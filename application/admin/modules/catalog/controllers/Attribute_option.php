<?php

class Attribute_option extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function has_match_option() {
        $aid = $this->input->post('aid');    
        $exists = $this->db->select('option')
                        ->from('attribute_option')
                        ->where('option', $this->input->post('option'))
                        ->where('attr_id', $aid)
                        ->get()->row_array();                        
        if (!$exists) {
            return true;
        } else {
            $this->form_validation->set_message('has_match_option', 'Attribute option already exists');
            return false;
        }
    }

    function index($aid = 0, $offset = 0) {
        $this->load->model('Attributeoptionmodel');
        $this->load->model('Attributesmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('text');
        $this->load->library('pagination');

        //get attributes details
        $attributes = array();
        $attributes = $this->Attributesmodel->getDetails($aid);
        if (!$attributes) {
            $this->utility->show404();
            return;
        }

        //Setup Pagination
        $perpage = 500;
        $config['base_url'] = base_url() . "attribute/index/$aid";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Attributeoptionmodel->countAll($attributes['id']);
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //get all attributes options
        $attributes_options = array();
        $attributes_options = $this->Attributeoptionmodel->listAll($attributes['id'], $offset, $perpage);


        //render view
        $inner = array();
        $inner['attributes'] = $attributes;
        $inner['attributes_value'] = $attributes_options;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('attributes/attributesoption/attributesvalue-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //Function Add attributes
    function add($aid = false) {
        $this->load->model('Attributeoptionmodel');
        $this->load->model('Attributesmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Get attributes Detail
        $attributes = array();
        $attributes = $this->Attributesmodel->getDetails($aid);
        if (!$attributes) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('option', 'Attribute Option', 'trim|required|callback_has_match_option');
        $this->form_validation->set_rules('additional_info', 'Additional Info', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['attributes'] = $attributes;
            $page['content'] = $this->load->view('attributes/attributesoption/attributesvalue-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Attributeoptionmodel->insertRecord($attributes);

            $this->session->set_flashdata('SUCCESS', 'attributes_added');

            redirect("catalog/attribute_option/index/$aid");
            exit();
        }
    }

    //Function Edit attributesvalue
    function edit($av_id = 0) {
        $this->load->model('Attributeoptionmodel');
        $this->load->model('Attributesmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Get attributes Detail
        $attributes_option = array();
        $attributes_option = $this->Attributeoptionmodel->details($av_id);
        if (!$attributes_option) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('option', 'Attribute Option ', 'trim|required');
        $this->form_validation->set_rules('additional_info', 'Additional Info', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['attributes_value'] = $attributes_option;
            $page['content'] = $this->load->view('attributes/attributesoption/attributesvalue-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Attributeoptionmodel->updateRecord($attributes_option);

            $this->session->set_flashdata('SUCCESS', 'attributesvalue_updated');

            redirect("catalog/attribute_option/index/{$attributes_option['attr_id']}");
            exit();
        }
    }

    public function remove($id) {
        $this->load->model('Attributeoptionmodel');
        $option = $this->Attributeoptionmodel->details($id);
        $path = $this->config->item('ATTRIBUTE_OPTION_ICON_PATH');
        $file = $path . $option['icon'];
        @unlink($file);
        $this->Attributeoptionmodel->deleteIcon($id);
        redirect('catalog/attribute_option/edit/' . $id);
    }

    public function delete($id) {
        $this->load->model('Attributeoptionmodel');
        $option = $this->Attributeoptionmodel->details($id);
        $path = $this->config->item('ATTRIBUTE_OPTION_ICON_PATH');
        $file = $path . $option['icon'];
        @unlink($file);
        $attr_id = $option['attr_id'];
        $this->Attributeoptionmodel->deleteAttrOpt($id);
        redirect('catalog/attribute_option/index/' . $attr_id);
    }

}

?>