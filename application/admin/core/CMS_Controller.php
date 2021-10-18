<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CMS_Controller extends CI_Controller {

    private $module_path = '';
    protected $user_type = false;
    protected $user_name = '';
    protected $member_data = false;
    protected $user_profile_id = false;

    function __construct() {
        parent::__construct();
        $this->module_path = realpath(APPPATH . '/views/' . $this->router->directory . '../');
        $this->load->vars(array('CI' => $this));
    }

    function getUser() {
        return $this->member_data;
    }

    function loadHead() {
        $file_name = $this->router->class . '_' . $this->router->method;
        $file_path = $this->module_path . "/views/headers/$file_name.php";
        if (file_exists($file_path)) {
            return $this->load->view("headers/" . $file_name, '', true);
        }
        return '';
    }

    function loadFooter() {
        $file_name = $this->router->class . '_' . $this->router->method;
        $file_path = $this->module_path . "/views/footers/$file_name.php";
        if (file_exists($file_path)) {
            return $this->load->view("footers/" . $file_name, '', true);
        }
        return '';
    }

    function getMeta() {
        $file_name = $this->router->class . '_' . $this->router->method;
        $file_path = $this->module_path . "/views/meta/$file_name.php";
        if (file_exists($file_path)) {
            return $this->load->view("meta/" . $file_name, '', true);
        }

        return '';
    }

    function getCSS() {
        //Minified
        global $DWS_MIN_CSS_ARR;
        $DWS_MIN_CSS_ARR = array_unique($DWS_MIN_CSS_ARR);
        if (count($DWS_MIN_CSS_ARR) > 0) {
            $css = join(",", $DWS_MIN_CSS_ARR);
            //echo '<link type="text/css" rel="stylesheet" href="'.$this->baseURL().'min/?f='.$css.'" />
            //';
            foreach ($DWS_MIN_CSS_ARR as $css) {
                echo '<link type="text/css" rel="stylesheet" href="' . $this->baseURL() . $css . '" />';
            }
        }

        global $DWS_CSS_ARR;
        $DWS_CSS_ARR = @array_unique($DWS_CSS_ARR);
        if($DWS_CSS_ARR) {
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
                echo '<script type="text/javascript" src="' . $this->baseURL() . $js . '"></script>';
            }
        }

        global $DWS_JS_ARR;
        $js_arr = array();
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
        $js_arr = array_unique($js_arr);
        $js_arr = array_unique($js_arr);
        if (count($js_arr) > 0) {
            foreach ($js_arr as $js) {
                echo '<script type="text/javascript" src="' . $this->baseURL() . $js . '"></script>';
            }
        }
    }

    function baseURL() {
        return base_url();
    }

    function baseURLNonSSL() {
        $url = $this->getBaseURL();
        return str_replace('https://', 'http://', $url);
    }

    function isAdmin() {
        return ($this->user_type == 'ADMIN');
    }

    function isCompany() {
        return ($this->user_type == 'COMPANY');
    }

    function isAccountType() {
        return ($this->user_profile_id == '3');
    }

    function getUserName() {
        return $this->user_name;
    }

    function getUserFullName() {
        return $this->member_data['first_name'] . ' ' . $this->member_data['last_name'];
    }

}

?>