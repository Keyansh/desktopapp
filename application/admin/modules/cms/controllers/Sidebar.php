<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sidebar extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index($offset = 0) {
        $this->load->model('Sidebarmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('pagination');
        
		//check resource
		if (!$this->checkAccess('MANAGE_MENU')) {
            $this->utility->accessDenied();
            return;
        }

        $perpage = 20;
        $config['base_url'] = base_url() . "cms/sidebar/index/";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Sidebarmodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        $menu = array();
        $menu = $this->Sidebarmodel->listAll($offset, $perpage);

        $inner = array();
        $inner['menu'] = $menu;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('sidebar/menu-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function add() {
        $this->load->model('Sidebarmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        
		//check resource
		if (!$this->checkAccess('MANAGE_MENU')) {
            $this->utility->accessDenied();
            return;
        }

        //Form Validations
        $this->form_validation->set_rules('menu_title', 'Menu Title', 'trim|required');
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('sidebar/menu-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Sidebarmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'menu_added');
            redirect('cms/sidebar/index', 'location');
            exit();
        }
    }

    function edit($mid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Sidebarmodel');
		
		if (!$this->checkAccess('MANAGE_MENU')) {
            $this->utility->accessDenied();
            return;
        }

        $menu = array();
        $menu = $this->Sidebarmodel->detail($mid);
        
        if (!$menu) {
            $this->utility->show404();
            return;
        }
        
		$this->form_validation->set_rules('menu_title', 'Menu Title', 'trim|required');
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['menu'] = $menu;
            $page['content'] = $this->load->view('sidebar/menu-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Sidebarmodel->updateRecord($menu);
            $this->session->set_flashdata('SUCCESS', 'menu_updated');
            redirect('cms/sidebar/index', 'location');
            exit();
        }
    }

    function delete($mid) {
        $this->load->model('Sidebarmodel');
		
		if (!$this->checkAccess('MANAGE_MENU')) {
            $this->utility->accessDenied();
            return;
        }
        
        $menu = array();
        $menu = $this->Sidebarmodel->detail($mid);
        
        if (!$menu) {
            $this->utility->show404();
            return;
        }

        $this->Sidebarmodel->deleteRecord($menu);
        $this->session->set_flashdata('SUCCESS', 'menu_deleted');
        redirect("cms/sidebar/index/");
        exit();
    }

}

?>