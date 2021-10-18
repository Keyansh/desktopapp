<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gallery extends Cms_Controller {

    protected $casestudy_id = false;
    public $details = false;

    function __construct() {
        parent::__construct();
        $this->load->model('Pagemodel');
        $this->load->model('Gallerymodel');
        $this->load->library('pagination');
    }

    function index() {

        
        $gallery = $this->Gallerymodel->listAllGallery();

        $inner = array();
        $inner['gallery'] = $gallery;

        $this->load->view("meta/project-listing", $inner);
        $gallery_view = $this->load->view('project-listing', $inner, true);
        $shell['contents'] = $gallery_view;
        $this->load->view("themes/" . THEME . "/templates/default", $shell);
    }


}

?>
