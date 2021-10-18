<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends Cms_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->library('parser');
        $this->load->library('email');
    }

    function fetchCorresAttr() {
        $this->load->model('catalog/Attributesmodel');
        $parentID = $this->input->post('parent_id');
        $atrID = $this->input->post('attr_id');
        $value = $this->input->post('value');

        $attrValues = $this->Attributesmodel->fetchAttVal($parentID, $atrID, $value);

        print_r(json_encode($attrValues));


        /* $depArr = json_decode(stripslashes($this->input->post('depend')));

          $filArray = array();
          foreach ($depArr as $val) {
          $filArray[$val->att_id] = $val->value;
          }
          $attrValues = array();
          $attrValues = $this->Attributesmodel->fetchAtrrValues($parentID, $atrID, $filArray);

          if (!empty($attrValues)) {
          //print_r($attrValues);
          //echo $attrValues;
          $optionsHtml = "";
          foreach ($attrValues as $atvRet) {
          $optionsHtml .= '<option value="' . $atvRet['value'] . '">' . ucfirst($atvRet['option']) . '</option>';
          }
          echo $optionsHtml;
          }
          die; */
        //echo json_encode($attrValues);
    }

    function fetch_price() {
        $this->load->model('Productmodel');
        $this->load->model('cart/Cartmodel');

        $option_value_id = array();
        $option_value_id = $_POST;
        $option_value_id = array_slice($option_value_id, 0, 2);
        $quantity = $this->input->post('quantity', true);
        if (is_null($quantity) OR empty($quantity)) {
            $quantity = 1;
        }
        $product_detail = array();
        $product_detail = $this->Productmodel->getDetails($this->input->post('pid', true));

        $price = 0;
        $option_price = array();
        $numericVal = 0;
        foreach ($option_value_id as $key => $item) {
            if (strpos($key, 'option') !== false) {
                $this->db->select('*');
                $this->db->from('option_rows');
                $this->db->join('product', 'product.product_id = option_rows.product_id');
                $this->db->join('options', 'options.option_id = option_rows.option_id');
                $this->db->where('option_row_id', $item);
                $res = $this->db->get();
                if ($res->num_rows() == 1) {

                    $option_rs = $res->row_array();
                    $option_price = $option_rs['price'];
                    $price += $option_price;

                    $optionArr = explode(' ', $option_rs['row_value']);
                    foreach ($optionArr as $key) {
                        if (is_numeric($key)) {
                            $numericVal = $key;
                        }
                    }
                    $price = $price * $numericVal;
                }
            }
        }

        if (intval($price)) {
            $product_price = $price;
        } else {
            $product_price = $product_detail['product_price'];
        }


        $product_price = ($product_price * $quantity);

        // fetch discount
        $discount = $this->Cartmodel->productDiscount($product_detail, $quantity);


        if (!empty($discount)) {
            $output['old_price'] = $product_price;
            $product_discount = round(($product_price * $discount) / 100, 2);
            $product_price = $product_price - $product_discount;
        }
        $prod_price = $product_price;
        if ($product_detail['is_pack'] == "1") {
            $prod_price = $product_price * $product_detail['pack_qty'];
        }
        $tierPrices = $this->Cartmodel->getTierPriceByProductId($this->input->post('pid', true), $quantity);
        if ($tierPrices) {
            $prod_price = $tierPrices['price'] * $quantity;
        }
        if (($product_detail['is_pack'] == "1") && ($tierPrices)) {
            $prod_price = $prod_price * $product_detail['pack_qty'];
        } else {
            $prod_price = $prod_price;
        }
        $output = array();
        $output['price'] = "&pound; " . number_format($prod_price, 2);
        echo json_encode($output);
        exit();
        //echo "Done";
    }

    function attributeShow() {
        $pid = 0;
        $attrid = array();
        $pid = $this->input->post('parent_id', true);
        $attrid = $this->input->post('attr_id', true);

        $this->load->model('Attributesmodel');
        $this->load->model('Productmodel');
        $childProducts = array();
        $result = '';
        $attrArray = array();
        $filterArray = array();

        $childProducts = $this->Productmodel->ChildProducts($pid);

        foreach ($childProducts as $childproduct) {
            $result[] = $this->Attributesmodel->fetchAttributes($childproduct['id'], $attrid);
        }

        // e($result,0);
        if ($result) {

            foreach ($result as $productA) {

                foreach ($productA as $valA) {

                    if ($productA['defaultShow'] == 0) {

                        $attrArray[$valA['name']][] = $valA;
                    }
                }
            }

            foreach ($attrArray as $attk => $attv) {
                foreach ($attv as $k => $v) {
                    if (isset($filterArray[$attk][$v['option']])) {
                        
                    } else {
                        $filterArray[$attk][$v['option']] = $v;
                        $filterArray[$attk][$v['option']]['parent_id'] = $pid;
                    }
                }
            }

            echo json_encode($filterArray);
        }
    }

    function getPrice() {
        $this->load->model('Attributesmodel');
        $selAttributes = array();
        $result = '';
        $parentID = 0;
        $a = $this->input->post('seleledValue');
        $b = $this->input->post('parent_id');
        if (!empty($a) && !empty($b)) {
            $parentID = $this->input->post('parent_id');
            $selAttributes = $this->input->post('seleledValue');
            $result = $this->Attributesmodel->fetchPrice($selAttributes, $parentID);
            echo json_encode($result);
        }
    }

    function getProduct() {
        $this->load->model('Attributesmodel');
        $this->load->model('Productmodel');
        $selAttributes = array();
        $result = false;
        $parentID = 0;
        $a = $this->input->post('seleledValue');
        $b = $this->input->post('parent_id');
        $c = $this->input->post('qty');
        if (!empty($a) && !empty($b) && !empty($c)) {
            $parentID = $this->input->post('parent_id');
            $selAttributes = $this->input->post('seleledValue');
            $qty = $this->input->post('qty');
            $accessories = $this->input->post('accessories');
            $result = $this->Attributesmodel->fetchProduct($selAttributes, $parentID, $qty, $accessories);
        }

        return $result;
    }

    function fetchValues() {
        $this->load->model('catalog/Attributesmodel');
        $parentID = $this->input->post('parent_id');
        $atrID = $this->input->post('attr_id');
        $depArr = json_decode(stripslashes($this->input->post('depend')));

        $filArray = array();
        foreach ($depArr as $val) {
            $filArray[$val->att_id] = $val->value;
        }
        $attrValues = array();
        $attrValues = $this->Attributesmodel->fetchAtrrValues($parentID, $atrID, $filArray);

        if (!empty($attrValues)) {
            //print_r($attrValues);
            //echo $attrValues;
            $optionsHtml = "";
            foreach ($attrValues as $atvRet) {
                $optionsHtml .= '<option value="' . $atvRet['value'] . '">' . ucfirst($atvRet['option']) . '</option>';
            }
            echo $optionsHtml;
        }
        die;
        //echo json_encode($attrValues);
    }

    function getImage() {
        $this->load->model('Attributesmodel');
        $this->load->model('cms/Tiercmsmodel');
        $this->load->model('Productmodel');
        $selAttributes = array();
        $parentID = 0;
        $result = '';
        $special_price = '';
        $customer = array();
        $customer = $this->memberauth->checkAuth();

        $a = $this->input->post('seleledValue');
        $b = $this->input->post('parent_id');
        if (!empty($a) && !empty($b)) {
            $selAttributes = $this->input->post('seleledValue');
            $parentID = $this->input->post('parent_id');
            $result = $this->Attributesmodel->fetchImage($selAttributes, $parentID);
//            e($result);
            //Special Price
            $special_price = $this->Productmodel->getDetails($result['mainImage']['pid'], $customer['profile_id']);

            $result['mainPrice'] = $special_price;

            //Tier Pricing
            if ($customer) {
                $tier_pricing = $this->Tiercmsmodel->getDetails($result['mainImage']['pid'], $customer['profile_id']);
                //$tempArray2 = $this->Tiercmsmodel->getAllDetails($result['mainImage']['pid']);
                //$tier_pricing = array_merge($tempArray1, $tempArray2);
            } else {
                $tier_pricing = $this->Tiercmsmodel->getAllDetails($result['mainImage']['pid']);
            }
            $result['tierPricing'] = $tier_pricing;
            echo json_encode($result);
        }
    }

    /* function attributeShow(){

      $this->load->model('Attributesmodel');
      $prod_id = 0;
      $atrr_id = 0;
      $pro_arry = array();

      $prod_id = $this->input->post('proid');
      $atrr_id = $this->input->post('atrrid');
      $result = array();
      $multiple = array();
      $outputArray = array();
      $pro_arry = explode(',', $prod_id);
      if(count($pro_arry) > 1){

      foreach ($pro_arry as $k => $v) {
      $result[] = $this->Attributesmodel->fetchAttributes($v, $atrr_id);
      }
      foreach ($result as $e) {
      foreach ($e as $d => $t) {
      $multiple[] = $t;
      }
      }
      foreach ($multiple as $value) {
      if(!isset($outputArray[$value['name']])){
      $outputArray[$value['name']] = $value;
      }
      else{
      $outputArray[$value['name']][] = $value;
      }

      }

      echo json_encode($multiple);


      }
      else{

      $result = $this->Attributesmodel->fetchAttributes($prod_id, $atrr_id);

      foreach ($result as $productA) {
      if($productA['defaultShow'] == 0){
      $attrArray[$productA['name']][] = $productA;
      }
      }
      echo json_encode($attrArray);
      }


      }
     */

    function productByCategory() {
        $this->load->model('catalog/Categorymodel');
        $this->load->model('catalog/Productmodel');
        $page = 0;
        $catURl = '';
        $perPage = 0;
        $offset = 0;
        $count = 0;
        $outputHtml = '';
        $attrs = '';
        $mprice = '';
        $attrIDs = array();
        $page = $this->input->post('page', true);
        $catURl = $this->input->post('cat_url', true);
        $perPage = $this->input->post('perPage', true);
        $attrs = $this->input->post('attrs');
        $attrIDs = $filteredProductIds = $combinations = [];
        if ($attrs) {
            $attrs = json_decode($attrs);
            foreach ($attrs as $key => $attr) {
                $attribute = $this->Productmodel->getAttributeFromName($key);
                foreach ($attr as $att) {
                    $attrIDs[$attribute['id']][] = $att;
                }
            }
        }

        $combinations = findCombinations($attrIDs);
        foreach ($combinations as $value) {
            $filteredProductIds = $this->Productmodel->findProductByCombination($value, $filteredProductIds);
        }
        // foreach ($attrIDs as $key => $value) {
        //     $filteredProductIds = $this->Productmodel->getProductIdsFromAttributes('pid',$key,$value,$filteredProductIds);
        //     $filteredProductIds = array_column($filteredProductIds,'pid');
        // }
        //get current starting point of records
        $offset = (($page - 1) * $perPage);

        if (!empty($page) && !empty($catURl) && !empty($perPage)) {

            $category = $products = $otherIds = array();
            $category = $this->Categorymodel->fetchByAlias(str_replace("/", ':', $catURl));
            // e($filteredProductIds);
            if ($filteredProductIds) {
                $otherIds = $this->Productmodel->getConfigProducts($filteredProductIds);
                $filteredProductIds = array_merge($otherIds, $filteredProductIds);
            }
            $products = $this->Productmodel->listByCategory($category['id'], $offset, $perPage, $filteredProductIds);
            $count = $this->Productmodel->countByCategory($category['id'], $filteredProductIds);
            $outputHtml = '';
//            e($products);
            foreach ($products as $product) {
                if (!empty($product['img'])) {
                    $imageP = $this->config->item('PRODUCT_PATH') . $product['img'];
                } else {
                    $imageP = 'images/product-default-image.jpg';
                }

                if ((isset($product['special_price']) && $product['special_price']) > 0) {
                    $price = $product['special_price'];
                } else if (!empty($product['discount'])) {
                    $discount = ($product['price'] * $product['discount']) / 100;
                    $price = $product['price'] - $discount;
                } elseif ($product['type'] == 'config' && $product['price'] > 0.00) {
                    $price = $product['price'];
                    $mprice = $product['srp_price'];
                } elseif ($product['type'] == 'config' && $product['least_price'] > 0) {
                    $price = $product['least_price'];
                    $mprice = $product['srp_price'];
                } else {
                    $price = $product['price'];
                }
//e($price,0);
                $outputHtml .= '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 single-product grid">
                                    <a href="' . base_url() . $product['uri'] . '">
                                        <div class="product-img">
                                            <!--User this div for sale tag on any product
                                            <div class="p-tag">
                                                <span class="tag-text">Sale</span>
                                            </div>-->
                                            <img src="' . resize($imageP, 283, 343, 'category_product') . '" alt="' . $product['imgalt'] . '" class="img-responsive main-img" />
                                        </div>
                                    </a>
                                    <div class="product-details">
                                                <a class="p-name" href="' . base_url() . $product['uri'] . '">' . $product['name'] . '</a>
                                                <p class="p-sku">' . $product['sku'] . '</p>
                                                 <!--<div class="available">
                                                    <ul class="list-inline colors-available">
                                                        <li><span style="background: #E8D5C7;"></span></li>
                                                        <li><span style="background: #72B6B7;"></span></li>
                                                        <li><span style="background: #FC7281;"></span></li>
                                                        <li><span style="background: #3C3B43;"></span></li>
                                                    </ul>
                                                </div>-->
                                                <div class="star-rating">
                                                    <ul class="list-inline rating-ul">
                                                        <li>
                                                            <ul class="list-inline start-rating-ul">';
                for ($i = 0; $i < $product['avgrate']; $i++) {
                    $outputHtml .= '<li><i class = "fa fa-star" aria-hidden = "true"></i></li>';
                }

                $outputHtml .= '</ul>
                                                        </li>
                                                        <li>(' . $product['reviewnumber'] . ')</li>
                                                    </ul>
                                                </div>
                                                <p class="p-price">' . DWS_CURRENCY_SYMBOL . number_format($price, 2) . ' <span class="line-through">' . DWS_CURRENCY_SYMBOL . number_format($mprice, 2) . '</span></p>
                                            </div>
                            </div>';
            }

            //echo $outputHtml;
        }
        /* else{
          echo $outputHtml;

          } */
        $data = array();
        $data['html'] = $outputHtml;

        if ($count > $perPage) {
            if (!empty($products)) {
                $data['count'] = 1;
            } else {
                $data['count'] = 0;
            }
        } else {
            $data['count'] = 0;
        }
//         e($data);
        echo json_encode($data);
    }

    function logtierPrice() {
        $this->load->model('cms/Tiercmsmodel');
        $pid = 0;
        $pfid = 0;
        $qty = 0;
        $result = 0;

        $pid = $this->input->post('pid');
        $pfid = $this->input->post('pfid');
        $qty = $this->input->post('qty');
        if ($pfid) {
            $result = $this->Tiercmsmodel->logtierPrice($pid, $pfid, $qty);
            echo json_encode($result);
        }
        //return ;
    }

    function notlogtierPrice() {
        $this->load->model('cms/Tiercmsmodel');
        $pid = 0;
        $pfid = 0;
        $qty = 0;
        $result = 0;

        $pid = $this->input->post('pid');
        $qty = $this->input->post('qty');
        if ($qty) {
            $result = $this->Tiercmsmodel->notLogTierPrice($pid, $qty);
            echo json_encode($result);
        }
        //return ;
    }

    function tierPrice() {
        $this->load->model('cms/Tiercmsmodel');
        $pid = 0;
        $qty = 0;
        $result = array();

        $pid = $this->input->post('pid');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');
        if ($qty) {
            $result = $this->Tiercmsmodel->tierPrice($pid, $qty);
            if($result['tier_price']){
                $result['tier_price'] =  number_format(($result['tier_price']) ,2) ;
                $result['tier_price_plus_vat'] = '(' . DWS_CURRENCY_SYMBOL . number_format(($result['tier_price'] + $result['tier_price'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)';
            }else{
                $result['tier_price'] =  number_format(($price) ,2) ;
                $result['tier_price_plus_vat'] = '(' . DWS_CURRENCY_SYMBOL . number_format(($result['tier_price'] + $result['tier_price'] * DWS_TAX / 100), 2) . ' ' . 'Inc. VAT)';
            }
//            e($result);
            echo json_encode($result);
        }
        //return ;
    }

    function singlePrice() {
        $this->load->model('catalog/Productmodel');
        $result = '';
        $pid = 0;
        $x = $this->input->post('pid');
        if (!empty($x)) {
            $pid = $this->input->post('pid');
            //Special Price
            $result = $this->Productmodel->getDetails($pid);
            echo json_encode($result);
        }
    }

    function AttrIdByName($attrName) {
        $this->db->select('id');
        $this->db->from('attribute');
        $this->db->where('name', $attrName);
        $rs = $this->db->get();
//        e($rs);
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
    }

    function attributesReset($attributes) {
        $main_attribute_id = $main_attribute_changed = false;
        $post_attributes = ($this->input->post('attributes')) ? $this->input->post('attributes') : [];
        // e($post_attributes);
        // e($attributes);
        foreach ($attributes as $attribute) {
            foreach ($post_attributes as $key => $value) {
                if (isset($value['att_id'])) {
                    $value['changed'] = ($value['changed'] == 'false') ? 0 : 1;
                    if (($attribute['attr_id'] == $value['att_id']) && ($attribute['is_main'] == 1) && ($value['changed'] == 1)) {
                        $main_attribute_changed = true;
                        $main_attribute_id = $attribute['attr_id'];
                    }
                }
            }
        }
        // e($main_attribute_changed);
        foreach ($post_attributes as $key => $value) {
            if ($main_attribute_changed) {
                if (isset($value['att_id'])) {
                    if ($value['att_id'] != $main_attribute_id) {
                        if (isset($_POST['attributes'][$key])) {
                            unset($_POST['attributes'][$key]);
                        }
                    }
                }
            }
        }
    }

    function attributes($pid) {
        $this->load->library('session');

        $flag = false;
        $this->load->model('catalog/Productmodel');
        $this->load->model('catalog/Attributesmodel');
        $inner = $attributes = $childProducts = $attributesIDs = [];
        $attributesIDs = $this->Productmodel->attributeIDs($pid);
        $aids = $this->Productmodel->array_column1($attributesIDs, 'attr_id');
        $attrValues = $this->Attributesmodel->fetchAtrrValues($pid, $aids);

        $this->attributesReset($attributesIDs);

        $post_attributes = ($this->input->post('attributes')) ? $this->input->post('attributes') : [];

        // may be this varible used in future
        $inner['changed_attribute_id'] = $main_attribute_changed = false;
        $arr = array();
        foreach ($post_attributes as $attribute) {
            if (isset($attribute['isMain'])) {
                if ($attribute['isMain'] == 1) {
                    $main_attribute_changed = true;
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if (isset($attribute['att_id'])) {
                if ($attribute['changed']) {
                    $inner['changed_attribute_id'] = $attribute['att_id'];
                }
                $attributes[$attribute['att_id']] = $attribute['value'];
            }
        }

        if ($attributes) {
            $childProducts = $this->Productmodel->getChildProducts('t3.child_id', $pid);
            $childProducts = $this->Productmodel->array_column1($childProducts, 'child_id');
            foreach ($attributes as $attribute_id => $attribute) {
                $childProducts = $this->Productmodel->getProductIdsFromAttributes('pid', $attribute_id, $attribute, $childProducts);
                $childProducts = $this->Productmodel->array_column1($childProducts, 'pid');
            }
            $inner['available_attributes_values'] = $this->Productmodel->getProductIdsFromAttributes('*', false, false, $childProducts);
            $inner['available_attributes_values'] = $this->Productmodel->array_column1($inner['available_attributes_values'], 'value');
        }

        if ($flag) {
            $arr = array();
            $arr = $inner['available_attributes_values'];
            $this->session->set_userdata('abc', $arr);
        }

        if ($this->session->userdata('abc')) {
            $temp = array();
            $temp = $this->session->userdata('abc');
            $x = array();
            $x = $arr + $temp;
            $inner['available_attributes_values'] = $x;
        }

        if ($attrValues) {
            $inner['attrArray'] = $attrValues;
            $inner['attributesIDs'] = $attributesIDs;
        }

        $inner['post_attributes'] = $post_attributes;
        $inner['pid'] = $pid;

        $tmp = current($childProducts);
        $images = $this->Productmodel->getImages($tmp);
        $main_image = $other_images = false;
        foreach ($images as $image) {
            if ($image['main']) {
                $main_image = base_url() . 'upload/products/' . $image['img'];
            } else {
                $other_images[] = [
                    'resized_image' => base_url() . 'upload/products/' . $image['img'],
                    'orignal_image' => $this->config->item('PRODUCT_URL') . $image['img'],
                ];
            }
        }

        if (!$main_image && $images) {
            $tmp = current($images);
            $main_image = base_url() . 'upload/products/' . $tmp['img'];
        }

        $return['price'] = false;
        $inner['tier_price'] = [];
        if ($childProducts) {
            $tmp = current($childProducts);

            $user_id = ($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : 0;
            $profile_id = ($this->session->userdata('profile_id')) ? $this->session->userdata('profile_id') : 1;
            $qty = $this->input->post('qty');
            $return = $this->Productmodel->getProductPrice($tmp, $user_id, $profile_id, $qty);
            $inner['tier_price'] = $this->Productmodel->getTierPrices($childProducts, $profile_id);
        }

        $accessories = array();
        $accessories = get_accessories($pid);
        $inner['accessories'] = $accessories;

        $content = $this->load->view('attributes', $inner, true);
        $return['image'] = $main_image;
        $return['other_images'] = $other_images;
        $return['content'] = $content;
        echo json_encode($return);
    }

    function expert_enquiry() {
        $data = array();
        $data['fname'] = $this->input->post('fname');
        $data['lname'] = $this->input->post('lname');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['message'] = $this->input->post('message');
        $data['product_id'] = $this->input->post('product_id');
        $data['added_on'] = time();

        if ($this->db->insert('product_enquiry', $data)) {
            $rs = $this->db->select('name, sku')
                    ->where('id', $data['product_id'])
                    ->where('is_active', 1)
                    ->get('product');

            if ($rs->num_rows() == 1) {
                $r = $rs->first_row('array');

                $emailData = array();
                $emailData['DATE'] = date("jS F, Y");
                $emailData['NAME'] = $data['fname'] . ' ' . $data['lname'];
                $emailData['EMAIL'] = $data['email'];
                $emailData['PHONE'] = $data['phone'];
                $emailData['MESSAGE'] = nl2br($data['message']);
                $emailData['PRODUCT_NAME'] = $r['name'];
                $emailData['PRODUCT_SKU'] = $r['sku'];

                $emailBody = $this->parser->parse('contact/emails/product_enquiry_email', $emailData, TRUE);

                $config = array();
                $this->email->initialize($this->config->item('EMAIL_CONFIG'));
                $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
                $this->email->reply_to(DWS_EMAIL_REPLY_TO);
                $this->email->to(DWS_EMAIL_ADMIN);
                $this->email->subject('Product Enquiry');
                $this->email->message($emailBody);

                $status = $this->email->send();
                $status = true;

                if ($status == TRUE) {
                    echo 'done';
                }
            }
        } else {
            echo 'failed';
        }
    }

    function tier_email() {
        $insert_data = array();
        foreach ($this->input->post('data') as $data) {
            $insert_data[$data['name']] = ($data['value']) ? $data['value'] : NULL;
        }
        $insert = $this->db->insert('tier_enquiry', $insert_data);
//      send  email
        $insert_data['DATE'] = date("jS F, Y");
        $insert_data['ADDRESS'] = DWS_ADDRESS;
        $insert_data['ADMIN_PHONE'] = DWS_TELLNO;
        $emailBody = $this->parser->parse('email/tier-enquiry', $insert_data, TRUE);
        $this->email->initialize($this->config->item('EMAIL_CONFIG'));
        $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
        $this->email->reply_to(DWS_EMAIL_REPLY_TO);
        $this->email->to(DWS_EMAIL_ADMIN);
        $this->email->subject('Product Enquiry');
        $this->email->message($emailBody);
        $send = $this->email->send();
        $response = array();
        if ($insert && $send) {
            $response['status'] = TRUE;
            $response['msg'] = 'successfully submitted';
        } else {
            $response['status'] = FALSE;
            $response['msg'] = 'failed to submit';
        }
        echo json_encode($response);
    }

}

?>
