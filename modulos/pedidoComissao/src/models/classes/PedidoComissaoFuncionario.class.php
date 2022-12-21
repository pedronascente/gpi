<?php

class PedidoComissaoFuncionario extends Crud {

    private $_tabela = "pedido_comissao_funcionario";
    private $_setor;
    private $_pcf_nome;
    private $_pcf_matricula;
    private $_pcf_id;
    private $_pcf_ctps;
    private $_pcf_ano;
    private $_pcf_periodo;
    private $_pcf_motivo;
    private $_pcf_id_setor;
    private $_pcf_id_usuario;
    private $_pcf_id_supervisor;
    private $_pcf_id_empresa;
    private $_pcf_status;
    private $_pcf_arquivar;
    private $_pcf_planilha;
    private $_nomeFuncionario;
    private $_ctpsFuncionario;
    private $_matriculaFuncionario;
    private $_sql;
    private $_filtros = "";
    private $_pcf_reclamacao;
    private $_pcf_empresa;
    private $_planilha_comissoes_nome;

    public function get_setor() {
        return $this->_setor;
    }

    public function get_pcf_nome() {
        return $this->_pcf_nome;
    }

    public function get_pcf_matricula() {
        return $this->_pcf_matricula;
    }

    public function get_pcf_id() {
        return $this->_pcf_id;
    }

    public function get_pcf_ctps() {
        return $this->_pcf_ctps;
    }

    public function get_pcf_ano() {
        return $this->_pcf_ano;
    }

    public function get_pcf_periodo() {
        return $this->_pcf_periodo;
    }

    public function get_pcf_motivo() {
        return $this->_pcf_motivo;
    }

    public function get_pcf_id_setor() {
        return $this->_pcf_id_setor;
    }

    public function get_pcf_id_usuario() {
        return $this->_pcf_id_usuario;
    }

    public function get_pcf_id_supervisor() {
        return $this->_pcf_id_supervisor;
    }

    public function get_pcf_status() {
        return $this->_pcf_status;
    }

    public function get_pcf_DescStatus() {
        if ($this->get_pcf_status() == "1") {
            return 'Enviado';
        } else if ($this->get_pcf_status() == "2") {
            return 'Reprovado';
        } else {
            return 'Em Aberto';
        }
    }

    public function get_pcf_arquivar() {
        return $this->_pcf_arquivar;
    }

    public function get_pcf_planilha() {
        return $this->_pcf_planilha;
    }

    public function get_nomeFuncionario() {
        return $this->_nomeFuncionario;
    }

    public function get_ctpsFuncionario() {
        return $this->_ctpsFuncionario;
    }

    public function get_matriculaFuncionario() {
        return $this->_matriculaFuncionario;
    }

    public function get_planilha_comissoes_nome() {
        return $this->_planilha_comissoes_nome;
    }

    public function get_pcf_empresa() {
    
        return $this->_pcf_empresa;
    }

     public function get_pcf_id_empresa() {
    
        return $this->_pcf_id_empresa;
    }

    public function get_pcf_reclamacao() {
        return $this->_pcf_reclamacao;
    }

    /* sets */

    public function set_setor($_setor) {
        $this->_setor = $_setor;
    }

    public function set_pcf_nome($_pcf_nome) {
        $this->_pcf_nome = $_pcf_nome;
    }

    public function set_pcf_matricula($_pcf_matricula) {
        $this->_pcf_matricula = $_pcf_matricula;
    }

    public function set_pcf_id($_pcf_id) {
        $this->_pcf_id = $_pcf_id;
    }

    public function set_pcf_ctps($_pcf_ctps) {
        $this->_pcf_ctps = $_pcf_ctps;
    }

    public function set_pcf_ano($_pcf_ano) {
        $this->_pcf_ano = $_pcf_ano;
    }

    public function set_pcf_periodo($_pcf_periodo) {
        $this->_pcf_periodo = $_pcf_periodo;
    }

    public function set_pcf_motivo($_pcf_motivo) {
        $this->_pcf_motivo = $_pcf_motivo;
    }

    public function set_pcf_id_setor($_pcf_id_setor) {
        $this->_pcf_id_setor = $_pcf_id_setor;
    }

    public function set_pcf_id_usuario($_pcf_id_usuario) {
        $this->_pcf_id_usuario = $_pcf_id_usuario;
    }

    public function set_pcf_id_supervisor($_pcf_id_supervisor) {
        $this->_pcf_id_supervisor = $_pcf_id_supervisor;
    }

    public function set_pcf_status($_pcf_status) {
        $this->_pcf_status = $_pcf_status;
    }

    public function set_pcf_arquivar($_pcf_arquivar) {
        $this->_pcf_arquivar = $_pcf_arquivar;
    }

    public function set_pcf_planilha($_pcf_planilha) {
        $this->_pcf_planilha = $_pcf_planilha;
    }

    public function set_nomeFuncionario($_nomeFuncionario) {
        $this->_nomeFuncionario = $_nomeFuncionario;
    }

    public function set_ctpsFuncionario($_ctpsFuncionario) {
        $this->_ctpsFuncionario = $_ctpsFuncionario;
    }

    public function set_matriculaFuncionario($_matriculaFuncionario) {
        $this->_matriculaFuncionario = $_matriculaFuncionario;
    }

    public function set_planilha_comissoes_nome($_planilha_comissoes_nome) {
        $this->_planilha_comissoes_nome = $_planilha_comissoes_nome;
    }

    public function set_pcf_empresa($pcf_empresa) {
        return $this->_pcf_empresa = $pcf_empresa;
    }

     public function set_pcf_id_empresa($id_empresa) {
        return $this->_pcf_id_empresa = $id_empresa;
    }

    public function set_pcf_reclamacao($pcf_reclamacao) {
        return $this->_pcf_reclamacao = $pcf_reclamacao;
    }

    public function pegaNomePanilha() {
        if (strlen($this->get_pcf_planilha()) > 2) {
            $planilha = $this->get_pcf_planilha();
        } else {
            $planilha = $this->get_planilha_comissoes_nome();
        }
        return $planilha;
    }

    public function sets($dados) {
        //var_dump($dados);
        $this->set_setor(isset($dados['planilha']) ? $dados['planilha'] : \NULL);
        $this->set_pcf_nome(isset($dados['nomeFuncionario']) ? $dados['nomeFuncionario'] : \NULL);
        $this->set_pcf_matricula(isset($dados['matriculaFuncionario']) ? $dados['matriculaFuncionario'] : NULL);
        $this->set_pcf_id(isset($dados['pcf_id']) ? $dados['pcf_id'] : \NULL);
        $this->set_pcf_ctps(isset($dados['ctpsFuncionario']) ? $dados['ctpsFuncionario'] : \NULL);
        $this->set_pcf_ano(isset($dados['pcf_ano']) ? $dados['pcf_ano'] : \NULL);
        $this->set_pcf_periodo(isset($dados['pcf_periodo']) ? $dados['pcf_periodo'] : \NULL );
        $this->set_pcf_motivo(isset($dados['pcf_motivo']) ? $dados['pcf_motivo'] : \NULL);
        $this->set_pcf_id_setor(isset($dados['pcf_id_setor']) ? $dados['pcf_id_setor'] : \NULL);
        $this->set_pcf_id_usuario(isset($dados['pcf_id_usuario']) ? $dados['pcf_id_usuario'] : \NULL);
        $this->set_pcf_id_supervisor(isset($dados['pcf_id_supervisor']) ? $dados['pcf_id_supervisor'] : NULL);
        $this->set_pcf_status(isset($dados['pcf_status']) ? $dados['pcf_status'] : \NULL);
        $this->set_pcf_arquivar(isset($dados['pcf_arquivar']) ? $dados['pcf_arquivar'] : \NULL);
        $this->set_pcf_planilha(isset($dados['pcf_planilha']) ? $dados['pcf_planilha'] : \NULL);
        $this->set_nomeFuncionario(isset($dados['nomeFuncionario']) ? $dados['nomeFuncionario'] : \NULL);
        $this->set_ctpsFuncionario(isset($dados['ctpsFuncionario']) ? $dados['ctpsFuncionario'] : \NULL );
        $this->set_matriculaFuncionario(isset($dados['matriculaFuncionario']) ? $dados['matriculaFuncionario'] : \NULL);
        $this->set_planilha_comissoes_nome(isset($dados['planilha']) ? $dados['planilha'] : \NULL);
        $this->set_pcf_empresa(isset($dados['pcf_empresa']) ? $dados['pcf_empresa'] : NULL);
        $this->set_pcf_id_empresa(isset($dados['id_empresa']) ? $dados['id_empresa'] : NULL);

        $this->set_pcf_reclamacao(isset($dados['pcf_reclamacao']) ? $dados['pcf_reclamacao'] : NULL);
    }

    public function insert($dados) {
        $this->Create()->ExCreate($this->_tabela, $dados);
        return $this->Create()->getResult();
    }

    public function liberarPlanilha($id) {
        $this->Update()->ExUpdate($this->_tabela, array("pcf_status" => 1), "WHERE pcf_id= :id", "id={$id}");
        return $this->Update()->getResult();
    }

    public function arquivarDados($id) {
        $this->Update()->ExUpdate($this->_tabela, array("pcf_arquivar" => "1"), "WHERE pcf_id= :id", "id={$id}");
        return $this->Update()->getResult();
    }

    public function atualizarDados($dados = null) {
        $this->Update()->ExUpdate($this->_tabela, $dados, "WHERE pcf_id= :id", "id={$dados['pcf_id']}");
        return $this->Update()->getResult();
    }

    public function reprovaPlanilha($id, $motivo) {
        $this->Update()->ExUpdate($this->_tabela, array("pcf_status" => "2", "pcf_motivo" => $motivo), "WHERE pcf_id= :id", "id={$id}");
        return $this->Update()->getResult();
    }

    public function deletePedidoComissaoFuncionario($id) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE pcf_id = {$id}", null);
        return $this->Delete()->getResult();
    }

    public function selectUltimoId() {
        return $this->Create()->getResult();
    }

    public function select($dados) {
        $limite = isset($dados ['limite']) ? " LIMIT {$dados['limite']}" : "";
        $this->_sql = "SELECT pcf.*, 
        IF(pcf.pcf_ctps !='' OR pcf_ctps IS NOT NULL, pcf.pcf_ctps, u.ctps) as ctpsFuncionario,
        IF(pcf.pcf_matricula !='' OR pcf_matricula IS NOT NULL, pcf.pcf_matricula, u.matricula) as matriculaFuncionario,
        IF(pcf.pcf_planilha >=1, p.planilha_comissoes_nome, pcf.pcf_planilha) as planilha,
        IF( pcf_nome IS NULL OR pcf_nome = '', u.nome, pcf_nome) as nomeFuncionario
        FROM {$this->_tabela} as pcf
        LEFT JOIN planilha_comissoes p ON pcf.pcf_planilha = planilha_comissoes_id
        LEFT JOIN usuarios u ON pcf_id_usuario = u.id
        WHERE pcf_id_supervisor = {$dados['pcf_id_supervisor']} {$this->_filtros}   group by pcf_id  ORDER BY pcf_status =  1, pcf_status ASC, pcf_ano DESC {$limite}";

        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    //Atualização Insconsistência
    public function selectPCF($pcf_id) {
        $this->_sql = "SELECT pcf.*, 
        IF(pcf.pcf_ctps !='' OR pcf_ctps IS NOT NULL, pcf.pcf_ctps, u.ctps) as ctpsFuncionario,
        IF(pcf.pcf_matricula !='' OR pcf_matricula IS NOT NULL, pcf.pcf_matricula, u.matricula) as matriculaFuncionario,
        IF(pcf.pcf_planilha >=1, p.planilha_comissoes_nome, pcf.pcf_planilha) as planilha,
        IF( pcf_nome IS NULL OR pcf_nome = '', u.nome, pcf_nome) as nomeFuncionario				
        FROM {$this->_tabela} as pcf
        LEFT JOIN planilha_comissoes p ON pcf.pcf_planilha = planilha_comissoes_id
        LEFT JOIN usuarios u ON pcf_id_usuario = u.id
        WHERE pcf_id = {$pcf_id}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    //Atualização Insconsistência
    public function selectTodos($limite = '') {
        $limite = isset($limite) && !empty($limite) ? "LIMIT {$limite}" : "";
        $this->_sql = "
        SELECT pcf.*,s.setor_local,  u.id_empresa,
        IF(pcf.pcf_planilha >=1, p.planilha_comissoes_nome, pcf.pcf_planilha) as planilha,
        IF(pcf_nome IS NULL OR pcf_nome = '', u.nome, pcf_nome) as nomeFuncionario
        FROM {$this->_tabela} AS pcf 
        INNER JOIN setor AS s ON pcf.pcf_id_setor = s.setor_id
        LEFT JOIN planilha_comissoes p ON pcf.pcf_planilha = p.planilha_comissoes_id
        LEFT JOIN usuarios u ON pcf.pcf_id_usuario = u.id
        WHERE pcf.pcf_status=1 and  pcf.pcf_arquivar=0 {$this->_filtros}    group by pcf.pcf_id ORDER BY pcf.pcf_id DESC {$limite}";

        return $this->Read()->FullRead($this->_sql, null);
    }

    public function selectTodosArquivados($limite = NULL) {
        $limite = (!empty($limite)) ? ' LIMIT  ' . $limite : "LIMIT 500";
        $this->_sql = "SELECT 
        pcf.*,s.setor_local,
        IF(pcf.pcf_planilha >=1, p.planilha_comissoes_nome, pcf.pcf_planilha) as planilha, 
        IF(pcf_nome = '', u.nome, pcf_nome) as nomeFuncionario,
        u.nome 
        FROM {$this->_tabela} AS pcf
        INNER JOIN setor AS s ON pcf.pcf_id_setor = s.setor_id
        LEFT JOIN usuarios u ON pcf_id_usuario = u.id
        LEFT JOIN planilha_comissoes p ON pcf.pcf_planilha = p.planilha_comissoes_id
        WHERE pcf.pcf_status=1 and pcf.pcf_arquivar=1 {$this->_filtros} group by pcf.pcf_id  ORDER BY pcf.pcf_id DESC {$limite}";

        return $this->Read()->FullRead($this->_sql, null);
    }

    public function selectComFiltro($busca) {
        $this->_filtros = $this->filtrar($this->_campos, $busca);
    }

    public function selectAllComissao() {
        $this->_sql = "SELECT pedido_comissao_id_usuario, SUM(pedido_comissao_comissao1) AS total_comissao, SUM(pedido_comissao_desc_comissao) AS total_desc_comissao  FROM pedido_comissao GROUP BY pedido_comissao_id_usuario";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selDadoFuncionario($id_pcf) {
        $this->_sql = " SELECT  pcf.*,
        		IF (pcf_planilha >=1, planilha_comissoes_nome, pcf_planilha) as planilha, 
        		IF (pcf_nome IS NULL OR pcf_nome = '',u.nome, pcf_nome) as nomeFuncionario,
        		IF (pcf_ctps IS NULL OR pcf_ctps = '',u.ctps, pcf_ctps) as ctpsFuncionario,u.id_empresa,
        		IF (pcf_matricula IS NULL OR pcf_matricula = '',u.matricula  , pcf_matricula) as matriculaFuncionario
        		FROM " . $this->_tabela . " AS pcf 
			 LEFT JOIN planilha_comissoes pc ON pcf.pcf_planilha = pc.planilha_comissoes_id
			 LEFT JOIN usuarios u  ON pcf.pcf_id_usuario = u.id
			 WHERE  pcf.pcf_id = " . $id_pcf . " ORDER BY pcf.pcf_id desc";
        $this->Read()->FullRead($this->_sql, null);
        $this->sets($this->limparArray($this->Read()->getResult()));
    }

    public function buscarPorPeriodo($id_usuario, $periodo, $planilha) {
        $this->Read()->ExRead($this->_tabela, "WHERE pcf_periodo = '{$periodo}' AND pcf_id_usuario = {$id_usuario} AND pcf_planilha = {$planilha} AND pcf_Arquivar != 1 AND pcf_status != 1", null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function somarDescontos($id_pcf) {
        $this->_sql = "SELECT 
        SUM(p.desconto) AS desconto 
        FROM
        (SELECT 
          p.pedido_comissao_desc_comissao AS desconto 
        FROM
          pedido_comissao_funcionario AS pcf 
          INNER JOIN pedido_comissao AS p 
            ON pcf.pcf_id = p.pedido_comissao_id_usuario 
          LEFT JOIN inconsistencias i 
            ON p.pedido_comissao_id = i.comissao_id 
        WHERE pedido_comissao_id_usuario = {$id_pcf} 
          AND (
            (
              i.situacao <> 3 
              AND i.situacao IS NOT NULL
            ) 
            OR i.situacao IS NULL
          ) 
        GROUP BY pedido_comissao_id) AS p";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult())['desconto'];
    }

    public function somarComissoes($id_pcf) {
        $this->_sql = "SELECT 
						  SUM(p.comissao) as comissao
						FROM
						  (SELECT 
						    p.pedido_comissao_comissao1 AS comissao 
						  FROM
						    pedido_comissao_funcionario AS pcf 
						    INNER JOIN pedido_comissao AS p 
						      ON pcf.pcf_id = p.pedido_comissao_id_usuario 
						    LEFT JOIN inconsistencias i 
						      ON p.pedido_comissao_id = i.comissao_id 
						  WHERE pedido_comissao_id_usuario = {$id_pcf} 
						    AND (
						      (
						        i.situacao <> 3 
						        AND i.situacao IS NOT NULL
						      ) 
						      OR i.situacao IS NULL
						    ) 
						  GROUP BY pedido_comissao_id) AS p";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult())['comissao'];
    }

    public function verificaInconsistenciaPlanilha($id) {
        $this->_sql = "SELECT i.* from pedido_comissao p
        INNER JOIN inconsistencias i ON p.pedido_comissao_id = i.comissao_id
        INNER JOIN pedido_comissao_funcionario pcf ON p.pedido_comissao_id_usuario = pcf.pcf_id
        WHERE pcf_id ={$id}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectPlanilha($id) {
        $this->Read()->ExRead($this->_tabela, "WHERE pcf_id = {$id}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function setFiltros($busca) {
        $campos = array("pcf_nome", "pcf_periodo", "pcf_ano", "pcf_planilha", "nome", "planilha_comissoes_nome",);
        $this->_filtros = $this->filtrar($campos, $busca);
    }

    public function desarquivarPlanilha($dados) {
        $this->Update()->ExUpdate($this->_tabela, $dados, "WHERE pcf_id= :id", "id={$dados['pcf_id']}");
        return $this->Update()->getResult();
    }

    public function atualizarEmpresa($dados) {
         $id =  $dados['id'];
         unset($dados['id']);
        $this->Update()->ExUpdate($this->_tabela, $dados, "WHERE pcf_id= :id", "id={$id}");
        return $this->Update()->getResult();
    }

}