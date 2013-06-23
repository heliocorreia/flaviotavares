<?php
/*
Template Name: Biografia
*/
?>
<?php get_header(); the_post(); ?>

<script>
head.ready(function(){
	$('.slides .slides-inner').bxSlider({
		auto: true,
		controls: false,
		infiniteLoop: true,
		pager: true
	});
});
</script>

<section id="t-biography">
	<div class="container">
		<header class="content-header">
			<h1 class="main-title"><?php the_title(); ?></h1>
			<blockquote class="by-author">
				<p><?php _e('Esse mundo da imagem me persegue e eu o persigo.', 'flaviotavares'); ?></p>
				<p><span><?php _e('Flávio Tavares', 'flaviotavares'); ?></span></p>
			</blockquote>
			<footer>
				<section class="slides">
					<div class="slides-inner">
					<?php $slides = array(
						array('img' => '/media/img/img-biography-author-1.jpg', 'caption' => 'O artista com seu quadro, A Pedra do Reino, 1981.'),
						array('img' => '/media/img/img-biography-author-2.jpg', 'caption' => 'O artista com seu quadro, A Pedra do Reino, 1981.'),
						array('img' => '/media/img/img-biography-author-3.jpg', 'caption' => 'O artista com seu quadro, A Pedra do Reino, 1981.'),
					);
					foreach($slides as $slide): ?>
						<figure>
							<img src="<?php echo get_stylesheet_directory_uri() . $slide['img']; ?>" width="735" height="441">
							<figcaption><?php _e($slide['caption'], 'flaviotavares'); ?></figcaption>
						</figure>
					<?php endforeach; ?>
					</div>
				</section>
				<blockquote class="by-others">
					<p><span class="block-1"><?php _e('Apesar de sua singular matriz, a busca de Flávio Tavares', 'flaviotavares'); ?></span> <span class="block-2"><?php _e('é a de um imaginário arquetípico em que o sacro dialoga', 'flaviotavares'); ?></span> <span class="block-3"><?php _e('com o profano e onde a afirmação da vida sempre', 'flaviotavares'); ?></span> <span class="block-4"><?php _e('se sobrepõe ao pessimismo e ao culto da morte, tão', 'flaviotavares'); ?></span> <span class="block-5"><?php _e('presentes na arte conteporânea.', 'flaviotavares'); ?></span></p>
					<footer><span><?php _e('Gabriel Bechara', 'flaviotavares'); ?></span>, <?php _e('Professor de Estética e História da Arte da Universidade Federal da Paraíba, 2005', 'flaviotavares'); ?></footer>
				</blockquote>
			</footer>
		</header>
		<article class="content-body">
			<section class="content">
				<?php the_content(); ?>
			</section>
			<aside class="sidebar">
				<ol>
					<li>
						<figure data-index="1" class="img-1">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-work-1.jpg" height="205" width="300">
						</figure>
						<dl>
							<dd class="title"><?php _e('A semente', 'flaviotavares'); ?></dd>
							<dd class="specs"><?php _e('Acrílico sobre tela 1,60 x 1,40 cm', 'flaviotavares'); ?></dd>
							<dd class="year">2006</dd>
						</dl>
					</li>
					<li>
						<figure data-index="2" class="img-2">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-work-2.jpg" height="205" width="288">
						</figure>
						<dl>
							<dd class="title"><?php _e('Sem título', 'flaviotavares'); ?></dd>
							<dd class="specs"><?php _e('Pastel 83 x 93 cm', 'flaviotavares'); ?></dd>
							<dd class="year">1968</dd>
						</dl>
					</li>
					<li>
						<figure data-index="3" class="img-3">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-work-3.jpg" height="205" width="410">
						</figure>
						<dl>
							<dd class="title"><?php _e('Sem título', 'flaviotavares'); ?></dd>
							<dd class="specs"><?php _e('Óleo sobre tela 80 x 70 cm', 'flaviotavares'); ?></dd>
							<dd class="year">1989</dd>
						</dl>
					</li>
					<li>
						<figure data-index="4" class="img-4">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-work-4.jpg" height="312" width="198">
						</figure>
						<dl>
							<dd class="title"><?php _e('Sem título', 'flaviotavares'); ?></dd>
							<dd class="specs"><?php _e('Pastel 83 x 93 cm', 'flaviotavares'); ?></dd>
							<dd class="year">1968</dd>
						</dl>
					</li>
				</ol>
				<nav id="nav-biography">
					<?php wp_nav_menu(array(
						'menu' => 'biography-' . my_top_parent_slug(),
						'theme_location' => 'biography',
						'container' => 'div',
						'menu_class' => 'nav-biography',
						'depth' => 2,
					)); ?>
				</nav>
			</aside>
		</article>
	</div>
</section>
<?php get_footer(); ?>