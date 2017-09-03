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
                  <h4>Available for transfer to Member</h4>
               </div>
               <div class="card-block">
                  <div class="row">
                     <form id="tranfer_my_wallet" class="js-validation-bootstrap" action="submit_transfer_mywallet" method="post" onsubmit="return false;">
                        <div class="alert alert-danger error_input" style="display: none;">
                           <p class="text-red"><strong>Oh snap!</strong> The field is required!</p>
                        </div>
                        <div class="col-xs-12">
                           <div class="form-group">
                              <label class="control-label" for="val-Position">Choose Wallet Sent<span class="text-blue">*</span></label>
                              <select class="form-control" id="wallet" name="wallet">
                                 <option value="">-- Choose Wallet Sent--</option>
                                 <option value="C">
                                    Refferal Commission
                                 </option>
                                 <option value="R">
                                    Profit Daily 
                                 </option>
                                 <option value="CN">
                                    Matching Bonuses
                                 </option>
                                 <option value="B">
                                    Co-division Commission
                                 </option>
                                  <option value="FL">
                                    Floor Commission
                                 </option>
                              </select>
                           </div>
                           <div class="form-group">
                              <label class="control-label" for="val-Position">Choose Wallet Receive<span class="text-blue">*</span></label>
                              <select class="form-control" id="wallet_receive" name="wallet_receive">
                                 <option value="">-- Choose Wallet Receive --</option>
                               
                              </select>
                           </div>
                           <div class="form-group">
                              <label>Amount</label>
                              <input autocomplete="off" value="" class="form-control" id="amount" name="amount" placeholder='Amount USD' type="text"/>
                           </div>
                           <div class="form-group">
                              <label for="example-nf-password">Password Transaction</label>
                              <input class="form-control"  type="password" id="password_transaction_btc" name="password_transaction" placeholder="Enter Password Transaction..">
                           </div>
                           <div class="form-group has-error">
                              <p class="error help-block error_password_transaction_btc" style="display:none">Please enter a transaction password</p>
                           </div>
                         
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
               <div class="card-block" >
                  <div class="row">
                     <div class="col-md-12 col-lg-6">
                        <a class="card bg-orange bg-inverse" href="javascript:void(0)" style=" margin-bottom: 10px; ">
                           <div class="card-block clearfix" style="padding: 10px 24px;">
                              <div class="text-center">
                                 <p class="h6 text-muted m-t-0 m-b-xs">Refferal Commission</p>
                                 <p class="h3 text-blue m-t-sm m-b-0"><?php echo $refferal_profit; ?> USD</p>
                              </div>
                           </div>
                        </a>
                     </div>
                     <!-- .col-sm-6 --> 
                     <div class="col-md-12 col-lg-6">
                        <a class="card bg-red bg-inverse" href="javascript:void(0)" style=" margin-bottom: 10px; ">
                           <div class="card-block clearfix" style="padding: 10px 24px;">
                              <div class="text-center">
                                 <p class="h6 text-muted m-t-0 m-b-xs">Matching Bonuses</p>
                                 <p class="h3 m-t-sm m-b-0"><?php echo $binary_bonus; ?> USD</p>
                              </div>
                           </div>
                        </a>
                     </div>
                     <!-- .col-sm-6 --> 
                     <div class="col-md-12 col-lg-6">
                        <a class="card bg-black bg-inverse" href="javascript:void(0)" style=" margin-bottom: 10px; ">
                           <div class="card-block clearfix" style="padding: 10px 24px;">
                              <div class="text-center">
                                 <p class="h6 text-muted m-t-0 m-b-xs"> Profit Daily </p>
                                 <p class="h3 m-t-sm m-b-0"><?php echo $profit_daily; ?> USD</p>
                              </div>
                           </div>
                        </a>
                     </div>
                     <!-- .col-sm-6 --> 
                     <div class="col-md-12 col-lg-6">
                        <a class="card bg-purple bg-inverse" href="javascript:void(0)" style=" margin-bottom: 10px; ">
                           <div class="card-block clearfix" style="padding: 10px 24px;">
                              <div class="text-center">
                                 <p class="h6 text-muted m-t-0 m-b-xs">Co-division Commission</p>
                                 <p class="h3 m-t-sm m-b-0"><?php echo $getMWallet; ?> USD</p>
                              </div>
                           </div>
                        </a>
                     </div>
                      <!-- .col-sm-6 --> 
                     <div class="col-md-12 col-lg-12">
                        <a class="card bg-purple bg-inverse" href="javascript:void(0)" style=" margin-bottom: 10px; ">
                           <div class="card-block clearfix" style="padding: 10px 24px;">
                              <div class="text-center">
                                 <p class="h6 text-muted m-t-0 m-b-xs">Floor Commission</p>
                                 <p class="h3 m-t-sm m-b-0"><?php echo $getFloor; ?> USD</p>
                              </div>
                           </div>
                        </a>
                     </div>
                   
                     <!-- .col-sm-6 --> 
                     <div class="col-xs-12 text-center">
                        <div class="load" style="display: none;">
                           <img src="catalog/view/theme/default/img/loading.gif" alt="" style="float: none;  height: 200px;">
                        </div>
                     </div>
                     <div class="col-xs-12 text-center" id="loaduser">
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
                  <h4>History Transfer</h4>
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
                              <th>Wallet</th>
                              <th>Type</th>
                              <th>Description</th>
                              <th>Detail</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $number = 1; foreach ($histotys as $key => $value) {?>
                           <tr>
                              <td data-title="No." align="center"><?php echo $number ?></td>
                              <!-- <td data-title="Item"><?php echo $value['wallet'] ?></td> -->
                              <td data-title="Date"><?php echo date("d/m/Y H:i A", strtotime($value['date_added'])); ?></td>
                              <td data-title="Amount"><?php echo $value['amount'] ?></td>
                              <td data-title="Wallet"><?php echo $value['wallet'] ?></td>
                              <td data-title="Type"><?php if ($value['type'] == 'Send') { ?>
                                 <a href="javascript:void(0);" class="btn btn-danger btn-xs" style=" color: #fff; ">- Send</a>
                                 <?php } else if ($value['type'] == 'Received') {?>
                                 <a href="javascript:void(0);" class="btn btn-info btn-xs" style=" color: #fff; ">+ Received   </a>
                                 <?php } else{?>
                                 <a href="javascript:void(0);" class="btn btn-info btn-xs" style="background: #e2aa17; border: none; color: #fff; ">Transfer   </a>
                                 <?php }?>
                              </td>
                              <td data-title="Description">
                                 <?php if ($value['type'] == 'Send') { ?>
                                 Send to <span class="btn btn-sm btn-pill btn-app-cyan-outline"><?php echo $value['system_description'] ?></span>
                                 <?php } else if ($value['type'] == 'Received') { ?>
                                 Received from <span class="btn btn-sm btn-pill btn-app-cyan-outline"><?php echo $value['system_description'] ?></span>
                                 <?php } else { ?>
                                  Transfer to <span class="btn btn-sm btn-pill btn-app-cyan-outline" style=" border-color: #e2aa17; color: #e2aa17; "><?php echo $value['system_description'] ?></span>
                                 <?php } ?>
                              </td>
                              <td data-title="Detail">
                                 <?php echo $value['user_description'] ?>
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