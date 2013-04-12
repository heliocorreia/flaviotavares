<?php
/*
Template Name: [en] Videos
*/
?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/media/js/swipebox/swipebox.css">
<script src="<?php echo get_stylesheet_directory_uri(); ?>/media/js/swipebox/jquery.swipebox.min.js"></script>
<section id="t-videos">
	<div class="container">
		<section class="outter">
			<section class="inner">
				<?php the_post(); the_content(); ?>
			</section>
		</section>
	</div>
</section>
<script>
$('#nav-main').find('.current-menu-parent .sub-menu').prepend('<li id="nav-prev-next"><span class="prev"></span><span class="next"></span></li>');
$(document).ready(function(){
	$gallery = ;

	$('#t-videos').find('.section a').swipebox({
		useCSS : true, // false will force the use of jQuery for animations
		hideBarsDelay : 0 // 0 to always show caption and action bar
	});
});
</script>
<?php get_footer(); ?>