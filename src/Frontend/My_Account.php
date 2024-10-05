<?php
/**
 * My_Account Class file.
 *
 * @package Lvendr/LoyaltyForWoo
 */

namespace LoyaltyForWoo\Frontend;

defined( 'ABSPATH' ) || exit;

/**
 * My_Account Class.
 *
 * @package Lvendr/LoyaltyForWoo
 */
class My_Account {
	/**
	 * Main instance.
	 */
	protected static $_instance = null;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Main Instance.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Getting everything ready to run.
	 *
	 * @return void
	 */
	private function init() {
		$this->init_hooks();
	}

	/**
	 * Hooks init.
	 *
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'init', array( $this, 'register_endpoints' ) );
		add_filter( 'woocommerce_account_menu_items', array( $this, 'add_points_history_tab' ), 10, 1 );
		add_filter( 'woocommerce_account_lfw-points-history_endpoint', array( $this, 'points_history_tab_content' ) );
	}

	/**
	 * Register Endpoints.
	 *
	 * @return void.
	 */
	public function register_endpoints() {
		add_rewrite_endpoint( 'lfw-points-history', EP_ROOT | EP_PAGES );
	}

	/**
	 * Add points history navigation item.
	 *
	 * @param array $items Original my account navigation items.
	 *
	 * @return array Modified navigation items.
	 */
	public function add_points_history_tab( array $items ) {
		$logout_item = $items['customer-logout'];
		unset( $items['customer-logout'] );
		$items['lfw-points-history'] = esc_html__( 'Points History', 'loyalty-for-woocommerce' );
		$items['customer-logout']    = $logout_item;

		return $items;
	}

	/**
	 * Points History HTML.
	 *
	 * @return void
	 */
	public function points_history_tab_content() {
		echo 'Hello its me!';
	}
}
