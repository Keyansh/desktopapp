<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends Cms_Controller {

    protected $casestudy_id = false;
    public $details = false;

    function __construct() {
        parent::__construct();
        $this->load->model('Pagemodel');
        $this->load->model('Blogmodel');
        $this->load->library('pagination');
    }

    function index() {
        $perpage = 10;
        $config['base_url'] = base_url() . "blog/index";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->Blogmodel->countAll();
        $config['per_page'] = $perpage;
//        $choice = $config["total_rows"] / $config["per_page"];
//        $config["num_links"] = floor($choice);
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
        $config['cur_tag_open'] = '<li class="active ajax-page"><a class="page-link disabled" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="ajax-page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $pages = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $blog = $this->Blogmodel->listAllBlog($pages, $perpage);
        $recent_blog = $this->Blogmodel->recentblog();
//        e(lQ());
        $inner = array();
        $inner['blog'] = $blog;
        $inner['recent_blog'] = $recent_blog;

        $inner['pagination'] = $this->pagination->create_links();
        $this->load->view("meta/project-listing", $inner);
        $blog_view = $this->load->view('project-listing', $inner, true);
        $shell['contents'] = $blog_view;
        $this->load->view("themes/" . THEME . "/templates/blog", $shell);
    }

    function details($alias = false) {
        $this->load->model('Pagemodel');
        $this->load->model('Blogmodel');
        //Get blog
        $blog = array();
        $blog = $this->Blogmodel->getDetails($alias);
        if (!$blog) {
            $this->utility->show404();
            return;
        }
        $inner['blog'] = $blog;
        $shell = array();
        $shell['contents'] = $this->load->view('blog-details', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/blog", $shell);
    }

    function ajaxform() {
//        e($_POST);
        $text = $this->input->post('value');
        $this->load->model('Blogmodel');
        $blog = $this->Blogmodel->searchblog($text);
        $inner = array();
        $inner['blog'] = $blog;
        $inner['pagination'] = '';
//        e($inner,0);
        if (!empty($blog)) {
            $html = $this->load->view('project-listing', $inner, TRUE);
            echo $html;
            exit;
        } else {
            $html = "<img class=no-record src=images/norecord.png style='margin: 0 auto;display: table;margin-top: 50px;'/>";
            echo $html;
            exit;
        }
    }

    function ajaxform2() {

        $text = $this->input->post('value');
        $this->load->model('Blogmodel');
        $blog = $this->Blogmodel->searchblog($text);
        $inner = array();
        $inner['blog'] = $blog;
        $inner['pagination'] = '';
        $inner['value'] = $text;
//        e($inner,0);
        if (!empty($blog)) {
//            e($blog);
            $html = $this->load->view('blog-details', $inner, TRUE);
            echo $html;
            exit;
        } else {
//            e(55);
            $html = "<img class=no-record src=images/norecord.png style='margin: 0 auto;display: table;margin-top: 50px;'/>";
            echo $html;
            exit;
        }
    }

}

?>
