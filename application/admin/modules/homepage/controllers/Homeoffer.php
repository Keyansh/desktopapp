<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Homeoffer extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //***************validation end****************
    //function add slides
    function add() {
//        ee($_POST);
        $this->load->model('Offermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $offers = array();
        $offers = $this->Offermodel->listAllOffers();

        $selectedOffers = $soids = array();
        $selectedOffers = $this->Offermodel->listAll();
        if ($selectedOffers) {
            foreach ($selectedOffers as $selectedOffer) {
                $soids[] = $selectedOffer['offer_id'];
            }
        }
//        ee($selectedOffers);
        //validation
        $this->form_validation->set_rules('offerids[]', 'Offers', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['offers'] = $offers;
            $inner['selectedOffers'] = $soids;
            $page['content'] = $this->load->view('add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Offermodel->insertRecord();

            $this->session->set_flashdata('SUCCESS', 'offer_added');
            redirect("homepage", "location");
            exit();
        }
    }

   
    function delete($id = false) {
        $this->load->model('Offermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $offer = array();
        $offer = $this->Offermodel->detail($id);
        if (!$offer) {
            $this->utility->show404();
            return;
        }

        $this->Offermodel->deleteRecord($offer);

        $this->session->set_flashdata('SUCCESS', 'offer_deleted');
        redirect("homepage", "location");
        exit();
    }

    //function to enable record
    function enable($uid = false) {
        $this->load->model('Offermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch the USP details
        $topcat = array();
        $topcat = $this->Offermodel->detail($uid);
        if (!$topcat) {
            $this->utility->show404();
            return;
        }
        $this->Offermodel->enableRecord($topcat);

        $this->session->set_flashdata('SUCCESS', 'offer_enable');

        redirect("homepage", "location");
        exit();
    }

    //function to disable record
    function disable($image_id = false) {
        $this->load->model('Offermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_SLIDE')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the Slide details
        $slideshowimage = array();
        $slideshowimage = $this->Offermodel->detail($image_id);
        if (!$slideshowimage) {
            $this->utility->show404();
            return;
        }

        $this->Offermodel->disableRecord($slideshowimage);

        $this->session->set_flashdata('SUCCESS', 'offer_disable');

//        redirect("slideshow/slide/index/{$slideshowimage['slideshow_id']}");
        redirect("homepage", "location");
        exit();
    }

}

?>