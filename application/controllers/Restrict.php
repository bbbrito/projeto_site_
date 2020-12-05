<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict extends CI_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->library("session");
	}

	public function index(){

		if ($this->session->userdata("id_user")) {
			$data = array(
				"styles" => array(
					"dataTables.bootstrap.min.css",
					"datatables.min.css"
				),
				"scripts" => array(
					//"sweetalert2.all.min.js",
					"dataTables.bootstrap.min.js",
					"datatables.min.js",					
					//"jquery.min.js",
					//"jquery.easing.1.3.js",
					//"bootstrap.min.js",
					"util.js",
					"restrict.js"
				),
				"id_user" => $this->session->userdata("id_user")
			);
			$this->template->show("restrict.php", $data);
		} else {
			$data = array(
				"scripts" => array(
					//"jquery.min.js",
					"util.js",
					"login.js" 
				)
			);
			$this->template->show("login.php", $data);
		}

	}

	public function logoff() {
		$this->session->sess_destroy();
		header("Location: " . base_url() . "restrict");
	}
	
	public function ajax_login() {
		
		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$username = $this->input->post("username");
		$password = $this->input->post("password");

		if (empty($username)) {
			$json["status"] = 0;
			$json["error_list"]["#username"] = "Usuário não pode ser vazio!";
		} else {
			$this->load->model("users_model");
			$result = $this->users_model->get_user_data($username);
			if ($result) {
				$id_user = $result->id_user;
				$password_hash = $result->password_hash;
				if (password_verify($password, $password_hash)) {
					$this->session->set_userdata("id_user", $id_user);
				} else {
					$json["status"] = 0;
				}
			} else {
				$json["status"] = 0;
			}
			if ($json["status"] == 0) {
				$json["error_list"]["#btn_login"] = "Usuário e/ou senha incorretos!";
			}
		}

		echo json_encode($json);

	}


	public function ajax_import_image() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

			
		if($_FILES["files"]["name"] != '') {

			$json = array();
			$json["status"] = 1;
			$json["img_view"] = '';
			$count_files = [];
			$count_files = $_FILES["files"]["name"];
			
			if (count($count_files) > 5) {
				$json["status"] = 0;
				$json["error"] = "Você só pode inserir até 5 imagens.";
			}
			else{

				$config["upload_path"] = "./tmp/";
				$config["allowed_types"] = "gif|png|jpg";
				$config["overwrite"] = TRUE;

				$this->load->library("upload", $config);
				$this->upload->initialize($config);
				for ($i = 0; $i < count($count_files); $i++){
					$_FILES["file"]["name"] = $_FILES["files"]["name"][$i];
					$_FILES["file"]["type"] = $_FILES["files"]["type"][$i];
					$_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$i];
					$_FILES["file"]["error"] = $_FILES["files"]["error"][$i];
					$_FILES["file"]["size"] = $_FILES["files"]["size"][$i];
					if (!$this->upload->do_upload('file')) {
						$json["status"] = 0;
						$json["error"] = $this->upload->display_errors("","");
					} else {
						$data = $this->upload->data();
						$json["img_path"][$i] = base_url() . "tmp/" . $data["file_name"];
						$json["img_view"] .= '<li><img src=" '.base_url() . 'tmp/' . $data["file_name"].'" class="img-responsive img-thumbnail" style="max-width: 100px; max-height: 100px;" /></li>';
						
						
					}
				}//end for
			}//end else
			echo json_encode($json);

		}//end if		
	}

	/*public function ajax_import_image2() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$config["upload_path"] = "./tmp/";
		$config["allowed_types"] = "gif|png|jpg";
		$config["overwrite"] = TRUE;

		$this->load->library("upload", $config);

		$json = array();
		$json["status"] = 1;	

		if (!$this->upload->do_upload("image_file")) {
			$json["status"] = 0;
			$json["error"] = $this->upload->display_errors("","");
		} else {
			
			if ($this->upload->data()["file_size"] <= 1024) {
				$file_name = $this->upload->data()["file_name"];
				$json["img_path"] = base_url() . "tmp/" . $file_name;

			} else {
				$json["status"] = 0;
				$json["error"] = "Arquivo não deve ser maior que 1 MB!";
			}
		}

		echo json_encode($json);
	}*/


	public function ajax_save_advert() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$this->load->model("adverts_model");

		$data = $this->input->post();

		if (empty($data["advert_title"])) {
			$json["error_list"]["#advert_title"] = "O título é obrigatório!";
		} else {
			if ($this->adverts_model->is_duplicated("advert_title", $data["advert_title"], $data["id_advert"])) {
				$json["error_list"]["#advert_title"] = "Anúncio já existente!";
			}
		}

		if (empty($data["category"])){
			$json["error_list"]["#category"] = "Categoria do anúncio é obrigatória!";
		}

		if (empty($data["zip_code"])){
			$json["error_list"]["#zip_code"] = "CEP do anúncio é obrigatório!";
		}

		if (empty($data["state"])){
			$json["error_list"]["#state"] = "Estado do anúncio é obrigatório!";
		}

		if (empty($data["city"])){
			$json["error_list"]["#city"] = "Cidade do anúncio é obrigatória!";
		}

		if (empty($data["advert_description"])){
			$json["error_list"]["#advert_description"] = "Descrição do anúncio é obrigatória!";
		}

		if (empty($data["advert_img"])){
			$json["error_list"]["#advert_img"] = "É obrigatório enviar pelo menos uma foto!";
		}

		if(!empty($json["error_list"])){
			$json["status"] = 0;
		} else {
			$temp_advert_img = explode(',', $data["advert_img"]);
			$data["advert_img"] = '';
			for ($i=0; $i < count($temp_advert_img); $i++) { 
				$file_name = basename($temp_advert_img[$i]);
				$old_path = getcwd() . "/tmp/" . $file_name;
				$new_path = getcwd() . "/public/images/adverts/" . $file_name;
				rename($old_path, $new_path);
				if(count($temp_advert_img) - 1 == 0 || $i == count($temp_advert_img) - 1) {					
					$data["advert_img"] .= "public/images/adverts/" . $file_name;
				}
				else{
					$data["advert_img"] .= "public/images/adverts/" . $file_name . ",";
				}
			}

			if(empty($data["id_advert"])){
				$timezone = new DateTimeZone('America/Sao_Paulo');
				$date = new DateTime('now', $timezone);
				$data["advert_datetime"] = $date->format("Y-m-d H:i");

				if ($this->session->userdata("id_user")) {
					$id_user = array("id_user" => $this->session->userdata("id_user"));
					$data["id_user_fk"] = $id_user["id_user"];
					unset($id_user["id_user"]);
				}

				$data["advert_status"] = 0; //1 = ativo / 0 = em aprovação
				$data["advert_delete"] = 1; //1 = ativo / 0 = deletado
				$data["advert_privilege"] = 0; //1 = pago / 0 = gratuito

				$this->adverts_model->insert($data);

			} else{
				$data["advert_status"] = 0; //1 = ativo / 0 = em aprovação
				$id_advert = $data["id_advert"];
				unset($data["id_advert"]);

				$this->adverts_model->update($id_advert, $data);
			}
		}
		echo json_encode($json);
	}

	public function ajax_approve_advert_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("adverts_model");
		$id_advert = $this->input->post("id_advert");
		$this->adverts_model->update_approve($id_advert);

		echo json_encode($json);
	}

	public function ajax_save_user() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$this->load->model("users_model");

		$data = $this->input->post();

		if (empty($data["login_user"])){
			$json["error_list"]["#login_user"] = "O login é obrigatório!";
		} else {
			if ($this->users_model->is_duplicated("login_user", $data["login_user"], $data["id_user"])){
				$json["error_list"]["#login_user"] = "Usuário já existente!";
			}
		}

		if (empty($data["email_user"])){
			$json["error_list"]["#email_user"] = "O e-mail é obrigatório!";
		} else {
			if ($this->users_model->is_duplicated("email_user", $data["email_user"], $data["id_user"])){
				$json["error_list"]["#email_user"] = "E-mail já existente!";
			} else {
				if ($data["email_user"] != $data["email_user_confirm"]) {
					$json["error_list"]["#email_user"] = "";
					$json["error_list"]["#email_user_confirm"] = "E-mails não conferem!";
				}
			}
		}

		if (empty($data["password_user"])){
			$json["error_list"]["#password_user"] = "A senha é obrigatória!";
		} else {
			if ($data["password_user"] != $data["password_user_confirm"]) {
				$json["error_list"]["#password_user"] = "";
				$json["error_list"]["#password_user_confirm"] = "Senhas não conferem!";
			}
		}

		if(!empty($json["error_list"])){
			$json["status"] = 0;
		} else {

			$data["password_hash"] = password_hash($data["password_user"], PASSWORD_DEFAULT);

			unset($data["password_user"]);
			unset($data["password_user_confirm"]);
			unset($data["email_user_confirm"]);

			if(empty($data["id_user"])){
				$timezone = new DateTimeZone('America/Sao_Paulo');
				$date = new DateTime('now', $timezone);
				$data["register_date"] = $date->format("Y-m-d");
				$this->users_model->insert($data);
			} else{
				$id_user = $data["id_user"];
				unset($data["id_user"]);
				$this->users_model->update($id_user, $data);
			}
		}
		echo json_encode($json);
	}

	//Função criada para editar anúncio
	public function ajax_get_advert_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["input"] = array();

		$this->load->model("adverts_model");

		$id_advert = $this->input->post("id_advert");
		$data = $this->adverts_model->get_data($id_advert)->result_array()[0];
		$json["input"]["id_advert"] = $data["id_advert"];
		$json["input"]["advert_title"] = $data["advert_title"];
		$json["input"]["category"] = $data["category"];
		$json["input"]["zip_code"] = $data["zip_code"];
		$json["input"]["state"] = $data["state"];
		$json["input"]["city"] = $data["city"];
		$json["input"]["advert_description"] = $data["advert_description"];

		$temp_advert_img_path = explode(',', $data["advert_img"]);
		$json["img"]["advert_img_path"] = '';
		for ($i=0; $i < count($temp_advert_img_path); $i++) { 
			$json["img"]["advert_img_path"] .= '<li><img src=" '.base_url() . $temp_advert_img_path[$i].'" class="img-responsive img-thumbnail" style="max-width: 100px; max-height: 100px;" /></li>';
		}

		echo json_encode($json);
	}

	public function ajax_get_user_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["input"] = array();

		$this->load->model("users_model");

		$id_user = $this->input->post("id_user");
		$data = $this->users_model->get_data($id_user)->result_array()[0];
		$json["input"]["id_user"] = $data["id_user"];
		$json["input"]["login_user"] = $data["login_user"];
		$json["input"]["email_user"] = $data["email_user"];
		$json["input"]["email_user_confirm"] = $data["email_user"];
		$json["input"]["password_user"] = $data["password_hash"];
		$json["input"]["password_user_confirm"] = $data["password_hash"];

		echo json_encode($json);
	}

	public function ajax_delete_advert_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("adverts_model");
		$id_advert = $this->input->post("id_advert");
		$this->adverts_model->update_delete($id_advert);

		echo json_encode($json);
	}

	public function ajax_exclude_advert_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("adverts_model");
		$id_advert = $this->input->post("id_advert");
		$this->adverts_model->delete($id_advert);

		echo json_encode($json);
	}

	public function ajax_recycle_advert_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("adverts_model");
		$id_advert = $this->input->post("id_advert");
		$this->adverts_model->update_recycle($id_advert);

		echo json_encode($json);
	}


	public function ajax_approve_all_advert_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("adverts_model");

		if ($this->session->userdata("id_user")) {
			$array_id_user = array("id_user" => $this->session->userdata("id_user"));
			$id_user = $array_id_user["id_user"];
			unset($array_id_user["id_user"]);

			$adverts = $this->adverts_model->get_datatable_pendent($id_user);
		}

		foreach ($adverts as $advert) {
			$id_advert = $advert->id_advert;
			$this->adverts_model->update_approve($id_advert);
		}

		echo json_encode($json);
	}

	public function ajax_exclude_all_advert_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("adverts_model");

		if ($this->session->userdata("id_user")) {
			$array_id_user = array("id_user" => $this->session->userdata("id_user"));
			$id_user = $array_id_user["id_user"];
			unset($array_id_user["id_user"]);

			$adverts = $this->adverts_model->get_datatable_deleted($id_user);
		}

		foreach ($adverts as $advert) {
			$id_advert = $advert->id_advert;
			$this->adverts_model->delete($id_advert);
		}

		echo json_encode($json);
	}

	public function ajax_delete_user_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("users_model");
		$id_user = $this->input->post("id_user");
		$this->users_model->delete($id_user);

		echo json_encode($json);
	}

	public function ajax_list_advert() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$this->load->model("adverts_model");
		//Adaptação para mostrar o datatable conforme usuário adm ou geral com status e excluídos
		if ($this->session->userdata("id_user")) {
			$array_id_user = array("id_user" => $this->session->userdata("id_user"));
			$id_user = $array_id_user["id_user"];
			unset($array_id_user["id_user"]);

			$adverts = $this->adverts_model->get_datatable($id_user);
		}

		$data = array();

		foreach ($adverts as $advert) {

			$row = array();
			$row[] = $advert->advert_title;

			$temp_advert_img_path = explode(',', $advert->advert_img);
			$row[] = '<img src="'.base_url().$temp_advert_img_path[0].'" style="max-height: 100px; max-width: 100px;">';


			$row[] = $advert->state;

			$advert_datetime_formated = $advert->advert_datetime;
			$row[] = date('d/m/Y H:i', strtotime($advert_datetime_formated));

			$row[] = $advert->advert_count;

			$row[] = '<div style="display: inline-block;">
						<button class="btn btn-warning btn-edit-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-edit"></i>
						</button>
						<button class="btn btn-danger btn-del-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-times"></i>
						</button>
					</div>';

			$data[] = $row;

		}

		$json = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $this->adverts_model->records_total(),
			"recordsFiltered" => $this->adverts_model->records_filtered($id_user),
			"data" => $data,
		);

		echo json_encode($json);
	}

	public function ajax_list_new_advert() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$this->load->model("adverts_model");

		if ($this->session->userdata("id_user")) {
			$array_id_user = array("id_user" => $this->session->userdata("id_user"));
			$id_user = $array_id_user["id_user"];
			unset($array_id_user["id_user"]);

			$adverts = $this->adverts_model->get_datatable_pendent($id_user);
		}

		$data = array();

		foreach ($adverts as $advert) {

			$row = array();
			$row[] = $advert->advert_title;

			$temp_advert_img_path = explode(',', $advert->advert_img);
			$row[] = '<img src="'.base_url().$temp_advert_img_path[0].'" style="max-height: 100px; max-width: 100px;">';

			$row[] = $advert->state;
			$row[] = '<div class="description">'.$advert->advert_description.'</div>';

			$advert_datetime_formated = $advert->advert_datetime;
			$row[] = date('d/m/Y H:i', strtotime($advert_datetime_formated));

			if ($id_user == 1) {
				$row[] = '<div style="display: inline-block;">
						<button class="btn btn-primary btn-approve-new-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-check"></i>
						</button>
						<button class="btn btn-warning btn-edit-new-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-edit"></i>
						</button>
						<button class="btn btn-danger btn-exclude-new-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-times"></i>
						</button>
					</div>';

			} else {
				$row[] = '<div style="display: inline-block;">
						<button class="btn btn-warning btn-edit-new-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-edit"></i>
						</button>
						<button class="btn btn-danger btn-exclude-new-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-times"></i>
						</button>
					</div>';
			}
			

			$data[] = $row;

		}

		$json = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $this->adverts_model->records_total(),
			"recordsFiltered" => $this->adverts_model->records_filtered_pendent($id_user),
			"data" => $data,
		);

		echo json_encode($json);
	}

	public function ajax_list_deleted_advert() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$this->load->model("adverts_model");

		if ($this->session->userdata("id_user")) {
			$array_id_user = array("id_user" => $this->session->userdata("id_user"));
			$id_user = $array_id_user["id_user"];
			unset($array_id_user["id_user"]);

			$adverts = $this->adverts_model->get_datatable_deleted($id_user);
		}

		$data = array();

		foreach ($adverts as $advert) {

			$row = array();
			$row[] = $advert->advert_title;

			$temp_advert_img_path = explode(',', $advert->advert_img);
			$row[] = '<img src="'.base_url().$temp_advert_img_path[0].'" style="max-height: 100px; max-width: 100px;">';

			$row[] = $advert->state;
			$row[] = '<div class="description">'.$advert->advert_description.'</div>';

			$advert_datetime_formated = $advert->advert_datetime;
			$row[] = date('d/m/Y H:i', strtotime($advert_datetime_formated));
			
			if ($id_user == 1) {
				$advert_status_formated = $advert->advert_status;
				if ($advert_status_formated == 1) {
					$row[] = "Aprovado";
				} else {
					$row[] = "Em Aprovação";
				}

				$row[] = $advert->advert_count;
			
				$row[] = '<div style="display: inline-block;">
						<button class="btn btn-success btn-recycle-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-recycle"></i>
						</button>
						<button class="btn btn-warning btn-edit-deleted-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-edit"></i>
						</button>
						<button class="btn btn-danger btn-exclude-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-times"></i>
						</button>
						</div>';
			} else {
				$row[] = $advert->advert_count;
				$row[] = '<div style="display: inline-block;">
						<button class="btn btn-success btn-recycle-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-recycle"></i>
						</button>
						</div>';
			}

			$data[] = $row;

		}

		$json = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $this->adverts_model->records_total(),
			"recordsFiltered" => $this->adverts_model->records_filtered_deleted($id_user),
			"data" => $data,
		);

		echo json_encode($json);
	}

	public function ajax_list_user() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$this->load->model("users_model");
		$users = $this->users_model->get_datatable();

		$data = array();
		foreach ($users as $user) {

			$row = array();
			$row[] = $user->login_user;
			$row[] = $user->email_user;

			$user_date_formated = $user->register_date;
			$row[] = date('d/m/Y', strtotime($user_date_formated));

			$row[] = '<div style="display: inline-block;">
						<button class="btn btn-primary btn-edit-user" 
							id_user="'.$user->id_user.'">
							<i class="icon-edit"></i>
						</button>
						<button class="btn btn-danger btn-del-user" 
							id_user="'.$user->id_user.'">
							<i class="icon-times"></i>
						</button>
					</div>';

			$data[] = $row;

		}

		$json = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $this->users_model->records_total(),
			"recordsFiltered" => $this->users_model->records_filtered(),
			"data" => $data,
		);

		echo json_encode($json);
	}

}
