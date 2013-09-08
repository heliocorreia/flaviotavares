<?php
$top_page_slug = my_top_parent_slug();
?><!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/media/compiled/css/flaviotavares.css" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<script>
	function getBreakpointLabel() {
		var win_w = $(window).width(),
			labels = ['smart', 'tablet', 'tablet', 'desktop', 'original'],
			breakpoints = [320, 600, 768, 1024, 1025],
			length = breakpoints.length,
			selected = breakpoints[0];

		for (i=0; i<length; i++) {
			if (breakpoints[i] < win_w) {
				selected = labels[i];
			}
		}

		return selected;
	}
	</script>
</head>
<body <?php body_class('top-page-slug-' . $top_page_slug); ?>>
<div id="doc">
	<?php if (!is_home()): ?>
	<header id="header">
		<label for="nav-main-button" onclick></label>
		<input type="checkbox" id="nav-main-button">
		<div class="container">
			<nav id="nav-main">
				<?php wp_nav_menu(array(
					'menu' => 'main-' . $top_page_slug,
					'theme_location' => 'main',
					'container' => 'div',
					'menu_class' => 'nav-menu',
					'depth' => 2,
				)); ?>
			</nav>
			<nav id="nav-language">
				<?php wp_nav_menu(array(
					'theme_location' => 'language',
					'container' => false,
					'menu_class' => 'nav-menu',
					'depth' => 1,
				)); ?>
			</nav>
		</div>
	</header>
	<?php endif; ?>
