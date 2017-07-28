<?php $self->document->setTitle("Withdrawal"); echo $self->load->controller('common/header');?>
<!-- Sidebar -->
<?php echo $self->load->controller('common/column_left');  ?>
<!-- /#sidebar-wrapper -->
<!-- Page Content -->
<main class="app-layout-content">
   <!-- Page Content -->
   <div class="container-fluid p-y-md">
      <div class="row">
         <div class="col-lg-6 col-sm-6">
            <!-- Colors -->
            <div class="card">
               <div class="card-header">
                  <h4>Available for withdrawal</h4>
               </div>
               <div class="card-block">
                  <div class="row">
                     <form id="tranfer_cm_btc" action="index.php?route=account/withdraw/submit_my_transaction" method="post" onsubmit="return false;">
                        <div class="col-xs-12">
                           <div  data-link="<?php echo $self->url->link('account/withdraw/get_btc_usd'); ?>" id="amount_btc"></div>
                           <div class="checkbox">
                              <label for="checkbox1">
                              <input type="checkbox" id="refferal" name="FromWallet[]" data-value="<?php echo $refferal_profit; ?>" value="1"  <?php  echo $refferal_profit == 0 ? 'disable="true"' : ''; ?> > Refferal Commission <code><?php echo $refferal_profit; ?> USD</code>
                              </label>
                           </div>
                           <div class="checkbox">
                              <label for="checkbox2">
                              <input type="checkbox" id="binary" name="FromWallet[]" data-value="<?php echo $binary_bonus; ?>" value="2"> Binary Bonuses <code><?php echo $binary_bonus; ?> USD</code>
                              </label>
                           </div>
                           <div class="checkbox">
                              <label for="checkbox3">
                              <input type="checkbox" id="daily" name="FromWallet[]" data-value="<?php echo $profit_daily; ?>" value="3"> Profit Daily <code><?php echo $profit_daily; ?> USD</code>
                              </label>
                           </div>
                           <div class="checkbox">
                              <label for="checkbox3">
                              <input type="checkbox" id="division" name="FromWallet[]" data-value="<?php echo $getMWallet; ?>" value="4">  Co-division Commission <code><?php echo $getMWallet; ?> USD</code>
                              </label>
                           </div>
                           <div class="checkbox has-error">
                              <p class="help-block animated fadeInDown choose_wallet" style="display:none">Please Choose wallet withdrawal</p>
                           </div>
                           
                           <div class="form-group">
                              <label for="example-nf-password">Amount</label>
                              <div class="row">
                                 <div class="col-xs-6">
                                    <input class="form-control" type="text" readonly="true" id="amount_usd" name="amount_usd" placeholder="Amount withdrawal">
                                 </div>
                                 <span style=" position: absolute; font-size: 25px; margin-left: -5px; "> = </span>
                                 <div class="col-xs-6">
                                    <input class="form-control" type="text" readonly="true" id="amount_btc_val" name="amount_btc_val" placeholder="Amount btc withdrawal">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="example-nf-password">Password Transaction</label>
                              <input class="form-control" readonly="true" type="password" id="password_transaction_btc" name="password_transaction" placeholder="Enter Password Transaction..">
                               
                           </div>
                           <div class="form-group has-error">
                              <p class="error help-block error_password_transaction_btc" style="display:none">Please enter a transaction password</p>
                                <p class="help-block animated fadeInDown error_password_transaction_deal_btc" style="display:none">Password do not macth</p>
                           </div>

                          
                         <?php  if (intval($get_customer_setting['withdrawal_authenticator']) == 1) {
                            ?>
                            <div class="form-group">
                              <label for="example-nf-password">Code Authenticator</label>
                              <input class="form-control" type="password" id="password_transaction_btc" name="authenticator" placeholder="Enter code authenticator..">
                               
                           </div>
                             <div class="form-group has-error">
                              <p class="error help-block error_authenticator" style="display:none">Code Authenticator do not macth</p>
                               
                           </div>
                           <?php } ?>
                           <div class="form-group m-b-0">
                              <button class="btn btn-app" type="submit">Confirm</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <!-- .card-block -->
            </div>
            <!-- .card -->
            <!-- End Colors -->
         </div>
         <!-- .col-lg-6 -->
         <div class="col-lg-6 col-sm-6">
            <!-- Sizes -->
            <div class="card">
               <div class="card-header">
                  <h4>Your Wallet</h4>
               </div>
               <div class="card-block">
                  <div class="row">
                     <div class="col-xs-12 text-center">
                        <div class="item_wallet">
                           <div class="wallet wallet_blockcio">
                              <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?php echo $customer['wallet'] ?>" alt="" style=" float: none;  height: 200px;">
                           </div>
                           <p><?php echo $customer['wallet'] ?></p>
                          
                           <p></p>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- .card-block -->
            </div>
            <!-- .card -->
            <!-- End Sizes -->
         </div>
         <!-- .col-lg-6 -->
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div class="card" id="sample-card">
               <div class="card-header">
                  <h4>History Withdrawal</h4>
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
                     <?php echo $pagination; ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
    
   </div>
</main>
<!-- /#page-content-wrapper -->
<?php echo $self->load->controller('common/footer') ?>
<script type="text/javascript">
    $( document ).ready(function() {
        var xhtml = '<p>Notice: We are very sorry. Over the past few days Blockchain in the world has had issues relating to the interests of the Member. All is normal with no problems other than this. We will come back and pay normal starting from 01/08/2017 on Member Blockchain. We are looking forward to the cooperation of Member and Bitflyerbank will develop stronger in the future. <br> Thank you !</p>';
                            alertify.alert(xhtml, function(){
                                // window.funLazyLoad.reset();
                                //     // location.reload(true);
                              });
                        });
    </script>