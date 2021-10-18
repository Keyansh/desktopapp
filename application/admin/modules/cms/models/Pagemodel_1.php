<?php

class Pagemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getModuleData($pid, $module_name, $setting) {
        $this->db->where('page_id', $pid);
        $this->db->where('module_name', $module_name);
        $this->db->where('page_setting', $setting);
        $rs = $this->db->get('page_data');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    function getModuleDataAll($page_id, $module_alias) {
        $this->db->where('page_id', $page_id);
        $this->db->where('module_name', $module_alias);
        $rs = $this->db->get('page_data');
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }
        return FALSE;
    }

    //get language
    function getLanguage($lang_code) {
        $this->db->where('language_code', $lang_code);
        $rs = $this->db->get('language');
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    //Get page details
    function detail($pid) {
        $this->db->from('page');
        $this->db->join('page_block', 'page_block.page_id = page.page_id');
        $this->db->join('page_template', 'page_template.page_template_id = page.page_template_id');
        $this->db->where('is_main', 1);
        $this->db->where('page.page_id', intval($pid));
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    //Get page & block details
    function fetchPageDataDetail($page_details, $block_data) {
        if ($block_data) {
            $this->db->where('is_main', 1);
            $this->db->where('page_id', intval($page_details['page_id']));
            $rs = $this->db->get('page_block');
        } else {
            $this->db->where('page_id', intval($page_details['page_id']));
            $rs = $this->db->get('page');
        }

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
    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->order_by('title', 'ASC');
        $rs = $this->db->get('page');
        return $rs->result_array();
    }

    //List All Records
    function listAllLanguage($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        //$this->db->order_by('title', 'ASC');
        $rs = $this->db->get('language');
        return $rs->result_array();
    }

    //function to list all pages in indented
    function listAllIndented() {
        $this->db->where('level', 0);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('page');
        return $query->result_array();
    }

    //function to list all pages in indented
    function listAllpages($parent, &$output = array()) {
        $this->db->where('parent_id', $parent);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('page');
        foreach ($query->result_array() as $row) {
            $output[] = $row;
            $this->indentedActiveList($row['page_id'], $output);
        }
        return $output;
    }

    //find the indented list of pages
    function indentedActiveList_old($parent, $exclude = false, &$output = array()) {
        //$this->db->where('active',1);
        $this->db->where('parent_id', $parent);
        if ($exclude) {
            $this->db->where('page_id !=', $exclude);
        }
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('page');
        foreach ($query->result_array() as $row) {
            $output[] = $row;
            $this->indentedActiveList($row['page_id'], $exclude, $output);
        }
        return $output;
    }

    function indentedActiveList($parent, &$output = array()) {
        $this->db->join('language', 'language.language_code = page.language_code', 'LEFT');
        $this->db->where('parent_id', $parent);
        $this->db->where('page.language_code', 'en');
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('page');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $output[$row['page_id']] = $row;
                $this->indentedActiveList($row['page_id'], $output);
            }
        }
        return $output;
    }

    //function page link tree
    function pageItemTree($parent, $output = '') {
        $this->db->join('language', 'language.language_code = page.language_code', 'LEFT');
        $this->db->where('parent_id', $parent);
        $this->db->where('page.language_code', 'en');
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('page');
        if ($query->num_rows() > 0) {
            if ($parent == 0) {
                $output .= '<ul id="pagetree">' . "\r\n";
            } else {
                $output .= "<ul>\r\n";
            }
            foreach ($query->result_array() as $row) {
                //var_dump($row);
                //link edit
                $edit_href = 'cms/page/edit/' . $row['page_id'] . '/2';

                //language
                $language = ' <span style="padding-left: 20px; color: #bbb">' . $row['page_uri'] . ' ';
                if ($row['language_code'] != 'en') {
                    $language = '(' . $row['language'] . ')';
                }
                $language .= '</span>';

                //link delete
                $del_href = 'cms/page/delete/' . $row['page_id'];

                //link split versions
                $splitversion_href = 'cms/page_version/index/' . $row['page_id'];

                //link blockd
                $block_href = 'cms/block/index/' . $row['page_id'];

                //link duplicate page
                $duplicate_href = 'cms/page/duplicate/' . $row['page_id'];

                //link translate page
                $translate_href = 'cms/translate/index/' . $row['page_id'];

                //older split versions
                $olderversion_href = 'older_version/index/' . $row['page_id'];

                //$output .= '<li id="page_' . $row['page_id'] . '"><div class="page_item"><div class="page_item_name"><a href="' . $edit_href . '">' . $row['title'] . "</a></div>  " . $language . " <div class=\"page_item_options\"> <a href=\"" . $translate_href . "\">Translate</a> | <a href=\"" . $duplicate_href . "\">Duplicate Page</a> | <a href=\"" . $block_href . "\"> Manage Blocks</a> | <a href=\"" . $edit_href . "\">Edit</a> | <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Link ?');\">Delete</a> | <a href=\"" . $splitversion_href . "\">Split Versions</a></div></div>";
                $output .= '<li id="page_' . $row['page_id'] . '"><div class="page_item"><div class="page_item_name"><a href="' . $edit_href . '">' . $row['title'] . "</a></div>  " . $language . " <div class=\"page_item_options\"> <a href=\"" . $block_href . "\"> Manage Blocks</a> | <a href=\"" . $edit_href . "\">Edit</a> | <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Link ?');\">Delete</a></div></div>";
                $output = $this->pageItemTree($row['page_id'], $output);
                $output .= "</li>\r\n";
            }
            $output .= "</ul>\r\n";
        }
        return $output;
    }

    //add record
    function insertRecord($lang) {
        $parent = false;
        if ($this->input->post('parent_id', true) > 0) {
            $parent = $this->detail($this->input->post('parent_id', true));
        }

        $data = array();
        $data['title'] = $this->input->post('title', TRUE);
        $data['parent_id'] = $this->input->post('parent_id', TRUE);

        if ($this->input->post('browser_title', TRUE) == '') {
            $data['browser_title'] = $this->input->post('title', TRUE);
        } else {
            $data['browser_title'] = $this->input->post('browser_title', TRUE);
        }
        $data['page_alias'] = url_title(strtolower($this->input->post('title', TRUE)));
        if ($this->input->post('page_uri', TRUE) == '') {
            $data['page_uri'] = $this->_slug($parent, $this->input->post('title', TRUE));
        } else {
            $data['page_uri'] = url_title(strtolower($this->input->post('page_uri', TRUE)));
        }

        if ($this->input->post('menu_title', TRUE) == '') {
            $data['menu_title'] = $this->input->post('title', TRUE);
        } else {
            $data['menu_title'] = $this->input->post('menu_title', TRUE);
        }

        $data['language_code'] = $lang;
        $data['meta_keywords'] = $this->input->post('meta_keywords', TRUE);
        $data['meta_description'] = $this->input->post('meta_description', TRUE);
        $data['before_head_close'] = $this->input->post('before_head_close', FALSE);
        $data['before_body_close'] = $this->input->post('before_body_close', FALSE);
        $data['page_template_id'] = $this->input->post('page_template_id', TRUE);
        if ($this->input->post('sort_order', TRUE) == '') {
            $data['sort_order'] = $this->getSortOrder($this->input->post('parent_id', TRUE));
        } else {
            $data['sort_order'] = $this->input->post('sort_order', TRUE);
        }

        $data['show_in_menu'] = $this->input->post('show_in_menu', TRUE);

        $data['show_in_search'] = 1;
        $data['active'] = 1;

        if ($this->input->post('parent_id', true) == 0) {
            $data['level'] = 0;
            $data['path'] = 0;
        } else {
            $parent_category = $this->detail($this->input->post('parent_id', true));
            $data['level'] = $parent_category['level'] + 1;
            $data['path'] = $parent_category['path'] . '.' . $this->input->post('parent_id', true);
        }

        $status = $this->db->insert('page', $data);
        if (!$status)
            return false;

        //add main bloak
        $page_id = $this->db->insert_id();

        $block = array();
        $block['page_id'] = $page_id;
        $block['block_alias'] = 'block_main';
        $block['is_main'] = 1;
        $block['updated_on'] = time();
        $block['block_contents'] = $this->input->post('contents', FALSE);
        $status = $this->db->insert('page_block', $block);
    }

    //function update Record
    function updateRecord($page_details, $page_data) {
        $parent = false;
        if ($this->input->post('parent_id', true) > 0) {
            $parent = $this->detail($this->input->post('parent_id', true));
        }

        $data = array();
        $data['title'] = $this->input->post('title', TRUE);
        $data['parent_id'] = $this->input->post('parent_id', TRUE);

        if ($this->input->post('browser_title', TRUE) == '') {
            $data['browser_title'] = $this->input->post('title', TRUE);
        } else {
            $data['browser_title'] = $this->input->post('browser_title', TRUE);
        }

        if (($this->input->post('parent_id', true) != $page_details['parent_id']) || ($this->input->post('page_uri', TRUE) == '')) {
            $data['page_uri'] = $this->_slugEdit($parent, $this->input->post('title', TRUE), $page_details['language_code']);
        } else {
            $data['page_uri'] = $this->input->post('page_uri', TRUE);
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
        $data['page_template_id'] = $this->input->post('page_template_id', TRUE);
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
        $block['updated_on'] = time();
        $block['block_contents'] = $this->input->post('contents', FALSE);
        $this->db->where('page_id', $page_details['page_id']);
        $this->db->where('is_main', 1);
        $this->db->update('page_block', $block);

        return $this->savePageSnapshot($page_details);
    }

    //Function page snapshot
    function savePageSnapshot($page) {
        $user_id = $this->session->userdata('ADMIN_USER_ID');

        //Save all blocks
        $block_data = $this->Blockmodel->fetchAllBlocks($page['page_id']);

        //Save module data
        $module_data = $this->getAllModulesData($page['page_id']);

        //Save includes data
        $include_data = $this->getAllIncludessData($page['page_id']);

        $save_log = array();
        $save_log['page_id'] = $page['page_id'];
        $save_log['page_data'] = base64_encode(serialize($page));
        $save_log['module_data'] = base64_encode(serialize($module_data));
        $save_log['block_data'] = base64_encode(serialize($block_data));
        $save_log['include_data'] = base64_encode(serialize($include_data));
        $save_log['user_id'] = $user_id;
        $save_log['page_save_time'] = time();
        $save_log['save_is_active'] = 1;
        $status = $this->db->insert('page_save_log', $save_log);
        return $status;
    }

    //get page module
    function getAllModulesData($pid) {
        $this->db->where('page_id', $pid);
        $rs = $this->db->get('page_data');
        if ($rs) {
            return $rs->result_array();
        }
        return FALSE;
    }

    //get page module
    function getAllIncludessData($pid) {
        $this->db->where('page_id', $pid);
        $rs = $this->db->get('page_include');
        if ($rs) {
            return $rs->result_array();
        }
        return FALSE;
    }

    //function for page alias
    function _slugEdit($parent, $pname, $lang) {
        $page_name = ($pname) ? $pname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

        $slug = $page_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        $slug = url_title($slug, 'dash', true);
        if ($parent) {
            $slug = $parent['page_uri'] . '/' . $slug;
        }


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
                $this->db->where('page_uri', $alt_slug);
                $this->db->where('language_code', $lang);
                $rs = $this->db->get('page');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }

        return $slug;
    }

    //dulicate the records record
    function duplicatePage($page) {
        $parent = false;
        if ($this->input->post('parent_id', true) > 0) {
            $parent = $this->detail($this->input->post('parent_id', true));
        }



        //Duplicate existing row
        $this->db->query("CREATE TEMPORARY TABLE pageduptmp SELECT * from " . $this->db->dbprefix . "page WHERE page_id = {$page['page_id']}");
        $this->db->query("ALTER TABLE pageduptmp drop page_id");
        $this->db->query("INSERT INTO " . $this->db->dbprefix . "page SELECT 0,pageduptmp.* FROM pageduptmp");
        $new_page_id = $this->db->insert_id();
        $this->db->query("DROP TABLE pageduptmp");

        //Some columns will need to be updated in the duplicate page entry
        $data = array();
        $data['title'] = $this->input->post('title', TRUE);
        $data['parent_id'] = $this->input->post('parent_id', true);

        if ($this->input->post('page_uri', TRUE) == '') {
            $data['page_uri'] = $this->_slugDuplicate($this->input->post('title', TRUE), $page['language_code']);
        } else {
            $data['page_uri'] = url_title($this->input->post('page_uri', TRUE), '-', TRUE);
        }


        $data['sort_order'] = $this->getSortOrder($page['parent_id']);
        if (!$parent) {
            $data['level'] = 0;
            $data['path'] = 0;
        } else {
            $data['level'] = $parent['level'] + 1;
            $data['path'] = $parent['path'] . '.' . $page['parent_id'];
        }
        $this->db->where('page_id', $new_page_id);
        $status = $this->db->update('page', $data);
        if (!$status)
            return false;

        $new_page_data = array();
        $new_page_data = $data;

        //Duplicate the Blocks
        $blocks = $this->Blockmodel->fetchAllBlocks($page['page_id']);
        foreach ($blocks as $item) {
            $new_block_id = $this->Blockmodel->duplicateBlock($item['page_block_id']);
            $data = array();
            $data['page_id'] = $new_page_id;
            $this->db->where('page_block_id', $new_block_id);
            $this->db->update('page_block', $data);
        }


        //fetch the module data from the page_data
        $modeule_data = $this->fetchPageModuleData($page['page_id']);

        if ($modeule_data) {
            foreach ($modeule_data as $item) {
                $new_page_data_id = $this->duplicateModuleData($item['page_data_id']);
                $data = array();
                $data['page_id'] = $new_page_id;
                $this->db->where('page_data_id', $new_page_data_id);
                $this->db->update('page_data', $data);
            }
        }

        $new_page_data['page_id'] = $new_page_id;
        return $new_page_data;
    }

    function fetchPageModuleData($pid) {
        $this->db->where('page_id', $pid);
        $rs = $this->db->get('page_data');
        return $rs->result_array();
    }

    function duplicateChildPage($old_page_data, $new_page_data) {
        $this->db->where('parent_id', $old_page_data['page_id']);
        $rs = $this->db->get('page');

        if ($rs->num_rows() > 0) {
            foreach ($rs->result_array() as $page) {
                $child_page_data = $this->duplicatePage($page);
                $child_page_uri = str_replace($old_page_data['page_uri'], $new_page_data['page_uri'], $page['page_uri']);

                //print_r($child_page_uri); 
                $child_data = array();
                $child_data['page_uri'] = $child_page_uri;
                $child_data['parent_id'] = $new_page_data['page_id'];
                $child_data['page_title'] = $page['page_title'];

                $child_data['sort_order'] = $this->getSortOrder($child_data['parent_id']);
                $child_data['level'] = $new_page_data['level'] + 1;
                $child_data['path'] = $new_page_data['path'] . '.' . $child_data['parent_id'];
                $this->db->where('page_id', $child_page_data['page_id']);
                $this->db->update('page', $child_data);

                $child_data['page_id'] = $child_page_data['page_id'];
                $child_data['parent_id'] = $child_page_data['parent_id'];


                $this->duplicateChildPage($page, $child_data);
            }
        }
    }

    function duplicateModuleData($page_data_id) {
        $this->db->query("CREATE TEMPORARY TABLE pagedataduptmp SELECT * from " . $this->db->dbprefix . "page_data WHERE page_data_id = $page_data_id");
        $this->db->query("ALTER TABLE pagedataduptmp drop page_data_id");
        $this->db->query("INSERT INTO " . $this->db->dbprefix . "page_data SELECT 0,pagedataduptmp.* FROM pagedataduptmp");
        $new_page_data_id = $this->db->insert_id();
        $this->db->query("DROP TABLE pagedataduptmp");
        return $new_page_data_id;
    }

    //enable page
    function enableRecord($page_details) {
        $data = array();

        $data['active'] = 1;

        $this->db->where('page_id', $page_details['page_id']);
        $this->db->update('page', $data);
        return;
    }

    //disable page
    function disableRecord($page_details) {
        $data = array();

        $data['active'] = 0;

        $this->db->where('page_id', $page_details['page_id']);
        $this->db->update('page', $data);
        return;
    }

    //function for delete record
    function deleteRecord($page_details) {
        $duplicate_check_arr = array();
        $this->load->model('Translatemodel');
        $this->load->model('Blockmodel');

        //Fetch all child pages
        $this->db->where('parent_id', $page_details['page_id']);
        $rs = $this->db->get('page');
        $child = $rs->result_array();

        if (!empty($child)) {
            foreach ($child as $child_page) {

                $data = array();
                $page_uri = explode('/', $child_page['page_uri']);
                $last_value = array_pop($page_uri);

                //Update the URI, Level, Path
                $data['page_uri'] = $last_value;
                $data['parent_id'] = $page_details['parent_id'];
                $data['level'] = $page_details['level'];
                $data['path'] = $page_details['path'];
                $this->db->where('page_id', $child_page['page_id']);
                $this->db->update('page', $data);
                $duplicate_check_arr[] = $child_page['page_id'];

                //Fetch all blocks for the child page
                $child_blocks = array();
                $child_blocks = $this->Blockmodel->fetchAllBlocks($child_page['page_id']);
                foreach ($child_blocks as $child_block) {
                    if (isset($child_block['block_template']) && $child_block['block_alias'] != 'block_main') {

                        $path = ROOT_APPPATH . 'views/themes/' . THEME . "/blocks/";
                        if ($child_page['language_code'] == 'en') {
                            $old_file_name = str_ireplace('/', '_', $child_page['page_uri']) . '_' . $child_block['block_alias'] . '.php';
                            $new_file_name = str_ireplace('/', '_', $last_value) . '_' . $child_block['block_alias'] . '.php';
                        } else {
                            $old_file_name = str_ireplace('/', '_', $child_page['page_uri']) . '_' . $child_page['language_code'] . '_' . $child_block['block_alias'] . '.php';
                            $new_file_name = str_ireplace('/', '_', $last_value) . '_' . $child_page['language_code'] . '_' . $child_block['block_alias'] . '.php';
                        }
                        if (file_exists($path . $old_file_name)) {
                            @unlink($path . $old_file_name);
                        }
                    }
                }

                //Fetch the translations
                $page_translations = array();
                $page_translations = $this->Translatemodel->listAll($child_page);
                if ($page_translations) {
                    foreach ($page_translations as $translation) {
                        $translations_uri = array();

                        //page uri
                        $page_uri = explode('/', $child_page['page_uri']);
                        $last_value = array_pop($page_uri);

                        $translations_uri['page_uri'] = $last_value;
                        $translations_uri['parent_id'] = $page_details['parent_id'];
                        $translations_uri['level'] = $page_details['level'];
                        $translations_uri['path'] = $page_details['path'];
                        $this->db->where('page_id', $translation['page_id']);
                        $this->db->update('page', $translations_uri);
                        $duplicate_check_arr[] = $translation['page_id'];

                        //fetch the bllocks of translation
                        $translation_blocks = array();
                        $translation_blocks = $this->Blockmodel->fetchAllBlocks($translation['page_id']);
                        foreach ($translation_blocks as $item) {
                            if (isset($item['block_template']) && $item['block_alias'] != 'block_main') {

                                $path = ROOT_APPPATH . 'views/themes/' . THEME . "/blocks/";
                                if ($translation['language_code'] == 'en') {
                                    $old_file_name = str_ireplace('/', '_', $translation['page_uri']) . '_' . $item['block_alias'] . '.php';
                                    $new_file_name = str_ireplace('/', '_', $translations_uri['page_uri']) . '_' . $item['block_alias'] . '.php';
                                } else {
                                    $old_file_name = str_ireplace('/', '_', $translation['page_uri']) . '_' . $translation['language_code'] . '_' . $item['block_alias'] . '.php';
                                    $new_file_name = str_ireplace('/', '_', $translations_uri['page_uri']) . '_' . $translation['language_code'] . '_' . $item['block_alias'] . '.php';
                                }
                                if (file_exists($path . $old_file_name)) {
                                    @unlink($path . $old_file_name);
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($page_details['language_code'] == 'en') {
            //fetch the translations
            $page_translations = array();
            $page_translations = $this->Translatemodel->listAll($page_details);
            if ($page_translations) {
                foreach ($page_translations as $translation) {
                    //fetch the bllocks of ttranslation
                    $translation_blocks = array();
                    $translation_blocks = $this->Blockmodel->fetchAllBlocks($translation['page_id']);

                    foreach ($translation_blocks as $item) {
                        $file_name = str_ireplace('/', '_', $translation['page_uri']) . '_' . $translation['language_code'] . '_' . $item['block_alias'] . '.php';
                        if (file_exists(ROOT_APPPATH . "views/themes/" . THEME . "/blocks/" . $file_name)) {
                            @unlink(ROOT_APPPATH . "views/themes/" . THEME . "/blocks/" . $file_name);
                        }
                    }

                    //delete the block
                    $this->db->where('page_id', $translation['page_id']);
                    $this->db->delete('page_block');

                    //delete the translation
                    $this->db->where('page_id', $translation['page_id']);
                    $this->db->delete('page');
                }
            }
        }


        //fetch the bllocks
        $blocks = array();
        $blocks = $this->Blockmodel->fetchAllBlocks($page_details['page_id']);
        foreach ($blocks as $item) {
            if ($page_details['language_code'] == 'en') {
                $file_name = str_ireplace('/', '_', $page_details['page_uri']) . '_' . $item['block_alias'] . '.php';
            } else {
                $file_name = str_ireplace('/', '_', $page_details['page_uri']) . '_' . $page_details['language_code'] . '_' . $item['block_alias'] . '.php';
            }
            if (file_exists(ROOT_APPPATH . "views/themes/" . THEME . "/blocks/" . $file_name)) {
                @unlink(ROOT_APPPATH . "views/themes/" . THEME . "/blocks/" . $file_name);
            }
        }

        //delete the block of this page
        $this->db->where('page_id', $page_details['page_id']);
        $this->db->delete('page_block');


        $this->db->where('page_id', $page_details['page_id']);
        $this->db->delete('page');

        foreach ($duplicate_check_arr as $id) {
            $this->db->where('page_id', intval($id));
            $rs = $this->db->get('page');
            $page_details = $rs->row_array();
            //print_r($page_details); 
            //Valid page uri and block templates name
            if ($page_details) {
                $this->db->from('page');
                $this->db->where('page_uri', $page_details['page_uri']);
                $this->db->where('page_id !=', $page_details['page_id']);
                $this->db->where('language_code', $page_details['language_code']);
                $page_uri = $rs->row_array();
                $page_count = $this->db->count_all_results();
                if ($page_count != 0) {
                    $data = array();
                    $data['page_uri'] = $this->_slugDuplicate($page_uri['page_uri'], $page_uri['language_code']);
                    $data['page_alias'] = $this->_slugDuplicate($page_uri['page_alias'], $page_uri['language_code']);

                    $this->db->where('page_id', $page_uri['page_id']);
                    $this->db->update('page', $data);

                    //Fetch all blocks for the child page
                    $child_blocks = array();
                    $child_blocks = $this->Blockmodel->fetchAllBlocks($page_details['page_id']);
                    foreach ($child_blocks as $child_block) {
                        if (isset($child_block['block_template']) && $child_block['block_alias'] != 'block_main') {
                            $path = ROOT_APPPATH . 'views/themes/' . THEME . "/blocks/";

                            if ($page_uri['language_code'] == 'en') {
                                $file_name = str_ireplace('/', '_', $data['page_uri']) . '_' . $child_block['block_alias'] . '.php';
                            } else {
                                $file_name = str_ireplace('/', '_', $data['page_uri']) . '_' . $page_uri['language_code'] . '_' . $child_block['block_alias'] . '.php';
                            }
                            file_put_contents($path . $file_name, $child_block['block_template']);

                            //generate block file
                            //$this->generateBlockViewFile($data['page_uri'], $page_uri['language_code'], $child_block['block_alias'], $child_block['block_template']);
                        }

                        //Fetch the translations
                        $page_translations = array();
                        $page_translations = $this->Translatemodel->listAll($page_uri);
                        if ($page_translations) {
                            foreach ($page_translations as $translation) {
                                //fetch the bllocks of translation
                                $translation_blocks = array();
                                $translation_blocks = $this->Blockmodel->fetchAllBlocks($translation['page_id']);
                                foreach ($translation_blocks as $item) {
                                    if (isset($item['block_template']) && $item['block_alias'] != 'block_main') {
                                        $path = ROOT_APPPATH . 'views/themes/' . THEME . "/blocks/";

                                        if ($translation['language_code'] == 'en') {
                                            $file_name = str_ireplace('/', '_', $data['page_uri']) . '_' . $item['block_alias'] . '.php';
                                        } else {
                                            $file_name = str_ireplace('/', '_', $data['page_uri']) . '_' . $translation['language_code'] . '_' . $item['block_alias'] . '.php';
                                        }

                                        file_put_contents($path . $file_name, $item['block_template']);

                                        //generate block file
                                        //$this->generateBlockViewFile($data['page_uri'], $translation['language_code'], $item['block_alias'], $item['block_template']);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    //Fetch all blocks for the child page
                    $child_blocks = array();
                    $child_blocks = $this->Blockmodel->fetchAllBlocks($page_details['page_id']);
                    foreach ($child_blocks as $child_block) {
                        if (isset($child_block['block_template']) && $child_block['block_alias'] != 'block_main') {
                            $path = ROOT_APPPATH . 'views/themes/' . THEME . "/blocks/";

                            if ($page_details['language_code'] == 'en') {
                                $file_name = str_ireplace('/', '_', $page_details['page_uri']) . '_' . $child_block['block_alias'] . '.php';
                            } else {
                                $file_name = str_ireplace('/', '_', $page_details['page_uri']) . '_' . $page_details['language_code'] . '_' . $child_block['block_alias'] . '.php';
                            }
                            file_put_contents($path . $file_name, $child_block['block_template']);

                            //generate block file
                            //$this->generateBlockViewFile($data['page_uri'], $page_uri['language_code'], $child_block['block_alias'], $child_block['block_template']);
                        }

                        //Fetch the translations
                        $page_translations = array();
                        $page_translations = $this->Translatemodel->listAll($page_details);
                        if ($page_translations) {
                            foreach ($page_translations as $translation) {
                                //fetch the bllocks of translation
                                $translation_blocks = array();
                                $translation_blocks = $this->Blockmodel->fetchAllBlocks($translation['page_id']);
                                foreach ($translation_blocks as $item) {
                                    if (isset($item['block_template']) && $item['block_alias'] != 'block_main') {
                                        $path = ROOT_APPPATH . 'views/themes/' . THEME . "/blocks/";

                                        if ($translation['language_code'] == 'en') {
                                            $file_name = str_ireplace('/', '_', $page_details['page_uri']) . '_' . $item['block_alias'] . '.php';
                                        } else {
                                            $file_name = str_ireplace('/', '_', $page_details['page_uri']) . '_' . $translation['language_code'] . '_' . $item['block_alias'] . '.php';
                                        }

                                        file_put_contents($path . $file_name, $item['block_template']);

                                        //generate block file
                                        //$this->generateBlockViewFile($data['page_uri'], $translation['language_code'], $item['block_alias'], $item['block_template']);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
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

    function enableWidget($page_details, $widget) {
        $data = array();
        $data['page_id'] = $page_details['page_id'];
        $data['widget_id'] = $widget['widget_id'];
        $sort_order = $this->getWidgetSortOrder($page_details['page_id']);
        $data['sort_order'] = $sort_order;
        $this->db->insert('page_widget', $data);
    }

    function disableWidget($page_details, $widget) {
        $this->db->where('page_id', $page_details['page_id']);
        $this->db->where('widget_id', $widget['widget_id']);
        $this->db->delete('page_widget');
    }

    //function to get sort order
    function getWidgetSortOrder($pid) {
        $this->db->select_max('sort_order');
        $this->db->where('page_id', intval($pid));
        $query = $this->db->get('page_widget');
        $sort_order = $query->row_array();
        return $sort_order['sort_order'] + 1;
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
    function _slugDuplicate($pname, $lang) {
        //print_r($lang); exit();
        $page_name = ($pname) ? $pname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

        $slug = $page_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
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

    //function for page alias
    function _slug($parent, $pname) {
        $page_name = ($pname) ? $pname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

        $slug = $page_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        $slug = url_title($slug, 'dash', true);
        if ($parent) {
            $slug = $parent['page_uri'] . '/' . $slug;
        }


        $this->db->limit(1);
        $this->db->where('page_uri', $slug);
        $rs = $this->db->get('page');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
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

    //Function enable include
    function enableInclude($page_details, $include) {

        //delete
        $this->db->where('page_id', $page_details['page_id']);
        $this->db->where('include_id', $include['include_id']);
        $this->db->delete('page_include');

        $data = array();
        $data['page_id'] = $page_details['page_id'];
        $data['include_id'] = $include['include_id'];

        $status = $this->db->insert('page_include', $data);
        if (!$status) {
            return FALSE;
        }
    }

    //Function disable include
    function disableInclude($page_details, $include) {
        $this->db->where('page_id', $page_details['page_id']);
        $this->db->where('include_id', $include['include_id']);
        $this->db->delete('page_include');
    }

}

?>