<?php
class Projectmodel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	//function get news details
	function getDetails($alias)
	{
		$this->db->from('projects');
		$this->db->where('projects_alias', $alias);
		$rs = $this->db->get();
		if ($rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return FALSE;
	}

	function getImg($id)
	{
		$this->db->from('projects_img');
		$this->db->where('projects_id', $id); 
		$this->db->order_by('main', 'desc');
		$rs = $this->db->get();
		return $rs->result_array();
	}
	function getProductImg($id)
	{
		$this->db->from('prod_img');
		$this->db->where('pid', $id);
		$this->db->where('main', 1);
		$rs = $this->db->get();
		return $rs->row_array();
	}

	function getProjectCategory($id)
	{
		$this->db->from('projecttype');
		$this->db->where('id', $id);
		$rs = $this->db->get();
		return $rs->row_array();
	}
	function getProductUsed($id)
	{
		$data = $this->db->select('t1.*')
			->from('product t1')
			->join('projects_assign t2', 't2.productadd = t1.id')
			->where('t2.pid', $id)
			->get()->result_array();

		return $data;
	}



	//Count All case studies
	function countAll()
	{
		$this->db->from('projects');
		return $this->db->count_all_results();
	}

	function listAll($offset = false, $limit = false)
	{

		if ($offset) $this->db->offset($offset);
		if ($limit) $this->db->limit($limit);

		$this->db->where('active', '1');
		$query = $this->db->get('projecttype');
		$results =  $query->result_array();

		$project_data = [];
		foreach ($results as $key => $item) {
			$this->db->select('*');
			$this->db->from('projects');
			$this->db->where('project_cat', $item['id']);
			$project = $this->db->get()->result_array();
			$project_data[$key] =  $item;
			$project_data[$key]['project'] = $project;
		}

		return $project_data;
	}
	public function projectDynamicFields($pid)
	{
		$this->db->select('*');
		$this->db->from('project_dynamic_fields');
		$this->db->where('project_id', $pid);
		$this->db->order_by("id", "ASC");
		$res = $this->db->get();
		$result = $res->result_array();
		return $result;
	}
}
