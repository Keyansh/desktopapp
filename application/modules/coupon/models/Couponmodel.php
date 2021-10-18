<?php
class Couponmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	//get coupon by code
	function getCoupon($c_code){

		$this->db->where('coupon_code', $c_code);
		$this->db->where('active_to >', date('Y-m-d'));
		$this->db->where('coupon_active ', 1);
		$rs = $this->db->get('coupon');
		if($rs->num_rows() == 1) {
	        return $rs->row_array();
		}
		 return FALSE;

	}
	function coupon_details($code){	
		$this->db->select('c.id as cpid, c.*, c1.id as cpcid, c1.*, p1.profile_name');
		$this->db->from('coupon c');
		$this->db->join('coupon_condition c1', 'c.id = c1.coupon_id', 'left');
		$this->db->join('profilegroup p1', 'p1.id = c.profile_id', 'left');
		$this->db->where('c.coupon_code', $code);
		$this->db->where('c.active_date <=', date('Y-m-d'));
		$this->db->where('c.expire_date >=', date('Y-m-d'));
		$this->db->where('c.coupon_active ', 1);
		//$this->db->group_by('c.id');
		$rs = $this->db->get();
	    return $rs->result_array();
	}

	function pro_coupon_details($code){	
		$this->db->select('c.id as cpid, c.*, c1.id as cpcid, c1.*');
		$this->db->from('coupon c');
		$this->db->join('coupon_condition c1', 'c.id = c1.coupon_id', 'left');
		$this->db->where('c.coupon_code', $code);
		//$this->db->where('c1.product_id', $ctID);
		$this->db->where('c.active_date <=', date('Y-m-d'));
		$this->db->where('c.expire_date >=', date('Y-m-d'));
		$this->db->where('c.coupon_active ', 1);
		//$this->db->group_by('c.id');
		$rs = $this->db->get();
		//echo $this->db->last_query();
		if($rs->num_rows() > 0) {
	        return $rs->result_array();
		}
		return FALSE;

	}
	
	function del_coupon_details($code){	
		$this->db->select('c.id as cpid, c.*, c1.id as cpcid, c1.*');
		$this->db->from('coupon c');
		$this->db->join('coupon_condition c1', 'c.id = c1.coupon_id', 'left');
		$this->db->where('c.coupon_code', $code);
		$this->db->where('c.coupon_active ', 1);
		$rs = $this->db->get();
		//return $this->db->last_query();
		if($rs->num_rows() == 1) {
	        return $rs->row_array();
		}
		return FALSE;

	}

	function coupon($code,$add=true) {
		$couponData = $this->coupon_details($code);
		$sessData = $this->session->userdata('cart_contents');
		$this->load->model('cart/cartmodel');
		$this->load->model('catalog/Productmodel');
		$user_id = $this->session->userdata('user_id');
		$profile_id = $this->session->userdata('profile_id');
		$guestuser = $this->session->userdata('guestuser');
		$frontuser = $this->session->userdata('frontuser');
		$couponApplicable = $couponApplied = false;
		$extraData = $this->cart->extraData();
		$cart_price = $extraData['subtotal'];
		foreach ($couponData as $couponData) {
			$tmp = $this->session->userdata('cart_contents');
			if(isset($tmp['coupon_code']) && $tmp['coupon_code'] && $add) {
				break;
			}
			$coupon_type = $couponData['pro_coupon_type'] ? $couponData['pro_coupon_type'] : ($couponData['coupon_on'] ? $couponData['coupon_on'] : '');
			$coupon_value = $couponData['pro_coupon_type_value'] ? $couponData['pro_coupon_type_value'] : ($couponData['coupon_type_value'] ? $couponData['coupon_type_value'] : '');
			$profileCheck = ($couponData['profile_id']==0) || ($couponData['profile_id']==$profile_id);
			$userCheck =  ($couponData['user_id']==0) || ($couponData['user_id']==$user_id);
			$minValueCheck = ($couponData['min_basket_value'] <= $cart_price) || (!$couponData['min_basket_value']);
			$sessData['coupon_type'] = $coupon_type;
			// if(!$add) {
			// 	continue;
			// }
			// e($couponData,0);
			// e("$profileCheck && $userCheck && $minValueCheck");
			if($profileCheck && $userCheck && $minValueCheck) {
				$sessData['coupon_code'] = $code;
				switch ($coupon_type) {
					case 'free':
						$product = $this->Productmodel->getDetails($couponData['product_id']);
						$tmp['product_id'] = $product['id'];
						$tmp['order_item_qty'] = $coupon_value;
						$tmp['order_item_name'] = $product['name'];
						$tmp['order_item_price'] = 0.00;
						$tmp['is_taxable'] = $product['is_taxable'];
						$tmp['free_product'] = true;
						$tmp['actual_price'] = $product['price'];
						$tmp['discounting_type'] = '';
						$tmp['special_price_type'] = '';
						$tmp['special_price'] = '';
						$tmp['tier_price'] = '';
						if($add) {
							$this->cartmodel->insertRecord($tmp);
							$couponApplied = $couponData;
						}
						else {
							$key = self::getCartItemKey($product['id']);
							if($key) {
								$this->cartmodel->deleteRecord($key);
								$couponApplied = $couponData;
							}
						}
					break;
					case 'basket':
						$couponn = $couponData['coupon_type'];
						$discountt = 0;
						if($couponn == 'percentage') {
							$discountt = $cart_price * $coupon_value / 100;
						}
						elseif($couponn == 'value') {
							$discountt = $coupon_value;
						}
						if($discountt && $add) {
							$sessData['discounted_amount'] = $discountt;
							$this->session->set_userdata('cart_contents',$sessData);
							$couponApplied = $couponData;
						}
						elseif(isset($sessData['discounted_amount']) && !$add) {
							self::cleanAdditionalData($sessData);
							$this->session->set_userdata('cart_contents',$sessData);
							$couponApplied = $couponData;
						}
					break;
				}
			}		
			elseif(!$add) {
				self::cleanAdditionalData($sessData);
				$this->session->set_userdata('cart_contents',$sessData);
				$couponApplied = $couponData;
			}
			// e('end');
		}

		// if($add) {
		// 	e($code);
		// }
		return $couponApplied;
	}

	function cleanAdditionalData(&$sessData){
		if(isset($sessData['discounted_amount'])){
			unset($sessData['discounted_amount']);
		}
		if(isset($sessData['coupon_code'])){
			unset($sessData['coupon_code']);
		}
		if(isset($sessData['coupon_type'])){
			unset($sessData['coupon_type']);
		}
		if(isset($sessData['coupon_value']) || empty($sessData['coupon_value'])) {
			unset($sessData['coupon_value']);
		}
	}

	function getCartItemKey($product_id) {
		$this->load->library('cart');
		$records = $this->cart->contents();
		foreach($records as $record) {
			if($record['product_id'] == $product_id) {
				return $record['rowid'];
			}
		}
	}

}
?>
