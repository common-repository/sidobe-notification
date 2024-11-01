<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="sidobe-wp-sidebar">
    <div class="sidobe-wp-sidebar-title">List Shortcode</div>
    <div class="sidobe-wp-sidebar-content">
        <table class="widefat striped">
            <tbody>
                <?php
                    foreach ($wc_shortcodes as $key => $shortcode) {
                        ?>
                        <tr>
                            <td><?php echo esc_html( $shortcode[0] ) ?></td>
                            <td><?php echo esc_html( $shortcode[2] ) ?></td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
