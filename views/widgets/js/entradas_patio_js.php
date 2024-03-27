<script>
let servicios;
var datosGrafica;
var data_estatus = [];
var data_colores = [];
var series_estatus = [];
var detalle_lotes = {};


$(document).ready(function() {
    //console.log("entra en lista de unidades");
    llenatablaestatus();
    // swal.close();

    setTimeout(() => {
        llenatablaestatus();
    }, 10000);
});

const chart_entradas = () => {

    //import * as echarts from 'echarts';
    // console.log($("#chart_entradas"));
    //console.log("arma chart_entradas");
    $("#chart_entradas").html("").attr("_echarts_instance_", "");
    data_estatus = [];
    data_colores = [];
    series_estatus = [];
    detalle_lotes = {};
    $.each(datosGrafica, function(idx, obj) {
        data_estatus.push({
            'value': obj.cantidad,
            'name': obj.estatus,
            'id': obj.estatus_id,
            'clave': obj.clave
        });
        data_colores.push(obj.color_estatus);
    });

    // $("#chart_productos").html("").attr("_echarts_instance_", "");
    var chartDom = document.getElementById('chart_entradas');
    var myChart = echarts.init(chartDom);
    var option;

    option = {
        tooltip: {
            trigger: 'item'
        },
        legend: {
            // top: '5%',
            // left: 'center',
            orient: 'vertical',
            left: 'left',
            // formatter: '{b}：{{c}}  {d}%',
            textStyle: {
                color: getColorTheme().fontcolor
            },
            itemStyle: {
                borderColor: getColorTheme().bgcolor

            },
            selected: {
                'Liberada': false,
            },
        },
        series: [{
            name: 'Entradas',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: true,
            selectedMode: 'single',
            itemStyle: {
                borderRadius: 10,
                borderColor: getColorTheme().bgcolor, //'#fff',
                borderWidth: 5
            },
            label: {
                // show: false,
                show: true,
                // position: 'center',
                position: 'right',
                formatter: '{b}：{{c}}  {d}%',
                borderColor: getColorTheme().bgcolor,
                color: getColorTheme().fontcolor
                // formatter: function(d) {
                // return d.name + ' { ' + d.data.value + ' }  {d}%' + d % ;
                // }
            },
            emphasis: {
                label: {
                    show: true,
                    fontSize: 15,
                    fontWeight: 'bold'
                }
            },
            labelLine: {
                show: true
            },
            color: data_colores, //["#7a7a7a", "#b5b228", "##1b8a05", "#d8813a", "#dad73f", "#2501a5", "#e4a700"],
            data: data_estatus,

        }]
    };
    option && myChart.setOption(option);
    myChart.on('click', function(params) {
        // Print name in console
        // console.log("estatus_id:", params.data.id);
        id_estatus_sel = params.data.id;
        estatus_sel = params.data.name;
        clave_sel = params.data.clave;
        llenatablaestatus(params.data.id, params.data.name, params.data.clave);
    });
    swal.close();



}

function llenatablaestatus() {
    $.ajax({
        url: __url__ + '?ajax&controller=Servicios&action=getUnidadesEstatus',
        data: {
            id_estatus: "0"
        },
        method: 'post',
        dataType: "json",
    }).then(resp => {
        // console.log(resp);
        servicios = resp;
        datosGrafica = resp.datosGrafica;
        chart_entradas();
    }).fail(resp => {}).catch(resp => {
        // mensajeError('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores');
        // erpalert("error", "Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores");
        console.log(resp);
    });
}
</script>