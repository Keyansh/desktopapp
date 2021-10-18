<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Contactus extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_admin_protected = true;
        $this->load->model('Contactusmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('text');
    }

    public function index()
    {
        $contactus = array();
        $contactus = $this->Contactusmodel->listAll();

        $inner = array();
        $inner['contactus'] = $contactus;

        $page = array();
        $page['content'] = $this->load->view('contactus-listing', $inner, true);
        $this->load->view('shell', $page);
    }

    public function add()
    {
        $this->form_validation->set_rules('contactus_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('contactus_location', 'Address', 'trim|required');
        // $this->form_validation->set_rules('contactus_country', 'Country', 'trim|required');
        // $this->form_validation->set_rules('contactus_city', 'Town/City', 'trim|required');
        // $this->form_validation->set_rules('contactus_pcode', 'Postal Code', 'trim|required');
        // $this->form_validation->set_rules('contactus_county', 'County', 'trim|required');
        // $this->form_validation->set_rules('contactus_web', 'Website', 'trim|required');
        // $this->form_validation->set_rules('contactus_email', 'Email', 'trim|required|valid_email');
        // $this->form_validation->set_rules('contactus_phone', 'Tel', 'trim|required');
        // $this->form_validation->set_rules('contactus_fax', 'Fax', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('contactus-add', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Contactusmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'contactus_added');
            redirect("contactus/index/", 'location');
            exit();
        }
    }

    public function edit($nid)
    {
        // e($_POST);
        $contactus = array();
        $contactus = $this->Contactusmodel->getdetails($nid);

        if (!$contactus) {
            $this->utility->show404();
            return;
        }

        $this->form_validation->set_rules('contactus_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('contactus_location', 'Address', 'trim|required');
        // $this->form_validation->set_rules('contactus_country', 'Country', 'trim|required');
        // $this->form_validation->set_rules('contactus_city', 'Town/City', 'trim|required');
        // $this->form_validation->set_rules('contactus_pcode', 'Postal Code', 'trim|required');
        // $this->form_validation->set_rules('contactus_county', 'County', 'trim|required');
        // $this->form_validation->set_rules('contactus_web', 'Website', 'trim|required');
        // $this->form_validation->set_rules('contactus_email', 'Email', 'trim|required|valid_email');
        // $this->form_validation->set_rules('contactus_phone', 'Tel', 'trim|required');
        // $this->form_validation->set_rules('contactus_fax', 'Fax', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {
            $inner = array();
            $page = array();

            $inner['contactus'] = $contactus;

            $page['content'] = $this->load->view('contactus-edit', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Contactusmodel->updateRecord($contactus);
            $this->session->set_flashdata('SUCCESS', 'contactus_updated');
            redirect("contactus/index/", 'location');
            exit();
        }
    }

    public function delete($nid)
    {
        $contactus = array();
        $contactus = $this->Contactusmodel->getdetails($nid);

        if (!$contactus) {
            $this->utility->show404();
            return;
        }

        $this->Contactusmodel->deleteRecord($contactus);
        $this->session->set_flashdata('SUCCESS', 'contactus_deleted');
        redirect('contactus/index/');
        exit();
    }

    public function toggle()
    {
        $id = $this->input->post('id');
        $sql = "UPDATE br_contactus SET active = active XOR 1 where id = '$id'";
        $status = $this->db->query($sql);
        return $status;
    }
    function updateSortOrder()
    {
        $sort_data = $this->input->post('contactus', true);
        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['sort_order'] = $key + 1;
            $this->db->where('id', $val);
            $this->db->update('contactus', $update);
        }
    }
}
