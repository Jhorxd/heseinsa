

var base_url;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	$("#nuevoRol").click(function(){
		url = base_url+"index.php/seguridad/rol/nuevo";
		location.href = url;
	});
 	$("#grabarRol").click(function(){
            $("#frmRol").submit();
	});
	$("#limpiarRol").click(function(){
            url = base_url+"index.php/seguridad/rol/listar";
            $("#txtNombre").val('');
            $("#txtRol").val('');

            location.href=url;
	});
	
	
        $("#cancelarRol").click(function(){
            url = base_url+"index.php/seguridad/rol/listar";
            location.href = url;
	});
        $("#buscarRol").click(function(){
            $("#form_busquedaRol").submit();
	});
});
function editar_rol(rol){
	location.href = base_url+"index.php/seguridad/rol/editar/"+rol;
}
function eliminar_rol(rol){
	if(confirm('¿Está seguro que desea eliminar este rol?')){
        dataString        = "rol="+rol;
        $.post("eliminar",dataString,function(data){
                location.href = base_url+"index.php/seguridad/rol/listar";
        });
	}
}
function ver_rol(rol){
	location.href = base_url+"index.php/seguridad/rol/ver/"+rol;
}
function atras_rol(){
	location.href = base_url+"index.php/seguridad/rol/listar";
}
