// Class definition
let KTFormControls = function () {
	// Private functions
	let _initNewCargo = function () {
		FormValidation.formValidation(
			document.getElementById('kt_rohel_cargo_note_form'),
			{
				fields: {
					note: {
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
