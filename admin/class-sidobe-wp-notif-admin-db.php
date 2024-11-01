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

class Sidobe_Wp_Notif_Admin_Db{
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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since      1.0.0
	 * @param      string    $sidobe_wp_notif       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sidobe_wp_notif, $version ) {
		$this->sidobe_wp_notif = $sidobe_wp_notif;
		$this->version = $version;
	}

    /**
     * @param   string  $code
     * @param   string  $content | nullable
     * @param   integer $is_active 1 true, 0 false | nullable
     */
    public function update_content($code, $content = null, $is_active = null){
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die();
        }

        global $wpdb;
        global $sidobe_wp_notif_table_name;

        $get_current_content = $this->get_content($code);

        if ($get_current_content == null){
            $res = $wpdb->insert( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                $sidobe_wp_notif_table_name,
                array( 'code' => $code, 'content' => $content, 'is_active' => $is_active ),
                array( '%s', '%s', '%d' )
            );

            return $res;
        }

        if ($content != null) {
            $get_current_content->content = $content;
        }
        if ($is_active != null) {
            $get_current_content->is_active = $is_active;
        }

        $res = $wpdb->update( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
            $sidobe_wp_notif_table_name,
            array( 'content' => $get_current_content->content, 'is_active' => $get_current_content->is_active ),
            array( 'code' => $code ),
            array( '%s', '%d' )
        );

        return $res;
    }

    /**
     * @param   string  $code
     *
     * @return  array   Result or null if not found
     */
    public function get_content($code){
        global $wpdb;
        global $sidobe_wp_notif_table_name;

        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $sql = $wpdb->prepare( "SELECT * FROM $sidobe_wp_notif_table_name WHERE code = %s LIMIT 1", $code);
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.PreparedSQL.NotPrepared
        $res = $wpdb->get_row( $sql );

        return $res;
    }

    /**
     * @param   integer $offset
     * @param   integer $limit
     *
     * @return Array
     */
    public function get_contents($limit, $offset){
        global $wpdb;
        global $sidobe_wp_notif_table_name;

        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $sql = $wpdb->prepare( "SELECT * FROM $sidobe_wp_notif_table_name ORDER BY created_at DESC LIMIT %d OFFSET %d", $limit, $offset );
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.PreparedSQL.NotPrepared
        $res = $wpdb->get_results( $sql );

        return $res;
    }
}
?>
