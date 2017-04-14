/*
Document: base_forms_validation.js
Author: Rustheme
Description: Custom JS code used in Form Validation Page
 */

var BaseFormValidation = function() {
    // Init Bootstrap Forms Validation: https://github.com/jzaefferer/jquery-validation
    var initValidationBootstrap = function() {
        jQuery( '.js-validation-bootstrap' ).validate({
            errorClass: 'help-block animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function( error, e ) {
                jQuery(e).parents( '.form-group > div' ).append( error );
            },
            highlight: function(e) {
                window.funLazyLoad.reset();
                $('#register-account button').attr('disabled', false);
                jQuery(e).closest( '.form-group' ).removeClass( 'has-error' ).addClass( 'has-error' );
                jQuery(e).closest( '.help-block' ).remove();
            },
            success: function(e) {
                jQuery(e).closest( '.form-group' ).removeClass( 'has-error' );
                jQuery(e).closest( '.help-block' ).remove();
            },
            rules: {
                'username': {
                    required: true,
                    minlength: 3
                },
                'email': {
                    required: true,
                    email: true
                },
                'telephone': {
                    required: true,
                    minlength: 9
                },
                'cmnd': {
                    required: true,
                    minlength: 4
                },
                'password': {
                    required: true,
                    minlength: 5
                },
                'val-confirm-password': {
                    required: true,
                    equalTo: '#password'
                },
                'transaction_password': {
                    required: true,
                    minlength: 5
                },
                'val-transaction_password': {
                    required: true,
                    equalTo: '#password2'
                },
                 'position': {
                    required: true
                },
                'country_id': {
                    required: true
                },

                'wallet': {
                    required: true
                },
                'val-terms': {
                    required: true
                },
                 'pbinary': {
                    required: true
                },
                'postion': {
                    required: true
                }
            },
            messages: {
                'username': {
                    required: 'Please enter a username',
                    minlength: 'Your username must consist of at least 3 characters'
                },
                'email': 'Please enter a valid email address',
                 'telephone': {
                    required: 'Please enter a phone number',
                    minlength: 'Your phone number must consist of at least 9 characters'
                },
                'cmnd': {
                    required: 'The Citizenship card/passport no field is required.',
                    minlength: 'Your Citizenship card/passport no must consist of at least 4 characters'
                },
                'password': {
                    required: 'Please provide a password',
                    minlength: 'Your password must be at least 5 characters long'
                },
               
                'val-confirm-password': {
                    required: 'Please confirm a password',
                    minlength: 'Your password must be at least 5 characters long',
                    equalTo: 'Please enter the same password as above'
                },
                'transaction_password': {
                    required: 'Please provide a transaction password',
                    minlength: 'Your transaction password must be at least 5 characters long'
                },
                'val-transaction_password': {
                    required: 'Please provide a transaction password',
                    minlength: 'Your transaction password must be at least 5 characters long'
                },
                'position': 'Please select a position!',
                'country_id': 'Please select a country!',
                'wallet': 'Please enter your wallet!',
                'val-terms': 'You must agree to the service terms!',
                'pbinary': 'The Binary field is required!',
                'postion': 'The postion field is required!'
            }
        });
    };

   
    return {
        init: function () {
            initValidationBootstrap();
        }
    };
}();

// Initialize when page loads
jQuery( function() {
	BaseFormValidation.init();
});
