<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Productmodel');
        $this->is_admin_protected = TRUE;
    }

//******************************************* validation start******************************************
    //validation for product image thumbnail
//    function valid_images($str) {
//        if (!isset($_FILES['image']) || $_FILES['image']['size'] == 0 || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
//            $this->form_validation->set_message('valid_images', 'The Product Image field is required.');
//            return FALSE;
//        }
//
//        $imginfo = @getimagesize($_FILES['image']['tmp_name']);
//
//        if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
//            $this->form_validation->set_message('valid_images', 'Only GIF, JPG and PNG Images are accepted');
//            return FALSE;
//        }
//        return TRUE;
//    }
//
//    //function for edit valid image
//    function validImage($str) {
//        if ($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
//
//            $imginfo = @getimagesize($_FILES['image']['tmp_name']);
//            if (!$imginfo) {
//                $this->form_validation->set_message('validImage', 'Only image files are allowed');
//                return false;
//            }
//
//            if (!($imginfo[2] == 1 || $imginfo[2] == 2 || $imginfo[2] == 3 )) {
//                $this->form_validation->set_message('validImage', 'Only GIF, JPG and PNG Images are accepted.');
//                return FALSE;
//            }
//        }
//        return TRUE;
//    }
    //****************************************** end of validation  ************************************************

    /* function index($offset = 0) {
      $this->load->model('Productmodel');
      $this->load->model('Categorymodel');
      $this->load->library('pagination');
      $this->load->library('form_validation');
      $this->load->helper('form');

      //Setup pagination
      $perpage = 10;

      // Initialize empty array.
      $config = array();

      //Get all Product
      $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;

      $products = array();
      $pName = "";
      $where = "";
      $cName = "";
      $sku = "";
      $price = "";
      $status = "";
      $from = "";
      $to = "";


      if($this->input->get('filter') == 'Filter'){

      if(!empty($this->input->get('pname')))
      {
      $pName = $this->input->get('pname');
      if(!empty($where))
      {
      $where .= " AND t1.name LIKE '$pName'";
      }
      else{
      $where = "t1.name LIKE '$pName'";
      }
      }

      if(!empty($this->input->get('cname')))
      {
      $cName = $this->input->get('cname');
      if(!empty($where))
      {
      $where .= " AND t3.name LIKE '$cName'";
      }
      else{
      $where = "t3.name LIKE '$cName'";
      }

      }

      if(!empty($this->input->get('sku')))
      {
      $sku = $this->input->get('sku');
      if(!empty($where))
      {
      $where .= " AND t1.sku LIKE '$sku'";
      }
      else{
      $where = "t1.sku LIKE '$sku'";
      }

      }

      if(!empty($this->input->get('price')))
      {
      $price = $this->input->get('price');
      if(!empty($where))
      {
      $where .= " AND t1.price = $price";
      }
      else{
      $where = "t1.price = $price";
      }

      }

      if($this->input->get('status') )
      {
      $status = $this->input->get('status');
      if(!empty($where))
      {
      $where .= " AND t1.is_active = $status";
      }
      else{
      $where = "t1.is_active = $status";
      }

      }

      if($this->input->get('status') == 0 && $this->input->get('status') != '')
      {
      $status = $this->input->get('status');
      if(!empty($where))
      {
      $where .= " AND t1.is_active = $status";
      }
      else{
      $where = "t1.is_active = $status";
      }
      }


      if(!empty($this->input->get('from')))
      {
      $from = $this->input->get('from');
      if(!empty($where))
      {
      $where .= " AND DATE_FORMAT(t1.added_on, '%Y-%m-%d') >= '$from'";
      }
      else{
      $where = "DATE_FORMAT(t1.added_on, '%Y-%m-%d') >= '$from'";
      }

      }
      if(!empty($this->input->get('to')))
      {
      $to = $this->input->get('to');
      if(!empty($where))
      {
      $where .= " AND DATE_FORMAT(t1.added_on, '%Y-%m-%d') <= '$to'";
      }
      else{
      $where = "DATE_FORMAT(t1.added_on, '%Y-%m-%d') <= '$to'";
      }

      }
      if($where){
      $total_row = $this->Productmodel->countFilter($where);
      }
      else{
      $total_row = $this->Productmodel->countAll();
      }

      $products = $this->Productmodel->filterProducts($page, $perpage, $where);


      }
      else
      {
      $total_row = $this->Productmodel->countAll();
      $products = $this->Productmodel->listAll($page, $perpage);
      }

      $total_row = $this->Productmodel->countAll();
      $products = $this->Productmodel->listAll($page, $perpage);
      $config['base_url'] = base_url()."catalog/product/index";
      $config['total_rows'] = $total_row;
      $config['per_page'] = $perpage;
      $config["uri_segment"] = 4;
      $choice = $config["total_rows"] / $config["per_page"];
      $config["num_links"] = round($choice);
      $this->pagination->initialize($config);

      //render view
      $inner = array();
      $inner['products'] = $products;
      $inner['pagination'] = $this->pagination->create_links();
      $page = array();
      $page['content'] = $this->load->view('product-index', $inner, TRUE);
      $this->load->view('shell', $page);
      } */
    function index() {

        $this->load->model('Productmodel');
        $this->load->model('Categorymodel');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //Setup pagination
        $perpage = 10;

        // Initialize empty array.
        $config = array();

        //Get all Product
        //$page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
        $page = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

        $products = array();
        $pName = "";
        $where = "";
        $cName = "";
        $sku = "";
        $price = "";
        $status = "";
        $from = "";
        $to = "";
        $queryString = '';

        if ($this->input->post('filter') == 'Filter') {

            if (!empty($this->input->post('pname'))) {
                $pName = $this->input->post('pname');

                if ($queryString) {
                    $queryString = "&pname=$pName";
                } else {
                    $queryString = "&pname=$pName";
                }

                if (!empty($where)) {
                    $where .= " AND t1.name LIKE '$pName'";
                } else {
                    $where = "t1.name LIKE '$pName'";
                }
            }

            if (!empty($this->input->post('cname'))) {
                $cName = $this->input->post('cname');

                if ($queryString) {
                    $queryString = "&cname=$cName";
                } else {
                    $queryString = "&cname=$cName";
                }

                if (!empty($where)) {
                    $where .= " AND t3.name LIKE '$cName'";
                } else {
                    $where = "t3.name LIKE '$cName'";
                }
            }

            if (!empty($this->input->post('sku'))) {
                $sku = $this->input->post('sku');
                if (!empty($where)) {
                    $where .= " AND t1.sku LIKE '$sku'";
                } else {
                    $where = "t1.sku LIKE '$sku'";
                }
            }

            if (!empty($this->input->post('price'))) {
                $price = $this->input->post('price');
                if (!empty($where)) {
                    $where .= " AND t1.price = $price";
                } else {
                    $where = "t1.price = $price";
                }
            }

            if ($this->input->post('status')) {
                $status = $this->input->post('status');
                if (!empty($where)) {
                    $where .= " AND t1.is_active = $status";
                } else {
                    $where = "t1.is_active = $status";
                }
            }

            if ($this->input->post('status') == 0 && $this->input->post('status') != '') {
                $status = $this->input->post('status');
                if (!empty($where)) {
                    $where .= " AND t1.is_active = $status";
                } else {
                    $where = "t1.is_active = $status";
                }
            }


            if (!empty($this->input->post('from'))) {
                $from = $this->input->post('from');
                if (!empty($where)) {
                    $where .= " AND DATE_FORMAT(t1.added_on, '%Y-%m-%d') >= '$from'";
                } else {
                    $where = "DATE_FORMAT(t1.added_on, '%Y-%m-%d') >= '$from'";
                }
            }
            if (!empty($this->input->post('to'))) {
                $to = $this->input->post('to');
                if (!empty($where)) {
                    $where .= " AND DATE_FORMAT(t1.added_on, '%Y-%m-%d') <= '$to'";
                } else {
                    $where = "DATE_FORMAT(t1.added_on, '%Y-%m-%d') <= '$to'";
                }
            }
        }

        if ($this->input->get('per_page') or empty($this->input->get('per_page'))) {

            if (!empty($this->input->get('pname'))) {
                $pName = $this->input->get('pname');

                if ($pName) {
                    $queryString .= "&pname=$pName";
                }


                if (!empty($where)) {
                    $where .= " AND t1.name LIKE '$pName'";
                } else {
                    $where = "t1.name LIKE '$pName'";
                }
            }

            if (!empty($this->input->get('cname'))) {
                $cName = $this->input->get('cname');

                if ($cName) {
                    $queryString .= "&cname=$cName";
                }

                if (!empty($where)) {
                    $where .= " AND t3.name LIKE '$cName'";
                } else {
                    $where = "t3.name LIKE '$cName'";
                }
            }

            if (!empty($this->input->get('sku'))) {
                $sku = $this->input->get('sku');

                if ($sku) {
                    $queryString .= "&sku=$sku";
                }

                if (!empty($where)) {
                    $where .= " AND t1.sku LIKE '$sku'";
                } else {
                    $where = "t1.sku LIKE '$sku'";
                }
            }

            if (!empty($this->input->get('price'))) {
                $price = $this->input->get('price');

                if ($price) {
                    $queryString .= "&price=$price";
                }

                if (!empty($where)) {
                    $where .= " AND t1.price = $price";
                } else {
                    $where = "t1.price = $price";
                }
            }

            if ($this->input->get('status')) {
                $status = $this->input->get('status');

                if ($status) {
                    $queryString .= "&status=$status";
                }

                if (!empty($where)) {
                    $where .= " AND t1.is_active = $status";
                } else {
                    $where = "t1.is_active = $status";
                }
            }

            if ($this->input->get('status') == 0 && $this->input->get('status') != '') {
                $status = $this->input->get('status');

                if ($status) {
                    $queryString .= "&status=$status";
                }

                if (!empty($where)) {
                    $where .= " AND t1.is_active = $status";
                } else {
                    $where = "t1.is_active = $status";
                }
            }


            if (!empty($this->input->get('from'))) {
                $from = $this->input->get('from');

                if ($from) {
                    $queryString .= "&from=$from";
                }

                if (!empty($where)) {
                    $where .= " AND DATE_FORMAT(t1.added_on, '%Y-%m-%d') >= '$from'";
                } else {
                    $where = "DATE_FORMAT(t1.added_on, '%Y-%m-%d') >= '$from'";
                }
            }
            if (!empty($this->input->get('to'))) {
                $to = $this->input->get('to');

                if ($to) {
                    $queryString .= "&to=$to";
                }

                if (!empty($where)) {
                    $where .= " AND DATE_FORMAT(t1.added_on, '%Y-%m-%d') <= '$to'";
                } else {
                    $where = "DATE_FORMAT(t1.added_on, '%Y-%m-%d') <= '$to'";
                }
            }
        }

        if ($where) {
            $total_row = $this->Productmodel->countFilter($where);
        } else {
            $total_row = $this->Productmodel->countAll();
        }

        $products = $this->Productmodel->filterProducts($page, $perpage, $where);

        $config['base_url'] = base_url() . "catalog/product/index?$queryString";
        $config['total_rows'] = $total_row;
        $config['per_page'] = $perpage;
        $config['page_query_string'] = TRUE;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);
        $this->pagination->initialize($config);

        //render view
        $inner = array();
        $inner['products'] = $products;
        $inner['pagination'] = $this->pagination->create_links();
        $page = array();
        $page['content'] = $this->load->view('product-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function listAll($cid) {
        //Get all Product
        $products = array();
        $products = $this->Productmodel->getCategoryProducts($cid);
        $jsonData = json_encode($products);
        print_r($jsonData);
    }

    //Function Add Product
    function add() {
        $this->load->model('Categorymodel');

        $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('type', 'Product Type', 'trim|required');
        $this->form_validation->set_rules('name', 'Product Name', 'trim|required|callback_valid_product');
        $this->form_validation->set_rules('uri', 'Product Alias', 'trim|strtolower');
        $this->form_validation->set_rules('sku', 'SKU Code', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim');
        $this->form_validation->set_rules('description', 'Product Description', 'trim');
        $this->form_validation->set_rules('is_featured', 'Product Is Featured', 'trim');
        $this->form_validation->set_rules('meta_title', 'Product Meta Title', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Product Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Product Meta Description', 'trim');

        if ($this->input->post('type') == 'config') {
            $this->form_validation->set_rules('childProduct[]', 'Child Product', 'trim|required');
        }
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //fetch category
        $categories = array();
        $catArray = array();
        $catArray[''] = 'Select';
        $categories = $this->Categorymodel->indentedList(0);
        foreach ($categories as $row) {
            $catArray[$row['id']] = str_repeat('&nbsp;', ($row['depth']) * 4) . $row['name'];
        }

        $proType = array('' => 'Select', 'standard' => 'Standard', 'config' => 'Configurable', 'combo' => 'Combo Product');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['categories'] = $catArray;
            $inner['proType'] = $proType;
            $page['content'] = $this->load->view('product-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {

            $this->Productmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'product_added');
            redirect("catalog/product");
        }
    }

    //Function Edit Product
    function edit($pid) {
        $this->load->model('Categorymodel');

        //Get Product Detail
        $product = array();
        $product = $this->Productmodel->details($pid);
        if (!$product) {
            $this->utility->show404();
            return;
        }

        $procat = array();
        $procat = $this->Productmodel->ProductCategory($pid);

        $proimg = array();
        $proimg = $this->Productmodel->productImages($pid);
        
        $prochild = array();
        $prochild = $this->Productmodel->ProductChild($pid);
//        e($prochild);
        
        $prosiblings = array();
        $prosiblings = $this->Productmodel->ProductSiblings($product['category_id'],$pid);
//        e($prosiblings);

//        e($proimg);
        //validation check
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('type', 'Product Type', 'trim|required');
        $this->form_validation->set_rules('name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('uri', 'Product Alias', 'trim|strtolower');
        $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim');
        $this->form_validation->set_rules('description', 'Product Description', 'trim');
        $this->form_validation->set_rules('is_featured', 'Product Is Featured', 'trim');
        $this->form_validation->set_rules('meta_title', 'Product Meta Title', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Product Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Product Meta Description', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //Fetch Categories
        $categories = array();
        $catArray = array();
        $catArray[''] = 'Select';
        $categories = $this->Categorymodel->indentedList(0);
        foreach ($categories as $row) {
            $catArray[$row['id']] = str_repeat('&nbsp;', ($row['depth']) * 4) . $row['name'];
        }

        $proType = array('' => 'Select', 'standard' => 'Standard', 'config' => 'Configurable', 'combo' => 'Combo Product');
        
        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['product'] = $product;
            $inner['categories'] = $catArray;
            $inner['procat'] = $procat;
            $inner['proimg'] = $proimg;
            $inner['proType'] = $proType;
            $inner['prochild'] = $prochild;
            $inner['prosiblings'] = $prosiblings;
            $page = array();
            $page['content'] = $this->load->view('product-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Productmodel->updateRecord($product);
            $this->session->set_flashdata('SUCCESS', 'product_updated');
            redirect("catalog/product");
        }
    }

    //function to enable product
    function enable($pid = false) {
        //Get Product Detail
        $product = array();
        $product = $this->Productmodel->details($pid);
        //print_r($product); exit();
        if (!$product) {
            $this->utility->show404();
            return;
        }
        $this->Productmodel->enableRecord($product);
        $this->session->set_flashdata('SUCCESS', 'product_updated');
        redirect("catalog/product");
        exit();
    }

    //function to disable record
    function disable($pid = false) {
        //Get Product Detail
        $product = array();
        $product = $this->Productmodel->details($pid);

        if (!$product) {
            $this->utility->show404();
            return;
        }

        $this->Productmodel->disableRecord($product);
        $this->session->set_flashdata('SUCCESS', 'product_updated');
        redirect("catalog/product");
        exit();
    }

    //Function Delete product
    function delete($pid) {
        //get product detail
        $product = array();
        $product = $this->Productmodel->details($pid);
        if (!$product) {
            $this->utility->show404();
            return;
        }

        $this->Productmodel->deleteRecord($product);

        $this->session->set_flashdata('SUCCESS', 'product_deleted');

        if ($product['product_type_id'] != 1 && $product['product_type_id'] != 2) {
            redirect("catalog/product");
            exit();
        } else {
            redirect("catalog/product/index/{$product['show_id']}/{$product['product_type_id']}");
            exit();
        }
    }

    function products_list($cid) {
        $result = $this->Productmodel->getCategoryProducts($cid);
        if ($result) {
            $result = json_encode($result);
            print_r($result);
        }
    }

    //update the product sort order
//    function updateorder() {
//
//        $sortOrder = $this->input->post('debugStr', TRUE);
//
//
//        if ($sortOrder) {
//            $sortOrder = trim($sortOrder);
//            $sortOrder = trim($sortOrder, ',');
//            //file_put_contents('facelube.txt',serialize($sortOrder));
//            $chunks = explode(',', $sortOrder);
//
//            $counter = 1;
//            foreach ($chunks as $id) {
//                $data = array();
//                $data['sort_order'] = $counter;
//                $this->db->where('product_id', intval($id));
//                $this->db->update('product', $data);
//                $counter++;
//            }
//        }
//    }
}

?>
