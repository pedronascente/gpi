<?
include ("../../../../../Config.inc.php");
// BOM DIA ! , POR FAVOR NÃO SE ESQUEÇA DE COMENTAR SEUS CODIGOS .
$codUsuario = $_GET ['usuario_id'];
$ddd = $_GET ['regiao_ddd'];
// BOM DIA ! , POR FAVOR NÃO SE ESQUEÇA DE COMENTAR SEUS CODIGOS .
$usuario = new Usuarios ();
$ass = $usuario->selecionarAssinaturaEmail($codUsuario, $ddd);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Assinatura</h4>
        </div>			
        <div class="modal-body">
            <table width="100%" border="0" cellpadding="0" cellspacing="0"
                   style="background: #FFF; margin: 0">
                <tr>
                    <td rowspan="2" valign="bottom">
                    	<img src="<?= "modulos/usuarios/public/img/assinaturas/" . $ass['0']['assinaturaEmail'] ?>">
                    </td>
                    <td align="center" style="font-size: 13px;"><strong><?= $ass['0']['nome'] ?></strong><br>
                        <?= $ass['0']['setor_local'] ?><br>
                        <?= '(' . $ass['1']['regiao_ddd'] . ')&nbsp;' . $ass['1']['regiao_telefone'] ?> <br>
                        <?= $ass['1']['estado_nome'] ?> <br> 
                        <?= $ass['0']['usuario_email'] ?> 
                    </td>
                    <td rowspan="2" valign="bottom">
                    	<img src="<?= "modulos/usuarios/public/img/assinaturas/parte3.jpg" ?>" alt="parte3">
                    </td>
                </tr>
                <tr>
                    <td  valign="bottom">
                    	<img src="<?= "modulos/usuarios/public/img/assinaturas/parte2.jpg" ?>" alt="parte2">
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>