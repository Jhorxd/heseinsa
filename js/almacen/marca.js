var base_url;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    $("#nuevaMarca").click(function(){
        url = base_url+"index.php/almacen/marca/nuevo";
        location.href = url;
    });
    $("#grabarMarca").click(function(){
        if ( $("#codigo_usuario").val() == "" ){
            alert("El abreviado de la marca es requerido.")
            return null;
        }
        else
            $("#frmMarca").submit();
    });
    $("#limpiarMarca").click(function(){
        url = base_url+"index.php/almacen/marca/listar";
        $("#nombre_marca").val('');
        location.href=url;
    });
    $("#cancelarMarca").click(function(){
        url = base_url+"index.php/almacen/marca/listar";
        location.href = url;
    });
    $("#buscarMarca").click(function(){
        $("#form_busquedaMarca").submit();
    });
});
function editar_marca(marca){
	location.href = base_url+"index.php/almacen/marca/editar/"+marca;
}
function eliminar_marca(marca){
    if(confirm('¿Está seguro que desea eliminar esta marca?')){
        dataString        = "marca="+marca;
        url = base_url+"index.php/almacen/marca/eliminar";
        $.post(url,dataString,function(data){
            location.href = base_url+"index.php/almacen/marca/listar";
        });
    }
}
function ver_marca(marca){
    location.href = base_url+"index.php/almacen/marca/ver/"+marca;
}
function atras_marca(){
    location.href = base_url+"index.php/almacen/marca/listar";
}