<?php

class Snapshotmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //List All snapshots
    function listAll($page_id, $offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->from('page_save_log');
        $this->db->join('user', 'user.user_id = page_save_log.user_id');
        $this->db->where('page_id', $page_id);
        $this->db->order_by('page_save_time', 'DESC');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    //Count all snapshots
    function countAll($page_id) {
        $this->db->where('page_id', $page_id);
        $this->db->get('page_save_log');
        return $this->db->count_all_results();
    }

    //Get snapshots details
    function getDetails($sid) {
        $this->db->select('*');
        $this->db->from('page_save_log');
        $this->db->where('page_save_log_id', intval($sid));
        $rs = $this->db->get();
        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    //Restore snapshot
    function restoreSnapshot($snapshot) {
        //Page data
        $page_data = unserialize(base64_decode($snapshot['page_data']));

        $update_page = array();
        $update_page['parent_id'] = $page_data['parent_id'];
        $update_page['translation_of'] = $page_data['translation_of'];
        $update_page['page_type_id'] = $page_data['page_type_id'];
        $update_page['page_alias'] = $page_data['page_alias'];
        $update_page['title'] = $page_data['title'];
        $update_page['page_uri'] = $page_data['page_uri'];
        $update_page['language_code'] = $page_data['language_code'];
        $update_page['menu_title'] = $page_data['menu_title'];
        $update_page['browser_title'] = $page_data['browser_title'];
        $update_page['page_template_id'] = $page_data['page_template_id'];
        $update_page['meta_keywords'] = $page_data['meta_keywords'];
        $update_page['meta_description'] = $page_data['meta_description'];
        $update_page['before_head_close'] = $page_data['before_head_close'];
        $update_page['before_body_close'] = $page_data['before_body_close'];
        $update_page['show_in_search'] = $page_data['show_in_search'];
        $update_page['path'] = $page_data['path'];
        $update_page['sort_order'] = $page_data['sort_order'];
        $update_page['priority'] = $page_data['priority'];
        $update_page['level'] = $page_data['level'];
        $update_page['active'] = $page_data['active'];
        $update_page['do_not_delete'] = $page_data['do_not_delete'];
        $update_page['include_in_sitemap'] = $page_data['include_in_sitemap'];
        $update_page['show_in_menu'] = $page_data['show_in_menu'];
        $update_page['do_not_delete'] = $page_data['do_not_delete'];
        $update_page['do_not_delete'] = $page_data['do_not_delete'];

        $this->db->where('page_id', $page_data['page_id']);
        $status = $this->db->update('page', $update_page);
        if (!$status) {
            return FALSE;
        }

        //Delete page bolcks
        $this->db->where('page_id', $page_data['page_id']);
        $this->db->delete('page_block');

        //Block data
        $blocks = unserialize(base64_decode($snapshot['block_data']));
        foreach ($blocks as $item) {
            $data = array();
            $data['page_id'] = $item['page_id'];
            $data['block_title'] = $item['block_title'];
            $data['block_alias'] = $item['block_alias'];
            $data['block_image'] = $item['block_image'];
            $data['block_image_alt'] = $item['block_image_alt'];
            $data['block_contents'] = $item['block_contents'];
            $data['block_link'] = $item['block_link'];
            $data['block_template_id'] = $item['block_template_id'];
            $data['updated_on'] = time();
            $data['is_main'] = $item['is_main'];

            $status = $this->db->insert('page_block', $data);
            if (!$status) {
                return FALSE;
            }
        }

        //Delete page module
        $this->db->where('page_id', $page_data['page_id']);
        $this->db->delete('page_data');

        //Module data
        $modeule_data = unserialize(base64_decode($snapshot['module_data']));
        if ($modeule_data) {
            foreach ($modeule_data as $item) {
                $modeule['page_id'] = $item['page_id'];
                $modeule['module_name'] = $item['module_name'];
                $modeule['page_setting'] = $item['page_setting'];
                $modeule['page_setting_value'] = $item['page_setting_value'];

                $status = $this->db->insert('page_data', $modeule);
                if (!$status) {
                    return FALSE;
                }
            }
        }

        //Delete page includes
        $this->db->where('page_id', $page_data['page_id']);
        $this->db->delete('page_include');

        //Include data
        $includes = unserialize(base64_decode($snapshot['include_data']));
        foreach ($includes as $include) {

            //Insert include
            $data = array();
            $data['page_id'] = $include['page_id'];
            $data['include_id'] = $include['include_id'];

            $status = $this->db->insert('page_include', $data);
            if (!$status) {
                return FALSE;
            }
        }

        $this->Pagemodel->savePageSnapshot($page_data);
        return;
    }

}

?>
