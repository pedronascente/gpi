<?php
/*
* 24/06/2016
* ManutencaoInicio
*/
    final class Seguro extends Crud {

        private $_tabela = 'seguro';
        private $_sql;

        public function getSeguro() {
            $this->_sql = " SELECT  * FROM " . $this->_tabela;
            $this->Read()->FullRead($this->_sql, null);
            return $this->Read()->getResult();
        }

    }
/*
* 24/06/2016
* ManutencaoFim
*/