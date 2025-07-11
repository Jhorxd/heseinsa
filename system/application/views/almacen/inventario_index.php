<link href="<?= base_url(); ?>js/fancybox/dist/jquery.fancybox.css?=<?= CSS; ?>" rel="stylesheet">
<script src="<?= base_url(); ?>js/fancybox/dist/jquery.fancybox.js?=<?= JS; ?>"></script>

<div class="container-fluid">
    <div class="row header">
        <div class="col-md-12 col-lg-12">
            <div>BUSCAR INVENTARIOS</div>
        </div>
    </div>
    <form id="form_busqueda" method="post">
        <div class="row fuente8 py-1">
            <div class="col-sm-11 col-md-1">
                <label for="searchSerie">Serie</label>
                <input type="text" name="searchSerie" id="searchSerie" value="" class="form-control h-1" />
            </div>
            <div class="col-sm-11 col-md-1">
                <label for="searchNumero">Número</label>
                <input type="number" name="searchNumero" id="searchNumero" value="" class="form-control h-1" />
            </div>
            <div class="col-sm-11 col-md-2">
                <label for="searchFechaDesde">Desde</label>
                <input type="date" name="searchFechaDesde" id="searchFechaDesde" value="" class="form-control h-1" />
            </div>
            <div class="col-sm-11 col-md-2">
                <label for="searchFechaHasta">Hasta</label>
                <input type="date" name="searchFechaHasta" id="searchFechaHasta" value="" class="form-control h-1" />
            </div>
        </div>
        <div class="row fuente8 py-1">
            <div class="col-sm-11 col-md-3">
                <label for="searchResponsable">Responsable</label>
                <select id="searchResponsable" name="searchResponsable" class="form-control h-2">
                    <option value=""> :: TODOS :: </option>
                    <?php
                    if (count($personal) > 0) {
                        foreach ($personal as $i => $val) { ?>
                            <option value="<?= $val->PERSP_Codigo; ?>"><?= "$val->PERSC_NumeroDocIdentidad - $val->PERSC_Nombre $val->PERSC_ApellidoPaterno"; ?></option>
                    <?php
                        }
                    } ?>
                </select>
            </div>
            <div class="col-sm-11 col-md-3">
                <label for="searchAlmacen">Almacen</label>
                <select id="searchAlmacen" name="searchAlmacen" class="form-control h-2">
                    <option value=""> :: TODOS :: </option>
                    <?php
                    if (count($almacenes) > 0) {
                        foreach ($almacenes as $i => $val) { ?>
                            <option value="<?= $val->ALMAP_Codigo; ?>"><?= "$val->ALMAC_CodigoUsuario - $val->ALMAC_Descripcion"; ?></option>
                    <?php
                        }
                    } ?>
                </select>
            </div>
            <div class="col-sm-11 col-md-1">
                <label for="searchProductoAU">Producto</label>
                <input type="text" id="searchCodigo" readonly value="" class="form-control h-1" />
            </div>
            <div class="col-sm-11 col-md-3">
                <label for="searchProductoAU">&nbsp;</label>
                <input type="hidden" name="searchProducto" id="searchProducto" value="" class="form-control h-1" />
                <input type="text" id="searchProductoAU" value="" class="form-control h-1" />
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="acciones">
                        <div id="botonBusqueda">
                        <?php 
                        // ############################# BEGINT aldo  ###########################
                            //$rol = $this->session->userdata('rol');/
                            $this->load->library('session');
                            $rol = $this->session->userdata('rol');
                            $rolEntero = intval($rol);
                            ?>
                            <!-- <input type="text" id="rol" value="<?php //echo $rol ?>"> -->
                            <?php                             
                            if ($rol == 7000) {?>
                                <ul class="lista_botones" onclick="modalCargarInventario('','')">
								    <li id="excel">Cargar</li>
							    </ul>
                                <?php 
                            }  
                            // ############################# END  ###########################
                            ?> 
                            <ul class="lista_botones">
                                <li id="nuevo" data-toggle='modal' data-target='#modalAjuste'>Nuevo Inventario</li>
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
                    <div class="header text-align-center">RESULTADOS</div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <table class="fuente8 display" id="dtInventario">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?= base_url() . 'images/loading.gif?=' . IMG; ?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:10%" data-orderable="true">FECHA</td>
                                <td style="width:15%" data-orderable="true">INVENTARIO</td>
                                <td style="width:30%" data-orderable="true">TITULO</td>
                                <td style="width:20%" data-orderable="true">ALMACEN</td>
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

<div id="modalAjuste" class="modal fade" role="dialog">
    <div class="modal-dialog w-porc-90">
        <div class="modal-content">
            <form id="formAjuste" method="POST">
                <input type="hidden" id="ajuste" name="ajuste" value="">
                <input type="hidden" id="comp_inicial" name="comp_inicial" value="<?=$comp_inicial;?>">
                <div class="modal-header" style="background: rgba(0,0,0,.8); color: white;">
                    <h4 class="modal-title">INGRESO DE INVENTARIO</h4>
                </div>
                <div class="modal-body panel panel-default">
                    <div class="row form-group">
                        <div class="col-md-1">
                            <label for="serieFormAjuste">SERIE</label>
                            <input type="text" id="serieFormAjuste" name="serieFormAjuste" class="form-control h-1 w-porc-90" value="<?=$serie;?>" readOnly>
                        </div>
                        <div class="col-md-1">
                            <label for="numeroFormAjuste">NÚMERO</label>
                            <div>
                                <input type="number" id="numeroFormAjuste" name="numeroFormAjuste" class="form-control h-1 w-porc-50" value="" style="display: inline-block;" readOnly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="titulo_inventario">Titulo</label>
                           <input type="text" id="titulo_inventario" name="titulo_inventario" class="form-control h-1 w-porc-50" value="" style="display: inline-block;">
                        </div>
                        <div class="col-md-3">
                            <label for="almacenFormAjuste">ALMACEN</label>
                            <select id="almacenFormAjuste" name="almacenFormAjuste" class="form-control h-2">
                                <?php
                                if (count($almacenes) > 0) {
                                    foreach ($almacenes as $i => $val) { ?>
                                        <option value="<?= $val->ALMAP_Codigo; ?>"><?= "$val->ALMAC_CodigoUsuario - $val->ALMAC_Descripcion"; ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </div>
                        
                        <div class="col-md-1">
                            <label for="fecha">Fecha</label>
                           <input type="date" id="fecha" name="fecha" class="form-control h-1 w-porc-50" value="<?php echo $fecha; ?>" style="display: inline-block;">
                        </div>
                        <div class="" hidden>
                            <label for="responsableFormAjuste">RESPONSABLE</label>
                            <select id="responsableFormAjuste" name="responsableFormAjuste" class="form-control h-2">
                                <option value="<?= $persona_id; ?>"><?= $persona_nombre; ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-md-11">
                            <label for="observacionFormAjuste">OBSERVACIÓN</label>
                            <textarea id="observacionFormAjuste" name="observacionFormAjuste" value="" class="form-control h-4" placeholder="Observaciones del responsable para este ajuste."></textarea>
                        </div>
                    </div>
                </div>

                <div class="row" style="background: rgba(0,0,0,.8); color: white;">
                    <div class="col-md-12">
                        <h4>AGREGAR PRODUCTOS</h4>
                    </div>
                </div>

                <div class="modal-body panel panel-default">
                    <div class="row form-group">
                            <input type="hidden" id="bar_code" name="bar_code" class="form-control h-1 w-porc-90" value="">
                        <div class="col-md-2">
                            <label for="getProductoCodigo">CÓDIGO</label>
                            <input type="hidden" id="productoCodigo" value="">
                            <input type="text" id="getProductoCodigo" class="form-control h-1 w-porc-90" value="">
                        </div>
                        <div class="col-md-4">
                            <label for="getProductoDescripcion">DESCRIPCIÓN</label>
                            <input type="text" id="getProductoDescripcion" class="form-control h-1 w-porc-90" value="">
                        </div>
                        <div class="col-md-1">
                            <label for="stockProducto">STOCK ACTUAL</label>
                            <input type="number" id="stockProducto" class="form-control h-1 w-porc-90" value="" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="cantidadProducto">CANT. NUEVA</label>
                            <input type="number" min="0" id="cantidadProducto" class="form-control h-1 w-porc-90" value="">
                        </div>
                        <div class="col-md-1">
                            <label for="" style="opacity: 0">&nbsp;</label>
                            <button type="button" class="btn btn-success" style="width: 100%;" onclick="addProducto()">Agregar</button>
                        </div>
                        <div class="col-md-1 pall-0">
                            <label for="" style="opacity: 0">&nbsp;</label>
                            <button type="button" class="btn btn-info" style="width: 100%;" onclick="cleanAddProducto()">Limpiar</button>
                        </div>
                    </div>
                </div>

                <div class="modal-body panel panel-default">
                    <div class="row" style="overflow-y: scroll;">
                        <div class="col-md-12 pall-0">
                            <table class="stable" width="100%">
                                <tr>
                                    <th style="width: 10%">FECHA</th>
                                    <th style="width: 20%">CÓDIGO</th>
                                    <th style="width: 40%">DESCRIPCIÓN</th>
                                    <th style="width: 10%">CANTIDAD INVENTARIO/STOCK</th>
                                    <th style="width: 10%">CANTIDAD A INGRESAR</th>
                                    <th style="width: 10%">BORRAR</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row" style="height: 300px; overflow-y: scroll;">
                        <div class="col-md-12 pall-0">
                            <table class="stable" id="dtProductos">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" accesskey="x" id="boton-registrar" onclick="registrar_inventario()">Guardar</button>
                    <button type="button" class="btn btn-info" onclick="clean(true)">Limpiar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalDetails" class="modal fade" role="dialog">
    <div class="modal-dialog w-porc-90">
        <div class="modal-content">
            <input type="hidden" id="ajuste" name="ajuste" value="">
            <div class="modal-header" style="background: rgba(0,0,0,.8); color: white;">
                <h4 class="modal-title">DETALLES DEL INVENTARIO</h4>
            </div>
            <div class="modal-body panel panel-default">
                <div class="row form-group">
                    <div class="col-md-1">
                        <span><b>SERIE:</b> <span id="serieDetails"></span></span>
                    </div>
                    <div class="col-md-2">
                        <span><b>NÚMERO:</b> <span id="numeroDetails"></span></span>
                    </div>
                    <div class="col-md-4">
                        <span><b>ALMACEN:</b> <span id="almacenDetails"></span></span>
                    </div>
                    <div class="col-md-3">
                        <span><b>TIPO MOVIMIENTO:</b> <span id="movimientoDetails"></span></span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-11">
                        <span><b>RESPONSABLES:</b> <span id="responsablesDetails"></span></span>
                    </div>
                </div>
            </div>

            <div class="row" style="background: rgba(0,0,0,.8); color: white;">
                <div class="col-md-12">
                    <h4>PRODUCTOS</h4>
                </div>
            </div>

            <div class="modal-body panel panel-default">
                <div class="row">
                    <div class="col-md-12 pall-0">
                        <table class="stable" id="tableDetails">
                            <thead>
                                <th style="width: 20%">CÓDIGO</th>
                                <th style="width: 60%">DESCRIPCIÓN</th>
                                <th style="width: 20%">CANTIDAD INGRESADO</th>
                                
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

<!-- Modal Cargar Stock -->
<div id="modalCargarStock" class="modal fade" role="dialog">
    <div class="modal-dialog w-porc-50">
        <div class="modal-content">
            <form id="formCargaStock" method="POST" action="#" enctype="multipart/form-data">
                <input type="hidden" name="ajusteCS" id="ajusteCS" value="">
                <div class="modal-header">
                    <h3 class="modal-title">Cargar stock de productos</h3>
                </div>
                <div class="modal-body panel panel-default">
                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11">
                            <label for="almacenCS">Almacen *</label>
                            <select id="almacenCS" name="almacenCS" class="form-control h-2">
                                <?php
                                foreach ($almacenes as $i => $val) { ?>
                                    <option value="<?= $val->ALMAP_Codigo; ?>"><?= $val->ALMAC_Descripcion; ?></option>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="excelCS">Documento excel *</label>
                            <input type="file" name="excelCS" id="excelCS" class="oculto" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        </div>
                        <div class="col-md-4"><br>
                            <a href="<?= $base_url; ?>index.php/almacen/inventario/formatLoadExcel" class="btn btn-primary">Descargar Formato</a>
                            <a href="javascript:;" class="btn btn-info" onclick="downloadCargados()">Ver cargados</a>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="cargarInventario()">Cargar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal cargar stock -->

<style type="text/css">
    .sincronizar {
        cursor: pointer;
        display: inline-block;
        margin: 0px;
        height: 30px;
        width: 30px;
        transition: all 3s;
        transition-timing: ease-in-out;
    }
</style>

<script type="text/javascript">
    base_url = "<?= $base_url; ?>";

    $(document).ready(function() {
        $('#dtInventario').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '<?= base_url(); ?>index.php/almacen/inventario/dtInventarios/',
                type: "POST",
                data: {
                    dataString: ""
                },
                beforeSend: function() {},
                error: function() {},
                complete: function() {}
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

        $("#buscarC").click(function() {
            search();
        });

        $("#nuevo").click(function() {
            clean(false);
        });

        $("#limpiarC").click(function() {
            search(false);
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

        $('#cantidadProducto').keyup(function(e) {
            if (e.which == 13) {
                if ($(this).val() != '')
                    addProducto();
            }
        });

        /*$("#getProductoCodigo").autocomplete({
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
        });*/

        var code_bar = $('#getProductoCodigo');

        code_bar.keyup(function (e) {
            var key = e.keyCode || e.which;
            if (key == 13) {
                if ($(this).val() != '') {
                    busqueda_producto_enter();
                }
            }
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

        $("#getNumber").click(function() {
            let angulo = 0;

            var stop = setInterval(function() {
                angulo += 60;
                $("#getNumber").css({
                    "transform": "rotate(" + angulo + "deg)"
                });
            }, 10);

            $.ajax({
                type: 'POST',
                url: "<?= base_url(); ?>index.php/almacen/inventario/correlativoAjuste",
                dataType: 'json',
                beforeSend: function() {},
                success: function(data) {
                    $("#numeroFormAjuste").val(data.cantidad);
                },
                complete: function() {
                    clearInterval(stop)
                    $("#getNumber").css({
                        "transform": "rotate(0deg)"
                    });
                }
            });
        });
    });

    function search(search = true) {
        let searchSerie = "";
        let searchNumero = "";
        let searchFechaDesde = "";
        let searchFechaHasta = "";
        let searchResponsable = "";
        let searchAlmacen = "";
        let searchProducto = "";

        if (search == true) {
            searchSerie = $("#searchSerie").val();
            searchNumero = $("#searchNumero").val();
            searchFechaDesde = $("#searchFechaDesde").val();
            searchFechaHasta = $("#searchFechaHasta").val();
            searchResponsable = $("#searchResponsable").val();
            searchAlmacen = $("#searchAlmacen").val();
            searchProducto = $("#searchProducto").val();
        } else {
            $("#form_busqueda")[0].reset();
        }

        $('#dtInventario').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url(); ?>index.php/almacen/inventario/dtInventarios/',
                type: "POST",
                data: {
                    serie: searchSerie,
                    numero: searchNumero,
                    fechaDesde: searchFechaDesde,
                    fechaHasta: searchFechaHasta,
                    responsable: searchResponsable,
                    almacen: searchAlmacen,
                    producto: searchProducto
                },
                beforeSend: function() {},
                error: function() {},
                complete: function() {}
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

    function editar(id) {
        var url = "<?= base_url() ?>index.php/almacen/inventario/getInventario";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                ajuste: id
            },
            beforeSend: function() {
                $("#dtProductos tbody").html("");
                $("#ajuste").val("");
                $("#productoCodigo").val("");
                $("#formAjuste")[0].reset();
            },
            success: function(data) {
                console.log(data);
                if (data.match == true) {
                    let tr      = '';
                    let info    = data.info;
                    let mensaje = info.responsables[0].observacion
                    mensaje = mensaje.replace(/<br>/g, '');

                    $("#ajuste").val(info.ajuste);
                    $("#serieFormAjuste").val(info.serie);
                    $("#movimientoFormAjuste").val(info.movimiento);
                    $("#numeroFormAjuste").val(info.numero);
                    $("#almacenFormAjuste").val(info.almacen);
                    $("#titulo_inventario").val(info.titulo_inventario);
                    $("#observacionFormAjuste").val(mensaje);

                    $.each(info.productos, function(i, col) {

                        tr = '<tr class="items_agregados" id="item_id_' + col.producto + '">' +
                            '   <td style="width: 10%">' + col.fecha_ingreso + '</td>' +
                            '   <td style="width: 20%">' + col.codigo + '</td>' +
                            '   <td style="width: 40%">' + col.descripcion + '</td>' +
                            '   <td style="width: 10%">' + ((col.cantidad == null)? 'ninguna':col.cantidad) + '</td>' +
                            '   <td style="width: 10%">' +
                            '       <input type="hidden" name="ajuste_ids[]" value="' + col.registro + '"> ' +
                            '       <input type="hidden" id="ajuste_producto' + col.producto + '" name="ajuste_producto[]" value="' + col.producto + '" class="ajuste_producto'+col.producto+'"> ' +
                            '       + <input type="number" min="0" name="ajuste_cantidad[]" onchange="cambiarResponsable(' + col.producto + ')" class="form-control h-1 w-porc-80 ajuste_cantidad_' + col.producto + '" value="'+col.stock+'" id="ajuste_cantidad' + col.producto + '"> ' +
                            //'       <input type="number" min="0" name="ajuste_cantidad[]" onchange="cambiarResponsable(' + col.producto + ')" class="form-control h-1 w-porc-80 ajuste_cantidad_' + col.producto + '" value="' + col.cantidad + '" id="ajuste_cantidad' + col.producto + '"> ' +
                            '       <input type="hidden" name="ajuste_flags[]" class="ajuste_flag_' + col.producto + '" value="1"> ' +
                            '       <input type="hidden" name="responsable_prd[]" class="responsable_prd_' + col.producto + '" value="' + col.responsable + '"> ' +
                            '   </td>' +
                            '   <td style="width: 10%;"> ' +
                            '       <button type="button" onclick="eliminar_item(' + col.producto + ')" class="btn btn-default">' +
                            '           <img src="<?= base_url(); ?>images/error.png" class="image-size-1b">' +
                            '       </button>' +
                            '   </td>' +
                            '</tr>';
                        $("#dtProductos tbody").prepend(tr);
                    });

                    $("#modalAjuste").modal("toggle");
                } else {
                    Swal.fire({
                        icon: "info",
                        title: "Información no disponible.",
                        html: "<b class='color-red'></b>",
                        showConfirmButton: true,
                        timer: 4000
                    });
                }
            },
            complete: function() {}
        });
    }

    function details(id) {
        var url = "<?= base_url() ?>index.php/almacen/inventario/getInventario";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                ajuste: id
            },
            beforeSend: function() {
                $('#tableDetails').DataTable().destroy();
                $("#tableDetails tbody").html("");
            },
            success: function(data) {
                if (data.match == true) {
                    let table = '';
                    let tr = '';
                    let info = data.info;
                    let background = '';

                    $("#serieDetails").html(info.serie);
                    $("#numeroDetails").html(info.numero);
                    $("#almacenDetails").html(info.almacen_nombre);
                    $("#movimientoDetails").html(info.movimiento_descripcion);

                    $.each(info.productos, function(i, col) {
                        tr = '<tr>' +
                            '   <td>' + col.codigo + '</td>' +
                            '   <td>' + col.descripcion + '</td>' +
                            
                            '   <td>' + col.cantidad + '    </td>' +
                         
                            '</tr>';
                        $("#tableDetails tbody").prepend(tr);
                    });

                    tr = '';
                    $.each(info.responsables, function(i, col) {
                        background = (i % 2 == 0) ? '#FFFFFF' : '#EEEEEE';
                        tr += ' <tr style="background: ' + background + '">' +
                            '       <td>' + col.nombre + ' </td>' +
                            '       <td>' + col.observacion + ' </td>' +
                            '   </tr>';
                    });

                    table = '<table class="fuente8 display">' +
                        '   <tr class="cabeceraTabla">' +
                        '       <td>PERSONAL</td>' +
                        '       <td>OBSERVACIÓN</td>' +
                        '   </tr>' +
                        tr +
                        '<table>';
                    $("#responsablesDetails").html(table);

                    $('#tableDetails').DataTable({
                        filter: true,
                        destroy: true,
                        autoWidth: false,
                        language: spanish,
                    });

                    $("#modalDetails").modal("toggle");
                } else {
                    Swal.fire({
                        icon: "info",
                        title: "Información no disponible.",
                        html: "<b class='color-red'></b>",
                        showConfirmButton: true,
                        timer: 4000
                    });
                }
            },
            complete: function() {}
        });
    }

    function registrar_inventario() {
        Swal.fire({
            icon: "question",
            title: "¿Esta seguro de guardar el registro?",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then(result => {
            if (result.value) {
                let ajuste = $("#ajuste").val();
                let validacion = true;

                if ($(".items_agregados").length == 0) {
                    Swal.fire({
                        icon: "info",
                        title: "Debe agregar al menos 1 item.",
                        showConfirmButton: true
                    });
                    validacion = false;
                    return null;
                }
                if ($("#titulo_inventario").val() == "") {
                    Swal.fire({
                        icon: "info",
                        title: "Debe agregar titulo al inventario.",
                        showConfirmButton: true
                    });
                    $("#titulo_inventario").focus()   
                    validacion = false;
                    return null;
                }


                if (validacion == true) {
                    var url = "<?= base_url(); ?>index.php/almacen/inventario/guardarInventario";
                    var info = $("#formAjuste").serialize();
                    $.ajax({
                        type: 'POST',
                        url: url,
                        dataType: 'json',
                        data: info,
                        error: function() {
                            alert("Hubo un error inesperado");
                        },
                        success: function(data) {
                            if (data.result == "success") {
                                if (ajuste == "")
                                    titulo = "¡Registro exitoso!";
                                else
                                    titulo = "¡Actualización exitosa!";

                                Swal.fire({
                                    icon: "success",
                                    title: titulo,
                                    showConfirmButton: true,
                                    timer: 2000
                                });
                                id = $("#ajuste").val();

                                $("#dtProductos tbody").html("");
                                $("#ajuste").val("");
                                $("#productoCodigo").val("");
                                $("#formAjuste")[0].reset();

                                search(false);
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Sin cambios.",
                                    html: "<b class='color-red'>La información no fue registrada/actualizada, intentelo nuevamente.</b>",
                                    showConfirmButton: true,
                                    timer: 4000
                                });
                            }
                        },
                        complete: function() {}
                    });
                }
            }
        });
    }

    function clean(search = true) {
        if (search == true) {
            Swal.fire({
                icon: "question",
                title: "¿Esta seguro de limpiar todos los campos?",
                html: "<b class='color-red'>Esta acción no se puede deshacer</b>",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar"
            }).then(result => {
                if (result.value) {
                    $("#dtProductos tbody").html("");
                    $("#ajuste").val("");
                    $("#productoCodigo").val("");
                    $("#formAjuste")[0].reset();
                }
            });
        }else{
            $("#dtProductos tbody").html("");
            $("#ajuste").val("");
            $("#productoCodigo").val("");
            $("#formAjuste")[0].reset();
        }
    }

    function addProducto() {

        let tr = '';
        let id          = $("#productoCodigo").val();
        let codigo      = $("#getProductoCodigo").val();
        let codigoBar   = $("#bar_code").val();
        let descripcion = $("#getProductoDescripcion").val();
        let stock       = $("#stockProducto").val();
        let cantidad    = $("#cantidadProducto").val();
        let responsable = $("#responsableFormAjuste").val();
        if (codigoBar=="") {
            codigoBar = codigo;
        }
        if (id == '' || codigoBar == '' || descripcion == '' || cantidad == '') {
            Swal.fire({
                icon: "warning",
                title: "Verifique los datos ingresados.",
                showConfirmButton: true
            });
        } else {
            if ($("#item_id_" + id).length > 0) {
                let flag = false;
                n = parseFloat(document.getElementById('dtProductos').rows.length);
                //addProducto();
                if (n > 0){
                    for (var i = 0; i < n; i++) {
                        cantida_sumar = parseFloat($("#cantidadProducto").val());
                        PROD_Codigo   = "ajuste_producto" + id;
                        if (!!document.getElementById(PROD_Codigo)==true) {
                            let productiviris = document.getElementById(PROD_Codigo).value;
                            if (isNaN(productiviris)) {
                                productiviris=0;
                            }
                            if (id == productiviris){
                                flag = true;
                                prod_cantidad   = "ajuste_cantidad" + id;
                                var productiviris_cant = document.getElementById(prod_cantidad).value;
                                productiviris_cant = parseFloat(productiviris_cant)+cantida_sumar;
                                $("#ajuste_cantidad" + id).val(productiviris_cant);
                                $("#getProductoCodigo").val("");
                                $("#getProductoCodigo").focus();
                                $("#bar_code").val("");
                                break;
                            }
                        }
                    }
                }
            } else {
                tr = '<tr class="items_agregados" id="item_id_' + id + '">' +
                    '   <td style="width: 10%">-</td>' +
                    '   <td style="width: 20%">' + codigoBar + '</td>' +
                    '   <td style="width: 40%">' + descripcion + '</td>' +
                    '   <td style="width: 10%">' + stock + '</td>' +
                    '   <td style="width: 10%">' +
                    '       <input type="hidden" name="ajuste_ids[]" value=""> ' +
                    '       <input type="hidden" name="ajuste_producto[]" id="ajuste_producto'+id+'" value="' + id + '"class="ajuste_producto'+id+'"> ' +
                    '       <input type="number" min="0" name="ajuste_cantidad[]" id="ajuste_cantidad'+id+'" onchange="cambiarResponsable(' + id + ')" class="form-control h-1 w-porc-80 ajuste_cantidad_' + id + '" value="' + cantidad + '"> ' +
                    '       <input type="hidden" name="ajuste_flags[]" class="ajuste_flag_' + id + '" value="1"> ' +
                    '       <input type="hidden" name="responsable_prd[]" class="responsable_prd_' + id + '" value="' + responsable + '"> ' +
                    '   </td>' +
                    '   <td style="width: 10%;"> ' +
                    '       <button type="button" onclick="eliminar_item(' + id + ')" class="btn btn-default">' +
                    '           <img src="<?= base_url(); ?>images/error.png" class="image-size-1b">' +
                    '       </button>' +
                    '   </td>' +
                    '</tr>';
                $("#dtProductos tbody").prepend(tr);
                //cleanAddProducto();
                $("#getProductoCodigo").focus();
                $("#bar_code").val("");
            }
            cleanAddProducto();
        }
    }

    function cambiarResponsable(id) {
        let responsable = $("#responsableFormAjuste").val();
        $(".responsable_prd_" + id).val(responsable);
    }

    function eliminar_item(id) {
        $(".ajuste_flag_" + id).val("0");
        $("#item_id_" + id).hide("slow");
        cambiarResponsable(id);
    }

    function cleanAddProducto() {
        $("#productoCodigo").val("");
        $("#getProductoCodigo").val("");
        $("#getProductoDescripcion").val("");
        $("#stockProducto").val("");
        $("#cantidadProducto").val("");
        $("#getProductoCodigo").focus();
    }

    function aprobar(id) {
        let url = "<?= base_url() ?>index.php/almacen/inventario/aprobarReajuste";
        let loading = '<img src="<?= base_url(); ?>/images/loading.gif" class="image-size-1b">';
        let aprobar = '<button type="button" onclick="aprobar(' + id + ')" class="btn btn-primary">Aprobar</button>';
        let aprobado = '<img src="<?= base_url(); ?>/images/icono_aprobar.png" class="image-size-1b">';

        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                ajuste: id
            },
            beforeSend: function() {
                $("#btn-editar-" + id).hide("fast");
                $("#btn-load-" + id).hide("fast");
                $("#btn-estado-" + id).html(loading);
            },
            success: function(data) {
                Swal.fire({
                    icon: data.result,
                    title: data.message,
                    showConfirmButton: true,
                    timer: 4000
                });

                if (data.result == "success") {
                    $("#btn-estado-" + id).html(aprobado);
                    let cargados = '<a href="javascript:;" onclick="downloadCargados(' + id + ')">' +
                        '   <button type="button" class="btn btn-default"> ' +
                        '       <img src="' + base_url + '/images/excel.png" class="image-size-1b"> ' +
                        '   </button>' +
                        '</a>';
                    $("#div-btn-load-" + id).append(cargados);
                } else {
                    $("#btn-estado-" + id).html(aprobar);
                    $("#btn-editar-" + id).show("fast");
                    $("#btn-load-" + id).show("fast");
                }
            },
            complete: function() {}
        });
    }

    /** Cargar Stock **/

    function modalCargarInventario(ajuste, almacen) {
        $("#formCargaStock")[0].reset();
        $("#ajusteCS").val(ajuste);
        $("#almacenCS").val(almacen);
        $("#modalCargarStock").modal("toggle");
    }

    function downloadCargados(aj = '') {
        let ajuste = (aj == '') ? $("#ajusteCS").val() : aj;

        if (ajuste != "") {
            window.location.href = base_url + "index.php/almacen/inventario/DetalleInventarioExcel/" + ajuste;
        } else {
            Swal.fire({
                icon: "warning",
                title: "Sin ajuste seleccionado.",
                showConfirmButton: true,
                timer: 4000
            });
        }
    }

    function cargarInventario(ajuste = '') {
        Swal.fire({
            icon: "question",
            title: "¿Esta seguro de ejecutar la carga?",
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then(result => {
            if (result.value) {
                let almacenCS = $("#almacenCS").val();
                let excelCS = $("#excelCS").val();
                let validacion = true;

                if (almacenCS == "") {
                    Swal.fire({
                        icon: "warning",
                        title: "Verifique los datos.",
                        html: "<b class='color-red'>Debe seleccionar un almacen.</b>",
                        showConfirmButton: true,
                        timer: 4000
                    });
                    $("#almacenCS").focus();
                    validacion = false;
                    return false;
                }

                if (excelCS == "") {
                    Swal.fire({
                        icon: "warning",
                        title: "Verifique los datos.",
                        html: "<b class='color-red'>Debe seleccionar un archivo.</b>",
                        showConfirmButton: true,
                        timer: 4000
                    });
                    $("#excelCS").focus();
                    validacion = false;
                    return false;
                }

                if (validacion == true) {
                    let url = base_url + "index.php/almacen/inventario/loadStockInventory";
                    let info = new FormData($('#formCargaStock')[0]);
                    $.ajax({
                        type: 'POST',
                        url: url,
                        dataType: 'json',
                        data: info,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            Swal.fire({
                                icon: data.result,
                                title: data.titulo,
                                html: data.message,
                                showConfirmButton: true
                            });

                            if (data.result == "success") {
                                $("#formCargaStock")[0].reset();
                                $("#ajusteCS").val("");
                            } else {
                                $("#formCargaStock")[0].reset();
                                $("#ajusteCS").val(data.ajuste);
                                search(false);
                            }
                        },
                        complete: function() {}
                    });
                }
            }
        });
    }


    function busqueda_producto_enter() {
        let codigo      = $("#getProductoCodigo").val();
        let productoCodigo = $("#productoCodigo").val();
        let bar_code    = $("#bar_code").val();
        let almacen     = $("#almacenFormAjuste").val();
        let cantidad    = parseFloat($("#cantidadProducto").val());
        if (codigo  != "" && codigo != null) {
            if (bar_code!="" && bar_code==codigo) {
                if (cantidad=="") {
                    cantidad = 1;
                }
                cantidad = cantidad+1;
                $("#cantidadProducto").val(cantidad);
                $("#getProductoCodigo").val("");
                $("#getProductoCodigo").focus();
            }
            else if (bar_code!="" && bar_code!=codigo){
                addProducto();
                busca_barcode(codigo,almacen);
            }else{
                busca_barcode(codigo,almacen);
            }
                
        }else{
            Swal.fire({
                icon: "warning",
                title: "No hay codigo para buscar.",
                html: "<b class='color-red'>Intenta de nuevo!</b>",
                showConfirmButton: true,
                timer: 2000
            });
        }
    }

    function busca_barcode(codigo,almacen){
        let barcode = $("#bar_code").val();
        let getProductoCodigo = $("#getProductoCodigo").val();
        var url = base_url + "index.php/almacen/inventario/searchProductoBarcode/";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        codigo: codigo,
                        almacen: almacen
                    },
                    dataType: "json",
                   
                    success: function (data) {
                        
                        if (data[0].result=="success") {
                            $("#productoCodigo").val(data[0].id);
                            $("#getProductoDescripcion").val(data[0].nombre);
                            $("#stockProducto").val(data[0].stock);
                            $("#cantidadProducto").val("1");
                            $("#getProductoCodigo").val("");
                            $("#getProductoCodigo").focus();
                            $("#bar_code").val(codigo);
                        }else{
                            $("#productoCodigo").val("");
                            $("#getProductoDescripcion").val("");
                            $("#stockProducto").val("");
                            $("#cantidadProducto").val("1");
                            $("#getProductoCodigo").val("");
                            $("#getProductoCodigo").focus();
                            $("#bar_code").val("");
                        }
                        
                        
                        
                    },
                    error: function (XHR, error) {
                        
                        Swal.fire({
                            icon: "warning",
                            title: "Hubo un problema.",
                            html: "<b class='color-red'>Intenta de nuevo!</b>",
                            showConfirmButton: true,
                            timer: 2000
                        });
                       
                    }
                });
    }

    function sumar_agregado(argument) {
        
    }

</script>