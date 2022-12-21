<?php

/**
 * Conn.class [Conexão]
 * Classe Abstrata de conexao .Padrão SingleTon.
 * Retorna Um Objeto PDO Pelo metodo estático getConn();
 * 
 * @copyright (c)year, Pedro jardim Grupo Volpato
 */
class Conn {

    private static $Host = HOST;
    private static $User = USER;
    private static $Pass = PASS;
    private static $Dbsa = DBSA;

    /**
     * @var PDO
     */
    private static $Connect = null;

    /**
     * Conecta com o banco de dados com o pattern Singleton.
     *
     * Retorna um objeto PDO!
     */
    private static function Conectar() {
        try {
            if (self::$Connect == null):
                $dsn = 'mysql:host=' . self::$Host . ';dbname=' . self::$Dbsa;
                $options = [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
                self::$Connect = new PDO($dsn, self::$User, self::$Pass, $options);
            endif;
        } catch (Exception $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            die();
        }
        self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Connect;
    }

    /**
     * Retorna um objeto singleton Pattern.
     */
    public function getConn() {
        return self::Conectar();
    }

    public function setarConfiguracoesASC() {
        $this->Dbsa = "teste_sql";
        $this->User = "ascinfo";
        $this->Pass = "asc_user";
        $this->Host = "localhost";
    }

}
