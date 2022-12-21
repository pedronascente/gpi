<?php

abstract class Conexao {

    private $host, $user, $pass, $dbname;
    private $host_server, $user_server, $pass_server, $dbname_server;
    static $conn = null;
    static $conn_server = null;

    public function __construct() {
        $this->host = "10.1.1.58";
        $this->user = "root";
        $this->pass = "@g@pi.@v@olpato.911";
        $this->dbname = "volpato_semiFinal";
        $this->conecta();
        $this->setDb();
    }

    public function conecta() {
        if (!isset(self::$conn)):
            self::$conn = mysql_connect($this->host, $this->user, $this->pass) or die("Não foi possivel realizar a conexao com MYSQL!" . mysql_error());
            return self::$conn;
        else:
            return self::$conn;
        endif;
    }

    public function setDb() {
        mysql_select_db($this->dbname)or die("Não foi possivel selecionar o banco de dados !" . mysql_error());
    }

}
