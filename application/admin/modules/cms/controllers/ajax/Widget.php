<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class widget extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->is_admin_protected = TRUE;
	}

	/*function updateSortOrder($page_id){
        $this->load->model('Widgetmodel');
        $page_widgets = array();
        $rs = $this->Widgetmodel->pageWidgets($page_id);
        foreach($rs as $pw) {
            $page_widgets[] = $pw['widget_id'];
        }
		$sort_data = $this->input->post('widget', true);

        $counter = 0;
        foreach($sort_data as $key=>$val) {
            if(in_array($val, $page_widgets)) {
                $counter++;
                $update = array();
                $update['sort_order'] = $counter;

                $this->db->where('widget_id', $val);
                $this->db->where('page_id', $page_id);
                $this->db->update('page_widget', $update);
            }
		}
		echo "Done";

	}*/
	
	function updateSortOrder() {
        $sort_data = $this->input->post('widget', true);
        foreach ($sort_data as $key => $val) {
            $update = array();
            $update['widget_sort_order'] = $key + 1;
            $this->db->where('widget_id', $val);
            $this->db->update('page_widget', $update);
        }
        echo "Done";
    }

}
?>