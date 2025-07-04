<?php $datos_menu = $this->session->userdata('datos_menu'); ?>

<script type="text/javascript">
	function mostrarMenuIzquierdo(idMenu){
		var arrayMenu = <?=json_encode($menus_base);?>;
		var cantidadMenu = <?=count($menus_base);?>;
		/**ponemos en session id menu seleccionado**/
		ingresarMenuSession(idMenu);
		/****/
		$("#idLiMenuDinamico").html("");
		
		for(x=0;x<cantidadMenu;x++){
			idDefaultd=arrayMenu[x]['MENU_Codigo'];
			if(idDefaultd==idMenu){
				descripcionMenu=arrayMenu[x]['MENU_Descripcion'];
				ArraySubMenu=arrayMenu[x]['submenus'];
				cantidadSub=ArraySubMenu.length;
				idA="#idAMenuPrincipal";
				fila="<a id='idAMenuPrincipal' href='#'>"+descripcionMenu+"<span>"+cantidadSub+"</span></a> ";
				if(cantidadSub>0){
					fila+="<ul>";
						for(j=0;j<cantidadSub;j++){
							codigoMenuSub=ArraySubMenu[j]['MENU_Codigo'];
							descripcionSub=ArraySubMenu[j]['MENU_Descripcion'];
		            		urlSub=ArraySubMenu[j]['MENU_Url'];
		            		estadoSub=ArraySubMenu[j]['MENU_FlagEstado'];
							if(estadoSub==1){
								fila+="<li class='subitem1'><a href='<?php echo base_url();?>index.php/"+urlSub+"'   onclick='ingresarMenuSession("+idMenu+","+codigoMenuSub+")'   >"+descripcionSub+"</a></li>";
							}
						}
					fila+="</ul>";
				}
				
				
				$("#idLiMenuDinamico").html(fila);
				document.getElementById("idLiMenuDinamico").style.display = "block";
				document.getElementById("idLiMenuDinamico").setAttribute("onclick","logicaMenuDinamico('#idAMenuPrincipal');");
				logicaMenuDinamico(idA);
			}
		}
	}

	function ingresarMenuSession(idMenuSeleccionado,idMenusub){
		url = "<?=base_url()?>index.php/index/sessionMenuSeleccion";
		$.post(url, {
                        idMenuSeleccionadoReal: idMenuSeleccionado,
                        idMenusubReal: idMenusub
                    }
                );
	}
	
</script>

<style>
    .icon-img{
        float: left;
        height: 100%;
    }
    .icon-img img{
        height: 20px;
        filter: invert(0.4) sepia(1) brightness(1000%);
    }
    #tip{
        cursor: pointer;
        padding:  10px;
        width: 300px;
		display: block;
        position: fixed;
        top: 10px;
        left: 0px;
        background: #FFF;
        z-index: 10;
        border: 1px solid #CCC;
        border-radius: 4px;
        font-family: Arial;
        font-size: 12px;
    }
    #tip div{
        font-weight: bold;
        padding: 5px;
    }
    #tip ul{
        padding-left: 10px;
        margin: 0;
    }
    #tip ul li{
        margin-bottom: 5px;
    }
</style>

<ul class="nav main">
    <li onclick="mostrarMenuIzquierdo('0','0')" ><a href="<?=site_url('index/inicio');?>"><span class="icon-img"><img src="<?php echo base_url();?>images/inicio.png?=<?=IMG;?>"/></span> &nbsp; Inicio</a></li> <?php
    foreach ($menus_base as $menu_base) {
    	$idDefaultd = $menu_base->MENU_Codigo;
        $iconMenu = ($menu_base->MENU_Icon != '') ? "<span class='icon-img'><img src='data:;base64,$menu_base->MENU_Icon'/></span>" : "";
        $descripcionMenu = ($menu_base->MENU_Descripcion != '') ? "<span style='float:right'>$menu_base->MENU_Descripcion</span>" : "";

        $text = ($menu_base->MENU_Url != '') ? "<a id='idAMenuSuperiorP_$idDefaultd' href='".site_url($menu_base->MENU_Url)."'>$menu_base->MENU_Descripcion</a>" : "<a id='idAMenuSuperiorP_$idDefaultd' href='javascript:;' onclick='mostrarMenuIzquierdo($idDefaultd)'>$iconMenu &nbsp; $descripcionMenu</a>";
        $enlaces = $menu_base->submenus; ?>
        <li><?=utf8_decode($text);?></li> <?php
    }
    
    $imgSalir = "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"; ?>
    <li><a href="<?=site_url('index/salir_sistema');?>"><span class='icon-img'><img src='data:;base64,<?=$imgSalir;?>'/></span> &nbsp; Salir</a></li>
</ul>

<script>
    $(document).ready(function(){
        $('#tip').click(function(){
            $(this).hide();   
        })
    })
</script>
<input type="hidden" name="base_url" id="base_url" value="<?=base_url();?>">