<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 13.10.2017 20:04.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Pages extends CI_Controller {

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

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Własne strony";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['pages'] = $this->PagesModel->getAll();

        $this->load->view('panel/Pages', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

    public function create() {
        if (!$this->session->userdata('logged')) redirect(base_url());

        $this->load->library('form_validation');

        $this->form_validation->set_rules('pageTitle', 'pageTitle', 'required|trim');
        $this->form_validation->set_rules('pageLink', 'pageLink', 'trim');
        $this->form_validation->set_rules('pageIcon', 'pageIcon', 'trim');
        $this->form_validation->set_rules('pageContent', 'pageContent', 'trim');

        if ($this->form_validation->run() === TRUE) {

            $this->load->model('PagesModel');

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

            if (!$this->PagesModel->add($data)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/pages'));
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Własne strony";
            $data['details'] = "Użytkownik dodał <strong>" . $rm . "</strong> o nazwie <strong>" . $pageTitle . "</strong>.";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Pomyślnie dodano " . $rm . " o nazwie <strong>" . $pageTitle ."</strong>!";
            redirect(base_url('panel/pages'));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wszystkie pola formularza!";
            redirect(base_url('panel/pages'));
        }
    }

    public function changeStatus() {
        if (!$this->session->userdata('logged')) redirect(base_url());

        $this->load->library('form_validation');

        $this->form_validation->set_rules('pageId', 'pageId', 'required|trim');
        $this->form_validation->set_rules('pageStatus', 'pageStatus', 'trim');

        if ($this->form_validation->run() === TRUE) {

            $this->load->model('PagesModel');

            $pageId = $this->input->post('pageId');
            $pageTargetStatus = $this->input->post('pageStatus');

            if (!$page = $this->PagesModel->getBy('id', $pageId, false)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/pages'));
            }

            if ((isset($pageTargetStatus)) && ($pageTargetStatus != null)) $pageTargetStatus = true; else $pageTargetStatus = false;

            $pageTitle = $page['title'];
            $data['active'] = $pageTargetStatus;

            if (!$this->PagesModel->update($pageId, $data)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/pages'));
            }

            if ($page['link'] == null) {
                $rm = "stronę";
            } else {
                $rm = "odnośnik";
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Własne strony";
            if ($pageTargetStatus == true) {
                $data['details'] = "Użytkownik aktywował <strong>" . $rm . "</strong> o nazwie <strong>" . $pageTitle . "</strong>";
            } else {
                $data['details'] = "Użytkownik dezaktywował <strong>" . $rm . "</strong> o nazwie <strong>" . $pageTitle . "</strong>";
            }
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            if ($pageTargetStatus == true) {
                $_SESSION['messageSuccess'] = "Pomyślnie aktywowano " . $rm . " o nazwie <strong>" . $pageTitle ."</strong>!";
            } else {
                $_SESSION['messageSuccess'] = "Pomyślnie dezaktywowano " . $rm . " o nazwie <strong>" . $pageTitle ."</strong>!";
            }
            redirect(base_url('panel/pages'));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wszystkie pola formularza!";
            redirect(base_url('panel/pages'));
        }
    }

    public function remove() {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('pageId', 'pageId', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $pageId = $this->input->post('pageId');

            $this->load->model('PagesModel');

            if (!$page = $this->PagesModel->getBy('id', $pageId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
                redirect(base_url('panel/pages'));
            }

            if ($page['link'] == null) {
                $rm = "stronę";
            } else {
                $rm = "odnośnik";
            }

            if (!$this->PagesModel->delete($pageId)) {
                $_SESSION['messageDanger'] = "Wystąpił błąd podczas łączenia z bazą danych!";
                redirect(base_url('panel/pages'));
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Własne strony";
            $data['details'] = "Użytkownik usunął <strong>" . $rm . "</strong> o nazwie <strong>" . $page['title'] . "</strong>";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Pomyślnie usunięto " . $rm . " o nazwie <strong>" . $page['title'] . "</strong>!";
            redirect(base_url('panel/pages'));
        } else {
            $_SESSION['messageDanger'] = "Wystąpił błąd, spróbuj jeszcze raz!";
            redirect(base_url('panel/pages'));
        }
    }

}