<?php
/**
 * 
 * @author Samuel Ramon samuel@phpcafe.com.br
 */

get_header();

get_template_part('title', 'page');

$instituicoes = get_signatarios('institu');
$outros = get_signatarios(false, 'institu');

$tipos = tipos_signatarios();

global $post;
?>

	<h2 class="title-signatarios"><?php echo $post->post_title ?></h2>

	<p>&nbsp;</p>
	
	<div class="sidea">
		<h4>Redes, Fóruns e Articulações <?php /*?><?php echo implode(',', $tipos['outros']) ?><?php */?></h4>
		
		<?php if($outros): foreach( $outros as $o ): ?>
		<p><?php echo $o->post_title; ?></p>
		<?php endforeach; else: ?>
		<p>Não encontrados</p>
		<?php endif; ?>
	</div>

	<div class="sideb">
		<h4>Organizações <?php /*?><?php echo $tipos['instituicoes'] ?><?php */?></h4>
		
		<?php if($instituicoes): foreach( $instituicoes as $i ): ?>
		<p><?php echo $i->post_title; ?></p>
		<?php endforeach; else: ?>
		<p>Não encontrados</p>
		<?php endif; ?>
	</div>

<?php
get_footer();
?>
