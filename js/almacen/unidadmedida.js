var base_url;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    $("#nuevoUnidadmedida").click(function(){
        url = base_url+"index.php/almacen/unidadmedida/nueva";
        location.href = url;
    });
    $("#grabarUnidadmedida").click(function(){
        $("#frmUnidadmedida").submit();
    });
    $("#limpiarUnidadmedida").click(function(){
        url = base_url+"index.php/almacen/unidadmedida/listar";
        $("#nombre_unidadmedida").val('');
        $("#simbolo").val('');
        location.href=url;
    });
    $("#cancelarUnidadmedida").click(function(){
        url = base_url+"index.php/almacen/unidadmedida/listar";
        location.href = url;
    });
    $("#buscarUnidadmedida").click(function(){
        $("#form_busquedaUnidadmedida").submit();
    });
});
function editar_unidadmedida(unidadmedida){
	location.href = base_url+"index.php/almacen/unidadmedida/editar/"+unidadmedida;
}
function eliminar_unidadmedida(unidadmedida){
    if(confirm('¿Está seguro que desea eliminar esta unidad de medida?')){
        dataString        = "unidadmedida="+unidadmedida;
        url = base_url+"index.php/almacen/unidadmedida/eliminar";
        $.post(url,dataString,function(data){
            location.href = base_url+"index.php/almacen/unidadmedida/listar";
        });
    }
}
function ver_unidadmedida(unidadmedida){
    location.href = base_url+"index.php/almacen/unidadmedida/ver/"+unidadmedida;
}
function atras_unidadmedida(){
    location.href = base_url+"index.php/almacen/unidadmedida/listar";
}