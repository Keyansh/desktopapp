<?php

class Attributesmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //fetch the attributes details
    function getAttributes($a_id) {
        $this->db->where('attribute_id', $a_id);
        $query = $this->db->get('attribute');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //fetch the attributes from code
    function getAttributeFromCode($code, $select = '*') {
        $this->db->select($select);
        $this->db->where('code', $code);
        $query = $this->db->get('attribute');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //list all attributes
    function fetchByProductID($product_id = false, $offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->select('tvar.attr_id, tvar.value, tatt.label, tatt.type, taop.option, tvar.pid, tatt.name,taop.icon,taop.additional_info');
        $this->db->from('attribute_varchar tvar');
        $this->db->join('attribute tatt', 'tvar.attr_id = tatt.id');
        $this->db->join('attribute_option taop', 'taop.id = tvar.value');
        $this->db->where('tvar.pid', intval($product_id));
        // $this->db->group_by('tvar.value');
        $query = $this->db->get();
        //e($this->db->last_query());
        return $query->result_array();
    }

    function fetchAssignedOptions($product_id) {
        $this->db->select('t1.*');
        $this->db->from('attribute_varchar t1');
        $this->db->join('attribute t2', 't1.attr_id = t2.id');
        $this->db->where('t1.pid',$product_id);
        $this->db->group_by('t1.attr_id');
        $attrs = $this->db->get()->result_array();

        $attrs_options = [];
        foreach($attrs as $item){
            $this->db->select('t1.*');
            $this->db->from('attribute_option t1');
            $this->db->join('attribute_varchar t2', 't1.id = t2.value');
            $this->db->where('t1.attr_id',$item['attr_id']);
            $this->db->where('t2.pid',$product_id);
            $assigned_options = $this->db->get()->result_array();

            $attrs_options[$item['attr_id']] = $assigned_options;
        }

        return $attrs_options;
    }

    //list all attributes
    function listOptions() {

        $this->db->select('*');
        $this->db->from('attribute_option');
        //$this->db->join('attribute', 'attributes.attributes_id = attributes_value.attributes_id');
        //$this->db->where('attribute_value_id', $attributes['attribute_value_id']);
        $query = $this->db->get();
        return $query->result_array();
    }

    //list all attributes
    function fetchAttributes($product_id = false, $attrid = false, $offset = FALSE, $limit = FALSE) {
        $this->db->select('tvar.attr_id, tvar.value, tatt.label, tatt.type, taop.option, tvar.pid, tatt.name');
        $this->db->from('attribute_varchar tvar');
        $this->db->join('attribute tatt', 'tvar.attr_id = tatt.id');
        $this->db->join('attribute_option taop', 'taop.id = tvar.value');
        $this->db->where('tvar.pid', $product_id);
        $this->db->where_not_in('tvar.attr_id', $attrid);
        $this->db->limit(1);

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    function fetchAttVal($parent_id, $att_id, $value) {

        //Child Products
        $this->db->select('conf.child_id');
        $this->db->from('product_configurable_link conf');
        $this->db->where('conf.parent_id', $parent_id);
        $childIDs = $this->db->get();
        $result = $childIDs->result_array();

        //Parent Attributes
        $this->db->select('*');
        $this->db->from('product_configurable_attr confAttr');
        $this->db->where('confAttr.parent_id', $parent_id);
        $confAttr = $this->db->get();
        $resConfAttr = $confAttr->result_array();


        $ids = array();
        $attrData = array();
        $attrResult = array();
        foreach ($result as $v) {
            $ids[] = $v['child_id'];
        }
        //print_r($ids);
        if (!empty($ids)) {

            foreach ($ids as $pid) {
                $this->db->select('tvar.value, opt.attr_id, tvar.pid');
                $this->db->from('attribute_varchar tvar');
                $this->db->join('attribute_option opt', 'opt.id = tvar.value', 'INNER');
                $this->db->where('tvar.pid', $pid);
                $this->db->where('tvar.attr_id !=', $att_id);
                //$this->db->group_by('opt.attr_id');
                $query2 = $this->db->get();
                //echo $this->db->last_query();
                $attrData[] = $query2->result_array();
            }
        }

        //return ($attrData);
        $data = array();
        $pid = 0;

        if (!empty($attrData)) {
            foreach ($attrData as $i => $v) {

                foreach ($v as $id) {
                    $pid = $id['pid'];
                }
                $attrData[$i][] = array("attr_id" => $att_id, "value" => $value, "pid" => $pid);
            }

            $data = array();
            foreach ($attrData as $dds) {
                $atArray = array();
                $atValArray = array();
                $pidArray = array();
                for ($i = 0; $i < count($dds); $i++) {
                    $atArray[] = $dds[$i]['attr_id'];
                    $atValArray[] = $dds[$i]['value'];
                    $pidArray[] = $dds[$i]['pid'];
                }

                $this->db->select("tvar.pid,tvar.attr_id, tvar.value");
                $this->db->from("attribute_varchar tvar");
                $qu = "(tvar.attr_id IN (" . implode(",", $atArray) . ") AND tvar.value IN (" . implode(",", $atValArray) . ") AND tvar.pid IN (" . implode(",", $pidArray) . "))";
                $this->db->where($qu);
                $this->db->group_by("tvar.value");
                //$this->db->having("count(*) <" . count($attrData));
                $dbquery = $this->db->get();
                // echo $this->db->last_query();
                if (count($dbquery->result_array()) == count($attrData)) {
                    $data[] = $dbquery->result_array();
                }
            }

            //return $attrData;
            return $data;
            //print_r($data);
        }

        //return $attrData;
    }

    function fetchAtrrValues($parent_id, $att_id = [], $dependentAttArr = null) {
        $this->db->select('conf.child_id');
        $this->db->from('product_configurable_link conf');
        $this->db->where('conf.parent_id', $parent_id);
        $childIDs = $this->db->get();
        $result = $childIDs->result_array();
        $ids = array();
        foreach ($result as $v) {
            $ids[] = $v['child_id'];
        }
        if (!empty($ids)) {
            $this->db->select('tvar.pid');
            $this->db->from('attribute_varchar tvar');
            $this->db->where_in('tvar.pid', $ids);
            $attrArra = array();
            if (!empty($dependentAttArr)) {
                $firstPart = "";
                $atArray = array();
                $atValArray = array();
                foreach ($dependentAttArr as $aidDep => $aidVal) {
                    $atArray[] = $aidDep;
                    $atValArray[] = $aidVal;
                    //$this->db->where($qu);
                }
                $qu = "(tvar.attr_id IN (" . implode(",", $atArray) . ") AND tvar.value IN (" . implode(",", $atValArray) . "))";
                $this->db->where($qu);
                $this->db->group_by("tvar.pid");
                $this->db->having("count(*) = " . count($dependentAttArr));
            } else {
                $this->db->where_in('tvar.attr_id', $att_id);
            }

            $query = $this->db->get();
//            echo $this->db->last_query();
            //die($this->db->last_query()) ;
            //return $query->result_array();
            $chldIds = array();
            foreach ($query->result_array() as $valIDs) {
                $chldIds[] = $valIDs['pid'];
            }

//            print_r($chldIds);
//            die;

            $this->db->select('tvar.value, opt.option, opt.attr_id, opt.icon, opt.additional_info');
            $this->db->from('attribute_varchar tvar');
            $this->db->join('attribute_option opt', 'opt.id = tvar.value', 'INNER');
            if ($chldIds) {
                $this->db->where_in('tvar.pid', $chldIds);
            }
            $this->db->where_in('tvar.attr_id', $att_id);
            $this->db->order_by("opt.option","ASC");
            $this->db->group_by('tvar.value');
            $query2 = $this->db->get();
//            die($this->db->last_query()) ;

            return $query2->result_array();
        }


        //$this->db->where_not_in('tvar.attr_id', $attrid);
        //$this->db->limit(1);
    }

    //Product Configurable Get Price
    function fetchPrice($attVal, $parentID) {
        //return $attVal;
        $this->db->select('tvar.pid');
        $this->db->from('attribute_varchar tvar');
        //$this->db->where_in('tvar.pid', $ids);
        $attrArra = array();
        if (!empty($attVal)) {
            $firstPart = "";
            $atArray = array();
            $atValArray = array();
            foreach ($attVal as $aidDep => $aidVal) {
                $atArray[] = $aidVal['att_id'];
                $atValArray[] = $aidVal['value'];
                //$this->db->where($qu);
            }
            $qu = "(tvar.attr_id IN (" . implode(",", $atArray) . ") AND tvar.value IN (" . implode(",", $atValArray) . "))";
            $this->db->where($qu);
            $this->db->group_by("tvar.pid");
            $this->db->having("count(*) = " . count($attVal));
        }

        $query = $this->db->get();
        //return$query->result_array();
        $pid = array();
        //echo $this->db->last_query() ;
        if ($query->num_rows() > 0) {
            $pidArray = $query->result_array();
            foreach ($pidArray as $value) {
                $pid[] = $value['pid'];
            }
            //return $pid;
            $this->db->select('min(p1.price) as price, p1.id as pid');
            $this->db->from('product p1');
            $this->db->join('br_product_configurable_link t3', 't3.child_id = p1.id', 'INNER');
            $this->db->where_in('p1.id', $pid);
            $this->db->where('t3.parent_id', $parentID);
            $this->db->group_by('p1.price');
            //$this->db->having("min(p1.price)");
            $query2 = $this->db->get();
            //echo $this->db->last_query() ;
            return $query2->row_array();
        }
        return false;
    }

    function fetchProduct($attVal, $parentID, $qty, $accessories) {
        $childIDs = $this->db
                        ->select('child_id')
                        ->from('product_configurable_link')
                        ->where('parent_id', $parentID)
                        ->get()->result_array();
        $childIDs = $this->array_column1($childIDs, 'child_id');

        $result = $attributes = $product = $product_ids = $parent_product = [];

        foreach ($attVal as $key => $value) {
            $attribute = $this->db
                            ->select('t1.id attribute_id,t1.label attribute_label,t2.option value_label,t2.id value')
                            ->from('attribute t1')
                            ->join('attribute_option t2', 't1.id=t2.attr_id AND t2.id=' . $value['value'])
                            ->where('t1.id', $value['att_id'])
                            ->get()->row_array();
            if ($attribute) {
                $attributes[] = $attribute;
            }
            $this->db
                    ->select('pid')
                    ->from('attribute_varchar')
                    ->where('attr_id', $value['att_id'])
                    ->where('value', $value['value']);
            if ($product_ids) {
                $this->db->where_in('pid', $product_ids);
            } else {
                $this->db->where_in('pid', $childIDs);
            }
            $result = $this->db->get()->result_array();
            $product_ids = $this->array_column1($result, 'pid');
        }

        $return['success'] = false;
        $all_mini_cart_items = $this->session->userdata('CONFIG_PRODUCT_ID');
        if ($result) {
            // Add Accessories to Cart
            $this->load->model('cart/Cartmodel');
            $accessories_arr = array();
            $accessories_arr = $this->get_accessories($accessories);

            if ($accessories_arr) {
                foreach ($accessories_arr as $k => $v) {
                    $tmp = [];
                    $tmp['id'] = $v['product_id'];
                    $tmp['product_sku'] = $v['product_sku'];
                    $tmp['qty'] = $v['quantity'];
                    $tmp['name'] = $v['name'];
                    $tmp['price'] = $v['quantity'] * $v['price'];
                    $tmp['actual_price'] = $tmp['price'];
                    $tmp['is_taxable'] = $v['is_taxable'];
                    $tmp['main_product_id'] = $v['config_product_id'];
                    $cart_id = $this->cart->insert($tmp);
                }
            }
            // e($this->cart->contents());
            // End - Add Accessories to Cart

            $result = current($result);
            $user_id = ($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : 0;
            $profile_id = ($this->session->userdata('profile_id')) ? $this->session->userdata('profile_id') : 1;
            $response = $this->Productmodel->getProductPrice($result['pid'], $user_id, $profile_id, $qty);
            $product = $this->db->select('id,sku,type,name,description,is_taxable')->from('product')->where('id', $result['pid'])->get()->row_array();
            $parent_product = $this->db->select('sku,price')->from('product')->where('id', $parentID)->get()->row_array();
            $priceapply = ($parent_product['price'] > 0) ? $parent_product['price'] : $response['actual_price'];
            $tmp[$result['pid']] = [
                'attributes' => $attributes,
                'price' => $priceapply,
                'qty' => $qty,
                'type' => $product['type'],
                'parent_sku' => $parent_product['sku'],
                'parent_price' => $parent_product['price'],
                'product_id' => $product['id'],
                'product_name' => $product['name'],
                'product_sku' => $product['sku'],
                'actual_price' => $response['actual_price'],
                'discounting_type' => $response['discounting_type'],
                'special_price_type' => $response['special_price_type'],
                'special_price' => $response['special_price'],
                'tier_price' => $response['tier_price'],
                'product_desc' => substr(strip_tags($product['description']), 0, 250),
                'is_taxable' => $product['is_taxable'],
            ];

            $tmp2 = isset($all_mini_cart_items[$parentID]) ? $all_mini_cart_items[$parentID] : [];
            $tmp = array_replace($tmp2, $tmp);
            $all_mini_cart_items[$parentID] = $tmp;
            $return['success'] = true;
        }
        $this->session->set_userdata('CONFIG_PRODUCT_ID', $all_mini_cart_items);
        echo json_encode($return);
    }

    //Product Configurable Get Price
    function fetchProduct_old($attVal, $parentID, $qty) {

        //print_r($attVal);
        //return $attVal;
        $this->db->select('tvar.pid');
        $this->db->from('attribute_varchar tvar');
        //$this->db->where_in('tvar.pid', $ids);
        $attrArra = array();
        if (!empty($attVal)) {
            $firstPart = "";
            $atArray = array();
            $atValArray = array();
            foreach ($attVal as $aidDep => $aidVal) {
                $atArray[] = $aidVal['att_id'];
                $atValArray[] = $aidVal['value'];
                //$this->db->where($qu);
            }
            $qu = "(tvar.attr_id IN (" . implode(",", $atArray) . ") AND tvar.value IN (" . implode(",", $atValArray) . "))";
            $this->db->where($qu);
            $this->db->group_by("tvar.pid");
            $this->db->having("count(*) = " . count($attVal));
        }

        $query = $this->db->get();

        //echo $this->db->last_query();
        // return $query->result_array();

        $pid = array();

        //echo $this->db->last_query() ;
        if ($query->num_rows() > 0) {
            $pidArray = $query->result_array();
            foreach ($pidArray as $value) {
                $pid[] = $value['pid'];
            }
            //return $pid;
            $this->db->select('min(p1.price) as price, p1.id as pid');
            $this->db->from('product p1');
            $this->db->join('attribute_varchar t4', 't4.pid = p1.id', 'INNER');
            $this->db->join('br_product_configurable_link t3', 't3.child_id = p1.id', 'INNER');

            $this->db->where_in('p1.id', $pid);
            $this->db->where('t3.parent_id', $parentID);
            $this->db->group_by('p1.price');
            //$this->db->having("min(p1.price)");
            $query2 = $this->db->get();
            //echo $this->db->last_query() ;
            $tempResult = $query2->row_array();

            foreach ($tempResult as $pid) {
                $this->db->select('p1.id as pid, p1.price as price, t5.id as attrid, t6.id as attVal, t5.label, t6.option');
                $this->db->from('product p1');
                $this->db->join('attribute_varchar t4', 't4.pid = p1.id', 'INNER');
                $this->db->join('attribute t5', 't5.id = t4.attr_id', 'INNER');
                $this->db->join('attribute_option t6', 't6.attr_id = t5.id AND t6.id = t4.value', 'INNER');
                $this->db->where('p1.id', $pid['pid']);
                $this->db->group_by('t4.value');
                $query3 = $this->db->get();
                $tempResult2 = $query3->result_array();
            }

            //return $tempResult2;

            $items = array();

            foreach ($tempResult2 as $k => $v) {
                $items[$v['pid']]['attributes'][] = array(
                    'attribute_id' => $v['attrid'],
                    'attribute_label' => $v['label'],
                    'value_label' => $v['option'],
                    'value' => $v['attVal'],
                );
                $items[$v['pid']]['price'] = $v['price'];
                $items[$v['pid']]['qty'] = $qty;
            }
            // e($items);
            // return $items;
            $this->session->userdata["CONFIG_PRODUCT_ID"][$parentID][] = $items;

            $this->session->sess_write();

            return $items;
        }
        return false;
    }

    function fetchImage($attVal, $parentID) {
        //return $attVal;
        $this->db->select('tvar.pid');
        $this->db->from('attribute_varchar tvar');
        //$this->db->where_in('tvar.pid', $ids);
        $attrArra = array();
        if (!empty($attVal)) {
            $firstPart = "";
            $atArray = array();
            $atValArray = array();
            foreach ($attVal as $aidDep => $aidVal) {
                $atArray[] = $aidVal['att_id'];
                $atValArray[] = $aidVal['value'];
                //$this->db->where($qu);
            }
            $qu = "(tvar.attr_id IN (" . implode(",", $atArray) . ") AND tvar.value IN (" . implode(",", $atValArray) . "))";
            $this->db->where($qu);
            $this->db->group_by("tvar.pid");
            $this->db->having("count(*) = " . count($attVal));
        }

        $query = $this->db->get();
        //return$query->result_array();
        $pid = array();
        $images = array();

        if ($query->num_rows() > 0) {
            $pidArray = $query->result_array();
            foreach ($pidArray as $value) {
                $pid[] = $value['pid'];
            }
            //return $pid;
            $this->db->select('min(p1.price) as price, p1.id as pid, p2.img as mainImage');
            $this->db->from('product p1');
            $this->db->join('prod_img p2', 'p2.pid = p1.id AND main = 1', 'LEFT');
            $this->db->join('br_product_configurable_link t3', 't3.child_id = p1.id', 'INNER');
            $this->db->where_in('p1.id', $pid);
            $this->db->where('t3.parent_id', $parentID);
            $this->db->group_by('p1.price');
            //$this->db->having("min(p1.price)");
            $query2 = $this->db->get();
            //echo $this->db->last_query() ;
            $images['mainImage'] = $query2->row_array();

            $this->db->select('min(t1.price) as price, t1.id as pid, GROUP_CONCAT(t2.img) as images');
            $this->db->from('product t1');
            $this->db->join('prod_img t2', 't2.pid = t1.id', 'LEFT');
            $this->db->join('br_product_configurable_link t3', 't3.child_id = t1.id', 'INNER');
            $this->db->where_in('t1.id', $pid);
            $this->db->where('t3.parent_id', $parentID);
            $this->db->group_by('t1.price');
            //$this->db->having("min(p1.price)");
            $query3 = $this->db->get();
            //echo $this->db->last_query();
            $images['images'] = $query3->result_array();
            if (empty($images['mainImage']['mainImage'])) {
                $images['mainImage']['mainImage'] = 'no-image.jpg';
            }
            return $images;
        }
        return false;
    }

    function fetchAtrrValuesBypro($pids, $att_id = []) {
        $this->db->select('tvar.value, opt.option, opt.attr_id, opt.icon, opt.additional_info');
        $this->db->from('attribute_varchar tvar');
        $this->db->join('attribute_option opt', 'opt.id = tvar.value', 'INNER');
        $this->db->where_in('tvar.pid', $pids);
        $this->db->where_in('tvar.attr_id', $att_id);
        $this->db->group_by('tvar.value');
        $query2 = $this->db->get();
//        die($this->db->last_query());
        return $query2->result_array();
    }

    function fetchBundleAtrrValues($parent_id, $att_id = [], $dependentAttArr = null) {
        //print_r($dependentAttArr);
        //print_r($att_id);
        //print_r($parent_id);
        //die;

        $this->db->select('conf.child_id');
        $this->db->from('product_configurable_link conf');
        $this->db->where('conf.parent_id', $parent_id);
        $childIDs = $this->db->get();
        $result = $childIDs->result_array();
        $ids = array();
        foreach ($result as $v) {
            $ids[] = $v['child_id'];
        }
        if (!empty($ids)) {
            $this->db->select('tvar.pid');
            $this->db->from('attribute_varchar tvar');
            $this->db->where_in('tvar.pid', $ids);
            $attrArra = array();
            if (!empty($dependentAttArr)) {
                $firstPart = "";
                $atArray = array();
                $atValArray = array();
                foreach ($dependentAttArr as $aidDep => $aidVal) {
                    $atArray[] = $aidDep;
                    $atValArray[] = $aidVal;
                    //$this->db->where($qu);
                }
                $qu = "(tvar.attr_id IN (" . implode(",", $atArray) . ") AND tvar.value IN (" . implode(",", $atValArray) . "))";
                $this->db->where($qu);
                $this->db->group_by("tvar.pid");
                $this->db->having("count(*) = " . count($dependentAttArr));
            } else {
                $this->db->where_in('tvar.attr_id', $att_id);
            }

            $query = $this->db->get();
//            echo $this->db->last_query();
            //die($this->db->last_query()) ;
            //return $query->result_array();
            $chldIds = array();
            foreach ($query->result_array() as $valIDs) {
                $chldIds[] = $valIDs['pid'];
            }

//            print_r($chldIds);
//            die;

            $this->db->select('tvar.pid,tvar.value, opt.option, opt.attr_id, opt.icon, opt.additional_info');
            $this->db->from('attribute_varchar tvar');
            $this->db->join('attribute_option opt', 'opt.id = tvar.value', 'INNER');
            if ($chldIds) {
                $this->db->where_in('tvar.pid', $chldIds);
            }
            $this->db->where_in('tvar.attr_id', $att_id);
//            $this->db->group_by('tvar.value');
            $query2 = $this->db->get();
//            die($this->db->last_query()) ;
            return $query2->result_array();
        }


        //$this->db->where_not_in('tvar.attr_id', $attrid);
        //$this->db->limit(1);
    }

    function array_column1(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( !array_key_exists($columnKey, $value)) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( !array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }

    function get_accessories($arr) {
        $rs = array();
        $rs = $this->db->select('accessories.*, product.sku as product_sku, product.type as type, product.name as name, product.is_taxable as is_taxable')
            ->from('accessories')
            ->join('product', 'product.id = accessories.product_id')
            ->where_in('accessories.id', $arr)
            ->get();

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return FALSE;
    }

}

?>
