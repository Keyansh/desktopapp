<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rating extends Cms_Controller {

    function __construct() {
        parent::__construct();
    }

    function index($alias = '') {
        $this->load->library('form_validation');
        $this->load->model('ratingmodel');
        $this->load->library('email');

        $rating = 0;
        $response = array();
        $response['msg'] = "";
        $response['status'] = "";
        $response['html'] = "";
        if ($this->input->post('score')) {
            $rating = $this->input->post('score');
        }

        $name = $this->input->post('name');
        $summery = $this->input->post('summery');
        $review = $this->input->post('review');
        $user_id = $this->input->post('user_id');

        if (($rating == 0)) {
            $response['status'] = 'error';
            $response['msg'] = ' .ratingerror ,';
        }
        if (trim($name) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .nameerror ,';
        }
//        if (trim($summery) == "") {
//            $response['status'] = 'error';
//            $response['msg'] .= ' .summeryerror ,';
//        }
        if (trim($review) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .reviewerror ';
        }
        if ($response['status'] == "error") {
            echo json_encode($response);
            return false;
        }
        //if ($this->ratingmodel->checkIp($this->input->post('product_id'))) {

        $this->ratingmodel->insertRecord();
        $response['status'] = 'success';
        $response['html'] = '';

//        if ($insertRes = 1) {
//            $emailBody = 'This is confirmation mail regarding Review on product &nbsp;"' . $company['company_name'] . '"';
//
//            $this->email->initialize($this->config->item('EMAIL_CONFIG'));
//            $this->email->from(MCC_EMAIL_NOREPLY, MCC_EMAIL_FROM);
////            $this->email->to('info@eventhireuk.com');
//            $this->email->to(MCC_EMAIL_ADMIN);
//            $this->email->subject('Alert for Review confirmation');
//            $this->email->message($emailBody);
//            $this->email->send();
//        }
        //} 
//        else {
//            $response['status'] = 'error';
//            $response['html'] = 'Rating Already submitted ';
//        }
        echo json_encode($response);

        //Render View
    }

}

?>