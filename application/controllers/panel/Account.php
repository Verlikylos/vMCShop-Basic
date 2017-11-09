<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 15.10.2017 01:54.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged')) redirect(base_url());
    }

    public function index() {

        $this->benchmark->mark('code_start');

        $this->load->library('form_validation');

        $this->load->model('SettingsModel');
        $this->load->model('PagesModel');

        $headerData['settings'] = $this->SettingsModel->get();


        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Ustawienia konta";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['pages'] = $this->PagesModel->getAll();

        $this->load->view('panel/Account', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

    public function changepassword() {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('accountPass', 'Hasło1', 'required|trim');
        $this->form_validation->set_rules('accountNewPass', 'Hasło2', 'required|trim');
        $this->form_validation->set_rules('accountNewPassRepeat', 'Hasło3', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $pass1 = $this->input->post('accountPass');
            $pass2 = $this->input->post('accountNewPass');
            $pass3 = $this->input->post('accountNewPassRepeat');

            $this->load->model('UsersModel');

            if (!$user = $this->UsersModel->getBy('name', $_SESSION['name'])) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
                redirect(base_url('panel/account'));
            }

            if (!password_verify($pass1, $user['password'])) {
                $_SESSION['messageDanger'] = "Podano nieprawidłowe aktualne hasło!";
                redirect(base_url('panel/account'));
            }

            if ($pass2 != $pass3) {
                $_SESSION['messageDanger'] = "Podane hasła nie pasują do siebie!";
                redirect(base_url('panel/account'));
            }

            $data['password'] = password_hash($pass2, PASSWORD_DEFAULT);

            if (!$this->UsersModel->update($user['id'], $data)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/account'));
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Ustawienia Konta";
            $data['details'] = "Użytkownik zmienił <strong>swoje hasło</strong>.";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Hasło zostało pomyślnie zmienione!";
            redirect(base_url('panel/account'));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wszystkie pola formularza!";
            redirect(base_url('panel/account'));
        }
    }

}