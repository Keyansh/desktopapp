<?php

class Downloadmodel extends CI_Model
{

    public function __construct()
    {

        parent::__construct();
    }

    //Get detail of News
    public function getdetails($nid)
    {
        $this->db->where('id', intval($nid));
        $query = $this->db->get('download');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }

        return false;
    }

    //Count All News
    public function countAll()
    {
        $this->db->from('download');

        return $this->db->count_all_results();
    }

    //list all News
    public function listAll($offset = false, $limit = false)
    {
        if ($offset) {
            $this->db->offset($offset);
        }

        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->order_by('id', 'DESC');
        $rs = $this->db->get('download');

        return $rs->result_array();
    }

    //insert record
    public function insertRecord()
    {
        $data = array();


        //upload image

        $config['upload_path'] = $this->config->item('DOWNLOAD_IMAGE_PATH');
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
                    $data['icon'] = $upload_data['file_name'];
                }
            }
        }


        $config1['upload_path'] = $this->config->item('DOWNLOAD_PDF_PATH');
        $config1['overwrite'] = FALSE;
        $config1['allowed_types'] = 'pdf';
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['pdf_file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['pdf_file']['tmp_name'])) {
                if (!$this->upload->do_upload('pdf_file')) {
                    show_error($this->upload->display_errors('<p class="err1">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    $data['pdf'] = $upload_data['file_name'];
                }
            }
        }


        $data['title'] = $this->input->post('title', false);
        $data['type'] = $this->input->post('type', false);
        $data['added_on'] = time();
        $this->db->insert('download', $data);
        return;
    }

    //update record
    public function updateRecord($download)
    {
        $data = array();


        $config['upload_path'] = $this->config->item('DOWNLOAD_IMAGE_PATH');
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
                    $data['icon'] = $upload_data['file_name'];
                }
            }
        }


        $config1['upload_path'] = $this->config->item('DOWNLOAD_PDF_PATH');
        $config1['overwrite'] = FALSE;
        $config1['allowed_types'] = 'pdf';
        $this->load->library('upload', $config1);
        $this->upload->initialize($config1);
        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['pdf_file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['pdf_file']['tmp_name'])) {
                if (!$this->upload->do_upload('pdf_file')) {
                    show_error($this->upload->display_errors('<p class="err1">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    $data['pdf'] = $upload_data['file_name'];

                    $path = $this->config->item('DOWNLOAD_PDF_PATH');
                    $filename = $path . $post['pdf_file'];
                    if (file_exists($filename)) {
                        @unlink($filename);
                    }
                }
            }
        }


        $data['title'] = $this->input->post('title', false);
        $data['type'] = $this->input->post('type', false);
        $data['added_on'] = time();
        $this->db->where('id', $download['id']);
        $this->db->update('download', $data);

        return;
    }

    //Function Delete Record
    public function deleteRecord($download)
    {
        $this->db->where('id', $download['id']);
        $this->db->delete('download');

        $path = $this->config->item('DOWNLOAD_IMAGE_PATH');
        $filename = $path . $download['icon'];
        if (file_exists($filename)) {
            @unlink($filename);
        }

        $path1 = $this->config->item('DOWNLOAD_PDF_PATH');
        $filename1 = $path1 . $download['pdf'];
        if (file_exists($filename1)) {
            @unlink($filename1);
        }
    }

    //Function Delete Record
    public function deleteImage($blog)
    {
        $data = array();
        $data['image'] = '';

        $this->db->where('blog_id', $blog['blog_id']);
        $this->db->update('blog', $data);

        return;
    }
}
