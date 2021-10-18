<?php
    defined('BASEPATH') or exit('No direct script access allowed');
    class Shippingrules extends Admin_Controller
    {
        function __construct() {
            parent::__construct();
            $this->load->model('Shippingrules_model');
        }

        function index() {
            $rules = array();
            $rules = $this->Shippingrules_model->get_rules();

            $inner = array();
            $inner['rules'] = $rules;

            $page = array();
            $page['content'] = $this->load->view('shippingrules-index', $inner, TRUE);
            $this->load->view('shell', $page);
        }

        function add() {
            $order_min_weight = 0;
            $order_max_weight = 0;
            $next_day_delivery = 0;
            $two_days_postage = 0;

            $order_min_weight = $this->input->post('order_min_weight');
            $order_max_weight = $this->input->post('order_max_weight');
            $two_days_postage = $this->input->post('two_days_postage');
            $next_day_delivery = $this->input->post('next_day_delivery');

            if ($order_min_weight && $two_days_postage) {
                if ($this->Shippingrules_model->do_order_value_exist($order_min_weight,$order_max_weight)) {
                    echo 'duplicate';
                } else {
                    $data = array();
                    $data['order_min_weight'] = $order_min_weight;
                    $data['order_max_weight'] = $order_max_weight;
                    $data['2days_postage'] = $two_days_postage;
                    $data['next_day_delivery'] = $next_day_delivery;
                    $data['added_on'] = time();
                    echo $this->db->insert('shipping_rules', $data);
                }
            } else {
                echo 'not-done';
            }
        }

        function remove() {
            $rule_id = 0;
            $rule_id = $this->input->post('id');

            if ($rule_id) {
                $this->db->where('id', $rule_id)->delete('shipping_rules');
            } else {
                echo 'not-done';
            }
        }
    }
?>
