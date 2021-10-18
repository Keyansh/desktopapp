<?php

class Headerandfootermodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //get all category
    public function headerandfooterlist()
    {
        $query = $this->db->get('header_and_footer');
        return $query->row_array();
    }


 
    //update record
    public function updateRecord($id)
    {
        $data = array();
        $data['header_style'] = $this->input->post('header_style', true);
        $data['footer_style'] = $this->input->post('footer_style', true);
        $this->db->where('id', $id);
        $this->db->update('header_and_footer', $data);
    }
}
