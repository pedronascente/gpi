<?php
class Condominio extends Crud {
    public  $sql;
    private $tabela = 'portaria_condominio';
    private $pcId;
    private $pcCodigo;
    private $pcDataCriacao;
    private $pcRazaoSocial;
    private $pcCep;
    private $pcUF;
    private $pcEndereco;
    private $pcNumero;
    private $pcCidade;
    private $pcBairro;
    private $pcComplemento;
    private $totalServico;
   
    /*
     ***************************
     * methods -> gets()
     ***************************
     */
    
    public function getTabela() {
        return $this->tabela;
    }

    public function getPcId() {
        return $this->pcId;
    }

    public function getPcCodigo() {
        return $this->pcCodigo;
    }

    public function getPcDataCriacao() {
        return $this->pcDataCriacao;
    }

    public function getPcRazaoSocial() {
        return $this->pcRazaoSocial;
    }

    public function getPcCep() {
        return $this->pcCep;
    }

    public function getPcUF() {
        return $this->pcUF;
    }

    public function getPcEndereco() {
        return $this->pcEndereco;
    }

    public function getPcNumero() {
        return $this->pcNumero;
    }

    public function getPcCidade() {
        return $this->pcCidade;
    }

    public function getPcBairro() {
        return $this->pcBairro;
    }

    public function getPcComplemento() {
        return $this->pcComplemento;
    }
    public function getTotalServicos() {
        return $this->totalServico;
    }
    
    /*
     ***************************
     * methods -> sets()
     ***************************
     */
    
    public function setTabela($tabela) {
        $this->tabela = $tabela;
        return $this;
    }

    public function setPcId($pcId) {
        $this->pcId = $pcId;
        return $this;
    }

    public function setPcCodigo($pcCodigo) {
        $this->pcCodigo = $pcCodigo;
        return $this;
    }

    public function setPcDataCriacao($pcDataCriacao) {
        $this->pcDataCriacao = $pcDataCriacao;
        return $this;
    }

    public function setPcRazaoSocial($pcRazaoSocial) {
        $this->pcRazaoSocial = $pcRazaoSocial;
        return $this;
    }

    public function setPcCep($pcCep) {
        $this->pcCep = $pcCep;
        return $this;
    }

    public function setPcUF($pcUF) {
        $this->pcUF = $pcUF;
        return $this;
    }

    public function setPcEndereco($pcEndereco) {
        $this->pcEndereco = $pcEndereco;
        return $this;
    }

    public function setPcNumero($pcNumero) {
        $this->pcNumero = $pcNumero;
        return $this;
    }

    public function setPcCidade($pcCidade) {
        $this->pcCidade = $pcCidade;
        return $this;
    }

    public function setPcBairro($pcBairro) {
        $this->pcBairro = $pcBairro;
        return $this;
    }

    public function setPcComplemento($pcComplemento) {
        $this->pcComplemento = $pcComplemento;
        return $this;
    }
    
    public function setTotalServicos($totalServico) {
        $this->totalServico = $totalServico;
        return $this;
    }
    
    /*
     ***************************
     * popula sets ()
     ***************************
     */
    public function sets($dados) {
        extract($dados);
        $this->setPcId($pc_id);
        $this->setPcCodigo($pc_codigo);
        $this->setPcDataCriacao($pc_dataCriacao);
        $this->setPcRazaoSocial($pc_razaoSocial);
        $this->setPcCep($pc_cep);
        $this->setPcUF($pc_uf);
        $this->setPcEndereco($pc_endereco);
        $this->setPcNumero($pc_numero);
        $this->setPcCidade($pc_cidade);
        $this->setPcBairro($pc_bairro);
        $this->setPcComplemento($pc_complemento);
        $this->setTotalServicos(!empty($pc_totalServico) ? $pc_totalServico :0);
    }
    
    //SELECIONA TODOS OS CONDOMINIOS EO TOTAL DE SERVIÇOS :
    public function select($dados,$buscarPor = null) {
        $limite = isset($dados ['limite']) ? " LIMIT {$dados['limite']}" : "";
        $this->filtro = $buscarPor;
        
        if($this->filtro !==NULL){
            $this->sql = "SELECT PC.*,COUNT(PCS.pcs_pc_id) AS pc_totalServico FROM  {$this->tabela} AS PC  LEFT JOIN portariacondominioservico  AS PCS ON PC.pc_id = PCS.pcs_pc_id   " . $this->getBuscarPor() . "   GROUP BY PC.pc_id    ORDER BY PC.pc_id DESC   {$limite}        "  ;
        }else{
            $this->sql = "SELECT PC.*,COUNT(PCS.pcs_pc_id) AS pc_totalServico FROM  {$this->tabela} AS PC  LEFT JOIN portariacondominioservico  AS PCS ON PC.pc_id = PCS.pcs_pc_id GROUP BY PC.pc_id    ORDER BY PC.pc_id DESC    {$limite}";
        }
        $this->Read()->FullRead($this->sql);
        return $this->Read()->getResult();
    }
    
    public function selectCondominio($id){
        $this->Read()->FullRead( "SELECT * from {$this->tabela} WHERE pc_id = {$id}  ");
        $this->sets($this->limparArray($this->Read()->getResult()));
    }
    
    //INSERT DB:
    public function insertCondominio($dados) {
        $this->Create()->ExCreate($this->tabela, $dados);
        return $this->Create()->getResult();
    }

    //DELETE DB:
    public function deleteCondominio($id) {
        $this->Delete()->ExDelete($this->tabela, "WHERE pc_id = :id", "id={$id}");
        return $this->Delete()->getResult();
    }

    private function getBuscarPor(){
     if($this->filtro !==NULL){
         $where = "
            WHERE
             pc_id           LIKE '%$this->filtro%' OR 
             pc_codigo       LIKE '%$this->filtro%' OR 
             pc_dataCriacao  LIKE '%$this->filtro%' OR 
             pc_razaoSocial  LIKE '%$this->filtro%' OR 
             pc_cep          LIKE '%$this->filtro%' OR
             pc_uf           LIKE '%$this->filtro%' OR
             pc_endereco     LIKE '%$this->filtro%' OR
             pc_numero       LIKE '%$this->filtro%' OR
             pc_cidade       LIKE '%$this->filtro%' OR
             pc_bairro       LIKE '%$this->filtro%' OR
             pc_complemento  LIKE '%$this->filtro%' 
         " ;   

    }else{
        $where = ''; 
    }
    return $where; 
    }
    
    public function verificaServico($id){
        $this->pcId  = $id;
        $this->sql = "SELECT PC.*,COUNT(PCS.pcs_pc_id) AS pc_totalServico FROM  {$this->tabela} AS PC  LEFT JOIN portariacondominioservico  AS PCS ON PC.pc_id = PCS.pcs_pc_id   where PC.pc_id = {$this->pcId}  GROUP BY PC.pc_id      ";
        $this->Read()->FullRead($this->sql);
        $this->sets($this->Read()->getResult()[0]);    
    }

    public function UpdateCondominio($dados) {
        $this->pcId =  $dados['pc_id']; 
        unset($dados['pc_id']);
        
        $this->Update()->ExUpdate($this->tabela, $dados, "WHERE pc_id = :id", "id={$this->pcId}");
        return $this->Update()->getResult();
    }
    
}