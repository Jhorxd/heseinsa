
<script type="text/javascript" src="<?php echo base_url();?>js/maestros/configuracion.js?=<?=JS;?>"></script>

<div class="container-fluid">
  <div class="row header">
    <div class="col-md-11">
      <div style="font-size:20pt"><?=$this->session->userdata('nombre_empresa');;?></div>
    </div>
  </div>
  <form id="form_configuracion" method="post">
  	<section>
  		<h1>Configuración general</h1>
	  	<div class="row fuente8 py-1">

		    <div class="col-sm-11 col-md-3">
		    	<label for="cboDeterminaPrecio">Tipo de Precio:</label>
		      <select id="cboDeterminaPrecio" name="cboDeterminaPrecio" class="form-control h-3">
		      	<option value="0" <?php if ($tipo_precio == '0') echo 'selected="selected"'; ?>>Los árticulos tienen un único precio</option>
	          <option value="1" <?php if ($tipo_precio == '1') echo 'selected="selected"'; ?>>El precio depende del tipo de cliente</option>
	          <option value="2" <?php if ($tipo_precio == '2') echo 'selected="selected"'; ?>>El precio depende de la tienda</option>
	          <option value="3" <?php if ($tipo_precio == '3') echo 'selected="selected"'; ?>>El precio depedente de la combinación de las dos últimas</option>
		      </select>
		    </div>
		 
	      <div class="col-sm-11 col-md-2">
		    	<label for="cliente_com">Registro de clientes:</label>
		      <select id="cliente_com" name="cliente_com" class="form-control h-3">
		      	<option value="1" <?php if ($clientes == '1') echo 'selected="selected"'; ?>>Todas las empresas</option>
	          <option value="2" <?php if ($clientes == '2') echo 'selected="selected"'; ?>>Empresa actual</option>
	          <option value="3" <?php if ($clientes == '3') echo 'selected="selected"'; ?>>Por sucursal</option>
		      </select>
		    </div>

		    <div class="col-sm-11 col-md-2">
		    	<label for="proveedor_com">Registro de proveedores:</label>
		      <select id="proveedor_com" name="proveedor_com" class="form-control h-3">
		      	<option value="1" <?php if ($proveedor == '1') echo 'selected="selected"'; ?>>Todas las empresas</option>
	          <option value="2" <?php if ($proveedor == '2') echo 'selected="selected"'; ?>>Empresa actual</option>
	          <option value="3" <?php if ($proveedor == '3') echo 'selected="selected"'; ?>>Por sucursal</option>
		      </select>
		    </div>
		    <div class="col-sm-11 col-md-2">
		    	<label for="producto_com">Registro de productos:</label>
		      <select id="producto_com" name="producto_com" class="form-control h-3">
		      	<option value="1" <?php if ($producto == '1') echo 'selected="selected"'; ?>>Todas las empresas</option>
	          <option value="2" <?php if ($producto == '2') echo 'selected="selected"'; ?>>Empresa actual</option>
	          <option value="3" <?php if ($producto == '3') echo 'selected="selected"'; ?>>Por sucursal</option>
		      </select>
		    </div>
	    </div>
    </section>
    <section>
  		<h1>Configuración por sucursal</h1>
	  	<div class="row fuente8 py-1">
	      <div class="col-sm-11 col-md-2">
		    	<label for="igv">IGV %:</label>
		      <input type="text" name="igv" id="igv" placeholder="IGV 0-100" class="form-control h-2" value="<?php echo $igv100;?>"/>
		    </div>
	 
	      <div class="col-sm-11 col-md-2">
	        <label for="contiene_igv">Precio de venta de los productos incluye IGV:</label><br>
	        <input id="contiene_igv" name="contiene_igv" type="checkbox" value="1" style="display: none;">
	        <div class="Switch Round On contiene_igv" style="vertical-align:bottom; margin-left:10px;"><div class="Toggle"></div></div>
	      </div>
	    </div>
    </section>

    <section>
  		<h1>Series y numeros de la sucursal</h1>
	  	<div class="row fuente8 py-1">
	      <div class="col-sm-11 col-md-1">
		    	<label for="igv">Cotizaciones</label>
		      <input type="text" name="orden_venta_serie" id="orden_venta_serie" class="form-control h-2" value="<?php echo $documentos['orden_venta_serie'];?>"/>
		      <input type="text" name="orden_venta" id="orden_venta" class="form-control h-2" value="<?php echo $documentos['orden_venta'];?>"/>
		    </div>
		    <div class="col-sm-11 col-md-1">
		    	<label for="igv">Factura</label>
		      <input type="text" name="factura_serie" id="factura_serie" class="form-control h-2" value="<?php echo $documentos['factura_serie'];?>"/>
		      <input type="text" name="factura" id="factura" class="form-control h-2" value="<?php echo $documentos['factura'];?>"/>
		    </div>
		    <div class="col-sm-11 col-md-1">
		    	<label for="igv">Boleta</label>
		      <input type="text" name="boleta_serie" id="boleta_serie" class="form-control h-2" value="<?php echo $documentos['boleta_serie'];?>"/>
		      <input type="text" name="boleta" id="boleta" class="form-control h-2" value="<?php echo $documentos['boleta'];?>"/>
		    </div>
		    <div class="col-sm-11 col-md-1">
		    	<label for="igv">Nota de Venta</label>
		      <input type="text" name="compgene_serie" id="compgene_serie" class="form-control h-2" value="<?php echo $documentos['compgene_serie'];?>"/>
		      <input type="text" name="compgene" id="compgene" class="form-control h-2" value="<?php echo $documentos['compgene'];?>"/>
		    </div>
		    <div class="col-sm-11 col-md-1">
		    	<label for="igv">Guia de remisión</label>
		      <input type="text" name="guiarem_serie" id="guiarem_serie" class="form-control h-2" value="<?php echo $documentos['guiarem_serie'];?>"/>
		      <input type="text" name="guiarem" id="guiarem" class="form-control h-2" value="<?php echo $documentos['guiarem'];?>"/>
		    </div>
		    <div class="col-sm-11 col-md-1">
		    	<label for="igv">Nota de Credito</label>
		      <input type="text" name="notacred_serie" id="notacred_serie" class="form-control h-2" value="<?php echo $documentos['notacred_serie'];?>"/>
		      <input type="text" name="notacred" id="notacred" class="form-control h-2" value="<?php echo $documentos['notacred'];?>"/>
		    </div>
		    <div class="col-sm-11 col-md-1">
		    	<label for="igv">Orden de compra</label>
		      <input type="text" name="ocompra_serie" id="ocompra_serie" class="form-control h-2" value="<?php echo $documentos['ocompra_serie'];?>"/>
		      <input type="text" name="ocompra" id="ocompra" class="form-control h-2" value="<?php echo $documentos['ocompra'];?>"/>
		    </div>
	    </div>
    </section>
  	
    <div class="row fuente8 py-1">
    	<div class="col-sm-4 col-md-4 col-lg-4 form-group"></div>
      <div class="col-sm-1 col-md-1 col-lg-1"><br>
          <button type="button" class="btn btn-success" id="buscar" name="buscar" onclick="guardar_config();">GUARDAR</button>
      </div>
      <div class="col-sm-1 col-md-1 col-lg-1"><br>
          <button type="button" class="btn btn-info" id="limpiar" name="limpiar">LIMPIAR</button>
      </div>
    </div>

	  
	</form>
 </div>

 <script type="text/javascript">
   	$(document).ready(function(){
   	 contiene_igv(<?=$contiene_igv;?>);
   	/* ================= Toggle Switch - Checkbox ================= */
	    $(".Switch").click(function() {
	    	$(this).hasClass("On") ? ($(this).parent().find("input:checkbox").attr("checked", !0), $(this).removeClass("On").addClass("Off")) : ($(this).parent().find("input:checkbox").attr("checked", !1), $(this).removeClass("Off").addClass("On"))
	    }), $(".Switch").each(function() {
	    	$(this).parent().find("input:checkbox").length && ($(this).parent().find("input:checkbox").hasClass("show") || $(this).parent().find("input:checkbox").hide(), $(this).parent().find("input:checkbox").is(":checked") ? $(this).removeClass("On").addClass("Off") : $(this).removeClass("Off").addClass("On"))
	    });
	   });

function contiene_igv( act = "" ){
    if (act == 1){
				$("#contiene_igv").click();
    }
}
function guardar_config(){
	Swal.fire({
		icon: "info",
		title: "¿Esta seguro de guardar esta configuración?",
		html: "<b class='color-red'></b>",
		showConfirmButton: true,
		showCancelButton: true,
		confirmButtonText: "Aceptar",
		cancelButtonText: "Cancelar"
	}).then(result => {
		if (result.value){
			var url = base_url + "index.php/maestros/configuracion/modificar_configuracion";

			validacion = true;

			if (validacion == true){
				var dataForm = $("#form_configuracion").serialize();
				$.ajax({
					type: 'POST',
					url: url,
					dataType: 'json',
					data: dataForm,
					success: function(data){
						if (data.result == "success") {
							titulo = "¡Actualización exitosa!";

							Swal.fire({
								icon: "success",
								title: titulo,
								showConfirmButton: true,
								timer: 5000
							});

						}
						else{
							Swal.fire({
								icon: "error",
								title: "Sin cambios.",
								html: "<b class='color-red'>" + data.message + "</b>",
								showConfirmButton: true,
								timer: 5000
							});
						}
					},
					complete: function(){
						
					}
				});
			}
		}
	});
}
   </script>