<?php
/**
 *
 * @author Samuel Ramon samuel@phpcafe.com.br
 */

get_header();

get_template_part('title', 'page');

$instituicoes = get_signatarios('institu', false, $_GET['s']);
$outros = get_signatarios(false, 'institu', $_GET['s']);

//$tipos = tipos_signatarios();
global $post;
?>

	<h2 class="title-signatarios">Conheça a lista de signatários da Plataforma para Construção de um Novo Marco Regulatório.</h2>

	<?php get_search_form(); ?>

	<div class="sidea">
		<h4>Redes, Fóruns e Articulações <?php /*?><?php echo implode(',', $tipos['outros']) ?><?php */?></h4>

		<?php if($outros): $total = 0; $j=0; ?>
			<?php foreach( $outros as $o => $i ): $customs =  get_post_custom_values("site", $i->ID); ?>
				<?php if ( $o < 10 ){ $attr = ''; } else { $attr = "style='display:none;'"; } ?>
				<?php if ( ($o%10)==0 ) { echo "<div id='unid2_{$total}' {$attr} class='page_content2'>"; $j = 1; $total++; } ?>
				<p>
				   <?php if ($customs[0]) { echo "<a href='".addhttp($customs[0])."' target='_blank'>"; } ?>
				      <?php echo $i->post_title; ?>
				   <?php if ($customs[0]) { echo "</a>"; } ?>
				</p>
				<?php if ( $j==10 || $o == count($outros)-1 ) { echo "</div>"; } ?>
				<?php if ( $j>0 && $j<=10 ) { $j++; } else { $j=0; } ?>
			<?php endforeach; ?>

			<?php if ( count($outros) > 10 ): ?>
				<div id="paginacao">
					<a href="#" id="voltar2">Voltar</a>
					<a href="#" id="avancar2">Avan&ccedil;ar</a>
				</div>

				<script type="text/javascript">
					var ini = 0,
						max = <?php echo $total ?>;

					jQuery(document).ready(function($){
						function show2( indice ) {
							$('.page_content2').css('display','none');
							$('#unid2_'+indice).css('display','block');

							ini = indice;
						}

						jQuery('#voltar2').click('click', function(e){
							e.preventDefault();
							if ( ini > 0 ) show2(ini-1)
						});

						jQuery('#avancar2').live('click', function(e){
							e.preventDefault();
							if ( ini < max - 1 ) show2(ini+1);
						});

						show2( ini );
					});
				</script>
			<?php endif; ?>
		<?php else: ?>
		<p>Não encontrados</p>
		<?php endif; ?>
	</div>

	<div class="sideb">
		<h4>Organizações <?php /*?><?php echo $tipos['instituicoes'] ?><?php */?></h4>

		<?php if($instituicoes): $total = 0; $j=0; ?>
			<?php foreach( $instituicoes as $o => $i ): $customs =  get_post_custom_values("site", $i->ID); ?>
				<?php if ( $o < 10 ){ $attr = ''; } else { $attr = "style='display:none;'"; } ?>
				<?php if ( ($o%10)==0 ) { echo "<div id='unid_{$total}' {$attr} class='page_content'>"; $j = 1; $total++; } ?>
				<p>
				   <?php if ($customs[0]) { echo "<a href='".addhttp($customs[0])."' target='_blank'>"; } ?>
				      <?php echo $i->post_title; ?>
				   <?php if ($customs[0]) { echo "</a>"; } ?>
				</p>
				<?php if ( $j==10 || $o == count($instituicoes)-1 ) { echo "</div>"; } ?>
				<?php if ( $j>0 && $j<=10 ) { $j++; } else { $j=0; } ?>
			<?php endforeach; ?>

			<?php if ( count($instituicoes) > 10 ): ?>
				<div id="paginacao">
					<a href="#" id="voltar">Voltar</a>
					<a href="#" id="avancar">Avan&ccedil;ar</a>
				</div>

				<script type="text/javascript">
					var ini = 0,
						max = <?php echo $total ?>;

					jQuery(document).ready(function($){
						function show( indice ) {
							$('.page_content').css('display','none');
							$('#unid_'+indice).css('display','block');

							ini = indice;
						}

						jQuery('#voltar').click('click', function(e){
							e.preventDefault();
							if ( ini > 0 ) show(ini-1)
						});

						jQuery('#avancar').live('click', function(e){
							e.preventDefault();
							if ( ini < max - 1 ) show(ini+1);
						});

						show( ini );
					});
				</script>
			<?php endif; ?>
		<?php else: ?>
		<p>Não encontrados</p>
		<?php endif; ?>
	</div>
<?php
get_footer();
?>
