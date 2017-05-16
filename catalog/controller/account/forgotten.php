<?php
class ControllerAccountForgotten extends Controller {
	private $error = array();

	public function index() {
		

		if ($this->customer->isLogged()) {
			$this->response->redirect(HTTPS_SERVER . 'login.html');
		}

		$this -> document -> addScript('catalog/view/javascript/forgot/forgot.js');
		$this -> document -> addScript('catalog/view/theme/default/assets/validate/jquery.validate.min.js');
		$this -> document -> addScript('catalog/view/theme/default/assets/validate/login_validation.js');
		$this->load->language('account/forgotten');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/customer');


		$getLanguage = 'english';

		$language = new Language($getLanguage);
		$language -> load('account/forgotten');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;


		if (($this->request->server['REQUEST_METHOD'] === 'POST') && $this->validate()) {

			$this->load->language('mail/forgotten');
			$filter_wave2 = Array('"', "'");
			foreach($_POST as $key => $value)
				$_POST[$key] = $this -> replace_injection($_POST[$key], $filter_wave2);
			foreach($_GET as $key => $value)
				$_GET[$key] = $this -> replace_injection($_GET[$key], $filter_wave2);

			$customer_info = $this->model_account_customer->getCustomerByUsername($_POST['email']);
			

			$password = substr(sha1(uniqid(mt_rand(), true)), 0, 30);

			$this->model_account_customer->editPasswordCustomForEmail($customer_info, $password);

			$subject = sprintf('BitflyerBank LTD - New transaction Password', html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

			$message  = sprintf('A new password was requested from BitflyerBank LTD', html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
			$message .= 'Your new password is:' . "\n\n";
			$message .= $password;



			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($customer_info['email']);
			$mail->setFrom($this->config->get('config_email'));

			$mail->setSender('BitflyerBank LTD');
			$mail->setSubject('BitflyerBank LTD - New Password');
			// $mail->setText($message);
			// $mail->send();
			$html_mail = '<div style="max-width: 600px; width: 100%; margin: 0 auto;">
				   <table width="100%" border="0" cellspacing="0" cellpadding="0">
				      <tr>
				         <td align="center" valign="top" bgcolor="" style="background-color:#;">
				            <br>
				            <br>
				            <table width="100%" border="0" cellspacing="0" cellpadding="0">
				               <tr>
				                  <td align="left" valign="top" bgcolor="#e94957" style="height: 177px; text-align: center;padding-top: 50px;"><img src="'.HTTPS_SERVER.'catalog/view/theme/default/img/logo.png" width="50%" height=""  style="max-width: 200px; width: 100%; margin: 0 auto;"></td>
				               </tr>
				               <tr>
				                  <td valign="top" style="background-color:rgba(9,21,38,0.9); font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000; padding:15px 15px 10px 15px;">
				                     <div style="font-size:21px; color:#e94957;"><b>Hello, '.$_POST['email'].'</b></div>
				                     <br>
				                     <div style="font-size:100%; color:#e94957;"><b>Dear '.$_POST['email'].',</b></div>
				                  
				                     <div  style="font-size:14px; color:#fff; line-height: 1.5">
				                        <br>
				                        <span  style="font-size:14px; color:#fff;"> Your new password is: </span>
				                        <br>
				                          <p style="font-size:14px;color: #e94957;"> <b>'.$password.'</b></p>
				                         
				                     </div>
				                     <div style="font-size: 14px; color: #fff; line-height: 1.6"><br>
				                      
				                     
				                        
				                        Best regards BitflyerBank team support <br>
				                        <a href="'.HTTPS_SERVER.'" target="_blank" style="color:#fff; text-decoration:none;"> https://bitflyerb.com</a>
				                     </div>
				                  </td>
				               </tr>
				            </table>
				            <br>
				            <br>
				         </td>
				      </tr>
				   </table>
				</div>';
				$mail -> setHtml($html_mail); 
				$mail -> send();

			$this->session->data['success'] = $this->language->get('text_success');

			// Add to activity log
			

			if ($customer_info) {
				$this->load->model('account/activity');

				$activity_data = array(
					'customer_id' => $customer_info['customer_id'],
					'name'        => $customer_info['firstname'] . ' ' . $customer_info['lastname']
				);

				$this->model_account_activity->addActivity('forgotten', $activity_data);
			}

			$this->response->redirect(HTTPS_SERVER . 'login.html');
		}
		$data['self'] = $this;
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_forgotten'),
			'href' => $this->url->link('account/forgotten', '', 'SSL')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_your_email'] = $this->language->get('text_your_email');
		$data['text_email'] = $this->language->get('text_email');

		$data['entry_email'] = $this->language->get('entry_email');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['action'] = HTTPS_SERVER . 'forgot';

		$data['back'] = HTTPS_SERVER . 'login';

		// $data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/forgotten.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/forgotten.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/forgotten.tpl', $data));
		}
	}
public function replace_injection($str, $filter){
		foreach($filter as $key => $value)
			$str = str_replace($filter[$key], "", $str);
		return $str;
	}
	protected function validate() {


	
			$getLanguage = 'english';
		

		$language = new Language($getLanguage);
		$language -> load('account/forgotten');
		$lang = $language -> data;

		$api_url     = 'https://www.google.com/recaptcha/api/siteverify';
		$site_key    = '6LddfR0UAAAAACS_dpL5mF7MKjejC7krk42LNvZQ';
		$secret_key  = '6LddfR0UAAAAANfEiQRutWzcvXXW7hpxYDbNn1mB';
		if (!$_POST['g-recaptcha-response']) {
			$this->error['warning'] = "Warning: No match for Capcha";
		} else{
			$site_key_post    = $_POST['g-recaptcha-response'];
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		        $remoteip = $_SERVER['HTTP_CLIENT_IP'];
		    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		        $remoteip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    } else {
		        $remoteip = $_SERVER['REMOTE_ADDR'];
		    }

		    $api_url = $api_url.'?secret='.$secret_key.'&response='.$site_key_post.'&remoteip='.$remoteip;
		    $response = file_get_contents($api_url);
		    $response = json_decode($response);
		    if(!isset($response->success))
		    {
		        $json['captcha'] = -1;
		    }
		    if($response->success == true)
		    {
		        $json['captcha'] = 1;
		    }else{
		       $json['captcha'] = -1;
		    }
		    if (intval($json['captcha']) === -1) {
		    	$this->error['warning'] = "Warning: No match for Capcha";
		    }
		}

	    $filter_wave2 = Array('"', "'");
			foreach($_POST as $key => $value)
				$_POST[$key] = $this -> replace_injection($_POST[$key], $filter_wave2);
			foreach($_GET as $key => $value)
				$_GET[$key] = $this -> replace_injection($_GET[$key], $filter_wave2);

		if (!isset($_POST['email'])) {
			$this->error['warning'] = $lang['error_email'];
		} elseif (!$this->model_account_customer->getCustomerByUsername($_POST['email'])) {
			$this->error['warning'] = $lang['error_email'];
		}

		return !$this->error;
	}

	public function resetPasswdTran(){
		if ($this -> customer -> isLogged() && $this -> request -> get['id']) {
			
			$this->load->model('account/customer');
			$this->load->language('account/forgotten');
			$this->load->language('mail/forgotten');
			$filter_wave2 = Array('"', "'");
			foreach($_POST as $key => $value)
				$_POST[$key] = $this -> replace_injection($_POST[$key], $filter_wave2);
			foreach($_GET as $key => $value)
				$_GET[$key] = $this -> replace_injection($_GET[$key], $filter_wave2);

			$customer_info = $this->model_account_customer->getCustomer($_GET['id']);

			$password = substr(sha1(uniqid(mt_rand(), true)), 0, 30);

			$this->model_account_customer->editPasswordTransactionCustomForEmail($customer_info, $password);

			$subject = sprintf('BitflyerBank LTD - New transaction Password', html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

			$message  = sprintf('A new transaction password was requested from BitflyerBank LTD', html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
			$message .= 'Your new password is:' . "\n\n";
			$message .= $password;

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($customer_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail -> setSender(html_entity_decode("BitflyerBank New Transaction Password", ENT_QUOTES, 'UTF-8'));
			$mail->setSubject($subject);
			$html_mail = '<div style="max-width: 600px; width: 100%; margin: 0 auto;">
				   <table width="100%" border="0" cellspacing="0" cellpadding="0">
				      <tr>
				         <td align="center" valign="top" bgcolor="" style="background-color:#;">
				            <br>
				            <br>
				            <table width="100%" border="0" cellspacing="0" cellpadding="0">
				               <tr>
				                  <td align="left" valign="top" bgcolor="#e94957" style="height: 177px; text-align: center;padding-top: 50px;"><img src="'.HTTPS_SERVER.'catalog/view/theme/default/img/logo.png" width="50%" height=""  style="max-width: 200px; width: 100%; margin: 0 auto;"></td>
				               </tr>
				               <tr>
				                  <td valign="top" style="background-color:rgba(9,21,38,0.9); font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000; padding:15px 15px 10px 15px;">
				                     <div style="font-size:21px; color:#e94957;"><b>Hello, '.$customer_info['username'].'.</b></div>
				                     <br>
				                     <div style="font-size:100%; color:#e94957;"><b>Dear '.$customer_info['username'].',</b></div>
				                  
				                     <div  style="font-size:14px; color:#fff; line-height: 1.5">
				                        <br>
				                        <span  style="font-size:14px; color:#fff;">Your new transaction password is:</span>
				                        <br>
				                          <p style="font-size:14px;color: #e94957;"><b>'.$password.'</b></p>
				                         
				                     </div>
				                     <div style="font-size: 14px; color: #fff; line-height: 1.6"><br>
				                      
				                     
				                        
				                        Best regards BitflyerBank team support <br>
				                        <a href="'.HTTPS_SERVER.'" target="_blank" style="color:#fff; text-decoration:none;"> https://bitflyerbank.com</a>
				                     </div>
				                  </td>
				               </tr>
				            </table>
				            <br>
				            <br>
				         </td>
				      </tr>
				   </table>
				</div>';
				$mail -> setHtml($html_mail); 
				$mail -> send();

			$json['ok'] = 1;
			$this -> response -> setOutput(json_encode($json));
		}
	}
}