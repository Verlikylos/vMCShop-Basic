<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 14.10.2017 18:08.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Settings extends CI_Controller {

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

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Ustawienia strony";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['pages'] = $this->PagesModel->getAll();

        $this->load->view('panel/Settings', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

    public function update() {

        $this->load->library('form_validation');
        $this->load->model('SettingsModel');

        $this->form_validation->set_rules('settingPageTitle', '', 'required|trim');
        $this->form_validation->set_rules('settingPageDesc', '', 'trim');
        $this->form_validation->set_rules('settingPageTags', '', 'trim');
        $this->form_validation->set_rules('settingFavicon', '', 'trim');
        $this->form_validation->set_rules('settingPageLogo', '', 'trim');
        $this->form_validation->set_rules('settingPageBackground', '', 'required|trim');
        $this->form_validation->set_rules('settingPageBroadcast', '', 'trim');
        $this->form_validation->set_rules('settingVoucherPrefix', '', 'trim');
        $this->form_validation->set_rules('settingVoucherLenght', '', 'required|trim');
        $this->form_validation->set_rules('settingPageTheme', '', 'required|trim');
        $this->form_validation->set_rules('settingSidebarPos', '', 'required|trim');
        $this->form_validation->set_rules('settingLastBuyersPos', '', 'required|trim');
        //$this->form_validation->set_rules('settingServicesListLayout', '', 'required|trim');

        if ($this->form_validation->run() === TRUE) {
            $data['pageTitle'] = $this->input->post('settingPageTitle');
            $data['pageDesc'] = ($this->input->post('settingPageDesc') == null) ? null : $this->input->post('settingPageDesc');
            $data['pageTags'] = ($this->input->post('settingPageTags') == null) ? null : $this->input->post('settingPageTags');
            $data['favicon'] = ($this->input->post('settingFavicon') == null) ? null : $this->input->post('settingFavicon');
            $data['pageLogo'] = ($this->input->post('settingPageLogo') == null) ? null : $this->input->post('settingPageLogo');
            $data['pageBackground'] = $this->input->post('settingPageBackground');
            $data['pageBroadcast'] = ($this->input->post('settingPageBroadcast') == null) ? null : $this->input->post('settingPageBroadcast');
            $data['voucherPrefix'] = ($this->input->post('settingVoucherPrefix') == null) ? null : $this->input->post('settingVoucherPrefix');
            $data['voucherLength'] = $this->input->post('settingVoucherLenght');
            $data['pageTheme'] = $this->input->post('settingPageTheme');
            $data['sidebarPos'] = $this->input->post('settingSidebarPos');
            $data['lastBuyersPos'] = $this->input->post('settingLastBuyersPos');
            //$data['serviceListLayout'] = $this->input->post('settingServicesListLayout');

            if (!$this->SettingsModel->update($data)) {
                $_SESSION['messageDanger'] = "Wystąpił problem podczas łączenia się z bazą danych!";
                redirect(base_url('panel/settings'));
            }

            unset($data);

            $data['user'] = $_SESSION['name'];
            $data['section'] = "Ustawienia Strony";
            $data['details'] = "Użytkownik zmodyfikował konfigurację strony.";
            $data['date'] = time();

            $this->load->model('LogsModel');
            $this->LogsModel->add($data);

            $_SESSION['messageSuccess'] = "Ustawienia zostały pomyślnie zapisane!";
            redirect(base_url('panel/settings'));
        } else {
            $_SESSION['messageDanger'] = "Proszę wypełnić wymagane pola formularza!";
            redirect(base_url('panel/settings'));
        }
    }

}