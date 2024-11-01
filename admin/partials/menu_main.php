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

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
	// check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'sidobe_wp_notif_main_messages', 'sidobe_wp_notif_message', __( 'Settings Saved', 'sidobe-notification' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'sidobe_wp_notif_main_messages' );
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
    <h2 class="nav-tab-wrapper">
        <a class="nav-tab nav-tab-active" id="woocommerce-tab" href="#woocommerce-tab">WooCommerce</a>
    </h2>
    <div id="woocommerce-tab" class="sidobe-wp-container-tab">
        <div class="sidobe-wp-loading-overlay" id="sidobe_loading_overlay">
            <div class="sidobe-spinner"></div>Loading...</div>
        <table class="widefat striped sidobe-wp-table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($template_contents as $key => $content) {
                    $current_content_db = $sidobe_db->get_content($content['code']);
                    ?>
                    <tr>
                    <td><?php echo esc_html( $content['title'] ) ?></td>
                    <td>
                        <label class="sidobe-wp-switch">
                            <input
                                class="sidobe-content-status"
                                type="checkbox"
                                name="<?php echo esc_attr( $content['code'] ) ?>"
                                <?php
                                    if (!empty($current_content_db)) {
                                         if ($current_content_db->is_active == '1') echo 'checked';
                                    }
                                ?>
                            >
                            <span class="sidobe-wp-slider round"></span>
                        </label>
                    </td>
                    <td>
                        <a href="admin.php?page=sidobe-wp-notif&template_code=<?php echo esc_attr( $content['code'] ) ?>"><span class="dashicons dashicons-edit"></span>Edit Template</a>
                    </td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
    </div>
      </form>
    </div>
</div>
