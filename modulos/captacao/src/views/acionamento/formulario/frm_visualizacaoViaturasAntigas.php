<div class="panel panel-primary">
    <div class="panel-heading "> Pesquisar Dados Antigos  </div>
    <div class="panel-body"> 
        <form action="" method="GET">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
						<input type="hidden" name="pg" value="28">
						<label>Selecione Mês :</label>
                        <select name="month" class="form-control" required="">
                            <option value=''>Selecione...</option>
                            <option value='1' <?=$month==1 ? 'selected' :''?>>Janeiro</option>
                            <option value='2' <?=$month==2 ? 'selected' :''?>>Fevereiro</option>
                            <option value='3' <?=$month==3 ? 'selected' :''?>>Março</option>
                            <option value='4' <?=$month==4 ? 'selected' :''?>>Abril</option>
                            <option value='5' <?=$month==5 ? 'selected' :''?>>Maio</option>
                            <option value='6' <?=$month==6 ? 'selected' :''?>>Junho</option>
                            <option value='7' <?=$month==7 ? 'selected' :''?>>Julho</option>
                            <option value='8' <?=$month==8 ? 'selected' :''?>>Agosto</option>
                            <option value='9' <?=$month==9 ? 'selected' :''?>>Setembro</option>
                            <option value='10' <?=$month==10 ? 'selected' :''?> >Outubro</option>
                            <option value='11' <?=$month==11 ? 'selected' :''?>>Novembro</option>
                            <option value='12' <?=$month==12 ? 'selected' :''?>>Dezembro</option>
                        </select>
                    </div>
					<div class="form-group">
                        <label>Selecione o Ano:</label>
                        <select name="ano" class="form-control" required="">
                            <option value=''>Selecione...</option>
							<?php
                            $d = date('Y');
								for($i=$d ; $i>=2014;$i--){
									$_selected = $ano== $i ? 'selected' :'';
									echo "<option value='".$i."' ".$_selected."  >".$i."</option>";
								}
							?>
                        </select>
                    </div>
                    <div class="form-group">
                         <input type="submit" value="OK" class="btn btn-primary">
                         <a href="?pg=26#tab2" class="btn btn-success">Voltar</a>
                    </div>
                </div>
            </div>
        </form>			
    </div>
</div>  