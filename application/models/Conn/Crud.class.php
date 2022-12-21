<?php
class Crud {

    private $_Read;
    private $_Update;
    private $_Delete;
    private $_Create;
    public $sql;
    

    public function __construct() {
        $this->_Read   = new Read ();
        $this->_Update = new Update ();
        $this->_Create = new Create ();
        $this->_Delete = new Delete ();
    }
    

    /*
     *****************************************************************************************
     ************ INSTANCIAR OBJETO DA CLASSE READ (GERENCIADOR DE LISTAGEM NA BD) *********** 
     *****************************************************************************************
     */ 

    public function Read() {
        return $this->_Read;
    }

    /*
     ***********************************************************************************************
     ************ INSTANCIAR OBJETO DA CLASSE UPDATE (GERENCIADOR DE ATUALIZACOES NA BD) *********** 
     ***********************************************************************************************
    */
    public function Update() {
        return $this->_Update;
    }

    /*
     ***********************************************************************************************
     ************ INSTANCIAR OBJETO DA CLASSE DELETE (GERENCIADOR DE EXCLUSAO  NA BD) *********** 
     ***********************************************************************************************
    */
    public function Delete() {
        return $this->_Delete;
    }

    public function Create() {
        return $this->_Create;
    }

    /*
     ***********************************************************************
     ************ converte data no formato amaricano ano-mes-dia *********** 
     ***********************************************************************
     */ 
    protected function converteData($dataParam) {
        $data   = explode ( "/", $dataParam);
        $d      = isset ($data[1]) ? $data [1] : '';
        $m      = isset ($data[0]) ? $data [0] : '';
        $y      = isset ($data[2]) ? $data [2] : '';

        if (!empty($d) && !empty($m) && !empty($y)){
            return $data = $y . '-' . $m . '-' . $d;
        }
    }

    public function limparArray($arrayParam){
        $array = isset($arrayParam[0]) ? $arrayParam[0] : $arrayParam;
        return $array;
    }
    
    //filtro generico tabelas
    public function filtrar(array $campos, $busca){
    
    	$where = "";
    	$or = "";
    
    	foreach ($campos as $campo){
    		$where .= " {$or} {$campo} LIKE '%{$busca}%'";
    		$or = "OR";
    	}
    
    	return " AND (".$where.")";
    
    }
    
    public function sets($dados){
        foreach ($dados as $k => $v){
                $this->$k = $v;
        }         
    }
    
    public function __destruct() {
    }
}