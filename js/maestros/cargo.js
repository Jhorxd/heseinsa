var base_url;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	$("#nuevoCargo").click(function(){
		url = base_url+"index.php/maestros/cargo/nuevo_cargo";
		location.href = url;
	});	
 	$("#grabarCargo").click(function(){
		$("#frmCargo").submit();	
	}); 
	$("#limpiarCargo").click(function(){
            url = base_url+"index.php/maestros/cargo/cargos";
            $("#txtCargo").val('');
            location.href=url;
	});
        $("#imprimirCargo").click(function(){
		
		///
        url = base_url+"index.php/maestros/cargo/registro_cargos_pdf/";
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;");
    });
	$("#cancelarCargo").click(function(){
            url = base_url+"index.php/maestros/cargo/cargos";
            location.href = url;
	});
	$("#buscarCargo").click(function(){
            $("#form_busquedaCargo").submit();
	});	
});
function editar_cargo(cargo){
	location.href = base_url+"index.php/maestros/cargo/editar_cargo/"+cargo;
}
function eliminar_cargo(cargo){
	if(confirm('¿Está seguro que desea eliminar este cargo?')){
		dataString        = "cargo="+cargo;
                url = base_url+"index.php/maestros/cargo/eliminar_cargo";
		$.post(url,dataString,function(data){
			location.href = base_url+"index.php/maestros/cargo/cargos";		
		});			
	}
}
function ver_cargo(cargo){
  location.href = base_url+"index.php/maestros/cargo/ver_cargo/"+cargo;
}
function atras_cargo(){
	location.href = base_url+"index.php/maestros/cargo/cargos";
}