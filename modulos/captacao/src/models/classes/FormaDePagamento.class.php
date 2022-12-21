<?php
final class FormaDePagamento extends Crud {
    private $_tabela = 'forma_de_pagamento';
    private $_sql;

    public function insert($dados) {
        $this->Create()->ExCreate($this->_tabela, $dados);
        return $this->Create()->getResult();
    }
    //VERIFICA DUPLICIDADE :
    public function selectFormaDePagamentoPorIdCliente($id) {
        $this->_sql = " SELECT * FROM " . $this->_tabela . " as fpd  WHERE fpd.id_cliente = {$id}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }
    public function insertFormaDePagamento($Dados) {
        $this->Create()->ExCreate($this->_tabela, $Dados);
        return $this->Create()->getResult();
    }
    public function updateFormaDePagamento($Dados) {
        $id_cliente = $Dados['id_cliente'];
        $id_forma_de_pagamento = $Dados['id_forma_de_pagamento'];
        unset($Dados['id_cliente'], $Dados['id_forma_de_pagamento']);
        $this->Update()->ExUpdate($this->_tabela, $Dados, "WHERE id_cliente = {$id_cliente} AND id_forma_de_pagamento = {$id_forma_de_pagamento}", null);
        return $this->Update()->getResult();
    } 
    
    public function deleteFormaDePagamento($id) {
        $this->Delete()->ExDelete($this->_tabela, " WHERE id_cliente = :id", "id={$id}");
        return $this->Delete()->getResult();
    }
}


