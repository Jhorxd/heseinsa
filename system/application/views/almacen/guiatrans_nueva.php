<script type="text/javascript" src="<?php echo base_url();?>js/almacen/guiatrans.js?=<?=JS;?>"></script>

<input type="hidden" name="codigoguiain" id='codigoguiain' value='<?php echo $codguiain?>'>
<input type="hidden" name="codigoguiasa" id='codigoguiasa' value='<?php echo $codguiasa?>'>
<input type="hidden" name="tipoguia" id='tipoguia' value='<?php echo $tipoguia?>'>
<!-- SE INDICA QUE TIPO DE OPERACION  PARA SABER SI EL PRODUCTO ES CON SERIE -->
<input type="hidden" name="tipo_oper" id='tipo_oper' value='V'>

<?php echo $form_open;?>
<input name="compania" type="hidden" id="compania" value="<?php echo $compania; ?>">
<input name="compania_inicial" type="hidden" id="compania_inicial" value="<?php echo $compania_inicial; ?>">
<input name="moneda" type="hidden" id="moneda" value="1">
<div id="zonaContenido" align="center">
    <div id="tituloForm" class="header"><?php echo $titulo;?></div>
    <div id="frmBusqueda">
        <table class="fuente8" width="100%" cellspacing="0" cellpadding="5" border="0">
            <tr>
                <input type="hidden" name="codigo_guiatrans" id='codigo_guiatrans' value='<?php echo $codigo?>'>
                <td  width="22%" valign="top" >N&uacute;mero
                    <input type="text" name="serie" id="serie" placeholder="" readonly="readonly" value="<?=$serie;?>" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10"/>
                    <input type="text" name="numero" id="numero" placeholder="" value="<?=$numero;?>" readonly="readonly" class="cajaGeneral cajaSoloLectura" size="10" maxlength="10"/>
                </td>
                <td width="25%">Origen *
                    <select name="almacen" id="almacen" class='comboMedio'>
                        <option value="0">::Seleccione::</option>
                        <?php

                        foreach($listar_almacen as $almacen_ori => $value){
                            ?>
                            <option value="<?php echo $value->ALMAP_Codigo; ?>" <?php if($almacen_ori == 0) echo "selected='selected'" ?> ><?php echo $value->ALMAC_Descripcion . ' - ' . $value->EESTABC_Descripcion; ?></option>
                        <?php
                        }

                        ?>
                    </select>
                </td>
                <td width="35%">Destino *
                <?php echo $cboAlmacenDestino;?></td>
                <td width="20%">F.Traslado*
                <?php echo $fecha;?>
                    <img src="<?php echo base_url();?>images/calendario.png?=<?=IMG;?>" name="Calendario2" id="Calendario2" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'" title="Calendario">
                    <script type="text/javascript">
                        Calendar.setup({
                            inputField     :    "fechas",      // id del campo de texto
                            ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                            button         :    "Calendario2"   // el id del botón que lanzará el calendario
                        });
                    </script>
                </td>
            </tr>

        </table>
    </div>
  
    <div id="frmBusqueda" class="box-add-product" style="text-align: right;">
        <a href="#" id="addItems" name="addItems" style="color:#ffffff;" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="limpiar_campos_modal(); ">Agregar Items</a>
    </div>

    <?php $this->load->view('maestros/temporal_subdetalles_second'); ?>

    <div id="frmBusqueda3_5">
        <table width="100%" border="0" align="right" cellpadding=0 cellspacing=0 class="fuente8">
            <tr>
                <td>
                    <table class="fuente8" width="100%" border="0" cellpadding="3" cellspacing="0" >
                        <tr>
                            <td valign="top" width="11%"><b>OBSERVACION</b></td>
                            <td colspan="7"><textarea id="observacion" name="observacion" class="cajaTextArea" style="width:95%" rows="3"><?php echo $observacion;?></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="8" style="display: none"><?=$estado;?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php echo $oculto;?>
        <input type="hidden" class="cajaMinima" name="conforusuario" id="conforusuario" value="" />
        <br/>
        <table width="100%" border="0" align="" cellpadding=0 cellspacing=0 class="fuente8">
            <tr>
                <td>
                    <div style="text-align: center; margin-top: 32px; margin-bottom: 10px" >
                        <img id="loading" src="<?php echo base_url();?>images/loading.gif?=<?=IMG;?>" style="visibility: hidden" />
                        <a href="javascript:;" id="grabarGuiatrans"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" /></a>
                        <a href="javascript:;" id="limpiarGuiatrans" onclick="limpiarCampoDeTexto()"><img src="<?php echo base_url();?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton" /></a>
                        <a href="javascript:;" id="cancelarGuiatrans"><img src="<?php echo base_url();?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" /></a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php
    echo $form_close;
    $this->load->view('maestros/temporal_detalles_second');
?>