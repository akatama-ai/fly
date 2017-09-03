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
            <div class="table-responsive" style="padding:0px;" >
               <select name="" id="Floor" class="form-control" required="required" style="width:200px;">
                  <option value="null">FLOOR</option>
                  <?php 
                     $totalFloor = intval($self -> sumFloor());
                     $total = intval($totalFloor) > 10 ? 10 : $totalFloor;
                     for ($i=1; $i <= $total; $i++) { 
                       
                         echo "<option value='floor".$i."'>Floor ".$i."</option>";
                     
                     } ?>
               </select>
               <div  id="customerFloor" data-id="<?php echo $self->session -> data['customer_id'] ?>" data-link="<?php echo $self->url->link('account/refferal/customerFloor', '', 'SSL'); ?>">
                  <?php 
                     $totalFloor = intval($self -> sumFloor());
                     //  for ($i=1; $i <= $totalFloor; $i++) { 
                     $total = intval($totalFloor) > 10 ? 10 : $totalFloor;
                        for ($i=1; $i <= $total; $i++) { 
                         echo ' <div class="resetFloor" id="customerFloor'.$i.'">
                                         </div>';
                     } ?>
               </div>
            </div>
            <div class="table-responsive" id="default">
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
<script type="text/javascript">
   $(document).ready(function() {     
   var sumFloor = '<?php echo intval($self -> sumFloor()); ?>';  
     $('#Floor').change(function(){
         $('#default').hide();

         var Floor = $('#Floor').val();
         for (var i = 1; i <= sumFloor; i++) {
             if (Floor == 'floor'+i) {
                 var floors = $('#customerFloor'+i);
             };
             
         };
         
         $.ajax({
              url : $('#customerFloor').data('link'),
              type : 'GET',
              data : {floor : $('#Floor').val()},
              async : false,
              success : function(result) {
                  result = $.parseJSON(result);
                 
                  for (var i = 1; i <= sumFloor; i++) {
   
                     if (Floor == 'floor'+i) {
                       
                         var appends = _.values(result)[0];
                     }
                 }
                // console.log(result);
                 $('.resetFloor').html('');
                 
                 floors.append(appends);
                  next();
                  prev();
              }
          });
        
      
     });
     
     function next(){
   
         $("#Next").click(function(){
           //   window.funLazyLoad.start();
           // window.funLazyLoad.show();
             // $('#next_page').val(parseInt($('#next_page').val())+10);
             // alert($('#next_page').val());
          $.ajax({
              url : $('#customerFloor').data('link'),
              type : 'GET',
              data : {next : parseInt($('#next_page').val()), floor : $('#Floor').val()},
              async : false,
              success : function(result) {
                 result = $.parseJSON(result);
                 console.log(result);
                 if (_.has(result, 'total') && _.has(result, 'total') >= parseInt($('#next_page').val()) ) { 
                     window.funLazyLoad.reset();
                     return false;
                 }
                 $('.resetFloor').html('');
                 setTimeout(function(){ window.funLazyLoad.reset(); }, 500);
                 for (var i = 1; i <= sumFloor; i++) {
                     if (_.has(result, 'fl'+i)) {                      
                         $('#customerFloor'+i).append(_.values(result)[0]);
                        next();
                         prev();
                         
                         return true;
                     } 
                     
                 };
   
              }
          });
         });
     }
   
     function prev(){
   
         $("#Prev").click(function(){
             window.funLazyLoad.start();
             window.funLazyLoad.show();
             // $('#next_page').val(parseInt($('#next_page').val())+10);
             // alert($('#next_page').val());
          $.ajax({
              url : $('#customerFloor').data('link'),
              type : 'GET',
              data : {prev : parseInt($('#next_page').val()), floor : $('#Floor').val()},
              async : false,
              success : function(result) {
                  result = $.parseJSON(result);
                 console.log(result);
                 if ( 10 == parseInt($('#next_page').val()) ) { 
                     window.funLazyLoad.reset();
                     return false;
                 }
                 $('.resetFloor').html('');
                 setTimeout(function(){ window.funLazyLoad.reset(); }, 500);
                 for (var i = 1; i <= sumFloor; i++) {
                     if (_.has(result, 'fl'+i)) {                      
                         $('#customerFloor'+i).append(_.values(result)[0]);
                        next();
                         prev();
                         
                         return true;
                     } 
                     
                 };
   
   
                 
                 
                 
              }
          });
         });
     }
     
   });
   
</script>