<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends M_CRUD {
      protected $tabela = "clientes";

      public function getCliente($id_cliente)
      {
           $this->db->select('_c.nome_cliente, _c.cnpjcpf_cliente,_c.tipo_cadastro')
           ->from("{$this->tabela} AS _c")
           ->where(['_c.id_cliente'=>$id_cliente]);
           $query = $this->db->get()->row_object();    
           return $query;
      }   
}