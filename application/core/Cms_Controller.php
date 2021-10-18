<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms_Controller extends CI_Controller {

    protected $user_data = false;
    private $module_path = '';
    private $modules_folder = '';
    private $page = false;

    function __construct() {
        parent::__construct();
        $this->module_path = realpath(APPPATH . '/views/' . $this->router->directory . '../');
        $this->modules_folder = realpath(APPPATH . '/modules/');
        $this->init();
        //$this->output->enable_profiler(TRUE);
    }

    private function checkLogin() {
        $userid = $this->session->userdata('CUSTOMER_ID');

        if (isset($userid) && (trim($userid) != '') && is_numeric($userid)) {
            $this->load->model('customer/Customermodel');
            $user = $this->Customermodel->fetchByID($userid);
            if ($user) {
                $this->user_data = $user;
                return TRUE;
            }
            $this->session->unset_userdata('CUSTOMER_ID');
        }

        return FALSE;
    }

    function init() {
        $this->load->model('catalog/Categorymodel');
        //fetch the categories
        $segment_1 = $this->uri->segment(1);
        $segment_2 = $this->uri->segment(2);
        $current_category = '';
        if ($segment_1 == 'catalog' && $segment_2 == 'category') {
            $current_category = $this->uri->segment(3);
        }
        $ul = $this->Categorymodel->getCategories($current_category, 0);
        $this->load->vars(array('CATEGORIES' => $ul));
    }

    function setPage($page) {
        $this->page = $page;
    }

    function getPage() {
        return $this->page;
    }

    function getUser() {
        return $this->user_data;
    }

    function getCSS() {
        //Minified
        global $DWS_MIN_CSS_ARR;
        /* $DWS_MIN_CSS_ARR = array_unique($DWS_MIN_CSS_ARR);
          if(count($DWS_MIN_CSS_ARR) > 0) {
          $css = join(",", $DWS_MIN_CSS_ARR);
          echo '<link type="text/css" rel="stylesheet" href="'.$this->baseURL().'min/?f='.$css.'" />
          ';
          } */

        //Minify disabled
        if ($DWS_MIN_CSS_ARR) {
            $DWS_CSS_ARR = array_unique($DWS_MIN_CSS_ARR);
            if (count($DWS_CSS_ARR) > 0) {
                foreach ($DWS_CSS_ARR as $css) {
                    echo '<link type="text/css" rel="stylesheet" href="' . $this->baseURL() . $css . '" />
				';
                }
            }
        }

        global $DWS_CSS_ARR;
        if ($DWS_CSS_ARR) {
            $DWS_CSS_ARR = array_unique($DWS_CSS_ARR);
            if (count($DWS_CSS_ARR) > 0) {
                foreach ($DWS_CSS_ARR as $css) {
                    echo '<link type="text/css" rel="stylesheet" href="' . $this->baseURL() . $css . '" />
				';
                }
            }
        }
    }

    function getJS() {
        //Minified
        global $DWS_MIN_JS_ARR;
        $js_arr = array();
        foreach ($DWS_MIN_JS_ARR as $temp) {
            if (is_array($temp) && count($temp) == 2) {
                if ($this->CI->agent->is_mobile) {
                    $js_arr[] = $temp[1];
                } else {
                    $js_arr[] = $temp[0];
                }
            } else {
                $js_arr[] = $temp;
            }
        }
        $js_arr = array_unique($js_arr);
        if (count($js_arr) > 0) {
            /* $js = join(",", $js_arr);
              echo '<script type="text/javascript" src="'.$this->baseURL().'min/?f='.$js.'"></script>
              '; */
            foreach ($js_arr as $js) {
                echo '<script type="text/javascript" src="' . $this->baseURL() . $js . '"></script>
				';
            }
        }

        global $DWS_JS_ARR;
        $js_arr = array();
        if ($DWS_JS_ARR) {
            foreach ($DWS_JS_ARR as $temp) {
                if (is_array($temp) && count($temp) == 2) {
                    if ($this->CI->agent->is_mobile) {
                        $js_arr[] = $temp[1];
                    } else {
                        $js_arr[] = $temp[0];
                    }
                } else {
                    $js_arr[] = $temp;
                }
            }
        }
        $js_arr = array_unique($js_arr);
        $js_arr = array_unique($js_arr);
        if (count($js_arr) > 0) {
            foreach ($js_arr as $js) {
                echo '<script type="text/javascript" src="' . $this->baseURL() . $js . '"></script>
				';
            }
        }
    }

    function baseURL() {
        $url = base_url();
        $https = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : 0;
        $https = strtolower($https);
        if (($https == 'on' || $https == 1)) {
            return str_replace('http://', 'https://', $url);
        }

        return $url;
    }

    function baseURLNoSSL() {
        $url = $this->baseURL();
        return str_replace('https://', 'http://', $url);
    }

    function baseURLSSL() {
        $url = $this->baseURL();
        return str_replace('http://', 'https://', $url);
    }

    function getMeta() {
        $file_name = $this->router->class . '_' . $this->router->method;
        $file_path = $this->module_path . "/views/meta/$file_name.php";
        if (file_exists($file_path)) {
            return $this->load->view("meta/" . $file_name, '', true);
        }

        $page = $this->getPage();
        if ($page) {
            $file_name = str_replace('/', '_', $page['page_uri']);
            $file_path = "application/views/" . THEME . "/meta/" . $file_name . ".php";
            if (file_exists($file_path)) {
                return $this->load->view("themes/" . THEME . "/meta/" . $file_name, array('page' => $page), true);
            }

            return $this->load->view("themes/" . THEME . "/meta/meta.php", array('page' => $page), true);
        }

        return '';
    }

    function loadHeaders() {
        $output = '';
        $file_name = $this->router->class . '_' . $this->router->method;
        $file_path = $this->module_path . "/views/headers/$file_name.php";
        if (file_exists($file_path)) {
            $output .= $this->load->view("headers/" . $file_name, array(), true);
        }

        $page = $this->getPage();
        if ($page) {
            $file_name = str_replace('/', '_', $page['page_uri']);
            $file_path = "application/views/themes/" . THEME . "/headers/" . $file_name . ".php";
            if (file_exists($file_path)) {
                $output .= $this->load->view("themes/" . THEME . "/headers/" . $file_name, array(), true);
            }
        }
        return $output;
    }

    function loadFooters() {
        $output = '';
        $file_name = $this->router->class . '_' . $this->router->method;
        $file_path = $this->module_path . "/views/footers/$file_name.php";
        if (file_exists($file_path)) {
            $output .= $this->load->view("footers/" . $file_name, array(), true);
        }

        $page = $this->getPage();
        if ($page) {
            $file_path = "application/views/" . THEME . "/footers/" . str_replace('/', '_', $page['page_uri']) . ".php";
            if (file_exists($file_path)) {
                $output .= $this->load->view("themes/" . THEME . "/footers/" . $file_name, array(), true);
            }
        }
        return $output;
    }

    function bodyClass() {
        $output = array();
        $page = $this->load->get_var('page');
        if (isset($page)) {
            $output[] = 'page_' . $page['page_alias'];
        }
        if ($this->agent->is_mobile) {
            $output[] = 'ua_mobile';
        } else {
            $output[] = 'ua_desktop';
        }

        $browser = @get_browser(null, true);
        if ($browser && isset($browser['javascript'])) {
            if ($browser['javascript'] == 1) {
                $output[] = 'js';
            } else {
                $output[] = 'no_js';
            }
        }

        return join(' ', $output);
    }

    function isMobile() {
        return $this->agent->is_mobile();
    }

    function isHome() {
        if ($this->page_alias == 'homepage') {
            return true;
        }

        return false;
    }

    function menu($params) {
        $this->load->model('Menumodel');
        return $this->Menumodel->menu($params);
    }

}

/* End of file cms.php */
/* Location: ./application/libraries/cms.php */
?>