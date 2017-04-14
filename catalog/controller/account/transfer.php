<?php
class ControllerAccountTransfer extends Controller {

    public function index() {  
       function myCheckLoign($self) {
            return $self -> customer -> isLogged() ? true : false;
        };

        function myConfig($self) {
            $self -> document -> addScript('catalog/view/javascript/transfer/transfermoney.js');
            
        };

        !call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
        call_user_func_array("myConfig", array($this));
        
        $session_id = $this -> session -> data['customer_id'];
        $this -> load -> model('account/customer');
        $data = array();
        $data['self'] = $this;
        $data['customer'] = $customer = $this -> model_account_customer -> getCustomer($this -> session -> data['customer_id']);
        
        $page = isset($this -> request -> get['page']) ? $this -> request -> get['page'] : 1;

        $limit = 10;
        $start = ($page - 1) * 10;

        $ts_history = $this -> model_account_customer -> getTotalTokenHistory($this -> session -> data['customer_id']);

        $ts_history = $ts_history['number'];

        $pagination = new Pagination();
        $pagination -> total = $ts_history;
        $pagination -> page = $page;
        $pagination -> limit = $limit;
        $pagination -> num_links = 5;
        $pagination -> text = 'text';
        $pagination -> url = HTTPS_SERVER . 'transfer&page={page}';
        $data['histotys'] = $this -> model_account_customer -> getTokenHistoryById($this -> session -> data['customer_id'], $limit, $start);

        $data['pagination'] = $pagination -> render();

        $this -> load -> model('account/withdrawal');
        
        $data['profit_daily'] = $this -> get_daily_profit();
        $data['refferal_profit'] = $this -> get_refferal_commisson();
        $data['binary_bonus'] = $this -> getBinaryBonus($this -> session -> data['customer_id']);
        $data['getMWallet'] = $this -> getMWallet($this -> session -> data['customer_id']);
        $data['get_customer_setting'] = $get_customer_setting = $this -> model_account_customer -> get_customer_setting($this -> session -> data['customer_id']);

        if (file_exists(DIR_TEMPLATE . $this -> config -> get('config_template') . '/template/account/transfer.tpl')) {
            $this -> response -> setOutput($this -> load -> view($this -> config -> get('config_template') . '/template/account/transfer.tpl', $data));
        } else {
            $this -> response -> setOutput($this -> load -> view('default/template/account/login.tpl', $data));
        }
    }
    
    public function get_daily_profit(){
        $this -> load -> model('account/withdrawal');
        $profit_daily = $this -> model_account_withdrawal -> get_daily_payment($this -> session -> data['customer_id']);
        
        return $profit_daily['amount'] ?  $profit_daily['amount']/1000000 : 0;

    }
    public function get_refferal_commisson(){
        $this -> load -> model('account/withdrawal');
        $refferal_profit = $this -> model_account_withdrawal -> get_refferal_payment($this -> session -> data['customer_id']);
        return $refferal_profit['amount'] ?  $refferal_profit['amount']/1000000 : 0;

    }
    public function getBinaryBonus($customer_id){
        $this -> load -> model('account/withdrawal');
        $binary = $this -> model_account_withdrawal -> get_binary_payment($this -> session -> data['customer_id']);
        return $binary['amount'] ?  $binary['amount']/1000000 : 0;
    }
     public function getMWallet($customer_id){
        $this -> load -> model('account/withdrawal');
        $getMWallet = $this -> model_account_withdrawal -> get_m_payment($this -> session -> data['customer_id']);
        return $getMWallet['amount'] ?  $getMWallet['amount']/1000000 : 0;
    }
   
   
    public function submit_transfer(){
        
        function myCheckLoign($self) {
            return $self -> customer -> isLogged() ? true : false;
        };

        function myConfig($self) {
            
        };
        !call_user_func_array("myCheckLoign", array($this)) && $this -> response -> redirect("/login.html");
        call_user_func_array("myConfig", array($this));
        $this -> load -> model('account/customer');
        $this -> load -> model('account/withdrawal');
  
        if ($this -> request -> post){
            $json = array();
       
            $customer = $_POST['customer'];
            $wallet = $_POST['wallet'];
            $amount = $_POST['amount'];
            $password_transaction = $_POST['password_transaction'];
            $description = $_POST['description'];
            $authenticator = $_POST['authenticator'];
            $json['input'] = 1;
            $json['ok'] = -1;
            $authen = 1;
            $json['authen'] = 1;
            $get_customer_setting = $this -> model_account_customer -> get_customer_setting($this -> session -> data['customer_id']);
          
            if (intval($get_customer_setting['withdrawal_authenticator']) == 1) {
                if ($authenticator == '') {
                    $authen = -1;
                      $json['authen'] = -1;
                }else{
                    $authen = 1;
                }
                
            }

            if ($customer == '' || $wallet == '' || $amount == '' || $password_transaction == ''|| $authen == -1) {
              $json['input'] = -1;
            }else{
                
                switch ($wallet) {
                    case 'C':
                        $wallet = 'Refferal Commission';
                        $amount_check = $this -> get_refferal_commisson();
                        break;
                    case 'R':
                         $wallet = 'Profit Daily';
                         $amount_check = $this -> get_daily_profit();
                        break;
                    case 'CN':
                        $wallet = 'Binary Bonuses';
                        $amount_check = $this -> getBinaryBonus($this -> session -> data['customer_id']);
                        break;
                    case 'B':
                        $wallet = 'Co-division Commission';
                         $amount_check = $this -> getMWallet($this -> session -> data['customer_id']);
                        break;
                    default:
                        die();
                        break;
                }
                // check amount
                $amount_usd = $_POST['amount']*1000000;
                $amount_check = $amount_check * 1000000;
                $json['amount'] = doubleval($amount_usd) > doubleval($amount_check) || doubleval($amount_usd) < 5000000 ? -1 : 1;
                // check password
                $check_password_transaction = $this -> model_account_customer -> check_password_transaction($this->session->data['customer_id'],$password_transaction);
                $json['password'] = intval($check_password_transaction)> 0 ? 1 : -1;
                // check username
                $TreeCustomer = $this -> model_account_customer -> checkUserName($this -> session -> data['customer_id']);
                $UTree = explode(',', $TreeCustomer);
                unset($UTree[0]);
                $json['customers'] = in_array($customer, $UTree) ? 1 : -1;
                // ==============================

                $ga = new PHPGangsta_GoogleAuthenticator();
                $oneCode = $ga->getCode($get_customer_setting['key_authenticator']);
                $oneCode == $authenticator ? $json['authenticator'] = 1 : $json['authenticator'] = -1;

              
                if (intval($json['amount']) === 1 && intval($json['password']) === 1 && intval($json['customers']) === 1 && intval($json['authenticator'] = 1) === 1) {


                    $customerSend = $this -> model_account_customer -> getCustomer($this -> session -> data['customer_id']);

                    $customerReceived = $this -> model_account_customer -> getCustomerByUsername($customer);

                    switch ($_POST['wallet']) {
                        case 'C':

                            $this -> model_account_withdrawal -> updateC_wallet_Sub($this -> session -> data['customer_id'], $amount_usd);   
                            $this -> model_account_withdrawal -> updateC_wallet_Sub($customerReceived['customer_id'], $amount_usd, true);
                            //save history cho user chuyen di
                            $id_history = $this -> model_account_customer -> saveHistoryPin($this -> session -> data['customer_id'], '- ' . ($amount_usd/1000000) . ' USD ', $description, 'Send', $customerReceived['username'], $wallet);
                            //save history cho user nhan token
                            $id_history = $this -> model_account_customer -> saveHistoryPin($customerReceived['customer_id'], '+ ' . ($amount_usd/1000000) . ' USD ', $description, 'Received', $customerSend['username'], $wallet);  
                            break;
                        case 'R':
                       
                            $this -> model_account_withdrawal -> updateR_wallet_Sub($this -> session -> data['customer_id'], $amount_usd);   
                            $this -> model_account_withdrawal -> updateR_wallet_Sub($customerReceived['customer_id'], $amount_usd, true);
                            //save history cho user chuyen di
                            $id_history = $this -> model_account_customer -> saveHistoryPin($this -> session -> data['customer_id'], '- ' . ($amount_usd/1000000) . ' USD ', $description, 'Send', $customerReceived['username'], $wallet);
                            //save history cho user nhan token
                            $id_history = $this -> model_account_customer -> saveHistoryPin($customerReceived['customer_id'], '+ ' . ($amount_usd/1000000) . ' USD ', $description, 'Received', $customerSend['username'], $wallet);  
                            break;
                        case 'CN':
                            $this -> model_account_withdrawal -> updateCN_wallet_Sub($this -> session -> data['customer_id'], $amount_usd);   
                            $this -> model_account_withdrawal -> updateCN_wallet_Sub($customerReceived['customer_id'], $amount_usd, true);
                            //save history cho user chuyen di
                            $id_history = $this -> model_account_customer -> saveHistoryPin($this -> session -> data['customer_id'], '- ' . ($amount_usd/1000000) . ' USD ', $description, 'Send', $customerReceived['username'], $wallet);
                            //save history cho user nhan token
                            $id_history = $this -> model_account_customer -> saveHistoryPin($customerReceived['customer_id'], '+ ' . ($amount_usd/1000000) . ' USD ', $description, 'Received', $customerSend['username'], $wallet);  
                            break;
                        case 'B':
                            $this -> model_account_withdrawal -> updateM_wallet_Sub($this -> session -> data['customer_id'], $amount_usd);   
                            $this -> model_account_withdrawal -> updateM_wallet_Sub($customerReceived['customer_id'], $amount_usd, true);
                            //save history cho user chuyen di
                            $id_history = $this -> model_account_customer -> saveHistoryPin($this -> session -> data['customer_id'], '- ' . ($amount_usd/1000000) . ' USD ', $description, 'Send', $customerReceived['username'], $wallet);
                            //save history cho user nhan token
                            $id_history = $this -> model_account_customer -> saveHistoryPin($customerReceived['customer_id'], '+ ' . ($amount_usd/1000000) . ' USD ', $description, 'Received', $customerSend['username'], $wallet);  
                            break;
                        default:
                            die();
                            break;
                    }
                    $json['ok'] = 1;

                }
                
            }

        }else{
            $json['ok'] = -1;
        }
        $this->response->setOutput(json_encode($json));
    }
   
}