<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sidobe_Wp_Notif
 * @subpackage Sidobe_Wp_Notif/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Sidobe_Wp_Notif
 * @subpackage Sidobe_Wp_Notif/includes
 * @author     Sidobe <help@sidobe.com>
 */
class Sidobe_Wp_Notif_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        $act = new Sidobe_Wp_Notif_Activator;
        $act->init_db();
	}

    /**
     * Docs: https://codex.wordpress.org/Creating_Tables_with_Plugins
     */
    function init_db(){
        global $wpdb;
        global $sidobe_wp_notif_db_version;
        global $sidobe_wp_notif_table_name;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $sidobe_wp_notif_table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            code varchar(55),
            content longtext,
            is_active boolean,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );

        add_option( 'sidobe_wp_notif_db_version', $sidobe_wp_notif_db_version );
    }

}
