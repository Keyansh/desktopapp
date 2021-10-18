<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coupon extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    // validation start for add******************************************
    //valid coupon title
    function valid_value($str) {
        $this->db->where('coupon_title', $str);
        $query = $this->db->get('coupon');
        if ($query->num_rows() != 0) {
            $this->form_validation->set_message('valid_value', 'Coupon is already in use');
            return false;
        }

        return true;
    }

    //valid coupon title
    function validCoupon($str) {
        $this->db->where('coupon_title', $str);
        $this->db->where('coupon_id !=', $this->input->post('coupon_id', true));
        $query = $this->db->get('coupon');
        if ($query->num_rows() != 0) {
            $this->form_validation->set_message('validCoupon', 'Coupon is already existing!');
            return false;
        }
        return true;
    }

    //**************************************************validation end

    function index($sortby = 'coupon_title', $direction = 'asc', $offset = false) {
        $this->load->model('Couponmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        if (!$this->checkAccess('MANAGE_COUPONS')) {
            show_error('You do not have permission to access this resource!');
        }

        //Setup pagination
        $perpage = 50;
        $config['base_url'] = base_url() . "coupon/index/$sortby/$direction/";
        $config['uri_segment'] = 5;
        $config['total_rows'] = $this->Couponmodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //Get all coupon
        $coupon = array();
        $coupon = $this->Couponmodel->listAll($sortby, $direction, $offset, $perpage);

        if ($direction == 'desc') {
            $toggle_direction = 'asc';
        } else {
            $toggle_direction = 'desc';
        }

        //render view
        $inner = array();
        $inner['coupon'] = $coupon;
        $inner['toggle_direction'] = $toggle_direction;
        $inner['sortby'] = $sortby;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('coupon-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Couponmodel');

        if (!$this->checkAccess('MANAGE_COUPONS')) {
            show_error('You do not have permission to access this resource!');
        }

        $company = array();
        $company = $this->Couponmodel->listAllCompanies();
        $options = array();
        $options['0'] = 'All';
        foreach ($company as $item) {
            $options[$item['company_id']] = $item['company_name'];
        }


        //Form Validation
        $this->form_validation->set_rules('coupon_title', 'Coupon Title', 'trim|required|callback_valid_value');
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
        $this->form_validation->set_rules('coupon_value', 'Coupon Value', 'trim|required');
        $this->form_validation->set_rules('active_from', 'Active From', 'trim|required');
        $this->form_validation->set_rules('active_to', 'Active To', 'trim|required');
        $this->form_validation->set_rules('minimum_order_value', 'Minimum Order Value', 'trim');
        $this->form_validation->set_rules('coupon_type', 'Coupon Type', 'trim|required');
		$this->form_validation->set_rules('one_time_use', 'One Time Use', 'trim|required');

        $this->form_validation->set_rules('company_id', 'Company Name', 'trim|required');

        $coupn_type = '';
        $coupn_type = $this->input->post('coupon_type', true);


        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $coupon_type = array();
        $coupon_type[''] = 'Select';
        $coupon_type['Value'] = 'Value';
        $coupon_type['Percentage'] = 'Percentage';

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['coupon_type'] = $coupon_type;
            $inner['options'] = $options;

            $page['content'] = $this->load->view('coupon-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Couponmodel->insertRecord();

            $this->session->set_flashdata('SUCCESS', 'coupon_added');

            redirect("coupon/index/");
            exit();
        }
    }

    //function edit
    function edit($cid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Couponmodel');

        if (!$this->checkAccess('MANAGE_COUPONS')) {
            show_error('You do not have permission to access this resource!');
        }

        $coupon = array();
        $coupon = $this->Couponmodel->detail($cid);
        if (!$coupon) {
            $this->utility->show404();
            return;
        }

        $company = array();
        $company = $this->Couponmodel->listAllCompanies();
        $options = array();
        $options['0'] = 'All';
        foreach ($company as $item) {
            $options[$item['company_id']] = $item['company_name'];
        }


        //Form Validation
        $this->form_validation->set_rules('coupon_title', 'Coupon Title', 'trim|required|callback_validCoupon');
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
        $this->form_validation->set_rules('coupon_value', 'Coupon Value', 'trim|required');
        $this->form_validation->set_rules('active_from', 'Coupon Date', 'trim|required');
        $this->form_validation->set_rules('active_to', 'Expiry Date', 'trim|required');
        $this->form_validation->set_rules('minimum_order_value', 'Minimum Order Value', 'trim');
        $this->form_validation->set_rules('coupon_type', 'Coupon Type', 'trim|required');
		$this->form_validation->set_rules('one_time_use', 'One Time Use', 'trim|required');

        $this->form_validation->set_rules('company_id', 'Company Name', 'trim|required');

        $coupn_type = '';
        $coupn_type = $this->input->post('coupon_type', true);

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $coupon_type = array();
        $coupon_type[''] = 'Select';
        $coupon_type['Value'] = 'Value';
        $coupon_type['Percentage'] = 'Percentage';

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();

            $inner['coupon'] = $coupon;
            $inner['coupon_type'] = $coupon_type;
            $inner['options'] = $options;

            $page['content'] = $this->load->view('coupon-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Couponmodel->updateRecord($coupon);

            $this->session->set_flashdata('SUCCESS', 'coupon_updated');

            redirect("coupon/index/");
            exit();
        }
    }

    //enable coupon
    function enable($cid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Couponmodel');

        if (!$this->checkAccess('MANAGE_COUPONS')) {
            show_error('You do not have permission to access this resource!');
        }

        //get coupon detail
        $coupon = array();
        $coupon = $this->Couponmodel->detail($cid);
        if (!$coupon) {
            $this->utility->show404();
            return;
        }

        $this->Couponmodel->enableRecord($coupon);

        $this->session->set_flashdata('SUCCESS', 'coupon_updated');

        redirect("coupon/index/");
        exit();
    }

    //disable coupon
    function disable($cid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Couponmodel');

        if (!$this->checkAccess('MANAGE_COUPONS')) {
            show_error('You do not have permission to access this resource!');
        }

        //get coupon detail
        $coupon = array();
        $coupon = $this->Couponmodel->detail($cid);
        if (!$coupon) {
            $this->utility->show404();
            return;
        }

        $this->Couponmodel->disableRecord($coupon);

        $this->session->set_flashdata('SUCCESS', 'coupon_updated');

        redirect("coupon/index/");
        exit();
    }

    function delete($cid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Couponmodel');

        if (!$this->checkAccess('MANAGE_COUPONS')) {
            show_error('You do not have permission to access this resource!');
        }

        //Get coupon Details
        $coupon = array();
        $coupon = $this->Couponmodel->detail($cid);
        if (!$coupon) {
            $this->utility->show404();
            return;
        }

        //Delete coupon
        $this->Couponmodel->deleteRecord($coupon);

        $this->session->set_flashdata('SUCCESS', 'coupon_deleted');

        redirect("coupon/index/");
        exit();
    }

}

?>