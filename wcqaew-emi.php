<?php
/**
 * Plugin Name: WCQ Automatic EMI Calculation for WooCommerce
 * Plugin URI:  https://github.com/sakibstime/wcqaew-emi
 * Description: Displays automatically calculated EMI plans on WooCommerce product pages via a shortcode or hook. EMI is based on the product's regular price.
 * Version:     2.0
 * Author:      Md. Sohanur Rahman Sakib
 * Author URI:  https://sakibsti.me/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: wcqaew-emi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



/**
 * Adds a Settings link to the plugin action links on the Plugins page.
 *
 * This function adds a link to the plugin's settings page and ensures it appears
 * before the Deactivate link.
 *
 * @param array $links The existing plugin action links.
 * @return array Modified plugin action links with the settings link added.
 */
function wcqaew_add_plugin_settings_link( $links ) {
    // Build the URL for the settings page.
    $settings_url = admin_url( 'options-general.php?page=wcqaew-emi-settings' );
    
    // Create the settings link.
    $settings_link = '<a href="' . esc_url( $settings_url ) . '">' . esc_html__( 'Settings', 'wcqaew-emi' ) . '</a>';
    
    // Add the settings link to the beginning of the links array.
    array_unshift( $links, $settings_link );
    
    return $links;
}

// Apply the filter to add the link for this specific plugin.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wcqaew_add_plugin_settings_link' );

// Check if the main plugin class already exists.
if ( ! class_exists( 'WCQAEW_EMI' ) ) {

	class WCQAEW_EMI {

		/**
		 * Constructor.
		 *
		 * Sets up shortcodes, enqueues scripts and styles, adds admin menu items,
		 * registers settings, and hooks up the plugin functions.
		 */
		public function __construct() {
			// Register the shortcode that outputs EMI details.
			add_shortcode( 'wcqaew_emi', array( $this, 'render_shortcode' ) );

			// Enqueue front-end styles for the EMI display.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

			// Insert the EMI details into the WooCommerce single product summary.
			add_action( 'woocommerce_single_product_summary', array( $this, 'render_emi_html' ), 25 );

			// Add an admin submenu for the plugin settings.
			add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

			// Register plugin settings when the admin initializes.
			add_action( 'admin_init', array( $this, 'register_settings' ) );

			// Enqueue admin scripts (e.g., the WordPress color picker).
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_color_picker' ) );
		}

		/**
		 * Enqueue front-end styles.
		 *
		 * Loads the plugin CSS and adds inline styles if the "custom" design mode is selected.
		 */
		public function enqueue_styles() {
			wp_enqueue_style(
				'wcqaew-emi-style', // Handle.
				plugin_dir_url( __FILE__ ) . 'assets/css/styles.css', // CSS file URL.
				array(), // Dependencies.
				'1.0' // Version.
			);

			// Retrieve the design mode setting.
			$design_mode = get_option( 'wcqaew_emi_design_mode', 'default' );

			// If custom design mode is enabled, inline custom CSS is added.
			if ( 'custom' === $design_mode ) {
				$background   = esc_attr( get_option( 'wcqaew_emi_background', '#ffffff' ) );
				$text_color   = esc_attr( get_option( 'wcqaew_emi_text_color', '#000000' ) );
				$tooltip_bg   = esc_attr( get_option( 'wcqaew_emi_tooltip_background', '#555555' ) );
				$tooltip_text = esc_attr( get_option( 'wcqaew_emi_tooltip_text', '#ffffff' ) );

				$custom_css = "
					.wcqaew-emi-container {
						background: {$background};
						color: {$text_color};
						padding: 10px;
						border-radius: 5px;
						display: inline-block;
					}
					.wcqaew-emi-tooltip .wcqaew-emi-tooltiptext {
						background: {$tooltip_bg};
						color: {$tooltip_text};
					}
					.wcqaew-emi-tooltip .wcqaew-emi-tooltiptext::after {
						border-color: {$tooltip_bg} transparent transparent transparent;
					}
				";

				wp_add_inline_style( 'wcqaew-emi-style', $custom_css );
			}
		}

		/**
		 * Render the EMI shortcode.
		 *
		 * Retrieves the current WooCommerce product, calculates EMI amounts for several plans,
		 * and outputs the formatted HTML for the EMI offer.
		 *
		 * @return string HTML output for the shortcode.
		 */
		public function render_shortcode() {
			global $product;
			$current_product = null;

			// Determine the current product.
			if ( is_product() && $product instanceof WC_Product ) {
				$current_product = $product;
			} else {
				$product_id = get_the_ID();
				$current_product = wc_get_product( $product_id );
			}

			// If no valid product is found, return an empty string.
			if ( ! $current_product instanceof WC_Product ) {
				return '';
			}

			// Get the product's regular price.
			$price = floatval( $current_product->get_regular_price() );
			if ( ! $price ) {
				return '';
			}

			// Define available EMI plans (in months).
			$months = array( 3, 6, 9, 12 );
			$tooltip_text = '';

			// Retrieve currency settings.
			$currency_mode = get_option( 'wcqaew_emi_currency_mode', 'default' );
			$currency_symbol = ( 'custom' === $currency_mode )
				? esc_html( get_option( 'wcqaew_emi_currency_symbol', 'BDT' ) )
				: get_woocommerce_currency_symbol();

			// Calculate EMI for each plan and build the tooltip text.
			foreach ( $months as $m ) {
				$emi = round( $price / $m );
				$tooltip_text .= esc_html( $currency_symbol ) . ' ' . esc_html( $emi ) . ' for ' . esc_html( $m ) . ' month' . ( $m > 1 ? 's' : '' ) . '<br>';
			}

			// Allow only <br> tags for the tooltip text.
			$tooltip_text = wp_kses( $tooltip_text, array( 'br' => array() ) );

			// Buffer the output.
			ob_start();
			?>
			<div class="wcqaew-emi-container">
				Avail EMI Offer
				<span class="wcqaew-emi-tooltip">View Plans
					<span class="wcqaew-emi-tooltiptext"><?php echo wp_kses_post( $tooltip_text ); ?></span>
				</span>
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * Output the EMI HTML.
		 *
		 * Simply echoes the shortcode output.
		 */
		public function render_emi_html() {
			echo wp_kses_post( $this->render_shortcode() );
		}

		/**
		 * Add the plugin settings page to the admin menu.
		 *
		 * Creates a submenu under the "Settings" menu.
		 */
		public function add_admin_menu() {
			add_submenu_page(
				'options-general.php', // Parent menu slug.
				__( 'WCQAEW EMI Settings', 'wcqaew-emi' ), // Page title.
				__( 'WCQAEW EMI Settings', 'wcqaew-emi' ), // Menu title.
				'manage_options', // Capability required.
				'wcqaew-emi-settings', // Menu slug.
				array( $this, 'settings_page' ) // Function to display the settings page.
			);
		}

		/**
		 * Register plugin settings.
		 *
		 * PluginCheck Warning Note:
		 * The following sanitization callbacks are hard-coded literal strings.
		 * Although PluginCheck may still flag these as dynamic arguments,
		 * they are not dynamically generated. This is a false positive.
		 * We are using 'sanitize_text_field' as the sanitization callback to
		 * ensure that all user input is properly sanitized.
		 */
		public function register_settings() {
			register_setting(
				'wcqaew_emi_settings_group',
				'wcqaew_emi_design_mode',
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			register_setting(
				'wcqaew_emi_settings_group',
				'wcqaew_emi_background',
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			register_setting(
				'wcqaew_emi_settings_group',
				'wcqaew_emi_text_color',
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			register_setting(
				'wcqaew_emi_settings_group',
				'wcqaew_emi_tooltip_background',
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			register_setting(
				'wcqaew_emi_settings_group',
				'wcqaew_emi_tooltip_text',
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			register_setting(
				'wcqaew_emi_settings_group',
				'wcqaew_emi_currency_mode',
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			register_setting(
				'wcqaew_emi_settings_group',
				'wcqaew_emi_currency_symbol',
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
		}

		/**
		 * Enqueue admin scripts and styles.
		 *
		 * Loads the WordPress color picker and related custom scripts.
		 */
		public function enqueue_admin_color_picker() {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script(
				'wp-color-picker-alpha',
				plugin_dir_url( __FILE__ ) . 'assets/js/wp-color-picker-alpha.min.js',
				array( 'wp-color-picker' ),
				'1.0',
				true
			);
			wp_enqueue_script(
				'wcqaew-color-picker',
				plugin_dir_url( __FILE__ ) . 'assets/js/wcqaew-emi-admin.js',
				array( 'wp-color-picker-alpha' ),
				false,
				true
			);
		}

		/**
		 * Render the settings page.
		 *
		 * Includes the settings template file.
		 */
		public function settings_page() {
			include plugin_dir_path( __FILE__ ) . 'templates/wcqaew-control.php';
		}
	}

	// Instantiate the plugin class.
	new WCQAEW_EMI();
}