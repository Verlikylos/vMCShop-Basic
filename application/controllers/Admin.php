<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

/**
 * Created with ♥ by Verlikylos on 11.10.2017 19:55.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->session->userdata('logged')) redirect(base_url('panel/dashboard'));

        $this->benchmark->mark('code_start');

        $this->load->library('form_validation');

        $this->load->model('SettingsModel');
        $this->load->model('PagesModel');

        $headerData['settings'] = $this->SettingsModel->get();


        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Logowanie do ACP";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['pages'] = $this->PagesModel->getAll();

        $this->load->view('Admin', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

    public function login() {
        if ($this->session->userdata('logged')) redirect(base_url('panel/dashboard'));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('authLogin', 'Login', 'required|trim');
        $this->form_validation->set_rules('authPass', 'Hasło', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $login = $this->input->post('authLogin');
            $pass = $this->input->post('authPass');

            $this->load->model('UsersModel');

            if (!$user = $this->UsersModel->getBy('name', $login)) {
                $_SESSION['messageDanger'] = "Podano nieprawidłowy login lub hasło!";
                redirect(base_url('admin'));
            }

            if (!password_verify($pass, $user['password'])) {
                $_SESSION['messageDanger'] = "Podano nieprawidłowy login lub hasło!";
                redirect(base_url('admin'));
            }

            $this->session->set_userdata('logged', TRUE);
            $this->session->set_userdata('name', $user['name']);

            $data['lastIP'] = getenv('HTTP_CLIENT_IP') ? : getenv('HTTP_X_FORWARDED_FOR') ? : getenv('HTTP_X_FORWARDED') ? : getenv('HTTP_FORWARDED_FOR') ? : getenv('HTTP_FORWARDED') ? : getenv('REMOTE_ADDR');
            if ($data['lastIP'] == "::1") $data['lastIP'] = "127.0.0.1";
            $ip = $data['lastIP'];
            $data['lastLogin'] = time();
            if (strpos(base_url() , 'vmcshop.pro') == true) {
                $ip = "W demo ukryte";
            }

            $this->UsersModel->update($user['id'], $data);

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Logowanie";
            $data['details'] = $ip;
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Zalogowano pomyślnie!<br />Witaj w panelu administratora <strong>" . $user['name'] . "</strong>!";
            redirect(base_url('panel/dashboard'));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wszystkie pola formularza logowania!";
            redirect(base_url('admin'));
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function consoleSendCommands() {
        if (!$this->session->userdata('logged')) redirect(base_url());

        require_once(APPPATH.'libraries/MinecraftPing.php');
        require_once(APPPATH.'libraries/MinecraftPingException.php');
        $this->load->library('form_validation');
        $this->load->model('ServersModel');

        $servers = $this->ServersModel->getAll();

        for ($i = 0; $i < count($servers); $i++) {

            try {
                $Query = new MinecraftPing($servers[$i]['ip'], $servers[$i]['port']);
                $servers[$i]['status']['online'] = true;
            } catch (MinecraftPingException $e) {
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 1) . "] MinecraftPingException: " . $e->getMessage());
            } finally {
                if (isset($Query)) $Query->Close();
            }

            $this->form_validation->set_rules('consoleInputServer'.$servers[$i]['id'], 'consoleInputServer'.$servers[$i]['id'], 'trim');

        }

        if ($this->form_validation->run() === TRUE) {

            $this->load->helper('rcon_helper');

            foreach ($servers as $server) {
                if (($this->input->post('consoleInputServer'.$server['id']) != null) || ($this->input->post('consoleInputServer'.$server['id']) != "")) {
                    if (!isset($server['status'])) {
                        $_SESSION['messageDanger'] = "Serwer, na którym próbowałeś wykonać polecenia jest offline!";
                        redirect(base_url('panel/console/' . $server['name']));
                    } else {
                        $result = rconCommand($server['ip'], $server['rcon_port'], $server['rcon_pass'], array($this->input->post('consoleInputServer'.$server['id'])));

                        if ($result['value'] == true) {
                            $_SESSION['messageSuccess'] = $result['message'];
                            if (isset($_SESSION['consoleOutput' . $server['id']])) {
                                foreach ($result['output'] as $output) {
                                    if ($output != "") {
                                        $_SESSION['consoleOutput' . $server['id']] = $_SESSION['consoleOutput' . $server['id']]  . "[" . date('H:i:s', time()) . "] " .  $output;
                                    }
                                }
                            } else {
                                $i = 0;
                                foreach ($result['output'] as $output) {
                                    if ($output != "") {
                                        if ($i == 0) {
                                            $_SESSION['consoleOutput' . $server['id']] = "[" . date('H:i:s', time()) . "] " . $output;
                                        } else {
                                            $_SESSION['consoleOutput' . $server['id']] = $_SESSION['consoleOutput' . $server['id']] . "[" . date('H:i:s', time()) . "] " .  $output;
                                        }
                                    }
                                    $i++;
                                }
                            }

                            $this->load->model('LogsModel');

                            $data['user'] = $_SESSION['name'];
                            $data['section'] = "Konsola";
                            $data['details'] = "Użytkownik wykonał <span class='text-success' data-toggle='tooltip' title='" . $this->input->post('consoleInputServer'.$server['id']) . "'>komendę</span> przez konsolę serwera <strong>" . $server['name'] . "</strong>.";
                            $data['date'] = time();

                            $this->load->model('LogsModel');
                            $this->LogsModel->add($data);

                            redirect(base_url('panel/console/' . $server['name']));
                        } else {
                            $_SESSION['messageDanger'] = $result['message'];
                            redirect(base_url('panel/console'));
                        }
                    }
                }
            }

        } else {
            $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia się z serwerem!";
            redirect(base_url('panel/console/' . $server['name']));
        }
    }

}