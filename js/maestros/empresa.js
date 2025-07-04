var base_url
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    
    $("#buscarEmpresa").click(function(){
		$("#form_busqueda").submit();
    });

    $("#nuevoEmpresa").click(function(){
		url = base_url+"index.php/maestros/empresa/nuevo_empresa";
		$("#zonaContenido").load(url);
    });

    $("#limpiarEmpresa").click(function(){
        url = base_url+"index.php/maestros/empresa/empresas";
        location.href=url;
    });

    $("#imgCancelarEmpresa").click(function(){
        base_url = $("#base_url").val();
        location.href = base_url+"index.php/maestros/empresa/empresas";
    });
    
	container = $('div.container');

	$("#imgGuardarEmpresa").click(function(){
	   	if($('#cboDistrito').val()!='00'){
			dataString = $('#frmEmpresa').serialize();
			/*$("#container").show();*/
				$('#VentanaTransparente').css("display","block");
				url = base_url+"index.php/maestros/empresa/modificar_empresa";
				$.ajax({
                       	url: url,
                       	type: "POST",
                       	data: {
                        		empresa_persona : $('#empresa_persona').val(),
        						cboTipoCodigo : $('#cboTipoCodigo').val(),
        						ruc : $('#ruc').val(),
        						razon_social : $('#razon_social').val(),
        						sector_comercial : $('#sector_comercial').val(),
        						telefono : $('#telefono').val(),
        						movil : $('#movil').val(),
        						fax : $('#fax').val(),
        						email : $('#email').val(),
        						web : $('#web').val(),
        						cboNacimiento : $('#cboNacimiento').val(),
        						cboDepartamento : $('#cboDepartamento').val(),
        						cboProvincia : $('#cboProvincia').val(),
        						cboDistrito : $('#cboDistrito').val(),
        						direccion : $('#direccion').val(),
        						ctactesoles : $('#ctactesoles').val(),
        						ctactedolares : $('#ctactedolares').val()
                       	},
                       	dataType: "json",
                       	success: function (data) {
                        	alert('Modificación exitosa.');
                        	location.href = base_url+"index.php/maestros/empresa/empresas";
                       	}
                });
	   	}
	   	else{
	   		alert("Ingrese el ubigeo del cliente");
	   		$('#cboDistrito').focus();
	   	}
    });

    //Ocultar capas
    $('#idGeneral').click(function(){
        $('#datosGenerales').show();
        $('#datosSucursales').hide();
        $('#datosContactos').hide();
        $('#datosAreas').hide();
        $('#nuevoRegistro').hide();
        $('#opcion').val('1');
        $("#botonBusqueda").show();
        $("#datosCuentas").hide();
    });
    $('#idSucursales').click(function(){
        $('#datosGenerales').hide();
        $('#datosSucursales').show();
        $('#datosContactos').hide();
        $('#datosAreas').hide();
        $('#nuevoRegistro').show();
        $('#opcion').val('2');
        $("#botonBusqueda").hide();
        $("#datosCuentas").hide();
    });
    $('#idContactos').click(function(){
        $('#datosGenerales').hide();
        $("#datosCuentas").hide();
        $('#datosSucursales').hide();
        $('#datosContactos').show();
        $('#datosAreas').hide();
        $('#nuevoRegistro').show();
		$('#opcion').val('3');
		$("#botonBusqueda").hide();
		
    });
    $('#idAreas').click(function(){
        $('#datosGenerales').hide();
        $('#datosSucursales').hide();
        $('#datosContactos').hide();
        $('#datosAreas').hide();
        $('#nuevoRegistro').show();
		$('#opcion').val('4');
		$("#botonBusqueda").hide();
		$("#datosCuentas").hide();
    });
  $('#idCuentas').click(function(){
        $('#datosGenerales').hide();
        $('#datosSucursales').hide();
        $('#datosContactos').hide();
        $("#datosCuentas").show();
        $('#datosAreas').hide();
        $('#nuevoRegistro').hide();
		$('#opcion').val('5');
		$("#botonBusqueda").hide();

    });

  $("#txtCuenta").keypress(function(){
   $("#txtCuenta").css({"background-color": "#fff"});
  });
  $("#txtTitular").keypress(function(){
  $("#txtTitular").css({"background-color": "#fff"});
  });
   $("#txtOficina").keypress(function(){
  $("#txtOficina").css({"background-color": "#fff"});
  });
    $("#txtSectoriza").keypress(function(){
  $("#txtSectoriza").css({"background-color": "#fff"});
  });
     $("#txtInterban").keypress(function(){
  $("#txtInterban").css({"background-color": "#fff"});
  });
  $("#txtTipoCuenta").click(function(){
   $("#txtTipoCuenta").css({"background-color": "#fff"});
  });
  $("#txtBanco").click(function(){
  $("#txtBanco").css({"background-color": "#fff"});
  });
  $("#txtMoneda").click(function(){
  $("#txtMoneda").css({"background-color": "#fff"});
  });
  $("#txtMonedaChekera").click(function(){
  	$("#txtMonedaChekera").css({"background-color": "#fff"});
  });
   $("#txtSerieChekera").keypress(function(){
  	$("#txtSerieChekera").css({"background-color": "#fff"});
  });
    $("#txtNumeroChek").keypress(function(){
  	$("#txtNumeroChek").css({"background-color": "#fff"});
  });
  $("#btnInsertarCuentaE").click(function(){
    $("#txtBanco").val("::SELECCIONE::");
  	$("#txtCuenta").val("");
  	$("#txtTitular").val("");
  	$("#txtTipoCuenta").val("");
  	$("#txtMoneda").val("");
  });

  
    container = $('div.container');
	
    //Funcionalidades
    $("#nuevoRegistro").click(function(){
        opcion   = $("#opcion").val();
		persona  = $("#persona").val();
		empresa  = $("#empresa").val();
		modo     = $("#modo").val();
		img_url  = base_url+"system/application/views/images/";
		if(opcion==4){
			n = document.getElementById('tablaArea').rows.length/2;
			j = n+1;
			fila  = "<tr>";
			fila += "<td align='center'>"+j+"</td>";
			fila += "<td align='left'><input type='text' name='nombre_area["+n+"]' id='nombre_area["+n+"]' class='cajaGrande'></td>";
			if(modo=='modificar'){
				fila += "<td align='center'>&nbsp;</td>";
				fila += "<td align='center'><a href='#' onclick='insertar_area();'><img src='"+base_url+"images/save.gif' border='0'></a></td>";
				fila += "</tr>";
			}
			$("#tablaArea").append(fila);
		}
        else if(opcion==3){
			$("#msgRegistros").hide();		
			n = (document.getElementById('tablaContacto').rows.length);
			a = "contactoNombre["+n+"]";
			j = n+1;
			fila  = "<tr>";
			fila += "<td align='center'>"+n+"</td>";
			fila += "<td align='left' style='position:relative;'>";
			fila += "<input type='hidden' name='contactoPersona["+n+"]' id='contactoPersona["+n+"]' class='cajaMedia'>";
			fila += "<input type='text' name='contactoNombre["+n+"]' id='contactoNombre["+n+"]' class='cajaMedia' onfocus='ocultar_homonimos("+n+")'>";
			fila += "<a href='#' onclick='mostrar_homonimos("+n+");'><image src='"+base_url+"images/ver.png' border='0'></a>";
			fila += "<div id='homonimos["+n+"]' style='display:none;background:#ffffff;width:300px;border:1px solid #cccccc;height:200px;overflow:auto;position:absolute;z-index:1;'></div>";
			fila += "</td>";
			fila += "<td align='center'><select name='contactoArea["+n+"]' id='contactoArea["+n+"]' class='comboMedio' ><option value='0'>::Seleccionar::</option></select></td>";
			fila += "<td align='left'><select name='cargo_encargado["+n+"]' id='cargo_encargado["+n+"]' class='cajaMedia'><option value='0'>::Seleccione::</option></select></td>";
			fila += "<td align='left'><input type='text' name='contactoTelefono["+n+"]' id='contactoTelefono["+n+"]' class='cajaPequena'></td>";
			fila += "<td align='left'><input type='text' name='contactoEmail["+n+"]' id='contactoEmail["+n+"]' class='cajaPequena'></td>";
			if($('#empresa_persona').val()!=''){
				fila += "<td align='center'>&nbsp;</td>";
				fila += "<td align='center'><a href='#' onclick='insertar_contacto("+n+");'><img src='"+base_url+"images/save.gif' border='0'></a></td>";
			}
                        else{
                            fila += "<td>&nbsp;</td>";
                            fila += "<td>&nbsp;</td>";
                        }
			fila += "</tr>";
			$("#tablaContacto").append(fila);
			document.getElementById(a).focus();
			listar_areas(n);
		}
		else if(opcion==2){
                        $("#msgRegistros2").hide();		
			n = document.getElementById('tablaSucursal').rows.length;
			a = "nombreSucursal["+n+"]";
			j = n+1;
			fila  = "<tr>";
			fila += "<td align='center'>"+n+"</td>";
			fila += "<td align='left'>";
			fila += "<input type='text' name='nombreSucursal["+n+"]' id='nombreSucursal["+n+"]' size='10' maxlength='150' class='cajaGeneral'>";
			fila += "<input type='hidden' name='empresaSucursal["+n+"]' id='empresaSucursal["+n+"]' class='cajaMedia' value='"+empresa+"'>";
			fila += "</td>";
			fila += "<td align='left'><select name='tipoEstablecimiento["+n+"]' id='tipoEstablecimiento["+n+"]' class='comboMedio' ><option value=''>::Seleccione::</option></select></td>";
			fila += "<td align='left'><input type='text' name='direccionSucursal["+n+"]' id='direccionSucursal["+n+"]' size='58' maxlength='200' class='cajaGeneral'></td>";
			fila += "<td align='left'>";
			fila += "<input type='hidden' name='dptoSucursal["+n+"]' id='dptoSucursal["+n+"]' class='cajaGrande' value='15'>";
			fila += "<input type='hidden' name='provSucursal["+n+"]' id='provSucursal["+n+"]' class='cajaGrande' value='01'>";
			fila += "<input type='hidden' name='distSucursal["+n+"]' id='distSucursal["+n+"]' class='cajaGrande'>";
			fila += "<input type='text' name='distritoSucursal["+n+"]' id='distritoSucursal["+n+"]' size='24' class='cajaGeneral cajaSoloLectura' readonly='readonly'/> ";
			fila += "<a href='#' onclick='abrir_formulario_ubigeo_sucursal("+n+");'><image src='"+base_url+"images/ver.png' border='0'></a>";
			fila += "</td>";
			if($('#empresa_persona').val()!=''){
				fila += "<td align='center'>&nbsp;</td>";
				fila += "<td align='center'><a href='#' onclick='insertar_sucursal("+n+");'><img src='"+base_url+"images/save.gif' border='0'></a></td>";
			}
                        else{
                            fila += "<td>&nbsp;</td>";
                            fila += "<td>&nbsp;</td>";
                        }
			fila += "</tr>";
			$("#tablaSucursal").append(fila);
			document.getElementById(a).focus();
			listar_tipoEstablecimientos(n);
		}
    });

  
});

  /*
	*/


function editar_empresa(empresa){
        var url = base_url+"index.php/maestros/empresa/editar_empresa/"+empresa;
	$("#zonaContenido").load(url);
}
function eliminar_empresa(empresa){
	if(confirm('Está seguro que desea eliminar esta empresa?')){
		dataString = "empresa="+empresa;
		url = base_url+"index.php/maestros/empresa/eliminar_empresa";
		$.post(url,dataString,function(data){
			url = base_url+"index.php/maestros/empresa/empresas";
			location.href = url;
		});
	}
}
function ver_empresa(empresa){
	url = base_url+"index.php/maestros/empresa/ver_empresa/"+empresa;
	$("#zonaContenido").load(url);
}
function atras_empresa(){
	location.href = base_url+"index.php/maestros/empresa/empresas";
}
function insertar_contacto(id){
	a = "contactoNombre["+id+"]";
	b = "contactoArea["+id+"]";
	c = "cargo_encargado["+id+"]";
	d = "contactoTelefono["+id+"]";
	e = "contactoEmail["+id+"]";
	f = "contactoPersona["+id+"]";
	empresa         = document.getElementById('empresa_persona').value;
	nombre_contacto   = document.getElementById(a).value;
	area_contacto     = document.getElementById(b).value;
	cargo_contacto    = document.getElementById(c).value;
	telefono_contacto = document.getElementById(d).value;
	email_contacto    = document.getElementById(e).value;
	contacto_persona  = document.getElementById(f).value;
	dataString        = "empresa="+empresa+"&persona_contacto="+contacto_persona+"&nombre_contacto="+nombre_contacto+"&area_contacto="+area_contacto+"&cargo_contacto="+cargo_contacto+"&telefono_contacto="+telefono_contacto+"&email_contacto="+email_contacto;
	url = base_url+"index.php/maestros/empresa/insertar_contacto";
	$.post(url,dataString,function(data){
		$("#datosContactos").html(data);
	});
}

function insertar_sucursal(n){
	a = "nombreSucursal["+n+"]";
	b = "direccionSucursal["+n+"]";
	c = "distritoSucursal["+n+"]";
	d = "tipoEstablecimiento["+n+"]";
	e = "dptoSucursal["+n+"]";
	f = "provSucursal["+n+"]";
	g = "distSucursal["+n+"]";
	empresa              = document.getElementById('empresa_persona').value;
	nombre_sucursal      = document.getElementById(a).value;
	direccion_sucursal   = document.getElementById(b).value;
	dpto_sucursal        = document.getElementById(e).value;
	prov_sucursal        = document.getElementById(f).value;
	dist_sucursal        = document.getElementById(g).value;
	ubigeo_sucursal      = dpto_sucursal+prov_sucursal+dist_sucursal;
	tipo_establecimiento = document.getElementById(d).value;
	dataString = "empresa="+empresa+"&nombre_sucursal="+nombre_sucursal+"&direccion_sucursal="+direccion_sucursal+"&ubigeo_sucursal="+ubigeo_sucursal+"&tipo_establecimiento="+tipo_establecimiento;
	if(direccion_sucursal!=''){
		url = base_url+"index.php/maestros/empresa/insertar_sucursal"
		$.post(url,dataString,function(data){
			$("#datosSucursales").html(data);
		});
	}
	else{
		alert('Debe ingresar la dirección de la sucursal.');
                document.getElementById(b).focus();
	}
}

function editar_sucursal(sucursal){
	empresa           = document.getElementById('empresa_persona').value;
	dataString        = "empresa="+empresa+"&sucursal="+sucursal;
	url = base_url+"index.php/maestros/empresa/editar_sucursal";
	$.post(url,dataString,function(data){
                $("#datosSucursales").html(data);
	});
}
function modificar_sucursal(n){
	a = "nombreSucursal["+n+"]";
	b = "direccionSucursal["+n+"]";
	c = "distritoSucursal["+n+"]";
	d = "tipoEstablecimiento["+n+"]";
	e = "dptoSucursal["+n+"]";
	f = "provSucursal["+n+"]";
	g = "distSucursal["+n+"]";
        h = "empresaSucursal["+n+"]";
	empresa              = document.getElementById('empresa_persona').value;
	nombre_sucursal      = document.getElementById(a).value;
	direccion_sucursal   = document.getElementById(b).value;
	dpto_sucursal        = document.getElementById(e).value;
	prov_sucursal        = document.getElementById(f).value;
	dist_sucursal        = document.getElementById(g).value;
	ubigeo_sucursal      = dpto_sucursal+prov_sucursal+dist_sucursal;
	tipo_establecimiento = document.getElementById(d).value;
        sucursal_empresa     = document.getElementById(h).value;
        dataString = "empresa="+empresa+"&sucursal_empresa="+sucursal_empresa+"&nombre_sucursal="+nombre_sucursal+"&direccion_sucursal="+direccion_sucursal+"&ubigeo_sucursal="+ubigeo_sucursal+"&tipo_establecimiento="+tipo_establecimiento;
	url = base_url+"index.php/maestros/empresa/modificar_sucursal"
	$.post(url,dataString,function(data){
		$("#datosSucursales").html(data);
	});
}
function editar_contacto(persona){
    var empresa         = document.getElementById('empresa_persona').value;
    var dataString        = "empresa="+empresa+"&persona="+persona;
    var url = base_url+"index.php/maestros/empresa/editar_contacto";
    $.post(url,dataString,function(data){
            $("#datosContactos").html(data);
    });
}
function modificar_contacto(id){
	a = "contactoNombre["+id+"]";
	b = "contactoArea["+id+"]";
	c = "cargo_encargado["+id+"]";
	d = "contactoTelefono["+id+"]";
	e = "contactoEmail["+id+"]";
	f = "contactoPersona["+id+"]";
	empresa           = document.getElementById('empresa_persona').value;
	nombre_contacto   = document.getElementById(a).value;
	area_contacto     = document.getElementById(b).value;
	cargo_contacto    = document.getElementById(c).value;
	telefono_contacto = document.getElementById(d).value;
	email_contacto    = document.getElementById(e).value;
	contacto_persona  = document.getElementById(f).value;
	dataString        = "empresa="+empresa+"&persona_contacto="+contacto_persona+"&nombre_contacto="+nombre_contacto+"&area_contacto="+area_contacto+"&cargo_contacto="+cargo_contacto+"&telefono_contacto="+telefono_contacto+"&email_contacto="+email_contacto;
	url = base_url+"index.php/maestros/empresa/modificar_contacto"
	$.post(url,dataString,function(data){
		$("#datosContactos").html(data);
	});
}
function eliminar_contacto(persona){
    if(confirm('Esta seguro desea eliminar a esta persona de su lista de contactos?')){
        var empresa = document.getElementById('empresa_persona').value;
        var dataString = "empresa="+empresa+"&persona="+persona;
        var url = base_url+"index.php/maestros/empresa/eliminar_contacto"
        $.post(url,dataString,function(data){
                $("#datosContactos").html(data);
        });
    }
}
function eliminar_sucursal(sucursal){
    if(confirm('Esta seguro desea eliminar a este establecimiento?')){
        var empresa = document.getElementById('empresa_persona').value;
        var dataString = "empresa="+empresa+"&sucursal="+sucursal;
        var url = base_url+"index.php/maestros/empresa/eliminar_sucursal";
        $.post(url,dataString,function(data){
                $("#datosSucursales").html(data);
        });
    }
}
/*Combos*/
function listar_tipoEstablecimientos(n){
    a      = "tipoEstablecimiento["+n+"]";
    select = document.getElementById(a);
    url = base_url+"index.php/maestros/establecimiento/listar_tiposEstablecimiento";
    $.getJSON(url,function(data){
          $.each(data, function(i,item){
                codigo      = item.TESTP_Codigo;
                descripcion = item.TESTC_Descripcion;
                opt         = document.createElement('option');
                texto       = document.createTextNode(descripcion);
                opt.appendChild(texto);
                opt.value = codigo;
                select.appendChild(opt);
          });
    });
}
function listar_areas(n){
    a      = "contactoArea["+n+"]";
    select = document.getElementById(a);
    url = base_url+"index.php/maestros/area/listar_areas";
    $.getJSON(url,function(data){
          $.each(data, function(i,item){
                codigo      = item.AREAP_Codigo;
                descripcion = item.AREAC_Descripcion;
                opt         = document.createElement('option');
                texto       = document.createTextNode(descripcion);
                opt.appendChild(texto);
                opt.value = codigo;
                select.appendChild(opt);
          });
          listar_cargos(n);
    });
}
function listar_cargos(n){
	a      = "cargo_encargado["+n+"]";
	select = document.getElementById(a);
	url = base_url+"index.php/maestros/cargo/listar_cargos";
	$.getJSON(url,function(data){
		  $.each(data, function(i,item){
			codigo      = item.CARGP_Codigo;
			descripcion = item.CARGC_Descripcion;
			opt         = document.createElement('option');
			texto       = document.createTextNode(descripcion);
			opt.appendChild(texto);
			opt.value = codigo;
			select.appendChild(opt);
		  });
	});
}
function listar_distritos(n){

}
function cargar_provincia(obj){
    departamento = obj.value;
    provincia    = "01";
    if(departamento!='00'){
        url = base_url+"index.php/maestros/ubigeo/cargar_ubigeo/"+departamento+"/"+provincia;
        $("#divUbigeo").load(url);
    }
}
function cargar_distrito(obj){
    departamento = $("#cboDepartamento").val();
    provincia    = obj.value;
    if(departamento!='00' && provincia!='00'){
        url = base_url+"index.php/maestros/ubigeo/cargar_ubigeo/"+departamento+"/"+provincia;
        $("#divUbigeo").load(url);
    }
}
function mostrar_homonimos(n){
    a = "homonimos["+n+"]";
    b = "contactoNombre["+n+"]";
    nombre = document.getElementById(b).value;
    url = base_url+"index.php/maestros/persona/busqueda_personas";
    if(nombre.length!='0'){
            dataString = "nombre="+nombre+"&n="+n;
            $.ajax({
                    type    : "POST",
                    url     : url,
                    data    : dataString,
                    success : function(response) {
                            if(response){
                                document.getElementById(a).style.display = "block";
                                document.getElementById(a).innerHTML = response;
                            }
                    }
                });
    }
    else{
        alert('Debe ingresar el nombre de su contacto');
        document.getElementById(b).focus();
    }
}
function ocultar_homonimos(n){
    a = "homonimos["+n+"]";
    b = "contactoNombre["+n+"]";
    nombre_contacto = document.getElementById(b).value;
    if(nombre_contacto.length!='0'){
        document.getElementById(a).style.display = 'none';
    }
}
function mostrar_encargado(n){
    a = "divEncargado["+n+"]";
    b = "encargado_area["+n+"]";
    nombre_encargado = document.getElementById(b).value;
    url = base_url+"index.php/maestros/persona/busqueda_personas";
}
function obtener_persona(persona,n){
	a = "homonimos["+n+"]";
	b = "contactoNombre["+n+"]";
	url = base_url+"index.php/maestros/persona/obtener_persona/"+persona;
	$.getJSON(url,function(data){
		  $.each(data, function(i,item){
			codigo  = item.PERSP_Codigo;
			nombre  = item.PERSC_Nombre;
			paterno = item.PERSC_ApellidoPaterno;
			materno = item.PERSC_ApellidoMaterno;
			document.getElementById(b).value = nombre+" "+paterno+" ";
			document.getElementById(a).style.display = "none";
		  });
	});
}
function abrir_formulario_ubigeo_sucursal(n){
	a = "dptoSucursal["+n+"]";
	b = "provSucursal["+n+"]";
	c = "distSucursal["+n+"]";
	dpto_nac = document.getElementById(a).value;
	prov_nac = document.getElementById(b).value;
	dist_nac = document.getElementById(c).value;
	ubigeo   = dpto_nac+""+prov_nac+""+dist_nac;
	seccion  = "sucursal";
	url = base_url+"index.php/maestros/ubigeo/formulario_ubigeo_complementario/"+ubigeo+"/"+seccion+"/"+n;
	window.open(url,'Formulario Ubigeo','menubar=no,resizable=no,width=610,height=110');
}
$(document).ready(function(){
$("#txtBanco #txtCuenta").bind("click", function(){
	$('#txtBanco').css('background-color', 'write').focus();
	$('#txtCuenta').css('background-color', 'write').focus();
	//alert("hola");
})
$("#popup").mouseenter(function(){
$('#txtSerieChekera').focus();
//alert("hola como estas");
});
$("#idCuentas").mouseleave(function(){
	$('#txtBanco').focus();
});
 $("#btnCancelarCuentaE").click(function(){
   	//alert("hola mundo");
    $("#txtBanco").val("::SELECCIONE::");
  	$("#txtCuenta").val("");
  	$("#txtTitular").val("");
  	$("#txtTipoCuenta").val("");
  	$("#txtMoneda").val("");
  	//$("#contenedorCuenta").html('');

  });
});
function insertar_cuentaEmpresa(){
	var codigo=$("#txtCodCuenEmpre").val();
	var empresa_persona=$("#empresa_persona").val();
	var txtBanco=$("#txtBanco").val();
	var txtCuenta=$("#txtCuenta").val();
	var txtTitular=$("#txtTitular").val();
	var txtTipoCuenta=$("#txtTipoCuenta").val();
	var txtMoneda=$("#txtMoneda").val();
	var TIP_Codigo=$("#TIP_Codigo").val();
	var txtOficina =$("#txtOficina").val();
	var txtInterban=$("#txtInterban").val();
	 var txtSectoriza=$("#txtSectoriza").val();
	//REGISTRAR UN NUEVO CUENTA EMPRESA

	if($("#txtCodCuenEmpre").val()==""){
    var dataString="empresa_persona="+empresa_persona+ "&txtBanco="+txtBanco+"&txtCuenta="+txtCuenta+"&txtTitular="+txtTitular+"&txtTipoCuenta="+txtTipoCuenta+"&txtMoneda="+txtMoneda+"&TIP_Codigo="+TIP_Codigo+"&txtOficina="+txtOficina+"&txtInterban="+txtInterban+"&txtSectoriza="+txtSectoriza;
	url = base_url+"index.php/maestros/empresa/insert_cuantasEmpresa";
    if(validateFormulario()){   	
	$.post(url,dataString,function(data){
	 	$('#contenidoCuentaTable').load(base_url+"index.php/maestros/empresa/TABLA_cuentaEmpresa/"+empresa_persona);
	});	
	$("#txtMoneda").val("::SELECCIONE::");
	$("#txtTipoCuenta").val("::SELECCIONE::");
	$("#txtBanco").val("::SELECCIONE::");
	$("#txtTitular").val("");
    $("#txtCuenta").val("");
    $("#txtOficina").val("");
    $("#txtSectoriza").val("");
     $("#txtInterban").val("");
	}
}else{
	//ACTUALIZAR DATA DE CUENTA EMPRESA
	var dataString="txtCodCuenEmpre="+codigo+"&empresa_persona="+empresa_persona+ "&txtBanco="+txtBanco+"&txtCuenta="+txtCuenta+"&txtTitular="+txtTitular+"&txtTipoCuenta="+txtTipoCuenta+"&txtMoneda="+txtMoneda+"&TIP_Codigo="+TIP_Codigo+"&txtOficina="+txtOficina+"&txtInterban="+txtInterban+"&txtSectoriza="+txtSectoriza;
	url = base_url+"index.php/maestros/empresa/update_cuantasEmpresa";
	  if(validateFormulario()){
	$.post(url,dataString,function(data){
	$('#contenidoCuentaTable').load(base_url+"index.php/maestros/empresa/TABLA_cuentaEmpresa/"+empresa_persona);
	$("#txtMoneda").val("::SELECCIONE::");
	$("#txtTipoCuenta").val("::SELECCIONE::");
	$("#txtBanco").val("::SELECCIONE::");
	$("#txtTitular").val("");
    $("#txtCuenta").val("");
    $("#txtOficina").val("");
    $("#txtSectoriza").val("");
     $("#txtInterban").val("");
});	
}
}
}
function actualizar_cuentaEmpresa(codigo){
	var url_data="index.php/maestros/empresa/TABLA_cuentaEmpresa/";
    var url=base_url+url_data+codigo+"/E";
    $('#contenedorCuenta').load(base_url+"index.php/maestros/empresa/TABLA_cuentaEmpresa/"+codigo+"/E");
}

function eliminar_cuantaEmpresa(codigo){

   var empresa_persona=$("#empresa_persona").val();
    var url_data="index.php/maestros/empresa/JSON_EliminarCuentaEmpresa/";
    var url= base_url+url_data+codigo;
    if(confirm("Esta Seguro Eliminar?")){
     $.ajax({url: url,type: "POST", success: function(result){
    	 	$('#contenidoCuentaTable').load(base_url+"index.php/maestros/empresa/TABLA_cuentaEmpresa/"+empresa_persona);
    
        }
    });   
 }else{

 }
    

}
function validateFormulario(){
    // Campos de texto
	if($("#txtBanco").val() == "S"){
       $('#txtBanco').css('background-color', '#FFC1C1').focus();
        return false;
    }//|| /^\s*$/.test(la caja de texto) cuando hay muchos espacios en blanco
    if($("#txtCuenta").val() == "" || /^\s*$/.test($("#txtCuenta").val())){
      $('#txtCuenta').css('background-color', '#FFC1C1').focus();
      return false;
    }
    if($("#txtTitular").val() == "" || /^\s*$/.test($("#txtTitular").val())) {
        $("#txtTitular").css('background-color', '#FFC1C1').focus();
        return false;
    }
	//if($("#txtOficina").val() == "" || /^\s*$/.test($("#txtOficina").val())) {
    //    $("#txtOficina").css('background-color', '#FFC1C1').focus();
    //    return false;
    //}
	//if($("#txtSectoriza").val() == "" || /^\s*$/.test($("#txtSectoriza").val())) {
    //    $("#txtSectoriza").css('background-color', '#FFC1C1').focus();
    //    return false;
    //}
	//if($("#txtInterban").val() == "" || /^\s*$/.test($("#txtInterban").val())) {
    //    $("#txtInterban").css('background-color', '#FFC1C1').focus();
    //    return false;
    //}

    if($("#txtTipoCuenta").val() == "S"){
         $("#txtTipoCuenta").css('background-color', '#FFC1C1').focus();
        return false;
    }
   if($("#txtMoneda").val() == "S"){
       $("#txtMoneda").css('background-color', '#FFC1C1').focus();
        return false;
    }

  /*  // Checkbox
    if(!$("#txtMoneda").is(":checked")){
        alert("Debe confirmar que es mayor de 18 años.");
        return false;
    }
*/
    return true; // Si todo está correcto
}
function soloLetras_andNumero(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.1234567890-_+";
    especiales = [8, 37, 39, 46];

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}
$(document).ready(function(){
  $('#open').click(function(){
        $('#popup').fadeIn('slow');
        $('.popup-overlay').fadeIn('slow');
        $('.popup-overlay').height($(window).height());
        return false;
    });
    $('#close').click(function(){
    	$("#listarChekera").html('');//limpiar la tabla
		$('#popup').fadeOut('slow');
        $('.popup-overlay').fadeOut('slow');
        return false;
    });
    //chekera
   $("#LimpiarChikera").click(function(){
	$("#txtNumeroChek").val("");
	$("#txtSerieChekera").val("");
})
});
function ventanaChekera(codigo){
var url_data="index.php/maestros/empresa/JSON_ListarCuentaEmpresa/";
    var url= base_url+url_data+codigo;
    $.getJSON(url, function (data) {
        $.each(data, function (i, item) {
        	$("#txtCodCuentaEmpre").val(item.CUENT_Codigo);
        	$("#txtnumeroEmpr").val(item.CUENT_NumeroEmpresa);
        	$("#txtMonedaChekera").val(item.MONED_Descripcion);
});
});
var url_data1="index.php/maestros/empresa/listarChikera/";
    var url1= base_url+url_data1+codigo;
    $.getJSON(url1, function (data) {
        $.each(data, function (i, item) {
        	if(item.SERIP_Codigo!=null){
        	var  	 fila = '<tr> <td>'+(i+1)+'</td>';
             fila+='<td>'+item.CHEK_FechaRegistro+'</td>';
             fila+='<td>'+item.CUENT_NumeroEmpresa+'</td>';
             fila+='<td>'+item.SERIP_Codigo+'</td>';
             fila+='<td>'+item.CHEK_Numero+'</td>';
             fila+='<td><a href="#" onclick="eliminarChikera('+item.CHEK_Codigo+')" ><img src='+base_url+'images/delete.gif ></a></td>';
        $("#listarChekera").append(fila);  
                    fila='</tr>';	
                }else{
                	//var fila="<tr><td align=center colspan=6 >" ;
  					//	fila+="<div>NO EXISTEN REGISTROS</div>";
                	//fila+='</td>';
          $("#listarChekera").append("<div>NO EXISTEN REGISTROS</div>");  
                	//fila='</tr>';
    }            
});
});	
    
	$('#popup').fadeIn('slow');
    $('.popup-overlay').fadeIn('slow');
    $('.popup-overlay').height($(window).height());
    return false;
}
 function mostrar(){
    $('#popup').fadeIn('slow');
    $('.popup-overlay').fadeIn('slow');
    $('.popup-overlay').height($(window).height());
    return false;	
}
function listarChekera(codigo){

	//alert("el segundo emtodo");
}
function insertChekera(){
	var txtCodCuentaEmpre=$("#txtCodCuentaEmpre").val();
	//var txtMonedaChekera=$("#txtMonedaChekera").val();
	var txtSerieChekera=$("#txtSerieChekera").val();
	var txtNumeroChek=$("#txtNumeroChek").val();
	var empresa_persona=$("#empresa_persona").val();
	
	 var dataString="txtSerieChekera="+txtSerieChekera+"&txtCodCuentaEmpre="+txtCodCuentaEmpre+"&txtTitular="+txtTitular+"&empresa_persona="+empresa_persona+"&txtNumeroChek="+txtNumeroChek;
	url = base_url+"index.php/maestros/empresa/insertChekera";
    //if(validateFormulario()){
   if(validarChikera()){
    $.post(url,dataString,function(data){
     $('#contenedorTableChekera').load(base_url+"index.php/maestros/empresa/TABLE_listarChekera/"+txtCodCuentaEmpre);
	$("#txtNumeroChek").val("");
	$("#txtSerieChekera").val("");
	});	
	}
	
}
function eliminarChikera(codigo){
	var txtCodCuentaEmpre=$("#txtCodCuentaEmpre").val();
    var url_data="index.php/maestros/empresa/eliminarChikera/";
    var url= base_url+url_data+codigo;
    if(confirm("Esta Seguro de Eliminar?")){
     $.ajax({url: url,type: "POST", success: function(result){
    	 	$('#contenedorTableChekera').load(base_url+"index.php/maestros/empresa/TABLE_listarChekera/"+txtCodCuentaEmpre);
    
        }
    });   
 }else{

 }
}
function validarChikera(){
if($("#txtSerieChekera").val() == "" || /^\s*$/.test($("#txtSerieChekera").val())){
      $('#txtSerieChekera').css('background-color', '#FFC1C1').focus();
      return false;
    }
 if($("#txtNumeroChek").val() == "" || /^\s*$/.test($("#txtNumeroChek").val())){
      $('#txtNumeroChek').css('background-color', '#FFC1C1').focus();
      return false;
    } 
 return true; 
}
$(document).keydown(function(tecla){ 

   if(tecla.keyCode == 27||tecla.keyCode == 10){
        $("#listarChekera").html('');//limpiar la tabla
		$('#popup').fadeOut('slow');
        $('.popup-overlay').fadeOut('slow');
        return false;
   }
 
  });
function limpiar_cuentaEmpresa(){
	$("#txtBanco").val("::SELECCIONE::");
  	$("#txtCuenta").val("");
  	$("#txtTitular").val("");
  	$("#txtTipoCuenta").val("");
  	$("#txtMoneda").val("");
  	$("#txtCodCuenEmpre").val("");
	//alert("hoasdasiohdopasdfha");
}
/////////////////////////////////////////////////
function  onkeypress_cuenta(){
    var cod=$("#txtCuenta").val();
    var url=base_url+"index.php/maestros/empresa/getBuscaCuenta/"+cod;
        // $("div").html(" ");//limpia el campo
        $.getJSON(url, function(result){
            $.each(result, function(i, item){
                $("#txtCodCuenEmpre").val(item.CUENT_Codigo);
                $("#txtOficina").val(item.CUENT_Oficina);
                $("#txtSectoriza").val(item.CUENT_Sectoriza);
                $("#txtInterban").val(item.CUENT_Interbancaria);
                $("#txtTitular").val(item.CUENT_Titular);
                document.getElementById("txtBanco").value=item.BANP_Codigo;
                $("#txtTipoCuenta").val(item.CUENT_TipoCuenta);
                $("#txtMoneda").val(item.MONED_Codigo);
               });
        });
}