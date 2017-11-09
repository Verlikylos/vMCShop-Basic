<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 02.11.2017 01:41.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Page extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($pageName = null) {

        if ($pageName == null) {

            $this->load->view('errors/html/error_404.php');
            log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 3) . "] No GET argument given!");
            return;

        } else {


            $this->benchmark->mark('code_start');

            $this->load->model('SettingsModel');
            $this->load->model('PagesModel');

            $headerData['settings'] = $this->SettingsModel->get();

            if (!$bodyData['page'] = $this->PagesModel->getBy('title', str_replace('-', ' ', $pageName))) {
                $this->load->view('errors/html/error_404.php');
                log_message('error', "[Controller: " . ucfirst($this->uri->segment(1)) . ".php | Line: " . (__LINE__ - 2) . "] Server with name '" . $pageName . "' does not exist in database!");
                return;
            }

            if ($bodyData['page']['active'] == 0) {
                $this->load->view('errors/html/error_404.php');
                return;
            }

            if ($bodyData['page']['link'] != null) {
                redirect($bodyData['page']['link']);
            }


            /**  Head Section  */

            $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Sklep serwera ";

            $this->load->view('components/Header', $headerData);


            /**  Body Section  */

            $bodyData['pages'] = $this->PagesModel->getAll();

            $this->load->view('Page', $bodyData);


            /**  Footer Section  */

            $this->benchmark->mark('code_end');

            $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

            $this->load->view('components/Footer', $footerData);


        }

    }

}