<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coupon extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Couponmodel');
        
    }

    // validation start for add******************************************

    function validDate() {
        $frm_date = $this->input->post('active_date', TRUE);
        $to_date = $this->input->post('expire_date', TRUE);
        if ($to_date < $frm_date) {
            $this->form_validation->set_message('validDate', 'Active To date can not be less than Active From date.');
            return false;
        }
        return True;
    }

    function chech_nan() {
        if (is_nan($this->input->post("coupon_value"))) {
            return false;
        } else {
            $this->form_validation->set_message('chech_nan', 'Coupon value is not a number.');
            return true;
        }
    }

    //valid coupon title

    function valid_value($str) {
        $this->db->where('coupon_code', $str);
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
        $this->db->where('id !=', $this->input->post('id', true));
        $query = $this->db->get('coupon');
        if ($query->num_rows() != 0) {
            $this->form_validation->set_message('validCoupon', 'Coupon is already existing!');
            return false;
        }
        return true;
    }

    //**************************************************validation end

    function index($sortby = 'coupon_title', $direction = 'asc', $offset = false) {
        if (isset($this->session->userdata['CUSTOMER_ID'])) {
            $this->session->unset_userdata('CUSTOMER_ID');
        }

        //$this->load->model('Couponmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        //$this->load->library('form_validation');
        //$this->load->library('Memberauth');
        //Setup pagination
        $perpage = 10;
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
        $this->load->model('Usermodel');
        $this->load->helper('form');
        $this->load->library('form_validation');        
        $this->load->model('Couponmodel');
        $this->load->model('catalog/Categorymodel');
        $this->load->model('user/Usermodel');
        $this->load->library('couponcode');

        //Auto Generate Coupon code
        //$cpCode = $this->couponcode->generate(8);

        # Fetch all Profile Groups
        $profileGroups = array();
        $profile_rs = $this->Usermodel->fetchAllProfileGroups();
        $profileGroups[0] = "All Profile";
        foreach ($profile_rs as $rowArr) {
            $profileGroups[$rowArr['id']] = $rowArr['profile_name'];
        }

        //fetch category
        $categories = array();
        $catArray = array();
        $categories = $this->Categorymodel->indentedList(0);
        foreach ($categories as $row) {
            $catArray['id'][] = $row['id'];
            $catArray['name'][] = str_repeat('&nbsp;', ($row['depth']) * 4) . $row['name'];
        }

        //Form Validation
        $this->form_validation->set_rules('profile', 'Profile', 'trim|required');
        if($this->input->post('user',true)){
            $this->form_validation->set_rules('user', 'User', 'trim|required');
        }
        

        $this->form_validation->set_rules('coupon_title', 'Coupon Title', 'trim|required');
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|callback_valid_value');
        $this->form_validation->set_rules('coupon_type', 'Coupon Type', 'trim|required');
        $this->form_validation->set_rules('redeem_type', 'Redeem Type', 'trim|required');
        $this->form_validation->set_rules('coupon_on', 'Coupon On', 'trim|required');


        if ($this->input->post('coupon_on') != "product") {
            $this->form_validation->set_rules('coupon_type', 'Coupon Type', 'trim|required|callback_chech_nan');
            $this->form_validation->set_rules('coupon_type_value', 'Coupon Type Value', 'trim|required|callback_chech_nan');
        }

        if ($this->input->post('procoupntype') == "free") {
            echo "FREE";

            $this->form_validation->set_rules('free_qty', 'Free Coupon', 'trim');
           
        }
        if ($this->input->post('procoupntype') == "value") {
            
            $this->form_validation->set_rules('value', 'Coupon Value', 'trim');
           
        }
        if ($this->input->post('procoupntype') == "percentage") {
            
            $this->form_validation->set_rules('percentage', 'Coupon Percentage', 'trim');
           
        }

        if ($this->input->post('coupon_on') == "category") {
            $this->form_validation->set_rules('category', 'Category', 'trim|required');
        }


        $this->form_validation->set_rules('uses_term', 'Uses Term', 'trim');
        $this->form_validation->set_rules('uses_limit', 'Uses Limit', 'trim|integer');

        $this->form_validation->set_rules('active_date', 'Active Date', 'trim|required');
        $this->form_validation->set_rules('expire_date', 'Expire Date', 'trim|required|callback_validDate');
        $this->form_validation->set_rules('min_basket_value', 'Minimum Basket Value', 'trim|integer');


        $coupn_type = $this->input->post('coupon_type', true);

        /*echo "<pre>";
        print_r($this->input->post());
        echo "</pre>";*/

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['profilegroups'] = $profileGroups;
            $inner['category_options'] = $catArray;
            //$inner['coupon_code'] = $cpCode;
            // e($inner);
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
        $this->load->model('catalog/Categorymodel');
        $this->load->model('user/Usermodel');

        $coupon = array();
        $coupon = $this->Couponmodel->detail($cid);
        //print_r($coupon);

        if (!$coupon) {
            $this->utility->show404();
            return;
        }

        //fetch category
        $categories = array();
        $catArray = array();
        $categories = $this->Categorymodel->indentedList(0);
        foreach ($categories as $row) {
            $catArray['id'][] = $row['id'];
            $catArray['name'][] = str_repeat('&nbsp;', ($row['depth']) * 4) . $row['name'];
        }
        
        # Fetch all Profile Groups
        $profileGroups = array();
        $profile_rs = $this->Usermodel->fetchAllProfileGroups();
        $profileGroups[0] = "All Profile";
        foreach ($profile_rs as $rowArr) {
            $profileGroups[$rowArr['id']] = $rowArr['profile_name'];
        }

        //Form Validation
        $this->form_validation->set_rules('profile', 'Profile', 'trim|required');
        if($this->input->post('user',true)){
            $this->form_validation->set_rules('user', 'User', 'trim|required');
        }
        
        $this->form_validation->set_rules('coupon_title', 'Coupon Title', 'trim|required');
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
        $this->form_validation->set_rules('coupon_type', 'Coupon Type', 'trim|required');
        $this->form_validation->set_rules('redeem_type', 'Redeem Type', 'trim|required');
        $this->form_validation->set_rules('coupon_on', 'Coupon On', 'trim|required');


        if ($this->input->post('coupon_on') != "product") {
            $this->form_validation->set_rules('coupon_type', 'Coupon Type', 'trim|required|callback_chech_nan');
            $this->form_validation->set_rules('coupon_type_value', 'Coupon Type Value', 'trim|required|callback_chech_nan');
        }

        if ($this->input->post('coupon_on') == "category") {
            $this->form_validation->set_rules('category', 'Category', 'trim|required');
        }


        $this->form_validation->set_rules('uses_term', 'Uses Term', 'trim');
        $this->form_validation->set_rules('uses_limit', 'Uses Limit', 'trim|integer');

        $this->form_validation->set_rules('active_date', 'Active Date', 'trim|required');
        $this->form_validation->set_rules('expire_date', 'Expire Date', 'trim|required|callback_validDate');
        $this->form_validation->set_rules('min_basket_value', 'Minimum Basket Value', 'trim|integer');



        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            // e($coupon);
            $inner['coupon'] = $coupon;
            $inner['profilegroups'] = $profileGroups;
            $inner['category_options'] = $catArray;
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
        /*$this->load->library('form_validation');
        $this->load->helper('form');*/
        //get coupon detail
        $this->load->model('Couponmodel');
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
      /* $this->load->library('form_validation');
       $this->load->helper('form');*/
       $this->load->model('Couponmodel');
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
    //delete coupon
    function delete($cid) {
        /*$this->load->library('form_validation');
        $this->load->helper('form');*/
        $this->load->model('Couponmodel');

        /*if (!$this->checkAccess('MANAGE_COUPONS')) {
            show_error('You do not have permission to access this resource!');
        }*/

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

    function getCouponProduct($couponid) {
        $r = $this->db->get_where('coupon_condition', array('coupon_id' => $couponid
        ));
        echo json_encode($r->result_array());
    }

}

?>
