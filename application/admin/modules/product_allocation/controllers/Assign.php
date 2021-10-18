<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assign extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //function catagory
    function category($user_id = Null) {
        $this->load->model('catalog/Categorymodel');
        $categories = array();
        $categories = $this->Categorymodel->rootList();
        //render view
        $inner = array();
        $inner['categories'] = $categories;
        
        if(isset($user_id)){
            $inner['user_id'] = $user_id;
            $inner['categories'] = $categories;
            $this->session->set_userdata('selected_user_id', $user_id);
        }
        else{
            $inner['userNotExist'] = 'User not selected';
            $this->session->set_userdata('selected_user_id', NULL);
        }
        $page = array();
        $page['content'] = $this->load->view('product_allocation/assign/category-list', $inner, TRUE);
        $this->load->view('shell', $page);
        
    }
    //function sub-catagory
    function sub_category($user_id = null, $catid = null) {
        $this->load->model('catalog/Categorymodel');
        $this->load->helper('form');
        //$this->load->library('pagination');
        $inner = array();
        $subCategory = array();
        if(isset($user_id) && isset($catid)){
            $subCategory = $this->Categorymodel->indentedList($catid);
            $categoryName = $this->Categorymodel->getdetails($catid);
            $inner['sub_category'] = $subCategory;
            $inner['user_id'] = $user_id;
            $inner['category_name'] = $categoryName;
        }
        else{
            $inner['user_error'] = 'Please select root category!';
        }
        $inner['current_cat_id'] = $catid;
        $this->session->unset_userdata('selected_category');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('parent_id');
        $this->session->unset_userdata('assignment');

        $page = array();
        $page['content'] = $this->load->view('product_allocation/assign/sub-category-list', $inner, TRUE);
        $this->load->view('shell', $page);
    }
    //function product-list
    function product_list() {
        $post = $this->input->post();
        $userId = $this->input->post('user_id');
        $subCategory = $this->input->post('sub-category');
        $current_cat_id = $this->input->post('current_cat_id');
        $subCategory[] = $current_cat_id;
        $subCategory = implode('-',$subCategory);
        if($this->input->post('assign-product')) {
            redirect("product_allocation/assign/product/$userId/$subCategory");
        }
        elseif($this->input->post('assign-category')) {
            redirect("product_allocation/assign/allcategory/$userId/$subCategory");
        }
        $previous_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        if($previous_url){
            redirect($previous_url);
        }
    }

    function allcategory($userId,$subCategory=false) {
        $this->load->helper('form');
        $this->load->model('Assignmodel');
        $this->load->model('catalog/Productmodel'); 
        $this->load->model('catalog/Categorymodel');
        $inner = array();
        $categories = array();
        $assignedCategory = array();
        $productAssigned = array();
        $hiddSubCat = array();
        if($this->input->post('submit-category') == 'Update')
        {
            $category_ids = $this->input->post('cid');
            $discounts = $this->input->post('discount');
            $specialprices = $this->input->post('specialprice');
            $actives = $this->input->post('select');
            foreach($category_ids as $key => $category_id){
                $data = [];
                $data['user_id'] = $userId;
                $data['catid'] = $category_id;
                $data['discount'] = floatval($discounts[$category_id]);
                $data['special_price'] = floatval($specialprices[$category_id]);
                $data['assign_type'] = 'all';
                $data['active'] = ($actives[$key]) ? 1 : 0;
                if(!$data['discount'] && !$data['special_price']) {
                    continue;
                }
                $this->Assignmodel->handleAllDiscounting($data);
            }
            redirect("product_allocation/assign/allcategory/$userId/$subCategory");
        }
        else {
            $inner['user_id'] = $userId; 
            $inner['subCategory'] = $subCategory;

            $hidSubCategory = explode('-', $subCategory);
            $categories= $this->Assignmodel->categoryDetails($hidSubCategory,$userId);
            // e($categories);
            $assignedCategory = $this->Assignmodel->getAssignedCategory($userId);
            $inner['productAssigned'] = $productAssigned;
            $inner['assignedCategory'] = $assignedCategory;
            $inner['categories'] = $categories;
            $inner['user_id'] = $userId;
            $inner['subCategory'] = $hidSubCategory;
            $inner['productAssigned'] = $this->Assignmodel->existCategory($userId,$hidSubCategory,'manual');
        }
        $page = array();
        $page['content'] = $this->load->view('product_allocation/assign/assign-category', $inner, TRUE);
        $this->load->view('shell', $page);

    }

    function product($user_id,$subCategory=false,$assigned=0){
        $inner = array();
        $this->load->helper('form');
        $this->load->model('Assignmodel');
        $this->load->model('catalog/Productmodel'); 
        $this->load->model('catalog/Categorymodel');

        // echo $this->input->post('submit-products');
        if($this->input->post('submit-products') == 'Update'){
            // e($_POST,1);
            $user_id = $this->input->post('hiddUserID');
            $discount = $this->input->post('discount');
            $specialprice = $this->input->post('specialprice');
            $assign = $this->input->post('select');
            $pid = $this->input->post('pid');
            $cid = $this->input->post('cid');
            $sku = $this->input->post('sku');
            $container = [];
            foreach ($discount as $key => $value) {
                $data = [];
                $data['user_id'] = $user_id;
                $data['product_id'] = $pid[$key];
                $data['catid'] = $cid[$key];
                $data['product_sku'] = $sku[$key];
                $data['discount'] = $discount[$key] ? $discount[$key] : 0;
                $data['special_price'] = $specialprice[$key] ? $specialprice[$key] : 0;
                $data['active'] = $assign[$key] ? 1 : 0;
                if(!$data['discount'] && !$data['special_price']) {
                    continue;
                }
                $result = $this->Assignmodel->handleManualDiscounting($data);
                if($result) {
                    unset($data['product_id']);
                    unset($data['product_sku']);
                    $data['assign_type'] = 'manual';
                    $container[$data['catid']] = $data;
                }
            }
            foreach($container as $cat){
                $this->Assignmodel->handleAllDiscounting($cat);
            }
            redirect("product_allocation/assign/product/$user_id/$subCategory");
        }
        else{
            $assginedProducts = $this->Assignmodel->assignedProducts($user_id,$subCategory); 
            $inner['assginedProducts'] = $assginedProducts;
            $tmp = explode('-',$subCategory);
            $inner['existAssignedCategory'] = $this->Assignmodel->existCategory($user_id,$tmp,'all');
        }
        $inner['user_id'] = $user_id; 
        $inner['subCategory'] = $subCategory;
        $inner['assigned'] = $assigned;
        $page = array();
        $page['content'] = $this->load->view('product_allocation/assign/product-list', $inner, TRUE);
        $this->load->view('shell', $page);

    }


    function product_old($cids=false){
        $inner = array();
        $this->load->helper('form');
        $this->load->model('Assignmodel');
        $this->load->model('catalog/Productmodel'); 
        $this->load->model('catalog/Categorymodel');
        $hiddSubCat = array();

        if($this->input->post('submit-products') == 'Update'){
            

            $hiddSubCat = explode(',', $this->input->post('hiddSubCategory'));

            $this->load->library('form_validation');
            $selectList = array();
            $user_id = array();
            $sku = array();
            $cid = array();
            $discount = array();
            $specialprice = array();

            $selectList = $this->input->post('select');
            $user_id = $this->input->post('user_id');

            $product_id = $this->input->post('pid');
            $sku = $this->input->post('sku');
            $cid = $this->input->post('cid');
            $discount = $this->input->post('discount');
            $specialprice = $this->input->post('specialprice');

            $type = 'Manual';

            $pid = 0;        
            $pid = count($this->input->post('pid'));
            $data = array();

            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";*/

                    
            for ($i=0; $i < $pid; $i++) 
            {
                //Insert Case
                if(!empty($selectList[$i]))
                {

                    $this->db->select('product_id');
                    $this->db->where('user_id', $user_id[$i]);
                    $result = $this->db->get('product_assignment');
                    $arraySet = array();
                    foreach ($result->result_array() as $row) {
                       $arraySet[] = $row['product_id'];
                    }
                    $insertCheck = in_array($selectList[$i], $arraySet);

                    if($insertCheck){
                        // Update
                        $where = '';
                        $data['discount'] = !empty($discount[$i])?$discount[$i]:0;
                        $data['special_price'] = !empty($specialprice[$i])?$specialprice[$i]:0;
                        $data['assign_type'] = $type;
                        $data['active'] = 1;
                        $data['updated_on'] = date('Y-m-d H:i:s');                
                        $updateData = array('discount'=>$data['discount'], 'special_price'=>$data['special_price'],'assign_type'=>$data['assign_type'], 'active'=>$data['active'],'updated_on'=>$data['updated_on']);
                        $where = "user_id = $user_id[$i] AND product_id = $product_id[$i] AND catid = $cid[$i]";
                        $this->Assignmodel->updateRecord($updateData, $where);

                        $this->Assignmodel->existCategoryUPdate($cid[$i], $user_id[$i]);
                    }
                    else{
                        // Insert 
                        $data['user_id'] = $user_id[$i];
                        $data['product_id'] = $product_id[$i];
                        $data['catid'] = $cid[$i];
                        $data['product_sku'] = $sku[$i];
                        $data['discount'] = !empty($discount[$i])?$discount[$i]:0;
                        $data['special_price'] = !empty($specialprice[$i])?$specialprice[$i]:0;
                        $data['assign_type'] = $type;
                        $data['active'] = 1;
                        $data['added_on'] = date('Y-m-d H:i:s');                
                        $insertData = array('user_id'=>$data['user_id'], 'product_id'=>$data['product_id'],'catid'=>$data['catid'],'product_sku'=>$data['product_sku'],'discount'=>$data['discount'],'special_price'=>$data['special_price'], 'assign_type'=>$data['assign_type'], 'active'=>$data['active'], 'added_on'=>$data['added_on']);

                        $this->Assignmodel->insertRecord($insertData);

                        $this->Assignmodel->existCategoryUPdate($cid[$i], $user_id[$i]);
                    }
                }
                else{
                    $d = 0;
                    $this->db->where('user_id', $user_id[$i]);
                    $this->db->where('product_id', $product_id[$i]);
                    $this->db->where('catid', $cid[$i]);                    
                    $this->db->delete('product_assignment');
                }           
           
            }  

            $subCategory = array();
            $parent_id = 0;
            $products = array();
            $subCategory = $hiddSubCat;
            $user_id = $this->input->post('hiddUserID');
            $existCateAssigned = array();
            

            foreach ($subCategory as $catId) {
                if($this->Productmodel->getCategoryProducts($catId)){
                    $products[] = $this->Productmodel->getCategoryProducts($catId);
                }
            }

            foreach ($subCategory as $catIDs) {
                if($this->Assignmodel->categoryAssigned($catIDs)){
                    $existCateAssigned[] = $this->Assignmodel->categoryAssigned($catIDs);
                }
                
            }

            $inner['existAssignedCategory'] = $existCateAssigned;
            $inner['products'] = $products;
            $inner['product_heading'] = $this->Productmodel->getCategoryProducts($this->input->post('hiddParentID'));
            $inner['user_id'] = $user_id; 
            $inner['subCategory'] = $this->input->post('hiddSubCategory');

            $assginedProducts = $this->Assignmodel->assignedProducts($user_id,$subCategory);

            $inner['assginedProducts'] = $assginedProducts;            
            
            foreach ($subCategory as $catId) {
                if($this->Productmodel->getCategoryProducts($catId)){
                    $products[] = $this->Productmodel->getCategoryProducts($catId);
                }                
            }  

            $inner['products'] = $products;
            $inner['product_heading'] = $this->Productmodel->getCategoryProducts($this->input->post('hiddParentID'));
            $inner['user_id'] = $user_id;

        }
        else{
            $subCategory = array();
            $hidSubCategory = '';
            $parent_id = 0;
            $products = array();
            
            if( $this->input->post('parent_id') && $this->input->post('user_id') || $this->input->post('sub-category')){

                $subCategory = $this->input->post('sub-category');
                $subCategory[] = $this->input->post('parent_id');
                $user_id = $this->input->post('user_id');
                $parent_id = $this->input->post('parent_id');
            }else{

                $subCategory = $this->session->userdata('selected_category');
                $user_id = $this->session->userdata('user_id');
                $parent_id = $this->session->userdata('parent_id');
            }           


            $existCateAssigned = array();

            $hidSubCategory = implode(',', $subCategory);

            foreach ($subCategory as $catId) {
                if($this->Productmodel->getCategoryProducts($catId)){
                    $products[] = $this->Productmodel->getCategoryProducts($catId);
                }
            }

            foreach ($subCategory as $catIDs) {
                if($this->Assignmodel->categoryAssigned($catIDs)){
                    $existCateAssigned[] = $this->Assignmodel->categoryAssigned($catIDs);
                }
                
            }
            
            $assginedProducts = $this->Assignmodel->assignedProducts($user_id,$subCategory);
 
            $inner['assginedProducts'] = $assginedProducts;
            $inner['existAssignedCategory'] = $existCateAssigned;
            $inner['products'] = $products;
            $inner['product_heading'] = $this->Productmodel->getCategoryProducts($parent_id);
            $inner['user_id'] = $user_id; 
            $inner['subCategory'] = $hidSubCategory;
            $inner['parentID'] = $parent_id; 
            $this->session->set_userdata('selected_category',$subCategory);
            $this->session->set_userdata('user_id',$user_id);
            $this->session->set_userdata('parent_id',$parent_id);
            $this->session->set_userdata('assignment','Manual');
        }
        // e($inner);
        $page = array();
        $page['content'] = $this->load->view('product_allocation/assign/product-list', $inner, TRUE);
        $this->load->view('shell', $page);

    }

    function customPagination($userID,$cat_ids,$assigned) {
        $this->load->model('catalog/Productmodel');  
        $this->load->model('Assignmodel');
        $search = $this->input->post('search');
        $searchTerm = $search['value'];
        $subCat = explode('-',$cat_ids);
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $data = $this->Assignmodel->assignedProductsDetails($userID,$subCat,$limit,$offset,$searchTerm,$assigned);
        // lQ();
        $data['draw'] = $this->input->post('draw');
        echo json_encode($data);
    }

    function customAssignedPagination() {
        $this->load->model('catalog/Productmodel');  
        $this->load->model('Assignmodel');
        $subCat = $this->session->userdata('selected_category'); 
        $userID = $this->session->userdata('user_id');
        $data = $this->Assignmodel->assignedProd($userID,$subCat);
        $data['draw'] = $this->input->post('draw');
        echo json_encode($data);
    }

    function assigned_products(){
        $this->load->model('catalog/Productmodel');  
        $this->load->model('Assignmodel');
        $subCat = $this->session->userdata('selected_category'); 

        if(!empty($subCat)){
            $userID = $this->session->userdata('user_id');
            $sessionSubcat = $subCat;
            $products = array();
            foreach ($sessionSubcat as $catId) {                
                if($this->Assignmodel->assignedProductsDetails($userID, $catId)){
                        // $products[] = $this->Assignmodel->assignedProductsDetails($userID, $catId);
                }              
            }
            $products[] = [];
            $inner['products'] = $products;
            $inner['product_heading'] = $this->Productmodel->getCategoryProducts($this->session->userdata('parent_id'));
        }

        

        $page = array();
        $page['content'] = $this->load->view('product_allocation/assign/assigned-products', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function assigned_category(){
        $this->load->model('catalog/Productmodel');  
        $this->load->model('Assignmodel');
        $subCat = $this->session->userdata('selected_category'); 

        if(!empty($subCat)){
            $userID = $this->session->userdata('user_id');
            $categories = array();

            $categories = $this->Assignmodel->assignedCategoryDetails($userID,$subCat);

            $inner['categories'] = $categories;
        }        

        $page = array();
        $page['content'] = $this->load->view('product_allocation/assign/assigned-categories', $inner, TRUE);
        $this->load->view('shell', $page);
    }
}

?>