$(function() {
  // ==========
  // ==================================================
  var delay = (function() {
      var timer = 0;
      return function(callback, ms) {
          clearTimeout(timer);
          timer = setTimeout(callback, ms);
      };
  })();

  function conver_usd_to_btc(amount_usd) {
      delay(function() {
          $.ajax({
              url: $('#amount_btc').data('link'),
              type: "post",
              dateType: "text",
              data: {
                  usd: amount_usd
              },
              success: function(result) {
                  result = $.parseJSON(result);
                  $('#amount_btc_val').val(parseFloat(result.btc));
                  $('#password_transaction_btc').attr("readonly", false);
              }
          });
      }, 500);
  }
function validateChecks() {
    var chks = document.getElementsByName('FromWallet[]');
    var checkCount = 0;
    for (var i = 0; i < chks.length; i++) {
      if (chks[i].checked) {
        checkCount++;
      }
    }
    if (checkCount < 1) {
      return false;
    }
    return true;
  }

    $('#tranfer_member').on('submit', function() {
      var user = $('#tranfer_member #MemberUserName').val();
        alertify.confirm('<p class="text-center" style="font-size:25px;color: black;text-transform: ;height: 20px">Do you want transfer to <span style=" color: #f3535f; font-weight: bold; ">'+user+'</span> ?</p>', function(e) {
            if (e) {
        
                $('#tranfer_member').ajaxSubmit({
                    type: 'POST',
                    beforeSubmit: function(arr, $form, options) {                      
                        window.funLazyLoad.start();

                    },
                    success: function(result) {
                        result = $.parseJSON(result);
                         $('#tranfer_member button').attr('disabled', true);
                        $('.error_input').hide();
                        if(_.has(result, 'input') && result['input'] === -1){
                          window.funLazyLoad.reset();
                         
                          $('.error_input').show();
                          $('#tranfer_member button').attr('disabled', false);
                          return false;
                        }  

                        if(_.has(result, 'password') && result['password'] === -1){
                          window.funLazyLoad.reset();
                          $('.error_input').show().html('Please enter password!');
                           $('#tranfer_member button').attr('disabled', false);
                          return false;
                        } 
                        if(_.has(result, 'customers') && result['customers'] === -1){
                          window.funLazyLoad.reset();
                          $('.error_input').show().html('Please enter username!');
                           $('#tranfer_member button').attr('disabled', false);
                          return false;
                        }
                        if(_.has(result, 'amount') && result['amount'] === -1){
                          window.funLazyLoad.reset();
                          $('.error_input').show().html('Please enter amount!');
                           $('#tranfer_member button').attr('disabled', false);
                          return false;
                        }
                        if(_.has(result, 'authen') && result['authen'] === -1){
                          window.funLazyLoad.reset();
                          $('.error_input').show().html('Please enter authen!');
                           $('#tranfer_member button').attr('disabled', false);
                          return false;
                        } 
                        if(_.has(result, 'ok') && result['ok'] === 1){
                          window.funLazyLoad.reset();
                          var html = '<div class="col-md-12">';
                            html += '<p class="text-center" style="font-size:19px;color: black;text-transform: ;height: 20px">Successful transfer!</p>';
                            alertify.alert(html, function() {
                                location.reload(true);
                            });
                        } 
                        
                      
                    }
                });
            } else {
                return false;
            }
        });

        return false;
    });

    $('#tranfer_my_wallet #wallet').change(function() {
        var wallet = $('#wallet').val();
        var html ='';
        if (wallet == 'CN') {html += '<option value="C"> Refferal Commission </option> <option value="R"> Profit Daily </option> <option value="B"> Co-division Commission </option>';}
        if (wallet == 'R') {html += '<option value="C"> Refferal Commission </option> <option value="CN"> Binary Bonuses </option> <option value="B"> Co-division Commission </option>';}
        if (wallet == 'C') {html += '<option value="R"> Profit Daily </option> <option value="CN"> Binary Bonuses </option> <option value="B"> Co-division Commission </option>';}
        if (wallet == 'B') {html += '<option value="C"> Refferal Commission </option> <option value="R"> Profit Daily </option> <option value="CN"> Binary Bonuses </option>';}
        $('#wallet_receive').empty();
        $('#wallet_receive').append(html);
    });
    // =============== transfer my wallet
    $('#tranfer_my_wallet').on('submit', function() {
      var user = $('#tranfer_my_wallet #MemberUserName').val();
        alertify.confirm('<p class="text-center" style="font-size:25px;color: black;text-transform: ;height: 20px">Do you want transfer to <span style=" color: #f3535f; font-weight: bold; ">'+ $('#wallet_receive').val()+' Wallet</span> ?</p>', function(e) {
            if (e) {
        
                $('#tranfer_my_wallet').ajaxSubmit({
                    type: 'POST',
                    beforeSubmit: function(arr, $form, options) {                      
                        window.funLazyLoad.start();

                    },
                    success: function(result) {
                        result = $.parseJSON(result);
                         $('#tranfer_my_wallet button').attr('disabled', true);
                        $('.error_input').hide();
                        if(_.has(result, 'input') && result['input'] === -1){
                          window.funLazyLoad.reset();
                         
                          $('.error_input').show();
                          $('#tranfer_my_wallet button').attr('disabled', false);
                          return false;
                        }  

                        if(_.has(result, 'password') && result['password'] === -1){
                          window.funLazyLoad.reset();
                          $('.error_input').show().html('Please enter password!');
                           $('#tranfer_my_wallet button').attr('disabled', false);
                          return false;
                        } 
                        if(_.has(result, 'customers') && result['customers'] === -1){
                          window.funLazyLoad.reset();
                          $('.error_input').show().html('Please enter username!');
                           $('#tranfer_my_wallet button').attr('disabled', false);
                          return false;
                        }
                        if(_.has(result, 'amount') && result['amount'] === -1){
                          window.funLazyLoad.reset();
                          $('.error_input').show().html('Please enter amount!');
                           $('#tranfer_my_wallet button').attr('disabled', false);
                          return false;
                        }
                        if(_.has(result, 'authen') && result['authen'] === -1){
                          window.funLazyLoad.reset();
                          $('.error_input').show().html('Please enter authen!');
                           $('#tranfer_my_wallet button').attr('disabled', false);
                          return false;
                        } 
                        if(_.has(result, 'ok') && result['ok'] === 1){
                          window.funLazyLoad.reset();
                          var html = '<div class="col-md-12">';
                            html += '<p class="text-center" style="font-size:19px;color: black;text-transform: ;height: 20px">Successful transfer!</p>';
                            alertify.alert(html, function() {
                                location.reload(true);
                            });
                        } 
                        
                      
                    }
                });
            } else {
                return false;
            }
        });

        return false;
    });


});
