<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profilegroup extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('Profilegroupmodel');
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    //function index
    function index($offset = 0, $perpage = '') {
        //Fetch News
        $profile_group = array();
        $profile_group = $this->Profilegroupmodel->listAll($offset, $perpage);
        //print_r($categories); exit();
        //render view
        $inner = array();
        $inner['profile_group'] = $profile_group;
        $page = array();
        $page['content'] = $this->load->view('group-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        //validation check
        $this->form_validation->set_rules('group', 'Customer Group', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('group-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Profilegroupmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'group_added');
            redirect("profilegroup/index/", 'location');
            exit();
        }
    }

    //function edit
    function edit($nid) {
        //Fetch News Details
        $profile_group = array();
        $profile_group = $this->Profilegroupmodel->getdetails($nid);
        if (!$profile_group) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('group', 'Customer Group', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['profile_group'] = $profile_group;
            $page['content'] = $this->load->view('group-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Profilegroupmodel->updateRecord($profile_group);
            $this->session->set_flashdata('SUCCESS', 'group_updated');
            redirect("profilegroup/index/", 'location');
            exit();
        }
    }

    //function delete
    function delete($nid) {
        //Fetch News Details
        $profile_group = array();
        $profile_group = $this->Profilegroupmodel->getdetails($nid);
        if (!$profile_group) {
            $this->utility->show404();
            return;
        }

        $this->Profilegroupmodel->deleteRecord($profile_group);
        $this->session->set_flashdata('SUCCESS', 'group_deleted');
        redirect('profilegroup/index/');
        exit();
    }

}

?>