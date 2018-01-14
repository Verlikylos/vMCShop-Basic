<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 13.10.2017 15:31.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Servers extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged')) redirect(base_url());
    }

    public function index() {

        $this->benchmark->mark('code_start');

        $this->load->library('form_validation');

        $this->load->model('SettingsModel');
        $this->load->model('ServersModel');
        $this->load->model('PagesModel');

        $headerData['settings'] = $this->SettingsModel->get();


        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Serwery";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['servers'] = $this->ServersModel->getAll();
        $bodyData['pages'] = $this->PagesModel->getAll();

        $this->load->view('panel/Servers', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

    public function create() {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('serverName', 'serverName', 'required|trim');
        $this->form_validation->set_rules('serverIp', 'serverIp', 'required|trim');
        $this->form_validation->set_rules('serverPort', 'serverPort', 'required|trim');
        $this->form_validation->set_rules('serverRconPort', 'serverRconPort', 'required|trim');
        $this->form_validation->set_rules('serverRconPass', 'serverRconPass', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $data['name'] = $this->input->post('serverName');

            if (!preg_match("/^[a-zA-Z0-9]{1,255}[^\s]$/", $data['name'])) {
                $_SESSION['messageDanger'] = "Nazwa serwera zawiera niedozwolone znaki!";
                redirect(base_url('panel/servers'));
            }

            $this->load->model('ServersModel');

            if ($this->ServersModel->getBy('name', $data['name'])) {
                $_SESSION['messageDanger'] = "Serwer o takiej nazwie już istnieje!";
                redirect(base_url('panel/servers'));
            }

            $config['upload_path'] = './assets/images/servers';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 10240;
            $config['max_width'] = 512;
            $config['max_height'] = 512;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('serverImage')) {
                $uploadData = $this->upload->data();
                $data['image'] = base_url('assets/images/servers/' . $uploadData['file_name']);
            } else {
                $_SESSION['messageDanger'] = $this->upload->display_errors();
                redirect(base_url('panel/servers'));
            }

            $data['ip'] = $this->input->post('serverIp');
            $data['port'] = $this->input->post('serverPort');
            $data['rcon_port'] = $this->input->post('serverRconPort');
            $data['rcon_pass'] = $this->input->post('serverRconPass');
            $serverName = $data['name'];

            if (!$this->ServersModel->add($data)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/servers'));
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Serwery";
            $data['details'] = "Użytkownik dodał <strong>serwer</strong> o nazwie <strong>" . $serverName . "</strong>.";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Pomyślnie dodano serwer o nazwie <strong>" . $serverName ."</strong>!";
            redirect(base_url('panel/servers'));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wszystkie pola formularza!";
            redirect(base_url('panel/servers'));
        }
    }

    public function remove() {
        if (!$this->session->userdata('logged')) redirect(base_url());

        $this->load->library('form_validation');

        $this->form_validation->set_rules('serverId', 'serverId', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $serverId = $this->input->post('serverId');

            $this->load->model('ServersModel');

            if (!$server = $this->ServersModel->getBy('id', $serverId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
                redirect(base_url('panel/servers'));
            }

            if (!$this->ServersModel->delete($serverId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/servers'));
            }

            $this->load->model('ServicesModel');

            $serverServices = $this->ServicesModel->getBy('server', $serverId, true);

            if ($serverServices != null) {

                $this->load->model('VouchersModel');
                $serverVouchers = null;
                $vouchersIds = array();
                $servicesIds = array();

                foreach ($serverServices as $serverService) {
                    array_push($servicesIds, $serverService['id']);
                    if ($serverVouchers == null) {
                        $serverVouchers = $this->VouchersModel->getBy('service', $serverService['id'], true);
                    } else {
                        array_merge($serverVouchers, $this->VouchersModel->getBy('service', $serverService['id'], true));
                    }
                }

                if ($serverVouchers != null) {
                    foreach ($serverVouchers as $serverVoucher) {
                        array_push($vouchersIds, $serverVoucher['id']);
                    }
                }

                if (!empty($vouchersIds)) {
                    if (!$this->VouchersModel->deleteMultiple($vouchersIds)) {
                        $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                        redirect(base_url('panel/servers'));
                    }
                }

                if (!$this->ServicesModel->deleteMultiple($servicesIds)) {
                    $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                    redirect(base_url('panel/servers'));
                }

            }

            $this->load->model('PurchasesModel');

            $serverPurchases = $this->PurchasesModel->getBy('server', $serverId, true);

            if ($serverPurchases) {

                $purchasesIds = array();

                foreach ($serverPurchases as $serverPurchase) {
                    array_push($purchasesIds, $serverPurchase['id']);
                }

                if (!$this->PurchasesModel->deleteMultiple($purchasesIds)) {
                    $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                    redirect(base_url('panel/servers'));
                }

            }

            unset($data);

            $logs = array();

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Serwery";
            $data['details'] = "Użytkownik usunał <strong>serwer</strong> o nazwie <strong>" . $server['name'] . "</strong>.";
            $data['date'] = time();

            array_push($logs, $data);

            foreach ($serverServices as $serverService) {
                $data['user'] = $_SESSION['name'];
                $data['section'] = "Usługi";
                $data['details'] = "Użytkownik usunał <strong>usługę</strong> o nazwie <strong>" . $serverService['name'] . "</strong> (ID:" . $serverService['id'] . ").";
                $data['date'] = time();
                array_push($logs, $data);
            }

            foreach ($serverVouchers as $serverVoucher) {
                $data['user'] = $_SESSION['name'];
                $data['section'] = "Vouchery";
                $data['details'] = "Użytkownik usunał <strong>voucher</strong> o ID <strong>#" . $serverVoucher['id'] . "</strong>.";
                $data['date'] = time();
                array_push($logs, $data);
            }

            $this->load->model('LogsModel');
            $this->LogsModel->addMultiple($logs);

            $_SESSION['messageSuccess'] = "Pomyślnie usunięto serwer o nazwie <strong>" . $server['name'] . "</strong>!";
            redirect(base_url('panel/servers'));
        } else {
            $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
            redirect(base_url('panel/servers'));
        }
    }

}