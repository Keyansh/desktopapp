<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Downloads extends Cms_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Downloadmodel');
        $this->load->model('cms/Pagemodel');
        if (!$this->session->userdata('CUSTOMER_ID')) {
            $this->load->helper('url');
            $this->session->set_userdata('REGENT_REDIR_URL', current_url());
        }
    }

    function index()
    {

        $getAllPdf = array();
        $getAllPdf = $this->Downloadmodel->getAllPdf();

        $inner = array();
        $inner['getAllPdf'] = $getAllPdf;
        $shell['meta_title'] = 'Downloads';
        $shell['contents'] = $this->load->view('pdf-result', $inner, true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }
    function csvdata()
    {
        $unAvailable = [];
        $this->db->select('t1.id,t1.option');
        $this->db->from('attribute_option t1');
        $this->db->join('attribute_varchar t2', 't1.id = t2.value');
        $this->db->group_by("t1.id");
        $query = $this->db->get();
        $data =   $query->result_array();
        $dataSort =  custom_array_coloum($data, 'id', 'option');
        $this->db->select('t1.id,t1.option');
        $this->db->from('attribute_option t1');
        $dataAll =  $this->db->get()->result_array();
        $dataSortAll =  custom_array_coloum($dataAll, 'id', 'option');
        foreach ($dataSortAll as $key => $value) :
            if (!isset($dataSort[$key])) :
                $unAvailable[$key] = $key;
            endif;
        endforeach;
        $this->db->select('t1.option');
        $this->db->from('attribute_option t1');
        $this->db->where_in('t1.id', $unAvailable);
        $this->db->get()->result_array();
        lQ();
    }

    function csvdataAttribute()
    {

        $this->db->select('t1.*');
        $this->db->from('attribute t1');
        $this->db->join('attr_attrset t2', 't2.attr_id = t1.id');
        $d = $this->db->group_by('t1.id')->get()->result_array();
        $ids = array_column($d, 'id');


        $this->db->select('*');
        $this->db->where_not_in('id', $ids);
        $this->db->get('attribute')->result_array();
        lq();
    }
}

// End of search.php
