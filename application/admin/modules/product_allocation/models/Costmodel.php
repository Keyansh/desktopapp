<?php

class Assignmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //get detail of category
    function getdetails($cid) {
        $this->db->where('category_id', $cid);
        $query = $this->db->get('category');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //List Primary category
    function getPrimaryCategory() {
        $this->db->where('c_active', 1);
        $query = $this->db->get('category');
        return $query->result_array();
    }

    //create indented list
    function indentedList($parent, &$output = array()) {


        $this->db->where('parent_id', $parent);
        $this->db->order_by('category_sort_order', 'ASC');
        $query = $this->db->get('category');
        foreach ($query->result_array() as $row) {
            $output[] = $row;
            $this->indentedList($row['category_id'], $output);
        }
        return $output;
    }

    //create indented list
    function getPrimaryCategories() {
        $this->db->where('parent_id', 0);
        $this->db->order_by('category_sort_order', 'ASC');
        $query = $this->db->get('category');
        //if ($query && $query->num_rows() > 0)
        return $query->result_array();

        return false;
    }

    //list all category
    function getCategory($current_category) {
        $this->db->where('c_active', 1);
        $this->db->where('category_id !=', $current_category['category_id']);
        $this->db->where('parent_id !=', $current_category['category_id']);
        $query = $this->db->get('category');
        return $query->result_array();
    }

    //Assign Product

    function assignProduct() {
        //echo '<pre>';
        //print_r($this->input->post());
        $error = '';
        if($this->input->post('user_id'))
        {
            $user_id = $this->input->post('user_id');
            $productList = $this->input->post('product');             
            $this->db->select('product_id');
            $this->db->where('user_id', $user_id);
            $result = $this->db->get('product_assignment');
            $existPidList =$result->result_array();
            $data = array();           
            $count = count($productList['product_id']);
            $hiddenID = array();
            for ($i=0; $i < $count; $i++) 
            {                
                $arraySet = array();
                foreach ($existPidList as $value) 
                {
                    $arraySet[] = $value['product_id'];
                }
                $insertCheck = in_array($productList['product_id'][$i], $arraySet);
                if($insertCheck)
                {
                   //echo $productList['product_id'][$i]." ".$productList['sku'][$i]." ".$productList['price'][$i]." Already Exist PID<br>";
                }
                else
                {
                    if(!empty($productList['product_id'][$i])){

                        $hiddenID = $productList['product_hid_id'];
                        foreach ($hiddenID as $hidkey => $hidval) 
                        {
                            if($hidval === $productList['product_id'][$i])
                            {                                
                                $data['user_id'] = $user_id;
                                $data['product_id'] = $hidval;
                                $data['price_sku'] = !empty($productList['sku'][$hidkey])?$productList['sku'][$hidkey]:'';
                                $data['price'] = !empty($productList['price'][$hidkey])?$productList['price'][$hidkey]:0;
                                $data['added_on'] = date('Y-m-d H:i:s');                
                                $insertData = array('user_id'=>$data['user_id'], 'product_id'=>$data['product_id'],'price_sku'=>$data['price_sku'],'price'=>$data['price'],'added_on'=>$data['added_on']);
                                $this->db->insert('product_assignment', $insertData);
                            }
                        }
                        $msg = 'Product Assigned!'; 
                        return $msg;
                    }
                    else{
                        $error = 'Please select products!'; 
                        return $error;
                    }
                    //exit();
                }
            }
        } 
        else{
           $error = 'Please select existing user!'; 
           return $error;
        }         
        
    }

    function UpdateProductPrice($cid, $pricing) {

        $this->db->from('product');
        $this->db->join('product_category', 'product.product_id = product_category.product_id');
        $this->db->where('category_id', $cid);
        $product = $this->db->get();
        foreach ($product->result_array() as $row) {
            $uprice['product_price'] = round(($pricing / 100) * $row['product_price'] + $row['product_price'], 2);
            $this->db->where('product_id', $row['product_id']);
            $this->db->update('product', $uprice);

            $this->UpdatePriceOption($row['product_id'], $pricing);
        }
    }

    function UpdatePriceOption($pid, $pricing) {
        $this->db->from('options');
        $this->db->join('option_rows', 'option_rows.option_id = options.option_id');
        $this->db->where('options.product_id', $pid);
        $options = $this->db->get();
        foreach ($options->result_array() as $rows) {
            $oprice = array();
            $oprice['price'] = round(($pricing / 100) * $rows['price'] + $rows['price'], 2);
            $this->db->from('option_rows');
            $this->db->where('option_row_id', $rows['option_row_id']);
            $this->db->update('option_rows', $oprice);
        }
    }

    function ListAll($offset = FALSE, $limit = FALSE) {
        $this->db->from('category_discount_history');
        $this->db->join('category', 'category_discount_history.category_id = category.category_id');
        $this->db->group_by('added_on');
        $this->db->order_by('added_on', 'DESC');
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $result = $this->db->get();
        return $result->result_array();
    }

    function countAll() {
        $this->db->from('category_discount_history');
        return $this->db->count_all_results();
    }

    function costListAll($offset = FALSE, $limit = FALSE) {
        $this->db->from('category_discount');
        $this->db->join('category', 'category_discount.category_id = category.category_id');
        $this->db->group_by('discount_added_on');
        $this->db->order_by('category_discount.category_id', 'ASC');
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $result = $this->db->get();
        return $result->result_array();
    }

    function costcountAll() {
        $this->db->from('category_discount');
        return $this->db->count_all_results();
    }

    function costListAction($cat_id) {
        $cat = explode("_", $cat_id);
        $data = array();
        $data['active'] = $cat['1'];
        $this->db->where('category_id', $cat['0']);
        $this->db->update('category_discount', $data);
    }

}

?>