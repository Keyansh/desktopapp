<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Block extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function updateSortOrder() {
        $sort_data = $this->input->post('block', true);
        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['block_sort_order'] = $key + 1;
            $this->db->where('page_block_id', $val);
            $this->db->update('page_block', $update);
        }
        //echo "Done";
        print_r($_POST);
    }

}

?>