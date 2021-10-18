<?php
class Newsmodel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	//function get news details
	function getDetails($alias)
	{
		$this->db->from('news');
		$this->db->where('news_alias', $alias);
		$rs = $this->db->get();
		if ($rs->num_rows() == 1) {
			return $rs->row_array();
		}
		return FALSE;
	}
	function newsComments($id)
	{
		$this->db->from('news_comments');
		$this->db->where('news_id', $id);
		$this->db->where('active', 1);
		$rs = $this->db->get();
		return $rs->result_array();
	}
	function getImg($newsid)
	{
		$this->db->from('news_img');
		$this->db->where('news_id', $newsid);
		$rs = $this->db->get();
		return $rs->result_array();
	}

	//function recent news
	function listLatestNews($limit)
	{

		$this->db->order_by('news_date', 'DESC');
		$this->db->limit($limit);
		$rs = $this->db->get('news');

		return $rs->result_array();
	}


	//Count All case studies
	function countAll()
	{
		$this->db->from('news');
		return $this->db->count_all_results();
	}

	function listAll($offset = false, $limit = false)
	{

		if ($offset) $this->db->offset($offset);
		if ($limit) $this->db->limit($limit);

		$this->db->order_by('news_date', 'DESC');
		$this->db->where('active', '1');
		$query = $this->db->get('news');
		$results =  $query->result_array();

		$news_data = [];
		foreach ($results as $key => $item) {
			$this->db->select('*');
			$this->db->from('news_img');
			$this->db->where('news_id', $item['news_id']);
			$new_img = $this->db->get()->result_array();

			$news_data[$key] =  $item;
			$news_data[$key]['img'] = $new_img;
		}


		return $news_data;
	}
}
