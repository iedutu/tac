// Class definition
let KTFormControls = function () {
	// Private functions
	let _initNewCargo = function () {
		FormValidation.formValidation(
			document.getElementById('kt_rohel_truck_stop_form'),
			{
				fields: {
					stop_id: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							},
							numeric: {
								thousandsSeparator: '',
								decimalSeparator: '.',
								message: 'Please enter a valid amount (numerical only: ex. 500.4)'
							}
						},
					},
					city: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},
					cmr: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							},
							numeric: {
								thousandsSeparator: '',
								decimalSeparator: '.',
								message: 'Please enter a valid amount (numerical only: ex. 500.4)'
							}
						},
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
						},
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
						},
					},
					volume: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							},
							numeric: {
								thousandsSeparator: '',
								decimalSeparator: '.',
								message: 'Please enter a valid amount (numerical only: ex. 500.4)'
							}
						},
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
		);
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
