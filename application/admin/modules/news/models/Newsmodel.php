<?php

class Newsmodel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //Get detail of News
    function getdetails($nid)
    {
        $this->db->where('news_id', intval($nid));
        $query = $this->db->get('news');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //Count All News
    function countAll()
    {
        $this->db->from('news');
        return $this->db->count_all_results();
    }

    //list all News
    function listAll($offset = FALSE, $limit = FALSE)
    {
        if ($offset)
            $this->db->offset($offset);
        if ($limit)
            $this->db->limit($limit);

        $rs = $this->db->get('news');
        return $rs->result_array();
    }

    //insert record
    function insertRecord()
    {
        $data = array();
        $data['news_title'] = $this->input->post('title', true);
        if ($this->input->post('url_alias', TRUE) == '') {
            $data['news_alias'] = $this->_slug($this->input->post('title', TRUE));
        } else {
            $data['news_alias'] = url_title($this->input->post('url_alias', TRUE));
        }

        //upload image
        // $config = array();
        // $config['upload_path'] = $this->config->item('NEWS_IMAGE_PATH');
        // $config['allowed_types'] = 'jpg|jpeg|gif|png';
        // $config['overwrite'] = FALSE;
        // $this->load->library('upload', $config);

        // if (count($_FILES) > 0) {
        //     //Check for valid image upload
        //     if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
        //         if (!$this->upload->do_upload('image')) {

        //             show_error($this->upload->display_errors('<p class="err">', '</p>'));
        //             return FALSE;
        //         } else {
        //             $upload_data = $this->upload->data();
        //             $data['news_image'] = $upload_data['file_name'];

        //             //resizing Medium image
        //             $config['image_library'] = 'GD2';
        //             $config['source_image'] = $this->config->item('NEWS_IMAGE_PATH') . $data['news_image'];
        //             $config['new_image'] = $this->config->item('NEWS_THUMBNAIL_PATH') . $data['news_image'];
        //             $config['create_thumb'] = FALSE;
        //             $config['maintain_ratio'] = FALSE;
        //             $config['width'] = 150;
        //             $config['height'] = 150;
        //             $this->load->library('image_lib', $config);
        //             $this->image_lib->resize();
        //         }
        //     }
        // }


        $data['news_contents'] = $this->input->post('contents', false);
        $data['news_date'] = $this->input->post('date', true);
        $data['added_on'] = time();
        $this->db->insert('news', $data);
        $news_id = $this->db->insert_id();
        // e($news_id);
        if ($this->input->post('image')) {
            $image = array();
            $image['main'] = $this->input->post('main');
            $image['photo'] = $this->input->post('image');

            self::newsImageAddEdit($image, $news_id);
        }
        return;
    }



    //update record
    function updateRecord($news)
    {
        $data = array();

        $data['news_title'] = $this->input->post('title', true);

        if ($this->input->post('url_alias', TRUE) == '') {
            $data['news_alias'] = $news['news_alias'];
        } else {
            $data['news_alias'] = url_title($this->input->post('url_alias', TRUE));
        }

        // //upload image
        // $config = array();
        // $config['upload_path'] = $this->config->item('NEWS_IMAGE_PATH');
        // $config['allowed_types'] = 'jpg|jpeg|gif|png';
        // $config['overwrite'] = FALSE;
        // $this->load->library('upload', $config);

        // if (count($_FILES) > 0) {
        //     //Check for valid image upload
        //     if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
        //         if (!$this->upload->do_upload('image')) {

        //             show_error($this->upload->display_errors('<p class="err">', '</p>'));
        //             return FALSE;
        //         } else {
        //             $upload_data = $this->upload->data();
        //             $data['news_image'] = $upload_data['file_name'];

        //             //resizing Medium image
        //             $config['image_library'] = 'GD2';
        //             $config['source_image'] = $this->config->item('NEWS_IMAGE_PATH') . $data['news_image'];
        //             $config['new_image'] = $this->config->item('NEWS_THUMBNAIL_PATH') . $data['news_image'];
        //             $config['create_thumb'] = FALSE;
        //             $config['maintain_ratio'] = FALSE;
        //             $config['width'] = 150;
        //             $config['height'] = 150;
        //             $this->load->library('image_lib', $config);
        //             $this->image_lib->resize();

        //             $path = $this->config->item('NEWS_IMAGE_PATH');
        //             $filename = $path . $news['news_image'];
        //             if (file_exists($filename)) {
        //                 @unlink($filename);
        //             }

        //             $path = $this->config->item('NEWS_THUMBNAIL_PATH');
        //             $filename = $path . $news['news_image'];
        //             if (file_exists($filename)) {
        //                 @unlink($filename);
        //             }
        //         }
        //     }
        // }


        $data['news_contents'] = $this->input->post('contents', false);
        $data['news_date'] = $this->input->post('date', true);
        $data['update_on'] = time();

        $this->db->where('news_id', $news['news_id']);
        $this->db->update('news', $data);
        $news_id = $news['news_id'];
        // e($news_id);
        if ($this->input->post('image')) {
            $image = array();
            $image['main'] = $this->input->post('main');
            $image['photo'] = $this->input->post('image');

            self::newsImageAddEdit($image, $news_id);
        }
        return;
    }
    public function newsImageAddEdit($image, $news_id)
    {
        $count = count($image['photo']);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $pimg = str_replace(' ', '_', $image['photo'][$i]);
                $img['news_id'] = $news_id;
                $img['img'] = $pimg;
                $img['imgalt'] = '';
                $img['main'] = $image['main'][$i];
                $this->db->insert('news_img', $img);
            }
        }
    }
    //Function Delete Record
    function deleteRecord($news)
    {
        $result = $this->db->where('news_id', $news['news_id'])->get('news_img')->result_array();

        if (count($result) > 0) {
            foreach ($result as $value) {
                $path = $this->config->item('NEWS_IMAGE_PATH');
                $filename = $path . $value['img'];
                if (file_exists($filename)) {
                    @unlink($filename);
                }
            }
        }

        $this->db->where('news_id', $news['news_id']);
        $this->db->delete('news');
        $this->db->where('news_id', $news['news_id']);
        $this->db->delete('news_comments');
        $this->db->where('news_id', $news['news_id']);
        $this->db->delete('news_img');

        // $path = $this->config->item('NEWS_IMAGE_PATH');
        // $filename = $path . $news['news_image'];
        // if (file_exists($filename)) {
        //     @unlink($filename);
        // }

        // $path = $this->config->item('NEWS_THUMBNAIL_PATH');
        // $filename = $path . $news['news_image'];
        // if (file_exists($filename)) {
        //     @unlink($filename);
        // }
    }

    //Function Delete Record
    function deleteImage($news)
    {
        $data = array();
        $data['image'] = '';
        $this->db->where('news_id', $news['news_id']);
        $this->db->update('news', $data);
        return;
    }

    //function slug
    function _slug($newstitle)
    {
        $news_title = ($newstitle) ? $newstitle : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $news_title;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('news_alias', $slug);
        $rs = $this->db->get('news');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('news_alias', $alt_slug);
                $rs = $this->db->get('news');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            } while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }

    public function newsImages($nid)
    {
        return $this->db
            ->where('news_id', $nid)
            ->get('news_img')
            ->result_array();
    }

    function listAllComments($id)
    {
        return $this->db
            ->where('news_id', $id)
            ->get('news_comments')
            ->result_array();
    }
    function getCommentDetails($id)
    {

        return $this->db
            ->where('id', $id)
            ->get('news_comments')
            ->row_array();
    }
    function deleteComment($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('news_comments');
        return;
    }
}
