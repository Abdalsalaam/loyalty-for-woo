<?php
/**
 * Main Class file.
 *
 * @package Lvendr/LoyaltyForWoo
 */

namespace LoyaltyForWoo;

use LoyaltyForWoo\Settings\Settings_Section;

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
	 * Plugin Settings.
	 *
	 * @var Settings_Section
	 */
	public static Settings_Section $settings;

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
		$this->get_plugin_settings();

		if ( ! self::$settings->is_loyalty_feature_enabled() ) {
			return;
		}

		$this->get_frontend();
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

	/**
	 * Get plugin settings instance.
	 *
	 * @return Settings_Section
	 */
	private function get_plugin_settings() {
		if ( empty( self::$settings ) ) {
			self::$settings = new Settings_Section();
		}

		return self::$settings;
	}

	/**
	 * Get plugin frontend.
	 */
	private function get_frontend() {
		Frontend\My_Account::instance();
	}
}
