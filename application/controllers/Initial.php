<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Initial extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library("session");
	}

	public function index()
	{		
		$data = array(
				"scripts" => array(
					"jquery.min.js",
					//"jquery-3.5.1.js",
					//"jquery.easing.1.3.js",
					//"bootstrap.min.js",
					"jquery.waypoints.min.js",
					"owl.carousel.min.js",
					"main.js"
				)
			);
			$this->template->show("initial.php", $data);
	}
}
