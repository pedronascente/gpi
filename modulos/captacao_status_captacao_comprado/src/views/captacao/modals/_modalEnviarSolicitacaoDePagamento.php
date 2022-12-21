<div class="modal fade" id="_modalEnviarSolicitacaoDePagamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                  <h3 class="modal-title" id="exampleModalLabel"><b>Enviar Cobrança</b> </h3>
            </div>
            <div class="modal-body">
                <div class="alert " id="_alertModaPagSeguro"  style="display:none">
                    <strong>Success!</strong> Indicates a successful or positive action.
                </div>
                <form  method="post" id="formPagSeguro">
                    <div class="form-group">
                        <label class="form-control-label">Email: <span style="color:red">*</span></label>
                        <input type="text"  name="email_cliente"   id="_email_cliente"  class="form-control"  value="">
                        <span style="color:red; display: none" class=""  id="span-email">campo obrigatório.</span>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Cliente:<span style="color:red">*</span></label>
                        <input type="text" name="cliente"  id="_cliente"  class="form-control"   value="" >
                        <span style="color:red; display: none" class="" id="span-cliente">campo obrigatório.</span>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6 col-md-6 ">
                                <label class="form-control-label">Valor R$:<span style="color:red">*</span></label>
                                <input type="text"  name="itemAmount1"  id="_valor"  class="form-control mask_real" value="" >
                                <span style="color:red; display: none" id="span-valor">campo obrigatório.</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Descrição:<span style="color:red">*</span></label>
                        <textarea name="itemDescription1" class="form-control" id="_descricao" ></textarea>
                        <span style="color:red ;display: none" id="span-descricao">campo obrigatório.</span>
                    </div>
                    <div class="modal-footer " style="text-align: left">
                         <input type="hidden" name="reference"  id="_reference" value="">
                         <input type="hidden" name="itemId1" value="0001">
                         <input type="hidden" name="itemQuantity1" value="1">
                         <a href="javascript:void(0)" id="btn-enviarPagamento" class="btn btn-primary "  > Enviar</a>
                         <a href="javascript:void(0)" id="btn-sairModal" class="btn btn-danger" > Sair</a>
                         <p id="_error" style="display: none; text-align: center"><b>Enviando . . . .</b></p>
                    </div>
                </form>
            </div>    
        </div>
    </div>
</div>