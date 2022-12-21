<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class selects extends CI_Model {

  protected $tabela = "rh_selectcampos";
  protected $database;

  public function getData() {

    $this->load->database();

    $returned = array();

    $this->db->select('tiposelect,arrayValues')->from($this->tabela);

    foreach ($this->db->get()->result() as $value) {
      $returned[$value->tiposelect]= json_decode($value->arrayValues);
    }

    $this->db->close();

    return $returned;
  }

}
