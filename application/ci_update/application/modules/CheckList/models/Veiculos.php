<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Veiculos extends M_CRUD {

   protected $tabela = "veiculos";

   public function getVeiculo($id_cliente){
        $this->db->select('_v.modelo,_v.marca,_v.placa,_v.chassis,_v.bloqueio')
        ->from("{$this->tabela} AS _v")
        ->where(['_v.id_cliente'=>$id_cliente]);
        $query = $this->db->get()->result_object();    
        return $query;
   }   
}