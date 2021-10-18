<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_Controller extends CMS_Controller {

    private $user_permissions = array();
    private $admin_config = array();

    function __construct() {
        parent::__construct();
        self::checkAuth();
    }

    function checkAuth() {
        $admin_id = $this->session->userdata('USER_ID');

        if ($admin_id) {
            $this->load->model('user/Usermodel');
            $user = $this->Usermodel->fetchByID($admin_id);
            if ($user) {
                $this->member_data = $user;
                $this->user_name = $user['username'];
                $this->user_type = 'ADMIN';
                $this->user_profile_id = $user['profile_id'];
                return TRUE;

                //Get permissions for this user
                $this->db->from('permission');
                $this->db->join('protected_resource', 'protected_resource.protected_resource_id = permission.protected_resource_id');
                $this->db->where('role_id', $user['role_id']);
                $rs = $this->db->get();
                foreach ($rs->result_array() as $row) {
                    $this->user_permissions[] = $row['protected_resource'];
                }

                return TRUE;
            }
        }

        redirect('welcome');
        exit();
    }

    public function checkAccess($resource_id) {
        if (!$this->checkAuth())
            return FALSE;

        if ($this->member_data['role_id'] == 1)
            return true;

        return true;

        if (in_array($resource_id, $this->user_permissions))
            return TRUE;

        return FALSE;
    }

    function getConfig($key) {
        if (array_key_exists($key, $this->admin_config))
            return $this->admin_config[$key];

        $this->db->where('config_key', $key);
        $rs = $this->db->get('config');
        if ($rs && $rs->num_rows() == 1) {
            $row = $rs->row_array();
            $this->admin_config[$key] = $row['config_value'];
            return $row['config_value'];
        }

        return false;
    }

}

?>