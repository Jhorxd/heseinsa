<!--vista => producto_view.php-->

<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/producto.js?=<?=JS;?>"></script>

<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>

<style>
    .costo{
        display: inline-block;
        position: relative;
        padding: 0.5em;
        cursor: pointer;
    }
    .costo:hover{
        background: rgba(51,51,51,.1);
    }
    .costo .editar_costo{
        text-align: left;
        position: absolute;
        visibility: hidden;
        padding: 0.7em 0.7em 0.7em 0.7em;
        width: 25em;
        top: -25%;
        right: 100%;
        background: rgba(51,51,51,.9);
    }
    .costo:hover .editar_costo{
        visibility: visible;
        width: 25em;
        background: rgba(51,51,51,.9);
        border-radius: 0.1em 0.1em 0.1em 0.1em;
    }
    .costo:hover input, .costo:hover .editar_costo img{
        opacity: 1;
    }
    .editar_costo input, .editar_costo img{
        opacity: 0;
        width: auto;
    }
    .busqueda_opcinal{
        position: relative;
        text-align: center;
    }
    .busqueda_opcinal_1{
        position: absolute;
        background-color: #004488;
        color: #f1f4f8;
        width: 98px;
        height: 70px;
        top: 14px;
        left: 135px;
        -webkit-box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
        -moz-box-shadow:    0px 0px 0px 3px rgba(47, 50, 50, 0.34);
        box-shadow:         0px 0px 0px 3px rgba(47, 50, 50, 0.34);
        cursor: pointer;
    }
    .control_1 .seleccionado{
        position: absolute;
        border-radius: 3px;
        background-color: #29fb00;
        width: 98px;
        height: 5px;
        bottom: 20px;
        left: 135px;
    }
    .busqueda_opcinal_2{
        position: absolute;
        background: #109EC8;
        color: #f1f4f8;
        width: 95px;
        height: 70px;
        top: 14px;
        right: 102px;
        cursor: pointer;
        -webkit-box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
        -moz-box-shadow:    0px 0px 0px 3px rgba(47, 50, 50, 0.34);
        box-shadow:         0px 0px 0px 3px rgba(47, 50, 50, 0.34);
    }
    .control_2 .seleccionado{
        position: absolute;
        border-radius: 3px;
        background-color: #ab1c27;
        width: 96px;
        height: 5px;
        bottom: 21px;
        right: 102px;
    }
    .lista_botones #actualizar
    {
    	background-image: url(<?php echo base_url(); ?>/images/Update-48.png);
    	background-size: 36px;
    	opacity: 0.2;
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
                <input id="txtCodigo" name="txtCodigo" type="text" class="form-control w-porc-90 h-1" placeholder="Codigo" maxlength="30" value="<?=$codigo;?>">
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="txtNombre">Nombre: </label>
                <input id="txtNombre" name="txtNombre" type="text" class="form-control w-porc-90 h-1" maxlength="100" placeholder="Nombre producto" value="<?php echo $nombre; ?>">
            </div>
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
                <input id="txtMarca" type="text" class="form-control w-porc-90 h-1" name="txtMarca" maxlength="100" placeholder="Marca producto" value="<?=$marca;?>">
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
            <div class="col-sm-1 col-md-1 col-lg-1"><br>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_totales">Inversión</button>
            </div>

            <input id="codigoInterno" name="codigoInterno" type="hidden" class="cajaGrande" maxlength="100" placeholder="Codigo original" value="<?=$codigoInterno;?>">
        </div>
    </form>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="acciones">
                        <div id="botonBusqueda">
                            <?php if ($this->session->userdata('rol')==1){ ?>
                            <ul id="imprimirProducto" class="lista_botones">
                                <li id="imprimir">Imprimir</li>
                            </ul>
                            <?php }?>

                            <ul id="limpiarP" class="lista_botones">
                                <li id="limpiar">Limpiar</li>
                            </ul>
                            <ul id="buscarP" class="lista_botones">
                                <li id="buscar">Buscar</li>
                            </ul>
                            <ul id="buscarP2" class="lista_botones">
                                <li id="actualizar" data-c="0" onclick="send_data();">Act. Precios</li>
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
                                <th style="width: 05%" data-orderable="true">COD</th>
                                <th style="width: 20%" data-orderable="true">NOMBRE</th>
                                <!-- <th style="width: 10%" data-orderable="true">FAMILIA</th> -->
                                <!-- <th style="width: 10%" data-orderable="true"><?=($flagBS == "B") ? "MARCA" : "";?></th> -->
                                <!-- <th style="width: 10%" data-orderable="false">UNIDAD MEDIDA</th> -->
                                <th data-orderable="true"><?=($flagBS == "B") ? "P. COSTO" : "";?></th> <?php
                                
                                foreach ($categorias as $key => $val){ ?>
                                    <th style="text-indent: 0;" data-orderable="false">UTI</th> 
                                    <th style="text-indent: 0;" data-orderable="false"><?=$val->TIPCLIC_Descripcion;?></th> 
                                    <?php
                                }?>
                                
                                <th style="width: 05%" data-orderable="false">ACT.</th>

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
                            <input type="hidden" id="id" name="id"/>
                            <input type="hidden" id="flagBS" name="flagBS" value="<?=$flagBS;?>"/>
                        </div>
                    </div>

                    <div class="row form-group font-9">
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <label for="nvo_codigo">CÓDIGO:</label>
                            <input type="text" id="nvo_codigo" name="nvo_codigo" class="form-control h-2 w-porc-90"/>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="nvo_nombre">NOMBRE:</label>
                            <input type="text" id="nvo_nombre" name="nvo_nombre" class="form-control h-2 w-porc-90"/>
                        </div>

                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_autocompleteCodigoSunat">CÓDIGO SUNAT:</label>
                            <input type="text" id="nvo_autocompleteCodigoSunat" name="nvo_autocompleteCodigoSunat" class="form-control h-2 w-porc-90"/>
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1"><br>
                            <input type="text" id="nvo_codigoSunat" name="nvo_codigoSunat" class="form-control h-2 w-porc-90" readOnly/>
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

                    <div class="row form-group font-9">
                        <div class="col-sm-10 col-md-10 col-lg-11">
                            <label for="nvo_descripcion">DESCRIPCIÓN</label>
                            <textarea class="form-control" id="nvo_descripcion" name="nvo_descripcion" maxlength="800" placeholder="Indique una descripción"></textarea>
                            <div class="pull-right">
                                Caracteres restantes:
                                <span class="contadorCaracteres">800</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row form-group font-9" <?=($flagBS == 'S') ? 'hidden' : '';?>>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_familia">FAMILIA:</label>
                            <select id="nvo_familia" name="nvo_familia" class="form-control h-3"> <?php
                                foreach ($familias as $i => $val) { ?>
                                    <option value="<?=$val->FAMI_Codigo?>"><?=$val->FAMI_Descripcion;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_fabricante">FABRICANTE:</label>
                            <select id="nvo_fabricante" name="nvo_fabricante" class="form-control h-3">
                                <option value=""> :: SELECCIONE :: </option> <?php
                                foreach ($fabricantes as $i => $val) { ?>
                                    <option value="<?=$val->FABRIP_Codigo?>"><?=$val->FABRIC_Descripcion;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_marca">MARCA:</label>
                            <select id="nvo_marca" name="nvo_marca" class="form-control h-3">
                                <option value=""> :: SELECCIONE :: </option> <?php
                                foreach ($marcas as $i => $val) { ?>
                                    <option value="<?=$val->MARCP_Codigo?>"><?=$val->MARCC_Descripcion;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_modelo">MODELO:</label>
                            <input type="text" id="nvo_modelo" name="nvo_modelo" class="form-control h-2 w-porc-90"/>
                            <!--
                                LOS DATOS DEL MODELO SON UTILIZADOS EN PRODUCCION, ASI DIFERENCIA ENTRE ARTICULOS E INSUMOS.
                                valor = "ARTICULO" ó "INSUMO"
                            -->
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <label for="nvo_stockMin">STOCK MINIMO:</label>
                            <input type="number" step="1" min="0" id="nvo_stockMin" name="nvo_stockMin" value="0" class="form-control h-2 w-porc-90"/>
                        </div>
                    </div>

                    <div class="row form-group font-9">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_unidad">UNIDAD DE MEDIDA:</label>
                            <select id="nvo_unidad[]" name="nvo_unidad[]" class="form-control h-3"> <?php
                                foreach ($unidades as $i => $val) { ?>
                                    <option value="<?=$val->UNDMED_Codigo?>"
                                        <?=($flagBS == 'S' && trim($val->UNDMED_Simbolo) != 'ZZ') ? 'disabled' : '';?>
                                        <?=($flagBS == 'B' && trim($val->UNDMED_Simbolo) == 'NIU') ? 'selected' : '';?>
                                        <?=($flagBS == 'B' && trim($val->UNDMED_Simbolo) == 'ZZ') ? 'disabled' : '';?>
                                    ><?="$val->UNDMED_Descripcion | $val->UNDMED_Simbolo";?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
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
                                                        <input type="number" name="nvo_pcategoria[]" value="<?=$val->TIPCLIP_Codigo;?>" hidden/>
                                                        <input type="number" name="nvo_pmoneda[]" value="<?=$value->MONED_Codigo;?>" hidden/>
                                                        <input type="number" step="1.00" min="1" name="precios[]" value="0" class="form-control h-1 w-porc-80 precio-<?=$val->TIPCLIP_Codigo.$value->MONED_Codigo;?>"/>
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
                <button type="button" class="btn btn-default nvo_limpiar" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>

<script language="javascript" >
    
    $(document).ready(function() {

        $('#table-totales').DataTable({
            filter: false,
            destroy: true,
            autoWidth: false,
            paging: false,
            language: spanish
        });

        $('#table-precios').DataTable({
            filter: false,
            destroy: true,
            autoWidth: false,
            paging: false,
            language: spanish
        });

        $('#table-productos').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : "<?=base_url();?>index.php/almacen/producto/datatable_productos_lista_precios/<?=$flagBS;?>",
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function()
                    {
                    	data=[];
                    	validar_update();
                    },
                    error: function(){
                    }
            },
            language: spanish
        });

        $("#buscarP").click(function(){

        		data=[];
        		validar_update();
            codigo = $('#txtCodigo').val();
            producto = $('#txtNombre').val();
            familia = $('#txtFamilia').val();
            marca = $('#txtMarca').val();
            modelo = $('#txtModelo').val();

            $('#table-productos').DataTable({
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                ajax:{
                        url : "<?=base_url();?>index.php/almacen/producto/datatable_productos_lista_precios/<?=$flagBS;?>",
                        type: "POST",
                        data: { txtCodigo: codigo, txtNombre: producto, txtFamilia: familia, txtMarca: marca, txtModelo: modelo },
                        error: function(){
                        }
                },
                language: spanish
            });
        });

        $("#limpiarP").click(function(){

        		data=[];
        		validar_update();
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
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                ajax:{
                        url : "<?=base_url();?>index.php/almacen/producto/datatable_productos_lista_precios/<?=$flagBS;?>",
                        type: "POST",
                        data: { txtCodigo: codigo, txtNombre: producto, txtFamilia: familia, txtMarca: marca, txtModelo: modelo },
                        error: function(){
                        }
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
                    success: function (data) {
                        response( $.map(data, function(item) {
                                return {
                                    label: item.descripcion,
                                    value: item.descripcion,
                                    idsunat: item.idsunat
                                }})
                            );
                    }
                });
            },
            select: function(event, ui) {
                $("#nvo_codigoSunat").val(ui.item.idsunat);
            },
            minLength: 2
        });

        /*$("#nvo_codigo").change(function(){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?=base_url();?>index.php/almacen/producto/existsCode/",
                    data: {
                        codigo: $(this).val(),
                        producto: $("#id").val()
                    },
                    success: function(data){
                        if (data.match == true){
                            Swal.fire({
                                        icon: "info",
                                        title: "Código registrado.",
                                        html: "<b class='color-red'>El código ingresado ha sido registrado anteriormente.</b>",
                                        showConfirmButton: true
                                    });
                        }
                    }
                });
        });*/

        $("#nvo_nombre").change(function(){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?=base_url();?>index.php/almacen/producto/existsNombre/",
                    data: {
                        nombre: $(this).val(),
                        producto: $("#id").val()
                    },
                    success: function(data){
                        if (data.match == true){
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

        $("#nvo_descripcion").keyup(function(){
            var descripcion = $("#nvo_descripcion").val().length;

            longitud = 800 - descripcion;
            $(".contadorCaracteres").html(longitud);
        });

        $(".nvo_limpiar").click(function(){
            clean();
        });
    });

    function getProducto(id){
        var url = base_url + "index.php/almacen/producto/getProductoInfo";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data:{
                    producto: id
            },
            beforeSend: function(){
                clean();
            },
            success: function(data){
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

                    $("#nvo_codigo").attr({
                        readOnly: true
                    });

                    $.each(unidad, function(i,v){
                        $("#nvo_unidad").val(v.unidad);
                    });

                    $.each(precio, function(i,v){
                        $(".precio-" + v.categoria + v.moneda).val(v.precio);
                    });


                    $("#modal_producto").modal("toggle");
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

    function registrar(){
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
                var id = $("#id").val();
                var nombre = $("#nvo_nombre").val();
                validacion = true;
                var codigo_usuario = $("#nvo_codigo").val();
                if (nombre == ""){
                    Swal.fire({
                        icon: "error",
                        title: "Verifique los datos ingresados.",
                        html: "<b class='color-red'>Debe ingresar un nombre.</b>",
                        showConfirmButton: true,
                        timer: 4000
                    });
                    $("#nvo_nombre").focus();
                    validacion = false;
                    return false;
                }
                if ($("#nvo_codigo").val() == ""){
                    $("#nvo_codigo").focus();
                    Swal.fire({
                        icon: "error",
                        title: "Verifique los datos ingresados.",
                        html: "<b class='color-red'>Debe ingresar un código.</b>",
                        showConfirmButton: true,
                        timer: 4000
                    });
                    validacion = false;
                    return false;
                }
                url2 = base_url+"index.php/almacen/producto/obtener_producto_x_codigo_usuario/"+codigo_usuario;
                $.post(url2,{codigo_usuario:codigo_usuario},function(data){
                    if(data>0 && id==""){

                        Swal.fire({
                            icon: "info",
                            title: "Este código ya se encuentra registrado.",
                            html: "<b style='color: red; font-size: 12pt;'>¿Desea continuar?</b>",
                            showConfirmButton: true,
                            showCancelButton: true,
                            confirmButtonText: "Aceptar",
                            cancelButtonText: "Cancelar"
                        }).then(result => {
                            if (result.value){
                                if (validacion == true){
                                    registro_producto();
                                }                                       
                            }
                            else{
                                $("#nvo_codigo").focus();
                                return false;
                            }
                        });

                    }else{
                    if (validacion == true){
                        registro_producto();    
                    }
                    }
                });

            }
        });
    }

   function registro_producto(){

        var url = base_url + "index.php/almacen/producto/guardar_registro";
        var info = $("#form_nvo").serialize();
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: info,
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

                    clean();
                    $("#limpiar").click();
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
                $("#nvo_codigo").focus();
            }
        });
    }

    function insertar_costo(id, precioc){
        costo = $("#"+precioc).val();

        if (id != '' && costo != ''){
            url = base_url + "index.php/almacen/producto/nvoCosto";
            
            $.ajax({
                type: "POST",
                url: url,
                data: { codigo: id, nvoCosto: costo },
                dataType: 'json',
                beforeSend: function(){
                    $("#btnCosto"+precioc).hide();
                    $("#loading"+precioc).show();
                },
                success: function(data){
                    console.log(data);
                    if (data.result == 'success'){
                        
                        Swal.fire({
                            icon: "success",
                            title: "Precio actualizado.",
                            showConfirmButton: true,
                            timer: 2000
                        });

                        $("#span"+precioc).html(costo);
                        $("#loading"+precioc).hide();
                        $("#btnCosto"+precioc).show();
                    }
                    else{
                        Swal.fire({
                                icon: "warning",
                                title: data.msg,
                                showConfirmButton: true,
                                timer: 2000
                        });

                        $("#loading"+precioc).hide();
                        $("#btnCosto"+precioc).show();
                    }
                },
                error : function(HXR, error){
                    $("#loading"+precioc).hide();
                    $("#btnCosto"+precioc).show();
                }
            });
        }
    }

    function cambiarEstado(estado, producto){
        url = '<?php echo base_url(); ?>index.php/almacen/producto/cambiarEstado/';
        $.ajax({
            url : url,
            type: "POST",
            data: {
                estado : Number(estado),
                cod_producto : producto
            },
            dataType: "json",
            beforeSend: function(data){
                $('#cargando_datos').show();
            },
            success: function(data){
                if(data.cambio == true || data.cambio == 'true'){
                    $('#cargando_datos').hide();
                    alert('Cambio de estado correctamente!');
                    window.location = "<?php echo base_url(); ?>index.php/almacen/producto/productos/B";
                }else{
                    $('#cargando_datos').hide();
                    alert('Ah Ocurrido un error con el cambio de estado!');
                }
            },
            error: function(data){
                $('#cargando_datos').hide();
                console.log('Error en cambio de fase');
            }
        });
    }

    function clean(){
        $("#form_nvo")[0].reset();
        $("#id").val("");
        $(".contadorCaracteres").html("800");

        $("#nvo_codigo").removeAttr("readOnly");
    }
    //_____________________________________________________

    var data=[];
    function calcular(accion,valor)
    {
    	var esta=<?php echo $esta; ?>;
    	
    	if (accion==1) 
    	{
    		if ($(".porcen"+valor).attr("data-check")==2) 
    		{
    			console.log("N/V");
    			$(".porcen"+valor).attr("data-check", 1);
    			return false;

    		}
    		var precio=$(".precio"+valor).val();
    		var porcen=parseInt($(".porcen"+valor).val());
    		var env=$(".porcen"+valor).attr("data-env"); 


    		if (porcen>0) 
    		{
    			var tes=valor+"";
    			var costo = tes.substring(0, tes.length - 1);
    			var costo_total=parseFloat($("#span"+costo).attr("data-bat"));


    			var p_intac=porcen;
    			if (costo_total>0) 
    			{
    				var item=[];
    				if (porcen>100) 
    				{
    					if (porcen>999) 
    					{
    						return false;
    					}
    					else
    					{
    						porcen=porcen/100;
    					}

    				}
    				else
    				{
    					if (porcen==100) 
    					{
    						porcen=1.00;
    					}
    					else
    					porcen=porcen/100;
    				}

    				var m=porcen;
    				var pm=parseFloat(m)+0.00;
    				var precio_f=(parseFloat(costo_total)*pm);
    				var precio_p=(Math.round(precio_f * 100) / 100).toFixed(2);
    				var total=parseFloat(costo_total)+parseFloat(precio_p);
    				var mostrar=(Math.round(total * 100) / 100).toFixed(2);
    				$(".precio"+valor).val(mostrar);

    				item.push(valor);
    				item.push(p_intac);
    				item.push(0);
    				item.push($(".porcen"+valor).attr("data-type"));
    				item.push(mostrar);
    				item.push(0);
    				item.push(esta);
    				item.push($(".porcen"+valor).attr("data-prod"));

    				//var obj={familia:"Fam1",valor:item};

    				if (data.length>0) 
    				{
    					for (var i = 0; i < data.length; i++) 
	    				{
	    					if (data[i][0]==valor) 
	    					{
	    							data.splice(i,1);
	    					}
	    				}
    				}
    				data.push(item);

    				var cont = $("#"+env).attr("data-contador");
    				$("#"+env).attr("data-contador", parseInt(cont)+1);
    				validar_img(env);


    				
    			}

    		}
    		else
    		{

    			var cont = $("#"+env).attr("data-contador");
    			if (cont>0) 
    			{
    				$("#"+env).attr("data-contador", parseInt(cont)-1);
    				validar_img(env);
    			}
    			

    			$(".porcen"+valor).val($(".porcen"+valor).attr("data-porcen"));
    			$(".precio"+valor).val($(".precio"+valor).attr("data-precio"));

    		}
    		validar_update();
    	}
    	if (accion==2) 
    	{
    		
    			//$(".porcen"+valor).attr("data-check", 2);
    			$(".porcen"+valor).val(0);

    			  var env=$(".porcen"+valor).attr("data-env"); 
    			  var cont = $("#"+env).attr("data-contador");
    				$("#"+env).attr("data-contador", parseInt(cont)+1);

    				validar_img(env);

    				var item=[];

    			 //  item.push(valor);
    				// item.push(0);
    				// item.push($(".precio"+valor).val());
    				// item.push(esta);
    				// item.push($(".porcen"+valor).attr("data-type"));

    				item.push(valor);
    				item.push(0);
    				item.push(0);
    				item.push($(".porcen"+valor).attr("data-type"));
    				item.push($(".precio"+valor).val());
    				item.push(0);
    				item.push(esta);
    				item.push($(".porcen"+valor).attr("data-prod"));

    				if (data.length>0) 
    				{
    					for (var i = 0; i < data.length; i++) 
	    				{
	    					if (data[i][0]==valor) 
	    					{
	    							data.splice(i,1);
	    					}
	    				}
    				}
    				data.push(item);
    	}

    	console.log(data);
    	validar_update();
    	
    	


    }
    function send_data()
    {
    	var check=$("#actualizar").attr("data-c");
    	if (check==1) 
    	{
    		
					$.ajax({
					          type: "POST",
					          url: "<?php echo base_url(); ?>index.php/almacen/producto/cambiarPrecioProducto_masivo/",
					          data: {'array': JSON.stringify(data)},     
					          success: function(data)
					          {
					          	var titulo="Precios Actualizados";
					          	  Swal.fire({
                        icon: "success",
                        title: titulo,
                        showConfirmButton: true,
                        timer: 2000
                    });
					          	  $("#limpiar").click();


					        	}
					});
    	}
    	else{
    		//
    	}

    }

    function trunc (x, posiciones = 0) {
		  var s = x.toString()
		  var l = s.length
		  var decimalLength = s.indexOf('.') + 1
		  var numStr = s.substr(0, decimalLength + posiciones)
		  return Number(numStr)
			}
			function validar_update()
			{
				if (data.length>0) 
				{
					$("#actualizar").css("opacity","1");
					$("#actualizar").attr("data-c","1");
				}
				else
				{
					$("#actualizar").css("opacity","0.2");
					$("#actualizar").attr("data-c","0");

				}
			}
		function validar_img(id)
		{
			var cont = $("#"+id).attr("data-contador");
			if (cont>0) 
			{
				$("#"+id).css("opacity", "1");
				$("#"+id).attr("onclick","send_data_by("+id+");");
				$("#"+id).css("cursor", "pointer");

			}
			else
			{
				$("#"+id).css("opacity", "0.2");
				$("#"+id).attr("onclick","javascript");
				$("#"+id).css("cursor", "alias");


			}
		}	
		function limpiar_data(porciones)
		{
					if (data.length>0) 
    				{
										var por=porciones+"3";
	    						  for (var i = 0; i < data.length; i++) 
				    				{
				    					if (data[i][0]==por) 
				    					{
				    							data.splice(i,1);
				    					}
				    				}
										var por=porciones+"5";
	    						  for (var i = 0; i < data.length; i++) 
				    				{
				    					if (data[i][0]==por) 
				    					{
				    							data.splice(i,1);
				    					}
				    				}
										var por=porciones+"7";
	    						  for (var i = 0; i < data.length; i++) 
				    				{
				    					if (data[i][0]==por) 
				    					{
				    							data.splice(i,1);
				    					}
				    				}

    				}
    				console.log(data);
    				validar_update();
		}
		function send_data_by(id)
		{
			var esta=<?php echo $esta; ?>;
			var data_by=[];
			var item_by=[];
			var c=id+"";
			var porciones = c.split('1000');
			var p=porciones[0]+"3";
			var porcentaje=$(".porcen"+p).val();
			var porcentaje_viejo=$(".porcen"+p).attr("data-porcen");
			var tipo_precio=$(".porcen"+p).attr("data-type");
			var precio=$(".precio"+p).val();
			var precio_viejo=$(".precio"+p).attr("data-precio");
			var prod=$(".porcen"+p).attr("data-prod");


			item_by.push(porcentaje);
			item_by.push(porcentaje_viejo);
			item_by.push(tipo_precio);
			item_by.push(precio);
			item_by.push(precio_viejo);
			item_by.push(esta);
			item_by.push(prod);

			data_by.push(item_by);

			var item_by=[];
			var p=porciones[0]+"5";
			var porcentaje=$(".porcen"+p).val();
			var porcentaje_viejo=$(".porcen"+p).attr("data-porcen");
			var tipo_precio=$(".porcen"+p).attr("data-type");
			var precio=$(".precio"+p).val();
			var precio_viejo=$(".precio"+p).attr("data-precio");
			var prod=$(".porcen"+p).attr("data-prod");

			item_by.push(porcentaje);
			item_by.push(porcentaje_viejo);
			item_by.push(tipo_precio);
			item_by.push(precio);
			item_by.push(precio_viejo);
			item_by.push(esta);
			item_by.push(prod);

			data_by.push(item_by);

			var item_by=[];
			var p=porciones[0]+"7";
			var porcentaje=$(".porcen"+p).val();
			var porcentaje_viejo=$(".porcen"+p).attr("data-porcen");
			var tipo_precio=$(".porcen"+p).attr("data-type");
			var precio=$(".precio"+p).val();
			var precio_viejo=$(".precio"+p).attr("data-precio");
			var prod=$(".porcen"+p).attr("data-prod");


			item_by.push(porcentaje);
			item_by.push(porcentaje_viejo);
			item_by.push(tipo_precio);
			item_by.push(precio);
			item_by.push(precio_viejo);
			item_by.push(esta);
			item_by.push(prod);

			data_by.push(item_by);

			//console.log(data_by);

			$.ajax({
          type: "POST",
          url: '<?php echo base_url(); ?>index.php/almacen/producto/cambiarPrecioProducto/',
          data: {'array': JSON.stringify(data_by)},     
          success: function(data)
          {
          	$("#"+id).attr("data-contador", "0");
          	validar_img(id);

          	var p=porciones[0]+"3";
						var porcentaje=$(".porcen"+p).val();
						var precio=$(".precio"+p).val();

						$(".porcen"+p).attr("data-porcen", porcentaje);
						$(".precio"+p).attr("data-precio", precio);

						var p=porciones[0]+"5";
						var porcentaje=$(".porcen"+p).val();
						var precio=$(".precio"+p).val();

						$(".porcen"+p).attr("data-porcen", porcentaje);
						$(".precio"+p).attr("data-precio", precio);

						var p=porciones[0]+"7";
						var porcentaje=$(".porcen"+p).val();
						var precio=$(".precio"+p).val();

						$(".porcen"+p).attr("data-porcen", porcentaje);
						$(".precio"+p).attr("data-precio", precio);



						limpiar_data(porciones[0]);
						validar_update();
    			

        	}
				});

		}

</script>