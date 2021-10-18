<?php
    class Shippingrules_model extends CI_Model
    {
        function __construct() {
            parent::__construct();
        }

        function get_rules() {
            $rs = array();
            $rs = $this->db->select('*')
                ->from('shipping_rules')
                ->order_by('order_min_weight')
                ->get();

            if ($rs->num_rows()) {
                return $rs->result_array();
            }

            return FALSE;
        }

        function do_order_value_exist($order_min_weight,$order_max_weight) {
            $rs = array();

            $rs = $this->db->select('*')
                ->from('shipping_rules')
                ->where('order_min_weight', $order_min_weight)
                ->where('order_max_weight', $order_max_weight)
                ->get();

            if ($rs->num_rows() == 1) {
                return TRUE;
            }

            return FALSE;
        }
    }
?>
