<?php
class ControllerAccountFix extends Controller {
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
        print_r($invoice);
die();
        
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

       
        // ===============================
        $this -> model_account_pd -> updateReceived($received, $invoice_id_hash);
        $invoice = $this -> model_account_pd -> getInvoiceByIdAndSecret($invoice_id, $secret);
     	
        $received = intval($invoice['received']);

        if ($received >= intval($invoice['amount'])) {

            if (intval($invoice['confirmations']) >= 3) {
              die();
            }
            
           

            $check_in_ml = $this -> model_account_pd -> check_in_ml($invoice['customer_id']);
            // if (intval($check_in_ml) === 0 ) {
            //    $this -> INsert_ML($invoice['customer_id']);
            // }
            
            $this -> model_account_pd -> updateConfirm($invoice_id_hash, 3, '', '');

            //update PD
           

            $pd_tmp_pd = $this -> model_account_pd -> getPD($invoice['transfer_id']);
            $pd_tmp_ = $pd_tmp_pd ;
            $pd_tmp_ = $pd_tmp_['filled'];
            
            // $this -> model_account_customer -> insert_cashout_today($invoice['customer_id']);
            switch ($pd_tmp_) {
                case 10:
                    // $this -> model_account_customer ->updateLevel($invoice['customer_id'], 2);
                    $pc = 0;
                    $day = 300;
                    // $this -> model_account_customer -> insert_max_out($invoice['customer_id'], 500);
                    break;
                case 50:
                // $this -> model_account_customer ->updateLevel($invoice['customer_id'], 3);
                    $pc = 0;
                    $day = 300;
                    // $this -> model_account_customer -> insert_max_out($invoice['customer_id'], 500);
                    break;
                case 100:
                // $this -> model_account_customer ->updateLevel($invoice['customer_id'], 4);
                    $pc = 0;
                    $day = 300;
                    // $this -> model_account_customer -> insert_max_out($invoice['customer_id'], 500);
                    break;
                
            }

            // if (empty($_GET['danhanreceived'])) {
            //     $this -> model_account_pd -> insert_money_deposit($invoice['customer_id'], $pd_tmp_, $invoice['amount'], $invoice['transfer_id']);
            //     $this -> model_account_pd -> update_total_invest($invoice['amount']);
            // }
            
            $pd_tmp_ = $pd_tmp_ * $pc;

          
            
            $customer = $this -> model_account_customer ->getCustomer($invoice['customer_id']);
       
            // $amountPD = intval($invoice['amount']);
            
            // $max_profit = $amountPD * 0.02;
            $pd_tmp_ = 0;
            // $this -> model_account_customer -> update_R_Wallet_add($pd_tmp_, $pd_tmp_pd['filled'], $invoice['transfer_id'], $invoice['customer_id'], $customer['wallet'],$day);
            

          
                 // $this -> model_account_pd -> updateDatefinishPD($invoice['transfer_id'], $pd_tmp_,$day);
                //update pd left and right
                //get customer_ml p_binary
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
