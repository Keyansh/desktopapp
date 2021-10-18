<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usp extends Admin_Controller {

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
//        ee('here');
        $this->load->model('Uspmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation
        $this->form_validation->set_rules('v_image', 'Image', 'trim|required|callback_valid_image');
        $this->form_validation->set_rules('alt', 'Icon Alt', 'trim');
        $this->form_validation->set_rules('content', 'USP Content', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('usp/add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Uspmodel->uploadImages();

            $this->session->set_flashdata('SUCCESS', 'usp_added');
            redirect("homepage", "location");
            exit();
        }
    }

    //function edit USP
    function edit($uid = false) {
        $this->load->model('Uspmodel');
        $this->load->helper('text');
        $this->load->library('form_validation');


        //fetch the USP details
        $usp = array();
        $usp = $this->Uspmodel->detail($uid);
        if (!$usp) {
            $this->utility->show404();
            return;
        }
//ee($usp);
        //validation check
        $this->form_validation->set_rules('v_image', 'Image', 'trim|required|callback_validImage');
        $this->form_validation->set_rules('alt', 'Icon Alt', 'trim');
        $this->form_validation->set_rules('content', 'USP Content', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //render view
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['usp'] = $usp;
            $page['content'] = $this->load->view('usp/edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Uspmodel->updateRecord($usp);

            $this->session->set_flashdata('SUCCESS', 'usp_updated');
            redirect("homepage", "location");
            exit();
        }
    }

    //function delete usp
    function delete($uid = false) {
        $this->load->model('Uspmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch the USP details
        $usp = array();
        $usp = $this->Uspmodel->detail($uid);
        if (!$usp) {
            $this->utility->show404();
            return;
        }

        $this->Uspmodel->deleteRecord($usp);

        $this->session->set_flashdata('SUCCESS', 'usp_deleted');
        redirect("homepage", "location");
        exit();
    }

    //function to enable record
    function enable($uid = false) {
        $this->load->model('Uspmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch the USP details
        $usp = array();
        $usp = $this->Uspmodel->detail($uid);
        if (!$usp) {
            $this->utility->show404();
            return;
        }
        $this->Uspmodel->enableRecord($usp);

        $this->session->set_flashdata('SUCCESS', 'usp_enable');

        redirect("homepage", "location");
        exit();
    }

    //function to disable record
    function disable($image_id = false) {
        $this->load->model('Uspmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_SLIDE')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the Slide details
        $slideshowimage = array();
        $slideshowimage = $this->Uspmodel->detail($image_id);
        if (!$slideshowimage) {
            $this->utility->show404();
            return;
        }

        $this->Uspmodel->disableRecord($slideshowimage);

        $this->session->set_flashdata('SUCCESS', 'usp_disable');

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

}

?>