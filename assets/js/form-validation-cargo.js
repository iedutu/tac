// Class definition
let KTFormControls = function () {
	// Private functions
	let _initNewCargo = function () {
		FormValidation.formValidation(
			document.getElementById('kt_rohel_cargo_form'),
			{
				fields: {
					from_address: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					to_address: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					from_city: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					to_city: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					rohel_cargo_expiration: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					rohel_cargo_loading: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					rohel_cargo_unloading: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					weight: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							},
							numeric: {
								thousandsSeparator: '',
								decimalSeparator: '.',
								message: 'Please enter a valid number'
							}
						}
					},

					volume: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							},
							numeric: {
								thousandsSeparator: '',
								decimalSeparator: '.',
								message: 'Please enter a valid number'
							}
						}
					},

					loading: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							},
							numeric: {
								thousandsSeparator: '',
								decimalSeparator: '.',
								message: 'Please enter a valid number (ex. 500.4)'
							}
						}
					},

					freight: {
						validators: {
							numeric: {
								thousandsSeparator: '',
								decimalSeparator: '.',
								message: 'Please enter a valid amount (numerical only: ex. 500.4)'
							}
						}
					},

					client: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},
				},

				plugins: { //Learn more: https://formvalidation.io/guide/plugins
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),
					// Submit the form when all fields are valid
					defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
				}
			}
		).on('core.form.valid', function() {
			document.getElementById('kt_new_cargo_submit_btn').setAttribute("disabled", "true");
		});
	}

	return {
		// public functions
		init: function() {
			_initNewCargo();
		}
	};
}();

jQuery(document).ready(function() {
	KTFormControls.init();
});
