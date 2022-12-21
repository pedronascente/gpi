$(function () {

        var mapOptions = {
            center: new google.maps.LatLng(-14.235004, -51.92527999999999),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 2
        };


        map = new google.maps.Map(document.getElementById('mapa2'), mapOptions);
        bounds = new google.maps.LatLngBounds();

        map.setCenter(new google.maps.LatLng(-14.235004, -51.92527999999999));

        $('#tabMapa').on('shown.bs.tab', function (e) {
            z = map.getZoom();
            c = map.getCenter();
            google.maps.event.trigger(map, 'resize');
            map.setZoom(z);
            map.setCenter(c);
        });
        
        var options = {
		  componentRestrictions: {country: "br"}
		 };

        //AUTOCOMPLETE
        var input = document.getElementById('mapa_address');
        autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener('place_changed', mudarLocal);

        var worldCoords = [
            new google.maps.LatLng(-85.1054596961173, -180),
            new google.maps.LatLng(85.1054596961173, -180),
            new google.maps.LatLng(85.1054596961173, 180),
            new google.maps.LatLng(-85.1054596961173, 180),
            new google.maps.LatLng(-85.1054596961173, 0)];

        $.getJSON("modulos/monitoramento/public/js/brasil_coordenadas.json", function (data) {
            var BrasilCords = new Array();
            $.each(data, function (key, value) {
                BrasilCords.push(new google.maps.LatLng(value[1], value[0]));
            });

            // Construct the polygon.
            poly = new google.maps.Polygon({
                paths: [worldCoords, BrasilCords],
                geodesic: true,
                strokeColor: "transparent",
            });

            poly.setMap(map);

        });


        //limitar zomm
        google.maps.event.addListener(map, 'zoom_changed', function () {
            if (map.getZoom() <
                    3)
                map.setZoom(3);
        });


        //CARREGAR GUINCHOS
        var guinchos = [];
        var guinchos2 = [];
        var guinchosC2 = [];
        var proximos = [];

        $.ajax({
            url: 'modulos/monitoramento/src/controllers/monitoramento.php',
            dataType: 'json',
            type: 'post',
            data: {
                acao: 'pegarGuinchos'
            },
            success: function (result) {
                markers = result;

                var lat = $("#latitude").text();
                var long = $("#longitude").text();
                var llat = $("#assistencia_local_lat").val();
                var llong = $("#assistencia_local_long").val();
                var status = $("#status").val();

                if (llat != "" && llong != "") {
                    var position = new google.maps.LatLng(llat, llong);
                    map.setCenter(position);
                    map.setZoom(10);

                    var markerAtual = new google.maps.Marker({
                        icon: "public/img/blue_MarkerL.png",
                        position: position,
                        map: map
                    });

                    markerAnterior = markerAtual;

                    bounds.extend(position);

                    var infoWindow = new google.maps.InfoWindow(), markerAtual;

                    markerAtual.addListener('click', function () {
                        infoWindow.setContent($("#mapa_address").val());
                        infoWindow.open(map, markerAtual);
                    });
                }


                if (markers != null && markers.length != 0) {

                    for (i = 0; i < markers.length; i++) {


                        if (!empty(markers[i][1]) && !empty(markers[i][2])) {

                            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);

                            var icone = "public/img/marker.png";

                            if (lat == markers[i][1] && long == markers[i][2]) {
                                icone = "public/img/green_MarkerG.png";

                                selectGuinchos(lat, long);
                                
                            } else if(markers[i][4] == 1){
                            	icone = "public/img/marker-orange.png";
                            }

                            bounds.extend(position);

                            marker = new google.maps.Marker({
                                position: position,
                                map: map,
                                icon: icone
                            });


                            var id = markers[i][3];
                            guinchos[id] = marker;
                            if(markers[i][4] == 2)
                            	guinchos2.push(marker);
                            else
                            	guinchosC2.push(marker);



                            var infoWindow = new google.maps.InfoWindow(), marker, i;

                            // Allow each marker to have an info window    
                            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                return function () {
                                    infoWindow.setContent(markers[i][0]);
                                    infoWindow.open(map, marker);
                                }
                            })(marker, i));

                            if (status != 2) {

                                google.maps.event.addListener(marker, 'dblclick', (function (m, i) {
                                    return function () {

                                        for (var i = 0; i < guinchos2.length; i++) {
                                            guinchos2[i].setIcon('public/img/marker.png');
                                        }
                                        
                                        for (var i = 0; i < guinchosC2.length; i++) {
                                        	guinchosC2[i].setIcon('public/img/marker-orange.png');
                                        }

                                        for (var i = 0; i < proximos.length; i++) {
                                            guinchos[proximos[i]].setIcon("public/img/yellow-marker.png");
                                        }

                                        m.setIcon('public/img/green_MarkerG.png');

                                        var latitude = m.getPosition().lat();
                                        var longitude = m.getPosition().lng();

                                        selectGuinchos(latitude, longitude);


                                    }
                                })(marker, i));

                            }
                        }

                        map.fitBounds(bounds);

                    }

                }

            }
        });

        $("#focarLocal").dblclick(function () {

            var llat = $("#assistencia_local_lat").val();
            var llong = $("#assistencia_local_long").val();

            if (llat != "" && llong != "") {
                var position = new google.maps.LatLng(llat, llong);
                map.setZoom(15);
                map.setCenter(position);
            }
        });

        $("#focarGuincho").dblclick(function () {

            var llat = $("#latitude").text();
            var llong = $("#longitude").text();

            if (llat != "" && llong != "") {
                var position = new google.maps.LatLng(llat, llong);
                map.setZoom(15);
                map.setCenter(position);
            }
        });

        function selectGuinchos(latitude, longitude) {
            $.ajax({
                url: 'modulos/monitoramento/src/controllers/monitoramento.php',
                dataType: 'json',
                type: 'post',
                data: {
                    acao: 'selecionarEmpresaGuincho', latitude: latitude, longitude: longitude
                },
                success: function (resposta) {
                    $("#razaoSocial").text(resposta['guincho_razao_social']);
                    $("#endereco").text(resposta['guincho_endereco'] + " - " + resposta['guincho_cidade'] + " - " + resposta['guincho_uf'] + " - " + resposta['guincho_cep']);
                    $("#atendimento").text(resposta['guincho_atendimento']);
                    $("#latitude").text("Latitude: " + latitude);
                    $("#longitude").text("Longitude: " + longitude);
                    $("#linkGuincho").attr("href", "index.php?pg=48&id="+resposta['guincho_id']).attr("target", "_blank").removeAttr("style");
                    $("#assistencia_guincho").val(resposta['guincho_id']);
                }
            });
        }

        var markerAnterior = null;
        //SELECIONAR NOVO LOCAL
        function mudarLocal() {

            var place = autocomplete.getPlace();
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();

            
            console.log(place.address_components);

            if (place.address_components.length > 1) {

                $("#assistencia_local_lat").val(latitude);
                $("#assistencia_local_long").val(longitude);

                var position = new google.maps.LatLng(latitude, longitude);
                map.setCenter(position);
                map.setZoom(5);

                var marker = new google.maps.Marker({
                    icon: "public/img/blue_MarkerL.png",
                    position: position,
                    map: map
                });

                markerAnterior = marker;

                bounds.extend(position);

                var infoWindow = new google.maps.InfoWindow(), marker;

                marker.addListener('click', function () {
                    infoWindow.setContent(place.formatted_address);
                    infoWindow.open(map, marker);
                });

                $.ajax({
                    url: 'modulos/monitoramento/src/controllers/monitoramento.php',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        acao: 'selecionarGuinchosProximos', latitude: latitude, longitude: longitude
                    },
                    success: function (guinchosProximos) {
                        if (guinchosProximos.length > 0) {
                            $.each(guinchosProximos, function (key, value) {
                                guinchos[value.guincho_id].setIcon("public/img/yellow-marker.png");
                                proximos.push(value.guincho_id);
                            });
                        }
                    }
                });


            } else {
                $("#mapa_address").val("");
            }
        }

});




