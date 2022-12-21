<?php

include_once("ManipulaData.class.php");

final class IntegracaoAsc extends ManipulaData {

    private $id_contratogpi;
    private $log_erro = NULL;
    private $razao_social;
    private $inscricao;
    private $rg;
    private $observacao;

    # METODO QUE RETORNA OS DADOS DO CLIENTE E DO CONTRATO  

    public function getCliente($id) {
        $sql = "SELECT *, SUBSTRING(data_contrato_gerado,1,4) AS ano_contrato_gerado , SUBSTRING(data_contrato_gerado,6,2) AS mes_contrato_gerado, SUBSTRING(data_contrato_gerado,9,2) AS dia_contrato_gerado FROM contratos A 
				INNER JOIN clientes B ON A.id_cliente = B.id_cliente 
				LEFT JOIN usuarios C ON A.id_usuario  = c.id
				WHERE id_contrato = " . $id;
        return parent::listQr(parent::execSQL($sql));
    }

    # METODO QUE RETORNA OS DADOS DO VEICULO

    public function getVeiculos($idCliente) {
        $sql = "
			SELECT A.id_veiculo, A.marca,A.ano,A.modelo,A.placa,A.cor,A.taxa_monitoramento, A.taxa_instalacao
			FROM 
			VEICULOS A
			INNER JOIN clientes B ON A.id_cliente = B.id_cliente
			INNER JOIN usuarios C ON B.id_usuario = C.id
			WHERE A.id_cliente = " . $idCliente . "
			AND id_veiculo NOT IN(SELECT id_tabela  FROM integracaoasc_controle WHERE nome_tabela = 'veiculos')";
        $ret = parent::execSQL($sql);
        $res = null;
        while ($row = parent::listQr($ret)) {
            $res[] = $row;
        }
        return $res;
    }

    # METODO QUE RETORNA OS DADOS ENDEREÃ‡O DE COBRANÃ‡A  

    public function getEndCobranca($id) {
        $sql = "SELECT * FROM endereco_cobranca WHERE id_cliente = " . $id;
        return parent::listQr(parent::execSQL($sql));
    }

    # METODO QUE RETORNA COD VENDEDOR ASC  

    public function getCodVendedorAsc($id) {
        $sql = "SELECT id_representante_asc FROM usuarios WHERE id = " . $id;
        return parent::listQr(parent::execSQL($sql));
    }

    # METODO DE GRAVAR NO BANCO DA GPI  

    public function gravar($table, $dados, $nomeBase = NULL) {
    	$cols = implode(',', array_keys($dados));
    	$values = implode(',', array_values($dados));
        $sql = " INSERT INTO " . $table . "($cols)values($values)";
        if (!$nomeBase) { # BASE GPI
            //print $sql;
            $rturn = parent::execSQL($sql);
        } else {#BASE ASC
            //print $sql;
            $res = odbc_exec($nomeBase, $sql);
            if (odbc_error()) {
                $errosql = odbc_errormsg($nomeBase);
                if (!stristr($errosql, "no cursor")) {
                    $rturn['instr_sql'] = $sql;
                    $rturn['status'] = 'erro';
                    $rturn['msg'] = $errosql;
                }
            } else {
                $rturn['status'] = 'ok';
            }
        }
        return $rturn;
    }

    # METODO QUE RETORNA ULTIMO ID INSERIDO  

    public function getUltimoId() {
        return mysql_insert_id();
    }

    #METODO DE ATUALIZAR TABELAS

    public function atualizar($tabela, $dados, $condicao, $nomeBase = NULL) {
        $sql = "UPDATE " . $tabela . " SET ";
        $separador = null;
        $separador2 = null;
        foreach ($dados as $campo => $valor) {
            $sql .= $separador . $campo . " = " . $valor;
            $separador = ", ";
        }
        $sql .= " WHERE ";
        foreach ($condicao as $campo => $valor) {
            $sql .= $separador2 . $campo . " = " . $valor;
            $separador2 = " AND ";
        }
        $res = odbc_exec($nomeBase, $sql);
    }

    #METODO DE ATUALIZAAR TABELAS

    public function excluir($tabela, array $condicao) {
        $sql = "DELETE FROM " . $tabela;
        $where = " WHERE ";

        foreach ($condicao as $campo => $valor) {
            $sql .= $where . $campo . " = " . $valor;
            $where = " AND ";
        }
        $retorno = parent::execSQL($sql);
        return $retorno;
    }

    #RETORNA ARRAY DE ERROS OU AVISOS

    public function getLogErro() {
        return $this->log_erro;
    }

    #CONSULTA CLIENTE ASC

    public function getClienteAsc($conn, $gpiCnpjcpf_cliente) {
        $tsql = "SELECT CLIENTE_ID,COBRANCA_ID,OBSERVACAO,REPRESENTANTE_ID,ATIVIDADE_ID,BANCO_ID,OBSERVACOES_COMPLEMENTO FROM CLIENTE WHERE CGCCPF = " . $gpiCnpjcpf_cliente;
        $result = odbc_exec($conn, $tsql);
        $ret = odbc_fetch_row($result);
        //SE CLIENTE JA EXISTE
        if ($ret) {
            $arrRet['cliente_id'] = odbc_result($result, 'CLIENTE_ID');
            $arrRet['obs'] = odbc_result($result, 'OBSERVACAO');
            $arrRet['representante'] = odbc_result($result, 'REPRESENTANTE_ID');
            $arrRet['obs_complemento'] = odbc_result($result, 'OBSERVACOES_COMPLEMENTO');
            $arrRet['cobranca_id'] = odbc_result($result, 'COBRANCA_ID');
            $arrRet['atividade_id'] = odbc_result($result, 'ATIVIDADE_ID');
            $arrRet['banco_id'] = odbc_result($result, 'BANCO_ID');
            return $arrRet;
        } else {
            return false;
        }
    }

    #CONSULTA ULTIMO ID ASC

    public function getMaxIdAsc($conn, $tbl, $campo, $arrWhere = NULL) {
        $where = "";
        if ($arrWhere) {
            $where = NULL;
            foreach ($arrWhere as $i => $valor) {
                $where .= (!$where) ? " WHERE " . $i . " = " . $valor : " AND " . $i . " = " . $valor;
            }
        }
        $tsql = "SELECT MAX(" . $campo . ") AS ID FROM " . $tbl . $where;
        //die($tsql);
        $result = odbc_exec($conn, $tsql);
        return odbc_result($result, 1);
    }

}
