<?php $self->document->setTitle("Home"); echo $self->load->controller('common/header_home'); ?>
<main class="app-layout-content frm">
   
   <!-- End Page header -->
   <!-- Page content -->
   <div class="page-content" style="min-height: 700px;">
      <div class="container">
         <div class="row">
            <!-- Login card -->
            <div class="col-sm-6 col-sm-offset-3">
               <div class="card" style=" border-radius: 10px;     margin-top: 90px;">
               <div class="card-header text-center">
                <img class="img-responsive" src="catalog/view/theme/default/img/logo.png" title="BitflyerBank" alt="BitflyerBank" />
               </div>
                  <div class="card-block text-center">
                    <p class="t-justify" style="text-indent: 1.5em;color: #fff;"><h2 style="color: #fff;">Congratulations you have registered an account at BitflyerBank Ltd!</h2></p>
                     <p>
                                            <button class="btn btn-pill btn-success" type="button" onclick="location.href='login.html';" style=" padding: 5px 30px; ">Login</button>
                                            <button class="btn btn-pill btn-danger" type="button" onclick="location.href='index.html';" style=" padding: 5px 30px; ">Home</button>
                                        </p>
                    
                  </div>
                  <!-- .card-block -->
               </div>
               <!-- .card -->
            </div>
            <!-- .col-md-6 -->
            <!-- End login -->
            <!-- Sign up -->
         </div>
         <!-- .row -->
      </div>
      <!-- .container -->
   </div>
   <!-- End page content -->
</main>
<?php echo $self->load->controller('common/footer_home'); ?>