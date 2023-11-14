<script>
let camiones;

$(document).ready(function() {
      console.log("entra monitor entradas");

      obtieneCamiones();
      setInterval(() => {
            obtieneCamiones();
      }, 60000);

});

const obtieneCamiones = () => {
      /*OBTIENE LOS CAMIONES*/
      jQuery.ajax({
            url: __url__ + '?ajax&controller=Servicios&action=getCamionesPatio',
            data: {

            },
            method: 'POST',
            dataType: "json",
      }).then(resp => {
            camiones = resp;
            $(".unidades").html("");
            for (var x = 0; x < camiones.camiones.length; x++) {
                  let html = `<div id="${camiones.camiones[x].numUnidad}" class='col-md-5 col-12 card_unidad selector'>
                                    <div class='card-title'>
                                          <h4>Unidad ${camiones.camiones[x].numUnidad}</h4>
                                          <h6>Fecha ${camiones.camiones[x].fecha_entrada}</h6>
                                    </div>
                                    <div class='row itemunidad'>
                                          <div class='col-md-6 col-12'>
                                                Tipo: ${camiones.camiones[x].tipo_unidad}
                                          </div>
                                          <div class='col-md-6 col-12'>
                                                Trans: ${camiones.camiones[x].transportista}
                                          </div> 
                                    </div>
                                    <div class='row itemunidad'>
                                          <div class='col-md-6 col-12'>
                                                Placas: ${camiones.camiones[x].placa1}
                                          </div>
                                          <div class='col-md-6 col-12'>
                                                Ticket: ${camiones.camiones[x].ticket}
                                          </div> 
                                    </div>
                                    <div class='row itemunidad'>
                                          <div class='col-12'>
                                                Fecha Programación:  ${camiones.camiones[x].fecha_programacion}
                                          </div> 
                                    </div>
                                    
                              </div>`;
                  switch (camiones.camiones[x].status_unidad) {
                        case "En terminal":
                              if (camiones.camiones[x].fecha_programacion == "") {
                                    $(".enterminal .unidades").append(html);
                              } else {
                                    $(".programado .unidades").append(html);
                              }
                              break;
                        case "Programada":
                              $(".programado .unidades").append(html);
                              break;
                        case "Embarque":
                              $(".porsalir .unidades").append(html);
                              break;

                        default:
                              break;
                  }


            }

            $(".selector").draggable({
                  revert: "invalid", // when not dropped, the item will revert back to its initial position
                  opacity: 0.35,
                  cursor: "move"
            });
            $(".droppper").droppable({
                  accept: ".selector",
                  classes: {
                        "ui-droppable-active": "ui-state-highlight"
                  },
                  drop: function(event, ui) {
                        $("#" + ui.draggable[0].id).attr("style", "");
                        $(this).find(".row").append($(ui.draggable));
                  }
            });


      }).fail(resp => {}).catch(resp => {
            swal('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores', {
                  icon: 'error'
            });
      });


}
</script>