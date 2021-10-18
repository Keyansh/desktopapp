<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Contact extends Cms_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cms/Pagemodel');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('parser');
        $this->load->helper('form');
        $this->load->helper('text');
    }

    public function valid_phone()
    {
        $value = $this->input->post('phone');
        $stripped = str_replace(' ', '', $value);
        if (!is_numeric($stripped)) {
            $this->form_validation->set_message('valid_phone', 'Please enter valid phone number');
            return false;
        } else {
            return true;
        }
    }

    public function index()
    {
        $homepage = $this->input->post('homepage', true);
        if ($homepage != 1) {
            $status = $this->cmscore->loadPage($this);
            if (!$status) {
                return;
            }
            extract($status);
        }
        //validation check
        $this->form_validation->set_rules('name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        $this->form_validation->set_rules('company', 'Company', 'trim|required');
        $this->form_validation->set_rules('location', 'location', 'trim|required');

        //        $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
        //        $userIp = $this->input->ip_address();
        $secret = DWS_RECAPTCHA_SECRET_KEY;
        $captcha = $this->input->post('g-recaptcha-response');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        $response = json_decode($response);
        if (!$response->success) {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'trim|required');
        }
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {

            $inner = array();
            $inner['address'] = $this->listAll();
            $shell = array();
            $shell['meta_title'] = 'Contact Us';
            $shell['contents'] = $this->load->view('contact-form', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/default", $shell);
        } else {
            $data = array();
            $data['name'] = $this->input->post('name', true);
            $data['email'] = $this->input->post('email', true);
            $data['last_name'] = $this->input->post('last_name', true);
            $data['telnumber'] = $this->input->post('phone', true);
            $data['company'] = $this->input->post('company', true);
            $data['location'] = $this->input->post('location', true);
            $data['contact_by_team'] = $this->input->post('contact_by_team', true);
            $data['join_mail_list'] = $this->input->post('join_mail_list', true);

            $insert_id = $this->db->insert('enquiry', $data);
            if ($insert_id) {
                $emailData = array();
                $emailData['DATE'] = date("jS F, Y");
                $emailData['BASE_URL'] = base_url();
                $emailData['NAME'] = $this->input->post('name', true);
                $emailData['LASTNAME'] = $this->input->post('last_name', true);
                $emailData['EMAIL'] = $this->input->post('email', true);
                $emailData['PHONE'] = $this->input->post('phone', true);
                $emailData['COMPANY'] = $this->input->post('company', true);
                $emailData['LOACTION'] = $this->input->post('location', true);
                $emailData['CONTACT_TEAM'] = $this->input->post('contact_by_team', true);
                $emailData['JOIN_MAIL'] = $this->input->post('join_mail_list', true);
                $emailData['ADDRESS'] = DWS_ADDRESS;
                $emailData['ADMIN_PHONE'] = DWS_TELLNO;
                // $emailContent['EMAIL_CONTENT'] = str_replace(array_keys($emailData), array_values($emailData), $emailTemplate['body_content']);
                $admin_emailBody = $this->parser->parse('contact/emails/contactus', $emailData, true);
                $emailBodyUser = $this->parser->parse('contact/emails/contactus-user', $emailData, true);
                // e($emailBodyUser);
                // to admin
                $config = array();
                $this->email->initialize($this->config->item('EMAIL_CONFIG'));
                $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
                $this->email->reply_to(DWS_EMAIL_REPLY_TO);
                $this->email->to(DWS_EMAIL_ADMIN);
                $this->email->subject('New enquiry received ');
                $this->email->message($admin_emailBody);
                $status1 = $this->email->send();
                // to user===
                $config = array();
                $this->email->initialize($this->config->item('EMAIL_CONFIG'));
                $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
                $this->email->reply_to(DWS_EMAIL_NOREPLY);
                $this->email->to($this->input->post('email'));
                $this->email->subject('Thankyou for Contacting');
                $this->email->message($emailBodyUser);
                $status2 = $this->email->send();

                // $status1 = true;
                // $status2 = true;
                if ($status1 == true && $status2 == true) {
                    // if ($status1 == true) {
                    redirect('/contact-us/success');
                    exit();
                }
            }
            redirect('/contact-us/failed');
            exit();
        }
    }
    public function success()
    {
        $inner = array();
        $shell = array();
        $shell['contents'] = $this->load->view("enquiry-success", $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    public function failed()
    {
        $inner = array();
        $shell = array();
        $shell['contents'] = $this->load->view("enquiry-failed", $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }
    public function listAll()
    {
        $rs = $this->db->where('active', 1)->order_by('sort_order', 'ASC')->get('contactus');
        return $rs->result_array();
    }
}
