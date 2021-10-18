<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function ar($image_url, $width, $height, $photoset_id = '') {
	require_once APPPATH . 'third_party/phpthumb/ThumbLib.inc.php';

	$CI = & get_instance();
	 

	$image_folder = $CI->config->item('RESIZED_IMAGES_PATH') . "$photoset_id/";
	$resized_images_url = $CI->config->item('RESIZED_IMAGES_URL') . "$photoset_id/";
	$size_folder = $width."_".$height;
	$image_name = basename($image_url);

	//return $image_folder.$size_folder;

	if(!file_exists($image_folder.$size_folder)) {
		mkdir($image_folder.$size_folder, 0755, true);
	}

	if(file_exists($image_folder.$size_folder."/$image_name")) {
		return $resized_images_url.$size_folder."/$image_name";
	}

	try {
		$thumb = PhpThumbFactory::create($image_url);
		$thumb->adaptiveResize($width, $height)->save($image_folder.$size_folder."/$image_name");
	    return $resized_images_url.$size_folder."/$image_name";
	}catch (Exception $e) {
		
	}
	return '';
}

function resize($image_url, $width, $height, $photoset_id = '') {
	require_once APPPATH . 'third_party/phpthumb/ThumbLib.inc.php';

	$CI = & get_instance();

	$image_folder = $CI->config->item('RESIZED_IMAGES_PATH') . "$photoset_id/";
	$resized_images_url = $CI->config->item('RESIZED_IMAGES_URL') . "$photoset_id/";
	$size_folder = $width."_".$height;
	$image_name = basename($image_url);

	//return $image_folder.$size_folder;

	if(!file_exists($image_folder.$size_folder)) {
		@mkdir($image_folder.$size_folder, 0755, true);
	}

	if(file_exists($image_folder.$size_folder."/$image_name")) {
		return $resized_images_url.$size_folder."/$image_name";
	}

	try {
		$thumb = PhpThumbFactory::create($image_url, array('jpegQuality' => 100));
		$thumb->resize($width, $height)->save($image_folder.$size_folder."/$image_name");
	    return $resized_images_url.$size_folder."/$image_name";
	}catch (Exception $e) {

	}
	return '';
}
?>