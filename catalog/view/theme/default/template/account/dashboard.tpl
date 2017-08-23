<?php $self->document->setTitle("Home"); echo $self->load->controller('common/header');?> <!-- Sidebar --> <?php echo $self->load->controller('common/column_left');  ?> 
<main class="app-layout-content">
   <!-- Page Content --> 
   <div class="container-fluid p-y-md">
      <!-- Stats --> 
     
      <div class="row">
         <div class="col-sm-6 col-lg-3">
            <a class="card bg-orange bg-inverse" href="javascript:void(0)">
               <div class="card-block clearfix">
                  <div class="text-center">
                     <p class="h6 text-muted m-t-0 m-b-xs">Total Investment</p>
                     <p class="h3 text-blue m-t-sm m-b-0"><?php echo $countPD; ?> USD</p>
                  </div>
                
               </div>
            </a>
         </div>
         <!-- .col-sm-6 --> 
         <div class="col-sm-6 col-lg-3">
            <a class="card bg-red bg-inverse" href="javascript:void(0)">
               <div class="card-block clearfix">
                  <div class="text-center">
                     <p class="h6 text-muted m-t-0 m-b-xs">Weekly profit</p>
                     <p class="h3 m-t-sm m-b-0"><?php echo $getR_Wallet_payment; ?> USD</p>
                  </div>
                 
               </div>
            </a>
         </div>
         <!-- .col-sm-6 --> 
         <div class="col-sm-6 col-lg-3">
            <a class="card bg-black bg-inverse" href="javascript:void(0)">
               <div class="card-block clearfix">
                  <div class="text-center">
                     <p class="h6 text-muted m-t-0 m-b-xs"> Direct commission</p>
                     <p class="h3 m-t-sm m-b-0"><?php echo $getCWallet ?> USD</p>
                  </div>
                  
               </div>
            </a>
         </div>
         <!-- .col-sm-6 --> 
         <div class="col-sm-6 col-lg-3">
            <a class="card bg-purple bg-inverse" href="javascript:void(0)">
               <div class="card-block clearfix">
                  <div class="text-center">
                     <p class="h6 text-muted m-t-0 m-b-xs">Binary bonus</p>
                     <p class="h3 m-t-sm m-b-0"><?php echo $getCNWallet ?> USD</p>
                  </div>
                 
               </div>
            </a>
         </div>
          <div class="col-sm-6 col-lg-3">
            <a class="card bg-red bg-inverse" href="javascript:void(0)">
               <div class="card-block clearfix">
                  <div class="text-center">
                     <p class="h6 text-muted m-t-0 m-b-xs">Co-division Commission</p>
                     <p class="h3 m-t-sm m-b-0"><?php echo $getMWallet ?> USD</p>
                  </div>
                
               </div>
            </a>
         </div>
         <div class="col-sm-6 col-lg-3">
            <a class="card bg-orange bg-inverse" href="javascript:void(0)">
               <div class="card-block clearfix">
                  <div class="text-center">
                     <p class="h6 text-muted m-t-0 m-b-xs">Binary - Left</p>
                     <p class="h3 m-t-sm m-b-0"><?php echo $total_pd_left ;?> USD</p>
                  </div>
                
               </div>
            </a>
         </div>
         <div class="col-sm-6 col-lg-3">
            <a class="card bg-purple bg-inverse" href="javascript:void(0)">
               <div class="card-block clearfix">
                  <div class="text-center">
                     <p class="h6 text-muted m-t-0 m-b-xs">Binary - Right</p>
                     <p class="h3 text-blue m-t-sm m-b-0"><?php echo $total_pd_right ;?> USD</p>
                  </div>
                
               </div>
            </a>
         </div>
       
         <!-- .col-sm-6 --> 
         <div class="col-sm-6 col-lg-3">
            <a class="card bg-black bg-inverse" href="javascript:void(0)">
               <div class="card-block clearfix">
                  <div class="pull-right text-center">
                     <p class="h6 text-muted m-t-0 m-b-xs">ID / Right</p>
                     <p class="h3 m-t-sm m-b-0"><?php echo $total_binary_right ?></p>
                  </div>
                  <div class="pull-left text-center">
                  <p class="h6 text-muted m-t-0 m-b-xs">ID / Left</p>
                     <p class="h3 m-t-sm m-b-0"><?php echo $total_binary_left ?></p>
                      </div>
               </div>
            </a>
         </div>
         <!-- .col-sm-6 --> 
      </div>
      <!-- .row --> 
      <div class="row">
         <div class="col-sm-12">
            <div class="card" id="sample-card">
               <div class="card-header">
                  <h4>Referral Link</h4>
                  <ul class="card-actions">
                     <li> <button type="button" data-toggle="card-action" data-action="fullscreen_toggle"><i class="ion-android-expand"></i></button> </li>
                     <li> <button type="button" data-toggle="card-action" data-action="content_toggle"><i class="ion-chevron-down"></i></button> </li>
                  </ul>
               </div>
               <div class="card-block"> <input style="width:100%;border:none;color: #2196f3;font-size: 16px;display: block; margin-bottom: 8px;" readonly class="js-copytextarea"value="<?php echo HTTPS_SERVER.'register?ref='.$customer_code; ?>" title="<?php echo HTTPS_SERVER.'register?ref='.$customer_code; ?>"> <button class="btn btn-default js-textareacopybtn">COPY Referral Link</button> </div>
            </div>
         </div>
      </div>
      <!-- End stats --> <!-- .row --> <!-- .row --> 
      <div class="row">
                            <div class="col-lg-6">
                                <!-- Default Table -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Recent Login Details</h4>
                                       
                                    </div>
                                    <div class="card-block" id="no-more-tables">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                   
                                                    <th>Browser</th>
                                                    <th class="">Login Date</th>
                                                    <th class="text-center">IP Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                  <?php foreach ($login_detail as $key => $value) {
                                  
                                                     ?>
                                                    <tr>
                                                        <td data-title="Browser"></i> <?php echo $value['browser'] ?>   </td>
                                                        <td data-title="Login Date"><?php echo date("Y-m-d H:i:A", strtotime($value['date_added'])); ?> </td>
                                                        <td data-title="IP Address"><?php echo $value['ip'] ?></td>
                                                    </tr>
                                                  <?php
                                                      
                                                    } ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- .card-block -->
                                </div>
                                <!-- .card -->
                                <!-- End Default Table -->
                            </div>
                            <!-- .col-lg-6 -->

                            <div class="col-lg-6">
                                <!-- Striped Table -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Weekly Rates</h4>
                                        <div class="card-actions">
                                            Current Rate <code><?php echo $limit1['rate']; ?>%</code>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <canvas id="canvas" height="400" style="max-width: 1170px; width: 100%; max-height: 400px; height: 100%;"></canvas>
                                    </div>
                                    <!-- .card-block -->
                                </div>
                                <!-- .card -->
                                <!-- End Striped Table -->
                            </div>
                            <!-- .col-lg-6 -->

                        </div>
   </div>
   <!-- .container-fluid --> <!-- End Page Content --> 
</main>
 <?php 
    
          $date = '';
          $rate = '';
          foreach ($chart as $value) {
          $date .= ', '.'"'.date("Y-m-d", strtotime($value['date'])).'"';
          $rate .= ', '.'"'.$value['rate'].'"';

          }
          $date = substr($date, 1);
           $rate = substr($rate, 1);
         
         ?>
 <script src="catalog/view/theme/default/home/js/Chart.bundle.js"></script> 

<script type="text/javascript">
   var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var config = {
    type: 'line',
    data: {
        labels: [ <?php echo $date ?> ],
        datasets: [{
            label: 'Rate(%)',
            fontSize: 36,
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [ <?php echo $rate ?> ],
            fill: false,
            pointBorderWidth: 3,
            pointHoverBorderWidth: 5,
        }]
    },
    options: {
        legend: {
            display: false,
        },
        responsive: true,
        title: {
            display: false,
            text: 'Rates',
            fontSize: 24,
            fontStyle: 'normal',
        },
        tooltips: {
            mode: 'index',
            intersect: false,
            xPadding: 10,
            yPadding: 14,
            titleFontSize: 16,
            titleMarginBottom: 10,
            bodyFontSize: 14,
            footerMarginTop: 10,
            caretSize: 10,
            footerFontSize: 6,
        },
        hover: {
            mode: 'nearest',
            intersect: true
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Date',
                    fontSize: 18,
                    fontColor: "#e63946"
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Rate (%)',
                    fontSize: 18,
                    fontColor: "#e63946"
                }
            }]
        }
    }
};

window.onload = function() {

    var ctx = document.getElementById("canvas").getContext("2d");
    Chart.defaults.global.defaultFontFamily = 'opensans-regular';
    window.myLine = new Chart(ctx, config);
};
</script>
<!-- /#page-content-wrapper --> <script type="text/javascript"> var copyTextareaBtn = document.querySelector('.js-textareacopybtn'); copyTextareaBtn.addEventListener('click', function(event) {var copyTextarea = document.querySelector('.js-copytextarea'); copyTextarea.select(); try {var successful = document.execCommand('copy'); var msg = successful ? 'successful' : 'unsuccessful'; console.log('Copying text command was ' + msg); } catch (err) {console.log('Oops, unable to copy'); } }); </script> <?php echo $self->load->controller('common/footer') ?>
<script type="text/javascript">
    $( document ).ready(function() {
        var xhtml = '<p>Send Bitflyerbank Member. We have passed phase 1 and have owned the System in Vietnam. We will start implementing phase 2 to generate passive income for the community. During Phase 2 implementation we will have delays please feel free to sympathize. We will announce the earliest date of entry to Phase 2 and Bitflyerbank will return to normal.<br> Thank you!</p>';
                            alertify.alert(xhtml, function(){
                                // window.funLazyLoad.reset();
                                //     // location.reload(true);
                              });
                        });
    </script>