<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Auth extends MX_Controller {

    private $confirm_registration;

    public function __construct() {
        parent::__construct();

        //load models
        $this->load->model(['mdl_auth']);

        //load all necessary helpers for this class
        $this->load->helper(['array']);

        $this->load->library(['Module_settings']);
        $this->load->module(['Template', 'Users']);

        $this->confirm_registration = false;
    }

    /*
     *  CONTROLLER PAGES
     * ========================================================================
     */

    public function backend() {
        if ($this->form_validation->run($this, 'alogin') == true) {
            if ($this->input->get('redirect') != null) {
                redirect($this->input->get('redirect'));
            } else {
                redirect('dashboard/');
            }
        }
        $data = $this->module_settings->page_settings('auth/login-view', null, null, 'Login Administrator', 'users/auth');
        $this->template->frontend($data);
    }

    public function login() {
        if ($this->form_validation->run($this, 'login') == true) {
            if ($this->input->get('redirect') != null) {
                redirect($this->input->get('redirect'), 'refresh');
            } else {
                redirect('dashboard/', 'refresh');
            }
        }
        $data = $this->module_settings->page_settings('auth/index', null, null, 'Login user', 'users');
        $this->template->middleend($data);
    }

    public function activate_account($token = null) {

        if (!is_null($token) && strlen($token) == 36) {
            $user = $this->db->where('token', $token)
                    ->update('users', ['token' => true, 'last_seen' => time()]);

            if ($user) {
                $this->session->set_flashdata('success', 'Account activation was successful. You can now log in.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Account activation was not successful. Please try again or contact administrator.');
            }
        } else {
            $this->session->set_flashdata('success', 'Invalid activation token');
        }

        redirect('users/meta-page');
    }

    public function results_page() {
        $data = $this->page_settings('auth/results-view', null, null, null, 'users/auth');
        $this->templates->frontend($data);
    }

    public function logout() {

        Modules::run('users/update_last_seen');

        //Destroy the session
        $this->session->sess_destroy();

        //Recreate the session
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->session->sess_create();
        } else {
            $this->session->sess_regenerate(true);
        }
        if (isset($_GET['redirect'])) {
            redirect(site_url($_GET['redirect']));
        }
        redirect(site_url('users/login'));
    }

    public function recovery() {
        if ($this->form_validation->run($this, 'recovery') == true) {
            if ($this->_reset_pword($this->input->post('email'))) {
                $this->session->set_flashdata('success', 'Password was reset successfully check email for new password');
            } else {
                $this->session->set_flashdata('error', 'Password was not changed successfully. Please try again');
            }
        }

        $data = $this->page_settings('recovery-view', null, null, 'Password recovery', 'auth');
        $this->templates->frontend($data);
    }

    public function change_password() {
        $this->form_validation->set_rules('pswd', 'Password', 'required');
        $this->form_validation->set_rules('pswd1', 'Password Confirmation', 'required|matches[pswd]');
        if ($this->form_validation->run($this) == true) {
            $data['pswd'] = $this->input->post('pswd');
            $id = $this->session->user_id;

            if ($this->mdl_auth->_update($id, $data)) {
                $this->session->set_flashdata('success', 'Password was updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Password was not updated. Please try again later');
            }
        }
        $data = $this->page_settings('change-pswd-view', null, null, 'Change password', 'auth');
        $this->templates->backend($data);
    }

    public function _reset_pword($email) {
        $this->load->helper('string');
        $data['pswd'] = random_string('alnum', 10);
        $result = $this->mdl_auth->get_where_custom('email', $email);
        $user_id = $result->row()->id;
        $this->mdl_auth->_update($user_id, $data);
        $data['user'] = $result->row()->full_name;

        return Modules::run('mail/send_mail', $email, $data, 'recovery');
    }

    /*
     * HELPERS
     * ========================================================================
     */

    public function _get_data_from_post() {
        $data['colname'] = $this->input->post('postname');

        return $data;
    }

    public function _get_data_from_db($id = null) {
        $returned = $this->$module->get_where($id);
        $data['postname'] = $returned->colname;

        return $data;
    }

    public function authenticate($email) {
        $msg = "";
        $pword = $this->input->post('pswd');

        $this->db->where('email', $email);
        $this->db->where('password', md5($pword));


        if ($this->users->get_confirm_status()) {
            $this->db->where('token', 1);
            $msg = "Account might have not been activated.";
        }
        $result = $this->mdl_auth->get();

        if ($result->num_rows() > 0) {
            $this->create_session($result->row()->id);
            return true;
        } else {

            $this->form_validation->set_message('authenticate', 'Invalid username or password.' . $msg);
            return false;
        }
    }

    public function authenticate_admin($email) {
        $pword = $this->input->post('pswd');

        $this->db->where('email', $email);
        $this->db->where('pswd', $pword);
        $result = $this->mdl_auth->get();

        if ($result->num_rows() > 0) {
            $this->create_session($result->row()->id, true);
            return true;
        } else {
            $this->form_validation->set_message('authenticate_admin', 'Invalid email or password ');
            return false;
        }
    }

    public function validate_email($email) {
        $result = $this->mdl_auth->get_where_custom('email', $email);
        if ($result->num_rows() > 0) {
            return true;
        } else {
            $this->form_validation->set_message('validate_email', 'Invalid email address or this email doesnt exist');
            return false;
        }
    }

    public function create_session($user_id, $admin = false) {
        $result = $this->mdl_auth->get_where($user_id)->row();
        $this->session->user_id = $result->id;
        $this->session->name = $result->full_name;
        $this->session->role = $result->role_id;
        $this->session->email = $result->email;
        $this->session->phone = $result->phone;
    }

    /*
     * PAGE SETTINGS
     * ========================================================================
     */

    public function page_settings($view_file, $view_data, $data_name = 'result', $page_title = null, $module = null) {
        $data[$data_name] = $view_data;
        $data['view_file'] = $view_file;
        $data['page_title'] = $page_title;
        if ($module != null) {
            $data['module'] = $module;
        }
        return $data;
    }

    public function debug($array) {
        echo '<pre>' . print_r($array, 1) . '</pre>';
        die();
    }

}
