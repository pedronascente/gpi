<?php

final class Usuarios extends Crud {

    private $_ultimoId;
    private $_usuario;
    private $_senha;
    private $_tabela = "usuarios";
    private $_sql;
    private $_fileTmp_name;
    private $_DadosUsuario = array();
    private $_filtros = "";

    public function setId_permissao($id) {
        $this->id_permissao = $id;
    }

    public function setId_administrativo($id_administrativo) {
        $this->id_administrativo = $id_administrativo;
    }

    public function setUsuario($usuario) {
        $this->_usuario = $usuario;
    }

    public function getUsuario() {
        return $this->_usuario;
    }

    public function setSenha($senha) {
        $this->_senha = $senha;
    }

    public function getSenha() {
        return $this->_senha;
    }

    public function getId_permissao() {
        return $this->id_permissao;
    }

    public function getUltimoId() {
        return $this->_ultimoId;
    }

    public function trataDados($Dados) {
        if (isset($Dados [1] ['assinatura']) && $Dados [1] ['assinatura'] != '') {
            $this->_fileTmp_name = $Dados [1] ['assinatura'] ['tmp_name'];
            unset($Dados [1]);
        }

        if (isset($Dados[0]['senha']) && $Dados [0] ['senha'] != "")
            $Dados [0] ['senha'] = md5($Dados [0] ['senha']);
        else
            unset($Dados[0]['senha']);

        unset($Dados [0]['ddd']);
        unset($Dados [0]['todos']);
        $Dados [0]['id_empresa'] = (int) $Dados [0]['id_empresa'];

        $this->_DadosUsuario = $Dados;
    }

    public function selectUsuarioLogin() {
        $this->Read()->ExRead($this->_tabela, "WHERE usuario=:usuario AND senha = :senha", "usuario={$this->_usuario}&senha={$this->_senha}");
        return $this->limparArray($this->Read()->getResult());
    }

    // insert usuarios na table:
    public function insert() {
        $this->Create()->ExCreate($this->_tabela, $this->_DadosUsuario [0]);
        return $this->Create()->getResult();
    }

    public function selectUsuario($usuario) {
        $this->Read()->ExRead($this->_tabela, "WHERE usuario = '{$usuario}'");
        return $this->limparArray($this->Read()->getResult());
    }

    // atualiza o valor do tempo de retorno das consultas :
    public function updateTempoUsuario($dados = array()) {
        $this->Update()->ExUpdate($this->_tabela, $dados, "WHERE id = {$dados['id']}", null);
        return $this->Update()->getResult();
    }

    // seleciona um usuario.
    public function selUsuario($id) {
        $this->_sql = "SELECT u.*, s.setor_local, r.ramal_ramal,r.ramal_id_usuario
        FROM " . $this->_tabela . " as u
        left JOIN setor s ON u.id_setor = s.setor_id
        left JOIN ramal r ON   u.id = r.ramal_id_usuario
        WHERE u.id=" . $id;

        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function findUserById($id) {
        $this->_sql = "SELECT u.*, s.setor_local
        FROM " . $this->_tabela . " as u
        left JOIN setor s ON u.id_setor = s.setor_id
        WHERE u.id=" . $id;

        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function updateUser() {
        if (isset($this->_DadosUsuario[0]['ativo']) || isset($this->_DadosUsuario[0]['id_cargo']) || isset($this->_DadosUsuario[0]['id_setor'])) {
            $this->_DadosUsuario[0]['ativo'] = (int) $this->_DadosUsuario[0]['ativo'];
            $this->_DadosUsuario[0]['id_cargo'] = (int) $this->_DadosUsuario[0]['id_cargo'];
            $this->_DadosUsuario[0]['id_setor'] = (int) $this->_DadosUsuario[0]['id_setor'];
        }
        $this->_DadosUsuario[0]['id'] = (int) $this->_DadosUsuario[0]['id'];
        $this->Update()->ExUpdate($this->_tabela, $this->_DadosUsuario [0], "WHERE id= :id", "id={$this->_DadosUsuario[0]['id']}");
        return $this->Update()->getResult();
    }

    public function validarUsuario($nome) {
        $this->Read()->ExRead($this->_tabela, "WHERE usuario = '{$nome}'", null);
        return $this->Read()->getRowCount();
    }

    public function selecionarTodos($limite, $orderbynome, $ativo = null) {
        $ativo = !empty($ativo) ? "AND u.ativo = {$ativo}" : "";
        $limite = !empty($limite) ? "LIMIT " . $limite : "";
        $orderby = $orderbynome ? "usuario ASC" : "id DESC";
        $this->_sql = "SELECT u.*, s.setor_local, c.cargo_descricao
		FROM " . $this->_tabela . " as u
		LEFT JOIN setor s ON u.id_setor = s.setor_id
		LEFT JOIN cargos c ON u.id_cargo = c.cargo_id
		WHERE u.id = u.id {$this->_filtros} {$ativo}
		ORDER BY {$orderby} {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selecionarAtivos() {
        $this->Read()->FullRead("SELECT  u.id, u.usuario ,u.nome  FROM usuarios  AS u  WHERE u.ativo =1 order by u.usuario asc");
        return $this->Read()->getResult();
    }

    public function getSql() {
        return $this->_sql;
    }

    public function updateUsuario($Dados) {
        $this->Update()->ExUpdate("usuarios", $Dados, "WHERE id = {$Dados['id']}", null);
        return $this->Update()->getResult();
    }

    //PERMISSÕES USUÁRIO
    public function insertPermissaoUsuario($dados) {
        $this->Create()->ExCreate("permissaouser_usuarios", $dados);
        return $this->Create()->getResult();
    }

    public function deletePermissoes($dados) {
        $this->Delete()->ExDelete("permissaouser_usuarios", "WHERE id_usuario = :id AND id_permissaouser = :id_permissaouser", "id={$dados['id_usuario']}&id_permissaouser={$dados['id_permissaouser']}");
        return $this->Delete()->getResult();
    }

    public function deletePermissosUsuario($id_usuario) {
        $this->Delete()->ExDelete("permissaouser_usuarios", "WHERE id_usuario = {$id_usuario}", null);
        return $this->Delete()->getResult();
    }

    public function deleteGrupoPermissao($id_usuario, $id_grupo) {
        $this->Delete()->ExDelete("permissaouser_usuarios", "WHERE id_usuario = :id AND id_permissao_grupo = :id_permissao_grupo", "id={$id_usuario}&id_permissao_grupo={$id_grupo}");
        return $this->Delete()->getResult();
    }

    public function updateGrupo($dados, $id_grupo) {
        $this->Update()->ExUpdate("permissaouser_usuarios", $dados, "WHERE id_usuario={$dados['id_usuario']} AND id_permissao_grupo = {$id_grupo}", null);
        return $this->Update()->getResult();
    }

    // verifica se existe duplicacao.
    public function verificaPermissaoGrupo($id_usuario) {
        $this->Read()->ExRead("permissaouser_usuarios", "WHERE id_usuario = :idU AND id_permissao_grupo IS NOT NULL AND id_permissao_grupo != 0", "idU={$id_usuario}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectPermissoesIndividuais($id_usuario) {
        $this->_sql = "SELECT id_permissaouser FROM permissaouser_usuarios WHERE id_usuario = {$id_usuario} AND id_permissaouser IS NOT NULL AND id_permissaouser != 0";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectPermissaoUsuario($id) {
        $this->_sql = "SELECT  
			p.id_permissao, 
			p.tipo_permissao , 
			pu.id_permissaouser,u.nome 
		FROM  permissaouser as p
		INNER JOIN permissaouser_usuarios AS pu 
			ON p.id_permissao = pu.id_permissaouser 
		INNER JOIN usuarios as u 
			ON pu.id_usuario = u.id 
		where u.id = {$id} ORDER by tipo_permissao ASC";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectUsuarioPermissaoComissao() {
        $this->_sql = "SELECT  u.* 
		FROM  permissaouser_usuarios as pu
		LEFT JOIN permissaouser AS p
			ON pu.id_permissaouser = p.id_permissao 
		INNER JOIN usuarios as u 
			ON pu.id_usuario = u.id
		LEFT JOIN grupos_permissao gp
		    ON pu.`id_permissao_grupo` = gp.`gp_id`
		LEFT JOIN permissao_grupo pg
		    ON pg.`permissao_grupo_grupo` = gp.`gp_id`
		LEFT JOIN permissaouser ps
   			ON pg.`permissao_grupo_permissao` = ps.`id_permissao`
		WHERE pu.id_permissaouser  = 9 OR ps.id_permissao = 9 ORDER BY nome";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function verificaUsuarioPermissaoVenda($id_usuario) {
        $this->_sql = "SELECT
		  u.*
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
		WHERE pu.id_permissaouser = 8 OR pg.permissao_grupo_permissao = 8 AND u.id = {$id_usuario}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    // seleciona os usuarios com permissao de captacao. eq estao ativos 1
    public function selUser($tipo_permissao, $limite = NULL) {
        if (!empty($limite)) {
            $limite = "LIMIT  {$limite} ";
        }
        $this->_sql = "
		SELECT
		  u.id as usuario_id,
		  u.nome as usuario_nome,
		  u.ativar_captacao as usuario_ativar_captacao
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
		WHERE p.tipo_permissao = '" . $tipo_permissao . "' OR  ps.tipo_permissao = '" . $tipo_permissao . "'
				AND ativo =1
				ORDER BY u.nome ASC  {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function deletarNivelCaptacaoVendedor($id_usuario) {
        $this->deletarDDDsUsuario($id_usuario);
        $this->Delete()->ExDelete("captacao_niveis_usuarios", "WHERE captacao_niveis_usuarios_id_usuario = :id", "id={$id_usuario}");
    }

    public function selectGrupoPermissao($id_usuario) {
        $this->_sql = "SELECT pu.id_permissao_grupo, p.tipo_permissao
						FROM permissaouser_usuarios pu
						LEFT JOIN grupos_permissao gp
							ON pu.`id_permissao_grupo` = gp.`gp_id`
						INNER JOIN permissao_grupo pg
							ON gp.`gp_id` = pg.`permissao_grupo_grupo`
						INNER JOIN permissaouser p
							ON  pg.`permissao_grupo_permissao` = p.`id_permissao`
						WHERE pu.`id_usuario` = {$id_usuario}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectPermissoes($id, $verifica = NULL) {
        $variavel = !empty($verifica) ? "p.id_permissao" : "p.tipo_permissao";

        //BUSCA AS PERMISSÔES DOS GRUPOS
        $this->_sql = "SELECT
						{$variavel}
						FROM permissaouser_usuarios pu
						LEFT JOIN grupos_permissao gp
							ON pu.`id_permissao_grupo` = gp.`gp_id`
						INNER JOIN permissao_grupo pg
							ON gp.`gp_id` = pg.`permissao_grupo_grupo`
						INNER JOIN permissaouser p
							ON  pg.`permissao_grupo_permissao` = p.`id_permissao`
						WHERE pu.`id_usuario` = {$id}
						UNION ALL
						SELECT
							{$variavel}
							FROM permissaouser_usuarios  as auxpu
								left JOIN usuarios as u
									 ON auxpu.id_usuario = u.id
								left JOIN permissaouser as p
									 ON auxpu.id_permissaouser = p.id_permissao
								WHERE auxpu.id_usuario = '" . $id . "' AND id_permissaouser != 0";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectDuplicadas($id_usuario, $id_grupo) {
        $this->_sql = "SELECT 
        pu.id_permissaouser 
        FROM
        permissaouser_usuarios pu 
        RIGHT JOIN permissao_grupo p 
          ON pu.id_permissaouser = p.permissao_grupo_permissao 
          WHERE pu.id_usuario = {$id_usuario} AND p.permissao_grupo_grupo = {$id_grupo}";
        $this->Read()->FullRead($this->_sql, null);
        $retorno = $this->Read()->getResult();

        if (!empty($retorno)) {
            foreach ($retorno as $r) {
                $this->deletePermissoes(array("id_usuario" => $id_usuario, "id_permissaouser" => $r['id_permissaouser']));
            }
        }

        return !empty($retorno) ? 1 : 0;
    }

    //REGIÕES USUÁRIO
    public function selecionarDddsUsuario($dados) {
        $this->_sql = "
		SELECT 
			r.regiao_ddd, 
			r.regiao_id,
			r.regiao_telefone
		FROM ddds_usuario d
		INNER JOIN usuarios u 
			ON d.ddds_usuario_id_usuario = u.id
		INNER JOIN regiao r 
			ON r.regiao_id = d.ddds_usuario_id_regiao
		INNER JOIN estado e 
			ON r.regiao_estado_id = e.estado_id
		WHERE d.ddds_usuario_id_usuario ={$dados['id_usuario']}";
        if (isset($dados ['id_estado']))
            $this->_sql .= " AND e.estado_id = {$dados['id_estado']}";
        $this->Read()->FullRead($this->_sql, "ORDER BY r.regiao_ddd ASC");
        return $this->Read()->getResult();
    }

    public function selecionarDddsUsuarioString($idUsuario) {
        $list_ddd = $this->selecionarDddsUsuario(array(
            "id_usuario" => $idUsuario
        ));
        $listaDDD = "";
        $virgula = "";
        if (!empty($list_ddd)) {
            foreach ($list_ddd as $d) {
                $listaDDD .= $virgula . $d ['regiao_ddd'];
                $virgula = ",";
            }
            trim($listaDDD);
            substr($listaDDD, 0, - 1);
        }
        return $listaDDD;
    }

    public function deletarDDDUsuario($id, $codDDD) {
        $this->Delete()->ExDelete("ddds_usuario", "WHERE ddds_usuario_id_usuario = :id AND ddds_usuario_id_regiao = :ddd", "id={$id}&ddd={$codDDD}");
        return $this->Delete()->getResult();
    }

    public function inserirDDDUsuario($ddd) {
        $this->Create()->ExCreate("ddds_usuario", $ddd);
        return $this->Create()->getResult();
    }

    public function deletarDDDsUsuario($id) {
        $this->Delete()->ExDelete("ddds_usuario", "WHERE ddds_usuario_id_usuario = :id", "id={$id}");
        return $this->Delete()->getResult();
    }

    public function selectEstadosUsuarios($id) {
        $this->_sql = "
        SELECT 
                e.estado_nome,
                e.estado_id
        FROM ddds_usuario d
        INNER JOIN usuarios u 
                ON d.ddds_usuario_id_usuario = u.id
        INNER JOIN regiao r 
                ON r.regiao_id = d.ddds_usuario_id_regiao
        INNER JOIN estado e 
                ON r.regiao_estado_id = e.estado_id
        WHERE d.ddds_usuario_id_usuario ={$id} GROUP BY estado_id";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    //ASSINATURAS USUÁRIO 
    public function selecionarAssinaturaEmail($codUsuario, $ddd) {
        $assinatura[0] = $this->selUsuario($codUsuario);
        $this->_sql = "SELECT r.*, e.estado_nome
        FROM regiao r 
        INNER JOIN estado e ON r.regiao_estado_id = e.estado_id 
        WHERE regiao_ddd=" . $ddd . ";";
        $this->Read()->FullRead($this->_sql, null);
        $assinatura [1] = $this->limparArray($this->Read()->getResult());
        return $assinatura;
    }

    // seleciona todos os usuarios onde o nivel = 2 e sem assinatura.
    public function selectUsuarioSemAssinatura() {
        $this->_sql = "
        SELECT u.usuario,u.id,u.nome  
        FROM " . $this->_tabela . " as u 
        LEFT JOIN permissaouser_usuarios AS pu
          ON u.id = pu.id_usuario
        LEFT JOIN permissaouser AS p
          ON pu.id_permissaouser = p.id_permissao
        LEFT JOIN grupos_permissao gp 
                ON pu.`id_permissao_grupo` = gp.`gp_id` 
        LEFT JOIN permissao_grupo pg 
                 ON gp.`gp_id` = pg.`permissao_grupo_grupo` 
        LEFT JOIN permissaouser ps 
                ON pg.`permissao_grupo_permissao` = ps.`id_permissao` 
        WHERE (p.tipo_permissao = 'vendas' OR ps.tipo_permissao = 'vendas') 
        AND u.assinatura = '' 
        OR u.assinatura = 'NULL'  
        ORDER BY u.usuario";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    //busca o cartao de visita dos vendedores:
    public function listaCartaoVisita($where) {
        $this->_sql = "
        SELECT  cv.cartao_visita_img , u.nome FROM " . $this->_tabela . " AS u
        INNER JOIN captacao AS cap
          ON u.id = cap.captacao_id_usuario
        INNER JOIN proposta AS p
          ON cap.captacao_id = p.proposta_id_captacao
        INNER JOIN cartao_visita AS cv
          ON u.id = cv.cartao_visita_id_usuario
        WHERE u.id=" . $where['id_usuario'] . "
        AND cv.cartao_visita_tipocartao = " . $where['tipo_proposta'] . "
        GROUP BY u.id ";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }

    //PLANILHA COMISSÕES USUÁRIO
    public function atribuirPlanilhaComissaoUsuario($dados) {
        $this->Create()->ExCreate('usuariosplanilhas', $dados);
        return $this->Create()->getResult();
    }

    public function verificaPlanilhaComissaoUsuario($dados) {
        $this->Read()->ExRead('usuariosplanilhas', "WHERE usuariosPlanilhas_id_usuarios = :id AND  usuariosPlanilhas_id_planilha_comissoes = :planilha", "id={$dados['idUsuario']}&planilha={$dados['planilha']}");
        return $this->Read()->getRowCount();
    }

    public function selectPlanilhaUsuario($id_usuario, $excecao = false) {
        $this->_sql = "
        SELECT p.planilha_comissoes_nome, p.planilha_comissoes_id, planilha_comissoes_ra FROM usuariosplanilhas up
        INNER JOIN usuarios u 
                ON up.usuariosplanilhas_id_usuarios = u.id
        INNER JOIN planilha_comissoes p 
                ON up.usuariosPlanilhas_id_planilha_comissoes = p.planilha_comissoes_id
        WHERE usuariosplanilhas_id_usuarios ={$id_usuario} ORDER by planilha_comissoes_nome ASC";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function deletePlanilhaUsuario($dados) {
        $this->Delete()->ExDelete("usuariosplanilhas", "WHERE usuariosplanilhas_id_planilha_comissoes = :idPlanilha AND usuariosplanilhas_id_usuarios = :idUsuario", "idPlanilha={$dados['id_planilha']}&idUsuario={$dados['id_usuario']}");
        return $this->Delete()->getResult();
    }

    /*
     * ***************************************
     * ********** CAPTACAO USUARIO **********
     * ***************************************
     */

    public function selectUsuariosPorNiveisCaptacao($nivelCaptacao) {
        $nivelCaptacao = !($nivelCaptacao == - 1) ? "WHERE  CN.captacao_niveis_ra =" . $nivelCaptacao : "";

        $this->_sql = "
        SELECT u.usuario,u.id, CN.captacao_niveis_desc, cnr.captacao_niveis_regras_desc, CNU.captacao_niveis_usuarios_id, CNU.captacao_niveis_usuarios_ativo
        FROM usuarios  AS u 
        INNER JOIN  captacao_niveis_usuarios AS CNU
                ON u.ID = CNU.captacao_niveis_usuarios_id_usuario
        INNER JOIN captacao_niveis AS CN 
                ON CN.captacao_niveis_id  = CNU.captacao_niveis_usuarios_captacao_niveis_id  
        LEFT JOIN captacao_niveis_regras as cnr
                ON CNU.captacao_niveis_usuarios_regra_id = cnr.captacao_niveis_regras_id {$nivelCaptacao} ORDER BY u.usuario ASC";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectUsuariosCaptacaoAtiva() {
        $this->_sql = "
        SELECT u.id , u.usuario  FROM usuarios  AS u 
        LEFT JOIN permissaouser_usuarios AS pu 
                ON u.id = pu.id_usuario
        LEFT JOIN grupos_permissao gp 
                ON pu.`id_permissao_grupo` = gp.`gp_id` 
        LEFT JOIN permissao_grupo pg 
                ON gp.`gp_id` = pg.`permissao_grupo_grupo` 
        LEFT JOIN permissaouser ps 
                ON pg.`permissao_grupo_permissao` = ps.`id_permissao` 
        WHERE  (pu.id_permissaouser = 8 OR ps.id_permissao) and u.ativo=1  group by u.id	 order by u.usuario ASC ";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function consultaFiltroDdd($id_usuario, $ddd) {
        $this->_sql = "SELECT COUNT(ddds_usuario_id) AS filtro_ddd FROM ddds_usuario_id WHERE ddds_usuario_id_usuario = {$id_usuario} AND ddds_usuario_id_regiao = {$ddd}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function validarNivelCaptacao($dados) {
        $regra = (!empty($dados ['captacao_niveis_regra'])) ? 'AND  captacao_niveis_usuarios_regra_id = ' . $dados ['captacao_niveis_regra'] : '';
        $nivel = (!empty($dados['captacao_niveis_usuarios_captacao_niveis_id'])) ? "AND captacao_niveis_usuarios_captacao_niveis_id = {$dados["captacao_niveis_usuarios_captacao_niveis_id"]}" : '';
        $this->_sql = "
        SELECT * FROM captacao_niveis_usuarios 
        WHERE captacao_niveis_usuarios_id_usuario ={$dados['id_usuario']} {$regra} {$nivel}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getRowCount();
    }

    public function validarCaptacaoVendedor($id) {
        $this->_sql = "SELECT captacao_niveis_usuarios_captacao_niveis_id FROM captacao_niveis_usuarios WHERE captacao_niveis_usuarios_id_usuario = {$id} AND captacao_niveis_usuarios_captacao_niveis_id = 1";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getRowCount();
    }

    public function selectUserComContratos() {
        $this->_sql = "
        SELECT 
          c.id_usuario,
          u.nome 
        FROM
          contratos c 
          LEFT JOIN usuarios u 
                ON c.id_usuario = u.`id` 
        GROUP BY u.nome ORDER BY u.nome";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selecionarVendedores() {
        $this->_sql = "SELECT  u.nome,u.id 
        FROM
        usuarios u
        INNER JOIN captacao_niveis_usuarios cn 
        ON u.id = cn.captacao_niveis_usuarios_id_usuario GROUP BY id";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selecionarUltimoAcesso($id_usuario) {
        $this->Read()->ExRead("log", "WHERE log_usuario = {$id_usuario} AND log_descricao = 'Login' ORDER BY log_id DESC LIMIT 1");
        return $this->limparArray($this->Read()->getResult());
    }

    public function setFiltros($busca) {
        $campos = array("id",
            "nome",
            "usuario",
            "setor_local",
            "cargo_descricao",
            "ativo");
        $this->_filtros = $this->filtrar($campos, $busca);
    }
    
    /**
     * @param String  $id_permissaouser 9
     * @return array Retorna ARRAYLIST de usuarios com permissao de captacao :( nome - id_empresa). 
     */
    public function getJoinUsuarioPermissaouserUsuarios($id_permissaouser) {
        $this->Read()->FullRead("SELECT DISTINCT(_u.nome),_u.id_empresa 
        FROM usuarios AS _u 
        INNER JOIN  permissaouser_usuarios AS _pu 
        ON _pu.id_usuario =  _u.`id`
        WHERE  _pu.id_permissaouser  = {$id_permissaouser} AND _u.id_empresa <>''
        ORDER BY _u.nome ASC
        ");
        return $this->Read()->getResult();
    }
}