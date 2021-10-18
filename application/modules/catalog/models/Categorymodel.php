<?php

class Categorymodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function fetchByAlias($c_alias, $c_id = 0) {
        if (!$c_id) {
            $this->db->where('uri', $c_alias);
        } else {
            $this->db->where('category_id', $c_id);
        }

        $this->db->where('active', 1);
        $query = $this->db->get('category');

        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    function getCategories() {
        $rs = $this->db->get('category');
        return $rs->result_array();
    }

    public $menus = '';

    function categoriesTree($parent, $output = '', $dept = '') {
        $this->db->select('id,name,uri,menu_image');
        $this->db->where('parent_id', $parent);
        $this->db->where('active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('category');
        $results = $query->result_array();
        $this->menus .= '<ul class="nav navbar-nav">';
        foreach ($results as $key => $value) {
            $this->menus .= '<li class="dropdown mega-dropdown">';
            $this->menus .= "<a class='dropdown-toggle' data-toggle='dropdown' href='" . base_url() . $value['uri'] . "'>" . $value['name'] . "</a>";
            $this->getCatChilds($value['id'], $value['menu_image']);
            $this->menus .= '</li>';
        }
        $params = array(
            'menu_alias' => 'header_menu',
            'ul_format' => '{MENU}',
            'level_1_format' => '<a href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>',
            'level_2_format' => '<a href="{HREF}"{ADDITIONAL}>{LINK_NAME}</a>'
        );
        $this->menus .= cms_menu($params);
        $this->menus .= '</ul>';
        return $this->menus;
    }

    function getCatChilds($id, $menuImage) {
        $results = $this->getChilds($id);
        if (!empty($results)) {
            $this->menus .= '<div class="mega-menu"><ul class="dropdown-menu mega-dropdown-menu list-inline">';
            if ($menuImage) {
                $this->menus .= "<li class='mega-innner-list'>";
                $this->menus .= "<div class='mega-category-col'><div class='mega-category-banner'><img src='upload/category/$menuImage' class='img-responsive'/></div><div class='collection-type'><p>WOMENS COLLECTION</p></div></div>";
                $this->menus .= '</li>';
            }
            foreach ($results as $key => $value) {
                $this->menus .= '<li class="mega-innner-list"><ul class="mega-ul">';
                $this->menus .= "<li class='dropdown-header'>" . $value['name'] . "</li>";
                $this->getCatChilds1($value['id']);
                $this->menus .= '</ul></li>';
            }
            $this->menus .= '<div style="clear:both"></div>';
            $this->menus .= '</ul></div>';
        }
    }

    function getCatChilds1($id) {
        $results = $this->getChilds($id);
        if (!empty($results)) {
            foreach ($results as $key => $value) {
                $this->menus .= "<li><a href='" . base_url() . str_replace(':', "/", $value['uri']) . "'>" . $value['name'] . "</a></li>";
            }
        }
    }

    function getIfAnyProductIsdisabled($SubparentId) {
        $this->db->where('parent_id', $SubparentId);
        $this->db->where('status', 0);
        $res = $this->db->get('megamenu');
        return $res->num_rows();
    }

//    public function getChilds($id) {
//        $this->db->where('megamenu.parent_id', $id);
//        $this->db->where('megamenu.status', 1);
//        $this->db->where('category.active', 1);
//        $this->db->order_by('megamenu.order', 'asc');
//        $query = $this->db->join('category', 'category.category_id = megamenu.sub_cat_id', 'left')
//                ->get('megamenu');
//
//        return $query->result_array();
//    }

    public function getChilds($id) {
        $this->db->select('id,name,uri');
        $this->db->where('parent_id', $id);
        $this->db->where('active', 1);
        $this->db->order_by('sort_order', 'asc');
        $query = $this->db->get('category');

        return $query->result_array();
    }

    function getCatProductExist($id) {
        $this->db->where('category_id', $id);
        if ($this->db->get('product_category')->num_rows() > 0) {

            return true;
        }
    }

//    function categoriesTree($parent, $output = '') {
//        $this->db->where('parent_id', 0);
//        $this->db->where('active', 1);
//        $query = $this->db->get('category');
//        $menu = array();
//        $total = 0;
//        foreach ($query->result_array() as $key => $parent) {
//            $this->db->where('parent_id', $parent['category_id']);
//            $this->db->where('active', 1);
//            $query = $this->db->get('category');
//            $vada_child = $query->result_array();
//            $menu[$parent['category_id']] = $parent;
//            $menu[$parent['category_id']]['count'] = count($vada_child);
//            $total += count($vada_child);
//            foreach ($vada_child as $key1 => $vada_child) {
//                $this->db->where('parent_id', $vada_child['category_id']);
//                $this->db->where('active', 1);
//                $query = $this->db->get('category');
//                $menu[$parent['category_id']][$vada_child['category_id']] = $vada_child;
//                $menu[$parent['category_id']][$vada_child['category_id']]['childrens'] = $query->result_array();
//                $menu[$parent['category_id']][$vada_child['category_id']]['count'] = count($query->result_array());
//            }
//        }
//        echo "<pre>";
//        print_r($menu);
//    }


    function getSubCategories($cid) {
        $this->db->where('parent_id', $cid);
        $this->db->where('active', 1)->order_by('category_sort_order', 'ASC');
        $query = $this->db->get('category');
        return $query->result_array();
    }

    function fetchProducts($cid, $categ = array()) {
        $this->db->from('product_category');
        $this->db->select('product_image.product_id AS p1, product_image.*, product.*');
        $this->db->join('product', 'product_category.product_id = product.product_id');
        $this->db->join('product_image', 'product.product_id = product_image.product_id AND tb_product_image.is_main_image = 1', 'left');
        $this->db->where('product_is_active', 1);
        $this->db->where('category_id', intval($cid));
        $rs = $this->db->get();
        $products = $rs->result_array();

        $attribs = $this->db->distinct()
                        ->select('attribute_label')
                        ->from('attribute')
                        ->where('category_id', intval($cid))
                        ->where('attribute_label != ', "")
                        ->get()->result_array();

        $att = array();
        $index = 2;
        $fst_set = false;
        $snd_set = false;
        foreach ($attribs as $k => $attr) {
            if (!empty($categ["attribute_sort"]) &&
                    $attr['attribute_label'] == $categ["attribute_sort"]) {
                $att[0] = $attr['attribute_label'];
                $fst_set = true;
            } else if (!empty($categ["combined_attribute_sort"]) &&
                    $attr['attribute_label'] == $categ["combined_attribute_sort"]) {
                $att[1] = $attr['attribute_label'];
                $snd_set = true;
            } else {
                $att[$index] = $attr['attribute_label'];
                $index++;
            }
        }
        ksort($att);
        $result = $this->fetchProductAttributes($products, $att);
        return $result;
    }

    function fetchProductAttributes($products, $att = false) {
        $data = array();
        foreach ($products as $product) {

            $sql = 'Select * FROM ' . $this->db->dbprefix('product_attribute') . '
					LEFT JOIN ' . $this->db->dbprefix('attribute') . '
					on ' . $this->db->dbprefix('attribute') . '.attribute_id
						= ' . $this->db->dbprefix('product_attribute') . '.attribute_id WHERE
					product_id="' . $product['product_id'] . '"';
            if ($att) {
                $str = '"' . implode('","', $att) . '"';
                $sql .= ' order by  FIELD (attribute_label,' . $str . ')';
            } else {
                $sql .= ' order by ' . $this->db->dbprefix('product_attribute') . '.attribute_id asc';
            }
            $rs = $this->db->query($sql);

            $customer = array();
            $customer = $this->memberauth->checkAuth();
            if ($customer) {
                $discount = $this->Cartmodel->productDiscount($product, $qty = 1);

                $data[] = array('product' => $product, 'attributes' => $rs->result_array(), 'discount' => $discount);
            } else {
                $data[] = array('product' => $product, 'attributes' => $rs->result_array());
            }
        }
        return $data;
    }

    function fetchAttributes($cid) {
        $this->db->where('category_id', intval($cid));
        $rs = $this->db->where('hide', 0)->get('attribute');
        return $rs->result_array();
    }

    function listUniqueAttributeValues($attr) {
        $output = array();
        $this->db->from('product_attribute');
        $this->db->join('product_category', 'product_category.product_id = product_attribute.product_id');
        $this->db->where('attribute_id', $attr['attribute_id']);
        $this->db->where('category_id', $attr['category_id']);
        $this->db->order_by('CAST(attribute_value AS SIGNED INTEGER)', 'asc');
        $this->db->group_by('attribute_value');
        $rs = $this->db->get();

        if ($rs) {
            $output[''] = 'Any';
            foreach ($rs->result_array() as $row) {
                $output[$row['attribute_value']] = $row['attribute_value'] . $row['attribute_postfix'];
            }
        }
        return $output;
    }

    /* function countAll($keywords) {
      if ($keywords != '0') {
      $this->db->from('product_attribute');
      $this->db->join('product', 'product_attribute.product_id = product.product_id');
      $this->db->where('attribute_value', $keywords);
      return $this->db->count_all_results();
      }
      } */

    function listAll($attribute_values, $cid = false) {
        $keywords = $this->input->post('search', TRUE);



        if ($keywords != '') {
            $keywords = mysql_real_escape_string($keywords);
            $this->db->from('product_attribute');
            $this->db->join('product', 'product_attribute.product_id = product.product_id')
                    ->join('product_category', 'product_category.product_id = product.product_id', 'left');
            $this->db->join('product_image', 'product.product_id = product_image.product_id AND tb_product_image.is_main_image = 1', 'left');
            $this->db->where('attribute_value', $keywords)
                    ->where('product_is_active', 1);
            if ($cid) {
                $this->db->where('product_category.category_id', intval($cid));
            }

            $rs = $this->db->get();
            $products = $rs->result_array();

            $result = $this->fetchProductAttributes($products);
            return $result;
//            return $rs->result_array();
        }

        $self_join_counter = 1;

        $this->db->from('product_attribute_view AS p1');
        $this->db->join('product_image', 'p1.product_id = product_image.product_id AND tb_product_image.is_main_image = 1', 'left');
        foreach ($attribute_values as $attr => $value) {

            //Get Search Criteria
            if ($this->input->post("attribute_{$attr}")) {
                //print_r($_POST); exit();
                $self_join_counter++;
                $table_name = "p$self_join_counter";
                $this->db->join("product_attribute_view AS $table_name", "p1.product_id = $table_name.product_id");
                $this->db->where("$table_name.attribute_id", $attr);
                $this->db->where("$table_name.attribute_value", $this->input->post("attribute_{$attr}", TRUE));
                $this->db->group_by('p1.product_id');
            }
        }
        $rs = $this->db->get();
        $products = $rs->result_array();
        $result = $this->fetchProductAttributes($products);
        return $result;
//        return $rs->result_array();
    }

    function listAllCategories() {
        $this->db->where('active', 1);
        $query = $this->db->get('category');
        return $query->result_array();
    }

    //Get sub categories
    function subCategories($category_id) {
        $this->db->where('parent_id', $category_id);
        $this->db->where('active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('category');
        return $query->result_array();
    }

    //Get sub child categories
    function subChildCategories($cids) {
        $this->db->where_in('parent_id', $cids);
        $this->db->where('show_as_child', 1);
        $this->db->where('active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('category');
        return $query->result_array();
    }

//    leftmenu
    public $leftmenus = '';

    function leftCategories($parent, $output = '', $dept = '') {
        $this->db->select('id,name,uri');
        $this->db->where('parent_id', $parent);
        $this->db->where('active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('category');
        $results = $query->result_array();
        if ($results) {
            $this->leftmenus .= '<div class="panel panel-default">';
            foreach ($results as $key => $value) {
                $this->leftmenus .= '<div class="panel-heading"><h4 class="panel-title">';
                $this->leftmenus .= '<a href="' . base_url() . str_replace(':', "/", $value['uri']) . '">' . $value['name'] . '</a>';
                $this->leftmenus .= '</h4></div>';
                // $this->leftCatChilds($value['id'], $value['menu_image']);
            }

            $this->leftmenus .= '</div>';
        }
        return $this->leftmenus;
    }

    function leftCatChilds($id, $menuImage) {
        $results = $this->getChilds($id);
        if (!empty($results)) {
            $this->leftmenus .= '<div id="product-type" class="panel-collapse collapse in"><div class="panel-body"><ul class="filters-list">';
            foreach ($results as $key => $value) {
                $this->leftmenus .= '<li><label class="al-new-select"><a href="' . base_url() . str_replace(':', "/", $value['uri']) . '"><span class="name">' . $value['name'] . '</span></a></label></li>';
            }
            $this->leftmenus .= '</ul></div></div>';
        }
    }

    function child_and_grandchild_categories($category_id) {
        $result = array();

        $rs = $this->db->select('category.id, category.parent_id, category.name, category.uri, category.image, category.image_alt, category.description')
                // ->join('cat_prod', 'cat_prod.cid=category.id')
                ->where('parent_id', $category_id)
                ->where('active', 1)
                ->order_by('sort_order', 'asc')
                // ->group_by('cat_prod.cid')
                ->get('category');
//    $rs = $rs->result_array();
//    e($rs);
        if ($rs->num_rows()) {
            $rs = $rs->result_array();
            foreach ($rs as $item) {
                $arr = array();
                $arr['category'] = $item;
                $rs2 = array();
                $rs2 = $this->db->select('id, parent_id, name, uri, image, image_alt')
                        ->where('parent_id', $item['id'])
                        ->where('active', 1)
                        ->order_by('sort_order', 'asc')
                        ->get('category');

                if ($rs2->num_rows()) {
                    $rs2 = $rs2->result_array();
                    $arr['sub_categories'] = $rs2;
                }

                array_push($result, $arr);
            }
        }

        return $result;
    }

    function new_categories() {
        $today = date('m/d/Y');

        $rs = $this->db->select('*')
                ->from('category')
                ->where('new_start_date <=', $today)
                ->where('new_end_date >=', $today)
                ->where('active', 1)
                ->get();

        if ($rs->num_rows()) {
            return $rs->result_array();
        }

        return FALSE;
    }

    function category_by_id($category_id) {
        $rs = array();
        $rs = $this->db->select('*')
                ->from('category')
                ->where('id', $category_id)
                ->get();

        if ($rs->num_rows()) {
            $r = $rs->first_row('array');
            return $r;
        }

        return FALSE;
    }

}

?>
