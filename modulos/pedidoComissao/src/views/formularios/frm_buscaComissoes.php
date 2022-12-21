<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
        <?php
        $formularioBusca = new FormularioDeBusca;
        $formularioBusca->setPg($pg);
        $formularioBusca->setFiltro('busca');
        $formularioBusca->setMethod("GET");
        $formularioBusca->setValue($busca);
        $formularioBusca->formBusca();
        ?>
    </div>
</div>
