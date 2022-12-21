$(function () {
    //RESPOSSAVEL POR ADICIONAR MAIS FORMAÇÕES.
    var campo_inicial = 1;
    var campo_max = 3;

    $('#btn-add-mais').click(function (e) {
        e.preventDefault();
        if (campo_inicial < campo_max) {
            $('#lista').append(formataTags());
            _selectFormacao(campo_inicial);
            campo_inicial++;
        }
    });

    //RESPOSSAVEL POR REMOVELR FORMAÇÕES.
    $('#lista').on("click", ".remover_campo", function (e) {
        e.preventDefault();
        var tr = $(this).attr('id');
        $('#lista section.' + tr).remove();
        campo_inicial--;
    });

    function formataTags() {
        var _tags;
        _tags = '<section class="remove_section' + campo_inicial + '">'
                + '<div class="row">'
                + '     <div class="col-xs-12  col-sm-6 col-md-4">'
                + '         <div class="form-group">'
                + '             <label>Forma&ccedil;&atilde;o:</label>'
                + '             <select class="form-control " name="FORMACAO[formacao][]" id="_selectFormacao' + campo_inicial + '" >'
                + '                 <option value="null " >selecione...</option>'
                + '             </select>'
                + '         </div>'
                + '     </div>'
                + '</div>'
                + '<div class="row">'
                + '     <div class="col-xs-12 col-md-12">'
                + '         <div class="form-group">'
                + '           <label>Curso:</label> '
                + '           <input class="form-control " type="text" name="FORMACAO[curso][]"  value="" >'
                + '       </div>'
                + '     </div>'
                + '</div>'
                + '<div class="row">'
                + '    <div class="col-xs-12 col-md-12">'
                + '        <div class="form-group">'
                + '            <label>Institui&ccedil;&atilde;o:</label> '
                + '            <input class="form-control " type="text" name="FORMACAO[instituicao][]"  value="" >'
                + '        </div>'
                + '    </div>'
                + '</div>'
                + '<div class="row  text-right">'
                + '    <div class="col-xs-12 col-md-12">'
                + '        <div class="form-group">'
                + '            <a href="javascript:void(0)" class="btn btn-danger remover_campo" id="remove_section' + campo_inicial + '">- Remover Forma&ccedil;&atilde;o</a>'
                + '        </div>'
                + '    </div>'
                + '</div>'
                + '</section>';

        return _tags;
    }
    ;
    function _selectFormacao(campo_inicial) {
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
            data: {_tipoSelect: 'formacao'},
            type: 'post',
            success: function (obj) {
                _option += '<option value="null " >Selecione...</option>';
                for (var i = 0; i < obj.formacao.length; i++) {
                    _option += '<option value="' + obj.formacao[i].descricao + '" >' + obj.formacao[i].descricao + '</option>';
                }
                $('#_selectFormacao' + campo_inicial + '').html(_option);
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        });
    }
    ;
});