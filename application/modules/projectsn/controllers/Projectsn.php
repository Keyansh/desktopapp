<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projectsn extends Module_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    function index($offset = false)
    {
        $this->http->show404();
        return;
        $this->load->model('Projectmodel');
        $this->load->model('cms/Pagemodel');
        $this->load->model('cms/Templatemodel');
        $this->load->helper('form');
        $this->load->library('pagination');
        $this->load->helper('text');

        //Get Page Details
        // $page = array();
        // $page = $this->Pagemodel->getDetails('project');

        //print_r($page); exit();
        // if (!$page) {
        //     $this->http->show404();
        //     return;
        // }

        //Setup pagination
        // $perpage = 4;
        // $config['base_url'] = base_url() . "Project/Project/index/";
        // $config['uri_segment'] = 4;
        // $config['full_tag_open'] = "<ul class='pagination'>";
        // $config['full_tag_close'] = '</ul>';
        // $config['num_tag_open'] = '<li>';
        // $config['num_tag_close'] = '</li>';
        // $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0)">';
        // $config['cur_tag_close'] = '</a></li>';
        // $config['prev_tag_open'] = '<li>';
        // $config['prev_tag_close'] = '</li>';
        // $config['first_tag_open'] = '<li>';
        // $config['first_tag_close'] = '</li>';
        // $config['last_tag_open'] = '<li>';
        // $config['last_tag_close'] = '</li>';

        // $config['prev_link'] = 'Previous';
        // $config['prev_tag_open'] = '<li class="prev">';
        // $config['prev_tag_close'] = '</li>';

        // $config['next_link'] = 'Next';
        // $config['next_tag_open'] = '<li>';
        // $config['next_tag_close'] = '</li>';
        // $config['total_rows'] = $this->Projectmodel->countAll();
        // $config['per_page'] = $perpage;
        // $this->pagination->initialize($config);


        //Get all news
        $project = array();
        // $project = $this->Projectmodel->listAll($offset, $perpage);
        $project = $this->Projectmodel->listAll();
        $this->html->addMeta($this->load->view("meta/project_index", array(), true));

        //Variables
        $inner = array();
        // $inner['page'] = $page;
        $inner['project'] = $project;
        $inner['pagination'] = $this->pagination->create_links();



        $shell['contents'] = $this->load->view('project-listing', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    function details($alias = false)
    {

        $this->load->model('Projectmodel');
        $this->load->model('cms/Pagemodel');
        $this->load->model('cms/Templatemodel');
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $page = array();
        $page = $this->Pagemodel->getDetails('projects');

        if (!$page) {
            $this->http->show404();
            return;
        }

        $project = array();
        $project = $this->Projectmodel->getDetails($alias);

        $project_img = array();
        $project_img = $this->Projectmodel->getImg($project['projects_id']);

        $getProjectCategory = array();
        $getProjectCategory = $this->Projectmodel->getProjectCategory($project['project_cat']);

        $getProductUsed = array();
        $getProductUsed = $this->Projectmodel->getProductUsed($project['projects_id']);

        $projectDynamicFields = array();
        $projectDynamicFields = $this->Projectmodel->projectDynamicFields($project['projects_id']);



        if (!$project) {
            $this->utility->show404();
            return;
        }



        $this->html->addMeta($this->load->view("meta/project_details", array('project' => $project), true));
        //render view
        $inner = array();
        $inner['project'] = $project;
        $inner['page'] = $page;
        $inner['project_img'] = $project_img;
        $inner['getProjectCategory'] = $getProjectCategory;
        $inner['getProductUsed'] = $getProductUsed;
        $inner['projectDynamicFields'] = $projectDynamicFields;
        $shell = array();
        $shell['meta_title'] = $project['projects_title'];
        $shell['contents'] = $this->load->view('project-detail', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }
}
