<?php
/**
 * 
 * @author Samuel Ramon samuel@phpcafe.com.br
 */

get_header();

the_post();
?>

<div class="titleSessao noticias">
	<img src="<?php bloginfo('template_url') ?>/images/sessao-noticias.gif"/>
</div>
<div id="noticia" class="sidefull">
	<h2 class="titlepost"><?php the_title() ?></h2>
	
	<br clear="all" />

	<div class="">
		<?php the_content() ?>
	</div>

        <div id="comentarios">
	    <div id="message"></div>
				
	    <div id="tit-mensagem">
	        <?php comment_form();?>		
	    </div>

	    <div class="cb"></div>

            <?php
	    $args = array(
	        'status' => 'approve',
	        'post_id' => $post->ID
	    );			
	    $comments = get_comments($args);
	    if( $comments ):
 	    ?>

	    <h3>comentários</h3>

	    <ol class="commentlist">
	    <?php
	    foreach($comments as $i => $comment) :
	        if($i%2){$pa="odd";}else{$pa="even";}
	    ?>
		<li class='<?php echo $pa; ?>'>
		    <div class="autor_comentario">
		        <?php echo $comment->comment_author; ?>
		    </div>
		    <div class="avatar_comentario">
		        <?php echo get_avatar( $comment->comment_author_email, 32 ); ?>
		    </div>
		    <div>
		        <p>
		            <?php echo $comment->comment_content;?>
		        </p>
		    </div>
		</li>
            <?php
	        endforeach;
	    ?>
	    </ol>

	    <?php paginate_comments_links(); ?> 
	    <?php endif; ?>
        </div>
</div>



<?php
get_footer();
?>