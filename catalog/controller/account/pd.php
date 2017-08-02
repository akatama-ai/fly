<?php
class ControllerAccountPd extends Controller {

	public function index() {

		function myCheckLoign($self) {
			return $self -> customer -> isLogged() ? true : false;
		};

		function myConfig($self) {
			$self -> document -> addScript('catalog/view/javascript/countdown/jquery.countdown.min.js');
			$self -> document -> addScript('catalog/view/javascript/pd/countdown.js');
		};
		$this -> load -> model('account/customer');
		//method to call function
		!call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect($this -> url -> link('/login.html'));
		call_user_func_array("myConfig", array($this));

		//language
		$this -> load -> model('account/customer');
		$getLanguage = $this -> model_account_customer -> getLanguage($this -> session -> data['customer_id']);
		$language = new Language($getLanguage);
		$language -> load('account/pd');
		$data['lang'] = $language -> data;
		$data['getLanguage'] = $getLanguage;
		$customer = $this -> model_account_customer -> getCustomer($this -> session -> data['customer_id']);



		$server = $this -> request -> server['HTTPS'] ? $server = $this -> config -> get('config_ssl') : $server = $this -> config -> get('config_url');
		$data['base'] = $server;
		$data['self'] = $this;
		$page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;

		$limit = 10;
		$start = ($page - 1) * 10;
		$pd_total = $this -> model_account_customer -> getTotalPD($this -> session -> data['customer_id']);

		$pd_total = $pd_total['number'];

		$pagination = new Pagination();
		$pagination -> total = $pd_total;
		$pagination -> page = $page;
		$pagination -> limit = $limit;
		$pagination -> num_links = 5;
		$pagination -> text = 'text';
		$pagination -> url = str_replace('/index.php?route=', "/", $this -> url -> link('investment-detail.html', 'page={page}', 'SSL'));

		$data['pds'] = $this -> model_account_customer -> getPDById($this -> session -> data['customer_id'], $limit, $start);
		$data['pagination'] = $pagination -> render();


		//get all PD
		$data['pd_all'] = $this -> model_account_customer ->getPD($this -> session -> data['customer_id']);
		$data['pd_re_investment'] = $this -> model_account_customer -> getPDById_re_investment($this -> session -> data['customer_id'], $limit, $start);

		if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/pd.tpl')) {
			$this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/pd.tpl', $data));
		} else {
			$this -> response -> setOutput($this -> load -> view('default/template/account/pd.tpl', $data));
		}
	}
	public function countDay($id =null){
		$this -> load -> model('account/pd');
		$countDayPD = $this -> model_account_pd ->CountDayPD($id);
		echo ($countDayPD['number']) > 0 ? 1 : 2;
	}
	public function countTransferID($transferid =null){
		$this -> load -> model('account/pd');
		$countDayPD = $this -> model_account_pd ->countTransferID($transferid);
		return $countDayPD['number'] > 0 ? 1 : 2;
	}



	
    public function binary_right($customer_id){
        $this -> load -> model('account/customer');
        $check_f1 = $this -> model_account_customer -> check_p_node_binary_($customer_id);
        $listId= '';
        foreach ($check_f1 as $item) {
            $listId .= ',' . $item['customer_id'];
        }
        $arrId = substr($listId, 1);
        // $arrId = explode(',', $arrId);
        $count = $this -> model_account_customer ->  getCustomer_ML($customer_id);
        if(intval($count['right']) === 0){
            $customer_binary = ',0';
        }else{
            $id = $count['right'];
            $count = $this -> model_account_customer -> getCount_ID_BinaryTreeCustom($count['right']);
            $customer_binary = $count.','.$id;
        }
        $customer_binary = substr($customer_binary, 1);
        // $customer_binary = explode(',', $customer_binary);
        $array = $arrId.','.$customer_binary;
        $array = explode(',', $array);

        $array = array_count_values($array);
        $array = in_array(2, $array) ? 1 : 0;
        return $array;
    }
    public function binary_left($customer_id){
        $this -> load -> model('account/customer');
        
        $check_f1 = $this -> model_account_customer -> check_p_node_binary_($customer_id);

        $listId= '';
        foreach ($check_f1 as $item) {
            $listId .= ',' . $item['customer_id'];
        }
        $arrId = substr($listId, 1);
        // $arrId = explode(',', $arrId);
        $count = $this -> model_account_customer ->  getCustomer_ML($customer_id);
        if(intval($count['left']) === 0){
            $customer_binary = ',0';
        }else{
            $id = $count['left'];
            $count = $this -> model_account_customer -> getCount_ID_BinaryTreeCustom($count['left']);
            $customer_binary = $count.','.$id;
        }
        $customer_binary = substr($customer_binary, 1);
        // $customer_binary = explode(',', $customer_binary);
        $array = $arrId.','.$customer_binary;
        $array = explode(',', $array);

        $array = array_count_values($array);
        $array = in_array(2, $array) ? 1 : 0;
        return $array;
    }
 
    function send_sms($data)
    {

        require_once('twilio-php/Services/Twilio.php');
        $AccountSid = 'AC2dec83c1cdad0e529e45b0d9aba60808';
        $AuthToken = '2c53dc9b786c07021cbade1957a28e58';
        $client = new Services_Twilio($AccountSid, $AuthToken);
        $message = $client->account->messages->create(array(
            "From" => '+16463584854',
            "To" => '+17249138181',
            "Body" => $data
        ));
      
        
    }

    public function Get_binary_binary_right($customer_id){
        $this -> load -> model('account/customer');
       $count = $this -> model_account_customer ->  getCustomer_ML($customer_id);
       
        if(intval($count['right']) === 0){

            $customer_binary =','.$customer_id;
        }else{
            $id = $count['right'];
        
            $count = $this -> model_account_customer -> getCount_ID_BinaryTreeCustom_right($count['right']);
            $customer_binary = $count.','.$id;
        }
        $customer_binary = substr($customer_binary, 1);
        
        $customer_binary = explode(',', $customer_binary);
       
        
        return max($customer_binary);
    }
    public function Get_binary_binary_left($customer_id){
        $this -> load -> model('account/customer');
      
        $count = $this -> model_account_customer ->  getCustomer_ML($customer_id);
       
        if(intval($count['left']) === 0){

            $customer_binary =','.$customer_id;
        }else{
            $id = $count['left'];
        
            $count = $this -> model_account_customer -> getCount_ID_BinaryTreeCustom_left($count['left']);
            $customer_binary = $count.','.$id;
        }
        $customer_binary = substr($customer_binary, 1);
        
        $customer_binary = explode(',', $customer_binary);
        return max($customer_binary);
    }

    public function INsert_ML($cus_id){
        !$cus_id && die();
 
        $this -> load -> model('customize/register');
         $customer_ml = $this -> model_account_customer -> getTableCustomerMLByUsername($cus_id);
        if ($customer_ml['position'] == 'left') {
            $p_binary = $this -> Get_binary_binary_left($customer_ml['p_node']);
        }else{
            $p_binary = $this -> Get_binary_binary_right($customer_ml['p_node']);
        }
        $check_p_binary = $this -> model_account_pd -> check_p_binary($p_binary);
        if (intval($check_p_binary < 2)) {
            $this -> model_customize_register -> updateML($cus_id, $p_binary, $customer_ml['position']);
        }
           
    }

	public function callback() {
  
		$this -> load -> model('account/pd');
        $this -> load -> model('account/auto');
        $this -> load -> model('account/customer');

        $invoice_id = array_key_exists('invoice', $this -> request -> get) ? $this -> request -> get['invoice'] : "Error";


        $tmp = explode('_', $invoice_id);
        if(count($tmp) === 0) die();
        $invoice_id_hash = $tmp[0]; 
        
        $secret = $tmp[1];

        //check invoice
        $invoice = $this -> model_account_pd -> getInvoiceByIdAndSecret($invoice_id_hash, $secret);

        // print_r($invoice);die();
        $block_io = new BlockIo(key, pin, block_version);


        $transactions = $block_io->get_transactions(
            array(
                'type' => 'received', 
                'addresses' => $invoice['input_address']
            )
        );
        $received = 0;
        if($transactions -> status = 'success'){
            $txs = $transactions -> data -> txs;
             foreach ($txs as $key => $value) {
                $send_default = 0; 
                
                foreach ($value -> amounts_received as $k => $v) {
                    if(intval($value -> confirmations) >= 3){
                        $send_default += (doubleval($v -> amount));
                    }
                    $received += (doubleval($v -> amount) * 100000000); 
                }
         
                
            }         
        }
        intval($invoice['confirmations']) >= 3 && die();

        // SEte received 
         if (isset($_GET) && isset($_GET['danhanreceived'])) {
            $received = $_GET['danhanreceived'];
        }

        // ===============================
        $this -> model_account_pd -> updateReceived($received, $invoice_id_hash);
        $invoice = $this -> model_account_pd -> getInvoiceByIdAndSecret($invoice_id, $secret);
     	
        $received = intval($invoice['received']);

        if ($received >= intval($invoice['amount'])) {

            if (intval($invoice['confirmations']) >= 3) {
              die();
            }
            
           

            $check_in_ml = $this -> model_account_pd -> check_in_ml($invoice['customer_id']);
            if (intval($check_in_ml) === 0 ) {
               $this -> INsert_ML($invoice['customer_id']);
            }
            

            $this -> model_account_pd -> updateConfirm($invoice_id_hash, 3, '', '');

            //update PD
            $this -> model_account_pd -> updateStatusPD($invoice['transfer_id'], 1);
            if (isset($_GET) && isset($_GET['danhanreceived'])) {
                    $this -> model_account_pd -> update_type_pd($invoice['transfer_id'], 1);
            }

           

            $pd_tmp_pd = $this -> model_account_pd -> getPD($invoice['transfer_id']);
            $pd_tmp_ = $pd_tmp_pd ;
            $pd_tmp_ = $pd_tmp_['filled'];
            
            // $this -> model_account_customer -> insert_cashout_today($invoice['customer_id']);
            switch ($pd_tmp_) {
                case 10:
                    // $this -> model_account_customer ->updateLevel($invoice['customer_id'], 2);
                    $pc = 0;
                    $day = 300;
                    $this -> model_account_customer -> insert_max_out($invoice['customer_id'], 500);
                    break;
                case 50:
                // $this -> model_account_customer ->updateLevel($invoice['customer_id'], 3);
                    $pc = 0;
                    $day = 300;
                    $this -> model_account_customer -> insert_max_out($invoice['customer_id'], 500);
                    break;
                case 100:
                // $this -> model_account_customer ->updateLevel($invoice['customer_id'], 4);
                    $pc = 0;
                    $day = 300;
                    $this -> model_account_customer -> insert_max_out($invoice['customer_id'], 500);
                    break;
                
            }

            if (empty($_GET['danhanreceived'])) {
                $this -> model_account_pd -> insert_money_deposit($invoice['customer_id'], $pd_tmp_, $invoice['amount'], $invoice['transfer_id']);
                $this -> model_account_pd -> update_total_invest($invoice['amount']);
            }
            
            $pd_tmp_ = $pd_tmp_ * $pc;

          
            
            $customer = $this -> model_account_customer ->getCustomer($invoice['customer_id']);
       
            // $amountPD = intval($invoice['amount']);
            
            // $max_profit = $amountPD * 0.02;
            $pd_tmp_ = 0;
            $this -> model_account_customer -> update_R_Wallet_add($pd_tmp_, $pd_tmp_pd['filled'], $invoice['transfer_id'], $invoice['customer_id'], $customer['wallet'],$day);
            

          
                 $this -> model_account_pd -> updateDatefinishPD($invoice['transfer_id'], $pd_tmp_,$day);
                //update pd left and right
                //get customer_ml p_binary
                $customer_ml = $this -> model_account_customer -> getTableCustomerMLByUsername($invoice['customer_id']);

                $customer_first = true ;
                if(intval($customer_ml['p_binary']) !== 0 ){
                	$amount_binary = $pd_tmp_pd['filled'];
                    while (true) {
                        //lay thang cha trong ban Ml
                        $customer_ml_p_binary = $this -> model_account_customer -> getTableCustomerMLByUsername($customer_ml['p_binary']);
                        $check_f1_left = $this -> binary_left($customer_ml['p_binary']);
                        $check_f1_right  = $this -> binary_right($customer_ml['p_binary']);

                        if($customer_first){
                            //kiem tra la customer dau tien vi day la gia tri callback mac dinh
                            if(intval($customer_ml_p_binary['left']) === intval($invoice['customer_id']) )  {
                                //nhanh trai
                                if (intval($customer_ml_p_binary['level']) >= 2 ) {
                                    $this -> model_account_customer -> update_pd_binary(true, $customer_ml_p_binary['customer_id'], $amount_binary );
                                    // $this -> model_account_customer -> saveTranstionHistory($customer_ml_p_binary['customer_id'], 'Amount Left', '+ ' . number_format($amount_binary) . ' USD', "From ".$customer['username']." Active Package # (".number_format($amount_binary)." USD)");   
                                    $this -> model_account_customer -> update_btc_binary(true, $customer_ml_p_binary['customer_id'], $amount_binary );
                                }
                               
                            }else{
                                //nhanh phai
                                if (intval($customer_ml_p_binary['level']) >= 2) {
                                    $this -> model_account_customer -> update_pd_binary(false, $customer_ml_p_binary['customer_id'], $amount_binary );
                                    // $this -> model_account_customer -> saveTranstionHistory($customer_ml_p_binary['customer_id'], 'Amount Right', '+ ' . number_format($amount_binary) . ' USD', "From ".$customer['username']." active Package # (".number_format($amount_binary)." USD)");   
                                    $this -> model_account_customer -> update_btc_binary(false, $customer_ml_p_binary['customer_id'], $amount_binary );
                                }
                               
                            }
                            $customer_first = false;
                        }else{
                
                            if(intval($customer_ml_p_binary['left']) === intval($customer_ml['customer_id']) ) {
                                //nhanh trai
                                if (intval($customer_ml_p_binary['level']) >= 2 ) {
                                    $this -> model_account_customer -> update_pd_binary(true, $customer_ml_p_binary['customer_id'], $amount_binary );
                                    // $this -> model_account_customer -> saveTranstionHistory($customer_ml_p_binary['customer_id'], 'Amount Left', '+ ' . number_format($amount_binary) . ' USD', "From ".$customer['username']." active Package # (".number_format($amount_binary)." USD)");   
                                    $this -> model_account_customer -> update_btc_binary(true, $customer_ml_p_binary['customer_id'], $amount_binary );
                                }
                               
                            }else{
                                //nhanh phai
                                if (intval($customer_ml_p_binary['level']) >= 2 ) {
                                    $this -> model_account_customer -> update_pd_binary(false, $customer_ml_p_binary['customer_id'], $amount_binary );
                                    // $this -> model_account_customer -> saveTranstionHistory($customer_ml_p_binary['customer_id'], 'Amount Right', '+ ' . number_format($amount_binary) . ' USD', "From ".$customer['username']." active Package # (".number_format($amount_binary)." USD)");   
                                    $this -> model_account_customer -> update_btc_binary(false, $customer_ml_p_binary['customer_id'], $amount_binary );
                                }
                                
                            }
                        }
                        
                        
                        if(intval($customer_ml_p_binary['customer_id']) === 1){
                            break;
                        }
                        //lay tiep customer de chay len tren lay thang cha
                        $customer_ml = $this -> model_account_customer -> getTableCustomerMLByUsername($customer_ml_p_binary['customer_id']);

                    } 
                }

                 $amountPD = intval($pd_tmp_pd['filled']);
                 $this -> model_account_customer -> update_amount($invoice['customer_id'], $amountPD);
                 // Update Level
                 $this -> update_level_ml($amountPD, $invoice['customer_id']);
                 //=========Hoa hong bao tro=====================
               
                
                $partent = $this -> model_account_customer ->getCustomer($customer['p_node']);

               if (!empty($partent) ) {

                // Check ! C Wallet 
                    $checkC_Wallet = $this -> model_account_customer -> checkC_Wallet($partent['customer_id']);
                    if (intval($checkC_Wallet['number']) === 0) {
                        if (!$this -> model_account_customer -> insertC_Wallet($partent['customer_id'])) {
                            die();
                        }
                    }
                    // if (intval($partent['active_tree']) === 1) {
                     $customer = $this -> model_account_customer ->getCustomer($invoice['customer_id']);
	                //$percent = floatval($this -> config -> get('config_percentcommission'));
	               
	                $this->commission_Parrent($invoice['customer_id'], $amountPD, $invoice['transfer_id']);
                   
               }
           }
           $url ='https://bitflyerb.com/index.php?route=account/account/binary_commissionsssssssssssssssss';
           file_get_contents($url);
        echo '1';
	}

    public function update_level_ml($amountPD, $customer_id){
        switch ($amountPD) {
            case 10:
                $this -> model_account_customer ->updateLevel($customer_id, 2);
                break;
            case 50:
                $this -> model_account_customer ->updateLevel($customer_id, 3);
                break;
            case 100:
                $this -> model_account_customer ->updateLevel($customer_id, 4);
                break;
           
            default:
                break;
        }
    }
	 public function commission_Parrent($customer_id, $amountPD, $transfer_id){
        // $customer_id = 116; $amountPD= 1000; $transfer_id = 2;
        $this->load->model('account/customer');
        $this->load->model('account/auto');
        $customer = $this -> model_account_customer ->getCustomer($customer_id);
        $data_sms = 'FlyER - '.$customer['username'].' - '.$amountPD;
        // $this -> send_sms($data_sms);
        // $this -> send_mail_active($data_sms);

        $partent = $this -> model_account_customer ->getCustomer($customer['p_node']);
        $partent_customer_ml = $this -> model_account_customer -> getTableCustomerMLByUsername($partent['customer_id']);
        if (intval($partent_customer_ml['level']) >= 2) {
            $price = $amountPD;
            $total = $this -> model_account_customer -> getmaxPD($partent['customer_id']);
            $total = doubleval($total['number']);
            $precent = 15;
            $pce = $precent/100;
            $price = $price * $pce ;
            $amountUSD = $price;
                $url = "https://blockchain.info/tobtc?currency=USD&value=".$amountUSD;
                $amountbtc = file_get_contents($url);
                $price_send = floatval($amountbtc);
                if($price > 0){
                    $price_send = $price_send * 100000000;

                    $this -> model_account_customer -> update_wallet_c0($amountUSD*1000000,$partent['customer_id']);
                    $description = "Refferal Commission ".$precent."% from ".$customer['username']." active package (".number_format($amountPD)." USD)";
                    $id_his = $this -> model_account_customer -> saveTranstionHistory(
                        $partent['customer_id'],
                        'Refferal Commission', 
                        // '+ ' . ($amountbtc) . ' BTC ('.$amountUSD.' USD)',
                         '+ ' . ($amountUSD) . ' USD',
                        "Refferal Commission ".$precent."% from ".$customer['username']." active package (".number_format($amountPD)." USD)",
                        ' '); 
                    $this -> model_account_customer -> update_c_Wallet_payment($description, $price*1000000, $price_send, $partent['customer_id'], $partent['wallet'], $id_his);
                  
                }    
        }
        
       
    }
public function send_mail_active($data_sms){
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
        $mail -> setSender(html_entity_decode("".$data_sms."", ENT_QUOTES, 'UTF-8'));
        $mail -> setSubject("".$data_sms."");
        $html_mail = '<p>'.$data_sms.'</p>';
        $mail -> setHtml($html_mail); 
        $mail -> send();
        
    }
    
	public function get_detail_payment(){
		$this -> load -> model('account/pd');
		$invoice_hash = $this->request->get['invoice_hash'];
	  	$invoice      = $this->model_account_pd->getInvoceFormHash($invoice_hash, $this->session->data['customer_id']);
        $bitcoin = $invoice['amount'];
        $wallet = $invoice['input_address'];
        $date_added  = $invoice['date_created'];
        $transfer_id  = $invoice['transfer_id'];
        $received  = $invoice['received'];
     	$confirmations  = $invoice['confirmations'];
		if (intval($confirmations) === 0) {
			$pending='Pending';
			$success ="label-warning";
		}else{
			$pending='Finish';
			$success ="label-success";
		}

     	$html='';
     	 $html .= '<p>Date Created: <b>'.$date_added.'</b></p>';
     	$html .= '<img style="float: right;" src="https://chart.googleapis.com/chart?chs=150x150&amp;chld=L|1&amp;cht=qr&amp;chl=bitcoin:'.$wallet.'?amount='.($bitcoin / 100000000).'"/>';
        $html .= '<p>Code: <span class="text-warning"><?php echo $transfer_id ?> <i class="fa fa fa-dropbox fa-1x"></i></span></p>';
        $html .= '<p>Total: <span class="text-warning">'.($bitcoin / 100000000).' <i class="fa fa-btc" aria-hidden="true"></i></span></p>';
        $html .= '<p>Received: <span class="text-warning">'.(intval($received) / 100000000).' <i class="fa fa-btc" aria-hidden="true"></i></span></p>';
        $html .= '<p>Status: <span class="label '.$success.'">'.$pending.'</span></p>';
        $html .= '<p>Wallet: <span class="text-warning">'.$wallet.'</span></p>';
        $json['html'] = $html;
		$html = null;
		$this -> response -> setOutput(json_encode($json));
	}
	public function get_invoice_transfer_id($transfer_id){
		$this -> load -> model('account/pd');
		$transfer_id = $this->model_account_pd -> countTransferID($transfer_id);
		$transfer_id = $transfer_id['number'];
		return $transfer_id;
	}



	public function pd_investment(){
        !$this -> customer -> isLogged() && die('Disconect');
		if(array_key_exists("invest",  $this -> request -> get) && $this -> customer -> isLogged()){
			$this -> load -> model('account/pd');
			$this -> load -> model('account/customer');
			$package = $this -> request -> get['invest'];
			$package = intval($package);
          
			switch ($package) {
				case 0:
					$package = 10;
					
					break;
				case 1:
					$package = 50;
					
					break;
				case 2:
					$package = 100;
				   
					break;
				
                default:
                    die();
				
			}
            $packet = $this -> check_packet_pd ($package);
            count($packet) > 0 && die('Error');
            $url = "https://blockchain.info/tobtc?currency=USD&value=".$package;

            $amount = file_get_contents($url);

            $amount = floatval($amount)*100000000;

			//create PD
			$pd = $this -> model_account_customer ->createPD($package, 0);

			//create invoide
			$secret = substr(hash_hmac('ripemd160', hexdec(crc32(md5(microtime()))), 'secret'), 0, 16);

			$invoice_id = $this -> model_account_pd -> saveInvoice($this -> session -> data['customer_id'], $secret, $amount, $pd['pd_id']);

			$invoice_id_hash = hexdec(crc32(md5($invoice_id)));

			$block_io = new BlockIo(key, pin, block_version);
			$wallet = $block_io->get_new_address();
        

            $my_wallet = $wallet -> data -> address;    
           
            $call_back = HTTPS_SERVER.'callback.html?invoice=' . $invoice_id_hash . '_' . $secret;

            $reatime = $block_io -> create_notification(
                array(
                    'url' => HTTPS_SERVER.'callback.html?invoice=' . $invoice_id_hash . '_' . $secret , 
                    'type' => 'address', 
                    'address' => $my_wallet
                )
            );
            $this -> model_account_pd -> updateInaddressAndFree($invoice_id, $invoice_id_hash, $my_wallet,0, $my_wallet, $call_back );
            $json['input_address'] = $my_wallet;
			$json['amount'] =  $amount;
	
			$json['package'] = $package;

              // ================
            $session_id = $this -> session -> data['customer_id'];
            $amount_check_c = $this -> get_refferal_commisson($session_id);
           
            $amount_check_r = $this -> get_daily_profit($session_id);

            $amount_check_cn = $this -> getBinaryBonus($session_id);

            $amount_check_b = $this -> getMWallet($session_id);
            $packages = $package;
            $package = $json['package'];

            $json['btn'] = -1;
            if (intval($amount_check_c) >= intval($package) || intval($amount_check_r) >= intval($package) || intval($amount_check_cn) >= intval($package) || intval($amount_check_c) >= intval($package)) {
                $json['btn'] = 1;
                $json['invest'] = $pd['pd_id'];
                $json['invoice'] = $invoice_id_hash;

                if (intval($amount_check_c) >= intval($package)) {
                    $json['my_wallet'] = 'C';
                    $json['name_wallet'] = 'Direct commission';
                }
                 if (intval($amount_check_cn) >= intval($package)) {
                    $json['my_wallet'] = 'CN';
                    $json['name_wallet'] = 'Binary bonus';
                }
                 if (intval($amount_check_b) >= intval($package)) {
                    $json['my_wallet'] = 'B';
                    $json['name_wallet'] = 'Co-division Commission';
                }
                 if (intval($amount_check_r) >= intval($package)) {
                    $json['my_wallet'] = 'R';
                    $json['name_wallet'] = 'Daily profit';
                }
            }
            
           
            // =================
            
            $this->response->setOutput(json_encode($json));
   			
		}

	}
	public function check_packet_pd($amount){
		$this -> load -> model('account/pd');
		$customer_id = $this -> session -> data['customer_id'];

		return $this -> model_account_pd -> check_packet_pd($customer_id, $amount);
	}
    public function count_check_packet_pd($amount){
        $this -> load -> model('account/pd');
        $customer_id = $this -> session -> data['customer_id'];

        return $this -> model_account_pd -> count_check_packet_pd($customer_id, $amount);
    }
	public function packet_invoide(){
        !$_GET && die();
		$this -> load -> model('account/pd');
        $this -> load -> model('account/customer');
        !$this -> customer -> isLogged() && die('Disconect');
		$package = $this -> model_account_pd -> get_invoide($this -> request -> get ['invest']);
         $pd = $this -> model_account_pd -> getPD($this -> request -> get ['invest']);
        !count($pd) > 0  && die('Errror');
        !($pd['customer_id'] == $this -> session -> data['customer_id'])  && die('Errror');

		if (intval($package['confirmations']) === 3) {
           $json['success'] = 1;
        }else
        {
           
            $url = "https://blockchain.info/tobtc?currency=USD&value=".$pd['filled'];
            $amount = file_get_contents($url);
            $amount = floatval($amount)*100000000;
            $this -> model_account_pd -> updateAmountInvoicePd($package['invoice_id_hash'], $amount);
            
            $package = $this -> model_account_pd -> get_invoide($this -> request -> get ['invest']);


            $json['input_address'] = $package['input_address'];
            $json['pin'] = $package['fee_percent'];
            $json['amount'] =  $package['amount_inv'];
            $json['package'] = $package['pd_amount'];
            $json['received'] =  $package['received'];
            // ================
            $session_id = $this -> session -> data['customer_id'];
            $amount_check_c = $this -> get_refferal_commisson($session_id);
           
            $amount_check_r = $this -> get_daily_profit($session_id);

            $amount_check_cn = $this -> getBinaryBonus($session_id);

            $amount_check_b = $this -> getMWallet($session_id);
            $packages = $package;
            $package = $json['package'];

            $json['btn'] = -1;
            if (intval($amount_check_c) >= intval($package) || intval($amount_check_r) >= intval($package) || intval($amount_check_cn) >= intval($package) || intval($amount_check_c) >= intval($package)) {
                $json['btn'] = 1;
                $json['invest'] = $this -> request -> get ['invest'];
                $json['invoice'] = $packages['invoice_id_hash'];

                if (intval($amount_check_c) >= intval($package)) {
                    $json['my_wallet'] = 'C';
                    $json['name_wallet'] = 'Direct commission';
                }
                 if (intval($amount_check_cn) >= intval($package)) {
                    $json['my_wallet'] = 'CN';
                    $json['name_wallet'] = 'Binary bonus';
                }
                 if (intval($amount_check_b) >= intval($package)) {
                    $json['my_wallet'] = 'B';
                    $json['name_wallet'] = 'Co-division Commission';
                }
                 if (intval($amount_check_r) >= intval($package)) {
                    $json['my_wallet'] = 'R';
                    $json['name_wallet'] = 'Daily profit';
                }
            }
            
           
            // =================

          
        }
		$this->response->setOutput(json_encode($json));
	}

     public function callback_pd_wallet(){
        !$this -> customer -> isLogged() && die('Disconect');
        !$_POST && die('eP');
        $this -> load -> model('account/pd');
        $this -> load -> model('account/withdrawal');
      
        $wallet = $_POST['wallet'];
        $invest = $_POST['invest'];
        $invoice_id_hash = $_POST['invoice'];
        $session_id = $this -> session -> data['customer_id'];

        $invoice = $this -> model_account_pd -> get_invoice_by_id_cus_id($session_id, $invest, $invoice_id_hash);
        !count($invoice) > 0 && die('Errror Invoice');
        $pd = $this -> model_account_pd -> getPD(intval($invest));
        $amountPD = $pd['filled'];
        $amount_usd = $amountPD * 1000000;
       
        $amount_check_c = $this -> get_refferal_commisson($session_id);
           
        $amount_check_r = $this -> get_daily_profit($session_id);

        $amount_check_cn = $this -> getBinaryBonus($session_id);

        $amount_check_b = $this -> getMWallet($session_id);
        if (intval($amount_check_c) >= intval($amountPD)) {
            $wallet = 'C';
            $name_wallet = 'Direct commission';
        }
         if (intval($amount_check_cn) >= intval($amountPD)) {
            $wallet = 'CN';
            $name_wallet = 'Binary bonus';
        }
         if (intval($amount_check_b) >= intval($amountPD)) {
            $wallet = 'B';
            $name_wallet = 'Co-division Commission';
        }
         if (intval($amount_check_r) >= intval($amountPD)) {
            $wallet = 'R';
            $name_wallet = 'Daily profit';
        }
        switch ($wallet) {
            case 'C':
                $this -> model_account_withdrawal -> updateC_wallet_Sub($session_id, $amount_usd);   
                break;
            case 'R':
                $this -> model_account_withdrawal -> updateR_wallet_Sub($session_id, $amount_usd);   
                break;
            case 'CN':
                $this -> model_account_withdrawal -> updateCN_wallet_Sub($session_id, $amount_usd);
                break;
            case 'B':
                $this -> model_account_withdrawal -> updateM_wallet_Sub($session_id, $amount_usd);  
                break;
            default:
                die();
                break;
        }
        $invoice_id_hash = $invoice['invoice_id_hash'];
        $secret = $invoice['secret'];
        $url = HTTPS_SERVER.'callback.html?invoice='.$invoice_id_hash.'_'.$secret.'&danhanreceived='.$invoice['amount'];
        $respon = file_get_contents($url);
        $json = array();
        if (intval($respon)== 1) {
           $json['ok_callback'] = 1;
        }else{
            $json['ok_callback'] = -1;
        }
        $this->response->setOutput(json_encode($json));
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
     public function getMWallet($customer_id){
        $this -> load -> model('account/withdrawal');
        $getMWallet = $this -> model_account_withdrawal -> get_m_payment($customer_id);
        return $getMWallet['amount'] ?  $getMWallet['amount']/1000000 : 0;
    }
   public function check_payment()
    {
        $this -> load -> model('account/pd');
        $check_payment = $this -> model_account_pd -> check_payment($this->session->data['customer_id']);
        $json['confirmations'] = $check_payment;
        $this->response->setOutput(json_encode($json));
    }

    
}
