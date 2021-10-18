<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Slide extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function updateSortOrder() {
        $sort_data = $this->input->post('menu', true);

        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['sort_order'] = $key + 1;
            $this->db->where('slideshow_image_id', $val);
            $this->db->update('slideshow_image', $update);
        }
        //echo "Done";
        print_r($_POST);
    }

    function uspSortOrder() {
        $sort_data = $this->input->post('menu', true);

        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['sort_order'] = $key + 1;
            $this->db->where('usp_id', $val);
            $this->db->update('usp', $update);
        }
        //echo "Done";
        print_r($_POST);
    }

    function topcatSortOrder() {
        $sort_data = $this->input->post('menu', true);

        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['sort_order'] = $key + 1;
            $this->db->where('id', $val);
            $this->db->update('topcat', $update);
        }
        //echo "Done";
        print_r($_POST);
    }

    function homecatSortOrder() {
        $sort_data = $this->input->post('menu', true);

        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['sort_order'] = $key + 1;
            $this->db->where('id', $val);
            $this->db->update('homecategories', $update);
        }
        //echo "Done";
        print_r($_POST);
    }

    function offerSortOrder() {
        $sort_data = $this->input->post('menu', true);

        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['sort_order'] = $key + 1;
            $this->db->where('id', $val);
            $this->db->update('homeoffers', $update);
        }
        //echo "Done";
        print_r($_POST);
    }

}

?>