<?php
/*
Template Name: Biografia
*/
?>
<?php get_header(); the_post(); ?>

<script>
head.ready(function(){
	$('.header-slides .header-slides-inner').bxSlider({
		auto: true,
		controls: false,
		infiniteLoop: true,
		pager: true
	});
});
</script>

<section id="t-biography">
	<header class="header">
		<section class="header-container">
			<section class="header-content">
				<h1 class="header-title"><?php the_title(); ?></h1>
				<blockquote class="quote-by-author">
					<p><?php _e('Esse mundo da imagem me persegue e eu o persigo.', 'flaviotavares'); ?></p>
					<p><span><?php _e('Flávio Tavares', 'flaviotavares'); ?></span></p>
				</blockquote>
			</section>
			<section class="header-slides">
				<div class="header-slides-inner">
				<?php $slides = array(
					array('img' => '/media/img/img-biography-author-1.jpg', 'caption' => 'O artista com seu quadro, A Pedra do Reino, 1981.'),
					array('img' => '/media/img/img-biography-author-3.jpg', 'caption' => 'O artista com seu quadro, A Pedra do Reino, 1981.'),
					array('img' => '/media/img/img-biography-author-4.jpg', 'caption' => 'O artista em seu ateliê com o jornalista Gonzaga Rodrigues.'),
					array('img' => '/media/img/img-biography-author-5.jpg', 'caption' => 'Flávio tavares, 2013 - Foto: wscom'),
				);
				foreach($slides as $slide): ?>
					<figure>
						<img src="<?php echo get_stylesheet_directory_uri() . $slide['img']; ?>" width="735" height="441">
						<figcaption><?php _e($slide['caption'], 'flaviotavares'); ?></figcaption>
					</figure>
				<?php endforeach; ?>
				</div>
			</section>
			<blockquote class="quote-by-others">
				<p><?php _e('Em três décadas impressionou-me a constante evolução desse artista e a sua capacidade de aprofundar os seus temas básicos e o refinamento dos instrumentos. Certamente, hoje, Flávio Tavares está entre os mais importantes artistas do Nordeste e tem uma posição respeitável entre os artistas brasileiros figurativos de sua geração.', 'flaviotavares'); ?></p>
				<footer class="hcard"><span class="fn n"><?php _e('Jacob Klintowitz', 'flaviotavares'); ?></span>, <span class="role"><?php _e('Crítico de arte', 'flaviotavares'); ?></span></footer>
			</blockquote>
		</section>
	</header>

	<article class="content">
		<section class="content-container">
			<section class="content-main">
				<?php the_content(); ?>
				<aside class="content-main-aside">
					<ol class="works">
						<li class="work-item" data-index="1">
							<figure data-index="1" class="work-figure work-figure-1">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-work-1.jpg" height="205" width="300">
							</figure>
							<dl>
								<dd class="work-title"><?php _e('A semente', 'flaviotavares'); ?></dd>
								<dd class="work-specs"><?php _e('Acrílico sobre tela 1,60 x 1,40 cm', 'flaviotavares'); ?></dd>
								<dd class="work-year">2006</dd>
							</dl>
						</li>
						<li class="work-item" data-index="2">
							<figure data-index="2" class="work-figure work-figure-2">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-work-2.jpg" height="205" width="288">
							</figure>
							<dl>
								<dd class="work-title"><?php _e('Sem título', 'flaviotavares'); ?></dd>
								<dd class="work-specs"><?php _e('Pastel 83 x 93 cm', 'flaviotavares'); ?></dd>
								<dd class="work-year">1968</dd>
							</dl>
						</li>
						<li class="work-item" data-index="3">
							<figure data-index="3" class="work-figure work-figure-3">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-work-3.jpg" height="205" width="410">
							</figure>
							<dl>
								<dd class="work-title"><?php _e('Sem título', 'flaviotavares'); ?></dd>
								<dd class="work-specs"><?php _e('Óleo sobre tela 80 x 70 cm', 'flaviotavares'); ?></dd>
								<dd class="work-year">1989</dd>
							</dl>
						</li>
						<li class="work-item" data-index="4">
							<figure data-index="4" class="work-figure work-figure-4">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/media/img/img-biography-work-4.jpg" height="312" width="198">
							</figure>
							<dl>
								<dd class="work-title"><?php _e('Sem título', 'flaviotavares'); ?></dd>
								<dd class="work-specs"><?php _e('Pastel 83 x 93 cm', 'flaviotavares'); ?></dd>
								<dd class="work-year">1968</dd>
							</dl>
						</li>
					</ol>
				</aside>
			</section>
		</section>
	</article>

	<aside class="extras">
		<section class="extra-quotes">
			<h1 class="extra-quotes-title">Citações</h1>
			<blockquote class="extra-quote">
				<p class="extra-quote-content"><?php _e('A obra de Flávio Tavares é fruto de 40 anos de processo contínuo, que resultou em uma linguagem artística perfeitamente adequada à sua expressão plástica. Para perceber sua poética é necessário compreender, ao mesmo tempo, as imbricações da concepção estética, a criatividade da imagética e o percurso de sua produção, manifestados em meios expressivos diferenciados e em variações técnicas que nos auxiliam, inclusive, na compreensão da arte contemporânea.', 'flaviotavares'); ?></p>
				<footer class="hcard"><span class="fn n">Elvira Vernaschi</span>, <span class="role"><?php _e('Presidente da Associação Brasileira de Críticos de Arte', 'flaviotavares'); ?></span>. 2005</footer>
			</blockquote>
			<blockquote class="extra-quote">
				<p class="extra-quote-content"><?php _e('Conheço o trabalho do artista plástico Flávio Tavares há 30 anos, aproximadamente. Nestas três décadas impressionou-me a constante evolução do artista e a sua capacidade de aprofundar os seus temas básicos e o refinamento dos instrumentos. Certamente, hoje, Flávio Tavares está entre os mais importantes artistas do Nordeste e tem uma posição respeitável entre os artistasbrasileiros figurativos de sua geração.', 'flaviotavares'); ?></p>
				<footer class="hcard"><span class="fn n">Jacob Klintowitz</span>, <span class="role"><?php _e('Crítico de arte', 'flaviotavares'); ?></span>. 2001</footer>
			</blockquote>
			<blockquote class="extra-quote">
				<p class="extra-quote-content"><?php _e('O artista surpreende-se, subverte, registra tudo em sua volta, neste desfilar de mistério por onde transitam flores, pássaros,florestas, bichos acuados, gente perplexa ou contemplativa, nas horas que vão sesucedendo entre o céu e  a terra num tempo marcado para acabar.', 'flaviotavares'); ?></p>
				<footer class="hcard"><span class="fn n">Hermano José Guedes</span>, <span class="role"><?php _e('Artista plástico', 'flaviotavares'); ?></span>, 2005</footer>
			</blockquote>
			<blockquote class="extra-quote">
				<p class="extra-quote-content"><?php _e('Flávio Tavares, em sua pesquisa artística, dá asas aos seus sonhos, através de desenhos e pinturas cujos componentes principais são a representação das lembranças da infância, das paisagens oníricas de sua terra e da criação de um mundo melhor. Sua arte convida o espectador a entrar na viagem artística semeada de alegria, de encanto e de mistério.', 'flaviotavares'); ?></p>
				<footer class="hcard"><span class="fn n">Risoleta Córdula</span>, <span class="role"><?php _e('Crítica de arte', 'flaviotavares'); ?></span>. 2005</footer>
			</blockquote>
			<blockquote class="extra-quote">
				<p class="extra-quote-content"><?php _e('Suavizada na superfície por suas cores e volumes carregados de calma sensualidade, recurso que sempre atrai e envolve o apreciador desprevenido, a pintura de Flávio Tavares, no próximo passo, como que nos arrebata e transforma o ‘devaneio’ em mergulho profundo. Em quase todas as suas fases, a profusa emoção que emana de suas figuras, em diferentes planos, instala uma atmosfera densa de significados, transcende todo o quadro e nos conduz a indagações no mínimo inquietantes. É assim que vejo e sinto a arte de Flávio Tavares, um pintor da alma, para mim um inveterado dostoiesvskiano, que se tornou, em seu luminoso trajeto, um dos maiores artistas da contemporaneidade brasileira.', 'flaviotavares'); ?></p>
				<footer class="hcard"><span class="fn n">Vladimir Carvalho</span>, <span class="role"><?php _e('Cineasta e jornalista', 'flaviotavares'); ?></span>. 2005</footer>
			</blockquote>
		</section>

		<section class="reinado">
			<figure class="reinado-figure">
				<img class="reinado-img1" src="<?php echo get_stylesheet_directory_uri() . '/media/img/reinado-do-sol-1.jpg'; ?>" width="622" height="350">
				<img class="reinado-img2" src="<?php echo get_stylesheet_directory_uri() . '/media/img/reinado-do-sol-2.jpg'; ?>" width="351" height="350">
				<figcaption>
					<h1 class="reinado-caption-title"><?php _e('Reinado do Sol', 'flaviotavares'); ?></h1>
					<p class="reinado-caption-desc"><?php _e('Óleo sobre Tela, 900 x 300cm, 2008. Acervo da Estação Cabo Branco, João Pessoa - PB', 'flaviotavares'); ?></p>
				</figcaption>
			</figure>
			<h1 class="reinado-title"><?php _e('Reinado do Sol', 'flaviotavares'); ?></h1>
			<p class="reinado-desc"><?php _e('Um escritor elegante e gentil bem no meio da tela. Um poeta maldito, um grupo nômade, uma tribo indígena e um intelectual abolicionista. Muitos escravos, putas, diversos espelhos, anões e duendes, enfim mais de 500 personagens, as tais personalidades que compõem o painel de 9 metros por 3, intitulado “No Reinado do Sol”, obra do artista Flávio Tavares.', 'flaviotavares'); ?>
			<p class="reinado-desc"><?php _e('A obra virou o adorno principal do hall da Estação Ciência, projeto do arquiteto Oscar Niemeyer, em que a Prefeitura de João Pessoa presentou a cidade como marco cultural de uma gestão que dialoga com as artes. Salve!', 'flaviotavares') ?> - <strong>Kubitschek Pinheiro</strong></p>
		</section>

		<section class="curriculum">
			<h1 class="curriculum-title"><?php _e('Curriculum', 'flaviotavares'); ?></h1>
			<p class="curriculum-desc"><?php printf(__('Baixe um PDF com o currículo do artista <a href="%s">clicando aqui</a>.', 'flaviotavares'), home_url('/wp-content/uploads/2013/06/curriculum-flavio-tavares.pdf')); ?></p>
		</section>

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
</section>
<?php get_footer(); ?>