$(document).ready(function () {

$('#fechaPedimento').change(function (){
 var fechaPedimento = getFormatDate($(this).val());
 var fechaIni = formatDateToString((new Date(fechaPedimento.setDate(fechaPedimento.getDate() + 1))));
  tipoCambio(fechaIni);
});

function tipoCambio(fechaIni){
  var token = getToken();
fetch('https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF60653/datos/'+fechaIni+'/'+fechaIni+'?token='+token)
.then(response => response.json())
.then(datos => {
  var tipoCambio = datos.bmx.series[0].datos[0].dato;
  $('#tipoCambio').val(tipoCambio);
  calcularTotalesPedimento(tipoCambio);
})
.catch(e => {mensajeError(e);});
}

$('#editImporte').click(function () {
  $.confirm({
    title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
    content: '<br> <strong>¿Desea cambiar el precio de compra?</strong>',
    type: 'orange',
    typeAnimated: true,
    animation: 'zoom',
    closeAnimation: 'right',
    backgroundDismiss: false,
    backgroundDismissAnimation: 'shake',
    buttons: {
      tryAgain: {
        text: 'Entendido',
        btnClass: 'btn btn-warning',
        action: function () {
          $('#enviarModal').modal('show');
        }
      },
      Cancelar: function () {
      }
    }
  });
});

//funcion enviar cambio de precio
$('#enviarCambioPrecio').click(function (e) {
  e.preventDefault();
  $(this).attr('disabled', true);
  var cuerpo = $('#cuerpoCorreo').val();
  var folio = $('#folioOrdenProducto').text();
  var precioAnte = $('#precioFactura').val();
  var precioNuevo = $('#precioFacturaNuevo').val();
  if(isNumeric(precioNuevo)){
    $('#precioFacturaNuevo').removeClass('required')
    if (cuerpo == "") {
      $('#enviarCambioPrecio').attr('disabled', false);
      var msnj = "Cuerpo de correo vacio, agregue comentario.";
      mensajesValidacion(msnj);
    }else{
      var datosForm = new FormData();
      datosForm.append('cuerpo', cuerpo);
      datosForm.append('folio', folio);
      datosForm.append('precioNuevo', precioNuevo);
      datosForm.append('precioAnterior', precioAnte);
        $('#enviarModal').modal('hide');
        $.ajax({
          data: datosForm,
          enctype: 'multipart/form-data',
          processData: false,
          contentType: false,
          url: '?ajax&controller=Compras&action=enviarAvisoCambioPrecio',
          type: 'POST',
          dataType: 'json',
          success: function (r) {
            $('#enviarCambioPrecio').attr('disabled', false);
            mensajeCorrecto("Se envio aviso.", false);
            $('#precioFactura').val(precioNuevo);
            $('#observacionesEmbarque').val(cuerpo);
            precioFactura($('#precioFactura'));
          },
          error: function (r) {
            $('#enviarCambioPrecio').attr('disabled', false);
            mensajeError("Algo salio mal, verifique los datos o contacte al admin. del sistema.");
          }
        }); 
      }
    }else{
      $('#precioFacturaNuevo').addClass('required');
    }
    });

$('#editIncrementable').click(function () {
  quitarFixed($('#incrementable'));
 });

 $('#editPrv').click(function () {
  quitarFixed($('#prvPedimento'));
 });

 $('#editDta').click(function () {
  quitarFixed($('#dtaPedimento'));
 });
 
$('#cantidadFactura').blur(function(){
  cantidadFactua($(this));
});

function cantidadFactua(cantidadFactura){
  var cant = $(cantidadFactura).val().trim();
  if(isNumeric(cant)){
    var cantidad = quitarComasNumero(cant);
    var cantidadOrden = quitarComasNumero($('#cantidadOrden').text());
    var cantidadEmbarcada = quitarComasNumero($('#cantidadEmbarcada').text());
    if((cantidadEmbarcada + cantidad) > cantidadOrden){
      $.confirm({
        title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
        content: 'Se supero la cantidad solicitada en la orden de compra. <br> <strong>¿Desea realizar embarque?</strong>',
        type: 'orange',
        typeAnimated: true,
        animation: 'zoom',
        closeAnimation: 'right',
        backgroundDismiss: false,
        backgroundDismissAnimation: 'shake',
        buttons: {
          tryAgain: {
            text: 'Entendido',
            btnClass: 'btn btn-warning',
            action: function () {
              calcularImporte();
              calcularLitrosFactura();
              $(cantidadFactura).val(htmlNum(cantidad)).removeClass('required');
            }
          },
          Cancelar: function () {
            $(cantidadFactura).addClass('required');
          }
        }
      });
    }else{
    calcularImporte();
    calcularLitrosFactura();
    $(cantidadFactura).val(htmlNum(cantidad)).removeClass('required');
    }
  } else{
    $(cantidadFactura).addClass('required');
    mensajeError("Debe de ser número")
  }
}

function calcularLitrosFactura(){
  var galones = quitarComasNumero($('#cantidadFactura').val().trim());
  var litros = galones * 3.78541;
  $('#litrosFactura').val(htmlNum(litros.toFixed(2)));
}

function calcularImporte(){
  var galones = quitarComasNumero($('#cantidadFactura').val().trim());
  var precio = quitarComasNumero($('#precioFactura').val().trim());
  var importe = parseFloat((galones * precio));
  $('#importeFactura').val(htmlNum(importe.toFixed(2)));
  calcularValorDolares();
}

function calcularValorDolares(){
  var oil = quitarComasNumero($('#oilFee').val().trim());
  var importe = quitarComasNumero($('#importeFactura').val().trim()); ;
  var incrementable = quitarComasNumero($('#incrementable').val().trim());
  var otros = quitarComasNumero($('#otrosCargosPed').val().trim());
  var valor = importe + incrementable + otros + oil;
  $('#valorDolares').val(htmlNum(valor));
  var tipoCambio = $('#tipoCambio').val();
  if(tipoCambio != ''){
  calcularTotalesPedimento(tipoCambio);
  }
}

function calcularIncrementables(){
  var oil = quitarComasNumero($('#oilFee').val().trim());
  var incrementable = quitarComasNumero($('#incrementable').val().trim());
  var otros = quitarComasNumero($('#otrosCargosPed').val().trim());
  var total = incrementable + oil + otros;
  $('#totalIncrementable').val(htmlNum(total.toFixed(2)));
}

function calcularTotalesPedimento(tipoCambio){
  var pesos = parseFloat(tipoCambio);
  var incr = quitarComasNumero($('#totalIncrementable').val()) * pesos;
  var valorPesos = quitarComasNumero($('#valorDolares').val()) * pesos;
  var ivaPedimento = valorPesos * .16;
  var comercial = valorPesos - incr;
  $('#incrementablesPeso').val(htmlNum(incr.toFixed(2)));
  $('#valorAduana').val(htmlNum(valorPesos.toFixed(2)));
  $('#ivaPedimento').val(htmlNum(ivaPedimento.toFixed(2)));
  $('#valorComercial').val(htmlNum(comercial.toFixed(2)));
  calcularImpuestos(ivaPedimento);
  }
  
  function calcularImpuestos(iva){
    var prv = quitarComasNumero($('#prvPedimento').val());
    var dta = quitarComasNumero($('#dtaPedimento').val());
    var ivaPrv = prv *.16;
    var ivaDta = dta * .16;
    var imp = iva + prv + ivaPrv + dta + ivaDta;
    var totalIva= iva + ivaDta;
    $('#ivaPedimento').val(htmlNum(totalIva.toFixed(2)));
    $('#ivaPrv').val(htmlNum(ivaPrv.toFixed(2)));
    $('#dtaPedimento').val(htmlNum(dta.toFixed(2)));
    $('#impuestosPedimento').val(htmlNum(imp.toFixed(2)));
  }

$('#incrementable').blur(function(){
  var increment = $(this).val().trim();
  if(isNumeric(increment)){
    $(this).removeClass('required');
    calcularIncrementables();
    calcularValorDolares();
    agregarFixed($(this));
  }else{
    $(this).addClass('required');
    mensajeError("Debe de ser número")
  }
});

$('#otrosCargosPed').blur(function(){
  var increment = $(this).val().trim();
  if(isNumeric(increment)){
    $(this).removeClass('required');
    calcularIncrementables();
    calcularValorDolares();
  }else{
    $(this).addClass('required');
    mensajeError("Debe de ser número")
  }
});

$('#precioFacturaNuevo').blur(function(){
  var precio = $(this).val().trim();
  if(isNumeric(precio)){
 $(this).removeClass('required');
  }else{
    $(this).addClass('required');
    mensajeError("Debe de ser número")
  }
});

$('#oilFee').blur(function(){
  var oil = $(this).val().trim();
    if(isNumeric(oil)){
      $(this).removeClass('required');
      calcularIncrementables();
      calcularValorDolares();
    }else{
      $(this).addClass('required');
      mensajeError("Debe de ser número")
    }
});

function precioFactura(precioInput){
  var precio = $(precioInput).val().trim();
  if(isNumeric(precio)){
  $(precioInput).removeClass('required');
  agregarFixed($(precioInput));
  calcularImporte();
  }else{
    $(precioInput).addClass('required');
    mensajeError("Debe de ser número")
  }
}

function agregarFixed(input){
  $(input).attr('readOnly', true).addClass('fixed');
}

function quitarFixed(input){
  $(input).removeAttr('readOnly').removeClass('fixed').focus().val('');
}

$('#prvPedimento').blur(function(){
  var prv = $(this).val().trim();
  if(isNumeric(prv)){
  $(this).removeClass('required');
  var iva = quitarComasNumero($('#ivaPedimento').val());
  agregarFixed($(this));
  calcularImpuestos(iva);
  }else{
    $(this).addClass('required');
    mensajeError("Debe de ser número")
  }
});

$('#dtaPedimento').blur(function(){
  var dta = $(this).val().trim();
  if(isNumeric(dta)){
  $(this).removeClass('required');
  var tipoCambio = $('#tipoCambio').val();
  var pesos = parseFloat(tipoCambio);
  var valorPesos = quitarComasNumero($('#valorDolares').val()) * pesos;
  var ivaPedimento = valorPesos * .16;
  agregarFixed($(this));
  calcularImpuestos(ivaPedimento);
  }else{
    $(this).addClass('required');
    mensajeError("Debe de ser número")
  }
});

$('#fechaFactura, #fechaPedimento').datepicker({
  showOn: 'button',
  changeMonth: true,
  changeYear: true,
  buttonText: "<span class='fas fa-calendar-alt i-calendar'></span>",
});

$("#proveedorFlete").change(function () {
  $('#transporte').removeAttr('disabled').val("");
  $('#ruta').val("");
  $('#costoFlete').val("");
});

$("#transporte").change(function () {
  $('#ruta').removeAttr('disabled');
 buscarRuta();
});

function buscarRuta() {
  var ruta = $("#ruta");
  var idRuta = $(ruta).val();
  var proveedor = $('#proveedorFlete');
  var transporte =  $("#transporte");
  console.log(proveedor.val());
  console.log(transporte.val());
    if (proveedor.val() != '') {
      $.ajax({
        data: { idProveedor: proveedor.val(), idTransporte: transporte.val()},
        url: '?ajax&controller=Catalogo&action=rutasByProveedorTransporte',
        type: 'POST',
        dataType: 'json',
        success: function (r) {
          ruta.find('option').not(':first').remove();
          if(r.length != 0){
            $(r).each(function (i, v) { // indice, valor
              ruta.append('<option value="' + v.id + '">' + v.ciudad_or + ' - ' + v.ciudad_des + '</option>');
            });
            $(ruta).val(idRuta);
          }else{
            ruta.append('<option value="" disabled>No hay rutas registradas</option>');
          }
        },
        error: function () {
          alert('Algo salio mal al buscar ruta, contacte al administrador del sistema');
        }
      });
    }
}

if($('#ruta').val() != "" && $('#tipoFlete').val() == 2){
  buscarPrecioRuta();
}

$('#ruta').change(function(){
 buscarPrecioRuta();
});


function buscarPrecioRuta(){
  var idRuta = $('#ruta').val();
  if (idRuta != '') {
    $.ajax({
      data: { idRuta: idRuta},
      url: '?ajax&controller=Catalogo&action=validarFechaVencimientoPrecio',
      type: 'POST',
      dataType: 'json',
      success: function (r) {
        var today = new Date();
        var vencimiento = new Date(r[0].fecha_vencimiento);
        if(vencimiento > today){
          $('#ruta').val(idRuta);
          $('#costoFlete').val(htmlNum(parseFloat(r[0].precio).toFixed(2))).attr('disabled', true);
          r[0].moneda != 0 ? $('#moneda').val(r[0].moneda) : "";
        }else{
          $('#ruta').val('');
          $('#costoFlete').val('');
          mensajeError('Precio de la ruta vencido, vaya a catalogos o solicite que se actualice.');
        }
      },
      error: function () {
        alert('Algo salio mal, no se encontro ruta, contacte al administrador del sistema');
      }
    });
}else{
  $('#costoFlete').val('');
}
}
if($('#nombreProveedorFlete').val() != undefined){
  $('#ruta').removeAttr('disabled');
  $('#moneda').val(2); //Moneda en dolares
  buscarRuta();
}

$('#editMoneda').click(function(){
  $('#moneda').attr('disabled', false).removeClass('fixed');
});

$('#moneda').blur(function(){
  $(this).addClass('fixed').attr('disabled', true);
});

$('#editCliente').click(function(){
  $('#cliente').attr('disabled', false);
  $('#clienteEmbarque').attr('disabled', false);
});

$('#clienteEmbarque').change(function(){
  var idCliente = $(this).val();
  $(this).attr('disabled', true);
  buscarCliente(idCliente);
});

$('#cliente').change(function(){
  var idCliente = $(this).val();
  $(this).attr('disabled', true);
  buscarCliente(idCliente);
});

if($('#cliente').val() != "" && $('#cliente').val() != undefined){
 var idCliente = $('#cliente').val();
  buscarCliente(idCliente);
}

if($('#clienteEmbarque').val() != "" && $('#clienteEmbarque').val() != undefined){
  var idCliente = $('#clienteEmbarque').val();
   buscarCliente(idCliente);
 }

function buscarCliente(idCliente){
  if(idCliente != ""){
  $.ajax({
    data: { idCliente: idCliente},
    url: '?ajax&controller=Catalogo&action=getClienteById',
    type: 'POST',
    dataType: 'json',
    success: function (r) {
      $('#clienteDireccion').val(r[0].direccion +', '+ r[0].ciudad_completa);
      $('#datosCliente').removeAttr('hidden')
    },
    error: function () {
      alert('Algo salio mal, no se encontro cliente, contacte al administrador del sistema');
    }
  });
}else{
  $('#datosCliente').prop('hidden', true)
}
}
$('#embarqueForm').keypress(function (e) { 
  if(e.keyCode == 13) {
    e.preventDefault();
  }
});


$('#btnGuardar').click(function(e){
  e.preventDefault();
  guardarEmbarque();
});

function guardarEmbarque(){
  var valid = validarDatos();
  if(valid){
    $('input, select').attr('disabled', false);
    $('#embarqueForm').submit();
    (window.opener).location.reload();
  }else{
    mensajeError("Verifique los datos");
  }
}


function validarDatos(){
  var valid = true;
  if($('#tipoFlete').val() == 2){
  if($('#proveedorFlete').val() == null || $('#proveedorFlete').val() == ""){
    valid = false;
    $('#proveedorFlete').addClass('required');
  }
  if($('#aduana').val() == null || $('#aduana').val() == ""){
      valid = false;
      $('#aduana').addClass('required');
  }
  if($('#transporte').val() == null || $('#transporte').val() == ""){
    valid = false;
    $('#transporte').addClass('required');
  }
  if($('#ruta').val() == null || $('#ruta').val() == "" ){
    valid = false;
    $('#ruta').addClass('required');
  }
}
  if( $('#fechaPedimento').val() != ""){
    if($('#numeroPedimento').val() == '' || $('#numeroPedimento').val() == null ){
    $('#numeroPedimento').addClass('required');
    valid = false;
    }
    if($('#referenciaPedimento').val() == '' || $('#referenciaPedimento').val() == null ){
      $('#referenciaPedimento').addClass('required');
      valid = false;
      }
  }
  return valid;
}

$('input').on('click', function () {
  $(this).removeClass('required');
});

$('select').on('click', function () {
  $(this).removeClass('required');
});

$.datepicker.regional['es'] = {
  closeText: 'Cerrar',
  prevText: '< Ant',
  nextText: 'Sig >',
  currentText: 'Hoy',
  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
  monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
  dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
  dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
  weekHeader: 'Sm',
  dateFormat: 'dd/mm/yy',
  firstDay: 1,
  isRTL: false,
  maxDate: 0,
  showMonthAfterYear: false,
  yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);

//Validar input archivos
$('#documento').change(function (){
  agregarDocumento($(this) , 1);
});

$('#documentoCertificado').change(function (){
  agregarDocumento($(this) , 2);
});

$('#documentoPedimento').change(function () {
  var ref = $('#referenciaPedimento');
  if($(ref).val() != ""){
  agregarDocumento($(this), 3);
  }else{
    $(ref).addClass('required')
    $(this).val("").next('span').html("");
    mensajeError("Debe de agregar número de referencia.")
  }
});

$('#documentoFacturaFlete').change(function (){
  agregarDocumento($(this) , 4);
});

$('#documentoRemision').change(function (){
   agregarRemision($(this));
});

  function agregarDocumento(inputFile, ref){
  switch(ref){
    case 1:
      var deleteDoc = $('#delete');
      var inputId = $('#numeroFactura');
      var divDocumento = $('#divDocumentoFactura');
      break;
    case 2:
        var deleteDoc = $('#deleteCertificado');
        var inputId = $('#numeroFactura');
        var divDocumento = $('#divDocumentoCert');
      break;
    case 3:
      var deleteDoc = $('#deletePedimento');
      var inputId = $('#numeroPedimento');
      var divDocumento = $('#divDocumentoPedimento');
      break;
    case 4:
      var deleteDoc = $('#deleteFacturaFlete');
      var inputId = $('#numeroFacturaFlete');
      var divDocumento = $('#divDocumentoFacturaFlete');
      break;
  }
  var spanDocumento = $(divDocumento).find('#spanDocumento');
  var idDoc = $(inputId).val();
 if(idDoc != ""){
  $(spanDocumento).html(idDoc +'.pdf');
  var tipoArchivo = $(inputFile).prop('files')[0].name;
  if (tipoArchivo.toLowerCase().includes('.pdf')) {
    $.confirm({
      title: "<span class='material-icons i-correcto'>check_circle_outline</span><span>¡Correcto!<span>",
      content: 'Archivo agregado',
      type: 'green',
      typeAnimated: true,
      draggable: true,
      buttons: {
        tryAgain: {
          text: 'Ok',
          btnClass: 'btn-success',
          action: function () {
            $(deleteDoc).removeAttr('hidden').show(500);
            $(inputFile).prev('label').hide(1000)
          }
        }
      }
    });
  } else {
    $.confirm({
      title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
      content: 'Formato invalido de Documento <br/>Archivo: <strong>' + tipoArchivo + '</strong> <br/> Formatos aceptados: <strong>.pdf. </strong>',
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
            inputFile.val("");
            $(spanDocumento).html("");
          }
        }
      }
    });
  }
}else{
    $(inputId).addClass('required');
    $(spanDocumento).html("");
    $(inputFile).val("");
    mensajeError("Debe de agregar número.");
  }
}

if($('#pedimento').val() != ""){
  $('#divDocumentoPedimento').find('label').hide();
  $('#deletePedimento').removeAttr('hidden');
  $('#showPedimento').removeAttr('hidden');
}

if($('#factura').val() != ""){
  $('#divDocumentoFactura').find('label').hide();
  $('#delete').removeAttr('hidden');
  $('#showFactura').removeAttr('hidden');
}

if($('#certificado').val() != ""){
  $('#divDocumentoCert').find('label').hide();
  $('#deleteCertificado').removeAttr('hidden');
  $('#showCertificado').removeAttr('hidden');
}

if($('#facturaFlete').val() != ""){
  $('#divDocumentoFacturaFlete').find('label').hide();
  $('#deleteFacturaFlete').removeAttr('hidden');
  $('#showFacturaFlete').removeAttr('hidden');
}

if($('#xml').val() != ""){
  $('#divDocumentoXml').find('label').hide();
  $('#deleteXml').removeAttr('hidden');
  $('#showXml').removeAttr('hidden');
}

if($('#remision').val() != ""){
  $('#divDocumentoRemision').find('label').hide();
  $('#deleteRemision').removeAttr('hidden');
  $('#showRemision').removeAttr('hidden');
}

//borrar factura
$('#deleteRemision').click(function () {
  if ($('#id').val() != "") {
    var divDocumento = $('#divDocumentoRemision');
    var span = $(divDocumento).find('#spanDocumento');
    var label = $(divDocumento).find('label');
    var id = $('#id').val();
    var documento = $('#remision').val();  
    $.confirm({
      title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
      content: 'Se eliminara remisión: <strong>' + $(span).html() + '</strong>',
      type: 'orange',
      typeAnimated: true,
      animation: 'zoom',
      closeAnimation: 'right',
      backgroundDismiss: false,
      backgroundDismissAnimation: 'shake',
      buttons: {
        tryAgain: {
          text: 'Entendido',
          btnClass: 'btn btn-warning',
          action: function () {
            $.ajax({
              data: {idRecepcion: id, documento: documento},
              url: '?ajax&controller=Compras&action=eliminarDocumentoRemision',
              type: 'POST',
              success: function (r) {
                $('#documentoRemision').val("");
                $(span).html("");
                $('#deleteRemision').hide(500);
                $('#showRemision').hide(500);
                $(label).show(800);
              },
              error: function () {
                alert('Algo salio mal, no se pudo borrar remisión, contacte al administrador del sistema');
              }
            });
          }
        },
        Cancelar: function () {
        }
      }
    });
  } else {
    $('#documentoRemision').val("");
    $(span).html("");
    $(this).hide(500);
  }
});

//borrar documento pedimento
$('#deletePedimento').click(function () {
  if ($('#idPedimento').val() != "") {
    var divDocumento = $('#divDocumentoPedimento');
    var span = $(divDocumento).find('#spanDocumento');
    var label = $(divDocumento).find('label');
    var pedimento = $('#idPedimento').val();
    var documento = $('#pedimento').val();  
    $.confirm({
      title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
      content: 'Se eliminara pedimento: <strong>' + $(span).html() + '</strong>',
      type: 'orange',
      typeAnimated: true,
      animation: 'zoom',
      closeAnimation: 'right',
      backgroundDismiss: false,
      backgroundDismissAnimation: 'shake',
      buttons: {
        tryAgain: {
          text: 'Entendido',
          btnClass: 'btn btn-warning',
          action: function () {
            $.ajax({
              data: {idPed: pedimento, documento: documento},
              url: '?ajax&controller=Compras&action=eliminarDocumentoPedimento',
              type: 'POST',
              success: function (r) {
                $('#documentoPedimento').val("");
                $(span).html("");
                $('#deletePedimento').hide(500);
                $('#showPedimento').hide(500);
                $(label).show(800);
              },
              error: function () {
                alert('Algo salio mal, no se pudo borrar pedimento, contacte al administrador del sistema');
              }
            });
          }
        },
        Cancelar: function () {
        }
      }
    });
  } else {
    $('#documentoPedimento').val("");
    $(span).html("");
    $(this).hide(500);
  }
});

//borrar documento pedimento
$('#deleteXml').click(function () {
  if ($('#id').val() != "") {
    var divDocumento = $('#divDocumentoXml');
    var span = $(divDocumento).find('#spanDocumento');
    var label = $(divDocumento).find('label');
    var id = $('#id').val();
    var documento = $('#xml').val();  
    $.confirm({
      title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
      content: 'Se eliminara XML: <strong>' + $(span).html() + '</strong>',
      type: 'orange',
      typeAnimated: true,
      animation: 'zoom',
      closeAnimation: 'right',
      backgroundDismiss: false,
      backgroundDismissAnimation: 'shake',
      buttons: {
        tryAgain: {
          text: 'Entendido',
          btnClass: 'btn btn-warning',
          action: function () {
            $.ajax({
              data: {idRecepcion: id, documento: documento},
              url: '?ajax&controller=Compras&action=eliminarDocumentoXml',
              type: 'POST',
              success: function (r) {
                $('#documentoXml').val("");
                $(span).html("");
                $('#deleteXml').hide(500);
                $('#showXml').hide(500);
                $(label).show(800);
              },
              error: function () {
                alert('Algo salio mal, no se pudo borrar XML, contacte al administrador del sistema');
              }
            });
          }
        },
        Cancelar: function () {
        }
      }
    });
  } else {
    $('#documentoXml').val("");
    $(span).html("");
    $(this).hide(500);
  }
});

//borrar factura
$('#delete').click(function () {
  if ($('#idEmbarque').val() != "") {
    var divDocumento = $('#divDocumentoFactura');
    var span = $(divDocumento).find('#spanDocumento');
    var label = $(divDocumento).find('label');
    var pedimento = $('#idEmbarque').val();
    var documento = $('#factura').val();  
    $.confirm({
      title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
      content: 'Se eliminara factura: <strong>' + $(span).html() + '</strong>',
      type: 'orange',
      typeAnimated: true,
      animation: 'zoom',
      closeAnimation: 'right',
      backgroundDismiss: false,
      backgroundDismissAnimation: 'shake',
      buttons: {
        tryAgain: {
          text: 'Entendido',
          btnClass: 'btn btn-warning',
          action: function () {
            $.ajax({
              data: {idEmbarque: pedimento, documento: documento},
              url: '?ajax&controller=Compras&action=eliminarDocumentoFactura',
              type: 'POST',
              success: function (r) {
                $('#documentoFactura').val("");
                $(span).html("");
                $('#delete').hide(500);
                $('#showFactura').hide(500);
                $(label).show(800);
              },
              error: function () {
                alert('Algo salio mal, no se pudo borrar factura, contacte al administrador del sistema');
              }
            });
          }
        },
        Cancelar: function () {
        }
      }
    });
  } else {
    $('#documentoFactura').val("");
    $(span).html("");
    $(this).hide(500);
  }
});

//borrar certificado
$('#deleteCertificado').click(function () {
  if ($('#idEmbarque').val() != "") {
    var divDocumento = $('#divDocumentoCert');
    var span = $(divDocumento).find('#spanDocumento');
    var label = $(divDocumento).find('label');
    var pedimento = $('#idEmbarque').val();
    var documento = $('#certificado').val();  
    $.confirm({
      title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
      content: 'Se eliminara certificado: <strong>' + $(span).html() + '</strong>',
      type: 'orange',
      typeAnimated: true,
      animation: 'zoom',
      closeAnimation: 'right',
      backgroundDismiss: false,
      backgroundDismissAnimation: 'shake',
      buttons: {
        tryAgain: {
          text: 'Entendido',
          btnClass: 'btn btn-warning',
          action: function () {
            $.ajax({
              data: {idEmbarque: pedimento, documento: documento},
              url: '?ajax&controller=Compras&action=eliminarDocumentoCertificado',
              type: 'POST',
              success: function (r) {
                $('#documentoCertificado').val("");
                $(span).html("");
                $('#deleteCertificado').hide(500);
                $('#showCertificado').hide(500);
                $(label).show(800);
              },
              error: function () {
                alert('Algo salio mal, no se pudo borrar certificado, contacte al administrador del sistema');
              }
            });
          }
        },
        Cancelar: function () {
        }
      }
    });
  } else {
    $('#documentoCertificado').val("");
    $(span).html("");
    $(this).hide(500);
  }
});

//borrar factura
$('#deleteFacturaFlete').click(function () {
  if ($('#id').val() != "") {
    var divDocumento = $('#divDocumentoFacturaFlete');
    var span = $(divDocumento).find('#spanDocumento');
    var label = $(divDocumento).find('label');
    var id = $('#id').val();
    var documento = $('#facturaFlete').val();  
    $.confirm({
      title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
      content: 'Se eliminara factura: <strong>' + $(span).html() + '</strong>',
      type: 'orange',
      typeAnimated: true,
      animation: 'zoom',
      closeAnimation: 'right',
      backgroundDismiss: false,
      backgroundDismissAnimation: 'shake',
      buttons: {
        tryAgain: {
          text: 'Entendido',
          btnClass: 'btn btn-warning',
          action: function () {
            $.ajax({
              data: {idRecepcion: id, documento: documento},
              url: '?ajax&controller=Compras&action=eliminarDocumentoFacturaFlete',
              type: 'POST',
              success: function (r) {
                $('#documentoFacturaFlete').val("");
                $(span).html("");
                $('#deleteFacturaFlete').hide(500);
                $('#showFacturaFlete').hide(500);
                $(label).show(800);
              },
              error: function () {
                alert('Algo salio mal, no se pudo borrar factura, contacte al administrador del sistema');
              }
            });
          }
        },
        Cancelar: function () {
        }
      }
    });
  } else {
    $('#documentoFacturaFlete').val("");
    $(span).html("");
    $(this).hide(500);
  }
});

 //funcion mostrar factura
 $('#showFactura').click(function () {
  var factura = $('#factura').val();
  $('#tituloDocumento').html('Factura: ' + factura);
  var url = 'views/compras/uploads/facturas/' + factura;
  $('#viewDoc').append('<object class="view-doc" id="objDoc" data=""></object>');
  $('#objDoc').attr('data', url);
  $('#modalDocumento').modal('show');
});

 //funcion mostrar pedimento
 $('#showPedimento').click(function () {
  var pedimento = $('#pedimento').val();
  $('#tituloDocumento').html('Pedimento: ' + pedimento);
  var url = 'views/compras/uploads/pedimentos/' + pedimento;
  $('#viewDoc').append('<object class="view-doc" id="objDoc" data=""></object>');
  $('#objDoc').attr('data', url);
  $('#modalDocumento').modal('show');
});

//funcion mostrar pedimento
$('#showCertificado').click(function () {
  var certificado = $('#certificado').val();
  $('#tituloDocumento').html('Certificado: ' + certificado);
  var url = 'views/compras/uploads/certificados/' + certificado;
  $('#viewDoc').append('<object class="view-doc" id="objDoc" data=""></object>');
  $('#objDoc').attr('data', url);
  $('#modalDocumento').modal('show');
});

//funcion mostrar factura flete
$('#showFacturaFlete').click(function () {
  var facturaFlete = $('#facturaFlete').val();
  $('#tituloDocumento').html('Factura flete: ' + facturaFlete);
  var url = 'views/compras/uploads/facturas/' + facturaFlete;
  $('#viewDoc').append('<object class="view-doc" id="objDoc" data=""></object>');
  $('#objDoc').attr('data', url);
  $('#modalDocumento').modal('show');
});

//funcion mostrar xml flete
$('#showXml').click(function () {
  var factura =  $('#xml').val();
  var url = './views/compras/uploads/xml/' + factura;
  window.open(url, factura, "width=1300,height=600")
});

//funcion mostrar remision flete
$('#showRemision').click(function () {
  var remision = $('#remision').val();
  $('#tituloDocumento').html('Remisión flete: ' + remision);
  var url = 'views/compras/uploads/remisiones/' + remision;
  $('#viewDoc').append('<object class="view-doc" id="objDoc" data=""></object>');
  $('#objDoc').attr('data', url);
  $('#modalDocumento').modal('show');
});

$('#modalDocumento').on('hidden.bs.modal', function () {
  $('#objDoc').remove();
});

function getFormatDate(fechaStr){
  var array = fechaStr.split('/');
  var fecha = (array[2]+'-'+ array[1]+'-'+ array[0]);
  return new Date(fecha);
}

function formatDateToString(date){
  return date.getFullYear()+'-'+(date.getMonth() + 1) +'-'+ date.getDate();
}

function isNumeric(value) {
  const regex = /,/g;
  var num = value.replace(regex, "");
  var valid = !isNaN(Number(num));
  return valid;
}

function htmlNum(num){
  return Number(num).toLocaleString('en');
}

function quitarComasNumero(value) {
  const regex = /,/g;
  if(value != ''){
  var num = value.replace(regex, "");
  return parseFloat(num);
  }
  else{
    return 0;
  }
}

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

function mensajeCorrecto(mnsj, reload = true){
  $.confirm({
    title: "<span class='material-icons i-correcto'>check_circle_outline</span><span>¡Correcto!<span>",
    content: mnsj,
    type: 'green',
    typeAnimated: true,
    draggable: true,
    buttons: {
      tryAgain: {
        text: 'Ok',
        btnClass: 'btn-success',
        action: function () {
          if(reload){
          if(window.opener != null){
          (window.opener).location.reload();
          }
         location.reload();
        }
        }
      }
    }
  });
}


$('#btnSalir').click(function(e){
  e.preventDefault();
  window.close();
});

$('#btnGenerarToken').click(function(e){
  e.preventDefault();
  $('#modalToken').modal('show')
 window.open("https://www.banxico.org.mx/SieAPIRest/service/v1/token", "Generar token BANXICO", "width=1300,height=600");
});

//guardar token Banxico
$('#actualizarToken').click(function (e) {
  e.preventDefault();
  var numToken = $('#token').val();
  if (numToken != "") {
      $.ajax({
              data: {token: numToken},
              url: '?ajax&controller=Token&action=guardarTokenBanxico',
              type: 'POST',
              success: function (r) {
                if(r){
                  mensajeCorrecto("Se actualizo token correctamente.");
                }else{
                mensajeError('Algo salio mal, no se pudo actualizar Token.');
                }
              },
              error: function () {
                alert('Algo salio mal, no se pudo actualizar Token, contacte al administrador del sistema');
              }
            });
          } else {
     mensajeError('Token no puede estar vacio')
  }
});

$('#mostrarToken').click(function(e){
e.preventDefault();
 var token = getToken();
$('#token').val(token);
$('#borrarToken').removeAttr('hidden')
});

function getToken(){
  var token;
$.ajax({
    async: false,
    url: '?ajax&controller=Token&action=getTokenBanxico',
    type: 'POST',
    dataType:'TEXT',
    success: function (data) {
     token = data;
    },
    error: function () {
      alert('Algo salio mal, no se pudo borrar pedimento, contacte al administrador del sistema');
    }
  });
  return token;
}

$('#borrarToken').click(function(e){
  e.preventDefault();
  $(this).attr('hidden', true);
  $('#token').val('');
  });

  $('#carroTanque').blur(function(){
    if($(this).val() != ""){
    var carro = $(this).val().trim();
    $.ajax({
      data:{carroTanque : carro},
      url: '?ajax&controller=Catalogo&action=buscarNumeroCarroTanque',
      type: 'POST',
      dataType: 'json',
      success: function (r) {
        if(r.length == 0){
        guardarCarroTanque(carro);
        }
        if(r.length == 1){
        if(r[0].estatus_id == 8){   //Estado 8 en transito
          $('#carroTanque').val("");
          $('#carroTanqueId').val("");
         mensajeError("Carro tanque esta en transito");
        }else{
          $('#carroTanqueId').val(r[0].id);
        }
      }
        if(r.length > 1){
          $('#carroTanque').val("");
          $('#carroTanqueId').val("");
         mensajeError("Carro tanque "+ carro +" esta duplicado");
        }
      },
      error: function () {
        alert('Algo salio mal, contacte al administrador del sistema');
      }
    });
    }
  });

  var carroTanques = new Array();
  $('#carroTanque').on('keypress', function(){
    if(carroTanques.length === 0){
    var carros = getCarroTanques();
    carroTanques = carros;
    }
    $(this).autocomplete({
      source: carroTanques
    });
  });



function getCarroTanques(){
  var carros = new Array();
  $.ajax({
    url: '?ajax&controller=Catalogo&action=getCarroTanquesDisponibles',
    type: 'POST',
    dataType: 'json',
    success: function (r) {
      $(r).each(function (i, v) { // indice, valor
       carros.push(v.numero);
      })
    },
    error: function () {
      alert('Algo salio mal, contacte al administrador del sistema');
    }
  });
  return carros;
}

function guardarCarroTanque(carro){
  $.confirm({
    title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
    content: '<br>Carro tanque <strong> '+carro+'</strong> no existe ¿Agregar al catálogo?',
    type: 'orange',
    typeAnimated: true,
    animation: 'zoom',
    closeAnimation: 'right',
    backgroundDismiss: false,
    backgroundDismissAnimation: 'shake',
    buttons: {
      tryAgain: {
        text: 'Entendido',
        btnClass: 'btn btn-warning',
        action: function () {
          $.ajax({
            data:{numero : carro, estatus:6, return:true},
            url: '?ajax&controller=Catalogo&action=saveCarroTanque',
            type: 'POST',
            dataType: 'json',
            success: function (r) {
               mensajeCorrecto('Se agrego carro tanque.', false)
               $('#carroTanqueId').val(r);
            },
            error: function (r) {
              alert('Algo salio mal, no se pudo agregar carro tanque, contacte al administrador del sistema');
            }
          });
        }
      },
      Cancelar: function () {
        $('#carroTanque').val("");
        $('#carroTanqueId').val("");
      }
    }
  });
}

$('#btnEliminar').click(function(e){
  e.preventDefault();
  var folioReq = $('#folioReqFlete').val() != "" || $('#folioReqFlete').val() != undefined ?  $('#folioReqFlete').val() : false;
  var orden = $('#ordenFlete').val() != "" || $('#ordenFlete').val() != undefined ?  $('#ordenFlete').val() : false;
  var mnsj = "";
   if(orden && folioReq){
    mnsj = ' <br><br><strong>Aviso:</strong> Se cancelaran también la Req. <strong>'+folioReq+'</strong> y la orden <strong>' + orden + '</strong> del flete asociado.';
   }else if(folioReq){
    mnsj =  '<br><br><strong>Aviso:</strong> Se cancelara también la Req. <strong>'+folioReq+'</strong> del flete asociado.';
   }
   var idEmbarque = $("#idEmbarque").val();
   if(idEmbarque != ""){
  $.confirm({
    title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
    content: '<strong>¿Quieres cancelar el embarque?</strong>' + mnsj,
    type: 'orange',
    typeAnimated: true,
    animation: 'zoom',
    closeAnimation: 'right',
    backgroundDismiss: false,
    backgroundDismissAnimation: 'shake',
    buttons: {
      tryAgain: {
        text: 'SI',
        btnClass: 'btn btn-warning',
        action: function () {
          $.ajax({
            data:{id : idEmbarque},
            url: '?ajax&controller=Compras&action=cancelarEmbarque',
            type: 'POST',
            dataType: 'json',
            success: function (r) {
               mensajeCorrecto('Se cancelo embarque', true);
             
            },
            error: function (r) {
              mensajeError('Algo salio mal, no se pudo cancelar embarque, contacte al administrador del sistema');
            }
          });
        }
      },
      NO: function () {
      }
    }
  });
}
});


$('#evaluacionProveedor').on('change', 'input[type=radio]', function(){
evaluarProveedor();
});

if($('input:radio[name=pregunta1]:checked').val() != undefined){
  evaluarProveedor();
}

function evaluarProveedor(){
  var val1 = $('input:radio[name=pregunta1]:checked').val() == undefined ? 0 : Number($('input:radio[name=pregunta1]:checked').val());
  var val2 = $('input:radio[name=pregunta2]:checked').val()  == undefined ? 0 : Number($('input:radio[name=pregunta2]:checked').val());
  var val3 = $('input:radio[name=pregunta3]:checked').val() == undefined ? 0 : Number($('input:radio[name=pregunta3]:checked').val());
  var val4 = $('input:radio[name=pregunta4]:checked').val() == undefined ? 0 : Number($('input:radio[name=pregunta4]:checked').val());
  var promedio = (val1 + val2 + val3 + val4) /4 ;
  var calificacion = promedio * 20;
  $('#promedio').val(promedio);
  $('#calificacion').val(calificacion);
}
  
  function mensajesValidacion(mensaje) {
    $.confirm({
      title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>!",
      content: mensaje,
      type: 'orange',
      typeAnimated: true,
      animation: 'zoom',
      closeAnimation: 'right',
      backgroundDismiss: false,
      backgroundDismissAnimation: 'shake',
      buttons: {
        tryAgain: {
          text: 'Entendido',
          btnClass: 'btn btn-warning',
          action: function () {
          }
        }
      }
    });
  }

  //recepcion de Fletes
  $('#btnGurdarRecepcionFlete').click(function(){
    var valid = true;
    if($('#numeroFacturaFlete').val()== ""){
      valid = false;
      $('#numeroFacturaFlete').addClass("required");
    }
    if($('#fechaFactura').val()== ""){
      $('#fechaFactura').addClass("required");
      valid = false;
    }

     if(valid && validarPreguntasFlete()){
      var datosForm = new FormData($('#recepcionFleteForm')[0]);
        $.ajax({
          data: datosForm,
          enctype: 'multipart/form-data',
          processData: false,
          contentType: false,
          url: '?ajax&controller=Compras&action=recepcionFletes',
          type: 'POST',
          dataType: 'json',
          success: function (r) {
            console.log(r.responseText)
           mensajeCorrecto('Guardado correctamente');
          },
          error: function (r) {
          console.log(r.responseText)
          mensajeError('Algo salio mal, no se pudo guardar la recepción, contacte al administrador del sistema');
          }
        }); 
     }
  });

  function validarPreguntasFlete() {
    var valid = true;
    var pregunta1 = $('input:radio[name=pregunta1]:checked').val();
    var pregunta2 = $('input:radio[name=pregunta2]:checked').val();
    var pregunta3 = $('input:radio[name=pregunta3]:checked').val();
    var pregunta4 = $('input:radio[name=pregunta4]:checked').val();
    if (pregunta1 == undefined) {
      $('#preg1').addClass('required');
      valid = false;
    }
    if (pregunta2 == undefined) {
      $('#preg2').addClass('required');
      valid = false;
    }
    if (pregunta3 == undefined) {
      $('#preg3').addClass('required');
      valid = false;
    }
    if (pregunta4 == undefined) {
      $('#preg4').addClass('required');
      valid = false;
    }
    if (!valid) {
      mensajeError('Complete la evaluación.');
    }
    return valid;
  };

$('#evaluacionProveedor').click(function(){
 $(this).find('strong').removeClass('required');
});

$('#documentoXml').change(function (){
  agregarDocumentoXml($(this));
});

function agregarDocumentoXml(inputFile){
  var deleteDoc = $('#deleteXml');
  var inputId = $('#numeroFacturaFlete');
  var divDocumento = $('#divDocumentoXml');
  var spanDocumento = $(divDocumento).find('#spanDocumento');
  var idDoc = $(inputId).val();
 if(idDoc != ""){
  $(spanDocumento).html(idDoc +'.xml');
  var tipoArchivo = $(inputFile).prop('files')[0].name;
  if (tipoArchivo.toLowerCase().includes('.xml')) {
    $.confirm({
      title: "<span class='material-icons i-correcto'>check_circle_outline</span><span>¡Correcto!<span>",
      content: 'Archivo agregado',
      type: 'green',
      typeAnimated: true,
      draggable: true,
      buttons: {
        tryAgain: {
          text: 'Ok',
          btnClass: 'btn-success',
          action: function () {
            $(deleteDoc).removeAttr('hidden').show(500);
            $(inputFile).prev('label').hide(1000)
          }
        }
      }
    });
  } else {
    $.confirm({
      title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
      content: 'Formato invalido de Documento <br/>Archivo: <strong>' + tipoArchivo + '</strong> <br/> Formatos aceptados: <strong>.xml. </strong>',
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
            inputFile.val("");
            $(spanDocumento).html("");
          }
        }
      }
    });
  }
}else{
    $(inputId).addClass('required');
    $(spanDocumento).html("");
    $(inputFile).val("");
    mensajeError("Debe de agregar número.");
  }
}

function agregarRemision(inputFile){
  var deleteDoc = $('#deleteRemision');
  var divDocumento = $('#divDocumentoRemision');
  var spanDocumento = $(divDocumento).find('#spanDocumento');
  var tipoArchivo = $(inputFile).prop('files')[0].name;
  $(spanDocumento).html(tipoArchivo);
  if (tipoArchivo.toLowerCase().includes('.pdf')) {
    $.confirm({
      title: "<span class='material-icons i-correcto'>check_circle_outline</span><span>¡Correcto!<span>",
      content: 'Archivo agregado',
      type: 'green',
      typeAnimated: true,
      draggable: true,
      buttons: {
        tryAgain: {
          text: 'Ok',
          btnClass: 'btn-success',
          action: function () {
            $(deleteDoc).removeAttr('hidden').show(500);
            $(inputFile).prev('label').hide(1000)
          }
        }
      }
    });
  } else {
    $.confirm({
      title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
      content: 'Formato invalido de Documento <br/>Archivo: <strong>' + tipoArchivo + '</strong> <br/> Formatos aceptados: <strong>.pdf. </strong>',
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
            inputFile.val("");
            $(spanDocumento).html("");
          }
        }
      }
    });
  }
}

$('#descCombustible').blur(function(){
  var desc = $(this).val().trim();
  if(isNumeric(desc)){
    var valor = quitarComasNumero(desc);
    $(this).val(htmlNum(valor));
  }else{
    $(this).addClass('required');
    mensajeError("Debe de ser número");
  }
});

$('#agregarFlete').change(function(){
  if($(this).prop('checked') == true){
    $('#folioReqFlete').hide().attr('disabled');
    var fletes = $('#selectFletes');
    $(fletes).removeAttr('hidden disabled');
    var idReqProd = $('#idReqProducto').val();
    if(idReqProd != ""){
      $.ajax({
        data: { idReq : idReqProd},
        url: '?ajax&controller=Compras&action=getFletesEmbarque',
        type: 'POST',
        dataType: 'json',
        success: function (r) {
          fletes.find('option').not(':first').remove();
          if(r.length != 0){
            console.log(r);
            $(r).each(function (i, v) { // indice, valor
              if(v.num < 2){
              fletes.append('<option value="' + v.idReqFlete + '">' + v.folioReq + '</option>');
              }
            });

          }else{
            fletes.append('<option value="" disabled>No hay fletes para esta orden</option>');
          }
        },
        error: function () {
          alert('Algo salio mal, contacte al administrador del sistema');
        }
      });
    }
  }else{
    $('#selectFletes').attr('hidden', true).prop('disabled', true);
    $('#folioReqFlete').show().attr('disabled', false);
  }
});

$('#selectFletes').change(function(){
  if($(this).val() != ''){
   var requisicionFlete = $(this).val();
    $('#idReqFlete').val(requisicionFlete);
      $.ajax({
        data: { idReq : requisicionFlete},
        url: '?ajax&controller=Compras&action=getRequisicionById',
        type: 'POST',
        dataType: 'json',
        success: function (r) {
          $('#proveedorFlete').val(r.proveedor_id).attr('disabled', true);
          $("#transporte").val(r.transporte_id);
          $("#ruta").val(r.ruta_id);
          buscarPrecioRuta();           
        },
        error: function () {
          alert('Algo salio mal, contacte al administrador del sistema');
        }
      });
    }
});
});
