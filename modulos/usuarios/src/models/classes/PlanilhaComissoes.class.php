<?php

class PlanilhaComissoes extends Crud {

    private $_tabela = "usuariosPlanilhas";
    private $_sql;

    public function insert($dados) {
        $this->Insert()->ExCreate($this->_tabela, $dados);
        return $this->Insert()->getResult();
    }

    public function updatePlanilha($dados) {
        $this->Update()->ExUpdate($this->_tabela, $dados, "WHERE id= :id", "id={$dados['id']}");
        return $this->Update()->getResult();
    }

    public function selectPlanilhas() {
        $this->Read()->ExRead("planilha_comissoes", "ORDER BY planilha_comissoes_nome", null);
        return $this->Read()->getResult();
    }

    // verifica se existe duplicacao.
    public function contPlhanilha($idU, $idP) {
        $this->_sql = " SELECT * FROM  {$this->_tabela} WHERE usuariosPlanilhas_id_usuarios = " . $idU . " AND  usuariosPlanilhas_id_planilha_comissoes = " . $idP;
        $this->Read()->FullRead($sql, null);
        return $this->Read()->getResult();
    }

    public function selectSetor($id_planilha) {
        $this->Read()->ExRead("planilha_comissoes", "WHERE planilha_comissoes_id = {$id_planilha}", null);
        return $this->limparArray($this->Read()->getResult())['planilha_comissoes_ra'];
    }

}
