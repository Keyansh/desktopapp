<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userauth {

    private $CI;
    private $member_data;
    private $user_permissions = array();
    private $login_flag = FALSE;

    function __construct() {
        $this->CI = & get_instance();
        log_message('debug', "Userauth Class Initialized");

        $this->login_flag = $this->validSession();
    }

    /* private function validSession() {
      $userid = $this->CI->session->userdata('USER_ID');
      if (isset($userid) && (trim($userid) != '') && is_numeric($userid)) {
      $this->CI->load->model('user/Usermodel');
      $user = $this->CI->Usermodel->fetchByID($userid);
      if ($user) {
      $this->member_data = $user;
      return TRUE;
      }
      $this->CI->session->sess_destroy();
      }

      return FALSE;
      } */

    private function validSession() {
        $userid = $this->CI->session->userdata('USER_ID');
        //echo $userid;
        if (isset($userid) && (trim($userid) != '') && is_numeric($userid)) {
            $this->CI->load->model('user/Usermodel');
            $user = $this->CI->Usermodel->fetchByID($userid);
            if ($user) {
                $this->member_data = $user;
                //Get permissions for this user
                $this->CI->db->where('role_id', $user['role_id']);
                $rs = $this->CI->db->get('permission');
                foreach ($rs->result_array() as $row) {
                    $this->user_permissions[] = $row['protected_resource_id'];
                }

                return TRUE;
            }
            $this->CI->session->sess_destroy();
        }

        return FALSE;
    }

    function checkAuth() {
        if ($this->login_flag)
            return $this->member_data;

        return false;
    }

    public function checkResourceAccess($resource_id) {
        if (!$this->checkAuth())
            return FALSE;

        if ($this->member_data['superuser'] == 1)
            return true;

        if (in_array($resource_id, $this->user_permissions))
            return TRUE;

        return FALSE;
    }

}

?>