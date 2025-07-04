<?php
$nombre_persona = $this->session->userdata('nombre_persona');
$persona = $this->session->userdata('persona');
$usuario = $this->session->userdata('usuario');
$url = base_url() . "index.php";
if (empty($persona))
    header("location:$url");
    
?>
<html>
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js?=<?=JS;?>"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.17.custom.min.js?=<?=JS;?>"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js?=<?=JS;?>"></script>
    <script src="<?php echo base_url(); ?>js/jquery.columns.min.js?=<?=JS;?>"></script>

    <!--<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js?=<?=JS;?>"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js?=<?=JS;?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css?=<?=CSS;?>" media="screen"/>-->

    <link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
    <script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>

    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js?=<?=JS;?>"></script>
    <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.js?=<?=JS;?>"></script>

    <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.css?=<?=CSS;?>" rel="stylesheet">
    <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap-theme.css?=<?=CSS;?>" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ventas/notacredito.js?=<?=JS;?>"></script>

    <script type="text/javascript">
        $(document).ready(function () { <?php
            if ($tipo_oper == 'V'){
                switch ($tipo_docu) {
                    case 'F': ?>
                        setLimite(<?php echo VENTAS_FACTURA; ?>); <?php
                        break;
                    case 'B': ?>
                        setLimite(<?php echo VENTAS_BOLETA; ?>); <?php
                        break;
                    case 'N': ?>
                        setLimite(<?php echo VENTAS_COMPROBANTE; ?>); <?php
                        break;
                    default:
                        break;
                }
            }
            else
                if ($tipo_oper == 'C') {
                    switch ($tipo_docu) {
                        case 'F': ?>
                            setLimite(<?php echo COMPRAS_FACTURA; ?>); <?php
                            break;
                        case 'B': ?>
                            setLimite(<?php echo COMPRAS_BOLETA; ?>); <?php
                            break;
                        default:
                            break;
                    }
                } ?>
                
            /**dialogo series asosicadas**/
            $("#dialogSeriesAsociadas").dialog({
                resizable: false,
                height: "auto",
                width: 400,
                autoOpen: false,
                show: {
                  effect: "blind",
                  duration: 500
                },
                hide: {
                  effect: "blind",
                  duration: 500
                }
              });
            /**fin **/

            /**dialogo series asosicadas**/
            $("#dialogoSeleccionarALmacenProducto").dialog({
                resizable: false,
                height: "auto",
                width: 400,
                autoOpen: false,
                show: {
                  effect: "blind",
                  duration: 500
                },
                hide: {
                  effect: "blind",
                  duration: 500
                },
                buttons: {
                    "Aceptar": function() {
                        grabarSeleccionarAlmacen();
                    },
                    Cancel: function() {
                      $(this).dialog( "close" );
                    }
                  }
              });
            /**fin **/
            /***verificacion de si es editar y esta relacionada con otras guias **/
            <?php   if(count($listaGuiaremAsociados)>0){  ?>
            document.getElementById("buscar_producto").readOnly = true;
            $("#idDivAgregarProducto").hide(200);
            <?php } ?>
            /***fin de realizar verificacion**/
            
            /**ejecutar mostrar orden de compra vista si existe**/
            <?php if($ordencompra!=0 &&  trim($ordencompra)!="" && $ordencompra!=null){   ?>
            mostrarOdenCompraVista(<?php echo $ordencompra.",".$serieOC.",".$numeroOC.",". $valorOC; ?>);
            <?php } ?>
            /**no mostrar**/
            /**ejecutar mostrar PRESUPUESTO vista si existe**/
            <?php if($presupuesto_codigo!=0 &&  trim($presupuesto_codigo)!="" && $presupuesto_codigo!=null){   ?>
            mostrarPresupuestoVista(<?php echo $presupuesto_codigo.",'".$seriePre."',".$numeroPre.",'". $tipo_oper."'"; ?>);7
            <?php } ?>
            /**no mostrar**/
            
            if ($('#tdcDolar').val() == '') {
                alert("Antes de registrar comprobantes debe ingresar Tipo de Cambio");
                top.location = "<?php echo base_url(); ?>index.php/index/inicio";
            }

            base_url = $("#base_url").val();
            tipo_oper = $("#tipo_oper").val();
            almacen = $("#cboCompania").val();

            $("a#linkVerCliente, a#linkSelecCliente, a#linkVerProveedor, a#linkSelecProveedor").fancybox({
                'width': 800,
                'height': 550,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'

            });

            $(" #linkSelecProducto").fancybox({
                'width': 800,
                'height': 500,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'

            });

            $("a#linkVerProducto").fancybox({
                'width': 800,
                'height': 650,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': true,
                'type': 'iframe'
            });

            $("#linkVerImpresion").fancybox({
                'width': 300,
                'height': 450,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': true
            });

            $(".verDocuRefe").click(function(){
                tipoMoneda = $("#moneda").val();
                almacen = $("#almacen").val();
                    if (tipo_oper == 'V') {
                        if ($('#cliente').val() == '') {
                            alert('Debe seleccionar el cliente.');
                            $('#nombre_cliente').focus();
                            return false;
                        } else {
                            if ($(".verDocuRefe::checked").val() == 'G')
                                baseurl = base_url + 'index.php/almacen/guiarem/ventana_muestra_guiarem/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/F/' + almacen + '/G/'+tipoMoneda;
                            else if ($('.verDocuRefe::checked').val() == 'P')
                                baseurl = base_url + 'index.php/ventas/presupuesto/ventana_muestra_presupuestoCom/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/<?php echo $tipo_docu; ?>/' + almacen + '/P';
                            else if ($('.verDocuRefe::checked').val() == 'O')
                                baseurl = base_url + 'index.php/compras/ocompra/ventana_muestra_ocompraCom/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/<?php echo $tipo_docu; ?>/' + almacen + '/O';
                            else if ($('.verDocuRefe::checked').val() == 'R')
                                baseurl = base_url + 'index.php/ventas/comprobante/ventana_muestra_recurrentes/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/<?php echo $tipo_docu; ?>/' + almacen + '/R';
                            else if ($('.verDocuRefe::checked').val() == 'F')
                                baseurl = base_url + 'index.php/ventas/notacredito/ventana_muestra_notadecredito/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/F/' + almacen + '/F';
                         
                            $('.verDocuRefe::checked').attr('href', baseurl);
                        }
                    }
                    else {

                        if ($('#proveedor').val() == '') {
                            alert('Debe seleccionar el proveedor.');
                            $('#nombre_proveedor').focus();
                            return false;
                        } else {
                            if ($('.verDocuRefe::checked').val() == 'G') {
                                baseurl = base_url + 'index.php/almacen/guiarem/ventana_muestra_guiarem/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/F/' + almacen + '/G/'+tipoMoneda;
                            }
                            else if ($('.verDocuRefe::checked').val() == 'P') {
                                if (tipo_oper == 'V')
                                    baseurl = base_url + 'index.php/ventas/presupuesto/ventana_muestra_presupuestoCom/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/<?php echo $tipo_docu; ?>/' + almacen + '/P';
                                else
                                    baseurl = base_url + 'index.php/compras/presupuesto/ventana_muestra_presupuestoCom/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/<?php echo $tipo_docu; ?>/' + almacen + '/P';
                            }
                            else if ($('.verDocuRefe::checked').val() == 'O') {
                                baseurl = base_url + 'index.php/compras/ocompra/ventana_muestra_ocompraCom/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/<?php echo $tipo_docu; ?>/' + almacen + '/O';
                            }
                            else if ($('.verDocuRefe::checked').val() == 'R') {
                                baseurl = base_url + 'index.php/ventas/comprobante/ventana_muestra_recurrentes/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/<?php echo $tipo_docu; ?>/' + almacen + '/R';
                            }
                            else if ($('.verDocuRefe::checked').val() == 'F')
                                baseurl = base_url + 'index.php/ventas/notacredito/ventana_muestra_notadecredito/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/F/' + almacen + '/F';
                            //alert(baseurl);

                            $('.verDocuRefe::checked').attr('href', baseurl);
                        }
                    }
            });

        });

    $(function () {
        // BUSQUEDA POR RAZON SOCIAL O CODIGO
        $("#nombre_cliente").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete/",
                        type: "POST",
                        data: {term: $("#nombre_cliente").val()},
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },

                select: function (event, ui) {
                    $("#nombre_cliente").val(ui.item.nombre);
                    $("#buscar_cliente").val(ui.item.ruc);
                    $("#cliente").val(ui.item.codigo);
                    $("#ruc_cliente").val(ui.item.ruc);
                    $("#codigoEmpresa").val(ui.item.codigoEmpresa);
                    $("#TipCli").val(ui.item.TIPCLIP_Codigo);
                    $("#cboVendedor > option[value="+ ui.item.vendedor +"]").attr("selected",true) // Selecciona el vendedor asociado al cliente - Rawil

                    if ( ui.item.contactos != null ){
                        var size = ui.item.contactos.length;
                        $('#contacto option').remove();

                        for (x = 0; x < size; x++){
                            $('#contacto').append("<option value='"+ui.item.contactos[x].PERSP_Codigo+"'>"+ui.item.contactos[x].PERSC_Nombre+"</option>");
                        }
                    }
                    get_obra(ui.item.codigo);
                },
                minLength: 2
        });

        // BUSQUEDA POR RUC
        $("#buscar_cliente").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete_ruc/",
                        type: "POST",
                        data: {
                            term: $("#buscar_cliente").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.length == 0)
                                $(".input-group-btn").css("opacity",1);
                            else{
                                $(".input-group-btn").css("opacity",0);
                                response(data);
                            }
                        }
                    });
                },
                select: function (event, ui) {
                    $("#nombre_cliente").val(ui.item.nombre);
                    $("#buscar_cliente").val(ui.item.ruc);
                    $("#cliente").val(ui.item.codigo);
                    $("#ruc_cliente").val(ui.item.ruc);
                    $("#codigoEmpresa").val(ui.item.codigoEmpresa);
                    $("#TipCli").val(ui.item.TIPCLIP_Codigo); // Codigo del cliente para el precio del producto - Rawil
                    $("#cboVendedor > option[value="+ ui.item.vendedor +"]").attr("selected",true) // Selecciona el vendedor asociado al cliente - Rawil

                    if ( ui.item.contactos != null ){
                        var size = ui.item.contactos.length;
                        $('#contacto option').remove();

                        for (x = 0; x < size; x++){
                            $('#contacto').append("<option value='"+ui.item.contactos[x].PERSP_Codigo+"'>"+ui.item.contactos[x].PERSC_Nombre+"</option>");
                        }
                    }
                    get_obra(ui.item.codigo);
                    $("#addItems").click();
                },
                minLength: 2
        });
        
        $("#buscar_cliente").change(function(){
                if ($("#buscar_cliente").val().length == 0)
                    $(".input-group-btn").css("opacity",0);
        });

        // BUSQUEDA POR RAZON SOCIAL PROVEEDOR
        $("#nombre_proveedor").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocomplete/",
                        type: "POST",
                        data: { term: $("#nombre_proveedor").val() },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    $("#buscar_proveedor").val(ui.item.ruc);
                    $("#nombre_proveedor").val(ui.item.nombre);
                    $("#proveedor").val(ui.item.codigo);
                    $("#ruc_proveedor").val(ui.item.ruc);
                    $("#codigoEmpresa").val(ui.item.codigoEmpresa);
                },
                minLength: 2
        });

        // BUSQUEDA POR RUC PROVEEDOR
        $("#buscar_proveedor").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocomplete_ruc/",
                        type: "POST",
                        data: {
                            term: $("#buscar_proveedor").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.length == 0)
                                $(".input-group-btn").css("opacity",1);
                            else{
                                $(".input-group-btn").css("opacity",0);
                                response(data);
                            }
                        }
                    });
                },
                select: function (event, ui) {
                    $("#buscar_proveedor").val(ui.item.ruc);
                    $("#nombre_proveedor").val(ui.item.nombre);
                    $("#proveedor").val(ui.item.codigo);
                    $("#ruc_proveedor").val(ui.item.ruc);
                    $("#codigoEmpresa").val(ui.item.codigoEmpresa);

                    $("#addItems").click();
                },
                minLength:2 
        });

        $('#close').click(function(){
            $('#popup').fadeOut('slow');
            $('.popup-overlay').fadeOut('slow');
            return false;
        });
    });

    $("#linkVerproyectoss").click(function () {
            if (tipo_oper == 'V')
                var url = base_url + "index.php/maestros/proyecto/JSON_listar_proyectos/" +$("#cliente").val();
            $("#lista_proyecto ul").html('');
            $("#lista_proyecto").slideToggle("fast", function () {
        
        $.getJSON(url, function (data) {
            $.each(data, function (i, item) {
                fila = '';
                    fila += '<li><a href="javascript:;">';
                    if (item.nombre != '')
                        fila += ' ' + item.nombre;
                    if (item.descripcion != '')
                        fila += ' - ' + item.descripcion;
                    fila += '</a></li>';
              $("#lista_proyecto  ul").append(fila);
            });
        });
    });
    }); 
        /*--------------------------------------------------*/

        function seleccionar_cliente(codigo, ruc, razon_social) {
            $("#cliente").val(codigo);
            $("#buscar_cliente").val(ruc);
            $("#nombre_cliente").val(razon_social);
            get_obra(codigo);
        }
        function seleccionar_proveedor(codigo, ruc, razon_social) {
            $("#proveedor").val(codigo);
            $("#buscar_proveedor").val(ruc);
            $("#nombre_proveedor").val(razon_social);
        }

        function seleccionar_producto(producto, cod_interno, familia, stock, costo, flagGenInd,codigoAlmacenProducto) {
            /**si el producto tiene almacen : es que no esta inventariado en ese almacen , se le asigna el almacen general de cabecera**/
            if(codigoAlmacenProducto==0){
                codigoAlmacenProducto=$("#almacen").val();
             }
            /**fin de asignacion**/
            /**verificamos si se e3ncuentra en la lista**/
            isEncuentra=verificarProductoDetalle(producto,codigoAlmacenProducto);
            if(!isEncuentra){
                $("#codproducto").val(cod_interno);
                $("#producto").val(producto);
                $("#cantidad").focus();
                $("#stock").val(stock);
                $("#costo").val(costo);
                $("#flagGenInd").val(flagGenInd);
                $("#almacenProducto").val(codigoAlmacenProducto);
                listar_unidad_medida_producto(producto);
            }else{
                $("#buscar_producto").val("");
                $("#producto").val("");
                $("#codproducto").val("");
                $("#costo").val("");
                $("#stock").val("");
                $("#flagGenInd").val("");
                $("#nombre_producto").val("");
                $("#almacenProducto").val("");
                $("#buscar_producto").val("");
                $("#buscar_producto").focus();
                alert("El producto ya se encuentra ingresado en la lista de detalles.");
          }

        }

        function seleccionar_documento_detalle(producto, codproducto, nombre_producto, cantidad, flagBS, flagGenInd, unidad_medida, nombre_medida, precio_conigv, precio_sinigv, precio, igv, importe, stock, costo) {
            agregar_fila(producto, codproducto, nombre_producto, cantidad, flagBS, flagGenInd, unidad_medida, nombre_medida, precio_conigv, precio_sinigv, precio, igv, importe, stock, costo);
        }

        function seleccionarOdenCompra(oCompra, serie, numero, valor)
        {
            mostrarOdenCompraVista(oCompra,serie, numero, valor);
            //obtener_detalle_ocompra(oCompra);
            obtener_comprobantes_temproductos(oCompra,'ocompras');

            /**quitamos lista de guiarem **/
            listadoGuiaremEstadoDeseleccionado();
            verificarOcultarListadoGuiaremAsociado();
        }
        

        function mostrarOdenCompraVista(oCompra,serie, numero, valor){
            if(valor == 1){
                serienumero = "Numero de Orden Compra. :" + serie + " - " + numero;
            }else{
                serienumero = "Numero de Orden Venta. :" + serie + " - " + numero;
            }
            $("#serieguiaverOC").html(serienumero);
            $("#serieguiaverOC").show(200);
            $("#serieguiaverPre").hide(200);
            $("#serieguiaver").hide(200);
            $("#serieguiaverRecu").hide(200);
            $('#ordencompra').val(oCompra);

            codigoPresupuesto=$("#presupuesto_codigo").val();
            if(codigoPresupuesto!="" && codigoPresupuesto!=0){
                    modificarTipoSeleccionPrersupuesto(codigoPresupuesto,0);
            }
            $("#presupuesto_codigo").val("");
        }

        function seleccionar_guiarem(guia, serieguia, numeroguia) {
            //realizado=agregar_todo(guia);
            realizado = verificar_agregar();
            obtener_comprobantes_temproductos(guia,'guiarem');

            if(realizado!=false){
                $("#serieguiaverPre").hide(200);
                $("#serieguiaverOC").hide(200);
                $("#serieguiaverRecu").hide(200);
                $('#ordencompra').val('');
            }

            codigoPresupuesto=$("#presupuesto_codigo").val();
            if(codigoPresupuesto!="" && codigoPresupuesto!=0){
                    modificarTipoSeleccionPrersupuesto(codigoPresupuesto,0);
            }
            $("#presupuesto_codigo").val("");
            
        }

        function seleccionar_presupuesto(guia, serieguia, numeroguia) {
            isRealizado=modificarTipoSeleccionPrersupuesto(guia,1);
            if(isRealizado){
                tipo_oper = $("#tipo_oper").val();
                //agregar_todopresupuesto(guia, tipo_oper);
                obtener_comprobantes_temproductos(guia,'presupuesto');
                mostrarPresupuestoVista(guia, serieguia, numeroguia,tipo_oper);
                /**quitamos lista de guiarem **/
                listadoGuiaremEstadoDeseleccionado();
                verificarOcultarListadoGuiaremAsociado();
            }
        }

        function mostrarPresupuestoVista(guia, serieguia, numeroguia,tipo_oper){
            if(tipo_oper=="V")
                serienumero = "Numero de PRESUPUESTO :" + serieguia + " - " + numeroguia;
            else
                serienumero = "Numero de COTIZACIÓN :" + serieguia + " - " + numeroguia;
                
            $("#serieguiaverPre").html(serienumero);
            $("#serieguiaverPre").show(200);
            $("#serieguiaver").hide(200);
            $("#serieguiaverOC").hide(200);
            $("#serieguiaverRecu").hide(200);
            $("#docurefe_codigo").val('');
            $("#dRef").val('');
            $('#ordencompra').val('');
            $("#numero_ref").val('');
            $("#presupuesto_codigo").val(guia);
        }
        
        function seleccionar_comprobante_recu(guia, serieguia, numeroguia) {
            //agregar_todo_recu(guia);
            obtener_comprobantes_temproductos(guia,'comprobantes');
            serienumero = "N de Comprobante: <br>" + serieguia + " - " + numeroguia;
            $("#serieguiaverRecu").html('<span style="font-size:15px" >Doc. Recurrente: <br>' + serienumero + '</span>');
            $("#serieguiaverRecu").show(200);
            $("#serieguiaver").hide(200);
            $("#serieguiaverRecuFlecha").show(400);
            $("#serieguiaverPre").hide(200);
            $("#serieguiaverOC").hide(200);
            $("#numero_ref").val('');
            $("#dRef").val('');
            $('#ordencompra').val('');
            $("#docurefe_codigo").val('');

            codigoPresupuesto=$("#presupuesto_codigo").val();
            if(codigoPresupuesto!="" && codigoPresupuesto!=0){
                modificarTipoSeleccionPrersupuesto(codigoPresupuesto,0);
            }
            $("#presupuesto_codigo").val("");

            
            /**quitamos lista de guiarem **/
            listadoGuiaremEstadoDeseleccionado();
            verificarOcultarListadoGuiaremAsociado();
        }

        function valida() {
            if (document.forms[0].seriep.value.length > 2) {
                document.forms[0].presupuesto.focus();
                return false;
            }
            else
                return true;

        }
        function tdc_cambiar() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/maestros/tipocambio/buscar_json",
                type: "POST",
                data: {
                    fecha: $('#fecha').val()
                },
                success: function (data) {
                    if (data == 0) {
                        alert('error Tipo de cambio en esta fecha no ingresada');
                        $('#fecha').val('<?php echo date('d/m/Y');?>');
                        tdc_cambiar();
                    } else {
                        $('#tdc').val(data);
                    }
                }
            });
        }
        // End -->

    function cambiarAlmacenProductoCodigo(almacen){
        
        posicionSeleccionado=$("#posicionSeleccionadaSerie").val();
        if(posicionSeleccionado!=null && posicionSeleccionado!=''){
        a="almacenProducto["+posicionSeleccionado+"]";
        document.getElementById(a).value=almacen;

        }
    }
    /**seleccionamos un almacen para el producto agregaod po o.vc cotizacioon, recurrentes**/
    function mostrarPopUpSeleccionarAlmacen(posicionSeleccionado, isView){
        var isView = isView == undefined ? true : isView;
        var a="almacenProducto["+posicionSeleccionado+"]";
        var b="prodcodigo["+posicionSeleccionado+"]";
        $("#posicionSeleccionadaSerie").val(posicionSeleccionado);
        var almacenProducto=document.getElementById(a).value;
        var codigoProducto=document.getElementById(b).value;
        var url="<?php echo base_url(); ?>index.php/almacen/producto/buscarAlmacenProducto/"+codigoProducto;

        var n = document.getElementById('idTblAlmacen').rows.length;
        if(n!=null && n!='' && n>1){
            for(var x=1;x<n;x++){
                document.getElementById("idTblAlmacen").deleteRow(1);
            }
        }
        
        $.ajax({
                url: url,
                dataType: 'json',
                //async: false,
                success: function (data) {
                    $.each(data, function (i, item) {
                        var codigoAlmacen=item.codigo;
                        var nombreAlmacen=item.nombreAlmacen;
                        var stock=item.stock;
                        var j=i+1;
                        var fila="<tr id='idTr_"+j+"' >";
                        fila+="<td>";
                        fila+="<input type='radio' name='almacenListado' id='idRdAlmacen"+j+"' value='"+codigoAlmacen+"'>"; 
                        fila+="</td>";
                        fila+="<td>";
                        fila+="<label for='idRdAlmacen"+j+"' >"+nombreAlmacen+"</label>";   
                        fila+="</td>";
                        fila+="<td>";
                        fila+="<label>"+stock+"</label>";   
                        fila+="</td>";
                        fila+="</tr>";
                        $("#idTblAlmacen").append(fila);

                        if($("#almacen").val() == codigoAlmacen) document.getElementById("prodstock["+posicionSeleccionado+"]").value = stock;
                    });
                    if(isView) $("#dialogoSeleccionarALmacenProducto").dialog("open");
                }
        });
    }

    function grabarSeleccionarAlmacen(){
        almacen=$('input:radio[name=almacenListado]:checked').val();
        if(almacen!=null && almacen!=""){
            cambiarAlmacenProductoCodigo(almacen);
            $("#dialogoSeleccionarALmacenProducto").dialog("close");
        }else{
            alert("Debe de seleccionar un almacen para el producto.");
        }
    }
    function get_obra(codigo) {
        //alert(codigo);
        $.post("<?php echo base_url(); ?>index.php/compras/pedido/obra", {
                        "codigoempre" : codigo
            }, function(data) {
                //alert("hola"+data);
                var c = JSON.parse(data);
                $('#obra').html('');
                $('#obra').append("<option value='0'>::Seleccione::</option>");
                $.each(c,function(i,item){
                    $('#obra').append("<option value='"+item.PROYP_Codigo+"'>"+item.proyecto+"</option>");
                });

                var idProyecto = $("#id-proyecto").val();
                if(idProyecto != "") $("#obra").val(idProyecto).trigger('change');
        });
    }
    </script>

</head>

<body>

<input type="hidden" name="codigoguia" id="codigoguia" value="<?php echo $guia; ?>"/>

<?php

//echo date("Y-m-d H:i:s");
// stylo para ocultar botones combos, etc

$style = "";
if (FORMATO_IMPRESION == 8) {
    $style = "display:none;";

}

?>

<!-- Inicio -->
<input value='<?php echo $compania; ?>' name="compania" type="hidden" id="compania"/>
<input value='<?php echo $sucursal; ?>' name="sucursal" type="hidden" id="sucursal"/>

<input type="hidden" name="idProyecto" id="id-proyecto" value="<?php echo $id_proyecto ?>">

<div id="VentanaTransparente" style="display:none;">
    <div class="overlay_absolute"></div>
    <div id="cargador" style="z-index:2000">
        <table width="100%" height="100%" border="0" class="fuente8">
            <tr valign="middle">
                <td> Por Favor Espere</td>
                <td>
                    <img src="<?php echo base_url(); ?>images/cargando.gif?=<?=IMG;?>" border="0" title="CARGANDO"/>
                    <a href="#" id="hider2"></a>
                </td>
            </tr>
        </table>
    </div>
</div>

<!-- Fin -->

<form id="<?php echo $formulario; ?>" method="post" action="<?php echo $url_action; ?>">
<div id="popup" style="display: none;">
    <div class="content-popup">
        <div class="close">
        <a href="#" id="close">
        <img src="<?=base_url()?>images/delete.gif?=<?=IMG;?>"/></a></div>
        <div>
           <h2>Falta Ingresar inventario</h2>
           <div id="contendio">
           </div>
           <a onclick="ejecutarModal()" target="_blank" href="<?=base_url()?>index.php/almacen/inventario/listar" id="btnInventario">IR A INGRESAR INVENTARIO </a>
           
        </div>
    </div>
</div>
    <div id="zonaContenido" align="center">
        <?php echo validation_errors("<div class='error'>", '</div>'); ?>
        <div id="tituloForm" class="header" style="height: 20px">
            <?php echo $titulo; ?>
            <?php
            if ($tipo_docu != 'N') {
                if ($codigo == '') {
                    ?>
                    <select id="cboTipoDocu" name="cboTipoDocu" class="comboMedio" style="visibility: hidden">
                        <option value="F" <?php if ($tipo_docu == 'F') echo 'selected="selected"'; ?>>FACTURA</option>
                        <option value="B" <?php if ($tipo_docu == 'B') echo 'selected="selected"'; ?>>BOLETA</option>
                    </select>
                <?php
                }else{ ?>
                    <input type="hidden" value="N" id="cboTipoDocu" name="cboTipoDocu"/>
               <?php }
            } else {
                ?>
                <input type="hidden" value="N" id="cboTipoDocu" name="cboTipoDocu"/>
            <?php } ?>
        </div>


        <div id="idDivGuiaRelacion" style="<?php echo (count($listaGuiaremAsociados)>0)?'':'display:none'; ?>">
        <div id="dialogSeriesAsociadas" title="Series Ingresadas">
          <div id="mostrarDetallesSeriesAsociadas"> 
           <div id="detallesSeriesAsociadas"></div>
          </div>
        </div>
        
        <!-- dialogo para mostrarse que sleccionar elñ almacen de un producto -->
        
        <div id="dialogoSeleccionarALmacenProducto" title="Seleccionar Almacen">
          <div id="mostrarDetallesSeleecionarALmacen">  
                <table id="idTblAlmacen" >
                    <tr id="idTr_0">
                        <td></td>
                        <td width="200px" >Descripci&oacute;n</td>
                        <td width="50px">Stock</td>             
                    </tr>
                </table>
          </div>
        </div>
        <!-- fin de dialogo -->
        
         <div id="tituloForm" class="header" style="height: 30px">
         <h3>GUIAS RELACIONADAS</h3>
         </div>
            <table class="fuente8" id="idTableGuiaRelacion">
            <tr id="idTrDetalleRelacion_0" >
                <td></td>
                <td>ITEM</td>
                <td>SERIE</td>
                <td>NUMERO</td>
                <td>BACKGROUND</td>
            </tr>
            <?php if(count($listaGuiaremAsociados)>0){ 
                    foreach ($listaGuiaremAsociados as $indice=>$valorGuiarem){
                            $codigoGuiarem=$valorGuiarem->codigoGuiarem;
                            $serieGuiarem=$valorGuiarem->serie;
                            $numeroGuiarem=$valorGuiarem->numero;
                            $j=$indice+1;
                            $colorGuiar[$codigoGuiarem]="#".dechex(rand(0,10000000));
                            
                ?>
            
        <tr id="idTrDetalleRelacion_<?php echo $j; ?>"> 
         <td> 
         <a href="javascript:void(0);" onclick="deseleccionarGuiaremision(<?php echo $codigoGuiarem; ?>,<?php echo $j; ?>)" title="Deseleccionar Guia de remision"> 
         x 
         </a> 
         </td> 
         <td><?php echo $j; ?></td> 
         <td><?php echo $serieGuiarem; ?></td> 
         <td><?php echo $numeroGuiarem; ?></td> 
         <td><div style="width:10px;height:10px;background-color:<?php echo $colorGuiar[$codigoGuiarem] ?>; border:1px solid black"></div> 
            <input type="hidden" id="codigoGuiaremAsociada[<?php echo $j; ?>]"  name="codigoGuiaremAsociada[<?php echo $j; ?>]" value="<?php echo $codigoGuiarem; ?>" /> 
            <input type="hidden" id="accionAsociacionGuiarem[<?php echo $j; ?>]"  name="accionAsociacionGuiarem[<?php echo $j; ?>]" value="2" />
            <input type="hidden" id="proveedorRelacionGuiarem[<?php echo $j; ?>]"  name="proveedorRelacionGuiarem[<?php echo $j; ?>]" value="<?php echo $proveedor; ?>" />
         </td> 
        
         </tr> 
            <?php }} ?>
            </table>
        </div>
        <div id="frmBusqueda">
            <table class="fuente8" width="100%" cellspacing="0" cellpadding="5" border="0">
                <tr>
                    <!--iNDEX DE FACTURA Y BOTELA-->
                    <td width="8%">Número*</td>
                    <td width="60%" valign="middle">
                        <!--  <input type="hidden" id="numeroAutomatico" name="numeroAutomatico" value="<?php echo $numeroAutomatico; ?>"/>-->
                        <input type="hidden" id="tipo_oper" value="<?php echo $tipo_oper; ?>"/>
                        <input type="hidden" id="guiaremision" value="<?php echo $guiaremision; ?>"/>
                        <input type="hidden" id="posicionSeleccionadaSerie" value="" />
                        
                        <input class="cajaGeneral" name="serie" type="text" id="serie" size="4" maxlength="4" value="<?php echo $serie; ?>"/>&nbsp;
                         
                         <?php if ($tipo_oper == 'V') { ?>
                        <input class="cajaGeneral" name="numero" type="text" id="numero" size="6" maxlength="6" value="<?php echo $numero; ?>"/>
                         
                         <?php }elseif($tipo_oper == 'C'){?>

                         <input class="cajaGeneral" name="numero" type="text" id="numero" size="6" maxlength="6" value="<?php echo $numero; ?>"/>
                         <?php } ?>

                        <?php if ($tipo_oper == 'V') { ?>
                            <a href="javascript:;" id="linkVerSerieNum" <?php if ($codigo != '') echo 'style="display:none"' ?>>
                                <p class="boleta" style="display:none"><?php echo $serie_suger_b . '-'. $numero_suger_b ?></p>
                                <p class="factura" style="display:none"><?php echo $serie_suger_f . '-' . $numero_suger_f ?></p>
                                <p class="comprobante" style="display:none"><?php echo $serie_suger_f . '-' . $numero_suger_f ?></p>
                                <img src="<?php echo base_url(); ?>images/flecha.png?=<?=IMG;?>" border="0" alt="Serie y nÃºmero sugerido" title="Serie y número sugerido"/>
                            </a>
                            
                            <input type="checkbox" name="numeroAutomatico"  id="numeroAutomatico" <?php echo($numeroAutomatico==1)?'checked=true':''; ?> value="1" title="SERIE-NUMERO AUTOMATICO SI SE SELECCIONA">
                        <?php } ?>
                        <label style="margin-left:20px;">IGV</label>
                        <input name="igv" type="text" class="cajaGeneral cajaSoloLectura" id="igv" size="2" maxlength="2" value="<?php echo $igv; ?>" onkeypress="return numbersonly(this,event,'.');" onblur="modifica_igv_total();" readonly="readonly"/> %
                        <!--input type="hidden" name="descuento" id="descuento" value=""/-->
                        <label hidden>
                            <input id="chk-exonera-igv" type="checkbox" <?php if($igv == 0) echo "checked";?>>Exonerar
                        </label>
                        <script>
                            $(document).ready(function () {
                                $("#chk-exonera-igv").change(function(event) {
                                    var isCheck = $(this).attr('checked'),
                                    igv = <?php echo $igv != 0 ? $igv : $igv_default ?>;
                                    $("#igv").val(isCheck ? 0 : igv);
                                }).trigger('change');
                            });
                        </script>
                    </td>
                    <!-- <td width="8%" valign="middle">Presupuesto</td>-->
                    <td width="5%" valign="middle">
                        <?php if ($tipo_oper == 'V') { ?>
                            <!--<label for="P"><img src="<?php echo base_url() ?>images/presupuesto.png?=<?=IMG;?>" class="imgBoton"/></label>-->
                        <?php } else { ?>
                            <!--<label for="P" style="cursor: pointer;" ><img src="<?php echo base_url() ?>images/cotizacion.png?=<?=IMG;?>" class="imgBoton"/></label>-->
                        <?php } ?>
                        <input type="radio" name="referenciar" id="P" value="P" href="javascript:;" class="verDocuRefe" style="display:none;">
                        <div id="serieguiaverPre" name="serieguiaverPre" style="background-color: #cc7700; color:#fff; padding:5px;display:none"></div>
                        <input type="hidden" name="presupuesto_codigo" id="presupuesto_codigo" size="5" value="<?php echo $presupuesto_codigo; ?>"/>
                    </td>

                    <!--<td width="8%" >O. <?php //if ($tipo_oper == 'C') echo 'Compra'; else echo 'Venta'; ?> </td>-->
                    <td width="5%">
                        <?php if ($tipo_oper == 'V') { ?>
                            <!--<label for="O" style="cursor: pointer;"><img src="<?php echo base_url() ?>images/oventa.png?=<?=IMG;?>" class="imgBoton"/></label>-->
                        <?php } else { ?>
                            <!--<label for="O" style="cursor: pointer;"><img src="<?php echo base_url() ?>images/ocompra.png?=<?=IMG;?>" class="imgBoton"/></label>-->
                        <?php } ?>
                        <input type="radio" name="referenciar" id="O" value="O" href="javascript:;" class="verDocuRefe" style="display:none;">
                        <div id="serieguiaverOC" name="serieguiaverOC" style="background-color: #cc7700; color: #fff; padding:5px;display:none"></div>
                        <input type="hidden" name="ordencompra" id="ordencompra" size="5" value="<?php echo $ordencompra; ?>"/>
                    </td>
                    <td width="5%" valign="middle">Fecha</td>
                    <td width="30%" valign="middle"><input name="fecha" type="text" class="cajaGeneral cajaSoloLectura" id="fecha" value="<?php echo $hoy; ?>" size="10" maxlength="10" readonly="readonly" onchange="tdc_cambiar()"/>
                        <img height="16" border="0" width="16" id="Calendario1" name="Calendario1" src="<?php echo base_url(); ?>images/calendario.png?=<?=IMG;?>"/>
                        <script type="text/javascript">
                            Calendar.setup({
                                inputField: "fecha",      // id del campo de texto
                                ifFormat: "%d/%m/%Y",       // formaClienteto de la fecha, cuando se escriba en el campo de texto
                                button: "Calendario1" // el id del botÃ³n que lanzarÃ¡ el calendario
                            });
                        </script>
                    </td>
                     <td width="5%" valign="middle">Fecha de vencimiento</td>
                    <td width="30%" valign="middle">
                        <input type="date" name="fecha_v" value="<?php echo $fecha_v; ?>" id="fecha_v"/>
                        
                    </td>
                </tr>
                <tr>
                    <td><?=($tipo_oper=="V") ? "Cliente *" : "Proveedor *";?></td>
                    <td valign="middle"> <?php
                        if ($tipo_oper == "V") { ?>
                            <input type="hidden" name="cliente" id="cliente" size="5" value="<?php echo $cliente ?>"/>
                            <input placeholder="ruc" name="buscar_cliente" type="text" class="cajaGeneral" id="buscar_cliente" size="10" value="<?php echo $ruc_cliente; ?>" title="Ingrese parte del nombre o el nro. de documento, luego presione ENTER."/>&nbsp;
                            <input type="hidden" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11" onblur="obtener_cliente();" value="<?php echo $ruc_cliente; ?>" onkeypress="return numbersonly(this,event,'.');"/>
                            <input placeholder="razon social" type="text" name="nombre_cliente" class="cajaGeneral" id="nombre_cliente" size="37" maxlength="50" value="<?php echo trim($nombre_cliente, '"'); ?>"/>

                            <!-- Add ingresar precio del cliente - Rawil-->
                            <?php if ( !isset($TIPCLIP_Codigo) ) $TIPCLIP_Codigo = ""; ?>
                            <input type="hidden" name="tempde_TipCli" id="TipCli" value="<?php echo $TIPCLIP_Codigo; ?>">
                            <!-- End add ingresar precio del cliente - Rawil -->
                            <a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_selecciona_cliente/" id="linkSelecCliente"></a> <?php
                        }
                        else { ?>
                            <input type="hidden" name="proveedor" id="proveedor" size="5" value="<?php echo $proveedor ?>"/>
                            <input name="buscar_proveedor" type="text" class="cajaGeneral" id="buscar_proveedor" size="10" placeholder="ruc" value="<?php echo $ruc_proveedor; ?>" title="Ingrese parte del nombre o el nro. de documento, luego presione ENTER."/>&nbsp;
                            <input type="hidden" name="ruc_proveedor" class="cajaGeneral" id="ruc_proveedor" size="10" maxlength="11" onblur="obtener_proveedor();" value="<?php echo $ruc_proveedor; ?>" placeholder="ruc" onkeypress="return numbersonly(this,event,'.');"/>
                            <input type="text" name="nombre_proveedor" class="cajaGeneral cajaSoloLectura" id="nombre_proveedor" size="25" maxlength="50" placeholder="razon social" value="<?php echo trim($nombre_proveedor, '"'); ?>"/>
                            <a href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_selecciona_proveedor/" id="linkSelecProveedor"></a> <?php
                        } ?>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <!--<td valign="middle">Guia remision *</td>-->
                    <td valign="middle">
                        <!--<label for="G" style="cursor: pointer;"><img src="<?php echo base_url() ?>images/gremision.png?=<?=IMG;?>" class="imgBoton"/></label>-->
                        <input type="radio" name="referenciar" id="G" value="G" href="javascript:;" class="verDocuRefe" style="display:none;">
                        <input type="hidden" id="dRef"  name="dRef" value="<?php echo $dRef; ?>" >
                    </td>
                    <!--<td valign="middle">Doc Pago</td>-->
                    
                    <td valign="middle" style="position: relative" >
                        <label for="F" style="cursor: pointer">
                            <img src="<?php echo base_url() ?>images/docpago.png?=<?=IMG;?>" class="imgBoton" id="docRelacionadoF" name="docRelacionadoF"/>
                        </label>
                        <input type="radio" name="referenciar" id="F" value="F" href="javascript:;" class="verDocuRefe" style="display:none;" data-fancybox data-type="iframe">
                        <input type="hidden" id="origenDocumento" value="<?=$ltCompIni;?>" name="origenDocumento"/>
                        <input type="hidden" id="guiaReferente" class="guiaReferente" value="<?=$idCompIni;?>" name="guiaReferente"/>
                        <input type="hidden" id="dRef" name="dRef">
                        <input type="hidden" name="idSerie" id="idSerie" value="<?=$numserref;?>"/>
                        <input type="hidden" name="idNumero" id="idNumero" value="<?=$numdocref;?>"/>
                            <span id="serieguiaverFlecha" class="flecha_izquierda2"></span>
                            <div id="serieguiaver" style="background: #cc7700; color:#fff; padding:5px;">Documento Relacionado:<br><?="$numserref - $numdocref";?></div>
                    </td>
                </tr>
                <tr>
                    <td>Almacen*</td>
                    <td><?php echo $cboAlmacen; ?></td>
                    <td valign="middle">Moneda*</td>
                    <td valign="middle" id="idTdMoneda">
                        <select name="moneda" id="moneda" class="comboPequeno"
                                style="width:150px;"><?php echo $cboMoneda; ?>
                        </select>
                       <label id="textoMoneda"></label> 
                        
                        <?php if(count($listaGuiaremAsociados)>0){  ?> 
                        <script type="text/javascript">
                            $("#moneda").hide(200);
                            textoMoneda=$("#moneda option:selected").text();
                            $("#textoMoneda").html(textoMoneda);
                            $("#textoMoneda").show(200);
                        </script>
                        
                        <?php } ?>
                    </td>
                    <td colspan="2">
                        TDC Dolar : &nbsp;
                        <input name="tdcDolar" type="text" class="cajaGeneral cajaSoloLectura" style="width: 28px" id="tdcDolar" size="3" value="<?php echo $tdcDolar; ?>" onkeypress="return numbersonly(this,event,'.');" readonly="readonly"/>&nbsp;
                        <span id="tdcOpcional">
                            Euro : &nbsp;
                            <input NAME="tdcEuro" type="text" class="cajaGeneral cajaSoloLectura" style="width: 28px" id="tdcEuro" size="3" value="<?php echo $tdcEuro; ?>" onkeypress="return numbersonly(this,event,'.');"/>
                        </span>
                    </td>
                    <script>
                        $("#moneda").change(function(event) {
                            var combo = $(this),
                                codigo = combo.val();
                            $("#tdcOpcional").css('display', codigo > 2 ? '' : 'none');
                            if(codigo > 2)
                                $("#tdcEuro").focus();
                        });

                        $(document).ready(function () {
                            $("#moneda").trigger('change');
                        });

                        function AgregarRetencion(activado=false) {
                            const   butt = document.getElementById("addretencion");
                                    butt.classList.toggle("btn-primary");
                            var montoTotal = parseFloat($("#importetotal").val())    
                            cant = $("#cant-cuotas").val()
                            if($("#addretencion").hasClass("btn-primary")==false){
                                $("#addretencion").html('Quitar Retencion');
                                retenV= parseFloat((montoTotal*3)/100)
                                $("#CantReten").val(retenV)
                               
                                $( "#barrainf" ).append( `<p id='textretencion'>Recuerde que la retencion es de : ${retenV}</p>` );
                            }else{
                                $("#addretencion").html('Agregar Retencion');
                                $("#CantReten").val(0)
                                $("#textretencion").remove()
                                
                            }
                        }

                        descuentoPercent = <?php echo isset($descuento) ? $descuento : 0 ?>;
                    </script>
                </tr> <?php

                if ($tipo_oper == 'V'){ ?>
                    <tr>
                        <td hidden>Descuento</td>
                        <td colspan="5" hidden>
                            <input type="text" class="cajaMinima" id="descuento" name="descuento" size="2" maxlength="2" value="" onKeyPress="return numbersonly(this,event,'.');" > %
                            &nbsp;
                            <span style="display: <?php if(!$usa_adelanto == 1) echo 'none' ?>;" id="box-adelantos">
                                Adelanto: &nbsp;
                                <input type="hidden" class="cajaGeneral cajaSoloLectura" id="proyecto-adelanto" readonly style="width: 100px;text-align: right;">
                                <input type="text" class="cajaGeneral cajaSoloLectura" id="saldo-adelanto" readonly style="width: 100px;text-align: right;">
                                &nbsp;
                                <label><input type="checkbox" id="usa-adelanto" name="adelanto" <?php if($usa_adelanto == 1) echo "checked" ?>> Usar adelanto</label>
                            </span>
                        </td>
                    </tr> <?php
                }
                else { ?>
                    <tr>                   
                        <td hidden>Importacion*</td>
                        <td hidden> <select name="importacion" id="importacion" class="comboGrande" style="width:150px;">
                            <?php echo $cboimportacion;?>
                        </select></td>
                        <td hidden>Descuento %</td>
                        <td colspan="3" hidden>
                            <input type="text" class="cajaMinima" id="descuento" name="descuento" size="2" maxlength="2" value="" onKeyPress="return numbersonly(this,event,'.');" >
                            &nbsp;
                            <span style="display: <?php if(!$usa_adelanto == 1) echo 'none' ?>;" id="box-adelantos">
                                Adelanto : 
                                &nbsp;
                                <input type="hidden" class="cajaGeneral cajaSoloLectura" id="proyecto-adelanto" readonly style="width: 100px;text-align: right;">
                                <input type="text" class="cajaGeneral cajaSoloLectura" id="saldo-adelanto" readonly style="width: 100px;text-align: right;">
                                &nbsp;
                                <label><input type="checkbox" id="usa-adelanto" name="adelanto" <?php if($usa_adelanto == 1) echo "checked" ?>> Usar adelanto</label>
                            </span>
                        </td>
                    </tr> <?php
                } ?>
            </table>
            <script>
                $(function() {
                    $("#obra").change(function (event) {
                        var value = event.target.value;

                        //if(value != 0 && $.trim(value) != "" && $("#forma_pago").val() != 19) consultarAdelantos(value);

                    }).trigger('change');

                    $("#usa-adelanto").change(function (event) {
                        var isCheck = $(event.target).attr('checked');

                        var adelanto = $("#proyecto-adelanto").val();
                        var descuento = isCheck ? $("#descuentotal").val() : 0;

                        $("#saldo-adelanto").val(parseFloat(adelanto - descuento).format());

                        $("#descuento").val(isCheck ? descuentoPercent : 0).trigger("blur");
                    });
                });

                function consultarAdelantos($id) {
                    $.getJSON("<?php echo base_url() ?>index.php/maestros/proyecto/get_adelantos_saldo/"+$id+"/"+tipo_oper, {}, function(json, textStatus) {
                            if(textStatus == 'success' && json.porcentaje > 0) {
                                $("#box-adelantos").show();
                                
                                if("insertar" == "<?php echo $modo ?>") {
                                    $("#usa-adelanto").attr('checked', 'checked');
                                    descuentoPercent = json.porcentaje;
                                    $("#descuento").val(descuentoPercent);
                                }

                                $("#proyecto-adelanto").val(json.saldo_dolares.format(false));
                                //$("#usa-adelanto").trigger('change');
                                $("#descuento").trigger('blur');
                            }
                        });
                }
            </script>
        </div>
        <div id="frmBusqueda"  <?php echo $hidden; ?> class="box-add-product" style="text-align: right;" >
            <a href="#" style="color:#ffffff;" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="limpiar_campos_modal(); ">Agregar Items</a></td>
        </div>
        
       <!-- LISTADO DE GUIAS ASOCIADAS  -->
        
       <!-- FIN DE LISTADO DE GUIAS ASOCIADAS --> 
       <!-- TABLA DETALLE DE TEMPORAL -->
<?php $this->load->view('maestros/temporal_subdetalles'); ?>
       <!-- FIN DE TABLA TEMPORAL DETALLE -->

<div id="frmBusqueda3">
            <table width="100%" border="0" align="right" cellpadding=3 cellspacing=0 class="fuente8">
                <tr>
                    <td width="80%" rowspan="9" align="left">
                        <table width="100%" border="0" align="right" cellpadding=3 cellspacing=0 class="fuente8" style="width: 736px;">
                            <tr style="display: none">
                                <td width="14%" height="30">Modo de impresión</td>
                                <td width="50%"><select name="modo_impresion" <?php if ($tipo_docu == 'B' || $tipo_docu == 'N') echo 'disabled="disabled"'; ?> id="modo_impresion" class="comboGrande" style="width:307px">
                                        <option <?php if ($modo_impresion == '1') echo 'selected="selected"'; ?>
                                            value="1">LOS PRECIOS DE LOS PRODUCTOS DEBEN INCLUIR IGV
                                        </option>
                                        <option <?php if ($modo_impresion == '2') echo 'selected="selected"'; ?>
                                            value="2">LOS PRECIOS DE LOS PRODUCTOS NO DEBEN INCLUIR IGV
                                        </option>
                                    </select>
                                    <input hidden class="cajaGeneral" name="docurefe_codigo" type="text" id="docurefe_codigo" size="14" maxlength="26" value="<?php echo $docurefe_codigo; ?>"/>
                                </td>
                            </tr>

                            <tr>
                                <td width="150px">Motivo de la nota de <?=($tipo_docu == 'C') ? "credito" : "debito";?></td>
                                    <!--
                                        *CREDITO
                                            1 = ANULACIÓN DE LA OPERACIÓN
                                            2 = ANULACIÓN POR ERROR EN EL RUC
                                            3 = CORRECCIÓN POR ERROR EN LA DESCRIPCIÓN
                                            4 = DESCUENTO GLOBAL
                                            5 = DESCUENTO POR ÍTEM
                                            6 = DEVOLUCIÓN TOTAL
                                            7 = DEVOLUCIÓN POR ÍTEM
                                            8 = BONIFICACIÓN
                                            9 = DISMINUCIÓN EN EL VALOR
                                            10 = OTROS CONCEPTOS
                                            11 = AJUSTES AFECTOS AL IVAP
                                            12 = AJUSTES DE OPERACIONES DE EXPORTACIÓN
                                            13 = AJUSTES - MONTOS Y/O FECHAS DE PAGO

                                        *DEBITO
                                            1 = INTERESES POR MORA
                                            2 = AUMENTO DE VALOR
                                            3 = PENALIDADES
                                            4 = AJUSTES AFECTOS AL IVAP
                                            5 = AJUSTES DE OPERACIONES DE EXPORTACIÓN

                                    -->

                                <td colspan="3">
                                    <select name="motivoNota" id="motivoNota" class="comboGrande"> <?php
                                        if ($tipo_docu == 'C'){ ?>
                                            <option <?=($motivoNota == '1') ? 'selected="selected"' : '';?> value="1"> ANULACIÓN DE LA OPERACIÓN </option>
                                            <option <?=($motivoNota == '2') ? 'selected="selected"' : '';?> value="2"> ANULACIÓN POR ERROR EN EL RUC </option>
                                            <option <?=($motivoNota == '3') ? 'selected="selected"' : '';?> value="3"> CORRECCIÓN POR ERROR EN LA DESCRIPCIÓN </option>
                                            <option <?=($motivoNota == '4') ? 'selected="selected"' : '';?> value="4"> DESCUENTO GLOBAL </option>
                                            <option <?=($motivoNota == '5') ? 'selected="selected"' : '';?> value="5"> DESCUENTO POR ÍTEM </option>
                                            <option <?=($motivoNota == '6') ? 'selected="selected"' : '';?> value="6"> DEVOLUCIÓN TOTAL </option>
                                            <option <?=($motivoNota == '7') ? 'selected="selected"' : '';?> value="7"> DEVOLUCIÓN POR ÍTEM </option>
                                            <option <?=($motivoNota == '8') ? 'selected="selected"' : '';?> value="8"> BONIFICACIÓN </option>
                                            <option <?=($motivoNota == '9') ? 'selected="selected"' : '';?> value="9"> DISMINUCIÓN EN EL VALOR </option> 
                                            <option <?=($motivoNota == '10') ? 'selected="selected"' : '';?> value="10"> OTROS CONCEPTOS </option> 
                                            <option <?=($motivoNota == '12') ? 'selected="selected"' : '';?> value="12"> AJUSTES DE OPERACIONES DE EXPORTACIÓN </option> 
                                            <option <?=($motivoNota == '13') ? 'selected="selected"' : '';?> value="13"> AJUSTES - MONTOS Y/O FECHAS DE PAGO </option> 

                                            <?php
                                        }
                                        else{ ?>
                                            <option <?=($motivoNota == '1') ? 'selected="selected"' : '';?> value="1"> INTERESES POR MORA </option>
                                            <option <?=($motivoNota == '2') ? 'selected="selected"' : '';?> value="2"> AUMENTO DE VALOR </option>
                                            <option <?=($motivoNota == '3') ? 'selected="selected"' : '';?> value="3"> PENALIDADES </option> 
                                            <option <?=($motivoNota == '4') ? 'selected="selected"' : '';?> value="4"> AJUSTES AFECTOS AL IVAP </option> 
                                            <option <?=($motivoNota == '5') ? 'selected="selected"' : '';?> value="5"> AJUSTES DE OPERACIONES DE EXPORTACIÓN </option> 

                                            <?php
                                        } ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Forma de Pago </td>
                                <td colspan="3">
                                    <select name="forma_pago" id="forma_pago" class="comboMedio" onchange="necesitaCuota()"><?php echo $cboFormaPago; ?></select>
                                </td>
                                <td >
                                    <!-- <span class="btn btn-primary" id="btn-cuotas" onclick="$('#modal-cuotas').modal({backdrop : 'static'})" style="display: none;">Cuotas (<span id="cuotas-count">0</span>)</span> -->
                                      <span class="btn btn-primary" id="btn-cuotas" data-toggle="modal" data-target=".modal-cuotas" style="display: none;">Cuotas</span>
                                </td>
                                <td style="display: none"><input id="cuotas-check" type="checkbox" name="cuotas" hidden=""></td>
                            </tr>
                            <tr>
                                <td>Observación</td>
                                <td colspan="3">
                                    <textarea id="observacion" name="observacion" class="cajaTextArea" style="width:97%; height:70px;"><?=$observacion;?></textarea>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <tr>
                        <td class="busqueda">Descuento</td>
                        <td align="right">
                            <div align="right"><input class="cajaTotales" name="descuentotal" type="text" id="descuentotal" size="12" align="right" readonly="readonly" value="<?php echo round($descuentotal, 2); ?>"/></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="busqueda">Exonerada</td>
                        <td align="right">
                            <div align="right"><input class="cajaTotales" name="exoneradototal" type="text" id="exoneradototal" size="12" align="right" readonly="readonly" value="<?=(isset($exoneradototal)) ? round($exoneradototal, 2) : '0';?>"/></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="busqueda">Inafecta</td>
                        <td align="right">
                            <div align="right"><input class="cajaTotales" name="inafectototal" type="text" id="inafectototal" size="12" align="right" readonly="readonly" value="<?=(isset($inafectototal)) ? round($inafectototal, 2) : '0';?>"/></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="busqueda">Gratuita</td>
                        <td align="right">
                            <div align="right"><input class="cajaTotales" name="gratuitatotal" type="text" id="gratuitatotal" size="12" align="right" readonly="readonly" value="<?=(isset($gratuitatotal)) ? round($gratuitatotal, 2) : '0';?>"/></div>
                        </td>
                    </tr>
                    <tr style="display: none"> <!--Important-->
                        <td>Sub-total</td>
                        <td width="10%" align="top">
                            <div align="right"><input class="cajaTotales" name="preciototal" type="text" id="preciototal" size="12" align="right" readonly="readonly" value="<?php echo round($preciototal, 2); ?>"/></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="busqueda">Gravada</td>
                        <td align="right">
                            <div align="right"><input class="cajaTotales" name="gravadatotal" type="text" id="gravadatotal" size="12" align="right" readonly="readonly" value="<?=(isset($gravada)) ? round($gravada, 2) : '0';?>"/></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="busqueda">IGV</td>
                        <td align="right">
                            <div align="right"><input class="cajaTotales" name="igvtotal" type="text" id="igvtotal" size="12" align="right" readonly="readonly" value="<?php echo round($igvtotal, 2); ?>"/></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="busqueda">Impuesto a la Bolsa Plástica</td>
                        <td align="right">
                            <div align="right"><input class="cajaTotales" id="importeBolsa" name="importeBolsa" type="text" size="12" align="right" readonly="readonly" value="0"/></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="busqueda">Importe Total</td>
                        <td align="right">
                            <div align="right"><input class="cajaTotales" name="importetotal" type="text" id="importetotal" size="12" align="right" readonly="readonly" value="<?php echo round($importetotal, 2); ?>"/></div>
                        </td>
                    </tr>
            </table>

        <!-- MODAL -->
    <div class="modal fade modal-cuotas" tabindex="-1" role="dialog" style="width: 50%">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Cuotas</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="cuotas_array" id="cuotas_array">
                    <div>
                        <button type="button" class="btn btn-danger del-cuota">-</button>
                            <input type="number" min="0" step="1" id="cant-cuotas" name="cant-cuotas" class="form-control" style="display: inline-block; width: 2em; padding: 0 12px;" value="<?=count($lista_cuotas);?>" readOnly>
                        <button type="button" class="btn btn-success add-cuota">+</button>
                    </div>
                    <div>
                        <table id="tbl-cuotas" width="100%" value="1" class="table">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div> 

                
                    <div class="modal-footer" id="barrainf">
                        Total cuotas : <span id="suma-cuotas"><?=number_format($monto_cuotas, 2);?></span>
                        &nbsp;&nbsp;
                       
                            <button type="button" class="btn btn-default btn-cuota-cancel">Cancelar / Borrar</button>
                        
                            <button type="button" class="btn btn-info btn-cuota-recalc">Recalcular</button>
                            <button type="button" class="btn btn-primary btn-cuota-acept">Aceptar</button>
                    </div> 
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal -->
        <br/>

        <div id="botonBusqueda2" style="padding-top:20px;">
            <img id="loading" src="<?php echo base_url(); ?>images/loading.gif?=<?=IMG;?>" style="visibility: hidden"/>
            <a href="javascript:;" id="grabarComprobante"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton"></a>
            <a href="javascript:;" id="limpiarComprobante"><img src="<?php echo base_url(); ?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton"></a>
            <a href="javascript:;" id="cancelarComprobante"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton"></a>
            <?php echo $oculto ?>
        </div>

    </div>

<style type="text/css">
    #popup {
        left: 0;
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 1001;
    }

    .content-popup {
        margin:0px auto;
        margin-top:150px;
        position:relative;
        padding:10px;
        width:300px;
        min-height:150px;
        border-radius:4px;
        background-color:#FFFFFF;
        box-shadow: 0 2px 5px #666666;
    }

    .content-popup h2 {
        color:#48484B;
        border-bottom: 1px solid #48484B;
        margin-top: 0;
        padding-bottom: 4px;
    }

    .popup-overlay {
        left: 0;
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 999;
        display:none;
        background-color: #777777;
        cursor: pointer;
        opacity: 0.7;
    }

    .close {
        position: absolute;
        right: 15px;
    }
    #btnInventario{
        size: 20px;
        width: 200px;
        height: 50px;
        border-radius: 33px 33px 33px 33px;
        -moz-border-radius: 33px 33px 33px 33px;
        -webkit-border-radius: 33px 33px 33px 33px;
        border: 0px solid #000000;
        background-color:rgba(199, 255, 206, 1);

    }
</style>

</form>


<a id="linkVerImpresion" href="#ventana"></a>
<div id="ventana" style="display: none; width: 350px">
    <div id="imprimir" style="padding:20px; text-align: center">
        <span style="font-weight: bold;"><?=($tipo_docu == 'C') ? 'NOTA DE CREDITO' : 'NOTA DE DEBITO'; ?></span>
        <div style="padding-left: 100px" >
            <input type="text" name="ser_imp" id="ser_imp" readonly="readonly" style="border: 0px; font: bold 10pt helvetica;" value="fsd" class="cajaMinima" maxlength="3">- <input type="text" name="num_imp" id="num_imp" readonly="readonly" style="border: 0px; font: bold 10pt helvetica;" value="lknmlk" class="cajaMedia" maxlength="10">
        </div>  <br/>
        <a href="javascript:;" id="imprimirComprobante"><img src="<?php echo base_url(); ?>images/impresora.jpg?=<?=IMG;?>" class="imgBoton" alt="Imprimir"></a>
        <br/> <br/>
        <a href="javascript:;" id="cancelarImprimirComprobante"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton"></a>
    </div>
</div>
<?php $this->load->view('maestros/temporal_detalles'); ?>
</body>

</html>
<script>
    var totalAmountOrden = 0;
    $("#moneda").change(function () {
        var combo = $(this),
            codigo = combo.val();

        $("#tdcOpcional").css('display', codigo > 2 ? '' : 'none');

        if(codigo > 2) $("#tdcOpcional").focus();
    });

    $(document).ready(function () {
        $("#moneda").trigger('change');

        var codigoClienteProveedor = 0;

        if($("#cliente").length == 1) codigoClienteProveedor = $("#cliente").val();

        if($("#proveedor").length == 1) codigoClienteProveedor = $("#proveedor").val();

        if(codigoClienteProveedor != '') get_obra(codigoClienteProveedor);

        $(".tooltiped").tooltip();

        colors = <?php echo json_encode($colors) ?>;
    });

    function verificarPorcentaje(evt) {
        var value = evt.target.value.toLowerCase();

        if(/[0-9\.]{1,}(?=\%)/.test(value)) {

            if(tipo_oper == 'C') {
                var porcentaje = parseFloat(value.match(/[0-9\.]{1,}(?=\%)/));
                var puTag = document.getElementById("prodpu[0]");

                if(porcentaje > 100 || porcentaje < 1) {
                    alert("El porcentaje no es correcto");
                    evt.target.focus();
                }else{
                    puTag.value = (totalAmountOrden * (porcentaje / 100)).toFixed(2);
                    puTag.focus();
                    puTag.blur();
                }
            }
        }else {
            alert("Debe ingresar un porcentaje en la descripcion del adelanto.");
            evt.target.focus();
        }
    }

//Nuevo NC

    function necesitaCuota() {
        var _this = $("#forma_pago");
        var cuotasCheck = $("#cuotas-check");
        var currentText = document.getElementById('forma_pago').options[document.getElementById('forma_pago').options.selectedIndex].innerText.toLowerCase();
        var requiereCuota = /cuota|credito|letra/g.test(currentText);

        $("#btn-cuotas").css('display', requiereCuota ? '' : 'none');
        $("#condicionespago").css('display', requiereCuota ? '' : 'none');
        codigo ="<?=$codigo;?>";
        
        // if (requiereCuota) {
        //     $("#btn-cuotas").click();
        // }
        
        if(!requiereCuota){
            //cuotasCheck.removeAttr('checked');
        }else{
            view_coutas_notas(<?=$codigo;?>);
        }
    }

    function cant_cuotas(){
        cuotas = $("#cant-cuotas").val();
        var fecha = "<?=date('Y-m-d');?>";

        cantidadA = $(".cantidad-cuotas").length;
        if ( cantidadA > cuotas ){
            $(".cantidad-cuotas:last-child").remove();
            $(".cantidad-cuotas:last-child .cuota-fechaf").removeAttr("onchange");
        }
        else{
                i = cuotas - 1;
                j = i + 1;
                
                if (i > 0){
                    fecha = $(".cuota-fechaf" + parseInt(i-1) ).val();
                    $(".cuota-fechaf"+parseInt(i-1)).attr({ "onchange": "fecha_fin_cuota("+parseInt(i)+")" });
                }

                inputs = '<tr class="cantidad-cuotas">';
                    inputs += '<td> ' + j + ' </td>';
                    inputs += '<td> <input type="date" id="cuota-fechai[' + i + ']" name="cuota-fechai[' + i + ']" class="cajaGeneral cuota-fechai'+i+'" value="' + fecha + '"> </td>';
                    inputs += '<td> <input type="date" id="cuota-fechaf[' + i + ']" name="cuota-fechaf[' + i + ']" class="cajaGeneral cuota-fechaf'+i+' cuota-fechaf" > </td>';
                    inputs += '<td> <input type="number" step="0.1" min="0" id="cuota-monto[' + i + ']" name="cuota-monto[' + i + ']" class="cajaPequena cuota-monto'+i+'" onchange="cuota_total(' + true + ')" value=""> </td>';
                inputs += '</tr>';

                $("#tbl-cuotas tbody").append(inputs);
        }
        cuota_total(false);
    }

    function view_coutas(comprobante = ""){
        if (comprobante != ""){
            url = base_url+"index.php/tesoreria/cuota/obtener_cuotas_comprobante";
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: { comprobante: comprobante },
                beforeSend:function(data){
                    $('#tbl-cuotas tbody').html('');
                },
                error: function (XRH, error){
                    Swal.fire({
                        icon: "warning",
                        title: "No fue posible acceder a las cuotas.",
                        showConfirmButton: false,
                        showCancelButton: false,
                        timer: 2000
                    });
                },
                success: function (data){
                    if (data.match == true) {                        
                        $.each(data.info, function(i,item){
                            cuotas = $("#cant-cuotas").val();
                            indice = i + 1;

                            inputs = '<tr class="cantidad-cuotas">';
                                inputs += '<td> ' + indice + ' </td>';
                                inputs += '<td> <input type="date" value="' + item.fechaiv + '" id="cuota-fechai[' + i + ']" name="cuota-fechai[' + i + ']" class="cajaGeneral cuota-fechai'+i+'" value="' + fecha + '"> </td>';

                                inputs += '<td> <input value="' + item.fechafv + '" type="date" id="cuota-fechaf[' + i + ']" name="cuota-fechaf[' + i + ']" class="cajaGeneral cuota-fechaf'+i+' cuota-fechaf"> </td>';
                                    
                                inputs += '<td> <input type="number" step="0.1" min="0" id="cuota-monto[' + i + ']" name="cuota-monto[' + i + ']" class="cajaPequena cuota-monto'+i+'" onchange="cuota_total(' + true + ')" value="' + item.cuota + '"> </td>';
                            inputs += '</tr>';

                            $("#tbl-cuotas tbody").append(inputs);
                        });

                        cuota_total(true);
                    }
                }
            });
        }
    }
    function view_coutas_notas(comprobante = ""){
        if (comprobante != ""){
            url = "<?php echo base_url(); ?>index.php/ventas/notacredito/detalle_cuotas_nota";
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: { comprobante: comprobante },
                beforeSend:function(data){
                    $('#tbl-cuotas tbody').html('');
                },
                error: function (XRH, error){
                    Swal.fire({
                        icon: "warning",
                        title: "No fue posible acceder a las cuotas.",
                        showConfirmButton: false,
                        showCancelButton: false,
                        timer: 2000
                    });
                },
                success: function (data){
                         var i=-1;             
                        $.each(data, function(){
                                i++;
                            cuotas = $("#cant-cuotas").val();
                            indice = i + 1;

                            inputs = '<tr class="cantidad-cuotas">';
                                inputs += '<td> ' + indice + ' </td>';
                                inputs += '<td> <input type="date" value="' + this.fecha_inicio + '" id="cuota-fechai[' + i + ']" name="cuota-fechai[' + i + ']" class="cajaGeneral cuota-fechai'+i+'" value="' + this.fecha_inicio + '"> </td>';

                                inputs += '<td> <input value="' + this.fecha_de_pago + '" type="date" id="cuota-fechaf[' + i + ']" name="cuota-fechaf[' + i + ']" class="cajaGeneral cuota-fechaf'+i+' cuota-fechaf"> </td>';
                                    
                                inputs += '<td> <input type="number" step="0.1" min="0" id="cuota-monto[' + i + ']" name="cuota-monto[' + i + ']" class="cajaPequena cuota-monto'+i+'" onchange="cuota_total(' + true + ')" value="' + this.importe + '"> </td>';
                            inputs += '</tr>';

                            $("#tbl-cuotas tbody").append(inputs);
                        });

                        $("#cant-cuotas").val(i+1);

                        cuota_total(true);
                    
                }
            });
        }
    }


    function fecha_fin_cuota(pos){
        i = parseInt(pos-1);
        $(".cuota-fechai"+pos).val( $(".cuota-fechaf"+i).val() );
    }

    function cuota_total(quetions = false){
        cuotas = $("#cant-cuotas").val();
        // if ( $("#retencion_codigo").val() != "" )
        //     montoTotal = parseFloat($(".importe_retencion").val());
        // else
            montoTotal = parseFloat($("#importetotal").val());

        importe = montoTotal / cuotas;
        total = 0;


        if (quetions == true){
            Swal.fire({
                        icon: "warning",
                        title: "¿Desea recalcular automaticamente las cuotas?",
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonText: "Si",
                        cancelButtonText: "No"
                    }).then(result => {
                        if (result.value){
                            for ( i=0; i<cuotas; i++ ){
                                $(".cuota-monto"+i).val(importe);
                                
                                if ( $(".cuota-monto"+i).val() != "" )
                                    total = parseFloat(total) + parseFloat($(".cuota-monto"+i).val());
                            }
                            $("#suma-cuotas").html( total.toFixed(2) );
                        }
                    });
        }
        else{
            for ( i=0; i<cuotas; i++ ){
                $(".cuota-monto"+i).val(importe);
                
                if ( $(".cuota-monto"+i).val() != "" )
                    total = parseFloat(total) + parseFloat($(".cuota-monto"+i).val());
            }
            $("#suma-cuotas").html( total.toFixed(2) );
        }
    }


   $(function() {

        $(".add-cuota").click(function(){
            $("#cant-cuotas").val( parseInt( $("#cant-cuotas").val() ) + 1 );
            cant_cuotas();
        });

        $(".del-cuota").click(function(){
            $("#cant-cuotas").val( parseInt( $("#cant-cuotas").val() ) - 1 );
            cant_cuotas();
        });

        $(".btn-cuota-recalc").click(function(){
            cuota_total(true);
        });

        $(".btn-cuota-cancel").click(function(){
            $("#cant-cuotas").val(0);
            $("#tbl-cuotas tbody").html("");
            $(".modal-cuotas").modal("hide");
        });

        $(".btn-cuota-acept").click(function(){
            cuotas = $("#cant-cuotas").val();
            i = cuotas - 1;
            $("#fecha_vencimiento").val( $(".cuota-fechaf" + i).val() );

            $(".modal-cuotas").modal("hide");
            $(".modal-backdrop").hide();
        });

        necesitaCuota();
    }); 

</script>