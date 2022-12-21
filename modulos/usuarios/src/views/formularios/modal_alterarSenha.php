<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Alterar Senha</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <form action="modulos/usuarios/src/controllers/usuarios.php" name="form_alterar_senha" id="form_alterar_senha" method="post" class="loadForm">
            	<div class="row">
            		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            			<div class="form-group">
            				<label>Nova Senha:</label>
            				<input type="text" name="senha" class="form-control" required>
            			</div>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            			<div class="form-group">
            				<label>Confirma Senha:</label>
            				<input type="text" name="confirma_senha" class="form-control" required>
            			</div>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            			<div class="form-actions">
            				<input type="hidden" name="acao" id="alterar_senha" value="alterar_senha">
            				
            				<button type="submit" class="btn btn-primary botaoLoadForm">
                                Salvar
                            </button>
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            
            			</div>
            		</div>
            	</div>
            </form>
        </div>
    </div>
</div>

