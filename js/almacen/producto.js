var base_url;
jQuery(document).ready(function(){
    base_url  = $('#base_url').val();
    flagBS  = $('#flagBS').val();
    
    $("#nuevoProducto").click(function(){
        url = base_url+"index.php/almacen/producto/nuevo_producto/"+flagBS;
        location.href = url;
    });
    
    $("#buscarProducto").click(function(){
    });

    $("#limpiarProducto").click(function(){
        url = base_url+"index.php/almacen/producto/productos/"+flagBS;
        location.href=url;
    });
	
    $("#imprimirProducto").click(function(){
        var flagbs = "B";
        var codigo = $("#txtCodigo").val();
        var nombre = $("#txtNombre").val();
        var familia = $("#txtFamilia").val();
        var marca = $("#txtMarca").val();

        var nombre= sintilde(nombre);
        var familia = sintilde(familia);
        var marca= sintilde(marca);

        if(codigo==""){codigo="--";}
        if(nombre==""){nombre="--";}
        if(familia==""){familia="--";}
        if(marca==""){marca="--";}

        url = base_url+"index.php/almacen/producto/registro_productos_pdf/"+flagbs+"/"+codigo+"/"+nombre+"/"+familia+"/"+marca+"/";
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
    });

    $("#imprimirServicio").click(function(){
        var flagbs = "S";
        var codigo = $("#txtCodigo").val();
        var nombre = $("#txtNombre").val();
        var familia = $("#txtFamilia").val();
        var marca = $("#txtMarca").val();

        var nombre= sintilde(nombre);
        var familia = sintilde(familia);
        var marca= sintilde(marca);

        if(codigo==""){codigo="--";}
        if(nombre==""){nombre="--";}
        if(familia==""){familia="--";}
        if(marca==""){marca="--";}

        url = base_url+"index.php/almacen/producto/registro_productos_pdf/"+flagbs+"/"+codigo+"/"+nombre+"/"+familia+"/"+marca+"/";
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
    });


	///
	
    $("#cancelarCodigoBarra").click(function(){
        window.close();
    });
    /*$("#imgGuardarProducto").click(function(){
        
        producto        = $("#codigo").val();
        modelo_producto = $("#modelo").val();        
       
        url = base_url+"index.php/almacen/producto/obtener_producto_x_modelo/"+modelo_producto+"/"+producto;
        if(modelo_producto!=""){
            $.post(url,'',function(data){
                if(data>0){
                    $("#modelo").val("");
                    alert('Este Modelo ya se encuentra registrado.');
                    $("#modelo").select();
                }
                else{
                    $("#frmProducto").submit();
                }                
            });
        }else{
            $("#frmProducto").submit();
        }
    //$("#frmProducto").submit();
    });*/

    $("#imgGuardarProducto").click(function(){
        $("#frmProducto").submit();
    });
    
    $("#imgLimpiarProducto").click(function(){
        $("#frmProducto").each(function(){
            this.reset();
        });
    });
    $("#imgCancelarProducto").click(function(){
        url = base_url+"index.php/almacen/producto/productos/"+flagBS;
        location.href = url;
    });
    
    $("#buscarProducto2").click(function(){
        var base_url  = $('#base_url').val();
        var pag       = $('#hpagina').val();
        var flagBS    = $('#flagBS').val();
        top.location=base_url +"index.php/almacen/producto/productos/"+flagBS
    });	
    
    $("#GuardarCarga").click(function(){
        $("#frmdocumento").submit();
    });

    $('#imgCancelarcarga').click(function(){ 
        parent.$.fancybox.close(); 
    });

    $("#nuevaReceta").click(function(){
        location.href = base_url+"index.php/almacen/produccion/receta_nueva";
    });

    $("#nuevaOProduccion").click(function(){
        location.href = base_url+"index.php/almacen/produccion/produccion_nueva";
    });

    $("#generarOC").click(function(){
        var url = base_url + "index.php/almacen/produccion/generarOrdenCompra";

        $.ajax({
            type: "POST",
            url: url,
            data: { oc: '' },
            dataType: 'json',
            beforeSend: function (data) {
                $("#cargando_datos").show();
            },
            error: function (data) {
                $("#cargando_datos").hide();
            },
            success: function (data) {
                switch (data.result){
                    case 'success':
                        alert(data.msg);
                        break;
                    case 'warning':
                        alert(data.msg);
                        break;
                    case 'error':
                        alert(data.msg);
                        break;
                }
                $("#cargando_datos").hide();
            }
        });
    });

    $("#nuevaODespacho").click(function(){
        location.href = base_url+"index.php/almacen/produccion/despacho_nueva";
    });

    $("#imgGuardarReceta").click(function(){
        $("#salir").val(1);
        $("#frmReceta").submit();
    });
    
    $("#limpiarReceta").click(function(){
        $("#salir").val(1);
        $("#frmReceta").each(function(){
            this.reset();
        });
    });
    $("#cancelarReceta").click(function(){
        $("#salir").val(1);
        url = base_url+"index.php/almacen/produccion/receta_index/";
        location.href = url;
    });
    
    $("#limpiarLote").click(function(){
        $("#salir").val(1);
        $("#frmLote").each(function(){
            this.reset();
        });
    });

    $("#cancelarLote").click(function(){
        $("#salir").val(1);
        url = base_url+"index.php/almacen/lote/lote_index/";
        location.href = url;
    });

    /*$("#imgGuardarProduccion").click(function(){
        $("#frmProduccion").submit();
    });*/

    $("#imgGuardarProduccion").click(function () {
        $("#salir").val(1);
        codigo = $("#codigo_guiatrans").val();
       
        $('img#loading').css('visibility', 'visible');
        // Sirve para editar y insertar

        var url = $("#url").val();
        //url = base_url + "index.php/almacen/guiatrans/grabar";

        dataString = $('#frmProduccion').serialize();
        $.post(url, dataString, function (data) {
            $('img#loading').css('visibility', 'hidden');
            switch (data.result) {
                case 'success':
                    location.href = data.redirect;
                    break;
                case 'warning':
                    alert("¡Debe generar una orden de compra con los insumos requeridos!");
                    break;
                case 'error':
                    alert(data.msg);
                    break;
            }
        }, 'json');
    });

    $("#buscarProductoLote").click(function(){
        $("#form_busqueda2").submit();
    });
    
    $("#limpiarProduccion").click(function(){
        $("#salir").val(1);
        $("#frmReceta").each(function(){
            this.reset();
        });
    });

    $("#cancelarProduccion").click(function(){
        $("#salir").val(1);
        url = base_url+"index.php/almacen/produccion/produccion_index/";
        location.href = url;
    });

    // DESPACHO
    $("#imgGuardarDespacho").click(function () {
        $("#salir").val(1);
        
        $('img#loading').css('visibility', 'visible');
        // Sirve para editar y insertar

        var url = $("#url").val();
        //url = base_url + "index.php/almacen/guiatrans/grabar";

        dataString = $('#frmDespacho').serialize();
        $.post(url, dataString, function (data) {
            $('img#loading').css('visibility', 'hidden');
            switch (data.result) {
                case 'success':
                    location.href = data.redirect;
                    break;
                case 'error':
                    alert(data.msg)
                    break;
            }
        }, 'json');
    });
    
    $("#limpiarDespacho").click(function(){
        $("#salir").val(1);
        $("#frmReceta").each(function(){
            this.reset();
        });
    });

    $("#cancelarDespacho").click(function(){
        $("#salir").val(1);
        url = base_url+"index.php/almacen/produccion/despacho_index";
        location.href = url;
    });

    $("#buscarProductoReceta").click(function(){
        $("#form_busqueda2").submit();
    });

    //Publicacion Web
    
    $("#grabarPublicacionWebNueva").click(function(){
        $("#frmPublicacionWeb").submit();
    });
    $("#grabarPublicacionWeb").click(function(){
        $("#frmPublicacionWeb").submit();
    });
    $("#limpiarPublicacionWeb").click(function(){
        $("#frmPublicacionWeb").each(function(){
            this.reset();
        });
    });
    $("#cancelarPublicacionWeb").click(function(){
        url = base_url+"index.php/almacen/producto/productos";
        location.href = url;
    });
    
    
    //Fin de la Publicacion
    
    $("#ate").click(function(){
       
        var checkboxes = frmpublicar.checkalmacen; //Array que contiene los checkbox 
        var cont = 0; //Variable que lleva la cuenta de los checkbox pulsados 

        for (var x=0; x < checkboxes.length; x++) { 
            if (checkboxes[x].checked) 
            { 
                cont = cont + 1; 

            //alert ("El valor del checkbox pulsados es " + checkboxes[x].value); 
            } 
        } 

        if(cont==0){
            alert ("Debe seleccionar un producto"); 
        }

        else {
    
            valida2(); 
    
    
        }
    });
     $("#molina").click(function(){
       
        var checkboxes = frmpublicar.checkalmacen; //Array que contiene los checkbox 
        var cont = 0; //Variable que lleva la cuenta de los checkbox pulsados 

        for (var x=0; x < checkboxes.length; x++) { 
            if (checkboxes[x].checked) 
            { 
                cont = cont + 1; 

            //alert ("El valor del checkbox pulsados es " + checkboxes[x].value); 
            } 
        } 

        if(cont==0){
            alert ("Debe seleccionar un producto"); 
        }

        else {
    
            valida3(); 
    
    
        }
    });
    /*$("#general").click(function(){
        if (frmpublicar.checkalmacen !== undefined){
            var checkboxes = frmpublicar.checkalmacen; //Array que contiene los checkbox 
            var cont = 0; //Variable que lleva la cuenta de los checkbox pulsados 

            for (var x=0; x < checkboxes.length; x++) { 
                if (checkboxes[x].checked) 
                { 
                    cont = cont + 1; 

                //alert ("El valor del checkbox pulsados es " + checkboxes[x].value); 
                } 
            } 

            if(cont==0){
                alert ("Debe seleccionar un producto"); 
            }

            else {
        
                valida4(); 
        
        
            }
        }
    });*/
    $('#prodGeneral').click(function(){        
        $('#general').show();
        $('#datosPrecios').hide();
        $('#datosProveedores').hide();
        $("#nuevoRegistroProv").hide();
        $('#datosOcompras').hide();
        $('#divBotones').show();
    });
    $('#prodPrecios').click(function(){
        $('#general').hide();
        $('#datosPrecios').show();
        $('#datosProveedores').hide();
        $("#nuevoRegistroProv").hide();
        $('#datosOcompras').hide();
        $('#divBotones').show();
    });
    $('#prodProveedores').click(function(){
        $('#general').hide();
        $('#datosPrecios').hide();
        $('#datosProveedores').show();
        $("#nuevoRegistroProv").show();
        $('#datosOcompras').hide();
        $('#divBotones').show();
    });
    $('#prodCompras').click(function(){
        producto = $("#producto").val();
        //alert('Corregir cuando sale esto');
        if(producto!=''){
            $('#general').hide();
            $('#datosPrecios').hide();
            $('#datosProveedores').hide();
            $("#nuevoRegistroProv").hide();
            $('#datosOcompras').show();
            $('#divBotones').hide();
            url = base_url+"index.php/almacen/producto/listar_lotes_producto/"+producto;
            $.post(url,'',function(data){
                $('#datosOcompras').html(data);
            });
        }
    });
    $("#nuevoRegistroProv").click(function(){
        $("#msgRegistros").hide();
        n = document.getElementById('tblProveedor').rows.length;
        fila  = "<tr>";
        fila += "<td align='center'>"+n+"</td>";
        fila += "<td align='left'><input type='text' name='ruc["+n+"]' id='ruc["+n+"]' class='cajaPequena cajaSoloLectura' readonly='readonly'></td>";
        fila += "<td align='left'>";
        fila += "<input type='hidden' name='proveedor["+n+"]' id='proveedor["+n+"]'>";        
        fila += "<input type='text' name='nombre_proveedor["+n+"]' id='nombre_proveedor["+n+"]' class='cajaGrande cajaSoloLectura'>";
        fila += "<a href='javascript:;' onclick='buscar_proveedor("+n+");'>&nbsp;<img height='16' width='16' border='0' title='Agregar Proveedor' src='"+base_url+"images/ver.png'></a>";
        fila += "</td>";
        fila += "<td align='left'><input type='text' name='direccion["+n+"]' id='direccion["+n+"]' class='cajaGrande cajaSoloLectura' readonly='readonly'></td>";
        fila += "<td align='left'><input type='text' name='distrito["+n+"]' id='distrito["+n+"]' class='cajaMedia cajaSoloLectura' readonly='readonly'></td>";        
        fila += "<td align='center'><a href='#' onclick='eliminar_productoproveedor("+n+");'><img src='"+base_url+"images/delete.gif' border='0'></a></td>";
        $("#tblProveedor").append(fila);
    });
    $("a.limpiarPrecios").click(function(){
        $(this).parents("tr").find("input").val('');

    });
    $('#tiene_padre').click(function(){
        if(this.checked==true)
            $('#lblTienePadre').fadeIn('slow');
        else
            $('#lblTienePadre').fadeOut('slow', function(){
                $('#padre, #codpadre, #nompadre').val('');
            });           
    });
    
       
    $("#publicarProductos").click(function(){
        var checkboxes = frmpublicar.producto; //Array que contiene los checkbox 
        var cont = 0; //Variable que lleva la cuenta de los checkbox pulsados 
        //En caso de haber un solo Chekbox
        if(checkboxes.length == undefined){
            if (document.getElementById('producto').checked){ 
                cont = cont + 1; 
            //alert ("El valor del checkbox pulsados es " + checkboxes[x].value); 
            }
        }
        //En caso de haber mas de un Chekbox
        for (var x=0; x < checkboxes.length; x++) { 
            if (checkboxes[x].checked){ 
                cont = cont + 1; 
            //alert ("El valor del checkbox pulsados es " + checkboxes[x].value); 
            } 
        } 
        
        if(cont==0){
            alert ("Debe seleccionar uno o mas productos"); 
        }
        else {
            //   $('#linkPublicar').attr('href',base_url+'index.php/almacen/producto/publicar_producto'+checkboxes).click();
            //    return true; 
            document.forms["frmpublicar"].action=base_url+"index.php/almacen/producto/publicar_producto";

            document.forms["frmpublicar"].submit();
        }
    });
     
    $("#imgGuardarPro").click(function(){

        $("#producto").submit();
    // parent.$.fancybox.close();
    });
     
    $('#publicarProducto').click(function(){
        var num=$('input[type="checkbox"][name^="producto"]:checked').length;
        if(num==0){
            alert('Debe seleccionar al menos un producto.');
            return false;
        }
        var productos='';
        $.each($('input[type="checkbox"][name^="producto"]:checked'), function(i,item){
            productos+=$(this).val()+'-';
        });
        $('a#linkPublicar').attr('href', base_url+'index.php/almacen/producto/publicar_producto/'+productos).click();
        return true;
    });
    $('#txtCodigo, #txtNombre, #txtFamilia, #txtMarca').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==13){
            $("#buscarP").click();
        } 
    });
});
 function valida2(){

       document.forms["frmpublicar"].action=base_url+"index.php/almacen/producto/insertar_establecimiento";

       document.forms["frmpublicar"].submit();


 }
  function valida3(){
       document.forms["frmpublicar"].action=base_url+"index.php/almacen/producto/insertar_establecimiento2";

       document.forms["frmpublicar"].submit();


 }
  function valida4(){
       document.forms["frmpublicar"].action=base_url+"index.php/almacen/producto/insertar_establecimiento3";

       document.forms["frmpublicar"].submit();


 }
 function validaCaractaer(pEvent){

    if (pEvent.keyCode==241){ //esta es la letra ñ
        alert("Evite escribir el signo 'ñ'");
      pEvent.keyCode=0;//Cuando le haces esto le impides la escritura del caracter en la caja
    }
      if (pEvent.keyCode==47){ 
         alert("Evite escribir el signo '/'");
        pEvent.keyCode = 0; //Cuando le haces esto le impides la escritura del caracter en la caja
    }

}

function mostrar_atributos(){
    var base_url  = $('#base_url').val();
    tipo_producto = $("#tipo_producto").val();
    dataString    = "";
    url           = base_url+"index.php/almacen/producto/mostrar_atributos/"+tipo_producto;
    if(tipo_producto!=''){
        $.post(url,dataString,function(data){
            $("#divAtributos").html(data);
        });
    }
    else{
        $("#divAtributos").html("");
    }
}
function despublicar_producto(cod){
    if(confirm('Esta seguro desea despublicar este producto?')){
        dataString = "cod="+cod;
        url = base_url+"index.php/almacen/producto/despublicar_producto";
        $.post(url,dataString,function(data){
            url = base_url+"index.php/almacen/producto/productos";
            location.href = url;
        });
    }
}
 


function valida_atributo(n){
    a = "tipo_atributo["+n+"]";
    b = "nombre_atributo["+n+"]";
    tipo_atributo   = document.getElementById(a).value;
    nombre_atributo = document.getElementById(b).value;
    if(nombre_atributo!=''){
        if(("0123456789.").indexOf(nombre_atributo) > -1){
            tipo = 1;//Numerico
            nombre_tipo = "Numerico";
        }
        else if(("ABCDEFGHIJKLMN?OPQRSTUVWXYZabcdefghijklmn?opqrstuvwxyz ").indexOf(nombre_atributo) > -1){
            tipo = 3;//String
            nombre_tipo = "String";
        }
        else{//Date
            tipo = 2;//Fecha
            nombre_tipo = "Date";
        }
        if(tipo!=tipo_atributo){
            alert('Favor ingrese un tipo de dato '+nombre_tipo);
        }
    }
}
function valida_producto(){
    unidad           = "unidad_medida[0]";
    flagBS  = $('#flagBS').val();

    //validamos la familia
    if($.trim($("#nombre_familia").val()) == '') {
        alert("Debe seleccionar una familia");
        return false;
    } 
 
    if($("#tiene_padre").attr('checked')==true && $("#padre").val()==""){
        alert('Debe seleccionar un producto.');
        $("#linkVerProducto").focus();
        return false;
    }
    else if($("#nombre_producto").val()==""){
        $("#nombre_producto").select();
        alert('Debe ingresar un nombre de producto');
        $("#nombre_producto").focus();
        return false;
    }
    else if(document.getElementById(unidad)){
    	if(document.getElementById(unidad).value=="" && flagBS=='B'){
        	alert('Debe ingresar una unidad');
        	document.getElementById(unidad).focus();
        	return false;
    	}
        
    }

     //validamos la partida arancelaria
      /*  if(flagBS == 'B' && !/^[0-9]{4}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}$/g.test($("#partida-arancelaria").val())){
            $("#partida-arancelaria").focus();
            alert("La partida arancelaria no es correcta.");
            return false;
        }*/
       
    return true;
}

function valida_nombre_producto(){ //ya tambien por modelo
    nombre_producto = $("#nombre_producto").val();
    producto        = $("#codigo").val();
    nombre_producto = $("#nombre_producto").val();
    nombre_producto = $("#modelo").val();
    url = base_url+"index.php/almacen/producto/obtener_producto_x_nombre/"+nombre_producto;
    if(nombre_producto!=""){
        $.post(url,'',function(data){
            if(data>0 && producto==""){
                alert('Este producto ya se encuentra registrado.');
                $("#nombre_producto").select();
            }
        });
    }
}


function valida_codigo(){ //ya tambien por modelo
    codigo_usuario = $("#codigo_usuario").val();
    producto        = $("#codigo").val();
    url = base_url+"index.php/almacen/producto/obtener_producto_x_codigo_usuario/"+codigo_usuario;
    if(codigo_usuario!=""){
        $.post(url,'',function(data){
            if(data>0 && producto==""){
                alert('Este codigo ya se encuentra registrado.');
                $("#codigo_usuario").select();
            }
        });
    }
}

///stv
function valida_codigo_original(){ //ya tambien por modelo
    codigo_original = $("#codigo_original").val();
    producto        = $("#codigo").val();


    url = base_url+"index.php/almacen/producto/obtener_producto_x_codigo_original/"+codigo_original;
    if(codigo_original!=""){
        $.post(url,'',function(data){
            if(data>0 && producto==""){
                alert('Este codigo original ya se encuentra registrado.');
                $("#codigo_original").select();
            }
        });
    }
}
///

//function valida_modelo_producto(){
//    producto        = $("#codigo").val();
//    modelo_producto = $("#modelo").val();
//    url = base_url+"index.php/almacen/producto/obtener_producto_x_modelo/"+modelo_producto+"/"+producto;
//    if(modelo_producto!=""){
//        $.post(url,'',function(data){
//            if(data>0){
//                $("#modelo").val("");
//                alert('Este Modelo ya se encuentra registrado.');                
//                $("#modelo").select();
//            }
//        });
//    }
//}
function editar_producto(producto){
    var base_url = $("#base_url").val();
    url           = base_url+"index.php/almacen/producto/editar_producto/"+producto;
    location.href = url;
}

function editar_producto2(n){
    var base_url  = $('#base_url').val();
    var pag       = $('#hpagina').val();
    var flagBS    = $('#flagBS').val();
    /*
    var cod = $('#txtCodigo').val();
    var nom = $('#txtNombre').val();
    var fam = $('#txtFamilia').val();
    var mar = $('#txtMarca').val();
    var tp  = $('#cboTipoProducto option:selected').val();
    var ep  = $('#cboEstadoProducto option:selected').val();
     */
    var a           = "producto["+n+"]";
    var producto     = document.getElementById(a).value;
    var dataString = "producto="+producto+"&pag="+pag+"&falgBS="+flagBS; //+"&cod="+cod+"&nom="+nom+"&fam="+fam+"&mar="+mar+"&cboTipoProducto="+tp+"&ep="+ep;
    url         = base_url+"index.php/almacen/producto/editar_producto2";
    $.post(url,dataString,function(data){
        $("#frmResultado").html(data);
        $("#frmResultado input[name^='descripcion["+n+"]']").focus();        
    });	
}

function modificar_producto2(n){
    
    var base_url  = $('#base_url').val();
    var flagBS    = $('#flagBS').val();
    var a = "producto["+n+"]";
    var b = "descripcion["+n+"]";
   
    var d = "codigointerno["+n+"]";
    var e = "productostock["+n+"]";
    var p = "productoprecio["+n+"]";    
    var g = "productopresentacion["+n+"]";
    var h = "productomarca["+n+"]";
    var s = "seriesproducto["+n+"]";
    var producto       = document.getElementById(a).value;
    var descripcion    = document.getElementById(b).value;   
    var tipoproducto;
        

    var codigointerno  = document.getElementById(d).value;
    var productostock  = document.getElementById(e).value;
    var productoprecio  = document.getElementById(p).value;
    var productopresentacion  = document.getElementById(g).value;
    var productomarca  = document.getElementById(h).value;
    //var codanterior2  = $('#codanterior2').val();
    var url        = base_url+"index.php/almacen/producto/modificar_producto2";
    //var dataString = "hpagina="+pag+"&flagBS="+flagBS+"&producto="+producto+"&descripcion="+descripcion+"&tipoproducto="+tipoproducto+"&nombregenerico="+nombregenerico+"&codigointerno="+codigointerno+"&productostock="+productostock;
    var dataString = "producto="+producto+"&descripcion="+descripcion+"&tipoproducto="+tipoproducto+"&codigointerno="+codigointerno+"&productostock="+productostock+"&productoprecio="+productoprecio+"&productopresentacion="+productopresentacion+"&productomarca="+productomarca;
    if(descripcion!=''){
        $.post(url,dataString,function(data){
            // $("#buscarProducto2").trigger('click');
            //$("#form_busqueda").submit();
            //$("#buscarProducto").click();
            //location.href = base_url+"index.php/almacen/familia/familias/"+flagBS+'/'+codanterior;
            location.href = base_url+"index.php/almacen/producto/productos/"+flagBS;
        });
    }
    else{
        alert('Debe ingresar un nombre para el producto');
    }
}



function publicar_producto(producto){
    var base_url = $("#base_url").val();
    url           = base_url+"index.php/almacen/producto/publicar_producto/"+producto;
    location.href = url;
}

// Publicaci���0�7�0�0n Web

function enviar(producto){
    var base_url = $("#base_url").val();
    url           = base_url+"index.php/almacen/producto/valida_publicacion_web/"+producto;
    location.href = url;
}

// Fin
function prorratear_producto(producto){
    var base_url = $("#base_url").val();
    url           = base_url+"index.php/almacen/producto/prorratear_producto/"+producto;
    location.href = url;
}
function ver_producto(producto){
    var base_url = $("#base_url").val();
    location.href = base_url+"index.php/almacen/producto/ver_producto/"+producto;
}
function atras_articulo(){
    url = base_url+"index.php/almacen/producto/productos";
    location.href = url;
}

function eliminar_productoproveedor(n){
    a = "nombre_proveedor["+n+"]"
    b = "proveedor["+n+"]";
    c = "productoproveedor["+n+"]";
    nombre_proveedor  = document.getElementById(a).value;
    proveedor         = document.getElementById(b).value;
    producto          = document.getElementById("producto").value;
    productoproveedor = document.getElementById(c).value;
    if(confirm('Esta seguro desea eliminar \n'+nombre_proveedor+'?')){
        dataString        = "productoproveedor="+productoproveedor;
        url = base_url+"index.php/almacen/producto/eliminar_productoproveedor";
        $.post(url,dataString,function(data){
            location.href = base_url+"index.php/almacen/producto/editar_producto/"+producto;
        });
    }
}
function agregar_unidad_producto(){
    n = (document.getElementById('tblUnidadMedida').rows.length);	
    a = "factor["+n+"]";
    fila  = '<tr>';	
    fila += '<td width="16%">Unidad medida Aux. '+n+'</td>';
    fila += '<td width="19%">';
    fila += '<input type="hidden" class="cajaMinima" name="produnidad['+n+']" id="produnidad['+n+']" value="">';	
    fila += '<select name="unidad_medida['+n+']" id="unidad_medida['+n+']" class="comboMedio"><option value="" selected="selected">::Seleccione::</option></select>&nbsp;</td>';
    fila += '<td width="10%">F.C.<input type="text" class="cajaPequena2" onkeypress="return numbersonly(this,event,\'.\');" maxlength="5" name="factor['+n+']" id="factor['+n+']"></td>';
    fila += '<td width="54%"><input type="hidden" class="cajaPequena2" name="flagPrincipal['+n+']" id="flagPrincipal['+n+']" value="0"></td>';
    fila += '</tr>';
    $("#tblUnidadMedida").append(fila);
    $('#spanPrecio').html(' <span title="Guarde los cambios primero para ingresar los precios">&nbsp;Precios</span>');
    listar_unidad_medida(n);
}
function listar_unidad_medida(n){
    var base_url = $("#base_url").val();
    a      = "unidad_medida["+n+"]";
    url    = base_url+"index.php/almacen/producto/listar_unidad_medida/";
    select = document.getElementById(a);
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo      = item.UNDMED_Codigo;
            descripcion = item.UNDMED_Descripcion;
            simbolo     = item.UNDMED_Simbolo;
            opt         = document.createElement('option');
            texto       = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;
            select.appendChild(opt);
        });
    });
}
function listar_unidad_medida_producto1(producto){
    base_url   = $("#base_url").val();
    url          = base_url+"index.php/almacen/producto/listar_unidad_medida_producto/"+producto;
    select   = document.getElementById('unidad_medida');
    //option  = document.getElementById('option');
    //padre = option[0].parentNode;
    //padre.removeChild(option[0]);
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo            = item.UNDMED_Codigo;
            alert(codigo);
            descripcion  = item.UNDMED_Descripcion;
            simbolo         = item.UNDMED_Simbolo;
            opt         = document.createElement('option');
            texto       = document.createTextNode(simbolo);
            opt.appendChild(texto);
            opt.value = codigo;
            select.appendChild(opt);
        });
    });
}
function listar_unidad_medida_producto(producto){
    base_url   = $("#base_url").val();
    url          = base_url+"index.php/almacen/producto/listar_unidad_medida_producto/"+producto;
    select   = document.getElementById('unidad_medida');
    //option  = document.getElementById('option');
    //padre = option[0].parentNode;
    //padre.removeChild(option[0]);
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo            = item.UNDMED_Codigo;
            descripcion  = item.UNDMED_Descripcion;
            simbolo         = item.UNDMED_Simbolo;
            nombre_producto = item.PROD_Nombre;
            opt         = document.createElement('option');
            texto       = document.createTextNode(simbolo);
            opt.appendChild(texto);
            opt.value = codigo;
            if(i==0)
                opt.selected=true;
            select.appendChild(opt);
        });
        $("#nombre_producto").val(nombre_producto);
    });
}
function obtener_producto_unidad(producto){
    url          = base_url+"index.php/almacen/producto/obtener_producto_unidad/"+producto;
    $.getJSON(url,function(data){
        alert(data);
    });
}

function IngresarSerieProducto(n){
    var base_url  = $('#base_url').val();
    a = "producto["+n+"]"
    b = "productostock["+n+"]";
    
    producto  = document.getElementById(a).value;
    productostock         = document.getElementById(b).value;    
    
    if(productostock!=''){
        
        $('.fancybox').attr('href', base_url+'index.php/almacen/producto/ventana_nueva_serie/'+producto+'/'+productostock+"/"+n)
        $('.fancybox').trigger('click');
    //alert(base_url+'index.php/almacen/producto/ventana_nueva_serie/'+producto+'/'+productostock)
    }
}
    
function buscar_productoint(){
    
    var producto = $("#nombre_producto").val();
    
    var url = base_url+"index.php/almacen/producto/JSON_busca_producto_xdoc/"+producto+'/'+flagBS;
    
        $.getJSON(url,function(data){
                
                $("#persona_msg").html(''); 
                $("#nombre_producto").val(producto);
                $.each(data,function(i,item){
                    
                        $("#nombre_producto").val(item.nombre_producto);
                        $("#persona_msg").html('<b>Existe un producto con el mismo nombre.</b>');
                });
        });
        
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

//*************************************
//******** RECETA
//*************************************

function editar_receta(receta){
    var base_url = $("#base_url").val();
    url           = base_url+"index.php/almacen/produccion/editar_receta/"+receta;
    location.href = url;
}

function eliminar_receta(receta){
    var success = confirm('¿Desea eliminar esta receta?');
    if (success == true){
        var base_url = $("#base_url").val();
        url           = base_url+"index.php/almacen/produccion/eliminar_receta/"+receta;
        location.href = url;
    }
    else
        return null;
}

function ver_receta(id, imagen = 0) {
    var url = base_url + "index.php/almacen/produccion/receta_pdf/" + id + "/" + imagen;
    window.open(url, '', "width=800,height=600,menubars=no,resizable=no;");
}

//*************************************
//******** PRODUCCION
//*************************************

function editar_produccion(id){
    var base_url = $("#base_url").val();
    url = base_url+"index.php/almacen/produccion/editar_produccion/" + id;
    location.href = url;
}

function ver_produccion(id, imagen = 0) {
    var url = base_url + "index.php/almacen/produccion/produccion_pdf/" + id + "/" + imagen;
    window.open(url, '', "width=800,height=600,menubars=no,resizable=no;");
}

//*************************************
//******** PRODUCCION
//*************************************

function editar_despacho(id){
    var base_url = $("#base_url").val();
    url = base_url+"index.php/almacen/produccion/despacho_editar/" + id;
    location.href = url;
}

function ver_despacho(id, imagen = 0) {
    var url = base_url + "index.php/almacen/produccion/despachoPdf/" + id + "/" + imagen;
    window.open(url, '', "width=800,height=600,menubars=no,resizable=no;");
}


//*************************************
//AUTOR: Luis Valdes 22/02/2021

//*************************************

// Inicio Luis Valdes
function barcode(codigo) {
    url = base_url+"index.php/almacen/producto/ver_productobarra/"+codigo;
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}

function eliminar_producto(producto){
    
    var url = base_url + "index.php/almacen/producto/eliminar_producto";

    $.ajax({
        type: "POST",
        url: url,
        data: { producto: producto },
        dataType: 'json',
        beforeSend: function (data) {
            
        },
        error: function (data) {
            
        },
        success: function (data) {
            $("#limpiar").click();
            Swal.fire({
                icon: "info",
                title: "Producto desactivado",
                html: "<b class='color-red'>Se ha desactivado el articulo</b>",
                showConfirmButton: true
            });
        }
    });
}

function habilitar_producto(producto){
    
    var url = base_url + "index.php/almacen/producto/habilitar_producto";

    $.ajax({
        type: "POST",
        url: url,
        data: { producto: producto },
        dataType: 'json',
        beforeSend: function (data) {
            
        },
        error: function (data) {
            alert("Ups! Algo extraño ha pasado, por favor comuniquese con soporte tecnico");
        },
        success: function (data) {
            $("#limpiar").click();
            Swal.fire({
                icon: "info",
                title: "Producto habilitado",
                html: "<b class='color-red'>Se ha habilitado el articulo para la compra/venta</b>",
                showConfirmButton: true
            });
        }
    });
}
//Fin Luis Valdes
