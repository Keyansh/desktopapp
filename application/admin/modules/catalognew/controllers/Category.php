<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //**************************************validation start*********************
    function valid_category($str) {
        $this->db->where('name', $str);
        $query = $this->db->get('category');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('valid_category', 'Category Already Existing!');
            return false;
        }

        return true;
    }

    function check_category($str) {
        $this->db->where('name', $str);
        $this->db->where('id !=', $this->input->post('id'));
        $query = $this->db->get('category');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_category', 'Category Already Existing!');
            return false;
        }
        return true;
    }

    function valid_categoryalias($str) {
        $this->db->where('uri', $str);
        $this->db->from('category');
        $category_count = $this->db->count_all_results();
        if ($category_count != 0) {
            $this->form_validation->set_message('valid_categoryalias', 'Category Alias is already being used!');
            return false;
        }
        return true;
    }

    function valid_category_e($str) {
        $this->db->where('uri', $str);
        $this->db->where('id !=', $this->input->post('id', true));
        $this->db->from('category');
        $category_count = $this->db->count_all_results();
        if ($category_count != 0) {
            $this->form_validation->set_message('valid_category_e', 'Category alias is already being used!');
            return false;
        }
        return true;
    }

    //validation for product image thumbnail
    function valid_images($str) {
        if (!isset($_FILES['image']) || $_FILES['image']['size'] == 0 || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $this->form_validation->set_message('valid_images', 'Category Image required');
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
    function valid_banner_image($str) {
        if ($_FILES['category_banner']['size'] > 0 && $_FILES['category_banner']['error'] == UPLOAD_ERR_OK) {

            $imginfo = @getimagesize($_FILES['category_banner']['tmp_name']);

            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
                $this->form_validation->set_message('valid_banner_image', 'Only GIF, JPG and PNG images are accepted');
                return FALSE;
            }
        }
        return TRUE;
    }

    //validation for edit banner image
    function validBannerImage($str) {
        if ($_FILES['category_banner']['size'] > 0 && $_FILES['category_banner']['error'] == UPLOAD_ERR_OK) {

            $imginfo = @getimagesize($_FILES['category_banner']['tmp_name']);
            if (!$imginfo) {
                $this->form_validation->set_message('validBannerImage', 'Only image files are allowed');
                return false;
            }

            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
                $this->form_validation->set_message('validBannerImage', 'Only GIF, JPG and PNG Images are accepted.');
                return FALSE;
            }
        }
        return TRUE;
    }



    //*************************************validation End********************************
    //function index
    function index($offset = 0) {
        $this->load->model('Categorymodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //Fetch pagetree
        $categorytree = '';
        $categorytree = $this->Categorymodel->categoriesTree(0);

        $categories = array();
        $categories = $this->Categorymodel->indentedList(0);

        //render view
        $inner = array();
        $inner['categorytree'] = $categorytree;
        $inner['categories'] = $categories;

        $page = array();
        $page['content'] = $this->load->view('categories/category-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        $this->load->model('Categorymodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_rules('parent_id', 'Parent Category', 'trim|required');
        $this->form_validation->set_rules('name', 'Category Name', 'trim|required|callback_valid_category');
        $this->form_validation->set_rules('uri', 'Category URI', 'trim|callback_valid_categoryalias');
        $this->form_validation->set_rules('short_description', 'Short Description', 'trim');
        $this->form_validation->set_rules('description', 'Category Description', 'trim');
        $this->form_validation->set_rules('bottom_description', 'Category Bottom Description', 'trim');
        $this->form_validation->set_rules('meta_title', 'Category Meta Title', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Category Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Category Meta Description', 'trim');
        $this->form_validation->set_rules('image_alt', 'Category Image Alt', 'trim');
        $this->form_validation->set_rules('banner_alt', 'Category Banner Alt', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $parent = array();
        $parent['0'] = 'Root';
        $categories = $this->Categorymodel->indentedList(0);

        foreach ($categories as $row) {
           $parent[$row['id']] = str_repeat('&nbsp;', ($row['depth']) * 4) . $row['name'];
        }

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['parent'] = $parent;
            //$inner['attrset'] = $attrset;
            $page = array();
            $page['content'] = $this->load->view('categories/category-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Categorymodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'category_added');

            redirect("catalog/category/index/", 'location');
            exit();
        }
    }

    function edit($cid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Categorymodel');

        $current_category = array();
        $current_category = $this->Categorymodel->getdetails($cid);
        if (!$current_category) {
            $this->utility->show404();
            return;
        }

        $parent = array();
        $parent['0'] = 'Root';
        $categories = $this->Categorymodel->indentedList(0);
        foreach ($categories as $row) {
            $parent[$row['id']] = str_repeat('&nbsp;', ($row['depth']) * 4) . $row['name'];
        }

        $this->form_validation->set_rules('parent_id', 'Parent Category', 'trim|required');
        $this->form_validation->set_rules('short_description', 'Short Description', 'trim');
        $this->form_validation->set_rules('description', 'Category Description', 'trim');
        $this->form_validation->set_rules('bottom_description', 'Category Bottom Description', 'trim');
        $this->form_validation->set_rules('image_v', 'Image', 'trim');
        $this->form_validation->set_rules('meta_title', 'Category Meta Title', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Category Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Category Meta Description', 'trim');
        $this->form_validation->set_rules('image_alt', 'Category Image Alt', 'trim');
        $this->form_validation->set_rules('banner_alt', 'Category Banner Alt', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['current_category'] = $current_category;
            $inner['parent'] = $parent;
            $inner['attrset'] = $attrset;

            $page['content'] = $this->load->view('categories/category-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Categorymodel->updateRecord($current_category);

            $this->session->set_flashdata('SUCCESS', 'category_updated');
            redirect("catalog/category/index/", 'location');
            exit();
        }
    }

    //function delete
    function delete($cid) {
        $this->load->model('Categorymodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //get category detail
        $current_category = array();
        $current_category = $this->Categorymodel->getdetails($cid);
        if (!$current_category) {
            $this->utility->show404();
            return;
        }

        //Validation Check
        $this->form_validation->set_rules('id', 'Category Name', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $interested_in = array();
        $interested_in[''] = 'Select';
        $categories = $this->Categorymodel->getCategory($current_category);
        foreach ($categories as $row) {
            $interested_in[$row['id']] = str_repeat('&nbsp;', ($row['depth']) * 8) . $row['name'];
        }

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['current_category'] = $current_category;
            $inner['interested_in'] = $interested_in;
            $page['content'] = $this->load->view('categories/category-delete', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Categorymodel->deleteRecord($current_category);
            $this->session->set_flashdata('SUCCESS', 'category_deleted');
            redirect('catalog/category/index/');
            exit();
        }
    }

    //function to enable category
    function enable($cid = false) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Categorymodel');

        //get category detail
        $category = array();
        $category = $this->Categorymodel->getdetails($cid);
        if (!$category) {
            $this->utility->show404();
            return;
        }

        $this->Categorymodel->enableRecord($category);

        $this->session->set_flashdata('SUCCESS', 'category_updated');

        redirect('catalog/category/index/');
        exit();
    }

    //function to disable record
    function disable($cid = false) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Categorymodel');

        //get category detail
        $category = array();
        $category = $this->Categorymodel->getdetails($cid);
        if (!$category) {
            $this->utility->show404();
            return;
        }

        $this->Categorymodel->disableRecord($category);

        $this->session->set_flashdata('SUCCESS', 'category_updated');

        redirect('catalog/category/index/');
        exit();
    }

    //function delete
    function category_delete($cid) {
        $this->load->model('Categorymodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //get category detail
        $current_category = array();
        $current_category = $this->Categorymodel->getdetails($cid);
        if (!$current_category) {
            $this->utility->show404();
            return;
        }

        $this->Categorymodel->deleteCategory($current_category);
        $this->session->set_flashdata('SUCCESS', 'category_deleted');
        redirect('catalog/category/index/');
        exit();
    }


    function imgsave() {
        $imagePath = "temp/";
        $allowedExts = array("jpeg", "jpg", "JPEG", "JPG", "png");
        $temp = explode(".", $_FILES["img"]["name"]);
        $extension = end($temp);

        if (!is_writable($imagePath)) {
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t upload File; no write Access'
            );
            print json_encode($response);
            return;
        }

        if (in_array($extension, $allowedExts)) {
            if ($_FILES["img"]["error"] > 0) {
                $response = array(
                    "status" => 'error',
                    "message" => 'ERROR Return Code: ' . $_FILES["img"]["error"],
                );
            } else {

                $filename = $_FILES["img"]["tmp_name"];
                list($width, $height) = getimagesize($filename);

                move_uploaded_file($filename, $imagePath . $_FILES["img"]["name"]);
                $response = array(
                    "status" => 'success',
                    "url" => $imagePath . $_FILES["img"]["name"],
                    "width" => $width,
                    "height" => $height
                );
            }
        } else {
            $response = array(
                "status" => 'error',
                "message" => 'something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini',
            );
        }

        echo json_encode($response);
    }
}

// End of category.php
