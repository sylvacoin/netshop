<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of templates
 *
 * @author Code X
 */
class Template extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * frontend
     * Handles the frontend rendering of the page
     *
     * @param  mixed $data
     * page_setting data
     *
     * @return void
     */
    public function frontend($data)
    {
        $this->load->view('frontend', $data);
    }

    /**
     * backend
     * Handles the frontend rendering of the page
     *
     * @param  mixed $data
     * page_setting data
     *
     * @return void
     */
    public function middleend($data)
    {
        $this->load->view('middleend', $data);
    }
    /**
     * backend
     * Handles the frontend rendering of the page
     *
     * @param  mixed $data
     * page_setting data
     *
     * @return void
     */
    public function backend($data)
    {
        $this->load->view('backend', $data);
    }
}
