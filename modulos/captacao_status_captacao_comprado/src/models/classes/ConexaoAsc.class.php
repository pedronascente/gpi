<?php

class ConexaoAsc {

    private $fonteOdbc;
    private $senha;
    private $user;
    private $conn;

    #METODO DE CONEXAO AO BANCO DE DADOS DO ASC

    public function __construct() {
        # SERVIDOR    $connect = odbc_connect("teste_sql",'asc_user','ascinfo');
        $this->fonteOdbc = "teste_sql";
        $this->senha = "asc_user";
        $this->user = "ascinfo";
        $this->conectar();
    }

    public function __destruct() {
        #FECHA A CONEXAO DO BANCO DE DADOS DO ASC
        odbc_close($this->conn['conn']);
    }

    public function conectar() {
        $connect = odbc_connect($this->fonteOdbc, $this->senha, $this->user);
        if ($connect) {
            $retorn['status'] = 'ok';
            $retorn['conn'] = $connect;
            $this->conn = $retorn;
        } else {
            $retorn['status'] = 'erro';
            $retorn['msg'] = odbc_errormsg();
            $this->conn = $retorn;
        }
    }

    #METODO DE RETORNO DA CONEXAO DO BANCO DE DADOS DO ASC

    public function getConn() {
        return $this->conn;
    }

    #CONSULTA ULTIMO ID ASC
    /* public function getTeste($tbl,$campo,$arrWhere=NULL){
      $where="";
      if($arrWhere){
      $where = NULL;
      foreach($arrWhere as $i=>$valor){
      $where .= (!$where)? " WHERE ".$i." = ".$valor : " AND ".$i." = ".$valor;
      }
      }
      $tsql = "SELECT MAX(".$campo.") AS ID FROM ".$tbl.$where;
      $result = odbc_exec($this->conn['conn'], $tsql);
      $ret = odbc_fetch_row($result);
      return odbc_result($result, 'ID');
      }
     */
}
