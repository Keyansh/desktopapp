<?php

class Projecttypemodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //get all category
    public function brandList()
    {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('projecttype');
        return $query->result_array();
    }

    //get detail of category
    public function getdetails($bid)
    {
        $this->db->where('id', $bid);
        $query = $this->db->get('projecttype');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //insert record
    public function insertRecord()
    {
        $data = array();
        $data['name'] = $this->input->post('name', true);

        $this->db->insert('projecttype', $data);
    }

    //update record
    public function updateRecord($projecttype)
    {
        $data = array();

        $this->db->where('id', $projecttype['id']);
        $this->db->update('projecttype', $data);
    }


    //Function Delete Record
    public function deleteBrand($projecttype)
    {

        //delete the  brand
        $this->db->where('id', $projecttype['id']);
        $this->db->delete('projecttype');
    }
}
