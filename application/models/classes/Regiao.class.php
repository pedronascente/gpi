<?php

final class Regiao extends Crud {

    private $_tabela = 'regiao';
    private $_sql;

    public function select() {
        $this->Read()->ExRead($this->_tabela, "ORDER BY regiao_ddd ASC", null);
        return $this->Read()->getResult();
    }

    public function buscarCodigo($ddd) {
        $this->_sql = "SELECT regiao_id from regiao where regiao_ddd = {$ddd}";
        $this->Read()->FullRead($this->_sql, null);
        $retorno = isset($this->limparArray($this->Read()->getResult())['regiao_id']) ? $this->limparArray($this->Read()->getResult())['regiao_id'] : $this->limparArray($this->Read()->getResult());
        return $retorno;
    }

    public function filtroDddAll() {
        $this->_sql = "
			SELECT 
			d.ddds_usuario_id_usuario, 
			r.regiao_ddd
			FROM ddds_usuario d
			INNER JOIN regiao r 
				ON d.ddds_usuario_id_regiao = r.regiao_id
			ORDER BY d.ddds_usuario_id_usuario, r.regiao_ddd";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function getSql() {
        return $this->_sql;
    }

}
