<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index()
	{		
		$data = array(
				"scripts" => array(
					"jquery.min.js",
					"util.js",
					"login.js"
				)
			);
			$this->template->show("password.php", $data);
	}

	public function ajax_save_new_password() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$this->load->model("users_model");
		$data = $this->input->post();

		$timezone = new DateTimeZone('America/Sao_Paulo');
		date_default_timezone_set('America/Sao_Paulo');
		$now_date = date('Y-m-d H:i:s');

		if (empty($data["email_new_password"])){
			$json["error_list"]["#email_new_password"] = "O e-mail é obrigatório!";
		} else {
			$data["email_user"] = $data["email_new_password"];
			unset($data["email_new_password"]);
			if (!$this->users_model->is_duplicated("email_user", $data["email_user"])){
				$json["error_list"]["#email_new_password"] = "E-mail não cadastrado!";
			} else if ($this->users_model->expire_link($data["email_user"], $now_date) || !$this->users_model->confirmation_cad($data["email_user"], $data["token_new_password"])) {
					$json["status"] = 2;
			}
		}

		if (empty($data["new_password_user"])){
			$json["error_list"]["#new_password_user"] = "A senha é obrigatória!";
		} else if($data["new_password_user"] != $data["new_password_user_confirm"]){
			$json["error_list"]["#new_password_user"] = "";
			$json["error_list"]["#new_password_user_confirm"] = "Senhas não conferem!";
		}

		if(!empty($json["error_list"])){
			$json["status"] = 0;
		} else {

			$data["password_hash"] = password_hash($data["new_password_user"], PASSWORD_DEFAULT);

			unset($data["link_date"]);
			unset($data["new_password_user"]);
			unset($data["new_password_user_confirm"]);
			unset($data["token_new_password"]);

			$this->users_model->update_password($data["email_user"], $data["password_hash"]);
			
		}
		echo json_encode($json);
	}

}
