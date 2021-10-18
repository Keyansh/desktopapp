<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//require_once APPPATH . 'third_party/vendor/autoload.php';

use Intervention\Image\ImageManager;

class Order extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Ordermodel');
        $this->load->model('cart/Cartmodel');
        $this->is_admin_protected = TRUE;
    }

    function index() {
        $quotations = array();
        $quotations = $this->Ordermodel->allQuotations();
//        e($quotations);
        $inner = array();
        $page = array();
        $inner['quotations'] = $quotations;
        $page['content'] = $this->load->view('order-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //Function Add Product
    function add() {
//        e($_POST);
        $this->load->model('Ordermodel');
        $this->load->model('user/Userprofilemodel');

        $profileGroups = array();
        $profile_rs = $this->Usermodel->fetchAllProfileGroups();
        $profileGroups[""] = "-Select-";
        foreach ($profile_rs as $rowArr) {
            $profileGroups[$rowArr['id']] = $rowArr['profile_name'];
        }

        $users = array();
        $users = $this->Ordermodel->userList();
//        e($users);
        $inner = array();
        $page = array();
        $inner['users'] = $users;
        $inner['profilegroups'] = $profileGroups;
        $page['content'] = $this->load->view('order-add', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function products_list($cid) {
        $result = $this->Ordermodel->getCategoryProducts($cid);
        if ($result) {
            $result = json_encode($result);
            print_r($result);
        }
    }

    function selectedUser() {
        $response = array();
        $response['msg'] = "";
        $response['status'] = "";
        $response['html'] = "";
        $response['userid'] = "";

        $user_id = $this->input->post('user');
        $price_list = $this->input->post('pricelist');
        $tier_price = $this->input->post('tierprice');

        if (trim($user_id) == "0") {
            $response['status'] = 'error';
            $response['msg'] .= ' .usererror ,';
        }
        if ($response['status'] == "error") {
            echo json_encode($response);
            return false;
        }

//        $this->Ordermodel->setUserSession();
        $response['status'] = 'success';
        $response['html'] = "User id for quick order is $user_id";
        $response['userid'] = $user_id;
        $response['pricelist'] = $price_list;
        $response['tierprice'] = $tier_price;
        echo json_encode($response);
    }

    function selectedProduct() {

        $response = array();
        $response['msg'] = "";
        $response['status'] = "";
        $response['html'] = "";

        $ids = $this->input->post('ids');
        $uid = $this->input->post('uid');
        $pricelist = $this->input->post('pricelist');
        $tierprice = $this->input->post('tierprice');

        if (empty($ids)) {
            $response['status'] = 'error';
            $response['msg'] .= ' .producterror ,';
        }

        if ($response['status'] == "error") {
            echo json_encode($response);
            return false;
        }
        $response['rowid'] = $this->Cartmodel->insertRecord($uid, $pricelist, $tierprice);
        $response['uid'] = $uid;
        $response['pricelist'] = $pricelist;
        $response['tierprice'] = $tierprice;
        $response['status'] = 'success';
        echo json_encode($response);
        exit;
    }

    function view($qid) {
        $quotation = $quotation_items = array();
        $quotation = $this->Ordermodel->fetchById($qid);
        $quotation_items = $this->Ordermodel->OrderedItem($qid);
        $this->load->model('invoice/invoicemodel');
        $this->load->library('email');

        if (!$quotation) {
            $this->utility->show404();
            return;
        }
        $approve_order = $this->input->post('approve_order');
        if ($approve_order) {
            $order_id = $this->Ordermodel->convertQuotationToOrder($quotation, $quotation_items);
            if ($order_id) {
                $this->session->set_flashdata('SUCCESS', 'quotation_converted_order');
                redirect('order');
            }
        }
        $inner = array();
        $page = array();
        $inner['quotation'] = $quotation;
        $inner['quotation_items'] = $quotation_items;
        $page['content'] = $this->load->view('quotation-view', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function delete($qid) {
        $quotation = $quotation_items = array();
        $quotation = $this->Ordermodel->fetchById($qid);
        $quotation_items = $this->Ordermodel->OrderedItem($qid);
        if (!$quotation) {
            $this->utility->show404();
            return;
        }
//        e($quotation,0);
//        e($quotation_items);
        $this->Ordermodel->deleteRecord($qid);
        $this->session->set_flashdata('SUCCESS', 'quotation_deleted');
        redirect('order');
        exit();
    }

    function allorders($filter = 0, $filter1 = 0) {
        $orders = $order_status = array();
        $orders = $this->Ordermodel->all_orders($filter, $filter1);
        $order_status = $this->Ordermodel->listAllStatus(1);

        $inner = array();
        $page = array();
        $inner['orders'] = $orders;
        $inner['order_status'] = $order_status;
        $page['content'] = $this->load->view('allorder-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function viewOrder($oid) {
        $order = $order_items = $order_detail = $order_status = array();
        $order = $this->Ordermodel->orderById($oid);
        $order_items = $this->Ordermodel->orderItemById($oid);
        $this->load->model('catalog/productmodel');
        foreach ($order_items as $key => $item) {
            $images = $this->productmodel->productImages($item['product_id']);
            $images = array_map(function($img) {
                return $img['img'];
            }, $images);
            $order_items[$key]['images'] = $images;
        }
        $order_detail = $this->Ordermodel->orderDetailById($oid);
        if (!$order) {
            $this->utility->show404();
            return;
        }
        $order_status = $this->Ordermodel->listAllStatus(1);

        $inner = array();
        $page = array();
        $inner['order'] = $order;
        $inner['order_detail'] = $order_detail;
        $inner['order_items'] = $order_items;
        $inner['order_status'] = $order_status;
        $page['content'] = $this->load->view('order-view', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function deleteOrder($oid) {
        $order = $order_items = array();
        $order = $this->Ordermodel->orderById($oid);
        $order_items = $this->Ordermodel->orderItemById($oid);
        if (!$order) {
            $this->utility->show404();
            return;
        }
        $this->Ordermodel->deleteOrderRecord($oid);
        $this->session->set_flashdata('SUCCESS', 'order_deleted');
        redirect('order/allorders');
        exit();
    }

    function image($order_item_id, $orient) {
        $orient = urldecode($orient);
        $order_item = $this->Ordermodel->orderItemByItemId($order_item_id);
        $product_img_url = $this->config->item('ORDER_URL') . $order_item['order_id'] . '/product_images//';
        $product_img_path = $this->config->item('ORDER_PATH') . $order_item['order_id'] . '/product_images//';
        $product_logo_url = $this->config->item('ORDER_URL') . $order_item['order_id'] . '/logo_images//';
        $product_logo_path = $this->config->item('ORDER_PATH') . $order_item['order_id'] . '/logo_images//';
        $orientations = json_decode($order_item['order_item_orientation'], true);
        // ee($orientations);
        foreach ($orientations as $product_img => $orientations):
            if ($orient != $product_img) {
                continue;
            }
            $image_file = $product_img_path . $product_img;
            $manager = new ImageManager(array('driver' => 'gd'));
            $image = $manager->make($image_file)->resize(375, 460);
            // ee($manager);
            foreach ($orientations as $orientation):
                // ee($orientation);
                $img = explode('/', $orientation['img']);
                $img = end($img);
                $image_file = $product_logo_path . $img;
                $height = (int) $orientation['height'];
                $width = (int) $orientation['width'];
                // ee($image_file);
                $layers = $manager->make($image_file)->resize($width, $height);
                $layers->rotate($orientation['angle']);
                $left = (int) $orientation['left'];
                // $left = 0;
                $top = (int) $orientation['top'];
                $image->insert($layers, 'top-left', $left, $top);
            endforeach;
            echo $image->response('png');
        endforeach;
    }

    function uploadedImage($order_item_id, $orient, $index) {
        $orient = urldecode($orient);
        $order_item = $this->Ordermodel->orderItemByItemId($order_item_id);
        $product_img_url = $this->config->item('ORDER_URL') . $order_item['order_id'] . '/product_images//';
        $product_img_path = $this->config->item('ORDER_PATH') . $order_item['order_id'] . '/product_images//';
        $product_logo_url = $this->config->item('ORDER_URL') . $order_item['order_id'] . '/logo_images//';
        $product_logo_path = $this->config->item('ORDER_PATH') . $order_item['order_id'] . '/logo_images//';
        $orientations = json_decode($order_item['order_item_orientation'], true);
        // ee($orientations);
        $orientations = isset($orientations[$orient]) ? $orientations[$orient] : null;
        if (!$orientations)
            return;
        $orientation = isset($orientations[$index]) ? $orientations[$index] : null;
        if (!$orientation) {
            return;
        }
        $img = explode('/', $orientation['img']);
        $img = end($img);
        $image_file = $product_logo_path . $img;
        $height = (int) $orientation['height'];
        $width = (int) $orientation['width'];
        $manager = new ImageManager(array('driver' => 'gd'));
        $image = $manager->make($image_file)->resize($width, $height);
        echo $image->response('png');
    }

    function abandonorders() {
        $abandonorder = $emailtemplate = array();
        $abandonorder = $this->Ordermodel->allAbandonOrder();
        $emailtemplate = $this->Ordermodel->emailTemplate();
//        ee($emailtemplate);
        $inner = array();
        $page = array();
        $inner['orders'] = $abandonorder;
        $inner['emailtemplate'] = $emailtemplate;
        $page['content'] = $this->load->view('abandon-order', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function viewAbandonOrder($oid) {
        $order = $order_items = $user_detail = array();
        $order = $this->Ordermodel->abandonOrderById($oid);
        $order_items = $this->Ordermodel->abandonOrderItemById($oid);
        $this->load->model('catalog/productmodel');
        foreach ($order_items as $key => $item) {
            $images = $this->productmodel->productImages($item['product_id']);
            $images = array_map(function($img) {
                return $img['img'];
            }, $images);
            $order_items[$key]['images'] = $images;
        }
        if (!$order) {
            $this->utility->show404();
            return;
        }
        $user_detail = $this->Ordermodel->abandonUserDetailById($order);

        $inner = array();
        $page = array();
        $inner['order'] = $order;
        $inner['user_detail'] = $user_detail;
        $inner['order_items'] = $order_items;
//        ee($inner);
        $page['content'] = $this->load->view('abandon-order-view', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function deleteAbandonOrder($oid) {
        $order = $order_items = array();
        $order = $this->Ordermodel->abandonOrderById($oid);
        $order_items = $this->Ordermodel->abandonOrderItemById($oid);
        if (!$order) {
            $this->utility->show404();
            return;
        }
        $this->Ordermodel->deleteAbandonOrderRecord($oid);
        $this->session->set_flashdata('SUCCESS', 'order_deleted');
        redirect('order/abandonorders');
        exit();
    }

    function croneSave() {
        $this->load->library('form_validation');
        $this->load->model('ordermodel');
        $this->load->library('email');

        $response = array();
        $response['msg'] = "";
        $response['status'] = "";
        $response['html'] = "";

        $date_time = $this->input->post('date_time');
        $template_id = $this->input->post('template_id');


        if (trim($date_time) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .datetimeerror ,';
        }
        if (trim($template_id) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .templateerror ';
        }

        if ($response['status'] == "error") {
            echo json_encode($response);
            return false;
        }

        $this->ordermodel->insertCroneRecord();
        $response['status'] = 'success';
        $response['html'] = 'Email notification set.';

        echo json_encode($response);
    }

    function export_orders_csv() {
        $from_date = $this->input->post('from_date');
        $till_date = $this->input->post('till_date');
        $order_status = $this->input->post('order_status');

        $from_date = explode('/', $from_date);
        $till_date = explode('/', $till_date);

        $from_date = $from_date[2] . '-' . $from_date[1] . '-' . $from_date[0];
        $till_date = $till_date[2] . '-' . $till_date[1] . '-' . $till_date[0];
        $where = '';
        if ($order_status != '0') {
            $where = " and  br_order.status = '$order_status'";
        }
        $sql = 'SELECT `br_order`.`order_num` as "Order Number",
                        `br_order_detail`.`b_first_name` as "Billing First Name",
                        `br_order_detail`.`b_last_name` as "Billing Last Name",
                        `br_order_detail`.`email` as "Billing Email",
                        `br_order_detail`.`b_address1` as "Billing Address",
                        `br_order_detail`.`b_city` as "Billing City",
                        `br_order_detail`.`b_county` as "Billing State",
                        `br_order_detail`.`b_postcode` as "Billing Postcode",
                        `br_order_detail`.`b_country` as "Billing Country",
                        `br_order_detail`.`b_phone` as "Billing Phone",
                        `br_order_detail`.`s_first_name` as "Shipping First Name",
                        `br_order_detail`.`s_last_name` as "Shipping Last Name",
                        `br_order_detail`.`s_address1` as "Shipping Address",
                        `br_order_detail`.`s_city` as "Shipping City",
                        `br_order_detail`.`s_county` as "Shipping State",
                        `br_order_detail`.`s_postcode` as "Shipping Postcode",
                        `br_order_detail`.`s_country` as "Shipping Country",
                        `br_order_detail`.`s_phone` as "Shipping Phone",
                        `br_order_item`.`product_id` as "Product Id",
                        `br_product`.`sku` as "SKU",
                        `br_order_item`.`order_item_name` as "Item Name",
                        `br_brand`.`name` as "Brand",
                        `br_order_item`.`order_item_price` as "Item Price",
                        `br_order_item`.`order_item_qty` as "Item Quantity",
                        `br_order_item`.`order_item_desc` as "Item Description",
                        `br_order`.`order_total` as "Order Total",
                        `br_order`.`vat` as "VAT",
                        `br_order`.`shipping` as "Shipping",
                        `br_order`.`status` as "Status"
                        FROM (`br_order`)
                        JOIN `br_order_item` ON `br_order_item`.`order_id` = `br_order`.`order_id`
                        JOIN `br_order_detail` ON `br_order_detail`.`order_id` = `br_order`.`order_id`
                        JOIN `br_product` ON `br_product`.`id` = `br_order_item`.`product_id`
                        LEFT JOIN `br_brand` ON `br_brand`.`id` = `br_product`.`bid`
                        WHERE date(br_order.order_date) >= "' . $from_date . '"
                        AND date(br_order.order_date) <= "' . $till_date . '"' . $where;


//        e( $sql );

        $rs = $this->db->query($sql);
//e($rs);
        $file_download = '';

        if ($rs->num_rows()) {
            $this->load->dbutil();
            $this->load->helper('download');
            $report_name = 'orders.csv';
            $csv_data = $this->dbutil->csv_from_result($rs);
            $report_path = $this->config->item('ADMIN_REPORT_CSV_PATH');
            $fileName = $report_path . $report_name;
            $fileWrite = fopen($fileName, 'w');
            fwrite($fileWrite, $csv_data);
            fclose($fileWrite);
            $file_download = $this->config->item('ADMIN_REPORT_CSV_URL') . $report_name;
        }

        if ($file_download == '') {
            echo 'no-data';
        } else {
            echo json_encode(array('report_file' => $file_download));
        }
        exit;
    }

    function multi_order_pdf() {
        $arr = $this->input->post('arr');
        $arr = json_decode($arr);

        $this->session->set_flashdata('multiorder_pdf', $arr);
    }

    function multi_order_pdf_download() {
        $this->load->library('M_pdf');
        $arr = $this->session->flashdata('multiorder_pdf');

        if ($arr) {
            $page_counter = count($arr);

            foreach ($arr as $item) {
                $inner = array();
                $inner = $this->Ordermodel->order_details($item);
                $page_counter--;
                $inner['page_counter'] = $page_counter;

                $html = $this->load->view('order-pdf', $inner, true);
                $footer = "<tr><td style=''> <table width='100%' style='border-collapse: collapse; position: absolute; top: 390px;'> <tr><td style='text-align: center; font-size: 12px; padding: 25px 0px 14px 0; font-weight: 300;'> <p style='margin: 0 0 6px 0;'>Thank you for shopping with Consort hardware</p><p style='margin: 0px;'>Visit us: <a href='#' style='text-decoration: none; color: #e86f1e;'>" . site_url() . "</a></p></td></tr></table> </td></tr>";

                $this->m_pdf->pdf->SetFooter($footer);
                $this->m_pdf->pdf->WriteHTML($html);
            }
            $filename = 'Multiple_Orders.pdf';
            $this->m_pdf->pdf->Output($filename, "D");
        }
    }

    function orderstatus() {
        $orderstatus = array();
        $orderstatus = $this->Ordermodel->listAllStatus();

        $inner = array();
        $inner['orderstatus'] = $orderstatus;

        $page['content'] = $this->load->view('status-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function add_status() {
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('label', 'Label', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('status-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Ordermodel->insertStatusRecord();
            $this->session->set_flashdata('SUCCESS', 'status_added');

            redirect("order/orderstatus", 'location');
            exit();
        }
    }

    function edit_status($id) {
        $this->load->library('form_validation');
        $this->load->helper('form');

        $status = array();
        $status = $this->Ordermodel->getstatusdetails($id);
        if (!$status) {
            $this->utility->show404();
            return;
        }
        //validation check
        $this->form_validation->set_rules('label', 'Label', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['status'] = $status;
            $page['content'] = $this->load->view('status-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Ordermodel->updateStatusRecord($status);
            $this->session->set_flashdata('SUCCESS', 'status_updated');

            redirect("order/orderstatus", 'location');
            exit();
        }
    }

    function enable_status($id) {
        $status = array();
        $status = $this->Ordermodel->getstatusdetails($id);
        if (!$status) {
            $this->utility->show404();
            return;
        }
        $data = array();
        $data['is_active'] = 1;
        $data['updatedon'] = time();
        $this->db->where('id', $status['id']);
        $this->db->update('order_status', $data);

        $this->session->set_flashdata('SUCCESS', 'status_enable');
        redirect("order/orderstatus", 'location');
        exit();
    }

    function disable_status($id) {
        $status = array();
        $status = $this->Ordermodel->getstatusdetails($id);
        if (!$status) {
            $this->utility->show404();
            return;
        }
        $data = array();
        $data['is_active'] = 0;
        $data['updatedon'] = time();
        $this->db->where('id', $status['id']);
        $this->db->update('order_status', $data);

        $this->session->set_flashdata('SUCCESS', 'status_disable');
        redirect("order/orderstatus", 'location');
        exit();
    }

    function update_status() {
//        $all_userdata = $this->session->all_userdata();
        $status = array();
        $ostatus = $this->input->post('ostatus');
        $oid = $this->input->post('oid');
        if ($this->session->userdata('USER_ID')) {
            if ($ostatus == 'Processed') {
                $order = array();
                $order['approved_by'] = $this->session->userdata('USER_ID');
                $this->db->where('order_id', $oid);
                $this->db->update('order', $order);
            }
        }
        $data = array();
        $data['status'] = $ostatus;
        $data['status_updated_on'] = time();
        $this->db->where('order_id', $oid);
        $this->db->update('order', $data);
        $status['success'] = 'success';
        $status['msg'] = "Order status updated as $ostatus successfully";
        echo json_encode($status);
        exit;
    }

}

?>
