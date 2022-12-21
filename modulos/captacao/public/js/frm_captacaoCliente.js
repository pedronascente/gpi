$(function () {
    $(".deleteConsulta").submit(function () {
        if (confirmarDelete())
            return true;
        else
            return false;
    });

    var checked = 'f';

    $('#radio1').attr("checked", true);

    $(".consultarCPF").submit(function () {


        var cpf = $("#cnpjcpf_cliente").val();

        if (checked == 'f') {
            if (!validarCPF(cpf)) {
                alert("Por favor digite um cpf válido!")
                return false;
            }
        } else {
            if (!validarCNPJ(cpf)) {
                alert("Por favor digite um cnpj válido!")
                return false;
            }
        }

        return true;

    });

    $("input[name|='tipo_pessoa']").click(function () {
        var radio = $(this).val();
        checked = radio;
        if (radio == 'f') {
            $('#title_nome').text('Nome:');
            $('#title_cpf').text('CPF:');
            $('input[name="cnpjcpf_cliente"]').mask("000.000.000-00");
        }

        if (radio == 'j') {
            $('#title_nome').text('Razão Social:');
            $('#title_cpf').text('CNPJ:');
            $('input[name="cnpjcpf_cliente"]').removeClass('mask_cpf').mask("00.000.000/0000-00");
        }
    });
});