<?php get_header(); ?>

<?php the_post(); the_content(); ?>

<script>
head.ready('_jquery', function(){
	head.ready('_bxslider', function(){
		var calculateOffset = function(outer, inner) {
			return (inner > outer) ? (outer - inner) / 2 : 0;
		}

		var windowResize = function(){
			var w = $w.width(),
				h = $w.height();

			$gallery.find('.gallery-item').css('max-width', w);

			$gallery.find('img').each(function(i, el){
				var $el = $(el),
					el_w = $el.width(),
					el_h = $el.height();

				dimensions = ((w/h) > (el_w/el_h))
					? {width: w     , height: 'auto'}
					: {width: 'auto', height: h};

				$el.css(dimensions);
				// $el.css('margin-left', calculateOffset(w, el_w));
			});
		};

		var selectedBreakpoint = getBreakpointLabel();
		$('img').each(function(i, el){
			var $el = $(el).hide(),
				data = $el.data(selectedBreakpoint);
			if (data && el.src != data) {
				el.src = data;
				$el.css({ height: 'auto', width: 'auto' }).show();
			}
		});

		var $w = $(window),
			$bxSlider,
			$gallery = $('.gallery');

		$bxSlider = $gallery.bxSlider({
				captions: true,
				controls: false,
				pager: false,
				preloadImages: 'all',
				slideWidth: 'auto',
			});

		$w.resize(windowResize).trigger('resize');

		$gallery.find('a')
			.css('cursor', 'default')
			.click(function(e){ e.preventDefault(); });

		$gallery.find('.bx-caption').each(function(i, el){
			$el = $(el);
			if (!$el.data('caption')) {
				$el.find('span').append('.');
				$el.append(' ' + $el.parent().find('img').attr('alt'));
				$el.data('caption', true);
			}
		});

		$('#nav-main .nav-menu').prepend('<li id="nav-prev-next"><span class="prev"></span><span class="next"></span></li>');
		var $nav = $('#nav-prev-next');
		$('.prev', $nav).click(function() { $bxSlider.goToPrevSlide(); });
		$('.next', $nav).click(function() { $bxSlider.goToNextSlide(); });
	});
});
</script>

<?php get_footer(); ?>