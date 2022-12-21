<?php

class Modulo extends Crud {

    private $_tabela = "modulos";
    private $modulo_id;
    private $modulo_serial;
    private $modulo_modelo;
    private $modulo_status;
    private $modulo_obs;
    private $modulo_obs_defeito;
    private $_sql = "";
    private $_filtros = "";
    private $lista = array();

    public function setDados($Dados) {
        if (!empty($Dados)) {
            foreach ($Dados as $k => $d) {
                $this->$k = $d;
            }
        }
    }

    //CRIA UM ARRAY DE OBJETOS E COLOCA NA LISTA
    public function setDadosLista($Dados) {
        $this->lista = array();

        if (!empty($Dados)) {
            foreach ($Dados as $k1 => $d) {
                $c = new Modulo;
                foreach ($d as $k2 => $dado) {
                    $c->set($k2, $dado);
                }
                $this->lista[$k1] = $c;
            }
        }
    }

    //SET E GET GENERICO
    public function set($key, $dado) {
        $this->$key = $dado;
    }

    public function get_modulo_status() {
        $modulo = "";

        switch ($this->modulo_status) {
            case 1: $modulo = "Novo";
                break;
            case 2: $modulo = "Com Defeito";
                break;
            case 3: $modulo = "Programado";
                break;
        }

        return $modulo;
    }

    public function get($key, $original = FALSE) {
        $metodo = "get_" . $key;

        if (method_exists($this, $metodo) && !$original)
            return $this->$metodo();
        else
            return $this->$key;
    }

    public function insert($Dados) {
        $this->Create()->ExCreate($this->_tabela, $Dados);
        return $this->Create()->getResult();
    }

    public function atualizar($Dados) {
        $this->Update()->ExUpdate($this->_tabela, $Dados, "WHERE modulo_id = {$Dados['modulo_id']}", null);
        return $this->Update()->getResult();
    }

    public function listar($status, $id_modulo = NULL, $limite = NULL) {
        $limite = !empty($limite) ? "LIMIT {$limite}" : "";
        $id_modulo = !empty($id_modulo) ? "OR modulo_id = {$id_modulo}" : "";
        $status = !empty($status) ? "AND (modulo_status = {$status} {$id_modulo})" : "";
        $this->Read()->ExRead($this->_tabela, "WHERE modulo_id = modulo_id {$this->_filtros} {$status} {$limite}");
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function select($id) {
        $this->Read()->ExRead($this->_tabela, "WHERE modulo_id = {$id}", null);
        $this->setDados($this->limparArray($this->Read()->getResult()));
    }

    public function selectArray($id) {
        $this->Read()->ExRead($this->_tabela, "WHERE modulo_id = {$id}", null);
        return $this->limparArray($this->Read()->getResult());
    }
    
    public function selectArrayModulo($modulo, $status = NULL) {
    	$status = !empty($status) ? "AND modulo_status = {$status}" : "";
        $this->Read()->ExRead($this->_tabela, "WHERE modulo_serial = '{$modulo}' {$status} ORDER by modulo_id DESC", null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function deleteModulo($id) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE modulo_id = {$id}", null);
        return $this->Delete()->getResult();
    }

    public function setFiltros($busca) {
        $campos = array("modulo_serial",
                    "modulo_modelo",
                    "modulo_obs",
        );

        $this->_filtros = $this->filtrar($campos, $busca);
    }

}
