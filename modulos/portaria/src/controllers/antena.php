<?php
include_once ("../../../../Config.inc.php");
$dados = filter_input_array(INPUT_POST) != null ? filter_input_array(INPUT_POST) : filter_input_array(INPUT_GET);
$acao = isset($dados ['acao']) ? $dados ['acao'] : '';
unset($dados['acao'],$dados['radio']);//RETIRA ESTE ATRIBUTO DO ARRAY

 $antena  = new PortariaAntena();
switch ($acao) :
    case "gerasenha":
        $senha  = new GeradorSenhas;
        die($senha->gerarSenha(50,10));
    break;
    case "insertAntena":
       
        //1-REGISTRAR ANTENA  E PEGAR O ULTIMO ID:
        $idAntena = null;
        if($idAntena== null)
        {
            $arrayIP = array('pia_ip'=>$dados['pia_ip'],'pia_mask'=>$dados['pia_mask'],'pia_gateway'=>$dados['pia_gateway']);
            unset($dados['pia_ip'],$dados['pia_mask'],$dados['pia_gateway']);
            $idAntena  = $antena->inserAntena($dados);
        }
        
        //2-REGISTRAR IPS:
        for($I=1; $I<=2; $I++) 
        {
            foreach ($arrayIP['pia_ip'] as  $v1)
            {    
                $dadosIP['pia_ip'] = $v1;
                if($I == 2) 
                {
                    break;
                }
            }
            foreach ($arrayIP['pia_mask'] as  $v2)
            {   
                $dadosIP['pia_mask'] = $v2;    
                if($I == 2) 
                {
                    break;
                }
            } 
            foreach ($arrayIP['pia_gateway'] as  $v3)
            {   
                 $dadosIP['pia_gateway'] = $v3;
                 if($I == 2) 
                 {
                     break;
                 }
            }
            
            $dadosIP['pia_pa_id'] = $idAntena;
            if(isset($dadosIP))
            {
                $antena->inserIP($dadosIP);
            }
            else
            {
                die('nao foi possivel registrar na base de dados, verifique os dados do IP');
            }
        }
        
        //3-REENCAMINHAR PARA VIEW:
        header('Location:../../../../index.php?pg=45&ret=success');
    break;
    case "editarAntena":
     
        //var_dump($dados );die;
        
        $idAntena = null;
        if($idAntena== null)
        {
            $arrayIP = array(
                'pia_ip'=>$dados['pia_ip'],
                'pia_mask'=>$dados['pia_mask'],
                'pia_gateway'=>$dados['pia_gateway'],
                'pia_id'=>$dados['pia_id']
            );
            
            unset(
                $dados['pia_ip'],
                $dados['pia_mask'],
                $dados['pia_gateway'],
                $dados['pia_id']
            );
            
            $antena->UpdateAntena($dados);
        }
        
        for($I=1; $I<=2; $I++) 
        {
            foreach ($arrayIP['pia_ip'] as  $v1)
            {    
                $dadosIP['pia_ip'] = $v1;
                if($I == 2) 
                {
                    break;
                }
            }
            foreach ($arrayIP['pia_mask'] as  $v2)
            {   
                $dadosIP['pia_mask'] = $v2;    
                if($I == 2) 
                {
                    break;
                }
            } 
            foreach ($arrayIP['pia_gateway'] as  $v3)
            {   
                 $dadosIP['pia_gateway'] = $v3;
                 if($I == 2) 
                 {
                     break;
                 }
            }
            foreach ($arrayIP['pia_id'] as  $v1)
            {    
                $dadosIP['pia_id'] = $v1;
                if($I == 2) 
                {
                    break;
                }
            }
            
            $dadosIP['pia_pa_id'] = $dados['pa_id'];
            
            if(isset($dadosIP))
            {
                $antena->UpdateIPAntena($dadosIP);
            }
            else
            {
                die('nao foi possivel EDITAR  , verifique os dados do IP');
            }
        }
        
        header('Location:../../../../index.php?pg=45&ret=warning');
    break;
endswitch;   

