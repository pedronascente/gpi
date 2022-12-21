<?php

class Credenciados extends Crud {
	
	private $_tabela = "credenciados";
	private $_sql = "";
	private $_filtros = "";
	private $credenciado_id;
	private $credenciado_data_cadastro;
	private $credenciado_status;
	private $credenciado_razao_social;
	private $credenciado_nome_fantasia;
	private $credenciado_cpfcnpj;
	private $credenciado_rg;
	private $credenciado_cep;
	private $credenciado_uf;
	private $credenciado_cidade;
	private $credenciado_bairro;
	private $credenciado_complemento;
	private $credenciado_numero;
	private $credenciado_logradouro;
	private $credenciado_instalacao;
	private $credenciado_manutencao;
	private $credenciado_deslocamento;
	private $credenciado_km;
	private $credenciado_obs;
	private $credenciado_banco;
	private $credenciado_agencia;
	private $credenciado_conta;
	private $credenciado_favorecida;
	private $credenciado_tipo_pessoa;
	private $credenciando_numero_banco;
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
				$c = new Credenciados;
				foreach ($d as $k2=>$dado){
					$c->set($k2, $dado);
				}
				$this->lista[$k1] = $c;
			}
		}
	}
	
	
	//GETS ESPECÍFICOS
	public function get_credenciado_data_cadastro(){
		return !empty($credenciado_data_cadastro) ?  Funcoes::formataData($credenciado_data_cadastro) : "";
	}
	
	public function get_credenciado_status(){
		
		$status = "";
		switch ($this->credenciado_status){
			case "1": $status = "Ativo"; break;
			case "2": $status = "Inativo"; break;
		}
		
		return $status;
		
	}
	
	public function get_credenciado_instalacao(){
		return !empty($this->credenciado_instalacao) ? Funcoes::formartaMoedaReal($this->credenciado_instalacao) : "";
	}
	
	public function get_credenciado_manutencao(){
		return !empty($this->credenciado_manutencao) ? Funcoes::formartaMoedaReal($this->credenciado_manutencao) : "";
	}
	
	public function get_credenciado_km(){
		return !empty($this->credenciado_km) ? Funcoes::formartaMoedaReal($this->credenciado_km) : "";
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
	
	public function atualizar($Dados){
		$this->Update()->ExUpdate($this->_tabela, $Dados, "WHERE credenciado_id = {$Dados['credenciado_id']}", null);
		return $this->Update()->getResult();
	}
	
	public function listar($status = NULL, $limite = NULL){
		$limite = !empty($limite) ? "LIMIT {$limite}" : "";
		$status = !empty($status) ? "AND credenciado_status = {$status}" : "";
		$this->_sql = "SELECT credenciado_id, credenciado_razao_social, credenciado_nome_fantasia, credenciado_cpfcnpj, credenciado_rg, credenciado_status FROM {$this->_tabela} WHERE credenciado_id >=1 {$status} {$this->_filtros} {$limite}";
		$this->Read()->FullRead($this->_sql);
		$this->setDadosLista($this->Read()->getResult());
		return $this->lista;
	}
	
	public function setFiltros($busca){
		$campos  = 
			array("credenciado_razao_social", 
				 	"credenciado_nome_fantasia",
				 	"credenciado_cpfcnpj", 
					"credenciado_rg", 
					"credenciado_cidade", 
					"credenciado_cep", 
					"credenciado_uf", 
					"credenciado_obs");
		$this->_filtros = $this->filtrar($campos, $busca);
	}
	
	public function select($id){
		$this->Read()->ExRead($this->_tabela, "WHERE credenciado_id = {$id} ORDER BY credenciado_razao_social");
		$this->setDados($this->limparArray($this->Read()->getResult()));
	}
	
	public function selectArray($id){
		$this->Read()->ExRead($this->_tabela, "WHERE credenciado_id = {$id} ORDER BY credenciado_razao_social");
		return $this->limparArray($this->Read()->getResult());
	}
	
}