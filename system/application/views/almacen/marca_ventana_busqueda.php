<html>
<head>
   <title><?php echo TITULO;?></title>
   <link href="<?php echo base_url();?>css/estilos.css?=<?=CSS;?>" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js?=<?=JS;?>"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/funciones.js?=<?=JS;?>"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/almacen/marca_popup.js?=<?=JS;?>"></script>   
   <script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js?=<?=JS;?>"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js?=<?=JS;?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css?=<?=CSS;?>" media="screen" />
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <script type="text/javascript">
       $(document).ready(function(){
        $("a#nuevoMarca").fancybox({
                'width'          : 650,
                'height'         : 500,
                'autoScale'	 : false,
                'transitionIn'   : 'none',
                'transitionOut'  : 'none',
                'showCloseButton': false,
                'modal'          : true,
                'type'	         : 'iframe'
        });
		
		$("a#editar_marca_popup").fancybox({
                'width'          : 650,
                'height'         : 500,
                'autoScale'	 : false,
                'transitionIn'   : 'none',
                'transitionOut'  : 'none',
                'showCloseButton': false,
                'modal'          : true,
                'type'	         : 'iframe'
        });
     });
   </script>
</head>
<body onload="document.getElementById('txtNombre').focus();">
<div align="center">
<form name="form_busqueda" id="form_busqueda" method="post" action="<?php echo site_url('almacen/marca/ventana_busqueda_marca'); ?>" >
    <div id="frmBusqueda" style="width:95%">
    <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>					
        <tr class="cabeceraTabla" height="25px">
            <td align="center" colspan="3">MarcaS</td>
        </tr>
        <tr>
            <td>Nombre</td>
            <td colspan="2"><input id="txtNombre" name="txtNombre" type="text" class="cajaGrande" maxlength="100" value="<?php echo $nombre; ?>"></td>
        </tr>
        <tr>
          <td></td>
          <td><input id="txtFamilia" type="hidden" class="cajaGrande" NAME="txtFamilia" maxlength="100" value=""></td>
          <td align="right"><a href="javascript:;" id="buscarMarca"><img  src="<?php echo base_url();?>images/botonbuscar.jpg?=<?=IMG;?>" class="imgBoton" /></a>
		  <!--
                           <a href="javascript:;" id="limpiarMarca"><img src="<?php echo base_url();?>images/botonlimpiar.jpg?=<?=IMG;?>" class="imgBoton" /></a>
                           <a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_nuevo_producto" id="nuevoMarca"><img src="<?php echo base_url();?>images/botonnuevoarticulo.jpg?=<?=IMG;?>" class="imgBoton" /></a>
		  -->
                           <a href="javascript:;" id="cerrarMarca"><img src="<?php echo base_url();?>images/botoncerrar.jpg?=<?=IMG;?>" class="imgBoton" /></a>
          </td>
          </tr>
       </table>
    </div>
    <div id="lineaResultado" style="width:95%; margin-top:10px">
        <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
            <tr>
                <td width="50%" align="left">N° de registros encontrados:&nbsp;<?php echo $registros;?></td>
                <td width="50%" align="right">&nbsp;</td>
            </tr>
        </table>
    </div>
    <div id="frmResultado" style="width:95%; height: 400px; overflow: auto; background-color: #f5f5f5">
    <table class="fuente8" width="100%" id="tabla_resultado" name="tabla_resultado"  align="center" border="0" cellpadding="4">
       <tr class="cabeceraTabla">
            <td width="5%"><div align="center"><b>Item</b></div></td>
            <td width="80%"><div align="center"><b>Nombre</b></div></td>
            <td width="1%"><div align="center"></div></td>
        </tr>
       <?php
       $indice = 0;
       foreach($lista as $valor){
            $classfila          = $indice%2==0?"itemImparTabla":"itemParTabla";
       ?>
         <tr class="<?php echo $classfila;?>">
           <td><div align="center"><?php echo $valor[0];?></div></td>
           <td><div align="left"><?php echo $valor[1];?></div></td>
           <td><div align="left"><?php echo $valor[3];?></div></td>
       </tr>
       <?php
       $indice++;
       }
       ?>
</table>
 <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>" />
</div>
</form>
<div style="margin-top:15px" class="fuente8"><?php echo $paginacion;?></div>
</div>
</body>
</html>