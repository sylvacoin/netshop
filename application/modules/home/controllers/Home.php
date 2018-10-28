<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends MX_Controller {

    public function __construct() {
        $this->load->library(['Module_settings']);
        $this->load->module(['Template']);
    }

    public function index() {
        $data = $this->module_settings->page_settings('index', null, null, 'Welcome', 'home');
        $this->template->frontend($data);
    }

    public function authenticate($uname) {
        $pword = $this->input->post('pswd');

        $this->db->where('username', $uname);
        $this->db->where('pswd', $pword);
        $result = $this->mdl_auth->get();

        if ($result->num_rows() > 0) {
            $this->create_session($result->row()->user_id);
            return true;
        } else {
            $this->form_validation->set_message('authenticate', 'Invalid username or password');
            return false;
        }
    }

}
