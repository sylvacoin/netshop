<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Categories extends MX_Controller
{
    public function __construct()
    {
        $this->load->library(['Module_settings']);
        $this->load->model(["Mdl_categories"]);
        $this->load->module(["template"]);
    }

    public function index()
    {
        //for front page
        $data = $this->module_settings->page_settings("index", null, null, "products");
        $this->template->backend($data);
    }

    public function create()
    {
        if ($this->form_validation->run($this, 'categories') == true) {
            $this->_submit_data();
        }
        $list = $this->Mdl_categories->get_where(0, 'parent_id')->result();
        
        $data = $this->module_settings->page_settings("create", null, null, "categories");
        $data['catOptions'] = $this->module_settings->get_dropdown_option('parent_id', $list, 'id', 'category', null, 'class="form-control"');
        
        $this->template->backend($data);
    }

    public function edit($id)
    {
        if (!is_numeric($id)){ redirect('categories/view'); }

        $item = $this->_get_data_from_db($id);
        if ($this->form_validation->run($this, 'categories') == true) {
            $this->_submit_data();
        }
        $list = $this->Mdl_categories->get_where(['parent_id'=>0, 'id !=' => $id])->result();
        $data = $this->module_settings->page_settings("edit", $item, null, "categories");
        $data['catOptions'] = $this->module_settings->get_dropdown_option('parent_id', $list, 'id', 'category', $item['parent_id'], 'class="form-control"');
        $this->template->backend($data);
    }

    public function view()
    {
        $data = $this->Mdl_categories->get('id');
        $data = $this->module_settings->page_settings("view", $data->result(), 'categories', "Categories");
        $this->template->backend($data);
    }

    public function delete( $id )
    {
        if ( $this->Mdl_categories->_delete($id))
        {
            $this->session->set_flashdata('success', "Category was deleted successfully");
        }else{
            $this->session->set_flashdata('error', "Category was not deleted. Please try again");
        }
       
        redirect('categories/view');
    }

    public function _submit_data()
    {
        //get data from post
        $data = $this->_get_data_from_post();

        $id = $this->uri->segment(3);
        if (is_numeric($id)) {
            //its an updata
            if ($this->Mdl_categories->_update($id, $data)) {
                $this->session->set_flashdata('success', "Category was updated successfully");
                redirect('categories/view');
            }
        } else {
            if ($this->Mdl_categories->_insert($data)) {
                $this->session->set_flashdata('success', "New category was added successfully");
                redirect('categories/view');
            }
        }
        $this->session->set_flashdata('error', "An error occured while trying to process data");
        redirect('categories/create');
    }

    public function _get_data_from_post()
    {
        $data['category'] = $this->input->post('category');
        $data['parent_id'] = $this->input->post('parent_id');
        $data['icon'] = $this->input->post('icon');

        return $data;
    }

    public function _get_data_from_db($id)
    {
        $row = $this->Mdl_categories->get_where($id)->row();
        $data['category'] = $row->category;
        $data['parent_id'] = $row->parent_id;
        $data['icon'] = $row->icon;
        return $data;
    }
}
