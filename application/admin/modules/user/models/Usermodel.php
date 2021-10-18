<?php

class Usermodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //Count All Records
    function countAll() {
        $this->db->where("user_id !=", 1);
        $this->db->where("parent_id", 0);
        $this->db->from('user');
        return $this->db->count_all_results();
    }

    //List All Records
    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $this->db->select('t1.*, t2.role');
        $this->db->from('user t1');
        $this->db->join('role t2', 't2.role_id = t1.role_id', 'LEFT');
        if (curUsrId() != '1') {
            $this->db->where("t1.parent_id", curUsrId());
            $this->db->or_where("t1.user_id", curUsrId());
        } else {
            $this->db->where("t1.parent_id", 0);
            $this->db->where("t1.user_id !=", 1);
        }
        $this->db->order_by('t1.user_id', 'desc');
        $this->db->where('guestuser', 0);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    //List All Records
    function fetchAllRole() {
        $rs = $this->db->get('role');
        return $rs->result_array();
    }

    //List All Profile Records
    function fetchAllProfileGroups() {
//        $this->db->where('is_active', 1);
//        $rs = $this->db->get('profilegroup');
//        return $rs->result_array();
        return $this->db->select('*')
                        ->from('role')
                        ->where("role_id !=", 1)
                        ->get()->result_array();
    }

    // Fetch profile user
    function fetchProfileUser($id) {
        $this->db->select('user.user_id, user.username');
        $this->db->where('user.profile_id', intval($id));
        $this->db->where('user.user_is_active', 1);
        $rs = $this->db->get('user');
        //die($this->db->last_query());
        return $rs->result_array();
    }

    //Get User Detial
    function fetchByID($uid) {
        $this->db->where('user.user_id', intval($uid));
        $this->db->where('user.user_is_active', 1);
        //$this->db->join('user_address','user.user_id = user_address.user_id_fk','LEFT');
        $rs = $this->db->get('user');
        if ($rs && $rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
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

    //Add Insert User
    function insertRecord() {
        $data = array();
        $data['role_id'] = 0;
        $data['profile_id'] = $this->input->post('profile_id', true);
        $data['parent_id'] = 0;
        $data['username'] = $this->input->post('username', true);
        $data['email'] = strtolower($this->input->post('email', true));
        $data['passwd'] = $this->encrypt->encode($this->input->post('passwd', true));
        $data['first_name'] = $this->input->post('firstname', true);
        $data['last_name'] = $this->input->post('lastname', true);
        $data['company_name'] = $this->input->post('companyname', true);
        $data['user_is_active'] = 1;
        $this->db->insert('user', $data);

        $insertId = $this->db->insert_id();

        $dataProfile = array();
        $dataProfile['user_id_fk'] = $insertId;
        $dataProfile['profile_image'] = '';
        $dataProfile['phone'] = $this->input->post('phone', true);
        $this->db->insert('user_profile', $dataProfile);

        $dataAddress = array();
        $dataAddress['user_id_fk'] = $insertId;
        $dataAddress['uadd_recipient'] = $this->input->post('first_name', true) . " " . $this->input->post('lastname', true);
        $dataAddress['uadd_phone'] = $this->input->post('phone', true);
        $dataAddress['uadd_address_01'] = $this->input->post('address', true);
        $dataAddress['uadd_address_02'] = $this->input->post('address2', true);
        $dataAddress['uadd_city'] = $this->input->post('city', true);
        $dataAddress['uadd_county'] = $this->input->post('county', true);
        $dataAddress['uadd_post_code'] = $this->input->post('postcode', true);
        $dataAddress['uadd_country'] = $this->input->post('country', true);
        $this->db->insert('user_address', $dataAddress);
        self::sendAccountRegistratoinEmail($insertId);
        self::sendAccountRegistratoinEmailUser($insertId);
        return $insertId;
    }

    function insertSubRecord() {
        $data = array();
        $data['role_id'] = 0;
        $data['profile_id'] = $this->input->post('profile_id', true);
        $data['parent_id'] = $this->input->post('user_id', true);
        $data['username'] = $this->input->post('username', true);
        $data['email'] = strtolower($this->input->post('email', true));
        $data['passwd'] = $this->encrypt->encode($this->input->post('passwd', true));
        $data['first_name'] = $this->input->post('firstname', true);
        $data['last_name'] = $this->input->post('lastname', true);
        $data['company_name'] = $this->input->post('designation', true);
        $data['user_is_active'] = 1;
        $this->db->insert('user', $data);

        $insertId = $this->db->insert_id();

        $dataProfile = array();
        $dataProfile['user_id_fk'] = $insertId;
        $dataProfile['profile_image'] = '';
        $dataProfile['phone'] = $this->input->post('phone', true);
        $this->db->insert('user_profile', $dataProfile);

        return $insertId;
    }

    function modifySubRecord() {
        $data = array();
        $data['role_id'] = 0;
        $data['profile_id'] = $this->input->post('profile_id', true);
        $data['parent_id'] = $this->input->post('user_id', true);
        $data['username'] = $this->input->post('username', true);
        $data['email'] = strtolower($this->input->post('email', true));
        $data['passwd'] = $this->encrypt->encode($this->input->post('passwd', true));
        $data['first_name'] = $this->input->post('firstname', true);
        $data['last_name'] = $this->input->post('lastname', true);
        $data['company_name'] = $this->input->post('designation', true);
        $data['user_is_active'] = 1;
        $update_id = $this->input->post("subuserid", true);
        $this->db->where("user_id", $update_id);
        $this->db->update('user', $data);
        return $update_id;
    }

    function insertAddressRecord() {
        $dataAddress = array();
        $dataAddress['user_id_fk'] = $this->input->post('user_id', true);
        $dataAddress['uadd_recipient'] = "";
        $dataAddress['uadd_phone'] = $this->input->post('phone', true);
        $dataAddress['uadd_address_01'] = $this->input->post('address', true);
        $dataAddress['uadd_address_02'] = $this->input->post('address2', true);
        $dataAddress['uadd_city'] = $this->input->post('city', true);
        $dataAddress['uadd_county'] = $this->input->post('county', true);
        $dataAddress['uadd_post_code'] = $this->input->post('postcode', true);
        $dataAddress['uadd_country'] = $this->input->post('country', true);
        $this->db->insert('user_address', $dataAddress);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    function updateAddressRecord() {
        $dataAddress = array();
        $dataAddress['user_id_fk'] = $this->input->post('user_id', true);
        $dataAddress['uadd_recipient'] = "";
        $dataAddress['uadd_phone'] = $this->input->post('phone', true);
        $dataAddress['uadd_address_01'] = $this->input->post('address', true);
        $dataAddress['uadd_address_02'] = $this->input->post('address2', true);
        $dataAddress['uadd_city'] = $this->input->post('city', true);
        $dataAddress['uadd_county'] = $this->input->post('county', true);
        $dataAddress['uadd_post_code'] = $this->input->post('postcode', true);
        $dataAddress['uadd_country'] = $this->input->post('country', true);

        $addressId = $this->input->post('address_id', TRUE);
        $this->db->where('user_address_id', $addressId);
        $this->db->update('user_address', $dataAddress);
        return $addressId;
    }

    function sendAccountRegistratoinEmail($userid) {
        //Send Confirmation email
        /*
          $emailData = array();
          $emailData['DATE'] = date("jS F, Y");
          $emailData['USERNAME'] = $data['username'];
          $emailData['EMAIL'] = $data['email'];
          $emailData['PASSWORD'] = $this->input->post('passwd', true);
          $emailData['LINK'] = $this->config->item('root_url');

          $emailBody = $this->parser->parse('user/emails/user-information', $emailData, TRUE);
          $this->email->initialize($this->config->item('EMAIL_CONFIG'));
          $this->email->from(DWS_NOREPLY_EMAIL, DWS_EMAIL_FROM);
          $this->email->to($data['email']);
          $this->email->subject('Account Information');
          $this->email->message($emailBody);
          $this->email->send();
         */
    }

    # Get Profile Configs

    function getProfileConfiguration() {
        $profileId = $this->input->post('profileId', true);
        $rs = $this->db->where('profile_id', $profileId)->get('profilegroup_config')->result_array();
        $respone = array();

        if ($rs > 0) {
            $respone['type'] = 1;
            $configRef = array_column($rs, 'profileconfig_ref');
            $configVal = array_column($rs, 'profileconfig_value');
            $combineArr = array_combine($configRef, $configVal);
            $respone['configVars'] = $combineArr;
            echo json_encode($respone);
        } else {
            $respone['type'] = 0;
            echo json_encode($respone);
        }
    }

    #assign credit

    function assignUserCredit() {
        $dataCreditAssign = array();

        $assignedDate = $this->input->post("daterangepicker-example", true);
        $dateArr = explode(" - ", $assignedDate);
        $startdate = $dateArr[0];
        $enddate = $dateArr[1];
        $dataCreditAssign['user_id_fk'] = $this->input->post('user_id', true);
        $dataCreditAssign['credit_limit'] = $this->input->post('creditlimit', true);
        $dataCreditAssign['order_above_limit'] = $this->input->post('limit_over', true);
        $dataCreditAssign['credit_startdate'] = $startdate;
        $dataCreditAssign['credit_lastdate'] = $enddate;
        $this->db->set('datetime', 'NOW()', FALSE);
        $this->db->insert('user_assign_credit', $dataCreditAssign);
        return $this->db->insert_id();
    }

    #get Assigned Credit

    function getAssginedCredit($id) {

        $this->db->where('user_id_fk', $id);
        $rs = $this->db->get('user_assign_credit');
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }
        return false;
    }

    # Get Profile Configs by Id

    function getProfileConfigurationbyId($id) {
        $rs = $this->db->where('profile_id', $id)->get('profilegroup_config')->result_array();
        $respone = array();

        if ($rs > 0) {
            $respone['type'] = 1;
            $configRef = array_column($rs, 'profileconfig_ref');
            $configVal = array_column($rs, 'profileconfig_value');
            $combineArr = array_combine($configRef, $configVal);
            $respone['configVars'] = $combineArr;
            return $respone;
        } else {
            $respone['type'] = 0;
            return $respone;
        }
    }

    #Get Logins

    function getLogins($id) {
        $this->db->where("parent_id", $id);
        $rs = $this->db->get('user');
        return $rs->result_array();
    }

    #Get Address

    function getAddressbyID($id) {
        $this->db->where("user_address_id", $id);
        $rs = $this->db->get('user_address');
        return $rs->row_array();
    }

    #Get Address

    function getAddress($id) {
        $this->db->where("user_id_fk", $id);
        $rs = $this->db->get('user_address');
        return $rs->result_array();
    }

    //Update User
    function updateRecord($user) {
        $data = array();
        $data['role_id'] = $this->input->post('role_id', true);
        $data['username'] = $this->input->post('username', true);
        $data['email'] = strtolower($this->input->post('email', true));
        $data['passwd'] = $this->encrypt->encode($this->input->post('passwd', true));
        $data['first_name'] = $this->input->post('firstname', true);
        $data['last_name'] = $this->input->post('lastname', true);
        $data['company_name'] = $this->input->post('companyname', true);
        $data['user_is_active'] = 1;

        $this->db->where('user_id', $user['user_id']);
        $this->db->update('user', $data);
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
    function deleteRecord($userid) {
        $this->db->where("user_id", $userid);
        $this->db->where("user_id !=", 1);
        $this->db->delete('user');

        $this->db->where("user_id_fk", $userid);
        $this->db->delete('user_profile');

        $this->db->where("user_id_fk", $userid);
        $this->db->delete('user_address');

        $this->db->where("user_id_fk", $userid);
        $this->db->delete('user_assign_credit');
    }

    //Delete User Address
    function deleteUserAddress($id) {
        $this->db->where("user_address_id", $id);
        $this->db->delete('user_address');
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

    function sendAccountRegistratoinEmailUser($userid) {
        $data = array();
        $data = self::fetchByID($userid);
        //Send Confirmation email

        $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
        $emailData['NAME'] = $data['first_name'] . $data['last_name'];
        $emailData['USERNAME'] = $data['username'];
        $emailData['EMAIL'] = $data['email'];
        $emailData['PASSWORD'] = $this->input->post('passwd', true);

        $emailBody = $this->parser->parse('user/emails/user-information', $emailData, TRUE);
//          ee($emailBody);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_NOREPLY_EMAIL, DWS_EMAIL_FROM);
        $this->email->to($data['email']);
        $this->email->subject('Account Information');
        $this->email->message($emailBody);
        $this->email->send();
    }

    function graphAmtOrders($mode = 'month') {
        $out = [];
        $out['month'] = [];
        $out['order_total'] = [];
        if ($mode == 'month') {
            $rs = $this->db->select_sum('order_total')
                    ->select('MONTH(order_date) as month')
                    ->from('order')
                    ->where('transaction_no <> ""')
                    ->where('YEAR(order_date)', date('Y'))
                    ->group_by('MONTH(order_date)')
                    ->order_by('MONTH(order_date)', 'ASC')
                    ->get();
            //    lQ();
        } elseif ($mode == 'days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-30 days'));
            $end_date = date('Y-m-d 23:59:59');
            $rs = $this->db->select_sum('order_total')
                    ->select('concat( day( order_date ) , "-" ,  MONTH( order_date )  ) as days', false)
                    ->from('order')
                    ->where('transaction_no <> ""')
                    ->where('YEAR(order_date)', date('Y'))
                    ->where('DATE(order_date) between "' . $start_date . '" and "' . $end_date . '"')
                    ->group_by('DATE(order_date), MONTH(order_date)')
                    ->order_by('DATE(order_date), MONTH(order_date)', 'ASC')
                    ->get();
//            lQ();
        }

        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }
    }

    function graphSaleOrders($mode = 'month') {
        $out = [];
        $out['month'] = [];
        $out['order_total'] = [];
        if ($mode == 'month') {
            $rs = $this->db->select('count(order_id) as cnt')
                    ->select('MONTH(order_date) as month')
                    ->from('order')
                    ->where('transaction_no <> ""')
                    ->where('YEAR(order_date)', date('Y'))
                    ->group_by('MONTH(order_date)')
                    ->order_by('MONTH(order_date)', 'ASC')
                    ->get();
//                        lQ();
        } elseif ($mode == 'days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-30 days'));
            $end_date = date('Y-m-d 23:59:59');
            $rs = $this->db->select('count(order_id) as cnt')
                    ->select('concat( day( order_date ) , "-" ,  MONTH( order_date )  ) as days', false)
                    ->from('order')
                    ->where('transaction_no <> ""')
                    ->where('YEAR(order_date)', date('Y'))
                    ->where('DATE(order_date) between "' . $start_date . '" and "' . $end_date . '"')
                    ->group_by('DATE(order_date), MONTH(order_date)')
                    ->order_by('DATE(order_date), MONTH(order_date)', 'ASC')
                    ->get();
//            lQ();
        }

        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }
    }

}

?>
