<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Role extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_role');
        $this->load->module(['templates', 'guard']);
        //$this->configurations->isUserLoggedIn();
    }

    /*
     *  SITE PAGES
     */

    public function index()
    {
        $this->guard->index();
        $data = $this->page_settings('role/default', null, null, 'Roles manager');
        $this->templates->backend($data);
    }

    public function view()
    {
        $data['roles'] = $this->mdl_role->get();
        $this->load->view('role/view', $data);
    }

    public function add()
    {
        if ($this->form_validation->run($this, 'role') == true) {
            $this->submit_data();
        }

        $this->load->view('add');
    }

    public function edit($id)
    {
        if ($this->form_validation->run($this, 'role') == true) {
            $this->submit_data();
        } else {
            $data = $this->page_settings('role/default', $this->get_profile_from_db($id), null, 'Roles manager');
            $this->templates->backend($data);
        }
    }

    public function delete($id)
    {
        if (!is_numeric($id)) {
            redirect('role/', 'refresh');
        }
        $this->_delete($id);
        redirect('role/', 'refresh');
    }

    public function profile($id)
    {
        if (!is_numeric($id)) {
            redirect('');
        }
        $data['customer'] = $this->get_where($id);
        $data['view_file'] = 'profile';
        $this->templates->admin($data);
    }

    public function submit_data()
    {
        //get data from post
        $data = $this->get_data_from_post();
        $id = $this->uri->segment(3);
        $this->db->or_where($data);
        $count = $this->db->get('roles')->num_rows();
        if ($count > 0 && !is_numeric($id)) {
            $this->session->set_flashdata('error', 'This role already exist.');
            redirect('role/', 'refresh');
        }
        if (is_numeric($id)) {
            $this->_update($id, $data);
            $this->_set_default($id);
            redirect('role/', 'refresh');
        } else {
            $this->_insert($data);
            $this->_set_default($this->db->insert_id());
            redirect('role/', 'refresh');
        }
//            }
    }

    /*
     *  HELPER FUNCTIONS
     */

    public function get_priv($priv)
    {
        $privileges = [
            'cm_users' => 'can manage users',
            'cm_roles' => 'can manage roles',
            'cm_site' => 'can manage site',
            'cm_posts' => 'can manage posts',
            'cs_sms' => 'can send sms',
        ];

        return $privileges[$priv];
    }

    public function get_data_from_post()
    {
        $data['role'] = $this->input->post('roles');
        $data['priv'] = serialize($this->input->post('priv'));

        return $data;
    }

    public function _set_default($id, $defaultPostName = 'default')
    {
        if ($this->input->post($defaultPostName) == 1 || $defaultPostName == 1) {
            $this->db->where('is_default', 1);
            $this->db->update('role', ['is_default' => null]);

            $this->db->where('role_id', $id);
            return $this->db->update('role', ['is_default' => 1]);
        }
    }

    public function set_default($id)
    {
        $this->guard->index();
        if ($this->_set_default($id, 1)) {
            $this->session->set_flashdata('success', 'Role was set to default succesfully');
        } else {
            $this->session->set_flashdata('error', 'Role was not set to default please try again');
        }
        redirect('role/', 'refresh');
    }

    public function can_role_do($id, $action)
    {
        $this->db->where('role_id', $id);
        $role = $this->db->get('roles')->row();
        return in_array($action, unserialize($role->priv));
    }

    public function get_role_privilege($role_id)
    {
        $role = $this->_get_where($role_id)->row();
        return unserialize($role->priv);
    }

    public function get_role_name($role_id)
    {
        $role = $this->_get_where($role_id)->row();
        return $role->role;
    }

    public function get_default_role()
    {
        $this->db->where('is_default', 1);
        $role = $this->db->get('roles')->row();
        return $role->id;
    }

    public function get_profile_from_db($id)
    {
        $this->load->model('mdl_role');
        $returned = $this->mdl_role->get_where($id)->row();

        $data['role'] = $returned->role;
        $data['priv'] = unserialize($returned->priv);
        $data['default'] = $returned->is_default;
        $data['id'] = $id;

        return $data;
    }

    /*
     * CRUD OPERATIONS
     * ==========================================================================
     */
    public function _insert($data)
    {
        $this->load->model('mdl_role');
        if ($this->mdl_role->_insert($data)) {
            $this->session->set_flashdata('success', 'New role was added successfully');
        } else {
            $this->session->set_flashdata('error', 'No role was added.');
        }
    }

    public function _update($id, $data)
    {
        $this->load->model('mdl_role');
        if ($this->mdl_role->_update($id, $data)) {
            $this->session->set_flashdata('success', 'update successfully');
        } else {
            $this->session->set_flashdata('error', 'update failed.');
        }
    }

    public function _delete($id)
    {
        $this->load->model('mdl_role');
        if ($this->mdl_role->_delete($id)) {
            $this->session->set_flashdata('success', 'Deletion was successful');
        } else {
            $this->session->set_flashdata('error', 'Data was not deleted.');
        }
    }

    private function _get_where($id, $col = null)
    {
        $this->load->model('mdl_role');
        $result = $this->mdl_role->get_where($id, $col);
        return $result;
    }

    public function count_where($column, $value)
    {
        $this->load->model('mdl_role');
        $count = $this->mdl_role->count_where($column, $value);
        return $count;
    }

    public function get_max()
    {
        $this->load->model('mdl_role');
        $max_id = $this->mdl_role->get_max();
        return $max_id;
    }

    public function _custom_query($mysql_query)
    {
        $this->load->model('mdl_role');
        $query = $this->mdl_role->_custom_query($mysql_query);
        return $query;
    }

    public function get_dropdown_option($name, $selected, $extra, $where = null, $model = 'mdl_role')
    {
        $items = [];
        if ($where != null) {
            $this->db->where($where);
            $items = $this->$model->get();
        } else {
            $items = $this->$model->get()->result();
        }
        if (count($items) > 0) {
            $data[null] = '-choose role-';
            foreach ($items as $item) {
                $data[$item->id] = $item->role_name;
            }
        } else {
            $data[] = 'No option has been added';
        }
        return form_dropdown($name, $data, $selected, $extra);
    }

    /*
     * PAGE SETTINGS
     * ========================================================================
     */

    public function page_settings($view_file, $view_data, $data_name = 'result', $page_title = null, $module = 'users')
    {
        if ($data_name == null) {
            $data = $view_data;
        } else {
            $data[$data_name] = $view_data;
        }
        $data['view_file'] = $view_file;
        $data['page_title'] = $page_title;
        if ($module != null) {
            $data['module'] = $module;
        }
        return $data;
    }

    public function debug($array)
    {
        echo '<pre>' . print_r($array, 1) . '</pre>';
        die();
    }

}
