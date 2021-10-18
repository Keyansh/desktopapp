<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function correct_password($str) {
        $this->load->library('encrypt');

        $this->db->where('user_id', $this->input->post('user_id', true));
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

    function changepassword() {
        $this->load->model('Adminmodel');
        $this->load->library('encrypt');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch user
        $user = $this->member_data;
        if (!$user) {
            redirect('admin/logout/');
            exit();
        }

        //validation check
        $this->form_validation->set_rules('old_passwd', 'Old Password', 'trim|required|callback_correct_password');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required');
        $this->form_validation->set_rules('passwd1', 'Confirm Password', 'trim|required|matches[passwd]');
        $this->form_validation->set_error_delimiters('<li>', '</li>');


        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['user'] = $user;

            $page['content'] = $this->load->view('admin/change-password', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Adminmodel->updatePassword($user);

            $this->session->set_flashdata('SUCCESS', 'admin_updated');

            redirect("/admin/changepassword/");
            exit();
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect("/welcome/");
        exit();
    }

}

?>
