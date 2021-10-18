<?php

class Testimonialmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getdetails($id) {
        $this->db->where('id', intval($id));
        $query = $this->db->get('testimonial');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    public function countAll() {
        $this->db->from('testimonial');
        return $this->db->count_all_results();
    }

    public function listAll($offset = false, $limit = false) {
        if ($offset) {
            $this->db->offset($offset);
        }

        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->order_by('sort_order', 'ASC');
        $rs = $this->db->get('testimonial');
        return $rs->result_array();
    }

    public function insertRecord() {
        $data = array();
        $data['testimonial'] = $this->input->post('testimonial', true);
        // if ($this->input->post('url_alias', true) == '') {
        //     $data['test_alias'] = $this->_slug($this->input->post('name', true));
        // } else {
        //     $data['test_alias'] = url_title($this->input->post('url_alias', true));
        // }
        $data['name'] = $this->input->post('name', true);
        // $data['alt'] = $this->input->post('alt', true);
        $data['address'] = $this->input->post('address', true);
        if ($this->input->post('browser_title', true) == '') {
            $data['browser_title'] = $this->input->post('name', true);
        } else {
            $data['browser_title'] = url_title($this->input->post('browser_title', true));
        }
        $data['show_in_homepage'] = $this->input->post('show_in_homepage', true);
        // $data['browser_title'] = $this->input->post('browser_title', false);
        // $data['browser_title'] = $this->input->post('browser_title', false);
        $data['meta_keywords'] = $this->input->post('meta_keywords', false);
        $data['meta_description'] = $this->input->post('meta_description', false);
        $data['active'] = 1;
        $data['added_on'] = time();
        //upload image
        // $config = array();
        // $config['upload_path'] = $this->config->item('TEST_IMAGE_PATH');
        // $config['allowed_types'] = 'jpg|jpeg|gif|png';
        // $config['overwrite'] = false;
        // $this->load->library('upload', $config);

        // if (count($_FILES) > 0) {
        //     //Check for valid image upload
        //     if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
        //         if (!$this->upload->do_upload('image')) {
        //             show_error($this->upload->display_errors('<p class="err">', '</p>'));
        //             return false;
        //         } else {
        //             $upload_data = $this->upload->data();
        //             $data['image'] = $upload_data['file_name'];
        //         }
        //     }
        // }
        $this->db->insert('testimonial', $data);
        return;
    }

    public function updateRecord($testimonial) {
        $data = array();
        $data['testimonial'] = $this->input->post('testimonial', true);
        // if ($this->input->post('url_alias', true) == '') {
        //     $data['test_alias'] = $testimonial['test_alias'];
        // } else {
        //     $data['test_alias'] = url_title($this->input->post('url_alias', true));
        // }
        $data['name'] = $this->input->post('name', true);
        // $data['alt'] = $this->input->post('alt', true);
        $data['address'] = $this->input->post('address', true);
        if ($testimonial['active'] == 1) {
            $data['active'] = $testimonial['active'];
        } else {
            
        }
        if ($this->input->post('browser_title', true) == '') {
            $data['browser_title'] = $this->input->post('name', true);
        } else {
            $data['browser_title'] = url_title($this->input->post('browser_title', true));
        }
        $data['show_in_homepage'] = $this->input->post('show_in_homepage', true);
        // $data['browser_title'] = $this->input->post('browser_title', false);
        $data['meta_keywords'] = $this->input->post('meta_keywords', false);
        $data['meta_description'] = $this->input->post('meta_description', false);
        //upload image
        // $config = array();
        // $config['upload_path'] = $this->config->item('TEST_IMAGE_PATH');
        // $config['allowed_types'] = 'jpg|jpeg|gif|png';
        // $config['overwrite'] = false;
        // $this->load->library('upload', $config);

        // if (count($_FILES) > 0) {
        //     //Check for valid image upload
        //     if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
        //         if (!$this->upload->do_upload('image')) {
        //             show_error($this->upload->display_errors('<p class="err">', '</p>'));

        //             return false;
        //         } else {
        //             $upload_data = $this->upload->data();
        //             $data['image'] = $upload_data['file_name'];
        //         }
        //     }
        // }
        $this->db->where('id', $testimonial['id']);
        $this->db->update('testimonial', $data);
        return;
    }

    public function deleteRecord($testimonial) {
        $this->db->where('id', $testimonial['id']);
        $this->db->delete('testimonial');
    }

    //function slug
    public function _slug($blogtitle) {
        $blog_title = ($blogtitle) ? $blogtitle : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $blog_title;
        $slug = trim($slug);
        $slug = str_replace($replace_array, '', $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('test_alias', $slug);
        $rs = $this->db->get('testimonial');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('test_alias', $alt_slug);
                $rs = $this->db->get('testimonial');
                if ($rs->num_rows() > 0) {
                    $slug_check = true;
                }

                ++$suffix;
            } while ($slug_check);
            $slug = $alt_slug;
        }

        return $slug;
    }

}
