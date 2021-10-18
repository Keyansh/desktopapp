<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Casestudy extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //**************************************validation start*********************
    function valid_title($str) {
        $this->db->where('title', $str);
        $query = $this->db->get('casestudy');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('valid_title', 'Case Study Title Already Existing!');
            return false;
        }

        return true;
    }

    function check_title($str) {
        $this->db->where('title', $str);
        $this->db->where('casestudy_id !=', $this->input->post('casestudy_id'));
        $query = $this->db->get('casestudy');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_title', 'Case Study Title Already Existing!');
            return false;
        }
        return true;
    }

    function valid_image($str) {
        if (!isset($_FILES['image']) || $_FILES['image']['size'] == 0 || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $this->form_validation->set_message('valid_image', 'The Case Study Image field is required.');
            return FALSE;
        }
        $imginfo = @getimagesize($_FILES['image']['tmp_name']);

        if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
            $this->form_validation->set_message('valid_image', 'Only GIF, JPG and PNG images are accepted');
            return FALSE;
        }
        return TRUE;
    }

    function validImage($str) {
        if ($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == UPLOAD_ERR_OK) {

            $imginfo = @getimagesize($_FILES['image']['tmp_name']);
            if (!$imginfo) {
                $this->form_validation->set_message('validImage', 'Only image files are allowed');
                return false;
            }

            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
                $this->form_validation->set_message('validImage', 'Only GIF, JPG and PNG Images are accepted.');
                return FALSE;
            }
        }
        return TRUE;
    }

    //*************************************validation End********************************
    //function index
    function index($offset = 0) {
        $this->load->model('Casestudymodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //Setup pagination
        $perpage = 25;
        $config['base_url'] = base_url() . "casestudy/index/";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->Casestudymodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //Fetch Case Studies
        $casestudies = array();
        $casestudies = $this->Casestudymodel->listAll($offset, $perpage);


        //render view
        $inner = array();
        $inner['casestudies'] = $casestudies;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('casestudy-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        $this->load->model('Casestudymodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('title', 'Case Study Title', 'trim|required|callback_valid_title');
        $this->form_validation->set_rules('url_alias', 'URL Alias', 'trim|callback_valid_UrlAlias');
        $this->form_validation->set_rules('v_image', 'Image', 'trim|required|callback_valid_image');
        $this->form_validation->set_rules('contents', 'Description', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');


        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('casestudy-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Casestudymodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'casestudy_added');

            redirect("casestudy/index/", 'location');
            exit();
        }
    }

    //function edit
    function edit($cid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Casestudymodel');

        //Fetch Case Study Details
        $casestudy = array();
        $casestudy = $this->Casestudymodel->getdetails($cid);
        if (!$casestudy) {
            $this->utility->show404();
            return;
        }


        //validation check
        $this->form_validation->set_rules('title', 'Case Study Title', 'trim|required');
        $this->form_validation->set_rules('url_alias', 'URL Alias', 'trim');
        $this->form_validation->set_rules('image_v', 'Image', 'trim|callback_validImage');
        $this->form_validation->set_rules('contents', 'Description', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['casestudy'] = $casestudy;
            $page['content'] = $this->load->view('casestudy-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Casestudymodel->updateRecord($casestudy);

            $this->session->set_flashdata('SUCCESS', 'casestudy_updated');
            redirect("casestudy/index/", 'location');
            exit();
        }
    }

    //function delete
    function delete($cid) {
        $this->load->model('Casestudymodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch Case Study Details
        $casestudy = array();
        $casestudy = $this->Casestudymodel->getdetails($cid);
        if (!$casestudy) {
            $this->utility->show404();
            return;
        }

        $this->Casestudymodel->deleteRecord($casestudy);
        $this->session->set_flashdata('SUCCESS', 'casestudy_deleted');
        redirect('/casestudy/index/');
        exit();
    }

}

?>