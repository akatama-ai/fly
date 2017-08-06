<?php $self -> document -> setTitle("Invesment Detail"); echo $self -> load -> controller('common/header');  ?> <!-- Sidebar --> <?php echo $self->load->controller('common/column_left');  ?> <!-- /#sidebar-wrapper --> <!-- Page Content --> 
<main class="app-layout-content">
   <!-- Page Content --> 
   <div class="container-fluid p-y-md">
      <!-- Modern Design --> 
   
      <div class="card">
         <?php if(count($pds) > 0){?>
          <div class="card-header">
              
                  <h4>INVESTMENT</h4>
                
               </div>
         <div class="card-block">
            <div class="table-responsive" id="no-more-tables">
               <table class="table table-striped table-borderless table-vcenter">
                  <thead>
                     <tr>
                        <th>Receipt No.</th>
                        <th>Time Created</th>
                        <th>Package</th>
                        <th>Profit</th>
                        <th>status</th>
                        <!-- <th>Time</th> -->
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($pds as $value=> $key){?> 
                     <tr>
                        <td data-title="Receipt No."># <?php echo $key['pd_number'] ?> </td>
                        <td data-title="Date Created"> <?php echo date("Y-m-d H:i:A", strtotime($key['date_added'])); ?> </td>
                        <td data-title="Package"> <?php echo number_format($key['filled']) ?> USD </td>
                        <td data-title="Profit"> <?php echo ($key['max_profit']/1000000) ?> USD </td>
                        <td data-title="Status" class="status"> <?php 
                        switch (intval($key['status'])) {
                           case 0: echo '<span class="label label-default">Waitting</span>'; 
                           break; 
                           case 1: echo '<span class="label label-info">Active</span>'; 
                           break; case 2: echo '<span class="label label-success">Finish</span>'; break; } ?> </td>
                        <!-- <td data-title="Time"> <span style="color:; font-size:15px;" class="text- countdown" data-countdown="<?php echo  $key['date_finish'] ?>"> </span> </td> -->
                     </tr>
                     <?php }?> 
                  </tbody>
               </table>
               <?php echo $pagination; ?>
            </div>
         </div>
         <?php } ?> <!-- .card-block --> 
      </div>
      <!-- .row --> 
      <h2 class="section-title">Investment package</h2>
      <div class="card">
      <div class="card-header">
              
                  <h4>INVESTMENT PACKAGE</h4>
                
               </div>
         <div class="card-block">
         <!-- Developer Plan --> 
         <div class="col-sm-6 col-lg-3">
            <?php $packet = $self -> check_packet_pd (10) ;?>
            <?php $count_package = $self -> count_check_packet_pd(10);?>
             <?php if(count($packet) > 0) { ?> 
            <div class="ribbon-wrapper" style="left: 16px;">
               <?php if (intval($packet['status']) === 0) {?> 
               <div class="ribbon-design red" style="transform: rotate(310deg);left: -32px;background-color:#202a3a">Watting</div>
               <?php } ?>
             </div>  
            <?php }?>    
   
               <?php if (intval($count_package['number']) > 0) { ?>
               <div class="ribbon-wrapper">
                <div class="ribbon-design red" style="background-color:#e74b57">Actived <span style=" border: 1px solid #f00; padding: 4px 7px; border-radius: 13px; background: #202a3a; "><?php echo $count_package['number']; ?></span></div>
               </div>
                <?php }?> 
            

          
            <div class="card hover-shadow-3 text-center" href="javascript:void(0)">
               <div class="card-header pricing">
                  <h4 class="h3">Plan 01</h4>
               </div>
               <div class="card-block card-block-full bg-black bg-inverse">
                  <div class="h1 m-y-sm">10 USD</div>
                  <div class="h5 font-300 text-muted m-t-0">Earn 1.5% - 5% weekly</div>
               </div>
               <div class="card-block">
                  <table class="table table-borderless table-condensed">
                     <tbody>
                        <tr>
                           <td>Direct commissions : 15%</td>
                        </tr>
                        <tr>
                           <td>Duration: 300 days</td>
                        </tr>
                        <tr>
                           <td>Accept: Bitcoin</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <div class="card-block card-block-mini card-block-full bg-gray-lighter-o">
                  <?php if (count($packet) === 0) {?> 
                  <form method="GET" class="packet-invest" action="<?php echo $self->url->link('account/pd/pd_investment', '', 'SSL'); ?>"> <input type="hidden" name="invest" value="0"> <button class="btn btn-info notranslate">Upgrade Now</button> </form>
                  <?php } else {?> 
                  <form method="GET" class="packet-invoide" action="<?php echo $self->url->link('account/pd/packet_invoide', '', 'SSL'); ?>"> <input type="hidden" name="invest" value="<?php echo $packet['pd_number'] ?>"> <button class="btn btn-info notranslate"><i class="fa fa-spinner fa-spin"></i> Reviews</button> </form>
                  <?php } ?> 
               </div>
            </div>
         </div>
         <!-- .col-sm-6 --> <!-- End Developer Plan --> <!-- Startup Plan --> 
         <div class="col-sm-6 col-lg-3">
           <?php $packet = $self -> check_packet_pd (50) ;?>
            <?php $count_package = $self -> count_check_packet_pd(50);?>
             <?php if(count($packet) > 0) { ?> 
            <div class="ribbon-wrapper" style="left: 16px;">
               <?php if (intval($packet['status']) === 0) {?> 
               <div class="ribbon-design red" style="transform: rotate(310deg);left: -32px;background-color:#202a3a">Watting</div>
               <?php } ?>
             </div>  
            <?php }?>    
   
               <?php if (intval($count_package['number']) > 0) { ?>
               <div class="ribbon-wrapper">
                <div class="ribbon-design red" style="background-color:#e74b57">Actived <span style=" border: 1px solid #f00; padding: 4px 7px; border-radius: 13px; background: #202a3a; "><?php echo $count_package['number']; ?></span></div>
               </div>
                <?php }?> 
            <div class="card hover-shadow-3 text-center" href="javascript:void(0)">
               <div class="card-header pricing">
                  <h4 class="h3">Plan 02</h4>
               </div>
               <div class="card-block card-block-full bg-red bg-inverse">
                  <div class="h1 m-y-sm">50 USD</div>
                  <div class="h5 font-300 text-muted m-t-0">Earn 1.5% - 5% weekly</div>
               </div>
               <div class="card-block">
                  <table class="table table-borderless table-condensed">
                     <tbody>
                        <tr>
                           <td>Direct commissions : 15%</td>
                        </tr>
                        <tr>
                           <td>Duration: 300 days</td>
                        </tr>
                        <tr>
                           <td>Accept: Bitcoin</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <div class="card-block card-block-mini card-block-full bg-gray-lighter-o">
                  <?php if (count($packet) === 0) {?> 
                  <form method="GET" class="packet-invest" action="<?php echo $self->url->link('account/pd/pd_investment', '', 'SSL'); ?>"> <input type="hidden" name="invest" value="1"> <button class="btn btn-app-blue notranslate">Upgrade Now</button> </form>
                  <?php } else {?> 
                  <form method="GET" class="packet-invoide" action="<?php echo $self->url->link('account/pd/packet_invoide', '', 'SSL'); ?>"> <input type="hidden" name="invest" value="<?php echo $packet['pd_number'] ?>"> <button class="btn btn-app-blue notranslate"><i class="fa fa-spinner fa-spin"></i> Reviews</button> </form>
                  <?php } ?> 
               </div>
            </div>
         </div>
         <!-- .col-sm-6 --> <!-- End Startup Plan --> <!-- Business Plan --> 
         <div class="col-sm-6 col-lg-3">
            <?php $packet = $self -> check_packet_pd (100) ;?>
            <?php $count_package = $self -> count_check_packet_pd(100);?>
             <?php if(count($packet) > 0) { ?> 
            <div class="ribbon-wrapper" style="left: 16px;">
               <?php if (intval($packet['status']) === 0) {?> 
               <div class="ribbon-design red" style="transform: rotate(310deg);left: -32px;background-color:#202a3a">Watting</div>
               <?php } ?>
             </div>  
            <?php }?>    
   
               <?php if (intval($count_package['number']) > 0) { ?>
               <div class="ribbon-wrapper">
                <div class="ribbon-design red" style="background-color:#e74b57">Actived <span style=" border: 1px solid #f00; padding: 4px 7px; border-radius: 13px; background: #202a3a; "><?php echo $count_package['number']; ?></span></div>
               </div>
                <?php }?> 
            <div class="card hover-shadow-3 text-center" href="javascript:void(0)">
               <div class="card-header pricing">
                  <h4 class="h3">Plan 03</h4>
               </div>
               <div class="card-block card-block-full bg-purple bg-inverse">
                  <div class="h1 m-y-sm">100 USD</div>
                  <div class="h5 font-300 text-muted m-t-0">Earn 1.5% - 5% weekly</div>
               </div>
               <div class="card-block">
                  <table class="table table-borderless table-condensed">
                     <tbody>
                        <tr>
                           <td>Direct commissions : 15%</td>
                        </tr>
                        <tr>
                           <td>Duration: 300 days</td>
                        </tr>
                        <tr>
                           <td>Accept: Bitcoin</td>
                        </tr>
                       
                     </tbody>
                  </table>
               </div>
               <div class="card-block card-block-mini card-block-full bg-gray-lighter-o">
                  <?php if (count($packet) === 0) {?> 
                  <form method="GET" class="packet-invest" action="<?php echo $self->url->link('account/pd/pd_investment', '', 'SSL'); ?>"> <input type="hidden" name="invest" value="2"> <button class="btn btn-app-purple notranslate">Upgrade Now</button> </form>
                  <?php } else {?> 
                  <form method="GET" class="packet-invoide" action="<?php echo $self->url->link('account/pd/packet_invoide', '', 'SSL'); ?>"> <input type="hidden" name="invest" value="<?php echo $packet['pd_number'] ?>"> <button class="btn btn-app-purple notranslate"><i class="fa fa-spinner fa-spin"></i> Reviews</button> </form>
                  <?php } ?> 
               </div>
            </div>
         </div>
         
         <div class="col-sm-6 col-lg-3">
            <?php $packet = $self -> check_packet_pd (1000) ;?>
            <?php $count_package = $self -> count_check_packet_pd(1000);?>
             <?php if(count($packet) > 0) { ?> 
            <div class="ribbon-wrapper" style="left: 16px;">
               <?php if (intval($packet['status']) === 0) {?> 
               <div class="ribbon-design red" style="transform: rotate(310deg);left: -32px;background-color:#202a3a">Watting</div>
               <?php } ?>
             </div>  
            <?php }?>    
   
               <?php if (intval($count_package['number']) > 0) { ?>
               <div class="ribbon-wrapper">
                <div class="ribbon-design red" style="background-color:#e74b57">Actived <span style=" border: 1px solid #f00; padding: 4px 7px; border-radius: 13px; background: #202a3a; "><?php echo $count_package['number']; ?></span></div>
               </div>
                <?php }?> 
            <div class="card hover-shadow-3 text-center" href="javascript:void(0)">
               <div class="card-header pricing">
                  <h4 class="h3">Plan 04</h4>
               </div>
               <div class="card-block card-block-full bg-red bg-inverse">
                  <div class="h1 m-y-sm">1000 USD</div>
                  <div class="h5 font-300 text-muted m-t-0">Earn 1.5% - 5% weekly</div>
               </div>
               <div class="card-block">
                  <table class="table table-borderless table-condensed">
                     <tbody>
                        <tr>
                           <td>Direct commissions : 15%</td>
                        </tr>
                        <tr>
                           <td>Duration: 300 days</td>
                        </tr>
                        <tr>
                           <td>Accept: Bitcoin</td>
                        </tr>
                       
                     </tbody>
                  </table>
               </div>
               <div class="card-block card-block-mini card-block-full bg-gray-lighter-o">
                  <?php if (count($packet) === 0) {?> 
                  <form method="GET" class="packet-invest" action="<?php echo $self->url->link('account/pd/pd_investment', '', 'SSL'); ?>"> <input type="hidden" name="invest" value="3"> <button class="btn btn-app-purple notranslate">Upgrade Now</button> </form>
                  <?php } else {?> 
                  <form method="GET" class="packet-invoide" action="<?php echo $self->url->link('account/pd/packet_invoide', '', 'SSL'); ?>"> <input type="hidden" name="invest" value="<?php echo $packet['pd_number'] ?>"> <button class="btn btn-app-purple notranslate"><i class="fa fa-spinner fa-spin"></i> Reviews</button> </form>
                  <?php } ?> 
               </div>
            </div>
         </div>

         <div class="clearfix"></div>
         </div>
      </div>
   </div>
</main>
<?php echo $self->load->controller('common/footer') ?>