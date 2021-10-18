<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deals extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    // validation start for add******************************************
    //valid coupon title
    //**************************************************validation end
}

?>