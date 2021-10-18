<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projecttype extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }


    //function index
    function index()
    {
        $this->load->model('Projecttypemodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');


        $projecttype = array();
        $projecttype = $this->Projecttypemodel->brandList();

        //render view
        $inner = array();
        $inner['projecttype'] = $projecttype;

        $page = array();
        $page['content'] = $this->load->view('projecttype-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add()
    {
        $this->load->model('Projecttypemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('projecttype-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Projecttypemodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'added');
            redirect("projecttype/", 'location');
            exit();
        }
    }

    //function edit
    function edit($bid)
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Projecttypemodel');
        $projecttype = array();
        $projecttype = $this->Projecttypemodel->getdetails($bid);
        if (!$projecttype) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('name', 'Name', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['projecttype'] = $projecttype;
            $page['content'] = $this->load->view('projecttype-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Projecttypemodel->updateRecord($projecttype);
            $this->session->set_flashdata('SUCCESS', 'updated');
            redirect("projecttype/index/", 'location');
            exit();
        }
    }

    public function toggle()
    {
        $id = $this->input->post('id');

        $sql = "UPDATE br_projecttype SET active = active XOR 1 where id = '$id'";
        $status = $this->db->query($sql);

        return $status;
    }

    //function delete
    function delete($bid)
    {
        $this->load->model('Projecttypemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //get brand detail
        $projecttype = array();
        $projecttype = $this->Projecttypemodel->getdetails($bid);
        if (!$projecttype) {
            $this->utility->show404();
            return;
        }

        $this->Projecttypemodel->deleteBrand($projecttype);
        $this->session->set_flashdata('SUCCESS', 'deleted');
        redirect('projecttype/index/');
        exit();
    }
}
