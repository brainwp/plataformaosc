<?php
/**
 * 
 * @author Samuel Ramon samuel@phpcafe.com.br
 */

//wp_deregister_script('mootools-core');
//wp_deregister_script('mootools-mode');

//wp_enqueue_script('css3-multi-column', get_bloginfo('template_url').'/js/css3-multi-column.js');
//wp_enqueue_style('css3-multi-column', get_bloginfo('template_url').'/css/css3-multi-column.css');

get_header();

?>


<?php get_template_part('title', 'page') ?>	

<?php if ( is_page('plataforma') ): the_post(); ?>

	<!-- div class="Article">
		<h2 class="title-signatarios">
			<?php //the_title() ?>
		</h2>

		<?php //the_content() ?>
	</div>
	<div id="Output"></div -->

	<div class="article">
		<h2><?php the_title() ?></h2>
		
		<div><?php the_content() ?></div>
	</div>

<?php elseif ( is_page('o-comite') ): the_post(); $customFileds = get_cfm( 'Comitê' ); ?>
	
	<div class="sidefull">
		<div class="descricao"><?php the_content(); ?></div>
		<p>&nbsp;</p>
		<ul class="comite">
			<?php if ($customFileds): foreach ($customFileds as $cfm): ?>
			<li>
				<?php if ( $cfm->image ): ?>
				<div><img height="50px" src="<?php echo $cfm->image ?>"/></div>
				<?php endif; ?>
				
				<h4><?php echo $cfm->nome ?></h4>
				<p>
					<?php if ( $cfm->nome_contato ): ?>
					- Nome do Contato: <?php echo $cfm->nome_contato ?><br/>
					<?php endif; ?>
					
					<?php if ( $cfm->telefone ): ?>
					- Telefone:  <?php echo $cfm->telefone ?><br/>
					<?php endif; ?>
					
					<?php if ( $cfm->email ): ?>
					- E-mail: <?php echo $cfm->email ?><br/>
					<?php endif; ?>
					
					<?php if ( $cfm->endereco ): ?>
					- Endereço: <?php echo $cfm->endereco ?><br/>
					<?php endif; ?>
					
					<?php if ( $cfm->site ): ?>
					- Site: <a href="<?php echo $cfm->site ?>" target="_blank"><?php echo $cfm->site ?></a>
					<?php endif; ?>
				</p>

			</li>
			<?php endforeach; endif; ?>
		</ul>
	</div>
	
<?php elseif ( is_page('links') ): the_post(); ?>

    <div class="sidefull">
        <h2><?php the_title() ?></h2>

	<br clear="all" />

	<div><?php the_content() ?></div>
	
       <div><ul class="pagina-links"><?php wp_list_bookmarks(array('title_before'=>'<h3>','title_after'=>'</h3>', 'show_description'=>1, 'between' => '<br />')); ?></ul></div>
    </div>

<?php else: the_post(); ?>
	
	<div class="sidefull">
		<h2><?php the_title() ?></h2>
		
		<br clear="all" />
		
		<div><?php the_content() ?></div>
	</div>

<?php endif; ?>

<?php
get_footer();
?>
