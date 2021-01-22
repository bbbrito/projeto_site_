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
		header("Location: " . base_url() . "home");
	}
	
	public function ajax_login() {
		
		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$email = $this->input->post("email");
		$password = $this->input->post("password");

		if (empty($email)) {
			$json["status"] = 0;
			$json["error_list"]["#email"] = "E-mail não pode ser vazio!";
		} else {
			$this->load->model("users_model");
			$result = $this->users_model->get_user_data($email);

			if ($result) {
				$id_user = $result->id_user;
				$password_hash = $result->password_hash;
				if (password_verify($password, $password_hash)) {
					if ($result->status == 0) {
						$json["status"] = 0;
						$json["error_list"]["#btn_login"] = "Ative seu cadastro pelo link enviado por e-mail!";
					} else {
						$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
						$userIp=$this->input->ip_address();    
		    			$secret = $this->config->item('SECRET_KEY');
					    $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;

					    $ch = curl_init();
					    curl_setopt($ch, CURLOPT_URL, $url); 
				        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				        $output = curl_exec($ch); 
				        curl_close($ch);      
				         
				        $status= json_decode($output, true);
				        if ($status['success']) {
				        	$this->session->set_userdata("id_user", $id_user);
							$this->session->set_userdata("username", $result->login_user);
				        } else {
				        	$json["status"] = 0;
				        	$json["error_list"]["#btn_login"] = "Captcha inválido! Atualize a página e tente novamente.";
				        }

						
					}
				} else {
					$json["status"] = 0;
					$json["error_list"]["#btn_login"] = "Usuário e/ou senha incorretos!";
				}
			} else {
				$json["status"] = 0;
				$json["error_list"]["#btn_login"] = "Usuário e/ou senha incorretos!";
			}
		}

		echo json_encode($json);

	}

		/**
     * Recebe o CEP via post e retorna os dados
     * consultados via JSON
     */
    public function consulta(){

    	$json = array();
		$json["status"] = 1;
		//$json["error_list"] = "";
		$json["zip_code"] = array();
    
        $cep = $this->input->post('cep');
        
        $this->load->library('curl');
        $data = $this->curl->consulta($cep);
        $obj = json_decode($data);

        if (isset($obj->erro)) {
        	$json["status"] = 0;
			$json["error_list"] = "CEP inválido!";
		} else {
			$json["zip_code"]["cidade"] = $obj->localidade;
			
			$json["zip_code"]["uf"] = $obj->uf; 
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
			//$json["img_view"] = '';
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
						/*$json["img_view"] .= '<li><img src=" '.base_url() . 'tmp/' . $data["file_name"].'" class="img-responsive img-thumbnail" class="remove" style="max-width: 100px; max-height: 100px;" /><i class="icon-delete"></i></li>';*/				
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
			if (!preg_match("/([a-zA-Z0-9])/", $data["advert_title"])){
				$json["error_list"]["#advert_title"] = "O título não deve conter caracteres especiais";
			}
		}

		if (empty($data["category"])){
			$json["error_list"]["#category"] = "Categoria do anúncio é obrigatória!";
		}

		if (empty($data["zip_code"])){
			$json["error_list"]["#zip_code"] = "CEP do anúncio é obrigatório!";
		}

		if (empty($data["city"])){
			$json["error_list"]["#city"] = "Cidade do anúncio é obrigatória!";
		}

		if (empty($data["state"])){
			$json["error_list"]["#state"] = "Estado do anúncio é obrigatório!";
		}

		if (empty($data["phone"])){
			$json["error_list"]["#phone"] = "O telefone para contato é obrigatório!";
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

	public function send_new_advert_email() {
		$this->load->library('email');
		$this->load->model("users_model");

		$id_user = $this->session->userdata("id_user");
		$data = $this->users_model->get_data($id_user)->result_array()[0];
		$to = $data["email_user"];
		$from = $this->config->item('EMAIL_COMPANY');
		      
        $this->email->set_mailtype("html");
		$this->email->from($from);
		$this->email->subject("Seu anúncio estará ativo em breve!");
		$this->email->to($to);
		$this->email->message("Obrigado por usar o Frete Aqui!<br>
Seu anúncio estará ativo em breve.<br>
Acompanhe o status do seu anúncio fazendo <a href= ".base_url() . "restrict>login!</a><br><br>
Para garantir recebimento dos nossos e-mails, adicione noreply@freteaqui.com aos seus contatos.<br>
Se você encontrar dificuldades contate o administrador: contato@freteaqui.com");
		$this->email->send();
		//$this->email->print_debugger();

	}

	public function ajax_save_user() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();
		$json["confirmation"] = array();

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
				} else {
					$json["confirmation"]["email_user"] = $data["email_user"];
				}
			}
		}

		if (empty($data["password_user"])){
			$json["error_list"]["#password_user"] = "A senha é obrigatória!";
		} else {
			if ($data["password_user"] != $data["password_user_confirm"]) {
				$json["error_list"]["#password_user"] = "";
				$json["error_list"]["#password_user_confirm"] = "Senhas não conferem!";
			} else {
				$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
				unset($data["g-recaptcha-response"]);
				$userIp=$this->input->ip_address();    
    			$secret = $this->config->item('SECRET_KEY');
			    $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;

			    $ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL, $url); 
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		        $output = curl_exec($ch); 
		        curl_close($ch);      
		         
		        $status= json_decode($output, true);
		        if (!$status['success']) {
        			$json["error_list"]["#btn_save_user"] = "Captcha inválido! Atualize a página e tente novamente.";
		        }
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
				date_default_timezone_set('America/Sao_Paulo');
				$data["register_date"] = date('Y-m-d H:i:s');
				$data["status"] = 0; //0 = em confirmação, 1 = confirmado
				$this->users_model->insert("users", $data);
				$json["confirmation"]["expire_date"] = date('Y-m-d H:i:s', strtotime('+1 day'));
				$json["confirmation"]["token"] = bin2hex(random_bytes(64));
				$this->users_model->insert("confirmation", $json["confirmation"]);
			} else{
				$id_user = $data["id_user"];
				unset($data["id_user"]);
				$this->users_model->update($id_user, $data);
			}
		}
		echo json_encode($json);
	}

	public function send_new_user_email() {
		$this->load->library('email');
		$this->load->model("users_model");

		$to = $this->input->post("email");
		$token = $this->input->post("token");
		$data = $this->users_model->get_login_data($to)->result_array()[0];
		$user = $data["login_user"];
		$from = $this->config->item('EMAIL_COMPANY');
		      
        $this->email->set_mailtype("html");
		$this->email->from($from);
		$this->email->subject("Confirmação de cadastro!");
		$this->email->to($to);
		$this->email->message("<strong>Cadastro no site Frete Aqui</strong><br>
Olá, " . $user. "!<br>Obrigado por se cadastrar no Frete Aqui!<br>Confirme seu e-mail <a href= ".base_url() . 'restrict/ajax_confirm_user/' . $to. '/' . $token. " >clicando aqui!</a><br><br>
Para garantir recebimento dos nossos e-mails, adicione noreply@freteaqui.com aos seus contatos.<br>
Se você encontrar dificuldades contate o administrador: contato@freteaqui.com");

		$this->email->send();
		//$this->email->print_debugger();

	}

	//Função criada para confirmar cadastro
	public function ajax_confirm_user() {

		/*if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}*/

		$this->load->model("users_model");

		$email = $this->uri->segment(3);
		$token = $this->uri->segment(4);
		date_default_timezone_set('America/Sao_Paulo');
		$now_date = date('Y-m-d H:i:s');

		if ($this->users_model->expire_link($email, $now_date) || !$this->users_model->confirmation_cad($email, $token)) {
			echo "
			<script>
			alert('Este link expirou!');
			window.location.href='".base_url()."restrict';
			</script>";
		} else {
			$this->users_model->active_cad($email);
			echo "
			<script>
			alert('Dados confirmados com sucesso!');
			window.location.href='".base_url()."restrict';
			</script>";
		}

		//$this->template->show("restrict.php");	
	}

	public function ajax_forgot_password() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();
		$json["confirmation"] = array();

		$this->load->model("users_model");

		$data = $this->input->post();

		if (empty($data["email_user_forgot"])){
			$json["error_list"]["#email_user_forgot"] = "O e-mail é obrigatório!";
		} else {
			if (!$this->users_model->is_duplicated("email_user", $data["email_user_forgot"])){
				$json["error_list"]["#email_user_forgot"] = "E-mail não cadastrado!";
			} else {
				if ($data["email_user_forgot"] != $data["email_user_forgot_confirm"]) {
					$json["error_list"]["#email_user_forgot"] = "";
					$json["error_list"]["#email_user_forgot_confirm"] = "E-mails não conferem!";
				} else {
					$json["confirmation"]["email_user"] = $data["email_user_forgot"];
					unset($data["email_user_forgot_confirm"]);

					$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
					$userIp=$this->input->ip_address();    
        			$secret = $this->config->item('SECRET_KEY');
				    $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;

				    $ch = curl_init();
				    curl_setopt($ch, CURLOPT_URL, $url); 
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			        $output = curl_exec($ch); 
			        curl_close($ch);      
			         
			        $status= json_decode($output, true);
			        if (!$status['success']) {
            			$json["error_list"]["#btn_forgot_password"] = "Captcha inválido! Atualize a página e tente novamente.";
			        }
				   
						
				}
			}
			
		} 

		if(!empty($json["error_list"])){
			$json["status"] = 0;
		} else {			
			$json["confirmation"]["token"] = bin2hex(random_bytes(64));
			date_default_timezone_set('America/Sao_Paulo');
			$json["confirmation"]["expire_date"] = date('Y-m-d H:i:s', strtotime('+1 day'));
			$this->users_model->insert("confirmation", $json["confirmation"]);			
		}
		echo json_encode($json);
	}

	public function send_new_password_email() {
		$this->load->library('email');

		$to = $this->input->post("email");
		$token = $this->input->post("token");
        $from = $this->config->item('EMAIL_COMPANY');
		      
        $this->email->set_mailtype("html");
		$this->email->from($from);
		$this->email->subject("Redefinição de senha!");
		$this->email->to($to);
		$this->email->message("<strong>Cadastro de nova senha</strong><br>
Recebemos uma tentativa de redefinição de senha para este e-mail. Caso não tenha sido você, desconsidere este e-mail, caso contrário, cadastre sua nova senha <div id='btn_new_password'><a href= ".base_url() . 'password/index/' . $to. '/' . $token. " >clicando aqui!</a>");

		$this->email->send();
		//$this->email->print_debugger();

	}

	//Função criada para confirmar o cadastro de nova senha
	public function ajax_confirm_new_password() {

		/*if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}*/

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();
		$json["confirmation"] = array();

		$this->load->model("users_model");

		/*$email = $this->uri->segment(3);
		$token = $this->uri->segment(4);*/

		$json["confirmation"]["email_user"] = $this->uri->segment(3);
		$json["confirmation"]["token"] = $this->uri->segment(4);
		
		echo "		
		<script>
		window.location.href='".base_url()."restrict';
		$(document).ready(function() {
    		$('#modal_password').modal('show');
		});
		</script>";
		/*if($this->users_model->confirmation_cad($email, $token)) {
			echo "
			<script>
			window.location.href='".base_url()."restrict';
			function getNewPassword() {
				$('#form_password')[0].reset();
				$('#modal_password').modal();
				$('#email_user_confirm').val(".$email.");
			} getNewPassword();			
			</script>";
			//document.getElementById('email_user_confirm').value = $email;			  
			} else {
			echo "
			<script>
			alert('Não foi possível confirmar seus dados!');
			window.location.href='".base_url()."restrict';
			</script>";
		}*/
		//echo json_encode($json);	
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
		$json["input"]["phone"] = $data["phone"];
		$json["input"]["advert_description"] = $data["advert_description"];

		$temp_advert_img_view = explode(',', $data["advert_img"]);
		//$json["img"]["advert_img_view_thumb"] = '';
		//$json["img"]["img_path_temp"] = '';
		for ($i=0; $i < count($temp_advert_img_view); $i++) { 
			/*$json["img"]["advert_img_view_thumb"] .= '<li><img src=" '.base_url() . $temp_advert_img_view[$i].'" class="img-responsive img-thumbnail" style="max-width: 100px; max-height: 100px;" /></li>';*/
			$json["img"]["img_path_temp"][$i] = base_url() . $temp_advert_img_view[$i];
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

	public function send_delete_advert_email() {
		$this->load->library('email');

		$this->load->model("users_model");
		$id_user = $this->session->userdata("id_user");
		$data = $this->users_model->get_data($id_user)->result_array()[0];
		$to = $data["email_user"];

		$this->load->model("adverts_model");
		$id_advert = $this->input->post("id_advert");
		$data = $this->adverts_model->get_data($id_advert)->result_array()[0];
		$title = $data["advert_title"];

		$from = $this->config->item('EMAIL_COMPANY');
		      
        $this->email->set_mailtype("html");
		$this->email->from($from);
		$this->email->subject("Anúncio excluído!");
		$this->email->to($to);
		$this->email->message("Seu anúncio $title foi excluído conforme solicitado.
Ele poderá ser excluído definitivamente de nossa base de dados a qualquer momento.
Enquanto isso não acontece, você poderá restaurá-lo.
Acompanhe o status do seu anúncio fazendo login!
Obrigado por anunciar conosco!");
		$this->email->send();
		//$this->email->print_debugger();

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

	public function send_approve_advert_email() {
		$this->load->library('email');
		$this->load->model("adverts_model");
		$this->load->model("users_model");

		$id_advert = $this->input->post("id_advert");
		$data_advert = $this->adverts_model->get_data($id_advert)->result_array()[0];
		$title = $data_advert["advert_title"];
		$id_user = $data_advert["id_user_fk"];		
		$data_user = $this->users_model->get_data($id_user)->result_array()[0];
		$to = $data_user["email_user"];
		$from = $this->config->item('EMAIL_COMPANY');
		      
        $this->email->set_mailtype("html");
		$this->email->from($from);
		$this->email->subject("Anúncio aprovado!");
		$this->email->to($to);
		$this->email->message("Seu anúncio $title foi aprovado e já está disponível para visualização.
			");
		$this->email->send();
		//$this->email->print_debugger();

	}

	public function ajax_disapproved_advert_data() {
		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;		

		$this->load->model("adverts_model");
		$this->load->model("users_model");

		$id_advert = $this->input->post("id_advert");
		$data_advert = $this->adverts_model->get_data($id_advert)->result_array()[0];
		$json["title"] = $data_advert["advert_title"];
		$id_user = $data_advert["id_user_fk"];		
		$data_user = $this->users_model->get_data($id_user)->result_array()[0];
		$json["to"] = $data_user["email_user"];
		$this->adverts_model->delete($id_advert);		

		echo json_encode($json);
	}

	public function send_disapproved_advert_email() {
		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->library('email');

		$title = $this->input->post("title");
		$to = $this->input->post("to");
		$from = $this->config->item('EMAIL_COMPANY');
		
		$this->email->set_mailtype("html");
		$this->email->from($from);
		$this->email->subject("Anúncio reprovado!");
		$this->email->to($to);
		$this->email->message("Seu anúncio $title foi reprovado por ir contra nossos Termos de Uso.
			Verifique nossos Termos de Uso em nosso <a href= ".base_url() . "restrict>site</a> e anuncie novamente!");
		$this->email->send();
		$this->email->clear();
		//$this->email->print_debugger();

	}

	public function ajax_exclude_advert_data() {
		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("adverts_model");
		$this->load->model("users_model");

		$id_advert = $this->input->post("id_advert");
		$data_advert = $this->adverts_model->get_data($id_advert)->result_array()[0];
		$json["title"] = $data_advert["advert_title"];		
		$id_user = $data_advert["id_user_fk"];		
		$data_user = $this->users_model->get_data($id_user)->result_array()[0];
		$json["to"] = $data_user["email_user"];
		$this->adverts_model->delete($id_advert);

		echo json_encode($json);
	}

	public function send_exclude_advert_email() {
		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->library('email');

		$title = $this->input->post("title");
		$to = $this->input->post("to");
		$from = $this->config->item('EMAIL_COMPANY');
		      
        $this->email->set_mailtype("html");
		$this->email->from($from);
		$this->email->subject("Anúncio excluído definitivamente!");
		$this->email->to($to);
		$this->email->message("Seu anúncio $title foi excluído definitivamente da nossa base de dados.
Obrigado por anunciar conosco!");
		$this->email->send();
		$this->email->clear();
		//$this->email->print_debugger();
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

	public function send_recycle_advert_email() {
		$this->load->library('email');
		$this->load->model("users_model");
		$this->load->model("adverts_model");

		$id_advert = $this->input->post("id_advert");
		$data_advert = $this->adverts_model->get_data($id_advert)->result_array()[0];
		$title = $data_advert["advert_title"];

		$id_user = $this->session->userdata("id_user");
		$data_user = $this->users_model->get_data($id_user)->result_array()[0];
		$to = $data_user["email_user"];
		$from = $this->config->item('EMAIL_COMPANY');
		      
        $this->email->set_mailtype("html");
		$this->email->from($from);
		$this->email->subject("Anúncio restaurado!");
		$this->email->to($to);
		$this->email->message("Seu anúncio $title foi restaurado e já está disponível para visualização.
Obrigado por anunciar conosco!");
		$this->email->send();
		//$this->email->print_debugger();

	}

	public function ajax_approve_all_advert_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["titles"] = array();
		$json["tos"] = array();

		$this->load->model("adverts_model");
		$this->load->model("users_model");

		if ($this->session->userdata("id_user")) {
			$array_id_user = array("id_user" => $this->session->userdata("id_user"));
			$id_user = $array_id_user["id_user"];
			unset($array_id_user["id_user"]);

			$adverts = $this->adverts_model->get_datatable_pendent($id_user);
		}

		foreach ($adverts as $advert) {
			$id_advert = $advert->id_advert;
			$this->adverts_model->update_approve($id_advert);
			$data_advert = $this->adverts_model->get_data($id_advert)->result_array()[0];
			$title = $data_advert["advert_title"];			
			$id_user = $data_advert["id_user_fk"];			
			$data_user = $this->users_model->get_data($id_user)->result_array()[0];
			$to = $data_user["email_user"];
			array_push($json["titles"], $title);
			array_push($json["tos"], $to);
		}
		echo json_encode($json);
	}

	public function send_approve_all_advert_email() {
		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->library('email');

		$titles = $this->input->post("titles");
		$tos = $this->input->post("tos");
		$from = $this->config->item('EMAIL_COMPANY');

		foreach(array_combine(explode(",", $titles), explode(",", $tos)) as $title => $to) {	      
			$this->email->from($from);		
			$this->email->subject("Anúncio aprovado!");
			$this->email->to($to);
			$this->email->message("Seu anúncio $title foi aprovado e já está disponível para visualização.");
			$this->email->send();
			$this->email->clear();
			//$this->email->print_debugger();
		}
		echo json_encode($json);
	}

	public function ajax_exclude_all_advert_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["titles"] = array();
		$json["tos"] = array();

		$this->load->model("adverts_model");
		$this->load->model("users_model");

		if ($this->session->userdata("id_user")) {
			$array_id_user = array("id_user" => $this->session->userdata("id_user"));
			$id_user = $array_id_user["id_user"];
			unset($array_id_user["id_user"]);

			$adverts = $this->adverts_model->get_datatable_deleted($id_user);
		}

		foreach ($adverts as $advert) {
			$id_advert = $advert->id_advert;

			$data_advert = $this->adverts_model->get_data($id_advert)->result_array()[0];
			$title = $data_advert["advert_title"];
			$id_user = $data_advert["id_user_fk"];
			$data_user = $this->users_model->get_data($id_user)->result_array()[0];
			$to = $data_user["email_user"];
			$this->adverts_model->delete($id_advert);
			array_push($json["titles"], $title);
			array_push($json["tos"], $to);

		}
		echo json_encode($json);
	}

	public function send_exclude_all_advert_email() {
		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->library('email');

		$titles = $this->input->post("titles");
		$tos = $this->input->post("tos");
		$from = $this->config->item('EMAIL_COMPANY');

		foreach(array_combine(explode(",", $titles), explode(",", $tos)) as $title => $to) {	
			$this->email->from($from);
			$this->email->subject("Anúncio excluído definitivamente!");
			$this->email->to($to);
			$this->email->message("Seu anúncio $title foi excluído definitivamente da nossa base de dados.
Obrigado por anunciar conosco!");
			$this->email->send();
			$this->email->clear();
			//$this->email->print_debugger();
		}
		echo json_encode($json);
	}

	public function ajax_list_advert() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$this->load->model("adverts_model");
		$this->load->model("users_model");
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

			if ($id_user == 1) {
				$id_user_advert = $advert->id_user_fk;
					$user_name = $this->users_model->get_data($id_user_advert, "login_user")->result_array()[0];			
				$row[] = $user_name["login_user"];
			}

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
		$this->load->model("users_model");

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
				$id_user_advert = $advert->id_user_fk;
				$user_name = $this->users_model->get_data($id_user_advert, "login_user")->result_array()[0];			
				$row[] = $user_name["login_user"];

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
		$this->load->model("users_model");

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

				$id_user_advert = $advert->id_user_fk;
				$user_name = $this->users_model->get_data($id_user_advert, "login_user")->result_array()[0];			
				$row[] = $user_name["login_user"];
			
				$row[] = '<div style="display: inline-block;">
						<button class="btn btn-success btn-recycle-advert" 
							id_advert="'.$advert->id_advert.'">
							<i class="icon-recycle"></i>
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

			$temp_status = $user->status;
			switch ($temp_status) {
			  case 0:
			    $row[] = "Em confirmação";
			    break;
			  case 1:
			    $row[] = "Ativo";
			    break;
			  case 2:
			    $row[] = "Banido";
			    break;
			  default:
			    $row[] = "Null";
			}

			$row[] = '<div style="display: inline-block;">
						<button class="btn btn-warning btn-edit-user" 
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

	public function ajax_delete_user_data() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("users_model");
		$id_user = $this->input->post("id_user");
		$data = $this->users_model->get_data($id_user, "status")->result_array()[0];
		if ($data["status"] == 1) {
			$this->load->model("adverts_model");
			$this->adverts_model->update_delete_ban($id_user);
		}
		$this->users_model->delete($id_user, $data["status"]);

		echo json_encode($json);
	}


}
