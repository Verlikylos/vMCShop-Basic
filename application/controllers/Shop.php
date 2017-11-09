<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

 /**
 * Created with ♥ by Verlikylos on 11.09.2017 22:13.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Shop extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($serverName = null) {

        if ($serverName == null) {

            $this->load->view('errors/html/error_404.php');
            log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 3) . "] No GET argument given!");
            return;

        } else {

            $this->benchmark->mark('code_start');

            $this->load->model('SettingsModel');
            $this->load->model('ServersModel');
            $this->load->model('ServicesModel');
            $this->load->model('PagesModel');
            $this->load->model('PurchasesModel');
            $this->load->library('form_validation');
            $this->load->helper('smsnumbers_helper');

            if (!$bodyData['server'] = $this->ServersModel->getBy('name', $serverName, true)) {
                $this->load->view('errors/html/error_404.php');
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 2) . "] Server with name '" . $serverName . "' does not exist in database!");
                return;
            }

            require_once(APPPATH.'libraries/MinecraftPing.php');
            require_once(APPPATH.'libraries/MinecraftPingException.php');

            $headerData['settings'] = $this->SettingsModel->get();


            /**  Head Section  */

            $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Sklep serwera " . $serverName;

            $this->load->view('components/Header', $headerData);


            /**  Body Section  */

            $bodyData['pages'] = $this->PagesModel->getAll();

            try {
                $Query = new MinecraftPing($bodyData['server']['ip'], $bodyData['server']['port']);
                $result = $Query->Query();
                $version = $result['version']['name'];
                $version = str_split($version);
                $bodyData['server']['status']['version'] = "";
                foreach ($version as $char) {

                    if ((is_numeric($char)) || ($char == ".")) {
                        $bodyData['server']['status']['version'] .= $char;
                    }
                }
                $bodyData['server']['status']['onlinePlayers'] = $result['players']['online'];
                $bodyData['server']['status']['maxPlayers'] = $result['players']['max'];
                $bodyData['server']['status']['percent'] = round($bodyData['server']['status']['onlinePlayers'] / $bodyData['server']['status']['maxPlayers'] * 100, 0);

                if ($bodyData['server']['status']['maxPlayers'] == 0) {
                    $bodyData['server']['status']['percent'] = 0;
                }
            } catch (MinecraftPingException $e) {
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 1) . "] MinecraftPingException: " . $e->getMessage());
            } finally {
                if (isset($Query)) $Query->Close();
            }

            $bodyData['services'] = $this->ServicesModel->getBy('server', $bodyData['server']['id'], true);

            for ($i = 0; $i < count($bodyData['services']); $i++) {
                if ($bodyData['services'][$i]['smsConfig'] != null) {
                    $bodyData['services'][$i]['smsConfig'] = json_decode($bodyData['services'][$i]['smsConfig'], true);
                }
            }

            $bodyData['purchases'] = $this->PurchasesModel->getBy('server', $bodyData['server']['id'], true);
            $servers = $this->ServersModel->getAll();
            $services = $bodyData['services'];

            foreach ($servers as $server) {
                for ($i = 0; $i < count($services); $i++) {
                    if ($services[$i]['server'] == $server['id']) {
                        $services[$i]['server'] = $server['name'];
                        for ($x = 0; $x < count($bodyData['purchases']); $x++) {
                            if ($bodyData['purchases'][$x]['service'] == $services[$i]['id']) {
                                $bodyData['purchases'][$x]['service'] = $services[$i]['name'];
                                $bodyData['purchases'][$x]['server'] = $server['name'];
                            }
                        }
                    }
                }
            }

            $this->load->model('PaymentsModel');

            $pp = $this->PaymentsModel->get(5);
            $pp = json_decode($pp['config'], true);
            $bodyData['paypal'] = $pp['adress'];

            $this->load->view('Shop', $bodyData);


            /**  Footer Section  */

            $this->benchmark->mark('code_end');

            $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

            $this->load->view('components/Footer', $footerData);


        }

    }
    
}