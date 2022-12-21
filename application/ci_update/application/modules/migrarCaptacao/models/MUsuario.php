<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MUsuario extends CI_Model {

    private $_tabela = 'usuarios';

    public function __construct() {
        $this->load->database();
    }

    public function get_usuarios(){
            $arrayList = $this->db->select("*")
                                  ->from($this->_tabela) 
                                  ->join("permissaouser_usuarios", "permissaouser_usuarios.id_usuario =$this->_tabela.id")
                                  ->join("permissaouser", "permissaouser.id_permissao =  permissaouser_usuarios.id_permissaouser")
                                  ->where("permissaouser.tipo_permissao = 'captacao' AND  $this->_tabela.ativo = 1")
                                  ->order_by('nome', 'ASC')->get()->result_object();
        return $arrayList;
    }
   
}
