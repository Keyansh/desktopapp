<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pricing_plans extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index($offset = 0) {
        $this->load->model('Pricingplanmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //Setup Pagination
        $perpage = 50;
        $config['base_url'] = base_url() . "pricing_plans/index/";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->Pricingplanmodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //Fetch Pricing Plans
        $pricing_plans = array();
        $pricing_plans = $this->Pricingplanmodel->listAll($offset, $perpage);
        //print_r($attributes); exit();
        //render view
        $inner = array();
        $inner['pricing_plans'] = $pricing_plans;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('pricingplan-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add Pricing plan
    function add() {
        $this->load->model('Pricingplanmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('pricing_plan', 'Pricing Plan ', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('pricingplan-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Pricingplanmodel->insertRecord();

            $this->session->set_flashdata('SUCCESS', 'pricing_plans_added');

            redirect("pricing/pricing_plans/index/");
            exit();
        }
    }

    //function edit pricing plans
    function edit($plan_id) {
        $this->load->model('Pricingplanmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //get pricing plan details
        $pricing_plan = array();
        $pricing_plan = $this->Pricingplanmodel->getDetails($plan_id);
        //print_r($pricing_plan); exit();
        if (!$pricing_plan) {
            $this->utility->show404();
            return;
        }



        //validation check
        $this->form_validation->set_rules('pricing_plan', 'Pricing Plan ', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['pricing_plan'] = $pricing_plan;
            $page = array();
            $page['content'] = $this->load->view('pricingplan-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Pricingplanmodel->updateRecord($pricing_plan);

            $this->session->set_flashdata('SUCCESS', 'pricing_plans_updated');

            redirect("pricing/pricing_plans/index/");
            exit();
        }
    }

    //function delete product Surface type
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