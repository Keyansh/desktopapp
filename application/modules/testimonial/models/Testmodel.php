<?php

class Testmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //function get news details
    function getDetails($alias) {
        $this->db->from('testimonial');
        $this->db->where('test_alias', $alias);
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    //function recent news
    function listLatestNews() {
        $this->db->order_by('added_on', 'DESC');
        $this->db->limit(2);
        $rs = $this->db->get('news');
//        e($this->db->last_query());
        return $rs->row_array();
    }

    function getRelatedNewsByProductId($pid) {
        if ($pid == "")
            return false;
        $this->db->where('relative_product_news.product_id', $pid);
        $this->db->join('news', 'relative_product_news.news_id = news.news_id', 'left');
        $res = $this->db->get('relative_product_news');
        return array('num_rows' => $res->num_rows(), 'result' => $res->result_array());
    }

    function listAllByRange($key = false, $offset = FALSE, $limit = FALSE) {

        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $exp = explode('-', $key);
        $this->db->select('*')->where('year(news_date)', $exp['0']);
        if (isset($exp[1])) {
            $this->db->where('month(news_date)', $exp[1]);
        }
        $this->db->order_by('news_id', 'DESC');
        $query = $this->db->get('news');

        return $query->result_array();
    }

    //Count All case studies
    function countAll() {
        $this->db->from('testimonial');
        $this->db->where('active', 1);
        return $this->db->count_all_results();
    }

    function countAllcomment($news) {
        $this->db->where('news_id', $news['news_id']);
        $this->db->where('approve', 1);
        $this->db->from('news_comment');
        return $this->db->count_all_results();
    }

    function getnewsId() {
        return $this->db->where('page_id', '55')->get('page')->row_array();
    }

    function listAllTest($offset = false, $limit = false) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $this->db->order_by('sort_order', 'ASC');
        $this->db->where('active', 1);
        $query = $this->db->get('testimonial');
        return $query->result_array();
    }

    function listAll($skip_alias = array(), $offset = false, $limit = false) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $sql = "SELECT * FROM `" . $this->db->dbprefix('news') . "` 
                         order by YEAR(news_date) desc, added_on desc, DAY(news_date) desc";
        if ($skip_alias) {
            $this->db->where_not_in('news_alias', $skip_alias);
        }
        $this->db->order_by('added_on', 'DESC');
        $query = $this->db->get('news');
        return $query->result_array();
    }

    function recendskip($skip_alias) {
        $this->db->from('blog');
        $this->db->where_not_in('blog_alias', $skip_alias);
        $this->db->limit(5);
        $this->db->order_by('added_on', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getArchives() {
        return $this->db->query('SELECT count(news_id) as counts, month(news_date) as monthnumber , monthname(news_date) as month, year(news_date) as year FROM `br_news` group by month(news_date) order by month(news_date) desc ')->result_array();
    }

    function addcomment($id) {
        $this->load->library('email');
        date_default_timezone_set('Europe/London');
        $data['user_name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['comment'] = $this->input->post('comment');
        $data['news_id'] = $id;

        $data['approve'] = '0';
        $title = $this->input->post('title');

        $data['added_on'] = time();
        $status = $this->db->insert('news_comment', $data);
        $status = 1;
        if ($status == 1) {
            $emailBody = 'This is confirmation mail regarding comment on post &nbsp;' . $title;

            $this->email->initialize($this->config->item('EMAIL_CONFIG'));
            $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
            $this->email->to(DWS_EMAIL_ADMIN);
//            $this->email->bcc('balwinder@multichannelcreative.co.uk');
            $this->email->subject('Alert for comment confirmation');
            $this->email->message($emailBody);
            $status = $this->email->send();
        }

        return;
//       $data['page']
    }

    function recentblog() {
        $this->db->order_by('added_on', 'desc');
        $this->db->limit(5);
        $query = $this->db->get('blog');
        return $query->result_array();
    }

    function searchblog($text) {
        $this->db->like('blog_title', $text);
        return $this->db->get('blog')->result_array();
    }

}

?>
