<?php
//namespace C:\wamp\www\gpi\modulos\captacao\src\models\classes\Contratos.class.php  
final class Contratos extends Crud {
    private $_sql;
    private $_tabela = 'contratos';
    private $_limite;
    private $_Filtros;
    private $id;

    public function setLimit($limite) {
        $this->_limite = $limite;
    }

    public function getSQL() {
        return $this->_sql;
    }

    public function setId($id) {
        $this->id = (int) $id;
    }

    public function getId() {
        return $this->id;
    }

    public function insert($dados) {
        $this->Create()->ExCreate($this->_tabela, $dados);
        return $this->Create()->getResult();
    }

    public function updateContratos($dados) {
        $this->Update()->ExUpdate("contratos", $dados, "WHERE id_contrato = :id", "id={$dados['id_contrato']}");
        return $this->Update()->getResult();
    }

    public function deleteContrato($id_contrato) {
        $this->Delete()->ExDelete('contratos', "WHERE id_contrato=:id", "id={$id_contrato}");
        return $this->Delete()->getResult();
    }

    public function ListarContratosComFiltros($filtros = NULL) {

        $where = " WHERE c.id_contrato>0";
        $f = "";

        if (!empty($filtros)) {
            if (!empty($filtros['cliente']) && $filtros['cliente'] != -1)
                $f .= " AND  cli.cnpjcpf_cliente = '{$filtros['cliente']}'";

            else if (!empty($filtros['vendedor']) && $filtros['vendedor'] != -1)
                $f .= " AND  c.id_usuario = {$filtros['vendedor']}";

            if (!empty($filtros['filtro']) && $filtros['filtro'] != -1) {

                if ($filtros['filtro'] == "clienteBuscar")
                    $f .= " AND  cli.nome_cliente like '%{$filtros['campo']}%'";

                else if ($filtros['filtro'] == "vendedorBuscar")
                    $f .= " AND u.nome like '%{$filtros['campo']}%'";
            }
        }

        if (!empty($filtros) || $f != "")
            $where .= $f;

        $this->_Filtros = $where;
    }

    public function ListarContratos($status, $limite = NULL) {
        $limite = !empty($limite) ? " LIMIT {$limite}" : "";
        switch ($status) {
            case 1 : $status = "AND (cor_status != 'a_cor_cinza' OR status_contrato = 2) AND c.observacoes_contrato  = 'ok' AND cli.status_cadastro = 1";
                break;
            case 2 : $status = "AND cor_status = 'a_cor_cinza'";
                break;
            default: $status = "";
                break;
        }
        $this->_sql = "
        SELECT 
        c.*,u.nome as 'nome_usuario',
        cli.tipo_cadastro as tipo,
        cli.vigencia, 
        cli.nome_cliente,
        cli.form_origem,
        cli.ja_e_cliente,
        c.data_envio
        FROM {$this->_tabela} AS c
        INNER JOIN clientes as cli   ON c.id_cliente = cli.id_cliente
        INNER JOIN usuarios AS u     ON c.id_usuario = u.id
        {$this->_Filtros} {$status} GROUP BY c.id_contrato ORDER BY  c.cor_status DESC, c.data_envio DESC {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function getNomeClienteContrato($id) {
        $this->_sql = "
        SELECT cli.nome_cliente as 'cliente' 
        FROM {$this->_tabela} AS c 
        INNER JOIN clientes  AS cli  ON  c.id_cliente = cli.id_cliente 
        WHERE c.id_contrato = {$id}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult())['cliente'];
    }

    public function getContratoPdf($id) {
        $this->_sql = "
        SELECT 
        c.id_contrato,
        c.id_cliente as cliente_id,
        c.id_usuario,
        c.tipo_contrato,
        c.tipo_assinatura,
        c.data_contrato_gerado,
        cli.*,
        e.*
        FROM  {$this->_tabela} as c 
        INNER JOIN clientes as cli     ON c.id_cliente = cli.id_cliente
        LEFT JOIN endereco_cobranca e  ON c.id_cliente = e.id_cliente  
        WHERE  c.id_contrato = {$id}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function select($id_contato) {
        $this->Read()->ExRead($this->_tabela, " WHERE id_contrato = :id", "id={$id_contato}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function listarContratosUsuario($id_usuario, $limite = NULL) {
        $limite = !empty($limite) ? "LIMIT {$limite}" : "";
        $this->_sql = "
			SELECT c.*, con.observacoes_contrato, con.id_contrato
			FROM clientes as c 
			LEFT JOIN contratos con
				ON c.id_cliente = con.id_cliente
			INNER JOIN usuarios as u 
				ON c.id_usuario = u.id	
			WHERE IF(con.id_contrato IS NOT NULL, c.status_cadastro =2, c.cnpjcpf_cliente != '') AND c.id_status = 2 AND c.id_usuario = {$id_usuario} ORDER BY id_contrato DESC {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectAnexos($id_contrato) {
        $this->_sql = "
			SELECT C.*,A.* 
			FROM {$this->_tabela}  AS C
			RIGHT JOIN anexos AS A 
				ON C.id_contrato = A.id_contrato 
			WHERE A.id_contrato = {$id_contrato}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function getLogASC($id_contrato) {
        $this->Read()->ExRead("integracaoasc_log", "WHERE id_contrato = {$id_contrato}", null);
        return $this->Read()->getResult();
    }

    //busca dados do contrato
    public function selectPorCliente($id_cliente) {
        $this->Read()->ExRead("contratos", "WHERE id_cliente = {$id_cliente}", null);
        return $this->Read()->getResult();
    }

    public function exportarContratoCupomValido($dt_inicial, $dt_final) {
        $dt_inicial = Funcoes::FormatadataSql($dt_inicial) . ' 00:00:00';
        $dt_final = Funcoes::FormatadataSql($dt_final) . ' 00:00:00';
        if (!empty($dt_inicial) && $dt_final) {
            $and = " AND  cont.data_envio BETWEEN '{$dt_inicial}' AND  '{$dt_final}'  ";
        }
        $this->_sql = "
        SELECT
        cont.id_contrato     AS 'NUMERO_CONTRATO',
        cont.data_envio      AS 'DATA_ENVIO',
        cli.cupomDesconto    AS 'CUPOM',
        cont.status_contrato AS 'STATUS'
        FROM contratos AS cont
        INNER JOIN clientes AS cli
        ON cont.id_cliente = cli.id_cliente
        WHERE 
        cont.status_contrato = 3 AND cli.cupomDesconto <> '' {$and}
        ORDER BY cont.id_contrato DESC ";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function getTempoDeFinalizacao($dt_inicial, $dt_final) {
        $dt_inicial = Funcoes::FormatadataSql($dt_inicial) . ' 00:00:00';
        $dt_final = Funcoes::FormatadataSql($dt_final) . ' 23:59:00';
        if (!empty($dt_inicial) && $dt_final) {
            $and = " AND  contratos.data_finalizacao_contrato BETWEEN '{$dt_inicial}' AND  '{$dt_final}'  ";
        }
        $this->_sql = "
        SELECT 
        contratos.id_contrato AS 'NUMERO_CONTRATO',clientes.nome_cliente AS 'CLIENTE' ,
        DATE_FORMAT(data_contrato_gerado ,'%d-%m-%Y  %H:%i:%s')AS ' DATA_CONTRATO_GERADO' ,
        DATE_FORMAT(data_finalizacao_contrato ,'%d-%m-%Y  %H:%i:%s')AS ' DATA_CONTRATO_FINALIZADO' ,
        DATEDIFF(DATE_FORMAT(data_finalizacao_contrato ,'%Y-%m-%d'),DATE_FORMAT(data_contrato_gerado ,'%Y-%m-%d')) AS   'TOTAL_EM_DIA',
        TIMEDIFF(DATE_FORMAT(data_finalizacao_contrato,'%Y-%m-%d  %H:%i:%s'), DATE_FORMAT( data_contrato_gerado,'%Y-%m-%d  %H:%i:%s')) AS   'TOTAL_EM_HORAS'
        FROM contratos 
        INNER JOIN clientes ON  contratos.id_cliente = clientes.id_cliente   WHERE contratos.status_contrato = '3'   {$and}
        ORDER BY contratos.id_contrato DESC";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

}
