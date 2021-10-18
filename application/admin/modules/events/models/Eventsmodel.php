<?php

class Eventsmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //function get deatails of eventss
    function getDetails($aid) {
        $this->db->select('*');
        $this->db->from('events');
        $this->db->where('id', intval($aid));
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return false;
    }

    //count all product eventss
    function countAll() {
        $this->db->select('*');
        $this->db->from('events');
        return $this->db->count_all_results();
    }

    //list all product eventss
    function listAll() {
        $userId = curUsrId();
//        e($userId);
        $this->db->select('t1.*');
        $this->db->from('events t1');
        if ($userId != 1) {
            $this->db->join('event_user t2', 't2.event_id = t1.id', 'LEFT');
            $this->db->where('t1.created_by', $userId);
            $this->db->or_where('t2.user_id', $userId);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    //function insert records
    function insertRecord() {
        $data = array();
        $data['created_by'] = curUsrId();
        $data['name'] = $this->input->post('event_name', true);
        $data['alias'] = $this->_slug($this->input->post('event_name', TRUE));
        $data['description'] = $this->input->post('contents', true);
        $data['date_time'] = $this->input->post('date') . '/' . $this->input->post('time');
        $data['is_active'] = 1;
        $data['created_on'] = time();
        $this->db->insert('events', $data);
    }

    //function update records
    function updateRecord($events) {
        $data = array();
        $data['name'] = $this->input->post('event_name', true);
        $data['date_time'] = $this->input->post('date') . '/' . $this->input->post('time');
        $data['description'] = $this->input->post('contents', true);
        $this->db->where('id', $events['id']);
        $this->db->update('events', $data);
        return;
    }

    //Function Delete Record	
    function deleteRecord($event) {
        $this->db->where('id', $event['id']);
        $this->db->delete('events');
        return;
    }

    //function slug
    function _slug($eventtitle) {
        $event_title = ($eventtitle) ? $eventtitle : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $event_title;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('alias', $slug);
        $rs = $this->db->get('events');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('alias', $alt_slug);
                $rs = $this->db->get('events');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }

    function listAllUser() {
        $cid = curUsrId();
        if ($cid != 1) {
            $this->db->where("parent_id", $cid);
        }
        $this->db->where("user_id !=", $cid);
        $rs = $this->db->get('user');
        return $rs->result_array();
    }

    function listAllAssignedUser($eid) {
        $this->db->where("event_id", $eid);
        $rs = $this->db->get('event_user');
        return $rs->result_array();
    }

    function assignUsers($eid) {
        $users = $this->input->post('users', true);
//        e($users);
//        if ($users) {
        $this->db->where('event_id', $eid);
        $this->db->delete('event_user');
        foreach ($users as $user) {
            $data['event_id'] = $eid;
            $data['user_id'] = $user;
            $this->db->insert('event_user', $data);
        }
//        }
    }

}

?>