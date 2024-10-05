<?php
/**
 * Main Class file.
 *
 * @package Lvendr/LoyaltyForWoo
 */

namespace LoyaltyForWoo;

defined( 'ABSPATH' ) || exit;

/**
 * Main Class.
 *
 * @package Lvendr/LoyaltyForWoo
 */
class Main {
	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	private $version = '1.0.0';

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
		add_action( 'before_woocommerce_init', array( $this, 'HPOS_compatibility_declaration' ) );
	}

	/**
	 * HPOS compatibility declaration.
	 *
	 * @return void
	 */
	public function HPOS_compatibility_declaration() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', LFW_PLUGIN_FILE, true );
		}
	}
}
