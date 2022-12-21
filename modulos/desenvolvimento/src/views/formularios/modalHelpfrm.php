<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Help</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
        	<form action="modulos/desenvolvimento/src/controllers/desenvolvimento.php" method="POST">
	        	<div class="row" id="motivo">
	        		<div class="col-xs12 col-sm-12 col-md-12 col-lg-12">
	        			<div class="form-group">
	        				<label>Descrição do Problema:</label>
	        				<textarea rows="5" class="form-control" name="log_motivo" id="log_motivo"></textarea>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-xs12 col-sm-12 col-md-12 col-lg-12">
	        			<div class="form-actions">
	        				
	        				<input type="hidden" name="desenvolvimento_id" value="<?=filter_input(INPUT_GET, "desenvolvimento_id");?>">
	        				<input type="hidden" name="acao" value="help">
	        				<input type="hidden" name="desenvolvimento_help" value="1">
	        			
	        				<button type="submit" class="btn  btn-primary">Salvar</button>
	        				
	        				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	        				
	        			</div>
	        		</div>
	        	</div>
        	</form>
        </div>
    </div>
</div>
