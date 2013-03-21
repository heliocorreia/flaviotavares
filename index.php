<?php get_header(); ?>

<div id="galleria">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01a-full.jpg">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01b-full.jpg">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01c-full.jpg">
</div>

<script>

Galleria.loadTheme('<?php echo get_stylesheet_directory_uri(); ?>/media/js/galleria/themes/classic/galleria.classic.js');
Galleria.configure({
	carousel: false,
	imageCrop: true,
	showCounter: false,
	showImagenav: false,
    thumbnails: false,
});
Galleria.run('#galleria');
var oGallery = Galleria.get(0);


$('#nav-main .nav-menu').prepend('<li id="nav-prev-next"><span class="prev"></span><span class="next"></span></li>');
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