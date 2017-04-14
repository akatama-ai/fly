<?php
class ControllerAccountLock extends Controller {
	public function index() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> load -> model('account/customer');
			
		};
		
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$data['base'] = $server;
		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect(HTTPS_SERVER.'signin.html');
		call_user_func_array("myConfig", array($this));

		if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }
		$data['base'] = $server;
        $data['self'] = $this;
        
        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
        	
        if ($this->request->server['REQUEST_METHOD'] == 'POST'){
        	$get_customer_setting = $this -> model_account_customer -> get_customer_setting($this -> session -> data['customer_id']);
        	
        	$ga = new PHPGangsta_GoogleAuthenticator();
			
			$secret = $get_customer_setting['key_authenticator'];
			
			$oneCode = $ga->getCode($secret);

			if ($this -> request -> post['authenticator'] == $oneCode)
			{
				$this -> session -> data['authenticator'] = $oneCode;
				$this->response->redirect(HTTPS_SERVER . 'home.html');
			}
			else
			{
				$data['error_warning'] = "The two-factor authentication code you specified is incorrect. Please check the clock on your authenticator device to verify that it is in sync";
			}
			
        }

       if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/lock.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/lock.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/account/lock.tpl', $data));
        }
	}
	public function cancel(){
		unset($this -> session -> data['authenticator']);
		unset($this -> session -> data['customer_id']);
		$this->response->redirect(HTTPS_SERVER . 'login.html');
	}
}