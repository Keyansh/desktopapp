<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Review extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //function index
    function index($offset = 0) {
        $this->load->model('Reviewmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //Setup pagination
//        $perpage = 25;
//        $config['base_url'] = base_url() . "review/index/";
//        $config['uri_segment'] = 3;
//        $config['total_rows'] = $this->Reviewmodel->countAll();
//        $config['per_page'] = $perpage;
//        $this->pagination->initialize($config);
        //Fetch Reviews
        $reviews = array();
        $reviews = $this->Reviewmodel->listAll();
//  $review = $this->Reviewmodel->listAll($offset, $perpage);
//        e($review);
        //Render view
        $inner = array();
        $inner['reviews'] = $reviews;
//        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('review-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function enable($id) {
        $this->load->model('Reviewmodel');
        $review = array();
        $review = $this->Reviewmodel->getdetails($id);
        if (!$review) {
            $this->utility->show404();
            return;
        }
        $this->Reviewmodel->enable($id);
        redirect('review');
    }

    function disable($id) {
        $this->load->model('Reviewmodel');
        $review = array();
        $review = $this->Reviewmodel->getdetails($id);
        if (!$review) {
            $this->utility->show404();
            return;
        }
        $this->Reviewmodel->disable($id);
        redirect('review');
    }

    function delete($id) {
        $this->load->model('Reviewmodel');
        $review = array();
        $review = $this->Reviewmodel->getdetails($id);
        if (!$review) {
            $this->utility->show404();
            return;
        }
        $this->Reviewmodel->delete($id);
        redirect('review');
    }
}

?>