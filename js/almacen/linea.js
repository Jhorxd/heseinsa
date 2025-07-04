var base_url;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    $("#nuevaLinea").click(function(){
        url = base_url+"index.php/almacen/linea/nueva";
        location.href = url;
    });
    $("#grabarLinea").click(function(){
        $("#frmLinea").submit();
    });
    $("#limpiarLinea").click(function(){
        url = base_url+"index.php/almacen/linea/listar";
        $("#nombre_linea").val('');
        location.href=url;
    });
    $("#cancelarLinea").click(function(){
        url = base_url+"index.php/almacen/linea/listar";
        location.href = url;
    });
    $("#buscarLinea").click(function(){
        $("#form_busquedaLinea").submit();
    });
});
function editar_linea(linea){
	location.href = base_url+"index.php/almacen/linea/editar/"+linea;
}
function eliminar_linea(linea){
    if(confirm('¿Está seguro que desea eliminar esta linea?')){
        dataString        = "linea="+linea;
        url = base_url+"index.php/almacen/linea/eliminar";
        $.post(url,dataString,function(data){
            location.href = base_url+"index.php/almacen/linea/listar";
        });
    }
}
function ver_linea(linea){
    location.href = base_url+"index.php/almacen/linea/ver/"+linea;
}
function atras_linea(){
    location.href = base_url+"index.php/almacen/linea/listar";
}