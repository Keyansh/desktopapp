<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Translate extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index($pid = false) {
        $this->load->model('Pagemodel');
        $this->load->model('Translatemodel');
        $this->load->helper('text');

        //check resource
        if (!$this->checkAccess('MANAGE_TRANSLATE')) {
            $this->utility->accessDenied();
            return;
        }

        //Get Page  Details
        $page = array();
        $page = $this->Pagemodel->detail($pid);
        if (!$page) {
            $this->utility->show404();
            return;
        }

        //Get all pages translate
        $pages_translate = array();
        $pages_translate = $this->Translatemodel->listAll($page);
        //print_r($pages_translate); exit();

        $pages = array();
        $rs = $this->Translatemodel->listAllPage($page);
        foreach ($rs as $row) {
            $pages[$row['language_code']] = $row['language_code'];
        }


        //fetch page languages
        $languages = array();
        $languages = $this->Translatemodel->listAllLanguages($page);
        //print_r($languages); exit();
        //render view
        $inner = array();
        $inner['page'] = $page;
        $inner['pages'] = $pages;
        $inner['pages_translate'] = $pages_translate;
        $inner['languages'] = $languages;
        $page = array();
        $page['content'] = $this->load->view('translates/translate-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function add($lang = '', $pid = false) {
        $this->load->model('Pagemodel');
        $this->load->model('Blockmodel');
        $this->load->model('Translatemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //check resource
        if (!$this->checkAccess('MANAGE_TRANSLATE')) {
            $this->utility->accessDenied();
            return;
        }

        //Get Page Details
        $page = array();
        $page = $this->Pagemodel->detail($pid);
        if (!$page) {
            $this->utility->show404();
            return;
        }

        //fetch the block of the page
        $blocks = array();
        $blocks = $this->Blockmodel->fetchAllBlocks($page['page_id']);

        $this->Translatemodel->insertRecord($lang, $page, $blocks);

        $this->session->set_flashdata('SUCCESS', 'translate_added');

        redirect("cms/translate/index/{$page['page_id']}");
        exit();
    }

    //function to edit record
    function edit($pid = false, $tid = false, $tab = 0) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Pagemodel');
        $this->load->model('Translatemodel');

        //permission check
        if (!$this->memberauth->checkAccess('MANAGE_TRANSLATE')) {
            $this->utility->acessresource();
            return;
        }

        //Get Page
        $page_rs = array();
        $page_rs = $this->Pagemodel->detail($pid);
        if (!$page_rs) {
            $this->utility->show404();
            return;
        }

        //Get Page Details
        $page_details = array();
        $page_details = $this->Translatemodel->detail($tid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        //fetch page data
        $page_data = array();
        $page_data = $this->Pagemodel->fetchDetail($page_details, FALSE);
        if (!$page_data) {
            $this->utility->show404();
            return;
        }

        //fetch the old page for parent
        $parent = array();
        $parent['0'] = 'Root';
        $pages = $this->Pagemodel->indentedActiveList(0, $page_details['page_id']);
        foreach ($pages as $row) {
            $parent[$row['page_id']] = str_repeat('&nbsp;', ($row['level']) * 8) . $row['title'];
        }

        //Blocks Available
        $blocks_available = array();
        $this->db->select('block_alias');
        $this->db->where('page_id', $page_details['page_id']);
        $rs = $this->db->get('page_block');
        if ($rs && $rs->num_rows() > 0) {
            $rows = $rs->result_array();
            foreach ($rows as $row) {
                $blocks_available[] = $row['block_alias'];
            }
        }


        //Get all pages
        $pages = array();
        $pages['0'] = 'Root';
        $page = $this->Pagemodel->listAllIndented(0);
        foreach ($page as $row) {
            $pages[$row['page_id']] = $row['page_alias'];
        }

        //Form Validations
        $this->form_validation->set_rules('title', 'Page Title', 'trim|required');
        $this->form_validation->set_rules('parent_id', 'Parent', 'trim');
        $this->form_validation->set_rules('browser_title', 'Browser Title', 'trim');
        $this->form_validation->set_rules('page_alias', 'Page Alias', 'trim|strtolower|callback_valid_pagename_e');
        $this->form_validation->set_rules('contents', 'Contents', 'trim');
        $this->form_validation->set_rules('meta_title', 'Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Meta Description', 'trim');
        $this->form_validation->set_rules('before_head_close', 'JS File', 'trim');
        $this->form_validation->set_rules('before_body_close', 'JS File', 'trim');
        $this->form_validation->set_rules('template', 'Template', 'trim');
        $this->form_validation->set_rules('video_list_id', 'Video List', 'trim');
        $this->form_validation->set_rules('menu_title', 'Menu Title', 'trim|required');
        $this->form_validation->set_rules('show_in_menu', 'Show In Menu', 'trim|required');
        //$this->form_validation->set_rules('page_template', 'Template', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $page_template = array();
        $page_template[''] = 'selcet';
        $handler = opendir(ROOT_APPPATH . "views/themes/" . THEME . "/templates/");
        while ($file = readdir($handler)) {
            if ($file != "." && $file != "..") {
                $explode_file = explode('.', $file);
                $page_template[$file] = ucfirst($explode_file[0]);
            }
        }

        //get all Videos
        $page_videos = array();
        $page_videos['0'] = '--Select--';
        $page_videos_rs = $this->Pagemodel->listAllVideo();
        foreach ($page_videos_rs as $row) {
            $page_videos[$row['video_list_id']] = $row['video_list_title'];
        }

        //get all testimonials
        $page_testimonials = array();
        $page_testimonials['0'] = '--Select--';
        $page_testimonials_rs = $this->Pagemodel->listAllTestimonial();
        foreach ($page_testimonials_rs as $row) {
            $page_testimonials[$row['testimonial_id']] = $row['testimonial_title'];
        }

        //get all testimonials
        $page_banners = array();
        $page_banners['0'] = '--Select--';
        $page_banners_rs = $this->Pagemodel->listAllBanner();
        foreach ($page_banners_rs as $row) {
            $page_banners[$row['banner_id']] = $row['banner_title'];
        }

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['page_details'] = $page_details;
            $inner['page_template'] = $page_template;
            $inner['page_testimonials'] = $page_testimonials;
            $inner['page_banners'] = $page_banners;
            $inner['pages'] = $pages;
            $inner['page_rs'] = $page_rs;
            $inner['parent'] = $parent;
            $inner['blocks_available'] = $blocks_available;
            $inner['page_videos'] = $page_videos;
            $inner['tab'] = $tab;
            $page['content'] = $this->load->view('cmspages/translates/translate-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Pagemodel->updateRecord($page_details, $page_data);

            $this->session->set_flashdata('SUCCESS', 'translate_updated');

            redirect("cms/translate/index/{$page_rs['page_id']}");
            exit();
        }
    }

    //function to delete record
    function delete($pid = false, $tid = false) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Pagemodel');
        $this->load->model('Translatemodel');


        //check resource
        if (!$this->checkAccess('MANAGE_TRANSLATE')) {
            $this->utility->accessDenied();
            return;
        }

        //Get Page
        $page_rs = array();
        $page_rs = $this->Pagemodel->detail($pid);
        if (!$page_rs) {
            $this->utility->show404();
            return;
        }

        //Get Page Details
        $page_details = array();
        $page_details = $this->Translatemodel->detail($tid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        $this->Pagemodel->deleteRecord($page_details);

        $this->session->set_flashdata('SUCCESS', 'translate_deleted');

        redirect("cms/translate/index/{$page_rs['page_id']}");
        exit();
    }

    function remove_banner($pid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Pagemodel');
        $this->load->model('Translatemodel');

        //Get Page Details
        $page_details = array();
        $page_details = $this->Pagemodel->detail($pid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        $this->Pagemodel->removeBanner($page_details);

        $this->session->set_flashdata('SUCCESS', 'translate_updated');

        redirect("cms/translate/index/{$page_details['page_id']}");
        exit();
    }

}

?>