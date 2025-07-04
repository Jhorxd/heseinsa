<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js?=<?=JS;?>"></script>		
<script type="text/javascript" src="<?php echo base_url();?>js/maestros/area.js?=<?=JS;?>"></script>		
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
        <div id="tituloForm" class="header"><?php echo $titulo;?></div>
        <div id="frmBusqueda">
            <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
            <tr>
                <td width="15%">C&oacute;digo</td>
                <td width="85%" colspan="2"><?php echo $datos_area[0]->AREAP_Codigo;?></td>
            </tr>
            <tr>
                <td width="15%">Nombre</td>
                <td width="85%" colspan="2"><?php echo $datos_area[0]->AREAC_Descripcion;?></td>
                <?php echo $oculto;?>
            </tr>
            </table>
        </div>
        <div id="botonBusqueda">
            <a href="#" onclick="atras_area();"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" border="1"></a>
        </div>
    </div>
  </div>
</div>