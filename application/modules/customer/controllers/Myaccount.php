<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class myaccount extends Cms_Controller {

    function __construct() {
        parent::__construct();
    }

    function index($offset = 0) {
        $this->load->model('Customermodel');
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');
        $this->load->helper('form');
        if (!$this->memberauth->checkAuth()) {
            redirect("/customer/login/");
            exit();
        }
        $title = array();
        $title[''] = '--Select--';
        $title['mr'] = 'Mr';
        $title['mrs'] = 'Mrs';
        $title['miss'] = 'Miss';

        $customer = array();
        $customer = $this->memberauth->checkAuth();
        //e($customer,0);
        //Validation checks
        //$this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|strtolower|valid_email|callback_email_check');
        // $this->form_validation->set_rules('confirm_email', 'Confirm Email', 'trim|strtolower|valid_email|matches[email]');
        // $this->form_validation->set_rules('cpasswd', 'Confirm Password', 'trim|matches[passwd]');
        $this->form_validation->set_rules('address1', 'Address 1', 'trim|required');
        $this->form_validation->set_rules('address2', 'Address 2', 'trim');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        //$this->form_validation->set_rules('state', 'County', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|numeric');
        $this->form_validation->set_rules('zipcode', 'Zip Code', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        // $countries = array();
        // $countries_rs = $this->Customermodel->getCountries();
        // $countries[''] = "----   Select Country ----";
        // foreach ($countries_rs as $country) {
        //     $countries[$country['country_code']] = $country['country_name'];
        // }
        $inner = array();
        $success = array();
        if ($this->form_validation->run() == FALSE) {
            $inner['title'] = $title;
            //$inner['countries'] = $countries;
            $inner['customer'] = $customer;
            $inner['success'] = array();
            $shell = array();
            $shell['contents'] = $this->load->view('myaccount', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/product", $shell);
        } else {
            $success = array('success');
            $customer = array();
            $customer = $this->Customermodel->updateUserRecord();
            $inner['title'] = $title;
            //$inner['countries'] = $countries;
            $inner['customer'] = $customer;
            $inner['success'] = $success;
            $shell['contents'] = $this->load->view("myaccount", $inner, true);
            $this->load->view("themes/" . THEME . "/templates/product", $shell);
        }
    }

    function changepassword($offset = 0) {
        $this->load->model('Customermodel');
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');
        $this->load->helper('form');
        if (!$this->memberauth->checkAuth()) {
            redirect("/customer/login/");
            exit();
        }
        $title = array();
        $this->form_validation->set_rules('password', 'Current Password', 'trim|required|callback_correct_password');
        $this->form_validation->set_rules('newpassword', 'New Password', 'trim|required');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|matches[newpassword]');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $customer = array();
        $customer = $this->memberauth->checkAuth();


        $inner = array();
        $success = array();
        if ($this->form_validation->run() == FALSE) {
            $inner['success'] = array();
            $inner['customer'] = $customer;
            $shell = array();
            $shell['contents'] = $this->load->view('changepassword', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/product", $shell);
        } else {
            $success = array('success');
            $this->Customermodel->updatePassword($customer);
            $inner['success'] = $success;
            $shell['contents'] = $this->load->view("changepassword", $inner, true);
            $this->load->view("themes/" . THEME . "/templates/product", $shell);
        }
    }

    function correct_password($str) {
        $this->load->library('encrypt');
        $this->db->where('user_id', $this->session->userdata('CUSTOMER_ID'));
        $query = $this->db->get('user');
        if ($query->num_rows() == 1) {
            $row = $query->row_array();
            if ($this->encrypt->decode($row['passwd']) == $str) {
                return true;
            }
        }
        $this->form_validation->set_message('correct_password', 'Old Password is incorrect');
        return false;
    }

}
