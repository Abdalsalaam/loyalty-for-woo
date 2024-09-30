<?php
/**
 * Plugin Name: Customer Loyalty and Rewards Program for WooCommerce
 * Plugin URI: #
 * Description: Powerful tool to enhance customer retention, drive repeat purchases.
 * Version: 1.0.0
 * Author: Lvendr, Inc.
 * Author URI: https://lvendr.com
 * Developer: Abdalsalaam Halawa
 * Developer URI: https://github.com/abdalsalaam/
 * Text Domain: loyalty-for-woo
 * Domain Path: /languages
 * Requires Plugins: woocommerce
 * WC requires at least: 9.2
 * WC tested up to: 9.3
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace LoyaltyForWoo;

defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * Plugin initialization.
 *
 * @return void
 */
function loyalty_for_woo_init() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'LoyaltyForWoo\\loyalty_for_woo_woocommerce_required' );

		return;
	}

	$main_instance = Main::instance();
	// Plugin logic.
}

add_action( 'plugins_loaded', 'LoyaltyForWoo\\loyalty_for_woo_init', 10 );

/**
 * WooCommerce is not active notice.
 */
function loyalty_for_woo_woocommerce_required() {
	echo '<div class="notice error"><p>' . sprintf( esc_html__( 'Customer Loyalty and Rewards Program requires %1sWooCommerce%2s plugin.' ), '<a target="_blank" href="https://woocommerce.com/">', '</a>' ) . '</p></div>';
}
