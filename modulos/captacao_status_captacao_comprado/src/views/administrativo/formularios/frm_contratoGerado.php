<div class="panel panel-primary">
    <div class="panel-heading">Formulário de Busca</div>
    <div class="panel-body">
        <form action="" method="GET" id="filtrarContrato">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Filtro:</label>
						<?php $_filtro = isset($_GET['filtro']) ?$_GET['filtro']: null; ?>
                        <select name="filtro"  class="form-control">
                            <option value="">Todos</option>
                            <option value="vendedorBuscar"  <?=($_filtro=="vendedorBuscar")?"selected":'';?>   >Vendedor</option>
                            <option value="clienteBuscar"  <?=($_filtro=="clienteBuscar")?"selected":'';?>   >Cliente</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Nome:</label>
                        <input type="text" name="campo" class="form-control"  />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-actions">
                        <input type="hidden" value="17" name="pg">
                        <button  type="submit" class="btn btn-primary">
                            Pesquisar
                        </button>
                        <button type="reset" class="btn btn-danger">
                            Limpar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>