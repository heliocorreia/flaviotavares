<?php get_header(); ?>
	<section class="content">
		<nav id="nav-lang">
			<?php wp_nav_menu(array(
				'theme_location' => 'language',
				'container' => false,
				'menu_class' => 'nav-menu',
				'depth' => 1,
				'link_before' => '<span>',
				'link_after' => '</span>',
			)); ?>
		</nav>
	</section>
<?php get_footer(); ?>