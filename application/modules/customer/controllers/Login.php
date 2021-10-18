<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends Cms_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Customermodel');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('parser');
        $this->load->helper('form');
        $this->load->helper('text');
        $this->load->library('encrypt');
    }

    function index()
    {
        if ($this->memberauth->checkAuth()) {
            redirect("customer/dashboard");
            exit();
        }
        $ref = $this->session->userdata('REGENT_REDIR_URL');
        if ($ref) {
            $this->session->set_userdata('REDIR_URL', $ref);
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        //        $this->form_validation->set_rules('passwd', 'Password', 'trim|required|callback_login_check');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['REF'] = '';
            $shell = array();
            //            $inner['REF'] = $ref;
            $shell['meta_title'] = 'Login';
            $shell['contents'] = $this->load->view('login-form', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/default", $shell);
        } else {
            $login_email = $this->input->post('email', true);
            $login_password = $this->input->post('passwd', true);

            $rs = array();
            $rs = $this->db->select('*')
                ->from('user')
                ->where('email', $login_email)
                ->where('guestuser', 0)
                ->where('user_is_active', 1)
                ->get();
            //e($rs->num_rows());
            if ($rs->num_rows() == 1) {
                $r = $rs->first_row('array');
                if ($this->encrypt->decode($r['passwd']) === $login_password) {

                    $customer = $rs->row_array();
                    $session = array();
                    $session['CUSTOMER_ID'] = $customer['user_id'];
                    $session['LOGIN_EMAIL'] = $customer['email'];
                    $session['GROUP_ID'] = $customer['customer_group'];
                    $this->session->set_userdata($session);
                    if ($this->session->userdata('REDIR_URL') == "") {
                        $CUSTOMER_ID = $this->session->userdata('CUSTOMER_ID');
                        $role_id = set_role_id_session($CUSTOMER_ID);
                        $this->session->set_userdata('ROLE_ID', $role_id['role_id']);
                        //                        redirect(base_url());
                        // echo "<script type='text/javascript' src='" . base_url() . 'js/login_redirect.js' . "'></script>";
                        redirect("customer/dashboard");
                        exit();
                    } else {
                        $url = $this->session->userdata('REDIR_URL');
                        $this->session->unset_userdata('REDIR_URL');
                        header("location: $url");
                        exit();
                    }
                }
            }
            $this->session->set_flashdata('loginerror', '<span style="color:red;" >Invalid user email or password !</span>');
            redirect("/customer/login/");
            exit();
        }
    }

    function create_passwd($user_randon_string)
    {
        //  Fetch Customer Detail
        $customer = array();
        $customer = $this->Customermodel->details($user_randon_string);
        if (!$customer) {
            $this->utility->show404();
            return;
        }
        $inner = array();
        $shell = array();
        $inner['user_randon_string'] = $user_randon_string;
        $shell['contents'] = $this->load->view('create-password', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    function save_password()
    {
        $data = array();
        $data['passwd'] = $this->encrypt->encode($this->input->post('password'));
        $this->db->where('user_randon_string', $this->input->post('user_randon_string'));
        $status = $this->db->update('user', $data);
        $response = array();
        if ($status) {
            $response['status'] = TRUE;
        } else {
            $response['status'] = FALSE;
        }
        echo json_encode($response);
    }
}
