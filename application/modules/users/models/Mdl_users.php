<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_users extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_table()
    {
        $table = "users";
        return $table;
    }

    public function get($order_by = null)
    {
        $table = $this->get_table();
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query->result();
    }

    public function get_with_limit($limit, $offset, $order_by)
    {
        $table = $this->get_table();
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    public function get_where($id)
    {
        $table = $this->get_table();
        $this->db->where('user_id', $id);
        $query = $this->db->get($table);
        return $query;
    }

    public function get_where_custom($col, $value)
    {
        $table = $this->get_table();
        $this->db->where($col, $value);
        $query = $this->db->get($table);
        return $query;
    }

    public function _insert($data)
    {
        $table = $this->get_table();
        return $this->db->insert($table, $data);
    }

    public function _update($id, $data)
    {
        $table = $this->get_table();
        $this->db->where('user_id', $id);
        return $this->db->update($table, $data);
    }

    public function _delete($id)
    {
        $table = $this->get_table();
        $this->db->where('user_id', $id);
        return $this->db->delete($table);
    }

    public function count_where($column, $value)
    {
        $table = $this->get_table();
        $this->db->where($column, $value);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    public function count_all()
    {
        $table = $this->get_table();
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    public function get_max()
    {
        $table = $this->get_table();
        $this->db->select_max('user_id');
        $query = $this->db->get($table);
        $row = $query->row();
        $id = $row->id;
        return $id;
    }

    public function _custom_query($mysql_query)
    {
        $query = $this->db->query($mysql_query);
        return $query;
    }

}