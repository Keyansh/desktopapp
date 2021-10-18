<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product_enquiry extends Admin_Controller
{
    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('Product_enquiry_model');
    }

    function index() {
        $enquiries = array();
        $enquiries = $this->Product_enquiry_model->listAll();
        $inner = array();
        $inner['enquiries'] = $enquiries;

        $page = array();
        $page['content'] = $this->load->view('product-enquiry-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function view($id) {
        $enquiry = array();
        $enquiry = $this->Product_enquiry_model->getdetails($id);

        if (!$enquiry) {
            $this->utility->show404();
            return;
        }

        $product = array();
        $product = $this->Product_enquiry_model->get_product_details($enquiry['product_id']);

        $inner = array();
        $inner['enquiry'] = $enquiry;
        $inner['product'] = $product;

        $page = array();
        $page['content'] = $this->load->view('product-enquiry-view', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function delete($id) {
        $enquiry = array();
        $enquiry = $this->Product_enquiry_model->getdetails($id);

        if (!$enquiry) {
            $this->utility->show404();
            return;
        }

        $this->Product_enquiry_model->delete($id);
        redirect('product_enquiry');
    }
}

// End of product_enquiry.php
