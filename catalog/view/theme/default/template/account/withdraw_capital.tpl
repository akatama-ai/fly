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
                                          
                                          <ul class="card-actions">
                                            <li>
                                                <button type="button">Percent: <?php $check = $self->check_date($value['id']); echo $check; ?>%</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-block">
                                        <form class="form-horizontal frm_capital" action="confirm-sm-withdrawl-capital" method="post" onsubmit="return false;">
                                            <div class="form-group">
                                              <div class="col-xs-12">
                                                <code>Receipt No: #<?php echo $value['pd_number']; ?></code>
                                              </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-12" for="register1-password">Transaction Password</label>
                                                <div class="col-xs-12">
                                                    <input class="form-control" type="password" name="transaction_password" placeholder="Enter transaction password...">
                                                    <input type="hidden" value="<?php echo $value['id']; ?>" name="number">
                                                </div>
                                            </div>
                                             <?php if (intval($check) > 0) {
                                               ?>
                                            <div class="form-group m-b-0">
                                                <div class="col-xs-12">
                                                    <button class="btn btn-app" type="submit" style="border-color: <?php echo $bg; ?>;  background-color:<?php echo $bg; ?>">Withdrawing <?php echo $check; ?>% </button>
                                                </div>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="form-group m-b-0">
                                                <div class="col-xs-12">
                                                    <a href="javascript:void(0)" class="btn btn-app disabled" style="border-color: <?php echo $bg; ?>;  background-color:<?php echo $bg; ?>"><i class="fa fa-spinner fa-spin"></i> Please wait...</a>
                                                </div>
                                            </div>
                                            <?php } ?>
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
                         <div class="row">
         <div class="col-sm-12">
            <div class="card" id="sample-card">
               <div class="card-header">
                  <h4>History Withdrawal Capital</h4>
                  <ul class="card-actions">
                     <li>
                        <button type="button" data-toggle="card-action" data-action="fullscreen_toggle"><i class="ion-android-expand"></i></button>
                     </li>
                     <li>
                        <button type="button" data-toggle="card-action" data-action="content_toggle"><i class="ion-chevron-down"></i></button>
                     </li>
                  </ul>
               </div>
               <div class="card-block">
                  <div id="no-more-tables" class="table-responsive">
                     <table id="datatable" class="table  table-hover">
                        <thead>
                           <tr>
                              <th class="text-center">No.</th>
                              <!-- <th>Item</th> -->
                              <th>Date</th>
                              <th>Amount</th>
                              <th>Detail</th>
                              <th>Link</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $number = 1; foreach ($histotys as $key => $value) {?>
                           <tr>
                              <td data-title="No." align="center"><?php echo $number ?></td>
                              <!-- <td data-title="Item"><?php echo $value['wallet'] ?></td> -->
                              <td data-title="Date"><?php echo date("d/m/Y H:i A", strtotime($value['date_added'])); ?></td>
                              <td data-title="Amount"><?php echo $value['text_amount'] ?></td>
                              <td data-title="Detail">
                                 <?php echo $value['system_decsription'] ?>
                              </td>
                              <td data-title="Link">
                              <?php if (($value['url']) == ' ') {
                                echo '<button class="btn btn-app-orange btn-xs" type="button">Pending</button>';
                              }else{
                                echo '<button class="btn btn-xs btn-app-teal" type="button">'.$value['url'].'</button>';
                            
                                } ?>
                                
                              </td>
                           </tr>
                           <?php $number++; } ?>
                        </tbody>
                     </table>
                   
                  </div>
               </div>
            </div>
         </div>
      </div>
                           
                    </div>
                    <!-- End Page Content -->

                </main>
<?php echo $self->load->controller('common/footer') ?>