<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/almacen/almacen.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js?=<?=JS;?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css?=<?=CSS;?>" media="screen" />
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo;?></div>
            <div id="frmBusqueda" >
                <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                    <tr>
						<td>Almacen</td>
						<td>
							<?php echo $cboAlmacen; ?>
							<a href="javascript:;" onclick="reporte_xls();" target="_self"><img src="<?php echo base_url();?>images/botonreporteexcel.png?=<?=IMG;?>" width="69" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
                        <td></td>
                       </tr>
                </table>
            </div>
            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        </div>
    </div>
</div>