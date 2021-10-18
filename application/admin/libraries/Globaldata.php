<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Globaldata {

    var $CI;

    function __construct() {
        $this->CI = & get_instance();
        log_message('debug', "Metautils Class Initialized");
        $this->load_data();
    }

    function load_data() {

        //Informational Messages
        $info = '';
        $info_key = $this->CI->session->flashdata('INFO');
        if ($info_key) {
            $this->CI->lang->load('info', 'english');
            $info = $this->CI->lang->line($info_key);
            $this->CI->load->vars(array('INFO' => $info));
        }

        //Error Messages
        $error = '';
        $error_key = $this->CI->session->flashdata('ERROR');
        if ($error_key) {
            $this->CI->lang->load('error', 'english');
            $error = $this->CI->lang->line($error_key);
            $this->CI->load->vars(array('ERROR' => $error));
        }

        //Success Messages
        $success = '';
        $success_key = $this->CI->session->flashdata('SUCCESS');
        if ($success_key) {
            $this->CI->lang->load('success', 'english');
            $success = $this->CI->lang->line($success_key);
            $this->CI->load->vars(array('SUCCESS' => $success));
        }

        //Get config settings
        $rs = $this->CI->db->get('config');
        foreach ($rs->result_array() as $row) {
            define('DWS_' . $row['config_key'], $row['config_value']);
        }
    }

}

?>