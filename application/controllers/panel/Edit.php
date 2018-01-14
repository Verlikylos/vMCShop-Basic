<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 07.11.2017 20:41.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Edit extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged')) redirect(base_url());
    }

    public function server() {

        $this->load->library('form_validation');

        $id = $this->input->post('serverId');

        if ($id == null) {

            $this->load->view('errors/html/error_404.php');
            log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 3) . "] No POST argument given!");
            return;

        } else {


            $this->benchmark->mark('code_start');

            $this->load->model('SettingsModel');
            $this->load->model('ServersModel');
            $this->load->model('PagesModel');

            if (!$bodyData['server'] = $this->ServersModel->getBy('id', $id, false)) {
                $this->load->view('errors/html/error_404.php');
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 2) . "] Server with ID #" . $id . " does not exist in database!");
                return;
            }

            $headerData['settings'] = $this->SettingsModel->get();


            /**  Head Section  */

            $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Edycja serwera " . $bodyData['server']['name'];

            $this->load->view('components/Header', $headerData);


            /**  Body Section  */

            $bodyData['pages'] = $this->PagesModel->getAll();

            $this->load->view('panel/Edit', $bodyData);


            /**  Footer Section  */

            $this->benchmark->mark('code_end');

            $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

            $this->load->view('components/Footer', $footerData);


        }

    }

    public function service() {

        $this->load->library('form_validation');

        $id = $this->input->post('serviceId');

        if ($id == null) {

            $this->load->view('errors/html/error_404.php');
            log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 3) . "] No POST argument given!");
            return;

        } else {


            $this->benchmark->mark('code_start');

            $this->load->model('SettingsModel');
            $this->load->model('ServicesModel');
            $this->load->model('ServersModel');
            $this->load->model('PagesModel');
            $this->load->model('PaymentsModel');
            $this->load->helper('smsnumbers_helper');

            if (!$bodyData['service'] = $this->ServicesModel->getBy('id', $id, false)) {
                $this->load->view('errors/html/error_404.php');
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 2) . "] Service with ID #" . $id . " does not exist in database!");
                return;
            }

            if ($bodyData['service']['smsConfig'] != null) {
                $bodyData['service']['smsConfig'] = json_decode($bodyData['service']['smsConfig'], true);
            }

            $headerData['settings'] = $this->SettingsModel->get();

            if ($headerData['settings']['smsOperator'] == 0) {
                $headerData['smsOperator'] = null;
            } else {
                $headerData['smsOperator'] = $this->PaymentsModel->get($headerData['settings']['smsOperator']);
                $headerData['smsOperator']['config'] = json_decode($headerData['smsOperator']['config']);
            }


            /**  Head Section  */

            $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Edycja usługi " . $bodyData['service']['name'] . " (ID: #" . $bodyData['service']['id'] . ")";

            $this->load->view('components/Header', $headerData);


            /**  Body Section  */

            $bodyData['pages'] = $this->PagesModel->getAll();
            $bodyData['servers'] = $this->ServersModel->getAll();

            $this->load->view('panel/Edit', $bodyData);


            /**  Footer Section  */

            $this->benchmark->mark('code_end');

            $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

            $this->load->view('components/Footer', $footerData);


        }

    }

    public function page() {

        $this->load->library('form_validation');

        $id = $this->input->post('pageId');

        if ($id == null) {

            $this->load->view('errors/html/error_404.php');
            log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 3) . "] No POST argument given!");
            return;

        } else {


            $this->benchmark->mark('code_start');

            $this->load->model('SettingsModel');
            $this->load->model('PagesModel');

            if (!$bodyData['page'] = $this->PagesModel->getBy('id', $id, false)) {
                $this->load->view('errors/html/error_404.php');
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 2) . "] Server with ID #" . $id . " does not exist in database!");
                return;
            }

            $headerData['settings'] = $this->SettingsModel->get();


            /**  Head Section  */

            $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Edycja strony " . $bodyData['page']['title'];

            $this->load->view('components/Header', $headerData);


            /**  Body Section  */

            $bodyData['pages'] = $this->PagesModel->getAll();

            $this->load->view('panel/Edit', $bodyData);


            /**  Footer Section  */

            $this->benchmark->mark('code_end');

            $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

            $this->load->view('components/Footer', $footerData);


        }

    }

    public function serverSave() {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('serverId', 'serverId', 'required|trim');
        $this->form_validation->set_rules('serverName', 'serverName', 'required|trim');
        $this->form_validation->set_rules('serverIp', 'serverIp', 'required|trim');
        $this->form_validation->set_rules('serverPort', 'serverPort', 'required|trim');
        $this->form_validation->set_rules('serverRconPort', 'serverRconPort', 'required|trim');
        $this->form_validation->set_rules('serverRconPass', 'serverRconPass', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $id = $this->input->post('serverId');
            $data['name'] = $this->input->post('serverName');

            if (!preg_match("/^[a-zA-Z0-9]{1,255}[^\s]$/", $data['name'])) {
                $_SESSION['messageDanger'] = "Edycja serwera nie powiodła się! Nazwa serwera zawiera niedozwolone znaki!";
                redirect(base_url('panel/servers'));
            }

            $this->load->model('ServersModel');

            if (!$this->ServersModel->getBy('id', $id)) {
                $_SESSION['messageDanger'] = "Edycja serwera nie powiodła się! Ten serwer nie istnieje w bazie danych!";
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
            }

            $data['ip'] = $this->input->post('serverIp');
            $data['port'] = $this->input->post('serverPort');
            $data['rcon_port'] = $this->input->post('serverRconPort');
            $data['rcon_pass'] = $this->input->post('serverRconPass');
            $serverName = $data['name'];

            if (!$this->ServersModel->update($id, $data)) {
                $_SESSION['messageDanger'] = "Edycja serwera nie powiodła się! Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/servers'));
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Serwery";
            $data['details'] = "Użytkownik edytował <strong>serwer</strong> o nazwie <strong>" . $serverName . "</strong>.";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Pomyślnie edytowano serwer o nazwie <strong>" . $serverName ."</strong>!";
            redirect(base_url('panel/servers'));
        } else {
            $_SESSION['messageDanger'] = "Edycja serwera nie powiodła się! Proszę wypełnić wszystkie pola formularza!";
            redirect(base_url('panel/servers'));
        }
    }

    public function serviceSave() {

        $this->load->model('SettingsModel');

        $this->load->library('form_validation');

        $settings = $this->SettingsModel->get();

        $this->form_validation->set_rules('serviceId', 'serviceId', 'required|trim');
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
            $id = $this->input->post('serviceId');

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

            }

            $this->load->model('ServicesModel');


            if (!$this->ServicesModel->update($id, $data)) {
                $_SESSION['messageDanger'] = "Edycja usługi nie powiodła się! Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/services'));
            }

            $this->load->model('ServersModel');

            $server = $this->ServersModel->getBy('id', $data['server']);

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Usługi";
            $data['details'] = "Użytkownik edytował <strong>usługę</strong> o nazwie <strong>" . $serviceName . "</strong>.";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Pomyślnie edytowano usługę o nazwie <strong>" . $serviceName . "</strong>!";
            redirect(base_url('panel/services'));
        } else {
            $_SESSION['messageDanger'] = "Edycja usługi nie powiodła się! Proszę wypełnić wszystkie pola formularza!";
            redirect(base_url('panel/services'));
        }
    }
    
    public function pageSave() {
        if (!$this->session->userdata('logged')) redirect(base_url());
    
        $this->load->library('form_validation');
    
        $this->form_validation->set_rules('pageId', 'pageId', 'required|trim');
        $this->form_validation->set_rules('pageTitle', 'pageTitle', 'required|trim');
        $this->form_validation->set_rules('pageLink', 'pageLink', 'trim');
        $this->form_validation->set_rules('pageIcon', 'pageIcon', 'trim');
        $this->form_validation->set_rules('pageContent', 'pageContent', 'trim');
    
        if ($this->form_validation->run() === TRUE) {
        
            $this->load->model('PagesModel');
        
            $pageId = $this->input->post('pageId');
            $data['title'] = $this->input->post('pageTitle');
            $data['link'] = ($this->input->post('pageTitle') == null) ? null : $this->input->post('pageLink');
            $data['icon'] = ($this->input->post('pageIcon') == null) ? null : $this->input->post('pageIcon');
            $data['content'] = ($this->input->post('pageContent') == null) ? null : $this->input->post('pageContent');
        
            if (!preg_match("/^[a-zA-Z0-9 ]{1,255}[^\s]$/", $data['title'])) {
                $_SESSION['messageDanger'] = "Nazwa strony zawiera niedozwolone znaki!";
                redirect(base_url('panel/pages'));
            }
        
            if ($data['link'] != null) {
                $rm = "odnośnik";
            } else {
                $rm = "stronę";
            }
            $pageTitle = $data['title'];
        
            if (!$this->PagesModel->update($pageId, $data)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/pages'));
            }
        
            unset($data);
        
            $data['user'] = $_SESSION['name'];
            $data['section'] = "Własne strony";
            $data['details'] = "Użytkownik edytował <strong>" . $rm . "</strong> o nazwie <strong>" . $pageTitle . "</strong>.";
            $data['date'] = time();
        
            $this->load->model('LogsModel');
            $this->LogsModel->add($data);
        
            $_SESSION['messageSuccess'] = "Pomyślnie edytowano " . $rm . " o nazwie <strong>" . $pageTitle ."</strong>!";
            redirect(base_url('panel/pages'));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wszystkie pola formularza!";
            redirect(base_url('panel/pages'));
        }
    }

}