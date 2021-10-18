<?php

class Uspmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Get homepageimage detail
    function detail($sid) {
        $this->db->where('usp_id', intval($sid));
        $rs = $this->db->get('usp');
        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    function listAll() {
        $query = $this->db->get('usp');
        return $query->result_array();
    }

    //get sort order
    function getOrder() {
        $this->db->select_max('sort_order');
        $query = $this->db->get('usp');
        $sort_order = $query->row_array();
        return $sort_order['sort_order'] + 1;
    }

    //Upload  usp images
    function uploadImages() {
        $data = array();
        $data['alt'] = $this->input->post('alt', TRUE);
        $data['content'] = $this->input->post('content', TRUE);
//        $data['usp_active'] = $this->input->post('usp_active', TRUE);
        $data['usp_uploaded'] = time();
        $data['sort_order'] = $this->getOrder();

        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('USP_IMAGE_PATH');
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

                    $data['usp_image'] = $upload_data['file_name'];
                }
            }
        }

//ee($data);
        $this->db->insert('usp', $data);
    }

    //function update slide images
    function updateRecord($usp) {
        $data = array();
        $data['alt'] = $this->input->post('alt', TRUE);
        $data['content'] = $this->input->post('content', TRUE);
        $data['usp_active'] = $this->input->post('usp_active', TRUE);

        //Upload Image
        $config = array();
        $config['upload_path'] = $this->config->item('USP_IMAGE_PATH');
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
                    $data['usp_image'] = $upload_data['file_name'];

                    //delete the  image
                    $path = $this->config->item('USP_IMAGE_PATH');
                    $filename = $path . $usp['usp_image'];
                    if (file_exists($filename) && $usp['usp_image'] != $data['usp_image']) {
                        @unlink($filename);
                    }
                }
            }
        }
        $this->db->where('usp_id', $usp['usp_id']);
        $this->db->update('usp', $data);
    }

    //function delete usp image
    function deleteRecord($usp) {
        $path = $this->config->item('USP_IMAGE_PATH');
        $filename = $path . $usp['usp_image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        $this->db->where('usp_id', $usp['usp_id']);
        $this->db->delete('usp');
    }

    //enable usp
    function enableRecord($usp) {
        $data = array();

        $data['usp_active'] = 1;

        $this->db->where('usp_id', $usp['usp_id']);
        $this->db->update('usp', $data);
        return;
    }

    //disable usp
    function disableRecord($usp) {
        $data = array();
        $data['usp_active'] = 0;
        $this->db->where('usp_id', $usp['usp_id']);
        $this->db->update('usp', $data);
        return;
    }

    //function uspTree
    function uspTree($output = '') {
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('usp');
        if ($query->num_rows() > 0) {
            $output .= '<ul id="usptree">' . "\r\n";
            foreach ($query->result_array() as $row) {
                $del_href = 'homepage/usp/delete/' . $row['usp_id'];
                $edit_href = 'homepage/usp/edit/' . $row['usp_id'];
                if ($row['usp_active'] == 1) {
                    $link_href = 'homepage/usp/disable/' . $row['usp_id'];
                    $link_name = '<i class="glyph-icon icon-eye green-color"></i>';
                } else {
                    $link_href = 'homepage/usp/enable/' . $row['usp_id'];
                    $link_name = '<i class="glyph-icon icon-eye-slash"></i>';
                }



                $output .= '<li id="menu_' . $row['usp_id'] . '"><div class="menu_item">' . '<img src="' . $this->config->item('USP_IMAGE_URL') . $row['usp_image'] . '" border="0" />' . "</div><div class=\"menu_item_options\"> <a href=\"" . $link_href . "\" onclick=\"return confirm('Are you sure you want to Enable/Disable this usp image?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Enable/Disable'>" . $link_name . "</a> <a href=\"" . $edit_href . "\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class='glyph-icon icon-linecons-pencil'></i></a> <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Homepage USP Image ?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class='glyph-icon icon-trash red-color'></i></a></div><div style=\"clear:both\"></div> ";
                $output .= "</li>\r\n";
            }
            $output .= "</ul>\r\n";
        }
        return $output;
    }

}

?>