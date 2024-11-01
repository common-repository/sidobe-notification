<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sidobe.com
 * @since      1.0.0
 *
 * @package    Sidobe_Wp_Notif
 * @subpackage Sidobe_Wp_Notif/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sidobe_Wp_Notif
 * @subpackage Sidobe_Wp_Notif/admin
 * @author     Sidobe <help@sidobe.com>
 */

class Sidobe_Wp_Notif_Admin_Form_Template{
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sidobe_wp_notif    The ID of this plugin.
	 */
	private $sidobe_wp_notif;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    private $sidobe_db;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $sidobe_wp_notif       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sidobe_wp_notif, $version ) {
		$this->sidobe_wp_notif = $sidobe_wp_notif;
		$this->version = $version;

        include_once plugin_dir_path( __FILE__ ) . 'class-sidobe-wp-notif-admin-db.php';
        $sidobe_db = new Sidobe_Wp_Notif_Admin_Db( $sidobe_wp_notif, $version );
        $this->sidobe_db = $sidobe_db;
	}

    /**
     * Function for handle edit template or content for notification
     */
    public function handle_submit_edit_template(){
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die();
        }

        $code = isset( $_POST['sidobe_wp_notif']['code'] ) ? sanitize_text_field( wp_unslash( $_POST['sidobe_wp_notif']['code'] ) ) : '' ;
        $content = isset( $_POST['sidobe_wp_notif']['content'] ) ? sanitize_textarea_field( wp_unslash( $_POST['sidobe_wp_notif']['content'] ) ) : '';
        $url = isset( $_POST['_wp_http_referer'] ) ? sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) ) : '';

		if (!check_admin_referer( "update_template_code_".$code )) {
			wp_die();
		}

        $res = $this->sidobe_db->update_content($code, $content, null);

        $redirect_url = add_query_arg('sidobe_wp_notif_status', 'success', $url);
        wp_redirect($redirect_url);
        exit;
    }

    /**
     * Function for handle update status template active or not from ajax
     */
    public function handle_ajax_status_template() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die();
        }

        $nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
        if (!isset($nonce) || !wp_verify_nonce($nonce, 'sidobe_ajax_nonce')) {
            wp_send_json_error(array('message' => 'Invalid nonce'));
            wp_die();
        }

        $template_status = isset($_POST['template_status']) ? sanitize_text_field( wp_unslash( $_POST['template_status'] ) ) : '';
        $template_code = isset($_POST['template_code']) ? sanitize_text_field( wp_unslash( $_POST['template_code'] ) ) : '';
        $template_payload = array(
            'template_status' => $template_status,
            'template_code' => $template_code
        );

        $res_db = $this->sidobe_db->update_content($template_code, null, $template_status);
        $res = array(
            'is_success' => true,
            'data' => array(
                'template_status' => $template_status,
                'template_code' => $template_code
            )
        );

        if ($res_db == false) {
            wp_send_json_error( $template_payload );
        }

        wp_send_json_success( $template_payload );
        wp_die();
    }
}
?>
