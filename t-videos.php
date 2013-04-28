<?php
/*
Template Name: Vídeo
*/
?>
<?php get_header(); ?>
<script>
head.ready(function(){
	$('#t-videos .content').responsiveVerticalCenter({ parentSelector:'body' });

	$('#nav-main').find('.current-menu-parent .sub-menu').prepend('<li id="nav-prev-next"><span class="prev"></span><span class="next"></span></li>');

	$('#t-videos').find('.section a').swipebox({
		useCSS : true, // false will force the use of jQuery for animations
		hideBarsDelay : 0 // 0 to always show caption and action bar
	});
});
</script>
<section id="t-videos">
	<div class="container">
		<div class="content">
			<?php the_post(); the_content(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>