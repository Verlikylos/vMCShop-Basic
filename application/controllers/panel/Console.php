<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

/**
 * Created with ♥ by Verlikylos on 25.10.2017 22:02.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Console extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged')) redirect(base_url());
    }

    public function index($serverActive = null) {

        $this->benchmark->mark('code_start');

        require_once(APPPATH.'libraries/MinecraftPing.php');
        require_once(APPPATH.'libraries/MinecraftPingException.php');
        $this->load->model('SettingsModel');
        $this->load->model('PagesModel');
        $this->load->model('ServersModel');
        $this->load->library('form_validation');

        $headerData['settings'] = $this->SettingsModel->get();


        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Konsola";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['pages'] = $this->PagesModel->getAll();

        if ($serverActive == null) {
            $serverActive = $this->ServersModel->getBy('id', 1);
            $serverActive = $serverActive['name'];
        } else {

            if (!$server = $this->ServersModel->getBy('name', $serverActive)) {
                $this->load->view('errors/html/error_404.php');
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 2) . "] Server with name '" . $serverActive . "' does not exist in database!");
                return;
            }

        }

        $bodyData['consoleServerActive'] = $serverActive;
        $servers = $this->ServersModel->getAll();
        $bodyData['servers'] = array();

        foreach ($servers as $server) {
            try {
                $Query = new MinecraftPing($server['ip'], $server['port']);
                $server['status']['online'] = true;
            } catch (MinecraftPingException $e) {
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 1) . "] MinecraftPingException: " . $e->getMessage());
            } finally {
                if (isset($Query)) $Query->Close();
            }

            array_push($bodyData['servers'], $server);

        }

        $this->load->view('panel/Console', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

}