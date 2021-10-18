<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Download extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //**************************************validation start*********************

    function valid_image($str) {
        if (!isset($_FILES['image']) || $_FILES['image']['size'] == 0 || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $this->form_validation->set_message('valid_image', 'Image not uploaded');
            return FALSE;
        }
        $imginfo = @getimagesize($_FILES['image']['tmp_name']);

        if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
            $this->form_validation->set_message('valid_image', 'Only GIF, JPG and PNG images are accepted');
            return FALSE;
        }
        return TRUE;
    }

    function validImage($str) {
        if ($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == UPLOAD_ERR_OK) {

            $imginfo = @getimagesize($_FILES['image']['tmp_name']);
            if (!$imginfo) {
                $this->form_validation->set_message('validImage', 'Only image files are allowed');
                return false;
            }

            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
                $this->form_validation->set_message('validImage', 'Only GIF, JPG and PNG Images are accepted.');
                return FALSE;
            }
        }
        return TRUE;
    }

    //*************************************validation End********************************
    //function index
    function index($offset = 0) {
        $this->load->model('Downloadmodel');
        $this->load->helper('text');


        //Fetch News
        $download = array();
        $download = $this->Downloadmodel->listAll();
        //print_r($categories); exit();
        //render view
        $inner = array();
        $inner['download'] = $download;

        $page = array();
        $page['content'] = $this->load->view('download-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        $this->load->model('Downloadmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        // $this->form_validation->set_rules('type', 'Type', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');



        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('download-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Downloadmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'PDF added');

            redirect("download/index/", 'location');
            exit();
        }
    }

    //function edit
    function edit($nid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Downloadmodel');


        //Fetch News Details
        $download = array();
        $download = $this->Downloadmodel->getdetails($nid);
        if (!$download) {
            $this->utility->show404();
            return;
        }


        //validation check
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        // $this->form_validation->set_rules('type', 'Type', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['download'] = $download;

            $page['content'] = $this->load->view('download-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Downloadmodel->updateRecord($download);

            $this->session->set_flashdata('SUCCESS', 'PDF updated');
            redirect("download/index/", 'location');
            exit();
        }
    }

    //function delete
    function delete($nid) {
        $this->load->model('Downloadmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch News Details
        $download = array();
        $download = $this->Downloadmodel->getdetails($nid);
        if (!$download) {
            $this->utility->show404();
            return;
        }


        $this->Downloadmodel->deleteRecord($download);
        $this->session->set_flashdata('SUCCESS', 'PDF deleted');
        redirect('download/index/');
        exit();
    }

    function remove_image($nid = false) {
        $this->load->model('Downloadmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch News Details
        $download = array();
        $download = $this->Downloadmodel->getdetails($nid);
        if (!$download) {
            $this->utility->show404();
            return;
        }

        $this->Downloadmodel->deleteImage($download);

        $this->session->set_flashdata('SUCCESS', 'download_image_deleted');
        redirect("/download/edit/{$download['download_id']}");
        exit();
    }
    public function toggle()
    {
        $id = $this->input->post('id');

        $sql = "UPDATE br_download SET active = active XOR 1 where id = '$id'";
        $status = $this->db->query($sql);
        return $status;
    }
    function updateSortOrder(){
        $sort_data = $this->input->post('download', true);
        foreach($sort_data as $key=>$val) {
                $update = array();
                $update['sort_order'] = $key+1;
                $this->db->where('id', $val);
                $this->db->update('download', $update);
        }
    }
}
