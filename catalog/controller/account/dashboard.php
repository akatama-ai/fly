<?php
class ControllerAccountDashboard extends Controller {

	public function index() {
		// $_SESSION['customer_id'] = 50;
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			// $self-> document-> addStyle('');
		
			$self -> load -> model('simple_blog/article');
		};

		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect(HTTPS_SERVER . 'login.html');
		call_user_func_array("myConfig", array($this));
		
		$session_id = $this -> session -> data['customer_id'];

		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($session_id);
		$data['language']= $getLanguage;
		$language = new Language($getLanguage);
		$language -> load('account/dashboard');
		$data['lang'] = $language -> data;
		$checkM_Wallet = $this -> model_account_customer -> checkM_Wallet($session_id);
		if(intval($checkM_Wallet['number'])  === 0){
			if(!$this -> model_account_customer -> insert_M_Wallet($session_id)){
				die();
			}
		}
		$time = $this -> model_account_customer -> get_M_Wallet($session_id);
		
		$data['date'] = $time['date'];
		//method to call function

		$data['limit1'] = $this -> model_account_customer -> get_rate_limit();
		$data['chart'] = $this -> model_account_customer -> get_rate_chart();
		//insert inot payment_block_chain if not exit

		

		//data render website
		//start load country model

		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		$data['base'] = $server;
		$data['self'] = $this;
		$data['regulations'] = $this -> config -> get('config_regulations');
		$data['regulations1'] = $this -> config -> get('config_regulations_1');
		$data['regulations2'] = $this -> config -> get('config_regulations_2');
		$data['regulations3'] = $this -> config -> get('config_regulations_3');
		// getArticles
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;      

		$limit = 5;
		$start = ($page - 1) * 5;
		$article_total = $this->model_simple_blog_article->getTotalArticle();

		$pagination = new Pagination();
		$pagination->total = $article_total;
		$pagination->page = $page;
		$pagination->limit = $limit; 
		$pagination->num_links = 5;
		//$pagination->text = 'text';
		$pagination->url = $this->url->link('account/dashboard', 'page={page}#anouncenment', 'SSL');
		if ($getLanguage == 'vietnamese') {
			$Language_id = 2;
		}else{
			$Language_id = 1;
		}
		$data['article_limit'] = $this -> model_simple_blog_article -> getArticleLimit($limit,$start, $Language_id);
		
		$data['pagination'] = $pagination->render();

		$data['pd_march'] = $this->model_account_customer->getPDMarch($this->session->data['customer_id']);
		///All GD
		$pages = isset($this -> request -> get['pages']) ? $this -> request -> get['pages'] : 1;

		//$data['pds'] = $this -> model_account_customer -> getAllPD($limit, $start);
		$checkC_Wallet = $this -> model_account_customer -> checkR_Wallet($this->session->data['customer_id']);
			if(intval($checkC_Wallet['number'])  === 0){
				if(!$this -> model_account_customer -> insertR_WalletR(0, $this->session->data['customer_id'])){
					die();
				}
			}
		$checkFloor_Wallet = $this -> model_account_customer -> checkFloor_Wallet($this->session->data['customer_id']);
			if(intval($checkFloor_Wallet['number'])  === 0){
				if(!$this -> model_account_customer -> insertFloor_Wallet(0, $this->session->data['customer_id'])){
					die();
				}
			}

		//customer js
		$data['countPD'] = $this -> countPD($session_id);
		
		$data['getR_Wallet_payment'] = $this -> get_daily_profit($session_id);
	
		$data['getCWallet'] = $this -> get_refferal_commisson($session_id);

		$data['getCNWallet'] = $this -> getBinaryBonus($session_id);
		$data['getMWallet'] = $this -> getMWallet($session_id);
		$customer = $this -> model_account_customer ->  getCustomer($session_id);

		$Hash = $customer['customer_code'];	
		
		$data['customer_code'] = $Hash;

		$data['total_left']= number_format($customer['total_left']);
		$data['total_right'] = number_format($customer['total_right']);
		$data['total_binary_left'] = $this -> total_binary_left($session_id);
		$data['total_binary_right'] = $this -> total_binary_right($session_id);
		$data['total_pd_left'] = $this -> total_pd_left($session_id);
		$data['total_pd_right'] = $this -> total_pd_right($session_id);
		$data['get_m_walleet'] = $this -> model_account_customer -> get_R_Wallet($this -> session -> data['customer_id']);
		$data['floor_commission'] = $this -> get_floor_wallet($session_id);
		$data['login_detail'] = $this->get_login($session_id);
		$this -> Insert_authenticator($session_id);
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/dashboard.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/dashboard.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/login.tpl', $data));
		}
	}
	public function get_floor_wallet($customer_id){
		$this -> load -> model('account/withdrawal');
		$getFloorWallet = $this -> model_account_withdrawal -> getFloorWallet($customer_id);
		
		return $getFloorWallet['amount'] ?  $getFloorWallet['amount']/1000000 : 0;

	}
	public function getMWallet($customer_id){
        $this -> load -> model('account/withdrawal');
        $getMWallet = $this -> model_account_withdrawal -> get_m_payment($customer_id);
        return $getMWallet['amount'] ?  $getMWallet['amount']/1000000 : 0;
    }
	public function get_daily_profit($customer_id){
		$this -> load -> model('account/withdrawal');
		$profit_daily = $this -> model_account_withdrawal -> get_daily_payment($customer_id);
		
		return $profit_daily['amount'] ?  $profit_daily['amount']/1000000 : 0;

	}
	public function get_refferal_commisson($customer_id){
		$this -> load -> model('account/withdrawal');
		$refferal_profit = $this -> model_account_withdrawal -> get_refferal_payment($customer_id);
		return $refferal_profit['amount'] ?  $refferal_profit['amount']/1000000 : 0;

	}
	public function getBinaryBonus($customer_id){
        $this -> load -> model('account/withdrawal');
        $binary = $this -> model_account_withdrawal -> get_binary_payment($customer_id);
        return $binary['amount'] ?  $binary['amount']/1000000 : 0;
    }
	public function Insert_authenticator($cus_id){
    	$ga = new PHPGangsta_GoogleAuthenticator();
		$key_authenticator = $ga->createSecret();

		$this -> load -> model('account/customer');
		$check_Setting = $this -> model_account_customer -> check_Setting($cus_id);
		if(intval($check_Setting['number'])  === 0){
			if(!$this -> model_account_customer -> insert_Setting($cus_id, $key_authenticator)){
				die();
			}
		}

    }
	public function get_login($customer_id){
		$this->load->model('account/activity');
		$login = $this -> model_account_activity -> get_login($customer_id);
		return $login;
	}
	public function RequestPDFinish(){
		$this->load->model('account/customer');
		$gds = $this -> model_account_customer -> getAllPD(7, 0, 2);
		$html = '';
		
		foreach ($gds as $key => $value) {
			$html .= '<p class="list-group-item"><span class="badge">'.($value['filled']/100000000).' BTC</span>'.$value['username'].'</p>';
		}
		

		$json['html'] = $html;
		$html = null;
		$this -> response -> setOutput(json_encode($json));
	}
	public function viewBlogs(){
		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> document -> addScript('catalog/view/javascript/dashboard/dashboard.js');
			$self -> load -> model('simple_blog/article');
		};
		

		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$data['language']= $getLanguage;
		$language = new Language($getLanguage);
		$language -> load('account/dashboard');
		
		$data['lang'] = $language -> data;

		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		//data render website
		//start load country model

		if ($this -> request -> server['HTTPS']) {
			$server = $this -> config -> get('config_ssl');
		} else {
			$server = $this -> config -> get('config_url');
		}

		$data['base'] = $server;
		$data['self'] = $this;
			//method to call function

			!$this -> request -> get['token']  && $this -> response -> redirect($this -> url -> link('account/dashboard', '', 'SSL'));
			$id_ = $this -> request -> get['token'];

if ($getLanguage == 'vietnamese') {
			$Language_id = 2;
		}else{
			$Language_id = 1;
		}
			$this->load->model('simple_blog/article');
			$data['detail_articles'] = $this->model_simple_blog_article->getArticlesBlogs($id_, $Language_id);        	
		
			if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/showblog.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/showblog.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/showblog.tpl', $data));
		}
		}

	public function changeLange(){
		if ($this -> customer -> isLogged() && $this -> session -> data['customer_id']) {
			$this -> load -> model('account/customer');
			$json['success'] = $this -> model_account_customer -> updateLanguage( $this -> session -> data['customer_id'], $this -> request -> get['lang'] ) ;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	/*
	 *
	 * ajax count total tree member
	 */
	public function totaltree() {
		if ($this -> customer -> isLogged() && $this -> session -> data['customer_id']) {
			$this -> load -> model('account/customer');
			$json['success'] = intval($this -> model_account_customer -> getCountTreeCustom($this -> session -> data['customer_id']));
			$this -> response -> setOutput(json_encode($json));
		}
	}
	public function total_binary_left($customer_id){
		$this -> load -> model('account/customer');

		$count = $this -> model_account_customer ->  getCustomer_ML($customer_id);
		if(intval($count['left']) === 0){
			return 0;
		}else{
			$count = $this -> model_account_customer -> getCountBinaryTreeCustom($count['left']);
			$count = (intval($count) + 1);
			return $count;
		}

		

	}

	public function total_binary_right($customer_id){
		$this -> load -> model('account/customer');

		$count = $this -> model_account_customer ->  getCustomer_ML($customer_id);
		if(intval($count['right']) === 0){
			return 0;
		}else{
			$count = $this -> model_account_customer -> getCountBinaryTreeCustom($count['right']);
			$count = (intval($count) + 1);
			return  $count;
		}


	}


	public function total_pd_left($customer_id){
		$this -> load -> model('account/customer');
		$count = $this -> model_account_customer ->  getCustomer($customer_id);
		if(intval($count['total_pd_left']) === 0){
			return 0;
		}else{
			return ($count['total_pd_left']);
		}

	}
	public function total_pd_right(){
		$this -> load -> model('account/customer');
		$count = $this -> model_account_customer ->  getCustomer($this -> session -> data['customer_id']);

		if(intval($count['total_pd_right']) === 0){
			return 0;
		}else{
			return ($count['total_pd_right']);

		}
		$this -> response -> setOutput(json_encode($json));
	}
	public function totalpin() {
		if ($this -> customer -> isLogged() && $this -> session -> data['customer_id']) {
			$this -> load -> model('account/customer');
			$pin = $this -> model_account_customer -> getCustomer($this -> session -> data['customer_id']);
			$pin = $pin['ping'];
			$json['success'] = intval($pin);
			$pin = null;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function analytics() {

		if ($this -> customer -> isLogged() && $this -> session -> data['customer_id']) {
			$this -> load -> model('account/customer');
			$json['success'] = intval($this -> model_account_customer -> getCountLevelCustom($this -> session -> data['customer_id'], $this -> request -> get['level']));
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function countPD($customer_id){
		
		$this -> load -> model('account/customer');

		$total = $this -> model_account_customer -> getTotalPD($customer_id);
		$total = number_format($total['number']);
		return ($total);
		
	}


	public function countGD(){
		if ($this -> customer -> isLogged() && $this -> session -> data['customer_id']) {
			$this -> load -> model('account/customer');
			$total = $this -> model_account_customer -> getTotalGD($this -> session -> data['customer_id']);
			$total = $total['number'];
			$json['success'] = intval($total);
			$total = null;
			$this -> response -> setOutput(json_encode($json));
		}
	}

	public function getR_Wallet_payment($customer_id){

		$this -> load -> model('account/customer');
	

		$total = $this -> model_account_customer -> getR_Wallet_payment($customer_id);
	
		//print_r($total); die;
		$total = count($total) > 0 ? $total['amount'] : 0;
		$json['success'] = round($total,2);
		return ($json['success']);
		

	}

	public function getCWallet($customer_id){

		$this -> load -> model('account/customer');

		$checkC_Wallet = $this -> model_account_customer -> checkC_Wallet($customer_id);


		if(intval($checkC_Wallet['number'])  === 0){
			if(!$this -> model_account_customer -> insertC_Wallet($customer_id)){
				die();
			}
		}
		$total = $this -> model_account_customer -> getC_Wallet($customer_id);

		$total = count($total) > 0 ? $total['amount'] : 0;
		$total = $total/1000000;

		$json['success'] = $total;
		$total = null;
		return $json['success'];
		
		
	}
	public function getCNWallet($customer_id){
		$this -> load -> model('account/customer');

		$getCustomer = $this -> model_account_customer -> getCustomer($this->session->data['customer_id']);

		// $getTotalPD = $this -> model_account_customer ->getTotalPD($this->session->data['customer_id']);
		
		if (doubleval($getCustomer['total_pd_left']) > doubleval($getCustomer['total_pd_right'])){
			 $balanced = doubleval($getCustomer['total_pd_right']);
		}
		else
		{
			$balanced = doubleval($getCustomer['total_pd_left']);
		}
		
	
		
		$precent = 10;
		
		$amount = ($balanced*$precent)/100;

		// print_r($amount);die();
		
		$json['success'] = number_format($amount);
		return $json['success'];
	}


	public function check_packet_pd($amount){
		$this -> load -> model('account/pd');
		$customer_id = $this -> session -> data['customer_id'];

		return $this -> model_account_pd -> check_packet_pd($customer_id, $amount);
	}

	public function packet_invoide(){
		$this -> load -> model('account/pd');
		$package = $this -> model_account_pd -> get_invoide($this -> request -> get ['invest']);
		$json['input_address'] = $package['input_address'];



		$json['amount'] =  $package['amount_inv'];
		$json['pin'] = $package['amount_inv'] - $package['pd_amount'];
		$json['package'] = $package['pd_amount'];
		$this->response->setOutput(json_encode($json));
	}

}
