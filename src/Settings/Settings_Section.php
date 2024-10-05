<?php
/**
 * Settings Class file.
 *
 * @package Lvendr/LoyaltyForWoo
 */

namespace LoyaltyForWoo\Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Settings Class.
 *
 * @package Lvendr/LoyaltyForWoo
 */
class Settings_Section {
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
		add_filter( 'woocommerce_get_sections_account', array( $this, 'add_section' ), 10 );
		add_filter( 'woocommerce_get_settings_account', array( $this, 'setting_fields' ), 10, 2 );
	}

	/**
	 * Plugin Settings.
	 *
	 * @param array $sections The sections for this settings page.
	 */
	public function add_section( array $sections ) {
		$sections['loyalty-for-woo'] = esc_html__( 'Customer Loyalty and Rewards', 'loyalty-for-woo' );
		return $sections;
	}

	/**
	 * @param $settings array Original setting fields array.
	 * @param $section string Current section.
	 *
	 * @return array Modified settings array.
	 */
	public function setting_fields( $settings, $section ) {
		if ( 'loyalty-for-woo' !== $section ) {
			return $settings;
		}

		$currency_symbol = get_woocommerce_currency_symbol();

		$settings = array(
			array(
				'name' => esc_html__( 'Customer Loyalty and Rewards Settings', 'loyalty-for-woo' ),
				'type' => 'title',
				'desc' => '',
				'id'   => 'lfw_section_title',
			),
			array(
				'name'    => esc_html__( 'Enable Loyalty Program', 'loyalty-for-woo' ),
				'type'    => 'checkbox',
				'desc'    => esc_html__( 'Enable or Disable the loyalty program feature.', 'loyalty-for-woo' ),
				'id'      => 'lfw_enable_loyalty',
				'default' => 'yes',
			),
			array(
				'name'              => sprintf( esc_html__( 'Points per %s spent.', 'loyalty-for-woo' ), $currency_symbol ),
				'type'              => 'number',
				'desc'              => sprintf( esc_html__( 'How many points the customer will get for every %s spent.', 'loyalty-for-woo' ), $currency_symbol ),
				'id'                => 'lfw_points_per_dollar',
				'custom_attributes' => array(
					'step' => 1,
					'min'  => 1,
				),
			),
			array(
				'name' => esc_html__( 'Allow Points to Redeem Coupons', 'loyalty-for-woo' ),
				'type' => 'checkbox',
				'desc' => esc_html__( 'Allow customer to redeem collected points for coupons.', 'loyalty-for-woo' ),
				'id'   => 'lfw_allow_coupon_redemption',
			),
			array(
				'name'    => esc_html__( 'Coupon Prefix', 'loyalty-for-woo' ),
				'type'    => 'text',
				'desc'    => esc_html__( 'Enter a prefix for generated coupon codes.', 'loyalty-for-woo' ),
				'id'      => 'lfw_coupon_prefix',
				'default' => 'lfw_'
			),
			array(
				'type' => 'sectionend',
				'id'   => 'lfw_section_end',
			)
		);

		/**
		 * Filter Customer Loyalty and Rewards Settings.
		 *
		 * @param array $settings Setting fields array.
		 */
		return apply_filters( 'lfw_get_settings', $settings );
	}

	/**
	 * Check if loyalty program is enabled.
	 *
	 * @return bool True if enabled.
	 */
	public function is_loyalty_feature_enabled() {
		return 'yes' === get_option( 'lfw_enable_loyalty' );
	}
}
