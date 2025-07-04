var base_url;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    $("#nuevoTipoCliente").click(function(){
        url = base_url+"index.php/ventas/tipocliente/nuevo";
        location.href = url;
    });
    $("#grabarTipoCliente").click(function(){
        $("#frmTipoCliente").submit();
    });
    $("#limpiarTipoCliente").click(function(){
        url = base_url+"index.php/ventas/tipocliente/listar";
        location.href=url;
    });
    $("#cancelarTipoCliente").click(function(){
        url = base_url+"index.php/ventas/tipocliente/listar";
        location.href = url;
    });
    $("#buscarTipoCliente").click(function(){
        $("#form_busquedaTipoCliente").submit();
    });
});
function editar_tipocliente(tipocliente){
	location.href = base_url+"index.php/ventas/tipocliente/editar/"+tipocliente;
}
function eliminar_tipocliente(tipocliente){
    if(confirm('¿Está seguro que desea eliminar esta categoría?')){
        dataString = "tipocliente = "+ tipocliente;
        location.href = base_url+"index.php/ventas/tipocliente/eliminar/"+tipocliente;
        /*$.post(
            url,
            dataString,
            function(data){
                location.href = base_url+"index.php/ventas/tipocliente/listar";
        });*/
    }
}
function ver_tipocliente(tipocliente){
    location.href = base_url+"index.php/ventas/tipocliente/ver/"+tipocliente;
}
function atras_tipocliente(){
    location.href = base_url+"index.php/ventas/tipocliente/listar";
}
