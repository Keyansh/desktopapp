<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Brand extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //**************************************validation start*********************
    function valid_category($str) {
        $this->db->where('name', $str);
        $query = $this->db->get('brand');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('valid_category', 'Brand Already Existing!');
            return false;
        }

        return true;
    }

    function check_category($str) {
        $this->db->where('name', $str);
        $this->db->where('id !=', $this->input->post('id'));
        $query = $this->db->get('brand');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_category', 'Brand Already Existing!');
            return false;
        }
        return true;
    }

    function valid_categoryalias($str) {
        $this->db->where('alias', $str);
        $this->db->from('brand');
        $category_count = $this->db->count_all_results();
        if ($category_count != 0) {
            $this->form_validation->set_message('valid_categoryalias', 'Brand Alias is already being used!');
            return false;
        }
        return true;
    }

    function valid_category_e($str) {
        $this->db->where('alias', $str);
        $this->db->where('id !=', $this->input->post('id', true));
        $this->db->from('brand');
        $category_count = $this->db->count_all_results();
        if ($category_count != 0) {
            $this->form_validation->set_message('valid_category_e', 'Brand alias is already being used!');
            return false;
        }
        return true;
    }

    //validation for product image thumbnail
    function valid_images($str) {
        if (!isset($_FILES['image']) || $_FILES['image']['size'] == 0 || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $this->form_validation->set_message('valid_images', 'Brand Image required');
            return FALSE;
        }

        $imginfo = @getimagesize($_FILES['image']['tmp_name']);

        if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
            $this->form_validation->set_message('valid_images', 'Only GIF, JPG and PNG Images are accepted');
            return FALSE;
        }
        return TRUE;
    }

    //function for edit valid image
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

    //validation for category banner image
//    function valid_banner_image($str) {
//        if ($_FILES['brand_banner']['size'] > 0 && $_FILES['brand_banner']['error'] == UPLOAD_ERR_OK) {
//
//            $imginfo = @getimagesize($_FILES['brand_banner']['tmp_name']);
//
//            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
//                $this->form_validation->set_message('valid_banner_image', 'Only GIF, JPG and PNG images are accepted');
//                return FALSE;
//            }
//        }
//        return TRUE;
//    }
    //validation for edit banner image
//    function validBannerImage($str) {
//        if ($_FILES['brand_banner']['size'] > 0 && $_FILES['brand_banner']['error'] == UPLOAD_ERR_OK) {
//
//            $imginfo = @getimagesize($_FILES['brand_banner']['tmp_name']);
//            if (!$imginfo) {
//                $this->form_validation->set_message('validBannerImage', 'Only image files are allowed');
//                return false;
//            }
//
//            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
//                $this->form_validation->set_message('validBannerImage', 'Only GIF, JPG and PNG Images are accepted.');
//                return FALSE;
//            }
//        }
//        return TRUE;
//    }
    //*************************************validation End********************************
    //function index
    function index() {
        $this->load->model('Brandmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');


        $brands = array();
        $brands = $this->Brandmodel->brandList();

        //render view
        $inner = array();
        $inner['brands'] = $brands;

        $page = array();
        $page['content'] = $this->load->view('brand-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        $this->load->model('Brandmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //$this->load->library('upload');
        //validation check
        $this->form_validation->set_rules('name', 'Brand Name', 'trim|required|callback_valid_category');
        $this->form_validation->set_rules('uri', 'Brand URI', 'trim|callback_valid_categoryalias');
        $this->form_validation->set_rules('image_v', 'Brand Logo', 'trim|required|callback_valid_images');
        $this->form_validation->set_rules('description', 'Brand Description', 'trim');
        $this->form_validation->set_rules('browser_title', 'Brand Browser Title', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Brand Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Brand Meta Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('brand-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Brandmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'brand_added');
            redirect("brand/", 'location');
            exit();
        }
    }

    //function edit
    function edit($bid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Brandmodel');
        //$this->load->library('upload');
        //get brand detail
        $brand = array();
        $brand = $this->Brandmodel->getdetails($bid);
//        e($brand);
        if (!$brand) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('name', 'Brand Name', 'trim');
        $this->form_validation->set_rules('uri', 'Brand URI', 'trim');
        $this->form_validation->set_rules('image_v', 'Brand Logo', 'trim|required|validImage');
        $this->form_validation->set_rules('description', 'Brand Description', 'trim');
        $this->form_validation->set_rules('browser_title', 'Brand Browser Title', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Brand Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Brand Meta Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['brand'] = $brand;
            $page['content'] = $this->load->view('brand-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Brandmodel->updateRecord($brand);
            $this->session->set_flashdata('SUCCESS', 'brand_updated');
            redirect("brand/index/", 'location');
            exit();
        }
    }

    //function to enable category
    function enable($cid = false) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Brandmodel');

        //get category detail
        $category = array();
        $category = $this->Brandmodel->getdetails($cid);
        if (!$category) {
            $this->utility->show404();
            return;
        }

        $this->Brandmodel->enableRecord($category);

        $this->session->set_flashdata('SUCCESS', 'category_updated');

        redirect('catalog/category/index/');
        exit();
    }

    //function to disable record
    function disable($cid = false) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Brandmodel');

        //get category detail
        $category = array();
        $category = $this->Brandmodel->getdetails($cid);
        if (!$category) {
            $this->utility->show404();
            return;
        }

        $this->Brandmodel->disableRecord($category);

        $this->session->set_flashdata('SUCCESS', 'category_updated');

        redirect('catalog/category/index/');
        exit();
    }

    //function delete
    function delete($bid) {
        $this->load->model('Brandmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //get brand detail
        $brand = array();
        $brand = $this->Brandmodel->getdetails($bid);
        if (!$brand) {
            $this->utility->show404();
            return;
        }

        $this->Brandmodel->deleteBrand($brand);
        $this->session->set_flashdata('SUCCESS', 'brand_deleted');
        redirect('brand/index/');
        exit();
    }

}

?>