<?php

final class Arquivo extends Crud {

  private $_sql;

  /*
   * ****************************** 	
   * *********  ARQUIVOS **********
   * ******************************
   */

  public function insertArquivo($dados) {
    $this->Create()->ExCreate("arquivo", $dados);
    return $this->Create()->getResult();
  }

  public function deleteArquivo($id) {
    $this->Delete()->ExDelete("arquivo", "WHERE arquivo_id = {$id}", null);
    $this->Delete()->ExDelete("arquivo_log", "WHERE arquivo_log_arquivo = {$id}", null);
  }

  public function updateArquivo($dados) {
    $this->Update()->ExUpdate("arquivo", $dados, "WHERE arquivo_id = {$dados['arquivo_id']}", null);
    return $this->Update()->getResult();
  }

  public function selectArquivo($id) {
    $this->Read()->ExRead("arquivo", "WHERE arquivo_id = '{$id}'");
    return $this->limparArray($this->Read()->getResult());
  }

  public function select($limite, $filtros) {

  
    //$limite = !empty($limite) ? "LIMIT {$limite}" : "LIMIT 10";


    $limite = !empty($limite) ? "LIMIT {$limite}" : "LIMIT 100";

 


    $groupby = "GROUP BY arquivo_id";
    $where = "";


    if (!empty($filtros)) {

      if (isset($filtros['filtro'])) {

        if ($filtros['filtro'] == "cliente")
          $where = " AND nome_cliente like '%{$filtros['texto']}%'";
        else if ($filtros['filtro'] == "placa")
          $where = " AND placa like '%{$filtros['texto']}%'";
        else if ($filtros['filtro'] == "cpf_cnpj")
          $where = " AND cnpjcpf_cliente like '%{$filtros['texto']}%'";
        else if ($filtros['filtro'] == "arquivo")
          $where = " AND arquivo_armario_desc like '%{$filtros['texto']}%'";
        else if ($filtros['filtro'] == "gaveta")
          $where = " AND arquivo_gaveta_desc like '%{$filtros['texto']}%'";
        else if ($filtros['filtro'] == "pasta")
          $where = " AND arquivo_pasta like '%{$filtros['texto']}%'";
        else if ($filtros['filtro'] == "cpfcnpj")
          $where = " AND cnpjcpf_cliente = '{$filtros['texto']}'";
        else if ($filtros['filtro'] == "id_arquivo")
          $where = " AND arquivo_id = '{$filtros['texto']}'";

        if ($filtros['filtro'] == "placa")
          $groupby = "";
      }

      if (isset($filtros['id_gaveta']) && $filtros['id_gaveta'] != -1)
        $where .= " AND arquivo_gaveta_id = {$filtros['id_gaveta']}";
      if (isset($filtros['id_armario']) && $filtros['id_armario'] != -1)
        $where .= " AND arquivo_armario_id = {$filtros['id_armario']}";
    }

    $this->_sql = "SELECT 
                  SQL_CACHE a.*,
                  c.nome_cliente,
                  c.cnpjcpf_cliente,
                  ar.*,
                  g.*,
                  v.placa
                  FROM arquivo a 
                  INNER JOIN clientes c ON a.arquivo_cliente = c.id_cliente
                  LEFT JOIN veiculos v ON v.cliente_ra = c.id_cliente 
                  LEFT JOIN arquivo_gaveta g ON a.arquivo_gaveta = g.arquivo_gaveta_id
                  LEFT JOIN arquivo_armario ar ON g.arquivo_gaveta_armario = ar.arquivo_armario_id
                  WHERE arquivo_id = arquivo_id {$where} {$groupby} {$limite} ";

    //var_dump('wdwd',$this->_sql); die;                                
    $this->Read()->FullRead($this->_sql, null);
    return $this->Read()->getResult();
  }

  public function arquivoInsertGaveta($dados) {
    $this->Create()->ExCreate("arquivo_gaveta", $dados);
    return $this->Create()->getResult();
  }

  public function arquivoInsertArmario($dados) {
    $this->Create()->ExCreate("arquivo_armario", $dados);
    return $this->Create()->getResult();
  }

  public function arquivoDeleteArmario($id) {
    $this->Delete()->ExDelete("arquivo_armario", "WHERE arquivo_armario_id = {$id}", null);
    $this->Delete()->ExDelete("arquivo_gaveta", "WHERE arquivo_gaveta_armario = {$id}", null);
    $this->Delete()->getResult();
  }

  public function arquivoDeleteGaveta($id) {
    $this->Delete()->ExDelete("arquivo_gaveta", "WHERE arquivo_gaveta_id = {$id}", null);
    $this->Delete()->getResult();
  }

  public function selectArquivoGaveta($id) {
    $this->Read()->ExRead("arquivo_gaveta", "WHERE arquivo_gaveta_armario = {$id}");
    return $this->Read()->getResult();
  }

  public function selectArquivoGavetaTexto($texto, $arquivo) {
    $this->Read()->ExRead("arquivo_gaveta", "WHERE arquivo_gaveta_desc = {$texto} AND arquivo_gaveta_armario = {$arquivo}");
    return $this->Read()->getResult();
  }

  public function verificaPlaca($placa) {
    $this->Read()->ExRead("veiculos", "WHERE placa = '{$placa}' AND veiculo_status != 2");
    return $this->Read()->getResult();
  }

  public function selectArquivoArmario() {

    $this->Read()->FullRead("SELECT * from   arquivo_armario ");
    return $this->Read()->getResult();
  }

  public function selectArquivoArmarioTexto($texto) {
    $this->Read()->ExRead("arquivo_armario", "WHERE arquivo_armario_desc = {$texto}");
    return $this->Read()->getResult();
  }

  /*
   * *************************************
   * *********  ARQUIVOS PLACAS **********
   * *************************************
   */

  public function arquivoInsertPlaca($dados) {
    $this->Create()->ExCreate("arquivo_placas", $dados);
    return $this->Create()->getResult();
  }

  public function deletePlaca($id) {
    $this->Delete()->ExDelete("arquivo_placas", "WHERE arquivo_placas_id = {$id}", null);
    return $this->Delete()->getResult();
  }

  public function selectVeiculosArquivo($id_cliente) {
    $this->Read()->ExRead("arquivo_placas", "WHERE arquivo_placas_cliente = '{$id_cliente}'");
    return $this->Read()->getResult();
  }

  public function selectVeiculoJaCasdastrado($placa = null, $id_veiculo = null) {
    $placa = !empty($placa) ? "placa = '{$placa}'" : "";
    $id_veiculo = !empty($id_veiculo) ? "id_veiculo = {$id_veiculo}" : "";
    $status = !empty($placa) ? "AND veiculo_status != 2" : "";
    $this->_sql = "SELECT v.*, c.nome_cliente, c.cnpjcpf_cliente
    					FROM veiculos v
    					INNER JOIN clientes c ON v.cliente_ra = c.id_cliente
    					WHERE {$placa} {$id_veiculo} {$status}";
    $this->Read()->FullRead($this->_sql, null);
    return $this->limparArray($this->Read()->getResult());
  }

  /*
   * ***************************************
   * *********  ARQUIVOS CLIENTES **********
   * ***************************************
   */

  public function arquivoInsertCliente($dados) {
    $this->Create()->ExCreate("arquivo_clientes", $dados);
    return $this->Create()->getResult();
  }

  public function selectArquivoCliente($id_cliente) {
    $this->Read()->ExRead("arquivo_clientes", "WHERE arquivo_clientes_id = :id", "id={$id_cliente}");
    return $this->limparArray($this->Read()->getResult());
  }

  public function verificarCPFCNPJ($cpfcnjp) {
    $this->_sql = "SELECT a.*, c.id_cliente, c.nome_cliente FROM clientes c
        				LEFT JOIN arquivo a
        					ON c.id_cliente = a.arquivo_cliente
        				WHERE cnpjcpf_cliente = '{$cpfcnjp}'";
    $this->Read()->FullRead($this->_sql, null);
    return $this->limparArray($this->Read()->getResult());
  }

  /*
   * ***********************************
   * *********  ARQUIVOS LOGS **********
   * ***********************************
   */

  public function insertArquivoLog($dados) {
    $this->Create()->ExCreate("arquivo_log", $dados);
    return $this->Create()->getResult();
  }

  public function selectLog($id_arquivo, $id_log) {
    $limite = !empty($limite) ? "LIMIT {$limite}" : "";
    $arquivo = !empty($id_arquivo) ? "l.arquivo_log_arquivo = {$id_arquivo}" : "";
    $log = !empty($id_log) ? "l.arquivo_log_id = {$id_log}" : "";

    $this->_sql = "SELECT l.*, u.nome FROM arquivo_log l
						INNER JOIN usuarios u ON l.arquivo_log_supervisor = u.id
						WHERE {$arquivo} {$log} ORDER by arquivo_log_data {$limite}";
    $this->Read()->FullRead($this->_sql, null);
    return $this->Read()->getResult();
  }

  public function verficarArquivosLog($id_arquivo) {
    $this->Read()->ExRead("arquivo_log", "WHERE arquivo_log_arquivo = {$id_arquivo} AND arquivo_log_tipo = 2", null);
    return $this->Read()->getRowCount();
  }

  public function selectVeiculosPorCliente($id_cliente, $limite = NULL) {
    $limite = !empty($limite) ? "LIMIT {$limite}" : "";
    $this->_sql = "SELECT
    	v.placa,
    	v.cor,
    	v.ano,
    	v.modelo,
    	v.marca,
    	v.chassis,
    	v.renavam,
    	v.tipo_bateria,
    	v.id_veiculo,
    	v.id_cliente,
    	v.cliente_ra,
    	v.veiculo_status,
    	v.tipo_cadastro
    	FROM veiculos v
    	LEFT JOIN clientes cli ON v.id_cliente = cli.id_cliente
    	WHERE v.cliente_ra = {$id_cliente}{$limite}";
    $this->Read()->FullRead($this->_sql, null);
    return $this->Read()->getResult();
  }

}
