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

<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <div class="sidobe-wp-row">
        <div class="sidobe-wp-col-8">
            <h2>Edit Template: <?php echo esc_html( $current_content['title'] ) ?></h2>
            <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
                <input type="hidden" name="action" value="handle_form_template">
                <input type="hidden" name="sidobe_wp_notif[code]" value="<?php echo esc_attr( $req_edit_template_code ) ?>">
                <?php wp_nonce_field( 'update_template_code_'.$req_edit_template_code ); ?>
                <table class="sidobe-wp-table-template" role="presentation">
                    <tbody>
                        <tr class="sidobe_wp_notif_row">
                            <td>
                                <?php
                                    $parse_db_content = null;

                                    if (!empty($current_content_db)) {
                                        if ($current_content_db->content != null) {
                                            $parse_db_content = $current_content_db->content;
                                        }
                                    };
                                ?>
                                <textarea name="sidobe_wp_notif[content]" id="sidobe_wp_notif[content]" class="sidobe-wp-input-template"><?php echo($parse_db_content != null) ? esc_textarea( $parse_db_content ) : null ?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php submit_button( __( 'Save Settings', 'sidobe-notification' ) ); ?>
            </form>
        </div>
        <div class="sidobe-wp-col-4">
            <?php require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/page_edit_template_sidebar.php'; ?>
        </div>
    </div>
</div>
