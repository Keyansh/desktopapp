<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Testimonial extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_admin_protected = true;
        $this->load->model('Testimonialmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('text');
    }

    public function index($offset = 0)
    {
        $testimonials = array();
        $testimonials = $this->Testimonialmodel->listAll($offset, $perpage);

        $inner = array();
        $inner['testimonials'] = $testimonials;

        $page = array();
        $page['content'] = $this->load->view('testimonial-listing', $inner, true);
        $this->load->view('shell', $page);
    }

    public function add()
    {
        $this->form_validation->set_rules('testimonial', 'Testimonial', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        // $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('testimonial-add', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Testimonialmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'testimonial_added');
            redirect("testimonial/index/", 'location');
            exit();
        }
    }

    public function edit($nid)
    {
        $testimonial = array();
        $testimonial = $this->Testimonialmodel->getdetails($nid);

        if (!$testimonial) {
            $this->utility->show404();
            return;
        }

        $this->form_validation->set_rules('testimonial', 'Testimonial', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        // $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {
            $inner = array();
            $page = array();

            $inner['testimonial'] = $testimonial;

            $page['content'] = $this->load->view('testimonial-edit', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Testimonialmodel->updateRecord($testimonial);
            $this->session->set_flashdata('SUCCESS', 'testimonial_updated');
            redirect("testimonial/index/", 'location');
            exit();
        }
    }

    public function delete($nid)
    {
        $testimonial = array();
        $testimonial = $this->Testimonialmodel->getdetails($nid);

        if (!$testimonial) {
            $this->utility->show404();
            return;
        }

        $this->Testimonialmodel->deleteRecord($testimonial);
        $this->session->set_flashdata('SUCCESS', 'testimonial_deleted');
        redirect('testimonial/index/');
        exit();
    }

    public function toggle()
    {
        $id = $this->input->post('id');

        $sql = "UPDATE br_testimonial SET active = active XOR 1 where id = '$id'";
        $status = $this->db->query($sql);

        return $status;
    }
    
    function updateSortOrder(){
        $sort_data = $this->input->post('testimonial', true);
        foreach($sort_data as $key=>$val) {
                $update = array();
                $update['sort_order'] = $key+1;
                $this->db->where('id', $val);
                $this->db->update('testimonial', $update);
        }
    }
}
