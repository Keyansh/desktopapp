<?php

class Productmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function custom_options($config, $pid) {
        $result = $this->db
                ->where('pid', $pid)
                ->where('config', $config)
                ->get('custom_table')
                ->result_array()
        ;
        return $result;
    }

    //product category
    function ProductCategory($pid) {
        return $this->db
                        ->where('pid', $pid)
                        ->where('main', 1)
                        ->get('cat_prod')->row_array();
    }

    function ProductSecondCategory($pid) {
        return $this->db
                        ->where('pid', $pid)
                        ->where('main', 0)
                        ->get('cat_prod')->result_array();
    }

    function categorydeatail($cid) {
        return $this->db
                        ->where('id', $cid)
                        ->get('category')->row_array();
    }

    //Function Get Details Of Product
    function details($pid) {
        $this->db->select('t1.*, t3.id as category_id, t3.name as category_name');
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid');
        $this->db->join('category t3', 't3.id = t2.cid');
        $this->db->where('t1.id', intval($pid));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

//    //List All Product
//    function listAll($offset = FALSE, $limit = FALSE) {
//        $this->db->select('t1.*, t3.id as category_id, t3.name category_name');
//        $this->db->from('product t1');
//        $this->db->join('cat_prod t2', 't1.id = t2.pid');
//        $this->db->join('category t3', 't3.id = t2.cid');
//        if ($offset)
//            $this->db->offset($offset);
//        if ($limit)
//            $this->db->limit($limit);
//        $query = $this->db->get();
//        //die($this->db->last_query());
//        return $query->result_array();
//    }
    //List All Product
    function listAll($offset = FALSE, $limit = FALSE) {
//        $this->db->select('t1.id, t1.sku, t1.name, t1.type, t1.price, t1.is_active, t3.id as category_id, t3.name category_name');
        $this->db->select('t1.id, t1.sku, t1.name, t1.type, t1.price, t1.is_active');
        $this->db->from('product t1');
        $this->db->order_by("t1.id", 'desc');
//        $this->db->join('cat_prod t2', 't1.id = t2.pid');
//        $this->db->join('category t3', 't3.id = t2.cid');
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result_array();
    }

    function catsproducts($cid) {
        $this->db->select('t1.id, t1.sku, t1.name, t1.type, t1.price, t1.is_active');
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid');
        $this->db->join('category t3', 't3.id = t2.cid');
        $this->db->where('t3.id', $cid);
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result_array();
    }

    function GetParentSku($id = FALSE) {

        $this->db->select("t1.parent_id");
        $this->db->from("br_product_configurable_link t1");
        $this->db->join("product t2", "t2.id = t1.child_id");
        $this->db->where_in("t1.child_id", $id);
        $row = $this->db->get()->row_array();
        if (!empty($row)) {
            $this->db->from("product");
            $this->db->where("id", $row['parent_id']);
            $result = $this->db->get()->row_array();
            return $result;
        }
        return false;
    }

    //Filter Products
    function filterProducts() {
        $this->db->select('t1.*, t3.id as category_id, t3.name category_name');
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid');
        $this->db->join('category t3', 't3.id = t2.cid');
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result_array();
    }

    //List All Product
    function getCategoryProducts($catId, &$output = array()) {
        $output = array();
        $this->db->select('t1.id as pid, t1.sku, t1.name as pname,t1.price as pprice,  t3.name as cname, t3.id as cid');
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid ');
        $this->db->join('category t3', 't3.id = t2.cid');
        $this->db->where('t3.id', $catId);
        $this->db->where('t1.type', 'standard');
        $this->db->where('t1.is_active', 1);
        $this->db->limit(20);
        $qu = "t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        $query = $this->db->get();
        return $query->result_array();
    }

    //Product list with image
    function listWithAll() {
        $this->db->select('distinct(t2.pid), t1.id, t1.name, t2.img');
        $this->db->from('product t1');
        $this->db->join('prod_img t2', 't2.pid = t1.id', 'inner');
        $this->db->group_by('t1.id');
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result_array();
    }

    function productImages($pid) {
        return $this->db
                        ->where('pid', $pid)
                        ->get('prod_img')
                        ->result_array();
    }

    function getAttrSet($asid) {
        $r = $this->db
                ->select('t1.*')
                ->from('attribute t1')
                ->join('attr_attrset t2', 't1.id=t2.attr_id', 'left')
                ->where('t2.set_id', $asid)
                ->get();
        return $r->result_array();
    }

    function addAttrSetText($testarea, $attr) {
        $name = 'attribute' . $attr['id'];
        $testarea['value'] = $this->input->post($name, true);
        $r = $this->db
                        ->where('pid', $testarea['pid'])
                        ->where('attr_id', $testarea['attr_id'])
                        ->get('attribute_text')->result_array();
        if (count($r) > 0) {
            $this->db
                    ->where('pid', $testarea['pid'])
                    ->where('attr_id', $testarea['attr_id'])
                    ->update('attribute_text', $testarea);
        } else {
            $this->db->insert('attribute_text', $testarea);
        }
    }

    function addAttrSetValue($varchar, $attr) {
        $name = 'attribute' . $attr['id'];
        $varchar['value'] = $this->input->post($name, true);
        $r = $this->db->where('pid', $varchar['pid'])
                      ->where('attr_id', $varchar['attr_id'])
                      ->get('attribute_varchar')->result_array();
        if (count($r) > 0) {
            $this->db->where('pid', $varchar['pid'])
                    ->where('attr_id', $varchar['attr_id'])
                    ->update('attribute_varchar', $varchar);
        } else {
            $this->db->insert('attribute_varchar', $varchar);
        }
    }

    function productImageAddEdit($image, $pid) {
        foreach ($image['main'] as $main) {
            if ($main) {
                self::productRemoveIsMainImage($pid);
            }
        }
        $count = count($image['photo']);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $pimg = str_replace(' ', '_', $image['photo'][$i]);
                $temp = $this->config->item('PRODUCT_PATH') . 'temp/' . $pimg;
                copy($temp, $this->config->item('PRODUCT_PATH') . $pimg);
                $img['pid'] = $pid;
                $img['img'] = $pimg;
                $img['imgalt'] = '';
                $img['main'] = $image['main'][$i];
                $this->db->insert('prod_img', $img);
                unlink($temp);
            }
        }
    }

    function changeMainImage($image_id) {
        $this->db->where('id', $image_id);
        $this->db->update('prod_img', ['main' => 1]);
    }

    function productRemoveIsMainImage($pid) {
        $this->db->where('pid', $pid);
        $this->db->update('prod_img', ['main' => 0]);
    }

    

    //add edit
    function addProParentCat($cid, $pid) {
        $cat_pro = array();
        $cat_pro['cid'] = $cid;
        $cat_pro['pid'] = $pid;
        $cat_pro['main'] = 1;

        $r = $this->db
                        ->where('pid', $pid)
                        ->where('main', 1)
                        ->get('cat_prod')->row_array();

        if ($r['cid'] != $cid) {
            $this->db
                    ->where('pid', $pid)
                    ->where('main', 1)
                    ->update('cat_prod', $cat_pro);
        }
        if (count($r) == 0) {
            $this->db->insert('cat_prod', $cat_pro);
        }
    }

    //Count All category
    function countAll() {
        $this->db->from('product');
        return $this->db->count_all_results();
    }

    //Count All category
    function countFilter($where) {
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid');
        $this->db->join('category t3', 't3.id = t2.cid');
        if ($where)
            $this->db->where($where);

        return $this->db->count_all_results();
        //die($this->db->last_query());
    }

    function getAttributesSets() {
        $this->db->from('attribute_set');
        $attr_res = $this->db->get();
        return $attr_res->result_array();
    }

    //Function Add Record
    function insertRecord() {
        $this->load->model('Categorymodel');
        $data = array();
        $quantity = $this->input->post('quantity', true);
        $price = $this->input->post('price', true);
        $alert_qty = $this->input->post('alert_qty', true);
        $srp_price = $this->input->post('srp_price', true);
        $data['quantity'] = ($quantity) ? $quantity : 0;
        $data['price'] = ($price) ? $price : 0.00;
        $data['alert_qty'] = ($alert_qty) ? $alert_qty : 0;
        $data['sku'] = $this->input->post('sku', true);
        $data['type'] = $this->input->post('type', true);

        $data['attr_set_id'] = $this->input->post('attrsetid', true); //direct add attribute set id for break the link of category

        $data['name'] = $this->input->post('name', true);
        $data['description'] = $this->input->post('description', false);
        $data['brief_description'] = $this->input->post('brief_description', false);
        $data['dimensions'] = $this->input->post('dimensions', false);
        $data['tags'] = $this->input->post('tags', false);
        $data['product_specifications'] = $this->input->post('product_specifications', false);
        $data['payment_delivery_options'] = $this->input->post('payment_delivery_options', false);
        $data['is_featured'] = $this->input->post('is_featured', true);
        $data['is_new'] = $this->input->post('is_new', true);
        $data['meta_title'] = $this->input->post('meta_title', true);
        $data['meta_keywords'] = $this->input->post('meta_keywords', true);
        $data['meta_description'] = $this->input->post('meta_description', true);
        $data['is_active'] = 1;
        $data['is_bespoke'] = $this->input->post('is_bespoke', true);
        $data['is_taxable'] = $this->input->post('is_taxable', true);
        $data['bid'] = $this->input->post('brand_id', true);
        $data['inc_or_exl_tax'] = $this->input->post('inc_or_exl_tax', true);
        $data['set_up_cost'] = $this->input->post('set_up_cost', true);
        $data['set_up_cost'] = $data['set_up_cost'] ? $data['set_up_cost'] : 0;
        $data['min_order_quantity'] = $this->input->post('min_order_quantity', true);
        $data['min_order_quantity'] = $data['min_order_quantity'] ? $data['min_order_quantity'] : 0;
        $data['bundle_qty'] = $this->input->post('bundle_qty', true);
        $data['bundle_qty'] = $data['bundle_qty'] ? $data['bundle_qty'] : 0;
        $data['srp_price'] = ($srp_price) ? $srp_price : 0.00;


        $data['new_start_date'] = $this->input->post('new_start_date');
        $data['new_end_date'] = $this->input->post('new_end_date');

        if ($this->input->post('uri', TRUE) == '') {
            $data['uri'] = $this->_slug($this->input->post('name', TRUE));
        } else {
            $data['uri'] = $this->_slug($this->input->post('uri', TRUE));
        }

        $this->db->insert('product', $data);
        $product_id = $this->db->insert_id();

        if ($product_id) {
            // Add accessories
            $accessories = array();
            $accessories = json_decode($this->input->post('accessories'), true);

            if ($accessories) {
                foreach ($accessories as $k => $v) {
                    $data = array();
                    $data['config_product_id'] = $product_id;
                    $data['product_id'] = $v['product_id'];
                    $data['quantity'] = $v['quantity'];
                    $data['price'] = $v['price'];
                    $data['added_on'] = time();
                    $this->db->insert('accessories', $data);
                }
            }
        }

        // Move files from temp to pdf and save in db
        $path = $this->config->item('PDF_TEMP_PATH');
        $path2 = $this->config->item('PDF_PATH') . $product_id;
        if (!file_exists($path2)) {
            mkdir($path2);
        }
        $pdf_data = array();

        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ('.' === $file)
                    continue;
                if ('..' === $file)
                    continue;

                array_push($pdf_data, $file);
            }
            closedir($handle);

            if ($pdf_data) {
                foreach ($pdf_data as $k => $v) {
                    $pdf_record = array();
                    $pdf_record['product_id'] = $product_id;
                    $pdf_record['pdf'] = $v;
                    $pdf_record['added_on'] = time();

                    $this->db->insert('product_pdf', $pdf_record);
                }
            }

            $files = scandir($path);
            $source = $path;
            $destination = $path2 . '/';

            foreach ($files as $file) {
                if (in_array($file, array(".", "..")))
                    continue;
                if (copy($source . $file, $destination . $file)) {
                    $delete[] = $source . $file;
                }
            }

            foreach ($delete as $file) {
                unlink($file);
            }
        }

        // update custom options
        self::saveCustomOption($product_id);

        if ($this->input->post('type', true) == 'standard') {

//            $attrset = $this->Categorymodel->catattrsetid($this->input->post('category_id', true));
            //$attrset['attrset_id']
            $attr_set_id = $this->input->post('attrsetid');
            $attributes = self::getAttrSet($attr_set_id);

            foreach ($attributes as $key => $attr) {
                if ($attr['type'] == 'text') {
                    $textarea = array();
                    $testarea['pid'] = $product_id;
                    $testarea['attr_id'] = $attr['id'];
                    $testarea['text'] = $this->input->post($attr['name'], TRUE);
                    self::addAttrSetText($testarea, $attr);
                } else {
                    $varchar = array();
                    $varchar['pid'] = $product_id;
                    $varchar['attr_id'] = $attr['id'];
                    $varchar['value'] = $this->input->post($attr['name'], TRUE);
                    self::addAttrSetValue($varchar, $attr);
                }
            }
        }


        //product parent category
        self::addProParentCat($this->input->post('category_id'), $product_id);
        $categoriesIds = $this->input->post('categoriesIds');
        if ($categoriesIds) {
            foreach ($categoriesIds as $categoriesId) {
                $atdata['pid'] = $product_id;
                $atdata['cid'] = $categoriesId;
                $atdata['main'] = 0;
                $this->db->insert('cat_prod', $atdata);
            }
        }
        //upload image
        if ($this->input->post('photo')) {
            $image = array();
            $image['main'] = $this->input->post('main');
            $image['photo'] = $this->input->post('photo');
            self::productImageAddEdit($image, $product_id);
        }

        //configurable product IDs insert
        $assign_product = $this->input->post('assign_product', true);
        $chilProducts = array();
        if (!empty($assign_product)) {
            $chilProducts = explode(",", $assign_product);
        }
        if ($TYPE == 'config') {
            if (count($chilProducts) > 0) {
                $chilProducts = array_unique($chilProducts);
                foreach ($chilProducts as $chilProduct) {
                    $cdata['parent_id'] = $product_id;
                    $cdata['child_id'] = $chilProduct;
                    $this->db->insert('product_configurable_link', $cdata);
                }
            }
        }

        $attrID = array();
        //configurable product Attrbute insertion
        $attrID = $this->input->post('attributesList', true);
        if ($attrID) {
            $atttdata = array();
            foreach ($attrID as $atID) {
                $atttdata['parent_id'] = $product_id;
                $atttdata['attr_id'] = $atID;
                $this->db->insert('product_configurable_attr', $atttdata);
            }
        }


        $tierData = array();
        $tierData['tier_product_id'] = isset($product_id) ? $product_id : 0;
        $insertData = array();
        $profIDList = $this->input->post('tier_profgroup', true);
        foreach ($profIDList as $ky => $id) {
            $tierData['tier_profile_id'] = $id;
            $tierData['tier_qty'] = $this->input->post('tier_qty', true);
            $tierData['tier_price'] = $this->input->post('tier_price', true);
            if ($id > -1) {
                $insertData['tier_product_id'] = isset($tierData['tier_product_id']) ? $tierData['tier_product_id'] : 0;
                $insertData['tier_profile_id'] = isset($tierData['tier_profile_id']) ? $tierData['tier_profile_id'] : 0;
                $insertData['tier_qty'] = isset($tierData['tier_qty'][$ky]) ? $tierData['tier_qty'][$ky] : 0;
                $insertData['tier_price'] = isset($tierData['tier_price'][$ky]) ? $tierData['tier_price'][$ky] : 0;
                if ($insertData['tier_qty'] && $insertData['tier_price']) {
                    $this->db->insert('tier_price', $insertData);
                }
            }
        }
        $brochureList = $this->input->post('brochures', true);
        if ($brochureList) {
            $bdata = array();
            foreach ($brochureList as $bid) {
                $bdata['pid'] = $product_id;
                $bdata['bid'] = $bid;
                $this->db->insert('product_brochures_link', $bdata);
            }
        }
        return $product_id;
    }

    //get sort order
    function getOrder() {
        $this->db->select_max('sort_order');
        $query = $this->db->get('product');
        $sort_order = $query->row_array();
        return $sort_order['sort_order'] + 1;
    }

    function deleteCustomOptions($config, $ids, $pid) {
        $this->db->where_not_in('id', $ids);
        $this->db->where('config', $config);
        $this->db->where('pid', $pid);
        $this->db->delete('custom_table');
    }

    function saveCustomOption($pid) {
//        e($pid);
        $custom_option = $this->input->post('custom_option');
        $update_id = $this->input->post('logo_print_location');
        self::deleteCustomOptions('logo_print_location', $update_id, $pid);
        foreach ($custom_option as $config => $value) {
            foreach ($value as $key => $val) {
                $id = isset($update_id[$key]) ? $update_id[$key] : null;
                $data = [
                    'config' => $config,
                    'value' => $val,
                    'active' => 1,
                    'pid' => $pid,
                ];
                if ($id) {
                    $this->db->where('id', $id);
                    $this->db->update('custom_table', $data);
                } else {
                    $this->db->insert('custom_table', $data);
                }
            }
        }
    }

    function changeStandardPrices($pid, $percnt) {
        $this->db->select('t1.parent_id,t1.child_id,t2.id,t2.name,t2.sku,t2.price,t2.is_active');
        $this->db->from('product_configurable_link t1');
        $this->db->join('product t2', 't2.id = t1.child_id', 'left');
        $this->db->where('t1.parent_id', $pid);
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            $prods = $res->result_array();
            $csvarray = [];
            foreach ($prods as $key => $item) {
                //oldprice + (percentage/100 × oldprice)
                $oldprice = $item['price'];
                $amount = ($percnt / 100 * $oldprice);
                $amount = number_format($amount, 2);

                $new_price = $oldprice + $amount;

                $data = array();
                $data['price'] = $new_price;
                $this->db->where('id', $item['id']);
                $status = $this->db->update('product', $data);
            }
            $configdata = array();
            $configdata['config_id'] = $pid;
            $configdata['percentage'] = $percnt;
            if ($percnt > 0) {
                $configdata['type'] = "Positive";
            } elseif ($percnt < 0) {
                $configdata['type'] = "Negative";
            }
            $configdata['added_on'] = date('Y-m-d H:i:s');
            $this->db->insert('config_price_changes', $configdata);
        }
    }

    function config_least_price($pid) {
        $this->db->select('min(t1.price) as least_price');
        $this->db->from('product t1');
        $this->db->join('product_configurable_link t2', 't1.id = t2.child_id', 'left');
        $this->db->where('t2.parent_id', $pid);
        $res = $this->db->get();
        $result = $res->row_array();
        if ($result) {
            return $result['least_price'];
        }
    }

    //Function Update Product
    function updateRecord($product) {
        $this->load->model('Categorymodel');
        $this->load->model('Attributesmodel');
        $product_id = $product['id'];
        $data = array();
        $quantity = $this->input->post('quantity', true);
        $price = $this->input->post('price', true);
        $alert_qty = $this->input->post('alert_qty', true);
        $srp_price = $this->input->post('srp_price', true);
        $data['quantity'] = ($quantity) ? $quantity : 0;
        $data['price'] = ($price) ? $price : 0.00;

        if ($this->input->post('is_change_price_for_child') == 1) {
            $new_least_price = $this->input->post('least_price', true);
            if ($new_least_price > 0) {
                $old_least_price = $this->config_least_price($product_id);
                if ($new_least_price != $old_least_price) {
                    $percentChange = ($new_least_price - $old_least_price) / $old_least_price * 100;
                    $percentChange = number_format($percentChange, 2);
                    if ($percentChange) {
                        $this->changeStandardPrices($product['id'], $percentChange);
                    }
                }
            }
        }

        $data['alert_qty'] = ($alert_qty) ? $alert_qty : 0;
        $data['sku'] = $this->input->post('sku', true);
        $data['type'] = $this->input->post('type', true);
        $data['name'] = $this->input->post('name', true);
        $data['description'] = $this->input->post('description', false);
        $data['brief_description'] = $this->input->post('brief_description', false);
        $data['dimensions'] = $this->input->post('dimensions', false);
        $data['tags'] = $this->input->post('tags', false);
        $data['product_specifications'] = $this->input->post('product_specifications', false);
        $data['payment_delivery_options'] = $this->input->post('payment_delivery_options', false);
        $data['is_featured'] = $this->input->post('is_featured', true);
        $data['is_new'] = $this->input->post('is_new', true);
        $data['meta_title'] = $this->input->post('meta_title', true);
        $data['meta_keywords'] = $this->input->post('meta_keywords', true);
        $data['meta_description'] = $this->input->post('meta_description', true);
//        $data['is_active'] = 1;
        $data['is_bespoke'] = $this->input->post('is_bespoke', true);
        $data['is_taxable'] = $this->input->post('is_taxable', true);
        $data['bid'] = $this->input->post('brand_id', true);
        $data['inc_or_exl_tax'] = $this->input->post('inc_or_exl_tax', true);
        $data['set_up_cost'] = $this->input->post('set_up_cost', true);
        $data['set_up_cost'] = $data['set_up_cost'] ? $data['set_up_cost'] : 0;
        $data['bundle_qty'] = $this->input->post('bundle_qty', true);
        $data['bundle_qty'] = $data['bundle_qty'] ? $data['bundle_qty'] : 0;
        $data['min_order_quantity'] = $this->input->post('min_order_quantity', true);
        $data['min_order_quantity'] = $data['min_order_quantity'] ? $data['min_order_quantity'] : 0;
        $data['srp_price'] = ($srp_price) ? $srp_price : 0.00;

        if ($data['is_new'] == 1) {
            $data['new_start_date'] = $this->input->post('new_start_date');
            $data['new_end_date'] = $this->input->post('new_end_date');
        } else {
            $data['new_start_date'] = '';
            $data['new_end_date'] = '';
        }

        $TYPE = $this->input->post('type', true);
        if ($this->input->post('uri', TRUE) == '') {
            $data['uri'] = url_title($data['name']);
        } else {
            $data['uri'] = url_title($this->input->post('uri', TRUE));
        }
        //$data['sort_order'] = $this->getSortOrder();

        $this->db->where('id', $product_id);
        $this->db->update('product', $data);

        // Move files from temp to pdf and save in db
        $path = $this->config->item('PDF_TEMP_PATH');
        $path2 = $this->config->item('PDF_PATH') . $product_id;
        if (!file_exists($path2)) {
            mkdir($path2);
        }
        $pdf_data = array();
        if ($handle = opendir($path)) {

            while (false !== ($file = readdir($handle))) {
                if ('.' === $file)
                    continue;
                if ('..' === $file)
                    continue;

                array_push($pdf_data, $file);
            }
            closedir($handle);
//                           e("shdgfd");

            if ($pdf_data) {
                foreach ($pdf_data as $k => $v) {
                    $pdf_record = array();
                    $pdf_record['product_id'] = $product_id;
                    $pdf_record['pdf'] = $v;
                    $pdf_record['added_on'] = time();

                    $this->db->insert('product_pdf', $pdf_record);
                }
            }
            $files = scandir($path);
            $source = $path;
            $destination = $path2 . '/';

            foreach ($files as $file) {
                if (in_array($file, array(".", "..")))
                    continue;
                if (copy($source . $file, $destination . $file)) {
                    $delete[] = $source . $file;
                }
            }

            foreach ($delete as $file) {
                unlink($file);
            }
        }
        // End of Code
        if ($TYPE == 'standard') {
            //$attrset = $this->Categorymodel->catattrsetid($this->input->post('category_id', true));
            $attr_set_id = $this->input->post('attrsetid');
            $attributes = self::getAttrSet($attr_set_id);

            foreach ($attributes as $key => $attr) {
                if ($attr['type'] == 'text') {
                    $textarea = array();
                    $testarea['pid'] = $product_id;
                    $testarea['attr_id'] = $attr['id'];
                    $testarea['text'] = $this->input->post($attr['name'], TRUE);
                    self::addAttrSetText($testarea, $attr);
                } else {
                    $varchar = array();
                    $varchar['pid'] = $product_id;
                    $varchar['attr_id'] = $attr['id'];
                    $varchar['value'] = $this->input->post($attr['name'], TRUE);
                    self::addAttrSetValue($varchar, $attr);
                }
            }
        }

        //Delete product attribute while we change standard product to configurable product
        // ee($TYPE);
        if ($TYPE == 'config' || $TYPE == 'bundle' || $TYPE == 'combo') {
            $this->Attributesmodel->deleteByID($product_id);
        }

        //product parent category
        self::addProParentCat($this->input->post('category_id'), $product_id);

        $categoriesIds = $this->input->post('categoriesIds', true);
        if ($categoriesIds) {
            $this->db->where('pid', $product['id']);
            $this->db->where('main', 0);
            $this->db->delete('cat_prod');
//            e($product_id);
            foreach ($categoriesIds as $categoriesId) {
                $atdata['pid'] = $product_id;
                $atdata['cid'] = $categoriesId;
                $atdata['main'] = 0;
                $this->db->insert('cat_prod', $atdata);
            }
        }
//e(444);
        // update custom options
        self::saveCustomOption($product_id);

        //change main image
        if ($img_id = $this->input->post('mainimg')) {
            self::productRemoveIsMainImage($product_id);
            self::changeMainImage($img_id);
        }
        //upload image
        if ($this->input->post('photo')) {
            $image = array();
            $image['main'] = $this->input->post('main');
            $image['photo'] = $this->input->post('photo');
            self::productImageAddEdit($image, $product_id);
        }

        if ($TYPE == 'config' || $TYPE == 'bundle' || $TYPE == 'combo') {

            //configurable product Attrbute insertion
            $attrID = array();
            $attrID = $this->input->post('attributesList', true);
            $attributesListName = $this->input->post('attributesListName', true);

            if ($attrID) {
//                e( $product['id']);
                $this->db->where('parent_id', $product['id']);
                $this->db->delete('product_configurable_attr');
                $is_main_attribute = $this->input->post('is_main_attribute');
                foreach ($attrID as $atID) {
                    $atttdata = array();
                    $atttdata['parent_id'] = $product['id'];
                    $atttdata['attr_id'] = $atID;
                    $atttdata['custom_name'] = @$attributesListName[$atID];
                    if ($is_main_attribute == $atID)
                        $atttdata['is_main'] = 1;
                    $this->db->insert('product_configurable_attr', $atttdata);
                }
            }

            //configurable product IDs insert
            // e($_POST);
            $assign_product = $this->input->post('assign_product', true);
            $chilProducts = array();
            if (!empty($assign_product)) {
                $chilProducts = explode(",", $assign_product);
            }
            if ($TYPE == 'config') {
                //if (count($chilProducts)>0) {

                $chilProducts = array_unique($chilProducts);
                $this->db->where('parent_id', $product['id']);
                $this->db->delete('product_configurable_link');
                foreach ($chilProducts as $chilProduct) {
                    $cdata['parent_id'] = $product_id;
                    $cdata['child_id'] = $chilProduct;
                    $this->db->insert('product_configurable_link', $cdata);
                }
                //}
            }
        }


        $tierData = array();
        $tierData['tier_product_id'] = isset($product_id) ? $product_id : 0;
        $updateData = array();
        $insertData = array();

        $profIDList = $this->input->post('tier_profgroup');
        $this->db->where('tier_product_id', $product_id);
        if ($profIDList) {
            $this->db->where_not_in('tier_profile_id', $profIDList);
        }
        $this->db->delete('tier_price');

        foreach ($profIDList as $k => $id) {

            $tierData['tier_profile_id'] = $this->input->post('tier_profgroup', true);
            $tierData['tier_qty'] = $this->input->post('tier_qty', true);
            $tierData['tier_price'] = $this->input->post('tier_price', false);
            $tierData['tier_id'] = $this->input->post('tier_id', true);
                if ($tierData['tier_id'][$k]) {
                    $updateData['tier_profile_id'] = isset($tierData['tier_profile_id'][$k]) ? $tierData['tier_profile_id'][$k] : 0;
                    $updateData['tier_qty'] = isset($tierData['tier_qty'][$k]) ? $tierData['tier_qty'][$k] : 0;
                    $updateData['tier_price'] = isset($tierData['tier_price'][$k]) ? $tierData['tier_price'][$k] : 0;
                    $this->db->where('tier_id', $tierData['tier_id'][$k]);
                    $this->db->where('tier_product_id', $product_id);
                    $this->db->update('tier_price', $updateData);
                } else {
                    $insertData['tier_product_id'] = isset($tierData['tier_product_id']) ? $tierData['tier_product_id'] : 0;
                    $insertData['tier_profile_id'] = isset($tierData['tier_profile_id'][$k]) ? $tierData['tier_profile_id'][$k] : 0;
                    $insertData['tier_qty'] = isset($tierData['tier_qty'][$k]) ? $tierData['tier_qty'][$k] : 0;
                    $insertData['tier_price'] = isset($tierData['tier_price'][$k]) ? $tierData['tier_price'][$k] : 0;
                    if ($insertData['tier_qty'] > 0 && $insertData['tier_price'] > 0) {
                        $this->db->insert('tier_price', $insertData);
                    }
                }
        }

        $brochureList = $this->input->post('brochures', true);
        if ($brochureList) {
            $this->db->where('pid', $product['id']);
            $this->db->delete('product_brochures_link');
            $bdata = array();
            foreach ($brochureList as $bid) {
                $bdata['pid'] = $product_id;
                $bdata['bid'] = $bid;
                $this->db->insert('product_brochures_link', $bdata);
            }
        }
    }

//    childs products price changes on the base of changed config products
    function standered_price_changes($param) {
        e($param);
    }

    //enable record
    function enableRecord($product) {
        $data = array();
        $data['is_active'] = 1;
        $this->db->where('id', $product['id']);
        $this->db->update('product', $data);
        return 1;
    }

    //disable record
    function disableRecord($product) {
        $data = array();

        $data['is_active'] = 0;
        $this->db->where('id', $product['id']);
        $this->db->update('product', $data);
        return 0;
    }

    //Delete Product
    function deleteRecord($product) {
        //get image detail
        $result = $this->db->where('pid', $product['id'])->get('prod_img')->result_array();

        if (count($result) > 0) {
            foreach ($result as $value) {
                $path = $this->config->item('PRODUCT_PATH');
                $filename = $path . $value['img'];
                if (file_exists($filename)) {
                    @unlink($filename);
                }
            }
        }

        //delete product
        $this->db->where('id', $product['id']);
        $this->db->delete('product');

        //delete product image
        $this->db->where('pid', $product['id']);
        $this->db->delete('prod_img');

        //delete product category relation
        $this->db->where('pid', $product['id']);
        $this->db->delete('cat_prod');

        //delete product assignment relation
        $this->db->where('product_id', $product['id']);
        $this->db->delete('product_assignment');

        //delete product tier pricing relation
        $this->db->where('tier_product_id', $product['id']);
        $this->db->delete('tier_price');

        if ($product['type'] == 'standard') {
            //delete product standard attribute
            $this->db->where('pid', $product['id']);
            $this->db->delete('attribute_varchar');
        }

        if ($product['type'] == 'config' || $product['type'] == 'comobo') {
            //delete product configurable link
            $this->db->where('parent_id', $product['id']);
            $this->db->delete('product_configurable_link');

            //delete product configurable attribute
            $this->db->where('parent_id', $product['id']);
            $this->db->delete('product_configurable_attr');
        }

        return;
    }

    //Function _Slug
    function _slug($pname) {
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
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }

    //function to get sort order
    function getSortOrder() {

        $this->db->select_max('sort_order');
        //$this->db->where('category_id', intval($cid));
        $query = $this->db->get('product');
        $sort_order = $query->row_array();
        return $sort_order['sort_order'] + 1;
    }

    function ProductChild($pid, $attributes) {
        $this->db->select('child_id');
        $this->db->from('product_configurable_link pcl');
        $this->db->join('product pr', 'pr.id = pcl.child_id');
        $this->db->join('attribute_varchar t4', 'pr.id=t4.pid');
        $this->db->join('attribute t5', 't4.attr_id=t5.id');
        $this->db->where('pr.is_active', 1);
        $this->db->where('pcl.parent_id', $pid);
        if ($attributes) {
            $this->db->where_in('t4.attr_id', $attributes);
            $this->db->having('COUNT(*) >=' . count($attributes), false);
        }
        $this->db->where("LOWER(t4.value) != 'select'");
        $this->db->where('t4.value !=', '0');
        $this->db->where('t4.value !=', '');
        $this->db->group_by("pr.id");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs = $query->result_array();
            foreach ($rs as $itm) {
                $ids[] = $itm['child_id'];
            }
            return $ids;
        }

        return false;
    }

    function SelProductChild($pid) {
        $this->db->select('child_id');
        $this->db->where('parent_id', $pid);
        $query = $this->db->get('product_configurable_link');
        $ids = array();
        if ($query->num_rows() > 0) {
            $rs = $query->result_array();
            foreach ($rs as $itm) {
                $ids[] = $itm['child_id'];
            }
            //return $ids;
        }
        if (!empty($ids)) {
            $this->db->select('t1.id as pid, t1.name,t1.sku, GROUP_CONCAT(a2.id) as attr_id, GROUP_CONCAT(a2.label) as attr_label, t1.price, t1.quantity');
            $this->db->from('product t1');
            $this->db->join('cat_prod t2', 't2.pid = t1.id');
            $this->db->join('attribute_varchar a1', 'a1.pid = t1.id');
            $this->db->join('attribute a2', 'a2.id = a1.attr_id');
            $this->db->where('t1.type', 'standard');
            $this->db->where('t1.is_active', 1);
            $this->db->where_in('t1.id', $ids);
            $this->db->group_by('t1.id');

            $query2 = $this->db->get();

            if ($query2->num_rows() > 0) {
                $rs = $query2->result_array();
                return $rs;
            } else {
                return false;
            }
        }

        return false;
    }

    function ProductSiblings($cid, $pid) {
        $this->db->select('t1.id, t1.name');
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't2.pid = t1.id');
        $this->db->where('t2.cid', $cid);
        $this->db->where('t1.id !=', $pid);
        $this->db->where('t1.type !=', 'config');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    // get product be sku
    function getProductBySku($sku) {
        $this->db->select('t1.*, t3.id as category_id, t3.name as category_name');
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid');
        $this->db->join('category t3', 't3.id = t2.cid');
        $this->db->where('t1.sku', $sku);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    //selected attributes
    function selectAttributes($id) {
        $this->db->select('t1.attr_id, c1.cid');
        $this->db->from('product_configurable_attr t1');
        $this->db->join('cat_prod c1', 'c1.pid = t1.parent_id', 'LEFT');
        $this->db->where('t1.parent_id', $id);
        $this->db->group_by('t1.attr_id');
        // $this->db->where('t1.cid',$catid);
        $query = $this->db->get();
        $outputArr = array();
        if ($query->num_rows() > 0) {
            $aidArray = array();
            foreach ($query->result_array() as $arr) {
                $aidArray[] = $arr['attr_id'];
                $outputArr['cid'] = $arr['cid'];
            }
            // print_r($query->result_array());
            $outputArr['attributes'] = $aidArray;
            return $outputArr;
        }
        return $outputArr['attributes'] = array();
    }

    function deleteAllRec($pid) {
        //get image detail
        $result = $this->db->where('pid', $pid)->get('prod_img')->result_array();

        if (count($result) > 0) {
            foreach ($result as $value) {
                $path = $this->config->item('PRODUCT_PATH');
                $filename = $path . $value['img'];
                if (file_exists($filename)) {
                    @unlink($filename);
                }
            }
        }

        //delete product
        $this->db->where('id', $pid);
        $this->db->delete('product');

        //delete product image
        $this->db->where('pid', $pid);
        $this->db->delete('prod_img');
        return 1;
    }

    function pdetail($pid) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('id', intval($pid));
        $query = $this->db->get();
//        e($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function getDetails($pid, $uid, $pricelist, $tierprice) {
//        $userInfo = self::getProfileGroup($uid);
//        $profile_id = $userInfo['profile_id'];

        if ($pricelist == 2) {
            $this->db->select('t1.*, t2.img, t2.imgalt,t3.discount, t3.special_price');
        } else {
            $this->db->select('t1.*, t2.img, t2.imgalt');
        }

        $this->db->from('product t1');
        $this->db->join('prod_img t2', 't1.id = t2.pid AND t2.main = 1', 'left');
        if ($pricelist == 2) {
            $this->db->join('product_assignment t3', "t3.product_id = t1.id AND t3.user_id = $uid", 'left');
        }
        $this->db->where('t1.is_active', 1);
        $this->db->where('t1.id', $pid)->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    function getProfileGroup($uid) {
        return $this->db
                        ->where('user_id', $uid)
                        ->get('user')->row_array();
    }

    function listAllBrands() {
        $this->db->select('id, name');
        return $this->db->get('brand')->result_array();
    }

    function userJsonProducts($curUsr) {
        $this->db->select('t1.id, t1.name, t1.sku,  t1.type, t1.price, t1.is_active');
        $this->db->from('product t1');
        $this->db->join('br_product_assignment t2', "t1.id = t2.product_id AND t2.user_id = $curUsr");
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result_array();
    }

    function userAssignedProducts($user_id, $offset, $limit, $search, $order) {
        $all = $manually = [];
        $assignment = $this->db
                ->from('category_assignment')
                ->where('user_id', $user_id)
                ->get()
                ->result_array()
        ;
        foreach ($assignment as $assign) {
            if ($assign['assign_type'] == 'manual') {
                $manually[] = $assign['catid'];
                $all[] = $assign['catid'];
            } else {
                $all[] = $assign['catid'];
            }
        }
        $result = $this->assignedProductsDetails($user_id, $all, $manually, $offset, $limit, $search, $order);
        return $result;
    }

    function totalcount($user_id, $allcats, $somecats, $searchTerm) {
        $output = array();
        if ($searchTerm) {
            $this->db->select('sum(IF(1=1,1,1)) as total,sum(IF(t1.sku LIKE "%' . $searchTerm . '%",1,IF(t1.name LIKE "%' . $searchTerm . '%",1,0))) as searchTotal ,t1.sku, t1.name as pname', false);
        } else {
            $this->db->select('sum(IF(1=1,1,1)) as total, sum(IF(1=1,1,1)) as searchTotal, t1.sku, t1.name as pname', false);
        }
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid ');
        $this->db->join('category t3', 't3.id = t2.cid');
        $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
        $this->db->where_in('t3.id', $allcats);
        $or = [];
        foreach ($somecats as $cart) {
            $or[] = " (t3.id=$cart AND t4.active=1) ";
        }
        $or = implode('OR', $or);
        if ($or) {
            $or = " OR $or ";
        }
        $tmp = implode(',', $allcats);
        $this->db->where("(t3.id in ($tmp) $or)", null, false);
        if ($searchTerm) {
            $this->db->like('t1.name', $searchTerm);
            $this->db->or_like('t1.sku', $searchTerm);
        }
        $row = $this->db->get()->row_array();
        // ee($row);
        return $row;
    }

    function assignedProductsDetails($user_id, $allcats, $somecats, $offset, $limit, $searchTerm, $order) {
        $output = array();
        $this->db->select('t1.id as pid, t1.sku, t1.name as pname, t1.type, t1.price as pprice, t3.id as cid, t3.name as cname, t4.discount as dis, t4.special_price as sp, t4.active');
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid ');
        $this->db->join('category t3', 't3.id = t2.cid');
        $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
        $or = [];
        foreach ($somecats as $cart) {
            $or[] = " (t3.id=$cart AND t4.active=1) ";
        }
        $or = implode('OR', $or);
        if ($or) {
            $or = " OR $or ";
        }
        $tmp = implode(',', $allcats);
        $this->db->where("(t3.id in ($tmp) $or)", null, false);

        if ($searchTerm) {
            $this->db->like('t1.name', $searchTerm);
            $this->db->or_like('t1.sku', $searchTerm);
        }
        if ($limit)
            $this->db->limit($limit);
        if ($offset)
            $this->db->offset($offset);
        $this->db->group_by('t1.id');
        if ($order) {
            switch ($order['column']) {
                case '1':
                    $this->db->order_by('t1.name', $order['dir']);
                    break;
                case '2':
                    $this->db->order_by('t1.sku', $order['dir']);
                    break;
                case '3':
                    $this->db->order_by('t1.type', $order['dir']);
                    break;
                default:
                    break;
            }
        }
        $query = $this->db->get();
        // ee($this->db->last_query());
        foreach ($query->result_array() as $row) {
            $output[] = $row;
        }
        $tmp = [];
        $tmp['data'] = $output;
        $records = $this->totalcount($user_id, $allcats, $somecats, $searchTerm);
        $tmp['recordsFiltered'] = ($records['searchTotal']) ? $records['searchTotal'] : 0;
        $tmp['recordsTotal'] = ($records['total']) ? $records['total'] : 0;
        return $tmp;
    }

    function getAttrDetail($pid) {
        $this->db->select('t3.id value,t3.option value_label, t2.id attribute_id,t2.name attribute_label,');
        $this->db->from('attribute_varchar t1');
        $this->db->join('attribute t2', 't2.id = t1.attr_id');
        $this->db->join('attribute_option t3', 't3.id = t1.value');
        $this->db->where_in('t1.pid', $pid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    function getProduct($sku, $select = '*') {
        $result = $this->db
                        ->select($select)
                        ->from('product')
                        ->where('sku', $sku)
                        ->get()->row_array()
        ;
        return $result;
    }

    function get_pdfs($product_id) {
        $rs = $this->db->select('*')
                ->where('product_id', $product_id)
                ->get('product_pdf');

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return FALSE;
    }

    function get_non_config_products($name = "") {
        $rs = array();
        $this->db->select('id, name, price')
                ->from('product')
                ->where('type <>', 'config')
                ->where('is_active', 1);
        if (!empty($name)) {
            $this->db->like('name', $name, 'both');
        }

        $rs = $this->db->get();

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return FALSE;
    }

    function get_non_config_products_dt($limit, $offset, $searchTerm) {
        $output = array();
        $this->db->select('t1.id, t1.name, t1.price, t1.name')->from('product t1')->where('t1.type <>', 'config')->where('t1.is_active', 1);
        if ($searchTerm) {
            $this->db->like('t1.sku', $searchTerm);
            $this->db->or_like('t1.name', $searchTerm);
        }
        $this->db->limit($limit);
        $this->db->offset($offset);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $output[] = $row;
        }
        $records = $this->totalAccessoriescount($searchTerm);
        $tmp = [];
        $tmp['data'] = $output;
        $tmp['recordsFiltered'] = $records['searchTotal'];
        $tmp['recordsTotal'] = $records['total'];
        return $tmp;
    }

    function totalAccessoriescount($searchTerm) {
        $output = array();
        if ($searchTerm) {
            $this->db->select('sum(IF(1=1,1,1)) as total,sum(IF(t1.sku LIKE "%' . $searchTerm . '%",1,IF(t1.name LIKE "%' . $searchTerm . '%",1,0))) as searchTotal ,t1.sku, t1.name as pname', false);
        } else {
            $this->db->select('sum(IF(1=1,1,1)) as total, sum(IF(1=1,1,1)) as searchTotal, t1.sku, t1.name as pname', false);
        }
        $this->db->from('product t1')->where('t1.type <>', 'config')->where('t1.is_active', 1);
        if ($searchTerm) {
            $this->db->like('t1.sku', $searchTerm);
            $this->db->or_like('t1.name', $searchTerm);
        }
        $row = $this->db->get()->row_array();
        return $row;
    }

    function get_accessories($config_product_id) {
        $rs = array();
        $rs = $this->db->select('accessories.*, product.name as name')
                ->from('accessories')
                ->join('product', 'product.id = accessories.product_id')
                ->where('config_product_id', $config_product_id)
                ->get();

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return FALSE;
    }

    function is_duplicate_accessory($config_product_id, $product_id) {
        $rs = array();
        $rs = $this->db->select('*')
                ->from('accessories')
                ->where('config_product_id', $config_product_id)
                ->where('product_id', $product_id)
                ->get();
        if ($rs->num_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    function listByCategory($cid) {
        $this->db->select('t1.id as pid,t1.name,t1.sku,t1.type,t1.price,t1.is_active,t2.*');
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't2.pid = t1.id');
        $qu = "t2.cid = " . intval($cid) . " AND t1.id NOT IN (select pf.child_id from br_product_configurable_link as pf)";
        $this->db->where($qu);
        $query = $this->db->get();
        return $query->result_array();
    }

    function childProductsAllTemp($childPids, $attributes) {
        $this->db->select('t1.id,t1.name,t1.sku,t1.price,t1.name,t1.quantity,group_concat(t4.attr_id) as attr_id,group_concat(t5.name) as attr_label', false);
        $this->db->from('product t1');
        $this->db->join('attribute_varchar t4', 't1.id=t4.pid');
        $this->db->join('attribute t5', 't4.attr_id=t5.id');
        $this->db->where('t1.is_active', 1);
        $this->db->where_in('t1.id', $childPids);
        $this->db->where_in('t4.attr_id', $attributes);
        $this->db->where("LOWER(t4.value) != 'select'");
        $this->db->where('t4.value !=', '0');
        $this->db->where('t4.value !=', '');
        $this->db->having('COUNT(*) >=' . count($attributes), false);
        $this->db->group_by("t1.id");
        $query = $this->db->get();
//        e($this->db->last_query());
        return $query->result_array();
    }

    function countbrochures() {
        $this->db->from('product_brochures');
        return $this->db->count_all_results();
    }

    function allbrochures($offset = FALSE, $limit = FALSE) {
        $this->db->from('product_brochures');
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }

    function insertbrochures() {
//        $this->load->library('upload');
        $config = $uploadData = array();
        $config['upload_path'] = $this->config->item('BROCHURES_PATH');
        $config['allowed_types'] = '*';
        $config['max_size'] = 0;
        //$config['overwrite'] = FALSE;
        //$config['encrypt_name'] = FALSE;
//        $this->upload->initialize($config);
        $filesCount = count($_FILES['brochure']['name']);
        for ($i = 0; $i < $filesCount; $i++) {
            $_FILES['file']['name'] = $_FILES['brochure']['name'][$i];
            $_FILES['file']['type'] = $_FILES['brochure']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['brochure']['tmp_name'][$i];
            $_FILES['file']['error'] = $_FILES['brochure']['error'][$i];
            $_FILES['file']['size'] = $_FILES['brochure']['size'][$i];

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fileData = $this->upload->data();
//                $uploadData[$i]['brochure'] = $fileData['file_name'];
//                $uploadData[$i]['addedon'] = time();
                $uploadData['brochure'] = $fileData['file_name'];
                $uploadData['addedon'] = time();
                $this->db->insert('product_brochures', $uploadData);
            } else {
                show_error($this->upload->display_errors('<p class="err">', '</p>'));
                return FALSE;
            }
        }
//        $this->db->insert_batch('product_brochures', $uploadData);
    }

    function brochuredetail($id) {
        $this->db->where('id', intval($id));
        $query = $this->db->get('product_brochures');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    function updatebrochures($brochure) {
        $this->load->library('upload');
        $config = $data = array();
        $config['upload_path'] = $this->config->item('BROCHURES_PATH');
        $config['allowed_types'] = '*';
        $config['max_size'] = 0;
        //$config['overwrite'] = FALSE;
        //$config['encrypt_name'] = FALSE;

        $this->upload->initialize($config);
        if (count($_FILES) > 0) {
            if ($_FILES['brochure']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['brochure']['tmp_name'])) {
                if (!$this->upload->do_upload('brochure')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    $data['brochure'] = $upload_data['file_name'];
                    $data['updatedon'] = time();
                    $path = $this->config->item('BROCHURES_PATH');
                    $filename = $path . $brochure['brochure'];
                    if (file_exists($filename)) {
                        @unlink($filename);
                    }
                }
            }
            $this->db->where('id', $brochure['id']);
            $this->db->set('product_brochures', $data);
            return;
        }
    }

    function deletebrochures($brochure) {
        $this->db->where('id', $brochure['id']);
        $this->db->delete('product_brochures');
        $path = $this->config->item('BROCHURES_PATH');
        $filename = $path . $brochure['brochure'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
        return;
    }

    function selectedbrochures($pid) {
        $this->db->where('pid', intval($pid));
        $query = $this->db->get('product_brochures_link');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

}

?>
