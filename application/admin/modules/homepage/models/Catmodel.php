<?php

class Catmodel extends CI_Model {

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
        $rs = $this->db->get('homecategories');
        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    function listAll() {
        $query = $this->db->get('homecategories');
        return $query->result_array();
    }

    //get sort order
    function getOrder($pid = FALSE) {
        $this->db->select_max('sort_order');
        if ($pid) {
            $this->db->where('parent_id', $pid);
        }
        $query = $this->db->get('homecategories');
        $sort_order = $query->row_array();
        return $sort_order['sort_order'] + 1;
    }

    function insertRecord() {
        $data = array();
        $data['category'] = $this->input->post('category', TRUE);
        $data['alt'] = $this->input->post('alt', TRUE);
        $data['addedon'] = time();
        $data['parent_id'] = 0;
        $data['sort_order'] = $this->getOrder();

        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('HOMECATEGORY_IMAGE_PATH');
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
                }
            }
        }

//        ee($data);
        $this->db->insert('homecategories', $data);

        $parentId = $this->db->insert_id();
        if ($parentId) {
            $childcats = $this->input->post('childcat');
            $altChild = $this->input->post('altChild');
            $descChild = $this->input->post('descriptionChild');
            $imageChild = $_FILES['imageChild'];

            for ($k = 0; $k < count($imageChild); $k++) {
                $_FILES['userfile' . $k] = array('name' => $imageChild['name'][$k], 'tmp_name' => $imageChild['tmp_name'][$k], 'type' => $imageChild['type'][$k], 'error' => $imageChild['error'][$k], 'size' => $imageChild['size'][$k]);
            }

            $i = 0;
            $data1 = array();
            foreach ($childcats as $childcat) {
                $data1['category'] = $childcats[$i];
                $data1['alt'] = $altChild[$i];
                $data1['description'] = $descChild[$i];
                $data1['addedon'] = time();
                $data1['parent_id'] = $parentId;
                $data1['sort_order'] = $this->getOrder($parentId);

                if ($_FILES['userfile' . $i]['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile' . $i]['tmp_name'])) {
                    if (!$this->upload->do_upload('userfile' . $i)) {
                        echo($this->upload->display_errors('<p class="err">', '</p>'));
                        return FALSE;
                    } else {
                        $upload_data = $this->upload->data();
                        $data1['image'] = $upload_data['file_name'];
                    }
                }

                $this->db->insert('homecategories', $data1);
                $i++;
            }
        }
    }

    //function update slide images
    function updateRecord($category) {
        $data = array();
        $data['alt'] = $this->input->post('alt', TRUE);
        $data['description'] = $this->input->post('description', TRUE);

        //Upload Image
        $config = array();
        $config['upload_path'] = $this->config->item('HOMECATEGORY_IMAGE_PATH');
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
                }
            }
        }
        $this->db->where('id', $category['id']);
        $this->db->update('homecategories', $data);
    }

    //function delete image
    function deleteRecord($category) {
        $path = $this->config->item('HOMECATEGORY_IMAGE_PATH');
        $filename = $path . $topcat['image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }

        if ($category['parent_id'] == 0) {
            $this->db->where('parent_id', $category['id']);
            $this->db->delete('homecategories');
        }
        $this->db->where('id', $category['id']);
        $this->db->delete('homecategories');
    }

    function enableRecord($topcat) {
        $data = array();

        $data['is_active'] = 1;

        $this->db->where('id', $topcat['id']);
        $this->db->update('homecategories', $data);
        return;
    }

    function disableRecord($topcat) {
        $data = array();
        $data['is_active'] = 0;
        $this->db->where('id', $topcat['id']);
        $this->db->update('homecategories', $data);
        return;
    }

    function homecatTree1($output = '') {
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('homecategories');
        if ($query->num_rows() > 0) {
            $output .= '<ul id="topcattree">' . "\r\n";
            foreach ($query->result_array() as $row) {
                $del_href = 'homepage/category/delete/' . $row['id'];
                $edit_href = 'homepage/category/edit/' . $row['id'];
                if ($row['is_active'] == 1) {
                    $link_href = 'homepage/category/disable/' . $row['id'];
                    $link_name = '<i class="glyph-icon icon-eye green-color"></i>';
                } else {
                    $link_href = 'homepage/category/enable/' . $row['id'];
                    $link_name = '<i class="glyph-icon icon-eye-slash"></i>';
                }



                $output .= '<li id="menu_' . $row['id'] . '"><div class="menu_item">' . '<img src="' . $this->config->item('HOMECATEGORY_IMAGE_URL') . $row['image'] . '" border="0" width=200px/>' . "</div><div class=\"menu_item_options\"> <a href=\"" . $link_href . "\" onclick=\"return confirm('Are you sure you want to Enable/Disable this Top category?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Enable/Disable'>" . $link_name . "</a> <a href=\"" . $edit_href . "\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class='glyph-icon icon-linecons-pencil'></i></a> <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Homepage Category ?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class='glyph-icon icon-trash red-color'></i></a></div><div style=\"clear:both\"></div> ";
                $output .= "</li>\r\n";
            }
            $output .= "</ul>\r\n";
        }
        return $output;
    }

    function homecatTree($parent, $output = '') {
        $this->db->where('parent_id', $parent);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('homecategories');
        if ($query->num_rows() > 0) {
            if ($parent == 0) {
                $output .= '<ul id="homecattree">' . "\r\n";
            } else {
                $output .= "<ul id='childcats' class='col-lg-5'>\r\n";
            }
            foreach ($query->result_array() as $row) {
                $addChild_href = 'homepage/category/addChild/' . $row['id'];
                $del_href = 'homepage/category/delete/' . $row['id'];
                $edit_href = $row['id'];
                if ($row['is_active'] == 1) {
                    $link_href = 'homepage/category/disable/' . $row['id'];
                    $link_name = '<i class="glyph-icon icon-eye green-color"></i>';
                } else {
                    $link_href = 'homepage/category/enable/' . $row['id'];
                    $link_name = '<i class="glyph-icon icon-eye-slash"></i>';
                }

                if ($parent == 0) {
                    $output .= '<li id="menu_' . $row['id'] . '" class="clearfix"><div class="col-lg-6" style="padding:0;"><div class="menu_item">' . '<img src="' . $this->config->item('HOMECATEGORY_IMAGE_URL') . $row['image'] . '" border="0" class="img-responsive"/>' . "</div><div class=\"menu_item_options\"> <a href=\"" . $link_href . "\" onclick=\"return confirm('Are you sure you want to Enable/Disable this Top category?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Enable/Disable'>" . $link_name . "</a> <a cid=\"" . $edit_href . "\" class='editCat tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class='glyph-icon icon-linecons-pencil'></i></a> <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Homepage Category ?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class='glyph-icon icon-trash red-color'></i></a></div><div style=\"clear:both\"></div></div><div class='addChildDiv'><a href='" . $addChild_href . "' class='btn btn-primary'>Add Child</a></div> ";
                } else {
                    $output .= '<li id="menu_' . $row['id'] . '"><div class="menu_item">' . '<img src="' . $this->config->item('HOMECATEGORY_IMAGE_URL') . $row['image'] . '" border="0" width=147px/>' . "</div><div class=\"menu_item_options\"> <a href=\"" . $link_href . "\" onclick=\"return confirm('Are you sure you want to Enable/Disable this Home Category?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Enable/Disable'>" . $link_name . "</a> <a cid=\"" . $edit_href . "\" class='editCat tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class='glyph-icon icon-linecons-pencil'></i></a> <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Homepage Category ?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class='glyph-icon icon-trash red-color'></i></a></div><div style=\"clear:both\"></div> ";
                }
                $output = $this->homecatTree($row['id'], $output);
                $output .= "</li>\r\n";
            }
            $output .= "</ul>\r\n";
        }
        return $output;
    }

    function allChild($catid) {
        $this->db->select('id,name,uri');
        $this->db->where('active', 1);
        $this->db->where('parent_id', $catid);
        $query = $this->db->get('category');
        return $query->result_array();
    }

    function detailAjax($sid) {
        $this->db->select('homecategories.*,cat.uri,cat.name');
        $this->db->from('homecategories');
        $this->db->join('category cat', 'cat.id = homecategories.category');
        $this->db->where('homecategories.id', intval($sid));
        $rs = $this->db->get();

        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    function insertRecordAjax() {
        $data = array();
        $catid = $this->input->post('catid', TRUE);
        $data['alt'] = $this->input->post('alt', TRUE);
        $data['description'] = $this->input->post('description', TRUE);

        //Upload Image
        $config = array();
        $config['upload_path'] = $this->config->item('HOMECATEGORY_IMAGE_PATH');
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
                }
            }
        }
        $this->db->where('id', $catid);
        $this->db->update('homecategories', $data);
    }

    function insertChildRecord($pid) {
        $data = array();
        $data['category'] = $this->input->post('category', TRUE);
        $data['alt'] = $this->input->post('alt', TRUE);
        $data['description'] = $this->input->post('description', TRUE);
        $data['addedon'] = time();
        $data['parent_id'] = $pid;
        $data['sort_order'] = $this->getOrder($pid);

        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('HOMECATEGORY_IMAGE_PATH');
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
                }
            }
        }

//        ee($data);
        $this->db->insert('homecategories', $data);
    }

}

?>