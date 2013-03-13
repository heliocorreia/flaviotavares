<?php get_header(); ?>

<div id="galleria">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01a-full.jpg">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01b-full.jpg">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01c-full.jpg">
</div>

<script>

Galleria.loadTheme('<?php echo get_stylesheet_directory_uri(); ?>/media/js/galleria/themes/classic/galleria.classic.min.js');
Galleria.run('#galleria');
var oGallery = Galleria.get(0);


$('#nav-main').prepend('<div id="nav-prev-next"><span class="prev"></span><span class="next"></span></div>');
var $nav = $('#nav-prev-next');

$('.prev', $nav).click(function(){
	console.log('prev');
	oGallery.prev();
});
$('.next', $nav).click(function(){
	console.log('next');
	oGallery.next();
});

</script>

<?php get_footer(); ?>