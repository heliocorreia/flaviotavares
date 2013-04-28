<?php
/*
Template Name: Vídeo
*/
?>
<?php get_header(); ?>
<script>
head.ready('_jquery',function(){
	head.ready('_verticalcenter', function(){
		$('#t-videos .content').responsiveVerticalCenter({parentSelector:'body'});
	});

	head.ready('_swipebox', function(){
		console.log('_swipebox');
		$('#t-videos').find('.section a').swipebox({
			useCSS: true,
			hideBarsDelay: 0
		});
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