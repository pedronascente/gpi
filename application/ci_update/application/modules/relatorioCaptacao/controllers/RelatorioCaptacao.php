<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RelatorioCaptacao extends MX_Controller {

    public function __construct() {
        $this->load->model('MCaptacao');
    }

    public function index() {
       $this->loadPage('Visualizar/page');
    }

    public function get_geral() {
        die(json_encode([
            'captacao_status' => $this->MCaptacao->get_total_de_leads_por_status(),
            'origem' => $this->MCaptacao->get_total_de_leads_por_origem(),
            'ano' => $this->MCaptacao->get_total_de_leads_por_ano(),
            'captacao_uf' => $this->MCaptacao->get_total_de_leads_por_UF(),
            'selects' => [
                'origem' => $this->MCaptacao->get_select("origem"),
                'status' => $this->MCaptacao->get_select("status"),
                'uf' => $this->MCaptacao->get_select("uf"),
            ],
        ]));
    }

    public function get_filtros($key, $p1, $p2, $p3) {
        switch ($key) {
            case 'status':
                die(json_encode([
                    'captacao_status' => $this->MCaptacao->get_captacao_status([
                        'origem' => $p1,
                        'uf' => $p2,
                        'periodo' => $p3
                    ])
                ]));
                break;
            case 'uf':
                die(json_encode([
                    'uf' => $this->MCaptacao->get_captacao_uf([
                        'status' => $p1,
                        'origem' => $p2,
                        'periodo' => $p3
                    ])
                ]));
                break;
            case 'origem':
                die(json_encode([
                    'origem' => $this->MCaptacao->get_captacao_origem([
                        'status' => $p1,
                        'uf' => $p2,
                        'periodo' => $p3
                    ])
                ]));
                break;
        }
    }

    public function get_filtros_dinamico($p1, $p2, $p3, $p4) {
        die(json_encode(['total_leads' => $this->MCaptacao->get_filtros_dinamico([
                'status' => $p1,
                'origem' => $p2,
                'uf' => $p3,
                'periodo' => $p4,
            ])
        ]));
    }

    private function get_captacao_status($paramentro) {
        $this->MCaptacao->get_captacao_status($paramentro);
    }

    private function get_captacao_origem($paramentro) {
        $this->MCaptacao->get_captacao_origem($paramentro);
    }

    private function get_captacao_uf($paramentro) {
        $this->MCaptacao->get_captacao_uf($paramentro);
    }

    private function loadPage($moduleRoute, $parameters = '') {
        $data['assets'] = $this->loadAssets($moduleRoute);
        $data['content'] = $this->load->view($moduleRoute, $parameters, TRUE);
        $this->load->view('page', $data);
    }

    private function loadAssets($moduleRoute) {
        $url = base_url();
        switch ($moduleRoute) {
            case 'Gerenciar/page':
                return array(
                );
                break;
            case 'Visualizar/page':
                return array(
                    'css' => '<link rel="stylesheet" href="' . $url . 'assets/css/bootstrap.min.css"/><link rel="stylesheet" href="' . $url . 'assets/css/bootstrap-datepicker3.min.css"/>',
                    'javaScriptHeader' => '<script src="' . $url . 'assets/js/jquery.min.js"></script><script src="' . $url . 'assets/js/bootstrap.js"></script><script src="' . $url . 'assets/js/bootstrap-datepicker.min.js"></script><script src="' . $url . 'assets/js/bootstrap-datepicker.pt-BR.min.js"></script><script src="' . $url . 'assets/js/vendor/jquery.mask.js"></script>',
                    'javaScriptFooter' => '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script><script src="' . $url . 'assets/modules/relatorioCaptacao/js/charts.main.js"></script>',
                );
                break;
        }
    }
}
