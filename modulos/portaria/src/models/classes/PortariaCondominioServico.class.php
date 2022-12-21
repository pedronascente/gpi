<?php
class PortariaCondominioServico extends Crud {
    private $tabela = 'portariacondominioservico';
    private $pcsId;
    private $pcsPCid;
    private $pcsPSid;
    private $pcsResponsavel;
    private $pcsTelefone;
    private $pcsDataCriacao;
    private $pcspsTipoServico;
    private $filtro;
    public $sql;
    /*
     ***************************
     * methods -> gets()
     ***************************
     */
    
    public function getTabela() {
        return $this->tabela;
    }
    public function getPcsId(){
        return $this->pcsId;
    }
    
    public function getPcsPCid(){
        return $this->pcsPCid;
    }
    
    public function getPcsPSId(){
        return $this->pcsPSid;
    }
    
    public function getPcsResponsavel(){
        return $this->pcsResponsavel;
    } 
    
    public function getPcsTelefone(){
        return $this->pcsTelefone;
    }
    
    public function getPcsDataCriacao(){
        return $this->pcsDataCriacao;
    }
     
    public function getPcspsTipoServico(){
        return $this->pcspsTipoServico;
    }
    
    /*
     ***************************
     * methods -> sets()
     ***************************
     */
    
    public function setPcsId($pcsId){
        $this->pcsId = $pcsId;
        return $this;
    }
    
    public function setPcsResponsavel($pcsResponsavel){
        $this->pcsResponsavel = $pcsResponsavel;
        return $this;
    }
    
    public function setPcsTelefone($pcsTelefone){
        $this->pcsTelefone = $pcsTelefone;
        return $this;
    }  
    
    public function setPcsDataCriacao($pcsDataCriacao){
        $this->pcsDataCriacao = $pcsDataCriacao;
        return $this;
    }  
    
    public function setPcsPCid($pcsPCid){
        $this->pcsPCid = $pcsPCid;
        return $this;
    }
    
    public function setPcsPSId($pcsPSid){
        $this->pcsPSid = $pcsPSid;
        return $this;
    }
    
    public function setPcspsTipoServico($pcspsTipoServico){
        $this->pcspsTipoServico = $pcspsTipoServico;
        return $this;
    }
    
    /*
     ***************************
     * popula sets ()
     ***************************
     */
    
    public function sets($dados) {
        $this->setPcsResponsavel(isset($dados['pcs_responsavel']) ? $dados['pcs_responsavel'] : NULL);
        $this->setPcsTelefone(isset($dados['pcs_telefone']) ? $dados['pcs_telefone'] : NULL);
        $this->setPcsDataCriacao(isset($dados['pcs_dataCriacao']) ? $dados['pcs_dataCriacao'] : NULL);
        $this->setPcsPCid(isset($dados['pcs_pc_id']) ? $dados['pcs_pc_id'] : NULL);
        $this->setPcsPSId(isset($dados['pcs_ps_id']) ? $dados['pcs_ps_id'] : NULL);
        $this->setPcsId(isset($dados['pcs_id']) ? $dados['pcs_id'] : NULL);
        $this->setPcspsTipoServico(isset($dados['ps_tipoServico']) ? $dados['ps_tipoServico'] : NULL);
    }
    
    //LISTA TODOS OS SERVIÇOS DO CONDOMINIO X :
    public function selectServicosDoCondominio($dados) {
        $limite = isset($dados ['limite']) ? " LIMIT {$dados['limite']}" : "";
        $this->pcsPCid = isset($dados ['pc_id']) ?$dados['pc_id'] :"";
        $this->filtro = isset($dados ['filtro']) ?$dados['filtro'] :"";;
        
        if(!empty($this->filtro)){
            $this->sql = "SELECT PCS.*,PS.ps_tipoServico FROM  {$this->tabela} AS PCS left JOIN portaria_servicos  AS PS ON  PCS.pcs_ps_id = PS.ps_id  " . $this->getBuscarPor() . "  AND PCS.pcs_pc_id={$this->pcsPCid}  GROUP BY PCS.pcs_id  ORDER BY PCS.pcs_id DESC  {$limite} " ;
            }else{
            $this->sql = "SELECT PCS.*,PS.ps_tipoServico FROM  {$this->tabela} AS PCS left JOIN portaria_servicos  AS PS ON  PCS.pcs_ps_id = PS.ps_id    WHERE PCS.pcs_pc_id = {$this->getPcsPCid()}    GROUP BY PCS.pcs_id    ORDER BY PCS.pcs_id DESC    {$limite}";
            }
        $this->Read()->FullRead($this->sql);
        return $this->Read()->getResult();
    }
    
    //VERIFICA SE CONDOMINIO JÁ POSSUI SERVICO:
    public function selectServicoDuplicado($dados){
        $this->pcsPCid = $dados['pcs_pc_id'];
        $this->pcsPSid = $dados['pcs_ps_id'];
        $this->sql   = "SELECT * from {$this->tabela} WHERE pcs_ps_id = {$this->pcsPSid} AND pcs_pc_id = {$this->pcsPCid}  ";
        $this->Read()->FullRead($this->sql);
        return $this->Read()->getRowCount();
    }
    
    //INSERT DB:
    public function insert($dados) {
        $this->Create()->ExCreate($this->tabela, $dados);
        return $this->Create()->getResult();
    }
    
    //DELETE DB:
    public function deleteServico($id) {
        $this->Delete()->ExDelete($this->tabela, "WHERE pcs_id = :id", "id={$id}");
        return $this->Delete()->getResult();
    }
    
     public function UpdateServico($dados) {
        $this->pcId =  $dados['pcs_id']; 
        $this->pcsPCid =  $dados['pcs_pc_id'];
        unset($dados['pcs_id'],$dados['pcs_pc_id']);
        $this->Update()->ExUpdate($this->tabela, $dados, "WHERE pcs_id = {$this->pcId} and pcs_pc_id = {$this->pcsPCid }");
        return $this->Update()->getResult();
    }  
    
    private function getBuscarPor(){
     if($this->filtro !==NULL){
         $where = "
            WHERE
             pcs_id LIKE '%$this->filtro%' OR 
             pcs_responsavel       LIKE '%$this->filtro%' OR 
             pcs_telefone  LIKE '%$this->filtro%' OR 
             pcs_dataCriacao  LIKE '%$this->filtro%' OR 
             ps_tipoServico  LIKE '%$this->filtro%'
         " ;   
    }else{
        $where = ''; 
    }
    return $where; 
    }
    
    public function selectServico($dados){
        $this->pcsPCid = $dados['pcs_pc_id'];
        $this->pcsId = $dados['pcs_id'];
        $this->sql   = "SELECT * from {$this->tabela} AS PCS "
        . "INNER JOIN portaria_servicos AS PS ON PCS.pcs_ps_id = PS.ps_id       WHERE pcs_id = {$this->pcsId} AND pcs_pc_id = {$this->pcsPCid}  ";
        $this->Read()->FullRead($this->sql);
        $this->sets($this->Read()->getResult()[0]);   
    }   
}