<?php
final class PlanoContratado extends Crud {
    private $_tabela = "plano_contratado";
   
     public function deletePlanoContratado($id) {
        $this->Delete()->ExDelete($this->_tabela, " WHERE id_cliente = :id", "id={$id}");
        return $this->Delete()->getResult();
    }
}