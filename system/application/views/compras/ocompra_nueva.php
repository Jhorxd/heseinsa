
<script type="text/javascript" src="<?=$base_url;?>js/compras/ocompra.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?=$base_url;?>js/funciones.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?=$base_url;?>js/fancybox/jquery.mousewheel-3.0.4.pack.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?=$base_url;?>js/fancybox/jquery.fancybox-1.3.4.pack.js?=<?=JS;?>"></script>

<script src="<?=$base_url;?>bootstrap/js/bootstrap.min.js?=<?=JS;?>"></script>
<script src="<?=$base_url;?>bootstrap/js/bootstrap.js?=<?=JS;?>"></script>

<link href="<?=$base_url;?>bootstrap/css/bootstrap.css?=<?=CSS;?>" rel="stylesheet">
<link href="<?=$base_url;?>bootstrap/css/bootstrap-theme.css?=<?=CSS;?>" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="<?=$base_url;?>js/fancybox/jquery.fancybox-1.3.4.css?=<?=CSS;?>" media="screen"/>
<script type="text/javascript">
	$(document).ready(function () {
		almacen = $("#cboCompania").val();
		$("a#linkVerPersona").fancybox({
			'width': 750,
			'height': 335,
			'autoScale': false,
			'transitionIn': 'none',
			'transitionOut': 'none',
			'showCloseButton': true,
			'modal': true,
			'type': 'iframe'
		});
		$("#linkSelecProducto").fancybox({
			'width': 800,
			'height': 500,
			'autoScale': false,
			'transitionIn': 'none',
			'transitionOut': 'none',
			'showCloseButton': true,
			'modal': false,
			'type': 'iframe'
		});
		$("a#linkVerCliente, a#linkSelecCliente, a#linkVerProveedor, a#linkSelecProveedor").fancybox({
			'width': 800,
			'height': 550,
			'autoScale': false,
			'transitionIn': 'none',
			'transitionOut': 'none',
			'showCloseButton': true,
			'modal': true,
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

		$(".verDocuRefe").fancybox({
			'width': 800,
			'height': 500,
			'autoScale': false,
			'transitionIn': 'none',
			'transitionOut': 'none',
			'showCloseButton': true,
			'modal': false,
			'type': 'iframe',
			'onStart': function () {

				tipo_oper = '<?php echo $tipo_oper; ?>';

				if (tipo_oper == 'V') {
					if ($('#cliente').val() == '') {
						alert('Debe seleccionar el cliente.');
						$('#nombre_cliente').focus();
						return false;
					} else {

						if ($('.verDocuRefe::checked').val() == 'P')
							baseurl = base_url + 'index.php/ventas/presupuesto/ventana_muestra_presupuestoCom/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/F/' + almacen + '/P/OC';
						else if ($('.verDocuRefe::checked').val() == 'O')
							baseurl = base_url + 'index.php/compras/ocompra/ventana_muestra_ocompra/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/F/' + almacen + '/O/OC';
						else if ($('.verDocuRefe::checked').val() == 'OV')
							baseurl = base_url + 'index.php/compras/ocompra/ventana_muestra_oventa';


						$('.verDocuRefe::checked').attr('href', baseurl);

					}
				} else {

					if ($('#proveedor').val() == '' && $('.verDocuRefe::checked').val() != 'OV') {
						alert('Debe seleccionar el proveedor.');
						$('#nombre_proveedor').focus();
						return false;
					} else {
						if ($('.verDocuRefe::checked').val() == 'P')
							baseurl = base_url + 'index.php/compras/presupuesto/ventana_muestra_presupuestoCom/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/F/' + almacen + '/P/OC';
						else if ($('.verDocuRefe::checked').val() == 'O')
							baseurl = base_url + 'index.php/compras/ocompra/ventana_muestra_ocompra/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/F/' + almacen + '/O/OC';
						else if ($('.verDocuRefe::checked').val() == 'OV')
							baseurl = base_url + 'index.php/compras/ocompra/ventana_muestra_oventa';

						$('.verDocuRefe::checked').attr('href', baseurl);
					}
				}

			}
		});
	});

	$(function () {

		$("#TipCli option:selected").css({'font-weight':'bold', 'font-size':'9pt', 'background':'#ddd'});

		$("#nombre_cliente").autocomplete({
			source: function (request, response) {
				$.ajax({
					url: "<?=$base_url;?>index.php/ventas/cliente/autocomplete/",
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
				$("#cboVendedor > option[value="+ ui.item.vendedor +"]").attr("selected",true);

				if (ui.item.digemin == 1){
					$('#tipoComprobante > option[value="F"]').attr('disabled',false);
					$('#tipoComprobante > option[value="B"]').attr('disabled',false);

					if (ui.item.ruc.length == 11)
						$('#tipoComprobante > option[value="F"]').attr('selected',true);
					else
						$('#tipoComprobante > option[value="B"]').attr('selected',true);
				}
				else{
					$('#tipoComprobante > option[value="F"]').attr('disabled',true);
					$('#tipoComprobante > option[value="B"]').attr('disabled',true);
					$('#tipoComprobante > option[value="N"]').attr('selected',true);
				}

				if ( ui.item.contactos != null ){
					$('#contacto option').remove();
					if (ui.item.contactos != undefined && ui.item.contactos != null){
						var size = ui.item.contactos.length;
						for (x = 0; x < size; x++){
							$('#contacto').append("<option value='"+ui.item.contactos[x].ECONP_Contacto+"'>"+ui.item.contactos[x].ECONC_Descripcion+"</option>");
						}
					}
					else{
							$('#contacto').append("<option value=''>Sin contactos registrados.</option>");
					}
				}
				get_obra(ui.item.codigo);
			},
			minLength: 2
		});

		$("#buscar_cliente").autocomplete({
			source: function (request, response) {
				$.ajax({
					url: "<?=$base_url;?>index.php/ventas/cliente/autocomplete_ruc/",
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
				$("#TipCli").val(ui.item.TIPCLIP_Codigo);
				$("#cboVendedor > option[value="+ ui.item.vendedor +"]").attr("selected",true);

				if (ui.item.digemin == 1){
					$('#tipoComprobante > option[value="F"]').attr('disabled',false);
					$('#tipoComprobante > option[value="B"]').attr('disabled',false);

					if (ui.item.ruc.length == 11)
						$('#tipoComprobante > option[value="F"]').attr('selected',true);
					else
						$('#tipoComprobante > option[value="B"]').attr('selected',true);
				}
				else{
					$('#tipoComprobante > option[value="F"]').attr('disabled',true);
					$('#tipoComprobante > option[value="B"]').attr('disabled',true);
					$('#tipoComprobante > option[value="N"]').attr('selected',true);
				}

				if ( ui.item.contactos != null ){
					var size = ui.item.contactos.length;
					$('#contacto option').remove();

					for (x = 0; x < size; x++){
						$('#contacto').append("<option value='"+ui.item.contactos[x].ECONP_Contacto+"'>"+ui.item.contactos[x].ECONC_Descripcion+"</option>");
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

		$("#nombre_proveedor").autocomplete({
			source: function (request, response) {
				$.ajax({
					url: "<?=$base_url;?>index.php/compras/proveedor/autocomplete/",
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

		$("#buscar_proveedor").autocomplete({
			source: function (request, response) {
				$.ajax({
					url: "<?=$base_url;?>index.php/compras/proveedor/autocomplete_ruc/",
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
				
				if (ui.item.contactos != null) {
					var size = ui.item.contactos.length;
					$('#contacto option').remove();

					for (x = 0; x < size; x++) {
						$('#contacto').append("<option value='" + ui.item.contactos[x].ECONP_Contacto + "'>" + ui.item.contactos[x].ECONC_Descripcion + "</option>");
					}
				}

				$("#addItems").click();
			},
			minLength:2 
		});

		$("#cboVendedor").change(function(){
			vendedor = $("#cboVendedor").val();
			url = "<?=base_url();?>index.php/ventas/cliente/categoria_cliente";
			$.ajax({
				url:url,
				type:"POST",
				data:{ vendedor: vendedor },
				dataType:"json",
				error:function(data){
				},
				success:function(data){
					if (data != null){
						var pers = data;
						var size = pers.length;
						for (j = 0; j < size; j++){
							$("#TipCli").val(pers[j].TIPCLIP_Codigo);
						}
					}
				}
			});
		});

		$('#close').click(function(){
			$('#popup').fadeOut('slow');
			$('.popup-overlay').fadeOut('slow');
			return false;
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

function limpiar_campos_necesarios() {

	$('#buscar_proveedor').val("");
	$('#proveedor').val("");
	$('#ruc_proveedor').val("");
	$('#nombre_proveedor').val("");

	$('#cliente').val("");
	$('#buscar_cliente').val("");
	$('#ruc_cliente').val("");
	$('#nombre_cliente').val("");
}

function verificar_Inventariado_producto(){
	base_url = $("#base_url").val();
	tipo_oper = $("#tipo_oper").val();
	url = base_url + "index.php/ventas/comprobante/verificar_inventariado/";
	producto=$("#producto").val();
	prodNombre=$("#nombre_producto").val();
	dataEnviar="enviarCodigo="+producto;  
	$.ajax({url: url,
		data:dataEnviar,
		type:'POST', 
		success: function(result){
			if (result=="0") {
				prodNombre="<p>"+$("#nombre_producto").val()+"</p>";
				$('#popup').fadeIn('slow');
				$('.popup-overlay').fadeIn('slow');
				$('.popup-overlay').height($(window).height());
				$("#contendio").html(prodNombre);
				return false;
			}

		}});
}

function ejecutarModal(){
	$("#buscar_producto").val("").focus();
	$('#popup').fadeOut('slow');
	$('.popup-overlay').fadeOut('slow');
	return false;
}

function seleccionar_cliente(codigo, ruc, razon_social, empresa, persona) {
	$("#cliente").val(codigo);
	$("#ruc_cliente").val(ruc);
	$("#nombre_cliente").val(razon_social);
	get_obra(codigo);
	if (empresa != '0') {
		if (empresa != $('#empresa').val()) {
			limpiar_combobox('contacto');
			$('#empresa').val(empresa);
			$('#persona').val(0);
			listar_contactos(empresa);
		}
	}
	else {
		limpiar_combobox('contacto');
		$('#linkVerPersona').hide();
		if (persona != $('#persona').val()) {
			$('#empresa').val(0);
			$('#persona').val(persona);
		}
	}
}

function seleccionar_proveedor(codigo, ruc, razon_social, empresa, persona, ctactesoles, ctactedolares) {
	$("#proveedor").val(codigo);
	$("#ruc_proveedor").val(ruc);
	$("#buscar_proveedor").val(ruc);
	$("#nombre_proveedor").val(razon_social);

	if (empresa != '0') {
		if (empresa != $('#empresa').val()) {
			$('#empresa').val(empresa);
			$('#persona').val(0);
			listar_contactos(empresa);
		}
	}
	else {
		if (persona != $('#persona').val()) {
			$('#empresa').val(0);
			$('#persona').val(persona);
		}
	}
	$('#ctactesoles').val(ctactesoles);
	$('#ctactedolares').val(ctactedolares);
}

function seleccionar_producto(codigo, interno, familia, stock, costo, flagGenInd) {
	$("#producto").val(codigo);
	$("#codproducto").val(interno);
	$("#cantidad").focus();
	$("#stock").val(stock);
	$("#costo").val(costo);
	$("#flagGenInd").val(flagGenInd);
	listar_unidad_medida_producto(codigo);
}

function seleccionar_ocompra(guia, serie, numero) {
	obtener_comprobantes_temproductos(guia,'ocompras')
	tipo_oper = '<?php echo $tipo_oper; ?>';
	serienumero = "Numero de ocompra :" + serie + " - " + numero;
	$("#serieguiaverOC").html(serienumero);
	$("#serieguiaverOC").show(200);
	$("#serieguiaverPre").hide(200);
	if (tipo_oper == 'V'){
		codigoPresupuesto=$("#presupuesto").val();
		if(codigoPresupuesto!="" && codigoPresupuesto!=0){
			modificarTipoSeleccionPrersupuesto(codigoPresupuesto,0);
		}
		$("#presupuesto").val(0);
	}    

}

function seleccionar_oventa(guia, serie, numero) {
	obtener_comprobantes_temproductos(guia,'ocompras');
}

function seleccionar_presupuesto(guia, serieguia, numeroguia) {
	isRealizado=modificarTipoSeleccionPrersupuesto(guia,1);
	if(isRealizado){
		tipo_oper = '<?php echo $tipo_oper; ?>';

		obtener_comprobantes_temproductos(guia,'presupuesto');
		serienumero = "Numero de PRESUPUESTO :" + serieguia + " - " + numeroguia;
		$("#serieguiaverPre").html(serienumero);
		$("#serieguiaverPre").show(200);
		$("#serieguiaverOC").hide(200);
		if (tipo_oper == 'V'){
			codigoPresupuesto=$("#presupuesto").val();
			if(codigoPresupuesto!="" && codigoPresupuesto!=0){
				modificarTipoSeleccionPrersupuesto(codigoPresupuesto,0);
			}
			$("#presupuesto").val(guia);
		}    
	}
}
function get_obra(codigo) {
	$.post("<?=$base_url;?>index.php/compras/pedido/obra", {
		"codigoempre" : codigo
	}, function(data) {
		var c = JSON.parse(data);
		$('#obra').html('');
		$('#obra').append("<option value='0'>::Seleccione::</option>");
		$.each(c,function(i,item){
			$('#obra').append("<option value='"+item.PROYP_Codigo+"'>"+item.proyecto+"</option>");
		});
	});
}
</script>

<form id="frmOcompra" id="<?php echo $formulario; ?>" method="post" action="<?php echo $url_action; ?>"
	onsubmit="return valida_ocompra();">
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
			<input name="compania" type="hidden" id="compania" value="<?php echo $compania; ?>">
			<input name="sucursal" type="hidden" id="sucursal" value="<?php echo $sucursal; ?>">
			<input name="tipo_oper" type="hidden" id="tipo_oper" value="<?php echo $tipo_oper; ?>">

			<div id="zonaContenido" align="center">
				<div id="tituloForm" class="header"><?php echo $titulo; ?></div>
				<div id="frmBusqueda">
					<table class="fuente8" width="100%" cellspacing="0" cellpadding="5" border="0">
						<tr>
							<td width="10%">Número</td>
							<td width="40%" valign="middle">

								<input name="codigo_usuario" id="codigo_usuario" type="hidden" class="cajaGeneral cajaSoloLectura" size="5" maxlength="50" value="<?php echo $codigo_usuario; ?>"/>
								<input name="serie" id="serie" type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="50" value="<?=(isset($serie) && $serie != '') ? $serie : $serie_suger_oc;?>"/>
								<input name="numero" id="numero" type="text" class="cajaGeneral cajaSoloLectura" size="10" maxlength="10" readonly="readonly" value="<?=(isset($numero) && $numero != '') ? $numero : '00'.$numero_suger_oc;?>"/>
								<input name="centro_costo" type="hidden" id="centro_costo" size="10" maxlength="10" value="1"/>


								<input name="pedido" type="hidden" class="cajaPequena2" id="pedido" size="10" maxlength="10" readonly="readonly" value="<?php echo $pedido; ?>"/>
								<?php ?>
								<a href="javascript:;" id="linkVerSerieNum">

									<p class="factura"
									style="display:none"><?php echo $serie_suger_oc . '-' . '00' . $numero_suger_oc ?>
								</p>
								<?php if ($modo == '') { ?>
									<img src="<?=$base_url;?>images/flecha.png?=<?=IMG;?>" border="0"
									alt="Serie y número sugerido" title="Serie y número sugerido"/>
								<?php } ?>
							</a>
							<?php ?>

							<?php if($tipo_oper == 'C'): ?>
								<span style="margin-left: 20px;"><label><input <?php echo $igv == 0 ? 'checked' : '' ?> data-igv="<?php echo $igv == 0 ? $igv_db : $igv ?>" type="checkbox" id="chkImportacion"> <b>Importación</b></label></span>
								<script>
									function reasign_igv(igv) {
										$.each($("#tblDetalleOcompra tbody tr"), function(i, elm) {
											document.getElementById("prodigv100["+i+"]").value = igv;
											document.getElementById("prodpu["+i+"]").focus();
										});
									}
									$(document).ready(function () {
										$("#chkImportacion").change(function() {
											var check = $(this),
											igv = check.data('igv'),
											isCheck = check.attr('checked');

											if(isCheck){
												$("#igv").val(0);
												reasign_igv(0);
											}else{
												$("#igv").val(igv);
												reasign_igv(igv);
											}

											$("#montoDescuento").css('display', isCheck ? '' : 'none');
										}).trigger('change');
									});
								</script>
							<?php endif; ?>

							&nbsp;&nbsp;
							I.G.V. &nbsp;&nbsp;
							<input name="igv" type="text" class="cajaGeneral cajaSoloLectura" readonly="readonly" size="2" maxlength="2" id="igv" maxlength="10" value="<?php echo $igv; ?>" onKeyPress="return numbersonly(this,event,'.');" onBlur="calcular_totales_tempdetalle();"/>
							&nbsp;&nbsp;

							<span>TDC</span> &nbsp;&nbsp;
							<input type="text" name="tdcDolar" class="cajaMinima cajaSoloLectura" readonly value="<?php echo $tdcDolar ?>">

							<span id="tdc-opcional">
								TDC Euro &nbsp;&nbsp;
								<input type="text" name="tdcEuro" class="cajaMinima" value="<?php echo $tdcEuro ?>">
							</span>
						</td>

						<td width="20%">Fecha
							<input name="fecha" id="fecha" type="text" class="cajaGeneral cajaSoloLectura" value="<?php echo $hoy; ?>" size="10" maxlength="10" readonly="readonly"/>
							<img height="16" border="0" width="16" id="Calendario1" name="Calendario1" src="<?=$base_url;?>images/calendario.png?=<?=IMG;?>"/>
							<script type="text/javascript">
								Calendar.setup({
									inputField: "fecha",
									ifFormat: "%d/%m/%Y",
									button: "Calendario1"
								});
							</script>
						</td>

						<td width="30%" valign="middle">
							Tipo de Documento: &nbsp;&nbsp;&nbsp;
							<select id="tipoComprobante" name="tipoComprobante" class="comboMedio">
								<option value="F" <?=(isset($tipoComprobante) && $tipoComprobante == "F") ? "selected" : "" ?>>FACTURA</option>
								<option value="B" <?=(isset($tipoComprobante) && $tipoComprobante == "B") ? "selected" : "" ?>>BOLETA</option>
								<option value="N" <?=(isset($tipoComprobante) && $tipoComprobante == "N") ? "selected" : "" ?>>COMPROBANTE</option>
							</select>
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

	          		 <?php
	          	}
	          	else { ?>
	          		<input type="hidden" name="proveedor" id="proveedor" size="5" value="<?php echo $proveedor ?>"/>
	          		<input name="buscar_proveedor" type="text" class="cajaGeneral" id="buscar_proveedor" size="10" placeholder="ruc" value="<?php echo $ruc_proveedor; ?>" title="Ingrese parte del nombre o el nro. de documento, luego presione ENTER."/>&nbsp;
	          		<input type="hidden" name="ruc_proveedor" class="cajaGeneral" id="ruc_proveedor" size="10" maxlength="11" onblur="obtener_proveedor();" value="<?php echo $ruc_proveedor; ?>" placeholder="ruc" onkeypress="return numbersonly(this,event,'.');"/>
	          		<input type="text" name="nombre_proveedor" class="cajaGeneral cajaSoloLectura" id="nombre_proveedor" size="25" maxlength="50" placeholder="razon social" value="<?php echo trim($nombre_proveedor, '"'); ?>"/>
	          		 <?php
	          	} 
	          	//$this->load->view('layout/modalClienteNuevo'); ?>
	          	<button type="button" class="btn btn-default" data-target="#modal_addcliente" data-toggle="modal">NUEVO</button>
	     </td>
		 <td colspan="2">
  <table style="width: 100%;">
    <tr>
      <td style="padding-right: 10px;">
        <label for="cboVendedor">Vendedor * </label>
      </td>
      <td>
        <select id="cboVendedor" name="cboVendedor" class="comboGrande" style="width: 200px;">
          <?=$cboVendedor;?>
        </select>
      </td>
    </tr>
    <tr>
        <td>Comprador :</td>
        <td>
            <input name="comprador" type="text" id="comprador" class="cajacomprador" value="<?php echo $comprador; ?>" style="color: black; font-size: 12px;">
        </td>
    </tr>
    <tr>
      <td style="padding-right: 10px;">
        <label for="descuento">Descuento </label>
      </td>
      <td>
        <input name="descuento" type="number" class="cajaGeneral" id="descuento" min="0" max="100" step="0.1" value="<?php echo $descuento; ?>" onKeyPress="return numbersonly(this,event,'.');" onBlur="calcular_totales_tempdetalle();" style="width: 50px;" /> %
      </td>
    </tr>
  </table>
</td>

      </td>
      </tr>
      <tr>
      	<td>Contacto</td>
      	<td>
      		<?php
      		if ($tipo_oper == 'C') { ?>
      			<select name="contacto" id="contacto" class="comboGrande"><?php echo $cboContacto; ?></select><?php
      		} elseif($tipo_oper == 'V') { ?>
				<select name="contacto" id="contacto" class="comboGrande"><?php echo $cboContacto; ?></select>
			<?php }
      		?>
      	</td>

      	<td align="left" colspan="3">Forma Pago
      		<?php echo $cboFormapago; ?>

      		&nbsp;&nbsp;&nbsp;
      		Moneda *
      		<select name="moneda" id="moneda" class="comboMedio" onchange="seleccionarMoneda(event)">
      			<?php echo $cboMoneda; ?>
      		</select>
      		<script>
      			function seleccionarMoneda(event) {
      				var id = event.target.value;
      				$("#tdc-opcional").css('display', id == 4 ? '' : 'none');
      			}
      			$(function() {
      				$("#moneda").trigger('change');
      			});
      		</script>
      	</td>
      </tr>
      <tr>
          
      	<td>N° orden de compra</td>
      	<td>
      		<input name="ordencompraempresa" type="text" id="ordencompraempresa" class="cajaMedia" value="<?=$ordencompraempresa;?>">
      	</td>

      	<td colspan="2" align="left">Almacen: <?=$cboAlmacen;?></td>
      </tr>
      <tr>
	    <td style="display:none">Proyecto *</td>
      	<td style="display:none">
      		<select id="obra" name="proyecto" class="cajaMedia">
      			<?php echo $cboObra;?>
      		</select>
      	</td>
      	<td style="display:none">Categoria del cliente</td>
      	<td style="display:none">
      		<?php if ( !isset($TIPCLIP_Codigo) ) $TIPCLIP_Codigo = 0; ?>
      		<select name="TipCli" id="TipCli" class="comboGrande">
      			<option value="0"> :: SELECCIONE :: </option><?php
            foreach ($categorias_cliente as $i => $val){ ?>
              <option value="<?=$val->TIPCLIP_Codigo;?>" <?=($val->TIPCLIP_Codigo == $TIPCLIP_Codigo) ? 'selected' : '';?>><?=$val->TIPCLIC_Descripcion;?></option> <?php
            } ?>
      		</select>
      	</td>
      </tr>
    </table>
  </div>
  <div id="frmBusqueda" class="box-add-product" style="text-align: right;" >
  	<a href="#" id="addItems" name="addItems" style="color:#ffffff;" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" data-backdrop="static" onclick="limpiar_campos_modal(); ">Agregar Items</a></td>
  </div>
  <!-- TABLA DETALLE DE TEMPORAL -->
  <?php $this->load->view('maestros/temporal_subdetalles'); ?>
  <!-- FIN DE TABLA TEMPORAL DETALLE -->
          <div id="frmBusqueda3">
          	<table border="0" align="center" cellpadding='3' cellspacing='0' class="fuente8" style="position: relative">
          		<tr>
          			<td width="82%">
          				<table border="0" align="left" cellpadding='3' cellspacing='0' style="font: 8pt helvetica;" width="100%">
          					<tr>
          						<td colspan="2" height="25"><b>INFORMACION DE LA ENTREGA </b></td>
          					</tr>
          					<tr>
          						<td width="10%">Lugar de entrega</td>
          						<td width="50%">
          							<input type="text" id="envio_direccion" value="<?php echo $envio_direccion; ?>" name="envio_direccion" class="cajaGeneral" size="56" maxlength="250"/>
          							<a href="javascript:;" id="linkVerDirecciones"> <img src="<?=$base_url;?>images/ver.png?=<?=IMG;?>" border="0"/> </a>

          							<div id="lista_direcciones" class="cuadro_flotante" style="width:305px; height:100px;">
          								<ul></ul>
          							</div>
          						</td>
          					</tr>
          					<tr>
          						<td>Facturar en</td>
          						<td><input type="text" id="fact_direccion" value="<?php echo $fact_direccion; ?>" name="fact_direccion" class="cajaGeneral" size="56" maxlength="250"/>
          							<a href="javascript:;" id="linkVerDirecciones_fact">
          								<img src="<?=$base_url;?>images/ver.png?=<?=IMG;?>" border="0"/>
          							</a>

          							<div id="lista_direcciones_fact" class="cuadro_flotante" style="width:305px; height:100px;">
          								<ul></ul>
          							</div>
          						</td>
          						<td>Fecha límite entrega</td>
          						<td><input NAME="fechaentrega" id="fechaentrega" type="text" class="cajaGeneral" value="<?php echo $fechaentrega; ?>" size="10" maxlength="10"/>
          							<img height="16" border="0" width="16" id="Calendario2" name="Calendario2" src="<?=$base_url;?>images/calendario.png?=<?=IMG;?>"/>
          							<script type="text/javascript">
          								Calendar.setup({
                                            inputField: "fechaentrega",
                                            ifFormat: "%d/%m/%Y",
                                            button: "Calendario2"
                                          });
                        </script>
                      </td>
                    </tr>
                    <tr>
                    	<td>Plazo de entrega</td>
                    	<td>
                    		<input type="text" id="tiempo_entrega" value="<?php echo $tiempo_entrega; ?>" name="tiempo_entrega" class="cajaGeneral" size="56" maxlength="250"/>
                    	</td>
                    </tr>
                    <tr>
                    	<td height="25"><b>ESTADO</b></td>
                    	<td>
                    		<select name="estado" id="estado" class="comboMedio">
                    			<option <?=($estado == '1') ? 'selected' : ''; ?> value="1"> Aceptado </option>
                    			<option <?=($estado == '2') ? 'selected' : ''; ?> value="2"> Pendiente </option>
                    			<option <?=($estado == '0') ? 'selected' : ''; ?> value="0"> Anulado </option>
                    		</select>
                    	</td>
                    </tr>
                    <tr style="display: none">
                    	<td><b>CTA. CTE.</b></td>
                    	<td>&nbsp;</td>
                    </tr>
                    <tr style="display: none">
                    	<td>Cta. Cte. S/.</td>
                    	<td><input name="ctactesoles" type="text" class="cajaGeneral" size="18" maxlength="50" id="ctactesoles" value="<?php echo $ctactesoles; ?>"/>Cta. Cte. US$ <input name="ctactedolares" type="text" class="cajaGeneral" size="18" maxlength="50" id="ctactedolares" value="<?php echo $ctactedolares; ?>"/></td>
                    </tr>
                    <tr>
                    	<td height="25" colspan="4"><b>OBSERVACION</b></td>
                    </tr>
                    <tr>
                    	<td colspan="4" valign="top"><textarea id="observacion" name="observacion" class="cajaTextArea" style="width:97%" rows="4"><?php echo $observacion; ?></textarea></td>
                    </tr>
                  </table>
                </td>
                <td valign="center">
                	<table width="100%" border="0" align="top" cellpadding='3' cellspacing='0' class="">
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
                		<tr style="display: none">
                			<td class="busqueda">Percepci&oacute;n</td>
                			<td align="right">
                				<div align="right"><input class="cajaTotales" name="percepciontotal" type="text" id="percepciontotal" size="12" align="right" readonly="readonly" value="<?php echo round($percepciontotal, 2); ?>"/></div>
                			</td>
                		</tr>
                	</table>
                </td>
              </tr>
            </table>
          </div>
        	<br/>
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
      <div style="margin:10px 0 10px 0; clear:both">
      	<img id="loading" src="<?=$base_url;?>images/loading.gif?=<?=IMG;?>" style="visibility: hidden"/>
      	<?php if(($tipo_oper == 'V' && $terminado == '0' && $evaluado == '0') || ($tipo_oper == 'C' && $terminado_importacion == '0')): ?>
      	<a href="javascript:;" id="grabarOcompra"><img src="<?=$base_url;?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton"></a>
      <?php endif; ?>
      <a href="javascript:;" id="limpiarOcompra"><img src="<?=$base_url;?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton"></a>
      <a href="javascript:;" id="cancelarOcompra"><img src="<?=$base_url;?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton"></a>

      <input type="hidden" name="salir" id="salir" value="0"/>

      <?php echo $oculto ?>
      <input type="hidden" name="ordencompra" id="ordencompra" value="<?php echo $ordencompra?>">
      <input type="hidden" name="ordencompraventa" id="ordencompraventa" value="<?php echo $ordencompraventa?>">
    </div>
  </div>
</form>



<?php
$this->load->view('maestros/temporal_detalles');
?>

<?php $this->load->view('ventas/modal_clientes'); ?>
<script>
	var colors = [];
	$(function() {
		<?php if($tipo_oper == 'C'): ?>
			$(".tooltiped").tooltip();

			colors = <?php echo json_encode(isset($colors) ? $colors : array()) ?>;
		<?php endif; ?>
	});

	
</script>