<?php
include_once ("../../../../Config.inc.php");
$dados = filter_input_array(INPUT_POST) != null ? filter_input_array(INPUT_POST) : filter_input_array(INPUT_GET);
$acao = isset($dados ['acao']) ? $dados ['acao'] : '';
unset($dados['acao'],$dados['radio']);//RETIRA ESTE ATRIBUTO DO ARRAY

$condominio  = new Condominio;
$pcs         = new PortariaCondominioServico;
$servico     = new PortariaServico;

switch ($acao) :
    case "insertCondominio":
        $id = $condominio->insertCondominio($dados);
        if(null!=$id){
            header("Location: ../../../../index.php?pg=42&id={$id}&ret=success");
        }else{
            die('erro ao cadastrar informe ao suporte !');
        }
    break;
    case "editarCondominio":
        $condominio->UpdateCondominio($dados);
        header("Location: ../../../../index.php?pg=42&id={$dados['pc_id']}&acao=editarC&ret=warning");
    break;
    case "editarServico":
        $pcs->UpdateServico($dados);
        
        header("Location: ../../../../index.php?pg=42&acao=editarS&idS={$dados['pcs_id']}&id={$dados['pcs_pc_id']}&ret=warning");
    break;
    case "insertServico":
        $pcs_pc_id      = !empty($dados['pcs_pc_id']) ? $dados['pcs_pc_id'] : '';
        $pcs_ps_id      = !empty($dados['pcs_ps_id']) ? $dados['pcs_ps_id'] : '';
        $ps_tipoServico = !empty($dados['ps_tipoServico']) ? $dados['ps_tipoServico'] : '';
        if(!empty($pcs_pc_id) && !empty($pcs_ps_id  && empty($ps_tipoServico))){
           unset($dados['ps_tipoServico']);
           if($pcs->selectServicoDuplicado(array('pcs_ps_id'=> $pcs_ps_id,'pcs_pc_id' =>$pcs_pc_id)) > 0){
               $url="../../../../index.php?pg=42&acao=editarC&id=$pcs_pc_id";
               $erer = "
                       <p class=\"alert alert-danger  \"><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"true\"></span>Condominio já possui este servico.<br>Por favor Informe outro</p><br>
                       <a href=\"$url\">Voltar</a>';" ;
               die($erer);
           } else{
                $pcs->insert($dados);//SALVA O ID DO SERVICO COM O ID DO CONDOMINIO.
           }
        }
        else if(!empty($pcs_pc_id) && empty($pcs_ps_id && !empty($ps_tipoServico))){
            $idServico = $servico->insertServico(array('ps_tipoServico'=>$ps_tipoServico));// 1)REGISTRA SE PRIMEIRO O SERVICO na BD EM SEGUIDA PEGA O ULTIMO ID DO SERVIÇO :
            // SALVA COM O ID DO CONDOMINIO : 
            if($idServico !=''){
                unset($dados['ps_tipoServico']);
                $dados['pcs_ps_id'] = $idServico; 
                $pcs->insert($dados);//SALVA O ID DO SERVICO COM O ID DO CONDOMINIO.
            }
        }
         header("Location: ../../../../index.php?pg=42&acao=editarC&id=$pcs_pc_id&ret=success");
    break;
endswitch;