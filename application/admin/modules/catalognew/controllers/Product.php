<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('Productmodel');
        $this->is_admin_protected = true;
        //      $this->output->enable_profiler(TRUE);
    }

    public function index()
    {
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
            $page['content'] = $this->load->view('product-index', $inner, true);
        } else {
            // $products = $this->Productmodel->userAssignedProducts($curUsr);
            $products = [];
            $inner['products'] = $products['data'];
            $page['content'] = $this->load->view('user-product-index', $inner, true);
        }
        $this->load->view('shell', $page);
    }

    //Code by @Rav
    function exportstock()
    {
        $arr = [];
        $arr = $this->Productmodel->getStock();

        $filename = "stock.xls"; // File Name
        // Download file
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");
        // Write data to file
        $flag = false;
        foreach ($arr as $row) {
            if (!$flag) {
                // display field/column names as first row
                echo implode("\t", array_keys($row)) . "\r\n";
                $flag = true;
            }
            echo implode("\t", array_values($row)) . "\r\n";
        }
    }

    public function stock()
    {
        $this->load->model('Productmodel');
        $this->load->model('Categorymodel');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $inner = $page = $products = array();
        $products = $this->Productmodel->listAllOutOfStock();
        $inner['products'] = $products;
        $page['content'] = $this->load->view('product-stock', $inner, true);
        $this->load->view('shell', $page);
    }

    public function userProducts()
    {
        $search = $this->input->post('search');
        $order = $this->input->post('order');
        if (isset($search['value'])) {
            $search = $search['value'];
        }

        if (isset($order[0])) {
            $order = $order[0];
        }
        $limit = $this->input->post('length');
        $offset = $this->input->post('start');
        $curUsr = curUsrId();
        $response = $this->Productmodel->userAssignedProducts($curUsr, $offset, $limit, $search, $order);
        echo json_encode($response);
    }

    public function getProducts()
    {
        $edit_link = anchor('catalognew/product/edit/$1', '<i class="glyph-icon icon-linecons-pencil"></i> ', 'class = ""');
        $delete_link = anchor('catalognew/product/delete/$1', '<i class="glyph-icon icon-linecons-trash red-color"></i>', 'message="Are you sure?" class = "confirmation"');
        $action = '<div class="page_item_options">' . $edit_link . '&nbsp;&nbsp;' . $delete_link . ' </div>';
        $this->load->library('datatables');
        $this->datatables
            ->select('id,name,sku,type,price,is_active', false)
            ->from('product');
        $this->datatables->add_column("Actions", $action, "id");
        echo $this->datatables->generate();
    }

    public function listAll($cid)
    {
        //Get all Product
        $products = array();
        $products = $this->Productmodel->getCategoryProducts($cid);
        $jsonData = json_encode($products);
        print_r($jsonData);
    }

    public function catproducts($cid)
    {
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
        $page['content'] = $this->load->view('cate-products-index', $inner, true);
        $this->load->view('shell', $page);
    }

    //Function Add Product
    public function add()
    {
        // e( $_POST );
        $this->load->model('Categorymodel');
        $this->load->model('user/Userprofilemodel');

        $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('type', 'Product Type', 'trim|required');
        // $this->form_validation->set_rules('name', 'Product Name', 'trim|is_unique[product.name]|required');
        $this->form_validation->set_rules('name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('uri', 'Product Alias', 'trim|strtolower');
        $this->form_validation->set_rules('sku', 'SKU Code', 'trim|required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim');
        $this->form_validation->set_rules('description', 'Product Description', 'trim');
        $this->form_validation->set_rules('brief_description', 'Brief Description', 'trim');
        $this->form_validation->set_rules('delivery_information', 'Delivery Information', 'trim');
        $this->form_validation->set_rules('technical_specification', 'Technical Specification', 'trim');
        $this->form_validation->set_rules('packaging', 'Packaging', 'trim');
        $this->form_validation->set_rules('is_featured', 'Product Is Featured', 'trim');
        $this->form_validation->set_rules('meta_title', 'Product Meta Title', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Product Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Product Meta Description', 'trim');
        $this->form_validation->set_rules('attrsetid', 'Attribute Set', 'trim|required');

        //        callback_valid_price
        if ($this->input->post('type') != 'config') {
            //            $this->form_validation->set_rules('price', 'Price', 'trim|required|callback_numeric_wcomma');
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

        $proType = array('standard' => 'Standard');

        $profileGroup = $this->Userprofilemodel->listAll();

        $attributes_sets = array(); //get attribute sets
        $attributes_sets = $this->Productmodel->getAttributesSets();

        $brands = array();
        $brands = $this->Productmodel->listAllBrands();

        $parentcat = array();
        $parentcat = $this->Productmodel->parentcat();

        $brochures = array();
        $brochures = $this->Productmodel->allbrochures();

        if ($this->form_validation->run() == false) {
            $this->remove_temp_pdf_files();

            $inner = array();
            $page = array();
            $inner['categories'] = $catArray;
            $inner['parentcat'] = $parentcat;
            $inner['catSecArray'] = $catSecArray;
            $inner['proType'] = $proType;
            $inner['profileGroup'] = $profileGroup;
            $inner['brands'] = $brands;
            $inner['attributes_sets'] = $attributes_sets;
            $inner['brochures'] = $brochures;

            $page['content'] = $this->load->view('product-add', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $product_id = $this->Productmodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'product_added');
            redirect("catalognew/product");
        }
    }

    //Function Edit Product
    public function edit($pid)
    {
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
        $parentcat = array();
        $parentcat = $this->Productmodel->parentcat();
        $sectedprod = array();
        $sectedprod = $this->Productmodel->sectedprod($pid);

        $procat = array();
        $procat = $this->Productmodel->ProductCategory($pid);

        $proSecCat = $proSecCatKeys = array();
        $proSecCat = $this->Productmodel->ProductSecondCategory($pid);
        if ($proSecCat) {
            $proSecCatKeys = array_column($proSecCat, 'cid');
        }
        $proimg = array();
        $proimg = $this->Productmodel->productImages($pid);

        $provideos = array();
        $provideos = $this->Productmodel->productVideos($pid);

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
        $parent = array();
        $parent = $this->Productmodel->GetParentSku($pid);
        $prosiblings = array();
        $brands = array();
        $brands = $this->Productmodel->listAllBrands();
        $brochures = $selectedbrochures = array();
        $brochures = $this->Productmodel->allbrochures();
        $selectedbrochures = $this->Productmodel->selectedbrochures($pid);
        if (!empty($selectedbrochures)) {
            $selectedbrochures = array_column($selectedbrochures, 'bid');
        }

        $custom_options = $this->Productmodel->custom_options('logo_print_location', $pid);
        $bulletpoints = $this->Productmodel->bulletpoints($pid);
        //validation check
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('type', 'Product Type', 'trim|required');
        $this->form_validation->set_rules('attrsetid', 'Attribute Set', 'trim|required');
        if ($this->input->post('name', true) != $product['name']) {
            // $this->form_validation->set_rules('name', 'Product Name', 'trim|is_unique[product.name]|required');
            $this->form_validation->set_rules('name', 'Product Name', 'trim|required');
        } else {
            $this->form_validation->set_rules('name', 'Product Name', 'trim|required');
        }

        $this->form_validation->set_rules('uri', 'Product Alias', 'trim|strtolower');
        $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('description', 'Product Description', 'trim');
        $this->form_validation->set_rules('brief_description', 'Brief Description', 'trim');
        $this->form_validation->set_rules('delivery_information', 'Delivery Information', 'trim');
        $this->form_validation->set_rules('technical_specification', 'Technical Specification', 'trim');
        $this->form_validation->set_rules('packaging', 'Packaging', 'trim');
        $this->form_validation->set_rules('is_featured', 'Product Is Featured', 'trim');
        $this->form_validation->set_rules('meta_title', 'Product Meta Title', 'trim');
        $this->form_validation->set_rules('meta_keywords', 'Product Meta Keywords', 'trim');
        $this->form_validation->set_rules('meta_description', 'Product Meta Description', 'trim');

        //        callback_valid_price
        if ($this->input->post('type') != 'config') {
            $this->form_validation->set_rules('quantity', 'Quantity', 'trim');
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
        $proType = array('standard' => 'Standard');

        $profileGroup = $this->Userprofilemodel->listAll();

        $productProfiles = $this->Tiermodel->getDetails($pid);
        $productTier = $this->Tiermodel->getTierDetails($pid);

        $quantity_range = $this->Tiermodel->quantity_range($pid);
        $least_price = $this->Productmodel->config_least_price($pid);

        $pdfs = array();
        $pdfs = $this->Productmodel->get_pdfs($product['id']);

        if ($this->form_validation->run() == false) {
            $inner = array();
            $inner['pid'] = $pid;
            $inner['product'] = $product;
            $inner['categories'] = $catArray;
            $inner['catSecArray'] = $categories;
            $inner['proSecCatKeys'] = $proSecCatKeys;
            $inner['procat'] = $procat;
            $inner['proimg'] = $proimg;
            $inner['provideos'] = $provideos;
            $inner['proType'] = $proType;
            $inner['parentcat'] = $parentcat;
            $inner['sectedprod'] = $sectedprod;
            //$inner['prochild'] = $prochild;
            $inner['prosiblings'] = $prosiblings;
            $inner['profileGroup'] = $profileGroup;
            $inner['editProfiles'] = $productProfiles;
            $inner['productTier'] = $productTier;
            $inner['quantity_range'] = $quantity_range;
            //$inner['selChildProducts'] = $selChild;
            $inner['child_ids'] = $child_ids;
            $inner['brands'] = $brands;
            $inner['mainCategory'] = $mainCategory;
            $inner['custom_options'] = $custom_options;
            $inner['selected_attrs'] = $selected_attrs;
            $inner['bulletpoints'] = $bulletpoints;

            $inner['pdfs'] = $pdfs;
            $inner['attributes_sets'] = $attributes_sets;
            $inner['parent'] = $parent;
            $inner['least_price'] = $least_price;
            $inner['brochures'] = $brochures;
            $inner['selectedbrochures'] = $selectedbrochures;
            if ($this->is_child_product($pid)) {
                // Do nothing
            } else {
                $accessories = array();
                $accessories = $this->Productmodel->get_accessories($pid);
                $inner['accessories'] = $accessories;
            }

            $page = array();
            $page['content'] = $this->load->view('product-edit', $inner, true);
            $this->load->view('shell', $page);
        } else {
            // e($_POST );
            $this->Productmodel->update_child_stock_and_price();
            $this->Productmodel->updateRecord($product);
            $this->session->set_flashdata('SUCCESS', 'product_updated');
            if ($this->input->post('button') == 'save_and_close') {
                redirect("catalognew/product");
            } elseif ($this->input->post('button') == 'save') {
                redirect("catalognew/product/edit/$pid");
            } else {
                redirect("catalognew/product/edit/$pid");
            }
        }
    }

    //Function Duplicate Product
    public function duplicate($pid)
    {

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
        //        $this->form_validation->set_rules('brand_id', 'Brand', 'trim');
        $this->form_validation->set_rules('attrsetid', 'Attribute Set', 'trim|required');
        if ($this->input->post('name', true) != $product['name']) {
            $this->form_validation->set_rules('name', 'Product Name', 'trim|is_unique[product.name]|required');
        } else {
            $this->form_validation->set_rules('name', 'Product Name', 'trim|required');
        }

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

        $productTier = $this->Tiermodel->getTierDetails($pid);


        $least_price = $this->Productmodel->config_least_price($pid);

        $pdfs = array();
        $pdfs = $this->Productmodel->get_pdfs($product['id']);

        if ($this->form_validation->run() == false) {
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
            $inner['productTier'] = $productTier;
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
            $page['content'] = $this->load->view('product-duplicate', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Productmodel->duplicateRecord($product);
            $this->session->set_flashdata('SUCCESS', 'product_added');
            redirect("catalognew/product");
        }
    }

    //function to enable product
    public function enable($pid = false)
    {
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
        redirect("catalognew/product");
        exit();
    }

    public function updateimagesortorder()
    {
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

    public function disable($pid = false)
    { //function to disable record
        //Get Product Detail
        $product = array();
        $product = $this->Productmodel->details($pid);

        if (!$product) {
            $this->utility->show404();
            return;
        }

        $this->Productmodel->disableRecord($product);
        $this->session->set_flashdata('SUCCESS', 'product_updated');
        redirect("catalognew/product");
        exit();
    }

    //Function Delete product
    public function delete($pid)
    {
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
            redirect("catalognew/product");
            exit();
        } else {
            redirect("catalognew/product/index/{$product['show_id']}/{$product['product_type_id']}");
            exit();
        }
    }

    public function products_list($cid)
    {
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
    public function deleteAll()
    {
        $pids = $_POST['pids'];
        foreach ($pids as $pid) {
            $result = $this->Productmodel->deleteAllRec($pid);
        }

        echo $result;
        exit;
    }

    public function ed()
    {
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

    public function valid_price($x)
    {
        if ($x) {
            if (filter_var($x, FILTER_VALIDATE_INT) || filter_var($x, FILTER_VALIDATE_FLOAT)) {
                return true;
            }
        }
        $this->form_validation->set_message('valid_price', 'Price is not valid.');
        return false;
    }

    function numeric_wcomma($val)
    {
        if (!preg_match("/[a-z]/i", $val)) {
            return true;
        } else {
            $this->form_validation->set_message('numeric_wcomma', 'Please enter numeric value for price field.');
            return false;
        }
    }

    public function upload_pdf()
    {
        $path = $this->config->item('PDF_TEMP_PATH');

        if (0 < $_FILES['file']['error']) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        } else {
            move_uploaded_file($_FILES['file']['tmp_name'], $path . $_FILES['file']['name']);
        }
    }

    public function remove_temp_pdf_files()
    {
        $path = $this->config->item('PDF_TEMP_PATH');
        array_map('unlink', glob("$path*"));
    }

    public function remove_pdf()
    {
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
            $filepath = $this->config->item('PDF_PATH') . $filename;

            if (file_exists($filepath)) {
                if (unlink($filepath)) {
                    echo $this->db->from('product_pdf')->where('id', $id)->delete();
                }
            }
        }
    }

    public function add_accessory()
    {
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

    public function remove_accessory()
    {
        echo $this->db->where('id', $this->input->post('accessory_id'))->delete('accessories');
    }

    public function is_child_product($id)
    {
        $rs = array();
        $rs = $this->db->select('*')
            ->from('product')
            ->join('product_configurable_link', 'product_configurable_link.child_id = product.id')
            ->where('product.id', $id)
            ->get();

        if ($rs->num_rows()) {
            return true;
        }

        return false;
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

    public function chld_update()
    {
        $data = array();
        $product_id = trim($this->input->post('product_id'));
        $data['price'] = trim($this->input->post('price'));
        $data['quantity'] = trim($this->input->post('quantity'));
        echo $this->db->where('id', $product_id)->update('product', $data);
    }

    public function brochures($offset = false)
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('text');
        $this->load->library('pagination');

        //Setup Pagination
        $perpage = 20;
        $config['base_url'] = base_url() . "catalognew/product/brochures/";
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
        $page['content'] = $this->load->view('catalog/brochure/index', $inner, true);
        $this->load->view('shell', $page);
    }

    public function brochures_add()
    {
        //validation check
        $this->form_validation->set_rules('v_image', 'Image', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('catalog/brochure/add', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Productmodel->insertbrochures();
            $this->session->set_flashdata('SUCCESS', 'brochures_added');
            redirect("catalognew/product/brochures");
            exit();
        }
    }

    public function brochures_edit($id)
    {
        $brochure = array();
        $brochure = $this->Productmodel->brochuredetail($id);
        //validation check
        $this->form_validation->set_rules('v_image', 'Image', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {
            $inner = array();
            $page = array();
            $inner['brochure'] = $brochure;
            $page['content'] = $this->load->view('catalog/brochure/edit', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Productmodel->updatebrochures($brochure);
            $this->session->set_flashdata('SUCCESS', 'brochures_updated');
            redirect("catalognew/product/brochures");
            exit();
        }
    }

    public function brochures_delete($id)
    {
        $brochure = array();
        $brochure = $this->Productmodel->brochuredetail($id);

        $this->Productmodel->deletebrochures($brochure);
        $this->session->set_flashdata('SUCCESS', 'brochures_deleted');
        redirect("catalognew/product/brochures");
        exit();
    }

    function delete_pdf()
    {


        $colname = $this->input->post('dataval');
        $data = array($colname => NULL);
        $id = $this->input->post('pid');
        $this->db->select($colname);
        $this->db->where('id', $id);
        $getfile =  $this->db->get('product')->row_array();
        $path = $this->config->item('PDF_PATH');
        $filename = $path . $getfile[$colname];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        $this->db->select($colname);
        $this->db->where('id', $id);
        $this->db->update('product', $data);
        
    }

    function updatePrdJkSortOrder()
    {
        $sort_data = $this->input->post('prd', true);
        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['prd_sort_order'] = $key + 1;
            $this->db->where('id', $val);
            $this->db->update('product', $update);
        }
        //echo "Done";
        print_r($_POST);
    }
    public function getchildcat()
    {
        $catId = $this->input->post('selcted_option', true);
        $data = $this->db->select('*')
            ->from('category')
            ->where('parent_id', $catId)
            ->where('active', 1)
            ->get();
        $html = '';
        $resultarray = [];
        if ($data->num_rows()) {
            $result =   $data->result_array();
            $html .= '<label class="col-sm-2 control-label block-element">Select Sub Category </label>';
            $html .= '<div class="input-car-product"> <input  type="text" placeholder="Search..." class="form-control input-search"> </div>';
            $html .= '<ul class="list-inline inner-ul-you-ma-8">';
           
            foreach ($result as $item) {
                $html .= '<li>';
                $html .= '<label class="custom-check">';
                $html .= '<input type="checkbox" name="subcat[]" value="' . $item['id'] . '">';
                $html .= '<span class="box-custom-check">';
                $html .= '<i class="fa fa-check"></i>';
                $html .= '</span>';
                $html .= '<span class="name">' . $item['name'] . '</span>';
                $html .= '</label>';
                $html .= '</li>';
                $html .= $this->getSubCatSub($item['id']);
            }
            
            $html .= '</ul>';
            $html .= '<div class="submit-sub-cat"><a href="#" class="sub-a-cat" style="background: #263388a3;">Get Products</a></div>';
            // e($html);
            $resultarray['subcat'] =  $html;
        } else {

            $this->db->select('t1.*');
            $this->db->from('product t1');
            $this->db->join('cat_prod t2', 't1.id = t2.pid', 'left');
            $this->db->join('category t3', 't3.id = t2.cid', 'left');
            $this->db->where('t3.id', $catId);
            $this->db->where('t3.active', 1);
            $query = $this->db->get();

            if ($query->num_rows()) {
                $result =   $query->result_array();
                $html .= '<ul class="list-inline inner-ul-you-ma-9">';
                $html .= '<label class="col-sm-2 control-label block-element">Select Products </label>';
                foreach ($result as $item) {
                    $html .= '<li>';
                    $html .= '<label class="custom-check">';
                    $html .= '<input type="checkbox" name="productadd[]" value="' . $item['id'] . '">';
                    $html .= '<span class="box-custom-check">';
                    $html .= '<i class="fa fa-check"></i>';
                    $html .= '</span>';
                    $html .= '<span class="name">' . $item['name'] . '</span>';
                    $html .= '</label>';
                    $html .= '</li>';
                }
                $html .= '</ul>';
                $resultarray['products'] = $html;
            } else {
                $html .= '<p>No Record</p>';
                $resultarray['noproduct'] = $html;
            }
        }

        echo json_encode($resultarray);
    }

    public function catGetProducts()
    {

        $catId = $this->input->post('subcat_id', true);
        $resultArray = [];
        $html = '';
        foreach ($catId as $key  => $item) {

            $this->db->select('t1.*');
            $this->db->from('product t1');
            $this->db->join('cat_prod t2', 't1.id = t2.pid', 'left');
            $this->db->join('category t3', 't3.id = t2.cid', 'left');
            $this->db->where('t2.cid', $item);
            $this->db->where('t1.is_active', 1);
            $query = $this->db->get();
            $result =  $query->result_array();

            $this->db->select('*');
            $this->db->from('category');
            $this->db->where('id', $item);
            $this->db->where('active', 1);
            $catname = $this->db->get()->row_array();

            if ($query->num_rows()) {
                $html .= '<label class="col-sm-2 control-label block-element">Select Product of ' . $catname['name'] . ' </label>';
                $html .= '<div class="col-sm-12 "> <input  type="text" placeholder="Search..." class="form-control input-search"> </div>';
                $html .= '<ul class="list-inline searchul">';
                
                foreach ($result as $key => $item) {
                    $html .= '<li>';
                    $html .= '<label class="custom-check">';
                    $html .= '<input type="checkbox" name="productadd[]" value="' . $item['id'] . '">';
                    $html .= '<span class="box-custom-check">';
                    $html .= '<i class="fa fa-check"></i>';
                    $html .= '</span>';
                    $html .= '<span class="name">' . $item['name'] . '</span>';
                    $html .= '</label>';
                    $html .= '</li>';
                }
                $html .= '</ul>';
                $resultArray['products'] = $html;
            } else {
                // $html .= '<label class="col-sm-2 control-label block-element">Select Product of ' . $catname['name'] . ' </label>';
                // $html .= '<p>No Record</p>';
                $resultArray['products'] = $html;
            }
        }
        //    e($resultArray);
        echo json_encode($resultArray);
    }


    function getSubCatSub($catId)
    {
        $result = $this->db->select('*')
            ->from('category')
            ->where('parent_id', $catId)
            ->where('active', 1)
            ->get()->result_array();
        $html = '';
        foreach ($result as $item) {
            $html .= '<li>';
            $html .= '<label class="custom-check">';
            $html .= '<input type="checkbox" name="subcat[]" value="' . $item['id'] . '">';
            $html .= '<span class="box-custom-check">';
            $html .= '<i class="fa fa-check"></i>';
            $html .= '</span>';
            $html .= '<span class="name">' . $item['name'] . '</span>';
            $html .= '</label>';
            $html .= '</li>';
        }
        return $html;
    }

    function updateProduct_SortOrder(){
		$sort_data = $this->input->post('pid', true);
		foreach($sort_data as $key=>$val) {
			$update = array();
			$update['prd_sort_order'] = $key+1;
			$this->db->where('id', $val);
			$this->db->update('product', $update);
		}
        print_r($_POST);
	}
}
