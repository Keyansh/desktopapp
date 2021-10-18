<?php

class Ordermodel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function detail($oid)
    {

        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('order_detail', 'order_detail.order_id = order.order_id');
        $this->db->where('order.order_num', $oid);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false; 
    }

    //count all customer
    function countAll($customer)
    {
        $this->db->select('order_id');
        $this->db->where('customer_id', $customer['user_id']);
        //$this->db->where('confirmed',1);
        $query = $this->db->get('order');
        return $query->num_rows();
        //return $this->db->count_all_results();
    }

    //List all customer
    function listAll($customer, $offset, $limit)
    {
        $this->db->offset($offset);
        $this->db->limit($limit);
        $this->db->from('order');
        $this->db->join('order_detail', 'order_detail.order_id = order.order_id');
        $this->db->where('order.customer_id', $customer['user_id']);
        //$this->db->where('order.confirmed', 1);
        $this->db->order_by('order_time', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    //fetch by id
    function fetchById($oid)
    {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('order_detail', 'order_detail.order_id = order.order_id', 'LEFT');
        $this->db->where('order.order_id', $oid);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //fetch details
    function fetchDetails($onum)
    {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('order_detail', 'order_detail.order_id = order.order_id');
        $this->db->where('order.order_num', $onum);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    function listOrderItems($oid)
    {
        $this->db->from('order_item');
        $this->db->where('order_id', $oid);
        $query = $this->db->get();
        return $query->result_array();
    }

    function fetchByOrderNum($onum)
    {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('order_detail', 'order_detail.order_id = order.order_id');
        //        $this->db->join('company', 'company.company_id = order.company_id');
        $this->db->where('order.order_num', $onum);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    function getOrderDetails($oid)
    {
        return $this->db->from('order')
            ->join('order_detail', 'order_detail.order_id = order.order_id')
            ->where('order.order_id', $oid)
            ->get()->result_array();
    }

    function fetchByPaymentIntend($pi)
    {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('order.payment_intent', $pi);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    function listAllEnquiry($customer, $offset, $limit)
    {
        $this->db->offset($offset);
        $this->db->limit($limit);
        $this->db->where('user_id', $customer);
        $rs = $this->db->get('checkout_enquiry');
        return $rs->result_array();
    }
    function enquiryDetails($customer)
    {
        $this->db->where('id', $customer);
        $rs = $this->db->get('checkout_enquiry');
        return $rs->row_array();
    }
}
