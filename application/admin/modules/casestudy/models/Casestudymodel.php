<?php

class Casestudymodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Get detail of CaseStudy
    function getdetails($cid) {
        $this->db->where('casestudy_id', intval($cid));
        $query = $this->db->get('casestudy');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //Count All CaseStudy
    function countAll() {
        $this->db->from('casestudy');
        return $this->db->count_all_results();
    }

    //List All Records
    function getPage() {

        $this->db->order_by('page_title', 'ASC');
        $rs = $this->db->get('page');
        return $rs->result_array();
    }

    //list all CaseStudy
    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $this->db->order_by('added_on', 'DESC');
        $rs = $this->db->get('casestudy');
        return $rs->result_array();
    }

    //insert record
    function insertRecord() {
        $data = array();
        $data['title'] = $this->input->post('title', true);
        if ($this->input->post('url_alias', TRUE) == '') {
            $data['url_alias'] = $this->_slug($this->input->post('title', TRUE));
        } else {
            $data['url_alias'] = url_title($this->input->post('url_alias', TRUE));
        }
        $data['contents'] = $this->input->post('contents', true);
        $data['added_on'] = time();

        //upload image
        $config['upload_path'] = $this->config->item('CASESTUDY_PATH');
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);
        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!$this->upload->do_upload('image')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    $data['image'] = $upload_data['file_name'];

                    //Generate thumbnail image
                    $config = array();
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $this->config->item('CASESTUDY_PATH') . $data['image'];
                    $config['new_image'] = $this->config->item('CASESTUDY_THUMBNAIL_PATH') . $data['image'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = DWS_CASESTUDY_THUMBNAIL_WIDTH;
                    $config['height'] = DWS_CASESTUDY_THUMBNAIL_HEIGHT;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                }
            }
        }

        $this->db->insert('casestudy', $data);
        return;
    }

    //update record
    function updateRecord($casestudy) {
        $data = array();
        $data['title'] = $this->input->post('title', true);
        if ($this->input->post('url_alias', TRUE) == '') {
            $data['url_alias'] = $casestudy['url_alias'];
        } else {
            $data['url_alias'] = url_title($this->input->post('url_alias', TRUE));
        }
        $data['contents'] = $this->input->post('contents', true);
        //$data['added_on'] = time();
        //Upload Image
        $config = array();
        $config['upload_path'] = $this->config->item('CASESTUDY_PATH');

        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);

        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!$this->upload->do_upload('image')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    $data['image'] = $upload_data['file_name'];

                    //Generate thumbnail image
                    $config = array();
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $this->config->item('CASESTUDY_PATH') . $data['image'];
                    $config['new_image'] = $this->config->item('CASESTUDY_THUMBNAIL_PATH') . $data['image'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = DWS_CASESTUDY_THUMBNAIL_WIDTH;
                    $config['height'] = DWS_CASESTUDY_THUMBNAIL_HEIGHT;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    //delete main 
                    $path = $this->config->item('CASESTUDY_PATH');
                    $filename = $path . $casestudy['image'];
                    if (file_exists($filename)) {
                        @unlink($filename);
                    }

                    //delete thumbnails
                    $path = $this->config->item('CASESTUDY_THUMBNAIL_PATH');
                    $filename = $path . $casestudy['image'];
                    if (file_exists($filename)) {
                        @unlink($filename);
                    }
                }
            }
        }


        $this->db->where('casestudy_id', $casestudy['casestudy_id']);
        $this->db->update('casestudy', $data);
        return;
    }

    //Function Delete Record
    function deleteRecord($casestudy) {
        $this->db->where('casestudy_id', $casestudy['casestudy_id']);
        $this->db->delete('casestudy');
    }

    //function slug
    function _slug($cname) {
        $casestudy_title = ($cname) ? $cname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $casestudy_title;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('url_alias', $slug);
        $rs = $this->db->get('casestudy');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('url_alias', $alt_slug);
                $rs = $this->db->get('casestudy');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }

}

?>