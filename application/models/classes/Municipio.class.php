<?php

final class Municipio extends Crud {

    private $_sql;
    private $_tabela = 'tab_municipios';

    public function consultarCodCidade($municipio, $uf) {
        $this->Read()->ExRead($this->_tabela, "WHERE municipio = '{$municipio}' AND uf = '{$uf}'", null);
        return $this->limparArray($this->Read()->getResult());
    }

}
