<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class FormularioDeBusca{
    
    private $method = 'get'; 
    private $acao;
    private $hiddens;
    private $filtro;
    private $value;
    private $id = NULL;
    
    public function getMethod() {
        return $this->method;
    }


    public function getAcao() {
        return $this->acao;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function setAcao($acao) {
        $this->acao = $acao;
    }
    
    public function getFiltro() {
        return $this->filtro;
    }

    public function setFiltro($filtro) {
        $this->filtro = $filtro;
    }

    public function formBusca(){
        return  $this->execForm();
        
    }
    
    public function setHiddens($hiddens = array()){
    	$this->hiddens = $hiddens;
    }
    
    public function getHiddens(){
    	$hiddens = "";
    	
    	if(!empty($this->hiddens)){
            foreach ($this->hiddens as $k=>$h){
                    $hiddens .= '<input type="hidden" name="'.$k.'" value="'.$h.'">';
            }
    	}
    	
    	return $hiddens;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    private function  execForm(){
         
        return \str_replace(
            ['#acao#','#method#','#filtro#','#id#', '#hiddens#','#value#'],
            [$this->getAcao(),$this->getMethod(),$this->getFiltro(),$this->getiD(), $this->getHiddens(), $this->getValue()], 
            $this->formHtml()
        );
    }
    
    private function formHtml(){
       return  file_get_contents('application/views/templates/frm_busca.tpl.html');
    }
}

//exemplo :
    
/*
    $formularioBusca = new FormularioDeBusca;
    $formularioBusca->setPg(40);
    $formularioBusca->setAcao('pesquisaServico');
    $formularioBusca->setFiltro('buscarPor');
    $formularioBusca->setId($idCondominio);
    $formularioBusca->formBusca(); 
*/   