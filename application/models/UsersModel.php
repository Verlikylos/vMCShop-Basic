<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 15.10.2017 01:29.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class UsersModel extends CI_Model {

    private $table = "vmcs_users";

    public function getAll() {
        return $this->db->order_by('id')->get($this->table)->result_array();
    }

    public function getBy($column, $data) {
        return $this->db->where($column, $data)->get($this->table)->row_array();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function add($data) {
        return $this->db->insert($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
    
}