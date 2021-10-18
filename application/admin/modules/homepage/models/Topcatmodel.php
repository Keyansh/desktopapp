<?php

class Topcatmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function listAllCat() {
        $this->db->select('id,name,uri');
        $this->db->where('active', 1);
        $query = $this->db->get('category');
        return $query->result_array();
    }

    function detail($sid) {
        $this->db->where('id', intval($sid));
        $rs = $this->db->get('topcat');
        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    function listAll() {
        $query = $this->db->get('topcat');
        return $query->result_array();
    }

    //get sort order
    function getOrder() {
        $this->db->select_max('sort_order');
        $query = $this->db->get('topcat');
        $sort_order = $query->row_array();
        return $sort_order['sort_order'] + 1;
    }

    function insertRecord() {
        $data = array();
        $data['category'] = $this->input->post('category', TRUE);
        $data['alt'] = $this->input->post('alt', TRUE);
        $data['price'] = $this->input->post('price', TRUE);
        $data['addedon'] = time();
        $data['sort_order'] = $this->getOrder();

        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('CATEGORY_IMAGE_PATH');
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
                    $data['image'] = $upload_data['file_name'];

                    //resizing Medium image
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $this->config->item('CATEGORY_IMAGE_PATH') . $data['image'];
                    $config['new_image'] = $this->config->item('CATEGORY_THUMBNAIL_PATH') . $data['image'];
                    $config['create_thumb'] = FALSE;
                    $config['encrypt_name'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 432;
                    $config['height'] = 433;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                }
            }
        }

//        ee($data);
        $this->db->insert('topcat', $data);
    }

    //function update slide images
    function updateRecord($topcat) {
        $data = array();
        $data['category'] = $this->input->post('category', TRUE);
        $data['alt'] = $this->input->post('alt', TRUE);
        $data['price'] = $this->input->post('price', TRUE);

        //Upload Image
        $config = array();
        $config['upload_path'] = $this->config->item('CATEGORY_IMAGE_PATH');
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
                    $data['image'] = $upload_data['file_name'];

                    //resizing Medium image
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $this->config->item('CATEGORY_IMAGE_PATH') . $data['image'];
                    $config['new_image'] = $this->config->item('CATEGORY_THUMBNAIL_PATH') . $data['image'];
                    $config['create_thumb'] = FALSE;
                    $config['encrypt_name'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 432;
                    $config['height'] = 433;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    //delete the  image
                    $path = $this->config->item('CATEGORY_IMAGE_PATH');
                    $filename = $path . $topcat['image'];
                    if (file_exists($filename) && $topcat['image'] != $data['image']) {
                        @unlink($filename);
                    }
                }
            }
        }
        $this->db->where('id', $topcat['id']);
        $this->db->update('topcat', $data);
    }

    //function delete topcat image
    function deleteRecord($topcat) {
        $path = $this->config->item('CATEGORY_IMAGE_PATH');
        $filename = $path . $topcat['image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        $path = $this->config->item('CATEGORY_THUMBNAIL_PATH');
        $filename = $path . $topcat['image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        $this->db->where('id', $topcat['id']);
        $this->db->delete('topcat');
    }

    //enable topcat
    function enableRecord($topcat) {
        $data = array();

        $data['active'] = 1;

        $this->db->where('id', $topcat['id']);
        $this->db->update('topcat', $data);
        return;
    }

    //disable topcat
    function disableRecord($topcat) {
        $data = array();
        $data['active'] = 0;
        $this->db->where('id', $topcat['id']);
        $this->db->update('topcat', $data);
        return;
    }

    //function topcatTree
    function topcatTree($output = '') {
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('topcat');
        if ($query->num_rows() > 0) {
            $output .= '<ul id="topcattree">' . "\r\n";
            foreach ($query->result_array() as $row) {
                $del_href = 'homepage/topcat/delete/' . $row['id'];
                $edit_href = 'homepage/topcat/edit/' . $row['id'];
                if ($row['active'] == 1) {
                    $link_href = 'homepage/topcat/disable/' . $row['id'];
                    $link_name = '<i class="glyph-icon icon-eye green-color"></i>';
                } else {
                    $link_href = 'homepage/topcat/enable/' . $row['id'];
                    $link_name = '<i class="glyph-icon icon-eye-slash"></i>';
                }



                $output .= '<li id="menu_' . $row['id'] . '"><div class="menu_item">' . '<img src="' . $this->config->item('CATEGORY_IMAGE_URL') . $row['image'] . '" border="0" width=200px/>' . "</div><div class=\"menu_item_options\"> <a href=\"" . $link_href . "\" onclick=\"return confirm('Are you sure you want to Enable/Disable this Top category?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Enable/Disable'>" . $link_name . "</a> <a href=\"" . $edit_href . "\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class='glyph-icon icon-linecons-pencil'></i></a> <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Homepage Category ?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class='glyph-icon icon-trash red-color'></i></a></div><div style=\"clear:both\"></div> ";
                $output .= "</li>\r\n";
            }
            $output .= "</ul>\r\n";
        }
        return $output;
    }

}

?>