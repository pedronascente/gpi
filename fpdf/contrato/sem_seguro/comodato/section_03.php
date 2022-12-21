<?php


$html .= '
 <br> <b>2. DAS PREVISÕES PRELIMINARES</b><br>
<p>
  2.1. Considerando que o rastreador veicular e os serviços disponibilizados pela CONTRATADA, com a presente contratação, não impedem a prática de atos delituosos e de qualquer tipo de evento danoso ao veículo rastreado, sendo que tais atividades cabem exclusivamente aos Órgãos da Segurança Pública, tais como Polícia (Brigada) Militar e Polícia Civil.
  <br><br>2.2. Considerando que o rastreador veicular e serviços disponibilizados pela CONTRATADA com a presente contratação não se tratam de seguro patrimonial, a CONTRATADA não se responsabiliza de qualquer forma pelo veículo rastreado em caso de sinistros.
  <br><br>2.3. Considerando que, ao firmar o presente instrumento está contratando um sistema de rastreamento veicular passivo, o CONTRATANTE tem conhecimento que o serviço de rastreamento é disponibilizado e deve fazer a gestão das informações obtidas, na forma e condições do serviço que ora está adquirindo da CONTRATADA, não restando qualquer dúvida.
  As Partes acima qualificadas, devidamente esclarecidas e ajustadas, resolvem firmar o presente CONTRATO PARTICULAR DE LOCAÇÃO DO RASTREADOR VEICULAR, doravante denominado apenas "Contrato", sustentado na boa fé objetiva e na livre e espontânea vontade das partes, com observância nas disposições do Código Civil, do Código de Defesa do Consumidor e nas demais previsões da legislação vigente.
</p>
</div>
<b>3. DO OBJETO DO CONTRATO</b><br><br>
<b>3.1. O presente contrato tem por objeto:</b><br>

<p>
  a) A locação dos seguintes itens:
  <br>01 (um) Módulo rastreador, com manual do equipamento
  <br>01 (um) CHIP de dados GPRS
  <br>01 (um) Chicote padrão de ligações elétricas com 1 (um) relé embutido
  <br>01 (um) Botão de pânico
  <br>b) A disponibilização de software do rastreador veicular viabilizando ao CONTRATANTE as informações eletrônicas acerca do veículo equipado com o rastreador, através de aplicativo de celular/tablet – APP Android/IOS – e da plataforma web;
  <br>c) A prestação de serviços consistente: 1) na disponibilização da Central de Monitoramento 24hs, que estará disponível para receber o comunicado do CONTRATANTE em caso de algum evento, a qual realizará a ligação telefônica para os Órgãos de Segurança Pública e/ou acionará a equipe de pronto atendimento da CONTRATADA, em caso de roubo e furto; e, 2) na disponibilização de equipe técnica em caso de manuteção dos equipamentos do rastreador veicular na forma delimitada neste instrumento.
</p>

<b>4. DA LOCAÇÃO DOS EQUIPAMENTOS</b><br>

<p>
  4.1. Os equipamentos informados na letra “a” da cláusula 3.1 são cedidos em locação pela CONTRATADA para viabilizar a disponibilização do serviço de rastreamento veicular passivo e são instalados no veículo descrito no item 1.3 deste contrato, sendo que estes equipamentos são de exclusiva propriedade da CONTRATADA.
  <br><br>4.2. Fica estabelecido que somente pessoas autorizadas pela CONTRATADA podem ter acesso aos equipamentos locados, sendo que eventual necessidade de reparo ou troca do equipamento é de responsabilidade da CONTRATADA.
  <br><br>4.3. O CONTRATANTE é responsável pelo equipamentos, respondendo pelo mau uso, devendo ressarcir a CONTRATADA pelo valor de mercado do equipamento novos ou similares.
  <br><br>4.4. Com o término do prazo contratual ou da rescisão do contrato, obriga-se o CONTRATANTE a devolver imediatamente todos os equipamentos descritos no item 3.1, nas mesmas condições em que estavam quando os recebeu, ou seja, em perfeitas condições de uso, salvo desgaste natural ocasionado pelo uso dos mesmos, respondendo o CONTRATANTE pelos danos e prejuízos causados devido ao mau uso dos equipamentos.
  <br><br>4.5. O CONTRATANTE desde já declara-se ciente de que no término do contrato deverá devolver à CONTRATADA os equipamentos do item 3.1, sob pena de reembolso à mesma no valor de R$ 750,00 (setecentos e cinquenta reais), em caso de não devolução dos equipamentos.
</p>

<b>5. DO SERVIÇO</b><br>

<p>
  5.1. Fica esclarecido que o objeto deste contrato consiste em disponibilizar o serviço de rastreamento veicular passivo, viabilizando ao CONTRATANTE as informações eletrônicas acerca do veículo equipado com o rastreador, que devem ser geridas pelo CONTRATANTE, através de aplicativo de celular/tablet – APP Android/IOS – e da plataforma web.
  <br><br>5.2. O rastreador contratado utiliza a comunicação por GPS/GPRS, realizada via empresas de telefonia móvel de celular, com disponibilidade somente em território nacional e onde houver cobertura de tais empresas.
  <br><br>5.3. O serviço disponibilizado de rastreamento veicular será prestado nas áreas de cobertura do sinal de telefonia móvel de celular, podendo eventualmente sofrer interferências ou zonas de sombra, dependendo da localização do veículo rastreado.
  <br><br>5.4. O serviço de rastreamento será disponibilizado durante as 24 (vinte e quatro) horas do dia, 07 (sete) dias por semana, inclusive durante feriados, com exceção da equipe técnica em caso de manutenções dos equipamentos do rastreador, que deverá ser observada a previsão da letra "d" do item 8.1 deste instrumento.
</p>

<b>6. DO PREÇO</b><br>

<p>
  <table border="1" cellspacing="0" cellpadding="2" width="100%">
  <tr>
    <td>
      6.1. A CONTRATADA realizará a habilitação dos equipamentos e ativação do rastreador, que terá o custo para o CONTRATANTE de <b> R$' . $valor_total_taxa_instalacao . '</b> (' . $_extenso->extenso($valor_total_taxa_instalacao) . '), pagos da seguinte forma: <b> ' . $forma_pagamento_habilitacao . ',</b> à título de taxa de habilitação.<br> Pagamento efetuado em  - <b>' . $list_cliente['data_pagamento'] . ' </b>
    </td>
  </tr>
</table>

<p>
  6.2. O CONTRATANTE pagará à CONTRATADA, mensalmente, pela locação dos equipamentos, o valor de <b> R$ ' . $valor_locacao_equipamento . ',</b> (' . $_extenso->extenso($valor_locacao_equipamento) . '), pela disponibilização software do rastreador veicular, o valor de <b>R$ ' . $valor_aluguel_software_rastreamento . '</b> (' . $_extenso->extenso($valor_aluguel_software_rastreamento) . ') e pelos serviços contratados (letra “c”, do item 3.1), o valor de <b>R$ ' . $valor_servico_contratado . '</b> (' . $_extenso->extenso($valor_servico_contratado) . '), que totaliza o valor de <b>R$ ' . $soma_valores_servicos . ' </b>, (' . $_extenso->extenso($soma_valores_servicos) . ') cobrado no mês seguinte ao da prestação de serviço, pró-rata.
</p>
  
<table border="1" cellspacing="0" cellpadding="2" width="100%">
  <tr>
    <td>
      6.3. O valor a ser pago mensalmente pelo CONTRANTANTE terá vencimento todo o dia '.$list_cliente['diaMelhorPagamento'].' ('.$diaMelhorPagamento.') de cada mês, pagos da seguinte forma: '.$forma_pagamento_mensalidade.'.
    </td>
  </tr>
</table>
<br>

  6.5. Ocorrendo atraso no pagamento ajustado, sobre o valor incidirá correção monetária, com base na variação do IGPM/FGV, mais juros de 1% (um por cento) ao mês, ou fração de mês, até a data do efetivo pagamento, e multa de 2% (dois por cento) sobre o valor total devido, até o efetivo pagamento pelo CONTRATANTE.
  <br><br>

  6.6. É facultada à CONTRATADA a suspensão do sistema de rastreamento por GPS/GPRS ou cancelamento do presente contrato, a critério da CONTRATADA, com a imediata interrupção da disponibilização e da prestação dos serviços objeto do item 3.1, independentemente de qualquer aviso ou notificação, judicial ou extrajudicial, sendo aplicada ainda de multa no valor de 10% (dez por cento) sobre o valor devido, em caso de cancelamento por inadimplência.
  <br><br>

  6.7. Ocorrendo o cancelamento do contrato, o CONTRATANTE DEVE DEVOLVER OS EQUIPAMENTOS LOCADOS À CONTRATADA, além dos valores em atraso corrigidos. Na hipótese não devolução dos equipamentos locados à CONTRATADA, além dos valores em atraso corrigidos, na forma dos itens 6.5 e 6.6, o CONTRATANTE também deverá pagar o valor previsto no item 4.5 deste contrato.
  <br><br>

  6.8. O CONTRATANTE fica expressamente informado que os seus dados poderão ser encaminhados para escritório de cobrança da CONTRATADA, caso em que se acrescentará 10% sobre o valor devido devidamente corrigido e poderão ser encaminhados para os Órgãos de Proteção ao Crédito. Os títulos poderão ser levados a protesto, correndo por conta do CONTRATANTE todas as eventuais despesas decorrente de tal protesto, que deverão ser ressarcidas pelo CONTRATANTE à CONTRATADA imediatamente e mediante cobrança bancária, bem como ficando a cargo do CONTRATANTE, por sua conta exclusiva, o eventual levantamento do protesto no órgão competente. A CONTRATADA poderá ainda fazer a cobrança judicial sobre os valores totais devidos pelo CONTRATANTE, devidamente corrigidos pelo IGPM/FGV, mais juros de 1% (um por cento) ao mês, multa de 2% (dois por cento) e honorários contratuais advocatícios de 20% sobre o valor total da dívida a ser cobrada.
</p>

<b>7. DA VIGÊNCIA</b><br>

<p>
  7.1. O presente contrato terá vigência por 12 (doze) meses, renovando-se automaticamente, por iguais períodos de 12 (doze) meses sucessivamente, salvo denunciação, por qualquer das partes, com a notificação expressa da outra parte, pessoalmente na sede da CONTRATADA, ou mediante: 1) correspondência com aviso de recebimento em mão própria – ARMP; ou, 2) por e-mail relacionamento2.rast@grupovolpato.com, sendo que em ambos os casos, firmado pelo CONTRATANTE e endereçado à CONTRATADA, comprovando-se a sua remessa e correspondente recebimento, sempre sendo respeitado o período de 30 dias de aviso prévio.
  <br><br>7.2. Em caso de denunciação do contrato dentro do período de 12 (doze) meses será cobrada uma multa por rescisão antecipada no valor de 10% (dez por cento) sobre o valor das parcelas mensais vincendas, mais o valor devido do aviso prévio, correspodente a uma mensalidade integral vigente na época. Após o período de 12 (doze) meses, não será devida a multa de 10%, mas deverá ser pago o aviso prévio de 30 dias, correspodente a uma mensalidade integral vigente na época.
  <br><br>7.3. Em caso de rescisão por iniciativa do CONTRATANTE ocorrida antes de completar 12 (doze) meses de vigência do presente instrumento, será devida pelo CONTRATANTE uma indenização no valor de R$ 150,00 (cento e cinquenta reais) por veículo, referente à mão de obra da desinstalação do equipamento rastreador.
  <br><br>7.4. O valor total do item 6.2, após 12 (doze) meses da assinatura deste instrumento, será automaticamente reajustado, de acordo com a variação acumulada do IGP-M do período.
</p>

<b>8. DAS OBRIGAÇÕES DA CONTRATADA</b><br><br>
<b>8.1. São obrigações da CONTRATADA:</b><br>

<p>
  <br>a) Disposnibilizar o serviço de rastreamento veicular passivo, viabilizando ao CONTRATANTE as informações eletrônicas acerca do veículo equipado com o rastreador;
  <br><br>b) Posteriormente ao comunicado do CONTRATANTE ou do terceiro por ela autorizado e que informe a senha e contrasenha à CONTRATADA, acionar em âmbito nacional o deslocamento de Pronta Resposta e/ou fazer ligação telefônica para os Órgãos de Segurança Pública, visando à localização e resgate do veículo monitorado após roubo ou furto do mesmo;
  <br><br>c) A mão de obra para instalar o Módulo Rastreador e a realização de testes da instalação necessários que assegurem o perfeito funcionamento do sistema;
  <br><br>d) Prestar assistência técnica, em horário comercial, e reposição de peças do equipamento do rastreador, exceto nos casos de uso indevido por parte da CONTRATANTE. A manutenção e assistência técnica serão efetuadas exclusivamente pela CONTRATADA, sendo vedado ao CONTRATANTE, em qualquer hipótese, permitir a interferência deterceiros na manutenção das instalações, sob pena de responder pelos danos causados e respectivos reparos dos equipamentos;
  <br><br>e) A CONTRATADA não prestará qualquer informação sobre o veículo rastreado por GPS/GPRS sem a correta identificação do cliente, código, senha ou contra-senha do mesmo, onde os dados cadastrados são de inteira responsabilidade do CONTRATANTE;
  <br><br>f) Prestar o serviço de manutenções dos equipamentos por equipe técnica indicada pela CONTRATADA, desde que o CONTRATANTE comunique a CONTRATADA a necessidade, sendo que o atendimento estará vinculada a uma avaliação da situação por parte da CONTRATADA, que se obriga a prestar todas as informações ao CONTRATANTE.
</p>

<b>9. DAS OBRIGAÇÕES DO CONTRATANTE</b><br><br>
<b>9.1. São obrigações do CONTRATANTE:</b><br>

<p>
  a) Efetuar os pagamentos da taxa de habilitação e das mensalidades na forma e modo ajustados neste instrumento contratual;
  <br>b) Agir com boa-fé, prestando declarações claras e precisas;
  <br>c) Manter atualizado os dados cadastrais do veículo rastreado e seu proprietário/condutor junto à CONTRATADA, comunicando imediatamente a CONTRATADA a transferência do veículo de sua posse ou propriedade;

  <br>d) Notificar, imediatamente, os órgãos de Segurança Pública em caso de envolvimento em ocorrência policial, bem como à CONTRATADA;
  <br>e) Ativar, pelo aplicativo de celular/tablet – APP Android/IOS – da CONTRATADA, os ícones de "Ignição" e "Cerca", viabilizando os alertas que o sistema disponibiliza ao CONTRATANTE. Tais alertas permitirão que o CONTRATANTE entre em contato com a Central 24hs da CONTRATADA. Caso o CONTRATANTE NÃO ACIONE OS ALERTAS DISPONÍVEIS NO APP, POR SER O SISTEMA DO RASTREADOR PASSIVO, A CONTRATADA NÃO SABERÁ DA OCORRÊNCIA EXISTENTE COM O VEÍCULO. NO SISTEMA CONTRATADO DO RASTREADOR PASSIVO, A COMUNICAÇÃO DO CONTRATANTE PARA A CONTRATATADA DA OCORRÊNCIA É INDISPENSÁVEL, ASSUMINDO O CONTRATANTE O RISCO DA FALTA DO COMUNICADO IMEDIATO COM A CONTRATADA.

  <br>f) Efetuar manutenção somente pelos técnicos autorizados pela CONTRATADA, visando o bom funcionamento do sistema e equipamentos;
  <br>g) Manter o sistema elétrico do veículo em condições de conservação e uso, fazendo principalmente que a bateria do equipamento de rastreamento não fique descarregada, realizando o CONTRATANTE testes de funcionamento, sob pena de assumir os riscos de eventual dano ao(s) veículo(s);
  <br>h) O CONTRATANTE fica obrigada a realizar um teste mensal de comunicação entre a central de monitoramento e o equipamento de rastreamento instalado no veículo objeto deste contrato;
  <br>i) Fica expressamente vedado ao CONTRATANTE, em qualquer hipótese, permitir a interferência de terceiros na manutenção das instalações, sob pena de responder pelos danos causados e pelos respectivos reparos dos equipamentos;
  <br>j) Manter o veículo rastreado em bom estado de conservação e segurança;
  <br>k) Apresentar o veículo para manutenções do sistema de rastreamento quando a CONTRATADA julgar necessário;
  <br>l) No que couber a sua responsabilidade, manter em perfeito funcionamento o sistema de monitoramento instalado no veículo;
  <br>m) Em caso de chamados realizados pelo CONTRATANTE, que ocasione o deslocamentos da equipe de manutenção do rastreador e se verificar que o problema do veículo não é ocasionado pelo rastreador instalado no veículo, mas por outro motivo, será cobrado um valor de R$ R$ 75,00,
(Setenta e cinco reais) por visita, chamada de “visita improdutiva”;
  <br>n) A qualquer momento, informar à CONTRATADA se o sistema de monitoramento instalado no veículo for desligado e desativado, por quaisquer motivos.
  <br><br>9.2. É obrigatório ao CONTRATANTE realizar o teste mensal e faz parte do dever de manutenção do Sistema de Rastreamento. O TESTE MENSAL DEVE SER REALIZADO NO PRAZO DE, NO MÁXIMO, 
  30 (trinta) DIAS, CONTADOS DO ULTIMO TESTE MENSAL enviado A CENTRAL DE MONITORAMENTO DA CONTRATADA. A falta de teste mensal configura ato culposo do CONTRATANTE e exonera a CONTRATADA de qualquer responsabilização pela não localização do veículo com o rastreador;
</p>

<b>9.2.1. O teste deverá ser feito através do aplicativo disponibilizado pela contratada seguindo as orientações abaixo: </b><br>

<p>
  a) Fazer o download do app na loja conforme o Smartphone do CONTRATANTE;
  <br>b) Com a ignição desligada fazer o login no app com o e-mail cadastrado e a senha disponibilizada pela CONTRATADA;
  <br>c) Conferir a data e hora da ultima atualização na barra retangular no canto superior direito do app;
  <br>d) Clicar e ativar o ícone "Ignição";
  <br>e) Ligar o veículo e permanecer com ele ligado por 2 minutos;
  <br>f) Desligar o veículo;
  <br>g) Clicar e desativar o ícone "Ignição" .
  <br>f) O teste foi registrado na plataforma.
</p>

<p>
  9.3. Para os casos onde o CONTRATANTE por algum motivo não obteve sucesso no procedimento de teste mensal o mesmo deverá entrar em contato com a central de atendimento pelo telefone 3004-5554 para que seja realizado o procedimento.
  9.4. É importante o CONTRATANTE comunicar o fato imediatamente a Central de Monitoramento e/ou seguir o procedimento específico da mesma para que se inicie o processo de recuperação do veículo.
  9.5. O CONTRATANTE tem a obrigação de comunicar imediatamente à CONTRATADA, pela via mais rápida possível a ocorrência de qualquer fato ou circunstância que possa afetar ou alterar o risco, bem como qualquer evento que possa vir a se caracterizar como um sinistro, encaminhando posteriormente documento por via formal e escrita.
</p>

<b> 10. DA CESSÃO DO CONTRATO</b><br>
<b>10.1. O CONTRATANTE não poderá Ceder ou Transferir este CONTRATO sem expressa anuência da CONTRATADA. </b><br>

<b>11. DA RESCISÃO </b><br>

<b>11.1. O presente contrato poderá ser rescindido na ocorrência de qualquer um dos seguintes motivos:</b><br>
<p>
  a) Descumprimento de qualquer obrigação contratual ou legal;
  <br>b) Falência ou insolvência de qualquer uma das partes;
  <br>c) Cessão do Contrato, sem expressa e prévia anuência da CONTRATADA;
  <br>d) Utilização do sistema GPS/GPRS para fins adversos ao do contrato;
  <br>e) Impossibilidade de execução do objeto dos serviços contratados por qualquer motivo.
</p>

<b> 12. DA RESPONSABILIDADE</b><br>
<p>
  12.1. O CONTRATANTE declara estar ciente de que o rastreador locado e os serviços prestados pela CONTRATADA, sem distinção, não têm o poder de impedir a prática de atos delituosos e de qualquer tipo de evento danoso, a qual cabe exclusivamente aos Órgãos da Segurança Pública, tais como Polícia (Brigada) Militar e Polícia Civil. Assim, o CONTRATANTE é sabedor ao firmar esse contrato que o sistema de rastreamento veicular passivo contratado não impede a ocorrência de sinistros.
</p>

<b>12.2. A CONTRATADA está isenta de responsabilidade: </b><br>
<p>
  a) pela omissão, incorreção e/ou não atualização dos dados do CONTRATANTE;
  <br>b) pela não observância do CONTRATANTE de manter a carga na bateria do equipamento, com acionamento periódico do motor do veículo (no máximo a cada dois dias) em que o sistema esteja instalado;
  <br>c) quando o serviço sofrer interferência ou estiver em zonas de sombra;
  <br>d) pela demora e/ou não comparecimento dos órgãos de segurança pública.
</p>


<div style="page-break-after:always;">

<b>12.3. A CONTRATADA não se responsabilizará: </b><br>
<p>
  a) por danos materiais e/ou pessoais, decorrentes da má-fé, negligência, imprudência e imperícia do CONTRATANTE, bem como por atraso e/ou falha na prestação de serviço por parte de terceiros, tais como Polícia Militar, Polícia civil, pessoas físicas e/ou jurídicas, entre outros;
  <br>b) pelo uso indevido dos equipamentos por parte do CONTRATANTE;
  <br>c) pela falta de recebimento de sinal e/ou comunicação com a Central de Monitoramento 24hs, que pode ocorrer em caso de uso de terceiros de dispositivos que interferem ou bloqueam o sinal do rastreamento, como, por exemplo, o uso de dispositivos chamados Jammer;
  <br>d) por danos decorrentes de culpa exclusiva do CONTRATANTE ou de terceiro, que venha a sabotar o equipamento de rastreamento;
  <br>e) por danos decorrentes de caso fortuito e força maior;
  <br>f) por danos decorrentes em período de suspensão dos serviços de rastreamento ou após o cancelamento, em caso de inadimplência.
</p>
<p>
  12.4. O rastreador veicular locado e os serviços disponibilizados pela CONTRATADA, com a presente contratação, não se tratam de seguro patrimonial. Os equipamentos e serviço contratado pelo CONTRATANTE não são infalíveis e de modo algum equiparam-se a um seguro de veículo/carga. Desse modo, o CONTRATANTE tem ciência que a CONTRATADA não se responsabiliza por prejuízos ou danos de qualquer natureza, incluindo danos de integridade física de pessoas, bem como danos de ordem material e moral não previstos e totalmente alheios à natureza da contratação.
</p>

<b> 13. DA PRIVACIDADE E PROTEÇÃO DE DADOS PESSOAIS </b><br>
<p>
  13.1. Para prestar os serviços contratados, a CONTRATADA realiza o tratamento de dados pessoais. Portanto, as cláusulas abaixo tem o objetivo de identificar as obrigações da CONTRATADA e da parte CONTRATANTE relativamente ao tratamento de dados pessoais nas atividades vinculadas ao presente Termo. Para melhor compreensão, as regras e condições estão fracionadas em “aplicáveis para CONTRATANTE pessoa física” e “aplicáveis para Contratante pessoa jurídica”.
</p>

<p>
  <b>13.2. Aplicáveis para CONTRATANTE pessoa física: </b> <br>
  
  <br> a) A parte CONTRATANTE tem ciência de que seus dados pessoais, especialmente aqueles preenchidos no anexo I, quando da contratação do(s) serviço(s), serão tratados para fins de execução do presente contrato e para prestação do serviço(s) contratado(s), exemplificadamente, para atividades de atendimento das suas solicitações, ressarcimento, dentre outros.
  <br> b) A parte CONTRATANTE tem ciência, ainda, que a CONTRATADA poderá compartilhar seus dados pessoais com terceiras empresas que lhe prestam serviços relacionados à execução do presente contrato ou à gestão do relacionamento mantido com a parte CONTRATANTE, tais como, exemplificadamente, empresas que disponibilizam softwares ou que prestam serviços de cobrança terceirizada.
  <br> c) Caso a parte CONTRATANTE tenha qualquer dúvida sobre o tratamento dos seus dados pessoais ou deseje maior detalhamento sobre as situações indicadas nos itens acima, deverá remeter e-mail para dpo@grupovolpato.com.
  <br> d) Nos casos em que a CONTRATADA necessitar tratar dados pessoais de terceiros para execução do presente contrato, a parte CONTRATANTE será responsável por orientá-la e instruí-la. Sempre que possível, a parte CONTRATANTE deverá comunicar tais terceiros sobre o tratamento dos seus dados pessoais para atividades vinculadas ao presente contrato. Exemplificadamente, nos casos de coleta de contatos de emergência ou de pessoas autorizadas para determinadas ações contratuais, a responsabilidade pela delimitação do volume e perímetro de coleta dos referidos dados pessoais é exclusiva do CONTRATANTE.
  <br> e) As partes obrigam-se a assegurar confidencialidade de qualquer dado pessoal tratado em decorrência do presente contrato, os quais poderão ser compartilhados com terceiros apenas para ações vinculadas à prestação dos serviços e desde que tais terceiros também estejam sujeitos a ajustes de confidencialidade.
</p>

<p>
<b>  13.3. Aplicáveis para CONTRATANTE pessoa jurídica:</b><br>
  a) As partes declaram através do presente instrumento conhecer a Lei Geral de Proteção de Dados Pessoais e implementar as regras lá indicadas, assim como boas práticas de segurança para o tratamento de dados pessoais, no desenvolvimento das suas respectivas atividades.
  <br> b) A parte CONTRATANTE, na condição de Controladora de dados pessoais, é responsável por delimitar e orientar o tratamento de dados pessoais realizado pela CONTRATADA – que atuará nos limites das instruções e orientações recebidas. Nos casos de coleta de dados pessoais no serviço contratado, a responsabilidade pela delimitação do volume ou perímetro de coleta dos referidos dados pessoais é exclusiva do CONTRATANTE.
  <br> c) As partes comprometem-se a tratar os dados pessoais relacionados à execução dos serviços contratados de forma confidencial, limitando o compartilhamento apenas aos colaboradores ou terceiras empresas estritamente necessárias para a prestação dos serviços contratados.
  <br> d) A parte CONTRATANTE não poderá compartilhar com terceiros dados pessoais de colaboradores da CONTRATADA, comprometendo-se a eliminar documentos e dados pessoais tão logo constatar a regularidade.
  <br> e) Caso as partes identifiquem qualquer tipo de incidente envolvendo os dados pessoais tratados em decorrência do presente contrato, deverão imediatamente comunicar uma a outra. A CONTRATADA deverá ser comunicada através do e-mail dpo@grupovolpato.com.br.
  <br> f) As partes deverão colaborar uma com a outra para atendimento das solicitações de direitos de titulares de dados pessoais ou, ainda, em procedimentos administrativos de órgãos reguladores, tais como Autoridade Nacional de Proteção de Dados – ANPD.
  <br> g) A CONTRATADA deverá eliminar os dados pessoais tratados em virtude do presente contrato logo após a extinção contratual, excecionando-se os casos em que a retenção for obrigatória para cumprimento de obrigação legal ou regulatória ou, ainda, para o exercício regular de direitos.
  <br> h) Desejando a parte CONTRATANTE informações adicionais sobre o tratamento de dados pessoais realizado a partir do presente contrato, está ciente de que deverá remeter e-mail para dpo@grupovolpato.com.br.
  <br> i) As partes são integralmente responsáveis por qualquer episódio de violação de dados pessoais e/ou de descumprimento da legislação aplicável a que vierem a dar causa durante a vigência do contrato, respondendo, cada uma delas, no limite de suas atribuições, sendo resguardado direito de indenização e regresso nos casos em que uma das partes for responsabilizada por irregularidades cometidas pela outra.
</p>



</div>


<div style="page-break-after:always;">
<p>
  <b>14. DISPOSIÇÕES GERAIS </b><br>
  <br> 14.1. Quaisquer avisos ou comunicações de uma PARTE para a outra, relativas a este contrato, deverá se dar sempre por escrito (carta registrada, fac-símile ou e-mail).
  <br><br> 14.2. A tolerância, por qualquer das partes, ao descumprimento de qualquer das disposições contidas no presente instrumento, não caracterizará alteração deste, nem mesmo configurará renúncia aos direitos decorrentes do respectivo descumprimento, salvo nas hipóteses aqui expressamente previstas.
  <br><br> 14.3. As PARTES, por seus prepostos e prestadores de serviço, obrigam-se a manter sigilo sobre quaisquer dados, materiais, documentos, especificações técnicas ou aperfeiçoamentos do conjunto deste contrato e seus anexos, de que venham a ter acesso ou conhecimento, ou ainda que lhes tenham sido confiados, não podendo, sob qualquer pretexto ou desculpa, omissão, culpa ou dolo, revelar, reproduzir, ou deles dar conhecimento a estranhos dessa contratação, salvo se houver consentimento expresso e, em conjunto, das PARTES. A responsabilidade das PARTES em relação à quebra de sigilo será proporcional aos efeitos do(s) prejuízo(s) causado(s).
  <br><br> 14.3.1. Fica expressamente previsto que ocorrendo falha na confidencialidade, a parte que deu causa responderá por eventuais prejuízos a parte contrária, na medida de sua participação no evento danoso.
  <br><br> 14.4. Fica eleito o foro desta Comarca de Porto Alegre, com expressa renúncia de outro qualquer, por mais privilegiado que seja, para dirimir quaisquer dúvidas oriundas do presente instrumento, ficando a parte vencida sujeita ao pagamento de custas judiciais e honorários advocatícios que forem arbitrados.
  E, por estarem assim justas e contratadas, as partes firmam o presente instrumento particular de contrato de prestação de serviços, em 02 (duas) vias de igual teor e forma, na presença das testemunhas instrumentais, abaixo assinadas.
</p>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:12px">
    <tr>
      <td height="45" colspan="2" align="center"> Porto  Alegre, ' . $dma[0] . ' de ' . $mes . ' de  ' . $dma[2] . '</td>
    </tr>
    <tr>
        <td height="40" align="center" >';
if ($list_cliente["tipo_assinatura"] == "ad") {
  $html .= '<img src="../img/assinatura1.jpg" alt="" width="143" height="45"  border="0"/>';
}
$html .= '</td>
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
if ($list_cliente['tipo_pessoa'] == 'F' || $list_cliente['tipo_pessoa'] == 'f') :
  $html .= '
        		<strong>CONTRATANTE  : </strong>' . $nome_cliente . '<br />   
        		<strong>CNPJ/CPF Nº  : </strong>' . $cpf_cliente . '<br />
        		<strong>NOME LEGÍVEL : </strong>' . $nome_cliente . '<br />
        		<strong>CPF N º      : </strong>' . $cpf_cliente . '<br />';
endif;
if ($list_cliente['tipo_pessoa'] == 'J' || $list_cliente['tipo_pessoa'] == 'j') :
  $html .= '
        			<strong>CONTRATANTE  : </strong>' . $list_cliente['nome_cliente'] . '<br />
        			<strong>CNPJ/CPF Nº  : </strong>' . $list_cliente['cnpjcpf_cliente'] . '<br />';
endif;
if (!empty($list_cliente['socio_1']) && empty($list_cliente['socio_2'])) :
  $html .= '
                  <strong>NOME LEGÍVEL : </strong>' . $list_cliente['socio_1'] . '<br />
                  <strong>CPF N º      : </strong>' . $list_cliente['cpf_socio1'] . '';
endif;
if (!empty($list_cliente['socio_1']) && !empty($list_cliente['socio_2'])) :
  $html .= '
                <strong>NOME LEGÍVEL : </strong>' . $list_cliente['socio_1'] . '<br />
                <strong>CPF N º      : </strong>' . $list_cliente['cpf_socio1'] . '<br />
                <strong>NOME LEGÍVEL : </strong>' . $list_cliente['socio_2'] . '<br />
                <strong>CPF N º      : </strong>' . $list_cliente['cpf_socio2'] . '';
endif;
$html .= '</div>
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
if ($list_cliente["tipo_assinatura"] == "ad") {
  $html .= '<img src="../img/assinaturas/' . $list_assinatura['assinatura'] . '" alt="" width="143" height="45"  border="0"/>';
}
$html .= ' </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>
          <div align="left" style=" margin:0;margin-right:10px; border-top:1px solid">
        	<strong>1º NOME : </strong>' . $list_assinatura['nome'] . '<br />
        	<strong> &nbsp; &nbsp; CPF: </strong>' . $list_assinatura['cpf'] . '<br />
          </div>
        </td>
        <td>
            <div align="left" style=" margin:0;margin-left:30px; border-top:1px solid; font-weight:bold">
              2º<br/>.
            </div>
        </td>
    </tr>
  </table>

';
