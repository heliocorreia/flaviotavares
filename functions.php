<?php

// theme setup

function flaviotavares_setup() {
	remove_action('wp_head', 'wp_generator');

	register_nav_menu('main', 'Main Menu');
	register_nav_menu('language', 'Language Menu');
}
add_action('after_setup_theme', 'flaviotavares_setup');

// filters

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);

function my_wp_nav_menu_objects($items) {
	foreach ($items as $item) {
		$item->classes[] = 'slug-' . sanitize_title($item->title);
	}
	return $items;    
}
add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects');

function my_oembed_result($html, $url, $args) {
	return "<div class=\"oembed-result\">$html</div>";
}
add_filter('oembed_result','my_oembed_result', 10, 3);

// shortcodes

function my_shortcode_wrapper($atts, $content = null) {
	$content = do_shortcode($content);
	return "<div class=\"section\">${content}</div>";
}

function my_add_shortcode(){
   add_shortcode('div', 'my_shortcode_wrapper');
}
add_action( 'init', 'my_add_shortcode');