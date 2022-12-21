<?php

final class Desenvolvimento extends Crud {

    private $_sql;
    private $_tabela = 'desenvolvimento';
    private $_filtros = '';
    private $desenvolvimento_id;
    private $desenvolvimento_id_usuario;
    private $desenvolvimento_usuario;
    private $desenvolvimento_nome_usuario;
    private $desenvolvimento_data_criacao;
    private $desenvolvimento_modulo;
    private $desenvolvimento_situacao;
    private $desenvolvimento_status;
    private $desenvolvimento_data_final;
    private $desenvolvimento_id_programador;
    private $desenvolvimento_programador;
    private $desenvolvimento_requisicao;
    private $desenvolvimento_descricao;
    private $desenvolvimento_nivel;
    private $desenvolvimento_data_inicio;
    private $desenvolvimento_email;
    private $desenvolvimento_tipo;
    private $desenvolvimento_obs_supervisor;
    private $desenvolvimento_help;
    private $desenvolvimento_setor;
    private $desenvolvimeno_log_motivo;
    private $desenvolvimento_nivel_solicitacao;
    private $desenvolvimento_ramal;
    private $log_descricao;
    private $so_id;
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
	    		$c = new Desenvolvimento;
	    		foreach ($d as $k2=>$dado){
	    			$c->set($k2, $dado);
	    		}
	    		$this->lista[$k1] = $c;
	    	}
    	}
    	
    }
    
    public function get_desenvolvimento_data_inicio(){
    	return !empty($this->desenvolvimento_data_inicio) ? Funcoes::formataDataComHora($this->desenvolvimento_data_inicio) : "";
    }
    
    public function get_desenvolvimento_data_criacao(){
    	return !empty($this->desenvolvimento_data_criacao) ? Funcoes::formataDataComHora($this->desenvolvimento_data_criacao) : "";
    }
    
    public function get_desenvolvimento_data_final(){
    	return !empty($this->desenvolvimento_data_final) ? Funcoes::formataDataComHora($this->desenvolvimento_data_final) : "";
    }
    
    public function get_desenvolvimento_nivel_solicitacao(){
    	$nivel = "";
    	
    	switch($this->desenvolvimento_nivel_solicitacao){
    		case 1: $nivel = "Desenvolvimento"; break;
    		case 2: $nivel = "Suporte"; break;
    	}
    	
    	return $nivel;
    }
    
    public function get_desenvolvimento_status(){
    	$status = "";
    	switch($this->desenvolvimento_status){
    		case 0: $status = "Storyboard"; break;
    		case 1: $status = "Aprovada"; break;
    		case 2: $status = "Em Andamento"; break;
    		case 3: $status = "Parada"; break;
    		case 4: $status = "Em Testes"; break;
    		case 5: $status = "Finalizada"; break;
    		case 6: $status = "Reprovada"; break;
    		case 7: $status = "Bug"; break;
    		case 8: $status = "Reanálise"; break;
    	}
    	
    	return $status;
    }
    
    public function get_desenvolvimento_nivel(){
    	$nivel = "";
    	switch($this->desenvolvimento_nivel){
    		case 1: $nivel = "Urgente"; break;
    		case 2: $nivel = "Normal"; break;
    		case 3: $nivel = "Baixo"; break;
    	}
    	
    	return $nivel;
    }
    
    public function get_desenvolvimento_tipo(){
    	$tipo = "";
    	switch($this->desenvolvimento_tipo){
    		case 1: $tipo = "Problema"; break;
    		case 2: $tipo = "Projeto"; break;
    		case 3: $tipo = "Manutenção"; break;
    		case 4: $tipo = "Auxílio"; break;
    	}
    	return $tipo;
    }
    
    public function get_log_descricao(){
    	return trim(str_replace("Alteração status da solicitação para", "", $this->log_descricao));
    }
    
    
    
    //SET E GET GENERICO
    public function set($key , $dado){
    	$this->$key = $dado;
    }
    
    public function get($key, $original = FALSE){
    	$metodo = "get_".$key;
    
    	if(method_exists($this, $metodo) && !$original)
    		return $this->$metodo();
    	else
    		return $this->$key;
    }
    

    public function insert($dados) {
        $this->Create()->ExCreate($this->_tabela, $dados);
        return $this->Create()->getResult();
    }
    
    public function insertSms($dados) {
        $this->Create()->ExCreate("sms_oraculo", $dados);
        return $this->Create()->getResult();
    }

    public function listar($desenvolvedor, $supervisor, $nivel = null, $limitacao = false, $limite = NULL) {
    	$desenvolvedor = $desenvolvedor ? " AND desenvolvimento_status IN (2, 3, 7)" : "";
    	$supervisor = $supervisor && !strpos($this->_filtros, "desenvolvimento_status") ? " OR desenvolvimento_status IN (0, 1, 8)" : "";
        $nivel = !empty($nivel) ? "AND desenvolvimento_nivel_solicitacao = {$nivel}" : "";
    	$limitacao = $limitacao  ? "AND desenvolvimento_status NOT IN (5, 6)" : "";
        $limite = !empty($limite) ? 'LIMIT ' . $limite : '';
        $this->_sql = "SELECT d.*, u.nome as desenvolvimento_usuario, us.nome as desenvolvimento_programador, s.setor_local as desenvolvimento_setor FROM desenvolvimento d
						INNER JOIN usuarios u ON d.desenvolvimento_id_usuario = u.id
						LEFT JOIN usuarios us ON d.desenvolvimento_id_programador  = us.id
						LEFT JOIN setor s ON u.id_setor = s.`setor_id`
					    WHERE desenvolvimento_id = desenvolvimento_id {$this->_filtros} {$desenvolvedor}{$nivel} {$limitacao} {$supervisor} 
						ORDER BY FIELD(desenvolvimento_status, 0, 1,2, 4, 3,7,5,6, 8) ASC, desenvolvimento_data_criacao DESC,desenvolvimento_nivel_solicitacao  DESC {$limite}";
	   $this->Read()->FullRead($this->_sql, null);
       $this->setDadosLista($this->Read()->getResult());
	   return $this->lista;
    }
    
    public function select($id_solicitacao) {
        $this->_sql = "SELECT d.*, u.nome as desenvolvimento_usuario, us.nome as desenvolvimento_programador, s.setor_local as desenvolvimento_setor FROM desenvolvimento d
		INNER JOIN usuarios u ON d.desenvolvimento_id_usuario = u.id
		LEFT JOIN usuarios us ON d.desenvolvimento_id_programador  = us.id
		LEFT JOIN setor s ON u.id_setor = s.`setor_id`
		WHERE desenvolvimento_id =  {$id_solicitacao}";
        $this->Read()->FullRead($this->_sql, null);
        $this->setDados($this->limparArray($this->Read()->getResult()));
    }
    
    public function selectStatusLog($id_solicitacao){
    	$this->_sql = "SELECT log_texto AS desenvolvimeno_log_motivo, log_descricao FROM logs_solicitacao WHERE log_solicitacao = {$id_solicitacao} AND log_descricao LIKE '%status%' AND log_texto != '' ORDER BY log_id DESC LIMIT 1";
    	$this->Read()->FullRead($this->_sql, null);
    	$this->setDados($this->limparArray($this->Read()->getResult()));
    }
    
    public function selectArray($id_solicitacao) {
        $this->_sql = "SELECT d.*, u.nome as usuario, us.nome as programador, s.setor_local FROM desenvolvimento d
		INNER JOIN usuarios u ON d.desenvolvimento_id_usuario = u.id
		LEFT JOIN usuarios us ON d.desenvolvimento_id_programador  = us.id
		LEFT JOIN setor s ON u.id_setor = s.`setor_id`
		WHERE desenvolvimento_id =  {$id_solicitacao}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function updateSolicitacao($dados) {
        $this->Update()->ExUpdate($this->_tabela, $dados, "WHERE desenvolvimento_id = {$dados['desenvolvimento_id']}", null);
        return $this->Update()->getResult();
    }

    public function deleteSolicitacao($id_solicitacao) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE desenvolvimento_id = {$id_solicitacao}", null);
        $this->Delete()->ExDelete("logs_solicitacao", "WHERE log_solicitacao = {$id_solicitacao}", null);
        $this->Delete()->ExDelete("sms_oraculo", "WHERE so_solicitacao = {$id_solicitacao}", null);
        return $this->Delete()->getResult();
    }

    public function selectComFiltros($f) {
        $filtros = "";
        $s = isset($f['status'])? $f['status'] : -1;
        $programador = isset($f['id_programador']) && $f['id_programador'] != '' && !in_array($s, array(0, 1 , 8)) ? " AND d.desenvolvimento_id_programador = {$f['id_programador']}" : '';
        $status = isset($f ['status']) && $f ['status'] != '' ? " AND d.desenvolvimento_status = {$f['status']}" : '';
        $nivel = isset($f ['nivel']) && $f ['nivel'] != '' ? " AND d.desenvolvimento_nivel = {$f['nivel']}" : '';
        $id = isset($f['id_usuario']) ? " AND desenvolvimento_id_usuario = {$f['id_usuario']} AND (desenvolvimento_id_programador != {$f['id_usuario']} OR desenvolvimento_id_programador IS NULL)" : '';
        $tipo = isset($f['tipo']) && $f['tipo'] != "" ? " AND desenvolvimento_tipo = {$f['tipo']}" : "";
        $modulo = isset($f['modulo']) && $f['modulo'] != "" ? " AND desenvolvimento_nivel_solicitacao = {$f['modulo']}" : "";

        if (!empty($f ['filtro']) && !empty($f["texto"])) {

            if ($f['filtro'] == "codigo")
                $filtros .= " AND d.desenvolvimento_id = {$f['texto']}";

            else if ($f['filtro'] == "solicitante")
                $filtros .= " AND u.nome like '%{$f['texto']}%'";

            else if ($f['filtro'] == "setor")
                $filtros .= " AND setor_local like '%{$f['texto']}%'";

            else if ($f['filtro'] == "titulo")
                $filtros .= " AND desenvolvimento_modulo like '%{$f['texto']}%'";
            
            else if ($f['filtro'] == "programador")
                $filtros .= " AND us.nome like '%{$f['texto']}%'";
        }

        $filtros .= $status . $nivel . $id . $programador .$tipo.$modulo;

        
        $this->_filtros = $filtros;
    }

    public function selectValoresStatus($nivel = null) {
    	$nivel = !empty($nivel) ? "AND desenvolvimento_nivel_solicitacao = {$nivel}" : "";
        $this->_sql = "SELECT COUNT(*) as total, d.desenvolvimento_status  FROM desenvolvimento d 
        				WHERE d.desenvolvimento_id = desenvolvimento_id {$this->_filtros} {$nivel}
						GROUP by desenvolvimento_status";
        $this->Read()->FullRead($this->_sql, null);
        $result = array();
        foreach( $this->Read()->getResult() as $r){
        	$result[$r['desenvolvimento_status']] = $r['total'];
        }
        
        return $result;
    }

    public function insertLog($dados) {
        $this->Create()->ExCreate("logs_solicitacao", $dados);
        return $this->Create()->getResult();
    }

    public function selectHistorico($id_solicitacao, $limite = NULL) {
        $limite = !empty($limite) ? 'LIMIT ' . $limite : '';
        $this->_sql = "SELECT l.*, u.nome FROM logs_solicitacao l
						INNER JOIN usuarios u ON l.log_usuario = u.id
						WHERE log_solicitacao = {$id_solicitacao} ORDER by log_data DESC {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectLog($id) {
        $this->_sql = "SELECT 
						  l.*,
						  u.nome AS usuario
						FROM
						  logs_solicitacao l 
						  INNER JOIN usuarios u 
						    ON l.log_usuario = u.id 
							WHERE l.log_id = {$id}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }
    
    public function selectProgramadorHelp($id_programador){
    	$this->_sql = "
		SELECT
		  DISTINCT u.id
		FROM
		  permissaouser_usuarios pu
		  LEFT JOIN permissaouser p
		    ON pu.`id_permissaouser` = p.`id_permissao`
		  INNER JOIN usuarios u
		    ON pu.`id_usuario` = u.`id`
		  LEFT JOIN grupos_permissao gp
		    ON pu.`id_permissao_grupo` = gp.`gp_id`
		  LEFT JOIN permissao_grupo pg
		    ON pg.`permissao_grupo_grupo` = gp.`gp_id`
		  LEFT JOIN permissaouser ps
   			ON pg.`permissao_grupo_permissao` = ps.`id_permissao`
		WHERE p.tipo_permissao = 'desenvolvedor' OR  ps.tipo_permissao = 'desenvolvedor'
				AND ativo =1 AND u.id != {$id_programador}";
    	$this->Read()->FullRead($this->_sql, null);
    	return $this->limparArray($this->Read()->getResult())['id'];
    }
    
    public function selectTestadasEmail(){
    	$this->_sql = "SELECT 
						  d.desenvolvimento_email,
    			 		  d.desenvolvimento_id_usuario,
						  GROUP_CONCAT(d.`desenvolvimento_id`) AS log_motivo,
    					  u.nome as desenvolvimento_nome_usuario
						FROM
						  desenvolvimento d 
    					INNER JOIN usuarios u 
    						ON d.desenvolvimento_id_usuario = u.id
						WHERE desenvolvimento_status = 4 
						  AND NOW() = DATE_ADD(
						    (SELECT 
						      log_data 
						    FROM
						      logs_solicitacao LOG
						    WHERE log_solicitacao = d.`desenvolvimento_id` AND log_descricao LIKE '%status%' 
						    ORDER BY log_id DESC 
						    LIMIT 1),
						    INTERVAL 7 DAY
						  ) 
						GROUP BY d.`desenvolvimento_id_usuario` ";
    	$this->Read()->FullRead($this->_sql, null);
    	$this->setDadosLista($this->Read()->getResult());
    	return $this->lista;
    }
    
    public function selectSolicitacoesParaSeremFinalizadas(){
    	$this->_sql = "SELECT 
						  d.desenvolvimento_email,
    					  GROUP_CONCAT(d.`desenvolvimento_id`) AS desenvolvimento_id,
  						  d.desenvolvimento_id_usuario,
    					 u.nome as desenvolvimento_nome_usuario 
						FROM
						  desenvolvimento d 
    					INNER JOIN usuarios u 
    						ON d.desenvolvimento_id_usuario = u.id
						WHERE desenvolvimento_status = 4  
						 AND NOW() > DATE_ADD(
						    (SELECT 
						      log_data 
						    FROM
						      logs_solicitacao LOG
						    WHERE log_solicitacao = d.`desenvolvimento_id` AND log_descricao LIKE '%status%'
						    ORDER BY log_id DESC 
						    LIMIT 1),
						    INTERVAL 7 DAY
						  ) 
						GROUP BY d.`desenvolvimento_id_usuario`";
    	$this->Read()->FullRead($this->_sql, null);
    	$this->setDadosLista($this->Read()->getResult());
    	return $this->lista;
    }
    
    public function selectLogParada($id_solicitacao){
    	$this->_sql = "SELECT 
						  log_texto as log_descricao
						FROM
						  logs_solicitacao 
						WHERE log_solicitacao = {$id_solicitacao} 
						  AND log_descricao LIKE '%parada%' 
						ORDER BY log_id DESC LIMIT 1";
    	$this->Read()->FullRead($this->_sql, null);
    	return $this->limparArray($this->Read()->getResult());
    }
    
    public function updateSolicitacoesParadas(){
    	$this->Read()->FullUpdate("UPDATE 
									  desenvolvimento d 
									  INNER JOIN usuarios u 
									    ON d.desenvolvimento_id_usuario = u.id SET desenvolvimento_status = 2 
									WHERE desenvolvimento_status = 3 
									  AND NOW() > DATE_ADD(
									    (SELECT 
									      log_data 
									    FROM
									      logs_solicitacao LOG
									    WHERE log_solicitacao = d.`desenvolvimento_id` 
									      AND log_descricao LIKE '%status%' 
									    ORDER BY log_id DESC 
									    LIMIT 1),
									    INTERVAL 30 DAY
									  )");
    }
    
    public function selectSMSOraculo(){
    	$this->_sql = "SELECT 
						  d.`desenvolvimento_nivel`,
						  d.`desenvolvimento_nivel_solicitacao`,
						  s.`so_id` 
						FROM
						  sms_oraculo s 
						  INNER JOIN desenvolvimento d 
						    ON s.`so_solicitacao` = d.`desenvolvimento_id` 
						WHERE so_data <= NOW() 
						  AND so_status = 0";
    	$this->Read()->FullRead($this->_sql, null);
    	$this->setDadosLista($this->Read()->getResult());
    	return $this->lista;
    	
    }
    
    public function atualizarStatusSms($id){
    	$this->Update()->ExUpdate("sms_oraculo", array("so_status"=>1), "WHERE so_id = {$id}", null);
    	$this->Update()->getResult();
    }
    
    public function insertAnexo($Dados){
    	$this->Create()->ExCreate("anexos_solicitacao", $Dados);
    	$this->Create()->getResult();
    }
    
    public function selectAnexos($id_solicitacao){
    	$this->Read()->ExRead("anexos_solicitacao", "WHERE desenvolvimento_id = {$id_solicitacao}" , null);
    	return $this->Read()->getResult();
    }
    
    public function deletarAnexo($id_anexo){
    	$this->Delete()->ExDelete("anexos_solicitacao", "WHERE anexo_id = {$id_anexo}", null);
    	$this->Delete()->getResult();
    }
    
    public function limparFiltros(){
    	$this->_filtros = "";
    }

}
