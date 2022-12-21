<?php

final class Setor extends Crud {

    private $_id_setor;
    private $_tabela = "setor";

    public function insert($dados = array()) {
        $this->Create()->ExCreate($this->_tabela, $dados);
        return $this->Create()->getResult();
    }
    
    public function insertBase($dados = array()) {
        $this->Create()->ExCreate("base", $dados);
        return $this->Create()->getResult();
    }

    public function updateSetor($dados = array()) {
        $this->Update()->ExUpdate($this->_tabela, $dados, "WHERE setor_id = :id", "id={$dados['setor_id']}");
        return $this->Update()->getResult();
    }

    public function deleteSetor($codSetor) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE setor_id = :id", "id={$codSetor}");
        return $this->Delete()->getResult();
    }

    public function selectTodosSetores() {
        $this->Read()->ExRead($this->_tabela, "WHERE setor_status = 1 ORDER by setor_local", null);
        return $this->Read()->getResult();
    }

    // seleciona um setor:
    public function selSetor($codSetor) {
        if (!empty($this->id)) :
            $this->Read()->ExRead($this->_tabela, "WHERE setor_id = :id", "id={$codSetor}");
            return $this->Read()->getResult();
        else :
            throw new Exception('<br><br><center><b>Atenção</b> : você não tem permissão !<br> contacte o Suporte.</center>');
        endif;
    }

    public function selectFiltroSetor($setor, $limite) {
        $this->Read()->ExRead($this->_tabela, "WHERE setor_local like '%" . $setor . "%' ORDER BY setor_id DESC  limit " . $limite, null);
        return $this->Read()->getResult();
    }
    
    public function selectTodosOsCargos() {
        $this->Read()->ExRead("cargos");
        return $this->Read()->getResult();
    }

}
