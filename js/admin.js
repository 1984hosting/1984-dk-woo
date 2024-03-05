class NineteenEightyWoo {
	static settingsForm() {
		return document.querySelector('#nineteen-eighty-woo-settings-form');
	}
	static settingsLoader() {
		return document.querySelector('#nineteen-eighty-woo-settings-loader');
	}
	static settingsSubmit() {
		return document.querySelector('#nineteen-eighty-woo-settings-submit');
	}
	static rowElements() {
		return document.querySelectorAll(
			'#payment-gateway-id-map-table tbody tr'
		);
	}

	static onSettingsFormSubmit(event) {
		event.preventDefault();

		const formData = new FormData(event.target);

		let apiKey         = formData.get('api_key').trim();
		let paymentIds     = formData.getAll('payment_id');
		let paymentNames   = formData.getAll('payment_name');
		let paymentMethods = [];

		for (let i = 0; i < paymentIds.length; i++) {
			let wooId = NineteenEightyWoo.rowElements()[i].dataset.gatewayId;
			let dkId  = parseInt(paymentIds[i]);

			if (isNaN(dkId)) {
				dkId = 0;
			}

			paymentMethods.push(
				{
					woo_id: wooId,
					dk_id: dkId,
					dk_name: paymentNames[i].trim()
				}
			);
		}

		const formDataObject = {
			api_key: apiKey,
			payment_methods: paymentMethods
		}

		console.log(formDataObject);

		NineteenEightyWoo.settingsLoader().classList.remove('hidden');
		NineteenEightyWoo.settingsSubmit().disabled = true;
		NineteenEightyWoo.postSettingsData(formDataObject);
	}

	static async postSettingsData(formDataObject) {
		const response = await fetch(
			wpApiSettings.root + 'NineteenEightyWoo/v1/settings',
			{
				method: 'POST',
				headers: {
					'Content-Type': 'application/json;charset=UTF-8',
					'X-WP-Nonce': wpApiSettings.nonce,
				},
				body: JSON.stringify(formDataObject),
			}
		);

		if (response.ok) {
			NineteenEightyWoo.settingsLoader().classList.add('hidden');
			NineteenEightyWoo.settingsSubmit().disabled = false;
		}
	}
}

window.addEventListener('DOMContentLoaded', () => {
	if (document.body) {
		if (
			document.body.classList.contains(
				'woocommerce_page_NineteenEightyWoo'
			)
		) {
			NineteenEightyWoo.settingsForm().addEventListener(
				'submit',
				NineteenEightyWoo.onSettingsFormSubmit
			);
		}
	}
});
