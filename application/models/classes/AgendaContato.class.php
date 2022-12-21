<?php

/**
 * 
 * @author desenvolvimento
 * @package application/models
 * Classe que possui as funções dos contatos dos clientes e da agenda que armazena os avisos a respeito dos dados dos clientes
 * Data Modificação: 17/06/2015
 */
final class AgendaContato extends Crud {

    private $_tabela = 'agenda_contato';
    private $_agenda_contato_id;

    public function insertAgenda($dados) {
        $this->Create()->ExCreate($this->_tabela, $dados);
        return $this->Create()->getResult();
    }

    public function deleteAgenda($id) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE agenda_contato_captacao_id  = :id", "id={$id}");
        return $this->Delete()->getResult();
    }

    public function selectAgendaPorID($id) {
        $sql = "SELECT a.*, IF(a.agenda_contato_email IS NULL OR a.agenda_contato_email = '', captacao_email, a.agenda_contato_email) as email FROM agenda_contato a LEFT JOIN captacao c ON a.agenda_contato_captacao_id = c.captacao_id WHERE agenda_contato_id = {$id} GROUP BY agenda_contato_id ";
        $this->Read()->FullRead($sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectAgendaProximaData($data, $hora, $usuario) {
        $this->Read()->ExRead($this->_tabela, "WHERE agenda_contato_proxima_data = '{$data}' AND agenda_contato_hora = '{$hora}' AND agenda_contato_id_usuario = {$usuario}", null);
        return $this->Read()->getResult();
    }

    public function selectPorUsuarioData($filtros = null, $limite = 1000) {
    	$datas = "";
    	$status = "";
    	$usuario = "";
    	
    	
    	if(!empty($filtros)){
    		$datas 		= !empty($filtros['dt_inicial']) 																	? " AND agenda_contato_proxima_data >= '".Funcoes::FormatadataSql($filtros['dt_inicial'])."'" 					: "";
    		$datas 	   .= !empty($filtros['dt_final']) 																		? " AND agenda_contato_proxima_data <= '".Funcoes::FormatadataSql($filtros['dt_final'])."'" 					: "";
    		$usuario 	= !empty($filtros['id'])																			? " AND agenda_contato_id_usuario = {$filtros['id']}"								: "";
    		$status 	= isset($filtros['agenda_contato_status']) && $filtros['agenda_contato_status'] != -1		        ? " AND agenda_contato_status = {$filtros['agenda_contato_status']}" 				: "";
    	}
    	
        $limite = !empty($limite) ? " LIMIT {$limite}" : "";
        $sql = "SELECT 
        		a.agenda_contato_id, 
        		a.agenda_contato_captacao_id, 
        		a.agenda_contato_proxima_data, 
        		a.agenda_contato_data_criacao, 
        		a.agenda_contato_motivo, 
        		a.agenda_contato_status,
        		a.agenda_contato_cliente,
        		a.agenda_contato_hora,
        		c.captacao_cliente,
        		u.nome
        		FROM agenda_contato a 
        		LEFT JOIN captacao c ON a.agenda_contato_captacao_id = c.captacao_id 
        		INNER JOIN usuarios u ON a.agenda_contato_id_usuario = u.id
        		WHERE agenda_contato_id = agenda_contato_id {$usuario} {$datas} {$status} 
        		ORDER BY agenda_contato_proxima_data DESC {$limite}";
        $this->Read()->FullRead($sql);
        return $this->Read()->getResult();
    }

    public function selectPorCaptacao($dados) {
        $limite = isset($dados ['limite']) ? " LIMIT {$dados['limite']}" : "";
        $sql = "SELECT a.*, c.captacao_cliente FROM agenda_contato a LEFT JOIN captacao c ON a.agenda_contato_captacao_id = c.captacao_id WHERE agenda_contato_captacao_id = {$dados['id_captacao']} ORDER BY agenda_contato_status ASC {$limite}";
        $this->Read()->FullRead($sql);
        return $this->Read()->getResult();
    }

    public function updateAgendaPorID($Dados) {
        $this->Update()->ExUpdate($this->_tabela, $Dados, "WHERE agenda_contato_id = {$Dados['agenda_contato_id']}", null);
    }
    
    public function selecionarUsuariosAlertas(){
    	$sql = "SELECT u.nome, u.id from agenda_contato a INNER JOIN usuarios u ON a.agenda_contato_id_usuario = u.id GROUP BY u.id ORDER BY u.nome";
    	$this->Read()->FullRead($sql);
    	return $this->Read()->getResult();
    }
 
    /*
     * *****************************
     * ********* CONTATOS **********
     * *****************************
     */

    public function insert($dados) {
        $this->Create()->ExCreate("contato", $dados);
        return $this->Create()->getResult();
    }

    public function updateContato($dados) {
        $this->Update()->ExUpdate('contato', $dados, "WHERE contato_id =:id", "id={$dados['contato_id']}");
    }

    public function deleteContato($id_contato) {
        $this->Delete()->ExDelete("contato", "WHERE contato_id =:id", "id={$id_contato}");
    }

    public function selectContato($id_contato) {
        $this->Read()->ExRead("contato", "WHERE contato_id = :id", "id={$id_contato}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectContatoCliente($id_cliente, $nivel, $limite = NULL) {
    	$limite = !empty($limite) ? " LIMIT {$limite}" : "";
        $this->Read()->ExRead("contato", "WHERE contato_id_cliente = :id {$limite} AND contato_nivel = {$nivel}", "id={$id_cliente}");
        return $this->Read()->getResult();
    }

    /*
     * *******************************************
     * ********* AGENDA CONTATO MOTIVOS **********
     * *******************************************
     */

    public function listarMotivos() {
        $this->Read()->ExRead("agenda_contato_motivos", "ORDER BY agenda_contato_motivos_desc ASC");
        return $this->Read()->getResult();
    }

    public function getSql() {
        return $this->_sql;
    }

}
