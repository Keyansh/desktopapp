<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Snapshots extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //function to enable record
    function index($pid = FALSE, $offset = 0) {
        $this->load->model('Snapshotmodel');
        $this->load->model('Pagemodel');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Get Page Details
        $page_details = array();
        $page_details = $this->Pagemodel->detail($pid);
        if (!$page_details) {
            $this->utility->show404();
            return;
        }

        //Setup pagination
        $perpage = 20;
        $config['base_url'] = base_url() . "cms/snapshots/index/{$page_details['page_id']}/";
        $config['uri_segment'] = 5;
        $config['total_rows'] = $this->Snapshotmodel->countAll($page_details['page_id']);
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //List all page snapshots
        $snapshots = array();
        $snapshots = $this->Snapshotmodel->listAll($page_details['page_id']);

        //render view
        $inner = array();
        $inner['page_details'] = $page_details;
        $inner['snapshots'] = $snapshots;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('snapshots/listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //Restore snapshot
    function restore($sid = FALSE) {
        $this->load->model('Snapshotmodel');
        $this->load->model('Pagemodel');
        $this->load->model('Blockmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Get snapshot details
        $snapshot = array();
        $snapshot = $this->Snapshotmodel->getDetails($sid);
        if (!$snapshot) {
            $this->utility->show404();
            return;
        }

        //Form Validation
        $this->form_validation->set_rules('restore_revision', 'Restore Revision', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['snapshot'] = $snapshot;

            $page = array();
            $page['content'] = $this->load->view('snapshots/restore-revision', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            if ($this->input->post('restore_revision', TRUE) == 1) {
                $this->Snapshotmodel->restoreSnapshot($snapshot);
                $this->session->set_flashdata('SUCCESS', 'snapshot_active');
            }

            redirect("cms/snapshots/index/{$snapshot['page_id']}");
            exit();
        }
    }

}

?>