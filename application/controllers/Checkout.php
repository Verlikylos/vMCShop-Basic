<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

/**
 * Created with ♥ by Verlikylos on 07.11.2017 23:24.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Checkout extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function sms() {
        $this->load->library('form_validation');

        require_once(APPPATH.'libraries/MinecraftPing.php');
        require_once(APPPATH.'libraries/MinecraftPingException.php');
        $this->form_validation->set_rules('userName', 'username', 'required|trim');
        $this->form_validation->set_rules('smsCode', 'smscode', 'required|trim');
        $this->form_validation->set_rules('serviceId', 'serviceid', 'required|trim');
        $this->form_validation->set_rules('serverName', 'servername', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $userName = $this->input->post('userName');
            $smsCode = $this->input->post('smsCode');
            $serviceId = $this->input->post('serviceId');
            $serverName = $this->input->post('serverName');

            $this->load->model('ServicesModel');

            if (!$service = $this->ServicesModel->getBy('id', $serviceId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
                redirect(base_url('shop/' . $serverName));
            }

            $this->load->model('ServersModel');

            if (!$server = $this->ServersModel->getBy('name', $serverName)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
                redirect(base_url('shop/' . $serverName));
            }

            require_once(APPPATH.'libraries/MinecraftPing.php');
            require_once(APPPATH.'libraries/MinecraftPingException.php');

            try {
                $Query = new MinecraftPing($server['ip'], $server['port']);
                $servers['status']['online'] = true;
            } catch (MinecraftPingException $e) {
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 1) . "] MinecraftPingException: " . $e->getMessage());
                $_SESSION['messageDanger'] = "Serwer, na którym próbujesz zakupić usługę jest aktualnie wyłączony. Zapraszamy później!";
                redirect(base_url('shop/' . $serverName));
            } finally {
                if (isset($Query)) $Query->Close();
            }

            $this->load->model('SettingsModel');
            $this->load->model('PaymentsModel');

            $settings = $this->SettingsModel->get();

            if ($settings['smsOperator'] == 0) {
                $_SESSION['messageDanger'] = "Ustawienia płatności SMS nie są skonfigurowane!";
                redirect(base_url('shop/' . $serverName));
            } else {
                $smsOperator = $this->PaymentsModel->get($settings['smsOperator']);
                $smsOperator['config'] = json_decode($smsOperator['config'], true);
            }

            $service['smsConfig'] = json_decode($service['smsConfig'], true);

            $allow = false;

            if ($smsOperator['name'] == "MicroSMS.pl") {
                $this->load->helper('payments/sms/microsms_helper');

                $response = check($smsOperator['config']['sms']['userid'], $service['smsConfig']['smsChannelId'], $service['smsConfig']['smsNumber'], $smsCode);

                if (!$response['value']) {
                    $_SESSION['messageDanger'] = $response['message'];
                } else {
                    $allow = true;
                }
            } else if ($smsOperator['name'] == "Lvlup.pro") {
                $this->load->helper('payments/sms/lvlup_helper');

                $response = check($smsOperator['config']['sms']['userid'], $service['smsConfig']['smsNumber'], $smsCode);

                if (!$response['value']) {
                    $_SESSION['messageDanger'] = $response['message'];
                } else {
                    $allow = true;
                }
            } else if ($smsOperator['name'] == "Homepay.pl") {
                $this->load->helper('payments/sms/homepay_helper');

                $response = check($smsOperator['config']['sms']['userid'], $smsOperator['config']['sms']['apikey'], $service['smsConfig']['smsChannelId'], $smsCode);

                if (!$response['value']) {
                    $_SESSION['messageDanger'] = $response['message'];
                } else {
                    $allow = true;
                }
            } else if ($smsOperator['name'] == "Pukawka.pl") {
                $this->load->helper('payments/sms/pukawka_helper');
                $this->load->helper('smsnumbers_helper');

                $price = round(getPriceBrutto() * 0.53, 2);
                $response = check($smsOperator['config']['sms']['apikey'], $price, $smsCode);

                if (!$response['value']) {
                    $_SESSION['messageDanger'] = $response['message'];
                } else {
                    $allow = true;
                }
            }

            if (!$allow) {
                $_SESSION['messageDanger'] = $smsOperator['name'];
                redirect(base_url('shop/' . $serverName));
            }

            $this->load->helper('smsnumbers_helper');

            $data['method'] = "SMS Premium";
            $data['details'] = "Kod z SMS: ".$smsCode;
            $data['profit'] = $smsOperator['config']['sms']['percentage'] * getPriceNetto($service['smsConfig']['smsNumber'], $smsOperator['id']);
            $data['buyer'] = $userName;
            $data['service'] = $service['id'];
            $data['server'] = $server['id'];
            $data['date'] = time();

            $this->load->model('PurchasesModel');

            $this->PurchasesModel->add($data);

            $commands = explode(";", $service['commands']);

            $this->load->helper('rcon_helper');

            $rconResponse = rconCommand($server['ip'], $server['rcon_port'], $server['rcon_pass'], $commands, $userName);

            if ($rconResponse['value']) {
                $_SESSION['messageSuccess'] = "Usługa <strong>" . $service['name'] . "</strong> została pomyślnie zrealizowana!";
            } else {
                $_SESSION['messageDanger'] = 'Wystąpił błąd podczas łączenia się z serwerem. Zachowaj kod SMS i zgłoś się do Administratora!';
            }

            redirect(base_url('shop/' . $serverName));
        } else {
            if ($serverName = $this->input->post('serverName')) {
                redirect(base_url('shop/' . $serverName));
            } else {
                redirect(base_url());
            }
        }

    }

    public function voucherRedeem() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('serverName', 'serverName', 'required|trim');
        $this->form_validation->set_rules('voucherCode', 'voucher', 'required|trim');
        $this->form_validation->set_rules('userName', 'userName', 'required|trim');
        $serverName = $this->input->post('serverName');

        if ($this->form_validation->run() === TRUE) {
            $voucherCode = $this->input->post('voucherCode');
            $userName = $this->input->post('userName');

            $this->load->model('VouchersModel');

            if (!$voucher = $this->VouchersModel->getBy('code', $voucherCode)) {
                $_SESSION['messageDanger'] = "Podany kod jest niepoprawny!";
                redirect(base_url('shop/' . $serverName));
            }

            $this->load->model('ServicesModel');

            if (!$service = $this->ServicesModel->getBy('id', $voucher['service'])) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj ponownie później!";
                redirect(base_url('shop/' . $serverName));
            }

            $this->load->model('ServersModel');

            if (!$server = $this->ServersModel->getBy('id', $service['server'])) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj ponownie później!";
                redirect(base_url('shop/' . $serverName));
            }

            require_once(APPPATH.'libraries/MinecraftPing.php');
            require_once(APPPATH.'libraries/MinecraftPingException.php');

            try {
                $Query = new MinecraftPing($server['ip'], $server['port']);
                $servers['status']['online'] = true;
            } catch (MinecraftPingException $e) {
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 1) . "] MinecraftPingException: " . $e->getMessage());
                $_SESSION['messageDanger'] = "Serwer, na którym próbujesz wykorzystać voucher jest aktualnie wyłączony. Zapraszamy później!";
                redirect(base_url('shop/' . $serverName));
            } finally {
                if (isset($Query)) $Query->Close();
            }

            $data['buyer'] = $userName;
            $data['service'] = $service['id'];
            $data['server'] = $server['id'];
            $data['method'] = "Voucher";
            $data['details'] = "Kod: " . $voucherCode;
            $data['profit'] = 0;
            $data['date'] = time();

            $this->load->model('PurchasesModel');

            $this->PurchasesModel->add($data);

            if (!$this->VouchersModel->delete($voucher['id'])) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj ponownie później!";
                redirect(base_url('shop/' . $serverName));
            }

            $commands = explode(";", $service['commands']);

            $this->load->helper('rcon_helper');

            $rconResponse = rconCommand($server['ip'], $server['rcon_port'], $server['rcon_pass'], $commands, $userName);

            if ($rconResponse['value']) {
                $_SESSION['messageSuccess'] = "Usługa <strong>" . $service['name'] . "</strong> z serwera <strong>" . $server['name'] . "</strong> została pomyślnie zrealizowana! Voucher został wykorzystany!";
            } else {
                $_SESSION['messageDanger'] = 'Wystąpił błąd podczas łączenia się z serwerem. Zachowaj kod vouchera i zgłoś się do Administratora!';
            }

            redirect(base_url('shop/' . $serverName));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wszystkie pola formularza!";
            redirect(base_url('shop/' . $serverName));
        }
    }

}