var base_url
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();       
    $("#imgGuardarProyecto").click(function(){
		dataString = $('#frmProyecto').serialize();
		$("#container").show();
		$("#frmProyecto").submit();
    });
    $("#buscarProyecto").click(function(){
		$("#form_busqueda").submit();
    });	
    $("#nuevoProyecto").click(function(){
		url = base_url+"index.php/maestros/proyecto/nuevo_proyecto";
		$("#zonaContenido").load(url);
    });
    $("#limpiarProyecto").click(function(){
        url = base_url+"index.php/maestros/proyecto/proyectos";
        location.href=url;
    });
    $("#imgCancelarProyecto").click(function(){
        base_url = $("#base_url").val();
        location.href = base_url+"index.php/maestros/proyecto/proyectos";
    });
    
	container = $('div.container');
 	$("#frmProyecto").validate({
		event    : "blur",
		rules    : {
					'ruc'             : {required:true,minlength:11,number:true},
					'razon_social'    : "required"
 			    },
		debug    : true,
		errorContainer      : "container",
		errorLabelContainer : $(".container"),
		wrapper             : 'li',
		submitHandler       : function(form){
				dataString  = $('#frmProyecto').serialize();
				modo        = $("#modo").val();
				$('#VentanaTransparente').css("display","block");
				if(modo=='insertar'){
					url = base_url+"index.php/maestros/proyecto/insertar_proyecto";
					$.post(url,dataString,function(data){
					$("#VentanaTransparente").css("display","none");
				alert('Se ha ingresado una proyecto.');
						location.href = base_url+"index.php/maestros/proyecto/proyectos";
					});
				}
				else if(modo=='modificar'){
					url = base_url+"index.php/maestros/proyecto/modificar_proyecto";
					$.post(url,dataString,function(data){
						$("#VentanaTransparente").css("display","none");
						alert('Su registro ha sido modificado.');
						location.href = base_url+"index.php/maestros/proyecto/proyectos";
					});
				}
		}
	});

    container = $('div.container');	
    //Funcionalidades
    $("#nuevoRegistro").click(function(){
        opcion   = $("#opcion").val();
		proyecto  = $("#proyecto").val();
		
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
			fila += "<div id='homonimos["+n+"]' style='display:none;background:#ffffff;width:300px;border:1px solid #cccccc;height:40px;overflow:auto;position:absolute;z-index:1;'></div>";
			fila += "</td>";
			fila += "<td align='center'><select name='contactoArea["+n+"]' id='contactoArea["+n+"]' class='comboMedio' ><option value='0'>::Seleccionar::</option></select></td>";
			fila += "<td align='left'><select name='cargo_encargado["+n+"]' id='cargo_encargado["+n+"]' class='cajaMedia'><option value='0'>::Seleccione::</option></select></td>";
			fila += "<td align='left'><input type='text' name='contactoTelefono["+n+"]' id='contactoTelefono["+n+"]' class='cajaPequena'></td>";
			fila += "<td align='left'><input type='text' name='contactoEmail["+n+"]' id='contactoEmail["+n+"]' class='cajaPequena'></td>";
			if($('#proyecto_persona').val()!=''){
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
			fila += "<input type='text' name='nombreSucursal["+n+"]' id='nombreSucursal["+n+"]' class='cajaMedia'>";
			fila += "<input type='hidden' name='proyectoSucursal["+n+"]' id='proyectoSucursal["+n+"]' class='cajaMedia' value='"+proyecto+"'>";
			fila += "</td>";
			fila += "<td align='left'><select name='tipoEstablecimiento["+n+"]' id='tipoEstablecimiento["+n+"]' class='comboMedio' ><option>::Seleccione::</option></select></td>";
			fila += "<td align='left'><input type='text' name='direccionSucursal["+n+"]' id='direccionSucursal["+n+"]' class='cajaGrande'></td>";
			fila += "<td align='left'>";
			fila += "<input type='hidden' name='dptoSucursal["+n+"]' id='dptoSucursal["+n+"]' class='cajaGrande' value='15'>";
			fila += "<input type='hidden' name='provSucursal["+n+"]' id='provSucursal["+n+"]' class='cajaGrande' value='01'>";
			fila += "<input type='hidden' name='distSucursal["+n+"]' id='distSucursal["+n+"]' class='cajaGrande'>";
			fila += "<input type='text' name='distritoSucursal["+n+"]' id='distritoSucursal["+n+"]' class='cajaPequena' readonly='readonly' onclick='abrir_formulario_ubigeo_sucursal("+n+");'/>";
			fila += "<a href='#' onclick='abrir_formulario_ubigeo_sucursal("+n+");'><image src='"+base_url+"images/ver.png' border='0'></a>";
			fila += "</td>";
			if($('#proyecto_persona').val()!=''){
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
function editar_proyecto(proyecto){
        var url = base_url+"index.php/maestros/proyecto/editar_proyecto/"+proyecto;
	$("#zonaContenido").load(url);
}
function eliminar_proyecto(proyecto){
	if(confirm('Esta seguro desea eliminar este proyecto?')){
		dataString = "proyecto="+proyecto;
		url = base_url+"index.php/maestros/proyecto/eliminar_proyecto";
		$.post(url,dataString,function(data){
			url = base_url+"index.php/maestros/proyecto/proyectos";
			location.href = url;
		});
	}
}



function ver_proyecto(proyecto){
	url = base_url+"index.php/maestros/proyecto/ver_proyecto/"+proyecto;
	$("#zonaContenido").load(url);
}


function ver_comprobantes_proyecto(proyecto){
	url = base_url+"index.php/maestros/proyecto/obtener_comprobantes_proyecto";
			 $('#tbl_proyecto_facturas tbody').html('');
			 $('#tbl_proyecto_boletas tbody').html('');
			 $('#tbl_proyecto_comprobantes tbody').html('');

	$.ajax({
		type: 'POST',
		data:{proyecto:proyecto},
		url: url,
		dataType: 'json',
		beforeSend:function(data){
		},
		error: function (XRH, error) {
			alert('faallo');
		},
		success: function (data){
			var fila = '';
			var indice = 1;
			var v = "V";
			console.log(data);
			$.each(data, function(i,item){
				indice = indice + i;
			 $('.modal-title').text(item.proyecto);
			 fila ="<tr>"
			 fila +="<td>"+indice+"</td>";
			 fila +="<td>"+item.serie+" - "+item.numero+"</td>";
			 fila +="<td>"+item.razon_social+"</td>";
			 fila +="<td>"+item.fecha+"</td>";
			 fila +="<td>"+item.monto+"</td>";
			 if (item.tipo_documento == 'F') {
			 	fila +="<td><a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete("+item.cod_comprobante+",8,1,"+'"'+v+'"'+")'><img src='"+base_url+"images/pdf.png' width='16' height='16' border='0' title='Modificar'></a></td>";
			 	fila += "</tr>";
			 	if(item.message == 1)
			 	$('#tbl_proyecto_facturas tbody').append(fila);
			 }else if(item.tipo_documento == 'B'){
			 	fila +="<td><a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete("+item.cod_comprobante+",9,1,"+'"'+v+'"'+")'><img src='"+base_url+"images/pdf.png' width='16' height='16' border='0' title='Modificar'></a></td>";
			 	fila += "</tr>";
			 	if(item.message == 1)
			 	 $('#tbl_proyecto_boletas tbody').append(fila);
			 }else{
			 	fila +="<td><a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete("+item.cod_comprobante+",14,1,"+'"'+v+'"'+")'><img src='"+base_url+"images/pdf.png' width='16' height='16' border='0' title='Modificar'></a></td>";
			 	fila += "</tr>";
			 	if(item.message == 1)
			 	 $('#tbl_proyecto_comprobantes tbody').append(fila);
			 }
			  
			})
			 
		}
	})
}


function atras_proyecto(){
	location.href = base_url+"index.php/maestros/proyecto/proyectos";
}


function agregar_direccion_proyecto() {
	

	posicion = $("#posicionEditar").val();
	alert(posicion);
	if(posicion.trim()!=""){
		a='descripcionDireccion['+posicion+']';
		b='referenciaDireccion['+posicion+']';
		c='cboDepartamentoD['+posicion+']';
		d='cboProvinciaD['+posicion+']';
		e='cboDistritoD['+posicion+']';
		f='cordenadaY['+posicion+']';
		g='cordenadaX['+posicion+']';
		
		descripcionGeneral=$("#descripcion").val();
		$("#idlDescripcionDireccion"+posicion).html(descripcionGeneral);
		document.getElementById(a).value=descripcionGeneral;
		
		referenciaGeneral=$("#referencia").val();
		$("#idlReferenciaDireccion"+posicion).html(referenciaGeneral);
		document.getElementById(b).value=referenciaGeneral;
		
		document.getElementById(c).value=$("#cboDepartamento").val();
		document.getElementById(d).value=$("#cboProvincia").val();
		document.getElementById(e).value=$("#cboDistrito").val();
		
		$("#idlNombresUbigeo"+posicion).html($("#cboDepartamento option:selected").text()+' / '+$("#cboProvincia option:selected").text()+' / '+$("#cboDistrito option:selected").text());
		
		document.getElementById(f).value=$("#cordY").val();
		document.getElementById(g).value=$("#cordX").val();
		
		limpiarDireccion();
		
	}else{
		direccionCodigo = null;
	    descripcionDireccion = $("#descripcion").val();
	    referenciaDireccion = $("#referencia").val();
	    cboDepartamento =  $("#cboDepartamento").val();
	    cboProvincia = $("#cboProvincia").val();
	    cboDistrito = $("#cboDistrito").val();
	    
	    nombreDepartamento =  $("#cboDepartamento option:selected").text();
	    nombreProvincia = $("#cboProvincia option:selected").text();
	    nombreDistrito = $("#cboDistrito  option:selected").text();
	    
	    cordenadaY = $("#cordY").val();
	    cordenadaX = $("#cordX").val();    
	    n = document.getElementById('tblDetalleDireccionProyecto').rows.length;   
	    j = n + 1;
	    if (j % 2 == 0) {
	        clase = "itemParTabla";
	    } else {
	        clase = "itemImparTabla";
	    }    

	    
	    
	    fila = '<tr id="' + n + '" class="' + clase + '">';
	    fila += '<td width="2%"><div align="center"  style="width: 70%;" ><font color="red"  style="width: 100%;" ><strong>';
	    fila += '<a href="javascript:;" onclick="eliminar_direccion(' + n + ');"><span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a>';
	    fila += '</strong></font></div></td>';
		fila += '<td width="2%">' + n + '</td>';
	    fila += '<input type="hidden" name="direccionCodigo[' + n + ']"  id="direccionCodigo[' + n + ']"  />	';				
	    fila += '<td width="5%"><div align="left" style="width: 60%;" >';
	    fila += '<label id="idlDescripcionDireccion' + n + '" >' + descripcionDireccion + '</label>';
	    fila += '<input type="hidden" name="descripcionDireccion[' + n + ']"   id="descripcionDireccion[' + n + ']"  value="' + descripcionDireccion + '"/>';
	    fila += '</div></td>';
		fila += ' <td width="5%"> <div align="left"  style="width: 60%;" >';
	    fila += '<label id="idlReferenciaDireccion' + n + '">' + referenciaDireccion + '</label>';
	    fila += '<input type="hidden" name="referenciaDireccion[' + n + ']"  id="referenciaDireccion[' + n + ']"  value="' + referenciaDireccion + '"/>';
	    fila += '</div></td>';
	    fila += '<td width="10%">	    ';
	    fila += ' <input type="hidden"  name="cboDepartamentoD[' + n + ']" id="cboDepartamentoD[' + n + ']"	value="' + cboDepartamento + '"/>';
	    fila += '<input type="hidden"  name="cboProvinciaD[' + n + ']" id="cboProvinciaD[' + n + ']" value="' + cboProvincia + '"/>';
	    fila += '<input type="hidden"  name="cboDistritoD[' + n + ']"	id="cboDistritoD[' + n + ']"	value="' + cboDistrito + '"/>	';
	    fila += '<label id="idlNombresUbigeo' + n + '">'+nombreDepartamento+' / '+nombreProvincia+' / '+nombreDistrito+'</label>';
	    fila += '<textarea  name="cordenadaX[' + n + ']" id="cordenadaX[' + n + ']"  style="display:none;" >'+ cordenadaX +'</textarea>';
	    fila += '<textarea  name="cordenadaY[' + n + ']" id="cordenadaY[' + n + ']"  style="display:none;">'+ cordenadaY +'</textarea>';
	    fila += '<input type="hidden" class="cajaMinima" name="direaccion[' + n + ']" id="direaccion[' + n + ']" value="n">';
	    fila += '</td>';
	    fila += '<td width="5%"><div align="left"  style="width: 60%;" >';
	    fila += '<a href="javascript:;" onclick="editar_direccion(' + n + ')"><img src="'+base_url+'images/modificar.png" width="16" height="16" border="0" title="Modificar"></a>';
	    fila += '</div></td>';
	    fila += '</tr>';
	    
	    $("#tblDetalleDireccionProyecto").append(fila);
	    $("#direccion").focus();
	    limpiarDireccion();
	}
	
	

}

function listar_departamento(n){
    var base_url = $("#base_url").val();
    a      = "cboDepartamento["+n+"]";
    url    = base_url+"index.php/maestros/proyecto/JSON_listar_departamento";
    select = document.getElementById(a);
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo      = item.UBIGC_CodDpto;
            descripcion = item.UBIGC_Descripcion;
            opt         = document.createElement('option');
            texto       = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;
            select.appendChild(opt);
        });
    });
}

function eliminar_direccion(n) {
    if (confirm('Esta seguro que desea eliminar esta direccion ffff?')) {
    	a = "direccionCodigo[" + n + "]";
    	b = "direaccion[" + n + "]";
        fila = document.getElementById(a).parentNode;
        fila.style.display = "none";
        document.getElementById(b).value = "e";
    }
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


function cargar_provincias(obj){
    departamento = obj.value;
    provincia    = "01";
    if(departamento!='00'){
        url = base_url+"index.php/maestros/ubigeo/cargar_ubigeos/"+departamento+"/"+provincia;
        $("#divUbigeos").load(url);
    }
}


function cargar_distritos(obj){
    departamento = $("#cboDepartamento").val();
    provincia    = obj.value;
    if(departamento!='00' && provincia!='00'){
        url = base_url+"index.php/maestros/ubigeo/cargar_ubigeos/"+departamento+"/"+provincia;
        $("#divUbigeos").load(url);
    }
}

function limpiarDireccion(){
	$('#descripcion').val("");
	$('#referencia').val("");
	$('#cboDepartamento').val("");
	$('#cboProvincia').val("");
	$('#cboDistrito').val("");
	$('#cordY').val("");
	$('#cordX').val("");
	$('#codigoDireccion').val("");
	$('#posicionEditar').val("");
	$('#idLcordY').html("");
	$('#idLcordX').html("");
	
}


function verEstados() {
	var currentTab = $(event.target),
		idProyecto = $("#id-proyecto").val();

	if(currentTab.parent().hasClass('ui-state-active')) {
		if(!confirm("è¢ƒDesea volver a cargar la data?")) return;
	}

	solicitarEstado(idProyecto, 'ov');
	solicitarEstado(idProyecto, 'oc');
	solicitarEstado(idProyecto, 'os');
}

function solicitarEstado(idProyecto, tipo) {
	var tables = {
		'ov' : "#tblOrdenesVenta",
		'oc' : "#tblOrdenesCompra",
		'os' : "#tblOrdenesServicio"
	},
	currentTable = $(tables[tipo]);

	currentTable.hide();
	currentTable.parent().find('.loading').show();

	currentTable.find('tbody').html('');
	$.ajax({
		url: base_url+'index.php/maestros/proyecto/estado/'+idProyecto+"/"+tipo,
		dataType: 'json'
	})
	.done(function(data) {
		$.each(data.ordenes, function(index, orden) {
			var row = '<tr style="font-weight: bold;">';
			row += '<td>'+orden.cliente+'</td>';
			row += '<td style="text-align:center;"><a style="color: blue;" target="blank" href="'+orden.documento_link+'">'+orden.documento_numero+'</a></td>';
			row += '<td>'+orden.moneda+'</td>';
			row += '<td style="text-align: right;">'+(orden.total == 0 ? '---' : orden.total.format())+'</td>';
			row += '<td style="text-align: right;">'+(orden.total_soles == 0 ? '---' : orden.total_soles.format())+'</td>';
			row += '<td style="text-align: right;">'+(orden.total_dolares == 0 ? '---' : orden.total_dolares.format())+'</td>';
			row += '<td style="text-align: right;">'+(orden.total_facturado == 0 ? '---' : orden.total_facturado.format())+'</td>';
			row += '<td style="text-align: right;">'+(orden.total_facturado_saldo == 0 ? '---' : orden.total_facturado_saldo.format())+'</td>';
			row += '<td style="text-align: right;">'+(orden.total_pagado == 0 ? '---' : orden.total_pagado.format())+'</td>';
			row += '<td style="text-align: right;">'+(orden.total_pagado_saldo == 0 ? '---' : orden.total_pagado_saldo.format())+'</td>';
			row += '</tr>';
			currentTable.find('tbody').append(row);

			$.each(orden.comprobantes, function(index, comprobante) {
				 var row = '<tr>';
				 row += '<td><div style="padding-left: 20px;text-align: right;">'+comprobante.fecha+'</div></td>';
				 row += '<td style="text-align:center;"><a style="color: blue;" target="blank" href="'+comprobante.comprobante_link+'">'+comprobante.comprobante_numero+'</a></td>';
				 row += '<td>'+comprobante.moneda+'</td>';
				 row += '<td style="text-align: right;">'+(comprobante.total == 0 ? '---' : comprobante.total.format())+'</td>';
				 row += '<td style="text-align: right;">'+(comprobante.total_soles == 0 ? '---' : comprobante.total_soles.format())+'</td>';
				 row += '<td style="text-align: right;">'+(comprobante.total_dolares == 0 ? '---' : comprobante.total_dolares.format())+'</td>';
				 row += '<td style="text-align: right;">'+(comprobante.total_dolares == 0 ? '---' : comprobante.total_dolares.format())+'</td>';
				 row += '<td style="text-align: right;"></td>';
				 row += '<td style="text-align: right;">'+(comprobante.total_pagado_dolares == 0 ? '---' : comprobante.total_pagado_dolares.format())+'</td>';
				 row += '<td style="text-align: right;">'+(comprobante.total_pagado_saldo == 0 ? '---' :  comprobante.total_pagado_saldo.format())+'</td>';
				 row += '</tr>';

				 currentTable.find('tbody').append(row);
			});
		});

		currentTable.find('.total-conv-soles').text(data.total_soles == 0 ? '---' : data.total_soles.format());
		currentTable.find('.total-conv-dolares').text(data.total_dolares == 0 ? '---' : data.total_dolares.format());

		currentTable.find('.total-facturado').text(data.total_facturado == 0 ? '---' : data.total_facturado.format());
		currentTable.find('.total-facturado-saldo').text(data.total_facturado_saldo == 0 ? '---' : data.total_facturado_saldo.format());

		currentTable.find('.total-pagado').text(data.total_pagado == 0 ? '---' : data.total_pagado.format());
		currentTable.find('.total-pagado-saldo').text(data.total_pagado_saldo == 0 ? '---' : data.total_pagado_saldo.format());

		currentTable.show();
		currentTable.parent().find('.loading').hide();
	})
	.fail(function() {
		currentTable.show();
		currentTable.parent().find('.loading').hide();
	});
	
}

function verBalance() {
	var currentTable = $("#tblBalance"),
		currentTab = $(event.target).parent(),
		idProyecto = $("#id-proyecto").val();

	if(currentTab.hasClass('ui-state-active')) {
		if(!confirm("è¢ƒDesea volver a cargar el balance?")) return;
	}

	currentTable.hide();
	currentTable.parent().find('.loading').show();

	currentTable.find('tbody').html('');
	$.ajax({
		url: base_url+'index.php/maestros/proyecto/balance/'+idProyecto,
		dataType: 'json'
	})
	.done(function(data) {
		$.each(data.ordenes, function(index, orden) {
			var row = '<tr>';
			row += '<td><b>'+orden.cliente+'</b></td>';
			row += '<td style="text-align:center;" colspan="2"><a style="color: blue;" target="blank" href="'+orden.documento_link+'">'+orden.documento_numero+'</a></td>';
			row += '<td style="text-align: right;"><b></b></td>';
			row += '<td style="text-align: right;"><b>'+(orden.total_dolares == 0 ? '---' : orden.total_dolares.format())+'</b></td>';
			row += '<td style="text-align: right;"><b>'+(orden.total_ingresos == 0 ? '---' : orden.total_ingresos.format())+'</b></td>';
			row += '<td style="text-align: right;"><b>'+(orden.total_egresos == 0 ? '---' : orden.total_egresos.format())+'</b></td>';
			row += '<td style="text-align: right;"><b>'+(orden.total_liquidez == 0 ? '---' : orden.total_liquidez.format())+'</b></td>';
			row += '</tr>';
			currentTable.find('tbody').append(row);

			$.each(orden.productos, function(index, producto) {
				var row = '<tr>';
				row += '<td><div style="max-width: 300px;padding-left: 20px">'+producto.descripcion+'</div></td>';
				row += '<td  style="text-align: right;">'+producto.cantidad+'</td>';
				row += '<td>'+producto.medida +'</td>';
				row += '<td style="text-align: right;">'+(producto.unitario_dolar == 0 ? '---' : producto.unitario_dolar.format())+'</td>';
				row += '<td style="text-align: right;">'+(producto.total_dolar == 0 ? '---' : producto.total_dolar.format())+'</td>';
				row += '<td style="text-align: right;">'+(producto.ingresos == 0 ? '---' : producto.ingresos.format())+'</td>';
				row += '<td style="text-align: right;">'+(producto.egresos == 0 ? '---' : producto.egresos.format())+'</td>';
				row += '<td style="text-align: right;">'+(producto.liquidez == 0 ? '---' : producto.liquidez.format())+'</td>';
				row += '</tr>';
				currentTable.find('tbody').append(row);
			});

			if(index + 1 < data.ordenes.length) currentTable.find('tbody').append('<tr><td colspan="8"><hr></td></tr>');
		});

		currentTable.find(".total-precio-dolares").text(data.total_precio_dolares == 0 ? '---' : data.total_precio_dolares.format());
		currentTable.find('.total-ingresos').text(data.total_ingresos == 0 ? '---' : data.total_ingresos.format());
		currentTable.find('.total-egresos').text(data.total_egresos == 0 ? '---' : data.total_egresos.format());
		currentTable.find('.total-liquidez').text(data.total_liquidez == 0 ? '---' : data.total_liquidez.format());

		currentTable.show();
		currentTable.parent().find('.loading').hide();
	})
	.fail(function() {
		currentTable.show();
		currentTable.parent().find('.loading').hide();
	});
	
}

function comprobante_ver_pdf_conmenbrete(comprobante,documento,imagen,tipo) {
    //tipo="V";
    var url = base_url + "index.php/maestros/configuracionimpresion/impresionDocumento/"+comprobante+"/"+documento+"/"+imagen+"/"+tipo+"/";
    window.open(url, '', "width=800,height=600,menubars=no,resizable=no;");
}