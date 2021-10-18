<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Splittestcore {

	function method_evenly($split_test) {
		$CI = & get_instance();
		$CI->load->model('split_test/Splittestmodel');
		$test_pages = $CI->Splittestmodel->getTestPages($split_test['test_id'], false);
		if (!$test_pages)
			return false;

		//Check for previous page served if any
		$cookie_data = $this->fetchCookieData($split_test);
		if ($cookie_data['cookie_test_page_id']) {
			$page_to_serve = $cookie_data['cookie_test_page_id'];
		} else {
			$test_pages_arr = array();
			foreach ($test_pages as $test_page) {
				$test_pages_arr[] = $test_page['page_id'];
			}

			$page_served = $CI->Splittestmodel->getMostRecentPage($split_test['test_id']);

			if (!$page_served) {
				$page_to_serve = $test_pages_arr[0];
			} else {
				$index = array_search($page_served['page_id'], $test_pages_arr);
				if ($index == (count($test_pages_arr) - 1)) {
					$page_to_serve = $test_pages_arr[0];
				} else {
					$page_to_serve = $test_pages_arr[$index + 1];
				}
			}
		}
		//fetch the 
		$page_details = $CI->Splittestmodel->fetchPageDetails($page_to_serve);

		if (!$cookie_data['repeat_visit']) {
			$uid = $this->setTestPageCookie($split_test, $page_details);
		} else {
			$uid = $cookie_data['uid'];
		}


		//fetch the widget page version
		//$page_details = $CI->Widgetmodel->fetchWidgets($page_details);
		$CI->Splittestmodel->splitTestLog($uid, $split_test, $page_details);

		return $page_details;
	}

	function method_50_plus_evenly($split_test) {
		$CI = & get_instance();
		$CI->load->model('split_test/Splittestmodel');
		$test_pages = $CI->Splittestmodel->getTestPages($split_test['test_id'], false);
		if (!$test_pages)
			return false;

		//fetch the control pages
		$control_page = $CI->Splittestmodel->getControlPage($split_test['test_id']);
		if (!$control_page)
			return false;
		
		//Check for previous page served if any
		$cookie_data = $this->fetchCookieData($split_test);
		if ($cookie_data['cookie_test_page_id']) {
			$page_to_serve = $cookie_data['cookie_test_page_id'];
		} else {
			$test_pages_arr = array();
			foreach ($test_pages as $test_page) {
				$test_pages_arr[] = $test_page['page_id'];
			}
			$page_to_serve = $control_page['page_id'];
			
			//fetch the most recent served test page
			$page_served = $CI->Splittestmodel->getMostRecentPage($split_test['test_id']);
			if ($page_served) {
				if ($page_served['page_id'] == $control_page['page_id']) {
					$index = array_search($page_served['page_id'], $test_pages_arr);
					if ($index == (count($test_pages_arr) - 1)) {
						$page_to_serve = $test_pages_arr[0];
					} else {
						$page_to_serve = $test_pages_arr[$index + 1];
					}
				}
			}
		}

		//fetch the 
		$page_details = $CI->Splittestmodel->fetchPageDetails($page_to_serve);
		if (!$cookie_data['repeat_visit']) {
			$uid = $this->setTestPageCookie($split_test, $page_details);
		} else {
			$uid = $cookie_data['uid'];
		}

		//fetch the widget page version
		//$page_details = $CI->Widgetmodel->fetchWidgets($page_details);
		$CI->Splittestmodel->splitTestLog($uid, $split_test, $page_details);

		return $page_details;
	}

	function method_randomly($split_test) {
		$CI = & get_instance();
		$CI->load->model('split_test/Splittestmodel');
		$test_pages = $CI->Splittestmodel->getTestPages($split_test['test_id'], true);
		if (!$test_pages)
			return false;
		
		//check for the conversion rate
		$hightest_conversed_page = array();
		$hightest_conversed_page = $CI->Splittestmodel->highestConvertingPage($split_test['test_id']);
		
		//Check for previous page served if any
		$cookie_data = $this->fetchCookieData($split_test);
		if ($cookie_data['cookie_test_page_id']) {
			$page_to_serve = $cookie_data['cookie_test_page_id'];
		} else {
			$test_pages_arr = array();
			foreach ($test_pages as $test_page) {
				$test_pages_arr[] = $test_page['page_id'];
			}

			$page_to_serve = $test_pages_arr[0];
			$page_served = $CI->Splittestmodel->getMostRecentPage($split_test['test_id']);
			if ($page_served) {
				if ($page_served['page_id'] == $test_pages_arr[0]) {
					$page_to_serve = $test_pages_arr[1];
				}
			}
		}
		
		//fetch the 
		$page_details = $CI->Splittestmodel->fetchPageDetails($page_to_serve);

		if (!$cookie_data['repeat_visit']) {
			$uid = $this->setTestPageCookie($split_test, $page_details);
		} else {
			$uid = $cookie_data['uid'];
		}

		//fetch the widget page version
		//$page_details = $CI->Widgetmodel->fetchWidgets($page_details);
		$CI->Splittestmodel->splitTestLog($uid, $split_test, $page_details);

		return $page_details;
	}

	function triggerConversion() {
		$CI = & get_instance();
		
		if ($CI->session->userdata('TEST_LOG_ID') && $CI->session->userdata('TEST_ID')) {
			//fetch the success url
			$success_urls = array();
			$CI->load->model('split_test/Splittestmodel');
			$rs = $CI->Splittestmodel->fetchSuccessURLs($CI->session->userdata('TEST_ID'));
			$success_urls  = array();
			if ($rs) {
				foreach ($rs as $item) {
					$match = array('{base_url}', '{base_url_ssl}', '{base_url_nossl}');
					$replace = array($CI->http->baseURL(), $CI->http->baseURLSSL(), $CI->http->baseURLNoSSL());
					$success_url = str_replace($match, $replace, $item['test_success_url']);
					$success_urls[] = $success_url;
				}
			}
			if ($success_urls && in_array(current_url(), $success_urls)) {
				return '<img src="split_test/track/' . $CI->session->userdata('TEST_LOG_ID') . '" width="1" height="1" />';
			}
		}
	}

	public function logConversion($test_log_id = 0) {
		$CI = & get_instance();

		if (!isset($_SERVER['HTTP_REFERER'])) {
			$this->sendPixelImage();
			return;
		}

		if (!$CI->session->userdata('TEST_LOG_ID')) {
			$this->sendPixelImage();
			return;
		}


		$blocked_ip_address = explode(',', DWS_BLOCKED_IP_ADDRESS);
		if (in_array($_SERVER['REMOTE_ADDR'], $blocked_ip_address)) {
			$this->sendPixelImage();
			return;
		}

		//var_dump($_SERVER['HTTP_REFFERER']); exit();
		//unset the session data
		$CI->session->unset_userdata('TEST_LOG_ID');
		$CI->session->unset_userdata('TEST_ID');
		$CI->session->unset_userdata('PAGE_ID');

		//update the
		$data = array();
		$data['test_log_id'] = $test_log_id;
		$data['conversion_url'] = $_SERVER['HTTP_REFERER'];
		$data['conversion_time'] = time();

		$CI->db->insert('test_conversion', $data);


		$this->sendPixelImage();
	}

	function sendPixelImage() {
		header('Content-Type: image/gif');
		echo file_get_contents('images/pixel.gif');
		exit();
	}

	//fetch the cookie data
	function fetchCookieData($split_test) {
		$CI = & get_instance();

		$data = array();
		$data['uid'] = 0;
		$data['repeat_visit'] = false;
		$data['cookie_test_page_id'] = false;
		if (isset($_COOKIE[$CI->config->item('COOKIE_NAME') . $split_test['test_id']])) {
			$cookie_value = $_COOKIE[$CI->config->item('COOKIE_NAME') . $split_test['test_id']];
			$cookie_value_arr = explode(':', $cookie_value);
			$data['uid'] = $cookie_value_arr[0];
			$data['repeat_visit'] = 1;
			$data['cookie_test_page_id'] = $cookie_value_arr[1];
		}
		return $data;
	}

	//set the cookies for test page
	function setTestPageCookie($split_test, $page_details) {
		$CI = & get_instance();

		//Generate UID for visitor
		$uid = md5(date("ymd-His-") . rand(1000, 9999));

		//store version id in cookie
		//set expiry of cookie to one year
		$cookie = array(
			'name' => $CI->config->item('COOKIE_NAME') . $split_test['test_id'],
			'value' => $uid . ':' . $page_details['page_id'],
			'expire' => '86500',
			'prefix' => 'ST_'
		);

		if ($CI->config->item('cookie_domain') != '') {
			$cookie['domain'] = $CI->config->item('cookie_domain');
		}

		//$this->input->set_cookie($cookie);
		$status = setcookie($cookie['name'], $cookie['value'], time() + $cookie['expire']);
		if ($status)
			return $uid;

		return FALSE;
	}

}

?>