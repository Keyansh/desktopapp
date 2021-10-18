<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Shipping extends Cms_Controller {

	function __construct() {
		parent::__construct();
	}

	function fetchShippingbyCountry() {		
		$this->load->model('cart/Cartmodel');
		$country = $this->input->post('country', true);
		$variables = $this->Cartmodel->variables(false, $country, 'country');				
		$this->sendHtml($variables);
		exit();
	}

	function fetchUKShipping() {
		$this->load->model('cart/Cartmodel');
		$postcode = $this->input->post('postcode', true);
		$variables = $this->Cartmodel->variables(false, $postcode, 'postcode');
		$this->sendHtml($variables);
		exit();
	}

	function sendHtml($out_variables){
		extract($out_variables);
		$output = array();
		$inner = array();
		$output['status'] = 1;
		$inner['cart_total'] =  $cart_total;
		$inner['shipping'] = $shipping ? $shipping : 0.00;
		$inner['tax'] = $tax;
		$inner['discount'] = 0.00;
		$inner['order_total'] = $order_total;
		$inner['delivery_charge'] = $delivery_charge;
                $inner['vat'] = $vat;
		$inner['vat_order_total'] = $vat_order_total;		
		$output['foot_contents'] = $this->load->view("ajax-shipping-view", $inner, true);
		$output['top_contents'] = $this->load->view("ajax-shipping-top-view", $inner, true);
		$output['last'] = $out_variables;
		echo json_encode($output);		
	}
}

?>
