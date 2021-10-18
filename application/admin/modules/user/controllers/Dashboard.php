<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $orders = array();
        $orders = $this->Usermodel->graphAmtOrders('month');
        $order_labels_month = @array_column($orders, 'month');
        $order_sum_month = @array_column($orders, 'order_total');
        $odr_months = getMonthsNameFromNumSq($order_labels_month);
        $inner = array();
        $inner['user'] = $this->getUser();
        $inner['orders'] = $orders;
        $inner['graph_labels'] = json_encode($odr_months);
        $inner['graph_data'] = json_encode($order_sum_month);
        $page = array();
        $page['content'] = $this->load->view('user/dashboard', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function password_check($str) {
        $this->load->library('encrypt');

        $this->db->where('user_id', $this->input->post('user_id', true));
        $query = $this->db->get('user');
        if ($query->num_rows() == 1) {
            $row = $query->row_array();
            if ($this->encrypt->decode($row['passwd']) == $str) {
                return true;
            }
        }

        $this->form_validation->set_message('password_check', 'Old Password is incorrect');
        return false;
    }

    function changepassword() {
        $this->load->library('encrypt');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('old_passwd', 'Old Password', 'trim|required|callback_password_check');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required');
        $this->form_validation->set_rules('passwd1', 'Confirm Password', 'trim|required|matches[passwd]');
        $this->form_validation->set_error_delimiters('<li>', '</li>');


        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['user'] = $this->getUser();
            $page['content'] = $this->load->view('user/change-password', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Usermodel->updatePassword($this->getUser());

            $this->session->set_flashdata('SUCCESS', 'admin_updated');

            redirect("/dashboard/changepassword/");
            exit();
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect("/welcome/");
        exit();
    }

    function getGraphData() {
        $graph_mode = 'month';
        $graph_name = $this->input->get('graph_name');

        if ($this->input->get('graph_mode')) {
            $graph_mode = $this->input->get('graph_mode');
            if ($graph_mode == 'days_graph') {
                $graph_mode = 'days';
            } elseif ($graph_mode == 'month_graph') {
                $graph_mode = 'month';
            }
        }
        $this->load->model('Usermodel');
        $orders = array();
        $graph_data = [];
        $graph_labels = [];
        if ($graph_name == 'order-amt-data') {
            $orders = $this->Usermodel->graphAmtOrders($graph_mode);
            if ($graph_mode == 'month') {
                $order_labels_month = array_column($orders, 'month');
                $graph_data = array_column($orders, 'order_total');
                $graph_labels = getMonthsNameFromNumSq($order_labels_month);
            } else if ($graph_mode == 'days') {
                $order_labels_month = array_column($orders, 'days');
                $graph_data = array_column($orders, 'order_total');
                $graph_labels = getGraphMonthName($order_labels_month);
            }
        } else if ($graph_name == 'order-sale-data') {
            $orders = $this->Usermodel->graphSaleOrders($graph_mode);
            if ($graph_mode == 'month') {
                $order_labels_month = array_column($orders, 'month');
                $graph_data = array_column($orders, 'cnt');
                $graph_labels = getMonthsNameFromNumSq($order_labels_month);
            } else if ($graph_mode == 'days') {
                $order_labels_month = array_column($orders, 'days');
                $graph_data = array_column($orders, 'cnt');
                $graph_labels = getGraphMonthName($order_labels_month);
            }
        }
        echo json_encode(array('graph_data' => $graph_data, 'graph_labels' => $graph_labels));
        exit;
    }

}

?>
