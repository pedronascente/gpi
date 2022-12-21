<?php

$DadosGet     = filter_input_array(INPUT_GET);//VARIAVEIS DA URL
$acao         = (!empty($DadosGet['acao'])) ? $DadosGet['acao'] : '';
$buscarPor    = (!empty($DadosGet['buscarPor'])) ? $DadosGet['buscarPor'] : '';
$idCondominio = !empty($DadosGet['id']) ?$DadosGet['id'] :'';
$idPCSservico = !empty($DadosGet['idS']) ?$DadosGet['idS'] :'';
$idAntena     = !empty($DadosGet['idA']) ?$DadosGet['idA'] :'';


$acao_Dofrm_cadastraCondominio = 'insertCondominio';
$acao_Dofrm_cadastraAntena = 'insertAntena';
$acao_Dofrm_cadastraServico = 'insertServico';
$submit_Dofrm = 'SALVAR';
$_disabledCampoDofrm_cadastraServico = '';

//CASO TENHA UM CONDOMINIO REGISTRADO É DISPONIVEL A ABA DE SERVIÇO:
$valorClasse = !empty($idCondominio) ? $idCondominio : 'display:none';

##########################
#      Debug URL :       #
##########################

//var_dump($DadosGet);
//var_dump($_REQUEST);

/*
 ***********************************
 *********** CONDOMINIOS ***********
 ***********************************
 */
$portariaCondominio = new Condominio;

//TOTAL DE CONDOMINIO NA BD :
$portariaCondominio->select(NULL);
$totalCondominio = $portariaCondominio->Read()->getRowCount();

//LISTA OS CONDOMINIOS COM PAGINAÇÃO :
$objPaginacaoCondominio = new paginacao(10,$totalCondominio, PAG, 10);
$objPaginacaoCondominio->_pagina = PAGINA;
$limiteCondominio = $objPaginacaoCondominio->limit();

if($acao=='pesquisaCondominio' && $buscarPor !==  NULL){
    $listCondominios = $portariaCondominio->select($limiteCondominio, $buscarPor); 
}else{
    $listCondominios = $portariaCondominio->select($limiteCondominio, null);        
}

/*
 ********************************
 *********** SERVICOS ***********
 ********************************
 */

if($idCondominio){
    $portariaCondominio->selectCondominio($idCondominio);
    require_once __DIR__ . './controller_view_Servicos.php';
}

/*
 ******************************
 *********** ANTENA ***********
 ******************************
 */

if($DadosGet['pg']==45){
    $portariaAntena = new PortariaAntena;
    require_once   __DIR__ . './controller_view_Antena.php' ;
}

/*
 ****************************************
 *********** CONDIÇÕS DO CRUD ***********
 ****************************************
 */



switch ($acao):
   case'editarC':
        $acao_Dofrm_cadastraCondominio = 'editarCondominio';
        $submit_Dofrm = 'EDITAR';           
   break;
    //DELETA CONDOMINIO :
    case'deletarC':
        $portariaCondominio->verificaServico($idCondominio);
        if($portariaCondominio->getTotalServicos() >=1){
            echo "<p class=\"alert alert-danger\"><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"true\"></span> Este condominio possui ({$portariaCondominio->getTotalServicos()}) serviços ,portanto Não pode ser  deletado.</p> " ; 
        }else{
           if($portariaCondominio->deleteCondominio($idCondominio)){
              echo "<script type=\"text/javascript\">
                        location.href='?pg=42#menu3';
              </script>" ; 
           }
       }   
    break;   
    //DELETA SERVIÇO :
    case'deletarS':
        if($portariaCondominioServico->deleteServico($idPCSservico)){
              echo "<script type=\"text/javascript\">
                   location.href='?pg=42&id={$idCondominio}';
              </script>" ; 
        }
    break;
   
    //EDITAR-SERVIÇO :
    case'editarS':
        $portariaCondominioServico->selectServico(array('pcs_id'=>$idPCSservico,'pcs_pc_id'=>$idCondominio));
        $acao_Dofrm_cadastraServico = 'editarServico';
        $_disabledCampoDofrm_cadastraServico =  'disabled="true"' ;
        $submit_Dofrm = 'EDITAR';
    break;
    
    //EDITAR-ANTENA :
    case'editarA':
        $acao_Dofrm_cadastraAntena = 'editarAntena';
        $submit_Dofrm = 'EDITAR';           
        $ipAntena = new PortariaIPAntena;
       
        $listaIP = $ipAntena->selectIpPorId($idAntena);
    break;
    //DELETA ANTENA :
    case'deletarA':
        $antena = new PortariaAntena;
        if($antena->deleteAntena($idAntena)){
            echo "<script type=\"text/javascript\">
                 location.href='?pg=45&ret=danger';
            </script>" ; 
        }
    break;
endswitch;