$(function () {
   
	_servidor ='/gpi/application/';
        
    $.when($.getJSON(_servidor + 'ci_update/relatoriocaptacao/geral')).then(function (a) {
        var _html_bloco_1 = '';
        var _cores = ['#76A7FA', '#006dcc', '#1b6d85', '#337ab7', '#109618', '#990099', '#333333', '#bf2744'];
        $.each(a.ano, function(k, v) {
            if (v.total){
            _html_bloco_1 += '<div class="col-md-3">'
                + '<div class="panel panel-primary">'
                + '<div class="panel-heading"   style="background:' + _cores[k] + '"  >' + v.ANO + '</div>'
                + '<div class="panel-body"><b>' + v.total + '  , Leads</b></div>'
                + '</div>'
                + '</div>';
            }
            $("#box-anual-bloco-1").html(_html_bloco_1);
        });
        google.charts.load("current", {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var array_data = [];
            var _cores = ['#76A7FA', '#006dcc', '#1b6d85', '#337ab7', '#109618', '#990099', '#333333', '#bf2744'];
            array_data[0] = ['Year', 'Leads', {role: 'style'}];
            $.each(a.ano, function(k, v) {
                array_data[k + 1] = [v.ANO, parseInt(v.total), _cores[k]];
            });
            var data = google.visualization.arrayToDataTable(array_data);
            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
            {calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"},
                    2]);
            var options = {
            title: "Gráfico anual",
                    width: 540,
                    height: 400,
                    bar: {groupWidth: "95%"},
                    legend: {position: "none"},
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
            chart.draw(view, options);
        };
        google.charts.setOnLoadCallback(drawChart2);
        function drawChart2() {
            var array_status = [];
            array_status[0] = ['Task', 'Hours per Day'];
            $.each(a.captacao_status, function(k, v) {
                array_status[k + 1] = [v.captacao_status, parseInt(v.total)];
            });
            var data = google.visualization.arrayToDataTable(array_status);
            var options = {
            title: 'Status ',
                    is3D: false,
            };
            var chart = new google.visualization.PieChart(document.getElementById('macro_status'));
            chart.draw(data, options);
        }
        google.charts.setOnLoadCallback(drawChart3);
        function drawChart3() {
            var array_origem = [];
            array_origem[0] = ['Task', 'Hours per Day'];
            $.each(a.origem, function(k, v) {
                array_origem[k + 1] = [v.origem, parseInt(v.total)];
            });
            var data = google.visualization.arrayToDataTable(array_origem);
            var options = {
            title: 'Origem ',
                is3D: false,
            };
            var chart = new google.visualization.PieChart(document.getElementById('macro_origem'));
            chart.draw(data, options);
        }
        google.charts.setOnLoadCallback(drawChart4);
        function drawChart4() {
            var array_uf = [];
            array_uf[0] = ['Task', 'Hours per Day'];
            $.each(a.captacao_uf, function(k, v) {
                array_uf[k + 1] = [v.uf, parseInt(v.total)];
            });
            var data = google.visualization.arrayToDataTable(array_uf);
            var options = {
            title: 'Estado - UF ',
                is3D: false,
            };
            var chart = new google.visualization.PieChart(document.getElementById('macro_uf'));
            chart.draw(data, options);
        }
        var html_select_origem = '<option value="null"> :: Selecione :: </option>';
        $.each(a.selects.origem, function(k, v) {
            html_select_origem += '<option value="' + v.origem + '"> ' + v.origem + ' </option>';
        });
        var html_select_uf = '<option value="null"> :: Selecione :: </option>';
        $.each(a.selects.uf, function(k, v) {
            html_select_uf += '<option value="' + v.captacao_uf + '"> ' + v.captacao_uf + ' </option>';
        });
        var html_select_status = '<option value="null"> :: Selecione :: </option>';
        $.each(a.selects.status, function(k, v) {
            html_select_status += '<option value="' + v.captacao_status + '"> ' + v.captacao_status + ' </option>';
        });
        $('.select_origem').html(html_select_origem);
        $('.select_uf').html(html_select_uf);
        $('.select_status').html(html_select_status);
    });
    $(".mask_data").mask('00/00/0000');
    $('._datepicker_data').datepicker({
        format: 'yyyy-mm-dd',
        //language: 'en'
        format: 'dd/mm/yyyy',                
        language: 'pt-BR'
    });
    //REQUISIÇÕES FORMULARIOS   :     
    $('#FORM_GERAL').submit(function(){
        var x = $(this).serializeArray();
        var param = {};
        var url = "";
        $.each(x, function(i, field){
            param[field.name] = field.value;
        });        
        var periodo = formata_data(param.data_inicial,param.data_fim);
        
        url = _servidor + "ci_update/relatoriocaptacao/filtros/" + param.captacao_status + "/" + param.origem + "/" + param.uf + "/" + periodo;
        $.when($.getJSON(url)).then(function (a) {
            $('#total_filtro').text(a.total_leads[0].total);
        });
        return false;
    });
    $('#FORM_STATUS').submit(function(){
        var x = $(this).serializeArray();
        var param = {};
        var url = "";
        $.each(x, function(i, field){
             param[field.name] = field.value;
        });
        var periodo = formata_data(param.data_inicial,param.data_fim);
        url = _servidor + "ci_update/relatoriocaptacao/status/" + param.origem + "/" + param.uf + "/" + periodo;
        $.when($.getJSON(url)).then(function (a) {
            google.charts.setOnLoadCallback(drawChartFORM_STATUS);
            function drawChartFORM_STATUS() {
                var array_data = [];
                array_data[0] = ['Task', 'Hours per Day'];
                $.each(a.captacao_status, function(k, v) {
                    array_data[k + 1] = [v.captacao_status, parseInt(v.total)];
                });
                var data = google.visualization.arrayToDataTable(array_data);
                var options = {
                title: 'Status',
                        is3D: false,
                };
                var chart = new google.visualization.PieChart(document.getElementById('piechart_form_status'));
                chart.draw(data, options);
            }
            $('#piechart_form_status').css('display', 'block');
        });
        return false;
    });
    $('#FORM_ORIGEM').submit(function(){
        var x = $(this).serializeArray();
        var param = {};
        var url = "";
        $.each(x, function(i, field){
            param[field.name] = field.value;
        });
        var periodo = formata_data(param.data_inicial,param.data_fim);
        url = _servidor + "ci_update/relatoriocaptacao/origem/" + param.status + "/" + param.uf + "/" + periodo;
        $.when($.getJSON(url)).then(function (a) {
            google.charts.setOnLoadCallback(drawChartFORM_ORIGEM);
            function drawChartFORM_ORIGEM() {
                var array_data = [];
                array_data[0] = ['Task', 'Hours per Day'];
                $.each(a.origem, function(k, v) {
                    array_data[k + 1] = [v.origem, parseInt(v.total)];
                });
                var data = google.visualization.arrayToDataTable(array_data);
                var options = {
                title: 'Origem',
                    is3D: false,
                };
                var chart = new google.visualization.PieChart(document.getElementById('piechart_form_origem'));
                chart.draw(data, options);
            }
            $('#piechart_form_origem').css('display', 'block');
        });
        return false;
    });
    $('#FORM_UF').submit(function(){
            var x = $(this).serializeArray();
            var param = {};
            var url = "";
            $.each(x, function(i, field){
                param[field.name] = field.value;
            });
            var periodo = formata_data(param.data_inicial,param.data_fim);
            url = _servidor + "ci_update/relatoriocaptacao/uf/" + param.status + "/" + param.origem + "/" + periodo;
            $.when($.getJSON(url)).then(function (a) {
            google.charts.setOnLoadCallback(drawChartFORM_UF);
            function drawChartFORM_UF() {
                var array_data = [];
                array_data[0] = ['Task', 'Hours per Day'];
                $.each(a.uf, function(k, v) {
                     array_data[k + 1] = [v.captacao_uf, parseInt(v.total)];
                });
                var data = google.visualization.arrayToDataTable(array_data);
                var options = {
                title: 'UF',
                    is3D: false,
                };
                var chart = new google.visualization.PieChart(document.getElementById('piechart_form_uf'));
                chart.draw(data, options);
            }
            $('#piechart_form_uf').css('display', 'block');
        });
        return false;
    });    
    function formata_data(data_inicial,data_fim){
        var di=data_inicial.split('/');
        var df =data_fim.split('/');
        var data_inicial =di[2]+'-'+di[1]+'-'+di[0]; 
        var data_fim =df[2]+'-'+df[1]+'-'+df[0]; 
        return  data_inicial+"a"+data_fim;
       
    }
});