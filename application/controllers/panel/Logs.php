<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 13.10.2017 19:59.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Logs extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged')) redirect(base_url());
    }

    public function index($page = 1) {

        $this->benchmark->mark('code_start');

        $this->load->model('SettingsModel');
        $this->load->model('LogsModel');
        $this->load->model('PagesModel');

        $headerData['settings'] = $this->SettingsModel->get();
        $logs = $this->LogsModel->getAll();

        if ($page == 1) {
            $start = 0;
        } else {
            $start = ($page - 1) * 15;
        }

        $bodyData['logs'] = $this->LogsModel->getAll($start, 15);

        $this->load->library('pagination');

        $config['base_url'] = base_url('panel/logs');
        $config['total_rows'] = count($logs);
        $config['per_page'] = 15;
        $config['uri_segment'] = 3;
        $config['num_links'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['attributes'] = array('class' => 'page-link');
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;

        $config['full_tag_open'] = '<nav class="mt-5"><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['prev_link'] = '<i class="fa fa-chevron-left" aria-hidden="true"></i>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-chevron-right" aria-hidden="true"></i>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $bodyData['pagination'] = $this->pagination->create_links();


        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Logi";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['pages'] = $this->PagesModel->getAll();

        $this->load->helper('date_helper');

        $this->load->view('panel/Logs', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

}