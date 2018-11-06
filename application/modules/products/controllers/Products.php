<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Products extends MX_Controller {

    public function __construct() {
        $this->load->library(['Module_settings']);
        $this->load->model(["mdl_products", "Mdl_products"]);
        $this->load->module(["template"]);
        $this->load->library("Uploader");
        $this->load->library('debugger');
    }

    public function index() {
        $data = $this->module_settings->page_settings("index", null, null, "products");
        $this->template->backend($data);
    }

    public function create() {
        if ($this->form_validation->run($this, 'products') == TRUE) {
            $this->_submit_data();
        }
        $data = $this->module_settings->page_settings("create", null, null, "products");
        $this->template->backend($data);
    }

    public function edit($id = null) {
        if (!is_numeric($id)) {
            redirect('/view');
        }
        if ($this->form_validation->run($this, 'products') == TRUE) {
            $this->_submit_data();
        }
        $product = $this->mdl_products->get_where($id)->row_array();
        //$this->module_settings->debug($product);
        $data = $this->module_settings->page_settings("create", $product, null, "products");
        $this->template->backend($data);
    }

    public function view() {
        $role = $this->session->role;
        $role_name = Modules::run("users/role/get_role_name", $role);
        $uid = $this->session->user_id;
        if (is_numeric($uid) && strtolower($role_name) == 'seller') {
            //if this is a seller
            $products = $this->Mdl_products->get_where_custom("seller_id", $uid);
        } else {
            $products = $this->Mdl_products->get('id');
        }
        $data = $this->module_settings->page_settings("view", $products->result(), 'products', "my products");
        $this->template->backend($data);
    }

    private function _get_data_from_post() {
        return array(
            'product' => $this->input->post("product"),
            'price' => $this->input->post("price"),
            'description' => $this->input->post("description"),
            'category_id' => $this->input->post("category"),
            'seller_id' => $this->session->user_id
        );
    }

    public function _submit_data() {
        //get data from post
        $data = $this->_get_data_from_post();
        $id = $this->uri->segment(3);
        //$this->debugger->debug($_FILES);
        if (isset($_FILES['preview']) && !empty($_FILES['preview']['name'][0])) {
            $data["preview"] = $this->uploader->upload_multiple('preview')->FileJsonSerialize();
        }

        if (is_numeric($id)) {
            //its an update
            if ($this->Mdl_products->_update($id, $data)) {
                $this->session->set_flashdata('success', "Product was updated successfully");
                redirect('products/view');
            }
        } else {
            //$this->debugger->debug($data);
            if ($this->Mdl_products->_insert($data)) {
                $this->session->set_flashdata('success', "New products was added successfully");
                redirect('products/view');
            }
        }
        $this->session->set_flashdata('error', "An error occured while trying to process data");
        redirect('products/create');
    }

}
