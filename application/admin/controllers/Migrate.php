<?php

class migrate extends CI_Controller {

    public function index() {
        // load migration library
        $this->load->library('migration');

        $admin_id = $this->session->userdata('USER_ID');
        if ($admin_id) {
            if ($this->migration->current() === FALSE) {
                echo 'Error' . $this->migration->error_string();
            } else {
                echo 'Migrations ran successfully!';
            }
        }
        else{
            redirect('welcome');
            exit();
        }
    }

}
