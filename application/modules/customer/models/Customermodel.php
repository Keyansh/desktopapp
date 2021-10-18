<?php

class Customermodel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //fetch by ID
    function fetchByID($cid)
    {
        $this->db->select('*');
        $this->db->join('user_address', 'user_address.user_id_fk = user.user_id', 'LEFT');
        $this->db->where('user_id', $cid);
        $rs = $this->db->get('user');
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
    function insertRecord()
    {
        $data = array();
        $data['first_name'] = $this->input->post('first_name', TRUE);
        $data['last_name'] = $this->input->post('last_name', TRUE);
        $data['phone'] = $this->input->post('phone', TRUE);
        $data['email'] = $this->input->post('email', TRUE);
        $data['company_name'] = $this->input->post('company_name', TRUE);
        $data['passwd'] = $this->encrypt->encode($this->input->post('password', TRUE));

        $data['location'] = $this->input->post('location', TRUE);
        $data['role_id'] = 3;
        $data['user_is_active'] = 3;
        $data['frontuser'] = 1;
        $data['user_randon_string'] = md5(time());
        $this->db->insert('user', $data);
        $customer_id = $this->db->insert_id();
        //Send Confirmation email
        //        $emailTemplate = getEmailTemplate('register-thank-you-user');
        //        $emailData = array();
        //        $emailData['DATE'] = date("jS F, Y");
        //        $emailData['{BASE_URL}'] = base_url();
        //        $emailContent['EMAIL_CONTENT'] = str_replace(array_keys($emailData), array_values($emailData), $emailTemplate['body_content']);
        //        $emailBody = $this->parser->parse('customer/emails/new-user-to-admin', $emailContent, TRUE);
        // Send email to admin
        $data['date'] = date("jS F, Y");
        $data['ADDRESS'] = DWS_ADDRESS;
        $data['PHONE'] = DWS_TELLNO;
        $emailBody = $this->parser->parse('customer/emails/new-user-to-admin', $data, TRUE);
        // e($emailBody);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->to(DWS_EMAIL_ADMIN);
        $this->email->subject('New User Registered');
        $this->email->message($emailBody);
        $this->email->send();

        $emailData = array();
        $emailData['date'] = date("jS F, Y");
        $emailData['first_name'] = $this->input->post('first_name', TRUE);
        $emailData['last_name'] = $this->input->post('last_name', TRUE);
        $emailData['email'] = $this->input->post('email', TRUE);
        $emailData['ADDRESS'] = DWS_ADDRESS;
        $emailData['PHONE'] = DWS_TELLNO;
        $emailData['BASE_URL'] = base_url();
        $emailData['DOMAIN_NAME'] = $_SERVER['HTTP_HOST'];
        $emailData['LINK'] = base_url() . "customer/login/create_passwd/{$data['user_randon_string']}";
        $emailBodyuser = $this->parser->parse('customer/emails/customer-approved', $emailData, TRUE);
        // e($emailBody);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->to($emailData['email']);
        $this->email->subject('Account awaiting approval');
        $this->email->message($emailBodyuser);
        $this->email->send();

        $data['customer_id'] = $customer_id;
        return $data;
    }

    function updateCustomerRecord()
    {
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
        if ($this->input->post('passwd') != "") {
            $data['passwd'] = $this->encrypt->encode($this->input->post('passwd', TRUE));
        }
        $data['email'] = $this->input->post('email', TRUE);
        //$data['act_code'] = md5(random_string('unique'));
        $data['registration_time'] = time();
        $data['last_login'] = 0;
        $data['cactive'] = 1;
        $data['country'] = "GBR";

        $this->db->where('customer_id', $this->input->post('customerId', TRUE));
        $this->db->update('customer', $data);
    }

    function insertGuest()
    {
        // e($_POST);

        $email = $this->input->post('email', TRUE);
        $customer = $this->db->select('user_id,email')->from('user')->where('email', $email)->get()->row_array();
        if ($customer) {
            return $customer['user_id'];
        }
        $this->load->helper('string');

        //        $data['title'] = $this->input->post('title', TRUE);
        $data['first_name'] = $this->input->post('fname', TRUE);
        $data['last_name'] = $this->input->post('lname', TRUE);
        $data['passwd'] = $this->encrypt->encode(random_string('alnum', 5));
        $data['email'] = $email;
        //$data['act_code'] = md5(random_string('unique'));
        //        $data['registration_time'] = time();
        //        $data['last_login'] = 0;
        //        $data['cactive'] = 1;
        //        $data['country'] = "GBR";

        $data['profile_id'] = 4;
        $data['user_is_active'] = 1;
        $data['guestuser'] = 1;

        //insert data into database
        $this->db->insert('user', $data);
        $customer_id = $this->db->insert_id();

        $data1['user_id_fk'] = $customer_id;

        $data1['uadd_address_01'] = $this->input->post('address1', TRUE);
        $data1['uadd_address_02'] = $this->input->post('address2', TRUE);
        $data1['uadd_city'] = $this->input->post('city', TRUE);
        $data1['uadd_post_code'] = $this->input->post('postcode', TRUE);
        if ($this->input->post('state')) {
            $data1['uadd_county'] = $this->input->post('state', TRUE);
        }
        $data1['uadd_country'] = $this->input->post('country', TRUE);
        $data1['uadd_phone'] = $this->input->post('phone', TRUE);

        $this->db->insert('user_address', $data1);

        //        $rand = rand(00000, 99999);
        //        $rand = $rand . "" . $customer_id;
        //        $data1['customer_code'] = $rand;
        //        $this->db->where('customer_id', $customer_id);
        //        $this->db->update('customer', $data1);
        return $customer_id;
    }

    function information($id)
    {
        $this->db->select('*');
        $this->db->where("customer.customer_id", $id);
        $this->db->from('customer');
        $this->db->join('customer_category_discount', 'customer_category_discount.customer_id = customer.customer_id');
        //        $this->db->join('customer_product_discount', 'customer_product_discount.customer_id =customer.customer_id','left');
        //        $this->db->join('customer_quantity_discount', 'customer_quantity_discount.customer_id = customer.customer_id','left');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    function parents($id)
    {
        $this->db->select('category_id');
        $this->db->where("product_category.product_id", $id);
        $this->db->from('product_category');

        $rs = $this->db->get();
        return $rs->row_array();
    }

    function parentId($id)
    {
        $this->db->select('parent_id');
        $this->db->where("category.category_id", $id);
        $this->db->from('category');

        $rs = $this->db->get();
        $parentId = $rs->row_array();
        if (!empty($parentId['parent_id'])) {
            foreach ($parentId as $paren) {
                $this->db->select('parent_id');
                $this->db->where("category.category_id", $paren);
                $this->db->from('category');

                $rs = $this->db->get();
                $parentId = $rs->row_array();
            }
            return $parentId['parent_id'];
        } else {
            return $parentId['parent_id'];
        }
    }

    function updateUserRecord()
    {

        //echo '<pre>'; print_r($this->session->all_userdata());exit;
        $customer_id = $this->session->userdata('CUSTOMER_ID');
        if (!empty($customer_id)) {
            $data = array();
            //$data['title'] = $this->input->post('title', TRUE);
            $data['first_name'] = $this->input->post('first_name', TRUE);
            $data['last_name'] = $this->input->post('last_name', TRUE);
            //$data['passwd'] = $this->encrypt->encode(random_string('alnum', 5));
            $data['email'] = $this->input->post('email', TRUE);
            //$data['act_code'] = md5(random_string('unique'));
            //$data['registration_time'] = time();
            //$data['last_login'] = 0;
            //$data['cactive'] = 1;
            //$data['country'] = "GBR";
            //$data['profile_id'] = 4;
            //$data['user_is_active'] = 1;
            //$data['guestuser'] = 1;
            //insert data into database
            // $this->db->insert('user', $data);
            // $customer_id = $this->db->insert_id();
            $this->db->where('user_id', $customer_id);
            if ($this->db->update('user', $data)) {
                $this->db->select('user_id_fk');
                $this->db->from('user_address');
                $this->db->where('user_id_fk', $customer_id);
                $data1 = array();
                $data1['uadd_address_01'] = $this->input->post('address1', TRUE);
                $data1['uadd_address_02'] = $this->input->post('address2', TRUE);
                $data1['uadd_city'] = $this->input->post('city', TRUE);
                $data1['uadd_post_code'] = $this->input->post('zipcode', TRUE);
                $data1['uadd_county'] = $this->input->post('state', TRUE);
                $data1['uadd_country'] = $this->input->post('country', TRUE);
                $data1['uadd_phone'] = $this->input->post('phone', TRUE);
                $query = $this->db->get();
                if ($query->num_rows() > 0) {
                    $this->db->where('user_id_fk', $customer_id);
                    $this->db->update('user_address', $data1);
                } else {
                    $data1['user_id_fk'] = $customer_id;
                    $this->db->insert('user_address', $data1);
                }
            }
        } else {
            return false;
        }
    }

    function updatePassword($user)
    {
        $data = array();
        if ($this->input->post('newpassword')) {
            $data['passwd'] = $this->encrypt->encode($this->input->post('newpassword', TRUE));
        }
        $this->db->where('user_id', $user['user_id']);
        $this->db->update('user', $data);
        return;
    }

    //fetch by token
    function fetchUserByToken($token)
    {
        $this->db->from('user');
        $this->db->where('token', $token);
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }

    //update new password
    function updateNewPassword()
    {

        $data = array();
        $token = $this->input->post('token', TRUE);
        $authid = $this->input->post('authid', TRUE);

        $data['passwd'] = $this->encrypt->encode($this->input->post('password1', TRUE));
        $data['token'] = '';
        $data['expires'] = '';
        //e( $data );
        $this->db->where('user_id', $authid);
        $this->db->where('token', $token);
        $this->db->update('user', $data);
    }

    function details($string)
    {
        $this->db->select('*');
        $this->db->where('user_randon_string', $string);
        $rs = $this->db->get('user');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }
}
