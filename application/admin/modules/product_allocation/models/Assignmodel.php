<?php

class Assignmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function alreadyAssignedProducts($parent_id) {
        $result = array();
        $this->db->select('t1.attr_id');
        $this->db->from('product_configurable_attr t1');
        $this->db->where('t1.parent_id', $parent_id);
        $this->db->group_by('t1.attr_id');
        // $this->db->where('t1.cid',$catid);
        $query = $this->db->get();
        $outputArr = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $arr) {
                $outputArr[] = $arr['attr_id'];
            }
        }
        if (!empty($outputArr)) {
            $this->db->select('t7.child_id');
            $this->db->from('product t1');
            $this->db->join('attribute_varchar t4', 't1.id=t4.pid');
            $this->db->join('attribute t5', 't4.attr_id=t5.id');
            $this->db->join('product_configurable_link t7', 't7.child_id=t1.id');
            $this->db->where('t1.is_active', 1);
            $this->db->group_by("t1.id");
            $this->db->where("LOWER(t1.type) != 'standard'");
            $this->db->where_in('t4.attr_id', $outputArr);
            $this->db->where('t7.parent_id', $parent_id);
            $this->db->where("LOWER(t4.value) != 'select'");
            $this->db->having('COUNT(*) >=' . count($outputArr), false);
            $query = $this->db->get();
            $result = $query->result_array();
            $result = array_map(function($arr) {
                return $arr['child_id'];
            }, $result);
        }
        return $result;
    }

    function totalcount2($catId, $searchTerm, $productId, $child_ids) {
        $output = array();
        if ($searchTerm) {
            $this->db->select('sum(IF(1=1,1,1)) as total,sum(IF(t1.sku LIKE "%' . $searchTerm . '%",1,IF(t1.name LIKE "%' . $searchTerm . '%",1,0))) as searchTotal ,t1.sku, t1.name as pname', false);
        } else {
            $this->db->select('sum(IF(1=1,1,1)) as total, sum(IF(1=1,1,1)) as searchTotal, t1.sku, t1.name as pname', false);
        }
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid ');
        $this->db->join('category t3', 't3.id = t2.cid AND t3.id = ' . $catId);
        $this->db->where('t1.is_active', 1);
        $this->db->where_not_in("t1.id", $child_ids);
        $row = $this->db->get()->row_array();
        return $row;
    }

    function totalcount3($catId, $searchTerm, $productId, $attributes, $childPids) {
        $output = array();
        if ($searchTerm) {
            $this->db->select('t1.id', false);
            $this->db->from('product t1');
            //$this->db->join('cat_prod t2', 't1.id = t2.pid ');
            //$this->db->join('category t3', 't3.id = t2.cid AND t3.id = '.$catId);
            if ($searchTerm) {
                $this->db->where("(t1.sku LIKE '%".$searchTerm."%' OR t1.name LIKE '%".$searchTerm."%')");
            }
            $this->db->join('attribute_varchar t4', 't1.id=t4.pid');
            $this->db->join('attribute t5', 't4.attr_id=t5.id');
            $this->db->where('t1.is_active', 1);
            $this->db->group_by("t1.id");
            
            $this->db->where("LOWER(t1.type) = 'standard'");
            $this->db->where_in('t4.attr_id', $attributes);
            $this->db->where("LOWER(t4.value) != 'select'");
            $this->db->where('t4.value !=', '0');
            $this->db->where('t4.value !=', '');
            $this->db->having('COUNT(*) >=' . count($attributes), false);
            $query = $this->db->get();
            $row2 = $query->result_array();
        }
        $this->db->select('t1.id');
        $this->db->from('product t1');
        //$this->db->join('cat_prod t2', 't1.id = t2.pid ');
        //$this->db->join('category t3', 't3.id = t2.cid AND t3.id = '.$catId);
        $this->db->join('attribute_varchar t4', 't1.id=t4.pid');
        $this->db->join('attribute t5', 't4.attr_id=t5.id');
        $this->db->where('t1.is_active', 1);
        $this->db->group_by("t1.id");
        $this->db->where("LOWER(t1.type) = 'standard'");
        $this->db->where_in('t4.attr_id', $attributes);
        $this->db->where("LOWER(t4.value) != 'select'");
        $this->db->where('t4.value !=', '0');
        $this->db->where('t4.value !=', '');
        $this->db->where_not_in('t1.id', $childPids);
        $this->db->having('COUNT(*) >=' . count($attributes), false);
        $query = $this->db->get();
        $row = $query->result_array();
        if (!empty($childPids) && empty($searchTerm)) {
            $row = array_merge($row, $childPids);
        }
        $output['total'] = count($row);
        if ($searchTerm) {
            $output['searchTotal'] = count($row2);
        } else {
            $output['searchTotal'] = $output['total'];
        }
        return $output;
    }

    function childProducts($catId, $limit, $offset, $searchTerm, $productId) {
        $output = array();
        $child_ids = $this->alreadyAssignedProducts($productId);
        $child_ids = implode(',', $child_ids);
        $this->db->select('t1.id,t1.name,t1.sku,t1.price,t1.name,t1.quantity,group_concat(t4.attr_id) as attr_id,group_concat(t5.name) as attr_label', false);
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid ');
        $this->db->join('category t3', 't3.id = t2.cid AND t3.id = ' . $catId);
        $this->db->join('attribute_varchar t4', 't1.id=t4.pid');
        $this->db->join('attribute t5', 't4.attr_id=t5.id');
        $this->db->where('t1.is_active', 1);
        // $this->db->where_not_in("t1.id",$child_ids);
        $this->db->group_by("t1.id");
        if ($child_ids) {
            $this->db->having("t1.id not in ($child_ids)", false);
        }
        if ($searchTerm) {
            $this->db->like('t1.sku', $searchTerm);
            $this->db->or_like('t1.sku', $searchTerm);
        }
        $this->db->limit($limit);
        $this->db->offset($offset);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $output[] = $row;
        }
        // lQ();
        $tmp = [];
        $tmp['data'] = $output;
        $records = $this->totalcount2($catId, $searchTerm, $productId, $child_ids);
        $tmp['recordsFiltered'] = $records['searchTotal'];
        $tmp['recordsTotal'] = $records['total'];
        return $tmp;
    }

    function childProductsAll($catId, $limit, $offset, $searchTerm, $productId, $attributes, $childPids, $childProds) {
        $output = array();
        if (!empty($attributes)) {
            $this->db->select('t1.id,t1.name,t1.sku,t1.price,t1.name,t1.quantity,group_concat(t4.attr_id) as attr_id,group_concat(t5.name) as attr_label', false);
            $this->db->from('product t1');
            //$this->db->join('cat_prod t2', 't1.id = t2.pid ');
            //$this->db->join('category t3', 't3.id = t2.cid AND t3.id = '.$catId);
            $this->db->join('attribute_varchar t4', 't1.id=t4.pid');
            $this->db->join('attribute t5', 't4.attr_id=t5.id');
            $this->db->where('t1.is_active', 1);
            if ($searchTerm) {
                 $this->db->where("(t1.sku LIKE '%".$searchTerm."%' OR t1.name LIKE '%".$searchTerm."%')");
            } else {
                $this->db->where_not_in('t1.id', $childPids);
            }
            $this->db->group_by("t1.id");
            $this->db->where("LOWER(t1.type) = 'standard'");
            $this->db->where_in('t4.attr_id', $attributes);
            $this->db->where("LOWER(t4.value) != 'select'");
            $this->db->where('t4.value !=', '0');
            $this->db->where('t4.value !=', '');
            if (!empty($childProds) && empty($searchTerm)) {
                if (($offset + $limit) <= count($childPids)) {
                    $this->db->limit(0);
                    $this->db->offset(0);
                } elseif ((($offset + $limit) > count($childPids)) && (count(array_slice($childProds, $offset, $limit)) < $limit)) {
                    $this->db->limit($limit - count(array_slice($childProds, $offset, $limit)));
                    if ($offset < count($childPids)) {
                        $this->db->offset(0);
                    } else {
                        $this->db->offset($offset - count($childProds));
                    }
                }
            } else {
                $this->db->limit($limit);
                $this->db->offset($offset);
            }

            $this->db->having('COUNT(*) >=' . count($attributes), false);
            $query = $this->db->get();
//            echo $this->db->last_query();
            foreach ($query->result_array() as $row) {
                $output[] = $row;
            }
        }
        if (!empty($childProds) && empty($searchTerm)) {
            if (($offset + $limit) <= count($childPids)) {
                $output = array_slice($childProds, $offset, $limit);
            } elseif ((($offset + $limit) > count($childPids)) && (count(array_slice($childProds, $offset, $limit)) < $limit)) {
                $output = array_merge(array_slice($childProds, $offset, $limit), $output);
            }
        }
//        lQ();
        $tmp = [];
        $tmp['data'] = $output;
        if (!empty($attributes)) {
            $records = $this->totalcount3($catId, $searchTerm, $productId, $attributes, $childPids);
        } else {
            $records['total'] = $records['searchTotal'] = 0;
        }

        $tmp['recordsFiltered'] = $records['searchTotal'];
        $tmp['recordsTotal'] = $records['total'];

        return $tmp;
    }

    // Prodcut Insert
    function insertRecord($data) {
        $result = 0;
        $result = $this->db->insert('product_assignment', $data);
        if ($result) {
            return $result;
        }
        return $result;
    }

    // Category Assignment Insert
    function catInsertRecord($data) {
        $result = 0;
        $result = $this->db->insert('category_assignment', $data);
        if ($result) {
            return $result;
        }
        return $result;
    }

    // Update
    function updateRecord($data, $where) {
        $result = 0;
        $result = $this->db->update('product_assignment', $data, $where);
        //die($this->db->last_query());
        if ($result) {
            return $result;
        }
        return $result;
    }

    // Category Assignment Update
    function catUpdateRecord($data, $where) {
        $result = 0;
        $result = $this->db->update('category_assignment', $data, $where);
        //die($this->db->last_query());
        if ($result) {
            return $result;
        }
        return $result;
    }

    //get category assignment
    function getAssignedCategory($uid) {
        $this->db->where('user_id', $uid);
        $query = $this->db->get('category_assignment');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
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

    // Assigned Products
    function assignedProducts($user_id, $category) {
        $output = array();
        foreach ($category as $catid) {
            $this->db->select('*');
            $this->db->where('catid', $catid);
            $this->db->where('user_id', $user_id);
            $query = $this->db->get('product_assignment');
            //die($this->db->last_query());
            foreach ($query->result_array() as $row) {
                $output[] = $row;
            }
        }
        return $output;
    }

    // Assigned Products
    function productAssigned($user_id, $catid) {
        $this->db->select('COUNT(p1.id) as totalAssigned, c1.name, p1.catid');
        $this->db->from('product_assignment p1');
        $this->db->join('category c1', 'c1.id = p1.catid', 'INNER');
        $this->db->where('p1.catid', $catid);
        $this->db->where('p1.user_id', $user_id);
        $this->db->where('p1.assign_type', 'Manual');
        $this->db->where('p1.active', 1);
        //$this->db->group_by('p1.id');
        $query = $this->db->get();
        //die($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    //Product to category
    function existProduct($user_id, $catid) {
        $this->db->select('p1.product_id, p1.user_id, p1.catid');
        $this->db->from('product_assignment p1');
        $this->db->where('p1.catid', $catid);
        $this->db->where('p1.user_id', $user_id);
        $this->db->where('p1.assign_type', 'Manual');
        $this->db->where('p1.active', 1);
        //$this->db->group_by('p1.id');
        $query = $this->db->get();
        //die($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Update product category wise

    function existProductUPdate($product_id, $user_id, $catid) {
        $data = array('assign_type' => 'All', 'active' => 0);
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $this->db->where('catid', $catid);
        $this->db->where('assign_type', 'Manual');
        $this->db->where('active', 1);
        $this->db->update('product_assignment', $data);
    }

    // Assigned Products
    function categoryAssigned($catid) {
        $this->db->select('c2.name');
        $this->db->from('category_assignment c1');
        $this->db->join('category c2', 'c2.id = c1.catid', 'INNER');
        $this->db->where('c1.catid', $catid);
        $this->db->where('c1.assign_type', 'All');
        $this->db->where('c1.active', 1);
        //$this->db->group_by('p1.id');
        $query = $this->db->get();
        //die($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    //Category to product
    function existCategory($user_id, $catid, $type = false) {
        $this->db->select('c1.user_id, c1.catid, c2.name');
        $this->db->from('category_assignment c1');
        $this->db->join('category c2', 'c2.id=c1.catid');
        $this->db->where('c1.user_id', $user_id);
        $this->db->where_in('c1.catid', $catid);
        if ($type) {
            $this->db->where('c1.assign_type', $type);
        }
        $this->db->where('c1.active', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    //Update Category

    function existCategoryUPdate($catid, $user_id) {
        $data = array('assign_type' => 'Manual', 'active' => 0);
        $this->db->where('user_id', $user_id);
        $this->db->where('catid', $catid);
        $this->db->where('assign_type', 'All');
        $this->db->where('active', 1);
        $this->db->update('category_assignment', $data);
    }

    function totalcount($user_id, $catId, $searchTerm) {
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
        $this->db->where_in('t3.id', $catId);
        $this->db->where('t1.is_active', 1);
        $row = $this->db->get()->row_array();
        return $row;
    }

    function assignedTotalcount($user_id, $catId) {
        $output = array();
        $this->db->select('sum(IF(1=1,1,1)) as total, sum(IF(1=1,1,1)) as searchTotal, t1.sku, t1.name as pname', false);
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid ');
        $this->db->join('category t3', 't3.id = t2.cid');
        $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'INNER');
        $this->db->where_in('t3.id', $catId);
        $this->db->where('t1.is_active', 1);
        $row = $this->db->get()->row_array();
        return $row;
    }

    // Assigned Products
    function assignedProductsDetails($user_id, $catId, $limit, $offset, $searchTerm, $assigned = 0) {
        $output = array();
        $this->db->select('t1.id as pid, t1.sku, t1.name as pname, t1.type, t1.price as pprice, t3.id as cid, t3.name as cname, t4.discount as dis, t4.special_price as sp, t4.active');
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid ');
        $this->db->join('category t3', 't3.id = t2.cid');
        $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'left');
        $this->db->where_in('t3.id', $catId);
        $this->db->where('t1.is_active', 1);
        if ($assigned == 1) {
            $this->db->where('t4.active', 1);
        } elseif ($assigned == 2) {
            $this->db->where('t4.active !=1 or t4.active is null', null);
        }

        if ($searchTerm) {
            $this->db->like('t1.sku', $searchTerm);
            $this->db->or_like('t1.sku', $searchTerm);
        }
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->group_by('t1.id');
        $query = $this->db->get();
        // ee($this->db->last_query());
        foreach ($query->result_array() as $row) {
            $output[] = $row;
        }
        $tmp = [];
        $tmp['data'] = $output;
        $records = $this->totalcount($user_id, $catId, $searchTerm);
        $tmp['recordsFiltered'] = $records['searchTotal'];
        $tmp['recordsTotal'] = $records['total'];
        return $tmp;
    }

    // Assigned Products
    function assignedProd($user_id, $catId) {
        $output = array();
        $this->db->select('t1.id as pid, t1.sku, t1.name as pname, t1.type, t1.price as pprice, t3.id as cid, t3.name as cname, t4.discount as dis, t4.special_price as sp, t4.active');
        $this->db->from('product t1');
        $this->db->join('cat_prod t2', 't1.id = t2.pid ');
        $this->db->join('category t3', 't3.id = t2.cid');
        $this->db->join('product_assignment t4', "t4.product_id = t1.id AND t4.user_id = $user_id", 'INNER');
        $this->db->where_in('t3.id', $catId);
        $this->db->where('t1.is_active', 1);
        $this->db->group_by('t1.id');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $output[] = $row;
        }
        $tmp = [];
        $tmp['data'] = $output;
        $records = $this->assignedTotalcount($user_id, $catId);
        $tmp['recordsFiltered'] = $records['searchTotal'];
        $tmp['recordsTotal'] = $records['total'];
        return $tmp;
    }

    function assignedCategoryDetails($user_id, $category) {
        $output = array();
        foreach ($category as $catid) {
            $this->db->select('c1.*, c2.name');
            $this->db->from('category_assignment c1');
            $this->db->join('category c2', 'c2.id = c1.catid', 'INNER');
            $this->db->where('c1.catid', $catid);
            $this->db->where('c1.user_id', $user_id);
            $this->db->where('c1.active', 1);
            $query = $this->db->get();
            //die($this->db->last_query());
            foreach ($query->result_array() as $row) {
                $output[] = $row;
            }
        }
        return $output;
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

    function handleManualDiscounting($data) {
        // e($data);
        $this->db->where('catid', $data['catid']);
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('product_id', $data['product_id']);
        $result = $this->db->get('product_assignment')->result_array();
        if (!$result) {
            return $this->db->insert('product_assignment', $data);
        } else {
            $this->db->where('catid', $data['catid']);
            $this->db->where('user_id', $data['user_id']);
            $this->db->where('product_id', $data['product_id']);
            return $this->db->update('product_assignment', $data);
        }
    }

    function handleAllDiscounting($data) {
        $this->db->where('catid', $data['catid']);
        $this->db->where('user_id', $data['user_id']);
        $result = $this->db->get('category_assignment')->result_array();
        if (!$result) {
            $this->db->insert('category_assignment', $data);
        } else {
            $this->db->where('catid', $data['catid']);
            $this->db->where('user_id', $data['user_id']);
            $this->db->update('category_assignment', $data);
        }
    }

    function categoryDetails($catIds, $userId) {
        $this->db->select('t1.id,t1.name,t2.discount,t2.discount,t2.special_price,t2.assign_type,t2.active');
        $this->db->from('category t1');
        $this->db->join('category_assignment t2', "t2.catid=t1.id AND t2.user_id =$userId", 'left');
        $this->db->where_in('t1.id', $catIds);
        $this->db->where('t1.active', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

}

?>
