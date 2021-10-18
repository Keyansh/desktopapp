<?php

class Translatemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Get page details
    function detail($pid) {
        $this->db->from('page');
        $this->db->join('page_block', 'page_block.page_id = page.page_id');
        $this->db->where('is_main', 1);
        $this->db->where('page.page_id', intval($pid));
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    //Count All Records
    function countAll() {
        $this->db->from('page');
        return $this->db->count_all_results();
    }

    //List All Records
    function listAll($page, $offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->from('page');
        $this->db->join('language', 'language.language_code = page.language_code', 'LEFT');
        $this->db->where('translation_of', $page['page_id']);

        $this->db->where('page.language_code != ', 'en');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    //List All Records
    function listAllTestimonials($testimonials, $offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->from('testimonial');
        $this->db->join('language', 'language.language_code = testimonial.language_code', 'LEFT');
        $this->db->where('trans_testimonial_id', $testimonials['trans_testimonial_id']);
        $this->db->where('testimonial.language_code != ', 'en');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    //List All languages
    function listAllLanguages() {
        $this->db->from('language');
        $this->db->where('language_code != ', 'en');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    //List All pages
    function listAllPage($page, $offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->from('page');
        $this->db->where('language_code != ', 'en');
        $this->db->where('page_uri', $page['page_uri']);
        $rs = $this->db->get();
        return $rs->result_array();
    }

    //add record
    function insertRecord($lang, $page, $blocks) {
        $data = array();
        $data['parent_id'] = $page['parent_id'];
        $data['translation_of'] = $page['page_id'];
        $data['title'] = $page['title'];
        $data['page_alias'] = $page['page_alias'];
        $data['page_uri'] = $page['page_uri'];
        $data['browser_title'] = $page['browser_title'];
        $data['menu_title'] = $page['menu_title'];
        $data['language_code'] = $lang;
        $data['meta_keywords'] = $page['meta_keywords'];
        $data['meta_description'] = $page['meta_description'];
        $data['before_head_close'] = $page['before_head_close'];
        $data['before_body_close'] = $page['before_body_close'];
        $data['page_template_id'] = $page['page_template_id'];
        $data['sort_order'] = $this->getSortOrder($page['sort_order']);
        $data['show_in_menu'] = $page['show_in_menu'];
        $data['show_in_search'] = $page['show_in_search'];
        $data['priority'] = $page['priority'];
        $data['active'] = $page['active'];
        $data['do_not_delete'] = $page['do_not_delete'];
        $data['include_in_sitemap'] = $page['include_in_sitemap'];
        if ($page['parent_id'] == 0) {
            $data['level'] = 0;
            $data['path'] = 0;
        } else {
            $parent_category = $this->detail($page['parent_id']);
            $data['level'] = $parent_category['level'] + 1;
            $data['path'] = $parent_category['path'] . '.' . $page['parent_id'];
        }

        $this->db->insert('page', $data);
        $page_id = $this->db->insert_id();

        //insert block
        foreach ($blocks as $item) {
            $block = array();
            $block['page_id'] = $page_id;
            $block['block_title'] = $item['block_title'];
            $block['block_alias'] = $item['block_alias'];
            $block['block_image'] = '';
            $block['block_contents'] = $item['block_contents'];
            $block['updated_on'] = time();
            $block['is_main'] = $item['is_main'];

            $this->db->insert('page_block', $block);
        }
    }

    //function update Record
    function updateRecord($page_details) {
        $data = array();
        $data['title'] = $this->input->post('title', TRUE);
        $data['parent_id'] = $this->input->post('parent_id', TRUE);

        if ($this->input->post('browser_title', TRUE) == '') {
            $data['browser_title'] = $this->input->post('title', TRUE);
        } else {
            $data['browser_title'] = $this->input->post('browser_title', TRUE);
        }

        if ($this->input->post('page_alias', TRUE) == '') {
            $data['page_alias'] = $page_details['page_alias'];
        } else {
            $data['page_alias'] = $this->input->post('page_alias', TRUE);
        }

        if ($this->input->post('menu_title', TRUE) == '') {
            $data['menu_title'] = $page_details['menu_title'];
        } else {
            $data['menu_title'] = $this->input->post('menu_title', TRUE);
        }

        $data['meta_keywords'] = $this->input->post('meta_keywords', TRUE);
        $data['meta_description'] = $this->input->post('meta_description', TRUE);
        $data['before_head_close'] = $this->input->post('before_head_close', FALSE);
        $data['before_body_close'] = $this->input->post('before_body_close', FALSE);
        if ($this->input->post('page_template_id', TRUE) == '') {
            $data['page_template_id'] = $page_details['page_template_id'];
        } else {
            $data['page_template_id'] = $this->input->post('page_template_id', TRUE);
        }

        $data['show_in_menu'] = $this->input->post('show_in_menu', TRUE);
        $data['show_in_search'] = 1;
        $data['priority'] = 1;

        if ($this->input->post('parent_id', true) == 0) {
            $data['level'] = 0;
            $data['path'] = 0;
        } else {
            $parent_category = $this->detail($this->input->post('parent_id', true));
            $data['level'] = $parent_category['level'] + 1;
            $data['path'] = $parent_category['path'] . '.' . $this->input->post('parent_id', true);
        }

        $this->db->where('page_id', $page_details['page_id']);
        $this->db->update('page', $data);

        //Add main block
        $block = array();
        $block['block_contents'] = $this->input->post('contents', FALSE);
        $this->db->where('page_id', $page_details['page_id']);
        $this->db->where('is_main', 1);
        $this->db->update('page_block', $block);
    }

    //add record
    function duplicateRecord($page, $blocks) {
        $data = array();

        $data['title'] = $this->input->post('title', TRUE);
        if ($this->input->post('page_alias', TRUE) == '') {
            $data['page_alias'] = $this->_slug($this->input->post('title', TRUE));
        } else {
            $data['page_alias'] = $this->input->post('page_alias', TRUE);
        }

        $data['parent_id'] = $page['parent_id'];
        $data['browser_title'] = $page['browser_title'];
        $data['menu_title'] = $page['menu_title'];
        $data['meta_keywords'] = $page['meta_keywords'];
        $data['meta_description'] = $page['meta_description'];
        $data['before_head_close'] = $page['before_head_close'];
        $data['before_body_close'] = $page['before_body_close'];
        $data['page_template_id'] = $page['page_template_id'];
        $data['sort_order'] = $this->getSortOrder($page['parent_id']);
        $data['show_in_search'] = $page['show_in_search'];
        $data['active'] = $page['active'];

        if ($page['parent_id'] == 0) {
            $data['level'] = 0;
            $data['path'] = 0;
            $data['page_uri'] = $data['page_alias'];
        } else {
            $parent_category = $this->detail($page['parent_id']);
            $data['level'] = $parent_category['level'] + 1;
            $data['path'] = $parent_category['path'] . '.' . $page['parent_id'];
            $data['page_uri'] = $parent_category['page_uri'] . '/' . $data['page_alias'];
        }

        $status = $this->db->insert('page', $data);
        if (!$status)
            return false;

        //add main bloak
        $page_id = $this->db->insert_id();

        //insert block
        foreach ($blocks as $item) {
            $block = array();
            $block['page_id'] = $page_id;
            $block['block_title'] = $item['block_title'];
            $block['block_alias'] = $item['block_alias'];
            $block['block_image'] = $item['block_image'];
            $block['block_contents'] = $item['block_contents'];
             $block['is_main'] = $item['is_main'];
            $this->db->insert('page_block', $block);
        }
    }

    //function for delete record
    function deleteRecord($page_details) {

        //fetch  all the child of the page and set all child as root
        $this->db->where('parent_id', $page_details['page_id']);
        $rs = $this->db->get('page');
        $child = $rs->result_array();
        if (count($child > 0)) {
            foreach ($child as $item) {

                $data = array();
                $data['parent_id'] = '0';
                $data['level'] = 0;
                $data['path'] = 0;

                $this->db->where('page_id', $item['page_id']);
                $this->db->update('page', $data);
            }
        }

        $this->db->where('page_id', $page_details['page_id']);
        $this->db->delete('page');
        return;
    }

    function removeBanner($page) {
        //delete the  image
        $path = $this->config->item('PAGE_BANNER_PATH');
        $filename = $path . $page['banner_image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }

        $data = array();

        $data['banner_image'] = '';

        $this->db->where('page_id', $page['page_id']);
        $this->db->update('page', $data);
    }

    //function to get sort order
    function getSortOrder($pid) {
        $this->db->select_max('sort_order');
        $this->db->where('parent_id', intval($pid));
        $query = $this->db->get('page');
        $sort_order = $query->row_array();
        return $sort_order['sort_order'] + 1;
    }

    //function for page alias
    function _slug($pname, $lang) {
        //print_r($lang); exit();
        $page_name = ($pname) ? $pname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

        $slug = $page_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('page_alias', $slug);
        $this->db->where('language_code', $lang);
        $rs = $this->db->get('page');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('language_code', $lang);
                $this->db->where('page_alias', $alt_slug);
                $rs = $this->db->get('page');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }

    //function for Company video alias
    function _slugvideo($vname) {
        //print_r($lang); exit();
        $video_name = ($vname) ? $vname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

        $slug = $video_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('video_alias', $slug);
        $rs = $this->db->get('company_video');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('video_alias', $alt_slug);
                $rs = $this->db->get('company_video');
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