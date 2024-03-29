<?php $self->document->setTitle("Home"); echo $self->load->controller('common/header_home'); ?> <script src='https://www.google.com/recaptcha/api.js'></script>
<main class="app-layout-content frm">
   <!-- End Page header --> <!-- Page content --> 
   <div class="page-content" style="min-height: 700px;">
      <button class="btn btn-pill btn-success" type="button" onclick="location.href='index.html';" style="padding: 5px 30px;position: absolute;left: 10px;top: 10px;"><i class="ion-arrow-left-a"></i></button>
      <div class="container">
         <div class="row">
            <!-- Login card --> 
            <div class="col-sm-6 col-sm-offset-3">
               <div class="card" style=" border-radius: 10px;     margin-top: 90px;">
                  <div class="card-header text-center"> <img class="img-responsive" src="catalog/view/theme/default/img/logo.png" title="BitflyerBank" alt="BitflyerBank" /> </div>
                  <div class="card-block">
                     <div class="row">
                        <?php if ($redirect) { ?> <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" /> <?php } ?> <?php if ($success) { ?> 
                        <div class="alert alert-success">
                           <p> <?php echo $success; ?></p>
                        </div>
                        <?php } ?> <?php if ($error_warning) { ?> 
                        <div class="alert alert-danger">
                           <p><?php echo $error_warning; ?></p>
                        </div>
                        <?php } ?> 
                     </div>
                     <form class="js-validation-bootstrap form-horizontal" action="login.html" method="post">
                        <div class="form-group">
                           <div> <label class="sr-only" for="frontend_login_username">Username</label> <input t autocomplete="off" type="text" id="email" name="email" value="<?php echo $email; ?>" placeholder="Your Username" class="form-control"/> </div>
                        </div>
                        <div class="form-group">
                           <div> <label class="sr-only" for="frontend_login_password">Password</label> <input  autocomplete="off" type="password" id="password" name="password" value="<?php echo $password; ?>" placeholder="Your Password" class="form-control"/> </div>
                        </div>
                      
                        <div class="form-group">
                           <div class="g-recaptcha" data-sitekey="6LddfR0UAAAAACS_dpL5mF7MKjejC7krk42LNvZQ"></div>
                        </div>
                        <button type="submit" class="btn btn-app notranslate btn-block">Login</button> 
                     </form>
                     <div class="text-center text-forgot"><a href="forgot.html">Forgot Password?</a></div>
                  </div>
                  <!-- .card-block --> 
               </div>
               <!-- .card --> 
            </div>
            <!-- .col-md-6 --> <!-- End login --> <!-- Sign up --> 
         </div>
         <!-- .row --> 
      </div>
      <!-- .container --> 
   </div>
   <!-- End page content --> 
</main>
<?php echo $self->load->controller('common/footer_home'); ?>