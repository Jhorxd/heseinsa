<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
#detalles{
    font-size: 12px;
    background-color: #849cb6;
    padding: 2px;
    border-radius: 5px 5px 5px 5px ;
    width: 55%;
}

.small-box {
    border-radius: 0.25rem;
    box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
    display: block;
    margin-bottom: 20px;
    position: relative;
} 

.bg-danger, .bg-danger>a {
    color: #fff!important;
}

.bg-warning {
    background-color: #ffc107!important;
}

.bg-danger {
    background-color: #dc3545!important;
}


.bg-warning, .bg-warning>a {
    color: #1f2d3d!important;
}

.bg-info {
    background-color: #17a2b8!important;
}   

.bg-info, .bg-info>a {
    color: #fff!important;
}

.bg-success {
    background-color: #28a745!important;
}

.bg-success, .bg-success>a {
    color: #fff!important;
}

.small-box>.inner {
    padding: 10px;

}

.small-box .icon {
    color: rgba(0,0,0,.15);
    z-index: 0;
}

.small-box h3 {
    font-size: 3.2rem;
    font-weight: 700;
    margin: 0 0 10px;
    padding: 0;
    white-space: nowrap;
}


.small-box .icon>i {
    font-size: 90px;
    position: absolute;
    right: 15px;
    top: 15px;
    transition: -webkit-transform .3s linear;
    transition: transform .3s linear;
    transition: transform .3s linear,-webkit-transform .3s linear;
}

.small-box .icon>i.fa, .small-box .icon>i.fab, .small-box .icon>i.fad, .small-box .icon>i.fal, .small-box .icon>i.far, .small-box .icon>i.fas, .small-box .icon>i.ion {
    font-size: 70px;
    top: 20px;
}

</style>
<style>

/* Style the tab */
.tab {
  overflow: hidden;TK64374
  border: 1px solid #337ab7;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #33ace1;
  color: #fff;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #337ab7;
  color: #fff;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  -webkit-animation: fadeEffect 1s;
  animation: fadeEffect 1s;
}

/* Fade in tabs */
@-webkit-keyframes fadeEffect {
  from {opacity: 0;}
  to {opacity: 1;}
}

@keyframes fadeEffect {
  from {opacity: 0;}
  to {opacity: 1;}
}

.mes {
  display: none;
  
}
.anio {
  display: none;

}

</style>
</head>
<input type="hidden" name="tipo_oper" id="tipo_oper" value="<?=$tipo_oper;?>">

<div class="container-fluid">

    <h3>REPORTE VENTAS POR CLIENTES</h3>

    <div class="tab">
      <button class="tablinks" onclick="verReporteTabla(event, 'general');search_general();">GENERAL</button>
      <button class="tablinks" onclick="verReporteTabla(event, 'detallado');search_detallado(true);">DETALLADO</button>
      <!--<button class="tablinks" onclick="verReporteTabla(event, 'mensual');search_mensual(true);">MENSUAL</button>
      <button class="tablinks" onclick="verReporteTabla(event, 'anual');search_anual(true);">ANUAL</button>-->
    </div>

    <div class="row fuente8 py-1">
        <div class="col-sm-5 col-md-2 rango_fechas">
            <label for="searchFechaDesde">Desde</label>
            <input type="date" name="searchFechaDesde" id="searchFechaDesde" value="" class="form-control h-1" />
        </div>
        <div class="col-sm-5 col-md-2 rango_fechas">
            <label for="searchFechaHasta">Hasta</label>
            <input type="date" name="searchFechaHasta" id="searchFechaHasta" value="" class="form-control h-1" />
        </div>
        <div class="col-sm-5 col-md-2 mes">
            <label for="searchMesDesde">Desde</label>
            <input type="month" name="searchMesDesde" id="searchMesDesde" value="" class="form-control h-1" />
        </div>
        <div class="col-sm-5 col-md-2 mes">
            <label for="searchMesHasta">Hata</label>
            <input type="month" name="searchMesHasta" id="searchMesHasta" value="" class="form-control h-1" />
        </div>
        
        <div class="col-sm-5 col-md-2 anio">
            <label for="searchAnioI">Año</label>
            <select id="searchAnioI" name="searchAnioI" class="form-control h-2">
                <?php
                if (count($anios) > 0) {
                    foreach ($anios as $i => $val) { ?>
                        <option value="<?= $val->anio; ?>" <?php echo ($val->anio==date('Y'))?"selected":"";?>><?= "$val->anio"; ?></option>
                    <?php
                    }
                } ?>
            </select>
        </div>
        <div class="col-sm-5 col-md-2 anio">
            <label for="searchAnioF">Año</label>
            <select id="searchAnioF" name="searchAnioF" class="form-control h-2">
                <?php
                if (count($anios) > 0) {
                    foreach ($anios as $i => $val) { ?>
                        <option value="<?= $val->anio; ?>" <?php echo ($val->anio==date('Y'))?"selected":"";?>><?= "$val->anio"; ?></option>
                    <?php
                    }
                } ?>
            </select>
        </div>
        
        <div class="col-sm-5 col-md-1">
            <label for="searchProductoAU">Producto</label>
            <input type="text" id="searchCodigo" readonly value="" class="form-control h-1" />
        </div>
        <div class="col-sm-6 col-md-3">
            <label for="searchProductoAU">&nbsp;</label>
            <input type="hidden" name="searchProducto" id="searchProducto" value="" class="form-control h-1" />
            <input type="text" id="searchProductoAU" value=""  placeholder="Codigo o descripcion" class="form-control h-1" />
        </div>
    </div>
    <div class="row fuente8 py-1">
        <div class="col-sm-5 col-md-1">
            <label for="search_documento">Número de documento</label>
            <input type="text" name="search_documento" id="search_documento" value="" placeholder="Documento" class="form-control h-1 w-porc-90"/>
        </div>
        <div class="col-sm-6 col-md-3">
            <label for="nombre_cliente">Nombre</label>
            <input type="text" name="nombre_cliente" id="nombre_cliente" placeholder="Buscar cliente" class="form-control h-1 w-porc-90"/>
            <input type="hidden" name="cliente" id="cliente" value=""/>
        </div>
        <div class="col-sm-11 col-md-2">
            <label for="moneda">Moneda</label>
            <select id="moneda" name="moneda" class="form-control h-2">
                <?php
                if (count($listado_moendas) > 0) {
                    foreach ($listado_moendas as $i => $val) { ?>
                        <option value="<?= $val->MONED_Codigo; ?>"><?= "$val->MONED_Simbolo - $val->MONED_Descripcion"; ?></option>
                    <?php
                    }
                } ?>
            </select>
        </div>
    </div>


    <div id="general" class="tabcontent">
        <div class="row">
	        <div class="col-lg-2 col-2">
		        <h3>Reporte General</h3>
		        </div>
	        <div class="col-lg-2 col-2">
	            <button class="btn btn-primary " id="buscarG" name="buscarG">Buscar</button>
	            <button class="btn btn-primary" id="limpiarG" name="limpiarG">Limpiar</button>
	        </div>
	        <div class="col-lg-2 col-2">
	            <!-- small box -->
	            <div class="small-box bg-info">
	                <div class="inner">
	                    <h3 id="cantidad_totalG" name="cantidad_totalG">0</h3>
	                    <p>Cantidad</p>
	                </div>
	                <div class="icon">
	                    <i class="ion ion-bag"></i>
	                </div>
	            </div>
	        </div>
	        <div class="col-lg-2 col-2" hidden>
	            <!-- small box -->
	            <div class="small-box bg-info">
	                <div class="inner">
	                    <h3 id="total_globalG" name="total_globalG">S/ 0.00</h3>
	                    <p>Total Global</p>
	                </div>
	                <div class="icon">
	                    <i class="ion ion-bag"></i>
	                </div>
	            </div>
	            
	        </div>
	        <div class="col-lg-2 col-2">
	        		<label>Reporte general</label><br>
	            <a href="javascript:;" id="verReporte2"><img src="<?php echo base_url();?>images/xls.png" style="width:40px; border:none; color: #000 !important;" class="imgBoton" align="absmiddle"/></a>
	        </div>
        </div>
       

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                        <div class="header text-align-center">RESULTADOS</div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
											<table class="table table-striped" id="table-general">
												<thead style="background-color: #babac299;">
													<tr>
														<th scope="col">Nº DOC.</th>
														<th scope="col">COMPROBANTE</th>
														<th scope="col">RAZON SOCIAL</th>
														<th scope="col">TOTAL</th>
														<th scope="col">FECHA</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="detallado" class="tabcontent">
    	<div class="row">
        <div class="col-lg-2 col-2">
        <h3>Reporte de Ventas por Producto</h3>
        </div>
        <div class="col-sm-11 col-md-2">
            <button class="btn btn-primary " id="buscarD" name="buscarD">Buscar</button>
            <button class="btn btn-primary" id="limpiarD" name="limpiarD">Limpiar</button>
        </div>
        <div class="col-lg-2 col-2" >
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="cantidad_totalD" name="cantidad_totalD">0</h3>
                    <p>Cantidad</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-2" hidden>
            <!-- small box -->
            <div class="small-box bg-info" >
                <div class="inner">
                    <h3 id="total_globalD" name="total_globalD">S/ 0.00</h3>
                    <p>Total Global</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>

            </div>
        </div>

        <div class="col-lg-2 col-2">
	        		<label>Reporte Detallado</label><br>
	            <a href="javascript:;" id="verReporteCliente"><img src="<?php echo base_url();?>images/xls.png" style="width:40px; border:none;" class="imgBoton" align="absmiddle"/></a>
	        </div>
	      </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                        <div class="header text-align-center">RESULTADOS</div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
											<table class="table table-striped" id="table-detallado">
												<thead style="background-color: #babac299;">
													<tr>
														<th scope="col">Nº DOC.</th>
														<th scope="col">COMPROBANTE</th>
														<th scope="col">RAZON SOCIAL</th>
														<th scope="col">TOTAL</th>
														<th scope="col">FECHA</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
<div class="col-md-6" id="chart">
<canvas id="myChart"></canvas>
</div>
<div class="col-md-5" id="chart2">
<canvas id="myChart2"></canvas>
</div> 

<!--FIN container-fluid-->
</div>

<script type="text/javascript">
	$(document).ready(function() {
		
		$("#buscarG").click(function() {
			search_general();
		});
		$("#buscarD").click(function() {
			search_detallado();
		});

		$("#limpiarD").click(function() {
			$("#cliente").val("");
			$("#searchCodigo").val("");
			$("#searchProducto").val("");
			$("#searchProductoAU").val("");
			$("#buscar_cliente").val("");
			$("#nombre_cliente").val("");
			$("#searchFechaDesde").val("");
			$("#searchFechaHasta").val("");
			$("#todos_total").prop("checked", false);
			search_detallado(false);
		});

		$("#limpiarD").click(function() {
			$("#cliente").val("");
			$("#searchCodigo").val("");
			$("#searchProducto").val("");
			$("#searchProductoAU").val("");
			$("#buscar_cliente").val("");
			$("#nombre_cliente").val("");
			$("#searchFechaDesde").val("");
			$("#searchFechaHasta").val("");
			$("#todos_total").prop("checked", false);
			search_general(false);
		});
  });

		function search_general() {
			//let acumulado=0;
			//if ($("#todos_total").prop("checked"))
			let acumulado = 1;

			let fecha_inicio 	= $("#searchFechaDesde").val();
			let fecha_fin 		= $("#searchFechaHasta").val();
			cliente 					= $("#cliente").val();
			$('#table-general').DataTable({
				filter: false,
				destroy: true,
				processing: true,
				serverSide: true,
				autoWidth: false,
				ajax:{
					url : '<?=base_url();?>index.php/reportes/ventas/datatable_ventas_clientes/',
					type: "POST",
					data: {
						cliente: cliente,
						acumulado:acumulado,
						fecha_inicio: fecha_inicio,
						fecha_fin: fecha_fin
					},
					beforeSend: function(){
					},
					error: function(){
					},
					complete: function(data){
					},
				},
				language: spanish,
				"drawCallback": function(settings) {

					if (settings.json.data_mostrar.length>0) 
					{
						mostrar_grafica(settings.json.data_mostrar);
						mostrar_grafica2(settings.json.data_mostrar);					
					}

					document.getElementById("cantidad_totalG").innerHTML = settings.json.cantidad_total;
          document.getElementById("total_globalG").innerHTML = settings.json.total_global;

				}
			});
		}

		function search_detallado() {
			//let acumulado=0;
			//if ($("#todos_total").prop("checked"))
			let acumulado = 0;

			let fecha_inicio 	= $("#searchFechaDesde").val();
			let fecha_fin 		= $("#searchFechaHasta").val();
			cliente 					= $("#cliente").val();
			searchProducto 		= $("#searchProducto").val();
			$('#table-detallado').DataTable({
				filter: false,
				destroy: true,
				processing: true,
				serverSide: true,
				autoWidth: false,
				ajax:{
					url : '<?=base_url();?>index.php/reportes/ventas/datatable_ventas_clientes/',
					type: "POST",
					data: {
						cliente: cliente,
						acumulado:acumulado,
						fecha_inicio:fecha_inicio,
						fecha_fin:fecha_fin
					},
					beforeSend: function(){
					},
					error: function(){
					},
					complete: function(data){
				      
					},
				},
				language: spanish,
				"drawCallback": function(settings) {

					if (settings.json.data_mostrar.length>0) 
					{
						mostrar_grafica(settings.json.data_mostrar);
						mostrar_grafica2(settings.json.data_mostrar);					
					}

					document.getElementById("cantidad_totalD").innerHTML = settings.json.cantidad_total;
          			document.getElementById("total_globalD").innerHTML = settings.json.total_global;


				}
			});
		}

		function search_detallado___() {
			//let acumulado=0;
			//if ($("#todos_total").prop("checked"))
			let acumulado = 0;

			let fecha_inicio 	= $("#searchFechaDesde").val();
			let fecha_fin 		= $("#searchFechaHasta").val();
			cliente 					= $("#cliente").val();
			$('#table_result').DataTable({
				filter: false,
				destroy: true,
				processing: true,
				serverSide: true,
				autoWidth: false,
				ajax:{
					url : '<?=base_url();?>index.php/reportes/ventas/datatable_ventas_clientes/',
					type: "POST",
					data: {
						cliente: cliente,
						acumulado:acumulado,
						fecha_inicio:fecha_inicio,
						fecha_fin:fecha_fin
					},
					beforeSend: function(){
					},
					error: function(){
					},
					complete: function(data){
					},
				},
				language: spanish,
				"drawCallback": function(settings) {

					if (settings.json.data_mostrar.length>0) 
					{
						mostrar_grafica(settings.json.data_mostrar);
						mostrar_grafica2(settings.json.data_mostrar);					
					}

				}
			});
		}

    function verReporteTabla(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }

		function mostrar_grafica(data_get)
		{
				$("#chart").html("");
				$("#chart").html('<canvas id="myChart"></canvas>');

				var labels="";
				var valores="";
				labels=labels+"[";
				valores=valores+"[";

				$.each(data_get,function()
				{
						 valores=valores+this.Total;
						 valores=valores+",";
						 labels=labels+'"'+this.Nombre+'"';
						 labels=labels+",";
				});

				labels=labels.substring(0, labels.length - 1)
				labels=labels+"]";
				valores=valores.substring(0, valores.length - 1)
				valores=valores+"]";
				var labels_array=JSON.parse(labels);
				var valores_array=JSON.parse(valores);


				const data = {
				  labels: labels_array,
				  datasets: [{
				    label: 'Reporte',
				    data: valores_array,
				    backgroundColor: [
				      'rgb(255, 99, 132)',
				      'rgb(54, 162, 235)',
				      'rgb(255, 205, 86)'
				    ],
				    hoverOffset: 4
				  }]
				};
				const config = {
				  type: 'doughnut',
				  data: data,
				};

			  const myChart = new Chart(
			    document.getElementById('myChart'),
			    config
			  );
		}
		function mostrar_grafica2(data_get)
		{
				$("#chart2").html("");
				$("#chart2").html('<canvas id="myChart2"></canvas>');

				var labels="";
				var valores="";
				labels=labels+"[";
				valores=valores+"[";

				$.each(data_get,function()
				{
						 valores=valores+this.Total;
						 valores=valores+",";
						 labels=labels+'"'+this.Nombre+'"';
						 labels=labels+",";
				});

				labels=labels.substring(0, labels.length - 1)
				labels=labels+"]";
				valores=valores.substring(0, valores.length - 1)
				valores=valores+"]";
				var labels_array=JSON.parse(labels);
				var valores_array=JSON.parse(valores);

				const data = {
				  labels: labels_array,
				  datasets: [{
				    label: 'Reporte Barras',
				    data: valores_array,
				    backgroundColor: [
				      'rgb(255, 99, 132)',
				      'rgb(54, 162, 235)',
				      'rgb(255, 205, 86)'
				    ],
				    hoverOffset: 4
				  }]
				};
				const config = {
				  type: 'bar',
				  data: data,
				};

			  const myChart = new Chart(
			    document.getElementById('myChart2'),
			    config
			  );
		}

		$("#verReporteCliente").click(function()
		{
			var cliente 			= $("#cliente").val() > 0 ? $("#cliente").val() : 0;
			var fecha_inicio 	= $("#searchFechaDesde").val();
			var fecha_fin 		= $("#searchFechaHasta").val();
			
			if(fecha_inicio==""){
				Swal.fire({
	          icon: "warning",
	          title: "Debe seleccionar un rango de fecha válido",
	          html: "<b>La descarga fue cancelada.</b>",
	          timer: 2000
	      });
	      return false;
			}

			window.location   = "<?php echo base_url(); ?>index.php/reportes/ventas/reporte_excel/"+cliente+"/"+fecha_inicio+"/"+fecha_fin;
		});

		$("#verReporte").click(function()
		{
			var cliente       = $("#cliente").val() > 0 ? $("#cliente").val() : 0;
			var searchCodigo  = $("#searchProducto").val() > 0 ? $("#searchProducto").val() : 0;
			var fecha_inicio  = $("#searchFechaDesde").val();
			var fecha_fin     = $("#searchFechaHasta").val();
			if(fecha_inicio==""){
				Swal.fire({
	          icon: "warning",
	          title: "Debe seleccionar un rango de fecha válido",
	          html: "<b>La descarga fue cancelada.</b>",
	          timer: 2000
	      });
	      return false;
			}
			window.location="<?php echo base_url(); ?>index.php/reportes/ventas/reporte_excel_producto/"+cliente+"/"+fecha_inicio+"/"+fecha_fin+"/"+searchCodigo;
		});

		$("#verReporte2").click(function()
		{
			var cliente 		= $("#cliente").val()>0?$("#cliente").val():0;
			var fecha_inicio 	= $("#searchFechaDesde").val()!= "" ? $("#searchFechaDesde").val() : 0;
			var fecha_fin 		= $("#searchFechaHasta").val()!= "" ? $("#searchFechaHasta").val() : 0;

			if(fecha_inicio==""){
				Swal.fire({
	          icon: "warning",
	          title: "Debe seleccionar un rango de fecha válido",
	          html: "<b>La descarga fue cancelada.</b>",
	          timer: 2000
	      });
	      return false;
			}
			window.location   = "<?php echo base_url(); ?>index.php/reportes/ventas/reporte_excel/"+cliente+"/"+fecha_inicio+"/"+fecha_fin+"/1";
		});

</script>