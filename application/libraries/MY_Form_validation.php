<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_form_validation
 *
 * @author Code X
 */
class MY_Form_validation extends CI_Form_validation
{
    public $CI;
    //put your code here
    public function run($module = '', $group = '')
    {
        //(is_object($module)) && $this->CI = &$module;
        if (is_object($module)) {$this->CI = &$module;}
        return parent::run($group);
    }

    /**
	 * Is Unique
	 *
	 * Check if the input value doesn't already exist
	 * in the specified database field.
	 *
	 * @param	string	$str
	 * @param	string	$field
	 * @return	bool
	 */
	public function is_unique($str, $field)
	{
        sscanf($field, '%[^.].%[^.]', $table, $field);
        $this->CI->db->where(array($field => $str));
		return is_object($this->CI->db)
			? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
			: FALSE;
	}

}
