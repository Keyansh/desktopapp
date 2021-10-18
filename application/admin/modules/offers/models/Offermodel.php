<?php

class Offermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Get detail of Offer
    function getdetails($nid) {
        $this->db->where('id', intval($nid));
        $query = $this->db->get('offers');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //Count All Offer
    function countAll() {
        $this->db->from('offers');
        return $this->db->count_all_results();
    }

    //list all Offer
    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $rs = $this->db->get('offers');
        return $rs->result_array();
    }

    //insert record
    function insertRecord() {
        $data = array();
        $data['name'] = $this->input->post('name', true);
        if ($this->input->post('alias', TRUE) == '') {
            $data['alias'] = $this->_slug($this->input->post('name', TRUE));
        } else {
            $data['alias'] = url_title($this->input->post('alias', TRUE));
        }
        $data['content'] = $this->input->post('contents', false);
        $data['price'] = $this->input->post('price', true);
        $data['start_on'] = date('Y-m-d', strtotime($this->input->post('start_on', true)));
        $data['end_on'] = date('Y-m-d', strtotime($this->input->post('end_on', true)));
        $data['addedon'] = time();

        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('OFFER_BANNER_PATH');
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);

        if (count($_FILES) > 0) {
            if ($_FILES['banner']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['banner']['tmp_name'])) {
                if (!$this->upload->do_upload('banner')) {

                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    $data['banner'] = $upload_data['file_name'];
                }
            }
        }

        $this->db->insert('offers', $data);
        return;
    }

    //update record
    function updateRecord($offer) {
        $data = array();
        $data['name'] = $this->input->post('name', true);
        if ($this->input->post('alias', TRUE) == '') {
            $data['alias'] = $offer['alias'];
        } else {
            $data['alias'] = url_title($this->input->post('alias', TRUE));
        }
        $data['content'] = $this->input->post('contents', false);
        $data['start_on'] = date('Y-m-d', strtotime($this->input->post('start_on')));
        $data['end_on'] = date('Y-m-d', strtotime($this->input->post('end_on')));
        $data['price'] = $this->input->post('price', true);

        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('OFFER_BANNER_PATH');
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);

        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['banner']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['banner']['tmp_name'])) {
                if (!$this->upload->do_upload('banner')) {

                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    $data['banner'] = $upload_data['file_name'];

                    $path = $this->config->item('OFFER_BANNER_PATH');
                    $filename = $path . $offer['banner'];
                    if (file_exists($filename)) {
                        @unlink($filename);
                    }
                }
            }
        }


        $this->db->where('id', $offer['id']);
        $this->db->update('offers', $data);
        return;
    }

    //Function Delete Record
    function deleteRecord($offer) {
        $this->db->where('id', $offer['id']);
        $this->db->delete('offers');


        $path = $this->config->item('OFFER_BANNER_PATH');
        $filename = $path . $offer['banner'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
    }

    //function slug
    function _slug($offerstitle) {
        $name = ($offerstitle) ? $offerstitle : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('alias', $slug);
        $rs = $this->db->get('offers');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('alias', $alt_slug);
                $rs = $this->db->get('offers');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }

    function enableRecord($offer) {
        $data = array();
        $data['is_active'] = 1;
        $this->db->where('id', $offer['id']);
        $this->db->update('offers', $data);
        return;
    }

    function disableRecord($offer) {
        $data = array();
        $data['is_active'] = 0;
        $this->db->where('id', $offer['id']);
        $this->db->update('offers', $data);
        return;
    }

    //create indented list
    function indentedList($parent, &$output = array()) {
        $this->db->where('parent_id', $parent);
        $query = $this->db->get('category');
        foreach ($query->result_array() as $row) {
            $output[] = $row;
            $this->indentedList($row['id'], $output);
        }
        return $output;
    }

    function mainCats() {
        $this->db->where('active', 1);
        $this->db->where('parent_id', 0);
        return $query = $this->db->get('category')->result_array();
    }

    function allProducts() {
        $this->db->select('id,name');
        $this->db->where('type', 'config');
        $this->db->where('is_active', 1);
        $rs = $this->db->get('product');
        return $rs->result_array();
    }

    function assignOffer($offer) {
        $categories = $this->input->post('category', true);
        $products = $this->input->post('product', true);

//        ee($categories, 0);
//        if ($categories) {
//            foreach ($categories as $category) {
//                $pid = self::getParentId($category);
//                if (!in_array($pid['parent_id'], $categories)) {
//                    $insertVar[] = $category;
//                }
//            }
//        }
//        ee($insertVar);
        $this->db->where('oid', $offer['id']);
        $this->db->delete('offer_prods');

        $this->db->where('oid', $offer['id']);
        $this->db->delete('offer_cates');
        if ($products) {
            foreach ($products as $product) {
                $data['oid'] = $offer['id'];
                $data['pid'] = $product;
                $this->db->insert('offer_prods', $data);
            }
        } elseif ($categories) {
            foreach ($categories as $category) {
                $pid = self::getParentId($category);
                if (!in_array($pid['parent_id'], $categories)) {
                    $insertVar[] = $category;
                }
            }
            foreach ($insertVar as $ins) {
                $data['oid'] = $offer['id'];
                $data['cid'] = $ins;
                $this->db->insert('offer_cates', $data);
            }
        }
    }

    function getParentId($cid) {
        $this->db->where('parent_id', $cid);
        $query = $this->db->get('category');
        return $query->row_array();
    }

}

?>