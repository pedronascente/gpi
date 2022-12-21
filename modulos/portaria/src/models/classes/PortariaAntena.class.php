<?php
class PortariaAntena extends PortariaIPAntena {
    protected $pa_tabela = 'portaria_antena';
    protected $pa_id;
    protected $pa_codigo;
    protected $pa_cliente;
    protected $pa_longitude;
    protected $pa_latitude;
    protected $pa_hostname;
    protected $pa_tipo_conexao;
    protected $pa_tipo_antena;
    protected $pa_wireless;
    protected $pa_security;
    protected $pa_encrypt;
    protected $pa_password;
    private $filtro;
            
    function getPa_id() {
        return $this->pa_id;
    }

    function getPa_codigo() {
        return $this->pa_codigo;
    }

    function getPa_cliente() {
        return $this->pa_cliente;
    }

    function getPa_longitude() {
        return $this->pa_longitude;
    }

    function getPa_latitude() {
        return $this->pa_latitude;
    }

    function getPa_hostname() {
        return $this->pa_hostname;
    }

    function getPa_tipo_conexao() {
        return $this->pa_tipo_conexao;
    }

    function getPa_tipo_antena() {
        return $this->pa_tipo_antena;
    }

    function getPa_wireless() {
        return $this->pa_wireless;
    }

    function getPa_security() {
        return $this->pa_security;
    }

    function getPa_encrypt() {
        return $this->pa_encrypt;
    }

    function getPa_password() {
        return $this->pa_password;
    }

    function setPa_id($pa_id) {
        $this->pa_id = $pa_id;
    }

    function setPa_codigo($pa_codigo) {
        $this->pa_codigo = $pa_codigo;
    }

    function setPa_cliente($pa_cliente) {
        $this->pa_cliente = $pa_cliente;
    }

    function setPa_longitude($pa_longitude) {
        $this->pa_longitude = $pa_longitude;
    }

    function setPa_latitude($pa_latitude) {
        $this->pa_latitude = $pa_latitude;
    }

    function setPa_hostname($pa_hostname) {
        $this->pa_hostname = $pa_hostname;
    }
 
    function setPa_tipo_conexao($pa_tipo_conexao) {
        $this->pa_tipo_conexao = $pa_tipo_conexao;
    }

    function setPa_tipo_antena($pa_tipo_antena) {
        $this->pa_tipo_antena = $pa_tipo_antena;
    }

    function setPa_wirelessv($pa_wirelessv) {
        $this->pa_wirelessv = $pa_wirelessv;
    }

    function setPa_security($pa_security) {
        $this->pa_security = $pa_security;
    }

    function setPa_encrypt($pa_encrypt) {
        $this->pa_encrypt = $pa_encrypt;
    }

    function setPa_password($pa_password) {
        $this->pa_password = $pa_password;
    }

    public function selectAntenas($dados){
           
        $limite = isset($dados ['limite']) ? " LIMIT {$dados['limite']}" : "";
        $this->pa_id = isset($dados ['pa_id']) ?$dados['pa_id'] :"";
        $this->filtro = isset($dados ['filtro']) ?$dados['filtro'] :"";;
        
        if($this->pa_id){
            $where  =" WHERE PA.pa_id = {$this->getPa_id()} ";
            $AND = "AND PA.pa_id={$this->pa_id} ";
        }else{
            $where = '';
            $AND ='';
        }
        
        if(!empty($this->filtro)){
            
            $this->sql = "SELECT PA.*,PIA.* FROM  {$this->pa_tabela} AS PA "
            . "left JOIN portaria_ip_antena  AS PIA ON  PA.pa_id = PIA.pia_pa_id  " . $this->getBuscarPor() . "  {$AND} GROUP BY PA.pa_id  ORDER BY PA.pa_id DESC  {$limite} " ;        
            }else{
            $this->sql = "SELECT PA.*,PIA.* FROM  {$this->pa_tabela} AS  PA left JOIN portaria_ip_antena  AS PIA ON  PA.pa_id = PIA.pia_pa_id   {$where}   GROUP BY PA.pa_id    ORDER BY PA.pa_id DESC    {$limite}";
        }
       
            
            $this->Read()->FullRead($this->sql);
    }
    public function selectAntenass($dados){
        
        $limite = isset($dados ['limite']) ? " LIMIT {$dados['limite']}" : "";
        $this->pa_id = isset($dados ['pa_id']) ?$dados['pa_id'] :"";
        $this->filtro = isset($dados ['filtro']) ?$dados['filtro'] :"";;
        
        if($this->pa_id){
            $where  =" WHERE PA.pa_id = {$this->getPa_id()} ";
        }else{
            $where = '';
        }
        
        if(!empty($this->filtro)){
            $this->sql = "SELECT PA.*,PIA.* FROM  {$this->pa_tabela} AS PA "
            . "left JOIN portaria_ip_antena  AS PIA ON  PA.pa_id = PIA.pia_pa_id  " . $this->getBuscarPor() . "  AND PA.pa_id={$this->pa_id}  GROUP BY PA.pa_id  ORDER BY PA.pa_id DESC  {$limite} " ;
        }else{
            $this->sql = "SELECT PA.*,PIA.* FROM  {$this->pa_tabela} AS  PA left JOIN portaria_ip_antena  AS PIA ON  PA.pa_id = PIA.pia_pa_id   {$where}   GROUP BY PA.pa_id    ORDER BY PA.pa_id DESC    {$limite}";
        }
       
            $this->Read()->FullRead($this->sql);
    }

    public function inserAntena($dados) {
        $this->Create()->ExCreate($this->pa_tabela, $dados);
        return $this->Create()->getResult();
    }
    
    //DELETE DB:
    public function deleteAntena($id) {
        
        if($this->deleteIPAntena($id)){
            $this->Delete()->ExDelete($this->pa_tabela, "WHERE pa_id = :id", "id={$id}");
            return $this->Delete()->getResult();
        }else{
            die('Não foi possivel deletar Arquivo ');
        }
    }
   
    public function UpdateAntena($dados){
        $this->pa_id =  $dados['pa_id']; 
        unset($dados['pa_id']);
        $this->Update()->ExUpdate($this->pa_tabela, $dados, "WHERE pa_id =:id ","id={$this->pa_id}");
        return $this->Update()->getResult();   
    }
    
    private function getBuscarPor(){
     if($this->filtro !==NULL){
         $where = "
            WHERE
             pa_codigo           LIKE '%$this->filtro%' OR 
             pa_cliente       LIKE '%$this->filtro%' OR 
             pa_longitude  LIKE '%$this->filtro%' OR 
             pa_latitude  LIKE '%$this->filtro%' OR 
             pa_hostname          LIKE '%$this->filtro%' OR
             pa_tipo_conexao           LIKE '%$this->filtro%' OR
             pa_tipo_antena     LIKE '%$this->filtro%' OR
             pa_wireless       LIKE '%$this->filtro%' OR
             pa_security       LIKE '%$this->filtro%' OR
             pa_encrypt       LIKE '%$this->filtro%' 
            
         " ;   

    }else{
        $where = ''; 
    }
    return $where; 
    }   
}