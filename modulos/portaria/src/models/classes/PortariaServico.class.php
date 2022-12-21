<?php
class PortariaServico extends Crud {
    
    private $tabela = 'portaria_servicos';
    private $psId;
    private $psTipoServico;
   
    private $psDataCriacao;
    
    /*
     ***************************
     * methods -> gets()
     ***************************
     */
    
    public function getTabela(){
        return $this->tabela;
    }
    
    public function getPsId(){
        return $this->psId;
    }
    
    public function getPsTipoServico(){
        return $this->psTipoServico;
    }  
    
    public function getPsDataCriacao(){
        return $this->psDataCriacao;
    }
    
     /*
     ***************************
     * methods -> sets()
     ***************************
     */
    public function setPsId($psId){
        $this->psId = intval($psId);
        return $this;
    }
    
    public function setPsTipoServico($tiposervico){
        $this->psTipoServico = $tiposervico;
        return $this;
    }    
    
    public function setPsDataCriacao($psDataCriacao){
        $this->psDataCriacao = $psDataCriacao;
        return $this;
    }  
    
    /*
     ***************************
     * popula sets ()
     ***************************
     */
    public function sets($dados) {
        $this->setPsId(isset($dados['ps_id']) ? $dados['ps_id'] : NULL);
        $this->setPsTipoServico(isset($dados['ps_tipoServico']) ? $dados['ps_tipoServico'] : NULL);
    }

    //SELECT DB :
     public function select() {
        $this->_sql = "SELECT * from {$this->getTabela()}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }
      
    //INSERT DB:
    public function insertServico($dados) {
        $this->Create()->ExCreate($this->tabela, $dados);
        return $this->Create()->getResult();
    }

    //DELETE DB:
    public function deleteCondominio($id) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE ps_id = :id", "id={$id}");
        return $this->Delete()->getResult();
    }
}
