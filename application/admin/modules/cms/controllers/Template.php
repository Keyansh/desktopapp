<?php

class Template extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->is_admin_protected = TRUE;
	}

	//**************************validation start***************************
	//function valid template for add
	function valid_template($str) {
		$this->db->where('template_alias', $str);
		$this->db->from('page_template');
		$block_count = $this->db->count_all_results();
		if ($block_count != 0) {
			$this->form_validation->set_message('valid_template', 'Template Alias is already being used!');
			return false;
		}
		return true;
	}

	//function valid page template for edit
	function valid_template_e($str) {
		$this->db->where('template_alias', $str);
		$this->db->where('page_template_id !=', $this->input->post('page_template_id', true));
		$this->db->from('page_template');
		$block_count = $this->db->count_all_results();
		if ($block_count != 0) {
			$this->form_validation->set_message('valid_template_e', 'Template Alias is already being used!');
			return false;
		}
		return true;
	}

	//*************************************validation end**********************************************


	function index($offset = 0) {
		$this->load->model('Templatemodel');
		$this->load->library('pagination');
		$this->load->helper('text');

		if (!$this->checkAccess('MANAGE_TEMPLATE')) {
			$this->utility->accessDenied();
			return;
		}

		//Setup pagination
		$perpage = 50;
		$config['base_url'] = base_url() . "cms/template/index/";
		$config['uri_segment'] = 3;
		$config['total_rows'] = $this->Templatemodel->countAll();
		$config['per_page'] = $perpage;
		$this->pagination->initialize($config);

		//Get all Job
		$templates = array();
		$templates = $this->Templatemodel->listAll($offset, $perpage);

		//render view
		$inner = array();
		$inner['templates'] = $templates;
		$inner['pagination'] = $this->pagination->create_links();

		$page = array();
		$page['content'] = $this->load->view('cms/templates/listing', $inner, TRUE);
		$this->load->view('shell', $page);
	}

	//function add templates
	function add() {
		$this->load->model('Templatemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		if (!$this->checkAccess('MANAGE_TEMPLATE')) {
			$this->utility->accessDenied();
			return;
		}

		//validation check
		$this->form_validation->set_rules('template_name', 'Template Name', 'trim|required');
		$this->form_validation->set_rules('template_alias', 'Template Alias', 'trim|callback_valid_template');
		$this->form_validation->set_rules('template_contents', 'Contents', 'trim|required');
		$this->form_validation->set_rules('admin_modules', 'Admin Modules', 'trim');
		$this->form_validation->set_rules('front_modules', ' Frontend Modules', 'trim');

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$page = array();
			$page['content'] = $this->load->view('cms/templates/templates-add', $inner, TRUE);
			$this->load->view('shell', $page);
		} else {
			$this->Templatemodel->insertRecord();

			$this->session->set_flashdata('SUCCESS', 'template_added');

			redirect("cms/template", "location");
			exit();
		}
	}

	//function add templates
	function edit($tid = false) {
		$this->load->model('Templatemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		if (!$this->checkAccess('MANAGE_TEMPLATE')) {
			$this->utility->accessDenied();
			return;
		}

		//Get Page Details
		$template = array();
		$template = $this->Templatemodel->fetchByID($tid);
		if (!$template) {
			$this->utility->show404();
			return;
		}

		$file_path = '../application/views/themes/' . THEME . "/templates/".$template['template_alias'].'.php';
		$template_contents = '';
		if(file_exists($file_path)) {
			$template_contents = file_get_contents($file_path);
		}

		//validation check
		$this->form_validation->set_rules('template_name', 'Template Name', 'trim|required');
		$this->form_validation->set_rules('template_alias', 'Template Alias', 'trim|callback_valid_template_e');
		$this->form_validation->set_rules('template_contents', 'Contents', 'trim|required');
		$this->form_validation->set_rules('admin_modules', 'Admin Modules', 'trim');
		$this->form_validation->set_rules('front_modules', ' Frontend Modules', 'trim');

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['template'] = $template;
			$inner['template_contents'] = $template_contents;

			$page = array();
			$page['content'] = $this->load->view('cms/templates/templates-edit', $inner, TRUE);
			$this->load->view('shell', $page);
		} else {
			$this->Templatemodel->updateRecord($template);

			$this->session->set_flashdata('SUCCESS', 'template_updated');

			redirect("cms/template", "location");
			exit();
		}
	}

	function delete($tid = false) {
		$this->load->model('Templatemodel');
		$this->load->library('form_validation');
		$this->load->helper('form');

		if (!$this->checkAccess('MANAGE_TEMPLATE')) {
			$this->utility->accessDenied();
			return;
		}

		//Get Page Details
		$template = array();
		$template = $this->Templatemodel->fetchByID($tid);
		if (!$template) {
			$this->utility->show404();
			return;
		}

		$this->Templatemodel->deleteRecord($template);

		$this->session->set_flashdata('SUCCESS', 'template_deleted');

		redirect("cms/template", "location");
		exit();
	}

}

?>
