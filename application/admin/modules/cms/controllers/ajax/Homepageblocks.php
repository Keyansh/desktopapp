<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Homepageblocks extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->is_admin_protected = TRUE;
	}

	function updateSortOrder(){
		$sort_data = $this->input->post('menu', true);
		//print_r($sort_data);
		foreach($sort_data as $key=>$val) {
			$update = array();
			$update['block_sort_order'] = $key+1;
			$this->db->where('page_block_id', $val);
			$this->db->update('cash_for_cars', $update);
		}
		//echo "Done";
        print_r($_POST);
	}
}
?>