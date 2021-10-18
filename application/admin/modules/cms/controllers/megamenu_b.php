<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Megamenu extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    function index() {
        $this->load->model('Megamenumodel');
        $ActiveParents = $this->Megamenumodel->getActiveParentCategories();
        $inner = array();
        $inner['ActiveCategories'] = $ActiveParents;
        $page = array();
        $page['content'] = $this->load->view('megamenu/megamenu-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function subcategory($parent) {
        $this->load->model('Megamenumodel');
        $ActiveSubcategory = $this->Megamenumodel->getActiveSubcategoryByParent($parent, 1);
        $inner['ActiveSubcategory'] = $ActiveSubcategory;
        $inner['parentCategory'] = $parent;
        $page = array();
        $page['content'] = $this->load->view('megamenu/megamenu-subcategory', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function sub_subcategory($parent) {
        $this->load->model('Megamenumodel');
        $ActiveSubcategory = $this->Megamenumodel->getActiveSubcategoryByParent($parent, 2);
        $inner['ActiveSubcategory'] = $ActiveSubcategory;
        $inner['parentCategory'] = $parent;
        $page = array();
        $page['content'] = $this->load->view('megamenu/megamenu-sub-subcategory', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function subcategory_add() {
        $this->load->model('Megamenumodel');
        echo "<pre>";
        print_r($_POST);
        $subcategory = $this->input->post('subcategory', true);
        $parentId = $this->input->post('parentCategory', true);

        foreach ($subcategory as $key => $val) {

            if (isset($_POST['status-' . $val])) {
                if (!isset($_POST['order-' . $val])) {
                    $_POST['order-' . $val] = 0;
                }
                if (isset($_POST['order-' . $val])) {
                    if (trim($_POST['order-' . $val]) == "") {
                        $_POST['order-' . $val] = 0;
                    }
                }



                if ($this->Megamenumodel->getSubCategoryExistenceWithParent($val, $parentId)) {

                    $data = array();
                    $data['sub_cat_id'] = $val;
                    $data['parent_id'] = $parentId;
                    $data['status'] = $_POST['status-' . $val];
                    $data['order'] = $_POST['order-' . $val];
                    $this->Megamenumodel->updateSubCategory($data);
                } else {

                    $data = array();
                    $data['sub_cat_id'] = $val;
                    $data['parent_id'] = $parentId;
                    $data['status'] = $_POST['status-' . $val];
                    $data['order'] = $_POST['order-' . $val];
                    $this->Megamenumodel->insertSubCategory($data);
                }
//                               if($val=="6")
//                {
//                    die('hiii');
//                }
            }
        }
        redirect('cms/megamenu/subcategory/' . $parentId);
    }

    function sub_subcategory_add() {
        $this->load->model('Megamenumodel');
//        echo "<pre>";
//        print_r($_POST);
        $subcategory = $this->input->post('subcategory', true);
        $parentId = $this->input->post('parentCategory', true);
        foreach ($subcategory as $key => $val) {

            if (isset($_POST['status-' . $val])) {
                if (!isset($_POST['order-' . $val])) {
                    $_POST['order-' . $val] = 0;
                }
                if (isset($_POST['order-' . $val])) {
                    if (trim($_POST['order-' . $val]) == "") {
                        $_POST['order-' . $val] = 0;
                    }
                }
                echo $val . '--<br>';
                if ($this->Megamenumodel->getSubCategoryExistenceWithParent($val, $parentId)) {
                    $data = array();
                    $data['sub_cat_id'] = $val;
                    $data['parent_id'] = $parentId;
                    $data['status'] = $_POST['status-' . $val];
                    $data['order'] = $_POST['order-' . $val];
                    $this->Megamenumodel->updateSubCategory($data);
                } else {

                    $data = array();
                    $data['sub_cat_id'] = $val;
                    $data['parent_id'] = $parentId;
                    $data['status'] = $_POST['status-' . $val];
                    $data['order'] = $_POST['order-' . $val];
                    $this->Megamenumodel->insertSubCategory($data);
                }
            }
        }

        redirect('cms/megamenu/sub_subcategory/' . $parentId);
    }

}
