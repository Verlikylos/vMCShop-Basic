<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 14.10.2017 23:22.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class PaymentsModel extends CI_Model {

    private $table = "vmcs_payments";

    public function get($id) {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }
    
}