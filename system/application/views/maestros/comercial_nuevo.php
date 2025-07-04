	<div id="contenedor_comercial">
		<div id="tituloForm" class="header"><?php echo $titulo;?></div>
            <div id="frmBusqueda">
                <?php echo validation_errors("<div class='error'>",'</div>');?>
                <?php echo $form_open;?>
                    <div id="datosGenerales">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                        <tr>
                        <td width="16%">NOMBRE DEL COMERCIAL</td>
                        <td colspan="3">
                        <input type="text" name="nombre" id="nombre" value="<?=$nombre?>">
                        <input type="hidden" name="codigo" id="codigo" value="<?=$Codigo?>">
                        </td>
                                </tr>
                          
                        </table>
                    </div>
                    <div style="margin-top:20px; text-align: center">
    <a href="#" id="grabarComercial" onclick="insertar_sector_comercial()"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" ></a>
    
    <a href="#" id="limpiarComercial"><img src="<?php echo base_url();?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton" ></a>
    
    <a href="#" id="cancelarComercial" onclick="cancelar_commercial()"><img src="<?php echo base_url();?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" ></a>
                    </div>
                <?php echo $form_close;?>
            </div>
    

	</div>
            