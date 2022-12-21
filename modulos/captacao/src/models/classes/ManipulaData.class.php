<?php

require_once("Conexao.class.php");

abstract class ManipulaData extends Conexao {

    private $qr, $tabela, $data, $_id;
    protected $status = NULL;
    protected $id = NULL;
    private $limite = 30;

    #sets and gets.

    public function getId() {
        return $this->id;
    }

    public function getTabela() {
        return $this->tabela;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        if (is_numeric($id)) {
            $this->id = $id;
        }
    }

    public function setTabela($tabela) {
        $this->tabela = $tabela;
    }

    public function setLimite($limite) {
        $this->limite = $limite;
    }

    # metodo utilizando para executar comandos SQL.

    public function insert($table, $dados) {
        $cols = implode(',', array_keys($dados));
        $values = implode(',', array_values($dados));
        $sql = " INSERT INTO " . $table . "($cols)values($values)";

        self::execSQL($sql);
    }

    protected function execSQL($sql) {
        $this->qr = @mysql_query($sql) or die("<b><center>Erro ao Executar o Query: $sql - </b></center><br />" . mysql_error());
        return $this->qr;
    }

    # método que executa e lista dados do banco de dados.

    public function listQr($qr) {
        $this->data = @mysql_fetch_assoc($qr);
        return $this->data;
    }

    public function numRows($qr) {
        $row = @mysql_num_rows($qr);
        return $row;
    }

    # conta o total de registros cadastrados na tabela :array('nome_da_coluna'=>'valor').

    protected function totalRegistro(array $where) {
        $columns = implode('[0]=>', array_keys($where));
        $values = implode('[0]=>', array_values($where));
        if (!empty($where)) {
            $sql = " 
				SELECT  COUNT(*)as total  
				FROM " . $this->tabela . "  
				WHERE " . $columns . " 
				LIKE '%" . $values . "%'";
        } else {
            $sql = " 
				SELECT  COUNT(*)as total 
				FROM " . $this->tabela;
        }
        $re = $this->execSQL($sql);
        return mysql_result($re, 0, "total");
    }

    /* 	
      protected function select(array $where){
      $columns = implode('[0]=>',array_keys($where));
      $values  = implode('[0]=>',array_values($where));
      if(!empty($where)):
      $sql = "
      SELECT  *
      FROM ".$this->tabela."
      WHERE ".$columns."
      LIKE '%".$values."%'
      ORDER BY  captacao_data_criacao DESC limit ".$this->limite;
      else:
      $sql = "
      SELECT  *
      FROM ".$this->tabela ."
      ORDER BY captacao_data_criacao DESC limit ".$limite;
      endif;
      $ret = $this->execSQL($sql);
      while($row = $this->listQr($ret)):
      $res[] = $row;
      endwhile;
      return @$res;
      }
     */
    # converte data no formato amaricano ano-mes-dia.

    protected function converteData($data) {
        $data = explode("/", $data);
        $d = isset($data[1]) ? $data[1] : '';
        $m = isset($data[0]) ? $data[0] : '';
        $y = isset($data[2]) ? $data[2] : '';
        if (!empty($d) && !empty($m) && !empty($y))
            return $data = $y . '-' . $m . '-' . $d;
    }

    public function order($coluna, $value) {
        return $coluna . ' ' . $value;
    }

}
