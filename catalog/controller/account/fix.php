<?php
class ControllerAccountFix extends Controller {
	public function callback() {
  
		$this -> load -> model('account/pd');
        $this -> load -> model('account/auto');
        $this -> load -> model('account/customer');
        die('Error');
        $invoice_id = array_key_exists('invoice', $this -> request -> get) ? $this -> request -> get['invoice'] : "Error";


        $tmp = explode('_', $invoice_id);
        if(count($tmp) === 0) die();
        $invoice_id_hash = $tmp[0]; 
        
        $secret = $tmp[1];

        //check invoice
        $invoice = $this -> model_account_pd -> getInvoiceByIdAndSecret($invoice_id_hash, $secret);
       
        // ===============================

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
           

            $pd_tmp_pd = $this -> model_account_pd -> getPD($invoice['transfer_id']);
           
            $customer = $this -> model_account_customer ->getCustomer($invoice['customer_id']);
           
                $customer_ml = $this -> model_account_customer -> getTableCustomerMLByUsername($invoice['customer_id']);

                $customer_first = true ;
                if(intval($customer_ml['p_binary']) !== 0 ){
                	$amount_binary = $pd_tmp_pd['filled'];
                    while (true) {
                        //lay thang cha trong ban Ml
                        $customer_ml_p_binary = $this -> model_account_customer -> getTableCustomerMLByUsername($customer_ml['p_binary']);
                        // $check_f1_left = $this -> binary_left($customer_ml['p_binary']);
                        // $check_f1_right  = $this -> binary_right($customer_ml['p_binary']);

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

               
               
                 // Update Level
                
                 //=========Hoa hong bao tro=====================
               
                
             

           }
           $url ='https://bitflyerb.com/index.php?route=account/account/binary_commissionsssssssssssssssss';
           file_get_contents($url);
        echo '1';
	}
}
