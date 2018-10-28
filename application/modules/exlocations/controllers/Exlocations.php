<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Exlocations extends MX_Controller
{
    public function __construct()
    {
        $this->load->library(['Module_settings']);
        $this->load->model(["Mdl_exlocations"]);
        $this->load->module(["template"]);
    }

    public function index()
    {
        //for front page
        $data = $this->module_settings->page_settings("index", null, null, "exlocations");
        $this->template->backend($data);
    }

    public function create()
    {
        if ($this->form_validation->run($this, 'exlocations') == true) {
            $this->_submit_data();
        }
        
        $data = $this->module_settings->page_settings("create", null, null, "Add exchange location");
        $this->template->backend($data);
    }

    public function edit($id)
    {
        if (!is_numeric($id)){ redirect('exlocations/view'); }

        $item = $this->_get_data_from_db($id);
        if ($this->form_validation->run($this, 'exlocations') == true) {
            $this->_submit_data();
        }
        $data = $this->module_settings->page_settings("edit", $item, null, "Edit exchange location");
        $this->template->backend($data);
    }

    public function view()
    {
        $data = $this->Mdl_exlocations->get('id');
        $data = $this->module_settings->page_settings("view", $data->result(), 'exlocations', "View Exchange locations");
        $this->template->backend($data);
    }

    public function delete( $id )
    {
        if ( $this->Mdl_exlocations->_delete($id))
        {
            $this->session->set_flashdata('success', "Location was deleted successfully");
        }else{
            $this->session->set_flashdata('error', "Location was not deleted. Please try again");
        }
       
        redirect('exlocations/view');
    }

    public function _submit_data()
    {
        //get data from post
        $data = $this->_get_data_from_post();

        $id = $this->uri->segment(3);
        if (is_numeric($id)) {
            //its an updata
            if ($this->Mdl_exlocations->_update($id, $data)) {
                $this->session->set_flashdata('success', "Location was updated successfully");
                redirect('exlocations/view');
            }
        } else {
            if ($this->Mdl_exlocations->_insert($data)) {
                $this->session->set_flashdata('success', "New Location was added successfully");
                redirect('exlocations/view');
            }
        }
        $this->session->set_flashdata('error', "An error occured while trying to process data");
        redirect('exlocations/create');
    }

    public function _get_data_from_post()
    {
        
        $data['location'] = $this->input->post('location');
        $data['school_id'] = 1;
        $data['is_approved'] = $this->input->post('status') != null ?  1 : 0;
        //$this->module_settings->debug($data);
        return $data;
    }

    public function _get_data_from_db($id)
    {
        $row = $this->Mdl_exlocations->get_where($id)->row();
        $data['location'] = $row->location;
        $data['status'] = $row->is_approved;
        return $data;
    }
}
