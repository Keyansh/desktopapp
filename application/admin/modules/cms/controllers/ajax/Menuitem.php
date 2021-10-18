<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menuitem extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->is_admin_protected = TRUE;
	}

	function updateSortOrder(){
		$sort_data = $this->input->post('menu', true);
		foreach($sort_data as $key=>$val) {
			$update = array();
			$update['menu_sort_order'] = $key+1;
			$this->db->where('menu_item_id', $val);
			$this->db->update('menu_item', $update);
		}
		//echo "Done";
        print_r($_POST);
	}

	/*function update() {
		$sort_data = $this->input->post('menu', true);
		$sort_order_arr = array();

		foreach($sort_data as $id=>$parent) {
			if($parent == 'root') {
				$parent = 0;
			}

			$update = array();
			$update['parent_id'] = $parent;
			$this->db->where('menu_item_id', $id);
			$this->db->update('menu_item', $update);
		}

		foreach($sort_data as $id=>$parent) {
			if($parent == 'root') {
				$parent = 0;
			}

			if(isset($sort_order_arr[$parent])) {
				$sort_order = $sort_order_arr[$parent];
				$sort_order++;
				$sort_order_arr[$parent] = $sort_order;
			}else {
				$sort_order = 0;
				$sort_order_arr[$parent] = $sort_order;
			}

			$update = array();
			$update['menu_sort_order'] = $sort_order;
			$this->db->where('menu_item_id', $id);
			$this->db->where('parent_id', $parent);
			$this->db->update('menu_item', $update);
		}

		print_r($sort_order_arr);
	}*/
}
?>