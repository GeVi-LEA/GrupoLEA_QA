<script>
var series_estatus = [];
var detalle_lotes = {};
var datosGrafica = <?= json_encode($datosGrafica) ?>;
var arrayIdsTr = <?= json_encode($arrayIdsTr) ?>;
var data_estatus = [];
var data_colores = [];
$(document).ready(function() {

    $("#div-lista").hide()
    $("#div-grafica").show();
    chart_productos();

    $(".btn-tab").unbind();
    $(".btn-tab").click(function() {
        showLoading_global();

        var tipo = $(this).data("tipo");
        switch (tipo) {
            case 'grafica':
                $("#div-lista").hide()
                $("#div-grafica").show()
                break;

            default:
                $("#div-lista").show()
                $("#div-grafica").hide()

                break;
        }
        setTimeout(() => {
            chart_productos();
        }, 1000);
    });

    $('#tabEntradas a').unbind();
    $('#tabEntradas a').on('click', function(e) {
        // console.log($(this)[0].id.replace("-tab", ""));
        showLoading_global();
        setTimeout(() => {
            chart_productos();
        }, 1000);
        // console.log($(this)[0].id);
    });

    setInterval(() => {
        if (!$(".swal2-html-container").is(":visible")) {
            llenatablaestatus(datosGrafica[0].estatus_id, datosGrafica[0].estatus, datosGrafica[0].clave)
            setTimeout(() => {
                chart_productos();
                llenatablaestatus(datosGrafica[0].estatus_id, datosGrafica[0].estatus, datosGrafica[0].clave);
            }, 1000);
        }
    }, 60000);
});
const chart_productos = () => {

    //import * as echarts from 'echarts';
    // console.log($("#chart_entradas"));
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
            top: '5%',
            left: 'center'
        },
        series: [{
            name: 'Entradas',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            selectedMode: 'single',
            itemStyle: {
                borderRadius: 10,
                borderColor: '#fff',
                borderWidth: 2
            },
            label: {
                show: true,
                position: 'right',
                formatter: '{b}：{{c}}  {d}%'
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
                show: false
            },
            color: data_colores, //["#7a7a7a", "#b5b228", "##1b8a05", "#d8813a", "#dad73f", "#2501a5", "#e4a700"],
            data: data_estatus,

        }]
    };
    option && myChart.setOption(option);
    myChart.on('click', function(params) {
        // Print name in console
        // console.log("estatus_id:", params.data.id);
        llenatablaestatus(params.data.id, params.data.name, params.data.clave);
    });
    swal.close();

}
var html = "";
var servicios;
var table;

function llenatablaestatus(id_estatus, estatus, clave) {
    $("#tituloestatus").html("");
    jQuery.ajax({
        url: __url__ + '?ajax&controller=Servicios&action=getUnidadesEstatus',
        data: {
            id_estatus: id_estatus
        },
        method: 'post',
        dataType: "json",
    }).then(resp => {
        // console.log(resp);
        servicios = resp;
        datosGrafica = resp.datosGrafica;
        html = "";
        for (var x = 0; x < resp.servicios.length; x++) {
            html += `
                <tr>
                    <td id="" hidden>${resp.servicios[x].id}</td>
                    <td id="idEnsacado" hidden>${resp.servicios[x].id}</td>
                    <td class="w-td-30 p-0 m-0">
                        <span id="showEnsacado" class="material-icons i-recibir">${((jQuery.inArray(resp.servicios[x].tipo_transporte_id, arrayIdsTr)) >=0) ? 'directions_subway' : 'local_shipping'}</span>
                        <strong>${getOperacionServicios(resp.servicios[x].servicio)}</strong>    
                    </td>

                    <td class="px-0 mx-0"><strong>${resp.servicios[x].numUnidad}</strong></td>
                    <td><span>${resp.servicios[x].nombreCliente}</span></td>
                    <td>${resp.servicios[x].fecha_entrada == null ? '' : moment(resp.servicios[x].fecha_entrada).format("DD/MM/YYYY hh:mm:ss")}</td>
                </tr>       `

        }
        $("#tituloestatus").html(estatus).removeClass().addClass(getClaseEstado(clave));
        $("#tabla_estatus tbody").html("");
        // $('#tabla_estatus').DataTable().clear().destroy();
        $("#tabla_estatus tbody").html(html);
        new DataTable('#tabla_estatus', {
            dom: 'Bfrtip',
            retrieve: true,
            language: {
                url: '<?php echo URL; ?>assets/libs/datatables/es-MX.json',
            },
            order: [
                [5, 'desc']
            ],
            columns: [null, null, {
                    "width": "5%"
                },
                {
                    "width": "15%"
                },
                {
                    "width": "50%"
                },
                {
                    "width": "30%"
                },
            ],
            buttons: [
                'print',
                {
                    extend: 'excelHtml5',
                    // className: 'btn btnExcel',
                    title: `Reporte de entradas ${estatus} ${formatDate(new Date())}`
                },
                'pdf',
            ],
        });

    }).fail(resp => {}).catch(resp => {
        mensajeError('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores');
    });
}
</script>