<?php
/*
Template Name: Vídeo
*/
?>
<?php get_header(); ?>

<section id="t-videos">
	<div class="container">
		<div class="content">
			<?php the_post(); the_content(); ?>
		</div>
	</div>
</section>
<script>
head.ready('_jquery',function(){
	head.ready('_verticalcenter', function(){
		$('#t-videos .content').responsiveVerticalCenter({parentSelector:'body'});

		head.ready('_tosros', function(){
			$('#t-videos').find('.section a').tosrus({
				// desktop and touch
				caption: false,
				anchors: {
					zoomIcon: false
				},
				video: {
					ratio: 16/9
				}
			}, {
				// desktop only
				video: {
					maxWidth: 600
				}
			});
		});
	});

});
</script>
<?php get_footer(); ?>