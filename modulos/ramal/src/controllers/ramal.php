<?php

include_once ("../../../../Config.inc.php");
$Dados = (filter_input_array(INPUT_POST) != '') ? filter_input_array(INPUT_POST) : filter_input_array(INPUT_GET);
$acao = $Dados ['acao'];
$ramalAntigo = !empty($Dados['ramalAntigo']) ? $Dados['ramalAntigo'] : 0;
unset($Dados ['acao'], $Dados['ramalAntigo']);
$ramal = new Ramal ();

@session_start();

switch ($acao) {
    case "editar" :
    	
    	$resultado = 0;
    	if (!empty($Dados ['ramal_ramal']))
    		$resultado = $ramal->validarRamal($Dados ['ramal_ramal'], $ramalAntigo);
    	
    	if($resultado == 0 ){
    		
    		if ($ramal->atualizarRamal($Dados) == 1)
    			die(json_encode(array("msg" => "Registros alterados com sucesso.", "type"=>2)));
    		else
    			die(json_encode(array("msg" => "Erro ao alterar os dados.", "type"=>2)));
    		
    	}  else {
    		die(json_encode(array("msg" => "Já existe um funcionário cadastrado nesse ramal, por favor escolha outro!", "type"=>1)));
    	}
        break;

    case "autenticar" :
        $Dados["ramal_status_solicitacao"] = 1;
        $Dados['ramal_dt_solicitacao'] = date("Y-m-d H:i:s");
        $Dados['ramal_id_usuario'] = $_SESSION['user_info']['id_usuario'];
        $Dados['ramal_nivel_solicitacao'] = 2;

        $result = $ramal->autenticarRamal($Dados);

        if (!empty($result))
            die(json_encode(array("msg" => "Alteração enviada para autenticação.")));
        else
            die(json_encode(array("msg" => "Erro ao enviar os dados.")));
        break;
        
    case "autenticarCadastro" :
        $Dados["ramal_status_solicitacao"] = 1;
        $Dados['ramal_dt_solicitacao'] = date("Y-m-d H:i:s");
        $Dados['ramal_id_usuario'] = $_SESSION['user_info']['id_usuario'];
        $Dados['ramal_nivel_solicitacao'] = 1;

        $result = $ramal->autenticarRamal($Dados);

        if (!empty($result))
            die(json_encode(array("msg" => "Cadastro esperando aprovação.")));
        else
            die(json_encode(array("msg" => "Erro ao enviar os dados.")));
        break;

    case "inserir" :

        unset($Dados['ramal_id']);

    	$resultado = 0;
    	if (!empty($Dados ['ramal_ramal']))
    		$resultado = $ramal->validarRamal($Dados ['ramal_ramal'], $ramalAntigo);
    	 
    	if($resultado == 0 ){
    	
        $ramal->setDados($Dados);
	        if ($ramal->insert()) :
	            die(json_encode(array("msg" => "Registrado com Sucesso.")));
	        else :
	            die(json_encode(array("msg" => "Não foi possivel registra , favor tente novamente mais Tarde.")));
	        endif;
	        
    	} else {
    		die(json_encode(array("msg" => "Já existe um funcionário cadastrado nesse ramal, por favor escolha outro!", "type"=>1)));
    	}
    	
        break;

    case "deletarRamal" :
        $ramal->deleteRamal($Dados ['id']);
        die(json_encode(array("type" => 1)));
        break;


    case "Aprovar":
        $id = filter_input(INPUT_GET, "id");
        $ramalAtualizado = $ramal->selectAtualizacao($id);
        $nivel = $ramalAtualizado['ramal_nivel_solicitacao'];
        unset($ramalAtualizado['id'], $ramalAtualizado['ramal_dt_solicitacao'], $ramalAtualizado['ramal_status_solicitacao'], $ramalAtualizado['ramal_id_usuario'], $ramalAtualizado['ramal_nivel_solicitacao']);
        
        if($nivel == 1){
        	$ramal->setDados($ramalAtualizado);
        	$ramal->insert();
        	
        } else {
        	$ramal->atualizarRamal($ramalAtualizado);
        }
        
        $ramal->atualizarStatusAtualizacao($id, 3);
        header("Location: ../../../../index.php?pg=11&acao=atualizarRamal");
        break;

    case "Reprovar":
        $id = filter_input(INPUT_GET, "id");
        $ramal->atualizarStatusAtualizacao($id, 2);
        header("Location: ../../../../index.php?pg=11&acao=atualizarRamal");
        break;

    case "atualizarRamal":
        $atualizacao = $ramal->pegarAtualizacoesRamal($Dados['ramal_id']);
        $atualizacao['ramal_dt_solicitacao'] = Funcoes::formataDataComHora($atualizacao['ramal_dt_solicitacao']);
        $dadosAntigos = $ramal->selectRamalId($Dados['ramal_id']);
        foreach ($dadosAntigos as $k => $d) {
            if (isset($atualizacao[$k]) && $atualizacao[$k] == $d)
                unset($atualizacao[$k]);
        }

        $dadosAtualizacao['solicitante'] = $atualizacao['nome'];
        $dadosAtualizacao['data'] = $atualizacao['ramal_dt_solicitacao'];

        unset($atualizacao['id'], $atualizacao['ramal_id_usuario'], $atualizacao['ramal_status_solicitacao'], $atualizacao['nome'], $atualizacao['ramal_dt_solicitacao'], $dadosAntigos['ramal_id'], $dadosAntigos['ramal_dt_atualizacao']);

        die(json_encode(array("atualizacao" => $atualizacao, "dadosAntigos" => $dadosAntigos, "dadosAtualizacao" => $dadosAtualizacao)));
        break;

    case "excel":
        $listaRamais = $ramal->listRamal(null, null);

        $html = "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
				<style type='text/css'>
				table{font-size:10px ; font-family:Arial, Helvetica, sans-serif}
				</style>
		<table border='1' cellspacing='0' cellpadding='0' width='100%'>
			<thead>
				<tr>
					<td colspan='4' align='center'>&nbsp;</td>
				</tr>
				<tr>
					<th>Colaborador</th>
					<th>Ramal</th>
					<th>Telefone</th>
					<th>E-mail</th>
				</tr>
			</thead>
			<tbody>";

        foreach ($listaRamais as $r) {
            $html .= "<tr>
			<td>".utf8_encode($r['ramal_nome_usuario'])."</td>
			<td>{$r['ramal_ramal']}</td>
			<td>{$r['ramal_telefone']}</td>
			<td>{$r['ramal_email']}</td>
			</tr>";
        }

        $html .= "</tbody>
			</table>";
        Funcoes::exportExel($html, "Ramais.xls");
        break;
    case "buscarRamal":
    	$listaRamal = $ramal->listRamal(null, null, array("usuarioRamal"=>$Dados['texto']));
    	die(json_encode($listaRamal));
    	break;
}
