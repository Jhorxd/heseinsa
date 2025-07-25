/* *********************************************************************************
Autor: Unknow
Fecha: Unknow

Dev: Rawil Ceballo -> RC
Dev: Luis Valdes	 -> LV
/* ******************************************************************************** */

// Dev: RC -> Begin - var inicializada en el view del Layout, segun valor del controlador.
// var tipo_oper;
// Dev: RC -> End

var tipo_docu;
var contiene_igv;

jQuery(document).ready(function(){
  contiene_igv = $("#contiene_igv").val();

  // Dev: RC -> Begin - index
  	$('#table-ocompra').DataTable({
      filter: false,
      destroy: true,
      processing: true,
      serverSide: true,
      ajax:{
        url : base_url + "index.php/compras/ocompra/datatable_ocompra/" + tipo_oper,
        type: "POST",
        data: { dataString: "" },
        beforeSend: function(){
          $(".loading-table").show();
        },
        error: function(){
        },
        complete: function(){
          $(".loading-table").hide();
        }
      },
      language: spanish,
      order: [[ 0, "desc" ]]
    });

    $("#buscarO").click(function(){
      search(true);
    });

    $("#limpiarO").click(function(){
    	search(false);
    });

  	// Filtros de busqueda en el DT index
  	$("#nombre_producto").autocomplete({
      source: function (request, response) {
        $.ajax({
          url: base_url + "index.php/maestros/temporaldetalle/autocomplete_producto/B//",
          type: "POST",
          data: {
            term: $("#nombre_producto").val(),
            TipCli: "",
            marca: "",
            modelo: "" 
          },
          dataType: "json",
          success: function (data) {
            response(data);
          }
        });
      },
      select: function (event, ui) {
        $("#producto").val(ui.item.codigo);
        $("#nombre_producto").val(ui.item.descripcion);
      },
      minLength: 2
    });

    $("#nombre_producto").keyup(function(){
      var cadena = $("#nombre_producto").val();
      if ( cadena.length == 0 )
        $("#producto").val("");
    });

    $('#nombre_proveedor, #ruc_proveedor, #nombre_cliente, #ruc_cliente').keyup(function(e){
      var key = e.keyCode;
      if (key == 13)
        search(true);
    });

	  // envio de correo
    $(".btn-close-envmail").click(function(){
        $(".modal-envmail").modal("hide");
    });

    $(".btn-sendMail").click(function(){
        if (tipo_oper=="V") {
            documento = 18;
        }else{
            documento = 3;
        }
        
        codigo = $("#idDocMail").val();

        destinatario = $("#destinatario").val();
        asunto = $("#asunto").val();
        mensaje = $(".nicEdit-main").html();

        if ( codigo == ""){
            Swal.fire({
                    icon: "warning",
                    title: "Sin documento. Intentelo nuevamente.",
                    showConfirmButton: true,
                    timer: 2000
            });
            return null;
        }

        if ( destinatario == ""){
            Swal.fire({
                    icon: "warning",
                    title: "Debe ingresar un destinatario.",
                    showConfirmButton: true,
                    timer: 2000
            });
            $("#destinatario").focus();
            return null;
        }
        else{
            correosI = destinatario.split(",");
            /* DEVELOPING
            expr = /^[a-zA-Z0-9@_.\-]{1,3}$/
            
            for (var i = 0; i < correosI.length - 1; i++) {
                if ( expr.test(correosI[i]) == false ){
                    alert("Verifique que todos los correos indicados sean validos.");
                }
            }*/
        }

        if ( asunto == ""){
            Swal.fire({
                    icon: "warning",
                    title: "Indique el asunto del correo.",
                    showConfirmButton: true,
                    timer: 2000
            });
            $("#asunto").focus();
            return null;
        }

        var url = base_url + "index.php/compras/ocompra/sendDocMail";
        $.ajax({
            url:url,
            type:"POST",
            data:{ codigo: codigo, destinatario: destinatario, asunto: asunto, mensaje: mensaje, documento: documento },
            dataType:"json",
            error:function(data){
            },
            beforeSend: function(){
                $(".tempde_footer .icon-loading-md").show();
                $(".btn-sendMail").hide();
            },
            success:function(data){
                if (data.result == "success"){
                    Swal.fire({
                        icon: "success",
                        title: "Correo electronico enviado.",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $(".modal-envmail").modal("hide");
                }
                else{
                    Swal.fire({
                        icon: "error",
                        title: "Correo no enviado, intentelo nuevamente.",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            },
            complete: function(){
                $(".tempde_footer .icon-loading-md").hide();
                $(".btn-sendMail").show();
            }
        });
    });
	// Dev: RC -> End


    $("#nuevoOcompa").click(function(){
        var sucursal = $("#compania").val();
        url = base_url + "index.php/compras/ocompra/nueva_ocompra/"+tipo_oper+"/"+sucursal;
        location.href = url;
    });

    function on_click_grabar() {
        $( "#grabarOcompra" ).unbind("click");
        $( "#salir").val(1);

        var error=0;
        $('img#loading').css('visibility','visible');
        var codigo=$('#codigo').val();
        if($("#serie").val()==""){
            $("#grabarOcompra").click(on_click_grabar);
            $("#serie").focus();
            alert("Ingrese la serie.");
            $('img#loading').css('visibility','hidden');
            return false;
        }
        
        if($('#cliente').val()==""){
            $("#grabarOcompra").click(on_click_grabar);
            alert('Seleccione Cliente');
            $('#cliente').focus();
            $('img#loading').css('visibility','hidden');
            return false;           
        }
        
        if($('#proveedor').val()==""){
            $("#grabarOcompra").click(on_click_grabar);
            alert('Seleccione Proveedor');
            $('#ruc_proveedor').focus();
            $('img#loading').css('visibility','hidden');
            return false;           
        }
        
        if($("#formapago").val()==''){
            $("#grabarOcompra").click(on_click_grabar);
            alert("Seleccione Forma de pago.");
            //$("#forma_pago option[value=2]").attr("selected",true);
            $('img#loading').css('visibility','hidden');
            return false;         
        }

        n = document.getElementById('tempde_tbl').rows.length;
        if(n==0){
            $("#grabarOcompra").click(on_click_grabar);
            alert("Ingrese un producto.");
            $('img#loading').css('visibility','hidden');
            return false;     
        }

        //buscando y calculando flete
        if(tipo_oper == 'C') searchFlete();

        if(codigo=='')
            url = base_url+"index.php/compras/ocompra/insertar_ocompra";
        else
            url = base_url+"index.php/compras/ocompra/modificar_ocompra";
            
        dataString  = $('#frmOcompra').serialize();
        $.post(url,dataString,function(data){
            $('img#loading').css('visibility','hidden');
            switch(data.result){
                case 'ok':
                    location.href = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
                    break;
                case 'error':
                    $("#grabarOcompra").click(on_click_grabar);
                    if(data.campo){
                        $('input[type="text"][readonly!="readonly"], select, textarea').css('background-color', '#FFFFFF');
                        $('#'+data.campo).css('background-color', '#FFC1C1').focus();
                    }else
                    if(data.msj)
                        alert(data.msj);
                    break;
                case 'error2':
                    $("#grabarOcompra").click(on_click_grabar);
                    alert(data.msj);
                    break;
            }
        },'json');
    }

    $("#grabarOcompra").click(on_click_grabar);

    $("#limpiarOcompra").click(function(){
        $('#ordencompraventa').val('');
        $('#ordencompraempresa').val('');
        $('#cboMoneda').val('1');
        $('#cboFormapago').val('1');
        $('#contacto').val('');
        $("#cboContacto").val('');
        $("#cboVendedor").val('');
        $('#descuento').val('0');
        $('#comprador').val('0');
        $('#percepcion').val('');
        $('#cliente').val('');
        $('#ruc_cliente').val('');
        $('#nombre_cliente').val('');
        $('#proveedor').val('');
        $('#ruc_proveedor').val('');
        $('#buscar_cliente').val('');
        $('#buscar_proveedor').val('');
       
        $('#nombre_proveedor').val('');
        $('#pedido').val('');
        $('#cotizacion').val('');
        $('#fechaentrega').val('');
        $('#preciototal').val('');
        $('#descuentotal').val('');
        $('#igvtotal').val('');
        $('#percepciontotal').val('');
        $('#importetotal').val('');
        $('#ctactesoles').val('');
        $('#ctactedolares').val('');
        $('#observacion').val('');
        $('#tipoComprobante').val('');
        $('#tiempo_entrega').val('');
        $('#envio_direccion').val('');
        $('#fact_direccion').val('');
        n = document.getElementById('tempde_tblbody').rows.length;
        for(i=0;i<n;i++){
            eliminar_producto_temporal_all(i);
        }
        /*$("#salir").val(1);
        url = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
        location.href = url;*/
    });

    $("#volverSeguimiento").click(function(){
        $("#salir").val(1);
        url = base_url+"index.php/compras/ocompra/seguimiento_ocompras/0/"+tipo_oper+"/1";
        location.href = url;
    });

    $("#cancelarOcompra").click(function(){
        $("#salir").val(1);
        url = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
        location.href = url;
    });
    $("#aceptarOcompra").click(function(){
        url = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper+"/1";
        location.href = url;
    });
    $("#cancelarOcompra2").click(function(){
        url = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
        location.href = url;
    }); 

    $("#aprobarOcompra").click(function(){
        $("#flag").val('1');
        $("#frmEvaluar").submit();
    }); 
    $("#desaprobarOcompra").click(function(){
        $("#flag").val('2');
        $("#frmEvaluar").submit();
    });

    $("#downloadOcompra").click(function(){
        var inicio = $("#numeroI").val();
        var fin = $("#numeroF").val();

        if (parseInt(inicio) > parseInt(fin)){
            alert("Rango de cotizaciones invalido.");
        }
        else{
            location.href = base_url + "index.php/almacen/almacenproducto/verCotizados/"+inicio+"/"+fin;
        }
    });

    $("#imprimirOcompra").click(function(){
        // var inicio = $("#numeroI").val();
        // var fin = $("#numeroF").val();

        // if (inicio == null || inicio == undefined || inicio == NaN || inicio == ""){
        //     alert("indique un numero de inicio.");
        //     $("#numeroI").focus();
        //     return null;
        // }
        // if (fin == null || fin == undefined || fin == NaN || fin == ""){
        //     alert("indique un numero de fin.");
        //     $("#numeroF").focus();
        //     return null;
        // }

        // if (parseInt(inicio) > parseInt(fin)){
        //     alert("Rango de cotizaciones invalido.");
        // }
        // else{
            var url = base_url + "index.php/compras/ocompra/ocompra_ver_pdf_rango/"
            window.open(url, '_blank', 'width=700,height=480,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0');
        // }
    });

    $("#imprimirOcompraFiltro").click(function(){

        var tipo_oper = "V";
        var fechai = $("#fechai").val();
        var fechaf = $("#fechaf").val();

        var nombre_cliente = $("#nombre_cliente").val();
        var ruc_cliente = $("#ruc_cliente").val();
        
        var producto = $("#producto").val();
        var vendedor = $("#cboVendedor").val();

        if (fechai == undefined || fechai == "")
            fechai = "0";

        if (fechaf == undefined || fechaf == "")
            fechaf = "0";

        if (nombre_cliente == undefined || nombre_cliente == "")
            nombre_cliente = "0";

        if (ruc_cliente == undefined || ruc_cliente == "")
            ruc_cliente = "0";

        if (producto == undefined || producto == "")
            producto = "0";

        if (vendedor == undefined || vendedor == "")
            vendedor = "0";
        

        var param = tipo_oper + "/" + fechai + "/" + fechaf + "/" + nombre_cliente + "/" + ruc_cliente + "/" + producto + "/" + vendedor;
        var url = base_url + "index.php/compras/ocompra/imprimirOcompraFiltro/" + param;
        window.open(url, '_blank', 'width=700,height=480,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0');
    });

    $("#checkTodos").change(function(){
        $('input').each( function() {                   
            if($("#checkTodos").attr('checked') == true){
                this.checked = true;
            } else {
                this.checked = false;
            }
        });               
    });

    $('img#linkVerPersona').click(function(){
        var contacto=$('#contacto').val();
        if(contacto!='')
            window.open(base_url+'index.php/maestros/persona/persona_ventana_mostrar/'+contacto, '_blank', 'width=700,height=380,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'); 
    });
    $('#contacto').change(function(){
        if(this.value!=''){
            var contacto=this.value;
            $('#linkVerPersona').show().attr('href', base_url+'index.php/maestros/persona/persona_ventana_mostrar/0/'+contacto);
        }
        else
            $('#linkVerPersona').hide();
    });

    $("#lugar_entrega").click(function() {
        $('#lista_direcciones').slideUp("fast"); 
        $('#lista_direcciones_fact').slideUp("fast"); 
    });

    $("#linkVerDirecciones").click(function(){
        if(tipo_oper=='V')
            var cliente=$("#cliente").val();
       else
            var proveedor=$("#proveedor").val();
            
        $("#lista_direcciones ul").html('');
        $("#lista_direcciones_fact").slideUp("fast");
        $("#lista_direcciones").slideToggle("fast", function(){
            if(tipo_oper !='V')
                  url = base_url+"index.php/compras/proveedor/JSON_listar_sucursalesEmpresa/"+proveedor;
            else
                url = base_url+"index.php/ventas/cliente/JSON_listar_sucursalesEmpresa/"+cliente;
                
            $.getJSON(url,function(data){
                $.each(data, function(i,item){
                    fila='';
                    if(item.Tipo=='1'){
                        fila+='<li style="list-style: none; font-weight:bold; color:#aaa"">'+item.Titulo+'</li>';
                    }
                    else{
                        fila+='<li><a href="javascript:;">'+item.EESTAC_Direccion;
                        fila+='</a></li>';
                    }
                    $("#lista_direcciones ul").append(fila);
                });
            });
            return true;
        });
        return true;
    });
    $("#lista_direcciones li a").live('click',function(){
        $("#envio_direccion").val($(this).html());
        $('#lista_direcciones').slideUp("fast"); 
    });
        
    $("#fact_direccion, #envio_direccion").click(function() {
        $('#lista_direcciones').slideUp("fast"); 
        $('#lista_direcciones_fact').slideUp("fast"); 
    });
    $("#linkVerDirecciones_fact").click(function(){
        if(tipo_oper=='V')
            var cliente=$("#cliente").val();
        else
            var proveedor=$("#proveedor").val();    
                
        $('#lista_direcciones').slideUp("fast"); 
        $("#lista_direcciones_fact ul").html('');
        $("#lista_direcciones_fact").slideToggle("fast", function(){
            var url;
            if(tipo_oper !='V')
               url = base_url+"index.php/compras/proveedor/JSON_listar_sucursalesEmpresa/"+proveedor;
            else
                url = base_url+"index.php/ventas/cliente/JSON_listar_sucursalesEmpresa/"+cliente;
                
            $.getJSON(url,function(data){
                $.each(data, function(i,item){
                    fila='';
                    if(item.Tipo=='1'){
                        fila+='<li style="list-style: none; font-weight:bold; color:#aaa"">'+item.Titulo+'1245</li>';
                    }else{
                        fila+='<li><a href="javascript:;">'+item.EESTAC_Direccion;
                        fila+='</a></li>';
                    } 
                    $("#lista_direcciones_fact ul").append(fila);
                });
            });
            return true;
        });
        return true;
    });

    $("#lista_direcciones_fact li a").live('click',function(){
        $("#fact_direccion").val($(this).html());
        $('#lista_direcciones_fact').slideUp("fast"); 
    });
        
    $('#buscar_cliente').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==20){
            if($(this).val()!=''){
                $('#linkSelecCliente').attr('href', base_url+'index.php/ventas/cliente/ventana_selecciona_cliente/'+$('#buscar_cliente').val()).click();
            }
        } 
    });
    
    $('#nombre_cliente').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==20){
            if($(this).val()!=''){
                $('#linkSelecCliente').attr('href', base_url+'index.php/ventas/cliente/ventana_selecciona_cliente/'+$('#nombre_cliente').val()).click();
            }
        }
    });

    $("#linkVerSerieNum").click(function () {
        var temp=$("#linkVerSerieNum p").html();
        var serienum=temp.split('-');
        $("#serie").val(serienum[0]);
        $("#numero").val(serienum[1]);
    });
    
    $('#buscar_proveedor').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==13){
            if($(this).val()!=''){
                $('#linkSelecProveedor').attr('href', base_url+'index.php/compras/proveedor/ventana_selecciona_proveedor/'+$('#buscar_proveedor').val()).click();
            }
        } 
    });
        
     $('#nombre_proveedor').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==13){
            if($(this).val()!=''){
                $('#linkSelecProveedor').attr('href', base_url+'index.php/compras/proveedor/ventana_selecciona_proveedor/'+$('#nombre_proveedor').val()).click();
            }
        } 
    }); 
        
        
    $('#buscar_producto').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==13){
            if($(this).val()!=''){                                                                                  //tipo oper estaba asi stv
                $('#linkSelecProducto').attr('href', base_url+'index.php/almacen/producto/ventana_selecciona_producto/C/'+$('#flagBS').val()+'/'+$('#buscar_producto').val()).click();
            }
        } 
    });
        
    $('#cantidad').bind('keypress', function(e) {
        tipo_oper = $("#tipo_oper").val();
        flagGenInd      = $("#flagGenInd").val();
        if(flagGenInd=='I'){
            if(e.keyCode==9 || e.keyCode==13){
                if(tipo_oper == 'V'){
                    if($(this).val()!=''){
                        var cantidad=parseInt($(this).val());
                        var stock=parseInt($('#stock').val());
                        if(cantidad>stock){
                            alert('La cantidad no debe ser mayor al stock.');
                            $(this).val('').focus();
                            return false;
                        }
                        ventana_producto_serie2_2();
                    }
                }
            }
        }
    });
        
    $('input[id^="prodcantidad"]').live('keypress', function(e) {
        var tipo_oper = $("#tipo_oper").val();
        var flagGenInd = $(this).parent().parent().parent().find('input[id^="flagGenIndDet"]').val();
        if(flagGenInd=='I'){
            if(e.keyCode==9 || e.keyCode==13){
                var almacen  = $('#almacen').val();
                var producto = $(this).parent().parent().parent().find('input[id^="prodcodigo"]').val();
                var cantidad=parseInt($(this).val());
                var stock=parseInt($(this).parent().parent().parent().find('input[id^="prodstock"]').val());
                if(tipo_oper == 'V'){
                    if($(this).val()!=''){                            
                        if(cantidad>stock){
                            alert('La cantidad no debe ser mayor al stock.');
                            $(this).val('').focus();
                            return false;
                        }
                        if(e.keyCode==13)
                            ventana_producto_serie2_3(almacen, producto, cantidad);
                    }
                }
            }
        }
        return true;
    });
});

// Dev: RC -> Begin - functions index
	function search( search = true ){
		var fechai = "";
		var fechaf = "";
		var nombre_cliente = "";
		var ruc_cliente = "";
		var nombre_proveedor = "";
		var ruc_proveedor = "";
		var producto = "";
		var aprobado = "";
		var ingreso = "";
		var cboVendedor = "";
		var codigoEmpleado = "";

		if (search == false){
	    $("#cliente").val("");
	    $("#proveedor").val("");
	    $("#producto").val("");
			$("#form_busqueda")[0].reset();
		}
		else{
	    fechai          = $("#fechai").val();
	    fechaf          = $("#fechaf").val();
	    nombre_cliente  = $("#nombre_cliente").val();
	    ruc_cliente     = $("#ruc_cliente").val();
	    nombre_proveedor = $("#nombre_proveedor").val();
	    ruc_proveedor   = $("#ruc_proveedor").val();
	    producto        = $("#producto").val();
	    aprobado        = $("#aprobado").val();
	    ingreso         = $("#ingreso").val();
	    cboVendedor     = $("#cboVendedor").val();
	    codigoEmpleado  = $("#codigoEmpleado").val();
	  }

	  $('#table-ocompra').DataTable({
	    filter: false,
	    destroy: true,
	    processing: true,
	    serverSide: true,
	    ajax:{
	      url : base_url + "index.php/compras/ocompra/datatable_ocompra/" + tipo_oper,
	      type: "POST",
	      data: {
	        fechai: fechai, 
	        fechaf: fechaf,
	        nombre_cliente: nombre_cliente,
	        ruc_cliente: ruc_cliente,
	        nombre_proveedor: nombre_proveedor,
	        ruc_proveedor: ruc_proveedor,
	        producto: producto,
	        aprobado: aprobado,
	        ingreso: ingreso,
	        cboVendedor: cboVendedor,
	        codigoEmpleado: codigoEmpleado
	      },
	      beforeSend: function(){
	        $(".loading-table").show();
	      },
	      error: function(){
	      },
	      complete: function(){
	        $(".loading-table").hide();
	      }
	    },
	    language: spanish,
	    order: [[ 0, "desc" ]]
	  });
	}

	function open_mail( id ){
	  $(".modal-envmail").modal("toggle");
	  url = base_url + "index.php/compras/ocompra/getInfoSendMail";

	  $.ajax({
	    url: url,
	    type: "POST",
	    data:{ id: id },
	    dataType: "json",
	    error: function(){
	    },
	    beforeSend: function(){
	      $("#idDocMail").val("");
	      $("#ncliente").val("");
	      $("#doccliente").val("");
	      $("#doccliente").val("");
	      $("#destinatario").val("");

	      $(".mail-cliente").html("");
	      $(".mail-empresa-envio").html("");
	      $(".mail-serie-numero").html("");
	      $(".mail-fecha").html("");
	      $(".mail-importe").html("");

	      $(".mail-contactos").html("");
	    },
	    success: function(data){
	      var info = data.info[0];
	      if (data.match == true){
	        $("#idDocMail").val(info.codigo);
	        $("#ncliente").val(info.nombre);
	        $("#doccliente").val(info.ruc);
	        $("#doccliente").val(info.ruc);

	        $(".mail-cliente").html(info.nombre);
	        $(".mail-empresa-envio").html(info.empresa_envio);
	        $(".mail-serie-numero").html(info.serie + " - " + info.numero );
	        $(".mail-fecha").html(info.fecha);
	        $(".mail-importe").html(info.importe);

	        $.each(info.contactos, function(i, item){
	            var inputsContactos = "&nbsp;<input type='checkbox' class='ncontacto' onclick='ingresar_correo(\"" + item.correo + "\")' value='" + item.correo + "'>" + item.contacto;
	            $(".mail-contactos").append(inputsContactos);
	        });
	      }
	    }
	  });
	}

	function ingresar_correo(correo){

	  destinatarios = $("#destinatario").val();
	  correosI = destinatarios.split(",");
	  cantidad = correosI.length;

	  add = true;

	  for (i = 0; i < cantidad; i++){
	    if ( correosI[i] == correo )
	      add = false;
	  }

	  if ( add == true){
	    if (destinatarios != "")
	      $("#destinatario").val(destinatarios + "," + correo);
	    else
	      $("#destinatario").val(correo);
	  }
	  else{
	    nvoCorreos = "";
	    for (i = 0; i < cantidad; i++){
	      if ( correosI[i] != correo ){
	        if ( i > 0 && nvoCorreos != "" ){
	          nvoCorreos += ",";
	        }
	        nvoCorreos += correosI[i];
	      }
	    }
	    $("#destinatario").val(nvoCorreos);
	  }
	}

	function canjeToGuia(OC, pos){

    $(".loading_g_"+pos).show();

    var url = base_url+"index.php/compras/ocompra/insertar_guiarem/"+OC;

    $.ajax({
      type: "POST",
      url: url,
      data: { idOC: OC },
      dataType: 'json',
      beforeSend: function (data) {
      },
      success: function (data) {
        switch (data.result){
          case 'success':
    				var pdf = '<a href="' + base_url + 'index.php/almacen/guiarem/guiarem_ver_pdf/' + data.guia + '/a4/1" data-fancybox data-type="iframe">' +
	  									' <span style="font-weight: bold; font-size: 7pt; color:green">' + data.sernum + '</span>' +
	  									'</a>';

	  				var edit = '<a href="' + base_url + 'index.php/almacen/guiarem/editar/' + data.guia + '/' + tipo_oper + '">' +
	  									 '	<img src="' + base_url + 'images/modificar.png" width="16" height="16" border="0" title="Modificar">' +
	  									 '</a>';

            $(".gResult_"+pos).html(pdf + ' ' + edit);
            $(".loading_g_"+pos).hide();
            break;
          case 'error':
            Swal.fire({
              icon: "error",
              title: data.message,
              html: "<b class='color-red'></b>",
              showConfirmButton: true,
              timer: 4000
            });
            $(".loading_g_"+pos).hide();
            break;
        }
      }
    });
	 }

	function canjeToComprobante(OC, pos, typeDoc = 'N'){

		/* TypeDoc
			 -> Factura (F)
			 -> Boleta (B)
			 -> Comprobante (N)
		*/

	  $(".loading_c_"+pos).show();
	    
	  var url = base_url+"index.php/compras/ocompra/insertar_comprobante/";

	  $.ajax({
	      type: "POST",
	      url: url,
	      data: { idOC: OC, doc: typeDoc },
	      dataType: 'json',
	      beforeSend: function (data) {
	      },
	      success: function (data) {
	        switch (data.result){
	          case 'success':
	  					var pdf = '<a href="' + base_url + 'index.php/ventas/comprobante/comprobante_ver_pdf/' + data.comprobante + '/a4" data-fancybox data-type="iframe">' +
			          				'	<span style="font-weight: bold; font-size: 7pt; color:green">' + data.sernum + '</span>' +
			          				'</a>';
	            $(".cResult_"+pos).html(pdf);
	            $(".loading_c_"+pos).hide();
	            break;
	          case 'error':
	            Swal.fire({
	              icon: "error",
	              title: data.message,
	              html: "<b class='color-red'></b>",
	              showConfirmButton: true,
	              timer: 4000
	            });
	            $(".loading_c_"+pos).hide();
	            break;
	        }
	      }
	  });
	}

	function ocompra_download_excel(ocompra){
    url = base_url + "index.php/compras/ocompra/ocompra_descarga_excel/"+ocompra;
    location.href = url;
	}
// Dev: RC -> End


function ver_reporte_pdf_compras(){
    var anio = $("#anioVenta").val();
    url = base_url+"index.php/ventas/comprobante/ver_reporte_pdf_commpras/"+anio;
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}

function enviar_cotizacion(codigo){
    url = base_url+"index.php/compras/ocompra/ventana_cotizacion_correos/"+codigo;
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}

function estadisticas_compras_ventas(tipo){
    var anio = $("#anioVenta2").val();
    url = base_url+"index.php/ventas/comprobante/estadisticas_compras_ventas/"+tipo+"/"+anio;
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}

function estadisticas_compras_ventas_mensual(tipo){
    var anio = $("#anioVenta3").val();
    var mes = $("#mesVenta3").val();
    url = base_url+"index.php/ventas/comprobante/estadisticas_compras_ventas_mensual/"+tipo+"/"+anio+"/"+mes+"";
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}

function estadisticas_compras_ventas_mensual_excel(tipo) {
    var anio = $("#anioVenta3").val();
    var mes = $("#mesVenta3").val();
    url = base_url + "index.php/ventas/comprobante/estadisticas_compras_ventas_mensual_excel/" + tipo + "/" + anio + "/" + mes + "";
    window.open(url, '', "width=800,height=600,menubars=no,resizable=no;");
}

function editar_ocompra(ocompra){
    location.href=base_url+"index.php/compras/ocompra/editar_ocompra/"+ocompra+'/'+tipo_oper;
}

function ver_detalle_ocompra(ocompra){
    location.href=base_url+"index.php/compras/ocompra/ver_detalle_ocompra/"+ocompra+'/'+tipo_oper;
}

function eliminar_ocompra(ocompra){
    if(confirm('Esta seguro desea eliminar a esta Orden de Compra?')){
        dataString   = "codigo="+ocompra;
        url          = base_url+"index.php/compras/ocompra/eliminar_ocompra";
        ;
        $.post(url,dataString,function(data){
            location.href = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
        });
    }
}

function ver_ocompra(ocompra){
    location.href = base_url+"index.php/compras/ocompra/ver_ocompra/"+ocompra;
}

function ocompra_ver_pdf(ocompra){
    //url = base_url+"index.php/compras/ocompra/ocompra_ver_pdf/"+ocompra;
    url = base_url+"index.php/compras/ocompra/ocompra_ver_pdf_conmenbrete/"+ocompra+"/0";
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}

function ocompra_ver_pdf_conmenbrete(ocompra){
    url = base_url+"index.php/compras/ocompra/ocompra_ver_pdf_conmenbrete/"+ocompra+"/1";
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}

function atras_ocompra(){
    location.href = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
}

function ver_reporte_pdf(){
    var fechai=$('#fechai').val();
    var fechaf=$('#fechaf').val();
    var proveedor=$('#proveedor').val();
    var producto=$('#producto').val();
    var aprobado=$('#aprobado').val();
    var ingreso=$('#ingreso').val();
     var tipo_oper = $("#tipo_oper").val();
    tipo_oper="C";
    
    url = base_url+"index.php/compras/ocompra/ver_reporte_pdf/"+fechai+'_'+fechaf+'_'+proveedor+'_'+producto+'_'+aprobado+'_'+ingreso+"/"+tipo_oper;
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}
function agregar_producto_ocompra(){
    flagBS  = $("#flagBS").val();
    
    if($("#producto").val()==''){
        alert('Ingrese el producto.');
        $("#codproducto").focus();
        return false;
    }
    if($("#cantidad").val()==''){
        alert('Ingrese una cantidad.');
        $("#cantidad").focus();
        return false;
    }
    /*if($("#unidad_medida").val()==0){
        $("#unidad_medida").focus();
        alert('Seleccione una unidad de medida.');
        return false;
    }*/
    
    codproducto     = $("#codproducto").val();
    producto        = $("#producto").val();
    nombre_producto = $("#nombre_producto").val();
    cantidad        = $("#cantidad").val();
    igv = parseInt($("#igv").val());
    precio_conigv = parseFloat($("#precio").val());
    if(contiene_igv=='1'){
        precio=(precio_conigv*100/(igv+100));
    }
    else{
        precio=precio_conigv;
        precio_conigv = (precio_conigv*(100+igv)/100);
    }
    stock           = parseFloat($("#stock").val());
    costo           = parseFloat($("#costo").val());
    unidad_medida   = '';
    nombre_unidad   = '';
    if(flagBS=='B'){
        unidad_medida = $("#unidad_medida").val();
        nombre_unidad = $('#unidad_medida option:selected').html()
    }
    
    flagGenInd      = $("#flagGenInd").val();
    almacenProducto =$("#almacenProducto").val();
    n = document.getElementById('tblDetalleOcompra').rows.length;
    j = n+1;
    if(j%2==0){
        clase="itemParTabla";
    }else{
        clase="itemImparTabla";
    }
    
    
    fila = '<tr class="'+clase+' det_prod_id_'+producto+'" id="ov_prod_id_0_'+producto+'">';
    fila+= '<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
    fila+= '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
    fila+= '</a></strong></font></div></td>';
    fila+= '<td width="4%"><div align="center">'+j+'</div></td>';
    fila+= '<td width="10%"><div align="center">';
    fila+= '<input type="hidden" class="cajaMinima prodcodigo" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
    fila+= '<input type="hidden" class="cajaMinima" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
    fila+= '<input type="hidden" name="prodobservacion['+n+']" id="prodobservacion_'+n+'" value="">';
    fila+= '<input type="hidden" class="cajaMinima" name="flagGenIndDet['+n+']" id="flagGenIndDet['+n+']" value="'+flagGenInd+'">';
    fila+= '</div></td>';
    fila+= '<td><div align="left">';
    fila+= '<img src="'+base_url+'images/ver_detalle.png" style="cursor:pointer;margin-right: 5px;" onclick="llenarObservacion('+n+')">';
    fila+= '<input type="text" class="cajaGeneral cajaSoloLectura" style="width:369px;" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" readonly>';
    fila+= '</div></td>';
    fila+= '<td width="10%"><div align="left">';
    fila+= '<input type="text" class="cajaGeneral" size="1" maxlength="5" style="text-align:right" name="prodcantidad['+n+']" id="prodcantidad['+n+']" value="'+cantidad+'" onchange="modificar_cantidad('+n+')" onblur="calcula_importe('+n+');" onkeypress="return numbersonly(this,event,\'.\');"> ' + nombre_unidad;
    fila+= '<input type="hidden" name="pendiente['+n+']" id="pendiente['+n+']" value="'+cantidad+'">'
    fila+= '</div></td>';
    fila += '<td width="6%"><div><input type="text" size="5" maxlength="10" style="text-align:right" class="cajaGeneral cajaSoloLectura" value="'+precio_conigv+'" name="prodpu_conigv['+n+']" id="prodpu_conigv['+n+']" onblur="modifica_pu_conigv('+n+');" onkeypress="return numbersonly(this,event,\'.\');" readonly/></div></td>'
    fila += '<td width="6%"><div><input type text" align="rigth" size="5" maxlength="10" style="text-align:right" class="cajaGeneral pu" value="'+precio.format(false)+'" name="prodpu['+n+']" id="prodpu['+n+']" onblur="modifica_pu('+n+');" onchange="igualarPrecioUnitario()" onkeypress="return numbersonly(this,event,\'.\');">'
    fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio['+n+']" id="prodprecio['+n+']" value="0" readonly="readonly"></div></td>';
    fila+= '<td width="6%"><div align="center"><input  style="text-align:right" type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" id="prodigv['+n+']" readonly></div></td>';
    fila+= '<td width="6%"><div align="center">';
    fila+= '<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
    fila+= '<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
    fila+= '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv+'">';
    fila+= '<input type="hidden" name="prodstock['+n+']" id="prodstock['+n+']" value="'+stock+'"/>';
    fila+= '<input type="hidden" name="oventacod['+n+']" id="oventacod['+n+']" value="null"/>';
    fila+= '<input type="hidden" name="prodcosto['+n+']" id="prodcosto['+n+']" value="'+costo+'" readonly="readonly">';
    fila += '<input type="hidden" name="almacenProducto[' + n + ']" id="almacenProducto[' + n + ']" value="' + almacenProducto + '"/>';
    fila+= '<input type="hidden" name="proddescuento100['+n+']" id="proddescuento100['+n+']" value="0">';
    fila+= '<input type="hidden" name="proddescuento['+n+']" id="proddescuento['+n+']" onblur="calcula_importe2('+n+');" />';
    fila+= '<input type="text" size="5" maxlength="10" style="text-align:right" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="0" readonly="readonly">';
    fila+= '</div></td>';
    fila+= '</tr>';
    $("#tblDetalleOcompra").append(fila);
    
    inicializar_cabecera_item();  
    calcula_importe(n);
    return true;  
}

function eliminar_producto_ocompra(n){
    if(confirm('Esta seguro que desea eliminar este producto?')){
        tabla       = document.getElementById('tblDetalleOcompra');
        a           = "detacodi["+n+"]";
        b           = "detaccion["+n+"]";
        fila        = document.getElementById(a).parentNode.parentNode.parentNode;

        $(fila).hide();

        document.getElementById(b).value = "e";

        calcula_totales();
    }
}
function calcula_importe(n){
    a  = "prodpu["+n+"]";
    b  = "prodcantidad["+n+"]";
    c  = "proddescuento["+n+"]";
    d  = "prodigv["+n+"]";
    e  = "prodprecio["+n+"]";
    f  = "prodimporte["+n+"]";
    g = "prodigv100["+n+"]";
    h = "proddescuento100["+n+"]";
    i = "prodpu_conigv["+n+"]";
    pu = document.getElementById(a).value;
    pu_conigv = document.getElementById(i).value;
    cantidad = document.getElementById(b).value;
    igv100 = document.getElementById(g).value;
    descuento100 = document.getElementById(h).value;
    precio = (pu*cantidad);
    total_dscto = (precio*descuento100/100);
    precio2 = (precio-parseFloat(total_dscto));
    
    if(pu_conigv=='')
        total_igv = (precio2*igv100/100);
    else{
        total_igv = ((pu_conigv-pu)*cantidad);
        //total_igv = (precio2*igv100/100);
    }
    importe = (precio-parseFloat(total_dscto)+parseFloat(total_igv));

    document.getElementById(c).value = total_dscto.format(false);
    document.getElementById(d).value = total_igv.format(false);
    document.getElementById(e).value = precio.format(false);
    document.getElementById(f).value = importe.format(false);
    
    calcula_totales();
}
function calcula_importe2(n){
    a  = "prodpu["+n+"]";
    b  = "prodcantidad["+n+"]";
    c  = "proddescuento["+n+"]";
    e  = "prodigv["+n+"]";
    f  = "prodprecio["+n+"]";
    g  = "prodimporte["+n+"]";
    pu           = parseFloat(document.getElementById(a).value);
    cantidad     = parseFloat(document.getElementById(b).value);
    descuento    = parseFloat(document.getElementById(c).value);
    total_igv    = parseFloat(document.getElementById(e).value);
    importe      = ((pu*cantidad)-descuento+total_igv);
    document.getElementById(g).value = importe.format(false);
    
    calcula_totales();
}
function calcula_totales(){
    n = document.getElementById('tblDetalleOcompra').rows.length;
    importe_total = 0;
    igv_total = 0;
    descuento_total = 0;
    precio_total = 0;
     ////aumentado
    igvtotal=0;
    importetotal=0;
    preciototal=0;
    ///
    for(i=0;i<n;i++){//Estanb al reves los campos
        a = "prodimporte["+i+"]"
        b = "prodigv["+i+"]";
        c = "proddescuento["+i+"]";
        d = "prodprecio["+i+"]";
        e  = "detaccion["+i+"]";        

        if(document.getElementById(e) != null && document.getElementById(e).value != 'e' && document.getElementById(e).value != 'EE'){
            importe = parseFloat(document.getElementById(a).value);
            igv = parseFloat(document.getElementById(b).value);
            descuento = parseFloat(document.getElementById(c).value);
            precio = parseFloat(document.getElementById(d).value);
            importe_total = (importe + importe_total);
            igv_total = (igv + igv_total);
            descuento_total = (descuento + descuento_total);
            precio_total = (precio + precio_total);
        }
    }
    igvtotal=((importe_total * $("#igv").val()) / 118);
       preciototal=(importe_total-igvtotal);
       importetotal=importe_total;
    ///
    $("#importetotal").val(importetotal.format(false));  //val(importe_total)
    $("#igvtotal").val(igvtotal.format(false));  //val(igv_total)
    $("#descuentotal").val(descuento_total.format(false));
    $("#preciototal").val(preciototal.format(false));  //val(precio_total)
}
function modifica_pu_conigv(n){
    a  ="prodpu_conigv["+n+"]";
    g = "prodigv100["+n+"]";
    i = "prodpu["+n+"]";
    pu_conigv = parseFloat(document.getElementById(a).value);
    igv100 = parseFloat(document.getElementById(g).value);
    
    pu = (100*pu_conigv/(100+igv100));
    document.getElementById(i).value=pu.format(false);
    
    calcula_importe(n);
}
function modifica_pu(n){
    a = "prodpu["+n+"]";
    g = "prodigv100["+n+"]";
    i = "prodpu_conigv["+n+"]";
    
    pu = parseFloat(document.getElementById(a).value);
    igv100 = parseFloat(document.getElementById(g).value); 
    precio_conigv = (pu*(100+igv100)/100);
    document.getElementById(i).value=precio_conigv.format(false);
    
    calcula_importe(n);
}
function modifica_descuento_total(){
    descuento = parseFloat($('#descuento').val());
    n     = document.getElementById('tblDetalleOcompra').rows.length;
    for(i=0;i<n;i++){
        a = "proddescuento100["+i+"]";
        document.getElementById(a).value = descuento.format(false);
    }
    for(jj=0;jj<n;jj++){
        calcula_importe(jj);
    }
    calcula_totales();
}
function modifica_igv_total(){
    igv = $('#igv').val();
    n     = document.getElementById('tblDetalleOcompra').rows.length;
    for(i=0;i<n;i++){
        a = "prodigv100["+i+"]";
        document.getElementById(a).value = igv.format(false);
    }
    for(jj=0;jj<n;jj++){
        calcula_importe(jj);
    }
    calcula_totales();
}
function listar_unidad_medida_producto(producto){

/////////stv
    var base_url      = $("#base_url").val();
    var flagBS        = $("#flagBS").val();
    url          = base_url+"index.php/almacen/producto/listar_unidad_medida_producto/"+producto;
    select_umedida   = document.getElementById('unidad_medida');

    limpiar_combobox('unidad_medida');

    $("#cantidad").val('');
    $("#precio").val('');

    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo            = item.UNDMED_Codigo;
            descripcion  = item.UNDMED_Descripcion;
            simbolo         = item.UNDMED_Simbolo;
            nombre_producto = item.PROD_Nombre;
            marca           = item.MARCC_Descripcion;
            modelo          = item.PROD_Modelo;
            presentacion    = item.PROD_Presentacion;
            opt         = document.createElement('option');
            texto       = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;
            if(i==0)
                opt.selected=true;
            select_umedida.appendChild(opt);
        });
        var nombre;
        nombre=nombre_producto;
        if(flagBS=='B'){
            if(marca)
                nombre+=' / Marca:'+marca;
            if(modelo)
                nombre+=' / Modelo: '+modelo;
            if(presentacion)
                nombre+=' / Prest: '+presentacion;
        }
        $("#nombre_producto").val(nombre);
        listar_precios_x_producto_unidad(producto);
    });
////////////


}
function listar_precios_x_producto_unidad(){
    producto = $("#producto").val();
    unidad = $("#unidad_medida").val();
    moneda = $("#moneda").val();
    base_url = $("#base_url").val();
    flagBS = $("#flagBS").val();

    if(tipo_oper == 'C') {
        url = base_url+"index.php/almacen/producto/listar_precio_for_compra/"+producto+"/"+unidad+"/"+moneda;
    }else {
        url = base_url+"index.php/almacen/producto/listar_precios_x_producto_unidad/"+producto+"/"+unidad+"/"+moneda;
    }
    select_precio   = document.getElementById('precioProducto');
    options_umedida = select_precio.getElementsByTagName("option"); 

    var num_option=options_umedida.length;
    for(i=1;i<=num_option;i++){
        select_precio.remove(0)
    }
    opt = document.createElement("option");
    texto = document.createTextNode("::Seleccion::");
    opt.appendChild(texto);
    opt.value = "";
    select_precio.appendChild(opt);
    $.getJSON(url,function(data){
        if(tipo_oper == 'C') {
            $("#precio").val(data.precio);
        }else {
            $.each(data, function(i,item){
                codigo      = item.codigo;
                moneda      = item.moneda;
                precio      = item.precio;
                opt         = document.createElement('option');
                texto       = document.createTextNode(moneda+" "+precio);
                opt.appendChild(texto);
                opt.value = precio;
                select_precio.appendChild(opt);
            });
        }
    });
}
function mostrar_precio(){
    precio = $("#precioProducto").val();
    $("#precio").val(precio);
}
function obtener_precio_producto(){
    var producto = $("#producto").val();
    if(producto=='')
        producto='0';
    var moneda = $("#moneda").val();
    if(moneda=='')
        moneda='0';
    var cliente = $("#cliente").val();
    if(cliente=='')
        cliente='0';
    var unidad_medida = $("#unidad_medida").val();
    if(unidad_medida=='')
        unidad_medida='0';
    var igv;
    if(contiene_igv=='1')
        igv=0;
    else
    if(tipo_docu!='B')
        igv=0;
    else
        igv=$("#igv").val();
    
    var url = base_url+"index.php/almacen/producto/JSON_precio_producto/"+producto+"/"+moneda+"/"+cliente+"/"+unidad_medida+"/"+igv;
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            $('#precio').val(parseFloat(item.PRODPREC_Precio).format(false));
        });
    });
}
function inicializar_cabecera_item(){
    $("#producto").val('');
    $("#buscar_producto").val('');
    $("#buscar_producto").val('');
    $("#codproducto").val('');
    $("#nombre_producto").val('');
    $("#cantidad").val('');
    $("#costo").val('');
    $("#unidad_medida").val('0');
    $("#precioProducto").val('');
    $("#precio").val('');
    limpiar_combobox('unidad_medida');
}

function load_cotizaciones(){
    var value = $('#pedidos').val();
    if(value == ''){
        $('#text_cotizacion').html("");
        $("#show_cotizaciones").html("");
    }else{
        var url = base_url+"index.php/compras/cuadrocom/cargar_ganadores/"+value;
        $("#show_cotizaciones").load(url);
        $('#text_cotizacion').html("Cotizacion :");
    }
    
}


function obtener_detalle_cotizacion(){//En realidad es detalle de la cotizacion
    cotizacion =  $("#cotizacion").val();
    descuento  =  $("#descuento").val();
    igv        = $("#igv").val();
    url = base_url+"index.php/compras/ocompra/obtener_detalle_cotizacion/"+cotizacion;//Es detalle de la cotizacion
    dataString = "cotizacion="+cotizacion;
    n = 0;
    $.getJSON(url,function(data){
        fila= '<table width="100%" height="250px;" border="0" cellpadding="0" cellspacing="0">';
        fila+= '<tr>';
        fila+= '<td valign="top">';
        fila = '<table id="tblDetalleOcompra" class="fuente8" width="100%" border="0">';
        $.each(data,function(i,item){
            pedido          = item.PEDIP_Codigo;
            n=i;
            j=i+1
            producto        = item.PROD_Codigo;
            codproducto     = item.PROD_CodigoInterno;
            unidad_medida   = item.UNDMED_Codigo;
            nombre_unidad   =item.UNDMED_Simbolo;
            nombre_producto = item.PROD_Nombre;
            cantidad        = item.COTDEC_Cantidad;
            proveedor       = item.PROVP_Codigo;
            ruc             = item.Ruc;
            razon_social    = item.RazonSocial;
            almacen         = item.ALMAP_Codigo;
            formapago       = item.FORPAP_Codigo;
            if((i+1)%2==0){
                clase="itemParTabla";
            }else{
                clase="itemImparTabla";
            }
            fila += '<tr class="'+clase+'">';
            fila +='<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
            fila +='<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
            fila +='</a></strong></font></div></td>';
            fila += '<td width="4%"><div align="center">'+j+'</div></td>';
            fila += '<td width="10%"><div align="center">';
            fila += '<input type="hidden" class="cajaMinima" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
            fila += '<input type="hidden" class="cajaMinima" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
            fila += '</div></td>';
            fila += '<td><div align="left"><input type="text" class="cajaGeneral" style="width:335px;" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
            fila += '<td width="10%"><div align="left">';
            fila += '<input type="text" class="cajaPequena2" name="prodcantidad['+n+']" style="text-align:right" id="prodcantidad['+n+']" value="'+cantidad+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad;
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="text" class="cajaPequena2" name="prodpu['+n+']" style="text-align:right" id="prodpu['+n+']" value="" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="text" class="cajaPequena2" name="prodprecio['+n+']" style="text-align:right" id="prodprecio['+n+']" value="0" readonly="readonly">';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="hidden" class="cajaPequena2" style="text-align:right" name="proddescuento100['+n+']" id="proddescuento100['+n+']" value="'+descuento+'">';
            fila += '<input type="text" class="cajaPequena2" style="text-align:right" name="proddescuento['+n+']" id="proddescuento['+n+']" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="hidden" class="cajaPequena2" style="text-align:right" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv+'">';
            fila += '<input type="text" class="cajaPequena2" style="text-align:right" name="prodigv['+n+']" id="prodigv['+n+']" readonly>';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="text" class="cajaPequena2" style="text-align:right" name="proddescuento2['+n+']" id="proddescuento2['+n+']" value="0" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center">';
            fila +='<input type="hidden" class="cajaMinima" name="detacodi['+n+']" id="detacodi['+n+']">';
            fila +='<input type="hidden" class="cajaMinima" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
            fila += '<input type="text" class="cajaPequena2" style="text-align:right" name="prodimporte['+n+']" id="prodimporte['+n+']" value="0" readonly="readonly" value="0">';
            fila += '</div></td>';
            fila += '</tr>';
        })
        fila+='</table>'
        fila+= '</td>';
        fila+= '</tr>';
        fila+= '</table>';
        $('#pedido').val(pedido);
        $('#ruc_proveedor').val(ruc);
        $('#proveedor').val(proveedor);
        $('#nombre_proveedor').val(razon_social);
        $('#almacen').val(almacen);
        $('#formapago').val(formapago);
        $(".divBusqueda").hide();
        if(n>=0){
            $("#lineaResultado2").html(fila);
        }
        else{
            $("#lineaResultado2").html('');
            alert('La cotizacion no tiene elementos.');
        }
    });
}

function obtener_detalle_presupuesto_compra(){
    presupuesto =  $("#pedidos_ganadores").val();
    descuento100  =  $("#descuento").val();
    igv100        = $("#igv").val();
    
    url = base_url+"index.php/ventas/presupuesto/obtener_detalle_presupuesto/"+presupuesto;
    n = document.getElementById('tblDetalleOcompra').rows.length;
    $.getJSON(url,function(data){
        limpiar_datos();
        $.each(data,function(i,item){
            pedido          = item.PEDIP_Codigo;
            j=n+1
            producto        = item.PROD_Codigo;
            codproducto     = item.PROD_CodigoInterno;
            moneda          = item.MONED_Codigo;
            unidad_medida   = item.UNDMED_Codigo;
            nombre_unidad   = item.UNDMED_Simbolo;
            nombre_producto = item.PROD_Nombre;
            cantidad        = item.PRESDEC_Cantidad;
            pu              = item.PRESDEC_Pu;
            subtotal        = item.PRESDEC_Subtotal;
            descuento       = item.PRESDEC_Descuento;
            igv             = item.PRESDEC_Igv;
            total           = item.PRESDEC_Total
            pu_conigv              = item.PRESDEC_Pu_ConIgv;
            subtotal_conigv        = item.PRESDEC_Subtotal_ConIgv;
            descuento_conigv       = item.PRESDEC_Descuento_ConIgv; 
            cliente         = item.CLIP_Codigo ;
            ruc             = item.Ruc;
            razon_social    = item.RazonSocial;
            formapago       = item.FORPAP_Codigo;
            if(j%2==0){
                clase="itemParTabla";
            }else{
                clase="itemImparTabla";
            }
            fila = '<tr class="'+clase+'">';
            fila +='<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
            fila +='<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
            fila +='</a></strong></font></div></td>';
            fila += '<td width="4%"><div align="center">'+j+'</div></td>';
            fila += '<td width="10%"><div align="center">';
            fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
            fila += '<input type="hidden" class="cajaGeneral" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
            fila += '</div></td>';
            fila += '<td><div align="left"><input type="text" class="cajaGeneral" style="width:335px;" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
            fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad['+n+']" id="prodcantidad['+n+']" style="text-align:right" value="'+cantidad+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad+'</div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu['+n+']" id="prodpu['+n+']" style="text-align:right" value="'+pu.format(false)+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';
            fila += '<td width="6%"><input type="text" style="text-align:right" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio['+n+']" id="prodprecio['+n+']" value="'+subtotal.format(false)+'" readonly="readonly"></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="hidden" name="proddescuento100['+n+']" style="text-align:right" id="proddescuento100['+n+']" value="'+descuento100.format(false)+'">';
            fila += '<input type="text" size="5" maxlength="10" style="text-align:right" class="cajaGeneral" name="proddescuento['+n+']" id="proddescuento['+n+']" value="'+descuento.format(false)+'" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" value="'+igv.format(false)+'" id="prodigv['+n+']" readonly></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila+= '<input type="text" size="5" maxlength="10" style="text-align:right" class="cajaGeneral" name="proddescuento2['+n+']" id="proddescuento2['+n+']" value="0" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila+= '</div></td>'; 
            fila += '<td width="6%"><div align="center">';
            fila +='<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
            fila += '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv100+'">';
            fila +='<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
            fila += '<input type="text" style="text-align:right" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="'+total.format(false)+'" readonly="readonly" value="0">';
            fila += '</div></td>';
            fila += '</tr>';
            $("#tblDetalleOcompra").append(fila);
            $('#ruc_cliente').val(ruc);
            $('#cliente').val(cliente);
            $('#nombre_cliente').val(razon_social);
            $('#formapago').val(formapago);
            $('#moneda').val(moneda);
            n++;
        })
           
        if(n>=0){
            calcula_totales();
        }
        else{
            alert('El presupuesto no tiene elementos.');
        }
    });
}


function obtener_detalle_presupuesto(){
    presupuesto =  $("#presupuesto").val();
    descuento100  =  $("#descuento").val();
    igv100        = $("#igv").val();
    
    url = base_url+"index.php/ventas/presupuesto/obtener_detalle_presupuesto/"+presupuesto;
    n = document.getElementById('tblDetalleOcompra').rows.length;
    $.getJSON(url,function(data){
        limpiar_datos();
        $.each(data,function(i,item){
            pedido          = item.PEDIP_Codigo;
            j=n+1
            producto        = item.PROD_Codigo;
            codproducto     = item.PROD_CodigoInterno;
            moneda          = item.MONED_Codigo;
            unidad_medida   = item.UNDMED_Codigo;
            nombre_unidad   = item.UNDMED_Simbolo;
            nombre_producto = item.PROD_Nombre;
            cantidad        = item.PRESDEC_Cantidad;
            pu              = item.PRESDEC_Pu;
            subtotal        = item.PRESDEC_Subtotal;
            descuento       = item.PRESDEC_Descuento;
            igv             = item.PRESDEC_Igv;
            total           = item.PRESDEC_Total
            pu_conigv              = item.PRESDEC_Pu_ConIgv;
            subtotal_conigv        = item.PRESDEC_Subtotal_ConIgv;
            descuento_conigv       = item.PRESDEC_Descuento_ConIgv; 
            cliente         = item.CLIP_Codigo ;
            ruc             = item.Ruc;
            razon_social    = item.RazonSocial;
            formapago       = item.FORPAP_Codigo;
            if(j%2==0){
                clase="itemParTabla";
            }else{
                clase="itemImparTabla";
            }
            fila = '<tr class="'+clase+'">';
            fila +='<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
            fila +='<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
            fila +='</a></strong></font></div></td>';
            fila += '<td width="4%"><div align="center">'+j+'</div></td>';
            fila += '<td width="10%"><div align="center">';
            fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
            fila += '<input type="hidden" class="cajaGeneral" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
            fila += '</div></td>';
            fila += '<td><div align="left"><input type="text" class="cajaGeneral" style="width:335px;" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
            fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad['+n+']" id="prodcantidad['+n+']" style="text-align:right" value="'+cantidad+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad+'</div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu['+n+']" id="prodpu['+n+']" style="text-align:right" value="'+pu.format(false)+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';
            fila += '<td width="6%"><input style="text-align:right" type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio['+n+']" id="prodprecio['+n+']" value="'+subtotal.format(false)+'" readonly="readonly"></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="hidden" name="proddescuento100['+n+']" id="proddescuento100['+n+']" style="text-align:right" value="'+descuento100.format(false)+'">';
            fila += '<input type="text" style="text-align:right" size="5" maxlength="10" class="cajaGeneral" name="proddescuento['+n+']" id="proddescuento['+n+']" value="'+descuento.format(false)+'" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" value="'+igv.format(false)+'" id="prodigv['+n+']" readonly></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila+= '<input type="text" size="5" style="text-align:right" maxlength="10" class="cajaGeneral" name="proddescuento2['+n+']" id="proddescuento2['+n+']" value="0" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila+= '</div></td>'; 
            fila += '<td width="6%"><div align="center">';
            fila +='<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
            fila += '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv100+'">';
            fila +='<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
            fila += '<input type="text" size="5" style="text-align:right" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="'+total.format(false)+'" readonly="readonly" value="0">';
            fila += '</div></td>';
            fila += '</tr>';
            $("#tblDetalleOcompra").append(fila);
            $('#ruc_cliente').val(ruc);
            $('#cliente').val(cliente);
            $('#nombre_cliente').val(razon_social);
            $('#formapago').val(formapago);
            $('#moneda').val(moneda);
            n++;
        })
           
        if(n>=0){
            calcula_totales();
        }
        else{
            alert('El presupuesto no tiene elementos.');
        }
    });
}

function ventana_ocompra_factura(ocompra){
    url = base_url+"index.php/compras/ocompra/ventana_ocompra_factura/"+ocompra;
    location.href = url;
}
function limpiar_datos(){
    n = document.getElementById('tblDetalleOcompra').rows.length;
    for(i=0;i<n;i++){
        a                = "detacodi["+i+"]";
        b                = "detaccion["+i+"]";
        fila            = document.getElementById(a).parentNode.parentNode.parentNode;
        fila.style.display="none";
        document.getElementById(b).value = "e";
    }
}
function obtener_cliente(){
    var numdoc = $("#ruc_cliente").val();
    $('#cliente,#nombre_cliente').val('');
    
    if(numdoc=='')
        return false;

    var url = base_url+"index.php/ventas/cliente/JSON_buscar_cliente/"+numdoc;
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            if(item.EMPRC_RazonSocial!=''){
                $('#nombre_cliente').val(item.EMPRC_RazonSocial);
                $('#cliente').val(item.CLIP_Codigo);
                $('#codproducto').focus();
            }
            else{
                $('#nombre_cliente').val('No se encontró ningún registro');
                $('#linkVerCliente').focus();
            }
        });
    });
    return true;
}
function obtener_proveedor(){
    var numdoc = $("#ruc_proveedor").val();
    $("#proveedor, #nombre_proveedor").val('');
    
    if(numdoc=='')
        return false;

    var url = base_url+"index.php/compras/proveedor/obtener_nombre_proveedor/"+numdoc;
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            if(item.EMPRC_RazonSocial!=''){
                $('#nombre_proveedor').val(item.EMPRC_RazonSocial);
                $('#proveedor').val(item.PROVP_Codigo);
                $('#codproducto').focus();
            }
            else{
                $('#nombre_proveedor').val('No se encontró ningún registro');
                $('#linkVerProveedor').focus();
            }
        });
    });
    return true;
}
function obtener_producto(){
    var flagBS        = $("#flagBS").val();
    var codproducto   = $("#codproducto").val();
    $("#producto, #nombre_producto").val('');
    if(codproducto=='')
        return false;
    
    var url = base_url+"index.php/almacen/producto/obtener_nombre_producto/"+flagBS+"/"+codproducto;
    $.getJSON(url,function(data){
        $.each(data,function(i,item){
            if(item.PROD_Nombre!=''){
                $("#producto").val(item.PROD_Codigo);
                $("#nombre_producto").val(item.PROD_Nombre);
                listar_unidad_medida_producto($("#producto").val());
                $('#cantidad').focus();
            }
            else{
                $('#nombre_producto').val('No se encontró ningún registro');
                $('#linkVerProducto').focus();
            }
                 
        });
    });
    return true;
}
function listar_contactos(empresa){
    a      = "contacto";
    select = document.getElementById(a);
    
    limpiar_combobox("contacto");
    
    if(tipo_oper=='V')
        cargo='5';
    else
        cargo='4';
    url = base_url+"index.php/maestros/empresa/JSON_listar_personal/"+empresa+"/"+cargo;
    $.getJSON(url,function(data){
        if(data == null) return;
        $.each(data, function(i,item){
            codigo      = item.DIREP_Codigo;
            descripcion = item.PERSC_ApellidoPaterno+' '+item.PERSC_ApellidoMaterno+' '+item.PERSC_Nombre;
            opt         = document.createElement('option');
            texto   = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;
            select.appendChild(opt);
            
        });
    });
    return true;
}
function limpiar_campos_producto(){
    $("#producto,  #codproducto, #nombre_producto, #cantidad, #precio").val('');
    limpiar_combobox('unidad_medida');
    if($('#flagBS').val()=='B')
        $('#unidad_medida').show();
    else
        $('#unidad_medida').hide();
    $('#linkVerProducto').attr('href', ''+base_url+'index.php/almacen/producto/ventana_busqueda_producto/'+$('#flagBS').val());
}

 function agregar_todoocompra(guia){
 
    descuento100  =  $("#descuento").val();
    igv100        = $("#igv").val();
    url = base_url+"index.php/compras/ocompra/obtener_detalle_ocompra2/"+guia;
    n = document.getElementById('tblDetalleOcompra').rows.length;  
    $.getJSON(url,function(data){
        limpiar_datos();
        $.each(data,function(i,item){
            moneda          = item.MONED_Codigo;
            formapago       = item.FORPAP_Codigo;
            serie           = item.PRESUC_Serie;
            numero          = item.OCOMDEC_Numero;
            codigo_usuario  = item.PROD_CodigoUsuario;
                         
            if(item.OCOMDEP_Codigo!=''){
                j=n+1
                producto        = item.PROD_Codigo;
                codproducto     = item.PROD_CodigoUsuario;
                unidad_medida   = item.UNDMED_Codigo;
                nombre_unidad   = item.UNDMED_Simbolo;
                nombre_producto = item.PROD_Nombre;
                flagGenInd      = item.OCOMDEC_GenInd;
                costo           = item.OCOMDEC_Costo;
                cantidad        = item.OCOMDEC_Cantidad;
                pu              = item.OCOMDEC_Pu;
                subtotal        = item.OCOMDEC_Subtotal;
                descuento       = item.OCOMDEC_Descuento;
                igv             = item.OCOMDEC_Igv;
                total           = item.OCOMDEC_Total;
                pu_conigv              = item.OCOMDEC_Pu_ConIgv;
                subtotal_conigv        = item.OCOMDEC_Subtotal_ConIgv;
                   
                descuento_conigv       = item.OCOMDEC_Descuento_ConIgv; 

                if(j%2==0){
                    clase="itemParTabla";
                }else{
                    clase="itemImparTabla";
                }
                fila = '<tr class="'+clase+'">';
                fila +='<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
                fila +='<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
                fila +='</a></strong></font></div></td>';
                fila += '<td width="4%"><div align="center">'+j+'</div></td>';
                fila += '<td width="10%"><div align="center">';
                fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codigo_usuario;
                fila += '<input type="hidden" class="cajaGeneral" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
                fila+= '<input type="hidden" name="prodobservacion['+n+']" id="prodobservacion_'+n+'" value="">';
                fila+= '<input type="hidden" class="cajaMinima" name="flagGenIndDet['+n+']" id="flagGenIndDet['+n+']" value="'+flagGenInd+'">';
                fila += '</div></td>';
                fila += '<td><div align="left"><img src="'+base_url+'images/ver_detalle.png" style="cursor:pointer;margin-right: 5px;" onclick="llenarObservacion('+n+')"><input type="text" class="cajaGeneral" size="73" style="width:369px" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
                fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad['+n+']" id="prodcantidad['+n+']" style="text-align:right" value="'+cantidad+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad;
            
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" name="prodpu_conigv['+n+']" id="prodpu_conigv['+n+']" value="'+parseFloat(pu_conigv).format(false)+'" size="5" maxlength="10" class="cajaGeneral" onblur="modifica_pu_conigv('+n+');"></div></td>';
                fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu['+n+']" id="prodpu['+n+']" value="'+parseFloat(pu).format(false)+'" onblur="modifica_pu('+n+');" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';                  
                
                fila += '<td width="6%"><input type="text" style="text-align:right" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio['+n+']" id="prodprecio['+n+']" value="'+parseFloat(subtotal).format(false)+'" readonly="readonly"></div></td>';
                fila += '<td width="6%" style="display:none;"><div align="center">';
                fila += '<input type="hidden" name="proddescuento100['+n+']" style="text-align:right" id="proddescuento100['+n+']" value="'+descuento100+'">';
                fila += '<input type="hidden" size="5" maxlength="10" class="cajaGeneral" name="proddescuento['+n+']" id="proddescuento['+n+']" value="'+descuento+'" onblur="calcula_importe2('+n+');calcula_totales();">';
 
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" value="'+parseFloat(igv).format(false)+'" id="prodigv['+n+']" readonly></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila +='<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
                fila +='<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
                fila += '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv100+'">';
                fila+= '<input type="hidden" class="cajaPequena2" name="prodcosto['+n+']" id="prodcosto['+n+']" value="'+costo+'" readonly="readonly">';
                fila+= '<input type="hidden" class="cajaPequena2" name="prodventa['+n+']" id="prodventa['+n+']" value="0" readonly="readonly">';                  
                fila += '<input type="text" style="text-align:right" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="'+parseFloat(total).format(false)+'" readonly="readonly" value="0">';
                fila += '</div></td>';
                fila += '</tr>';
                $("#tblDetalleOcompra").append(fila);
                
            }
               

            $('#moneda').val(moneda);
  
            n++;      
        })
        
                calcula_totales();
       
    });
}

function agregar_todopresupuesto(guia,tipo_oper){
    
    descuento100  =  $("#descuento").val();
    igv100        = $("#igv").val();    
    tipo_docu='F';
    url = base_url+"index.php/ventas/presupuesto/obtener_detalle_presupuesto/"+tipo_oper+"/"+tipo_docu+"/"+guia;
    n = document.getElementById('tblDetalleOcompra').rows.length;
    $.getJSON(url,function(data){
        limpiar_datos();
        $.each(data,function(i,item){
            moneda          = item.MONED_Codigo;
            formapago       = item.FORPAP_Codigo;
            serie           = item.PRESUC_Serie;
            numero          = item.PRESUC_Numero;
            codigo_usuario  = item.PRESUC_CodigoUsuario;
            
            if(item.PRESDEP_Codigo!=''){
                j=n+1
                producto                = item.PROD_Codigo;
                codproducto             = item.PROD_CodigoInterno;
                unidad_medida           = item.UNDMED_Codigo;
                nombre_unidad           = item.UNDMED_Simbolo;
                nombre_producto         = item.PROD_Nombre;
                flagGenInd              = item.PROD_GenericoIndividual;
                costo                   = item.PROD_CostoPromedio;
                cantidad                = item.PRESDEC_Cantidad;
                pu                      = item.PRESDEC_Pu;
                subtotal                = item.PRESDEC_Subtotal;
                descuento               = item.PRESDEC_Descuento;
                igv                     = item.PRESDEC_Igv;
                total                   = item.PRESDEC_Total;
                pu_conigv               = item.PRESDEC_Pu_ConIgv;
                subtotal_conigv         = item.PRESDEC_Subtotal_ConIgv;
                descuento_conigv        = item.PRESDEC_Descuento_ConIgv;    

                if(j%2==0){
                    clase="itemParTabla";
                }else{
                    clase="itemImparTabla";
                }
                fila = '<tr class="'+clase+'">';
                fila +='<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
                fila +='<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
                fila +='</a></strong></font></div></td>';
                fila += '<td width="4%"><div align="center">'+j+'</div></td>';
                fila += '<td width="10%"><div align="center">';
                fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
                fila += '<input type="hidden" class="cajaGeneral" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
                fila+= '<input type="hidden" class="cajaMinima" name="flagGenIndDet['+n+']" id="flagGenIndDet['+n+']" value="'+flagGenInd+'">';
                fila += '</div></td>';
                fila += '<td><div align="left"><input type="text" class="cajaGeneral" size="73" style="width:370px" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
                fila += '<td width="10%"><div align="left"><input style="text-align:right" type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad['+n+']" id="prodcantidad['+n+']" value="'+cantidad+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad;
               
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" name="prodpu_conigv['+n+']" id="prodpu_conigv['+n+']" value="'+pu_conigv.format(false)+'" size="5" maxlength="10" class="cajaGeneral" onblur="modifica_pu_conigv('+n+');"></div></td>';
                fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu['+n+']" id="prodpu['+n+']" value="'+pu.format(false)+'" onblur="modifica_pu('+n+');" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';                  
                
                fila += '<td width="6%"><input type="text" style="text-align:right" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio['+n+']" id="prodprecio['+n+']" value="'+subtotal.format(false)+'" readonly="readonly"></div></td>';
                fila += '<td width="6%" style="display:none;"><div align="center">';
                fila += '<input type="hidden" name="proddescuento100['+n+']" id="proddescuento100['+n+']" value="'+descuento100+'">';
                fila += '<input type="hidden" size="5" maxlength="10" class="cajaGeneral" name="proddescuento['+n+']" id="proddescuento['+n+']" value="'+descuento+'" onblur="calcula_importe2('+n+');calcula_totales();">';
 
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" value="'+igv.format(false)+'" id="prodigv['+n+']" readonly></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila +='<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
                fila +='<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
                fila += '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv100+'">';
                fila+= '<input type="hidden" class="cajaPequena2" name="prodcosto['+n+']" id="prodcosto['+n+']" value="'+costo+'" readonly="readonly">';
                fila+= '<input type="hidden" class="cajaPequena2" name="prodventa['+n+']" id="prodventa['+n+']" value="0" readonly="readonly">';                  
                fila += '<input type="text" style="text-align:right" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="'+total.format(false)+'" readonly="readonly" value="0">';
                fila += '</div></td>';
                fila += '</tr>';
                $("#tblDetalleOcompra").append(fila);
            }
            $('#moneda').val(moneda);
            n++;      
        })
        if(n>=0)
            calcula_totales();
        else
            alert('El presupuesto no tiene elementos.');
        
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

function agregar_todooventa(guia, serie, numero){
 
    var descuento100  =  $("#descuento").val();
    var igv100        = $("#igv").val();
    var url = base_url+"index.php/compras/ocompra/obtener_detalle_ocompra2/"+guia+"/B";
    var n = document.getElementById('tblDetalleOcompra').rows.length;

    var hexcolor = '#'+Math.floor(Math.random()*16777215).toString(16);

    $.getJSON(url,function(data){
        $.each(data,function(i,item) {
            if($("#ov_prod_id_"+item.OCOMDEP_Codigo).length != 0) return;

            /*if(colors[item.]) {
                hexcolor = colors[0];
            }else {
                colors[0] = hexcolor;
            }*/

            var moneda          = item.MONED_Codigo;
            var formapago       = item.FORPAP_Codigo;
            var serie           = item.PRESUC_Serie;
            var numero          = item.OCOMDEC_Numero;
            var codigo_usuario  = item.PROD_CodigoUsuario;
            var codigo_oventa   = item.OCOMP_Codigo;
            var pendiente       = item.OCOMDEC_Pendiente;            
            if(item.OCOMDEP_Codigo!='' && pendiente!=0) {
                var j = n + 1;
                var producto        = item.PROD_Codigo;
                var codproducto     = item.PROD_CodigoInterno;
                var unidad_medida   = item.UNDMED_Codigo;
                var nombre_unidad   = item.UNDMED_Simbolo;
                var nombre_producto = item.PROD_Nombre;
                var flagGenInd      = item.OCOMDEC_GenInd;
                var costo           = item.OCOMDEC_Costo;
                var cantidad        = item.OCOMDEC_Cantidad;
                
                var pu              = item.OCOMDEC_Pu;
                var subtotal        = item.OCOMDEC_Subtotal;
                var descuento       = item.OCOMDEC_Descuento;
                var igv             = item.OCOMDEC_Igv;
                var total           = item.OCOMDEC_Total;
                var pu_conigv              = item.OCOMDEC_Pu_ConIgv;
                var subtotal_conigv        = item.OCOMDEC_Subtotal_ConIgv;
                   
                var descuento_conigv       = item.OCOMDEC_Descuento_ConIgv; 

                if(j%2==0){
                    clase="itemParTabla";
                }else{
                    clase="itemImparTabla";
                }

                var fila = '<tr class="tooltiped '+clase+' det_prod_id_'+item.PROD_Codigo+'" id="ov_prod_id_'+item.OCOMDEP_Codigo+'" data-toggle="tooltip" data-placement="top" title="'+(item.PROYC_Nombre ? "Proyecto : "+item.PROYC_Nombre : ((tipo_oper == 'C' ? 'Cliente : ' : 'Proveedor : ') + item.RazonSocial))+'">';
                fila +='<td width="3%" align="center"><input type="checkbox" name="pedir['+n+']" id="pedir['+n+']" onchange="togglePedir('+n+')" checked/></td>';
                fila += '<td width="4%"><div align="center">'+j+'</div></td>';
                fila += '<td width="10%" style="border-left: 10px solid '+hexcolor+';"><div align="center">';
                fila += '<input type="hidden" class="cajaGeneral prodcodigo" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'"><div>'+codigo_usuario+'</div>';
                fila += '<input type="hidden" class="cajaGeneral" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
                fila+= '<input type="hidden" name="prodobservacion['+n+']" id="prodobservacion_'+n+'" value="'+(item.OCOMDEC_Observacion ? item.OCOMDEC_Observacion : '')+'">';
                fila+= '<input type="hidden" class="cajaMinima" name="flagGenIndDet['+n+']" id="flagGenIndDet['+n+']" value="'+flagGenInd+'">';
                fila += '</div></td>';
                fila += '<td><div align="left"><img src="'+base_url+'images/ver_detalle.png" style="cursor:pointer;margin-right: 5px;" onclick="llenarObservacion('+n+')"><input type="text" class="cajaGeneral" size="73" style="width:355px" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
                fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad['+n+']" id="prodcantidad['+n+']" style="text-align:right" value="'+pendiente+'" onchange="modificar_cantidad('+n+');calcula_cantidad_pendiente(' + n + ')"  onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad;
                fila+= '<input type="hidden" name="pendiente['+n+']" id="pendiente['+n+']" value="'+pendiente+'">'
                fila+= '<input type="hidden" name="cantidareal['+n+']" id="cantidareal['+n+']" value="'+cantidad+'">'
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" name="prodpu_conigv['+n+']" id="prodpu_conigv['+n+']" value="'+parseFloat(pu_conigv).format(false)+'" size="5" maxlength="10" class="cajaGeneral" onblur="modifica_pu_conigv('+n+');"></div></td>';
                fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" size="5" maxlength="10" class="cajaGeneral pu" name="prodpu['+n+']" id="prodpu['+n+']" value="'+parseFloat(pu).format(false)+'" onblur="modifica_pu('+n+');" onkeypress="return numbersonly(this,event,\'.\');" onchange="igualarPrecioUnitario()"></div></td>';                  
                
                fila += '<td width="6%"><input type="text" style="text-align:right" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio['+n+']" id="prodprecio['+n+']" value="'+parseFloat(subtotal).format(false)+'" readonly="readonly"></div></td>';
                fila += '<td width="6%" style="display:none;"><div align="center">';
                fila += '<input type="hidden" name="proddescuento100['+n+']" style="text-align:right" id="proddescuento100['+n+']" value="'+descuento100+'">';
                fila += '<input type="hidden" size="5" maxlength="10" class="cajaGeneral" name="proddescuento['+n+']" id="proddescuento['+n+']" value="'+descuento+'" onblur="calcula_importe2('+n+');calcula_totales();">';
 
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input style="text-align:right" type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" value="'+parseFloat(igv).format(false)+'" id="prodigv['+n+']" readonly></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila +='<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
                fila +='<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
                fila += '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv100+'">';
                fila+= '<input type="hidden" class="cajaPequena2" name="prodcosto['+n+']" id="prodcosto['+n+']" value="'+costo+'" readonly="readonly">';
                fila += '<input type="hidden" class="cajaPequena2" name="oventacod['+n+']" id="oventacod['+n+']" value="'+item.OCOMDEP_Codigo+'" readonly="readonly">';
                fila+= '<input type="hidden" class="cajaPequena2" name="prodventa['+n+']" id="prodventa['+n+']" value="0" readonly="readonly">';                  
                fila += '<input type="text" style="text-align:right" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="'+parseFloat(total).format(false)+'" readonly="readonly" value="0">';
                fila += '</div></td>';
                fila += '</tr>';

                $("#tblDetalleOcompra").append(fila);

                
                n++; 
                //$(".det_prod_id_"+producto).find('.pu').focus();
            };

               

            $('#moneda').val(moneda);
            $('#ordencompra').val(codigo_oventa);    
        });
        
                calcula_totales();

                $(".tooltiped").tooltip();
       
    });
}

function igualarPrecioUnitario() {
    if(tipo_oper == "V") return;

    var elm = $(event.target),
        currentRow = elm.parents("tr");

    $.each($(".det_prod_id_"+currentRow.find(".prodcodigo").val()), function(index, el) {
        var el = $(el);

        if(el.find('.pu').val() != elm.val()) {
            el.find('.pu').val(elm.val());
            el.find(".pu").focus().blur();
        }
    });
}

function modificar_cantidad(n) {
    a="prodcantidad["+n+"]";
    b="pendiente["+n+"]";
    d="detaccion["+n+"]";
    
    var id = document.getElementById(d).value;

    if(id=='n'){
        var cantidad= document.getElementById(a).value;
        document.getElementById(b).value=cantidad;
    }else{
        c="cantreal["+n+"]";
        var cantidadElm = document.getElementById(a);
        cantidad= cantidadElm.value;
        var pendiente = document.getElementById(b).value;
        var cantreal = document.getElementById(c).value;
        cantsaliente=(cantreal-pendiente);

        
        if(parseInt(pendiente) != parseInt(cantreal)){

            if(parseInt(cantidad) < parseInt(cantsaliente)){
                alert("la cantidad no puede ser inferior a "+cantsaliente+", por que ya hay  "+cantsaliente+" cantidades solicitadas.");
                cantidadElm.value = event.target.defaultValue;  
            }

        }else{
            document.getElementById(b).value=cantidad;
            document.getElementById(c).value=cantidad;
        }
    }
}
function calcula_cantidad_pendiente(n){
  ocodigo=$("#ordencompra").val();
  a="prodcodigo["+n+"]";
  b="prodcantidad["+n+"]";
  prod=document.getElementById(a).value;
  cant=document.getElementById(b).value;
  //alert("ocodigo"+ocodigo+" "+"producto"+prod+" "+"cantidad "+ cant);

    url = base_url+"index.php/compras/ocompra/calcula_ocantidad_pendiente/"+ocodigo+"/"+prod+"/"+cant;
    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
    })
    .done(function(data) {

        console.log(data.estado);
      if (data.estado==1) {
         $("#grabarOcompra").show();
      }
      else{
        alert("la cantidad ingresado en mayor a la cantidad de O. Compra"+"  "+data.cantidad);
        $("#grabarOcompra").hide();
      }
      
    })   
}
function calcula_cantidad(n){
  ocodigo=$("#ordencompra").val();
  //oventa=$("#ordencompraventa").val();
  a="prodcodigo["+n+"]";
  b="prodcantidad["+n+"]";
  c="pendiente["+n+"]";
  var d = "oventacod[" + n + "]";
  var cantiTag = document.getElementById(b);

  prod=document.getElementById(a).value;
  cant=document.getElementById(b).value;
  pend=document.getElementById(c).value;
  var oventa = document.getElementById(d).value;
  //alert("ocodigo"+oventa+" "+"producto"+prod+" "+"cantidad "+ cant+" "+"pendiente "+ pend);

  //console.log("cantidad : " + cantidad,"pendiente : " + pendiente, "saliente : " + cantsaliente, "real : "+cantreal);

    url = base_url+"index.php/compras/ocompra/cantidad_oregistrada/"+oventa+"/"+prod+"/"+cant+"/"+pend;
    $.ajax({
      url: url,
      type: 'POST',
      dataType : 'json'
    }).done(function(data) {
      if (data.estado == 1) {
         $("#grabarOcompra").show();
      } else {
        //document.getElementById(b).value = document.getElementById(b).defaultValue;
        cantiTag.value = cantiTag.defaultValue;
        alert("la cantidad ingresado es mayor a la cantidad de la OC. Maximo : " + data.cantidad);
        $("#grabarOcompra").hide();
      }
    });
    
}

function llenarObservacion(indice) {
    var observacionElm = $("#prodobservacion_"+indice),
        modalElm = $("#descripcion-modal");

    
        modalElm.find("#descripcion-producto").val(observacionElm.val());
        modalElm.find('#save').data('currentIndice', indice);
    
        modalElm.modal();
}

function guardarDescripcion() {
    var modalElm = $("#descripcion-modal"),
        btnSave = $(event.target);

        $("#prodobservacion_"+btnSave.data('currentIndice')).val(modalElm.find("#descripcion-producto").val());

        modalElm.modal('hide');
}

function verificarProductoDetalle(codigoProducto,codigoAlmacen){
        n = document.getElementById('tblDetalleOcompra').rows.length;   
        isEncuentra=false;
        if(n!=0){
            for(x=0;x<n;x++){
                d="detaccion["+x+"]";
                accionDetalle=document.getElementById(d).value;
                if(accionDetalle!="e"){
                    /***verificamos si existe el mismo producto y no lo agregamos**/
                    a="almacenProducto["+x+"]";
                    c="prodcodigo["+x+"]";
                    almacenProducto=document.getElementById(a).value;
                    codProducto=document.getElementById(c).value;
                    if(codProducto==codigoProducto){
                    //if(codProducto==codigoProducto && almacenProducto==codigoAlmacen){
                        isEncuentra=true;   
                        break;
                    }
                }
            }
        }
        return isEncuentra;
    }


function togglePedir(indice) {
    var pedir = document.getElementById("pedir["+indice+"]").checked;

    document.getElementById("detaccion["+indice+"]").value = pedir ? 'n' : 'EE';

    calcula_totales();
}

function searchFlete() {
    var alert = $("<div>", {
        class : "toast fuente8",
        css : {
            padding : "5px",
            margin : "5px",
            width : "230px"
        },
        html : '<img src="' + base_url + 'images/loading.gif"  style="margin-right: 5px;" />'+
                '<b>Buscando flete ...</b>'
    });

    $("#toasts").append(alert);

    var fleteAmount = 0;
    var totalAmount = 0;
    var productsList = [];

    $.each($("#tblDetalleOcompra tr"), function(i, row) {
        var descripcionTag = document.getElementById("proddescri[" + i + "]");
        var unidadTag = document.getElementById("produnidad[" + i + "]");
        var accionTag = document.getElementById("detaccion[" + i + "]");
        
        var idDetalleTag = document.getElementById("detacodi[" + i + "]");
        var cantidadDetalleTag = document.getElementById("prodcantidad[" + i + "]");
        var importeDetalleTag = document.getElementById("prodimporte[" + i + "]");

        if(unidadTag.value == 0 && accionTag.value != "e" && /flete/.test(descripcionTag.value.toLowerCase())) {
            fleteAmount += parseFloat(importeDetalleTag.value);
        }else {
            if(accionTag.value != "e") totalAmount += parseFloat(importeDetalleTag.value);
            
            productsList[i] = {
                codigo : idDetalleTag.value,
                importe : parseFloat(importeDetalleTag.value),
                cantidad : parseFloat(cantidadDetalleTag.value),
                accion : accionTag.value
            };
        }
    });

    if(fleteAmount > 0) {
        alert.find('b').text('Calculando monto individual de flete ...');
        $.each(productsList, function(i, product) {
            if(product.accion != "e") {
                var percent = product.importe / totalAmount;

                var currentRow = $("#tblDetalleOcompra tr");
                var tdOnRow = $(currentRow[i]).find('td');

                $(tdOnRow[0]).append('<input type="hidden" name="flete[' + i + ']" value="' + ((fleteAmount * percent) / product.cantidad) + '">');
            }
        });
    }

    alert.find('b').text("Guardando datos ...");

    //throw new Error("mal mal muy mal :P");
}