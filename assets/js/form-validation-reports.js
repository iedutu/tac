// Class definition
let KTFormControls = function () {
	// Private functions
	let reportDateSelection = function () {
		FormValidation.formValidation(
			document.getElementById('kt_rohel_reports_form'),
			{
				fields: {
					rohel_reports_end: {
						validators: {
							notEmpty: {
								message: 'Field cannot be empty.'
							}
						}
					},

					rohel_reports_start: {
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
			document.getElementById('kt_reports_submit_btn').setAttribute("disabled", "true");
		});
	}

	return {
		// public functions
		init: function() {
			reportDateSelection();
		}
	};
}();

jQuery(document).ready(function() {
	KTFormControls.init();
});
