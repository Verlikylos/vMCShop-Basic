<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 20.09.2017 20:17.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Service extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($serviceId = null) {

        if ($serviceId == null) {

            $this->load->view('errors/html/error_404');
            log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 3) . "] No GET argument given!");
            return;

        } else {

            $this->benchmark->mark('code_start');

            $this->load->model('SettingsModel');
            $this->load->model('ServersModel');
            $this->load->model('ServicesModel');
            $this->load->model('PagesModel');
            $this->load->library('form_validation');
            $this->load->helper('smsnumbers');

            if (!$bodyData['service'] = $this->ServicesModel->getBy('id', $serviceId)) {
                $this->load->view('errors/html/error_404.php');
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 2) . "] Service with ID #" . $serviceId . " does not exist in database!");
                return;
            }

            $bodyData['service']['smsConfig'] = json_decode($bodyData['service']['smsConfig'], true);

            $headerData['settings'] = $this->SettingsModel->get();


            /**  Head Section  */

            $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Ranga VIP ";

            $this->load->view('components/Header', $headerData);


            /**  Body Section  */

            if (!$bodyData['server'] = $this->ServersModel->getBy('id', $bodyData['service']['server'], true)) {
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 1) . "] Server with ID #" . $bodyData['service']['server'] . " does not exist in database!");
                show_error('Serwer przypisany do tej usługi został usunięty!', '404', 'Serwer przypisany do tej usługi został usunięty!');
                return;
            }

            $this->load->model('PaymentsModel');

            $pp = $this->PaymentsModel->get(5);
            $pp = json_decode($pp['config'], true);
            $bodyData['paypal'] = $pp['adress'];

            $bodyData['pages'] = $this->PagesModel->getAll();

            $this->load->view('Service', $bodyData);


            /**  Footer Section  */

            $this->benchmark->mark('code_end');

            $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

            $this->load->view('components/Footer', $footerData);


        }

    }

}