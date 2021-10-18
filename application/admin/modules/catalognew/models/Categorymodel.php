<?php

class Categorymodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //get all category
    function getAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->where('active', 1);
        $query = $this->db->get('category');
        return $query->result_array();
    }

    //get detail of category
    function getdetails($cid) {
        $this->db->where('id', $cid);
        $query = $this->db->get('category');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //get all detail of category
    function getAllDetails($cid) {
        $this->db->select('id, name');
        $this->db->where('id', $cid);
        $this->db->where('active', 1);
        $query = $this->db->get('category');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    //Count All category
    function countAll() {
        $this->db->from('category');
        $this->db->where('active', 1);
        return $this->db->count_all_results();
    }

    //list all category
    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->where('active', 1);

        $rs = $this->db->get('category');
        return $rs->result_array();
    }

    // Category Arribute ID
    function catattrsetid($id) {
        $result = array();
        $this->db->select('attrset_id');
        $this->db->where('active', 1);
        $this->db->where('id', $id);
        $query = $this->db->get('category');
        foreach ($query->result_array() as $row) {
            $result = $row;
        }
        return $result;
    }

    //create indented Active List
    function indentedActiveList($parent, &$output = array()) {
        $this->db->where('active', 1);
        $this->db->where('depth', 0);
        $this->db->where('parent_id', $parent);
        $query = $this->db->get('category');
        foreach ($query->result_array() as $row) {
            $output[] = $row;
            $this->indentedActiveList($row['category_id'], $output);
        }
        return $output;
    }

    //Root list
    function rootList() {
        $output = array();
        $this->db->where('active', 1);
        $this->db->where('depth', 0);
        $query = $this->db->get('category');
        foreach ($query->result_array() as $row) {
            $output[] = $row;
        }
        return $output;
    }

    //Category list
    function cateList() {
        $output = array();
        $this->db->select('id, name, parent_id');
        $this->db->where('active', 1);
        $query = $this->db->get('category');
        foreach ($query->result_array() as $row) {
            $output[] = $row;
        }
        return $output;
    }

    function getMainCategory($pid) {
        $category = $this->db
        ->select('t1.*')
        ->from('category t1')
        ->join('cat_prod t2','t1.id=t2.cid AND t2.pid='.$pid)
        ->get()->row_array()
        ;
        return $category;
    }

    //create indented list
    function indentedListSmall($parent, &$output = array()) {
        //$this->db->order_by('c_sort_order','ASC');
        $this->db->select('id,parent_id,name,uri');
        $this->db->where('parent_id', $parent);
        $query = $this->db->get('category');
        foreach ($query->result_array() as $row) {
            $output[] = $row;
            $this->indentedListSmall($row['id'], $output);
        }
        return $output;
    }

    //create indented list
    function indentedList($parent, &$output = array()) {
        //$this->db->order_by('c_sort_order','ASC');
        $this->db->where('parent_id', $parent);
        $query = $this->db->get('category');
        foreach ($query->result_array() as $row) {
            $output[] = $row;
            $this->indentedList($row['id'], $output);
        }
        return $output;
    }

    //list all category
    function getCategory($current_category) {
        $this->db->where('active', 1);
        //$this->db->where('depth', 0);
        $this->db->where('id !=', $current_category['id']);
        $this->db->where('parent_id !=', $current_category['id']);
        //$this->db->where('parent_id', $current_category['parent_id']);
        $query = $this->db->get('category');
        return $query->result_array();
    }

    //insert record
    function insertRecord() {
        $parent = false;

        if ($this->input->post('parent_id', true) > 0) {
            $parent = $this->getdetails($this->input->post('parent_id', true));
        }

        $data = array();
        $data['parent_id'] = $this->input->post('parent_id', true);
        $data['name'] = $this->input->post('name', true);

        if ($this->input->post('uri', TRUE) == '') {
            $data['uri'] = $this->_slug($this->input->post('name', TRUE));
        } else {
            $data['uri'] = url_title($this->input->post('uri', TRUE), '-', TRUE);
        }

        $data['short_description'] = $this->input->post('short_description', true);
        $data['description'] = $this->input->post('description', true);
        $data['bottom_description'] = $this->input->post('bottom_description', true);
        $data['meta_title'] = $this->input->post('meta_title', true);
        $data['meta_keywords'] = $this->input->post('meta_keywords', true);
        $data['meta_description'] = $this->input->post('meta_description', true);
        $data['featured'] = $this->input->post('featured', true);
        $data['image_alt'] = $this->input->post('image_alt', true);
        $data['banner_alt'] = $this->input->post('banner_alt', true);
        $data['new_start_date'] = $this->input->post('new_start_date');
        $data['new_end_date'] = $this->input->post('new_end_date');
        $data['is_new'] = $this->input->post('is_new', true);

        $data['active'] = '1';
        if (!$parent) {
            $data['depth'] = 0;
        } else {
            $data['depth'] = $parent['depth'] + 1;
            $data['uri'] = $parent['uri'] . "/" . $data['uri'];
        }

        $this->load->library('upload');

        if ($_FILES['icon']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['icon']['tmp_name'])) {
            $config = array();
            $config['upload_path'] = $this->config->item('CATEGORY_ICON_PATH');
            $config['allowed_types'] = 'jpg|jpeg|gif|png';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('icon')) {
                echo($this->upload->display_errors('<p class="err">', '</p>'));
                return FALSE;
            } else {
                $upload_data = $this->upload->data();
                $data['icon'] = $upload_data['file_name'];
            }
        }

        if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $config = array();
            $config['upload_path'] = $this->config->item('CATEGORY_IMAGE_PATH');
            $config['allowed_types'] = 'jpg|jpeg|gif|png';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('image')) {
                echo($this->upload->display_errors('<p class="err">', '</p>'));
                return FALSE;
            } else {
                $upload_data = $this->upload->data();
                $data['image'] = $upload_data['file_name'];
            }
        }

        if ($_FILES['banner']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['banner']['tmp_name'])) {
            $config = array();
            $config['upload_path'] = $this->config->item('CATEGORY_BANNER_PATH');
            $config['allowed_types'] = 'jpg|jpeg|gif|png';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('banner')) {
                echo($this->upload->display_errors('<p class="err">', '</p>'));
                return FALSE;
            } else {
                $upload_data = $this->upload->data();
                $data['category_banner'] = $upload_data['file_name'];
            }
        }
        $data['show_in_homepage'] = $this->input->post('show_in_homepage', true);
        $data['show_in_menu'] = $this->input->post('show_in_menu', true);
        $data['show_as_child'] = $this->input->post('show_as_child', true);
        $data['banner_title'] = $this->input->post('banner_title', true);
        $data['banner_content'] = $this->input->post('banner_content', true);
        $order = $this->getOrder($parent);
        $data['sort_order'] = $order;

        $this->db->insert('category', $data);
    }

    //get sort order of category
    function getOrder($pid) {
        $this->db->select_max('sort_order');
        $this->db->where('parent_id', intval($pid));
        $query = $this->db->get('category');
        $sort_order = $query->row_array();
        return $sort_order['sort_order'] + 1;
    }

    //update record
    function updateRecord($category) {
        $data = array();
        $data['parent_id'] = $this->input->post('parent_id', true);
        $data['name'] = $this->input->post('name');

        if ($this->input->post('uri', TRUE) == '') {
            $rs = $this->db->select('uri')
                ->where('id', $data['parent_id'])
                ->get('category');
            if ($rs->num_rows() == 1) {
                $r = $rs->first_row('array');
                $data['uri'] = $r['uri'] . "/" . $this->_slug($data['name']);
            }
        } else {
            $data['uri'] = $this->input->post('uri', TRUE);
        }

        $data['short_description'] = $this->input->post('short_description', true);
        $data['description'] = $this->input->post('description', true);
        $data['bottom_description'] = $this->input->post('bottom_description', true);
        $data['meta_title'] = $this->input->post('meta_title', true);
        $data['meta_keywords'] = $this->input->post('meta_keywords', true);
        $data['meta_description'] = $this->input->post('meta_description', true);
        $data['featured'] = $this->input->post('featured', true);
        $data['image_alt'] = $this->input->post('image_alt', true);
        $data['banner_alt'] = $this->input->post('banner_alt', true);
        $data['is_new'] = $this->input->post('is_new', true);

        if ($data['is_new'] == 1) {
            $data['new_start_date'] = $this->input->post('new_start_date');
            $data['new_end_date'] = $this->input->post('new_end_date');
        } else {
            $data['new_start_date'] = '';
            $data['new_end_date'] = '';
        }

        if ($this->input->post('parent_id', true) == 0) {
            $data['depth'] = 0;
        } else {
            $parent_category = $this->getdetails($this->input->post('parent_id', true));
            $data['depth'] = $parent_category['depth'] + 1;
        }

        $this->load->library('upload');

        if ($_FILES['icon']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['icon']['tmp_name'])) {
            $config = array();
            $config['upload_path'] = $this->config->item('CATEGORY_ICON_PATH');
            $config['allowed_types'] = 'jpg|jpeg|gif|png';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('icon')) {
                echo($this->upload->display_errors('<p class="err">', '</p>'));
                return FALSE;
            } else {
                $upload_data = $this->upload->data();
                $data['icon'] = $upload_data['file_name'];
            }
        }

        if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $config = array();
            $config['upload_path'] = $this->config->item('CATEGORY_IMAGE_PATH');
            $config['allowed_types'] = 'jpg|jpeg|gif|png';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('image')) {
                echo($this->upload->display_errors('<p class="err">', '</p>'));
                return FALSE;
            } else {
                $upload_data = $this->upload->data();
                $data['image'] = $upload_data['file_name'];
            }
        }

        if ($_FILES['banner']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['banner']['tmp_name'])) {
            $config = array();
            $config['upload_path'] = $this->config->item('CATEGORY_BANNER_PATH');
            $config['allowed_types'] = 'jpg|jpeg|gif|png';
            $config['overwrite'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('banner')) {
                echo($this->upload->display_errors('<p class="err">', '</p>'));
                return FALSE;
            } else {
                $upload_data = $this->upload->data();
                $data['category_banner'] = $upload_data['file_name'];
            }
        }

        $data['show_in_menu'] = $this->input->post('show_in_menu', true);    
        $data['show_in_homepage'] = $this->input->post('show_in_homepage', true);
        $data['show_as_child'] = $this->input->post('show_as_child', true);
        $data['banner_title'] = $this->input->post('banner_title', true);
        $data['banner_content'] = $this->input->post('banner_content', true);
        $this->db->where('id', $category['id']);
        $this->db->update('category', $data);
    }

    //enable record
    function enableRecord($category) {
        $data = array();
        $data['active'] = 1;
        $this->db->where('id', $category['id']);
        $this->db->update('category', $data);
    }

    //disable record
    function disableRecord($category) {
        $data = array();

        $data['active'] = 0;
        $this->db->where('id', $category['id']);
        $this->db->update('category', $data);
    }

    //Function Delete Record
    function deleteRecord($current_category) {
        $data = array();
        $category_id = $this->input->post('category_id', TRUE);

        $category_data = array();
        $category_data['parent_id'] = $category_id;
        $this->db->where('parent_id', $current_category['category_id']);
        $this->db->update('category', $category_data);

        $this->db->where('category_id', $current_category['category_id']);
        $query = $this->db->get('product');
        $products = $query->result_array();

        foreach ($products as $row) {
            $data['category_id'] = $this->input->post('category_id', TRUE);
            $this->db->where('category_id', $row['category_id']);
            $this->db->update('product', $data);
        }

        $this->db->where('category_id', $current_category['category_id']);
        $this->db->delete('category');
    }

    //Function Delete Record
    function deleteCategory($current_category) {
        //delete product table
//		$this->db->where('category_id', $current_category['id']);
//		$this->db->delete('product');
        //delete category table
        $this->db->where('id', $current_category['id']);
        $this->db->delete('category');
    }

    function categoriesTree($parent, $output = '') {
        $this->db->where('parent_id', $parent);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('category');
        if ($query->num_rows() > 0) {
            if (!$array_format) {
                if ($parent == 0) {
                    $output .= '<ul id="pagetree">' . "\r\n";
                } else {
                    $output .= "<ul>\r\n";
                }
            }
            foreach ($query->result_array() as $row) {
                if ($row['active'] == 1) {
                    $link_type = "<i class='glyph-icon icon-linecons-eye green-color'></i>";
                    $link = 'catalog/category/disable/' . $row['id'];
                } else {
                    $link_type = "<i class='glyph-icon icon-eye-slash red-color'></i>";
                    $link = 'catalog/category/enable/' . $row['id'];
                }

                $edit_href = 'catalog/category/edit/' . $row['id'];

                //link delete
                $del_href = 'catalog/category/delete/' . $row['id'];

                //link attribute to category
                $attribute_href = 'catalog/assignattr/index/' . $row['id'];
//                <a href=\"" . $attribute_href . "\">Assign Attribute</a> |

                $output .= '<li id="page_' . $row['id'] . '"><div class="page_item"><div class="page_item_name "><a href="' . $edit_href . '">' . $row['name'] . "</a></div><div class=\"menu_item_options\"> <a href='catalognew/product/catproducts/".$row['id']."' title='Manage Products'>Manage Products</a> |<a href=\"" . $link . "\" onclick=\"return confirm('Are you sure you want to " . $link_type . " this Category ?');\" title='Enable/Disable'>" . $link_type . "</a> | <a href=\"" . $edit_href . "\" title=''Edit><i class='glyph-icon icon-linecons-pencil'></i></a> | <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Link ?');\" title='Delete'><i class='glyph-icon icon-linecons-trash red-color'></i></a></div><div style=\"clear:both\"></div></div>";
                $output = $this->categoriesTree($row['id'], $output);
                $output .= "</li>\r\n";
            }
            $output .= "</ul>\r\n";
        }
        return $output;
    }

    //function slug
    function _slug($cname) {
        $category_name = ($cname) ? $cname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $category_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('uri', $slug);
        $rs = $this->db->get('category');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('uri', $alt_slug);
                $rs = $this->db->get('category');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }

    function getCategoryDetailByName($category,$select='*') {
        $result = $this->db->select($select)
                        ->from('category')
                        ->where('name', $category)
                        ->get()->row_array()
        ;
        return $result;
    }

}

?>


