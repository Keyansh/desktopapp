<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Images extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function updateSortOrder() {
        $sort_data = $this->input->post('menu', true);
        //print_r($sort_data); 
        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['image_sort_order'] = $key + 1;
            $this->db->where('product_image_id', $val);
            $this->db->update('product_image', $update);
        }
        //echo "Done";
        print_r($_POST);
    }

    function remove(){
        $img_id = $this->input->post('img_id',true);
        $return['status'] = false;
        $return['image'] = null;
        if($img_id) {
            $image = $this->db->where('id',$img_id)->get('prod_img')->row_array();
            $path = $this->config->item('PRODUCT_PATH').$image['img'];
            if(file_exists($path)){
                @unlink($path);
            }
            $status = $this->db->where('id',$img_id)->delete('prod_img');
            if($status){
                $return['image'] = $img_id;
                $return['status'] = true;
            }
        }
        echo json_encode($return);
    }
    
    function removeVideo(){
        $video_id = $this->input->post('video_id',true);
        $return['status'] = false;
        $return['video'] = null;
        if($video_id) {
            $image = $this->db->where('id',$video_id)->get('prod_videos')->row_array();
            $path = $this->config->item('PRODUCT_PATH').'videos/'.$image['video'];
            if(file_exists($path)){
                @unlink($path);
            }
            $status = $this->db->where('id',$video_id)->delete('prod_videos');
            if($status){
                $return['video'] = $video_id;
                $return['status'] = true;
            }
        }
        echo json_encode($return);
    }

}

?>