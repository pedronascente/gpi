<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MCaptacao extends CI_Model {

    private $_tabela = 'captacao';

    public function __construct() {
        $this->load->database();
    }

    public function get_total_de_leads_por_status() {
        $arrayList = $this->db->select('DISTINCT(captacao_status) ,COUNT(captacao_id) AS total')->from($this->_tabela)->group_by('captacao_status')->order_by('captacao_status ASC')->get()->result_object();
        return $arrayList;
    }

    public function get_total_de_leads_por_origem() {
        $arrayList = $this->db->select('DISTINCT(origem) ,COUNT(captacao_id) AS total')
                              ->from($this->_tabela)->group_by('origem')
                              ->where(
                                            "origem 
                                                 NOT IN( 
                                                        'liigue-51-4063-6666',	
                                                        'liigue-51-3342-5551',
                                                        'liigue-11-3522-1111',
                                                        'ligue-85-4062-9432',
                                                        'ligue-81-4062-9142',
                                                        'ligue-71-4062-9554',
                                                        'ligue-65-4052-9679',
                                                        'ligue-62-4053-8093',
                                                        'ligue-51-4063-6666',
                                                        'ligue-51-3342-5551',
                                                        'ligue-48-4052-8474',
                                                        'ligue-41-4063-7868',
                                                        'ligue-31-4063-9523',
                                                        'ligue-3004-5554',
                                                        'ligue-27-4062-9343',
                                                        'ligue-21-4062-7070',
                                                        'ligue-11-3522-1111'
                                                )
                                             ")  
                              ->order_by('origem DESC')
                              ->get()->result_object();
        return $arrayList;
    }

    public function get_total_de_leads_por_ano() {
        $arrayList = $this->db->select('DISTINCT(year(captacao_data_criacao)) as ANO,COUNT(captacao_id) AS total')->from($this->_tabela)->group_by('year(captacao_data_criacao)')->order_by('year(captacao_data_criacao) DESC')->get()->result_object();
        $array_complemento=[
            'ANO'=>'Total',
            'total'=>$this->db->select('COUNT(captacao_id) AS total')->from($this->_tabela)->get()->result_object()[0]->total,
        ];
        array_push($arrayList, $array_complemento);
        return $arrayList;
    }

    public function get_total_de_leads_por_UF() {
        $arrayList = $this->db->select('distinct(captacao_uf) AS uf, COUNT(captacao_id) AS total')->from($this->_tabela)->group_by('captacao_uf')->order_by('captacao_uf ASC')->get()->result_object();
        return $arrayList;
    }

    public function get_total_leads() {
        $arrayList = $this->db->select('COUNT(captacao_id) AS total')->from($this->_tabela)->get()->result_object();
        return $arrayList;
    }

    public function get_captacao_status($paramentro) {
        $_AND = '';
        if ($paramentro['uf'] != 'null') {
            $_AND = "AND captacao_uf ='" . $paramentro['uf'] . "' ";
        }
        if ($paramentro['origem'] != 'null') {
            $_AND .="AND origem ='" . $paramentro['origem'] . "' ";
        }
        if ($paramentro['periodo'] != 'null') {
            $data = explode('a', $paramentro['periodo']);
            $data_inicial = "'{$data[0]}  00:00:00'";
            $data_final = "'{$data[1]} 23:59:59'";
        } else {
            $data_inicial = "'2019-01-01 00:00:00'";
            $data_final = "'2019-12-29 23:59:59'";
        }
        $_BETWEEN = "BETWEEN  {$data_inicial}  AND {$data_final}";

        $arrayList = $this->db->select(' COUNT(*) AS total ,captacao_status')
                        ->from($this->_tabela)
                        ->where("captacao_data_criacao {$_BETWEEN}   {$_AND} ")
                        ->group_by("captacao_status")
                        ->get()->result_object();
        return $arrayList;
    }

    public function get_captacao_origem($paramentro) {
        $_AND = '';
        if ($paramentro['uf'] != 'null') {
            $_AND = "AND captacao_uf ='" . $paramentro['uf'] . "' ";
        }
        if ($paramentro['status'] != 'null') {
            $_AND .="AND captacao_status ='" . $paramentro['status'] . "' ";
        }
        if ($paramentro['periodo'] != 'null') {
            $data = explode('a', $paramentro['periodo']);
            $data_inicial = "'{$data[0]}  00:00:00'";
            $data_final = "'{$data[1]} 23:59:59'";
        } else {
            $data_inicial = "'2019-01-01 00:00:00'";
            $data_final = "'2019-12-29 23:59:59'";
        }
        $_BETWEEN = "BETWEEN  {$data_inicial}  AND {$data_final}";

        $arrayList = $this->db->select(' COUNT(*) AS total ,origem')
                        ->from($this->_tabela)
                        ->where("
                                origem 
                                                 NOT IN( 
                                                        'liigue-51-4063-6666',	
                                                        'liigue-51-3342-5551',
                                                        'liigue-11-3522-1111',
                                                        'ligue-85-4062-9432',
                                                        'ligue-81-4062-9142',
                                                        'ligue-71-4062-9554',
                                                        'ligue-65-4052-9679',
                                                        'ligue-62-4053-8093',
                                                        'ligue-51-4063-6666',
                                                        'ligue-51-3342-5551',
                                                        'ligue-48-4052-8474',
                                                        'ligue-41-4063-7868',
                                                        'ligue-31-4063-9523',
                                                        'ligue-3004-5554',
                                                        'ligue-27-4062-9343',
                                                        'ligue-21-4062-7070',
                                                        'ligue-11-3522-1111'
                                                )


                            AND    captacao_data_criacao {$_BETWEEN}   {$_AND}  ")
                        ->group_by("origem")
                        ->get()->result_object();
        return $arrayList;
    }

    public function get_captacao_uf($paramentro) {
        $_AND = '';
        if ($paramentro['status'] != 'null') {
            $_AND = "AND captacao_status ='" . $paramentro['status'] . "' ";
        }
        if ($paramentro['origem'] != 'null') {
            $_AND .="AND origem ='" . $paramentro['origem'] . "' ";
        }
        if ($paramentro['periodo'] != 'null') {
            $data = explode('a', $paramentro['periodo']);
            $data_inicial = "'{$data[0]}  00:00:00'";
            $data_final = "'{$data[1]} 23:59:59'";
        } else {
            $data_inicial = "'2019-01-01 00:00:00'";
            $data_final = "'2019-12-29 23:59:59'";
        }
        $_BETWEEN = "BETWEEN  {$data_inicial}  AND {$data_final}";

        $arrayList = $this->db->select(' COUNT(*) AS total ,captacao_uf')
                        ->from($this->_tabela)
                        ->where("captacao_data_criacao {$_BETWEEN}   {$_AND} ")
                        ->group_by("captacao_uf")
                        ->get()->result_object();
        return $arrayList;
    }

    public function get_filtros_dinamico($paramentro) {
        $_AND = '';
        if ($paramentro['status'] != 'null') {
            $_AND = "AND captacao_status ='" . $paramentro['status'] . "' ";
        }

        if ($paramentro['origem'] != 'null') {
            $_AND .="AND origem ='" . $paramentro['origem'] . "' ";
        }

        if ($paramentro['uf'] != 'null') {
            $_AND .="AND captacao_uf ='" . $paramentro['uf'] . "' ";
        }

        if ($paramentro['periodo'] != 'null') {
            $data = explode('a', $paramentro['periodo']);
            $data_inicial = "'{$data[0]}  00:00:00'";
            $data_final = "'{$data[1]} 23:59:59'";
        } else {
            $data_inicial = "'2019-01-01 00:00:00'";
            $data_final = "'2019-12-29 23:59:59'";
        }
        $_BETWEEN = "BETWEEN  {$data_inicial}  AND  {$data_final}";
        $arrayList = $this->db->select(' COUNT(*) AS total')
                        ->from($this->_tabela)
                        ->where("captacao_data_criacao {$_BETWEEN}   {$_AND} ")
                        ->get()->result_object();
        return $arrayList;
    }

    public function get_select($p1) {
        switch ($p1) {
            case 'origem':
                $arrayLists = $this->db->select("DISTINCT(origem) AS origem")
                                       ->where(
                                            "origem 
                                                 NOT IN( 
                                                        'liigue-51-4063-6666',	
                                                        'liigue-51-3342-5551',
                                                        'liigue-11-3522-1111',
                                                        'ligue-85-4062-9432',
                                                        'ligue-81-4062-9142',
                                                        'ligue-71-4062-9554',
                                                        'ligue-65-4052-9679',
                                                        'ligue-62-4053-8093',
                                                        'ligue-51-4063-6666',
                                                        'ligue-51-3342-5551',
                                                        'ligue-48-4052-8474',
                                                        'ligue-41-4063-7868',
                                                        'ligue-31-4063-9523',
                                                        'ligue-3004-5554',
                                                        'ligue-27-4062-9343',
                                                        'ligue-21-4062-7070',
                                                        'ligue-11-3522-1111'
                                                )
                                             ")
                                       ->from($this->_tabela)->order_by('origem DESC')->get()->result_object();
                break;
            case 'status':
                $arrayLists = $this->db->select("DISTINCT(captacao_status) AS captacao_status")->from($this->_tabela)->order_by('captacao_status ASC')->get()->result_object();
                break;
            case 'uf':
                $arrayLists = $this->db->select("DISTINCT(captacao_uf) AS captacao_uf")->from($this->_tabela)->order_by('captacao_uf ASC')->get()->result_object();
                break;
        }
        return $arrayLists;
    }
}
