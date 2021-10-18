<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pagebuilder extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_admin_protected = true;
        $this->load->model('Pagebuildermodel');
    }

    function validate_template($str)
    {
        $field_value = $str;
        $template = $this->db->where('template_name', $field_value)->get('pagebuilder_templates')->row_array();
        if ($template) {
            return false;
        } else {
            return true;
        }
    }

    public function index($pid = 0, $offset = 0)
    {
        $this->load->model('Pagebuildermodel');
        $this->load->model('Pagemodel');
        $this->load->model('Sidebarmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('pagination');

        if (!$this->checkAccess('MANAGE_PAGE_BLOCKS')) {
            $this->utility->accessDenied();
            return;
        }

        $pages = array();
        $pages = $this->Pagemodel->detail($pid);
        if (!$pages) {
            $this->utility->show404();
            return;
        }

        $block = array();
        $block = $this->Pagebuildermodel->listAll($pid);

        $sideMenus = array();
        $sideMenus = $this->Sidebarmodel->listAll();

        $pagebuiltderElements = array();
        $pagebuiltderElements = $this->Pagebuildermodel->listAllElements();

        $pageTemplates = array();
        $pageTemplates = $this->Pagebuildermodel->getPageTemplates();

        $inner = array();
        $inner['block'] = $block;
        $inner['pages'] = $pages;
        $inner['pagebuiltderElements'] = $pagebuiltderElements;
        $inner['sideMenus'] = $sideMenus;
        $inner['pageTemplates'] = $pageTemplates;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('pagebuilder/pagebuilder-index', $inner, true);
        $this->load->view('shell', $page);
    }

    public function pageBuilderView()
    {
        $res = $data = $data1 =  [];
        $element_id =  $this->input->post('element_id');
        $page_id =  $this->input->post('page_id');
        $row_id =  $this->input->post('row_id');
        $column_id =  $this->input->post('column_id');
        $element_alias =  $this->input->post('element_alias');
        $element_style_fields =  $this->input->post('element_style_fields');
        $element_item_fields = $this->input->post('element_item_fields');
        $block_item_content = $this->input->post('block_item_content');
        $block_style_content = $this->input->post('block_style_content');
        $element_table =  $this->input->post('element_table');

        $data['element_id'] = $element_id;
        $data['page_id'] = $page_id;
        $data['row_id'] = $row_id;
        $data['column_id'] = $column_id;
        $data['element_alias'] = $element_alias;
        $data['element_style_fields'] = $element_style_fields;
        $data['block_style_content'] = $block_style_content;
        $data['element_table'] = $element_table;
        $configForm = $this->load->view('pagebuilder/widgets/inc-style-form', $data, true);

        $data1['element_id'] = $element_id;
        $data1['page_id'] = $page_id;
        $data1['row_id'] = $row_id;
        $data1['column_id'] = $column_id;
        $data1['element_alias'] = $element_alias;
        $data1['element_item_fields'] = $element_item_fields;
        $data1['block_item_content'] = $block_item_content;
        $data1['element_table'] = $element_table;
        $itemForm = $this->load->view('pagebuilder/widgets/inc-item-form', $data1, true);

        $res['success'] = true;
        $res['configForm'] = $configForm;
        $res['itemForm'] = $itemForm;
        echo json_encode($res);
    }

    public function pagebuilderElementStyledata()
    {
        $page_id = $this->input->post('page_id');
        $column_id = $this->input->post('column_id');
        $row_id = $this->input->post('row_id');
        $data = array();
        $data['element_id'] = $this->input->post('element_id');
        $data['element_alias'] = $this->input->post('element_alias');
        unset($_POST['element_id']);
        unset($_POST['page_id']);
        unset($_POST['row_id']);
        unset($_POST['column_id']);
        unset($_POST['element_alias']);
        // e(json_encode($this->input->post()));
        $data['style_config'] = json_encode($this->input->post());
        $this->db->where('id', $column_id);
        $this->db->where('row_id', $row_id);
        $this->db->where('page_id', $page_id);
        $this->db->update('pagebuilder_columns', $data);
        $res['success'] = true;
        echo json_encode($res);
    }

    public function pagebuilderElementformdata()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');

        $elementAlias = $this->input->post('element_alias');

        // if ($elementAlias == 'heading') {
        //     $this->form_validation->set_rules('heading', 'Heading', 'trim|required');
        // }
        // if ($elementAlias == 'text') {
        //     $this->form_validation->set_rules('content', 'Description', 'trim|required');
        // }
        // if ($elementAlias == 'banner' || $elementAlias == 'image') {
        //     if (empty($_FILES['image']['name'])) {
        //         $this->form_validation->set_rules('image', 'Image', 'required');
        //     }
        // }
        $this->form_validation->set_rules('element_alias', ' ', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $res =  [];
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            $res['success'] = false;
            $res['message'] = $errors;
        } else {
            $InsertedElementData =  $this->Pagebuildermodel->insertElementRecord();
            $res['success'] = true;
        }
        echo json_encode($res);
    }

    public function insertRowAndColumnForm()
    {
        $this->Pagebuildermodel->insertRowAndColumnFormData();
        $res =  [];
        $res['success'] = true;
        $res['message'] = 'inserted';
        echo json_encode($res);
    }

    function updateSortOrder()
    {
        $sort_data = $this->input->post('order');
        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['sort_order'] = $key + 1;
            $this->db->where('id', $val);
            $this->db->update('pagebuilder_page_rows', $update);
        }
    }

    function updateRowColumns()
    {
        $this->Pagebuildermodel->updateRowColumns();
        return true;
    }

    function getSelectedValueData()
    {

        $result = [];
        $uri = '';
        $title = '';
        $front_uri = "";
        $value = $this->input->post('selectedValue');
        if ($value == 'page') {
            $uri = 'page_uri';
            $title = 'title';
            $front_uri = "";
        }
        if ($value == 'news') {
            $uri = 'news_alias';
            $title = 'news_title';
            $front_uri = $value . '/';
        }
        if ($value == 'services') {
            $uri = 'url_alias';
            $title = 'title';
            $front_uri = $value . '/';
        }
        $this->db->where('active', 1);
        $rs = $this->db->get($value);
        $data = $rs->result_array();
        $html = '';
        $html .= '<option>--select--</option>';
        foreach ($data as $item) {
            $html .= '<option value="' . $front_uri . $item[$uri] . '">' . $item[$title] . '</option>';
        }
        $result['content'] = $html;
        $result['success'] = true;
        $result['linktype'] = 'link item';

        echo json_encode($result);
    }

    function rowUpdateView()
    {
        $page_id = $this->input->post('page_id');
        $row_id = $this->input->post('row_id');
        $data = $res = [];
        $data['row_data'] = $this->Pagebuildermodel->getRowData($page_id, $row_id);
        $data['page_id'] = $page_id;
        $data['row_id'] = $row_id;
        // e($data['row_data']);
        $res['view'] = $this->load->view('pagebuilder/widgets/inc-update-row', $data, true);
        echo json_encode($res);
    }

    function rowUpdate()
    {
        $res = [];
        $res['data'] = $this->Pagebuildermodel->updateRow();
        $res['success'] = true;
        echo json_encode($res);
    }
    // function onpageloadCheckPublish()
    // {
    //     $pid = $this->input->post('pagid');
    //     $CI = $this;
    //     $CI->db->where('page_id', $pid);
    //     $CI->db->where('is_publish', 0);
    //     $CI->db->delete('pagebuilder_page_rows');

    //     $CI->db->where('page_id', $pid);
    //     $CI->db->where('is_publish', 0);
    //     $CI->db->delete('pagebuilder_columns');
    // }
    function PublishPage()
    {
        $pid = $this->input->post('pagid');

        $data['is_publish'] = 1;
        $this->db->where('page_id', $pid);
        $this->db->update('pagebuilder_page_rows', $data);
        $this->db->where('page_id', $pid);
        $this->db->update('pagebuilder_columns', $data);
    }

    function addSideMenulist()
    {
        $data = [];
        $page_id = $this->input->post('page_id');
        $data['sidebar_menu_id'] = json_encode($this->input->post('menu_id'));
        $this->db->where('page_id', $page_id)->update('page', $data);
        return true;
    }

    function savePageTemplate()
    {
        $res = [];
        $this->form_validation->set_rules('template_name', 'Template Name', 'required|callback_validate_template');
        $this->form_validation->set_message('validate_template', 'This template already exits.');

        if ($this->form_validation->run() == FALSE) {
            $res['success'] = false;
            $res['message'] = validation_errors();
        } else {
            $this->Pagebuildermodel->savePageTemplate();
            $res['success'] = true;
            $res['message'] = 'Template saved successfully!';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }

    function assignPageTemplate()
    {
        $res = [];
        $this->Pagebuildermodel->assignPageTemplate();
        $res['success'] = true;
        $res['message'] = 'Template assigned successfully!';
        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }
    function getModelData()
    {
        $result = [];
        $id = '';
        $title = '';
        $active = "";
        $value = $this->input->post('selectedValue');
        $addedValue = $this->input->post('addedValue');
        $selectedData = json_decode($addedValue);

        if ($value == 'category') {
            $id = 'id';
            $title = 'name';
            $active = "active";
        }
        if ($value == 'projects') {
            $id = 'projects_id';
            $title = 'projects_title';
            $active = "active";
        }
        if ($value == 'product') {
            $id = 'id';
            $title = 'name';
            $active = "is_active";
        }

        $this->db->where($active, 1);
        $rs = $this->db->get($value);
        $data = $rs->result_array();


        $html = '';
        foreach ($data as $item) {
            $selected = in_array($item[$id], $selectedData) ? "selected" : " ";
            $html .= '<option ' . $selected . ' value="' . $item[$id] . '">' . $item[$title] . '</option>';
        }
        $result['content'] = $html;
        $result['success'] = true;
        echo json_encode($result);
    }
}
