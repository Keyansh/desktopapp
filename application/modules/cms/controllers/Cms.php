<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cms extends Cms_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('catalog/Productmodel');
        $this->load->model('catalog/Categorymodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->model('Pagemodel');
        $this->load->model('catalog/Attributesmodel');

        // $this->load->model('catalog/productmodel');
        $this->load->model('Tiercmsmodel');
        $this->load->model('catalog/Attributesmodel');
        $this->load->library('form_validation');
        $this->load->model('rating/Ratingmodel');
        if (!$this->session->userdata('CUSTOMER_ID')) {
            $this->load->helper('url');
            $this->session->set_userdata('REGENT_REDIR_URL', current_url());
        }
    }

    public function checkURi($uri, $id)
    {
        $this->db->select('*');
        $this->db->from('product_bk');
        $this->db->where('id !=', $id);
        $this->db->where('uri', $uri);
        $rs = $this->db->get();
        return $rs->row_array();
    }

    public function allProdListLink($local = false, $type = "all")
    {
        $this->db->select('t1.uri, t1.id,t1.sku,t1.type');

        $this->db->from('product t1');
        $this->db->join('prod_img t2', 't1.id = t2.pid AND t2.main = 1', 'left');
        $this->db->join('cat_prod t4', 't1.id = t4.pid', 'left');
        //$this->db->join('review t4', 't1.id = t4.product_id AND t4.status = 1', 'left');
        //$this->db->join('leadtime', 'product.product_id = leadtime.product_id AND selected = 1', 'left');

        $qu = "t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf where pf.child_id != pf.parent_id)";
        $this->db->where($qu);
        $this->db->group_by('t1.id');
        $this->db->where('t1.is_active', 1);
        if ($type != "all") {
            $this->db->where('t1.type', $type);
        }
        //echo $this->db->last_query();
        $query = $this->db->get();
        $ab = $query->result_array();

        $url = "http://lof.checksample.co.uk";
        if ($local) {
            $url = "http://localhost/lofd";
        }
        foreach ($ab as $a) {
            echo "<a href='$url/" . $a['uri'] . "'>" . $a['uri'] . " (" . $a['sku'] . ")" . $a['type'] . "</a>" . "||||||||" . "<a href='$url/admin/catalog/product/edit/" . $a['id'] . "'>admin</a>";
            echo "</br/>";
        }
    }

    public function uriChange()
    {
        $this->db->select('*');
        $this->db->from('product_bk');
        //$this->db->where('id', $attrId['id']);
        $this->db->where("uri LIKE '%\_%'");
        $rs = $this->db->get();
        $ab = $rs->result_array();
        foreach ($ab as $attrId) {
            $uri = $attrId['uri'];
            echo $uri . "||||||";
            $uri = str_replace("_", "-", $uri);
            $uri = preg_replace('!-+!', '-', $uri);
            $uri = rtrim($uri, '-');
            echo $uri . ")";
            $i = 1;
            while (!empty($this->checkURi($uri, $attrId['id']))) {
                $uri = $uri . "-" . $i;
                $i++;
                break;
            }

            $updateData = array(
                'uri' => $uri,
            );
            $this->db->where('id', $attrId['id']);
            $this->db->update('product_bk', $updateData);
        }
        die;
    }

    public function index()
    {
        $alias = false;
        $tmp = $this->uri->segment_array();
        $last_segment = array_pop($tmp);
        $uri = $this->uri->uri_string();
        $perpage = explode('/', $uri);
        $offset = 0;
        if (is_numeric(end($perpage))) {
            $uri = implode(':', array_slice($perpage, 0, -1));
            $category = $this->Categorymodel->fetchByAlias($uri);
            $offset = end($perpage);
        } else {
            $uri = preg_replace('/~.*$/', '', $uri);
            $category = $this->Categorymodel->fetchByAlias($uri);
        }



        if ($category) {
            $this->_category($category['uri'], $offset);
            return;
        }

        $product = $this->Productmodel->fetchByAlias($this->uri->uri_string());

        if (($product) && (!$product['is_bespoke']) && ($product['type'] != 'bundle')) {
            $this->_product($product['uri']);
            return;
        } elseif ($product && $product['is_bespoke']) {
            $this->_productdesigner($product);
            return;
        } elseif (($product) && ($product['type'] == 'bundle')) {
            $this->_productbundle($product);
            return;
        }

        $brand = array();
        $brand = $this->Pagemodel->get_brand($uri);
        if ($brand) {
            $this->_brand($brand);
            return;
        }

        $status = $this->cmscore->loadPage($this, $alias);

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

        $page_blocks = array();
        $page_blocks = $this->Pagemodel->page_blocks($pageId);

        $slides = $usp = $topcat = $homemaincat = $homechildcat = $homeoffers = array();
        $slides = $this->Pagemodel->listAllSlides();

        $compiled_blocks = array();
        $compiled_blocks = $this->Pagemodel->compiledBlocks1($pageId);

        $featured_category_icons = array();
        $featured_category_icons = $this->Pagemodel->featured_category_icons();

        $new_arrivals = array();
        $new_arrivals = $this->Pagemodel->new_arrivals();

        $featured_products = array();
        $featured_products = $this->Pagemodel->featuredProduct();

        if ($featured_products) {
            $inner['config_ids'] = $this->Productmodel->config_ids($featured_products);
        }

        $ad_banners = array();
        $ad_banners = $this->Pagemodel->ad_banners();

        $trending_categories = array();
        $trending_categories = $this->Pagemodel->trending_categories();

        $projectsTypes = array();
        $projectsTypes = $this->Pagemodel->projectsTypes();

        $testimonials = array();
        $testimonials = $this->Pagemodel->testimonials();

        $home_offers = $this->Pagemodel->showAllHomeOffers();

        $home_categories = $this->Pagemodel->homepage_categories();

        //        top rated products
        if (file_exists($file_path)) {
            $inner['slides'] = $slides;
            $inner['blocks'] = $compiled_blocks;
            $inner['featured_products'] = $featured_products;
            $inner['featured_category_icons'] = $featured_category_icons;
            $inner['new_arrivals'] = $new_arrivals;
            $inner['trending_categories'] = $trending_categories;
            $inner['projectsTypes'] = $projectsTypes;
            $inner['ad_banners'] = $ad_banners;
            $inner['testimonials'] = $testimonials;
            $inner['home_categories'] = $home_categories;
            $shell['contents'] = $this->load->view("themes/" . THEME . "/cms/" . $file_name, $inner, true);
        } else {
            $shell['contents'] = $this->load->view("themes/" . THEME . "/cms/" . 'default', $inner, true);
        }

        $globalBlocks = array();
        $globalBlocks = $this->Pagemodel->getGlobalBlocks(0);
        $shell['globalBlocks'] = $globalBlocks;
        $shell['page_blocks'] = $page_blocks;
        if (isset($page['page_banner']) && $page['page_banner'] != '') {
            $shell['page_banner'] = $page['page_banner'];
        }

        // Do not show empty config product
        if ($product) {
            if ($product['type'] == 'config') {
                if ($product['id'] != $this->Productmodel->config_ids($product)) {
                    $this->http->show404();
                    return;
                }
            }
        }

        $this->load->view("themes/" . THEME . "/templates/{$page['template_alias']}", $shell);
    }

    public function _productdesigner($product)
    {
        $shell['contents'] = $this->load->view('designer/index', compact('product'), true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    public function _productbundle($product)
    {
        $shell['contents'] = $this->load->view('designer/bundleproduct', compact('product'), true);
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }

    public function _category($c_alias = '', $offset = 0)
    {

        $uri = $this->uri->uri_string();
        $this->load->library('mypagination');

        $category = $inner = $shell = $attrsC = $newAttrs = $catAttr = $subcatids = array();

        $category = $this->Categorymodel->fetchByAlias($c_alias);
        $sub_categories = $sub_child_categories = array();
        $sub_categories = $this->Categorymodel->subCategories($category['id']);

        if ($sub_categories) {
            $subcatids = $this->Pagemodel->array_column1($sub_categories, 'id');
            $sub_child_categories = $this->Categorymodel->subChildCategories($subcatids);
        }

        $trending_categories = array();
        $trending_categories = $this->Pagemodel->trending_categories();

        $all_parent_categories = array();
        $all_parent_categories = $this->Pagemodel->all_parent_categories();

        $url_options = explode('~', $uri);
        $url_options = array_map(function ($item) {
            return rawurldecode($item);
        }, $url_options);
        unset($url_options[0]);
        $pagination_string = $options = $other_options = array();
        foreach ($url_options as $url_option) :
            if (strpos($url_option, 'page-') === false) {
                $pagination_string[] = $url_option;
            }
            $tmp = explode('-', $url_option);
            $attr = $this->Productmodel->getAttributeIdByName($tmp[0]);
            if ($attr) {
                if (!isset($options[$attr['id']])) {
                    $options[$attr['id']] = [];
                }

                $url_option = explode(',', $tmp[1]);
                $url_option = $this->Productmodel->getAttributeValueIdByName($url_option, $attr['type']);
                $options[$attr['id']] = $url_option;
            } else {
                $other_options[$tmp[0]] = $tmp[1];
            }
        endforeach;

        $extra = [
            'selected_min_price' => isset($other_options['minprice']) ? $other_options['minprice'] : 0,
            'selected_max_price' => isset($other_options['maxprice']) ? $other_options['maxprice'] : 0,
            'offset' => isset($other_options['page']) ? $other_options['page'] : $offset,
        ];

        $brand_by_product = $products = $out = [];
        $total_products = 0;

        $perpage = isset($other_options['perpage']) ? $other_options['perpage'] : 20;
        if ($options || $extra['selected_min_price'] || $extra['selected_max_price']) {
            $out = $this->Productmodel->getCategoryFiltersProducts($category['id'], $options, $extra);
        }
        if ($out !== false) {
            $products = $this->Productmodel->listByCategory($category['id'], $extra['offset'], $perpage, $out, false);
            $total_products = $this->Productmodel->listByCategoryCount($category['id'], $out);
        }
        // Get total number of products of this category.
        if ($pagination_string) {
            $config['base_url'] = base_url() . str_replace(":", '/', $c_alias) . "~" . implode('~', $pagination_string);
        } else {
            $config['base_url'] = base_url() . str_replace(":", '/', $c_alias);
        }
        $config['uri_segment'] = 4;
        $config['total_rows'] = $total_products;
        $config['per_page'] = $perpage;
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination" >';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        // $config['prev_link'] = '&laquo';
        // $config['prev_tag_open'] = '<li class="prev">';
        // $config['prev_tag_close'] = '</li>';
        $config['prev_link'] = false;
        // $config['next_link'] = 'next';
        // $config['next_tag_open'] = '<li>';
        // $config['next_tag_close'] = '</li>';
        $config['next_link'] = false;
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a class="page-link disabled" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->mypagination->initialize($config);

        $attributesIDs = $aids = $attrValues = array();
        if (@$pids) {
            $attributesIDs = $this->Productmodel->attributeIDsBypro($pids);
            $aids = $this->Pagemodel->array_column1($attributesIDs, 'attr_id');
            $attrValues = $this->Productmodel->fetchAtrrValuesBypro($pids, $aids);
        }
        // first uri segment
        $CatFirstSegment = $this->Categorymodel->fetchByAlias($this->uri->segment(1));
        // first uri segment
        $child_and_grandchild_categories = array();
        $child_and_grandchild_categories = $this->Categorymodel->child_and_grandchild_categories($CatFirstSegment['id']);
        $customer = array();
        $customer = $this->memberauth->checkAuth();

        $prodStocked = $prodOutStocked = $prodOutStockedManual = $prodComingSoonManual = [];

        foreach ($products as $productSeq) {
            if ($productSeq['current_quantity'] > 0 && !isset($productSeq['product_stock_status'])) {
                $prodStocked[] = $productSeq;
            }
            if ($productSeq['current_quantity'] <= 0) {
                $prodOutStocked[] = $productSeq;
            }
            if (isset($productSeq['product_stock_status']) && $productSeq['product_stock_status'] == 0) {
                $prodOutStockedManual[] = $productSeq;
            }
            if (isset($productSeq['product_stock_status']) && $productSeq['product_stock_status'] == 1) {
                $prodComingSoonManual[] = $productSeq;
            }
        }

        $products = array_merge($prodStocked, $prodComingSoonManual, $prodOutStockedManual, $prodOutStocked);

        $inner['customer'] = $customer;
        $inner['attrArray'] = $attrValues;
        $inner['attributesIDs'] = $attributesIDs;
        $inner['newAttrs'] = $newAttrs;

        $inner['category'] = $category;
        $inner['sub_categories'] = $sub_categories;
        $inner['sub_child_categories'] = $sub_child_categories;
        $inner['catAttr'] = $catAttr;
        $inner['products'] = $products;
        $inner['child_and_grandchild_categories'] = $child_and_grandchild_categories;
        $inner['category_price_range'] = $this->Productmodel->category_price_range($category['id']);
        $inner['price_slider'] = [
            'min' => isset($extra['selected_min_price']) ? $extra['selected_min_price'] : 0,
            'max' => isset($extra['selected_max_price']) ? $extra['selected_max_price'] : 0,
        ];
        if ($products) {
            $inner['config_ids'] = $this->Productmodel->config_ids($products);
        }

        $jsonItemsArr = array();
        if (!empty($products)) {
            $x = 1;
            foreach ($products as $key => $product) {
                $jsonItems['id'] = $product['product_id'];
                $jsonItems['name'] = $product['name'];
                $jsonItems['price'] = $product['price'];
                $jsonItems['brand'] = "";
                $jsonItems['category'] = $product['cname'];
                $jsonItems['list_position'] = $x;
                $jsonItemsArr[] = $jsonItems;
                $x++;
            }
        }
        $inner['perpage'] = $perpage;
        $inner['page_offset'] = 0;
        $inner['category_id'] = $category['id'];
        $inner['more_products'] = $total_products - count($products);

        $globalBlocks = $this->Pagemodel->getGlobalBlocks(0);
        $inner['globalBlocks'] = $globalBlocks;
        $inner['pagination'] = $this->mypagination->create_links();

        $inner['pagination_data'] = $this->mypagination;

        $shell['meta_title'] = $category['name'];
        $shell['meta_keyword'] = $category['name'];
        $shell['meta_description'] = $category['name'];

        if (!$products) {
            $new_categories = $this->Categorymodel->new_categories();
            $inner['new_categories'] = $new_categories;
            $shell['contents'] = $this->load->view('catalog/category-listing', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/my-page", $shell);
        } else {
            $attribute_filter = $product_attrset = $attrsetProduct = $brand_filter = array();
            $product_attrset = $this->Productmodel->getProductCatAttributeSet($category['id']);
            if (!empty($product_attrset)) {
                $attrsetProduct = array_column($product_attrset, "attr_set_id");
                $attribute_filter = $this->Pagemodel->attribute_filter($category['id'], $attrsetProduct);
            }

            $inner['attribute_filter'] = $attribute_filter;
            $inner['selected_attributes'] = $options;
            $inner['category_url'] = site_url($c_alias);
            $inner['category_alias'] = $c_alias;
            $inner['jsonItemsArr'] = json_encode($jsonItemsArr);
            $inner['trending_categories'] = $trending_categories;
            $inner['all_parent_categories'] = $all_parent_categories;
            //e($inner);
            $shell['contents'] = $this->load->view('catalog/products', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/my-page", $shell);
        }
    }

    public function _product($p_alias = false)
    {
        if (!$this->session->userdata('CUSTOMER_ID')) {
            return redirect('customer/login');
        }
        $product = array();
        $product = $this->Productmodel->fetchByAlias($p_alias);

        if (!$product) {
            $this->utility->show404();
            return;
        }

        $multiImages = array();
        $multiImages = $this->Productmodel->fetchMultiImages($product['id']);

        $productVideos = array();
        $productVideos = $this->Productmodel->fetchProductVideos($product['id']);

        $inner = $shell = array();

        $attributes = array();
        $childProducts = array();
        $childattributes = array();
        $attrCustomNames = array();
        if ($product['type'] == 'config') {
            if ($this->Productmodel->child_count($product['id']) == 0) {
                $this->utility->show404();
                return;
            }

            $childProductsReturn = $this->Productmodel->ChildProductsWithAttributes($product['id']);
            if (empty($childProductsReturn['products'])) {
                $this->utility->show404();
                return;
            }

            $attrCustomNames = $childProductsReturn['attrCustomNames'];
            $childProducts = $childProductsReturn['products'];
            $childattributes = $childProductsReturn['attributes'];
            $inner['productsChild'] = $childProducts;
            $inner['attrCustomNames'] = $attrCustomNames;

            $childPrice = array();
            $pid = array();

            foreach ($childProducts as $ids) {
                $pid[] = $ids['id'];
            }

            $childPrice = $this->Productmodel->getChildPrice($pid, $product['id']);
            if (!empty($childPrice)) {
                $inner['childPrice'] = $childPrice;
            }

            $attributesIDs = array();
            $attributesIDs = $this->Productmodel->attributeIDs($product['id']);

            $aids = $this->Pagemodel->array_column1($attributesIDs, 'attr_id');

            if (!$aids) {
                $aids[] = 1;
            }

            $attrValues = $this->Attributesmodel->fetchAtrrValues($product['id'], $aids);

            if ($attrValues) {
                $inner['attrArray'] = $attrValues;
                $inner['attributesIDs'] = $attributesIDs;
            }
        } else if ($product['type'] == 'combo') {
            $comboProducts = $this->Productmodel->GroupProducts($product['id']);
            $inner['comboProducts'] = $comboProducts;
        } else {
            $attributes = $this->Attributesmodel->fetchByProductID($product['id']);
            $assigned_attrs = $this->Attributesmodel->fetchAssignedOptions($product['id']);
        }

        $reviews = $this->Ratingmodel->getVerifiedReviewsByProductID($product['id']);
        $reviewsAvg = $this->Ratingmodel->getaverage($product['id']);

        $relatedproducts = array();
        $relatedproducts = $this->Productmodel->getRelatedProducts($product['id']);

        if ($relatedproducts) {
            $inner['config_ids'] = $this->Productmodel->config_ids_2($relatedproducts);
        }

        $brochures = array();
        $brochures = $this->Productmodel->getBrochures($product['id']);

        $customer = array();
        $customer = $this->memberauth->checkAuth();
        $tempArray1 = array();
        $tempArray2 = array();
        $tier_pricing = array();

        if ($customer) {
            $tier_pricing = $this->Tiercmsmodel->getDetails($product['id'], $customer['profile_id']);
        } else {
            $tier_pricing = $this->Tiercmsmodel->getAllDetails($product['id']);
        }


        $product_tier_pricing = array();

        $product_tier_pricing = $this->Tiercmsmodel->getTierDetails($product['id']);

        $featured_products = $this->Pagemodel->featuredProduct();
        if ($featured_products) {
            $inner['config_ids'] = $this->Productmodel->config_ids($featured_products);
        }

        $jsonItem['id'] = $product['id'];
        $jsonItem['name'] = $product['name'];
        $jsonItem['list_name'] = "Search Results";
        $jsonItem['brand'] = $product['bname'];
        $jsonItem['category'] = $product['cname'];
        $jsonItem['variant'] = "";
        $jsonItem['list_position'] = $this->cart->total_items();
        $jsonItem['quantity'] = 1;
        if ($product['type'] == 'config') {
            $jsonItem['price'] = $childPrice['price'];
        } else {
            $jsonItem['price'] = $product['price'];
        }

        $inner['jsonItem'] = json_encode($jsonItem);
        $inner['featured_products'] = $featured_products;
        $inner['product'] = $product;
        $inner['customer'] = $customer;
        $inner['multiImages'] = $multiImages;
        $inner['productVideos'] = $productVideos;
        $inner['avgrate'] = $reviewsAvg;
        $inner['reviews'] = $reviews;
        $inner['relatedproducts'] = $relatedproducts;
        $inner['attributes'] = $attributes;
        $inner['assigned_attrs'] = $assigned_attrs;
        $inner['childattributes'] = $childattributes;
        $inner['tier_pricing'] = $tier_pricing;
        $inner['product_tier_pricing'] = $product_tier_pricing;
        $childIDs = $this->Productmodel->childIDs($product['id']);
        $inner['child_images'] = $this->Productmodel->getImages($childIDs);
        $inner['child_images'] = $this->Pagemodel->array_column1($inner['child_images'], 'img');
        $inner['child_images'] = array_unique($inner['child_images']);
        $inner['tempData'] = isset($this->session->userdata["CONFIG_PRODUCT_ID"][$product['id']]) ? $this->session->userdata["CONFIG_PRODUCT_ID"][$product['id']] : array();
        $inner['wishlist_flag'] = $this->Productmodel->is_wishlisted($product['id']);
        $inner['breadcrumbs'] = $this->Productmodel->breadcrumbs($product['cid']);
        $globalBlocks = array();
        $globalBlocks = $this->Pagemodel->getGlobalBlocks(0);
        $inner['globalBlocks'] = $globalBlocks;
        $inner['pdfs'] = $this->Pagemodel->get_pdfs($product['id']);
        $inner['brochures'] = $brochures;

        $accessories = array();
        $accessories = $this->Productmodel->get_accessories($product['id']);
        $inner['accessories'] = $accessories;
        if ($product['type'] == 'config') {
            $viewfile = 'catalog/product-details-config2';
        } else if ($product['type'] == 'combo') {
            $viewfile = 'catalog/product-details-combo';
        } else {
            $viewfile = 'catalog/product-details';
        }

        $shell['product_detail_page'] = 'product_detail_page';
        $shell['meta_title'] = $product['name'];
        $shell['meta_keyword'] = $product['meta_keywords'];
        $shell['meta_description'] = $product['meta_description'];
        $shell['contents'] = $this->load->view($viewfile, $inner, true);
        $this->load->view("themes/" . THEME . "/templates/product", $shell);
    }

    public function offerform()
    {
        $this->load->model('Pagemodel');
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->load->library('encrypt');
        $this->load->library('parser');
        $this->load->library('session');
        $this->load->library('email');

        $response = array();
        $response['msg'] = "";
        $response['status'] = "";
        $response['html'] = "";

        $fname = $this->input->post('fname');
        $lname = $this->input->post('lname');
        $email = $this->input->post('email');
        $contact = $this->input->post('contact');
        $message = $this->input->post('message');
        $subject = $this->input->post('subject');

        $emailpattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
        $telpattern = '/^[0-9]+$/';

        if (trim($fname) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .fnameerror ,';
        }
        if (trim($lname) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .lnameerror ,';
        }
        if (trim($email) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .emailerror ,';
        } else if (!preg_match($emailpattern, $email)) {
            $response['status'] = 'error';
            $response['msg'] .= ' .emailinvaliderror ,';
        }
        if (trim($contact) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .contacterror ,';
        } else if (!preg_match($telpattern, $contact)) {
            $response['status'] = 'error';
            $response['msg'] .= ' .contactinvaliderror ,';
        }
        if (trim($message) == "") {
            $response['status'] = 'error';
            $response['msg'] .= ' .messageerror ';
        }
        if ($response['status'] == "error") {
            echo json_encode($response);
            return false;
        }

        $this->Pagemodel->insertOfferRecord();
        $response['status'] = 'success';
        $response['html'] = 'Thanks for query this offer. We will contact shortly.';

        echo json_encode($response);
    }

    public function _brand($brand, $offset = false)
    {
        $uri = $this->uri->uri_string();
        $this->load->library('mypagination');

        $url_options = explode('~', $uri);
        $url_options = array_map(function ($item) {
            return rawurldecode($item);
        }, $url_options);

        unset($url_options[0]);
        $pagination_string = $options = $other_options = array();
        if ($url_options) {
            foreach ($url_options as $url_option) :
                if (strpos($url_option, 'page-') === false) {
                    $pagination_string[] = $url_option;
                }
                $tmp = explode('-', $url_option);
                $attr = $this->Productmodel->getAttributeIdByName($tmp[0]);
                if ($attr) {
                    if (!isset($options[$attr['id']])) {
                        $options[$attr['id']] = [];
                    }

                    $url_option = explode(',', $tmp[1]);
                    $url_option = $this->Productmodel->getAttributeValueIdByName($url_option, $attr['type']);
                    $options[$attr['id']] = $url_option;
                } else {
                    $other_options[$tmp[0]] = $tmp[1];
                }
            endforeach;
        }

        $extra = [
            'selected_min_price' => isset($other_options['minprice']) ? $other_options['minprice'] : 0,
            'selected_max_price' => isset($other_options['maxprice']) ? $other_options['maxprice'] : 0,
            'offset' => isset($other_options['page']) ? $other_options['page'] : $offset,
        ];

        $perpage = isset($other_options['perpage']) ? $other_options['perpage'] : 16;
        if ($options || $extra['selected_min_price'] || $extra['selected_max_price']) {
            $out = $this->Productmodel->getBrandFiltersProducts($brand['id'], $options, $extra);
        }

        if ($out !== false) {
            $products = $this->Productmodel->listByBrand($brand['id'], $extra['offset'], $perpage, $out, false);
            $total_products = $this->Productmodel->listByBrandCount($brand['id'], $out);
        }
        // Get total number of products of this category.
        if ($pagination_string) {
            $config['base_url'] = base_url() . str_replace(":", '/', $brand['alias']) . "~" . implode('~', $pagination_string);
        } else {
            $config['base_url'] = base_url() . str_replace(":", '/', $brand['alias']);
        }
        $config['uri_segment'] = 4;
        $config['total_rows'] = $total_products;
        $config['per_page'] = $perpage;
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination" style="display:inline-block;">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['prev_link'] = false;

        $config['next_link'] = false;
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a class="page-link disabled" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->mypagination->initialize($config);

        $attributesIDs = $aids = $attrValues = array();

        $customer = array();
        $customer = $this->memberauth->checkAuth();

        $inner['customer'] = $customer;
        $inner['attrArray'] = $attrValues;
        $inner['attributesIDs'] = $attributesIDs;
        $inner['products'] = $products;
        $inner['price_slider'] = [
            'min' => isset($extra['selected_min_price']) ? $extra['selected_min_price'] : 0,
            'max' => isset($extra['selected_max_price']) ? $extra['selected_max_price'] : 0,
        ];
        if ($products) {
            $inner['config_ids'] = $this->Productmodel->config_ids($products);
        }

        $inner['perpage'] = $perpage;
        $inner['page_offset'] = 0;
        $inner['brand_id'] = $brand['id'];
        $inner['more_products'] = $total_products - count($products);

        $inner['pagination'] = $this->mypagination->create_links();

        $inner['pagination_data'] = $this->mypagination;

        $shell['meta_title'] = $brand['meta_title'];
        $shell['meta_keyword'] = $brand['meta_keywords'];
        $shell['meta_description'] = $brand['meta_description'];

        if (!$products) {
            $inner['no_brand_product'] = 1;
            $shell['contents'] = $this->load->view('catalog/category-listing', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/category", $shell);
        } else {
            $attribute_filter = $product_attrset = $attrsetProduct = $brand_filter = array();
            $product_attrset = $this->Productmodel->getProductBidAttributeSet($brand['id']);
            if (!empty($product_attrset)) {
                $attrsetProduct = array_column($product_attrset, "attr_set_id");
                $attribute_filter = $this->Pagemodel->brand_attribute_filter($brand['id'], $attrsetProduct);
            }
            $inner['attribute_filter'] = $attribute_filter;
            $inner['selected_attributes'] = $options;
            $inner['brand_url'] = site_url($brand['alias']);
            $inner['brand'] = $brand;
            $shell['contents'] = $this->load->view('catalog/brand', $inner, true);
            $this->load->view("themes/" . THEME . "/templates/product", $shell);
        }
    }
    public function myForm()
    {
        $this->load->library('form_validation');
        $this->load->helper('security');
        $this->load->model('forms/Formsmodel');

        $validations = [];
        $res = [];
        $post_arr = $_POST;

        foreach ($post_arr as $post_key => $post_item) {
            if (strpos($post_key, '_validation') !== false) {
                $validations[str_replace("_validation", "", $post_key)] = $post_item;
            }
        }

        $this->form_validation->set_error_delimiters('<p>', '');
        foreach ($validations as $field_name => $field_validation) {
            if ($field_validation) {
                if ($field_name == 'g-recaptcha-response') {
                    $secret = DWS_RECAPTCHA_SECRET_KEY;
                    $captcha = $post_arr('g-recaptcha-response');
                    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
                    $response = json_decode($response);
                    if (!$response->success) {
                        $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'trim|required');
                    }
                } else {
                    $validation_pipe = json_decode($field_validation, true);
                    $validation_pipe_str = implode('|', $validation_pipe);
                    // e($validation_pipe_str);
                    // if (strpos($field_name, 'arr_') !== false) {
                    //     $field_name = str_replace("arr_","",$field_name);
                    //     $field_name = json_encode(strval($field_name.'[]'));
                    // }
                    $this->form_validation->set_rules($field_name, str_replace("_", ' ', $field_name), $validation_pipe_str . '|trim');
                }
            }
        }
        if ($this->form_validation->run() == FALSE) {
            $res['success'] = false;
            $res['message'] = validation_errors();
        } else {
            $this->Formsmodel->saveFormData();
            $res['success'] = true;
            $res['message'] = 'Form submitted';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($res));
    }
    public function userlog()
    {
        $cutomer = $this->session->userdata('CUSTOMER_ID');
        $id =  $this->input->post('id');
        $type =  $this->input->post('type');
        $date = date('Y-m-d');
        $this->db->where('comment', $date);
        $this->db->where('created_by', $cutomer);
        $this->db->where('type_id', $id);
        $rs = $this->db->get('logger');
        $result = $rs->row_array();
        if (!$result) :
            $this->logger
                ->user($cutomer) //Set UserID, who created this  Action
                ->type($type)
                ->comment($date)
                ->id($id)
                ->log();
        endif;
    }

    public function projects()
    {
        $result  = [];
        $this->db->where('active', 1);
        $this->db->where('project_cat', $_POST['id']);
        $rs = $this->db->get('projects');
        $data = $rs->result_array();
        $result['html'] = '<p>No Data</p>';
        if ($data) {
            $html = '';
            foreach ($data as $item) {
                $html .= '<li class="list-items" data-id=' . $item['projects_id'] . '>' . $item['projects_title'] . '</li>';
            }
            $result['html'] = $html;
        }
        echo json_encode($result);
    }
    public function projectData()
    {
        $this->db->where('projects_id', $_POST['id']);
        $rs = $this->db->get('projects');
        $data = $rs->row_array();
        $html = '';
        $html .=  '<tr class="container-qty">';
        $html .= ' <td class="dynamic">1</td>';
        $html .=  '<td><input type="text" name="name[]" value="' . $data["projects_title"] . '"></td>';
        $html .=  ' <td><input type="text" name="qty[]" value ="1" class="qty"></td>';
        $html .=  ' <td><input type="text" name="mrp[]" placeholder="MRP"></td>';
        $html .=  '<td><input type="text" name="discount[]" placeholder="Discount"></td>';
        $html .=  '<td><select name="type[]"><option value="dinning">Dinning</option><option value="takeaway">Takeaway</option></select></td>';
        $html .=  '<td><button type="button" class="cart-qty-plus">+</button></td>';
        $html .=  '<td><button type="button" class="cart-qty-minus">-</button></td>';
        $html .=  '<td><span class="recyclebin"><i class="fas fa-trash-alt"></i></span></td>';
        $html .=  ' </tr>';

        $result['html'] = $html;
        echo json_encode($result);
    }
    public function csvExport()
    {
        $fname = "orders-" . time();
        $report_name = "$fname.csv";
        $report_path = $this->config->item('CSV_PATH');
        $fileName = $report_path . $report_name;
        $fileWrite = fopen($fileName, 'w');
        $header = array_keys($_POST);
        fputcsv($fileWrite, $header);
        $array_new = array();
        foreach ($header as $name) {
            foreach ($_POST[$name] as $key => $line) {
                $array_new[$key][$name] = $_POST[$name][$key];
            }
        }
        foreach ($array_new as $new_line) {
            fputcsv($fileWrite, $new_line);
        }
        fclose($fileWrite);
        // carry
        $report_path_new = $this->config->item('CSV_TAKEAWAY_PATH');
        $fileNameNew = $report_path_new . $report_name;
        $fileWrite1 = fopen($fileNameNew, 'w');
        fputcsv($fileWrite1, $header);
        foreach ($array_new as $new_line) {
            if ($new_line['type'] == "takeaway") {
                fputcsv($fileWrite1, $new_line);
            }
        }
        fclose($fileWrite1);
        // close
        $file_download = $this->config->item('CSV_URL') . $report_name;
        if ($file_download == '') {
            echo 'no-data';
        } else {
            echo json_encode(array('report_file' => $file_download));
        }
        exit;
    }
}
