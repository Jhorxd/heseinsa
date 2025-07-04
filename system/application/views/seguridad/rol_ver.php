<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js?=<?=JS;?>"></script>		
<script type="text/javascript" src="<?php echo base_url();?>js/maestros/rol.js?=<?=JS;?>"></script>
<?php
$CI = get_instance();
$this->load->model('seguridad/rol_model');
$menus_base=$CI->rol_model->obtener_rol_permiso();
?>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
        <div id="tituloForm" class="header"><?php echo $titulo;?></div>
        <div id="frmBusqueda">
            <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
               <tr>
                <td width="15%"><strong>Codigo :</strong></td>
                <td width="85%" colspan="2"><?php echo $datos_rol[0]->ROL_Codigo;?></td>
                <?php echo $oculto;?>
               </tr>
                <tr>
                <td width="15%"><strong>ROL :</strong></td>
                <td width="85%" colspan="2"><?php echo $datos_rol[0]->ROL_Descripcion;?></td>
                <?php echo $oculto;?>
               </tr>
               <tr>
                   <td>
          <table>
         <?php
         foreach($menus_base as $menu_base){
                   $enlaces = $menu_base->submenus;
                    ?>
                    <tr><td width="300"><?php
                     $menu=$menu_base->MENU_Codigo;
                     if(isset($codigo)){
                          $ROL_menu=$this->permiso_model->busca_permiso($codigo, $menu);
                        if(count($ROL_menu)>0) {
                             echo $text = ($menu_base->MENU_Url!='')?'<strong>'.$menu_base->MENU_Descripcion.'</strong>' : '<strong>'.$menu_base->MENU_Descripcion.'</strong>';
                         }else{
                             echo $text = ($menu_base->MENU_Url!='')?'<strong>'.$menu_base->MENU_Descripcion.'</strong>' : '<strong>'.$menu_base->MENU_Descripcion.'</strong>';
                         }
                     }else{
                          echo $text = ($menu_base->MENU_Url!='')?'<strong>'.$menu_base->MENU_Descripcion.'</strong>' : '<strong>'.$menu_base->MENU_Descripcion.'</strong>';
                     }
                    ?>
                    <?php
                    if(count($enlaces)){
                        ?>
                       <table>
                        <?php
                        foreach($enlaces as $enlace){
                            $subtext='';
                            $subtext2='';
                            $checked='';
                            $subtext=$enlace->MENU_Descripcion;
                            $subtext2=$enlace->MENU_Codigo;
              if(isset($codigo)){
               $menu=$menu_base->MENU_Codigo;
               $ROL_Codigo=$this->permiso_model->busca_permiso($codigo, $subtext2);
                     if(count($ROL_Codigo)>0){
                     echo '<tr><td width="300">&nbsp;&nbsp;&nbsp;'.$subtext.'</tr></td>';
                        }
                     else{
                        echo '<tr><td width="300">&nbsp;&nbsp;&nbsp;'.$subtext.'</tr></td>';
                        }
                    }else{
                        echo '<tr><td width="300">&nbsp;&nbsp;&nbsp;'.$subtext.'</tr></td>';
                        }
                    }
                  ?>
                </table>
                   <?php
                       }
                    ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
                   </td>
               </tr>
               
            </table>
        </div>
        <div id="botonBusqueda">
            <a href="#" onclick="atras_rol();"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" border="1"></a>
        </div>
    </div>
  </div>
</div>