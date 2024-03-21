<script src="<?php echo URL; ?>/assets/libs/daterangepicker/daterangepicker.js" type="text/javascript"></script>

<script>
if (typeof __url__ !== "undefined" && __url__) {
    // vriable is set and isnt falsish so it can be used;
} else {
    __url__ = localStorage.getItem("_URL_");
}
const serv = __url__;
let clientes = [];
let clientes_id = [];
let servicios_ens;
let table;
let llenaclientes = 0;
var series_servicios = [];

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
    $("#fechas-startend").val(moment(startDate).format("YYYY-MM-DD") + "|" + datahoyparse);


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
        $("#fechas-startend").val(start + "|" + end);
        buscaServicios();
        llenaclientes = 0;
    });
    $("#cmbClientes").find("option").remove();
    $("#cmbClientes").select2({
        placeholder: 'Todos los clientes',
        width: 'resolve'
    });
    $("#cmbClientes").change(function() {
        buscaServicios();
    });
    buscaServicios();
});



const buscaServicios = () => {
    // showLoading_global();
    clientes = [];
    clientes_id = [];

    jQuery.ajax({
        url: __url__ + '?ajax&controller=Servicios&action=getServicios',
        data: {
            clientes: $("#cmbClientes").val().join(", "),
            fechas: $("#rangoFechas").val()
        },
        method: 'POST',
        dataType: "json",
    }).then(resp => {
        servicios_ens = resp;
        for (x = 0; x < servicios_ens.servicios.length; x++) {
            if (clientes.indexOf(servicios_ens.servicios[x].nom_cliente) < 0) {
                clientes.push(servicios_ens.servicios[x].nom_cliente);
                clientes_id.push(servicios_ens.servicios[x].id_cliente);
            }
        }

        for (l = 0; l < clientes.length; l++) {
            // console.log(clientes[l]);
            if (llenaclientes == 0) {
                $("#cmbClientes").append('<option value="' + clientes_id[l] + '">' + clientes[l] + '</option>');

            }
        }
        llenaclientes = 1;
        chart_servicios();

    }).fail(resp => {}).catch(resp => {
        // erpalert("error", "Ocurrió un error al consultar los servicios");
        console.log(resp);
        swal.close();
    });

}

const exportPDF = (Clientes, rangoFechas) => {
    // console.log("Clientes: ", Clientes);
    // console.log("rangoFechas: ", rangoFechas);

    window.open(serv + "?controller=Servicios&action=imprimirReporteServicios&fechas=" + rangoFechas + "&clientes=" + Clientes, "Imprimir servicio", "width=1300,height=600");

}

const chart_servicios = () => {

    //import * as echarts from 'echarts';
    // $("#chart_clientes").attr("style", "height:" + (naves.length * 200) + "px");
    // $("#chart_nave").html("").attr("_echarts_instance_", "");
    $("#chart_clientes").html("").attr("_echarts_instance_", "");
    console.log($("#chart_clientes"));
    var chartDom = document.getElementById('chart_clientes');
    var myChart = echarts.init(chartDom);
    var option;
    series_servicios = [];
    $.each(servicios_ens.servicios_grafica, function(idx, obj) {
        //console.log((idx, obj))
        series_servicios.push({
            name: obj.nom_cliente,
            type: 'bar',
            stack: 'total',
            label: {
                show: true,
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
            color: obj.colorweb,
            data: [obj.cantidad]
        });
    });

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
            data: ['Servicios'], //legends_lotes //['LT45654', 'ABC1', 'ABC2', '678']
        },
        series: series_servicios

    };

    option && myChart.setOption(option);
    //    myChart.unbind();
    myChart.on('click', function(params) {
        // Print name in console
        //console.log(params);
        /*obtiene detalles*/
        // abreDetalle(params.seriesName, "null", "null", params.name);
    });
    setTimeout(() => {
        buscaServicios();
    }, 30000);
}
</script>