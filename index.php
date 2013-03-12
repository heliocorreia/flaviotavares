<?php get_header(); ?>

<div id="galleria">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01a-full.jpg">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01b-full.jpg">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-01c-full.jpg">
</div>

<style>
    #galleria{ margin: 0 auto; width: 700px; height: 400px; background: #000 }
</style>

<script>
Galleria.loadTheme('<?php echo get_stylesheet_directory_uri(); ?>/media/js/galleria/themes/classic/galleria.classic.min.js');
Galleria.run('#galleria');
</script>

<?php get_footer(); ?>