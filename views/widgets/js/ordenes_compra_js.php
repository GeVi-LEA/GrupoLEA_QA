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
        $("#cant_oc").html(resp.ordenes[0].total_oc);
    }).fail(resp => {}).catch(resp => {
        console.log(resp);
    });
}
</script>