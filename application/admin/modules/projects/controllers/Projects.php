<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projects extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('Projectsmodel');
        $this->load->model('catalognew/Productmodel');
    }

    //**************************************validation start*********************

    function valid_image($str)
    {
        if (!isset($_FILES['image']) || $_FILES['image']['size'] == 0 || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $this->form_validation->set_message('valid_image', 'Image not uploaded');
            return FALSE;
        }
        $imginfo = @getimagesize($_FILES['image']['tmp_name']);

        if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3)) {
            $this->form_validation->set_message('valid_image', 'Only GIF, JPG and PNG images are accepted');
            return FALSE;
        }
        return TRUE;
    }

    function validImage($str)
    {
        if ($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == UPLOAD_ERR_OK) {

            $imginfo = @getimagesize($_FILES['image']['tmp_name']);
            if (!$imginfo) {
                $this->form_validation->set_message('validImage', 'Only image files are allowed');
                return false;
            }

            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3)) {
                $this->form_validation->set_message('validImage', 'Only GIF, JPG and PNG Images are accepted.');
                return FALSE;
            }
        }
        return TRUE;
    }

    //*************************************validation End********************************
    //function index
    function index($offset = 0)
    {
        $this->load->model('Projectsmodel');
        $this->load->model('catalognew/Productmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //Setup pagination
        // $perpage = 25;
        // $config['base_url'] = base_url() . "project/project/index/";
        // $config['uri_segment'] = 4;
        // $config['total_rows'] = $this->Projectsmodel->countAll();
        // $config['per_page'] = $perpage;
        // $this->pagination->initialize($config);

        //Fetch News
        $projects = array();
        // $projects = $this->Projectsmodel->listAll($offset, $perpage);
        $projects = $this->Projectsmodel->listAll();
        //print_r($categories); exit();
        //render view
        $inner = array();
        $inner['projects'] = $projects;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('projects-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add()
    {
        // e($_POST);
        $this->load->model('Projectsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('url_alias', 'URL Alias', 'trim');
        $this->form_validation->set_rules('contents', 'Full Description', 'trim');
        $this->form_validation->set_rules('projects_image', 'Listing Page image', 'trim|required');
        // $this->form_validation->set_rules('architect', 'Architect', 'trim|required');
        // $this->form_validation->set_rules('contractor', 'Contractor', 'trim|required');
        // $this->form_validation->set_rules('short_contents', 'Short Description', 'trim');
        $this->form_validation->set_rules('project_cat', 'Project Type', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $parentcat = array();
        $parentcat = $this->Productmodel->parentcat();
        $projecttype = array();
        $projecttype = $this->Projectsmodel->projecttype();


        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['parentcat'] = $parentcat;
            $inner['projecttype'] = $projecttype;
            $page = array();
            $page['content'] = $this->load->view('projects-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Projectsmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'added');

            redirect("projects/index/", 'location');
            exit();
        }
    }

    //function edit
    function edit($pid)
    {
        // e($_POST);
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Projectsmodel');


        //Fetch projects Details
        $projects = array();
        $projects = $this->Projectsmodel->getdetails($pid);
        if (!$projects) {
            $this->utility->show404();
            return;
        }
        $projecttype = array();
        $projecttype = $this->Projectsmodel->projecttype();
        $projectDynamicFields = array();
        $projectDynamicFields = $this->Projectsmodel->projectDynamicFields($pid);
        $projects_img = array();
        $projects_img = $this->Projectsmodel->projectsImages($pid);

        //validation check
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('url_alias', 'URL Alias', 'trim');
        $this->form_validation->set_rules('contents', 'Full Description', 'trim');
        $this->form_validation->set_rules('projects_image', 'Listing Page image', 'trim|required');
        // $this->form_validation->set_rules('architect', 'Architect', 'trim|required');
        // $this->form_validation->set_rules('contractor', 'Contractor', 'trim|required');
        // $this->form_validation->set_rules('short_contents', 'Short Description', 'trim');
        $this->form_validation->set_rules('project_cat', 'Project Type', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $parentcat = array();
        $parentcat = $this->Productmodel->parentcat();
        $sectedprod = array();
        $sectedprod = $this->Projectsmodel->sectedprod($pid);
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['parentcat'] = $parentcat;
            $inner['projects'] = $projects;
            $inner['sectedprod'] = $sectedprod;
            $inner['projecttype'] = $projecttype;
            $inner['projectDynamicFields'] = $projectDynamicFields;
            $inner['projects_img'] = $projects_img;

            $page['content'] = $this->load->view('projects-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Projectsmodel->updateRecord($projects);
            $this->session->set_flashdata('SUCCESS', 'updated');
            redirect("projects/edit/$pid");
            exit();
        }
    }

    //function delete
    function delete($pid)
    {
        $this->load->model('Projectsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch News Details
        $projects = array();
        $projects = $this->Projectsmodel->getdetails($pid);
        if (!$projects) {
            $this->utility->show404();
            return;
        }


        $this->Projectsmodel->deleteRecord($projects);
        $this->session->set_flashdata('SUCCESS', 'deleted');
        redirect('projects/index/');
        exit();
    }

    function remove_image($pid = false)
    {
        $this->load->model('Projectsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch projects Details
        $projects = array();
        $projects = $this->Projectsmodel->getdetails($pid);
        if (!$projects) {
            $this->utility->show404();
            return;
        }

        $this->Projectsmodel->deleteImage($projects);

        $this->session->set_flashdata('SUCCESS', 'projects_image_deleted');
        redirect("/projects/edit/{$projects['projects_id']}");
        exit();
    }
    public function toggle()
    {
        $id = $this->input->post('id');

        $sql = "UPDATE br_projects SET active = active XOR 1 where projects_id = '$id'";
        $status = $this->db->query($sql);

        return $status;
    }
    function upload()
    {

        $config = array();
        $config['upload_path'] = $this->config->item('PROJECTS_IMAGE_PATH');
        $config['allowed_types'] = '*';
        $config['overwrite'] = TRUE;
        $this->load->library('upload', $config);
        if (count($_FILES) > 0) {
            if ($_FILES['file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['file']['tmp_name'])) {
                $this->upload->do_upload('file');
            }
        }
    }
    function deleteimg()
    {
        $path = $this->config->item('PROJECTS_IMAGE_PATH');
        $filename = $path . $_POST['fileList'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
    }
    function remove()
    {
        $img_id = $this->input->post('img_id', true);
        $return['status'] = false;
        $return['image'] = null;
        if ($img_id) {
            $image = $this->db->where('id', $img_id)->get('projects_img')->row_array();
            $path = $this->config->item('PROJECTS_IMAGE_PATH') . $image['img'];
            if (file_exists($path)) {
                @unlink($path);
            }
            $status = $this->db->where('id', $img_id)->delete('projects_img');
            if ($status) {
                $return['image'] = $img_id;
                $return['status'] = true;
            }
        }
        echo json_encode($return);
    }
    function updateMain()
    {
        $projects_id = $this->input->post('projects_id', true);
        $data = [];
        $this->db->where('projects_id',  $projects_id);
        $data['main'] = 0;
        $this->db->update('projects_img', $data);


        $img_id = $this->input->post('radiobtn', true);
        $data1 = [];
        $this->db->where('id', $img_id);
        $data1['main'] = 1;
        $this->db->update('projects_img', $data1);
        return;
    }
    function deleteVideoThumb()
    {


        $colname = $this->input->post('dataval');
        $data = array($colname => NULL);
        $id = $this->input->post('projects_id');
        $this->db->select($colname);
        $this->db->where('projects_id', $id);
        $getfile =  $this->db->get('projects')->row_array();

        $path = $this->config->item('PROJECTS_IMAGE_PATH');

        $filename = $path . $getfile[$colname];

        if (file_exists($filename)) {
            @unlink($filename);
        }

        $this->db->update('projects', $data);
    }
}
