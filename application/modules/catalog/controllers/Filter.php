<?php

defined('BASEPATH') or exit('No direct script access allowed.');

class Filter extends Cms_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Categorymodel');
        $this->load->model('catalog/Productmodel');
        $this->load->library('mypagination');
    }
    
    function index(){
        $selected_attribute_options = $this->input->post('selected_attribute_options');
        $category_id = $this->input->post('category_id');
        $products = array();
        $inner = array();
        $page = array();
        
        $filtered_pids = $this->Productmodel->getCategoryFilteredProducts($category_id, $selected_attribute_options);
        $products = $this->Productmodel->listByCategory($category_id, false, false, $filtered_pids, false);
        if($products){
            $inner['products'] = $products;
            $page['category_id'] = $category_id;
            $page ['html'] = $this->load->view('filtered-products', $inner, true);
            echo json_encode($page);
            exit();
        }else{
            $page['html'] = "<p class='text-center' style='color:red;'>no-record</p>";
            echo json_encode($page);
            exit();
        }
    }

    function index_OLD($uri) {
        $uri = $this->input->post('url');
        $selected_min_price = 0;
        $category_id = $this->input->post('category_id');
        $c_alias = $this->input->post('category_alias');
        $url_options = explode('~', $uri);
        $url_options = array_map(function($item) {
            return rawurldecode($item);
        }, $url_options);
        $catURl = $url_options[0];
        $total_products = 0;
        unset($url_options[0]);
        $out = $products = $pagination_string = $options = $other_options = array();
        foreach ($url_options as $url_option):
            if (strpos($url_option, 'page-') === false) {
                $pagination_string[] = $url_option;
            }
            $tmp = explode('-', $url_option);
            $attr = $this->Productmodel->getAttributeIdByName($tmp[0]);
            if ($attr) {
                if (!isset($options[$attr['id']]))
                    $options[$attr['id']] = [];
                $url_option = explode(',', $tmp[1]);
                $url_option = $this->Productmodel->getAttributeValueIdByName($url_option, $attr['type']);
                // e($url_option,0);
                $options[$attr['id']] = $url_option;
            }
            else {
                $other_options[$tmp[0]] = $tmp[1];
            }
        endforeach;

        $extra = [
            'selected_min_price' => isset($other_options['minprice']) ? $other_options['minprice'] : 0,
            'selected_max_price' => isset($other_options['maxprice']) ? $other_options['maxprice'] : 0,
            'offset' => isset($other_options['page']) ? $other_options['page'] : 0,
        ];
        $perpage = isset($other_options['perpage']) ? $other_options['perpage'] : 16;
        if ($options || $extra['selected_min_price'] || $extra['selected_max_price']) {
            $out = $this->Productmodel->getCategoryFiltersProducts($category_id, $options, $extra);
        }
        if ($out !== false) {
            $products = $this->Productmodel->listByCategory($category_id, $extra['offset'], $perpage, $out, false);
            $total_products = $this->Productmodel->listByCategoryCount($category_id, $out);
        }
        if ($products) {
            // Get first page of products matching filter criteria.
            if ($pagination_string) {
                $config['base_url'] = base_url() . str_replace(":", '/', $c_alias) . "~" . implode('~', $pagination_string);
            } else {
                $config['base_url'] = base_url() . str_replace(":", '/', $c_alias);
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
            // $config['prev_link'] = '&laquo';
            // $config['prev_tag_open'] = '<li class="prev">';
            // $config['prev_tag_close'] = '</li>';
            // $config['next_link'] = 'next';
            // $config['next_tag_open'] = '<li>';
            // $config['next_tag_close'] = '</li>';
            $config['next_link'] = false;
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active test"><a class="page-link disabled" href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->mypagination->initialize($config);
            // $products = $this->Productmodel->filter_products($out, $order, $options, $perpage, $offset);
            if ($selected_min_price) {
                if ($products) {
                    foreach ($products as $item) {
                        if ($item['least_price'] < $selected_min_price) {
                            $item['least_price'] = child_having_price_more_or_greater_than($item['pid'], $selected_min_price);
                        }
                    }
                }
            }

            $inner = array();
            $inner['total_products'] = $total_products;
            $inner['products'] = $products;
            $inner['filter_flag'] = 1;
            $inner['perpage'] = $perpage;
            $inner['selected_min_price'] = $selected_min_price;
            $inner['pagination_data'] = $this->mypagination;
            $customer = array();
            $customer = $this->memberauth->checkAuth();
            if ($customer) {
                $inner['customer'] = $customer;
                $inner['wishlisted_products'] = wishlisted_products($customer['user_id']);
            }
            $start_offset = $extra['offset'] + 1;
            $end_offset = $extra['offset'] + count($products);

            $page = array();
            $page['category_id'] = $category_id;
            $page['displaying_records'] = "Displaying $start_offset  -  $end_offset  of  $total_products Products";
            $page['pagination'] = $this->mypagination->create_links();
            $page ['html'] = $this->load->view('filtered-products', $inner, true);
            echo json_encode($page);
            exit();
        } else {
            $page = array();
            $page["html"] = "<p class='text-center' style='color:red;'>no-record</p>";
            $page["pagination"] = "";
            echo json_encode($page);
            exit();
        }
    }

    function index_back($offset = 0) {
        // e($offset);
        // e($_POST);
        // e($_POST,0);
        $attr_name_basket = $this->input->post('attr_name_basket');
        $this->load->library('mypagination');
        $category_id = $this->input->post('category_id');
        // e($category_id);
        $catURl = $this->input->post('cat_url');
        $brands = $this->input->post('brands');
        $options = $this->input->post('options');
        $selected_min_price = $this->input->post('selected_min_price');
        $selected_max_price = $this->input->post('selected_max_price');
        $order = $this->input->post('order');
        $ppids = $this->input->post('pid');

        if ($this->input->post('perpage')) {
            $perpage = $this->input->post('perpage');
        } else {
            $perpage = 20;
        }
        if ($order == "low") {
            $order = 'ASC';
        }
        if ($order == 'high') {
            $order = 'DESC';
        }
        if ($brands == '' && $options == '' && !$selected_min_price && !$selected_max_price) {
            $products = array();
            if ($ppids != "") {
                $ppids = $ppids;
            } else {
                $ppids = false;
            }
            $config['base_url'] = base_url() . $catURl . "/";
            $config['uri_segment'] = 4;
            $config['total_rows'] = $this->Productmodel->countByCategory($category_id, $filteredProductIds = FALSE);
            $config['per_page'] = $perpage;
//                e($config);
            //config for bootstrap pagination class integration
            $config['full_tag_open'] = '<ul class="pagination" style="display:inline-block;">';
            $config['full_tag_close'] = '</ul>';
            $config['first_link'] = false;
            $config['last_link'] = false;
            $config['first_tag_open'] = '<li class="page-item">';
            $config['first_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo';
            $config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            $config['next_link'] = 'next';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active test"><a class="page-link disabled" href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->mypagination->initialize($config);
            $products = $this->Productmodel->listByCategory($category_id, $offset, $perpage, $ppids, $order);
            $inner = array();
            $inner['products'] = $products;
            $page = array();
            $page['attr_name_basket'] = $attr_name_basket;
            $page['pagination'] = $this->mypagination->create_links();
            $page ['html'] = $this->load->view('filtered-products', $inner, true);

            echo json_encode($page);
            exit();
        } else {
            $url_options = explode('~', $this->uri->uri_string());
            $category = explode('/', $url_options[0]);
            $category = end($category);
            unset($url_options[0]);
            $pagination_string = $options = $other_options = array();
            foreach ($url_options as $url_option):
                if (strpos($url_option, 'page-') === false) {
                    $pagination_string[] = $url_option;
                }

                $tmp = explode('-', $url_option);
                $attr = $this->Productmodel->getAttributeIdByName($tmp[0]);
                if ($attr) {
                    if (!isset($options[$attr['id']]))
                        $options[$attr['id']] = [];
                    $url_option = explode(',', $tmp[1]);
                    $url_option = $this->Productmodel->getAttributeValueIdByName($url_option, $attr['type']);
                    $options[$attr['id']] = $url_option;
                }
                else {
                    $other_options[$tmp[0]] = $tmp[1];
                }
            endforeach;
            // e($other_options);
            $extra = [
                'selected_min_price' => $selected_min_price,
                'selected_max_price' => $selected_max_price,
                'offset' => isset($other_options['page']) ? $other_options['page'] : 0
            ];
            $out = $this->Productmodel->getCategoryFiltersProducts($category_id, $options, $extra);
            if ($out) {

                // Get number of products matching filter criteria.
                $total_products = $this->Productmodel->listByCategoryCount($category_id, $out);
                // e('$total_products');
                // Get first page of products matching filter criteria.
                $config['base_url'] = base_url() . $category . "~" . implode('~', $pagination_string);
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
                $config['prev_link'] = '&laquo';
                $config['prev_tag_open'] = '<li class="prev">';
                $config['prev_tag_close'] = '</li>';
                $config['next_link'] = 'next';
                $config['next_tag_open'] = '<li>';
                $config['next_tag_close'] = '</li>';
                $config['last_tag_open'] = '<li>';
                $config['last_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li class="active test"><a class="page-link disabled" href="#">';
                $config['cur_tag_close'] = '</a></li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';

                $this->mypagination->initialize($config);
                // $products = $this->Productmodel->filter_products($out, $order, $options, $perpage, $offset);
                $products = $this->Productmodel->listByCategory($category_id, $extra['offset'], $perpage, $out, false);
                if ($selected_min_price) {
                    if ($products) {
                        foreach ($products as $item) {
                            if ($item['least_price'] < $selected_min_price) {
                                $item['least_price'] = child_having_price_more_or_greater_than($item['pid'], $selected_min_price);
                            }
                        }
                    }
                }

                $inner = array();
                $inner['total_products'] = $total_products;
                $inner['products'] = $products;
                $inner['filter_flag'] = 1;
                $inner['perpage'] = $perpage;
                $inner['price_order'] = $order;
                $inner['selected_min_price'] = $selected_min_price;
                $customer = array();
                $customer = $this->memberauth->checkAuth();

                if ($customer) {
                    $inner['customer'] = $customer;
                    $inner['wishlisted_products'] = wishlisted_products($customer['user_id']);
                }

                $page = array();
                $page['category_id'] = $category_id;
                $page['pagination'] = $this->mypagination->create_links();
                $page['attr_name_basket'] = $attr_name_basket;
                $page ['html'] = $this->load->view('filtered-products', $inner, true);
                $page['selectedAttr'] = [];
                echo json_encode($page);
                exit();
            } else {
                $page = array();
                $page['attr_name_basket'] = $attr_name_basket;
                $page["html"] = "<p class='text-center' style='color:red;'>no-record</p>";
                $page["pagination"] = "";
                echo json_encode($page);
                exit();
            }
        }
    }

    function brand($uri) {
        $uri = $this->input->post('url');
        $bid = $this->input->post('bid');
        $brand_alias = $this->input->post('brand_alias');

        $c_alias = $uri;
        $url_options = explode('~', $uri);
        $url_options = array_map(function($item) {
            return rawurldecode($item);
        }, $url_options);

        $catURl = $url_options[0];
        $total_products = 0;
        unset($url_options[0]);
        $out = $products = $pagination_string = $options = $other_options = array();
        foreach ($url_options as $url_option):
            if (strpos($url_option, 'page-') === false) {
                $pagination_string[] = $url_option;
            }
            $tmp = explode('-', $url_option);
            $attr = $this->Productmodel->getAttributeIdByName($tmp[0]);
            if ($attr) {
                if (!isset($options[$attr['id']]))
                    $options[$attr['id']] = [];
                $url_option = explode(',', $tmp[1]);
                $url_option = $this->Productmodel->getAttributeValueIdByName($url_option, $attr['type']);
                // e($url_option,0);
                $options[$attr['id']] = $url_option;
            }
            else {
                $other_options[$tmp[0]] = $tmp[1];
            }
        endforeach;

        $extra = [
            'selected_min_price' => isset($other_options['minprice']) ? $other_options['minprice'] : 0,
            'selected_max_price' => isset($other_options['maxprice']) ? $other_options['maxprice'] : 0,
            'offset' => isset($other_options['page']) ? $other_options['page'] : 0,
        ];
        $perpage = isset($other_options['perpage']) ? $other_options['perpage'] : 16;
        if ($options || $extra['selected_min_price'] || $extra['selected_max_price']) {
            $out = $this->Productmodel->getBrandFiltersProducts($bid, $options, $extra);
        }

        if ($out !== false) {
            $products = $this->Productmodel->listByBrand($bid, $extra['offset'], $perpage, $out, false);
            $total_products = $this->Productmodel->listByBrandCount($bid, $out);
        }
        if ($products) {
            // Get first page of products matching filter criteria.
            if ($pagination_string) {
                $config['base_url'] = base_url() . str_replace(":", '/', $brand_alias) . "~" . implode('~', $pagination_string);
            } else {
                $config['base_url'] = base_url() . str_replace(":", '/', $brand_alias);
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
            $config['cur_tag_open'] = '<li class="active test"><a class="page-link disabled" href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->mypagination->initialize($config);
            // $products = $this->Productmodel->filter_products($out, $order, $options, $perpage, $offset);

            $inner = array();
            $inner['total_products'] = $total_products;
            $inner['products'] = $products;
            $inner['filter_flag'] = 1;
            $inner['perpage'] = $perpage;
            $inner['pagination_data'] = $this->mypagination;
            $customer = array();
            $customer = $this->memberauth->checkAuth();
            if ($customer) {
                $inner['customer'] = $customer;
            }
            $start_offset = $extra['offset'] + 1;
            $end_offset = $extra['offset'] + count($products);

            $page = array();
            $page['bid'] = $bid;
            $page['displaying_records'] = "Displaying $start_offset  -  $end_offset  of  $total_products Products";
            $page['pagination'] = $this->mypagination->create_links();
            $page ['html'] = $this->load->view('filtered-products', $inner, true);
            echo json_encode($page);
            exit();
        } else {
            $page = array();
            $page["html"] = "<p class='text-center' style='color:red;'>no-record</p>";
            $page["pagination"] = "";
            echo json_encode($page);
            exit();
        }
    }

}

?>
