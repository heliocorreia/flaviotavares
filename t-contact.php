<?php
/*
Template Name: Contato
*/
?>
<?php get_header(); ?>
<script>
head.ready(function(){
	$('#t-contact .content').responsiveVerticalCenter({parentSelector:'body'});
});
</script>
<section id="t-contact" class="vcard">
	<div class="container">
		<section class="content">
			<h1 class="main-title"><?php the_title(); ?></h1>
			<address>
				<h1 class="fn"><?php _e('Ateliê Flávio Tavares', 'flaviotavares'); ?></h1>
				<p class="adr"><span class="street-address"><?php _e('Rua Maria José Rique, quadra 177, loteamento Cidade Recreio', 'flaviotavares'); ?></span>, <?php _e('Altiplano', 'flaviotavares'); ?>, <span class="locality"><?php _e('João Pessoa', 'flaviotavares'); ?></span> - <abbr class="region" title="Paraíba">PB</abbr> - <a href="#"><?php _e('Veja mapa aqui', 'flaviotavares'); ?></a></p>
				<p><?php _e('Terças, quintas e sábados.', 'flaviotavares'); ?></p>
				<p><?php _e('Agendar horário para visitação.', 'flaviotavares'); ?></p>
				<p class="tel"><?php _e('Fone: (83) 3226 7376', 'flaviotavares'); ?></p>
			</address>
			<address>
				<h1><?php _e('Na Web', 'flaviotavares'); ?></h1>
				<p class="email">contato@flaviotavares.com.br</p>
				<p class="url">www.facebook.com/flaviotavares</p>
				<p class="url">www.youtube.com.br/flaviotavares</p>
			</address>
		</section>
	</div>
</section>
<?php get_footer(); ?>