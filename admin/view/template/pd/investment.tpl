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
<?php echo $footer; ?>