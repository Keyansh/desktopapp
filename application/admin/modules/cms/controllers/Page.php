<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //**************************validation start*********************************************************
    function valid_pagename($str) {
        $this->db->where('page_uri', $str);
        //$this->db->where('language_code', $this->config->item('DEFAULT_LANG'));
        $this->db->from('page');
        $page_count = $this->db->count_all_results();
        //print_r($page_count); exit();
        if ($page_count != 0) {
            $this->form_validation->set_message('valid_pagename', 'Page URI is already being used!');
            return false;
        }
        return true;
    }

    function valid_pagename_e($str, $lang) {
        $this->db->where('page_uri', $str);
        $this->db->where('page_id !=', $this->input->post('page_id', true));
        $this->db->where('language_code', $this->input->post('language_code', true));
        $this->db->from('page');
        $page_count = $this->db->count_all_results();
        if ($page_count != 0) {
            $this->form_validation->set_message('valid_pagename_e', 'Page URI is already being used!');
            return false;
        }
        return true;
    }

    function valid_pageuri($str) {
        $this->db->where('page_uri', $str);
        $this->db->from('page');
        $page_count = $this->db->count_all_results();
        if ($page_count != 0) {
            $this->form_validation->set_message('valid_pageuri', 'Page URI is already being used!');
            return false;
        }
        return true;
    }

    function valid_pageuri_e($str, $lang) {
        $this->db->where('page_uri', $str);
        $this->db->where('page_id !=', $this->input->post('page_id', true));
        $this->db->where('language_code', $this->input->post('language_code', true));
        $this->db->from('page');
        $page_count = $this->db->count_all_results();
        if ($page_count != 0) {
            $this->form_validation->set_message('valid_pageuri_e', 'Page URI is already being used!');
            return false;
        }
        return true;
    }

    //function valid images for add
    function valid_images($str) {
        if ($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == UPLOAD_ERR_OK) {

            $imginfo = @getimagesize($_FILES['image']['tmp_name']);
            if (!$imginfo) {
                $this->form_validation->set_message('validImage', 'Only image files are allowed');
                return false;
            }

            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
                $this->form_validation->set_message('valid_images', 'Only GIF, JPG and PNG Images are accepted');
                return FALSE;
            }
        }
        return TRUE;
    }

    //function valid images for edit
    function validImage($str) {
        if ($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == UPLOAD_ERR_OK) {

            $imginfo = @getimagesize($_FILES['image']['tmp_name']);
            if (!$imginfo) {
                $this->form_validation->set_message('validImage', 'Only image files are allowed');
                return false;
            }

            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
                $this->form_validation->set_message('validImage', 'Only GIF, JPG and PNG Images are accepted.');
                return FALSE;
            }
        }
        return TRUE;
    }

    function module($str, $module_function) {
        $module_function = explode(',', $module_function);
        $module = trim($module_function[0]);
        $function = trim($module_function['1']);
        if ($module) {
            return $this->$module->$function($str);
        }
        return true;
    }

    //*************************************validation end**********************************************

    function index($offset = 0) {
        $this->load->model('Pagemodel');
        $this->load->helper('text');
        if (!$this->checkAccess('MANAGE_PAGES')) {
            $this->utility->accessDenied();
            return;
        }

        //Fetch pagetree
        $pagetree = '';
        $pagetree = $this->Pagemodel->pageItemTree(0);


        //Get all pages
        $pages = array();
        $pages = $this->Pagemodel->listAllpages(0);

        //render view
        $inner = array();
        $inner['pages'] = $pages;
        $inner['pagetree'] = $pagetree;

        $page = array();
        $page['content'] = $this->load->view('page-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function add() {
        $this->load->model('Pagemodel');
        $this->load->model('Templatemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('MANAGE_PAGES')) {
            $this->utility->accessDenied();
            return;
        }


        //fetch the old page for parent
        $parent = array();
        $parent['0'] = 'Root';
        $pages = $this->Pagemodel->indentedActiveList(0);
        foreach ($pages as $row) {
            $parent[$row['page_id']] = str_repeat('&nbsp;', ($row['level']) * 8) . $row['title'];
        }

        //Form Validations
        $this->form_validation->set_rules('title', 'Page Title', 'trim|required');
        // $this->form_validation->set_rules('page_type', 'Page Type', 'trim|required');
        $this->form_validation->set_rules('parent_id', 'Parent', 'trim');
        $this->form_validation->set_rules('browser_title', 'Browser Title', 'trim');
        $this->form_validation->set_rules('page_alias', 'Page Alias', 'trim|strtolower|callback_valid_pagename');
        $this->form_validation->set_rules('contents', 'Contents', 'trim');
        $this->form_validation->set_rules('meta_title', 'Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Meta Description', 'trim');
        $this->form_validation->set_rules('before_head_close', 'Addtional Header Contents', 'trim');
        $this->form_validation->set_rules('before_body_close', 'Addtional Footer Contents', 'trim');
        $this->form_validation->set_rules('page_template_id', 'Template', 'trim|required');
        $this->form_validation->set_rules('menu_title', 'Menu Title', 'trim');
        $this->form_validation->set_rules('show_in_menu', 'Show In Menu', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //Fetch the page templates 
        $page_template = array();
        $page_template[''] = 'Select';
        $rs = $this->Templatemodel->listAll();
        foreach ($rs as $item) {
            $page_template[$item['page_template_id']] = $item['template_name'];
        }
        $brands = array();
        $brands['0'] = 'Select';
        $rsb = all_brands();
        foreach ($rsb as $item) {
            $brands[$item['id']] = $item['option'];
        }

        //Get all pages
        $pages = array();
        $pages['0'] = 'Root';
        $page = $this->Pagemodel->listAllIndented(0);
        foreach ($page as $row) {
            $pages[$row['page_id']] = $row['page_alias'];
        }

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['pages'] = $pages;
            $inner['parent'] = $parent;
            $inner['page_template'] = $page_template;
            $inner['brands'] = $brands;

            $page = array();
            $page['content'] = $this->load->view('page-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Pagemodel->insertRecord($this->config->item('DEFAULT_LANG'));

            $this->session->set_flashdata('SUCCESS', 'page_added');

            redirect('cms/page/index/', 'location');
            exit();
        }
    }

    //function to edit record
    function edit($pid = false, $target = 1, $tab = 0) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Pagemodel');
        $this->load->model('Blockmodel');
        $this->load->model('Templatemodel');

        if (!$this->checkAccess('MANAGE_PAGES')) {
            $this->utility->accessDenied();
            return;
        }

        //Get Page Details
        $page_details = array();
        $page_details = $this->Pagemodel->detail($pid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        //fetch page data
        $page_data = array();
        $page_data = $this->Pagemodel->fetchPageDataDetail($page_details, FALSE);
        if (!$page_data) {
            $this->utility->show404();
            return;
        }

        //fetch the old page for parent
        $parent = array();
        $parent['0'] = 'Root';
        $pages = array();
        $this->Pagemodel->indentedActiveList(0, $pages);
        foreach ($pages as $row) {
            if ($row['page_id'] == $page_details['page_id'])
                continue;
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
        // $this->form_validation->set_rules('page_type', 'Page Type', 'trim|required');
        $this->form_validation->set_rules('parent_id', 'Parent', 'trim');
        $this->form_validation->set_rules('browser_title', 'Browser Title', 'trim');
        $this->form_validation->set_rules('page_uri', 'Page URI', 'trim|strtolower|callback_valid_pagename_e');
        $this->form_validation->set_rules('contents', 'Contents', 'trim');
        $this->form_validation->set_rules('meta_title', 'Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Meta Description', 'trim');
        $this->form_validation->set_rules('before_head_close', 'JS File', 'trim');
        $this->form_validation->set_rules('before_body_close', 'JS File', 'trim');
        $this->form_validation->set_rules('page_template_id', 'Template', 'trim|required');
        $this->form_validation->set_rules('menu_title', 'Menu Title', 'trim|required');
        $this->form_validation->set_rules('show_in_menu', 'Show In Menu', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $page_template = array();
        $page_template[''] = 'Select';


        //fetch the templates form table
        $rs = $this->Templatemodel->listAll();
        foreach ($rs as $item) {
            $page_template[$item['page_template_id']] = $item['template_name'];
        }
//        code
        $brands = array();
        $brands['0'] = 'Select';
        $rsb = all_brands();
        foreach ($rsb as $item) {
            $brands[$item['id']] = $item['option'];
        }
//        code
        //Admin template module
        $modules = array();
        $this->db->where('page_template_id', $page_details['page_template_id']);
        $query = $this->db->get('page_template');
        $template_details = $query->row_array();
        if ($query->num_rows() == 1) {
            $template_details = $query->row_array();
            if ($template_details['admin_modules']) {
                $modules = explode(',', $template_details['admin_modules']);
                foreach ($modules as $page_module) {
                    $this->load->library("page_modules/" . $page_module, array('page' => $page_details));
                }
            }
        }


        //$this->load->library("page_modules/includes", array('page' => $page_details));

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['modules'] = $modules;
            $inner['page_details'] = $page_details;
            $inner['page_data'] = $page_data;
            $inner['page_template'] = $page_template;
            $inner['brands'] = $brands;
            $inner['pages'] = $pages;
            $inner['parent'] = $parent;
            $inner['blocks_available'] = $blocks_available;
            $inner['tab'] = $tab;
            $inner['target'] = $target;
            $page['content'] = $this->load->view('page-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Pagemodel->updateRecord($page_details, $page_data);

            if ($modules) {
                foreach ($modules as $module) {
                    $this->$module->actionUpdate();
                }
            }

            $this->session->set_flashdata('SUCCESS', 'page_updated');

            $previous_page = $this->session->userdata('PREVIOUS_PAGE');

            if ($this->input->post('button', TRUE) == 'Save and close') {
                redirect('cms/page');
                exit();
            }

            if ($this->input->post('button', TRUE) == 'Save') {
                redirect("cms/page/edit/{$page_details['page_id']}/$target", 'location');
                exit();
            }
        }
    }

    function duplicate($pid = false) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Pagemodel');
        $this->load->model('Blockmodel');
        $this->load->model('Translatemodel');

        //Check access
        if (!$this->checkAccess('MANAGE_DUPLICATES')) {
            $this->utility->accessDenied();
            return;
        }

        //Get Page Details
        $page_details = array();
        $page_details = $this->Pagemodel->detail($pid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }


        //fetch the old page for parent
        $parent = array();
        $parent[$page_details['page_id']] = "Current Location";
        $parent['0'] = '---Root---';
        $pages = array();
        $this->Pagemodel->indentedActiveList(0, $pages);
        foreach ($pages as $row) {
            if ($row['page_id'] == $page_details['page_id'])
                continue;
            $parent[$row['page_id']] = str_repeat('&nbsp;', ($row['level']) * 8) . $row['title'];
        }

        $this->form_validation->set_rules('title', 'Page Title', 'trim|required');
        $this->form_validation->set_rules('page_uri', 'Page URL', 'trim|strtolower|callback_valid_pagename');

        //fetch the block of the page
        $blocks = array();
        $blocks = $this->Blockmodel->fetchAllBlocks($page_details['page_id']);

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['page_details'] = $page_details;
            $inner['parent'] = $parent;
            $page['content'] = $this->load->view('page-duplicate', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $new_page_data = $this->Pagemodel->duplicatePage($page_details);

            if ($this->input->post('duplicate_subpage') == 1) {
                $this->Pagemodel->duplicateChildPage($page_details, $new_page_data);
            }

            $this->session->set_flashdata('SUCCESS', 'page_duplicated');

            redirect('cms/page', 'location');
            exit();
        }
    }

    //function to enable record
    function enable($pid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Pagemodel');

        //Get Page Details
        $page_details = array();
        $page_details = $this->Pagemodel->detail($pid);
        //print_r($page_details); exit();
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        $this->Pagemodel->enableRecord($page_details);

        $this->session->set_flashdata('SUCCESS', 'page_updated');

        redirect("cms/page/index/");
        exit();
    }

    //function to disable record
    function disable($pid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Pagemodel');

        //Get Page Details
        $page_details = array();
        $page_details = $this->Pagemodel->detail($pid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        $this->Pagemodel->disableRecord($page_details);

        $this->session->set_flashdata('SUCCESS', 'page_updated');

        redirect("cms/page/index/");
        exit();
    }

    //function to delete record
    function delete($pid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Pagemodel');

        if (!$this->checkAccess('MANAGE_PAGES')) {
            $this->utility->accessDenied();
            return;
        }

        //Get Page Details
        $page_details = array();
        $page_details = $this->Pagemodel->detail($pid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        $this->Pagemodel->deleteRecord($page_details);

        $this->session->set_flashdata('SUCCESS', 'page_deleted');

        redirect("cms/page/index/");
        exit();
    }

    function remove_banner($pid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Pagemodel');

        //Get Page Details
        $page_details = array();
        $page_details = $this->Pagemodel->detail($pid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        $this->Pagemodel->removeBanner($page_details);

        $this->session->set_flashdata('SUCCESS', 'page_updated');

        redirect("cms/page/");
        exit();
    }

    //Function enable include
    function enable_include($pid = false, $iid = false, $target = FALSE) {
        $this->load->model('Pagemodel');
        $this->load->model('includes/Includemodel');

        //Get Page Details
        $page_details = array();
        $page_details = $this->Pagemodel->detail($pid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        //fetch the include
        $include = array();
        $include = $this->Includemodel->getdetails($iid);
        if (!$include) {
            $this->utility->show404();
            return;
        }

        $this->Pagemodel->enableInclude($page_details, $include);

        $this->session->set_flashdata('SUCCESS', 'page_updated');

        redirect("cms/page/edit/$pid/$target/2");
        exit();
    }

    //Function disable include
    function disable_include($pid = false, $iid = false, $target = FALSE) {
        $this->load->model('Pagemodel');
        $this->load->model('includes/Includemodel');

        //Get Page Details
        $page_details = array();
        $page_details = $this->Pagemodel->detail($pid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        //fetch the include
        $include = array();
        $include = $this->Includemodel->getdetails($iid);
        if (!$include) {
            $this->utility->show404();
            return;
        }


        $this->Pagemodel->disableInclude($page_details, $include);

        $this->session->set_flashdata('SUCCESS', 'page_updated');

        redirect("cms/page/edit/$pid/$target/2");
        exit();
    }

    function updatePageSidebar(){
        $page_id = $this->input->post('page_id');
        $data = [];
        $data['page_sidebar_width'] = $this->input->post('page_sidebar_width');
        $data['sidebar_layout'] = $this->input->post('sidebar_layout');
        $data['page_template_id'] = 3;

        $this->db->where('page_id',$page_id);
        $this->db->update('page', $data);
        return true;
    }
    function systemPages($offset = 0) {
        $this->load->model('Pagemodel');
        $this->load->helper('text');
        if (!$this->checkAccess('MANAGE_PAGES')) {
            $this->utility->accessDenied();
            return;
        }

        //Fetch pagetree
        $pagetree = '';
        $pagetree = $this->Pagemodel->SystempageItemTree(0);


        //Get all pages
        $pages = array();
        $pages = $this->Pagemodel->listAllpages(0);

        //render view
        $inner = array();
        $inner['pages'] = $pages;
        $inner['pagetree'] = $pagetree;

        $page = array();
        $page['content'] = $this->load->view('page-system', $inner, TRUE);
        $this->load->view('shell', $page);
    }
}
