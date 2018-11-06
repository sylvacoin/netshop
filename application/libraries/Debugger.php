<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Debugger {

    protected $CI;

    public function __construct() {
        // Assign the CodeIgniter super-object
        $this->CI = & get_instance();
    }

    public function debug($array, $dump = false) {
        if ($dump) {
            var_dump($array);
            die();
        }

        echo '<pre>' . print_r($array, true) . '</pre>';
        die();
    }

    public function tempDebug($array, $dump = false) {
        if ($dump) {
            var_dump($array);
        }

        echo '<pre>' . print_r($array, true) . '</pre>';
    }

}
