<?php
class ControllerPdInvestment extends Controller {
	public function index() {
		
		$this->document->setTitle('Deposit');
		$this->load->model('pd/registercustom');
		$data['self'] =$this;
		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;
		// $this -> document -> addScript('../catalog/view/javascript/countdown/jquery.countdown.min.js');
		// $this -> document -> addScript('../catalog/view/javascript/transaction/countdown.js');
		$limit = 10;
		$start = ($page - 1) * 10;

		$ts_history = $this -> model_pd_registercustom -> get_count_investment();
		$data['self'] =  $this;
		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = $this -> url -> link('pd/investment', 'page={page}&token='.$this->session->data['token'].'', 'SSL');
		$data['code'] =  $this-> model_pd_registercustom->get_all_invesment($limit, $start);
		
		$data['pagination'] = $pagination -> render();
		$data['linkdate'] = HTTPS_SERVER.'index.php?route=pd/investment/totalpd&token='.$this->session->data['token'];
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');



		$this->response->setOutput($this->load->view('pd/investment.tpl', $data));
	}
	
	public function totalpd($date = false){
		
		$this->load->model('pd/registercustom');
		// $date = '14-04-2017';
		// $date =  date("Y-m-d", strtotime($date) );
		if ($this -> request -> server['REQUEST_METHOD'] === 'POST') {
 			$json=array();
 			$date =  date("Y-m-d", strtotime($_POST['date']));
 			$total = $this -> model_pd_registercustom -> get_total_pd($date);
 			$json['total'] = $total > 0 ? $total : '0';
 			$this->response->setOutput(json_encode($json));
		}else{

			$total = $this -> model_pd_registercustom -> get_total_pd($date);

			return $total > 0 ? $total : 0;
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
}