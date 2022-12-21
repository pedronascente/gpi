<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MCaptacao extends CI_Model {

    private $_tabela = 'captacao';

    public function __construct() {
        $this->load->database();
    }

    public function update_captacao($data_input) {
        $data_inicial = date('Y-m-d', strtotime(str_replace('/', '-', $data_input['data_inicial']))). ' 00:00:01';
        $data_fim = date('Y-m-d', strtotime(str_replace('/', '-', $data_input['data_fim']))). ' 23:59:59';
        $this->db->where('captacao_id_usuario', intval($data_input['id_vendedor_doador']))
                 ->where('captacao_data_criacao BETWEEN "'.$data_inicial. '" and "'. $data_fim.'"')
                 ->set('captacao_id_usuario', intval($data_input['id_vendedor_receptor']))
                 ->update($this->_tabela);
        if($this->db->trans_status() === true){
            $this->db->trans_commit();
            return true;
        }else{
            $this->db->trans_rollback();
            return false;
        }
    }

    public function select_total_captacao($data_input){
        $data_inicial = date('Y-m-d', strtotime(str_replace('/', '-', $data_input['data_inicial']))). ' 00:00:01';
        $data_fim = date('Y-m-d', strtotime(str_replace('/', '-', $data_input['data_fim']))). ' 23:59:59';
        return $this->db->select('*')
                        ->from($this->_tabela)
                        ->where('captacao_id_usuario', intval($data_input['id_vendedor_doador']))
                        ->where('captacao_data_criacao BETWEEN "'.$data_inicial. '" and "'. $data_fim.'"')
                        ->get()
                        ->num_rows();
    }

    public function select_vendedor($data_input,$tipo){
        
        if($tipo=='vendedor_receptor'){
            $id = intval($data_input['id_vendedor_receptor']);
        }else if($tipo=='vendedor_doador'){
            $id = intval($data_input['id_vendedor_doador']);
        }

        //o primeiro id é o vendedor receptor, eo segundo éo doador.
        return $this->db->select('id,nome')
                        ->from($this->_tabela)
                        ->join("usuarios", "usuarios.id =  $this->_tabela.captacao_id_usuario")
                        ->where("captacao.captacao_id_usuario",$id)
                        ->group_by('captacao.captacao_id_usuario')
                        ->get()
                        ->result_object();
         

    }


























}