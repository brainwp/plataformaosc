<?php
/**
 * Arquivo do cabeçalho das páginas 
 * 
 * @access public
 * @package WordPress
 * @subpackage Gife
 * @version 1.0
 * @author Samuel Ramon samuel@phpcafe.com.br
 * @author Felipe Viana ffpviana@gmail.com
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?php
/*
 * Print the <title> tag based on what is being viewed.
 */
global $page, $paged;

wp_title( '|', true, 'right' );

// Add the blog name.
bloginfo( 'name' );

// Add the blog description for the home/front page.
$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description && ( is_home() || is_front_page() ) )
	echo " | $site_description";

// Add a page number if necessary:
if ( $paged >= 2 || $page >= 2 )
	echo ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) );
	
if ( is_search() )
	echo "Busca";

?></title>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<div id="header">
			<?php 
			wp_nav_menu( array( 
				'theme_location' => 'top_menu',
				'container_id' => 'menu'
			)); 
			?>
			<div class="barra">
				<h1>
					<a href="<?php bloginfo('url') ?>">
						Plataforma por um Novo Marco Regulatório<br/>
						para as Organizações da Sociedade Civil.
					</a>
				</h1>
                <div class="bt-adesao">
				      <a href="<?php bloginfo('url') ?>/adesoes">
					<img src="<?php bloginfo('template_url') ?>/images/faca-sua-adesao.gif"/>
				     </a>
				 </div>
				<div class="socialicons">
					<ul>
                    	<li class="home">
                        	<a href="<?php bloginfo('url') ?>/?page_id=8"></a>
                        </li>
						<?php if ( get_option('gife-facebook') ): ?>
						<li class="facebook">
							<a href="<?php echo get_option('gife-facebook') ?>" taget="_blank"></a>
						</li>
						<?php endif; ?>
						
						<?php if ( get_option('gife-twitter') ): ?>
						<li class="twitter">
							<a href="http://twitter.com/<?php echo str_replace('@','',get_option('gife-twitter')) ?>" taget="_blank"></a>
						</li>
						<?php endif; ?>
						
						<?php if ( get_option('gife-orkut') ): ?>
						<li class="orkut">
							<a href="<?php echo get_option('gife-orkut') ?>" taget="_blank"></a>
						</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
		<div id="content">
			<div id="main">