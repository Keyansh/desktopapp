<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Coupon extends Module_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$this->load->model('catalog/Productmodel');
        $this->load->model('catalog/Cartmodel');
		$this->load->model('catalog/Attributesmodel');
        $this->load->model('customer/Profilemodel');
		$this->load->model('Couponmodel');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->library('pagination');
		$this->load->helper('text');

		$this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
		$this->form_validation->set_error_delimiters('<li>', '</li>');

		if ($this->cart->total_items() == 0) {
            redirect('catalog/cart/index/', "location");
            exit();
        }

        //check the customers login
        $customer = array();
        $customer = $this->memberauth->checkAuth();
        if (!$customer) {
            $this->session->set_userdata('REDIR_URL', "checkout/");
            redirect('/customer/login/', "location");
            exit();
        }

		//fetch all attributes
		$attributes = array();
		$rs = $this->Attributesmodel->fetchByProductID();
		foreach($rs as $row) {
			$attributes[$row['attribute_id']] = $row['attribute_label'];
		}

		//fetch All tle attributes
		$attribute_options = array();
		$rs = $this->Attributesmodel->listOptions();
		foreach($rs as $row){
			$attribute_options[$row['attribute_value_id']] = $row['attribute_option'];
		}

		$variables = $this->Cartmodel->variables($customer);
        extract($variables);

		if ($this->form_validation->run() == FALSE) {
			$inner = array();
			$inner['attributes'] = $attributes;
			$inner['attribute_values'] = $attribute_options;
			$inner['customer'] = $customer;
			$inner['cart_total'] = $cart_total;
			$inner['shipping'] = $shipping;
			$inner['tax'] = $tax;
			$inner['discount'] = $discount;
			$inner['order_total'] = $order_total;

			$shell = array();
			$shell['contents'] = $this->load->view('checkout/checkout-index', $inner, true);
			$this->load->view("themes/" . THEME . "/templates/default", $shell);
		} else {
			$c_code = $this->input->post('coupon_code', true);

			//Get Coupon
			$coupon = array();
			$coupon = $this->Couponmodel->getCoupon($c_code);
			if ($coupon) {
				$this->session->set_userdata(array('COUPON_APPLIED' => $coupon));
				$this->session->set_flashdata('SUCCESS', 'coupon_added');

			}
			//if($this->input->post('coupon_code', true)==''){
			//$this->session->unset_userdata('INVALID_COUPON');
		//}
			//if(!$coupon){
				//$invalid_coupon = 'Invalid Coupon Code';
				//$this->session->set_userdata(array('INVALID_COUPON' => $invalid_coupon));
			//}
			redirect("checkout/index");

			exit();
		}
	}
	function check_coupon($code) {
		if(!$code) {
			echo json_encode(array("result"=>"No coupon code specified"));
			exit;
		}
		$this->load->model('Couponmodel');
		$this->load->model('cart/cartmodel');
		$this->load->model('catalog/Productmodel');
		$this->load->library('cart');

		$couponData = $this->Couponmodel->coupon_details($code);
		$sessData = $this->session->userdata('cart_contents');

		if(isset($sessData['coupon_code']) && $sessData['coupon_code'] == $code){
			echo json_encode(array("result"=>"Coupon Already Applied!"));
			exit;
		}
		elseif(!$couponData) {
			echo json_encode(array("result"=>"Wrong Coupon Code!"));
			exit;
		}
		else
		{
			if(isset($couponData[0]['min_basket_value'])) {
				if ($couponData[0]['min_basket_value'] > 0) {
					if ($sessData['subtotal'] < $couponData[0]['min_basket_value']) {
						$str = "This coupon is applicable on minimum basket value " . DWS_CURRENCY_SYMBOL . $couponData[0]['min_basket_value'];
						echo json_encode(array("result"=>$str));
						exit;
					}
				}
			}

			$couponApplied = $this->Couponmodel->coupon($code);
			if($couponApplied) {
				// e($couponApplied);
				$cart_contents = $this->session->userdata('cart_contents');
				$cart_contents['coupon_code'] = $code;
				$cart_contents['coupon_type'] = $couponApplied['pro_coupon_type'];
				$cart_contents['coupon_value'] = $couponApplied['pro_coupon_type_value'];
				$this->session->set_userdata('cart_contents',$cart_contents);
				echo json_encode(array("result"=>"Coupon Applied"));
				exit();
			}
		}
	}

	function del_coupon() {
		$this->load->model('Couponmodel');
		$sessData = $this->session->userdata('cart_contents');
		$existing_coupon_code = isset($sessData['coupon_code']) ? $sessData['coupon_code'] : 0 ;
		if(!$existing_coupon_code) {
			return;
		}
		$result = $this->Couponmodel->coupon($existing_coupon_code,false);
		if($result) {
			// $cart_contents = $this->session->userdata('cart_contents');
			// unset($cart_contents['coupon_code']);
			// unset($cart_contents['coupon_type']);
			// unset($cart_contents['coupon_value']);
			// $this->session->set_userdata('cart_contents',$cart_contents);
			echo json_encode(array("result"=>"Coupon Removed"));
		}
	}

	/*function del_coupon($cpcode){

		if($cpcode){

			$this->load->model('Couponmodel');
			$this->load->library('cart');
			$data = $this->Couponmodel->del_coupon_details($cpcode);
			$cpData = array();
			$sessData = $this->session->userdata('cart_contents');
			$perVal = "";

			if($data['user_id'] == $this->session->userdata('CUSTOMER_ID')){

				if($data['coupon_on'] === 'basket'){

					if($sessData['cart_total'] == 0){
						unset($sessData['coupon_status']);
						unset($sessData['coupon_code']);
						$this->session->set_userdata('cart_contents', $sessData);
						print_r(json_encode(array("result"=>"Coupon removed!")));
					}

					if($sessData['cart_total'] <= $data['min_basket_value'] && !empty($data['min_basket_value'])){
						unset($sessData['coupon_status']);
						unset($sessData['coupon_code']);
						$this->session->set_userdata('cart_contents', $sessData);
						print_r(json_encode(array("result"=>"Coupon removed!")));
					}

					if($sessData['cart_total'] >= $data['min_basket_value'] && !empty($data['min_basket_value']) ){

						if($data['coupon_type'] === 'percentage'){
							$dec = $data['coupon_type_value'] / 100;
							$perVal = $sessData['cart_total']  * $dec;
							$sessData['cart_total'] = $sessData['cart_total'] - $perVal;
						}
						if($data['coupon_type'] === 'value'){
							$sessData['cart_total'] = $sessData['cart_total'] - $data['coupon_type_value'];
						}

						$this->session->set_userdata('cart_contents', $sessData);
						print_r(json_encode(array("result"=>"Coupon removed!")));
					}

					if(empty($data['min_basket_value']) && $sessData['cart_total'] != 0 ) {

						if($data['coupon_type'] === 'percentage'){
							$dec = $data['coupon_type_value'] / 100;
							$perVal = $sessData['cart_total']  * $dec;
							$sessData['cart_total'] = $sessData['cart_total'] - $perVal;
						}
						if($data['coupon_type'] === 'value'){
							$sessData['cart_total'] = $sessData['cart_total'] - $data['coupon_type_value'];
						}

						$this->session->set_userdata('cart_contents', $sessData);
						print_r(json_encode(array("result"=>"Coupon removed!")));
					}



				}

				if($data['coupon_on'] === 'category'){

					$proArray = array();
					foreach ($sessData as $key => $value) {
						if(is_array($value)){
							$proArray[$key] = $value;
						}
					}

					$filterArr =array();
					foreach ($proArray as $p => $v) {
						if($p == 'free'){

						}
						else{
							$filterArr[] = $v;
						}
					}

					$catArr = array();
					foreach ($filterArr as $k => $c) {
						if($data['category'] == $c['cid']){
							$catArr['cid'] = $c['cid'];
						}
					}

					if($catArr['cid']){

						if($sessData['cart_total'] == 0){
							unset($sessData['coupon_status']);
							unset($sessData['coupon_code']);
							$this->session->set_userdata('cart_contents', $sessData);
							print_r(json_encode(array("result"=>"Coupon removed!")));
						}

						if($sessData['cart_total'] <= $data['min_basket_value'] && !empty($data['min_basket_value'])){
							unset($sessData['coupon_status']);
							unset($sessData['coupon_code']);
							$this->session->set_userdata('cart_contents', $sessData);
							print_r(json_encode(array("result"=>"Coupon removed!")));
						}

						if($sessData['cart_total'] >= $data['min_basket_value'] && !empty($data['min_basket_value']) ){

							if($data['coupon_type'] === 'percentage'){
								$dec = $data['coupon_type_value'] / 100;
								$perVal = $sessData['cart_total']  * $dec;
								$sessData['cart_total'] = $sessData['cart_total'] - $perVal;
							}
							if($data['coupon_type'] === 'value'){
								$sessData['cart_total'] = $sessData['cart_total'] - $data['coupon_type_value'];
							}

							$this->session->set_userdata('cart_contents', $sessData);
							print_r(json_encode(array("result"=>"Coupon removed!")));
						}

						if(empty($data['min_basket_value']) && $sessData['cart_total'] != 0 ) {

							if($data['coupon_type'] === 'percentage'){
								$dec = $data['coupon_type_value'] / 100;
								$perVal = $sessData['cart_total']  * $dec;
								$sessData['cart_total'] = $sessData['cart_total'] - $perVal;
							}
							if($data['coupon_type'] === 'value'){
								$sessData['cart_total'] = $sessData['cart_total'] - $data['coupon_type_value'];
							}

							$this->session->set_userdata('cart_contents', $sessData);
							print_r(json_encode(array("result"=>"Coupon removed!")));

						}

					}
					else{
						unset($sessData['coupon_status']);
						unset($sessData['coupon_code']);
						$this->session->set_userdata('cart_contents', $sessData);
						print_r(json_encode(array("result"=>"Coupon removed!")));
					}

				}

				if($data['coupon_on'] === 'product'){

					$proArray = array();
					foreach ($sessData as $key => $value) {
						if(is_array($value)){
							$proArray[$key] = $value;
						}
					}
					$filterArr =array();
					foreach ($proArray as $p => $v) {
						if($p == 'free'){

						}
						else{
								$filterArr[] = $v;
						}
					}

					if($data['pro_coupon_type'] === 'free'){
						if(!empty($sessData['free'])){
							print_r('expression');
							unset($sessData['coupon_status']);
							unset($sessData['coupon_code']);
							unset($sessData['free']);
							$this->session->set_userdata('cart_contents', $sessData);
							print_r(json_encode(array("result"=>"Coupon removed!")));
						}

						foreach ($filterArr as $sv) {
							if($data['category_id'] == $sv['cid'] && $data['product_id'] == $sv['id']){
								print_r($filterArr);
								//return print_r(json_encode(array('nothing')));
							}
							else{
								unset($sessData['coupon_status']);
								unset($sessData['coupon_code']);
								unset($sessData['free']);
								$this->session->set_userdata('cart_contents', $sessData);
								return print_r(json_encode(array("result"=>"Coupon removed!")));
							}
						}

					}

					if($data['pro_coupon_type'] === 'value'){
						foreach ($filterArr as $sv) {
							if($data['category_id'] == $sv['cid'] && $data['product_id'] == $sv['id']){

							}
							else{
								unset($sessData['coupon_status']);
								unset($sessData['coupon_code']);
								$this->session->set_userdata('cart_contents', $sessData);
								print_r(json_encode(array("result"=>"Coupon removed!")));
							}
						}

					}

					if($data['pro_coupon_type'] === 'percentage'){
						foreach ($filterArr as $sv) {
							if($data['category_id'] == $sv['cid'] && $data['product_id'] == $sv['id']){

							}
							else{
								unset($sessData['coupon_status']);
								unset($sessData['coupon_code']);
								$this->session->set_userdata('cart_contents', $sessData);
								print_r(json_encode(array("result"=>"Coupon removed!")));
							}
						}

					}

				}


			}

		}
	}*/

	function deleteCouponID($ctID, $cpCode, $rowID){


		if($ctID && $cpCode){
			$this->load->model('Couponmodel');
			$this->load->library('cart');
			$couponData = $this->Couponmodel->coupon_details($cpCode);

			$coupStatus = array();
			$cpData = array();
			$sessData = $this->session->userdata('cart_contents');
			$perVal = "";

			foreach ($couponData as $data) {

				if($data['user_id'] == $this->session->userdata('CUSTOMER_ID')){

					if($sessData['cart_total'] >= $data['min_basket_value'] OR !empty($sessData['cart_total'])){



					}
					else{
						if($data['coupon_on'] === 'basket'){

							if($data['coupon_type'] === 'percentage'){
									$dec = $data['coupon_type_value'] / 100;
									$perVal = $sessData['cart_total']  * $dec;
									$sessData['cart_total'] = $sessData['cart_total'] + $perVal;
									unset($sessData['coupon_status']);
									unset($sessData['coupon_code']);
									$this->session->set_userdata('cart_contents', $sessData);
									$coupStatus[] = 'Coupon Removed!';
							}
							if($data['coupon_type'] === 'value'){
								$sessData['cart_total'] = $sessData['cart_total'] + $data['coupon_type_value'];
									unset($sessData['coupon_status']);
									unset($sessData['coupon_code']);
									$this->session->set_userdata('cart_contents', $sessData);
									$coupStatus[] = 'Coupon Removed!';

							}

						}

						if($data['coupon_on'] === 'category'){

							$proArray = array();
							foreach ($sessData as $key => $value) {
									if(is_array($value)){
										$proArray[$key] = $value;
									}
							}

							$filterArr =array();
							foreach ($proArray as $p => $v) {
									if($p == 'coupon'){

									}
									else{
										$filterArr[] = $v;
									}
							}


							$catArr = array();
							foreach ($filterArr as $k => $c) {
									if($data['category'] == $c['cid']){
										$catArr['cid'] = $c['cid'];
									}
							}

							if($data['coupon_type'] === 'value'){						if($catArr['cid']){

										if($sessData['cart_total'] > $data['coupon_type_value']){

											$sessData['cart_total'] = $sessData['cart_total'] + $data['coupon_type_value'];

											unset($sessData['coupon_status']);
											unset($sessData['coupon_code']);
											$this->session->set_userdata('cart_contents', $sessData);
											$coupStatus[] = 'Coupon Removed!';

										}
									}


							}
							if($data['coupon_type'] === 'percentage'){

									if($catArr['cid']){

										if($sessData['cart_total'] && $data['coupon_type_value']){

											$dec = $data['coupon_type_value'] / 100;
											$perVal = $sessData['cart_total']  * $dec;

											$sessData['cart_total'] = $sessData['cart_total'] + $perVal;
											unset($sessData['coupon_status']);
											unset($sessData['coupon_code']);
											$this->session->set_userdata('cart_contents', $sessData);
											$coupStatus[] = 'Coupon Removed!';
										}

									}

							}

						}
					}
					/*if($sessData['cart_total'] >= $data['coupon_type_value']){

						if($data['coupon_on'] === 'product'){

							$proArray = array();
							foreach ($sessData as $key => $value) {
								if(is_array($value)){
									$proArray[$key] = $value;
								}
							}
							$filterArr =array();
							foreach ($proArray as $p => $v) {
								$filterArr[] = $v;
							}



							if($data['pro_coupon_type'] === 'free'){
								foreach ($filterArr as $sv) {
									if($sv['rowid'] === 'free'){
										unset($sessData['coupon_status']);
										unset($sessData['coupon_code']);
										unset($sessData['free']);
									}
								}



								$coupStatus[] = 'Coupon Removed!';


								if($rowID === 'free'){
									unset($sessData['coupon_status']);
									unset($sessData['coupon_code']);
									unset($sessData['free']);
									$this->session->set_userdata('cart_contents', $sessData);
									$coupStatus[] = 'Coupon Removed!';
								}

							}

							if($data['pro_coupon_type'] === 'value'){
								foreach ($filterArr as $sv) {

									if($sv['id'] == $data['product_id']){

										$sessData[$sv['rowid']]['price'] = $sessData[$sv['rowid']]['price'] + $data['pro_coupon_type_value'];

										$qtyVal = $sessData[$sv['rowid']]['qty'] * $data['pro_coupon_type_value'];
										$sessData[$sv['rowid']]['subtotal'] = $sessData[$sv['rowid']]['subtotal'] + $qtyVal;

										$sessData['cart_total'] = $sessData['cart_total'] + $qtyVal;


										//print_r(json_encode($data['pro_coupon_type_value']));
										//exit;
										unset($sessData['coupon_status']);
										unset($sessData['coupon_code']);
										//$this->session->set_userdata('cart_contents', $sessData);
										$coupStatus[] = 'Coupon Removed!';

									}



								}

							}

							if($data['pro_coupon_type'] === 'percentage'){
								$this->load->model('cart/Cartmodel');
								foreach ($filterArr as $sv) {

									if($sv['id'] == $data['product_id']){

										$actualPrice = $this->Cartmodel->getPrice($sv['id']);

										$dec = $data['pro_coupon_type_value'] / 100;
										$pecValue = $actualPrice['price']  * $dec;

										$sessData[$sv['rowid']]['price'] = $sessData[$sv['rowid']]['price'] + $pecValue;

										$qtyVal = $sessData[$sv['rowid']]['qty'] * $pecValue;

										$sessData[$sv['rowid']]['subtotal'] = $sessData[$sv['rowid']]['subtotal'] + $qtyVal;

										$sessData['cart_total'] = $sessData['cart_total'] + $qtyVal;

										unset($sessData['coupon_status']);
										unset($sessData['coupon_code']);
										//$this->session->set_userdata('cart_contents', $sessData);
										$coupStatus[] = 'Coupon Removed!';

									}


								}

							}




						}

					}
					else{

						if($data['coupon_on'] === 'basket'){

							if($data['coupon_type'] === 'percentage'){
									$dec = $data['coupon_type_value'] / 100;
									$perVal = $sessData['cart_total']  * $dec;
									$sessData['cart_total'] = $sessData['cart_total'] + $perVal;
									unset($sessData['coupon_status']);
									unset($sessData['coupon_code']);
									$this->session->set_userdata('cart_contents', $sessData);
									print_r(json_encode(array('Coupon Removed!')));
									return;
							}
							if($data['coupon_type'] === 'value'){
								$sessData['cart_total'] = $sessData['cart_total'] + $data['coupon_type_value'];
									unset($sessData['coupon_status']);
									unset($sessData['coupon_code']);
									$this->session->set_userdata('cart_contents', $sessData);
									print_r(json_encode(array('Coupon Removed!')));
									return;

							}

						}

						if($data['coupon_on'] === 'category'){

							$proArray = array();
							foreach ($sessData as $key => $value) {
									if(is_array($value)){
										$proArray[$key] = $value;
									}
							}

							$filterArr =array();
							foreach ($proArray as $p => $v) {
									if($p == 'coupon'){

									}
									else{
										$filterArr[] = $v;
									}
							}


							$catArr = array();
							foreach ($filterArr as $k => $c) {
									if($data['category'] == $c['cid']){
										$catArr['cid'] = $c['cid'];
									}
							}

							if($data['coupon_type'] === 'value'){						if($catArr['cid']){

										if($sessData['cart_total'] > $data['coupon_type_value']){

											$sessData['cart_total'] = $sessData['cart_total'] + $data['coupon_type_value'];

											unset($sessData['coupon_status']);
											unset($sessData['coupon_code']);
											$this->session->set_userdata('cart_contents', $sessData);
											print_r(json_encode(array('Coupon Removed!')));
											return;

										}
									}


							}
							if($data['coupon_type'] === 'percentage'){

									if($catArr['cid']){

										if($sessData['cart_total'] && $data['coupon_type_value']){

											$dec = $data['coupon_type_value'] / 100;
											$perVal = $sessData['cart_total']  * $dec;

											$sessData['cart_total'] = $sessData['cart_total'] + $perVal;
											unset($sessData['coupon_status']);
											unset($sessData['coupon_code']);
											$this->session->set_userdata('cart_contents', $sessData);
											print_r(json_encode(array('Coupon Removed!')));
											return;
										}

									}

							}

						}

						if($data['coupon_on'] === 'product'){

							$proArray = array();
							foreach ($sessData as $key => $value) {
								if(is_array($value)){
									$proArray[$key] = $value;
								}
							}
							$filterArr =array();
							foreach ($proArray as $p => $v) {
								$filterArr[] = $v;
							}


							if($data['pro_coupon_type'] === 'free'){
								if($sv['rowid'] === 'free'){
									unset($sessData['coupon_status']);
									unset($sessData['coupon_code']);
									unset($sessData['free']);
									$this->session->set_userdata('cart_contents', $sessData);
									$coupStatus[] = 'Coupon Removed!';
								}

							}

							if($data['pro_coupon_type'] === 'value'){
								foreach ($filterArr as $sv) {

									if($sv['rowid'] == 'free'){

									}
									else{
										if($sv['id'] == $ctID){

											$sessData[$sv['rowid']]['price'] = $sessData[$sv['rowid']]['price'] + $data['pro_coupon_type_value'];

											$qtyVal = $sessData[$sv['rowid']]['qty'] * $data['pro_coupon_type_value'];
											$sessData[$sv['rowid']]['subtotal'] = $sessData[$sv['rowid']]['subtotal'] + $qtyVal;

											$sessData['cart_total'] = $sessData['cart_total'] + $qtyVal;
											unset($sessData['coupon_status']);
											unset($sessData['coupon_code']);
											$this->session->set_userdata('cart_contents', $sessData);
											$coupStatus[] = 'Coupon Removed!';

										}
									}


								}

							}

							if($data['pro_coupon_type'] === 'percentage'){
								$this->load->model('cart/Cartmodel');
								foreach ($filterArr as $sv) {

									if($sv['rowid'] == 'free'){

									}
									else{
										if($sv['id'] == $ctID){

											$actualPrice = $this->Cartmodel->getPrice($sv['id']);

											$dec = $data['pro_coupon_type_value'] / 100;
											$pecValue = $actualPrice['price']  * $dec;

											$sessData[$sv['rowid']]['price'] = $sessData[$sv['rowid']]['price'] + $pecValue;

											$qtyVal = $sessData[$sv['rowid']]['qty'] * $pecValue;

											$sessData[$sv['rowid']]['subtotal'] = $sessData[$sv['rowid']]['subtotal'] + $qtyVal;

											$sessData['cart_total'] = $sessData['cart_total'] + $qtyVal;

											unset($sessData['coupon_status']);
											unset($sessData['coupon_code']);
											$this->session->set_userdata('cart_contents', $sessData);
											$coupStatus[] = 'Coupon Removed!';

										}
									}


								}

							}




						}


					}*/


				}
			}

			//$this->session->set_userdata('cart_contents', $sessData);
			print_r(json_encode($coupStatus));
			//return ;

		}
	}

	function del_exist_coupon($cpcode){

		if($cpcode){

			$this->load->model('Couponmodel');
			$this->load->library('cart');
			$couponData = $this->Couponmodel->coupon_details($cpcode);

			$coupStatus = array();
			$cpData = array();
			$sessData = $this->session->userdata('cart_contents');
			$perVal = "";

			foreach ($couponData as $data) {


				if(( !empty($data['user_id']) && !empty($this->session->userdata('CUSTOMER_ID')) && $data['user_id'] == $this->session->userdata('CUSTOMER_ID') ) or (empty($data['user_id']) && $data['profile_name'] == 'Guest' && empty($this->session->userdata('CUSTOMER_ID'))) or ( empty($data['user_id']) && $data['profile_name'] == 'All Groups' && !empty($this->session->userdata('CUSTOMER_ID')))){

					if($data['coupon_on'] === 'basket'){

						if($data['coupon_type'] === 'percentage'){
								$sessData['cart_total'] = $sessData['cart_total'] + $sessData['coupon_discount'];
								unset($sessData['coupon_status']);
								unset($sessData['coupon_code']);
								unset($sessData['coupon_discount']);
								$this->session->set_userdata('cart_contents', $sessData);
								print_r(json_encode(array('Coupon Removed!')));
								return;
						}
						if($data['coupon_type'] === 'value'){
							$sessData['cart_total'] = $sessData['cart_total'] + $data['coupon_type_value'];
								unset($sessData['coupon_status']);
								unset($sessData['coupon_code']);
								$this->session->set_userdata('cart_contents', $sessData);
								print_r(json_encode(array('Coupon Removed!')));
								return;

						}

					}

					if($data['coupon_on'] === 'category'){

						$proArray = array();
						foreach ($sessData as $key => $value) {
								if(is_array($value)){
									$proArray[$key] = $value;
								}
						}

						$filterArr =array();
						foreach ($proArray as $p => $v) {
								if($p == 'coupon'){

								}
								else{
									$filterArr[] = $v;
								}
						}


						$catArr = array();
						foreach ($filterArr as $k => $c) {
								if($data['category'] == $c['cid']){
									$catArr['cid'] = $c['cid'];
								}
						}

						if($data['coupon_type'] === 'value'){						if($catArr['cid']){

									if($sessData['cart_total'] > $data['coupon_type_value']){

										$sessData['cart_total'] = $sessData['cart_total'] + $data['coupon_type_value'];

										unset($sessData['coupon_status']);
										unset($sessData['coupon_code']);
										$this->session->set_userdata('cart_contents', $sessData);
										print_r(json_encode(array('Coupon Applied!')));
										return;

									}
								}


						}
						if($data['coupon_type'] === 'percentage'){

								if($catArr['cid']){

									if($sessData['cart_total'] && $data['coupon_type_value']){

										$sessData['cart_total'] = $sessData['cart_total'] + $sessData['coupon_discount'];
										unset($sessData['coupon_status']);
										unset($sessData['coupon_code']);
										unset($sessData['coupon_discount']);
										$this->session->set_userdata('cart_contents', $sessData);
										print_r(json_encode(array('Coupon Applied!')));
										return;
									}

								}

						}

					}

					/*if($data['coupon_on'] === 'product'){

						$proArray = array();
						foreach ($sessData as $key => $value) {
							if(is_array($value)){
								$proArray[$key] = $value;
							}
						}
						$filterArr =array();
						foreach ($proArray as $p => $v) {
							if($p == 'free'){

							}
							else{
									$filterArr[] = $v;
								}
						}

						if($data['pro_coupon_type'] === 'free'){
							unset($sessData['coupon_status']);
							unset($sessData['coupon_code']);
							unset($sessData['free']);
							$this->session->set_userdata('cart_contents', $sessData);
							$coupStatus[] = 'Coupon Removed!';

						}

						if($data['pro_coupon_type'] === 'value'){
							foreach ($filterArr as $sv) {
								if($data['category_id'] == $sv['cid'] && $data['product_id'] == $sv['id']){

									$sessData[$sv['rowid']]['price'] = $sessData[$sv['rowid']]['price'] + $data['pro_coupon_type_value'];

									$qtyVal = $sessData[$sv['rowid']]['qty'] * $data['pro_coupon_type_value'];
									$sessData[$sv['rowid']]['subtotal'] = $sessData[$sv['rowid']]['subtotal'] + $qtyVal;

									$sessData['cart_total'] = $sessData['cart_total'] + $qtyVal;
									unset($sessData['coupon_status']);
									unset($sessData['coupon_code']);
									$this->session->set_userdata('cart_contents', $sessData);
									$coupStatus[] = 'Coupon Removed!';

								}

							}

						}

						if($data['pro_coupon_type'] === 'percentage'){
							$this->load->model('cart/Cartmodel');
							foreach ($filterArr as $sv) {
								if($data['category_id'] == $sv['cid'] && $data['product_id'] == $sv['id']){

									$actualPrice = $this->Cartmodel->getPrice($sv['id']);

									$dec = $data['pro_coupon_type_value'] / 100;
									$pecValue = $actualPrice['price']  * $dec;

									$sessData[$sv['rowid']]['price'] = $sessData[$sv['rowid']]['price'] + $pecValue;

									$qtyVal = $sessData[$sv['rowid']]['qty'] * $pecValue;

									$sessData[$sv['rowid']]['subtotal'] = $sessData[$sv['rowid']]['subtotal'] + $qtyVal;

									$sessData['cart_total'] = $sessData['cart_total'] + $qtyVal;

									unset($sessData['coupon_status']);
									unset($sessData['coupon_code']);
									$this->session->set_userdata('cart_contents', $sessData);
									$coupStatus[] = 'Coupon Removed!';

								}

							}

						}

					}*/


				}
			}

			print_r(json_encode($coupStatus));

		}
	}

}
?>
