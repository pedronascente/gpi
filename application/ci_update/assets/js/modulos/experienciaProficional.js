$(function () {
    //RESPOSSAVEL POR ADICIONAR MAIS FORMAÇÕES.
    var campo_inicialE = 1;
    var campo_maxE = 3;

    $('#btn-add-maisE').on('click',function (e) {
        e.preventDefault();
        if (campo_inicialE < campo_maxE) {
            $('#listaE').append(formataTagsE);
            _selectExperiencia(campo_inicialE);
            $('.datepicker').datepicker({ format: 'dd/mm/yyyy', language: 'pt-BR' });
            $('.mask_data').mask('99/99/9999');
            campo_inicialE++;
        }
    });

    //RESPOSSAVEL POR REMOVER EXPERIENCIAS PROFICIONAIS.
    $('#listaE').on("click", ".remover_campoE", function (e) {
        e.preventDefault();
        var _tr = $(this).attr('id');
        $('#listaE section.' + _tr).remove();
        campo_inicialE--;
    });
    
    function formataTagsE() {
        
        var _tagsE;
        _tagsE = '<section class="remove_selectionE' + campo_inicialE + '">'
                + '     <div class="row">'
                + '        <div class="col-xs-12  col-md-12">'
                + '            <div class="form-group">'
                + '                <label>Empresa:</label>'
                + '                <input class="form-control " type="text" name="EXPERIENCIAPROFISSIONAL[empresa][]"  value="" >'
                + '            </div>'
                + '        </div>'
                + '      </div>'
                + '     <div class="row">'
                + '      <div class="col-xs-12  col-sm-6 col-md-4">'
                + '	    <div class="form-group">'
                + '	        <label>Dat.Adimissão:</label>'
                + '	        <div class="input-group">'
                + '	            <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>'
                + '	            <input class="form-control datepicker  mask_data"  type="text" name="EXPERIENCIAPROFISSIONAL[dataAdimissao][]"  value="" >'
                + '	        </div>'
                + '	    </div>'
                + '	 </div>'
                + '	 <div class="col-xs-12  col-sm-6 col-md-4">'
                + '	    <div class="form-group">'
                + '	        <label>Dat.Demissão:</label>'
                + '	        <div class="input-group">'
                + '	            <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>'
                + '	            <input class="form-control datepicker  mask_data " type="text" name="EXPERIENCIAPROFISSIONAL[dataDemissao][]"  value="" >'
                + '	        </div>'
                + '	    </div>'
                + '	  </div>'
                + '       <div class="col-xs-12  col-sm-6 col-md-4">'
                + '            <div class="form-group">'
                + '                <label>Motivo:</label>'
                + '                <select  name="EXPERIENCIAPROFISSIONAL[motivo][]" class="form-control text-center" id="_selectExperiencia' + campo_inicialE + '" >'
                + '                   <option value="null">Selecione...</option>'
                + '                </select>'
                + '           </div>'
                + '       </div>'
                + '    </div>'
                + '    </div>'
                + '    <div class="row">'
                + '        <div class="col-xs-12 col-md-6">'
                + '            <div class="form-group">'
                + '                <label>Cargo:</label>'
                + '                <input class="form-control " type="text" name="esperienciaproficional[cargo][]"   value="" >'
                + '            </div>'
                + '        </div>'
                + '        <div class="col-xs-12 col-md-12">'
                + '            <div class="form-group">'
                + '                <label>Atividades:</label>'
                + '                <textarea class="form-control"  rows="5"  name="EXPERIENCIAPROFISSIONAL[atividade][]"></textarea>'
                + '            </div>'
                + '        </div>'
                + '    </div>'
                + '    <div class="row text-right">'
                + '        <div class="col-xs-12   col-md-12">'
                + '            <div class="form-group">'
                + '                 <a href="javascript:void(0)" class="btn btn-danger remover_campoE" id="remove_selectionE' + campo_inicialE + '">- Remover Esperiência</a>'
                + '            </div>'
                + '        </div>'
                + '    </div>'
                + '<section>';
        return _tagsE;
    }
    
    function _selectExperiencia(campo_inicialE) {
        var _option;
        var _url = $(location).attr('pathname');
        
        if(_url !='/rh/'){
           _url = '../TrabConosco/selectsJQ';
        }else{
            _url = 'TrabConosco/selectsJQ';
        }
    
        $.ajax({
            url: _url,
            dataType: 'json',
            data: {_tipoSelect: 'motivo'},
            type: 'post',
            success: function (obj) {
                _option += '<option value="null " >selecione...</option>';
                for (var i = 0; i < obj.motivo.length; i++) {
                    _option += '<option value="' + obj.motivo[i].descricao + '" >' + obj.motivo[i].descricao + '</option>';
                }
                $('#_selectExperiencia' + campo_inicialE + '').html(_option);
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        });
    }
    ;
});