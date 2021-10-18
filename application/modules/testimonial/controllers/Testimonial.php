<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonial extends Cms_Controller
{

    protected $casestudy_id = false;
    public $details = false;

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Pagemodel');
        $this->load->model('testmodel');
        $this->load->library('pagination');
    }

    function index($offset = 0)
    {
        $perpage = 25;
        $config['base_url'] = base_url() . "testimonial";
        $config['uri_segment'] = 2;
        $config['total_rows'] = $this->testmodel->countAll();
        $config['per_page'] = $perpage;

        $config['full_tag_open'] = "<ul class='pagination pagi-ul'  style='margin:auto;display:table'>";
        $config['full_tag_close'] = "</ul >";
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev ajax-page">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'next';
        $config['next_tag_open'] = '<li class="ajax-page">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active ajax-page"><a class="page-link disabled" href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="ajax-page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $testimonial = $this->testmodel->listAllTest($offset, $perpage);
        //        e(lQ());
        $inner = array();
        $inner['testimonial'] = $testimonial;
        $inner['pagination'] = $this->pagination->create_links();
        $this->load->view("meta/project-listing", $inner);
        $blog_view = $this->load->view('test-listing', $inner, true);
        $shell['contents'] = $blog_view;
        $shell['meta_title'] = 'Testimonails';
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }
}
