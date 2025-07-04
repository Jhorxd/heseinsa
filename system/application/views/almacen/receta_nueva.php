<?php
$nombre_persona = $this->session->userdata('nombre_persona');
$persona = $this->session->userdata('persona');
$usuario = $this->session->userdata('usuario');
$url = base_url() . "index.php";
if (empty($persona))
    header("location:$url");
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/produccion.js?=<?=JS;?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        plusCost();
		/***verificacion de si es editar y esta relacionada con otras guias **/
		<?php
            if(count($listaGuiaremAsociados)>0){  ?>
		    document.getElementById("tempde_producto").readOnly = true;
            $("#addItems").hide(200);
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
		
        base_url = $("#base_url").val();
        tipo_oper = $("#tipo_oper").val();
        almacen = $("#cboCompania").val();

        

    });

    //AUTOCOMPLETO DE PRODUCTOS
    $(function () {
        /*$("#getProductoCodigo").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= base_url(); ?>index.php/almacen/produccion/searchProducto/",
                    type: "POST",
                    data: {
                        codigo: $("#getProductoCodigo").val(),
                        almacen: $("#almacenFormAjuste").val(),
                        default: "codigo",
                    },
                    dataType: "json",
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $("#productoCodigo").val(ui.item.id);
                $("#getProductoDescripcion").val(ui.item.nombre);
                $("#stockProducto").val(ui.item.stock);
                $("#cantidadProducto").focus();
            },
            minLength: 2
        });*/

        $('#getProductoCodigo').keyup(function(e) {
            if (e.which == 13) {
                if ($(this).val() != '')
                    addProductoBarcode();
            }
        });


        $("#descripcionProducto").autocomplete({
                source: function (request, response) {

                    $("#tempde_message").html('');
                    $("#tempde_message").hide();
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/autocomplete_producto/" + $("#flagBS").val() + "/" + $("#compania").val()+"/"+$("#almacen").val(),
                        type: "POST",
                        data: {
                            term: $("#descripcionProducto").val(), TipCli: 0, tipo_oper:"V", moneda: $("#moneda").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    $("#idProducto").val(ui.item.codigo);
                    $("#descripcionProducto").val(ui.item.value);
                    $("#descripcion_receta").val(ui.item.value);
                    $("#codigo_producto").val(ui.item.codinterno);
                    $("#addItems").click();
                    $("#tempde_producto").focus();
                },
                minLength: 1
            });
    });

    $('a').on('click', function(){
      window.last_clicked_time = new Date().getTime();
      window.last_clicked = $(this);
    });

    $(window).bind('beforeunload', function() {
        if ( $("#salir").val() == 0 ){
          var time_now = new Date().getTime();
          var link_clicked = window.last_clicked != undefined;
          var within_click_offset = (time_now - window.last_clicked_time) < 100;
          if (link_clicked && within_click_offset) {
            return 'You clicked a link to '+window.last_clicked[0].href+'!';
          } else {
            return 'Estas abandonando la página!';
          }
        }
    });
    
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

    

	
</script>

</head>

<body>

<input type="hidden" name="codigoguia" id="codigoguia" value="<?php echo $guia; ?>"/>

<!-- Inicio -->
    <input value='<?php echo $compania; ?>' name="compania" type="hidden" id="compania"/>

    <div id="VentanaTransparente" style="display:none;">
        <div class="overlay_absolute"></div>
        <div id="cargador" style="z-index:2000">
            <table width="100%" height="100%" border="0" class="fuente8">
                <tr valign="middle">
                    <td> Por Favor Espere</td>
                    <td>
    					<img src="<?php echo base_url(); ?>images/cargando.gif" border="0" title="CARGANDO"/>
    					<a href="#" id="hider2"></a>
    				</td>
                </tr>
            </table>
        </div>
    </div>
<!-- Fin -->

<form id="<?php echo $formulario; ?>" name="<?php echo $formulario; ?>" method="post" action="<?php echo $url_action; ?>">
    <div id="zonaContenido" align="center">
        <?php echo validation_errors("<div class='error'>", '</div>'); ?>
        <div id="tituloForm" class="header" style="height: 20px">
            <?php echo $titulo;?>
            <select id="cboTipoDocu" name="cboTipoDocu" class="comboMedio" hidden>
                <option value="P">RECETA</option>
            </select>
        </div>

		<div id="idDivGuiaRelacion" style="<?php echo (count($listaGuiaremAsociados)>0)?'':'display:none'; ?>">
    		<div id="dialogSeriesAsociadas" title="Series Ingresadas">
                <div id="mostrarDetallesSeriesAsociadas">
                    <div id="detallesSeriesAsociadas"></div>
                </div>
    		</div>
    		
    		<!-- dialogo para mostrarse que sleccionar el almacen de un producto -->
    		
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
        </div>
        
        <div id="frmBusqueda">
            <table class="fuente8" width="100%" cellspacing="0" cellpadding="5" border="0">
                <tr>
                    <td>Codigo</td>
                    <td valign="middle"> <input placeholder="Codigo de barra" type="text" name="getProductoCodigo" id="getProductoCodigo" class="cajaGrande"/></td>
                    <td>Articulo</td>
                    <td valign="middle">
                        <input type="hidden" name="idProducto" id="idProducto" value="<?=$idProducto;?>"/>
                       
                        <input placeholder="Nombre del producto" type="text" name="descripcionProducto" id="descripcionProducto" class="cajaGrande" size="37" maxlength="50" value="<?=$descripcionProducto;?>"/>
                        
                    </td>
                    <td width="20%">Codigo de la receta</td>
                    <td valign="middle">
                        <input type="hidden" name="receta" id="receta" size="5" value="<?=$receta;?>"/>
                        
                        <input placeholder="Codigo" type="text" name="codigo_producto" id="codigo_producto"  readonly value="<?=$codigo_producto;?>" class="cajaGrande"/>
                    </td>
                </tr>
                <tr>
                    <td>COSTOS DE PRODUCCION</td>
                </tr>
                <tr>
                    <td>Materia prima</td>
                    <td valign="middle"><input type="number" name="materia_prima" id="materia_prima" onkeyup="plusCost();" value="<?=$materia_prima;?>" class="cajaGrande">
                    </td>
                    <td>Mano de obra</td>
                    <td><input type="number" name="mano_obra" id="mano_obra" onkeyup="plusCost();" value="<?=$mano_obra;?>" class="cajaGrande"></td>
                    <td>Moneda</td>
                    <td valign="middle">
                        <select name="moneda" id="moneda" class="comboPequeno" style="width:150px;">
                            <?php echo $cboMoneda; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Gastos de produccion</td>
                    <td valign="middle"><input type="number" name="gastos_prod" id="gastos_prod"  onkeyup="plusCost();" value="<?=$gastos_prod;?>" class="cajaGrande">
                    </td>
                    <td>Adicionales</td>
                    <td><input type="number" name="costos_adicionales" id="costos_adicionales" onkeyup="plusCost();" value="<?=$costos_adicionales;?>" class="cajaGrande"></td>
                    <td><b>TOTAL COSTO DE PRODUCCION</b></td>
                    <td valign="middle">
                        <input type="number" name="totalReceta" id="totalReceta" class="cajaGrande" readonly>
                    </td>
                </tr>
                <tr style="display: none">
                    <td>Almacen</td>
                    <td valign="middle">
                        <?=$cboAlmacen;?>
                    </td>
                    <td>Articulo *</td>
                    <td>Articulo *</td>
                </tr>
                <tr>
                    <td>NOMBRE DE LA RECETA</td>
                    <td><input placeholder="Nombre de la receta" name="descripcion_receta" type="text" class="cajaGrande cajaSoloLectura" id="descripcion_receta" value="<?=$descripcionReceta;?>" readonly maxlength="50" title="Ingrese el nombre de la receta"/></td>
                    
                    
                </tr>
            </table>
        </div>
        <div id="frmBusqueda"  <?php echo $hidden; ?> class="box-add-product" style="text-align: right;" >
            <a href="#" id="addItems" name="addItems" style="color:#ffffff;" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="limpiar_campos_modal(); ">Agregar Items</a></td>
        </div>
       <!-- TABLA DETALLE DE TEMPORAL -->
        <?php $this->load->view('maestros/temporal_subdetalles_second'); ?>
       <!-- FIN DE TABLA TEMPORAL DETALLE -->

        <br/>

        <div id="botonBusqueda2" style="padding:10px; background: #e7ebef;">
            <img id="loading" src="<?php echo base_url(); ?>images/loading.gif" style="visibility: hidden"/>
            <?php if($estado != 0): ?>
            <a href="javascript:;" id="imgGuardarReceta"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton"></a>
            <?php endif; ?>
            <a href="javascript:;" id="limpiarReceta"><img src="<?php echo base_url(); ?>images/botonlimpiar.jpg" width="69" height="22" class="imgBoton"></a>
            <a href="javascript:;" id="cancelarReceta"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
            <input type="hidden" name="salir" id="salir" value="0"/>
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
        <span style="font-weight: bold;">
          <?php if ($tipo_docu == 'P') echo 'RECETA'; else echo 'RECETA'; ?>
      </span>
      <div style="padding-left: 100px" >
          <input type="text" name="ser_imp" id="ser_imp" readonly="readonly" style="border: 0px; font: bold 10pt helvetica;" value="fsd" class="cajaMinima" maxlength="3">
          - <input type="text" name="num_imp" id="num_imp" readonly="readonly" style="border: 0px; font: bold 10pt helvetica;" value="lknmlk" class="cajaMedia" maxlength="10">
      </div>  <br/>
      <a href="javascript:;" id="imprimirPedido"><img src="<?php echo base_url(); ?>images/impresora.jpg" class="imgBoton" alt="Imprimir"></a>
      <br/> <br/>
      <a href="javascript:;" id="cancelarImprimirPedido"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
  </div>
</div>
<?php $this->load->view('maestros/temporal_detalles_second'); ?>
</body>

</html>