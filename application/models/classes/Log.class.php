<?php

class Log extends Crud {
	
	private $_sql = "";
	private $_tabela = "log";
	private $_filtro = "";
	private $log_id;
	private $log_identificacao;
	private $log_usuario;
	private $log_descricao;
	private $log_data;
	private $log_texto;
	private $log_nivel;
	private $log_nome_usuario;
	private $log_tabela;
	private $lista = array();
	
	
	//SETA OS ATRIBUTOS NO MESMO OBJETO
	public function setDados($Dados){
		foreach ($Dados as $k=>$d){
			$this->$k = $d;
		}
	}
	
	//CRIA UM ARRAY DE OBJETOS E COLOCA NA LISTA
	public function setDadosLista($Dados){
		$this->lista = array();
		
		if(!empty($Dados)){
			foreach ($Dados as $k1=>$d){
				$l = new Log;
				foreach ($d as $k2=>$dado){
					$l->set($k2, $dado);
				}
				$this->lista[$k1] = $l;
			}
		}
	}
	
	public function get_log_data(){
		return !empty($this->log_data) ? Funcoes::formataDataComHora($this->log_data) : "";
	}
	
	//SET E GET GENERICO
	public function set($key , $dado){
		$this->$key = $dado;
	}
	
	public function get($key){
		$metodo = "get_".$key;
	
		if(method_exists($this, $metodo))
			return $this->$metodo();
		else
			return $this->$key;
	}
	
	public function insert($Dados){
		$this->Create()->ExCreate($this->_tabela, $Dados);
		return $this->Create()->getResult();
	}
	
	public function select($id){
		$this->_sql = "SELECT l.*, u.nome as log_nome_usuario FROM log l
						LEFT JOIN usuarios u ON l.log_usuario = u.id
							WHERE log_id = {$id}";
		$this->Read()->FullRead($this->_sql);
		$this->setDados($this->limparArray($this->Read()->getResult()));
	}
	
	public function selectTabelas(){
		$this->Read()->ExRead("log_tabelas", null, null);
		return $this->Read()->getResult();
	}
	
	public function listar($limite = NULL, $id = NULL, $nivel = NULL, $data1 = NULL, $data2 = NULL){
		$id = !empty($id) ? $id = "AND log_identificacao = {$id}" : "";
		$nivel = !empty($nivel) ? "AND log_nivel = {$nivel}" : "";
		$limite = !empty($limite) ? "LIMIT {$limite}" : "LIMIT 2000";
		$datas = 	!empty($data1) ? "AND log_data >='".Funcoes::FormatadataSql($data1)."'" : "";
		$datas .= 	!empty($data2) ? "AND log_data <='".Funcoes::FormatadataSql($data2)."'" : "";
		$this->_sql = "SELECT l.*, u.nome as log_nome_usuario, lt.log_tabelas_desc as log_tabela FROM log l
						LEFT JOIN usuarios u ON l.log_usuario = u.id
						INNER JOIN log_tabelas lt ON l.log_nivel = lt.log_tabelas_ra
							WHERE log_id >=1 {$nivel} {$id} {$this->_filtro} {$datas}  ORDER by log_data DESC {$limite}";
		$this->Read()->FullRead($this->_sql);
		$this->setDadosLista($this->Read()->getResult());
		return $this->lista; 
	}
	
	public function setFiltros($busca){
		$this->_filtro = $this->filtrar(array("log_identificacao", "log_tabelas_desc", "nome", "log_texto", "log_descricao"), $busca);
	}

	public function get_sql(){
		return $this->_sql;

	}
}