<?php

class Couponmodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //get details of coupon
    function detail($cid) {
        $this->db->select('c.*, c.id as cpid, c1.*, c1.id as cpchid,c.id');
        $this->db->from('coupon c');
        $this->db->join('coupon_condition c1', 'c.id = c1.coupon_id', 'left');
        $this->db->where('c.id', $cid);
        $rs = $this->db->get();
        //return $this->db->last_query();
        if($rs->num_rows() > 0) {
            return $rs->row_array();
        }
        return FALSE;

    }

    //count all coupon
    function countAll($c_id = "") {
        if (!empty($c_id)) {
            $this->db->where('customer_id', $c_id);
        }
        if (isset($this->session->userdata['BRANCH_ID'])) {
            $this->db->where('company_id', $this->session->userdata['BRANCH_ID']);
        }
        $this->db->from('coupon');
        return $this->db->count_all_results();
    }

    //list all coupon
    function listAll($sortby, $direction, $offset = false, $limit = false, $c_id = "") {


        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);


        if (!empty($c_id)) {
            $this->db->where('customer_id', $c_id);
        }
        if (isset($this->session->userdata['BRANCH_ID'])) {
            $this->db->where('company_id', $this->session->userdata['BRANCH_ID']);
        }
        $this->db->order_by($sortby, $direction);
        $rs = $this->db->get('coupon');
        return $rs->result_array();
    }

    function listAllCompanies() {
        $rs = $this->db->get('company');
        return $rs->result_array();
    }

    //function to insert record
    function insertRecord() {

        $data = array();
        if($this->input->post('profile', TRUE) > -1){
            $data['profile_id'] = $this->input->post('profile', TRUE);
        }

        if($this->input->post('user', TRUE)){
            $data['user_id'] = $this->input->post('user', TRUE);
        }
        else{
            $data['user_id'] = 0;  
        }
        
        
        $data['coupon_title'] = $this->input->post('coupon_title', TRUE);
        $data['coupon_code'] = $this->input->post('coupon_code', TRUE);
        $data['redeem_type'] = $this->input->post('redeem_type', TRUE);

        $data['coupon_on'] = $this->input->post('coupon_on', TRUE);

        if ($data['coupon_on'] == "category") {
            $data['category'] = $this->input->post('category', TRUE);
        }

        if ($data['coupon_on'] != "product") {
            $data['coupon_type'] = $this->input->post('coupon_type', TRUE);
            $data['coupon_type_value'] = $this->input->post('coupon_type_value', TRUE);
            $data['min_basket_value'] = $this->input->post('min_basket_value', TRUE);
        }

        $term = $this->input->post('uses_term', TRUE);
        $data['uses_term'] = $term;
        $data['uses_limit'] = $term == 'onetime' ? 1 : $this->input->post('uses_limit', TRUE);
        $activeDate = explode("-",$this->input->post('active_date', TRUE));
        $expireDate = explode("-",$this->input->post('expire_date', TRUE));
        $data['active_date'] = $activeDate[2]."-".$activeDate[1]."-".$activeDate[0];
        $data['expire_date'] = $expireDate[2]."-".$expireDate[1]."-".$expireDate[0];
        $data['coupon_active'] = 1;
        $data['added_on'] = date('Y-m-d', time());
//        e( $data );
        $this->db->insert('coupon', $data);
        $coupon_id = $this->db->insert_id();

        if ($data['coupon_on'] == "product") {
            $category = $this->input->post('category', TRUE);
            $product = $this->input->post('product', TRUE);
            $basketvalue = $this->input->post('basket_value', TRUE);
            $couponType = $this->input->post('procoupntype', TRUE);
            $free = $this->input->post('free_qty', TRUE);
            $value = $this->input->post('value', TRUE);
            $percentage = $this->input->post('percentage', TRUE);
            //print_r($category);
            $condition = array();
            foreach ($category as $k => $v) {
                $condition['coupon_id'] = $coupon_id;
                $condition['category_id'] = $category[$k];
                $condition['product_id'] = $product[$k];
                $condition['basket_value'] = $basketvalue[$k];
                $condition['pro_coupon_type'] = $couponType[$k];
                
                if($couponType[$k] == 'free'){
                    $couponTypeValue[$k] = $free[$k];
                }

                if($couponType[$k] == 'value'){
                    $couponTypeValue[$k] = $value[$k];
                }

                if($couponType[$k] == 'percentage'){
                    $couponTypeValue[$k] = $percentage[$k];
                }

                $condition['pro_coupon_type_value'] = $couponTypeValue[$k];
                //print_r($condition);

                $this->db->insert('coupon_condition', $condition);
            }   
        }
    }

    function updateRecord($coupon) {
        $data = array();
        if($this->input->post('profile', TRUE) > -1){
            $data['profile_id'] = $this->input->post('profile', TRUE);
        }

        if($this->input->post('user', TRUE)){
            $data['user_id'] = $this->input->post('user', TRUE);
        }
        else{
            $data['user_id'] = 0;  
        }

        $data['coupon_title'] = $this->input->post('coupon_title', TRUE);
        $data['coupon_code'] = $this->input->post('coupon_code', TRUE);
        $data['redeem_type'] = $this->input->post('redeem_type', TRUE);

        $data['coupon_on'] = $this->input->post('coupon_on', TRUE);

        if ($data['coupon_on'] == "category") {
            $data['category'] = $this->input->post('category', TRUE);
        }

        if ($data['coupon_on'] != "product") {
            $data['coupon_type'] = $this->input->post('coupon_type', TRUE);
            $data['coupon_type_value'] = $this->input->post('coupon_type_value', TRUE);
            $data['min_basket_value'] = $this->input->post('min_basket_value', TRUE);
        }

        $term = $this->input->post('uses_term', TRUE);
        $data['uses_term'] = $term;
        $data['uses_limit'] = $term == 'onetime' ? 1 : $this->input->post('uses_limit', TRUE);
        $activeDate = explode("-",$this->input->post('active_date', TRUE));
        $expireDate = explode("-",$this->input->post('expire_date', TRUE));
        $data['active_date'] = $activeDate[2]."-".$activeDate[1]."-".$activeDate[0];
        $data['expire_date'] = $expireDate[2]."-".$expireDate[1]."-".$expireDate[0];
        $data['coupon_active'] = $coupon['coupon_active'];
        $data['added_on'] = $coupon['added_on'];
        $data['updated_on'] = date('Y-m-d', time());
        $this->db->where('id', $coupon['cpid']);
        $this->db->update('coupon', $data);

        $this->db->where('coupon_id', $coupon['id']);
        $this->db->delete('coupon_condition');

        if ($data['coupon_on'] == "product") {
            $category = $this->input->post('category', TRUE);
            $product = $this->input->post('product', TRUE);
            $basketvalue = $this->input->post('basket_value', TRUE);
            $couponType = $this->input->post('procoupntype', TRUE);
            $free = $this->input->post('free_qty', TRUE);
            $value = $this->input->post('value', TRUE);
            $percentage = $this->input->post('percentage', TRUE);
            // e($free,0);
            // e($value);
            $condition = array();
            foreach ($category as $k => $v) {
                $condition['coupon_id'] = $coupon['id'];                
                $condition['category_id'] = $category[$k];
                $condition['product_id'] = $product[$k];
                $condition['basket_value'] = $basketvalue[$k];
                $condition['pro_coupon_type'] = $couponType[$k];
                if($couponType[$k] == 'free'){
                    $couponTypeValue = $free[$k];
                }
                if($couponType[$k] == 'value'){
                    $couponTypeValue = $value[$k];
                }
                if($couponType[$k] == 'percentage'){
                    $couponTypeValue = $percentage[$k];
                }
                $condition['pro_coupon_type_value'] = $couponTypeValue;
                $this->db->where('coupon_id', $coupon['id']);
                $this->db->insert('coupon_condition', $condition);
            }
        }
    }

    //function to enable record
    function enableRecord($coupon) {
        $data = array();
        $data['coupon_active'] = 1;
        $this->db->where('id', $coupon['id']);
        $this->db->update('coupon', $data);
    }

    //function to disable record
    function disableRecord($coupon) {
        $data = array();
        $data['coupon_active'] = 0;
        $this->db->where('id', $coupon['id']);
        $this->db->update('coupon', $data);
    }

    //delete record
    function deleteRecord($coupon) {
        $this->db->where('id', $coupon['id']);
        $this->db->delete('coupon');
        $this->db->where('coupon_id', $coupon['id']);
        $this->db->delete('coupon_condition');
    }

}

?>