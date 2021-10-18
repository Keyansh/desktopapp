<?php

class Brandmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //get all category
    public function brandList() {
        $this->db->where('active', 1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('brand');
        return $query->result_array();
    }

    //get detail of category
    public function getdetails($bid) {
        $this->db->where('id', $bid);
        $query = $this->db->get('brand');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //Count All category
    public function countAll() {
        $this->db->from('category');
        $this->db->where('active', 1);
        return $this->db->count_all_results();
    }

    //list all category
    public function listAll($offset = false, $limit = false) {
        if ($offset) {
            $this->db->offset($offset);
        }

        if ($limit) {
            $this->db->limit($limit);
        }

        $this->db->where('active', 1);

        $rs = $this->db->get('category');
        return $rs->result_array();
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
        $this->db->insert('brand', $data);
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
        $this->db->update('brand', $data);
    }

    //enable record
    public function enableRecord($category) {
        $data = array();
        $data['active'] = 1;
        $this->db->where('id', $category['id']);
        $this->db->update('brand', $data);
    }

    //disable record
    public function disableRecord($category) {
        $data = array();

        $data['active'] = 0;
        $this->db->where('id', $category['id']);
        $this->db->update('brand', $data);
    }

    //Function Delete Record
    public function deleteBrand($brand) {
        $path = $this->config->item('BRAND_IMAGE_PATH');
        $filename = $path . $brand['image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        $path = $this->config->item('BRAND_THUMBNAIL_PATH');
        $filename = $path . $brand['image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        $path = $this->config->item('BRAND_IMAGE_PATH');
        $filename = $path . $brand['banner'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        //delete the  brand
        $this->db->where('id', $brand['id']);
        $this->db->delete('brand');
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
        $rs = $this->db->get('brand');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('alias', $alt_slug);
                $rs = $this->db->get('brand');
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
