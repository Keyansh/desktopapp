<?php

class Userprofilemodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //Count All Records
    function countAll() {
        $this->db->from('profilegroup');
        return $this->db->count_all_results();
    }

    //List All Records
    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $this->db->where("role_id !=", 1);
        $this->db->order_by('role_id', 'ASC');
        $rs = $this->db->get('role');
        return $rs->result_array();
    }

    //List All Records
    function fetchAllRole() {
        $rs = $this->db->get('role');
        return $rs->result_array();
    }

    //Get User Detial
    function fetchByID($id) {
        $this->db->where('id', intval($id));
        $rs = $this->db->get('profilegroup');
        if ($rs && $rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    //get Group values
    function fetchProfileGroupByID($id) {
        $this->db->select('profileconfig_ref,profileconfig_value');
        $this->db->where('profile_id', $id);
        $rs = $this->db->get('profilegroup_config');
        $data = $rs->result_array();

        $dataArr = array();
        foreach ($data as $key => $val) {
            $dataArr[$val['profileconfig_ref']] = $val['profileconfig_value'];
        }
        return $dataArr;
    }

    //Get User Detial
    function fetchByUsername($uid) {
        $this->db->where('username', intval($uid));
        $this->db->where('user_is_active', 1);
        $rs = $this->db->get('user');
        if ($rs && $rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    //Add Insert UserProfile
    function insertRecord() {
        $data = array();
        $data['profile_name'] = $this->input->post('profilename', true);
        $data['is_active'] = strtolower($this->input->post('is_active', true));
        $this->db->insert('profilegroup', $data);
        return;
    }

    //Add Profile Configs
    function insertProfileConfig() {
        $data = array();
        $configdata = $this->input->post('configprofile');
        $profile_id = $this->input->post('profile_id');
        foreach ($configdata as $key => $val) {
            $this->db->where("profileconfig_ref", $key);
            $this->db->where('profile_id', $profile_id);
            $rs = $this->db->get('profilegroup_config');
            if ($rs->num_rows() > 0) {
                $data['profileconfig_value'] = $val;
                $this->db->where('profile_id', $profile_id);
                $this->db->where('profileconfig_ref', $key);
                $this->db->update('profilegroup_config', $data);
            } else {
                $data['profile_id'] = $profile_id;
                $data['profileconfig_ref'] = $key;
                $data['profileconfig_value'] = $val;
                $data['created_at'] = date('Y-m-d h:i:s');
                $this->db->insert('profilegroup_config', $data);
            }
        }
        return;
    }

    //Update User
    function updateRecord($profilegroup) {
        $data = array();

        $data['profile_name'] = $this->input->post('profilename', true);
        $data['is_active'] = $this->input->post('is_active', true);
        $this->db->where('id', $profilegroup['id']);
        $this->db->update('profilegroup', $data);
        //e($this->db->last_query());
    }

    //Update User
    function updateRole($user) {
        $data = array();

        $data['username'] = $this->input->post('username', true);
        $data['email'] = strtolower($this->input->post('email', true));
        if ($this->input->post('passwd', true)) {
            $data['passwd'] = $this->encrypt->encode($this->input->post('passwd', true));
        }
        $this->db->where('user_id', $user['user_id']);
        $this->db->update('user', $data);

        if ($user['role_id'] == 1)
            return;

        //Delete the previous permission of user
        $this->db->where('user_id', $user['user_id']);
        $this->db->delete('permission');

        //Add user permission
        if ($this->input->post('resource_id', true)) {
            foreach ($this->input->post('resource_id', true) as $item) {
                $resource = array();
                $resource['role_id'] = $user['role_id'];
                $resource['user_id'] = $user['user_id'];
                $resource['protected_resource_id'] = $item;
                $this->db->insert('permission', $resource);
            }
        }
    }

    //Delete User
    function deleteRecord($id) {
        $this->db->where('id', $id);
        $this->db->delete('profilegroup');
    }

    //Get Current Permission
    function getPermission($uid) {
        $this->db->select('*');
        $this->db->from('permission');
        $this->db->join('user', 'user.user_id = permission.user_id');
        $this->db->where('permission.user_id', intval($uid));
        $query = $this->db->get();
        if ($query->num_rows() > 0)
            return $query->result_array();

        return FALSE;
    }

    //List Permission
    function listResources() {
        $rs = $this->db->get('protected_resource');
        return $rs->result_array();
    }

    function issuePassword($username) {

        //get customer detail on email
        $user = array();
        $user = $this->fetchByUsername($username);

        $passwd = $this->encrypt->decode($user['passwd']);

        //Email to Password Member
        $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
        $emailData['BASE_URL'] = base_url();
        $emailData['USERNAME'] = $user['username'];
        $emailData['PASSWORD'] = $passwd;

        $emailBody = $this->parser->parse('user/emails/lostpasswd', $emailData, TRUE);
        //print_r($emailBody); exit();

        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->to($user['email']);
        $this->email->subject('Password Recovery');
        $this->email->message($emailBody);
        $this->email->send();
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

}

?>