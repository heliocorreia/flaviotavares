<?php get_header(); ?>

<?php the_post(); the_content(); ?>

<script>
head.ready('_jquery', function(){
head.ready('_picturefill', function(){
	head.ready('_bxslider', function(){
		var $w = $(window),
			$bxSlider,
			$bxViewPort,
			$gallery = $('.gallery'),
			resize = function() {
				resizeBxViewPort($bxViewPort);
				$gallery.find('img').each(function(){
					resizeImage($(this));
				});
			},
			resizeImage = function($el){
				var win_w = $w.width(),
					win_h = $w.height(),
					img_w_orig = $el.outerWidth(),
					img_h_orig = $el.outerHeight(),
					img_ratio = img_w_orig / img_h_orig,
					scale_h = win_w / img_w_orig,
					scale_v = win_h / img_h_orig,
					scale = scale_h > scale_v ? scale_h : scale_v;

				var dimensions = ((img_h_orig * scale) > win_h)
					? {width: win_w, height: 'auto'}
					: {width: 'auto', height: win_h};

				$el.css(dimensions);
			},
			resizeBxViewPort = function($el) {
				$el.css('height', $w.height() + 'px');
			};

		$gallery.bind('DOMNodeInserted', function(e) {
			if (e.target.tagName === 'IMG') {
				resizeImage($(e.target));
			}
		});

		$bxSlider = $gallery.bxSlider({
			auto: true,
			autoHover: true,
			captions: false,
			controls: true,
			easing: 'linear',
			mode: 'horizontal',
			pager: false,
			pause: 5000,
			randomStart: true,
			speed: 750
		});

		$bxViewPort = $bxSlider.parent('.bx-viewport');
		resizeBxViewPort($bxViewPort);

		$w
		.load(resize)
		.resize(resize)
		.keydown(function(event){
			var btnPrev = function() { $bxSlider.goToPrevSlide(); },
				btnNext = function() { $bxSlider.goToNextSlide(); },
				action = function(fn) {
				event.preventDefault();
				fn();
			};
			if (event.keyCode == 37) { action(btnPrev); }
			if (event.keyCode == 39) { action(btnNext); }
		});
	});
});
});
</script>

<?php get_footer(); ?>