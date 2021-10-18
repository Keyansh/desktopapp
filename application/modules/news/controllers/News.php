<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News extends Module_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    function index($offset = false)
    {
        $this->load->model('Newsmodel');
        $this->load->model('cms/Pagemodel');
        $this->load->model('cms/Templatemodel');
        $this->load->helper('form');
        $this->load->library('pagination');
        $this->load->helper('text');

        //Get Page Details
        $page = array();
        $page = $this->Pagemodel->getDetails('news');

        //print_r($page); exit();
        if (!$page) {
            $this->http->show404();
            return;
        }

        //Setup pagination
        $perpage = 4;
        $config['base_url'] = base_url() . "news/news/index/";
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0)">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_link'] = 'Previous';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['total_rows'] = $this->Newsmodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);


        //Get all news
        $news = array();
        $news = $this->Newsmodel->listAll($offset, $perpage);
        $this->html->addMeta($this->load->view("meta/news_index", array(), true));

        //Variables
        $inner = array();
        $inner['page'] = $page;
        $inner['news'] = $news;
        $inner['pagination'] = $this->pagination->create_links();

        // if ($page['admin_modules']) {
        //     $modules = explode(',', $page['admin_modules']);
        //     foreach ($modules as $page_module) {
        //         $this->load->library("page_modules/" . $page_module, array('page' => $page));
        //         $module_name = "module_$page_module";
        //         $inner[$module_name] = $this->$module_name;
        //     }
        // }

        $shell['contents'] = $this->load->view('news-listing', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    function details($alias = false)
    {
        $this->load->model('Newsmodel');
        $this->load->model('cms/Pagemodel');
        $this->load->model('cms/Templatemodel');
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $page = array();
        $page = $this->Pagemodel->getDetails('news');

        if (!$page) {
            $this->http->show404();
            return;
        }
        //Get news
        $news = array();
        $news = $this->Newsmodel->getDetails($alias);
        $news_img = array();
        $news_img = $this->Newsmodel->getImg($news['news_id']);
        $newsComments = array();
        $newsComments = $this->Newsmodel->newsComments($news['news_id']);

        if (!$news) {
            $this->utility->show404();
            return;
        }



        $this->html->addMeta($this->load->view("meta/news_details", array('news' => $news), true));
        //render view
        $inner = array();
        $inner['news'] = $news;
        $inner['page'] = $page;
        $inner['news_img'] = $news_img;
        $inner['newsComments'] = $newsComments;
        $shell = array();
        $shell['contents'] = $this->load->view('news-detail', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }



    public function valid_phone()
    {
        $value = $this->input->post('phone');
        $stripped = str_replace(' ', '', $value);
        if (!is_numeric($stripped)) {
            $this->form_validation->set_message('valid_phone', 'Please enter valid phone number');
            return false;
        } else {
            return true;
        }
    }

    public function comment()
    {

        //validation check
        $this->form_validation->set_rules('c_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('c_mail', 'Mail', 'trim|required|valid_email');
        $this->form_validation->set_rules('message', 'Comment', 'trim|required');

        $secret = DWS_RECAPTCHA_SECRET_KEY;
        $captcha = $this->input->post('g-recaptcha-response');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        $response = json_decode($response);
        if (!$response->success) {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'trim|required');
        }

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {

            $errors = validation_errors();
            echo json_encode(['success' => false, 'message' => $errors]);
            exit;
        } else {
            $data = array();
            $data['news_id'] = $this->input->post('news_id', true);
            $data['c_name'] = $this->input->post('c_name', true);
            $data['c_mail'] = $this->input->post('c_mail', true);
            $data['c_website'] = $this->input->post('c_website', true);
            $data['message'] = $this->input->post('message', true);
            $data['added_on'] = time();
            $insert_id = $this->db->insert('news_comments', $data);
            if ($insert_id) {
                $redirect_url = base_url('/news/success');
                echo json_encode(['success' => true, 'redirect_url' => $redirect_url]);
                exit;
            }
        }
    }
    public function success()
    {
        $inner = array();
        $shell = array();
        $shell['contents'] = $this->load->view("news-success", $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }
}
