<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 14.10.2017 19:51.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class SettingsModel extends CI_Model {

    private $table = "vmcs_settings";

    public function get() {
        return $this->db->where('id', 1)->get($this->table)->row_array();
    }

    public function update($data) {
        return $this->db->where('id', 1)->update($this->table, $data);
    }
    
}