<?php

class Users_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_user_data($email) {
		$this->db
			->select("id_user, login_user, password_hash, email_user, status")
			->from("users")
			->where("email_user", $email);

		$result = $this->db->get();

		if($result->num_rows() > 0){
			return $result->row();
		} else{
			return NULL;
		}
	}

	public function get_data($id, $select = NULL) {
		if (!empty($select)) {
			$this->db->select($select);
		}
		$this->db->from("users");
		$this->db->where("id_user", $id);
		return $this->db->get();
	}

	public function get_login_data($email) {
		$this->db->select("login_user");
		$this->db->from("users");
		$this->db->where("email_user", $email);		
		return $this->db->get();
	}

	public function confirmation_cad($email, $token){
		$this->db->select("*");
		$this->db->from("confirmation");
		$this->db->where("email_user", $email);
		$this->db->where("token", $token);
		$count = $this->db->get()->num_rows();

		if ($count > 0) {
			$this->db->from("confirmation");
			$this->db->where("email_user", $email);
			$this->db->delete("confirmation");
			return true;
		} else {
			return false;
		}
	}

	public function expire_link($email, $date){	
		$this->db->from("confirmation");
		$this->db->where("email_user", $email);
		$this->db->where("expire_date <", $date);
		if ($this->db->get()->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function active_cad($email){
		$this->db->from("users");
		$this->db->where("email_user", $email);
		$this->db->set("status", 1);
		$this->db->update("users");
	}

	public function insert($table, $data){
		$this->db->insert($table, $data);
	}

	public function update($id, $data){
		$this->db->where("id_user", $id);
		$this->db->update("users", $data);
	}

	public function update_password($email, $data){
		$this->db->from("users");
		$this->db->where("email_user", $email);
		$this->db->set("password_hash", $data);
		$this->db->update("users");
	}

	public function delete($id, $status){
		$this->db->where("id_user", $id);
		switch ($status) {
		  case 0:
			$this->db->delete("users");
		    break;
		  case 1:
			$this->db->set("status", "2");
			$this->db->update("users");
		    break;
		  case 2:
			$this->db->delete("users");
		    break;
		  default:
		    return false;
		}
	}

	public function is_duplicated($field, $value, $id = NULL){
		if(!empty($id)){
			$this->db->where("id_user <>", $id);
		}	
		$this->db->from("users");
		$this->db->where($field, $value);
		return $this->db->get()->num_rows() > 0;
	}

	var $column_search = array("login_user", "email_user", "register_date");
	var $column_order = array("login_user", "email_user", "register_date", "status");

	private function _get_datatable() {

		$search = NULL;
		if ($this->input->post("search")) {
			$search = $this->input->post("search")["value"];
		}
		$order_column = NULL;
		$order_dir = NULL;
		$order = $this->input->post("order");
		if (isset($order)) {
			$order_column = $order[0]["column"];
			$order_dir = $order[0]["dir"];
		}

		$this->db->from("users");
		if (isset($search)) {
			$first = TRUE;
			foreach ($this->column_search as $field) {
				if ($first) {
					$this->db->group_start();
					$this->db->like($field, $search);
					$first = FALSE;
				} else {
					$this->db->or_like($field, $search);
				}
			}
			if (!$first) {
				$this->db->group_end();
			}
		}

		if (isset($order)) {
			$this->db->order_by($this->column_order[$order_column], $order_dir);
		}
	}

	public function get_datatable() {

		$length = $this->input->post("length");
		$start = $this->input->post("start");
		$this->_get_datatable();
		if (isset($length) && $length != -1) {
			$this->db->limit($length, $start);
		}
		return $this->db->get()->result();
	}

	public function records_filtered() {

		$this->_get_datatable();
		return $this->db->get()->num_rows();

	}

	public function records_total() {

		$this->db->from("users");
		return $this->db->count_all_results();

	}
}