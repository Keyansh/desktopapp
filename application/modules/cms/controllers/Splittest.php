<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Splittest extends Cms_Controller {

    public function track($test_id = 0) {
		
		$this->splittestcore->logConversion($test_id);
		/*$blocked_ip_address = explode(',', DWS_BLOCKED_IP_ADDRESS);
		if(in_array($_SERVER['REMOTE_ADDR'], $blocked_ip_address)){
			return ;
		}
        //unset the session data
        $this->session->unset_userdata('SPLIT_TEST_LOG_ID');
        $this->session->unset_userdata('SPLIT_TEST_ID');
        $this->session->unset_userdata('SUCCESS_URL');

        //update the
        $data = array();
        $data['conversion'] = 1;
        $this->db->where('split_test_log_id', $test_id);
        $this->db->update('split_test_log', $data);

        header('Content-Type: image/gif');
        echo file_get_contents('images/pixel.gif');
        exit();*/
    }

}

?>