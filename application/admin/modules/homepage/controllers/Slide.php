<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Slide extends Admin_Controller {

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

    function index($sid = false) {
        $this->load->model('Slideshowmodel');
        $this->load->model('Slidemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_SLIDE')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch slide show
        $slideshow = array();
        $slideshow = $this->Slideshowmodel->getDetail($sid);
        if (!$slideshow) {
            $this->utility->show404();
            return;
        }

        //Fetch producttree
        $slidetree = '';
        $slidetree = $this->Slidemodel->slideTree(0, $slideshow['slideshow_id']);

        //render view
        $inner = array();
        $inner['slidetree'] = $slidetree;
        $inner['slideshow'] = $slideshow;
        $page = array();
        $page['content'] = $this->load->view('slideshows/slides/listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add slides
    function add($sid = false) {
        $this->load->model('Slideshowmodel');
        $this->load->model('Slidemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_SLIDE')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the Slideshow details
        $slideshow = array();
        $slideshow = $this->Slideshowmodel->getDetail($sid);
        if (!$slideshow) {
            $this->utility->show404();
            return;
        }

        //validation
        $this->form_validation->set_rules('v_image', 'Image', 'trim|required|callback_valid_image');
        $this->form_validation->set_rules('link', 'Slide link', 'trim');
        $this->form_validation->set_rules('alt', 'Slide Alt', 'trim');
        $this->form_validation->set_rules('heading', 'Heading', 'trim');
        $this->form_validation->set_rules('tagline', 'Tagline', 'trim');
        $this->form_validation->set_rules('price', 'Price', 'trim');
        $this->form_validation->set_rules('new_window', 'New Window', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['slideshow'] = $slideshow;

            $page = array();
            $page['content'] = $this->load->view('slideshowimage-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Slidemodel->uploadImages($slideshow);

            $this->session->set_flashdata('SUCCESS', 'slide_added');

//            redirect("slideshow/slide/index/{$slideshow['slideshow_id']}", "location");
            redirect("homepage", "location");
            exit();
        }
    }

    //function edit slide image
    function edit($image_id = false) {
        $this->load->model('Slidemodel');
        $this->load->helper('text');
        $this->load->library('form_validation');

        if (!$this->checkAccess('MANAGE_SLIDE')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the Slide details
        $slideshowimage = array();
        $slideshowimage = $this->Slidemodel->detail($image_id);
//        e($slideshowimage);
        if (!$slideshowimage) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('v_image', 'Image', 'trim|required|callback_validImage');
        $this->form_validation->set_rules('link', 'Slide link', 'trim');
        $this->form_validation->set_rules('alt', 'Slide Alt', 'trim');
        $this->form_validation->set_rules('heading', 'Heading', 'trim');
        $this->form_validation->set_rules('tagline', 'Tagline', 'trim');
        $this->form_validation->set_rules('price', 'Price', 'trim');
        $this->form_validation->set_rules('new_window', 'New Window', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //render view
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['slideshowimage'] = $slideshowimage;
            $page['content'] = $this->load->view('slideshowimage-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Slidemodel->updateRecord($slideshowimage);

            $this->session->set_flashdata('SUCCESS', 'slide_updated');

//            redirect("slideshow/slide/index/{$slideshowimage['slideshow_id']}");
            redirect("homepage", "location");
            exit();
        }
    }

    //function delete slide
    function delete($image_id = false) {
        $this->load->model('Slidemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_SLIDE')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the Slide details
        $slideshowimage = array();
        $slideshowimage = $this->Slidemodel->detail($image_id);
        if (!$slideshowimage) {
            $this->utility->show404();
            return;
        }

        $this->Slidemodel->deleteRecord($slideshowimage);

        $this->session->set_flashdata('SUCCESS', 'slide_deleted');

//        redirect("slideshow/slide/index/{$slideshowimage['slideshow_id']}");
        redirect("homepage", "location");
        exit();
    }

    //function to enable record
    function enable($image_id = false) {
        $this->load->model('Slidemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_SLIDE')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the Slide details
        $slideshowimage = array();
        $slideshowimage = $this->Slidemodel->detail($image_id);
        if (!$slideshowimage) {
            $this->utility->show404();
            return;
        }

        $this->Slidemodel->enableRecord($slideshowimage);

        $this->session->set_flashdata('SUCCESS', 'slide_enable');

//        redirect("slideshow/slide/index/{$slideshowimage['slideshow_id']}");
        redirect("homepage", "location");
        exit();
    }

    //function to disable record
    function disable($image_id = false) {
        $this->load->model('Slidemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_SLIDE')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the Slide details
        $slideshowimage = array();
        $slideshowimage = $this->Slidemodel->detail($image_id);
        if (!$slideshowimage) {
            $this->utility->show404();
            return;
        }

        $this->Slidemodel->disableRecord($slideshowimage);

        $this->session->set_flashdata('SUCCESS', 'slide_disable');

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
