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
        $("#cant_fact").html(resp.ordenes[0].total_fact);
    }).fail(resp => {}).catch(resp => {
        console.log(resp);
    });
}
</script>