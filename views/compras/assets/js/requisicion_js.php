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

    $("#tabla_detalle #edit").click(function() {
        rowedit = $(this);
        $("#modal_add").modal("show");
        setTimeout(() => {
            console.log($(this).parent());
            $("#modal_add #descripcion").val($(this).parents("tr").find(".det_descripcion").html()); //
            // $("#modal_add #unidad").val($(this).parents("tr").find(".det_unidad").html()); //td>
            for (var x = 1; x < ("#modal_add #unidad option").length; x++) {
                if ($("#modal_add #unidad option")[x].text == rowedit.parents("tr").find(".det_unidad").html()) {
                    $("#modal_add #unidad").val($("#modal_add #unidad option")[x].value).trigger('change');
                    break;
                }

            }
            $("#modal_add #cantidad").val($(this).parents("tr").find(".det_cantidad").html()); //
            $("#modal_add #pre_unitario").val($(this).parents("tr").find(".det_precio_unitario").html().replace(",", "")); //
            editar = 1;
            $("#btnAgregaDetalle").html("Editar");

        }, 300);

    })





    $(".agregaPop").click(function() {


    });

    $("#btnAgregaDetalle").click(function() {
        console.log("agrega detalle");
        if (editar == 1) {
            actualizaDetalle();
            $("[data-iddetalle=" + rowedit.parents("tr").data("iddetalle") + "] .det_descripcion").html($("#modal_add #descripcion").val());
            $("[data-iddetalle=" + rowedit.parents("tr").data("iddetalle") + "] .det_unidad").html($("#modal_add #unidad option:selected").text());
            $("[data-iddetalle=" + rowedit.parents("tr").data("iddetalle") + "] .det_cantidad").html(numero2Decimales($("#modal_add #cantidad").val(), true));
            $("[data-iddetalle=" + rowedit.parents("tr").data("iddetalle") + "] .det_precio_unitario").html(numero2Decimales($("#modal_add #pre_unitario").val()));
            editar = 0;
            $("#btnAgregaDetalle").html("Agregar");

        } else {
            $("#tabla_detalle tbody").append(`
            <tr>
                <td>${$("#descripcion").val()}</td>
                <td>${$("#unidad option:selected").val()}</td>
                <td>${$("#cantidad").val()}</td>
                <td>${$("#pre_unitario").val()}</td>
                <td>
                    <div>
                        <a id="edit"><span class="material-icons i-edit">edit</span></a>
                        <a id="save" hidden><span class="material-icons i-save">save</span></a>
                        <a id="delete"><span class="material-icons i-delete">delete_forever</span></a>
                    </div>
                </td>
            </tr>`);
        }

    });

});

function actualizaDetalle() {

    // $_POST['id'], $_POST['unidad_id'], $_POST['descripcion'], $_POST['cantidad'], $_POST['precio_unitario']
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
</script>