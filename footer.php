<?php
/**
 * Arquivo do rodapé das páginas 
 * 
 * @access public
 * @package WordPress
 * @subpackage Gife
 * @version 1.0
 * @author Samuel Ramon samuel@phpcafe.com.br
 * @author Felipe Viana ffpviana@gmail.com
 */
?>

				</div>
				<div id="footer">
					<?php
					wp_nav_menu( array( 
						'theme_location' => 'bottom_menu',
						'container' => ''
					));
					?>
                    <p class="copyright"> © 2011 Plataformaosc. Todos os direitos reservados.</p>
                </div>
            </div>
        </div>
		<?php wp_footer(); ?>
    </body>
</html>