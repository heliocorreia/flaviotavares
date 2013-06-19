<?php
/*
Template Name: Galeria (itens)
*/
?>
<?php get_header(); ?>
<div id="t-gallery-items">
	<div class="container">
		<section class="content">
			<?php the_post(); the_content(); ?>
		</section>
	</div>
</div>
<script>
"use strict";
head.ready('_jquery', function(){
	var $gallery = $('.gallery'),
		selectedBreakpoint = getBreakpointLabel();

	// update gallery items links and img src
	$gallery.find('a').each(function(i, el){
		var $el = $(el),
			$img = $el.find('img'),
			img_size = $img.data('size-' + selectedBreakpoint).split('x');

		$img.attr('src', $img.data('src-' + selectedBreakpoint)).css({
			'width': img_size[0],
			'height': img_size[1]
		});

		el.href = $el.data('href-' + selectedBreakpoint);
	});

	head.ready('_verticalcenter', function(){
		$('.sub-menu').responsiveVerticalCenter({attribute:'top',parentSelector:'body'});
		$('#t-gallery-items .content').responsiveVerticalCenter({parentSelector:'body'});

		head.ready('_tosros', function(){
			$gallery.find('a').each(function(i, el){
				var $el = $(el),
					title = $el.data('title') + '. ' + $el.data('caption');
				title = title.replace(/<br \/>\n*/g, ' ');
				$el.attr('title', title);
			}).tosrus({
				// desktop and touch
				caption: ['title'],
				anchors: {
					zoomIcon: false
				}
			}, {
				// desktop only
				keys: true,
				close: {
					key: true
				}
			});
		});
	});

	head.ready('_bxslider', function(){
		var btnPrev,
			btnNext,
			bxSlider = $gallery.first().bxSlider({
				controls: true,
				pager: false,
				slideWidth: 'auto'
			});

		btnPrev = function() {
			bxSlider.goToPrevSlide();
		}

		btnNext = function() {
			bxSlider.goToNextSlide();
		}

		$(window).keydown(function(event){
			var action = function(fn) {
				event.preventDefault();
				fn();
			};
			if (event.keyCode == 37) { action(btnPrev); }
			if (event.keyCode == 39) { action(btnNext); }
		});
	});
});
</script>
<?php get_footer(); ?>