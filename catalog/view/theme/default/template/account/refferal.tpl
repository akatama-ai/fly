<?php $self -> document -> setTitle($lang['heading_title']); echo $self -> load -> controller('common/header'); ?> <!-- Sidebar --> <?php echo $self->load->controller('common/column_left');  ?> <!-- /#sidebar-wrapper --> <!-- Page Content --> 
<main class="app-layout-content">
   <!-- Page Content --> 
   <div class="container-fluid p-y-md">
      <!-- Modern Design --> 
     
      <div class="card">
      
      <div class="card-header">
              
                  <h4>Affiliates</h4>
                
               </div>
         <div class="card-block">
            <div class="table-responsive">
               <table class="table table-striped table-borderless table-vcenter">
                  <thead>
                     <tr>
                        <th class="text-center">No.</th>
                        <th>Username</th>
                        <!-- <th>Level</th> --> <!-- <th>QR Code</th> --> 
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $count = 1; foreach ($refferals as $key => $value) { ?> 
                     <tr>
                        <td data-title="<?php echo $lang['NO'] ?>." align="center"><?php echo $count ?></td>
                        <td data-title="<?php echo $lang['USERNAME'] ?>"><?php echo $value['username'] ?></td>
                        <td data-title="<?php echo $lang['TELEPHONE'] ?>" > <?php echo $value['telephone']; ?> </td>
                        <td data-title="<?php echo $lang['EMAIL'] ?>"><?php echo $value['email'] ?></td>
                        <td data-title="<?php echo $lang['COUNTRY'] ?>"><?php echo $self->getCountry($value['country_id']); ?></td>
                         <td data-title="Status"><?php if ($value['level'] == 1) { ?>
                                  <a href="javascript:void(0);" class="btn btn-danger btn-xs">InAvtive</a>
                                  <?php } else{?>
                                  <a href="javascript:void(0);" class="btn btn-info btn-xs">Avtive   </a>
                                   <?php }?>
                               </td>
                     </tr>
                     <?php $count++; } ?> 
                  </tbody>
               </table>
               <?php echo $pagination; ?> 
            </div>
         </div>
         <!-- .card-block --> 
      </div>
   </div>
</main>
<?php echo $self->load->controller('common/footer') ?>