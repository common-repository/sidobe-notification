<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://sidobe.com
 * @since      1.0.0
 *
 * @package    Sidobe_Wp_Notif
 * @subpackage Sidobe_Wp_Notif/admin/partials
 */

?>

<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
	// check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'sidobe_wp_notif_options_messages', 'sidobe_wp_notif_message', __( 'Settings Saved', 'sidobe-notification' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'sidobe_wp_notif_options_messages' );
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'sidobe_wp_notif_form_options' );
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'sidobe-wp-notif-options' );
        // output save settings button
        submit_button( __( 'Save Settings', 'sidobe-notification' ) );
        ?>
      </form>
    </div>
</div>
