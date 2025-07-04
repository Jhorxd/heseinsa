<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js?=<?=JS;?>"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.min.js?=<?=JS;?>"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>js/almacen/marca.js?=<?=JS;?>"></script>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo;?></div>
            <div id="frmBusqueda">
                <?php echo validation_errors("<div class='error'>",'</div>');?>
                <?php echo $form_open;?>
                    <div id="datosGenerales">
                        <table class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">
                           
                              <tr>
                                <td>Imagen</td>
                               <?php  if($imagen!='') echo '<img style="margin-top:10px;" src="'.base_url().'/images/img_db/'.$imagen.'" alt="'.$imagen.'" width="120" height="120" border="1" />' ?>                   
                                  <td colspan="3"> <input name="imagen" id="imagen" style="font-size:0.9em" type="file" />
                                <!-- inicio articulo 1 -->
             </td>
                              </tr>
                              <tr>
                                <td>Nombre Marca</td>
                                <td colspan="3"><input type="text" name="nombre_marca" id="nombre_marca" value="<?php echo $nombre_marca ?>"></td>
                              </tr>
                              <tr>
                              <td width="13%">Abreviado</td>
                               <td colspan="3"><input type="text" name="codigo_usuario" id="codigo_usuario" value="<?=$codigo_usuario ?>" maxlength="5"></td>
                              </tr>
                           
                        </table>
  </div>
                    <div style="margin-top:20px; text-align: center">
                        <a href="#" id="grabarMarca"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" ></a>
                        <a href="#" id="limpiarMarca"><img src="<?php echo base_url();?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton" ></a>
                        <a href="#" id="cancelarMarca"><img src="<?php echo base_url();?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" ></a>
                        <?php echo $oculto?>
                    </div>
                <?php echo $form_close;?>
            </div>
        </div>
    </div>
</div>