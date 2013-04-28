<?php get_header(); ?>

<?php the_post(); the_content(); ?>

<script>
head.ready('_jquery', function(){
	var selectedBreakpoint = getBreakpointLabel();
	$('img').each(function(i, el){
		var data = $(el).data(selectedBreakpoint);
		if (data && el.src != data) {
			el.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';
			el.src = data;
		}
	});

	head.ready('_bxslider', function(){
		function calculateHOffset(outer, inner) {
			return (inner > outer) ? (outer - inner) / 2 : 0;
		}

		var $w = $(window),
			$bxSlider,
			$gallery = $('.gallery');

		var windowResize = function(){
			var w = $w.width(),
				h = $w.height();

			$gallery.find('img').each(function(i, el){
				$el = $(el);
				dimensions = ((w/h) > ($el.width()/$el.height()))
					? {width: w     , height: 'auto'}
					: {width: 'auto', height: h};
				
				$el.css(dimensions);
				$el.css({marginLeft: calculateHOffset(w, $el.width())});
			});
			
			$bxSlider && $bxSlider.reloadSlider();
		};

		$w.resize(windowResize).trigger('resize');
		$gallery.find('a').click(function(e){ e.preventDefault(); });
		
		$bxSlider = $gallery.bxSlider({
			slideWidth: 'auto',
			captions: true,
			controls: false,
			pager: false
		});

		$gallery.find('.bx-caption').each(function(i, el){
			$el = $(el);
			$el.find('span').append('.');
			$el.append(' ' + $el.parent().find('img').attr('alt'));
		});
		
		$('#nav-main .nav-menu').prepend('<li id="nav-prev-next"><span class="prev"></span><span class="next"></span></li>');
		var $nav = $('#nav-prev-next');
		$('.prev', $nav).click(function() { $bxSlider.goToPrevSlide(); });
		$('.next', $nav).click(function() { $bxSlider.goToNextSlide(); });
	});
});
</script>

<?php get_footer(); ?>