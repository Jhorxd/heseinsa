jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	/*Cargo*/
	$("#nuevoCargo").click(function(){
		url = base_url+"index.php/usuario/cargo/nuevo_cargo";
		location.href = url;
	});	
 	$("#grabarCargo").click(function(){
		$("#frmProveedor").submit();	
	}); 
	$("#limpiarCargo").click(function(){
		$("#frmProveedor").each(function(){
			this.reset();
		});
	});
	$("#cancelarCargo").click(function(){
		url = base_url+"index.php/usuario/cargo/cargos";
		location.href = url;		
	});
	$("#buscarCargo").click(function(){
		dataString = $("#form_busquedaCargo").serialize();
		txtCargo   = $("#txtCargo").val();
		if(txtCargo!=''){
			$("#form_busquedaCargo").submit();
		}
		else{
			$("#txtCargo").focus();
			alert('Debe ingresar un nombre a buscar.');
		}
	});	
 	$("#frmProveedor").validate({
		event    : "blur",
		rules    : {'nombre' : "required"},
		messages : {'nombre' : "Por favor ingrese el nombre del cargo."},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			nombre     = $("#nombre").val();
			modo       = $("#modo").val();
			codigo     = $("#codigo").val();
			dataString = "nombre="+nombre+"&codigo="+codigo;
			$('#VentanaTransparente').css("display","block");
			if(modo=='insertar'){
				url = base_url+"index.php/usuario/cargo/insertar_cargo";
				$.post(url,dataString,function(data){	
					$('#VentanaTransparente').css("display","none");
					alert('Se ha insertado un nuevo cargo.');
					location.href = base_url+"index.php/usuario/cargo/cargos";
				});				
			}
			else if(modo=='modificar'){
				url = base_url+"index.php/usuario/cargo/modificar_cargo";
				$.post(url,dataString,function(data){	
					$('#VentanaTransparente').css("display","none");
					location.href = base_url+"index.php/usuario/cargo/cargos";
				});				
			}
		}
	}); 
	/*Usuarios*/
	$("#nuevoUsuario").click(function(){
		url = base_url+"index.php/usuario/usuario/nuevo_usuario";
		location.href = url;
	});	
 	$("#grabarUsuario").click(function(){
		$("#frmUsuario").submit();	
	}); 
	$("#limpiarUsuario").click(function(){
		$("#frmUsuario").each(function(){
			this.reset();
		});
	});
	$("#cancelarUsuario").click(function(){
		url = base_url+"index.php/usuario/usuario/usuarios";
		location.href = url;		
	});
	$("#buscarUsuario").click(function(){
		txtNombres  = $("#txtNombres").val();
        txtUsuario      = $("#txtUsuario").val();
        txtRol               = $("#txtRol").val();
//		if(txtNombres=='' && txtUsuario=='' && txtRol==''){
//             if(txtNombres==''){
//                 $("#txtNombres").focus();
//                 alert('Debe ingresar un nombre de usuario.');
//             }
//            else if(txtUsuario==''){
//                 $("#txtUsuario").focus();
//                 alert('Debe ingresar un usuario a buscar.');
//            }
//            else if( txtRol==''){
//                 $("#txtRol").focus();
//                 alert('Debe ingresar un rol a buscar.');
//             }
//		}
		//else{
            $("#form_busquedaUsuario").submit();
		//}
	});
	$("#frmUsuario").validate({
		event    : "blur",
		rules    : {'txtNombres' : "required"},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			txtNombres     = $("#txtNombres").val();
			txtPaterno     = $("#txtPaterno").val();
			txtMaterno     = $("#txtMaterno").val();
			txtUsuario     = $("#txtUsuario").val();
			txtClave       = $("#txtClave").val();
			cboRol         = $("#cboRol").val();
			modo           = $("#modo").val();
			codigo         = $("#codigo").val();
			dataString  = "txtNombres="+txtNombres+"&txtPaterno="+txtPaterno+"&txtMaterno="+txtMaterno+"&txtUsuario="+txtUsuario+"&txtClave="+txtClave+"&cboRol="+cboRol+"&modo="+modo+"&codigo="+codigo;
			if(modo=='insertar'){
				url = base_url+"index.php/usuario/usuario/insertar_usuario";
				$.post(url,dataString,function(data){	
					alert('Se ha insertado un nuevo usuario.');
					location.href = base_url+"index.php/usuario/usuario/usuarios";
				});				
			}
			else if(modo=='modificar'){
				url = base_url+"index.php/usuario/usuario/modificar_usuario";
				$.post(url,dataString,function(data){	
					location.href = base_url+"index.php/usuario/usuario/usuarios";
				});				
			}
		}
	}); 		
	/*Areas*/
	$("#nuevaArea").click(function(){
		url = base_url+"index.php/comercial/area/nueva_area";
		location.href = url;
	});	
 	$("#grabarArea").click(function(){
		$("#frmArea").submit();	
	}); 
	$("#limpiarArea").click(function(){
		$("#frmArea").each(function(){
			this.reset();
		});
	});
	$("#cancelarArea").click(function(){
		url = base_url+"index.php/comercial/area/areas";
		location.href = url;		
	});
	$("#buscarArea").click(function(){
		dataString = $("#form_busquedaArea").serialize();
		txtCargo   = $("#txtArea").val();
		if(txtCargo!=''){
			$("#form_busquedaArea").submit();
		}
		else{
			$("#txtArea").focus();
			alert('Debe ingresar un area a buscar.');
		}
	});
	$("#frmArea").validate({
		event    : "blur",
		rules    : {'txtArea' : "required"},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			nombres     = $("#txtArea").val();
			modo       = $("#modo").val();
			codigo     = $("#codigo").val();			
			dataString  = "codigo="+codigo+"&nombres="+nombres;
			$('#VentanaTransparente').css("display","block");	
			if(modo=='insertar'){
				url = base_url+"index.php/comercial/area/insertar_area";
				$.post(url,dataString,function(data){	
					$('#VentanaTransparente').css("display","none");					
					alert('Se ha insertado una nueva area..');
					location.href = base_url+"index.php/comercial/area/areas";
				});				
			}
			else if(modo=='modificar'){
				url = base_url+"index.php/comercial/area/modificar_area";
				$.post(url,dataString,function(data){	
					$('#VentanaTransparente').css("display","none");									
					location.href = base_url+"index.php/comercial/area/areas";
				});				
			}
		}
	}); 
	/*Establecimientos*/
	$("#nuevoEstablecimiento").click(function(){
		url = base_url+"index.php/comercial/establecimiento/nuevo_establecimiento";
		location.href = url;
	});	
 	$("#grabarEstablecimiento").click(function(){
		$("#frmEstablecimiento").submit();	
	}); 
	$("#limpiarEstablecimiento").click(function(){
		$("#frmEstablecimiento").each(function(){
			this.reset();
		});
	});
	$("#cancelarEstablecimiento").click(function(){
		url = base_url+"index.php/comercial/establecimiento/establecimientos";
		location.href = url;		
	});
	$("#buscarEstablecimiento").click(function(){
		dataString            = $("#form_busquedaEstablecimiento").serialize();
		txtEstablecimiento    = $("#txtEstablecimiento").val();
		if(txtEstablecimiento!=''){
			$("#form_busquedaEstablecimiento").submit();
		}
		else{
			$("#txtEstablecimiento").focus();
			alert('Debe ingresar un area a buscar.');
		}
	});
	$("#frmEstablecimiento").validate({
		event    : "blur",
		rules    : {'txtNombres' : "required"},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			nombres    = $("#txtEstablecimiento").val();
			modo       = $("#modo").val();
			codigo     = $("#codigo").val();			
			dataString = "codigo="+codigo+"&nombres="+nombres;
			$('#VentanaTransparente').css("display","block");
			if(modo=='insertar'){
				url = base_url+"index.php/comercial/establecimiento/insertar_establecimiento";
				$.post(url,dataString,function(data){	
					$("#VentanaTransparente").css("display","none");
					alert('Se ha insertado un nuevo establecimiento.');
					location.href = base_url+"index.php/comercial/establecimiento/establecimientos";
				});				
			}
			else if(modo=='modificar'){
				url = base_url+"index.php/comercial/establecimiento/modificar_establecimiento";
				$.post(url,dataString,function(data){	
					$("#VentanaTransparente").css("display","none");
					location.href = base_url+"index.php/comercial/establecimiento/establecimientos";
				});				
			}
		}
	}); 
	/*Cuenta*/
 	$("#grabarCuenta").click(function(){
		$("#frmCuenta").submit();	
	}); 
	$("#limpiarCuenta").click(function(){
		$("#frmCuenta").each(function(){
			this.reset();
		});
	});
	$("#cancelarCuenta").click(function(){
		url = base_url+"index.php/usuario/usuario";
		location.href = url;		
	});	
	$("#frmCuenta").validate({
		event    : "blur",
		rules    : {'txtNombres' : "required"},
		debug    : true,
		errorElement   : "label",
		errorContainer : $("#errores"),
		submitHandler  : function(form){
			txtNombres     = $("#txtNombres").val();
			txtPaterno     = $("#txtPaterno").val();
			txtMaterno     = $("#txtMaterno").val();
			txtUsuario     = $("#txtUsuario").val();
			txtClave       = $("#txtClave").val();
			modo           = $("#modo").val();
			codigo         = $("#codigo").val();
			dataString  = "txtNombres="+txtNombres+"&txtPaterno="+txtPaterno+"&txtMaterno="+txtMaterno+"&txtUsuario="+txtUsuario+"&txtClave="+txtClave+"&modo="+modo+"&codigo="+codigo;
			if(modo=='modificar'){
				url = base_url+"index.php/usuario/usuario/modificar_cuenta";
				$.post(url,dataString,function(data){	
					location.href = base_url+"index.php/usuario/usuario";
				});				
			}
		}
	}); 
	/*****C o n f i g u ra ci o n*/
 	$("#imgGuardarConfiguracion").click(function(){
		$("#frmConfiguracion").submit();
	}); 
	$("#imgLimpiarConfiguracion").click(function(){
		$("#frmConfiguracion").each(function(){
			this.reset();
		});
	});
	$("#imgCancelarConfiguracion").click(function(){
		url = base_url+"index.php/usuario/configuracion";
		location.href = url;		
	});	
});
/*******************************************************************************************************/
function editar_cargo(cargo){
	location.href = base_url+"index.php/usuario/cargo/editar_cargo/"+cargo;
}
function eliminar_cargo(cargo){
	if(confirm('�Esta seguro desea eliminar a esta cargo?')){
		dataString        = "cargo="+cargo;
		$.post("eliminar_cargo",dataString,function(data){
			location.href = base_url+"index.php/usuario/cargo/cargos";		
		});			
	}
}
function ver_cargo(cargo){
  location.href = base_url+"index.php/usuario/cargo/ver_cargo/"+cargo;
}
function atras_cargo(){
	location.href = base_url+"index.php/usuario/cargo/cargos";
}
/*Usuarios*/
function editar_usuario(usuario){
	location.href = base_url+"index.php/usuario/usuario/editar_usuario/"+usuario;
}
function eliminar_usuario(usuario){
	if(confirm('�Esta seguro desea eliminar a este usuario?')){
		dataString        = "usuario="+usuario;
		$.post("eliminar_usuario",dataString,function(data){
			location.href = base_url+"index.php/usuario/usuario/usuarios";		
		});			
	}
}
function ver_usuario(usuario){
	location.href = base_url+"index.php/usuario/usuario/ver_usuario/"+usuario;
}
function atras_usuario(){
	location.href = base_url+"index.php/usuario/usuario/usuarios";
}
/*Areas*/
function editar_area(area){
	location.href = base_url+"index.php/comercial/area/editar_area/"+area;
}
function eliminar_area(area){
	if(confirm('Esta seguro desea eliminar esta area?')){
		dataString        = "area="+area;
		$.post("eliminar_area",dataString,function(data){
			location.href = base_url+"index.php/comercial/area/areas";		
		});			
	}
}
function ver_area(area){
	location.href = base_url+"index.php/comercial/area/ver_area/"+area;
}
function atras_area(){
	location.href = base_url+"index.php/comercial/area/areas";
}
/*Establecimientos*/
function editar_establecimiento(establecimiento){
	location.href = base_url+"index.php/comercial/establecimiento/editar_establecimiento/"+establecimiento;
}
function eliminar_establecimiento(establecimiento){
	if(confirm('Esta seguro desea eliminar este establecimiento?')){
		dataString        = "establecimiento="+establecimiento;
		$.post("eliminar_establecimiento",dataString,function(data){
			location.href = base_url+"index.php/comercial/establecimiento/establecimientos";		
		});			
	}
}
function ver_establecimiento(establecimiento){
	location.href = base_url+"index.php/comercial/establecimiento/ver_establecimiento/"+establecimiento;
}
function atras_establecimiento(){
	location.href = base_url+"index.php/comercial/establecimiento/establecimientos";
}
/*Configuracion*/
function cargar_configuracion_detalle(compania){
     dataString = "compania="+compania;
    url                 = base_url+"index.php/mantenimiento/cargar_configuracion_detalle";
     $.post(url,dataString,function(data){
          $("#divSecundario").html(data);
     });
}
/*Cuentas*/
function editar_cuenta(usuario){
	location.href = base_url+"index.php/mantenimiento/editar_cuenta/"+usuario;
}
