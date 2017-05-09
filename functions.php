<?php
/**
 * Funções de controle do tema
 *
 * @author Samuel Ramon samuel@phpcafe.com.br
 */

ini_set('display_errors', false);
error_reporting(false);

//ini_set('display_errors', true);
//error_reporting(E_ALL);

add_action('after_setup_theme','gife_setup');
if ( !function_exists('gife_setup') ):
	/**
	 * Função de configuração do tema
	 */
	function gife_setup () {
		// adicionando editor de estilo para o tema
		add_editor_style();

		// adicionando feeds de notícias automáticos par aos links
		add_theme_support( 'automatic-feed-links' );

		// adicionando thumbs para os posts
		add_theme_support( 'post-thumbnails' );

		// Registrando os menus do tema
		register_nav_menu( 'top_menu', __('Menu Topo') );
		register_nav_menu( 'bottom_menu', __('Menu Rodapé') );
	}
endif;

add_action('init', 'ini_gifeproject');
if ( !function_exists('ini_gifeproject') ) :
	/**
	 * Função para retirar o jquery do site e colocar o mootools
	 */
	function ini_gifeproject() {
		if ( !is_admin() ):
			// removendo o jquery do wordpress
			wp_deregister_script('jquery');

			// incluindo mootools no projeto
			wp_enqueue_script('mootools-core', get_bloginfo('template_url').'/js/mootools-core-1.4.0.js');
			wp_enqueue_script('mootools-more', get_bloginfo('template_url').'/js/mootools-more-1.4.0.1.js', array('mootools-core'));

			// incluindo plugin do mootools para ajuste de texto em colunas
//			wp_enqueue_script('moocolumns', get_bloginfo('template_url').'/js/MooColumns_0.67.js', array('mootools-core','mootools-more'));
		endif;
	}
endif;

if ( !function_exists('save_sitepost') ):
	/**
	 * Salvando os dados do post Signatário
	 *
	 * @param array $data The post data
	 * @return boolean
	 */
	function save_sitepost() {
		global $wpdb;

		$_POST['post_type'] = 'signatarios';

		$_POST['post_mime_type'] = '';

		// Clear out any data in internal vars.
		unset( $_POST['filter'] );

		// Check for autosave collisions
		// Does this need to be updated? ~ Mark
		$temp_id = false;
		if ( isset($_POST['temp_ID']) ) {
			$temp_id = (int) $_POST['temp_ID'];
			if ( !$draft_ids = get_user_option( 'autosave_draft_ids' ) )
				$draft_ids = array();
			foreach ( $draft_ids as $temp => $real )
				if ( time() + $temp > 86400 ) // 1 day: $temp is equal to -1 * time( then )
					unset($draft_ids[$temp]);

			if ( isset($draft_ids[$temp_id]) ) { // Edit, don't write
				$_POST['post_ID'] = $draft_ids[$temp_id];
				unset($_POST['temp_ID']);
				update_user_option( $user_ID, 'autosave_draft_ids', $draft_ids );
				return edit_post();
			}
		}

		// Edit don't write if we have a post id.
		if ( isset( $_POST['ID'] ) ) {
			$_POST['post_ID'] = $_POST['ID'];
			unset ( $_POST['ID'] );
		}
		if ( isset( $_POST['post_ID'] ) ) {
			return edit_post();
		}

		$translated = _wp_translate_postdata( false );
		if ( is_wp_error($translated) )
			return $translated;

		if ( isset($_POST['visibility']) ) {
			switch ( $_POST['visibility'] ) {
				case 'public' :
					$_POST['post_password'] = '';
					break;
				case 'password' :
					unset( $_POST['sticky'] );
					break;
				case 'private' :
					$_POST['post_status'] = 'private';
					$_POST['post_password'] = '';
					unset( $_POST['sticky'] );
					break;
			}
		}

		// Create the post.
		$post_ID = wp_insert_post( $_POST );
		if ( is_wp_error( $post_ID ) )
			return $post_ID;

		if ( empty($post_ID) )
			return 0;

		add_meta( $post_ID );

		add_post_meta( $post_ID, '_edit_last', $GLOBALS['current_user']->ID );

		// Reunite any orphaned attachments with their parent
		// Does this need to be udpated? ~ Mark
		if ( !$draft_ids = get_user_option( 'autosave_draft_ids' ) )
			$draft_ids = array();
		if ( $draft_temp_id = (int) array_search( $post_ID, $draft_ids ) )
			_relocate_children( $draft_temp_id, $post_ID );
		if ( $temp_id && $temp_id != $draft_temp_id )
			_relocate_children( $temp_id, $post_ID );

		// Update autosave collision detection
		if ( $temp_id ) {
			$draft_ids[$temp_id] = $post_ID;
			update_user_option( $user_ID, 'autosave_draft_ids', $draft_ids );
		}

		// Now that we have an ID we can fix any attachment anchor hrefs
		_fix_attachment_links( $post_ID );

		wp_set_post_lock( $post_ID, $GLOBALS['current_user']->ID );

		// inserindo os campos customizados
		$inserts = array();
		foreach ( $_POST as $key => $val ) {
			if ( strpos($key, 'cctm_') !== false ) {
				$inserts[] = "('{$post_ID}', '".str_replace('cctm_', '', $key)."', '{$val}')";
			}
		}
		$inserts = implode(",", $inserts);

		$sql = "INSERT INTO {$wpdb->postmeta} (`post_id`,`meta_key`,`meta_value`) VALUES {$inserts};";
		$wpdb->query($sql);

		// enviando email avisando do novo cadastro
		$message	= "Novo cadastro de signatário.\n\nSignatário: {$_POST['post_title']}\nContato: {$_POST['cctm_nome_contato']}\nTel.: {$_POST['cctm_telefone']}\nE-mail: {$_POST['cctm_email_contato']}\n\n Acesse a administração do site para ativar o signatário cadastrado";

		@wp_mail(get_option('gife-email'),'Cadastro de Signatário',$message);

		return true;
	}
endif;

if ( !function_exists('get_signatarios') ):
	/**
	 *
	 * @global wpdb $wpdb
	 * @param string $type
	 * @param string $not_type
	 */
	function get_signatarios( $type = false, $not_type = false, $search = false ) {
		global $wpdb;

		$sql = "
			SELECT p.*, pm.*
			FROM {$wpdb->posts} AS p
			INNER JOIN {$wpdb->prefix}postmeta AS pm ON p.ID = pm.post_id
			WHERE pm.meta_key = 'caracteristica'
			AND p.post_type = 'signatarios'";

		if ( $type ) {
			$sql .= "
			AND pm.meta_value LIKE '%{$type}%'
			";

		} else if ( $not_type ) {
			$sql .= "
			AND pm.meta_value NOT LIKE '%{$not_type}%'
			";
		}

		if ( $search ) {
			$search = stripslashes($search);
			$sql .= "
			AND p.post_title LIKE '%{$search}%'
			";
		}

		$sql .="
			AND p.post_status = 'publish'
			ORDER BY p.post_title
			";

		return $wpdb->get_results($sql);
	}
endif;

if ( !function_exists('tipos_signatarios') ):

	function tipos_signatarios() {
		global $wpdb;

		$sql = "SELECT option_value FROM {$wpdb->options} WHERE option_name = 'cctm_data'";
		$data = maybe_unserialize($wpdb->get_row($sql)->option_value);

		$returnData = array();
		foreach ( $data['custom_field_defs']['caracteristica']['options'] as $option ) {
			if ( $option == 'Instituição' )
				$returnData['instituicoes'] = 'Instituições';
			else
				$returnData['outros'][] = $option;
		}

		return $returnData;
	}
endif;

if ( !function_exists('gife_config') ):
	function gife_config() {

		register_setting('gife-options', 'gife-orkut');
		register_setting('gife-options', 'gife-twitter');
		register_setting('gife-options', 'gife-facebook');
		register_setting('gife-options', 'gife-email');

		add_options_page('Configurações - GIFE', 'Configurações - GIFE', 'manage_options', 'gife-options', 'gife_config_html');
	}
endif;
add_action('admin_menu', 'gife_config');

if ( !function_exists('gife_config_html') ):
	/**
	 * Função para o formuláro das opções das configurações
	 *
	 * @access public
	 */
	function gife_config_html() {
		include_once('html/opcoes.php');
	}
endif;
function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}
