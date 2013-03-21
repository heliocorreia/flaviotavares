<?php
/*
Template Name: [en] Videos
*/
?>
<?php get_header(); ?>
<section id="t-videos">
	<div class="container">
		<section class="outter">
			<section class="inner">
				<?php the_post(); the_content(); ?>
			</section>
		</section>
	</div>
</section>
<?php get_footer(); ?>