<?php
class PedidoComissao extends Crud 
{
    private $_tabela = 'pedido_comissao';
    public $_sql;
    private $_filtros = "";
    private $_pedido_comissao_id;
    private $_pedido_comissao_id_usuario;
    private $_pedido_comissao_id_contrato;
    private $_pedido_comissao_data;
    private $_pedido_comissao_cliente;
    private $_pedido_comissao_comissao1;
    private $_pedido_comissao_comissao2;
    private $_pedido_comissao_comissao3;
    private $_pedido_comissao_servico;
    private $_pedido_comissao_captacao;
    private $_pedido_comissao_inst_venda;
    private $_pedido_comissao_mensal;
    private $_pedido_comissao_conta;
    private $_pedido_comissao_razao_social_nova;
    private $_pedido_comissao_razao_social_antiga;
    private $_pedido_comissao_equip_servico;
    private $_pedido_comissao_consultor;
    private $_pedido_comissao_n_os;
    private $_pedido_comissao_placa;
    private $_pedido_comissao_total_rastreadores;
    private $_pedido_comissao_status;
    private $_pedido_comissao_qtd_veiculo;
    private $_pedido_comissao_tx_instalacao;
    private $_pedido_comissao_desc_comissao;
    private $_pedido_comissao_obs_rastreamento;
    private $_pedido_comissao_id_cliente;
    private $_pedido_comissao_inconsistencia;
    private $_pedido_comissao_empresa;
    private $_pedido_comissao_reclamacao;        
    //inconsistencias
    private $_inconsistencias_id;
    private $_inconsistencias_supervisor_id;
    private $_inconsistencias_usuario_id;
    private $_inconsistencias_comissao_id;
    private $_inconsistencias_situacao;
    private $_inconsistencias_data_criacao;
    
    private $_usuario;
    private $_usuarioCadastro;
    private $_pcf_periodo;
    private $_cliente;
    private $_id;
    private $_pcf_arquivar;
    private $_nome;
    private $_pcf_nome;
    private $_pcf_status;
    
  
    public function get_tabela() {
        return $this->_tabela;
    }
    
    public function get_sql() {
        return $this->_sql;
    }

    public function get_pedido_comissao_id() {
        return $this->_pedido_comissao_id;
    }

    public function get_pedido_comissao_id_usuario() {
        return $this->_pedido_comissao_id_usuario;
    }

    public function get_pedido_comissao_id_contrato() {
        return $this->_pedido_comissao_id_contrato;
    }

    public function get_pedido_comissao_data() {
        return $this->_pedido_comissao_data;
    }

    public function get_pedido_comissao_cliente() {
        return $this->_pedido_comissao_cliente;
    }

    public function get_pedido_comissao_comissao1() {
        return $this->_pedido_comissao_comissao1;
    }

    public function get_pedido_comissao_comissao2() {
        return $this->_pedido_comissao_comissao2;
    }

    public function get_pedido_comissao_comissao3() {
        return $this->_pedido_comissao_comissao3;
    }

    public function get_pedido_comissao_servico() {
        return $this->_pedido_comissao_servico;
    }

    public function get_pedido_comissao_captacao() {
        return $this->_pedido_comissao_captacao;
    }

    public function get_pedido_comissao_inst_venda() {
        return $this->_pedido_comissao_inst_venda;
    }

    public function get_pedido_comissao_mensal() {
        return $this->_pedido_comissao_mensal;
    }

    public function get_pedido_comissao_conta() {
        return $this->_pedido_comissao_conta;
    }

    public function get_pedido_comissao_razao_social_nova() {
        return $this->_pedido_comissao_razao_social_nova;
    }

    public function get_pedido_comissao_razao_social_antiga() {
        return $this->_pedido_comissao_razao_social_antiga;
    }

    public function get_pedido_comissao_equip_servico() {
        return $this->_pedido_comissao_equip_servico;
    }

    public function get_pedido_comissao_consultor() {
        return $this->_pedido_comissao_consultor;
    }

    public function get_pedido_comissao_n_os() {
        return $this->_pedido_comissao_n_os;
    }

    public function get_pedido_comissao_placa() {
        return $this->_pedido_comissao_placa;
    }

    public function get_pedido_comissao_total_rastreadores() {
        return $this->_pedido_comissao_total_rastreadores;
    }

    public function get_pedido_comissao_status() {
        return $this->_pedido_comissao_status;
    }

    public function get_pedido_comissao_qtd_veiculo() {
        return $this->_pedido_comissao_qtd_veiculo;
    }

    public function get_pedido_comissao_tx_instalacao() {
        return $this->_pedido_comissao_tx_instalacao;
    }

    public function get_pedido_comissao_desc_comissao() {
        return $this->_pedido_comissao_desc_comissao;
    }

    public function get_pedido_comissao_obs_rastreamento() {
        return $this->_pedido_comissao_obs_rastreamento;
    }

    public function get_pedido_comissao_id_cliente() {
        return $this->_pedido_comissao_id_cliente;
    }

    public function get_pedido_comissao_inconsistencia() {
        return $this->_pedido_comissao_inconsistencia;
    }
        
    public function get_inconsistencias_id(){ 
        return  $this->_inconsistencias_id;
    }
    
    public function get_inconsistencias_supervisor_id(){ 
        return $this->_inconsistencias_supervisor_id;
    }
    
    public function get_inconsistencias_usuario_id(){	
        return $this->_inconsistencias_usuario_id;
    }
    
    public function get_inconsistencias_comissao_id(){
        return $this->_inconsistencias_comissao_id;
    }
    
    public function get_inconsistencias_situacao(){	
        return $this->_inconsistencias_situacao;
    }
    
    public function get_inconsistencias_data_criacao(){	
        return $this->_inconsistencias_data_criacao;
    }
    
    public function get_inconsistencias_DescSituacao(){	
        
        if ($this->_inconsistencias_situacao == 1) {
            return "Em Análise";
        } else if ($this->_inconsistencias_situacao == 2) {
            return"Liberada";
        } else if ($this->_inconsistencias_situacao == 3) {
            return "Reprovada";
        }            
    }
    
    public function get_usuario() {
        return $this->_usuario;
    }
    
    public function get_usuarioCadastro() {
        return $this->_usuarioCadastro ;
    }
    
     public function get_pcf_periodo() {
        return $this->_pcf_periodo;
    }
    
    public function get_id() {
        return $this->_id;
    }

    
    public function get_cliente() {
        return $this->_cliente;
    }
    
    public function get_situacao() {
        return $this->_situacao ;
    }
    
    public function get_pcf_arquivar() {
        return $this->_pcf_arquivar ;
    }
    
    public function get_nome() {
        return $this->_nome ;
    }
    
    public function get_pcf_nome() {
        return $this->_pcf_nome ;
    }
    public function get_pcf_status() {
        return $this->_pcf_status ;
    }
    
    public function get_pedido_comissao_empresa(){ 
        return $this->_pedido_comissao_empresa;
    }

    public function get_pedido_comissao_reclamacao(){ 
        return $this->_pedido_comissao_reclamacao ;
    }
    
    //sets  :  
    public function set_tabela($_tabela) {
        $this->_tabela = $_tabela;
    }

    public function set_sql($_sql) {
        $this->_sql = $_sql;
    }
    
    public function set_pedido_comissao_id($_pedido_comissao_id) {
        $this->_pedido_comissao_id = $_pedido_comissao_id;
    }

    public function set_pedido_comissao_id_usuario($_pedido_comissao_id_usuario) {
        $this->_pedido_comissao_id_usuario = $_pedido_comissao_id_usuario;
    }

    public function set_pedido_comissao_id_contrato($_pedido_comissao_id_contrato) {
        $this->_pedido_comissao_id_contrato = $_pedido_comissao_id_contrato;
    }

    public function set_pedido_comissao_data($_pedido_comissao_data) {
        $this->_pedido_comissao_data = date('d/m/Y', strtotime($_pedido_comissao_data));
    }

    public function set_pedido_comissao_cliente($_pedido_comissao_cliente) {
        $this->_pedido_comissao_cliente = $_pedido_comissao_cliente;
    }

    public function set_pedido_comissao_comissao1($_pedido_comissao_comissao1) {
        $this->_pedido_comissao_comissao1 = $_pedido_comissao_comissao1;
    }

    public function set_pedido_comissao_comissao2($_pedido_comissao_comissao2) {
        $this->_pedido_comissao_comissao2 = $_pedido_comissao_comissao2;
    }

    public function set_pedido_comissao_comissao3($_pedido_comissao_comissao3) {
        $this->_pedido_comissao_comissao3 = $_pedido_comissao_comissao3;
    }

    public function set_pedido_comissao_servico($_pedido_comissao_servico) {
        $this->_pedido_comissao_servico = $_pedido_comissao_servico;
    }

    public function set_pedido_comissao_captacao($_pedido_comissao_captacao) {
        $this->_pedido_comissao_captacao = $_pedido_comissao_captacao;
    }

    public function set_pedido_comissao_inst_venda($_pedido_comissao_inst_venda) {
        $this->_pedido_comissao_inst_venda = $_pedido_comissao_inst_venda;
    }

    public function set_pedido_comissao_mensal($_pedido_comissao_mensal) {
        $this->_pedido_comissao_mensal = $_pedido_comissao_mensal;
    }

    public function set_pedido_comissao_conta($_pedido_comissao_conta) {
        $this->_pedido_comissao_conta = $_pedido_comissao_conta;
    }

    public function set_pedido_comissao_razao_social_nova($_pedido_comissao_razao_social_nova) {
        $this->_pedido_comissao_razao_social_nova = $_pedido_comissao_razao_social_nova;
    }

    public function set_pedido_comissao_razao_social_antiga($_pedido_comissao_razao_social_antiga) {
        $this->_pedido_comissao_razao_social_antiga = $_pedido_comissao_razao_social_antiga;
    }

    public function set_pedido_comissao_equip_servico($_pedido_comissao_equip_servico) {
        $this->_pedido_comissao_equip_servico = $_pedido_comissao_equip_servico;
    }

    public function set_pedido_comissao_consultor($_pedido_comissao_consultor) {
        $this->_pedido_comissao_consultor = $_pedido_comissao_consultor;
    }

    public function set_pedido_comissao_n_os($_pedido_comissao_n_os) {
        $this->_pedido_comissao_n_os = $_pedido_comissao_n_os;
    }

    public function set_pedido_comissao_placa($_pedido_comissao_placa) {
        $this->_pedido_comissao_placa = $_pedido_comissao_placa;
    }

    public function set_pedido_comissao_total_rastreadores($_pedido_comissao_total_rastreadores) {
        $this->_pedido_comissao_total_rastreadores = $_pedido_comissao_total_rastreadores;
    }

    public function set_pedido_comissao_status($_pedido_comissao_status) {
        $this->_pedido_comissao_status = $_pedido_comissao_status;
    }

    public function set_pedido_comissao_qtd_veiculo($_pedido_comissao_qtd_veiculo) {
        $this->_pedido_comissao_qtd_veiculo = $_pedido_comissao_qtd_veiculo;
    }

    public function set_pedido_comissao_tx_instalacao($_pedido_comissao_tx_instalacao) {
        $this->_pedido_comissao_tx_instalacao = $_pedido_comissao_tx_instalacao;
    }

    public function set_pedido_comissao_desc_comissao($_pedido_comissao_desc_comissao) {
        $this->_pedido_comissao_desc_comissao = $_pedido_comissao_desc_comissao;
    }

    public function set_pedido_comissao_obs_rastreamento($_pedido_comissao_obs_rastreamento) {
        $this->_pedido_comissao_obs_rastreamento = $_pedido_comissao_obs_rastreamento;
    }

    public function set_pedido_comissao_id_cliente($_pedido_comissao_id_cliente) {
        $this->_pedido_comissao_id_cliente = $_pedido_comissao_id_cliente;
    }

    public function set_pedido_comissao_inconsistencia($_pedido_comissao_inconsistencia) {
        $this->_pedido_comissao_inconsistencia = $_pedido_comissao_inconsistencia;
    }
    
    public function set_inconsistencias_id($inconsistencias_id){	
        $this->_inconsistencias_id = $inconsistencias_id;}
    
    public function set_inconsistencias_supervisor_id($inconsistencias_supervisor_id){ 
        $this->_inconsistencias_supervisor_id = $inconsistencias_supervisor_id;}
    
    public function set_inconsistencias_usuario_id($inconsistencias_usuario_id){	
        $this->_inconsistencias_usuario_id = $inconsistencias_usuario_id;
    }
    
    public function set_inconsistencias_comissao_id($inconsistencias_comissao_id){
        $this->_inconsistencias_comissao_id = $inconsistencias_comissao_id;
    }
    
    public function set_inconsistencias_situacao($inconsistencias_situacao){
        $this->_inconsistencias_situacao = $inconsistencias_situacao;}
    
    public function set_inconsistencias_data_criacao($inconsistencias_data_criacao){
        $this->_inconsistencias_data_criacao = $inconsistencias_data_criacao;
    }
    
    public function set_usuario($usuario) {
       $this->_usuario = $usuario;
    }
    
    public function set_usuarioCadastro($usuarioCadastro) {
        return $this->_usuarioCadastro =$usuarioCadastro;
    }
    
    public function set_pcf_periodo($_pcf_periodo) {
        $this->_pcf_periodo = $_pcf_periodo;
    }
    
    public function set_cliente($_cliente) {
        $this->_cliente = $_cliente;
    }
    
    public function set_id($_id) {
        $this->_id = $_id;
    }
    
    public function set_situacao($_situacao) {
        $this->_situacao = $_situacao;
    }
    
    
    public function set_pcf_arquivar($pcf_arquivar) {
        $this->_pcf_arquivar = $pcf_arquivar ;
    }
    
    public function set_nome($nome) {
        $this->_nome = $nome ;
    }
    
    public function set_pcf_nome($_pcf_nome) {
       $this->_pcf_nome = $_pcf_nome ;
    }
    
    public function set_pcf_status($pcf_status) {
        return $this->_pcf_status  = $pcf_status;
    }

    public function set_pedido_comissao_empresa($pcf_empresa){ 
        return $this->_pedido_comissao_empresa = $pcf_empresa;
    }
    
    public function set_pedido_comissao_reclamacao($pcf_reclamacao){ 
        return $this->_pedido_comissao_reclamacao = $pcf_reclamacao;
    }
 
    public function sets($dados){
    	//var_dump($dados);
        $this->set_pedido_comissao_id(isset($dados['pedido_comissao_id']) ? $dados['pedido_comissao_id'] : NULL);
        $this->set_pedido_comissao_id_usuario(isset($dados['pedido_comissao_id_usuario']) ? $dados['pedido_comissao_id_usuario'] :NULL);
        $this->set_pedido_comissao_id_contrato(isset($dados['pedido_comissao_id_contrato']) ? $dados['pedido_comissao_id_contrato'] : NULL);
        $this->set_pedido_comissao_data(isset($dados['pedido_comissao_data'])?$dados['pedido_comissao_data']:NULL);
        $this->set_pedido_comissao_cliente(isset($dados['cliente'])? $dados['cliente'] : NULL);
        $this->set_pedido_comissao_comissao1(isset($dados['pedido_comissao_comissao1'])? $dados['pedido_comissao_comissao1']: NULL);
        $this->set_pedido_comissao_comissao2(isset($dados['pedido_comissao_comissao2'])? $dados['pedido_comissao_comissao2']: NULL);
        $this->set_pedido_comissao_comissao3(isset($dados['pedido_comissao_comissao3']) ? $dados['pedido_comissao_comissao3'] : NULL);
        $this->set_pedido_comissao_servico(isset($dados['pedido_comissao_servico']) ? $dados['pedido_comissao_servico'] : NULL);
        $this->set_pedido_comissao_captacao(isset($dados['pedido_comissao_captacao']) ? $dados['pedido_comissao_captacao'] : NULL);
        $this->set_pedido_comissao_inst_venda(isset($dados['pedido_comissao_inst_venda']) ? $dados['pedido_comissao_inst_venda']: NULL);
        $this->set_pedido_comissao_mensal(isset($dados['pedido_comissao_mensal'])? $dados['pedido_comissao_mensal'] : NULL);
        $this->set_pedido_comissao_conta(isset($dados['pedido_comissao_conta'])? $dados['pedido_comissao_conta'] : NULL);
        $this->set_pedido_comissao_razao_social_nova(isset($dados['pedido_comissao_razao_social_nova'])? $dados['pedido_comissao_razao_social_nova'] : NULL);
        $this->set_pedido_comissao_razao_social_antiga(isset($dados['pedido_comissao_razao_social_antiga'])? $dados['pedido_comissao_razao_social_antiga'] : NULL);
        $this->set_pedido_comissao_equip_servico(isset($dados['pedido_comissao_equip_servico'])? $dados['pedido_comissao_equip_servico'] : NULL);
        $this->set_pedido_comissao_consultor(isset($dados['pedido_comissao_consultor']) ? $dados['pedido_comissao_consultor'] :NULL);
        $this->set_pedido_comissao_n_os(isset($dados['pedido_comissao_n_os']) ?$dados['pedido_comissao_n_os'] :NULL );
        $this->set_pedido_comissao_placa(isset($dados['pedido_comissao_placa']) ? $dados['pedido_comissao_placa'] : NULL);
        $this->set_pedido_comissao_total_rastreadores(isset($dados['pedido_comissao_total_rastreadores']) ? $dados['pedido_comissao_total_rastreadores'] : NULL);
        $this->set_pedido_comissao_status(isset($dados['pedido_comissao_status']) ? $dados['pedido_comissao_status'] : NULL);
        $this->set_pedido_comissao_qtd_veiculo(isset($dados['pedido_comissao_qtd_veiculo']) ? $dados['pedido_comissao_qtd_veiculo'] : NULL);
        $this->set_pedido_comissao_tx_instalacao(isset($dados['pedido_comissao_tx_instalacao'])? $dados['pedido_comissao_tx_instalacao'] : NULL);
        $this->set_pedido_comissao_desc_comissao(isset($dados['pedido_comissao_desc_comissao'])? $dados['pedido_comissao_desc_comissao'] : NULL);
        $this->set_pedido_comissao_obs_rastreamento(isset($dados['pedido_comissao_obs_rastreamento'])? $dados['pedido_comissao_obs_rastreamento']: NULL);
        $this->set_pedido_comissao_id_cliente(isset($dados['pedido_comissao_id_cliente'])? $dados['pedido_comissao_id_cliente']: NULL);         
        $this->set_pedido_comissao_empresa(isset($dados['pedido_comissao_empresa'])? $dados['pedido_comissao_empresa'] :NULL);    
        $this->set_pedido_comissao_reclamacao(isset($dados['pedido_comissao_reclamacao'])? $dados['pedido_comissao_reclamacao'] :NULL);
        $this->set_pedido_comissao_inconsistencia(isset($dados['pedido_comissao_inconsistencia'])? $dados['pedido_comissao_inconsistencia'] :NULL); 
        $this->set_inconsistencias_id(isset($dados['inconsistencias_id'])?$dados['inconsistencias_id']:NULL);
        $this->set_inconsistencias_supervisor_id(isset($dados['inconsistencias_supervisor_id'])?$dados['inconsistencias_supervisor_id']:NULL);
        $this->set_inconsistencias_usuario_id(isset($dados['inconsistencias_usuario_id'])?$dados['inconsistencias_usuario_id']:NULL);
        $this->set_inconsistencias_comissao_id(isset($dados['inconsistencias_comissao_id'])? $dados['inconsistencias_comissao_id'] : NULL);
        $this->set_inconsistencias_situacao(isset($dados['inconsistencias_situacao'])?$dados['inconsistencias_situacao']:NULL);
        $this->set_inconsistencias_data_criacao(isset($dados['inconsistencias_data_criacao'])?$dados['inconsistencias_data_criacao']:NULL );
        $this->set_usuario(isset($dados['usuario'])?$dados['usuario']:NULL );
        $this->set_usuarioCadastro(isset($dados['usuarioCadastro'])?$dados['usuarioCadastro']:NULL );
        $this->set_cliente(isset($dados['cliente'])?$dados['cliente']:NULL );
        $this->set_id(isset($dados['id'])?$dados['id']:NULL );
        $this->set_situacao(isset($dados['situacao'])?$dados['situacao']:NULL );
        $this->set_pcf_arquivar(isset($dados['pcf_arquivar'])?$dados['pcf_arquivar']:NULL );
        $this->set_nome(isset($dados['nome'])?$dados['nome']:NULL );
        $this->set_pcf_nome(isset($dados['usuario'])?$dados['usuario']:NULL );
        $this->set_pcf_status(isset($dados['pcf_status'])?$dados['pcf_status']:NULL );
        $this->set_pcf_periodo(isset($dados['pcf_periodo'])?$dados['pcf_periodo']:NULL );
    }

    public function insert($dados) {
        $this->Create()->ExCreate($this->_tabela, $dados);
        return $this->Create()->getResult();
    }

    public function updatePedidoComissao($dados) {
        $this->Update()->ExUpdate($this->_tabela, $dados, "WHERE pedido_comissao_id = :id", "id={$dados['pedido_comissao_id']}");
        return $this->Update()->getResult();
    }

    public function select($dados) 
    {
        $limite = isset($dados ['limite']) ? " LIMIT {$dados['limite']}" : "";
        $this->_sql = "
        SELECT * FROM pedidoscomissaoselect 
        WHERE pedido_comissao_id_usuario = {$dados['id_usuario']} {$this->_filtros} GROUP BY pedido_comissao_id {$limite}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function getPedidoComissaoPorPlanilha($id_planilha) {
        $this->_sql = "SELECT 
        p.*,
        pcf.pcf_ano,
        pcf.pcf_periodo,
        pcf.pcf_id_supervisor,
        u.nome AS usuarioCadastro, 
        i.*,
        IF(pcf.pcf_nome = '', us.nome, pcf.pcf_nome) as usuario,
        IF(p.pedido_comissao_cliente = '', c.nome_cliente, p.pedido_comissao_cliente) as cliente
        FROM
        pedido_comissao p 
        INNER JOIN pedido_comissao_funcionario pcf 
          ON p.pedido_comissao_id_usuario = pcf.pcf_id 
        INNER JOIN usuarios u 
          ON pcf.pcf_id_supervisor = u.id 
        LEFT JOIN usuarios us 
          ON pcf.pcf_id_usuario = us.id 
        LEFT JOIN clientes c
              ON p.pedido_comissao_id_cliente = c.id_cliente
        LEFT JOIN inconsistencias i
              ON p.pedido_comissao_id = i.comissao_id
        WHERE pedido_comissao_id_usuario = {$id_planilha} AND (i.situacao IS NULL OR i.situacao<2)";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }
    
    public function getComissoesPlanilha($id_planilha){
    	$this->Read()->ExRead($this->_tabela, "WHERE pedido_comissao_id_usuario = {$id_planilha}");
    	return $this->Read()->getResult();
    }

    public function deletePedidoComissao($id) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE pedido_comissao_id = :id", "id={$id}");
        return $this->Delete()->getResult();
    }

    public function deletePorIdUsuario($id) {
        $this->Delete()->ExDelete($this->_tabela, "WHERE pedido_comissao_id_usuario = {$id}", null);
        return $this->Delete()->getResult();
    }

    public function selectIdPedidoComissao($id) {
        $this->_sql = "SELECT p.*,IF(c.nome_cliente IS NULL OR c.nome_cliente = '', p.pedido_comissao_cliente, c.nome_cliente) as cliente FROM pedido_comissao p
        LEFT JOIN clientes c ON p.pedido_comissao_id_cliente = c.id_cliente
        WHERE pedido_comissao_id = {$id}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->sets($this->limparArray($this->Read()->getResult()));
    }
    
    public function selectIdPedidoComissaoArray($id) {
        $this->_sql = "SELECT p.*,IF(c.nome_cliente IS NULL OR c.nome_cliente = '', p.pedido_comissao_cliente, c.nome_cliente) as cliente FROM pedido_comissao p
        LEFT JOIN clientes c ON p.pedido_comissao_id_cliente = c.id_cliente
        WHERE pedido_comissao_id = {$id}";
        $this->Read()->FullRead($this->_sql, null);
        return $this->limparArray($this->Read()->getResult());
    }


   //aquidebug99
    public function listar($status, $datas, $limite = NULL) {
        $limite = !empty($limite) ? "LIMIT {$limite}" : "LIMIT 2000";
        $dataInicial = !empty($datas['dt_inicial']) ? "AND pedido_comissao_data >='".Funcoes::formataDataSql($datas['dt_inicial'])." 00:00:00'" : "";
        $dataFinal = !empty($datas['dt_final']) ? "AND pedido_comissao_data <='".Funcoes::formataDataSql($datas['dt_final'])." 23:59:59'" : "";

        $sql = "";
        if(!empty($status)){
            switch ($status){
                case "arquivados": $sql = "AND pcf_arquivar = 1"; break;
                case "conferencia" ; $sql =  "AND pcf_status >= 1 AND pcf_arquivar = 0"; break;
            }
        }
        $this->_sql = "SELECT  pc.*, pcf.*,
            IF(pcf.pcf_nome = '', u.nome, pcf.pcf_nome) AS usuario,
            IF(pc.pedido_comissao_cliente = '', c.nome_cliente, pc.pedido_comissao_cliente) AS cliente    
        
            FROM pedido_comissao AS pc

            LEFT JOIN contratos  ON  pc.pedido_comissao_id_contrato = contratos.id_contrato
            LEFT JOIN clientes c ON  contratos.id_cliente = c.id_cliente
            INNER JOIN pedido_comissao_funcionario AS pcf  ON pc.pedido_comissao_id_usuario = pcf.pcf_id 
            INNER JOIN usuarios u ON pcf.pcf_id_supervisor = u.id 
            LEFT JOIN usuarios us  ON pcf.pcf_id_usuario = us.id 

        WHERE pcf_id = pcf_id {$this->_filtros} {$sql} {$dataInicial} {$dataFinal}
        ORDER BY pc.pedido_comissao_data DESC {$limite} ";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }
    
    
    /*
     * ************************************ 
     * ********* INCONSISTÃŠNCIAS ********* 
     * ************************************ 
     */
    //O mÃ©todo pega as inconsistÃªncia gerais do usuÃ¡rios, de uma planilha especifica ou todas dependendo dos parametros passados
    public function listaInconsistencia($placa, $conta, $data, $status, $historico, $id_planilha, $limite, $filtros) {
        $limite = !empty($limite) ? "LIMIT {$limite}" : "";
        $total = ", COUNT(*) AS total, IF (pedido_comissao_comissao1 IS NOT NULL, pedido_comissao_comissao1, 0) AS pedido_comissao_comissao1,
        IF (pedido_comissao_comissao2 IS NOT NULL, pedido_comissao_comissao2, 0) AS pedido_comissao_comissao2,
        IF (pedido_comissao_comissao3 IS NOT NULL, pedido_comissao_comissao3, 0) AS pedido_comissao_comissao3";
        $totalFinal = " , SUM(pedido_comissao_comissao1 + pedido_comissao_comissao2 + pedido_comissao_comissao3) AS soma, f.total";
        $conta = !empty($conta) ? " AND pedido_comissao_conta = '{$conta}'" : ($historico ? "" : " AND pedido_comissao_conta =''");
        $placa = !empty($placa) ? " AND pedido_comissao_placa = '{$placa}'  " : ($historico ? "" : " AND pedido_comissao_placa = ''" );
        $data = !empty($datas) ? " AND pedido_comissao_data BETWEEN DATE_SUB('{$data}', INTERVAL 3 MONTH) AND DATE_ADD('{$data}', INTERVAL 1 MONTH)" : "";
        $id_planilha = !empty($id_planilha) ? " OR pcf_id=" . $id_planilha : "";
        $status = !empty($status) ? " AND ((pcf_id={$status} AND situacao<=1) OR pcf_id !={$status})" : "";
        $joinInconsistencia = $historico ? "INNER" : "LEFT";
        $count = !$historico ? "HAVING (COUNT(pedido_comissao_id) > 1)" : "";
        $busca = "";
        if (!empty($filtros['filtro']) && !empty($filtros['texto'])) {
            if ($filtros['filtro'] == "Conta") {
                $busca = "AND pedido_comissao_conta LIKE '%{$filtros['texto']}%'";
            } else if ($filtros['filtro'] == "Placa") {
                $busca = "AND pedido_comissao_placa LIKE '%{$filtros['texto']}%'";
            }
        }
        $this->_sql = "SELECT 
						  f.pedido_comissao_conta,
						  f.pedido_comissao_placa,
						  f.nivel,
						  IF(f.nivel = 2, pedido_comissao_conta, pedido_comissao_placa) as conta_placa,
						  f.pedido_comissao_data
						  {$totalFinal}
						FROM
						  (SELECT 
						    pedido_comissao_conta,
						    pedido_comissao_placa,
						    2 as nivel,
						    pedido_comissao_data
						    {$total}
						  FROM
						    pedido_comissao p 
						    INNER JOIN pedido_comissao_funcionario pcf 
						      ON p.pedido_comissao_id_usuario = pcf.`pcf_id` 
						    LEFT JOIN usuarios u 
						      ON pcf.`pcf_id_usuario` = u.`id`
						    {$joinInconsistencia} JOIN inconsistencias i
						  		ON p.pedido_comissao_id = comissao_id
						  WHERE pedido_comissao_conta <> '' 
						    AND pedido_comissao_conta IS NOT NULL 
						     {$conta}
						   	 {$data}
						   	 {$busca}
						    AND (pcf_status >= 1 {$id_planilha})
						  GROUP BY pedido_comissao_conta 
						 {$count}
						  UNION
						  ALL 
						  SELECT 
						    pedido_comissao_conta,
						    pedido_comissao_placa,
						    1 as nivel,
						    pedido_comissao_data
						    {$total}
						  FROM
						    pedido_comissao p 
						    INNER JOIN pedido_comissao_funcionario pcf 
						      ON p.pedido_comissao_id_usuario = pcf.`pcf_id` 
						    LEFT JOIN usuarios u 
						      ON pcf.`pcf_id_usuario` = u.`id`
						    {$joinInconsistencia} JOIN inconsistencias i
						  		ON p.pedido_comissao_id = comissao_id 
						  WHERE pedido_comissao_placa <> '' 
						    AND pedido_comissao_placa IS NOT NULL 
						    {$placa}
						   	{$data}
						   	{$busca}
						   AND (pcf_status >= 1 {$id_planilha}) {$status}
						  GROUP BY pedido_comissao_placa
						  {$count}) AS f 
						  GROUP by f.nivel, pedido_comissao_conta, pedido_comissao_placa
						 ORDER by f.pedido_comissao_data {$limite}";
                                                 
       
        
        $this->Read()->FullRead($this->_sql, null);
        
        
        return $this->Read()->getResult();
    }

    public function getInconsistencias($placa, $conta, $planilha, $datas = NULL) {
        $placa = !empty($placa) ? " pedido_comissao_placa = '{$placa}'" : "";
        $conta = !empty($conta) ? " pedido_comissao_conta = '{$conta}'" : "";
        $join = $planilha ? "LEFT" : "INNER";
        $where = $planilha ? " AND pedido_comissao_data BETWEEN DATE_SUB('{$datas}', INTERVAL 3 MONTH) 
																		AND '{$datas}' 
																		AND (pcf_status >= 1) " : "";
        $this->_sql = "SELECT 
        p.pedido_comissao_id,
        p.pedido_comissao_servico,
        p.pedido_comissao_n_os,
        p.pedido_comissao_id_usuario,
        pedido_comissao_placa,
        pedido_comissao_data,
        pcf.pcf_id_supervisor,
        i.*,
        IF (i.situacao IS NOT NULL, i.data_criacao , pedido_comissao_conta) as conta_placa,
        IF (u.nome IS NULL, supervisor.nome, u.nome) as usuarioCadastro,
        IF (p.pedido_comissao_cliente IS NULL OR  p.pedido_comissao_cliente = '', c.nome_cliente,  p.pedido_comissao_cliente) as cliente,
        IF(pcf.pcf_nome = '', us.nome, pcf.pcf_nome) as nomeFuncionario,
        us.nome as supervisor,
        SUM(
          IF (
            pedido_comissao_comissao1 IS NOT NULL,
            pedido_comissao_comissao1,
            0
          ) + IF (
            pedido_comissao_comissao2 IS NOT NULL,
            pedido_comissao_comissao2,
            0
          ) + IF (
            pedido_comissao_comissao3 IS NOT NULL,
            pedido_comissao_comissao3,
            0
          )
        ) AS comissao, 
        IF(pcf.pcf_nome = '', us.nome, pcf.pcf_nome) as usuario,
        pcf.pcf_periodo,
        pcf.pcf_ano
        FROM
        pedido_comissao p 
        INNER JOIN pedido_comissao_funcionario pcf 
          ON p.pedido_comissao_id_usuario = pcf.pcf_id 
        {$join} JOIN inconsistencias i
              ON p.pedido_comissao_id = comissao_id
        LEFT JOIN usuarios us
              ON i.supervisor_id = us.id
        LEFT JOIN usuarios u
              ON i.usuario_id = u.id
        LEFT JOIN usuarios supervisor
              ON pcf.pcf_id_supervisor = supervisor.id
        LEFT JOIN clientes c
              ON p.pedido_comissao_id_cliente = c.id_cliente
        WHERE ({$conta}{$placa}) {$where}
        GROUP BY pedido_comissao_id";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }

    public function insertInconsistencia($dados) {
        $this->Create()->ExCreate("inconsistencias", $dados);
        return $this->Create()->getResult();
    }
    
    public function getInconsistencia($id_comissao) {
        $this->Read()->ExRead("inconsistencias", "WHERE comissao_id = {$id_comissao}", null);
        return $this->limparArray($this->Read()->getResult());
    }

    public function updateInconsistencia($dados) {
        $this->Update()->ExUpdate("inconsistencias", $dados, "WHERE id = {$dados['id']}", null);
        return $this->Update()->getResult();
    }

    public function contarComissoes($id_planilha) {
        $this->Read()->ExRead("pedido_comissao", "WHERE pedido_comissao_id_usuario = {$id_planilha}", null);
        return $this->Read()->getRowCount();
    }
    
    public function deleteInconsistencias($id_comissao){
    	$this->Delete()->ExDelete("inconsistencias", "WHERE comissao_id = {$id_comissao}", null);
    	return $this->Delete()->getResult();
    }

	public function setFiltros($busca, $campo_novo =''){
		    $campos  = 
			array("pedido_comissao_cliente", 
					"nome_cliente", 
                    "pedido_comissao_id_contrato", 
					"pedido_comissao_captacao", 
					"pedido_comissao_servico", 
					"pedido_comissao_obs_rastreamento", 
					"pedido_comissao_placa", 
					"pedido_comissao_conta", 
					"pedido_comissao_n_os", 
					"pedido_comissao_comissao1", 
					"pedido_comissao_comissao2", 
					"pedido_comissao_comissao3"
            );

            if(!empty($campo_novo)){
                array_push($campos,$campo_novo);
            }    

		$this->_filtros = $this->filtrar($campos, $busca);
	}
	
	public function gerarComissoes($id_usuario, $dataInicial, $dataFinal){
		$this->_sql = "SELECT 
						  c.*
						FROM
						  contratos  c
						  INNER JOIN clientes cli 
						    ON c.id_cliente = cli.id_cliente 
						  LEFT JOIN pedido_comissao pc
						  	ON c.id_contrato = pc.pedido_comissao_id_contrato  
						WHERE c.id_contrato > 0 
						  AND c.data_contrato_gerado>='{$dataInicial}' AND c.data_contrato_gerado<='{$dataFinal}'
						  AND c.observacoes_contrato = 'ok' 
						  AND c.id_usuario = {$id_usuario}
						  AND pc.pedido_comissao_id IS NULL
						GROUP BY c.id_contrato";
		$this->Read()->FullRead($this->_sql);
		return $this->Read()->getResult();
	}
    	
}
