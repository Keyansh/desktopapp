<?php

/* This file created for UserProfile Group
 * Created by @Rav
 * Date: 31 Jan 2017
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userprofile extends Admin_Controller {
    # Validation for Profile Name

    function valid_profilename($str) {
        $this->db->where('profile_name', $str);
        $query = $this->db->get('profilegroup');
        if ($query->num_rows() == 1) {
            $this->form_validation->set_message('valid_profilename', 'Profile Group is already being used!');
            return false;
        }

        return true;
    }

    function e_valid_profilename($str) {
        $this->db->where('profile_name', $str);
        $this->db->where("id !=", $this->input->post('id', true));
        $query = $this->db->get('profilegroup');
        if ($query->num_rows() == 1) {
            $this->form_validation->set_message('e_valid_profilename', 'Profile Group is already being used!');
            return false;
        }

        return true;
    }

    # function index

    function index($offset = false) {
        $this->load->model('Userprofilemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('pagination');

        if (!$this->checkAccess('MANAGE_USERS')) {
            show_error('You do not have permission to access this resource!');
        }

        ///Setup pagination
        $perpage = 20;
        $config['base_url'] = base_url() . "userprofile/index/";
        $config['uri_segment'] = 3;
        $config['total_rows'] = $this->Userprofilemodel->countAll();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //UserProfile list
        $userProfile = array();
        $userProfile = $this->Userprofilemodel->listAll($offset, $perpage);
//        e($userProfile);

        //render view
        $inner = array();
        $inner['userprofile'] = $userProfile;
        $inner['user'] = $this->getUser();
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('userprofile-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //Profile Config
    function profileconfig($id) {
        $this->load->model('Userprofilemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');

        //validation check
        // Posted array

        $this->form_validation->set_rules('configprofile[WEBSHOPPING]', 'WEBSHOPPING', 'required|trim');
        $this->form_validation->set_rules('configprofile[ADMINSHOPPING]', 'ADMINSHOPPING', 'required|trim');
        $this->form_validation->set_rules('configprofile[CREDIT]', 'CREDIT', 'required|trim');
        $this->form_validation->set_rules('configprofile[MULTILOGIN]', 'MULTILOGIN', 'required|trim');
        $this->form_validation->set_rules('configprofile[MULTIDELADDRESS]', 'MULTIDELADDRESS', 'required|trim');
        $this->form_validation->set_rules('configprofile[TIERPRICING]', 'TIERPRICING', 'required|trim');
        $this->form_validation->set_rules('profile_id', 'Profile Id', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        
        
        //Fetch ConfigGroup Data details
        $profileGroup = array();
        $profileGroup = $this->Userprofilemodel->fetchProfileGroupByID($id);
        
        //Render View
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['profileid'] = $id;
            $inner['data'] = $profileGroup;
            $page = array();
            $page['content'] = $this->load->view('config-group', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Userprofilemodel->insertProfileConfig();
            $this->session->set_flashdata('SUCCESS', 'profilegroup_added');
            redirect('user/userprofile/index/');
            exit();
        }
    }

    //function add
    function add() {
        $this->load->model('Userprofilemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');

        if (!$this->checkAccess('ADD_USER')) {
            show_error('You do not have permission to access this resource!');
        }

        //validation check
        $this->form_validation->set_rules('profilename', 'Profile Name', 'trim|required|callback_valid_profilename');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //Render View
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('add-group', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Userprofilemodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'profilegroup_added');
            redirect('user/userprofile/index/');
            exit();
        }
    }

    //Edit Users
    function edit($id = 0) {
        $this->load->model('Userprofilemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('encrypt');

        if (!$this->checkAccess('EDIT_USER')) {
            show_error('You do not have permission to access this resource!');
        }

        //Fetch user details
        $profileGroup = array();
        $profileGroup = $this->Userprofilemodel->fetchByID($id);
        if (!$profileGroup) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('profilename', 'Profile Name', 'trim|required|callback_e_valid_profilename');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //Render View
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['group'] = $profileGroup;
            $page = array();
            $page['content'] = $this->load->view('edit-group', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Userprofilemodel->updateRecord($profileGroup);
            $this->session->set_flashdata('SUCCESS', 'profilegroup_updated');
            redirect('user/userprofile/index/');
            exit();
        }
    }

    //Delete users
    function delete($id) {
        $this->load->model('Userprofilemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('string');

        //Fetch ProfileGroup details
        $profileGroup = array();
        $profileGroup = $this->Userprofilemodel->fetchByID($id);
        if (!$profileGroup) {
            $this->utility->show404();
            return;
        }

        $this->Userprofilemodel->deleteRecord($id);
        $this->session->set_flashdata('SUCCESS', 'profilegroup_deleted');
        redirect('user/userprofile/index/');
        exit();
    }

}

?>