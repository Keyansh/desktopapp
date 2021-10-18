<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menuajax extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->is_admin_protected = TRUE;
	}


	function index($mid) {
		$this->load->model('Menulinkmodel');
		echo $this->Menulinkmodel->menuTree(0, $mid);
	}

	function sortorder($menu_item_id = 0) {
		$this->load->model('Menulinkmodel');

		//Get Page Details
		$menu_item = array();
		$menu_item = $this->Menulinkmodel->details($menu_item_id);
		if(!$menu_item ) {
            $this->utility->show404();
            return;
        }

		$this->setSortOrder($menu_item);
	}

	function setSortOrder($menu_item) {
		$menu_sort_order= intval($this->input->post('menu_sort_order', TRUE));

		if($menu_sort_order < $menu_item['menu_sort_order']) {
			$this->db->query('UPDATE `'.$this->db->dbprefix.'menu_item` SET `menu_sort_order` = menu_sort_order + 1 WHERE `menu_sort_order` >= '.$menu_sort_order.' AND `menu_sort_order` <= '.$menu_item['menu_sort_order'].' AND `parent_id` = '.$menu_item['parent_id'].' AND `menu_item_id` != '.$menu_item['menu_item_id']);
		}
		else {
			$this->db->query('UPDATE `'.$this->db->dbprefix.'menu_item` SET `menu_sort_order` = menu_sort_order - 1 WHERE `menu_sort_order` >= '.$menu_item['menu_sort_order'].' AND `menu_sort_order` <= '.$menu_sort_order.' AND `parent_id` = '.$menu_item['parent_id'].' AND `menu_item_id` != '.$menu_item['menu_item_id']);
		}

		$update = array();
		$update['menu_sort_order'] = $menu_sort_order;
		$this->db->where('menu_item_id', $menu_item['menu_item_id']);
		$this->db->update('menu_item', $update);

		echo "All Done";
	}
}
?>