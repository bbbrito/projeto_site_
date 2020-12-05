<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index($id_city = NULL)
	{
		$this->load->model("adverts_model");

		$config = array (
					"base_url" => base_url("adverts/p"),//rota que deve ser utilizada nos links de paginação
					"per_page" => 2,//Identifica o número de registro a ser exibido por página
					"num_links" => 3, //Número de links que devem ser exibidos (1 a 10, 2 a 12 etc)
					"uri_segment" => 3,//Identifica o segmento da url que vai determinar o número da página onde os registros devem ser recuperados e exibidos. No base_url, adverts é o 1, p é o 2, e o uri é o 3.
					"total_rows" => $this->adverts_model->countAll($id_city),
					"full_tag_open" => "<ul class='pagination'>",
					"full_tag_close" => "</ul>",
					"first_link" => FALSE,
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
					"num_tag_close" => "</li>"
				);
		$this->pagination->initialize($config);
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$adverts = $this->adverts_model->show_adverts("id_advert", "desc", $config["per_page"], $offset, $id_city);
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
				"pagination" => $this->pagination->create_links(),//retorna o html completo de paginação
				"adverts" => $adverts
			);
			$this->template->show("home.php", $data, false);
	}


	/*private function a()
    {
    	$variavel = [];
    	$variavel[0] = $this->ajax_adverts_filter_show();

        return $variavel[0];
    }*/
	//Filtro por estado
	/*public function ajax_adverts_filter_show() {

		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();
		$json["status"] = 1;
	
		$id_state = $this->input->post("id_state");
		/*$this->load->library('../Home/Home_Filter_State');
		$this->Home_Filter_State->index($id_state);*/
		//$this->parser->parse('ajax/'+base_url(), $id_state);
		
		/*$json["state"] = $id_state;

		echo json_encode($json);
	}*/

	/*function _remap($method, $args){

	    if($method == "ajax_adverts_filter_show"){
	      $this->index($args);
	      //header("Refresh: 20 url=home/index");
	  	}
	    else
	      $this->index();
  }

  /*function _remap($method, $args) {

       if (method_exists($this, $method))
       {
            $this->Index($args);
       }
       else
       {
            $this->Index();
       }
	}*/


	public function ajax_filtered_adverts_city($id_city = NULL)
	{
		if (!$this->input->is_ajax_request()) {
			exit("Nenhum acesso de script direto permitido!");
		}

		$json = array();

		$this->load->model("adverts_model");
		$id_city = $this->input->post("id_city");

		$config = array (
					"base_url" => base_url("adverts/p"),//rota que deve ser utilizada nos links de paginação
					"per_page" => 2,//Identifica o número de registro a ser exibido por página
					"num_links" => 3, //Número de links que devem ser exibidos (1 a 10, 2 a 12 etc)
					"uri_segment" => 3,//Identifica o segmento da url que vai determinar o número da página onde os registros devem ser recuperados e exibidos. No base_url, adverts é o 1, p é o 2, e o uri é o 3.
					"total_rows" => $this->adverts_model->countAll($id_city),
					"full_tag_open" => "<ul class='pagination'>",
					"full_tag_close" => "</ul>",
					"first_link" => FALSE,
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
					"num_tag_close" => "</li>"
				);
		$this->pagination->initialize($config);
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$filtered_adverts_city = $this->adverts_model->show_adverts("id_advert", "desc", $config["per_page"], $offset, $id_city);
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
				"pagination" => $this->pagination->create_links(),//retorna o html completo de paginação
				"filtered_adverts_city" => $filtered_adverts_city
			);
			$this->load->view("home.php", $data, false);
			$this->template->show("home.php", $data, false);


		//$json["filtered_adverts_city"] = $filtered_adverts_city;
		/*$json["pagination"] = $data["pagination"];*/
		
		//return ($filtered_adverts_city);
		//echo $adverts;
		//echo json_encode($filtered_adverts_city);
		//return ("filtered_adverts_city");
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
		$this->adverts_model->update_advert_count($id_advert);

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


}
