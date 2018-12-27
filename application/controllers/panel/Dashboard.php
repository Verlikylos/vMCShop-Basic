<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

/**
 * Created with ♥ by Verlikylos on 12.10.2017 16:24.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged')) redirect(base_url());
    }

    public function index() {

        $this->benchmark->mark('code_start');

        require_once(APPPATH.'libraries/MinecraftPing.php');
        require_once(APPPATH.'libraries/MinecraftPingException.php');
        $this->load->model('SettingsModel');
        $this->load->model('PagesModel');
        $this->load->model('ServersModel');
        $this->load->model('UsersModel');
        $this->load->model('PurchasesModel');

        $headerData['settings'] = $this->SettingsModel->get();


        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Dashboard";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $servers = $this->ServersModel->getAll();
        $bodyData['servers'] = array();

        foreach ($servers as $server) {

            try {
                $Query = new MinecraftPing($server['ip'], $server['port']);
                $result = $Query->Query();
                $version = $result['version']['name'];
                $version = str_split($version);
                $server['status']['version'] = "";
                foreach ($version as $char) {
                    if ((is_numeric($char)) || ($char == ".")) {
                        $server['status']['version'] .= $char;
                    }
                }
                $server['status']['onlinePlayers'] = $result['players']['online'];
                $server['status']['maxPlayers'] = $result['players']['max'];
            } catch (MinecraftPingException $e) {
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 1) . "] MinecraftPingException: " . $e->getMessage());
            } finally {
                if (isset($Query)) $Query->Close();
            }

            array_push($bodyData['servers'], $server);

        }

        $bodyData['usersCount'] = count($this->UsersModel->getAll());
        $purchases = $this->PurchasesModel->getAll();
        $bodyData['purchasesCount'] = count($purchases);
        $bodyData['profit'] = 0;

        foreach ($purchases as $purchase) {
            $bodyData['profit'] += $purchase['profit'];
        }

        $bodyData['pages'] = $this->PagesModel->getAll();

        $this->load->view('panel/Dashboard', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

}