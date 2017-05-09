<?php
/**
 * Termo e condições sem formatação para impressão
 * 
 * @author Samuel Ramon samuel@phpcafe.com.br
 */

the_post();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/termo.css" />
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

?></title>
</head>

<body>
	<div style="width: 100%; margin: 0 auto;">
		<h1><?php the_title() ?></h1>
		
		<div>
			<?php the_content(); ?>
		</div>
	</div>
	
</body>
</html>
