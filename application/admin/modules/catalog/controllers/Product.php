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
//      $this->output->enable_profiler(TRUE);
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
      //print_r($inner['products'] );
      } */
    function index() {
        $curUsr = curUsrId();
        $this->load->model('Productmodel');
        $this->load->model('Categorymodel');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $inner = $page = $products = array();

        if ($curUsr == 1) {
            $products = $this->Productmodel->listAll();
            $inner['products'] = $products;
            $page['content'] = $this->load->view('product-index', $inner, TRUE);
        } else {
            // $products = $this->Productmodel->userAssignedProducts($curUsr);
            $products = [];
            $inner['products'] = $products['data'];
            $page['content'] = $this->load->view('user-product-index', $inner, TRUE);
        }
        $this->load->view('shell', $page);
    }

    function userProducts() {
        $search = $this->input->post('search');
        $order = $this->input->post('order');
        if (isset($search['value']))
            $search = $search['value'];
        if (isset($order[0])) {
            $order = $order[0];
        }
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $curUsr = curUsrId();
        $response = $this->Productmodel->userAssignedProducts($curUsr, $offset, $limit, $search, $order);
        echo json_encode($response);
    }

    function getProducts() {
        $edit_link = anchor('catalog/product/edit/$1', '<i class="glyph-icon icon-linecons-pencil"></i> ', 'class = ""');
        $delete_link = anchor('catalog/product/delete/$1', '<i class="glyph-icon icon-linecons-trash red-color"></i>', 'message="Are you sure?" class = "confirmation"');
        $action = '<div class="page_item_options">' . $edit_link . '&nbsp;&nbsp;' . $delete_link . ' </div>';
        $this->load->library('datatables');
        $this->datatables
                ->select('id,name,sku,type,price,is_active', false)
                ->from('product');
        $this->datatables->add_column("Actions", $action, "id");
        echo $this->datatables->generate();
    }

    function listAll($cid) {
        //Get all Product
        $products = array();
        $products = $this->Productmodel->getCategoryProducts($cid);
        $jsonData = json_encode($products);
        print_r($jsonData);
    }

    function catproducts($cid) {
        $this->load->model('Productmodel');
        $this->load->model('Categorymodel');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $inner = $page = $products = $category = array();
        $products = $this->Productmodel->listByCategory($cid);
        $category = $this->Productmodel->categorydeatail($cid);

        $inner['products'] = $products;
        $inner['category'] = $category;
        $page['content'] = $this->load->view('cate-products-index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    //Function Add Product
    function add() {
        $this->load->model('Categorymodel');
        $this->load->model('user/Userprofilemodel');

        $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('type', 'Product Type', 'trim|required');
        $this->form_validation->set_rules('brand_id', 'Brand', 'trim');
        $this->form_validation->set_rules('name', 'Product Name', 'trim|is_unique[product.name]|required|callback_valid_product');
        $this->form_validation->set_rules('uri', 'Product Alias', 'trim|strtolower');
        $this->form_validation->set_rules('sku', 'SKU Code', 'trim|required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim');
        $this->form_validation->set_rules('description', 'Product Description', 'trim');
        $this->form_validation->set_rules('brief_description', 'Brief Description', 'trim');
        $this->form_validation->set_rules('product_specifications', 'Product Specifications', 'trim');
        $this->form_validation->set_rules('dimensions', 'Product Dimensions', 'trim');
        $this->form_validation->set_rules('tags', 'Product Tags', 'trim');
        $this->form_validation->set_rules('payment_delivery_options', 'Payment Delivery Options', 'trim');
        $this->form_validation->set_rules('is_featured', 'Product Is Featured', 'trim');
        $this->form_validation->set_rules('meta_title', 'Product Meta Title', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Product Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Product Meta Description', 'trim');

        $this->form_validation->set_rules('attrsetid', 'Attribute Set', 'trim|required');

        if ($this->input->post('type') != 'config') {
            $this->form_validation->set_rules('price', 'Price', 'trim|required|callback_valid_price');
            $this->form_validation->set_rules('price', 'Price', 'trim|required');
        }
        if ($this->input->post('type') == 'config') {
            if ($this->input->post('price')) {
                $this->form_validation->set_rules('price', 'Price', 'trim|callback_valid_price');
            }
            // $this->form_validation->set_rules('assign_product[]', 'Associated Products', 'trim|required');
        }
        if ($this->input->post('type') == 'bundle') {
            $this->form_validation->set_rules('bundle_qty', 'Bundle Quantity', 'trim');
        }
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //fetch category
        $categories = array();
        $catArray = $catSecArray = array();
        $catArray[''] = 'Select';
        $categories = $this->Categorymodel->indentedList(0);
        foreach ($categories as $row) {
            $catArray[$row['id']] = str_repeat('&nbsp;', ($row['depth']) * 4) . $row['name'];
            $catSecArray[$row['id']] = str_repeat('&nbsp;', ($row['depth']) * 4) . $row['name'];
        }

        $proType = array('' => 'Select', 'standard' => 'Standard', 'config' => 'Configurable', 'bundle' => 'Bundle', 'combo' => 'Combo Product');

        $profileGroup = $this->Userprofilemodel->listAll();

        $attributes_sets = array(); //get attribute sets
        $attributes_sets = $this->Productmodel->getAttributesSets();

        $brands = array();
        $brands = $this->Productmodel->listAllBrands();

        $brochures = array();
        $brochures = $this->Productmodel->allbrochures();

        if ($this->form_validation->run() == FALSE) {
            $this->remove_temp_pdf_files();

            $inner = array();
            $page = array();
            $inner['categories'] = $catArray;
            $inner['catSecArray'] = $catSecArray;
            $inner['proType'] = $proType;
            $inner['profileGroup'] = $profileGroup;
            $inner['brands'] = $brands;
            $inner['attributes_sets'] = $attributes_sets;
            $inner['brochures'] = $brochures;

            // Get non-config products.
            //$non_config_products = array();
            //$non_config_products = $this->Productmodel->get_non_config_products();
            //$inner['non_config_products'] = $non_config_products;

            $page['content'] = $this->load->view('product-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $product_id = $this->Productmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'product_added');
            redirect("catalog/product");
        }
    }

    //Function Edit Product
    function edit($pid) {
        $this->load->model('Categorymodel');
        $this->load->model('user/Userprofilemodel');
        $this->load->model('Tiermodel');
        $this->load->model('product_allocation/assignmodel');
        //Get Product Detail
        $product = array();
        $product = $this->Productmodel->details($pid);

        if (!$product) {
            $this->utility->show404();
            return;
        }

        $procat = array();
        $procat = $this->Productmodel->ProductCategory($pid);

        $proSecCat = $proSecCatKeys = array();
        $proSecCat = $this->Productmodel->ProductSecondCategory($pid);
        if ($proSecCat) {
            $proSecCatKeys = array_column($proSecCat, 'cid');
        }
        $proimg = array();
        $proimg = $this->Productmodel->productImages($pid);

        $attributes_sets = array(); //get attribute sets
        $attributes_sets = $this->Productmodel->getAttributesSets();
        $selected_attrs = $this->Productmodel->selectAttributes($pid);
        if (!empty($selected_attrs['attributes'])) {
            $selected_attrs = $selected_attrs['attributes'];
        } else {
            $selected_attrs = array();
        }

        $prochild = array();
        $child_ids = $this->Productmodel->ProductChild($pid, $selected_attrs);
//        e($child_ids);
        //$child_ids = $this->assignmodel->alreadyAssignedProducts($pid);

        $parent = array();
        $parent = $this->Productmodel->GetParentSku($pid);
//        e($selChild);
        /* echo "<pre>";
          print_r($selChild);
          echo "</pre>"; */
//        e($prochild);
        $prosiblings = array();
        // $prosiblings = $this->Productmodel->ProductSiblings($product['category_id'], $pid);
//        e($prosiblings);
//        e($proimg);
        $brands = array();
        $brands = $this->Productmodel->listAllBrands();
        $brochures = $selectedbrochures = array();
        $brochures = $this->Productmodel->allbrochures();
        $selectedbrochures = $this->Productmodel->selectedbrochures($pid);
        if (!empty($selectedbrochures)) {
            $selectedbrochures = array_column($selectedbrochures, 'bid');
        }

        $custom_options = $this->Productmodel->custom_options('logo_print_location', $pid);
        //validation check
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('type', 'Product Type', 'trim|required');
        $this->form_validation->set_rules('brand_id', 'Brand', 'trim');
        $this->form_validation->set_rules('attrsetid', 'Attribute Set', 'trim|required');
        if ($this->input->post('name', true) != $product['name'])
            $this->form_validation->set_rules('name', 'Product Name', 'trim|is_unique[product.name]|required');
        else
            $this->form_validation->set_rules('name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('uri', 'Product Alias', 'trim|strtolower');
        $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('description', 'Product Description', 'trim');
        $this->form_validation->set_rules('brief_description', 'Brief Description', 'trim');
        $this->form_validation->set_rules('dimensions', 'Product Dimensions', 'trim');
        $this->form_validation->set_rules('tags', 'Product Tags', 'trim');
        $this->form_validation->set_rules('product_specifications', 'Product Specifications', 'trim');
        $this->form_validation->set_rules('payment_delivery_options', 'Payment Delivery Options', 'trim');
        $this->form_validation->set_rules('is_featured', 'Product Is Featured', 'trim');
        $this->form_validation->set_rules('meta_title', 'Product Meta Title', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Product Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Product Meta Description', 'trim');

        if ($this->input->post('type') != 'config') {
            $this->form_validation->set_rules('price', 'Price', 'trim|required|callback_valid_price');
            $this->form_validation->set_rules('quantity', 'Quantity', 'trim');
        }
        if ($this->input->post('type') == 'config') {
            if ($this->input->post('price')) {
                $this->form_validation->set_rules('price', 'Price', 'trim|callback_valid_price');
            }
            // $this->form_validation->set_rules('assign_product[]', 'Associated Products', 'trim|required');
        }

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        //Fetch Categories
        $categories = array();
        $catArray = $catSecArray = array();
        $catArray[''] = 'Select';
        $categories = $this->Categorymodel->indentedListSmall(0);
        $mainCategory = $this->Categorymodel->getMainCategory($pid);
        foreach ($categories as $row) {
            $depth = isset($row['depth']) ? $row['depth'] : 1;
            $catArray[$row['id']] = str_repeat('&nbsp;', ($depth) * 4) . $row['name'];
        }
//e($categories);
        $proType = array('' => 'Select', 'standard' => 'Standard', 'config' => 'Configurable', 'bundle' => 'Bundle', 'combo' => 'Combo Product');

        $profileGroup = $this->Userprofilemodel->listAll();

        $productProfiles = $this->Tiermodel->getDetails($pid);

        $least_price = $this->Productmodel->config_least_price($pid);

        $pdfs = array();
        $pdfs = $this->Productmodel->get_pdfs($product['id']);

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['product'] = $product;
            $inner['categories'] = $catArray;
            $inner['catSecArray'] = $categories;
            $inner['proSecCatKeys'] = $proSecCatKeys;
            $inner['procat'] = $procat;
            $inner['proimg'] = $proimg;
            $inner['proType'] = $proType;
            //$inner['prochild'] = $prochild;
            $inner['prosiblings'] = $prosiblings;
            $inner['profileGroup'] = $profileGroup;
            $inner['editProfiles'] = $productProfiles;
            //$inner['selChildProducts'] = $selChild;
            $inner['child_ids'] = $child_ids;
            $inner['brands'] = $brands;
            $inner['mainCategory'] = $mainCategory;
            $inner['custom_options'] = $custom_options;
            $inner['selected_attrs'] = $selected_attrs;

            $inner['pdfs'] = $pdfs;
            $inner['attributes_sets'] = $attributes_sets;
            $inner['parent'] = $parent;
            $inner['least_price'] = $least_price;
            $inner['brochures'] = $brochures;
            $inner['selectedbrochures'] = $selectedbrochures;
            if ($this->is_child_product($pid)) {
                // Do nothing
            } else {
                // Get non-config products.
                //$non_config_products = array();
                //$non_config_products = $this->Productmodel->get_non_config_products();
                //$inner['non_config_products'] = $non_config_products;

                $accessories = array();
                $accessories = $this->Productmodel->get_accessories($pid);
                $inner['accessories'] = $accessories;
            }

            $page = array();
            $page['content'] = $this->load->view('product-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            // ee($_POST);
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

    function updateimagesortorder() {
        $prodid = $this->input->post('pid');
        $sortOrd = $this->input->post('sort_order');
        $imgDesc = $this->input->post('imgDesc');
        foreach ($sortOrd as $key => $value) {
            $data = array();
            $data['sort_order'] = $value['sort_order'];
            $data['desc'] = $imgDesc[$key]['desc'];
            $this->db->where('id', $value['image_id']);
            $this->db->where('pid', $value['pid']);
            $status = $this->db->update('prod_img', $data);
        }
        if ($status) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function disable($pid = false) { //function to disable record
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
//    functionorder() {
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
    //Function Delete product
    function deleteAll() {
        $pids = $_POST['pids'];
        foreach ($pids as $pid) {
            $result = $this->Productmodel->deleteAllRec($pid);
        }

        echo $result;
        exit;
    }

    function ed() {
        $pid = $_POST['pid'];
        //Get Product Detail
        $product = array();
        $product = $this->Productmodel->pdetail($pid);

        if (!$product) {
            $this->utility->show404();
            return;
        }
        $result = array();
        if ($product['is_active'] == 1) {
            $result = $this->Productmodel->disableRecord($product);
        } else {
            $result = $this->Productmodel->enableRecord($product);
        }
        echo json_encode($result);
        exit;
    }

    function valid_price($x) {
        if ($x) {
            if (filter_var($x, FILTER_VALIDATE_INT) || filter_var($x, FILTER_VALIDATE_FLOAT)) {
                return TRUE;
            }
        }
        $this->form_validation->set_message('valid_price', 'Price is not valid.');
        return FALSE;
    }

    function upload_pdf() {
        $path = $this->config->item('PDF_TEMP_PATH');

        if (0 < $_FILES['file']['error']) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        } else {
            move_uploaded_file($_FILES['file']['tmp_name'], $path . $_FILES['file']['name']);
        }
    }

    function remove_temp_pdf_files() {
        $path = $this->config->item('PDF_TEMP_PATH');
        array_map('unlink', glob("$path*"));
    }

    function remove_pdf() {
        $product_id = $this->input->post('product_id');
        $id = $this->input->post('id');

        $rs = array();
        $rs = $this->db->select('pdf')
                ->from('product_pdf')
                ->where('id', $id)
                ->get();

        if ($rs->num_rows() == 1) {
            $r = $rs->first_row('array');
            $filename = $r['pdf'];
            $filepath = $this->config->item('PDF_PATH') . $product_id . '/' . $filename;

            if (file_exists($filepath)) {
                if (unlink($filepath)) {
                    echo $this->db->from('product_pdf')->where('id', $id)->delete();
                }
            }
        }
    }

    function add_accessory() {
        $data = array();
        $data['config_product_id'] = trim($this->input->post('config_product_id'));
        $data['product_id'] = trim($this->input->post('id'));
        $data['quantity'] = trim($this->input->post('quantity'));
        $data['price'] = trim($this->input->post('price'));
        $data['added_on'] = time();

        if ($data['config_product_id'] && $data['product_id'] && $data['quantity'] && $data['price']) {
            if ($this->Productmodel->is_duplicate_accessory($data['config_product_id'], $data['product_id'])) {
                echo 'duplicate';
            } else {
                if ($this->db->insert('accessories', $data)) {
                    $arr = array();
                    $arr = $this->Productmodel->get_accessories($data['config_product_id']);
                    echo json_encode($arr);
                } else {
                    echo 'error';
                }
            }
        } else {
            echo 'no-input';
        }
    }

    function remove_accessory() {
        echo $this->db->where('id', $this->input->post('accessory_id'))->delete('accessories');
    }

    function is_child_product($id) {
        $rs = array();
        $rs = $this->db->select('*')
                ->from('product')
                ->join('product_configurable_link', 'product_configurable_link.child_id = product.id')
                ->where('product.id', $id)
                ->get();

        if ($rs->num_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    /* function add_remove_child($parent_id) {
      $data = array();
      $data['product_id'] = trim($this->input->post('product_id'));
      $data['is_add'] = trim($this->input->post('is_add'));
      if($data['is_add'] == 1) {
      echo $this->db->insert('product_configurable_link', array( "parent_id" => $parent_id, "child_id" => $data['product_id']  ));
      }
      else if($data['is_add'] == 0){
      echo $this->db->where('parent_id', $parent_id)->where('child_id', $data['product_id'])->delete('product_configurable_link');
      }
      die;
      } */

    function chld_update() {
        $data = array();
        $product_id = trim($this->input->post('product_id'));
        $data['price'] = trim($this->input->post('price'));
        $data['quantity'] = trim($this->input->post('quantity'));
        echo $this->db->where('id', $product_id)->update('product', $data);
    }

    function brochures($offset = FALSE) {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('text');
        $this->load->library('pagination');


        //Setup Pagination
        $perpage = 20;
        $config['base_url'] = base_url() . "catalog/product/brochures/";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Productmodel->countbrochures();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        $brochures = array();
        $brochures = $this->Productmodel->allbrochures($offset, $perpage);

        //render view
        $inner = array();
        $inner['brochures'] = $brochures;
        $inner['pagination'] = $this->pagination->create_links();
        $page = array();
        $page['content'] = $this->load->view('catalog/brochure/index', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function brochures_add() {
        //validation check
        $this->form_validation->set_rules('v_image', 'Image', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('catalog/brochure/add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Productmodel->insertbrochures();
            $this->session->set_flashdata('SUCCESS', 'brochures_added');
            redirect("catalog/product/brochures");
            exit();
        }
    }

    function brochures_edit($id) {
        $brochure = array();
        $brochure = $this->Productmodel->brochuredetail($id);
        //validation check
        $this->form_validation->set_rules('v_image', 'Image', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $inner['brochure'] = $brochure;
            $page['content'] = $this->load->view('catalog/brochure/edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Productmodel->updatebrochures($brochure);
            $this->session->set_flashdata('SUCCESS', 'brochures_updated');
            redirect("catalog/product/brochures");
            exit();
        }
    }

    function brochures_delete($id) {
        $brochure = array();
        $brochure = $this->Productmodel->brochuredetail($id);

        $this->Productmodel->deletebrochures($brochure);
        $this->session->set_flashdata('SUCCESS', 'brochures_deleted');
        redirect("catalog/product/brochures");
        exit();
    }

}
