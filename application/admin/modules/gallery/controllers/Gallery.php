<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gallery extends Admin_Controller {

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
        $this->load->model('Gallerymodel');
        $this->load->helper('text');


        //Fetch News
        $gallery = array();
        $gallery = $this->Gallerymodel->listAll($offset, $perpage);
        //print_r($categories); exit();
        //render view
        $inner = array();
        $inner['gallery'] = $gallery;

        $page = array();
        $page['content'] = $this->load->view('gallery-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        $this->load->model('Gallerymodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('project_name', 'gallery Title', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');



        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('gallery-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Gallerymodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'gallery_added');

            redirect("gallery/index/", 'location');
            exit();
        }
    }

    //function edit
    function edit($nid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Gallerymodel');


        //Fetch News Details
        $gallery = array();
        $gallery = $this->Gallerymodel->getdetails($nid);
        if (!$gallery) {
            $this->utility->show404();
            return;
        }


        //validation check
        $this->form_validation->set_rules('project_name', 'gallery Title', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['gallery'] = $gallery;

            $page['content'] = $this->load->view('gallery-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Gallerymodel->updateRecord($gallery);

            $this->session->set_flashdata('SUCCESS', 'gallery_updated');
            redirect("gallery/index/", 'location');
            exit();
        }
    }

    //function delete
    function delete($nid) {
        $this->load->model('Gallerymodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch News Details
        $gallery = array();
        $gallery = $this->Gallerymodel->getdetails($nid);
        if (!$gallery) {
            $this->utility->show404();
            return;
        }


        $this->Gallerymodel->deleteRecord($gallery);
        $this->session->set_flashdata('SUCCESS', 'gallery_deleted');
        redirect('gallery/index/');
        exit();
    }

    function remove_image($nid = false) {
        $this->load->model('Gallerymodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch News Details
        $gallery = array();
        $gallery = $this->Gallerymodel->getdetails($nid);
        if (!$gallery) {
            $this->utility->show404();
            return;
        }

        $this->Gallerymodel->deleteImage($gallery);

        $this->session->set_flashdata('SUCCESS', 'gallery_image_deleted');
        redirect("/gallery/edit/{$gallery['gallery_id']}");
        exit();
    }
    public function toggle()
    {
        $id = $this->input->post('id');

        $sql = "UPDATE br_gallery SET active = active XOR 1 where id = '$id'";
        $status = $this->db->query($sql);
        return $status;
    }
}

?>