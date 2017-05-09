<?php
/**
 * 
 * @author Samuel Ramon samuel@phpcafe.com.br
 */
?>
<form role="search" method="get" id="searchform" action="<?php bloginfo('siteurl'); ?>">
  		<div>
    		<label class="screen-reader-text" for="s">Procurar:</label>
    		<input type="text" value="<?php echo $_GET['s'] ?>" name="s" id="s" />
	 	 	<input type="submit" id="searchsubmit" value="Search" />
  		</div>
	</form>