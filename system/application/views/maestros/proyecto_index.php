<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>

<div class="container-fluid">
	<div class="row header">
		<div class="col-md-12 col-lg-12">
			<div><?=$titulo;?></div>
		</div>
	</div>
	<form id="form_busqueda" method="post">
		<div class="row fuente8 py-1">
			<div class="col-sm-4 col-md-4 col-lg-4"></div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<input type="text" name="search_proyecto" id="search_proyecto" value="" placeholder="Titulo del proyecto" class="form-control h-1 w-porc-90"/>
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<input type="hidden" name="search_cliente" id="search_cliente" value="" class="form-control h-1"/>
				<input type="number" name="search_ruc" id="search_ruc" value="" placeholder="Número de ruc" class="form-control h-1 w-porc-90"/>
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<input type="text" name="search_razon_social" id="search_razon_social" value="" placeholder="Razón social" class="form-control h-1 w-porc-90"/>
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
								<li id="nuevo" data-toggle='modal' data-target='#add_proyecto'>Proyecto</li>
							</ul>
							<ul id="limpiarC" class="lista_botones">
								<li id="limpiar">Limpiar</li>
							</ul>
							<ul id="buscarC" class="lista_botones">
								<li id="buscar">Buscar</li>
							</ul> 
						</div>
						<div id="lineaResultado"><?=$titulo;?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12 pall-0">
					<table class="fuente8 display" id="table-proyecto">
						<div id="cargando_datos" class="loading-table">
							<img src="<?=base_url().'images/loading.gif?='.IMG;?>">
						</div>
						<thead>
							<tr class="cabeceraTabla">
								<td style="width:10%" data-orderable="true">RUC</td>
								<td style="width:30%" data-orderable="true">RAZÓN SOCIAL</td>
								<td style="width:40%" data-orderable="true">PROYECTO</td>
								<td style="width:05%" data-orderable="false"></td>
								<td style="width:05%" data-orderable="false"></td>
								<td style="width:05%" data-orderable="false"></td>
								<td style="width:05%" data-orderable="false"></td>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="add_proyecto" class="modal fade" role="dialog">
	<div class="modal-dialog w-porc-60">
		<div class="modal-content">
			<form id="formProyecto" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
				</div>
				<div style="text-align: center;">
					<h3><b>REGISTRAR PROYECTO</b></h3>
				</div>
				<div class="modal-body panel panel-default">
					<input type="hidden" id="proyecto" name="proyecto" value="">

					<div class="row form-group">
						<div class="col-sm-11 col-md-11 col-lg-11 header">
							<span>CLIENTE</span>
							<input type="hidden" id="cliente" name="cliente" value="">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="ruc">RUC</label>
							<input type="number" id="ruc" name="ruc" class="form-control h-2" placeholder="Número de documento" value="">
						</div>
						<div class="col-sm-5 col-md-5 col-lg-5">
							<label for="razon_social">RAZÓN SOCIAL</label>
							<input type="text" id="razon_social" name="razon_social" class="form-control h-2" placeholder="Razón social" value="">
						</div>
					</div>

					<div class="row form-group">
						<div class="col-sm-11 col-md-11 col-lg-11 header">
							<span>INFORMACIÓN DEL PROYECTO</span>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-5 col-md-5 col-lg-5">
							<label for="nombre_proyecto">NOMBRE *</label>
							<input type="text" id="nombre_proyecto" name="nombre_proyecto" class="form-control h-2" placeholder="Nombre del proyecto" value="">
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="fecha_inicio">FECHA DE INICIO *</label>
							<input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control h-2" value="">
						</div>
						<div class="col-sm-2 col-md-2 col-lg-2">
							<label for="fecha_final">FECHA FINAL *</label>
							<input type="date" id="fecha_final" name="fecha_final" class="form-control h-2" value="">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-10 col-md-10 col-lg-10">
							<label for="codigo_proyecto">DESCRIPCIÓN *</label>
							<textarea id="descripcion_proyecto" name="descripcion_proyecto" class="form-control h-5" placeholder="Descripción del proyecto"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" accesskey="x" onclick="registrar_proyecto()">Guardar Registro</button>
					<button type="button" class="btn btn-info" onclick="clean()">Limpiar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modalDirections" class="modal fade" role="dialog">
	<div class="modal-dialog w-porc-80">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"></h4>
			</div>
			<div style="text-align: center;">
				<h3><b>DIRECCIONES REGISTRADAS</b></h3>
			</div>
			<div class="modal-body panel panel-default">
				<div class="row form-group">
					<div class="col-sm-11 col-md-11 col-lg-11 header">
						<span>CLIENTE</span>
					</div>
				</div>
				<div class="row form-group font-9">
          <div class="col-sm-2 col-md-2 col-lg-2">
            <label>RUC / DNI:</label> <span class="modal_ruc"></span>
          </div>
          <div class="col-sm-8 col-md-8 col-lg-8">
            <label>RAZÓN SOCIAL:</label> <span class="modal_razonSocial"></span>
          </div>
        </div>

        <div class="row form-group">
					<div class="col-sm-11 col-md-11 col-lg-11 header">
						<span>INFORMACIÓN DEL PROYECTO</span>
					</div>
				</div>
        <div class="row form-group font-9">
          <div class="col-sm-4 col-md-4 col-lg-4">
            <label>TITULO: </label> <span class="modal_titulo"></span>
          </div>
          <div class="col-sm-3 col-md-3 col-lg-3">
            <label>FECHA INICIO:</label> <span class="modal_fechaInicio"></span>
          </div>
          <div class="col-sm-3 col-md-3 col-lg-3">
            <label>FECHA FINAL:</label> <span class="modal_fechaFinal"></span>
          </div>
        </div>

        <div class="row form-group font-9">
          <div class="col-sm-10 col-md-10 col-lg-10">
            <label>DESCRIPCIÓN:</label> <span class="modal_descripcion"></span>
          </div>
          <div class="col-sm-1 col-md-1 col-lg-1">
          	<button type="button" class="btn btn-primary" data-toggle='modal' data-target='#add_directions' onclick="clean_direction();">Agregar dirección</button>
          </div>
        </div>

				<div class="row form-group">
          <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <table class="fuente8 display" id="table-directions">
              <div id="cargando_datos" class="loading-table">
                <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
              </div>
              <thead>
                <tr class="cabeceraTabla">
                    <td style="width:30%" data-orderable="true">DIRECCIÓN</td>
                    <td style="width:24%" data-orderable="true">REFERENCIA</td>
                    <td style="width:12%" data-orderable="true">DEPARTAMENTO</td>
                    <td style="width:12%" data-orderable="true">PROVINCIA</td>
                    <td style="width:12%" data-orderable="true">DISTRITO</td>
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

<div id="add_directions" class="modal fade" role="dialog">
	<div class="modal-dialog w-porc-60">
		<div class="modal-content">
			<form id="formDirections" method="POST">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
				</div>

				<div class="modal-body panel panel-default">
					<input type="hidden" id="direction_id" name="direction_id" value="">
					<input type="hidden" id="proyecto_id" name="proyecto_id" value="">

					<div class="row form-group">
						<div class="col-sm-11 col-md-11 col-lg-11">
							<label for="direccion_proyecto">DIRECCIÓN *</label>
							<input type="text" id="direccion_proyecto" name="direccion_proyecto" class="form-control h-2" placeholder="Indica la dirección del proyecto" value="" maxlength="200">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-11 col-md-11 col-lg-11">
							<label for="referencia_proyecto">REFERENCIA</label>
							<input type="text" id="referencia_proyecto" name="referencia_proyecto" class="form-control h-2" placeholder="Agrega una referencia" value="" maxlength="200">
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

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" accesskey="x" onclick="register_directions();">Guardar</button>
					<button type="button" class="btn btn-info" onclick="clean_direction();">Limpiar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal_infoProyecto" class="modal fade" role="dialog">
  <div class="modal-dialog w-porc-70">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center">INFORMACIÓN DEL PROYECTO</h4>
      </div>
      <div class="modal-body panel panel-default">
      	<div class="row form-group">
					<div class="col-sm-11 col-md-11 col-lg-11 header">
						<span>CLIENTE</span>
					</div>
				</div>
        <div class="row form-group font-9">
          <div class="col-sm-2 col-md-2 col-lg-2">
            <label>RUC / DNI:</label> <span class="modal_ruc"></span>
          </div>
          <div class="col-sm-8 col-md-8 col-lg-8">
            <label>RAZÓN SOCIAL:</label> <span class="modal_razonSocial"></span>
          </div>
        </div>

        <div class="row form-group">
					<div class="col-sm-11 col-md-11 col-lg-11 header">
						<span>PROYECTO</span>
					</div>
				</div>
        <div class="row form-group font-9">
          <div class="col-sm-4 col-md-4 col-lg-4">
            <label>TITULO: </label> <span class="modal_titulo"></span>
          </div>
          <div class="col-sm-3 col-md-3 col-lg-3">
            <label>FECHA INICIO:</label> <span class="modal_fechaInicio"></span>
          </div>
          <div class="col-sm-3 col-md-3 col-lg-3">
            <label>FECHA FINAL:</label> <span class="modal_fechaFinal"></span>
          </div>
        </div>

        <div class="row form-group font-9">
          <div class="col-sm-11 col-md-11 col-lg-11">
            <label>DESCRIPCIÓN:</label> <span class="modal_descripcion"></span>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <table class="fuente8 display" id="table-comprobantes">
              <thead>
                <tr>
                  <th style="width:10%;" data-orderable="true">FECHA</th>
                  <th style="width:35%;" data-orderable="true">EMPRESA EMISORA</th>
                  <th style="width:15%;" data-orderable="true">DOCUMENTO</th>
                  <th style="width:05%;" data-orderable="true">SERIE</th>
                  <th style="width:05%;" data-orderable="true">NÚMERO</th>
                  <th style="width:05%;" data-orderable="true">MONEDA</th>
                  <th style="width:10%;" data-orderable="true">IMPORTE</th>
                  <th style="width:10%;" data-orderable="true">ESTADO</th>
                  <th style="width:05%;" data-orderable="true"></th>
                </tr>
              </thead>
              <tbody class="comprobantes-info"></tbody>
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

<script type="text/javascript">
	base_url = "<?=$base_url;?>";

	$(document).ready(function(){
		$('#table-proyecto').DataTable({ responsive: true,
			filter: false,
			destroy: true,
			processing: true,
			serverSide: true,
			autoWidth: false,
			ajax:{
				url : '<?=base_url();?>index.php/maestros/proyecto/datatable_proyecto/',
				type: "POST",
				data: { dataString: "" },
				beforeSend: function(){
					$("#table-proyecto .loading-table").show();
				},
				error: function(){
				},
				complete: function(){
					$("#table-proyecto .loading-table").hide();
				}
			},
			language: spanish,
			//columnDefs: [{"className": "dt-center", "targets": 0}],
			order: [[ 0, "asc" ]]
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

		$('#search_proyecto').keyup(function(e){
			if ( e.which == 13 ){
				if( $(this).val() != '' )
					search();
			}
		});

		$("#search_razon_social").autocomplete({
			source: function (request, response) {
				$.ajax({
					url: base_url + "index.php/ventas/cliente/autocomplete/",
					type: "POST",
					data: {
						term: $("#search_razon_social").val()
					},
					dataType: "json",
					success: function (data) {
						response(data);
					}
				});
			},
			select: function (event, ui){
				$("#search_cliente").val(ui.item.codigo);
				$("#search_ruc").val(ui.item.ruc);
				$("#search_razon_social").val(ui.item.nombre);
			},
			minLength: 2
		});		

		$("#search_ruc").autocomplete({
			source: function (request, response) {
				$.ajax({
					url: base_url + "index.php/ventas/cliente/autocomplete_ruc/",
					type: "POST",
					data: {
						term: $("#search_ruc").val()
					},
					dataType: "json",
					success: function (data){
						response(data);
					}
				});
			},
			select: function (event, ui) {
				$("#search_cliente").val(ui.item.codigo);
				$("#search_ruc").val(ui.item.ruc);
				$("#search_razon_social").val(ui.item.nombre);
			},
			minLength: 2
		});

		$("#razon_social").autocomplete({
			source: function (request, response) {
				$.ajax({
					url: base_url + "index.php/ventas/cliente/autocomplete/",
					type: "POST",
					data: {
						term: $("#razon_social").val()
					},
					dataType: "json",
					success: function (data) {
						response(data);
					}
				});
			},
			select: function (event, ui){
				$("#cliente").val(ui.item.codigo);
				$("#ruc").val(ui.item.ruc);
				$("#razon_social").val(ui.item.nombre);
			},
			minLength: 2
		});

		$("#ruc").autocomplete({
			source: function (request, response) {
				$.ajax({
					url: base_url + "index.php/ventas/cliente/autocomplete_ruc/",
					type: "POST",
					data: {
						term: $("#ruc").val()
					},
					dataType: "json",
					success: function (data){
						response(data);
					}
				});
			},
			select: function (event, ui) {
				$("#cliente").val(ui.item.codigo);
				$("#ruc").val(ui.item.ruc);
				$("#razon_social").val(ui.item.nombre);
			},
			minLength: 2
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
	});

	function search( search = true){
		if (search == true){
			search_proyecto = $("#search_proyecto").val();
			search_cliente = $("#search_cliente").val();
		}
		else{
			$("#search_proyecto").val("");
			$("#search_cliente").val("");

			search_proyecto = "";
			search_cliente = "";

			$("#search_ruc").val("");
			$("#search_razon_social").val("");
		}

		$('#table-proyecto').DataTable({ responsive: true,
			filter: false,
			destroy: true,
			processing: true,
			serverSide: true,
			ajax:{
				url : '<?=base_url();?>index.php/maestros/proyecto/datatable_proyecto/',
				type: "POST",
				data: {
					search_proyecto: search_proyecto,
					search_cliente: search_cliente
				},
				beforeSend: function(){
					$("#table-proyecto .loading-table").show();
				},
				error: function(){
				},
				complete: function(){
					$("#table-proyecto .loading-table").hide();
				}
			},
			language: spanish,
			columnDefs: [{"className": "dt-center", "targets": 0}],
			order: [[ 0, "asc" ]]
		});
	}

	function editar(id){
		var url = base_url + "index.php/maestros/proyecto/getProyecto";
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			data:{
				proyecto: id
			},
			beforeSend: function(){
				clean();
			},
			success: function(data){
				if (data.match == true) {
					info = data.info;

					$("#proyecto").val(info.proyecto);
					$("#cliente").val(info.cliente);
					$("#ruc").val(info.ruc);
					$("#razon_social").val(info.razon_social);
					$("#nombre_proyecto").val(info.nombre_proyecto);
					$("#fecha_inicio").val(info.fecha_inicio);
					$("#fecha_final").val(info.fecha_final);
					$("#descripcion_proyecto").val(info.descripcion_proyecto);

					$("#add_proyecto").modal("toggle");
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

	function viewInfo(id){
		var url = base_url + "index.php/maestros/proyecto/getProyecto";
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			data:{
				proyecto: id
			},
			beforeSend: function(){
				$('#table-comprobantes').DataTable().destroy();
        $("#table-comprobantes .comprobantes-info").html("");
			},
			success: function(data){
				if (data.match == true) {
					info = data.info;
					docs = data.comprobantes;

					$(".modal_ruc").html(info.ruc);
					$(".modal_razonSocial").html(info.razon_social);
					$(".nombre_proyecto").html(info.nombre_proyecto);

					$(".modal_ruc").html(info.ruc);
					$(".modal_razonSocial").html(info.razon_social);
					$(".modal_titulo").html(info.nombre_proyecto);
					$(".modal_fechaInicio").html(info.fecha_inicio_corta);
					$(".modal_fechaFinal").html(info.fecha_final_corta);

					if (info.descripcion_proyecto != "")
						$(".modal_descripcion").html(info.descripcion_proyecto);
					else
						$(".modal_descripcion").html("Sin descripción.");

					if (docs != null){
						$.each(docs, function(i,item){
	            tr = '<tr>';
	              tr += '<td>' + item.fecha + '</td>';
	              tr += '<td>' + item.empresa_emisora + '</td>';
	              tr += '<td>' + item.documento + '</td>';
	              tr += '<td>' + item.serie + '</td>';
	              tr += '<td>' + item.numero + '</td>';
	              tr += '<td>' + item.moneda + '</td>';
	              tr += '<td>' + item.importe + '</td>';
	              tr += '<td>' + item.estado + '</td>';
	              tr += '<td>' + item.pdf + '</td>';
	            tr += '</tr>';

	            $("#table-comprobantes .comprobantes-info").append(tr);
	          });
		        
		        $('#table-comprobantes').DataTable({ responsive: true,
		            filter: false,
		            destroy: true,
		            autoWidth: false,
		            language: spanish
		        });
					}
					else{
	            tr = '<tr>';
	              tr += '<td colspan="6">No se encontraron facturas, boletas o comprobantes asociados.</td>';
	            tr += '</tr>';
					}

					$("#modal_infoProyecto").modal("toggle");
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

	function registrar_proyecto(){
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
				var proyecto = $("#proyecto").val();
				var cliente = $("#cliente").val();
				var ruc = $("#ruc").val();
				var razon_social = $("#razon_social").val();
				var nombre_proyecto = $("#nombre_proyecto").val();
				var fecha_inicio = $("#fecha_inicio").val();
				var fecha_final = $("#fecha_final").val();
				var descripcion_proyecto = $("#descripcion_proyecto").val();

				validacion = true;

				if (cliente == ""){
					Swal.fire({
						icon: "error",
						title: "Verifique los datos ingresados.",
						html: "<b class='color-red'>Debe seleccionar un cliente.</b>",
						showConfirmButton: true,
						timer: 4000
					});
					$("#cliente").focus();
					validacion = false;
					return null;
				}

				if (nombre_proyecto == ""){
					Swal.fire({
						icon: "error",
						title: "Verifique los datos ingresados.",
						html: "<b class='color-red'>Debe ingresar el nombre del proyecto.</b>",
						showConfirmButton: true,
						timer: 4000
					});
					$("#nombre_proyecto").focus();
					validacion = false;
					return null;
				}

				if (validacion == true){
					var url = base_url + "index.php/maestros/proyecto/guardar_registro";
					var info = $("#formProyecto").serialize();
					$.ajax({
						type: 'POST',
						url: url,
						dataType: 'json',
						data: info,
						success: function(data){
							if (data.result == "success") {
								if (proyecto == "")
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
									html: "<b class='color-red'>La información no fue registrada/actualizada, intentelo nuevamente.</b>",
									showConfirmButton: true,
									timer: 4000
								});
							}
						},
						complete: function(){
							$("#descripcion_proyecto").focus();
						}
					});
				}
			}
		});
	}

	function deshabilitar(proyecto){
		Swal.fire({
			icon: "info",
			title: "Debe confirmar esta acción.",
			html: "<b class='color-red'>Esta acción no se puede deshacer</b>",
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonText: "Aceptar",
			cancelButtonText: "Cancelar"
		}).then(result => {
			if (result.value){
				var url = base_url + "index.php/maestros/proyecto/deshabilitar_proyecto";
				$.ajax({
					type: 'POST',
					url: url,
					dataType: 'json',
					data: {
						proyecto: proyecto
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
								html: "<b class='color-red'>Algo ha ocurrido, verifique he intentelo nuevamente.</b>",
								showConfirmButton: true,
								timer: 4000
							});
						}
					},
					complete: function(){
						search(false);
					}
				});
			}
		});
	}

	function clean(){
		$("#formProyecto")[0].reset();
		$("#proyecto").val("");
		$("#cliente").val("");
	}

	function viewdirections(id){
		var url = base_url + "index.php/maestros/proyecto/getProyecto";
		$.ajax({
			type: 'POST',
			url: url,
			dataType: 'json',
			data:{
				proyecto: id
			},
			beforeSend: function(){
			},
			success: function(data){
				if (data.match == true) {
					info = data.info;

					$(".modal_ruc").html(info.ruc);
					$(".modal_razonSocial").html(info.razon_social);
					$(".nombre_proyecto").html(info.nombre_proyecto);
					$(".modal_titulo").html(info.nombre_proyecto);
					$(".modal_fechaInicio").html(info.fecha_inicio_corta);
					$(".modal_fechaFinal").html(info.fecha_final_corta);

					if (info.descripcion_proyecto != "")
						$(".modal_descripcion").html(info.descripcion_proyecto);
					else
						$(".modal_descripcion").html("Sin descripción.");

					$("#modalDirections").modal("toggle");
					getTableDirections(id);
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
				$("#proyecto_id").val(id);
			}
		});
	}

	function getTableDirections(id){
    $('#table-directions').DataTable({ responsive: true,
      filter: false,
      destroy: true,
      processing: true,
      serverSide: true,
      autoWidth: false,
      ajax:{
              url : '<?=base_url();?>index.php/maestros/proyecto/datatable_directions',
              type: "POST",
              data: {
                  proyecto: id
              },
              beforeSend: function(){
                  $("#table-directions .loading-table").show();
              },
              error: function(){
              },
              complete: function(){
                  $("#table-directions .loading-table").hide();
              }
      },
      language: spanish,
      order: [[ 0, "asc" ]]
    });
  }

  function editar_directions( id ){
    var url = base_url + "index.php/maestros/proyecto/getDirection";
    $.ajax({
      type: 'POST',
      url: url,
      dataType: 'json',
      data:{
            direction: id
      },
      beforeSend: function(){
        $("#add_directions").modal("toggle");
      },
      success: function(data){
        if (data.match == true) {
          info = data.info;

          $("#direction_id").val(info.direction_id);
          $("#proyecto_id").val(info.proyecto);
          $("#direccion_proyecto").val(info.direccion);
          $("#referencia_proyecto").val(info.referencia);

          $("#departamento").val(info.departamento);
          getProvincias(info.departamento, info.provincia, "", "", false)
          getDistritos(info.departamento, info.provincia, info.distrito)
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

  function register_directions(){
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
                      var url = base_url + "index.php/maestros/proyecto/save_direction";

                      var id = $("#direction_id").val();
                      var proyecto = $("#proyecto_id").val();
                      var direccion = $("#direccion_proyecto").val();

                      validacion = true;

                      if (proyecto == ""){
                          Swal.fire({
                                      icon: "info",
                                      title: "Falta la asignación del proyecto",
                                      html: "<b class='color-red'>Cierre esta ventana he intentelo nuevamente.</b>",
                                      showConfirmButton: true,
                                      timer: 4000
                                  });
                          validacion = false;
                          return false;
                      }

                      if (direccion == ""){
                          Swal.fire({
                                      icon: "info",
                                      title: "Verifique los datos ingresados.",
                                      html: "<b class='color-red'>Debe ingresar una dirección.</b>",
                                      showConfirmButton: true,
                                      timer: 4000
                                  });
                          $("#direccion_proyecto").focus();
                          validacion = false;
                          return false;
                      }

                      if (validacion == true){
                          var dataForm = $("#formDirections").serialize();
                          $.ajax({
                              type: 'POST',
                              url: url,
                              dataType: 'json',
                              data: dataForm,
                              success: function(data){
                                  if (data.result == "success") {
                                      if (id == "")
                                          titulo = "¡Registro exitoso!";
                                      else
                                          titulo = "¡Actualización exitosa!";

                                      Swal.fire({
                                          icon: "success",
                                          title: titulo,
                                          showConfirmButton: true,
                                          timer: 2000
                                      });

                                      clean_direction();
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
                                  getTableDirections(proyecto);
                              }
                          });
                      }
                  }
              });
  }

  function disable_directions(id, proyecto = 0){
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
                      var url = base_url + "index.php/maestros/proyecto/disable_direction";
                      $.ajax({
                          type: 'POST',
                          url: url,
                          dataType: 'json',
                          data: {
                              direccion: id
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
                          	if (proyecto > 0)
                              getTableDirections(proyecto);
                          }
                      });
                  }
              });
  }

  function clean_direction(){
  	$("#formDirections")[0].reset();
    $("#direction_id").val("");
  }

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
                if (inputProv == "")
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
</script>