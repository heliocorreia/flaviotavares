<?php

function flaviotavares_setup() {
	remove_action('wp_head', 'wp_generator');

	register_nav_menu('main', 'Main Menu');
}
add_action( 'after_setup_theme', 'flaviotavares_setup' );
