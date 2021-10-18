<?php

class Blockmodel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //Get block Detial
    function getDetails($bid) {
        $this->db->where('page_block_id', $bid);
        $rs = $this->db->get('page_block');
        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    function fetchByAlias($pageid, $alias) {
        $this->db->where('page_id', $pageid);
        $this->db->where('block_alias', $alias);
        $rs = $this->db->get('page_block');
        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    //list all block
    function fetchAllBlocks($pid) {
        $this->db->where('page_id', $pid);
        $this->db->order_by('page_block_id', 'ASC');
        $query = $this->db->get('page_block');
        return $query->result_array();
    }

    //count all block
    function countAll($pid) {
        $this->db->where('page_id', $pid);
        $this->db->where('is_main', 0);
        $this->db->from('page_block');
        return $this->db->count_all_results();
    }

    //list all block
    function listAll($pid, $offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->where('page_id', $pid);
        $this->db->where('is_main', 0);
        $this->db->order_by('block_sort_order', 'ASC');
        $query = $this->db->get('page_block');
        return $query->result_array();
    }

    function getOrder($pid) {
        $this->db->select_max('block_sort_order');
        $this->db->where('page_id', $pid);
        $query = $this->db->get('page_block');
        $sort_order = $query->row_array();
        return $sort_order['block_sort_order'] + 1;
    }

    //function insert record
    function insertRecord($pages) {

        $data = array();
        $data['page_id'] = $pages['page_id'];
        $data['block_title'] = $this->input->post('block_title', TRUE);
        //$data['block_alias'] = strtolower($this->input->post('block_alias', TRUE));
        $data['block_alias'] = $this->_slug($pages['page_id'], $this->input->post('block_title', TRUE));
        $data['block_contents'] = $this->input->post('block_contents', FALSE);
        $data['block_template_id'] = $this->input->post('block_template_id', FALSE);
        $data['block_type_id'] = $this->input->post('block_type_id', FALSE);
        $data['block_image_alt'] = $this->input->post('block_image_alt', TRUE);
        $data['block_link'] = $this->input->post('block_link', TRUE);
        $data['updated_on'] = time();

        //upload image
        $config['upload_path'] = $this->config->item('BLOCK_IMAGE_PATH');
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);
        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {

                if (!$this->upload->do_upload('image')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    $data['block_image'] = $upload_data['file_name'];
                }
            }
        }

        $order = $this->getOrder($pages['page_id']);
        $data['block_sort_order'] = $order;
        $this->db->insert('page_block', $data);
    }

    //function update record
    function updateRecord($block) {
        $data = array();
        $data['block_title'] = $this->input->post('block_title', TRUE);
        //$data['block_alias'] = strtolower($this->input->post('block_alias', TRUE));
        $data['block_contents'] = $this->input->post('block_contents', FALSE);
        $data['block_template_id'] = $this->input->post('block_template_id', FALSE);
        $data['block_type_id'] = $this->input->post('block_type_id', FALSE);
        $data['block_image_alt'] = $this->input->post('block_image_alt', TRUE);
        $data['block_link'] = $this->input->post('block_link', TRUE);
        $data['updated_on'] = time();

        //Upload block image
        $config['upload_path'] = $this->config->item('BLOCK_IMAGE_PATH');
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);
        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!$this->upload->do_upload('image')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {
                    $upload_data = $this->upload->data();
                    $data['block_image'] = $upload_data['file_name'];

                    $path = $this->config->item('BLOCK_IMAGE_PATH');
                    $filename = $path . $block['block_image'];
                    if (file_exists($filename)) {
                        @unlink($filename);
                    }
                }
            }
        }

        $this->db->where('page_block_id', $block['page_block_id']);
        $this->db->update('page_block', $data);
    }

    function blockTree($pid) {
        $this->db->where('page_id', $pid);
        $this->db->where('is_main', 0);
        //  $this->db->order_by('page_block_id', 'ASC');
        $query = $this->db->get('page_block');
        if ($query->num_rows() > 0) {
            if ($parent == 0) {
                $output .= '<ul id="pagetree">' . "\r\n";
            } else {
                $output .= "<ul>\r\n";
            }
            foreach ($query->result_array() as $row) {
                //var_dump($row);
                //link edit
                $edit_href = 'cms/block/edit/' . $row['page_block_id'] . '/2';
                //link delete
                $del_href = 'cms/block/delete/' . $row['page_block_id'];
                //$output .= '<li id="page_' . $row['page_id'] . '"><div class="page_item"><div class="page_item_name"><a href="' . $edit_href . '">' . $row['title'] . "</a></div>  " . $language . " <div class=\"page_item_options\"> <a href=\"" . $translate_href . "\">Translate</a> | <a href=\"" . $duplicate_href . "\">Duplicate Page</a> | <a href=\"" . $block_href . "\"> Manage Blocks</a> | <a href=\"" . $edit_href . "\">Edit</a> | <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Link ?');\">Delete</a> | <a href=\"" . $splitversion_href . "\">Split Versions</a></div></div>";
                $output .= '<li id="page_' . $row['page_block_id'] . '"><div class="page_item"><div class="page_item_name"><a href="' . $edit_href . '">' . $row['block_title'] . "</a></div><div class=\"page_item_options\">  <a href=\"" . $edit_href . "\">Edit</a> | <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Link ?');\">Delete</a></div></div>";
                $output = $this->blockTree($row['page_block_id'], $output);
                $output .= "</li>\r\n";
            }
            $output .= "</ul>\r\n";
        }
        return $output;
    }

    //function delete page block
    function deleteRecord($block) {
        //delete the entry form the product image table
        $this->db->where('page_block_id', $block['page_block_id']);
        $this->db->delete('page_block');
    }

    function duplicateBlock($block_id) {
        $this->db->query("CREATE TEMPORARY TABLE page_blockduptmp SELECT * from " . $this->db->dbprefix . "page_block WHERE page_block_id = $block_id");
        $this->db->query("ALTER TABLE page_blockduptmp drop page_block_id");
        $this->db->query("INSERT INTO " . $this->db->dbprefix . "page_block SELECT 0,page_blockduptmp.* FROM page_blockduptmp");
        $new_block_id = $this->db->insert_id();
        $this->db->query("DROP TABLE page_blockduptmp");
        return $new_block_id;
    }

    //function for page alias
    function _slug($pid, $pname) {
        $page_name = ($pname) ? $pname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

        $slug = $page_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        $slug = url_title($slug, 'dash', true);

        $this->db->limit(1);
        $this->db->where('page_id', $pid);
        $this->db->where('block_alias', $slug);
        $rs = $this->db->get('page_block');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('page_id', $pid);
                $this->db->where('block_alias', $alt_slug);
                $rs = $this->db->get('page_block');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }

        return $slug;
    }

    function edRecord($block) {
        $data = array();

        if ($block['is_active'] == 1) {
            $data['is_active'] = 0;
        } else {
            $data['is_active'] = 1;
        }
        $this->db->where('page_block_id', $block['page_block_id']);
        $this->db->update('page_block', $data);
        return;
    }

}

?>
