<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attribute extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index() {
      if (!$this->checkAccess('IMPORT_DATA')) {
          $this->utility->accessDenied();
          return;
      }
      $this->load->model('import/Importmodel');
      $this->load->library('form_validation');
      // $this->load->helper('form');
      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');

      $this->form_validation->set_error_delimiters('<p>', '</p>');
      $this->form_validation->set_rules('files', 'CSV file', 'callback_valid_document');
      $this->form_validation->set_rules('button','Submit','required');
      // e($_FILES);
      if ($this->form_validation->run() == FALSE) {
          // e(validation_errors());
          $page = $inner = array();
          $page['content'] = $this->load->view('import/attributes', $inner, TRUE);
          $this->load->view('shell', $page);
      }
      else {
          $this->Importmodel->importAttributes();
          $this->session->set_flashdata('SUCCESS', 'import_data');
          redirect("import/attribute");
      }

    }

    // validation start for add******************************************
    public function valid_document($str) {
        if (count($_FILES) == 0 || !array_key_exists('document', $_FILES)) {
            $this->form_validation->set_message('valid_document', 'CSV file is required');
            return false;
        }

        if ($_FILES['document']['size'] == 0) {
            $this->form_validation->set_message('valid_document', 'CSV file is required');
            return false;
        }

        if ($_FILES['document']['error'] != UPLOAD_ERR_OK) {
            $this->form_validation->set_message('valid_document', 'Upload of CSV failed');
            return false;
        }

        $validfile = array('.csv');
        $ext = strtolower(strrchr($_FILES['document']['name'], "."));
        if (!in_array($ext, $validfile)) {
            $this->form_validation->set_message('valid_document', 'Only .csv file allowed');
            return false;
        }
        return true;
    }
    //validation ends*****************************************************************************


}
