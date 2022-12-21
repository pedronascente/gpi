<?php
class PortariaIPAntena extends Crud{
    
    private $tabela = 'portaria_ip_antena';
    protected $pia_id;
    protected $pia_ip;
    protected $pia_mask;
    protected $pia_gateway;
    protected $pia_data_criacao;
    protected $pia_pa_id;
    
    public function getPia_id() {
        return $this->pia_id;
    }

    public function getPia_ip() {
        return $this->pia_ip;
    }

    public function getPia_mask() {
        return $this->pia_mask;
    }

    public function getPia_gateway() {
        return $this->pia_gateway;
    }

    public function getPia_data_criacao() {
        return $this->pia_data_criacao;
    }

    public function getPia_pa_id() {
        return $this->pia_pa_id;
    }

    public function setPia_id($pia_id) {
        $this->pia_id = $pia_id;
    }

    public function setPia_ip($pia_ip) {
        $this->pia_ip = $pia_ip;
    }

    public function setPia_mask($pia_mask) {
        $this->pia_mask = $pia_mask;
    }

    public function setPia_gateway($pia_gateway) {
        $this->pia_gateway = $pia_gateway;
    }

    public function setPia_data_criacao($pia_data_criacao) {
        $this->pia_data_criacao = $pia_data_criacao;
    }

    public function setPia_pa_id($pia_pa_id) {
        $this->pia_pa_id = $pia_pa_id;
    }
    
    public function selectIpPorId($idAntena){
       $this->sql = "select * from {$this->tabela} WHERE pia_pa_id = {$idAntena} ORDER BY  pia_id desc"; 
       $this->Read()->FullRead($this->sql);
       return $this->Read()->getResult();
    } 
    
    public function  inserIP($dados){
        $this->Create()->ExCreate($this->tabela, $dados);
        return $this->Create()->getResult();
    }
    
    //DELETE DB:
    public function deleteIPAntena($id) {
        $this->Delete()->ExDelete($this->tabela, "WHERE pia_pa_id = :id", "id={$id}");
        return $this->Delete()->getResult();
    }
    
    public function UpdateIPAntena($dados){
        $this->pia_pa_id =  $dados['pia_pa_id']; 
        $this->pia_id =  $dados['pia_id']; 
        unset($dados['pia_pa_id'],$dados['pia_id']);
        $this->Update()->ExUpdate($this->tabela, $dados, "WHERE pia_pa_id =:id     AND pia_id = :id2   "  ,        "id={$this->pia_pa_id}&id2={$this->pia_id}");
        return $this->Update()->getResult();   
    }
    
}
