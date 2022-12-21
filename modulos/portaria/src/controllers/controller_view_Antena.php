<?php
$dados['pa_id'] = $idAntena;

//TOTAL DE ANTENAS NA BD :
$portariaAntena->selectAntenass($dados);
$totalAntenas = $portariaAntena->Read()->getRowCount();

//LISTA OS ANTENAS COM PAGINAÇÃO :
$objPaginacaoAntena = new paginacao(10,$totalAntenas, PAG, 10);
$objPaginacaoAntena->_pagina = PAGINA;
$dados['limit'] = $objPaginacaoAntena->limit();
 
if($acao=='pesquisaAntenas' && $buscarPor !==  NULL){
    $dados['filtro'] = $buscarPor;   
    
    unset($dados['pa_id']);
    $portariaAntena->selectantenas($dados); //var_dump('com filtro',$dados);  
    if(!empty($dados['pa_id'])){
         $portariaAntena->sets($portariaAntena->Read()->getResult()[0]);
    }else{
         $listAntenas =  $portariaAntena->Read()->getResult();
    }
    
}else{
    
    $portariaAntena->selectantenas($dados);  //var_dump('sem filtro',$dados);   
    if(!empty($dados['pa_id'])){
        $portariaAntena->sets($portariaAntena->Read()->getResult()[0]);
    }else{
        $listAntenas =  $portariaAntena->Read()->getResult();
    }
}
