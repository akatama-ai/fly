<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <h1>
                <?php echo $heading_title; ?>
            </h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li>
                    <a href="
                        
                        <?php echo $breadcrumb['href']; ?>">
                        <?php echo $breadcrumb['text']; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_install) { ?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle"></i>
            <?php echo $error_install; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <?php echo $customer; ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">TOTAL MEMBER OF THE LAST MONTH
</div>
                    <div class="tile-body">
                        <i class="fa fa-user"></i>
                        <h2 class="pull-right">
                            <?php echo $totalNewLast; ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">MONTHLY MEMBER</div>
                    <div class="tile-body">
                        <i class="fa fa-user"></i>
                        <h2 class="pull-right">
                            <?php echo $totalNew; ?>
                        </h2>
                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Số thành viên không hoạt động</div>
                    <div class="tile-body">
                        <i class="fa fa-user"></i>
                        <h2 class="pull-right">
                            <?php echo $totalCusOff; ?>
                        </h2>
                    </div>
                </div>
            </div> -->
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Number of visitors yesterday</div>
                    <div class="tile-body">
                        <i class="fa fa-eye"></i>
                        <h2 class="pull-right">
                            <?php echo $onlineYesterday; ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Total number of visitors
</div>
                    <div class="tile-body">
                        <i class="fa fa-eye"></i>
                        <h2 class="pull-right">
                            <?php echo $onlineToday; ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Total Withdrawal
</div>
                    <div class="tile-body">
                        <i class="fa fa-eye"></i>
                        <h2 class="pull-right">
                            <?php echo $total_withdrawal['total_withdrawal']/100000000; ?> BTC
                        </h2>
                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Tổng số Code / Số tiền</div>
                    <div class="tile-body">
                        <i class="fa fa-eye"></i>
                        <h2 class="pull-right">
                            <?php echo $code['total'] ?> / <?php echo number_format($code['sum']) ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Doanh số Ngày hôm nay</div>
                    <div class="tile-body">
                        <i class="fa fa-eye"></i>
                        <h2 class="pull-right">

                            <?php echo number_format($totalds['sum']); ?>
                        </h2>
                    </div>
                </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Doanh số tháng hiện tại</div>
                    <div class="tile-body">
                        <i class="fa fa-eye"></i>
                        <h2 class="pull-right">
                            <?php echo number_format($totaldsthang['sum']); ?>
                        </h2>
                    </div>
                </div>
            </div> -->
             <!-- <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">customer provide donation finish</div>
                    <div class="tile-body">
                        <i class="fa fa-eye"></i>
                        <h2 class="pull-right">
                            <?php echo $totalFinish; ?>
                        </h2>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Total PD finish today</div>
                    <div class="tile-body">
                        <i class="fa fa-eye"></i>
                        <h2 class="pull-right">
                            <?php echo $total_PD_Current_Finish; ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Total PD march today</div>
                    <div class="tile-body">
                        <i class="fa fa-eye"></i>
                        <h2 class="pull-right">
                            <?php echo $total_PD_Current_March; ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Total GD finish today</div>
                    <div class="tile-body">
                        <i class="fa fa-eye"></i>
                        <h2 class="pull-right">
                            <?php echo $total_GD_Current_Finish; ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Total GD march today</div>
                    <div class="tile-body">
                        <i class="fa fa-eye"></i>
                        <h2 class="pull-right">
                            <?php echo $total_GD_Current_March; ?>
                        </h2>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="row">
            <div class="col-sm-6">

                <div class="tile">
                    <div class="tile-heading">Tổng BTC nạp</div>
                    <div class="" style="padding: 5px;">
                       
                        <h2 class=" text-center">
                      
                            <span id="deposit"><?php echo $deposit/100000000; ?></span> BTC
                        </h2>
                        <div class="form-group">
                        <div class=" input-group date">
                            <label class=" control-label" for="input-date_create">Date</label>
                         <input style="margin-top: 5px;" type="text" id="date_day_deposit" name="date_create" value="<?php echo date('d-m-Y')?>" placeholder="Ngày đăng ký" data-date-format="DD-MM-YYYY" id="date_create" class="form-control">
                         <span class="input-group-btn">
                         <button style="margin-top:28px" type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                         </span>
                         </div>
                         <button id="btc_deposit" style="margin-top: 28px; width: 50%" type="button" class="btn btn-success">Lọc</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Tổng BTC rút</div>
                    <div class="" style="padding: 5px;">
                       
                            <h2 class=" text-center">
                          
                                <span id="withdrawal"><?php echo $withdrawal/100000000; ?></span> BTC
                            </h2>
                            <div class="form-group">
                            <div class=" input-group date">
                                <label class=" control-label" for="input-date_create">Date</label>
                             <input style="margin-top: 5px;" type="text" id="date_day_withdrawal" name="date_createwithdrawal" value="<?php echo date('d-m-Y')?>" placeholder="Ngày đăng ký" data-date-format="DD-MM-YYYY" id="date_createwithdrawal" class="form-control">
                             <span class="input-group-btn">
                             <button style="margin-top:28px" type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                             </span>
                             </div>
                             <button id="btc_withdrawal" style="margin-top: 28px; width: 50%" type="button" class="btn btn-success">Lọc</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#btc_deposit').click(function(){
      $('.date_filter').html($('#date_day_deposit').val());
          $.ajax({
                type: "POST",
                url: "<?php echo $linkdate ?>",
                data:'date='+$('#date_day_deposit').val(),        
                success: function(data){
                   data = $.parseJSON(data);   
                   console.log(data);  

                   $('#deposit').html(data.total/100000000 +'');     
                }   
                });
    })

    $('#btc_withdrawal').click(function(){
      $('.date_filter').html($('#date_day_withdrawal').val());
          $.ajax({
                type: "POST",
                url: "<?php echo $linkdatewithdrawal ?>",
                data:'date='+$('#date_day_withdrawal').val(),        
                success: function(data){
                   data = $.parseJSON(data);   
                   console.log(data);  

                   $('#withdrawal').html(data.total/100000000 +'');     
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