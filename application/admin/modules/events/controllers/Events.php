<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Events extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index() {
        $this->load->model('Eventsmodel');

        $events = array();
        $events = $this->Eventsmodel->listAll();
//        e($events);

        $inner = array();
        $inner['events'] = $events;
        $page = array();
        $page['content'] = $this->load->view('events-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //function add product attributes
    function add() {
        $this->load->model('Eventsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');


        //validation check
        $this->form_validation->set_rules('event_name', 'Event Name', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('time', 'Time', 'trim|required');
        $this->form_validation->set_rules('contents', 'Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('event-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Eventsmodel->insertRecord();

            $this->session->set_flashdata('SUCCESS', 'event_added');

            redirect("events");
            exit();
        }
    }

    //function edit product attributes
    function edit($eid) {
        $this->load->model('Eventsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //get attributes details
        $event = array();
        $event = $this->Eventsmodel->getDetails($eid);
//        e($event);
        if (!$event) {
            $this->utility->show404();
            return;
        }

        //validation check
        $this->form_validation->set_rules('event_name', 'Event Name', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('time', 'Time', 'trim|required');
        $this->form_validation->set_rules('contents', 'Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['event'] = $event;
            $page = array();
            $page['content'] = $this->load->view('event-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Eventsmodel->updateRecord($event);

            $this->session->set_flashdata('SUCCESS', 'attributes_updated');

            redirect("events");
            exit();
        }
    }

    //function delete
    function delete($eid) {
        $this->load->model('Eventsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //get attributes details
        $event = array();
        $event = $this->Eventsmodel->getDetails($eid);
//        e($event);
        if (!$event) {
            $this->utility->show404();
            return;
        }
        $this->Eventsmodel->deleteRecord($event);
        $this->session->set_flashdata('SUCCESS', 'event_deleted');
        redirect('events');
        exit();
    }

    function assign($eid) {
        $this->load->model('Eventsmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $users = array();
        $users = $this->Eventsmodel->listAllUser();
//        e($users);

        $assignedusers = $userIds = array();
        $assignedusers = $this->Eventsmodel->listAllAssignedUser($eid);
        if ($assignedusers) {
            foreach ($assignedusers as $assigneduser) {
                $userIds[] = $assigneduser['user_id'];
            }
        }
        //validation check
        $this->form_validation->set_rules('users[]', 'Users', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['users'] = $users;
            $inner['userIds'] = $userIds;
            $inner['eid'] = $eid;
            $page = array();
            $page['content'] = $this->load->view('assignment', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Eventsmodel->assignUsers($eid);

            $this->session->set_flashdata('SUCCESS', 'user_assigened');

            redirect("events");
            exit();
        }
    }

    function calender_view() {
        $inner = array();
        $page = array();
        $page['content'] = $this->load->view('calender-view', $inner, true);
        $this->load->view('shell', $page);
    }

    function myevents_json() {
        $curUser = curUsrId();
        if ($curUser == 1) {
            $sql = "select br_events.id as eid,name as title ,description as description ,date_time as date_time ,UNIX_TIMESTAMP(STR_TO_DATE(date_time, '%d-%m-%Y/%h:%i %p')) as datetime from br_events";
        } else {
            $sql = "select br_events.id as eid,name as title ,description as description ,date_time as date_time ,UNIX_TIMESTAMP(STR_TO_DATE(date_time, '%d-%m-%Y/%h:%i %p')) as datetime from br_events LEFT JOIN br_event_user ON br_event_user.event_id = br_events.id WHERE br_event_user.user_id = $curUser OR br_events.created_by = $curUser group by br_event_user.event_id";
        }

//        $this->db->select('id,name as title ,description as description ,date_time as date_time ,UNIX_TIMESTAMP(STR_TO_DATE(date_time, \'%d-%m-%Y/%h:%i %p\')) as datetime', false);
//        $this->db->from('events t1');
//        if ($curUser != 1) {
//            $this->db->join('event_user t2', 't2.user_id = t1.created_by');
//            $this->db->where('t2.user_id OR t1.created_by', $curUser);
//        }
//        $results = $this->db->get()->result_array();
        $return['success'] = true;
        $results = $this->db->query($sql)->result_array();
//        e($results);
        foreach ($results as $result):
            $startdate = strtotime("midnight", $result['datetime']);
            $endate = strtotime("midnight", $result['datetime']) + (60 * 60);
            $temp = array();
            $temp['id'] = $result['eid'];
            $temp['title'] = $result['title'];
//            $temp['url'] = '#';
            $temp['class'] = 'event-info';
            $temp['start'] = $startdate * 1000;
            $temp['end'] = $endate * 1000;
            $temp['description'] = $result['description'];
            $temp['date_time'] = str_replace('/', ' ', $result['date_time']);
            $return['result'][] = $temp;
        endforeach;
        echo json_encode($return);
    }

}

?>