<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plan extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index($pricing_id = false) {
        $this->load->model('Planmodel');
        $this->load->model('Pricingplanmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //get pricing plan details
        $pricing_plan = array();
        $pricing_plan = $this->Pricingplanmodel->getDetails($pricing_id);
        if (!$pricing_plan) {
            $this->utility->show404();
            return;
        }



        //Fetch products by plan
        $plans = array();
        $plans = $this->Planmodel->listProductByPlan($pricing_id);
        //print_r($attributes); exit();
        //render view
        $inner = array();
        $inner['plans'] = $plans;
        $inner['pricing_plan'] = $pricing_plan;



        $page = array();
        $page['content'] = $this->load->view('plans/plan-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add Pricing plan
    function add($pricing_id = false) {
        $this->load->model('Pricingplanmodel');
        $this->load->model('Planmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');


        //get pricing plan details
        $pricing_plan = array();
        $pricing_plan = $this->Pricingplanmodel->getDetails($pricing_id);
        if (!$pricing_plan) {
            $this->utility->show404();
            return;
        }

        $deliveryprices = array();
        $rs = $this->Planmodel->fetchPrice($pricing_id);
        foreach ($rs as $item) {
            $deliveryprices[$item['product_id']]['delivery_price'] = $item['product_delivery_price'];
        }
        //print_r($product_price); exit();
        $collectionprices = array();
        foreach ($rs as $item) {
            $collectionprices[$item['product_id']]['collection_price'] = $item['product_collection_price'];
        }

        //Fetch All Products
        $products = array();
        $products = $this->Planmodel->listAll();


        //validation check
        foreach ($products as $item) {
            $this->form_validation->set_rules('product_price_' . $item['product_id'] . '_' . 'delivery_price', $item['product_name'] . ' Delivery Price', 'trim|required');
            $this->form_validation->set_rules('product_price_' . $item['product_id'] . '_' . 'collection_price', $item['product_name'] . ' Collection Price', 'trim|required');
        }
        $this->form_validation->set_rules('product_id', 'Product Name ', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['products'] = $products;
            $inner['pricing_plan'] = $pricing_plan;
            $inner['collectionprices'] = $collectionprices;
            $inner['deliveryprices'] = $deliveryprices;
            $page = array();
            $page['content'] = $this->load->view('plans/addprice-plan', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Planmodel->insertRecord($products, $pricing_plan);

            $this->session->set_flashdata('SUCCESS', 'plan_updated');

            redirect("pricing/plan/add/$pricing_id");
            exit();
        }
    }

    //function delete product pricing Plan
    function delete($plan_id) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Pricingplanmodel');

        //get pricing plan details
        $pricing_plan = array();
        $pricing_plan = $this->Pricingplanmodel->getDetails($plan_id);
        if (!$pricing_plan) {
            $this->utility->show404();
            return;
        }

        $this->Pricingplanmodel->deleteRecord($pricing_plan);
        $this->session->set_flashdata('SUCCESS', 'pricing_plans_deleted');
        redirect("pricing/pricing_plans/index/");
        exit();
    }

}

?>