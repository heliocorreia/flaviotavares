<?php
/*
Template Name: Galeria (itens)
*/
?>
<?php get_header(); ?>
<script>
head.ready('_jquery', function(){
	var btnPrev = btnNext = function(){}

	$('#nav-main').find('.current-menu-parent .sub-menu').prepend('<li id="nav-prev-next"><span class="prev"></span><span class="next"></span></li>');
	$gallery = $('.gallery');

	head.ready('_verticalcenter', function(){
		$('.sub-menu').responsiveVerticalCenter({attribute:'top',parentSelector:'body'});
		$('#t-gallery-items .content').responsiveVerticalCenter({parentSelector:'body'});
	});

	head.ready('_swipebox', function(){
		$gallery.find('a').swipebox({
			useCSS : true,
			hideBarsDelay : 3000
		});
	});

	head.ready('_bxslider', function(){
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

		btnPrev = function() {
			aBxSlider.forEach(function(el){ el.goToPrevSlide(); })
		}

		btnNext = function() {
			aBxSlider.forEach(function(el){ el.goToNextSlide(); })
		}

		var $nav = $('#nav-prev-next');
		$('.prev', $nav).click(btnPrev);
		$('.next', $nav).click(btnNext);
	});

	head.ready('_touchswipe', function(){
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
});
</script>

<div id="t-gallery-items">
	<div class="container">
		<section class="content">
			<?php the_post(); the_content(); ?>
		</section>
	</div>
</div>
<?php get_footer(); ?>