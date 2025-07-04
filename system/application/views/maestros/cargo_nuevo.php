<script type="text/javascript" src="<?php echo base_url();?>js/maestros/cargo.js?=<?=JS;?>"></script>					
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo;?></div>
            <div id="frmBusqueda">
                <?php echo validation_errors("<div class='error'>",'</div>');?>
                <?php echo $form_open;?>
                    <div id="datosGenerales">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                            <?php
                            foreach($campos as $indice=>$valor){
                            ?>
                                <tr>
                                  <td width="16%"><?php echo $campos[$indice];?></td>
                                  <td colspan="3"><?php echo $valores[$indice]?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div style="margin-top:20px; text-align: center">
                        <a href="#" id="grabarCargo"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" ></a>
                        <a href="#" id="limpiarCargo"><img src="<?php echo base_url();?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton" ></a>
                        <a href="#" id="cancelarCargo"><img src="<?php echo base_url();?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" ></a>
                        <?php echo $oculto?>
                    </div>
                <?php echo $form_close;?>
            </div>
        </div>
    </div>
</div>