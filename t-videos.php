<?php
/*
Template Name: Vídeo
*/
?>
<?php get_header(); ?>

<section id="t-videos">
	<div class="container">
		<div class="content">
			<div class="slides">
				<?php the_post(); the_content(); ?>
			</div>
		</div>
	</div>
</section>
<script>
head.ready('_jquery',function(){
	head.ready('_bxslider', function(){
		var $bxSlider = $('#t-videos .slides').bxSlider({
			controls: true,
			infiniteLoop: false,
			pager: false,
			slideSelector: '.section',
			slideWidth: 'auto'
		});

		head.ready('_verticalcenter', function(){
			$('html.gt-640 #t-videos .content').responsiveVerticalCenter({parentSelector:'body'});

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
					keys: true,
					close: {
						key: true
					},
					video: {
						maxWidth: 600
					}
				});
			});
		});
	});
});
</script>
<?php get_footer(); ?>