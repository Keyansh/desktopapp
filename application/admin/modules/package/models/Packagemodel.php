<?php

class Packagemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function countAll($sid) {
        $this->db->from('package');
        if ($sid)
            $this->db->where('show_id', $sid);
        else
            $this->db->where('show_id', '0');
        return $this->db->count_all_results();
    }

    function listAll($sid = FALSE, $offset = FALSE, $perpage = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($perpage)
            $this->db->limit($perpage);
        if ($sid)
            $this->db->where('show_id', $sid);
        else
            $this->db->where('show_id', '0');
        $rs = $this->db->get('package');
        return $rs->result_array();
    }

    function insertRecord() {
        $data = array();
        if ($this->input->post('show_id', TRUE))
            $data['show_id'] = $this->input->post('show_id', TRUE);
        else
            $data['show_id'] = 0;
        $data['package_name'] = $this->input->post('package_name', TRUE);
        if ($this->input->post('package_uri_alias', TRUE))
            $data['package_uri_alias'] = $this->input->post('package_uri_alias', TRUE);
        else
            $data['package_uri_alias'] = $this->_slug($this->input->post('package_name', TRUE));
        $data['package_price'] = $this->input->post('package_price', TRUE);
        $data['package_desc'] = $this->input->post('package_desc', TRUE);

        $this->db->insert('package', $data);
        return $data;
    }

    function getdetails($pid) {
        $this->db->where('product_id', $pid);
        $query = $this->db->get('product');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    function updateRecord($package) {
        $data = array();
        $data['package_name'] = $this->input->post('package_name', TRUE);
        if ($this->input->post('package_uri_alias', TRUE))
            $data['package_uri_alias'] = $this->input->post('package_uri_alias', TRUE);
        else
            $data['package_uri_alias'] = $package['package_uri_alias'];
        $data['package_price'] = $this->input->post('package_price', TRUE);
        $data['package_desc'] = $this->input->post('package_desc', TRUE);

        $this->db->where('package_id', $package['package_id']);
        $this->db->update('package', $data);
        return $package;
    }

    function deleteRecord($package) {
        $this->db->where('package_id', $package['package_id']);
        $this->db->delete('package');
    }

    function listAllProducts($pid) {
        //$this->db->select('product_bundle_item.*, product.product_name');
        $this->db->from('product_bundle_item');
        $this->db->join('product', 'product.product_id = product_bundle_item.bundled_item_id');
        $this->db->where('product_bundle_item.product_id', $pid);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    function getProducts() {
        $this->db->select('product_id, product_name');
        $this->db->where('product_type_id >', '2');
        $rs = $this->db->get('product');
        return $rs->result_array();
    }

    function insertProduct($pkid) {
        $data = array();
        $data['product_id'] = intval($pkid);
        $data['bundled_item_id'] = $this->input->post('product_id', TRUE);
        $data['product_quantity'] = $this->input->post('product_quantity', TRUE);
        if ($this->input->post('product_extra_price', TRUE))
            $data['product_extra_price'] = $this->input->post('product_extra_price', TRUE);

        $this->db->insert('product_bundle_item', $data);
    }

    function getProductDetail($ppid) {
        $this->db->where('product_bundle_item_id', $ppid);
        $query = $this->db->get('product_bundle_item');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    function updateProduct($ppid) {
        $data = array();
        $data['bundled_item_id'] = $this->input->post('bundled_item_id', TRUE);
        $data['product_quantity'] = $this->input->post('product_quantity', TRUE);
        if ($this->input->post('product_extra_price', TRUE))
            $data['product_extra_price'] = $this->input->post('product_extra_price', TRUE);

        $this->db->where('product_bundle_item_id', $ppid);
        $this->db->update('product_bundle_item', $data);
    }

    function deleteProduct($pack_product) {
        $this->db->where('product_bundle_item_id', $pack_product['product_bundle_item_id']);
        $this->db->delete('product_bundle_item');
    }

    function countAllShow() {
        $this->db->from('show');
        return $this->db->count_all_results();
    }

    function listAllShow($offset, $perpage) {
        if ($offset)
            $this->db->offset($offset);
        if ($perpage)
            $this->db->limit($perpage);
        $rs = $this->db->get('show');
        return $rs->result_array();
    }

    function insertShow() {
        $data = array();
        $data['show_name'] = $this->input->post('show_name', TRUE);
        if ($this->input->post('show_uri_alias', TRUE))
            $data['show_uri_alias'] = $this->input->post('show_uri_alias', TRUE);
        else
            $data['show_uri_alias'] = $this->_slugshow($this->input->post('show_name', TRUE));
        $data['show_code'] = $this->input->post('show_code', TRUE);

        $this->db->insert('show', $data);
    }

    function getShowDetail($sid) {
        $this->db->where('show_id', intval($sid));
        $query = $this->db->get('show');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    function updateShow($show) {
        $data = array();
        $data['show_name'] = $this->input->post('show_name', TRUE);
        if ($this->input->post('show_uri_alias', TRUE))
            $data['show_uri_alias'] = $this->input->post('show_uri_alias', TRUE);
        else
            $data['show_uri_alias'] = $show['show_uri_alias'];
        $data['show_code'] = $this->input->post('show_code', TRUE);

        $this->db->where('show_id', $show['show_id']);
        $this->db->update('show', $data);
    }

    function deleteShow($show) {
        $this->db->where('show_id', $show['show_id']);
        $this->db->delete('show');
    }

    //function slug for package
    function _slug($sname) {
        $sector = ($sname) ? $sname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $sector;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);

        $this->db->limit(1);
        $this->db->where('package_uri_alias', $slug);
        $rs = $this->db->get('package');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('package_uri_alias', $alt_slug);
                $rs = $this->db->get('package');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }

    //function slug for show
    function _slugshow($sname) {
        $sector = ($sname) ? $sname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $sector;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);

        $this->db->limit(1);
        $this->db->where('show_uri_alias', $slug);
        $rs = $this->db->get('show');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('show_uri_alias', $alt_slug);
                $rs = $this->db->get('show');
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