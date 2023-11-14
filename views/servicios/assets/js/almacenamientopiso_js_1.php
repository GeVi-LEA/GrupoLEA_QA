<script>
let inventarios;
let clientes = [];
let productos = [];
let lotes = [];
let legends_lotes = [];
let naves = [];
let colors = [];
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
    setTimeout(() => {
        chart_productos();
    }, 2000);

    $('#InventariosTab a').unbind();
    $('#InventariosTab a').on('click', function(e) {
        console.log($(this)[0].id.replace("-tab", ""));
        selectedtab = $(this)[0].id.replace("-tab", "");
        showLoading_global();
        armaInventarios($(this)[0].id.replace("-tab", "")).then(function() {
            console.log("aqui: ", $(this)[0].id.replace("-tab", ""));
        });
        console.log($(this)[0].id);
    });
    setInterval(() => {
        // console.log("moving: ", moving);
        // if (moving >= 0) {
        armaInventarios(selectedtab);
        console.log("armó los inventarios");
        setTimeout(() => {
            chart_productos();
            chart_lotes();
            chart_nave();
            console.log("terminó las graficas");
        }, 3000);



        // } else {
        // moving = 0;
        // }
    }, 60000);
    $(document).mousemove(function() {
        moving = 1;
    });
    $("#cmbClientes").change(function() {
        armaInventarios().done(function() {



            switch ($('#InventariosTab .active')[0].id.replace("-tab", "")) {
                case "productos":
                    setTimeout(() => {
                        $("#chart_productos").html("").attr("_echarts_instance_", "");
                        chart_productos();
                        swal.close();
                    }, 500);

                    break;
                case "lotes":
                    setTimeout(() => {
                        $("#chart_lotes").html("").attr("_echarts_instance_", "");
                        chart_lotes();
                        swal.close();
                    }, 500);


                    break;
                case "naves":
                    setTimeout(() => {
                        $("#chart_nave").html("").attr("_echarts_instance_", "");
                        chart_nave();
                        swal.close();
                    }, 500);

                    break;
                default:
                    break;
            }

        });
    });
});

const muestraGrafica = (latab) => {
    switch (latab) {
        case "productos":
            //setTimeout(() => {
            $("#chart_productos").html("").attr("_echarts_instance_", "");
            chart_productos();
            swal.close();
            //}, 500);

            break;
        case "lotes":
            //setTimeout(() => {
            $("#chart_lotes").html("").attr("_echarts_instance_", "");
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
const chart_productos = () => {

    //import * as echarts from 'echarts';
    $("#chart_productos").attr("style", "min-height:" + (productos.length * 100) + "px");
    console.log($("#chart_productos"));
    // $("#chart_productos").html("").attr("_echarts_instance_", "");
    var chartDom = document.getElementById('chart_productos');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
        color: colors, //clientes.map(obj => obj.color),
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
            data: productos //['L500', 'LS222ER25']
        },
        series: series_productos

    };

    option && myChart.setOption(option);
    myChart.on('click', function(params) {
        // Print name in console
        myChart.on('click', function(params) {
            // Print name in console
            // console.log(params);
            /*obtiene detalles*/
            abreDetalle(params.seriesName, "null", params.name, "null");
        });
    });
}

const chart_lotes = () => {

    //import * as echarts from 'echarts';
    $("#chart_lotes").attr("style", "height:" + (lotes.length * 100) + "px");
    console.log($("#chart_lotes"));
    // $("#chart_lotes").html("").attr("_echarts_instance_", "");
    var chartDom = document.getElementById('chart_lotes');
    chart_lotes_ = echarts.init(chartDom);
    var option;

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

    option && chart_lotes_.setOption(option);
    // console.log($("#chart_lotes"));
    try {
        chart_lotes_.unbind();
    } catch ($exception) {}
    chart_lotes_.on('click', function(params) {
        // Print name in console
        // console.log(params);
        /*obtiene detalles*/
        abreDetalle(params.seriesName, params.name, "null", "null");

    });
}
const chart_nave = () => {

    //import * as echarts from 'echarts';
    $("#chart_nave").attr("style", "height:" + (lotes.length * 100) + "px");
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
            data: legends_lotes //['LT45654', 'ABC1', 'ABC2', '678']
        },
        series: series_naves

    };

    option && myChart.setOption(option);
    myChart.on('click', function(params) {
        // Print name in console
        // console.log(params);
        /*obtiene detalles*/
        abreDetalle("null", params.name, "null", params.seriesName);
    });
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
    detalle_productos = {};
    detalle_lotes = {};
    detalle_naves = {};
    series_productos = [];
    series_lotes = [];
    series_naves = [];
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
            }
            if (productos.indexOf(inventarios.inventarios[x].Producto) < 0) {
                productos.push(inventarios.inventarios[x].Producto); // + '{' + inventarios.inventarios[x].total + '}');
            }
            if (lotes.indexOf(inventarios.inventarios[x].Lote) < 0) {
                lotes.push(inventarios.inventarios[x].Lote); // + '{' + inventarios.inventarios[x].total + '}');
            }
            if (naves.indexOf(inventarios.inventarios[x].Nombre_Almacen) < 0) {
                naves.push(inventarios.inventarios[x].Nombre_Almacen); // + '{' + inventarios.inventarios[x].total + '}');
            }
        }
        /* PRODUCTOS */
        //             ,floor(20000/25) bultos
        // ,floor((20000/25)/55) tarimas
        // ,round((((20000/25)/55)-floor((20000/25)/55))*55) parcial
        for (c = 0; c < clientes.length; c++) {
            //console.log(clientes[c]);
            if (detalle_productos.hasOwnProperty(clientes[c]) <= 0) {
                detalle_productos[clientes[c]] = ({
                    name: clientes[c],
                    type: 'bar',
                    stack: 'total',
                    label: {
                        show: true,
                        formatter: function(param) {
                            return param.data == 0 ? '' : numero2Decimales(param.data) + ' KG (TARIMAS:' + (Math.floor((param.data / 25) / 55)) + ' SACOS:' + (Math.round((((param.data /
                                    25) / 55) -
                                Math.floor((param.data / 25) / 55)) * 55)) + ') ';
                        },
                        shadowColor: 'rgba(0, 0, 0, 0.5)',
                        shadowBlur: 10
                    },
                    emphasis: {
                        focus: 'series'
                    },
                    data: [],



                });
                if (llenaclientes == 0) {
                    $("#cmbClientes").append('<option value="' + clientes_id[c] + '">' + clientes[c] + '</option>');
                }
                let total = 0;
                for (l = 0; l < productos.length; l++) {
                    // console.log(productos[l]);
                    total = 0;
                    for (x = 0; x < inventarios.inventarios.length; x++) {
                        if ((clientes[c] == inventarios.inventarios[x].Nombre_Cliente) && inventarios.inventarios[x].Producto == productos[l]) {
                            total = total + parseFloat(inventarios.inventarios[x].disponible);
                        }
                    }
                    detalle_productos[clientes[c]].data.push(total);
                }
            }

        }
        llenaclientes = 1;

        /* LOTES */
        for (c = 0; c < clientes.length; c++) {
            // console.log(clientes[c]);
            if (detalle_lotes.hasOwnProperty(clientes[c]) <= 0) {
                detalle_lotes[clientes[c]] = ({
                    name: clientes[c],
                    type: 'bar',
                    stack: 'total',
                    label: {
                        show: true,
                        formatter: function(param) {
                            return param.data == 0 ? '' : numero2Decimales(param.data) + ' KG (TARIMAS:' + (Math.floor((param.data / 25) / 55)) + ' SACOS:' + (Math.round((((param.data /
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
                            total = total + parseFloat(inventarios.inventarios[x].disponible);
                        }
                    }
                    detalle_lotes[clientes[c]].data.push(total);
                }
            }
        }

        /* NAVES */
        for (c = 0; c < naves.length; c++) {
            // console.log(naves[c]);
            if (detalle_naves.hasOwnProperty(naves[c]) <= 0) {
                detalle_naves[naves[c]] = ({
                    name: naves[c],
                    type: 'bar',
                    stack: 'total',
                    label: {
                        show: true,
                        formatter: function(param) {
                            return param.data == 0 ? '' : numero2Decimales(param.data) + ' KG (TARIMAS:' + (Math.floor((param.data / 25) / 55)) + ' SACOS:' + (Math.round((((param.data /
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
                for (l = 0; l < lotes.length; l++) {
                    // console.log(lotes[l]);
                    total = 0;
                    for (x = 0; x < inventarios.inventarios.length; x++) {
                        if ((naves[c] == inventarios.inventarios[x].Nombre_Almacen) && inventarios.inventarios[x].Lote == lotes[l]) {
                            total = total + parseFloat(inventarios.inventarios[x].disponible);
                        }
                    }
                    detalle_naves[naves[c]].data.push(total);
                }
            }


        }


        /*DETALLE PRODUCTOS */
        series_productos = [];
        $.each(detalle_productos, function(idx, obj) {
            series_productos.push(obj);

        });
        series_lotes = [];
        $.each(detalle_lotes, function(idx, obj) {
            series_lotes.push(obj);

        });
        series_naves = [];
        $.each(detalle_naves, function(idx, obj) {
            series_naves.push(obj);

        });

        /*TABLA INVENTARIOS*/
        $('#tableInventario').DataTable().clear().destroy();
        $("#tableInventario").DataTable({
            dom: 'Bfrtip',
            retrieve: true,
            data: inventarios.inventarios,
            columns: [{
                    data: 'Nombre_Cliente'
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
                    data: 'disponible'
                },


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
        dfrd1.resolve();
        muestraGrafica(latab);
    }).fail(resp => {}).catch(resp => {
        swal('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores', {
            icon: 'error'
        });
    });
    console.log("terminó de armar");
    return $.when(dfrd1).done(function() {
        console.log('both tasks in function1 are done');
        // Both asyncs tasks are done
    }).promise();
}

const abreDetalle = (cliente = "", lote = "", producto = "", almacen = "") => {
    console.log("entra a detalle");
    console.log(cliente, lote, producto);
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
            console.log(datos);
        },
        success: function(r) {
            var resp = r;
            console.log(resp);
            detalles = resp;
            Swal.fire({
                title: "<strong>" + ((cliente != "null") ? cliente : almacen) + "</strong>",
                // icon: 'info',
                position: "top",
                width: "80%",
                html: `El ${(lote!="null")?"Lote":(producto!="null")?"Producto":"Almacen"} seleccionado es ${(lote!="null")?lote:(producto!="null")?producto:almacen}
                                    <table class="display" id="table_detalle" style="width:100%">
                                    <thead>
                                          <th>FECHA</th><th>CARRO</th><th>TOLVA/PLACA</th><th>CLIENTE</th><th>TIPO</th><th>CANTIDAD</th><th>#ORDEN</th><th>FIN SERVICIO</th><th>ALMACÉN</th>
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
                                    data: 'cant_mov'
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

function numero2Decimales(str = "", $decimales = false, $numDecimales = 2) {
    if ($decimales) {
        $int = parseFloat(str);
        // return number_format($int, $numDecimales);
        return $int.toLocaleString("us", {
            minimumFractionDigits: $numDecimales,
            maximumFractionDigits: $numDecimales,
        });
    } else {
        console.log("str: ", str);
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
</script>