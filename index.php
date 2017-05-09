<?php
/**
 * 
 * @author Samuel Ramon samuel@phpcafe.com.br
 */

get_header();

the_post();
?>

<div id="noticia" class="sidefull">
	<h2 class="titlepost"><?php the_title() ?></h2>
	
	<br clear="all" />

	<div class="">
		<?php the_content() ?>
	</div>
</div>



<?php
get_footer();
?>