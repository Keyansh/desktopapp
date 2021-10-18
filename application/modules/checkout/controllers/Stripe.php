<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stripe extends CI_Controller {

	public function index()
	{
		$this->load->view('product_form');		
	}

	public function check()
	{
		//check whether stripe token is not empty
		if(!empty($_POST['stripeToken']))
		{
			//get token, card and user info from the form
			$token  = $_POST['stripeToken'];
			$name = $_POST['name'];
			$email = $_POST['email'];
			$card_num = $_POST['card_num'];
			$card_cvc = $_POST['cvc'];
			$card_exp_month = $_POST['exp_month'];
			$card_exp_year = $_POST['exp_year'];
			
			//include Stripe PHP library
			require_once APPPATH."third_party/stripe/init.php";
			
			//set api key
			$stripe = array(
			  "secret_key"      => "STRIPE_SECRET_KEY",
			  "publishable_key" => "STRIPE_PUBLISHABLE_KEY"
			);
			
			\Stripe\Stripe::setApiKey($stripe['secret_key']);
			
			//add customer to stripe
			$customer = \Stripe\Customer::create(array(
				'email' => $email,
				'source'  => $token
			));
			
			//item information
			$itemName = "Stripe Donation";
			$itemNumber = "PS123456";
			$itemPrice = 50;
			$currency = "usd";
			$orderID = "SKA92712382139";
			
			//charge a credit or a debit card
			$charge = \Stripe\Charge::create(array(
				'customer' => $customer->id,
				'amount'   => $itemPrice,
				'currency' => $currency,
				'description' => $itemNumber,
				'metadata' => array(
					'item_id' => $itemNumber
				)
			));
			
			//retrieve charge details
			$chargeJson = $charge->jsonSerialize();

			//check whether the charge is successful
			if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)
			{
				//order details 
				$amount = $chargeJson['amount'];
				$balance_transaction = $chargeJson['balance_transaction'];
				$currency = $chargeJson['currency'];
				$status = $chargeJson['status'];
				$date = date("Y-m-d H:i:s");
			
				
				//insert tansaction data into the database
				$dataDB = array(
					'name' => $name,
					'email' => $email, 
					'card_num' => $card_num, 
					'card_cvc' => $card_cvc, 
					'card_exp_month' => $card_exp_month, 
					'card_exp_year' => $card_exp_year, 
					'item_name' => $itemName, 
					'item_number' => $itemNumber, 
					'item_price' => $itemPrice, 
					'item_price_currency' => $currency, 
					'paid_amount' => $amount, 
					'paid_amount_currency' => $currency, 
					'txn_id' => $balance_transaction, 
					'payment_status' => $status,
					'created' => $date,
					'modified' => $date
				);

				if ($this->db->insert('orders', $dataDB)) {
					if($this->db->insert_id() && $status == 'succeeded'){
						$data['insertID'] = $this->db->insert_id();
						$this->load->view('payment_success', $data);
						// redirect('Welcome/payment_success','refresh');
					}else{
						echo "Transaction has been failed";
					}
				}
				else
				{
					echo "not inserted. Transaction has been failed";
				}

			}
			else
			{
				echo "Invalid Token";
				$statusMsg = "";
			}
		}
	}

	public function payment_success()
	{
		$this->load->view('payment_success');
	}

	public function payment_error()
	{
		$this->load->view('payment_error');
	}

	public function help()
	{
		$this->load->view('help');
	}

	function st_process($onum = false){
		require 'vendor/autoload.php';
		$this->load->model('Checkoutmodel');
        $this->load->model('customer/Customermodel');
		$this->load->model('customer/Ordermodel');
		$this->load->library('form_validation');
		
		 //fetch order details
		 $order = $this->Ordermodel->fetchDetails($onum);
		 if (!$order) {
			 $this->utility->show404();
			 return;
		 }

		 \Stripe\Stripe::setApiKey(DWS_STRIPE_SECRET_KEY);
              
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[            
                'name' => 'Consort hardware Order',
                'description' => 'Checkout process for an order.',
                'amount' => (float)($order['order_total'])*100,
                'currency' => 'gbp',            
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => base_url().'checkout/stripe/success/' . $order['order_num'],
            'cancel_url' => base_url().'checkout/failed',
		]);
		
		$data = array();        
        $data['payment_intent'] = $session->payment_intent;                        
        $data['payment_response'] = json_encode($session);        
        $this->db->where('order_id', $order['order_id']);
        $this->db->update('order', $data);

        //render view
        $inner = array();
        $shell = array();
        $inner['order'] = $order;
        $inner['session'] = $session;
        //e($inner);
        $this->load->view('stripeview', $inner);
	}
	function success($order_num){
        $this->load->model('Checkoutmodel');
        $this->load->model('customer/Ordermodel');
        $this->load->library('email');
        $this->load->library('parser');        
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('text');
        $this->load->library('encrypt');
        if($order_num) {
            error_log(print_r($order_num, true), 3, "my-errors.log");
            $order = array();
			$order = $this->Ordermodel->detail($order_num);			
            $orderid = $order['order_id'];            
            error_log(print_r($order, true), 3, "my-errors.log");
            
            /* $data = array();
            $data['is_paid'] = 1;
        	$data['confirmed'] = 1;         
            $this->db->where('order_id', $orderid);
            $this->db->update('order', $data);
            $this->Checkoutmodel->orderConfirmed($order); */
		redirect('checkout/payment/success/' . $order_num);
		}
    }

}
