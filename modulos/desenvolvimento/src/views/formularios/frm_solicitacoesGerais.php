<form action="" method="GET" >
    <div class="row">
    	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
        	<div class="form-group">
                <label>Filtro:</label>
                <select name="filtro" class="form-control">
                    <option></option>
                    <option value="codigo">Número</option>
                    <option value="solicitante">Solicitante</option>
                    <option value="setor">Setor</option>
                    <option value="titulo">Título</option>
                    <option value="programador">Consultor</option>
                </select>
            </div> 
        </div>
        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
        	<div class="form-group">
                <label>Nome:</label>
                <input type="text" name="texto" class="form-control">
            </div> 
        </div>
        <?php if(!$ti){?>
        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
        	 <div class="form-group">
                <label>Setor:</label>
                <select name="modulo" class="form-control">
                    <option></option>
                    <option value="1">Desenvolvimento</option>
                    <option value="2">Suporte</option>
                </select>    
            </div>
        </div>
        <?php }?>
        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
            <div class="form-group">
                <label>Status:</label>
                <select name="status" class="form-control">
                    <option></option>
                    <option value="0">Em Análise</option>
                    <option value="1">Aprovada</option>
                    <option value="2">Iniciada</option>
                    <option value="4">Em Testes</option>
                    <option value="3">Parada</option>
                    <option value="5">Finalizada</option>
                    <option value="6">Reprovada</option>
                    <option value="7">Bug</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
        	 <div class="form-group">
                <label>Nivel:</label>
                <select name="nivel" class="form-control">
                    <option></option>
                    <option value="1">Urgente</option>
                    <option value="2">Normal</option>
                    <option value="3">Baixo</option>
                </select>    
            </div>
        </div>
        <?php if($desenvolvedor || $supervisor){?>
        <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
        	 <div class="form-group">
                <label>Tipo:</label>
                <select name="tipo" class="form-control">
                    <option></option>
                    <option value="1">Problema</option>
                    <option value="2">Projeto</option>
                </select>    
            </div>
        </div>
        <?php }?>
        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2" style="position:relative; top:25px; margin-bottom:30px">
        	<div class="form-actions">
                <input type="hidden" name="pg" value="23"> 
                <input type="hidden" value="pesquisarGeral" name="acao">
                <button  type="submit" class="btn btn-primary botaoLoadForm">
                    Pesquisar
                </button>
                
                <button type="reset" class="btn btn-danger limpa">
                   Limpar
                </button>
            </div>
        </div>	
    </div>
</form>