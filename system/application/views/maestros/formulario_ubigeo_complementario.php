<html>
<head>
	<title><?php echo TITULO;?></title>
	<script>

	var cursor;
        if (document.all) {
        // Está utilizando EXPLORER
        cursor='hand';
        } else {
        // Está utilizando MOZILLA/NETSCAPE
        cursor='pointer';
        }
	function cargar_ubigeo(){
		seccion      = $("#seccion").val();
		nro_fila     = $("#nro_fila").val();
		departamento = $("#cboDepartamento").val();
		provincia    = $("#cboProvincia").val();
		distrito     = $("#cboDistrito").val();
		index        = $("#cboDistrito").attr("selectedIndex");
		valor='';
                if($("#cboDepartamento").val()!='00')
                    valor = $("#cboDepartamento option:selected").text();
                if($("#cboProvincia").val()!='00')
                    valor = $("#cboProvincia option:selected").text();
                if($("#cboDistrito").val()!='00')
                    valor = $("#cboDistrito option:selected").text();
		window.opener.cargar_ubigeo_complementario(departamento,provincia,distrito,valor,seccion,nro_fila);
		window.close();
	}
	</script>
	<link rel="stylesheet" href="<?php echo base_url();?>css/estilos.css?=<?=CSS;?>" type="text/css"/>	
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js?=<?=JS;?>"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/compras/proveedor.js?=<?=JS;?>"></script>
	</head>
<body style="margin: 10px; background-color:#f5f5f5;">
<form name="form1" id="form1" method="post" action="">
	<span class="fuente8">Departamento</span>
	<table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
	  <tr>
		<td>
			<div id="divUbigeo">
				<select id='cboDepartamento' name='cboDepartamento' class='comboMedio' onchange='cargar_provincia(this);'><?php echo $cbo_dpto;?></select>&nbsp;&nbsp;
				Provincia&nbsp;	&nbsp;<select id='cboProvincia' name='cboProvincia' class='comboMedio' onchange='cargar_distrito(this);'><?php echo $cbo_prov;?></select>&nbsp;&nbsp;			
				Distrito&nbsp;	&nbsp;<select id='cboDistrito' name='cboDistrito' class='comboMedio'><?php echo $cbo_dist;?></select>
			</div>
		</td>
	  </tr>	  
	</table>
	<br>
	<table width="100%" border="0">
	  <tr>
		<td>
			<div align="center">
				<a href="#" onclick="cargar_ubigeo();"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="70" height="22" border="1" onMouseOver="style.cursor=cursor"></a>&nbsp;
				<a href="#" onClick="window.close()"><img src="<?php echo base_url();?>images/botoncancelar.jpg?=<?=IMG;?>" width="70" height="22" border="1" onMouseOver="style.cursor=cursor"></a>
				<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
				<input type="hidden" name="seccion" id="seccion" value="<?php echo $seccion;?>">
				<input type="hidden" name="nro_fila" id="nro_fila" value="<?php echo $nro_fila;?>">
			</div>
		</td>
	  </tr>
	</table>
</form>
</body>
</html>
