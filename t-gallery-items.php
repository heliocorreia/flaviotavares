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

<script src="<?php echo get_stylesheet_directory_uri(); ?>/media/js/touchswipe/jquery.touchSwipe.min.js"></script>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/media/js/swipebox/swipebox.css">
<script src="<?php echo get_stylesheet_directory_uri(); ?>/media/js/swipebox/jquery.swipebox.min.js"></script>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/media/js/bxslider/jquery.bxslider.css">
<script src="<?php echo get_stylesheet_directory_uri(); ?>/media/js/bxslider/jquery.bxslider.min.js"></script>

<script>
$('#nav-main').find('.current-menu-parent .sub-menu').prepend('<li id="nav-prev-next"><span class="prev"></span><span class="next"></span></li>');
$(document).ready(function(){
	$gallery = $('.gallery');

	$gallery.find('a').swipebox({
		useCSS : true, // false will force the use of jQuery for animations
		hideBarsDelay : 0 // 0 to always show caption and action bar
	});

	var aBxSlider = [];
	$gallery.each(function(i, el){
		bxSlider = $(el).bxSlider({
			controls: false,
			infiniteLoop: false,
			pager: false,
			slideWidth: 'auto'
		});

		aBxSlider.push(bxSlider);
	});

	var btnPrev = function() {
		aBxSlider.forEach(function(el){
			el.goToPrevSlide();
		})
	}

	var btnNext = function() {
		aBxSlider.forEach(function(el){
			el.goToNextSlide();
		})
	}

	var $nav = $('#nav-prev-next');
	$('.prev', $nav).click(btnPrev);
	$('.next', $nav).click(btnNext);

	// swipe
	$gallery.swipe({
		allowPageScroll: 'auto',
		triggerOnTouchEnd : true,
		swipeStatus : function swipeStatus(event, phase, direction, distance, fingers) {
			if (phase=='end' && (direction=='left' || direction=='right') ) {
				(direction=='left') && btnNext();
				(direction=='right') && btnPrev();
			}
		}
	});
});
</script>
<?php get_footer(); ?>