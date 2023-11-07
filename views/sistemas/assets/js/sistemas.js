$(document).ready(function () {
    const serv = "http://localhost/GrupoLEA/";


 $('textarea').click(function (){
    $(this).removeClass('required')
 });
    
 $('#btnGenerarSolicitud').click(function (e) { 
    e.preventDefault();
    $(this).addClass('opaco no-hover');
    $(this).attr('disabled', true);
    if(validarFormularioSolicitud()){
        if($('#id').val() != ''){
        $.ajax({
            data: $('#formSolicitudServicio').serialize(),
            url: '?ajax&controller=Sistemas&action=generarSolicitudServicio',
            type: 'POST',
            success: function (r) {
            console.log(r);
            mensajeCorrecto('Se actualizo solicitud' , false)
            },
            error: function () {
              $(this).removeClass('opaco no-hover');
              $(this).attr('disabled' , false);
                mensajeError("Algo salio mal, no se actualizo la solicutud, contacte al administrador.")
            }
          });
        }else{
          $.ajax({
            data: $('#formSolicitudServicio').serialize(),
            url: '?ajax&controller=Sistemas&action=generarSolicitudServicio',
            type: 'POST',
            success: function (r) {
            console.log(r);
            mensajeCorrecto('Se genero la solicitud ' + r , false, true);
            },
            error: function () {
              $(this).removeClass('opaco no-hover');
              $(this).attr('disabled', false);
                mensajeError("Algo salio mal, no se genero la solicutud, contacte al administrador.");
            }
          });
        }
       }else{
        $(this).removeClass('opaco no-hover');
        $(this).attr('disabled', false);
        mensajeError("Complete los datos solicitados.");
       }
    });

    $('#btnIniciarSolicitud').click(function (e) { 
        e.preventDefault();
            if($('#id').val() != ''){
            $.ajax({
                data: {id : $('#id').val()},
                url: '?ajax&controller=Sistemas&action=iniciarSolicitudServicio',
                type: 'POST',
                success: function (r) {
                console.log(r);
                mensajeCorrecto('Se inicio solicitud' , true)
                },
                error: function () {
                    mensajeError("Algo salio mal, no se inicio la solicutud, contacte al administrador.")
                }
              });
            }
        });


 //funcion eliminar solicitud
  $('#tablaRegistros').on('click', '#deleteSolicitud', function () {
    var tr = $(this).closest('tr');
    var id = tr.find('#idTabla').html()
    if (id != "") {
      eliminarSolicitud (id);
    }
  });

  $('#btnCancelarSolicitud').click(function(e){
    e.preventDefault();
    var id = $('#id').val();
    if (id != "") {
        eliminarSolicitud (id);
      }
  });

  function eliminarSolicitud(id){
    $.confirm({
        title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
        content: '¿Seguro desea eliminar la soliciutud?',
        type: 'red',
        typeAnimated: true,
        animation: 'zoom',
        closeAnimation: 'right',
        backgroundDismiss: false,
        backgroundDismissAnimation: 'shake',
        buttons: {
          tryAgain: {
            text: 'Eliminar',
            btnClass: 'btn-red',
            action: function () {
              $.ajax({
                data: { idSolicitud: id },
                url: '?ajax&controller=Sistemas&action=eliminarSolicitudServicio',
                type: 'POST',
                success: function (r) {
                   location.reload();
                },
                error: function () {
                  alert("Algo salio mal, no se logro eliminar")
                }
              });
            }
          },
          Cancelar: function () {
          }
        }
      });
  }

  $('#btnFinalizarSolicitud').click(function(e){
    e.preventDefault();
    var id = $('#id').val();
    var solucion = $('#solucion').val();
    if(solucion == ""){
        $('#solucion').addClass('required');
        mensajeError('Especifique la solución');
    } else{
    if (id != "" ) {
        $.confirm({
            title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
            content: '¿Desea finalizar solicitud?',
            type: 'orange',
            typeAnimated: true,
            animation: 'zoom',
            closeAnimation: 'right',
            backgroundDismiss: false,
            backgroundDismissAnimation: 'shake',
            buttons: {
              tryAgain: {
                text: 'Finalizar',
                btnClass: 'btn btn-warning',
                action: function () {
                    $.ajax({
                        data: { idSolicitud: id, solucionSolicitud: solucion },
                        url: '?ajax&controller=Sistemas&action=finalizarSolicitudServicio',
                        type: 'POST',
                        success: function (r) {
                           console.log(r);
                           location.reload();
                        },
                        error: function () {
                          alert("Algo salio mal, contacte al administrador")
                        }
                      });
                }
              },
              Cancelar: function () {         
              }
            }
          });
      }
    }
  });

  $('#btnImprimirSolicitud').on('click', function (e) {
      e.preventDefault();
    var id = $('#id').val();
    showSolictudServicio(id);
  });

  $('#tablaRegistros').on('click', '#showSolicitud', function () {
    var tr = $(this).closest('tr');
    var id = tr.find('#idTabla').html();
    showSolictudServicio(id);
  });

  function showSolictudServicio(id){
    window.open(serv + "?controller=Sistemas&action=imprimirSolicitud&&idSolicitud=" + id, "Imprimir solicitud de servicio", "width=1300,height=600");
  }

  $('#tipoRequerimiento').change(function(){
     var req = $(this).val();
     if(req != "" && req == 2){
       $('#equipoModal').modal('show');
     }
     else{
      $('#divEquipo').removeClass('d-flex justify-content-between');
      $('#idEquipoSolicitud').val("");
     }
  });

  $('#tipoSelect').change(function(){
    var equipo = $(this).val();
    if(equipo == 1 || equipo == 2 || equipo == 3){
      var usuario = $('#usuarioSolicitudId').val();   
      buscarEquipoComputoAsignado(equipo, usuario);
    }else{
      buscarEquipoComputoAsignado(equipo, 0);
    }
 });

    function buscarEquipoComputoAsignado(equipo, usuario){
      var equipoSelect = $('#equipoSelect');
      $.ajax({
        data: { idUsuario: usuario, tipoEquipo: equipo},
        url: '?ajax&controller=Catalogo&action=equipoComputoByTipo',
        type: 'POST',
        dataType: 'json',
        success: function (r) {
          console.log(r);
          if(r.length != 0){
          equipoSelect.prop('disabled', false);
          equipoSelect.find('option').not(':first').remove();
          $(r).each(function (i, v) { // indice, valor
         equipoSelect.append('<option value="' + v.id + '">' + v.modelo + ' - ' + v.folio +'</option>');
          })
        }else{
          console.log(r);
          equipoSelect.prop('disabled', true);
          equipoSelect.find('option').not(':first').remove();
          mensajeError('No hay equipos registrados, o no tiene un equipo asignado')
        }
        },
        error: function () {
          alert('Algo salio mal, contacte al administrador del sistema');
        }
      });
    } 

    $('#equipoModal').on('hidden.bs.modal', function () {
      $('#formEquipo').trigger('reset');
    });

    $('#btnEquipo').click(function(){
    var equipo =  $('#equipoSelect').val();
    if(equipo != ""){
      buscarEquipoComputo(equipo);
    }
    });
    
    var idEquipo = $('#idEquipoSolicitud').val();
    if(idEquipo != undefined && idEquipo != ""){
    buscarEquipoComputo(idEquipo);
    }

    function buscarEquipoComputo(equipo){
      $.ajax({
        data: {idEquipo: equipo},
        url: '?ajax&controller=Catalogo&action=equipoComputoById',
        type: 'POST',
        dataType: 'json',
        success: function (r) {
          $('#idEquipoSolicitud').val(r[0].id);
          $('#tipoEquipo').val(r[0].tipo_equipo);
          $('#folio').val(r[0].folio);
          $('#marca').val(r[0].marca);
          $('#serie').val(r[0].numero_serie);
          $('#modelo').val(r[0].modelo);
          $('#equipoModal').modal("hide")
          $('#divEquipo').addClass('d-flex justify-content-between');
        },
        error: function () {
          alert('Algo salio mal, contacte al administrador del sistema');
        }
      });
    }

    $('#deleteEquipo').click(function(){
      $('#idEquipoSolicitud').val("");
      $('#tipoRequerimiento').val("");
      $('#divEquipo').removeClass('d-flex justify-content-between');
    });

    $('#buscarSolicitud').click(function () {
      $('#buscarSolicitudes').modal('show');
    });
  
    $('#buscarSolicitudes').on('hidden.bs.modal', function () {
      $('#formBuscarSolicitud').trigger('reset');
    });

    $('#btnBuscarSolicitud').click(function(){
      var fechaIni = $('#fechaInicioSolicitud').val() == '' ? true : false;
      var fechaFin = $('#fechaFinSolicitud').val() == '' ? true : false;
      var user = $('#usuarioSolicitud').val() == '' ? true : false;
      var folio = $('#folioSolicitud').val() == '' ? true : false;
      if (fechaIni && fechaFin && user && folio){
        mensajeError('Debe de agregar un campo de busqueda');
      }else {
       $('#formBuscarSolicitud').submit();
       $('#buscarSolicitudes').modal('hide');
      }
    });

    $('#indicadorSolicitudes').click(function(){
      $('#indicadorSolicitudesModal').modal('show');
    });
  
    $('#indicadorSolicitudesModal').on('hidden.bs.modal', function () {
      $('#formIndicadorSolicitud').trigger('reset');
    });
  

    $('#btnExcelSolicitud').click(function () {
      $('#pdf').val(0);
      validarFormIndicador();
    });
    
    $('#btnPdfSolicitud').click(function () {
      $('#pdf').val(1);
      validarFormIndicador();
    });
  
     function validarFormIndicador(){
      var fechaIni = $('#fechaInicioExp').val() == '' ? true : false;
      var fechaFin = $('#fechaFinExp').val() == '' ? true : false;
      if (fechaIni || fechaFin){
        mensajeError('Debe de seleccionar periodo');
      }else {
       $('#formIndicadorSolicitud').submit();
       $('#indicadorSolicitudesModal').modal('hide');
      }
     }
  
     
    function validarFormularioSolicitud(){
        var inputs = $('#formSolicitudServicio').find('select');
         var valid = true;
        inputs.each(function(){
         if($(this).val() == null || $(this).val() == ""){
          $(this).addClass('required');
           valid = false;
        }
        });
        if($('#descripcion').val() == ""){
            $('#descripcion').addClass('required');
            valid = false;
        };
        if( $('#tipoRequerimiento').val() == 2 && $('#idEquipoSolicitud').val() == "" ){
          mensajeError('Debes de seleccionar un equipo. Si no esta en la lista, solicite que se le asigne o se registre al administrador.');
          $('#equipoModal').modal('show');
          valid = false;
        }
        return valid;
      }

      $('#tablaRegistros').on('click', '#btnMantenimiento', function () {
        var tr = $(this).closest('tr');
        var id = tr.find('#idEquipo').html();
        if (id != "" ) {
            $.confirm({
                title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
                content: '¿Desea generar solicitud de mantenimiento para este equipo?',
                type: 'orange',
                typeAnimated: true,
                animation: 'zoom',
                closeAnimation: 'right',
                backgroundDismiss: false,
                backgroundDismissAnimation: 'shake',
                buttons: {
                  tryAgain: {
                    text: 'Generar',
                    btnClass: 'btn btn-warning',
                    action: function () {
                        $.ajax({
                            data: { idEquipo: id},
                            url: '?ajax&controller=Sistemas&action=generarSolicitudServicioByEquipo',
                            type: 'POST',
                            success: function (r) {
                               mensajeCorrecto('Se genero solicitud con folio: ' + r , true);
                            },
                            error: function () {
                              alert("Algo salio mal, contacte al administrador")
                            }
                          });
                    }
                  },
                  Cancelar: function () {         
                  }
                }
              });
        }
      });

      function mensajeError(result) {
        $.confirm({
          title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
          content: result,
          type: 'red',
          typeAnimated: true,
          animation: 'zoom',
          closeAnimation: 'right',
          backgroundDismiss: false,
          backgroundDismissAnimation: 'shake',
          buttons: {
            tryAgain: {
              text: 'Entendido',
              btnClass: 'btn-red',
              action: function () {
              }
            }
          }
        });
      }

      function mensajeCorrecto(result, reload=false, redirect=false) {
        $.confirm({
          title: "<span class='material-icons i-correcto'>check_circle_outline</span><span>¡Correcto!<span>",
          content: result,
          type: 'green',
          typeAnimated: true,
          draggable: true,
          buttons: {
            tryAgain: {
              text: 'Ok',
              btnClass: 'btn-success',
              action: function () {
                if(reload){
                  location.reload();
                }
                if(redirect){
                 window.location = serv + 'views/principal/?controller=Sistemas&action=solicitudes';
                }
              }
            }
          }
        });
      }
    
});
