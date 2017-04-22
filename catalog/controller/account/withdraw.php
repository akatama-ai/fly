<?php
class ControllerAccountWithdraw extends Controller {

	public function index() {
		
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> document -> addScript('catalog/view/javascript/tranfercm.js');
			
		};

		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		
		$session_id = $this -> session -> data['customer_id'];
		$this -> load -> model('account/customer');
		$data = array();
		$data['self'] = $this;
		$data['customer'] = $customer = $this -> model_account_customer -> getCustomer($this -> session -> data['customer_id']);
		
 		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;

		$limit = 10;
		$start = ($page - 1) * 10;

		$ts_history = $this -> model_account_customer -> getTotalHistory_withdraw($this -> session -> data['customer_id']);

		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = HTTPS_SERVER . 'withdraw&page={page}';
		$data['histotys'] = $this -> model_account_customer -> getTransctionHistory_withdraw($this -> session -> data['customer_id'], $limit, $start);

		$data['pagination'] = $pagination -> render();

		$this -> load -> model('account/withdrawal');
		
		$data['profit_daily'] = $this -> get_daily_profit();
		$data['refferal_profit'] = $this -> get_refferal_commisson();
		$data['binary_bonus'] = $this -> getBinaryBonus($this -> session -> data['customer_id']);
		$data['getMWallet'] = $this -> getMWallet($this -> session -> data['customer_id']);
		$data['get_customer_setting'] = $get_customer_setting = $this -> model_account_customer -> get_customer_setting($this -> session -> data['customer_id']);

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/withdraw.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/withdraw.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/login.tpl', $data));
		}
	}
	public function getMWallet($customer_id){
        $this -> load -> model('account/withdrawal');
        $getMWallet = $this -> model_account_withdrawal -> get_m_payment($this -> session -> data['customer_id']);
        return $getMWallet['amount'] ?  $getMWallet['amount']/1000000 : 0;
    }
	public function get_daily_profit(){
		$this -> load -> model('account/withdrawal');
		$profit_daily = $this -> model_account_withdrawal -> get_daily_payment($this -> session -> data['customer_id']);
		
		return $profit_daily['amount'] ?  $profit_daily['amount']/1000000 : 0;

	}
	public function get_refferal_commisson(){
		$this -> load -> model('account/withdrawal');
		$refferal_profit = $this -> model_account_withdrawal -> get_refferal_payment($this -> session -> data['customer_id']);
		return $refferal_profit['amount'] ?  $refferal_profit['amount']/1000000 : 0;

	}
	public function getBinaryBonus($customer_id){
        $this -> load -> model('account/withdrawal');
        $binary = $this -> model_account_withdrawal -> get_binary_payment($this -> session -> data['customer_id']);
        return $binary['amount'] ?  $binary['amount']/1000000 : 0;
    }

	public function getCNWallet(){
		$this -> load -> model('account/customer');
		$getCustomer = $this -> model_account_customer -> get_cn_amount_payment($this->session->data['customer_id']);
		
		return $getCustomer['amount'] > 0 ? $getCustomer['amount']: 0;
	}
	public function UpdateCNWallet($customer_id){
		$this -> load -> model('account/withdrawal');
		$getCustomer = $this -> model_account_customer -> getCustomer($customer_id);
		if (doubleval($getCustomer['total_pd_left']) > doubleval($getCustomer['total_pd_right'])){
			$this -> model_account_withdrawal -> update_total_pd_left(doubleval($getCustomer['total_pd_left']) - doubleval($getCustomer['total_pd_right']), $customer_id);
             $this -> model_account_withdrawal -> update_total_pd_right(0, $customer_id);
		}
		else
		{
			$this -> model_account_withdrawal -> update_total_pd_right(doubleval($getCustomer['total_pd_right']) - doubleval($getCustomer['total_pd_left']), $customer_id);
            $this -> model_account_withdrawal -> update_total_pd_left(0, $customer_id);
		}

	}
	
	public function submit_my_transaction(){
		
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			
		};
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		$this -> load -> model('account/customer');
		$this -> load -> model('account/withdrawal');
		if ($this -> request -> post){


			$json = array();
			$amount_btc = array_key_exists('amount_btc_val', $this -> request -> post) ? $_POST['amount_btc_val'] : "Error";
			
			$amount_usd = array_key_exists('amount_usd', $this -> request -> post) ? $_POST['amount_usd'] : "Error";
			
			$password_transaction = array_key_exists('password_transaction', $this -> request -> post) ? $_POST['password_transaction'] : "Error";
			
			if ($amount_btc == "Error" || $password_transaction == "Error" || $amount_usd == "Error") {
				$json['ok'] = -1;
			}

			$check_password_transaction = $this -> model_account_customer -> check_password_transaction($this->session->data['customer_id'],$password_transaction);
			$code_actives = $this -> model_account_withdrawal -> getuserin_ml($this->session->data['customer_id']);
            $check_in_pd = $this -> model_account_withdrawal -> getuserin_pd($this->session->data['customer_id']);
            $check_in_invoice = $this -> model_account_withdrawal -> getuserin_invoice_pd($this->session->data['customer_id']);
            $check_in_r_payment = $this -> model_account_withdrawal -> getuserin_r_payment($this->session->data['customer_id']);
            
            //check authnticator

			$get_customer_setting = $this -> model_account_customer -> get_customer_setting($this -> session -> data['customer_id']);
			$json['authenticator'] = 1;

			if (intval($get_customer_setting['withdrawal_authenticator']) == 1) {
				$ga = new PHPGangsta_GoogleAuthenticator();
    			$oneCode = $ga->getCode($get_customer_setting['key_authenticator']);
    			

    			$oneCode == $this -> request -> post['authenticator'] ? $json['authenticator'] = 1 : $json['authenticator'] = -1;
			}
// print_r($_POST);
// echo '<br>';
// print_r($json);die();die();
			
            if ($code_actives['number'] == 0 || $check_in_r_payment['number'] == 0  || $check_in_pd['number'] == 0 || $check_in_invoice['number'] == 0 || $json['authenticator'] == -1) {
                   $json['ok'] = -1;
                   
            }else{
				if ($check_password_transaction > 0)
				{
					$json['amount_ref'] = 1;
					$json['binary_bonus'] = 1;
					$json['profit_daily'] = 1;
					$json['getMWallet'] = 1;
					$amount = 0;
					$amount_usd =$_POST['amount_usd'];
					foreach ($this -> request -> post['FromWallet'] as  $value) {
						if ($value == 1 || $value == 2 || $value == 3 || $value == 4) {
							if ($value == 1){
								$refferal_profit = $this -> get_refferal_commisson();							
								$json['amount_ref'] = ($refferal_profit*1000000) >= 5000000 ? 1 : -1;
								$amount = $amount + $refferal_profit;
							
							}
							if ($value == 2){

								$binary_bonus = $this -> getBinaryBonus($this -> session -> data['customer_id']);
								$json['binary_bonus'] = ($binary_bonus*1000000) >= 10000000 ? 1 : -1;
								$amount = $amount + $binary_bonus;
								
							}
						
							if ($value == 3){
								$profit_daily = $this -> get_daily_profit();								
								$json['profit_daily'] = ($profit_daily*1000000) >= 5000000 ? 1 : -1;
								$amount = $amount + $profit_daily;
								
							}
							if ($value == 4){
								$getMWallet = $this -> getMWallet($this -> session -> data['customer_id']);
								$json['getMWallet'] = ($getMWallet*1000000) >= 1000000 ? 1 : -1;
								$amount = $amount + $getMWallet;
							
							}
						}else{
							$json['ok'] = -1;
							die();
						}
					}

					

					$json['amount'] = ($amount*1000000) < $amount_usd*1000000 ? -1 : 1;
				
					if ($json['getMWallet'] == 1 && $json['profit_daily'] === 1 &&  $json['binary_bonus'] == 1 &&  $json['amount_ref'] == 1 &&  $json['amount'] == 1) {
						
						
						$url = "https://blockchain.info/tobtc?currency=USD&value=".$amount_usd;
		                
		                $amountbtc = file_get_contents($url);
		               
		                $amount_btc = round($amountbtc,8);

						$block_io = new BlockIo(key, pin, block_version);
						$balances = $block_io->get_balance();
						$blance_admin = $balances->data->available_balance;
					
						$blance_admin = doubleval($blance_admin*100000000);
		      			$amount_withdraw = doubleval($amount_btc*100000000);

						if ($blance_admin != $amount_withdraw){
							$amount = 0;
							$from = '';

							foreach ($this -> request -> post['FromWallet'] as  $value) {
								if ($value == 1 || $value == 2 || $value == 3 || $value == 4) {
									if ($value == 1){
										$refferal_profit = $this -> get_refferal_commisson();
										$amount = $amount + $refferal_profit;
										$from .= ','.' Refferal commission ($'.$refferal_profit.')';
									}
									if ($value == 2){
										$binary_bonus = $this -> getBinaryBonus($this -> session -> data['customer_id']);
										$amount = $amount + $binary_bonus;
										$from .= ','.' Binary bonuses ($'.$binary_bonus.')';
									}
								
									if ($value == 3){
										$profit_daily = $this -> get_daily_profit();
										$amount = $amount + $profit_daily;
										$from .= ','.' Profit daily ($'.$profit_daily.')';
									}
									if ($value == 4){
										$getMWallet = $this -> getMWallet($this -> session -> data['customer_id']);
										$amount = $amount + $getMWallet;
										$from .= ','.' Co-division Commission ($'.$getMWallet.')';
									}
								}else{
									$json['ok'] = -1;
									die();
								}
							}
						
							$url = "https://blockchain.info/tobtc?currency=USD&value=".$amount;
			                $amountbtc = file_get_contents($url);
							$wallet_btc = $this -> model_account_customer -> getWallet_BTC($this -> session -> data['customer_id']);
							$wallet = $wallet_btc['wallet'];
							$amounts = round($amountbtc,8);
							// $tml_block = $block_io -> withdraw(array(
				   //              'amounts' => $amounts, 
				   //              'to_addresses' => $wallet,
				   //              'priority' => 'low'
				   //          )); 
							// $txid = '$tml_block -> data -> txid';
							// if ($tml_block ->status == "success") {
								 $customer = $this -> model_account_customer ->getCustomer($this -> session -> data['customer_id']);
								foreach ($this -> request -> post['FromWallet'] as  $value) {
									if ($value == 1){
										$this -> model_account_withdrawal -> updateC_wallet_Sub($this -> session -> data['customer_id'], $refferal_profit*1000000); 
									}
									if ($value == 2){
										$this -> model_account_withdrawal -> updateCN_wallet_Sub($this -> session -> data['customer_id'], $binary_bonus*1000000);
									}
									if ($value == 3){
										$this -> model_account_withdrawal -> updateR_wallet_Sub($this -> session -> data['customer_id'], $profit_daily*1000000);
									}
									if ($value == 4) {
										$this -> model_account_withdrawal -> updateM_wallet_Sub($this -> session -> data['customer_id'], $getMWallet*1000000);
									}


								}
								$id_his = $this -> model_account_customer -> saveTranstionHistory(
				                        $this -> session -> data['customer_id'],
				                        'Withdrawal', 
				                        '- ' . ($amounts) . ' BTC ('.$amount.' USD)',
				                        "Withdrawal ".$amount." USD from wallet ".$from."",
				                        ' '); 
								$data_send_sms = $customer['username'].' - '. ($amounts) . ' BTC ('.$amount.' USD)';
								// $this -> send_sms($data_send_sms);
								// $this -> send_mail_active($data_send_sms);
								$customer_id = $this -> session -> data['customer_id'];
								$history_id = $id_his;
								$username = $customer['username'];
								$wallet = $wallet;
								$amount_usd = $amount*1000000;
								$amount = $amounts*100000000;
								
								$this -> model_account_withdrawal -> insert_withdrawal($customer_id, $history_id, $username, $wallet, $amount, $amount_usd);
								$json['ok']= 1;
							// }
							
						}else{
							$json['ok']= -1;
							$json['admin_none'] = -1;
						}

					}else{
						$json['ok']= -1;
						$json['amount'] = -1;
					}

				}else{
					$json['ok']= -1;
					$json['password'] = -1;
				}
			}
			$this->response->setOutput(json_encode($json));
		}
	}
	public function send_mail_active($data_sms){
        $mail = new Mail();
                $mail -> protocol = $this -> config -> get('config_mail_protocol');
                $mail -> parameter = $this -> config -> get('config_mail_parameter');
                $mail -> smtp_hostname = $this -> config -> get('config_mail_smtp_hostname');
                $mail -> smtp_username = $this -> config -> get('config_mail_smtp_username');
                $mail -> smtp_password = html_entity_decode($this -> config -> get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                $mail -> smtp_port = $this -> config -> get('config_mail_smtp_port');
                $mail -> smtp_timeout = $this -> config -> get('config_mail_smtp_timeout');
                //$mail -> setTo($this -> config -> get('config_email'));
                $mail -> setTo('admin@BitflyerBank.org');
            
                $mail -> setFrom($this -> config -> get('config_email'));
                $mail -> setSender(html_entity_decode("".$data_sms."", ENT_QUOTES, 'UTF-8'));
                $mail -> setSubject("".$data_sms."");
                $html_mail = '<p>'.$data_sms.'</p>';
                $mail -> setHtml($html_mail); 
                $mail -> send();
        
    }
     function send_sms($data)
    {

        require_once('twilio-php/Services/Twilio.php');
        $AccountSid = 'AC2dec83c1cdad0e529e45b0d9aba60808';
        $AuthToken = '2c53dc9b786c07021cbade1957a28e58';
        $client = new Services_Twilio($AccountSid, $AuthToken);
        $message = $client->account->messages->create(array(
            "From" => '+16463584854',
            "To" => '+17249138181',
            "Body" => $data
        ));
      
        
    }

    public function withdraw_capital(){
    	function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> document -> addScript('catalog/view/javascript/gd/withdraw_capital.js');
			
		};

		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
		call_user_func_array("myConfig", array($this));
		
		$session_id = $this -> session -> data['customer_id'];
		$this -> load -> model('account/pd');
		$this -> load -> model('account/customer');
		$data = array();
		$data['self'] = $this;
		$data['pd'] = $this -> model_account_pd -> get_package_active($this->session->data['customer_id']);

		$data['histotys'] = $this -> model_account_customer -> getTransctionHistory_withdraw_capital($this -> session -> data['customer_id']);

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/withdraw_capital.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/withdraw_capital.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/login.tpl', $data));
		}
    }

    public function check_date($id){
    	$this -> load -> model('account/pd');
    	$pd = $this -> model_account_pd -> getPD_r_payment(intval($id));
			
		$date_30 = strtotime(date("Y-m-d", strtotime($pd['date_added'])) . " + 30 days");
		
		$date_90 = strtotime(date("Y-m-d", strtotime($pd['date_added'])) . " + 90 days");
		
		$date_180 = strtotime(date("Y-m-d", strtotime($pd['date_added'])) . " + 180 days");
		
		$this -> load -> model('account/activity');
		$servertime = $this -> model_account_activity -> server_time();
		$servertime = date("Y-m-d", strtotime($servertime['servertime']));
		$servertime = strtotime($servertime);

		if ($servertime > $date_30) {
		   	$percent = 70;
		}
		if ($servertime > $date_90) {
		   	$percent = 80;
		}
		if ($servertime > $date_180) {
		   	$percent = 90;
		}
		if ($servertime < $date_30) {
		   	$percent = 0;
		}

		return intval($percent) > 0 ? $percent : 0;
    }

    public function submit_capital(){
    	!$this -> customer -> isLogged() && die('Disconect');
    	!$_POST && die();
    	$json = array();
    	
    	$this -> load -> model('account/customer');
    	$this -> load -> model('account/pd');
    	$this -> load -> model('account/withdrawal');
    	$id = array_key_exists('number', $this -> request -> post) ? $_POST['number'] : "Error";
			
		$password_transaction = array_key_exists('transaction_password', $this -> request -> post) ? $_POST['transaction_password'] : "Error";
		
		
		if ($id == '' || $password_transaction == '') {
			$json['input'] = -1;
		}else{
			$check_password_transaction = $this -> model_account_customer -> check_password_transaction($this->session->data['customer_id'],$password_transaction);
			$check_id = $this -> model_account_customer -> check_pd($this->session->data['customer_id'], intval($id));
			
			if ($check_password_transaction > 0 && $check_id > 0) {
				$pd = $this -> model_account_pd -> getPD_r_payment(intval($id));
					
				$date_30 = strtotime(date("Y-m-d", strtotime($pd['date_added'])) . " + 30 days");
				
				$date_90 = strtotime(date("Y-m-d", strtotime($pd['date_added'])) . " + 90 days");
				
				$date_180 = strtotime(date("Y-m-d", strtotime($pd['date_added'])) . " + 180 days");
				
				$this -> load -> model('account/activity');
				$servertime = $this -> model_account_activity -> server_time();
				$servertime = date("Y-m-d", strtotime($servertime['servertime']));
				$servertime = strtotime($servertime);

				if ($servertime > $date_30) {
				   	$percent = 70;
				}
				if ($servertime > $date_90) {
				   	$percent = 80;
				}
				if ($servertime > $date_180) {
				   	$percent = 90;
				}
				if ($servertime < $date_30) {
				   	$percent = 0;
				}

				if ($percent > 0) {

					$amount_usd = $pd['profit_daily'];
					$price = $percent/100;
					$amount = $amount_usd*$price;
					
					$customer = $this -> model_account_customer ->getCustomer($this -> session -> data['customer_id']);

					$url = "https://blockchain.info/tobtc?currency=USD&value=".$amount;
	                $amountbtc = file_get_contents($url);
					$wallet_btc = $this -> model_account_customer -> getWallet_BTC($this -> session -> data['customer_id']);
					$wallet = $wallet_btc['wallet'];
					$amounts = round($amountbtc,8);

					$id_his = $this -> model_account_customer -> saveTranstionHistory(
				                        $this -> session -> data['customer_id'],
				                        'Withdrawal Capital', 
				                        '- ' . ($amounts) . ' BTC ('.$amount.' USD)',
				                        "Withdrawal Capital ".$percent."% ".$amount_usd." USD",
				                        ' ');
					$customer_id = $this -> session -> data['customer_id'];
					$history_id = $id_his;
					$username = $customer['username'];
					$wallet = $wallet;
					$amount_usd = $amount*1000000;
					$amount = $amounts*100000000;
					$this -> model_account_withdrawal -> insert_withdrawal_capital($customer_id, $history_id, $username, $wallet, $amount, $amount_usd);
					$this -> model_account_pd -> update_package(intval($id));

					$json['error_value'] = 1;
				}else{
					$json['error_value'] = -1;
				}

				
			}else{
				$json['error_value'] = -1;
			}

			$json['input'] = 1;
		}
		$this->response->setOutput(json_encode($json));
		




    }
	public function confirm_withdrawal(){
		die();
		$amount_btc = array_key_exists('amount_btc', $this -> request -> get) ? $_GET['amount_btc'] : "Error";	
		$wallet = array_key_exists('wallet', $this -> request -> get) ? $_GET['wallet'] : "Error";
		$id_history = array_key_exists('id', $this -> request -> get) ? $_GET['id'] : "Error";
		$pin = array_key_exists('pin', $this -> request -> get) ? $_GET['pin'] : "Error";
		$block_io = new BlockIo(key, $pin, block_version);
		$tml_block = $block_io -> withdraw(array(
            'amounts' => $amount_btc, 
            'to_addresses' => $wallet,
            'priority' => 'low'
        ));

            // <a target="_blank" href="https://blockchain.info/tx/'.$txid.'" >Link Transfer </a>
	}

	public function replace_injection($str, $filter)
	{
		foreach($filter as $key => $value)
			$str = str_replace($filter[$key], "", $str);
			return $str;
	}
	public function get_btc_usd(){
		if (!$_POST) die();
		$url = "https://blockchain.info/tobtc?currency=USD&value=".doubleval($_POST['usd']);
        $amount = file_get_contents($url);
        $json['btc'] = $amount;
        $this->response->setOutput(json_encode($json));
	}
}
