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

$category = get_the_category();

global $wpdb;

$sql = "SELECT p.*
	FROM {$wpdb->posts} AS p
	INNER JOIN {$wpdb->term_relationships} AS tr ON tr.object_id = p.ID
	INNER JOIN {$wpdb->term_taxonomy} AS tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
	WHERE tt.term_id = {$category[0]->cat_ID}
	AND p.post_status = 'publish'
	ORDER BY p.post_date DESC";

if ( is_category('noticias') ) {
	global $wp_query, $paged;

	if ($paged && $paged != 1){
		$page =	( $wp_query->query_vars['posts_per_page'] * $paged ) - $wp_query->query_vars['posts_per_page'];
		$next = $paged +1;
		$prev = $paged - 1;
	} else {
		$page =	0;
		$next = $paged + 2;
		$prev = 0;
	}

	$sql .= " LIMIT {$page},{$wp_query->query_vars['posts_per_page']}";
}
	
$posts = $wpdb->get_results($sql);

$total = count($posts);
if ( is_category('reunioes') ) 
	$sidea = $total/2;
else
	$sidea = ceil($total/2);
?>

<?php get_template_part('title', 'page') ?>

<?php if ( is_category('noticias') && function_exists('wp_pagenavi') ) wp_pagenavi();  ?>

<div class="sidea" <?php if ( is_category('noticias') ) echo 'id="main-noticia"'; ?>>
	
	<?php if ( !is_category('noticias') ): ?>
	<h2><?php echo $category[0]->category_description ?></h2>
	
	<br clear="all" />
	<?php endif; ?>
	
	<ul <?php if ( is_category('reunioes') ) echo 'class="reunioes"'; ?>>
	<?php for ( $i=0; $i<$sidea; $i++ ): ?>

		<?php if ( is_category('reunioes') ): $customField = get_cfm('Reuniões', $posts[$i]->ID); ?>
		
			<li>
				<h4><?php echo $posts[$i]->post_title ?></h4>
				<p>Data: <strong><?php echo $customField[0]->data ?></strong></p>
				<p>Local: <strong><?php echo $customField[0]->local ?></strong></p>

				<?php if ( $customField[0]->documento ): ?>
				<a href="<?php echo $customField[0]->documento ?>" target="_blank">
				   <img src="<?php bloginfo('template_url') ?>/images/btn-download.gif"/>
				</a>
				<?php endif; ?>
			</li>
		
		<?php else: ?>
		
			<li>
				<h3><?php echo $posts[$i]->post_title ?></h3>
				<p>
					<?php echo $posts[$i]->post_excerpt; ?>
					<span class="link">
						<a href="<?php echo get_permalink( $posts[$i] ) ?>">... mais</a>
					</span>
				</p>
			</li>
		
		<?php endif; ?>

	<?php endfor; ?>
	</ul>
</div>

<div class="sideb" <?php if ( is_category('noticias') ) echo 'id="main-noticia"'; ?>>
	<ul <?php if ( is_category('reunioes') ) echo 'class="reunioes"'; ?>>
	<?php for ( ; $i<$total; $i++ ): ?>

		<?php if ( is_category('reunioes') ): $customField = get_cfm('Reuniões', $posts[$i]->ID); ?>
		
			<li>
				<h4><?php echo $posts[$i]->post_title ?></h4>
				<p>Data: <strong><?php echo $customField[0]->data ?></strong></p>
				<p>Local: <strong><?php echo $customField[0]->local ?></strong></p>

				<?php if ( $customField[0]->documento ): ?>
				<a href="<?php echo $customField[0]->documento ?>" target="_blank">
				   <img src="<?php bloginfo('template_url') ?>/images/btn-download.gif"/>
				</a>
				<?php endif; ?>
			</li>
		
		<?php else: ?>
		
			<li>
				<h3><?php echo $posts[$i]->post_title ?></h3>
				<p>
					<?php echo $posts[$i]->post_excerpt; ?>
					<span class="link">
						<a href="<?php echo get_permalink( $posts[$i] ) ?>">... mais</a>
					</span>
				</p>
			</li>
		
		<?php endif; ?>

	<?php endfor; ?>
	</ul>
</div>

<?php
get_footer();
?>