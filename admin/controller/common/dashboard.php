<?php
class ControllerCommonDashboard extends Controller {
	public function index() {
		$this->load->language('common/dashboard');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_sale'] = $this->language->get('text_sale');
		$data['text_map'] = $this->language->get('text_map');
		$data['text_activity'] = $this->language->get('text_activity');
		$data['text_recent'] = $this->language->get('text_recent');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		// Check install directory exists
		if (is_dir(dirname(DIR_APPLICATION) . '/install')) {
			$data['error_install'] = $this->language->get('error_install');
		} else {
			$data['error_install'] = '';
		}

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['banner'] = $this->load->controller('dashboard/banner');
		$data['customer'] = $this->load->controller('dashboard/customer');
		$data['customer_account'] = $this->load->controller('dashboard/customer_account');
		$data['online'] = $this->load->controller('dashboard/online');
		$data['map'] = $this->load->controller('dashboard/map');
		$data['chart'] = $this->load->controller('dashboard/chart');
		$data['activity'] = $this->load->controller('dashboard/activity');
		$data['recent'] = $this->load->controller('dashboard/recent');
		$data['footer'] = $this->load->controller('common/footer');
		$this->load->model('report/activity');
		
		$data['total_withdrawal'] = $this->model_report_activity->get_total_invest_withdrawal();
		$data['totalCustomers'] = $this->model_report_activity->getTotalCustomers();
		$data['totalWatting'] = $this->model_report_activity->getTotalProvide(0);
		$data['totalMarched'] = $this->model_report_activity->getTotalProvide(1);
		$data['totalFinish'] = $this->model_report_activity->getTotalProvide(2);
		$data['totalCTP'] = $this->model_report_activity->getAllProfitByType(2);
		
		$data['total_GD_Current_Finish'] = $this->model_report_activity->get_total_gd_current_date(2);
		$data['total_GD_Current_March'] = $this->model_report_activity->get_total_gd_current_date(1);
		$data['total_PD_Current_Finish'] = $this->model_report_activity->get_total_pd_current_date(2);
		$data['total_PD_Current_March'] = $this->model_report_activity->get_total_pd_current_date(1);
		
		
		$data['totalHP'] = $this->model_report_activity->getAllProfitByType(1);
		
		$data['totalNewLast'] = $this->model_report_activity->getTotalCustomersNewLast();
		
		$data['totalNew'] = $this->model_report_activity->getTotalCustomersNew();
		
		$data['totalCusOff'] = $this->model_report_activity->getTotalCustomersOff();
		
		$data['onlineToday'] = $this->model_report_activity->onlineToday();
		
		$data['onlineYesterday'] = $this->model_report_activity->onlineYesterday();
		
		$data['linkdate'] = HTTPS_SERVER.'index.php?route=common/dashboard/deposit&token='.$this->session->data['token'];
		$data['linkdatewithdrawal'] = HTTPS_SERVER.'index.php?route=common/dashboard/withdrawal&token='.$this->session->data['token'];
		$data['deposit'] = $this -> model_report_activity -> GetTotalDeposit();
		$data['withdrawal'] = $this -> model_report_activity -> GetTotalWithdrawal();
		$data['self'] = $this;
		$this -> loadxml();
		// Run currency update
		if ($this->config->get('config_currency_auto')) {
			$this->load->model('localisation/currency');

			$this->model_localisation_currency->refresh();
		}

		$this->response->setOutput($this->load->view('common/dashboard.tpl', $data));
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

	public function deposit($date = false){
		
		$this->load->model('report/activity');
		// $date = '14-04-2017';
		// $date =  date("Y-m-d", strtotime($date) );
		if ($this -> request -> server['REQUEST_METHOD'] === 'POST') {
 			$json=array();
 			$date =  date("Y-m-d", strtotime($_POST['date']));
 			$total = $this -> model_report_activity -> get_total_pd_deposit($date);
 			$json['total'] = $total > 0 ? $total : '0';
 			$this->response->setOutput(json_encode($json));
		}else{

			$total = $this -> model_report_activity -> get_total_pd_deposit($date);

			return $total > 0 ? $total : 0;
		}
				
		
	}
	public function withdrawal($date = false){
		
		$this->load->model('report/activity');
		// $date = '14-04-2017';
		// $date =  date("Y-m-d", strtotime($date) );
		if ($this -> request -> server['REQUEST_METHOD'] === 'POST') {
 			$json=array();
 			$date =  date("Y-m-d", strtotime($_POST['date']));
 			$total = $this -> model_report_activity -> get_total_pd_withdrawal($date);
 			$json['total'] = $total > 0 ? $total : '0';
 			$this->response->setOutput(json_encode($json));
		}else{

			$total = $this -> model_report_activity -> get_total_pd_withdrawal($date);

			return $total > 0 ? $total : 0;
		}
				
		
	}
}