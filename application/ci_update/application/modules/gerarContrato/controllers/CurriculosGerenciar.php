<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CurriculosGerenciar extends MX_Controller {
    public function __construct() {        
        $this->load->model('curriculo');
        $this->load->model('selects');
    }

    public function gerenciar() {
        $maximo = 20;
        $pageGet = $this->input->get();
        $cookieFiltros = (isset($_COOKIE['filtros'])) ? $_COOKIE['filtros'] : null;
        $inicio = 0;
        if ((null == $pageGet) && (null != $cookieFiltros)) {
            $filtros = array_filter(json_decode($cookieFiltros, true), create_function('$value', 'return $value !== "";'));
        } else {
            $filtros = array_filter($pageGet, create_function('$value', 'return $value !== "";'));
            setcookie('filtros', json_encode($pageGet));
        }
        if (isset($pageGet['per_page'])) {
            $inicio = $pageGet['per_page'];
        }
        unset($filtros['per_page']);
        $filtros = array_filter($filtros, create_function('$value', 'return $value !== "";'));
        $getedData = $this->getData($maximo, $inicio, $filtros);       
        $this->pagination->initialize(configPaginacao(base_url('gerenciar?' . http_build_query($filtros)), $getedData['count'], $maximo));
        $urlPagination = $this->pagination->create_links();
        $total = count($this->curriculo->getTotalRegistro());
        $data['selects'] = $this->getSelects();
        $data['content'] = $getedData['content'];
        $data['count'] = $getedData['count'];
        $data['paginacao'] = $urlPagination;
        $data['total_registro'] = $total;
        $ArrayListCandidato = $this->buscarDadosviaWS(array("TABELA" => 'rh_candidato'));
        if (NULL !==$ArrayListCandidato) {
            $data['respostaAtualizarDados'] = count($ArrayListCandidato['rh_candidato']);
        } else {
            $data['respostaAtualizarDados'] = false;
        }
        $this->loadPage('Gerenciar/page', $data);
    }
    
    private function buscarDadosviaWS($arrayData) {
        $url = "http://www.seguidor.com.br/api_restful_gpi/rh/list/{$arrayData['TABELA']}";
        if (isset($arrayData['ID']) && $arrayData['ID'] > 0) {
            $url = "http://www.seguidor.com.br/api_restful_gpi/rh/list/{$arrayData['TABELA']}/{$arrayData['CAMPO']}/{$arrayData['ID']}";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        $result = curl_exec($ch);
        
        return json_decode($result, true);
    }

    public function visualizar($id) {
        $data['colaborador'] = $this->getColaborador($id);
        if (!is_null($data['colaborador']['dadosPessoais'])) {
            $this->loadPage('Visualizar/page', $data);
        } else {
            $cookieActualLink = (isset($_COOKIE['actual_link'])) ? $_COOKIE['actual_link'] : $this->config->base_url();
            $msg['msg'] = 'Não foi possivel localizar o colaborador';
            $msg['type'] = 'danger';
            $msg['callBack'] = $cookieActualLink;
           $this->loadPage('Transicoes/transicao', $msg);
        }
    }

    public function editar($id) {
        $data['colaborador'] = $this->getColaborador($id);
        $data['selects'] = $this->getSelects(null, null);
        $this->loadPage('Editar/page', $data);
    }

    public function salvarEdicao() {
        $posted = $this->input->post();
        $result = $this->curriculo->salvarEdicao($posted);
        if ($result['boll']) {
            $msg['msg'] = 'Alteração realizada com sucesso.';
            $msg['type'] = 'success';
            $msg['callBack'] = base_url('visualizar/' . $result['id']);
            $this->loadPage('Transicoes/transicao', $msg);
        } else {
            $msg['msg'] = 'Não foi possivel realizar a ação, tente novamente mais tarde.';
            $msg['type'] = 'danger';
            $this->loadPage('Transicoes/transicao', $msg);
        }
    }

    public function getSelects($list = NULL, $selected = NULL) {
        $content = $this->selects->getData($list, $selected);
        return $content;
    }

    public function getData($maximo, $inicio, $filtros) {
        $content = $this->curriculo->getData($maximo, $inicio, $filtros);
        return $content;
    }

    public function getColaborador($id) {

        $content = $this->curriculo->getColaborador($id);
        return $content;
    }

    private function loadPage($moduleRoute, $parameters = '') {
        $data['assets'] = $this->loadAssets($moduleRoute);
        $data['content'] = $this->load->view($moduleRoute, $parameters, TRUE);
        $this->load->view('page', $data);
    }

    public function excluir($id) {
        $result = $this->curriculo->excluir($id);
        if ($result) {
            $msg['msg'] = 'Exclusão Realizada com sucesso!';
            $msg['type'] = 'success';
            $msg['callBack'] = (isset($_COOKIE['actual_link'])) ? $_COOKIE['actual_link'] : $this->config->base_url();
            $this->loadPage('Transicoes/transicao', $msg);
        } else {
            $msg['msg'] = 'Não foi possivel realizar a ação, tente novamente mais tarde.';
            $msg['type'] = 'danger';
            $msg['callBack'] = base_url('visualizar/' . $id);
            $this->loadPage('Transicoes/transicao', $msg);
        }
    }

    private function loadAssets($moduleRoute) {
        $url = base_url();
        switch ($moduleRoute) {
            case 'Gerenciar/page':
                return array(
                    'css' => '<link rel="stylesheet" href="' . $url . 'assets/css/bootstrap.min.css"/><link rel="stylesheet" href="' . $url . 'assets/css/main.css"/><link rel="stylesheet" href="' . $url . 'assets/css/bootstrap-select.min.css"/><link rel="stylesheet" href="' . $url . 'assets/css/bootstrap-datepicker3.min.css"/><link rel="stylesheet" href="' . $url . 'assets/css/bootstrap-theme.min.css"/>',
                    'javaScriptHeader' => '<script src="' . $url . 'assets/js/jquery.min.js"></script><script src="' . $url . 'assets/js/bootstrap.js"></script><script src="' . $url . 'assets/js/bootstrap-select.js"></script><script src="' . $url . 'assets/js/bootstrap-datepicker.min.js"></script><script src="' . $url . 'assets/js/bootstrap-datepicker.pt-BR.min.js"></script>',
                    'javaScriptFooter' => '<script src="' . $url . 'assets/modules/CurriculoGerenciar/Gerenciar/js/main.js"></script>'
                );
                break;
            case 'Visualizar/page':
            case 'Editar/page':
                return array(
                    'css' => '<link rel="stylesheet" href="' . $url . 'assets/css/bootstrap.min.css"/><link rel="stylesheet" href="' . $url . 'assets/css/main.css"/><link rel="stylesheet" href="' . $url . 'assets/css/bootstrap-select.min.css"/><link rel="stylesheet" href="' . $url . 'assets/css/bootstrap-datepicker3.min.css"/><link rel="stylesheet" href="' . $url . 'assets/modules/CurriculoGerenciar/Visualizar/css/main.css"/><link rel="stylesheet" href="' . $url . 'assets/css/bootstrap-theme.min.css"/>',
                    'javaScriptHeader' => '<script src="' . $url . 'assets/js/jquery.min.js"></script><script src="' . $url . 'assets/js/bootstrap.js"></script><script src="' . $url . 'assets/js/bootstrap-select.js"></script><script src="' . $url . 'assets/js/bootstrap-datepicker.min.js"></script><script src="' . $url . 'assets/js/bootstrap-datepicker.pt-BR.min.js"></script>',
                    'javaScriptFooter' => '<script src="' . $url . 'assets/modules/CurriculoGerenciar/Gerenciar/js/main.js"></script><script src="' . $url . 'assets/modules/CurriculoGerenciar/Visualizar/js/main.js"></script>'
                );
                break;
            case 'Transicoes/transicao':
                return array(
                    'css' => '',
                    'javaScriptHeader' => '',
                    'javaScriptFooter' => ''
                );
                break;
        }
    }

    public function arquivar($id) {
        $this->curriculo->setArquivar('rh_candidato', array('arquivar'=>1), $id);
        redirect('gerenciar');
       
    }

}
