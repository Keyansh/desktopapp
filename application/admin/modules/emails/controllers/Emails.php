<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Emails extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }
    
    function valid_image($str) {
        if (!isset($_FILES['template_header']) || $_FILES['template_header']['size'] == 0 || $_FILES['template_header']['error'] != UPLOAD_ERR_OK) {
            $this->form_validation->set_message('valid_image', ' Template Header Field is required.');
            return FALSE;
        }
        $imginfo = @getimagesize($_FILES['template_header']['tmp_name']);

        if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
            $this->form_validation->set_message('valid_image', 'Only GIF, JPG and PNG images are accepted');
            return FALSE;
        }
        return TRUE;
    }

    function index() {
        $this->load->model('Emailsmodel');

        $emailtemplate = array();
        $emailtemplate = $this->Emailsmodel->listAll();
//        e($emailtemplate);

        $inner = array();
        $inner['emails'] = $emailtemplate;
        $page = array();
        $page['content'] = $this->load->view('emails-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add product attributes
    function add() {
        $this->load->model('Emailsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');


        //validation check
//        $this->form_validation->set_rules('v_image', 'Image', 'trim|required|callback_valid_image');
        $this->form_validation->set_rules('template_name', 'Template Name', 'trim|required');
        $this->form_validation->set_rules('template_alias', 'Template Alias', 'trim');
        $this->form_validation->set_rules('contents', 'Description', 'trim|required');
//        $this->form_validation->set_rules('footer_contents', 'Template Footer', 'trim');
//        $this->form_validation->set_rules('template_for', 'Template For', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('emails-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Emailsmodel->insertRecord();

            $this->session->set_flashdata('SUCCESS', 'template_added');

            redirect("emails");
            exit();
        }
    }

    //function edit product attributes
    function edit($eid) {
        $this->load->model('Emailsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //get attributes details
        $emailtemplate = array();
        $emailtemplate = $this->Emailsmodel->getDetails($eid);
    //    e($emailtemplate);
        if (!$emailtemplate) {
            $this->utility->show404();
            return;
        }

       //validation check
        $this->form_validation->set_rules('template_name', 'Template Name', 'trim|required');
        $this->form_validation->set_rules('template_alias', 'Template Alias', 'trim');
        $this->form_validation->set_rules('contents', 'Description', 'trim|required');
//        $this->form_validation->set_rules('footer_contents', 'Template Footer', 'trim');
//        $this->form_validation->set_rules('template_for', 'Template For', 'trim|required');


        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['template'] = $emailtemplate;
            $page = array();
            $page['content'] = $this->load->view('emails-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Emailsmodel->updateRecord($emailtemplate);

            $this->session->set_flashdata('SUCCESS', 'template_updated');

            redirect("emails");
            exit();
        }
    }

    //function delete
    function delete($eid) {
        $this->load->model('Emailsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //get emailtemplate details
        $emailtemplate = array();
        $emailtemplate = $this->Emailsmodel->getDetails($eid);
//        e($emailtemplate);
        if (!$emailtemplate) {
            $this->utility->show404();
            return;
        }
        $this->Emailsmodel->deleteRecord($emailtemplate);
        $this->session->set_flashdata('SUCCESS', 'template_deleted');
        redirect('emails');
        exit();
    }

}

?>