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
		add_image_size('smart', 320, 0, false);
		add_image_size('tablet', 480, 0, false);
		add_image_size('desktop', 768, 0, false);
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
		'_bxslider'       		=> $base . '/media/js/bxslider/jquery.bxslider.css',
		'_fontOvo' 				=> 'http://fonts.googleapis.com/css?family=Ovo',
		'_fontQuattrocentoSans' => 'http://fonts.googleapis.com/css?family=Quattrocento+Sans:400italic,700italic,700,400',
		'_swipebox'				=> $base . '/media/js/swipebox/swipebox.css',

	);

	foreach($styles as $k => $v) {
		wp_deregister_style($k);
		wp_register_style($k, $v);
	}

	$scripts = array(
		'_jquery'         => '/media/js/jquery/2.0.0.js',
		'_verticalcenter' => '/media/js/jquery.responsive-vertical-center.js',
		'_swipebox'       => '/media/js/swipebox/jquery.swipebox.min.js',
		'_bxslider'       => '/media/js/bxslider/jquery.bxslider.min.js',
		'_touchswipe'	  => '/media/js/touchswipe/jquery.touchSwipe.min.js',
	);

	foreach($scripts as $k => $v) {
		wp_deregister_script($k);
		wp_register_script($k, $base . $v);
	}

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
		wp_enqueue_style('_swipebox');
		wp_enqueue_script('_swipebox');
	}

	if (is_page_template('t-gallery-items.php')) {
		wp_enqueue_script('_touchswipe');

		wp_enqueue_style('_swipebox');
		wp_enqueue_script('_swipebox');

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
        'size'       => 'my-gallery-thumb',
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

		$img_src_smart = wp_get_attachment_image_src($id, 'smart', false);
		$img_src_tablet = wp_get_attachment_image_src($id, 'tablet', false);
		$img_src_desktop = wp_get_attachment_image_src($id, 'desktop', false);
		$img_src_original = wp_get_attachment_image_src($id, 'original', false);

		$attachment = get_post($id);

		$data_attr = array(
			'data-smart' => $img_src_smart[0],
			'data-tablet' => $img_src_tablet[0],
			'data-desktop' => $img_src_desktop[0],
			'data-original' => $img_src_original[0],
			'title' => __($attachment->post_title, 'flaviotavares'),
			'data-caption' => __($attachment->post_excerpt, 'flaviotavares'),
		);

		$media = wp_get_attachment_image($id, $size, false, $data_attr);

		$href = isset($attr['link']) && 'file' == $attr['link']
			? get_attachment_link($id)
			: wp_get_attachment_url($id);

		$link = "<a href='$href'>$media</a>";

        $output .= "<{$itemtag} class='gallery-item $class_oddeven'>";
        $output .= "<{$icontag} class='gallery-icon'>$link</{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "<{$captiontag} class='wp-caption-text gallery-caption'><span class='gallery-caption-outer'><span class='gallery-caption-inner'>"
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