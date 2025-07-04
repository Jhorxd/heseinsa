<html>
<head>
   <title><?php echo TITULO;?></title>
   <link href="<?php echo base_url();?>css/estilos.css?=<?=CSS;?>" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js?=<?=JS;?>"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/funciones.js?=<?=JS;?>"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/almacen/producto.js?=<?=JS;?>"></script>

   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   
</head>
<body>
<div align="center">  
   <?php echo $form_open;?>
    <div id="frmBusqueda" style="width:80%">
        
        
        
    <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>					
        <tr class="cabeceraTabla" height="25px">
            <td align="center" colspan="3">IMPORTAR DOCUMENTOS</td>
        </tr>
       </table>
    </div>
    <div id="frmBusqueda" style="width:80%;">
    <table class="fuente8" width="100%" id="tabla_resultado" name="tabla_resultado"  align="center" cellspacing="1" cellpadding="3" border="0" >
       
        <tr>
               <td width="35%">Importar Documento:</td>
               <td width="65%"><?php echo $documento;?></td>
           </tr>
         
    </table>
</div>
    <br />
    <div id="divBotones" style="text-align: center; float:left;margin-left: auto;margin-right: auto;width: 98%;margin-top:15px;">
        <img id="loading" src="<?php echo base_url();?>images/loading.gif?=<?=IMG;?>"  style="visibility: hidden" />
      
        <a href="javascript:;" id="GuardarCarga"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton"></a>
        <a href="javascript:;" id="imgCancelarcarga"><img src="<?php echo base_url();?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton"></a>
        <?php echo $form_hidden;?>
    </div>
    <?php echo $form_close;?>
</body>
</html>
