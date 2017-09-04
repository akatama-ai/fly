<?php $self -> document -> setTitle($lang['heading_title']); echo $self -> load -> controller('common/header'); ?> <!-- Sidebar --> <?php echo $self->load->controller('common/column_left');  ?> <!-- /#sidebar-wrapper --> <!-- Page Content --> 
<main class="app-layout-content">
   <!-- Page Content --> 
   <div class="container-fluid p-y-md">
      <!-- Modern Design --> 
      <div class="card">
         <div class="card-header">
            <h4>Affiliates</h4> 
            <form  id="frmFindId">
            <div class="form-group">
   <label for="validate-optional">Search ID</label>
   <div class="input-group">
      <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
      <span id="submitFind" class="input-group-addon info" style="cursor: pointer;">Search</span>
   </div>
</div>

           
            
          </form>
         </div>
         <div class="card-block">
            <div class="table-responsive" style="padding:0px;" >
               <select name="" id="Floor" class="form-control" required="required" style="width:200px;">
                  
                  <?php 
                     $totalFloor = intval($self -> sumFloor());
                     $total = intval($totalFloor) > 10 ? 10 : $totalFloor;
                     for ($i=1; $i <= $total; $i++) { 
                       
                         echo "<option value='floor".$i."'>Floor ".$i."</option>";
                     
                     } ?>
               </select>
               <h3 class="totalInvest panel-title" style=" text-align: center; font-size: 20px; color: #e74854; border-bottom: 1px solid #f5d11b; padding-bottom: 10px; text-transform: uppercase; display: none;"> </h3>
               <div  id="customerFloor" data-id="<?php echo $self->session -> data['customer_id'] ?>" data-link="<?php echo $self->url->link('account/refferal/customerFloor', '', 'SSL'); ?>">
                  <?php 
                     $totalFloor = intval($self -> sumFloor());
                     //  for ($i=1; $i <= $totalFloor; $i++) { 
                     $total = intval($totalFloor) > 10 ? 10 : $totalFloor;
                        for ($i=1; $i <= $total; $i++) { 
                         echo ' <div class="resetFloor" id="customerFloor'.$i.'" style=" position: relative; ">
                                         </div>';
                     } ?>
               </div>
            </div>
            <div class="table-responsive" id="default">

            <h3 class="panel-title" style=" text-align: center; font-size: 20px; color: #e74854; border-bottom: 1px solid #f5d11b; padding-bottom: 10px; text-transform: uppercase; ">F1 - TOTAL INVEST: <?php echo number_format($sum['filled']); ?> USD</h3>
               <table class="table table-striped table-borderless table-vcenter">
                  <thead>
                     <tr>
                        <th class="text-center">No.</th>
                        <th>Username</th>
                        <!-- <th>Level</th> --> <!-- <th>QR Code</th> --> 
                        <th>Phone</th>
                        <th>Sponsor</th>
                       <th>Deposit</th>
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $count = 1; foreach ($refferals as $key => $value) { ?> 
                     <tr>
                        <td data-title="<?php echo $lang['NO'] ?>." align="center"><?php echo $count ?></td>
                        <td data-title="<?php echo $lang['USERNAME'] ?>"><?php echo $value['username'] ?></td>
                        <td data-title="<?php echo $lang['TELEPHONE'] ?>" > <?php echo $value['telephone']; ?> </td>
                        <td data-title="Sponsor"><?php echo $self -> getParrent($value['p_node']) ?></td>
                      <td data-title="Deposit"><?php echo $self -> getPD($value['customer_id']) ?> USD</td>
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
<style type="text/css">
@media screen and (max-width: 405px){
  .drawer-header a img {
    height: 30px;
    width: auto;
    max-width: none;
    margin-top: 30px;
  }
}

  .glyphicon-refresh-animate { -animation: spin .7s infinite linear; -webkit-animation: spin2 .7s infinite linear; } @-webkit-keyframes spin2 { from { -webkit-transform: rotate(0deg);} to { -webkit-transform: rotate(360deg);} } @keyframes spin { from { transform: scale(1) rotate(0deg);} to { transform: scale(1) rotate(360deg);} }
</style>
<?php echo $self->load->controller('common/footer') ?>

<script type="text/javascript">
$(document).ready(function(){

  $("#submitFind").click(function(){

    var username = $("#username").val();
    

    if((username == "")) {
     alert('Please Enter username!');
    }
    else {
      $.ajax({
        type: "POST",
        url: "/index.php?route=account/refferal/findID",
        data: "username="+username,
        success: function(data){
          data = $.parseJSON(data);
          

          if(data.status == -1){
              alert('This id was not found.');
              $("#submitFind").html("Search");
              $("#username").val('');
          }else {
              var xhtml = '<div class="col-md-6 col-md-offset-4"style=" text-align: left; font-weight: 500;"><p>Username: ' + data.username + '</p><p>Phone Number: ' + data.phone + '</p><p> Sponsor: ' + data.sponsor + '</p><p>Total Invest: ' + data.invest + '</p><p>Floor: F ' + data.floor + '</p></div>';
                 alertify.alert(xhtml, function() {
                     // location.reload(false);
                     $("#username").val('');
                     $("#submitFind").html("Search");
                 });
              
          }
        },
        beforeSend: function()
        {
          $("#submitFind").html("<img src='catalog/view/theme/default/img/ajax-loader.gif' style='width: 23px;''>")
        }
      });
    }
    return false;
  });
});
   $(document).ready(function() {     
   var sumFloor = '<?php echo intval($self -> sumFloor()); ?>';  
     $('#Floor').change(function(){
         $('#default').hide();
         window.funLazyLoad.start();
             window.funLazyLoad.show();
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
                        
                         var appends = _.values(result)[1];
                          var SumAmount = _.values(result)[0];
                          var floorss = 'F'+i;
                     }
                 }
                // console.log(result);
                 $('.resetFloor').html('');
                 $('.totalInvest').show().html(' '+floorss+' - Total Invest: '+SumAmount+' USD');
                   window.funLazyLoad.reset();
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
                         $('#customerFloor'+i).append(_.values(result)[1]);
                         var SumAmount = _.values(result)[0];
                          var floorss = 'F'+i;
                          // $('.totalInvest').show().html(' '+floorss+' - Total Invest: '+SumAmount+' USD');
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
                         $('#customerFloor'+i).append(_.values(result)[1]);
                         var SumAmount = _.values(result)[0];
                          var floorss = 'Floor '+i;
                          // $('.totalInvest').show().html(' '+floorss+' - Total Invest: '+SumAmount+' USD');
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