<div class="modal fade bd-example-modal-lg" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-temporal">
        <div class="modal-content">
            <form id="form_tempdetalle" method="POST">
                <div class="modal-header" style="text-align: center;">
                    <h2 class="modal-title">DETALLE DE LA LINEA O ITEM <button type="button" class="btn btn-success"
                            data-target="#modal_producto" data-toggle="modal">NUEVO</button></h2>
                </div>
                <div class="modal-body panel panel-default">
                    <input type="hidden" class="form-control" name="tempSession" id="tempSession"
                        value="<?php echo $tempSession; ?>">
                    <input type="hidden" class="form-control" name="tempde_id" id="tempde_id">
                    <input type="hidden" class="form-control" name="tempde_codproducto" id="tempde_codproducto">
                    <input type="hidden" class="form-control" name="tempde_almacenproducto" id="tempde_almacenproducto">
                    <input type="hidden" class="form-control" name="tempde_unidadmedida" id="tempde_unidadmedida">
                    <input type="hidden" class="form-control" name="tempde_flagGenInd" id="tempde_flagGenInd">
                    <input type="hidden" class="form-control" name="tempde_moneda" id="tempde_moneda">
                    <input type="hidden" class="form-control" name="tempde_descuento" id="tempde_descuento">
                    <input type="hidden" class="form-control" name="tempde_descuento100" id="tempde_descuento100">
                    <input type="hidden" class="form-control" name="tempde_igv100" id="tempde_igv100">
                    <input type="hidden" class="form-control" name="tempde_productocosto" id="tempde_productocosto">
                    <input type="hidden" class="form-control" name="tempde_flagBs" id="tempde_flagBs">
                    <input type="hidden" class="form-control" name="bar_code" id="bar_code">

                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                            <span>INFORMACIÓN DEL CLIENTE</span>
                        </div>
                    </div>
                    <!--********** Info producto **********-->
                    <div class="row form-group">
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <label for="tipo_cliente">Tipo item</label>
                            <select name="flagBS" id="flagBS" class="form-control h-3 w-porc-90"
                                style="display: inline-block; width: 60px;" onchange="limpiar_campos_modal();">
                                <option value="B" selected="selected" title="Producto">P</option>
                                <option value="S" title="Servicio">S</option>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="tipo_documento">Codigo Barras</label>
                            <input type="text" class="form-control h-2 w-porc-90" name="tempde_barcode"
                                id="tempde_barcode" placeholder="codigo de barras">
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <label for="numero_documento">Descripción</label>
                            <input type="text" class="form-control h-2 w-porc-90" style="display: inline-block;"
                                name="tempde_producto" id="tempde_producto">
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <label for="numero_documento">Stock General</label>
                            <input type="text" readonly="readonly" name="tempde_prodStock" id="tempde_prodStock"
                                class="form-control h-2">
                        </div>
                    </div>

                    <!--********** DETALLES ADICIONALES **********-->
                    <div class="row form-group">
                        <div class="col-sm-9 col-md-9 col-lg-9">
                            <label for="razon_social">
                                Detalles adicionales
                                <?php if($tipo_docu == 'F' || $tipo_docu == 'GRC' || $tipo_docu == 'GRV'){ ?>
                                <abbr
                                    title="PARA MODIFICAR EL CODIGO Y DESCRIPCION INGRESE LOS NUEVOS DATOS EN 'DETALLES ADICIONALES' DE ESTA MANERA: 'CODIGO' // 'DESCRIPCION'. LUEGO, MARQUE LA CASILLA 'MOSTRAR DETALLES'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                        <path fill="#2570c1"
                                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10m-1-7v2h2v-2zm2-1.645A3.502 3.502 0 0 0 12 6.5a3.501 3.501 0 0 0-3.433 2.813l1.962.393A1.5 1.5 0 1 1 12 11.5a1 1 0 0 0-1 1V14h2z" />
                                    </svg>
                                </abbr>
                                <?php }?>

                            </label>
                            <input type="text" class="form-control h-2" name="tempde_detalleItem"
                                id="tempde_detalleItem">
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <label for="numero_documento">Historial</label><br>
                            <span style="display: none; height: 45px; width: 20px; cursor: pointer;"
                                id="linkVerVentasArticulo" name="linkVerVentasArticulo"><img
                                    src="<?=base_url();?>images/icono-factura.gif?=<?=IMG;?>" /></span>
                        </div>
                        <?php if($tipo_docu == 'F' || $tipo_docu == 'GRC' || $tipo_docu == 'GRV'){ ?>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="razon_social">Mostrar Detalles</label>
                            <input type="checkbox" class="form-control h-2" name="showDetails" id="showDetails">
                        </div>
                        <?php } ?>
                    </div>

                    <!--********** HISTORICO DEL PRODUCTO **********-->
                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11 VentasArticulo" id="VentasArticulo"
                            name="VentasArticulo">
                            <span href="javascript:;" class="btn-close">X</span>
                            <div class="detallesVentasAnteriores">
                                <span style="font-size: 10pt; font-weight: bold; padding-bottom: 1em;">PRECIO DEL
                                    ARTICULO EN VENTAS ANTERIORES</span> <br>
                                <table id="detallesVentasAnteriores" name="detallesVentasAnteriores"></table> <br>
                                <span style="font-size: 10pt; font-weight: bold; padding-bottom: 1em;">PRECIO DEL
                                    ARTICULO EN COTIZACIONES</span> <br>
                                <table id="detallesCotizaciones" name="detallesCotizaciones"></table>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group align-items-center">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="cantidad">Cantidad</label>
                            <input type="text" class="form-control h-2 w-porc-90" name="tempde_cantidad"
                                id="tempde_cantidad" value="0" onkeypress="return numbersonly(this,event,'.');"
                                onkeyup="calcular_temProducto_modal();">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="direccion">Valor Unitario</label>
                            <input type="text" class="form-control h-2 w-porc-90" name="tempde_precioUnitario"
                                id="tempde_precioUnitario" value="0.00000"
                                onkeypress="return numbersonly(this,event,'.');" onkeyup="calcular_temProducto_modal()">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="direccion">Subtotal</label>
                            <input type="text" class="form-control h-2 w-porc-90" readonly="readonly"
                                name="tempde_subTotal" id="tempde_subTotal">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="ficha_message"></label>
                            <input type="text" class="form-control h-2 w-porc-90" readonly="readonly"
                                name="ficha_message" id="ficha_message">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="ficha_message">Cargar o actualizar ficha técnica</label>
                            <button type="button" class="h-2 w-porc-90 btn btn-warning" data-toggle="modal"
                                data-target="#modal_ficha" onclick="cerrar_ventana_prodtemporal();">Abrir</button>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3" hidden>
                            <label for="direccion">Descuento <small>(aplica al subtotal)</small></label>
                            <input type="text" class="form-control h-2 w-porc-90" name="tempde_item_descuento"
                                id="tempde_item_descuento">
                        </div>

                    </div>

                    <div class="row form-group">
                        <div class="col-sm-1 col-md-1 col-lg-1"
                            <?=($tipo_docu == "C") ? 'style="display: none"' : "";?>>
                            <div class="">
                                <label for="direccion">ICBPER</label>
                                <input type="hidden" value="false" name="tempde_icbper_hidden">
                                <input class="form-control" id="tempde_icbper" name="tempde_icbper" type="checkbox"
                                    value="1" style="display: none;">
                                <div class="Switch Round On fib" style="vertical-align: center;">
                                    <div class="Toggle"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1"
                            <?=($tipo_docu == "C") ? 'style="display: none"' : "";?>>
                            <div class="form-group">
                                <label for="tempde_icbper_monto">&nbsp;</label>
                                <input class="form-control h-2 w-porc-90" id="tempde_icbper_monto" readonly
                                    name="tempde_icbper_monto" type="text" value="">
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="tempde_tipoIgv">Tipo IGV</label>
                            <select name="tempde_tipoIgv" id="tempde_tipoIgv" class="form-control h-3"
                                onchange="calcular_temProducto_modal();">
                                <?php foreach ($afectaciones as $i => $val) { ?>
                                <option value="<?=$val->AFECT_Codigo?>"><?=$val->AFECT_DescripcionSmall;?></option>
                                <?php } ?>

                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 align-items-end">
                            <label for="telefono">IGV</label>
                            <input type="text" class="form-control h-2 w-porc-90" readonly="readonly"
                                name="tempde_igvLinea" id="tempde_igvLinea" value="0.00000">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 align-items-end">
                            <label for="telefono">TOTAL</label>
                            <input type="text" class="form-control h-2 w-porc-90" onkeyup="calcular_desde_total();"
                                name="tempde_total" id="tempde_total" value="0.00000">
                        </div>

                    </div>
                    <!--ANTICIPOS-->
                    <div class="row form-group anticipos">
                        <hr>
                        <div class="row">
                            <div class="col-sm-11 col-md-11 col-lg-11 tempde_stock" style="text-align:center;"><label>Si
                                    es el <b>PRIMER ANTICIPO</b> dejar estos datos en blanco.<br>Si es una <b>DEDUCCIÓN
                                        DE ANTICIPO</b> el importe de este ITEM o LINEA es el total del pago anticipado
                                    y restará a los totales del documento.</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-md-3 col-lg-4 tempde_stock">
                                <label>¿Deducción de Anticipo?</label>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3 tempde_stock">
                                <label>Serie</label>

                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3 tempde_stock">
                                <label>Número</label>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-md-3 col-lg-4 tempde_stock">
                                <input type="hidden" value="false" name="tempde_anticipo_hidden">
                                <input class="form-control" id="tempde_anticipo" name="tempde_anticipo" type="checkbox"
                                    value="1" style="display: none;">
                                <div class="Switch Round On applyAnticipo" style="vertical-align:top;margin-left:10px;">
                                    <div class="Toggle"></div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3 tempde_stock">
                                <input type="text" readonly name="serie_anticipo" id="serie_anticipo">
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3 tempde_stock">
                                <input type="text" readonly name="numero_anticipo" id="numero_anticipo">
                            </div>
                        </div>
                    </div>
                    <!--FIN ANTICIPOS-->
                </div>
                <div class="row">
                    <div class="col-sm-11 col-md-11 col-lg-11">
                        <span id="tempde_message" style="display: block;"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="tempde_aceptar" onclick="agregar_producto_temporal();"
                        class="btn btn-success" accesskey="x">Aceptar</button>
                    <button type="button" class="btn btn-info" onclick="limpiar_campos_modal()">Limpiar</button>
                    <button type="button" id="tempde_cancelar" class="btn btn-danger"
                        onclick="cerrar_ventana_prodtemporal();">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_ficha" tabindex="-1" role="dialog" aria-labelledby="label_fi"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label_fi"><input id="label_ficha" name="label_ficha" type="text" class="form-control"
				style="width: 70%; color: blue;" readonly></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<form id="form_file">
            <input type="hidden" id="id_p" name="id_p">
            <div class="modal-body">
                <center>
                    <label for="nvo_preciocosto">RUTA ACTUAL</label>
                    <input id="rura_act" name="rura_act" type="text" class="form-control"
                        style="width: 30%; color: green;" readonly>
                    <br>
                    <a><img src="<?php echo base_url()?>/images/pdf_salida.png" width="40px" height="40px"
                            onclick="ver_ficha()"></a>

                </center>
                <br></br>
                    <label for="nvo_preciocosto">ADJUNTAR FICHA TECNICA</label>
                    <label for="nvo_preciocosto" style="color: red;">(El archivo PDF no de debe pesar mas de
                        2MB)</label>
                    <input type="file" id="ficha_file" name="ficha_file" value="0"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target=".bd-example-modal-lg">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="importar_ficha()">Importar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_producto" class="modal fade" role="dialog">
    <div class="modal-dialog w-porc-80">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center">REGISTRAR <?=($flagBS == 'B') ? 'ARTÍCULO' : 'PRODUCTO/SERVICIO';?>
                </h3>
            </div>
            <div class="modal-body panel panel-default">
                <form id="form_nvo" method="POST" action="#">
                    <div class="row form-group header">
                        <div class="col-sm-11 col-md-11 col-lg-11">
                            DETALLES DEL ITEM
                            <input type="hidden" id="id" name="id" />
                        </div>
                    </div>


                    <div class="row form-group font-9">
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <label for="flagB_S">TIPO:</label>
                            <select id="flagB_S" name="flagB_S" class="form-control h-3">
                                <option value="B">Producto</option>
                                <option value="S">Servicio</option>
                            </select>
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <label for="nvo_codigo">CÓDIGO:</label>
                            <input type="text" id="nvo_codigo" name="nvo_codigo" class="form-control h-2 w-porc-90" />
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
                            <input type="text" id="nvo_modelo" name="nvo_modelo" class="form-control h-2 w-porc-90" />
                            <!--
                                LOS DATOS DEL MODELO SON UTILIZADOS EN PRODUCCION, ASI DIFERENCIA ENTRE ARTICULOS E INSUMOS.
                                valor = "ARTICULO" ó "INSUMO"
                            -->
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <label for="nvo_stockMin">STOCK MINIMO:</label>
                            <input type="number" step="1" min="0" id="nvo_stockMin" name="nvo_stockMin" value="0"
                                class="form-control h-2 w-porc-90" />
                        </div>
                    </div>

                    <div class="row form-group font-9">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_unidad">UNIDAD DE MEDIDA:</label>
                            <select id="nvo_unidad[0]" name="nvo_unidad[0]" class="form-control h-3"> <?php
                                foreach ($unidades as $i => $val) { ?>
                                <option value="<?=$val->UNDMED_Codigo?>">
                                    <?="$val->UNDMED_Descripcion | $val->UNDMED_Simbolo";?>
                                </option>
                                <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="nvo_preciocosto">PRECIO COSTO S/:</label>
                            <input type="number" id="nvo_preciocosto" name="nvo_preciocosto" value="0"
                                class="form-control h-2 w-porc-90" />
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

<style type="text/css">
.anticipos {
    display: none;
}

.ui-autocomplete {
    height: 350px;
    overflow-y: scroll;
    overflow-x: hidden;
}

.cajaCabecera input {
    margin-bottom: 1%;
    border: 1px solid #ABA7A6;
    border-radius: 7px;
    height: 30px;
    width: 90%;
}

#tempde_tipoIgv {
    font-size: 12px;
    margin-bottom: 1%;
    border: 1px solid #ABA7A6;
    border-radius: 7px;
    height: 30px;
    width: 100%;
}

#tempde_tipoIgv:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    border-radius: 7px;
    outline: none;
}

.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    border-radius: 7px;
    outline: none;
}

.tempde_stock input {
    margin-bottom: 1%;
    border: 1px solid #ABA7A6;
    border-radius: 7px;
    height: 30px;
    width: 95%;
}

.tempde_stock input:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    border-radius: 7px;
    outline: none;
}

.row {
    margin: auto;
}

.VentasArticulo {
    display: none;
    z-index: 11;
    background: rgba(255, 255, 255, 1);
    position: absolute;
    top: 13em;
    left: 0em;
    right: 0em;
    bottom: 0em;
}

.detallesVentasAnteriores {
    position: absolute;
    display: block;
    background: rgba(255, 255, 255, 1);
    padding: 1em;
    border: thin #000 solid;
    border-radius: 1em;
    top: 1em;
    bottom: 1.5em;
    left: 1em;
    right: 1em;
    overflow: auto;
}

.detallesVentasAnteriores tr {
    background: #D9D9D9;
}

.detallesVentasAnteriores tr:nth-child(2n) {
    background: #FFFFFF;
}

.detallesVentasAnteriores td,
.detallesVentasAnteriores th {
    border-bottom: thin #000 solid;
}

th .detaArticulos {
    font-weight: bold;
    font-size: 10pt;
}

.detaArticulos {
    font-size: 8pt;
    padding: 0.5em;
}

.rowLote {
    display: none;
    position: relative;
    background: #fff;
}

.nvoLote a {
    padding-left: 0em;
    padding-right: 0em;
}

.nvoLote {
    z-index: 3;
    margin-top: 0.5em;
    position: absolute;
    display: block;
    background: #fff;
    padding: 1em;
    border: #bbbbbb thin solid;
    border-radius: 1em;
}

.btn-close {
    z-index: 3;
    position: absolute;
    top: 3em;
    right: 3em;
    cursor: pointer;
    font-size: 10pt;
}

.btn-close:hover {
    font-weight: bold;
}
</style>

<script type="text/javascript">
const isEdit = <?php echo (isset($isEdit) and $isEdit == TRUE) ? 1 : 0 ?>;
$(document).ready(function() {
    var comprobante = "<?=$codigo;?>";
    var tipo_docu = "<?=$tipo_docu;?>";
    var tipo_oper = "<?=$tipo_oper;?>";
    var precioContieneIgv = "<?=( isset($contiene_igv) && $contiene_igv == '1' ) ? 1 : 0;?>";

    var code_bar = $('#tempde_barcode');

    code_bar.keyup(function(e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            if ($(this).val() != '') {
                busqueda_producto_enter();
            }
        }
    });

    if (tipo_oper == 'V')
        $("#linkVerVentasArticulo").css("display", "inline-block");

    if (tipo_docu == 'OV') {
        $(".displayLote").hide();
    }

    listar_familia();
    listar_marca();

    if (comprobante == '') {
        //tipo_afectacion_temproductos();
    } else {
        editar_comprobantes_temproductos(comprobante, tipo_docu);
    }

    $("#tempde_producto").autocomplete({
        source: function(request, response) {

            $("#tempde_message").html('');
            $("#tempde_message").hide();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/autocomplete_producto/" +
                    $("#flagBS").val() + "/" + $("#sucursal").val() + "/" + $("#almacen")
                    .val(),
                type: "POST",
                data: {
                    term: $("#tempde_producto").val(),
                    TipCli: $("#TipCli").val(),
                    familia: $("#tempde_filtro_familia").val(),
                    marca: $("#tempde_filtro_marca").val(),
                    modelo: $("#tempde_filtro_modelo").val(),
                    tipo_oper: tipo_oper,
                    moneda: $("#moneda").val()
                },
                dataType: "json",
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            /**si el producto tiene almacen : es que no esta inventariado en ese almacen , se le asigna el almacen general de cabecera**/
            if (ui.item.almacenProducto == 0) {
                ui.item.almacenProducto = $("#almacen").val();
            }
            console.log(ui.item.codigo);
            //return


            if (ui.item.ficha != '') {
                $("#ficha_message").val("TIENE FICHA TECNICA");
                
            } else {
                $("#ficha_message").val("NO TIENE FICHA TECNICA");
            }

			$("#id_p").val(ui.item.codigo);
			$("#rura_act").val(ui.item.ficha);
			$("#label_ficha").val(ui.item.label);

            /**fin de asignacion**/
            //isEncuentra = verificarProductoTempDetalle(ui.item.codigo,ui.item.almacenProducto);

            // clean data of lotes for add
            $("#tempde_lote").html("");
            $("#tempde_vencimientoLote").val("");

            // if(!isEncuentra){
            $("#bar_code").val(ui.item.codinterno);
            $("#tempde_producto").val(ui.item.value);
            $("#tempde_detalleItem").val(ui.item.descripcion);
            $("#tempde_codproducto").val(ui.item.codigo);
            $("#tempde_moneda").val($("#moneda").val());

            if (tipo_oper == "C") {
                $("#tempde_precioUnitario").val(ui.item.pcosto);
            } else {
                $("#tempde_precioUnitario").val(ui.item.pventa);

            }
            $("#tempde_productocosto").val(ui.item.pcosto);

            $("#tempde_prodStock").val(ui.item.stock);
            if (ui.item.stock <= 0) {
                $("#tempde_prodStock").css('background-color', '#E10C36');
            }

            $("#tempde_lote").html(function() {
                var dlote = ui.item.lote;

                if (dlote != undefined) {
                    size = dlote.length;
                    opciones = '';
                    stockLote = 0;
                    vencimientoLote = '0001-01-01';

                    for (j = 0; j < size; j++) {
                        if (j == 0) {
                            opciones += '<option value="' + dlote[j].LOTP_Codigo +
                                '" selected>' + dlote[j].LOTC_Numero + '</option>';
                            stockLote = dlote[j].ALMALOTC_Cantidad;
                            vencimientoLote = dlote[j].LOTC_FechaVencimiento;
                        } else
                            opciones += '<option value="' + dlote[j].LOTP_Codigo + '">' +
                            dlote[j].LOTC_Numero + '</option>';
                    }
                    $("#tempde_lote").append(opciones);
                    $("#tempde_vencimientoLote").val(vencimientoLote);
                }
            });

            $("#tempde_flagBs").val($("#flagBS").val());
            $("#tempde_flagGenIndnInd").val(ui.item.flagGenInd);
            $("#tempde_almacenproducto").val(ui.item.almacenProducto);
            $("#tempde_unidadmedida").val(ui.item.codunidad);
            $("#tempde_tipoIgv").val(ui.item.tipo_afectacion);
            $("#tempde_filtro_marca").val(ui.item.marca);
            $("#tempde_cantidad").val('1');
            $("#tempde_cantidad").focus();
            calcular_temProducto_modal();
            // }else{
            // 	$("#tempde_producto").val("");
            // 	$("#tempde_detalleItem").val("");
            //     $("#tempde_codproducto").val("");
            //     $("#codproducto").val("");
            //     $("#tempde_precioUnitario").val("");
            //     $("#tempde_productocosto").val("");
            //     $("#tempde_prodStock").val("");
            //     $("#tempde_flagGenIndnInd").val("");
            // 	$("#tempde_lote").html("");
            // 	$("#tempde_vencimientoLote").val("");
            //     $("#tempde_flagBs").val("");
            //    	//$("#nombre_producto").val("");
            //     $("#tempde_almacenproducto").val("");
            //     $("#tempde_unidadmedida").val("");
            //     $("#tempde_filtro_marca").val("");
            //     $("#tempde_filtro_familia").val("");
            // 	//$("#buscar_producto").val("");
            // 	//alert("El producto ya se encuentra ingresado en la lista de detalles.");
            // 	Swal.fire({
            //         icon: "info",
            //         title: "El producto ya se encuentra ingresado en la lista de detalles.",
            //         html: "<b class='color-red'></b>",
            //         showConfirmButton: true,
            //         timer: 2000
            //     });
            // 	return !isEncuentra;
            // }
        },
        minLength: 1
    });

    /* ================= Toggle Switch - Checkbox ================= */
    $(".Switch").click(function() {
        $(this).hasClass("On") ? ($(this).parent().find("input:checkbox").attr("checked", !0), $(this)
            .removeClass("On").addClass("Off")) : ($(this).parent().find("input:checkbox").attr(
            "checked", !1), $(this).removeClass("Off").addClass("On"))
    }), $(".Switch").each(function() {
        $(this).parent().find("input:checkbox").length && ($(this).parent().find("input:checkbox")
            .hasClass("show") || $(this).parent().find("input:checkbox").hide(), $(this).parent()
            .find("input:checkbox").is(":checked") ? $(this).removeClass("On").addClass("Off") : $(
                this).removeClass("Off").addClass("On"))
    });

    $(".applyAnticipo").click(function() {

        if ($("#tempde_anticipo").is(":checked") == true) {
            $("#serie_anticipo").removeAttr("readonly");
            $("#numero_anticipo").removeAttr("readonly");
        } else {
            $("#serie_anticipo").attr("readonly", "readonly");
            $("#numero_anticipo").attr("readonly", "readonly");
        }
    });

    $(".fib").click(function() {
        if ($("#tempde_icbper").is(":checked") == true) {
            cantidad = $("#tempde_cantidad").val()
            total_bolsa = cantidad * monto_bolsa;
            $('#tempde_icbper_monto').val(total_bolsa.toFixed(2));
        } else {
            $('#tempde_icbper_monto').val("");
        }
    });


});

$("#tempde_filtro_marca").change(function() {
    var marca = $('#tempde_filtro_marca').val();
    idMarca = marca.split(' - ');
    listar_modelo(idMarca[0]);
});

$("#linkVerVentasArticulo").click(function() {
    var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/cantidad_ventas_articulo";
    var producto = $("#tempde_codproducto").val();
    var cliente = parent.$("#cliente").val();
    var nombreCliente = parent.$("#nombre_cliente").val();

    $(".detaArticulos").remove();

    if (producto > 0 && cliente > 0) {
        $.ajax({
            url: url,
            type: "POST",
            data: {
                producto: producto,
                cliente: cliente
            },
            dataType: "json",
            error: function(data) {

            },
            success: function(data) {
                if (data != null) {
                    fila = '<tr class="detaArticulos">';
                    fila += '<th width="5%">N°</th>';
                    fila += '<th width="30%">CLIENTE</th>';
                    fila += '<th width="30%">ARTICULO</th>';
                    fila += '<th width="10%">DOCUMENTO</th>';
                    fila += '<th width="10%">SERIE/NÚMERO</th>';
                    fila += '<th width="10%">PU S/IGV</th>';
                    fila += '<th width="10%">PU C/IGV</th>';
                    fila += '</tr>';

                    $.each(data, function(i, item) {
                        nombreArticulo = item.nombreArticulo;
                        documento = item.documento;
                        serie = item.serie;
                        numero = item.numero;
                        precioSigv = item.precioSigv;
                        precioCigv = item.precioCigv;

                        if (documento == 'F')
                            doc = "FACTURA";
                        else
                        if (documento == 'B')
                            doc = "BOLETA";
                        else
                        if (documento == 'N')
                            doc = "COMPROBANTE";

                        n = i + 1;

                        fila += '<tr class="detaArticulos">';
                        fila += '<td>' + n + '</td>';
                        fila += '<td>' + nombreCliente + '</td>';
                        fila += '<td>' + nombreArticulo + '</td>';
                        fila += '<td>' + doc + '</td>';
                        fila += '<td>' + serie + ' - ' + numero + '</td>';
                        fila += '<td>' + precioSigv + '</td>';
                        fila += '<td>' + precioCigv + '</td>';
                        fila += '</tr>';
                    });
                } else {
                    fila = '<tr class="detaArticulos">';
                    fila += '<td colspan="6">SIN VENTAS REGISTRADAS.</td>';
                    fila += '</tr>';
                }
                $("#detallesVentasAnteriores").append(fila);
            }
        });

        url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/cantidad_cotizaciones_articulo";
        $.ajax({
            url: url,
            type: "POST",
            data: {
                producto: producto,
                cliente: cliente
            },
            dataType: "json",
            error: function(data) {

            },
            success: function(data) {
                if (data != null) {
                    fila = '<tr class="detaArticulos">';
                    fila += '<th width="5%">N°</th>';
                    fila += '<th width="30%">CLIENTE</th>';
                    fila += '<th width="30%">ARTICULO</th>';
                    fila += '<th width="10%">DOCUMENTO</th>';
                    fila += '<th width="10%">SERIE/NÚMERO</th>';
                    fila += '<th width="10%">PU S/IGV</th>';
                    fila += '<th width="10%">PU C/IGV</th>';
                    fila += '</tr>';

                    $.each(data, function(i, item) {
                        nombreArticulo = item.nombreArticulo;
                        serie = item.serie;
                        numero = item.numero;
                        precioSigv = item.precioSigv;
                        precioCigv = item.precioCigv;
                        doc = "COTIZACIÓN";

                        n = i + 1;

                        fila += '<tr class="detaArticulos">';
                        fila += '<td>' + n + '</td>';
                        fila += '<td>' + nombreCliente + '</td>';
                        fila += '<td>' + nombreArticulo + '</td>';
                        fila += '<td>' + doc + '</td>';
                        fila += '<td>' + serie + ' - ' + numero + '</td>';
                        fila += '<td>' + precioSigv + '</td>';
                        fila += '<td>' + precioCigv + '</td>';
                        fila += '</tr>';
                    });
                } else {
                    fila = '<tr class="detaArticulos">';
                    fila += '<td colspan="6">SIN COTIZACIONES REGISTRADAS.</td>';
                    fila += '</tr>';
                }
                $("#detallesCotizaciones").append(fila);
            }
        });
        $(".VentasArticulo").show();
    } else {
        //alert('DEBE SELECCIONAR UN CLIENTE Y UN ARTICULO PRIMERO.');
        Swal.fire({
            icon: "info",
            title: "DEBE SELECCIONAR UN CLIENTE Y UN ARTICULO PRIMERO.",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 2000
        });
    }
});

$(".btn-close").click(function() {
    $(".VentasArticulo").hide();
});

$(".btn-cancelLote").click(function() {
    $(".rowLote").hide();
});

$("#tempde_lote").change(function() {
    var tipo_oper = "<?=$tipo_oper;?>";
    idLote = $("#tempde_lote").val();
    producto = $("#tempde_codproducto").val();
    almacen = $("#tempde_almacenproducto").val();

    url = "<?=base_url();?>index.php/almacen/lote/detalles";
    $.ajax({
        url: url,
        type: "POST",
        data: {
            idLote: idLote,
            producto: producto,
            almacen: almacen,
            tipo_oper: tipo_oper
        },
        dataType: "json",
        error: function(data) {},
        success: function(data) {
            $("#tempde_lote").html('');
            if (data != null) {
                $("#tempde_lote").html(function() {
                    var dlote = data;
                    size = dlote.length;
                    opciones = '';
                    stockLote = 0;
                    vencimientoLote = '0001-01-01';

                    for (j = 0; j < size; j++) {
                        if (dlote[j].LOTP_Codigo == idLote) {
                            opciones += '<option value="' + dlote[j].LOTP_Codigo +
                                '" selected>' + dlote[j].LOTC_Numero + '</option>';
                            stockLote = dlote[j].ALMALOTC_Cantidad;
                            vencimientoLote = dlote[j].LOTC_FechaVencimiento;
                        } else
                            opciones += '<option value="' + dlote[j].LOTP_Codigo + '">' +
                            dlote[j].LOTC_Numero + '</option>';
                    }
                    $("#tempde_lote").append(opciones);
                    $("#tempde_vencimientoLote").val(vencimientoLote);
                });
            }
        }
    });
});

$(".addLote").click(function() {
    producto = $("#tempde_codproducto").val();
    if (producto > 0) {
        $(".rowLote").show();
    } else {
        //alert('Debe seleccionar un producto para continuar.');
        Swal.fire({
            icon: "info",
            title: "Debe seleccionar un producto para continuar.",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 2000
        });
    }
});

$(".btn-nvoLote").click(function() {
    var producto = $("#tempde_codproducto").val();
    var infoNumeroLote = $("#infoNumeroLote").val();
    var infoVencimientoLote = $("#infoVencimientoLote").val();

    var url = "<?php echo base_url(); ?>index.php/almacen/lote/nuevo_lote/";

    if (producto > 0) {
        $.ajax({
            url: url,
            type: "POST",
            data: {
                producto: producto,
                numeroLote: infoNumeroLote,
                vencimientoLote: infoVencimientoLote
            },
            dataType: "json",
            error: function(data) {},
            success: function(data) {
                $.each(data, function(i, item) {
                    if (item.result == "success") {
                        $("#tempde_lote").html("");
                        $("#tempde_lote").html(function() {
                            var dlote = item.lote;
                            size = dlote.length;
                            opciones = '';
                            stockLote = 0;
                            vencimientoLote = '0001-01-01';

                            console.log(dlote);

                            for (j = 0; j < size; j++) {
                                if (j == 0) {
                                    opciones += '<option value="' + dlote[j]
                                        .LOTP_Codigo + '" selected>' + dlote[j]
                                        .LOTC_Numero + '</option>';
                                    stockLote = dlote[j].ALMALOTC_Cantidad;
                                    vencimientoLote = dlote[j]
                                    .LOTC_FechaVencimiento;
                                } else
                                    opciones += '<option value="' + dlote[j]
                                    .LOTP_Codigo + '">' + dlote[j].LOTC_Numero +
                                    '</option>';
                            }
                            $("#tempde_lote").append(opciones);
                            $("#tempde_vencimientoLote").val(vencimientoLote);
                        });
                    } else {
                        alert(item.mensaje);
                    }
                });
            }
        });
        $(".rowLote").hide();
    }
});

function flagBolsa(flag) {
    if (flag == 0) {
        if ($("#tempde_icbper").is(":checked") == true) {
            $(".fib").click();
            cantidad = $("#tempde_cantidad").val()
            total_bolsa = cantidad * monto_bolsa;
            $('#tempde_icbper_monto').val(total_bolsa.toFixed(2));
        }
    } else
    if (flag == 1) {
        if ($("#tempde_icbper").is(":checked") == false) {
            $(".fib").click();
            $("#tempde_icbper_monto").val();
        }
    }
}

//Anticipos
function flagAnticipo(flag) {
    if (flag == 0) {
        if ($("#tempde_anticipo").is(":checked") == true)
            $(".applyAnticipo").click();

    } else
    if (flag == 1) {
        if ($("#tempde_anticipo").is(":checked") == false)
            $(".applyAnticipo").click();
    }
}
//fin anticipos

function agregar_producto_temporal() {
    if (cantArtIngresados() >= <?=VENTAS_FACTURA;?>) {
        $("#tempde_message").text('Limite de articulos permitidos alcanzado.');
        $("#tempde_message").show();
        return false;
    }

    flagBS = $("#flagBS").val();

    if ($("#tempde_codproducto").val() == '') {
        $("#tempde_codproducto").focus();
        //alert('Ingrese el producto.');
        Swal.fire({
            icon: "info",
            title: "Ingrese el producto.",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 1500
        });
        return false;
    }

    if ($("#tempde_cantidad").val() == '') {
        $("#tempde_cantidad").focus();
        //alert('Ingrese una cantidad.');
        Swal.fire({
            icon: "info",
            title: "Ingrese una cantidad.",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 1500
        });
        return false;
    }

    if ($("#tempde_precioUnitario").val() == '') {
        $("#tempde_precioUnitario").focus();
        //alert('Ingrese precio');
        Swal.fire({
            icon: "info",
            title: "Ingrese precio",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 1500
        });
        return false;
    }

    if ($("#showDetails").is(":checked") == true && $("#tempde_detalleItem").val() == "") {
        Swal.fire({
            icon: "warning",
            title: "Por favor, ingrese la nueva descripcion y codigo del producto",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 2000
        });
        return false;
    }

    stock = parseFloat($("#tempde_prodStock").val());
    costo = parseFloat($("#tempde_productocosto").val());
    precio = parseFloat($("#tempde_precioUnitario").val());

    let showDetails = ($('#showDetails').is(':checked') == true) ? '2' : '1';

    var tipo_oper = "<?=$tipo_oper;?>";
    var tipo_docu = "<?=$tipo_docu;?>";
    if (tipo_oper == "V" && tipo_docu != "C" && tipo_docu != "D")
        costoMinimo = 0;
    else
        costoMinimo = 0;

    //SOLO DEBE COMPARAR PRECIOS SI ES VENTA Y NO ES NOTA DE CREDITO 
    if (tipo_docu != 'C' && tipo_oper == 'V') {
        if (costoMinimo > precio) {
            $("#tempde_precioUnitario").focus();
            //alert('El precio de venta minimo para este articulo debe ser de: ' + costoMinimo);
            Swal.fire({
                icon: "info",
                title: "El precio de venta minimo para este articulo debe ser de: " + costoMinimo,
                html: "<b class='color-red'>El precio debe ser superior</b>",
                showConfirmButton: true
            });
            $("#tempde_precioUnitario").val(costoMinimo);
            calcular_temProducto_modal();
            return false;
        }
    }

    codproducto = $("#tempde_codproducto").val();
    producto = $("#tempde_codproducto").val();
    idLote = $("#tempde_lote").val();
    vencimientoLote = $("#tempde_vencimientoLote").val();
    nombre_producto = $("#tempde_producto").val();

    /*
	    var marca = $('#tempde_filtro_marca').val();
			var marcaInfo = marca.split(' - ');
	    nombre_marca = marcaInfo[0];*/

    if ($("#tempde_detalleItem").val() != '')
        observ_producto = $("#tempde_detalleItem").val();
    else
        observ_producto = "";

    numeroLote = "<br> <b>N° de lote:</b> " + $("#tempde_lote option:selected").text() +
        ". <b>Fecha de vencimiento:</b> " + vencimientoLote;
    if (tipo_docu == 'OV') {
        nombre_producto_span = nombre_producto + " | " + observ_producto;
    } else if (observ_producto == "") {
        nombre_producto_span = nombre_producto;
    } else {
        nombre_producto_span = nombre_producto + " | " + observ_producto; // + " " + numeroLote;
    }

    descuento = $("#descuento").val();
    igv = parseFloat($("#igv").val());
    if (igv == null || igv == undefined) {
        igv = 18;
    }
    if (descuento == null || descuento == undefined) {
        descuento = 0;
    }
    cantidad = $("#tempde_cantidad").val();
    almacenProducto = $("#tempde_almacenproducto").val();

    if (cantidad == 0 || cantidad < 0) {

        Swal.fire({
            icon: "info",
            title: "La cantidad debe ser mayor que 0",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 1500
        });
        $("#tempde_cantidad").focus();
        return false;
    }

    if (tipo_docu != 'C' && tipo_oper == 'V' && tipo_docu != 'GRC') {
        if (precio == 0 || precio < 0) {
            Swal.fire({
                icon: "info",
                title: "El precio debe ser mayor que 0",
                html: "<b class='color-red'></b>",
                showConfirmButton: true,
                timer: 1500
            });
            $("#tempde_precioUnitario").focus();
            return false;
        }
    }

    var tipoIgv = $("#tempde_tipoIgv").val();
    if (tipoIgv == '1') {

        var contieneIgv = "<?=( isset($contiene_igv) && $contiene_igv == '1' ) ? 1 : 0;?>";
        var igv100 = $("#igv").val();
        if (contieneIgv == 0)
            precio = parseFloat(precio) + (parseFloat(precio) * parseFloat(igv100) / 100);

        precio_conigv = parseFloat(precio);
        precio_sinigv = parseFloat(precio) / (1 + (igv / 100));
        precio_igv = (precio_conigv - precio_sinigv) * cantidad; //precio_conigv*(igv/100);
        subTotal = precio_sinigv * cantidad;
        //importe_total = precio_conigv*cantidad;
    } else {
        precio_conigv = precio; //(precio*(100+igv)/100);
        precio_sinigv = precio;
        precio_igv = 0;
        subTotal = precio_sinigv * cantidad;
        //importe_total = precio_sinigv;
    }

    importe_total = precio_conigv * cantidad;
    prodprecio = precio_sinigv * cantidad;


    unidad_medida = '';
    nombre_unidad = '';
    if (flagBS == 'B') {
        unidad_medida = $("#tempde_unidadmedida").val();
        //nombre_unidad = $('#unidad_medida option:selected').html()
    }

    flagGenInd = $("#tempde_flagGenInd").val();
    n = document.getElementById('tempde_tblbody').rows.length;
    //PARA NO INGRESAR PRODUCTOS REPETIDOS
    // for (var i = 0; i < n; i++) {
    // 	PROD_Codigo = "prodcodigo[" + i + "]";
    // 	accion = "detaccion[" + i + "]";

    // 	productiviris = document.getElementById(PROD_Codigo).value;
    // 	detaccion = document.getElementById(accion).value;

    // 	if (producto == productiviris && detaccion!="e") {

    //         return false;
    // 	}

    // }
    //var limit = getLimite();
    /*
    if (n >= limit) {

        alert('Limite del detalle de Documento');
        return false
    }
    */
    j = n + 1;
    if (j % 2 == 0) {
        clase = "itemParTabla";
    } else {
        clase = "itemImparTabla";
    }

    if ($("#tempde_icbper").is(":checked") == false)
        icbper = 0;
    else
        icbper = 1;

    if ($("#tempde_anticipo").is(":checked") == false) {
        anticipo = 0;
    } else {
        serie_anticipo = $("#serie_anticipo").val();
        numero_anticipo = $("#numero_anticipo").val();
        anticipo = 1;
    }

    if (anticipo == 1) {
        if (serie_anticipo == "" || numero_anticipo == "") {

            Swal.fire({
                icon: "info",
                title: "Debe agregar numero y serie del documento relacionado",
                html: "<b class='color-red'></b>",
                showConfirmButton: true,
                timer: 1500
            });
            $("#serie_anticipo").focus();
            return false;
        }
    }

    fila = '<tr id="' + n + '" class="' + clase + '" >';
    fila += '<td width="5%"><div align="center">' + j + '</div></td>';

    fila += "<td width='35%'><div align='left'><input type='hidden' name='proddescri[" + n + "]' id='proddescri[" + n +
        "]' value='" + nombre_producto + "'/><span id='proddescri_span[" + n + "]'>" + nombre_producto_span + "</span>";
    fila += '</div></td>';



    fila += '<td width="10%"><div style="text-align:center;">';
    fila += '<input type="hidden" name="pendiente[' + n + ']" id="pendiente[' + n + ']" value="' + cantidad + '">';
    fila += '<input type="hidden" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad +
        '"><span id="prodcantidad_span[' + n + ']"> ' + parseFloat(cantidad).toFixed(2) + '</span>';
    fila += '</div></td>';

    fila += '<td width="10%"><div style="text-align:center;"><span id="prod_precio_span_sigv[' + n + ']">' + parseFloat(
        precio_sinigv).toFixed(2) + '</span></div></td>';

    fila += '<td width="10%"><div style="text-align:center;"><span id="prod_precio_span[' + n + ']">' + parseFloat(
        precio_conigv).toFixed(2) + '</span></div></td>';

    fila +=
        '<td width="10%"><div style="text-align:center;"><input type="hidden" size="5" style="text-align: right;" name="prodimporte[' +
        n + ']" id="prodimporte[' + n + ']" value="' + importe_total + '" ><span id="prodimporte_span[' + n + ']">' +
        parseFloat(importe_total).toFixed(2) + '</span></div></td>';

    fila +=
        '<td width="5%"><div style="text-align:center;"><a href="#" data-toggle="modal" data-target=".bd-example-modal-lg"  onclick="editar_producto_temporal(' +
        n + ');"><img src="' + base_url +
        'images/edit.png?=<?=IMG;?>" width="20" height="20"  border="0" tittle="editar"></a>';
    fila += '<td width="5%"><div style="text-align:center;"><a href="#" onclick="eliminar_producto_temporal(' + n +
        ');"><img src="' + base_url +
        'images/delete.png?=<?=IMG;?>" width="20" height="20"  border="0" tittle="eliminar"></a>';


    fila +=
        '<td width="6%" style="display:none;"><div align="center"><input style="text-align: right;" type="text" size="5" maxlength="10" class="cajaGeneral" value="' +
        precio_sinigv + '" name="prodpu[' + n + ']" id="prodpu[' + n + ']" value="0"></div></td>';
    fila +=
        '<td width="6%" style="display:none;"><div align="center"><input type="text" size="5" style="text-align: right;" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio[' +
        n + ']" id="prodprecio[' + n + ']" value="' + prodprecio + '" readonly="readonly">';

    fila +=
        '<td width="6%" style="display:none;" ><div align="center"><input type="text" style="text-align: right;" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[' +
        n + ']" id="prodigv[' + n + ']" value="' + precio_igv + '" readonly="readonly"></div></td>';
    fila += '<td width="6%" style="display:none;" ><div align="center">';
    fila += '<input type="hidden" value="n" name="detaccion[' + n + ']" id="detaccion[' + n + ']">';
    fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv + '">';
    fila += '<input type="hidden" value="" name="detacodi[' + n + ']" id="detacodi[' + n + ']">';
    fila += '<input type="hidden" name="proddescuento100[' + n + ']" id="proddescuento100[' + n + ']" value="' +
        descuento + '">';
    fila += '<input type="hidden" name="showDetails[' + n + ']" id="showDetails[' + n + ']" value="' + showDetails +
        '">';

    fila += '<input type="hidden" name="tafectacion[' + n + ']" id="tafectacion[' + n + ']" value="' + tipoIgv + '"/>';
    fila += '<input type="hidden" name="idLote[' + n + ']" id="idLote[' + n + ']" value="' + idLote + '"/>';
    fila += '<input type="hidden" name="icbper[' + n + ']" id="icbper[' + n + ']" value="' + icbper + '"/>';
    fila += '<input type="hidden" name="proddescuento[' + n + ']" id="proddescuento[' + n + ']"  />';
    fila += '<input type="hidden" name="flagBS[' + n + ']" id="flagBS[' + n + ']" value="' + flagBS + '"/>';
    fila += '<input type="hidden" name="prodobservacion[' + n + ']" id="prodobservacion[' + n + ']" value="' +
        observ_producto + '"/>';
    fila += '<input type="hidden" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' + producto + '"/>';
    fila += '<input type="hidden" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' + unidad_medida +
        '"/>';
    fila += '<input type="hidden" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' + flagGenInd +
        '"/>';
    fila += '<input type="hidden" name="prodstock[' + n + ']" id="prodstock[' + n + ']" value="' + stock + '"/>';
    fila += '<input type="hidden" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo + '"/>';
    fila += '<input type="hidden" name="almacenProducto[' + n + ']" id="almacenProducto[' + n + ']" value="' +
        almacenProducto + '"/>';
    fila += '<input type="hidden" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" value="' +
        precio_conigv + '" /> '
    fila += '<input type="hidden" name="modalAccion[' + n + ']" id="modalAccion[' + n + ']" value="n"/>'
    fila += '<input type="hidden" name="oventacod[' + n + ']" id="oventacod[' + n + ']" value="0">'

    //ANTICIPOS
    fila += '<input type="hidden" name="anticipo[' + n + ']" id="anticipo[' + n + ']" value="' + anticipo + '"/>';
    fila += '<input type="hidden" name="serie_anticipo[' + n + ']" id="serie_anticipo[' + n + ']" value="' +
        serie_anticipo + '"/>';
    fila += '<input type="hidden" name="numero_anticipo[' + n + ']" id="numero_anticipo[' + n + ']" value="' +
        numero_anticipo + '"/>';




    /*if (verificarProductoTempDetalle(codprod,almprod)) {
	   		$("#tempde_message").css('color', 'red');
			$("#tempde_message").html('Este producto ya fue agregado');
			$("#tempde_message").show();
	   		return false;
	   	}else{*/


    regitrar_prodtemporal()
        .then((result) => {
            let tempdeId = result;

            fila += "<td width='35%' hidden><div align='left'><input type='hidden' name='tempdeId[" + n +
                "]' id='tempdeId[" + n + "]' value='" + tempdeId + "'/><span id='tempdeId[" + n + "]'>" + tempdeId +
                "</span>";

            fila += '</div></td>';
            fila += '</tr>';

            var codprod = $("#tempde_codproducto").val();
            var almprod = $("#tempde_almacenproducto").val();

            $("#tempde_tblbody").append(fila);
            calcular_totales_tempdetalle();

        })



    /*}*/
}

function agregar_productotemp_modificado(fila) {
    flagBS = $("#flagBS").val();

    if ($("#tempde_codproducto").val() == '') {
        $("#tempde_codproducto").focus();
        //alert('Ingrese el producto.');
        Swal.fire({
            icon: "info",
            title: "Ingrese el producto.",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 2000
        });
        return false;
    }
    if ($("#tempde_cantidad").val() == '') {
        $("#tempde_cantidad").focus();
        //alert('Ingrese una cantidad.');
        Swal.fire({
            icon: "info",
            title: "Ingrese una cantidad.",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 2000
        });
        return false;
    }
    if ($("#tempde_precioUnitario").val() == '') {
        $("#tempde_precioUnitario").focus();
        //alert('Ingrese precio');
        Swal.fire({
            icon: "info",
            title: "Ingrese precio",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 2000
        });
        return false;
    }

    if ($("#showDetails").is(":checked") == true && $("#tempde_detalleItem").val() == "") {
        Swal.fire({
            icon: "warning",
            title: "Por favor, ingrese la nueva descripcion y codigo del producto",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 2000
        });
        return false;
    }

    stock = parseFloat($("#tempde_prodStock").val());
    costo = parseFloat($("#tempde_productocosto").val());
    precio = parseFloat($("#tempde_precioUnitario").val());

    let showDetails = ($('#showDetails').is(':checked') == true) ? '2' : '1';

    //##################################################
    //#### LIMITAR EL PRECIO VENTA AL 15% MAS DEL COSTO
    //##################################################
    var tipo_oper = "<?=$tipo_oper;?>";
    var tipo_docu = "<?=$tipo_docu;?>";
    if (tipo_oper == "V" && tipo_docu != "C" && tipo_docu != "D")
        costoMinimo = 0; //costo; // + ((costo * 0.15) );
    else
        costoMinimo = 0;

    if (tipo_docu != 'C' && tipo_oper == 'V') {
        if (costoMinimo > precio) {
            $("#tempde_precioUnitario").focus();
            //alert('El precio de venta minimo para este articulo debe ser de: ' + costoMinimo);
            Swal.fire({
                icon: "info",
                title: "El precio de venta minimo para este articulo debe ser de: " + costoMinimo,
                html: "<b class='color-red'>El precio debe ser superior</b>",
                showConfirmButton: true
            });
            $("#tempde_precioUnitario").val(costoMinimo);
            calcular_temProducto_modal();
            return false;
        }
    }

    codproducto = $("#tempde_codproducto").val();
    idLote = $("#tempde_lote").val();
    vencimientoLote = $("#tempde_vencimientoLote").val();
    producto = $("#tempde_codproducto").val();
    nombre_producto = $("#tempde_producto").val();

    if ($("#tempde_detalleItem").val() != '')
        observ_producto = $("#tempde_detalleItem").val();
    else
        observ_producto = "";

    numeroLote = "<br> <b>N° de lote:</b> " + $("#tempde_lote option:selected").text() +
        ". <b>Fecha de vencimiento:</b> " + vencimientoLote;

    /*var marca = $('#tempde_filtro_marca').val();
			var marcaInfo = marca.split(' - ');
	    nombre_marca = marcaInfo[0];*/

    if (tipo_docu == 'OV') {
        nombre_producto_span = nombre_producto + " | " + observ_producto;
    } else if (observ_producto == "") {
        nombre_producto_span = nombre_producto;
    } else {
        nombre_producto_span = nombre_producto + " | " + observ_producto; // + " " + numeroLote;
    }

    igv_linea = $("#tempde_igvLinea").val();
    descuento = $("#descuento").val();
    igv = parseFloat($("#igv").val());
    if (igv == null || igv == undefined) {
        igv = 18;
    }
    if (descuento == null || descuento == undefined) {
        descuento = 0;
    }
    cantidad = $("#tempde_cantidad").val();
    almacenProducto = $("#tempde_almacenproducto").val();

    if (cantidad == 0 || cantidad < 0) {
        //alert('La cantidad debe ser mayor que 0');
        Swal.fire({
            icon: "info",
            title: "La cantidad debe ser mayor que 0",
            html: "<b class='color-red'></b>",
            showConfirmButton: true,
            timer: 2000
        });
        $("#tempde_cantidad").focus();
        return false;
    }

    /*if (cantidad > stockLote) {
    	alert('La cantidad ingresada supera el stock del Lote');
    	$("#tempde_cantidad").focus();
    	return false;
    }*/
    // if(tipo_docu!='C' && tipo_oper=='V'){
    //     if (precio == 0 || precio < 0) {
    //     	Swal.fire({
    //             icon: "info",
    //             title: "El precio debe ser mayor que 0",
    //             html: "<b class='color-red'></b>",
    //             showConfirmButton: true,
    //             timer: 2000
    //         });
    //     	$("#tempde_precioUnitario").focus();
    //     	return false;
    //     }
    // }
    precio_sinigv = "";

    var tipoIgv = $("#tempde_tipoIgv").val();
    if (tipoIgv == '1') {

        var contieneIgv = "<?=( isset($contiene_igv) && $contiene_igv == '1' ) ? 1 : 0;?>";
        var igv100 = $("#igv").val();
        if (contieneIgv == 0)
            precio = parseFloat(precio) + (parseFloat(precio) * parseFloat(igv100) / 100);

        precio_conigv = precio;
        precio_sinigv = (precio / (1 + (igv / 100)));
        precio_igv = (precio_conigv - precio_sinigv) * cantidad; //precio_conigv*(igv/100);
        subTotal = precio_sinigv * cantidad;
        //importe_total = precio_conigv*cantidad;
    } else {
        precio_conigv = precio; //(precio*(100+igv)/100);
        precio_sinigv = precio;
        precio_igv = 0; //precio_conigv*(igv/100);
        subTotal = precio_sinigv * cantidad;
        //importe_total = precio_sinigv;
    }

    importe_total = precio_conigv * cantidad;
    prodprecio = precio_sinigv * cantidad;

    unidad_medida = '';
    nombre_unidad = '';
    if (flagBS == 'B') {
        unidad_medida = $("#tempde_unidadmedida").val();
        //nombre_unidad = $('#unidad_medida option:selected').html()
    }

    flagGenInd = $("#tempde_flagGenInd").val();

    if ($("#tempde_icbper").is(":checked") == false)
        icbper = 0;
    else
        icbper = 1;

    if ($("#tempde_anticipo").is(":checked") == false) {
        anticipo = 0;
    } else {
        serie_anticipo = $("#serie_anticipo").val();
        numero_anticipo = $("#numero_anticipo").val();
        anticipo = 1;
    }

    if (anticipo == 1) {
        if (serie_anticipo == "" || numero_anticipo == "") {

            Swal.fire({
                icon: "info",
                title: "Debe agregar numero y serie del documento relacionado",
                html: "<b class='color-red'></b>",
                showConfirmButton: true,
                timer: 1500
            });
            $("#serie_anticipo").focus();
            return false;
        }
    }

    /*id's de todos los campos*/
    a = "proddescri[" + fila + "]";
    aa = "proddescri_span[" + fila + "]";
    b = "prodcantidad[" + fila + "]";
    bb = "prodcantidad_span[" + fila + "]";
    ccs = "prod_precio_span_sigv[" + fila + "]";
    cc = "prod_precio_span[" + fila + "]";
    d = "prodimporte[" + fila + "]";
    dd = "prodimporte_span[" + fila + "]";
    e = "prodigv100[" + fila + "]";
    f = "detacodi[" + fila + "]";
    g = "proddescuento100[" + fila + "]";
    h = "flagBS[" + fila + "]";
    i = "prodobservacion[" + fila + "]";
    j = "prodcodigo[" + fila + "]";
    k = "produnidad[" + fila + "]";
    l = "flagGenIndDet[" + fila + "]";
    m = "prodstock[" + fila + "]";
    n = "prodcosto[" + fila + "]";
    o = "almacenProducto[" + fila + "]";
    q = "pendiente[" + fila + "]";
    r = "prodprecio[" + fila + "]";
    s = "prodpu_conigv[" + fila + "]";
    t = "tafectacion[" + fila + "]";
    u = "idLote[" + fila + "]";
    p = "prodigv[" + fila + "]";
    z = "prodpu[" + fila + "]";
    ib = "icbper[" + fila + "]";

    an = "anticipo[" + fila + "]";
    san = "serie_anticipo[" + fila + "]";
    nan = "numero_anticipo[" + fila + "]";

    showProductDetails = "showDetails[" + fila + "]";

    modificar_prodtemporal();

    document.getElementById(a).value = nombre_producto;
    document.getElementById(aa).innerHTML = nombre_producto_span;
    document.getElementById(b).value = cantidad;
    document.getElementById(bb).innerText = parseFloat(cantidad).toFixed(2);
    document.getElementById(ccs).innerText = parseFloat(precio_sinigv).toFixed(2);
    document.getElementById(cc).innerText = parseFloat(precio_conigv).toFixed(2);
    document.getElementById(d).value = importe_total;
    document.getElementById(dd).innerText = parseFloat(importe_total).toFixed(2);
    document.getElementById(e).value = igv;
    document.getElementById(g).value = descuento;
    document.getElementById(p).value = igv_linea;
    document.getElementById(z).value = precio_sinigv;
    document.getElementById(h).value = flagBS;
    document.getElementById(i).value = observ_producto;
    document.getElementById(j).value = codproducto;
    document.getElementById(k).value = unidad_medida;
    document.getElementById(m).value = stock;
    document.getElementById(n).value = costo;
    document.getElementById(o).value = almacenProducto;
    document.getElementById(q).value = cantidad;
    document.getElementById(r).value = prodprecio;
    document.getElementById(s).value = precio_conigv;
    document.getElementById(t).value = tipoIgv;
    document.getElementById(ib).value = icbper;

    document.getElementById(an).value = anticipo;
    document.getElementById(san).value = serie_anticipo;
    document.getElementById(nan).value = numero_anticipo;

    document.getElementById(showProductDetails).value = showDetails;

    if (tipo_docu != 'C' && tipo_docu != 'D')
        document.getElementById(u).value = idLote;

    calcular_totales_tempdetalle();
}

function regitrar_prodtemporal() {
    var url = "<?=base_url();?>index.php/maestros/temporaldetalle/registrar_prodtemporal";
    dataString = $("#form_tempdetalle").serialize();
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: url,
            data: dataString,
            type: 'POST',
            dataType: 'json',
            error: function(data) {
                alert('ocurrio un problema');
            },
            success: function(data) {
                if (data.status == 200) {
                    $("#tempde_message").css('color', '#232D7E');
                    $("#tempde_message").html(
                        "se registro correctamente. Cantidad de articulos ingresados " +
                        cantArtIngresados() + " de <?=VENTAS_FACTURA;?>");
                    $("#tempde_prodStock").val("");
                    $("#tempde_prodStock").css("background-color", "#ffffff");
                    $("#tempde_message").show();
                    limpiar_campos_modal();
                    resolve(data.tempdeId);
                } else {
                    alert("intentelo nuevamente.");
                }
            }
        })
    });

}

function cantArtIngresados() {
    cantidad = 0;
    $('#tempde_tblbody tr').each(function() {
        if ($(this).css("display") != 'none') {
            cantidad++;
        }
    });
    return cantidad;
}

function modificar_prodtemporal() {
    var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/modificar_prodtemporal";
    dataString = $("#form_tempdetalle").serialize();

    $.ajax({
        url: url,
        data: dataString,
        type: 'POST',
        dataType: 'json',
        error: function(data) {
            alert('ocurrio un problema');
        },
        success: function(data) {
            if (data == "1") {
                $("#tempde_message").css('color', '#232D7E');
                $("#tempde_message").html('se modifico correctamente');
                $("#tempde_prodStock").val("");
                $("#tempde_prodStock").css("background-color", "#ffffff");
                $("#tempde_message").show();

                $("#tempde_aceptar").attr("onclick", "agregar_producto_temporal()");
                //$("#tempde_aceptar").attr("onclick","agregar_productotemp_modificado("+fila+")");
                limpiar_campos_modal();

            } else {
                alert("No se pudo modificar los datos");
                return false;
            }
        }
    });
}

function editar_producto_temporal(fila) {
    limpiar_campos_modal();
    var t = "tempdeId[" + fila + "]";
    var d = "detacodi[" + fila + "]";
    var p = "prodcodigo[" + fila + "]";
    var a = "almacenProducto[" + fila + "]";
    var s = "prodstock[" + fila + "]";
    var m = "modalAccion[" + fila + "]";
    var e = "detaccion[" + fila + "]";
    var l = "idLote[" + fila + "]";

    tempdeId = document.getElementById(t).value;
    detalleId = document.getElementById(d).value;
    codProducto = document.getElementById(p).value;
    almacen = document.getElementById(a).value;
    stock = document.getElementById(s).value;
    idLote = document.getElementById(l).value;

    var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/obtener_producto_temporal";
    if (detalleId == '') {
        document.getElementById(m).value = 'm';
    } else {
        document.getElementById(m).value = 'm';
        document.getElementById(e).value = 'm';
    }
    //$("#tempde_aceptar").attr("onclick","agregar_producto_temporal()");
    $("#tempde_aceptar").attr("onclick", "agregar_productotemp_modificado(" + fila + ")");
    var tempSession = $("#tempSession").val();
    $.ajax({
        url: url,
        data: {
            tempdeId: tempdeId,
            detalleId: detalleId,
            codproducto: codProducto,
            tempSession: tempSession,
            idLote: idLote
        },
        type: "POST",
        dataType: "json",
        success: function(data) {
            $.each(data.datos, function(i, item) {
                $("#bar_code").val(item.codigo_usuario);
                $("#tempde_id").val(item.TEMPDE_Codigo);
                $("#tempde_codproducto").val(item.PROD_Codigo);
                $("#tempde_almacenproducto").val(almacen);
                $("#tempde_unidadmedida").val(item.UNDMED_Codigo);
                $("#tempde_moneda").val(item.MONED_Codigo);
                $("#tempde_descuento").val(item.TEMPDE_Descuento);
                $("#tempde_igvLinea").val(item.TEMPDE_Igv);
                $("#tempde_filtro_marca").val(' - ' + item.marca);
                $("#tempde_producto").val(item.TEMPDE_Descripcion);
                // $("#tempde_producto").attr('readonly','readonly');
                $("#tempde_detalleItem").val(item.TEMPDE_Observacion);
                $("#tempde_prodStock").val(item.stock);
                $("#tempde_productocosto").val(item.TEMPDE_Costo);
                $("#tempde_cantidad").val(item.TEMPDE_Cantidad);
                $("#tempde_precioUnitario ").val(item.TEMPDE_Precio);
                $("#tempde_subTotal").val(item.TEMPDE_Subtotal);
                //tipo_afectacion_temproductos(item.TEMPDE_TipoIgv);
                $("#tempde_tipoIgv").val(item.TEMPDE_TipoIgv);
                $("#tempde_total").val(item.TEMPDE_Total);

                $("#serie_anticipo").val(item.TEMPDE_AntSerie);
                $("#numero_anticipo").val(item.TEMPDE_AntNumero);

                if (item.show_details == '2') {
                    $("#showDetails").prop('checked', true);
                } else {
                    $("#showDetails").prop('checked', false);
                }


                lotes(item.PROD_Codigo, almacen, idLote);
                flagBolsa(item.TEMPDE_ICBPER);
                flagAnticipo(item.TEMPDE_Anticipo);
            });
        }
    })
}

function eliminar_producto_temporal(fila) {
    if (confirm('Esta seguro de eliminar este producto?')) {
        var d = "detacodi[" + fila + "]";
        var p = "prodcodigo[" + fila + "]";
        var a = "almacenProducto[" + fila + "]";
        var s = "prodstock[" + fila + "]";
        var m = "modalAccion[" + fila + "]";
        var e = "detaccion[" + fila + "]";
        detalleId = document.getElementById(d).value;
        codProducto = document.getElementById(p).value;
        almacen = document.getElementById(a).value;
        stock = document.getElementById(s).value;
        var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/eliminar_producto_temporal";
        document.getElementById(m).value = 'e';
        document.getElementById(e).value = 'e';
        var tempSession = $("#tempSession").val();
        $.ajax({
            url: url,
            data: {
                codproducto: codProducto,
                tempSession: tempSession
            },
            type: "POST",
            success: function(data) {
                if (data == "1") {
                    $("#" + fila).css('display', 'none');
                    $("#tempde_message").css('color', '#232D7E');
                    $("#tempde_message").html('se elimino correctamente');
                    $("#tempde_prodStock").val("");
                    $("#tempde_prodStock").css("background-color", "#ffffff");
                    $("#tempde_message").show();

                    $("#tempde_aceptar").attr("onclick", "agregar_producto_temporal()");
                    //$("#tempde_aceptar").attr("onclick","agregar_productotemp_modificado("+fila+")");
                    limpiar_campos_modal();
                    calcular_totales_tempdetalle();
                }
            }
        });
    }
    return false;
}

function verificarProductoTempDetalle(codigoProducto, codigoAlmacen) {
    n = document.getElementById('tempde_tbl').rows.length;
    isEncuentra = false;
    if (n != 0) {
        for (x = 0; x < n; x++) {
            d = "detaccion[" + x + "]";
            accionDetalle = document.getElementById(d).value;
            if (accionDetalle != "e") {
                /***verificamos si existe el mismo producto y no lo agregamos**/
                a = "almacenProducto[" + x + "]";
                c = "prodcodigo[" + x + "]";
                almacenProducto = document.getElementById(a).value;
                codProducto = document.getElementById(c).value;
                if (codProducto == codigoProducto && almacenProducto == codigoAlmacen) {
                    isEncuentra = true;
                    break;
                }
            }
        }
    }
    return isEncuentra;
}

function tipo_afectacion_temproductos(id = '') {
    var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/tipo_afectacion_temproductos";
    $.ajax({
        url: url,
        type: "POST",
        data: {
            codafectacion: id
        },
        dataType: "json",
        success: function(data) {
            $("#tempde_tipoIgv").html(data.option);
            if (data.selected != '') {
                $("#tempde_tipoIgv").val(data.selected);
            } else {
                $("#tempde_tipoIgv").val(1);
            }
        }
    });
}

function lotes(producto, almacen, idLote) {
    var tipo_oper = "<?=$tipo_oper;?>";
    var tipo_docu = "<?=$tipo_docu;?>";
    var url = "<?php echo base_url(); ?>index.php/almacen/lote/detalles";
    $.ajax({
        url: url,
        type: "POST",
        data: {
            idLote: idLote,
            producto: producto,
            almacen: almacen,
            tipo_oper: tipo_oper
        },
        dataType: "json",
        success: function(data) {
            if (data != '') {
                $("#tempde_lote").html(function() {
                    var dlote = data;
                    size = dlote.length;
                    opciones = '';
                    stockLote = 0;
                    vencimientoLote = '0001-01-01';
                    for (j = 0; j < size; j++) {
                        if (idLote == dlote[j].LOTP_Codigo) {
                            opciones += '<option value="' + dlote[j].LOTP_Codigo + '" selected>' +
                                dlote[j].LOTC_Numero + '</option>';
                            stockLote = dlote[j].ALMALOTC_Cantidad;
                            vencimientoLote = dlote[j].LOTC_FechaVencimiento;
                        } else {
                            if (tipo_docu != 'C' && tipo_docu != 'D')
                                opciones += '<option value="' + dlote[j].LOTP_Codigo + '">' + dlote[
                                    j].LOTC_Numero + '</option>';
                            else // Si es una nota de credito o debito, no debe seleccionar ningun otro lote
                                opciones += '<option value="' + dlote[j].LOTP_Codigo +
                                '" disabled>' + dlote[j].LOTC_Numero + '</option>';
                        }
                    }
                    $("#tempde_lote").append(opciones);
                    $("#tempde_vencimientoLote").val(vencimientoLote);

                });
            }
        }
    });
}

function listar_marca(id = '') {
    var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/filtro_marca_temproductos";
    $.ajax({
        url: url,
        type: "POST",
        data: {
            idmarca: id
        },
        dataType: "json",
        success: function(data) {
            $("#Marcas").html(data.option);
        }
    });
}

function listar_familia(id = '') {
    var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/filtro_familia_temproductos";
    $.ajax({
        url: url,
        type: "POST",
        data: {
            idfamilia: id
        },
        dataType: "json",
        success: function(data) {
            $("#Familias").html(data.option);
        }
    });
}

function listar_modelo(id) {
    if ($.isNumeric(id) && id > 0) {
        var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/filtro_modelo_temproductos";
        $.ajax({
            url: url,
            type: "POST",
            data: {
                marca: id
            },
            dataType: "json",
            success: function(data) {
                $("#modelos").html(''); // limpiar opciones
                $("#modelos").html(data.option); // agregar opciones nuevas
            }
        });
    } else
        $("#modelos").html(''); // limpiar opciones
}

function mostrar_temporal_producto() {
    var url = "<?=base_url();?>index.php/maestros/temporaldetalle/mostrar_temporal_producto";
    var tempSession = $("#tempSession").val();
    $.ajax({
        url: url,
        type: "POST",
        data: {
            tempSession: tempSession
        },
        dataType: "json",
        error: function(data) {

        },
        success: function(data) {
            if (data.message == '1') {
                array_temporal_producto(data.datos, 'n');
            }

        }
    })
}

function array_temporal_producto(datos, detaccion, randomColor = '', serie = null, num_comprobante = null, tipo =
null) {
    var comprobante = "<?=$codigo;?>";
    var tipo_oper = "<?=$tipo_oper;?>";
    var tipo_docu = "<?=$tipo_docu;?>";

    $.each(datos, function(i, item) {
        tempdeId = item.TEMPDE_Codigo;
        nombre_producto = item.TEMPDE_Descripcion;
        cantidad = parseFloat(item.TEMPDE_Cantidad);
        precio = parseFloat(item.TEMPDE_Precio);
        igv = parseFloat(item.TEMPDE_Igv100);
        descuento = parseFloat(item.TEMPDE_Descuento100);
        flagBS = item.TEMPDE_FlagBs;
        observ_producto = item.TEMPDE_Observacion;
        producto = item.PROD_Codigo;
        unidad_medida = item.UNDMED_Codigo;
        tipoIgv = item.TEMPDE_TipoIgv;
        idLote = item.LOTP_Codigo;
        flagGenInd = '';
        stock = item.TEMPDE_Stock;
        costo = parseFloat(item.tempde_productocosto);
        almacenProducto = item.ALMAP_Codigo;
        icbper = item.TEMPDE_ICBPER;

        anticipo = item.TEMPDE_Anticipo;
        serie_anticipo = item.TEMPDE_AntSerie;
        numero_anticipo = item.TEMPDE_AntNumero;
        showDetails = item.show_details;

        if (item.TEMPDE_CodDetalle != null && comprobante != '') {
            detacodi = item.TEMPDE_CodDetalle;
        } else {
            detacodi = null;
        }

        if (idLote != 0)
            numeroLote = "<br> <b>N° de lote:</b> " + item.LOTC_Numero + ". <b>Fecha de vencimiento:</b> " +
            item.LOTC_FechaVencimiento;
        else
            numeroLote = "";

        marcaSpan = "";

        if (item.marca != undefined && item.marca != null && item.marca != "" && item.marca != "null")
            marcaSpan += item.marca;

        if (tipo_docu == 'OV') {
            nombre_producto_span = nombre_producto + " | " + observ_producto;
        } else if (observ_producto == "") {
            nombre_producto_span = nombre_producto;
        } else {
            nombre_producto_span = nombre_producto + " | " + observ_producto; // + " " + numeroLote;
        }

        comprobante = item.TEMPDE_CodComprobante;

        if (tipoIgv == '1') {

            var contieneIgv = "<?=( isset($contiene_igv) && $contiene_igv == '1' ) ? 1 : 0;?>";
            var igv100 = $("#igv").val();
            if (contieneIgv == 0)
                precio = parseFloat(precio) + (parseFloat(precio) * parseFloat(igv100) / 100);

            precio_conigv = precio;
            precio_sinigv = (precio / (1 + (igv / 100)));
            precio_igv = (precio_conigv - precio_sinigv) * cantidad; //precio_conigv*(igv/100);
            subTotal = precio_sinigv * cantidad;
            //importe_total = precio_conigv*cantidad;
        } else {
            precio_conigv = precio; //(precio*(100+igv)/100);
            precio_sinigv = precio;
            precio_igv = 0; //precio_conigv*(igv/100);
            subTotal = precio_sinigv * cantidad;
            //importe_total = precio_sinigv;
        }

        importe_total = parseFloat(precio_conigv * cantidad);
        prodprecio = parseFloat(precio_sinigv * cantidad);

        n = i;
        j = n + 1;
        if (j % 2 == 0) {
            clase = "itemParTabla";
        } else {
            clase = "itemImparTabla";
        }
          function escaparValor(valor) {
         return valor.replace(/"/g, '&quot;').replace(/'/g, "&#39;");
          }


        fila = '<tr id="' + n + '" class="' + clase + '"  style="background-color:' + randomColor +
            '; color:#000000;" >';
        fila += '<td width="5%"><div align="center">' + j + '</div></td>';

        //fila += '<td width="35%"><div align="left"><input type="hidden" name="proddescri[' + n + ']" id="proddescri[' + n + ']" value="' + nombre_producto + '"/><span id="proddescri_span['+n+']">'+nombre_producto_span+'</span>';

        fila += "<td width='35%' hidden><div align='left'><input type='hidden' name='tempdeId[" + n +
            "]' id='tempdeId[" + n + "]' value='" + tempdeId + "'/><span id='tempdeId[" + n + "]'>" + tempdeId +
            "</span>";

        fila += "<td width='35%'><div align='left'><input type='hidden' name='proddescri[" + n +
            "]' id='proddescri[" + n + "]' value='" + nombre_producto + "'/><span id='proddescri_span[" + n +
            "]'>" + nombre_producto_span + "</span>";
        fila += '</div></td>';

        fila += '<td width="10%"><div style="text-align:center;">';
        fila += '<input type="hidden" name="pendiente[' + n + ']" id="pendiente[' + n + ']" value="' +
            cantidad + '">';
        fila += '<input type="hidden" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' +
            cantidad + '"><span id="prodcantidad_span[' + n + ']"> ' + parseFloat(cantidad).toFixed(2) +
            '</span>';
        fila += '</div></td>';

        fila += '<td width="10%"><div style="text-align:center;"><span id="prod_precio_span_sigv[' + n + ']">' +
            parseFloat(precio_sinigv).toFixed(2) + '</span></div></td>';

        fila += '<td width="10%"><div style="text-align:center;"><span id="prod_precio_span[' + n + ']">' +
            parseFloat(precio_conigv).toFixed(2) + '</span></div></td>';

        fila +=
            '<td width="10%"><div style="text-align:center;"><input type="hidden" size="5" style="text-align: right;" name="prodimporte[' +
            n + ']" id="prodimporte[' + n + ']" value="' + importe_total + '" ><span id="prodimporte_span[' +
            n + ']">' + parseFloat(importe_total).toFixed(2) + '</span></div></td>';

        fila +=
            '<td width="5%"><div style="text-align:center;"><a href="#" data-toggle="modal" data-target=".bd-example-modal-lg"  onclick="editar_producto_temporal(' +
            n + ');"><img src="' + base_url +
            'images/edit.png?=<?=IMG;?>" width="20" height="20"  border="0" tittle="editar"></a>';
        fila +=
            '<td width="5%"><div style="text-align:center;"><a href="#" onclick="eliminar_producto_temporal(' +
            n + ');"><img src="' + base_url +
            'images/delete.png?=<?=IMG;?>" width="20" height="20"  border="0" tittle="eliminar"></a>';


        fila +=
            '<td width="6%" style="display:none;"><div align="center"><input style="text-align: right;" type="text" size="5" maxlength="10" class="cajaGeneral" value="' +
            precio_sinigv + '" name="prodpu[' + n + ']" id="prodpu[' + n + ']" value="0" onblur="modifica_pu(' +
            n + ');" onkeypress="return numbersonly(this,event,\'.\');" ></div></td>';
        fila +=
            '<td width="6%" style="display:none;"><div align="center"><input type="text" size="5" style="text-align: right;" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio[' +
            n + ']" id="prodprecio[' + n + ']" value="' + prodprecio + '" readonly="readonly">';

        fila +=
            '<td width="6%" style="display:none;" ><div align="center"><input type="text" style="text-align: right;" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[' +
            n + ']" id="prodigv[' + n + ']" value="' + precio_igv + '" readonly="readonly"></div></td>';
        fila += '<td width="6%" style="display:none;" ><div align="center">';
        fila += '<input type="hidden" name="detaccion[' + n + ']" id="detaccion[' + n + ']" value="' +
            detaccion + '">';
        fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv +
            '">';
        fila += '<input type="hidden" value="' + detacodi + '" name="detacodi[' + n + ']" id="detacodi[' + n +
            ']">';
        fila += '<input type="hidden" name="proddescuento100[' + n + ']" id="proddescuento100[' + n +
            ']" value="' + descuento + '">';
        fila += '<input type="hidden" name="showDetails[' + n + ']" id="showDetails[' + n + ']" value="' +
            showDetails + '">';

        fila += '<input type="hidden" name="tafectacion[' + n + ']" id="tafectacion[' + n + ']" value="' +
            tipoIgv + '"/>';
        fila += '<input type="hidden" name="idLote[' + n + ']" id="idLote[' + n + ']" value="' + idLote + '"/>';
        fila += '<input type="hidden" name="icbper[' + n + ']" id="icbper[' + n + ']" value="' + icbper + '"/>';
        fila += '<input type="hidden" name="proddescuento[' + n + ']" id="proddescuento[' + n + ']"  />';
        fila += '<input type="hidden" name="flagBS[' + n + ']" id="flagBS[' + n + ']" value="' + flagBS + '"/>';
         fila += '<input type="hidden" name="prodobservacion[' + n + ']" id="prodobservacion[' + n + ']" value="' + escaparValor(observ_producto) + '"/>';
        fila += '<input type="hidden" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' +
            producto + '"/>';
        fila += '<input type="hidden" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' +
            unidad_medida + '"/>';
        fila += '<input type="hidden" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' +
            flagGenInd + '"/>';
        fila += '<input type="hidden" name="prodstock[' + n + ']" id="prodstock[' + n + ']" value="' + stock +
            '"/>';
        fila += '<input type="hidden" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo +
            '"/>';
        fila += '<input type="hidden" name="almacenProducto[' + n + ']" id="almacenProducto[' + n +
            ']" value="' + almacenProducto + '"/>';
        fila += '<input type="hidden" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" value="' +
            precio_conigv + '" /> ';
        fila += '<input type="hidden" name="modalAccion[' + n + ']" id="modalAccion[' + n + ']" value="n"/>';
        fila += '<input type="hidden" name="oventacod[' + n + ']" id="oventacod[' + n + ']" value="0">';
        fila += '<input type="hidden" name="codigoGuiarem[' + n + ']" id="codigoGuiarem[' + n + ']" value="">';
        fila += '<input type="hidden" name="numero_comprobante[' + n + ']" id="numero_comprobante[' + n +
            ']" value="' + comprobante + '">';

        //ANTICIPOS
        fila += '<input type="hidden" name="anticipo[' + n + ']" id="anticipo[' + n + ']" value="' + anticipo +
            '"/>';
        fila += '<input type="hidden" name="serie_anticipo[' + n + ']" id="serie_anticipo[' + n + ']" value="' +
            serie_anticipo + '"/>';
        fila += '<input type="hidden" name="numero_anticipo[' + n + ']" id="numero_anticipo[' + n +
            ']" value="' + numero_anticipo + '"/>';

        //fila += '<input type="hidden" name="idNumero[' + n + ']" id="idNumero[' + n + ']" value="' + num_comprobante + '">';
        //fila += '<input type="hidden" name="idSerie[' + n + ']" id="idSerie[' + n + ']" value="' + serie + '">';
        //fila += '<input type="hidden" name="guiaReferente[' + n + ']" id="guiaReferente[' + n + ']" value="' + comprobante + '">';
        //fila += '<input type="hidden" name="origenDocumento[' + n + ']" id="origenDocumento[' + n + ']" value="' + tipo + '">';

        fila += '</div></td>';
        fila += '</tr>';


        $("#tempde_tblbody").append(fila);
        calcular_totales_tempdetalle();
    });
    return;
}

function editar_comprobantes_temproductos(comprobante, tipo_docu) {
    var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/editar_comprobantes_temproductos";
    var tempSession = $("#tempSession").val();
    $.ajax({
        url: url,
        type: "POST",
        data: {
            comprobante: comprobante,
            tipo_docu: tipo_docu,
            tempSession: tempSession
        },
        dataType: "json",
        success: function(data) {
            if (data.message == '1') {
                array_temporal_producto(data.datos, 'm');
                //tipo_afectacion_temproductos();

                if (data.proyecto != null && data.proyecto != '') {
                    $("#obra option[value=" + data.proyecto + "]").attr("selected", true);
                }

                if (data.OrdenCompraEmpresa != null && data.OrdenCompraEmpresa != '') {
                    $("#ordencompraempresa").val(data.OrdenCompraEmpresa);
                }
            }

        }
    })
}

function obtener_comprobantes_temproductos(comprobante, tabla) {
    var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/obtener_comprobantes_temproductos";
    var tempSession = $("#tempSession").val();

    $.ajax({
        url: url,
        type: "POST",
        data: {
            comprobante: comprobante,
            tabla: tabla,
            tempSession: tempSession
        },
        dataType: "json",
        success: function(data) {
            if (data.message == '1') {
                var color = generar_color();
                //limpiar_campos_prod_temporal();

                array_temporal_producto(data.datos, 'n', color);
                //tipo_afectacion_temproductos();
                if (tabla == 'guiarem') {
                    //agregarGuiasRelacion(comprobante,data.serie,data.numero,color);
                    insertar_valrepetido_campo('codigoGuiarem', comprobante);
                }

                if (data.proyecto != null && data.proyecto != '') {
                    $("#obra option[value=" + data.proyecto + "]").attr("selected", true);
                }

                if (data.OrdenCompraEmpresa != null && data.OrdenCompraEmpresa != '') {
                    $("#ordencompraempresa").val(data.OrdenCompraEmpresa);
                }
            } else
                alert("No hay articulos para agregar.");

        }
    })
}

function limpiar_campos_prod_temporal() {
    n = document.getElementById('tempde_tblbody').rows.length;
    for (i = 0; i < n; i++) {
        $("#" + i).remove();
    }
}

function insertar_valrepetido_campo(input, valor) {
    n = document.getElementById('tempde_tblbody').rows.length;
    for (i = 0; i < n; i++) { //Estanb al reves los campos
        a = input + "[" + i + "]";
        document.getElementById(a).value = valor;
    }
}

function generar_color() {
    /*var randomColor = Math.floor(Math.random()*16777215).toString(16);*/
    var randomColor = "rgba(9,149,239,0.7)";
    /*randomColor="#"+randomColor;*/
    return randomColor;
}

function cerrar_ventana_prodtemporal() {
    $('.bd-example-modal-lg').modal('toggle');
    $('.modal-backdrop').hide();
}
/* ::::::::::::::: FUNCION SOLO EN FACTURA AL JALAR GUIA ::::::::::::::::: */
function agregarGuiasRelacion(codigoGuiarem, serie, numero, color) {

    var total = $('input[id^="accionAsociacionGuiarem"][value!="0"]').length;
    n = document.getElementById('idTableGuiaRelacion').rows.length;

    if (total == 0) {
        /***mmostramos el div tr de guias relacionadas**/
        $("#idDivGuiaRelacion").show(200);
    }



    proveedor = $("#proveedor").val();
    j = n;
    fila = '<tr id="idTrDetalleRelacion_' + j + '">';
    fila += '<td>';
    fila += '<a href="javascript:void(0);" onclick="deseleccionarGuiaremision(' + codigoGuiarem + ',' + j +
        ')" title="Deseleccionar Guia de remision">';
    fila += 'x';
    fila += '</a>';
    fila += '</td>';
    fila += '<td>' + j + '</td>';
    fila += '<td>' + serie + '</td>';
    fila += '<td>' + numero + '</td>';
    /**accionAsociacionGuiarem nuevo:1**/
    fila += '<td><div style="width:10px;height:10px;background-color:' + color + ';border:1px solid black"></div>';
    fila += '	<input type="text" id="codigoGuiaremAsociada[' + j + ']"  name="codigoGuiaremAsociada[' + j +
        ']" value="' + codigoGuiarem + '" />';
    fila += '<input type="text" id="accionAsociacionGuiarem[' + j + ']"  name="accionAsociacionGuiarem[' + j +
        ']" value="1" />';
    fila += '<input type="text" id="proveedorRelacionGuiarem[' + j + ']"  name="proveedorRelacionGuiarem[' + j +
        ']" value="' + proveedor + '" />';
    fila += '</td>';
    fila += '</tr>';
    $("#idTableGuiaRelacion").append(fila);

}
/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */

function limpiar_campos_modal() {
    $("#tempde_id").val("");
    $("#bar_code").val("");
    $("#tempde_codproducto").val("");
    $("#tempde_almacenproducto").val("");
    $("#tempde_unidadmedida").val("");
    $("#tempde_moneda").val("");
    $("#tempde_descuento").val("");
    $("#tempde_igvLinea").val("");
    $("#tempde_productocosto").val("0");
    $("#tempde_producto").val("");
    $("#tempde_detalleItem").val("");
    $("#tempde_prodStock").val("");
    $("#tempde_cantidad").val("1");
    $("#tempde_precioUnitario").val("0");
    $("#tempde_subTotal").val("0");
    $("#tempde_tipoIgv").val("1");

    $('#showDetails').prop('checked', false);

    $("#tempde_lote").html("");
    $("#tempde_vencimientoLote").val("");

    /* Limpiar los campos en caso se halla creado un lote */
    $("#infoNumeroLote").val("");
    $("#infoVencimientoLote").val("");

    $("#tempde_total").val("");
    $("#tempde_producto").attr('readonly', false);
    $("#tempde_filtro_marca").val("");
    $("#tempde_filtro_familia").val("");
    $("#tempde_icbper_monto").val("");
    $("#tempde_aceptar").attr("onclick", "agregar_producto_temporal()");
    flagBolsa(0);

    //ANTICIPOS
    flagAnticipo(0);
    $("#serie_anticipo").val("");
    $("#numero_anticipo").val("");

    anticipos = $("#tipo_venta").val();

    if (anticipos == "4") {
        $(".anticipos").css("display", "block");
    } else {
        $(".anticipos").css("display", "none");
    }
    //FIN ANTICIPOS

    $("#tempde_producto").focus();
}

/* ::::::::::::::: FUNCIONES SOLO CALCULOS :::::::::::::::::::::::::::::  */
function calcular_temProducto_modal() {
    var cantidad = $("#tempde_cantidad").val();
    var precio_unitario = $("#tempde_precioUnitario").val();
    var subTotal = $("#tempde_subTotal").val();
    var total = $("#tempde_total").val();
    var tipoIgv = $("#tempde_tipoIgv").val();
    var igvLinea = $("#tempde_igvLinea").val();
    var igv100 = $("#igv").val();
    var precio_sinigv = 0;
    var precio_conigv = 0;
    var importe = 0;
    var igvpu = 0;

    if ($("#tempde_icbper").is(":checked") == true) {
        total_bolsa = monto_bolsa * cantidad
        $('#tempde_icbper_monto').val(total_bolsa.toFixed(2));
    } else {
        $('#tempde_icbper_monto').val("");
    }

    if (tipoIgv == "1") {

        var contieneIgv = "<?=( isset($contiene_igv) && $contiene_igv == '1' ) ? 1 : 0;?>";
        if (contieneIgv == 0)
            precio_unitario = parseFloat(precio_unitario) + (parseFloat(precio_unitario) * parseFloat(igv100) / 100);

        precio_conigv = parseFloat(precio_unitario);
        precio_sinigv = parseFloat(precio_conigv / ((100 + parseFloat(igv100)) / 100));
        igvpu = parseFloat(precio_sinigv * (igv100 / 100));
        igvLinea = parseFloat(igvpu * cantidad);
        importe = parseFloat(cantidad * precio_conigv);
        subTotal = parseFloat(cantidad * precio_sinigv);
    } else {
        precio_sinigv = parseFloat(precio_unitario);
        igvpu = 0; //parseFloat(precio_sinigv*(igv100/100));
        precio_conigv = parseFloat(precio_sinigv + igvpu);
        igvLinea = 0; //parseFloat(igvpu*cantidad);
        importe = parseFloat(cantidad * precio_conigv);
        subTotal = parseFloat(cantidad * precio_sinigv);
    }

    $("#tempde_subTotal").val(subTotal.toFixed(5));
    $("#tempde_igvLinea").val(igvLinea.toFixed(5));
    $("#tempde_total").val(importe.toFixed(5));
}

function calcular_desde_total() {
    var cantidad = $("#tempde_cantidad").val();
    var precio_unitario = $("#tempde_precioUnitario").val();
    var subTotal = $("#tempde_subTotal").val();
    var total = $("#tempde_total").val();
    var tipoIgv = $("#tempde_tipoIgv").val();
    var igvLinea = $("#tempde_igvLinea").val();
    var igv100 = $("#igv").val();
    var precio_sinigv = 0;
    var precio_conigv = 0;
    var importe = 0;
    var igvpu = 0;

    if ($("#tempde_icbper").is(":checked") == true) {
        total_bolsa = monto_bolsa * cantidad
        $('#tempde_icbper_monto').val(total_bolsa.toFixed(2));
    } else {
        $('#tempde_icbper_monto').val("");
    }


    if (tipoIgv == "1") {

        var contieneIgv = "<?=( isset($contiene_igv) && $contiene_igv == '1' ) ? 1 : 0;?>";

        igvLinea = parseFloat((total * (igv100 / 100)) / (1 + (igv100 / 100)));
        subTotal = parseFloat(igvLinea / (igv100 / 100));
        precio_sinigv = parseFloat(subTotal / cantidad);
        if (contieneIgv == 0) {
            precio_unitario = precio_sinigv;
        } else {
            precio_unitario = precio_sinigv * ((100 + parseFloat((igv100))) / 100);
        }

    } else {
        igvLinea = 0;
        subTotal = parseFloat(total);
        precio_sinigv = parseFloat(subTotal / cantidad);
        if (contieneIgv == 0) {
            precio_unitario = precio_sinigv;
        } else {
            precio_unitario = precio_sinigv;
        }
    }

    $("#tempde_subTotal").val(subTotal.toFixed(5));
    $("#tempde_igvLinea").val(igvLinea.toFixed(5));
    //$("#tempde_total").val(importe.toFixed(5));
    $("#tempde_precioUnitario").val(precio_unitario.toFixed(5))
}

function calcular_totales_tempdetalle() {

    n = document.getElementById('tempde_tbl').rows.length;
    importe_total = 0;
    igv_total = 0;
    descuento_total = 0;
    precio_total = 0;
    igvtotal = 0;
    gravada_total = 0;
    exonerado_total = 0;
    inafecto_total = 0;
    gratuito_total = 0;
    preciototal = 0;
    importetotal = 0;
    tbolsa = 0;
    tanticipo = 0;

    igv = $("#igv").val();
    descuento = $("#descuento").val();
    tipo_venta = $("#tipo_venta").val();
    if (igv == null || igv == undefined) {
        igv = 18;
    }
    if (descuento == null || descuento == undefined) {
        descuento = 0;
    }
    for (i = 0; i < n; i++) {
        a = "prodimporte[" + i + "]";
        pc = "prodcantidad[" + i + "]";
        b = "prodigv[" + i + "]";
        c = "proddescuento[" + i + "]";
        d = "prodprecio[" + i + "]";
        e = "detaccion[" + i + "]";
        f = "tafectacion[" + i + "]";
        g = "icbper[" + i + "]";
        an = "anticipo[" + i + "]";

        if (document.getElementById(e) != null && document.getElementById(e).value != 'e' && document.getElementById(e)
            .value != 'EE') {
            precio = parseFloat(document.getElementById(d).value); //subTotal || cantidad * precio sin igv
            afectacion = document.getElementById(f).value; // SUMA DE IGV
            icbper = document.getElementById(g).value; // IMPUESTO POR BOLSA
            cantidad = document.getElementById(pc).value; // IMPUESTO POR BOLSA
            importeBolsa = monto_bolsa * cantidad;

            anticipo = document.getElementById(an).value; // ANTICIPOS O DEDUCCIONES
            if (anticipo == "1" && tipo_venta == "4") {
                tanticipo += precio;
            } else {
                if (afectacion == "1") { // GRAVADA
                    gravada_total += precio;

                    //igvTo = parseFloat(document.getElementById(b).value); // SUMA DE IGV
                    //igvtotal = (igvTo + igvtotal);
                } else
                if (afectacion == "8") { // EXONERADO
                    exonerado_total += precio;
                } else
                if (afectacion == "9" || afectacion == '16') { // INAFECTO O EXPORTACION
                    inafecto_total += precio;
                } else { // GRATUITA
                    gratuito_total += precio;
                }

                if (icbper == "1") {
                    tbolsa += importeBolsa;
                }
            }
        }
    }

    descuento_gravada = gravada_total * parseFloat(descuento / 100);
    descuento_exonerado = exonerado_total * parseFloat(descuento / 100);
    descuento_inafecto = inafecto_total * parseFloat(descuento / 100);

    // AL GRATUITO NO SE LE APLICA EL DESCUENTO, "DE POR SI YA ES GRATUITO ;) "
    descuento_total = descuento_gravada + descuento_exonerado + descuento_inafecto;

    gravada_total = gravada_total - descuento_gravada - tanticipo;
    exonerado_total = exonerado_total - descuento_exonerado;
    inafecto_total = inafecto_total - descuento_inafecto;

    precio_total = gravada_total + exonerado_total + inafecto_total;
    igvtotal = parseFloat((gravada_total * igv) / 100);

    // IMPORTE TOTAL NO INCLUYE DESCUENTO TOTAL. EL DESCUENTO YA FUE RESTADO DE LAS AFECTACIONES
    importetotal = parseFloat(precio_total + igvtotal + tbolsa);

    $("#gravadatotal").val(gravada_total.format(false));
    $("#exoneradototal").val(exonerado_total.format(false));
    $("#inafectototal").val(inafecto_total.format(false));
    $("#gratuitatotal").val(gratuito_total.format(false));

    <?php # AHORA SI INCLUIMOS EL DESCUENTO TOTAL, PARA MOSTRARLO CORRECTAMENTE EN LA VISTA Y GUARDAR EN LA DB ?>

    $("#preciototal").val(precio_total.format(false)); //val(precio_total)
    $("#descuentotal").val(descuento_total.format(false));
    $("#igvtotal").val(igvtotal.format(false)); //val(igv_total)
    $("#importetotal").val(importetotal.format(false)); //val(importe_total)
    $('#montoFP_default').val(importetotal.format(false));
    $("#importeBolsa").val(tbolsa.format(false));
    $("#importeAnticipo").val(-tanticipo.format(false));





    //DETRACCION
    if (tipo_venta == "30") {

        var por_detraccion = parseFloat($("#por_detraccion").val());
        var importetotal = parseFloat($("#importetotal").val());
        importeTMR = 0;
        if ($("#applyRetencion").is(":checked") == true) {
            importeR = (importetotal * $("#retencion_porc").val() / 100);
        }
        total_detraccion = (por_detraccion / 100) * importetotal;
        total_a_pagar = importetotal - total_detraccion - importeTMR;
        $("#total_detraccion").val(total_detraccion);
        $(".importe_detraccion").val(total_a_pagar);
        cuota_total(false);
    }
    //FIN DETRACCION
    // SI TIENE RETENCIÓN
    if ($("#applyRetencion").is(":checked") == true) {
        $(".info-retencion").css({
            "display": "inline-block"
        });
        $(".importe_retencion_tr").show();

        importeRetencion = $("#importetotal").val() * 0.03;
        importetotal = $("#importetotal").val() - importeRetencion;

        $(".importe_retencion_span").html(importeRetencion.toFixed(2));
        $(".importe_retencion").val(importetotal.toFixed(2));
        tipo_venta = $("#tipo_venta").val();
        if ($("#tipo_venta").val() == "30") {
            var por_detraccion = parseFloat($("#por_detraccion").val());
            var importetotal = parseFloat($("#importetotal").val());
            total_detraccion = (por_detraccion / 100) * importetotal;
            total_a_pagar = importetotal - total_detraccion - importeRetencion;
            $(".importe_detraccion").val(total_a_pagar);

        }

        $("#retencion_porc").val("3");
        $("#retencion_codigo").val("1");
        var currentText = document.getElementById('forma_pago').options[document.getElementById('forma_pago').options
            .selectedIndex].innerText.toLowerCase();
        var requiereCuota = /cuota|credito|letra/g.test(currentText);
        if (requiereCuota) {
            cuota_total(false);
        }

    }
    //FIN RETENCION
    //PERCEPCION
    if (tipo_venta == "34") {
        calcular_percepcion();
    }
    //FIN PERCEPCION

    if (tipo_docu == "F" || tipo_docu == "N" || tipo_docu == "B") {
        var currentText = document.getElementById('forma_pago').options[document.getElementById('forma_pago').options
            .selectedIndex].innerText.toLowerCase();
        var requiereCuota = /cuota|credito/g.test(currentText);
        if (requiereCuota) {
            cuota_total(false);
        }
    }

    // //Modificar monto de forma de pago principal
    // var montoFP_default2 = parseFloat($('#montoFP_default2').val());
    // var montoFP_default = parseFloat($('#montoFP_default').val());
    // if (isEdit == 0 && $('#montoFP_default').val() == '')
    // {
    //     $('#montoFP_default').val($("#importetotal").val());
    // }else{
    //     /*if (montoFP_default2 > 0){
    //         $('#montoFP_default').val(montoFP_default2);
    //     }
    //     else{
    //         $('#montoFP_default').val($("#importetotal").val());
    //     }*/
    // }

}

//FUNCION QUE LIMPIA LOS ITEMS CUANDO SE DA CLIC AL BOTON LIMPIAR DEL DOCUMENTO
function eliminar_producto_temporal_all(fila) {

    var d = "detacodi[" + fila + "]";
    var p = "prodcodigo[" + fila + "]";
    var a = "almacenProducto[" + fila + "]";
    var s = "prodstock[" + fila + "]";
    var m = "modalAccion[" + fila + "]";
    var e = "detaccion[" + fila + "]";
    detalleId = document.getElementById(d).value;
    codProducto = document.getElementById(p).value;
    almacen = document.getElementById(a).value;
    stock = document.getElementById(s).value;
    var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/eliminar_producto_temporal";
    document.getElementById(m).value = 'e';
    document.getElementById(e).value = 'e';
    var tempSession = $("#tempSession").val();
    $.ajax({
        url: url,
        data: {
            codproducto: codProducto,
            tempSession: tempSession
        },
        type: "POST",
        success: function(data) {
            if (data == "1") {
                $("#" + fila).css('display', 'none');
                $("#tempde_message").css('color', '#232D7E');
                $("#tempde_message").html('se elimino correctamente');
                $("#tempde_prodStock").val("");
                $("#tempde_prodStock").css("background-color", "#ffffff");
                $("#tempde_message").show();

                $("#tempde_aceptar").attr("onclick", "agregar_producto_temporal()");
                //$("#tempde_aceptar").attr("onclick","agregar_productotemp_modificado("+fila+")");
                limpiar_campos_modal();
                calcular_totales_tempdetalle();
            }
        }
    });

    return false;
}

///////////////////////////
//CODIGOS DE BARRA

function busqueda_producto_enter() {
    let valida = true;
    var bar_code = $("#bar_code").val();
    var flagBS = $('#flagBS').val();
    var codigo_interno = $('#tempde_barcode').val().trim();
    var almacen = $('#almacen').val().trim();
    var TipCli = $("#TipCli").val();
    var codproducto = $("#tempde_codproducto").val();
    var precio = $("#tempde_precioUnitario").val();
    var cantidad = $("#tempde_cantidad").val();
    var moneda = $("#moneda").val();

    if (codigo_interno != "" && codigo_interno != null) {

        n = document.getElementById('tempde_tblbody').rows.length;

        if (codigo_interno == bar_code) {
            var cantidad = parseFloat($("#tempde_cantidad").val());
            var total = cantidad + 1;
            $("#tempde_cantidad").val(total);
            $("#tempde_barcode").val("");
            calcular_temProducto_modal();
        } else {

            if (bar_code != "" && codproducto != "") {
                if (n > 0) {
                    for (var i = 0; i < n; i++) {
                        accion = "detaccion[" + i + "]";
                        detaccion = document.getElementById(accion).value;
                        PROD_Codigo = "prodcodigo[" + i + "]";
                        productiviris = document.getElementById(PROD_Codigo).value;
                        if (codproducto == productiviris && detaccion != "e") {

                            agregar_productotemp_modificado(i);
                            $("#tempde_barcode").val("");

                        } else {
                            if (precio == "" || precio == "0") {
                                Swal.fire({
                                    icon: "warning",
                                    title: "Precio debe ser mayor a cero!",
                                    html: "<b class='color-red'></b>",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                $("#tempde_barcode").val("");
                                valida = false;
                                return false;
                            } else if (cantidad == "" || cantidad == "0") {
                                Swal.fire({
                                    icon: "warning",
                                    title: "Cantidad debe ser mayor a cero!",
                                    html: "<b class='color-red'></b>",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                $("#tempde_barcode").val("");
                                valida = false;
                                return false;
                            } else {
                                agregar_producto_temporal();

                                Swal.fire({
                                    icon: "warning",
                                    title: "Agregando cantidad ingresada!",
                                    html: "<b class='color-red'>Por favor espere</b>",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }


                        }
                    }
                } else {
                    if (precio == "" || precio == "0") {
                        Swal.fire({
                            icon: "warning",
                            title: "Precio debe ser mayor a cero!",
                            html: "<b class='color-red'></b>",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $("#tempde_barcode").val("");
                        valida = false;
                        return false;
                    } else if (cantidad == "" || cantidad == "0") {
                        Swal.fire({
                            icon: "warning",
                            title: "Cantidad debe ser mayor a cero!",
                            html: "<b class='color-red'></b>",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $("#tempde_barcode").val("");
                        valida = false;
                        return false;
                    } else {
                        agregar_producto_temporal();

                        Swal.fire({
                            icon: "warning",
                            title: "Agregando cantidad ingresada!",
                            html: "<b class='color-red'>Por favor espere</b>",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }





                }


            }
            if (valida == true) {

                var url = base_url + "index.php/almacen/producto/seleccionar_producto_con_enter/";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        tipo_oper: tipo_oper,
                        flagbs: flagBS,
                        codigo_interno: codigo_interno,
                        TipCli: TipCli,
                        moneda: moneda,
                        almacen: almacen
                    },
                    dataType: "json",

                    success: function(data) {

                        var valor = data[0].valor;

                        if (valor == '1') {
                            var flag = 0;
                            if (n > 0) {
                                for (var i = 0; i < n; i++) {

                                    PROD_Codigo = "prodcodigo[" + i + "]";
                                    productiviris = document.getElementById(PROD_Codigo).value;
                                    PROD_Cantidad = "prodcantidad[" + i + "]";
                                    product_qty = document.getElementById(PROD_Cantidad).value;
                                    accion = "detaccion[" + i + "]";
                                    detaccion = document.getElementById(accion).value;
                                    if (data[0].codigo == productiviris && detaccion != "e") {
                                        editar_producto_temporal_pistoleao(i);
                                        flag = 1;
                                        $("#tempde_barcode").val("");
                                        calcular_temProducto_modal();
                                    }
                                }
                            }
                            if (flag == 0) {
                                $("#tempde_producto").val(data[0].value);
                                $("#tempde_detalleItem").val(data[0].descripcion);
                                $("#tempde_codproducto").val(data[0].codigo);
                                $("#tempde_moneda").val($("#moneda").val());

                                if (tipo_oper == "C") {
                                    $("#tempde_precioUnitario").val(data[0].pcosto);
                                } else {
                                    if (data[0].pventa == "" || data[0].pventa == null) {
                                        $("#tempde_precioUnitario").val(0);

                                    } else {
                                        $("#tempde_precioUnitario").val(data[0].pventa);
                                    }
                                }

                                $("#tempde_productocosto").val(data[0].pcosto);

                                $("#tempde_prodStock").val(data[0].stock);
                                if (data[0].stock <= 0) {
                                    $("#tempde_prodStock").css('background-color', '#E10C36');
                                }

                                $("#tempde_lote").html(function() {
                                    var dlote = data[0].lote;

                                    if (dlote != undefined) {
                                        size = dlote.length;
                                        opciones = '';
                                        stockLote = 0;
                                        vencimientoLote = '0001-01-01';

                                        for (j = 0; j < size; j++) {
                                            if (j == 0) {
                                                opciones += '<option value="' + dlote[j]
                                                    .LOTP_Codigo + '" selected>' + dlote[j]
                                                    .LOTC_Numero + '</option>';
                                                stockLote = dlote[j].ALMALOTC_Cantidad;
                                                vencimientoLote = dlote[j].LOTC_FechaVencimiento;
                                            } else
                                                opciones += '<option value="' + dlote[j]
                                                .LOTP_Codigo + '">' + dlote[j].LOTC_Numero +
                                                '</option>';
                                        }

                                        $("#tempde_lote").append(opciones);
                                        $("#tempde_vencimientoLote").val(vencimientoLote);
                                    }
                                });

                                $("#tempde_flagBs").val($("#flagBS").val());
                                $("#tempde_flagGenIndnInd").val(data[0].flagGenInd);
                                $("#tempde_almacenproducto").val(data[0].almacenProducto);
                                $("#tempde_unidadmedida").val(data[0].codunidad);
                                $("#tempde_tipoIgv").val(data[0].tipo_afectacion);
                                $("#tempde_filtro_marca").val(data[0].marca);
                                $("#tempde_cantidad").val(1);
                                $("#tempde_barcode").val("");
                                $("#bar_code").val(codigo_interno);
                                //$("#tempde_cantidad").focus();
                                calcular_temProducto_modal();
                            }
                        } else {
                            Swal.fire({
                                icon: "warning",
                                title: "Parece que el producto o servicio no existe!",
                                html: "<b class='color-red'>Verifica en la lista de articulos</b>",
                                showConfirmButton: true,
                                timer: 2000
                            });
                        }

                    },
                    error: function(XHR, error) {

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
        }
    }
}

function editar_producto_temporal_pistoleao(fila) {
    limpiar_campos_modal();

    var d = "detacodi[" + fila + "]";
    var p = "prodcodigo[" + fila + "]";
    var a = "almacenProducto[" + fila + "]";
    var s = "prodstock[" + fila + "]";
    var m = "modalAccion[" + fila + "]";
    var e = "detaccion[" + fila + "]";
    var l = "idLote[" + fila + "]";
    detalleId = document.getElementById(d).value;
    codProducto = document.getElementById(p).value;
    almacen = document.getElementById(a).value;
    stock = document.getElementById(s).value;
    idLote = document.getElementById(l).value;
    var url = "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/obtener_producto_temporal";
    if (detalleId == '') {
        document.getElementById(m).value = 'm';
    } else {
        document.getElementById(m).value = 'm';
        document.getElementById(e).value = 'm';
    }
    //$("#tempde_aceptar").attr("onclick","agregar_producto_temporal()");
    $("#tempde_aceptar").attr("onclick", "agregar_productotemp_modificado(" + fila + ")");
    var tempSession = $("#tempSession").val();
    $.ajax({
        url: url,
        data: {
            detalleId: detalleId,
            codproducto: codProducto,
            tempSession: tempSession,
            idLote: idLote
        },
        type: "POST",
        dataType: "json",
        success: function(data) {
            $.each(data.datos, function(i, item) {

                var cantidad = parseFloat(item.TEMPDE_Cantidad) + 1;
                $("#tempde_cantidad").val(cantidad);
                $("#tempde_id").val(item.TEMPDE_Codigo);
                $("#tempde_codproducto").val(item.PROD_Codigo);
                $("#bar_code").val(item.codigo_usuario);
                $("#tempde_almacenproducto").val(almacen);
                $("#tempde_unidadmedida").val(item.UNDMED_Codigo);
                $("#tempde_moneda").val(item.MONED_Codigo);
                $("#tempde_descuento").val(item.TEMPDE_Descuento);
                $("#tempde_igvLinea").val(item.TEMPDE_Igv);
                $("#tempde_filtro_marca").val(' - ' + item.marca);
                $("#tempde_producto").val(item.TEMPDE_Descripcion);
                $("#tempde_producto").attr('readonly', 'readonly');
                $("#tempde_detalleItem").val(item.TEMPDE_Observacion);
                $("#tempde_prodStock").val(item.stock);
                $("#tempde_productocosto").val(item.TEMPDE_Costo);
                $("#tempde_precioUnitario ").val(item.TEMPDE_Precio);
                $("#tempde_subTotal").val(item.TEMPDE_Subtotal);
                $("#tempde_tipoIgv").val(item.TEMPDE_TipoIgv);
                $("#tempde_total").val(item.TEMPDE_Total);
                lotes(item.PROD_Codigo, almacen, idLote);
                flagBolsa(item.TEMPDE_ICBPER);

            });
        }
    })
}

//FIN CODIGO DE BARRA

//ADD PRODUCTO NUEVO

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
                                html: "<b style='color: red; font-size: 12pt;'>¿Desea continuar?</b>",
                                showConfirmButton: true,
                                showCancelButton: true,
                                confirmButtonText: "Aceptar",
                                cancelButtonText: "Cancelar"
                            }).then(result => {
                                if (result.value) {
                                    if (validacion == true) {
                                        registro_producto();
                                    }
                                } else {
                                    $("#nvo_codigo").focus();
                                    return false;
                                }
                            });
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
    var info = $("#form_nvo").serialize();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: info,
        success: function(data) {
            let id = $("#id").val();
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
            $("#modal_producto").modal("toggle");
        }
    });
}

function ver_ficha() {
    var id_prod = $("#id_p").val();
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

function importar_ficha() {
	var url = base_url + "index.php/maestros/temporaldetalle/actualizar_ficha";

	// Crear un objeto FormData
	var formData = new FormData();
	var ficha = $("#ficha_file")[0].files[0]; // Capturar el archivo PDF

	formData.append('info', $("#form_file").serialize());
	formData.append('ficha', ficha);

	$.ajax({
		type: 'POST',
		url: url,
		data: formData,
		contentType: false, // Evitar que jQuery establezca contentType
		processData: false, // No procesar los datos (no convertir a query string)
		dataType: 'json',
		success: function(data) {
			let id = $("#id_p").val();
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


function clean() {
    $("#form_nvo")[0].reset();
    $("#id").val("");
    $(".contadorCaracteres").html("800");

    $("#nvo_codigo").removeAttr("readOnly");
}
//FIN ADD PRODUCTO NUEVO
</script>