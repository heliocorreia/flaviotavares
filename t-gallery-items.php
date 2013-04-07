<?php
/*
Template Name: Galeria (itens)
*/
?>
<?php get_header(); ?>
<div id="t-gallery-items">
	<div class="container">
		<section class="content">
			<div class="content-outer">
				<div class="content-inner">
					<?php the_post(); the_content(); ?>
				</div>
			</div>
		</section>
	</div>
</div>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/media/js/swipebox/swipebox.css">
<script src="<?php echo get_stylesheet_directory_uri(); ?>/media/js/swipebox/jquery.swipebox.min.js"></script>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/media/js/bxslider/jquery.bxslider.css">
<script src="<?php echo get_stylesheet_directory_uri(); ?>/media/js/bxslider/jquery.bxslider.min.js"></script>

<script>
$(document).ready(function(){
	$gallery = $('.gallery');

	$gallery.find('a').swipebox({
		useCSS : true, // false will force the use of jQuery for animations
		hideBarsDelay : 0 // 0 to always show caption and action bar
	});

	$gallery.bxSlider({
		pager: false,
		slideWidth: 'auto',
		infiniteLoop: false
	});
});
</script>
<?php get_footer(); ?>