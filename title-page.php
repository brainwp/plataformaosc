<?php
/**
 * 
 * @author Samuel Ramon samuel@phpcafe.com.br
 */
?>

<?php if ( is_page('plataforma') ): ?>
	<div class="titleSessao plataforma">
		<img src="<?php bloginfo('template_url') ?>/images/sessao-plataforma.gif" />
		<?php 
			$customFileds = get_cfm( 'PDF' );
			if ( $customFileds ):
		?>
		<a target="_blank" href="<?php echo $customFileds[0]->pdf ?>">
			<img class="btnpdf" src="<?php bloginfo('template_url') ?>/images/btn-baixarpdf.gif" />
		</a>
		<?php endif; ?>
	</div>

<?php elseif( is_page('adesoes') ): ?>
    <div class="titleSessao adesoes">
		<img src="<?php bloginfo('template_url') ?>/images/sessao-adesoes.gif" />
	</div>
	
<?php elseif( is_page('signatarios') || is_search() ): ?>
	<div class="titleSessao signatario">
		<img src="<?php bloginfo('template_url') ?>/images/sessao-signatarios.gif" />
		<?php
			$customFileds = get_cfm( 'PDF' );
			if ( $customFileds ):
		?>
		<a target="_blank" href="<?php echo $customFileds[0]->pdf ?>">
			<img class="btnpdf" src="<?php bloginfo('template_url') ?>/images/btn-baixarpdf-sign.gif" />
		</a>
		<?php endif; ?>
	</div>


<?php elseif( is_page('o-comite') ): ?>
	<div class="titleSessao comite">
		<img src="<?php bloginfo('template_url') ?>/images/sessao-comite.gif" />
	</div>
	
<?php elseif( is_category('noticias') ): ?>
	<div class="titleSessao noticias">
		<img src="<?php bloginfo('template_url') ?>/images/sessao-noticias.gif" />
	</div>
	
<?php elseif( is_category('reunioes') ): ?>
	<div class="titleSessao reunioes">
		<img src="<?php bloginfo('template_url') ?>/images/sessao-reunioes.gif" />
	</div>
	
<?php elseif( is_page('fale-conosco') ): ?>
	<style> h2 {display:none;} </style>
	<div class="titleSessao">
		<img src="<?php bloginfo('template_url') ?>/images/barra-faleconosco.gif" />
	</div>
	
<?php elseif( is_page('mapa-do-site') ): ?>
	<style> h2 {display:none;} </style>
	<div class="titleSessao">
		<img src="<?php bloginfo('template_url') ?>/images/barra-mapadosite.gif" />
	</div>
	
<?php elseif( is_page('politica-de-privacidade') ): ?>
	<style> h2 {display:none;} </style>
	<div class="titleSessao">
		<img src="<?php bloginfo('template_url') ?>/images/barra-politica.gif" />
	</div>
	
<?php elseif( is_page('links') ): ?>
	<style> h2 {display:none;} </style>
	<div class="titleSessao links">
		<img src="<?php bloginfo('template_url') ?>/images/sessao-links.gif" />
	</div>

<?php endif; ?>
	
	