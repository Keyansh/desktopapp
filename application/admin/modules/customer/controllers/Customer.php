<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->library('encrypt');
        $this->load->model('Customermodel');
        $this->load->library('email');
        $this->load->library('parser');
    }

    function index($sortby = 'coupon_title', $direction = 'asc', $offset = false) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('pagination');

        if (!$this->checkAccess('MANAGE_USERS')) {
            show_error('You do not have permission to access this resource!');
        }
        ///Setup pagination
        $perpage = $this->Customermodel->customer_All();
        $config['base_url'] = base_url() . "customer/index/";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->Customermodel->customer_All();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);
        //Users list 
        $users = array();
        $users = $this->Customermodel->All_customer($offset, $perpage);
        //render view
        $inner = array();
        $inner['users'] = $users;
        $inner['user'] = $this->getUser();
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('customer-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function customer_add() {
        $inner = array();
        $page = array();
        $page['content'] = $this->load->view('customer-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //Edit Users
    function edit($uid = 0) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');
        if (!$this->checkAccess('ADD_USER')) {
            show_error('You do not have permission to access this resource!');
        }
        //Fetch user details
        $user = array();
        $user = $this->Customermodel->fetchByID($uid);
        if (!$user) {
            $this->utility->show404();
            return;
        }
        $profileGroups = array();
        $profile_rs = $this->Customermodel->fetchAllProfileGroups();
        $profileGroups["0"] = "-Select-";
        foreach ($profile_rs as $rowArr) {
            $profileGroups[$rowArr['role_id']] = $rowArr['role'];
        }

        $customer_groups = array();
        $customer_rs = $this->Customermodel->customergroups();
        $customer_groups["0"] = "-Select-";
        foreach ($customer_rs as $rowArr) {
            $customer_groups[$rowArr['id']] = $rowArr['group'];
        }
        //Render View
        $inner = array();
        $page = array();
        $inner['profilegroups'] = $profileGroups;
        $inner['customer_groups'] = $customer_groups;
        $inner['user'] = $user;
        $page['content'] = $this->load->view('customer-edit', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function pending($keywords = 0, $offset = 0) {
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Get Search Criteria
        if ($this->input->post('search')) {
            $keywords = $this->input->post('search', TRUE);
        }

        //Setup Pagination
        $perpage = 25;
        $config['base_url'] = base_url() . "customer/pending/$keywords";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Customermodel->countPendingAll($keywords);
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //Fecth All Customers
        $customers = array();
        $customers = $this->Customermodel->listPendingAll($keywords, $offset, $perpage);
        //print_r ($products); exit();
        //Check For Missing Search Criteria
        if ($keywords == '0' || trim($keywords) == '') {
            $keywords = '';
        }

        //render view
        $inner = array();
        $inner['customers'] = $customers;
        $inner['keywords'] = $keywords;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('customer-pending', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //Function Edit Customer
    function approve($cid) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('pricing/Pricingplanmodel');
        $this->load->helper('string');

        //Fetch Customer Detail
        $customer = array();
        $customer = $this->Customermodel->detail($cid);
        //print_r($customer); exit();
        if (!$customer) {
            $this->utility->show404();
            return;
        }
        if ($customer['admin_approved'] == 1) {
            $this->utility->show404();
            return;
        }

        //fetch Pricing Plans
        $pricing_plans = array();
        $pricing_plans[''] = 'Select';
        $rs = $this->Pricingplanmodel->listAll();
        //print_r($attributes); exit();
        foreach ($rs as $row) {
            $pricing_plans[$row['pricing_plan_id']] = $row['pricing_plan'];
        }

        //validation check
        $this->form_validation->set_rules('pricing_plan_id', 'Price Plan', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['customer'] = $customer;
            $inner['pricing_plans'] = $pricing_plans;

            $page = array();
            $page['content'] = $this->load->view('pending-customer-details', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Customermodel->ApproveRecord($customer);

            $this->session->set_flashdata('SUCCESS', 'customer_approved');

            redirect("/customer/pending/");
            exit();
        }
    }

    function delete($uid) {
        $this->load->helper('string');
        //Fetch user details
        $user = array();
        $user = $this->Customermodel->fetchByID($uid);
        if (!$user) {
            $this->utility->show404();
            return;
        }
        if ($user['role_id'] == 1) {
            $this->session->set_flashdata('ERROR', 'user_cnonot_deleted');
            redirect('/customer/index/', 'location');
            exit();
        }
        $this->Customermodel->deleteRecord($user['user_id']);
        $this->session->set_flashdata('SUCCESS', 'customer_deleted');
        redirect('customer/index/');
        exit();
    }

    function insert() {
        parse_str($this->input->post('data'), $data);
//        insert in user table
        $user_table = array();
        $user_table['first_name'] = $data['first_name'];
        $user_table['last_name'] = $data['last_name'];
        $user_table['phone'] = $data['customer_phone'][0];
        $user_table['email'] = $data['customer_email'];
        $user_table['user_is_active'] = 1;
        $user_table['company_name'] = $data['company_name'];
        $user_table['role_id'] = $data['type_of_customer'];
        $user_table['city'] = $data['customer_city'];
        $user_table['postcode'] = $data['customer_postcode'];
        $user_table['profile_id'] = NULL;
        $user_table['min_spent'] = $data['min_spent'];
        $user_table['user_randon_string'] = md5(time());
        $user_insert = $this->db->insert('user', $user_table);
        $insertId = $this->db->insert_id();
//        insert in customer table
        $company_table = array();
        $company_table['user_id'] = $insertId;
        $company_table['company_address'] = $data['company_address'];
        $company_table['company_city'] = $data['company_city'];
        $company_table['company_postcode'] = $data['company_postcode'];
        $company_table['company_phone'] = $data['customer_phone'][1];
        $company_table['company_vat'] = $data['company_vat'];
        $company_table['company_email'] = $data['company_email'];
        $company_table['cash_credit'] = $data['cash_credit'];
        $company_table['catalauge'] = $data['catalauge'];
        $customer_inserted = $this->db->insert('customer', $company_table);
//        insert category price list
        if ($data['checkbox']) {
            foreach ($data['checkbox'] as $each) {
                if (isset($each['checked'])) {
                    $category_price_list = array();
                    $category_price_list['user_id'] = $insertId;
                    $category_price_list['cat_id'] = $each['checked'];
                    $category_price_list['category_discount'] = $each['amount'];
                    $this->db->insert('category_price_list', $category_price_list);
                }
            }
        }
//        send email code
        $emailData = array();
        $emailData['ADDRESS'] = DWS_ADDRESS;
        $emailData['ADMIN_PHONE'] = DWS_TELLNO;
        $emailData['BASE_URL'] = base_url();
        $emailData['DATE'] = date("jS F, Y");
        $emailData['EMAIL'] = $data['customer_email'];
        $emailData['DOMAIN_NAME'] = $_SERVER['HTTP_HOST'];
        $emailData['NAME'] = $data['first_name'] . ' ' . $data['last_name'];
        $emailData['LINK'] = substr(base_url(), 0, -6) . "customer/login/create_passwd/{$user_table['user_randon_string']}";
        $emailBody = $this->parser->parse('emails/customer-approved', $emailData, TRUE);
//        e($emailBody);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->reply_to(DWS_EMAIL_REPLY_TO);
        $this->email->to($data['customer_email']);
        $this->email->subject('Create your password');
        $this->email->message($emailBody);
        $status = $this->email->send();
//        send email code end
        $response = array();
        if ($user_insert && $status) {
            $response['status'] = TRUE;
            $response['message'] = 'Uata inserted successfully';
        } else {
            $response['status'] = FALSE;
            $response['message'] = 'Failed to insert data';
        }
        echo json_encode($response);
    }

    function update() {
        // e($_POST);
        parse_str($this->input->post('update_data'), $update_data);
        if ($update_data['customer_group']) {
            $session['GROUP_ID'] = $update_data['customer_group'];
            $this->session->set_userdata($session);
        }
        //        user table
// e($update_data);
        $table_user = array();
        $table_user['email'] = $update_data['email'];
        $table_user['first_name'] = $update_data['firstname'];
        $table_user['company_name'] = $update_data['company_name'];
        $table_user['last_name'] = $update_data['lastname'];
        $table_user['location'] = $update_data['location'];
        $table_user['role_id'] = $update_data['role_id'];
        $table_user['phone'] = $update_data['phone'];
        $table_user['city'] = $update_data['customer_city'];
        $table_user['postcode'] = $update_data['customer_postcode'];
        $table_user['user_is_active'] = $update_data['user_is_active'];
        $table_user['min_spent'] = $update_data['min_spent'];
        $table_user['customer_group'] = $update_data['customer_group'];
        $table_user['profile_type'] = $update_data['profile_type'];
        $this->db->where('user_id', $update_data['user_id']);

        $customer_updated = $this->db->update('user', $table_user);
        //        customer table
        $exist_customer_table = exist_customer_table($update_data['user_id']);
        if ($exist_customer_table) {
            $company_table = array();
            $company_table['company_address'] = $update_data['company_address'];
            $company_table['company_phone'] = $update_data['company_phone'];
            $company_table['company_postcode'] = $update_data['company_postcode'];
            $company_table['company_email'] = $update_data['company_email'];
            $company_table['company_city'] = $update_data['company_city'];
            $company_table['company_vat'] = $update_data['company_vat'];
            $company_table['cash_credit'] = $update_data['cash_credit'];
            $this->db->where('user_id', $update_data['user_id']);
            $company_updated = $this->db->update('customer', $company_table);
        } else {
            $company_table = array();
            $company_table['company_address'] = $update_data['company_address'];
            $company_table['company_phone'] = $update_data['company_phone'];
            $company_table['company_postcode'] = $update_data['company_postcode'];
            $company_table['company_email'] = $update_data['company_email'];
            $company_table['company_city'] = $update_data['company_city'];
            $company_table['company_vat'] = $update_data['company_vat'];
            $company_table['cash_credit'] = $update_data['cash_credit'];
            $company_table['user_id'] = $update_data['user_id'];
            $company_updated = $this->db->insert('customer', $company_table);
        }
//        price list table
        $this->db->where('user_id', $update_data['user_id']);
        $this->db->delete('category_price_list');
        $checkbox = $update_data['checkbox'];
        if ($checkbox) {
            foreach ($checkbox as $each) {
                if (isset($each['checked'])) {
                    $category_price_list = array();
                    $category_price_list['user_id'] = $update_data['user_id'];
                    $category_price_list['cat_id'] = $each['checked'];
                    $category_price_list['category_discount'] = $each['amount'];
                    $this->db->insert('category_price_list', $category_price_list);
                }
            }
        }
        $is_passwd_exists = is_passwd_exists($update_data['user_id']);
        // if ($update_data['user_is_active'] == 1 && !$is_passwd_exists['passwd']) {
        if ($update_data['user_flag'] != 1) {
            if ($update_data['user_is_active'] == 1) {
                $emailData = array();
                $emailData['ADDRESS'] = DWS_ADDRESS;
                $emailData['ADMIN_PHONE'] = DWS_TELLNO;
                $emailData['BASE_URL'] = base_url();
                $emailData['DATE'] = date("jS F, Y");
                $emailData['EMAIL'] = $update_data['email'];
                $emailData['DOMAIN_NAME'] = $_SERVER['HTTP_HOST'];
                $emailData['NAME'] = $update_data['firstname'] . ' ' . $update_data['lastname'];
                $emailData['LINK'] = substr(base_url(), 0, -6) . "customer/login/create_passwd/{$update_data['user_randon_string']}";
                $emailBody = $this->parser->parse('emails/customer-approved', $emailData, TRUE);
            //    e($emailBody);
                $this->email->initialize($this->config->item('EMAIL_CONFIG'));
                $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
                $this->email->reply_to(DWS_EMAIL_REPLY_TO);
                $this->email->to($update_data['email']);
                $this->email->subject('Account approved successfully');
                $this->email->message($emailBody);
                $this->email->send();
    //            echo $this->email->print_debugger();
    //            exit;
            }
        }
        $response = array();
        if ($customer_updated) {
            $response['status'] = TRUE;
            $response['message'] = 'Uata updated successfully';
        } else {
            $response['status'] = FALSE;
            $response['message'] = 'Failed to update data';
        }
        echo json_encode($response);
    }

    function get_user_emails() {
        $email = $this->input->post('email');
        $user_emails = $this->db->select('email')
                        ->from('user')
                        ->where('email', $email)
                        ->get()->row_array();
        $response = array();
        if ($user_emails) {
            $response['result'] = TRUE;
            $response['message'] = 'Email was already exists';
            $response['email'] = $user_emails['email'];
        } else {
            $response['result'] = FALSE;
            $response['message'] = 'Email is new';
            $response['email'] = '';
        }
        echo json_encode($response);
    }

}
