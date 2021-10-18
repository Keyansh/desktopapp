<?php

class Attrset extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('Attrsetmodel');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    function IsUniqueSet($str) {
        $this->db->select('*');
        $this->db->from('attribute_set');
        $this->db->where('name', $str);
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
            $this->form_validation->set_message('IsUniqueSet', 'Attribute set name already in Existing');
            return false;
        }
        return TRUE;
    }

    function index() {

        $attrset = array();
        $attrset = $this->Attrsetmodel->getAllAttrSet();

        $inner = array();
        $inner['attrset'] = $attrset;
        $page = array();
        $page['content'] = $this->load->view('attrset/attrset-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function add() {
        //validation check
        $this->form_validation->set_rules('name', 'Attribute Set', 'trim|required|callback_IsUniqueSet');
        
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //Render View
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('attrset/attrset-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Attrsetmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'attrset_added');
            redirect("catalog/attrset/index");
            exit();
        }
    }

    function edit($asid) {
        $attrset = array();
        $attrset = $this->Attrsetmodel->getAttrSet($asid);
        //validation check
        $this->form_validation->set_rules('name', 'Attribute Set', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        //Render View
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['attrset'] = $attrset;
            $page = array();
            $page['content'] = $this->load->view('attrset/attrset-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Attrsetmodel->updateRecord($attrset);
            $this->session->set_flashdata('SUCCESS', 'attrset_added');
            redirect("catalog/attrset/index");
            exit();
        }
    }

    function assign($asid = 0) {
        $this->load->model('Categorymodel');


        //get all attributes 
        $attrset = array();
        $attrset = $this->Attrsetmodel->getAttrSet($asid);

        $attributes = array();
        $attributes = $this->Attrsetmodel->getAllAttr();

        //get top parent category assigned attributes 
//        $catparentattr = array();
//        $catparentattr = $this->Attrsetmodel->getCatParentAttr($cid);
        //get category all assigned attributes 
        $assignedattr = array();
        $assignedattr = $this->Attrsetmodel->getAssignAttr($asid);

        //render view
        $inner = array();
        $inner['attrset'] = $attrset;
        $inner['attributes'] = self::creatli($attributes, 'ui-state-default', FALSE);
//        $inner['catparentattr'] = self::creatli($catparentattr, 'ui-state-default', FALSE);
        $inner['assignedattr'] = self::creatli($assignedattr, 'ui-state-highlight', TRUE);

        $page = array();
        $page['content'] = $this->load->view('attrset/assignattr-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function attrassign($asid) {
        $status = $this->Attrsetmodel->addAttr($asid);
        if ($status) {
            redirect('/catalog/attrset');
        }
    }

    function creatli($lidata, $classname, $remove) {
        $removehtml = ($remove == 1) ? "<i class='fa fa-trash nn-style-x-pad remove-attr'></i>" : '';
        $li = '';
        if ($lidata != '') {
            foreach ($lidata as $list) {
                $li .= '<li class="' . $classname . '" data-index="' . $list['id'] . '"><input type="hidden" name="attrids[]" value="' . $list['id'] . '" />' . $list['label'] . $removehtml . '</li>';
            }
        }
        return $li;
    }

}

?>