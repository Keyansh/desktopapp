<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Server_side_dt extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Ordermodel');
        $this->load->library('cart');
        $this->is_admin_protected = TRUE;
    }

    function jsonProducts() {
        $this->cart->destroy();
        // DB table to use
        $table = 'br_product';

        // Table's primary key
        $primaryKey = 'id';
        // indexes
        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'img', 'dt' => 1),
            array('db' => 'name', 'dt' => 2),
            array('db' => 'sku', 'dt' => 3),
            array('db' => 'price', 'dt' => 4),
//            array(
//                'db' => 'salary',
//                'dt' => 4,
//                'formatter' => function( $d, $row ) {
//                    return '$' . number_format($d);
//                }
//            )
        );

// SQL server connection information for local setup
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );

        $this->load->library('Ssp');
        echo json_encode(
                SSP::getProducts($_REQUEST, $sql_details, $table, $primaryKey, $columns)
        );
    }

}

?>