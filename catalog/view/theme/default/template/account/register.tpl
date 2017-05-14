<?php echo $self->load->controller('common/header'); ?> 
<main class="frm">
   <!-- Page Content --> <!-- <div class="page-header bg-green bg-inverse"> <div class="container"> <div class="p-y-lg text-center"> <h1 class="display-2">Register</h1> </div> </div> </div> --> 
   <div class="container-fluid p-y-md">
      <button class="btn btn-pill btn-success" type="button" onclick="location.href='home.html';" style="padding: 5px 30px;position: absolute;left: 10px;top: 10px;"><i class="ion-arrow-left-a"></i></button><!-- Forms Row --> 
      <div class="row">
         <div class="col-sm-6 col-sm-offset-3">
       
            <!-- Bootstrap Forms Validation --> 
            <div class="card" style=" border-radius: 10px;">
               <div class="card-header text-center" style=" position: relative; z-index: 999999; "> <img class="img-responsive" src="catalog/view/theme/default/img/logo.png" title="BitflyerBank" alt="BitflyerBank" /> </div>
               <div class="card-block">
                  <form id="register-account" action="<?php echo $self -> url -> link('account/registers/confirmSubmit', '', 'SSL'); ?>" class="js-validation-bootstrap form-horizontal" method="post" novalidate="novalidate">
                     <input type="hidden" name="node" value="<?php echo $self->request->get['ref']; ?>"> 
                     <div class="form-group">
                        <label class="col-md-4 control-label" for="val-username">Sponser <span class="text-blue">*</span></label> 
                        <div class="col-md-7"> <input readonly class="form-control" placeholder="Choose a nice username..." value="<?php echo $sponsor; ?>" style=" background: #d03543; text-transform: uppercase; font-weight: bold; "> </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label" for="val-username">Username <span class="text-blue">*</span></label> 
                        <div class="col-md-7"> <input class="form-control" placeholder="Choose a nice username..." name="username" id="username" value="" data-link="<?php echo $actionCheckUser; ?>"> <span id="user-error" class="help-block animated fadeInDown" style="display: none;"> <span>Please enter user name</span> </span> </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label" for="val-email">Email <span class="text-blue">*</span></label> 
                        <div class="col-md-7"> <input class="form-control" placeholder="Enter your email..." name="email" id="email" data-link="<?php echo $actionCheckEmail; ?>"> <span id="email-error" class="help-block animated fadeInDown" style="display: none;"> <span id="Email-error">Please enter Email Address</span></span> </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label" for="val-phone">Phone Number <span class="text-blue">*</span></label> 
                        <div class="col-md-7"> <input class="form-control" type="text" placeholder="Phone Number" name="telephone" id="phone" data-link="<?php echo $actionCheckPhone; ?>"> <span id="phone-error" class="help-block animated fadeInDown" style="display: none;"> <span>Please enter Phone Number</span> </span> </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label" for="val-phone">Citizenship Card/Passport No <span class="text-blue">*</span></label> 
                        <div class="col-md-7"> <input class="form-control" placeholder="Citizenship Card/Passport No" type="text" name="cmnd" id="cmnd" data-link="<?php echo $actionCheckCmnd; ?>"> <span id="cmnd-error" class="help-block animated fadeInDown" style="display: none;"> <span id="CardId-error">The Citizenship card/passport no field is required.</span> </span> </div>
                     </div>
                     <div class="form-group">
                     <label class="col-md-4 control-label" for="val-Position">Choose Position <span class="text-blue">*</span></label>
                     <div class="col-md-7">
			               <select class="form-control" id="position" name="position">
			                     <option value="">-- Choose Position --</option>
			                   
			                     <option value="left">
			                        Left
			                     </option>
			                    <option value="right">
			                        Right
			                     </option>
			                  </select>
			                  <span id="position-error" class="field-validation-error" style="display: none;">
			                     <span>The position field is required.</span>
			                  </span>
			             </div>
			             </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label" for="val-country">Country <span class="text-blue">*</span></label> 
                        <div class="col-md-7">
                           <select class="form-control" id="country" name="country_id">
                              <option value="">-- Choose your Country --</option>
                              <?php foreach ($country as $key=> $value) {?> 
                              <option value="<?php echo $value['id'] ?>"> <?php echo $value[ 'name'] ?> </option>
                              <?php } ?> 
                           </select>
                           <span id="country-error" class="help-block animated fadeInDown" style="display: none;"> <span>The country field is required.</span> </span> 
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label" for="val-password">Password <span class="text-blue">*</span></label> 
                        <div class="col-md-7"> <input class="form-control" placeholder="Password For Login" id="password" name="password" type="password"> <span id="password-error" class="help-block animated fadeInDown" style="display: none;"> <span>Please enter password for login</span> </span> </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label" for="val-confirm-password">Confirm Password <span class="text-blue">*</span></label> 
                        <div class="col-md-7"> <input class="form-control valid" placeholder="Repeat Password For Login" name="val-confirm-password" id="confirmpassword" type="password"> <span id="confirmpassword-error" class="help-block animated fadeInDown" style="display: none;"> <span>Repeat Password For Login not correct</span> </span> </div>
                     </div>
                     <div class="form-group" >
                        <label class="col-md-4 control-label" for="val-password">Transaction Password <span class="text-blue">*</span></label> 
                        <div class="col-md-7"> <input value="" class="form-control" id="password2" placeholder="Transaction Password" name="transaction_password" type="password"> <span id="password2-error" class="help-block animated fadeInDown" style="display: none;"> <span>Please enter transaction password</span> </span> </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label" for="val-confirm-password">Confirm Transaction Password <span class="text-blue">*</span></label> 
                        <div class="col-md-7"> <input value="" class="form-control valid" placeholder="Repeat Transaction Password" id="confirmpasswordtransaction" name="val-transaction_password" type="password"> <span id="confirmpasswordtransaction-error" class="help-block animated fadeInDown" style="display: none;"> <span>Repeat Transaction Password is not correct</span> </span> </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label" for="val-phone">Bitcoin Wallet <span class="text-blue">*</span></label> 
                        <div class="col-md-7"> <input class="form-control" id="BitcoinWalletAddress" placeholder="Bitcoin Wallet" data-link="<?php echo $actionWallet; ?>" name="wallet" type="text" /> <span id="BitcoinWalletAddress-error" class="help-block animated fadeInDown"> <span></span> </span> </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label"><a data-toggle="modal" data-target="#modal-terms" href="#"></a> <span class="text-blue">*</span></label> 
                        <div class="col-md-8"> <label class="css-input css-checkbox css-checkbox-default" for="val-terms"> <input type="checkbox" id="val-terms" name="val-terms" value="1" /><span></span> I agree to the terms </label> </div>
                     </div>
                     <div class="form-group">
                     <label class="col-md-4 control-label" >Captcha <span class="text-blue">*</span></label> 
                     <div class="col-md-7">
                           <div class="g-recaptcha" data-sitekey="6LddfR0UAAAAACS_dpL5mF7MKjejC7krk42LNvZQ"></div>
                           </div>
                        </div>
                     <div class="form-group m-b-0">
                        <div class="col-md-8 col-md-offset-4"> <button class="btn btn-app btn-frm-submit" type="submit">Submit</button> </div>
                     </div>
                  </form>
               </div>
               <!-- .card-block --> 
            </div>
            <!-- .card --> <!-- Bootstrap Forms Validation --> 
         </div>
         <!-- .col-lg-6 --> <!-- .col-lg-6 --> 
      </div>
   </div>
   <!-- End Page Content --> 
</main>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php echo $self->load->controller('common/footer_home'); ?>