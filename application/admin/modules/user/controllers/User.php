<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends Admin_Controller {

    //***********************************Validation start ****************************************
    //Check Username from database
    function chkusername($str) {
        $this->db->where('username', strtolower($str));
        $query = $this->db->get('user');
        if ($query->num_rows() == 1) {
            $this->form_validation->set_message('chkusername', 'Username is already being used!');
            return false;
        }

        return true;
    }

    //for registration
    function email_check($str) {
        $this->db->where('email', strtolower($str));
        $query = $this->db->get('user');
        if ($query->num_rows() == 1) {
            $this->form_validation->set_message('email_check', 'Email is already being used!');
            return false;
        }

        return true;
    }

    //for edit
    function valid_email_e($str) {
        $this->db->where('email', $str);
        $this->db->where('user_id !=', $this->input->post('user_id', true));
        $this->db->from('user');
        $rs = $this->db->count_all_results();
        if ($rs != 0) {
            $this->form_validation->set_message('valid_email_e', 'Email is already being used!');
            return false;
        }
        return true;
    }

    //for edit
    function valid_email_ajax_e($str) {
        $this->db->where('email', $str);
        $this->db->where('user_id !=', $this->input->post('subuserid', true));
        $this->db->from('user');
        $rs = $this->db->count_all_results();
        if ($rs != 0) {
            $this->form_validation->set_message('valid_email_e', 'Email is already being used!');
            return false;
        }
        return true;
    }

    //for registration
    function valid_login($str) {
        $this->db->where('username', $str);
        $query = $this->db->get('user');
        if ($query->num_rows() == 1) {
            $this->form_validation->set_message('valid_login', 'Username is already being used!');
            return false;
        }
        return true;
    }

    //for edit
    function valid_login_e($str) {
        $this->db->where('username', $str);
        $this->db->where('user_id !=', $this->input->post('user_id', true));
        $this->db->from('user');
        $rs = $this->db->count_all_results();
        if ($rs != 0) {
            $this->form_validation->set_message('valid_login_e', 'Username is already being used!');
            return false;
        }
        return true;
    }

    //for edit
    function valid_login_ajax_e($str) {
        $this->db->where('username', $str);
        $this->db->where('user_id !=', $this->input->post('subuserid', true));
        $this->db->from('user');
        $rs = $this->db->count_all_results();
        if ($rs != 0) {
            $this->form_validation->set_message('valid_login_e', 'Username is already being used!');
            return false;
        }
        return true;
    }

    //Check Password
    function check_pwd($str) {
        if ($this->input->post('passwd', true) != '' || $str != '') {
            if ($this->input->post('passwd', true) != $str) {
                $this->form_validation->set_message('check_pwd', ' Password and Confirm Password do not match!');
                return false;
            }
        }
        return true;
    }

    //****************************************End Validation****************************************
    //function index
    function index($sortby = 'coupon_title', $direction = 'asc', $offset = false) {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('pagination');

        if (!$this->checkAccess('MANAGE_USERS')) {
            show_error('You do not have permission to access this resource!');
        }

        ///Setup pagination
        $perpage = 20;
        $config['base_url'] = base_url() . "users/index/";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->Usermodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //Users list
        $users = array();
        $users = $this->Usermodel->listAll($offset, $perpage);
//e($users);
        //render view
        $inner = array();
        $inner['users'] = $users;
        $inner['user'] = $this->getUser();
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('user-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add
    function add() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');

        if (!$this->checkAccess('ADD_USER')) {
            show_error('You do not have permission to access this resource!');
        }

        //validation check
        $this->form_validation->set_rules('profile_id', 'Profile Group', 'trim|required');
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
//        $this->form_validation->set_rules('companyname', 'Company Name', 'trim|required');
//        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_chkusername');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required');
        $this->form_validation->set_rules('passwd1', 'confirm Password', 'trim|required|matches[passwd]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('county', 'County', 'trim|required');
        $this->form_validation->set_rules('postcode', 'Postcode', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        # Fetch all Profile Groups
        $profileGroups = array();
        $profile_rs = $this->Usermodel->fetchAllProfileGroups();
        $profileGroups[""] = "-Select-";
        foreach ($profile_rs as $rowArr) {
            $profileGroups[$rowArr['id']] = $rowArr['profile_name'];
        }

        //Render View
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['profilegroups'] = $profileGroups;
            $page = array();
            $page['content'] = $this->load->view('add-user', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $insertId = $this->Usermodel->insertRecord();
            if ($insertId) {
                $this->session->set_flashdata('SUCCESS', 'user_added');
                redirect('user/profile/index/' . $insertId);
                exit();
            }
        }
    }

    #Add SubUser into database

    function addSubUser() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');

        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_chkusername');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required');
        $this->form_validation->set_rules('passwd1', 'Confirm Password', 'trim|required|matches[passwd]');
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required');

        if ($this->form_validation->run($this) == FALSE) {

            $errors = array();
            // Loop through $_POST and get the keys
            foreach ($this->input->post() as $key => $value) {
                // Add the error message for this field
                $errors[$key] = form_error($key);
            }

            //$response = array_filter($errors); // Some might be empty
            $response = $errors;
            $json_arr = array('response' => 'false', 'customerror' => $response, 'msg' => validation_errors());
            echo json_encode($json_arr);
            exit;
        } else {
            $insertId = $this->Usermodel->insertSubRecord();
            $html = "";
            echo json_encode(array('response' => 'true', 'msg' => 'Done', 'html' => $html));
        }
    }

    # Get Add subuser view template

    function addSubUserAjax() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');

        $inner = array();
        $page = array();
        $data = $this->load->view('add-new-user-ajax', $inner, TRUE);

        $resArr = array();
        $resArr['type'] = 'true';
        $resArr['userhtml'] = $data;
        echo json_encode($resArr);
    }

    # Funtion to modify existing user

    function modifySubUser() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');

        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_valid_login_ajax_e');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_valid_email_ajax_e');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required');
        $this->form_validation->set_rules('passwd1', 'Confirm Password', 'trim|required|matches[passwd]');
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required');

        if ($this->form_validation->run($this) == FALSE) {

            $errors = array();
            // Loop through $_POST and get the keys
            foreach ($this->input->post() as $key => $value) {
                // Add the error message for this field
                $errors[$key] = form_error($key);
            }

            //$response = array_filter($errors); // Some might be empty
            $response = $errors;
            $json_arr = array('response' => 'false', 'customerror' => $response, 'msg' => validation_errors());
            echo json_encode($json_arr);
            exit;
        } else {
            $insertId = $this->Usermodel->modifySubRecord();
            $html = "";
            echo json_encode(array('response' => 'true', 'msg' => 'Done', 'html' => $html));
        }
    }

    # Function to get sub user template file

    function editSubUser() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');

        $id = $this->input->post('id', TRUE);
        if (!$id) {
            show_404();
        }
        $rs = $this->Usermodel->fetchByID($id);
        $inner = array();
        $inner['userdata'] = $rs;
        $page = array();
        $data = $this->load->view('edit-user-ajax', $inner, TRUE);

        $resArr = array();
        $resArr['type'] = 'true';
        $resArr['userhtml'] = $data;
        echo json_encode($resArr);
    }

    #function to get view template for add new address

    function addAddressAjax() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');


        $inner = array();
        $page = array();
        $data = $this->load->view('add-new-address-ajax', $inner, TRUE);

        $resArr = array();
        $resArr['type'] = 'true';
        $resArr['userhtml'] = $data;
        echo json_encode($resArr);
    }

    # function to view part for edit ajax

    function getAddressAjax() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');

        $id = $this->input->post('id', TRUE);
        if (!$id) {
            show_404();
        }
        $rs = $this->Usermodel->getAddressbyID($id);
        $inner = array();
        $inner['addressdata'] = $rs;
        $page = array();
        $data = $this->load->view('edit-new-address-ajax', $inner, TRUE);

        $resArr = array();
        $resArr['type'] = 'true';
        $resArr['userhtml'] = $data;
        echo json_encode($resArr);
    }

    # Insert new address to database

    function addUserAddress() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');

        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('county', 'County', 'trim|required');
        $this->form_validation->set_rules('postcode', 'Postcode', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');

        if ($this->form_validation->run($this) == FALSE) {

            $errors = array();
            // Loop through $_POST and get the keys
            foreach ($this->input->post() as $key => $value) {
                // Add the error message for this field
                $errors[$key] = form_error($key);
            }

            //$response = array_filter($errors); // Some might be empty
            $response = $errors;
            $json_arr = array('response' => 'false', 'customerror' => $response, 'msg' => validation_errors());
            echo json_encode($json_arr);
            exit;
        } else {
            $insertId = $this->Usermodel->insertAddressRecord();
            $html = "";
            echo json_encode(array('response' => 'true', 'msg' => 'Done', 'html' => $html));
        }
    }

    # Modify user address

    function updateUserAddress() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');

        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('county', 'County', 'trim|required');
        $this->form_validation->set_rules('postcode', 'Postcode', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');

        if ($this->form_validation->run($this) == FALSE) {

            $errors = array();
            // Loop through $_POST and get the keys
            foreach ($this->input->post() as $key => $value) {
                // Add the error message for this field
                $errors[$key] = form_error($key);
            }

            //$response = array_filter($errors); // Some might be empty
            $response = $errors;
            $json_arr = array('response' => 'false', 'customerror' => $response, 'msg' => validation_errors());
            echo json_encode($json_arr);
            exit;
        } else {
            $insertId = $this->Usermodel->updateAddressRecord();
            $html = "";
            echo json_encode(array('response' => 'true', 'msg' => 'Done', 'html' => $html));
        }
    }

    # function to delete sub user

    function delSubUser() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');

        $id = $this->input->post('id', TRUE);
        if (!$id) {
            show_404();
        }

        $this->Usermodel->deleteRecord($id);

        $dataArr = array();
        $dataArr['type'] = 'true';
        $dataArr['msg'] = "User successfully deleted";
        $dataArr['rowid'] = $id;
        echo json_encode($dataArr);
    }

    #function to delete Multiple address

    function delMultiAddress() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');

        $id = $this->input->post('id', TRUE);
        if (!$id) {
            show_404();
        }

        $this->Usermodel->deleteUserAddress($id);

        $dataArr = array();
        $dataArr['type'] = 'true';
        $dataArr['msg'] = "Address successfully deleted";
        $dataArr['rowid'] = $id;
        echo json_encode($dataArr);
    }

    #function to check user availabilty

    function checkUserAvail() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');

        if (!$this->checkAccess('ADD_USER')) {
            show_error('You do not have permission to access this resource!');
        }
        //validation check
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_chkusername');
        if ($this->form_validation->run() == FALSE) {
            echo 0;
        } else {
            echo 1;
        }
    }

    # function to assign credit to user

    function assignCredit() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');

        $this->form_validation->set_rules('creditlimit', 'Credit Limit', 'trim|required');
        $this->form_validation->set_rules('limit_over', 'Over Limit', 'trim|required');
        $this->form_validation->set_rules('daterangepicker-example', 'Datepicker', 'trim|required');

        if ($this->form_validation->run($this) == FALSE) {

            $errors = array();
            // Loop through $_POST and get the keys
            foreach ($this->input->post() as $key => $value) {
                // Add the error message for this field
                $errors[$key] = form_error($key);
            }

            //$response = array_filter($errors); // Some might be empty
            $response = $errors;
            $json_arr = array('response' => 'false', 'customerror' => $response, 'msg' => validation_errors());
            echo json_encode($json_arr);
            exit;
        } else {
            $insertId = $this->Usermodel->assignUserCredit();
            $html = "";
            echo json_encode(array('response' => 'true', 'msg' => 'Credit successfully assigned', 'html' => $html));
        }
    }

    //Edit Users
    function edit($uid = 0) {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');

        if (!$this->checkAccess('ADD_USER')) {
            show_error('You do not have permission to access this resource!');
        }

        //Fetch user details
        $user = array();
        $user = $this->Usermodel->fetchByID($uid);
        if (!$user) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('role_id', 'Role', 'trim|required');
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
//        $this->form_validation->set_rules('companyname', 'Company Name', 'trim|required');
//        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_valid_login_e');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_valid_email_e');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required');
        $this->form_validation->set_rules('passwd1', 'confirm Password', 'trim|required|matches[passwd]');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        # Fetch all Profile Groups
        $profileGroups = array();
        $profile_rs = $this->Usermodel->fetchAllProfileGroups();
        $profileGroups[""] = "-Select-";
        foreach ($profile_rs as $rowArr) {
            $profileGroups[$rowArr['role_id']] = $rowArr['role'];
        }

        //Render View
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['profilegroups'] = $profileGroups;
            $inner['user'] = $user;
            $page = array();
            $page['content'] = $this->load->view('edit-user', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Usermodel->updateRecord($user);
            $this->session->set_flashdata('SUCCESS', 'user_updated');
            redirect('user/index/');
            exit();
        }
    }

    //Delete users
    function delete($uid) {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');

        //Fetch user details
        $user = array();
        $user = $this->Usermodel->fetchByID($uid);
        if (!$user) {
            $this->utility->show404();
            return;
        }
        if ($user['superuser'] == 1) {
            $this->session->set_flashdata('ERROR', 'user_cnonot_deleted');

            redirect('/user/index/', 'location');
            exit();
        }

        $this->Usermodel->deleteRecord($user['user_id']);

        $this->session->set_flashdata('SUCCESS', 'user_deleted');

        redirect('user/index/');
        exit();
    }

    # Function to get User Profile by Id

    function getProfileConfig() {
        $this->load->model('Usermodel');
        $this->Usermodel->getProfileConfiguration();
    }

    # Get User by Profile ID

    function getProfileUser($id) {
        $this->load->model('Usermodel');
        print_r(json_encode($this->Usermodel->fetchProfileUser($id)));
    }

    function userAjax() {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('email');

        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

        $rating = 0;
        $response = array();
        $response['msg'] = "";
        $response['status'] = "";
        $response['html'] = "";
        if ($this->input->post('score')) {
            $rating = $this->input->post('score');
        }

        $profile = $this->input->post('profile_id');
        $username = $this->input->post('username');
        $fname = $this->input->post('firstname');
        $lname = $this->input->post('lastname');
        $cname = $this->input->post('companyname');
        $email = $this->input->post('email');
        $password = $this->input->post('passwd');
        $cpassword = $this->input->post('passwd1');
        $address = $this->input->post('address');
        $address1 = $this->input->post('address2');
        $city = $this->input->post('city');
        $county = $this->input->post('county');
        $country = $this->input->post('country');
        $postcode = $this->input->post('postcode');
        $phone = $this->input->post('phone');

        if (($profile == '')) {
            $response['status'] = 'error';
            $response['msg'] = ' .profileerror ,';
        }
        if (trim($username) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .usernameerror ,';
        } else if (!$this->chkusername($username)) {
            $response['status'] = 'error';
            $response['msg'] .= ' .userexisterror ,';
        }
        if (trim($fname) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .firstnameerror ,';
        }
        if (trim($lname) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .lastnameerror ,';
        }
        if (trim($cname) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .companynameerror ,';
        }
        if (trim($email) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .emailerror ,';
        } else if (!preg_match($regex, $email)) {
            $response['status'] = 'error';
            $response['msg'] .= ' .invalidemailerror ,';
        } else if (!$this->email_check($email)) {
            $response['status'] = 'error';
            $response['msg'] .= ' .emailexisterror ,';
        }
        if (trim($password) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .passwderror ,';
        }
        if (trim($cpassword) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .passwd1error ,';
        } else if (trim($password) != trim($cpassword)) {
            $response['status'] = 'error';
            $response['msg'] .= ' .passwd2error ,';
        }
        if (trim($address) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .addresserror ,';
        }
//        if (trim($address1) == "") {
//            $response['status'] = 'error';
//            $response['msg'] .= ' .address2error ,';
//        }
        if (trim($city) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .cityerror ,';
        }
        if (trim($county) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .countyerror ,';
        }
        if (trim($country) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .countryerror ,';
        }
        if (trim($postcode) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .postcodeerror ,';
        }
        if (trim($phone) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .phoneerror ';
        }


        if ($response['status'] == "error") {
            echo json_encode($response);
            return false;
        }

        $this->Usermodel->insertRecord();
        $response['status'] = 'success';
        $response['html'] = 'Thanks for Rating this Product. Please wait for approval.';
        echo json_encode($response);
    }

}

?>
