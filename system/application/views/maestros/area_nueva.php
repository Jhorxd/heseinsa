<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js?=<?=JS;?>"></script>		
<script type="text/javascript" src="<?php echo base_url();?>js/maestros/area.js?=<?=JS;?>"></script>			
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo;?></div>
            <div id="frmBusqueda">
                <?php echo validation_errors("<div class='error'>",'</div>');?>
                <form id="<?php echo $formulario;?>" method="post" action="<?php echo base_url();?>index.php/mantenimiento/insertar_cargo">
                <div id="datosGenerales">
                    <table class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">
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
                    <a href="#" id="grabarArea"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" ></a>
                    <a href="#" id="limpiarArea"><img src="<?php echo base_url();?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton" ></a>
                    <a href="#" id="cancelarArea"><img src="<?php echo base_url();?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" ></a>
                    <?php echo $oculto?>
                </div>
            </form>
         </div>
        </div>
    </div>
</div>