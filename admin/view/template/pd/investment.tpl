<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1>Investment Manager</h1>

  </div>
</div>
<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title pull-left">Investment Manager </h3>
        
      <div class="clearfix">
          
      </div>
    </div>
<div class="form-group row">
            
            <div class="col-sm-3 input-group date">
                 <label class=" control-label" for="input-date_create">Date</label>
                 <input style="margin-top: 5px;" type="text" id="date_day" name="date_create" value="<?php echo date('d-m-Y')?>" placeholder="Ngày đăng ký" data-date-format="DD-MM-YYYY" id="date_create" class="form-control">
                 <span class="input-group-btn">
                 <button style="margin-top:28px" type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                 </span>
              </div>
              <div class="col-sm-3">
                <button id="submit_date" style="margin-top: 28px;" type="button" class="btn btn-success">Filter</button>
              </div>
             
            </div>

          <div class="row">
        
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">TOTAL INVEST <span class="date_filter" style="color: #f00; font-size: 16px;"> </span></div>
                    <div class="tile-body">
                        <i class="fa fa-user"></i>
                        <h2 class="pull-right">
                            <span class="total"><?php echo $self -> totalpd(); ?> USD</span>
                        </h2>
                    </div>
                </div>
            </div>
            
            </div>
    <div class="panel-body row">

        <div class="clearfix" style="margin-top:10px;"></div>
     	<table class="table table-bordered table-hover">
     		<thead>
     			<tr>
     				<th>TT</th>
     				<th>Username</th>
            <th>Wallet</th>
            <th>Packega</th>
            <th>Date</th>
            <th>Status</th>
     			</tr>
     		</thead>
     		<tbody>
        <?php 
          $i = 0;
          //print_r($_SESSION); die;
          foreach ($code as $value) {
           
            $i++;
        ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $value['username'] ?></td>
            <td><a target="_blank" href="https://blockchain.info/address/<?php echo $value['wallet'] ?>"><?php echo $value['wallet'] ?> <i class="fa fa-external-link" aria-hidden="true"></i></a></td>
            <td><?php echo $value['filled'] ?> USD</td>
            <td><?php echo date('d/m/Y H:i',strtotime($value['date_added'])); ?></td>
            <td><span class="label label-success">Active</span></td>
            
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
<script type="text/javascript">
$('#submit_date').click(function(){
  $('.date_filter').html($('#date_day').val());
      $.ajax({
            type: "POST",
            url: "<?php echo $linkdate ?>",
            data:'date='+$('#date_day').val(),        
            success: function(data){
               data = $.parseJSON(data);   
               console.log(data);  

               $('.total').html(data.total +' USD');     
            }   
            });
})

   $('.date').datetimepicker({
        pickTime: false
      });
      
      $('.datetime').datetimepicker({
        pickDate: true,
        pickTime: true
      });
      
      $('.time').datetimepicker({
        pickDate: false
      }); 
      

</script>
<?php echo $footer; ?>