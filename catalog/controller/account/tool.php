<?php
class ControllerAccountTool extends Controller {


	public function auto_addtree(){
		$this -> load -> model('account/customer');

		$customer_ml = $this -> model_account_customer -> get_all_customer_ml();
		
		foreach ($customer_ml as $value) {
			$this -> auto_add_tree($value['customer_id']);
            
			
		}
		die('OKkkkkkkkkkkkkkkkk');
	}



	public function matching_profit($customer_id, $amountPD)
    {
    	// $customer_id = 21;
     //    $amountPD = 1000;
         die();
        $this->load->model('account/customer');
        $customer = $this -> model_account_customer ->getCustomer($customer_id);
            $amounts_received = 1500000;
            $user_id = $customer['customer_id'];            
            // ========================
            $amountUSD = ($amountPD*0.005);
            $amountUSD = $amountUSD*1000000;

            for ($i=1; $i < 21 ; $i++) { 
                $p_binary_id = $this -> model_account_customer -> get_p_binary_by_id($user_id);

                if (count($p_binary_id) > 0 && $p_binary_id['p_binary'] != 0)
                {
                	$id_history = $this -> model_account_customer -> saveTranstionHistory(
                        $p_binary_id['p_binary'],
                        'Matching Commission', 
                        '+ '.($amountUSD/1000000).' USD',
                        "Earn 0.5%  from ".$customer['username']." active packag (".($amountPD)." USD)",' ');
	               	$this -> model_account_customer ->update_binary_wallet_cn0($amountUSD,$p_binary_id['p_binary']);                    
                }   
                else
                {
                    break;
                }
                $user_id = $p_binary_id['p_binary'];

            }

    }
    public function matching_pnode()
    {
  
        $this->load->model('account/customer');
        $customer = $this -> model_account_customer ->getCustomer($customer_id);
       
            $amounts_received = 1500000;
            $user_id = $customer['customer_id'];
            // ========================
            $amountUSD = ($amountPD*0.05);
            $amountUSD = $amountUSD*1000000;
            for ($i=1; $i < 11 ; $i++) { 
                $p_binary_id = $this -> model_account_customer -> get_p_binary_by_id($user_id);

                if (count($p_binary_id) > 0 && $p_binary_id['p_node'] != 0)
                {
                	$id_history = $this -> model_account_customer -> saveTranstionHistory(
                        $p_binary_id['p_node'],
                        'Matching Commission', 
                        '+ '.($amountUSD/1000000).' USD',
                        "Earn 5%  from ".$customer['username']." week profit");
	               	$this -> model_account_customer ->update_binary_wallet_cn0($amountUSD,$p_binary_id['p_node']);
                }   
                else
                {
                    break;
                }
                $user_id = $p_binary_id['p_node'];

            }

    }

	public function auto_add_tree($user_id)
    {
        $this -> load -> model('account/customer');
        $customer_id = $user_id;
        $parent = 18;
        $userPonser = $this -> get_child_flood($parent);

        
        
        $this -> model_account_customer -> update_p_binary($customer_id,$userPonser['customer_id']);
        
        if ($userPonser['position'] == 'left')
        {
            $this -> model_account_customer -> update_p_left($userPonser['customer_id'],$customer_id );
        }
        else
        {
            $this -> model_account_customer -> update_p_right($userPonser['customer_id'] ,$customer_id );
        }
        
    }

  

	 public function countLeft($customer_id){
		$this -> load -> model('account/customer');
		$count = $this -> model_account_customer -> getCountBinaryTreeCustom($customer_id);
		$count = (intval($count) + 1);
		return $count;
	}

	public function countRight($customer_id){
		$this -> load -> model('account/customer');
		$count = $this -> model_account_customer -> getCountBinaryTreeCustom($customer_id);
		$count = (intval($count) + 1);
		return  $count;
	}

    public function get_child_flood($parent)
    {   
        $count_id = 1;
        $fool1 = $fool2 = $fool3 = $fool4 = $fool5 = $fool6 = $fool7 = $fool8 = array();
        $left = 196;
        $right = 19;
        while (true) {

        	$countLeft = $this -> countLeft($left);
        	$countRight = $this -> countRight($right);

        	if ($countLeft <= $countRight) {
        		
        		$GetML = $this -> model_account_customer ->  getCustomer_ML($left);

				if(intval($GetML['left']) === 0){
					$customer_id = $left;
					$position = 'left';
					break;
				}
				if(intval($GetML['right']) === 0){
					$customer_id = $left;
					$position = 'right';
					break;
				}

				$GetML = $this -> model_account_customer ->  getCustomer_ML($left);
				$left = $GetML['left'];
				$right = $GetML['right'];
        	}

        	if ($countLeft > $countRight) {

        		$GetML = $this -> model_account_customer ->  getCustomer_ML($right);

				if(intval($GetML['left']) === 0){
					$customer_id = $right;
					$position = 'left';
					break;
				}
				if(intval($GetML['right']) === 0){
					$customer_id = $right;
					$position = 'right';
					break;
				}

				$GetML = $this -> model_account_customer ->  getCustomer_ML($right);
				$left = $GetML['left'];
				$right = $GetML['right'];
        	}


            
        }
        
     	$data['customer_id'] = $customer_id;
     	$data['position'] = $position;
     	return $data;
     	

    }


}