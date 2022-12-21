$(function () {


    if (typeof google === 'object' && typeof google.maps === 'object') {
        var map = null;
        var markerAnterior = null;

        var lat = $("#mapa_lat").val();
        var long = $("#mapa_lon").val();

        $(window).load(function () {
            var mapOptions = {
                center: new google.maps.LatLng(-14.235004, -51.92527999999999),
                zoom: 4,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById('mapa'), mapOptions);

            $('#tabMapa').on('shown.bs.tab', function (e) {
                z = map.getZoom();
                c = map.getCenter();
                google.maps.event.trigger(map, 'resize');
                map.setZoom(z);
                map.setCenter(c);
            });

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

            
            var options = {
          		componentRestrictions: {country: "br"}
          	};

            var input = document.getElementById('mapa_address');

            autocomplete = new google.maps.places.Autocomplete(input, options);

            autocomplete.addListener('place_changed', mudarLocal);

            google.maps.event.addListener(map, 'zoom_changed', function () {
                if (map.getZoom() <
                        3)
                    map.setZoom(3);
            });

            if (lat.length != 0 && long.length != 0)
                setarMaker(lat, long, $("mapa_address").val());


        });

        function mudarLocal() {
            var place = autocomplete.getPlace();
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            var titulo = place.formatted_address;

            setarMaker(latitude, longitude, titulo);

        }

        $('.nav-tabs a').click(function (e) {
            google.maps.event.trigger(map, 'resize');
        });

        function setarMaker(latitude, longitude, titulo) {

            if (markerAnterior != null)
                markerAnterior.setMap(null);

            var position = new google.maps.LatLng(latitude, longitude);

            map.setCenter(position);
            map.setZoom(15);

            $("#mapa_lat").val(latitude);
            $("#mapa_lon").val(longitude);

            var marker = new google.maps.Marker({
                icon: "public/img/blue_MarkerL.png",
                position: position,
                map: map,
                draggable: true,
                tittle: "teste",
            });

            markerAnterior = marker;

            var infoWindow = new google.maps.InfoWindow(), marker;

            marker.addListener('click', function () {
                infoWindow.setContent(titulo);
                infoWindow.open(map, marker);
            });
        }

    } else {
    	$("#mapaMsg").removeAttr("style");
    	$("#mapa2").attr("style", "display:none;");
    	$("#salvarGuincho").attr("style", "display:none;");
    }
    
});
