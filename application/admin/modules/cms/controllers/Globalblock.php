<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Globalblock extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //**************************validation start***************************
    //function valid page block for add
    function valid_block($str) {
        $this->db->where('block_alias', $str);
        $this->db->where('page_id', 0);
        $this->db->from('block');
        $block_count = $this->db->count_all_results();
        if ($block_count != 0) {
            $this->form_validation->set_message('valid_block', 'Block Alias is already being used!');
            return false;
        }
        return true;
    }

    //function valid page block for edit
    function validBlock($str) {
        $this->db->where('block_alias', $str);
        $this->db->where('page_id', 0);
        $this->db->where('page_id !=', $this->input->post('page_id', true));
        $this->db->from('block');
        $block_count = $this->db->count_all_results();
        if ($block_count != 0) {
            $this->form_validation->set_message('validBlock', 'Block Alias is already being used!');
            return false;
        }
        return true;
    }

    //*************************************validation end**********************************************
    function index($offset = 0) {
        $this->load->model('Globalblockmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('pagination');

        if (!$this->checkAccess('MANAGE_GLOBAL_BLOCKS')) {
            $this->utility->accessDenied();
            return;
        }

        //Setup pagination
        $perpage = 20;
        $config['base_url'] = base_url() . "globalblock/index/";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Globalblockmodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //list all block
        $global_blocks = array();
        $global_blocks = $this->Globalblockmodel->listAll($offset, $perpage);

        //render view
        $inner = array();
        $inner['global_blocks'] = $global_blocks;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('global_block-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add block
    function add() {
        $this->load->model('Globalblockmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('ADD_GLOBAL_BLOCKS')) {
            $this->utility->accessDenied();
            return;
        }

        //validation check
        $this->form_validation->set_rules('block_title', 'Block Title', 'trim|required');
        $this->form_validation->set_rules('block_link', 'Block Link', 'trim');
        $this->form_validation->set_rules('block_image_alt', 'Block Image Alt', 'trim');
        $this->form_validation->set_rules('block_alias', 'Block Alias', 'trim|required|callback_valid_block');
        $this->form_validation->set_rules('block_contents', 'Contents', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('global_block-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Globalblockmodel->insertRecord();

            $this->session->set_flashdata('SUCCESS', 'globalblock_added');

            redirect("cms/globalblock/index/", "location");
            exit();
        }
    }

    //function edit page block
    function edit($g_bid = false) {
        $this->load->model('Globalblockmodel');
        $this->load->helper('text');
        $this->load->library('form_validation');

        if (!$this->checkAccess('EDIT_GLOBAL_BLOCKS')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the block details
        $global_block = array();
        $global_block = $this->Globalblockmodel->getDetails($g_bid);
        if (!$global_block) {
            $this->utility->show404();
            return;
        }

        //Global Blocks
        $blocks_available = array();
        $global_blocks = array();
        $blocks_available[] = 'block_main';
        $global_blocks = $this->Globalblockmodel->listAll();
        foreach ($global_blocks as $row) {
            $blocks_available[] = $row['block_alias'];
        }

        //fetch  page template
        $File = $global_block['block_alias'] . '.php';
        $path = $this->config->item('BLOCK_TEMPLATE_PATH');

        //validation check
        $this->form_validation->set_rules('block_title', 'Block Title', 'trim|required');
        $this->form_validation->set_rules('block_link', 'Block Link', 'trim');
        $this->form_validation->set_rules('block_image_alt', 'Block Image Alt', 'trim');
        $this->form_validation->set_rules('block_alias', 'Block Alias', 'trim|required|callback_validBlock');
        $this->form_validation->set_rules('block_contents', 'Contents', 'trim');
        $this->form_validation->set_rules('block_template', 'Template', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //render view
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['global_block'] = $global_block;
            $inner['blocks_available'] = $blocks_available;
            $page['content'] = $this->load->view('global_block-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Globalblockmodel->updateRecord($global_block);

            $this->session->set_flashdata('SUCCESS', 'globalblock_updated');

            redirect("cms/globalblock/index/", "location");
            exit();
        }
    }

    function delete($g_bid = false) {
        $this->load->model('Globalblockmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        if (!$this->checkAccess('DELETE_GLOBAL_BLOCKS')) {
            $this->utility->accessDenied();
            return;
        }

        //fetch the block details
        $global_block = array();
        $global_block = $this->Globalblockmodel->getDetails($g_bid);
        if (!$global_block) {
            $this->utility->show404();
            return;
        }

        $this->Globalblockmodel->deleteRecord($global_block);

        $this->session->set_flashdata('SUCCESS', 'globalblock_deleted');
        redirect("cms/globalblock/index/", "location");
        exit();
    }

}

?>