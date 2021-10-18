<?php

class Invoicemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

//    function getOrder($id) {
//        $data = $this->db
//                        ->from('order')
//                        ->where('order_num', $id)
//                        ->get()->row_array()
//        ;
//        return $data;
//    }
//
//    function getOrderItems($id) {
//        $data = $this->db
//                        ->from('order_item')
//                        ->where('order_id', $id)
//                        ->get()->result_array()
//        ;
//        return $data;
//    }
//
//    function getOrderDetail($id) {
//        $data = $this->db
//                        ->from('order_detail')
//                        ->where('order_id', $id)
//                        ->get()->row_array()
//        ;
//        return $data;
//    }
//
//    function fullOrderDetail($id) {
//        $order = self::getOrder($id);
//        $order['detail'] = self::getOrderDetail($order['order_id']);
//        $order['items'] = self::getOrderItems($order['order_id']);
//        return $order;
//    }
//
//    function generateInvoice($order_number) {
//        $fullOrderDetail = $this->fullOrderDetail($order_number);
//        $this->load->library('m_pdf');
//        $pdf = $this->m_pdf->load();
//        $content = $this->load->view('invoice/invoice', compact('fullOrderDetail'), true);
//        // echo $content;exit;
//        $pdf->WriteHTML($content, 2);
//        $path = $this->config->item('INVOICE_PATH');
//        $file_path = $path . "$order_number.pdf";
//        $pdf->Output($file_path, "F");
//        $fullOrderDetail['content'] = $content;
//        $fullOrderDetail['filename'] = "$order_number.pdf";
//        return $fullOrderDetail;
//    }

    function order_details($order_id) {
        $out = array();

        $rs = array();
        $rs = $this->db->select('*')
                ->from('order')
                ->where('order_id', $order_id)
                ->get();

        if ($rs->num_rows() == 1) {
            $out['order'] = $rs->first_row('array');
        }

        $rs = array();
        $rs = $this->db->select('*')
                ->from('order_detail')
                ->where('order_id', $order_id)
                ->get();

        if ($rs->num_rows() == 1) {
            $out['order_detail'] = $rs->first_row('array');
        }

        $rs = array();
        $rs = $this->db->select('*')
                ->from('order_item')
                ->where('order_id', $order_id)
                ->get();

        if ($rs->num_rows()) {
            $out['order_items'] = $rs->result_array();
        }

        return $out;
    }

}
