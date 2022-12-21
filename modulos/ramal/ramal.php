<?php
include_once(__DIR__ . "\bootstrap.php");
$Dados = filter_input_array(INPUT_POST);

if ($Dados == '') {
    $Dados = filter_input_array(INPUT_GET);
}

$acao = (!empty($Dados ['acao'])) ? $Dados ['acao'] : null;
unset($Dados ['x'], $Dados ['y'], $Dados ['acao']);

// OBJETO RAMAL.
$ramal = new Ramal ();
$listBase = $ramal->listBase(null);
$recepcao = in_array(array("tipo_permissao" => "recepcao"), $_SESSION['user_info']['permissoes']);
$recpcaoMaster = in_array(array("tipo_permissao" => "recepcaoMaster"), $_SESSION['user_info']['permissoes']);
$permissao = $recepcao || $recpcaoMaster;

$acaoRamal = $permissao ? "editar" : "autenticar";

$ramal->listPedidoAtuRamalId();
$total = $ramal->Read()->getRowCount();

$objPaginacao = new paginacao(10, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA;
$limite = $objPaginacao->limit();

$listaAtualizacoes = $ramal->listPedidoAtuRamalId($limite);

/*
 * ************************************************************************************
 * ********** RELATORIO QUE LISTA AS BASES E OS RAMAIS AGRUPADOS POR SETOR ************
 * ************************************************************************************
 */

switch ($acao) :
    case 'listarRamais' :
        include_once ("src/views/listas/lst_ramais.php");
    break;
    case 'buscarRamal' :
    	
        $ramal->listRamal(null, null, $Dados);
        $totalBusca = $ramal->Read()->getRowCount();
        $objPaginacaoBusca = new paginacao(10, $totalBusca, PAG, 10);
        $objPaginacaoBusca->_pagina = PAGINA."&acao=buscarRamal".Funcoes::getParametrosURL($Dados);
        $Dados['limite'] = $objPaginacao->limit();
        $listaRamal = $ramal->listRamal(null, null, $Dados);
        
        if(!empty($listaRamal)) { ?>
            <h1>Resultado da Pesquisa : </h1>
                 <table class="table table-bordered table-hover table-striped dataTableBootstrap">
                    <thead>
                        <tr>      
                            <th>NOME</th>
                            <th>RAMAL</th>
                            <th>TELEFONE</th>
                            <th>E-MAIL</th>
                            <th>BASE</th>
                            <th>SETOR</th>
                            <th width="5%">AÇ&Atilde;O</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($listaRamal as $K => $ramal){
                        ?>
                                <tr> 
                                    <td><?=$ramal['ramal_nome_usuario'];?></td> 
                                    <td><?=$ramal['ramal_ramal'];?></td> 
                                    <td><?=$ramal['ramal_telefone'];?></td> 
                                    <td><?=$ramal['ramal_email'];?></td> 
                                    <td><?=$ramal['base_nome'];?></td> 
                                    <td><?=$ramal['setor_local'];?></td>
                                    <td  align="center">

                                        <a  id="modulos/ramal/src/views/formularios/form.php?acao=<?=$acaoRamal;?>&id=<?=$ramal['ramal_id'];?>" class="botaoLoad modalOpen btn btn-sm btn-info" data-target="#modal">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>

                                    <?php if($recpcaoMaster){?>
                                       <a  id="<?=$ramal['ramal_id'];?>" class="deletarRamal btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> </a>
                                    <?php }?>
                                    </td>
                                </tr>
                                <?php 
                            }
                        ?>
                </tbody>
               </table>
	   <?php
	   $objPaginacaoBusca->MontaPaginacao();
       } else {
            Funcoes::Nregistro();
       }
    break;
	case 'atualizarRamal':
		include_once ("src/views/listas/lst_atualizacoesRamais.php");
		break;
endswitch;
?>
