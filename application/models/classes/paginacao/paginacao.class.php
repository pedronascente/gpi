<?php
class paginacao {
    var $regs; // nï¿½mero de registros por pï¿½ginas
    var $exNum; // nï¿½mero de pï¿½ginas a ser exibida no menu ex.: mostra "1 2 3 4 5" apesar de termos 10 pï¿½ginas
    var $totReg; // nï¿½mero de registros contidos no banco de dados
    var $totPag; // nï¿½mero total de pï¿½ginas
    var $pg; // pï¿½gina em que estamos
    var $separador; // separador entre os links do menu ex. separador = "|" menu = 1|2|3|4|5
    var $tag_pagin; // tag na qual nossa paginaï¿½ï¿½o estarï¿½ inserida
    var $url_separator; // separador de url, para o caso de precisarmos passar outros argumentos pelo get, que nï¿½o seja apenas a pï¿½gina
    var $nome_arq;
    var $classLinkAtivo;
    var $classLink = "linkPaginacao";
    var $_pagina;
    var $_tabs;

    function Construir_Url() {
        global $REQUEST_URI, $REQUEST_METHOD, $HTTP_GET_VARS, $HTTP_POST_VARS;

        $query_string = "";

        // separa o link em 2 strings
        if (!empty($REQUEST_URI)) {
            list ( $this->nome_arq, $voided ) = explode("?", $REQUEST_URI);

            if ($REQUEST_METHOD == "GET")
                $cgi = $HTTP_GET_VARS;
            else
                $cgi = $HTTP_POST_VARS;

            reset($cgi); // posiciona no inicio do array
            // separa a coluna com o seu respectivo valor
            while (list ( $chave, $valor ) = @each($cgi))
                if ($chave != "pg")
                    $query_string .= "&" . $chave . "=" . $valor;
        }

        return $query_string;
    }

    /**
     * mï¿½todo construtor da nossa classe
     */
    function paginacao($regs, $totReg, $pg, $exNum = "", $separador = '', $tag_pagin = "") {
        $this->regs = $regs;
        $this->exNum = $exNum;
        $extra_vars = $this->Construir_Url();
        $arquivo = $this->nome_arq;
        $this->totReg = $totReg;
        $totPag = ($totReg <= $regs) ? 1 : ceil($totReg / $regs); // se vocï¿½ estï¿½ acostumado com o operador ternï¿½rio, vocï¿½ sabe o que isso siginifica, senï¿½o, leia TERNï¿½RIO
        $this->totPag = $totPag;
        $this->pg = ($pg != "") ? $pg : 1;
        // $this->separador = $separador != "" ? $separador : " | ";
        $this->tag_pagin = $tag_pagin;
        $this->url_separator = (strpos($extra_vars, "?") !== false) ? "&" : "?";
        $this->url_separator = $extra_vars;
        $this->_tabs = $this->getTabs();
    }

    public function setTabs($tabs) {
        $this->_tabs = $tabs;
    }

    private function getTabs() {
        return $this->_tabs;
    }

    /**
     * mï¿½todo que nos retornarï¿½ uma string com o valor a ser passado na clï¿½usula limit do sql
     * 
     * @return string limit pronto pra sql
     */
    function limit() {
        $inicio = ($this->pg * $this->regs) - $this->regs; // o primeiro registro a ser puxado do BD
        $final = $this->regs; // o total de registros a ser puxado do BD
        $limit = $inicio . "," . $final; // limit formatado para ser utilizado na sua query
        return $limit;
    }

    /**
     * mï¿½tod que cria nossa paginaï¿½ï¿½o
     * 
     * @return string menu formatado
     */
    function paginar($primeiro = "<<", $ultimo = ">>", $prev = "<", $next = ">") {
        // vamos pegar os valores dos atributos da classe e usar como variÃ¡veis locais ao mÃ©todo
        $pg = $this->pg;
        $totPag = $this->totPag;
        $arquivo = $this->nome_arq;
        $tag_pagin = $this->tag_pagin;
        $url_separator = $this->url_separator;
        $classLink = $this->classLink;
        $classLinkAtivo = $this->classLinkAtivo;
        // caso nada seja passado como parÃ¢mtro para a funÃ§Ã£o, iremos dar um valor default
        $primeiro = $primeiro == "" ? "<<" : $primeiro;
        $ultimo = $ultimo == "" ? ">>" : $ultimo;
        $prev = $prev == "" ? "<" : $prev;
        $next = $next == "" ? ">" : $next;

        // primeira condiï¿½ï¿½o. Se tivermos o nï¿½mero de pï¿½ginas igual ï¿½ pï¿½gina atual, estaremos na ï¿½ltima pï¿½gina, ou temos apenas
        // uma pï¿½gina, mas nesse caso nï¿½o exibiremos a paginaï¿½ï¿½o (com css, display: none)
        // jï¿½ que estamos na ï¿½ltima pï¿½gina, nï¿½o precisaremos de links nos botoes proximo e ï¿½ltima
        if ($totPag == $pg) {
            // a pï¿½gina utilizada nos links dos botoes de voltar
            //$pg = $this->pg - 1;
			$pg = $this->pg;
/*
            $proximo = "<li><a href='".$arquivo."?pg='".$this->_pagina."&pag=".$totPag."> " . $next . "</a></li>";
            $ultima = "<li><a href='".$arquivo."?pg='".$this->_pagina."&pag=".$totPag."> " . $ultimo . "</a></li>";
*/
            $proximo = "<li><a> " . $next . "</a></li>";
            $ultima = "<li><a> " . $ultimo . "</a></li>";
            // precisaremos de botoes anterior e primeira, a n�o ser que tenhamos apenas uma p�gina, mas nesse caso esconderemos
            // nossa pagina��o
            $anterior = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg" . $url_separator . $this->_tabs . " \"> " . $prev . "</a></li>";
            $primeira = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=1" . $url_separator . $this->_tabs . " \">" . $primeiro . "</a></li>";
        } elseif ($pg == 1) {
            // nosso segundo condicional. se estivermos na pï¿½gina 1, nï¿½o precisamos de botï¿½es de voltar, certo?
            // a pï¿½gina utilizada nos links dos botï¿½es de avanï¿½ar
            $pg = $this->pg + 1;
            $proximo = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg" . $url_separator . $this->_tabs . "\" >" . $next . "</a></li>";
            $anterior = "<li><a>" . $prev . "</a></li>";
            $primeira = "<li><a>" . $primeiro . "</a></li>";
            $ultima = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$totPag" . $url_separator . $this->_tabs . "\" >" . $ultimo . "</a></li>";
			} else {
            // significa que nï¿½o estamos nem na ï¿½ltima nem na primeira, e os botï¿½es podem ter os links normais
            // nï¿½mero de pï¿½gina usado no botï¿½o de avanï¿½ar
            $pg_p = $pg + 1;
            // nï¿½mero de pï¿½gina usado no botï¿½o de voltar
            $pg_a = $pg - 1;
            // bot�es
            $proximo = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_p" . $url_separator . $this->_tabs . "\" >" . $next . " </a> ";
            $anterior = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_a" . $url_separator . $this->_tabs . "\" > " . $prev . "</a> ";
            $primeira = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=1" . $url_separator . $this->_tabs . "\" >" . $primeiro . "<a/> ";
            $ultima = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$totPag" . $url_separator . $this->_tabs . "\" >" . $ultimo . "</a>";
            // bot�es
            $proximo = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_p" . $url_separator . $this->_tabs . "\">" . $next . "</a></li>";
            $anterior = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_a" . $url_separator . $this->_tabs . "\"> " . $prev . "</a></li>";
            $primeira = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=1" . $url_separator . $this->_tabs . "\">" . $primeiro . "</a></li>";
            $ultima = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$totPag" . $url_separator . $this->_tabs . "\">" . $ultimo . "</a></li>";
		}
        // montamos nossa primeira seï¿½ï¿½o de botï¿½es, os de voltar
		$pagina = $primeira.$anterior;
		
		// se tivermos o $exNum definido, � porque teremos uma pagina��o limitada...
        if ($this->exNum != "") {
            $exNum = $this->exNum;
            $pagina .= $this->paginar_limitado($exNum, $totPag);
        } else {
            // ...senï¿½o, podemos paginar normalmente
            // esse laï¿½o vai nos dar os nï¿½meros do menu da paginaï¿½ï¿½o
            for ($i = 1; $i <= $totPag; $i ++) {
                // se nosso link for o mesmo da pï¿½gina em que estamos, devemos mostrï¿½-lo em negrito, e sem links...
                if ($i == $this->pg) {
                    // nossa vari�vel p�gina ser� concatenada com os valores de i dentro do loop, aqui e dentro do else log abaixo
                    $pagina .= "<li><a href='#'>" . $i . "</a></li>";
                } else {
                    $pagina .= "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\"> " . $i . "</a></li>";
                }
            } // close for
        }
        // mais uma concatena��o, agora para terminarmos nosso menu, com os bot�es de ir e vir, e com os n�meros internos
        $pagina .= $proximo.$ultima;
        // aqui n�s definiremos se o menu deve aparecer ou n�o (caso tenha apenas uma p�gina)
        if ($totPag == 1) {
            $result = "";
            // $result = "";
        } elseif ($tag_pagin != "") {
            // se tivermos uma tag definida, devemos colocar nosso menu dentro dela, correto?
            $result = $pagina;
        } else {
            $result = $pagina;
        }
        // retornamos o nosso menu completo, pronto para ser mostrado na nossa pï¿½gina
        return $result;
    }

/************************************************************
*******		INÍCIO DA PÁGINAÇÃO DE SINISTROS		*********
************************************************************/
    function paginacaoSinistros($regs, $totReg, $pg, $exNum = "", $separador = '', $tag_pagin = "") {
        $this->regs = $regs;
        $this->exNum = $exNum;
        $extra_vars = $this->Construir_Url();
        $arquivo = $this->nome_arq;
        $this->totReg = $totReg;
        $totPag = ($totReg <= $regs) ? 1 : ceil($totReg / $regs); // se voce esta acostumado com o operador ternario, voce sabe o que isso siginifica, senao, leia TERNÁRIO
        $this->totPag = $totPag;
        $this->pg = ($pg != "") ? $pg : 1;
        // $this->separador = $separador != "" ? $separador : " | ";
        $this->tag_pagin = $tag_pagin;
        $this->url_separator = (strpos($extra_vars, "?") !== false) ? "&" : "?";
        $this->url_separator = $extra_vars;
        $this->_tabs = $this->getTabsSinistro();
    }

    public function setTabsSinistro($tabs) {
        $this->_tabs = $tabs;
    }

    private function getTabsSinistro() {
        return $this->_tabs;
    }



    function paginarSinistros($primeiro = "<<", $ultimo = ">>", $prev = "<", $next = ">") {
        // vamos pegar os valores dos atributos da classe e usar como variáveis locais ao método
        $pg = $this->pg;
        $totPag = $this->totPag;
        $arquivo = $this->nome_arq;
        $tag_pagin = $this->tag_pagin;
        $url_separator = $this->url_separator;
        $classLink = $this->classLink;
        $classLinkAtivo = $this->classLinkAtivo;
        // caso nada seja passado como parâmetro para a função, iremos dar um valor default
        $primeiro = $primeiro == "" ? "<<" : $primeiro;
        $ultimo = $ultimo == "" ? ">>" : $ultimo;
        $prev = $prev == "" ? "<" : $prev;
        $next = $next == "" ? ">" : $next;

        // primeira condicao. Se tivermos o numero de paginas igual a pagina atual, estaremos na ultima pagina, ou temos apenas
        // uma pagina, mas nesse caso nao exibiremos a paginacao (com css, display: none)
        // ja que estamos na ultima pagina, nao precisaremos de links nos botoes proximo e ultima
        if ($totPag == $pg) {
            // a pagina utilizada nos links dos botoes de voltar
            $pg = $this->pg - 1;
			//$pg = $this->pg;
/*
            $proximo = "<li><a href='".$arquivo."?pg='".$this->_pagina."&pag=".$totPag."> " . $next . "</a></li>";
            $ultima = "<li><a href='".$arquivo."?pg='".$this->_pagina."&pag=".$totPag."> " . $ultimo . "</a></li>";
*/
            $proximo = "<li><a> " . $next . "</a></li>";
            $ultima = "<li><a> " . $ultimo . "</a></li>";
            // precisaremos de botoes anterior e primeira, a nao ser que tenhamos apenas uma pagina, mas nesse caso esconderemos
            // nossa paginacao
/*
            $anterior = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg" . $url_separator . $this->_tabs . " \"> " . $prev . "</a></li>";
            $primeira = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=1" . $url_separator . $this->_tabs . " \">" . $primeiro . "</a></li>";
*/
            $anterior = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg" . $url_separator . $this->_tabs . "#lista \"> " . $prev . "</a></li>";
            $primeira = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=1" . $url_separator . $this->_tabs . "#lista \">" . $primeiro . "</a></li>";
        } elseif ($pg == 1) {
            // nosso segundo condicional. se estivermos na pagina 1, nao precisamos de botoes de voltar, certo?
            // a pagina utilizada nos links dos botoes de avancar
            $pg = $this->pg + 1;
/*
            $proximo = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg" . $url_separator . $this->_tabs . "\" >" . $next . "</a></li>";
            $anterior = "<li><a>" . $prev . "</a></li>";
            $primeira = "<li><a>" . $primeiro . "</a></li>";
            $ultima = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$totPag" . $url_separator . $this->_tabs . "\" >" . $ultimo . "</a></li>";
*/
            $proximo = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg" . $url_separator . $this->_tabs . "#lista\" >" . $next . "</a></li>";
            $anterior = "<li><a>" . $prev . "</a></li>";
            $primeira = "<li><a>" . $primeiro . "</a></li>";
            $ultima = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$totPag" . $url_separator . $this->_tabs . "#lista\" >" . $ultimo . "</a></li>";
			} else {
            // significa que nao estamos nem na ultima nem na primeira, e os botoes podem ter os links normais
            // numero de pagina usado no botao de avancar
            $pg_p = $pg + 1;
            // numero de pagina usado no botao de voltar
            $pg_a = $pg - 1;
            // botoes
/*
            $proximo = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_p" . $url_separator . $this->_tabs . "\" >" . $next . " </a> ";
            $anterior = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_a" . $url_separator . $this->_tabs . "\" > " . $prev . "</a> ";
            $primeira = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=1" . $url_separator . $this->_tabs . "\" >" . $primeiro . "<a/> ";
            $ultima = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$totPag" . $url_separator . $this->_tabs . "\" >" . $ultimo . "</a>";
*/
            $proximo = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_p" . $url_separator . $this->_tabs . "#lista\" >" . $next . " </a> ";
            $anterior = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_a" . $url_separator . $this->_tabs . "#lista\" > " . $prev . "</a> ";
            $primeira = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=1" . $url_separator . $this->_tabs . "#lista\" >" . $primeiro . "<a/> ";
            $ultima = "<a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$totPag" . $url_separator . $this->_tabs . "#lista\" >" . $ultimo . "</a>";
            // botoes
/*
            $proximo = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_p" . $url_separator . $this->_tabs . "\">" . $next . "</a></li>";
            $anterior = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_a" . $url_separator . $this->_tabs . "\"> " . $prev . "</a></li>";
            $primeira = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=1" . $url_separator . $this->_tabs . "\">" . $primeiro . "</a></li>";
            $ultima = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$totPag" . $url_separator . $this->_tabs . "\">" . $ultimo . "</a></li>";
*/
            $proximo = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_p" . $url_separator . $this->_tabs . "#lista\">" . $next . "</a></li>";
            $anterior = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$pg_a" . $url_separator . $this->_tabs . "#lista\"> " . $prev . "</a></li>";
            $primeira = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=1" . $url_separator . $this->_tabs . "#lista\">" . $primeiro . "</a></li>";
            $ultima = "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=$totPag" . $url_separator . $this->_tabs . "#lista\">" . $ultimo . "</a></li>";
		}
        // montamos nossa primeira secao de botoes, os de voltar
		$pagina = $primeira.$anterior;
		
		// se tivermos o $exNum definido, eh porque teremos uma paginacao limitada...
        if ($this->exNum != "") {
            $exNum = $this->exNum;
            $pagina .= $this->paginar_limitadoSinistro($exNum, $totPag);
        } else {
            // ...senao, podemos paginar normalmente
            // esse laco vai nos dar os numeros do menu da paginacao
            for ($i = 1; $i <= $totPag; $i ++) {
                // se nosso link for o mesmo da pagina em que estamos, devemos mostra-lo em negrito, e sem links...
                if ($i == $this->pg) {
                    // nossa variavel pagina sera concatenada com os valores de i dentro do loop, aqui e dentro do else log abaixo
                    $pagina .= "<li><a href='#'>" . $i . "</a></li>";
                } else {
                    $pagina .= "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\"> " . $i . "</a></li>";
                }
            } // close for
        }
        // mais uma concatena��o, agora para terminarmos nosso menu, com os bot�es de ir e vir, e com os n�meros internos
        $pagina .= $proximo.$ultima;
        // aqui n�s definiremos se o menu deve aparecer ou n�o (caso tenha apenas uma p�gina)
        if ($totPag == 1) {
            $result = "";
            // $result = "";
        } elseif ($tag_pagin != "") {
            // se tivermos uma tag definida, devemos colocar nosso menu dentro dela, correto?
            $result = $pagina;
        } else {
            $result = $pagina;
        }
        // retornamos o nosso menu completo, pronto para ser mostrado na nossa pï¿½gina
        return $result;
    }


    function paginar_limitadoSinistro($exNum, $totalPg) {
        $classLink = $this->classLink;
        $classLinkAtivo = $this->classLinkAtivo;
        $menu = null;
        // vamos pegar os valores dos atributos da classe e usar como variaveis locais ao metodo
        $arquivo = $this->nome_arq;
        $url_separator = $this->url_separator;
        $separador = $this->separador;
        $pg = $this->pg;
        // aqui teremos duas variaveis importantissimas:
        // div nos mostra a o prï¿½ximo inteiro mais proximo da metade do valor de exNum. esse valor sera utilizado em calculos futuros
        $div = (is_int($exNum / 2)) ? $exNum / 2 : floor($exNum / 2);
        // centro ï¿½ o centro da paginacao. se tivermos 5 como exNum, teremos 3 com sendo o centro. Isso eh para uma apresentacao estatica mais agradavel
        $centro = (is_int($exNum / 2)) ? $exNum / 2 : ceil($exNum / 2);
        // 1a condicional: nossa pagina eh igual ao total de painas(estamos na ultima pagina)...
        if ($pg == $totalPg) {
            // ...testamos se nosso total de paginas eh maior que o numero de links a ser exibido no menu...
            // ...se sim, nosso menu ultrapassa os limites de exibicao de links, e deve comecar por um numero maior que 1.
            if ($totalPg >= $exNum) {
                // variavel que indica o final do menu
                $termina = $totalPg;
                // variavel que indica o comeco do menu. Precisamos subtrair do final, o exNum. E adicionar 1, senao teremos um link a mais no nosso menu
                $comeco = $termina - $exNum + 1;
                // comecaremos nosso loop com o valor do primeiro link do menu
                $i = $comeco;
                // para exibirmos os links do menu, temos que ter um loop, e nesse loop precisamos testar se nosso numero tem link ou nao. Fazemos isso com um operador ternario, que eh mais enxuto:
                while ($i >= $comeco and $i <= $termina) {
                    // Note o uso da variavel $separador, como separador de numeros do menu
                    @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\">" . $i . "</a></li>";
                    $i ++;
                }
            } else {
                // ...senao, nosso menu nao ultrapassa os limites de exibicao de links.
                // nosso menu comeca...do comeco...rsrs
                $comeco = 1;
                // e termina na nossa ultima pagina
                $termina = $totalPg;
                // daqui para baixo, os loops serao os mesmos, entao considere os comentarios do loop de cimam ^
                $i = $comeco;
                while ($i >= $comeco and $i <= $termina) {
                    @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\">" . $i . "</a></li>";
                    $i ++;
                }
            }
        } elseif ($pg == 1) {
            // 2a condicional: estamos na primeira pagina
            // nosso menu comeca...do comeco...rsrs
            $comeco = 1;
            // para sabermos onde termina, precisamos saber se nosso menu ultrapassa os limites de links, se sim, nosso menu termina exNum nï¿½meros depois do comeï¿½o menos 1. Assim fazemos nosso menu ter apenas exNum links, e nï¿½o exNum + 1.
            $termina = $totalPg >= $exNum ? ($comeco + $exNum) - 1 : $totalPg;
            $i = $comeco;
            $menu = null;
            while ($i <= $termina and $i >= $comeco) {
                @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\">" . $i . "</a></li>";
                $i ++;
            }
        } elseif ($pg < $totalPg - $exNum) {
            // 3a condicional: estamos num pagina cujo numero eh menor que o total de paginas menos o exNum. ou seja, nao esta entre os "exNum"s links do nosso menu
            if ($pg > $exNum) {
                // estamos num pagina que eh maior que os "exNum" primeiros numeros do nosso menu
                // nosso menu comeca "div" numeros antes da nossa pagina atual. ou seja, nossa pagina ficara no centro do menu
                $comeco = $pg - $div;
                // o nosso sistema de fazer o menu terminar com exNum links
                $termina = $comeco + $exNum - 1;
                $i = $comeco;
                while ($i <= $termina and $i >= $comeco) {
                    @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\">" . $i . "</a></li>";
                    $i ++;
                }
            } elseif ($pg < $exNum) {
                // estamos entre os "exNum"s primeiros numeros do menu, devemos saber se estamos no centro, ou se estamos antes dele
                if ($pg > $centro) {
                    // se estamos alem do centro, nosso menu comeca "div" numeros antes de nossa pagina atual, ou seja, nossa pagina ficara no centro do menu
                    $comeco = $pg - $div;
                    $termina = $comeco + $exNum - 1;
                    $i = $comeco;
                    while ($i <= $termina and $i >= $comeco) {
                        @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\">" . $i . "</a></li>";
                        $i ++;
                    }
                } else {
                    // se estamos antes ou no centro, nossa pagina ficara na posicao normal, sem deslocamento para centrarmos ao menu
                    $comeco = 1;
                    $termina = $comeco + $exNum - 1;
                    $i = $comeco;
                    $menu = null;
                    while ($i <= $termina and $i >= $comeco) {
                        $menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\">" . $i . "</a></li>";
                        $i ++;
                    }
                }
            } elseif ($pg == $exNum) {
                // estamos no limite de exibicao de links
                // jogaremos, entao, nossa pagina no centro do menu, com esse calculo, onde tiramos div do exNum, o que nos dara o centro atual do menu:
                $comeco = $exNum - $div;
                $termina = $comeco + $exNum - 1;
                $i = $comeco;
                while ($i >= $comeco and $i <= $termina) {
                    @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\">" . $i . "</a></li>";
                    $i ++;
                }
            }
        } elseif ($pg > $totalPg - $exNum) {
            // 4a condicional: testamos se nossa pagina esta entre as exNum ultimas do menu
            if ($totalPg > $exNum) {
                // temos um total de paginas que ultrapassa o limite de links/pagina
                if ($pg <= $totalPg - ($exNum - $centro)) {
                    // nossa pagina esta antes ou eh o centro atual do menu, entao jogamos ela para o centro, quando ja nao o ï¿½
                    $comeco = $pg - $div;
                    $termina = $comeco + $exNum - 1;
                    $i = $comeco;
                    while ($i >= $comeco and $i <= $termina) {
                        @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\">" . $i . "</a></li>";
                        $i ++;
                    }
                } else {
                    // nossa pagina esta alem do centro, entao teremos que manter seu lugar normal, sem desloca-la para o centro, senao teremos mais links do que realmente precisamos
                    $comeco = $totalPg - $exNum + 1;
                    $termina = $comeco + $exNum - 1;
                    $i = $comeco;
                    while ($i >= $comeco and $i <= $termina) {
                        @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\">" . $i . "</a></li>";
                        $i ++;
                    }
                }
            } elseif ($totalPg <= $exNum) {
                // nosso total de paginas nao eh maior que nosso menu
                $comeco = 1;
                $termina = $totalPg;
                $i = $comeco;
                while ($i <= $termina and $i >= $comeco) {
                    $menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\">" . $i . "</a></li>";
                    $i ++;
                }
            }
        } elseif ($pg == $totalPg - $exNum) {
            // 5a condicional: se nossa pagina for igual ao total de paginas menos o limite de exibicao por menu, ela ainda nao foi atingida por nenhum condicional acima, entao teremos um so pra ela... :D
            $termina = $totalPg - ($exNum - $div);
            $comeco = $termina - $exNum + 1;
            $i = $comeco;
            while ($i <= $termina and $i >= $comeco) {
                @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "#lista\">" . $i . "</a></li>";
                $i ++;
            }
        }
        // die(@$menu);//essa eh uma boa pratica: testar o seu resultado retornado antes de utilizar a classe no seu site;)
        // aqui nos iremos retirar o ultimo separador da nossa string, pois nao precisamos dele entre os numeros e os botoes.
        @$menu = rtrim(@$menu, $separador) . " ";
        return @$menu;
    }
	
/*		FIM DA PÁGINAÇÃO DE SINISTROS		*/

    /**
     * mï¿½todo que cria uma paginaï¿½ï¿½o limitada
     * 
     * @access private
     * @return string menu quase pronto
     */

	function paginar_limitado($exNum, $totalPg) {
        $classLink = $this->classLink;
        $classLinkAtivo = $this->classLinkAtivo;
        $menu = null;
        // vamos pegar os valores dos atributos da classe e usar como variï¿½veis locais ao mï¿½todo
        $arquivo = $this->nome_arq;
        $url_separator = $this->url_separator;
        $separador = $this->separador;
        $pg = $this->pg;
        // aqui teremos duas variï¿½veis importantï¿½ssimas:
        // div nos mostra a o prï¿½ximo inteiro mais prï¿½ximo da metade do valor de exNum. esse valor serï¿½ utilizado em cï¿½lculos futuros
        $div = (is_int($exNum / 2)) ? $exNum / 2 : floor($exNum / 2);
        // centro ï¿½ o centro da paginaï¿½ï¿½o. se tivermos 5 como exNum, teremos 3 com sendo o centro. Isso ï¿½ para uma apresentaï¿½ï¿½o estï¿½tica mais agradï¿½vel
        $centro = (is_int($exNum / 2)) ? $exNum / 2 : ceil($exNum / 2);
        // 1ï¿½ condicional: nossa pï¿½gina ï¿½ igual ao total de pï¿½ginas(estamos na ï¿½ltima pï¿½gina)...
        if ($pg == $totalPg) {
            // ...testamos se nosso total de paginas ï¿½ maior que o numero de links a ser exibido no menu...
            // ...se sim, nosso menu ultrapassa os limites de exibiï¿½ï¿½o de links, e deve comeï¿½ar por um nï¿½mero maior que 1.
            if ($totalPg >= $exNum) {
                // variï¿½vel que indica o final do menu
                $termina = $totalPg;
                // variï¿½vel que indica o comeï¿½o do menu. Precisamos subtrair do final, o exNum. E adicionar 1, senï¿½o teremos um link a mais no nosso menu
                $comeco = $termina - $exNum + 1;
                // comeï¿½aremos nosso loop com o valor do primeiro link do menu
                $i = $comeco;
                // para exibirmos os links do menu, temos que ter um loop, e nesse loop precisamos testar se nosso nï¿½mero tem link ou nï¿½o. Fazemos isso com um operador ternï¿½rio, que ï¿½ mais enxuto:
                while ($i >= $comeco and $i <= $termina) {
                    // Note o uso da vari�vel $separador, como separador de n�meros do menu
                    @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "\">" . $i . "</a></li>";
                    $i ++;
                }
            } else {
                // ...senï¿½o, nosso menu nï¿½o ultrapassa os limites de exibiï¿½ï¿½o de links.
                // nosso menu comeï¿½a...do comeï¿½o...rsrs
                $comeco = 1;
                // e termina na nossa ï¿½ltima pï¿½gina
                $termina = $totalPg;
                // daqui para baixo, os loops serï¿½o os mesmos, entï¿½o considere os comentï¿½rios do loop de cimam ^
                $i = $comeco;
                while ($i >= $comeco and $i <= $termina) {
                    @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "\">" . $i . "</a></li>";
                    $i ++;
                }
            }
        } elseif ($pg == 1) {
            // 2ï¿½ condicional: estamos na primeira pï¿½gina
            // nosso menu comeï¿½a...do comeï¿½o...rsrs
            $comeco = 1;
            // para sabermos onde termina, precisamos saber se nosso menu ultrapassa os limites de links, se sim, nosso menu termina exNum nï¿½meros depois do comeï¿½o menos 1. Assim fazemos nosso menu ter apenas exNum links, e nï¿½o exNum + 1.
            $termina = $totalPg >= $exNum ? ($comeco + $exNum) - 1 : $totalPg;
            $i = $comeco;
            $menu = null;
            while ($i <= $termina and $i >= $comeco) {
                @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "\">" . $i . "</a></li>";
                $i ++;
            }
        } elseif ($pg < $totalPg - $exNum) {
            // 3ï¿½ condicional: estamos num pï¿½gina cujo nï¿½mero ï¿½ menor que o total de pï¿½ginas menos o exNum. ou seja, nï¿½o estï¿½ entre os "exNum"s links do nosso menu
            if ($pg > $exNum) {
                // estamos num pï¿½gina que ï¿½ maior que os "exNum" primeiros nï¿½meros do nosso menu
                // nosso menu comeï¿½a "div" nï¿½meros antes da nossa pï¿½gina atual. ou seja, nossa pï¿½gina ficarï¿½ no centro do menu
                $comeco = $pg - $div;
                // o nosso sistema de fazer o menu terminar com exNum links
                $termina = $comeco + $exNum - 1;
                $i = $comeco;
                while ($i <= $termina and $i >= $comeco) {
                    @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "\">" . $i . "</a></li>";
                    $i ++;
                }
            } elseif ($pg < $exNum) {
                // estamos entre os "exNum"s primeiros nï¿½meros do menu, devemos saber se estamos no centro, ou se estamos antes dele
                if ($pg > $centro) {
                    // se estamos alï¿½m do centro, nosso menu comeï¿½a "div" nï¿½meros antes de nossa pï¿½gina atual, ou seja, nossa pï¿½gina ficarï¿½ no centro do menu
                    $comeco = $pg - $div;
                    $termina = $comeco + $exNum - 1;
                    $i = $comeco;
                    while ($i <= $termina and $i >= $comeco) {
                        @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "\">" . $i . "</a></li>";
                        $i ++;
                    }
                } else {
                    // se estamos antes ou no centro, nossa pï¿½gina ficarï¿½ na posiï¿½ï¿½o normal, sem deslocamento para centrarmos ao menu
                    $comeco = 1;
                    $termina = $comeco + $exNum - 1;
                    $i = $comeco;
                    $menu = null;
                    while ($i <= $termina and $i >= $comeco) {
                        $menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "\">" . $i . "</a></li>";
                        $i ++;
                    }
                }
            } elseif ($pg == $exNum) {
                // estamos no limite de exibiï¿½ï¿½o de links
                // jogaremos, entï¿½o, nossa pï¿½gina no centro do menu, com esse cï¿½lculo, onde tiramos div do exNum, o que nos darï¿½ o centro atual do menu:
                $comeco = $exNum - $div;
                $termina = $comeco + $exNum - 1;
                $i = $comeco;
                while ($i >= $comeco and $i <= $termina) {
                    @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "\">" . $i . "</a></li>";
                    $i ++;
                }
            }
        } elseif ($pg > $totalPg - $exNum) {
            // 4ï¿½ condicional: testamos se nossa pï¿½gina estï¿½ entre as exNum ï¿½ltimas do menu
            if ($totalPg > $exNum) {
                // temos um total de paginas que ultrapassa o limite de links/p�gina
                if ($pg <= $totalPg - ($exNum - $centro)) {
                    // nossa pï¿½gina estï¿½ antes ou ï¿½ o centro atual do menu, entï¿½o jogamos ela para o centro, quando jï¿½ nï¿½o o ï¿½
                    $comeco = $pg - $div;
                    $termina = $comeco + $exNum - 1;
                    $i = $comeco;
                    while ($i >= $comeco and $i <= $termina) {
                        @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "\">" . $i . "</a></li>";
                        $i ++;
                    }
                } else {
                    // nossa pï¿½gina estï¿½ alï¿½m do centro, entï¿½o teremos que manter seu lugar normal, sem deslocï¿½-la para o centro, senï¿½o teremos mais links do que realmente precisamos
                    $comeco = $totalPg - $exNum + 1;
                    $termina = $comeco + $exNum - 1;
                    $i = $comeco;
                    while ($i >= $comeco and $i <= $termina) {
                        @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "\">" . $i . "</a></li>";
                        $i ++;
                    }
                }
            } elseif ($totalPg <= $exNum) {
                // nosso total de pï¿½ginas nï¿½o ï¿½ maior que noss menu
                $comeco = 1;
                $termina = $totalPg;
                $i = $comeco;
                while ($i <= $termina and $i >= $comeco) {
                    $menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "\">" . $i . "</a></li>";
                    $i ++;
                }
            }
        } elseif ($pg == $totalPg - $exNum) {
            // 5ï¿½ condicional: se nossa pï¿½gina for igual ao total de pï¿½ginas menos o limite de exibiï¿½ï¿½o por menu, ela ainda nï¿½o foi atingida por nenhum condicional acima, entï¿½o teremos um sï¿½ pra ela... :D
            $termina = $totalPg - ($exNum - $div);
            $comeco = $termina - $exNum + 1;
            $i = $comeco;
            while ($i <= $termina and $i >= $comeco) {
                @$menu .= ($i == $pg) ? "<li class='active'><a href='#'>" . $i . "</a></li>" : "<li><a href=\"" . $arquivo . "?pg=" . $this->_pagina . "&pag=" . $i . $url_separator . $this->_tabs . "\">" . $i . "</a></li>";
                $i ++;
            }
        }
        // die(@$menu);//essa ï¿½ uma boa pratica: testar o seu resultado retornado antes de utilizar a classe no seu site;)
        // aqui nï¿½s iremos retirar o ultimo separador da nossa string, pois nï¿½o precisamos dele entre os nï¿½meros e os botï¿½es.
        @$menu = rtrim(@$menu, $separador) . " ";
        return @$menu;
    }

    /**
     * mï¿½todo que nos retornarï¿½ aquele lembrete de localizaï¿½ï¿½o nos registros como no google ex.
     * reg.: 1 a 5 de 10
     * 
     * @return lembrete de registros
     */
    function paginar_inteligente($template = "") {
        // valor que serï¿½ apresentado como o valor inicial
        $de = $this->pg * $this->exNum - $this->exNum + 1;
        // valor final que se estï¿½ exibindo
        $a = $this->pg * $this->exNum;
        // total de registros exibidos
        $total = $this->totReg;
        // correï¿½ï¿½o de um bug bem feio
        ($total - $a) < $this->exNum ? $a = $total : "";
        // testamos se nï¿½o tem nada no parametro da funï¿½ï¿½o, para entï¿½o retornarmos o nosso default, ou o template passado.
        if (!empty($template)) {
            // temos aqui uma aglomeraï¿½ï¿½o de funï¿½ï¿½es do php para manipulaï¿½ï¿½o de strings, procure entender cada uma delas no manual.
            // veja SUBSTR_REPLACE e STRPOS
            $tpl = substr_replace(substr_replace(substr_replace($template, $total, strpos($template, "#3"), 2), $a, strpos($template, "#2"), 2), $de, strpos($template, "#1"), 2);

            @$menu = $tpl;
        } else {
            @$menu = "Itens " . $de . " a " . $a . " de " . $total;
        }
        return @$menu;
    }

 function MontaPaginacao() {
    	echo '<nav>';
    	echo '<ul class="pagination">';
    	echo utf8_encode($this->paginar());
    	echo '</ul>';
    	echo '<nav>';	
	}

/*		INÍCIO MONTA PAGINAÇÃO DE SINISTROS		*/
 function MontaPaginacaoSinistros() {
    	echo '<nav>';
    	echo '<ul class="pagination">';
    	echo utf8_encode($this->paginarSinistros());
    	echo '</ul>';
    	echo '<nav>';	
	}
/*		FIM DA MONTAGEM PAGINAÇÃO DE SINISTROS	*/	
}
