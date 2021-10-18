<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Category extends Cms_Controller {

    function index($c_alias = FALSE, $keywords = 0, $offset = FALSE) {
        $this->load->model('Categorymodel');
        $this->load->model('cart/Cartmodel');
        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->library('form_validation');

        //Category Details
        $category = array();
        $category = $this->Categorymodel->fetchByAlias($c_alias);
        //print_R($category); exit();

        if (!$category) {
            $this->utility->show404();
            return;
        }
        //echo $c_alias; exit();
        //Fetch sub-categories
        $show_products = false;
        $sub_categories = array();
        $sub_categories = $this->Categorymodel->getSubCategories($category['category_id']);

        if (empty($sub_categories)) {
            $show_products = true;
            $sub_categories = $this->Categorymodel->getSubCategories($category['parent_id']);
        }

        //Fetch Products
        $products = array();
        $category_attributes = array();
        $attribute_values = array();

        if ($show_products) {

            $products = $this->Categorymodel->fetchProducts($category['category_id'], $category);
            $category_attributes = $this->Categorymodel->fetchAttributes($category['category_id']);

            foreach ($category_attributes as $row) {
                $attribute_values[$row['attribute_id']] = $this->Categorymodel->listUniqueAttributeValues($row);
            }
        }

        $selected_products = array();
        $search_keyword = isset($_POST['search']) ? $_POST['search'] : '';
        if (!empty($search_keyword)) {
            $search_keyword = strtolower($search_keyword);
            foreach ($products as $prodDetail) {
                $prod_name = strtolower($prodDetail['product']['product_name']);
                $prod_desc = strtolower($prodDetail['product']['product_description']);
                $in_name = strpos($prod_name, $search_keyword);
                $in_description = strpos($prod_desc, $search_keyword);
                if ($in_description !== false || $in_name !== false) {
                    $selected_products[] = $prodDetail;
                }
            }
        }

        if ($this->input->post('search')) {
            $keywords = $this->input->post('search', TRUE);
        }

        foreach ($attribute_values as $attr => $value) {
            //Get Search Criteria
            if ($this->input->post("attribute_{$attr}")) {
                $keywords = $this->input->post(("attribute_{$attr}"), TRUE);
            }
        }

//        echo $keywords;
        if ($keywords) {
            $products = $this->Categorymodel->listAll($attribute_values, $category['category_id']);
        }
//        exit;
        if ($keywords == '0' || trim($keywords) == '') {
            $keywords = '';
        }

        if ($keywords && !count($products) && $selected_products) {
            $products = $selected_products;
        }
        $sortOrder = false;
        $post_order = null;
        $prodIndexSort = array();
        $prodIndexCombSort = array();
        $prodIndexPostSort = array();

        foreach ($products as $index => $prod) {
            if (isset($prod['attributes']) && is_array($prod['attributes']) && count($prod['attributes'])
            ) {
                foreach ($prod['attributes'] as $prodAttr) {
                    if ($prodAttr['attribute_label'] == $category['attribute_sort'] || $prodAttr['attribute_field_name'] == $category['attribute_sort']) {
                        $sortOrder = true;
                        $prodIndexSort[$index] = $prodAttr['attribute_value'];
                        $test_val = trim($prodAttr['attribute_value']);
                        $prodIndexPostSort[$prodAttr['attribute_postfix']][$index] = $this->getNumPart($test_val);
                        if (!empty($category['combined_attribute_sort'])) {
                            $param = array(
                                'product_index' => $index,
                                'search_stack' => $prod['attributes'],
                                'category' => $category,
                            );
                            $this->getCombSorting($prodIndexCombSort[$prodAttr['attribute_postfix']], $param);
                        }
                    } else if (empty($prodIndexSort[$index])) {
                        if (!empty($category['attribute_sort'])) {
                            $prodIndexSort[$index] = $prod['product']['product_sort_order'];
                            $prodIndexPostSort[""][$index] = "";
                        } else {
                            $prodIndexSort[$index] = $prod['product']['product_sort_order'];
                        }
                    }
                }
            } else {
                $prodIndexSort[$index] = $prod['product']['product_sort_order'];
            }
        }


        if ($sortOrder) {
            $all_prod = array();
            $sub_key_sorting = array();
            $post_keys = array_keys($prodIndexPostSort);
            ksort($prodIndexPostSort);
            if ($category['attribute_post_order'] == 'desc') {
                krsort($prodIndexPostSort);
            }

            $multi = false;
            if (!empty($category['combined_attribute_post_order'])) {
                foreach ($prodIndexPostSort as $fstDet => $fstDetArr) {
                    foreach ($fstDetArr as $pindex => $pval) {
                        $all_prod[$pindex] = array(
                            'pid' => $pindex,
                            'f_post_key' => $fstDet,
                            'f_post_val' => $pval,
                        );
                    }
                }

                foreach ($post_keys as $sub_key) {
                    if (isset($prodIndexCombSort[$sub_key]) && is_array($prodIndexCombSort[$sub_key])) {
                        $multi = true;
                        foreach ($prodIndexCombSort[$sub_key] as $sb_index => $sb_det) {
                            foreach ($sb_det as $pindex => $pval) {
                                $all_prod[$pindex]['s_post_key'] = $sb_index;
                                $all_prod[$pindex]['s_post_val'] = $pval;
                            }
                        }
                    }
                }
            }

            $indexed_sort_result_arr = array();
            if (!$multi) {
                foreach ($prodIndexPostSort as $postIndex => $postArry) {

                    asort($prodIndexPostSort[$postIndex]);
                    if ($category['attribute_order'] == 'desc') {
                        arsort($prodIndexPostSort[$postIndex]);
                    }
                    $indexed_sort_result_arr += $prodIndexPostSort[$postIndex];
                }

                $prodIndexPostSort = $indexed_sort_result_arr;
                $prodIndexSort = $prodIndexPostSort;
            } else {
                $fst_key = SORT_ASC;
                if ($category['attribute_post_order'] == 'desc') {
                    $fst_key = SORT_DESC;
                }

                $snd_key = SORT_ASC;
                if ($category['combined_attribute_post_order'] == 'desc') {
                    $snd_key = SORT_DESC;
                }

                $fst_val = SORT_ASC;
                if ($category['attribute_order'] == 'desc') {
                    $fst_val = SORT_DESC;
                }

                $snd_val = SORT_ASC;
                if ($category['combined_attribute_order'] == 'desc') {
                    $snd_val = SORT_DESC;
                }

                $sorted = $this->array_orderby($all_prod, 'f_post_key', $fst_key, 'f_post_val', $fst_val, 's_post_key', $snd_key, 's_post_val', $snd_val);


                $prodIndexPostSort = array();
                foreach ($sorted as $prod) {
                    $prodIndexPostSort[$prod['pid']] = $prod['pid'];
                }
                $prodIndexSort = $prodIndexPostSort;
            }
        }


//        echo "<pre>"; print_R($products); exit;
        $inner = array();
        $shell = array();

        $inner['keywords'] = $keywords;
        $inner['c_alias'] = $c_alias;
        $inner['show_products'] = $show_products;
        $inner['category'] = $category;
        $inner['category_attributes'] = $category_attributes;
        $inner['attribute_values'] = $attribute_values;
        $inner['sub_categories'] = $sub_categories;
        $inner['prodIndexSort'] = $prodIndexSort;
        $inner['products'] = $products;
        $inner['pagination'] = $this->pagination->create_links();


        if (!$show_products) {
            $shell['contents'] = $this->load->view('category', $inner, true);
        } else {
            $this->assets->addFooterJS('js/website/product_listing.js', 200);
            $shell['contents'] = $this->load->view('products', $inner, true);
        }
        $this->load->view("themes/" . THEME . "/templates/subpage", $shell);
    }

    private function getNumPart($test_val) {
        /*
         * check starting from numeric part
         */
        $pattern = '/^(\.)?[0-9]*/';
        preg_match($pattern, $test_val, $matches_out);
        if (isset($matches_out[0]) && !empty($matches_out[0])) {

            /**
             * check is any alphabet exist
              $prodIndexPostSort[$prodAttr['attribute_postfix']][$index] = floatval(trim($prodAttr['attribute_value']));
              $prodIndexPostSort[$prodAttr['attribute_postfix']][$index] = round(trim($prodAttr['attribute_value']), 50);
              $prodAttr['attribute_value'] = $prodAttr['attribute_value'].' '.$prodAttr['attribute_postfix'];
             */
            preg_match('~[a-zA-Z]~i', $test_val, $matches_out, PREG_OFFSET_CAPTURE);
            if (isset($matches_out[0][1]) && !empty($matches_out[0][1])) {
                $numeric_section = substr($test_val, 0, $matches_out[0][1]);
            } else {
                $test_val = trim($test_val, "-");
                $test_val = trim($test_val, "+");
                $numeric_section = $test_val;
            }

            $numeric_section_part = explode(".", $numeric_section);
            $decimal_section = 0;
            /*
             * check is decimal part exist and is / part exist
             */
            if (isset($numeric_section_part[1]) && preg_match('~[\/]~i', $test_val, $matches_out)) {
                eval('$result = (' . $numeric_section_part[1] . ');');
                $decimal_section = $result;
            } else {
                $numeric_section_part[0] = $numeric_section;
            }

            eval('$numresult = (' . $numeric_section_part[0] . ');');
            $numeric_section_part[0] = $numresult;
            $numeric_section = $numeric_section_part[0] + $decimal_section;
            return $numeric_section;
        } else {
            return $test_val;
        }
    }

    private function getCombSorting(&$sortingArr, $param) {
        foreach ($param['search_stack'] as $prodAttr) {
            if ($prodAttr['attribute_label'] == $param['category']['combined_attribute_sort'] || $prodAttr['attribute_field_name'] == $param['category']['combined_attribute_sort']) {
                $test_val = trim($prodAttr['attribute_value']);
                $sortingArr[$prodAttr['attribute_postfix']][$param['product_index']] = $this->getNumPart($test_val);
            } else {
                //$sortingArr[][$param['product_index']] = "";
            }
        }
    }

    private function array_orderby() {
        $args = func_get_args();
        $data = array_shift($args);

        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row) {
                    $tmp[$key] = isset($row[$field]) ? $row[$field] : "";
                }
                $args[$n] = $tmp;
            }
        }

        $args[] = &$data;

        call_user_func_array('array_multisort', $args);

        return array_pop($args);

    }
}
