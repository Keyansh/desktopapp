<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Newsletter extends Cms_Controller
{

    public function __construct()
    {
        parent::__construct();
        // include APPPATH . 'third_party/mailchimp/Mailchimp.php';
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('parser');
    }

    function email_check($str)
    {
        $this->db->where('email', $str);
        $query = $this->db->get('newsletter');
       
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('email_check', 'Email Already Existing!');
            return false;
        }
        return true;
    }

    public function index()
    {

        $this->form_validation->set_rules('email_newsletter', 'Email', 'callback_email_check');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $response = array();
        if ($this->form_validation->run() == false) {
            $response['content'] = validation_errors();
        } else {
            $data = array();
            $data['email'] = $this->input->post('email_newsletter');
            $submit = $this->db->insert('newsletter', $data);
            //        email to admin
            $emailData = array();
            $emailData['DATE'] = date("jS F, Y");
            $emailData['EMAIL'] = $this->input->post('email', true);
            $emailData['ADDRESS'] = DWS_ADDRESS;
            $emailData['PHONE'] = DWS_TELLNO;
            $emailBody = $this->parser->parse('newsletter/emails/newsletter-subscription', $emailData, true);
            //            e($emailBody);
            $this->email->initialize($this->config->item('EMAIL_CONFIG'));
            $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
            $this->email->reply_to(DWS_EMAIL_REPLY_TO);
            $this->email->to(DWS_EMAIL_ADMIN);
            $this->email->subject('Subscribed');
            $this->email->message($emailBody);

            $status = $this->email->send();


            if ($submit && $status) {
                $response['status'] = true;
            } else {
                $response['status'] = false;
            }
        }
        echo json_encode($response);
    }
}
