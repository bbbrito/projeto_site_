<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library("session");
		$this->load->helper('url');
		$this->load->library('user_agent');
		$this->load->library("ajax_pagination");
		$this->load->model("adverts_model");
		$this->per_page = 12;
	}

	public function index()	{
		//Get record count
		if ($this->agent->browser() == 'Internet Explorer' and $this->agent->version() <= 11) {
			$this->template->show("posts/unsupported_browser");
		}

		else {
			$conditions["returnType"] = 'count'; 
	        $totalRec = $this->adverts_model->getRows($conditions);

			//Pagination configuration
			$config = array (
						'target' => "#advertList",
						'base_url' => base_url("posts/ajax_search_data"),//rota que deve ser utilizada nos links de paginação
						'total_rows' => $totalRec,
						'per_page' => $this->per_page,//Identifica o número de registro a ser exibido por página
						'link_func' => "searchFilter",
						
						//"num_links" => 3, //Número de links que devem ser exibidos (1 a 10, 2 a 12 etc)
						//"uri_segment" => 3,//Identifica o segmento da url que vai determinar o número da página onde os registros devem ser recuperados e exibidos. No base_url, adverts é o 1, p é o 2, e o uri é o 3.
						"full_tag_open" => "<ul class='pagination'>",
						"full_tag_close" => "</ul>",
						"first_link" => "Primeira",
						"last_link" => FALSE,
						"first_tag_open" => "<li>",
						"first_tag_close" => "</li>",
						"prev_link" => "Anterior",
						"prev_tag_open" => "<li class='prev'>",
						"prev_tag_close" => "</li>",
						"next_link" => "Próxima",
						"next_tag_open" => "<li class='next'>",
						"next_tag_close" => "</li>",
						"last_tag_open" => "<li>",
						"last_tag_close" => "</li>",
						"cur_tag_open" => "<li class='active'><a href='#'>",
						"cur_tag_close" => "</a></li>",
						"num_tag_open" => "<li>",
						"num_tag_close" => "</li>",
						"show_count" => FALSE
					);
			//Initialize pagination library
			$this->ajax_pagination->initialize($config);
			//Get records
			$conditions = array('limit' => $this->per_page);
			$data = array(
					"styles" => array(
						"bootstrap.css",
						//"wing.min.css",
					),
					"scripts" => array(
						"jquery.min.js",
						//"bootstrap.min-3.4.1",
						//"jquery-3.5.1.js",
						//"jquery.easing.1.3.js",
						//"bootstrap.min.js",
						"jquery.waypoints.min.js",
						"owl.carousel.min.js",
						"main.js",
						"util.js",
						"home.js"
					),
					//"pagination" => $this->ajax_pagination->create_links(),//retorna o html completo de paginação
					'adverts' => $this->adverts_model->getRows($conditions)
				);
			$this->template->show("posts/home", $data);
		}
	}

	function ajax_search_data() {
		//Define offset
		$page = $this->input->post("page");
		if(!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}
		//Set conditions for search and filter
		$keywords = $this->input->post("keywords");
		$sortBy = $this->input->post("sortBy");
		if (!empty($keywords)) {
			$conditions["search"]["keywords"] = $keywords;
		}
		if (!empty($sortBy)) {
			$conditions["search"]["sortBy"] = $sortBy;
		}
		//Get record count
		$conditions["returnType"] = "count";
		$totalRec = $this->adverts_model->getRows($conditions);
		//Pagination configuration
		$config = array (
					'target' => "#advertList",
					'base_url' => base_url("posts/ajax_search_data"),//rota que deve ser utilizada nos links de paginação
					'total_rows' => $totalRec,
					'per_page' => $this->per_page,//Identifica o número de registro a ser exibido por página
					'link_func' => "searchFilter",				
					//"num_links" => 3, //Número de links que devem ser exibidos (1 a 10, 2 a 12 etc)
					//"uri_segment" => 3,//Identifica o segmento da url que vai determinar o número da página onde os registros devem ser recuperados e exibidos. No base_url, adverts é o 1, p é o 2, e o uri é o 3.
					//"total_rows" => $totalRec,
					"full_tag_open" => "<ul class='pagination'>",
					"full_tag_close" => "</ul>",
					"first_link" => "Primeira",
					"last_link" => FALSE,
					"first_tag_open" => "<li>",
					"first_tag_close" => "</li>",
					"prev_link" => "Anterior",
					"prev_tag_open" => "<li class='prev'>",
					"prev_tag_close" => "</li>",
					"next_link" => "Próxima",
					"next_tag_open" => "<li class='next'>",
					"next_tag_close" => "</li>",
					"last_tag_open" => "<li>",
					"last_tag_close" => "</li>",
					"cur_tag_open" => "<li class='active'><a href='#'>",
					"cur_tag_close" => "</a></li>",
					"num_tag_open" => "<li>",
					"num_tag_close" => "</li>",
					"show_count" => FALSE
				);
		//Initialize pagination library
		$this->ajax_pagination->initialize($config);
		//Get records
		$conditions['start'] = $offset; 
        $conditions['limit'] = $this->per_page; 
        unset($conditions['returnType']); 
		$data = array(
				"styles" => array(
					"bootstrap.css",
					//"wing.min.css",
				),
				"scripts" => array(
					"jquery.min.js",
					//"bootstrap.min-3.4.1",
					//"jquery-3.5.1.js",
					//"jquery.easing.1.3.js",
					//"bootstrap.min.js",
					"jquery.waypoints.min.js",
					"owl.carousel.min.js",
					"main.js",
					"util.js",
					"home.js"
				),
				//"pagination" => $this->ajax_pagination->create_links(),//retorna o html completo de paginação
				"adverts" => $this->adverts_model->getRows($conditions)
			);
		//unset($conditions["start"]);
		$this->template->show("posts/home_search.php", $data, false);
	}
		
	//Adiciona número de visualizações do anúncio
	public function ajax_views_count() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;

		$this->load->model("adverts_model");
		$id_advert = $this->input->post("id_advert");
		if ($this->session->userdata("id_user")!== null) {
			$id_user = $this->session->userdata("id_user");
			if($this->adverts_model->is_duplicated("id_user_fk", $id_user, $id_advert)){
				$this->adverts_model->update_advert_count($id_advert);
			}
		} else {
			$this->adverts_model->update_advert_count($id_advert);
		}

		echo json_encode($json);
	}

	//Função criada para mostrar anúncio no modal com carousel
	public function ajax_get_advert_data_modal() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
		$json["input"] = array();

		$this->load->model("adverts_model");

		$id_advert = $this->input->post("id_advert");
		$data = $this->adverts_model->get_data($id_advert)->result_array()[0];

		$advert_img_path = explode(',', $data["advert_img"]);
		$json["img"]["advert_data_slide_to"] = '';
		$json["img"]["advert_img_path_item"] = '';
		for ($i=0; $i < count($advert_img_path); $i++) { 
			$json["img"]["advert_data_slide_to"] .= '<li data-target="#faqui-carousel-'.$id_advert.'" data-slide-to="'. $i . '"></li>';

			$json["img"]["advert_img_path_item"] .= '<div class="item"><img src="'.base_url() . $advert_img_path[$i] . '" class="img-advert-modal center-block" alt="Foto do veículo" >   </div>';
        }   
		echo json_encode($json);
	}

	//Função criada para mostrar lista horizontal de cidades
	function ajax_list_city_data() {
		
		$this->load->model("adverts_model");
		$state = $this->input->post("id_state");

		$data = $this->adverts_model->get_cities($state)->result_array();
		$html = '';

		if($data == NULL){
			$html .= '<li class="slider-item item-visible"><a href="'.base_url(). 'restrict'.'" class="slab2-text"> Nenhum anúncio cadastrado neste Estado. Clique aqui e seja o primeiro a anunciar! </a></li>';
		} else {
			for ($i=0; $i < count($data); $i++) { 
				$html .= '<li id="'.$data[$i]['city'].'" class="slider-item"><a href="#" class="slab2-text" title="'.$data[$i]['city'].'" style="display: block;" > '.$data[$i]['city'].' </a></li>';				
        	}
		}
		echo $html;
	}

	//Filtro por cidade e categoria
	function ajax_filter_city_data() {
		//Define offset
		$page = $this->input->post("page");
		if(!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}
		//Set conditions for search and filter
		$city = $this->input->post("id_city");
		$category = $this->input->post("category");

		if (!empty($city)) {
			$conditions["where"]["city"] = $city;
		}
		if (!empty($category)) {
			$conditions["where"]["category"] = $category;
		}
		//Set conditions for search and filter
		$sortBy = $this->input->post("sortBy");
		if (!empty($sortBy)) {
			$conditions["search"]["sortBy"] = $sortBy;
		}

		//Get record count
		$conditions["returnType"] = "count";
		$totalRec = $this->adverts_model->getRows($conditions);

		//Pagination configuration
		$config = array (
					'target' => "#advertList",
					'base_url' => base_url("posts/ajax_filter_city_data"),//rota que deve ser utilizada nos links de paginação
					'total_rows' => $totalRec,
					'per_page' => $this->per_page,//Identifica o número de registro a ser exibido por página
					'link_func' => "cityFilter",
						
					//"num_links" => 3, //Número de links que devem ser exibidos (1 a 10, 2 a 12 etc)
					//"uri_segment" => 3,//Identifica o segmento da url que vai determinar o número da página onde os registros devem ser recuperados e exibidos. No base_url, adverts é o 1, p é o 2, e o uri é o 3.
					//"total_rows" => $totalRec,
					"full_tag_open" => "<ul class='pagination'>",
					"full_tag_close" => "</ul>",
					"first_link" => "Primeira",
					"last_link" => FALSE,
					"first_tag_open" => "<li>",
					"first_tag_close" => "</li>",
					"prev_link" => "Anterior",
					"prev_tag_open" => "<li class='prev'>",
					"prev_tag_close" => "</li>",
					"next_link" => "Próxima",
					"next_tag_open" => "<li class='next'>",
					"next_tag_close" => "</li>",
					"last_tag_open" => "<li>",
					"last_tag_close" => "</li>",
					"cur_tag_open" => "<li class='active'><a href='#'>",
					"cur_tag_close" => "</a></li>",
					"num_tag_open" => "<li>",
					"num_tag_close" => "</li>",
					"show_count" => FALSE
		);
		//Initialize pagination library
		$this->ajax_pagination->initialize($config);

		//Get records
		$conditions['start'] = $offset; 
        $conditions['limit'] = $this->per_page; 
        unset($conditions['returnType']); 

		$data = array(
				"styles" => array(
					"bootstrap.css",
					//"wing.min.css",
				),
				"scripts" => array(
					"jquery.min.js",
					//"bootstrap.min-3.4.1",
					//"jquery-3.5.1.js",
					//"jquery.easing.1.3.js",
					//"bootstrap.min.js",
					"jquery.waypoints.min.js",
					"owl.carousel.min.js",
					"main.js",
					"util.js",
					"home.js"
				),
				//"pagination" => $this->ajax_pagination->create_links(),//retorna o html completo de paginação
				"adverts" => $this->adverts_model->getRows($conditions)
		);
		//unset($conditions["start"]);
		$this->template->show("posts/home_filter_city.php", $data, false);
	}

	
}
