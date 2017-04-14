$( document ).ready(function() {

     $('#username').keyup(function() {
        var name = $(this).val().replace(/[^A-Z0-9]/gi, '');
         $('#username').val(name)
      });



    $('#register-account').on('submit', function(event) {
        $('#register-account button').attr('disabled', true);
        window.funLazyLoad.start();
        $.fn.existsWithValue = function() {
            return this.length && this.val().length;
        };

        // var self = $(this);
        // var isValidEmailAddress = function(email, callback) {
        //     var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        //     callback(pattern.test(email));
        // };

        // if (self.find('#cmnd').existsWithValue() === 0) {
        //     self.find('#cmnd').parent().addClass('has-error');
        //     self.find('#cmnd-error').show();
        //     self.find('#cmnd-error span').html('The Citizenship card/passport no field is required');
        //     window.funLazyLoad.reset();
        //     $('#register-account button').attr('disabled', false);
        //     return false;
        // }
        // if (!self.find('#val-terms').is(":checked")) {
        //     $('#register-account button').attr('disabled', false);
        //     self.find('#val-terms').addClass('validation-error');
        //     window.funLazyLoad.reset();
        //     return false;
        // } else {
        //     $('#val-terms').is(":checked") && $('#val-terms').removeClass('validation-error');
        // }

        
        // if( self.find('#val-terms').is(":checked")){

        //     window.funLazyLoad.start();
        //     $('.btn-frm-submit').hide();
        //     return true;
        // }

        return true;

    });
}); 