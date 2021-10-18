<?php

class Commentsmodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //count all comment
    function countAll($news) {
        $this->db->where('news_id', $news['news_id']);
        $this->db->where('approve', 1);
        $this->db->from('news_comment');
        return $this->db->count_all_results();
    }

    //list all comment
    function listAll($news, $offset = FALSE, $limit = FALSE) {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);
        $this->db->where('news_id', $news['news_id']);
        $this->db->where('approve', 1);
        $query = $this->db->get('news_comment');

        return $query->result_array();
    }

    //add comment
    function addComment($news) {

        //Add Entry to database
        $data = array();
//        $data['post_title'] = $post['post_title'];
        $data['news_id'] = $news['news_id'];
        $data['user_name'] = $this->input->post('user_name', TRUE);
        $data['comment'] = $this->input->post('comment', TRUE);
        $data['email'] = $this->input->post('email', TRUE);
        $data['added_on'] = time();
        //       print_r($data); exit();

        $status = $this->db->insert('news_comment', $data);

        if ($status == 1) {
            $emailBody = 'This is confirmation mail regarding comment on post &nbsp;' . $news['news_title'];

            $this->email->initialize($this->config->item('EMAIL_CONFIG'));
            $this->email->from(DWS_EMAIL_NOREPLY, DWS_EMAIL_FROM);
             $this->email->to(DWS_EMAIL_ADMIN);
//            $this->email->bcc('balwinder@multichannelcreative.co.uk');
            $this->email->subject('Alert for comment confirmation');
            $this->email->message($emailBody);
            $status = $this->email->send();
        }

        return;
    }

}

?>