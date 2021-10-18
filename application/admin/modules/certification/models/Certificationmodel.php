<?php

class Certificationmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //get all category
    public function brandList() {
        $this->db->where('active', 1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('certification');
        return $query->result_array();
    }

    //get detail of category
    public function getdetails($bid) {
        $this->db->where('id', $bid);
        $query = $this->db->get('certification');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }


    //insert record
    public function insertRecord() {
        $data = array();
        $data['name'] = $this->input->post('name', true);
        if ($this->input->post('uri', true) == '') {
            $data['alias'] = $this->_slug($this->input->post('name', true));
        } else {
            $data['alias'] = url_title($this->input->post('uri', true), '-', true);
        }
        $data['alt'] = $this->input->post('alt', true);
        $data['description'] = $this->input->post('description', true);
        $data['browser_title'] = $this->input->post('browser_title', true);
        $data['meta_keywords'] = $this->input->post('meta_keywords', true);
        $data['meta_description'] = $this->input->post('meta_description', true);
        $data['active'] = '1';

        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('BRAND_IMAGE_PATH');
        $config['allowed_types'] = 'jpg|jpeg|gif|png';
        $config['overwrite'] = false;
        $this->load->library('upload', $config);

        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!$this->upload->do_upload('image')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return false;
                } else {
                    $upload_data = $this->upload->data();
                    $data['image'] = $upload_data['file_name'];

                    //resizing Medium image
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $this->config->item('BRAND_IMAGE_PATH') . $data['image'];
                    $config['new_image'] = $this->config->item('BRAND_THUMBNAIL_PATH') . $data['image'];
                    $config['create_thumb'] = false;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 217;
                    $config['height'] = 67;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                }
            }
        }
        $this->db->insert('certification', $data);
    }

    //update record
    public function updateRecord($brand) {
        $data = array();
        $data['name'] = $this->input->post('name');
        if ($this->input->post('uri', true) == '') {
            $data['alias'] = $brand['alias'];
        } else {
            $data['alias'] = $this->input->post('uri', true);
        }
        $data['alt'] = $this->input->post('alt', true);
        $data['description'] = $this->input->post('description', true);
        $data['meta_keywords'] = $this->input->post('meta_keywords', true);
        $data['meta_description'] = $this->input->post('meta_description', true);

        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('BRAND_IMAGE_PATH');
        $config['allowed_types'] = 'jpg|jpeg|gif|png';
        $config['overwrite'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!$this->upload->do_upload('image')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return false;
                } else {
                    $upload_data = $this->upload->data();
                    $data['image'] = $upload_data['file_name'];
                    //resizing Medium image
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $this->config->item('BRAND_IMAGE_PATH') . $data['image'];
                    $config['new_image'] = $this->config->item('BRAND_THUMBNAIL_PATH') . $data['image'];
                    $config['create_thumb'] = false;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 217;
                    $config['height'] = 60;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $path = $this->config->item('BRAND_IMAGE_PATH');
                    $filename = $path . $brand['image'];
                    if (file_exists($filename)) {
                        @unlink($filename);
                    }
                }
            }
        }
        $this->db->where('id', $brand['id']);
        $this->db->update('certification', $data);
    }


    //Function Delete Record
    public function deletecertification($certification) {
        $path = $this->config->item('BRAND_IMAGE_PATH');
        $filename = $path . $certification['image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        $path = $this->config->item('BRAND_THUMBNAIL_PATH');
        $filename = $path . $certification['image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        $path = $this->config->item('BRAND_IMAGE_PATH');
        $filename = $path . $certification['banner'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        //delete the  brand
        $this->db->where('id', $certification['id']);
        $this->db->delete('certification');
    }

    //function slug
    public function _slug($cname) {
        $brand_name = ($cname) ? $cname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $brand_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('alias', $slug);
        $rs = $this->db->get('certification');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('alias', $alt_slug);
                $rs = $this->db->get('certification');
                if ($rs->num_rows() > 0) {
                    $slug_check = true;
                }

                $suffix++;
            } while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }

}
