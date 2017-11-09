<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 13.10.2017 18:24.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Vouchers extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged')) redirect(base_url());
    }

    public function index() {

        $this->benchmark->mark('code_start');

        $this->load->library('form_validation');

        $this->load->model('SettingsModel');
        $this->load->model('VouchersModel');
        $this->load->model('ServicesModel');
        $this->load->model('ServersModel');
        $this->load->model('PagesModel');

        $headerData['settings'] = $this->SettingsModel->get();


        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Vouchery";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['vouchers'] = $this->VouchersModel->getAll();
        $bodyData['services'] = $this->ServicesModel->getAll();
        $servers = $this->ServersModel->getAll();
        $bodyData['pages'] = $this->PagesModel->getAll();

        foreach ($servers as $server) {
            for ($i = 0; $i < count($bodyData['services']); $i++) {
                if ($bodyData['services'][$i]['server'] == $server['id']) {
                    $bodyData['services'][$i]['server'] = $server['name'];
                    for ($x = 0; $x < count($bodyData['vouchers']); $x++) {
                        if (!isset($bodyData['vouchers'][$x]['server'])) {
                            $bodyData['vouchers'][$x]['server'] = "Serwer nie istnieje!";
                        }
                        if ($bodyData['vouchers'][$x]['service'] == $bodyData['services'][$i]['id']) {
                            $bodyData['vouchers'][$x]['service'] = $bodyData['services'][$i]['name'] . " (ID: #" . $bodyData['services'][$i]['id'] . ")";
                            $bodyData['vouchers'][$x]['server'] = $server['name'];
                        }
                    }
                }
            }
        }

        $this->load->view('panel/Vouchers', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

    public function create() {
        if (!$this->session->userdata('logged')) redirect(base_url());

        $this->load->model('SettingsModel');
        $this->load->model('VouchersModel');
        $this->load->model('ServicesModel');

        $this->load->library('form_validation');
        $this->load->helper('string');

        $settings = $this->SettingsModel->get();

        $this->form_validation->set_rules('voucherService', 'voucherService', 'required|trim');
        $this->form_validation->set_rules('voucherAmount', 'Amount', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $data['service'] = $this->input->post('voucherService');
            $amount = $this->input->post('voucherAmount');
            $vouchers = array();

            if (!$service = $this->ServicesModel->getBy('id', $data['service'])) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
                redirect(base_url('panel/vouchers'));
            }

            for ($i = 1; $i <= $amount; $i++) {
                $data['code'] = $settings['voucherPrefix'] . random_string('alpha', $settings['voucherLength']);
                array_push($vouchers, $data);
            }

            if (!$this->VouchersModel->addMultiple($vouchers)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/vouchers'));
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Vouchery";
            $data['details'] = "Użytkownik wygenerował <strong>" . $amount . " voucherów</strong> dla usługi <strong>" . $service['name'] . "</strong> (ID: #" . $service['id'] . ").";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Pomyślnie wygenerowano <strong>" . $amount . "</strong> voucherów dla usługi <strong>" . $service['name'] . "</strong> (ID: #" . $service['id'] . ")!";
            redirect(base_url('panel/vouchers'));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wszystkie pola formularza!";
            redirect(base_url('panel/vouchers'));
        }
    }

    public function remove() {
        if (!$this->session->userdata('logged')) redirect(base_url());

        $this->load->library('form_validation');

        $this->form_validation->set_rules('voucherId', 'voucherId', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $voucherId = $this->input->post('voucherId');

            $this->load->model('VouchersModel');

            if (!$voucher = $this->VouchersModel->getBy('id', $voucherId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
                redirect(base_url('panel/vouchers'));
            }

            if (!$this->VouchersModel->delete($voucherId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/vouchers'));
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Voucher";
            $data['details'] = "Użytkownik usunął <strong>voucher</strong> o ID <strong>#" . $voucher['id'] . "</strong>.";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Pomyślnie usunięto voucher o ID <strong>#" . $voucher['id'] . "</strong>!";
            redirect(base_url('panel/vouchers'));
        } else {
            $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
            redirect(base_url('panel/vouchers'));
        }
    }

}