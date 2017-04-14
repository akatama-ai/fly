<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Rate</h1>
  </div>
</div>
<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">      
      <div class="clearfix">
            <div class="col-md-6 text-center wow fadeInUp" data-wow-delay="0.3s" style="margin-top: 60px;">
                <form method="POST" action="index.php?route=pd/rate/update_commission&token=<?php echo $_GET['token'] ?>" style="">
                 <h1>Weekly interest calculation</h1>
                <label>Code Authy</label>
                <input required="true" type="text" placeholder="authy"  name="opt">
                <br>
                <label>Rate Current</label>
                <input readonly type="text" placeholder="Rate current" value="<?php echo $limit1['rate']; ?>" name="rate_current" >
                <br>
                <label></label>
                <input type="submit" name="ok" value="OK" >
              </form>
            </div>         
            <div class="col-md-6 text-center wow fadeInUp" data-wow-delay="0.3s" style="margin-top: 60px;">
              <form method="POST" action="index.php?route=pd/rate/rate_sm&token=<?php echo $_GET['token'] ?>" style="">
                <h1>Update Rate</h1>
                <label>Rate</label>
                <input required="true" type="text" placeholder="rate"  name="rate">
                <br>
                <label>Code Authy</label>
                <input required="true" type="text" placeholder="authy"  name="opt">
                <br>
                <label>Rate Current</label>
                <input readonly type="text" placeholder="Rate current" value="<?php echo $limit1['rate']; ?>" name="rate_current" >
                <br>
                <label></label>
                <input type="submit" name="ok" value="OK" >
              </form>
            </div>
      </div>
    </div>
   
    <div class="panel-body row">
        <div class="clearfix" style="margin-top:10px;"></div>
     	<table class="table table-bordered table-hover">
     		<thead>
     			<tr>
     				<th>TT</th>
     				<th>Rate</th>
            <th>Date</th>
    
            <th>Week</th>
          
            
     			</tr>
     		</thead>
     		<tbody>
        <?php 
          $i = 0;
          $date = '';
          $rate = '';
          foreach ($code as $value) {
            $i++;
          ?>
          <tr <?php echo $value['status'] == 0 ? 'style=" background: #e84949; "' : ''; ?> >
            <td><?php echo $i; ?></td>
            <td><?php echo $value['rate'] ?></td>
            <td><?php echo date("Y-m-d", strtotime($value['date'])); ?> </td>
              <td>Week <?php echo $value['id'] ?></td>
          </tr>
         <?php
         

          }
        
         ?>
     		</tbody>
     	</table>
    <?php echo $pagination; ?>
    </div>
  </div>
</div>

     
<style>
  form label{
    width: 130px;
    height: 30px;
  }
  form input{
    padding: 7px;
    font-weight: bold;
    border: 1px solid #e4e4e4;
    width: 300px;
    border-radius: 3px;
  }
</style>
<script>

  if (location.hash === '#no_google') {
      var html = '<div class="col-md-12">';
        html += '<p class="text-center" style="font-size:23px;text-transform: uppercase;height: 20px;color:red">ERROR !</p><p class="text-center" style="font-size:20px;height: 20px">Faild OTP</p>';
        html += '<p style="margin-top:30px;font-size:16px"></p>';
        html += '</div>';
        alertify.alert(html, function(){
           
        });
    }
    if (location.hash === '#error') {
      var html = '<div class="col-md-12">';
        html += '<p class="text-center" style="font-size:23px;text-transform: uppercase;height: 20px;color:red">Please try again !</p><p class="text-center" style="font-size:20px;height: 20px">Faild OTP</p>';
        html += '<p style="margin-top:30px;font-size:16px"></p>';
        html += '</div>';
        alertify.alert(html, function(){
           
        });
    }
    if (location.hash === '#suscces') {
      var html = '<div class="col-md-12">';
        html += '<p class="text-center" style="font-size:23px;text-transform: uppercase;height: 20px;color:#053636">SUSCCES !</p><p class="text-center" style="font-size:20px;height: 20px">Update Success</p>';
        html += '<p style="margin-top:30px;font-size:16px"></p>';
        html += '</div>';
        alertify.alert(html, function(){
           
        });
    }
</script>
<?php echo $footer; ?>