<?php

final class Proposta extends Crud {

    private $_tabela = 'proposta';
    private $_sql;

    public function insert($dados) {
        $this->Create()->ExCreate($this->_tabela, $dados);
        return $this->Create()->getResult();
    }

    public function updateProposta($dados) {
        $this->Update()->ExUpdate($this->_tabela, $dados, " WHERE proposta_id =:id", "id={$dados['proposta_id']}");
        return $this->Update()->getResult();
    }

    // BUSCA OS VEICULOS CADASTRADOS:
    public function selVeiculos($id) {
        $this->_sql = " SELECT  cpv.* FROM " . $this->_tabela . " as p
        INNER JOIN  captacao_propostaveiculo  AS  cpv
        ON p.proposta_id = cpv.cpv_id_proposta
        WHERE p.proposta_id = " . $id;
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    // BUSCA O VALOR TOTAL DA PROPOSTA:
    public function selectTotal($id) {
        $this->_sql = " SELECT sum(cpv_total_taxa_valor) as total FROM " . $this->_tabela . " AS p 
        INNER JOIN  captacao_propostaveiculo  AS  cpv 
        ON p.proposta_id = cpv.cpv_id_proposta
        WHERE p.proposta_id = " . $id;
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    // BUSCA O TIPO DA PROPOSTA EO EMAIL:
    public function selectProposta($id) {
        $this->_sql = "SELECT p.*,ce.email FROM " . $this->_tabela . " AS p
        LEFT JOIN  captacao_emails  AS  ce
        ON p.proposta_id = ce.emails_id_proposta
        WHERE p.proposta_id = " . $id;
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    // BUSCA O VALOR TOTAL DA TAXA DE INSTALACAO.
    public function selectTotalTInst($id) {
        $this->_sql = " SELECT SUM(cpv_total_taxa_intalacao) as 'totalTxInst' FROM " . $this->_tabela . " INNER JOIN captacao_propostaveiculo  ON proposta.proposta_id = captacao_propostaveiculo.cpv_id_proposta  WHERE cpv_id_proposta = " . $id;
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    // BUSCA O VALOR TOTAL DA  MENSALIDADE.
    public function selectTotalMensal($id) {
        $this->_sql = "
        SELECT sum(cpv_total_valor_mensal) as 'totalMensal'
        FROM " . $this->_tabela . "
        INNER JOIN captacao_propostaveiculo
        ON proposta.proposta_id = captacao_propostaveiculo.cpv_id_proposta
        WHERE cpv_id_proposta = " . $id;
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    // BUSCA O NOME DO CLIENTE :
    public function selCliente($id) {
        $this->_sql = " SELECT c.captacao_cliente AS cliente,c.captacao_telefone1 AS ddd,p.proposta_id_captacao AS id_captacao FROM " . $this->_tabela . " as p
        INNER JOIN captacao as c ON p.proposta_id_captacao = c.captacao_id 
        WHERE p.proposta_id =" . $id;
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    // PROPOSTA :
    public function selectPropostaVeiculoCaptacao($id_proposta) {
        $this->Read()->ExRead("captacao_propostaveiculo", "WHERE cpv_id_proposta = :id GROUP BY cpv_id", "id= {$id_proposta}");
        return $this->Read()->getResult();
    }

    public function somaVeiculos($id_captacao) {
        $this->_sql = "  SELECT SUM(cp.cpv_qtd_veiculo) AS 'QTDVEICULO'
        FROM proposta as P
        INNER JOIN captacao_propostaveiculo AS CP
        ON P.proposta_id = CP.cpv_id_proposta
        WHERE  P.proposta_id_captacao = {$id_captacao} ORDER BY CP.cpv_id DESC";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    /*
     * ***********************************************
     * ********* CAPTAÇÃO PROSPOSTA VEICULOS *********
     * ***********************************************
     */

    public function selectPlanoAssistencial($id_proposta) {
        $this->Read()->ExRead("captacao_propostaveiculo", "WHERE cpv_id_proposta = :id GROUP BY cpv_id_proposta", "id= {$id_proposta}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectPropostaVeiculo($id_cpv) {
        $this->Read()->ExRead("captacao_propostaveiculo", "WHERE cpv_id = :id", "id= {$id_cpv}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function insertCaptacaoPropostaVeiculos($Dados) {
        $this->Create()->ExCreate("captacao_propostaveiculo", $Dados);
        return $this->Create()->getResult();
    }

    public function updateCaptacaoPropostaVeiculos($Dados) {
        $this->Update()->ExUpdate("captacao_propostaveiculo", $Dados, "WHERE  cpv_id={$Dados['cpv_id']}", null);
        return $this->Update()->getResult();
    }

    public function deletarCaptacaoPropostaVeiculosId($id_cpv) {
        $this->Delete()->ExDelete("captacao_propostaveiculo", "WHERE cpv_id=:id", ":id={$id_cpv}");
        return $this->Delete()->getResult();
    }

    public function updateCaptacaoPropostaVeiculosIdProposta($Dados) {
        $id_proposta = $Dados['id_proposta'];
        unset($Dados['id_proposta']);
        $this->Update()->ExUpdate("captacao_propostaveiculo", $Dados, " WHERE cpv_id_proposta = {$id_proposta}", null);
        return $this->Update()->getResult();
    }
}