<?php

class Produtos extends Crud {

    private $_sql = "";
    private $_tabela = "produtos";
    private $_filtros = "";
    private $produto_id;
    private $produto_descricao;
    private $produto_referencia;
    private $produto_categoria;
    private $produto_unidade;
    private $produto_quantidade;
    private $produto_estoque_min;
    private $produto_data_cadastro;
    private $produto_localizacao;
    private $produto_obs;
    private $produto_status;
    private $produto_categoria_id;
    private $produto_categoria_desc;
    private $produto_unidade_id;
    private $produto_unidade_desc;
    private $produto_requisicao_id;
    private $produto_requisicao_data;
    private $produto_requisicao_usuario;
    private $produto_requisicao_solicitante;
    private $produto_requisicao_produto;
    private $produto_requisicao_setor;
    private $produto_requisicao_quantidade;
    private $produto_requisicao_obs;
    private $produto_requisicao_tipo;
    private $produto_requisicao_data_criacao;
    private $lista = array();

    //SETA OS ATRIBUTOS NO MESMO OBJETO
    public function setDados($Dados) {
        if (!empty($Dados)) {
            foreach ($Dados as $k => $d) {
                $this->$k = $d;
            }
        }
    }

    //CRIA UM ARRAY DE OBJETOS E COLOCA NA LISTA
    public function setDadosLista($Dados) {
        $this->lista = array();

        if (!empty($Dados)) {
            foreach ($Dados as $k1 => $d) {
                $c = new Produtos;
                foreach ($d as $k2 => $dado) {
                    $c->set($k2, $dado);
                }
                $this->lista[$k1] = $c;
            }
        }
    }

    public function get_produto_data_cadastro() {
        return !empty($this->produto_data_cadastro) ? Funcoes::formataDataComHora($this->produto_data_cadastro) : "";
    }

    public function get_produto_status() {
        return ucwords($this->produto_status);
    }

    public function get_produto_requisicao_data() {
        return !empty($this->produto_requisicao_data) ? Funcoes::formataData($this->produto_requisicao_data) : "";
    }

    public function get_produto_requisicao_data_criacao() {
        return !empty($this->produto_requisicao_data_criacao) ? Funcoes::formataDataComHora($this->produto_requisicao_data_criacao) : "";
    }

    public function get_produto_requisicao_tipo() {
        return ucwords($this->produto_requisicao_tipo);
    }

    public function get_produto_quantidade() {
        return str_replace(".", ",", $this->produto_quantidade);
    }

    public function get_produto_estoque_min() {
        return str_replace(".", ",", $this->produto_estoque_min);
    }

    public function get_produto_requisicao_quantidade() {
        return str_replace(".", ",", $this->produto_requisicao_quantidade);
    }

    //SET E GET GENERICO
    public function set($key, $dado) {
        $this->$key = $dado;
    }

    public function get($key, $original = FALSE) {
        $metodo = "get_" . $key;

        if (method_exists($this, $metodo) && !$original)
            return $this->$metodo();
        else
            return $this->$key;
    }

    public function insert($Dados) {
        $this->Create()->ExCreate($this->_tabela, $Dados);
        return $this->Create()->getResult();
    }

    public function insertRequisicao($Dados) {
        $this->Create()->ExCreate("produtos_requisicao", $Dados);
        return $this->Create()->getResult();
    }

    public function insertCategoria($Dados) {
        $this->Create()->ExCreate("produtos_categorias", $Dados);
        return $this->Create()->getResult();
    }

    public function insertUnidade($Dados) {
        $this->Create()->ExCreate("produtos_unidades", $Dados);
        return $this->Create()->getResult();
    }

    public function atualizar($Dados) {
        $this->Update()->ExUpdate($this->_tabela, $Dados, "WHERE produto_id = {$Dados['produto_id']}", null);
        return $this->Update()->getResult();
    }

    public function select($id) {
        $this->Read()->ExRead($this->_tabela, "WHERE produto_id = {$id}", null);
        $this->setDados($this->limparArray($this->Read()->getResult()));
    }

    public function selectDadosProduto($id) {
        $this->_sql = "SELECT  TRUNCATE (p.produto_quantidade, 3) as produto_quantidade, p.produto_estoque_min, u.produto_unidade_desc FROM produtos p
						LEFT JOIN produtos_unidades u ON p.produto_unidade = u.produto_unidade_id WHERE produto_id = {$id}";
        $this->Read()->FullRead($this->_sql);
        $this->setDados($this->limparArray($this->Read()->getResult()));
    }

    public function selectRequisicao($id) {
        $this->_sql = "SELECT 
						  pr.produto_requisicao_id,
						  pr.produto_requisicao_solicitante,
						  pr.produto_requisicao_produto,
						  pr.produto_requisicao_setor,
						  pr.produto_requisicao_quantidade,
						  pr.produto_requisicao_obs,
						  pr.produto_requisicao_tipo,
						  pr.produto_requisicao_data_criacao,
						  pr.produto_requisicao_data,
						  u.nome AS produto_requisicao_usuario
						FROM
						  produtos_requisicao pr 
						  INNER JOIN usuarios u 
						    ON pr.produto_requisicao_usuario = u.id
							WHERE produto_requisicao_id = {$id}";
        $this->Read()->FullRead($this->_sql);
        $this->setDados($this->limparArray($this->Read()->getResult()));
    }

    public function selectCategorias() {
        $this->Read()->ExRead("produtos_categorias", "ORDER by produto_categoria_desc DESC", null);
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function selectUnidades() {
        $this->Read()->ExRead("produtos_unidades", "ORDER by produto_unidade_desc DESC", null);
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function listar($filtro = NULL, $limite = NULL) {
        $filtros = !empty($filtro) && $filtro == 2 ? "AND p.produto_quantidade <= p.produto_estoque_min AND p.produto_quantidade != 0" : "";
        $filtros = !empty($filtro) && $filtro == 1 ? "AND p.produto_quantidade = 0" : $filtros;
        $limite = !empty($limite) ? " LIMIT {$limite}" : "";
        $this->_sql = "SELECT 
						  p.produto_id,
						  p.produto_status,
						  p.produto_data_cadastro,
						  p.produto_descricao,
						  p.produto_referencia,
						  TRUNCATE (p.produto_quantidade, 3) as produto_quantidade,
						  p.produto_estoque_min,
						  p.produto_localizacao,						  
						  c.produto_categoria_desc,
						  u.produto_unidade_desc 
						FROM
						  produtos p 
						  LEFT JOIN produtos_categorias c 
						    ON p.produto_categoria = c.produto_categoria_id 
						  LEFT JOIN produtos_unidades u 
						    ON p.produto_unidade = u.produto_unidade_id 
						WHERE p.produto_id = p.produto_id {$filtros}{$this->_filtros}
						GROUP BY p.produto_id 
						ORDER BY p.produto_data_cadastro {$limite}";
        $this->Read()->FullRead($this->_sql);
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function listarRequisicao($limite = NULL) {
        $limite = !empty($limite) ? " LIMIT {$limite}" : "";
        $this->_sql = "SELECT 
						  pr.produto_requisicao_id,
						  pr.produto_requisicao_data,
						  pr.produto_requisicao_solicitante,
						  pr.produto_requisicao_quantidade,
						  pr.produto_requisicao_tipo,
						  u.nome AS produto_requisicao_usuario,
						  s.setor_local AS produto_requisicao_setor, 
						  p.produto_descricao AS produto_requisicao_produto
						FROM
						  produtos_requisicao pr 
						  INNER JOIN usuarios u ON pr.produto_requisicao_usuario = u.id
						  INNER JOIN setor s ON pr.produto_requisicao_setor = s.setor_id
						  INNER JOIN produtos p ON pr.produto_requisicao_produto = p.produto_id
						  WHERE pr.produto_requisicao_id = pr.produto_requisicao_id {$this->_filtros}
						  ORDER BY produto_requisicao_data DESC {$limite}";
        $this->Read()->FullRead($this->_sql);
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function setFiltros($busca) {
        $campos = array("produto_id",
                    "produto_descricao",
                    "produto_referencia",
                    "produto_quantidade",
                    "produto_localizacao",
                    "produto_categoria_desc",
                    "produto_unidade_desc"
        );

        $this->_filtros = $this->filtrar($campos, $busca);
    }

    public function setFiltrosRequisicao($busca) {
        $campos = array("produto_requisicao_id",
                    "produto_requisicao_solicitante",
                    "produto_requisicao_quantidade",
                    "produto_requisicao_tipo",
                    "produto_descricao",
                    "nome",
                    "setor_local"
        );

        $this->_filtros = $this->filtrar($campos, $busca);
    }

    public function selectProdutosDisponiveis($tipo) {
        $tipo = $tipo == "saida" ? " AND produto_quantidade > 0" : "";
        $this->_sql = "SELECT produto_descricao, produto_id FROM produtos WHERE produto_status = 'ativo' {$tipo}";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function atualizarQuantidade($id, $quantidade, $operacao) {
        $this->Read()->FullUpdate("UPDATE produtos SET produto_quantidade = produto_quantidade{$operacao}{$quantidade} WHERE produto_id = {$id}");
    }

    public function deleteRequisicao($id_requisicao) {
        $this->Delete()->ExDelete("produtos_requisicao", "WHERE produto_requisicao_id = {$id_requisicao}", null);
        return $this->Delete()->getResult();
    }

}
