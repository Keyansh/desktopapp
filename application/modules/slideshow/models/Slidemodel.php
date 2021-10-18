<?php

class Slidemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function listAll() {
        $this->db->where('active', 1);
        $this->db->order_by('sort_order', 'ASC');
        $rs = $this->db->get('slideshow_image');
        $query = $rs->result_array();
        return $query;
    }
    
     function ListHomeSlides(){
        $this->db->select('image,page_uri,title')
                ->from('page')
                ->where('type','1');
        
        $query = $this->db->get();
        if($query->num_rows()>0){
           return $query->result_array();
           
        }
        return FALSE;
        
     }
}

?>