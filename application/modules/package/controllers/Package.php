<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Package extends Module_Controller {

	function __construct() {
		parent::__construct();
	}
	
	//**************************************validation start**********************************
    function valid_show($str) {
        $this->db->where('show_code', $str);
        $query = $this->db->get('show');
        if ($query->num_rows() != 1) {
            $this->form_validation->set_message('valid_show', 'No Match found!');
            return false;
        }

        return true;
    }
	
	//*************************************validation End***************************************

	function index($alias = false, $cart_id = false) {
		$this->load->model('Packagemodel');
		$this->load->model('catalog/Cartmodel');
		$this->load->model('catalog/Attributesmodel');
		$this->load->helper('text');
		$this->load->helper('form');
		$this->load->library('form_validation');

		//Fetch Package Details
		$package = array();
		$package = $this->Packagemodel->fetchByAlias($alias);
		if (!$package) {
			$this->utility->show404();
			return;
		}

		//fetch all package products
		$products = array();
		$products = $this->Packagemodel->listAllPackageProducts($package);

		$this->form_validation->set_rules('buy', 'Buy', 'trim');

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		if ($this->form_validation->run() == FALSE) {

			//render view
			$inner = array();
			$shell = array();
			$inner['package'] = $package;
			$inner['products'] = $products;
			$inner['cart_id'] = $cart_id;
			$shell['contents'] = $this->load->view('package-details', $inner, true);
			$this->load->view("themes/" . THEME . "/templates/default.php", $shell);
		} else {

			//inser into cart
			$this->Cartmodel->insertPackage($package, $cart_id);
			$this->session->set_flashdata('SUCCESS', 'item_added');

			redirect("catalog/cart/index", "location");
			exit();
		}
	}

	function remove() {
		$this->session->unset_userdata('VIEWED_PRODUCTS');
		redirect(base_url());
		exit();
	}

	function show() {
		$this->load->model('Packagemodel');
		$this->load->helper('text');
		$this->load->helper('form');
		$this->load->library('form_validation');

		//fetch show
		$show = array();
		if ($this->input->post('show', TRUE))
			$show = $this->Packagemodel->getShowDetail($this->input->post('show', TRUE));

		//validation check
		$this->form_validation->set_rules('show', 'Show', 'trim|required|callback_valid_show');
		$this->form_validation->set_error_delimiters('<li>', '</li>');

		//Render View
		if ($this->form_validation->run() == FALSE) {
			redirect(base_url());
			exit();
		} else {
			$packages = array();
			$packages = $this->Packagemodel->getPackages($show);

			//render view
			$inner = array();
			$inner['show'] = $show;
			$inner['packages'] = $packages;
			$shell = array();
			$shell['contents'] = $this->load->view('package-listing', $inner, true);
			$this->load->view("themes/" . THEME . "/templates/default", $shell);
		}
	}

}

?>