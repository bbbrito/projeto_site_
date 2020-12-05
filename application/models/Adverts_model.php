<?php

class Adverts_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/*public function show_adverts($sort = "id_advert", $order = "desc") {
		$this->db->from("adverts");
		$this->db->where("advert_status", 1);
		$this->db->where("advert_delete", 1);
		$this->db->order_by($sort, $order);
		return $this->db->get()->result_array();
	}*/

	public function show_adverts($sort = "id_advert", $order = "desc", $limit = NULL, $offset = NULL, $city = NULL) {

		if ($limit){
			$this->db->limit($limit, $offset);
		}

		if ($city){
			$this->db->where("city", $city);
		}

		$this->db->from("adverts");
		$this->db->where("advert_status", 1);
		$this->db->where("advert_delete", 1);
		$this->db->order_by($sort, $order);
		return $this->db->get()->result_array();
	}

	public function get_data($id, $select = NULL){
		if(!empty($select)){
			$this->db->select($select);
		}
		$this->db->from("adverts");
		$this->db->where("id_advert", $id);
		return $this->db->get();
	}

	public function countAll($city = NULL) {
		if ($city){
			$this->db->where("city", $city);
		}

		$this->db->from("adverts");
		$this->db->where("advert_status", 1);
		$this->db->where("advert_delete", 1);
		return $this->db->get()->num_rows();

	}

	public function insert($data){
		$this->db->insert("adverts", $data);
	}

	public function update($id, $data){
		$this->db->where("id_advert", $id);
		$this->db->update("adverts", $data);
	}

	public function update_delete($id){
		$this->db->where("id_advert", $id);
		$this->db->set("advert_delete", 0);
		$this->db->update("adverts");
	}

	public function update_approve($id){
		$this->db->where("id_advert", $id);
		$this->db->set("advert_status", 1);
		$this->db->update("adverts");
	}

	public function update_recycle($id){
		$this->db->where("id_advert", $id);
		$this->db->set("advert_delete", 1);
		$this->db->update("adverts");
	}

	public function console_log( $data ){
		  echo '<script>';
		  echo 'console.log('. json_encode( $data ) .')';
		  echo '</script>';
		}

	public function update_advert_count($id){
		$data = $this->get_data($id, "advert_count")->result_array()[0];
		$advert_count = $data["advert_count"];
		$advert_count = $advert_count + 1;

		$this->db->where("id_advert", $id);
		$this->db->set("advert_count", $advert_count);
		$this->db->update("adverts");
	}
	public function delete($id){
		$this->db->where("id_advert", $id);
		$this->db->delete("adverts");
	}

	public function is_duplicated($field, $value, $id = NULL){
		if(!empty($id)){
			$this->db->where("id_advert <>", $id);
		}	
		$this->db->from("adverts");
		$this->db->where($field, $value);
		return $this->db->get()->num_rows() > 0;
	}

	/* CAMPOS VIA POST
		$_POST['search']['value'] = Campo para busca
		$_POST['order'] = [[0, 'asc']]
			$_POST['order'][0]['column'] = index da coluna
			$_POST['order'][0]['dir'] = tipo de ordenação (asc, desc)
		$_POST['length'] = Quantos campos mostrar
		$_POST['start'] = Qual posição começar
	*/

	var $column_search = array("advert_title", "advert_description");
	var $column_order = array("advert_title", "state", "advert_datetime");

	//Datatable dos anúncios ativos
	private function _get_datatable($id) {

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

		if($id == 1){
			$this->db->from("adverts");
			$this->db->group_start();
			$this->db->where("advert_status", 1);
			$this->db->where("advert_delete", 1);
			//$this->db->where("advert_privilege", 0);
			$this->db->group_end();
		}
		else {
			$this->db->from("adverts");
			$this->db->group_start();
			$this->db->where("id_user_fk", $id);
			$this->db->where("advert_status", 1);
			$this->db->where("advert_delete", 1);
			//$this->db->where("advert_privilege", 0);
			$this->db->group_end();
		}
			
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

	public function get_datatable($id) {

		$length = $this->input->post("length");
		$start = $this->input->post("start");
		$this->_get_datatable($id);
		if (isset($length) && $length != -1) {
			$this->db->limit($length, $start);
		}
		return $this->db->get()->result();
	}

	public function records_filtered($id) {

		$this->_get_datatable($id);
		return $this->db->get()->num_rows();

	}


	//Datatable dos anúncios em aprovação por id

	private function _get_datatable_pendent($id) {

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

		if($id == 1){
			$this->db->from("adverts");
			$this->db->group_start();
			$this->db->where("advert_status", 0);
			$this->db->where("advert_delete", 1);
			//$this->db->where("advert_privilege", 0);
			$this->db->group_end();
		}
		else {
			$this->db->from("adverts");
			$this->db->group_start();
			$this->db->where("id_user_fk", $id);
			$this->db->where("advert_status", 0);
			$this->db->where("advert_delete", 1);
			//$this->db->where("advert_privilege", 0);
			$this->db->group_end();
		}
			
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

	public function get_datatable_pendent($id) {

		$length = $this->input->post("length");
		$start = $this->input->post("start");
		$this->_get_datatable_pendent($id);
		if (isset($length) && $length != -1) {
			$this->db->limit($length, $start);
		}
		return $this->db->get()->result();
	}

	public function records_filtered_pendent($id) {

		$this->_get_datatable_pendent($id);
		return $this->db->get()->num_rows();

	}

	//Datatable dos anúncios deletados, mas não excluídos definitivamente

	private function _get_datatable_deleted($id) {

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

		if($id == 1){
			$this->db->from("adverts");
			//$this->db->where("advert_status", 1);
			$this->db->where("advert_delete", 0);
		}
		else {
			$this->db->from("adverts");
			//$this->db->group_start();
			$this->db->where("id_user_fk", $id);
			//$this->db->where("advert_status", 1);
			$this->db->where("advert_delete", 0);
			//$this->db->group_end();
		}
			
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

	public function get_datatable_deleted($id) {

		$length = $this->input->post("length");
		$start = $this->input->post("start");
		$this->_get_datatable_deleted($id);
		if (isset($length) && $length != -1) {
			$this->db->limit($length, $start);
		}
		return $this->db->get()->result();
	}

	public function records_filtered_deleted($id) {

		$this->_get_datatable_deleted($id);
		return $this->db->get()->num_rows();

	}

	//Geral
	public function records_total() {

		$this->db->from("adverts");
		return $this->db->count_all_results();

	}
}
