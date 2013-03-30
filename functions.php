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

// theme setup

function flaviotavares_setup() {
	remove_action('wp_head', 'wp_generator');

	register_nav_menu('main', 'Main Menu');
	register_nav_menu('language', 'Language Menu');

	if (function_exists('add_image_size')) {
		add_image_size( 'my-gallery-thumb', 263, 263, false);
	}
}
add_action('after_setup_theme', 'flaviotavares_setup');

// filters

remove_filter('the_content', 'wpautop');
add_filter('the_content', 'wpautop' , 12);

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
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "<{$icontag} class='gallery-icon'>$link</{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "<{$captiontag} class='wp-caption-text gallery-caption'>"
					. wptexturize($attachment->post_excerpt)
					. "</{$captiontag}>";
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