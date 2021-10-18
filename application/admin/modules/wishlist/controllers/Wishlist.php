<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wishlist extends Admin_Controller
{
    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('Wishlist_model');        
    }

    function index($offset = 0) {
        $perpage = 25;
        $config['base_url'] = base_url() . "wishlist/wishlist/index/";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->Wishlist_model->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        $wishlist = array();
        $wishlist = $this->Wishlist_model->listAll($offset, $perpage);

        $inner = array();
        $inner['wishlist'] = $wishlist;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('wishlist-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }
}

// eof
