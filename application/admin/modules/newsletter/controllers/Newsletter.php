<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Newsletter extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('Newslettermodel');
    }

    //function index
    function index() {
        $newsletter = $this->Newslettermodel->listAll();
        //Render view
        $inner = array();
        $inner['newsletter'] = $newsletter;
        $page = array();
        $page['content'] = $this->load->view('newsletter-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function delete($id) {
        $status = $this->Newslettermodel->delete($id);
        if ($status) {
            redirect('newsletter');
        }
    }

}

?>