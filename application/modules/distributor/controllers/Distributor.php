<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Distributor extends Cms_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Distributormodel');
        $this->load->model('cms/Pagemodel');
    }

    public function index()
    {
        $status = $this->cmscore->loadPage($this);
        if (!$status) {
            return;
        }
        extract($status);
        $file_name = $page['page_uri'];
        $file_path = "application/views/themes/" . THEME . "/cms/" . $file_name . ".php";
        $page = array();
        $page = $this->Pagemodel->getDetails($file_name);

        if (!$page) {
            $this->http->show404();
            return;
        }
        $pageId = $page['page_id'];
        $globalBlocks = array();
        $globalBlocks = $this->Pagemodel->getGlobalBlocks(0);
        $compiled_blocks = array();
        $compiled_blocks = $this->Pagemodel->compiledBlocks1($pageId);
        $shell['globalBlocks'] = $globalBlocks;
        $keyword = $this->input->post('keywords');

        $search_result = array();

        $search_result = $this->Distributormodel->searchKeyWord($keyword);

        $inner = array();
        $inner['blocks'] = $compiled_blocks;
        $inner['search_result'] = $search_result;
        $inner['keywords'] = $this->input->post('keywords');
        $shell['contents'] = $this->load->view('distributor-result', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    public function HomepageSuppliers()
    {

        $keyword = $this->input->post('keywords');
        $search_result = $this->Distributormodel->searchKeyWord($keyword);

        $output = '';
        if ($search_result) {
            $i = 0;
            foreach ($search_result as $iteam) {
                if (str_replace(",", "", $iteam['miles'])  <=  25) {
                    $i = 1;
                    $output .= '<div class="col-xs-12 col-sm-4 keysearch-main">';
                    $output .= '<div class="col-xs-12 keysearch-main-inner">';
                    $output .= '<p class="key-title">' . $iteam["distribution_name"] . '</p>';
                    $output .= '<p class="key-title-1"> <span>' . $iteam["distribution_location"] . '</span><span>' . $iteam["distribution_city"] . '</span><span>' . $iteam["distribution_county"] . '</span><span>' . $iteam["distribution_pcode"] . '</span>' . '</p>';
                    $output .= '<p class="key-title-2">' . $iteam["distribution_country"] . '</p>';
                    if($iteam["distribution_phone"]){
                    $output .= '<p class="key-title-3">Phone</p>';
                    $output .= '<p class="key-title-4">' . $iteam["distribution_phone"] . '</p>';
                    }
                    if($iteam["distribution_email"]){
                    $output .= '<p class="key-title-3">Email</p>';
                    $output .= '<p class="key-title-4">' . $iteam["distribution_email"] . '</p>';
                    }
                    $output .= '<p class="key-title-3">Miles</p>';
                    $output .= '<p class="key-title-4">' . $iteam["miles"] . '</p>';
                    $output .= '<p class="find-us"><a href="#" class="lpr-directions"  data-to-lat="'.$iteam["distribution_latitude"].'" data-to-lng="'.$iteam["distribution_longitude"].'" data-from-lat="'.$iteam["postcode"]["latitude"] .'" data-from-lng="'.$iteam["postcode"]["longitude"].'">Click to Find Us</a></p>';
                    $output .= '</div>';
                    $output .= '</div>';
                }
            }
            if ($i == 0) {
                echo '<p class="noresult-dist"> No Supplier </p>';
            }
        } else {
            $output .= '<div>No Supplier </div>';
        }
        echo $output;
    }

    public function postcodes()
    {
        $search1 = $_POST['term'];
        $search = str_replace(' ', '', $search1);
        if (!isset($search1)) {
            $fetchData = $this->db->select('*')->order_by('postcode', 'ASC')->limit(5)->get('postcodelatlng')->result_array();
        } else {
            $fetchData = $this->db->like('replace(postcode," ","")', $search)->limit(5)->get('postcodelatlng')->result_array();
        }
        $data = array();
        $rows = $fetchData;
        foreach ($rows as $row) {
            $data[] = array("id" => $row['id'], "text" => $row['postcode']);
        }
        echo json_encode($data);
    }
}

// End of search.php
