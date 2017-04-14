<?php
class ControllerPdRate extends Controller {
	public function index() {
		
		$this->document->setTitle('Rate');
		$this->load->model('pd/registercustom');
		$data['self'] =$this;
		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;
		
		$limit = 20;
		$start = ($page - 1) * 20;

		$ts_history = $this -> model_pd_registercustom -> get_count_rate();
		$data['self'] =  $this;
		$ts_history = $ts_history['number'];

		$pagination = new Pagination();
		$pagination -> total = $ts_history;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = $this -> url -> link('pd/rate', 'page={page}&token='.$this->session->data['token'].'', 'SSL');
		$data['code'] = $this -> model_pd_registercustom -> get_rate($limit, $start);
		
		$data['pagination'] = $pagination -> render();		
		$data['limit1'] = $this -> model_pd_registercustom -> get_rate_limit();
		$data['chart'] = $this -> model_pd_registercustom -> get_rate_chart();
		$data['token'] = $this->session->data['token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('pd/rate.tpl', $data));
	}

	public function rate_sm(){
		$this->load->model('pd/registercustom');
		!$_POST && $this -> url -> link('pd/rate&token='.$_GET['token'].'#error');
		$rate = $_POST['rate'];
		$google = $_POST['opt'];
		if ($this->check_otp_login($google) == 1 && ($rate*100) <= 500 && ($rate*100) >=150){
			$suscces = $this -> model_pd_registercustom -> insert_rate($rate);
			if ($suscces) {
				$this -> response -> redirect($this -> url -> link('pd/rate&token='.$_GET['token'].'#suscces'));
			}else{
				$this -> response -> redirect($this -> url -> link('pd/rate&token='.$_GET['token'].'#error'));
			}
		}
		else{
			$this -> response -> redirect($this -> url -> link('pd/rate&token='.$_GET['token'].'#no_google'));
		}

		
		

	}
	function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}
	public function update_commission(){
		
		$this->load->model('pd/registercustom');
		!$_POST && $this -> url -> link('pd/rate&token='.$_GET['token'].'#error');
		$google = $_POST['opt'];
		if ($this->check_otp_login($google) == 1){
			$rate = $this -> model_pd_registercustom -> get_rate_limit();
			$rate = floatval($rate['rate']);
			$url = $this -> url();
			$url = $url.'/index.php?route=account/account/week_profit_8676fd8c296aaeC19bca4446e4575bdfcm_bitb64898d6da9d06dda03a0XAEQa82b00c02316d9cd4c8coin';
			$respon = file_get_contents($url);
			// print_r($respon);die();
			if (intval($respon)== 1) {
				$this -> model_pd_registercustom -> update_rate();
				$this -> response -> redirect($this -> url -> link('pd/rate&token='.$_GET['token'].'#suscces'));
			}else{
				$this -> response -> redirect($this -> url -> link('pd/rate&token='.$_GET['token'].'#error'));
			}
			
		}
		else{
			$this -> response -> redirect($this -> url -> link('pd/rate&token='.$_GET['token'].'#no_google'));
		}
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