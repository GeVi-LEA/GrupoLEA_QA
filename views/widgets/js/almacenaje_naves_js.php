<script>
let inventarios;
let naves = [];



$(document).ready(function() {
    armaInventarios();


});

const armaInventarios = () => {
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
            clientes: ""
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
            if (naves.indexOf(inventarios.inventarios[x].Nombre_Almacen) < 0) {
                naves.push(inventarios.inventarios[x].Nombre_Almacen); // + '{' + inventarios.inventarios[x].total + '}');
            }
        }

        /* NAVES */
        for (c = 0; c < clientes.length; c++) {
            //console.log(naves[c]);
            if (detalle_naves.hasOwnProperty(clientes[c]) <= 0) {
                detalle_naves[clientes[c]] = ({
                    name: clientes[c],
                    type: 'bar',
                    stack: 'total',
                    label: {
                        show: false,
                        //formatter: function(param) {
                        //    // console.log("param: ", param);
                        //    return param.data == 0 ? '' : numero2Decimales(param.data.value, false, 0) + ' KG (TARIMAS:' + (Math.floor((param.data.value / 25) / 55)) + ' SACOS:' + (Math
                        //        .round((((param.data.value /
                        //                25) / 55) -
                        //            Math.floor((param.data.value / 25) / 55)) * 55)) + ') ';
                        //},
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
                            color: getColorCliente(clientes[c])
                        },
                    });
                }
            }


        }
        //}


        /*DETALLE NAVES */
        series_naves = [];
        $.each(detalle_naves, function(idx, obj) {
            series_naves.push(obj);

        });
        $("#chart_naves").html("").attr("_echarts_instance_", "");
        chart_nave();
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

const chart_nave = () => {

    //import * as echarts from 'echarts';
    $("#chart_nave").attr("style", "height:" + (naves.length * 200) + "px");
    $("#chart_nave").html("").attr("_echarts_instance_", "");
    //console.log($("#chart_nave"));
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
        //abreDetalle(params.seriesName, "null", "null", params.name);
    });
    setTimeout(() => {
        armaInventarios();
    }, 20000);
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