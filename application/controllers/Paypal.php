<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

/**
 * Created with ♥ by Verlikylos on 08.11.2017 20:31.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Paypal extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->load->library('form_validation');

        require_once(APPPATH.'libraries/MinecraftPing.php');
        require_once(APPPATH.'libraries/MinecraftPingException.php');
        $this->form_validation->set_rules('userName', 'username', 'required|trim');
        $this->form_validation->set_rules('serverName', 'servername', 'required|trim');
        $this->form_validation->set_rules('serviceId', 'serviceId', 'required|trim');
        $serverName = $this->input->post('serverName');

        if ($this->form_validation->run() === TRUE) {
            $this->benchmark->mark('code_start');

            $userName = $this->input->post('userName');
            $serviceId = $this->input->post('serviceId');

            $this->load->model('ServersModel');
            $this->load->model('ServicesModel');

            if (!$service = $this->ServicesModel->getBy('id', $serviceId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas weryfikacji ustawień płatności! Spróbuj ponownie później.";
                redirect(base_url('shop/' . $serverName));
            }

            if (!$server =  $this->ServersModel->getBy('name', $serverName)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas weryfikacji ustawień płatności! Spróbuj ponownie później.";
                redirect(base_url('shop/' . $serverName));
            }

            $bodyData['server'] = $server;

            try {
                $Query = new MinecraftPing($server['ip'], $server['port']);
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
                if (($bodyData['server']['status']['onlinePlayers'] == 0) || ($bodyData['server']['status']['maxPlayers'] == 0)) {
                    $bodyData['server']['status']['percent'] = 0;
                } else {
                    $bodyData['server']['status']['percent'] = round($bodyData['server']['status']['onlinePlayers'] / $bodyData['server']['status']['maxPlayers'] * 100, 0);
                }

                if ($bodyData['server']['status']['maxPlayers'] == 0) {
                    $bodyData['server']['status']['percent'] = 0;
                }
            } catch (MinecraftPingException $e) {
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 1) . "] MinecraftPingException: " . $e->getMessage());
                $_SESSION['messageDanger'] = "Serwer, na którym próbujesz zakupić usługę jest aktualnie wyłączony. Zapraszamy później!";
                redirect(base_url('shop/' . $serverName));
            } finally {
                if (isset($Query)) $Query->Close();
            }

            $this->load->model('PaymentsModel');
            $this->load->model('SettingsModel');

            $sellerAdress = $this->PaymentsModel->get(5);
            $sellerAdress = json_decode($sellerAdress['config'], true);

            $this->load->helper('string');

            $bodyData['paypalData']['business'] = $sellerAdress['adress'];
            $bodyData['paypalData']['item_name'] = "Usługa " . $service['name'] . " dla serwera " . $serverName;
            $bodyData['paypalData']['item_number'] = $serviceId;
            $bodyData['paypalData']['amount'] = $service['paypalCost'];
            $bodyData['paypalData']['custom'] = random_string('alnum', 64);
            $bodyData['paypalData']['quantity'] = 1;
            $bodyData['paypalData']['currency_code'] = "PLN";

            $data['service'] = $bodyData['paypalData']['item_number'];
            $data['user'] = $userName;
            $data['hash'] = $bodyData['paypalData']['custom'];
            $data['gross'] = $bodyData['paypalData']['amount'];
            $data['currency'] = "PLN";
            $data['status'] = "CREATED";

            $this->load->model('PaypalPaymentsModel');

            if (!$this->PaypalPaymentsModel->add($data)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia się z bazą danych! Spróbuj ponownie później.";
                redirect(base_url('shop/' . $serverName));
            }

            $headerData['settings'] = $this->SettingsModel->get();
            $this->load->model('PagesModel');
            $this->load->model('PurchasesModel');
            $this->load->model('ServicesModel');
            $this->load->library('form_validation');

            /**  Head Section  */

            $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Weryfikacja płatności PayPal";

            $this->load->view('components/Header', $headerData);


            /**  Body Section  */

            $bodyData['pages'] = $this->PagesModel->getAll();
            $bodyData['displayPage'] = "createForm";

            $bodyData['purchases'] = $this->PurchasesModel->getBy('server', $bodyData['server']['id'], true);
            $servers = $this->ServersModel->getAll();
            $services = $this->ServicesModel->getBy('server', $server['id'], true);

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

            $this->load->view('Paypal', $bodyData);


            /**  Footer Section  */

            $this->benchmark->mark('code_end');

            $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

            $this->load->view('components/Footer', $footerData);



        } else {
            $_SESSION['messageDanger'] = "Wystąpił błąd podczas weryfikacji ustawień płatności! Spróbuj ponownie później.";
            redirect(base_url('shop/' . $serverName));
        }


    }

    public function cancelled() {
        $_SESSION['messageSuccess'] = "Płatność została anulowana!";
        redirect(base_url());
    }

    public function success() {

        if (!count($_GET)) {
            show_404();
        }

        $this->benchmark->mark('code_start');

        $amount = $_GET['amt'];
        $currency = $_GET['cc'];
        $hash = $_GET['cm'];
        $service = $_GET['item_number'];
        $txn = $_GET['tx'];

        $this->load->model('PaypalPaymentsModel');

        if (!$payment = $this->PaypalPaymentsModel->getBy('hash', $hash)) {
            show_404();
        }

        $this->load->model('ServicesModel');
        $this->load->model('SettingsModel');

        $servi = $this->ServicesModel->getBy('id', $payment['service']);

        $this->load->model('ServersModel');

        $bodyData['server'] = $this->ServersModel->getBy('id', $servi['server']);

        if ($payment['status'] == "CREATED") {
            $headerData['settings'] = $this->SettingsModel->get();
            $this->load->model('PagesModel');
            $this->load->model('PurchasesModel');
            $this->load->library('form_validation');

            /**  Head Section  */

            $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Oczekiwanie na weryfikacje płatności PayPal";

            $this->load->view('components/Header', $headerData);


            /**  Body Section  */

            $bodyData['pages'] = $this->PagesModel->getAll();
            $bodyData['displayPage'] = "showWait";

            $bodyData['purchases'] = $this->PurchasesModel->getBy('server', $bodyData['server']['id'], true);
            $servers = $this->ServersModel->getAll();
            $services = $this->ServicesModel->getBy('server', $bodyData['server']['id']);

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

            $this->load->view('Paypal', $bodyData);


            /**  Footer Section  */

            $this->benchmark->mark('code_end');

            $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

            $this->load->view('components/Footer', $footerData);
            return;
        }

        if (
        ($amount != number_format($payment['gross'], 2, '.', '')) ||
        ($currency != $payment['currency']) ||
        ($service != $payment['service']) ||
        ($txn != $payment['txn']) ||
        ($payment['status'] != "COMPLETED")
        ) {
            show_404();
        }

        $data['method'] = "PayPal";
        $data['details'] = "Imię i nazwisko: " . $payment['payer_name'] . "<br/>E-mail: " . $payment['payer_mail'];
        $data['profit'] = $payment['gross'] - $payment['fee'];
        $data['buyer'] = $payment['user'];
        $data['service'] = $servi['id'];
        $data['server'] = $servi['server'];
        $data['date'] = time();

        $this->load->model('PurchasesModel');

        $this->PurchasesModel->add($data);

        $commands = explode(";", $servi['commands']);

        $this->load->helper('rcon_helper');

        $rconResponse = rconCommand($bodyData['server']['ip'], $bodyData['server']['rcon_port'], $bodyData['server']['rcon_pass'], $commands, $payment['user']);

        unset($data);

        if ($rconResponse['value']) {
            $data['status'] = "ENDED";
        } else {
            $data['status'] = "RCON_ERROR";
        }

        $this->PaypalPaymentsModel->update($payment['id'], $data);

        $headerData['settings'] = $this->SettingsModel->get();
        $this->load->model('PagesModel');
        $this->load->model('PurchasesModel');
        $this->load->library('form_validation');

        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Płatność PayPal została zakończona!";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['pages'] = $this->PagesModel->getAll();
        if ($rconResponse['value']) {
            $bodyData['displayPage'] = "Usługa <strong>" . $servi['name'] . "</strong> została pomyślnie zrealizowana!";
        } else {
            $bodyData['displayPage'] = 'error';
        }

        $bodyData['purchases'] = $this->PurchasesModel->getBy('server', $bodyData['server']['id'], true);
        $servers = $this->ServersModel->getAll();
        $services = $this->ServicesModel->getBy('server', $bodyData['server']['id']);

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

        $this->load->view('Paypal', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);
        return;

    }

    public function ipn() {

        if (count($_POST)) {

            $raw_post_data = file_get_contents('php://input');
            $raw_post_array = explode('&', $raw_post_data);
            $myPost = array();
            foreach ($raw_post_array as $keyval) {
                $keyval = explode('=', $keyval);
                if (count($keyval) == 2) {
                    // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                    if ($keyval[0] === 'payment_date') {
                        if (substr_count($keyval[1], '+') === 1) {
                            $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                        }
                    }
                    $myPost[$keyval[0]] = urldecode($keyval[1]);
                }
            }

            $req = 'cmd=_notify-validate';
            $get_magic_quotes_exists = false;
            if (function_exists('get_magic_quotes_gpc')) {
                $get_magic_quotes_exists = true;
            }
            foreach ($myPost as $key => $value) {
                if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                    $value = urlencode(stripslashes($value));
                } else {
                    $value = urlencode($value);
                }
                $req .= "&$key=$value";
            }

            $ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
            curl_setopt($ch, CURLOPT_SSLVERSION, 6);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
            $res = curl_exec($ch);
            if ( ! ($res)) {
                curl_close($ch);
            }

            $info = curl_getinfo($ch);
            $http_code = $info['http_code'];
            if ($http_code == 200) {
                curl_close($ch);
                if ($res == "VERIFIED") {

                    foreach ($_POST as $key => $value) {
                        if ($key == "item_number") {
                            $data['service'] = $value;
                        }
                        if ($key == "txn_id") {
                            $data['txn'] = $value;
                        }
                        if ($key == "custom") {
                            $data['hash'] = $value;
                        }
                        if ($key == "mc_gross") {
                            $data['gross'] = $value;
                        }
                        if ($key == "mc_currency") {
                            $data['currency'] = $value;
                        }
                        if ($key == "mc_fee") {
                            $data['fee'] = $value;
                        }
                        if ($key == "address_name") {
                            $data['payer_name'] = $value;
                        }
                        if ($key == "payer_email") {
                            $data['payer_mail'] = $value;
                        }
                        if ($key == "business") {
                            $reciverEmail = $value;
                        }
                        if ($key == "payment_status") {
                            $paymentStatus = $value;
                        }
                    }

                    $this->load->model('PaypalPaymentsModel');
                    $this->load->model('PaymentsModel');

                    $reciverAdress = $this->PaymentsModel->get(5);
                    $reciverAdress = json_decode($reciverAdress['config'], true);

                    if ($payment = $this->PaypalPaymentsModel->getBy('hash', $data['hash'])) {

                        if (
                            ($data['service'] == $payment['service']) &&
                            ($data['gross'] == number_format($payment['gross'], 2, '.', '')) &&
                            ($data['currency'] == $payment['currency']) &&
                            ($payment['status'] == "CREATED") &&
                            ($reciverEmail == $reciverAdress['adress'])
                        ) {
                            $data['status'] = strtoupper($paymentStatus);

                            $this->PaypalPaymentsModel->update($payment['id'], $data);
                        }

                    }

                }

                header("HTTP/1.1 200 OK");
            }
        }
    }

}