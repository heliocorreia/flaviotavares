<?php get_header(); ?>

<?php the_post(); the_content(); ?>

<script>
head.ready('_jquery', function(){
	head.ready('_bxslider', function(){
		var resizeImage = function($el){
			var win_w = $w.width(),
				win_h = $w.height(),
				img_w_orig = $el.outerWidth(),
				img_h_orig = $el.outerHeight(),
				img_ratio = img_w_orig / img_h_orig,
				scale_h = win_w / img_w_orig,
				scale_v = win_h / img_h_orig,
				scale = scale_h > scale_v ? scale_h : scale_v;

			var dimensions = (img_h_orig * scale > win_h)
				? {width: win_w, height: 'auto'}
				: {width: 'auto', height: win_h};

			$el.css(dimensions);
		}

		var $w = $(window),
			$bxSlider,
			$gallery = $('.gallery')
			selectedBreakpoint = getBreakpointLabel();

		$gallery.find('a').each(function(i, el){
			var $el = $(el);

			$el
			.css('cursor', 'default')
			.click(function(e){ e.preventDefault(); })
			.find('img').each(function(){
				$(this)
				.load(function(){ resizeImage($(this)) })
				.attr('src', $el.data('href-' + selectedBreakpoint));
			});
		});

		$bxSlider = $gallery.bxSlider({
			captions: false,
			controls: false,
			randomStart: true,
			mode: 'horizontal',
			pager: false,
			onSlideAfter: function($slideElement, oldIndex, newIndex){
				$slideElement.find('img').each(function(){
					resizeImage($(this));
				});
			}
		});

		$w
		.resize(function(){
			$gallery.find('img').each(function(){
				resizeImage($(this));
			});
		})
		.trigger('resize');

		// $gallery.find('.bx-caption').each(function(i, el){
		// 	$el = $(el);
		// 	if (!$el.data('caption')) {
		// 		$el.find('span').append('.');
		// 		$el.append(' ' + $el.parent().find('img').attr('alt'));
		// 		$el.data('caption', true);
		// 	}
		// });

		$('#nav-main .nav-menu').prepend('<li id="nav-prev-next"><span class="prev"></span><span class="next"></span></li>');
		var $nav = $('#nav-prev-next');
		$('.prev', $nav).click(function() { $bxSlider.goToPrevSlide(); });
		$('.next', $nav).click(function() { $bxSlider.goToNextSlide(); });
	});
});
</script>

<?php get_footer(); ?>