<?php

class Offermodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function listAllOffers() {
        $this->db->select('id,name');
        $this->db->where('is_active', 1);
        $this->db->where('end_on >', date('Y-m-d'));
        $query = $this->db->get('offers');
//        ee($this->db->last_query());
        return $query->result_array();
    }

    function detail($sid) {
        $this->db->where('id', intval($sid));
        $rs = $this->db->get('homeoffers');
        if ($rs->num_rows() == 1)
            return $rs->row_array();

        return FALSE;
    }

    function listAll() {
        $query = $this->db->get('homeoffers');
        return $query->result_array();
    }

    //get sort order
    function getOrder() {
        $this->db->select_max('sort_order');
        $query = $this->db->get('homeoffers');
        $sort_order = $query->row_array();
        return $sort_order['sort_order'] + 1;
    }

    function insertRecord() {
        $data = array();
        $offerids = $this->input->post('offerids');
        if ($offerids) {
            $this->db->truncate('homeoffers');
            foreach ($offerids as $offerid) {
                $data['offer_id'] = $offerid;
                $data['sort_order'] = $this->getOrder();
                $this->db->insert('homeoffers', $data);
            }
        }
    }

    function deleteRecord($offer) {
        $this->db->where('id', $offer['id']);
        $this->db->delete('homeoffers');
    }

    //enable topcat
    function enableRecord($offer) {
        $data = array();

        $data['is_active'] = 1;

        $this->db->where('id', $offer['id']);
        $this->db->update('homeoffers', $data);
        return;
    }

    //disable topcat
    function disableRecord($offer) {
        $data = array();
        $data['is_active'] = 0;
        $this->db->where('id', $offer['id']);
        $this->db->update('homeoffers', $data);
        return;
    }

    function offerTree($output = '') {
        $this->db->select('t1.*, t2.name');
        $this->db->from('homeoffers t1');
        $this->db->join('offers t2', 't2.id = t1.offer_id');
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $output .= '<ul id="offertree">' . "\r\n";
            foreach ($query->result_array() as $row) {
                $del_href = 'homepage/homeoffer/delete/' . $row['id'];
                if ($row['is_active'] == 1) {
                    $link_href = 'homepage/homeoffer/disable/' . $row['id'];
                    $link_name = '<i class="glyph-icon icon-eye green-color"></i>';
                } else {
                    $link_href = 'homepage/homeoffer/enable/' . $row['id'];
                    $link_name = '<i class="glyph-icon icon-eye-slash"></i>';
                }



                $output .= '<li id="menu_' . $row['id'] . '"><div class="menu_item">' . '<div class="offerView"><h3>' . $row['name'] . '</h3></div>' . "</div><div class=\"menu_item_options\"> <a href=\"" . $link_href . "\" onclick=\"return confirm('Are you sure you want to Enable/Disable this Offer?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Enable/Disable'>" . $link_name . "</a> <a href=\"" . $del_href . "\" onclick=\"return confirm('Are you sure you want to Delete this Offer ?');\" class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class='glyph-icon icon-trash red-color'></i></a></div><div style=\"clear:both\"></div> ";
                $output .= "</li>\r\n";
            }
            $output .= "</ul>\r\n";
        }
        return $output;
    }

}

?>