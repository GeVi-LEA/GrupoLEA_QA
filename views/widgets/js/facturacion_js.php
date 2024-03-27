<script>
$(document).ready(function() {
    //console.log("entra en getOC_MES");
    getFact_MES();
    // swal.close();
});

function getFact_MES() {
    $.ajax({
        url: __url__ + '?ajax&controller=Compras&action=getFact_MES',
        method: 'post',
        dataType: "json",
    }).then(resp => {
        // $("#cant_oc").html(resp.ordenes[0].total_oc);
        var html = "";
        console.log(resp);
        for (var x = 0; x < resp.ordenes.length; x++) {
            html += `<div class="col">
                        <div class="card sombra" style="border:none;">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class=" bg-soft-success rounded p-3">
                                        <span class="material-symbols-outlined text-white" style="font-size:2em; float:right">
                                            price_change
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-success counter" style="visibility: visible;float:right;font-size:2em;" id="cant_fact">${resp.ordenes[x].total_fact}</h1>
                                        <p class="text-success mb-0 mt-1" style="font-size:1em;     text-align: right;">Facturación</p>
                                        <p class="text-success mb-0" style="float:right; font-size:0.5em;   text-align: right;">${resp.ordenes[x].empresa}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;

        }
        $("#fact_pnl").html(html);

    }).fail(resp => {}).catch(resp => {
        console.log(resp);
    });
}
</script>