<?php

class Formsmodel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getdetails($form_id)
    {
        $this->db->where('id', intval($form_id));
        $query = $this->db->get('forms');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    function countAll()
    {
        $this->db->from('forms');
        return $this->db->count_all_results();
    }

    function listAll($offset = FALSE, $limit = FALSE)
    {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $rs = $this->db->get('forms');
        return $rs->result_array();
    }

    function getFields(){
        $fields = $this->db->order_by('field_type', 'ASC')->get('form_fields')->result_array();
        return $fields;
    }

    function insertRecord(){
        $data = array();
        $data['form_title'] = $this->input->post('form_title', true);
        $data['form_alias'] = $this->_slug($data['form_title']);
        $this->db->insert('forms', $data);
        return $this->db->insert_id();
    }

    function updateRecord($form_id){
        $data = array();
        $data['form_title'] = $this->input->post('form_title', true);
        $data['form_alias'] = $this->_slug($data['form_title']);
        $data['send_email_to_user'] = $this->input->post('send_email_to_user', true);
        $data['user_email_from'] = $this->input->post('user_email_from', true);
        $data['user_email_subject'] = $this->input->post('user_email_subject', true);
        $data['user_email_body'] = $this->input->post('user_email_body', false);

        $data['send_email_to_admin'] = $this->input->post('send_email_to_admin', true);
        $data['admin_email_from'] = $this->input->post('admin_email_from', true);
        $data['admin_email_to'] = $this->input->post('admin_email_to', true);
        $data['admin_email_subject'] = $this->input->post('admin_email_subject', true);
        $data['admin_email_body'] = $this->input->post('admin_email_body', false);

        $this->db->where('id', $form_id);
        $this->db->update('forms', $data);
    }

    function assignFields(){
        $validation_arr = $this->input->post('validations') ? $this->input->post('validations') : [];
        $min_length = $this->input->post('min_length');
        $max_length = $this->input->post('max_length');
        if($min_length){
            array_push($validation_arr,"min_length[$min_length]");
        }
        
        if($max_length){
            array_push($validation_arr,"max_length[$max_length]");
        }
        

        $data = array();
        $data['form_id'] = $this->input->post('form_id');
        $data['type'] = $this->input->post('type');
        if($data['type'] == 'captcha'){
            $data['name'] = 'captcha';
            $data['validations'] = '["required"]';
        }else{
            $data['name'] = $this->_slug($this->input->post('label'));
            $data['validations'] = json_encode($validation_arr);
        }
        $data['label'] = $this->input->post('label');
        $data['display_label'] = $this->input->post('display_label');
        $data['default_value'] = $this->input->post('default_value');
        $data['placeholder'] = $this->input->post('placeholder');
        $data['options'] = $this->input->post('options');
        $this->db->insert('form_field_assignment', $data);
    }

    function getAssignedFields($form_id){
        $fields = $this->db->where('form_id', $form_id)->order_by('sort_order', 'ASC')->get('form_field_assignment')->result_array();
        return $fields;
    }

    function _slug($newstitle)
    {
        $news_title = ($newstitle) ? $newstitle : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $news_title;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        $slug = url_title($slug, 'underscore', true);
        return $slug;
    }

    function listAllSubmissions(){
        $this->db->select('t1.form_title, t2.*');
        $this->db->from('forms t1');
        $this->db->join('form_submissions t2', 't2.form_id = t1.id');
        return $this->db->get()->result_array();
    }
}
