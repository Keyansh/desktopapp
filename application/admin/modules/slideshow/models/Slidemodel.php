<?php

class Slidemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Get homepageimage detail
    function detail($sid) {
        $this->db->where('slideshow_image_id', intval($sid));
        $rs = $this->db->get('slideshow_image');
        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    function listAll() {
        $query = $this->db->get('slideshow');
        return $query->result_array();
    }
    
    //get sort order
    function getOrder($slideshow) {
        $this->db->select_max('sort_order');
        $this->db->where('slideshow_id', $slideshow['slideshow_id']);
        $query = $this->db->get('slideshow_image');
        $sort_order = $query->row_array();
        return $sort_order['sort_order'] + 1;
    }

    //Upload  slideshow images
    function uploadImages($slideshow) {
        $data = array();
        $data['slideshow_id'] = $slideshow['slideshow_id'];
        $data['alt'] = $this->input->post('alt', TRUE);
        $data['link'] = $this->input->post('link', TRUE);
        $data['videolink'] = $this->input->post('videolink', TRUE);
        $data['active'] = $this->input->post('image_active', TRUE);
        $data['new_window'] = $this->input->post('new_window', TRUE);
        $data['slide_uploaded'] = time();
        $data['sort_order'] = $this->getOrder($slideshow);
        
        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('SLIDESHOW_IMAGE_PATH');
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);

        $img_counter = 0;
        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!$this->upload->do_upload('image')) {
                    echo($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();

                    $data['slideshow_image'] = $upload_data['file_name'];
                }
            }
        }


        $this->db->insert('slideshow_image', $data);
    }

    //function update slide images
    function updateRecord($slideshowimage) {
        $data = array();
        $data['alt'] = $this->input->post('alt', TRUE);
        $data['link'] = $this->input->post('link', TRUE);
        $data['videolink'] = $this->input->post('videolink', TRUE);
        // $data['active'] = $this->input->post('image_active', TRUE);
        $data['new_window'] = $this->input->post('new_window', TRUE);

        //Upload Image
        $config = array();
        $config['upload_path'] = $this->config->item('SLIDESHOW_IMAGE_PATH');
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);

        if (count($_FILES) > 0) {
            //Check For Vaild Image Upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!$this->upload->do_upload('image')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    //$data = array();
                    $upload_data = $this->upload->data();
                    $data['slideshow_image'] = $upload_data['file_name'];

                    //delete the  image
                    $path = $this->config->item('SLIDESHOW_IMAGE_PATH');
                    $filename = $path . $slideshowimage['slideshow_image'];
                    if (file_exists($filename) && $slideshowimage['slideshow_image'] != $data['slideshow_image']) {
                        @unlink($filename);
                    }
                }
            }
        }
        $this->db->where('slideshow_image_id', $slideshowimage['slideshow_image_id']);
        $this->db->update('slideshow_image', $data);
    }

    //function delete slide image
    function deleteRecord($slideshowimage) {
        //delete the  image
        $path = $this->config->item('SLIDESHOW_IMAGE_PATH');
        $filename = $path . $slideshowimage['slideshow_image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        $this->db->where('slideshow_image_id', $slideshowimage['slideshow_image_id']);
        $this->db->delete('slideshow_image');
    }
    
    //enable slideshow
    function enableRecord($slideshowimage) {
        $data = array();

        $data['active'] = 1;

        $this->db->where('slideshow_image_id', $slideshowimage['slideshow_image_id']);
        $this->db->update('slideshow_image', $data);
        return;
    }

    //disable slideshow
    function disableRecord($slideshowimage) {
        $data = array();
        $data['active'] = 0;
        $this->db->where('slideshow_image_id', $slideshowimage['slideshow_image_id']);
        $this->db->update('slideshow_image', $data);
        return;
    }
    
    //function slidetree
    function slideTree($parent, $sid, $output = '') {
        $this->db->order_by('sort_order', 'ASC');
        $this->db->where('slideshow_id', intval($sid));
        $query = $this->db->get('slideshow_image');
        if ($query->num_rows() > 0) {
            if ($parent == 0) {
                $output .= '<ul id="menutree">' . "\r\n";
            } else {
                $output .= "<ul>\r\n";
            }
            foreach ($query->result_array() as $row) {
                $del_href = 'slideshow/slide/delete/' . $row['slideshow_image_id'];
                $edit_href = 'slideshow/slide/edit/' . $row['slideshow_image_id'];
                if($row['active'] == 1) {
                    $link_href = 'slideshow/slide/disable/' . $row['slideshow_image_id'];
                    $link_name = '<i class="glyph-icon icon-eye green-color"></i>';
                }else{
                  $link_href = 'slideshow/slide/enable/' . $row['slideshow_image_id'];
                  $link_name = '<i class="glyph-icon icon-eye-slash"></i>';
                }
                
                

                $output .= '<li id="menu_' . $row['slideshow_image_id'] . '"><div class="menu_item">' . '<img src="' . $this->config->item('SLIDESHOW_IMAGE_URL') . $row['slideshow_image'] . '" border="0" width="200px" />' . "</div><div class=\"menu_item_options\"><a href=\"" . $link_href . "\" onclick=\"return confirm('Are you sure you want to Enable/Disable this slide image?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Enable/Disable'>".$link_name."</a> | <a href=\"" . $edit_href . "\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class='glyph-icon icon-linecons-pencil'></i></a> | <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Homepage Slide Image ?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class='glyph-icon icon-trash red-color'></i></a></div><div style=\"clear:both\"></div> ";
                $output .= "</li>\r\n";
            }
            $output .= "</ul>\r\n";
        }
        return $output;
    }

}

?>