</div> <!-- .app-layout-container --> </div> 
<div id="apps-modal" class="modal fade" tabindex="-1" role="dialog">
   <div class="modal-sm modal-dialog modal-dialog-top">
      <div class="modal-content">
         <!-- Apps card --> 
         <div class="card m-b-0">
            <div class="card-header bg-app bg-inverse">
               <h4>Apps</h4>
               <ul class="card-actions">
                  <li> <button data-dismiss="modal" type="button"><i class="ion-close"></i></button> </li>
               </ul>
            </div>
            <div class="card-block">
               <div class="row text-center">
                  <div class="col-xs-6">
                     <a class="card card-block m-b-0 bg-app-secondary bg-inverse" href="home.html">
                        <i class="ion-speedometer fa-4x"></i> 
                        <p>Dashboard</p>
                     </a>
                  </div>
                  <div class="col-xs-6">
                     <a class="card card-block m-b-0 bg-app-tertiary bg-inverse" href="index.html">
                        <i class="ion-laptop fa-4x"></i> 
                        <p>Home</p>
                     </a>
                  </div>
               </div>
            </div>
            <!-- .card-block --> 
         </div>
         <!-- End Apps card --> 
      </div>
   </div>
</div>
<!-- End Apps Modal --> 
<div class="app-ui-mask-modal"></div>
<div id="google_translate_element" style="position: fixed; right: 0; bottom: -19px; z-index: 10002;"></div>
<script type="text/javascript">
function googleTranslateElementInit() {
   new google.translate.TranslateElement({pageLanguage: 'en' }, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

      <style type="text/css">
      #google_translate_element select{
        border: 1px solid #d03543;
    padding: 10px;
    border-radius: 5px;
    background: #d03543;
    color: #fff;
      }
      a.goog-logo-link {
    display: none;
}
.goog-te-banner-frame.skiptranslate {
    display: none !important;
    }
    .goog-te-gadget {

    color: transparent;
}
body {
    top: 0px !important; 
    }
    #goog-gt-tt {
    display: none !important;
}
      </style>
<script> $(".menu-toggle").click(function(e) {e.preventDefault(); $("#wrapper").toggleClass("toggled"); }); $("#menu-toggle").click(function(e) {e.preventDefault(); $("#wrapper").toggleClass("toggled"); }); </script> <!-- Core JS: jQuery, Bootstrap, slimScroll, scrollLock and App.js --> <script src="catalog/view/theme/default/assets/bootstrap.min.js"></script> <script src="catalog/view/theme/default/assets/jquery.slimscroll.min.js"></script> <script src="catalog/view/theme/default/assets/jquery.scrollLock.min.js"></script> <script src="catalog/view/theme/default/assets/jquery.placeholder.min.js"></script> <script src="catalog/view/theme/default/assets/app.js"></script> <script src="catalog/view/theme/default/assets/app-custom.js"></script> <?php foreach ($scripts_footer as $script) { ?> <script src="<?php echo $script; ?>" type="text/javascript"></script> <?php } ?> <script> $(function() {App.initHelpers('slick'); }); </script> 
<script type="text/javascript">
    $("#MemberUserName").keyup(function(){
            $('.load').show();
            $('.item_wallet').hide();
            $('#loaduser').html('');
            $.ajax({
            type: "POST",
            url: "<?php echo HTTPS_SERVER ?>getaccount",
            data:'keyword='+$(this).val(),        
            success: function(data){
                $("#suggesstion-box").show();
                $("#suggesstion-box").html(data);
                $("#MemberUserName").css("background","#FFF");            
            }   
            });
        });
function selectU(val) {
        $("#MemberUserName").val(val);
        $("#suggesstion-box").hide();
        $('.item_wallet').hide();
        $('.load').show();
       
        $.ajax({
            type: "POST",
            url: "<?php echo HTTPS_SERVER ?>getinfouser",
            data:'user='+val,        
            success: function(data){
                result = $.parseJSON(data);

                 var html =' <div class=""><div class="col-xs-4 left"><p><img style="width:60px !important;  height:60px; border-radius:50%; margin:0 auto" src="'+result.myavatar+'"></p><p>Username: <b>'+result.myusername+'</b></p><p>Phone: <b>'+result.myphone+'</b></p></div><div class="col-xs-4 text-center"><i class="ion-arrow-right-a" style=" font-size: 40px; "></i></div><div class="col-xs-4 right"><p style="margin-left:0px !important;"><img style="width:60px !important; height:60px; border-radius:50%; margin:0 auto" src="'+result.avatar+'"></p><p>Username: <b>'+result.username+'</b></p></p><p>Phone: <b>'+result.phone+'</b></p></div></div>';
                setTimeout(function(){
                    $('#loaduser').html(html);
                     $('.load').hide();
                }, 500);
            }
        });
    }
</script>
<script type="text/javascript">
 $('.packet-invest').on('submit', function() {
     var self = $(this);
     var root = "https://blockchain.info/";
     alertify.confirm('<p class="text-center" style="font-size:25px;color: black;text-transform: ;height: 20px">Make sure your choice is correct !</p>', function() {
         window.funLazyLoad.start();
         setTimeout(function() {
             self.ajaxSubmit({
                 success: function(result) {
                     if (result == "no_6") {
                         var xhtml = '<p class="text-center" style="font-size:25px;color: black;text-transform: ;height: 20px">Smaller your weak team 50 BTC !</p>';
                         alertify.alert(xhtml, function() {
                             location.reload(true);
                         });
                         window.funLazyLoad.reset();
                         return false;
                     }
                     if (result == "no_7") {
                         var xhtml = '<p class="text-center" style="font-size:25px;color: black;text-transform: ;height: 20px">Smaller your weak team 100 BTC !</p>';
                         alertify.alert(xhtml, function() {
                             location.reload(true);
                         });
                         window.funLazyLoad.reset();
                         return false;
                     }
                     if (result == "no_complete") {
                         var xhtml = '<p class="text-center" style="font-size:25px;color: black;text-transform: ;height: 20px">Please pay your investment package!</p>';
                         alertify.alert(xhtml, function() {
                             location.reload(true);
                         });
                         window.funLazyLoad.reset();
                         return false;
                     }
                     result = $.parseJSON(result);
                     var amount = result.amount / 100000000;
                     if(_.has(result, 'btn') && result['btn'] === 1){
                      var html = '<input type="hidden" id="my_wallet" name="my_wallet" value="'+result.my_wallet+'" ><input type="hidden" id="invest" name="invest" value="'+result.invest+'" ><input type="hidden" id="invoice" name="invoice" value="'+result.invoice+'" ><button id="payment_o" class="btn btn-info">Pay with '+result.name_wallet+' Wallet</button>';

                    }else{
                      var html ='';
                    } 
                     var package = result.package;
                     var total = package;
                     var xhtml = '<div class="col-md-12"style=" text-align: center; ">Please send <code>' + amount + ' BTC</code> (' + package + ' USD) to this address.</div><div class="col-md-12"style=" text-align: center; "><p></p><p>Your Packet: ' + package + ' USD </p><p>Total: ' + amount + ' BTC</p><p>'+html+'</p><img style="margin-left:-10px" src="https://chart.googleapis.com/chart?chs=225x225&chld=L|0&cht=qr&chl=bitcoin:' + result.input_address + '?amount=' + amount + '"/><p>' + result.input_address + '</p></div>';
                     alertify.alert(xhtml, function() {
                         location.reload(true);
                     });
                     payment_o(result.my_wallet, result.invest, result.invoice);
                     function checkBalance() {
                         $.ajax({
                             type: "GET",
                             url: root + 'q/getreceivedbyaddress/' + result.input_address,
                             data: {
                                 format: 'plain'
                             },
                             success: function(response) {

                                 if (!response) return;

                                 var value = parseInt(response);

                                 if (value > 0) {
                                     var xhtml = '<div class="col-md-12 text-center"><h3>Payment success!</h3></div>';
                                     alertify.alert(xhtml, function() {
                                         window.funLazyLoad.reset();
                                         location.reload(true);
                                     });
                                 } else {
                                     setTimeout(checkBalance, 5000);
                                 }
                             }
                         });
                     }
                     setTimeout(checkBalance, 5000);
                 }
             });
         }, 200);
     }, function() {});
     return false;
 });

function payment_o(mywallet, invest, invoice) {
    $('#payment_o').click(function() {
        alertify.confirm('<p class="text-center" style="font-size:25px;color: black;text-transform: ;height: 20px">Are you sure?</p>', function(e) {
            if (e) {
                var Wallet = mywallet;
                $.ajax({
                    type: "POST",
                    url: "<?php echo HTTPS_SERVER ?>callback_pd_wallet",
                    data: 'wallet=' + Wallet + '&invest=' + invest + '&invoice=' + invoice,
                    success: function(response) {
                        if (!response) return;
                        response = $.parseJSON(response);
                        if (response.ok_callback == 1) {
                            var xhtml = '<div class="col-md-12 text-center"><h3>Payment success!</h3></div>';
                             alertify.alert(xhtml, function() {
                                 window.funLazyLoad.reset();
                                 location.reload(true);
                             });
                        }
                    }
                });

            } else {
                return false;
            }
        });
    });
}
 

 $('.packet-invoide').on('submit', function() {
     var self = $(this);
     var root = "https://blockchain.info/";
     window.funLazyLoad.start();
     setTimeout(function() {
         self.ajaxSubmit({
             success: function(result) {
                 result = $.parseJSON(result);
                 if (_.has(result, 'success') && result['success'] === 1) {
                     var xhtml = '<div class="col-md-12 text-center"><h3>You have to activate this package! please select another package!</h3></div>'
                 } else {
                     var amount = result.amount / 100000000;
                    if(_.has(result, 'btn') && result['btn'] === 1){
                      var html = '<input type="hidden" id="my_wallet" name="my_wallet" value="'+result.my_wallet+'" ><input type="hidden" id="invest" name="invest" value="'+result.invest+'" ><input type="hidden" id="invoice" name="invoice" value="'+result.invoice+'" ><button id="payment_o" class="btn btn-info">Pay with '+result.name_wallet+' Wallet</button>';

                    }else{
                      var html ='';
                    }  
                     var package = result.package;
                     var total = package;
                     var received = result.received / 100000000;
                     var xhtml = '<div class="col-md-12"style=" text-align: center; ">Please send <code>' + amount + ' BTC</code> (' + package + ' USD) to this address.</div><div class="col-md-12"style=" text-align: center; "><p></p><p>Your Packet: ' + package + ' USD </p><p>Total: ' + amount + ' BTC</p><p>'+html+'</p><img style="margin-left:-10px" src="https://chart.googleapis.com/chart?chs=225x225&chld=L|0&cht=qr&chl=bitcoin:' + result.input_address + '?amount=' + amount + '"/><p>' + result.input_address + '</p></div>';
                 }
                 alertify.alert(xhtml, function() {
                     location.reload(true);
                 });

                  payment_o(result.my_wallet, result.invest, result.invoice);
                 function checkBalance() {
                     $.ajax({
                         type: "GET",
                         url: root + 'q/getreceivedbyaddress/' + result.input_address,
                         data: {
                             format: 'plain'
                         },
                         success: function(response) {

                             if (!response) return;

                             var value = parseInt(response);

                             if (value > 0) {
                                 var xhtml = '<div class="col-md-12 text-center"><h3>Payment success!</h3></div>';
                                 alertify.alert(xhtml, function() {
                                     window.funLazyLoad.reset();
                                     location.reload(true);
                                 });
                             } else {
                                 setTimeout(checkBalance, 5000);
                             }
                         }
                     });
                 }
                 setTimeout(checkBalance, 5000);
             }
         });
     }, 200);
     return false;
 });


</script> 
</body> </html>