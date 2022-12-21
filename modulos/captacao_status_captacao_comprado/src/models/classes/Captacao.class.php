<?php

// namespace C:\wamp\www\gpi\modulos\captacao\src\models\classes\Captacao.class.php

/**
 * 
 * @author desenvolvimento
 * @package modulos/captacao/src/models/
 * Classe que controla todas as ações relacionadas com a captação
 */
final class Captacao extends Crud {

    private $_sql;
    private $_tabela = 'captacao';
    private $captacaoCampos = array("captacao_cliente", "origem", "captacao_telefone1", "captacao_telefone2", "captacao_telefone3", "captacao_interesse");
    private $captacaoInteresse = array("captacao_niveis_interesses_desc");
    private $captacaoUsuarios = array("u.nome", "us.nome");
    private $filtros = "";

    public function insert($dados) {

        $this->Create()->ExCreate($this->_tabela, $dados);
        return $this->Create()->getResult();
    }

    public function insertCaptacaoDeletada($dados) {
        $this->Create()->ExCreate("captacao_deletadas", $dados);
        return $this->Create()->getResult();
    }

    public function deleteCaptacao($id) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE captacao_id = {$id}", null);
        return $this->Delete()->getResult();
    }

    public function updateCaptacao(array $Dados) {
        $this->Update()->ExUpdate($this->_tabela, $Dados, "WHERE captacao_id =:id", "id={$Dados['captacao_id']}");
        return $this->Update()->getResult();
    }

    public function updateCaptacaoNivelUsuario(array $Dados) {
        $this->Update()->ExUpdate("captacao_niveis_usuarios", $Dados, "WHERE captacao_niveis_usuarios_id =:id", "id={$Dados['captacao_niveis_usuarios_id']}");
        return $this->Update()->getResult();
    }

    public function ListarCaptacao($limite = NULL, $status, $permissao) {
        $status = !empty($status) ? " AND C.captacao_status = '{$status}' " : "";
        $limite = !empty($limite) ? " LIMIT {$limite}" : "";
        $permissao = $permissao ? " AND (cn.captacao_niveis_ra IN(2,3,4) OR C.captacao_interesse IN('cftv','alarme Comercial','alarme Residencial','cerca Eletrica','portaria'))" : "";
        $this->_sql = "	
			SELECT 
				C.origem,
				C.captacao_status,
				C.captacao_id,
				C.captacao_data_criacao,
				C.captacao_cliente,
                                C.captacao_indicador,
				IF(C.captacao_interesse>=1, cni.captacao_niveis_interesses_desc, c.captacao_interesse) as captacao_interesse,
				C.captacao_telefone1,SUBSTRING(REPLACE(REPLACE(C.captacao_telefone1,')', '' ),'(', '' ),1,2) AS ddd1,
				C.captacao_telefone1,
				C.motivo_finalizacao AS motivo,	
				U.id as usuario_id,
				U.nome  AS vendedor, 
				us.nome as usuarioCadastro
		FROM {$this->_tabela} AS C 
		INNER JOIN usuarios  AS U 
			ON C.captacao_id_usuario =  U.id
		LEFT JOIN captacao_niveis_interesses CNI
			ON C.captacao_interesse = CNI.captacao_niveis_interesses_id
		LEFT JOIN captacao_niveis cn
			ON cni.captacao_niveis_interesses_nivel = cn.captacao_niveis_id
		LEFT JOIN usuarios us
			ON C.id_usuario = us.id
		WHERE (C.captacao_id >=1 {$status} {$permissao}) {$this->filtros} GROUP by captacao_id ORDER BY captacao_data_criacao DESC {$limite}";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function ListarCaptacaoComFiltro($busca) {
        $campos = array_merge($this->captacaoCampos, $this->captacaoInteresse, $this->captacaoUsuarios);
        $this->filtros = $this->filtrar($campos, $busca);
    }

    public function selectCaptacaoUser($filtros, $limite) {
        $where = !empty($filtros['busca']) ? $this->filtrar($this->captacaoCampos, $filtros['busca']) : '';
        $orderby = empty($filtros['busca']) ? " captacao_status = 'novo'," : "";
        $limite = (!empty($limite)) ? "LIMIT {$limite}" : "";
        $status = !empty($filtros['status']) ? " AND captacao_status = '{$filtros['status']}'" : "";

        $this->_sql = " SELECT  * FROM  {$this->_tabela} WHERE captacao_id_usuario = {$filtros['id']} {$where} {$status}
		ORDER BY {$orderby} captacao_data_criacao DESC {$limite}";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function selCaptacao($id_captacao) {
        $this->_sql = "SELECT c.*, 
        IF (c.captacao_interesse >= 1, cni.captacao_niveis_interesses_desc , c.captacao_interesse) AS interesse, 
        u.nome as vendedor,
        IF(us.id IS NULL, c.origem, us.nome) as cadastro
        FROM captacao c
                LEFT JOIN captacao_niveis_interesses cni ON c.captacao_interesse = cni.captacao_niveis_interesses_id
        LEFT JOIN usuarios u ON c.captacao_id_usuario = u.id 
        LEFT JOIN usuarios us ON c.id_usuario = us.id 
        WHERE captacao_id = {$id_captacao}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function selCaptacaoId($id_captacao) {
        $this->Read()->ExRead("captacao", "WHERE captacao_id = {$id_captacao}", null);
        return $this->limparArray($this->Read()->getResult());
    }

    // seleciona o tipo de proposta
    public function setTipoProposta($id) {
        $this->Read()->ExRead("proposta", "WHERE proposta_id_captacao = :id", "id={$id}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function statusCaptacao() {
        $this->_sql = "SELECT DISTINCT(captacao_status) as 'captacao_status' FROM captacao  ORDER BY captacao_status ASC";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectCaptacaoCliente() {
        $this->_sql = "SELECT c.nome_cliente, cap.captacao_id, cni.captacao_niveis_interesses_desc as captacao_interesse, id_cliente FROM captacao cap
						INNER JOIN clientes c ON cap.captacao_id_cliente = c.id_cliente
						LEFT JOIN captacao_niveis_interesses cni ON cap.captacao_interesse = cni.captacao_niveis_interesses_id
						WHERE captacao_status = 'novo'";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selCliente($id) {

        $this->_sql = " SELECT captacao_cliente AS cliente,captacao_telefone1 AS ddd, captacao_id as id_captacao FROM " . $this->_tabela . " 
			  WHERE captacao_id =" . $id;
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectCaptacaoAbertaUsuarios($id_usuario) {
        $this->Read()->ExRead($this->_tabela, "WHERE captacao_id_usuario = {$id_usuario} AND captacao_status != 'comprado' AND captacao_status != 'cancelado' GROUP By captacao_id");
        return $this->Read()->getResult();
    }

    /*
     * *************************************
     * ********* MÉTOODS GRÁFICOS **********
     * *************************************
     */

    public function gerarIndicesInteresses($dt_inicial, $dt_final, $vendedor, $statusCaptacao) {
        $dt_inicial = !empty($dt_inicial) ? "AND captacao_data_criacao >= '{$dt_inicial} 00:00:00'" : "";
        $dt_final = !empty($dt_inicial) ? "AND captacao_data_criacao <= '{$dt_final} 23:59:59'" : "";
        $vendedor = !empty($vendedor) ? "AND captacao_id_usuario = {$vendedor}" : "";
        $statusCaptacao = !empty($statusCaptacao) ? "AND captacao_status = '{$statusCaptacao}'" : "";

        $this->_sql = "SELECT 
						  COUNT(*) as value,
						  cn.captacao_niveis_interesses_desc as label
						FROM
						  captacao c 
						  LEFT JOIN captacao_niveis_interesses CN 
						    ON c.captacao_interesse = cn.captacao_niveis_interesses_id 
						  WHERE captacao_interesse != '' {$dt_inicial} {$dt_final} {$vendedor} {$statusCaptacao}
						GROUP BY captacao_interesse ORDER by value DESC";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function gerarIndicesVendedores($dt_inicial, $dt_final, $statusCaptacao, $interesseCaptacao) {
        $dt_inicial = !empty($dt_inicial) ? "AND captacao_data_criacao >= '{$dt_inicial} 00:00:00'" : "";
        $dt_final = !empty($dt_inicial) ? "AND captacao_data_criacao <= '{$dt_final} 23:59:59'" : "";
        $statusCaptacao = !empty($statusCaptacao) ? "AND captacao_status = '{$statusCaptacao}'" : "";
        $interesseCaptacao = !empty($interesseCaptacao) ? "AND captacao_interesse = {$interesseCaptacao}" : "";

        $this->_sql = "SELECT 
        COUNT(*) as value,
        u.nome as label,
         IF (
          cn.captacao_niveis_interesses_id IS NULL,
          UPPER(captacao_interesse),
          UPPER(cn.captacao_niveis_interesses_desc)
        ) AS interesse
        FROM
        captacao c 
        LEFT JOIN captacao_niveis_interesses CN 
          ON c.captacao_interesse = cn.captacao_niveis_interesses_id 
        INNER JOIN usuarios u ON c.captacao_id_usuario = u.id
        WHERE c.captacao_id = c.captacao_id AND captacao_interesse != '' {$dt_inicial} {$dt_final} {$statusCaptacao} {$interesseCaptacao}
        GROUP BY c.captacao_id_usuario  ORDER by value DESC";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function gerarIndicesStatus($dt_inicial, $dt_final, $vendedor, $interesseCaptacao) {
        $dt_inicial = !empty($dt_inicial) ? "AND captacao_data_criacao >= '{$dt_inicial} 00:00:00'" : "";
        $dt_final = !empty($dt_inicial) ? "AND captacao_data_criacao <= '{$dt_final} 23:59:59'" : "";
        $interesseCaptacao = !empty($interesseCaptacao) ? "AND captacao_interesse = {$interesseCaptacao}" : "";
        $vendedor = !empty($vendedor) ? "AND captacao_id_usuario = {$vendedor}" : "";

        $this->_sql = "SELECT 
						  COUNT(*) as value,
						  upper(captacao_status) as label
						FROM
						  captacao c 
						  LEFT JOIN captacao_niveis_interesses CN 
						    ON c.captacao_interesse = cn.captacao_niveis_interesses_id
    					WHERE c.captacao_id = c.captacao_id {$dt_inicial} {$dt_final} {$vendedor} {$interesseCaptacao}
						GROUP BY captacao_status ORDER by value DESC";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function gerarIndicesEstados($dt_inicial, $dt_final, $vendedor, $statusCaptacao, $interesseCaptacao) {
        $dt_inicial = !empty($dt_inicial) ? "AND captacao_data_criacao >= '{$dt_inicial} 00:00:00'" : "";
        $dt_final = !empty($dt_inicial) ? "AND captacao_data_criacao <= '{$dt_final} 23:59:59'" : "";
        $interesseCaptacao = !empty($interesseCaptacao) ? "AND captacao_interesse = {$interesseCaptacao}" : "";
        $vendedor = !empty($vendedor) ? "AND captacao_id_usuario = {$vendedor}" : "";
        $statusCaptacao = !empty($statusCaptacao) ? "AND captacao_status = '{$statusCaptacao}'" : "";
        $this->_sql = "SELECT 
						  d.numCap as value,
						  d.ddd,
						  e.estado_nome as label 
						FROM
						  (SELECT 
						    COUNT(captacao_id) AS numCap,
						    SUBSTRING(
						      REPLACE(
						        REPLACE(c.captacao_telefone1, ')', ''),
						        '(',
						        ''
						      ),
						      1,
						      2
						    ) AS ddd 
						  FROM
						    captacao c 
    						LEFT JOIN captacao_niveis_interesses CN 
						    ON c.captacao_interesse = cn.captacao_niveis_interesses_id
						WHERE captacao_id = captacao_id  {$statusCaptacao} {$vendedor} {$dt_final} {$dt_inicial} {$interesseCaptacao}
						  GROUP BY ddd 
						  HAVING (
						      ddd IN 
						      (SELECT 
						        regiao_ddd 
						      FROM
						        regiao)
						    )) AS d 
						  INNER JOIN regiao r 
						    ON r.`regiao_ddd` = ddd 
						  INNER JOIN estado e 
						    ON r.`regiao_estado_id` = e.estado_id 
						GROUP BY estado_nome ";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function gerarIndiceComparativoVendedores($dt_inicial, $dt_final) {
        $dt_inicial = !empty($dt_inicial) ? "'{$dt_inicial} 00:00:00'" : "";
        $dt_final = !empty($dt_inicial) ? "'{$dt_final} 23:59:59'" : "";
        $this->_sql = "SELECT 
						  c.label,
						  SUM(c.contrato) AS contrato,
						  SUM(c.captacao) AS captacao 
						FROM
						  (SELECT 
						    u.`nome` AS label,
						    0 AS contrato,
						    COUNT(cap.captacao_id) AS captacao 
						  FROM
						    captacao cap 
						    INNER JOIN usuarios u 
						      ON cap.captacao_id_usuario = u.id 
						  WHERE cap.captacao_interesse = 5 
						    AND cap.captacao_data_criacao >= {$dt_inicial} 
						    AND cap.captacao_data_criacao <= {$dt_final} 
						  GROUP BY u.id 
						  UNION
						  SELECT 
						    u.nome AS label,
						    COUNT(con.id_contrato) AS contrato,
						    0 AS captacao 
						  FROM
						    contratos con 
						    INNER JOIN usuarios u 
						      ON con.id_usuario = u.id 
						  WHERE con.observacoes_contrato = 'ok' 
						    AND con.data_contrato_gerado >= {$dt_inicial} 
						    AND con.data_contrato_gerado <= {$dt_final} 
						  GROUP BY u.id) AS c 
						GROUP BY c.label ";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function gerarIndicesComparativoAnual() {
        $this->_sql = "SELECT 
						  a.label,
						  SUM(a.contrato) AS contrato,
						  SUM(a.captacao) AS captacao 
						FROM
						  (SELECT 
						    YEAR(captacao_data_criacao) AS label,
						    0 AS contrato,
						    COUNT(captacao_id) AS captacao 
						  FROM
						    captacao 
						  WHERE captacao_interesse = 5 
						  GROUP BY YEAR(captacao_data_criacao) 
						  UNION
						  SELECT 
						    YEAR(data_contrato_gerado) AS label,
						    COUNT(id_contrato) AS contrato,
						    0 AS captacao 
						  FROM
						    contratos 
						  WHERE observacoes_contrato = 'ok' 
						  GROUP BY YEAR(data_contrato_gerado)) AS a 
						GROUP BY a.label ";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function gerarIndicesComparativoMensal($ano) {
        $this->_sql = "SELECT 
						  m.label,
						  SUM(m.contrato) AS contrato,
						  SUM(m.captacao) AS captacao 
						FROM
						  (SELECT 
						    MONTH(captacao_data_criacao) AS label,
						    0 AS contrato,
						    COUNT(captacao_id) AS captacao 
						  FROM
						    captacao 
						  WHERE captacao_interesse = 5 
						    AND YEAR(captacao_data_criacao) = {$ano} 
						  GROUP BY MONTH(captacao_data_criacao) 
						  UNION
						  SELECT 
						    MONTH(data_contrato_gerado) AS label,
						    COUNT(id_contrato) AS contrato,
						    0 AS captacao 
						  FROM
						    contratos 
						  WHERE observacoes_contrato = 'ok' 
						    AND YEAR(data_contrato_gerado) = {$ano} 
						  GROUP BY MONTH(data_contrato_gerado)) AS m GROUP BY label";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function gerarIndiceComparativoEstadoAnual($ano, $groupby = false, $uf = null) {
        $groupby = $groupby ? ", mes" : "";
        $ufC = !empty($uf) ? "AND e.estado_nome = '{$uf}'" : "";
        $ufCon = !empty($uf) ? "AND uf_cliente = '{$uf}'" : "";
        $this->_sql = "SELECT 
						  f.mes,
						  f.uf,
						  SUM(f.captacao) AS captacao,
						  SUM(f.contrato) AS contrato 
						FROM
						  (SELECT 
						    MONTH(cap.`captacao_data_criacao`) AS mes,
						    e.`estado_nome` AS uf,
						    COUNT(cap.captacao_id) AS captacao,
						    0 AS contrato 
						  FROM
						    captacao cap 
						    INNER JOIN regiao r 
						      ON r.regiao_ddd LIKE SUBSTRING(
						        REPLACE(
						          REPLACE(cap.captacao_telefone1, ')', ''),
						          '(',
						          ''
						        ),
						        1,
						        2
						      ) 
						    INNER JOIN estado e 
						      ON r.`regiao_estado_id` = e.estado_id 
						  WHERE YEAR(cap.`captacao_data_criacao`) = {$ano}  
						    AND cap.captacao_interesse = 5 {$ufC}
						  GROUP BY MONTH(cap.`captacao_data_criacao`) 
						  UNION
						  SELECT 
						    MONTH(con.data_contrato_gerado) AS mes,
						    c.`uf_cliente` AS uf,
						    0 AS captacao,
						    COUNT(con.id_contrato) AS contrato 
						  FROM
						    contratos con 
						    INNER JOIN clientes c 
						      ON con.id_cliente = c.id_cliente 
						  WHERE YEAR(con.`data_contrato_gerado`) = {$ano}  
						    AND con.observacoes_contrato = 'ok' {$ufCon}
						  GROUP BY c.uf_cliente,
						    MONTH(con.`data_contrato_gerado`)) AS f 
						GROUP BY uf
						  {$groupby}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function gerarIndiceComparativoEstado($dt_inicial, $dt_final) {
        $dt_inicial = !empty($dt_inicial) ? "'{$dt_inicial} 00:00:00'" : "";
        $dt_final = !empty($dt_inicial) ? "'{$dt_final} 23:59:59'" : "";
        $this->_sql = "SELECT 
						  es.label,
						  SUM(es.contrato) AS contrato,
						  SUM(es.captacao) AS captacao,
						  SUM(es.antigo) AS antigo 
						FROM
						  (SELECT 
						    e.`estado_nome` AS label,
						    COUNT(cap.captacao_id) AS captacao,
						    0 AS contrato,
						    0 as antigo 
						  FROM
						    captacao cap 
						    INNER JOIN regiao r 
						      ON r.regiao_ddd LIKE SUBSTRING(
						        REPLACE(
						          REPLACE(cap.captacao_telefone1, ')', ''),
						          '(',
						          ''
						        ),
						        1,
						        2
						      ) 
						    INNER JOIN estado e 
						      ON r.`regiao_estado_id` = e.estado_id 
						  WHERE captacao_data_criacao >= {$dt_inicial} 
						    AND captacao_data_criacao <= {$dt_final} 
						    AND cap.captacao_interesse = 5 
						  GROUP BY e.estado_nome 
						  UNION
						  SELECT 
						    co.uf_cliente AS label,
						    0 AS captacao,
						    COUNT(co.id_contrato) AS contrato,
						    0 as antigo 
						  FROM
						    (SELECT 
						      cli.`uf_cliente`,
						      con.id_contrato,
						      (SELECT 
						        COUNT(con2.id_contrato) 
						      FROM
						        contratos con2 
						      WHERE con2.cliente_ra = cli.id_cliente 
						        AND con2.data_contrato_gerado >= {$dt_inicial}  
						        AND con2.data_contrato_gerado <= {$dt_final} ) AS quantCon 
						    FROM
						      contratos con 
						        INNER JOIN clientes cli 
						        ON con.cliente_ra = cli.id_cliente 
						    WHERE data_contrato_gerado >= {$dt_inicial} 
						      AND data_contrato_gerado <= {$dt_final}  
						      AND con.observacoes_contrato = 'ok' 
						    GROUP BY id_contrato 
						    HAVING (quantCon = 1)) AS co 
						  GROUP BY co.uf_cliente
						   UNION
							  SELECT 
							  co2.uf_cliente AS label,
							  0 AS captacao,
							  0 AS contrato,
							  COUNT(co2.id_contrato) AS antigo 
							FROM
							  (SELECT 
							    c.`uf_cliente`,
							    con.id_contrato,
							    (SELECT 
							      COUNT(con2.id_contrato) 
							    FROM
							      contratos con2 
							    WHERE con2.cliente_ra = cli.id_cliente 
							      AND con2.data_contrato_gerado >= {$dt_inicial} 
							      AND con2.data_contrato_gerado <= {$dt_final}) AS quantCon 
							  FROM
							    contratos con 
													    INNER JOIN clientes cli 
							      ON con.cliente_ra = cli.id_cliente 
							  WHERE data_contrato_gerado >= {$dt_inicial}  
							    AND data_contrato_gerado <= {$dt_final} 
							    AND con.observacoes_contrato = 'ok' 
							  GROUP BY id_contrato 
							  HAVING (quantCon > 1)) AS co2 
							GROUP BY co2.uf_cliente) AS es 
						GROUP BY label";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectValoresComparativos($dt_nicial, $dt_final, $estado, $antigo = false) {
        $operacao = $antigo ? ">" : "=";
        $this->_sql = "SELECT 
						  cli.nome_cliente AS cliente,
						  con.data_contrato_gerado, 
						  (SELECT 
						    COUNT(con2.id_contrato) 
						  FROM
						    contratos con2 
						  WHERE con2.cliente_ra = cli.id_cliente 
						    AND con2.data_contrato_gerado >= '{$dt_nicial} 00:00::00'
						    AND con2.data_contrato_gerado <= '{$dt_final} 23:59:59') AS quantCon 
						FROM
						  contratos con 
		
						  INNER JOIN clientes cli 
						    ON con.cliente_ra = cli.id_cliente 
						WHERE data_contrato_gerado >= '{$dt_nicial} 00:00::00'
						  AND data_contrato_gerado <= '{$dt_final} 23:59:59'
						  AND con.observacoes_contrato = 'ok' 
						  AND c.uf_cliente = '$estado'
						GROUP BY id_contrato 
						HAVING (quantCon {$operacao} 1)";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function gerarIndiceComparativoSeguro($ano) {
        $this->_sql = "SELECT 
						  COUNT(con.id_contrato) AS contrato,
						  MONTH(con.data_contrato_gerado) AS label, 
						  (SELECT 
						    COUNT(*) 
						  FROM
						    contratos con2 
						  WHERE con2.`observacoes_contrato` = 'ok' 
						    AND YEAR(con2.`data_contrato_gerado`) = {$ano} 
						    AND MONTH(con2.data_contrato_gerado) = MONTH(con.data_contrato_gerado)
						  GROUP BY MONTH(con2.data_contrato_gerado)) AS captacao
						FROM
						  contratos con 
						  INNER JOIN veiculos v 
						    ON con.id_cliente = v.`id_cliente` 
						WHERE con.`observacoes_contrato` = 'ok' 
						  AND v.`seguro` = 's' 
						  AND YEAR(con.`data_contrato_gerado`) = {$ano}  
						GROUP BY label 
						ORDER BY label";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectValoresGraficos($id, $variavel, $ano, $vendedor, $dt_inicial, $dt_final, $comparativo = false, $interesse = null, $status = null) {
        $dt_inicial = !empty($dt_inicial) ? "AND captacao_data_criacao >= '{$dt_inicial} 00:00:00'" : "";
        $dt_final = !empty($dt_inicial) ? "AND captacao_data_criacao <='{$dt_final} 23:59:59'" : "";
        $vendedor = !empty($vendedor) ? "AND u.id = {$vendedor}" : "";
        $vendedor = $id == "vendedores" ? "AND u.nome = '{$variavel}'" : $vendedor;
        $comparativo = $comparativo ? "AND captacao_interesse = 5" : "";
        $interesse = !empty($interesse) ? "AND captacao_interesse = {$interesse}" : "";
        $status = !empty($status) ? "AND captacao_status = '{$status}'" : "";

        $filtro = "";
        switch ($id) {
            case "anual";
                $filtro = "AND YEAR(c.captacao_data_criacao) = {$variavel}";
                break;
            case "estados":
                $filtro = "AND e.estado_nome = '{$variavel}'";
                break;
            case "mensal":
                $filtro = "AND YEAR(captacao_data_criacao) = {$ano} AND MONTH(captacao_data_criacao) = {$variavel}";
                break;
            case "status":
                $filtro = "AND captacao_status = '{$variavel}'";
                break;
            case "interesses":
                $filtro = "AND captacao_niveis_interesses_desc = '{$variavel}'";
                break;
        }

        $this->_sql = "SELECT 
						  c.captacao_data_criacao as data,
						  c.captacao_cliente as cliente
						FROM
						  captacao c 
						  LEFT JOIN regiao r 
						    ON r.regiao_ddd LIKE SUBSTRING(
						      REPLACE(
						        REPLACE(c.captacao_telefone1, ')', ''),
						        '(',
						        ''
						      ),
						      1,
						      2
						    ) 
						  LEFT JOIN captacao_niveis_interesses cni ON c.captacao_interesse = captacao_niveis_interesses_id
						  LEFT JOIN estado e ON e.estado_id = r.regiao_estado_id
						  LEFT JOIN usuarios u 
						    ON c.captacao_id_usuario = u.`id`
    						WHERE c.captacao_id = captacao_id {$comparativo} {$filtro} {$dt_inicial} {$dt_final} {$vendedor} {$interesse} {$status}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    //NÍVES CAPTAÇÃO :
    public function insertNiveisCaptacaoUsuario($Dados) {
        $this->Create()->ExCreate("captacao_niveis_usuarios", $Dados);
        return $this->Create()->getResult();
    }

    public function insertNiveisCaptacao($Dados) {
        $this->Create()->ExCreate("captacao_niveis", $Dados);
        return $this->Create()->getResult();
    }

    public function deleteNivelCaptacao($id_usuario) {
        $this->Delete()->ExDelete("captacao_niveis_usuarios", "WHERE captacao_niveis_usuarios_id=:ID", "ID={$id_usuario}");
        return $this->Delete()->getResult();
    }

    public function selectCaptacaoNiveis() {
        $this->_sql = "SELECT cn.*, cnra.captacao_niveis_ra_desc FROM captacao_niveis cn
       					INNER JOIN captacao_niveis_ra cnra ON cn.captacao_niveis_ra = cnra.captacao_niveis_ra_id ORDER BY captacao_niveis_ra_id";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectCaptacaoNiveisRegras($nivel) {
        $nivel = !(empty($nivel)) ? "WHERE  captacao_niveis_regras_nivel = " . $nivel : "";
        $this->Read()->ExRead("captacao_niveis_regras", "{$nivel} ORDER by captacao_niveis_regras_operacao DESC", null);
        return $this->Read()->getResult();
    }

    //VERIFICA O TIPO DA CAPTACAO 
    public function selectCaptacaoInteresseNivel($interesse) {
        $this->_sql = "SELECT cn.captacao_niveis_ra FROM captacao_niveis cn 
        INNER JOIN captacao_niveis_interesses cni
        ON cn.captacao_niveis_id = cni.captacao_niveis_interesses_nivel
        WHERE cni.captacao_niveis_interesses_id = {$interesse}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function selecionarRaNivel($nivel) {
        $this->_sql = "SELECT captacao_niveis_ra  FROM captacao_niveis WHERE captacao_niveis_id = {$nivel}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectCaptacaoNiveisInteresses() {
        $this->_sql = "
		SELECT cni.*, cn.captacao_niveis_desc
		FROM captacao_niveis_interesses cni
		INNER JOIN captacao_niveis cn
		ON cni.captacao_niveis_interesses_nivel = cn.captacao_niveis_id
		ORDER BY cni.captacao_niveis_interesses_id";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function insertNivelCaptacaoInteresse($Dados) {
        $this->Create()->ExCreate("captacao_niveis_interesses", $Dados);
        return $this->Create()->getResult();
    }

    public function insertNivelCaptacaoRegra($Dados) {
        $this->Create()->ExCreate("captacao_niveis_regras", $Dados);
        return $this->Create()->getResult();
    }

    public function buscarNivelPorInteresse($contratoId) {
        $this->_sql = "SELECT cp.captacao_niveis_pc
        FROM captacao_niveis_interesses
        INNER JOIN captacao_niveis ON cp.captacao_niveis_id = captacao_niveis_interesses_nivel
        INNER JOIN captacao c ON captacao_niveis_interesses_id = c.captacao_interesses
        WHERE c.captacao_id = {$contratoId};";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function buscarRegraUsuario000($captacao_niveis_ra, $status_captacao) {
        $this->_sql = "SELECT 
        cnr.*,u.id,u.status_captacao,u.nome
        FROM
        captacao_niveis_usuarios AS cnu 
        LEFT JOIN usuarios u 
          ON cnu.`captacao_niveis_usuarios_id_usuario` = u.`id` 
        RIGHT JOIN captacao_niveis_regras cnr 
          ON cnu.`captacao_niveis_usuarios_regra_id` = cnr.`captacao_niveis_regras_id` 
        LEFT JOIN captacao_niveis cn 
          ON cnu.`captacao_niveis_usuarios_captacao_niveis_id` = cn.`captacao_niveis_id`
        LEFT JOIN permissaouser_usuarios AS pu 	   				ON u.id = pu.id_usuario
        LEFT JOIN permissaouser p 				    ON pu.`id_permissaouser` = p.`id_permissao` 
        WHERE 	 (pu.id_permissaouser = 8 ) AND u.ativo = 1	AND CN.captacao_niveis_ra = '$captacao_niveis_ra'AND u.status_captacao ='$status_captacao'

        ORDER BY u.id


";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function buscarRegraUsuario($id_usuario) {
        $this->_sql = "SELECT 
						  cnr.*,u.id
						FROM
						  captacao_niveis_usuarios AS cnu 
						  LEFT JOIN usuarios u 
						    ON cnu.`captacao_niveis_usuarios_id_usuario` = u.`id` 
						  RIGHT JOIN captacao_niveis_regras cnr 
						    ON cnu.`captacao_niveis_usuarios_regra_id` = cnr.`captacao_niveis_regras_id` 
						  LEFT JOIN captacao_niveis cn 
						    ON cnu.`captacao_niveis_usuarios_captacao_niveis_id` = cn.`captacao_niveis_id`
						   WHERE cnu.`captacao_niveis_usuarios_id_usuario` = {$id_usuario}";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function selectDescricaoNivel($id_nivel) {
        $this->_sql = "SELECT 
						  cnr.captacao_niveis_ra_desc 
						FROM
						  captacao_niveis cn 
						  INNER JOIN captacao_niveis_ra cnr 
						    ON cn.captacao_niveis_ra = cnr.captacao_niveis_ra_id
						WHERE captacao_niveis_id = {$id_nivel}";
        $this->Read()->FullRead($this->_sql);
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectDescricaoRegra($id_regra) {
        $this->Read()->ExRead("captacao_niveis_regras", "WHERE captacao_niveis_regras_id = {$id_regra}", null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectNivelUsuario($id_nivel) {
        $this->_sql = "SELECT cna.captacao_niveis_ra_desc, cnr.captacao_niveis_regras_desc, u.nome, u.id FROM captacao_niveis_usuarios cnu 
						INNER JOIN captacao_niveis cn ON cnu.captacao_niveis_usuarios_captacao_niveis_id = cn.captacao_niveis_id
						INNER JOIN usuarios u ON cnu.captacao_niveis_usuarios_id_usuario = u.id
						INNER JOIN captacao_niveis_ra cna ON cn.captacao_niveis_ra = cna.captacao_niveis_ra_id
						LEFT JOIN captacao_niveis_regras cnr ON cnu.captacao_niveis_usuarios_regra_id = cnr.captacao_niveis_regras_id
						WHERE cnu.captacao_niveis_usuarios_id = {$id_nivel}";
        $this->Read()->FullRead($this->_sql);
        return $this->limparArray($this->Read()->getResult());
    }

    /*
     * **********************************************
     * ********* MÉTOODS ATRIBUIR CAPTAÇÃO **********
     * **********************************************
     */

    public function selectFiltro($ddd) {
        $this->Read()->ExRead("ddds_usuario", "WHERE ddds_usuario_id_regiao = :idRegiao", "idRegiao={$ddd}");
        return $this->Read()->getResult();
    }

    public function selectFiltroDdds_usuario_status_fila($ddd, $status) {
        $this->Read()->ExRead("ddds_usuario", "WHERE   ddds_usuario_status_fila='$status'   AND  ddds_usuario_id_regiao = :idRegiao", "idRegiao={$ddd}");
        return $this->Read()->getResult();
    }

    public function buscaMenorIdTableFiltroDDDvendedor($filtro) {
        $this->_sql = "SELECT MIN(d.usuario_id) usuario_id FROM ddds_usuario d
	   	INNER JOIN usuarios  AS u 
			ON  u.id = d.ddds_usuario_id_usuario
	   	LEFT JOIN permissaouser_usuarios AS pu 
			ON u.id = pu.id_usuario
		LEFT JOIN permissaouser p 
			ON pu.`id_permissaouser` = p.`id_permissao` 
		LEFT JOIN grupos_permissao gp 
			ON pu.`id_permissao_grupo` = gp.`gp_id` 
		LEFT JOIN permissao_grupo pg 
			 ON gp.`gp_id` = pg.`permissao_grupo_grupo` 
		LEFT JOIN permissaouser ps 
			ON pg.`permissao_grupo_permissao` = ps.`id_permissao` 
	   	WHERE u.status_captacao = 'off' AND (pu.id_permissaouser = 8 OR ps.id_permissao)  AND u.ativo = 1 AND  d.ddds_usuario_id_regiao = {$filtro}";
        $this->Read()->FullRead($sql);
        return $this->limparArray($this->Read()->getResult())['usuario_id'];
    }

    /*
     * ****************************************************************
     * ********* ATUALIZA O STATUS DA CAPTACAO DA TABELA USUARIO
     * ****************************************************************
     */

    public function atualizarStatusCaptacao($id, $status) {

        $id = isset($id['id']) ? $id['id'] : $id;
        if ($id) {
            $this->Update()->ExUpdate("usuarios", array(
                'status_captacao' => "$status"
                    ), "WHERE  id =:id", "id={$id}");
        } else {
            $this->Update()->ExUpdate("usuarios", array(
                'status_captacao' => $status
                    ), "WHERE  status_captacao =:status_captacao", "status_captacao=on");
        }
        return $this->Update()->getResult();
    }

    // SELECIONA TODOS OS (IDS) DA TABELA -> filtro_ddd :
    private function selectIdsUsuarioTableFiltroDDDvendedor($dados) {
        $this->_sql = "SELECT d. r.regiao_ddd_id_usuario FROM  r.regiao_ddd AS d
			INNER JOIN usuarios AS U  ON d. r.regiao_ddd_usuario_id = U.id  
	   		WHERE d.ddds_usuario_id_regiao  =" . $dados ['filtro'] . " AND U.status_captacao = 'on'";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    // ATUALIZA SOMENTE OS USUARIOS DO FILTRO :
    public function atualizarUsuariosFiltroDDDvendedor($dados) {
        foreach ($this->selectIdsUsuarioTableFiltroDDDvendedor($dados) as $id) :
            // var_dump($dados,$id); die;
            $this->Update()->ExUpdate('usuarios', array(
                'status_captacao' => $dados ['status']
                    ), "WHERE id=:idU", "idU={$id['usuario_id']}");
        endforeach
        ;
        return $this->Update()->getResult();
    }

    /*
     * Seleciona o menor (ID) da Tabela usuarios de acordo com as seguintes Regras:
     * usuarios.status_captacao = 'off';
     * usuarios.ativo = 1;
     * permissaouser_usuario.id_permissaouser = 8;
     * captacao_niveis_usuarios.captacao_niveis_id = (1 à 5).
     */

    public function selectMenorIdUsuarioTableUsuario($nivelPermissao, $status, $ddd = '') {
        if ($nivelPermissao == '1') {
            $nivelPermissao = $this->get_regioes($ddd);
        }
        $this->_sql = "SELECT u.id FROM usuarios AS u
        LEFT JOIN permissaouser_usuarios AS pu 	   				ON u.id = pu.id_usuario
        LEFT JOIN permissaouser p 				    ON pu.`id_permissaouser` = p.`id_permissao` 
        LEFT JOIN captacao_niveis_usuarios AS CNU 	   			ON u.id = CNU.captacao_niveis_usuarios_id_usuario
        LEFT JOIN captacao_niveis AS CN 	   			ON CN.captacao_niveis_id = CNU.captacao_niveis_usuarios_captacao_niveis_id
        LEFT JOIN captacao_niveis_regras AS cnr	   				ON CNU.captacao_niveis_usuarios_regra_id = cnr.captacao_niveis_regras_id 
        WHERE u.status_captacao = '" . $status . "'	AND (pu.id_permissaouser = 8 ) AND u.ativo = 1	AND CN.captacao_niveis_ra = {$nivelPermissao}
        GROUP BY u.id
        ORDER BY u.id";

        $this->Read()->FullRead($this->_sql);

        $RR = $this->Read()->getResult();
        return $RR;
    }

    /* Novos metodos para cadastrar a captacao */
    /*
     * Seleciona o menor (ID) da Tabela filtro_ddd_vendedor de acordo com as seguintes regras:
     * filtro_ddd_vendedor.status_fila = 'off'
     * permissaouser_usuarios.permissaouser = 8;
     * usuarios.ativo = 1;
     * filtro_ddd_vendedor.filtro_ddd = {$filtro}
     */

    public function selectMenorIdUsuarioTableFiltroDDDvendedor($filtro, $status, $nivelPermissao) {
        $this->_sql = "SELECT u.id as usuario_id FROM usuarios u
			LEFT JOIN ddds_usuario AS d 
	   					ON  u.id = d.ddds_usuario_id_usuario
			LEFT JOIN permissaouser_usuarios AS pu 
	   					ON u.id = pu.id_usuario
			LEFT JOIN permissaouser p 
				    ON pu.`id_permissaouser` = p.`id_permissao` 
			LEFT JOIN grupos_permissao gp 
				    ON pu.`id_permissao_grupo` = gp.`gp_id` 
			LEFT JOIN permissao_grupo pg 
				    ON gp.`gp_id` = pg.`permissao_grupo_grupo` 
			LEFT JOIN permissaouser ps 
				    ON pg.`permissao_grupo_permissao` = ps.`id_permissao` 
			LEFT JOIN captacao_niveis_usuarios AS CNU 
	   					ON u.id = CNU.captacao_niveis_usuarios_id_usuario
			LEFT JOIN captacao_niveis AS CN 
	   					ON CN.captacao_niveis_id = CNU.captacao_niveis_usuarios_captacao_niveis_id
			WHERE IF(d.ddds_usuario_status_fila = '{$status}', d.ddds_usuario_id_regiao = {$filtro}, u.`status_captacao` = '{$status}') AND (pu.id_permissaouser = 8 OR ps.id_permissao = 8) AND u.ativo = 1 AND CN.captacao_niveis_ra = {$nivelPermissao} ORDER BY (d.`ddds_usuario_id_usuario` IS NOT NULL) DESC LIMIT 1";
        $this->Read()->FullRead($this->_sql);
        return$this->limparArray($this->Read()->getResult())['usuario_id'];
    }

    // ATUALIZA O STATUS DA CAPTACAO DA TABELA filtro_ddd_vendedor
    public function atualizarStatusTableFiltroDDDvendedor($id, $status, $filtro) {
        $this->Update()->ExUpdate("ddds_usuario", array(
            'ddds_usuario_status_fila' => $status
                ), "WHERE ddds_usuario_id_regiao =" . $filtro . " AND ddds_usuario_id_usuario =:idU", "idU={$id}");
        return $this->Update()->getResult();
    }

    public function atualizarStatusTableFiltroDDDvendedorTodos($ddds_usuario_status_fila, $ddds_usuario_id_regiao) {

        $ddds_usuario_id_regiao = (int) $ddds_usuario_id_regiao;
        $this->Update()->ExUpdate("ddds_usuario", array(
            'ddds_usuario_status_fila' => $ddds_usuario_status_fila
                ), "WHERE ddds_usuario_id_regiao =" . $ddds_usuario_id_regiao . " AND ddds_usuario_status_fila =:status_fila", "status_fila=on");
        var_dump($this->Update());
        return $this->Update()->getResult();
    }

    // SELECIONA TODOS OS (IDS) DA TABELA -> filtro_ddd :
    private function selectIdsUsuarioTableFiltroDDD($dados) {
        $this->_sql = "SELECT d.ddds_usuario_id_usuario FROM ddds_usuario AS d
			INNER JOIN usuarios AS U 
	   					ON d.ddds_usuario_id_usuario = U.id  
	   		WHERE d.ddds_usuario_id_regiao  =" . $dados ['filtro'] . " AND d.ddds_usuario_status_fila = 'on'";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    // ATUALIZA SOMENTE OS USUARIOS DO FILTRO :
    public function atualizarUsuariosFiltroDDD($dados) {
        foreach ($this->selectIdsUsuarioTableFiltroDDD($dados) as $id) :
            $this->Update()->ExUpdate('ddds_usuario', array(
                'ddds_usuario_status_fila' => $dados ['status']
                    ), "WHERE ddds_usuario_id_regiao = :idR", "idR={$dados['filtro']}");
        endforeach
        ;
        return $this->Update()->getResult();
    }

    // VERIFICA QUANTIDADE DE USUARIOS COM NIVEL
    public function verificarQtdVendedores($nivelPermissao) {
        $this->_sql = "SELECT 
				  COUNT(u.id) AS totalVendedores
				FROM
				  usuarios AS u 
				  LEFT JOIN permissaouser_usuarios AS pu 
				    ON u.id = pu.id_usuario 
				  LEFT JOIN permissaouser p 
				    ON pu.`id_permissaouser` = p.`id_permissao` 
				  LEFT JOIN grupos_permissao gp 
				    ON pu.`id_permissao_grupo` = gp.`gp_id` 
				  LEFT JOIN permissao_grupo pg 
				    ON gp.`gp_id` = pg.`permissao_grupo_grupo` 
				  LEFT JOIN permissaouser ps 
				    ON pg.`permissao_grupo_permissao` = ps.`id_permissao` 
				  INNER JOIN captacao_niveis_usuarios AS CNU 
				    ON u.id = CNU.captacao_niveis_usuarios_id_usuario 
				  INNER JOIN captacao_niveis AS CN 
				    ON CN.captacao_niveis_id = CNU.captacao_niveis_usuarios_captacao_niveis_id 
				  LEFT JOIN captacao_niveis_regras AS cnr 
				    ON CNU.captacao_niveis_usuarios_regra_id = cnr.captacao_niveis_regras_id 
				  WHERE (pu.id_permissaouser = 8 OR ps.`id_permissao` = 8) AND u.ativo = 1 AND CN.captacao_niveis_ra = {$nivelPermissao}";
        $this->Read()->FullRead($this->_sql);
        return $this->limparArray($this->Read()->getResult())['totalVendedores'];
    }

    public function totalEmail($id_proposta) {
        $this->_sql = "
		SELECT  COUNT(*)as total
		FROM captacao_emails
		WHERE   emails_id_proposta != 0
		AND emails_id_proposta = " . $id_proposta;
        $this->Read()->FullRead($this->_sql);
        return $this->limparArray($this->Read()->getResult());
    }

    public function insertCaptacaoEmail($dados) {
        $this->Create()->ExCreate("captacao_emails", $dados);
        return $this->Create()->getResult();
    }

    //ACIONAMENTO DE VIATURAS :
    public function insertViaturas($dados) {
        $this->Create()->ExCreate("viaturas", $dados);
        return $this->Create()->getResult();
    }

    public function selectViaturas($data, $limite = NULL) {
        $limite = !empty($limite) ? "LIMIT " . $limite : "";
        $this->_sql = "SELECT * FROM viaturas WHERE data LIKE '{$data}' ORDER by data, hora DESC {$limite}";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function selectViaturasAntigas($dados, $limite = NULL) {
        $limite = !empty($limite) ? "LIMIT " . $limite : "";
        $this->_sql = "SELECT * FROM viaturas WHERE MONTH(data) = '{$dados['month']}' ORDER BY 'data' DESC {$limite}";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function selectViaturasSelecionada($dados) {
        $this->_sql = "SELECT * FROM viaturas WHERE id_viaturas = '{$dados['id']}'";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function getSql() {
        return $this->_sql;
    }

    //VERIFIFA A FILA DE ACORDO COM O DDD
    public function get_regioes($ddd) {
        $_fila = 1;

        $_SP = ['14', '15', '16', '17', '18']; //São Paulo
        $_RJ = ['21', '22', '24']; //Rio de Janeiro
        $_ES = ['27', '28']; //Espírito Santo
        $_SC = ['47', '48', '49']; //Santa Catarina
        $_MG = ['31', '32', '33', '34', '34', '35', '37', '38']; //Minas Gerais
        $_PR = ['41', '42', '43', '44', '45', '46']; //Paraná
        $_RS = ['51', '52', '53', '54', '55']; //Rio Grande do Sul
        $_RS_PR_SC = ['41', '42', '43', '44', '45', '46', '51', '52', '53', '54', '55'];
        $_AC = ['68']; //Acre
        $_AL = ['82']; //Alagoas
        $_AP = ['96']; //Amapá
        $_AM = ['92', '97']; //Amazonas
        $_BS = ['73', '74', '75']; //Bahia
        $_CE = ['85', '88']; //Ceará
        $_GO = ['61', '62', '64']; //Goiás
        $_MA = ['98', '99']; //Maranhão
        $_MT = ['65', '66']; //Mato Grosso
        $_MS = ['67']; //Mato Grosso do Sul
        $_PA = ['91', '93', '94']; //Pará
        $_PB = ['83']; //Paraíba
        $_PE = ['81', '87']; //Pernambuco
        $_PI = ['86', '89']; //Piauí
        $_RN = ['84']; //Rio Grande do Norte
        $_RO = ['69']; //Rondônia
        $_RR = ['95']; //Roraima
        $_SE = ['79']; //Sergipe
        $_TO = ['63']; //Tocantins
        if (
                in_array($ddd, $_RS_PR_SC) ||
                in_array($ddd, $_AC) ||
                in_array($ddd, $_AL) ||
                in_array($ddd, $_RJ)
        ) {
            $_fila = 1;
        }
        return $_fila;
    }

    public function getByEmail($email) {
        $this->_sql = "SELECT * from captacao WHERE captacao_email='{$email}' order by captacao_id desc limit 0,1";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

}
