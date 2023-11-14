<!-- document.head.appendChild( elementToAdd ); -->
<?php
// print_r('<pre>');
// print_r($idEst);
// print_r('</pre>');

?>
<script>
let servicios;
$(document).ready(function() {
      console.log("entra en lista de unidades");
      getUnidades();
      swal.close();
});

const getUnidades = () => {
      $.ajax({
            url: __url__ + "?ajax&controller=Servicios&action=getUnidadesAPP",
            data: {
                  idEst: "<?php echo $idEst; ?>",
                  PesoPend: "<?php echo $PesoPend; ?>",

            },
            method: 'post',
            dataType: "json",
      }).then(resp => {
            servicios = resp.servicios;
            $('#tableUnidades').DataTable().clear().destroy();
            $("#tableUnidades").DataTable({
                  dom: 'Bfrtip',
                  retrieve: true,
                  data: resp.servicios,
                  columns: [{
                              data: 'iconounidad',
                              width: '1%'
                        },
                        {
                              data: 'numUnidad',
                              // width: '10%'
                        },
                        {
                              data: 'nombreCliente',
                              // width: '80%'
                        }

                  ],
                  buttons: [
                        'print',

                        {
                              extend: 'excelHtml5',
                              // className: 'btn btnExcel',
                              title: `Reporte de unidades ${formatDate(new Date())}`
                        },
                        'pdf',

                  ],
                  language: {
                        url: '<?php echo root_url; ?>assets/libs/datatables/es-MX.json',
                  },
                  initComplete: function(settings, json) {
                        $(".showEnsacado").unbind();
                        $(".showEnsacado").click(function(a) {
                              console.log(a.currentTarget);
                              accionEtapa(a.currentTarget.dataset.idserv, a.currentTarget.firstChild.nodeValue);

                        });
                  }
            });

      }).fail(resp => {}).catch(resp => {
            erpalert("error", 'Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores... ' + resp);
            console.log("error unidades: ", resp);
      });
}

let servicio;
const accionEtapa = (idserv, tipoUnidad) => {
      let idEtapa = $("#idEtapa").val();
      console.log("idEtapa: ", idEtapa);
      console.log("idserv: ", idserv);
      console.log("tipoUnidad: ", tipoUnidad);
      if (tipoUnidad == "") {}
      switch (idEtapa) {
            case "1":
                  Swal.fire({
                        title: '¿Seguro que cambiará la unidad a transito?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si'
                  }).then((result) => {
                        if (result.isConfirmed) {
                              $.ajax({
                                    data: {
                                          id: idserv
                                    },
                                    url: __url__ + "?ajax&controller=Servicios&action=transitoUnidad",
                                    type: "POST",
                                    dataType: "json",
                                    success: function(r) {
                                          console.log(r);
                                          if (r.error != false) {
                                                erpalert("", "", "Se cambió el estatus de la unidad");
                                                setTimeout(() => {
                                                      getUnidades();
                                                }, 500);
                                          } else {
                                                erpalert("error", "Ocurrió un error", r.mensaje);
                                          }
                                    },
                                    error: function(r) {
                                          console.log(r.responseText);
                                          mensajeError("Algo salio mal,  contacte al administrador.");
                                    },
                              });






                        }
                  });
                  break;
            case "8":
                  servicio = servicios.find(function(e) {
                        return e.id === idserv;
                  });;
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
                              htmlclientes += `<option value="${clientes[x].id}" ${(clientes[x].id==servicio.cliente_id)?"selected":""}>${clientes[x].nombre} </option>`
                        }

                        htmlclientes += `</select>`;

                        htmltransportes = `<strong class="mr-1">Transporte:</strong>
                                          <select name="transporte" class="item" id="transporte">
                                                <option value="" selected>--Selecciona--</option>`;
                        for (var x = 0; x < transportes.length; x++) {
                              htmltransportes += `<option value="${transportes[x].id}" ${(transportes[x].id==servicio.tipo_transporte_id)?"selected":""}>${transportes[x].nombre} </option>`
                        }

                        htmltransportes += `</select>`;

                        Swal.fire({
                              title: /*html*/ `<h4>ENTRADAS Y SALIDAS</h4><span><h6>Ingreso de unidades</span>`,
                              confirmButtonText: 'Guardar',
                              cancelButtonText: 'Cancelar',
                              showCancelButton: true,
                              cancelButtonColor: '#d33',
                              html: /*html*/ `
                        
                              <section id="sectionForm">
                                    <form id="ensacadoForm" enctype="multipart/form-data" class="form form-horizontal">
                                          <input type="text" name="id" id="id" hidden value="${servicio.id}" /> 
                                          <h4 class="form-section"><i class="ft-user"></i> Datos Unidad</h4>
                                          <div class="form-group row">
                                                <div class="col-12 ">
                                                      <div id="divRadios" class="div-radios" disabled>
                                                            <strong for="ferrotolva">Ferrotolva:</strong>
                                                            <input class="ml-1 mr-3" id="ferrotolva" class="item" type="radio" ${(servicio.tipo_transporte_id ==6 || servicio.tipo_transporte_id ==12) ?"checked":""} name="ferrotolva" value="F" disabled/>
                                                            <strong for="ferrotolvas">Camión:</strong>
                                                            <input class="ml-1" type="radio" name="ferrotolva" class="item" value="A"  ${(servicio.tipo_transporte_id !=6 && servicio.tipo_transporte_id !=12) ?"checked":""} disabled/>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="form-group row mt-2">
                                                <div class="col-12 datos mt-2 mb-1">
                                                      <strong class="mr-1"># Unidad:</strong><input type="text" name="numeroUnidad" id="numeroUnidad" class="item-medium item" value="${servicio.numUnidad}" readonly/> 
                                                </div>
                                          </div>
                                           <h4 class="form-section"><i class="ft-user"></i> Datos Cliente</h4>
                                          <div class="form-group row mt-2">
                                                <div class="col-12 datos mt-2 mb-1">
                                                      ${htmlclientes}
                                                </div>
                                          </div>
                                          <div class="form-group row mt-2">
                                                <div class="col-12 datos mt-2 mb-1">
                                                      <strong class="mr-1">Peso Cliente:</strong><input type="text" name="pesoCliente" id="pesoCliente" class="item-medium item  numhtml" value="${(servicio.peso_cliente==null)?"":servicio.peso_cliente}" /> 
                                                </div>
                                          </div>
                                          
                                          <div class="form-group row mt-2">
                                                <div class="col-12">
                                                      <section id="seccionCamion" hidden>
                                                      <h4 class="form-section"><i class="ft-user"></i> Datos Transportista</h4>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div><strong class="mr-1">Transportista:</strong><input id="transportista" class="item" type="text" value="${servicio.transportista}" /></div>
                                                                  <div><strong class="mr-1">Chofer:</strong><input class="item" id="chofer" name="chofer" type="text" value="${servicio.chofer}"/></div>
                                                            </div>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div>
                                                                        ${htmltransportes}
                                                                  </div>
                                                                  <div><strong class="mr-1">Placa tractor #1:</strong><input name="placa1" class="item" id="placa1" type="text" value="${servicio.placa1}"/></div>
                                                                  <div><strong class="mr-1">Placa tractor #2:</strong><input name="placa2" class="item" id="placa2" type="text" value="${servicio.placa2}"/> </div>
                                                            </div>
                                                      </section>
                                                      <section id="seccionFerrotolva" hidden>
                                                      <h4 class="form-section"><i class="ft-user"></i> Datos Transportista</h4>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div><strong class="mr-1">Transportista:</strong><input id="transportistaTren" class="item" type="text" value="${servicio.transportista}"/></div>
                                                                  <div>
                                                                        ${htmltransportes.replace('id="transporte"','id="transporteTren"')} 
                                                                  </div>
                                                            </div>
                                                      </section>
                                                </div>
                                          </div>
                                          <div class="form-group row mt-2">
                                                <div class="col-12 datos mt-2 mb-1">
                                                      <strong class="mr-1">Observaciones:</strong><input name="observaciones" class="item" id="observaciones" type="text" value="${servicio.observaciones}"/>
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
                                    let tipoferre = "A";
                                    if (servicio.tipo_transporte_id == 6 || servicio.tipo_transporte_id == 12) {
                                          tipoferre = "F";
                                    }
                                    cambiaFerrotolva(tipoferre);
                                    $("#transportista").val(servicio.transportista);
                                    formatoNumeros();

                              }
                        }).then((result) => {
                              if (result.isConfirmed) {
                                    $("#ensacadoForm").find("input, select").removeAttr("disabled");
                                    var datosForm = new FormData($("#ensacadoForm")[0]);
                                    console.log(datosForm);
                                    jQuery.ajax({
                                          url: __url__ + '?ajax&controller=Servicios&action=guardarEnsacado',
                                          data: datosForm,
                                          processData: false,
                                          contentType: false,
                                          enctype: "multipart/form-data",
                                          method: 'post',
                                          dataType: "json",
                                    }).then(resp => {
                                          console.log(resp);
                                          if (resp.error) {

                                                $.ajax({
                                                      data: {
                                                            id: servicio.id
                                                      },
                                                      url: __url__ + "?ajax&controller=Servicios&action=ingresarUnidad",
                                                      type: "POST",
                                                      dataType: "json",
                                                      success: function(r) {
                                                            console.log(r);
                                                            if (r.error != false) {
                                                                  erpalert("", "Entrada", r.mensaje);
                                                            } else {
                                                                  erpalert("error", "Entrada", r.mensaje);
                                                                  mensajeError(r.mensaje);
                                                            }
                                                            setTimeout(() => {
                                                                  getUnidades();
                                                            }, 500);
                                                      },
                                                      error: function(r) {
                                                            console.log(r.responseText);
                                                            mensajeError("Algo salio mal,  contacte al administrador.");
                                                      },
                                                });
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


                  break;
            case "11":
                  servicio = servicios.find(function(e) {
                        return e.id === idserv;
                  });;
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
                                          <select name="cliente" class="item" id="cliente" disabled>
                                                <option value="" selected>--Selecciona--</option>`;
                        for (var x = 0; x < clientes.length; x++) {
                              htmlclientes += `<option value="${clientes[x].id}" ${(clientes[x].id==servicio.cliente_id)?"selected":""}>${clientes[x].nombre} </option>`
                        }

                        htmlclientes += `</select>`;

                        htmltransportes = `<strong class="mr-1">Transporte:</strong>
                                          <select name="transporte" class="item" id="transporte" disabled>
                                                <option value="" selected>--Selecciona--</option>`;
                        for (var x = 0; x < transportes.length; x++) {
                              htmltransportes += `<option value="${transportes[x].id}" ${(transportes[x].id==servicio.tipo_transporte_id)?"selected":""}>${transportes[x].nombre} </option>`
                        }

                        htmltransportes += `</select>`;

                        Swal.fire({
                              title: /*html*/ `<h4>ENTRADAS Y SALIDAS</h4><span><h6>Servicio de Báscula</span>`,
                              confirmButtonText: 'Guardar',
                              cancelButtonText: 'Cancelar',
                              showCancelButton: true,
                              cancelButtonColor: '#d33',
                              html: /*html*/ `
                        
                              <section id="sectionForm">
                                    <form id="ensacadoForm" enctype="multipart/form-data" class="form form-horizontal">
                                          <input type="text" name="id" id="id" hidden value="${servicio.id}" /> 
                                          <h4 class="form-section"><i class="ft-user"></i> Datos Unidad</h4>
                                          <div class="form-group row">
                                                <div class="col-12 ">
                                                      <div id="divRadios" class="div-radios" disabled>
                                                            <strong for="ferrotolva">Ferrotolva:</strong>
                                                            <input class="ml-1 mr-3" id="ferrotolva" type="radio" ${(servicio.tipo_transporte_id ==6 || servicio.tipo_transporte_id ==12) ?"checked":""} name="ferrotolva" value="F" disabled/>
                                                            <strong for="ferrotolvas">Camión:</strong>
                                                            <input class="ml-1" type="radio" name="ferrotolva" value="A"  ${(servicio.tipo_transporte_id !=6 && servicio.tipo_transporte_id !=12) ?"checked":""} disabled/>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="form-group row mt-2">
                                                <div class="col-12 datos mt-2 mb-1">
                                                      <strong class="mr-1"># Unidad:</strong>
                                                      <input type="text" name="numeroUnidad" id="numeroUnidad" class="item" value="${servicio.numUnidad}" readonly disabled=""/> 
                                                </div>
                                          </div>
                                          <h4 class="form-section"><i class="ft-user"></i> Datos Cliente</h4>
                                          <div class="form-group row mt-2">
                                                <div class="col-12 datos mt-2 mb-1">
                                                      ${htmlclientes}
                                                </div>
                                          </div>
                                          <div class="col-12 datos mt-2 mb-1">
                                                <strong class="mr-1">Peso Cliente:</strong>
                                                <input type="text" name="pesoCliente" id="pesoCliente" class="item numhtml" value="${(servicio.peso_cliente==null)?"":servicio.peso_cliente}" /> 
                                          </div>
                                          <div class="form-group row mt-2">
                                                <div class="col-12">
                                                      <section id="seccionCamion" hidden>
                                                      <h4 class="form-section"><i class="ft-user"></i> Datos Transportista</h4>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div><strong class="mr-1">Transportista:</strong><input id="transportista" class="item" type="text" value="${servicio.transportista}" readonly disabled="" /></div>
                                                                  <div><strong class="mr-1">Chofer:</strong><input class="item" id="chofer" name="chofer" type="text" value="${servicio.chofer}"  readonly disabled=""/></div>
                                                            </div>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div>
                                                                        ${htmltransportes}
                                                                  </div>
                                                                  <div><strong class="mr-1">Placa tractor #1:</strong><input name="placa1" class="item" id="placa1" type="text" value="${servicio.placa1}"  readonly disabled=""/></div>
                                                                  <div><strong class="mr-1">Placa tractor #2:</strong><input name="placa2" class="item" id="placa2" type="text" value="${servicio.placa2}"  readonly disabled=""/> </div>
                                                            </div>
                                                      </section>
                                                      <section id="seccionFerrotolva" hidden>
                                                      <h4 class="form-section"><i class="ft-user"></i> Datos Transportista</h4>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div><strong class="mr-1">Transportista:</strong><input id="transportistaTren" class="item" type="text" value="${servicio.transportista}" readonly disabled=""/></div>
                                                                  <div>
                                                                        ${htmltransportes.replace('id="transporte"','id="transporteTren"')} 
                                                                  </div>
                                                            </div>
                                                      </section>
                                                </div>
                                          </div>
                                          <h4 class="form-section"><i class="ft-user"></i> Datos Báscula</h4>
                                          <div class="form-group row mt-2">
                                                <div class="col-6 datos mt-2 mb-1">
                                                      <strong class="mr-1">Tara:</strong>
                                                      <input type="text" name="tara" value="${((servicio.peso_tara != null) ? servicio.peso_tara : "0") }" id="tara" class="item" /><span class="ml-1">lbs.</span>
                                                </div>
                                                <div class="col-6 datos mt-2 mb-1">
                                                      <strong class="mr-1">Ticket:</strong>
                                                      <input type="text" name="ticket" class="item" value="${((servicio.ticket != null) ? servicio.ticket : "") }" id="ticket" class="item-small" />
                                          
                                                </div>
                                                
                                                <div class="col-6 datos mt-2 mb-1">
                                                      <strong>Tara Kilos:</strong>
                                                      <input type="text" name="taraKilos" value="${((servicio.pesoTaraKg != null) ? servicio.pesoTaraKg : "") }" id="taraKilos" class="item fixed" disabled /><span class="ml-1">kgs.</span>

                                                </div>
                                                <div class="col-6 datos mt-2 mb-1">
                                                      <strong>Peso teorico:</strong>
                                                      <input type="text" name="pesoTeorico" value="${((servicio.peso_teorico != null) ? servicio.peso_teorico : "") }" id="pesoTeorico" class="item fixed" disabled /><span class="ml-1">kgs.</span>
                                                </div>
                                                <div class="col-6 datos mt-2 mb-1">
                                                      <strong>% Tolerable:</strong>
                                                      <input type="text" name="tolerable" value="${((servicio.tolerable != null) ? servicio.tolerable : "") }" id="tolerable" class="item fixed" disabled /><span class="ml-1">kgs.</span>
                                                </div>
                                                <div class="col-6 datos mt-2 mb-1">
                                                      <strong title="Diferencia entre peso teorico y peso cliente.">Diferencia teorica:</strong>
                                                      <input type="text" name="diferenciaTeorica" value="" id="diferenciaTeorica" class="item fixed numhtml" disabled /><span class="ml-1">kgs.</span>
                                                </div>
                                                <div class="col-6 datos mt-3 mb-1">
                                                      <strong>Peso bruto:</strong>
                                                      <input type="text" name="pesoBruto" value="" id="pesoBruto" class="item fixed numhtml mt-4" disabled /><span class="ml-1">kgs.</span>
                                                </div>
                                                <div class="col-6 datos mt-2 mb-1">
                                                      <strong>Peso tara:</strong>
                                                      <input type="text" name="pesoTara" value="" id="pesoTara" class="item fixed numhtml" disabled /><span class="ml-1">kgs.</span>
                                                </div>
                                                <div class="col-6 datos mt-2 mb-1">
                                                      <strong>Peso neto:</strong>
                                                      <input type="text" name="pesoNeto" value="" id="pesoNeto" class="item fixed numhtml" disabled /><span class="ml-1">kgs.</span>
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

                                    let tipoferre = "A";
                                    if (servicio.tipo_transporte_id == 6 || servicio.tipo_transporte_id == 12) {
                                          tipoferre = "F";
                                    }
                                    cambiaFerrotolva(tipoferre);
                                    $("#ticket, #tara").change(function() {
                                          getPesos();
                                    });
                                    $("#transportista").val(servicio.transportista);
                                    formatoNumeros();

                              }
                        }).then((result) => {
                              if (result.isConfirmed) {
                                    $("#ensacadoForm").find("input, select").removeAttr("disabled");
                                    var datosForm = new FormData($("#ensacadoForm")[0]);
                                    console.log(datosForm);
                                    jQuery.ajax({
                                          url: __url__ + '?ajax&controller=Servicios&action=guardarEnsacado',
                                          data: datosForm,
                                          processData: false,
                                          contentType: false,
                                          enctype: "multipart/form-data",
                                          method: 'post',
                                          dataType: "json",
                                    }).then(resp => {
                                          console.log(resp);
                                          if (resp.error) {
                                                erpalert("", "Báscula", resp.mensaje);

                                          } else {
                                                erpalert("error", "Error", resp.mensaje)
                                                mensajeError(resp.mensaje);
                                          }
                                          getUnidades();
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

                  break;
            case "14":
                  Swal.fire({
                        title: '¿Seguro que liberará la unidad para su salida?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si'
                  }).then((result) => {
                        if (result.isConfirmed) {
                              $.ajax({
                                    data: {
                                          id: idserv
                                    },
                                    url: __url__ + "?ajax&controller=Servicios&action=salidaUnidad",
                                    type: "POST",
                                    dataType: "json",
                                    success: function(r) {
                                          console.log(r);
                                          if (r.error != false) {
                                                erpalert("", "", "Se cambió el estatus de la unidad");
                                                setTimeout(() => {
                                                      getUnidades();
                                                }, 500);
                                          } else {
                                                erpalert("error", "Ocurrió un error", r.mensaje);
                                          }
                                    },
                                    error: function(r) {
                                          console.log(r.responseText);
                                          erpalert("error", "Algo salio mal,  contacte al administrador.");
                                    },
                              });
                              if (tipoUnidad.includes("local_ship")) {
                                    window.open(__url__ + "?ajax&controller=Servicios&action=ordenSalida&id=" + idserv, "_blank");
                              }
                              // document.location.href = __url__ + "?ajax&controller=Servicios&action=ordenSalida&id=" + idserv;
                              // $.ajax({
                              // data: {
                              // id: idserv
                              // },
                              // url: __url__ + "?controller=Servicios&action=ordenSalida",
                              // type: "POST",
                              // dataType: "json",
                              // success: function(r) {
                              // console.log(r);
                              if (r.error != false) {
                                    erpalert("", "", "Se cambió el estatus de la unidad");
                                    setTimeout(() => {
                                          getUnidades();
                                    }, 500);
                              } else {
                                    erpalert("error", "Ocurrió un error", r.mensaje);
                              }
                              // },
                              // error: function(r) {
                              // console.log(r.responseText);
                              // mensajeError("Algo salio mal,  contacte al administrador.");
                              // },
                              // });






                        }
                  });
                  break;
            case "15":
                  Swal.fire({
                        title: '¿Seguro que dará salida a la unidad?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si'
                  }).then((result) => {
                        if (result.isConfirmed) {
                              $.ajax({
                                    data: {
                                          id: idserv
                                    },
                                    url: __url__ + "?ajax&controller=Servicios&action=liberaUnidad",
                                    type: "POST",
                                    dataType: "json",
                                    success: function(r) {
                                          console.log(r);
                                          if (r.error != false) {
                                                erpalert("", "", "Se liberó la unidad");
                                                setTimeout(() => {
                                                      getUnidades();
                                                }, 500);
                                          } else {
                                                erpalert("error", "Ocurrió un error", r.mensaje);
                                          }
                                    },
                                    error: function(r) {
                                          console.log(r.responseText);
                                          mensajeError("Algo salio mal,  contacte al administrador.");
                                    },
                              });






                        }
                  });
                  break;
            default:
                  break;
      }

}

function padTo2Digits(num) {
      return num.toString().padStart(2, "0");
}

function formatDate(date) {
      return (
            [
                  date.getFullYear(),
                  padTo2Digits(date.getMonth() + 1),
                  padTo2Digits(date.getDate()),
            ].join("/") +
            " " + [
                  padTo2Digits(date.getHours()),
                  padTo2Digits(date.getMinutes()),
                  padTo2Digits(date.getSeconds()),
            ].join(":")
      );
}
const validaCampos = () => {
      let faltan = false;
      $("#pesoCliente").removeClass("invalid").removeClass("checked");
      if ($("#pesoCliente").val() == "") {
            faltan = true;
            $("#pesoCliente").addClass("invalid");
      } else {
            $("#pesoCliente").addClass("checked");
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
$("#tara").blur(function() {
      if (isNumeric($(this).val())) {
            calcularPesos();
      } else {
            mensajeError("Peso debe de ser numerico.");
      }
});
$("#pesoCliente").blur(function() {
      if (isNumeric($(this).val())) {
            calcularPesos();
      } else {
            mensajeError("Peso debe de ser numerico.");
      }
});

function quitarEspacios(str) {
      return str.replace(/ /g, "");
}

function calcularPesos() {
      var pesoBruto = quitarComasNumero($("#pesoBruto").val());
      var tara = quitarComasNumero($("#tara").val());
      var taraKilos = parseInt(Math.round(tara * 0.453592));
      var pesoCliente = quitarComasNumero($("#pesoCliente").val());
      var pesoTeorico = pesoBruto - taraKilos;
      var diferenciaTeorica = pesoTeorico - pesoCliente;
      var tolerable = parseInt(Math.round(pesoCliente * 0.003));
      $("#tolerable").val(htmlNum(tolerable));
      $("#taraKilos").val(htmlNum(taraKilos));
      $("#pesoTeorico").val(htmlNum(pesoTeorico));
      $("#diferenciaTeorica").val(htmlNum(diferenciaTeorica));
      $("#pesoCliente").val(htmlNum(pesoCliente));
      $("#tara").val(htmlNum(tara));
      diferenciaTeoricaColor(diferenciaTeorica, tolerable);
}

function getPesos() {
      var ticket = $("#ticket").val();
      var ferrotolva = 0;
      if ($("input[name=ferrotolva]:checked").val() == "F") {
            ferrotolva = 1;
      }
      if (ticket != "") {
            $.ajax({
                  data: {
                        id: ticket,
                        ferrotolva: ferrotolva
                  },
                  url: __url__ + "?ajax&controller=Servicios&action=getPesos",
                  type: "POST",
                  dataType: "json",
                  success: function(r) {
                        console.log(r);
                        if (r != false) {
                              var numero = quitarEspacios(r.EntPlacas.trim());
                              if (numero == $("#numeroUnidad").val().trim()) {
                                    $("#pesoBruto").val(htmlNum(r.EntPesoB));
                                    $("#pesoTara").val(htmlNum(r.EntPesoT));
                                    $("#horaPeso").val(r.EntHoraE);
                                    $("#fechaPeso").val(formatDateToString(new Date(r.EntFechaE)));
                                    $("#horaPesoSalida").val(r.EntHoraS);
                                    $("#fechaPesoSalida").val(
                                          formatDateToString(new Date(r.EntFechaS))
                                    );
                                    $("#pesoNeto").val(
                                          htmlNum(parseInt(r.EntPesoB) - parseInt(r.EntPesoT))
                                    );
                                    calcularPesos();
                              } else {
                                    erpalert("error", "",
                                          "Numero de ferrotolva no coincide.</br><span><b> Número Ticket: </b>" +
                                          ticket +
                                          "</span></br><span><b> FT/AT: </b>" +
                                          r.EntPlacas +
                                          "</span>"
                                    );
                                    $("#ticket").addClass("required").val("");
                                    $("#divPesos").find("input").val("");
                              }
                        } else {
                              erpalert("error", "", "Ticket no registrado");
                        }
                  },
                  error: function() {
                        mensajeError("Algo salio mal,  contacte al administrador.");
                  },
            });
      }
}

function quitarComasNumero(value) {
      const regex = /,/g;
      if (value != "") {
            var num = value.replace(regex, "");
            return parseFloat(num);
      }
}

function diferenciaTeoricaColor(diferenciaTeorica, tolerable) {
      if (
            Math.sign(diferenciaTeorica) == -1 &&
            Math.abs(diferenciaTeorica) > tolerable
      ) {
            $("#diferenciaTeorica").removeClass("green");
            $("#diferenciaTeorica").addClass("warning");
      } else {
            $("#diferenciaTeorica").removeClass("warning");
            $("#diferenciaTeorica").addClass("green");
      }
}
</script>