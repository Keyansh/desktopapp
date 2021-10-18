<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forms extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('Formsmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    function index($offset = 0)
    {
        $perpage = 25;
        $config['base_url'] = base_url() . "forms/forms/index/";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Formsmodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        $forms = array();
        $forms = $this->Formsmodel->listAll($offset, $perpage);

        $inner = array();
        $inner['forms'] = $forms;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('forms-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function add()
    {
        $this->form_validation->set_rules('form_title', 'Title', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('forms-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $form_id = $this->Formsmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'added');
            redirect("forms/edit/$form_id", 'location');
            exit();
        }
    }

    function edit($form_id)
    {
        $this->form_validation->set_rules('form_title', 'Title', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $form_details = $this->Formsmodel->getdetails($form_id);
        $fields = $this->Formsmodel->getFields();
        $assigned_fields = $this->Formsmodel->getAssignedFields($form_id);

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['form_details'] = $form_details;
            $inner['fields'] = $fields;
            $inner['assigned_fields'] = $assigned_fields;
            $page['content'] = $this->load->view('forms-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Formsmodel->updateRecord($form_id);
            $this->session->set_flashdata('SUCCESS', 'added');
            redirect("forms/index/", 'location');
            exit();
        }
    }

    function saveFormField(){
        $res = [];
        $this->form_validation->set_rules('label', 'Name', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        if ($this->form_validation->run() == FALSE) {
            $res['success'] = false;
            $res['message'] = validation_errors();
        } else{
            $form_assign = $this->Formsmodel->assignFields();
            $res['success'] = true;
            $res['message'] = 'Field added successfully!';
        }
        echo json_encode($res);
    }

    function updateSortOrder(){
		$sort_data = $this->input->post('field', true);
		foreach($sort_data as $key=>$val) {
			$update = array();
			$update['sort_order'] = $key+1;
			$this->db->where('id', $val);
			$this->db->update('form_field_assignment', $update);
		}
    }
    
    function deleteFormField(){
        $res = [];
        $field_id = $this->input->post('field_id');
        $this->db->where('id', $field_id)->delete('form_field_assignment');
        $res['success'] = true;
        echo json_encode($res);
    }

    function submissions(){
        $forms = array();
        $forms = $this->Formsmodel->listAll();

        $submissions = array();
        $submissions = $this->Formsmodel->listAllSubmissions();

        $inner = array();
        $inner['submissions'] = $submissions;
        $inner['forms'] = $forms;
        $page = array();
        $page['content'] = $this->load->view('submission-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }
}
