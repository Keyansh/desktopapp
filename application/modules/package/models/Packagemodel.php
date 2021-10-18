<?php

class Packagemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function listAllPackages() {
		$this->db->where('show_id', '0');
		$this->db->where('product_type_id', '1');
		$this->db->limit('6');
		$this->db->order_by("product_id", "desc"); 
		$rs = $this->db->get('product');
		return $rs->result_array();
	}
	
	function fetchByAlias($alias) {
		$this->db->select('*');
        $this->db->from('product');
		$this->db->join('product_pricing', 'product_pricing.product_id = product.product_id');
		$this->db->where('product_is_active', '1');
		$customer = $this->memberauth->checkAuth();
		if($customer['pricing_plan_id']) {
			$this->db->where('product_pricing.pricing_plan_id', $customer['pricing_plan_id']);
		} else {
			$this->db->where('product_pricing.pricing_plan_id', '1');
		}
		$this->db->where('product_alias', $alias);		
		$query = $this->db->get();
		if($query->num_rows() == 1) {
			return $query->row_array();
		} else {
			return FALSE;
		}
	}
	
	function listAllPackageProducts($package) {
		$this->db->from('product_bundle_item');
		$this->db->join('product','product.product_id = product_bundle_item.bundled_item_id');
		$this->db->where('product_bundle_item.product_id', $package['product_id']);
		$rs = $this->db->get();
		return $rs->result_array();
	}
	
	function getShowDetail($show_code) {
		$this->db->where('show_code', $show_code);
		$query = $this->db->get('show');
		if($query->num_rows() == 1) {
			return $query->row_array();
		} else {
			return FALSE;
		}
	}
	
	function getPackages($show) {
		$this->db->where('show_id', $show['show_id']);
		$rs = $this->db->get('product');
		return $rs->result_array();
	}
}

?>