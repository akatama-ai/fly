<?php
class ModelAccountWithdrawal extends Model {
	// public function get_daily_payment($customer_id){
	// 	$query = $this -> db -> query("SELECT id, customer_id, SUM(amount) as amount FROM " . DB_PREFIX . "customer_r_wallet_payment WHERE customer_id = '".$this->db->escape($customer_id)."' ");
	// 	return $query->row;
	// }
	public function updateR_wallet_Sub($customer_id, $amount, $add = false){
		if ($add) {
			$query = $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer_r_wallet
					SET amount = amount + ".doubleval($amount)." WHERE customer_id = ".$customer_id."
			");
		}else{
			$query = $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer_r_wallet
					SET amount = amount - ".doubleval($amount)." WHERE customer_id = ".$customer_id."
			");
		}
		
		return $query;
	}
	public function updateC_wallet_Sub($customer_id, $amount, $add = false){
		if ($add) {
			$query = $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer_c_wallet
					SET amount = amount + ".doubleval($amount)." WHERE customer_id = ".$customer_id."
			");
		}else{
			$query = $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer_c_wallet
					SET amount = amount - ".doubleval($amount)." WHERE customer_id = ".$customer_id."
			");
		}
		
		return $query;
	}
	public function updateM_wallet_Sub($customer_id, $amount, $add = false){

		if ($add) {
			$query = $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer_m_wallet
					SET amount = amount + ".doubleval($amount)." WHERE customer_id = ".$customer_id."
			");
		}else{
			$query = $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer_m_wallet
					SET amount = amount - ".doubleval($amount)." WHERE customer_id = ".$customer_id."
			");
		}
		return $query;
	}
	public function updateCN_wallet_Sub($customer_id, $amount, $add = false){
		if ($add) {
			$query = $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer_cn_wallet
					SET amount = amount + ".doubleval($amount)." WHERE customer_id = ".$customer_id."
			");
		}else{
			$query = $this -> db -> query("
				UPDATE " . DB_PREFIX . "customer_cn_wallet
					SET amount = amount - ".doubleval($amount)." WHERE customer_id = ".$customer_id."
			");
		}
		return $query;
	}
	public function get_daily_payment($customer_id){
		$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "customer_r_wallet WHERE customer_id = '".$this->db->escape($customer_id)."' ");
		return $query->row;
	}
	public function update_r_payment_default($customer_id){
		$query = $this -> db -> query("
			UPDATE " . DB_PREFIX . "customer_r_wallet_payment
				SET amount = 0, number_day = 0 WHERE customer_id = ".$customer_id."
		");
		return $query;
	}
	public function delete_cn_payment_default($customer_id) {
		$this -> db -> query("DELETE FROM " . DB_PREFIX . "customer_cn_wallet_payment
		 WHERE customer_id = '" . $this -> db -> escape($customer_id) . "'");
	}
	public function update_R_Wallet_payment($amount , $transferID){
		
		$query = $this -> db -> query("
		UPDATE " . DB_PREFIX . "customer_r_wallet_payment SET
			amount = amount + ".intval($amount).",
			total_day = total_day - 1,
			number_day = number_day + 1
			WHERE transfer_id = '".$transferID."'
		");

		return $query === true ? true : false;
	}

	public function get_refferal_payment($customer_id){

		$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "customer_c_wallet WHERE customer_id = '".$this->db->escape($customer_id)."' ");
		return $query->row;
	}
	public function get_binary_payment($customer_id){

		$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "customer_cn_wallet WHERE customer_id = '".$this->db->escape($customer_id)."' ");
		return $query->row;
	}
	public function get_m_payment($customer_id){

		$query = $this -> db -> query("SELECT * FROM " . DB_PREFIX . "customer_m_wallet WHERE customer_id = '".$this->db->escape($customer_id)."' ");
		return $query->row;
	}
	// ================= c_payment
	// public function get_refferal_payment($customer_id){

	// 	$query = $this -> db -> query("SELECT id, customer_id, SUM(amount) as amount FROM " . DB_PREFIX . "customer_c_wallet_payment WHERE customer_id = '".$this->db->escape($customer_id)."' ");
	// 	return $query->row;
	// }
	public function deleteRefferal($customer_id) {
		$this -> db -> query("DELETE FROM " . DB_PREFIX . "customer_c_wallet_payment
		 WHERE customer_id = '" . $this -> db -> escape($customer_id) . "'");
	}
	public function update_total_pd_left($amount, $cus_id){
		$query = $this -> db -> query("
		UPDATE ". DB_PREFIX ."customer SET
			total_pd_left = '".$amount."'
			WHERE customer_id = '".$cus_id."'
		");
		return $query;
	
	}
	public function update_total_pd_right($amount, $cus_id){
		$query = $this -> db -> query("
		UPDATE ". DB_PREFIX ."customer SET
			total_pd_right = '".$amount."'
			WHERE customer_id = '".$cus_id."'
		");
		return $query;
	
	}

	public function getuserin_ml($customer_id){
	
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."customer_ml
			WHERE customer_id = '".intval($customer_id)."'
		");

		return $query -> row;
	}
	public function getuserin_pd($customer_id){
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."customer_provide_donation
			WHERE status = 1 AND customer_id = '".intval($customer_id)."'
		");

		return $query -> row;
	}
	public function getuserin_invoice_pd($customer_id){
	
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."customer_invoice_pd
			WHERE confirmations = 3 AND customer_id = '".intval($customer_id)."'
		");

		return $query -> row;
	}
	public function getuserin_r_payment($customer_id){
		
		$query = $this -> db -> query("
			SELECT count(*) AS number 
			FROM ".DB_PREFIX."customer_r_wallet_payment
			WHERE customer_id = '".intval($customer_id)."'
		");

		return $query -> row;
	}


	public function insert_withdrawal($customer_id, $history_id, $username, $wallet, $amount, $amount_usd){
		$query = $this -> db -> query("
			INSERT INTO " . DB_PREFIX . "withdrawal SET
			customer_id = '".$this -> db -> escape($customer_id)."',
			history_id = '".$this -> db -> escape($history_id)."',
			username = '".$this -> db -> escape($username)."',
			wallet = '".$this -> db -> escape($wallet)."',
			amount = '".$this -> db -> escape($amount)."',
			amount_usd = '".$this -> db -> escape($amount_usd)."'
		");
		return $query;
	}
}