<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends Cms_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->session->unset_userdata('ROLE_ID');
        $this->session->unset_userdata('CUSTOMER_ID');
        $this->session->unset_userdata('LOGIN_EMAIL');
        $this->session->unset_userdata('LOGIN_NAME');
        $this->session->unset_userdata('GROUP_ID');
        $this->session->sess_destroy();
        redirect("customer/login");
        exit();
    }

}

?>
