// Class definition
let KTFormControls = function () {
	// Private functions
	let _initNewCargo = function () {
		FormValidation.formValidation(
			document.getElementById('kt_rohel_truck_form'),
			{
				fields: {
					from_city: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					rohel_truck_loading: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					rohel_truck_unloading: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					details: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					plate_number: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					freight: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							},
							numeric: {
								thousandsSeparator: '',
								decimalSeparator: '.',
								message: 'Please enter a valid amount (numerical only: ex. 500.4)'
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

					loading_meters: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							},
							numeric: {
								thousandsSeparator: '',
								decimalSeparator: '.',
								message: 'Please enter a valid amount (numerical only: ex. 500.4)'
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
								message: 'Please enter a valid amount (numerical only: ex. 500.4)'
							}
						}
					},

					volume: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						},
						numeric: {
							thousandsSeparator: '',
							decimalSeparator: '.',
							message: 'Please enter a valid amount (numerical only: ex. 500.4)'
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
