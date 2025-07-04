<!--vista => producto_view.php-->

<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/producto.js?=<?=JS;?>"></script>

<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>

<style>
.costo {
    display: inline-block;
    position: relative;
    padding: 0.5em;
    cursor: pointer;
}

.costo:hover {
    background: rgba(51, 51, 51, .1);
}

.costo .editar_costo {
    text-align: left;
    position: absolute;
    visibility: hidden;
    padding: 0.7em 0.7em 0.7em 0.7em;
    width: 25em;
    top: -25%;
    right: 100%;
    background: rgba(51, 51, 51, .9);
}

.costo:hover .editar_costo {
    visibility: visible;
    width: 25em;
    background: rgba(51, 51, 51, .9);
    border-radius: 0.1em 0.1em 0.1em 0.1em;
}

.costo:hover input,
.costo:hover .editar_costo img {
    opacity: 1;
}

.editar_costo input,
.editar_costo img {
    opacity: 0;
    width: auto;
}

.busqueda_opcinal {
    position: relative;
    text-align: center;
}

.busqueda_opcinal_1 {
    position: absolute;
    background-color: #004488;
    color: #f1f4f8;
    width: 98px;
    height: 70px;
    top: 14px;
    left: 135px;
    -webkit-box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
    -moz-box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
    box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
    cursor: pointer;
}

.control_1 .seleccionado {
    position: absolute;
    border-radius: 3px;
    background-color: #29fb00;
    width: 98px;
    height: 5px;
    bottom: 20px;
    left: 135px;
}

.busqueda_opcinal_2 {
    position: absolute;
    background: #109EC8;
    color: #f1f4f8;
    width: 95px;
    height: 70px;
    top: 14px;
    right: 102px;
    cursor: pointer;
    -webkit-box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
    -moz-box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
    box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
}

.control_2 .seleccionado {
    position: absolute;
    border-radius: 3px;
    background-color: #ab1c27;
    width: 96px;
    height: 5px;
    bottom: 21px;
    right: 102px;
}
</style>

<div class="container-fluid">
    <div class="row header">
        <div class="col-md-12 col-lg-12">
            <div><?=$titulo_busqueda;?></div>
        </div>
    </div>
    <form id="form_busqueda" method="post">
        <div class="row fuente8 py-1">
            <div class="col-sm-1 col-md-1 col-lg-1 form-group">
                <label for="txtCodigo">Código: </label>
                <input id="txtCodigo" name="txtCodigo" type="text" class="form-control w-porc-90 h-1"
                    placeholder="Codigo" maxlength="30" value="<?=$codigo;?>">
            </div>
            <?php if($flagBS == 'S'): ?>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="txtNombre">Nombre: </label>
                <input id="txtNombre" name="txtNombre" type="text" class="form-control w-porc-90 h-1" maxlength="100"
                    placeholder="Nombre servicio" value="<?php echo $nombre; ?>">
            </div>
            <?php else: ?>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="txtNombre">Nombre: </label>
                <input id="txtNombre" name="txtNombre" type="text" class="form-control w-porc-90 h-1" maxlength="100"
                    placeholder="Nombre producto" value="<?php echo $nombre; ?>">
            </div>
            <?php endif; ?>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="txtFamilia">Familia: </label>
                <select name="txtFamilia" id="txtFamilia" class="form-control w-porc-90 h-2">
                    <option value=""> TODOS </option><?php
                    if ($familias != NULL){
                        foreach ($familias as $i => $v){ ?>
                    <option value="<?=$v->FAMI_Codigo;?>"><?=$v->FAMI_Descripcion;?></option> <?php
                        }
                    } ?>
                </select>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group" <?=($flagBS == 'S') ? 'hidden' : '';?>>
                <label for="txtMarca">Marca: </label>
                <input id="txtMarca" type="text" class="form-control w-porc-90 h-1" name="txtMarca" maxlength="100"
                    placeholder="Marca producto" value="<?=$marca;?>">
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group" <?=($flagBS == 'S') ? 'hidden' : '';?>>
                <label for="txtModelo">Modelo: </label>
                <select name="txtModelo" id="txtModelo" class="form-control w-porc-90 h-2">
                    <option value=""> TODOS </option><?php
                    if ($modelos != NULL){
                        foreach ($modelos as $indice => $val){
                            if ($val->PROD_Modelo != ''){ ?>
                    <option value="<?=$val->PROD_Modelo;?>"><?=$val->PROD_Modelo;?></option> <?php
                            }
                        }
                    } ?>
                </select>
            </div>
            <?php if($flagBS == 'S'): ?>

            <?php else: ?>
            <div class="col-sm-1 col-md-1 col-lg-1"><br>
                <button type="button" class="btn btn-info" data-toggle="modal"
                    data-target="#modal_totales">Inversión</button>
            </div>
            <?php endif; ?>
            <input id="codigoInterno" name="codigoInterno" type="hidden" class="cajaGrande" maxlength="100"
                placeholder="Codigo original" value="<?=$codigoInterno;?>">
        </div>
    </form>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="acciones">
                        <div id="botonBusqueda">
                            <?php if($flagBS == 'S'):  ?>
                            <ul id="imprimirServicio" class="lista_botones">
                                <li id="imprimir">Imprimir </li>
                            </ul>
                            <?php else: ?>
                            <ul id="imprimirProducto" class="lista_botones">
                                <li id="imprimir">Imprimir </li>
                            </ul>
                            <?php endif; ?>

                            <ul class="lista_botones" data-toggle="modal" data-target="#modal_producto">
                                <li id="nuevo">Nuevo <?php if ($flagBS == 'B') echo 'Artículo'; else echo 'Servicio'; ?>
                                </li>
                            </ul>
                            <ul id="limpiarP" class="lista_botones">
                                <li id="limpiar">Limpiar</li>
                            </ul>
                            <ul id="buscarP" class="lista_botones">
                                <li id="buscar">Buscar</li>
                            </ul>
                        </div>
                        <div id="lineaResultado">Registros encontrados</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="header text-align-center"><?=$titulo;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div id="cargando_datos" class="loading-table">
                        <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                    </div>
                    <table class="fuente8 display" id="table-productos">
                        <thead>
                            <tr class="cabeceraTabla">
                                <th style="width: 05%" data-orderable="true">CÓDIGO</th>
                                <th style="width: 20%" data-orderable="true">NOMBRE</th>
                                <th style="width: 10%" data-orderable="true">FAMILIA</th>
                                <th style="width: 10%" data-orderable="true"><?=($flagBS == "B") ? "MARCA" : "";?></th>
                                <th style="width: 10%" data-orderable="false">UNIDAD MEDIDA</th>
                                <th data-orderable="true"><?=($flagBS == "B") ? "P. COSTO" : "";?></th> <?php
                                
                                foreach ($categorias as $key => $val){ ?>
                                <th style="text-indent: 0;" data-orderable="false"><?=$val->TIPCLIC_Descripcion;?></th> <?php
                                }?>

                                <th style="width: 05%" data-orderable="false">EDITAR</th>
                                <!--<th style="width: 05%" data-orderable="false">BARCODE</th>-->
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal_totales" class="modal fade" role="dialog">
    <div class="modal-dialog w-porc-60">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div style="text-align: center;">
                <h3><b>TOTAL EN INVERSIÓN</b></h3>
            </div>
            <div class="modal-body panel panel-default">
                <div class="row form-group">
                    <div class="col-sm-11 col-md-11 col-lg-11">
                        <table class="fuente8 display" id="table-totales">
                            <thead>
                                <tr class="cabeceraTabla">
                                    <th style="width:60%;" data-orderable="true">CATEGORIA</th>
                                    <th style="width:40%;" data-orderable="true">TOTAL EN ARTICULOS</th>
                                </tr>
                            </thead>
                            <tbody> <?php
                                if ( isset($totalesCat) && $totalesCat != NULL){
                                    foreach ($totalesCat as $key => $value) { ?>
                                <tr>
                                    <td style="text-align: left;"><?=$value->categoria;?></td>
                                    <td align="right"><?="$value->moneda ".number_format($value->total,2);?></td>
                                </tr>
                                <?php
                                    }
                                } ?>
                            </tbody>
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

<div id="modal_producto" class="modal fade" role="dialog">
    <div class="modal-dialog w-porc-80">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center">REGISTRAR <?=($flagBS == 'B') ? 'ARTICULO' : 'SERVICIO';?></h3>
            </div>
            <div class="modal-body panel panel-default">
                <form id="form_nvo" method="POST" action="#">
                    <div class="row form-group header">
                        <div class="col-sm-11 col-md-11 col-lg-11">
                            DETALLES DEL <?=($flagBS == 'B') ? 'ARTICULO' : 'SERVICIO';?>
                            <input type="hidden" id="id" name="id" />
                            <input type="hidden" id="flagB_S" name="flagB_S" value="<?=$flagBS;?>" />
                        </div>
                    </div>

                    <div class="row form-group font-9">
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <label for="nvo_codigo">CÓDIGO:</label>
                            <input type="text" id="nvo_codigo" name="nvo_codigo" class="form-control h-2 w-porc-90" />
                            <p id="mensajeError" style="color: red;"></p>
                        </div>

                        <div class="col-sm-1 col-md-1 col-lg-2">
                            <label for="nvo_codigo_externo">CÓDIGO DE BARRA EXTERNO:</label>
                            <input type="text" id="nvo_codigo_externo" name="nvo_codigo_externo"
                                class="form-control h-2 w-porc-90" />
                        </div>

                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <label for="nvo_nombre">NOMBRE:</label>
                            <input type="text" id="nvo_nombre" name="nvo_nombre" class="form-control h-2 w-porc-90" />
                        </div>

                        <div class="col-sm-2 col-md-2 col-lg-2" hidden>
                            <label for="nvo_autocompleteCodigoSunat">CÓDIGO SUNAT:</label>
                            <input type="text" id="nvo_autocompleteCodigoSunat" name="nvo_autocompleteCodigoSunat"
                                class="form-control h-2 w-porc-90" />
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1" hidden><br>
                            <input type="text" id="nvo_codigoSunat" name="nvo_codigoSunat"
                                class="form-control h-2 w-porc-90" readOnly />
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-3">
                            <label for="nvo_tipoAfectacion">AFECTACIÓN:</label>
                            <select id="nvo_tipoAfectacion" name="nvo_tipoAfectacion" class="form-control h-3"> <?php
                                foreach ($afectaciones as $i => $val) { ?>
                                <option value="<?=$val->AFECT_Codigo?>"><?=$val->AFECT_DescripcionSmall;?></option> <?php
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group font-9" hidden>
                        <div class="col-sm-10 col-md-10 col-lg-11">
                            <label for="nvo_descripcion">DESCRIPCIÓN</label>
                            <textarea class="form-control" id="nvo_descripcion" name="nvo_descripcion" maxlength="800"
                                placeholder="Indique una descripción"></textarea>
                            <div class="pull-right">
                                Caracteres restantes:
                                <span class="contadorCaracteres">800</span>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group font-9">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_familia">FAMILIA:</label>
                            <select id="nvo_familia" name="nvo_familia" class="form-control h-3"> <?php
                                foreach ($familias as $i => $val) { ?>
                                <option value="<?=$val->FAMI_Codigo?>"><?=$val->FAMI_Descripcion;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2" <?=($flagBS == 'S') ? 'hidden' : '';?>>
                            <label for="nvo_fabricante">FABRICANTE:</label>
                            <select id="nvo_fabricante" name="nvo_fabricante" class="form-control h-3">
                                <option value=""> :: SELECCIONE :: </option> <?php
                                foreach ($fabricantes as $i => $val) { ?>
                                <option value="<?=$val->FABRIP_Codigo?>"><?=$val->FABRIC_Descripcion;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2" <?=($flagBS == 'S') ? 'hidden' : '';?>>
                            <label for="nvo_marca">MARCA:</label>
                            <select id="nvo_marca" name="nvo_marca" class="form-control h-3">
                                <option value=""> :: SELECCIONE :: </option> <?php
                                foreach ($marcas as $i => $val) { ?>
                                <option value="<?=$val->MARCP_Codigo?>"><?=$val->MARCC_Descripcion;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2" <?=($flagBS == 'S') ? 'hidden' : '';?>>
                            <label for="nvo_modelo">MODELO:</label>
                            <input type="text" id="nvo_modelo" name="nvo_modelo" class="form-control h-2 w-porc-90" />
                            <!--
                                LOS DATOS DEL MODELO SON UTILIZADOS EN PRODUCCION, ASI DIFERENCIA ENTRE ARTICULOS E INSUMOS.
                                valor = "ARTICULO" ó "INSUMO"
                            -->
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1" <?=($flagBS == 'S') ? 'hidden' : '';?>>
                            <label for="nvo_stockMin">STOCK MINIMO:</label>
                            <input type="number" step="1" min="0" id="nvo_stockMin" name="nvo_stockMin" value="0"
                                class="form-control h-2 w-porc-90" />
                        </div>
                    </div>

                    <div class="row form-group font-9">
                        <?php if($flagBS == 'S'): ?>
                        <input type="hidden" value="32" id="nvo_unidad[0]" name="nvo_unidad[0]" />
                        <?php else: ?>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_unidad">UNIDAD DE MEDIDA:</label>
                            <select id="nvo_unidad[0]" name="nvo_unidad[0]" class="form-control h-3"> <?php
                                foreach ($unidades as $i => $val) { ?>
                                <option value="<?=$val->UNDMED_Codigo?>"
                                    <?=($flagBS == 'S' && trim($val->UNDMED_Simbolo) != 'ZZ') ? 'disabled' : '';?>
                                    <?=($flagBS == 'B' && trim($val->UNDMED_Simbolo) == 'NIU') ? 'selected' : '';?>
                                    <?=($flagBS == 'B' && trim($val->UNDMED_Simbolo) == 'ZZ') ? 'disabled' : '';?>>
                                    <?="$val->UNDMED_Descripcion | $val->UNDMED_Simbolo";?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_preciocosto">PRECIO COSTO S/:</label>
                            <input type="number" id="nvo_preciocosto" name="nvo_preciocosto" value="0"
                                class="form-control h-2 w-porc-90" />
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_preciocosto">ADJUNTAR FICHA TECNICA</label>
                            <input type="file" id="ficha_file" name="ficha_file" value="0"
                             />
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_preciocosto"></label>
                            <img src="<?=base_url();?>images/documento.png" alt="" width="50px" height="50px"
                                onclick="ver_ficha()">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1">
                        </div>
                    </div>

                    <div class="row form-group header info_formapago">
                        <div class="col-sm-11 col-md-11 col-lg-11">
                            PRECIOS
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                            <table class="fuente8 display" id="table-precios">
                                <thead>
                                    <tr class="cabeceraTabla">
                                        <th data-orderable="false">CATEGORIA</th> <?php
                                        foreach ($precio_monedas as $i => $val) { ?>
                                        <th style="width: 15%" data-orderable="false"><?=$val->MONED_Descripcion;?></th> <?php
                                        } ?>
                                    </tr>
                                </thead>
                                <tbody> <?php
                                        foreach ($precio_categorias as $i => $val) { ?>
                                    <tr>
                                        <td><?=$val->TIPCLIC_Descripcion;?></td> <?php
                                                foreach ($precio_monedas as $j => $value) { ?>
                                        <td>
                                            <input type="number" name="nvo_pcategoria[]"
                                                value="<?=$val->TIPCLIP_Codigo;?>" hidden />
                                            <input type="number" name="nvo_pmoneda[]" value="<?=$value->MONED_Codigo;?>"
                                                hidden />
                                            <input type="number" step="1.00" min="1" name="precios[]" value="0"
                                                class="form-control h-1 w-porc-80 precio-<?=$val->TIPCLIP_Codigo.$value->MONED_Codigo;?>" />
                                        </td> <?php
                                                } ?>
                                    </tr><?php
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="registrar()">Guardar</button>
                <button type="button" class="btn btn-info nvo_limpiar">Limpiar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>

<script language="javascript">
$(document).ready(function() {

    $('#table-totales').DataTable({
        responsive: true,
        filter: false,
        destroy: true,
        autoWidth: false,
        paging: false,
        language: spanish
    });

    $('#table-precios').DataTable({
        responsive: true,
        filter: false,
        destroy: true,
        autoWidth: false,
        paging: false,
        language: spanish
    });

    $('#table-productos').DataTable({
        responsive: true,
        filter: false,
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?=base_url();?>index.php/almacen/producto/datatable_productos/<?=$flagBS;?>",
            type: "POST",
            data: {
                dataString: ""
            },
            beforeSend: function() {},
            error: function() {}
        },
        language: spanish
    });

    $("#buscarP").click(function() {
        codigo = $('#txtCodigo').val();
        producto = $('#txtNombre').val();
        familia = $('#txtFamilia').val();
        marca = $('#txtMarca').val();
        modelo = $('#txtModelo').val();

        $('#table-productos').DataTable({
            responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?=base_url();?>index.php/almacen/producto/datatable_productos/<?=$flagBS;?>",
                type: "POST",
                data: {
                    txtCodigo: codigo,
                    txtNombre: producto,
                    txtFamilia: familia,
                    txtMarca: marca,
                    txtModelo: modelo
                },
                error: function() {}
            },
            language: spanish
        });
    });

    $("#limpiarP").click(function() {

        $("#txtCodigo").val("");
        $("#txtNombre").val("");
        $("#txtFamilia").val("");
        $("#txtMarca").val("");
        $("#txtModelo").val("");

        codigo = "";
        producto = "";
        familia = "";
        marca = "";
        modelo = "";

        $('#table-productos').DataTable({
            responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?=base_url();?>index.php/almacen/producto/datatable_productos/<?=$flagBS;?>",
                type: "POST",
                data: {
                    txtCodigo: codigo,
                    txtNombre: producto,
                    txtFamilia: familia,
                    txtMarca: marca,
                    txtModelo: modelo
                },
                error: function() {}
            },
            language: spanish
        });
    });

    $("#nvo_autocompleteCodigoSunat").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?=base_url();?>index.php/almacen/producto/autocompleteIdSunat/",
                type: "POST",
                data: {
                    term: $("#nvo_autocompleteCodigoSunat").val()
                },
                dataType: "json",
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.descripcion,
                            value: item.descripcion,
                            idsunat: item.idsunat
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $("#nvo_codigoSunat").val(ui.item.idsunat);
        },
        minLength: 2
    });

    $("#nvo_codigo").change(function() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?=base_url();?>index.php/almacen/producto/existsCode/",
            data: {
                codigo: $(this).val(),
                producto: $("#id").val()
            },
            success: function(data) {
                if (data.match == true) {
                    Swal.fire({
                        icon: "info",
                        title: "Código registrado.",
                        html: "<b class='color-red'>El código ingresado ha sido registrado anteriormente.</b>",
                        showConfirmButton: true
                    });
                }
            }
        });
    });

    $("#nvo_nombre").change(function() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?=base_url();?>index.php/almacen/producto/existsNombre/",
            data: {
                nombre: $(this).val(),
                producto: $("#id").val()
            },
            success: function(data) {
                if (data.match == true) {
                    Swal.fire({
                        icon: "info",
                        title: "Nombre registrado.",
                        html: "<b class='color-red'>El nombre ingresado ha sido registrado anteriormente.</b>",
                        showConfirmButton: true
                    });
                }
            }
        });
    });

    $("#nvo_descripcion").keyup(function() {
        var descripcion = $("#nvo_descripcion").val().length;

        longitud = 800 - descripcion;
        $(".contadorCaracteres").html(longitud);
    });

    $(".nvo_limpiar").click(function() {
        clean();
    });
});

function ver_ficha() {
    var id_prod = $("#id").val();
    var request = new XMLHttpRequest();  

    if (id_prod === "" || id_prod === "NULL") {
        alert("Ninguna ficha adjunta");
        return;
    }

    var ruta = base_url + 'uploads/fichas/' + id_prod + '.pdf';

    // Verificar si el archivo existe
    request.open('HEAD', ruta, true);
    request.onreadystatechange = function() {
        if (request.readyState === 4) {
            if (request.status === 200) {
                window.open(ruta, 'width=500,height=150');

            } else {
                
                alert("La ficha no existe.");
            }
        }
    };
    request.send();
}


function getProducto(id) {
    var url = base_url + "index.php/almacen/producto/getProductoInfo";
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: {
            producto: id
        },
        beforeSend: function() {
            clean();
        },
        success: function(data) {
            if (data.match == true) {
                info = data.producto;
                unidad = data.unidades;
                precio = data.precios;

                $("#id").val(info.producto);
                $("#nvo_codigo").val(info.codigo);
                $("#nvo_nombre").val(info.nombre);
                $("#nvo_autocompleteCodigoSunat").val(info.sunatDescripcion);
                $("#nvo_codigoSunat").val(info.sunatCodigo);
                $("#nvo_tipoAfectacion").val(info.afectacion);
                $("#nvo_descripcion").val(info.descripcion);
                $("#nvo_familia").val(info.familia);
                $("#nvo_fabricante").val(info.fabricante);
                $("#nvo_marca").val(info.marca);
                $("#nvo_modelo").val(info.modelo);
                $("#nvo_stockMin").val(info.stockMin);
                $("#nvo_preciocosto").val(info.nvo_preciocosto);
                $("#nvo_codigo_externo").val(info.nvo_codigo_externo);

                /*
                $("#nvo_codigo").attr({
                  readOnly: true
                });
                */

                campo_unidad = "nvo_unidad[0]";
                $.each(unidad, function(i, v) {
                    document.getElementById(campo_unidad).value = v.unidad;
                });

                $.each(precio, function(i, v) {
                    $(".precio-" + v.categoria + v.moneda).val(v.precio);
                });

                $("#modal_producto").modal("toggle");
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

function registrar() {
    Swal.fire({
        icon: "info",
        title: "¿Esta seguro de guardar el registro?",
        html: "<b class='color-red'></b>",
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.value) {
            let id = $("#id").val();
            let nombre = $("#nvo_nombre").val();
            validacion = true;
            var codigo_usuario = $("#nvo_codigo").val();
            if (nombre == "") {
                Swal.fire({
                    icon: "error",
                    title: "Verifique los datos ingresados.",
                    html: "<b class='color-red'>Debe ingresar un nombre.</b>",
                    showConfirmButton: true,
                    timer: 4000
                });
                $("#nvo_nombre").focus();
                validacion = false;
                return null;
            }
            if ($("#nvo_codigo").val() == "") {
                Swal.fire({
                    icon: "error",
                    title: "Verifique los datos ingresados.",
                    html: "<b class='color-red'>Debe ingresar un código.</b>",
                    showConfirmButton: true,
                    timer: 4000
                });
                $("#nvo_codigo").focus();
                validacion = false;
                return null;
            }

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?=base_url();?>index.php/almacen/producto/existsCode/",
                data: {
                    codigo: codigo_usuario,
                    producto: $("#id").val()
                },
                success: function(data) {
                    if (validacion) {
                        if (data.match == true) {
                            Swal.fire({
                                icon: "info",
                                title: "Este código ya se encuentra registrado.",
                                html: "<b class='color-red'>La información no ha sido registrada. Por favor, cambie el código</b>",
                                timer: 4000

                            });
                            $("#nvo_codigo").focus();
                            return false;
                        } else {
                            registro_producto();
                        }
                    }
                }
            });
        }
    });
}

function registro_producto() {
    var url = base_url + "index.php/almacen/producto/guardar_registro";

    // Crear un objeto FormData
    var formData = new FormData();
    var ficha = $("#ficha_file")[0].files[0]; // Capturar el archivo PDF

    // Agregar todos los datos serializados al FormData
    formData.append('info', $("#form_nvo").serialize());

    // Agregar el archivo PDF al FormData
    formData.append('ficha', ficha);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false, // Evitar que jQuery establezca contentType
        processData: false, // No procesar los datos (no convertir a query string)
        dataType: 'json',
        success: function(data) {
            let id = $("#id").val();
            if (data.result == "success") {
                let titulo = id == "" ? "¡Registro exitoso!" : "¡Actualización exitosa!";
                Swal.fire({
                    icon: "success",
                    title: titulo,
                    showConfirmButton: true,
                    timer: 2000
                });

                clean();
                $("#limpiar").click();
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
        complete: function() {
            $("#nvo_codigo").focus();
        }
    });
}


function insertar_costo(id, precioc) {
    costo = $("#" + precioc).val();

    if (id != '' && costo != '') {
        url = base_url + "index.php/almacen/producto/nvoCosto";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                codigo: id,
                nvoCosto: costo
            },
            dataType: 'json',
            beforeSend: function() {
                $("#btnCosto" + precioc).hide();
                $("#loading" + precioc).show();
            },
            success: function(data) {
                console.log(data);
                if (data.result == 'success') {

                    Swal.fire({
                        icon: "success",
                        title: "Precio actualizado.",
                        showConfirmButton: true,
                        timer: 2000
                    });

                    $("#span" + precioc).html(costo);
                    $("#loading" + precioc).hide();
                    $("#btnCosto" + precioc).show();
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: data.msg,
                        showConfirmButton: true,
                        timer: 2000
                    });

                    $("#loading" + precioc).hide();
                    $("#btnCosto" + precioc).show();
                }
            },
            error: function(HXR, error) {
                $("#loading" + precioc).hide();
                $("#btnCosto" + precioc).show();
            }
        });
    }
}

function cambiarEstado(estado, producto) {
    url = '<?php echo base_url(); ?>index.php/almacen/producto/cambiarEstado/';
    $.ajax({
        url: url,
        type: "POST",
        data: {
            estado: Number(estado),
            cod_producto: producto
        },
        dataType: "json",
        beforeSend: function(data) {
            $('#cargando_datos').show();
        },
        success: function(data) {
            if (data.cambio == true || data.cambio == 'true') {
                $('#cargando_datos').hide();
                alert('Cambio de estado correctamente!');
                window.location = "<?php echo base_url(); ?>index.php/almacen/producto/productos/B";
            } else {
                $('#cargando_datos').hide();
                alert('Ah Ocurrido un error con el cambio de estado!');
            }
        },
        error: function(data) {
            $('#cargando_datos').hide();
            console.log('Error en cambio de fase');
        }
    });
}

function clean() {
    $("#form_nvo")[0].reset();
    $("#id").val("");
    $(".contadorCaracteres").html("800");

    $("#nvo_codigo").removeAttr("readOnly");
}
</script>