<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 13.10.2017 16:38.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Services extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged')) redirect(base_url());
    }

    public function index() {

        $this->benchmark->mark('code_start');

        $this->load->library('form_validation');

        $this->load->model('SettingsModel');
        $this->load->model('PaymentsModel');
        $this->load->model('ServicesModel');
        $this->load->model('ServersModel');
        $this->load->model('PagesModel');

        $this->load->helper('smsnumbers_helper');

        $headerData['settings'] = $this->SettingsModel->get();

        if ($headerData['settings']['smsOperator'] == 0) {
            $headerData['smsOperator'] = null;
        } else {
            $headerData['smsOperator'] = $this->PaymentsModel->get($headerData['settings']['smsOperator']);
            $headerData['smsOperator']['config'] = json_decode($headerData['smsOperator']['config']);
        }


        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Usługi";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['pages'] = $this->PagesModel->getAll();
        $bodyData['services'] = $this->ServicesModel->getAll();
        $servers = $this->ServersModel->getAll();
        $bodyData['servers'] = $servers;

        foreach ($servers as $server) {
            for ($i = 0; $i < count($bodyData['services']); $i++) {
                if (($bodyData['services'][$i]['smsConfig'] != null) && (!is_array($bodyData['services'][$i]['smsConfig']))) {
                    $bodyData['services'][$i]['smsConfig'] = json_decode($bodyData['services'][$i]['smsConfig'], true);
                }
                if (!is_array($bodyData['services'][$i]['commands'])) {
                    $bodyData['services'][$i]['commands'] = explode(';', $bodyData['services'][$i]['commands']);
                }
                if ($bodyData['services'][$i]['server'] == $server['id']) {
                    $bodyData['services'][$i]['server'] = $server['name'];
                }
            }
        }

        $this->load->view('panel/Services', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

    public function create() {
        if (!$this->session->userdata('logged')) redirect(base_url());

        $this->load->model('SettingsModel');

        $this->load->library('form_validation');

        $settings = $this->SettingsModel->get();

        $this->form_validation->set_rules('serviceName', 'serviceName', 'required|trim');
        $this->form_validation->set_rules('serviceServer', 'serviceServer', 'required|trim');
        $this->form_validation->set_rules('serviceDesc', 'serviceDesc', 'required|trim');
        if (($settings['smsOperator'] == "1") || ($settings['smsOperator'] == "3")) {
            $this->form_validation->set_rules('serviceSmsChannel', 'serviceSmsChannel', 'trim');
            $this->form_validation->set_rules('serviceSmsChannelId', 'serviceSmsChannelId', 'trim');
        }
        $this->form_validation->set_rules('serviceSmsNumber', 'serviceSmsNumber', 'trim');
        $this->form_validation->set_rules('servicePaypalCost', 'servicePaypalCost', 'trim');
        $this->form_validation->set_rules('serviceCmds', 'serviceCmds', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $data['server'] = $this->input->post('serviceServer');
            $data['name'] = $this->input->post('serviceName');
            $data['description'] = $this->input->post('serviceDesc');
            $data['paypalCost'] = (($this->input->post('servicePaypalCost') == null) || ($this->input->post('servicePaypalCost') == "") ? null : $this->input->post('servicePaypalCost'));
            $data['commands'] = $this->input->post('serviceCmds');

            $smsConfig = array(
                'operator' => $settings['smsOperator'],
                'smsNumber' => (($this->input->post('serviceSmsNumber') == null) || ($this->input->post('serviceSmsNumber') == "") ? null : $this->input->post('serviceSmsNumber'))
            );

            if (($settings['smsOperator'] == "1") || ($settings['smsOperator'] == "3")) {
                $smsConfig['smsChannel'] = (($this->input->post('serviceSmsChannel') == null) || ($this->input->post('serviceSmsChannel') == "") ? null : $this->input->post('serviceSmsChannel'));
                $smsConfig['smsChannelId'] = (($this->input->post('serviceSmsChannelId') == null) || ($this->input->post('serviceSmsChannelId') == "") ? null : $this->input->post('serviceSmsChannelId'));
            }

            if ($settings['smsOperator'] == 2) {
                $smsConfig['smsChannel'] = "AP.HOSTMC";
            }

            if ($settings['smsOperator'] == 4) {
                $smsConfig['smsChannel'] = "pukawka";
            }

            if (($smsConfig['smsNumber'] == NULL) && ($smsConfig['smsChannel'] == NULL) && ($smsConfig['smsChannelId'] == NULL)) {
                $data['smsConfig'] = null;
            } else {
                $data['smsConfig'] = json_encode($smsConfig);
            }

            $config['upload_path'] = './assets/images/services';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 10240;
            $config['max_width'] = 360;
            $config['max_height'] = 360;
            $config['encrypt_name'] = TRUE;
            $serviceName = $data['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('serviceImage')) {

                $uploadData = $this->upload->data();
                $data['image'] = base_url('assets/images/services/' . $uploadData['file_name']);

            } else {

                $_SESSION['messageDanger'] = $this->upload->display_errors();
                redirect(base_url('panel/services'));

            }

            $this->load->model('ServicesModel');


            if (!$this->ServicesModel->add($data)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/services'));
            }

            $this->load->model('ServersModel');

            $server = $this->ServersModel->getBy('id', $data['server']);

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Usługi";
            $data['details'] = "Użytkownik utworzył <strong>usługę</strong> o nazwie <strong>" . $serviceName . "</strong> dla serwera <strong>" . $server['name'] . "</strong>.";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Pomyślnie utworzono usługę o nazwie <strong>" . $serviceName . "</strong> dla serwera <strong>" . $server['name'] . "</strong>!";
            redirect(base_url('panel/services'));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wszystkie pola formularza!";
            redirect(base_url('panel/services'));
        }
    }

    public function remove() {
        if (!$this->session->userdata('logged')) redirect(base_url());

        $this->load->library('form_validation');

        $this->form_validation->set_rules('serviceId', 'serviceId', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $serviceId = $this->input->post('serviceId');

            $this->load->model('ServicesModel');

            if (!$service = $this->ServicesModel->getBy('id', $serviceId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
                redirect(base_url('panel/services'));
            }

            if (!$this->ServicesModel->delete($serviceId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/services'));
            }

            $this->load->model('VouchersModel');

            $serviceVouchers = $this->VouchersModel->getBy('service', $serviceId, true);

            if ($serviceVouchers) {

                $vouchersIds = array();

                foreach ($serviceVouchers as $serviceVoucher) {
                    array_push($vouchersIds, $serviceVoucher['id']);
                }

                if (!$this->VouchersModel->deleteMultiple($vouchersIds)) {
                    $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                    redirect(base_url('panel/servers'));
                }

            }

            $this->load->model('PurchasesModel');

            $servicePurchases = $this->PurchasesModel->getBy('service', $serviceId, true);

            if ($servicePurchases) {

                $purchasesIds = array();

                foreach ($servicePurchases as $servicePurchase) {
                    array_push($purchasesIds, $servicePurchase['id']);
                }

                if (!$this->PurchasesModel->deleteMultiple($purchasesIds)) {
                    $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                    redirect(base_url('panel/servers'));
                }

            }

            unset($data);

            $logs = array();

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Usługi";
            $data['details'] = "Użytkownik usunął <strong>usługę</strong> o nazwie <strong>" . $service['name'] . "</strong> (ID: #" . $service['id'] . ").";
            $data['date'] = time();

            array_push($logs, $data);

            foreach ($serviceVouchers as $serviceVoucher) {
                $data['user'] = $_SESSION['name'];
                $data['section'] = "Vouchery";
                $data['details'] = "Użytkownik usunął <strong>voucher</strong> o ID <strong>#" . $serviceVoucher['id'] . "</strong>.";
                $data['date'] = time();
                array_push($logs, $data);
            }

            $this->load->model('LogsModel');
            $this->LogsModel->addMultiple($logs);

            $_SESSION['messageSuccess'] = "Pomyślnie usunięto usługę o nazwie <strong>" . $service['name'] . " (ID: #" . $service['id'] . ")</strong>!";
            redirect(base_url('panel/services'));
        } else {
            $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
            redirect(base_url('panel/services'));
        }
    }

}