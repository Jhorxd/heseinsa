var base_url;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    $("#nuevoFabricante").click(function(){
        url = base_url+"index.php/almacen/fabricante/nuevo";
        location.href = url;
    });
    $("#grabarFabricante").click(function(){
        $("#frmFabricante").submit();
    });
    $("#limpiarFabricante").click(function(){
        url = base_url+"index.php/almacen/fabricante/listar";
        $("#nombre_fabricante").val('');
        location.href=url;
    });
    $("#cancelarFabricante").click(function(){
        url = base_url+"index.php/almacen/fabricante/listar";
        location.href = url;
    });
    $("#buscarFabricante").click(function(){
        $("#form_busquedaFabricante").submit();
    });
});
function editar_fabricante(fabricante){
	location.href = base_url+"index.php/almacen/fabricante/editar/"+fabricante;
}
function eliminar_fabricante(fabricante){
    if(confirm('¿Está seguro que desea eliminar este fabricante?')){
        dataString        = "fabricante="+fabricante;
        url = base_url+"index.php/almacen/fabricante/eliminar";
        $.post(url,dataString,function(data){
            location.href = base_url+"index.php/almacen/fabricante/listar";
        });
    }
}
function ver_fabricante(fabricante){
    location.href = base_url+"index.php/almacen/fabricante/ver/"+fabricante;
}
function atras_fabricante(){
    location.href = base_url+"index.php/almacen/fabricante/listar";
}