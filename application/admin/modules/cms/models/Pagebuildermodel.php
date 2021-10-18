<?php

class Pagebuildermodel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //list all block
    function listAll($pid)
    {
        $this->db->where('page_id', $pid);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('pagebuilder_page_rows');
        $data = [];
        $blockData = $query->result_array();

        foreach ($blockData as $key => $item) {
            $this->db->where('page_id', $item['page_id']);
            $this->db->where('row_id', $item['id']);
            $this->db->order_by('id','ASC');
            $query = $this->db->get('pagebuilder_columns');
            $blobkElement = $query->result_array();

            $data[$item['id']] =  $item;
            $data[$item['id']]['blockElement'] =  $blobkElement;
        }

        return $data;
    }

    function listAllElements()
    {
        $this->db->select('*');
        $this->db->where('is_active', 1);
        $this->db->order_by('element_name','ASC');
        $query = $this->db->get('pagebuilder_elements');
        return $query->result_array();
    }

    function insertRecord()
    {
        $data = array();
        $data['element_id'] = $this->input->post('element_id');
        $data['page_id'] = $this->input->post('page_id');
        $data['title'] = $this->input->post('title');
        unset($_POST['element_id']);
        unset($_POST['page_id']);
        unset($_POST['title']);
        $data['config'] = json_encode($_POST);
        $data['added_on'] = time();
        $this->db->insert('pagebuilder_page_rows', $data);

        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $data['row_id'] = $insert_id;
        }

        $this->db->select('element_alias');
        $this->db->where('id', $data['element_id']);
        $query = $this->db->get('pagebuilder_elements')->row();
        $data['element_alias'] =  $query->element_alias;
        return  $data;
    }

    function insertRowAndColumnFormData()
    {
        $data = array();
        $data['layout_type'] = $this->input->post('layout_type');
        $data['page_id'] = $this->input->post('page_id');
        $data['added_on'] = time();
        $this->db->insert('pagebuilder_page_rows', $data);
        $insert_id = $this->db->insert_id();
        $number = 1;

        if ($data['layout_type'] == 'half_column' || $data['layout_type'] == 'left_column' || $data['layout_type'] == 'right_column') {
            $number = 2;
        }
        if ($data['layout_type'] == 'three_column' || $data['layout_type'] == 'center_column') {
            $number = 3;
        }
        if ($data['layout_type'] == 'four_column') {
            $number = 4;
        }
        if ($data['layout_type'] == 'five_column') {
            $number = 5;
        }

        for ($x = 1; $x <= $number; $x++) {
            $iteamdata = array();
            $iteamdata['page_id'] = $this->input->post('page_id');
            $iteamdata['row_id'] = $insert_id;
            $iteamdata['is_temp'] = 1;
            $iteamdata['added_on'] = time();
            $this->db->insert('pagebuilder_columns', $iteamdata);
        }
    }

    function insertElementRecord()
    {
        $page_id = $this->input->post('page_id');
        $column_id = $this->input->post('column_id');
        $row_id = $this->input->post('row_id');
        $data = array();
        $data['element_id'] = $this->input->post('element_id');
        $data['element_alias'] = $this->input->post('element_alias');
        $data['is_temp'] = 1;

        if($_POST["image"] != ''){
            $base64strcount = count($_POST["image"]);
            $image_format_type = explode(';base64',explode('data:image/',$_POST["image"])[1])[0];
            for ($i = 0; $i < $base64strcount; $i++) {
                $img_name = time() . "_" . rand(0, 999999) . "." . $image_format_type;
                $img_path = $this->config->item('BLOCK_IMAGE_PATH') . $img_name;
                $img = $_POST["image"];

                if (strpos($img, 'data:image') !== false) {
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $img = str_replace('data:image/jpg;base64,', '', $img);
                    $img = str_replace('data:image/jpeg;base64,', '', $img);
                    $img = str_replace('data:image/gif;base64,', '', $img);
                    $img = str_replace(' ', '+', $img);
                    $img_data = base64_decode($img);

                    $im = imagecreatefromstring($img_data);
                    if($image_format_type == 'png'){
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
                    // array_push($resize_image_arr, array("width" => "1000", "height" => "1000", "base_path" => $this->config->item('BLOCK_IMAGE_PATH')));
                    array_push($resize_image_arr, array("base_path" => $this->config->item('BLOCK_IMAGE_PATH')));

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

                        $_POST['image'] = $this->config->item('BLOCK_IMAGE_URL') . $img_name;
                        // $_POST['image'] = cdn('page/block_images/'.$img_name);
                        // $cdnImage = $img_name;
                        // self::runCmd($cdnImage);
                    }
                }
            }
        }

        unset($_POST['element_id']);
        unset($_POST['page_id']);
        unset($_POST['row_id']);
        unset($_POST['column_id']);
        unset($_POST['element_alias']);

        if($this->input->post('element_table') != ''){
            $update_row = [];
            $update_row['layout_type'] = $this->input->post('grid_layout_type');
            unset($_POST['grid_layout_type']);
            $update_row['element_config'] = json_encode($this->input->post());
            $this->db->where('id', $row_id)->update('pagebuilder_page_rows',$update_row);
        }
        unset($_POST['element_table']);

        $data['content_config'] = json_encode($this->input->post());
        $data['added_on'] = time();
        $this->db->where('id', $column_id);
        $this->db->where('row_id', $row_id);
        $this->db->where('page_id', $page_id);
        $this->db->update('pagebuilder_columns', $data);
    }

    function updateRowColumns(){
        $page_id = $this->input->post('page_id');
        $row_id = $this->input->post('row_id');
        $column_id = $this->input->post('column_id');
        $delete_type = $this->input->post('delete_type');
        
        if($delete_type == 'column'){
            $columnData = [];
            $columnData['element_id'] = null;
            $columnData['element_alias'] = null;
            $columnData['content_config'] = null;
            $columnData['style_config'] = null;
            $this->db->where('id',$column_id);
            $this->db->where('page_id',$page_id);
            $this->db->update('pagebuilder_columns',$columnData);
        }elseif($delete_type == 'row'){
            $this->db->where('page_id',$page_id)->where('id',$row_id)->delete('pagebuilder_page_rows');
            $this->db->where('page_id',$page_id)->where('row_id',$row_id)->delete('pagebuilder_columns');
        }
        return true;
    }

    function getRowData($page_id, $row_id){
        $row = $this->db->where('id',$row_id)->where('page_id',$page_id)->get('pagebuilder_page_rows')->row_array();
        return $row;
    }

    function updateRow(){
        $page_id = $this->input->post('page_id');
        $row_id = $this->input->post('row_id');
        unset($_POST['page_id']);
        unset($_POST['row_id']);
        $data = [];

        if($_POST["image"] != ''){
            $base64strcount = count($_POST["image"]);
            $image_format_type = explode(';base64',explode('data:image/',$_POST["image"])[1])[0];
            for ($i = 0; $i < $base64strcount; $i++) {
                $img_name = time() . "_" . rand(0, 999999) . "." . $image_format_type;
                $img_path = $this->config->item('BLOCK_IMAGE_PATH') . $img_name;
                $img = $_POST["image"];

                if (strpos($img, 'data:image') !== false) {
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $img = str_replace('data:image/jpg;base64,', '', $img);
                    $img = str_replace('data:image/jpeg;base64,', '', $img);
                    $img = str_replace('data:image/gif;base64,', '', $img);
                    $img = str_replace(' ', '+', $img);
                    $img_data = base64_decode($img);

                    $im = imagecreatefromstring($img_data);
                    if($image_format_type == 'png'){
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
                    // array_push($resize_image_arr, array("width" => "1000", "height" => "1000", "base_path" => $this->config->item('BLOCK_IMAGE_PATH')));
                    array_push($resize_image_arr, array("base_path" => $this->config->item('BLOCK_IMAGE_PATH')));

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

                        $_POST['image'] = $this->config->item('BLOCK_IMAGE_URL') . $img_name;
                        // $_POST['image'] = cdn('page/block_images/'.$img_name);
                        // $cdnImage = $img_name;
                        // self::runCmd($cdnImage);
                    }
                }
            }
        }


        $data['style_config'] = json_encode($this->input->post());
        $this->db->where('id',$row_id)->where('page_id',$page_id)->update('pagebuilder_page_rows',$data);
        return true;
    }

    public static function runCmd($cdnimg) {
        $basepath = dirname(FCPATH);
        $command = "/usr/bin/php5.6 " . $basepath . "/index.php cdn uploadPageBuilderImage $cdnimg &";
        $outputCommand = shell_exec($command);
    }

    public function savePageTemplate(){
        $page_id = $this->input->post('page_id');
        $template_name = $this->input->post('template_name');

        $template = [];
        $template['template_name'] = $template_name;
        $template['template_alias'] = $this->_slug($template_name);
        $this->db->insert('pagebuilder_templates',$template);
        $insert_id = $this->db->insert_id();

        if($insert_id){
            $page_rows = $this->db->where('page_id', $page_id)->order_by('id','ASC')->get('pagebuilder_page_rows')->result_array();
            $row_cols = [];
            if($page_rows){
                foreach($page_rows as $page_row){
                    $row_cols[$page_row['id']] = $page_row;
                    $row_cols[$page_row['id']]['columns'] = $this->db->where('page_id',$page_id)->where('row_id',$page_row['id'])->order_by('id','ASC')->get('pagebuilder_columns')->result_array();
                }
            }
            
            if($row_cols){
                foreach($row_cols as $row_col){
                    $template_row = [];
                    $template_row['template_id'] = $insert_id;
                    $template_row['layout_type'] = $row_col['layout_type'];
                    $template_row['element_config'] = $row_col['element_config'];
                    $template_row['style_config'] = $row_col['style_config'];
                    $template_row['sort_order'] = $row_col['sort_order'];
                    $this->db->insert('pagebuilder_template_rows',$template_row);
                    $row_id = $this->db->insert_id();

                    if($row_id){
                        if(isset($row_col['columns']) & $row_col['columns']){
                            foreach($row_col['columns'] as $row_column){
                                $template_column = [];
                                $template_column['template_id'] = $insert_id;
                                $template_column['row_id'] = $row_id;
                                $template_column['element_id'] = $row_column['element_id'];
                                $template_column['element_alias'] = $row_column['element_alias'];
                                // $template_column['content_config'] = $row_column['content_config'];
                                $template_column['style_config'] = $row_column['style_config'];
                                $this->db->insert('pagebuilder_template_columns',$template_column);
                                $column_id = $this->db->insert_id();
                            }
                        }
                    }
                }
            }
        }

        return true;
    }

    public function getPageTemplates(){
        return $this->db->get('pagebuilder_templates')->result_array();
    }

    public function removePageRowsAndColumns($page_id){
        $this->db->where('page_id', $page_id)->delete('pagebuilder_page_rows');
        $this->db->where('page_id', $page_id)->delete('pagebuilder_columns');
    }

    public function assignPageTemplate(){
        $page_id = $this->input->post('page_id');
        $template_id = $this->input->post('template_id');
        $template_rows = $this->db->where('template_id',$template_id)->order_by('id','ASC')->get('pagebuilder_template_rows')->result_array();

        $row_cols = [];
        if($template_rows){
            foreach($template_rows as $template_row){
                $row_cols[$template_row['id']] = $template_row;
                $row_cols[$template_row['id']]['columns'] = $this->db->where('template_id',$template_id)
                                                                ->where('row_id',$template_row['id'])
                                                                ->order_by('id','ASC')
                                                                ->get('pagebuilder_template_columns')->result_array();
            }
        }

        $this->removePageRowsAndColumns($page_id);

        if($row_cols){
            foreach($row_cols as $row_col){
                $page_row = []; 
                $page_row['page_id'] = $page_id;
                $page_row['layout_type'] = $row_col['layout_type'];
                $page_row['element_config'] = $row_col['element_config'];
                $page_row['style_config'] = $row_col['style_config'];
                $page_row['sort_order'] = $row_col['sort_order'];
                $this->db->insert('pagebuilder_page_rows',$page_row);
                $row_id = $this->db->insert_id();
                if($row_id){
                    if(isset($row_col['columns']) && $row_col['columns']){
                        foreach($row_col['columns'] as $column){
                            $page_column = [];
                            $page_column['page_id'] = $page_id;
                            $page_column['row_id'] = $row_id;
                            $page_column['element_id'] = $column['element_id'];
                            $page_column['element_alias'] = $column['element_alias'];
                            $page_column['content_config'] = $column['content_config'];
                            $page_column['style_config'] = $column['style_config'];
                            $page_column['is_temp'] = 1;
                            $this->db->insert('pagebuilder_columns',$page_column);
                        }
                    }
                }
            }
        }

        return true;
    }

    public function _slug($cname) {
        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`');
        $slug = $cname;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        $slug = url_title($slug, 'underscore', true);
        return $slug;
    }
}
