<?php

declare(strict_types = 1);

namespace NineteenEightyFour\NineteenEightyWoo\Hooks;

use NineteenEightyFour\NineteenEightyWoo\Config;
use WP_Error;
use WC_Checkout;
use WC_Customer;
use WC_Order;

/**
 * The Kennitala Field hook class
 *
 * This adds a kennitala field to the checkout form and assigns it to the order.
 *
 * We have to add the kennitala field to three different places and handle them
 * differently each time. First of all, it's the "classic" shortcode based
 * checkout form and then there's the more recent block-based checkout form.
 *
 * The third one is the user profile editor.
 *
 * It's not nice (or cheap) having to do things three times over during a
 * transition period like that, but it's not like Gutenberg hasn't been out for
 * 6 years already!
 */
class KennitalaField {
	const KENNITALA_PATTERN = '^(([0-9]{10})|([0-9]{6}(-|\s)[0-9]{4}))$';

	/**
	 * The class constructor, obviously
	 */
	public function __construct() {
		if ( true === Config::get_kennitala_classic_field_enabled() ) {
			add_action(
				'woocommerce_before_checkout_billing_form',
				array( __CLASS__, 'render_classic_checkout_field' ),
				10,
				1
			);

			add_action(
				'woocommerce_checkout_process',
				array( __CLASS__, 'check_classic_checkout_field' ),
				10,
				0
			);

			add_action(
				'woocommerce_checkout_update_order_meta',
				array( __CLASS__, 'save_classic_checkout_field' ),
				10,
				1
			);

			add_filter(
				'woocommerce_order_get_formatted_billing_address',
				array( __CLASS__, 'add_kennitala_to_formatted_billing_address' ),
				10,
				3
			);
		}

		if (
			true === function_exists(
				'__experimental_woocommerce_blocks_register_checkout_field'
			) &&
			true === Config::get_kennitala_block_field_enabled()
		) {
			add_action(
				'woocommerce_blocks_loaded',
				array( __CLASS__, 'register_block_checkout_field' ),
				10,
				0
			);

			add_action(
				'woocommerce_store_api_checkout_order_processed',
				array( __CLASS__, 'add_order_kennitala_to_the_customer_from_api' ),
				10,
				1
			);
		}

		add_action(
			'woocommerce_checkout_order_processed',
			array( __CLASS__, 'add_order_kennitala_to_the_customer' ),
			10,
			3
		);

		add_filter(
			'woocommerce_customer_meta_fields',
			array( __CLASS__, 'add_field_to_user_profile' ),
		);
	}

	/**
	 * Add a kennitala field to the user profile page
	 *
	 * This is used for the `woocommerce_customer_meta_fields` filter and adds
	 * the kennitala field to the "billing" section of the WooCommerce fields
	 * in the user profile editor.
	 *
	 * @param array $fields The original fields as they enter the
	 *                      `woocommerce_customer_meta_fields` filter.
	 */
	public static function add_field_to_user_profile( array $fields ): array {
		$billing = array_merge(
			array_slice( $fields['billing']['fields'], 0, 2 ),
			array(
				'kennitala' => array(
					'label'       => __( 'Kennitala', 'NineteenEightyWoo' ),
					'description' => '',
				),
			),
			array_slice( $fields['billing']['fields'], 2 )
		);

		$new_fields = $fields;

		$new_fields['billing']['fields'] = $billing;

		return $new_fields;
	}

	/**
	 * Add a the kennitala from an order to the order's customer record
	 *
	 * This is used for the `woocommerce_checkout_order_processed` action hook
	 * for assigning the kennitala from a newly created order automatically to
	 * the releavant customer record on creation.
	 *
	 * @param int      $order_id The order id (unused).
	 * @param array    $posted_data The default set of posted order data (unused).
	 * @param WC_Order $order The order object we are working with.
	 *
	 * @return bool True if the kennitala has been assigned to a user record,
	 *              false if it hasn't (for any reason).
	 */
	public static function add_order_kennitala_to_the_customer(
		int $order_id,
		array $posted_data,
		WC_Order $order
	): bool {
		$customer_id = $order->get_customer_id();

		if ( 0 === $customer_id ) {
			return false;
		}

		$order_kennitala = $order->get_meta( 'billing_kennitala', true );

		if ( false === empty( $order_kennitala ) ) {
			$customer = new WC_Customer( $customer_id );

			$customer->add_meta_data(
				'kennitala',
				$order_kennitala,
				true
			);
			$customer->save_meta_data();

			return true;
		}

		return false;
	}

	/**
	 * Add a the kennitala from an order to the order's customer record when
	 * submitted via the JSON API
	 *
	 * This is the JSON API transplant of the above
	 * `add_order_kennitala_to_the_customer()` function and uses the
	 * `woocommerce_store_api_checkout_order_processed` hook.
	 *
	 * @param WC_Order $order The order being submitted.
	 */
	public static function add_order_kennitala_to_the_customer_from_api(
		WC_Order $order
	): bool {
		$customer_id = $order->get_customer_id();

		if ( 0 === $customer_id ) {
			return false;
		}

		$additional_fields = $order->get_meta(
			'_additional_billing_fields',
			true
		);

		if (
			false === array_key_exists(
				'1984_woo_dk/kennitala',
				$additional_fields,
			)
		) {
			return false;
		}

		$order_kennitala = $additional_fields['1984_woo_dk/kennitala'];

		if ( false === empty( $order_kennitala ) ) {
			$customer = new WC_Customer( $customer_id );

			$customer->add_meta_data(
				'kennitala',
				$order_kennitala,
				true
			);
			$customer->save_meta_data();

			return true;
		}

		return false;
	}

	/**
	 * Add a formated kennitala to a formatted billing address
	 *
	 * This is for the `woocommerce_order_get_formatted_billing_address` hook
	 * and adds a kennitala line to the formatted address as the 2nd line of
	 * the billing address.
	 *
	 * @param string   $address_data The original string containing the
	 *                               formatted address.
	 * @param array    $raw_address The address elements as an array (unused).
	 * @param WC_Order $order The order object we pick the kennitala meta from.
	 */
	public static function add_kennitala_to_formatted_billing_address(
		string $address_data,
		array $raw_address,
		WC_Order $order
	): string {
		$kennitala = $order->get_meta( 'billing_kennitala', true );

		if ( true === empty( $kennitala ) ) {
			return $address_data;
		}

		$formatted_kennitala = self::format_kennitala( $kennitala );

		$formatted_array = explode( '<br/>', $address_data );

		return implode(
			'<br/>',
			array_merge(
				array_slice( $formatted_array, 0, 1 ),
				array( 'Kt. ' . $formatted_kennitala ),
				array_slice( $formatted_array, 1 )
			)
		);
	}

	/**
	 * Render a kennitala field in the shortcode based checkout page
	 *
	 * @param WC_Checkout $checkout The checkout object we get the
	 *                              customer ID from.
	 */
	public static function render_classic_checkout_field(
		WC_Checkout $checkout
	): void {
		$customer_id = $checkout->get_value( 'id' );
		if ( 0 !== $customer_id ) {
			$customer  = new WC_Customer( $customer_id );
			$kennitala = $customer->get_meta( 'kennitala', true );
		} else {
			$kennitala = '';
		}

		woocommerce_form_field(
			'billing_kennitala',
			array(
				'type'              => 'text',
				'label'             => __( 'Kennitala', 'NineteenEightyWoo' ),
				'id'                => '1984_woo_dk_checkout_kennitala',
				'custom_attributes' => array(
					'pattern' => self::KENNITALA_PATTERN,
				),
			),
			self::format_kennitala( $kennitala )
		);
	}

	/**
	 * Validate the kennitala input from the shortcode-based checkout page
	 *
	 * A nonce verification is not required here as WooCommerce has already
	 * taken care of that for us at this point.
	 */
	public static function check_classic_checkout_field(): void {
		// phpcs:ignore WordPress.Security.NonceVerification
		if ( true === isset( $_POST['kennitala'] ) ) {

			$kennitala = sanitize_text_field(
				// phpcs:ignore WordPress.Security.NonceVerification
				wp_unslash( $_POST['kennitala'] )
			);

			$sanitized_kennitala = self::sanitize_kennitala( $kennitala );

			if ( '' !== $sanitized_kennitala ) {
				return;
			}

			$validation = self::validate_kennitala( $sanitized_kennitala );

			if ( $validation instanceof WP_Error ) {
				wc_add_notice(
					$validation->get_error_message(),
					'error'
				);
			}
		}
	}

	/**
	 * Save the kennitala from the block-based checkout process
	 *
	 * This is used by the `woocommerce_checkout_update_order_meta` hook.
	 *
	 * A nonce verification is not required here as WooCommerce has already
	 * taken care of that for us at this point.
	 *
	 * @param int $order_id The order id.
	 */
	public static function save_classic_checkout_field( int $order_id ): void {
		$order = new WC_Order( $order_id );

		// phpcs:ignore WordPress.Security.NonceVerification
		if ( true === isset( $_POST['billing_kennitala'] ) ) {
			$kennitala = sanitize_text_field(
				// phpcs:ignore WordPress.Security.NonceVerification
				wp_unslash( $_POST['billing_kennitala'] )
			);

			$sanitized_kennitala = self::sanitize_kennitala( $kennitala );

			$order->update_meta_data(
				'billing_kennitala',
				$sanitized_kennitala
			);

			$order->save();
		}
	}

	/**
	 * Register a kennitala checkout field for the block-based checkout page
	 *
	 * WooCommerce 8.7 adds a new block-based checkout page. This renders
	 * previously used ways of adding extra fields such as one for the Icelandic
	 * Kennitala pretty much useless.
	 *
	 * Running this function using the `woocommerce_blocks_loaded` hook adds
	 * a kennitala field to the block-based checkout page.
	 *
	 * @link https://github.com/woocommerce/woocommerce/blob/trunk/plugins/woocommerce-blocks/docs/third-party-developers/extensibility/checkout-block/additional-checkout-fields.md
	 */
	public static function register_block_checkout_field(): void {
		if (
			true === function_exists(
				'__experimental_woocommerce_blocks_register_checkout_field'
			)
		) {
			__experimental_woocommerce_blocks_register_checkout_field(
				array(
					'id'                => '1984_woo_dk/kennitala',
					'label'             => __(
						'Kennitala',
						'NineteenEightyWoo'
					),
					'optionalLabel'     => __(
						'Kennitala (Optional)',
						'NineteenEightyWoo'
					),
					'location'          => 'address',
					'type'              => 'text',
					'sanitize_callback' => array(
						__CLASS__,
						'sanitize_kennitala',
					),
					'validate_callback' => array(
						__CLASS__,
						'validate_kennitala',
					),
					'attributes'        => array(
						'autocomplete' => 'kennitala',
						'pattern'      => self::KENNITALA_PATTERN,
					),
				)
			);
		}
	}

	/**
	 * Sanitize the kennitala input
	 *
	 * Kennitala is a 10-digit numeric string. This strips everything but
	 * numbers from the provided string and returns only the numbers from it.
	 *
	 * @param string $kennitala The unsanitized kennitala.
	 *
	 * @return string The sanitized kennitala.
	 */
	public static function sanitize_kennitala( string $kennitala ): string {
		return preg_replace( '/[^0-9]/', '', $kennitala );
	}

	/**
	 * Validate kennitala input
	 *
	 * @param string $kennitala The (hopefully sanitized) kennitala.
	 *
	 * @return ?WP_Error A WP_Error object is generated if the kennitala
	 *                   is invalid, containing a code and a further explainer.
	 */
	public static function validate_kennitala( string $kennitala ): null|WP_Error {
		if (
			0 === preg_match_all(
				'/' . self::KENNITALA_PATTERN . '/',
				$kennitala
			)
		) {
			return new WP_Error(
				'invalid_kennitala',
				__(
					'Invalid kennitala. A kennitala is a string of 10 numeric characters.',
					'NineteenEightyWoo'
				),
			);
		}

		return null;
	}

	/**
	 * Format a kennitala string
	 *
	 * This simply adds a divider between the birthdate portion and the rest of
	 * the kennitala. The default is a dash.
	 *
	 * @param string $kennitala The original, sanitized, unformatted kennitala.
	 * @param string $divider The divider to use (defaults to `-`).
	 */
	public static function format_kennitala(
		string $kennitala,
		string $divider = '-'
	): string {
		$first_six = substr( $kennitala, 0, 6 );
		$last_four = substr( $kennitala, 6, 4 );

		return $first_six . $divider . $last_four;
	}
}
