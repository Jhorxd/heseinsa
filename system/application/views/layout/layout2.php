<link rel="stylesheet" href="<?php echo base_url(); ?>pos/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>pos/css/easy-autocomplete.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>pos/css/toastr.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
<script src="<?php echo base_url(); ?>pos/js/jquery-3.6.0.js"></script>
<script src="<?php echo base_url(); ?>pos/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>pos/js/fontawesome.min.js"></script>
<script src="<?php echo base_url(); ?>pos/js/jquery.easy-autocomplete.min.js"></script>
<script src="<?php echo base_url(); ?>pos/js/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>pos/js/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>pos/js/kioskboard-1.0.0.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>pos/css/kioskboard-1.0.0.css">
<style type="text/css">
	/*-- Number input --*/

	.input-number {
		position: relative;
	}

	.input-number {
		-webkit-appearance: none;
		margin: 0;
	}

	.input-number {
		-moz-appearance: textfield;
		height: 40px;
		width: 100%;
		border: 1px solid #ced4da;
		border-radius: 0.25rem;
		transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
		background-color: #FFF;
		padding: 0px 35px 0px 15px;

		/*display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;*/

	}

	.input-number:focus {
		color: #212529;
		background-color: #fff;
		border-color: #86b7fe;
		outline: 0;
		box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25)
	}

	.input-number .qty-up,
	.input-number .qty-down {
		position: absolute;
		display: block;
		width: 20px;
		height: 20px;
		border: 1px solid #ced4da background-color: #FFF;
		text-align: center;
		font-weight: 700;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	.input-number .qty-up {
		right: 0;
		top: 0;
		border-bottom: 0px;
	}

	.input-number .qty-down {
		right: 0;
		bottom: 0;
	}

	.input-number .qty-up:hover,
	.input-number .qty-down:hover {
		background-color: #E4E7ED;
		color: #D10024;
	}

	.excel-reporte {
		border: 0;
		background-color: transparent;
	}
	
	.pdf-reporte {
		border: 0;
		background-color: transparent;
	}



	#KioskBoard-VirtualKeyboard {
		width: 100%;
		height: 330px;
	}

	@media screen and (max-width: 980px) {
		div#teclado_div {
			display: none;
		}
	}


	#virtual-keyboard {
		/*border: 5px #212F3D double;*/
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		padding: 15px;
		/*background-color: #626567;*/
	}

	.keyboard-row {
		text-align: center;
		margin-bottom: 10px;
	}

	#virtual-keyboard a {
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		background: #000000;
		padding: 3px 4px;
		font-size: 18px;
		color: #ffffff;
		text-align: center;
		margin-right: 15px;
		text-decoration: none;
	}

	#virtual-keyboard a:hover {
		text-decoration: none;
		opacity: 0.8;
	}

	#ventana-flotante {
		width: 40%;
		/* Ancho de la ventana */
		height: 90px;
		/* Alto de la ventana */
		background: #bec9be;
		/* Color de fondo */
		position: fixed;
		top: 50%;
		left: 50%;
		margin-left: -180px;
		/*border: 1px solid #adffad;  /* Borde de la ventana */
		*/
		/*box-shadow: 0 5px 25px rgba(0,0,0,.1);  /* Sombra */
		*/ z-index: 999;
	}

	#ventana-flotante #contenedor {
		padding: 25px 10px 10px 10px;
	}

	#ventana-flotante .cerrar {
		float: right;
		border-bottom: 1px solid #bbb;
		border-left: 1px solid #bbb;
		color: #999;
		background: white;
		line-height: 17px;
		text-decoration: none;
		padding: 0px 14px;
		font-family: Arial;
		border-radius: 0 0 0 5px;
		box-shadow: -1px 1px white;
		font-size: 18px;
		-webkit-transition: .3s;
		-moz-transition: .3s;
		-o-transition: .3s;
		-ms-transition: .3s;
	}

	#ventana-flotante .cerrar:hover {
		background: #ff6868;
		color: white;
		text-decoration: none;
		text-shadow: -1px -1px red;
		border-bottom: 1px solid red;
		border-left: 1px solid red;
	}

	#ventana-flotante #contenedor .contenido {
		padding: 15px;
		box-shadow: inset 1px 1px white;
		background: #f2ffe8;
		/* Fondo del mensaje */
		/*border: 1px solid #9eff9e;  /* Borde del mensaje */
		*/ font-size: 20px;
		/* Tamaño del texto del mensaje */
		color: #555;
		/* Color del texto del mensaje */
		text-shadow: 1px 1px white;
		margin: 0 auto;
		border-radius: 4px;
	}

	.oculto {
		-webkit-transition: 1s;
		-moz-transition: 1s;
		-o-transition: 1s;
		-ms-transition: 1s;
		opacity: 0;
		-ms-opacity: 0;
		-moz-opacity: 0;
		visibility: hidden;
	}
	
	
	
	
	
	
	

/* Estilos para hacer la tabla responsive */
.table-responsive {
    overflow-x: auto;
}

/* Ajustar el ancho de las columnas según el contenido */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 8px;
    text-align: left;
}

/* Estilos para cuando la tabla sea muy pequeña */
   

   @media (max-width: 768px) {
    .table-responsive {
        width: 100%;
        margin-bottom: 15px;
        overflow-y: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        border: 1px solid #ddd;
    }

    .table {
        border-collapse: collapse !important;
        width: 100% !important;
        max-width: 100%;
        margin-bottom: 0;
    }

    .table-bordered {
        border: 0;
    }

    .table-responsive {
        border: 1px solid #ddd;
    }
    }



	/* Codigo modal Stock general */

	@media(max-width: 390px) {
		.table-modal-small {
			font-size: 0.8rem;
		}
	}

	@media(max-width: 325px) {
		.table-modal-small {
			font-size: 0.7rem;
		}
	}

	@media(max-width: 295px) {
		.table-modal-small {
			font-size: 0.6rem;
			
		}
	}

	@media(max-width: 270px) {
		.table-modal-small {
			font-size: 0.5rem;
			
		}
	}



	
</style>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8">
	<title>POS</title>
</head>
<style type="text/css">
	.fa,
	.fas.far,
	.fa-solid {
		cursor: pointer;
	}

	@keyframes ldio-0sdgcnk1lov {
		0% {
			opacity: 1;
			backface-visibility: hidden;
			transform: translateZ(0) scale(1.5, 1.5);
		}

		100% {
			opacity: 0;
			backface-visibility: hidden;
			transform: translateZ(0) scale(1, 1);
		}
	}

	.ldio-0sdgcnk1lov div>div {
		position: absolute;
		width: 24px;
		height: 24px;
		border-radius: 50%;
		background: #93dbe9;
		animation: ldio-0sdgcnk1lov 1s linear infinite;
	}

	.ldio-0sdgcnk1lov div:nth-child(1)>div {
		left: 148px;
		top: 88px;
		animation-delay: -0.875s;
	}

	.ldio-0sdgcnk1lov>div:nth-child(1) {
		transform: rotate(0deg);
		transform-origin: 160px 100px;
	}

	.ldio-0sdgcnk1lov div:nth-child(2)>div {
		left: 130px;
		top: 130px;
		animation-delay: -0.75s;
	}

	.ldio-0sdgcnk1lov>div:nth-child(2) {
		transform: rotate(45deg);
		transform-origin: 142px 142px;
	}

	.ldio-0sdgcnk1lov div:nth-child(3)>div {
		left: 88px;
		top: 148px;
		animation-delay: -0.625s;
	}

	.ldio-0sdgcnk1lov>div:nth-child(3) {
		transform: rotate(90deg);
		transform-origin: 100px 160px;
	}

	.ldio-0sdgcnk1lov div:nth-child(4)>div {
		left: 46px;
		top: 130px;
		animation-delay: -0.5s;
	}

	.ldio-0sdgcnk1lov>div:nth-child(4) {
		transform: rotate(135deg);
		transform-origin: 58px 142px;
	}

	.ldio-0sdgcnk1lov div:nth-child(5)>div {
		left: 28px;
		top: 88px;
		animation-delay: -0.375s;
	}

	.ldio-0sdgcnk1lov>div:nth-child(5) {
		transform: rotate(180deg);
		transform-origin: 40px 100px;
	}

	.ldio-0sdgcnk1lov div:nth-child(6)>div {
		left: 46px;
		top: 46px;
		animation-delay: -0.25s;
	}

	.ldio-0sdgcnk1lov>div:nth-child(6) {
		transform: rotate(225deg);
		transform-origin: 58px 58px;
	}

	.ldio-0sdgcnk1lov div:nth-child(7)>div {
		left: 88px;
		top: 28px;
		animation-delay: -0.125s;
	}

	.ldio-0sdgcnk1lov>div:nth-child(7) {
		transform: rotate(270deg);
		transform-origin: 100px 40px;
	}

	.ldio-0sdgcnk1lov div:nth-child(8)>div {
		left: 130px;
		top: 46px;
		animation-delay: 0s;
	}

	.ldio-0sdgcnk1lov>div:nth-child(8) {
		transform: rotate(315deg);
		transform-origin: 142px 58px;
	}

	.loadingio-spinner-spin-lvpepxs6i1 {
		width: 200px;
		height: 200px;
		display: inline-block;
		overflow: hidden;
		background: none;
	}

	.ldio-0sdgcnk1lov {
		width: 100%;
		height: 100%;
		position: relative;
		transform: translateZ(0) scale(1);
		backface-visibility: hidden;
		transform-origin: 0 0;
		/* see note above */
	}

	.ldio-0sdgcnk1lov div {
		box-sizing: content-box;
	}


	#imgload2 {
		position: fixed;
		top: 40%;
		left: 35%;
		right: 0;
		bottom: 0;
		display: flex;
		justify-content: center;
		align-items: center;
		z-index: 9999;
		transition: 1s all;
	}
</style>
<div class="col-md-12" id="imgload" style="width: 100%;background-color: #c1c1d536;position: fixed;height: 100%;display: none;">
	<img src="<?php echo base_url(); ?>images/load2.gif" id="imgload2">
</div>
<input type="hidden" id="numero_temporal">

<script type="text/javascript">
	KioskBoard.Init({
		keysArrayOfObjects: null,
		keysJsonUrl: '<?php echo base_url(); ?>pos/kioskboard-keys.json',
		specialCharactersObject: null,
		keysSpecialCharsArrayOfStrings: [".", ","],
		language: 'en',
		theme: 'light',
		capsLockActive: true,
		allowRealKeyboard: false,
		cssAnimations: true,
		cssAnimationsDuration: 360,
		cssAnimationsStyle: 'slide',
		keysAllowSpacebar: true,
		keysSpacebarText: 'Space',
		keysFontFamily: 'sans-serif',
		keysFontSize: '18px',
		keysFontWeight: 'normal',
		keysIconSize: '19px',
	});
</script>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-4">
				<img src="<?php echo base_url(); ?>/assets/img/logo_pos.png">
			</div>
			<!--     		
					<div class="col-md-2" id="teclado_div">
    			Teclado Virtual <input type="checkbox" data-toggle="toggle" data-size="sm" data-on="SI" data-off="NO" id="teclado">
    			<input type="hidden" id="teclado_hidden">
    			<input type="hidden" id="producto_hidden">
    			</div> 
    		-->


			<div class="col-md-2" id="usuario_venta">
				Usuario: <b><?php echo $usuario; ?></b>
			</div>

			<div class="col-md-2">
				<label id="see_last_sell" style="cursor:pointer;">Última Venta <i class="fa-solid fa-money-bill" style="color:green;"></i></label>
			</div>

			<div class="col-md-2">
				Establecimiento: <b><?php echo $nombre_sucursal; ?></b>
			</div>

			<div class="col-md-2" align="right">
				<label>Salir de POS</label>
				<i class="fa-solid fa-right-from-bracket" id="salir_pos"></i>
				<div>
					<a style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; color: #000000; text-decoration: none;" href="<?= site_url('index/salir_sistema'); ?>">Salir del Sistema</a>
				</div>
			</div>
		</div>
	</div>
</div>
<br>
<!-- REPORTE -->
<div class="row mb-2">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header d-flex justify-content-around align-items-center">
				<h5 class="m-0">REPORTE DE VENTAS DIARIO</h5>
				<button class="excel-reporte">
					<iconify-icon style="font-size:2rem" icon="vscode-icons:file-type-excel"></iconify-icon>
				</button>
				<!-- CODIGO COLOCADO POR EL DESARROLLADOR ALDO -->
				<button onclick="reportePdf()" class="pdf-reporte">
					<iconify-icon style="font-size:2rem" icon="vscode-icons:file-type-pdf2"></iconify-icon>
				</button>
			</div>
		</div>
	</div>
</div>

<!-- REPORTE -->

<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<input type="hidden" id="moneda" name="moneda" value="1">
				<input type="hidden" id="flagBS" value="B">
				<!--<input type="hidden" id="almacen" value="1">-->
				<input type="hidden" id="cliente">
				<input type="hidden" id="last_sell">
				<input type="hidden" id="last_sell_tipo">
				<input type="hidden" id="tipo_persona">
				<input type="hidden" id="fecha_temp" value="<?php echo date("Y-m-d"); ?>">

				<input type="hidden" id="tdcDolar" value="<?php echo $tdcDolar; ?>">
				<input type="hidden" id="sucursal" value="<?php echo $sucursal; ?>"> <!---->
				<form id="frmComprobante">
					<input type="hidden" name="datos" id="datos">
				</form>
				<div class="row">
					<div class="col-md-6" id="ch">Tipo de Comprobante</div>
					<div class="col-md-6">
						<select class="form-control" id="cboTipoDocu">
							<option value="B">BOLETA</option>
							<option value="F">FACTURA</option>
							<option value="N">NOTA DE SALIDA</option>
						</select>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">RUC/DNI</div>
							<div class="col-md-12"><input id="ruc_cliente" name="ruc_cliente" type="text" class="form-control teclado" data-kioskboard-specialcharacters="true" data-kioskboard-type="all" onclick="ver_teclado('ruc_cliente')"></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">Nombre/Razón Social <i class="fa-solid fa-circle-plus" id="modal_d">Nuevo</i></div>
							<div class="col-md-12"><input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control teclado" data-kioskboard-specialcharacters="true" data-kioskboard-type="all" onclick="ver_teclado('nombre_cliente')"></div>
						</div>
					</div>
					<div class="col-md-12" style="display:none;">
						<div class="row">
							<div class="col-md-12">Dirección</div>
							<div class="col-md-12">
								<select id="direccionsuc" name="direccionsuc" class="form-control"></select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">Vendedor</div>
							<div class="col-md-12">
								<select class="form-control" id="cboVendedor">
									<option value="">Seleccione</option>
									<?php foreach ($cboVendedor as $key => $value) { ?>
										<option value="<?php echo $value->PERSP_Codigo; ?>"><?php echo $value->PERSC_Nombre . "-" . $value->PERSC_ApellidoPaterno; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">Categoria de Precios</div>
							<div class="col-md-12">
								<select class="form-control" id="TipCli">
									<?php foreach ($Categorias as $key => $value) { ?>
										<option value="<?php echo $value->TIPCLIP_Codigo; ?>"><?php echo $value->TIPCLIC_Descripcion; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">TIPO DE PAGO <i class="fa-solid fa-circle-plus" id="modal_d">Nuevo</i></div>
                            <div class="col-md-12">
                                <select class="form-control" id="condiciones_pago" name="condiciones_pago" onchange="ver_tipo_pago()">
                                    <?php foreach ($cboFormaPago as $key => $value) { ?>
                                    <option value="<?php echo $value->FORPAP_Codigo; ?>"><?php echo $value->FORPAC_Descripcion; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

            
				</div>
				<div class="row">
					<div class="col-md-12" style="padding-top: 10px;">
						<div class="card">
							<div class="card-header">
							</div>
							<div class="card-body">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th scope="col" style="width: 40%;">Producto</th>
											<th scope="col" style="width: 15%;">Precio</th>
											<th scope="col" style="width: 25%;">Cantidad</th>
											<th scope="col" style="width: 15%;">Total</th>
											<?php 
											$this->load->library('session');
											$rol = $this->session->userdata('rol');
											?>
											<th scope="col" style="width: 05%;"></th>
											<input type="hidden" id="rol" value="<?php echo $rol ?>">
										</tr>
									</thead>
									<tbody id="tbody_productos">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row" style="padding: 10px;">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">Subtotal</div>
							<div class="col-md-6">S./<label id="subtotal">0</label></div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">IGV</div>
							<div class="col-md-6">S./<label id="igv">0</label></div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">Total</div>
							<div class="col-md-6">S./<label id="total">0</label></div>
						</div>
					</div>
					<div class="col-md-12">
						<br>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6" align="center">
								<button type="button" class="btn btn-danger" id="cancelar" style="width: 100%!important;height: 60px!important;">Cancelar Venta</button>
							</div>
							<div class="col-md-6" align="center">
								<button type="button" class="btn btn-success" id="procesar" style="width: 100%!important;height: 60px!important;">Procesar Venta</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-2">
						Productos
					</div>
					<div class="col-md-6">
						<select id="almacen" name="almacen" class="form-control" onchange="cargar_favoritos()">
							<?php
							foreach ($almacenes as $key => $value) {
							?><option value="<?= $value->ALMAP_Codigo; ?>"><?= $value->ALMAC_Descripcion; ?></option><?php
																													}
																														?>
						</select>
					</div>
					<div class="col-md-2" style="cursor:pointer;" id="fav_reload">
						<i class="fa-solid fa-rotate-left"></i> Actualizar
					</div>
					<div class="col-md-2" align="center">
						<div class="row">
							<div class="col-md-10" align="right" style="padding-right: 0;">
								<i class="fa-solid fa-star" style="font-size: 20px;cursor: auto;"></i>
							</div>
							<div class="col-md-1" align="left">
								<i style="padding-top: 0px;font-size: 14px;color: #db3434;" data-html="true" data-toggle="popover" data-bs-trigger="hover" title="Favoritos" data-bs-content="
  						<div class='row'>
  							<div class='col-md-12'><i class='fa-solid fa-star' style='color:green;'></i>Marcado como Favorito</div>
  							<div class='col-md-12'><i class='fa-solid fa-star' style='color:#bdbdbd'></i>Marcado como Normal</div>
  							<div class='col-md-12'><hr></div>
  							<div class='col-md-12'>*Los Productos Marcados como <b>Favoritos</b> se Cargan al Iniciar POS</div>
  						</div>" class="fa-solid fa-circle-question"></i>
							</div>
							<div class="col-md-1" align="left">
							</div>
						</div>

					</div>
				</div>

			</div>

			<div class="container">
			<hr>
				<div class="row">
					<div class="col-2"></div>
					<div class="col-8 text-center">
						<h6>Buscar un Producto o Servicio</h6>
						<div class="d-flex justify-content-center">
							<img src="<?=base_url();?>images/icono.png" style="width: 80px" />
						</div>
					</div>
					<div class="col-2"></div>
				</div>
			</div>

			<div id='ventana-flotante' class="oculto" style="z-index: 4000!important;">
				<div class="card" style="background-color: #ffffff00;">
					<div class="card-body" style="background-color: #bfbfbf;border-radius: 30px;">
						<a class='cerrar' onclick="cerrar_teclado()" style="cursor: pointer;">x</a>
						<div id='contenedor' class="container" style="">
							<div class='contenido'>
								<div class="row">
									<div id="content" class="col-lg-12">

										<div id="virtual-keyboard">
											<div class="keyboard-row">
												<a class="number" href="#" data="1">1</a>
												<a class="number" href="#" data="2">2</a>
												<a class="number" href="#" data="3">3</a>
												<a class="number" href="#" data="4">4</a>
												<a class="number" href="#" data="5">5</a>
												<a class="number" href="#" data="6">6</a>
												<a class="number" href="#" data="7">7</a>
												<a class="number" href="#" data="8">8</a>
												<a class="number" href="#" data="9">9</a>
												<a class="number" href="#" data="0">0</a>
											</div>
											<div class="keyboard-row">
												<a href="#" data="Q">Q</a>
												<a href="#" data="W">W</a>
												<a href="#" data="E">E</a>
												<a href="#" data="R">R</a>
												<a href="#" data="T">T</a>
												<a href="#" data="Y">Y</a>
												<a href="#" data="U">U</a>
												<a href="#" data="I">I</a>
												<a href="#" data="O">O</a>
												<a href="#" data="P">P</a>
											</div>
											<div class="keyboard-row">
												<a href="#" data="A">A</a>
												<a href="#" data="S">S</a>
												<a href="#" data="D">D</a>
												<a href="#" data="F">F</a>
												<a href="#" data="G">G</a>
												<a href="#" data="H">H</a>
												<a href="#" data="J">J</a>
												<a href="#" data="K">K</a>
												<a href="#" data="L">L</a>
												<a href="#" data="Ñ">Ñ</a>
											</div>
											<div class="keyboard-row">
												<a href="#" data="Z">Z</a>
												<a href="#" data="X">X</a>
												<a href="#" data="C">C</a>
												<a href="#" data="V">V</a>
												<a href="#" data="B">B</a>
												<a href="#" data="N">N</a>
												<a href="#" data="M">M</a>
											</div>
											<div class="keyboard-row">
												<a href="#" data=" ">ESPACIO</a>
												<a href="#" data="DEL">BORRAR</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>



			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<input type="text" placeholder="Ingrese el producto o servicio..." class="form-control teclado" data-kioskboard-type="all" data-kioskboard-specialcharacters="true" id="search" autocomplete="off" onclick="ver_teclado('search');">
					</div>
					<div class="col-md-12" align="center">
						<div id="search_msj" style="display:block;" class="msj">
							<!-- <i class="fa-solid fa-arrow-up-wide-short" style="padding-top: 30px;font-size: 30px;"></i>
							<br>
							<label>Buscar un Producto o Servicio</label> -->
						</div>
						<div id="empty_msj" style="display:none;" class="msj">
							<i class="fa-solid fa-ban" style="padding-top: 30px;font-size: 30px;"></i>
							<br>
							<label>Sin Resultados</label>
						</div>
						<div id="search_result" align="center">
							<hr>
							<div class="row" id="results" align="center">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal hide fade in" data-keyboard="false" data-backdrop="static" id="modal_pago">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Pagar</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<!--
  				<div class="col-md-6">
  					<label>Forma de Pago</label>
  					<select id="forma_pago" class="form-control" onchange="necesitaCuota()">
  						<?php
							foreach ($cboFormaPago as $key => $value) {
							?><option value="<?= $value->FORPAP_Codigo; ?>"><?= $value->FORPAC_Descripcion; ?></option><?php
																													}
																														?>
  					</select>
  				</div>
  				 -->
					<div class="col-md-6">
						<label>Caja</label>
						<select class="form-control" id="caja">
							<option value="">Seleccionar</option>
							<?php
							foreach ($cajas as $key => $value) {
							?><option value="<?= $value->CAJA_Codigo; ?>"><?= $value->CAJA_Nombre; ?></option><?php
																											}
																												?>
						</select>

					</div>

					<div class="col-md-12" style="display:none;">
						<label>Condiciones de Pago</label>
						<input type="text" readonly="true" id="condiciones_de_pago" class="form-control">
					</div>



					<div class="col-md-12" id="div_mostrar_cuotas" style="display:none;padding: 10px;" align="right">
						<div>
							<button type="button" class="btn btn-danger del-cuota">-</button>
							<input type="number" min="0" step="1" id="cant-cuotas" name="cant-cuotas" class="form-control" style="display: inline-block;width: 75px;padding: 2px 12px;height: 32px;text-align: center;" value="0" readOnly>
							<button type="button" class="btn btn-success add-cuota">+</button>
						</div>
						<div class="table-responsive">
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
						<button type="button" class="btn btn-info btn-cuota-recalc">Recalcular</button>
					</div>

					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4">
								<label>Total:</label><input type="text" id="total_temp" class="form-control" readonly="true">
							</div>
							<div id="monto_temp1" class="col-md-4">
								<label>Monto:</label><input type="text" onclick="ver_teclado('monto_temp')" onblur="calcular_vuelto()" onkeyup="calcular_vuelto()" id="monto_temp" name="monto_temp" class="form-control teclado" data-kioskboard-specialcharacters="true" data-kioskboard-type="all">
							</div>
							<div id="vuelto_temp1" class="col-md-4">
								<label>Vuelto:</label><input type="text" id="vuelto_temp" class="form-control" readonly="true">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<label>Observaciones:</label><input type="text" id="observaciones" data-kioskboard-specialcharacters="true" data-kioskboard-type="all" onclick="ver_teclado('observaciones')" class="form-control teclado">
							</div>
						</div>
					</div>
					<div class="col-md-6" align="left" style="padding: 10px;">
						<button type="button" class="btn btn-secondary" id="modal_atras">Atrás</button>
					</div>
					<div class="col-md-6" style="padding: 10px;" id="div_generar" align="right">
						<button type="button" class="btn btn-primary btn-cuota-acept">Generar</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_ticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12" id="pdf">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="close_modal_ticket" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>



<div id="modal_addcliente" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form id="formCliente" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
				</div>
				<div style="text-align: center;">
					<h3><b>REGISTRAR CLIENTE</b></h3>
				</div>
				<div class="modal-body panel panel-default">
					<!-- <input type="hidden" id="cliente" name="cliente" value=""> -->
					<input type="hidden" id="operacionE" name="operacionE" value="">

					<div class="row form-group">
						<div class="col-md-12" style="background-color: #76768d70;color: black;" align="center">
							<label>INFORMACIÓN DEL CLIENTE</label>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-12 col-md-3 col-lg-3">
							<label for="tipo_cliente">Tipo de cliente</label>
							<select id="tipo_cliente" name="tipo_cliente" class="form-control h-3 w-porc-90">
								<option value="0">NATURAL</option>
								<option value="1" selected>JURIDICO</option>
							</select>
						</div>
						<div class="col-sm-12 col-md-3 col-lg-3">
							<label for="tipo_documento">Tipo de documento</label>
							<select id="tipo_documento" name="tipo_documento" class="form-control h-3 w-porc-90">
								<optgroup label="Natural" disabled class="documentosNatural"> <?php
																								foreach ($documentosNatural as $i => $val) { ?>
										<option class="DOC0" value="<?= $val->TIPDOCP_Codigo; ?>"><?= $val->TIPOCC_Inciales; ?></option> <?php
																																		} ?>
								</optgroup>

								<optgroup label="Juridico" class="documentosJuridico"> <?php
																						foreach ($documentosJuridico as $i => $val) { ?>
										<option class="DOC1" value="<?= $val->TIPCOD_Codigo; ?>"><?= $val->TIPCOD_Inciales; ?></option> <?php
																																	} ?>
								</optgroup>

							</select>
						</div>
						<div class="col-sm-12 col-md-3 col-lg-3">
							<label for="numero_documento">Número de Doc. (*)</label>
							<input type="text" id="numero_documento" name="numero_documento" class="form-control h-2 w-porc-90 teclado" placeholder="Número de documento" value="" autocomplete="off">
						</div>
						<div class="col-sm-12 col-md-3 col-lg-3">&nbsp;<br>
							<button type="button" class="btn btn-default btn-search-sunat" onclick="getSunat()">
								<img style="width: 40px;" src="<?= base_url(); ?>images/sunat.png" class='image-size-2' />

							</button>
							<img id="img_load" style="width: 40px; display: none;" src="<?= base_url(); ?>images/load.gif" class='image-size-2' />
							<span class="icon-loading-lg"></span>
						</div>
					</div>

					<!--********** JURIDICO **********-->
					<div class="row form-group divJuridico">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<label for="razon_social">Razón social (*)</label>
							<input type="text" id="razon_social" name="razon_social" class="form-control h-2 teclado" placeholder="Indique la razón social" value="" autocomplete="off">
						</div>
					</div>

					<!--********** NATURAL **********-->
					<div class="row form-group divNatural" style="display: none;">
						<div class="col-sm-12 col-md-4 col-lg-4">
							<label for="nombres">Nombres (*)</label>
							<input type="text" id="nombres" name="nombres" class="form-control h-2 w-porc-90" placeholder="Indique el nombre completo" value="" autocomplete="off">
						</div>
						<div class="col-sm-12 col-md-4 col-lg-4">
							<label for="apellido_paterno">Apellido paterno (*)</label>
							<input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control h-2 w-porc-90" placeholder="Indique el apellido paterno" value="" autocomplete="off">
						</div>
						<div class="col-sm-12 col-md-4 col-lg-4">
							<label for="apellido_materno">Apellido materno (*)</label>
							<input type="text" id="apellido_materno" name="apellido_materno" class="form-control h-2 w-porc-90" placeholder="Indique el apellido materno" value="" autocomplete="off">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12 form-group">
							<label for="direccion">Dirección (*)</label>
							<textarea id="direccion" name="direccion" class="form-control h-4 teclado" placeholder="Indique la dirección"></textarea>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-12" style="background-color: #76768d70;color: black;" align="center">
							<label>INFORMACIÓN DE CONTACTO</label>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-12 col-md-4 col-lg-4">
							<label for="telefono">Telefono</label>
							<input type="tel" id="telefono" name="telefono" class="form-control teclado" placeholder="000 000 000" val="" autocomplete="off">
						</div>
						<div class="col-sm-12 col-md-4 col-lg-4">
							<label for="movil">Movil</label>
							<input type="tel" id="movil" name="movil" class="form-control teclado" placeholder="000 000 000" val="" autocomplete="off">
						</div>
						<div class="col-sm-12 col-md-4 col-lg-4">
							<label for="correo">Correo</label>
							<input type="email" id="correo" name="correo" class="form-control teclado" placeholder="cliente@empresa.com" val="" autocomplete="off">
						</div>

					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="registrar_cliente()">Guardar Registro</button>
					<button type="button" class="btn btn-info" onclick="clean()">Limpiar</button>
					<button type="button" class="btn btn-default" id="cerrar_cliente">Salir</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Modal de Stock -->
<div class="modal fade" id="StockModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Stock General</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table class="table table-striped table-hover table-modal-small">
					<thead>
						<tr>
							<th scope="col">Compañia</th>
							<th scope="col">Sucursal</th>
							<th scope="col">Almacen</th>
							<th scope="col">Stock</th>
						</tr>
					</thead>
					<tbody id="res">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_ticket2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> -->
      <div class="modal-body">
        <div class="row">
			<div class="col-12">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<iframe id="pdfFrame" width="100%" height="500px" frameborder="0"></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" id="close_modal_ticket2" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

<script type="text/javascript">
	var base_url = "<?php echo base_url(); ?>";
	var compania = "<?php echo $compania; ?>";
	
	
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>pos/js/main.js"></script>
<script type="text/javascript">
	cargar_productos(<?php echo json_encode($favoritos); ?>);
	$(function() {
		$("[data-toggle=popover]").popover({
			html: true,
			sanitize: false,
		});
	});
	

	$("#virtual-keyboard a").on('click', function() {
		var input = $("#teclado_hidden").val();
		if ($(this).attr('data') == 'DEL') {
			board_text = $('#' + input).val();
			board_text = board_text.substring(0, board_text.length - 1);
			$('#' + input).val(board_text);
		} else {
			$('#' + input).val($('#' + input).val() + $(this).attr('data'));
		}

		$("#" + input).focus();

		if (input == 'search') {
			search();
		}

		var valid = "precio" + $("#producto_hidden").val();
		var id_valid = $("#producto_hidden").val();
		if (input == valid) {
			console.log(id_valid);
			cantidad(id_valid, 1);
			cantidad(id_valid, 2);
		}

	});
	
	function ver_tipo_pago() {
    var selectedValue = $("#condiciones_de_pago").val();
    // Realiza aquí la lógica que desees con el valor seleccionado
    }


	// function ver_teclado(input,id=0)
	// {
	// 	if ($("#teclado").prop("checked")) 
	// 	{
	// 		//$("#teclado_hidden").val(input);

	// 		$('#'+input).mlKeyboard({
	// 		  layout: 'en_US'
	// 		});

	// 		//$("#ventana-flotante").removeClass("oculto");
	// 		$("#producto_hidden").val("");
	// 	}
	// 	if (id>0) 
	// 	{
	// 		$("#producto_hidden").val(id);
	// 	}



	// }

	$("#teclado").change(function() {
		if ($("#teclado").prop("checked")) {
			mostrar_teclado();
		} else {
			ocultar_teclado();
		}
	});

	$(".excel-reporte").click(function() {

		let user = $("#usuario_venta").text();
		user = user.split(": ");

		let currentDate = new Date();
		let day = currentDate.getDate();
		let month = currentDate.getMonth() + 1;
		let year = currentDate.getFullYear();

		currentDate = `${year}-${month}-${day}`;

		location.href = "<?= base_url(); ?>index.php/reportes/ventas/ventasDiarias/" + currentDate + "/"+ user[1];
	});
	
	// $(".pdf-reporte").click(function() {
	// let user = $("#usuario_venta").text();
	// user = user.split(": ");
	// let currentDate = new Date();
	// let day = currentDate.getDate();
	// let month = currentDate.getMonth() + 1;
	// let year = currentDate.getFullYear();
	// currentDate = `${year}-${month}-${day}`;
	// location.href = "<?= base_url(); ?>index.php/reportes/ventas/ventasDiarias_pdf/" + currentDate + "/"+ user[1];
	// });
	
	//ES LA FUNCION QUE SIRVE PARA INPRIMIR EN FORMATO PDF ventasDiarias_pdf
	//CODIGO CREADO POR EL DESARROLLADOR ALDO
	function reportePdf() {
		let user = $("#usuario_venta").text();
		user = user.split(": ");
		let currentDate = new Date();
		let day = currentDate.getDate();
		let month = currentDate.getMonth() + 1;
		let year = currentDate.getFullYear();
		currentDate = `${year}-${month}-${day}`;
		let pdfUrl = "<?= base_url(); ?>index.php/reportes/ventas/ventasDiarias_pdf/" + currentDate + "/" + user[1];
		fetch(pdfUrl)
			.then(response => response.blob())
			.then(blob => {
				const url = window.URL.createObjectURL(blob);
				$("#pdfFrame").attr("src", url);
				$("#modal_ticket2").modal("show");
				const a = document.createElement('a');
            a.href = url;
            a.download = 'TICKET.pdf';
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
            a.onload = function() {
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            };
			})
			.catch(error => {
				console.error('Error:', error);
			   });
	}
	// function reportePdf() {
	// 	let user = $("#usuario_venta").text();
	// 	user = user.split(": ");
	// 	let currentDate = new Date();
	// 	let day = currentDate.getDate();
	// 	let month = currentDate.getMonth() + 1;
	// 	let year = currentDate.getFullYear();
	// 	currentDate = `${year}-${month}-${day}`;
	// 	let pdfUrl = "<?= base_url(); ?>index.php/reportes/ventas/ventasDiarias_pdf/" + currentDate + "/" + user[1];
	// 	fetch(pdfUrl)
	// 		.then(response => response.blob())
	// 		.then(blob => {
	// 			const url = window.URL.createObjectURL(blob);
	// 			$("#pdfFrame").attr("src", url);
	// 			$("#modal_ticket2").modal("show");
	// 		})
	// 		.catch(error => {
	// 			console.error('Error:', error);
	// 		   });
	// }

	//mostrar_teclado();

	function ver_teclado(input, id = 0) {
		if ($("#teclado").prop("checked")) {
			$("#producto_hidden").val("");
		}
		if (id > 0) {
			$("#producto_hidden").val(id);
		}
	}

	function ocultar_teclado() {
		$(".teclado").addClass("noteclado");
		$(".noteclado").removeClass("teclado");
	}

	function mostrar_teclado() {
		$(".noteclado").addClass("teclado");
		$(".teclado").removeClass("noteclado");
		KioskBoard.Run(".teclado");

	}

	function cerrar_teclado() {
		$("#ventana-flotante").addClass("oculto");
	}
</script>