<?php
//namespace C:\www\gpi\modulos\captacao\src\models\classes\RelatorioCaptacao.class.php
final class RelatorioCaptacao extends Crud {

    private $_tabela = 'captacao';
    private $_sql;

    // BUSCA AS CAPTACOES POR FILTRO :
    public function consultar($data = array(), $limite = NULL) {
        $where = " WHERE 1=1 ";
        
        if (isset($limite)) {
            $limite = "limit {$limite}";
        }
        if (isset($data ["nome"]) && (trim($data ["nome"]) != "")) {
            $where .= " AND captacao_cliente LIKE '%" . $data ["nome"] . "%'";
        }
        
        if (isset($data ["servico"]) && (trim($data ["servico"]) != "")) {
            $where .= " AND (captacao_interesse = '" . $data ["servico"] . "' OR UPPER(captacao_niveis_interesses_desc) = UPPER('" . $data ["servico"] . "'))";
        }
        if (isset($data ["captacao_status"]) && (trim($data ["captacao_status"]) != "")) {
            $where .= " AND (captacao_status = '" . $data ["captacao_status"] . "' OR UPPER(captacao_status) = UPPER('" . $data ["captacao_status"] . "'))";
        }
        
        if (isset($data ["cidu"]) && ($data ["cidu"] != "0")) {
            $where .= " AND captacao_id_usuario = " . $data ["cidu"];
        }
        if (isset($data ["ddd"]) && (trim($data ["ddd"]) != "")) {
            $where .= " AND SUBSTRING(REPLACE(REPLACE(captacao_telefone1,')', '' ),'(', '' ),1,2) = " . $data ["ddd"];
        }

        $dataIni = isset($data ["dt_inicial"]) ? $data ["dt_inicial"] : "";
        $dataFim = isset($data ["dt_final"]) ? $data ["dt_final"] : "";

        if (($dataIni) && ($dataFim)) {
            $where .= " AND captacao_data_criacao >= '" . $dataIni . " 00:00:00' AND captacao_data_criacao <= '" . $dataFim . " 23:59:00'";
        } elseif ($dataIni) {
            $where .= " AND captacao_data_criacao >= '" . $dataIni . " 00:00:00 23:59:00'";
        } elseif ($dataFim) {
            $where .= " AND captacao_data_criacao <= '" . $dataFim . "' ";
        }

        $this->_sql = "SELECT
        origem,
        captacao_data_criacao,
        captacao_nivel_prioridade,
        captacao_cliente,
        captacao_cidade,
        captacao_uf,
        captacao_id_usuario,
        SUBSTRING(REPLACE(REPLACE(captacao_telefone1,')', '' ),'(', '' ),1,2)AS captacao_ddd,
        captacao_status, 
        captacao_indicador,
        motivo_finalizacao AS motivo,
        us.nome as usuarioCadastro, 
        IF(A.captacao_interesse>=1, cn.captacao_niveis_interesses_desc, A.captacao_interesse) as captacao_interesse,
        B.nome AS nome_consultor
        FROM " . $this->_tabela . " A 
        LEFT JOIN usuarios B ON B.id = A.captacao_id_usuario 
        LEFT JOIN usuarios us ON A.id_usuario = us.id 
        LEFT JOIN captacao_niveis_interesses CN ON A.captacao_interesse = cn.captacao_niveis_interesses_id
        " . $where . " 
        GROUP by captacao_id ORDER BY captacao_data_criacao DESC  {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

}
