<?php
/*
Template Name: Galeria
*/
?>
<?php get_header(); ?>
<div id="t-gallery">
	<div class="container">
		<section class="content">
			<h1 class="main-title"><?php the_title(); ?></h1>
		</section>
	</div>
</div>

<script>
// submenu
$('.sub-menu').responsiveVerticalCenter({attribute:'top',parentSelector:'body'});
</script>
<?php get_footer(); ?>