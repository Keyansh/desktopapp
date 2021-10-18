<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Utility {
	var $CI;

    function __construct() {
		$this->CI =& get_instance();
		log_message('debug', "Utility Class Initialized");
	}
	
	function show404() {
		$inner = array();
		$page = array();
		$page['title'] = 'Page Not Found';
		$page['content'] = $this->CI->load->view('pages/404', $inner, true);
		$this->CI->load->view('shell', $page);
	}
	
	function accessDenied() {
		$inner = array();
		$page = array();
		$page['title'] = 'Access Denied';
		$page['content'] = $this->CI->load->view('pages/access-denied', $inner, true);
		$this->CI->load->view('shell', $page);
	}
	
}
?>