<?php

final class Veiculos extends Crud {

    private $_id_veiculo;
    private $_tabela = "veiculos";
    private $_sql;
    private $_filtros;

    public function setIdV($idv) {
        $this->_id_veiculo = $idv;
    }

    public function getIdV() {
        return $this->_id_veiculo;
    }

    public function insert($dados) {
        $this->Create()->ExCreate($this->_tabela, $dados);
        return $this->Create()->getResult();
    }
    
    public function updateVeiculo($dados) {
        $this->Update()->ExUpdate($this->_tabela, $dados, "WHERE id_veiculo= :id", "id={$dados['id_veiculo']}");
        return $this->Update()->getResult();
    }

    public function deleteVeiculo($id_veiculos) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE id_veiculo = :id", "id={$id_veiculos}");
        return $this->Delete()->getResult();
    }

    public function deleteVeiculoPorContrato($id_contrato) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE id_cliente = :id", "id={$id_contrato}");
        return $this->Delete()->getResult();
    }

    // seleciona o veiculo pelo id do veiculo
    public function select($id) {
        $this->_sql = "
			SELECT v.* , c.id_cliente 
			FROM " . $this->_tabela . " AS v 
			LEFT JOIN clientes AS c 
			ON v.id_cliente =  c.id_cliente     
			WHERE  v.id_veiculo  = " . $id;
        $this->Read()->FullRead($this->_sql, null);
        
        return $this->limparArray($this->Read()->getResult());
    }
    
    public function selectVeiculoSac($id) {
    	$this->_sql = "SELECT
    	v.placa,
    	v.cor,
    	v.ano,
    	v.modelo,
    	v.marca,
    	v.chassis,
    	v.renavam,
    	v.tipo_bateria,
    	v.id_veiculo,
    	v.cliente_ra,
    	v.tipo_cadastro,
    	v.observacoes
    	FROM veiculos v
    	LEFT JOIN clientes cli ON v.id_cliente = cli.id_cliente
    	WHERE v.id_veiculo = {$id}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    //ATUALIZAÃ‡Ã‚O 09/07/2015
    public function selectOSVeiculo($veiculos_os_id) {
        $this->_sql = "SELECT * FROM veiculos_os AS vos INNER JOIN veiculos AS v ON v.`id_veiculo` = vos.`veiculos_os_id_veiculo` WHERE vos.veiculos_os_id = {$veiculos_os_id}";
        $this->Read()->FullRead($this->_sql);
        return $this->limparArray($this->Read()->getResult());
    }

    // seleciona o veiculo pelo id do cliente
    public function selectIDCliente($id) {
        $this->_sql = "
        SELECT v.* , c.id_cliente 
        FROM " . $this->_tabela . " AS v 
        LEFT JOIN clientes AS c 
        ON v.id_cliente =  c.id_cliente     
        WHERE  v.id_cliente  = " . $id;
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    // busca total de veiculos cadAStrado por cliente:
    public function totalVeiculos($id) {
        $this->_sql = " 
        SELECT count( * ) AS totalVeiculos 
        FROM  {$this->_tabela} AS v  
        INNER JOIN clientes AS c 
                ON v.id_cliente = c.id_cliente    
        WHERE c.id_cliente =" . $id;
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult())['totalVeiculos'];
    }

    // busca total da taxa de instalacao :
    public function totaltaxaInstalacao($id) {
        $this->_sql = " 
        SELECT sum(taxa_instalacao) AS totalTxInstalacao 
        FROM  {$this->_tabela} AS v  
        INNER JOIN clientes AS c 
                ON v.id_cliente = c.id_cliente   
        WHERE c.id_cliente =" . $id;
        $this->Read()->FullRead($this->_sql, null);
        
        return $this->limparArray($this->Read()->getResult())['totalTxInstalacao'];
    }

    // busca total da taxa de manutencao :
    public function totaltaxamanutencao($id,$coluna) {
        $this->_sql = " 
        SELECT sum($coluna) AS totalTxmonitoramento 
        FROM  {$this->_tabela} AS v  
        INNER JOIN clientes AS c 
                ON v.id_cliente = c.id_cliente   
        WHERE c.id_cliente =" . $id;
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult())['totalTxmonitoramento'];
    }
    

     public function total_protecao($id,$protecao,$valor_protecao) {
        $this->_sql = " 
        SELECT sum($valor_protecao) AS totalprotecao 
        FROM  {$this->_tabela} AS v  
        INNER JOIN clientes AS c ON v.id_cliente = c.id_cliente   
        WHERE c.id_cliente =$id  AND tipo_seguro = '$protecao'";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult())['totalprotecao'];
    }
    
    public function valorUnitarioTaxaInstalacao($id) {
        $this->_sql = "
        SELECT DISTINCT(v.taxa_instalacao) ,count(v.taxa_instalacao) AS 'qtd_taxa_instalacao'
        FROM {$this->_tabela}  AS v 
        INNER JOIN clientes AS c 
                ON v.id_cliente = c.id_cliente
        WHERE v.id_cliente =" . $id . " 
        GROUP BY v.taxa_instalacao";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function valorUnitarioTaxaMonitoramento($id) {
        $this->_sql = " 
        SELECT DISTINCT(v.taxa_monitoramento) ,COUNT(v.taxa_monitoramento) AS 'qtd_taxa_monitoramento' 
        FROM {$this->_tabela}  AS v 
        INNER JOIN clientes AS c   ON v.id_cliente = c.id_cliente
        WHERE v.id_cliente =" . $id . " 
        GROUP BY v.taxa_monitoramento";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }
    
    public function selectVeiculosPorCliente($id_cliente, $statusVeiculo = NULL, $limite = NULL, $placa = false){
    	$limite = !empty($limite) ? "LIMIT {$limite}" : "";
    	$statusVeiculo = !empty($statusVeiculo) ? "AND veiculo_status = {$statusVeiculo}" : " AND veiculo_status = 1";
     	$placa = $placa ? "AND placa != '' AND placa IS NOT NULL" : "";
    	$this->_sql = "SELECT 
    						v.placa,
    						v.cor,
    						v.ano,
    						v.modelo,
    						v.marca,
    						v.chassis,
    						v.renavam,
    						v.tipo_bateria,
    						v.id_veiculo,
    						v.id_cliente,
    						v.cliente_ra,
    						v.veiculo_status,
    						v.tipo_cadastro
    					 	FROM veiculos v
							LEFT JOIN clientes cli ON v.id_cliente = cli.id_cliente
							WHERE v.cliente_ra = {$id_cliente} {$statusVeiculo} {$placa} {$limite}";
    	$this->Read()->FullRead($this->_sql, null);
    	return $this->Read()->getResult();
    }
    
    public function selectVeiculosPorClienteOs($id_cliente){
    	$this->_sql = "SELECT 
    						v.placa,
    						v.cor,
    						v.ano,
    						v.modelo,
    						v.marca,
    						v.chassis,
    						v.renavam,
    						v.tipo_bateria,
    						v.id_veiculo,
    						v.id_cliente,
    						v.cliente_ra,
    						v.veiculo_status,
    						v.tipo_cadastro
    					 	FROM veiculos v
							LEFT JOIN clientes cli ON v.id_cliente = cli.id_cliente
							WHERE v.cliente_ra = {$id_cliente} AND veiculo_status = 1 AND placa != ''";
    	$this->Read()->FullRead($this->_sql, null);
    	return $this->Read()->getResult();
    }
    
    public function selectVeiculosPorClienteSac($id_cliente, $statusVeiculo = NULL, $limite = NULL){
    	$limite = !empty($limite) ? "LIMIT {$limite}" : "";
    	$statusVeiculo = !empty($statusVeiculo) ? "AND veiculo_status = {$statusVeiculo}" : " AND veiculo_status = 1";
    	$this->_sql = "SELECT 
    						v.placa,
    						v.cor,
    						v.ano,
    						v.modelo,
    						v.marca,
    						v.chassis,
    						v.renavam,
    						v.tipo_bateria,
    						v.id_veiculo,
    						v.id_cliente,
    						v.cliente_ra,
    						v.veiculo_status,
    						v.tipo_cadastro,
    						m.modulo_serial as modulo
    					 	FROM veiculos v
							LEFT JOIN clientes cli ON v.id_cliente = cli.id_cliente
							LEFT JOIN veiculos_equipamentos ve ON v.id_veiculo = ve.veiculos_equipamentos_id_veiculo
							LEFT JOIN chips chip ON ve.veiculos_equipamentos_id_chip = chip.chip_id
							LEFT JOIN modulos as m ON chip.chip_modulo = m.modulo_id
							WHERE v.cliente_ra = {$id_cliente} {$statusVeiculo} {$limite}";
    	$this->Read()->FullRead($this->_sql, null);
    	return $this->Read()->getResult();
    }
    
    public function verificaVeiculoContrato($id_veiculo){
    	$this->_sql = "SELECT
    	v.*
    	FROM
    	veiculos v
    	INNER JOIN clientes c
    	ON v.id_cliente = c.`id_cliente`
    	INNER JOIN contratos con
    	ON c.`id_cliente` = con.`id_cliente`
    	WHERE v.`id_veiculo` = {$id_veiculo}";
    	$this->Read()->FullRead($this->_sql, null);
    	return $this->Read()->getRowCount();
    	 
    }

    /* EU */

    public function selectPorContrato($id_cliente, $limite= NULL) {
    	$limite = !empty($limite) ? "LIMIT {$limite}" : "";
        $this->_sql = "SELECT * FROM VEICULOS WHERE id_cliente = {$id_cliente} {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }
    
    public function selectVeiculo($id_veiculo) {
        $this->Read()->ExRead($this->_tabela, "WHERE  id_veiculo  =:id", "id={$id_veiculo}");
        return $this->limparArray($this->Read()->getResult());
    }

    /*
     * ******************************************
     * ********* VEICULOS EQUIPAMENTOS **********
     * *******************************************
     */

    public function insertEquipamento($dados) {
        $this->Create()->ExCreate('veiculos_equipamentos', $dados);
        return $this->Create()->getResult();
    }

    public function updateEquipamento($dados) {
        $this->Update()->ExUpdate('veiculos_equipamentos', $dados, "WHERE veiculos_equipamentos_id_veiculo =:id", "id={$dados['veiculos_equipamentos_id_veiculo']}");
        return $this->Update()->getResult();
    }

    public function selectEquipamentos($id_veiculo) {
        $this->Read()->ExRead("veiculos_equipamentos", "WHERE  veiculos_equipamentos_id_veiculo = :id", "id={$id_veiculo}");
        return $this->limparArray($this->Read()->getResult());
    }

    /*
     * ********************************
     * ********* VEICULOS OS **********
     * ********************************
     */

    public function insertOS($dados) {
        $this->Create()->ExCreate('veiculos_os', $dados);
        return $this->Create()->getResult();
    }

    public function updateOS($dados) {
        $this->Update()->ExUpdate('veiculos_os', $dados, "WHERE veiculos_os_id = :id", "id={$dados['veiculos_os_id']}");
        return $this->Update()->getResult();
    }
    
    public function selectVeiculcosOS($dados) {
        $limite = !empty($dados ['limite']) ? "LIMIT " . $dados ['limite'] : "";
        $this->_sql = "
			SELECT os.* , v.placa  
			FROM veiculos_os  AS os 
			LEFT JOIN veiculos AS v 
				ON os.veiculos_os_id_veiculo = v.id_veiculo  
			WHERE v.cliente_ra = {$dados['id_cliente']} ORDER BY veiculos_os_id DESC {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

	public function selectOS($veiculo_id_os) {
        $this->_sql = "
		SELECT
		c.*,
		ve.*,
		os.*,
		chip.chip_operadora,
		chip.chip_modulo,
		chip.chip_linha,
		cre.credenciado_razao_social,
		IF(v.placa IS NULL, os.veiculos_os_placa, v.placa) as placa,
    	v.cor,
    	v.ano,
    	v.modelo,
    	v.marca,
    	v.chassis,
    	v.renavam,
    	v.tipo_bateria,
    	v.id_veiculo		
		FROM veiculos_os  AS os
		INNER JOIN veiculos AS v ON os.veiculos_os_id_veiculo = v.id_veiculo
		INNER JOIN clientes AS c ON v.cliente_ra = c.id_cliente
		LEFT JOIN veiculos_equipamentos AS ve ON os.veiculos_os_id_veiculo = ve.veiculos_equipamentos_id_veiculo
		LEFT JOIN chips chip ON  ve.veiculos_equipamentos_id_chip = chip.chip_id
		LEFT JOIN credenciados cre ON os.veiculos_os_id_credenciado = cre.credenciado_id
		WHERE veiculos_os_id = {$veiculo_id_os}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }
    
    public function setFiltrosVeiculosOS($busca){
    	$campos = array(
    			"nome_cliente",
    			"placa",
    			"credenciado_razao_social",
    			"veiculos_os_tecnico",
    			"cliente_cidade",
    			"cliente_estado",
    			"veiculos_os_protocolo",
    			"cnpjcpf_cliente",
    			"chip_chip",
    			"chip_modulo"
    	);
    	$this->_filtros = $this->filtrar($campos, $busca);
    }
    
    public function selectOSEmAberto($tipo, $status, $limite = NULL){
    	$status = !empty($status) ? "AND veiculos_os_status = {$status}" : "";
    	$tipo 	= !empty($tipo)   ? "AND veiculos_os_tipo = {$tipo}" : "";
    	$limite = !empty($limite) ? "LIMIT {$limite}" : " LIMIT 1000";
    	$this->_sql = "SELECT vo.*, c.nome_cliente, cre.credenciado_razao_social FROM veiculos_os vo
    					INNER JOIN clientes c ON vo.veiculos_os_id_cliente = c.id_cliente
    					LEFT JOIN credenciados cre ON vo.veiculos_os_id_credenciado = cre.credenciado_id
    					WHERE veiculos_os_id>=1 {$status} {$tipo} {$this->_filtros} GROUP BY veiculos_os_id ORDER BY veiculos_os_gravidade, veiculo_os_data_criacao DESC {$limite}";
    	$this->Read()->FullRead($this->_sql);
    	return $this->Read()->getResult();
    }
    
    
    public function selecionarOsPorVeiculo($id_veiculo){
    	$this->Read()->ExRead("veiculos_os", "WHERE veiculos_os_id_veiculo = {$id_veiculo}");
    	return $this->Read()->getResult();
    }
    
    /*
     * ***********************************************
     * ********* VEICULOS PLANO ASSITENCIAL **********
     * ***********************************************
     */

    public function insertPlanoAssitencial($dados) {
        $this->Create()->ExCreate("plano_assistencial", $dados);
        return $this->Create()->getResult();
    }

    public function updatePlanoAssistencial($dados) {
        $this->Update()->ExUpdate('plano_assistencial', $dados, "WHERE id_veiculo = :id", "id={$dados['id_veiculo']}");
        return $this->Update()->getResult();
    }

    public function selectPlanoAssitencialVeiculo($id_veiculo) {
        $this->_sql = " 
			SELECT V.*,
			PLA.id  AS PLA_ID,
			PLA.status_planoAssistencia,
			PLA.tags_planoAssistencia,
			PLA.valor
			FROM veiculos  as V 
			LEFT JOIN plano_assistencial AS PLA 
				ON V.id_veiculo = PLA.id_veiculo 
			WHERE V.id_veiculo = {$id_veiculo}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectPlanoAssitencialCliente($dados) {
        $limite = isset($dados ['limite']) ? "LIMIT {$dados['limite']}" : "";
        $this->_sql = "
			SELECT V.*,
			PLA.id  AS PLA_ID ,
			PLA.status_planoAssistencia 
			FROM veiculos  as V 
			LEFT JOIN plano_assistencial AS PLA 
				ON V.id_veiculo = PLA.id_veiculo 
			WHERE V.id_cliente = {$dados['id_cliente']} ORDER BY V.id_veiculo DESC {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectPlanoAssitencial($id_veiculo) {
        $this->Read()->ExRead("plano_assistencial", "WHERE  id_veiculo  =:id", "id={$id_veiculo}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function getSql() {
        return $this->_sql;
    }
    
    
    /*
     * ****************************************
     * ********* VEICULOS ADICIONAIS **********
     * ****************************************
     */
    
    public function insertAdicional($dados) {
    	$this->Create()->ExCreate("veiculos_adicional", $dados);
    	return $this->Create()->getResult();
    }
    
    public function selectAdicional($id_veiculo_antigo){
    	$this->Read()->ExRead("veiculos_adicional", "WHERE veiculo_id_antigo = {$id_veiculo_antigo}", null);
    	return $this->limparArray($this->Read()->getResult());
    }
    
    public function updateVeiculoAdicional($dados) {
    	$this->Update()->ExUpdate("veiculos_adicional", $dados, "WHERE id_veiculo= :id", "id={$dados['id_veiculo']}");
    	return $this->Update()->getResult();
    }

}
