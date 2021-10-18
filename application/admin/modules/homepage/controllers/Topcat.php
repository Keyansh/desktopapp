<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Topcat extends Admin_Controller {

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
        $this->load->model('Topcatmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $categories = array();
        $categories = $this->Topcatmodel->listAllCat();
//        ee($categories);
        //validation
        $this->form_validation->set_rules('category', 'Category', 'trim|required');
        $this->form_validation->set_rules('v_image', 'Image', 'trim|required|callback_valid_image');
        $this->form_validation->set_rules('alt', 'Alt', 'trim');
        $this->form_validation->set_rules('price', 'Price', 'trim');


        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['categories'] = $categories;
            $page['content'] = $this->load->view('topcat/add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Topcatmodel->insertRecord();

            $this->session->set_flashdata('SUCCESS', 'topcat_added');
            redirect("homepage", "location");
            exit();
        }
    }

    //function edit USP
    function edit($uid = false) {
        $this->load->model('Topcatmodel');
        $this->load->helper('text');
        $this->load->library('form_validation');


        //fetch the USP details
        $topcat = array();
        $topcat = $this->Topcatmodel->detail($uid);
        if (!$topcat) {
            $this->utility->show404();
            return;
        }
//ee($topcat);
        $categories = array();
        $categories = $this->Topcatmodel->listAllCat();
//        ee($categories);
        //validation check
        $this->form_validation->set_rules('category', 'Category', 'trim|required');
        $this->form_validation->set_rules('v_image', 'Image', 'trim|required|callback_validImage');
        $this->form_validation->set_rules('alt', 'Alt', 'trim');
        $this->form_validation->set_rules('price', 'Price', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //render view
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['topcat'] = $topcat;
            $inner['categories'] = $categories;
            $page['content'] = $this->load->view('topcat/edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Topcatmodel->updateRecord($topcat);

            $this->session->set_flashdata('SUCCESS', 'topcat_updated');
            redirect("homepage", "location");
            exit();
        }
    }

    //function delete topcat
    function delete($uid = false) {
        $this->load->model('Topcatmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch the USP details
        $topcat = array();
        $topcat = $this->Topcatmodel->detail($uid);
        if (!$topcat) {
            $this->utility->show404();
            return;
        }

        $this->Topcatmodel->deleteRecord($topcat);

        $this->session->set_flashdata('SUCCESS', 'topcat_deleted');
        redirect("homepage", "location");
        exit();
    }

    //function to enable record
    function enable($uid = false) {
        $this->load->model('Topcatmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch the USP details
        $topcat = array();
        $topcat = $this->Topcatmodel->detail($uid);
        if (!$topcat) {
            $this->utility->show404();
            return;
        }
        $this->Topcatmodel->enableRecord($topcat);

        $this->session->set_flashdata('SUCCESS', 'topcat_enable');

        redirect("homepage", "location");
        exit();
    }

    //function to disable record
    function disable($image_id = false) {
        $this->load->model('Topcatmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_SLIDE')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the Slide details
        $slideshowimage = array();
        $slideshowimage = $this->Topcatmodel->detail($image_id);
        if (!$slideshowimage) {
            $this->utility->show404();
            return;
        }

        $this->Topcatmodel->disableRecord($slideshowimage);

        $this->session->set_flashdata('SUCCESS', 'topcat_disable');

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

    function LowestPrice($cat_id) {
        $query = $this->db->select('min(p.price) as price')
                        ->from('product p')
                        ->join('cat_prod c', 'c.pid = p.id')
                        ->join('category cat', 'c.cid = cat.id')
                        ->group_by('cat.id')
                        ->where('cat.id', $cat_id)
                        ->where('p.type != ', 'config')->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    function CatProLowPrice() {
        $cat_id = $this->input->post('cat_id', TRUE);
        $result_query = self::LowestPrice($cat_id);

        $result_subquery = array();
        if ($result_query) {
            $price = $result_query['price'];
            $response['price'] = $price;
            echo json_encode($response);
        } else {
            $childcat = $this->db->select('id')->where('parent_id', $cat_id)->get('category')->result_array();
            if ($childcat) {
                foreach ($childcat as $value) {
                    if (self::LowestPrice($value['id'])) {
                        $result_subquery[] = self::LowestPrice($value['id']);
                    }
                }
//                ee($result_subquery);
                if ($result_subquery) {
                    $result_sub = min($result_subquery);
                    if ($result_sub) {
                        $price = $result_sub['price'];
                        $response['price'] = $price;
                        echo json_encode($response);
                    }
                }
            }
        }
    }

}

?>