<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Offers extends Admin_Controller {

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

    function validEndDate() {
        $start_date = $this->input->post('start_on', true);
        $end_date = $this->input->post('end_on', true);
        if ($start_date < $end_date) {
            return TRUE;
        } else {
            $this->form_validation->set_message('validEndDate', 'Applicable To must be after Applicable From');
            return FALSE;
        }
    }

    //*************************************validation End********************************
    //function index
    function index() {
        $this->load->model('Offermodel');
        $this->load->helper('text');
        $this->load->library('form_validation');

        $offers = array();
        $offers = $this->Offermodel->listAll();
//        ee($offers); 
        //render view
        $inner = array();
        $inner['offers'] = $offers;

        $page = array();
        $page['content'] = $this->load->view('offer-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        $this->load->model('Offermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('name', 'Offer Title', 'trim|required');
        $this->form_validation->set_rules('alias', 'URI Alias', 'trim|callback_valid_UrlAlias');
        $this->form_validation->set_rules('start_on', 'Applicable From', 'trim|required');
        $this->form_validation->set_rules('end_on', 'Applicable To', 'trim|required|callback_validEndDate');
        $this->form_validation->set_rules('contents', 'Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');



        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('offer-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Offermodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'offer_added');

            redirect("offers/index/", 'location');
            exit();
        }
    }

    //function edit
    function edit($id) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Offermodel');


        //Fetch Offer Details
        $offer = array();
        $offer = $this->Offermodel->getdetails($id);
        if (!$offer) {
            $this->utility->show404();
            return;
        }
//        ee($offer);
        //validation check
        $this->form_validation->set_rules('name', 'Offer Title', 'trim|required');
        $this->form_validation->set_rules('alias', 'URI Alias', 'trim|callback_valid_UrlAlias');
        $this->form_validation->set_rules('start_on', 'Applicable From', 'trim|required');
        $this->form_validation->set_rules('end_on', 'Applicable To', 'trim|required|callback_validEndDate');
        $this->form_validation->set_rules('contents', 'Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['offer'] = $offer;
            $page['content'] = $this->load->view('offer-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Offermodel->updateRecord($offer);

            $this->session->set_flashdata('SUCCESS', 'offer_updated');
            redirect("offers/index/", 'location');
            exit();
        }
    }

    //function delete
    function delete($id) {
        $this->load->model('Offermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch Offer Details
        $offer = array();
        $offer = $this->Offermodel->getdetails($id);
        if (!$offer) {
            $this->utility->show404();
            return;
        }
//        ee($offer);


        $this->Offermodel->deleteRecord($offer);
        $this->session->set_flashdata('SUCCESS', 'offer_deleted');
        redirect('offers/index/');
        exit();
    }

    function disable($id) {
        $this->load->model('Offermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch Offer Details
        $offer = array();
        $offer = $this->Offermodel->getdetails($id);
        if (!$offer) {
            $this->utility->show404();
            return;
        }
//        ee($offer);


        $this->Offermodel->disableRecord($offer);
        $this->session->set_flashdata('SUCCESS', 'offer_disable');
        redirect('offers/index/');
        exit();
    }

    function enable($id) {
        $this->load->model('Offermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch Offer Details
        $offer = array();
        $offer = $this->Offermodel->getdetails($id);
        if (!$offer) {
            $this->utility->show404();
            return;
        }
//        ee($offer);


        $this->Offermodel->enableRecord($offer);
        $this->session->set_flashdata('SUCCESS', 'offer_disable');
        redirect('offers/index/');
        exit();
    }

    function assign($oid) {
//        ee($_POST);
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Offermodel');


        //Fetch Offer Details
        $offer = array();
        $offer = $this->Offermodel->getdetails($oid);
        if (!$offer) {
            $this->utility->show404();
            return;
        }
        $categories = $mainCats = $products = array();

        $products = $this->Offermodel->allProducts();
        $mainCats = $this->Offermodel->mainCats();
        $categories = $this->Offermodel->indentedList(0);

        //validation check
        $this->form_validation->set_rules('assigntype', 'Assign Type', 'trim|required');
        if ($this->input->post('assigntype') == 1) {
            $this->form_validation->set_rules('category[]', 'Categories', 'trim|required');
        } else if ($this->input->post('assigntype') == 2) {
            $this->form_validation->set_rules('product[]', 'Products', 'trim|required');
        }

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['offer'] = $offer;
            $inner['categories'] = $mainCats;
            $inner['products'] = $products;
//            ee($inner);
            $page['content'] = $this->load->view('offer-assign', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
//            ee($_POST);
            $this->Offermodel->assignOffer($offer);

            $this->session->set_flashdata('SUCCESS', 'offer_assigned');
            redirect("offers/index/", 'location');
            exit();
        }
    }

    //create indented list
    function childList() {
        $parents = $this->input->post('cat_ids');
//        print_r($parents);
//        exit;
        $this->db->select('id,name,parent_id');
        $this->db->where_in('parent_id', $parents);
        $query = $this->db->get('category');
        foreach ($query->result_array() as $row) {
            $output[] = $row;
//            $this->childIndentedList($row['id'], $output);
        }
//        return $output;
        $response['childCats'] = $output;
        echo json_encode($response);
    }

    //create indented list
    function childIndentedList($parent, &$output = array()) {
        $this->db->select('id,name,parent_id');
        $this->db->where('parent_id', $parent);
        $query = $this->db->get('category');
        foreach ($query->result_array() as $row) {
            $output[] = $row;
            $this->childIndentedList($row['id'], $output);
        }
        return $output;
    }

}

?>