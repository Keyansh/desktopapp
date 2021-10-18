<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //function index
    function index($offset = 0) {
        $this->load->model('Suppliermodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //Setup pagination
        $perpage = 25;
        $config['base_url'] = base_url() . "supplier/index/";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->Suppliermodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //Fetch suppliers
        $suppliers = array();
        $suppliers = $this->Suppliermodel->listAll($offset, $perpage);

        //render view
        $inner = array();
        $inner['suppliers'] = $suppliers;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Suppliermodel');

        //validation check
        $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('address', 'Address', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');



        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('supplier-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Suppliermodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'supplier_added');

            redirect("supplier/index/", 'location');
            exit();
        }
    }

    //function edit
    function edit($s_id) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Suppliermodel');


        //Fetch supplier Details
        $supplier = array();
        $supplier = $this->Suppliermodel->getdetails($s_id);
        if (!$supplier) {
            $this->utility->show404();
            return;
        }


        //validation check
        $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('address', 'Address', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['supplier'] = $supplier;

            $page['content'] = $this->load->view('supplier-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Suppliermodel->updateRecord($supplier);

            $this->session->set_flashdata('SUCCESS', 'supplier_updated');
            redirect("supplier/index/", 'location');
            exit();
        }
    }

    //function delete
    function delete($s_id) {
        $this->load->model('Suppliermodel');

        //Fetch supplier Details
        $supplier = array();
        $supplier = $this->Suppliermodel->getdetails($s_id);
        if (!$supplier) {
            $this->utility->show404();
            return;
        }


        $this->Suppliermodel->deleteRecord($supplier);
        $this->session->set_flashdata('SUCCESS', 'supplier_deleted');
        redirect('/supplier/index/');
        exit();
    }

}

?>