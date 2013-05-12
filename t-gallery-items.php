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

	// update gallery items links and img src
	var selectedBreakpoint = getBreakpointLabel();
	$gallery.find('a').each(function(i, el){
		var $el = $(el),
			$img = $el.find('img'),
			data_el = $el.data('href-' + selectedBreakpoint),
			data_img = $img.data('src-' + selectedBreakpoint);

		el.href = data_el;

		img_size = $img.data('size-' + selectedBreakpoint);
		img_size = img_size.split('x');

		$img.attr('src', data_img).css({
			'width': img_size[0],
			'height': img_size[1]
		});
	});

	head.ready('_verticalcenter', function(){
		$('.sub-menu').responsiveVerticalCenter({attribute:'top',parentSelector:'body'});
		$('#t-gallery-items .content').responsiveVerticalCenter({parentSelector:'body'});

		head.ready('_tosros', function(){
			$gallery.find('a').tosrus({
				// desktop and touch
				caption: true,
				anchors: {
					zoomIcon: false
				}
			});
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