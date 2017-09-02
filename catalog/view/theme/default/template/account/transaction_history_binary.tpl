<?php $self -> document -> setTitle($lang['heading_title']); echo $self -> load -> controller('common/header'); ?> <!-- Sidebar --> <?php echo $self->load->controller('common/column_left');  ?> 
<main class="app-layout-content">
   <!-- Page Content --> 
   <div class="container-fluid p-y-md">
      <div class="row">
         <div class="col-md-12">
            <!-- Card Tabs Default Style --> 
            <div class="card">
              <!--  <ul class="nav nav-tabs" data-toggle="tabs">
                  <li > <a href="#btabs-static-home">Amount Binary</a> </li>
                  <li class="active"> <a href="#btabs-static-profile">Binary bonus</a> </li>
               </ul> -->
               <div class="card-header">
                  <h4>Matching bonus</h4>
               </div>
               <div class="card-block tab-content">
                  <div class="tab-pane " id="btabs-static-home">
                     <div class="table-responsive" id="no-more-tables">
                        <table class="table table-striped table-borderless table-vcenter">
                           <thead>
                              <tr>
                                 <th class="text-center"><?php echo $lang['column_no'] ?></th>
                                 <th>Wallet</th>
                                 <th><?php echo $lang['column_date_added'] ?></th>
                                 <th><?php echo $lang['column_amount'] ?></th>
                                 <th><?php echo $lang['column_description'] ?></th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php $number = 1; foreach ($histotys as $key => $value) {?> 
                              <tr>
                                 <td data-title="<?php echo $lang['column_no'] ?>." align="center"><?php echo $number ?></td>
                                 <td data-title="Wallet"><?php echo $value['wallet'] ?></td>
                                 <td data-title="<?php echo $lang['column_date_added'] ?>"><?php echo date("d/m/Y H:i A", strtotime($value['date_added'])); ?></td>
                                 <td data-title="<?php echo $lang['column_amount'] ?>"><?php echo $value['text_amount'] ?></td>
                                 <td data-title="<?php echo $lang['column_description'] ?>"> <?php echo $value['system_decsription'] ?> </td>
                              </tr>
                              <?php $number++; } ?> 
                           </tbody>
                        </table>
                        <?php echo $pagination; ?> 
                     </div>
                  </div>
                  <div class="tab-pane active" id="btabs-static-profile">
                     <div class="table-responsive">
                        <table class="table table-striped table-borderless table-vcenter">
                           <thead>
                              <tr>
                                 <th class="text-center"><?php echo $lang['column_no'] ?></th>
                                 <th>Wallet</th>
                                 <th><?php echo $lang['column_date_added'] ?></th>
                                 <th><?php echo $lang['column_amount'] ?></th>
                                 <th><?php echo $lang['column_description'] ?></th>
                                 
                              </tr>
                           </thead>
                           <tbody>
                              <?php $number = 1; foreach ($getTransctionHistory_binary_new as $key => $value) {?> 
                              <tr>
                                 <td data-title="<?php echo $lang['column_no'] ?>." align="center"><?php echo $number ?></td>
                                 <td data-title="Wallet"><?php echo $value['wallet'] ?></td>
                                 <td data-title="<?php echo $lang['column_date_added'] ?>"><?php echo date("d/m/Y H:i A", strtotime($value['date_added'])); ?></td>
                                 <td data-title="<?php echo $lang['column_amount'] ?>"><?php echo $value['text_amount'] ?></td>
                                 <td data-title="<?php echo $lang['column_description'] ?>"> <?php echo $value['system_decsription'] ?> </td>
                               
                              </tr>
                              <?php $number++; } ?> 
                           </tbody>
                        </table>
                        <?php echo $pagination_new; ?> 
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- End Page Content --> 
</main>
<?php echo $self->load->controller('common/footer') ?>