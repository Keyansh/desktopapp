<?php

class Templatemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //List All templates
    function listAll($offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $this->db->from('page_template');
        $this->db->order_by('page_template_id', 'ASC');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    function countAll() {
        $this->db->from('page_template');
        return $this->db->count_all_results();
    }

    //Get template details
    function fetchByID($tid) {
        $this->db->select('*');
        $this->db->from('page_template');
        $this->db->where('page_template_id', intval($tid));
        $rs = $this->db->get();
        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    function insertRecord() {
        $data = array();

        $data['template_name'] = $this->input->post('template_name', TRUE);
        $data['admin_modules'] = $this->input->post('admin_modules', TRUE);
        $data['front_modules'] = $this->input->post('front_modules', TRUE);
		
        if ($this->input->post('template_alias', TRUE)) {
            $data['template_alias'] = $this->input->post('template_alias', TRUE);
        } else {
            $data['template_alias'] = $this->_slug($this->input->post('template_name', TRUE));
        }
        $data['template_contents'] = $this->input->post('template_contents', FALSE);
		
		$file_path = '../application/views/themes/' . THEME . "/templates/".$data['template_alias'].'.php';
		$status = file_put_contents($file_path, $data['template_contents']);
        if (!$status) {
            show_error('<p class="err">The system was unable to create the template!</p>');
            return FALSE;
        }

        $this->db->insert('page_template', $data);
    }

    //update record
    function updateRecord($template) {
        $data = array();

        $data['template_name'] = $this->input->post('template_name', TRUE);
         $data['admin_modules'] = $this->input->post('admin_modules', TRUE);
        $data['front_modules'] = $this->input->post('front_modules', TRUE);
        //template alias
        if ($this->input->post('template_alias', TRUE)) {
            $data['template_alias'] = $this->input->post('template_alias', TRUE);
        } else {
            $data['template_alias'] = $this->_slug($this->input->post('template_name', TRUE));
        }

        $data['template_contents'] = $this->input->post('template_contents', FALSE);
		
		//unlink the previous file
		$old_file = '../application/views/themes/' . THEME . "/templates/".$template['template_alias'].'.php';
		if (file_exists($old_file)) {
			@unlink($old_file);
		}
		
		//put the content in the new file
		$file_path = '../application/views/themes/' . THEME . "/templates/".$data['template_alias'].'.php';
		$status = file_put_contents($file_path, $data['template_contents']);
        if (!$status) {
            show_error('<p class="err">The system was unable to update the template!</p>');
            return FALSE;
        }

        $this->db->where('page_template_id', $template['page_template_id']);
        $this->db->update('page_template', $data);
    }

    //delete records
    function deleteRecord($template) {
		//unlink the previous file
		$old_file = '../application/views/themes/' . THEME . "/templates/".$template['template_alias'].'.php';
		if (file_exists($old_file)) {
			@unlink($old_file);
		}
		
        $this->db->where('page_template_id', $template['page_template_id']);
        $this->db->delete('page_template');
    }

    function _slug($tname) {
        $template_name = ($tname) ? $tname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

        $slug = $template_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        $slug = url_title($slug, 'dash', true);

        $this->db->limit(1);
        $this->db->where('template_alias', $slug);
        $rs = $this->db->get('page_template');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('template_alias', $alt_slug);
                $rs = $this->db->get('page_template');
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
