<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends Cms_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $customer = array();
        $customer = $this->memberauth->checkAuth();
        if (!$customer) {
            //$this->Hooksmodel->setReturnURL();
            redirect("/customer/login/");
            exit();
        }
        //print_r($customer); exit();
        //Render View
        $inner = array();
        $inner['customer'] = $customer;
        $shell['meta_title'] = 'Dashboard';
        $shell['contents'] = $this->load->view('dashboard', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/product", $shell);
    }
}
