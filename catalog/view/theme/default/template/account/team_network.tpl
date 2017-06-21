<?php $self -> document -> setTitle('Team Network Summary'); echo $self -> load -> controller('common/header'); ?> <!-- Sidebar --> <?php echo $self->load->controller('common/column_left');  ?> <!-- /#sidebar-wrapper --> <!-- Page Content --> 
<main class="app-layout-content">
   <!-- Page Content --> 
   <div class="container-fluid p-y-md">
      <!-- Modern Design --> 
     
      <div class="card">
       <div class="card-header">
              
                  <h4>Team Network Summary</h4>
                
               </div>
         <div class="card-block">
          <div class="row pd5">
                   <div class="col-sm-2 col-xs-3">
                                    <div class="item-quick-access ">
                                           <img src="catalog/view/theme/default/stylesheet/icons/3.png">
                                           <p><a href="column-tree.html">Blank</a></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-3">
                                        <div class="item-quick-access">
                                             <img src="catalog/view/theme/default/stylesheet/icons/6.png" >
                                             <p><a href="column-tree.html">In Active</a></p>
                                        </div>
                                    </div>
                                   
                                    <div class="col-sm-4 col-xs-3">
                                        <div class="item-quick-access">
                                             <img src="catalog/view/theme/default/stylesheet/icons/2.png" >
                                             <p><a href="column-tree.html">10 USD</a></p>
                                        </div>
                                    </div>
                                     <div class="col-sm-2 col-xs-3">
                                        <div class="item-quick-access">
                                             <img src="catalog/view/theme/default/stylesheet/icons/4.png" >
                                             <p><a href="column-tree.html">50 USD  </a></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-12">
                                        <div class="item-quick-access">
                                             <img src="catalog/view/theme/default/stylesheet/icons/7.png" >
                                             <p><a href="column-tree.html">100 USD  </a></p>
                                        </div>
                                    </div>
                     
                  </div>
             
         </div>
       
         <!-- .card-block --> 
      </div>
      <div class="card">
        <div class="row">
            <div class="col-md-6">
              <div class="card-box">
                <div class="card-header">
                  <h4 class="header-title"><b>Number Team Network</b></h4>
                </div>
                <div class="card-box-content form-compoenent">
                  <div class="table-responsive data-table">
                    <table class="table table-bordred table-striped">
                      <thead>
                        <tr>
                          <th><b>#</b></th>
                          <th><b>Left</b></th>
                          <th><b>Right</b></th>
                          <th><b>Total</b></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td> <img src="catalog/view/theme/default/css/icons/3.png" style=" width: 41px; "></td>
                          <td><?php echo $total_binary_left ?></td>
                          <td><?php echo $total_binary_right ?></td>
                          <td><?php echo ($total_binary_left+$total_binary_right); ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card-box">
                <div class="card-header">
                  <h4 class="header-title"><b>Amount Team Network</b></h4>
                </div>
                <div class="card-box-content form-compoenent">
                     <div class="table-responsive data-table">
                    <table class="table table-bordred table-striped">
                      <thead>
                        <tr>
                          <th><b>#</b></th>
                          <th><b>Left</b></th>
                          <th><b>Right</b></th>
                          <th><b>Total</b></th>
                        </tr>
                      </thead>
                      <tbody>
                        <!--  <tr>
                          <td> Total</td>
                          <td><?php echo number_format($total_amount_left) ?> USD</td>
                          <td><?php echo number_format($total_amount_right) ?> USD</td>
                          <td><?php echo number_format($total_amount_left+$total_amount_right); ?> USD</td>
                        </tr> -->
                        <tr>
                          <td> Current</td>
                          <td><?php echo number_format($total_pd_left) ?> USD</td>
                          <td><?php echo number_format($total_pd_right) ?> USD</td>
                          <td><?php echo number_format($total_pd_left+$total_pd_right); ?> USD</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
        
          
          </div>
      </div>
   </div>
</main>
<?php echo $self->load->controller('common/footer') ?>