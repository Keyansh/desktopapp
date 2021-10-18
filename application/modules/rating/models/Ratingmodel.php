<?php

class Ratingmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //fetch the attributes details
    function insertRecord() {

        $data = array();
        $data['user_id'] = $this->input->post('user_id');
        $data['product_id'] = $this->input->post('product_id');
        $data['name'] = $this->input->post('name');
        $data['summery'] = $this->input->post('summery');
        $data['review'] = $this->input->post('review');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['status'] = 0;
        $data['rate'] = $this->input->post('score');
        $data['addedon'] = time();
        $insertRes = $this->db->insert('review', $data);

        return $insertRes;
    }

    function checkIp($productId) {
        $this->db->where('ip', $_SERVER['REMOTE_ADDR']);
        $this->db->where('product_id', $productId);
        $res = $this->db->get('review');
        //  echo $this->db->last_query();
        if ($res->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    function getVerifiedReviewsByProductID($id) {
        $this->db->select('name, summery, review, rate, addedon');
        $this->db->where('product_id', $id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'desc');
        return $this->db->get('review')->result_array();
    }

    function getaverage($productId) {
//        $this->db->select('avg(rate) as avgrate');
//        $this->db->where('status',1);
//        $this->db->where('product_id',$productId);
//        $r = $this->db->get('review')->first_row('array');
//        return number_format($r['avgrate'], 1);
        $this->db->select('avg(rate) as avgrate');
        $this->db->from('review');
        $this->db->where('status', 1);
        $this->db->where('product_id', $productId);
        $r = $this->db->get()->first_row('array');
        return number_format($r['avgrate']);
    }

    function getCatAverage($categoryId) {

        $this->db->select('product_id')
                ->from('product')
                ->where('category_id', $categoryId);

        $query = $this->db->get();
        $ids = "";
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();

            foreach ($rows as $row) {
                $ids .= $row['product_id'] . ",";
            }
            $ids = substr($ids, 0, -1);
        }

        if ($ids != '') {
            $sql_query = $this->db->query("SELECT count(*) as total, SUM(rating) as total_rating FROM eve_review where 1 = 1 and product_id IN($ids) and status = 1");
            $s_row = $sql_query->row_array();

            $_total = $s_row['total'];
            $_Rating = $s_row['total_rating'];

            $average = round($_Rating / $_total);

            return $average;
        } else {
            $average = "0";
            return $average;
        }
    }

}

?>
