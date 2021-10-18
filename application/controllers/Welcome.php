<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function index() {

//        $this->load->library('encrypt');
//        echo $this->encrypt->encode('123456');
//        e($this->encrypt->decode('UGcDYQNg'));

        $this->load->model('Settingsmodel');
        $this->load->model('Pagemodel');
        $this->load->helper('text');

        //Page Alias
        $alias = 'homepage';
        //Get Page Details
        $page = array();
        $page = $this->Pagemodel->getDetails($alias);

        if (!$page) {
            $this->utility->show404();
            return;
        }
//        $this->cms->setPage($page);


        //Get Page Blocks
        $blocks = array();
        $blocks = $this->Pagemodel->getPageBlocks($page['page_id']);

        //Compiled blocks
        $compiled_blocks = array();
        $compiled_blocks = $this->Pagemodel->compiledBlocks($page, $blocks);


        //Variables
        $inner = array();
        $inner['page'] = $page;

        foreach ($compiled_blocks as $key => $val) {
            $inner[$key] = $val;
        }

        //Compile page template
        echo $this->Pagemodel->compiledPage($page, $inner);
        exit();
    }

    function set_inclusive_exclusive_session() {
        $this->session->unset_userdata('SELECTED_VAT');

        $session['SELECTED_VAT'] = $this->input->post('vat');
        $this->session->set_userdata($session);

        $response = array();
        $response['status'] = TRUE;
        $response['message'] = 'VAT prices updated';
        echo json_encode($response);
    }
    
    function enterPfiles(){
        $prds = $this->db->select('*')->where('mini_guide is NOT NULL')->get('product')->result_array();
        foreach($prds as $prditem){
            $datappd = array(
                    'product_id' => $prditem['id'],
                    'pdf'  => $prditem['mini_guide']
            );
            $this->db->insert('product_pdf', $datappd);
        }
        e('data added');
    }

    function stripecallback() {  
        $this->load->model('customer/Ordermodel');
        $this->load->model('checkout/Checkoutmodel');        
        $this->load->library('email');
        $this->load->library('parser');        
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('text');
        $this->load->library('encrypt');                

        $body = @file_get_contents('php://input');
        $event_json = json_decode($body,true);
        error_log(print_r($event_json,true), 3, "custom.log"); 
        
        if ($event_json['type'] == 'charge.succeeded') {   
                $pi =  $event_json['data']['object']['payment_intent'];
                if(!empty($pi)){                       
                    $order = array();
                    $order = $this->Ordermodel->fetchByPaymentIntend($pi);    
                    if(!empty($order)){
                            error_log(print_r($order,true), 3, "custom.log");                           
                            //update your database and emails as well. 
                            $data = array();
                            $data['is_paid'] = 1;
                            $data['confirmed'] = 1;
                            $data['transaction_no'] = $pi;                            
                            $this->db->where('order_id', $order['order_id']);
                            $this->db->update('order', $data);
                            $this->Checkoutmodel->orderConfirmed($order);      
                            echo $order['order_id'];
                    } else {
                            echo 'Order not found';
                    }
                }  else {
                    echo 'No payment intent!';                
                }
        } else {
                echo 'No payment succeeded!';
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */