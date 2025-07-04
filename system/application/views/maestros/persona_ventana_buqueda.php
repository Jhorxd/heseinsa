<html>
<head>
   <title><?php echo TITULO;?></title>
   <link href="<?php echo base_url();?>css/estilos.css?=<?=CSS;?>" type="text/css" rel="stylesheet">
   <link rel="stylesheet" href="<?php echo base_url();?>css/theme.css?=<?=CSS;?>" type="text/css">
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js?=<?=JS;?>"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/funciones.js?=<?=JS;?>"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/comercialjs.js?=<?=JS;?>"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js?=<?=JS;?>"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js?=<?=JS;?>"></script>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <script type="text/javascript">
        function seleccionar_persona(codigo,ruc,razon_social){
             window.opener.seleccionar_persona(codigo,ruc,razon_social);
             window.close();
        }
   </script>
</head>
<body onload="document.getElementById('nombres').focus();">
<div align="center">
<form name="form_busqueda" id="form_busqueda" method="post" action="" >
    <div id="frmBusqueda" style="width:95%">
        <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0">
           <tr class="cabeceraTabla" height="25px">
                <td align="center" colspan="5">PERSONA</td>
           </tr>
            <tr height="35px">
                <td width="25%">RUC </td>
                <td width="68%"><input id="ruc" type="text" class="cajaPequena" NAME="ruc" maxlength="11" value="" onkeypress="return numbersonly(this,event)">
                <td width="5%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
                <td width="6%" align="right"></td>
            </tr>
            <tr height="25px">
                <td>Nombre o Raz&oacute;n Social</td>
                <td><input id="nombres" name="nombres" type="text" class="cajaGrande" maxlength="45" value=""></td>
                <td>&nbsp;</td>
                <td><a href="#" ><img id="buscarPersona" src="<?php echo base_url();?>images/botonbuscar.jpg?=<?=IMG;?>" border="1" title="Buscar Persona"></a></td>
            </tr>
        </table>
   </div>
    <div id="lineaResultado" style="width:95%; margin-top:10px">
        <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
            <tr>
                <td width="50%" align="left">N de personas encontrados:&nbsp;<?php echo $registros;?></td>
                <td width="50%" align="right">&nbsp;</td>
            </tr>
        </table>
    </div>
   <div id="frmResultado"  style="width:95%">
  <table class="fuente8" width="100%" id="tabla_resultado" name="tabla_resultado"  align="center" border="0" cellpadding="4">
       <tr class="cabeceraTabla">
			<td width="5%"><div align="center"><b>Item</b></div></td>
			<td width="17%"><div align="center"><b>Ruc</b></div></td>
            <td width="51%"><div align="center"><b>Nombre o Raz&oacute;n Social</b></div></td>
			<td width="20%"><div align="center"><b>Tipo persona</b></div></td>
			<td width="7%"><div align="center"></div></td>
       </tr>
       <?php
       $indice = 0;
       foreach($lista as $valor){
            $classfila          = $indice%2==0?"itemImparTabla":"itemParTabla";
            $codigo             = $valor[5];
            $ruc                    =  $valor[1];
            $razon_social = $valor[2];
       ?>
         <tr class="<?php echo $classfila;?>">
            <td><div align="center"><?php echo $valor[0];?></div></td>
           <td><div align="center"><?php echo $valor[1];?></div></td>
           <td><div align="left"><?php echo $valor[2];?></div></td>
           <td><div align="center"><?php echo $valor[3];?></div></td>
           <td align="center"><div align="center"><a href="#" onclick="seleccionar_proveedor(<?php echo $codigo;?>,'<?php echo $ruc;?>','<?php echo $razon_social;?>');"><img src="<?php echo base_url();?>images/convertir.png?=<?=IMG;?>" border="0" title="Seleccionar"></a></div></td>
       </tr>
       <?php
       $indice++;
       }
       ?>
</table>
</div>
<div style="margin-top: 15px;"><?php echo $paginacion;?></div>
<table width="100%" border="0">
  <tr>
    <td>
       <div align="center"><a href="#" onclick="window.close();"><img src="<?php echo base_url();?>images/botoncerrar.jpg?=<?=IMG;?>" width="70" height="22"  border="1" ></a></div>
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>