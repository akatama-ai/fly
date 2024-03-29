<?php
class ModelAccountPd extends Model {
	
	public function getAllInvoiceByCustomer($customer_id, $limit, $offset){
		$query = $this -> db -> query("
			SELECT amount, received, confirmations, date_created, transfer_id, input_address
			FROM ". DB_PREFIX ."customer_invoice_pd
			WHERE customer_id = '". $customer_id ."'
			ORDER BY date_created DESC
			LIMIT ".$limit."
			OFFSET ".$offset."
		");
		return $query -> rows;
	}
 
	public function getAllInvoiceByCustomer_notCreateOrder($customer_id){
		$query = $this -> db -> query("
			SELECT amount, received, confirmations, date_created, transfer_id, input_address
			FROM ". DB_PREFIX ."customer_invoice_pd
			WHERE customer_id = '". $customer_id ."' AND confirmations = 0
			ORDER BY date_created DESC
		");
		return $query -> rows;
	}
public function getInvoceForm_InvoiceIdHash($invoice_id_hash){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX ."customer_invoice_pd
			WHERE invoice_id_hash = '".$invoice_id_hash."'
		");
		return $query -> row;
	}
	public function check_in_ml($customer_id){
		$query = $this -> db -> query("
			SELECT COUNT(*) as number FROM `sm_customer_ml` WHERE customer_id = '". $customer_id ."' AND status = 2
		");
		return $query -> row['number'];
	}
	public function check_p_binary($customer_id){
		$query = $this -> db -> query("
			SELECT COUNT(*) as number FROM `sm_customer_ml` WHERE `p_binary` = '". intval($customer_id) ."'
		");
		return $query -> row['number'];
	}
	public function getAllInvoiceByCustomerTotal($customer_id){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM ". DB_PREFIX ."customer_invoice_pd
			WHERE customer_id = '". $customer_id ."'
		");
		return $query -> row;
	}
	public function getInvoceFormHash($invoice_id_hash, $customer_id){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX ."customer_invoice_pd
			WHERE invoice_id_hash = '".$invoice_id_hash."' and customer_id = '". $customer_id ."'
		");
		return $query -> row;
	}

	public function countPD($id_customer){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM ". DB_PREFIX ."customer_invoice_pd
			WHERE customer_id = '". $id_customer ."' AND confirmations = 0
		");
		return $query -> row;
	}
	public function countTransferID($transfer_id){
		$query = $this -> db -> query("
			SELECT COUNT(*) AS number
			FROM ". DB_PREFIX ."customer_invoice_pd
			WHERE transfer_id = '". $transfer_id ."'
		");
		return $query -> row;
	}

	public function updateInaddressAndFree($invoice_id, $invoice_id_hash , $input_addr, $fee_percent, $my_addr,$callback){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_invoice_pd SET
			input_address = '".$input_addr."',
			fee_percent = ".$fee_percent.",
			my_address = '".$my_addr."',
			invoice_id_hash = '".$invoice_id_hash."',
			callback = '".$callback."'
			WHERE invoice_id = ".$invoice_id."");
		return $query;
	}

	public function updateConfirm($invoice_id_hash, $confirmations){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_invoice_pd SET
			confirmations = ".$confirmations.",
			transaction_hash = 'transaction_hash',
			input_transaction_hash = 'nput_transaction_hash'
			WHERE invoice_id_hash = ". $invoice_id_hash."");
		return $query;
	}

	public function updateReceived($received, $invoice_id_hash){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_invoice_pd SET
			received = '" . $received . "'
			WHERE invoice_id_hash = '" . $invoice_id_hash . "'");
		return $query;
	}
	public function update_total_invest($total){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "total SET
			total_invest = total_invest + " . doubleval($total) . "
			WHERE id = 1 ");
		return $query;
	}
	public function update_m_wallet($customer_id, $amount){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_m_wallet SET
			amount = amount - ".intval($amount)."
			WHERE customer_id = '" . $customer_id . "'");
		return $query;
	}

	public function getPD($id){
		$query = $this -> db -> query("
			SELECT * 
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE id = ".$id."
		");
		return $query -> row;
	}
	public function getPD_investment(){
		$query = $this -> db -> query("
			SELECT c.wallet, m.* 
			FROM ". DB_PREFIX . "customer_m_wallet m JOIN ". DB_PREFIX . "customer c ON m.customer_id = c.customer_id
			WHERE m.amount >= 100
		");
		return $query -> rows;
	}

	public function updateDatefinishPD($pd_id,$max_profit,$day){
		$max_profit = 0;
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET 
				status = '1',
				date_finish = DATE_ADD(NOW(),INTERVAL + ".intval($day)." DAY),
				date_update_profit = NOW(),
				max_profit = '".$max_profit."'
				WHERE id = '".$pd_id."'
			");
	}

	public function saveHistoryPin($id_customer, $amount, $user_description, $type , $system_description){
		$this -> db -> query("INSERT INTO " . DB_PREFIX . "ping_history SET
			id_customer = '" . $this -> db -> escape($id_customer) . "',
			amount = '" . $this -> db -> escape( $amount ) . "',
			date_added = NOW(),
			user_description = '" .$this -> db -> escape($user_description). "',
			type = '" .$this -> db -> escape($type). "',
			system_description = '" .$this -> db -> escape($system_description). "'
		");
		return $this -> db -> getLastId();
	}

	public function saveInvoice($customer_id, $secret, $amount, $pd_id){
		$query = $this -> db -> query("
			INSERT INTO ".DB_PREFIX."customer_invoice_pd SET
			customer_id = '".$customer_id."',
			secret = '".$secret."',
			amount = ".$amount.",
			transfer_id = '".$pd_id."',
			received = 0,

			date_created = NOW()
		");

		return $query === True ? $this->db->getLastId() : -1;
	}

	public function getInvoiceByIdAndSecret($invoice_id_hash, $secret){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX ."customer_invoice_pd
			WHERE invoice_id_hash = '". $invoice_id_hash ."' AND 
				  secret = '".$secret."'
		");
		return $query -> row;
	}

	public function getPDNow($id){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE id = '".$this->db->escape($id)."'
		");
		return $query -> row;
	}
	public function getGDBefore(){
		$query = $this -> db -> query("
			SELECT id , customer_id, amount , filled
			FROM ". DB_PREFIX . "customer_get_donation 
			WHERE status IN (0,1) AND filled < amount AND customer_id <> ".$this -> session -> data['customer_id']."
			ORDER BY date_added ASC
			LIMIT 1
		");
		return $query -> row;
	}
	// date_added <= DATE_ADD(NOW(), INTERVAL -10 DAY)
	// 			  AND 
	public function getCustomerInventory(){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX . "customer
			WHERE status = 9 AND customer_id <> '".$this -> session -> data['customer_id']."'
			ORDER BY date_added ASC 
			LIMIT 1
		");
		return $query -> row;
	}
	public function createGDInventory($amount, $customer_id){
		$this -> db -> query("
			INSERT INTO ". DB_PREFIX . "customer_get_donation SET 
			customer_id = '".$customer_id."',
			date_added = NOW(),
			amount = '".$amount."',
			status = 0
		");
		$gd_id = $this->db->getLastId();
		
		$gd_number = hexdec(crc32($gd_id));
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_get_donation SET 
				gd_number = '".$gd_number."'
				WHERE id = '".$gd_id."'
			");
		if($query){
			$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer SET 
				date_added = NOW()
				WHERE customer_id = '".$customer_id."'
			");
		}
		$data['query'] = $query ? true : false;
		$data['gd_number'] = $gd_number;
		$data['gd_id'] = $gd_id;
		return $data;
	}
	public function createTransferList($data){
		$this -> db -> query("
				INSERT INTO ". DB_PREFIX . "customer_transfer_list SET 
				pd_id = '".$data["pd_id"]."',
				gd_id = '".$data["gd_id"]."',
				pd_id_customer = '".$data["pd_id_customer"]."',
				gd_id_customer = '".$data["gd_id_customer"]."',
				transfer_code = '".hexdec( crc32($data["gd_id"]) )."',
				date_added = NOW(),
				date_finish = DATE_ADD(NOW() , INTERVAL +1 DAY),
				amount = '".$data["amount"]."',
				pd_satatus = 0,
				gd_status = 0

			");
	}
	
	public function updateTotalAmountPD($pd_id , $amount){
		$this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET 
			amount = amount + ".$amount." 
			WHERE id = '".$pd_id."'
		");
	}
	public function updateFilledGD($gd_id , $filled){
		$this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_get_donation SET 
			filled = filled + '".$filled."' 
			WHERE id = '".$gd_id."'
		");
	}
	public function updateStatusGD($gd_id , $status){
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer_get_donation SET 
			status = '".$status."'
			WHERE id = '".$gd_id."'
		");
	}
	public function updateStatusPD($pd_id , $status){
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer_provide_donation SET 
			status = '".$status."' 
			WHERE id = '".$pd_id."'
		");
	}
	public function update_type_pd($pd_id , $type){
		$this -> db -> query("UPDATE " . DB_PREFIX . "customer_provide_donation SET 
			type = '".$type."' 
			WHERE id = '".$pd_id."'
		");
	}
	public function CountDayPD($id){
		$query = $this -> db -> query("
			SELECT date_finish
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE id = '".$this->db->escape($id)."' and date_finish <= NOW()
		");
		return $query -> row;
	}

	
	public function check_packet_pd($customer_id, $amount){
		$query = $this -> db -> query("
			SELECT id as pd_number, status
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE customer_id = ".$customer_id." and filled = ".$amount." AND status = 0
		");
		return $query -> row;
	}
	public function count_check_packet_pd($customer_id, $amount){
		$query = $this -> db -> query("
			SELECT count(*) as number
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE customer_id = ".$customer_id." and filled = ".$amount." AND status = 1
		");
		return $query -> row;
	}
	public function get_package_active($customer_id){
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX . "customer_provide_donation
			WHERE customer_id = ".$customer_id." AND status = 1
		");
		return $query -> rows;
	}

	public function get_invoide($pd_id){
		$query = $this -> db -> query("
			SELECT fee_percent, transfer_id, invoice_id_hash,confirmations,pd.filled AS pd_amount, inv.input_address, inv.amount AS amount_inv, inv.received
			FROM ". DB_PREFIX . "customer_provide_donation AS pd
			JOIN ". DB_PREFIX . "customer_invoice_pd inv
				ON pd.id = inv.transfer_id
			WHERE pd.id = ".$pd_id."
		");
		return $query -> row;
	}
	public function getPD_r_payment($id){
		$query = $this -> db -> query("
			SELECT * 
			FROM ". DB_PREFIX . "customer_r_wallet_payment
			WHERE transfer_id = '".$this->db->escape($id)."'
		");
		return $query -> row;
	}
	public function updateAmountInvoicePd($invoice_id_hash, $amount){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_invoice_pd SET
			amount = ".$amount."
			WHERE invoice_id_hash = ". $invoice_id_hash."");
		return $query;
	}
	public function check_payment($customer_id){
		$query -> row['confirmations'] = array();
		$query = $this -> db -> query("
			SELECT confirmations
			FROM ". DB_PREFIX . "customer_invoice_pd
			WHERE customer_id = '".$customer_id."' ORDER BY date_created DESC LIMIT 1
		");
		return $query -> row['confirmations'];
	}
	public function get_invoice_by_id_cus_id($customer_id, $transfer_id, $invoice_id_hash){
	
		$query = $this -> db -> query("
			SELECT *
			FROM ". DB_PREFIX . "customer_invoice_pd
			WHERE customer_id = '".$this->db->escape($customer_id)."' AND transfer_id = '".$this->db->escape($transfer_id)."' AND invoice_id_hash = '".$this->db->escape($invoice_id_hash)."'
		");
		return $query -> row;
	}

	public function update_package($id) {
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_provide_donation SET
			status = 2, date_finish = NOW()
			WHERE id = ". $id."");
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_r_wallet_payment SET
			date_end = NOW()
			WHERE transfer_id = ". $id."");
		return $query;
	}

	public function get_Max_filled($customer_id){
		$query = $this -> db -> query("SELECT max(filled) as max FROM " . DB_PREFIX . "customer_provide_donation WHERE customer_id = '".$this->db->escape($customer_id)."' AND status = 1");
		return $query -> row;
	}
	public function level_ml($level, $customer_id){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_ml SET
			level = '".$level."' WHERE customer_id = ". $customer_id."");
		return $query;
	}
	public function insert_money_deposit($customer_id, $btc, $usd,$pd_id){
		$query = $this -> db -> query("
			INSERT INTO ".DB_PREFIX."money_deposit SET
			customer_id = '".$customer_id."',
			btc = '".$btc."',
			usd = '".$usd."',
			date = NOW(),
			pd_id = '".$pd_id."'
		");
		$id = $this->db->getLastId();
		return $id;
	}
}