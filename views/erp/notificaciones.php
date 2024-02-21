<?php
require_once models_root . 'erp/notificaciones.php';
$notificaciones = new Notificaciones();

function getNotificaciones()
{
    $notificaciones             = new Notificaciones();
    $_SESSION['notificaciones'] = $notificaciones->getNotificacionesByUserId($_SESSION['usuario']->id);
    return $_SESSION['notificaciones'];
    // echo json_encode(["mensaje" => "OK", "_notificaciones" => $_notificaciones]);
    // require views_root.'erp/notificaciones.php';
}

?>

<script>
let var_notificaciones;
let cant_unseen = 0;

function difHoras(fecha) {
    var FutureDate = new Date(fecha);
    var TodayDate = new Date();
    var t1 = FutureDate.getTime();
    var t2 = TodayDate.getTime();
    var diffInHours = Math.floor((t2 - t1) / (3600 * 1000)); //Removed the 24 here
    let diferencia = difference2Parts(new Date() - new Date(fecha));
    let regreso = "";
    if (diferencia.hours > 0) {
        regreso += diferencia.hours + " horas ";
    }
    if (diferencia.minutes > 0) {
        regreso += diferencia.minutes + " minutos ";
    }
    return regreso;
}

function difference2Parts(milliseconds) {
    const secs = Math.floor(Math.abs(milliseconds) / 1000);
    const mins = Math.floor(secs / 60);
    const hours = Math.floor(mins / 60);
    const days = Math.floor(hours / 24);
    const millisecs = Math.floor(Math.abs(milliseconds)) % 1000;
    const multiple = (term, n) => n !== 1 ? `${n} ${term}s` : `1 ${term}`;

    return {
        days: days,
        hours: hours % 24,
        hoursTotal: hours,
        minutesTotal: mins,
        minutes: mins % 60,
        seconds: secs % 60,
        secondsTotal: secs,
        milliSeconds: millisecs,
        get diffStr() {
            return `${multiple(`day`, this.days)}, ${
        multiple(`hour`, this.hours)}, ${
        multiple(`minute`, this.minutes)} and ${
        multiple(`second`, this.seconds)}`;
        },
        get diffStrMs() {
            return `${this.diffStr.replace(` and`, `, `)} and ${
        multiple(`millisecond`, this.milliSeconds)}`;
        },
    };
}

function deleteNotificacion(id_not = 0) {
    jQuery.ajax({
        url: __url__ + '?ajax&controller=Notificaciones&action=getNotificaciones',
        data: {
            opc: "deleteNotification",
            id_not: id_not
        },
        method: 'post',
        dataType: "json",
    }).then(resp => {
        console.log(resp);
    }).fail(resp => {
        console.log(resp);
    }).catch(resp => {
        swal.fire('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores', {
            icon: 'error'
        });
    });
    console.log("se eliminó notificacion");
    llamaNotificaciones();
}

function seenNotificacion(id_not = 0) {
    jQuery.ajax({
        url: __url__ + '?ajax&controller=Notificaciones&action=getNotificaciones',
        data: {
            opc: "seenNotification",
            id_not: id_not
        },
        method: 'post',
        dataType: "json",
    }).then(resp => {
        console.log(resp);
    }).fail(resp => {
        console.log(resp);
    }).catch(resp => {
        swal.fire('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores', {
            icon: 'error'
        });
    });
    console.log("se leyó notificacion");

    llamaNotificaciones();
}

function llamaNotificaciones() {
    jQuery.ajax({
        url: __url__ + '?ajax&controller=Notificaciones&action=getNotificaciones',
        data: {
            opc: "getNotificacionesIndex"
        },
        method: 'POST',
        dataType: "json",
        // jQuery.ajax({
        // url: "?ajax&controller=Notificaciones&action=getNotificaciones", //url: "<?php echo URL; ?>/views/master/index.php",
        // data: {
        // "opc": "getNotificaciones"
        // },
        // method: 'POST',
        // dataType: "json",
    }).then(resp => {
        // console.log(resp);
        var_notificaciones = resp.notificaciones;
        $(".notificaciones-lista").html("");
        if (var_notificaciones.length > 0) {
            let html = "";
            cant_unseen = 0;
            for (x = 0; x < ((var_notificaciones.length > 4) ? 4 : var_notificaciones.length); x++) {
                // console.log(var_notificaciones[var_notificaciones.length - x].titulo);
                if (var_notificaciones[x].status == 2) {
                    cant_unseen++;
                }
                // <div class="col-2">
                //   <i class="fa fa-file warning font-large-2 float-left"></i>
                //   <span class="material-symbols-outlined"></span>
                // </div>
                html += `
                            <div class="text-reset notification-item">
                                <div class="card status${var_notificaciones[(x)].status}">
                                          <div class="card-content">
                                                <div class="card-body">
                                                      <div class="row">
                                                            
                                                            <div class="col-12">
                                                                  <div class="row">
                                                                        <div class="col-12">
                                                                              <h6>${var_notificaciones[(x)].titulo}</h6>
                                                                        </div>
                                                                        <div class="col-12">
                                                                              <span>${var_notificaciones[(x)].mensaje}</span>
                                                                        </div>
                                                                  </div>
                                                                  <div class="row">
                                                                        <div class=col12">
                                                                              <time class="media-meta text-muted" datetime="${var_notificaciones[(x)].fecha_creacion}">hace ${difHoras(var_notificaciones[(x)].fecha_creacion)}</time>
                                                                              <ul class="list-inline mb-0">
                                                                                    <li>
                                                                                          <i class="material-icons seen_noti" data-toggle="tooltip" data-placement="top" title="Marcar como leído" data-id_not="${var_notificaciones[(x)].id}">visibility_off</i>
                                                                                          <i class="material-icons delete_noti" data-toggle="tooltip" data-placement="top" title="Borrar" data-id_not="${var_notificaciones[(x)].id}">delete</i>
                                                                                    </li>
                                                                              </ul>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                </div>
                                
                            </div>
                              `
            }
            $(".notificaciones-lista").html(html);
            if (cant_unseen > 0) {
                localStorage.getItem("notif");
                $(".noti-dot").show();
                if (((localStorage.getItem("notif") != "") ? localStorage.getItem("notif") : 0) < cant_unseen) {
                    setTimeout(() => {
                        erpalert("info", title = var_notificaciones[0].titulo, var_notificaciones[0].mensaje, "10000");
                    }, 2000);
                }
                localStorage.setItem("notif", cant_unseen);
                $(".noti-dot").html(cant_unseen);
            } else {
                $(".noti-dot").hide();
            }
        } else {
            $(".noti-dot").hide();
        }
        $(".seen_noti").unbind();
        $(".seen_noti").click(function(e) {
            console.log("seen_noti:", this.getAttribute("data-id_not"));
            seenNotificacion(this.getAttribute("data-id_not"));
            localStorage.setItem("notif", cant_unseen - 1);
        });
        $(".delete_noti").unbind();
        $(".delete_noti").click(function(e) {
            console.log("delete_noti:", this.getAttribute("data-id_not"));
            deleteNotificacion(this.getAttribute("data-id_not"));
            localStorage.setItem("notif", cant_unseen - 1);
        });
        $(".todoleido").unbind();
        $(".todoleido").click(function(e) {
            for (x = 0; x < var_notificaciones.length; x++) {
                seenNotificacion(var_notificaciones[x].id);
                localStorage.setItem("notif", cant_unseen - 1);
            }
        });
        $(".tododelete").unbind();
        $(".tododelete").click(function(e) {

            for (x = 0; x < var_notificaciones.length; x++) {
                deleteNotificacion(var_notificaciones[x].id);
                localStorage.setItem("notif", cant_unseen - 1);
            }


        });


    }).fail(function(xhr, textStatus, errorThrown) {
        console.log("fail"); //{}resp =>
        console.log("textStatus: ", textStatus, " errorThrown: ", errorThrown);
    }).catch(resp => {
        Swal.fire({
            icon: 'error',
            text: 'Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores'
        });
        //console.log(resp);

    });

    setTimeout(() => {
        llamaNotificaciones();
    }, 60000);

}

function llamaNotificaciones2() {
    <?php

        $_SESSION['notificaciones'] = $notificaciones->getNotificacionesByUserId($_SESSION['usuario']->id);
        //      print_r('<pre>');
        //      print_r($_SESSION['notificaciones']);
        //      print_r('</pre>');

    ?>

    var_notificaciones = jQuery.parseJSON('<?php if (!empty($_SESSION['notificaciones'])) { echo json_encode($_SESSION['notificaciones']); } ?>');
    console.log('entra: ', var_notificaciones);

    if (var_notificaciones.length > 0) {
        localStorage.getItem("notif");
        $(".noti-dot").show();
        if (((localStorage.getItem("notif") != "") ? localStorage.getItem("notif") : 0) < var_notificaciones.length) {
            erpalert("", title = var_notificaciones[0].titulo, var_notificaciones[0].mensaje);
        }
        localStorage.setItem("notif", var_notificaciones.length);
        $(".noti-dot").html(var_notificaciones.length);
        let html = "";
        for (x = 0; x < ((var_notificaciones.length > 4) ? 4 : var_notificaciones.length); x++) {
            // console.log(var_notificaciones[var_notificaciones.length - x].titulo);
            html += `

                  <a href="javascript:void(0)" class="text-reset notification-item">
                        <div class="card status${var_notificaciones[(x)].status}">
                              <div class="card-content">
                                    <div class="card-body">
                                          <div class="row">
                                                <div class="col-2">
                                                      <i class="ft-file warning font-large-2 float-left"></i>
                                                      <span class="material-symbols-outlined"></span>
                                                </div>
                                                <div class="col-10">
                                                      <div class="row">
                                                            <div class="col-12">
                                                                  <h6>${var_notificaciones[(x)].titulo}</h6>
                                                            </div>
                                                            <div class="col-12">
                                                                  <span>${var_notificaciones[(x)].mensaje}</span>
                                                            </div>
                                                      </div>
                                                      <div class="row">
                                                            <div class=col12">
                                                                  <time class="media-meta text-muted" datetime="${var_notificaciones[(x)].fecha_creacion}">hace ${difHoras(var_notificaciones[(x)].fecha_creacion)}</time>
                                                                  <ul class="list-inline mb-0">
                                                                        <li><i class="material-icons" data-id_not="${var_notificaciones[(x)].id}">visibility_off</i></li>
                                                                        <li><i class="material-icons" data-id_not="${var_notificaciones[(x)].id}">delete</i></li>
                                                                  </ul>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>

                  </a>
                  `
        }
        $(".notificaciones-lista").html(html);
    } else {
        $(".noti-dot").hide();
    }

    /*<a href="#!" class="text-reset notification-item">
          <div class='card status${var_notificaciones[(x)].status}'>

                <div class='card-header2'>
                      <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                  <li><i class="la-eye-slash"></i></li>
                                  <li><i class="la-trash"></i></li>
                            </ul>
                      </div>
                </div>
                <div class='card-content text-center'>
                      <div class='card-body p-0'>
                            <h4 class='card-title'>${var_notificaciones[(x)].titulo}</h4>
                            <h6 class='card-subtitle text-muted'>${difHoras(var_notificaciones[(x)].fecha_creacion)} horas atrás</h6>
                            ${var_notificaciones[(x)].mensaje}
                      </div>
                </div>
          </div>
    </a>*/

    // */
    // <div class="card">
    //
    // <div class="card-content">
    //
    // <div class="card-body">
    //
    // <div class="media d-flex">
    //
    // <div class="align-self-center">
    //
    // <i class="la la-comment warning font-large-2 float-left"></i>
    //
    // </div>
    //
    // <div class="media-body text-right">
    //
    // <h4 class='card-title'>${var_notificaciones[(x)].titulo}</h4>
    //
    // <h6>${difHoras(var_notificaciones[(x)].fecha_creacion)} horas atrás</h6>
    //
    // <span>${var_notificaciones[(x)].mensaje}</span>
    //
    // </div>
    //
    // </div>
    //
    // </div>
    //
    // </div>
    //
    // </div>

    // <div class='card text-center'>
    // <div class='card-content'>
    // <div class='card-header text-rigth'><i class="ft-eye"></i></div>
    // <div class='card-body p-0'>
    // <h4 class='card-title'>${var_notificaciones[(x)].titulo}</h4>
    // <h6 class='card-subtitle text-muted'>${difHoras(var_notificaciones[(x)].fecha_creacion)} horas atrás</h6>
    // ${var_notificaciones[(x)].mensaje}
    // </div>
    // </div>
    // </div>
    // <div class="d-flex">
    // <div class="flex-shrink-0 me-3">
    // <img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-sm" alt="user-pic">
    // </div>
    // <div class="flex-grow-1">
    // <h6 class="mb-1">James Lemire</h6>
    // <div class="font-size-13 text-muted">
    // <p class="mb-1">${var_notificaciones[var_notificaciones.length - 1].titulo}</p>
    // <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>${difHoras(var_notificaciones[var_notificaciones.length - 1].fecha_creacion)}</span></p>
    // </div>
    // </div>
    // </div>
    // */
    //console.log("lasnotificaciones: ");
    // jQuery.ajax({
    // url: "<?php echo URL; ?>/controllers/NotificacionesController.php",
    // data: {
    // opc: "getNotificaciones"
    // },
    // method: 'POST',
    // dataType: "json",
    // }).then(resp => {
    // console.log($resp);
    // }).fail(resp => {}).catch(resp => {
    // swal('Ocurrio un problema en la peticion en el servidor, favor de reportar a los administradores', {
    // icon: 'error'
    // });
    // 
    // });
}
</script>