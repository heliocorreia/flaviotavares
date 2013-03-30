<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/media/compiled/css/flaviotavares.css" />
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--
	<link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400italic,700italic,700,400' rel='stylesheet' type='text/css'>
	-->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/media/js/jquery-1.9.1.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/media/js/galleria/galleria-1.2.9.min.js"></script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="doc">
	<?php if (!is_home()): ?>
	<header id="header">
		<div class="container">
			<nav id="nav-language">
				<?php wp_nav_menu(array(
					'theme_location' => 'language',
					'container' => false,
					'menu_class' => 'nav-menu',
					'depth' => 1,
				)); ?>
			</nav>
			<nav id="nav-main">
				<?php wp_nav_menu(array(
					'menu' => 'main-' . my_get_top_parent()->post_name,
					'theme_location' => 'main',
					'container' => 'div',
					'menu_class' => 'nav-menu',
					'depth' => 2,
				)); ?>
			</nav>
		</div>
	</header>
	<?php endif; ?>
