<?php

function flaviotavares_setup() {
	remove_action('wp_head', 'wp_generator');

	register_nav_menu('main', 'Main Menu');
	register_nav_menu('language', 'Language Menu');
}
add_action( 'after_setup_theme', 'flaviotavares_setup' );
