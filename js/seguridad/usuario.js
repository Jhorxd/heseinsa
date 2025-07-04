var base_url;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    $("#nuevoUsuario").click(function(){
        url = base_url+"index.php/seguridad/usuario/nuevo_usuario";
        location.href = url;
    });

    $("#grabarUsuario").click(function(){
        var idPersona = $("#idPersona").val();
        
        var persona = $("#persona").val();
        var txtNombres = $("#txtNombres").val();
        var txtPaterno = $("#txtPaterno").val();
        var txtMaterno = $("#txtMaterno").val();

        var username = $("#txtUsuario").val();
        // Expresion, solo debe aceptar letras numeros y caracteres . - _ entre 3 y 15 caracteres de longitud

        if (persona == ""){
            alert("Debe seleccionar al empleado.");
            $("#persona").focus();
            return null;
        }

        if (txtNombres == ""){
            alert("El nombre del empleado no puede estar en blanco.");
            $("#txtNombres").focus();
            return null;
        }

        if (txtPaterno == ""){
            alert("El apellido paterno del empleado no puede estar en blanco.");
            $("#txtPaterno").focus();
            return null;
        }

        if (txtMaterno == ""){
            alert("El apellido materno del empleado no puede estar en blanco.");
            $("#txtMaterno").focus();
            return null;
        }

        if ( username == "" ){
            alert("Debe ingresar un nombre de usuario.");
            $("#txtUsuario").focus();
            return null;
        }

        if ( $("#txtClave").val() == "" || $("#txtClave").val().length < 5 ){
            alert("Debe ingresar una clave valida.");
            $("#txtClave").focus();
            return null;
        }

        if ( $("#txtClave").val() != $("#txtClave2").val() ){
            alert("Las contraseñas ingresadas no coinciden.");
            return null;
        }

        if ( $(".verify-default").length == 0 || $("#default").val() == "" ){
            alert("Debe seleccionar una sede por default.");
            return null;
        }

        expr = /[a-zA-Z0-9._\-]{3,15}$/
        if ( expr.test(username) == true ){
            url = base_url+"index.php/seguridad/usuario/buscar_nombre_usuario";
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                data: { username: username },
                beforeSend: function(data) {

                },
                success: function(data){
                    if ( data.match == true && idPersona == "" ){
                        alert("El nombre de usuario " + username + " no esta disponible.");
                        $("#txtUsuario").focus();
                    }
                    else
                        $("#frmUsuario").submit();
                }
            });
        }
        else
            alert("El nombre de usuario " + username + ". no esta permitido.");
    });
        
    $("#limpiarUsuario").click(function(){
        url = base_url+"index.php/seguridad/usuario/usuarios";
        $("#txtNombres").val('');
        $("#txtUsuario").val('');
        $("#txtRol").val('');
        location.href=url;
    });

    $("#cancelarUsuario").click(function(){
        url = base_url+"index.php/seguridad/usuario/usuarios";
        location.href = url;
    });

    $("#buscarUsuario").click(function(){
        $("#form_busquedaUsuario").submit();
    });

    $("#grabarCuenta").click(function(){
        $("#frmCuenta").submit();   
    });

    $("#verificarUsuario").click(function(){
        
             var comprobante = $("#comprobante").val();
             var RolUsuario = $("#rolinicio").val();
             var tipo_oper = $("#txtoper").val();
             var tipo_docu = $("#txtdocu").val();

             var txtClave = $("#txtClave").val();
             var txtUsuario = $("#txtUsuario").val();
             var motivoAnulacion = $("#motivoAnulacion").val();

             if(txtUsuario==''){
                alert('Ingrese el usuario');
                return false;
            }
            else{
                if(txtClave==''){
                    alert('Ingrese la clave');
                    return false;
                }
                else{
                    
                    url = base_url + "index.php/seguridad/usuario/confirmacion_usuario_anulafb/"+tipo_docu+"/"+comprobante;

                    $.ajax({
                        type: "POST",
                        async: false,
                        url: url,
                        data: {comprobante:comprobante,txtUsuario:txtUsuario,txtClave:txtClave,txtRol:RolUsuario,motivo:motivoAnulacion},
                        beforeSend: function (data) {
                        },
                        error: function (data) {
                            alert('No se puedo completar la operación - Revise los campos ingresados.')
                        },
                        success: function (data) {
                            $("#frmBusqueda").html(data);
                            if ( $("#refresh").length > 0 ){
                                Swal.fire({
                                    icon: "success",
                                    title: "Anulacion completada",
                                    html: "<b class='color-red'></b>",
                                    showConfirmButton: true,
                                    timer: 1500
                                });
                                parent.location.reload();
                            }
                        }
                    });
                }
            }
    });
        
    $("#verificarTransUsuario").click(function(){
        $("#verificarTransUsuario").hide();
        $("#form_busqueda").submit();           
    }); 
    //---------
    $("#limpiarCuenta").click(function(){
        $("#frmCuenta").each(function(){
            this.reset();
        });
    });
    $("#cancelarCuenta").click(function(){
        url = base_url+"index.php/seguridad/usuario";
        location.href = url;        
    });
    $('#cerrarUsuario').click(function(){
        parent.$.fancybox.close(); 
    }); 
    
    if ( $("#frmCuenta").length > 0 ){
        $("#frmCuenta").validate({
            event    : "blur",
            rules    : {
                'txtNombres' : "required"
            },
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
                    url = base_url+"index.php/seguridad/usuario/modificar_cuenta";
                    $.post(url,dataString,function(data){   
                        location.href = base_url+"index.php/seguridad/usuario";
                    });             
                }
            }
        });
    }
    
    $('#nuevoRegistro').click(function(){
        n = document.getElementById('tblEstablec').rows.length;
        attr_class="";
        if(n%2!=0){
            attr_class="itemParTabla";
        }else{
            attr_class="itemImparTabla";
        }
        fila='<tr class="'+attr_class+' estabcAccess'+n+'">';
        fila+='<td><div align="left"><select name="cboEstablecimiento['+n+']" id="cboEstablecimiento['+n+']" class="comboMedio"><option disabled>::Seleccione::</option></select></div></td>';
        fila+='<td><div align="left"><select name="cboRol['+n+']" id="cboRol['+n+']" class="comboMedio"><option disabled>::Seleccione::</option></select></div></td>';
        fila+='<td><div align="center"><input type="radio" name="default" id="default" class="verify-default" value="'+n+'" /></div></td>'
        fila+='<td align="center"><div align="left"><a href="#" onclick="eliminar_establecimientos('+n+');"><img src="'+base_url+'images/delete.gif" border="0"></a></div>';
            fila+= '<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
            fila+='<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
        fila+='</td>';
        fila+='</tr>';
        $("#tblEstablec").append(fila);
        listar_establecimiento(n);
    });
       
});


function redireccionar(){
    top.location.href = base_url+"index.php/almacen/guiatrans/listar";
}

function redireccionar2(){

    top.location.href = base_url+"index.php/index/inicio";
}

function confirmar_usuario(cod){
    parent.confirmar_usuario(cod);
    parent.$.fancybox.close(); 
}

function listar_establecimiento(n){
    var base_url = $("#base_url").val();
    a      = "cboEstablecimiento["+n+"]";
    url    = base_url+"index.php/seguridad/usuario/JSON_listar_establecimiento/";
    select = document.getElementById(a);
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo      = item.COMPP_Codigo;
            descripcion = item.EESTABC_Descripcion;
            opt         = document.createElement('option');
            texto       = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;
            select.appendChild(opt);
        });
        listar_rol(n);
    });
}

function eliminar_establecimientos(n){
    $(".estabcAccess"+n).remove();
}

function listar_rol(n){
    var base_url = $("#base_url").val();
    a      = "cboRol["+n+"]";
    url    = base_url+"index.php/seguridad/rol/JSON_listar_rol/";
    select = document.getElementById(a);
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo      = item.ROL_Codigo;
            descripcion = item.ROL_Descripcion;
            opt         = document.createElement('option');
            texto       = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;  
            select.appendChild(opt);
        });
    });
}

function eliminar_establecimiento(usuario_compania,usuario){
    location.href = base_url + "index.php/seguridad/usuario/eliminar_establecimiento/"+usuario_compania+"/"+usuario;
}

function eliminar_usuario(usuario){
    if(confirm('¿Está seguro que desea eliminar este usuario?')){
        dataString        = "usuario="+usuario;
        $.post("eliminar_usuario",dataString,function(data){
            location.href = base_url+"index.php/seguridad/usuario/usuarios";        
        });         
    }
}

function atras_usuario(){
    location.href = base_url+"index.php/seguridad/usuario/usuarios";
}

function editar_cuenta(usuario){
    location.href = base_url+"index.php/seguridad/editar_cuenta/"+usuario;
}