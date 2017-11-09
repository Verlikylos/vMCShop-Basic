<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 01.11.2017 15:18.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class LogsModel extends CI_Model {

    private $table = "vmcs_logs";

    public function getAll($start = 0, $limit = "all") {
        if ($limit == "all") {
            return $this->db->order_by('id')->get($this->table)->result_array();
        } else {
            return $this->db->limit($limit, $start)->order_by('id', 'DESC')->get($this->table)->result_array();
        }
    }
    
    public function getBy($column, $data, $oneInArray = false) {
        $result = $this->db->where($column, $data)->get($this->table)->result_array();
        if ($result == null) {
            return null;
        } else if (count($result) > 1) {
            return $result;
        } else {
            if ($oneInArray) return $result;
            return $result[0];
        }
    }

    public function add($data) {
        return $this->db->insert($this->table, $data);
    }

    public function addMultiple($data) {
        return $this->db->insert_batch($this->table, $data);
    }
    
}