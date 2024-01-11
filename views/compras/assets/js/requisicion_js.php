<script>
var myModal;
var editar = 0;
try {
    if (!__url__) {
        __url__ = localStorage.getItem("_URL_");
    }
} catch (error) {
    __url__ = localStorage.getItem("_URL_");

}

$(document).ready(function() {
    myModal = document.getElementById('modal_add');

    try {

        myModal.addEventListener('shown.bs.modal', () => {
            $("#modal_add input").val("");
            $("#unidad").val("").trigger('change');
            // console.log("QWE");
        });
    } catch (error) {

    }

    setTimeout(() => {
        $("#formRequisicion").find("input").each((i, el) => {
            $(el).val($(el).attr("value"));
        });
        $("input").removeClass("item-small");
    }, 50);

    accionDetalleTabla();







    $(".agregaPop").click(function() {


    });

    $("#btnAgregaDetalle").click(function() {
        console.log("agrega detalle");
        if (editar == 1) {
            try {
                actualizaDetalle();
            } catch (error) {

            }
            $("[data-iddetalle=" + rowedit.parents("tr").data("iddetalle") + "] .det_descripcion").html($("#modal_add #descripcion").val());
            $("[data-iddetalle=" + rowedit.parents("tr").data("iddetalle") + "] .det_unidad").html($("#modal_add #unidad option:selected").text());
            $("[data-iddetalle=" + rowedit.parents("tr").data("iddetalle") + "] .det_cantidad").html(numero2Decimales($("#modal_add #cantidad").val(), true));
            $("[data-iddetalle=" + rowedit.parents("tr").data("iddetalle") + "] .det_precio_unitario").html(numero2Decimales($("#modal_add #pre_unitario").val()));
            editar = 0;
            $("#btnAgregaDetalle").html("Agregar");

        } else {
            $("#tabla_detalle tbody").append(`
            <tr data-iddetalle="${($("#tabla_detalle tbody").find("tr").length+1)}">
                <td class="det_descripcion">
                    <input type="hidden" 
                    name="descripcion[]" 
                    id="descripcion[]"  
                    value="${$("#descripcion").val()}" />
                    ${$("#descripcion").val()}
                </td>
                <td class="det_unidad">
                    <input type="hidden" 
                    name="unidad[]" 
                    id="unidad[]"  
                    value="${$("#unidad option:selected").val()}" />
                    ${$("#unidad option:selected").text()}
                </td>
                <td class="det_cantidad">
                    <input type="hidden" 
                    name="cantidad[]" 
                    min="0" 
                    id="cantidad[]" 
                    value="${$("#cantidad").val()}"  />
                    ${$("#cantidad").val()}
                    </td>
                <td class="det_precio_unitario">
                    <input type="hidden" 
                    name="precioUnitario[]" 
                    min="0" 
                    id="precioUnitario[]"  
                    value="${$("#pre_unitario").val()}" />
                    ${$("#pre_unitario").val()}
                    </td>
                <td>
                    <input type="hidden" id="idDetalle[]" name="idDetalle[]" />
                    <div>
                        <a id="edit"><span class="material-icons i-edit">edit</span></a>
                        <a id="save" hidden><span class="material-icons i-save">save</span></a>
                        <a id="delete"><span class="material-icons i-delete">delete_forever</span></a>
                    </div>
                </td>
            </tr>`);
        }
        setTimeout(() => {
            accionDetalleTabla();
        }, 1000);


    });

    $("#descProducto").click(function() {
        var html = `<form id="formProducto">
                        <div class="container">
                            <div class="row d-flex mb-2">
                                <div class="w-25 text-right pr-1"><label for="producto">Producto:</label></div>
                                <div>
                                    <select name="producto" class="item-big" id="producto">
                                        <option value="" selected disabled>--Selecciona--</option>
                                        <?php
                                            $productos = Utils::getProductos();
                                            if (!empty($productos)):
                                                foreach ($productos as $pro):
                                        ?>
                                        <option value="<?= $pro->id ?>"><?= $pro->nombre . ' (' . $pro->nombre_refineria . ')' ?></option>
                                        <?php
                                                endforeach;
                                            endif;
                                                                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-flex mb-2">
                                <div class="w-25 text-right pr-1"><label for="transporteProducto">Transporte:</label></div>
                                <div>
                                    <?php $carrTanque = Utils::getCarroTanque() ?>
                                    <input class="ml-2" type="radio" name="transporteProducto" id="transporteProducto" value="<?= $carrTanque->id ?>"
                                        <?= isset($req) && $req['transporte_id'] == $carrTanque->id ? 'checked' : 'checked' ?> /> <label><?= $carrTanque->nombre ?></label>
                                    <input class="ml-2" type="radio" name="transporteProducto" id="transporteProducto" value="1" <?= isset($req) && $req['transporte_id'] != $carrTanque->id ? 'checked' : '' ?> />
                                    <label>Pipa</label>
                                </div>
                            </div>
                            <div class="row d-flex mb-2">
                                <div class="w-25 text-right pr-1"><label for="cantidadPro">Cantidad:</label></div>
                                <div><input type="text" id="cantidadPro" name="cantidadPro" value="" class="item-medium" placeholder="Ej. 5"></span></div>
                            </div>
                            <div class="row d-flex mb-2">
                                <div class="w-25 text-right pr-1"><label for="tipoFlete">Tipo flete:</label></div>
                                <div>
                                    <select name="tipoFlete" class="item-big" id=" tipoFlete">
                                        <option value="" selected disabled>--Selecciona--</option>
                                        <?php
                                            foreach (tipoFlete as $k => $v):
                                        ?>
                                        <option value="<?= $k ?>"><?= $v ?></option>
                                        <?php
                                            endforeach;
                                                                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-flex mb-2" id="divRutaProducto">
                                <div class="w-25 text-right pr-1"><label for="rutaProducto">Ruta:</label></div>
                                <div>
                                    <select name="rutaProducto" class="item-big" id=" rutaProducto">
                                        <option value="0" selected>--Selecciona--</option>
                                        <?php
                                            $rutas = Utils::getRutasKansas();
                                            if (!empty($rutas)):
                                                foreach ($rutas as $r):
                                        ?>
                                        <option value="<?= $r->id ?>"><?= $r->ciudad_or . ' - ' . $r->ciudad_des ?></option>
                                        <?php
                                                endforeach;
                                            endif;
                                                                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-flex mb-2" id="divAduanaProducto">
                                <div class="w-25 text-right pr-1"><label for="aduana">Aduana:</label></div>
                                <div>
                                    <select name="aduana" class="item-big" id=" aduana">
                                        <option value="0" selected>--Selecciona--</option>
                                        <?php
                                            $aduanas = Utils::getAduanas();
                                            if (!empty($aduanas)):
                                                foreach ($aduanas as $a):
                                        ?>
                                        <option value="<?= $a->id ?>"><?= $a->clave ?></option>
                                        <?php
                                                endforeach;
                                            endif;
                                                                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-flex">
                                <div class="w-25 text-right pr-1"><label for="cliente">Cliente:</label></div>
                                <div>
                                    <select name="clienteProd" class="item-big" id=" clienteProd">
                                        <option value="0" selected>--Selecciona--</option>
                                        <?php
                                            $clientes = Utils::getClientes();
                                            if (!empty($clientes)):
                                                foreach ($clientes as $c):
                                        ?>
                                        <option value="<?= $c->id ?>"><?= $c->nombre ?></option>
                                        <?php
                                                endforeach;
                                            endif;
                                                                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    `;

        Swal.fire({
            title: '<span class="material-icons fas fa-flask pr-3"></span>Agregar producto',
            html: html,
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "Agregar",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                if (validarFormProductos()) {
                    var producto = $("#producto option:selected").text();
                    var transporte = $("#transporteProducto:checked").next("label").html();
                    var cantidad = $("#cantidadPro").val();
                    if (!isNumeric(cantidad)) {
                        var desc = $("#tablaDescripcion").find("input[id='descripcion[1]'");
                        if ($(desc).val() != "") {
                            $(desc)
                                .val("(" + cantidad + " " + transporte + ") " + producto)
                                .attr("readOnly", true);
                        } else {
                            $("#descEspecif")
                                .val("(" + cantidad + " " + transporte + ") " + producto)
                                .attr("readOnly", true);
                        }
                        $("#idProducto").val($("#producto").val());
                        $("#idTransporte").val($("#transporteProducto:checked").val());
                        $("#flete").val($("#tipoFlete").val());
                        $("#cantidadFlete").val(cantidad);
                        $(this).attr("data-dismiss", "modal");
                        //$("#tabla_detalle tbody").append(`
                        //                                    <tr data-iddetalle="${($("#tabla_detalle tbody").find("tr").length+1)}">
                        //                                        <td class="det_descripcion"><input class="item-x-big" type="text" name="descripcion[${($("#tabla_detalle tbody").find("tr").length+1)}]" id="descripcion[${($("#tabla_detalle tbody").find("tr").length+1)}]" disabled value="${"(" + cantidad + " " + transporte + ") " + producto}" /></td>
                        //                                        <td class="det_unidad" name="unidad[]" id="unidad[${($("#tabla_detalle tbody").find("tr").length+1)}]">${$("#unidad option:selected").val()}</td>
                        //                                        <td class="det_cantidad"><input class="item-small" type="text" name="cantidad[${($("#tabla_detalle tbody").find("tr").length+1)}]" min="0" id="cantidad[${($("#tabla_detalle tbody").find("tr").length+1)}]" value="${cantidad}" disabled /></td>
                        //                                        <td class="det_precio_unitario"><input class="item-medium" type="text" name="precioUnitario[${($("#tabla_detalle tbody").find("tr").length+1)}]" min="0" id="precioUnitario[${($("#tabla_detalle tbody").find("tr").length+1)}]" disabled  /></td>
                        //
                        //                                        <td>
                        //                                            <div>
                        //                                                <a id="edit"><span class="material-icons i-edit">edit</span></a>
                        //                                                <a id="save" hidden><span class="material-icons i-save">save</span></a>
                        //                                                <a id="delete"><span class="material-icons i-delete">delete_forever</span></a>
                        //                                            </div>
                        //                                        </td>
                        //                                    </tr>`);
                        $("#tabla_detalle tbody").append(`
                                                            <tr data-iddetalle="${($("#tabla_detalle tbody").find("tr").length+1)}">
                                                                <td class="det_descripcion">
                                                                    <input type="hidden" 
                                                                    name="descripcion[]" 
                                                                    id="descripcion[]"  
                                                                    value="${"(" + cantidad + " " + transporte + ") " + producto}" />
                                                                    ${"(" + cantidad + " " + transporte + ") " + producto}
                                                                </td>
                                                                <td class="det_unidad">
                                                                    <input type="hidden" 
                                                                    name="unidad[]" 
                                                                    id="unidad[]"  
                                                                    value="${$("#unidad option:selected").val()}" />
                                                                    ${$("#unidad option:selected").text()}
                                                                </td>
                                                                <td class="det_cantidad">
                                                                    <input type="hidden" 
                                                                    name="cantidad[]" 
                                                                    min="0" 
                                                                    id="cantidad[]" 
                                                                    value="${cantidad}"  />
                                                                    ${cantidad}
                                                                    </td>
                                                                <td class="det_precio_unitario">
                                                                    <input type="hidden" 
                                                                    name="precioUnitario[]" 
                                                                    min="0" 
                                                                    id="precioUnitario[]"  
                                                                    value="" />
                                                                    
                                                                    </td>
                                                                <td>
                                                                    <input type="hidden" id="idDetalle[]" name="idDetalle[]"  />
                                                                    <div>
                                                                        <a id="edit"><span class="material-icons i-edit">edit</span></a>
                                                                        <a id="save" hidden><span class="material-icons i-save">save</span></a>
                                                                        <a id="delete"><span class="material-icons i-delete">delete_forever</span></a>
                                                                    </div>
                                                                </td>
                                                            </tr>`);

                        setTimeout(() => {
                            accionDetalleTabla();
                        }, 1000);
                    } else {
                        $(this).removeAttr("data-dismiss", "modal");
                        mensajeError("Cantidad debe ser numero");
                    }
                } else {
                    $(this).removeAttr("data-dismiss", "modal");
                    mensajeError("Debe completar todos los datos.");
                }
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });

        /*
        $("#btnProducto").click(function (e) {
		
	});
    */
    });
});

function actualizaDetalle() {

    // $_POST['id'], $_POST['unidad_id'], $_POST['descripcion'], $_POST['cantidad'], $_POST['precio_unitario']
    if (getUrlParameter('id') == "0") {
        // PASA PORQUE EL REGISTRO ES NUEVO
    } else {
        $.ajax({
            data: {
                id: rowedit.parents("tr").data("iddetalle"),
                unidad_id: $("#modal_add #unidad option:selected").val(),
                descripcion: $("#modal_add #descripcion").val(),
                cantidad: $("#modal_add #cantidad").val(),
                precio_unitario: $("#modal_add #pre_unitario").val()
            },
            url: __url__ + "?ajax&controller=Compras&action=editarDetalleReq",
            type: "POST",
            dataType: "json",
            success: function(resp) {
                console.log("resp: ");
                console.log(resp);

            },
            error: function(err) {
                console.log("err: ");
                console.log(err);
                alert(
                    "Algo salio mal, no se pudo eliminar, contacte al administrador del sistema"
                );
            },
        });
    }
}

function validarFormProductos() {
    var inputs = $("#formProducto").find("select, input");
    var valid = true;
    inputs.each(function() {
        if ($(this).val() == null || $(this).val() == "") {
            $(this).addClass("required");
            valid = false;
        }
    });
    return valid;
}

function accionDetalleTabla() {

    $("#tabla_detalle #edit").unbind();
    $("#tabla_detalle #edit").click(function() {
        rowedit = $(this);
        $("#modal_add").modal("show");
        setTimeout(() => {
            console.log("$(this).parent()");
            console.log($(this).parent());
            $("#modal_add #descripcion").val($(this).parents("tr").find(".det_descripcion").find("input").val()); //
            // $("#modal_add #unidad").val($(this).parents("tr").find(".det_unidad").html()); //td>
            try {
                for (var x = 1; x < ("#modal_add #unidad option").length; x++) {
                    if ($("#modal_add #unidad option")[x].value == rowedit.parents("tr").find(".det_unidad").find("input").val()) {
                        $("#modal_add #unidad").val($("#modal_add #unidad option")[x].value).trigger('change');
                        break;
                    }
                }
            } catch (error) {}
            console.log($(this).parents("tr"));
            $("#modal_add #cantidad").val($(this).parents("tr").find(".det_cantidad").find("input").val()); //
            $("#modal_add #pre_unitario").val($(this).parents("tr").find(".det_precio_unitario").find("input").val().replace(",", "")); //
            editar = 1;
            $("#btnAgregaDetalle").html("Editar");

        }, 300);

    })

}

function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}
</script>