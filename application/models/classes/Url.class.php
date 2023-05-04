<?php
class Url
{
    private $PAGINAS = [];
    private $_PAGINA = [];
    private $user_info;
    public function __construct($pg)
    {
        $this->user_info = $_SESSION['user_info']['permissoes'];
        $this->verifica_permissao();
        $this->listaPaginas($pg);
    }

    public function listaPaginas($pg)
    {
        $this->PAGINAS[0] = 'application/views/home.php';
        // CAPTACAO :
        $this->PAGINAS[1] = 'modulos/captacao/src/views/captacao/formularios/frm_cadastrarCaptacao.php';
        $this->PAGINAS[2] = 'modulos/captacao/src/views/captacao/formularios/config_captacao.php';
        $this->PAGINAS[3] = 'modulos/captacao/src/views/captacao/listas/relatorio_captacao.php';
        // USUÁRIOS:
        $this->PAGINAS[4] = 'modulos/usuarios/usuarios.php'; //rh
        $this->PAGINAS[53] = 'modulos/curriculo/curriculo.php'; //rh
        // PEDIDO DE COMISS:
        $this->PAGINAS[5] = 'modulos/pedidoComissao/src/views/index.phtml'; //'modulos/pedidoComissao/src/views/formularios/frm_pedidoComissao.php';
        $this->PAGINAS[6] = 'modulos/pedidoComissao/src/views/index.phtml';
        $this->PAGINAS[7] = 'modulos/pedidoComissao/src/views/index.phtml'; //'modulos/pedidoComissao/src/views/listas/lst_comissoesArquivadas.php'
        $this->PAGINAS[8] = 'modulos/pedidoComissao/src/views/index.phtml'; //'modulos/pedidoComissao/src/views/listas/lst_conferenciaPedidoComissao.php';
        $this->PAGINAS[9] = 'modulos/pedidoComissao/src/views/index.phtml'; //'modulos/pedidoComissao/src/views/listas/lst_comissoes.php'
        // SAC :
        $this->PAGINAS[10] = 'modulos/sac/index.phtml';
        $this->PAGINAS[38] = 'modulos/sac/index.phtml';
        $this->PAGINAS[40] = 'modulos/sac/index.phtml';
        // RAMAL :
        $this->PAGINAS[11] = 'modulos/ramal/ramal.php';
        // CAPTACAO :
        $this->PAGINAS[12] = 'modulos/captacao/src/views/captacao/listas/lst_captacaoCliente.php';
        $this->PAGINAS[13] = 'modulos/captacao/src/views/administrativo/formularios/frm_consultarAlarmes.php';
        $this->PAGINAS[14] = 'modulos/captacao/src/views/administrativo/listas/lst_consultasInternas.php';
        $this->PAGINAS[15] = 'modulos/captacao/src/views/rastreador/formularios/frm_generico.php';
        $this->PAGINAS[16] = 'modulos/captacao/src/views/rastreador/listas/lst_contratos.php';
        $this->PAGINAS[17] = 'modulos/captacao/src/views/administrativo/listas/lst_contratoGerado.php';
        $this->PAGINAS[18] = 'modulos/captacao/src/views/captacao/listas/lst_captacao.php';
        $this->PAGINAS[19] = 'modulos/captacao/src/views/captacao/formularios/gerenciador_captacao.php';
        $this->PAGINAS[20] = 'modulos/ramal/views/ramal.php';
        $this->PAGINAS[21] = 'modulos/usuarios/src/views/formularios/frm_cadastrarUsuarios.php';
        $this->PAGINAS[22] = 'modulos/desenvolvimento/src/views/formularios/frm_solicitacao.php';
        $this->PAGINAS[23] = 'modulos/desenvolvimento/src/views/listas/lst_solicitacao.php';
        $this->PAGINAS[26] = 'modulos/captacao/src/views/acionamento/formulario/acionamento_viaturas.php';
        $this->PAGINAS[27] = 'modulos/captacao/src/views/acionamento/listas/lst-visualizacaoViaturas.php';
        $this->PAGINAS[28] = 'modulos/captacao/src/views/acionamento/listas/lst-visualizacaoViaturasAntigas.php';
        $this->PAGINAS[29] = 'modulos/captacao/src/views/captacao/formularios/frm_captacaoCliente.php';
        $this->PAGINAS[30] = 'modulos/captacao/src/views/rastreador/formularios/frm_generico.php';
        $this->PAGINAS[31] = 'modulos/captacao/src/views/rastreador/formularios/frm_generico.php';
        $this->PAGINAS[32] = 'modulos/captacao/src/views/rastreador/formularios/frm_generico.php';
        $this->PAGINAS[33] = 'modulos/captacao/src/views/rastreador/formularios/frm_generico.php';
        //LOG :
        $this->PAGINAS[41] = 'modulos/log/index.phtml';
        // PORTARIA :
        $this->PAGINAS[42] = 'modulos/portaria/src/views/index.phtml';
        $this->PAGINAS[45] = 'modulos/portaria/src/views/index.phtml';
        //COMPRAS :
        $this->PAGINAS[46] = 'modulos/compras/index.phtml';
        $this->PAGINAS[47] = 'modulos/compras/index.phtml';
        $this->PAGINAS[48] = 'modulos/monitoramento/index.phtml';
        $this->PAGINAS[49] = 'modulos/monitoramento/index.phtml';
        $this->PAGINAS[51] = 'modulos/monitoramento/index.phtml';
        //AUDITORIA ALERTAS :
        $this->PAGINAS[52] = 'modulos/auditoria/index.phtml';
        //ARQUIVO :
        $this->PAGINAS[24] = 'modulos/arquivo/index.phtml';
        //CERTIFICADOS :
        $this->PAGINAS[54] = 'modulos/certificados/src/controllers/certificados.php';
        $this->PAGINAS[55] = 'modulos/captacao/src/views/captacao/formularios/admin_visualizar_captacao.php';
        $this->PAGINAS[56] = 'modulos/captacao/src/views/captacao/formularios/admin_form_editar_captacao.php';
        $this->PAGINAS[57] = 'modulos/bi/index.phtml';
        $this->PAGINAS[58] = 'modulos/migrarCaptacao/index.phtml';
        //GSAC:
        $this->PAGINAS[60] = 'modulos/gsac/index.phtml';
        $this->PAGINAS[61] = 'modulos/gsac/src/views/formulario/frm_cadastrar_novo_cliente.php';
        $this->PAGINAS[62] = 'modulos/gsac/src/views/formulario/frm_editar_novo_cliente.php';
        $this->PAGINAS[63] = 'modulos/gsac/src/controllers/criar_cliente.php';
        $this->PAGINAS[64] = 'modulos/gsac/src/controllers/atualizar_cliente.php';
        $this->PAGINAS[65] = 'modulos/gsac/src/views/formulario/frm_cadastrar_novo_gestor.php';
        $this->PAGINAS[66] = 'modulos/gsac/src/views/formulario/frm_editar_gestor.php';
        $this->PAGINAS[67] = 'modulos/gsac/src/controllers/criar_gestor.php';
        $this->PAGINAS[68] = 'modulos/gsac/src/controllers/delete_cliente.php';
        $this->PAGINAS[69] = 'modulos/gsac/src/views/listar_gestor.php';
        $this->PAGINAS[70] = 'modulos/captacao/src/views/detran/frm.php';
        $this->PAGINAS[71] = 'modulos/captacao/src/views/detran/config.php';
        //SESMT:
        $this->PAGINAS[72] = 'modulos/sesmt/index.php';
        $this->PAGINAS[73] = 'modulos/sesmt/obrigado.php';
        $this->PAGINAS[74] = 'modulos/sesmt/relatorio.php';
        $this->PAGINAS[80] = 'modulos/gsac/src/controllers/atualizar_gestor.php';
        $this->PAGINAS[81] = 'modulos/gsac/src/controllers/delete_gestor.php';

        // Use of array_key_exists() function
        if (array_key_exists($pg, $this->PAGINAS) && file_exists($this->PAGINAS[$pg])) {

            //percorre as permissoes:
            for ($i = 0; $i < count($_SESSION['user_info']['permissoes']); $i++) {
                $_permissao[] = $_SESSION['user_info']['permissoes'][$i]['tipo_permissao'];
            }

            if (in_array('pedido_comissao', $_permissao)) {
                $this->_PAGINA = [0, 5, 6, 11];
            }

            if (in_array('conf_comissao', $_permissao)) {
                array_push($this->_PAGINA, 0, 6, 7, 8, 9, 11);
            }

            if (in_array('monitoramento', $_permissao) || in_array('monitoramento2', $_permissao)) {
                array_push($this->_PAGINA, 1, 51, 48, 49, 11, 26, 27, 28);
            }

            if (in_array('desenvolvedor', $_permissao)) {
                array_push($this->_PAGINA, 0, 4, 41, 46, 48, 49, 11);
            }

            if (in_array('arquivo', $_permissao)) {
                array_push($this->_PAGINA, 0, 41, 48, 49, 11, 24);
            }

            if (in_array('captacao', $_permissao)) {
                array_push($this->_PAGINA, 0, 11, 12, 15, 18, 19, 30, 31, 32, 33, 29, 70, 71);
            }

            if (in_array('gerente', $_permissao) || in_array('auditoria', $_permissao)) {
                array_push($this->_PAGINA,  0, 2, 58, 3, 57, 54, 11, 55);
            }

            if (in_array('rh', $_permissao) || in_array('desenvolvedor', $_permissao)) {
                array_push($this->_PAGINA,  0, 53, 11);
            }

            if (in_array('administrativo', $_permissao)) {
                array_push($this->_PAGINA, 0, 17, 41, 11);
            }

            if (in_array('consultaCaptacao', $_permissao)) {
                array_push($this->_PAGINA, 0, 12, 14, 11);
            }

            if (in_array('auditoriaAlertas', $_permissao)) {
                array_push($this->_PAGINA,  0, 52, 11);
            }

            if (in_array('almoxarifado', $_permissao)) {
                array_push($this->_PAGINA, 0, 47, 11);
            }

            if (in_array('sac', $_permissao)) {
                array_push($this->_PAGINA, 60, 61, 62, 63, 64, 65, 66, 67, 68);
            }

            if (in_array('sac_admin', $_permissao)) {
                array_push($this->_PAGINA, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 80);
            }

            if (in_array('recepcaoMaster', $_permissao)) {
                array_push($this->_PAGINA, 11);
            }

            if (in_array('sesmt.relatorio.laboral', $_permissao)) {
                array_push($this->_PAGINA, 72, 73, 74);
            }

            if (in_array('sesmt', $_permissao)) {
                array_push($this->_PAGINA, 72, 73);
            }

            if (in_array('admin', $_permissao)) {
                array_push(
                    $this->_PAGINA,
                    1,
                    2,
                    3,
                    4,
                    5,
                    6,
                    7,
                    8,
                    9,
                    10,
                    11,
                    12,
                    13,
                    14,
                    15,
                    16,
                    17,
                    18,
                    19,
                    20,
                    21,
                    22,
                    23,
                    24,
                    25,
                    26,
                    27,
                    28,
                    29,
                    30,
                    31,
                    32,
                    33,
                    34,
                    35,
                    36,
                    37,
                    38,
                    39,
                    40,
                    41,
                    42,
                    43,
                    44,
                    45,
                    46,
                    47,
                    48,
                    49,
                    50,
                    51,
                    52,
                    53,
                    54,
                    55,
                    56,
                    57,
                    58,
                    59,
                    60,
                    61,
                    62,
                    63,
                    64,
                    65,
                    66,
                    67,
                    68,
                    69,
                    70,
                    71,
                    80,
					81
                );
            }

            if (in_array($pg, $this->_PAGINA)) {
                if ($_SESSION['user_info']['id_usuario'] == 471) {
                    var_dump($this->PAGINAS[$pg]);
                }
                include_once($this->PAGINAS[$pg]);
            } else {
                include_once($this->PAGINAS[0]);
            }
        } else {
            echo ("<b style='color:red'>Página Não encontrada!</b>");
        }
    }

    public function verifica_permissao()
    {
        if (empty($this->user_info)) {
            die("<b>Este usuário ainda não possui permissão!</b><br> entre em contato com a TI.");
        }
    }
}
