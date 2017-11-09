<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 14.10.2017 17:56.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Payments extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged')) redirect(base_url());
    }

    public function index() {

        $this->benchmark->mark('code_start');

        $this->load->library('form_validation');

        $this->load->model('SettingsModel');
        $this->load->model('PaymentsModel');
        $this->load->model('PagesModel');

        $headerData['settings'] = $this->SettingsModel->get();

        if ($headerData['settings']['smsOperator'] == 0) {
            $headerData['smsOperator'] = null;
        } else {
            $headerData['smsOperator'] = $this->PaymentsModel->get($headerData['settings']['smsOperator']);
            $headerData['smsOperator']['config'] = json_decode($headerData['smsOperator']['config']);
        }

        $pp = $this->PaymentsModel->get(5);
        $pp = json_decode($pp['config'], true);
        $bodyData['paypal'] = $pp['adress'];


        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Ustawienia płatności";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['pages'] = $this->PagesModel->getAll();

        $this->load->view('panel/Payments', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

    public function update() {

        $this->load->library('form_validation');

        $this->load->model('SettingsModel');
        $this->load->model('PaymentsModel');

        $settings = $this->SettingsModel->get();

        if ($settings['smsOperator'] == 0) {
            $smsOperator = null;
        } else {
            $smsOperator = $this->PaymentsModel->get($settings['smsOperator']);
            $smsOperator['config'] = json_decode($smsOperator['config']);
        }

        $this->form_validation->set_rules('paymentSmsOperator', '', 'required|trim');
        $this->form_validation->set_rules('paymentPercentage', '', 'trim');
        $this->form_validation->set_rules('paymentPaypalAdress', '', 'trim');

        if ($smsOperator['name'] == "MicroSMS.pl") {
            $this->form_validation->set_rules('paymentMicrosmsUserId', '', 'required|trim');
        } elseif ($smsOperator['name'] == "Homepay.pl") {
            $this->form_validation->set_rules('paymentHomepayUserId', '', 'required|trim');
            $this->form_validation->set_rules('paymentHomepayApiKey', '', 'required|trim');
        } elseif ($smsOperator['name'] == "Lvlup.pro") {
            $this->form_validation->set_rules('paymentLvlupUserId', '', 'required|trim');
        } elseif ($smsOperator['name'] == "Pukawka.pl") {
            $this->form_validation->set_rules('paymentPukawkaApiKey', '', 'required|trim');
        }

        if ($this->form_validation->run() === TRUE) {
            $data['smsOperator'] = $this->input->post('paymentSmsOperator');

            if (!$this->SettingsModel->update($data)) {
                $_SESSION['messageDanger'] = "Wystąpił problem podczas łączenia się z bazą danych!";
                redirect(base_url('panel/payments'));
            }

            unset($data);

            if (($this->input->post('paymentPercentage') == null) || ($this->input->post('paymentPercentage') == "")) {
                $percentage = 0.45;
            } else {
                $percentage = str_replace('%', '', $this->input->post('paymentPercentage')) / 100;
            }

            if ($smsOperator['name'] == "MicroSMS.pl") {
                $data['config'] = json_encode(array('sms' => array('userid' => $this->input->post('paymentMicrosmsUserId'), 'percentage' => $percentage)));
            } elseif ($smsOperator['name'] == "Homepay.pl") {
                $data['config'] = json_encode(array('sms' => array('userid' => $this->input->post('paymentHomepayUserId'), 'apikey' => $this->input->post('paymentHomepayApiKey'), 'percentage' => $percentage)));
            } elseif ($smsOperator['name'] == "Lvlup.pro") {
                $data['config'] = json_encode(array('sms' => array('userid' => $this->input->post('paymentLvlupUserId'), 'percentage' => $percentage)));
            } elseif ($smsOperator['name'] == "Pukawka.pl") {
                $data['config'] = json_encode(array('sms' => array('apikey' => $this->input->post('paymentPukawkaApiKey'), 'percentage' => $percentage)));
            }

            if ($smsOperator != null) {
                if (!$this->PaymentsModel->update($settings['smsOperator'], $data)) {
                    $_SESSION['messageDanger'] = "Wystąpił problem podczas łączenia się z bazą danych!";
                    redirect(base_url('panel/payments'));
                }
            }

            unset($data);

            $data['config'] = json_encode(array('adress' => (($this->input->post('paymentPaypalAdress') == null) || ($this->input->post('paymentPaypalAdress') == "")) ? null : $this->input->post('paymentPaypalAdress')));

            if (!$this->PaymentsModel->update(5, $data)) {
                $_SESSION['messageDanger'] = "Wystąpił problem podczas łączenia się z bazą danych!";
                redirect(base_url('panel/payments'));
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Ustawienia Płatności";
            $data['details'] = "Użytkownik zmodyfikował ustawienia płatności.";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Ustawienia płatności zostały pomyślnie zapisane!";
            redirect(base_url('panel/payments'));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wymagane pola formularza!";
            redirect(base_url('panel/payments'));
        }
    }

}