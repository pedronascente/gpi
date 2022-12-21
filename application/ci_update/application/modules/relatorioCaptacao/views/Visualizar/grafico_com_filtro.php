<div class="panel panel-primary">
    <div class="panel-heading "> <strong>Gráficos com Filtro</strong></div>
    <div class="panel-body"> 
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading"><b>Filtro geral</b> </div>
                    <div class="panel-body">
                         <?php $this->load->view('form/form_geral.php'); ?>
                        <div class="row">
                            <div class=" col-md-offset-9 col-md-3">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td class="text-center">
                                            <b>Total </b><br>
                                            <span style="color: red; font-size: 26px ;text-align:right" id="total_filtro">[ 00 ]</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>   
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading"><b>Status</b> com Filtro</div>
                    <div class="panel-body">
                        <?php $this->load->view('form/form_status.php'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="piechart_form_status" style="width: 500px; height: 300px; display: none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading"><b>UF</b> com Filtro</div>
                    <div class="panel-body">
                        <?php $this->load->view('form/form_uf.php'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="piechart_form_uf" style="width: 500px; height: 300px;display: none"></div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>     
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading"><b>Origem</b> com Filtro</div>
                    <div class="panel-body">
                        <?php $this->load->view('form/form_origem.php'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="piechart_form_origem" style="width: 500px; height: 300px; display: none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
        </div>
    </div>
</div>