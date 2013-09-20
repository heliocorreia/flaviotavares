<?php
/*
Template Name: Contato
*/
?>
<?php get_header(); ?>
<section id="t-contact" class="vcard">
	<div class="container">
		<section class="content">
			<h1 class="main-title"><?php the_title(); ?></h1>
			<address>
				<h1 class="fn"><?php _e('Ateliê Flávio Tavares', 'flaviotavares'); ?></h1>
				<p class="adr">
					<span class="street-address"><?php _e('Rua Zilda Nunes da Silva. 177. Portal do Sol', 'flaviotavares'); ?></span>.<br/>
					<?php _e('Altiplano Cabo Branco', 'flaviotavares'); ?> - <?php _e('CEP: 58046-505', 'flaviotavares'); ?>,<br/>
					<span class="locality"><?php _e('João Pessoa', 'flaviotavares'); ?></span> - <abbr class="region" title="Paraíba">PB</abbr>
				</p>
				<p><?php _e('Agendar horário para visitação.', 'flaviotavares'); ?></p>
				<p class="tel"><?php _e('Fone: (83) 3226-5022', 'flaviotavares'); ?></p>
			</address>
			<address>
				<h1><?php _e('Na Web', 'flaviotavares'); ?></h1>
				<p class="email">contato@flaviotavares.com.br</p>
				<p class="url">youtube.com/user/flaviotavaresmelo</p>
			</address>
		</section>
	</div>
</section>
<script>
head.ready(function(){
	$('html.gt-640 #t-contact .content').responsiveVerticalCenter({parentSelector:'body'});
});
</script>
<?php get_footer(); ?>