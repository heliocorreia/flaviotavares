<?php

// functions

function my_get_top_parent() {
	global $post;
	if ($post->post_parent)	{
		$id = end(get_post_ancestors($post->ID));
		return get_post($id);
	}
	return $post;
}

function my_top_parent_slug() {
	return my_get_top_parent()->post_name;
}

// theme setup

function flaviotavares_setup() {
	remove_action('wp_head', 'wp_generator');

	register_nav_menu('main', 'Main Menu');
	register_nav_menu('language', 'Language Menu');
	register_nav_menu('biography', 'Biography');

	if (function_exists('add_image_size')) {
		add_image_size('my-gallery-thumb', 410, 195, false);

		add_image_size('gallery-thumb-smart', 0, 100, false);
		add_image_size('gallery-thumb-tablet', 0, 200, false);
		add_image_size('gallery-thumb-desktop', 0, 300, false);

		add_image_size('smart', 480, 0, false); // 480x320
		add_image_size('tablet', 800, 0, false); // 800x600
		add_image_size('desktop', 1024, 0, false); // 1024x768
	}

	load_theme_textdomain('flaviotavares', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'flaviotavares_setup');

function is_my_print_scripts_disabled() {
	return (is_admin() or is_feed() or defined('XMLRPC_REQUEST'));
}

// actions

function my_enqueue_cssjs(){
	if (is_my_print_scripts_disabled()) {
		return;
	}

	$base = get_stylesheet_directory_uri();

	$styles = array(
		'_bxslider'				=> $base . '/media/js/bxslider/jquery.bxslider.css',
		// '_fontOvo' 				=> 'http://fonts.googleapis.com/css?family=Ovo',
		'_fontQuattrocentoSans' => 'http://fonts.googleapis.com/css?family=Quattrocento+Sans:400italic,700italic,700,400',
		'_tosros'				=> $base . '/media/js/tosros/jquery.tosrus.css',
	);

	foreach($styles as $k => $v) {
		wp_deregister_style($k);
		wp_register_style($k, $v);
	}

	$scripts = array(
		'_bxslider'			=> '/media/js/bxslider/jquery.bxslider.min.js',
		'_jquery'			=> '/media/js/jquery/2.0.0.js',
		'_tosros'			=> '/media/js/tosros/jquery.tosrus-1.3.1-packed.js',
		'_picturefill'		=> '/media/js/picturefill.js',
		'_verticalcenter'	=> '/media/js/jquery.responsive-vertical-center.js',
		'_hammer'			=> '/media/js/hammer/jquery.hammer.min.js',
	);

	foreach($scripts as $k => $v) {
		wp_deregister_script($k);
		wp_register_script($k, $base . $v);
	}

	wp_enqueue_script('_picturefill');
	wp_enqueue_script('_jquery');
	wp_enqueue_script('_verticalcenter');

	if (is_page_template('default')) {
		wp_dequeue_script('_verticalcenter');

		wp_enqueue_script('_bxslider');
	}

	if (is_page_template('t-biography.php')) {
		wp_dequeue_script('_verticalcenter');

		wp_enqueue_style('_fontOvo');

		wp_enqueue_style('_bxslider');
		wp_enqueue_script('_bxslider');
	}

	if (is_page_template('t-videos.php')) {
		wp_enqueue_style('_tosros');
		wp_enqueue_script('_tosros');

		wp_enqueue_style('_bxslider');
		wp_enqueue_script('_bxslider');
	}

	if (is_page_template('t-gallery-items.php')) {
		wp_enqueue_style('_tosros');
		wp_enqueue_script('_tosros');

		wp_enqueue_script('_hammer');

		wp_enqueue_style('_bxslider');
		wp_enqueue_script('_bxslider');
	}
}
add_action('wp_enqueue_scripts', 'my_enqueue_cssjs');

function my_print_scripts(){
	// http://github.com/beezee/wp_headjs
	global $wp_scripts;

	if (is_my_print_scripts_disabled() or empty($wp_scripts->queue)) {
		return;
	}

	if (!property_exists($wp_scripts, 'my_print_scripts')) {
		echo '<script src="' . get_stylesheet_directory_uri() . '/media/js/headjs/0.99.js"></script>';
		$wp_scripts->my_print_scripts = true;
	}

	$scripts = array();
	foreach($wp_scripts->queue as $script) {
		if (is_array($wp_scripts->registered[$script]->extra) and isset($wp_scripts->registered[$script]->extra['data'])) {
			echo '<script>' . $wp_scripts->registered[$script]->extra['data'] . '</script>';
		}
		$src = $wp_scripts->registered[$script]->src;
		$src = ( (preg_match('/^(http|https)\:\/\//', $src)) ? '' : get_bloginfo('url') ) . $src;
		$scripts[] = '{"' . $script . '":"' . $src . '"}';
	}

	echo '<script type="text/javascript">head.js('. implode(',', $scripts) . ');</script>';
	$wp_scripts->queue = array();
}
add_action('wp_print_scripts', 'my_print_scripts');

// filters

remove_filter('the_content', 'wpautop');
add_filter('the_content', 'wpautop' , 12);

function my_locale($locale) {
	$len = strlen(site_url('/', 'relative'));
	$lang = explode('/', substr($_SERVER['REQUEST_URI'], $len), 2);
	$lang = $lang[0];

	$source = array('en', 'pt_br');
	$target = array('en_US', 'pt_BR');

	$new = str_replace($source, $target, $lang);

	if ($new != $lang) {
		return $new;
	}

	return $locale;
}
add_filter('locale', 'my_locale', 10);

function my_wp_nav_menu_objects($items) {
	$parents = array();
	foreach ($items as $item) {
		if ($item->menu_item_parent && $item->menu_item_parent > 0) {
			$parents[] = $item->menu_item_parent;
		}
	}
	foreach ($items as $item) {
		$item->classes[] = 'slug-' . sanitize_title($item->title);
		if (in_array($item->ID, $parents)) {
			$item->classes[] = 'menu-has-submenu';
		}
	}
	return $items;
}
add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects');

function my_oembed_result($html, $url, $args) {
	return "<div class=\"oembed-result\">$html</div>";
}
add_filter('oembed_result','my_oembed_result', 10, 3);

function my_post_gallery($output, $attr) {
    global $post;

    static $instance = 0;
    $instance++;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'gallery-thumb-smart',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = $gallery_div = '';
    $size_class = sanitize_html_class( $size );
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
    $output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
		$class_oddeven = (++$i & 1) ? 'item-odd' : 'item-even';

		$link_href_smart = wp_get_attachment_image_src($id, 'smart', false);
		$link_href_tablet = wp_get_attachment_image_src($id, 'tablet', false);
		$link_href_desktop = wp_get_attachment_image_src($id, 'desktop', false);
		$link_href_original = wp_get_attachment_image_src($id, 'original', false);

		$img_src_smart = wp_get_attachment_image_src($id, 'gallery-thumb-smart', false);
		$img_src_tablet = wp_get_attachment_image_src($id, 'gallery-thumb-tablet', false);
		$img_src_desktop = wp_get_attachment_image_src($id, 'gallery-thumb-desktop', false);

		$attachment = get_post($id);

		$data_img_attr = array(
			'data-src-smart' => $img_src_smart[0],
			'data-src-tablet' => $img_src_tablet[0],
			'data-src-desktop' => $img_src_desktop[0],
			'data-src-original' => $img_src_desktop[0],
			// size: width x height
			'data-size-smart' => $img_src_smart[1] . 'x' . $img_src_smart[2],
			'data-size-tablet' => $img_src_tablet[1] . 'x' . $img_src_tablet[2],
			'data-size-desktop' => $img_src_desktop[1] . 'x' . $img_src_desktop[2],
			'data-size-original' => $img_src_desktop[1] . 'x' . $img_src_desktop[2],
			// extra attr
			'data-title' => __($attachment->post_title, 'flaviotavares'),
			'data-caption' => __($attachment->post_excerpt, 'flaviotavares'),
		);

		$data_link_attr = array(
			'data-href-smart' => $link_href_smart[0],
			'data-href-tablet' => $link_href_tablet[0],
			'data-href-desktop' => $link_href_desktop[0],
			'data-href-original' => $link_href_original[0],
			// extra attr
			'data-title' => __($attachment->post_title, 'flaviotavares'),
			'data-caption' => __($attachment->post_excerpt, 'flaviotavares'),
		);

		$media = "<img src=\"data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7\" alt=\"{$attachment->post_excerpt}\"";
		foreach($data_img_attr as $name => $value) {
			$media .= " $name=" . '"' . $value . '"';
		}
		$media .= ' />';

		if (!is_page_template('t-gallery-items.php')) {
			$media = <<<MEDIA
<span data-picture data-alt="${data_link_attr['data-title']}">
    <span data-src="${data_link_attr['data-href-smart']}"></span>
    <span data-src="${data_link_attr['data-href-tablet']}" data-media="(min-width: 600px)"></span>
    <span data-src="${data_link_attr['data-href-desktop']}" data-media="(min-width: 768px)"></span>
    <span data-src="${data_link_attr['data-href-original']}" data-media="(min-width: 1024px)"></span>
    <noscript>
        <img src="${data_link_attr['data-href-smart']}" alt="${data_link_attr['data-title']}" data-title="${data_link_attr['data-title']}" data-caption="${data_link_attr['data-caption']}" />
    </noscript>
</span>
MEDIA;
			$media = implode('', array_map('trim', explode("\n", $media)));
		}

		$href = isset($attr['link']) && 'file' == $attr['link']
			? get_attachment_link($id)
			: wp_get_attachment_url($id);

		$link = "<a href=\"$href\"";
		foreach($data_link_attr as $name => $value) {
		        $link .= " $name=" . '"' . $value . '"';
		}
		$link .= ">$media</a>";

        $output .= "<{$itemtag} class='gallery-item $class_oddeven'>";
        $output .= "<{$icontag} class='gallery-icon'>$link</{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "<{$captiontag} class='wp-caption-text gallery-caption'><span class='gallery-caption-outer'><span class='gallery-caption-inner'>"
					. wptexturize($attachment->post_title)
					. ".<br />\n"
					. wptexturize($attachment->post_excerpt)
					. "</span></{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
    }

    $output .= "</div>";

    return $output;
}
add_filter('post_gallery', 'my_post_gallery', 10, 2);

// shortcodes

function my_shortcode_wrapper($atts, $content = null) {
	$content = do_shortcode($content);
	return "<div class=\"section\">${content}</div>";
}

function my_add_shortcode(){
   add_shortcode('div', 'my_shortcode_wrapper');
}
add_action( 'init', 'my_add_shortcode');