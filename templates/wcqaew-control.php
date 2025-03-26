<?php
// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>

<!-- Begin Plugin Settings Page -->
<div class="wrap">
    <!-- Page Title -->
    <h1><?php esc_html_e( 'WCQAEW EMI Settings', 'wcqaew-emi' ); ?></h1>
    
    <!-- Usage Instructions -->
    <p>
        <strong><?php esc_html_e( 'Usage:', 'wcqaew-emi' ); ?></strong>
        <?php esc_html_e( 'Use the shortcode', 'wcqaew-emi' ); ?>
        <code>[wcqaew_emi]</code>
        <?php esc_html_e( 'to display EMI plans on product pages.', 'wcqaew-emi' ); ?>
    </p>

    <!-- Begin Settings Form -->
    <form method="post" action="options.php">
        <?php 
        // Outputs nonce, action, and option_page fields for the settings group.
        settings_fields( 'wcqaew_emi_settings_group' ); 

        // Displays all settings sections and their fields for the settings group.
        do_settings_sections( 'wcqaew_emi_settings_group' ); 
        ?>

        <!-- Settings Table -->
        <table class="form-table">
            <!-- Design Mode Setting -->
            <tr>
                <th scope="row"><?php esc_html_e( 'Design Mode', 'wcqaew-emi' ); ?></th>
                <td>
                    <!-- Dropdown to select between Default and Custom design modes -->
                    <select name="wcqaew_emi_design_mode" id="wcqaew_emi_design_mode">
                        <option value="default" <?php selected( get_option('wcqaew_emi_design_mode', 'default'), 'default' ); ?>>
                            <?php esc_html_e( 'Default', 'wcqaew-emi' ); ?>
                        </option>
                        <option value="custom" <?php selected( get_option('wcqaew_emi_design_mode'), 'custom' ); ?>>
                            <?php esc_html_e( 'Custom', 'wcqaew-emi' ); ?>
                        </option>
                    </select>
                    <!-- Description for Design Mode -->
                    <p class="description">
                        <?php esc_html_e( 'Select', 'wcqaew-emi' ); ?>
                        <strong><?php esc_html_e( 'Custom', 'wcqaew-emi' ); ?></strong>
                        <?php esc_html_e( 'to apply your own colors.', 'wcqaew-emi' ); ?>
                    </p>
                </td>
            </tr>

            <!-- Block Background Color Setting -->
            <tr class="wcqaew-color-option">
                <th scope="row"><?php esc_html_e( 'Block Background Color', 'wcqaew-emi' ); ?></th>
                <td>
                    <!-- Input field for block background color -->
                    <input type="text" name="wcqaew_emi_background" 
                           value="<?php echo esc_attr( get_option( 'wcqaew_emi_background', '#ffffff' ) ); ?>" 
                           class="color-field" />
                </td>
            </tr>

            <!-- Text Color Setting -->
            <tr class="wcqaew-color-option">
                <th scope="row"><?php esc_html_e( 'Text Color', 'wcqaew-emi' ); ?></th>
                <td>
                    <!-- Input field for text color -->
                    <input type="text" name="wcqaew_emi_text_color" 
                           value="<?php echo esc_attr( get_option( 'wcqaew_emi_text_color', '#000000' ) ); ?>" 
                           class="color-field" />
                </td>
            </tr>

            <!-- Tooltip Background Color Setting -->
            <tr class="wcqaew-color-option">
                <th scope="row"><?php esc_html_e( 'Tooltip Background Color', 'wcqaew-emi' ); ?></th>
                <td>
                    <!-- Input field for tooltip background color -->
                    <input type="text" name="wcqaew_emi_tooltip_background" 
                           value="<?php echo esc_attr( get_option( 'wcqaew_emi_tooltip_background', '#555555' ) ); ?>" 
                           class="color-field" />
                </td>
            </tr>

            <!-- Tooltip Text Color Setting -->
            <tr class="wcqaew-color-option">
                <th scope="row"><?php esc_html_e( 'Tooltip Text Color', 'wcqaew-emi' ); ?></th>
                <td>
                    <!-- Input field for tooltip text color -->
                    <input type="text" name="wcqaew_emi_tooltip_text" 
                           value="<?php echo esc_attr( get_option( 'wcqaew_emi_tooltip_text', '#ffffff' ) ); ?>" 
                           class="color-field" />
                </td>
            </tr>

            <!-- Currency Mode Setting -->
            <tr>
                <th scope="row"><?php esc_html_e( 'Currency Mode', 'wcqaew-emi' ); ?></th>
                <td>
                    <!-- Dropdown to select currency mode (default WooCommerce or custom symbol) -->
                    <select name="wcqaew_emi_currency_mode" id="wcqaew_emi_currency_mode">
                        <option value="default" <?php selected( get_option('wcqaew_emi_currency_mode', 'default'), 'default' ); ?>>
                            <?php esc_html_e( 'Default (WooCommerce Currency)', 'wcqaew-emi' ); ?>
                        </option>
                        <option value="custom" <?php selected( get_option('wcqaew_emi_currency_mode'), 'custom' ); ?>>
                            <?php esc_html_e( 'Custom Symbol', 'wcqaew-emi' ); ?>
                        </option>
                    </select>
                    <!-- Description for Currency Mode -->
                    <p class="description">
                        <?php esc_html_e( 'Select', 'wcqaew-emi' ); ?>
                        <strong><?php esc_html_e( 'Custom', 'wcqaew-emi' ); ?></strong>
                        <?php esc_html_e( 'to use your own currency symbol.', 'wcqaew-emi' ); ?>
                    </p>
                </td>
            </tr>

            <!-- Custom Currency Symbol Setting -->
            <tr class="wcqaew-currency-custom">
                <th scope="row"><?php esc_html_e( 'Custom Currency Symbol', 'wcqaew-emi' ); ?></th>
                <td>
                    <!-- Input field for custom currency symbol -->
                    <input type="text" name="wcqaew_emi_currency_symbol" 
                           value="<?php echo esc_attr( get_option( 'wcqaew_emi_currency_symbol', 'BDT' ) ); ?>" 
                           class="regular-text" 
                           placeholder="<?php esc_attr_e( '৳, BDT, $, Rs', 'wcqaew-emi' ); ?>" />
                </td>
            </tr>
        </table>

        <!-- Submit Button -->
        <?php submit_button(); ?>
    </form>
    <!-- End of Settings Form -->
</div>
<!-- End Plugin Settings Page -->