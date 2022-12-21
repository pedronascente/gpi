<?php
echo '<b> Data da criação da transação.             : </b>' . $transaction->date. '<br>' ;
echo '<b> Código identificador da transação         : </b>' . $transaction->code   . '<br>' ;
echo '<b> Código de referência da transação.        : </b>' . $transaction->reference. '<br>' ;
echo '<b> Tipo da transação.                        : </b>' . $transaction->type  . '<br>';
echo '<b> Status da transação.                      : </b>' . $transaction->status  . '<br>';
echo '<b> Origem do cancelamento.                   : </b>' . $transaction->cancellationSource  . '<br>';
echo '<b> Data do último evento..                   : </b>' . $transaction->lastEventDate  . '<br>';

/*Dados do meio de pagamento usado pelo comprador.*/

echo '<b> Tipo do meio de pagamento type.           : </b>' . $transaction->paymentMethod->type  . '<br>';
echo '<b> Tipo do meio de pagamento code.           : </b>' . $transaction->paymentMethod->code  . '<br>';

echo '<b> Valor bruto da transação..                : </b>' . $transaction->grossAmount  . '<br>';
echo '<b> Valor do desconto dado.                   : </b>' . $transaction->discountAmount  . '<br>';
echo '<b> Valor total das taxas cobradas.           : </b>' . $transaction->feeAmount  . '<br>';
echo '<b> Valor líquido da transação.               : </b>' . $transaction->netAmount  . '<br>';
echo '<b> Data de crédito.                          : </b>' . $transaction->escrowEndDate  . '<br>';
echo '<b> Valor extra.                              : </b>' . $transaction->extraAmount  . '<br>';
echo '<b> Número de parcelas.                       : </b>' . $transaction->installmentCount  . '<br>';
echo '<b> Número de itens da transação.             : </b>' . $transaction->itemCount  . '<br>'; 

/*
	Lista de itens contidos na transação. 
	O número de itens sob este elemento corresponde ao valor de itemCount.
*/


echo '<h1>Lista de itens contidos na transação. .</h1>';
echo '<p>O número de itens sob este elemento corresponde ao valor de itemCount.</p>';

foreach ($transaction->items->item as $key => $value) 
{
    echo '<b> Identificador do it  em.              : </b>' . $value->id . '<br>';
    echo '<b> Descrição do item.                	: </b>' . $value->description . '<br>';
    echo '<b> Valor unitário do item.               : </b>' . $value->amount. '<br>';
    echo '<b> Quantidade do item.                   : </b>' . $value->quantity  . '<br>';
    echo '<br>';
}

/*Dados do comprador.*/
echo '<h1>Dados do comprador.</h1>';
echo '<b> E-mail do comprador.                      : </b>' . $transaction->sender->email  . '<br>';
echo '<b> Nome completo do comprador.               : </b>' . $transaction->sender->name  . '<br>';
echo '<b> DDD do comprador   <areaCode>.      		: </b>' . $transaction->sender->phone->areaCode  . '<br>';
echo '<b> Número de telefone do comprador <number>. : </b>' . $transaction->sender->phone->number  . '<br>';

/*Dados do frete.*/
echo '<h1>Dados do frete.</h1>';
echo '<b> Tipo de frete.                            : </b>' . $transaction->shipping->type  . '<br>';
echo '<b>Custo total do frete.                      : </b>' . $transaction->shipping->cost  . '<br>';

/*Dados do endereço de envio.*/
echo '<h1>Dados do endereço de envio.</h1>';
echo '<b> País do endereço de envio.                : </b>' . $transaction->shipping->address->country  . '<br>';
echo '<b> Estado do endereço de envio.              : </b>' . $transaction->shipping->address->state  . '<br>';
echo '<b> Cidade do endereço de envio.              : </b>' . $transaction->shipping->address->city  . '<br>';
echo '<b> Cep do endereço de envio.                 : </b>' . $transaction->shipping->address->postalCode  . '<br>';
echo '<b> Bairro do endereço de envio.              : </b>' . $transaction->shipping->address->district  . '<br>';
echo '<b> Nome da rua do endereço de envio.         : </b>' . $transaction->shipping->address->street . '<br>';
echo '<b> Número do endereço de envio.              : </b>' . $transaction->shipping->address->number  . '<br>';
echo '<b> Complemento do endereço de envio.         : </b>' . $transaction->shipping->address->complement  . '<br>';