<?php

class sqlserver {

    private $host = "10.1.1.154";
    private $user = "asc_user";
    private $pass = "ascinfo";
    private $dbname = "volpato";

    public function selectServevr() {

        /*
          $uid = "USUARIO_DO_BANCO";

          $pwd = "SENHA";

          $host = "ENDERECO_DO_SERVIDOR";

          $dbsql = "NOME DO BANCO";

          //Declaração do array
          $connectionInfo = array( "UID"=>$uid,
          "PWD"=>$pwd,
          "Database"=>"NOME_DO_BANCO");


          $conn = sqlsrv_connect( $host, $connectionInfo);

          if( $conn === false ) {
          echo "Unable to connect.</br>";
          die( print_r( sqlsrv_errors(), true));

          }

         */


        //veja se aparece a extenção:
        echo '<pre>';
        print_r(get_loaded_extensions());
        echo '</pre>';







        //die( phpinfo());
        //$conn  = mssql_connect($this->host,$this->user,$this->pass) or die("Não foi possivel realizar a conexao com SQL SERVER!");


        if (isset($conn)) {

            echo 'ok';
        } else {
            echo 'off';
        }

        /* 		 mssql_select_db('volpato',$conn);

          $query = "SELECT * FROM cliente ";
          $ret = mssql_query($query)  or die('A error occured: ' . mysql_error());
          while($row = mssql_fetch_assoc($ret)){
          $result[]  = $row ;
          }
         */  //return   $result ; 
    }

}

//FIM DA CLASSE.