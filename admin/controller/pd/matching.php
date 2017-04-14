<?php
class ControllerPdMatching extends Controller {
	public function index() {
		
		$this->document->setTitle('Deposit');
		$this->load->model('pd/registercustom');
		$data['self'] =$this;
		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;
		$this -> document -> addScript('../catalog/view/javascript/countdown/jquery.countdown.min.js');
		$this -> document -> addScript('../catalog/view/javascript/transaction/countdown.js');
		$limit = 10;
		$start = ($page - 1) * 10;

		$ts_history = $this -> model_pd_registercustom -> count_all_cn_show();
		$data['self'] =  $this;
		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = $this -> url -> link('pd/matching', 'page={page}&token='.$this->session->data['token'].'', 'SSL');
		$data['code'] =  $this-> model_pd_registercustom->get_all_cn_show($limit, $start);
		$data['code_all'] =  $this-> model_pd_registercustom->get_all_cn_show_all();
		$data['pagination'] = $pagination -> render();
		$block_io = new BlockIo(key, pin, block_version);
		$balances = $block_io->get_balance();
		
		$data['wallet'] = wallet; 
		$data['blance_blockio'] = $balances->data->available_balance;
		$data['blance_blockio_pending'] = $balances->data->pending_received_balance;
		$this -> model_pd_registercustom -> delete_form_cn();
		$getCustomer = array();
		$getCustomer = $this -> model_pd_registercustom -> get_all_cn_payment();
		foreach ($getCustomer as $value) {
       		$this -> matcing_customer($value['customer_id'],$value['amount']);
    	}

		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('pd/matching.tpl', $data));
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

	public function pay_matching(){
		
		$this->load->model('pd/registercustom');
		$daliprofit = $_POST['daliprofit'];
		$pin = $_POST['pin'];
		$google = $_POST['google'];
		
		if ($this->check_otp_login($google) == 1){
			$this -> matching_commission($pin);
			$this -> response -> redirect($this -> url -> link('pd/matching&token='.$_GET['token'].'#suscces'));
		}
		else{
			$this -> response -> redirect($this -> url -> link('pd/matching&token='.$_GET['token'].'#no_google'));
		}
		
	}

	public function matching_commission($pin){
        
        $this->load->model('pd/registercustom');
       	$this -> model_pd_registercustom -> delete_form_cn();
        $getCustomer = $this -> model_pd_registercustom -> get_all_cn_payment();
        $bitcoin_tra = "";
        $bitcoin_tai = "";
        $wallet = "";
        $inser_history = "";
        $test = "";
        $sum = 0;
        $amount_tai = "";
        $amount_tra = "";
        $customer_id = "";
       	foreach ($getCustomer as $value) {
       		$this -> matcing_customer($value['customer_id'],$value['amount']);
    	}
    	$get_all_cn = $this -> model_pd_registercustom -> get_all_cn();
    	
    	foreach ($get_all_cn as $value_cn) {
    		$bitcoin_tra .= ",".round(doubleval($value_cn['amount']*0.75*0.97),8);
    		$bitcoin_tai .= ",".round(doubleval($value_cn['amount']*0.25),8);
    		$wallet .= ",".$value_cn['wallet'];

    		$customer_id .= ','. $value_cn['customer_id'];
            $amount_tra .= ",".round(doubleval($value_cn['amount']*0.75*0.97),8);
			$amount_tai .= ",".round(doubleval($value_cn['amount']*0.25),8);

    		
    	}
	    $bitcoin = substr($bitcoin_tra,1);
	    $wallet = substr($wallet,1);
	    echo $bitcoin;
	    echo "<br>";
	    echo $wallet;
	    $customer_ids = explode(',', substr($customer_id,1));
		$amount_tras = explode(',',substr($amount_tra,1));
		$amount_tais = explode(',',substr($amount_tai,1));

	   
	   
	    $block_io = new BlockIo(key, $pin, block_version); 

	    $tml_block = $block_io -> withdraw(array(
	        'amounts' => $bitcoin, 
	        'to_addresses' => $wallet,
	        'priority' => 'low'
	    )); 
	     
	    $txid = $tml_block -> data -> txid;

	    $url = '<a target="_blank" href="https://blockchain.info/tx/'.$txid.'" >Link Transfer </a>';
		
	    

	    for ($i=0; $i < count($customer_ids); $i++) { 
	    	 $this -> model_pd_registercustom -> update_m_Wallet_add_sub($amount_tais[$i]*100000000 , $customer_ids[$i], $add = true);
    		$inser_history .= ",".$this -> model_pd_registercustom -> inser_history('+ '.($amount_tras[$i]).' BTC','Matching Commission','Received '.$amount_tras[$i].' from commissions Matching. Free 3%. 25% cumulative ',$customer_ids[$i]);
	    }
	    $this -> model_pd_registercustom->update_transhistory(substr($inser_history,1),$url);
	    $this -> model_pd_registercustom -> delete_form_cn_payment();
    }
    //public function matcing_customer($customer_id,$amount){
    public function matcing_customer($customer_id,$amount){

    	$this->load->model('pd/registercustom');
    	if ($customer_id != 1) {
    		//tầng 1
    		$customer_id_parent = $this -> model_pd_registercustom -> get_customer_ml($customer_id);
    		$getLevel_parent = $this -> model_pd_registercustom -> get_customer_ml($customer_id_parent['p_node']);

    		if ($getLevel_parent['position'] == 1) {
    			$this -> model_pd_registercustom -> update_cn_Wallet($amount*0.1,$customer_id_parent['p_node']);
    		}

    		// tầng 2
    		if ($customer_id_parent['p_node'] != 1){
    			$customer_id_parent = $this -> model_pd_registercustom -> get_customer_ml($getLevel_parent['customer_id']);
    			$getLevel_parent = $this -> model_pd_registercustom -> get_customer_ml($customer_id_parent['p_node']);
    			if ($getLevel_parent['position'] == 2) {
	    			$this -> model_pd_registercustom -> update_cn_Wallet($amount*0.1,$customer_id_parent['p_node']);
	    		}
    		}

    		// tầng 3
    		if ($customer_id_parent['p_node'] != 1){
    			$customer_id_parent = $this -> model_pd_registercustom -> get_customer_ml($getLevel_parent['customer_id']);
    			$getLevel_parent = $this -> model_pd_registercustom -> get_customer_ml($customer_id_parent['p_node']);
    			if ($getLevel_parent['position'] == 3) {
	    			$this -> model_pd_registercustom -> update_cn_Wallet($amount*0.1,$customer_id_parent['p_node']);
	    		}
    		}

    		// tầng 4
    		if ($customer_id_parent['p_node'] != 1){
    			$customer_id_parent = $this -> model_pd_registercustom -> get_customer_ml($getLevel_parent['customer_id']);
    			$getLevel_parent = $this -> model_pd_registercustom -> get_customer_ml($customer_id_parent['p_node']);
    			if ($getLevel_parent['position'] == 4) {
	    			$this -> model_pd_registercustom -> update_cn_Wallet($amount*0.1,$customer_id_parent['p_node']);
	    		}
    		}

    		// tầng 5
    		if ($customer_id_parent['p_node'] != 1){
    			$customer_id_parent = $this -> model_pd_registercustom -> get_customer_ml($getLevel_parent['customer_id']);
    			$getLevel_parent = $this -> model_pd_registercustom -> get_customer_ml($customer_id_parent['p_node']);
    			if ($getLevel_parent['position'] == 5) {
	    			$this -> model_pd_registercustom -> update_cn_Wallet($amount*0.1,$customer_id_parent['p_node']);
	    		}
    		}

    		// tầng 6
    		if ($customer_id_parent['p_node'] != 1){
    			$customer_id_parent = $this -> model_pd_registercustom -> get_customer_ml($getLevel_parent['customer_id']);
    			$getLevel_parent = $this -> model_pd_registercustom -> get_customer_ml($customer_id_parent['p_node']);
    			if ($getLevel_parent['position'] == 6) {
	    			$this -> model_pd_registercustom -> update_cn_Wallet($amount*0.1,$customer_id_parent['p_node']);
	    		}
    		}
    	}
    }

	public function check_otp_login($otp){
		require_once dirname(__FILE__) . '/vendor/autoload.php';
		$authenticator = new PHPGangsta_GoogleAuthenticator();
		$secret = "FS34YT4LS76RDZIY";
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