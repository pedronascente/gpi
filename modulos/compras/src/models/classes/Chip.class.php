<?php

class Chip extends Crud {

    private $_sql = "";
    private $_tabela = "chips";
    private $_filtro = "";
    private $chip_id;
    private $chip_data_programacao;
    private $chip_linha;
    private $chip_iccid;
    private $chip_operadora;
    private $chip_modulo;
    private $chip_puk;
    private $chip_puk2;
    private $chip_status;
    private $chip_vpn;
    private $chip_cliente;
    private $chip_veiculo;
    private $modulo_id;
    private $modulo_serial;
    private $modulo_modelo;
    private $modulo_status;
    private $modulo_obs;
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
                $c = new chip;
                foreach ($d as $k2 => $dado) {
                    $c->set($k2, $dado);
                }
                $this->lista[$k1] = $c;
            }
        }
    }

    public function get_chip_data_criacao() {
        return !empty($this->chip_data_criacao) ? Funcoes::formataData($this->chip_data_criacao) : NULL;
    }

    public function get_chip_vpn() {
        $vpn = "";

        switch ($this->chip_vpn) {
            case 1: $vpn = "Dentro";
                break;
            case 2: $vpn = "Fora";
                break;
        }

        return $vpn;
    }

    public function get_chip_pim() {
        return !empty($this->chip_linha) ? substr($this->chip_linha, -4) : "";
    }

    public function get_chip_status() {
        $status = '';
        switch ($this->chip_status) {
            case 1: $status = 'Novo';
                break;
            case 2: $status = 'Em Andamento';
                break;
            case 3: $status = 'Programado';
                break;
            case 5: $status = 'Vinculado';
                break;
        }
        return $status;
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

    public function atualizar($Dados) {
        $this->Update()->ExUpdate($this->_tabela, $Dados, "WHERE chip_id = {$Dados['chip_id']}", null);
        return $this->Update()->getResult();
    }

    public function listar($status = NULL, $id_chip = NULL, $limite = NULL) {
        $limite = !empty($limite) ? "LIMIT {$limite}" : "";
        $id_chip = !empty($id_chip) ? "OR chip_id = {$id_chip}" : "";
        $status = !empty($status) ? "AND (chip_status = '{$status}' {$id_chip})" : "";
        $this->Read()->ExRead($this->_tabela, "WHERE chip_id>=1 {$status} {$this->_filtro} ORDER BY chip_linha {$limite}");
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function listarProgramacao($status = NULL, $limite = NULL) {
        $limite = !empty($limite) ? "LIMIT {$limite}" : " LIMIT 1000";
        $status = !empty($status) ? "AND chip_status = '{$status}'" : "AND chip_status = 2";
        $this->_sql = "SELECT 
						  c.chip_status,
						  c.chip_id,
						  c.chip_linha,
						  cli.nome_cliente as chip_cliente,
						  m.modulo_serial,
						  m.modulo_id 
						FROM
						  {$this->_tabela} c 
						  LEFT JOIN modulos m ON c.chip_modulo = m.modulo_id
						  LEFT JOIN veiculos_equipamentos ve ON ve.veiculos_equipamentos_id_chip =  c.chip_id
						  LEFT JOIN veiculos v ON ve.veiculos_equipamentos_id_veiculo = v.id_veiculo
						  LEFT JOIN clientes cli ON v.cliente_ra = cli.id_cliente
						  WHERE c.chip_id = c.chip_id {$this->_filtro} {$status} {$limite}";
        $this->Read()->FullRead($this->_sql);
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function listarDisponiveis($id_chip) {
        $this->_sql = "SELECT 
						  c.*, m.modulo_serial
						FROM
						  chips c 
						  LEFT JOIN modulos m ON c.chip_modulo = m.modulo_id
						    WHERE c.chip_id = '{$id_chip}' AND c.chip_status = 3
						   ";
        $this->Read()->FullRead($this->_sql);
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function selectProgramacao($id_programacao) {
        $limite = !empty($limite) ? "LIMIT {$limite}" : "";
        $status = !empty($status) ? "AND chip_status = '{$status}'" : "AND chip_status = 2";
        $this->_sql = "SELECT
						c.*,
						m.*,
						v.cliente_ra as chip_cliente,
						ve.veiculos_equipamentos_id_veiculo as chip_veiculo
						FROM
						{$this->_tabela} c
						LEFT JOIN modulos m ON c.chip_modulo = m.modulo_id
						LEFT JOIN veiculos_equipamentos ve ON ve.veiculos_equipamentos_id_chip =  c.chip_id
						LEFT JOIN veiculos v ON ve.veiculos_equipamentos_id_veiculo = v.id_veiculo
						WHERE c.chip_id = {$id_programacao}";
        $this->Read()->FullRead($this->_sql);
        $this->setDados($this->limparArray($this->Read()->getResult()));
    }

    public function validarChip($id_chip) {
        $this->_sql = "SELECT veiculos_equipamentos_id, veiculos_equipamentos_id_veiculo FROM veiculos_equipamentos WHERE veiculos_equipamentos_id_chip = {$id_chip}";
        $this->Read()->FullRead($this->_sql);
        return $this->limparArray($this->Read()->getResult());
    }

    public function setFiltros($busca, $adicional = NULL) {
        $campos = array("chip_linha",
                    "chip_iccid",
                    "chip_puk",
                    "chip_puk2");

        if (!empty($adicional))
            $campos = array_merge($campos, $adicional);

        $this->_filtro = $this->filtrar($campos, $busca);
    }

    public function select($id) {
        $this->_sql = "SELECT c.*, m.modulo_serial FROM chips c LEFT JOIN modulos m ON c.chip_modulo = m.modulo_id WHERE c.chip_id = {$id}";
        $this->Read()->FullRead($this->_sql);
        $this->setDados($this->limparArray($this->Read()->getResult()));
    }

    public function selectArray($id) {
        $this->Read()->ExRead($this->_tabela, "WHERE chip_id = {$id}");
        return $this->limparArray($this->Read()->getResult());
    }
    
    public function selectArrayChip($chip) {
    	$status = !empty($status) ? "AND modulo_status = {$status}" : "";
        $this->Read()->ExRead($this->_tabela, "WHERE chip_linha = '{$chip}' {$status}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function deleteChip($id) {
        $this->Delete()->ExDelete("chips", "WHERE chip_id = {$id}", null);
        return $this->Delete()->getResult();
    }

    public function limparFiltros() {
        $this->_filtro = "";
    }

}
