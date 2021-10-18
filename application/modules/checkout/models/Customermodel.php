<?php

class Customermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

//fetch by ID
    function fetchByID($cid) {

        $this->db->where('customer_id', $cid);
        $rs = $this->db->get('customer');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }
    function getCountries()
    {
        return $this->db->get('country')->result_array();

    }
    //Insert customer
    function insertRecord() {
        $data = array();

        $data['title'] = $this->input->post('title', TRUE);
        $data['first_name'] = $this->input->post('first_name', TRUE);
        $data['last_name'] = $this->input->post('last_name', TRUE);
        $data['address1'] = $this->input->post('address1', TRUE);
        $data['address2'] = $this->input->post('address2', TRUE);
        $data['city'] = $this->input->post('city', TRUE);
        $data['zipcode'] = $this->input->post('zipcode', TRUE);
        $data['state'] = $this->input->post('state', TRUE);
        $data['phone'] = $this->input->post('phone', TRUE);
        $data['passwd'] = $this->encrypt->encode($this->input->post('passwd', TRUE));
        $data['email'] = $this->input->post('email', TRUE);
        //$data['act_code'] = md5(random_string('unique'));
        $data['registration_time'] = time();
        $data['last_login'] = 0;
        $data['cactive'] = 1;
        $data['country'] = $this->input->post('country', TRUE);

        //insert data into database
        $this->db->insert('customer', $data);

        $customer_id = $this->db->insert_id();

        $rand = rand(00000,99999);
        $rand = $rand."".$customer_id;
        $data1['customer_code'] = $rand;
        $this->db->where('customer_id',$customer_id);
        $this->db->update('customer',$data1);
        $this->db->last_query();


        //echo $customer_id; exit();
        //Send Confirmation email
        $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
        $emailData['EMAIL'] = $data['email'];
        $emailData['NAME'] = $data['first_name'] . ' ' . $data['last_name'];
        $emailData['PASSWORD'] = $this->input->post('passwd', TRUE);
        $emailBody = $this->parser->parse('customer/emails/account-created', $emailData, TRUE);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->to($data['email']);
        $this->email->subject('Account Activated at Regent');
        $this->email->message($emailBody);
        $this->email->send();

        $data['customer_id'] = $customer_id;
        return $data;
    }

}

?>
