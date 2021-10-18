<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Homepage extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index($sid = false) {
//        $this->load->model('Slideshowmodel');
        $this->load->model('Slidemodel');
        $this->load->model('Uspmodel');
        $this->load->model('Topcatmodel');
        $this->load->model('Catmodel');
        $this->load->model('Offermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');


        $slidetree = '';
        $slidetree = $this->Slidemodel->slideTree(0, 1);

        $usptree = '';
        $usptree = $this->Uspmodel->uspTree();

        $topcattree = '';
        $topcattree = $this->Topcatmodel->topcatTree();

        $homecatTree = '';
        $homecatTree = $this->Catmodel->homecatTree(0);

        $offertree = array();
        $offertree = $this->Offermodel->offerTree();
//        ee($homecatTree);
        //render view
        $inner = array();
        $inner['slidetree'] = $slidetree;
        $inner['usptree'] = $usptree;
        $inner['topcattree'] = $topcattree;
        $inner['homecatTree'] = $homecatTree;
        $inner['offertree'] = $offertree;
//        ee($inner);
        $page = array();
        $page['content'] = $this->load->view('homepage-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

}

?>