<?php
class Equipamento extends Crud {

	private $_sql = "";
	private $_tabela = "equipamentos_sac";
	private $_filtro = "";
	private $equipamentos_sac_desc;
	private $equipamentos_sac_id;
	private $equipamentos_sac_clientes_cliente;
	private $equipamentos_sac_clientes_equipamento;
	private $equipamentos_sac_clientes_id;
	private $lista = array();
	
	//SETA OS ATRIBUTOS NO MESMO OBJETO
	public function setDados($Dados){
		foreach ($Dados as $k=>$d){
			$this->$k = $d;
		}
	}
	
	//CRIA UM ARRAY DE OBJETOS E COLOCA NA LISTA
	public function setDadosLista($Dados){
		foreach ($Dados as $k1=>$d){
			$c = new Equipamento;
			foreach ($d as $k2=>$dado){
				$c->set($k2, $dado);
			}
			$this->lista[$k1] = $c;
		}
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
	
	public function selectEquipamentosCliente($id_cliente){
		$this->_sql = "SELECT ec.*, e.equipamentos_sac_desc FROM equipamentos_sac_clientes ec 
						INNER JOIN equipamentos_sac e ON ec.equipamentos_sac_clientes_equipamento = e.equipamentos_sac_id
						WHERE ec.equipamentos_sac_clientes_cliente = {$id_cliente}";
		$this->Read()->FullRead($this->_sql);
		$this->setDadosLista($this->Read()->getResult());
		return $this->lista;
	}
	
	public function selectEquipamentosClienteArray($id_cliente){
		$this->_sql = "SELECT ec.*, e.equipamentos_sac_desc FROM equipamentos_sac_clientes ec 
						INNER JOIN equipamentos_sac e ON ec.equipamentos_sac_clientes_equipamento = e.equipamentos_sac_id
						WHERE ec.equipamentos_sac_clientes_cliente = {$id_cliente}";
		$this->Read()->FullRead($this->_sql);
		return $this->Read()->getResult();
		return $this->lista;
	}
	
	public function selectEquipamentosClienteEquipamentos($id_cliente){
		$this->_sql = "SELECT ec.equipamentos_sac_clientes_equipamento FROM equipamentos_sac_clientes ec 
						INNER JOIN equipamentos_sac e ON ec.equipamentos_sac_clientes_equipamento = e.equipamentos_sac_id
						WHERE ec.equipamentos_sac_clientes_cliente = {$id_cliente}";
		$this->Read()->FullRead($this->_sql);
		return $this->Read()->getResult();
	}
	
	public function selectEquipamentosClienteEquipamentosDesc($id_cliente){
		$this->_sql = "SELECT e.equipamentos_sac_desc FROM equipamentos_sac_clientes ec 
						INNER JOIN equipamentos_sac e ON ec.equipamentos_sac_clientes_equipamento = e.equipamentos_sac_id
						WHERE ec.equipamentos_sac_clientes_cliente = {$id_cliente}";
		$this->Read()->FullRead($this->_sql);
		return $this->Read()->getResult();
	}
	
	public function verificaEquipamentoCliente($id_equipameto){
		$this->Read()->ExRead("equipamentos_sac_clientes", "WHERE equipamentos_sac_clientes_equipamento = {$id_equipameto}", null);
		return $this->Read()->getResult();
	}
	
	function deletarEquipamentoCliente($id_cliente, $id_equipamento){
		$this->Delete()->ExDelete("equipamentos_sac_clientes", "WHERE equipamentos_sac_clientes_equipamento = {$id_equipamento} AND equipamentos_sac_clientes_cliente = {$id_cliente}", null);
		return $this->Delete()->getResult();
	}
	
	function deletarEquipamento($id_equipamento){
		$this->Delete()->ExDelete("equipamentos_sac", "WHERE equipamentos_sac_id = {$id_equipamento}", null);
		return $this->Delete()->getResult();
	}
	
	public function insert($tabela ,$Dados){
		$this->Create()->ExCreate($tabela , $Dados);
		return $this->Create()->getResult();
	}
	
	public function listarEquipamentos(){
		$this->Read()->ExRead("equipamentos_sac");
		$this->setDadosLista($this->Read()->getResult());
		return $this->lista;
	}
	
	
}