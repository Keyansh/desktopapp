<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Downloads extends Cms_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Downloadmodel');
        $this->load->model('cms/Pagemodel');
        if (!$this->session->userdata('CUSTOMER_ID')) {
            $this->load->helper('url');
            $this->session->set_userdata('REGENT_REDIR_URL', current_url());
        }
    }

    function index()
    {

        $getAllPdf = array();
        $getAllPdf = $this->Downloadmodel->getAllPdf();

        $inner = array();
        $inner['getAllPdf'] = $getAllPdf;
        $shell['meta_title'] = 'Downloads';
        $shell['contents'] = $this->load->view('pdf-result', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }
    function edit($id)
    {
        $getDetails = array();
        $getDetails = $this->Downloadmodel->getDetails($id);
        $projectsTypes = array();
        $projectsTypes = $this->Pagemodel->projectsTypes();
        $inner = array();
        $inner['getDetails'] = $getDetails;
        $inner['projectsTypes'] = $projectsTypes;
        $shell['contents'] = $this->load->view('themes/' . THEME . '/layout/inc-mainview', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }
  

    
}

// End of search.php
