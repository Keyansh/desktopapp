<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Certification extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }


    //function index
    function index() {
        $this->load->model('Certificationmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');


        $certification = array();
        $certification = $this->Certificationmodel->brandList();

        //render view
        $inner = array();
        $inner['certification'] = $certification;

        $page = array();
        $page['content'] = $this->load->view('certification-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        $this->load->model('Certificationmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('image_v', 'Brand Logo', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('certification-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Certificationmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'added');
            redirect("certification/", 'location');
            exit();
        }
    }

    //function edit
    function edit($bid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Certificationmodel');
        //get brand detail
        $certification = array();
        $certification = $this->Certificationmodel->getdetails($bid);

        if (!$certification) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['certification'] = $certification;
            $page['content'] = $this->load->view('certification-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Certificationmodel->updateRecord($certification);
            $this->session->set_flashdata('SUCCESS', 'updated');
            redirect("certification/index/", 'location');
            exit();
        }
    }




    //function delete
    function delete($bid) {
        $this->load->model('Certificationmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //get brand detail
        $certification = array();
        $certification = $this->Certificationmodel->getdetails($bid);
        if (!$certification) {
            $this->utility->show404();
            return;
        }

        $this->Certificationmodel->deletecertification($certification);
        $this->session->set_flashdata('SUCCESS', 'deleted');
        redirect('certification/index/');
        exit();
    }

}

?>