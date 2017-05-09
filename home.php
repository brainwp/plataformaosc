<?php
/**
 * Página Inicial do projeto
 * Composição:
 *	2 notícias em listagem
 *	Listagem com efeito scroll dos facilitadores
 *	Twitter
 *	Banner superior configurável
 * 
 * @author Samuel Ramon samuel@phpcafe.com.br
 */

// css para o slider
wp_enqueue_style('mootools-slider', get_bloginfo('template_url').'/css/SlideItMoo.css');

// plugin de slider do mootools
wp_enqueue_script('slideitmoo', get_bloginfo('template_url').'/js/slideitmoo-1.1-mootools1.3.js', array('mootools-core','mootools-more'));
wp_enqueue_script('gife_slide', get_bloginfo('template_url').'/js/gife_slide.js', array('slideitmoo'));

get_header();

global $wpdb;

$sql = "SELECT p.*
	FROM {$wpdb->posts} AS p
	INNER JOIN {$wpdb->term_relationships} AS tr ON tr.object_id = p.ID
	INNER JOIN {$wpdb->term_taxonomy} AS tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
	INNER JOIN {$wpdb->terms} AS t ON t.term_id = tt.term_id
	WHERE t.slug = 'noticias'
	AND p.post_status = 'publish'
	ORDER BY p.post_date DESC
	LIMIT 3";

$noticias = $wpdb->get_results($sql);

$comite = get_cfm('Comitê', 11); // Pegando os fields da página de comitê

?>

<div class="banner">
	<?php if (function_exists('nivoslider4wp_show')) { nivoslider4wp_show(); } ?>
<!--	<img src="<?php bloginfo('template_url') ?>/images/banner-home.jpg" alt="Banner Destaque" 
		 title="Uma articulação inédita entre redes, movimentos e organizações sociais diversas sob uma mesma bandeira."/>-->
</div>

<div id="main-noticia">
	<?php if ( $noticias ): ?>
	<ul>
		<?php foreach ( $noticias as $n ): ?>
		<li>
			<h3><?php echo $n->post_title ?></h3>
			<p>
				<?php echo $n->post_excerpt ?>
				<span class="link">
					<a href="<?php echo get_permalink( $n->ID ); ?>">... mais</a>
				</span>
			</p>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
</div>

<?php if ( class_exists('SimpleNews') ) SimpleNews::form() ?>

<div id="main-comite">
	<div class="esq SlideItMoo_back"></div>
	<div class="dir SlideItMoo_forward"></div>
	<div id="SlideItMoo_inner">
		<div id="SlideItMoo_items">			
			<?php foreach ( $comite as $c ): if( $c->image ): ?>
			<div class="SlideItMoo_element">
				<img height="50px" src="<?php echo $c->image ?>" title="<?php echo $c->nome ?>" />
			</div>
			<?php endif; endforeach; ?>
		</div>
	</div>
</div>

<div id="widgetTwitter">
	<div class="cabecalho">Nosso Twitter</div>
	<div id="twitter_feed"></div>
</div>

<script type="text/javascript">
window.addEvent('domready', function(){
	var arr = new Array(),
		index = 0;
	
	new Request.JSONP({
		url: "http://search.twitter.com/search.json",
		data: {
			q: "from:<?php echo str_replace('@','',get_option('gife-twitter')) ?>",
			count: 40
		},
		onRequest: this.fireEvent('request'),
		onComplete: function(obj) {
			if (obj.results != undefined &&  obj.results.length > 0) {
				Array.each(obj.results, function(o) {
					var ct = o.text;
					ct = ct.replace(/http:\/\/\S+/g,  '<a href="$&" target="_blank">$&</a>');
					ct = ct.replace(/\s(@)(\w+)/g,    ' @<a href="http://twitter.com/$2" target="_blank">$2</a>');
					ct = ct.replace(/\s(#)(\w+)/g,    ' #<a href="http://search.twitter.com/search?q=%23$2" target="_blank">$2</a>');
					ct = '<p> '+ct+'</p>';
					arr.push(ct);
				});
				
				setInterval(function(){
					var html = ''; 
					for( i=index; i<index+4; i++ )
						html += arr[i];

					index = index+4;
					$('twitter_feed').set('html', html);
					if ( index+4 > arr.length )
						index = 0;
				}, 5000);
			} else {
				$('twitter_feed').set('text','Sem tweets recentes');
			}
		}
	}).send();
});
</script>

<?php
get_footer();
?>