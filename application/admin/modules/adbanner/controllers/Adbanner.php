<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Adbanner extends Admin_Controller
{
    function __construct() {
        parent::__construct();
        $this->is_admin_protected = TRUE;
        $this->load->model('Adbanner_model');
    }

    function index() {
        $banners = array();
        $banners = $this->Adbanner_model->get_banners();

        $inner = array();
        $inner['banners'] = $banners;

        $page = array();
        $page['content'] = $this->load->view('adbanner-listing', $inner, TRUE);
        $this->load->view('shell', $page);
    }

    function add() {
        $this->form_validation->set_rules('link', 'Button Link', 'trim|required');
        $this->form_validation->set_rules('heading', 'Banner Heading', 'trim|required');
        $this->form_validation->set_rules('description', 'Banner Description', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('adbanner-add', $inner, TRUE);
            $this->load->view('shell', $page);
        } else {
            $this->Adbanner_model->insert_record();
            $this->session->set_flashdata('SUCCESS', 'banner_added');
            redirect("adbanner");
            exit();
        }
    }

    function edit($id) {
        $banner = array();
        $banner = $this->Adbanner_model->get_banner($id);

        if (!$banner) {
            $this->utility->show404();
            return;
        }

        $this->form_validation->set_rules('link', 'Button Link', 'trim|required');
        $this->form_validation->set_rules('heading', 'Banner Heading', 'trim|required');
        $this->form_validation->set_rules('description', 'Banner Description', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            $inner = array();
            $inner['banner'] = $banner;

            $page = array();
            $page['content'] = $this->load->view('adbanner-edit', $inner, TRUE);

            $this->load->view('shell', $page);
        } else {
            $this->Adbanner_model->update_record($banner);
            $this->session->set_flashdata('SUCCESS', 'banner_updated');
            redirect("adbanner");
            exit();
        }
    }

    function delete($id) {
        $banner = array();
        $banner = $this->Adbanner_model->get_banner($id);

        if (!$banner) {
            $this->utility->show404();
            return;
        }

        $this->Adbanner_model->delete_record($id);
        $this->session->set_flashdata('SUCCESS', 'banner_deleted');
        redirect('adbanner/index/');
        exit();
    }

    function toggle()
    {
        $id = $this->input->post('id');

        $sql = "UPDATE br_ad_banner SET active = active XOR 1 where id = '$id'";
        $status = $this->db->query($sql);

        echo 'done';
    }

    function imgsave() {
        $imagePath = "temp/";
        $allowedExts = array("jpeg", "jpg", "JPEG", "JPG", "png");
        $temp = explode(".", $_FILES["img"]["name"]);
        $extension = end($temp);

        if (!is_writable($imagePath)) {
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t upload File; no write Access'
            );
            print json_encode($response);
            return;
        }

        if (in_array($extension, $allowedExts)) {
            if ($_FILES["img"]["error"] > 0) {
                $response = array(
                    "status" => 'error',
                    "message" => 'ERROR Return Code: ' . $_FILES["img"]["error"],
                );
            } else {

                $filename = $_FILES["img"]["tmp_name"];
                list($width, $height) = getimagesize($filename);

                move_uploaded_file($filename, $imagePath . $_FILES["img"]["name"]);
                $response = array(
                    "status" => 'success',
                    "url" => $imagePath . $_FILES["img"]["name"],
                    "width" => $width,
                    "height" => $height
                );
            }
        } else {
            $response = array(
                "status" => 'error',
                "message" => 'something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini',
            );
        }

        echo json_encode($response);
    }

    function imgcrop() {
        $imgUrl = $_POST['imgUrl'];
        $imgInitW = $_POST['imgInitW'];
        $imgInitH = $_POST['imgInitH'];
        $imgW = $_POST['imgW'];
        $imgH = $_POST['imgH'];
        $imgY1 = $_POST['imgY1'];
        $imgX1 = $_POST['imgX1'];
        $cropW = $_POST['cropW'];
        $cropH = $_POST['cropH'];
        $angle = $_POST['rotation'];
        $jpeg_quality = 100;

        $temp1 = explode("/", $_POST['imgUrl']);
        $image_name_with_ext = end($temp1);
        $temp2 = explode(".", $image_name_with_ext);
        $output_filename = "adbanner_images/" . current($temp2);
        $what = getimagesize($imgUrl);

        switch (strtolower($what['mime'])) {
            case 'image/png':
                $img_r = imagecreatefrompng($imgUrl);
                $source_image = imagecreatefrompng($imgUrl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($imgUrl);
                $source_image = imagecreatefromjpeg($imgUrl);
                error_log("jpg");
                $type = '.jpg';
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($imgUrl);
                $source_image = imagecreatefromgif($imgUrl);
                $type = '.gif';
                break;
            default: die('image type not supported');
        }

        if (!is_writable(dirname($output_filename))) {
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t write cropped File'
            );
        } else {
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            $rotated_image = imagerotate($resizedImage, -$angle, 0);
            $rotated_width = imagesx($rotated_image);
            $rotated_height = imagesy($rotated_image);
            $dx = $rotated_width - $imgW;
            $dy = $rotated_height - $imgH;
            $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
            imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
            imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
            imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
            imagejpeg($final_image, $output_filename . $type, $jpeg_quality);
            $response = Array(
                "status" => 'success',
                "url" => $output_filename . $type,
                "des_image" => '<input type="hidden" value="' . $image_name_with_ext . '" name="image">'
            );
        }
        print json_encode($response);
    }

}

// End of adbanner.php
