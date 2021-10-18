<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class JSResource {

	private $resource = false;
	private $is_minified = true;
	private $is_file = true;
	private $is_footer = false;

	function __construct($resource, $is_file = true) {
		$this->resource = $resource;
		$this->is_file = $is_file;
	}

	function setMinified($status) {
		$this->is_minified = $status;
	}

	function isMinified() {
		return $this->is_minified;
	}

	function setEmbedInFooter($status) {
		$this->is_footer = $status;
	}

	function getEmbedInFooter($status) {
		return $this->is_footer;
	}

	function isFile() {
		return $this->is_file;
	}
}
?>