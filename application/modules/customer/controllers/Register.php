<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends Cms_Controller {

    function __construct() {
        parent::__construct();
    }

    //Validation Functions Start ****************************************************************


    function email_check($str) {
        $this->db->where('email', $str);
        $query = $this->db->get('user');
        if ($query->num_rows()) {
            $this->form_validation->set_message('email_check', 'Email already in use');
            return false;
        }
        return true;
    }

    function valid_phone_number_or_empty() {
        $value = $this->input->post('phone');
        if (preg_match('/^\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}$/', $value)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('valid_phone_number_or_empty', 'Please enter 10 digits phone number');
            return FALSE;
        }
    }

    function valid_phone() {
        $value = $this->input->post('phone');
        $stripped = str_replace(' ', '', $value);
        if (!is_numeric($stripped)) {
            $this->form_validation->set_message('valid_phone', 'Please enter valid phone number');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function save_email_session() {
        $register_email = $this->input->post('register_email');
        if ($register_email) {
            $this->session->unset_userdata('REGISTER_EMAIL');
            $this->session->set_userdata('REGISTER_EMAIL', $register_email);
        }
        redirect('customer/register');
    }

    //Validation Functions Ends ****************************************************************

    function index() {
        $this->load->model('Customermodel');
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('form');

        $title = array();
        $title[''] = '--Select--';
        $title['mr'] = 'Mr';
        $title['mrs'] = 'Mrs';
        $title['miss'] = 'Miss';

        $this->form_validation->set_rules('first_name', 'first name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required|strtolower|valid_email|callback_email_check');
        $this->form_validation->set_rules('location', 'Location', 'trim|required');
        $this->form_validation->set_rules('company_name', 'company', 'trim|required');
        
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        // $this->form_validation->set_rules('postcode', 'postcode', 'trim|required');

        $secret = DWS_RECAPTCHA_SECRET_KEY ; //'6Lel5PoUAAAAAF32kRlf59p7GqcNj1Iv0WAfpg7S';
        $captcha = $this->input->post('g-recaptcha-response');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        $response = json_decode($response);
        if (!$response->success) {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'trim|required');
        }

        $this->form_validation->set_error_delimiters('<li>', '</li>');
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $shell = array();
            $shell['meta_title'] = 'Register';
            $shell['contents'] = $this->load->view('register', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/default", $shell);
        } else {
            $customer = $this->Customermodel->insertRecord();
            if ($customer) {
                if ($this->session->userdata('REDIR_URL') != "") {
                    $url = $this->session->userdata('REDIR_URL');
                    $this->session->unset_userdata('REDIR_URL');
                    header("location: " . base_url() . "customer/register/success");
                    exit();
                }
                redirect('customer/register/success');
                exit();
            }
            redirect('customer/register/error');
            exit();
        }
    }

    function success() {
        $this->load->model('Customermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('cart');

        //Render View
        $inner = array();
        $shell = array();

        $shell['contents'] = $this->load->view('registration-success', $inner, TRUE);
        $this->load->view("themes/" . THEME . "/templates/product", $shell);
    }

    function error() {
        $this->load->model('Customermodel');
        $this->load->library('form_validation');
        $this->load->model('cms/Pagemodel');
        $this->load->model('cms/Templatemodel');
        $this->load->helper('form');
        $this->load->library('cart');

        //Render View
        $inner = array();
        $this->html->addMeta($this->load->view("meta/register_error.php", $inner, TRUE));

        $shell = array();
        $shell['contents'] = $this->load->view('registration-error', $inner, TRUE);
        $this->load->view("themes/" . THEME . "/templates/subpage", $shell);
    }

}
