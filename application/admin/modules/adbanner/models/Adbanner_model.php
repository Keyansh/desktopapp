<?php

class Adbanner_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function get_banners() {
        $rs = $this->db->get('ad_banner');

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return FALSE;
    }

    function get_banner($id) {
        $rs = $this->db->where('id', $id)
            ->get('ad_banner');

        if ($rs->num_rows() == 1) {

            return $rs->first_row('array');
        }

        return FALSE;
    }

    function insert_record() {
        $data = array();
        $data['alt'] = $this->input->post('alt', true);
        $data['link'] = $this->input->post('link', true);
        $data['heading'] = $this->input->post('heading', true);
        $data['description'] = $this->input->post('description', false);
        $data['added_on'] = time();

        $imageN = $this->input->post('image');
        if ($imageN) {
            $imageN = str_replace(array('.jpeg','.JPG'), '.jpg', $imageN);
            $data['image'] = $imageN;
        }

        $this->db->insert('ad_banner', $data);
        return;
    }

    function update_record($banner) {
        $data = array();
        $data['alt'] = $this->input->post('alt', true);
        $data['link'] = $this->input->post('link', true);
        $data['heading'] = $this->input->post('heading', true);
        $data['description'] = $this->input->post('description', false);
        $data['added_on'] = time();

        $imageN = $this->input->post('image');
        if ($imageN) {
            $imageN = str_replace(array('.jpeg','.JPG'), '.jpg', $imageN);
            $data['image'] = $imageN;
        }

        $this->db->where('id', $banner['id']);
        $this->db->update('ad_banner', $data);
        return;
    }

    function delete_record($id) {
        $this->db->where('id', $id);
        $this->db->delete('ad_banner');
    }
}

// End of adbaner_mode.php
