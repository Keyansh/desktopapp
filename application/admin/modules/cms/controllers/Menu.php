<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //**************************validation start***************************
    //function valid page block for add
    function valid_block($str) {
        $this->db->where('menu_alias', $str);
        $this->db->from('menu');
        $block_count = $this->db->count_all_results();
        if ($block_count != 0) {
            $this->form_validation->set_message('valid_menu', 'Menu Alias is already being used!');
            return false;
        }
        return true;
    }

    //function valid page block for edit
    function validBlock($str) {
        $this->db->where('menu_alias', $str);
        $this->db->where('block_id !=', $this->input->post('menu_id', true));
        $this->db->from('menu');
        $block_count = $this->db->count_all_results();
        if ($block_count != 0) {
            $this->form_validation->set_message('validMenu', 'Menu Alias is already being used!');
            return false;
        }
        return true;
    }

    //*************************************validation end**********************************************

    function index($offset = 0) {
        $this->load->model('Menumodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('pagination');
        
		//check resource
		if (!$this->checkAccess('MANAGE_MENU')) {
            $this->utility->accessDenied();
            return;
        }


        //Setup pagination
        $perpage = 20;
        $config['base_url'] = base_url() . "cms/menu/index/";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Menumodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //list all block
        $menu = array();
        $menu = $this->Menumodel->listAll($offset, $perpage);

        //render view
        $inner = array();
        $inner['menu'] = $menu;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('menus/menu-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //add menu
    function add() {
        $this->load->model('Menumodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        
		//check resource
		if (!$this->checkAccess('MANAGE_MENU')) {
            $this->utility->accessDenied();
            return;
        }

        //Form Validations
        $this->form_validation->set_rules('menu_title', 'Menu Title', 'trim');
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required');
        $this->form_validation->set_rules('menu_alias', 'Menu Alias', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('menus/menu-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Menumodel->insertRecord();

            $this->session->set_flashdata('SUCCESS', 'menu_added');

            redirect('cms/menu/index', 'location');
            exit();
        }
    }

    //function to edit record
    function edit($mid) {
		
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Menumodel');
		
		//check resource
		if (!$this->checkAccess('MANAGE_MENU')) {
            $this->utility->accessDenied();
            return;
        }

        //Get Menu Details
        $menu = array();
        $menu = $this->Menumodel->detail($mid);
        //print_r($menu); exit();
        if (!$menu) {
            $this->utility->show404();
            return;
        }
        //Form Validations
		$this->form_validation->set_rules('menu_title', 'Menu Title', 'trim');
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required');
        $this->form_validation->set_rules('menu_alias', 'Menu Alias', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['menu'] = $menu;

            $page['content'] = $this->load->view('menus/menu-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Menumodel->updateRecord($menu);

            $this->session->set_flashdata('SUCCESS', 'menu_updated');

            redirect('cms/menu/index', 'location');
            exit();
        }
    }

    //function to delete record
    function delete($mid) {
        $this->load->model('Menumodel');
		
		//check resource
		if (!$this->checkAccess('MANAGE_MENU')) {
            $this->utility->accessDenied();
            return;
        }
        
        //Get Menu Details
        $menu = array();
        $menu = $this->Menumodel->detail($mid);
        //print_r($menu); exit();
        if (!$menu) {
            $this->utility->show404();
            return;
        }

        $this->Menumodel->deleteRecord($menu);

        $this->session->set_flashdata('SUCCESS', 'menu_deleted');

        redirect("cms/menu/index/");
        exit();
    }

}

?>