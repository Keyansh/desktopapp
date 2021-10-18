<?php

class Blogmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //Get detail of News
    public function getdetails($nid) {
        $this->db->where('blog_id', intval($nid));
        $query = $this->db->get('blog');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }

        return false;
    }

    //Count All News
    public function countAll() {
        $this->db->from('blog');

        return $this->db->count_all_results();
    }

    //list all News
    public function listAll($offset = false, $limit = false) {
        if ($offset) {
            $this->db->offset($offset);
        }

        if ($limit) {
            $this->db->limit($limit);
        }

        $rs = $this->db->get('blog');

        return $rs->result_array();
    }

    //insert record
    public function insertRecord() {
        $data = array();
        $data['blog_title'] = $this->input->post('title', true);
        if ($this->input->post('url_alias', true) == '') {
            $data['blog_alias'] = $this->_slug($this->input->post('title', true));
        } else {
            $data['blog_alias'] = url_title($this->input->post('url_alias', true));
        }

        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('BLOG_IMAGE_PATH');
        $config['allowed_types'] = 'jpg|jpeg|gif|png';
        $config['overwrite'] = false;
        $this->load->library('upload', $config);

        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!$this->upload->do_upload('image')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));

                    return false;
                } else {
                    $upload_data = $this->upload->data();
                    $data['blog_image'] = $upload_data['file_name'];

                    //resizing Medium image
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $this->config->item('BLOG_IMAGE_PATH') . $data['blog_image'];
                    $config['new_image'] = $this->config->item('BLOG_THUMBNAIL_PATH') . $data['blog_image'];
                    $config['create_thumb'] = false;
                    $config['maintain_ratio'] = false;
                    $config['width'] = 236;
                    $config['height'] = 133;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);
                    $one = $this->image_lib->resize();
                    if (!$one) {
                        echo $this->image_lib->display_errors();
                    }
//                    second
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $this->config->item('BLOG_IMAGE_PATH') . $data['blog_image'];
                    $config['new_image'] = $this->config->item('BLOG_IMAGE_PATH') . 'thumbnails/600-338/' . $data['blog_image'];
                    $config['create_thumb'] = false;
                    $config['maintain_ratio'] = false;
                    $config['width'] = 600;
                    $config['height'] = 338;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);
                    $two = $this->image_lib->resize();
                    if (!$two) {
                        echo $this->image_lib->display_errors();
                    }
                }
            }
        }

        $data['name'] = $this->input->post('name', false);
        $data['alt'] = $this->input->post('alt', false);
        $data['browser_title'] = $this->input->post('browser_title', false);
        $data['meta_keywords'] = $this->input->post('meta_keywords', false);
        $data['meta_description'] = $this->input->post('meta_description', false);
        $data['blog_contents'] = $this->input->post('contents', false);
//        $data['url'] = $this->input->post('url', true);
        $blog_date = $this->input->post('date', true);
        $date1 = strtr($blog_date, '/', '-');
        $change_format = date('Y-m-d', strtotime($date1));
        $data['blog_date'] = $change_format;
        $data['added_on'] = time();
        $this->db->insert('blog', $data);
        return;
    }

    //update record
    public function updateRecord($blog) {
        $data = array();

        $data['blog_title'] = $this->input->post('title', true);

        if ($this->input->post('url_alias', true) == '') {
            $data['blog_alias'] = $blog['blog_alias'];
        } else {
            $data['blog_alias'] = url_title($this->input->post('url_alias', true));
        }

        //upload image
        $config = array();
        $config['upload_path'] = $this->config->item('BLOG_IMAGE_PATH');
        $config['allowed_types'] = 'jpg|jpeg|gif|png';
        $config['overwrite'] = false;
        $this->load->library('upload', $config);

        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
                if (!$this->upload->do_upload('image')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));

                    return false;
                } else {
                    $upload_data = $this->upload->data();
                    $data['blog_image'] = $upload_data['file_name'];
                    //resizing Medium image
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $this->config->item('BLOG_IMAGE_PATH') . $data['blog_image'];
                    $config['new_image'] = $this->config->item('BLOG_THUMBNAIL_PATH') . $data['blog_image'];
                    $config['create_thumb'] = false;
                    $config['maintain_ratio'] = false;
                    $config['width'] = 236;
                    $config['height'] = 133;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);
                    $one = $this->image_lib->resize();
                    if (!$one) {
                        echo $this->image_lib->display_errors();
                    }

                    $path = $this->config->item('BLOG_IMAGE_PATH');
                    $filename = $path . $blog['blog_image'];
                    // if (file_exists($filename)) {
                    //     @unlink($filename);
                    // }

                    $path = $this->config->item('BLOG_THUMBNAIL_PATH');
                    $filename = $path . $blog['blog_image'];
                    // if (file_exists($filename)) {
                    //     @unlink($filename);
                    // }
//                    second size
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = $this->config->item('BLOG_IMAGE_PATH') . $data['blog_image'];
                    $config['new_image'] = $this->config->item('BLOG_IMAGE_PATH') . 'thumbnails/600-338/' . $data['blog_image'];
                    $config['create_thumb'] = false;
                    $config['maintain_ratio'] = false;
                    $config['width'] = 600;
                    $config['height'] = 338;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->initialize($config);
                    $two = $this->image_lib->resize();
                    if (!$two) {
                        echo $this->image_lib->display_errors();
                    }
                }
            }
        }

        $data['name'] = $this->input->post('name', false);
        $data['alt'] = $this->input->post('alt', false);
        $data['browser_title'] = $this->input->post('browser_title', false);
        $data['meta_keywords'] = $this->input->post('meta_keywords', false);
        $data['meta_description'] = $this->input->post('meta_description', false);
        $data['blog_contents'] = $this->input->post('contents', false);
//        $data['url'] = $this->input->post('url', true);
        $blog_date = $this->input->post('date', true);
        $date1 = strtr($blog_date, '/', '-');
        $change_format = date('Y-m-d', strtotime($date1));
        $data['blog_date'] = $change_format;
        $data['update_on'] = time();
        $this->db->where('blog_id', $blog['blog_id']);
        $this->db->update('blog', $data);

        return;
    }

    //Function Delete Record
    public function deleteRecord($blog) {
        $this->db->where('blog_id', $blog['blog_id']);
        $this->db->delete('blog');

        $path = $this->config->item('BLOG_IMAGE_PATH');
        $filename = $path . $blog['blog_image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }

        $path = $this->config->item('BLOG_THUMBNAIL_PATH');
        $filename = $path . $blog['blog_image'];
        if (file_exists($filename)) {
            @unlink($filename);
        }
    }

    //Function Delete Record
    public function deleteImage($blog) {
        $data = array();
        $data['image'] = '';

        $this->db->where('blog_id', $blog['blog_id']);
        $this->db->update('blog', $data);

        return;
    }

    //function slug
    public function _slug($blogtitle) {
        $blog_title = ($blogtitle) ? $blogtitle : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $blog_title;
        $slug = trim($slug);
        $slug = str_replace($replace_array, '', $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('blog_alias', $slug);
        $rs = $this->db->get('blog');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('blog_alias', $alt_slug);
                $rs = $this->db->get('blog');
                if ($rs->num_rows() > 0) {
                    $slug_check = true;
                }

                ++$suffix;
            } while ($slug_check);
            $slug = $alt_slug;
        }

        return $slug;
    }

}
