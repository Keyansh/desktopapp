<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ForgotPass extends Cms_Controller {

    const TOKEN_SIZE = 50;
    const REMEMBER_ME = 1;
    const FORGOT_PASSWORD = 2;
    const VERIFICATION_EMAIL = 3;
    const CUSTOMER_ACTIVATION = 4;

    function __construct() {
        parent::__construct();
    }

    function send_password_email($str) {
        $this->load->library('encrypt');

        $this->db->where('email', $this->input->post('email', TRUE));
        $this->db->where('user_is_active', 1);
        $query = $this->db->get('user');

        if ($query->num_rows() == 1) {
            return true;
        }

        $this->form_validation->set_message('send_password_email', 'Email does not exist.');
        return false;
    }

    function index() {
        $this->load->model('Customermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('text');
        $this->load->library('email');
        $this->load->library('parser');

        //Get Page Details
        //validation check

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_send_password_email');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();

            $shell = array();
            $shell['contents'] = $this->load->view('forgot-form', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/default", $shell);
        } else {
            $this->db->where('email', $this->input->post('email', true));
            $rs = $this->db->get('user');
            if ($rs->num_rows() == 1) {
                $row = $rs->row_array();

                // $expData = [];

                // $type = self::FORGOT_PASSWORD;
                // $expData['expires'] = self::get_expires($type);
                // $expData['token'] = self::generate_token();
                $expData = [];
                $expData['user_randon_string'] = md5(time());
                $this->db->where('user_id', $row['user_id']);
                $this->db->update('user', $expData);

                $emailTemplate = getEmailTemplate('forgot-password-user');

                $emailData = array(); 
                $emailData['DATE'] = date("jS F, Y");
                $emailData['BASE_URL'] = base_url();
                $emailData['NAME'] = $row['first_name'] . ' ' . $row['last_name'];
                $emailData['EMAIL'] = $row['email'];
                $emailData['ADDRESS'] = DWS_ADDRESS;
                $emailData['PHONE'] = DWS_TELLNO;
                $linktosend = base_url() . 'customer/forgotpass/updatepassword/' . $expData['user_randon_string'];
                $linkHtml = '<a href="' . $linktosend . '" target="_blank">Click here to change password</a>';
                $emailData['FORGOT_LINK'] = $linkHtml;

//                $emailData['{PASSWORD}'] = $this->encrypt->decode($row['passwd']);

               $emailBody = $this->parser->parse('customer/emails/forgot-pass', $emailData, TRUE);
                // $emailContent['EMAIL_CONTENT'] = str_replace(array_keys($emailData), array_values($emailData), $emailTemplate['body_content']);
                
                // $emailBody = $this->parser->parse('customer/emails/forgot-pass', $emailContent, TRUE);

                $config = array();
                $this->email->initialize($this->config->item('EMAIL_CONFIG'));
                $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
                $this->email->to($row['email']);
                $this->email->subject('Change Password');
                $this->email->message($emailBody);
                $status = $this->email->send();

                //   echo $status;
                //   exit;

                if ($status == TRUE) {
                    redirect("customer/forgotpass/success");
                    exit();
                }
                redirect("customer/forgotpass/error");
                exit();
            }
            redirect("/customer/forgotpass/");
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

        $shell['contents'] = $this->load->view('forgot-pass-success', $inner, TRUE);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
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
        //$this->html->addMeta($this->load->view("meta/register_error.php", $inner, TRUE));

        $shell = array();
        $shell['contents'] = $this->load->view('forgot-pass-error', $inner, TRUE);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    function updatepassword($token) {
        $this->load->model('Customermodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('text');
        $this->load->library('email');
        $this->load->library('parser');
        $this->load->library('encrypt');

        $user = $this->db->get_where('user',array('user_randon_string' => $token, 'user_is_active' => 1))->row_array();

        if (!$user) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['user'] = $user;

            $shell['contents'] = $this->load->view('forgot-password-tpl', $inner, TRUE);
            $this->load->view("themes/" . THEME . "/templates/default", $shell);
        } else {

            $pass = $this->input->post('password', TRUE);
            $data = ['passwd' => $this->encrypt->encode($pass), 'user_randon_string' => ''];
            $this->db->where('user_id', $user['user_id']);
            $this->db->update('user', $data);
            $this->session->set_flashdata('SUCCESS', 'password_updated');
            redirect('customer/login', 'LOCATION');
            exit();
        }
    }

    /**
     * generates random secure token of self::TOKEN_SIZE size.
     * @return string generated token
     */
    private function generate_token() {
        $bytes = openssl_random_pseudo_bytes(self::TOKEN_SIZE);
        $hex = bin2hex($bytes);
        return $hex;
    }

    public static function get_expires($type) {
        switch ($type) {
            case self::REMEMBER_ME:
                //see libs/helpers.php for this function's definition
                return date("Y-m-d H:i:s", strtotime("+30 days"));
                break;
            case self::FORGOT_PASSWORD:
                return date("Y-m-d H:i:s", strtotime("+1 hours"));
                break;
            case self::VERIFICATION_EMAIL:
                return date("Y-m-d H:i:s", strtotime("+2 years"));
                break;
            case self::CUSTOMER_ACTIVATION:
                return date("Y-m-d H:i:s", strtotime("+1 years"));
                break;
            default:
                return false;
                break;
        }
    }

}
