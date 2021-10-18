<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Offers extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

}

?>