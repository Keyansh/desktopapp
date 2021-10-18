<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$file_location = dirname(FCPATH) . '/application/third_party/mpdf/vendor/autoload.php';

require_once $file_location;

class Invoice extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('invoicemodel');
    }

    function index($order_num) {
        $result = $this->invoicemodel->generateInvoice($order_num);
    }

    function order_pdf($order_id) {
        $inner = array();
        $inner = $this->invoicemodel->order_details($order_id);
        $html = $this->load->view('order-pdf', $inner, true);
        $footer = "<tr><td style=''> <table width='100%' style='border-collapse: collapse; position: absolute; top: 390px;'> <tr><td style='text-align: center; font-size: 12px; padding: 25px 0px 14px 0; font-weight: 300;'> <p style='margin: 0 0 6px 0;'>Thank you for shopping with Consort hardware</p><p style='margin: 0px;'>Visit us: <a href='#' style='text-decoration: none; color: #e86f1e;'>" . substr(base_url(), 0, -6) . "</a></p></td></tr></table> </td></tr>";
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->SetFooter($footer);
        $this->m_pdf->pdf->WriteHTML($html);
        $filename = 'order.pdf';
        $this->m_pdf->pdf->Output($filename, "D");
    }

}
