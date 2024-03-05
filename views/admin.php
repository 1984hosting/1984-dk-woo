<?php

declare(strict_types = 1);

$payment_gateways = new WC_Payment_Gateways();

?>
<div
	class="wrap ninteen-eighty-woo-wrap"
	id="ninteen-eighty-woo-wrap"
>
	<form id="ninteen-eighty-woo-settings-form" class="type-form">
		<h1 class="wp-heading-inline">
			<?php esc_html_e( '1984 dkPlus Connection', 'NinteenEightyWoo' ); ?>
		</h1>
		<section class="section">
			<h2><?php esc_html_e( 'Authentication', 'NinteenEightyWoo' ); ?></h2>
			<table id="api-key-form-table" class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="ninteen-eighty-woo-key-input">
								<?php esc_html_e( 'API Key', 'NinteenEightyWoo' ); ?>
							</label>
						</th>
						<td>
							<input
								id="ninteen-eighty-woo-key-input"
								class="regular-text api-key-input"
								name="api_key"
								type="text"
								value="<?php echo esc_attr( get_option( '1984_woo_api_key' ) ); ?>"
							/>
							<p class="description">
								<?php
								esc_html_e(
									'The API key is provided by DK for use with the dkPlus API. Do not share this key with anyone.',
									'NinteenEightyWoo'
								)
								?>
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</section>

		<section class="section">
			<h2><?php esc_html_e( 'WooCommerce Payment Gateways and DK Payment Methods IDs', 'NinteenEightyWoo' ); ?></h2>
			<p><?php esc_html_e( 'Please enter the Payment Method ID and Name for each payment gateway as it appears in DK:', 'NinteenEightyWoo' ); ?></p>
			<table id="payment-gateway-id-map-table" class="form-table">
				<tbody>
					<?php foreach ( $payment_gateways->payment_gateways as $p ) : ?>
					<tr data-gateway-id="<?php echo esc_attr( $p->id ); ?>">
						<th span="row" class="column-title column-primary">
							<span class="payment-gateway-title"><?php echo esc_html( $p->title ); ?></span>
							<?php if ( 'yes' === $p->enabled ) : ?>
							<span class="payment-gateway-status enabled">
								<?php esc_html_e( 'Enabled in WC', 'NinteenEightyWoo' ); ?>
							</span>
							<?php else : ?>
							<span class="payment-gateway-status enabled">
								<?php esc_html_e( 'Disabled in WC', 'NinteenEightyWoo' ); ?>
							</span>
							<?php endif ?>
						</th>
						<td class="method-id">
							<label for="payment_id_input_<?php echo esc_attr( $p->id ); ?>">
								<?php esc_html_e( 'Method ID', 'NinteenEightyWoo' ); ?>
							</label>
							<input
								id="payment_id_input_<?php echo esc_attr( $p->id ); ?>"
								class="regular-text payment-id"
								name="payment_id"
								type="text"
							/>
						</td>
						<td>
							<label for="payment_name_input_<?php echo esc_attr( $p->id ); ?>">
								<?php esc_html_e( 'DK Payment Method Name', 'NinteenEightyWoo' ); ?>
							</label>
							<input
								id="payment_name_input_<?php echo esc_attr( $p->id ); ?>"
								class="regular-text payment-name"
								name="payment_name"
								value="<?php echo esc_attr( get_option( '1984_woo_payment_name_' . $p->id, $p->title ) ); ?>"
								type="text"
							/>
						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>

			<p>
				<?php
				echo sprintf(
					// Translators: %1$s stands for the opening and %2$s <a> tag in a hyperlink to the WooCommerce Payment Settings page.
					esc_html( __( 'The payment gateways themselves are handled by your WooCommerce Settings, under %1$sthe Payments Section%2$s.', 'NinteenEightyWoo' ) ),
					'<a href="' . esc_url( admin_url( '?page=wc-settings&tab=checkout ' ) ) . '">',
					'</a>'
				);
				?>
			</p>
		</section>

		<div class="submit-container">
			<img
				id="ninteen-eighty-woo-settings-loader"
				class="loader hidden"
				src="<?php echo esc_url( get_admin_url() . 'images/wpspin_light-2x.gif' ); ?>"
				width="32"
				height="32"
			/>
			<input
				type="submit"
				value="<?php esc_attr_e( 'Save', 'NinteenEightyWoo' ); ?>"
				class="button button-primary button-hero"
				id="ninteen-eighty-woo-settings-submit"
			/>
		</div>
	</form>

	<div id="ninteen-eighty-four-logo-container">
		<p>
			<?php
			esc_html_e(
				'The 1984 dkPlus Connection Plugin for WooCommerce is developed, maintained and supported on goodwill basis by 1984 Hosting as free software without any guarantees or obligations and is not affiliated with or supported by DK hugbúnaður ehf.',
				'NinteenEightyWoo'
			);
			?>
		</p>
		<img
			alt="<?php esc_attr_e( 'Ninteen-Eighty-Four', 'NinteenEightyWoo' ); ?>"
			src="<?php echo esc_attr( NineteenEightyFour\NinteenEightyWoo\Admin::logo_url() ); ?>"
		/>
	</div>
</div>