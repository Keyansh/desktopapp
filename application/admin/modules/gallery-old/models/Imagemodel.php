<?php

class Imagemodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //Get Image Detial
    function getDetail($im_id) {
        $this->db->where('image_id', intval($im_id));
        $rs = $this->db->get('image');
        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    //count all Project
    function countAll() {
        $this->db->from('image');
        return $this->db->count_all_results();
    }

    //list all Project
    function listAll($pid = NULL) {
//        echo $pid;
        //exit;
        $this->db->select('*')
                ->from('image')
                ->where('category_id', $pid);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    //Upload  images
    function insertRecord($pid = NULL) {
        $data = array();
        $data['title'] = $this->input->post('title', TRUE);
        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('PROJECT_IMAGE_PATH');
        $thumb_path = $this->config->item('PROJECT_IMAGE_PATH') . "thumb";
        $config['allowed_types'] = 'jpg|gif|png|jpeg';
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

                    $config1 = array(
                        'source_image' => $upload_data['full_path'], //get original image
                        'new_image' => $thumb_path, //save as new image //need to create thumbs first
//                                            'maintain_ratio' => true,
                        'width' => 250,
                        'height' => 250
                    );
                    $this->load->library('image_lib', $config1); //load library
                    $this->image_lib->resize(); //generating thumb
                }
            }
        }

        $order = $this->getOrder();
        $data['image_sort_order'] = $order;
        $cid = $this->input->post('pid');
        $data['category_id'] = $cid;
//        echo '<pre>';
//        print_r($data);
//        exit;
        $this->db->insert('image', $data);

        return $cid;
    }
    
     function updateRecord($pid1 = NULL) {
        $data = array();
        $data['title'] = $this->input->post('title', TRUE);
        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('PROJECT_IMAGE_PATH');
        $thumb_path = $this->config->item('PROJECT_IMAGE_PATH') . "thumb";
        $config['allowed_types'] = 'jpg|gif|png|jpeg';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);
       
        if ($_FILES['image']['name']!='') {
            //Check for valid image upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!$this->upload->do_upload('image')) {

                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    $data['image'] = $upload_data['file_name'];

                    $config1 = array(
                        'source_image' => $upload_data['full_path'], //get original image
                        'new_image' => $thumb_path, //save as new image //need to create thumbs first
//                                            'maintain_ratio' => true,
                        'width' => 250,
                        'height' => 250
                    );
                    $this->load->library('image_lib', $config1); //load library
                    $this->image_lib->resize(); //generating thumb
                }
            }
        }
        else{
            $data['image'] = $this->input->post('img_name', TRUE);
            
        }

        $order = $this->getOrder();
        $data['image_sort_order'] = $order;
        $cid = $this->input->post('pid');
        $data['category_id'] = $cid;
        
        $this->db->where('image_id',$pid1);
        $this->db->update('image', $data);
        
        return $cid;
    }

    //get sort order of image
    function getOrder() {
        $this->db->select_max('image_sort_order');
        $query = $this->db->get('image');
        $sort_order = $query->row_array();
        return $sort_order['image_sort_order'] + 1;
    }

    function getProjects() {
        $this->db->select('page_id,title')
                ->from('page')
                ->where('type', '1');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function deleteRecord($image) {

        $path = $this->config->item('IMAGE_PATH');
        $filename = $path . $image['image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }

        $path = $this->config->item('IMAGE_THUMBNAIL_PATH');
        $filename = $path . $image['image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }


        $this->db->where('image_id', $image['image_id']);
        $this->db->delete('image');
    }

}

?>
