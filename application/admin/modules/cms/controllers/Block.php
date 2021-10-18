<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Block extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_admin_protected = true;
    }

    //**************************validation start***************************
    //function valid page block for add
    public function valid_block($str)
    {
        $this->db->where('block_alias', $str);
        $this->db->where('page_id', $this->input->post('page_id', true));
        $this->db->from('page_block');
        $block_count = $this->db->count_all_results();
        if ($block_count != 0) {
            $this->form_validation->set_message('valid_block', 'Block Alias is already being used!');
            return false;
        }
        return true;
    }

    //function valid page block for edit
    public function validBlock($str)
    {
        $this->db->where('block_alias', $str);
        $this->db->where('page_block_id !=', $this->input->post('block_id', true));
        $this->db->where('page_id', $this->input->post('page_id', true));
        $this->db->from('page_block');
        $block_count = $this->db->count_all_results();
        if ($block_count != 0) {
            $this->form_validation->set_message('validBlock', 'Block Alias is already being used!');
            return false;
        }
        return true;
    }

    //validation for valid image
    public function valid_images($str)
    {
        if (!isset($_FILES['image']) || $_FILES['image']['size'] == 0 || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
            $this->form_validation->set_message('valid_images', 'Image not uploaded.');
            return false;
        }

        $imginfo = @getimagesize($_FILES['image']['tmp_name']);

        if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3)) {
            $this->form_validation->set_message('valid_images', 'Only GIF, JPG and PNG Images are accepted');
            return false;
        }
        return true;
    }

    //function for edit valid image
    public function valid_image($str)
    {
        if ($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == UPLOAD_ERR_OK) {

            $imginfo = @getimagesize($_FILES['image']['tmp_name']);
            if (!$imginfo) {
                $this->form_validation->set_message('validImage', 'Only image files are allowed');
                return false;
            }

            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3)) {
                $this->form_validation->set_message('validImage', 'Only GIF, JPG and PNG Images are accepted.');
                return false;
            }
        }
        return true;
    }

    //*************************************validation end**********************************************
    public function index($pid = 0, $offset = 0)
    {
        $this->load->model('Blockmodel');
        $this->load->model('Pagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('pagination');

        if (!$this->checkAccess('MANAGE_PAGE_BLOCKS')) {
            $this->utility->accessDenied();
            return;
        }

        //Get page Detail
        $pages = array();
        $pages = $this->Pagemodel->detail($pid);
        if (!$pages) {
            $this->utility->show404();
            return;
        }

        //Setup pagination
        /* $perpage = 20;
        $config['base_url'] = base_url() . "block/index/$pid/";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Blockmodel->countAll($pid);
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

         */

        //list all block
        $block = array();
        $block = $this->Blockmodel->listAll($pid);

        $page_lang = array();
        $page_lang = $this->Pagemodel->getLanguage($pages['language_code']);

        //render view
        $inner = array();
        $inner['block'] = $block;
        $inner['pages'] = $pages;
        $inner['page_lang'] = $page_lang;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('block/block-index', $inner, true);
        $this->load->view('shell', $page);
    }

    //function add block
    public function add($pid = false)
    {
        $this->load->model('Blockmodel');
        $this->load->model('Blocktemplatemodel');
        $this->load->model('Pagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_PAGE_BLOCKS')) {
            $this->utility->accessDenied();
            return;
        }

        //Get page Detail
        $pages = array();
        $pages = $this->Pagemodel->detail($pid);
        if (!$pages) {
            $this->utility->show404();
            return;
        }

        $block_template = array();
        $rs = $this->Blocktemplatemodel->listAll();
        foreach ($rs as $item) {
            $block_template[$item['block_template_id']] = $item['block_template_name'];
        }

        //validation check
        $this->form_validation->set_rules('block_title', 'Block Title', 'trim|required');
        //$this->form_validation->set_rules('block_alias', 'Block Alias', 'trim|required|callback_valid_block');
        $this->form_validation->set_rules('v_image', 'Block Image', 'trim|required|callback_valid_image');
        $this->form_validation->set_rules('block_link', 'Block Link', 'trim');
        $this->form_validation->set_rules('block_image_alt', 'Alt', 'trim');
        $this->form_validation->set_rules('block_template_id', 'Template', 'trim|required');
        $this->form_validation->set_rules('block_contents', 'Contents', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {
            $inner = array();
            $inner['pages'] = $pages;
            $inner['block_template'] = $block_template;
            $inner['block_type'] = array('text_block' => 'text block', 'usp_block' => 'Usp block', 'full_image' => 'Full image', 'product_block' => 'Product Block', 'distributor-block' => 'Distributor Block');
            $page = array();
            $page['content'] = $this->load->view('block/block-add', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Blockmodel->insertRecord($pages);

            $this->session->set_flashdata('SUCCESS', 'block_added');

            redirect("cms/block/index/$pid", "location");
            exit();
        }
    }

    //function edit page block
    public function edit($bid = false)
    {
        $this->load->model('Blockmodel');
        $this->load->model('Blocktemplatemodel');
        $this->load->model('Pagemodel');
        $this->load->helper('text');
        $this->load->library('form_validation');

        if (!$this->checkAccess('MANAGE_PAGE_BLOCKS')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the block details
        $block = array();
        $block = $this->Blockmodel->getDetails($bid);
        if (!$block) {
            $this->utility->show404();
            return;
        }

        //Get page Detail
        $pages = array();
        $pages = $this->Pagemodel->detail($block['page_id']);
        if (!$pages) {
            $this->utility->show404();
            return;
        }

        //fetch  page template
        $blocktemplate = '';
        if ($pages['language_code'] == 'en') {
            $file_name = str_ireplace('/', '_', $pages['page_uri']) . '_' . $block['block_alias'] . '.php';
        } else {
            $file_name = str_ireplace('/', '_', $pages['page_uri']) . '_' . $pages['language_code'] . '_' . $block['block_alias'] . '.php';
        }

        if (file_exists(ROOT_APPPATH . "views/themes/" . THEME . "/blocks/" . $file_name)) {
            //echo $file_name;
            $blocktemplate = file_get_contents(ROOT_APPPATH . "views/themes/" . THEME . "/blocks/" . $file_name);
        }

        $block_template = array();
        $rs = $this->Blocktemplatemodel->listAll();
        foreach ($rs as $item) {
            $block_template[$item['block_template_id']] = $item['block_template_name'];
        }

        //validation check
        $this->form_validation->set_rules('block_title', 'Block Title', 'trim|required');
        //$this->form_validation->set_rules('block_alias', 'Block Alias', 'trim|required|callback_validBlock');
        $this->form_validation->set_rules('v_image', 'Block Image', 'trim|required|callback_valid_image');
        $this->form_validation->set_rules('block_link', 'Block Link', 'trim');
        $this->form_validation->set_rules('block_image_alt', 'Alt', 'trim');
        $this->form_validation->set_rules('block_template_id', 'Template', 'trim|required');
        $this->form_validation->set_rules('block_contents', 'Contents', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //render view
        if ($this->form_validation->run() == false) {
            $inner = array();
            $page = array();
            $inner['block'] = $block;
            $inner['pages'] = $pages;
            $inner['blocktemplate'] = $blocktemplate;
            $inner['block_template'] = $block_template;
            // $inner['block_type'] = array('1' => 'type 1', '2' => 'type 2', '3' => 'type 3', '4' => 'type 4', '5' => 'type 5', '6' => 'type 6');
            $inner['block_type'] = array('text_block' => 'text block', 'usp_block' => 'Usp block', 'full_image' => 'Full image', 'product_block' => 'Product Block', 'distributor-block' => 'Distributor Block');
            $page['content'] = $this->load->view('block/block-edit', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Blockmodel->updateRecord($block, $pages);

            $this->session->set_flashdata('SUCCESS', 'block_updated');

            redirect("cms/block/index/{$block['page_id']}");
            exit();
        }
    }

    //function edit page block
    public function edit_popup($pageid = false, $alias = false)
    {
        $this->load->model('Blockmodel');
        $this->load->model('Blocktemplatemodel');
        $this->load->model('Pagemodel');
        $this->load->helper('text');
        $this->load->library('form_validation');

        if (!$this->checkAccess('MANAGE_PAGE_BLOCKS')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the block details
        $block = array();
        $block = $this->Blockmodel->fetchByAlias($pageid, $alias);
        if (!$block) {
            $this->utility->show404();
            return;
        }

        //Get page Detail
        $page = array();
        $page = $this->Pagemodel->detail($block['page_id']);
        if (!$page) {
            $this->utility->show404();
            return;
        }

        $block_template = array();
        $block_template[''] = '--Select--';
        $rs = $this->Blocktemplatemodel->listAll();
        foreach ($rs as $item) {
            $block_template[$item['block_template_id']] = $item['block_template_name'];
        }

        //validation check
        $this->form_validation->set_rules('block_title', 'Block Title', 'trim|required');
        $this->form_validation->set_rules('block_alias', 'Block Alias', 'trim|required|callback_validBlock');
        $this->form_validation->set_rules('v_image', 'Block Image', 'trim|required|callback_valid_image');
        $this->form_validation->set_rules('block_link', 'Block Image Link', 'trim');
        $this->form_validation->set_rules('block_image_alt', 'Alt', 'trim');
        $this->form_validation->set_rules('block_template_id', 'Template', 'trim|required');
        $this->form_validation->set_rules('block_contents', 'Contents', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //render view
        if ($this->form_validation->run() == false) {
            $inner = array();
            $shell = array();
            $inner['block'] = $block;
            $inner['page'] = $page;
            $inner['block_template'] = $block_template;
            $shell['content'] = $this->load->view('block/block-edit-popup', $inner, true);
            $this->load->view('overlay', $shell);
        } else {
            $this->Blockmodel->updateRecord($block);
            redirect("cms/block/edit_popup_success");
            exit();
        }
    }

    public function edit_popup_success()
    {
        $inner = array();
        $shell = array();
        $shell['content'] = $this->load->view('block/block-edit-success', $inner, true);
        $this->load->view('overlay', $shell);
    }

    public function delete($bid = false)
    {
        $this->load->model('Blockmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_PAGE_BLOCKS')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the block details
        $block = array();
        $block = $this->Blockmodel->getDetails($bid);
        if (!$block) {
            $this->utility->show404();
            return;
        }

        $this->Blockmodel->deleteRecord($block);

        $this->session->set_flashdata('SUCCESS', 'block_deleted');
        redirect("cms/block/index/{$block['page_id']}", "location");
        exit();
    }

    public function ed($id)
    {
        $this->load->model('Blockmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_PAGE_BLOCKS')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the block details
        $block = array();
        $block = $this->Blockmodel->getDetails($id);
        if (!$block) {
            $this->utility->show404();
            return;
        }

        $this->Blockmodel->edRecord($block);

        $this->session->set_flashdata('SUCCESS', 'block_updated');
        redirect("cms/block/index/{$block['page_id']}", "location");
        exit();
    }

}
