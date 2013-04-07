<?php get_header(); ?>

<div id="galleria">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01a-full.jpg">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01b-full.jpg">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01c-full.jpg">
</div>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/media/js/bxslider/jquery.bxslider.css">
<script src="<?php echo get_stylesheet_directory_uri(); ?>/media/js/bxslider/jquery.bxslider.min.js"></script>

<script>
$(document).ready(function(){
	$bxSlider = $('#galleria').bxSlider({
		controls: false,
		pager: false,
		randomStart: true
	});

	$('#nav-main .nav-menu').prepend('<li id="nav-prev-next"><span class="prev"></span><span class="next"></span></li>');
	var $nav = $('#nav-prev-next');

	$('.prev', $nav).click(function(){
		$bxSlider.goToPrevSlide();
	});

	$('.next', $nav).click(function(){
		$bxSlider.goToNextSlide();
	});
});
</script>

<?php get_footer(); ?>