<?php

class Customermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //function count all
    function countAll() {
        $this->db->select('*');
        $this->db->from('customer');
//        $this->db->where('admin_approved', '1');
        return $this->db->count_all_results();
    }

    //function listAll
    function listAll($sortby, $direction, $offset, $limit) {
        $this->db->offset($offset);
        $this->db->limit($limit);
        $this->db->select('*');
        $this->db->order_by($sortby, $direction);
        $this->db->from('customer');
//        $this->db->where('admin_approved', '1');

        $rs = $this->db->get();
        return $rs->result_array();
    }

    //function get details
    function detail($cid) {

        $this->db->select('*');
        $this->db->from('customer');
        //$this->db->join('country','country.iso_code = customer.b_iso_code');
        $this->db->where('customer_id', $cid);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //function count all
    function countPendingAll($keywords) {
        $this->db->select('*');
        $this->db->from('customer');
//        $this->db->where('admin_approved', 0);
        if ($keywords != '0') {
            $keywords = mysql_real_escape_string($keywords);
//            $this->db->where("(MATCH(b_first_name,b_last_name,email) AGAINST ('$keywords'))");
            //$this->db->where("(b_first_name LIKE '%$keywords%' OR  b_last_name LIKE '%$keywords%' OR  email LIKE '%$keywords%')");
        }
        return $this->db->count_all_results();
    }

    //function listAll
    function listPendingAll($keywords, $offset, $limit) {
        $this->db->offset($offset);
        $this->db->limit($limit);

        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('admin_approved', 0);
        if ($keywords != '0') {
            $keywords = mysql_real_escape_string($keywords);
//            $this->db->where("(MATCH(b_first_name,b_last_name,email) AGAINST ('$keywords'))");
            //$this->db->where("(b_first_name LIKE '%$keywords%' OR  b_last_name LIKE '%$keywords%' OR  email LIKE '%$keywords%')");
        }

        $rs = $this->db->get();
        return $rs->result_array();
    }

    /* //function insert record
      function insertRecord(){
      $data = array();
      $data['coupon'] = $this->input->post('coupon', TRUE);
      $data['coupon_type'] = $this->input->post('coupon_type', TRUE);
      $data['coupon_price'] = $this->input->post('coupon_price', TRUE);
      $data['active'] = '1';

      $this->db->insert('coupon', $data);
      return;
      } */

//    //function update record
//    function updateRecord($customer) {
//
//        $data = array();
//
//        $data['pricing_plan_id'] = $this->input->post('pricing_plan_id', TRUE);
//        $data['b_title'] = $this->input->post('b_title', TRUE);
////        $data['b_first_name'] = $this->input->post('b_first_name', TRUE);
//        $data['b_last_name'] = $this->input->post('b_last_name', TRUE);
//        $data['b_address1'] = $this->input->post('b_address1', TRUE);
//        $data['b_address2'] = $this->input->post('b_address2', TRUE);
//        $data['b_city'] = $this->input->post('b_city', TRUE);
//        $data['b_state'] = $this->input->post('b_state', TRUE);
//        $data['b_postcode'] = $this->input->post('b_postcode', TRUE);
//        $data['phone'] = $this->input->post('phone', TRUE);
//
//        $data['s_title'] = $this->input->post('s_title', TRUE);
//        $data['s_first_name'] = $this->input->post('s_first_name', TRUE);
//        $data['s_last_name'] = $this->input->post('s_last_name', TRUE);
//        $data['s_address1'] = $this->input->post('s_address1', TRUE);
//        $data['s_address2'] = $this->input->post('s_address2', TRUE);
//        $data['s_city'] = $this->input->post('s_city', TRUE);
//        $data['s_state'] = $this->input->post('s_state', TRUE);
//        $data['s_postcode'] = $this->input->post('s_postcode', TRUE);
//        $data['s_mobile'] = $this->input->post('s_mobile', TRUE);
//
//        //print_r($data); exit();
//        $this->db->where('customer_id', $customer['customer_id']);
//        $this->db->update('customer', $data);
//    }

    function approveRecord($customer) {

        $data = array();
        $data['pricing_plan_id'] = $this->input->post('pricing_plan_id', TRUE);

        $data['admin_approved'] = 1;

        $this->db->where('customer_id', $customer['customer_id']);
        $this->db->update('customer', $data);

        //Send Confirmation email
        $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
//        $emailData['NAME'] = $customer['b_first_name'] . ' ' . $customer['b_last_name'];
        $emailData['PASSWORD'] = $this->input->post('passwd', TRUE);
        $emailBody = $this->parser->parse('emails/customer-approved', $emailData, TRUE);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->to($customer['email']);
        $this->email->subject('Account Activated at Consort hardware');
        $this->email->message($emailBody);
        $this->email->send();
    }

    //function delete record
//    function deleteRecord($customer) {
//
//        $this->db->where('customer_id', $customer['customer_id']);
//        $this->db->delete('customer');
//    }

    function customer_All() {
        $this->db->select('t1.*, t2.role,t3.company_address,t1.user_id as customer_id');
        $this->db->from('user t1');
        $this->db->join('role t2', 't2.role_id = t1.role_id', 'LEFT');
        $this->db->join('customer t3', 't3.user_id = t1.user_id', 'LEFT');
        if (curUsrId() != '1') {
            $this->db->where("t1.parent_id", curUsrId());
            $this->db->or_where("t1.user_id", curUsrId());
        } else {
            $this->db->where("t1.parent_id", 0);
            $this->db->where("t1.user_id !=", 1);
        }
        $this->db->where('guestuser', 0);
        $rs = $this->db->count_all_results();
        return $rs;
    }

    function All_customer($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $this->db->select('t1.*, t2.role,t3.company_address,t1.user_id as customer_id');
        $this->db->from('user t1');
        $this->db->join('role t2', 't2.role_id = t1.role_id', 'LEFT');
        $this->db->join('customer t3', 't3.user_id = t1.user_id', 'LEFT');
        if (curUsrId() != '1') {
            $this->db->where("t1.parent_id", curUsrId());
            $this->db->or_where("t1.user_id", curUsrId());
        } else {
            $this->db->where("t1.parent_id", 0);
            $this->db->where("t1.user_id !=", 1);
        }
        $this->db->order_by('t1.user_id', 'desc');
        $this->db->where('guestuser', 0);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    function fetchByID($uid) {
        return $this->db->select('t1.*,t2.company_address,t2.company_phone,t2.company_email,t2.company_city,t2.cash_credit,t2.catalauge,t2.dis_allocation,t2.company_postcode,t2.company_vat,t2.same_discount,t2.not_assign_discount,t1.user_id as customer_id')
                        ->from('user t1')
                        ->join('customer t2', 't1.user_id=t2.user_id', 'left')
                        ->where('t1.user_id', $uid)
                        ->get()->row_array();
    }

    function fetchAllProfileGroups() {
        return $this->db->select('*')
                        ->from('role')
                        ->where("role_id !=", 1)
                        ->get()->result_array();
    }

    function customergroups() {
        return $this->db->select('*')
                        ->from('customer_group')
                        ->get()->result_array();
    }

    function deleteRecord($userid) {
        $this->db->where("user_id", $userid);
        $this->db->where("user_id !=", 1);
        $this->db->delete('user');

        $this->db->where("user_id", $userid);
        $this->db->delete('customer');

        $this->db->where("user_id", $userid);
        $this->db->delete('category_price_list');
    }

}

?>
