var base_url
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    if($("#id").val()=='') 
        cambiar_estado_campos(true);
    else{
        $("#cboTipoCodigo, #ruc").attr('readonly',true);
        $("#tipo_documento, #numero_documento").attr('readonly',true);
    }
    $("#imgGuardarProveedor").click(function(){
		dataString = $('#frmProveedor').serialize();
		$("#container").show();
		$("#frmProveedor").submit();
    });
    $("#buscarProveedor").click(function(){
		$("#form_busqueda").submit();
    });	
    $("#nuevoProveedor").click(function(){
		url = base_url+"index.php/compras/proveedor/nuevo_proveedor";
		$("#zonaContenido").load(url);
    });
    $("#limpiarProveedor").click(function(){
        url = base_url+"index.php/compras/proveedor/proveedores/";
        location.href=url;
    });
    $("#imgCancelarProveedor").click(function(){
	base_url = $("#base_url").val();
        location.href = base_url+"index.php/compras/proveedor/proveedores";
    });

$("#imprimirProveedor").click(function(){
            var docum = $("#txtNumDoc").val();
            var nombre = $("#txtNombre").val();
            var telefono = $("#txtTelefono").val();
            
           
            var docum = sintilde(docum);
            var nombre= sintilde(nombre);
            var telefono= sintilde(telefono);
        ///
          if(docum==""){docum="--";}
          if(nombre==""){nombre="--";}
          if(telefono==""){telefono="--";}

        url = base_url+"index.php/compras/proveedor/registro_proveedor_pdf/"+telefono+"/"+docum+"/"+ nombre;
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;");
    });

    $(":radio").click(function(){
        valor = $(this).attr("value");
        limpiar_campos();
        cambiar_estado_campos(true);
        if(valor==0){//Persona
            $("#datosEmpresa").hide();
            $("#datosPersona").show();
            $("#idGeneral").hide();
            $("#idSucursales").hide();
            $("#idContactos").hide();
            $("#idAreas").hide();
            $("#ruc").val('00000000000');
            $("#razon_social").val('No usado')
            $("#numero_documento").focus();
            $(".container").hide();
        }
        else if(valor==1){//Empresa
            $("#datosEmpresa").show();
            $("#datosPersona").hide();
            $("#idGeneral").show();
            $("#idSucursales").show();
            $("#idContactos").show();
            $("#idAreas").hide();
            $("#nombres").val('No usado');
            $("#paterno").val('No usado'); 
            $(".container").hide();
            $("#ruc").focus();
        }
    });
	container = $('div.container');
 	$("#frmProveedor").validate({
		event    : "blur",
		rules    : {
                            'ruc'             : {required:true},
                            'razon_social'    : "required",
                            'nombres'         : "required",
                            'paterno'         : "required",
                            'email'           : {required:false,email:true},
                            'tipo_documento'  : "required",
                            'cboSexo'         : "required",
                            'cboNacionalidad' : "required",
                           },
		debug    : true,
		errorContainer      : "container",
		errorLabelContainer : $(".container"),
		wrapper             : 'li',
		submitHandler       : function(form){
                    dataString  = $('#frmProveedor').serialize();
                    modo        = $("#modo").val();
                    $('#VentanaTransparente').css("display","block");
                    if(modo=='insertar'){
                        url = base_url+"index.php/compras/proveedor/insertar_proveedor";
                        $.post(url,dataString,function(data){
                        $("#VentanaTransparente").css("display","none");
                                alert('Se ha ingresado un proveedor.');
                                location.href = base_url+"index.php/compras/proveedor/proveedores";
                        });
                    }
                    else if(modo=='modificar'){
                        $('tipo_documento').val('2');
                        $('cboNacionalidad').val('193');
                        url = base_url+"index.php/compras/proveedor/modificar_proveedor";
                        $.post(url,dataString,function(data){
                                $("#VentanaTransparente").css("display","none");
                                alert('Su registro ha sido modificado.');
                                location.href = base_url+"index.php/compras/proveedor/proveedores";
                        });
                    }
		}
	});
    //Ocultar capas
	
	
	$('#idTipos').click(function(){
		$('#datosMarcas').hide();
		$('#datosGenerales').hide();
		$('#datosSucursales').hide();
		$('#datosContactos').hide();
		$("#datosCuentas").hide();
		$('#datosAreas').hide();
		$('#datosRegistro').hide();
		$('#datosTipos').show();
		$('#opcion').val('6');
		$('#botonBusqueda').show();
		$('#nuevoRegistro').show();
	});
	
	$('#idMarcas').click(function(){
		$('#datosMarcas').show();
		$('#datosGenerales').hide();
		$('#datosSucursales').hide();
		$('#datosContactos').hide();
		$('#datosAreas').hide();
		$("#datosCuentas").hide();
		$('#datosRegistro').hide();
		$('#datosTipos').hide();
		$('#opcion').val('7');
		$('#botonBusqueda').show();
		$('#nuevoRegistro').show();
	});
	
	
    $('#idGeneral').click(function(){
        $('#datosGenerales').show();
        $('#datosSucursales').hide();
        $('#datosContactos').hide();
        $('#datosMarcas').hide();
        $('#datosAreas').hide();
        $("#datosCuentas").hide();
		$('#datosTipos').hide();
        $('#nuevoRegistro').hide();
        $('#opcion').val('1');
        $("#botonBusqueda").show();
    });

    $('#idSucursales').click(function(){
        $('#datosGenerales').hide();
        $('#datosSucursales').show();
        $('#datosContactos').hide();
        $('#datosMarcas').hide();
        $('#datosAreas').hide();
		$('#datosTipos').hide();
		$("#datosCuentas").hide();
        $('#nuevoRegistro').show();
        $('#opcion').val('2');
        $("#botonBusqueda").hide();
    });

    $('#idContactos').click(function(){
        $('#datosGenerales').hide();
        $('#datosSucursales').hide();
        $('#datosContactos').show();
        $('#datosAreas').hide();
        $('#datosMarcas').hide();
        $("#datosCuentas").hide();
		$('#datosTipos').hide();
        $('#nuevoRegistro').show();
        $('#opcion').val('3');
        $("#botonBusqueda").hide();
    });

    $('#idAreas').click(function(){
        $('#datosGenerales').hide();
        $('#datosSucursales').hide();
        $('#datosContactos').hide();
        $('#datosMarcas').hide();
        $('#datosAreas').show();
		$('#datosTipos').hide();
		$("#datosCuentas").hide();
        $('#nuevoRegistro').show();
		$('#opcion').val('4');
		$("#botonBusqueda").hide();
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

	//Para clientes
	$('#idGeneral2').click(function(){
        $('#datosGenerales').show();
        $('#datosSucursales').hide();
        $('#datosContactos').hide();
        $('#datosAreas').hide();
        $("#datosCuentas").hide();
        $('#nuevoRegistro2').hide();
        $('#opcion').val('1');
        //$("#botonBusqueda").show();
    });

    $('#idSucursales2').click(function(){
        $('#datosGenerales').hide();
        $('#datosSucursales').show();
        $('#datosContactos').hide();
        $("#datosCuentas").hide();
        $('#datosAreas').hide();
        $('#nuevoRegistro2').show();
        $('#opcion').val('2');
        //$("#botonBusqueda").hide();
    });

    $('#idContactos2').click(function(){
        $('#datosGenerales').hide();
        $('#datosSucursales').hide();
        $('#datosContactos').show();
        $("#datosCuentas").hide();
        $('#datosAreas').hide();
        $('#nuevoRegistro2').show();
        $('#opcion').val('3');
        //$("#botonBusqueda").hide();
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
			fila += "<div id='homonimos["+n+"]' style='display:none;background:#ffffff;width:300px;border:1px solid #cccccc;height:100px;overflow:auto;position:absolute;z-index:1;'></div>";
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
			fila  = "<tr class='itemParTabla' height='10px;'>";
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
		else if(opcion == 5){
			/* Agregar item a tabla de marcas */
			$("#msgRegistrosMarcas").hide();		
			n = (document.getElementById('tablaMarca').rows.length);
			a = "marcaNombre["+n+"]";
			j = n+1;
			fila  = "<tr>";
			fila += "<td align='center'>"+n+"</td>";
			fila += "<td align='left' style='position:relative;'>";
			fila += "<input type='hidden' name='marcaCodigo["+n+"]' id='marcaCodigo["+n+"]' class='cajaMedia'>";
			fila += "<input type='text' name='marcaNombre["+n+"]' readonly id='marcaNombre["+n+"]' class='cajaMedia'>";
			fila += "<a href='#' onclick='buscar_marca();'><img src='"+base_url+"images/ver.png' border='0'></a>";
			fila += "</td>";
			if($('#empresa_persona').val()!=''){
				fila += "<td align='center'>&nbsp;</td>";
				fila += "<td align='center'><a href='#' onclick='insertar_marca("+n+");'><img src='"+base_url+"images/save.gif' border='0'></a></td>";
			}
			else{
				fila += "<td>&nbsp;</td>";
				fila += "<td>&nbsp;</td>";
			}
			fila += "</tr>";
			$("#tablaMarca").append(fila);
			document.getElementById(a).focus();
			// listar_areas(n);
		
		}
		else if(opcion == 6){
			/* Agregar item a tabla de tipos */
			$("#msgRegistrosTipos").hide();		
			n = (document.getElementById('tablaTipo').rows.length);
			a = "tipoNombre["+n+"]";
			j = n+1;
			fila  = "<tr>";
			fila += "<td align='center'>"+n+"</td>";
			fila += "<td align='left' style='position:relative;'>";
			fila += "<input type='hidden' name='tipoCodigo["+n+"]' id='tipoCodigo["+n+"]' class='cajaMedia'>";
			fila += "<input type='text' name='tipoNombre["+n+"]' id='tipoNombre["+n+"]' readonly class='cajaMedia'>";
			fila += "<a href='#' onclick='buscar_tipo("+n+");'><img src='"+base_url+"images/ver.png' border='0'></a>";
			fila += "</td>";
			if($('#empresa_persona').val()!=''){
				fila += "<td align='center'>&nbsp;</td>";
				fila += "<td align='center'><a href='#' onclick='insertar_tipo("+n+");'><img src='"+base_url+"images/save.gif' border='0'></a></td>";
			}
			else{
				fila += "<td>&nbsp;</td>";
				fila += "<td>&nbsp;</td>";
			}
			fila += "</tr>";
			$("#tablaTipo").append(fila);
			document.getElementById(a).focus();
			// listar_areas(n);
		
		}
    });
});

////////////////////////////// NEGIN CUENTA ESMPRESAS

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
				console.log($dataString);
				$("#txtMoneda").val("::SELECCIONE::");
				$("#txtTipoCuenta").val("::SELECCIONE::");
				$("#txtBanco").val("::SELECCIONE::");
				$("#txtTitular").val("");
				$("#txtCuenta").val("");
				$("#txtOficina").val("");
				$("#txtSectoriza").val("");
				$("#txtInterban").val("");
			}
		}
		else{
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
		}
		else{

		}
	}

	function validateFormulario(){
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
			
			if($("#txtOficina").val() == "" || /^\s*$/.test($("#txtOficina").val())) {
				$("#txtOficina").css('background-color', '#FFC1C1').focus();
					return false;
			}
			
			if($("#txtSectoriza").val() == "" || /^\s*$/.test($("#txtSectoriza").val())) {
				$("#txtSectoriza").css('background-color', '#FFC1C1').focus();
					return false;
			}
			
			if($("#txtInterban").val() == "" || /^\s*$/.test($("#txtInterban").val())) {
				$("#txtInterban").css('background-color', '#FFC1C1').focus();
					return false;
			}

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

    		} });
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

/////////////////////// END CUENTAS BANCOS


function eliminar_marca(marca){
    if(confirm('Esta seguro desea eliminar esta marca?')){
		empresa = document.getElementById('empresa_persona').value;
        dataString        = "marca="+marca+"&empresa="+empresa;
        url = base_url+"index.php/compras/proveedor/eliminar_marca";
        $.post(url,dataString,function(data){
                $("#datosMarcas").html(data);
        });
    }
}

function eliminar_tipo(tipo){
    if(confirm('Esta seguro desea eliminar este tipo?')){
		proveedor = document.getElementById('id').value;
        dataString        = "tipo="+tipo+"&proveedor="+proveedor;
        url = base_url+"index.php/compras/proveedor/eliminar_tipo";
        $.post(url,dataString,function(data){
                $("#datosTipos").html(data);
        });
    }
}


function editar_proveedor(proveedor){
        var url = base_url+"index.php/compras/proveedor/editar_proveedor/"+proveedor;
	$("#zonaContenido").load(url);
}
function eliminar_proveedor(proveedor){
	if(confirm('Esta seguro desea eliminar este proveedor?')){
		dataString = "proveedor="+proveedor;
		url = base_url+"index.php/compras/proveedor/eliminar_proveedor";
		$.post(url,dataString,function(data){
			if ( data == 0 ){
				alert('Existen comprobantes relacionados a este proveedor, por ello no puede ser eliminado.');
			}
			else{
				url = base_url+"index.php/compras/proveedor/proveedores";
				location.href = url;
			}
		});
	}
}

function insertar_marca(id){
	a = "marcaCodigo["+id+"]";
	codigo   = document.getElementById(a).value;
	empresa = document.getElementById('empresa_persona').value;
	dataString  = "empresa="+empresa+"&codigo="+codigo;
	url = base_url+"index.php/maestros/empresa/insertar_marca";
	$.post(url,dataString,function(data){
		$("#datosMarcas").html(data);
	});
}

function insertar_tipo(id){
	a = "tipoCodigo["+id+"]";
	codigo   = document.getElementById(a).value;
	proveedor = document.getElementById('id').value;
	dataString  = "proveedor="+proveedor+"&codigo="+codigo;
	url = base_url+"index.php/maestros/empresa/insertar_tipo";
	$.post(url,dataString,function(data){
		$("#datosTipos").html(data);
	});
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

function listar_marcas(n){

	/* Logica por implementar */
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
function abrir_formulario_ubigeo(){
	ubigeo = $("#cboNacimiento").val();
        if(ubigeo=='')
            ubigeo='000000';
	url = base_url+"index.php/maestros/ubigeo/formulario_ubigeo/"+ubigeo;
	window.open(url,'Formulario Ubigeo','menubar=no,resizable=no,width=610,height=110');
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
function ver_proveedor(proveedor){
	url = base_url+"index.php/compras/proveedor/ver_proveedor/"+proveedor;
	$("#zonaContenido").load(url);
}
function atras_proveedor(){
	location.href = base_url+"index.php/compras/proveedor/proveedores";
}
function buscar_empresa(){
    var tipo = $("#cboTipoCodigo").val();
    var tipodesc = $('#cboTipoCodigo option:selected').text();
    var numero = $("#ruc").val();

   // var url = base_url+"index.php/maestros/empresa/JSON_busca_empresa_proveedor_xruc/"+tipo+'/'+numero;
    var url = base_url+"index.php/maestros/empresa/JSON_busca_empresa_xruc/"+tipo+'/'+numero;
    
    if(tipo!='0' && numero!=''){
        $.getJSON(url,function(data){
                limpiar_campos();
                $("#empresa_msg").html('<b>No Se ha encontrado una empresa con el número de '+tipodesc+ ' indicado.</b>'); 
                cambiar_estado_campos(false);
                $("#cboTipoCodigo").val(tipo);
                $("#ruc").val(numero);
                $("#nombres").val('No usado');
                $("#paterno").val('No usado');
                $.each(data,function(i,item){
                        $("#cboTipoCodigo").val(tipo);
                        $("#ruc").val(numero);
                        $("#razon_social").val(item.razon_social);
                        $("#cboDepartamento").val(item.departamento);
                        $("#cboProvincia").val(item.provincia);
                        $("#cboDistrito").val(item.distrito);
                        $("#direccion").val(item.direccion);
                        $("#telefono").val(item.telefono);
                        $("#movil").val(item.movil);
                        $("#fax").val(item.fax);
                        $("#email").val(item.correo);
                        $("#web").val(item.paginaweb);
                        $("#sector_comercial").val(item.sector_comercial);
                        $("#ctactesoles").val(item.ctactesoles);
                        $("#ctactedolares").val(item.ctactedolares);
                        
                        $("#empresa_persona").val(item.codigo); 
                         $("#empresa_msg").html("<b>Se ha encontrado una empresa con el número de "+tipodesc+ " indicado. <a href='#' style='background: #ffffcc; color: #666666; text-decoration: none; padding: 4px;font-size: 10pt;font-weight: bold' onClick='editar_proveedor("+item.cod_proveedor+")' >Click Aqui</a></b>");
                      alert('Se ha encontrado una empresa con el número de '+tipodesc+ ' indicado.');
                        
                        var codigo = $("#empresa_persona").val();
                        url = base_url+"index.php/maestros/empresa/TABLA_sucursales/"+ codigo + '/0/1';
                        $.post(url,'',function(data){
                                $("#datosSucursales").html(data);
                        });
                        
                        url = base_url+"index.php/maestros/empresa/TABLA_contactos/p/"+codigo+'/0/1';
                        $.post(url,'',function(data){
                                $("#datosContactos").html(data);
                        });
                });
        });
        
    }
}
function buscar_persona(){
    var tipo = $("#tipo_documento").val();
    var tipodesc = $('#tipo_documento option:selected').text();
    var numero = $("#numero_documento").val();

    var url = base_url+"index.php/maestros/persona/JSON_busca_persona_xdoc/"+tipo+'/'+numero;
    if(tipo!='0' && numero!=''){
        $.getJSON(url,function(data){
                limpiar_campos();
                $("#persona_msg").html('<b>No Se ha encontrado una persona con el número de '+tipodesc+ ' indicado.</b>'); 
                cambiar_estado_campos(false);
                $("#tipo_documento").val(tipo);
                $("#numero_documento").val(numero);
                $("#ruc").val('00000000000');
                $("#razon_social").val('No usado');
                $.each(data,function(i,item){
                        $("#tipo_documento").val(tipo);
                        $("#numero_documento").val(numero);
                        $("#nombres").val(item.nombre);
                        $("#cboNacimientovalue").val(item.ubignom);
                        $("#cboNacimiento").val(item.ubigcod);
                        $("#paterno").val(item.apepat);
                        $("#cboSexo").val(item.sexo);
                        $("#materno").val(item.apemat);
                        $("#cboEstadoCivil").val(item.estadocivil);
                        $("#cboNacionalidad").val(item.nacionalidad);
                        $("#ruc_persona").val(item.ruc);
                        
                        $("#cboDepartamento").val(item.departamento);
                        $("#cboProvincia").val(item.provincia);
                        $("#cboDistrito").val(item.distrito);
                        $("#direccion").val(item.direccion);
                        $("#telefono").val(item.telefono);
                        $("#movil").val(item.movil);
                        $("#fax").val(item.fax);
                        $("#email").val(item.correo);
                        $("#web").val(item.paginaweb);
                        $("#ctactesoles").val(item.ctactesoles);
                        $("#ctactedolares").val(item.ctactedolares);
                        
                        $("#empresa_persona").val(item.codigo); 
                       $("#persona_msg").html("<b>Se ha encontrado una empresa con el número de "+tipodesc+ " indicado. <a href='#' style='background: #ffffcc; color: #666666; text-decoration: none; padding: 4px;font-size: 10pt;font-weight: bold' onClick='editar_proveedor("+item.cod_proveedor+")' >Click Aqui</a></b>");
                        document.getElementById('guardarImagen').style.display = "none";
                   });
        });
        
    }
}
function limpiar_campos(){
    //Para los campos de la empresa
    $("#cboTipoCodigo").val('1');
    $("#ruc").val('');
    $("#razon_social").val('');
    $("#cboDepartamento").val('15');
    $("#cboProvincia").val('01');
    $("#cboDistrito").val('');
    $("#direccion").val('');
    $("#telefono").val('');
    $("#movil").val('');
    $("#fax").val('');
    $("#email").val('');
    $("#web").val('');
    $("#sector_comercial").val('');
    $("#ctactesoles").val('');
    $("#ctactedolares").val('');
    $("#datosSucursales").html('<table id="tablaSucursal" width="98%" class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="1"><tr align="center" bgcolor="#BBBB20" height="10px;"><td>Nro</td><td>Nombre&nbsp;(*)</td><td>Tipo Establecimiento&nbsp;(*)</td><td>Direccion Sucursal&nbsp;(*)</td><td>Distrito</td><td>Borrar</td><td>Editar</td></tr></table><div id="msgRegistros2" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>');
    $("#datosContactos").html('<table id="tablaContacto" class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="1"><tr align="center" bgcolor="#BBBB20" height="10px;"><td>Nro</td><td>Nombre del Contacto</td><td>Area</td><td>Cargo</td><td>Telefonos</td><td>E-mail</td><td>Borrar</td><td>Editar</td></tr></table><div id="msgRegistros" style="width:98%;text-align:center;height:20px;border:1px solid #000;">NO EXISTEN REGISTROS</div>');
    
    //Para los campos de la persona
    $("#tipo_documento").val('1');
    $("#numero_documento").val('');
    $("#nombres").val('');
    $("#cboNacimientovalue").val('');
    $("#cboNacimiento").val('');
    $("#paterno").val('');
    $("#cboSexo").val('0');
    $("#materno").val('');
    $("#cboEstadoCivil").val('');
    $("#cboNacionalidad").val('193');
    $("#ruc_persona").val('');
    
    $("#empresa_msg").html('');
    $("#persona_msg").html('');
}
function cambiar_estado_campos(estado){
    //Para los campos de la empresa
    $("#razon_social").attr('disabled', estado);
    $("#cboDepartamento").attr('disabled', estado);
    $("#cboProvincia").attr('disabled', estado);
    $("#cboDistrito").attr('disabled', estado);
    $("#direccion").attr('disabled', estado);
    $("#telefono").attr('disabled', estado);
    $("#movil").attr('disabled', estado);
    $("#fax").attr('disabled', estado);
    $("#email").attr('disabled', estado);
    $("#web").attr('disabled', estado);
    $("#sector_comercial").attr('disabled', estado);
    $("#ctactesoles").attr('disabled', estado);
    $("#ctactedolares").attr('disabled', estado);
    
    //Para los campos de la persona
    $("#nombres").attr('disabled', estado);
    $("#cboNacimientovalue").attr('disabled', estado);
    $("#paterno").attr('disabled', estado);
    $("#cboSexo").attr('disabled', estado);
    $("#materno").attr('disabled', estado);
    $("#cboEstadoCivil").attr('disabled', estado);
    $("#cboNacionalidad").attr('disabled', estado);
    $("#ruc_persona").attr('disabled', estado);
    
}
function sintilde(cadena){
   
   var specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";

   
   for (var i = 0; i < specialChars.length; i++) {
       cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
   }   

   // Lo queremos devolver limpio en minusculas
   cadena = cadena.toLowerCase();

   // Quitamos acentos y "ñ". Fijate en que va sin comillas el primer parametro
   cadena = cadena.replace(/á/gi,"a");
   cadena = cadena.replace(/é/gi,"e");
   cadena = cadena.replace(/í/gi,"i");
   cadena = cadena.replace(/ó/gi,"o");
   cadena = cadena.replace(/ú/gi,"u");
   cadena = cadena.replace(/ñ/gi,"n");
   return cadena;
}

