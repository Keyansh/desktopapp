<?php

defined('BASEPATH') or exit('No direct script access allowed.');

class Megamenu extends Admin_Controller
{
    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('Megamenu_model');
    }

    function index() {
        $inner = array();
        $inner['menu'] = $this->Megamenu_model->get_menus();
        $inner['sub_categories'] = $this->Megamenu_model->get_sub_categories();
        $inner['mapping'] = $this->Megamenu_model->get_mapping();

        $page = array();
        $page['content'] = $this->load->view('megamenu-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function update() {
        $this->Megamenu_model->update();
    }

    function reset() {
        $this->Megamenu_model->reset();
    }
}

// End of megamenu.php
