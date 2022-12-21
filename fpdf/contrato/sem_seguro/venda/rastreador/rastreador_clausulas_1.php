<?php
//TROCA CLÁSULA 42 DE ACORDO COM O CONTRATO
$clasula42 = $list_cliente['tipo_cadastro'] == "venda" ?  "4.2 - Serão fornecidos ao CONTRATANTE, em regime de venda, para cada veículo rastreado, os seguintes itens:<br>" : "4.2 - Serão fornecidos ao CONTRATANTE, em regime de comodato, para cada veículo rastreado, os seguintes itens:<br />";
//LÓGICA CLÁSULA 73
$clasula73 = $list_cliente['tipo_cadastro'] == "venda" ? "<br>" : "";
$nMeses = "";
$clasula62 = "";
$sMeses = "";
if($list_cliente['tipo_cadastro'] != "venda"){	
    switch($list_cliente['vigencia']){
        case 1:$nMeses = 12;$sMeses = "doze";break;
        case 2:$nMeses = 24;$sMeses = "vinte e quatro";break;
        case 3:$nMeses = 36;$sMeses = "trinta e seis";break;
    }

    if($list_cliente['vigencia'] != 1){
            $clasula73 = "7.3 - Em caso de rescisão por iniciativa do CONTRATANTE ocorrida antes de completar {$nMeses} ({$sMeses}) meses de vigência do presente instrumento, será devida pelo(a) 
                            CONTRATANTE, uma indenização equivalente aos meses faltantes até completar o período de {$nMeses} ({$sMeses}) meses de vigência do presente instrumento, a ser pago através de cobrança 
                            bancária em até 05 (cinco) dias após a rescisão contratual operada;<br/><br/>";
            $clasula62 = "6.2 - A A renovação do presente contrato dar-se-á de forma automática, sempre por 01 (um) ano, após transcorridos {$nMeses} ({$sMeses}) meses iniciais.";
    } else {
            $clasula73 = "7.3 - Em caso de rescisão por iniciativa do CONTRATANTE ocorrida antes de completar 12 (doze) meses de vigência do presente instrumento, será devida pelo CONTRATANTE uma 
                            indenização no valor de R$ 150,00 (cento e cinqüenta reais), por veiculo referente à mão de obra da desinstalação do equipamento rastreador;<br/><br/>";
            $clasula62 = "6.2 - A renovação do presente contrato dar-se-á de forma automática, sempre por {$nMeses} ({$sMeses}) meses, salvo aviso prévio de 30 (trinta) dias por uma das partes;";
    }
}

$equipamentos = !$seguro ?  "<ul>
                            <li> a)01 (um) Módulo rastreador;</li>
                            <li> b)01 (um) CHIP de dados GPRS;</li>
                            <li> c)01 (um) Chicote padrão de ligações elétricas com 1 (um) relé embutido;</li>
                            <li> d)01 (um) Botão de pânico;</li>
                            </ul>"
                            :
                            "<ul>
                            <li> a)01 (um) Módulo rastreador ;</li>
                            <li> b)01 (um) CHIP de dados GPRS;</li>
                            <li> c)01 (um) Chicote padrão de ligações elétricas com 1 (um) relé embutido;</li>
                            <li> d)01 (um) Botão de pânico;</li>
                            </ul>";

$html .='
	</div>
        <div style="page-break-after:always;">
	 <p align="right">
		<img src="../img/logo-contrato.jpg"  alt="" width="207" height="67" border="0" align="right"/>
	  </p>
	  <p align="justify">
		<strong>
			CLÁUSULA PRIMEIRA - OBJETO 
		</strong>
	 <br />
		1.1  - Por este CONTRATO e na melhor forma de direito, a CONTRATADA compromete-se a  prestar ao CONTRATANTE os serviços de monitoramento por GPS/GPRS para o(s)  veículo(s) especificado(s) no item II do presente, doravante denominado de  SERVIÇO e tão somente este, não cobrindo danos 
		decorrentes de danos morais e/ou  materiais, responsabilidade civil, lucros cessantes e/ou qualquer prejuízo por  destruição, perda ou reclamação que possa ser diretamente ou indiretamente  decorrentes de acidentes, caso fortuito, roubo ou  força maior de qualquer natureza;<br />
		1.2  - O SERVIÇO ora contratado será prestado nas áreas de cobertura do sinal de  telefonia celular, podendo eventualmente sofrer interferências ou zonas de  sombra, dependendo da localização do veículo rastreado;<br />
		1.3  - O SERVIÇO será prestado durante as 24 (vinte e quatro) horas do dia, 07 (sete)  dias por semana, inclusive durante feriados;<br>
		<strong>
			CLÁUSULA SEGUNDA - OBRIGAÇÕES DA  CONTRATADA
		</strong>
		<br>
		2.1 - Os serviços a cargo da  CONTRATADA compreendem:<br />
		<ul>
		   <li>a) Monitorar  o (s) veículo (s) da CONTRATANTE, de forma ininterrupta, com pessoal  especializado, encaminhando com presteza qualquer solicitação por parte do CONTRATANTE;</li>
		   <li>b) Acionar em âmbito nacional o deslocamento de Pronta Resposta e  Polícias, visando à localização e resgate do veículo monitorado após roubo ou  furto do mesmo;</li>
		   <li>c) A mão de obra para instalar o Módulo Rastreador e a realização de testes necessários que assegurem o perfeito funcionamento do sistema;</li>
		   <li>d) Prestar assistência técnica e reposição de peças, exceto nos casos de uso indevido por parte da CONTRATANTE. A manutenção e assistência técnica serão efetuadas exclusivamente pela CONTRATADA, sendo vedado ao CONTRATANTE, 
		   em qualquer hipótese, permitir a interferência de terceiros na manutenção das instalações, sob pena de responder pelos danos causados e respectivos reparos dos equipamentos;</li>
		   <li>e) A CONTRATADA não prestará qualquer informação sobre o veículo rastreado por satélite sem a correta identificação do cliente, código, senha ou contra-senha do mesmo, onde os dados cadastrados são de inteira responsabilidade do CONTRATANTE; </li>
		</ul>
	 <p align="justify">	
	  <strong>
		CLÁUSULA TERCEIRA - OBRIGAÇÕES DO CONTRATANTE<br>
	  </strong>
		3.1 São obrigações do CONTRATANTE:<br />
	  </p>
	  <p align="justify">
	  <ul>
		<li>a) Manter atualizado os dados cadastrais do veículo rastreado e seu proprietário/condutor junto à CONTRATADA;<br />
		</li>
		<li>b) Não permitir que pessoas desautorizadas utilizem o sistema ou se faça qualquer tipo de manutenção no equipamento;</li>
		<li>c) Notificar, imediatamente, os órgãos de Segurança Pública em caso de envolvimento em ocorrência policial, bem como à CONTRATADA;</li>
		<li>d) Efetuar manutenção somente pelos técnicos autorizados pela CONTRATADA, de acordo com a periodicidade exigida para o bom funcionamento do sistema e equipamentos;</li>
		<li>e) Manter o sistema elétrico do veículo em perfeitas condições de conservação e uso;</li>
		<li>f) A CONTRATADA não se responsabilizará por eventuais ocorrências ou sinistros;</li>
		<li>g) A CONTRATANTE declara estar ciente que o presente serviço não substitui ou a isenta de qualquer forma a contratação de seguro patrimonial, inexistindo, pois,
		qualquer tipo de cobertura, seja de qualquer natureza/abrangência, relativa a danos, bens, pessoas, terceiros, entre outros, devendo a 
		CONTRATANTE para tanto, optar pelas coberturas que entender necessárias, através de empresa seguradora especializada e legalmente habilitada junto a SUSEP;
		</li>
	  </ul>
	  <p align="justify">
		<strong>
			CLÁUSULA QUARTA  PREÇO E REAJUSTAMENTO
		</strong>
		<br />
		4.1 - Pela instalação dos equipamentos e ativação dos serviços de rastreamento e monitoramento, a CONTRATANTE pagará uma taxa de habilitação do sistema constante no item III - Taxa de Serviços;<br />

		'.$clasula42.'
		'.$equipamentos.'
	  <p align="justify">
4.2.1 - A CONTRATANTE desde já declara-se ciente de que no término do contrato deverá  devolver à CONTRATADA os itens descritos acima, 
		sob pena de reembolso à mesma no valor de R$750,00 (setecentos e cinquenta reais), em caso de não devolução dos equipamentos. ;<br />
4.3 - A título de Taxa de Monitoramento (mensalidade), a CONTRATANTE pagará mensalmente a quantia especificada no item III do presente contrato;<br />
		4.4 - O pagamento da Taxa de Monitoramento será efetuado sempre no primeiro dia útil do mês subseqüente ao início da prestação de serviços, através de cobrança bancária;<br />
		4.5 - Os pagamentos efetuados após a data do seu vencimento sofrerão multa moratória de 2% (dois por cento), juros de 1% (um por cento) ao mês e correção monetária baseada na variação do IGP-M da FGV ou outro índice legal que venha a lhe substituir;<br />
		4.6 - O não pagamento do SERVIÇO DE MONITORAMENTO especificado no item III autoriza a CONTRATADA a desabilitar imediatamente, remota e fisicamente, o sistema de rastreamento por GPS/GPRS, sem prévia comunicação, ficando o CONTRATANTE obrigado a devolver o equipamento de rastreamento, saldar o débito existente, bem como o pagamento de uma multa no valor de 30% (trinta por cento) da taxa de habilitação do sistema. Desde já fica acertado que poderão ser protestados os títulos emitidos, correndo por conta do CONTRATANTE todas as eventuais despesas decorrente de tal protesto, que deverão ser ressarcidas pelo CONTRATANTE à CONTRATADA imediatamente e mediante cobrança bancária, bem como ficando a cargo do CONTRATANTE, por sua conta exclusiva, o eventual levantamento do protesto no órgão competente. A CONTRATADA poderá, ainda, enviar o nome do CONTRATANTE inadimplente para a inscrição nos Serviços de Proteção ao Crédito e demais cadastros semelhantes, mediante prévia notificação; <br />
		4.7 - Após 12 (doze) meses da assinatura deste instrumento, os valores serão automaticamente reajustados anualmente, de acordo com a variação acumulada do IGP-M do período;
	</div><div style="page-break-after:always;">
	<p align="right">
		<img src="../img/logo-contrato.jpg"  alt="" width="207" height="67" border="0" align="right"/>
	</p> 	
	<p align="justify">
		<strong>
			CLÁUSULA QUINTA - CESSÃO DO CONTRATO
		</strong>
		<br />
	  5.1 - A CONTRATANTE não poderá Ceder ou Transferir este CONTRATO sem expressa anuência da CONTRATADA;</p>
	 <p align="justify"> 
		<strong>
			CLÁUSULA SEXTA - PRAZO
		</strong>
		<br />
		6.1 - O presente Contrato de Prestação de Serviço de Monitoramento terá vigência por '.$nMeses.' ('.$sMeses.') meses;<br />
		'.$clasula62.'
	  </p>
	  <p align="justify">
		<strong>
			CLÁUSULA SÉTIMA - RESCISÃO
		</strong>
		<br />
		7.1 - O presente contrato será rescindido na ocorrência de qualquer um dos seguintes motivos:<br />
	 </p>
	 <ul>
		 <li> a) Descumprimento  de qualquer obrigação  contratual ou legal;</li>
		 <li> b) Falência   ou insolvência  de qualquer uma das partes;</li>
		 <li> c) Cessão do Contrato, sem expressa e prévia anuência da CONTRATADA;</li>
		 <li> Utilização do sistema GPS/GPRS pra fins adversos ao do contrato;</li> 
	  </ul>
	  <p align="justify">
		7.2 - Após transcorridos os primeiros '.$nMeses.' ('.$sMeses.') meses, poderá o presente instrumento ser denunciado por qualquer das partes, sem qualquer ônus à parte denunciante, mediante aviso prévio, por escrito, com antecedência mínima de 30 (trinta) dias;<br />
		'.$clasula73.'
		<strong>
			CLÁUSULA OITAVA - DISPOSIÇÕES GERAIS
		</strong>
		<br />
		8.1 - Quaisquer avisos ou comunicações de uma PARTE para a outra, relativas a este contrato, deverá se dar sempre por escrito (carta registrada, fac-símile ou e-mail);<br />
		8.2 - Qualquer concessão ou tolerância de uma PARTE ou outra, quando não manifestada por escrito, não importará em renúncia ao direito de renovação, mas mera liberdade da mesma;<br />
		8.3 - As PARTES elegem o foro da comarca de Porto Alegre/RS, com renúncia a qualquer outro, por mais privilegiado que seja para dirimir quaisquer dúvidas ou questões que possam decorrer deste contrato;<br />
		E, por estarem assim justas e contratadas, as PARTES firmam este CONTRATO em 03 (três) vias de igual teor e forma, para um só efeito, juntamente com as duas testemunhas firmatárias, para que produza seus efeitos jurídicos e legais.
	</p>
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:12px">
		<tr>
		<td height="45" colspan="2" align="center"> Porto  Alegre, '.$dma[0].' de '.$mes.' de  '.$dma[2].'</td>
	  </tr>
	  <tr>
	   <td height="40" align="center" >';
			
            if($list_cliente["tipo_assinatura"]=="ad"){
                $html.='<img src="../img/assinatura1.jpg" alt="" width="143" height="45"  border="0"/>';
            }    
                           
            $html.='</td>
	   <td height="40" align="center" >&nbsp;</td>
	  </tr>
	   <tr>
		<td width="55%" valign="top">
                    <div align="left" style=" margin:0;margin-right:10px; border-top:1px solid">
                        <strong>CONTRATADA : </strong>VOLPATO SERVIÇOS DE SEGURANÇA LTDA.<br />
                        <strong>CNPJ Nº: </strong>07.086.942/0001-83<br />
                        <strong>NOME LEGÍVEL : </strong>Cristina Rosmann Volpato<br />
                        <strong>CPF Nº: </strong>954.787.950-20
                    </div>
		</td>
		<td width="55%" valign="top">
		  <div align="left" style=" margin:0;margin-left:10px; border-top:1px solid">';
			  if($list_cliente['tipo_pessoa']=='F' || $list_cliente['tipo_pessoa']=='f'):
				$html .='
				<strong>CONTRATANTE  : </strong>'.$nome_cliente.'<br />   
				<strong>CNPJ/CPF Nº  : </strong>'.$cpf_cliente.'<br />
				<strong>NOME LEGÍVEL : </strong>'.$nome_cliente.'<br />
				<strong>CPF N º      : </strong>'.$cpf_cliente.'</div>'; 
			  endif;
			  
			  if($list_cliente['tipo_pessoa']=='J' || $list_cliente['tipo_pessoa']=='j'):
					$html .='
					<strong>CONTRATANTE  : </strong>'.$list_cliente['nome_cliente'].'<br />
					<strong>CNPJ/CPF Nº  : </strong>'.$list_cliente['cnpjcpf_cliente'].'<br />';
					if(!empty($list_cliente['socio_1']) && empty($list_cliente['socio_2'])):
					   $html .='
							<strong>NOME LEGÍVEL : </strong>'.$list_cliente['socio_1'].'<br />
							<strong>CPF N º      : </strong>'.$list_cliente['cpf_socio1'].'</div>
					   ';								
					endif;
					if(!empty($list_cliente['socio_1']) && !empty($list_cliente['socio_2'])):
					   $html .='
							 <strong>NOME LEGÍVEL : </strong>'.$list_cliente['socio_1'].'<br />
							 <strong>CPF N º      : </strong>'.$list_cliente['cpf_socio1'].'<br />
							 <strong>NOME LEGÍVEL : </strong>'.$list_cliente['socio_2'].'<br />
							<strong>CPF N º      : </strong>'.$list_cliente['cpf_socio2'].'</div>
					   ';								
					endif;
			  endif;
			  $html .='
		</td>
	  </tr>
	  <tr>
		<td colspan="2"><br><br></td>
	  </tr> 
	  <tr>
		<td height="16"><strong> TESTEMUNHAS:</strong></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td align="center">';
                        if($list_cliente["tipo_assinatura"]=="ad"){
                            $html.='<img src="../img/assinaturas/'.$list_assinatura['assinatura'].'" alt="" width="143" height="45"  border="0"/>';
                        }    
               $html.=' </td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>
		  <div align="left" style=" margin:0;margin-right:10px; border-top:1px solid">
			<strong>1º NOME : </strong>'.$list_assinatura['nome'].'<br />
			<strong> &nbsp; &nbsp; CPF: </strong>'.$list_assinatura['cpf'].'<br />
		  </div>
		</td>
		<td>
		  <div align="left" style=" margin:0;margin-left:30px; border-top:1px solid; font-weight:bold">
			2º<br />
			.
		   </div>
		  </td>
	  </tr>
	  </table>
</div>';
