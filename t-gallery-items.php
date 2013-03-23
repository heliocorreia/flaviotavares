<?php
/*
Template Name: [en] Gallery Items
*/
?>
<?php get_header(); ?>
<div id="t-gallery-items">
	<div class="container">
		<section class="content">
			<div class="content-outer">
				<div class="content-inner">
					<?php the_post(); the_content(); ?>
				</div>
			</div>
		</section>
	</div>
</div>
<?php get_footer(); ?>