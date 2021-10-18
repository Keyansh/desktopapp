<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attribute extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index() {
        $this->load->model('Attributesmodel');
//        $this->load->model('Producttypemodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //Get Product Type Detail
//        $attrid = intval($tid);
//        $attr = array();
//        $attr = $this->Attributesmodel->getDetails($attrid);
//        if (!$attr) {
//            $this->utility->show404();
//            return;
//        }
        //Setup Pagination
        //list all attributes
        $attributes = array();
        $attributes = $this->Attributesmodel->listAll();
        //print_r($attributes); exit();
        //render view
        $inner = array();
        $inner['attributes'] = $attributes;
//        $inner['product_type'] = $attr;
        $inner['pagination'] = $this->pagination->create_links();
        $page = array();
        $page['content'] = $this->load->view('attributes/attributes-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add product attributes
    function add() {
        $this->load->model('Attributesmodel');
//        $this->load->model('Producttypemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Get Product Type Detail
//        $attrid = intval($tid);
//        $attr = array();
//        $attr = $this->Producttypemodel->getDetails($attrid);
//        if (!$attr) {
//            $this->utility->show404();
//            return;
//        }
        //validation check
        $this->form_validation->set_rules('name', 'Attribute Name', 'trim|required');
        $this->form_validation->set_rules('label', 'Attribute Label', 'trim|required');
        $this->form_validation->set_rules('code', 'Attribute Code', 'trim|required');
        $this->form_validation->set_rules('type', 'Attribute Type', 'trim|required');
        //$this->form_validation->set_rules('default', 'Default', 'trim');



        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            //$inner['product_type'] = $attr;
            $page = array();
            $page['content'] = $this->load->view('attributes/attributes-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Attributesmodel->insertRecord();

            $this->session->set_flashdata('SUCCESS', 'attributes_added');

            redirect("catalog/attribute");
            exit();
        }
    }

    //function edit product attributes
    function edit($aid) {
        $this->load->model('Attributesmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //get attributes details
        $attributes = array();
        $attributes = $this->Attributesmodel->getDetails($aid);
        if (!$attributes) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('name', 'Attribute Name', 'trim|required');
        $this->form_validation->set_rules('label', 'Attribute Label', 'trim|required');
        $this->form_validation->set_rules('code', 'Attribute Code', 'trim|required');
        $this->form_validation->set_rules('type', 'Attribute Type', 'trim|required');
        $this->form_validation->set_rules('default', 'Default', 'trim');


        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['attributes'] = $attributes;
            $page = array();
            $page['content'] = $this->load->view('attributes/attributes-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Attributesmodel->updateRecord($attributes);

            $this->session->set_flashdata('SUCCESS', 'attributes_updated');

            redirect("catalog/attribute");
            exit();
        }
    }

}

?>