<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$config['EMAIL_CONFIG'] = array(
    'mailtype' => 'html',
);

//get path of various files upload in website
$config['UPLOAD_PATH'] = str_replace('\\', '/', realpath(BASEPATH . '../')) . '/upload/';
$config['UPLOAD_URL'] = $this->config['base_url'] . 'upload/';

$config['RESIZED_IMAGES_PATH'] = str_replace('\\', '/', realpath(BASEPATH . '../')) . '/images/resized/';
$config['RESIZED_IMAGES_URL'] = $this->config['base_url'] . 'images/resized/';

$config['DESIGNER_MAIN_IMAGES_PATH'] = $config['RESIZED_IMAGES_PATH'] . 'product_main_image/500_500/';
$config['DESIGNER_MAIN_IMAGES_URL'] = $config['RESIZED_IMAGES_URL'] . 'product_main_image/500_500/';

$config['DESIGNER_OTHER_IMAGES_PATH'] = $config['RESIZED_IMAGES_PATH'] . 'product_main_image/100_100/';
$config['DESIGNER_OTHER_IMAGES_URL'] = $config['RESIZED_IMAGES_URL'] . 'product_main_image/100_100/';

$config['PAGEBANNER_PATH'] = $config['UPLOAD_PATH'] . 'pagebanner/';
$config['PAGEBANNER_THUMBNAIL_PATH'] = $config['PAGEBANNER_PATH'] . 'thumbnails/';
$config['PAGEBANNER_URL'] = $config['UPLOAD_URL'] . 'pagebanner/';
$config['PAGEBANNER_THUMBNAIL_URL'] = $config['PAGEBANNER_URL'] . 'thumbnails/';

$config['PRODUCT_PATH'] = $config['UPLOAD_PATH'] . 'products/';
$config['PRODUCT_THUMBNAIL_PATH'] = $config['PRODUCT_PATH'] . 'thumbnails/';
$config['PRODUCT_URL'] = $config['UPLOAD_URL'] . 'products/';
$config['PRODUCT_THUMBNAIL_URL'] = $config['PRODUCT_URL'] . 'thumbnails/';

$config['CATEGORY_PATH'] = $config['UPLOAD_PATH'] . 'category/';
$config['CATEGORY_THUMBNAIL_PATH'] = $config['CATEGORY_PATH'] . 'thumbnails/';

$config['CATEGORY_URL'] = $config['UPLOAD_URL'] . 'category/';
$config['CATEGORY_THUMBNAIL_URL'] = $config['CATEGORY_URL'] . 'thumbnails/';

$config['CATEGORY_BANNER_PATH'] = $config['UPLOAD_PATH'] . 'category/banner/';
$config['CATEGORY_BANNER_URL'] = $config['UPLOAD_URL'] . 'category/banner/';

$config['IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'gallery/';
$config['IMAGE_THUMBNAIL_PATH'] = $config['IMAGE_PATH'] . 'thumbnails/';

$config['IMAGE_URL'] = $config['UPLOAD_URL'] . 'gallery/';
$config['IMAGE_THUMBNAIL_URL'] = $config['IMAGE_URL'] . 'thumbnails/';

$config['CASESTUDY_PATH'] = $config['UPLOAD_PATH'] . 'casestudies/';
$config['CASESTUDY_THUMBNAIL_PATH'] = $config['CASESTUDY_PATH'] . 'thumbnails/';

$config['CASESTUDY_URL'] = $config['UPLOAD_URL'] . 'casestudies/';
$config['CASESTUDY_THUMBNAIL_URL'] = $config['CASESTUDY_URL'] . 'thumbnails/';

$config['SLIDESHOW_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'slideshow/';
$config['SLIDESHOW_IMAGE_URL'] = $config['UPLOAD_URL'] . 'slideshow/';

$config['BLOCK_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'page/block_images/';
$config['BLOCK_IMAGE_URL'] = $config['UPLOAD_URL'] . 'page/block_images/';

$config['PAGE_BANNER_PATH'] = $config['UPLOAD_PATH'] . 'page/banner/';
$config['PAGE_BANNER_URL'] = $config['UPLOAD_URL'] . 'page/banner/';

$config['EMAIL_LOGO_PATH'] = $config['UPLOAD_PATH'] . 'email/headers/';
$config['EMAIL_LOGO_URL'] = $config['UPLOAD_URL'] . 'email/headers/';

$config['BRAND_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'brand/';
$config['BRAND_THUMBNAIL_PATH'] = $config['BRAND_IMAGE_PATH'] . 'thumbnails/140-75/';
$config['BRAND_IMAGE_URL'] = $config['UPLOAD_URL'] . 'brand/';
$config['BRAND_THUMBNAIL_URL'] = $config['BRAND_IMAGE_URL'] . 'thumbnails/140-75/';

$config['ATTRIBUTE_OPTION_ICON_PATH'] = $config['UPLOAD_PATH'] . 'attributes/options/images/';
$config['ATTRIBUTE_OPTION_ICON_URL'] = $config['UPLOAD_URL'] . 'attributes/options/images/';

$config['INVOICE_PATH'] = $config['UPLOAD_PATH'] . 'orders/invoices/';
$config['INVOICE_URL'] = $config['UPLOAD_URL'] . 'orders/invoices/';

$config['ORDER_PATH'] = $config['UPLOAD_PATH'] . 'orders/';
$config['ORDER_URL'] = $config['UPLOAD_URL'] . 'orders/';

$config['USP_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'usp/';
$config['USP_IMAGE_URL'] = $config['UPLOAD_URL'] . 'usp/';

$config['HOMECATEGORY_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'category/homepage/';
$config['HOMECATEGORY_IMAGE_URL'] = $config['UPLOAD_URL'] . 'category/homepage/';

// My code

$path = str_replace('\\', '/', realpath(BASEPATH . '../'));
$url = $this->config['base_url'];

$config['CATEGORY_ICON_PATH'] = $path . '/admin/category/icon/';
$config['CATEGORY_ICON_URL'] = $this->config['base_url'] . 'admin/category/icon/';

$config['AD_BANNER_PATH'] = $path . '/admin/adbanner_images/';
$config['AD_BANNER_URL'] = $url . 'admin/adbanner_images/';

$config['PDF_PATH'] = $config['UPLOAD_PATH'] . 'pdf/';
$config['PDF_URL'] = $config['UPLOAD_URL'] . 'pdf/';

$config['BROCHURES_PATH'] = $config['UPLOAD_PATH'] . 'brochures/';
$config['BROCHURES_URL'] = $config['UPLOAD_URL'] . 'brochures/';

$config['BLOG_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'blog/';
$config['BLOG_THUMBNAIL_PATH'] = $config['BLOG_IMAGE_PATH'] . 'thumbnails/236-133/';
$config['BLOG_IMAGE_URL'] = $config['UPLOAD_URL'] . 'blog/';
$config['BLOG_THUMBNAIL_URL'] = $config['BLOG_IMAGE_URL'] . 'thumbnails/236-133/';

$config['TEST_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'testimonial/';
$config['TEST_IMAGE_URL'] = $config['UPLOAD_URL'] . 'testimonial/';

$config['OFFER_BANNER_PATH'] = $config['UPLOAD_PATH'] . 'offers/';
$config['OFFER_BANNER_URL'] = $config['UPLOAD_URL'] . 'offers/';

$config['MENU_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'menu/';
$config['MENU_IMAGE_URL'] = $config['UPLOAD_URL'] . 'menu/';

$config['GALLERY_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'gallery/';
$config['GALLERY_IMAGE_URL'] = $config['UPLOAD_URL'] . 'gallery/';

$config['DOWNLOAD_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'pdf/icon/';
$config['DOWNLOAD_IMAGE_URL'] = $config['UPLOAD_URL'] . 'pdf/icon/';

$config['DOWNLOAD_PDF_PATH'] = $config['UPLOAD_PATH'] . 'pdf/';
$config['DOWNLOAD_PDF_URL'] = $config['UPLOAD_URL'] . 'pdf/';

$config['NEWS_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'news/';
$config['NEWS_THUMBNAIL_PATH'] = $config['NEWS_IMAGE_PATH'] . 'thumbnails/';
$config['NEWS_IMAGE_URL'] = $config['UPLOAD_URL'] . 'news/';
$config['NEWS_THUMBNAIL_URL'] = $config['NEWS_IMAGE_URL'] . 'thumbnails/';

$config['CONTACT_US_FILE_PATH'] = $config['UPLOAD_PATH'] . 'logo/';
$config['CONTACT_US_FILE_URL'] = $config['UPLOAD_URL'] . 'logo/';

$config['PROJECTS_IMAGE_PATH'] = $config['UPLOAD_PATH'] . 'projects/';
$config['PROJECTS_THUMBNAIL_PATH'] = $config['PROJECTS_IMAGE_PATH'] . 'thumbnails/';
$config['PROJECTS_IMAGE_URL'] = $config['UPLOAD_URL'] . 'projects/';
$config['PROJECTS_THUMBNAIL_URL'] = $config['PROJECTS_IMAGE_URL'] . 'thumbnails/';

$config['LINE_DROWING_PATH'] = $config['UPLOAD_PATH'] . 'linedrowing/';
$config['LINE_DROWING_URL'] = $config['UPLOAD_URL'] . 'linedrowing/';
