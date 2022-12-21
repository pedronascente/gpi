<?php

class Monitoramento extends Crud {

    private $sinistro_id;
    private $sinistro_cliente;
    private $sinistro_coordenador;
    private $sinistro_operador;
    private $sinistro_telefone;
    private $sinistro_data;
    private $sinistro_veiculo;
    private $sinistro_evento;
    private $sinistro_atendimento;
    private $sinistro_outro;
    private $sinistro_comunicante;
    private $sinistro_confirmacao_senha;
    private $sinistro_local_evento;
    private $sinistro_data_acao;
    private $sinistro_hora_acao;
    private $sinistro_uf;
    private $sinistro_bloqueio;
    private $sinistro_bloqueio_obs;
    private $sinistro_resgate;
    private $sinistro_ocorrencia;
    private $sinistro_bo;
    private $sinistro_contato;
    private $sinistro_endereco_recuperacao;
    private $sinistro_data_recuperacao;
    private $sinistro_hora_recuperacao;
    private $sinistro_fotos;
    private $sinistro_obs;
    private $sinistro_hora;
    private $sinistro_status;
    private $assistencia_id;
    private $assistencia_responsavel;
    private $assistencia_data;
    private $assistencia_guincho;
    private $assistencia_hora;
    private $assistencia_cliente;
    private $assistencia_veiculo;
    private $assistencia_solicitante;
    private $assistencia_confirmacao_senha;
    private $assistencia_solicitacao;
    private $assistencia_finalizacao;
    private $assistencia_local;
    private $assistencia_pagamento;
    private $assistencia_forma_pagamento;
    private $assistencia_cpfcnpj;
    private $assistencia_pagamento_titular;
    private $assistencia_pagamento_agencia;
    private $assistencia_pagamento_conta;
    private $assistencia_pagamento_banco;
    private $assistencia_obs;
    private $assistencia_protocolo;
    private $assistencia_status;
    private $assistencia_tipo_pessoa;
    private $assistencia_local_lat;
    private $assistencia_local_long;
    private $a_nome_cliente;
    private $a_id_cliente;
    private $a_nivel_cliente;
    private $a_placa_veiculo;
    private $a_id_veiculo;
    private $a_nivel_veiculo;
    private $a_nome_responsavel;
    private $a_cor_veiculo;
    private $a_marca_veiculo;
    private $a_modelo_veiculo;
    private $a_ano_veiculo;
    private $mc_id;
    private $mc_nome;
    private $mc_data;
    private $mc_telefone;
    private $mc_ra;
    private $mvc_id;
    private $mvc_placa;
    private $mvc_marca;
    private $mvc_modelo;
    private $mvc_cor;
    private $mvc_ano;
    private $mvc_id_cliente;
    private $guincho_id;
    private $guincho_uf;
    private $guincho_cidade;
    private $guincho_razao_social;
    private $guincho_endereco;
    private $guincho_cep;
    private $guincho_responsavel;
    private $guincho_atendimento;
    private $guincho_obs;
    private $guincho_local;
    private $guincho_latitude;
    private $guincho_longitude;
    private $guincho_credenciado;
    private $gpr_id;
    private $gpr_tipo_veiculos;
    private $gpr_condicao;
    private $gpr_guincho;
    private $contato_id;
    private $contato_nome;
    private $contato_telefone1;
    private $contato_telefone2;
    private $contato_telefone3;
    private $contato_email;
    private $contato_email2;
    private $contato_email3;
    private $contato_email4;
    private $lista;
    private $_sql;
    private $filtro;
    private $filtros = array(
        "guinchos" => array(
            "guincho_uf",
            "guincho_razao_social",
            "guincho_cidade",
            "guincho_endereco",
            "guincho_responsavel",
            "guincho_endereco",
            "guincho_responsavel",
            "guincho_obs"
        ),
        "sinistro" => array(
            "sinistro_coordeador",
            "sinistro_operador",
            "sinistro_telefone",
            "sinistro_comunicante",
            "sinistro_local_evento",
            "sinistro_hora_acao",
            "sinistro_hora",
            "sinistro_uf",
            "sinistro_endereco_recuperacao",
            "sinistro_hora_recuperacao",
            "sinistro_bo",
            "sinistro_obs",
            "mc_nome",
            "nome_cliente"
        ),
        "assistencia" => array(
            "assistencia_hora",
            "assistencia_solicitante",
            "assistencia_local",
            "assistencia_protocolo",
            "assistencia_obs",
            "nome_cliente",
            "nome",
            "mc_nome",
            "placa",
            "mvc_placa",
            "guincho_razao_social",
        )
    );

    // SETA OS ATRIBUTOS NO MESMO OBJETO
    public function setDados($Dados) {
        foreach ($Dados as $k => $d) {
            $this->$k = $d;
        }
    }

    // CRIA UM ARRAY DE OBJETOS E COLOCA NA LISTA
    public function setDadosLista($Dados) {
        $this->lista = array();

        if (!empty($Dados)) {
            foreach ($Dados as $k1 => $d) {
                $c = new Monitoramento();
                foreach ($d as $k2 => $dado) {
                    $c->set($k2, $dado);
                }
                $this->lista [$k1] = $c;
            }
        }
    }

    // SET E GET GENERICO
    public function set($key, $dado) {
        $this->$key = $dado;
    }

    public function get_assistencia_data() {
        return !empty($this->assistencia_data) ? Funcoes::formataData($this->assistencia_data) : "";
    }

    public function get_assistencia_finalizacao() {
        return !empty($this->assistencia_finalizacao) ? Funcoes::formataData($this->assistencia_finalizacao) : "";
    }

    public function get_assistencia_solicitacao() {
        $solicitacao = "";

        switch ($this->assistencia_solicitacao) {
            case 1: $solicitacao = "Socorro Mecânico";
                break;
            case 2: $solicitacao = "Reboque";
                break;
            case 3: $solicitacao = "Chaveiro";
                break;
            case 4: $solicitacao = "Troca de Pneu";
                break;
        }

        return $solicitacao;
    }

    public function get_assistencia_status() {
        $status = "";

        switch ($this->assistencia_status) {
            case "1": $status = "Em Aberto";
                break;
            case "2": $status = "Finalizado";
                break;
        }

        return $status;
    }

    public function get_sinistro_data() {
        return !empty($this->sinistro_data) ? Funcoes::formataData($this->sinistro_data) : "";
    }

    public function get_sinistro_data_recuperacao() {
        return !empty($this->sinistro_data_recuperacao) ? Funcoes::formataData($this->sinistro_data_recuperacao) : "";
    }

    public function get_sinistro_atendimento() {
        $atendimento = "";

        switch ($this->sinistro_atendimento) {
            case "1": $atendimento = "0800 646 5551";
                break;
            case "2": $atendimento = "Central Monitoramento 24h";
                break;
        }

        return $atendimento;
    }

    public function get_sinistro_evento() {
        $evento = "";

        switch ($this->sinistro_evento) {
            case "1": $evento = "Furto";
                break;
            case "2": $evento = "Roubo";
                break;
            case "3": $evento = "Outro";
                break;
        }

        return $evento;
    }

    public function get($key, $original = FALSE) {
        $metodo = "get_" . $key;

        if (method_exists($this, $metodo) && !$original)
            return $this->$metodo();
        else
            return $this->$key;
    }

    public function get_sinistro_resgate() {
        return !empty($this->sinistro_resgate) ? explode("-", $this->sinistro_resgate) : null;
    }

    public function insert($tabela, $Dados) {
        $this->Create()->ExCreate($tabela, $Dados);
        return $this->Create()->getResult();
    }

    public function selectGuincho($id) {
        $this->Read()->ExRead("guinchos", "WHERE guincho_id = {$id}");
        $this->setDados($this->limparArray($this->Read()->getResult()));
    }

    public function updateGuincho($Dados) {
        $this->Update()->ExUpdate("guinchos", $Dados, "WHERE guincho_id = {$Dados['guincho_id']}", null);
        return $this->Update()->getResult();
    }

    public function listarGuinchos($limite = null) {
        $limite = !empty($limite) ? "LIMIT {$limite}" : "";
        $this->Read()->ExRead("guinchos", "WHERE guincho_id = guincho_id {$this->filtro} {$limite}");
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function listarGuinchosArray() {
        $this->Read()->ExRead("guinchos", "WHERE guincho_id = guincho_id");
        return $this->Read()->getResult();
    }

    public function selectGuinchosProximos($latitude, $longitude) {
        $this->_sql = "SELECT 
						  g.guincho_id,
						  3956 * 2 * ASIN(
						    SQRT(
						      POWER(
						        SIN(
						          (
						            {$latitude} - guincho_latitude
						          ) * PI() / 180 / 2
						        ),
						        2
						      ) + COS({$latitude} * PI() / 180) * COS(guincho_latitude * PI() / 180) * POWER(
						        SIN(
						          (
						            {$longitude} - guincho_longitude
						          ) * PI() / 180 / 2
						        ),
						        2
						      )
						    )
						  ) AS distance 
						FROM
						  guinchos g 
						ORDER BY distance ASC 
						LIMIT 5";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function setFiltros($tabela, $busca) {
        $this->_filtro = $this->filtrar($this->filtros [$tabela], $busca);
    }

    public function getCondicoes($id_guincho, $limite = null) {
        $limite = !empty($limite) ? "LIMIT {$limite}" : "";
        $this->Read()->ExRead("guinchos_precos", "WHERE gpr_guincho = {$id_guincho} {$limite}");
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function deletarCondicao($id) {
        $this->Delete()->ExDelete("guinchos_precos", "WHERE gpr_id = {$id}", null);
        return $this->Delete()->getResult();
    }

    public function selectGuinchoPorPosicao($latitude, $longitude) {
        $this->Read()->ExRead("guinchos", "WHERE guincho_latitude = {$latitude} AND guincho_longitude = {$longitude}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function getContatosGuincho($id) {
        $this->Read()->ExRead("contato", "WHERE contato_id_cliente = {$id} AND contato_nivel = 3 ORDER BY contato_id DESC");
        return $this->Read()->getResult();
    }

    public function selectClientes($filtro = null) {
        $filtro1 = !empty($filtro) ? "AND c.nome_cliente like '{$filtro}%'" : "";
        $filtro2 = !empty($filtro) ? "WHERE mc.mc_nome like '{$filtro}%'" : "";
        $this->_sql = "
        			SELECT
        				busca.nome,
        				busca.id,
        				busca.nivel
        			FROM
        			(SELECT 
					  c.nome_cliente as nome,
					  c.id_cliente as id,
					  1 AS nivel 
					FROM
					  clientes c 
					WHERE c.cliente_ativo = 'on' {$filtro1}
					  AND nome_cliente != '' 
					UNION
					ALL 
					SELECT 
					  mc_nome as nome,
					  mc_id as id,
					  2 AS nivel 
					FROM
					  monitoramento_clientes mc {$filtro2}) as busca ORDER BY nome ASC";
        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function selectVeiculosCliente($id_cliente, $nivel) {

        if ($nivel == 1)
            $this->_sql = "SELECT 
							  id_veiculo AS id,
							  placa,
							  1 as nivel 
							FROM
							  veiculos 
							WHERE cliente_ra = {$id_cliente} 
							  AND placa != '' 
							UNION
							ALL 
							SELECT 
							  mvc_id AS id,
							  mvc_placa AS placa, 
							  2 as nivel
							FROM
							  monitoramento_clientes_veiculos mvc
							  WHERE mvc_cliente_ra = {$id_cliente}";
        else
            $this->_sql = "SELECT mvc_id as id, mvc_placa as placa, 2 as nivel FROM monitoramento_clientes_veiculos WHERE mvc_cliente = {$id_cliente}";

        $this->Read()->FullRead($this->_sql);
        return $this->Read()->getResult();
    }

    public function selectAssistencia($id) {
        $this->_sql = "SELECT 
						  a.*,
						  IF(a.`assistencia_cliente` != '', mc.`mc_nome`, c.`nome_cliente`) AS a_nome_cliente,
						  IF(a.`assistencia_cliente` != '', mc.`mc_id`, c.`id_cliente`) AS a_id_cliente,
						  IF(a.`assistencia_cliente` != '', 2,1) AS a_nivel_cliente,
						  IF(a.`assistencia_veiculo` != '', mvc.`mvc_id`, v.`id_veiculo`) AS a_id_veiculo,
						  IF(a.`assistencia_veiculo` != '', mvc.`mvc_placa`, v.`placa`) AS a_placa_veiculo,
						  IF(a.`assistencia_veiculo` != '', 2, 1) AS a_nivel_veiculo,
						  g.guincho_latitude,
						  g.guincho_longitude,
						  u.nome as a_nome_responsavel
						FROM
						  assistencia a 
						  LEFT JOIN clientes c 
						    ON a.`assistencia_ra` = c.id_cliente 
						  LEFT JOIN monitoramento_clientes mc 
						    ON a.`assistencia_cliente` = mc.`mc_id` 
						  LEFT JOIN veiculos v 
						    ON a.`assistencia_id_veiculo` = v.id_veiculo 
						  LEFT JOIN monitoramento_clientes_veiculos mvc 
						    ON a.`assistencia_veiculo` = mvc.`mvc_id`
						  LEFT JOIN guinchos g ON a.assistencia_guincho = g.guincho_id
						  LEFT JOIN usuarios u ON a.assistencia_responsavel = u.id
    					WHERE a.assistencia_id = {$id}";
        $this->Read()->FullRead($this->_sql);
        $this->setDados($this->limparArray($this->Read()->getResult()));
    }

    public function listaAssistencia($limite = null) {
        $limite = !empty($limite) ? "LIMIT {$limite}" : "";
        $this->_sql = "SELECT 
						  a.*,
						  IF(a.`assistencia_cliente` != '', mc.`mc_nome`, c.`nome_cliente`) AS a_nome_cliente,
						  IF(a.`assistencia_cliente` != '', mc.`mc_id`, c.`id_cliente`) AS a_id_cliente,
						  IF(a.`assistencia_cliente` != '', 2,1) AS a_nivel_cliente,
						  IF(a.`assistencia_veiculo` != '', mvc.`mvc_id`, v.`id_veiculo`) AS a_id_veiculo,
						  IF(a.`assistencia_veiculo` != '', mvc.`mvc_placa`, v.`placa`) AS a_placa_veiculo,
						  IF(a.`assistencia_veiculo` != '', 2, 1) AS a_nivel_veiculo,
						  g.guincho_latitude,
						  g.guincho_longitude,
    					  g.guincho_razao_social,
    					  u.nome as a_nome_responsavel
						FROM
						  assistencia a 
						  LEFT JOIN clientes c 
						    ON a.`assistencia_ra` = c.id_cliente 
						  LEFT JOIN monitoramento_clientes mc 
						    ON a.`assistencia_cliente` = mc.`mc_id` 
						  LEFT JOIN veiculos v 
						    ON a.`assistencia_id_veiculo` = v.id_veiculo 
						  LEFT JOIN monitoramento_clientes_veiculos mvc 
						    ON a.`assistencia_veiculo` = mvc.`mvc_id`
						  LEFT JOIN guinchos g ON a.assistencia_guincho = g.guincho_id
    					  LEFT JOIN usuarios u ON a.assistencia_responsavel = u.id ORDER BY assistencia_status ASC, assistencia_data DESC {$limite}";
        $this->Read()->FullRead($this->_sql);
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function listaSinistro($limite = null) {
        $limite = !empty($limite) ? "LIMIT {$limite}" : "";
        $this->_sql = "SELECT 
						  s.*,
						  IF(s.`sinistro_cliente` != '', mc.`mc_nome`, c.`nome_cliente`) AS a_nome_cliente,
						  IF(s.`sinistro_cliente` != '', mc.`mc_id`, c.`id_cliente`) AS a_id_cliente,
						  IF(s.`sinistro_cliente` != '', 2,1) AS a_nivel_cliente,
						  IF(s.`sinistro_veiculo` != '', mvc.`mvc_id`, v.`id_veiculo`) AS a_id_veiculo,
						  IF(s.`sinistro_veiculo` != '', mvc.`mvc_placa`, v.`placa`) AS a_placa_veiculo,
						  IF(s.`sinistro_veiculo` != '', 2, 1) AS a_nivel_veiculo,
						  u.nome as a_nome_responsavel
						FROM
						  sinistros s 
						  LEFT JOIN clientes c 
						    ON s.`sinistro_ra` = c.id_cliente 
						  LEFT JOIN monitoramento_clientes mc 
						    ON s.`sinistro_cliente` = mc.`mc_id` 
						  LEFT JOIN veiculos v 
						    ON s.`sinistro_id_veiculo` = v.id_veiculo 
						  LEFT JOIN monitoramento_clientes_veiculos mvc 
						    ON s.`sinistro_veiculo` = mvc.`mvc_id`
						  LEFT JOIN usuarios u
						  	ON s.sinistro_operador = u.id
						  ORDER BY sinistro_status ASC, sinistro_data DESC {$limite}";
        $this->Read()->FullRead($this->_sql);
        $this->setDadosLista($this->Read()->getResult());
        return $this->lista;
    }

    public function selectSinistro($id) {
        $this->_sql = "SELECT 
						  s.*,
						  IF(s.`sinistro_cliente` != '', mc.`mc_nome`, c.`nome_cliente`) AS a_nome_cliente,
						  IF(s.`sinistro_cliente` != '', mc.`mc_id`, c.`id_cliente`) AS a_id_cliente,
						  IF(s.`sinistro_cliente` != '', 2,1) AS a_nivel_cliente,
						  IF(s.`sinistro_veiculo` != '', mvc.`mvc_id`, v.`id_veiculo`) AS a_id_veiculo,
						  IF(s.`sinistro_veiculo` != '', mvc.`mvc_placa`, v.`placa`) AS a_placa_veiculo,
						  IF(s.`sinistro_veiculo` != '', mvc.`mvc_cor`, v.`cor`) AS a_cor_veiculo,
						  IF(s.`sinistro_veiculo` != '', mvc.`mvc_marca`, v.`marca`) AS a_marca_veiculo,
						  IF(s.`sinistro_veiculo` != '', mvc.`mvc_modelo`, v.`placa`) AS a_modelo_veiculo,
						  IF(s.`sinistro_veiculo` != '', mvc.`mvc_ano`, v.`ano`) AS a_ano_veiculo,
						  IF(s.`sinistro_veiculo` != '', 2, 1) AS a_nivel_veiculo
						FROM
						  sinistros s 
						  LEFT JOIN clientes c 
						    ON s.`sinistro_ra` = c.id_cliente 
						  LEFT JOIN monitoramento_clientes mc 
						    ON s.`sinistro_cliente` = mc.`mc_id` 
						  LEFT JOIN veiculos v 
						    ON s.`sinistro_id_veiculo` = v.id_veiculo 
						  LEFT JOIN monitoramento_clientes_veiculos mvc 
						    ON s.`sinistro_veiculo` = mvc.`mvc_id`
						 WHERE sinistro_id = {$id}";
        $this->Read()->FullRead($this->_sql);
        $this->setDados($this->limparArray($this->Read()->getResult()));
    }

    public function updateAssistencia($Dados) {
        $this->Update()->ExUpdate("assistencia", $Dados, "WHERE assistencia_id = {$Dados['assistencia_id']}", null);
        return $this->Update()->getResult();
    }

    public function updateSinistro($Dados) {
        $this->Update()->ExUpdate("sinistros", $Dados, "WHERE sinistro_id = {$Dados['sinistro_id']}", null);
        return $this->Update()->getResult();
    }

    public function deleteSinistro($id) {
        $this->Delete()->ExDelete("sinistros", "WHERE sinistro_id = {$id}", null);
        return $this->Delete()->getResult();
    }

    public function selectAssistenciaPorGuincho($id_guincho) {
        $this->Read()->ExRead("assistencia", "WHERE assistencia_guincho = {$id_guincho}");
        return $this->Delete()->getResult();
    }

    public function deleteGuincho($id) {
        $this->Delete()->ExDelete("guinchos", "WHERE guincho_id = {$id}", null);
        return $this->Delete()->getResult();
    }

    public function deleteAssistencia($id) {
        $this->Delete()->ExDelete("assistencia", "WHERE assistencia_id = {$id}", null);
        return $this->Delete()->getResult();
    }
    
    public function buscaVeiculos($busca){
    	$this->_sql = "SELECT 
						  c.nome_cliente,
						  c.`id_cliente`,
						  v.placa,
						  id_veiculo,
						  1 AS nivel 
						FROM
						  veiculos v 
						  INNER JOIN clientes c 
						    ON v.`cliente_ra` = c.`id_cliente` 
						WHERE placa LIKE '{$busca}%' 
						UNION
						ALL 
						SELECT 
						  c.nome_cliente,
						  c.`id_cliente`,
						  mvc.mvc_placa AS placa,
						  mvc.mvc_id AS id_veiculo,
						  1 AS nivel 
						FROM
						  monitoramento_clientes_veiculos mvc
						  INNER JOIN clientes c 
						    ON c.`id_cliente` = mvc.`mvc_cliente_ra` 
						WHERE mvc.mvc_placa LIKE '{$busca}%' 
						UNION
						ALL 
						SELECT 
						  mvc.mvc_cliente AS id_cliente,
						  mvc.`mvc_placa` AS placa,
						  mvc.`mvc_id` AS id_veiculo,
						  mc.mc_nome AS cliente,
						  2 AS nivel 
						FROM
						  monitoramento_clientes_veiculos mvc 
						  INNER JOIN monitoramento_clientes mc 
						    ON mvc.`mvc_cliente` = mc.mc_id 
						WHERE mvc.mvc_placa LIKE '{$busca}%' ";
    	$this->Read()->FullRead($this->_sql);
    	return $this->Read()->getResult();
    	
    }

}
