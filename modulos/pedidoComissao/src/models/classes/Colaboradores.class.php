<?php

final class Colaboradores extends Crud {

    private $_id_colaborador;
    private $_id_empresa;
    private $_id_base;
    private $_nome_colaborador;
    private $_ctps;
    private $_matricula;
    private $_tabela = "Colaboradores";

    public function setId_colaborador($id_colaborador){
        $this->_id_colaborador = $id_colaborador;
    }
    public function setId_empresa($id_empresa){
        $this->_id_empresa = $id_empresa;
    }
    public function setId_base($id_base){
        $this->_id_base = $id_base;
    }
    public function setNome_colaborador($nome_colaborador){
        $this->_nome_colaborador = $nome_colaborador;
    }
    public function setCtps($ctps){
        $this->_ctps = $ctps;
    }
    public function setMatricula($matricula){
        $this->_matricula = $matricula;
    }

    public function selectTodosUsuarios(){
        $this->Read()->ExRead($this->_tabela, "ORDER BY nome_colaborador ASC", null);
        return $this->Read()->getResult();
    }

}
