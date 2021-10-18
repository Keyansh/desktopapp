<?php

class Distributionmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getdetails($id)
    {
        $this->db->where('id', intval($id));
        $query = $this->db->get('distribution');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    public function countAll()
    {
        $this->db->from('distribution');
        return $this->db->count_all_results();
    }

    public function listAll()
    {

        $this->db->order_by('id', DESC);
        $rs = $this->db->get('distribution');
        return $rs->result_array();
    }


    public function insertRecord()
    {
        $data = array();

        $data['distribution_name'] = $this->input->post('distribution_name', true);
        $data['distribution_location'] = $this->input->post('distribution_location', true);
        $data['distribution_location_2'] = $this->input->post('distribution_location_2', true);
        $data['distribution_city'] = $this->input->post('distribution_city', true);
        $data['distribution_pcode'] = $this->input->post('distribution_pcode', true);
        $data['distribution_county'] = $this->input->post('distribution_county', true);
        $data['distribution_email'] = $this->input->post('distribution_email', true);
        $data['distribution_phone'] = $this->input->post('distribution_phone', true);
        $data['distribution_country'] = $this->input->post('distribution_country', true);
        $data['distribution_latitude'] = $this->input->post('distribution_latitude', true);
        $data['distribution_longitude'] = $this->input->post('distribution_longitude', true);
        $data['added_on'] = time();

        $this->db->insert('distribution', $data);
        $insert_id = $this->db->insert_id();
        $states = $this->input->post('states', true);

        $datapost = array();

        foreach ($states as $state) {
            $datapost['post_is'] = $state;
            $datapost['dest_id'] = $insert_id;
            $datapost['added_on'] = time();
            $this->db->insert('postcodes_asigned', $datapost);
        }
        return;
    }

    public function updateRecord($distribution)
    {
        $data = array();
        $data['distribution_name'] = $this->input->post('distribution_name', true);
        $data['distribution_location'] = $this->input->post('distribution_location', true);
        $data['distribution_location_2'] = $this->input->post('distribution_location_2', true);
        $data['distribution_city'] = $this->input->post('distribution_city', true);
        $data['distribution_pcode'] = $this->input->post('distribution_pcode', true);
        $data['distribution_county'] = $this->input->post('distribution_county', true);
        $data['distribution_email'] = $this->input->post('distribution_email', true);
        $data['distribution_phone'] = $this->input->post('distribution_phone', true);
        $data['distribution_country'] = $this->input->post('distribution_country', true);
        $data['distribution_latitude'] = $this->input->post('distribution_latitude', true);
        $data['distribution_longitude'] = $this->input->post('distribution_longitude', true);
        $data['added_on'] = time();

        $this->db->where('id', $distribution['id']);
        $this->db->update('distribution', $data);
        $insert_id = $distribution['id'];
        $states = $this->input->post('states', true);

        $this->db->where('dest_id', $insert_id);
        $this->db->delete('postcodes_asigned');
        // e("123");

        $datapost = array();

        foreach ($states as $state) {
            $datapost['post_is'] = $state;
            $datapost['dest_id'] = $insert_id;
            $datapost['added_on'] = time();
            $this->db->insert('postcodes_asigned', $datapost);
        }
        return;
    }

    public function deleteRecord($distribution)
    {
        $this->db->where('id', $distribution['id']);
        $this->db->delete('distribution');
    }
    public function deletepost($distribution)
    {
        $this->db->where('dest_id', $distribution['id']);
        $this->db->delete('postcodes_asigned');
    }
}
