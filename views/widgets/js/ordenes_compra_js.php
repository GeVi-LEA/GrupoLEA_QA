<script>
$(document).ready(function() {
    //console.log("entra en getOC_MES");
    getOC_MES();
    // swal.close();
});

function getOC_MES() {
    $.ajax({
        url: __url__ + '?ajax&controller=Compras&action=getOC_MES',
        method: 'post',
        dataType: "json",
    }).then(resp => {
        // $("#cant_oc").html(resp.ordenes[0].total_oc);
        console.log(resp);
        var html = "";
        for (var x = 0; x < resp.ordenes.length; x++) {
            html += `<div class="col">
                        <div class="card sombra" style="border:none;">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class=" bg-soft-warning rounded p-3">
                                        <span class="material-symbols-outlined text-white" style="font-size:2em; float:right">
                                            shopping_cart_checkout
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-warning counter" style="visibility: visible;float:right;font-size:2em;" id="cant_oc">${resp.ordenes[x].total_oc}</h1>
                                        <p class="text-warning mb-0" style="float:right; font-size:1em;">Ordenes de Compra</p>
                                        <p class="text-warning mb-0" style="float:right; font-size:0.5em;text-align: right;">${resp.ordenes[x].empresa}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;

        }
        $("#oc_pnl").html(html);

    }).fail(resp => {}).catch(resp => {
        console.log(resp);
    });
}
</script>