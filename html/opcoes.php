<?php
/**
 * Arquivo do formulário de configuração do tema gavulino
 * 
 * @access public
 * @package WordPress
 * @subpackage Gavulino
 * @version 1.0
 * @author Samuel Ramon samuel@phpcafe.com.br
 * @author Felipe Viana ffpviana@gmail.com
 */

global $title;
?>
<div class="wrap">
    <div class="icon32"></div>

    <h2><?php echo $title; ?></h2>

    <form id="svm-promocoes" method="post" action="options.php">
<?php   settings_fields( 'gife-options' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
					<label for="gife-twitter">Twitter</label>
				</th>
                <td>
                    <input type="text" name="gife-twitter" id="gife-twitter"
						   value="<?php echo get_option('gife-twitter'); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
					<label for="gife-facebook">URL Facebook</label>
				</th>
                <td>
                    <input type="text" name="gife-facebook" id="gife-facebook"
						   value="<?php echo get_option('gife-facebook'); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
					<label for="gife-orkut">Orkut</label>
				</th>
                <td>
                    <input type="text" name="gife-orkut" id="gife-orkut"
						   value="<?php echo get_option('gife-orkut'); ?>" />
                </td>
            </tr>
			<tr valign="top">
                <th scope="row">
					<label for="gife-orkut">E-mail para receber adesões</label>
				</th>
                <td>
                    <input type="text" name="gife-email" id="gife-orkut"
						   value="<?php echo get_option('gife-email'); ?>" />
                </td>
            </tr>
        </table>

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
</div>
