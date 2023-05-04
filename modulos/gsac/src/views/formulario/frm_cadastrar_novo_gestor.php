<div class="panel panel-primary">
    <div class="panel-heading ">Cadastrar Gestor</div>
    <div class="panel-body"> 
        <form action="index.php?pg=67" method="post"> 
            <div class="row">
                <div class="col-xs-12 col-sm-4  col-md-4">
                    <div class="form-group">
                        <label>Nome:</label>
                        <input type="text" name="gestor"  class=" form-control" required="true"  placeholder="Digite o nome do gestor" />
                    </div>
                </div>
                 <div class="col-xs-12 col-sm-4  col-md-4">
                    <div class="form-group">
                        <label>Ramal:</label>
                        <input type="text" name="ramal" class="form-control" required="true" placeholder="Digite  o Ramal" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
				<hr>
                    <input type="submit" class="btn btn-success"  value="Salvar">
					<a href="/gpi/index.php?pg=61" class="btn  btn-danger">Voltar</a>
                </div>
            </div>
        </form>
    </div>
</div>