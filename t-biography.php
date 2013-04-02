<?php
/*
Template Name: Biografia
*/
?>
<?php get_header(); the_post(); ?>
<section id="t-biography">
	<div class="container">
		<header class="content-header">
			<h1 class="main-title"><?php the_title(); ?></h1>
			<blockquote class="by-author">
				<p>Esse mundo da imagem me persegue e eu o persigo.</p>
				<p><span>Flávio Tavares</span></p>
			</blockquote>
			<footer>
				<section class="slides">
					<figure>
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-slides.jpg" height="441" width="735">
						<figcaption>O artista com seu quadro, A Pedra do Reino, 1981.</figcaption>
					</figure>
				</section>
				<blockquote class="by-others">
					<p><span class="block-1">Apesar de sua singular matriz, a busca de Flávio Tavares</span> <span class="block-2">é a de um imaginário arquetípico em que o sacro dialoga</span> <span class="block-3">com o profano e onde a afirmação da vida sempre</span> <span class="block-4">se sobrepõe ao pessimismo e ao culto da morte, tão</span> <span class="block-5">presentes na arte conteporânea.</span></p>
					<footer><span>Gabriel Bechara</span>, Professor de Estética e História da Arte da Universidade Federal da Paraíba, 2005</footer>
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
							<dd class="title">A semente</dd>
							<dd class="specs">Acrílico sobre tela 1,60 x 1,40 cm</dd>
							<dd class="year">2006</dd>
						</dl>
					</li>
					<li>
						<figure data-index="2" class="img-2">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-work-2.jpg" height="205" width="288">
						</figure>
						<dl>
							<dd class="title">Sem título</dd>
							<dd class="specs">Pastel 83 x 93 cm</dd>
							<dd class="year">1968</dd>
						</dl>
					</li>
					<li>
						<figure data-index="3" class="img-3">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-work-3.jpg" height="205" width="410">
						</figure>
						<dl>
							<dd class="title">Sem título</dd>
							<dd class="specs">Óleo sobre tela 80 x 70 cm</dd>
							<dd class="year">1989</dd>
						</dl>
					</li>
					<li>
						<figure data-index="4" class="img-4">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-work-4.jpg" height="312" width="198">
						</figure>
						<dl>
							<dd class="title">Sem título</dd>
							<dd class="specs">Pastel 83 x 93 cm</dd>
							<dd class="year">1968</dd>
						</dl>
					</li>
				</ol>
			</aside>
		</article>
	</div>
</section>
<?php get_footer(); ?>