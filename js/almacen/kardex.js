var base_url;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    $("#nuevoAlmacen").click(function(){
        url = base_url+"index.php/almacen/almacen/nuevo";
        location.href = url;
    });
    $("#grabarAlmacen").click(function(){
        $("#frmAlmacen").submit();
    });
    $("#limpiarAlmacen").click(function(){
        url = base_url+"index.php/almacen/almacen/listar";
        $("#txtAlmacen").val('');
        location.href=url;
    });
    $("#cancelarAlmacen").click(function(){
        url = base_url+"index.php/almacen/almacen/listar";
        location.href = url;
    });


  $("#limpiarkardex").click(function(){
        url = base_url+"index.php/almacen/kardex/listar";
        location.href=url;
    });

    $("#buscarKardex").click(function(){
        activarBusqueda();
    });
	
});


function activarBusqueda(){
    tipo_valorizacion = $("#tipo_valorizacion:checked").val();

    if(tipo_valorizacion=="0"){
        url = base_url+"index.php/almacen/kardex/listarFIFO";
    }
    else if(tipo_valorizacion=="1"){
        url = base_url+"index.php/almacen/kardex/listarLIFO";
    }
    else{
        url = base_url+"index.php/almacen/kardex/activarBusqueda";
    }

    // Busqueda recargando pagina
    //$("#frmkardex").attr("action",url);
    //$("#frmkardex").submit();

    datos = $('#frmkardex').serialize();

    $.ajax({
        url: url,
        type: "POST",
        data : datos,
        beforeSend: function(data){
            $('#cargando_datos').show();
        },
        success: function(data){
            $('#cargando_datos').hide();
            $('#activarBusqueda').html(data);
        },
        error: function(HXR, error){
            $('#cargando_datos').hide();
            console.log('error');
        }
    });


}

function editar_almacen(almacen){
	location.href = base_url+"index.php/almacen/almacen/editar/"+almacen;
}
function eliminar_almacen(almacen){
    if(confirm('Esta seguro desea eliminar este almacen?')){
        dataString        = "almacen="+almacen;
        url = base_url+"index.php/almacen/almacen/eliminar";
        $.post(url,dataString,function(data){
                location.href = base_url+"index.php/almacen/almacen/listar";
        });
    }
}
function ver_kardex(almacen,producto){
    location.href = base_url+"index.php/almacen/kardex/listar/"+producto;
}
function atras_almacen(){
    location.href = base_url+"index.php/almacen/almacen/listar";
}

function obtener_producto(){
    var codproducto   = $("#codproducto").val();
    $("#producto, #nombre_producto").val('');
    if(codproducto=='')
        return false;
    
    var url = base_url+"index.php/almacen/producto/obtener_nombre_producto/"+codproducto;
     $.getJSON(url,function(data){
         $.each(data,function(i,item){
             if(item.PROD_Nombre!=''){
                 $("#producto").val(item.PROD_Codigo);
                 $("#nombre_producto").val(item.PROD_Nombre);
             }else{
                 $('#nombre_producto').val('No se encontr� ning�n registro');
                 $('#linkVerProdcuto').focus();
             }
                 
         });
     });
     return true;
}
function comprobante_ver_pdf_conmenbrete(itemcodigo){

	if(itemcodigo.split("/").length-1 > 1)
	pdfurl= base_url+'index.php/ventas/comprobante/comprobante_ver_pdf_conmenbrete1/'+itemcodigo;
	else
	pdfurl= base_url+'index.php/almacen/guiarem/guiarem_ver_pdf_conmenbrete/'+itemcodigo;
	
    window.open(pdfurl,'',"width=800,height=600,menubars=no,resizable=no;");
}

/**gcbq debe mostrar listado se series realizadas por cada comprobante**/
function mostrarSeriesProducto(detallesMostrarSerie){

	valores=detallesMostrarSerie.split("/");
	codigoProducto=valores[0];
	codigoTipoDocumento=valores[1];
	codigoDocumentoReferencia=valores[2];
	tipoOperacion=valores[3];
	/**verificamos si esta inicializado para destroy los campos**/
	if($('.ui-table').length > 0){
		$('#detallesSeries').columns('destroy');
	}
		/**OBTENER DATOS JSON DE SERIES***/
		 url = base_url + "index.php/almacen/producto/series_ingresadas_json/" +codigoProducto + "/"+codigoTipoDocumento+ "/"+codigoDocumentoReferencia+ "/"+tipoOperacion,
         $.getJSON(url, function (data) {
        	 if(data!=null && data!=''){
        	 example1 = $('#detallesSeries').columns({
                 data:data,
                 sortableFields: ['numero'],
                 schema: [
                     {"header":"Nro.", "key":"i"},
                     {"header":"Numero Serie", "key":"numero"},
                     {"header":"Fecha de Registro", "key":"fecha"}
                 ],
                 evenRowClass: 'even-rows'
             }); 
             $("#dialogSeries" ).dialog( "open" );
        	 }else{
        		 alert("no contiene series ingresadas");
        		 
        	 }
             
             
         });		 
}

function ValidaKardex(codKardex,indice){
    if(confirm('¿Esta seguro de confirmar este movimiento?')){
        var url = base_url+"index.php/almacen/kardex/verificarMovimiento/"+codKardex;
        $.ajax({
            url: url,
            type: "POST",
            data : {kardex:codKardex},
            beforeSend: function(data){
                $('#cargando_datos').show();
            },
            success: function(data){
                $('#cargando_datos').hide();
                if(data != 'error'){
                    alert("Verificacion actualizada");
                    document.getElementById('checkValida['+indice+']').setAttribute("disabled","disabled");
                    document.getElementById('usuario['+indice+']').innerHTML = data;
                }
            },
            error: function(HXR, error){
                document.getElementById('checkValida['+indice+']').checked = false;
            }
        });
    }else{
        document.getElementById('checkValida['+indice+']').checked = false;
    } 
}



