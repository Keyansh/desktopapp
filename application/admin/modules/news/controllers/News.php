<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('Newsmodel');
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
        $this->load->model('Newsmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //Setup pagination
        $perpage = 25;
        $config['base_url'] = base_url() . "news/news/index/";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Newsmodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //Fetch News
        $news = array();
        $news = $this->Newsmodel->listAll($offset, $perpage);
        //print_r($categories); exit();
        //render view
        $inner = array();
        $inner['news'] = $news;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('news-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add()
    {
        // e($_POST);
        $this->load->model('Newsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('title', 'News Title', 'trim|required');
        $this->form_validation->set_rules('url_alias', 'URL Alias', 'trim');
        $this->form_validation->set_rules('date', 'News Date', 'trim|required');
        $this->form_validation->set_rules('v_image', 'Image', 'trim');
        $this->form_validation->set_rules('contents', 'Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');



        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('news-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Newsmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'news_added');

            redirect("news/index/", 'location');
            exit();
        }
    }

    //function edit
    function edit($nid)
    {
        // e($_POST);
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Newsmodel');


        //Fetch News Details
        $news = array();
        $news = $this->Newsmodel->getdetails($nid);
        if (!$news) {
            $this->utility->show404();
            return;
        }
        $news_img = array();
        $news_img = $this->Newsmodel->newsImages($nid);

        //validation check
        $this->form_validation->set_rules('title', 'News Title', 'trim|required');
        $this->form_validation->set_rules('url_alias', 'URL Alias', 'trim');
        $this->form_validation->set_rules('date', 'News Date', 'trim|required');
        $this->form_validation->set_rules('v_image', 'Image', 'trim');
        $this->form_validation->set_rules('contents', 'Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['news'] = $news;
            $inner['news_img'] = $news_img;

            $page['content'] = $this->load->view('news-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Newsmodel->updateRecord($news);

            $this->session->set_flashdata('SUCCESS', 'news_updated');
            redirect("news/index/", 'location');
            exit();
        }
    }

    //function delete
    function delete($nid)
    {
        $this->load->model('Newsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch News Details
        $news = array();
        $news = $this->Newsmodel->getdetails($nid);
        if (!$news) {
            $this->utility->show404();
            return;
        }


        $this->Newsmodel->deleteRecord($news);
        $this->session->set_flashdata('SUCCESS', 'news_deleted');
        redirect('news/index/');
        exit();
    }

    function remove_image($nid = false)
    {
        $this->load->model('Newsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Fetch News Details
        $news = array();
        $news = $this->Newsmodel->getdetails($nid);
        if (!$news) {
            $this->utility->show404();
            return;
        }

        $this->Newsmodel->deleteImage($news);

        $this->session->set_flashdata('SUCCESS', 'news_image_deleted');
        redirect("/news/edit/{$news['news_id']}");
        exit();
    }
    public function toggle()
    {
        $id = $this->input->post('id');

        $sql = "UPDATE br_news SET active = active XOR 1 where news_id = '$id'";
        $status = $this->db->query($sql);

        return $status;
    }
    function upload()
    {

        $config = array();
        $config['upload_path'] = $this->config->item('NEWS_IMAGE_PATH');
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
        $path = $this->config->item('NEWS_IMAGE_PATH');
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
            $image = $this->db->where('id', $img_id)->get('news_img')->row_array();
            $path = $this->config->item('NEWS_IMAGE_PATH') . $image['img'];
            if (file_exists($path)) {
                @unlink($path);
            }
            $status = $this->db->where('id', $img_id)->delete('news_img');
            if ($status) {
                $return['image'] = $img_id;
                $return['status'] = true;
            }
        }
        echo json_encode($return);
    }
    function updateMain()
    {
        $news_id = $this->input->post('news_id', true);
        $data = [];
        $this->db->where('news_id',  $news_id);
        $data['main'] = 0;
        $this->db->update('news_img', $data);


        $img_id = $this->input->post('radiobtn', true);
        $data1 = [];
        $this->db->where('id', $img_id);
        $data1['main'] = 1;
        $this->db->update('news_img', $data1);
        return;
    }


    function ViewComments($id)
    {
        $this->load->model('Newsmodel');
        $this->load->helper('text');
        $this->load->library('form_validation');

        $newsComments = array();
        $newsComments = $this->Newsmodel->listAllComments($id);

        $inner = array();
        $inner['newsComments'] = $newsComments;


        $page = array();
        $page['content'] = $this->load->view('news-comments-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }
    public function commenttoggle()
    {
        $id = $this->input->post('id');

        $sql = "UPDATE br_news_comments SET active = active XOR 1 where id = '$id'";
        $status = $this->db->query($sql);

        return $status;
    }
    function commentView($id)
    {
        $commentdetails = array();
        $commentdetails = $this->Newsmodel->getCommentDetails($id);
        //Render view
        $inner = array();
        $inner['commentdetails'] = $commentdetails;
        $page = array();
        $page['content'] = $this->load->view('news-comment-view', $inner, TRUE);
        $this->load->view('shell', $page);
    }
    function commentDelete($nid,$newid)
    {
        $this->Newsmodel->deleteComment($nid);
        redirect('news/ViewComments/'. $newid .'');
        exit();
    }
}
