<?php

final class Permissao extends Crud {

    private $_sql;
    private $_tabela = 'permissaouser';

    public function insert($dados) {
        $this->Create()->ExCreate($this->_tabela, $dados);
        return $this->Create()->getResult();
    }

    public function select() {
        $this->Read()->ExRead($this->_tabela, "ORDER BY tipo_permissao ASC", null);
        return $this->Read()->getResult();
    }

    public function deletePermissao($id) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE id_permissao = :id", "id={$id}");
        return $this->Delete()->gerResult();
    }

    /*
     * ****************************************
     * ********* GRUPO DE PERMISSÂO ***********
     * ****************************************
     */

    public function insertGrupo($grupo) {
        $this->Create()->ExCreate("grupos_permissao", $grupo);
        return $this->Create()->getResult();
    }

    public function insertPermissaoGrupo($permissaoGrupo) {
        $this->Create()->ExCreate("permissao_grupo", $permissaoGrupo);
        return $this->Create()->getResult();
    }

    public function deletePermissaoGrupo($id_grupo, $id_permissao) {
        $this->Delete()->ExDelete("permissao_grupo", "WHERE permissao_grupo_grupo = {$id_grupo} AND permissao_grupo_permissao = {$id_permissao}", null);
    }

    public function selectGrupoPermissao() {
        $this->Read()->ExRead("grupos_permissao", null, null);
        return $this->Read()->getResult();
    }

    public function selectPermissaoGrupo($permissao) {
        $this->_sql = "SELECT
						u.id, u.nome
						FROM permissaouser_usuarios pu
						LEFT JOIN grupos_permissao gp
							ON pu.`id_permissao_grupo` = gp.`gp_id`
						INNER JOIN permissao_grupo pg
						ON gp.`gp_id` = pg.`permissao_grupo_grupo`
						INNER JOIN permissaouser p
							ON  pg.`permissao_grupo_permissao` = p.`id_permissao`
						INNER JOIN usuarios u 
							ON pu.id_usuario = u.id
						WHERE p.tipo_permissao like '%" . $permissao . "%'
						UNION
						SELECT
						us.id, us.nome
						FROM permissaouser_usuarios  as auxpu
						LEFT JOIN usuarios as u
							ON auxpu.id_usuario = u.id
						LEFT JOIN permissaouser as p
							ON auxpu.id_permissaouser = p.id_permissao
						INNER JOIN usuarios us 
							ON auxpu.id_usuario = us.id
						WHERE p.tipo_permissao like '%" . $permissao . "%'";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function selectPermmisoesGrupo($id_grupo) {
        $this->_sql = "SELECT 
						  pg.permissao_grupo_permissao as id_permissao
						FROM
						  permissao_grupo pg 
						  INNER JOIN grupos_permissao gp 
						    ON pg.permissao_grupo_grupo = gp.gp_id 
						  INNER JOIN permissaouser p 
						    ON pg.permissao_grupo_permissao = p.id_permissao
						WHERE pg.permissao_grupo_grupo = {$id_grupo} ORDER by p.tipo_permissao";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function getSQL() {
        return $this->_sql;
    }

}
