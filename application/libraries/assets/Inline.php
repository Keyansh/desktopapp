<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inline extends Asset {

    private $resource = false;
    private $is_file = false;
    private $in_head = false;

    function __construct($resource) {
        $this->resource = $resource;
    }

    function setInHead($header) {
        $this->in_head = $header;
    }

    function inHead() {
        return $this->in_head;
    }

    function render() {
        $CI = & get_instance();
        echo $this->resource . "\r\n";
    }

}

?>