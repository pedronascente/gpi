<?php
    $html .='
      
    <p align="justify">
          <strong>
            CLÁUSULA PRIMEIRA – OBJETO
          </strong>
          <br>
          1.1	- Por este CONTRATO e na melhor forma de direito, a CONTRATADA compromete-se a prestar ao CONTRATANTE os serviços de monitoramento por GPS/GPRS para o(s) veículo(s) especificado(s) no item II do presente, doravante denominado de SERVIÇO e tão somente este, não cobrindo danos decorrentes de danos morais e/ou materiais, responsabilidade civil, lucros cessantes e/ou qualquer prejuízo por destruição, perda ou reclamação que possa ser diretamente ou indiretamente decorrentes de acidentes, caso fortuito, roubo ou força maior de qualquer natureza, salvo nos casos de contratação dos serviços de proteção patrimonial previstos no anexo II do presente contrato.<br>
          1.2	- O SERVIÇO, ora contratado, poderá eventualmente sofrer interferências ou zonas de sombra, dependendo da localização do veículo rastreado;<br>
          1.3	- O SERVIÇO será prestado durante as 24 (vinte e quatro) horas do dia, 07 (sete) dias por semana, inclusive durante feriados;
    </p>
    <p align="justify">
          <strong>
            CLÁUSULA SEGUNDA - OBRIGAÇÕES DA CONTRATADA
          </strong>
          <br>
            2.1	- Os serviços a cargo da CONTRATADA compreendem:<br>
            a)	Monitorar o (s) veículo (s) da CONTRATANTE, de forma ininterrupta, com pessoal especializado, encaminhando com presteza qualquer solicitação por parte do CONTRATANTE;<br>
            b)	Acionar em âmbito nacional o deslocamento de Pronta Resposta e/ou Polícias, visando à localização e resgate do veículo monitorado após roubo ou furto do mesmo;<br>
            c)	A mão de obra para instalar o Módulo Rastreador e a realização de testes de finalização da instalação e da comunicação entre o equipamento de rastreamento e a Central de Monitoramento da CONTRATADA que são necessários para o perfeito funcionamento do sistema;<br>
            d)	Prestar assistência técnica e reposição de peças, exceto nos casos de uso indevido por parte da CONTRATANTE. A manutenção e assistência técnica serão efetuadas exclusivamente pela CONTRATADA, <br>
            e)	A CONTRATADA não prestará qualquer informação sobre o veículo rastreado por satélite sem a correta identificação do cliente, código, senha ou contra-senha do mesmo, onde os dados cadastrados são de inteira responsabilidade do CONTRATANTE;<br>
            f)	Realizar os tramites legais de filiação do CONTRATANTE a Associação de Proteção Patrimonial do Brasil – APPBR, para que este usufrua dos benefícios da condição de associado da mesma. 
    </p>
    <p align="justify">
          <strong>
            CLÁUSULA TERCEIRA - OBRIGAÇÕES DO CONTRATANTE
          </strong>
          <br>
           3.1	São obrigações do CONTRATANTE:<br>
            a)	Manter atualizado os dados cadastrais do veículo rastreado e seu proprietário/condutor junto à CONTRATADA;<br>
            b)	Não permitir que pessoas desautorizadas utilizem o sistema ou se faça qualquer tipo de manutenção no equipamento;<br>
            c)	Notificar, imediatamente, os órgãos de Segurança Pública em caso de envolvimento em ocorrência policial, bem como à CONTRATADA;<br>
            d)	Efetuar manutenção somente pelos técnicos autorizados pela CONTRATADA, de acordo com a periodicidade exigida para o bom funcionamento do sistema e equipamentos;<br>
            e)	Manter o sistema elétrico do veículo em perfeitas condições de conservação e uso;<br>
            f)	A CONTRATANTE fica expressamente obrigada a realizar um teste mensal de comunicação entre a central de Monitoramento e o equipamento de rastreamento instalado no veículo do CONTRATANTE. O teste mensal deve ser realizado conforme descrição da letra “f”, da Cláusula 8, do Anexo II.<br>
            g)	A CONTRATANTE é obrigada a preencher e assinar a Ficha de Adesão a condição de associado na Associação de Proteção Patrimonial Brasil – APPBR, para que a CONTRATADA possa dar inicio aos tramites legais da associação do CONTRATANTE.<br>
            h)	Fica expressamente vedado ao CONTRATANTE, em qualquer hipótese, permitir a interferência de terceiros na manutenção das instalações, sob pena de responder pelos danos causados e pelos respectivos reparos dos equipamentos, assim como perder os benefícios da proteção patrimonial oferecidos pela Associação de Proteção Patrimonial Brasil – APPBR.<br>
    </p>
    <p align="justify">
          <strong>
            CLÁUSULA QUARTA PREÇO E REAJUSTAMENTO
          </strong>
          <br>
            4.1	- Pela instalação dos equipamentos de rastreador, ativação dos serviços de rastreamento e monitoramento veicular, da Proteção Patrimonial e da Assistência Veicular, sendo este ultima opcional, a CONTRATANTE pagará os valores descritos no item III - Taxa de Monitoramento (soma dos serviços contratados);<br>
            4.2	- Será fornecido ao CONTRATANTE, em regime de comodato, para cada veículo rastreado, 01 (um) Kit de Rastreamento, contendo os seguintes itens:<br>
                a) 01 (um) Módulo rastreador;<br>
                b) 01 (um) CHIP de dados GPRS;<br>
                c) 01 (um) Chicote padrão de ligações elétricas com 1 (UM) relé embutido; <br>
                d) 01 (um) acessório de segurança extra.<br>';
            if($list_cliente['tipo_cadastro']=='rastreador'){
                  $html.='4.2.2 - A CONTRATANTE desde já se declara ciente de que ao término do contrato, independentemente do motivo, deverá devolver à CONTRATADA os equipamentos de 	rastreadores instalados nos veículos cujo cancelamento tenha se operado, sob pena de reembolso a CONTRATADA, ficando desde já estabelecido o valor de R$ 750,00 (setecentos e cinqüenta reais) caso não ocorra à devolução do Kit de Rastreamento descrito na Cláusula 4.2;<br>';
            }else{
                  $html.='4.2.1 - O SIM CARD (Chip) é propriedade da Volpato Serviços de Segurança Ltda, cedido sob forma de comodato para o cumprimento das obrigações assumidas no presente instrumento;<br>';
            }

    $html.=' </p>       
  <p align="justify">
       4.3	- A título de Taxa de Monitoramento (mensalidade) pelos serviços prestados, a CONTRATANTE pagará a CONTRATADA, mensalmente, a soma dos serviços contratos e descritos no item III do presente contrato;<br>
            4.4 - Os pagamentos efetuados após a data do seu vencimento sofrerão multa moratória de 2% (dois por cento), juros de 1% (um por cento) ao mês e correção monetária baseada na variação do IGP-M da FGV ou outro índice legal que venha a lhe substituir;<br>
            4.5 - O não pagamento da Taxa de Monitoramento, especificada no item III deste contrato, autoriza a CONTRATADA, independentemente de qualquer notificação, a desabilitar imediatamente, remota e fisicamente, o sistema de rastreamento por GPS/GPRS, assim como proceder a suspensão dos demais serviços contratos, inclusive, aqueles ligados aos benefícios de Associado da Associação de Proteção Patrimonial Brasil – APPBR, com a conseqüente perda dos direitos dela oriundos, tais como a perda da Proteção Patrimonial do veículo do CONTRATANTE.  Ficando, ainda, expressamente previsto, que no caso de o CONTRATANTE não efetuar o pagamento dos débitos junto a CONTRATADA, ficará obrigado a devolver o Kit de Rastreamento e saldar o débito existente, sendo que a CONTRATADA poderá, ainda, enviar o nome do CONTRATANTE inadimplente para a inscrição nos Serviços de Proteção ao Crédito e demais cadastros semelhantes, mediante prévia notificação;<br>
            4.6 - Após 12 (doze) meses contados do início da prestação dos Serviços, os valores serão automaticamente reajustados anualmente, de acordo com a variação acumulada do IGP-M/FGV do período.
    </p>
    </div>
    <p align="justify">
          <strong>
            CLÁUSULA QUINTA - CESSÃO DO CONTRATO
          </strong>
          <br>
          5.1 – Nenhuma das Partes poderá Ceder ou Transferir este CONTRATO sem expressa anuência da outra Parte; 
    </p>
    <p align="justify">
          <strong>
            CLÁUSULA SEXTA - PRAZO
          </strong>
          <br>
          6.1	- O presente Contrato de Prestação de Serviço de Monitoramento terá vigência por 12 (doze) meses, renovando-se automaticamente, por iguais períodos de 12 (doze) meses sucessivamente, salvo denunciação, por qualquer das partes, com a notificação expressa da outra parte, neste caso, respeitando o período de 30 dias de aviso prévio, conforme cláusula 7.2 deste contrato.  
    </p>
    <p align="justify">
        <strong>
          CLÁUSULA SÉTIMA - RESCISÃO
        </strong>
        <br>
        7.1	- O presente contrato será rescindido na ocorrência de qualquer um dos seguintes motivos:<br>
            a)	Descumprimento de qualquer obrigação contratual ou legal;<br>
            b)	Falência ou insolvência de qualquer uma das partes;<br>
            c)	Cessão do Contrato, sem expressa e prévia anuência da CONTRATADA;<br> 
            d)	Utilização do sistema GPS/GPRS pra fins adversos ao do contrato;<br>
        7.2	- O presente instrumento contratual, depois de transcorridos os 12 (doze) meses, pode ser denunciado por qualquer das partes, sem qualquer ônus à parte denunciante, mediante aviso prévio, por escrito, da parte denunciada, com antecedência mínima de 30 (trinta) dias;<br>
        7.2.1	- Em caso de cancelamento/rescisão por iniciativa do CONTRATANTE ocorrida antes de completar os 12 (doze) meses de vigência do presente contrato, será devida pelo CONTRATANTE, uma indenização, correspondente a mão de obra para realização da retirada do equipamento de rastreador do veículo cancelado, ficando desde já estabelecido o valor de R$ 150,00 (cento e cinqüenta reais) por retirada de cada equipamento/veículo. 
    </p>
    <p align="justify">
        <strong>
          CLÁUSULA OITAVA - DISPOSIÇÕES GERAIS
        </strong>
        <br>
        8.1 - Quaisquer avisos ou comunicações de uma PARTE para a outra, relativas a este contrato, deverá se dar sempre por escrito (carta registrada, fac-símile ou e-mail), salvo nos casos de solicitação/notificação de cancelamento, sendo que nestes casos se faz necessária a comunicação expressa através de Carta Registrada, ou outra maneira inequívoca de ciência da outra parte.<br>
        8.2 - Qualquer concessão ou tolerância de uma PARTE ou outra, quando não manifestada por escrito, não importará em renúncia ao direito de renovação, mas mera liberalidade da mesma;<br>
        8.3 - As PARTES elegem o foro da comarca de Porto Alegre/RS, com renúncia a qualquer outro, por mais privilegiado que seja para dirimir quaisquer dúvidas ou questões que possam decorrer deste contrato;<br>
        E, por estarem assim justas e contratadas, as PARTES firmam este CONTRATO em 02 (duas) vias de igual teor e forma, para um só efeito, juntamente com as duas testemunhas firmatárias, para que produza seus efeitos jurídicos e legais.
    </p>
    
    ';