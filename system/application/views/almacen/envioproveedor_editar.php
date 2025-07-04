<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js?=<?=JS;?>"></script>		
<script type="text/javascript" src="<?php echo base_url();?>js/almacen/envioproveedor.js?=<?=JS;?>"></script>		
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
        <div id="tituloForm" class="header"><?php echo $titulo;?></div>
        <div id="frmBusqueda">
            <?php echo validation_errors("<div class='error'>",'</div>');?>
            <?php echo $form_open;?>
                <table width="250" cellspacing="0" cellpadding="6" border="0">
                    <tr>
                        <td>Descripci&oacute;n : </td>
                        <td><?php echo $campo;?></td>
                    </tr>
                    <tr>
                        <td><img id="guardar" src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" border="1"></td>
                        <td><img id="cancelar" src="<?php echo base_url();?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" border="1"></td>
                    </tr>
                </table>
                <?php echo $oculto; ?>
                <input type="hidden" name="cod" id="cod" value="<?php echo $cod; ?>" >
            <?php echo $form_close;?>
            <br/>
        </div>
    </div>
  </div>
</div>