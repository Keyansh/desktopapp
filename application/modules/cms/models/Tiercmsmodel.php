<?php

class Tiercmsmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    //Function Get Details Of Tier
    function getDetails($pid, $profile_id) {
        $profile_ids = array($profile_id, 1);
        $this->db->select('p3.tier_qty, p3.tier_price');
        $this->db->from('profilegroup p1');
        $this->db->join('profilegroup_config p2', 'p1.id = p2.profile_id', 'INNER');
        $this->db->join('tier_price p3', 'p3.tier_profile_id = p2.profile_id', 'INNER');
        $this->db->where('p3.tier_product_id', intval($pid));
        $this->db->where('p2.profileconfig_ref', 'TIERPRICING');
        $this->db->where('p2.profileconfig_value', 1);
        $this->db->where_in('p3.tier_profile_id', $profile_ids);
//        $this->db->where('p3.tier_profile_id', $profile_id);
        $this->db->group_by('p3.tier_id');
        $this->db->order_by('p3.tier_qty', 'DESC');
        $query = $this->db->get();
        //die($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    //Function Get All Details Of Tier
    function getTierDetails($pid) {
        $this->db->select('*');
        $this->db->from('product_tier_price');
        $this->db->where('product_tier_price.tier_product_id', intval($pid));
        $this->db->group_by('product_tier_price.tier_id');
        $this->db->order_by('product_tier_price.tier_min_qty', 'ASC');
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result_array();
    }

    //Function Get All Details Of Tier
    function getAllDetails($pid) {
        $profileIds = array('1', '2');
        $this->db->select('p3.tier_qty, p3.tier_price');
        $this->db->from('profilegroup p1');
        $this->db->join('profilegroup_config p2', 'p1.id = p2.profile_id', 'INNER');
        $this->db->join('tier_price p3', 'p3.tier_profile_id = p2.profile_id', 'INNER');
        $this->db->where('p3.tier_product_id', intval($pid));
        $this->db->where('p2.profileconfig_ref', 'TIERPRICING');
        $this->db->where('p2.profileconfig_value', 1);
        $this->db->where_in('p1.id', $profileIds);
        $this->db->group_by('p3.tier_id');
        $this->db->order_by('p3.tier_qty', 'ASC');
        $query = $this->db->get();
        //die($this->db->last_query());
        return $query->result_array();
    }

    //Function Get Details Of Tier
    function getQtyDetails($pid, $profile_id, $qty) {
        $profileName = array('Allgroup', 'Guest');

        $this->db->select('p3.tier_qty, p3.tier_price');
        $this->db->from('profilegroup p1');
        $this->db->join('profilegroup_config p2', 'p1.id = p2.profile_id', 'INNER');
        $this->db->join('tier_price p3', 'p3.tier_profile_id = p2.profile_id', 'INNER');
        $this->db->where('p3.tier_product_id', intval($pid));
        $this->db->where('p3.tier_qty <=', intval($qty));
        $this->db->where('p2.profileconfig_ref', 'TIERPRICING');
        $this->db->where('p2.profileconfig_value', 1);
        $this->db->where('p3.tier_profile_id', $profile_id);
        $this->db->group_by('p3.tier_id');
        $this->db->order_by('p3.tier_qty', 'DESC');
        $query = $this->db->get();
        //die($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        $this->db->select('p3.tier_qty, p3.tier_price');
        $this->db->from('profilegroup p1');
        $this->db->join('profilegroup_config p2', 'p1.id = p2.profile_id', 'INNER');
        $this->db->join('tier_price p3', 'p3.tier_profile_id = p2.profile_id', 'INNER');
        $this->db->where('p3.tier_product_id', intval($pid));
        $this->db->where('p3.tier_qty <=', intval($qty));
        $this->db->where('p2.profileconfig_ref', 'TIERPRICING');
        $this->db->where('p2.profileconfig_value', 1);
        $this->db->where_in('p1.profile_name', $profileName);
        $this->db->group_by('p3.tier_id');
        $this->db->order_by('p3.tier_qty', 'DESC');
        $query = $this->db->get();
        //die($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    //Function Get All Details Of Tier
    function getQtyAllDetails($pid, $qty) {
        $profileName = array('Allgroup', 'Guest');
        $this->db->select('p3.tier_qty, p3.tier_price');
        $this->db->from('profilegroup p1');
        $this->db->join('profilegroup_config p2', 'p1.id = p2.profile_id', 'INNER');
        $this->db->join('tier_price p3', 'p3.tier_profile_id = p2.profile_id', 'INNER');
        $this->db->where('p3.tier_product_id', intval($pid));
        $this->db->where('p3.tier_qty <=', intval($qty));
        $this->db->where('p2.profileconfig_ref', 'TIERPRICING');
        $this->db->where('p2.profileconfig_value', 1);
        $this->db->where_in('p1.profile_name', $profileName);
        $this->db->group_by('p3.tier_id');
        $this->db->order_by('p3.tier_qty', 'DESC');
        $query = $this->db->get();
        //die($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function logtierPrice($pid, $pfid, $qty) {
        $this->db->select('p1.tier_price');
        $this->db->from('tier_price p1');
        $this->db->where('p1.tier_product_id', intval($pid));
        $this->db->where('p1.tier_qty <=', intval($qty));
        $this->db->where('p1.tier_profile_id', $pfid);
        $this->db->group_by('p1.tier_id');
        $query = $this->db->get();
        //die($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    function tierPrice($pid, $qty) {
        $this->db->select('p1.tier_price,p1.tier_id');
        $this->db->from('product_tier_price p1');
        $this->db->where('p1.tier_product_id', intval($pid));
        // $this->db->where('p1.tier_qty <=', intval($qty));
        $this->db->where(intval($qty)." BETWEEN p1.tier_min_qty AND p1.tier_max_qty");
        $this->db->group_by('p1.tier_id');
        $query = $this->db->get();
        // die($this->db->last_query());
       
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            $this->db->select('p1.tier_price,p1.tier_id');
            $this->db->from('product_tier_price p1');
            $this->db->where('p1.tier_product_id', intval($pid));
            $this->db->where('p1.tier_max_qty', 0); 
            $this->db->where('p1.tier_min_qty <=', intval($qty));
            // $this->db->where(intval($qty)." BETWEEN p1.tier_min_qty AND p1.tier_max_qty");
            $this->db->group_by('p1.tier_id');
            $query = $this->db->get();
            // die($this->db->last_query());

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }

        }
    }

    function notLogTierPrice($pid, $qty) {
        $profileName = array('Allgroup', 'Guest');
        $this->db->select('p3.tier_price');
        $this->db->from('profilegroup p1');
        $this->db->join('profilegroup_config p2', 'p1.id = p2.profile_id', 'INNER');
        $this->db->join('tier_price p3', 'p3.tier_profile_id = p2.profile_id', 'INNER');
        $this->db->where('p3.tier_product_id', intval($pid));
        $this->db->where('p3.tier_qty <=', intval($qty));
        $this->db->where('p2.profileconfig_ref', 'TIERPRICING');
        $this->db->where('p2.profileconfig_value', 1);
        $this->db->where_in('p1.profile_name', $profileName);
        $this->db->group_by('p3.tier_id');
        $this->db->order_by('p3.tier_qty', 'DESC');
        $query = $this->db->get();
        // die($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

}

?>
