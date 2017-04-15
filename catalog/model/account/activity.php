<?php
class ModelAccountActivity extends Model {
	public function addActivity($key, $data) {
		if (isset($data['customer_id'])) {
			$customer_id = $data['customer_id'];
		} else {
			$customer_id = 0;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_activity` SET `customer_id` = '" . (int)$customer_id . "', `key` = '" . $this->db->escape($key) . "', `data` = '" . $this->db->escape(serialize($data)) . "', `ip` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', `date_added` = NOW()");
	}
	public function SaveInfoLogin($key, $data) {
		if (isset($data['customer_id'])) {
			$customer_id = $data['customer_id'];
		} else {
			$customer_id = 0;
		}
		$ip_old = $this -> getip($customer_id);
		if ($ip_old == $this->request->server['REMOTE_ADDR']) {
			$query = $this -> db -> query("
			UPDATE ". DB_PREFIX . "customer_login_ip
			SET total = total + 1
			WHERE customer_id = ".$customer_id." AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' ");
		}else{
			$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_login_ip` SET `customer_id` = '" . (int)$customer_id . "', `username` = '" . $this->db->escape($data['name']) . "', `browser` = '" . $this->db->escape($data['browser']) . "', `ip` = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', `date_added` = NOW(), total = 1 ");
		}
		
	}

	public function getip($customer_id) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_login_ip` WHERE customer_id = '" . $this->db->escape($customer_id) . "' ");

		return $query->row['ip'];
	}
	public function get_login($customer_id) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_login_ip` WHERE customer_id = '" . $this->db->escape($customer_id) . "' ORDER BY date_added DESC LIMIT 10 ");

		return $query->rows;
	}
	public function server_time(){
		$query = $this->db->query("SELECT NOW() as servertime ");

		return $query->row;
	}
	

	public function get_rate_limit() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "rate WHERE status = 0 order by id DESC LIMIT 1");
		return $query->row;
	}
}