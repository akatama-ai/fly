<?php $self -> document -> setTitle($lang['heading_title']); echo $self -> load -> controller('common/header'); ?> <?php echo $self->load->controller('common/column_left');  ?> <!-- /#sidebar-wrapper --> <!-- Page Content --> 
<main class="app-layout-content">
   <!-- Page Content --> 
   <div class="container-fluid p-y-md">
      <div class="card card-profile">
         <div class="card-profile-img bg-img" style="background-image: url(catalog/view/theme/default/img/base_pages_profile_header_bg.jpg);"> </div>
         <div class="card-block card-profile-block text-xs-center text-sm-left">
          <div id="login" ng-app='Biflyerbank_app' ng-controller='sign_up'>
            <form ng-submit="GroopAddImage()">
               <span class="edit_icon">

               <input type="file" name="file" id="file"   accept="image/*" style="visibility: hidden; width: 1px; height: 1px"> 
               <?php if(!$customer['img_profile']){ ?> 
               <a href="" onclick="document.getElementById('file').click(); return false">
                <img id="blah" class="img-avatar img-avatar-96" src="#" style="display:none;" />
                 <img id="old_img" class="img-avatar img-avatar-96" src="catalog/view/theme/default/stylesheet/icons/user-avatar.jpg">
                 </a> <?php } ?> <?php if($customer['img_profile']){ ?>
                  <a onclick="document.getElementById('file').click(); return false"> 
                     <img id="blah" class="img-avatar img-avatar-96" src="#" style="display:none;" />
                 <img id="old_img" class="img-avatar img-avatar-96" src="<?php echo $customer['img_profile'] ?>" alt=""></a> <?php } ?> 
                 </span> 
               <div class="inner_pages_heading">
                  <!-- <h4>Avatar</h4> --> 
               </div>
               <br>
               <div id="btn_save" class="" style="display:none; position: absolute; "> 
               <button type="submit" class="btn btn-xs btn-pill btn-app-teal">Save</button> </div>
   

            </form>
            </div>
            <div class="profile-info font-500">
               <?php echo $customer['username'] ?> 
               <div class="small text-muted m-t-xs"><?php echo $customer['email'] ?></div>
            </div>
         </div>
      </div>
     
      <div class="row">
         <div class="col-md-3">
            <div class="card">
               <ul class="nav nav-tabs nav-stacked">
                  <li class="active"> <a href="#profile-tab1" data-toggle="tab">Account</a> </li>
                  <li> <a href="#profile-tab2" data-toggle="tab">Password Login</a> </li>
                  <li> <a href="#profile-tab4" data-toggle="tab">Transaction Password</a> </li>
                  <li> <a href="#profile-tab5" data-toggle="tab">Wallet</a> </li>
                  <li> <a href="#profile-Security" data-toggle="tab">Security and privacy</a> </li>
               </ul>
               <!-- .nav-tabs --> 
            </div>
            <!-- .card --> 
         </div>

         <!-- .col-md-4 --> 
         <div class="col-md-9">
            <div class="card">
               <div class="card-block tab-content">
                  <!-- Profile tab 1 --> 
                  <div class="tab-pane fade in active" id="profile-tab1">
                     <div class="message-box" id="EditProfile" data-link="<?php echo $self -> url -> link('account/setting/account', '', 'SSL'); ?>" data-id="<?php echo $self->session -> data['customer_id'] ?>" >
                        <form class="fieldset" id="updateProfile" action="<?php echo $self -> url -> link('account/setting/update_profile', '', 'SSL'); ?>" method="post">
                           <h4 class="m-t-sm m-b">General info</h4>
                           <div class="form-group row">
                              <div class="col-xs-12"> <label for="exampleInputName1">Username</label> <input type="text" class="form-control" id="UserName" name='username' readonly='true' value="" data-link="<?php echo $self -> url -> link('account/register/checkuser', '', 'SSL'); ?>" /> </div>
                              <div class="col-xs-12"> <label for="exampleInputName2">Country</label> <input class="form-control" id="Country" name='countryname'  type="text" readonly='true' value="" /> </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-xs-12"> <label for="exampleInputPhone1">Email</label> <input class="form-control" data-link="<?php echo $self -> url -> link('account/register/checkemail', '', 'SSL'); ?>" id="Email" name="email" readonly='true' type="text" value="" /> </div>
                              <div class="col-xs-12"> <label for="exampleInputPhone2">Phone number</label> <input class="form-control" data-link="<?php echo $self -> url -> link('account/register/checkphone', '', 'SSL'); ?>" class="form-control" id="Phone" readonly='true' name="telephone" type="text" value="" /> </div>
                              <div class="col-xs-12"> <label for="Citizenship">Citizenship Card/Passport No</label> <input class="form-control" class="form-control" id="Citizenship" readonly='true' name="Citizenship" type="text" value="" /> </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-xs-12"> <label for="exampleInputPassword1">Affiliate Since:</label> <input type="text"  id="Date" readonly='true' value="" placeholder="" spellcheck="false" class="form-control sbg info-city" /> </div>
                              <div class="col-xs-12"> <label for="exampleInputPassword2">Last Login IP:</label> <input type="text"  id="LastIP" value="" readonly='true' placeholder="" spellcheck="false" class="form-control sbg info-region" /> </div>
                           </div>
                           <div class="row narrow-gutter">
                              <!--  <div class="col-xs-6"> <button type="button" class="btn btn-default btn-block">Cancel</button> </div> <div class="col-xs-6"> <button type="submit" class="btn btn-app btn-block">Save<span class="hidden-xs"> changes</span></button> </div> --> 
                           </div>
                        </form>
                     </div>
                  </div>
                  <!-- End profile tab 1 --> <!-- Profile tab 2 --> <!-- Profile tab 3 --> 
                  <div class="tab-pane fade" id="profile-tab2">
                     <form class="fieldset" id="frmChangePassword" action="<?php echo $self -> url -> link('account/setting/editpasswd', '', 'SSL'); ?>" method="post">
                        <h4 class="m-t-md m-b">Change password</h4>
                        <div class="form-group row">
                           <div class="col-xs-12"> <label for="exampleInputPassword1">Confirm current password</label> <input type="password" class="form-control" id="OldPassword"  data-link="<?php echo $self -> url -> link('account/setting/checkpasswd', '', 'SSL'); ?>"  /> <span id="OldPassword-error" class="field-validation-error"> <span></span> </span> </div>
                           <div class="col-xs-12"> <label for="exampleInputPassword3">New password</label> <input type="password" class="form-control" id="ConfirmPassword" /> <span id="Password-error" class="field-validation-error"> <span></span> </span> </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-xs-12"> <label for="exampleInputPassword2">Confirm new password</label> <input type="password" class="form-control" id="Password" name="password"  /> <span id="ConfirmPassword-error" class="field-validation-error"> <span></span> </span> </div>
                        </div>
                        <div class="row narrow-gutter">
                           <!-- <div class="col-xs-6"> <button type="button" class="btn btn-default btn-block">Cancel</button> </div> -->
                           <div class="col-xs-6"> <button type="submit" class="btn btn-app btn-block">Save<span class="hidden-xs"> changes</span></button> </div>
                        </div>
                     </form>
                  </div>
                  <!-- End profile tab 3 --> <!-- Profile tab 4 --> 
                  <div class="tab-pane fade" id="profile-tab4">
                     <form class="fieldset" id="changePasswdTransaction" action="<?php echo $self -> url -> link('account/setting/edittransactionpasswd', '', 'SSL'); ?>"  method="post" novalidate="novalidate">
                        <h4 class="m-t-md m-b">Change password</h4>
                        <div class="form-group row">
                           <div class="col-xs-12"> <label for="exampleInputPassword1">Confirm current password</label> <input type="password" class="form-control" id="TranoldPassword" type="password" data-link="<?php echo $self -> url -> link('account/setting/checkpasswdtransaction', '', 'SSL'); ?>"  /> <span id="TranoldPassword-error" class="field-validation-error"> <span></span> </span> </div>
                           <div class="col-xs-12"> <label for="exampleInputPassword3">New password</label> <input type="password" class="form-control" id="Tranpassword_New" name="transaction_password" /> <span id="Tranpassword_New-error" class="field-validation-error"> <span></span> </span> </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-xs-12"> <label for="exampleInputPassword2">Confirm new password</label> <input type="password" class="form-control" id="TranConfirmPassword"  /> <span id="TranConfirmPassword-error" class="field-validation-error" style="display:none"> <span></span> </span> </div>
                        </div>
                        <div class="row narrow-gutter">
                           <div class="col-xs-6"> <a data-link="<?php echo $self -> url -> link('account/forgotten/resetPasswdTran', '', 'SSL'); ?>" data-id="<?php echo $self->session -> data['customer_id'] ?>" id="reset_passwdTran" href="javascript:;" class="btn btn-info btn-block">Reset Transaction Password</a> </div>
                           <div class="col-xs-6"> <button type="submit" class="btn btn-app btn-block">Save<span class="hidden-xs"> changes</span></button> </div>
                        </div>
                     </form>
                  </div>
                  <!-- End profile tab 4 --> <!-- Profile tab 5 --> 
                  <div class="tab-pane fade" id="profile-tab5">
                     <form class="fieldset">
                        <h4 class="m-t-sm m-b">General info</h4>
                        <div class="form-group row"> <label for="exampleInputName1">Wallet</label> <input type="text" class="form-control" readonly id="BitcoinWalletAddress" /> </div>
                        <div class="form-group row">
                           <div id="bitcoin-image" data-img="https://chart.googleapis.com/chart?chs=200x200&amp;cht=qr&amp;chl=">
                              <div class="form-group"> <img style="border:1px solid #cecece"/> </div>
                           </div>
                        </div>
                        <!--   <div class="form-group row"> <label for="exampleInputPassword3">Password</label> <input type="password" class="form-control" id="exampleInputPassword3" /> </div> --> 
                        <div class="row narrow-gutter">
                           <!-- <div class="col-xs-6"> <button type="button" class="btn btn-default btn-block">Cancel</button> </div>
                           <div class="col-xs-6"> <button type="button" class="btn btn-app btn-block">Save<span class="hidden-xs"> changes</span></button> </div> -->
                        </div>
                     </form>
                  </div>
                  <!-- End profile tab 5 --> <!-- Profile tab 6 --> 
                  <div class="tab-pane fade" id="profile-Security">
                    
                     <div class="control-group">
                        
                        <br>
                        <div class="row">
                           <div class="col-lg-12">
                                <!-- Colors -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Authenticator</h4>

                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                        <div class="col-xs-12">
                                         
                        <i style="font-size: 14px;">Use the Authenticator app to receive a free verification code even if your phone is offline. Available for Android and iPhone.</i>
                          <br>
                                        </div>
                                        <div class="clearfix"></div>
                                          <br>
                                          <div class="col-xs-12">
                                             <div class="text-center">
                                                <form id="updateauthenticator" action="<?php echo $self -> url -> link('account/setting/updateauthenticator', '', 'SSL'); ?>" method="GET" novalidate="novalidate">
                                                   <?php if ($get_customer_setting['check_authenticator'] == 0) {
                                                      ?>
                                                   <img style="width: 130px;" src="<?php echo $qrCodeUrl;?>">
                                                   <p style="font-size: 16px;"><?php echo $secret ?></p>
                                                   <?php } ?>
                                                   <input style="width: 150px; float: none;margin: 0 auto" class="form-control" name="ip_authenticator" id="ip_authenticator" value="" size="15" placeholder="000000">
                                                   <input type="hidden" name="key_authenticator" value="<?php echo $secret ?>">
                                                   <?php if ($get_customer_setting['status_authenticator'] == 0) { ?>
                                                   <input type="hidden" name="status" value="1">
                                                   <button style=" margin-top: 5px; margin-bottom: 20px;" type="submit" class="btn btn-warning btn-md" name="toggle_login_emails" id="toggle_login_emails">
                                                   Enable Authenticator
                                                   </button>
                                                   <?php } else { ?>
                                                   <input type="hidden" name="status" value="0">
                                                   <button style=" margin-top: 5px; margin-bottom: 20px;" type="submit" class="btn btn-danger btn-md" name="toggle_login_emails" id="toggle_login_emails">
                                                   Disable Authenticator
                                                   </button>
                                                   <?php } ?>
                                                </form>
                                             </div>
                                          </div>
                                          <?php if ($get_customer_setting['status_authenticator'] == 1) { ?>
                                            <div class="col-xs-6">
                                    <form id="update_authenticator_withdrawal" method="POST" novalidate="novalidate">
                                       <div id="link_update" data-link="<?php echo $self -> url -> link('account/setting/update_authenticator_withdrawal', '', 'SSL'); ?>">
                                           <label class="css-input switch switch-success">
                                           Use Authenticator for Withdrawal
                                       </label>
                                       </div>
                                       <div class="col-xs-6">
                                          
                                          <label class="css-input css-radio css-radio-default m-r-sm">
                                             <input type="radio" value="yes" name="radioAuthen" <?php echo $get_customer_setting['withdrawal_authenticator'] == 0 ? '' : 'checked=""'; ?> ><span></span> Yes
                                          </label>
                                          <label class="css-input css-radio css-radio-default">
                                             <input type="radio" value="no" name="radioAuthen" <?php echo $get_customer_setting['withdrawal_authenticator'] == 0 ? ' checked=""' : ''; ?>><span></span> No
                                          </label>
                                       </div>
                                    </form>


                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- .card-block -->
                                </div>
                                <!-- .card -->
                                <!-- End Colors -->
                            </div>
                        </div>
                        
                     </div>
                  </div>
                  <!-- End profile tab 6 --> 
               </div>
               <!-- .card-block .tab-content --> 
            </div>
            <!-- .card --> 
         </div>
         <!-- .col-md-8 --> 
      </div>
      <!-- .row --> 
   </div>
   <!-- End Page Content --> 
</main>
<script type="text/javascript">window.username='<?php echo $customer['username'] ?>'; if (location.hash === '#success') {alertify.set('notifier','delay', 100000000); alertify.set('notifier','position', 'top-right'); alertify.success('Update profile successfull !!!'); } </script> 
         <script src="catalog/view/javascript/angular/angular.js"></script>
        <script src="catalog/view/javascript/angular/app.js" type="text/javascript"></script>
        <script src="catalog/view/javascript/angular/home.js" type="text/javascript"></script>
        <script src="catalog/view/javascript/angular/firebase/firebase.js"></script>
  <script src="catalog/view/javascript/angular/firebase/angularfire.min.js"></script>

<script src="https://www.gstatic.com/firebasejs/3.7.6/firebase.js"></script>

<?php echo $self->load->controller('common/footer') ?>