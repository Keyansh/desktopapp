<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Distribution extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_admin_protected = true;
        $this->load->model('Distributionmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('text');
    }

    public function index()
    {
        $distribution = array();
        $distribution = $this->Distributionmodel->listAll();

        $inner = array();
        $inner['distribution'] = $distribution;

        $page = array();
        $page['content'] = $this->load->view('distribution-listing', $inner, true);
        $this->load->view('shell', $page);
    }

    public function add()
    {
        // $this->form_validation->set_rules('distribution_name', 'Distribution Name', 'trim|required');
        $this->form_validation->set_rules('distribution_location', 'Distribution Location', 'trim|required');
        $this->form_validation->set_rules('distribution_city', 'Town/City', 'trim|required');
        $this->form_validation->set_rules('distribution_pcode', 'Postal Code', 'trim|required');
        // $this->form_validation->set_rules('distribution_county', 'County', 'trim|required');
        // $this->form_validation->set_rules('distribution_email', 'Email', 'trim|required|valid_email');
        // $this->form_validation->set_rules('distribution_phone', 'Phone', 'trim|required|numeric');
        $this->form_validation->set_rules('distribution_latitude', 'latitude', 'trim|required');
        $this->form_validation->set_rules('distribution_longitude', 'longitude', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('distribution-add', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Distributionmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'distribution_added');
            redirect("distribution/index/", 'location');
            exit();
        }
    }

    public function edit($nid)
    {
        // e($_POST);
        $distribution = array();
        $distribution = $this->Distributionmodel->getdetails($nid);

        if (!$distribution) {
            $this->utility->show404();
            return;
        }

        // $this->form_validation->set_rules('distribution_name', 'Distribution Name', 'trim|required');
        $this->form_validation->set_rules('distribution_location', 'Distribution Location', 'trim|required');
        $this->form_validation->set_rules('distribution_city', 'Town/City', 'trim|required');
        $this->form_validation->set_rules('distribution_pcode', 'Postal Code', 'trim|required');
        // $this->form_validation->set_rules('distribution_county', 'County', 'trim|required');
        // $this->form_validation->set_rules('distribution_email', 'Email', 'trim|required|valid_email');
        // $this->form_validation->set_rules('distribution_phone', 'Phone', 'trim|required|numeric');
        $this->form_validation->set_rules('distribution_latitude', 'latitude', 'trim|required');
        $this->form_validation->set_rules('distribution_longitude', 'longitude', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {
            $inner = array();
            $page = array();

            $inner['distribution'] = $distribution;

            $page['content'] = $this->load->view('distribution-edit', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Distributionmodel->updateRecord($distribution);
            $this->session->set_flashdata('SUCCESS', 'distribution_updated');
            redirect("distribution/index/", 'location');
            exit();
        }
    }

    public function delete($nid)
    {
        $distribution = array();
        $distribution = $this->Distributionmodel->getdetails($nid);

        if (!$distribution) {
            $this->utility->show404();
            return;
        }

        $this->Distributionmodel->deleteRecord($distribution);
        $this->Distributionmodel->deletepost($distribution);
        $this->session->set_flashdata('SUCCESS', 'distribution_deleted');
        redirect('distribution/index/');
        exit();
    }

    public function toggle()
    {
        $id = $this->input->post('id');

        $sql = "UPDATE br_distribution SET active = active XOR 1 where id = '$id'";
        $status = $this->db->query($sql);

        return $status;
    }

    public function postcodes()
    {
        $search = $_POST['term'];
        if (!isset($search)) {
            $fetchData = $this->db->select('*')->order_by('postcode', 'ASC')->limit(5)->get('postcodelatlng')->result_array();
        } else {
            $fetchData = $this->db->like('postcode', $search)->limit(5)->get('postcodelatlng')->result_array();
        }
        $data = array();
        $rows = $fetchData;
        foreach ($rows as $row) {
            $data[] = array("id" => $row['id'], "text" => $row['postcode']);
        }
        echo json_encode($data);
    }
}
