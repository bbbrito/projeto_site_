<?php

class Adverts_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->table = 'adverts';
	}

	public function get_data($id, $select = NULL){
		if(!empty($select)){
			$this->db->select($select);
		}
		$this->db->from("adverts");
		$this->db->where("id_advert", $id);
		return $this->db->get();
	}

	public function get_cities($state){
		$this->db->select("city");
		$this->db->distinct();
		$this->db->from("adverts");
		$this->db->where("state", $state);
		return $this->db->get();
	}

	public function getRows($params = array()) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where("advert_status", 1);
		$this->db->where("advert_delete", 1);

		if(array_key_exists("where", $params)){ 
            foreach($params['where'] as $key => $val){ 
                $this->db->where($key, $val); 
            } 
        } 

        if(array_key_exists("search", $params)){ 
            // Filter data by searched keywords 
            if(!empty($params['search']['keywords'])){ 
                $this->db->like('advert_title', $params['search']['keywords']); 
            } 
        }          
        // Sort data by ascending or desceding order 
        if(!empty($params['search']['sortBy'])){ 
            $this->db->order_by('id_advert', $params['search']['sortBy']); 
        }
         
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
            $result = $this->db->count_all_results(); 
        }else{ 
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                $this->db->limit($params['limit'],$params['start']); 
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                $this->db->limit($params['limit']); 
            }             
            $query = $this->db->get(); 
            $result = ($query->num_rows() > 0)?$query->result_array():FALSE;           
        } 
        return $result; 
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

	public function update_delete_ban($id){
		$this->db->where("id_user_fk", $id);
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
	var $column_order = array("advert_title", "advert_img", "state", "advert_datetime", "advert_count", "id_user_fk");

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
