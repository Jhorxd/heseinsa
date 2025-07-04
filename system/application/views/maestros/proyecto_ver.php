<?php
$nombre = $this->session->userdata('nombre');
$persona        = $this->session->userdata('persona');
$usuario        = $this->session->userdata('usuario');
$url            = base_url()."index.php";
if(empty($persona)) header("location:$url");
?>
<html>
<head>
	<title><?php echo TITULO;?></title>
	<link href="<?php echo URL_CSS;?>estilos.css?=<?=CSS;?>" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo URL_BASE;?>js/mantenimiento.js?=<?=JS;?>"></script>
	<script type="text/javascript" src="<?php echo URL_BASE;?>js/jquery.metadata.js?=<?=JS;?>"></script>
	<script type="text/javascript" src="<?php echo URL_BASE;?>js/jquery.validate.js?=<?=JS;?>"></script>		
</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php echo $titulo;?></div>
				<div id="frmBusqueda">
					
                    <div id="datosProyecto">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                                <tr>
                                  <td>Nombres</td>
                                  <td>
                                     <?php echo $datos[0]->PROYC_Nombre;?>
                                  </td>                                  
                                </tr>
                                <tr>
                                    <td>Descripcion</td>
                                    <td><?php echo $datos[0]->PROYC_Descripcion;?></td>
                                 
                                  
                                </tr>
                                <tr>
                                    <td>Encargado</td>
                                    <td><?php echo $datos[0]->DIREP_Codigo;?></td>
                                </tr>                              
                                
                        </table>
                        <div id="divBotones" style="text-align: center; float:left;margin-left: auto;margin-right: auto;width: 98%;margin-top:15px;">
				<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
				<a href="#" onclick="atras_proyecto();"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" border="1" onMouseOver="style.cursor=cursor"></a>
			  </div>
                    </div>					   
			  </div>
				
		  </div>
		  </div>
		</div>
	</body>
</html>
