<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Headerandfooter extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //function index
    function index()
    {
        $this->load->model('Headerandfootermodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');


        $headerandfooterlist = array();
        $headerandfooterlist = $this->Headerandfootermodel->headerandfooterlist();

        //render view
        $inner = array();
        $inner['headerandfooterlist'] = $headerandfooterlist;

        $page = array();
        $page['content'] = $this->load->view('headerandfooter-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function update($id)
    {
        $this->load->model('Headerandfootermodel');
        $this->Headerandfootermodel->updateRecord($id);
        $this->session->set_flashdata('SUCCESS', 'updated');
        redirect("headerandfooter/", 'location');
        exit();
    }
}
