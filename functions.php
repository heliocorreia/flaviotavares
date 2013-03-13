<?php

function flaviotavares_setup() {
	remove_action('wp_head', 'wp_generator');

	register_nav_menu('main', 'Main Menu');
	register_nav_menu('language', 'Language Menu');
}
add_action('after_setup_theme', 'flaviotavares_setup');


function add_menu_title_slug_class($items) {
	foreach ($items as $item) {
		$item->classes[] = 'slug-' . sanitize_title($item->title);
	}
	return $items;    
}
add_filter('wp_nav_menu_objects', 'add_menu_title_slug_class');
