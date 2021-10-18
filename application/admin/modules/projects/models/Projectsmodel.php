<?php

class Projectsmodel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //Get detail of News
    function getdetails($nid)
    {
        $this->db->where('projects_id', intval($nid));
        $query = $this->db->get('projects');
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        return false;
    }

    //Count All projects
    function countAll()
    {
        $this->db->from('projects');
        return $this->db->count_all_results();
    }

    //list all projects
    function listAll($offset = FALSE, $limit = FALSE)
    {
        // if ($offset)
        //     $this->db->offset($offset);
        // if ($limit)
        //     $this->db->limit($limit);

        $rs = $this->db->order_by("projects_id", "DESC")->get('projects');
        return $rs->result_array();
    }

    //insert record
    function insertRecord()
    {
        // e($_POST);
        $data = array();
        $data['projects_title'] = $this->input->post('title', true);
        if ($this->input->post('url_alias', TRUE) == '') {
            $data['projects_alias'] = $this->_slug($this->input->post('title', TRUE));
        } else {
            $data['projects_alias'] = url_title($this->input->post('url_alias', TRUE));
        }



        $data['project_cat'] = $this->input->post('architect', true);
        $data['architect'] = $this->input->post('architect', true);
        $data['contractor'] = $this->input->post('contractor', true);
        $data['short_contents'] = $this->input->post('short_contents');
        $data['projects_contents'] = $this->input->post('contents');
        $data['projects_date'] = $this->input->post('date', true);
        $data['project_cat'] = $this->input->post('project_cat', true);
        $data['video_link'] = $this->input->post('video_link', true);
        $data['is_like_active'] = $this->input->post('is_like_active', true) ? $this->input->post('is_like_active', true) : 0;
        $data['homepage_active'] = $this->input->post('homepage_active', true) ? $this->input->post('homepage_active', true) : 0;
        $data['added_on'] = time();

        // upload image
        $config = array();
        $config['upload_path'] = $this->config->item('PROJECTS_IMAGE_PATH');
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);

        if (count($_FILES) > 0) {
            //Check for valid image upload
            if ($_FILES['video_thumb']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['video_thumb']['tmp_name'])) {
                if (!$this->upload->do_upload('video_thumb')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {

                    $upload_data = $this->upload->data();
                    $data['video_thumb'] = $upload_data['file_name'];
                }
            }
        }
        $projects_image =  $this->input->post('projects_image');
        if ($projects_image != '') {
            $base64strcount = count($projects_image);
            $image_format_type = explode(';base64', explode('data:image/', $projects_image)[1])[0];
            for ($i = 0; $i < $base64strcount; $i++) {
                $img_name = time() . "_" . rand(0, 999999) . "." . $image_format_type;
                $img_path = $this->config->item('PROJECTS_IMAGE_PATH') . $img_name;
                $img = $projects_image;

                if (strpos($img, 'data:image') !== false) {
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $img = str_replace('data:image/jpg;base64,', '', $img);
                    $img = str_replace('data:image/jpeg;base64,', '', $img);
                    $img = str_replace('data:image/gif;base64,', '', $img);
                    $img = str_replace(' ', '+', $img);
                    $img_data = base64_decode($img);

                    $im = imagecreatefromstring($img_data);
                    if ($image_format_type == 'png') {
                        $white = imagecolorallocate($im, 255, 255, 255);
                        imagecolortransparent($im, $white);
                        imagepng($im, $img_path);
                    }

                    if ($im !== false) {
                        imagepng($im, $img_path);
                        imagedestroy($im);
                    } else {
                        echo 'An error occurred.';
                        exit();
                    }

                    // Get new sizes
                    list($width, $height) = getimagesize($img_path);
                    $extension = pathinfo($img_path, PATHINFO_EXTENSION);

                    $resize_image_arr = array();
                    // array_push($resize_image_arr, array("width" => "1000", "height" => "1000", "base_path" => $this->config->item('PROJECTS_IMAGE_PATH')));
                    array_push($resize_image_arr, array("base_path" => $this->config->item('PROJECTS_IMAGE_PATH')));

                    foreach ($resize_image_arr as $row) {
                        // CREATE IMAGES
                        $newwidth = $row['width'];
                        $newheight = $row['height'];

                        // Load
                        $destination = imagecreatetruecolor($newwidth, $newheight);
                        $source = imagecreatefromstring($img_data);

                        // Resize
                        imagecopyresized($destination, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                        // Output
                        imagepng($destination, $row['base_path'] . $img_name);

                        $data['projects_image'] =  $img_name;
                    }
                }
            }
        }

        $this->db->insert('projects', $data);
        $projects_id = $this->db->insert_id();
        // e($projects_id);
        $projects_assign = $this->input->post('productadd');

        if ($projects_assign) {
            foreach ($projects_assign as  $item) {
                $data = [];
                $data['productadd'] = $item;
                $data['pid'] = $projects_id;
                $this->db->insert('projects_assign', $data);
            }
        }
        $fieldname = $this->input->post('fieldname');
        $fieldvalue = $this->input->post('fieldvalue');
        if ($fieldname) {
            foreach ($fieldname as $key =>  $item) {
                $data = [];
                $data['fieldname'] = $item;
                $data['fieldvalue'] = $fieldvalue[$key];
                $data['project_id'] = $projects_id;
                $this->db->insert('project_dynamic_fields', $data);
            }
        }

        if ($this->input->post('image')) {
            $image = array();
            $image['main'] = $this->input->post('main');
            $image['photo'] = $this->input->post('image');

            self::projectsImageAddEdit($image, $projects_id);
        }
        return;
    }



    //update record
    function updateRecord($projects)
    {
        // e($_POST);
        $data = array();

        $data['projects_title'] = $this->input->post('title', true);

        if ($this->input->post('url_alias', TRUE) == '') {
            $data['projects_alias'] = $projects['projects_alias'];
        } else {
            $data['projects_alias'] = url_title($this->input->post('url_alias', TRUE));
        }


        $data['project_cat'] = $this->input->post('architect', true);
        $data['architect'] = $this->input->post('architect', true);
        $data['contractor'] = $this->input->post('contractor', true);
        $data['short_contents'] = $this->input->post('short_contents');
        $data['projects_contents'] = $this->input->post('contents');
        $data['projects_date'] = $this->input->post('date', true);
        $data['project_cat'] = $this->input->post('project_cat', true);
        $data['video_link'] = $this->input->post('video_link', true);
        $data['is_like_active'] = $this->input->post('is_like_active', true) ? $this->input->post('is_like_active', true) : 0;
        $data['homepage_active'] = $this->input->post('homepage_active', true) ? $this->input->post('homepage_active', true) : 0;
        $data['update_on'] = time();
        // upload image
        $config = array();
        $config['upload_path'] = $this->config->item('PROJECTS_IMAGE_PATH');
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $this->load->library('upload', $config);

        if (count($_FILES) > 0) {

            //Check for valid image upload
            if ($_FILES['video_thumb']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['video_thumb']['tmp_name'])) {
                if (!$this->upload->do_upload('video_thumb')) {
                    show_error($this->upload->display_errors('<p class="err">', '</p>'));
                    return FALSE;
                } else {

                    $upload_data = $this->upload->data();
                    $data['video_thumb'] = $upload_data['file_name'];
                }
            }
        }

        $projects_image =  $this->input->post('projects_image');
        if ($projects_image != '') {
            $base64strcount = count($projects_image);
            $image_format_type = explode(';base64', explode('data:image/', $projects_image)[1])[0];
            for ($i = 0; $i < $base64strcount; $i++) {
                $img_name = time() . "_" . rand(0, 999999) . "." . $image_format_type;
                $img_path = $this->config->item('PROJECTS_IMAGE_PATH') . $img_name;
                $img = $projects_image;

                if (strpos($img, 'data:image') !== false) {
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $img = str_replace('data:image/jpg;base64,', '', $img);
                    $img = str_replace('data:image/jpeg;base64,', '', $img);
                    $img = str_replace('data:image/gif;base64,', '', $img);
                    $img = str_replace(' ', '+', $img);
                    $img_data = base64_decode($img);

                    $im = imagecreatefromstring($img_data);
                    if ($image_format_type == 'png') {
                        $white = imagecolorallocate($im, 255, 255, 255);
                        imagecolortransparent($im, $white);
                        imagepng($im, $img_path);
                    }

                    if ($im !== false) {
                        imagepng($im, $img_path);
                        imagedestroy($im);
                    } else {
                        echo 'An error occurred.';
                        exit();
                    }

                    // Get new sizes
                    list($width, $height) = getimagesize($img_path);
                    $extension = pathinfo($img_path, PATHINFO_EXTENSION);

                    $resize_image_arr = array();
                    // array_push($resize_image_arr, array("width" => "1000", "height" => "1000", "base_path" => $this->config->item('PROJECTS_IMAGE_PATH')));
                    array_push($resize_image_arr, array("base_path" => $this->config->item('PROJECTS_IMAGE_PATH')));

                    foreach ($resize_image_arr as $row) {
                        // CREATE IMAGES
                        $newwidth = $row['width'];
                        $newheight = $row['height'];

                        // Load
                        $destination = imagecreatetruecolor($newwidth, $newheight);
                        $source = imagecreatefromstring($img_data);

                        // Resize
                        imagecopyresized($destination, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                        // Output
                        imagepng($destination, $row['base_path'] . $img_name);

                        $data['projects_image'] =  $img_name;
                    }
                }
            }
        }

        $this->db->where('projects_id', $projects['projects_id']);
        $this->db->update('projects', $data);
        $projects_id = $projects['projects_id'];
        // e($projects_id);


        $projects_assign = $this->input->post('productadd');

        $this->db->where('pid', $projects_id);
        $this->db->delete('projects_assign');


        if ($projects_assign) {
            foreach ($projects_assign as  $item) {
                $data = [];
                $data['productadd'] = $item;
                $data['pid'] = $projects_id;
                $this->db->insert('projects_assign', $data);
            }
        }
        $this->db->where('project_id', $projects_id);
        $this->db->delete('project_dynamic_fields');
        $fieldname = $this->input->post('fieldname');
        $fieldvalue = $this->input->post('fieldvalue');
        if ($fieldname) {
            foreach ($fieldname as $key =>  $item) {
                $data = [];
                $data['fieldname'] = $item;
                $data['fieldvalue'] = $fieldvalue[$key];
                $data['project_id'] = $projects_id;
                $this->db->insert('project_dynamic_fields', $data);
            }
        }
        if ($this->input->post('image')) {
            $image = array();
            $image['main'] = $this->input->post('main');
            $image['photo'] = $this->input->post('image');

            self::projectsImageAddEdit($image, $projects_id);
        }
        return;
    }
    public function projectsImageAddEdit($image, $projects_id)
    {
        $count = count($image['photo']);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $pimg = str_replace(' ', '_', $image['photo'][$i]);
                $img['projects_id'] = $projects_id;
                $img['img'] = $pimg;
                $img['imgalt'] = '';
                $img['main'] = $image['main'][$i];
                $this->db->insert('projects_img', $img);
            }
        }
    }
    //Function Delete Record
    function deleteRecord($projects)
    {
        $result = $this->db->where('projects_id', $projects['projects_id'])->get('projects_img')->result_array();

        if (count($result) > 0) {
            foreach ($result as $value) {
                $path = $this->config->item('PROJECTS_IMAGE_PATH');
                $filename = $path . $value['img'];
                if (file_exists($filename)) {
                    @unlink($filename);
                }
            }
        }

        $this->db->where('projects_id', $projects['projects_id']);
        $this->db->delete('projects');
        $this->db->where('project_id', $projects['projects_id']);
        $this->db->delete('project_dynamic_fields');
        $this->db->where('projects_id', $projects['projects_id']);
        $this->db->delete('projects_img');
    }

    //Function Delete Record
    function deleteImage($projects)
    {
        $data = array();
        $data['image'] = '';
        $this->db->where('projects_id', $projects['projects_id']);
        $this->db->update('projects', $data);
        return;
    }

    //function slug
    function _slug($projectstitle)
    {
        $projects_title = ($projectstitle) ? $projectstitle : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');

        $slug = $projects_title;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        //.,*,/,\,",',,,{,(,},)[,]
        $slug = url_title($slug, 'dash', true);
        $this->db->limit(1);
        $this->db->where('projects_alias', $slug);
        $rs = $this->db->get('projects');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('projects_alias', $alt_slug);
                $rs = $this->db->get('projects');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            } while ($slug_check);
            $slug = $alt_slug;
        }
        return $slug;
    }

    public function projectsImages($nid)
    {
        return $this->db
            ->where('projects_id', $nid)
            ->get('projects_img')
            ->result_array();
    }

    public function sectedprod($pid)
    {
        $this->db->select('t1.*');
        $this->db->from('product t1');
        $this->db->join('projects_assign t2', 't2.productadd = t1.id', 'left');
        $this->db->where('t2.pid', $pid);
        $this->db->group_by("t1.id");
        $res = $this->db->get();
        $result = $res->result_array();
        return $result;
    }
    public function projecttype()
    {
        $this->db->select('*');
        $this->db->from('projecttype');
        $this->db->where('active', 1);
        $res = $this->db->get();
        $result = $res->result_array();
        return $result;
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
