<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Casestudy extends Module_Controller {

    function __construct() {
        parent::__construct();
    }

    function index($offset = false) {

        $this->load->model('Casestudymodel');
        $this->load->library('form_validation');
        $this->load->model('cms/Pagemodel');
        $this->load->model('cms/Templatemodel');
        $this->load->helper('form');
        $this->load->library('pagination');
        $this->load->helper('text');

       
        //Setup pagination
        $perpage = 10;
        $config['base_url'] = base_url() . "casestudy/index/";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->Casestudymodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //Get  all case studies
        $casestudies = array();
        $casestudies = $this->Casestudymodel->listAll($offset, $perpage);     

        //Variables
        $inner = array();
        $inner['casestudies'] = $casestudies;
        $inner['pagination'] = $this->pagination->create_links();      

        $inner['pagination'] = $this->pagination->create_links();
        $shell['contents'] = $this->load->view('casestudy-listing', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    function details($alias = false) {
 
        $this->load->model('Casestudymodel');
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Get casestudies
        $casestudy = array();
        $casestudy = $this->Casestudymodel->getDetails($alias);
      
        if (!$casestudy) {
            $this->utility->show404();
            return;
        }

        
        //render view
        $inner = array();
        $inner['casestudy'] = $casestudy;
        $shell = array();
        $shell['contents'] = $this->load->view('casestudy-detail', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }
}
?>