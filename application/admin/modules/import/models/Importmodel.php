<?php

class Importmodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //fix record
    function fixRecord($record) {
        $output = array();
        $output = array_map('trim', $record);
        foreach ($output as $key => $val) {
            $val = preg_replace("/\s+/", " ", $val);
            $output[$key] = utf8_encode($val);
        }
        return $output;
    }

    //delete the csv file
    function deletefile($file_name) {
        $path = $this->config->item('CSV_PATH');
        $filename = $path . $file_name;
        if (file_exists($filename)) {
            @unlink($filename);
        }
    }

    //upload csv file
    function csvfile() {
        $config = array();
        $config['upload_path'] = $this->config->item('IMPORT_PRODUCT_PATH');
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);
        if (count($_FILES) > 0) {
            //Check for valid document upload
            if ($_FILES['document']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['document']['tmp_name'])) {
                if (!$this->upload->do_upload('document')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    //Add Entry to database
                    $file_name = $upload_data['file_name'];
                    return $file_name;
                }
            }
        }
        return FALSE;
    }

    function extractData($file) {
        $content = file($file);

        $array = array();
        for ($i = 0; $i < count($content); $i++) {
            $line = explode('|', $content[$i]);
            for ($j = 0; $j < count($line); $j++) {
                $array[$i][$j + 1] = $line[$j];
            }
        }

        $headers = $array[0];
        unset($array[0]);
        $headers = array_map('strtolower', $headers);
        $headers = array_map('trim', $headers);
        $return['header'] = $headers;
        foreach ($array as $k => $a) {
            $a = array_map('trim', $a);
            $array[$k] = array_combine(array_values($headers), array_values($a));
        }

        $return['data'] = $array;
        return $return;
    }

    function import($products) {
        $this->load->model('catalog/productmodel');
        $this->load->model('catalog/categorymodel');
        $this->load->model('catalog/attributesmodel');
        $this->load->model('catalog/attributeoptionmodel');

        $result = [];
//        e($products,0);
        foreach ($products as $product) {
//            e($product);
            //make a new function for fetch attributes with attribute id
            $response = ['saved' => 'no', 'message' => ''];
            if (!isset($product['sku']) || !$product['sku']) {
                $response['message'] = 'sku is missing';
                $result[] = ['product' => $product, 'response' => $response];
                continue;
            }
            $dbProduct = $this->productmodel->getProductBySku($product['sku']);
            /* filter according to type start */
            if ($this->importType == 1 && $dbProduct) {
                $response['message'] = 'product already exists';
                $result[] = ['product' => $product, 'response' => $response];
                continue;
            } else if ($this->importType == 2 && !$dbProduct) {
                $response['message'] = 'product not exists';
                $result[] = ['product' => $product, 'response' => $response];
                continue;
            }
            /* filter according to type end */
            $dbCategory = $additional_categories = [];
            $parent_id = false;
            if (isset($product['parent_sku'])) {
                $parent_id = $this->productmodel->getProduct($product['parent_sku'], 'id');
                if (isset($parent_id['id'])) {
                    $parent_id = $parent_id['id'];
                }
            }
            // e($product);
            //old function for fetch attributes with category id
            $category = $product['category'];
            $category = explode('::', $category);
            $categorySet = false;
            foreach ($category as $value) {
                $categorySet = true;
                $tmp = explode(':', $value);
                if (isset($tmp[1]) && $tmp[1] && $tmp[0]) {
                    $dbCategory = $this->categorymodel->getCategoryDetailByName($tmp[0], 'id,attrset_id');
                } elseif (isset($tmp[1]) && $tmp[0] && ($tmp[1] == 0)) {
                    $tmp = $this->categorymodel->getCategoryDetailByName($tmp[0], 'id');
                    if ($tmp) {
                        $additional_categories[] = $tmp;
                    }
                }
            }
            if (!$categorySet) {
                $response['message'] = 'Category not assigned';
                $result[] = ['product' => $product, 'response' => $response];
                continue;
            }
//            if (!$dbCategory) {
//                $response['message'] = 'main category not found';
//                $result[] = ['product' => $product, 'response' => $response];
//                continue;
//            }
            //make a new function for fetch attributes with attribute id
            $attr_set = $this->attributesmodel->getAttributebyName($product['attribute_set']);
            if (!$attr_set) {
                $response['message'] = 'Attribute set not found';
                $result[] = ['product' => $product, 'response' => $response];
                continue;
            }


            if ($attr_set) {
                $attributes = $this->attributesmodel->getAttributes($attr_set['id']);
            }
            $tableFields = $this->db->list_fields('product');
            $data = $dataAttributes = $images = $cat_ids = [];
            foreach ($tableFields as $tf) {
                if (isset($product[$tf])) {
                    $data[$tf] = $product[$tf];
                }
            }

            if (isset($attr_set['id'])) {
                $data['attr_set_id'] = ($attr_set['id']) ? $attr_set['id'] : NULL;
            }
            if (isset($data['price']) && !$data['price']) {
                $data['price'] = 0.00;
            }
            if (isset($data['inc_or_exl_tax']) && !$data['inc_or_exl_tax']) {
                $data['inc_or_exl_tax'] = 1;
            }
            if (isset($data['is_taxable']) && !$data['is_taxable']) {
                $data['is_taxable'] = 1;
            }
            if (!isset($data['is_active'])) {
                $data['is_active'] = 1;
            }
            if (!isset($data['is_active'])) {
                $data['is_active'] = 1;
            }

            if (isset($product['special_price'])) {
                $data['srp_price'] = ($product['special_price']) ? $product['special_price'] : 0.00;
            }




            // saving product starts
            if ($dbProduct) {
                $this->db->where('id', $dbProduct['id']);
                if (isset($data['print_profile']) && !$data['print_profile']) {
                    $data['print_profile'] = 0;
                }
                if (isset($data['tax_class']) && !$data['tax_class']) {
                    $data['tax_class'] = 0;
                }
                $this->db->update('product', $data);
                $product_id = $dbProduct['id'];
            } else {
                if (empty($data['alert_qty'])) {
                    $data['alert_qty'] = 0;
                }
                if (empty($data['quantity'])) {
                    $data['quantity'] = 0;
                }
                if (empty($data['name'])) {
                    $data['name'] = str_replace('-', ' ', $data['sku']);
                }
                if (isset($data['print_profile']) && !$data['print_profile']) {
                    $data['print_profile'] = 0;
                }
                if (isset($data['tax_class']) && !$data['tax_class']) {
                    $data['tax_class'] = 0;
                }

                $data['uri'] = $this->_slug($data['name']);


                /* $i = 1;
                $uri = preg_replace('/[^a-z0-9]/i', '-', $data['name']);
                $not_unique = $this->db
                                ->from('product')
                                ->where('uri', $uri)
                                ->get()->result_array();
                while ($not_unique) {
                    $uri = preg_replace('/[^a-z0-9]/i', '-', $data['name'] . $i);
                    $not_unique = $this->db
                                    ->from('product')
                                    ->where('uri', $uri)
                                    ->get()->result_array()
                    ;
                    $i++;
                }
                $uri = rtrim($uri, '-');
                $data['uri'] = $uri; */

                $this->db->insert('product', $data);
                $product_id = $this->db->insert_id();
            }

            // saving product image starts
            $images_ctn = [];
            $images = (isset($product['images']) && $product['images'] != '') ? explode(':::', $product['images']) : [];
//            e($images);
            foreach ($images as $image) {
                $tmp = explode('::', $image);
                $tmp = [
                    'image' => $tmp[0],
                    'main' => $tmp[1],
                    'type' => strpos($tmp[0], 'http') > -1 ? 'url' : 'path',
                    'alt' => isset($tmp[2]) ? $tmp[2] : ''
                ];
                if ($tmp['type'] == 'path' && $tmp['image'] != '') {
                    $file = $this->config->item('IMPORT_PRODUCTIMAGES_PATH') . $tmp['image'];
                    if (!file_exists($file)) {
                        continue;
                    }

                    $destination = $this->config->item('PRODUCT_PATH') . $tmp['image'];
                    $i = 0;
                    while (file_exists($destination)) {
                        $destination = $this->config->item('PRODUCT_PATH') . $i . $tmp['image'];
                        $i++;
                    }
                    if (copy($file, $destination)) {
                        $tmp['image'] = $destination;
                        $images_ctn[] = $tmp;
                    }
                } elseif ($tmp['type'] == 'url') {
                    $t = urldecode(end(explode('/', $tmp['image'])));
                    $destination = $this->config->item('PRODUCT_PATH') . $t;
                    $i = 0;
                    while (file_exists($destination)) {
                        $destination = $this->config->item('PRODUCT_PATH') . $i . $t;
                        $i++;
                    }
                    if (copy($tmp['image'], $destination)) {
                        $tmp['image'] = $destination;
                        $images_ctn[] = $tmp;
                    }
                } else {
                    continue;
                }
            }

            if ($images_ctn) {
                $product_old_images = $this->db
                                ->from('prod_img t1')
                                ->where('t1.pid', $product_id)
                                ->get()->result_array()
                ;
                $remove_image_ids = [];
                foreach ($product_old_images as $product_old_image) {
                    $path = $this->config->item('PRODUCT_PATH') . $product_old_image['img'];
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    $remove_image_ids[] = $product_old_image['id'];
                }
                if ($remove_image_ids) {
                    $this->db
                            ->where_in('id', $remove_image_ids)
                            ->delete('prod_img')
                    ;
                }
                foreach ($images_ctn as $key => $uploaded_image) {
                    $image = end(explode('/', $uploaded_image['image']));
                    $tmp = [
                        'pid' => $product_id,
                        'img' => $image,
                        'orignal_name' => $image,
                        'main' => ($uploaded_image['main']) ? $uploaded_image['main'] : 0,
                        'imgalt' => $uploaded_image['alt']
                    ];
                    $images_ctn[$key] = $tmp;
                }
                $this->db->insert_batch('prod_img', $images_ctn);
                // e($images_ctn);
            }
            // saving product image ended
            // saving product ends
            if ($product_id) {
                $response['saved'] = 'yes';
            }

            if (isset($product['tier_prices']) && $product['tier_prices']) {
                $tier_prices = $product['tier_prices'];
                $tier_prices = explode('::', $tier_prices);
                // ee($tier_prices);
                foreach ($tier_prices as $tier_price) {
                    $tmp = explode(':', $tier_price);
                    // index 0 => name , 1 => quantity , 2 => price
                    if (count($tmp) != 3)
                        continue;
                    $group_name = $tmp[0];
                    $tier_quantity = intval($tmp[1]);
                    $tier_price = floatval($tmp[2]);
                    $profile = $this->getUserProfile($group_name);
                    if (!$profile)
                        continue;
                    $this->updateProductTierPrice($profile['id'], $product_id, $tier_quantity, $tier_price);
                }
            }
            // assign categories start
            $this->db->where('cid', $dbCategory['id']);
            $this->db->where('pid', $product_id);
            $this->db->from('cat_prod');
            $row = $this->db->get()->row_array();

            if (isset($dbCategory['id'])) {
                if (!$row) {
                    $this->db->insert('cat_prod', ['cid' => $dbCategory['id'], 'pid' => $product_id, 'main' => 1]);
                }
            }
            $cat_ids[] = $dbCategory['id'];
            foreach ($additional_categories as $value) {
                $cat_ids[] = $value['id'];
                $this->db->where('cid', $value['id']);
                $this->db->where('pid', $product_id);
                $this->db->from('cat_prod');
                $row = $this->db->get()->row_array();
                if (!$row) {
                    if (!$value['id']) {
                        // e($additional_categories,0);
                        // e($value);
                    }
                    $data = ['cid' => $value['id'], 'pid' => $product_id, 'main' => 0];
                    $this->db->insert('cat_prod', $data);
                }
            }
            // assign categories end
            //clear changed categories started
            $this->db->where_not_in('cid', $cat_ids);
            $this->db->where('pid', $product_id);
            $this->db->delete('cat_prod');
            //clear changed categories end
//            e($attributes);
            foreach ($attributes as $attribute) {
                $attribute['code'] = strtolower($attribute['code']);
                $option_value = null;
                $options = $this->attributeoptionmodel->listAll($attribute['id']);
                $value = isset($product[$attribute['code']]) ? $product[$attribute['code']] : '';
                if ($attribute['type'] == 'dropdown' || $attribute['type'] == 'radio') {
                    foreach ($options as $option) {
                        $option['option'] = trim($option['option']) . ' ' . trim($option['additional_info']);
                        $option['option'] = trim($option['option']);
                        if (strtolower($option['option']) == strtolower($value)) {
                            $option_value = $option['id'];
                        }
                    }
                    if (!$option_value && $value) {
                        if ($value != 'assigned' || $value != 'assigned:1') { //check for stop the 'assigned' value assignment in db
                            $option_value = $this->addAttributeOption($attribute['id'], $value);
                        }
                    }
                }
                if ($option_value) {
                    $this->attributeValue($product_id, $attribute['id'], $attribute['type'], $option_value);
                }
//                elseif (($product['type'] == 'config' || $product['type'] == 'bundle') && $value == 'assigned') {
                if (($product['type'] == 'config' || $product['type'] == 'bundle') && $value == 'assigned' || $value == 'assigned:1') {
                    $forismain = explode(':', $value);
                    $main = $forismain[1] ? 1 : 0;
                    $this->insertAssginedAttributes($product_id, $attribute['id'], $main);
                }
            }

            // assign product to parent
            if ($parent_id) {
                $row = $this->db
                                ->from('product_configurable_link')
                                ->where('parent_id', $parent_id)
                                ->where('child_id', $product_id)
                                ->get()->row_array()
                ;
                if (!$row) {
                    $data = ['parent_id' => $parent_id, 'child_id' => $product_id];
                    $this->db->insert('product_configurable_link', $data);
                }
            }
            $result[] = ['product' => $product, 'response' => $response];
        }
        $this->download_send_headers('response.csv');
        echo $this->importOutput($result);
        exit;
    }

    function updateProductTierPrice($profile_id, $product_id, $quantity, $price) {
        $result = $this->db
                        ->where('tier_product_id', $product_id)
                        ->where('tier_profile_id', $profile_id)
                        ->where('tier_qty', $quantity)
                        ->from('tier_price')
                        ->get()->row_array()
        ;
        $data = ['tier_profile_id' => $profile_id, 'tier_product_id' => $product_id, 'tier_qty' => $quantity, 'tier_price' => $price];
        if (!$result) {
            $this->db->insert('tier_price', $data);
        } else {
            $this->db
                    ->where('tier_product_id', $product_id)
                    ->where('tier_profile_id', $profile_id);
            $this->db->update('tier_price', $data);
        }
    }

    function getUserProfile($groupName) {
        $groupName = trim(strtolower($groupName));
        if ($groupName == 'all group') {
            return ['id' => 0];
        }
        return $this->db
                        ->where('profile_name', $groupName)
                        ->from('profilegroup')
                        ->get()
                        ->row_array()
        ;
    }

    function getproductId($id) {
        $this->db->from("br_product_configurable_attr");
        $this->db->where("parent_id", $id);
        $this->db->where("is_main", 1);
        return $this->db->get()->row_array();
    }

    function insertAssginedAttributes($product_id, $attribute_id, $main) {
        $array['attr_id'] = $attribute_id;
        $array['parent_id'] = $product_id;
        $array['is_main'] = $main;
        $atrr_row = $this->getproductId($product_id);
        if (!empty($atrr_row)) {
            if ($atrr_row['attr_id'] == $attribute_id) {
                $array['is_main'] = $atrr_row['is_main'];
            }
        }
        $row = $this->db
                ->get_where('product_configurable_attr', $array)
                ->row_array()
        ;
        if (!$row) {
            $this->db->insert('product_configurable_attr', $array);
        }
    }

    function importOutput($result) {
        $df = fopen('php://output', 'w');
        ob_start();
        foreach ($result as $result) {
            $array = array_merge($result['product'], $result['response']);
            fputcsv($df, $array);
        }
        fclose($df);
        return ob_get_clean();
    }

    function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

    function addAttributeOption($aid, $value) {
        $data = [
            'attr_id' => $aid,
            'option' => $value
        ];
        $this->db->insert('attribute_option', $data);
        return $this->db->insert_id();
    }

    function attributeValue($pid, $aid, $atype, $value) {
        //print_r($value);

        $type_avilable = [];
        $type_avilable[] = 'dropdown';
        $type_avilable[] = 'radio';
        $table = 'attribute_text';
        if (in_array($atype, $type_avilable)) {
            $table = 'attribute_varchar';
        }
        $this->db->where('pid', $pid);
        $this->db->where('attr_id', $aid);
        $result = $this->db->get($table)->row_array();
        $data = ['pid' => $pid, 'attr_id' => $aid, 'value' => $value];
        if ($result) {
            if ($value) {
                $this->db->where('pid', $pid);
                $this->db->where('attr_id', $aid);
                $this->db->update($table, $data);
            } else {
                //delete case
                $this->db->where('pid', $pid);
                $this->db->where('attr_id', $aid);
                $this->db->delete($table, $data);
            }
        } else {
            $this->db->insert($table, $data);
        }
        return $this->db->insert_id();
    }

    public $importType = 1;

    //import products
    function importStock() {
        $file_name = $this->csvfile();
        $this->importType = $this->input->post('type');
        $return = [];
        if (!$file_name)
            return false;
        else {
            $file = $this->config->item('IMPORT_PRODUCT_PATH') . $file_name;
            $this->load->library('CSVReader');
            $return = $this->csvreader->parse_file($file);
//            e($return);
            // $return = $this->extractData($file);
        }
        // e($return);
        $this->import($return);
    }

    function tmp() {
        $this->load->model('catalog/productmodel');
        $file_name = $this->csvfile();
        $this->importType = $this->input->post('type');
        $return = [];
        if (!$file_name)
            return false;
        else {
            $file = $this->config->item('IMPORT_PRODUCT_PATH') . $file_name;
            $return = $this->extractData($file);
        }
        $data = isset($return['data']) ? $return['data'] : [];
        foreach ($data as $data) {
            if (empty($data['sku']) || empty($data['image'])) {
                continue;
            }
            $dbProduct = $this->productmodel->getProductBySku($data['sku']);
            if (!$dbProduct)
                continue;
            // ee($dbProduct);
            $image_found = false;
            $destination_file_name = '';
            $fileExtensions = ['.jpg', '.jpeg', '.png'];
            foreach ($fileExtensions as $ext) {
                $tmp = explode('.', $data['image']);
                $image_name = $tmp[0];
                $file = $this->config->item('IMPORT_PRODUCTIMAGES_PATH') . $image_name . $ext;
                if (file_exists($file)) {
                    $destination_file_name = $image_name . time() . $ext;
                    $dest = $this->config->item('PRODUCT_PATH') . $destination_file_name;
                    copy($file, $dest);
                    $image_found = true;
                }
            }


            if ($image_found) {
                $this->db->where('pid', $dbProduct['id']);
                $this->db->where('orignal_name', $data['image']);
                $this->db->from('prod_img');
                $row = $this->db->get()->row_array();
                if (!$row) {
                    $this->db->insert('prod_img', ['pid' => $dbProduct['id'], 'img' => $destination_file_name, 'orignal_name' => $data['image'], 'main' => 1]);
                }
            }
        }
    }

    public function importAttributes() {
        $file_name = $this->csvfile();
        $file = $this->config->item('IMPORT_PRODUCT_PATH') . $file_name;
        $this->load->library('CSVReader');
        $return = $this->csvreader->parse_file($file);
        $columns = array_keys(current($return));
        $columns = $this->getAttributeByNames($columns);
        $columns = array_reduce($columns, function($result, $row) {
            $name = trim(strtolower($row['name']));
            $result[$name] = $row;
            return $result;
        }, []);
        // $columns = $this->getAttributeOptions($columns);
        $container = [];
        foreach ($return as $key => $data):
            $found = $current_attribute = false;
            foreach ($data as $attribute_name => $import) {
                $attribute_name = trim(strtolower($attribute_name));
                $current_attribute = isset($columns[$attribute_name]) ? $columns[$attribute_name] : [];
                $import_tmp = trim($import);
                $container[$attribute_name][$key] = [
                    'value' => $import_tmp,
                    'response' => ''
                ];
                if (!isset($container[$attribute_name]['max_length']))
                    $container[$attribute_name]['max_length'] = 1;
                else
                    $container[$attribute_name]['max_length'] ++;
                // e($container);
                if (!$current_attribute) {
                    $container[$attribute_name][$key]['response'] = 'attribute not found.';
                    continue;
                } elseif (empty($import_tmp)) {
                    $container[$attribute_name][$key]['response'] = 'option value is empty.';
                    continue;
                } elseif ($current_attribute['type'] != 'dropdown') {
                    $container[$attribute_name][$key]['response'] = 'attribute type is not dropdown.';
                    continue;
                }
                // e($current_attribute,1);
                // e($import);
                $aid = $current_attribute['id'];
                $count = $this->db
                        ->from('attribute_option')
                        ->where('attr_id', $aid)
                        ->where('option', $import_tmp)
                        ->count_all_results()
                ;
                if ($count > 0) {
                    $container[$attribute_name][$key]['response'] = 'option already exists.';
                    continue;
                }
                $result = $this->db->insert('attribute_option', [
                    'attr_id' => $aid,
                    'option' => $import_tmp
                ]);
                if ($result)
                    $container[$attribute_name][$key]['response'] = 'option inserted.';
                else
                    $container[$attribute_name][$key]['response'] = 'status unknown.';
                // lQ();
                // e($result);
            }
        endforeach;
        // e($container);
        $this->Importmodel->download_send_headers('response.csv');
        $keys = array_keys($container);
        $max_length = max(array_column($container, 'max_length'));
        $df = fopen('php://output', 'w');
        ob_start();
        // headers
        $headers = [];
        foreach ($keys as $key) {
            $headers[] = $key;
            $headers[] = '';
        }
        fputcsv($df, $headers);

        // values
        for ($i = 0; $i < $max_length; $i++) {
            $tmp_values = [];
            foreach ($keys as $key) {
                if (isset($container[$key][$i])) {
                    $tmp_values[] = $container[$key][$i]['value'];
                    $tmp_values[] = $container[$key][$i]['response'];
                }
            }
            fputcsv($df, $tmp_values);
            // e($tmp_values);
        }
        fclose($df);
        echo ob_get_clean();
        exit;
    }

    public function getAttributeOptions($columns) {
        foreach ($columns as $key => $column)
            $columns[$key]['options'] = $this->getAttributeByAttributeId($column['id']);
        return $columns;
    }

    public function getAttributeByAttributeId($attribute_id) {
        $options = $this->db
                        ->where('attr_id', $attribute_id)
                        ->from('attribute_option')
                        ->get()->result_array()
        ;
        return $options;
    }

    public function getAttributeByNames($name = []) {
        return $this->db
                        ->from('attribute')
                        ->where_in('name', $name)
                        ->get()
                        ->result_array()
        ;
    }

    function attribute_names() {
        $attributes = array();

        $rs = array();
        $rs = $this->db->select('id,name')
                ->from('attribute')
                ->get();

        // if ($rs->num_rows()) {
        //     $attributes = array_column($rs->result_array(), 'name');
        // }

        return $rs->result_array();
    }

    function getimage($id) {
        $this->db->select("t2.img");
        $this->db->from("product t1");
        $this->db->join("br_prod_img t2", "t1.id = t2.pid");
        $this->db->where("t1.id", $id);
        return $this->db->get()->result_array();
    }

    function export_products() {
        ini_set("memory_limit", "512M");
        $tmp = $this->attribute_names();
        $attributes = array_reduce($tmp, function($result, $item) {
            $result[$item['name']] = '';
            return $result;
        }, []);
        $attributes_with_ids = array_reduce($tmp, function($result, $item) {
            $result[$item['id']] = $item['name'];
            return $result;
        }, []);
        $products = $this->db
                        ->select('t1.id,t1.name,t1.sku,t1.type,t3.name category,t1.price,t1.quantity,t1.is_active,t1.description,t1.is_taxable,t1.attr_set_id,group_concat(t4.img) images', false)
                        ->from('product t1')
                        ->join('cat_prod t2', 't2.pid = t1.id AND t2.main = 1','left')
                        ->join('category t3', 't3.id = t2.cid','left')
                        ->join('prod_img t4', 't4.pid=t1.id', 'left')
//                        ->like('t1.sku', '25M')
                        ->group_by('t1.id')
//                        ->limit(10)
                        ->get()->result_array()
        ;


        foreach ($products as $key => $product):
//            if ($product['id'] != 1549) {
//                continue;
//            }
            $images = explode(',', $products[$key]['images']);
            unset($products[$key]['images']);
            // e($product);
            // $tmp = $this->db
            // ->from('attr_attrset t4')
            // ->join('attribute t5',"t5.id = t4.attr_id")
            // ->join('attribute_varchar t6',"t6.attr_id = t5.id",'left')
            // ->join('attribute_text t7',"t6.attr_id = t5.id",'left')
            // ->join('attribute_option t8',"t8.attr_id = t5.id AND t8.id = t6.value",'left')
            // // ->join('product_configurable_attr t9',"t9.parent_id = t2.pid",'left')
            // ->where('t4.set_id',$product['attrset_id'])
            // ->where("(t6.pid IS NULL OR t6.pid = $pid)")
            // ->where("(t7.pid IS NULL OR t7.pid = $pid)")
            // ->get()->result_array()
            // ;
            $query = "
        SELECT t5.id,t5.name as attribute_name,t5.type attribute_type,t6.value,t7.text,t8.option
        FROM (`br_attr_attrset` t4)
        JOIN `br_attribute` t5 ON `t5`.`id` = `t4`.`attr_id`
        LEFT JOIN `br_attribute_varchar` t6 ON `t6`.`attr_id` = `t5`.`id`  and t6.pid = {$product['id']}
        LEFT JOIN `br_attribute_text` t7 ON `t6`.`attr_id` = `t5`.`id` and  t7.pid = {$product['id']}
        LEFT JOIN `br_attribute_option` t8 ON `t8`.`attr_id` = `t5`.`id` AND t8.id = t6.value
        WHERE `t4`.`set_id` =  {$product['attr_set_id'] }
        ";
            $tmps = $this->db->query($query)->result_array();
            $tmps = array_reduce($tmps, function($result, $arr) {
                $result[$arr['id']] = $arr;
                return $result;
            }, []);
            foreach ($tmps as $tmp):
//            e($key);
                if ($tmp['attribute_type'] == 'varchar') {
                    $products[$key][$tmp['attribute_name']] = $tmp['value'];
                } elseif ($tmp['attribute_type'] == 'text') {
                    $products[$key][$tmp['attribute_name']] = $product['text'];
                } elseif ($tmp['attribute_type'] == 'dropdown') {
                    $products[$key][$tmp['attribute_name']] = $tmp['option'];
                } elseif ($tmp['attribute_type'] == 'radio') {
                    $products[$key][$tmp['attribute_name']] = $tmp['option'];
                }
            endforeach;
            if ($product['type'] == 'config') {
                $ids = $this->db
                                ->select('attr_id', false)
                                ->from('product_configurable_attr')
                                ->where('parent_id', $product['id'])
                                ->get()->result_array()
                ;
                $ids = array_column($ids, 'attr_id');
                foreach ($tmps as $tmp):
                    if (!in_array($tmp['id'], $ids)) {
                        continue;
                    }
                    $products[$key][$tmp['attribute_name']] = 'assigned';
                endforeach;
            }
            $products[$key] = array_replace($products[$key], $images);
        endforeach;

        //   echo "not real: ".(memory_get_peak_usage(false)/1024/1024)." MiB\n";
        //   echo "real: ".(memory_get_peak_usage(true)/1024/1024)." MiB\n\n";
        //   exit;
        $headers = array_keys(current($products));
        foreach ($attributes as $attribute => $value) {
            $headers[] = $attribute;
        }

        $this->Importmodel->download_send_headers('response.csv');
        $df = fopen('php://output', 'w');
        ob_start();
        fputcsv($df, $headers);

        foreach ($products as $result) {
//            if ($result['id'] != 1549) {
//                continue;
//            }
            $tmp = [];
            foreach ($headers as $header) {
                $tmp[] = isset($result[$header]) ? $result[$header] : '';
            }
            fputcsv($df, $tmp);
        }
        fclose($df);
        echo ob_get_clean();
    }

    function export_products_old() {
        $attributes = $this->attribute_names();

        $total_products = 0;
        $total_products = $this->total_products();

        $offset = 0;
        $limit = 1;

        $iterations = 0;
        $iterations = ceil($total_products / $limit);

        $column_header_flag = TRUE;

        while ($iterations--) {
            $out = array();

            // Get product details except attributes
            $rs = array();
            $rs = $this->db->select('product.id, product.sku, product.name, product.type, product.uri, product.price, product.quantity, product.description, product.meta_title, product.meta_keywords, product.meta_description, brand.name as brand_name')
                    ->join('brand', 'brand.id = product.bid', 'left')
                    ->where('type', 'standard')
                    ->get('product', $limit, $offset);

            $offset += $limit;

            if ($rs->num_rows()) {
                $rs = $rs->result_array();
                foreach ($rs as $item) {
                    $record = array();
                    $record = $item;
                    $product_id = $item['id'];

                    // Create empty attributes record
                    $attributes_record = array();
                    $temp = array();

                    foreach ($attributes as $a) {
                        array_push($temp, ' ');
                    }
                    $attributes_record = array_combine($attributes, $temp);

                    // Get category details
                    $rs2 = array();
                    $rs2 = $this->db->select('category.id as category_id, category.name as category_name, category.attrset_id as attribute_set_id')
                            ->from('category')
                            ->join("cat_prod", "cat_prod.cid = category.id")
                            ->where('cat_prod.pid', $item['id'])
                            ->where('cat_prod.main', 1)
                            ->get();

                    if ($rs2->num_rows()) {
                        $r = array();
                        $r = $rs2->first_row('array');

                        $record['category_id'] = $r['category_id'];
                        $record['category_name'] = $r['category_name'];
                        $record['attribute_set_id'] = $r['attribute_set_id'];
                    }

                    // Get attribute set details
                    $rs2 = array();
                    $rs2 = $this->db->select('name')
                            ->from('attribute_set')
                            ->where('attribute_set.id', $record['attribute_set_id'])
                            ->get();

                    if ($rs2->num_rows()) {
                        $r = array();
                        $r = $rs2->first_row('array');
                        $record['attribute_set_name'] = $r['name'];
                    }

                    // Get attribute details
                    $rs2 = array();
                    $rs2 = $this->db->distinct('attribute.name')->select('attribute.name, attribute_text.text as attribute_value')
                            ->from('attribute')
                            ->join('attr_attrset', 'attr_attrset.attr_id = attribute.id')
                            ->join('attribute_text', 'attribute_text.attr_id = attribute.id')
                            ->where('attr_attrset.set_id', $record['attribute_set_id'])
                            ->where('attribute_text.pid', $product_id)
                            ->get();

                    if ($rs2->num_rows()) {
                        $rs2 = $rs2->result_array();

                        $attribute = array();
                        $record['attributes'] = array();

                        foreach ($rs2 as $item2) {
                            foreach ($attributes as $attr_item) {
                                if ($attr_item == $item2['name']) {
                                    $attributes_record[$attr_item] = $item2['attribute_value'];
                                    break;
                                }
                            }
                        }

                        $record['attributes'] = $attributes_record;
                    }

                    array_push($out, $record);
                }
            }

            if ($out) {
                $response = array();

                // Write column header only once.
                if ($column_header_flag == TRUE) {
                    $column_header_flag = FALSE;

                    $temp = array();
                    $temp[0] = 'product id';
                    $temp[1] = 'product sku';
                    $temp[2] = 'product name';
                    $temp[3] = 'product type';
                    $temp[4] = 'product uri';
                    $temp[5] = 'product price';
                    $temp[6] = 'product quantity';
                    $temp[7] = 'product description';
                    $temp[8] = 'product meta title';
                    $temp[9] = 'product meta keywords';
                    $temp[10] = 'product meta description';
                    $temp[11] = 'product brand id';
                    $temp[12] = 'product srp price';
                    $temp[13] = 'brand name';

                    $temp[14] = 'category id';
                    $temp[15] = 'category name';
                    $temp[16] = 'attribute set id';

                    $temp[17] = 'attribute set name';

                    if ($attributes) {
                        $i = 18;
                        foreach ($attributes as $attr_name) {
                            $temp[$i] = $attr_name;
                            $i++;
                        }
                    }

                    array_push($response, $temp);
                }

                foreach ($out as $item) {
                    $arr = array();

                    array_push($arr, $item['id']);
                    array_push($arr, $item['sku']);
                    array_push($arr, $item['name']);
                    array_push($arr, $item['type']);
                    array_push($arr, $item['uri']);
                    array_push($arr, $item['price']);
                    array_push($arr, $item['quantity']);
                    array_push($arr, $item['description']);
                    array_push($arr, $item['meta_title']);
                    array_push($arr, $item['meta_keywords']);
                    array_push($arr, $item['meta_description']);
                    array_push($arr, $item['bid']);
                    array_push($arr, $item['srp_price']);
                    array_push($arr, $item['brand_name']);
                    array_push($arr, $item['category_id']);
                    array_push($arr, $item['category_name']);
                    array_push($arr, $item['attribute_set_id']);
                    array_push($arr, $item['attribute_set_name']);

                    if ($item['attributes']) {
                        foreach ($item['attributes'] as $attr_k => $attr_v) {
                            array_push($arr, $attr_v);
                        }
                    }

                    array_push($response, $arr);
                }
                // e($response);
                $this->Importmodel->download_send_headers('response.csv');
                $df = fopen('php://output', 'w');
                ob_start();

                foreach ($response as $result) {
                    fputcsv($df, $result);
                }

                fclose($df);
                echo ob_get_clean();
            }
        }
    }

    function total_products() {
        $rs = array();
        $rs = $this->db->select('id')
                ->from('product')
                ->get();

        return $rs->num_rows();
    }

    function delete_products() {
        $this->load->library('CSVReader');
        $file = $_FILES['csv']['tmp_name'];

        if ($file) {
            $sku = array();
            $sku = $this->csvreader->parse_file($file);
            $sku = array_column($sku, 'sku');

            if ($sku) {
                // Get id of all products.
                $product_id_arr = array();
                $product_id_arr = $this->db->select('id')
                        ->from('product')
                        ->where_in('sku', $sku)
                        ->get();

                if ($product_id_arr->num_rows()) {
                    $product_id_arr = $product_id_arr->result_array();
                    $product_id_arr = array_column($product_id_arr, 'id');

                    $this->db->where_in('id', $product_id_arr);
                    $this->db->delete('product');

                    $this->db->where_in('pid', $product_id_arr);
                    $this->db->delete('cat_prod');

                    $this->db->where_in('pid', $product_id_arr);
                    $this->db->delete('attribute_text');

                    $this->db->where_in('pid', $product_id_arr);
                    $this->db->delete('attribute_varchar');

                    // Get image files for products and delete them.
                    $image = array();
                    $image = $this->db->select('img')
                            ->from('prod_img')
                            ->where_in('pid', $product_id_arr)
                            ->get();

                    $this->db->where_in('pid', $product_id_arr);
                    $this->db->delete('prod_img');

                    if ($image->num_rows()) {
                        $image = $image->result_array();

                        foreach ($image as $item) {
                            $file = $this->config->item('PRODUCT_PATH') . $item['img'];
                            unlink($file);
                        }
                    }
                }
            }
        }
    }

    //attribute update work
    function AttibuteUpdateStock() {
        $file_name = $this->csvfile();
        $return = [];
        if (!$file_name)
            return false;
        else {
            $file = $this->config->item('IMPORT_PRODUCT_PATH') . $file_name;
            $this->load->library('CSVReader');
            $return = $this->csvreader->parse_file($file);
        }
        $this->ImportAttibuteUpdate($return);
    }

    function ImportAttibuteUpdate($products) {
        $result = [];
        foreach ($products as $key => $product) {
            $sku = $product['sku'];
            $attribute_name = $product['attribute'];

            //product
            $this->db->select('id,type');
            $this->db->from('product');
            $this->db->where('sku', $sku);
            $query = $this->db->get();
            $products[$key]['message'] = "";
            if (!$query->row_array()) {
                $products[$key]['message'] .= " Product not found, ";
                continue;
            }
            $product = $query->row_array();
            // e($product);
            if ($product['type'] != 'config') {
                $products[$key]['message'] .= " Product is not configurable, ";
                continue;
            }

            $pid = $product['id'];

            //attribute
            $this->db->select('id');
            $this->db->from('attribute');
            $this->db->where('name', $attribute_name);
            $attri_que = $this->db->get();
            if (!$attri_que->row_array()) {
                $products[$key]['message'] .= " Attribute not found, ";
                continue;
            }
            $attribute = $attri_que->row_array();
            $aid = $attribute['id'];

            //select products from product_configurable_attr
            $this->db->select('*');
            $this->db->from('product_configurable_attr');
            $this->db->where('parent_id', $pid);
            $all_attributes = $this->db->get();
            if ($all_attributes->num_rows() == 0) {
                $products[$key]['message'] .= " No attribute assigned against product, ";
                continue;
            } else {
                $adata = array();
                $adata['is_main'] = 0;
                $this->db->where('parent_id', $pid);
                $result = $this->db->update('product_configurable_attr', $adata);
                if ($result)
                    $products[$key]['message'] .= " Product attributes is main reseted to 0, ";
            }

            //select products from product_configurable_attr
            $this->db->select('*');
            $this->db->from('product_configurable_attr');
            $this->db->where('parent_id', $pid);
            $this->db->where('attr_id', $aid);
            $sheet_set = $this->db->get();
            if ($sheet_set->num_rows() == 0) {
                $products[$key]['message'] .= " Main attribute is not assigned against product, ";
                continue;
            }
            $get_row_set = $sheet_set->row_array();
//            update row set work
            $Sdata = array();
            $Sdata['is_main'] = 1;
            $this->db->where('id', $get_row_set['id']);
            $status = $this->db->update('product_configurable_attr', $Sdata);
            if ($status) {
                $products[$key]['message'] .= " Is main successfully updated. ";
            }
        }
        // e($products);
        $this->Importmodel->download_send_headers('response.csv');
        $df = fopen('php://output', 'w');
        ob_start();
        foreach ($products as $result) {
            fputcsv($df, $result);
        }
        fclose($df);
        echo ob_get_clean();
        exit;
    }

    function export_product_cats() {
        ini_set("memory_limit", "512M");
        $products = $this->db
                        ->select('t1.sku,group_concat(t3.name) as categories', false)
                        ->from('product t1')
                        ->join('cat_prod t2', 't2.pid = t1.id')
                        ->join('category t3', 't3.id = t2.cid')
                        ->group_by('t1.sku')
                        ->get()->result_array()
        ;
//        e($products);
        foreach ($products as $product) {
            $categories = $productAr = array();
            $categories = explode(',', $product['categories']);
            $productAr['sku'] = $product['sku'];
            $x = 0;
            foreach ($categories as $key => $category) {
                $x++;
                $productAr['category ' . $x] = $category;
            }
            $productArr[] = $productAr;
        }
//        e($productArr);
        $headers = array_keys(max($productArr));
//        e($headers);
        $this->Importmodel->download_send_headers('product_with_categories.csv');
        $df = fopen('php://output', 'w');
        ob_start();
        fputcsv($df, $headers);
        foreach ($productArr as $result) {
            $tmp = [];
            foreach ($headers as $header) {
                $tmp[] = isset($result[$header]) ? $result[$header] : '';
            }
            fputcsv($df, $tmp);
        }
        fclose($df);
        echo ob_get_clean();
    }

    //Function _Slug
    public function _slug($pname) {
        $product_name = ($pname) ? $pname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

        $slug = $product_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('uri', $slug);
        $rs = $this->db->get('product');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('uri', $alt_slug);
                $rs = $this->db->get('product');
                if ($rs->num_rows() > 0) {
                    $slug_check = true;
                }

                $suffix++;
            } while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }
}
?>
