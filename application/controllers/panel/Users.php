<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 13.10.2017 14:57.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged')) redirect(base_url());
    }

    public function index() {

        $this->benchmark->mark('code_start');

        $this->load->library('form_validation');

        $this->load->model('SettingsModel');
        $this->load->model('UsersModel');
        $this->load->model('PagesModel');

        $this->load->helper('date_helper');

        $headerData['settings'] = $this->SettingsModel->get();


        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Użytkownicy ACP";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['users'] = $this->UsersModel->getAll();
        $bodyData['pages'] = $this->PagesModel->getAll();

        $this->load->view('panel/Users', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

    public function create() {
        $this->load->library('form_validation');
        $this->load->helper('string');

        $this->form_validation->set_rules('userName', 'userName', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $data['name'] = $this->input->post('userName');

            $this->load->model('UsersModel');

            if ($this->UsersModel->getBy('name', $data['name'])) {
                $_SESSION['messageDanger'] = "Użytkownik o takiej nazwie już istnieje!";
                redirect(base_url('panel/users'));
            }

            $password = random_string('alnum', 16);
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            $userName = $data['name'];

            if (!$this->UsersModel->add($data)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/users'));
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Użytkownicy ACP";
            $data['details'] = "Utworzono nowego <strong>użytkownika</strong> o nazwie <strong>" . $userName . "</strong>.";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Pomyślnie utworzono nowego użytkownika o nazwie <strong>" . $userName ."</strong>!";
            $_SESSION['newUserInfo'] = "Dane logowania do ACP dla nowego użytkownika:<br />Nazwa użytkownika: <strong>" . $userName . "</strong>, Hasło: <strong>" . $password ."</strong><br /><br />Wyślij te dane jak najszybciej do nowego administratora, ponieważ znikną po przeładowaniu strony!";
            redirect(base_url('panel/users'));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wszystkie pola formularza!";
            redirect(base_url('panel/users'));
        }
    }

    public function remove() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('userId', 'userId', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $userId = $this->input->post('userId');

            $this->load->model('UsersModel');

            if (!$user = $this->UsersModel->getBy('id', $userId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
                redirect(base_url('panel/users'));
            }

            if ($_SESSION['name'] == $user['name']) {
                $_SESSION['messageDanger'] = "Nie możesz usunąć swojego konta!";
                redirect(base_url('panel/users'));
            }

            if (!$this->UsersModel->delete($userId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/users'));
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Użytkownicy ACP";
            $data['details'] = "Użytkownik usunął <strong>użytkownika</strong> o nazwie <strong>" . $user['name'] . "</strong>.";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Pomyślnie usunięto użytkownika o nazwie <strong>" . $user['name'] . "</strong>!";
            redirect(base_url('panel/users'));
        } else {
            $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
            redirect(base_url('panel/users'));
        }
    }

}