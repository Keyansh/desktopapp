<?php

class Contactusmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getdetails($id)
    {
        $this->db->where('id', intval($id));
        $query = $this->db->get('contactus');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    public function countAll()
    {
        $this->db->from('contactus');
        return $this->db->count_all_results();
    }

    public function listAll()
    {

        $this->db->order_by('sort_order', 'ASC');
        $rs = $this->db->get('contactus');
        return $rs->result_array();
    }


    public function insertRecord()
    {
        $data = array();

        $data['contactus_name'] = $this->input->post('contactus_name', true);
        $data['contactus_location'] = $this->input->post('contactus_location', true);
        $data['contactus_location_2'] = $this->input->post('contactus_location_2', true);
        // $data['contactus_city'] = $this->input->post('contactus_city', true);
        $data['contactus_pcode'] = $this->input->post('contactus_pcode', true);
        $data['contactus_county'] = $this->input->post('contactus_county', true);
        $data['contactus_email'] = $this->input->post('contactus_email', true);
        $data['contactus_phone'] = $this->input->post('contactus_phone', true);
        $data['contactus_country'] = $this->input->post('contactus_country', true);
        $data['contactus_fax'] = $this->input->post('contactus_fax', true);
        $data['contactus_web'] = $this->input->post('contactus_web', true);
        $data['added_on'] = time();
        $data['active'] = 1;

        $this->db->insert('contactus', $data);

        return;
    }

    public function updateRecord($contactus)
    {
        $data = array();
        $data['contactus_name'] = $this->input->post('contactus_name', true);
        $data['contactus_location'] = $this->input->post('contactus_location', true);
        $data['contactus_location_2'] = $this->input->post('contactus_location_2', true);
        // $data['contactus_city'] = $this->input->post('contactus_city', true);
        $data['contactus_pcode'] = $this->input->post('contactus_pcode', true);
        $data['contactus_county'] = $this->input->post('contactus_county', true);
        $data['contactus_email'] = $this->input->post('contactus_email', true);
        $data['contactus_phone'] = $this->input->post('contactus_phone', true);
        $data['contactus_country'] = $this->input->post('contactus_country', true);
        $data['contactus_fax'] = $this->input->post('contactus_fax', true);
        $data['contactus_web'] = $this->input->post('contactus_web', true);
        $data['added_on'] = time();

        $this->db->where('id', $contactus['id']);
        $this->db->update('contactus', $data);

        return;
    }

    public function deleteRecord($contactus)
    {
        $this->db->where('id', $contactus['id']);
        $this->db->delete('contactus');
    }
}
