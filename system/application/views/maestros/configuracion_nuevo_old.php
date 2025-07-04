<script type="text/javascript" src="<?php echo base_url();?>js/maestros/cargo.js?=<?=JS;?>"></script>

<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>

<div class="container-fluid">
	<div class="row header">
		<div class="col-md-12 col-lg-12">
			<div><?=$titulo;?></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js?=<?=JS;?>"></script>			
<script type="text/javascript" src="<?php echo base_url();?>js/maestros/configuracion.js?=<?=JS;?>"></script>
<div id="pagina">
<div id="zonaContenido">
    <div align="center">
        <div id="tituloForm" class="header"><?php echo $titulo;?></div>
        <div id="frmBusqueda">
            <div align="left"><?php echo validation_errors("<div class='error'>",'</div>');?></div>

                <form id="<?php echo $formulario?>" name="<?php echo $formulario?>" method="post" enctype="multipart/form-data" action="<?php echo $url_action;?>">
                    <br>
                    <div id="divPrincipal">
                        <table class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">
                            <tr>
                                <td width="20%"><?php echo $campos[0];?></td>
                                <td align="left">
                                     <?php echo $valores[0];?>
                                </td>
                                <td>&nbsp;</td>
                                <td align="center" valign="top">&nbsp;</td>
                                <td align="center" valign="top">&nbsp;</td>
                                <td align="center" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="20%"><?php echo $campos[1];?></td>
                                <td align="left">
                                     <?php echo $valores[1];?>
                                </td>
                                <td>&nbsp;</td>
                                <td align="center" valign="top">&nbsp;</td>
                                <td align="center" valign="top">&nbsp;</td>
                                <td align="center" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="6"><div align="center"><hr width="100%"></div></td>
                            </tr>
                        </table>
                    </div>
                    <div id="divPrincipal">
                        <table class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">
                            <tr STYLE="display: NONE;">
                                <td width="20%"><?php echo $campos[2];?></td>
                                <td align="left">
                                     <?php echo $valores[2];?>
                                </td>
                            </tr>
                            <tr STYLE="display: NONE;">
                                <td colspan="6"><div align="center"><hr width="100%"></div></td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>PRECIOS DE LOS ARTÍCULOS</b></td>
                            </tr>
                            <tr>
                                <td width="20%"><?php echo $campos[3];?></td>
                                <td align="left">
                                     <?php echo $valores[3];?>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%"><?php echo $campos[4];?></td>
                                <td align="left">
                                     <?php echo $valores[4];?>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%"><?php echo $campos[5];?></td>
                                <td align="left">
                                     <?php echo $valores[5];?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><div align="center"><hr width="100%"></div></td>
                            </tr>
                        </table>
                    </div>
                    <div id="divPrincipal_c1">
                        <table class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">
                            <tr>
                                <td colspan="2"><b>COMPARTIR</b> (la configuracion se encuentra en el archivo:constant.php)</td>
                            </tr>
                            <tr>
                                <td width="20%">CLIENTES</td>
                                <td align="left">
                                    <?php if($cliente == "1"){ ?>
                                        <input type="checkbox" name="cliente_com" id="cliente_com" checked="checked" disabled='disabled'/>
                                    <?php }else{ ?>
                                        <input type="checkbox" name="cliente_com" id="cliente_com" disabled='disabled'	/>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">PROVEEDORES</td>
                                <td align="left">
                                    <?php if($proveedor == "1"){ ?>
                                        <input type="checkbox" name="proveedor_com" id="proveedor_com" checked="checked" disabled='disabled'/>
                                    <?php }else{ ?>
                                        <input type="checkbox" name="proveedor_com" id="proveedor_com" 	disabled='disabled'/>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">PRODUCTOS</td>
                                <td align="left">
                                    <?php if($producto == "1"){ ?>
                                        <input type="checkbox" name="producto_com" id="producto_com" checked="checked" disabled='disabled'/>
                                    <?php }else{ ?>
                                        <input type="checkbox" name="producto_com" id="producto_com" 	disabled='disabled'/>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">FAMILIAS</td>
                                <td align="left">
                                    <?php if($familia == "1"){ ?>
                                        <input type="checkbox" name="familia_com" id="familia_com" checked="checked" disabled='disabled' />
                                    <?php }else{ ?>
                                        <input type="checkbox" name="familia_com" id="familia_com" 	disabled='disabled'/>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><div align="center"><hr width="100%"></div></td>
                            </tr>
                        </table>
                    </div>
                    <div id="divSecundario">
                        <table class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">
                            <tr>
                                <td colspan="6"><b >SERIES Y NÚMEROS ACTUALES DE LOS DOCUMETOS</b></td>
                            </tr>
                            <tr>
                                <td><div align="left">Orden de Pedido</div></td>
                                <td><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="orden_pedido_serie" id="orden_pedido_serie" value="<?php echo $documentos['orden_pedido_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="orden_pedido" id="orden_pedido" value="<?php echo $documentos['orden_pedido'];?>">
                                </div></td>
                                <td align="left" valign="top"><div align="left">Guia de Ingreso</div></td>
                                <td align="left" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="guia_ingreso_serie" id="guia_ingreso_serie" value="<?php echo $documentos['guiain_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="guia_ingreso" id="guia_ingreso" value="<?php echo $documentos['guiain'];?>">
                                </div></td>
                                <td><div align="left">Boleta</div></td>
                                <td align="center" valign="left"><div align="left">
                                    <input type="text" size="1" maxlength="4" class="cajaGeneral" name="boleta_serie" id="boleta_serie" value="<?php echo $documentos['boleta_serie'];?>">
                                    <input type="text" size="7" maxlength="10" class="cajaGeneral" name="boleta" id="boleta" value="<?php echo $documentos['boleta'];?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td ><div align="left">Cotizaci&oacute;n</div></td>
                                <td><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="cotizacion_serie" id="cotizacion_serie" value="<?php echo $documentos['cotizacion_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="cotizacion" id="cotizacion" value="<?php echo $documentos['cotizacion'];?>">
                                </div></td>
                                <td align="left" valign="top"><div align="left">Guia de Salida</div></td>
                                <td align="left" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="guia_salida_serie" id="guia_salida_serie" value="<?php echo $documentos['guiasa_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="guia_salida" id="guia_salida" value="<?php echo $documentos['guiasa'];?>">
                                </div></td>
                                <td><div align="left">Guia de remisi&oacute;n</div></td>
                                <td align="center" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="4" name="guia_remision_serie" id="guia_remision_serie" value="<?php echo $documentos['guiarem_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="guia_remision" id="guia_remision" value="<?php echo $documentos['guiarem'];?>">
                                </div></td>
                            </tr>
                            <tr>
                                <td><div align="left">Orden de Compra</div></td>
                                <td><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="orden_compra_serie" id="orden_compra_serie" maxlength="11"  value="<?php echo $documentos['ocompra_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="orden_compra" id="orden_compra" maxlength="11" onBlur="obtener_proveedor();" value="<?php echo $documentos['ocompra'];?>">
                                </div></td>
                                <td align="left" valign="top"><div align="left">Vale de salida</div></td>
                                <td align="left" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="vale_salida_serie" id="vale_salida_serie" value="<?php echo $documentos['valesa_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="vale_salida" id="vale_salida" value="<?php echo $documentos['valesa'];?>">
                                </div></td>
                                <td align="left" valign="top"><div align="left">Nota de cr&eacute;dito</div></td>
                                <td align="left" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="4" name="nota_credito_serie" id="nota_credito_serie" value="<?php echo $documentos['notacred_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="nota_credito" id="nota_credito" value="<?php echo $documentos['notacred'];?>">
                                </div></td>
                            </tr>
                            <tr>
                                <td><div align="left">Orden de Servicio</div></td>
                                <td><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="orden_servicio_serie" id="orden_servicio_serie" maxlength="11"  value="<?php echo $documentos['oservicio_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="orden_servicio" id="orden_servicio" maxlength="11" onBlur="obtener_proveedor();" value="<?php echo $documentos['oservicio'];?>">
                                </div></td>
                                <td><div align="left">Factura</div></td>
                                <td align="center" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="4" name="factura_serie" id="factura_serie" value="<?php echo $documentos['factura_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="factura" id="factura" value="<?php echo $documentos['factura'];?>">
                                </div></td>
                                <td align="left" valign="top"><div align="left">Nota de d&eacute;bito</div></td>
                                <td align="left" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="4" name="nota_debito_serie" id="nota_debito_serie" value="<?php echo $documentos['notadeb_serie'];?>"> 
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="nota_debito" id="nota_debito" value="<?php echo $documentos['notadeb'];?>">
                                </div></td>
                            </tr>
                            <tr>

                                <td align="left" valign="top"><div align="left">Presupuesto</div></td>
                                <td align="left" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="presupuesto_serie" id="presupuesto_serie" value="<?php echo $documentos['presupuesto_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="presupuesto" id="presupuesto" value="<?php echo $documentos['presupuesto'];?>">
                                </div>
                                </td>

                                <td><div align="left">Comprobante general</div></td>
                                <td align="center" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="4" name="comprobante_general_serie" id="comprobante_general_serie" value="<?php echo $documentos['compgene_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="comprobante_general" id="comprobante_general" value="<?php echo $documentos['compgene'];?>">
                                </div></td>
                               <td><div align="left">Importacion</div></td>
                                <td align="center" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="importacion_serie" id="importacion_serie" value="<?php echo $documentos['importacion_serie'];?>">

                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="importacion" id="importacion" value="<?php echo $documentos['importacion'];?>">
                                </div></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top"><div align="left">Inventario</div></td>
                                <td align="left" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="orden_compra" id="inventario_serie" value="<?php echo $documentos['inventario_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="inventario" id="inventario" value="<?php echo $documentos['inventario'];?>">
                                </div></td>
                                <td align="left" valign="top"><div align="left">Orden de venta</div></td>
                                <td align="left" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="orden_venta" id="ordenventa_serie" value="<?php echo $documentos['ordenventa_serie'];?>">
                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="ordenventa" id="ordenventa" value="<?php echo $documentos['ordenventa'];?>">
                                </div></td>
                                <td align="left" valign="top"><div align="left">Cuentas por Cobrar</div></td>
                                <td align="left" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="cobrar_serie" id="cobrar_serie" value="<?php echo $documentos['cobrar_serie'];?>">

                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="cobrar_numero" id="cobrar_numero" value="<?php echo $documentos['cobrar_numero'];?>">
                                </div></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top"><div align="left">Cuentas por Pagar</div></td>
                                <td align="left" valign="top"><div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="3" name="pagar_serie" id="pagar_serie" value="<?php echo $documentos['pagar_serie'];?>">

                                    <input type="text" class="cajaGeneral" size="7" maxlength="10" name="pagar_numero" id="pagar_numero" value="<?php echo $documentos['pagar_numero'];?>">
                                </div></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="center" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                            </tr>
                        </table>                    
                    </div>	                
                    <div>
                        <table width="98%">
                            <tr>
                                <td valign="top" colspan="2" style="border-top: solid 1px;"></td>
                            </tr>
                            <tr>
                                <td><b>MOVIMIENTO DE STOCK</b></td>
                            </tr>
                            <tr>
                                <td width="20%" >
                                    <div align="left"><?php echo $campos[6]; ?></div>
                                </td>
                                <td align="left">
                                    <?php echo $valores[6]; ?>
                                </td>
                            </tr>
                            <tr>
                                <td> 
                                    <div align="left"><?php echo $campos[7]; ?></div>
                                </td>
                                <td>
                                    <?php echo $valores[7]; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table width="98%">
                            <tr>
                                <td valign="top" colspan="2" style="border-top: solid 1px;"></td>
                            </tr>
                            <tr>
                                <td><b>INVENTARIO INICIAL</b></td>
                            </tr>
                            <tr>
                                <td width="20%" >
                                    <div align="left"><?php echo $campos[8]; ?></div>
                                </td>
                                <td align="left">
                                    <?php echo $valores[8]; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="text-align:center">
                        <a href="javascript:;" id="imgGuardarConfiguracion"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton"></a>
                        <a href="javascript:;" id="imgLimpiarConfiguracion"><img src="<?php echo base_url();?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton"></a>
                        <a href="javascript:;" id="imgCancelarConfiguracion"><img src="<?php echo base_url();?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton"></a>
                        <?php echo $oculto;?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>