<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Server_side_dt extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Productmodel');
        $this->is_admin_protected = TRUE;
    }

    function jsonProducts() {
        /*
         * DataTables example server-side processing script.
         *
         * Please note that this script is intentionally extremely simply to show how
         * server-side processing can be implemented, and probably shouldn't be used as
         * the basis for a large complex system. It is suitable for simple use cases as
         * for learning.
         *
         * See http://datatables.net/usage/server-side for full details on the server-
         * side processing requirements of DataTables.
         *
         * @license MIT - http://datatables.net/license_mit
         */

        /*         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * Easy set variables
         */

// DB table to use
        $table = 'br_product';

// Table's primary key
        $primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'img', 'dt' => 1),
            array('db' => 'name', 'dt' => 2),
            array('db' => 'sku', 'dt' => 3),
            array('db' => 'type', 'dt' => 4),
            array('db' => 'price', 'dt' => 5),
            array('db' => 'is_active', 'dt' => 6),
            
//            array(
//                'db' => 'salary',
//                'dt' => 5,
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

// SQL server connection information for checksample setup
//        $sql_details = array(
//            'user' => 'common_Ly638%',
//            'pass' => 'P7Xt3F*2QclmKabq',
//            'db' => 'user_8r4ndm3',
//            'host' => '192.168.100.21'
//        );


        /*         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

//        require( 'ssp.class.php' );
        $this->load->library('Ssp');
        echo json_encode(
                SSP::getProducts($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }

}

?>