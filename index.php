<?php get_header(); ?>

<div id="gallery"></div>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/media/js/touchswipe/jquery.touchSwipe.min.js"></script>

<script>
(function($) {
	var $w = $(window),
		$current = $('<img />'),
		$new = $(),
		step = 0,
		bgList = {
			'1024': [
				'<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01a-full.jpg',
				'<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01b-full.jpg',
				'<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01c-full.jpg',
			],
		};

	var backgrounds = bgList['1024'];






	var bgResize = function(){
		var win_w = $w.width(),
		win_h = $w.height();

		// Load narrowest background image based on
		// viewport width, but never load anything narrower
		// that what's already loaded if anything.
		var available = [
		1024//, 1280, 1366, 1400, 1680, 1920, 2560, 3840, 4860
		];

		// if (!current || ((current < win_w) && (current < available[available.length - 1]))) {
			var chosen = available[available.length - 1];
			for (var i=0; i<available.length; i++) {
				if (available[i] >= win_w) {
					chosen = available[i];
					break;
				}
			}
		// }

		hoff =  - horizontalOffset(win_w, $current.width());

		// stretch x or y?
		dimensions = ((win_w / win_h) < ($current.width() / $current.height()))
			? {height: '100%', width: 'auto', marginLeft: hoff}
			: {width: '100%', height: 'auto', marginLeft: hoff};

		$new.css(dimensions);
		$current.css(dimensions);
	};
	$w.resize(bgResize);

	var stepIt = function(forward) {
		var speed = 250,
			win_w = $w.width();

		if (forward) {
			width = $current.width();
			offset = horizontalOffset(win_w, $current.width());

			$new.attr('src', backgrounds[step]).css({'left': width, 'margin-left': -offset});
			$new.show().animate({'left': 0}, speed);
			$current.animate({'left': -width}, {
				duration: speed,
				complete: function(){
					$current.attr('src', $new.attr('src'));
					$current.css({'left': 0 });
					$new.hide();
				}
			});

		} else {
			// backward
			width = $new.width();
			offset = horizontalOffset(win_w, $current.width());

			$new.attr('src', backgrounds[step]).css({'left': -width, 'margin-left': -offset });
			$new.show().animate({'left': 0}, speed);
			$current.animate({'left': width}, {
				duration: speed,
				complete: function(){
					$current.attr('src', $new.attr('src'));
					$current.css({'left': 0 });
					$new.hide();
				}
			});
		}
	}

	var stepBy = function(i){
		step += i;

		if (step < 0) {
			step = backgrounds.length - 1;
		}
		if (step >= backgrounds.length || !backgrounds[step - 1] ) {
			step = 0;
		}

		stepIt((i > 0));
	}

	var stepPrev = function(){ stepBy(-1); }

	var stepNext = function(){ stepBy(1); }

	var horizontalOffset = function(win_w, img_w) {
		offset = win_w - $current.width();
		return (offset < 0) ? Math.abs(offset / 2) : 0;
	}

	$current.css({
		'left': '0px',
		'position': 'fixed',
		'top': '0px'
    })
	.prependTo('body')
	.attr('src', backgrounds[step])
	.bind('load', function(){
		bgResize();
	});

	$new = $current.clone();
	$new.hide().insertAfter($current);

	var preload = function(backgrounds) {
        var cache = [];
        for (var i in backgrounds) {
            var cacheImage = document.createElement('img');
            cacheImage.src = backgrounds[i];
            cache.push(cacheImage);
        }
    }
	preload(backgrounds);

	$(function() {
		$('#nav-main .nav-menu').prepend('<li id="nav-prev-next"><span class="prev"></span><span class="next"></span></li>');
		var $nav = $('#nav-prev-next');
		$('.prev', $nav).click(stepPrev);
		$('.next', $nav).click(stepNext);

		bgResize();

		// add swipe
		$current.swipe({
			allowPageScroll: 'auto',
			triggerOnTouchEnd : true,
			swipeStatus : function swipeStatus(event, phase, direction, distance, fingers) {
				if (phase=='end' && (direction=='left' || direction=='right') ) {
					(direction=='left') && stepNext();
					(direction=='right') && stepPrev();
				}
			}
		});
	});
})(jQuery);
</script>

<?php get_footer(); ?>