<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>

<div class="container-fluid">
	<div class="row header">
		<div class="col-md-12 col-lg-12">
			<div><?=$titulo_busqueda;?></div>
		</div>
	</div>
	<form id="form_busqueda" method="post">
		<div class="row fuente8 py-1">
			<div class="col-sm-2 col-md-2 col-lg-2">
				<label for="search_documento">Número de documento</label>
				<input type="text" name="search_documento" id="search_documento" value="" placeholder="Documento" class="form-control h-1 w-porc-90" autocomplete="off"/>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<label for="nombre_proveedor">Razón social / Nombre</label>
				<input type="text" name="nombre_proveedor" id="nombre_proveedor" value="" placeholder="Buscar proveedor" class="form-control h-1 w-porc-90" autocomplete="off"/>
			</div>
		</div>
	</form>
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12 pall-0">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12 pall-0">
					<div class="acciones">
						<div id="botonBusqueda">
							<ul class="lista_botones">
								<li id="nuevo" data-toggle='modal' data-target='#modal_addproveedor'>Proveedor</li>
							</ul>
							<ul id="limpiarC" class="lista_botones">
								<li id="limpiar">Limpiar</li>
							</ul>
							<ul id="buscarC" class="lista_botones">
								<li id="buscar">Buscar</li>
							</ul> 
						</div>
						<div id="lineaResultado">Registros encontrados</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12 pall-0">
					<div class="header text-align-center"><?=$titulo_tabla;?></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12 pall-0">
					<table class="fuente8 display" id="table-proveedor">
						<div id="cargando_datos" class="loading-table">
							<img src="<?=base_url().'images/loading.gif?='.IMG;?>">
						</div>
						<thead>
							<tr class="cabeceraTabla">
								<td style="width:10%" data-orderable="true">DOCUMENTO</td>
								<td style="width:15%" data-orderable="true">NÚMERO</td>
								<td style="width:51%" data-orderable="true">NOMBRE Ó RAZÓN SOCIAL</td>
								<td style="width:04%" data-orderable="false"></td>
								<td style="width:04%" data-orderable="false"></td>
								<td style="width:04%" data-orderable="false"></td>
								<td style="width:04%" data-orderable="false"></td>
								<td style="width:04%" data-orderable="false"></td>
								<td style="width:04%" data-orderable="false"></td>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL PROVEEDOR-->
<div id="modal_addproveedor" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog w-porc-80">
		<div class="modal-content">
			<form id="formProveedor" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
				</div>
				<div style="text-align: center;">
					<h3><b>REGISTRAR PROVEEDOR</b></h3>
				</div>
				<div class="modal-body panel panel-default">
					<input type="hidden" id="proveedor" name="proveedor" value="">

					<div class="row form-group">
						<div class="col-sm-11 col-md-11 col-lg-11 header form-group">
							<span>INFORMACIÓN DEL PROVEEDOR</span>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="tipo_cliente">Tipo de proveedor</label>
							<select id="tipo_cliente" name="tipo_cliente" class="form-control h-3 w-porc-90">
								<option value="0">NATURAL</option>
								<option value="1" selected>JURIDICO</option>
							</select>
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="tipo_documento">Tipo de documento</label>
							<select id="tipo_documento" name="tipo_documento" class="form-control h-3 w-porc-90">
								<optgroup label="Natural" disabled class="documentosNatural"><?php
									foreach ($documentosNatural as $i => $val){ ?>
										<option class="DOC0" value="<?=$val->TIPDOCP_Codigo;?>"><?=$val->TIPOCC_Inciales;?></option><?php
									} ?>
								</optgroup>

								<optgroup label="Juridico" class="documentosJuridico"> <?php
									foreach ($documentosJuridico as $i => $val){ ?>
										<option class="DOC1" value="<?=$val->TIPCOD_Codigo;?>"><?=$val->TIPCOD_Inciales;?></option><?php
									} ?>
								</optgroup>
							</select>
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="numero_documento">Número de documento (*)</label>
							<input type="number" id="numero_documento" name="numero_documento" class="form-control h-2 w-porc-90" placeholder="Número de documento" value="" autocomplete="off">
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">&nbsp;<br>
							<button type="button" class="btn btn-default btn-search-sunat">
								<img src="<?=$base_url;?>images/sunat.png" class='image-size-2'/>
							</button>
							<span class="icon-loading-lg"></span>
						</div>
					</div>

					<!-- JURIDICO -->
					<div class="row form-group divJuridico">
						<div class="col-sm-9 col-md-9 col-lg-9">
							<label for="razon_social">Razón social (*)</label>
							<input type="text" id="razon_social" name="razon_social" class="form-control h-2" placeholder="Indique la razón social" value="" autocomplete="off">
						</div>
					</div>

					<!-- NATURAL -->
					<div class="row form-group divNatural" hidden>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="nombres">Nombres (*)</label>
							<input type="text" id="nombres" name="nombres" class="form-control h-2 w-porc-90" placeholder="Indique el nombre completo" value="" autocomplete="off">
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="apellido_paterno">Apellido paterno (*)</label>
							<input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control h-2 w-porc-90" placeholder="Indique el apellido paterno" value="" autocomplete="off">
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="apellido_materno">Apellido materno (*)</label>
							<input type="text" id="apellido_materno" name="apellido_materno" class="form-control h-2 w-porc-90" placeholder="Indique el apellido materno" value="" autocomplete="off">
						</div>
					</div>

					<div class="row form-group divNatural" hidden>
						<div class="col-sm-2 col-md-2 col-lg-2 form-group">
							<label for="genero">Genero</label>
							<select id="genero" name="genero" class="form-control h-3">
								<option value="M">MASCULINO</option>
								<option value="F">FEMENINO</option>
							</select>
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2 form-group">
							<label for="edo_civil">Estado civil</label>
							<select id="edo_civil" name="edo_civil" class="form-control h-3"> <?php
								foreach ($edo_civil as $i => $val) { ?>
									<option value="<?=$val->ESTCP_Codigo?>" <?=($val->ESTCC_Descripcion == "SOLTERO") ? "selected" : "";?>><?=$val->ESTCC_Descripcion;?></option> <?php
								} ?>
							</select>
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2 form-group">
							<label for="nacionalidad">Nacionalidad</label>
							<select id="nacionalidad" name="nacionalidad" class="form-control h-3"> <?php
								foreach ($nacionalidad as $i => $val) { ?>
									<option value="<?=$val->NACP_Codigo;?>" <?=($val->NACP_Codigo == 193) ? "selected" : '';?> ><?=$val->NACC_Descripcion;?></option> <?php
								} ?>
							</select>
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="fecha_nacimiento">Fecha de nacimiento</label>
							<input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control h-2 w-porc-90" value="">
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-9 col-md-9 col-lg-9">
							<label for="direccion">Dirección (*)</label>
							<textarea id="direccion" name="direccion" class="form-control h-4" placeholder="Indique la dirección"></textarea>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="departamento">Departamento</label>
							<select id="departamento" name="departamento" class="form-control h-3 w-porc-90"><?php
								foreach ($departamentos as $i => $val){ ?>
									<option value="<?=$val->UBIGC_CodDpto;?>" <?=($val->UBIGC_CodDpto == "15") ? "selected" : ""?> ><?=$val->UBIGC_DescripcionDpto;?></option> <?php
								} ?>
							</select>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="provincia">Provincia</label>
							<select id="provincia" name="provincia" class="form-control h-3 w-porc-90"><?php
								foreach ($provincias as $i => $val){ ?>
									<option value="<?=$val->UBIGC_CodProv;?>" <?=($val->UBIGC_CodProv == "01") ? "selected" : "";?>><?=$val->UBIGC_DescripcionProv;?></option> <?php
								} ?>
							</select>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="distrito">Distrito</label>
							<select id="distrito" name="distrito" class="form-control h-3 w-porc-90"><?php
								foreach ($distritos as $i => $val){ ?>
									<option value="<?=$val->UBIGC_CodDist;?>" <?=($val->UBIGC_CodDist == "01") ? "selected" : "";?>><?=$val->UBIGC_Descripcion;?></option> <?php 
								} ?>
							</select>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-11 col-md-11 col-lg-11 header form-group">
							<span>OTROS DATOS</span>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="sector_comercial">Sector Comercial</label>
							<select id="sector_comercial" name="sector_comercial" class="form-control h-3 w-porc-90">
								<option value=""> :: SELECCIONE :: </option><?php
								foreach ($sector_comercial as $i => $val){ ?>
									<option value="<?=$val->SECCOMP_Codigo;?>"><?=$val->SECCOMC_Descripcion;?></option> <?php
								} ?>
							</select>
						</div>

						<div class="col-sm-3 col-md-3 col-lg-3" hidden="">
							<label for="forma_pago">Forma de pago</label>
							<select id="forma_pago" name="forma_pago" class="form-control h-3 w-porc-90">
								<option value=""> :: SELECCIONE :: </option><?php
								foreach ($forma_pago as $i => $val){ ?>
									<option value="<?=$val->FORPAP_Codigo;?>"><?=$val->FORPAC_Descripcion;?></option> <?php
								} ?>
							</select>
						</div>

						<div class="col-sm-3 col-md-3 col-lg-3" hidden>
							<label for="categoria">Categoria</label>
							<select id="categoria" name="categoria" class="form-control h-3 w-porc-90">
								<option value=""> :: SELECCIONE :: </option><?php
								foreach ($categorias_proveedor as $i => $val){ ?>
									<option value="<?=$val->TIPCLIP_Codigo;?>"><?=$val->TIPCLIC_Descripcion;?></option> <?php
								} ?>
							</select>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-11 col-md-11 col-lg-11 header form-group">
							<span>INFORMACIÓN DE CONTACTO</span>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="telefono">Telefono</label>
							<input type="tel" id="telefono" name="telefono" class="form-control h-2 w-porc-90" placeholder="000 000 000" val="" autocomplete="off">
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="movil">Movil</label>
							<input type="tel" id="movil" name="movil" class="form-control h-2 w-porc-90" placeholder="000 000 000" val="" autocomplete="off">
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="fax">Fax</label>
							<input type="number" id="fax" name="fax" class="form-control h-2 w-porc-90" placeholder="000 000 000" val="" autocomplete="off">
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="correo">Correo</label>
							<input type="email" id="correo" name="correo" class="form-control h-2 w-porc-90" placeholder="proveedor@empresa.com" val="" autocomplete="off">
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="web">Dirección web</label>
							<input type="url" id="web" name="web" class="form-control h-2 w-porc-90" placeholder="" val="http://www.google.com" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="registrar_proveedor()">Guardar Registro</button>
					<button type="button" class="btn btn-info" onclick="clean()">Limpiar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END MODAL PROVEEDOR-->

<!-- MODAL SUCURSALES -->
<div id="modal_sucursales" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog w-porc-80">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h3 class="modal-title">SUCURSALES</h3>
			</div>
			<div class="modal-body panel panel-default">
				<div class="row form-group">
					<div class="col-sm-2 col-md-2 col-lg-2">
						<label>RUC:</label> <span class="titleRuc"></span>
					</div>
					<div class="col-sm-5 col-md-5 col-lg-5">
						<label>RAZÓN SOCIAL:</label> <span class="titleRazonSocial"></span>
					</div>
					<div class="col-sm-1 col-md-1 col-lg-1">
						<button type="button" class="btn btn-info btn-addSucursal" value="">Agregar Sucursal</button>
					</div>
				</div>

				<div class="row form-group">
					<div class="col-sm-12 col-md-12 col-lg-12 pall-0">
						<table class="fuente8 display" id="table-sucursales">
							<div id="cargando_datos" class="loading-table">
								<img src="<?=base_url().'images/loading.gif?='.IMG;?>">
							</div>
							<thead>
								<tr class="cabeceraTabla">
									<td style="width:15%" data-orderable="true">NOMBRE</td>
									<td style="width:15%" data-orderable="true">TIPO</td>
									<td style="width:40%" data-orderable="true">DIRECCIÓN</td>
									<td style="width:20%" data-orderable="true">UBIGEO</td>
									<td style="width:05%" data-orderable="false"></td>
									<td style="width:05%" data-orderable="false"></td>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
			</div>
		</div>
	</div>
</div>

<div id="modal_addsucursal" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog w-porc-70">
		<div class="modal-content">
			<form id="formSucursal" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
				</div>
				<div style="text-align: center;">
					<h3><b>REGISTRO DE SUCURSAL</b></h3>
				</div>
				<div class="modal-body panel panel-default">

					<input type="hidden" id="sucursal" name="sucursal" value="">
					<input type="hidden" id="sucursal_empresa" name="sucursal_empresa" value="">

					<div class="row form-group">
						<div class="col-sm-4 col-md-4 col-lg-4">
							<label for="establecimiento_nombre">Nombre *</label>
							<input type="text" id="establecimiento_nombre" name="establecimiento_nombre" class="form-control h-2 w-porc-90" placeholder="Nombre del establecimiento" value="" autocomplete="off">
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="establecimiento_tipo">Tipo de establecimiento</label>
							<select id="establecimiento_tipo" name="establecimiento_tipo" class="form-control h-3 w-porc-90"><?php
								foreach ($tipo_establecimiento as $i => $val){ ?>
									<option value="<?=$val->TESTP_Codigo?>"><?=$val->TESTC_Descripcion;?></option><?php
								} ?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-9 col-md-9 col-lg-9">
							<label for="establecimiento_direccion">Dirección (*)</label>
							<textarea id="establecimiento_direccion" name="establecimiento_direccion" class="form-control h-4" placeholder="Indique la dirección del establecimiento"></textarea>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="establecimiento_departamento">Departamento</label>
							<select id="establecimiento_departamento" name="establecimiento_departamento" class="form-control h-3 w-porc-90"><?php
							foreach ($departamentos as $i => $val){ ?>
									<option value="<?=$val->UBIGC_CodDpto;?>" <?=($val->UBIGC_CodDpto == "15") ? "selected" : ""?> ><?=$val->UBIGC_DescripcionDpto;?></option> <?php
								} ?>
							</select>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="establecimiento_provincia">Provincia</label>
							<select id="establecimiento_provincia" name="establecimiento_provincia" class="form-control h-3 w-porc-90"><?php
								foreach ($provincias as $i => $val){ ?>
									<option value="<?=$val->UBIGC_CodProv;?>" <?=($val->UBIGC_CodProv == "01") ? "selected" : "";?>><?=$val->UBIGC_DescripcionProv;?></option> <?php
								} ?>
							</select>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="establecimiento_distrito">Distrito</label>
							<select id="establecimiento_distrito" name="establecimiento_distrito" class="form-control h-3 w-porc-90"><?php
							foreach ($distritos as $i => $val){ ?>
									<option value="<?=$val->UBIGC_CodDist;?>" <?=($val->UBIGC_CodDist == "01") ? "selected" : "";?>><?=$val->UBIGC_Descripcion;?></option> <?php 
								} ?>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="registrar_sucursal()">Guardar Registro</button>
					<button type="button" class="btn btn-info" onclick="clean_sucursal()">Limpiar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END MODAL SUCURSALES -->

<!-- MODAL BANCOS -->
<div id="modal_bancos" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog w-porc-80">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h3 class="modal-title">CUENTAS BANCARIAS</h3>
			</div>
			<div class="modal-body panel panel-default">
				<div class="row form-group">
					<div class="col-sm-2 col-md-2 col-lg-2">
						<label>RUC:</label> <span class="titleRuc"></span>
					</div>
					<div class="col-sm-5 col-md-5 col-lg-5">
						<label>RAZÓN SOCIAL:</label> <span class="titleRazonSocial"></span>
					</div>
					<div class="col-sm-1 col-md-1 col-lg-1">
						<button type="button" class="btn btn-info btn-addBanco" value="">Agregar Cuenta</button>
						<button type="button" hidden id="btn-ctabancoempresa" value=""></button>
						<button type="button" hidden id="btn-ctabancopersona" value=""></button>
					</div>
				</div>

				<div class="row form-group">
					<div class="col-sm-12 col-md-12 col-lg-12 pall-0">
						<table class="fuente8 display" id="table-bancos">
							<div id="cargando_datos" class="loading-table">
								<img src="<?=base_url().'images/loading.gif?='.IMG;?>">
							</div>
							<thead>
								<tr class="cabeceraTabla">
									<td style="width:20%" data-orderable="true">BANCO</td>
									<td style="width:20%" data-orderable="true">TITULAR</td>
									<td style="width:10%" data-orderable="true">TIPO</td>
									<td style="width:10%" data-orderable="true">MONEDA</td>
									<td style="width:15%" data-orderable="false">N° CUENTA</td>
									<td style="width:15%" data-orderable="false">INTERBANCARIA</td>
									<td style="width:05%" data-orderable="false"></td>
									<td style="width:05%" data-orderable="false"></td>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
			</div>
		</div>
	</div>
</div>

<div id="modal_addctabancaria" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog w-porc-70">
		<div class="modal-content">
			<form id="formCtaBancaria" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
				</div>
				<div style="text-align: center;">
					<h3><b>REGISTRO DE CUENTA BANCARIA</b></h3>
				</div>
				<div class="modal-body panel panel-default">

					<input type="hidden" id="cta_bancaria" name="cta_bancaria" value="">
					<input type="hidden" id="cta_bancaria_empresa" name="cta_bancaria_empresa" value="">
					<input type="hidden" id="cta_bancaria_persona" name="cta_bancaria_persona" value="">

					<div class="row form-group">
						<div class="col-sm-4 col-md-4 col-lg-4">
							<label for="banco">Banco *</label>
							<select id="banco" name="banco" class="form-control h-3 w-porc-90"><?php
								foreach ($bancos as $i => $val){ ?>
									<option value="<?=$val->BANP_Codigo;?>"><?=$val->BANC_Nombre;?></option> <?php
								} ?>
							</select>
						</div>

						<div class="col-sm-5 col-md-5 col-lg-5">
							<label for="cta_bancaria_titular">Titular *</label>
							<input type="text" id="cta_bancaria_titular" name="cta_bancaria_titular" class="form-control h-2 w-porc-90" placeholder="Titular de la cuenta" value="" autocomplete="off">
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="cta_bancaria_tipo">Tipo de cuenta *</label>
							<select id="cta_bancaria_tipo" name="cta_bancaria_tipo" class="form-control h-3 w-porc-90">
								<option value="1">AHORROS</option>
								<option value="2">CORRIENTE</option>
							</select>
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="cta_bancaria_moneda">Moneda *</label>
								<select id="cta_bancaria_moneda" name="cta_bancaria_moneda" class="form-control h-3 w-porc-90"><?php
								foreach ($monedas as $i => $val){ ?>
									<option value="<?=$val->MONED_Codigo;?>"><?="$val->MONED_Simbolo | $val->MONED_smallName";?></option> <?php
								} ?>
							</select>
						</div>

						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="cta_bancaria_numero">N° de cuenta *</label>
							<input type="number" id="cta_bancaria_numero" name="cta_bancaria_numero" class="form-control h-2 w-porc-90" placeholder="Número de la cuenta" value="" autocomplete="off">
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="cta_bancaria_interbancaria">Interbancaria </label>
							<input type="number" id="cta_bancaria_interbancaria" name="cta_bancaria_interbancaria" class="form-control h-2 w-porc-90" placeholder="Número de cuenta interbancaria" value="" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="registrar_CtaBancaria()">Guardar Registro</button>
					<button type="button" class="btn btn-info" onclick="clean_CtaBancaria()">Limpiar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END MODAL BANCOS -->

<!-- MODAL CONTACTOS -->
<div id="modal_contactos" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog w-porc-80">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h3 class="modal-title">CONTACTOS REGISTRADOS</h3>
			</div>
			<div class="modal-body panel panel-default">
				<div class="row form-group">
					<div class="col-sm-2 col-md-2 col-lg-2">
						<label>RUC:</label> <span class="titleRuc"></span>
					</div>
					<div class="col-sm-5 col-md-5 col-lg-5">
						<label>RAZÓN SOCIAL:</label> <span class="titleRazonSocial"></span>
					</div>
					<div class="col-sm-1 col-md-1 col-lg-1">
						<button type="button" class="btn btn-info btn-addContacto" value="">Agregar Contacto</button>
						<button type="button" hidden id="btn-contactoempresa" value=""></button>
						<button type="button" hidden id="btn-contactopersona" value=""></button>
					</div>
				</div>

				<div class="row form-group">
					<div class="col-sm-12 col-md-12 col-lg-12 pall-0">
						<table class="fuente8 display" id="table-contactos">
							<div id="cargando_datos" class="loading-table">
								<img src="<?=base_url().'images/loading.gif?='.IMG;?>">
							</div>
							<thead>
								<tr class="cabeceraTabla">
									<td style="width:20%" data-orderable="true">CONTACTO</td>
									<td style="width:15%" data-orderable="true">AREA</td>
									<td style="width:15%" data-orderable="true">CARGO</td>
									<td style="width:10%" data-orderable="false">TELEFONO</td>
									<td style="width:10%" data-orderable="false">MÓVIL</td>
									<td style="width:10%" data-orderable="false">FÁX</td>
									<td style="width:10%" data-orderable="false">CORREO</td>
									<td style="width:05%" data-orderable="false"></td>
									<td style="width:05%" data-orderable="false"></td>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
			</div>
		</div>
	</div>
</div>

<div id="modal_addcontacto" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog w-porc-70">
		<div class="modal-content">
			<form id="formContacto" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
				</div>
				<div style="text-align: center;">
					<h3><b>REGISTRO DE CONTACTO</b></h3>
				</div>
				<div class="modal-body panel panel-default">

					<input type="hidden" id="contacto" name="contacto" value="">
					<input type="hidden" id="contacto_empresa" name="contacto_empresa" value="">
					<input type="hidden" id="contacto_persona" name="contacto_persona" value="">

					<div class="row form-group">
						<div class="col-sm-5 col-md-5 col-lg-5">
							<label for="contacto_nombre">Nombre y apellidos *</label>
							<input type="text" id="contacto_nombre" name="contacto_nombre" class="form-control h-2 w-porc-90" placeholder="Nombre del contacto" value="" autocomplete="off">
						</div>

						<div class="col-sm-5 col-md-5 col-lg-5">
							<label for="contacto_area">Area</label>
							<input type="text" id="contacto_area" name="contacto_area" class="form-control h-2 w-porc-90" placeholder="-> VENTAS" value="" autocomplete="off">
						</div>

						<div class="col-sm-5 col-md-5 col-lg-5">
							<label for="contacto_cargo">Cargo</label>
							<input type="text" id="contacto_cargo" name="contacto_cargo" class="form-control h-2 w-porc-90" placeholder="-> SUPERVISOR" value="" autocomplete="off">
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="contacto_telefono">Telefono</label>
							<input type="tel" id="contacto_telefono" name="contacto_telefono" class="form-control h-2 w-porc-90" placeholder="000 000 000" val="" autocomplete="off">
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="contacto_movil">Móvil</label>
							<input type="tel" id="contacto_movil" name="contacto_movil" class="form-control h-2 w-porc-90" placeholder="000 000 000" val="" autocomplete="off">
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="contacto_fax">Fáx</label>
							<input type="number" id="contacto_fax" name="contacto_fax" class="form-control h-2 w-porc-90" placeholder="000 000 000" val="" autocomplete="off">
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<label for="contacto_correo">Correo</label>
							<input type="email" id="contacto_correo" name="contacto_correo" class="form-control h-2 w-porc-90" placeholder="proveedor@empresa.com" val="" autocomplete="off">
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="registrar_contacto()">Guardar Registro</button>
					<button type="button" class="btn btn-info" onclick="clean_contacto()">Limpiar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END MODAL CONTACTOS -->

<!-- MODAL DOCUMENTOS -->
<div id="modal_documentos" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog w-porc-80">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h3 class="modal-title">DOCUMENTOS GENERADOS</h3>
			</div>
			<div class="modal-body panel panel-default">
				<div class="row form-group">
					<div class="col-sm-2 col-md-2 col-lg-2">
						<label>RUC:</label> <span class="titleRuc"></span>
					</div>
					<div class="col-sm-5 col-md-5 col-lg-5">
						<label>RAZÓN SOCIAL:</label> <span class="titleRazonSocial"></span>
					</div>
				</div>

				<div class="row form-group">
					<div class="col-sm-12 col-md-12 col-lg-12 pall-0">
						<table class="fuente8 display" id="table-documentos">
							<div class="table-documentos loading-table"> <img src="<?=base_url().'images/loading.gif?='.IMG;?>"> </div>
							<thead>
								<tr class="cabeceraTabla">
									<td style="width:30%" data-orderable="true">EMPRESA REGISTRO</td>
									<td style="width:15%" data-orderable="true">DOCUMENTO</td>
									<td style="width:15%" data-orderable="true">FECHA REGISTRO</td>
									<td style="width:10%" data-orderable="false">FECHA EMISIÓN</td>
									<td style="width:10%" data-orderable="false">SERIE</td>
									<td style="width:10%" data-orderable="false">NÚMERO</td>
									<td style="width:10%" data-orderable="false">TOTAL</td>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
			</div>
		</div>
	</div>
</div>
<!-- END DOCUMENTOS -->

<script type="text/javascript">
	$(document).ready(function(){
		$('#table-proveedor').DataTable({ responsive: true,
			filter: false,
			destroy: true,
			processing: true,
			serverSide: true,
			autoWidth: false,
			ajax:{
				url : base_url + 'index.php/compras/proveedor/datatable_proveedor/',
				type: "POST",
				data: { dataString: "" },
				beforeSend: function(){
					$("#table-proveedor .loading-table").show();
				},
				error: function(){
				},
				complete: function(){
					$("#table-proveedor .loading-table").hide();
				}
			},
			language: spanish,
			columnDefs: [
			{"className": "dt-center", "targets": 0},
			{"className": "dt-center", "targets": 1}
			],
			order: [[ 2, "asc" ]]
		});

		$("#buscarC").click(function(){
			search();
		});

		$("#limpiarC").click(function(){
			search(false);
		});

		$('#form_busqueda').keypress(function(e){
			if ( e.which == 13 ){
				return false;
			} 
		});

		$("#formProveedor").keypress(function(e){
			if ( e.which == 13 ){
				registrar_proveedor();
			}
		});

		$("#numero_documento").keyup(function(e){
			if ( e.which == 16 ){
				if( $(this).val() != '' )
					getSunat();
			}
		});

		$("#formCtaBancaria").keypress(function(e){
			if ( e.which == 13 ){
				registrar_CtaBancaria();
			}
		});

		$("#formContacto").keyup(function(e){
			if ( e.which == 13 ){
				registrar_contacto();
			}
		});

		$("#formSucursal").keyup(function(e){
			if ( e.which == 13 ){
				registrar_sucursal();
			}
		});

		$('#search_codigo, #search_documento, #nombre_proveedor').keyup(function(e){
			if ( e.which == 13 ){
				if( $(this).val() != '' )
					search();
			}
		});

		$("#tipo_cliente").change(function(){
			show_tipoProveedor( parseInt($(this).val()) );
		});

		$("#departamento").change(function(){
			getProvincias();
		});

		$("#provincia").change(function(){
			getDistritos();
		});

		$("#establecimiento_departamento").change(function(){
			getProvincias(null, null, "#establecimiento_departamento", "#establecimiento_provincia");
		});

		$("#establecimiento_provincia").change(function(){
			getDistritos(null, null, null, "#establecimiento_departamento", "#establecimiento_provincia", "#establecimiento_distrito");
		});

		$("#idproveedor").click(function(){
			if ($("#proveedor").val() == ""){
				var url = base_url + "index.php/compras/proveedor/generateCodeProveedor";
				$.ajax({
					type: 'POST',
					url: url,
					dataType: 'json',
					data:{
						json: true
					},
					beforeSend: function(){
					},
					success: function(data){
						if (data.code != "") {
							$("#idproveedor").val(data.code);
						}
						else{
							Swal.fire({
								icon: "info",
								title: "Información no disponible.",
								html: "<b class='color-red'>La información consultada no esta disponible. Intentelo nuevamente.</b>",
								showConfirmButton: true,
								timer: 4000
							});
						}
					},
					complete: function(){
					}
				});
			}
		});

		$(".btn-search-sunat").click(function(){
			getSunat();
		});

		$(".btn-addSucursal").click(function(){
			clean_sucursal();
			$("#modal_addsucursal").modal("toggle");
		});

		$(".btn-addBanco").click(function(){
			clean_CtaBancaria();
			$("#modal_addctabancaria").modal("toggle");
		});

		$(".btn-addContacto").click(function(){
			clean_contacto();
			$("#modal_addcontacto").modal("toggle");
		});
	});

	/* PROVEEDOR */
	function search( search = true){
		if (search == true){
			documento = $("#search_documento").val();
			nombre = $("#nombre_proveedor").val();
		}
		else{
			$("#search_codigo").val("");
			$("#search_documento").val("");
			$("#nombre_proveedor").val("");

			documento = "";
			nombre = "";
		}

		$('#table-proveedor').DataTable({ responsive: true,
			filter: false,
			destroy: true,
			processing: true,
			serverSide: true,
			autoWidth: false,
			ajax:{
				url : base_url + 'index.php/compras/proveedor/datatable_proveedor/',
				type: "POST",
				data: {
					documento: documento,
					nombre: nombre
				},
				beforeSend: function(){
					$("#table-proveedor .loading-table").show();
				},
				error: function(){
				},
				complete: function(){
					$("#table-proveedor .loading-table").hide();
				}
			},
			language: spanish,
			columnDefs: [
			{"className": "dt-center", "targets": 0},
			{"className": "dt-center", "targets": 1}
			],
			order: [[ 2, "asc" ]]
		});
	}

	function editar_proveedor(id){
		var url = base_url + "index.php/compras/proveedor/getProveedor";
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			data:{
				proveedor: id
			},
			beforeSend: function(){
				clean();
				$(".divJuridico").hide();
				$(".divNatural").hide();
			},
			success: function(data){
				if (data.match == true) {
					info = data.info;

					show_tipoProveedor(info.tipo_cliente);

					$("#proveedor").val(info.proveedor);

					doc = "DOC" + info.tipo_cliente;

					$("#tipo_cliente").val(info.tipo_cliente);
					$("#tipo_documento").val(info.tipo_documento);
					$("#numero_documento").val(info.numero_documento);

					$("#razon_social").val(info.razon_social);

					$("#nombres").val(info.nombres);
					$("#apellido_paterno").val(info.apellido_paterno);
					$("#apellido_materno").val(info.apellido_materno);
					$("#genero").val(info.genero);
					$("#edo_civil").val(info.edo_civil);
					$("#nacionalidad").val(info.nacionalidad);

					$("#direccion").val(info.direccion);
					$("#departamento").val(info.departamento);

					getProvincias(info.departamento, info.provincia);
					getDistritos(info.departamento, info.provincia, info.distrito);

					if (info.sector_comercial != null)
						$("#sector_comercial").val(info.sector_comercial);

					if (info.forma_pago != null)
						$("#forma_pago").val(info.forma_pago);

					if (info.categoria != null)
						$("#categoria").val(info.categoria);

					$("#telefono").val(info.telefono);
					$("#movil").val(info.movil);
					$("#fax").val(info.fax);
					$("#correo").val(info.correo);
					$("#web").val(info.web);

					$("#modal_addproveedor").modal("toggle");
				}
				else{
					Swal.fire({
						icon: "info",
						title: "Información no disponible.",
						html: "<b class='color-red'></b>",
						showConfirmButton: true,
						timer: 4000
					});
				}
			},
			complete: function(){
			}
		});
	}

	function registrar_proveedor(){
		Swal.fire({
			icon: "info",
			title: "¿Esta seguro de guardar el registro?",
			html: "<b class='color-red'></b>",
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar"
		}).then(result => {
			if (result.value){
				var url = base_url + "index.php/compras/proveedor/guardar_registro";

				proveedor         	= $("#proveedor").val();
				tipo_cliente    	= $("#tipo_cliente").val();
				tipo_documento  	= $("#tipo_documento").val();
				numero_documento 	= $("#numero_documento").val();
				razon_social    	= $("#razon_social").val();
				nombres         	= $("#nombres").val();
				apellido_paterno 	= $("#apellido_paterno").val();
				apellido_materno 	= $("#apellido_materno").val();
				genero          	= $("#genero").val();
				edo_civil       	= $("#edo_civil").val();
				nacionalidad    	= $("#nacionalidad").val();
				direccion       	= $("#direccion").val();
				departamento    	= $("#departamento").val();
				provincia       	= $("#provincia").val();
				distrito        	= $("#distrito").val();
				idproveedor       	= $("#idproveedor").val();
				vendedor        	= $("#vendedor").val();
				sector_comercial 	= $("#sector_comercial").val();
				forma_pago      	= $("#forma_pago").val();
				categoria       	= $("#categoria").val();
				telefono        	= $("#telefono").val();
				movil           	= $("#movil").val();
				fax             	= $("#fax").val();
				correo          	= $("#correo").val();
				web             	= $("#web").val();

				validacion = true;

				if (tipo_cliente == "1"){
					if (razon_social == ""){
						Swal.fire({
							icon: "error",
							title: "Verifique los datos ingresados.",
							html: "<b class='color-red'>Debe ingresar una razón social.</b>",
							showConfirmButton: true,
							timer: 4000
						});
						$("#razon_social").focus();
						validacion = false;
						return false;
					}
				}
				else{
					if (nombres == ""){
						Swal.fire({
							icon: "error",
							title: "Verifique los datos ingresados.",
							html: "<b class='color-red'>Debe ingresar el nombre.</b>",
							showConfirmButton: true,
							timer: 4000
						});
						$("#nombres").focus();
						validacion = false;
						return false;
					}

					if (apellido_paterno == ""){
						Swal.fire({
							icon: "error",
							title: "Verifique los datos ingresados.",
							html: "<b class='color-red'>Debe ingresar el apellido paterno.</b>",
							showConfirmButton: true,
							timer: 4000
						});
						$("#apellido_paterno").focus();
						validacion = false;
						return false;
					}

					if (apellido_materno == ""){
						Swal.fire({
							icon: "error",
							title: "Verifique los datos ingresados.",
							html: "<b class='color-red'>Debe ingresar el apellido materno.</b>",
							showConfirmButton: true,
							timer: 4000
						});
						$("#apellido_materno").focus();
						validacion = false;
						return false;
					}
				}

				if (numero_documento == ""){
					Swal.fire({
						icon: "error",
						title: "Verifique los datos ingresados.",
						html: "<b class='color-red'>Debe ingresar un número de documento valido.</b>",
						showConfirmButton: true,
						timer: 4000
					});
					$("#numero_documento").focus();
					validacion = false;
					return false;
				}

				if (direccion == ""){
					Swal.fire({
						icon: "error",
						title: "Verifique los datos ingresados.",
						html: "<b class='color-red'>Debe ingresar la dirección.</b>",
						showConfirmButton: true,
						timer: 4000
					});
					$("#direccion").focus();
					validacion = false;
					return false;
				}

				if (validacion == true){
					var dataForm = $("#formProveedor").serialize();
					$.ajax({
						type: 'POST',
						url: url,
						dataType: 'json',
						data: dataForm,
						success: function(data){
							if (data.result == "success") {
								if (proveedor == "")
									titulo = "¡Registro exitoso!";
								else
									titulo = "¡Actualización exitosa!";

								Swal.fire({
									icon: "success",
									title: titulo,
									showConfirmButton: true,
									timer: 2000
								});

								clean();
							}
							else{
								Swal.fire({
									icon: "error",
									title: "Sin cambios.",
									html: "<b class='color-red'>" + data.message + "</b>",
									showConfirmButton: true,
									timer: 4000
								});
							}
						},
						complete: function(){
							$("#numero_documento").focus();
						}
					});
				}
			}
		});
	}

	function deshabilitar_proveedor(id){
		Swal.fire({
			icon: "info",
			title: "¿Esta seguro de eliminar el registro seleccionado?",
			html: "<b class='color-red'>Esta acción no se puede deshacer.</b>",
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar"
		}).then(result => {
			if (result.value){
				var url = base_url + "index.php/compras/proveedor/deshabilitar_proveedor";
				$.ajax({
					type: 'POST',
					url: url,
					dataType: 'json',
					data: {
						proveedor: id
					},
					success: function(data){
						if (data.result == "success") {
							titulo = "¡Registro eliminado!";
							Swal.fire({
								icon: "success",
								title: titulo,
								showConfirmButton: true,
								timer: 2000
							});
							search(false);
						}
						else{
							Swal.fire({
								icon: data.result,
								title: data.message,
								html: "<b class='color-red'></b>",
								showConfirmButton: true,
								timer: 4000
							});
						}
					},
					complete: function(){
					}
				});
			}
		});
	}

	function show_tipoProveedor( id = null ){
		if (id == null)
			id = parseInt( $("#tipo_cliente").val() );
		else
			$("#tipo_cliente").val(id);

		if ( id == 0 ){
			$(".divJuridico").hide("fast");
			$(".divNatural").show("slow");

			$(".documentosJuridico").attr({ "disabled": "disabled" });
			$(".DOC1").removeAttr("selected");

			$(".documentosNatural").removeAttr("disabled");
			$(".DOC0").first().attr({"selected":"selected"});
		}
		else
			if ( id == 1 ){
				$(".divNatural").hide("fast");
				$(".divJuridico").show("slow");

				$(".documentosNatural").attr({ "disabled": "disabled" });
				$(".DOC0").removeAttr("selected");

				$(".documentosJuridico").removeAttr("disabled");
				$(".DOC1").first().attr({"selected":"selected"});
			}
	}

	function clean( id = null ){
		$("#proveedor").val("");
		$("#formProveedor")[0].reset();

		show_tipoProveedor( id );
		getProvincias('15','01', '', '', false);
    getDistritos('15','01','01');
	}
	/* END PROVEEDOR */

	/* SUCURSAL */

	function sucursales( empresa = null, razon_social = "" ){

		$("#modal_sucursales").modal("toggle");

		title = razon_social.split("-");
		$(".titleRuc").html(title[0]);
		$(".titleRazonSocial").html(title[1]);
		$(".btn-addSucursal").val(empresa);

		getTableSucursales();
	}

	function getTableSucursales(){
		$('#table-sucursales').DataTable({ responsive: true,
			filter: false,
			destroy: true,
			processing: true,
			serverSide: true,
			autoWidth: false,
			ajax:{
				url : '<?=base_url();?>index.php/maestros/empresa/datatable_sucursales',
				type: "POST",
				data: {
					empresa: $(".btn-addSucursal").val()
				},
				beforeSend: function(){
					$("#table-sucursales .loading-table").show();
				},
				error: function(){
				},
				complete: function(){
					$("#table-sucursales .loading-table").hide();
				}
			},
			language: spanish,
			order: [[ 0, "asc" ]]
		});
	}

	function editar_sucursal( id ){
		var url = base_url + "index.php/maestros/empresa/getEstablecimiento";
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			data:{
				sucursal: id
			},
			beforeSend: function(){
				clean_sucursal();
				$("#modal_addsucursal").modal("toggle");
			},
			success: function(data){
				if (data.match == true) {
					info = data.info;

					$("#sucursal").val(info.sucursal);
					$("#establecimiento_nombre").val(info.nombre);
					$("#establecimiento_tipo").val(info.tipo);
					$("#establecimiento_direccion").val(info.direccion);

					$("#establecimiento_departamento").val(info.departamento);
					getProvincias(info.departamento, info.provincia, "#establecimiento_departamento", "#establecimiento_provincia", false)
					getDistritos(info.departamento, info.provincia, info.distrito, "#establecimiento_departamento", "#establecimiento_provincia", "#establecimiento_distrito")
				}
				else{
					Swal.fire({
						icon: "info",
						title: "Información no disponible.",
						html: "<b class='color-red'></b>",
						showConfirmButton: true,
						timer: 4000
					});
				}
			},
			complete: function(){
			}
		});
	}

	function registrar_sucursal(){
		Swal.fire({
			icon: "info",
			title: "¿Esta seguro de guardar el registro?",
			html: "<b class='color-red'></b>",
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar"
		}).then(result => {
			if (result.value){
				var url = base_url + "index.php/maestros/empresa/guardar_sucursal";

				sucursal = $("#sucursal").val();
				nombre = $("#establecimiento_nombre").val();
				direccion = $("#establecimiento_direccion").val();

				validacion = true;

				if (nombre == ""){
					Swal.fire({
						icon: "error",
						title: "Verifique los datos ingresados.",
						html: "<b class='color-red'>Debe ingresar un nombre valido.</b>",
						showConfirmButton: true,
						timer: 4000
					});
					$("#establecimiento_nombre").focus();
					validacion = false;
					return false;
				}

				if (direccion == ""){
					Swal.fire({
						icon: "error",
						title: "Verifique los datos ingresados.",
						html: "<b class='color-red'>Debe ingresar la dirección.</b>",
						showConfirmButton: true,
						timer: 4000
					});
					$("#establecimiento_direccion").focus();
					validacion = false;
					return false;
				}

				if (sucursal == ""){
					$("#sucursal_empresa").val( $(".btn-addSucursal").val() );

					if ( $("#sucursal_empresa").val() == "" ){
						Swal.fire({
							icon: "error",
							title: "No hay empresa seleccionada.",
							html: "<b class='color-red'>Cierre el formulario de sucursales e intente ingresar nuevamente.</b>",
							showConfirmButton: true,
							timer: 4000
						});
					}
				}

				if (validacion == true){
					var dataForm = $("#formSucursal").serialize();
					$.ajax({
						type: 'POST',
						url: url,
						dataType: 'json',
						data: dataForm,
						success: function(data){
							if (data.result == "success") {
								if (sucursal == "")
									titulo = "¡Registro exitoso!";
								else
									titulo = "¡Actualización exitosa!";

								Swal.fire({
									icon: "success",
									title: titulo,
									showConfirmButton: true,
									timer: 2000
								});

								clean_sucursal();
							}
							else{
								Swal.fire({
									icon: "error",
									title: "Sin cambios.",
									html: "<b class='color-red'>La información no fue registrada/actualizada, intentelo nuevamente.</b>",
									showConfirmButton: true,
									timer: 4000
								});
							}
						},
						complete: function(){
							getTableSucursales();
						}
					});
				}
			}
		});
	}

	function deshabilitar_sucursal(id){
		Swal.fire({
			icon: "info",
			title: "¿Esta seguro de eliminar el registro seleccionado?",
			html: "<b class='color-red'>Esta acción no se puede deshacer.</b>",
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar"
		}).then(result => {
			if (result.value){
				var url = base_url + "index.php/maestros/empresa/deshabilitar_sucursal";
				$.ajax({
					type: 'POST',
					url: url,
					dataType: 'json',
					data: {
						sucursal: id
					},
					success: function(data){
						if (data.result == "success") {
							titulo = "¡Registro eliminado!";
							Swal.fire({
								icon: "success",
								title: titulo,
								showConfirmButton: true,
								timer: 2000
							});
						}
						else{
							Swal.fire({
								icon: "error",
								title: "Sin cambios.",
								html: "<b class='color-red'>La información no pudo ser eliminada, intentelo nuevamente.</b>",
								showConfirmButton: true,
								timer: 4000
							});
						}
					},
					complete: function(){
						getTableSucursales();
					}
				});
			}
		});
	}

	function clean_sucursal(){
		$("#sucursal").val("");
		$("#sucursal_empresa").val("");
		$("#formSucursal")[0].reset();
	}

	/* END SUCURSAL */

	/* CTA BANCARIA */

	function modal_CtasBancarias( empresa = null, persona = null, razon_social = "" ){

		$("#modal_bancos").modal("toggle");

		title = razon_social.split("-");
		$(".titleRuc").html(title[0]);
		$(".titleRazonSocial").html(title[1]);
		$("#btn-ctabancoempresa").val(empresa);
		$("#btn-ctabancopersona").val(persona);

		getTableCtaBancarias();
	}

	function getTableCtaBancarias(){
		$('#table-bancos').DataTable({ responsive: true,
			filter: false,
			destroy: true,
			processing: true,
			serverSide: true,
			autoWidth: false,
			ajax:{
				url : '<?=base_url();?>index.php/tesoreria/bancocta/datatable_ctaEmpresa',
				type: "POST",
				data: {
					empresa: $("#btn-ctabancoempresa").val(),
					persona: $("#btn-ctabancopersona").val()
				},
				beforeSend: function(){
					$("#table-bancos .loading-table").show();
				},
				error: function(){
				},
				complete: function(){
					$("#table-bancos .loading-table").hide();
				}
			},
			language: spanish,
			order: [[ 0, "asc" ]]
		});
	}

	function editar_CtaBancaria( id ){
		var url = base_url + "index.php/tesoreria/bancocta/getCtaBancaria";
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			data:{
				cta_bancaria: id
			},
			beforeSend: function(){
				clean_sucursal();
				$("#modal_addctabancaria").modal("toggle");
			},
			success: function(data){
				if (data.match == true) {
					info = data.info;

					$("#cta_bancaria").val(info.cta_bancaria);
					$("#cta_bancaria_empresa").val(info.empresa);
					$("#cta_bancaria_persona").val(info.persona);
					$("#banco").val(info.banco);
					$("#cta_bancaria_titular").val(info.titular);
					$("#cta_bancaria_numero").val(info.cta_numero);
					$("#cta_bancaria_interbancaria").val(info.cta_interbancaria);
					$("#cta_bancaria_tipo").val(info.tipo_cuenta);
					$("#cta_bancaria_moneda").val(info.moneda);
				}
				else{
					Swal.fire({
						icon: "info",
						title: "Información no disponible.",
						html: "<b class='color-red'></b>",
						showConfirmButton: true,
						timer: 4000
					});
				}
			},
			complete: function(){
			}
		});
	}

	function registrar_CtaBancaria(){
		Swal.fire({
			icon: "info",
			title: "¿Esta seguro de guardar el registro?",
			html: "<b class='color-red'></b>",
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar"
		}).then(result => {
			if (result.value){
				var url = base_url + "index.php/tesoreria/bancocta/guardar_ctabancaria";

				var cta = $("#cta_bancaria").val();
				var empresa = $("#cta_bancaria_empresa").val();
				var persona = $("#cta_bancaria_persona").val();
				var banco = $("#banco").val();
				var titular = $("#cta_bancaria_titular").val();
				var tipo = $("#cta_bancaria_tipo").val();
				var moneda = $("#cta_bancaria_moneda").val();
				var numero = $("#cta_bancaria_numero").val();
				var interbancaria = $("#cta_bancaria_interbancaria").val();

				validacion = true;

				if (titular == ""){
					Swal.fire({
						icon: "error",
						title: "Verifique los datos ingresados.",
						html: "<b class='color-red'>Debe ingresar un titular.</b>",
						showConfirmButton: true,
						timer: 4000
					});
					$("#cta_bancaria_titular").focus();
					validacion = false;
					return false;
				}

				if (numero == ""){
					Swal.fire({
						icon: "error",
						title: "Verifique los datos ingresados.",
						html: "<b class='color-red'>Debe ingresar un número de cuenta.</b>",
						showConfirmButton: true,
						timer: 4000
					});
					$("#cta_bancaria_numero").focus();
					validacion = false;
					return false;
				}

				if (cta == ""){
					$("#cta_bancaria_empresa").val( $("#btn-ctabancoempresa").val() );
					$("#cta_bancaria_persona").val( $("#btn-ctabancopersona").val() );

					if ( $("#cta_bancaria_empresa").val() == "" && $("#cta_bancaria_persona").val() == "" ){
						Swal.fire({
							icon: "error",
							title: "No hay proveedor/proveedor seleccionado.",
							html: "<b class='color-red'>Cierre el formulario de cuentas bancarias e intente ingresar nuevamente.</b>",
							showConfirmButton: true,
							timer: 4000
						});
					}
				}

				if (validacion == true){
					var dataForm = $("#formCtaBancaria").serialize();
					$.ajax({
						type: 'POST',
						url: url,
						dataType: 'json',
						data: dataForm,
						success: function(data){
							if (data.result == "success") {
								if (cta == "")
									titulo = "¡Registro exitoso!";
								else
									titulo = "¡Actualización exitosa!";

								Swal.fire({
									icon: "success",
									title: titulo,
									showConfirmButton: true,
									timer: 2000
								});

								clean_CtaBancaria();
							}
							else{
								Swal.fire({
									icon: "error",
									title: "Sin cambios.",
									html: "<b class='color-red'>La información no fue registrada/actualizada, intentelo nuevamente.</b>",
									showConfirmButton: true,
									timer: 4000
								});
							}
						},
						complete: function(){
							getTableCtaBancarias();
						}
					});
				}
			}
		});
	}

	function deshabilitar_CtaBancaria(id){
		Swal.fire({
			icon: "info",
			title: "¿Esta seguro de eliminar el registro seleccionado?",
			html: "<b class='color-red'>Esta acción no se puede deshacer.</b>",
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar"
		}).then(result => {
			if (result.value){
				var url = base_url + "index.php/tesoreria/bancocta/deshabilitar_ctabancaria";
				$.ajax({
					type: 'POST',
					url: url,
					dataType: 'json',
					data: {
						cta_bancaria: id
					},
					success: function(data){
						if (data.result == "success") {
							titulo = "¡Registro eliminado!";
							Swal.fire({
								icon: "success",
								title: titulo,
								showConfirmButton: true,
								timer: 2000
							});
						}
						else{
							Swal.fire({
								icon: "error",
								title: "Sin cambios.",
								html: "<b class='color-red'>La información no pudo ser eliminada, intentelo nuevamente.</b>",
								showConfirmButton: true,
								timer: 4000
							});
						}
					},
					complete: function(){
						getTableCtaBancarias();
					}
				});
			}
		});
	}

	function clean_CtaBancaria(){
		$("#cta_bancaria").val("");
		$("#cta_bancaria_empresa").val("");
		$("#cta_bancaria_persona").val("");
		$("#formCtaBancaria")[0].reset();
	}

	/* END CTA BANCARIA */

	/* CONTACTOS */

	function modal_contactos( empresa = null, persona = null, razon_social = "" ){

		$("#modal_contactos").modal("toggle");

		title = razon_social.split("-");
		$(".titleRuc").html(title[0]);
		$(".titleRazonSocial").html(title[1]);
		$("#btn-contactoempresa").val(empresa);
		$("#btn-contactopersona").val(persona);

		getTableContactos();
	}

	function getTableContactos(){
		$('#table-contactos').DataTable({ responsive: true,
			filter: false,
			destroy: true,
			processing: true,
			serverSide: true,
			autoWidth: false,
			ajax:{
				url : '<?=base_url();?>index.php/maestros/empresa/datatable_contactos',
				type: "POST",
				data: {
					empresa: $("#btn-contactoempresa").val(),
					persona: $("#btn-contactopersona").val()
				},
				beforeSend: function(){
					$("#table-contactos .loading-table").show();
				},
				error: function(){
				},
				complete: function(){
					$("#table-contactos .loading-table").hide();
				}
			},
			language: spanish,
			order: [[ 0, "asc" ]]
		});
	}

	function editar_contacto( id ){
		var url = base_url + "index.php/maestros/empresa/getContacto";
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			data:{
				contacto: id
			},
			beforeSend: function(){
				clean_contacto();
				$("#modal_addcontacto").modal("toggle");
			},
			success: function(data){
				if (data.match == true) {
					info = data.info;

					$("#contacto").val(info.contacto);
					$("#contacto_empresa").val(info.empresa);
					$("#contacto_persona").val(info.persona);
					$("#contacto_nombre").val(info.nombre);
					$("#contacto_area").val(info.area);
					$("#contacto_cargo").val(info.cargo);
					$("#contacto_telefono").val(info.telefono);
					$("#contacto_movil").val(info.movil);
					$("#contacto_fax").val(info.fax);
					$("#contacto_correo").val(info.correo);
				}
				else{
					Swal.fire({
						icon: "info",
						title: "Información no disponible.",
						html: "<b class='color-red'></b>",
						showConfirmButton: true,
						timer: 4000
					});
				}
			},
			complete: function(){
			}
		});
	}

	function registrar_contacto(){
		Swal.fire({
			icon: "info",
			title: "¿Esta seguro de guardar el registro?",
			html: "<b class='color-red'></b>",
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar"
		}).then(result => {
			if (result.value){
				var url = base_url + "index.php/maestros/empresa/guardar_contacto";

				var contacto = $("#contacto").val();
				var empresa = $("#contacto_empresa").val();
				var persona = $("#contacto_persona").val();

				var nombre = $("#contacto_nombre").val();
				var telefono = $("#contacto_telefono").val();
				var movil = $("#contacto_movil").val();
				var fax = $("#contacto_fax").val();
				var correo = $("#contacto_correo").val();

				validacion = true;

				if (nombre == ""){
					Swal.fire({
						icon: "error",
						title: "Verifique los datos ingresados.",
						html: "<b class='color-red'>Debe ingresar un nombre de contacto.</b>",
						showConfirmButton: true,
						timer: 4000
					});
					$("#contacto_nombre").focus();
					validacion = false;
					return false;
				}

				if (telefono == "" && movil == "" && fax == "" && correo == ""){
					Swal.fire({
						icon: "error",
						title: "Complete la información requerida.",
						html: "<b class='color-red'>Debe ingresar al menos un medio de contacto (telefono, movil, fax o correo).</b>",
						showConfirmButton: true,
						timer: 4000
					});
					validacion = false;
					return false;
				}

				if (contacto == ""){
					$("#contacto_empresa").val( $("#btn-contactoempresa").val() );
					$("#contacto_persona").val( $("#btn-contactopersona").val() );

					if ( $("#contacto_empresa").val() == "" && $("#contacto_persona").val() == "" ){
						Swal.fire({
							icon: "error",
							title: "No hay proveedor/proveedor seleccionado.",
							html: "<b class='color-red'>Cierre el formulario de contactos e intente ingresar nuevamente.</b>",
							showConfirmButton: true,
							timer: 4000
						});
					}
				}

				if (validacion == true){
					var dataForm = $("#formContacto").serialize();
					$.ajax({
						type: 'POST',
						url: url,
						dataType: 'json',
						data: dataForm,
						success: function(data){
							if (data.result == "success") {
								if (contacto == "")
									titulo = "¡Registro exitoso!";
								else
									titulo = "¡Actualización exitosa!";

								Swal.fire({
									icon: "success",
									title: titulo,
									showConfirmButton: true,
									timer: 2000
								});

								clean_contacto();
							}
							else{
								Swal.fire({
									icon: "error",
									title: "Sin cambios.",
									html: "<b class='color-red'>La información no fue registrada/actualizada, intentelo nuevamente.</b>",
									showConfirmButton: true,
									timer: 4000
								});
							}
						},
						complete: function(){
							getTableContactos();
						}
					});
				}
			}
		});
	}

	function deshabilitar_contacto(id){
		Swal.fire({
			icon: "info",
			title: "¿Esta seguro de eliminar el registro seleccionado?",
			html: "<b class='color-red'>Esta acción no se puede deshacer.</b>",
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar"
		}).then(result => {
			if (result.value){
				var url = base_url + "index.php/maestros/empresa/deshabilitar_contacto";
				$.ajax({
					type: 'POST',
					url: url,
					dataType: 'json',
					data: {
						contacto: id
					},
					success: function(data){
						if (data.result == "success") {
							titulo = "¡Registro eliminado!";
							Swal.fire({
								icon: "success",
								title: titulo,
								showConfirmButton: true,
								timer: 2000
							});
						}
						else{
							Swal.fire({
								icon: "error",
								title: "Sin cambios.",
								html: "<b class='color-red'>La información no pudo ser eliminada, intentelo nuevamente.</b>",
								showConfirmButton: true,
								timer: 4000
							});
						}
					},
					complete: function(){
						getTableContactos();
					}
				});
			}
		});
	}

	function clean_contacto(){
		$("#contacto").val("");
		$("#contacto_empresa").val("");
		$("#contacto_persona").val("");
		$("#formContacto")[0].reset();
	}

	/* END CONTACTOS */

	/* UBIGEO */

	function getProvincias( dpto = null, select = null, inputDpto = "", inputProv = "", getDist = true){

		if ( dpto == null )
			dpto = (inputDpto == "") ? $("#departamento").val() : $(inputDpto).val();

		var url = base_url + "index.php/maestros/ubigeo/getProvincias";
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			data:{
				departamento: dpto
			},
			beforeSend: function(){
				if (inputProv == "")
					$("#provincia").html("");
				else
					$(inputProv).html("");
			},
			success: function(data){
				if (data.match == true) {
					info = data.info;

					options = '';
					$.each(info, function(i,item){
						if (select != null && item.codigo == select)
							selected = "selected";
						else
							selected = "";

						options += '<option value="' + item.codigo + '" ' + selected + '>' + item.descripcion + '</option>';
					});

					if (inputProv == "")
						$("#provincia").append(options);
					else
						$(inputProv).append(options);
				}
				else{
					Swal.fire({
						icon: "info",
						title: "Información de provincias no disponible.",
						html: "<b class='color-red'></b>",
						showConfirmButton: true,
						timer: 4000
					});
				}
			},
			complete: function(){
				if (inputProv == "" && getDist == true)
					getDistritos();
				else
					if (getDist == true)
						getDistritos(null, null, null, "#establecimiento_departamento", "#establecimiento_provincia", "#establecimiento_distrito");
				}
			});
	}

	function getDistritos( dpto = null, prov = null, select = null, inputDpto = "", inputProv = "", inputDist = ""){

		if (dpto == null)
			dpto = (inputDpto == "") ? $("#departamento").val() : $(inputDpto).val();

		if (prov == null)
			prov = (inputProv == "") ? $("#provincia").val() : $(inputProv).val();

		var url = base_url + "index.php/maestros/ubigeo/getDistritos";
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			data:{
				departamento: dpto,
				provincia: prov
			},
			beforeSend: function(){
				if (inputDist == "")
					$("#distrito").html("");
				else
					$(inputDist).html("");
			},
			success: function(data){
				if (data.match == true) {
					info = data.info;

					options = '';
					$.each(info, function(i,item){
						if (select != null && item.codigo == select)
							selected = "selected";
						else
							selected = "";

						options += '<option value="' + item.codigo + '" ' + selected + '>' + item.descripcion + '</option>';
					});

					if (inputDist == "")
						$("#distrito").append(options);
					else
						$(inputDist).append(options);
				}
				else{
					Swal.fire({
						icon: "info",
						title: "Información de distritos no disponible.",
						html: "<b class='color-red'></b>",
						showConfirmButton: true,
						timer: 4000
					});
				}
			},
			complete: function(){
			}
		});
	}

	/* END UBIGEO */

	function getSunat(){
		if ( $("#numero_documento").val() != "" ){
			var url = base_url + "index.php/compras/proveedor/search_documento";
			$.ajax({
				type: 'POST',
				url: url,
				dataType: 'json',
				data:{
					numero: $("#numero_documento").val()
				},
				beforeSend: function(){
					$('.btn-search-sunat').hide("fast");
					$(".icon-loading-lg").show("slow");

					$("#nombres").val("");
					$("#apellido_paterno").val("");
					$("#apellido_materno").val("");

					$("#razon_social").val("");
					$("#direccion").val("");
				},
				success: function(data){
					if (data.exists == false) {
						if (data.match == true){
							info = data.info;

							show_tipoProveedor(data.tipo_cliente);
							$("#idproveedor").val(data.id_proveedor);

							if (data.tipo_cliente == 0){
								$("#nombres").val(info.nombre);
								$("#apellido_paterno").val(info.paterno);
								$("#apellido_materno").val(info.materno);

								if (info.sexo == "Masculino")
									$("#genero").val("0");
								if (info.sexo == "Femenino")
									$("#genero").val("1");
							}
							else{
								$("#razon_social").val(info.result.razon_social);
								$("#direccion").val(info.result.direccion);

								ubigeo = info.result.ubigeo;

								dpto = ubigeo.substr(0,2);
								prov = ubigeo.substr(2,2);
								dist = ubigeo.substr(4,2);

								$("#departamento").val(dpto);

								getProvincias(dpto, prov, "", "", false);
								getDistritos(dpto, prov, dist);
							}
						}
						else{
							Swal.fire({
								icon: "info",
								title: "¡Algo ha ocurrido!",
								html: "<b class='color-red'>" + data.message + "</b>",
								showConfirmButton: true,
								timer: 6000
							});
						}
					}
					else{
						Swal.fire({
							icon: "info",
							title: "¡Algo ha ocurrido!",
							html: "<b class='color-red'>" + data.message + "</b>",
							showConfirmButton: true,
							timer: 6000
						});
					}
				},
				complete: function(){
					$(".icon-loading-lg").hide("fast");
					$('.btn-search-sunat').show("fast");
				}
			});
		}
	}

	/* DOCUMENTOS EMITIDOS */
	function docs_emitidos( id , ndoc = '', razon_social = '' ){
		$(".titleRuc").html(ndoc);
		$(".titleRazonSocial").html(razon_social);
		$("#modal_documentos").modal("toggle");


		$('#table-documentos').DataTable({ responsive: true,
			filter: false,
			destroy: true,
			processing: true,
			serverSide: true,
			autoWidth: false,
			ajax:{
				url : base_url + 'index.php/compras/proveedor/docs_emitidos/',
				type: "POST",
				data: {
					proveedor: id,
				},
				beforeSend: function(){
					$(".table-documentos").show();
				},
				error: function(){
				},
				complete: function(){
					$(".table-documentos").hide();
				}
			},
			language: spanish,
			columnDefs: [
				{"className": "dt-right", "targets": 4},
				{"className": "dt-right", "targets": 5},
				{"className": "dt-right", "targets": 6}
			],
			order: [[ 2, "desc" ]]
		});
	}
</script>