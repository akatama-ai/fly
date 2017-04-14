/*
Document: base_forms_validation.js
Author: Rustheme
Description: Custom JS code used in Form Validation Page
 */

var LoginValidation = function() {
   
    var initValidationBootstrap = function() {
        jQuery( '.js-validation-bootstrap' ).validate({
            errorClass: 'help-block animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function( error, e ) {
                jQuery(e).parents( '.form-group > div' ).append( error );
            },
            highlight: function(e) {
                jQuery(e).closest( '.form-group' ).removeClass( 'has-error' ).addClass( 'has-error' );
                jQuery(e).closest( '.help-block' ).remove();
            },
            success: function(e) {
                jQuery(e).closest( '.form-group' ).removeClass( 'has-error' );
                jQuery(e).closest( '.help-block' ).remove();
            },
            rules: {
                'email': {
                    required: true,
                    minlength: 3
                },
                 'capcha': {
                    required: true
                },
               
                'password': {
                    required: true,
                    minlength: 5
                }
               
            },
            messages: {
                'email': {
                    required: 'Please enter a username',
                    minlength: 'Your username must consist of at least 3 characters'
                },
                'capcha': {
                    required: 'Please enter captcha',
                },
                'password': {
                    required: 'Please provide a password',
                    minlength: 'Your password must be at least 5 characters long'
                }
               
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
	LoginValidation.init();
});
