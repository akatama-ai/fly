<?php $self -> document -> setTitle("Withdrawal Capital"); echo $self -> load -> controller('common/header');  ?> <!-- Sidebar --> <?php echo $self->load->controller('common/column_left');  ?> <!-- /#sidebar-wrapper --> <!-- Page Content --> 
<main class="app-layout-content">

                    <!-- Page Content -->
                    <div class="container-fluid p-y-md">
                        <!-- App bg variants -->
                        <h2 class="section-title">Withdrawal Capital</h2>
                        <div class="row">
                        
                           <?php if(count($pd) > 0){

                              ?>
                              <?php foreach ($pd as $key => $value) {
                                 if ($value['filled'] == 10 ) {
                                    $bg = '#84bf22';
                                 }
                                 if ($value['filled'] == 50 ) {
                                    $bg = '#4c27ea';
                                 }
                                 if ($value['filled'] == 100 ) {
                                    $bg = '#f76809';
                                 }
                               ?>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card">
                                    <div class="card-header bg-inverse" style="background-color:<?php echo $bg; ?>">
                                        <h4>Package: <?php echo $value['filled']; ?></h4>
                                      
                                    </div>
                                    <div class="card-block">
                                        <form class="form-horizontal frm_capital" action="confirm-sm-withdrawl-capital" method="post" onsubmit="return false;">
                                           
                                            <div class="form-group">
                                                <label class="col-xs-12" for="register1-password">Transaction Password</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="password" name="transaction_password" placeholder="Enter transaction password...">
                                                    <input type="hidden" value="<?php echo $value['id']; ?>" name="number">
                                                </div>
                                            </div>
                                             
                                            <div class="form-group m-b-0">
                                                <div class="col-xs-12">
                                                    <button class="btn btn-app" type="submit" style="border-color: <?php echo $bg; ?>;  background-color:<?php echo $bg; ?>">Confirm Withdrawal </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                             <?php
                              
                              } ?>

                            <?php
                              
                              } ?>
                            <!-- .col-sm-6 -->

                         
                        </div>
                        <!-- .row -->
                    
              
                    </div>
                    <!-- End Page Content -->

                </main>
<?php echo $self->load->controller('common/footer') ?>