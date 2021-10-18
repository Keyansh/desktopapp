<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Package extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

    //**************************************validation start*****************************************
    //for adding package
    function valid_UrlAlias($str) {
        $this->db->where('package_uri_alias', $str);
        $rs = $this->db->get('package');
        if ($rs->num_rows() >= 1) {
            $this->form_validation->set_message('valid_UrlAlias', 'This alias is already in use.');
            return FALSE;
        }
        return TRUE;
    }

    //for edit package
    function valid_Url_Alias($str) {
        $this->db->where('package_uri_alias', $str);
        $this->db->where('package_id !=', $this->input->post('package_id', TRUE));
        $rs = $this->db->get('package');
        if ($rs->num_rows() >= 1) {
            $this->form_validation->set_message('valid_Url_Alias', 'This alias is already in use.');
            return FALSE;
        }
        return TRUE;
    }

    //for adding show
    function valid_ShowUrlAlias($str) {
        $this->db->where('show_uri_alias', $str);
        $rs = $this->db->get('show');
        if ($rs->num_rows() >= 1) {
            $this->form_validation->set_message('valid_ShowUrlAlias', 'This alias is already in use.');
            return FALSE;
        }
        return TRUE;
    }

    //for edit show
    function valid_ShowUrl_Alias($str) {
        $this->db->where('show_uri_alias', $str);
        $this->db->where('show_id !=', $this->input->post('show_id', TRUE));
        $rs = $this->db->get('show');
        if ($rs->num_rows() >= 1) {
            $this->form_validation->set_message('valid_ShowUrl_Alias', 'This alias is already in use.');
            return FALSE;
        }
        return TRUE;
    }

    //*************************************validation End*******************************************

    function index($sid = 0, $offset = 0) {
        $this->load->model('Packagemodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //Setup pagination
        $perpage = 25;
        $config['base_url'] = base_url() . "package/index/$sid/";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Packagemodel->countAll($sid);
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //fetch all packages
        $packages = array();
        $packages = $this->Packagemodel->listAll($sid, $offset, $perpage);

        //fetch show
        $show = array();
        $show = $this->Packagemodel->getShowDetail($sid);

        $inner = array();
        $inner['packages'] = $packages;
        $inner['show'] = $show;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('package-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function add($sid = FALSE) {
        $this->load->model('Packagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch show
        $show = array();
        $show = $this->Packagemodel->getShowDetail($sid);

        //validation check
        $this->form_validation->set_rules('package_name', 'Package Name', 'trim|required');
        $this->form_validation->set_rules('package_uri_alias', 'Package URL Alias', 'trim|callback_valid_UrlAlias');
        $this->form_validation->set_rules('package_price', 'Package Price', 'trim|required');
        $this->form_validation->set_rules('package_desc', 'Package Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['show'] = $show;
            $page = array();
            $page['content'] = $this->load->view('package-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $cur_show = $this->Packagemodel->insertRecord();
            $this->session->set_flashdata('SUCCESS', 'package_added');

            redirect("package/index/{$cur_show['show_id']}", 'location');
            exit();
        }
    }

    function edit($pkid = FALSE) {
        $this->load->model('Packagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch package
        $package = array();
        $package = $this->Packagemodel->getdetails($pkid);

        //validation check
        $this->form_validation->set_rules('package_name', 'Package Name', 'trim|required');
        $this->form_validation->set_rules('package_uri_alias', 'Package URL Alias', 'trim|callback_valid_Url_Alias');
        $this->form_validation->set_rules('package_price', 'Package Price', 'trim|required');
        $this->form_validation->set_rules('package_desc', 'Package Description', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['package'] = $package;
            $page = array();
            $page['content'] = $this->load->view('package-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $cur_show = $this->Packagemodel->updateRecord($package);
            $this->session->set_flashdata('SUCCESS', 'package_updated');

            redirect("package/index/{$cur_show['show_id']}", 'location');
            exit();
        }
    }

    function delete($pkid) {
        $this->load->model('Packagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch package
        $package = array();
        $package = $this->Packagemodel->getdetails($pkid);
        if (!$package) {
            $this->utility->show404();
            return;
        }

        $this->Packagemodel->deleteRecord($package);
        $this->session->set_flashdata('SUCCESS', 'package_deleted');
        redirect("package/index/{$package['show_id']}", 'location');
        exit();
    }

    function products($pid) {
        $this->load->model('Packagemodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //fetch package
        $package = array();
        $package = $this->Packagemodel->getdetails($pid);

        //fetch all products for package
        $products = array();
        $products = $this->Packagemodel->listAllProducts($package['product_id']);

        $inner = array();
        $inner['package'] = $package;
        $inner['products'] = $products;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('product-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function addproduct($pkid) {
        $this->load->model('Packagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch package
        $package = array();
        $package = $this->Packagemodel->getdetails($pkid);

        //fetch all products
        $products = array();
        $products[''] = '-Select-';
        $rs = array();
        $rs = $this->Packagemodel->getProducts();

        foreach ($rs as $item) {
            $products[$item['product_id']] = $item['product_name'];
        }

        //validation check
        $this->form_validation->set_rules('product_id', 'Product', 'trim|required');
        $this->form_validation->set_rules('product_quantity', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('product_extra_price', 'Extra Price', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['package'] = $package;
            $inner['products'] = $products;
            $page = array();
            $page['content'] = $this->load->view('product-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Packagemodel->insertProduct($pkid);
            $this->session->set_flashdata('SUCCESS', 'package_product_added');

            redirect("package/products/{$package['product_id']}", 'location');
            exit();
        }
    }

    function editproduct($ppid) {
        $this->load->model('Packagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $pack_product = array();
        $pack_product = $this->Packagemodel->getProductDetail($ppid);

        //fetch all products
        $products = array();
        $products[''] = '-Select-';
        $rs = array();
        $rs = $this->Packagemodel->getProducts();

        foreach ($rs as $item) {
            $products[$item['product_id']] = $item['product_name'];
        }

        //validation check
        $this->form_validation->set_rules('bundled_item_id', 'Product', 'trim|required');
        $this->form_validation->set_rules('product_quantity', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('product_extra_price', 'Extra Price', 'trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['pack_product'] = $pack_product;
            $inner['products'] = $products;
            $page = array();
            $page['content'] = $this->load->view('product-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Packagemodel->updateProduct($pack_product['product_bundle_item_id']);
            $this->session->set_flashdata('SUCCESS', 'package_product_updated');

            redirect("package/products/{$pack_product['product_id']}", 'location');
            exit();
        }
    }

    function deleteproduct($ppid) {
        $this->load->model('Packagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        $pack_product = array();
        $pack_product = $this->Packagemodel->getProductDetail($ppid);
        if (!$pack_product) {
            $this->utility->show404();
            return;
        }

        $this->Packagemodel->deleteProduct($pack_product);
        $this->session->set_flashdata('SUCCESS', 'package_product_deleted');
        redirect("package/products/{$pack_product['product_id']}");
        exit();
    }

    function shows($offset = FALSE) {
        $this->load->model('Packagemodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //Setup pagination
        $perpage = 25;
        $config['base_url'] = base_url() . "package/show/";
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->Packagemodel->countAllShow();
        $config['per_page'] = $perpage;
        $this->pagination->initialize($config);

        //fetch all shows
        $shows = array();
        $shows = $this->Packagemodel->listAllShow($offset, $perpage);

        $inner = array();
        $inner['shows'] = $shows;
        $inner['pagination'] = $this->pagination->create_links();

        $page = array();
        $page['content'] = $this->load->view('shows-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function addshow() {
        $this->load->model('Packagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //validation check
        $this->form_validation->set_rules('show_name', 'Show Name', 'trim|required');
        $this->form_validation->set_rules('show_uri_alias', 'Show URL Alias', 'trim|callback_valid_ShowUrlAlias');
        $this->form_validation->set_rules('show_code', 'Show Code', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('show-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Packagemodel->insertShow();
            $this->session->set_flashdata('SUCCESS', 'show_added');

            redirect("package/shows", 'location');
            exit();
        }
    }

    function editshow($sid) {
        $this->load->model('Packagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch show
        $show = array();
        $show = $this->Packagemodel->getShowDetail($sid);

        //validation check
        $this->form_validation->set_rules('show_name', 'Show Name', 'trim|required');
        $this->form_validation->set_rules('show_uri_alias', 'Show URL Alias', 'trim|callback_valid_ShowUrl_Alias');
        $this->form_validation->set_rules('show_code', 'Show Code', 'trim|required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['show'] = $show;
            $page = array();
            $page['content'] = $this->load->view('show-edit', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Packagemodel->updateShow($show);
            $this->session->set_flashdata('SUCCESS', 'show_updated');

            redirect("package/shows", 'location');
            exit();
        }
    }

    function deleteshow($sid) {
        $this->load->model('Packagemodel');
        $this->load->library('form_validation');
        $this->load->helper('form');

        //fetch show
        $show = array();
        $show = $this->Packagemodel->getShowDetail($sid);
        if (!$show) {
            $this->utility->show404();
            return;
        }

        $this->Packagemodel->deleteShow($show);
        $this->session->set_flashdata('SUCCESS', 'show_deleted');
        redirect("package/shows", 'location');
        exit();
    }

}

?>