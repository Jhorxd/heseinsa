var base_url;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    $("#nuevoAlmacen").click(function(){
        url = base_url+"index.php/almacen/almacen/nuevo";
        location.href = url;
    });
    $("#grabarAlmacen").click(function(){
        $("#frmAlmacen").submit();
    });
    $("#limpiarAlmacen").click(function(){
        url = base_url+"index.php/almacen/almacen/listar";
        $("#txtAlmacen").val('');
        location.href=url;
    });
    $("#cancelarAlmacen").click(function(){
        url = base_url+"index.php/almacen/almacen/listar";
        location.href = url;
    });
    $("#buscarAlmacen").click(function(){
        $("#form_busquedaAlmacen").submit();
    });
});
function editar_almacen(almacen){
	location.href = base_url+"index.php/almacen/almacen/editar/"+almacen;
}
function eliminar_almacen(almacen){
    if(confirm('Esta seguro desea eliminar este almacen?')){
        dataString        = "almacen="+almacen;
        url = base_url+"index.php/almacen/almacen/eliminar";
        $.post(url,dataString,function(data){
                location.href = base_url+"index.php/almacen/almacen/listar";
        });
    }
}
function ver_almacen(almacen){
    location.href = base_url+"index.php/almacen/almacen/ver/"+almacen;
}
function atras_almacen(){
    location.href = base_url+"index.php/almacen/almacen/listar";
}
function reporte_xls(){
	var almacen = $("#almacen_id").val();
	var url = base_url+"index.php/almacen/almacen/reporte_xls/"+almacen;
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}