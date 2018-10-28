<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Dashboard extends MX_Controller
{
    public function __construct()
    {
        $this->load->library(['Module_settings']);
        $this->load->module(["template"]);
    }

    public function index()
    {
        $data = $this->module_settings->page_settings("index",null, null, "dashboard");
        $this->template->backend($data);
    }
}
