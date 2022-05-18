"use strict";

// Class Definition
let KTLogin = function () {
	let _login;

	let _showForm = function (form) {
		let cls = 'login-' + form + '-on';
		var form = 'kt_login_' + form + '_form';

		_login.removeClass('login-forgot-on');
		_login.removeClass('login-signin-on');
		_login.removeClass('login-signup-on');

		_login.addClass(cls);

		KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
	}

	let _handleSignInForm = function () {
		let validation;

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_signin_form'),
			{
				fields: {
					username: {
						validators: {
							notEmpty: {
								message: 'Username is required'
							}
						}
					},
					password: {
						validators: {
							notEmpty: {
								message: 'Password is required.'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					submitButton: new FormValidation.plugins.SubmitButton(),
					defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		).on('core.form.valid', function() {
			KTApp.block('#kt_login_signin_submit');
		});

		$('#kt_login_signin_submit').on('click', function (e) {
			e.preventDefault();

			validation.validate().then(function (status) {
				KTUtil.scrollTop();
			});
		});

		// Handle forgot button
		$('#kt_login_forgot').on('click', function (e) {
			e.preventDefault();
			_showForm('forgot');
		});

		// Handle signup
		$('#kt_login_signup').on('click', function (e) {
			e.preventDefault();
			_showForm('signup');
		});
	}

	let _handleSignUpForm = function (e) {
		let validation;
		let form = KTUtil.getById('kt_login_signup_form');

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			form,
			{
				fields: {
					name: {
						validators: {
							notEmpty: {
								message: 'Name is required'
							}
						}
					},
					email2: {
						validators: {
							notEmpty: {
								message: 'Email address is required'
							},
							emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					},
					agree: {
						validators: {
							notEmpty: {
								message: 'You must accept the terms and conditions'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					submitButton: new FormValidation.plugins.SubmitButton(),
					defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

		$('#kt_login_signup_submit').on('click', function (e) {
			e.preventDefault();

			validation.validate().then(function (status) {
				KTUtil.scrollTop();
			});
		});

		// Handle cancel button
		$('#kt_login_signup_cancel').on('click', function (e) {
			e.preventDefault();

			_showForm('signin');
		});
	}

	let _handleForgotForm = function (e) {
		let validation;

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_forgot_form'),
			{
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Email address is required'
							},
							emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					submitButton: new FormValidation.plugins.SubmitButton(),
					defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

		$('#kt_login_forgot_submit').on('click', function (e) {
			e.preventDefault();

			validation.validate().then(function (status) {
				console.debug('In validate - succes??');
				KTUtil.scrollTop();
			});
		});

		// Handle cancel button
		$('#kt_login_forgot_cancel').on('click', function (e) {
			e.preventDefault();

			_showForm('signin');
		});
	}

	// Public Functions
	return {
		// public functions
		init: function () {
			_login = $('#kt_login');

			_handleSignInForm();
			_handleSignUpForm();
			_handleForgotForm();
		}
	};
}();

// Class Initialization
jQuery(document).ready(function() {
	KTLogin.init();
});
