<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Import extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('import/Importmodel');
    }

    // validation start for add******************************************
    function valid_document($str) {
        if (count($_FILES) == 0 || !array_key_exists('document', $_FILES)) {
            $this->form_validation->set_message('valid_document', 'CSV file is required');
            return false;
        }

        if ($_FILES['document']['size'] == 0) {
            $this->form_validation->set_message('valid_document', 'CSV file is required');
            return false;
        }

        if ($_FILES['document']['error'] != UPLOAD_ERR_OK) {
            $this->form_validation->set_message('valid_document', 'Upload of CSV failed');
            return false;
        }

        $validfile = array('.csv');
        $ext = strtolower(strrchr($_FILES['document']['name'], "."));
        if (!in_array($ext, $validfile)) {
            $this->form_validation->set_message('valid_document', 'Only .csv file allowed');
            return false;
        }
        return true;
    }

    //validation ends*****************************************************************************

    function products() {
        //print_r($_FILES);
        if (!$this->checkAccess('IMPORT_DATA')) {
            $this->utility->accessDenied();
            return;
        }
        $this->load->model('import/Importmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');

        //Form Validation
        if ($_FILES) {
            $this->form_validation->set_rules('button', 'CSV file', 'trim|required|callback_valid_document');
        }
        $this->form_validation->set_rules('button', 'Submit', 'required');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $page['content'] = $this->load->view('import/products', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Importmodel->importStock();
            $this->session->set_flashdata('SUCCESS', 'import_data');

            redirect("import/products");
            exit();
        }
    }

    function tmp() {
        if (!$this->checkAccess('IMPORT_DATA')) {
            $this->utility->accessDenied();
            return;
        }
        $this->load->model('import/Importmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Form Validation
        if ($_FILES) {
            $this->form_validation->set_rules('button', 'CSV file', 'trim|required|callback_valid_document');
        }
        $this->form_validation->set_rules('button', 'Submit', 'required');

        if ($this->form_validation->run() == FALSE) {
            $inner = $page = array();
            $page['content'] = $this->load->view('import/tmp', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Importmodel->tmp();

            $this->session->set_flashdata('SUCCESS', 'import_data');
            redirect("import/tmp");
            exit();
        }
    }

    function export_products($flag = false) {
        if ($flag == false) {
            $inner = array();
            $inner['total_products'] = $this->Importmodel->total_products();

            $page = array();
            $page['content'] = $this->load->view('import/export-products', $inner, TRUE);

            $this->load->view('shell', $page);
        } else {
            $this->Importmodel->export_products();
        }
    }

    function delete_products($response = false) {
        $this->load->model('import/Importmodel');

        $inner = array();
        $inner['response'] = $response;

        $page = array();
        $page['content'] = $this->load->view('import/delete_products', $inner, TRUE);

        $this->load->view('shell', $page);
    }

    function delete_sku() {
        $this->load->model('import/Importmodel');

        $this->Importmodel->delete_products();
        $this->delete_products('Done');
    }

    function attribute_update() {

        //print_r($_FILES);
        if (!$this->checkAccess('IMPORT_DATA')) {
            $this->utility->accessDenied();
            return;
        }
        $this->load->model('import/Importmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Form Validation
        if ($_FILES) {
            $this->form_validation->set_rules('button', 'CSV file', 'trim|required|callback_valid_document');
        }
        $this->form_validation->set_rules('button', 'Submit', 'required');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $page['content'] = $this->load->view('import/atrribute-update', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Importmodel->AttibuteUpdateStock();
            $this->session->set_flashdata('SUCCESS', 'import_data');

            redirect("import/attribute_update");
            exit();
        }
    }

//    function AU() {
//        $this->Importmodel->ImportAttibuteUpdate();
//        e("end");
//    }
    function export_product_cats($flag = false) {
        if ($flag == false) {
            $inner = array();
            $inner['total_products'] = $this->Importmodel->total_products();

            $page = array();
            $page['content'] = $this->load->view('import/export-products', $inner, TRUE);

            $this->load->view('shell', $page);
        } else {
            $this->Importmodel->export_product_cats();
        }
    }

}

?>
