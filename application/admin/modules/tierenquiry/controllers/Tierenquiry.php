<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tierenquiry extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('tierenquirymodel');
        $this->load->helper('text');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    //*************************************validation End********************************
    //function index
    function index($offset = 0) {
        //Fetch News
        $tier = array();
        $tier = $this->tierenquirymodel->listAll($offset, $perpage);
        //render view
        $page = array();
        $inner = array();
        $inner['tier'] = $tier;
        $page['content'] = $this->load->view('tierenquiry-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function edit
    function view($nid) {
        $tier = $this->tierenquirymodel->getdetails($nid);
        if (!$tier) {
            $this->utility->show404();
            return;
        }
        $inner = array();
        $page = array();
        $inner['tier'] = $tier;
        $page['content'] = $this->load->view('tierenquiry-view', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function delete
    function delete($nid) {
        $tier = $this->tierenquirymodel->getdetails($nid);
        if (!$tier) {
            $this->utility->show404();
            return;
        }
        $this->tierenquirymodel->deleteRecord($tier);
        $this->session->set_flashdata('SUCCESS', 'blog_deleted');
        redirect('tierenquiry/index');
        exit();
    }

}

?>