<script>
let clientes;
let proveedores;
let legends_reqs = [];
let series_reqs = [];
let list_estatus = [];
let legends_reqs1 = [];
let list_reqs;
let legends_reqs_colors = {};
let detalle_series = {};
let detalle_series_p = [];
let series_estatus = [];
let series_estatus_p = [];
let data_colores = [];
let latabla;
var dateFormat = "yy/mm/dd";
var hoy = new moment().format('YYYY/MM/DD');
var ayer = moment().subtract(1, 'months').format('YYYY/MM/01');
var table;
var clickiframe;
var aceptadaslist = [];
var selestatus, selsolicitud;
// <th>ESTATUS</th>
let htmltable = `<table id="tablaRegistros" class='table stripe' style='width:100%'>
                                <thead>
                                    <th hidden>id</th>
                                    <th style="width:10%;">FOLIO</th>
                                    <th style="width:50%;">PROVEEDOR</th>                                    
                                    <th style="width:15%;">FECHA REQUERIDA</th>
                                    <th style="width:5%;">FIRMAS</th>
                                    <th style="width:5%;">ACCIONES</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>`;

$(document).ready(function() {
    $("#cmbClientes, #cmbProveedores").find("option").remove();

    var from = $("#fechaReporteF").datepicker({
        changeMonth: true,
        dateFormat: "yy/mm/dd",
    }).on("change", function() {
        to.datepicker("option", "minDate", getDate(this));
        $("#cmbClientes, #cmbProveedores").find("option").remove();
        getRequisiciones();
        getProveedores();
    });
    $("#fechaReporteF").datepicker("setDate", ayer);

    var to = $("#fechaReporteT").datepicker({
        changeMonth: true,
        dateFormat: "yy/mm/dd",
    }).on("change", function() {
        from.datepicker("option", "maxDate", getDate(this));
        $("#cmbClientes, #cmbProveedores").find("option").remove();
        getRequisiciones();
        getProveedores();
    });
    to.datepicker("setDate", new Date());
    table = $("#tablaRegistros").DataTable({
        dom: 'Bfrtip',
        retrieve: true,
        responsive: true,
        scrollY: '300px',
        // scrollCollapse: true,
        // pagingType: 'full_numbers',
        // lengthMenu: [
        // [10, 25, 50, -1],
        // [10, 25, 50, 'All']
        // ],

        pagging: true,
        buttons: [
            'print',
            {
                extend: 'excel',
                // extend: 'excelHtml5',
                className: 'btn btnExcel buttons-excel',
                //${((cliente != "null") ? cliente : almacen)}
                title: `Reporte de Requisiciones  ${formatDate(new Date())}`
            },
            'pdf',
        ],
        language: {
            url: '<?php echo URL; ?>assets/libs/datatables/es-MX.json',
        },
    });
    table.on('mouseenter', 'td', function() {
        let colIdx = table.cell(this).index().column;

        table
            .cells()
            .nodes()
            .each((el) => el.classList.remove('highlight'));

        table
            .column(colIdx)
            .nodes()
            .each((el) => el.classList.add('highlight'));
    });
    getRequisiciones();

    // SE OBTIENEN LOS CLIENTES
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: __url__ + "?ajax&controller=Catalogo&action=getClientes",
        success: function(r) {
            var resp = r;
            console.log(resp);
            detalles = resp;
            clientes = resp.clientes;
            resp.clientes.forEach(cliente => {
                $("#cmbClientes").append('<option value="' + cliente['id'] + '">' + cliente['nombre'] + '</option>');
            });

        },
        error: function(xhr, status, error) {
            erpalert("error", "Algo salio mal, contacte al administrador....");
            console.log(xhr, status, error);

        },
    });

    $("#cmbClientes").select2({
        placeholder: 'Todos los clientes',
        width: 'resolve'
    });
    $("#cmbClientes, #cmbProveedores").change(function() {
        console.log("cambia combo");
        getRequisiciones();
    });

    getProveedores();
});

function getDate(element) {
    var date;
    try {
        date = $.datepicker.parseDate(dateFormat, element.value);
    } catch (error) {
        date = null;
    }
    return date;
}


function getProveedores() {
    // SE OBTIENEN LOS PROVEEDORES
    $("#cmbProveedores option").remove();
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: __url__ + "?ajax&controller=Catalogo&action=getProveedores",
        success: function(r) {
            var resp = r;
            console.log(resp);
            proveedores = resp.proveedores;
            resp.proveedores.forEach(proveedor => {
                if (ifGetProveedor(proveedor['id'])) {
                    $("#cmbProveedores").append('<option value="' + proveedor['id'] + '">' + proveedor['nombre'] + '</option>');
                }
            });

            $("#cmbProveedores").select2({
                placeholder: 'Todos los proveedores',
                width: 'resolve'
            });

        },
        error: function(xhr, status, error) {
            erpalert("error", "Algo salio mal, contacte al administrador....");
            console.log(xhr, status, error);

        },
    });
}

function getRequisiciones() {
    // SE OBTIENEN LAS REQUISICIONES
    showLoading_global();
    $("#tablaRegistros tbody").html("");
    list_reqs = [];
    list_estatus = [];
    detalle_series = {};
    detalle_series_p = [];
    legends_reqs = [];
    legends_reqs_colors = {};
    data_colores = [];
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: __url__ + "?ajax&controller=Compras&action=getRequisiciones",
        data: {
            // clientes: $("#cmbClientes").val().join(", "),
            proveedores: $("#cmbProveedores").val().join(", "),
            fechaini: $("#fechaReporteF").val(),
            fechafin: $("#fechaReporteT").val()
        },
        success: function(r) {
            var resp = r;
            console.log(resp);
            list_reqs = resp;
            series_estatus_p = [];
            for (var x = 0; x < list_reqs.requisiciones.length; x++) {
                if (legends_reqs.indexOf(list_reqs.requisiciones[x].estatus.toUpperCase()) < 0) {
                    legends_reqs.push(list_reqs.requisiciones[x].estatus.toUpperCase()); // + '{' + inventarios.inventarios[x].total + '}');
                    legends_reqs_colors[list_reqs.requisiciones[x].estatus.toUpperCase()] = [{
                        "estatus": list_reqs.requisiciones[x].estatus.toUpperCase(),
                        "color": list_reqs.requisiciones[x].color_estatus
                    }]; // + '{' + inventarios.inventarios[x].total + '}');
                }
                if (list_estatus.indexOf(list_reqs.requisiciones[x].solicitud.toUpperCase()) < 0) {
                    list_estatus.push(list_reqs.requisiciones[x].solicitud.toUpperCase()); // + '{' + inventarios.inventarios[x].total + '}');
                }
            }
            // LLENA SERIES
            for (c = 0; c < legends_reqs.length; c++) {
                //console.log(clientes[c]);
                if (detalle_series.hasOwnProperty(legends_reqs[c].toUpperCase()) <= 0) {
                    detalle_series[legends_reqs[c].toUpperCase()] = ({
                        name: legends_reqs[c].toUpperCase(),
                        type: 'bar',
                        stack: 'total',
                        label: {
                            show: true,
                        },
                        emphasis: {
                            focus: 'series'
                        },
                        data: [],



                    });
                    series_estatus_p.push(legends_reqs[c].toUpperCase());
                    detalle_series_p.push({
                        type: 'bar',
                        data: [],
                        // data: [1, 2, 3, 4, 3, 5, 1],
                        coordinateSystem: 'polar',
                        name: legends_reqs[c].toUpperCase(),
                        stack: 'a',
                        emphasis: {
                            focus: 'series'
                        },
                        color_estatus: legends_reqs_colors[legends_reqs[c]][0].color

                    });


                    let total = 0;
                    for (l = 0; l < list_estatus.length; l++) {
                        // console.log(productos[l]);
                        // legends_reqs.push(list_estatus[l]);
                        total = 0;
                        for (x = 0; x < list_reqs.requisiciones.length; x++) {
                            if ((legends_reqs[c].toUpperCase() == list_reqs.requisiciones[x].estatus.toUpperCase()) && list_reqs.requisiciones[x].solicitud.toUpperCase() == list_estatus[l]) {
                                total = total + 1;
                            }
                        }
                        detalle_series[legends_reqs[c].toUpperCase()].data.push(total);
                        detalle_series_p[c].data.push(total);
                    }
                    // let total = 0;
                    // legends_lotes1 = [];
                    // for (l = 0; l < lotes.length; l++) {
                    // //console.log(lotes[l]);
                    // legends_lotes1.push(lotes[l]);
                    // total = 0;
                    // for (x = 0; x < inventarios.inventarios.length; x++) {
                    // if ((clientes[c] == inventarios.inventarios[x].Nombre_Cliente) && inventarios.inventarios[x].Lote == lotes[l]) {
                    // total = total + parseFloat(inventarios.inventarios[x].disponible);
                    // }
                    // }
                    // detalle_lotes[clientes[c]].data.push(total);
                    // }
                }

            }

            series_estatus = [];
            series_estatus_p = [];
            $.each(detalle_series, function(idx, obj) {
                series_estatus.push(obj);
            });
            $.each(detalle_series_p, function(idx, obj) {
                console.log(obj);
                series_estatus_p.push(obj.name);
                data_colores.push(obj.color_estatus);
            });

            chart_requisiciones();
            getDetalleGrafica();
            swal.close();
        },
        error: function(xhr, status, error) {
            erpalert("error", "Algo salio mal, contacte al administrador....");
            console.log(xhr, status, error);
        },
    });
}

function getDetalleGrafica(estatus = "", solicitud = "") {
    console.log("estatus: ", estatus, " solicitud: ", solicitud);
    selestatus = estatus;
    selsolicitud = solicitud;
    let tabladetalle = [];
    let html = "";
    $("#tablaRegistros").remove();
    // $("#tablaRegistros").DataTable();
    $("#tituloestatus").html("");
    table.clear().draw();
    if (estatus == "" && solicitud == "") {
        for (x = 0; x < list_reqs.requisiciones.length; x++) {
            // <td >${list_reqs.requisiciones[x].estatus} - ${list_reqs.requisiciones[x].solicitud}</td>
            // <td hidden>${list_reqs.requisiciones[x].id}</td>
            //
            //<a href="<?= principalUrl ?>?controller=Compras&action=requisicion&id='+list_reqs.requisiciones[x].id+'">
            html += `
             <tr data-idreq="${list_reqs.requisiciones[x].id}">
                    <td hidden id="idTabla">${list_reqs.requisiciones[x].id}</td>
                    <td >
                        <div class="row" style="width:170px">
                            <div class="col">
                                <div id="tdEstatus" style="" 
                                class="${getClaseEstado(list_reqs.requisiciones[x].clave)} estatus-tabla" 
                                title="${list_reqs.requisiciones[x].descEstatus}">
                                    <span id="estatus">${list_reqs.requisiciones[x].clave}</span>
                                </div>
                            </div>
                            <div class="col">
                                <strong>${list_reqs.requisiciones[x].folio}</strong>
                            </div>
                        </div>
                    </td>
                    <td >${list_reqs.requisiciones[x].proveedor.substr(0, 20)}</td>
                    <td >${list_reqs.requisiciones[x].fecha_requerida == null ? '' : moment(list_reqs.requisiciones[x].fecha_requerida).format("DD/MM/YYYY")}</td>
                    <td >${showFirmas(list_reqs.requisiciones[x].firmas)}</td>
                    <td>
                        <div class="text-right">
                            ${(list_reqs.requisiciones[x].cotizacion) ? '<span hidden id="archivoCotizacion">'+list_reqs.requisiciones[x].cotizacion+'</span><span id="showCotizacion" class="i-clip material-icons">attach_file</span>' : ''}
                            ${((!(list_reqs.requisiciones[x].estatus_id == 4) || list_reqs.requisiciones[x].estatus_id == 5)) ? '<span id="" onclick="viewReq('+list_reqs.requisiciones[x].id+')" class="material-icons i-edit" title="Editar">edit</span></a>' : ''}
                            ${(!(list_reqs.requisiciones[x].estatus_id == 2 || list_reqs.requisiciones[x].estatus_id == 5)) ? '<span id="deleteReq" class="material-icons i-delete" title="Eliminar">delete_forever</span>' : ''}
                            <span id="showReq" class="i-document material-icons">description</span>
                        </div>
                    </td>
                    
             </tr>       `;
        }
    } else {
        for (x = 0; x < list_reqs.requisiciones.length; x++) {
            if ((solicitud == list_reqs.requisiciones[x].solicitud.toUpperCase()) && list_reqs.requisiciones[x].estatus.toUpperCase() == estatus) {
                // <td >${getCliente(list_reqs.requisiciones[x].cliente_id)}</td>
                // <td >${list_reqs.requisiciones[x].estatus} - ${list_reqs.requisiciones[x].solicitud}</td>

                html += `
                            <tr data-idreq="${list_reqs.requisiciones[x].id}">
                                    <td hidden id="idTabla">${list_reqs.requisiciones[x].id}</td>
                                    <td >
                                        <div class="row" style="width:170px">
                                            <div class="col">
                                                <div id="tdEstatus" style="" 
                                                class="${getClaseEstado(list_reqs.requisiciones[x].clave)} estatus-tabla" 
                                                title="${list_reqs.requisiciones[x].descEstatus}">
                                                    <span id="estatus">${list_reqs.requisiciones[x].clave}</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <strong>${list_reqs.requisiciones[x].folio}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td >${list_reqs.requisiciones[x].proveedor.substr(0, 20)}</td>
                                    <td >${list_reqs.requisiciones[x].fecha_requerida == null ? '' : moment(list_reqs.requisiciones[x].fecha_requerida).format("DD/MM/YYYY")}</td>
                                    <td >${showFirmas(list_reqs.requisiciones[x].firmas)}</td>
                                    <td>
                                        <div class="text-right">
                                            ${(list_reqs.requisiciones[x].cotizacion) ? '<span hidden id="archivoCotizacion">'+list_reqs.requisiciones[x].cotizacion+'</span><span id="showCotizacion" class="i-clip material-icons">attach_file</span>' : ''}
                                            ${((!(list_reqs.requisiciones[x].estatus_id == 4) || list_reqs.requisiciones[x].estatus_id == 5)) ? '<span id="" onclick="viewReq('+list_reqs.requisiciones[x].id+')" class="material-icons i-edit" title="Editar">edit</span></a>' : ''}
                                            ${(!(list_reqs.requisiciones[x].estatus_id == 2 || list_reqs.requisiciones[x].estatus_id == 5)) ? '<span id="deleteReq" class="material-icons i-delete" title="Eliminar">delete_forever</span>' : ''}
                                            <span id="showReq" class="i-document material-icons">description</span>
                                        </div>
                                    </td>
                                    
                            </tr>
                    `;
            }
            // }
        }
    }
    $("#tituloestatus").html(estatus + " - " + solicitud);
    $("#div_tabla").html(htmltable);
    $("#tablaRegistros tbody").html(html);
    let table_d = $("#tablaRegistros").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        columns: [null, {
                "width": "5%"
            },
            {
                "width": "15%"
            }, {
                "width": "55%"
            }, {
                "width": "20%"
            }, {
                "width": "5%"
            }
        ],
        buttons: [
            'print',
            {
                extend: 'excelHtml5',
                className: 'btn btnExcel buttons-excel',
                title: `Reporte de Requisiciones  ${formatDate(new Date())}`,
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            'pdf',

        ],
        language: {
            url: '<?php echo URL; ?>assets/libs/datatables/es-MX.json',
        },
    });
    aceptadas_list = [];
    var agregada = 0;
    table_d.on('click', 'tbody tr', function(e) {
        e.currentTarget.classList.toggle('selected');
        clickiframe = e.currentTarget;
        if (e.currentTarget.classList.toString().indexOf("selected") > 0) {
            if (jQuery.inArray(e.currentTarget.dataset["idreq"], aceptadas_list) != -1) {
                console.log("is in array");
            } else {
                aceptadas_list.push(e.currentTarget.dataset["idreq"]);
                if (estatus == "ACEPTADA" && agregada == 0) {
                    agregada = 1;
                    $(".dt-buttons").append(
                        `<button class="btn btn-secondary buttons-genoc" tabindex="0" aria-controls="tablaRegistros" type="button" onclick="crearOC('${estatus}', '${solicitud}')"><span>Generar OC</span></button>`
                    )
                }

            }
        } else {
            // aceptadas_list[jQuery.inArray(e.currentTarget.dataset["idreq"], aceptadas_list) - 1].remove();
            aceptadas_list.splice($.inArray(e.currentTarget.dataset["idreq"], aceptadas_list), 1);
        }

    });



    iniciaEventos();

}

const chart_requisiciones = () => {

    //import * as echarts from 'echarts';
    // $("#chart_requisiciones").attr("style", "min-height:" + (productos.length * 100) + "px");
    console.log($("#chart_requisiciones"));
    $("#chart_requisiciones").html("").attr("_echarts_instance_", "");
    var chartDom = document.getElementById('chart_requisiciones');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
        angleAxis: {
            type: 'category',
            data: list_estatus, //['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']

            textStyle: {
                overflow: 'break'
            },
            tooltips: {
                enabled: false
            },
            grid: {
                tooltip: {
                    show: true,
                    trigger: "axis"
                }
            }


        },

        radiusAxis: {},
        polar: {},
        series: detalle_series_p,
        color: data_colores,
        legend: {
            show: true,
            data: series_estatus_p, //['GENERADA', 'PROCESO', 'FINALIZADA']
            selected: {
                'FINALIZADA': false,
                'CANCELADA': false
            },
            // color: data_colores,
            textStyle: {
                overflow: 'break'
            }
        }

    };

    option && myChart.setOption(option);
    myChart.on('click', function(params) {
        // Print name in console
        console.log(params);
        /*obtiene detalles*/
        getDetalleGrafica(params.seriesName, params.name);
        goToByScroll("tablaRegistros");
    });
}


function showFirmas(firmas_json) {
    var str = '';
    // console.log(firmas);
    var firmas = JSON.parse(firmas_json);
    // if (is_array($firmasArray)) {
    $.each(firmas, function(i, item) {
        // console.log("item: ", item);
        if (item != 0) {
            str += '<i class="text-success fas fa-check pl-1"></i><div hidden>✓</div>';
        } else {
            str += '<i class="text-danger fas fa-times pl-1"></i><div hidden>X</div>';
        }
        // console.log(str);
    });
    // firmas.forEach(f => {
    // if (f != 0) {
    // str += '<i class="text-success fas fa-check pl-1"></i>';
    // } else {
    // str += '<i class="text-danger fas fa-times pl-1"></i>';
    // }
    // });

    // }
    return str;
}

function getCliente(cliente_id) {
    var nombrecliente = "";
    if (cliente_id != null) {
        for (var x = 0; x < clientes.length; x++) {
            console.log(clientes[x].id, "==", cliente_id);
            if (clientes[x].id == cliente_id) {
                nombrecliente = clientes[x].nombre;
                break;
            }
        }
    }
    console.log("nombrecliente: ", nombrecliente);
    return nombrecliente;
}

function ifGetProveedor(proveedor_id) {
    var resultado = false;
    var resultadobusqueda = list_reqs.requisiciones.find((item) => item.proveedor_id === proveedor_id);
    try {
        if (resultadobusqueda) {
            resultado = true;
        }
    } catch (error) {

    }
    return resultado;
}

function viewReq(_idReq = "0") {

    console.log("_idReq: ", _idReq);
    Swal.fire({
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,
        position: "top",
        width: "75vw",
        html: `<iframe id="iframe___url__icio" style="width:100%; height:80vh;" src="${__url__}?controller=Compras&action=requisicionpop&id=${_idReq}" frameborder="0"></iframe>`,
        didOpen: () => {
            console.log("open");
            $("iframe").on("load", function() {

                $(this)
                    .contents()
                    .on("mousedown, mouseup, click", function(e) {
                        clickiframe = e;
                        if (e.target.id == "btnGenerar") {
                            //// alert("aqui");
                            $("iframe").on("load", function() {
                                getRequisiciones();
                                setTimeout(() => {
                                    viewReq(_idReq);
                                }, 1000);
                            });




                        }
                    });
                $(".form-select").select2();
            });

        },
        didClose: () => {

        },
    });


}

function iniciaEventos() {
    //funcion mostrar requisicion
    $("#tablaRegistros").on("click", "#showReq", function() {
        console.log("AQUI");
        var tr = $(this).closest("tr");
        var id = tr.find("#idTabla").html();
        if (id != "") {
            // window.open(
            // __url__ + "?controller=Compras&action=showRequisicion&idReq=" + id,
            // "Requisición",
            // "width=1300,height=650"
            // );

            showRequisicion(id);
        }
    });

    //funcion mostrar requisicion
    $("#tablaRegistros").on("click", "#showReqOrden", function() {
        var tr = $(this).closest("tr");
        var id = tr.find("#idTablaReq").html();
        if (id != "") {
            // window.open(
            // __url__ + "?controller=Compras&action=showRequisicion&idReq=" + id,
            // "Requisición",
            // "width=1300,height=650"
            // );
            Swal.fire({
                showCloseButton: false,
                showCancelButton: false,
                showConfirmButton: false,
                position: "top",
                width: "75vw",
                html: `<iframe id="iframe___url__icio" style="width:100%; height:80vh;" 
                src="${__url__}?controller=Compras&action=showRequisicion&idReq=${id}" frameborder="0"></iframe>`,
                didOpen: () => {
                    $("iframe").on("load", function() {});

                },
                didClose: () => {
                    // $("#divEstados a")[0].click();
                },
            });
        }
    });

    //funcion eliminar requisición
    $("#tablaRegistros").on("click", "#deleteReq", function() {
        var tr = $(this).closest("tr");
        var id = tr.find("#idTabla").html();
        if (id != "") {
            $.confirm({
                title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
                content: "¿Seguro desea eliminar?",
                type: "red",
                typeAnimated: true,
                animation: "zoom",
                closeAnimation: "right",
                backgroundDismiss: false,
                backgroundDismissAnimation: "shake",
                buttons: {
                    tryAgain: {
                        text: "Eliminar",
                        btnClass: "btn-red",
                        action: function() {
                            $.ajax({
                                data: {
                                    idReq: id
                                },
                                url: __url__ + "?ajax&controller=Compras&action=deleteRequision",
                                type: "POST",
                                success: function(r) {
                                    tr.hide();
                                    tr.remove();
                                },
                                error: function() {
                                    // alert("Algo salio mal, no se logro eliminar");
                                    erpalert("error", "Algo salio mal, no se logro eliminar....");
                                },
                            });
                        },
                    },
                    Cancelar: function() {},
                },
            });
        }
    });

    //funcion mostrar cotizacion
    $("#tablaRegistros").on(
        "click",
        "#showCotizacion",
        function() {
            var cotizacion = $(this)
                .closest("tr")
                .find("#archivoCotizacion")
                .html();

            console.log("acá: ", cotizacion);
            $("#tituloCotizacion").html("Cotización: " + cotizacion);
            var url = "../../views/compras/uploads/cotizaciones/" + cotizacion;
            $("#viewCot").append(
                '<object class="view-cot" id="objCot" data=""></object>'
            );
            $("#objCot").attr("data", url);
            // $("#modalCotizacion").modal("show");
            Swal.fire({
                html: '<object style="width:100%" class="view-cot" id="objCot" data="' + url + '"></object>',
                width: "60vw"
            });
        }
    );

    $("#modalCotizacion").on("hidden.bs.modal", function() {
        $("#objCot").remove();
    });

    $("#tablaRegistros").on("click", "#showEmbarque, #showRecepcionFlete, #showServiciosNave", function() {
        $(this).toggleClass("rotar");
        var tr = $(this).closest("tr").next("tr");
        $(tr).attr("hidden", function(i, attr) {
            if (attr === "hidden") {
                $(tr).removeAttr("hidden").removeClass("transparent", 1500);
            } else {
                $(tr).addClass("transparent").attr("hidden", true);
            }
        });
    });


}

function showRequisicion(id) {
    Swal.fire({
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,
        position: "top",
        width: "75vw",
        html: `<iframe id="iframe___url__icio" style="width:100%; height:80vh;" 
                src="${__url__}?controller=Compras&action=showRequisicion&idReq=${id}" frameborder="0"></iframe>`,
        didOpen: () => {
            // $("iframe").on("load", function() {
            console.log("se abre");
            var _selestatus = selestatus;
            var _selsolicitud = selsolicitud;
            $("iframe").on("load", function() {
                $(this)
                    .contents()
                    .on("mousedown, mouseup, click", function(e) {
                        clickiframe = e;
                        if (e.target.id == "btnFirma") {
                            console.log("se firmó");

                            setTimeout(() => {
                                getRequisiciones();
                                console.log("selestatus: ", _selestatus, " selsolicitud: ", _selsolicitud);
                                setTimeout(() => {
                                    setTimeout(() => {
                                        getDetalleGrafica(_selestatus, _selsolicitud);
                                    }, 1000);
                                    showRequisicion(id);
                                    setTimeout(() => {
                                        $("iframe").contents().scrollTop(1000);
                                    }, 500);
                                }, 500);
                            }, 1000);

                        }
                    });
                $(".form-select").select2();
            });
            // });

        },
        didClose: () => {
            // $("#divEstados a")[0].click();
        },
    });
}

function crearOC(estatus = "", solicitud = "") {
    var error = 0;
    for (var x = 0; x <= aceptadas_list.length; x++) {
        try {

            console.log("idreq: ", aceptadas_list[x]);
            $.ajax({
                data: {
                    idReq: aceptadas_list[x]
                },
                url: __url__ + "?ajax&controller=Compras&action=generarOrdenCompra",
                type: "POST",
                success: function(r) {
                    console.log("se generó");
                    console.log(r);
                    // aceptadas_list[x].remove();
                    aceptadas_list.splice($.inArray(aceptadas_list[x], aceptadas_list), 1);
                    // tr.hide();
                    // tr.remove();
                },
                error: function() {
                    error = 1;
                    erpalert("error", "Algo salio mal, no se genero orden de compra....");
                },
            });

        } catch (error) {

        }

    }
    if (error == 0) {
        erpalert("", "Se generardon las ordenes de compra");
        getRequisiciones();
        setTimeout(() => {
            getDetalleGrafica(estatus, solicitud);
        }, 1000);

    } else {}

}
</script>