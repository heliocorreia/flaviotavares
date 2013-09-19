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
			<?php the_post(); the_content(); ?>
		</section>
	</div>
</div>
<script>
head.ready('_verticalcenter', function(){
	var $content = $('#t-gallery').find('.content');
	if ($('html').hasClass('gt-640')) {
		$content.responsiveVerticalCenter({parentSelector:'body'});
	}
	$content.find('a').each(function(){
		var $that = $(this);
		$that.attr('rel', $that.find('img').first().attr('alt'));
	});
});
</script>
<?php get_footer(); ?>