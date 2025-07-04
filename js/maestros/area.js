var base_url;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	$("#nuevaArea").click(function(){
		url = base_url+"index.php/maestros/area/nueva_area";
		location.href = url;
	});	
 	$("#grabarArea").click(function(){
		$("#frmArea").submit();	
	}); 
	$("#limpiarArea").click(function(){
            url = base_url+"index.php/maestros/area/areas";
            $("#txtArea").val('');
            location.href=url;
	});
	$("#cancelarArea").click(function(){
            url = base_url+"index.php/maestros/area/areas";
            location.href = url;
	});
	$("#buscarArea").click(function(){
            $("#form_busquedaArea").submit();
	});
	$("#frmArea").validate({
		event    : "blur",
		rules    : {'txtArea' : "required"},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			var nombres     = $("#nombres").val();
			var modo       = $("#modo").val();
			var codigo     = $("#codigo").val();			
			var dataString  = "codigo="+codigo+"&nombres="+nombres;
			$('#VentanaTransparente').css("display","block");	
			if(modo=='insertar'){
				url = base_url+"index.php/maestros/area/insertar_area";
				$.post(url,dataString,function(data){	
					$('#VentanaTransparente').css("display","none");					
					alert('Se ha insertado una nueva area..');
					location.href = base_url+"index.php/maestros/area/areas";
				});				
			}
			else if(modo=='modificar'){
				url = base_url+"index.php/maestros/area/modificar_area";
				$.post(url,dataString,function(data){	
					$('#VentanaTransparente').css("display","none");									
					location.href = base_url+"index.php/maestros/area/areas";
				});				
			}
		}
	}); 
});
function editar_area(area){
	location.href = base_url+"index.php/maestros/area/editar_area/"+area;
}
function eliminar_area(area){
	if(confirm('¿Está seguro que desea eliminar esta area?')){
		dataString        = "area="+area;
		url = base_url+"index.php/maestros/area/eliminar_area";
		$.post(url,dataString,function(data){
			location.href = base_url+"index.php/maestros/area/areas";		
		});			
	}
}
function ver_area(area){
	location.href = base_url+"index.php/maestros/area/ver_area/"+area;
}
function atras_area(){
	location.href = base_url+"index.php/maestros/area/areas";
}

//Probando SVN