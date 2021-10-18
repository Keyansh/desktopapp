<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //**********************validation start**************
    function valid_image($str) {
        if (!isset($_FILES['image']) || $_FILES['image']['size'] == 0 || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $this->form_validation->set_message('valid_image', ' Image Field is required.');
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
    //function add slides
    function add() {
//        ee($_POST);
        $this->load->model('Catmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $categories = array();
        $categories = $this->Catmodel->listAllCat();
//        ee($categories);
        //validation
        $this->form_validation->set_rules('category', 'Category', 'trim|required');
        $this->form_validation->set_rules('v_image', 'Image', 'trim|required|callback_valid_image');
        $this->form_validation->set_rules('alt', 'Alt', 'trim');


        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['categories'] = $categories;
            $page['content'] = $this->load->view('category/add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Catmodel->insertRecord();

            $this->session->set_flashdata('SUCCESS', 'category_added');
            redirect("homepage", "location");
            exit();
        }
    }

    //function edit USP
    function edit($uid = false) {
        $this->load->model('Catmodel');
        $this->load->helper('text');
        $this->load->library('form_validation');


        //fetch the USP details
        $category = array();
        $category = $this->Catmodel->detail($uid);
        if (!$category) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('alt', 'Alt', 'trim');
        $this->form_validation->set_rules('price', 'Price', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //render view
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['category'] = $category;
            $page['content'] = $this->load->view('category/edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Catmodel->updateRecord($category);

            $this->session->set_flashdata('SUCCESS', 'category_updated');
            redirect("homepage", "location");
            exit();
        }
    }

    //function delete category
    function delete($uid = false) {
        $this->load->model('Catmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch the USP details
        $category = array();
        $category = $this->Catmodel->detail($uid);
        if (!$category) {
            $this->utility->show404();
            return;
        }

        $this->Catmodel->deleteRecord($category);

        $this->session->set_flashdata('SUCCESS', 'category_deleted');
        redirect("homepage", "location");
        exit();
    }

    //function to enable record
    function enable($uid = false) {
        $this->load->model('Catmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch the USP details
        $category = array();
        $category = $this->Catmodel->detail($uid);
        if (!$category) {
            $this->utility->show404();
            return;
        }
        $this->Catmodel->enableRecord($category);

        $this->session->set_flashdata('SUCCESS', 'category_enable');

        redirect("homepage", "location");
        exit();
    }

    //function to disable record
    function disable($image_id = false) {
        $this->load->model('Catmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_SLIDE')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the Slide details
        $slideshowimage = array();
        $slideshowimage = $this->Catmodel->detail($image_id);
        if (!$slideshowimage) {
            $this->utility->show404();
            return;
        }

        $this->Catmodel->disableRecord($slideshowimage);

        $this->session->set_flashdata('SUCCESS', 'category_disable');

//        redirect("slideshow/slide/index/{$slideshowimage['slideshow_id']}");
        redirect("homepage", "location");
        exit();
    }

    //update the speaker sort order
    function updateorder() {

        $sortOrder = $this->input->post('debugStr', TRUE);


        if ($sortOrder) {
            $sortOrder = trim($sortOrder);
            $sortOrder = trim($sortOrder, ',');
            //file_put_contents('facelube.txt',serialize($sortOrder));
            $chunks = explode(',', $sortOrder);
            $counter = 1;
            foreach ($chunks as $id) {
                $data = array();
                $data['slideshow_sort_order'] = $counter;
                $this->db->where('slideshoe_image_id', intval($id));
                $this->db->update('slideshow_image', $data);
                $counter++;
            }
        }
    }

    function childCats() {
        $this->load->model('Catmodel');
        $catId = $this->input->post('cat_id', TRUE);
        $childCats = array();
        if ($catId) {
            $childCats = $this->Catmodel->allChild($catId);
        }
        $response['childCats'] = $childCats;
        echo json_encode($response);
    }

    function getDetailAjax() {
        $this->load->model('Catmodel');
        $catId = $this->input->post('cat_id', TRUE);
        $catDetail = $this->Catmodel->detailAjax($catId);
        $response['catDetail'] = $catDetail;
        echo json_encode($response);
    }

    function updateAjax() {
        $this->load->library('form_validation');
        $this->load->model('Catmodel');

        $response = array();
        $response['msg'] = "";
        $response['status'] = "";
        $response['html'] = "";

        $alt = $this->input->post('alt');
        $description = $this->input->post('description');
        $catid = $this->input->post('catid');
        $image = $this->input->post('image');

//        if (trim($alt) == "") {
//            $response['status'] = 'error';
//            $response['msg'] .= ' .alterror ,';
//        }
//        if (trim($description) == "") {
//            $response['status'] = 'error';
//            $response['msg'] .= ' .descriptionerror ';
//        }

        if ($response['status'] == "error") {
            echo json_encode($response);
            return false;
        }

        $this->Catmodel->insertRecordAjax();
        $response['status'] = 'success';
        $response['html'] = 'Thank you for updating this category.';

        echo json_encode($response);
    }

    function addChild($pid) {
        $this->load->model('Catmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch the  details
        $category = $childCats = array();
        $category = $this->Catmodel->detail($pid);
        if (!$category) {
            $this->utility->show404();
            return;
        }
//        ee($category);
        $childCats = $this->Catmodel->allChild($category['category']);
//        ee($childCats);
        //validation
        $this->form_validation->set_rules('category', 'Category', 'trim|required');
        $this->form_validation->set_rules('v_image', 'Image', 'trim|required|callback_valid_image');
        $this->form_validation->set_rules('alt', 'Alt', 'trim');
        $this->form_validation->set_rules('description', 'Alt', 'trim');


        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['category'] = $category;
            $inner['childCats'] = $childCats;
            $page['content'] = $this->load->view('category/add-child', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Catmodel->insertChildRecord($pid);

            $this->session->set_flashdata('SUCCESS', 'category_added');
            redirect("homepage", "location");
            exit();
        }
    }

}

?>