<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js?=<?=JS;?>"></script>	
<script type="text/javascript" src="<?php echo base_url();?>js/seguridad/usuario.js?=<?=JS;?>"></script>		

<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo;?></div>
            <div id="frmBusqueda">
                <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                    <tr>
                        <td width="15%">NOMBRES</td>
                        <td width="85%" colspan="2"><?php echo $datos_persona->PERSC_Nombre;?></td>
                    </tr>
                    <tr>
                        <td width="15%">APELLIDO PATERNO</td>
                        <td width="85%" colspan="2"><?php echo $datos_persona->PERSC_ApellidoPaterno;?></td>
                        <?php echo $oculto;?>
                    </tr>
                    <tr>
                        <td width="15%">APELLIDO MATERNO</td>
                        <td width="85%" colspan="2"><?php echo $datos_persona->PERSC_ApellidoMaterno;?></td>
                        <?php echo $oculto;?>
                    </tr>
                    <tr>
                        <td width="15%">USUARIO</td>
                        <td width="85%" colspan="2"><?php echo $datos_persona->USUA_usuario;?></td>
                        <?php echo $oculto;?>
                    </tr>
                    <tr>
                        <td width="15%">ESTABLECIMIENTO  / ROL :</td>
                        <td width="85%" colspan="2"><?php //echo  $datos_rol[0]->ROL_Descripcion;?></td>
                         <?php
                                            if(count($lista)>0){
                                                foreach($lista as $indice=>$valor){
                                                    $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                                                    ?>
                                                    <tr class="<?php echo $class;?>">
                                                        <td><div align="left"><?php echo $valor[0]." : ";?></div></td>
                                                        <td><div align="left"><?php echo $valor[1];?></div></td>
                                                     
                                                    </tr>
                                                    <?php
                                                }

                                            }
                                            ?>
                        <?php echo $oculto;?>
                    </tr>
                    
                </table>
            </div>
        <div id="botonBusqueda">
        <a href="#" onclick="atras_usuario();"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" border="1"></a>
      </div>
    </div>
</div>
</div>