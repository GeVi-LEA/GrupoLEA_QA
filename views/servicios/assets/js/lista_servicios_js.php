<script src="<?php echo URL; ?>/assets/libs/daterangepicker/daterangepicker.js" type="text/javascript"></script>

<script>
if (typeof __url__ !== "undefined" && __url__) {
    // vriable is set and isnt falsish so it can be used;
} else {
    __url__ = localStorage.getItem("_URL_");
}

const serv = __url__;
let clientes = [];
let cat_servicios = [];
let clientes_id = [];
let cat_servicios_id = [];
let servicios;
let table;
let llenaclientes = 0;
var series_servicios = [];
var data_estatus = [];
var data_colores = [];
var series_estatus = [];
var detalle_lotes = {};


var data = {
    children: []
};
var data2 = [];

$(document).ready(function() {
    var d = new Date();
    var currMonth = d.getMonth();
    var currYear = d.getFullYear();
    var startDate = new Date(currYear, currMonth, "01");
    datahoyparse = moment().format("YYYY-MM-DD");
    datahoyparseend = moment().format("YYYY-MM-DD");
    iniciodelostiempos = moment("2000-01-01").format("YYYY-MM-DD");
    findelostiempos = moment().format("YYYY-MM-DD");
    $("#fechas-startend").attr("data-fstart", startDate);
    $("#fechas-startend").attr("data-fend", datahoyparseend);
    //    2021-12-01|2021-12-29
    ////console.log(moment(startDate).format("YYYY-MM-DD") + "|" + datahoyparse);
    $("#fechas-startend").val(moment(startDate).format("YYYY-MM-DD") + " - " + datahoyparse);


    $('.shawCalRanges').daterangepicker({
        startDate: startDate,
        endDate: datahoyparseend,
        ranges: {
            'Todo el periodo': [moment(iniciodelostiempos), moment(findelostiempos)],
            'Hoy': [moment(datahoyparse), moment(datahoyparseend)],
            'Ayer': [moment(datahoyparse).subtract(1, 'days'), moment(datahoyparseend).subtract(1, 'days')],
            'Ultimos 7 Días': [moment(datahoyparse).subtract(6, 'days'), moment(datahoyparseend)],
            'Ultimos 30 Días': [moment(datahoyparse).subtract(29, 'days'), moment(datahoyparseend)],
            'Este mes': [moment(datahoyparse).startOf('month'), moment(datahoyparseend).endOf('month')],
            'Mes Pasado': [moment(datahoyparse).subtract(1, 'month').startOf('month'), moment(
                datahoyparseend).subtract(1, 'month').endOf('month')]
        },
        timePicker: false,
        timePicker24Hour: false,
        timePickerSeconds: false,
        locale: {
            format: 'YYYY-MM-DD',
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "customRangeLabel": "Personalizado",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1
        },
        alwaysShowCalendars: true,
    }, function(start, end, label) {
        var start = start.format('YYYY-MM-DD');
        var end = end.format('YYYY-MM-DD');
        ////console.log(start + "|" + end);
        $("#fechas-startend").val(start + " - " + end);
        $("#cmbClientes").find("option").remove();
        $("#cmbTipoServicios").find("option").remove();
        buscaServicios();
        llenaclientes = 0;
    });
    $("#cmbClientes").find("option").remove();
    $("#cmbClientes").select2({
        placeholder: 'Todos los clientes',
        width: 'resolve'
    });

    $("#cmbTipoServicios").find("option").remove();
    $("#cmbTipoServicios").select2({
        placeholder: 'Todos los servicios',
        width: 'resolve'
    });
    $("#cmbClientes, #cmbTipoServicios").change(function() {
        buscaServicios();
    });
    buscaServicios();
    // getCatServicios();
});


const buscaServicios = () => {
    showLoading_global();
    clientes = [];
    clientes_id = [];
    console.log("fechas: ", $("#rangoFechas").val());
    console.log("fechas: ", $("#fechas-startend").val());
    jQuery.ajax({
        url: __url__ + '?ajax&controller=Servicios&action=getServicios',
        data: {
            clientes: $("#cmbClientes").val().join(", "),
            fechas: $("#fechas-startend").val(),
            tiposervicios: ($("#cmbTipoServicios").val().join(", ") == "") ? "(SELECT id FROM catalogo_servicios)" : $("#cmbTipoServicios").val().join(", "),
        },
        method: 'POST',
        dataType: "json",
    }).then(resp => {
        servicios = resp;
        for (x = 0; x < servicios.servicios.length; x++) {
            if (clientes.indexOf(servicios.servicios[x].nom_cliente) < 0) {
                clientes.push(servicios.servicios[x].nom_cliente);
                clientes_id.push(servicios.servicios[x].id_cliente);
            }
            if (cat_servicios.indexOf(servicios.servicios[x].tipo_serv) < 0) {
                cat_servicios.push(servicios.servicios[x].tipo_serv);
                cat_servicios_id.push(servicios.servicios[x].id_tipo_serv);
            }
        }



        for (l = 0; l < clientes.length; l++) {
            // console.log(clientes[l]);
            if (llenaclientes == 0) {
                $("#cmbClientes").append('<option value="' + clientes_id[l] + '">' + clientes[l] + '</option>');

            }
        }
        for (l = 0; l < cat_servicios.length; l++) {
            if (llenaclientes == 0) {
                $("#cmbTipoServicios").append('<option value="' + cat_servicios_id[l] + '">' + cat_servicios[l] + '</option>');
            }
        }


        llenaclientes = 1;
        chart_servicios();
        //chart_grupos();
        armaTarjetas();
        // /*TABLA INVENTARIOS*/
        $('#tableServicios').DataTable().clear().destroy();
        table = $("#tableServicios").DataTable({
            searching: true,
            processing: true,
            width: "100%",
            // responsive: true,
            // scrollY: '55vh',
            scrollX: '55vw',
            dom: 'Blfrtip',
            bDestroy: true,
            autoWidth: true,
            data: servicios.servicios,
            columns: [{
                    data: 'folio'
                },
                {
                    data: 'tipo_serv'
                },
                {
                    data: 'numUnidad'
                },
                {
                    data: 'nom_cliente'
                },
                {
                    data: 'lote'
                },
                {
                    data: 'nom_prod'
                },
                {
                    data: 'alias'
                },
                {
                    data: 'cantidad'
                },
                {
                    data: 'fecha_inicio'
                },
                {
                    data: 'usu_ini'
                },
                {
                    data: 'fecha_fin'
                },
                {
                    data: 'usu_fin'
                }, {
                    data: 'tiempo_invertido'
                },
                {
                    data: 'tarimas'
                },
                {
                    data: 'parcial'
                },
                {
                    data: 'barredura_sucia'
                },
                {
                    data: 'barredura_limpia'
                },
            ],
            buttons: [
                'print',
                {
                    extend: 'excelHtml5',
                    title: `Reporte de servicios ensacado ${$("#rangoFechas").val()}`
                },
                // {
                // extend: 'pdfHtml5',
                // orientation: 'landscape',
                // },
                {
                    text: 'PDF',
                    className: 'btn buttons-pdf ',
                    action: function(e, dt, node, config) {
                        exportPDF($("#cmbClientes").val().join(", "), $("#rangoFechas").val());
                    },
                },
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All']
            ],
            language: {
                url: '<?php echo URL; ?>assets/libs/datatables/es-MX.json',
            },
            initComplete: function(settings, json) {
                swal.close();
            },
        });
        // table.buttons().container().appendTo($('.col-sm-6:eq(0)', table.table().container()));
        // dfrd1.resolve();
        // muestraGrafica(latab);

    }).fail(resp => {}).catch(resp => {
        erpalert("error", "Ocurrió un error al consultar los servicios");
        console.log(resp);
        swal.close();
    });

}

const getCatServicios = () => {
    jQuery.ajax({
        url: __url__ + '?ajax&controller=Catalogo&action=getServicios',
        data: {},
        method: 'POST',
        dataType: "json",
    }).then(resp => {
        cat_servicios = resp;
        for (l = 0; l < cat_servicios.length; l++) {
            $("#cmbTipoServicios").append('<option value="' + cat_servicios[l].id + '">' + cat_servicios[l].nombre + '</option>');
        }
        $("#cmbTipoServicios").select2();

    }).fail(resp => {}).catch(resp => {
        erpalert("error", "Ocurrió un error al consultar los servicios");
        console.log(resp);
        swal.close();
    });
}

const buscaServiciosChart = (cliente) => {
    showLoading_global();
    console.log("cliente: ", cliente);
    jQuery.ajax({
        url: __url__ + '?ajax&controller=Servicios&action=getServicios',
        data: {
            clientes: cliente,
            fechas: $("#fechas-startend").val(),
            tiposervicios: ($("#cmbTipoServicios").val().join(", ") == "") ? "(SELECT id FROM catalogo_servicios)" : $("#cmbTipoServicios").val().join(", "),
        },
        method: 'POST',
        dataType: "json",
    }).then(resp => {
        // /*TABLA INVENTARIOS*/
        console.log(resp.servicios);
        $('#tableServicios').DataTable().clear().destroy();
        $("#tableServicios").DataTable({
            searching: true,
            processing: true,
            width: "100%",
            // responsive: true,
            // scrollY: '55vh',
            scrollX: '55vw',
            dom: 'Blfrtip',
            bDestroy: true,
            autoWidth: true,
            data: resp.servicios,
            columns: [{
                    data: 'folio'
                },
                {
                    data: 'tipo_serv'
                },
                {
                    data: 'numUnidad'
                },
                {
                    data: 'nom_cliente'
                },
                {
                    data: 'lote'
                },
                {
                    data: 'nom_prod'
                },
                {
                    data: 'alias'
                },
                {
                    data: 'cantidad'
                },
                {
                    data: 'fecha_inicio'
                },
                {
                    data: 'usu_ini'
                },
                {
                    data: 'fecha_fin'
                },
                {
                    data: 'usu_fin'
                }, {
                    data: 'tiempo_invertido'
                },
                {
                    data: 'tarimas'
                },
                {
                    data: 'parcial'
                },
                {
                    data: 'barredura_sucia'
                },
                {
                    data: 'barredura_limpia'
                },
            ],
            buttons: [
                'print',
                {
                    extend: 'excelHtml5',
                    title: `Reporte de servicios ensacado ${$("#rangoFechas").val()}`
                },
                // {
                // extend: 'pdfHtml5',
                // orientation: 'landscape',
                // },
                {
                    text: 'PDF',
                    className: 'btn buttons-pdf ',
                    action: function(e, dt, node, config) {
                        exportPDF($("#cmbClientes").val().join(", "), $("#rangoFechas").val());
                    },
                },
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All']
            ],
            language: {
                url: '<?php echo URL; ?>assets/libs/datatables/es-MX.json',
            },
            initComplete: function(settings, json) {
                swal.close();
            },
            fail: function(settings, json) {
                swal.close();
            },
        });
        // table.buttons().container().appendTo($('.col-sm-6:eq(0)', table.table().container()));
        // dfrd1.resolve();
        // muestraGrafica(latab);

    }).fail(resp => {
        erpalert("error", "Ocurrió un fail al consultar los servicios");
        console.log(resp);
        swal.close();
    }).catch(resp => {
        erpalert("error", "Ocurrió un error al consultar los servicios");
        console.log(resp);
        swal.close();
    });

}

var myChart;
const chart_servicios = () => {

    //import * as echarts from 'echarts';
    // console.log($("#chart_entradas"));
    $("#chart_servicios").html("").attr("_echarts_instance_", "");
    data_estatus = [];
    data_colores = [];
    series_estatus = [];
    detalle_lotes = {};
    data.children = [];
    /*$.each(servicios.servicios_grafica, function(idx, obj) {
        console.log(idx);
        console.log(obj);
        data_estatus.push({
            'value': obj.cantidad,
            'name': obj.nom_cliente,
            'id': obj.id_cliente,
            'clave': obj.clave
        });
        data_colores.push(obj.colorweb);
    });*/
    $(".tar_clientes").html("");
    $.each(servicios.servicios_grafica, function(idx, obj) {
        // console.log(idx);
        console.log(obj.nom_cliente, " - ", obj.colorweb);
        data_estatus.push(
            // 'value': obj.cantidad,
            // 'name': obj.nom_cliente,
            // 'id': obj.id_cliente,
            // 'clave': obj.clave
            {
                name: obj.nom_cliente,
                value: obj.cantidad,
                id: obj.id_cliente,
                color: obj.colorweb,
                children: getChildren(obj.nom_cliente)
                // children: [{
                // name: 'nodeAa',
                // value: 4
                // },
                // {
                // name: 'nodeAb',
                // value: 6
                // }
                // ]
            }
        );
        data.children.push({
            name: obj.nom_cliente,
            color: obj.colorweb,
            children: [{
                name: obj.nom_cliente,
                id: obj.id_cliente,
                color: obj.colorweb,
                children: getChildren(obj.nom_cliente)
            }] //getChildren(obj.nom_cliente)
        });
        data_colores.push(obj.colorweb);
        $(".tar_clientes").append(`<div class="col card" style="
                                                                padding:10px; 
                                                                background-color:${obj.colorweb};
                                                                border:none;
                                                                margin: 5px;
                                                                font-size: 0.7rem;
                                                                font-weight: bold;
                                                                text-align: center;
                                                                color: white;">
                                        <span style="margin:auto;">${obj.nom_cliente}</span>
                                    </div>`);
    });

    // $("#chart_productos").html("").attr("_echarts_instance_", "");
    var chartDom = document.getElementById('chart_servicios');
    myChart = echarts.init(chartDom);
    var option;

    option = {
        // title: {
        // text: 'ECharts Options',
        // subtext: '2016/04',
        // left: 'leafDepth'
        // },
        tooltip: {},
        color: data_colores,
        series: [{
            name: 'Servicios',
            type: 'treemap',
            visibleMin: 300,
            data: data.children,
            leafDepth: 2,
            levels: [{
                    itemStyle: {
                        borderColor: '#fff',
                        borderWidth: 4,
                        gapWidth: 4,

                    }
                },
                {
                    colorSaturation: [0.3, 0.6],
                    itemStyle: {
                        borderColorSaturation: 0.7,
                        gapWidth: 2,
                        borderWidth: 2
                    }
                },
                {
                    colorSaturation: [0.3, 0.5],
                    itemStyle: {
                        borderColorSaturation: 0.6,
                        gapWidth: 1
                    }
                },
                {
                    colorSaturation: [0.3, 0.5]
                }
            ]
        }]
    };
    option && myChart.setOption(option);
    myChart.on('click', function(params) {
        // Print name in console
        try {
            console.log(params);
            console.log(params.data.id, params.data.name, params.data.clave);
            id_estatus_sel = params.data.id;
            estatus_sel = params.data.name;
            clave_sel = params.data.clave;
            buscaServiciosChart(params.data.id);
            // llenatablaestatus(params.data.id, params.data.name, params.data.clave);

        } catch (error) {
            //
            if (params.nodeData.dataIndex == 0) {
                buscaServiciosChart($("#cmbClientes").val().join(", "));
            }
        }
    });
    swal.close();

}

const getChildren = (nom_cliente = "") => {
    var children = [];
    var total = 0;
    var id_cliente;
    for (var x = 0; x < cat_servicios.length; x++) {
        total = 0;
        for (var s = 0; s < servicios.servicios.length; s++) {
            if (servicios.servicios[s].tipo_serv == cat_servicios[x] && servicios.servicios[s].nom_cliente == nom_cliente) {
                total++;
                id_cliente = servicios.servicios[s].id_cliente;
            }

        }
        children.push({
            name: cat_servicios[x] + " (" + total + ")",
            id: id_cliente,
            value: total
        });
    }
    // console.log(children);
    return children;

}

const armaTarjetas = () => {
    $("#cartas_serv").html("");
    for (var x = 0; x < cat_servicios.length; x++) {
        console.log(cat_servicios[x]);
        var total = 0;
        for (c = 0; c < servicios.servicios.length; c++) {
            if (servicios.servicios[c].tipo_serv == cat_servicios[x]) {
                total++;
            }
        }
        var html = /*html*/ `
            <div class="col-md-4">            
                    <div class="card card-animate sombras mt-3 mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">${cat_servicios[x]}</p>
                                        <h4 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="${htmlNum(total)}">${htmlNum(total)}</span></h4>
                                    </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0" style="margin:auto;">
                                        <span class="avatar-title bg-info rounded-circle fs-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
            </div>
            `;
        html = /*html*/ `
            <div class="col-md-4">
                <div class="card card-animate sombra bg-primary mt-3" style="margin: auto; text-align: center; border: none !important; color: white; font-weight: bold;">
                    <div class="avatar-sm flex-shrink-0" style="margin:auto;">
                        <span class="avatar-title bg-primary rounded-circle fs-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                        </span>
                    </div>
                    <span>${cat_servicios[x]} - ${htmlNum(total)}</span>
                </div>
            </div>
            `;
        $("#cartas_serv").append(html);
    }
}

function quitarComas(value) {
    try {
        const regex = /,/g;
        if (value != "") {
            var num = value.replace(regex, "");
            return parseFloat(num);
        }
    } catch (error) {
        return "";
    }
}

function htmlNum(num) {
    if ($.isNumeric(num)) {
        return Number(num).toLocaleString("en");
    } else {
        return "";
    }
}

function getColorCliente(cliente) {
    var color = getRandomColor();
    // console.log("getcolorcliente: ", color);
    for (x = 0; x < servicios.servicios_grafica.length; x++) {
        if (servicios.servicios_grafica[x].nom_cliente == cliente) {
            color = servicios.servicios_grafica[x].colorwerb;
            break;
        }
    }
    // console.log(color);
    return color;
}

const exportPDF = (Clientes, rangoFechas) => {
    // console.log("Clientes: ", Clientes);
    // console.log("rangoFechas: ", rangoFechas);

    window.open(serv + "?controller=Servicios&action=imprimirReporteServicios&fechas=" + rangoFechas + "&clientes=" + Clientes, "Imprimir servicio", "width=1300,height=600");

}
</script>