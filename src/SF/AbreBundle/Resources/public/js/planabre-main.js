var d3map = {};
var TOTAL_PUNTOS = 214; //hardcodeado por ahora
var DEBUG_LEVEL = false;

d3map.brush = null;
d3map.cantidadPuntos = 0;
d3map.layers = {};
d3map.log = function(msg, debugLevel) {
  var debugLevelValue = {
    "info": 1,
    "warning": 2,
    "all": 3
  }
  if (debugLevelValue[DEBUG_LEVEL] >= debugLevelValue[debugLevel]) {
    console.log(msg);
  }
}

function mostrarProyecto(data) {
  document.title = data.titulo_publico + " - Plan Abre - Gobierno de la Provincia de Santa Fe";
  var tpl = document.getElementById("sideTemplate").text;
  document.getElementById('overlay-padder').innerHTML = _.template(tpl, data);
  $(".addthis_native_toolbox").appendTo("#overlay-compartir");
  $("#overlay").fadeIn().addClass('visible');
}


function main() {

    var extent, scale, 
        classes = 9,
        reverse = false;
        container = L.DomUtil.get('map');

    map = new L.Map('map', {
      zoomControl: false,
      center: [-32.9598, -60.6423],
      zoom: 13,
      zoomAnimation: false
    });

    var sfLayer = L.tileLayer.wms("https://aswe.santafe.gov.ar/idesf/servicios-wms", {
        layers: 'manzanasipec,ipec_ejes_2010_toponimia',
        format: 'image/png',
        transparent: true,
        attribution: "Mapa de IDESF - Gobierno de la Provincia de Santa Fe"
    });

    sfLayer.addTo(map);

    $(".boton-filtro").on("click", function() {

      if($(this).hasClass("active")) {
        $(this).removeClass("active");
        $(".area-" + $(this).data("id")).hide();
      } else {
        $(this).addClass("active");
        $(".area-" + $(this).data("id")).show();
      }

    });

    d3map.svgGeneral = d3.select(map.getPanes().overlayPane).append("svg").attr("id", "svg-general");

    function addPolygonLayer(layerName, jsonData) {

      console.log("Agregando capa [" + layerName + "]");
      var svgGeneral = d3.select("#svg-general");

      d3map.layers[layerName] = [];
      // Agregar la capa SVG      
      d3map.layers[layerName]['g'] = svgGeneral.append("g").attr("class", "leaflet-zoom-hide");

        // Dibuja los puntos sobre el mapa de Leaflet con D3.js
        var transform = d3.geo.transform({point: projectPoint});
        
        d3map.layers[layerName]['collection'] = jsonData;
        d3map.layers[layerName]['path'] = d3.geo.path().projection(transform);

        // Obtener los puntos y asignar una clase
        d3map.layers[layerName]['features'] = d3map.layers[layerName]['g'].selectAll("path")
          .data(jsonData.features)
          .enter()
          .append("path")
          .attr("class", "area-" + layerName);

        // Listener para el click en un punto del mapa
        d3map.layers[layerName]['features'].on("click", function (d, i) {
          L.DomEvent.stopPropagation(d3.event);
          console.log(d.properties);
          var data = {
              //fecha: d.properties.fecha,
              titulo: d.properties.name,
              descripcion: "Lorem ipsum dolor sit amet, texto de descripción de ejemplo, ejemplo, lorem ipsum.",
              monto: "$ 123.456",
              imagen: "imgs/planabre/redescloacales.jpg"
          };
          mostrarProyecto(data);
        });

        // Use Leaflet to implement a D3 geometric transformation.
        function projectPoint(x, y) {
          var point = map.latLngToLayerPoint(new L.LatLng(y, x));
          this.stream.point(point.x, point.y);
        }

        // Experimental: pattern
        d3map.svgGeneral.append("defs")
        .append('pattern')
          .attr('id', 'abrebg')
          .attr('patternUnits', 'userSpaceOnUse')
          .attr('width', 289)
          .attr('height', 180)
         .append("image")
          .attr("xlink:href", "imgs/planabre/abrebg.png")
          .attr('width', 289)
          .attr('height', 180);

        map.on("viewreset", resetCapasSVG);

    }

    for (layerName in jsonData) {
      addPolygonLayer(layerName, jsonData[layerName]);
    }
    
    // Reposition the SVG to cover the features.
    function resetCapasSVG() {

      for (layerName in d3map.layers) {

        if(layerName == "dummyLayer") {
          continue;
        }

        console.log("Reseteando " + layerName);

        d3map.layers[layerName]['bounds'] = d3map.layers[layerName]['path'].bounds(d3map.layers[layerName]['collection']);

        var topLeft = d3map.layers[layerName]['bounds'][0],
            bottomRight = d3map.layers[layerName]['bounds'][1];

        d3map.svgGeneral.attr("width", bottomRight[0] - topLeft[0])
          .attr("height", bottomRight[1] - topLeft[1])
          .style("left", topLeft[0] + "px")
          .style("top", topLeft[1] + "px");

        d3map.layers[layerName]['g'].attr("transform", "translate(" + -topLeft[0] + "," + -topLeft[1] + ")");

        d3map.layers[layerName]['features'].attr("d", d3map.layers[layerName]['path']);

      }

    }

  resetCapasSVG();

  $("#cerrar-sidebar").on("click", function () {
    $(".addthis_native_toolbox").appendTo("#addthis-hidden");
    $("#overlay").fadeOut().removeClass('visible');
  });

}; // end main()

var datosAreas = null;
var jsonData = {};

window.onload = function() {

  var SIGFiles = [
    '/bundles/sfabre/xml/zonas-de-interes.xml',
    '/bundles/sfabre/xml/mi-tierra-mi-casa.xml',
    '/bundles/sfabre/xml/mejoramiento-barrial.xml'
  ];

  var currentFile = 0;

  function loadNextFile() {

    if (SIGFiles[currentFile]) {

      console.log("Cargando: " + SIGFiles[currentFile]);
      $.ajax(SIGFiles[currentFile]).done(function(xml) {
        
        var regexFiles = /\/([\w\-]+)\./g;
        var matches = regexFiles.exec(SIGFiles[currentFile]);
        var fileName = matches[1];

        jsonData[fileName] = toGeoJSON.kml(xml);
        currentFile++;
        loadNextFile();
      });          

    } else {
      console.log("Iniciando");

      $(".loader").fadeOut(1000, function() {
        $(".loader").remove();
      });

      function responseToOptions(nombre, datos) {

        var wrapper = $("#" + nombre + "_wrapper"),
            selectDestino = $("<select>");

        $("#" + nombre + "_ayuda").hide();

        wrapper.html('');

        selectDestino.attr("name", nombre);
        selectDestino.attr("data-placeholder", "Seleccionar...");

        newOption = $("<option>");
        newOption.attr("value", 0);
        newOption.html("Todos");
        selectDestino.append(newOption);

        for (idx in datos) {
          newOption = $("<option>");
          newOption.attr("value", datos[idx].id);
          newOption.html(datos[idx].nombre);
          selectDestino.append(newOption);
        }

        selectDestino.removeAttr("disabled");
        wrapper.append(selectDestino);
        selectDestino.chosen({disable_search_threshold: 10, width: "100%"}).change(function() {
          $("#form_filtros").submit();
        })
        wrapper.removeClass("hidden");

      }

      function cargarProyecto(e, forceURL) {
        // Alero Coronel Dorrego - id 358 - linea: infraestructuras estratégicas
        if (e) {
          e.preventDefault();
        }

        var url = "", id = 0;
        if (!forceURL) {
          url = $(this).attr("href");
        } else {
          url = forceURL;
        }
        id = url.split("/")[2];

        location.href = "/#proyecto-" + id;

        $.ajax(
        {
            url: url,
            type: "GET",
            success:function(data, textStatus, jqXHR)
            {

              var imagen = "";
              var clasificacion = [];

              if (data[0]["eje_trabajo"]) {
                clasificacion.push(data[0]["eje_trabajo"].nombre);
              }
              if (data[0]["linea_accion"]) {
                clasificacion.push(data[0]["linea_accion"].nombre);
              }
              if (data[0]["intervencion"]) {
                clasificacion.push(data[0]["intervencion"].nombre);
              }

              if (data[0]["imagen"]) {
                imagen = data[0]["imagen"];
              } else {
                imagen = "/bundles/sfabre/sinimagen.jpg";
              }

              clasificacion = clasificacion.join(" / ");

              var jsonData = {
                titulo_publico: data[0]["titulo_publico"],
                monto_publico: data[0]["monto_publico"],
                bajada_publica: data[0]["bajada_publica"],
                cuerpo_publico: data[0]["cuerpo_publico"],
                clasificacion: clasificacion,
                imagen: imagen,
              }
              mostrarProyecto(jsonData);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                   
            }
        });

      }

      function linksProyectos(datos) {

        var wrapper = $("#proyectos_wrapper");
        $("#proyectos_wrapper a").off("click");
        wrapper.html('');

        if (!!datos.length) {

          var proyectosEncontrados = $("<p>");
          proyectosEncontrados.html(datos.length + " proyectos encontrados.");
          wrapper.append(proyectosEncontrados);

          var containerProyectos = $("<div>")
          containerProyectos.addClass("container-proyectos");

          for (idx in datos) {
            newLink = $("<a>");
            newLink.attr("href", "/proyecto/" + datos[idx].id);
            newLink.html(datos[idx].nombre);
            newLink.on("click", cargarProyecto);
            containerProyectos.append(newLink);
          }

          wrapper.append(containerProyectos);

        } else {

          var sinProyectos = $("<p>");
          sinProyectos.html("No se encontraron proyectos con los criterios seleccionados.");
          wrapper.append(sinProyectos);
        }

      }

      function cargarLineaAccion(submitForm) {
        $.ajax({
          url: "/lineas/poreje/" + $("#eje_trabajo").val()
        }).done(function(response) {
          responseToOptions("linea_accion", response);
          if (!!submitForm) {
            $("#form_filtros").submit();
          }
        });
      }


      function cargarIntervenciones(submitForm) {
        $.ajax({
          url: "/intervencion/porlinea/" + $("#linea_accion").val()
        }).done(function(response) {
          responseToOptions("intervencion", response);
          if (!!submitForm) {
            $("#form_filtros").submit();
          }
        });
      }

      function initChosenListeners() {

        $("#localidad").chosen({disable_search_threshold: 10, width: "100%"}).change(function() {

          var idLocalidad = $(this).val();
          console.log(idLocalidad);

          switch (parseInt(idLocalidad)) {
            case 150: // Santa Fe
              map.panTo([-31.6184553, -60.7029753]);
              break;
            case 151: // Santo Tomé
              map.panTo([-31.662857, -60.7617666]);
              break;
            case 212: // Rosario
              map.panTo([-32.9598, -60.6423]);
              break;
            case 213: // VGG
              map.panTo([ -33.0245361, -60.6315897]);
              break;
          }

          $.ajax({
            url: "/barrios/" + idLocalidad
          }).done(function(response) {

            responseToOptions("barrio", response);

            console.log("buscando distritos");

            // Después de buscar los barrios, buscar los distritos
            $.ajax({
              url: "/distritos/" + idLocalidad
            }).done(function(distritosResponse) {
              responseToOptions("distrito", distritosResponse);
              $("#form_filtros").submit();
            });

          });


        });

        $("#eje_trabajo").chosen({disable_search_threshold: 10, width: "100%"}).change(function() {
          cargarLineaAccion(true);
        });

        $("#linea_accion").chosen({disable_search_threshold: 10, width: "100%"}).change(function() {
          cargarIntervenciones(true);
        });

        $("#intervencion, #barrio, #distrito").chosen({disable_search_threshold: 10, width: "100%"}).change(function() {
          $("#form_filtros").submit();
        });

      }


      function initDOMListeners() {

        $("#form_filtros").submit(function(e) {

            $("#proyectos_wrapper").html('<div id="proyectos-loader">Cargando...</div>');

            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax(
            {
                url : formURL,
                type: "POST",
                data : postData,
                success:function(data, textStatus, jqXHR)
                {
                  console.log(data);
                  linksProyectos(data);
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                       
                }
            });
            e.preventDefault(); 
        });

        $("#form_filtros a.link-ciudad").on("click", function(e) {
          e.preventDefault();
          $("#form_filtros a.link-ciudad").removeClass("active");
          $(this).addClass("active");
          $(".accordion-content").hide();
          var target = $(this).data("target");
          $("#" + target).show();
        });

        
      }

      initDOMListeners();
      initChosenListeners();

      cargarIntervenciones();
      cargarLineaAccion();
      $("#form_filtros").submit();

      if (location.hash) {
        var idProyecto = location.hash.split("-")[1];
        cargarProyecto(null, "/proyecto/" + idProyecto)
      }
      
      main();
    }
  }

  loadNextFile();

}
