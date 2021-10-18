<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Productenquiries extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //function index
    function index() {
        $this->load->model('Productenquiriesmodel');

        $enquiries = array();
        $enquiries = $this->Productenquiriesmodel->listAll();

        //Render view
        $inner = array();
        $inner['enquiries'] = $enquiries;
        $page = array();
        $page['content'] = $this->load->view('enquiry-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function view($id) {
        $this->load->model('Productenquiriesmodel');

        $enquiry = array();
        $enquiry = $this->Productenquiriesmodel->getdetails($id);
      
        if (!$enquiry) {
            $this->utility->show404();
            return;
        }
        //Render view
        $inner = array();
        $inner['enquiry'] = $enquiry;
        $page = array();
        $page['content'] = $this->load->view('enquiry-view', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function delete($id) {
        $this->load->model('Productenquiriesmodel');
        $enquiry = array();
        $enquiry = $this->Productenquiriesmodel->getdetails($id);
        if (!$enquiry) {
            $this->utility->show404();
            return;
        }
        $this->Productenquiriesmodel->delete($id);
        redirect('productenquiries');
    }

}

?>