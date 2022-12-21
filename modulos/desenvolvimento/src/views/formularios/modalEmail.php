<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">E-mail</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
        	<form action="modulos/desenvolvimento/src/controllers/desenvolvimento.php" method="POST">
        		<div class="col-xs12 col-sm-12 col-md-12 col-lg-12">
        			<div class="form-group">
        				<label>Destinatário:</label>
        				<input type="email" name="email" class="form-control" required="required">
        			</div>
        		</div>
        		<div class="col-xs12 col-sm-12 col-md-12 col-lg-12">
        			<div class="form-group">
        				<label>Titulo:</label>
        				<input type="text" name="titulo" class="form-control" required="required">
        			</div>
        		</div>
        		<div class="col-xs12 col-sm-12 col-md-12 col-lg-12">
        			<div class="form-group">
        				<label>Mensagem:</label>
        				<textarea name="mensagem" class="form-control"></textarea>
        			</div>
        		</div>
	        	<div class="row">
	        		<div class="col-xs12 col-sm-12 col-md-12 col-lg-12">
	        			<div class="form-actions">
	        				
	        				<input type="hidden" name="id" value="<?=filter_input(INPUT_GET, "id");?>">
	        				<input type="hidden" name="tab" value="<?=filter_input(INPUT_GET, "tab");?>">
	        				<input type="hidden" name="acao" value="enviarEmail">
	        			
	        				<button type="submit" class="btn  btn-primary">Salvar</button>
	        				
	        				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	        				
	        			</div>
	        		</div>
	        	</div>
        	</form>
        </div>
    </div>
</div>
