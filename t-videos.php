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
			controls: false,
			infiniteLoop: false,
			pager: false,
			slideSelector: '.section',
			slideWidth: 'auto'
		});

		var btnPrev = function() {
			$bxSlider.goToPrevSlide();
		}
		
		var btnNext = function() {
			$bxSlider.goToNextSlide();
		}

		$('#nav-main .nav-menu').prepend('<li id="nav-prev-next"><span class="prev"></span><span class="next"></span></li>');
		var $nav = $('#nav-prev-next');
		$('.prev', $nav).click(btnPrev);
		$('.next', $nav).click(btnNext);

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
					keys: true,
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