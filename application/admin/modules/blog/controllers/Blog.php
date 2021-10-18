<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends Admin_Controller {

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
        $this->load->model('Blogmodel');
        $this->load->helper('text');


        //Fetch News
        $blog = array();
        $blog = $this->Blogmodel->listAll($offset, $perpage);
        //print_r($categories); exit();
        //render view
        $inner = array();
        $inner['blog'] = $blog;

        $page = array();
        $page['content'] = $this->load->view('blog-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        $this->load->model('Blogmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('title', 'Blog Title', 'trim|required');
        $this->form_validation->set_rules('url_alias', 'URL Alias', 'trim|callback_valid_UrlAlias');
        $this->form_validation->set_rules('date', 'Blog Date', 'trim|required');
        $this->form_validation->set_rules('v_image', 'Image', 'trim');
        $this->form_validation->set_rules('contents', 'Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');



        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('blog-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Blogmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'blog_added');

            redirect("blog/index/", 'location');
            exit();
        }
    }

    //function edit
    function edit($nid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Blogmodel');


        //Fetch News Details
        $blog = array();
        $blog = $this->Blogmodel->getdetails($nid);
        if (!$blog) {
            $this->utility->show404();
            return;
        }


        //validation check
        $this->form_validation->set_rules('title', 'Blog Title', 'trim|required');
        $this->form_validation->set_rules('url_alias', 'URL Alias', 'trim|callback_valid_UrlAlias');
        $this->form_validation->set_rules('date', 'Blog Date', 'trim|required');
        $this->form_validation->set_rules('v_image', 'Image', 'trim');
        $this->form_validation->set_rules('contents', 'Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['blog'] = $blog;

            $page['content'] = $this->load->view('blog-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Blogmodel->updateRecord($blog);

            $this->session->set_flashdata('SUCCESS', 'blog_updated');
            redirect("blog/index/", 'location');
            exit();
        }
    }

    //function delete
    function delete($nid) {
        $this->load->model('Blogmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch News Details
        $blog = array();
        $blog = $this->Blogmodel->getdetails($nid);
        if (!$blog) {
            $this->utility->show404();
            return;
        }


        $this->Blogmodel->deleteRecord($blog);
        $this->session->set_flashdata('SUCCESS', 'blog_deleted');
        redirect('blog/index/');
        exit();
    }

    function remove_image($nid = false) {
        $this->load->model('Blogmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch News Details
        $blog = array();
        $blog = $this->Blogmodel->getdetails($nid);
        if (!$blog) {
            $this->utility->show404();
            return;
        }

        $this->Blogmodel->deleteImage($blog);

        $this->session->set_flashdata('SUCCESS', 'blog_image_deleted');
        redirect("/blog/edit/{$blog['blog_id']}");
        exit();
    }

}

?>