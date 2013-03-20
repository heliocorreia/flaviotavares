<?php
/*
Template Name: [en] Biography
*/
?>
<?php get_header(); ?>
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
				<h1>Pintando, como sempre pintou</h1>
				<p>Nascido em João Pessoa, na Paraíba, nos anos 50, dizer que Flávio teve uma infância igual a qualquer outro garoto da época seria exagero. Filho de um pai médico com fortes tendências para o desenho, sua jornada começou ainda menino, observando os rabiscos do pai, no terraço de uma casa ampla, cheia de fruteiras e convites para as aventuras infantis.</p>
				<p>O que era brincadeira virou coisa séria e foi na Universidade Federal da Paraíba que ele começou a profissionalizar seu traço, tendo aulas com grandes nomes da arte paraibana como, entre outros, Hermano José, que, segundo Flávio, “é das pessoas mais sábias que a Paraíba tem”.</p>
				<p>No entanto, engana-se quem pensa que a formação do artista se deu apenas em sala de aula. Depois de ganhar um prêmio no Salão de Arte Global de Olinda, em 1974, as pinceladas de Flávio o levaram ao velho mundo, para onde nunca mais deixaria de voltar, tendo em vista os diversos admiradores que conquistou por lá. Foi desenhando, expondo e sucessivamente nessa ordem que Flávio viu sua carreira deslanchar como Artista Plástico, afinal, a melhor escola ainda é, simplesmente, produzir.</p>
				<blockquote>
					<p>“Quando estou pintando, estou pintando para a gente, para o povo daqui. Acho que isso valoriza a parceria que existe entre o pintor, o artista, e o povo.”</p>
				</blockquote>
				<p>Percebe-se, no imaginário do artista, um predomínio de figuras humanas e ele confirma que o popular é seu maior campo de interesse. Com um fabulário ligado ao folclore, ao mundo do Cordel e à literatura, diversos autores Paraibanos já passaram por seus pincéis, como Augusto dos Anjos, José Lins do Rego, Machado de Assis e José Américo de Almeida. O cinema Paraibano também exerce grande influência na obra de Flávio, que se inspira com Wladimir de Carvalho, Paulo Melo, João Ramiro e Marco Vilar.</p>
				<p>Apesar de já ter andado por diversos cantos do mundo, o lugar desse pintor é mesmo a sua terra natal. Constantemente declara sua paixão e admiração por João Pessoa, cidade que considera extremamente afetiva. Acha que a as pessoas valorizam a arte local e, sendo assim, os artistas. Seus imensos painéis estampam construções importantes da capital paraibana, provando que sua arte é considerada patrimônio popular e de grande valia para a cultura do Estado e, consequentemente, Brasileira.</p>
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