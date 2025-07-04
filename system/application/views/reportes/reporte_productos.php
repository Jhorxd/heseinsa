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

<h3>REPORTE VENTAS POR PRODUCTOS</h3>

<div class="tab">
  <button class="tablinks" onclick="verReporteTabla(event, 'general');search_general(true);">GENERAL</button>
  <button class="tablinks" onclick="verReporteTabla(event, 'detallado');search_detallado(true);">DETALLADO</button>
  <button class="tablinks" onclick="verReporteTabla(event, 'mensual');search_mensual(true);">MENSUAL</button>
  <button class="tablinks" onclick="verReporteTabla(event, 'anual');search_anual(true);">ANUAL</button>
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
        <div class="col-sm-11 col-md-2">
            <button class="btn btn-primary " id="buscarG" name="buscarG">Buscar</button>
            <button class="btn btn-primary" id="limpiarG" name="limpiarG">Limpiar</button>
        </div>
        <div class="col-lg-2 col-2">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="cantidad_total" name="cantidad_total">0</h3>
                    <p>Cantidad</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-2">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total_global" name="total_global">S/ 0.00</h3>
                    <p>Total Global</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-2">
            <label>Reporte general</label><br>
            <a href="javascript:;" id="verReporteGeneral"><img src="<?php echo base_url();?>images/xls.png" style="width:40px; border:none; color: #000 !important;" class="imgBoton" align="absmiddle"/></a>
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
                    <table class="fuente8 display" id="tabla-general" data-page-length='25'>
                    <div id="cargando_datos" class="loading-table">
                        <img src="<?= base_url() . 'images/loading.gif?=' . IMG; ?>">
                    </div>
                    <thead>
                        <tr class="cabeceraTabla">
                        <td style="width:15%" data-orderable="true">CODIGO</td>
                        <td style="width:30%" data-orderable="true">DESCRIPCION</td>
                        <td style="width:15%" data-orderable="true">MARCA</td>
                        <td style="width:10%" data-orderable="true">No DOCs</td>
                        <td style="width:10%" data-orderable="false">CANTIDAD</td>
                        <td style="width:10%" data-orderable="false">TOTAL</td>
                        
                        </tr>
                    </thead>
                    <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detallado" class="tabcontent">
    <div class="row">
        <div class="col-lg-2 col-2">
            <h3>Reporte detallado</h3>
        </div>
        <div class="col-lg-2 col-2">
            <button class="btn btn-primary " id="buscarD" name="buscarD">Buscar</button>
            <button class="btn btn-primary" id="limpiarD" name="limpiarD">Limpiar</button>
        </div>
        <div class="col-lg-2 col-2">
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
        <div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-info">
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
            <label>Reporte detallado</label><br>
            <a href="javascript:;" id="verReporteDetallado"><img src="<?php echo base_url();?>images/xls.png" style="width:40px; border:none; color: #000 !important;" class="imgBoton" align="absmiddle"/></a>
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
                    <table class="fuente8 display" id="tabla-detallado" data-page-length='25'>
                    <div id="cargando_datos" class="loading-table">
                        <img src="<?= base_url() . 'images/loading.gif?=' . IMG; ?>">
                    </div>
                    <thead>
                        <tr class="cabeceraTabla">
                        <td style="width:10%" data-orderable="true">FECHA</td>
                        <td style="width:08%" data-orderable="true">Serie-Nro</td>
                        <td style="width:33%" data-orderable="true">NOMBRE</td>
                        <td style="width:38%" data-orderable="true">DESCRIPCION</td>
                        <td style="width:05%" data-orderable="false">UNIDAD</td>
                        <td style="width:08%" data-orderable="false">CANTIDAD</td>
                        <td style="width:08%" data-orderable="false">TOTAL</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="mensual" class="tabcontent">
    <div class="row">
        <div class="col-lg-2 col-2">
            <h3>Reporte mensual<br>(12 meses en pantalla)</h3>
        </div>
        <div class="col-sm-11 col-md-2">
            <button class="btn btn-primary " id="buscarM" name="buscarM">Buscar</button>
            <button class="btn btn-primary" id="limpiarM" name="limpiarM">Limpiar</button>
        </div>
        <div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="cantidad_totalM" name="cantidad_totalM">0</h3>
                    <p>Cantidad</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total_globalM" name="total_globalM">S/ 0.00</h3>
                    <p>Total Global</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-2">
            <label>Reporte mensual</label><br>
            <a href="javascript:;" id="verReporteMensual"><img src="<?php echo base_url();?>images/xls.png" style="width:40px; border:none; color: #000 !important;" class="imgBoton" align="absmiddle"/></a>
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
                    <table class="fuente8 display" id="tabla-mensual" data-page-length='25'>
                    <div id="cargando_datos" class="loading-table">
                        <img src="<?= base_url() . 'images/loading.gif?=' . IMG; ?>">
                    </div>
                    <thead>
                        <tr class="cabeceraTabla viewthead">
                            <td style="width:15%" data-orderable="true">CODIGO</td>
                            <td style="width:30%" data-orderable="true">DESCRIPCION</td>
                            <td style="width:15%" data-orderable="true">MARCA</td>
                            <td style="width:10%" data-orderable="true">No DOCs</td>
                            <td style="width:10%" data-orderable="false">CANTIDAD</td>
                        </tr>
                    </thead>
                    <tbody class="viewData"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="anual" class="tabcontent">
    <div class="row">
        <div class="col-lg-2 col-2">
            <h3>Reporte por año</h3>
        </div>
        <div class="col-lg-2 col-2">
            <button class="btn btn-primary " id="buscarA" name="buscarA">Buscar</button>
            <button class="btn btn-primary" id="limpiarA" name="limpiarA">Limpiar</button>
        </div>
        <div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="cantidad_totalA" name="cantidad_totalA">0</h3>
                    <p>Cantidad</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total_globalA" name="total_globalA">S/ 0.00</h3>
                    <p>Total Global</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-2">
            <label>Reporte anual</label><br>
            <a href="javascript:;" id="verReporteAnual"><img src="<?php echo base_url();?>images/xls.png" style="width:40px; border:none; color: #000 !important;" class="imgBoton" align="absmiddle"/></a>
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
                    <table class="fuente8 display" id="tabla-anual" data-page-length='25'>
                    <div id="cargando_datos" class="loading-table">
                        <img src="<?= base_url() . 'images/loading.gif?=' . IMG; ?>">
                    </div>
                    <thead>
                        <tr class="cabeceraTabla viewtheadA">
                            <td style="width:15%" data-orderable="true">CODIGO</td>
                            <td style="width:30%" data-orderable="true">DESCRIPCION</td>
                            <td style="width:15%" data-orderable="true">MARCA</td>
                            <td style="width:10%" data-orderable="true">No DOCs</td>
                            <td style="width:10%" data-orderable="false">CANTIDAD</td>
                        </tr>
                    </thead>
                    <tbody class="viewDataA"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--FIN container-fluid-->
</div>




































<script type="text/javascript">
    base_url    = "<?= $base_url; ?>";
    tipo_oper   = $("#tipo_oper").val();
    $(document).ready(function() {

        $('#tabla-general').DataTable({
            filter: false,
            destroy: true,
            autoWidth: false,
            language: spanish
            
        });

        $('#tabla-detallado').DataTable({
            filter: false,
            destroy: true,
            autoWidth: false,
            language: spanish
            
        });
        
        $("#buscarG").click(function() {
            search_general();
        });

        $("#limpiarG").click(function() {
            search_general(false);
        });

        $("#buscarD").click(function() {
            search_detallado();
        });

        $("#limpiarD").click(function() {
            search_detallado(false);
        });

        $("#buscarM").click(function() {
            search_mensual();
        });

        $("#limpiarM").click(function() {
            search_mensual(false);
        });

        $("#buscarA").click(function() {
            search_anual();
        });

        $("#limpiarA").click(function() {
            search_anual(false);
        });

        $('#form_busqueda').keypress(function(e) {
            if (e.which == 13) {
                return false;
            }
        });

        $('#search_descripcion').keyup(function(e) {
            if (e.which == 13) {
                if ($(this).val() != '')
                    search();
            }
        });

        $("#getProductoCodigo").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= base_url(); ?>index.php/almacen/inventario/searchProducto/",
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
        });

        $("#getProductoDescripcion").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= base_url(); ?>index.php/almacen/inventario/searchProducto/",
                    type: "POST",
                    data: {
                        nombre: $("#getProductoDescripcion").val(),
                        almacen: $("#almacenFormAjuste").val(),
                        default: "nombre",
                    },
                    dataType: "json",
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $("#productoCodigo").val(ui.item.id);
                $("#getProductoCodigo").val(ui.item.codigo);
                $("#stockProducto").val(ui.item.stock);
                $("#cantidadProducto").focus();
            },
            minLength: 2
        });

        $("#searchProductoAU").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= base_url(); ?>index.php/almacen/inventario/searchProducto/",
                    type: "POST",
                    data: {
                        nombre: $("#searchProductoAU").val(),
                        default: "nombre",
                    },
                    dataType: "json",
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $("#searchProducto").val(ui.item.id);
                $("#searchCodigo").val(ui.item.codigo);
            },
            minLength: 2
        });

        //AUTOCOMPLETE CLIENTE
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
                $("#search_documento").val(ui.item.ruc);
                $("#cliente").val(ui.item.codigo);
            },
            minLength: 2
        });

        // BUSQUEDA POR RUC
        $("#search_documento").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete_ruc/",
                    type: "POST",
                    data: {
                        term: $("#search_documento").val()
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
                $("#search_documento").val(ui.item.ruc);
                $("#cliente").val(ui.item.codigo);
            },
            minLength: 2
        });

        
    });

    function search_general(search = true) {
        let searchSerie         = "";
        let searchNumero        = "";
        let searchFechaDesde    = "";
        let searchFechaHasta    = "";
        let searchResponsable   = "";
        let searchAlmacen       = "";
        let searchProducto      = "";
        let cliente             = "";
        let moneda              = "";
        
        
        $(".mes").css("display","none");
        $(".anio").css("display","none");
        $(".rango_fechas").css("display","block");
        if (search == true) {
            cliente             = $("#cliente").val();
            searchFechaDesde    = $("#searchFechaDesde").val();
            searchFechaHasta    = $("#searchFechaHasta").val();
            searchResponsable   = $("#searchResponsable").val();
            searchProducto      = $("#searchProducto").val();
            moneda              = $("#moneda").val();
        } else {
            
            $("#searchFechaDesde").val("");
            $("#searchFechaHasta").val("");
            $("#searchCodigo").val("");
            $("#searchProducto").val("");
            $("#searchProductoAU").val("");
            $("#cliente").val("");
            $("#search_documento").val("");
            $("#nombre_cliente").val("");
            $("#moneda").val("1");
        }

        $('#tabla-general').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: false,
            searching: true,
            ajax: {
                url: '<?= base_url(); ?>index.php/reportes/ventas/productos_vendidos_general/',
                type: "POST",
                datatype: 'json',
                data: {
                    fechaDesde: searchFechaDesde,
                    fechaHasta: searchFechaHasta,
                    cliente: cliente,
                    moneda: moneda,
                    producto: searchProducto,
                    tipo_oper:tipo_oper
                },
                beforeSend: function() {},
                error: function() {},
                complete: function(data) {
                    datax = data['responseText'];
                    totales = jQuery.parseJSON(datax);

                    document.getElementById("cantidad_total").innerHTML = totales.cantidad_total;
                    document.getElementById("total_global").innerHTML = totales.total_global;
                    
                }
            },
            language: spanish,
            columnDefs: [{
                "className": "dt-left",
                "targets": 0
            }],
            order: [
                [1, "asc"]
            ]
        });
    }

    function search_detallado(search = true) {
        let searchSerie         = "";
        let searchNumero        = "";
        let searchFechaDesde    = "";
        let searchFechaHasta    = "";
        let searchResponsable   = "";
        let searchAlmacen       = "";
        let searchProducto      = "";
        let cliente             = "";
        let moneda              = "";
        $(".mes").css("display","none");
        $(".anio").css("display","none");
        $(".rango_fechas").css("display","block");
        if (search == true) {
            cliente             = $("#cliente").val();
            searchFechaDesde    = $("#searchFechaDesde").val();
            searchFechaHasta    = $("#searchFechaHasta").val();
            searchResponsable   = $("#searchResponsable").val();
            searchProducto      = $("#searchProducto").val();
            moneda              = $("#moneda").val();
        } else {
            
            $("#searchFechaDesde").val("");
            $("#searchFechaHasta").val("");
            $("#searchCodigo").val("");
            $("#searchProducto").val("");
            $("#searchProductoAU").val("");
            $("#cliente").val("");
            $("#search_documento").val("");
            $("#nombre_cliente").val("");
            $("#moneda").val("1");
        }

        $('#tabla-detallado').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: false,
            searching : true,
            ajax: {
                url: '<?= base_url(); ?>index.php/reportes/ventas/productos_vendidos_detalle/',
                type: "POST",
                data: {
                    fechaDesde: searchFechaDesde,
                    fechaHasta: searchFechaHasta,
                    cliente: cliente,
                    moneda: moneda,
                    producto: searchProducto,
                    tipo_oper:tipo_oper
                },
                beforeSend: function() {},
                error: function() {},
                complete: function(data) {
                    datax = data['responseText'];
                    totales = jQuery.parseJSON(datax);

                    document.getElementById("cantidad_totalD").innerHTML = totales.cantidad_total;
                    document.getElementById("total_globalD").innerHTML = totales.total_global;
                }
            },
            language: spanish,
            columnDefs: [{
                "className": "dt-center",
                "targets": 0
            }],
            order: [
                [1, "asc"]
            ]
        });
    }
    
    
    function search_mensual(search = true) {
        let searchSerie         = "";
        let searchNumero        = "";
        let searchMesDesde    = "";
        let searchMesHasta    = "";
        let searchResponsable   = "";
        let searchAlmacen       = "";
        let searchProducto      = "";
        let cliente             = "";
        let moneda              = "";

        $(".mes").css("display","block");
        $(".anio").css("display","none");
        $(".rango_fechas").css("display","none");
        

        if (search == true) {
            cliente             = $("#cliente").val();
            searchProducto      = $("#searchProducto").val();
            moneda              = $("#moneda").val();
            searchMesDesde      = $("#searchMesDesde").val();
            searchMesHasta      = $("#searchMesHasta").val();
        } else {
            $("#searchMesDesde").val("");
            $("#searchMesHasta").val("");
            $("#searchCodigo").val("");
            $("#searchProducto").val("");
            $("#searchProductoAU").val("");
            $("#cliente").val("");
            $("#search_documento").val("");
            $("#nombre_cliente").val("");
            $("#moneda").val("1");
        }

        $("#tabla-mensual").DataTable().destroy();
        
        $(".viewData").html('');
        $(".viewthead").html('');
        //viewthead
        viewthead = '';
        viewthead += '<td style="width:05%" >CODIGO</td>';
        viewthead += '<td style="width:15%" >DESCRIPCION</td>';
        viewthead += '<td style="width:05%" >No DOCs</td>';
        viewthead += '<td style="width:05%" >CANTIDAD</td>';
        $(".viewthead").append(viewthead);
        $.ajax({
          url : '<?= base_url(); ?>index.php/reportes/ventas/productos_vendidos_mensual/',
          type: "POST",
          data: {
            fechaDesde: searchMesDesde,
            fechaHasta: searchMesHasta,
            cliente: cliente,
            moneda: moneda,
            producto: searchProducto,
            tipo_oper:tipo_oper
          },
          dataType: "json",
          success: function (data) {
            if (data.data != null && data.data != undefined){ 

              document.getElementById("cantidad_totalM").innerHTML = data.cantidad_total;
              document.getElementById("total_globalM").innerHTML = data.total_global;
              
              viewtheadD = '';
              $.each(data.listaMeses, function(i, item) {
                  viewtheadD = '';  
                  viewtheadD += '<td>' + item +'</td>';
                 
                  $(".viewthead").append(viewtheadD);
              });

              $.each(data.data, function(i, item) {
                  table = '';
                  table += '<tr>';
                  
                  table += '<td>' + item["codigousua"]          +'</td>';
                  table += '<td>' + item["descripcion"]          +'</td>';
                  
                  table += '<td>' + item["docs"]          +'</td>';
                  table += '<td>' + item["cantidad"]        +'</td>';
                  $.each(item["meses"], function(i, item) {
                      table += '<td style="text-align:center;">' + item +'</td>';
                  });
                  table += '</tr>';

                  $(".viewData").append(table);
              });

              
            }

            $('#tabla-mensual').DataTable({
            filter: false,
            destroy: true,
            autoWidth: true,
            language: spanish,
            paging:true,
            responsive: true
            
        });
          }
        });
    }

    function search_anual(search = true) {
        let searchSerie         = "";
        let searchNumero        = "";
        let searchAnioI    = "";
        let searchAnioF    = "";
        let searchResponsable   = "";
        let searchAlmacen       = "";
        let searchProducto      = "";
        let cliente             = "";
        let moneda              = "";

        $(".mes").css("display","none");
        $(".anio").css("display","block");
        $(".rango_fechas").css("display","none");
        

        if (search == true) {
            cliente             = $("#cliente").val();
            searchProducto      = $("#searchProducto").val();
            moneda              = $("#moneda").val();
            searchAnioI         = parseInt($("#searchAnioI").val());
            searchAnioF         = parseInt($("#searchAnioF").val());
        } else {
            $("#searchAnioI").val("");
            $("#searchAnioF").val("");
            $("#searchCodigo").val("");
            $("#searchProducto").val("");
            $("#searchProductoAU").val("");
            $("#cliente").val("");
            $("#search_documento").val("");
            $("#nombre_cliente").val("");
            $("#moneda").val("1");
        }

        diff = searchAnioF - searchAnioI;
        if (diff<0) {
            Swal.fire({
                icon: "error",
                title: "El año final debe ser mayor que el año de inicio",
                html: "<b class='color-red'></b>",
                showConfirmButton: true,
                timer: 1500
            });
        }

        $("#tabla-anual").DataTable().destroy();
        
        $(".viewDataA").html('');
        $(".viewtheadA").html('');
        //viewthead
        viewthead = '';
        viewthead += '<td style="width:05%" >CODIGO</td>';
        viewthead += '<td style="width:15%" >DESCRIPCION</td>';
        viewthead += '<td style="width:05%" >No DOCs</td>';
        viewthead += '<td style="width:05%" >CANTIDAD</td>';
        $(".viewtheadA").append(viewthead);
        $.ajax({
          url : '<?= base_url(); ?>index.php/reportes/ventas/productos_vendidos_anual/',
          type: "POST",
          data: {
            fechaDesde: searchAnioI,
            fechaHasta: searchAnioF,
            cliente: cliente,
            moneda: moneda,
            producto: searchProducto,
            tipo_oper:tipo_oper
          },
          dataType: "json",
          success: function (data) {
            if (data.data != null && data.data != undefined){ 

              document.getElementById("cantidad_totalA").innerHTML = data.cantidad_total;
              document.getElementById("total_globalA").innerHTML = data.total_global;
              
              viewtheadD = '';
              $.each(data.listaAnios, function(i, item) {
                  viewtheadD = '';  
                  viewtheadD += '<td>' + item +'</td>';
                 
                  $(".viewtheadA").append(viewtheadD);
              });

              $.each(data.data, function(i, item) {
                  table = '';
                  table += '<tr>';
                  
                  table += '<td>' + item["codigousua"]          +'</td>';
                  table += '<td>' + item["descripcion"]          +'</td>';
                  
                  table += '<td>' + item["docs"]          +'</td>';
                  table += '<td>' + item["cantidad"]        +'</td>';
                  $.each(item["anios"], function(i, item) {
                      table += '<td style="text-align:center;">' + item +'</td>';
                  });
                  table += '</tr>';

                  $(".viewDataA").append(table);
              });

              
            }

            $('#tabla-anual').DataTable({
            filter: false,
            destroy: true,
            autoWidth: true,
            language: spanish,
            paging:true,
            responsive: true
            
        });
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


    $("#verReporteGeneral").click(function()
    {
        
        var cliente         = $("#cliente").val() > 0 ? $("#cliente").val() : 0;
        var searchCodigo    = $("#searchProducto").val() > 0 ? $("#searchProducto").val() : 0;
        var fecha_inicio    = $("#searchFechaDesde").val()!= "" ? $("#searchFechaDesde").val() : 0;
        var fecha_fin       = $("#searchFechaHasta").val()!= "" ? $("#searchFechaHasta").val() : 0;
        var moneda          = $("#moneda").val();
        var tipo_oper       = $("#tipo_oper").val();
        

        if(fecha_inicio==""){
            Swal.fire({
                icon: "warning",
                title: "Debe seleccionar un rango de fecha válido",
                html: "<b>La descarga fue cancelada.</b>",
                timer: 2000
            });
            return false;
        }
        window.location="<?php echo base_url(); ?>index.php/reportes/ventas/reporteProductoGeneral/"+tipo_oper+"/"+moneda+"/"+cliente+"/"+fecha_inicio+"/"+fecha_fin+"/"+searchCodigo;
    });

    $("#verReporteDetallado").click(function()
    {
        var cliente         = $("#cliente").val() > 0 ? $("#cliente").val() : 0;
        var searchCodigo    = $("#searchProducto").val() > 0 ? $("#searchProducto").val() : 0;
        var fecha_inicio    = $("#searchFechaDesde").val()!= "" ? $("#searchFechaDesde").val() : 0;
        var fecha_fin       = $("#searchFechaHasta").val()!= "" ? $("#searchFechaHasta").val() : 0;
        var moneda          = $("#moneda").val();
        var tipo_oper       = $("#tipo_oper").val();
        

        if(fecha_inicio==""){
            Swal.fire({
                icon: "warning",
                title: "Debe seleccionar un rango de fecha válido",
                html: "<b>La descarga fue cancelada.</b>",
                timer: 2000
            });
            return false;
        }
        window.location="<?php echo base_url(); ?>index.php/reportes/ventas/reporteProductoDetallado/"+tipo_oper+"/"+moneda+"/"+cliente+"/"+fecha_inicio+"/"+fecha_fin+"/"+searchCodigo;
    });

    $("#verReporteMensual").click(function()
    {
        var cliente         = $("#cliente").val() > 0 ? $("#cliente").val() : 0;
        var searchCodigo    = $("#searchProducto").val() > 0  ? $("#searchProducto").val() : 0;
        var fecha_inicio    = $("#searchMesDesde").val()!= "" ? $("#searchMesDesde").val() : 0;
        var fecha_fin       = $("#searchMesHasta").val()!= "" ? $("#searchMesHasta").val() : 0;
        var moneda          = $("#moneda").val();
        var tipo_oper       = $("#tipo_oper").val();

        if(fecha_inicio==""){
            Swal.fire({
                icon: "warning",
                title: "Debe seleccionar un rango de fecha válido",
                html: "<b>La descarga fue cancelada.</b>",
                timer: 2000
            });
            return false;
        }
        window.location="<?php echo base_url(); ?>index.php/reportes/ventas/reporteProductoMensual/"+tipo_oper+"/"+moneda+"/"+cliente+"/"+fecha_inicio+"/"+fecha_fin+"/"+searchCodigo;
    });

    $("#verReporteAnual").click(function()
    {
        var cliente         = $("#cliente").val()>0?$("#cliente").val():0;
        var searchCodigo    = $("#searchProducto").val() > 0 ? $("#searchProducto").val() : 0;
        var fecha_inicio    = $("#searchAnioI").val();
        var fecha_fin       = $("#searchAnioF").val();
        var moneda          = $("#moneda").val();
        var tipo_oper       = $("#tipo_oper").val();

        if(fecha_inicio==""){
            Swal.fire({
                icon: "warning",
                title: "Debe seleccionar un rango de fecha válido",
                html: "<b>La descarga fue cancelada.</b>",
                timer: 2000
            });
            return false;
        }
       
        window.location="<?php echo base_url(); ?>index.php/reportes/ventas/reporteProductoAnual/"+tipo_oper+"/"+moneda+"/"+cliente+"/"+fecha_inicio+"/"+fecha_fin+"/"+searchCodigo;
    });

</script>