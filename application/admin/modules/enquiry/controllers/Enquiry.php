<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Enquiry extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //function index
    function index() {
        $this->load->model('Enquirymodel');

        $enquiries = array();
        $enquiries = $this->Enquirymodel->listAll();
//        ee($enquiries);
        //Render view
        $inner = array();
        $inner['enquiries'] = $enquiries;
        $page = array();
        $page['content'] = $this->load->view('enquiry-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function view($id) {
        $this->load->model('Enquirymodel');

        $enquiry = array();
        $enquiry = $this->Enquirymodel->getdetails($id);
//        e($enquiry);
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
        $this->load->model('Enquirymodel');
        $enquiry = array();
        $enquiry = $this->Enquirymodel->getdetails($id);
        if (!$enquiry) {
            $this->utility->show404();
            return;
        }
        $this->Enquirymodel->delete($id);
        redirect('enquiry');
    }

    //function index
    function offer() {
        $this->load->model('Enquirymodel');

        $enquiries = array();
        $enquiries = $this->Enquirymodel->listAllOffer();
//        ee($enquiries);
        //Render view
        $inner = array();
        $inner['enquiries'] = $enquiries;
        $page = array();
        $page['content'] = $this->load->view('offer-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function offer_view($id) {
        $this->load->model('Enquirymodel');

        $enquiry = array();
        $enquiry = $this->Enquirymodel->getofferdetails($id);
//        ee($enquiry);
        if (!$enquiry) {
            $this->utility->show404();
            return;
        }
        //Render view
        $inner = array();
        $inner['enquiry'] = $enquiry;
        $page = array();
        $page['content'] = $this->load->view('offer-view', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function offer_delete($id) {
        $this->load->model('Enquirymodel');
        $enquiry = array();
        $enquiry = $this->Enquirymodel->getofferdetails($id);
        if (!$enquiry) {
            $this->utility->show404();
            return;
        }
        $this->Enquirymodel->deleteoffer($id);
        redirect('enquiry/offer');
    }

}

?>