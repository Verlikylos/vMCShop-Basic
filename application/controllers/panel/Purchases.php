<?php
defined('BASEPATH') OR exit('No direct script access allowed!');

/**
 * Created with ♥ by Verlikylos on 13.10.2017 19:09.
 * Visit www.verlikylos.pro for more.
 * Copyright © vMCShop Basic 2017
*/

class Purchases extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged')) redirect(base_url());
    }

    public function index($page = 1) {

        $this->benchmark->mark('code_start');

        $this->load->model('SettingsModel');
        $this->load->model('PurchasesModel');
        $this->load->model('ServersModel');
        $this->load->model('ServicesModel');
        $this->load->model('PagesModel');
        $this->load->helper('date_helper');

        $headerData['settings'] = $this->SettingsModel->get();

        $purchases = $this->PurchasesModel->getAll();

        if ($page == 1) {
            $start = 0;
        } else {
            $start = ($page - 1) * 15;
        }

        $bodyData['purchases'] = $this->PurchasesModel->getAll($start, 15);

        $this->load->library('pagination');

        $config['base_url'] = base_url('panel/purchases');
        $config['total_rows'] = count($purchases);
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

        $servers = $this->ServersModel->getAll();
        $services = $this->ServicesModel->getAll();

        foreach ($servers as $server) {
            for ($i = 0; $i < count($services); $i++) {
                if ($services[$i]['server'] == $server['id']) {
                    for ($x = 0; $x < count($bodyData['purchases']); $x++) {
                        if ($bodyData['purchases'][$x]['service'] == $services[$i]['id']) {
                            $bodyData['purchases'][$x]['service'] = $services[$i]['name'] . " (ID: #" . $services[$i]['id'] . ")";
                            $bodyData['purchases'][$x]['server'] = $server['name'];
                        }
                    }
                }
            }
        }

        $bodyData['pagination'] = $this->pagination->create_links();


        /**  Head Section  */

        $headerData['page_title'] = $headerData['settings']['pageTitle'] . " | Historia zakupów";

        $this->load->view('components/Header', $headerData);


        /**  Body Section  */

        $bodyData['pages'] = $this->PagesModel->getAll();

        $this->load->view('panel/Purchases', $bodyData);


        /**  Footer Section  */

        $this->benchmark->mark('code_end');

        $footerData['benchmark'] = $this->benchmark->elapsed_time('code_start', 'code_end');

        $this->load->view('components/Footer', $footerData);


    }

}