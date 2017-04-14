$(function() {
  $('#tranfer_cm_btc input[type=checkbox]').change(function() {
      if ($('#amount_usd').val() == "")
          var total_BTC = 0;
      var valRadio = parseInt($(this).val());
      var valBTC = null;
      var total = 0;
      $('#tranfer_cm_btc input[type=checkbox]').each(function() {
          if (this.checked) {
              if (this.value == 1) {
                  total = parseFloat(total) + parseFloat($('#refferal').data('value'));
              }
              if (this.value == 2) {
                  total = parseFloat(total) + parseFloat($('#binary').data('value'));
              }
              if (this.value == 3) {
                  total = parseFloat(total) + parseFloat($('#daily').data('value'));
              }
               if (this.value == 4) {
                  total = parseFloat(total) + parseFloat($('#division').data('value'));
              }
          }
      });
      conver_usd_to_btc(total);
      $('#amount_usd').val(parseFloat(total));
  });
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

    $('#tranfer_cm_btc').on('submit', function() {
        alertify.confirm('<p class="text-center" style="font-size:25px;color: black;text-transform: ;height: 20px">Are you sure ?</p>', function(e) {
            if (e) {
                window.funLazyLoad.start();
                $('#tranfer_cm_btc').ajaxSubmit({
                    type: 'POST',
                    beforeSubmit: function(arr, $form, options) {                      
                        window.funLazyLoad.start();
                        $('.choose_wallet').hide();
                
                        $('.error_password_transaction_btc').hide();

                         if(validateChecks()==false) {
                             $('.choose_wallet').show();
                            window.funLazyLoad.reset();
                            return false;
                          }
                        // if ($('#amount_usd').val() == "" || isNaN(parseFloat($('#amount_usd').val())) || parseFloat($('#amount_usd').val()) < 10) {
                        //     $('.choose_wallet').show().html('The amount withdrawal > 10');
                        //     window.funLazyLoad.reset();
                        //     return false;
                        // }
                        if ($('#password_transaction_btc').val() == "") {
                            $('.error_password_transaction_btc').show();
                            window.funLazyLoad.reset();
                            return false;
                        }

                    },
                    success: function(result) {
                      
                        result = $.parseJSON(result);
                      
                        if (result.password == -1) {
                            window.funLazyLoad.reset();
                            $('.error_password_transaction_deal_btc').show();
                            return false;
                        }
                        if (result.amount == -1) {
                            window.funLazyLoad.reset();
                            var html = '<div class="col-md-12">';
                            html += '<p class="text-center" style="font-size:19px !important;color: black;text-transform: ;height: 20px">You are not enough USD!</p>';
                            alertify.alert(html, function() {
                                location.reload(true);
                            });
                            return false;

                        }
                        if (result.amount == -1) {
                            window.funLazyLoad.reset();
                            $('.choose_wallet').show().html('The amount withdrawal > 10');
                            return false;
                        }
                        if (result.amount_ref == -1) {
                            window.funLazyLoad.reset();
                            $('.choose_wallet').show().html('The amount Refferal Commission  > 5');
                            return false;
                        }
                         if (result.binary_bonus == -1) {
                            window.funLazyLoad.reset();
                            $('.choose_wallet').show().html('The amount Binary  Commission  > 10');
                            return false;
                        }
                         if (result.profit_daily == -1) {
                            window.funLazyLoad.reset();
                            $('.choose_wallet').show().html('The Profit Daily  Commission  > 5');
                            return false;
                        }
                        if (result.getMWallet == -1) {
                            window.funLazyLoad.reset();
                            $('.choose_wallet').show().html('The amount Co-division  Commission  > 1');
                            return false;
                        }
                         if (result.authenticator == -1) {
                            window.funLazyLoad.reset();
                            $('.error_authenticator').show();
                            return false;
                        }
                        if (result.ok == -1) {
                          alert('Please try again!');
                            return false;
                        }
                         if (result.admin_none == -1) {
                            window.funLazyLoad.reset();
                            var html = '<div class="col-md-12">';
                            html += '<p class="text-center" style="font-size:19px !important;color: black;text-transform: ;height: 20px">Please try again!</p>';
                            alertify.alert(html, function() {
                                location.reload(true);
                            });
                            return false;

                        }
                        if (result.ok==1) {
                            var html = '<div class="col-md-12">';
                            html += '<p class="text-center" style="font-size:19px;color: black;text-transform: ;height: 20px">Successful Withdrawal!</p>';
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

function selectU(val) {
    $('.wallet_tranfer').show();
    $('#username').val(val);
    $('#suggesstion-box_username').hide();
    $.ajax({
        type: "POST",
        url: 'index.php?route=transaction/tranfercm/load_wallet_coinmax',
        data: {
            'username': val
        },
        success: function(data) {
            result = $.parseJSON(data);
            result = JSON.parse(result);
            $('.wallet_your').html(result.username);
            $('#telephone').html(result.telephone);
            $('#customer_code').html((result.customer_code).substring(0, 6));
            //$('#amount_your').html(numberWithCommas(result.amount));
            //alert(result.img_profile);
            $('.my_wallet_user').attr({
                'src': result.img_profile

            });

            $("#amount").attr("readonly", false);
            $("#password_transaction_vnd").attr("readonly", false);
            $('.hidden_wallet').show();
            $('#amount').val('');
            $('#password_transaction_vnd').val('');
            $('#amount').focus();
        }
    });
}

function selectU_btc(val, customer_id) {
    $('.wallet_tranfer').show();
    $('#username_btc').val(val);
    $('#suggesstion-box_username_btc').hide();
    $.ajax({
        type: "POST",
        url: 'index.php?route=transaction/tranfercm/load_wallet_blockio',
        data: {
            'customer_id': customer_id
        },
        success: function(data) {
            result = $.parseJSON(data);
            var html = ' <div class="wallet wallet_blockcio"><img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=' + result.wallet + '" alt=""></div><p>' + result.wallet + '</p><p>Amount: ' + result.blance + ' BTC</p></p><p>Amount pending: ' + result.pending + ' BTC</p>';
            $('.wallet_you').html(html);


            $("#amount_btc_block").attr("readonly", false);
            $("#password_transaction_btc_block").attr("readonly", false);
            $('.hidden_wallet').show();
            $('#amount_btc').val('');
            $('#password_transaction_btc').val('');
            $('#amount_btc').focus();
        }
    });

}
String.prototype.reverse = function() {
    return this.split("").reverse().join("");
}

function reformatText(input) {
    var x = input.value;
    x = x.replace(/,/g, ""); // Strip out all commas
    x = x.reverse();
    x = x.replace(/.../g, function(e) {
        return e + ",";
    }); // Insert new commas
    x = x.reverse();
    x = x.replace(/^,/, ""); // Remove leading comma
    input.value = x;
}

function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}