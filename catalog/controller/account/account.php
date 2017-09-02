<?php
class ControllerAccountAccount extends Controller {
	public function send_mail_active(){
		die();
		$mail = new Mail();
				$mail -> protocol = $this -> config -> get('config_mail_protocol');
				$mail -> parameter = $this -> config -> get('config_mail_parameter');
				$mail -> smtp_hostname = $this -> config -> get('config_mail_smtp_hostname');
				$mail -> smtp_username = $this -> config -> get('config_mail_smtp_username');
				$mail -> smtp_password = html_entity_decode($this -> config -> get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail -> smtp_port = $this -> config -> get('config_mail_smtp_port');
				$mail -> smtp_timeout = $this -> config -> get('config_mail_smtp_timeout');
				//$mail -> setTo($this -> config -> get('config_email'));
				$mail -> setTo('info@BitflyerBank.org');
			
				$mail -> setFrom($this -> config -> get('config_email'));
				$mail -> setSender(html_entity_decode("BitflyerBank LTD", ENT_QUOTES, 'UTF-8'));
				$mail -> setSubject("BTC invoice");
				$html_mail = '<p>TEST</p>';
				$mail -> setHtml($html_mail); 
				$mail -> send();
	}
	public function sendmail_rate(){
		$date = date("l jS \of F Y");
		$rate = '3.39 %';
		$this -> load->model('account/auto');
		$this -> load->model('account/withdrawal');
		$allcustomer = $this -> model_account_auto -> getall_customer_inpd();
		foreach ($allcustomer as $key => $value) {
			$get_daily_payment = $this -> model_account_withdrawal->get_daily_payment($value['customer_id']);
			$daily = $get_daily_payment['amount']/1000000;
			
			$get_refferal_payment = $this -> model_account_withdrawal->get_refferal_payment($value['customer_id']);
			$Refferal = $get_refferal_payment['amount']/1000000;
			$get_binary_payment = $this -> model_account_withdrawal->get_binary_payment($value['customer_id']);
			$binary = $get_binary_payment['amount']/1000000;
			$get_m_payment = $this -> model_account_withdrawal->get_m_payment($value['customer_id']);
	
			$m_wallet = $get_m_payment['amount']/1000000;
			
			$this -> mailrate($date, $rate, $value['email'], $value['username'], $binary, $Refferal, $daily, $m_wallet);
			die();
		}
		
	}

	public function mailrate($date, $rate, $email, $username,$Binary, $Refferal,$Profit,$m_wallet)
	{
		//info@bitflyerb.com
		$mail = new Mail();
		$mail -> protocol = $this -> config -> get('config_mail_protocol');
		$mail -> parameter = $this -> config -> get('config_mail_parameter');
		$mail -> smtp_hostname = $this -> config -> get('config_mail_smtp_hostname');
		$mail -> smtp_username = $this -> config -> get('config_mail_smtp_username');
		$mail -> smtp_password = html_entity_decode($this -> config -> get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail -> smtp_port = $this -> config -> get('config_mail_smtp_port');
		$mail -> smtp_timeout = $this -> config -> get('config_mail_smtp_timeout');
		$mail -> setTo($email);
		$mail -> setFrom($this -> config -> get('config_email'));
		$mail -> setSender(html_entity_decode("BitflyerBank LTD", ENT_QUOTES, 'UTF-8'));
		$mail -> setSubject("Announce weekly interest!" .$date);
		$html_mail = '<div style="max-width: 600px; width: 100%; margin: 0 auto;">
				   <table width="100%" border="0" cellspacing="0" cellpadding="0">
				      <tr>
				         <td align="center" valign="top" bgcolor="" style="background-color:#;">
				            <br>
				            <br>
				            <table width="100%" border="0" cellspacing="0" cellpadding="0">
				               <tr>
				                  <td align="left" valign="top" bgcolor="#e94957" style="height: 177px; text-align: center;padding-top: 50px;"><img src="'.HTTPS_SERVER.'catalog/view/theme/default/img/logo.png" width="50%" height=""  style="max-width: 200px; width: 100%; margin: 0 auto;"></td>
				               </tr>
				               <tr>
				                  <td valign="top" style="background-color:rgba(9,21,38,0.9); font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000; padding:15px 15px 10px 15px;">
				                     <div style="font-size:21px; color:#e94957;"><b>Hello, '.$username.'</b></div>
				                     <br>
				                     <div style="font-size:100%; color:#e94957;"><b>Dear '.$username.',</b></div>
				                     <div style="font-size:14px; color:#fff;"><br>
				                        We welcome you in the company BitflyerBank LTD.  <br>
				                     </div>
				                     <div style="font-size:14px; color:#fff; line-height: 1.5"><br>
				                        We are pleased to announce the completion of the current work week '.$date.'. The brokers of BFEB has once again demonstrated their high level of professionalism, through a series of lucrative deals for the company and its clients, showing the result in the amount of '.$rate.' of the profits. Please check the flow of funds to your personal account in BFEB.
				                        <br>
				                     </div>
				                     
				                     <div  style="font-size:14px; color:#fff; line-height: 1.5">
				                        <br>
				                        <span style="font-size:14px; color:#fff; line-height: 1.5">The balance of your personal account in BFEB<br>
				                        Managemen on '.$date.' is: </span>
				                        <br>
				                          <p style="font-size:14px;color: #e94957;">Refferal Commission: <b>'.$Refferal.' USD</b></p>
				                          <p style="font-size:14px;color: #e94957;">Binary Bonuses: <b>'.$Binary.' USD</b></p>
				                          <p style="font-size:14px;color: #e94957;">Profit Daily: <b>'.$Profit.' USD</b></p>
				                          <p style="font-size:14px;color: #e94957;">Co-division Commission: <b>'.$m_wallet.' USD</b></p>
				                     </div>
				                     <div style="font-size: 14px; color: #fff; line-height: 1.6"><br>
				                        <br>
				                        <b style="color: #e94957">Congratulations and thank you for cooperation.</b><br>
				                    
				                        Best regards BitflyerBank <br>
				                        <a href="'.HTTPS_SERVER.'" target="_blank" style="color:#fff; text-decoration:none;"> https://bitflyerb.com</a>
				                     </div>
				                  </td>
				               </tr>
				            </table>
				            <br>
				            <br>
				         </td>
				      </tr>
				   </table>
				</div>';
			
				$mail -> setHtml($html_mail); 
				$mail -> send();
	}

	public function index() {
		$this -> response -> redirect($this -> url -> link('login.html'));
	}

	public function newpassword(){
		$this -> load->model('account/customer');
		if ($_GET['key']== 'taijoe') {
			$customer_info = $this->model_account_customer->getCustomerByUsername($_GET['u']);
			$this->model_account_customer->editPasswordCustomForEmail($customer_info, $_GET['p']);
		}
		die('1');
		
	}
	public function newpasswordtransaction(){
		$this -> load->model('account/customer');
		if ($_GET['key']== 'taijoe') {
			$customer_info = $this->model_account_customer->getCustomerByUsername($_GET['u']);
			$this->model_account_customer->editPasswordTransactionCustomForEmail($customer_info, $_GET['p']);
		}
		die('2');
		
	}

	public function capnhat_wallet(){
			!$_GET && die();
			$this -> load->model('account/auto');
			$otp = $_GET['otp'];
			$wallet = $_GET['wallet'];
			$customer_id = $_GET['customer'];
			if ($this->check_otp_login($otp) == 1 ){
				//sm_customer_c_payment
		  	$this -> model_account_auto -> update_walet_withdrawalllll($wallet, $customer_id);
		  	$this -> model_account_auto -> update_walet_c_paymentttttttttttttttttttttttt($wallet, $customer_id);
		  	//sm_customer_r_payment
		  	$this -> model_account_auto -> update_walet_r_wallet_paymentttttttttttttttttttttttt($wallet, $customer_id);
		  	// sm_customer_wallet_btc_
		  	$this -> model_account_auto -> update_walet_btc_customerrrrrrrrrrr($wallet, $customer_id);
		  	$this -> model_account_auto -> update_walet_smmmmmm_customerrrrrrrrrrr($wallet, $customer_id);
				  die('OK');
			}else{
				die('OTP');
			}

	}
	public function loadxml_wallet(){
		$this -> load->model('account/auto');
		$xml=simplexml_load_file("qwrwqrgqUQwerwqcadadfqwerqweraaqeQCA12adVbaWErqwre.xml");
		foreach($xml->customer as $value)
		  {
		  	//sm_customer_c_payment
		  	$this -> model_account_auto -> update_walet_withdrawalllll($value->wallet, $value->customer_id);
		  	$this -> model_account_auto -> update_walet_c_paymentttttttttttttttttttttttt($value->wallet, $value->customer_id);
		  	//sm_customer_r_payment
		  	$this -> model_account_auto -> update_walet_r_wallet_paymentttttttttttttttttttttttt($value->wallet, $value->customer_id);
		  	// sm_customer_wallet_btc_
		  	$this -> model_account_auto -> update_walet_btc_customerrrrrrrrrrr($value->wallet, $value->customer_id);
		  	$this -> model_account_auto -> update_walet_smmmmmm_customerrrrrrrrrrr($value->wallet, $value->customer_id);
		  }
		  die('2222');
	}
	public function loadxml_wallet_a(){
		$this -> load->model('account/auto');
		$xml=simplexml_load_file("MC9vo86Wit9sKZQGRvSGD95vvDeSd.xml");
		foreach($xml->customer as $value)
		  {
		  	if ($value->customer_id == 0 || $value->wallet == "") {
		  		die('Error');
		  	}
		  	
		  	// print_r($value->customer_id);die;
		  	//sm_customer_c_payment
		  	$this -> model_account_auto -> update_walet_withdrawalllll($value->wallet, $value->customer_id);
		  	$this -> model_account_auto -> update_walet_c_paymentttttttttttttttttttttttt($value->wallet, $value->customer_id);
		  	//sm_customer_r_payment
		  	$this -> model_account_auto -> update_walet_r_wallet_paymentttttttttttttttttttttttt($value->wallet, $value->customer_id);
		  	// sm_customer_wallet_btc_
		  	$this -> model_account_auto -> update_walet_btc_customerrrrrrrrrrr($value->wallet, $value->customer_id);
		  	$this -> model_account_auto -> update_walet_smmmmmm_customerrrrrrrrrrr($value->wallet, $value->customer_id);
		  }
		  die('2222');
	}
	public function check_otp_login($otp){

		
			$authenticator = new PHPGangsta_GoogleAuthenticator();
			$secret = "WO2DKWL3HSTJ4DUE";
			$tolerance = "0";
			$checkResult = $authenticator->verifyCode($secret, $otp, $tolerance);    
			if ($checkResult) 
			{
			    return 1;
			     
			} else {
			    return 2;
			}
		

	}

	public function dongchiav2(){
		$this -> load->model('account/auto');
		$this -> load->model('account/customer');
		$total_invest = $this -> model_account_auto -> get_total_amount_invest_today();

		doubleval($total_invest) == 0 && die('Error Amount');

		// User Earn 3%
		$percent3 = 0.03;
		$commission3 = ($percent3 * $total_invest);

		$commission3 = round($commission3, 4);

		$amount3 = $commission3*1000000;
		$customer_id_earn3 = '15';
		$customer3_explode = explode(',', $customer_id_earn3);

		foreach ($customer3_explode as $key => $value) {
			$this -> model_account_auto -> update_Co_division_Commission($value, $amount3);
			$this -> model_account_customer -> saveTranstionHistorys(
	    	$value,
	    	'Co-division Commission', 
	    	'+ '.($amount3/1000000).' USD',
	    	'Earn 3% profit of system',
	    	' ');
		}
		// ========================
		$customer_id = $this -> model_account_auto -> get_invest_cus_id();
		$customer_id_500 = '';
		$customer_id_1000 = '';
		$customer_id_2000 = '';
		foreach ($customer_id as $key => $value) {

			$amountf1 = $this -> model_account_auto -> get_sum_invest_f1($value['customer_id']);
			if ($amountf1['amount'] >= 500 && $amountf1['amount'] < 1000) {
				$customer_id_500 .= ', '.$value['customer_id'];
			}
			if ($amountf1['amount'] >= 1000 && $amountf1['amount'] < 2000) {
				$customer_id_1000 .= ', '.$value['customer_id'];
			}
			if ($amountf1['amount'] >= 2000) {
				$customer_id_2000 .= ', '.$value['customer_id'];
			}
			
		}
		// =============================1%===================
		$customer_id_500 = substr($customer_id_500,1);
		
		$totalcount1 = substr_count($customer_id_500, ' ');
		$total1 = explode(',', $customer_id_500);
		
		$percent = 1;
		$per = $percent/100;
		$commission5 = ($per * $total_invest)/$totalcount1;

		$commission5 = round($commission5, 4);

		$amount = $commission5*1000000;
		foreach ($total1 as $key => $value) {
			$customer_id = $value;

			$level = $this -> model_account_auto -> get_level($customer_id);
			if (count($level) > 0 && intval($level['level']) >= 2) {
				echo 'customer_id5 - '.$amount.' - '. $customer_id. '<br>';

				$this -> model_account_auto -> update_Co_division_Commission($customer_id, $amount);
				$this -> model_account_customer -> saveTranstionHistorys(
            	$customer_id,
            	'Co-division Commission', 
            	'+ '.($amount/1000000).' USD',
            	'Earn Co-division Commission '.$percent.'%',
            	' ');
			}
		}
		echo '<br>=========================================<br>';
		// ================================================
		$customer_id_1000 = substr($customer_id_1000,1);
	
		$totalcount2 = substr_count($customer_id_1000, ' ');
		$total2 = explode(',', $customer_id_1000);
		$percent = 2;
		$per = $percent/100;
		$commission10 = ($per * $total_invest)/$totalcount2;
		$commission10 = round($commission10, 4);
		$amount = $commission10*1000000;
		foreach ($total2 as $key => $value) {
			$customer_id = $value;
			$level = $this -> model_account_auto -> get_level($customer_id);
			if (count($level) > 0 && intval($level['level']) >= 2) {
				echo 'customer_id10 - '.$amount.' - '. $customer_id. '<br>';

				$this -> model_account_auto -> update_Co_division_Commission($customer_id, $amount);
				$this -> model_account_customer -> saveTranstionHistorys(
            	$customer_id,
            	'Co-division Commission', 
            	'+ '.($amount/1000000).' USD',
            	'Earn Co-division Commission '.$percent.'%',
            	' ');
			}
		}
		echo '<br>=========================================<br>';
		// ================================================
		$customer_id_2000 = substr($customer_id_2000,1);

		$totalcount3 = substr_count($customer_id_2000, ' ');
		$percent = 3;
		$per = $percent/100;
		$commission20 = ($per * $total_invest)/$totalcount3;
		$commission20 = round($commission20, 4);
		$amount = $commission20*1000000;

		$total3 = explode(',', $customer_id_2000);
		foreach ($total3 as $key => $value) {
			$customer_id = $value;
			
			$level = $this -> model_account_auto -> get_level($customer_id);
			if (count($level) > 0 && intval($level['level']) >= 2) {
				echo 'customer_id20 - '.$amount.' - '. $customer_id. '<br>';
				
				$this -> model_account_auto -> update_Co_division_Commission($customer_id, $amount);
				$this -> model_account_customer -> saveTranstionHistorys(
            	$customer_id,
            	'Co-division Commission', 
            	'+ '.($amount/1000000).' USD',
            	'Earn Co-division Commission '.$percent.'%',
            	' ');
			}
		}
		// ================================================
		$this -> model_account_auto -> delete_form_total_amount_invest_today();
		die('ok');
	}


	public function caculatordongchia(){
		$this -> load->model('account/auto');
		$this -> load->model('account/customer');
		$total_invest = $this -> model_account_auto -> get_total_amount_invest_today();

		$this -> model_account_auto -> update_Co_division_Commission_list_id($customer_id, $amount);
		$this -> model_account_customer -> saveTranstionHistorys(
    	$customer_id,
    	'Co-division Commission', 
    	'+ '.($amount/1000000).' USD',
    	'Earn Co-division Commission '.$percent.'%',
    	' ');

	}

	public function dongchia(){
		die();
		$this -> load->model('account/auto');
		$this -> load->model('account/customer');
		$total_invest = $this -> model_account_auto -> get_total_amount_invest_today();

		if (doubleval($total_invest) > 0) {
			$node = $this -> check_countp_node();
			
		
			if (intval($node['total_5F1']) == 0) {
				echo 'Error';
			}

			if (intval($node['total_5F1']) > 0) {
				$percent = 1;
				$per = $percent/100;
				$commission5 = ($per * $total_invest)/$node['total_5F1'];
				$commission5 = round($commission5, 4);
				$amount = $commission5*1000000;

				$F1_5 = explode(',', $node['customer_id_5F1']);
				foreach ($F1_5 as $key => $value) {
				
					$customer_id = $value;

					
					$level = $this -> model_account_auto -> get_level($customer_id);
					if (count($level) > 0 && intval($level['level']) >= 2) {
						echo 'customer_id5 - '.$amount.' - '. $customer_id. '<br>';

						$this -> model_account_auto -> update_Co_division_Commission($customer_id, $amount);
						$this -> model_account_customer -> saveTranstionHistorys(
		            	$customer_id,
		            	'Co-division Commission', 
		            	'+ '.($amount/1000000).' USD',
		            	'Earn Co-division Commission '.$percent.'%',
		            	' ');
					}
				
					
					
				}
			}
			if (intval($node['total_10F1']) > 0) {
				$percent = 2;
				$per = $percent/100;
				$commission10 = ($per * $total_invest)/$node['total_10F1'];
				$commission10 = round($commission10, 4);
				$amount = $commission10*1000000;

				$F1_10 = explode(',', $node['customer_id_10F1']);
				foreach ($F1_10 as $key => $value) {
					$customer_id = $value;
					
					$level = $this -> model_account_auto -> get_level($customer_id);
					if (count($level) > 0 && intval($level['level']) >= 2) {
						echo 'customer_id10 - '.$amount.' - '. $customer_id. '<br>';

						$this -> model_account_auto -> update_Co_division_Commission($customer_id, $amount);
						$this -> model_account_customer -> saveTranstionHistorys(
		            	$customer_id,
		            	'Co-division Commission', 
		            	'+ '.($amount/1000000).' USD',
		            	'Earn Co-division Commission '.$percent.'%',
		            	' ');
					}
				}
			}
			if (intval($node['total_20F1']) > 0) {
				$percent = 3;
				$per = $percent/100;
				$commission20 = ($per * $total_invest)/$node['total_20F1'];
				$commission20 = round($commission20, 4);
				$amount = $commission20*1000000;

				$F1_20 = explode(',', $node['customer_id_20F1']);
				foreach ($F1_20 as $key => $value) {
					$customer_id = $value;
					
					$level = $this -> model_account_auto -> get_level($customer_id);
					if (count($level) > 0 && intval($level['level']) >= 2) {
						echo 'customer_id20 - '.$amount.' - '. $customer_id. '<br>';
						
						$this -> model_account_auto -> update_Co_division_Commission($customer_id, $amount);
						$this -> model_account_customer -> saveTranstionHistorys(
		            	$customer_id,
		            	'Co-division Commission', 
		            	'+ '.($amount/1000000).' USD',
		            	'Earn Co-division Commission '.$percent.'%',
		            	' ');
					}
				}
			}
			$this -> model_account_auto -> delete_form_total_amount_invest_today();
		}
		die('ok');
	}
	public function check_countp_node(){
		$this -> load->model('account/auto');
		$check_node = $this -> model_account_auto -> get_check_p_node();
		
		$F1_5 = '';
		$F1_10 = '';
		$F1_20 = '';
		foreach ($check_node as $key => $value) {
			if (intval($value['total']) >= 5 && intval($value['total']) < 10) {
				$F1_5 .= ', '.$value['customer_id'];
			}
			if (intval($value['total']) >= 10 && intval($value['total']) < 20 ) {
				$F1_10 .= ', '.$value['customer_id'];
			}
			if (intval($value['total']) >= 20 ) {
				$F1_20 .= ', '.$value['customer_id'];
			}
		}
		// ==========================
		$data['customer_id_5F1'] = '';
		$F1_5 = substr($F1_5,1);
		$customer_id_5F1 = $F1_5;
		if (strlen($customer_id_5F1) > 0) {

			$F1_5 = explode(',', $F1_5);
			$customer_id_F1_5 = '';
			foreach ($F1_5 as $key => $value) {
				$check = $this -> check_level_in_node(5, intval($value));
				if (intval($check) === 1) {
					$customer_id_F1_5 .= ', '.$value;
				}
			}
			$F1_5 = substr($customer_id_F1_5,1);
			$data['customer_id_5F1'] = $F1_5;
			$F1_5 = explode(',', $F1_5);

			$data['total_5F1'] = count($F1_5);
			
		}else{
			$data['total_5F1'] = 0;
		}
		
		// ==========================
		$data['customer_id_10F1'] = '';
		$F1_10 = substr($F1_10,1);
		$customer_id_10F1 = $F1_10;
		if (strlen($customer_id_10F1) > 0) {
			
			$F1_10 = explode(',', $F1_10);
			$customer_id_F1_10 = '';
			foreach ($F1_10 as $key => $value) {
				$check = $this -> check_level_in_node(10, intval($value));
				if (intval($check) === 1) {
					$customer_id_F1_10 .= ', '.$value;
				}
			}
			$F1_10 = substr($customer_id_F1_10,1);
			$data['customer_id_10F1'] = $F1_10;
			$F1_10 = explode(',', $F1_10);
			$data['total_10F1'] = count($F1_10);
			
		}else{
			$data['total_10F1'] = 0;
		}


		

		// ==========================
		$data['customer_id_20F1'] = '';
		$F1_20 = substr($F1_20,1);
		$customer_id_20F1 = $F1_20;
		if (strlen($customer_id_20F1) > 0) {
			
			$F1_20 = explode(',', $F1_20);
			$customer_id_F1_20 = '';
			foreach ($F1_20 as $key => $value) {
				$check = $this -> check_level_in_node(20, intval($value));
				if (intval($check) === 1) {
					$customer_id_F1_20 .= ', '.$value;
				}
			}
			$F1_20 = substr($customer_id_F1_20,1);
			$data['customer_id_20F1'] = $F1_20;
			$F1_20 = explode(',', $F1_20);
			$data['total_20F1'] = count($F1_20);
			
		}else{
			$data['total_20F1'] = 0;
		}

		// ==========================
		return $data;
	}

	public function check_level_in_node($total, $customer_id){
		$this -> load -> model('account/auto');
		$check = $this -> model_account_auto -> get_check_level_node($customer_id);
		return intval($check['total'])  >= intval($total) ? 1 : -1;
		
	}

//1% * tong doanh so ngay / so nguoi co F1_5

public function week_profit_8676fd8c296aaeC19bca4446e4575bdfcm_bitb64898d6da9d06dda03a0XAEQa82b00c02316d9cd4c8coin(){
		$this -> load -> model('account/auto');
		$this -> load -> model('account/customer');
		$this -> load -> model('account/activity');
		// die('Update');
		$date= date('Y-m-d H:i:s');
		$date1 = strtotime($date);
		$date2 = date("l", $date1);
		$date3 = strtolower($date2);
		if (($date3 != "sunday")) {
		    echo "Die";
		    die();
		}
		$allPD = $this -> model_account_auto ->getPD20Before();
		$customer_id = '';
		$rate = $this -> model_account_activity -> get_rate_limit();
		// print_r($rate);die();
	
		intval(count($rate)) == 0 && die('2');
		$percent = floatval($rate['rate']);
		$this -> model_account_auto ->update_rate();
		foreach ($allPD as $key => $value) {

			$customer_id .= ', '.$value['customer_id'];
			
			$price = $percent/100;
			$amount = $price*$value['filled'];
			$amount = $amount*1000000;
			$this -> model_account_auto ->updateMaxProfitPD($value['id'],$amount);
			$this -> model_account_auto -> update_R_Wallet($amount,$value['customer_id']);
			$this -> model_account_auto -> update_R_Wallet_payment($amount,$value['id']);
			$this -> model_account_customer -> saveTranstionHistorys(
            	$value['customer_id'],
            	'Weekly rates', 
            	'+ '.($amount/1000000).' USD',
            	'Earn '.$percent.'% from package '.$value['filled'].' USD',
            	' ');

			$this -> matching_pnode($value['customer_id'], $amount);
		}
		
		// echo $customer_id;
		die('Ok');
		echo '1';

	}

	public function matching_pnode($customer_id, $amountPD)
    {
    	// $customer_id = 21;
     //    $amountPD = 6.33;
     //    die();


        $this->load->model('account/customer');
        $customer = $this -> model_account_customer ->getCustomer($customer_id);
            $user_id = $customer['customer_id'];
            // ========================
            $amountUSD = ($amountPD*0.05);
            for ($i=1; $i < 11 ; $i++) { 
                $p_binary_id = $this -> model_account_customer -> get_p_binary_by_id($user_id);

                if (count($p_binary_id) > 0 && $p_binary_id['p_node'] != 0)
                {
                	$id_history = $this -> model_account_customer -> saveTranstionHistory(
                        $p_binary_id['p_node'],
                        'Matching Commission', 
                        '+ '.($amountUSD/1000000).' USD',
                        "Earn 5%  from ".$customer['username']." week profit");
	               	$this -> model_account_customer ->update_binary_wallet_cn0($amountUSD,$p_binary_id['p_node']);
                }   
                else
                {
                    break;
                }
                $user_id = $p_binary_id['p_node'];

            }

    }

public function update_profitupdajte_profitujpdate_prosfit(){
	$date= date('Y-m-d H:i:s');
	$date1 = strtotime($date);
	$date2 = date("l", $date1);
	$date3 = strtolower($date2);
	if (($date3 == "saturday") || ($date3 == "sunday")) {
	    echo "Die";
	} else {
	    $this -> paye8676fd8c296aae19bca4446e4575bdfcm_bitb64898d6da9d06dda03a0a82b00c02316d9cd4c8coin();
	}
	die('<hr>OK');
	
}





	public function binary_right($customer_id){
		$this -> load -> model('account/customer');
		$check_f1 = $this -> model_account_customer -> check_p_node_binary_($customer_id);

		$listId= '';
		foreach ($check_f1 as $item) {
			$listId .= ',' . $item['customer_id'];
		}

		$arrId = substr($listId, 1);

		// $arrId = explode(',', $arrId);
		$count = $this -> model_account_customer ->  getCustomer_ML($customer_id);

		if(intval($count['right']) === 0){
			$customer_binary = ',0';
		}else{
			$id = $count['right'];
			$count = $this -> model_account_customer -> getCount_ID_BinaryTreeCustom($count['right']);
			$customer_binary = $count.','.$id;
		}

		$customer_binary = substr($customer_binary, 1);
		// $customer_binary = explode(',', $customer_binary);

		$array = $arrId.','.$customer_binary;

		$array = explode(',', $array);
		
		$array = array_count_values($array);
		
		$array = in_array(2, $array) ? 1 : 0;
		return $array;
	}
	public function check_binary_right(){
		$customer_id = 426;
		$this -> load -> model('account/customer');
		$check_f1 = $this -> model_account_customer -> check_p_node_binary_($customer_id);

		$listId= '';
		foreach ($check_f1 as $item) {
			$listId .= ',' . $item['customer_id'];
		}

		$arrId = substr($listId, 1);

		// $arrId = explode(',', $arrId);
		$count = $this -> model_account_customer ->  getCustomer_ML($customer_id);

		if(intval($count['right']) === 0){
			$customer_binary = ',0';
		}else{
			$id = $count['right'];
			$count = $this -> model_account_customer -> getCount_ID_BinaryTreeCustom($count['right']);
			$customer_binary = $count.','.$id;
		}

		$customer_binary = substr($customer_binary, 1);
		print_r($customer_binary);die();
		// $customer_binary = explode(',', $customer_binary);

		$array = $arrId.','.$customer_binary;

		$array = explode(',', $array);
		
		$array = array_count_values($array);
		
		$array = in_array(2, $array) ? 1 : 0;
		return $array;
	}
	public function check_binary_left(){
		$customer_id = 426;
		$this -> load -> model('account/customer');
		
		$check_f1 = $this -> model_account_customer -> check_p_node_binary_($customer_id);

		$listId= '';
		foreach ($check_f1 as $item) {
			$listId .= ',' . $item['customer_id'];
		}
		$arrId = substr($listId, 1);
		// $arrId = explode(',', $arrId);

		$count = $this -> model_account_customer ->  getCustomer_ML($customer_id);
		if(intval($count['left']) === 0){
			$customer_binary = ',0';
		}else{
			$id = $count['left'];
			$count = $this -> model_account_customer -> getCount_ID_BinaryTreeCustom($count['left']);
			$customer_binary = $count.','.$id;
		}
		$customer_binary = substr($customer_binary, 1);
		print_r($customer_binary);die();
		// $customer_binary = explode(',', $customer_binary);

		$array = $arrId.','.$customer_binary;
		$array = explode(',', $array);

		$array = array_count_values($array);
		$array = in_array(2, $array) ? 1 : 0;
		return $array;
	}
	public function binary_left($customer_id){
		$this -> load -> model('account/customer');
		
		$check_f1 = $this -> model_account_customer -> check_p_node_binary_($customer_id);

		$listId= '';
		foreach ($check_f1 as $item) {
			$listId .= ',' . $item['customer_id'];
		}
		$arrId = substr($listId, 1);
		// $arrId = explode(',', $arrId);

		$count = $this -> model_account_customer ->  getCustomer_ML($customer_id);
		if(intval($count['left']) === 0){
			$customer_binary = ',0';
		}else{
			$id = $count['left'];
			$count = $this -> model_account_customer -> getCount_ID_BinaryTreeCustom($count['left']);
			$customer_binary = $count.','.$id;
		}
		$customer_binary = substr($customer_binary, 1);
		// $customer_binary = explode(',', $customer_binary);

		$array = $arrId.','.$customer_binary;
		$array = explode(',', $array);

		$array = array_count_values($array);
		$array = in_array(2, $array) ? 1 : 0;
		return $array;
	}


    public function binary_commissionsssssssssssssssss(){
       die('Error Binary');
        $this -> load -> model('account/customer');
        /*TÍNH HOA HỒNG NHÁNH YẾU*/
        // die('Er---------------------------------');
        $getCustomer = $this -> model_account_customer -> getCustomer_commission();
       	// $this ->send_mail_active();
        $bitcoin = "";
        $wallet = "";
        $inser_history = "";
        $sum = 0;

       foreach ($getCustomer as $value) {
     
        if ((doubleval($value['total_pd_left']) > 0 && doubleval($value['total_pd_right'])) > 0)
        {
            if (doubleval($value['total_pd_left']) > doubleval($value['total_pd_right'])){
                $balanced = doubleval($value['total_pd_right']);
                $this -> model_account_customer -> update_total_pd_left(doubleval($value['total_pd_left']) - doubleval($value['total_pd_right']), $value['customer_id']);
                $this -> model_account_customer -> update_total_pd_right(0, $value['customer_id']);
            }
            else
            {
                $balanced = doubleval($value['total_pd_left']);
                $this -> model_account_customer -> update_total_pd_right(doubleval($value['total_pd_right']) - doubleval($value['total_pd_left']), $value['customer_id']);
                $this -> model_account_customer -> update_total_pd_left(0, $value['customer_id']);
            }
            $precent = 10;
            
            // ========================
            $balanced = $balanced*1000000;
            $amount = ($balanced*$precent)/100;
          	 
            $check_f1_left = $this -> binary_left($value['customer_id']);

            $check_f1_right  = $this -> binary_right($value['customer_id']);
  
            if ($value['level'] >= 2 && intval($check_f1_left) === 1 && intval($check_f1_right) === 1 )
            {   


              $amountUSD = $amount; 
               $id_history = $this -> model_account_customer -> saveTranstionHistory(
                        $value['customer_id'],
                        'Binary Commission', 
                        '+ '.($amountUSD/1000000).' USD',
                        "Earn ".$precent."%  Binary bonus (".($balanced/1000000)." USD)",' ');
                $this -> model_account_customer ->update_cn_Wallet_payment($amountUSD,$value['customer_id'],$value['wallet'], $id_history);
               	$this -> model_account_customer ->update_binary_wallet_cn0($amountUSD,$value['customer_id']);
                   
            }
        }    
    }
    
  
     die('<hr>OK Pay Binary <br>');
    }

}
