<script>
let inventarios;
let clientes = [];
let productos = [];
let productos_clientes = {};
let prods_disponibles = [];
var productos_sel_join = "";
var lotes_sel_join = "";
let lotes = [];
let legends_lotes = [];
let naves = [];
let colors = [];
let colors_productos = [];
let colors_lotes = [];
let detalle_productos = {};
let detalle_lotes = {};
let detalle_naves = {};
let series_productos = [];
let series_lotes = [];
let series_naves = [];
let interval;
let llenaclientes = 0;
let detalles;
let chart_lotes_;
let jason = {};
let selectedtab;
$(document).ready(function() {
    console.log("entra inventario");
    $("#cmbClientes").find("option").remove();
    armaInventarios();
    $("#cmbClientes").select2({
        placeholder: 'Todos los clientes',
        width: 'resolve'
    });
    $("#cmbProductos").select2({
        placeholder: 'Todos los productos',
        width: 'resolve'
    });
    $("#cmbLotes").select2({
        placeholder: 'Todos los lotes',
        width: 'resolve'
    });
    setTimeout(() => {
        chart_productos();
    }, 2000);

    $('#InventariosTab a').unbind();
    $('#InventariosTab a').on('click', function(e) {
        //console.log($(this)[0].id.replace("-tab", ""));
        selectedtab = $(this)[0].id.replace("-tab", "");
        $("#cmbProductos").parent().parent().attr("hidden", true);
        $("#cmbLotes").parent().parent().attr("hidden", true);
        productos_sel_join = "";
        showLoading_global();
        armaInventarios($(this)[0].id.replace("-tab", "")).then(function() {
            console.log("aqui: ", $(this)[0].id.replace("-tab", ""));
        });
        console.log($(this)[0].id);
    });
    setInterval(() => {
        // console.log("moving: ", moving);
        if (!$("#table_detalle").is(":visible")) {
            armaInventarios(selectedtab);
            //console.log("armó los inventarios");
            setTimeout(() => {
                chart_productos();
                chart_lotes();
                chart_nave();
                //console.log("terminó las graficas");
            }, 3000);



        }
        //else {
        // moving = 0;
        // }
    }, 60000);
    $(document).mousemove(function() {
        moving = 1;
    });
    $("#cmbClientes").change(function() {
        $("#cmbProductos").parent().parent().attr("hidden", true);
        $("#cmbLotes").parent().parent().attr("hidden", true);
        armaInventarios().done(function() {
            switch ($('#InventariosTab .active')[0].id.replace("-tab", "")) {
                case "productos":
                    setTimeout(() => {
                        $("#chart_productos").html("").attr("_echarts_instance_", "");
                        chart_productos();
                        armaFiltros("Productos");

                        swal.close();
                    }, 500);

                    break;
                case "lotes":
                    setTimeout(() => {
                        $("#chart_lotes").html("").attr("_echarts_instance_", "");
                        chart_lotes();
                        $("#cmbLotes").parent().parent().attr("hidden", false);
                        armaFiltros("Lotes");
                        swal.close();
                    }, 500);


                    break;
                case "naves":
                    setTimeout(() => {
                        $("#chart_nave").html("").attr("_echarts_instance_", "");
                        chart_nave();
                        // armaFiltros("naves");
                        swal.close();
                    }, 500);

                    break;
                default:
                    break;
            }

        });
    });

    $("#cmbProductos, #cmbLotes").change(function() {
        // $("#cmbProductos").parent().parent().attr("hidden", true);
        // $("#cmbLotes").parent().parent().attr("hidden", true);
        //armaInventarios().done(function() {
        switch ($('#InventariosTab .active')[0].id.replace("-tab", "")) {
            case "productos":
                setTimeout(() => {
                    $("#chart_productos").html("").attr("_echarts_instance_", "");
                    chart_productos();
                    // armaFiltros("Productos");

                    swal.close();
                }, 500);

                break;
            case "lotes":
                setTimeout(() => {
                    $("#chart_lotes").html("").attr("_echarts_instance_", "");
                    chart_lotes();
                    $("#cmbLotes").parent().parent().attr("hidden", false);
                    // armaFiltros("Lotes");
                    swal.close();
                }, 500);


                break;
            case "naves":
                setTimeout(() => {
                    $("#chart_nave").html("").attr("_echarts_instance_", "");
                    chart_nave();
                    // armaFiltros("naves");
                    swal.close();
                }, 500);

                break;
            default:
                break;
        }

        //});
    });
});

const muestraGrafica = (latab) => {
    switch (latab) {
        case "productos":
            //setTimeout(() => {
            $("#chart_productos").html("").attr("_echarts_instance_", "");
            $("#cmbProductos").parent().parent().attr("hidden", false);
            chart_productos();
            swal.close();
            //}, 500);

            break;
        case "lotes":
            //setTimeout(() => {
            $("#chart_lotes").html("").attr("_echarts_instance_", "");
            $("#cmbLotes").parent().parent().attr("hidden", false);
            chart_lotes();
            swal.close();
            //}, 500);


            break;
        case "naves":
            //setTimeout(() => {
            $("#chart_naves").html("").attr("_echarts_instance_", "");
            chart_nave();
            swal.close();
            //}, 500);

            break;
        default:
            break;
    }

}

const armaInventarios = (latab) => {
    var dfrd1 = $.Deferred();
    clientes = [];
    clientes_id = [];
    productos = [];
    lotes = [];
    legends_lotes = [];
    naves = [];
    colors = [];
    colors_productos = [];
    detalle_productos = {};
    detalle_lotes = {};
    detalle_naves = {};
    series_productos = [];
    series_lotes = [];
    series_naves = [];
    // $("#cmbProductos").parent().parent().attr("hidden", true);
    // $("#cmbLotes").parent().parent().attr("hidden", true);
    jQuery.ajax({
        url: __url__ + '?ajax&controller=Servicios&action=getInventarios',
        data: {
            clientes: $("#cmbClientes").val().join(", ")
        },
        method: 'POST',
        dataType: "json",
    }).then(resp => {
        inventarios = resp;
        for (x = 0; x < inventarios.inventarios.length; x++) {
            if (clientes.indexOf(inventarios.inventarios[x].Nombre_Cliente) < 0) {
                clientes.push(inventarios.inventarios[x].Nombre_Cliente);
                clientes_id.push(inventarios.inventarios[x].id_cliente);
                colors.push(inventarios.inventarios[x].color_cliente);
                // productos_clientes[inventarios.inventarios[x].Nombre_Cliente].push(inventarios.inventarios[x].Producto);
            }
            if (productos.indexOf(inventarios.inventarios[x].Producto) < 0) {
                productos.push(inventarios.inventarios[x].Producto); // + '{' + inventarios.inventarios[x].total + '}');
                if (productos_clientes.hasOwnProperty(inventarios.inventarios[x].Nombre_Cliente) <= 0) {
                    productos_clientes[inventarios.inventarios[x].Nombre_Cliente] = [inventarios.inventarios[x].Producto];
                } else {
                    productos_clientes[inventarios.inventarios[x].Nombre_Cliente].push(inventarios.inventarios[x].Producto);
                }
            }
            if (lotes.indexOf(inventarios.inventarios[x].Lote) < 0) {
                lotes.push(inventarios.inventarios[x].Lote); // + '{' + inventarios.inventarios[x].total + '}');
            }
            if (naves.indexOf(inventarios.inventarios[x].Nombre_Almacen) < 0) {
                naves.push(inventarios.inventarios[x].Nombre_Almacen); // + '{' + inventarios.inventarios[x].total + '}');
            }
        }
        /* PRODUCTOS */

        for (c = 0; c < clientes.length; c++) {
            detalle_productos[clientes[c]] = ({
                type: 'bar',
                data: [], //[1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                coordinateSystem: 'polar',
                name: clientes[c],
                stack: 'a',
                emphasis: {
                    focus: 'series'
                },
                label: {
                    show: true,
                    position: 'middle',
                    formatter: '{b}: {c}'
                }
            });
        }
        for (c = 0; c < clientes.length; c++) {
            for (p = 0; p < productos.length; p++) {
                total = 0;
                for (x = 0; x < inventarios.inventarios.length; x++) {
                    // console.log(inventarios.inventarios[x].Producto, "==", productos[p]);
                    if (inventarios.inventarios[x].Producto == productos[p]) {
                        // if ((detalle_productos.hasOwnProperty(inventarios.inventarios[x].Nombre_Cliente) <= 0)) {
                        total = total + parseFloat(quitarComasNumero(inventarios.inventarios[x].disponible));
                        // detalle_productos[inventarios.inventarios[x].Nombre_Cliente].data.push(inventarios.inventarios[x].disponible);
                    } else {
                        // detalle_productos[inventarios.inventarios[x].Nombre_Cliente].data.push(0);
                    }
                }
                detalle_productos[clientes[c]].data.push(total);
            }
        }

        for (l = 0; l < clientes.length; l++) {
            // console.log(clientes[l]);
            if (llenaclientes == 0) {
                $("#cmbClientes").append('<option value="' + clientes_id[l] + '">' + clientes[l] + '</option>');
            }
        }
        llenaclientes = 1;

        /* LOTES */
        for (c = 0; c < clientes.length; c++) {
            if (detalle_lotes.hasOwnProperty(clientes[c]) <= 0) {
                detalle_lotes[clientes[c]] = ({
                    name: clientes[c],
                    type: 'bar',
                    stack: 'total',
                    label: {
                        show: true,
                        formatter: function(param) {
                            return param.data == 0 ? '' : numero2Decimales(param.data, false, 0) + ' KG (TARIMAS:' + (Math.floor((param.data / 25) / 55)) + ' SACOS:' + (Math
                                .round((((param.data /
                                        25) / 55) -
                                    Math.floor((param.data / 25) / 55)) * 55)) + ') ';
                        },
                    },
                    emphasis: {
                        focus: 'series'
                    },
                    data: []
                });
                let total = 0;
                legends_lotes = [];
                for (l = 0; l < lotes.length; l++) {
                    // console.log(lotes[l]);
                    legends_lotes.push(lotes[l]);
                    total = 0;
                    for (x = 0; x < inventarios.inventarios.length; x++) {
                        if ((clientes[c] == inventarios.inventarios[x].Nombre_Cliente) && inventarios.inventarios[x].Lote == lotes[l]) {
                            total = total + parseFloat(quitarComasNumero(inventarios.inventarios[x].disponible));
                        }
                    }
                    detalle_lotes[clientes[c]].data.push(total);
                }
            }
        }

        /* NAVES */

        for (c = 0; c < clientes.length; c++) {
            // console.log(naves[c]);
            if (detalle_naves.hasOwnProperty(clientes[c]) <= 0) {
                detalle_naves[clientes[c]] = ({
                    name: clientes[c],
                    type: 'bar',
                    stack: 'total',
                    color: colors[c],
                    label: {
                        show: true,
                        formatter: function(param) {
                            // console.log("param: ", param);
                            return param.data == 0 ? '' : numero2Decimales(param.data.value, false, 0) + ' KG (TARIMAS:' + (Math.floor((param.data.value / 25) / 55)) + ' SACOS:' + (Math
                                .round((((param.data.value /
                                        25) / 55) -
                                    Math.floor((param.data.value / 25) / 55)) * 55)) + ') ';
                        },
                    },
                    emphasis: {
                        focus: 'series'
                    },
                    data: []
                });
                let total = 0;
                for (l = 0; l < naves.length; l++) {
                    // console.log(lotes[l]);
                    total = 0;
                    for (x = 0; x < inventarios.inventarios.length; x++) {
                        if ((naves[l] == inventarios.inventarios[x].Nombre_Almacen) && inventarios.inventarios[x].Nombre_Cliente == clientes[c]) {
                            total = total + parseFloat(quitarComasNumero(inventarios.inventarios[x].disponible));
                        }
                    }
                    detalle_naves[clientes[c]].data.push({
                        value: total,
                        itemStyle: {
                            color: colors[c] //getColorCliente(clientes[c])
                        },
                    });
                }
            }


        }

        /*DETALLE PRODUCTOS */
        series_productos = [];
        $.each(detalle_productos, function(idx, obj) {
            //console.log((idx, obj))
            series_productos.push(obj);
        });
        series_lotes = [];
        //$.each(detalle_lotes, function(idx, obj) {
        //    series_lotes.push(obj);
        //
        //});
        series_naves = [];
        $.each(detalle_naves, function(idx, obj) {
            series_naves.push(obj);

        });

        /*TABLA INVENTARIOS*/
        $('#tableInventario').DataTable().clear().destroy();
        table = $("#tableInventario").DataTable({
            dom: 'Bfltip',
            retrieve: true,
            data: inventarios.inventarios,
            columns: [{
                    data: 'Nombre_Cliente'
                },
                {
                    data: 'numUnidad'
                },
                {
                    data: 'Nombre_Almacen'
                },
                {
                    data: 'Producto'
                },
                {
                    data: 'Lote'
                },
                {
                    data: 'Rotulo'
                },
                {
                    data: 'disponible'
                },
                {
                    data: 'sacoxtarima'
                },
                {
                    data: 'tarimas'
                },
                {
                    data: 'parcial'
                },
                /*
                <th>Nombre del Cliente</th>
                <th>Num Ferrotolva</th>
                <th>Almacen</th>
                <th>Producto</th>
                <th>Lote</th>
                <th>Rótulo</th>
                <th>Cant. Disponible</th>
                <th>Sacos por Tarima</th>
                <th>Tarimas</th>
                <th>Parcial</th>
                */

            ],
            buttons: [
                'print',
                {
                    extend: 'excelHtml5',
                    title: `Reporte de inventarios ${formatDate(new Date())}`
                },
                'pdf'
            ],
            language: {
                url: '<?php echo URL; ?>assets/libs/datatables/es-MX.json',
            },
        });
        table.buttons().container()
            .appendTo($('.col-sm-6:eq(0)', table.table().container()));
        dfrd1.resolve();
        muestraGrafica(latab);
        armaFiltros("Productos");
        armaFiltros("Lotes");
    }).fail(resp => {}).catch(resp => {
        swal('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores', {
            icon: 'error'
        });
    });
    //console.log("terminó de armar");
    return $.when(dfrd1).done(function() {
        //console.log('both tasks in function1 are done');
        // Both asyncs tasks are done
    }).promise();
}

const chart_productos = () => {

    //import * as echarts from 'echarts';
    // $("#chart_productos").attr("style", "min-height:" + (productos.length * 100) + "px");
    console.log($("#chart_productos"));
    $("#productos .contenido").html("");
    // armaFiltros("Productos");
    $("#cmbProductos").parent().parent().attr("hidden", false);

    for (var xchart = 0; xchart < clientes_id.length; xchart++) {

        $("#productos .contenido").append(`<div class='col-md-${(((12/Math.round(clientes_id.length))/1) < 6) ? "6":((12/Math.round(clientes_id.length))/1)}'><div id='chart_productos_${clientes_id[xchart]}' style='min-height:600px;'></div></div>`);

        // $("#chart_productos").html("").attr("_echarts_instance_", "");
        var chartDom = document.getElementById('chart_productos_' + clientes_id[xchart]);
        var myChart = echarts.init(chartDom);
        var option;

        /* ARMA LA DATA POR CLIENTE */
        var prod_cliente = {};
        var color_cliente = "";
        var productos_sel = (($("#cmbProductos").val().length > 0) ? $("#cmbProductos").val().join(",").split(",") : "");
        productos_sel_join = (($("#cmbProductos").val().length > 0) ? $("#cmbProductos").val().join(",") : "");
        $.each(inventarios.inventarios, function(i, item) {
            if (item.id_cliente == clientes_id[xchart]) {
                // console.log(item);
                color_cliente = item.color_cliente;
                if ((prod_cliente.hasOwnProperty(item.Producto) <= 0) && (productos_sel.length == 0 || jQuery.inArray($.trim(item.Producto), productos_sel) >= 0)) {
                    prod_cliente[item.Producto] = parseFloat(quitarComasNumero(item.disponible));
                } else {
                    if (productos_sel.length == 0 || jQuery.inArray($.trim(item.Producto), productos_sel) >= 0) {
                        prod_cliente[item.Producto] = prod_cliente[item.Producto] + parseFloat(quitarComasNumero(item.disponible));
                    }
                }
            }
        });
        data_estatus = [];
        data_label = [];
        data_value = [];
        $.each(prod_cliente, function(i, item) {
            // console.log(i, " - ", item);
            data_label.push(i + " {" + numero2Decimales2(item, false, 0) + " KG}");
            data_value.push(item);
            data_estatus.push({
                'value': item,
                'name': i + " {" + numero2Decimales2(item, false, 0) + " KG}",
                // 'id': obj.estatus_id,
                // 'clave': obj.clave
            });
        });

        option = {
            title: {
                text: clientes[xchart],
                // subtext: 'Fake Data',
                left: 'center'
            },
            tooltip: {
                trigger: 'item'
            },
            xAxis: {
                type: 'category',
                data: data_label, //['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                axisLabel: {
                    interval: 0,
                    rotate: 90
                }
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    interval: 0,
                    rotate: 90
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            series: [{
                data: data_value, //[120, 200, 150, 80, 70, 110, 130],
                type: 'bar',
                color: color_cliente,
                name: clientes[xchart]
            }]
        };
        option && myChart.setOption(option);
        //        myChart.unbind();
        myChart.on('click', function(params) {
            // Print name in console
            //console.log(params);
            // myChart.on('click', function(params) {
            // Print name in console

            /*obtiene detalles*/
            abreDetalle(params.seriesName, "null", params.name.split(" {")[0], "null");
            // });
        });
    }
    // armaFiltros("Productos");
}


const chart_lotes = () => {

    //import * as echarts from 'echarts';
    // $("#chart_lotes").attr("style", "height:" + (lotes.length * 100) + "px");
    console.log("#chart_lotes");
    // armaFiltros("Lotes");
    $("#cmbLotes").parent().parent().attr("hidden", false);
    $("#lotes .contenido").html("");
    for (var xchart = 0; xchart < clientes_id.length; xchart++) {

        $("#lotes .contenido").append(`<div class='col-md-${(((12/Math.round(clientes_id.length))/1) < 6) ? "6":((12/Math.round(clientes_id.length))/1)}'><div id='chart_lotes_${clientes_id[xchart]}' style='min-height:600px;'></div></div>`);

        // $("#chart_productos").html("").attr("_echarts_instance_", "");
        var chartDom = document.getElementById('chart_lotes_' + clientes_id[xchart]);

        // $("#chart_lotes").html("").attr("_echarts_instance_", "");
        var chartDom = document.getElementById('chart_lotes_' + clientes_id[xchart]);
        chart_lotes_ = echarts.init(chartDom);
        var option;

        var prod_cliente = {};
        var color_cliente = "";
        var lotes_sel = (($("#cmbLotes").val().length > 0) ? $("#cmbLotes").val().join(",").split(",") : "");
        lotes_sel_join = (($("#cmbLotes").val().length > 0) ? $("#cmbLotes").val().join(",") : "");
        //console.log("cliente: ", clientes_id[xchart]);
        $.each(inventarios.inventarios, function(i, item) {
            if (item.id_cliente == clientes_id[xchart]) {
                // console.log(item);
                color_cliente = item.color_cliente;
                if ((prod_cliente.hasOwnProperty(item.Lote) <= 0) && (lotes_sel.length == 0 || jQuery.inArray($.trim(item.Lote), lotes_sel) >= 0)) {
                    prod_cliente[item.Lote] = parseFloat(quitarComasNumero(item.disponible));
                } else {
                    if (lotes_sel.length == 0 || jQuery.inArray($.trim(item.Lote), lotes_sel) >= 0) {
                        prod_cliente[item.Lote] = prod_cliente[item.Lote] + parseFloat(quitarComasNumero(item.disponible));
                    }
                }
            }
        });
        data_estatus = [];
        var data_label = [];
        var data_value = [];
        $.each(prod_cliente, function(i, item) {
            data_label.push(i + " {" + numero2Decimales2(item, false, 0) + " KG}");
            data_value.push(item);
        });
        /*
        option = {
            color: colors,
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    // Use axis to trigger tooltip
                    type: 'shadow' // 'shadow' as default; can also be 'line' or 'shadow'
                }
            },
            legend: {},
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'value'
            },
            yAxis: {
                type: 'category',
                data: legends_lotes //['LT45654', 'ABC1', 'ABC2', '678']
            },
            series: series_lotes

        };
        */
        option = {
            title: {
                text: clientes[xchart],
                // subtext: 'Fake Data',
                left: 'center'
            },
            tooltip: {
                trigger: 'item'
            },
            xAxis: {
                type: 'category',
                data: data_label, //['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                axisLabel: {
                    interval: 0,
                    rotate: 90
                }
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    interval: 0,
                    rotate: 90
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            series: [{
                data: data_value, //[120, 200, 150, 80, 70, 110, 130],
                type: 'bar',
                color: color_cliente,
                name: clientes[xchart]
            }]
        };
        option && chart_lotes_.setOption(option);
        // console.log($("#chart_lotes"));
        //try {
        //    chart_lotes_.unbind();
        //} catch ($exception) {}
        //        chart_lotes.unbind();
        chart_lotes_.on('click', function(params) {
            // Print name in console
            //console.log(params);
            /*obtiene detalles*/
            abreDetalle(params.seriesName, params.name.split(" {")[0], "null", "null");

        });
    }

}

const chart_nave = () => {

    //import * as echarts from 'echarts';
    $("#chart_nave").attr("style", "height:" + (naves.length * 200) + "px");
    // $("#chart_nave").html("").attr("_echarts_instance_", "");
    console.log($("#chart_nave"));
    var chartDom = document.getElementById('chart_nave');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                // Use axis to trigger tooltip
                type: 'shadow' // 'shadow' as default; can also be 'line' or 'shadow'
            }
        },
        legend: {},
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'value'
        },
        yAxis: {
            type: 'category',
            data: naves, //legends_lotes //['LT45654', 'ABC1', 'ABC2', '678']
        },
        series: series_naves

    };

    option && myChart.setOption(option);
    //    myChart.unbind();
    myChart.on('click', function(params) {
        // Print name in console
        //console.log(params);
        /*obtiene detalles*/
        abreDetalle(params.seriesName, "null", "null", params.name);
    });
}

const armaFiltros = (filtro = "") => {
    console.log("aqui");
    $("#cmbProductos, #cmbLotes").find("option").remove();
    // $("#cmb" + filtro).parent().parent().attr("hidden", false);
    $("#cmb" + filtro).find("option").remove();
    var _lotes = [];
    var _productos = [];
    for (var x = 0; x < inventarios.inventarios.length; x++) {
        if (parseFloat(quitarComasNumero(inventarios.inventarios[x].disponible)) > 0) {
            if (jQuery.inArray($.trim(inventarios.inventarios[x].Producto), _productos) < 0) {
                _productos.push(inventarios.inventarios[x].Producto);
            }
            if (jQuery.inArray($.trim(inventarios.inventarios[x].Lote), _lotes) < 0) {
                _lotes.push(inventarios.inventarios[x].Lote);
            }

        }
    }
    if (filtro == "Lotes") {
        for (x = 0; x < _lotes.length; x++) {
            $("#cmbLotes").append('<option value="' + $.trim(_lotes[x]) + '">' + $.trim(_lotes[x]) + '</option>');
        }
    } else {
        for (x = 0; x < _productos.length; x++) {
            $("#cmbProductos").append('<option value="' + $.trim(_productos[x]) + '">' + $.trim(_productos[x]) + '</option>');
        }
    }
}


const abreDetalle = (cliente = "", lote = "", producto = "", almacen = "") => {
    //console.log("entra a detalle");
    //console.log(cliente, lote, producto, almacen);
    let datos = {
        "cliente": cliente,
        "lote": lote,
        "producto": producto,
        "almacen": almacen
    };
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: __url__ + "?ajax&controller=Servicios&action=getInventariosDetalle",
        data: datos,
        beforeSend: function(datas) {
            //console.log(datos);
        },
        success: function(r) {
            var resp = r;
            //console.log(resp);
            detalles = resp;
            Swal.fire({
                title: "<strong>" + ((cliente != "null") ? cliente : almacen) + "</strong>",
                // icon: 'info',
                position: "top",
                width: "90%",
                html: `El ${(lote!="null")?"Lote":(producto!="null")?"Producto":"Almacen"} seleccionado es ${(lote!="null")?lote:(producto!="null")?producto:almacen}
                                    <table class="display" id="table_detalle" style="width:100%">
                                    <thead>
                                          <th>FECHA</th><th>CARRO</th><th>TOLVA/PLACA</th><th>CLIENTE</th><th>TIPO</th><th>LOTE</th><th>ROTULO</th><th>CANTIDAD</th><th>#ORDEN</th><th>FIN SERVICIO</th><th>ALMACÉN</th>
                                    </thead>
                                    <tbody>
                                    </tbody>


                              `,
                showCloseButton: true,
                didOpen: () => {
                    setTimeout(() => {
                        $("#table_detalle").DataTable({
                            dom: 'Bfrtip',
                            retrieve: true,
                            data: resp.inventarios,
                            columns: [{
                                    data: 'fecha_entrada'
                                },
                                {
                                    data: 'numUnidad'
                                },
                                {
                                    data: 'placa1'
                                },
                                {
                                    data: 'Nombre_Cliente'
                                },
                                {
                                    data: 'operacion',
                                    class: 'clase'
                                },
                                {
                                    data: 'Lote'
                                },
                                {
                                    data: 'Rotulo'
                                },
                                {
                                    data: 'cant_mov',
                                    class: 'cant_movs'
                                },
                                {
                                    data: 'orden'
                                },
                                {
                                    data: 'fecha_fin_servicio'
                                },
                                {
                                    data: 'Nombre_Almacen'
                                },

                            ],
                            buttons: [
                                'print',

                                {
                                    extend: 'excelHtml5',
                                    // className: 'btn btnExcel',
                                    title: `Reporte de inventario ${((cliente != "null") ? cliente : almacen)} ${formatDate(new Date())}`
                                },
                                'pdf',
                                {
                                    text: 'Transfer',
                                    className: 'btn btnTransfer ' + ((lote != "null") ? "" : "hide"),
                                    action: function(e, dt, node, config) {
                                        transferencia(cliente, lote);
                                    },

                                },

                            ],
                            language: {
                                url: '<?php echo URL; ?>assets/libs/datatables/es-MX.json',
                            },
                            initComplete: function() {
                                for (x = 0; x < $(".cant_movs").length; x++) {
                                    //console.log($(".cant_movs")[x].innerText)
                                    if ($(".cant_movs")[x].innerText.indexOf("-") >= 0) {
                                        //$(".cant_movs")[x].innerText = "<color='red'>"+$(".cant_movs")[x].innerText+"</color>";
                                        $(".cant_movs")[x].className = $(".cant_movs")[x].className + " i-red"
                                    }
                                }
                            }
                        });
                    }, 500);

                },
            });
        },
        error: function(xhr, status, error) {
            erpalert("error", "Algo salio mal, contacte al administrador....");
            console.log(xhr, status, error);
        },
    });

};


function DistinctRecords(MYJSON, prop) {
    return MYJSON.filter((obj, pos, arr) => {
        return arr.map(mapObj => mapObj[prop]).indexOf(obj[prop]) === pos;
    })
}

const transferencia = (cliente = "", lote = "", producto = "", almacen = "") => {
    console.log(cliente);
    console.log(lote);
    var elrow = getrow(cliente, lote);
    Swal.fire({
        title: "<strong>Transferir entre almacenes</strong>",
        // icon: 'info',
        // position: "top",
        width: "50%",
        showCancelButton: true,
        confirmButtonText: 'Transferir',
        cancelButtonText: 'Cancelar',
        html: /*html*/ `El ${(lote!="null") ? "Lote: "+lote+"" : ""}
            <div class="row">
                  <div class="d-flex justify-content-between pb-1" id="divAlmacenes">
                        <div class="d-flex">
                              <label class="pt-1 pr-1">Almacen Origen:</label>
                              <select class="item-small" name="almacen[]" id="selectAlmacen_from" required>
                                    <option value="">-Selecciona</option>
                              </select>
                        </div>
                        <div class="d-flex">
                              <label class="pt-1 pr-1">Almacen Destino:</label>
                              <select class="item-small" name="almacen[]" id="selectAlmacen_to" required>
                                    <option value="">-Selecciona</option>
                              </select>
                        </div>
                        
                        <div class="d-flex">
                              <label class="pt-1 pr-1">Cantidad:</label> <input type="text" name="cantidadAlmacen[]" class="item-small" id="cantidadEnviar" required />
                              <span class="pt-1 pl-1">Kg.</span>
                        </div>
                  </div>
            </div>
            `,
        showCloseButton: true,
        didOpen: () => {
            var select_from = $("#selectAlmacen_from");
            var select_to = $("#selectAlmacen_to");
            $.ajax({
                url: __url__ + "?ajax&controller=Catalogo&action=getAlmacenes",
                type: "POST",
                dataType: "json",
                success: function(r) {
                    console.log(r);
                    if (r != false) {
                        select_from.find("option").not(":first").remove();
                        select_to.find("option").not(":first").remove();
                        if (r.length != 0) {
                            $(r).each(function(i, v) {
                                // indice, valor
                                select_from.append(
                                    '<option value="' + v.id + '">' + v.nombre + "</option>"
                                );
                                select_to.append(
                                    '<option value="' + v.id + '">' + v.nombre + "</option>"
                                );
                            });
                        } else {
                            select_from.append(
                                '<option value="" disabled>No hay almacenes registrados</option>'
                            );
                            select_to.append(
                                '<option value="" disabled>No hay almacenes registrados</option>'
                            );
                        }
                    }
                },
                error: function() {
                    alert("Algo salio mal, contacte al Administrador.");
                },
            });

        },
        didClose: () => {




            abreDetalle(cliente, lote, "null", "null");
        }

    }).then((result) => {
        if (result.isConfirmed) {
            console.log("envia transferencia");
            console.log("selectAlmacen_from: ", $("#selectAlmacen_from").val());
            console.log("selectAlmacen_to: ", $("#selectAlmacen_to").val());
            console.log("cantidadEnviar: ", $("#cantidadEnviar").val());
            jQuery.ajax({
                url: __url__ + "?ajax&controller=Servicios&action=setTransfer",
                data: {
                    almacen_id_from: $("#selectAlmacen_from").val(),
                    almacen_id_to: $("#selectAlmacen_to").val(),
                    cantidad: $("#cantidadEnviar").val(),
                    lote: lote
                },
                method: 'POST',
                dataType: "json",
            }).then(resp => {
                erpalert("", "", "Se realizó transferencia");
                abreDetalle(cliente, lote, "null", "null");
            }).fail(resp => {}).catch(resp => {
                swal('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores', {
                    icon: 'error'
                });
            });

        }
    });


}

function getrow(cliente, lote) {
    for (var x = 0; x < inventarios.inventarios.length; x++) {
        if (inventarios.inventarios[x].Nombre_Cliente == cliente && inventarios.inventarios[x].Lote == lote) {

            return inventarios.inventarios[x];
        }

    }
}

function numero2Decimales2(str = "", $decimales = false, $numDecimales = 2) {
    // console.log("str: ", str);
    if ($decimales) {
        $int = parseFloat(str);
        // return number_format($int, $numDecimales);
        return $int.toLocaleString("us", {
            minimumFractionDigits: $numDecimales,
            maximumFractionDigits: $numDecimales,
        });
    } else {

        $strArray = str.toString().split("/[.]/");
        if (parseInt($strArray[1]) == 0) {
            $int = parseInt(str);
            return number_format($int);
            return $int.toLocaleString("us", {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            });
        } else {
            $int = parseFloat(str);
            return $int.toLocaleString("us", {
                minimumFractionDigits: $numDecimales,
                maximumFractionDigits: $numDecimales,
            });
            // return number_format($int, $numDecimales);
        }
    }
}

function quitarComasNumero(value) {
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

function getColorCliente(cliente) {
    var color = getRandomColor();
    // console.log("getcolorcliente: ", color);
    for (x = 0; x < inventarios.inventarios.length; x++) {
        if (inventarios.inventarios[x].Nombre_Cliente == cliente) {
            color = inventarios.inventarios[x].color_cliente;
            break;
        }
    }
    // console.log(color);
    return color;
}
</script>