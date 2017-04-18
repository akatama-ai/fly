<?php
class ControllerHomePage extends Controller {
	public function index() {
		// $this->response->redirect(HTTPS_SERVER . 'home#googtrans(tg|th)');
		// $this->response->redirect(HTTPS_SERVER . 'home');
		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		$this -> load->model('account/customer');
		$data['limit1'] = $this -> model_account_customer -> get_rate_limit();
		$data['chart'] = $this -> model_account_customer -> get_rate_chart();
		$this -> response -> setOutput($this -> load -> view('default/template/home/index.tpl', $data));
	}

	public function representatives() {
		
		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		$this -> response -> setOutput($this -> load -> view('default/template/home/representatives.tpl', $data));
	}
	public function policy() {
		
		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		$this -> response -> setOutput($this -> load -> view('default/template/home/policy.tpl', $data));
	}
	public function about() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		$this -> response -> setOutput($this -> load -> view('default/template/home/about.tpl', $data));
	}
	public function ourproject() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		$this -> response -> setOutput($this -> load -> view('default/template/home/ourproject.tpl', $data));
	}
	public function how() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/how.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/how.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/how.tpl', $data));
		}
	}
	public function blog() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/blog.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/blog.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/blog.tpl', $data));
		}
	}
	public function faq() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/faq.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/faq.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/faq.tpl', $data));
		}
	}
	public function investment() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/investment.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/investment.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/investment.tpl', $data));
		}
	}
	public function partners() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/partners.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/partners.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/partners.tpl', $data));
		}
	}
	public function slide() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/slide.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/slide.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/slide.tpl', $data));
		}
	}
	public function support() {

		$data['base'] = HTTPS_SERVER;
		$data['self'] = $this;
		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/home/support.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/home/support.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/home/support.tpl', $data));
		}
	}
	public function sendMail(){
		if ($this -> request -> post) {

		// if ($_POST['capcha'] != $_SESSION['cap_code']) {
		// 		die('Error');
	 //    }
		$json = array();
	       $api_url     = 'https://www.google.com/recaptcha/api/siteverify';
		$site_key    = '6LddfR0UAAAAACS_dpL5mF7MKjejC7krk42LNvZQ';
		$secret_key  = '6LddfR0UAAAAANfEiQRutWzcvXXW7hpxYDbNn1mB';

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
	    $json['success'] = -1;
	    if (intval($json['captcha']) === 1) {
	    	$name = $this->request->post['fname'];
		$email = $this->request->post['email'];
		$subject = $this->request->post['subject'];
		$comments = $this->request->post['msg'];
		//$email = "mmo.hyipcent@gmail.com";
			$mail = new Mail();
				$mail -> protocol = $this -> config -> get('config_mail_protocol');
				$mail -> parameter = $this -> config -> get('config_mail_parameter');
				$mail -> smtp_hostname = $this -> config -> get('config_mail_smtp_hostname');
				$mail -> smtp_username = $this -> config -> get('config_mail_smtp_username');
				$mail -> smtp_password = html_entity_decode($this -> config -> get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail -> smtp_port = $this -> config -> get('config_mail_smtp_port');
				$mail -> smtp_timeout = $this -> config -> get('config_mail_smtp_timeout');

				//$mail -> setTo($this -> config -> get('config_email'));
				$mail -> setTo('bitflyerbank@gmail.com');
				$mail -> setFrom($this -> config -> get('config_email'));
				$mail -> setSender(html_entity_decode("BitflyerBank", ENT_QUOTES, 'UTF-8'));
				$mail -> setSubject("Support!");
				$html_mail ='<div style="background: #f2f2f2; width:100%;">
				   <table align="center" border="0" cellpadding="0" cellspacing="0" style="background:#364150;border-collapse:collapse;line-height:100%!important;margin:0;padding:0;
				    width:700px; margin:0 auto">
				   <tbody>
				      <tr>
				        <td>
				          <div style="text-align:center" class="ajs-header"><img  src="'.HTTPS_SERVER.'/catalog/view/theme/default/img/logo.png" alt="logo" style="margin: 0 auto; width:150px;"></div>
				        </td>
				       </tr>
				       <tr>
				       <td style="background:#fff">
				       	<p class="text-center" style="font-size:20px;color: black;text-transform: uppercase; width:100%; float:left;text-align: center;margin: 30px 0px 0 0;">Support !<p>
				       	<p class="text-center" style="color: black; width:100%; float:left;text-align: center;line-height: 15px;margin-bottom:30px;"></p>
       	<div style="width:600px; margin:0 auto; font-size=15px">
       	<p style="font-size:14px;color: black;margin-left: 70px;">Email: <b>'.$name.'</b></p>
					       	<p style="font-size:14px;color: black;margin-left: 70px;">Email: <b>'.$email.'</b></p>
					       	<p style="font-size:14px;color: black;margin-left: 70px;">Subject: <b>'.$subject.'</b></p>
					       	<p style="font-size:14px;color: black;margin-left: 70px;">Message: <b>'.$comments.'</b></p>
					      
					          </div>
				       </td>
				       </tr>
				    </tbody>
				    </table>
				  </div>';
				$mail -> setHtml($html_mail); 
				$mail -> send();
			$json['success'] = 1;
	    }
	    	
		
				
				
			$this->response->setOutput(json_encode($json));
			}
	}
}