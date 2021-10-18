<?php

class Gallerymodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //Get detail of News
    public function getdetails($nid) {
        $this->db->where('id', intval($nid));
        $query = $this->db->get('gallery');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }

        return false;
    }

    //Count All News
    public function countAll() {
        $this->db->from('gallery');

        return $this->db->count_all_results();
    }

    //list all News 
    public function listAll($offset = false, $limit = false) {
        if ($offset) {
            $this->db->offset($offset);
        }

        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->order_by('id', DESC);
        $rs = $this->db->get('gallery');

        return $rs->result_array();
    }

    //insert record
    public function insertRecord() {
        $data = array();
      

        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('GALLERY_IMAGE_PATH');
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
  
                }
            }
        }
        $data['show_in_homepage'] = $this->input->post('show_in_homepage', true);
        $data['project_name'] = $this->input->post('project_name', false);
        $data['alt'] = $this->input->post('alt', false);
        $data['location'] = $this->input->post('location', false);
        $data['added_on'] = time();
        $this->db->insert('gallery', $data);
        return;
    }

    //update record
    public function updateRecord($gallery) {
        $data = array();


        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('GALLERY_IMAGE_PATH');
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
           
                }
            }
        }
        $data['show_in_homepage'] = $this->input->post('show_in_homepage', true);
        $data['project_name'] = $this->input->post('project_name', false);
        $data['alt'] = $this->input->post('alt', false);
        $data['location'] = $this->input->post('location', false);
        $data['added_on'] = time();
        $this->db->where('id', $gallery['id']);
        $this->db->update('gallery', $data);

        return;
    }

    //Function Delete Record
    public function deleteRecord($gallery) {
        $this->db->where('id', $gallery['id']);
        $this->db->delete('gallery');

        $path = $this->config->item('GALLERY_IMAGE_PATH');
        $filename = $path . $gallery['image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }

        
    }

    //Function Delete Record
    public function deleteImage($blog) {
        $data = array();
        $data['image'] = '';

        $this->db->where('blog_id', $blog['blog_id']);
        $this->db->update('blog', $data);

        return;
    }

  

}
