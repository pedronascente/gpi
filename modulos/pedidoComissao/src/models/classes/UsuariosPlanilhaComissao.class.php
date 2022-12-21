<?php
class UsuariosPlanilhaComissao extends Crud 
{
    private $_tabela = 'usuarios_da_planilha_de_comissao';
    
    public function getByParam($coluna) {
        $this->_sql = "SELECT {$coluna} from {$this->_tabela} order by nome asc";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }
    
    public function getEmpresa($param) {
        $this->_sql = "SELECT empresa from {$this->_tabela}   where nome =$param";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }
    	
}