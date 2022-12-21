<?php

/**
 * Classe de conexão com o banco padrão, contendo os métodos comuns a todos os módulos
 * @author admin
 *
 */
class M_CRUD extends CI_Model {

    private $_select = "*";
    private $_tabela;

    /**
     * Construtor padrão
     */
    public function __construct() {
        parent::__construct();
		$this->load->database();
    }

    /**
     * Insert padrão
     * @param string $tabela
     * @param array $dados
     */
    public function insert($tabela, array $dados) {
        $this->db->insert($tabela, $dados);
    }
    
    public function saveMultiple($tabela,$dadosForm) {
       $this->db->insert_batch($tabela, $dadosForm);
       return $this->ultimoId();
    }
    
    
    

    /**
     * Delete padrão
     * @param string $tabela
     * @param array/string $where
     */
    public function delete($tabela, $where) {
        $this->where($where);
        $this->db->delete($tabela);
    }

    /**
     * Update padrão
     * @param string $tabela
     * @param array $dados
     * @param array/string $where
     */
    public function update($tabela, array $dados, $where) {
       //var_dump($tabela, $dados, $where); die;
        
        $this->where($where);
        $this->db->update($tabela, $dados);
    }

    /**
     * Método que procura um elemento pelo id
     * @param string $tabela
     * @param string $campo descrição do campo do id
     * @param string/int $id valor a ser procurado
     */
    public function findById($tabela, $campo, $id) {
        $this->_tabela = $tabela;
        $this->db->select($this->_select)->from($tabela)->where($campo, $id);
        return $this->limparArray($this->db->get()->result());
    }

    /**
     * Método que procura um elemento pelo id retornando um array
     * @param string $tabela
     * @param string $campo descrição do campo do id
     * @param string/int $id valor a ser procurado
     */
    public function findByIdArray($tabela, $campo, $id) {
        $this->_tabela = $tabela;
        $this->db->select($this->_select)->from($tabela)->where($campo, $id);
        return $this->limparArray($this->db->get()->result_array());
    }

    /**
     * Select padrão, nele podem ser incorporados os métodos where(), filtrar(), setSelectCampos(), join(), like(), groupby(), limit(), orderby(), having(), orCampo();
     * @param string $tabela
     */
    public function select($tabela) {
        $this->_tabela = $tabela;
        $this->db->select($this->_select)->from($tabela);
        return $this;
    }

    /**
     * Retorna primeiro resultado do select
     */
    public function getResultOne() {
        $this->_select = "";
        return $this->limparArray($this->db->get()->result());
    }

    /**
     * Retorna primeiro resultado do select como array
     */
    public function getResultOneArray() {
        $this->_select = "";
        return $this->limparArray($this->db->get()->result_array());
    }

    /*     * *
     * Retorna o resultado em um array
     */

    public function getResultArray() {
        $this->_select = "";
        return $this->db->get()->result_array();
    }

    /*     * *
     * Retorna o resultado em um array de objetos
     */

    public function getResult() {
        $this->_select = "";
        return $this->db->get()->result();
    }

    /*     * *
     * Limpa valor 0 quando se precisa retornar somente um registro
     */

    public function limparArray($arrayParam) {
        $array = isset($arrayParam[0]) ? $arrayParam[0] : $arrayParam;
        return $array;
    }

    /*     * *
     * Filtrar os campos recebidos pelo valor da busca
     * @param array $campos
     * @param string $busca
     */

    public function filtrar(array $campos, $busca) {

        $where = "";
        $or = "";

        foreach ($campos as $campo) {
            $where .= " {$or} {$campo} LIKE '{$busca}%'";
            $or = "OR";
        }
        $this->db->where("(" . $where . ")");
    }

    /**
     * Adiciona where de and e =
     * @param array/string $where onde a chave do campo do array é o nome do atributo e o valor o value
     */
    public function where($where) {
        $this->db->where($where);
        return $this;
    }

    /**
     * Seta campos a serem retornados pelo select
     * @param array/string $campos onde a chave do campo do array é o nome do atributo e o valor o value
     */
    public function setSelectCampos($campos) {
        if (!empty($campos))
            $this->_select = $campos;
            return $this;
    }

    /**
     * 
     * @param string $tabela1 tabela a ser incorporada
     * @param string $tabela2 tabela ja existente
     * @param string $campo1 campo tabela1
     * @param string $campo2 campo tabela2 
     * @param string $join left, right, inner
     * @param string $alias1 alias tabela1
     * @param string $alias2 alias tabela2
     */
    public function join($tabela1, $tabela2, $campo1, $campo2, $join = "left", $alias1 = null, $alias2 = null) {
        $al1 = empty($alias1) ? $tabela1 : $alias1;
        $al2 = empty($alias2) ? $tabela2 : $alias2;
        $this->db->join($tabela1 . " " . $alias1, $al2 . "." . $campo2 . " = " . $al1 . "." . $campo1, $join);
        return $this;
    }

    /**
     * Adiciona like a query(AND)
     * @param array $campos onde a chave do campo do array é o nome do atributo e o valor o value
     */
    public function like($campos, $match = "match") {
        $this->db->like($campos, $match);
        return $this;
    }

    /**
     * Adiciona grouby a query
     * @param array/string $campos onde a chave do campo do array é o nome do atributo e o valor o value
     */
    public function groupby($campos) {
        $this->db->group_by($campos);
        return $this;
    }

    /**
     * Seta limite a query
     * @param string/int $limite
     */
    public function limit($limite, $offset = null) {
        $this->db->limit($limite, $offset);
        return $this;
    }

    /**
     * Adiciona parametros having a query
     * @param array $dados onde a chave do campo do array é o nome do atributo(pode ser seguido da operacao, padrão =) e o valor o value
     */
    public function having($dados) {
        $this->db->having($dados);
        return $this;
    }

    /**
     * Adiciona orderby a query
     * @param array/string $campos
     */
    public function orderby($campos, $ordem = null) {
        $this->db->order_by($campos, $ordem);
        return $this;
    }

    /**
     * Adiciona uma intrução or na query podendo ser like, having e where
     * @param string $acao acao a ser realizada like, having e where
     * @param array $campos onde a chave do campo do array é o nome do atributo e o valor o value
     */
    public function orCampo($acao, $campos, $match = null) {
        $acao = "or_" . $acao;
        $this->db->$acao($campos, $match);
        return $this;
    }

    /**
     * Retorna um array de objetos fazendo a pesquisa a partir da instrução sql recebida
     * @param string $sql
     */
    public function seletctQuery($sql) {
        return $this->db->query($sql)->result();
        return $this;
    }

    /**
     * Retorna um array fazendo a pesquisa a partir da instrução sql recebida
     * @param string $sql
     */
    public function selectQueryArray($sql) {
        return $this->db->query($sql)->result_array();
        return $this;
    }

    /**
     * Retorna o numero de linhas
     */
    public function numRow() {
        return $this->db->count_all_results();
        return $this;
    }

    /**
     * Retorna ultimo id cadastrado
     */
    public function ultimoId() {
        return $this->db->insert_id();
        return $this;
    }

    /**
     * Seta dados de um array
     * @param unknown $Dados
     */
    public function setDados($Dados, $tabela = "") {
        $tabela = !empty($tabela) ? $tabela . "_" : "";
        if (!empty($Dados)) {
            foreach ($Dados as $k => $d) {
                $var = $tabela . $k;
                $this->$var = $d;
            }
        }
    }

    /**
     * Retorna os dados setados
     * @param unknown $Dados
     */
    public function get($key, $original = FALSE) {
        if (property_exists($this, $key)) {
            $metodo = "get_" . $key;

            if (method_exists($this, $metodo) && !$original)
                return $this->$metodo();
            else
                return $this->$key;
        } else
            return "";
    }

    /**
     * Executa uma query especifica
     * @param unknown $statement
     */
    public function query($statement) {
        $this->db->query($statement);
        return $this;
    }

    /**
     * Executa a última query formada
     */
    public function executarUltimaQuery() {
        $this->db->query($this->db->last_query())->result();
        
    }

    /**
     * Retorna a última query formada
     */
    public function retornarUltimaQuery() {
        return $this->db->last_query();
    }
    
    
    /*
     * 
     * 
     *    
     * 
     */
    
    public function findByTable($filtro){
        return $this->selectQueryArray("select * from {$filtro}");
    }
}
