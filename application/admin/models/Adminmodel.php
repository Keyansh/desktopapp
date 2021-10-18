<?php

class Adminmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function fetchByID($aid) {
        $this->db->where('active', 1);
        $rs = $this->db->get('user');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    function fetchByUsername($username) {
        $this->db->where('username', $username);
        $rs = $this->db->get('user');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    function updatePassword($user) {
        $data = array();
        if ($this->input->post('passwd')) {
            $data['passwd'] = $this->encrypt->encode($this->input->post('passwd', TRUE));
        }

        $this->db->where('user_id', $user['user_id']);
        $this->db->update('user', $data);
        return;
    }

    //function issu password
    function issuePassword($username) {

        //get customer detail on email
        $user = array();
        $user = $this->fetchByUsername($username);

        $passwd = $this->encrypt->decode($user['passwd']);
		//print_r($passwd);exit();
        
        //Email to Password Member
        $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
        $emailData['BASE_URL'] = base_url();
        $emailData['USERNAME'] = $user['username'];
        $emailData['PASSWORD'] = $passwd;

        $emailBody = $this->parser->parse('admin/emails/lostpasswd', $emailData, TRUE);
        
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->to($user['email']);
        $this->email->subject('Password Recovery');
        $this->email->message($emailBody);
        $this->email->send();
    }

}

?>