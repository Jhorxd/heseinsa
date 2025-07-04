var base_url
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    
    $("#imgGuardarDirectivo").click(function(){
        modo = $("#modo").val();             
        
        if($('#tipo_documento').val()==0){
            alert('Seleccione el tipo de documento');
            $('#tipo_documento').focus();
            return false;
        }        
        
        if($('#numero_documento').val()==''){
            alert('Ingrese el n\u00FAmero de documento');
            $('#numero_documento').focus();
            return false;
        }
        
        if($('#nombres').val()==''){
            alert('Ingrese el nombre del empleado');
            $('#nombres').focus();
            return false;
        }
        
        if($('#paterno').val()==''){
            alert('Ingrese el apellido del empleado');
            $('#paterno').focus();
            return false;
        }
        
        if($('#materno').val()==''){
            alert('Ingrese el apellido del empleado');
            $('#materno').focus();
            return false;
        }

        if($('#fechanac').val()==''){
            //alert('Ingrese el a\u00F1o de nacimiento del empleado');
            //$('#fechanac').focus();
            //return false;
            $('#fechanac').val("2000-01-01");
        }
        
        if($('#cboNacimientovalue').val()==''){
            //alert('Seleccione el lugar de nacimiento');
            //$('#cboNacimientovalue').focus();
            //return false;
            $('#cboNacimientovalue').val("150101");
        }
        /*alert($('#foto').val())
        if($('#foto').val()==''){
            alert('Seleccione una foto para el empleado');
            $('#foto').focus();
            return false;
        } 
        */
        if($('#cboDistrito').val()==''){
            alert('Seleccione el lugar de residencia');
            $('#cboDistrito').focus();
            return false;
        }
        
        if($('#direccion').val()==''){
            alert('Ingrese la direcci\u00F3n de residencia');
            $('#direccion').focus();
            return false;
        }
        
        if($('#telefono').val()==''){
            //alert('Ingrese el tel\u00E9fono del empleado');
            //$('#telefono').focus();
            //return false;
        }
        
       /* if($('#contrato').val()==''){
            alert('Ingrese el n\u00FAmero de contrato');
            $('#contrato').focus();
            return false;
        }*/
        
        if($('#cboCargo').val()==0){
            alert('Seleccione un Cargo correspondiente.')
            $('#cboCargo').focus();
            return false;
        }

        /*if($('#cboCategoria').val()==0){
            alert('Seleccione un categoria de cliente para futuras ventas')
            $('#cboCategoria').focus();
            return false;
        }*/

        dataString = $('#frmDirectivo').serialize();
        $("#container").show();
        $("#frmDirectivo").submit();       

        //if(modo=='insertar'){ 
                        
            //document.forms["frmDirectivo"].action=base_url+"index.php/maestros/directivo/insertar_directivo";
            //document.forms["frmDirectivo"].submit();
        //}
        //else if(modo=='modificar'){
           // document.forms["frmDirectivo"].action=base_url+"index.php/maestros/directivo/modificar_directivo";
          //  document.forms["frmDirectivo"].submit();
        //}
    });
    $("#buscarDirectivo").click(function(){
        $("#form_busqueda").submit();
    });	
    $("#nuevoDirectivo").click(function(){
        url = base_url+"index.php/maestros/directivo/nuevo_directivo";
        $("#zonaContenido").load(url);
    });
    $("#limpiarDirectivo").click(function(){
        url = base_url+"index.php/maestros/directivo/directivos";
        location.href=url;
    });
    $("#imgCancelarDirectivo").click(function(){
        base_url = $("#base_url").val();
        location.href = base_url+"index.php/maestros/directivo/directivos";
    });
    $("#imprimirDirectivo").click(function(){
            var docum = $("#txtNumDoc").val();
            var nombre = $("#txtNombre").val();
            var empresa = $("#cboCompania").val();
            

            var docum = sintilde(docum);
            var nombre = sintilde(nombre);
        ///
          if(docum==""){docum="--";}
          if(nombre==""){nombre="--";}
           if(empresa==""){empresa="--";}

        url = base_url+"index.php/maestros/directivo/registro_directivo_pdf/"+docum+"/"+ nombre+"/"+empresa;
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;");
        });
   
    
    container = $('div.container');
    $("#frmDirectivo").validate({
        event    : "blur",
        rules    : {
            'nombres'         : "required",
            'paterno'         : "required",
            'email'           : {
                required:false,
                email:true
            },
            'tipo_documento'  : "required",
            'cboSexo'         : "required",
            'cboNacionalidad' : "required"
        },
        debug    : true,
        errorContainer      : "container",
        errorLabelContainer : $(".container"),
        wrapper             : 'li',
        submitHandler       : function(form){
            dataString  = $('#frmDirectivo').serialize();                               
            modo        = $("#modo").val();
            $('#VentanaTransparente').css("display","block");
            if(modo=='insertar'){
                url = base_url+"index.php/maestros/directivo/insertar_directivo";
                $.post(url,dataString,function(data){
                    //alert('codigo:'+data.directivo);
                    $("#VentanaTransparente").css("display","none");
                    //alert('Se ha ingresado un empleado.');
                    location.href = base_url+"index.php/maestros/directivo/directivos";
                });
            }
            else if(modo=='modificar'){
                $('tipo_documento').val('2');
                $('cboNacionalidad').val('193');
                url = base_url+"index.php/maestros/directivo/modificar_directivo";
                $.post(url,dataString,function(data){
                    $("#VentanaTransparente").css("display","none");
                    //alert('Su registro ha sido modificado.');
                    location.href = base_url+"index.php/maestros/directivo/directivos";
                });
            }
        }
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
            //a = "nombreSucursal["+n+"]";
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
            //document.getElementById(a).focus();
            listar_tipoEstablecimientos(n);
        }
    });
        
        
        
});
function editar_directivo(directivo){
    var url = base_url+"index.php/maestros/directivo/editar_directivo/"+directivo;
    $("#zonaContenido").load(url);
}
function ver_directivo(directivo){
    url = base_url+"index.php/maestros/directivo/ver_directivo/"+directivo;
    $("#zonaContenido").load(url);
}
function atras_directivo(){
    location.href = base_url+"index.php/maestros/directivo/directivos";
}

function eliminar_directivo(directivo){
    if(confirm('Esta seguro desea eliminar este empleado?')){
        dataString = "directivo="+directivo;
        url = base_url+"index.php/maestros/directivo/eliminar_directivo";
        $.post(url,dataString,function(data){
            url = base_url+"index.php/maestros/directivo/directivos";
            location.href = url;
        });
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

function abrir_formulario_ubigeo(){
    ubigeo = $("#cboNacimiento").val();
    if(ubigeo=='')
        ubigeo='000000';
    url = base_url+"index.php/maestros/ubigeo/formulario_ubigeo/"+ubigeo;
    window.open(url,'Formulario Ubigeo','menubar=no,resizable=no,width=610,height=110');
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
            //$("#ruc").val('00000000000');
            //$("#razon_social").val('No usado');
            $.each(data,function(i,item){
                $("#personacod").val(item.codigo);
                //$("#empresa_persona").val(item.codigo);
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
                //$("#ruc_persona").val(item.ruc);
                       
                $("#cboDepartamento").val(item.departamento);
                $("#cboProvincia").val(item.provincia);
                $("#cboDistrito").val(item.distrito);
                $("#direccion").val(item.direccion);
                $("#telefono").val(item.telefono);
                $("#movil").val(item.movil);
                $("#fax").val(item.fax);
                $("#email").val(item.correo);
                $("#web").val(item.paginaweb);
                //$("#ctactesoles").val(item.ctactesoles); 
                //$("#ctactedolares").val(item.ctactedolares); 

                //$("#empresa_persona").val(item.codigo); 
                $("#persona_msg").html('<b>Se ha encontrado una persona con el número de '+tipodesc+ ' indicado.</b>');
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
    $("#categoria").val('');
    $("#forma_pago").val('');
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
    $("#personacod").val('');
    
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
    $("#categoria").attr('disabled', estado);
    $("#forma_pago").attr('disabled', estado);
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

function clientes_directivo(codigo){
    url = base_url+"index.php/maestros/directivo/relacion_clientes/"+codigo;
    window.open(url,'Formulario Ubigeo','menubar=no,resizable=no,width=800,height=700');
}