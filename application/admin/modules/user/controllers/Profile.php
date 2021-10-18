<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends Admin_Controller {

    //***********************************Validation start ****************************************
    //Check Username from database
    function chkusername($str){
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
    function index($id) {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('pagination');

        if (!$this->checkAccess('MANAGE_USERS')) {
            show_error('You do not have permission to access this resource!');
        }
        $userData = $this->Usermodel->fetchByID($id);
        if(!$userData){
            show_404();
        }
        $getConfigs = $this->Usermodel->getProfileConfigurationbyId($userData['profile_id']);
        
        $logins = array();
        $address = array();
        $assignedCredits = array();
        if($getConfigs['type']){
            if(isset($getConfigs['configVars']['MULTILOGIN']) && $getConfigs['configVars']['MULTILOGIN']==1){
                $logins = $this->Usermodel->getLogins($userData['user_id']);
            }
            if(isset($getConfigs['configVars']['MULTIDELADDRESS'])&&$getConfigs['configVars']['MULTIDELADDRESS']==1){
                $address = $this->Usermodel->getAddress($userData['user_id']);
            }
            if(isset($getConfigs['configVars']['CREDIT'])&&$getConfigs['configVars']['CREDIT']==1){
                $assignedCredits = $this->Usermodel->getAssginedCredit($userData['user_id']);
            }
        }
        //render view
        $inner = array();
        $inner['user'] = $this->getUser();
        $inner['profileconfig'] = $getConfigs;
        $inner['userprofile'] = $userData;
        $inner['logins'] = $logins;
        $inner['address'] = $address;
        $inner['assginedCredit'] = $assignedCredits;
//        e($inner['assginedCredit']);
        $page = array();
        $page['content'] = $this->load->view('manage-profile', $inner, TRUE);
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
        //$this->form_validation->set_rules('profile_id', 'Profile Group', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required');
        $this->form_validation->set_rules('passwd1', 'confirm Password', 'trim|required|matches[passwd]');
        $this->form_validation->set_rules('companyname','Company Name','trim|required');
        $this->form_validation->set_rules('address','Address','trim|required');
        $this->form_validation->set_rules('city','City','trim|required');
        $this->form_validation->set_rules('county','County','trim|required');
        $this->form_validation->set_rules('postcode','Postcode','trim|required');
        $this->form_validation->set_rules('phone','Phone','trim|required');
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
            if($insertId){
                $this->session->set_flashdata('SUCCESS', 'user_added');
                redirect('user/profile/'.$insertId);
                exit();
            }
        }
        
    }
    
    function addUser(){
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
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required');
        $this->form_validation->set_rules('passwd1', 'confirm Password', 'trim|required|matches[passwd]');
        $this->form_validation->set_rules('companyname','Company Name','trim|required');
        $this->form_validation->set_rules('address','Address','trim|required');
        $this->form_validation->set_rules('city','City','trim|required');
        $this->form_validation->set_rules('county','County','trim|required');
        $this->form_validation->set_rules('postcode','Postcode','trim|required');
        $this->form_validation->set_rules('phone','Phone','trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        
        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['type'] = 0;
            $data['errors'] = validation_errors();
            echo json_encode($data);
        }else{
            $data = array();
            $data['type'] = 1;
            $data['msg'] = "User successfully created";
            $this->Usermodel->insertRecord();
            echo json_encode($data);            
        }
    }
    
    function checkUserAvail(){
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
        }else{
            echo 1;
        }
        
        
        
    }

    //Edit Users
    function edit($uid = 0) {
        $this->load->model('Usermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');

        if (!$this->checkAccess('EDIT_USER')) {
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
        $this->form_validation->set_rules('resource_id[]', 'Permission', 'trim');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_valid_login_e');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_valid_email_e');
        $this->form_validation->set_rules('passwd', 'Password', 'trim');
        $this->form_validation->set_rules('passwd1', 'confirm Password', 'trim|callback_check_pwd');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //Render View
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
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

        $this->Usermodel->deleteRecord($user);

        $this->session->set_flashdata('SUCCESS', 'user_deleted');

        redirect('user/index/');
        exit();
    }
    
    
    # Function to get User Profile by Id
    function getProfileConfig(){
        $this->load->model('Usermodel');
        $this->Usermodel->getProfileConfiguration();
    }

}

?>
