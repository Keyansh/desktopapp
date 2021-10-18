<?php

class Gallerymodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }


  
    function countAll() {
        $this->db->from('gallery');
        return $this->db->count_all_results();
    }

   
    
    function listAllGallery( ){
        $this->db->where('active', 1);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('gallery');
        return $query->result_array();
    }
 
  
}

?>
