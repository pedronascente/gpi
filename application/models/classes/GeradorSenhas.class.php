<?php
class GeradorSenhas {
    
    private $forca =0;
    private $tamanho=9;
    private $vogais = 'aeiouy';
    private $consoantes = 'bdghjmnpqrstvz';
    private $senha = '';
    private $alt;
   
    function getForca() {
        return $this->forca;
    }

    function getTamanho() {
        return $this->tamanho;
    }

    function setForca($forca) {
        $this->forca = $forca;
    }

    function setTamanho($tamanho) {
        $this->tamanho = $tamanho;
    }

    function getVogais() {
        return $this->vogais;
    }

    function setVogais($vogais) {
        $this->vogais = $vogais;
    }

    function getConsoantes() {
        return $this->consoantes;
    }

    function getSenha() {
        return $this->senha;
    }

    function getAlt() {
        return $this->alt;
    }

    function setConsoantes($consoantes) {
        $this->consoantes = $consoantes;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setAlt($alt) {
        $this->alt = $alt;
    }
    
    public function gerarSenha($tamanho,$forca) {
        $this->setTamanho($tamanho);
        $this->setForca($forca);
        $this->setCondicoes();
        return $this->createSenha();
    }
    
    private function setCondicoes(){
        if ($this->forca >= 1)
        {
            $this->consoantes .= 'BDGHJLMNPQRSTVWXZ';
    	}
    	if ($this->forca >= 2) {
            $this->vogais .= "AEUY";
    	}
    	if ($this->forca >= 4) {
            $this->consoantes .= '23456789';
    	}
    	if ($this->forca >= 8 ) {
            $this->vogais .= '@#$%';
    	}
    } 
    
    private function createSenha(){
        $this->alt = time() % 2;
    	for ($i = 0; $i < $this->tamanho; $i++) {
            if ($this->alt == 1) {
                $this->senha .= $this->consoantes[(rand() % strlen($this->consoantes))];
                $this->alt = 0;
            } else {
                $this->senha .= $this->vogais[(rand() % strlen($this->vogais))];
                $this->alt = 1;
            }
    	}
    	return $this->senha;
    }
}

/*
    //exemplo
    $senha  = new GeradorSenhas;
    echo 'senha' .$senha->gerarSenha(50,4);
    var_dump($senha);
*/
