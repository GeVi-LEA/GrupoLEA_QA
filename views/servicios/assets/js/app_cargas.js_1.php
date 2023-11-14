<!-- document.head.appendChild( elementToAdd ); -->
<?php
// print_r('<pre>');
// print_r($idEst);
// print_r('</pre>');

?>
<script>
let servicios;
$(document).ready(function() {
      console.log("entra en app cargas");
      getServicios();
      swal.close();
      setInterval(() => {
            getServicios();
      }, 60000);
});

const getServicios = () => {
      $("#enviarAlmacenModal1").modal("hide");
      $.ajax({
            url: __url__ + "?ajax&controller=Servicios&action=getServCargas",
            data: {

            },
            method: 'post',
            dataType: "json",
      }).then(resp => {
            servicios = resp.servCargas;
            let htmlservicios = "";
            let hopper = "";
            let inicio = 0;
            $(".panelunidades").html("");
            for (var x = 0; x < servicios.length; x++) {
                  if (servicios[x].hopper != hopper) {
                        hopper = servicios[x].hopper
                        htmlservicios += /*html*/ `
                                                <div class='col '>
                                                            <div class='card sombra'>
                                                                  <div class='card-content'>
                                                                        <div class='card-header'>
                                                                              <h4 class='card-title'>${servicios[x].hopper} - ${servicios[x].transportista} - ${servicios[x].chofer} </h4>
                                                                        </div>
                                                                        <div class='card-body p-0'>
                                                                              <h6 class='card-subtitle text-muted'></h6>
                                                                              <div class='card-body'>
                                                                                    <div class='card servicio ${servicios[x].estatus_operacion}'>
                                                                                          <div class='card-content'>
                                                                                                <div class='card-body p-0'>
                                                                                                      <h6 class='card-title'><strong>Producto:</strong>${servicios[x].producto} - <strong>Lote:</strong>${servicios[x].lote} - <strong>Almacén:</strong>${(servicios[x].almacen!="")?'<i>'+servicios[x].almacen+'</i>':""} <br /> ${servicios[x].cliente}</h6>
                                                                                                      <div class='botones'>
                                                                                                            ${(servicios[x].fecha_inicio !="" ? '<span id="detenerServicios" class="fa-regular fa-circle-stop material-icons i-pdf border-btn" onclick="detenerServicio('+servicios[x].id_servicio+')"></span>':'<span id="iniciarServicios" class="material-icons i-iniciar border-btn" onclick="iniciarServicio('+servicios[x].id_servicio+')">play_arrow</span>' )}
                                                                                                            
                                                                                                      </div>
                                                                                                      <h6 class='card-subtitle text-muted'><i>TIPO SERVICIO(${servicios[x].empaque}) CARGA</i></h6>
                                                                                                      <div class='card-body'>
                                                                                                            <p><strong>Rótulo:</strong> ${servicios[x].rotulo}</p>
                                                                                                            <p><strong>Fecha Programacion:</strong> ${servicios[x].fecha_programacion}</p>
                                                                                                            <p><strong>Cantidad:</strong> ${servicios[x].kilos} KG</p>
                                                                                                            <p><strong><i>Tarimas:</strong> ${servicios[x].tarimas}</i> <strong><i>Parcial:</strong> ${servicios[x].parcial}</i></p>
                                                                                                            <p></p>
                                                                                                            <p></p>
                                                                                                            ${(servicios[x].fecha_inicio !="" ? '<p><strong>Fecha Inicio:</strong> '+servicios[x].fecha_inicio+'</p><p><strong>Tiempo Operacion:</strong> '+servicios[x].tiempo_operacion+'</p>':'' )}
                                                                                                            <!-- <p><strong>Fecha Inicio:</strong>HOY</p>
                                                                                                            <p><strong>Operador:</strong>Gerardo Villarreal</p>-->
                                                                                                      </div>
                                                                                                </div>
                                                                                          </div>
                                                                                    </div>                                                                                    
                                          `;
                  } else {
                        htmlservicios += /*html*/ `<div class='card servicio ${servicios[x].estatus_operacion}'>
                                                      <div class='card-content'>
                                                            <div class='card-body p-0'>
                                                                  <h6 class='card-title'><strong>Producto:</strong>${servicios[x].producto} - <strong>Lote:</strong>${servicios[x].lote} - <strong>Almacén:</strong>${(servicios[x].almacen!="")?'<i>'+servicios[x].almacen+'</i>':""} <br /> ${servicios[x].cliente}</h6>
                                                                  <div class='botones'>
                                                                        ${(servicios[x].fecha_inicio !="" ? '<span id="detenerServicios" class="fa-regular fa-circle-stop material-icons i-pdf border-btn" onclick="detenerServicio('+servicios[x].id_servicio+','+servicios[x].almacen_id+')"></span>':'<span id="iniciarServicios" class="material-icons i-iniciar border-btn" onclick="iniciarServicio('+servicios[x].id_servicio+')">play_arrow</span>' )}
                                                                  </div>
                                                                  <h6 class='card-subtitle text-muted'><i>TIPO SERVICIO(${servicios[x].empaque})</i></h6>
                                                                  <div class='card-body'>
                                                                        <p><strong>Rótulo:</strong> ${servicios[x].rotulo}</p>
                                                                        <p><strong>Fecha Programacion:</strong> ${servicios[x].fecha_programacion}</p>
                                                                        <p><strong>Cantidad:</strong> ${servicios[x].kilos} KG</p>
                                                                        <p><strong><i>Tarimas:</strong> ${servicios[x].tarimas}</i> <strong><i>Parcial:</strong> ${servicios[x].parcial}</i></p>
                                                                        <p></p>
                                                                        <p></p>
                                                                        ${(servicios[x].fecha_inicio !="" ? '<p><strong>Fecha Inicio:</strong> '+servicios[x].fecha_inicio+'</p><p><strong>Tiempo Operacion:</strong> '+servicios[x].tiempo_operacion+'</p>':'' )}
                                                                        <!-- <p><strong>Fecha Inicio:</strong>HOY</p>
                                                                        <p><strong>Operador:</strong>Gerardo Villarreal</p>-->
                                                                  </div>
                                                            </div>
                                                      </div>
                                                </div>
                                                `;
                  }
                  try {
                        if (servicios[x + 1].hopper != hopper) {
                              htmlservicios += `                        </div>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>`;
                        }
                  } catch (err) {
                        htmlservicios += `                        </div>
                                     </div>
                               </div>
                         </div>
                   </div>`;
                  }

            }

            $(".panelunidades").html(htmlservicios);




      }).fail(resp => {}).catch(resp => {
            erpalert("error", 'Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores... ' + resp);
            console.log("error unidades: ", resp);
      });
}

let servicio;
const accionEtapa = (idserv) => {
      let idEtapa = $("#idEtapa").val();
      console.log("idEtapa: ", idEtapa);
      console.log("idserv: ", idserv);
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
                                          <div class="col-12 datos mt-2 mb-1">
                                                <strong class="mr-1">Peso Cliente:</strong><input type="text" name="pesoCliente" id="pesoCliente" class="item-medium item" value="${(servicio.peso_cliente==null)?"":servicio.peso_cliente}" /> 
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
                                    let tipoferre = "A";
                                    if (servicio.tipo_transporte_id == 6 || servicio.tipo_transporte_id == 12) {
                                          tipoferre = "F";
                                    }
                                    cambiaFerrotolva(tipoferre);

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
                                                      <input type="text" name="numeroUnidad" id="numeroUnidad" class="item" value="${servicio.numUnidad}" readonly/> 
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
                                                <input type="text" name="pesoCliente" id="pesoCliente" class="item" value="${(servicio.peso_cliente==null)?"":servicio.peso_cliente}" /> 
                                          </div>
                                          <div class="form-group row mt-2">
                                                <div class="col-12">
                                                      <section id="seccionCamion" hidden>
                                                      <h4 class="form-section"><i class="ft-user"></i> Datos Transportista</h4>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div><strong class="mr-1">Transportista:</strong><input id="transportista" class="item" type="text" disabled /></div>
                                                                  <div><strong class="mr-1">Chofer:</strong><input class="item" id="chofer" name="chofer" type="text"  disabled/></div>
                                                            </div>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div>
                                                                        ${htmltransportes}
                                                                  </div>
                                                                  <div><strong class="mr-1">Placa tractor #1:</strong><input name="placa1" class="item" id="placa1" type="text"  disabled/></div>
                                                                  <div><strong class="mr-1">Placa tractor #2:</strong><input name="placa2" class="item" id="placa2" type="text"  disabled/> </div>
                                                            </div>
                                                      </section>
                                                      <section id="seccionFerrotolva" hidden>
                                                      <h4 class="form-section"><i class="ft-user"></i> Datos Transportista</h4>
                                                            <div class="datos mt-2 mb-1">
                                                                  <div><strong class="mr-1">Transportista:</strong><input id="transportistaTren" class="item" type="text"  disabled/></div>
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
                                                      <input type="text" name="tara" value="${((servicio.peso_tara != null) ? servicio.peso_tara : "") }" id="tara" class="item" /><span class="ml-1">lbs.</span>
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
                                                      <input type="text" name="diferenciaTeorica" value="" id="diferenciaTeorica" class="item fixed" disabled /><span class="ml-1">kgs.</span>
                                                </div>
                                                <div class="col-6 datos mt-3 mb-1">
                                                      <strong>Peso bruto:</strong>
                                                      <input type="text" name="pesoBruto" value="" id="pesoBruto" class="item fixed mt-4" disabled /><span class="ml-1">kgs.</span>
                                                </div>
                                                <div class="col-6 datos mt-2 mb-1">
                                                      <strong>Peso tara:</strong>
                                                      <input type="text" name="pesoTara" value="" id="pesoTara" class="item fixed" disabled /><span class="ml-1">kgs.</span>
                                                </div>
                                                <div class="col-6 datos mt-2 mb-1">
                                                      <strong>Peso neto:</strong>
                                                      <input type="text" name="pesoNeto" value="" id="pesoNeto" class="item fixed" disabled /><span class="ml-1">kgs.</span>
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

function iniciarServicio(id) {
      console.log(id);
      $.confirm({
            title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
            content: "<b>¿Iniciar servicio?</b>",
            type: "orange",
            typeAnimated: true,
            animation: "zoom",
            closeAnimation: "right",
            backgroundDismiss: false,
            backgroundDismissAnimation: "shake",
            buttons: {
                  tryAgain: {
                        text: "Iniciar servicio",
                        btnClass: "btn btn-warning",
                        action: function() {
                              $.ajax({
                                    data: {
                                          id: id
                                    },
                                    url: __url__ + "?ajax&controller=Servicios&action=iniciarServicio",
                                    type: "POST",
                                    dataType: "json",
                                    success: function(r) {
                                          console.log(r);
                                          if (r != false) {
                                                erpalert("", "", r.mensaje);
                                          } else {
                                                erpalert("error", "Error", r.mensaje);
                                          }
                                          getServicios();
                                    },
                                    error: function(r) {
                                          console.log(r.responseText);
                                          mensajeError("Algo salio mal,  contacte al administrador.");
                                    },
                              });
                        },
                  },

                  Cancelar: function() {},
            },
      });
}

function detenerServicio(id, almacen_id = "1") {
      var form = $("#formEnviarAlmacen");
      var select = $(form).find("#selectAlmacen");
      $.ajax({
            url: __url__ + "?ajax&controller=Catalogo&action=getAlmacenes",
            type: "POST",
            dataType: "json",
            success: function(r) {
                  console.log(r);
                  if (r != false) {
                        select.find("option").not(":first").remove();
                        if (r.length != 0) {
                              $(r).each(function(i, v) {
                                    // indice, valor
                                    select.append(
                                          '<option value="' + v.id + '">' + v.nombre + "</option>"
                                    );
                              });
                        } else {
                              select.append(
                                    '<option value="" disabled>No hay almacenes registrados</option>'
                              );
                        }
                  }
            },
            error: function() {
                  alert("Algo salio mal, contacte al Administrador.");
            },
      });
      $("#idServicioEnviar").val(id);
      $(form).find(id);
      $(form).find($("#operacionEnviar")).val("S");
      // $("#enviarAlmacenModal1").modal("show");
      // $("#enviarFinalizarServicio").unbind();
      // $("#enviarFinalizarServicio").click(function() {
      // if (validarDatosEnviarAlmacen()) {
      let servicio = servicios.filter(el => el.id_servicio == id)[0];
      $.confirm({
            title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
            content: "<b>¿Finalizar servicio?</b>",
            type: "orange",
            typeAnimated: true,
            animation: "zoom",
            closeAnimation: "right",
            backgroundDismiss: false,
            backgroundDismissAnimation: "shake",
            buttons: {
                  tryAgain: {
                        text: "Finalizar servicio",
                        btnClass: "btn btn-warning",
                        action: function() {
                              $.ajax({
                                    // data: $("#formEnviarAlmacen").serialize(),
                                    data: {
                                          idServicioEnviar: id,
                                          operacionEnviar: "S",
                                          cantidadAlmacen: servicio.kilos.replace(",", ""),
                                          almacen: almacen_id,


                                    },
                                    url: "?ajax&controller=Servicios&action=finalizarServicio",
                                    type: "POST",
                                    dataType: "json",
                                    success: function(r) {
                                          console.log(r);
                                          if (r.error != false) {
                                                erpalert("", "", r.mensaje);
                                          } else {
                                                erpalert("error", "Error", r.mensaje);
                                          }
                                          getServicios();
                                    },
                                    error: function(r) {
                                          console.log(r.responseText);
                                          mensajeError("Algo salio mal,  contacte al administrador.");
                                    },
                              });
                        },
                  },
                  Cancelar: function() {},
            },
      });
      // } else {
      // erpalert("error", "", "No puede estar un campo vacio.");
      // }
      // });
}


function validarDatosEnviarAlmacen() {
      var form = $("#formEnviarAlmacen");
      var inputs = $(form).find("input, select");
      var valid = true;
      inputs.each(function() {
            console.log($(this));
            if ($(this).val() == null || $(this).val() == "") {
                  $(this).addClass("required");
                  valid = false;
                  console.log(this);
            }
      });
      return valid;
}
</script>