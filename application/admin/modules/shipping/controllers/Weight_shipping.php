<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Weight_shipping extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index($offset = false) {
        $this->load->model('Shippingmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Setup Pagination
        $perpage = 25;
        $config['base_url'] = base_url() . "shipping/weight_shipping/index/";
        $config['uri_segment'] = 5;
        $config['total_rows'] = $this->Shippingmodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //Get all Product
        $shippings = array();
        $shippings = $this->Shippingmodel->listAll($offset, $perpage);

        //render view
        $inner = array();
        $inner['shippings'] = $shippings;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function add() {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Shippingmodel');

        //validation check
        $this->form_validation->set_rules('weight_from', 'Weight From', 'trim|required');
        $this->form_validation->set_rules('weight_to', 'Weight To', 'trim|required');
        $this->form_validation->set_rules('shipping', 'Shipping', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $page['content'] = $this->load->view('add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Shippingmodel->insertRecord();

            $this->session->set_flashdata('SUCCESS', 'shipping_added');

            redirect("shipping/weight_shipping/index/");
            exit();
        }
    }

    function edit($sid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Shippingmodel');

        $shipping = array();
        $shipping = $this->Shippingmodel->detail($sid);
        if (!$shipping) {
            $this->utility->show404();
            return;
        }
        //validation check
        $this->form_validation->set_rules('weight_from', 'Weight From', 'trim|required');
        $this->form_validation->set_rules('weight_to', 'Weight To', 'trim|required');
        $this->form_validation->set_rules('shipping', 'Shipping', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['shipping'] = $shipping;

            $page['content'] = $this->load->view('edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Shippingmodel->updateRecord($shipping);

            $this->session->set_flashdata('SUCCESS', 'shipping_updated');

            redirect("shipping/weight_shipping/index/");
            exit();
        }
    }

    //function delete
    function delete($sid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Shippingmodel');

        $shipping = array();
        $shipping = $this->Shippingmodel->detail($sid);
        if (!$shipping) {
            $this->utility->show404();
            return;
        }

        //Delete shipping
        $this->Shippingmodel->deleteRecord($shipping);

        $this->session->set_flashdata('SUCCESS', 'shipping_deleted');

        redirect("shipping/weight_shipping/index/");
        exit();
    }

}

?>