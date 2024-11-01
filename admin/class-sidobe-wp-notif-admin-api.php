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

class Sidobe_Wp_Notif_Admin_Api{
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

    private $sidobe_wa_api_url;
    private $sidobe_wa_api_headers;

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

        $options = get_option( 'sidobe_wp_notif_options' );
        $this->sidobe_wa_api_url = 'https://api.sidobe.com/wa/v1';

        if ($options) {
            $this->sidobe_wa_api_headers = array(
                'Content-Type' => 'application/json',
                'X-SECRET-KEY' => $options['sidobe_wp_notif_field_secret_key']
            );
        }
	}

    /**
     * Method POST for sending payload to Sidobe.
     *
     * @param   string  $path from feature Sidobe.
     * @param   array   $body payload.
     */
    function sidobe_post( $path, $body ) {
        $args = array(
            'body'        => wp_json_encode($body),
            'timeout'     => '5',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => $this->sidobe_wa_api_headers,
            'cookies'     => array(),
        );

        $response = wp_remote_post( $this->sidobe_wa_api_url . '/' . $path, $args );

        return $response;
    }
}
?>
