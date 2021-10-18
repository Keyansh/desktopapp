<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Image extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //**********************validation start**************
    function valid_image($str) {
        if (!isset($_FILES['image']) || $_FILES['image']['size'] == 0 || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $this->form_validation->set_message('valid_image', 'The Image field is required.');
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

    //***************validation end****************

    function index($pid = NULL) {
        $this->load->model('Imagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');


        //image list
        $images = array();
        $images = $this->Imagemodel->listAll($pid);

        //render view
        $inner = array();
        $inner['images'] = $images;
//        echo "<pre>"; print_r($images); exit;

        $page = array();
        $page['content'] = $this->load->view('image-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function add($pid = NULL) {

        //$this->load->model('Imagemodel');
        $this->load->model('Imagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $this->form_validation->set_rules('v_image', 'Image', 'trim|required|callback_valid_image');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            // $inner = array();
//            $inner['parent'] = $this->Imagemodel->getProjects();
            $inner['pid'] = $pid;
            $page = array();
            // print_r($inner);
            //  exit;
            $page['content'] = $this->load->view('image-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {

            $cid = $this->Imagemodel->insertRecord($pid);

            $this->session->set_flashdata('SUCCESS', 'image_added');

            redirect("gallery/image/index/$cid", "location");
            exit();
        }
    }

    function edit($im_id = false, $cid) {
        $this->load->model('Imagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $img = array();
        $img = $this->Imagemodel->getDetail($im_id);
//        echo '<pre>';
//        print_r($img);
//        exit;

        $this->form_validation->set_rules('img_name', 'Image', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            //echo 123;
            $inner['pid'] = $cid;
            $inner['img'] = $img;
            $page = array();
            // print_r($inner);
            //  exit;
            $page['content'] = $this->load->view('image-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            // echo 12;
            $cid = $this->Imagemodel->updateRecord($im_id);

            $this->session->set_flashdata('SUCCESS', 'image_updates');

            redirect("cms/page/edit/$cid", "location");
            exit();
        }
    }

    function delete($im_id = false, $cid) {
        $this->load->model('Imagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch image Detail
        $image = array();
        $image = $this->Imagemodel->getDetail($im_id);
        if (!$image) {
            $this->utility->show404();
            return;
        }

        $this->Imagemodel->deleteRecord($image);

        $this->session->set_flashdata('SUCCESS', 'image_deleted');
        redirect("gallery/image/index/$cid", "location");
        exit();
    }

}

?>