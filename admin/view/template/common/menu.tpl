<ul id="menu">
<li style=" color: #f00; opacity: 1; text-transform: capitalize;    padding: 15px; ">

         <?php $date = new DateTime($servertime['servertime']); ?>
         <span class="blinking"> Server Time: <?php echo date_format($date, 'g:ia \o\n l jS F Y'); ?> </span>
        
         </li>
  <li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>

  <!--  <li id="dashboard"><a href="index.php?route=pd/history&token=<?php echo $_GET['token'];?>"><i class="fa fa-dashboard fa-fw"></i> <span>Edit customer</span></a></li> -->
<li id="sale"><a href="<?php echo $customer; ?>"><i class="fa fa-user fa-fw"></i> <span><?php echo $text_customer; ?></span></a></li>
  <li id="mn_statistical" ><a target="_blank" href="index.php?route=pd/personalcustom&token=<?php echo $_GET['token'];?>&name="><i class="fa fa-user fa-fw"></i> <span> Tree </span></a></li>

  
  <li id="" ><a href="index.php?route=pd/investment&token=<?php echo $_GET['token'];?>"><i class="fa fa-user fa-fw"></i> <span> Investment Manager </span></a></li>


   <li id="" ><a href="index.php?route=pd/withdrawal&token=<?php echo $_GET['token'];?>"><i class="fa fa-user fa-fw"></i> <span> User Withdrawal</span></a></li>
   <li id="" ><a href="index.php?route=pd/withdrawalcapital&token=<?php echo $_GET['token'];?>"><i class="fa fa-user fa-fw"></i> <span> User Withdrawal Capital</span></a></li>
   <li id="" ><a href="index.php?route=pd/rate&token=<?php echo $_GET['token'];?>"><i class="fa fa-user fa-fw"></i> <span> Rate </span></a></li>
  
  <li id="system"><a class="parent"><i class="fa fa-cog fa-fw"></i> <span><?php echo $text_system; ?></span></a>
    <ul>
      <!-- <li><a href="<?php echo $setting; ?>"><?php echo $text_setting; ?></a></li> -->
      <?php /*?>
      <li><a class="parent"><?php echo $text_design; ?></a>
        <ul>
          <li><a href="<?php echo $layout; ?>"><?php echo $text_layout; ?></a></li>
          <li><a href="<?php echo $banner; ?>"><?php echo $text_banner; ?></a></li>
        </ul>
      </li>
      <?php */?>
      <li><a class="parent"><?php echo $text_users; ?></a>
        <ul>
          <li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
          <li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
      <?php /*?>    <li><a href="<?php echo $api; ?>"><?php echo $text_api; ?></a></li> <?php */?>
        </ul>
      </li>
      
     <!--  <li><a class="parent"><?php echo $text_localisation; ?></a>
       <ul>
         <li><a href="<?php echo $location; ?>"><?php echo $text_location; ?></a></li>
         <li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li>
       
         <li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li>
         <li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li>
         <li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li>
         <li><a class="parent"><?php echo $text_return; ?></a>
           <ul>
             <li><a href="<?php echo $return_status; ?>"><?php echo $text_return_status; ?></a></li>
             <li><a href="<?php echo $return_action; ?>"><?php echo $text_return_action; ?></a></li>
             <li><a href="<?php echo $return_reason; ?>"><?php echo $text_return_reason; ?></a></li>
           </ul>
         </li>
         <li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li>
         <li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li>
         <li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li>
         <li><a class="parent"><?php echo $text_tax; ?></a>
           <ul>
             <li><a href="<?php echo $tax_class; ?>"><?php echo $text_tax_class; ?></a></li>
             <li><a href="<?php echo $tax_rate; ?>"><?php echo $text_tax_rate; ?></a></li>
           </ul>
         </li>
         <li><a href="<?php echo $length_class; ?>"><?php echo $text_length_class; ?></a></li>
         <li><a href="<?php echo $weight_class; ?>"><?php echo $text_weight_class; ?></a></li>
         
       </ul>
     </li> -->
 
    </ul>
  </li> 
  <?php /*?>
  <li id="tools"><a class="parent"><i class="fa fa-wrench fa-fw"></i> <span><?php echo $text_tools; ?></span></a>
    <ul>
      <li><a href="<?php echo $upload; ?>"><?php echo $text_upload; ?></a></li>
      <li><a href="<?php echo $backup; ?>"><?php echo $text_backup; ?></a></li>
      <li><a href="<?php echo $error_log; ?>"><?php echo $text_error_log; ?></a></li>
    </ul>
  </li>
  <li id="reports"><a class="parent"><i class="fa fa-bar-chart-o fa-fw"></i> <span><?php echo $text_reports; ?></span></a>
    <ul>
      <li><a class="parent"><?php echo $text_sale; ?></a>
        <ul>
          <li><a href="<?php echo $report_sale_order; ?>"><?php echo $text_report_sale_order; ?></a></li>
          <li><a href="<?php echo $report_sale_tax; ?>"><?php echo $text_report_sale_tax; ?></a></li>
          <li><a href="<?php echo $report_sale_shipping; ?>"><?php echo $text_report_sale_shipping; ?></a></li>
          <li><a href="<?php echo $report_sale_return; ?>"><?php echo $text_report_sale_return; ?></a></li>
          <li><a href="<?php echo $report_sale_coupon; ?>"><?php echo $text_report_sale_coupon; ?></a></li>
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_product; ?></a>
        <ul>
          <li><a href="<?php echo $report_product_viewed; ?>"><?php echo $text_report_product_viewed; ?></a></li>
          <li><a href="<?php echo $report_product_purchased; ?>"><?php echo $text_report_product_purchased; ?></a></li>
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_customer; ?></a>
        <ul>
          <li><a href="<?php echo $report_customer_online; ?>"><?php echo $text_report_customer_online; ?></a></li>
          <li><a href="<?php echo $report_customer_activity; ?>"><?php echo $text_report_customer_activity; ?></a></li>
          <li><a href="<?php echo $report_customer_order; ?>"><?php echo $text_report_customer_order; ?></a></li>
          <li><a href="<?php echo $report_customer_reward; ?>"><?php echo $text_report_customer_reward; ?></a></li>
          <li><a href="<?php echo $report_customer_credit; ?>"><?php echo $text_report_customer_credit; ?></a></li>
        </ul>
      </li>
      <li><a class="parent"><?php echo $text_marketing; ?></a>
        <ul>
          <li><a href="<?php echo $report_marketing; ?>"><?php echo $text_marketing; ?></a></li>
          <li><a href="<?php echo $report_affiliate; ?>"><?php echo $text_report_affiliate; ?></a></li>
          <li><a href="<?php echo $report_affiliate_activity; ?>"><?php echo $text_report_affiliate_activity; ?></a></li>
        </ul>
      </li>
    </ul>
  </li>
  <?php */?>

</ul>
<script type="text/javascript">
  jQuery('#auto_walet_c').click(function(){
    url = jQuery(this).parent().attr('href');
    jQuery.ajax({
      url : url,
        type : "post",
        dataType:"text",
        data : {   
        },
        success : function (result){
            if (result == "done")
            {
              alert("Tính phần trăm thành công.")
            }
        }
    });
    return false;
  });
</script>