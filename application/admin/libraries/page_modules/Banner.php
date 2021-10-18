<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banner {

    private $CI;
    private $page;
    private $module_alias = 'banner';
    private $module_name = 'Banner';

    function __construct($params) {
        $this->CI = & get_instance();
        $this->page = $params['page'];
        $this->init();
    }

    function valid_image($str) {
        if ($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == UPLOAD_ERR_OK) {

            $imginfo = @getimagesize($_FILES['image']['tmp_name']);
            if (!$imginfo) {
                $this->CI->form_validation->set_message('module', 'Only image files are allowed');
                return false;
            }

            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
                $this->CI->form_validation->set_message('module', 'Only GIF, JPG and PNG Images are accepted.');
                return FALSE;
            }
        }

        return TRUE;
    }

    function init() {
        $this->CI->load->library('form_validation');
        $this->CI->form_validation->set_rules('image_v', 'Main Banner', 'trim|required|callback_module[banner, valid_image]');
    }

    function getName() {
        return $this->module_name;
    }

    function getAlias() {
        return $this->module_alias;
    }

    function addView() {
        return "add";
    }

    //function to edit record
    function editView() {
        $this->CI->load->library('form_validation');
        $this->CI->load->helper('form');
        $this->CI->load->model('cms/Pagemodel');

        $banner = array();
        $banner = $this->CI->Pagemodel->getModuleData($this->page['page_id'], $this->getAlias(), 'image');

        $inner = array();
        $inner['page'] = $this->page;
        $inner['banner'] = $banner;

        return $this->CI->load->view('cms/page_modules/banner/edit', $inner, true);
    }

    function actionAdd() {
        echo "add";
    }

    function actionDelete() {
        $this->CI->load->model('cms/Pagemodel');
        $page = $this->page;

        $banner = array();
        $banner = $this->CI->Pagemodel->getModuleData($this->page['page_id'], $this->getAlias(), 'image');

        $path = $this->CI->config->item('PAGE_PATH');
        $filename = $path . $banner['image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }

        $this->CI->db->where('page_data_id', $banner['page_data_id']);
        $this->CI->db->delete('page_data');
    }

    function actionUpdate() {
        $this->CI->load->model('cms/Pagemodel');
        $page = $this->page;

        $banner = array();
        $banner = $this->CI->Pagemodel->getModuleData($this->page['page_id'], $this->getAlias(), 'image');

        //Upload Image
        $config['upload_path'] = $this->CI->config->item('PAGE_PATH');
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $this->CI->load->library('upload', $config);
        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!$this->CI->upload->do_upload('image')) {
                    show_error($this->CI->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->CI->upload->data();

                    $data = array();
                    $data['page_setting_value'] = $upload_data['file_name'];
                    $data['page_setting'] = "image";
                    $data['module_name'] = $this->getAlias();
                    $data['page_id'] = $page['page_id'];
                    $this->CI->db->insert('page_data', $data);

                    if ($banner) {
                        $this->CI->db->where('page_data_id', $banner['page_data_id']);
                        $this->CI->db->delete('page_data');

                        $path = $this->CI->config->item('PAGE_PATH');
                        $filename = $path . $banner['page_setting_value'];
                        if (file_exists($filename)) {
                            @unlink($filename);
                        }
                    }
                }
            }
        }
    }

}

?>