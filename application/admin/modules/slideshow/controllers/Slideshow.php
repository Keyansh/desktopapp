<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Slideshow extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index($offset = false) {
        $this->load->model('Slideshowmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('pagination');
        
        if (!$this->checkAccess('MANAGE_SLIDESHOW')) {
            $this->utility->accessDenied();
            return;
        }

        //Setup pagination
        $perpage = 20;
        $config['base_url'] = base_url() . "slideshow/index/";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->Slideshowmodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //list all slide show
        $slideshows = array();
        $slideshows = $this->Slideshowmodel->listAll($offset, $perpage);

        //render view
        $inner = array();
        $inner['slideshows'] = $slideshows;

        $page = array();
        $page['content'] = $this->load->view('slideshows/slideshow-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function add() {
        $this->load->model('Slideshowmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        
        if (!$this->checkAccess('MANAGE_SLIDESHOW')) {
            $this->utility->accessDenied();
            return;
        }

        //validation
        //validation
        $this->form_validation->set_rules('slideshow_title', 'Slideshow', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('slideshows/slideshow-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Slideshowmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'slideshow_added');

            redirect("slideshow/index", "location");
            exit();
        }
    }

    //function edit slide image
    function edit($sid) {
        $this->load->model('Slideshowmodel');
        $this->load->helper('text');
        $this->load->library('form_validation');
        
        if (!$this->checkAccess('MANAGE_SLIDESHOW')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch slide show
        $slideshow = array();
        $slideshow = $this->Slideshowmodel->getDetail($sid);
        if (!$slideshow) {
            $this->utility->show404();
            return;
        }


        //validation check
        $this->form_validation->set_rules('slideshow_title', 'Slideshow', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //render view
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['slideshow'] = $slideshow;
            $page['content'] = $this->load->view('slideshows/slideshow-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Slideshowmodel->updateRecord($slideshow);
            $this->session->set_flashdata('SUCCESS', 'slideshow_updated');

            redirect("slideshow/index/");
            exit();
        }
    }

    //function to enable record
    function enable($sid) {
        $this->load->model('Slideshowmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        if (!$this->checkAccess('MANAGE_SLIDESHOW')) {
            $this->utility->accessDenied();
            return;
        }
        
        //fetch slide show
        $slideshow = array();
        $slideshow = $this->Slideshowmodel->getDetail($sid);
        if (!$slideshow) {
            $this->utility->show404();
            return;
        }

        $this->Slideshowmodel->enableRecord($slideshow);

        $this->session->set_flashdata('SUCCESS', 'slideshow_enable');

        redirect("slideshow/index/");
        exit();
    }

    //function to disable record
    function disable($sid) {
        $this->load->model('Slideshowmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        if (!$this->checkAccess('MANAGE_SLIDESHOW')) {
            $this->utility->accessDenied();
            return;
        }

        ///fetch slide show
        $slideshow = array();
        $slideshow = $this->Slideshowmodel->getDetail($sid);
        if (!$slideshow) {
            $this->utility->show404();
            return;
        }

        $this->Slideshowmodel->disableRecord($slideshow);

        $this->session->set_flashdata('SUCCESS', 'slideshow_updated');

        redirect("/slideshow/index/");
        exit();
    }

    function delete($sid) {
        $this->load->model('Slideshowmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        if (!$this->checkAccess('MANAGE_SLIDESHOW')) {
            $this->utility->accessDenied();
            return;
        }

        ///fetch slide show
        $slideshow = array();
        $slideshow = $this->Slideshowmodel->getDetail($sid);
        if (!$slideshow) {
            $this->utility->show404();
            return;
        }

        $this->Slideshowmodel->deleteRecord($slideshow);

        $this->session->set_flashdata('SUCCESS', 'slideshow_deleted');

        redirect("/slideshow/index/");
        exit();
    }

}

?>