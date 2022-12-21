<?php

final class Login extends Crud {

    private $_usuario;
    private $_senha;
    private $_tabela = 'usuarios';

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

    public function selectUsuarioLogin() {
        $this->Read()->ExRead($this->_tabela, "WHERE usuario=:usuario AND senha = :senha", "usuario={$this->_usuario}&senha={$this->_senha}");
        return $this->limparArray($this->Read()->getResult());
    }

    // seleciona as permissoes do usuario:
    public function selectPermissoes($id) {
        $sql = "SELECT 
				  p.tipo_permissao 
				FROM
				  permissaouser_usuarios pu 
				  LEFT JOIN grupos_permissao gp 
				    ON pu.`id_permissao_grupo` = gp.`gp_id` 
				  INNER JOIN permissao_grupo pg 
				    ON gp.`gp_id` = pg.`permissao_grupo_grupo` 
				  INNER JOIN permissaouser p
				    ON  pg.`permissao_grupo_permissao` = p.`id_permissao` 
				WHERE pu.`id_usuario` = {$id}";
        $this->Read()->FullRead($sql, null);
        
        $retorno = $this->Read()->getResult();
        $sql = " 	
			SELECT 
				 p.tipo_permissao
				 FROM permissaouser_usuarios  as auxpu
			left JOIN usuarios as u
				 ON auxpu.id_usuario = u.id
			left JOIN permissaouser as p 
				 ON auxpu.id_permissaouser = p.id_permissao
			WHERE auxpu.id_usuario = '" . $id . "' AND id_permissaouser != 0  group by auxpu.id_permissaouser ";
        $this->Read()->FullRead($sql, null);
        
        $retorno = array_merge($retorno, $this->Read()->getResult());
        return $retorno;
    }

}
