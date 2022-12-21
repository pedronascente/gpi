<?php

final class Ramal extends Crud {

    private $_ramal_id;
    private $_ramal_id_base;
    private $_ramal_id_setor;
    private $_ramal_id_usuario;
    private $_ramal_nome_usuario;
    private $_ramal_ramal;
    private $_ramal_telefone;
    private $_ramal_email;
    private $_ramal_status_id;
    private $_ramal_dt_atualizacao;
    private $_rama_dados = array();
    private $_tabela = 'ramal';

    public function setDados($Dados, $tipo = null) {
        if ($tipo == 'select') {
            foreach ($Dados[0] as $atributo => $valor) {
                $atributo = '_' . $atributo;
                $this->$atributo = $valor;
            }
        }
        $this->_rama_dados = $Dados;
    }

    public function get_ramal_id() {
        return $this->_ramal_id;
    }

    public function get_ramal_id_base() {
        return $this->_ramal_id_base;
    }

    public function get_ramal_id_setor() {
        return $this->_ramal_id_setor;
    }
    
    public function get_ramal_id_usuario() {
        return $this->_ramal_id_usuario;
    }

    public function get_ramal_nome_usuario() {
        return $this->_ramal_nome_usuario;
    }

    public function get_ramal_ramal() {
        return $this->_ramal_ramal;
    }

    public function get_ramal_telefone() {
        return $this->_ramal_telefone;
    }

    public function get_ramal_email() {
        return $this->_ramal_email;
    }

    public function get_ramal_status_id() {
        return $this->_ramal_status_id;
    }

    public function get_ramal_dt_atualizacao() {
        return $this->_ramal_dt_atualizacao;
    }

    public function insert() {
        $this->Create()->ExCreate($this->_tabela, $this->_rama_dados);
        return $this->Create()->getResult();
    }

    public function listRamal($idSetor, $idBase, $dados = NULL) {
        $where = "";
        $limite = isset($dados['limite']) ? "LIMIT {$dados['limite']}" : "";
        if ($dados) {
            $where = " AND ramal_nome_usuario LIKE '%" . $dados ['usuarioRamal'] . "%' OR setor_local LIKE '%" . $dados ['usuarioRamal'] . "%' OR ramal_ramal like '%{$dados ['usuarioRamal']}%'";
        }
        $idSetor = !empty($idSetor) ? " AND ramal_id_setor = {$idSetor} " : "";
        $idBase = !empty($idBase) ? "  AND a.ramal_id_base = {$idBase}" : "";
        $sql = "SELECT 
		a.ramal_id,
		a.ramal_nome_usuario,
		a.ramal_ramal,
		a.ramal_telefone,
		a.ramal_email,
		b.setor_id,
		c.base_id,
		a.ramal_status_id,
		b.setor_local, 
		c.base_nome
		FROM  
		ramal a
		INNER JOIN setor b ON a.ramal_id_setor = b.setor_id 
		INNER JOIN base c ON a.ramal_id_base = c.base_id 
		WHERE
		a.ramal_status_id NOT IN (2) {$idSetor} {$idBase} " . $where . "
		ORDER BY a.ramal_nome_usuario {$limite}";
        $this->Read()->FullRead($sql);
        return $this->Read()->getResult();
    }

    /*
     * **********************************************
     * ********* CONSULTA A LISTA DE BASES **********
     * **********************************************
     */

    public function listBase($tipo) {
        $sql = "";

        if ($tipo == "distinct") {
            $sql = "SELECT * from base ORDER BY base_nome";
        } else {
            $sql = "SELECT c.*
			FROM  
			ramal a
			INNER JOIN setor b ON a.ramal_id_setor = b.setor_id 
			INNER JOIN base c ON a.ramal_id_base = c.base_id 
			WHERE a.ramal_status_id NOT IN (2)
			GROUP BY a.ramal_id_base
			ORDER BY c.base_nome";
        }
        $this->Read()->FullRead($sql);
        return $this->Read()->getResult();
    }

    /*
     * *************************************************
     * ********* CONSULTA A LISTA DOS SETORES **********
     * *************************************************
     */

    public function listSetor($idBase, $tipo = null) {
        $idBase = !empty($idBase) ? " WHERE a.ramal_id_base = {$idBase} AND a.ramal_status_id NOT IN (2)" : "";
        if ($tipo == "ditinct") {
            $sql = "SELECT * FROM  setor WHERE setor_status = 1 ORDER BY setor_local";
        } else {
            $sql = "SELECT b.*
			FROM  
			ramal a
			INNER JOIN setor b ON a.ramal_id_setor = b.setor_id 
			INNER JOIN base c ON a.ramal_id_base = c.base_id 
			{$idBase}
			GROUP BY a.ramal_id_setor
			ORDER BY b.setor_local";
        }
        $this->Read()->FullRead($sql);
        return $this->Read()->getResult();
    }

    /*
     * ******************************************************
     * ********* CONSULTA UM PEDIDO DE ATUALIZAÇÃO **********
     * ******************************************************
     */

    public function listRamalId($idRamal) {
        $sql = "SELECT * FROM  ramal WHERE ramal_status_id = 1 AND ramal_id = " . $idRamal;
        $this->Read()->FullRead($sql);
        return $this->Read()->getResult();
    }

    /*
     * *************************************************************************
     * ********* CONSULTA O PEDIDO DE ATUALIZAÇÃO DE UM RAMAL PELO id **********
     * *************************************************************************
     */

    public function listPedidoAtuRamalId($limite = NULL) {
    	$limite = !empty($limite) ? "LIMIT {$limite}" : "";
        $sql = "SELECT 
				  r.*,
				  a.ramal_id_base AS baseAntiga,
				  a.ramal_id_setor AS setorAntigo,
				  a.ramal_nome_usuario AS nomeAntigo,
				  a.ramal_telefone AS telefoneAntigo,
				  a.ramal_status_id AS statusAntigo,
				  a.ramal_email AS emailAntigo,
        		  a.ramal_ramal as ramalAntigo,
				  s.setor_local,
				  b.base_nome,
				  u.nome 
				FROM
				  ramal_atualizacao r 
				  INNER JOIN setor s 
				    ON r.ramal_id_setor = s.setor_id 
				  INNER JOIN base b 
				    ON r.ramal_id_base = b.base_id 
				  INNER JOIN usuarios u 
				    ON r.ramal_id_usuario = u.id 
				  LEFT JOIN ramal a 
				    ON r.ramal_id = a.ramal_id 
				WHERE r.ramal_status_solicitacao >= 1 
				ORDER BY FIELD(ramal_status_solicitacao, 1,3,2), ramal_dt_solicitacao DESC {$limite}";
        $this->Read()->FullRead($sql);
        return $this->Read()->getResult();
    }

    /*
     * *****************************************************************
     * ********* LISTA TODOS OS RAMAIS OU UM CASO TENHA UM ID **********
     * *****************************************************************
     */

    public function selectRamal($id) {
        if (!empty($id)) {
            $sql = "select * from ramal where ramal_id = {$id}";
        } else {
            $sql = "select * from ramal ";
        }

        $this->Read()->FullRead($sql);
        return $this->Read()->getResult();
    }
    
    public function selectRamalA($id){
    	$this->Read()->ExRead("ramal_atualizacao", "WHERE id = {$id}");
    	return $this->Read()->getResult();
    }
    
    public function selectRamalId($id) {
        $this->Read()->ExRead("ramal", "WHERE ramal_id = {$id}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function atualizarRamal($Dados) {
        $id = $Dados ['ramal_id'];
        unset($Dados ['ramal_id']);
        $this->Update()->ExUpdate($this->_tabela, $Dados, "WHERE  ramal_id = :id", "id={$id}");
        return $this->Update()->getResult();
    }

    public function verificarRamais($Dados) {
        $sql = "SELECT * FROM ramal AS r 
		INNER JOIN setor AS s ON (r.`ramal_id_setor` = s.`setor_id`)
		INNER JOIN base AS b ON (r.`ramal_id_base` = b.`base_id`)
		WHERE r.ramal_nome_usuario = '" . $Dados ['ramal_nome_usuario'] . "'";
        $this->Read()->FullRead($sql);
        return $this->Read()->getRowCount();
    }

    public function deleteRamal($id) {
        $this->Delete()->ExDelete("ramal", "WHERE ramal_id = {$id}", null);
        return $this->Delete()->getResult();
    }

    public function validarRamal($ramal, $ramalAntigo) {
        $this->Read()->ExRead("ramal", "WHERE ramal_ramal = '{$ramal}' AND ramal_ramal <> {$ramalAntigo} AND ramal_status_id != 2", null);
        return $this->Read()->getRowCount();
    }
    
    public function autenticarRamal($ramal) {
    	$this->Create()->ExCreate("ramal_atualizacao", $ramal);
        return $this->Create()->getResult();
    }
    
    public function selectAtualizacao($id){
    	$this->Read()->ExRead("ramal_atualizacao", "WHERE id = {$id}", null);
    	return $this->limparArray($this->Read()->getResult());
    }
    
    public function atualizarStatusAtualizacao($id, $status){
    	$this->Update()->ExUpdate("ramal_atualizacao", array("ramal_status_solicitacao"=>$status), "WHERE  id = {$id}", null);
    	return $this->Update()->getResult();
    }
    
    public function pegarAtualizacoesRamal($ramal){
    	$sql = "SELECT r.*, u.nome FROM ramal_atualizacao r INNER JOIN usuarios u ON r.ramal_id_usuario = u.id WHERE r.ramal_id = {$ramal} AND ramal_status_solicitacao = 1";
    	$this->Read()->FullRead($sql);
    	return $this->limparArray($this->Read()->getResult());
    }

}
