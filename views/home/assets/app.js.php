<script>
var s = document.createElement("script");
s.type = "text/javascript";
// s.src = "../servicios/assets/js/servicios.js";
$("head").append(s);

$(document).ready(function() {
      console.log("entra menuflex")
      $(".card").click(function() {
            loadingPage();
            //setTimeout(() => {
            //      swal.close();
            //}, 3000);
      });
      $(".btn-Alta").click(function() {
            jQuery.ajax({
                  url: __url__ + '?ajax&controller=Servicios&action=getClientesYTransportes',
                  data: {

                  },
                  method: 'POST',
                  dataType: "json",
            }).then(resp => {
                  clientes = resp.clientes;
                  transportes = resp.transportes;
                  htmlclientes = `<strong class="mr-1">Cliente:</strong>
                                          <select name="cliente" class="item" id="cliente">
                                                <option value="" selected>--Selecciona--</option>`;
                  for (var x = 0; x < clientes.length; x++) {
                        htmlclientes += `<option value="${clientes[x].id}">${clientes[x].nombre} </option>`
                  }

                  htmlclientes += `</select>`;

                  htmltransportes = `<strong class="mr-1">Transporte:</strong>
                                          <select name="transporte" class="item" id="transporte">
                                                <option value="" selected>--Selecciona--</option>`;
                  for (var x = 0; x < transportes.length; x++) {
                        htmltransportes += `<option value="${transportes[x].id}">${transportes[x].nombre} </option>`
                  }

                  htmltransportes += `</select>`;
                  // var elehtml = html ``;
                  Swal.fire({
                        title: /*html*/ `<h4>ENTRADAS Y SALIDAS</h4><span><h6>Registro de unidades</span>`,
                        confirmButtonText: 'Guardar',
                        html: /*html*/ `
                        
                              <section id="sectionForm">
                                    <form id="ensacadoForm" enctype="multipart/form-data" class="form form-horizontal">
                                          <h4 class="form-section"><i class="ft-user"></i> Tipo Unidad</h4>
                                          <div class="form-group row">
                                                <div class="col-12 ">
                                                      <div id="divRadios" class="div-radios">
                                                            <strong for="ferrotolva">Ferrotolva:</strong>
                                                            <input class="ml-1 mr-3" id="ferrotolva" type="radio" name="ferrotolva" value="F" required/>
                                                            <strong for="ferrotolvas">Camión:</strong>
                                                            <input class="ml-1" type="radio" name="ferrotolva" value="A" required/>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="form-group row mt-2">
                                                <div class="col-12 datos mt-2 mb-1">
                                                      <strong class="mr-1"># Unidad:</strong><input type="text" name="numeroUnidad" id="numeroUnidad" class="item" required/> 
                                                </div>
                                          </div>
                                          <h4 class="form-section"><i class="ft-user"></i> Datos Cliente</h4>
                                          <div class="form-group row mt-2">
                                                <div class="col-12 datos mt-2 mb-1">
                                                      ${htmlclientes}
                                                </div>
                                          </div>
                                          
                                          <div class="form-group row mt-2">
                                                <div class="col-12">
                                                      <section id="seccionCamion" hidden>
                                                      <h4 class="form-section"><i class="ft-user"></i> Datos Transportista</h4>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div><strong class="mr-1">Transportista:</strong><input id="transportista" class="item" type="text" /></div>
                                                                  <div><strong class="mr-1">Chofer:</strong><input class="item" id="chofer" name="chofer" type="text" /></div>
                                                            </div>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div>
                                                                        ${htmltransportes}
                                                                  </div>
                                                                  <div><strong class="mr-1">Placa tractor #1:</strong><input name="placa1" class="item" id="placa1" type="text" /></div>
                                                                  <div><strong class="mr-1">Placa tractor #2:</strong><input name="placa2" class="item" id="placa2" type="text" /> </div>
                                                            </div>
                                                      </section>
                                                      <section id="seccionFerrotolva" hidden>
                                                      <h4 class="form-section"><i class="ft-user"></i> Datos Transportista</h4>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div><strong class="mr-1">Transportista:</strong><input id="transportistaTren" class="item" type="text" /></div>
                                                                  <div>
                                                                        ${htmltransportes.replace('id="transporte"','id="transporteTren"')} 
                                                                  </div>
                                                            </div>
                                                      </section>
                                                </div>
                                          </div>
                                          <div class="form-group row mt-2">
                                                <div class="col-12 datos mt-2 mb-1">
                                                      <strong class="mr-1">Observaciones:</strong><input name="observaciones" class="item" id="observaciones" type="text" />
                                                </div>
                                          </div>
                                          
                                          
                                          </form>
                              </section>`,
                        preConfirm: () => {
                              if (validaCampos()) {
                                    erpalert("error", "", "Validar campor obligatorios")
                                    return false; // Prevent confirmed
                              }
                        },
                        didOpen: () => {
                              $('input[name="ferrotolva"]').change(function() {
                                    cambiaFerrotolva($(this).val());
                              });
                        }
                  }).then((result) => {
                        if (result.isConfirmed) {
                              //e.preventDefault();
                              let ferrotolva = $('input[name="ferrotolva"]:checked').val();
                              let numeroUnidad = $("#numeroUnidad").val();
                              let observaciones = $("#observaciones").val();
                              let cliente = $("#cliente").val();
                              $("#ensacadoForm").find("input, select").removeAttr("disabled");
                              var datosForm = new FormData($("#ensacadoForm")[0]);
                              console.log(datosForm);
                              jQuery.ajax({
                                    url: __url__ + '?ajax&controller=Servicios&action=guardarEnsacado',
                                    data: datosForm,
                                    processData: false,
                                    contentType: false,
                                    enctype: "multipart/form-data",
                                    //data: {
                                    //      ferrotolva: ferrotolva,
                                    //      numeroUnidad: numeroUnidad,
                                    //      cliente: cliente,
                                    //      observaciones: observaciones,
                                    //      transporte: ""
                                    //},
                                    method: 'post',
                                    dataType: "json",
                              }).then(resp => {
                                    console.log(resp);
                                    if (resp.error) {
                                          erpalert("", "Alta", resp.mensaje)
                                          mensajeCorrecto(resp.mensaje);
                                    } else {
                                          erpalert("error", "Error", resp.mensaje)
                                          mensajeError(resp.mensaje);
                                    }
                              }).fail(resp => {}).catch(resp => {
                                    swal('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores', {
                                          icon: 'error'
                                    });
                              });
                        }
                  });

            }).fail(resp => {}).catch(resp => {
                  swal('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores', {
                        icon: 'error'
                  });
            });

      });
      validaCantidades();
      setInterval(() => {
            validaCantidades();
      }, 30000);

});

const validaCampos = () => {
      let faltan = false;
      $("#numeroUnidad").removeClass("invalid").removeClass("checked");
      if ($("#numeroUnidad").val() == "") {
            faltan = true;
            $("#numeroUnidad").addClass("invalid");
      } else {
            $("#numeroUnidad").addClass("checked");
      }
      $("#cliente").removeClass("invalid").removeClass("checked");
      if ($("#cliente").val() == "") {
            faltan = true;
            $("#cliente").addClass("invalid");
      } else {
            $("#cliente").addClass("checked");
      }

      if ($("#transporteTren").is(":visible")) {
            $("#transporteTren").removeClass("invalid").removeClass("checked");
            if ($("#transporteTren").val() == "") {
                  faltan = true;
                  $("#transporteTren").addClass("invalid");
            } else {
                  $("#transporteTren").addClass("checked");
            }
      }

      if ($("#transporte").is(":visible")) {
            $("#transporte").removeClass("invalid").removeClass("checked");
            if ($("#transporte").val() == "") {
                  faltan = true;
                  $("#transporte").addClass("invalid");
            } else {
                  $("#transporte").addClass("checked");
            }
      }

      // transportista
      if ($("#transportista").is(":visible")) {
            $("#transportista").removeClass("invalid").removeClass("checked");
            if ($("#transportista").val() == "") {
                  faltan = true;
                  $("#transportista").addClass("invalid");
            } else {
                  $("#transportista").addClass("checked");
            }
      }
      // $("#cliente").val()
      return faltan;
}
let cantidades;
const validaCantidades = () => {
      jQuery.ajax({
            url: __url__ + '?ajax&controller=Servicios&action=getCantidadesServicios',
            data: {},
            method: 'post',
            dataType: "json",
      }).then(resp => {
            cantidades = resp;
            $(".badge").html("");
            $(".badge").removeClass('animated flash');
            for (var x = 0; x < cantidades.etapas.length; x++) {
                  //console.log(cantidades.etapas[x].Etapa, " - ", cantidades.etapas[x].Cantidad)
                  $("#" + cantidades.etapas[x].Etapa + "_badge").html(cantidades.etapas[x].Cantidad);
                  $("#" + cantidades.etapas[x].Etapa + "_badge").addClass('animated flash');

            }
            setTimeout(() => {
                  $(".badge").removeClass('animated flash');
            }, 2000);

      }).fail(resp => {}).catch(resp => {
            swal('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores', {
                  icon: 'error'
            });
      });
}
</script>