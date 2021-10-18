<?php

class Distributormodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    // public function searchKeyWord($keyword)
    // {
    //     $key = str_replace(' ', '', $keyword);
    //     if ($keyword) {
    //         $this->db->select('*');
    //         $this->db->from('distribution t1');
    //         $this->db->join('postcodes_asigned t2', 't2.dest_id = t1.id');
    //         $this->db->join('postcodelatlng t3', 't3.id = t2.post_is');
    //         $this->db->like("REPLACE(t3.postcode, ' ', '')", $key);
    //         $this->db->where('t1.active', 1);
    //         $query = $this->db->get();
    //         // e($this->db->last_query());
    //         return $query->result_array();

    //     }
    // } 


    public function searchKeyWord($keyword)
    {
        $result = [];
        if ($keyword) {
            $this->db->select('*');
            $this->db->from('distribution t1');
            $this->db->where('t1.active', 1);
            $this->db->group_by('t1.id');
            $query = $this->db->get();
            $destributer = $query->result_array();

            $this->db->select('*');
            $this->db->from('postcodelatlng');
            $this->db->where('id', $keyword);
            $query1 = $this->db->get();
            $postcode = $query1->row_array();
            foreach ($destributer as $iteam) {
                $miles =  number_format(distributerdistance($postcode['latitude'], $postcode['longitude'], $iteam['distribution_latitude'], $iteam['distribution_longitude'], "M") . " Miles", 2);
                $result[$iteam['id']] = $iteam;
                $result[$iteam['id']]['miles'] = $miles;
                $result[$iteam['id']]['postcode'] = $postcode;
            }
            $attack = [];
            foreach ($result as $key => $row) {
                $attack[$key]  = $row['miles'];
            }
            array_multisort($attack, SORT_ASC, $result);
            return $result;
        }
    }
}
