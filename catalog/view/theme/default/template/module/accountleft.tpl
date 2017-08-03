<?php $route=$self -> request -> get['route']; ?> 
<aside class="app-layout-drawer">
   <!-- Drawer scroll area --> 
   <div class="app-layout-drawer-scroll">
      <!-- Drawer logo --> <!-- Drawer navigation --> 
      <nav class="drawer-main">
         <ul class="nav nav-drawer">
 
        
         <li class="nav-item nav-drawer-header" style="color: #f5d11b; opacity: 1; text-transform: capitalize; font-size: 14px;">
         <?php $date = new DateTime($servertime['servertime']); ?>
         <span class="blinking"> Server Time: <?php echo date_format($date, 'l jS \of F Y H:i:s A'); ?> </span>
        
         </li>
         
    
            <li class="nav-item <?php echo $route==='account/dashboard' ? 'active' : '' ?>"> <a href="home.html"><i class="ion-home"></i> Dashboard</a> </li>
            <li class="nav-item <?php echo $route==='account/pd' ? 'active' : '' ?>"> <a href="investment-detail.html"><i class="ion-ios-plus-outline"></i> Deposite</a> </li>
          
             <li class="nav-item nav-item-has-subnav <?php echo $route==='account/withdraw' || $route==='account/withdraw/withdraw_capital' ? 'active open' : '' ?>">
               <a href="javascript:void(0)"><i class="ion-ios-calculator-outline"></i> Withdrawal</a> 
               <ul class="nav nav-subnav">
                  <li> <a href="withdraw">Withdrawal Profit/Commission</a> </li>
                  <li> <a href="withdraw-capital"> Withdraw Capital</a> </li>
            <!-- withdraw-capital -->
               </ul>
            </li>
            
             <li class="nav-item nav-item-has-subnav <?php echo $route==='account/transfer' || $route==='account/transfer/transfer_my_wallet' ? 'active open' : '' ?>">
               <a href="javascript:void(0)"><i class="ion-ios-calculator-outline"></i> Transfer Money</a> 
               <ul class="nav nav-subnav">
                  <li> <a href="transfer">Transfer to Member</a> </li>
                  <li> <a href="transfer-wallet"> Transfer In My Wallet</a> </li>
            <!-- withdraw-capital -->
               </ul>
            </li>
            <li class="nav-item <?php echo $route==='account/refferal' ? 'active' : '' ?>"> <a href="refferal"><i class="ion-ios-people"></i> Refferal</a> </li>
   
            <li class="nav-item nav-item-has-subnav <?php echo $route==='account/personal' || $route==='account/personal/team_network' ? 'active open' : '' ?>">
               <a href="javascript:void(0)"><i class="ion-merge"></i>NetWork</a> 
               <ul class="nav nav-subnav">
                  <li> <a href="column-tree.html">Binary Tree</a> </li>
                  <li> <a href="Team-Network-Summary"> Team Network Summary</a> </li>
          
               </ul>
            </li>
            
            <li class="nav-item nav-item-has-subnav <?php echo $route==='account/transaction_history' || $route==='account/transaction_history/binary' || $route==='account/transaction_history/reffernal' || $route==='account/transaction_history/co_division_commission' ? 'active open' : '' ?>">
               <a href="javascript:void(0)"><i class="ion-clipboard"></i> Transaction History</a> 
               <ul class="nav nav-subnav">
                  <li> <a href="everyday-profit.html">Weekly rates</a> </li>
                  <li> <a href="binary-profit.html">Binary Bonus</a> </li>
                  <li> <a href="refferal-profit.html">Refferal Commission</a> </li>
                  <li> <a href="co-division-commission">Co-division Commission</a> </li>
               </ul>
            </li>
            <li class="nav-item <?php echo $route==='account/setting' ? 'active' : '' ?>"> <a href="your-profile.html"><i class="ion-gear-a" ></i> Account</a> </li>
            <li class="nav-item"> <a href="logout"><i class="ion-log-out" ></i> Logout</a> </li>
         </ul>
      </nav>
      <!-- End drawer navigation --> 
      <div class="drawer-footer" style="margin-top: 0px; padding: 0px 20px;" >
         <p class="copyright"><a href="http://t.me/BFEB_bot" target="_blank"><img src="catalog/view/theme/default/img/chat-icon.png"></a></p>
      </div>
   </div>
   <!-- End drawer scroll area --> 
</aside>
<header class="app-layout-header">
   <nav class="navbar navbar-default">
      <div class="container-fluid">
         <div class="navbar-header"> <button class="pull-left hidden-lg hidden-md navbar-toggle" type="button" data-toggle="layout" data-action="sidebar_toggle"> <span class="sr-only">Toggle drawer</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button> </div>
         <div class="pull-left">
            <div id="logo" class="drawer-header"> <a href=""><img class="img-responsive" src="catalog/view/theme/default/img/logo.png" title="BitflyerBank" alt="BitflyerBank" /></a> </div>
         </div>
         <div class="pull-right" >
            <!-- .navbar-left --> 
            <ul class="nav nav-header navbar-nav navbar-right ">
               <li>
                  <!-- Opens the modal found at the bottom of the page --> <a href="javascript:void(0)" data-toggle="modal" data-target="#apps-modal"><i class="ion-grid"></i></a> 
               </li>
               <li class="dropdown dropdown-profile">
                  <a href="javascript:void(0)" data-toggle="dropdown"> <span class="m-r-sm"><?php echo $username; ?><span class="caret"></span></span> <?php if ($img_profile ) {echo  '<img class="img-avatar img-avatar-48" src="'.$img_profile.'" />'; }else{echo '<img class="img-avatar img-avatar-48" src="catalog/view/theme/default/stylesheet/icons/user-avatar.jpg" />'; } ?> </a> 
                  <ul class="dropdown-menu dropdown-menu-right">
                     <li class="dropdown-header"> Pages </li>
                     <li> <a href="your-profile.html">Profile</a> </li>
                     <li> <a href="logout">Logout</a> </li>
                  </ul>
               </li>
            </ul>
            <!-- .navbar-right --> 
         </div>
      </div>
      <!-- .container-fluid --> 
   </nav>
   <!-- .navbar-default --> 
</header>
