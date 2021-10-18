<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userjourney extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //function index
    function index()
    {
        $this->load->model('Userjourneymodel');
        $userjourney = array();
        $userjourney = $this->Userjourneymodel->listAll();
        $inner = array();
        $inner['userjourney'] = $userjourney;
        $page = array();
        $page['content'] = $this->load->view('userjourney-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function view($id, $date)
    {

        $this->load->model('Userjourneymodel');
        $inner = array();
        $inner['userjourney'] = getDataArray('logger', array('created_by' => $id, 'comment' => $date));
        $inner['date'] = $date;
        $inner['id'] = $id;
        $page = array();
        $page['content'] = $this->load->view('userjourney-view', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function delete($id, $date)
    {
        $this->load->model('Userjourneymodel');
        $this->Userjourneymodel->delete($id, $date);
        redirect('userjourney');
    }

    public function triggerEmail()
    {
        $this->load->library('email');
        $this->load->library('parser');
        $post = $this->input->post();
        $userData =  getData('user', array('user_id' => $post['userId']));
        $userjourney = getDataArray('logger', array('created_by' => $post['userId'], 'comment' => $post['dataDate']));
        asort($userjourney);
        $categoryData = $productData = array();
        foreach ($userjourney as $key => $item) :
            if ($item['type'] == 'category') :
                $categoryData[$key] = getData('category', 'id', $item['type_id']);
            endif;
            if ($item['type'] == 'product') :
                $product = getData('product', 'id', $item['type_id']);
                $productData[$key] = $product;
                $productData[$key]['product_image'] = getData('prod_img', array('pid' => $product['id'], 'main' => 1));
            endif;
        endforeach;
        $emailData = array();
        $emailData['DATE'] = date("jS F, Y");
        $emailData['BASE_URL'] = base_url();
        $emailData['SITE_URL'] = $this->config->item('site_url');
        $emailData['CATEGORY'] = $categoryData;
        $emailData['PRODUCT'] = $productData;
        $emailData['ADDRESS'] = DWS_ADDRESS;
        $emailData['ADMIN_PHONE'] = DWS_TELLNO;
        $emailData['EMAIL_ADMIN'] = DWS_EMAIL_ADMIN;

        $emailBodyUser = $this->parser->parse('userjourney/emails/user', $emailData, true);
        // e($emailBodyUser);
        // to admin
        $config = array();
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->reply_to(DWS_EMAIL_REPLY_TO);
        $this->email->to($userData['email']);
        $this->email->subject('We noticed you viewing our range');
        $this->email->message($emailBodyUser);
        $status1 = $this->email->send();
        $result['content'] = 'Email not send';
        if ($status1 == true) {
            // if (1 == 1) {
            $data = array();
            $data['email_status'] = 1;
            $this->db->where('comment', $post['dataDate']);
            $this->db->where('created_by', $post['userId']);
            $this->db->update('logger', $data);
            $result['content'] = 'Email send';
        }
        echo json_encode($result);
    }
}
