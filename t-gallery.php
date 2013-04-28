<?php
/*
Template Name: Galeria
*/
?>
<?php get_header(); ?>
<script>
head.ready(function(){
	$('.sub-menu').responsiveVerticalCenter({attribute:'top',parentSelector:'body'});
});
</script>
<div id="t-gallery">
	<div class="container">
		<section class="content">
			<h1 class="main-title"><?php the_title(); ?></h1>
		</section>
	</div>
</div>
<?php get_footer(); ?>