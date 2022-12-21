<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MigrarCaptacao extends MX_Controller {

    public function __construct() {
        $this->load->model('MCaptacao');
        $this->load->model('MUsuario');
        $this->load->library('session');
    }

    public function index() {
        $this->loadPage('Visualizar/page',['arrayListUser'=>$this->MUsuario->get_usuarios()]);
    }

    //Verificar se existe Registro para ser migrado:
    public function migrarCaptacaoSelect(){
        $total_captacao = $this->MCaptacao->select_total_captacao($this->input->post());

        if($total_captacao>0){
            $ret['mensagem'] = 'Registros encontrados :  ' . $total_captacao;
            $ret['total']  = $total_captacao;
        }else{
            $ret['mensagem'] = 'Nenhum Registros encontrado : ' . $total_captacao;
            $ret['total']  = $total_captacao;
        }
        $this->loadPage('Visualizar/migrarCaptacaoSelect',['registro'=>$ret,'filtro'=>$this->input->post()]);
    }

    public function migrarCaptacaoSave(){
         $total_captacao = $this->input->post('total') ; //$this->MCaptacao->select_total_captacao($this->input->post('migrar'));
         $usuarios = $this->MCaptacao->select_vendedor($this->input->post('migrar'));
 
         $data_inicial = $this->input->post('migrar')['data_inicial'];
         $data_fim = $this->input->post('migrar')['data_fim'];
         $mensagem = "<p>O Vendedor : <b>{$usuarios[0]->nome} </b> Recebeu =  <b>{$total_captacao}</b>  captações.  Do Vendedor: <b>{$usuarios[1]->nome} </b>  No periodo  : <b>{$data_inicial} até {$data_fim}</b> .</p>";
         $this->MCaptacao->update_captacao($this->input->post('migrar'));
         $this->session->set_userdata('mensagem', $mensagem) ;
         if($this->session->has_userdata('mensagem')){
                redirect('/migrarcaptacaosucesso', 'location', 301);
         }else{
                redirect('/migrarcaptacao', 'location', 301);
         }
    }

    public function migrarCaptacaoSucesso() {
        $this->loadPage('Visualizar/migrarcaptacaosucesso');
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
            case 'Visualizar/migrarcaptacaosucesso':
            case 'Visualizar/migrarCaptacaoSelect':
            
                return array(
                    'css' => '<link rel="stylesheet" href="' . $url . 'assets/css/bootstrap.min.css"/><link rel="stylesheet" href="' . $url . 'assets/css/bootstrap-datepicker3.min.css"/>',
                    'javaScriptHeader' => '<script src="' . $url . 'assets/js/jquery.min.js"></script><script src="' . $url . 'assets/js/bootstrap.js"></script><script src="' . $url . 'assets/js/bootstrap-datepicker.min.js"></script><script src="' . $url . 'assets/js/bootstrap-datepicker.pt-BR.min.js"></script><script src="' . $url . 'assets/js/vendor/jquery.mask.js"></script>',
                    'javaScriptFooter' => '<script src="' . $url . 'assets/modules/relatorioCaptacao/js/charts.main.js"></script>',
                );
                break;
        }
    }
}
