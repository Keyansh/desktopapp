<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index($group_id = 0) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Settingsmodel');

        if (!$this->checkAccess('MANAGE_SETTINGS')) {
            $this->utility->accessDenied();
            return;
        }

        //Groups
        if ($group_id) {
            $groups = $this->Settingsmodel->fetchConfigGroup($group_id);
        } else {
            $groups = $this->Settingsmodel->getConfigGroups();
        }


        //Settings
        $settings = array();
        $settings_rs = $this->Settingsmodel->getAllConfig($group_id);
        foreach ($settings_rs as $row) {
            $settings[$row['config_group_id']][] = $row;
        }


        //Form Validation
        foreach ($settings_rs as $row) {
            $key = $row['config_key'];
            $label = $row['config_label'];
            $this->form_validation->set_rules("$key", "$label", 'trim');
        }

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['groups'] = $groups;
            $inner['group_id'] = $group_id;

            $inner['settings'] = $settings;
            $page['content'] = $this->load->view('settings-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Settingsmodel->update($settings_rs);
            $this->session->set_flashdata('SUCCESS', 'settings_updated');
            redirect("setting/settings/index/$group_id", 'location');
            exit();
        }
    }

    function remove_image($key = false) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Settingsmodel');

        $setting = array();
        $setting = $this->Settingsmodel->getByKey($key);

        $this->Settingsmodel->DeleteImage($setting);
        $this->session->set_flashdata('SUCCESS', 'settings_updated');
        redirect("setting/settings/index", 'location');
        exit();
    }

    function widget_settings($pid = 0, $wid = 0) {
        $this->load->model('cms/Pagemodel');

        //Get Page Details
        $page_details = array();
        $page_details = $this->Pagemodel->detail($pid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        $this->db->where('widget_id', $wid);
        $rs = $this->db->get('widget');
        if (!$rs || $rs->num_rows() != 1)
            return;
        $widget = $rs->row_array();

        $class = $widget['widget_class'];
        $this->load->library("widget/$class");
        $this->$class->init($widget);
        $this->$class->settings($page_details);
    }

}

?>