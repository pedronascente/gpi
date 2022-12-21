<?php
// namespace C:\wamp\www\gpi\application\models\classes\Clientes.class.php
final class Clientes extends Crud {

    private $_tabela = 'clientes';
    private $_sql;

    public function insert($tabela, $dados) {
        $this->Create()->ExCreate($tabela, $dados);
        return $this->Create()->getResult();
    }

    public function updateStatusCadastro($id, $status) {
        $this->Update()->ExUpdate("clientes", array(
            "status_cadastro" => $status
                ), "WHERE id_cliente= :id", "id={$id}");
        return $this->Update()->getResult();
    }

    // ATIVAR OU DESATIVAR CLIENTE.
    public function updateCliente($tabela, $dados) {
        $this->Update()->ExUpdate($tabela, $dados, "WHERE id_cliente= :id", "id={$dados['id_cliente']}");
        return $this->Update()->getResult();
    }

    public function updateContatoCliente($tabela, $dados) {

        for ($i = 0; $i <= 1; $i++) {
            $this->Update()->ExUpdate($tabela, $dados[$i], "WHERE id_cliente_contato=:id  AND ra_contato =:ra_contato", "id={$dados[$i]['id_cliente_contato']}", "ra_contato={$dados[$i]['ra_contato']}");
        }
        return $this->Update()->getResult();
    }

    public function deleteCliente($tabela, $id) {
        $this->Delete()->ExDelete($tabela, "WHERE id_cliente = :id", "id={$id}");
        return $this->Delete()->getResult();
    }

    public function deleteContratoClientes($id_cliente) {
        $this->Delete()->ExDelete("contratos", "WHERE cliente_ra = :id", "id={$id_cliente}");
        return $this->Delete()->getResult();
    }

    public function select($id_cliente) {
        $this->Read()->ExRead($this->_tabela, "WHERE id_cliente  = :id", "id={$id_cliente}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectClienteContrato($id_cliente) {
        $this->Read()->ExRead("clientes", "WHERE id_cliente  = :id", "id={$id_cliente}");
        return $this->limparArray($this->Read()->getResult());
    }

    // ATUALIZAÃ‡ÃƒO 09/07/2015
    public function selectComFiltros($dados) {
        $limite = isset($dados ['limite']) ? "LIMIT {$dados['limite']}" : "";
        $filtro = isset($dados ['selectFiltro']) ? $dados ['selectFiltro'] : "";
        $status = isset($dados ['status']) && !empty($dados['status']) ? "AND C.cliente_ativo = '{$dados['status']}'" : (empty($dados['selectFiltro'])) ? "AND cliente_ativo = 'on'" : "";
        $os = ($filtro == 'os' || !empty($dados['situacao_os'])) ? 'LEFT JOIN veiculos_os as o ON v.id_veiculo = o.veiculos_os_id_veiculo' : '';
        $equipamento = ($filtro == 'chip' || $filtro == 'modulo') ? 'LEFT JOIN veiculos_equipamentos ve ON v.id_veiculo = ve.veiculos_equipamentos_id_veiculo
        				LEFT JOIN chips chip ON ve.veiculos_equipamentos_id_chip = chip.chip_id
        					LEFT JOIN modulos m ON chip.chip_modulo = m.modulo_id' : '';
        $veiculos = ($filtro == 'placa' || $filtro == 'os' || $filtro == 'modulo' || $filtro == 'chip' || !empty($dados['situacao_os'])) ? 'LEFT JOIN veiculos AS V  ON C.id_cliente = V.cliente_ra' : '';
        $campoVeiculo = ($filtro == 'placa' || $filtro == 'os' || $filtro == 'chip' || $filtro == 'modulo') ? ',V.placa' : '';
        $campo_os = ($filtro == 'os') ? ", o.veiculos_os_id" : "";
        $this->_sql = "SELECT C.id_cliente, C.nome_cliente, C.cnpjcpf_cliente, C.id_cliente as id {$campoVeiculo} {$campo_os} FROM {$this->_tabela} AS C
    		{$veiculos} {$os} {$equipamento} 
		WHERE C.id_cliente = C.id_cliente AND (C.status_cadastro = 3 OR C.tipo_cadastro = 'interno') AND C.nome_cliente != ''
		";

        if (!empty($dados ['selectFiltro'])) {
            if ($dados ['selectFiltro'] == "Razao_Social") {
                $this->_sql .= " AND C.nome_cliente   LIKE '%" . $dados ['campo_pesquisa'] . "%'";
            } else if ($dados ['selectFiltro'] == "cpf_cnpj") {
                $this->_sql .= " AND C.cnpjcpf_cliente LIKE '%" . $dados ['campo_pesquisa'] . "%'";
            } else if ($dados ['selectFiltro'] == "placa") {
                $this->_sql .= " AND V.placa  LIKE '%" . $dados ['campo_pesquisa'] . "%'";
            } else if ($dados ['selectFiltro'] == "os") {
                $this->_sql .= " AND veiculos_os_id LIKE '%{$dados ['campo_pesquisa']}%'";
            } else if ($dados ['selectFiltro'] == "chip") {
                $this->_sql .= " AND chip_linha LIKE  '%{$dados ['campo_pesquisa']}%'";
            } else if ($dados ['selectFiltro'] == "modulo") {
                $this->_sql .= " AND modulo_serial LIKE  '%{$dados ['campo_pesquisa']}%'";
            } else if ($dados ['selectFiltro'] == "cidade") {
                $this->_sql .= " AND C.cidade_cliente LIKE  '%{$dados ['campo_pesquisa']}%'";
            } else if ($dados ['selectFiltro'] == "estado") {
                $this->_sql .= " AND C.uf_cliente LIKE  '%{$dados ['campo_pesquisa']}%'";
            }
        }
        $this->_sql .= "{$status} GROUP BY C.id_cliente ORDER BY nome_cliente {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function buscarCPF($cpf) {
        $this->Read()->ExRead($this->_tabela, "WHERE cnpjcpf_cliente  = '{$cpf}'", null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function ja_e_cliente($cpf) {
        if ($this->buscarCPF($cpf)) {
            return true;
        } else {
            return false;
        }
    }

    public function selectClienteUsuario($limite) {
        $limite = isset($limite) && !empty($limite) ? "LIMIT {$limite}" : "";

        $this->_sql = "
			SELECT 
			cli.id_cliente,  
			cli.cnpjcpf_cliente, 
			cli.tipo_cadastro,  
			cli.nome_cliente,
			cli.id_cliente as id_cliente_contrato,
			DATE(cli.data_solicitacao_cliente) AS data_solicitacao_cliente, 
			u.nome,  u.id, u.id_status 
			FROM {$this->_tabela} as cli 
			INNER JOIN usuarios as u 
				ON cli.id_usuario = u.id
			WHERE  cli.id_status = 1 ORDER BY cli.data_solicitacao_cliente DESC {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectClienteEnderecoCobranca($id_cliente, $id_cli = NULL) {
        $id_cli = !empty($id_cli) ? "AND cli.id_cliente = {$id_cli}" : "";
        $this->_sql = "
        SELECT  c.*, e.*,cli.tipo_cadastro as tipo, cli.status_cadastro as status, c.cod_municipio as cli_cod_municipio, e.cod_municipio as cod_municipio_cobranca, cli.id_cliente as id_contrato
        FROM {$this->_tabela} AS c  
        LEFT JOIN cliente_endereco_cobranca e  ON c.id_cliente = e.id_cliente
        LEFT JOIN clientes cli  ON c.id_cliente = cli.cliente_ra
        WHERE c.id_cliente ={$id_cliente} {$id_cli}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectClienteEnderecoCobrancaContrato($id_cliente) {
        $this->_sql = "
		
        SELECT  
        
        u.nome as vendedor, 
        c.*, 
        e.*, 
        con.id_contrato, 
        c.cod_municipio as cli_cod_municipio, 
        e.cod_municipio as cod_municipio_cobranca,  
        c.id_cliente as idCliente, 
        c.tipo_cadastro as tipo, 
        c.id_cliente as id_contrato
        
        FROM clientes AS c
        LEFT JOIN endereco_cobranca e	ON c.id_cliente = e.id_cliente
        LEFT JOIN contratos con   	ON c.id_cliente = con.id_cliente
        INNER JOIN usuarios u	        ON c.id_usuario = u.id
        WHERE c.id_cliente ={$id_cliente}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function consultaSerasa($dados) {
        $limite = isset($dados ['limite']) ? "LIMIT {$dados['limite']}" : "";
        $this->_sql = "
        SELECT 
        id_cliente,
        id_captacao,
        data_solicitacao_cliente AS data_solicitacao_cliente,
        nome_cliente,
        cnpjcpf_cliente,
        motivo_reprovacao_cliente ,
        tipo_cadastro,
        id_cliente as id_cliente_contrato,
        st.* 
        FROM {$this->_tabela}
        INNER JOIN status_avaliacao AS st  
          ON id_status = st.id_status_avaliacao
        WHERE id_usuario  = {$dados['id_usuario']} AND status_cadastro = 0
        ORDER BY data_solicitacao_cliente DESC {$limite}";
        $this->Read()->FullRead($this->_sql, null);

        return $this->Read()->getResult();
    }

    public function selectTodos($limite = NULL) {
        $limite = $limite != '' ? "LIMIT {$limite}" : "";
        $this->_sql = "SELECT * FROM clientes ORDER BY nome_cliente asc {$limite}";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function selectClienteComContratos() {
        $this->_sql = "
        SELECT id_cliente, nome_cliente, cnpjcpf_cliente FROM clientes
        WHERE status_cadastro = 1 GROUP BY id_cliente
        ORDER by nome_cliente";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function verificarCliente($cpf_cnpj) {
        $this->Read()->ExRead("clientes", "WHERE cnpjcpf_cliente = '{$cpf_cnpj}'", null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function verificarContratosClientes($id) {
        $this->Read()->ExRead("clientes", "WHERE cliente_ra = {$id}", null);
        return $this->Read()->getRowCount();
    }

    public function getNomeCliente($id_cliente) {
        $this->_sql = "SELECT nome_cliente FROM clientes WHERE id_cliente = {$id_cliente} ";
        $this->Read()->FullRead($this->_sql);
        $nome = !empty($this->limparArray($this->Read()->getResult())['nome_cliente']) ? $this->limparArray($this->Read()->getResult())['nome_cliente'] : "";
        return $nome;
    }

    public function gerarIndicesVendedores($dt_inicial, $dt_final) {
        $dt_inicial = !empty($dt_inicial) ? "AND data_contrato_gerado >= '{$dt_inicial} 00:00:00'" : "";
        $dt_final = !empty($dt_inicial) ? "AND data_contrato_gerado <= '{$dt_final} 23:59:59'" : "";
        $this->_sql = "SELECT 
        COUNT(v.id_veiculo) as value,
        u.nome as label 
        FROM
        contratos con 
        INNER JOIN usuarios u 
          ON con.`id_usuario` = u.`id`
        INNER JOIN veiculos v ON v.id_cliente = con.id_cliente
        WHERE con.`observacoes_contrato` = 'ok' 
        {$dt_final} {$dt_inicial}
        GROUP BY u.id ";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function gerarIndicesEstados($dt_inicial, $dt_final, $vendedor = NULL) {
        $dt_inicial = !empty($dt_inicial) ? "AND data_contrato_gerado >= '{$dt_inicial} 00:00:00'" : "";
        $dt_final = !empty($dt_inicial) ? "AND data_contrato_gerado <= '{$dt_final} 23:59:59'" : "";
        $vendedor = !empty($vendedor) ? "AND cli.id_usuario = {$vendedor}" : "";
        $this->_sql = "SELECT 
        COUNT(v.id_veiculo) AS value,
        cli.uf_cliente AS label 
        FROM
        contratos con 
        INNER JOIN clientes cli 
          ON con.id_cliente = cli.`id_cliente` 
        INNER JOIN veiculos v ON v.id_cliente =  con.id_cliente
        WHERE con.`observacoes_contrato` = 'ok' 
         AND cli.uf_cliente != '' {$dt_final} {$dt_inicial} {$vendedor}
        GROUP BY cli.uf_cliente";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function selectValoresGraficos($id, $variavel, $ano, $vendedor, $dt_inicial, $dt_final, $comparativo = false) {
        $dt_inicial = !empty($dt_inicial) ? "AND data_contrato_gerado >= '{$dt_inicial} 00:00:00'" : "";
        $dt_final = !empty($dt_inicial) ? "AND data_contrato_gerado <='{$dt_final} 23:59:59'" : "";
        $vendedor = !empty($vendedor) ? "AND u.id = {$vendedor}" : "";
        $vendedor = $id == "vendedores" ? "AND u.nome = '{$variavel}'" : $vendedor;
        $seguro = $id == "seguro" ? "AND v.seguro = 's'" : "";
        $groupby = $comparativo ? "GROUP BY c.id_contrato" : "GROUP BY v.id_veiculo";
        $join = $comparativo ? "LEFT" : "INNER";

        $filtro = "";
        switch ($id) {
            case "anual";
                $filtro = "AND YEAR(c.data_contrato_gerado) = {$variavel}";
                break;
            case "estados": $filtro = "AND cli.uf_cliente = '{$variavel}'";
                break;
            case "seguro":
            case "mensal":
                $filtro = "AND YEAR(data_contrato_gerado) = {$ano} AND MONTH(data_contrato_gerado) = {$variavel}";
                break;
        }

        $this->_sql = "SELECT cli.nome_cliente as cliente, c.data_contrato_gerado as data FROM contratos c
        LEFT JOIN clientes cli ON c.id_cliente = cli.id_cliente
        LEFT JOIN usuarios u ON c.id_usuario = u.id
        {$join} JOIN veiculos v ON cli.id_cliente = v.id_cliente
        WHERE  c.observacoes_contrato = 'ok' {$filtro} {$dt_inicial} {$dt_final} {$vendedor} {$seguro} {$groupby}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    //FUNCOES ENDERECO :
    public function insertEnderecoCobranca($tabela, $dados) {
        $this->Create()->ExCreate($tabela, $dados);
        return $this->Create()->getResult();
    }

    public function insertContatoCliente($tabela, $dados) {
        for ($i = 0; $i <= 1; $i++) {
            $this->Create()->ExCreate($tabela, $dados[$i]);
        }
        return $this->Create()->getResult();
    }

    public function updateEnderecoCobranca($tabela, $dados) {
        $this->Update()->ExUpdate($tabela, $dados, "WHERE id_cliente =:id", "id={$dados['id_cliente']}");
    }

    public function updateEndereco($tabela, $dados) {
        $sim_existe_endereco = $this->selectEnderecoCobranca($tabela, $dados[0]['id_cliente']);
        if ($sim_existe_endereco) {
            for ($i = 0; $i <= 1; $i++) {
                $this->Update()->ExUpdate($tabela, $dados[$i], "WHERE id_cliente =:id  AND  tipo_endereco=:tipo_endereco", "id={$dados[$i]['id_cliente']}", "tipo_endereco={$dados[$i]['tipo_endereco']}");
            }
        } else {
            for ($i = 0; $i <= 1; $i++) {
                $this->insertEnderecoCobranca($tabela, $dados[$i]);
            }
        }
    }

    public function deleteEnderecoCobranca($tabela, $id_cliente) {
        $this->Delete()->ExDelete($tabela, "WHERE id_cliente=:id", "id={$id_cliente}");
    }

    public function deleteContatoCliente($tabela, $id_cliente) {
        $this->Delete()->ExDelete($tabela, "WHERE id_cliente_contato=:id", "id={$id_cliente}");
    }

    public function selectEnderecoCobranca($tabela, $id) {
        $this->Read()->ExRead($tabela, "WHERE id_cliente = :id", "id={$id}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function selecContatoCliente($tabela, $id) {
        $this->Read()->ExRead($tabela, "WHERE id_cliente_contato = :id", "id={$id}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function getEnderecoByTipoEndereco($DATA_ARRAY) {
        $this->Read()->ExRead($DATA_ARRAY['tabela'], "WHERE id_cliente = {$DATA_ARRAY['id_cliente']} AND  tipo_endereco='" . $DATA_ARRAY['tipo_endereco'] . "'");
        return $this->limparArray($this->Read()->getResult());
    }

    public function getContatoByRaContato($DATA_ARRAY) {
        $this->Read()->ExRead($DATA_ARRAY['tabela'], "WHERE id_cliente_contato = {$DATA_ARRAY['id_cliente_contato']} AND  ra_contato='" . $DATA_ARRAY['ra_contato'] . "'");
        return $this->limparArray($this->Read()->getResult());
    }

    public function getSql() {
        return $this->_sql;
    }

    //FUNCOES LOGINS :

    public function selectLoginCliente($id_cliente, $limite = NULL) {
        $limite = !empty($limite) ? " LIMIT {$limite}" : "";
        $this->Read()->ExRead("clientes_logins", "WHERE id_cliente = {$id_cliente} ORDER by login_sistema ASC {$limite}", null);
        return $this->Read()->getResult();
    }

    public function insertLogin($dados) {
        $this->Create()->ExCreate("clientes_logins", $dados);
        return $this->Create()->getResult();
    }

    public function selectLogin($id_login) {
        $this->Read()->ExRead("clientes_logins", "WHERE id = {$id_login}", null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function updateLogin($dados) {
        $this->Update()->ExUpdate("clientes_logins", $dados, "WHERE id = {$dados['id']}", null);
        return $this->Update()->getResult();
    }

    public function deleteLogin($id_login) {
        $this->Delete()->ExDelete("clientes_logins", "WHERE id = {$id_login}", null);
        return $this->Delete()->getResult();
    }

    public function verificarLogin($id_cliente, $tipo_login) {
        $this->Read()->ExRead("clientes_logins", "WHERE id_cliente = {$id_cliente} AND tipo_sistema = {$tipo_login}", null);
        return $this->Read()->getRowCount();
    }

    //CAMPOS CONTRATO: 
    public function selectCamposContrato($nivel = null) {
        $nivel = !empty($nivel) ? "WHERE campos_contrato_nivel = {$nivel}" : "";
        $this->Read()->ExRead("campos_contrato", $nivel, null);
        return $this->Read()->getResult();
    }

    public function insertCamposContrato($dados) {
        $this->Create()->ExCreate("campos_contrato_repovado", $dados);
        return $this->Create()->getResult();
    }

    public function selectCamposContratoReprovado($id_cliente, $nivel = null, $veiculo = false) {
        $nivel = !empty($nivel) ? "AND cc.`campos_contrato_nivel` = {$nivel}" : "";
        $this->_sql = "SELECT cc.campos_contrato_name, cr.cr_veiculo   FROM	  campos_contrato_repovado cr   INNER JOIN campos_contrato cc  ON cr.cr_campo = cc.campos_contrato_id  WHERE cr.cr_cliente = {$id_cliente} {$nivel}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function deleteCamposContratoReprovados($id_cliente) {
        $this->Delete()->ExDelete("campos_contrato_repovado", "WHERE cr_cliente = {$id_cliente}", "");
        return $this->Delete()->getResult();
    }

}
