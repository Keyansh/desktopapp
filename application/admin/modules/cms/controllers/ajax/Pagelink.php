<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pagelink extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
    }

  function updateSortOrder() {
        $sort_data = $this->input->post('page', true);
        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['sort_order'] = $key + 1;
            $this->db->where('page_id', $val);
            $this->db->update('page', $update);
        }
        //echo "Done";
        print_r($_POST);
    }

    /* function update() {
      $sort_data = $this->input->post('page', true);
      $sort_order_arr = array();


      foreach($sort_data as $id=>$parent) {
      if($parent == 'root') {
      $parent = 0;
      }

      $update = array();
      $update['parent_id'] = $parent;
      $this->db->where('page_id', $id);
      $this->db->update('page', $update);
      }

      foreach($sort_data as $id=>$parent) {
      if($parent == 'root') {
      $parent = 0;
      }

      if(isset($sort_order_arr[$parent])) {
      $sort_order = $sort_order_arr[$parent];
      $sort_order++;
      $sort_order_arr[$parent] = $sort_order;
      }else {
      $sort_order = 0;
      $sort_order_arr[$parent] = $sort_order;
      }

      $update = array();
      $update['sort_order'] = $sort_order;
      $this->db->where('page_id', $id);
      $this->db->where('parent_id', $parent);
      $this->db->update('page', $update);
      }


      } */

    function update() {
        $sort_data = $this->input->post('page', true);

        $sort_order_arr = array();
        foreach ($sort_data as $id => $parent) {
            if ($parent == 'root') {
                $parent = 0;
            }

            //fech the page details
            $new_page_uri = false;
            $page_details = array();
            $this->db->from('page');
            $this->db->where('page_id', $id);
            $query = $this->db->get();
            $page_details = $query->row_array();


            $uri = explode('/', $page_details['page_uri']);
            $new_page_uri = array_pop($uri);
            $parent_page = array();
            if ($parent != 0) {
                //fetch parent page
                $this->db->from('page');
                $this->db->where('page_id', $parent);
                $query = $this->db->get();
                $parent_page = $query->row_array();

                //valid uri
                /*$this->db->where('parent_id', $page_details['parent_id']);
                $this->db->where('page_uri', $new_page_uri);
                $this->db->where('page_id !=', $page_details['page_id']);
                $page_count = $this->db->count_all_results('page');
                if ($page_count != 0) {
                    $new_page_uri = $this->_slug($new_page_uri, $parent_page['language_code']);
                }*/

                $new_page_uri = $parent_page['page_uri'] . '/' . $new_page_uri;

            }

            //fetch the blocks of page
            $page_blocks = array();
            $this->db->where('page_id', $page_details['page_id']);
            $this->db->where('is_main', 0);
            $this->db->order_by('page_block_id', 'ASC');
            $query = $this->db->get('page_block');
            $page_blocks = $query->result_array();
            foreach ($page_blocks as $row) {
                $old_file_name = str_ireplace('/', '_', $page_details['page_uri']) . '_' . $row['block_alias'] . '.php';
                $new_file_name = str_ireplace('/', '_', $new_page_uri) . '_' . $row['block_alias'] . '.php';
                rename("../application/views/themes/" . THEME . "/blocks/" . $old_file_name, "../application/views/themes/" . THEME . "/blocks/" . $new_file_name);
            }

            $update = array();
            $update['parent_id'] = $parent;
            $update['page_uri'] = $new_page_uri;
            $this->db->where('page_id', $id);
            $this->db->update('page', $update);

            //fetch the lang
            $this->load->model('Translatemodel');
            $page_translations = array();
            $page_translations = $this->Translatemodel->listAll($page_details);
            if ($page_translations) {
                foreach ($page_translations as $item) {
                    //fetch the blocks
                    $translation_blocks = array();
                    $this->db->where('page_id', $item['page_id']);
                    $this->db->where('is_main', 0);
                    $this->db->order_by('page_block_id', 'ASC');
                    $query = $this->db->get('page_block');
                    $translation_blocks = $query->result_array();
                    foreach ($translation_blocks as $row) {
                        $old_file_name = str_ireplace('/', '_', $item['page_uri']) . '_' . $item['language_code'] . '_' . $row['block_alias'] . '.php';
                        $new_file_name = str_ireplace('/', '_', $new_page_uri) . '_' . $item['language_code'] . '_' . $row['block_alias'] . '.php';
                        rename("../application/views/themes/" . THEME . "/blocks/" . $old_file_name, "../application/views/themes/" . THEME . "/blocks/" . $new_file_name);
                    }

                    $update = array();
                    $update['parent_id'] = $parent;
                    $update['page_uri'] = $new_page_uri;
                    $this->db->where('page_id', $item['page_id']);
                    $this->db->update('page', $update);
                }
            }
        }


        foreach ($sort_data as $id => $parent) {
            if ($parent == 'root') {
                $parent = 0;
            }

            if (isset($sort_order_arr[$parent])) {
                $sort_order = $sort_order_arr[$parent];
                $sort_order++;
                $sort_order_arr[$parent] = $sort_order;
            } else {
                $sort_order = 0;
                $sort_order_arr[$parent] = $sort_order;
            }

            $update = array();
            $update['sort_order'] = $sort_order;
            $this->db->where('page_id', $id);
            $this->db->where('parent_id', $parent);
            $this->db->update('page', $update);
        }

        print_r($sort_order_arr);
    }

    //function for page alias
    function _slug($pname, $lang) {
        //print_r($lang); exit();
        $page_name = ($pname) ? $pname : '';

        $slug = $page_name;
        $slug = trim($slug);

        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('page_uri', $slug);
        $this->db->where('language_code', $lang);
        $rs = $this->db->get('page');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('language_code', $lang);
                $this->db->where('page_uri', $alt_slug);
                $rs = $this->db->get('page');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }

}

?>