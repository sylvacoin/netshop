<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users extends MX_Controller
{
    private $confirm_registration;

    public function __construct()
    {
        parent::__construct();
        //load models
        $this->load->model(['mdl_users']);

        //load all necessary helpers for this class
        $this->load->helper(['array']);

        //load the template
        $this->load->module(['template', 'guard']);
        $this->load->library(['module_settings']);

        $this->confirm_registration = false;
    }

    /*
     *  CONTROLLER PAGES
     * ========================================================================
     */

    public function index()
    {
        if (!is_numeric($this->session->user_id)) {redirect('login');}
        $this->view();
    }

    public function signup()
    {
        if ($this->form_validation->run($this, 'signup') == true) {
            $this->_submit_data();
        }

        $data = $this->page_settings('signup', null, null, 'Register to ' . SITENAME, 'users/users');
        $this->template->middleend($data);
    }

    public function profile($edit = '')
    {
        $this->guard->index();

        $id = is_numeric($this->uri->segment(3)) ? $this->uri->segment(3) : $this->session->user_id;
        if ($edit == 'edit') {
            if ($this->form_validation->run($this, 'profile') == true) {
                $this->_submit_data();
            }
            $result = $this->_get_data_from_db($id);
            $data = $this->page_settings('edit', $result, null, 'Edit profile', 'users');

        } else {
            $data['user'] = $this->db->where(['user_id' => $id])->get('users')->row();
            $data['view_file'] = 'profile';
        }
        $this->templates->backend($data);
    }

    public function edit($id = null)
    {
        if (!is_numeric($this->session->user_id)) {redirect('login');}
        if ($this->form_validation->run($this, 'profile') == true) {
            $this->_submit_data();
        }
        $result = $this->_get_data_from_db($id);
        $data = $this->page_settings('default', $result, null, 'Edit Profile', 'users');
        $this->templates->backend($data);
    }

    public function view($id = null)
    {
        if (!is_numeric($this->session->user_id)) {redirect('login');}
        //if id is not numeric then its not a specific item. get everything
        if (!is_numeric($id)) {
            $result = $this->_get('user_id');

            $data = $this->page_settings('view', $result, 'users', 'View users', 'users');
        } else {
            $result = $this->_get_where($id);
            $data = $this->page_settings('view', $result, 'users', 'View users', 'users');
        }
        //$this->load->view('view', $result);
        $this->templates->backend($data);
    }

    public function delete($id = null)
    {
        if (is_numeric($id)) {
            $this->_delete($id, 'mdl_users');
        }

        if ($this->input->get('redirect')) {
            redirect($this->input->get('redirect'));
        }

        redirect('users/view');

    }

    /*
     * AJAX FUNCTIONS
     * ========================================================================
     */

    /*
     * CRUD
     * =========================================================================
     */

    public function _get($order_by, $model = 'mdl_users')
    {
        $query = $this->$model->get($order_by);
        return $query;
    }

    public function _get_where($id, $model = 'mdl_users')
    {
        $query = $this->$model->get_where($id);
        return $query;
    }

    public function _get_where_custom($col, $value, $model = 'mdl_users')
    {
        $query = $this->$model->get_where_custom($col, $value);
        return $query;
    }

    public function _insert($data, $model = 'mdl_users')
    {
        if ($this->$model->_insert($data)) {

            if ($this->confirm_registration) {
                Modules::run('mail/send_mail', $data['email'], [
                    'name' => $data['name'],
                    'link' => site_url('users/validate/' . $data['token']),
                ], 'confirm_registration');
            } else {
                Modules::run('mail/send_mail', $data['email'], ['name' => $data['name']]);
            }
            $this->session->set_flashdata('success', 'Registration was successful. Please refer to your email for  account activation');
        } else {
            $this->session->set_flashdata('error', 'Registration failed please try again later');
        }
    }

    public function _update($id, $data, $model = 'mdl_users')
    {

        if ($this->$model->_update($id, $data)) {
            $this->session->set_flashdata('success', 'users was updated successfully');
        } else {
            $this->session->set_flashdata('error', 'users not updated please try again later');
        }
    }

    public function _delete($id, $model = 'mdl_users')
    {
        if ($this->$model->_delete($id)) {
            $this->session->set_flashdata('success', 'Data was deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Data was not deleted successfully please try again later');
        }
        if ($model == 'mdl_users') {
            redirect('users');
        }
    }

    public function _count_where($column, $value, $model = 'mdl_users')
    {
        $count = $this->$model->count_where($column, $value);
        return $count;
    }

    public function _get_max($model = 'mdl_users')
    {
        $max_id = $this->$model->get_max();
        return $max_id;
    }

    public function _custom_query($mysql_query, $model = 'mdl_users')
    {
        $query = $this->$model->_custom_query($mysql_query);
        return $query;
    }

    /*
     * WIDGETS
     * ========================================================================
     */

    public function generate_token()
    {
        return random_string('alnum', 36);
    }

    public function update_last_seen()
    {
        $id = $this->session->user_id;
        $this->db->where('id', $id);
        return $this->db->update('users', ['last_seen' => time()]);
    }

    /*
     * HELPERS
     * ========================================================================
     */
    public function get_confirm_status()
    {
        return $this->confirm_registration;
    }

    public function _get_data_from_post()
    {

        if ($this->confirm_registration) {
            $data['token'] = $this->generate_token();
        }
        $data['full_name'] = $this->input->post('fname');
        $data['password'] = md5($this->input->post('pswd'));
        $data['phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');

        $data['role_id'] = Modules::run('users/role/get_default_role');

        return $data;
    }

    public function _get_data_from_db($id = null, $model = 'mdl_users')
    {
        $returned = $this->$model->get_where($id)->row();

        $data['fname'] = $returned->name;
        $data['email'] = $returned->email;
        $data['phone'] = $returned->phone;
        $data['id'] = $returned->user_id;

        //$data['photo'] = $returned->image;
        return $data;
    }

    public function callback_is_unique_email()
    {
        $query_username = $this->_get_where_custom('email', $this->input->post('email'));
        if($query_username->num_rows() == 1){
            return false;
        }else{
            return true;
        }
    }

    public function _submit_data()
    {
        //get data from post
        $data = $this->_get_data_from_post();

        if (isset($_FILES['photo']) && $_FILES['photo']['name'] != null) {
            $data['image'] = Modules::run('uploader/upload', 'photo', 'profile');
        }

        $id = $this->uri->segment(3) == 'edit' ? $this->session->user_id : '';
        if (is_numeric($id)) {
            $this->_update($id, $data);
            Modules::run('auth/create_session', $this->session->user_id);
            redirect($this->uri->segment(3) == 'edit' ? 'users/profile' : 'users');
        } else {
            $this->_insert($data);
            redirect('users/login');
        }
    }

    public function get_dropdown_option($name, $selected, $extra, $where = null, $model = 'mdl_users')
    {
        $data = [];
        if ($where != null) {
            $this->db->where($where);
            $data = $this->$model->get();
        } else {
            $data = $this->$model->get();
        }
        if (count($data) > 0) {
            $options[null] = '--choose--';
            foreach ($data as $datum) {
                $options[$datum->user_id] = $datum->users;
            }
        } else {
            $options[] = 'No option has been added';
        }
        return form_dropdown($name, $options, $selected, $extra);
    }

    /*
     * PAGE SETTINGS
     * ========================================================================
     */

    public function page_settings($view_file, $view_data, $data_name = 'result', $page_title = null, $model = null)
    {
        if ($data_name == null) {
            $data = $view_data;
        } else {
            $data[$data_name] = $view_data;
        }
        $data['view_file'] = $view_file;
        $data['page_title'] = $page_title;
        if ($model != null) {
            $data['module'] = $model;
        }
        return $data;
    }

    public function debug($array)
    {
        echo '<pre>' . print_r($array, 1) . '</pre>';
        die();
    }

}
