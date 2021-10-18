<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gallery extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->is_admin_protected = TRUE;
	}

	function updateSortOrder(){
		$sort_data = $this->input->post('image', true);
		foreach($sort_data as $key=>$val) {
			$update = array();
			$update['image_sort_order'] = $key+1;
			$this->db->where('image_id', $val);
			$this->db->update('image', $update);
		}

        print_r($_POST);
	}
}
?>