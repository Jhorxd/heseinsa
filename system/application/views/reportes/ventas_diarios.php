<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.metadata.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/maestros/area.js?=<?=JS;?>"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
      
        $("#tipo_doc").change(function(){
            tipo_docu    = $("#tipo_doc").val();
            fecha    = $("#fecha").val();
            
            location.href= "<?php echo base_url() ?>index.php/reportes/ventas/ventasdiario_fecha/"+tipo_docu+"/"+fecha;
        
        });
        $("#imprimirArea").click(function(){
            tipo_docu    = $("#tipo_doc").val();
            fecha    = $("#fecha").val();
           
            var url= "<?php echo base_url() ?>index.php/reportes/ventas/ventas_pdf/"+tipo_docu+"/"+fecha;
            window.open(url,'',"menubars=no,resizable=no;");
        });
       
//         $("#fecha").key(function(){
//             tipo_docu    = $("#tipo_doc").val();
//             fecha    = $("#fecha").val();
   //         location.href= "<?php echo base_url() ?>index.php/reportes/ventas/ventasdiario_fecha/"+tipo_docu+"/"+fecha;
        
//         });




    });
    
    
</script>    
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php //echo $titulo_busqueda;  ?></div>
			<div class="acciones">
			            <div id="botonBusqueda">
			                <input name="fecha" type="text" class="cajaGeneral cajaSoloLectura" id="fecha" value="<?php echo $fecha; ?>" size="10" maxlength="10" readonly="readonly" />
			                                <img height="16" border="0" width="16" id="Calendario1" name="Calendario1" src="<?php echo base_url(); ?>images/calendario.png?=<?=IMG;?>" />
			                                <script type="text/javascript">
			                                Calendar.setup({
			                                    inputField     :    "fecha",      // id del campo de texto
			                                    ifFormat       :    "%Y-%m-%d",       // formaClienteto de la fecha, cuando se escriba en el campo de texto
			                                    button         :    "Calendario1"   // el id del bot¨¨�0…7�0†0n que lanzar¨¨¡ã�0„8 el calendario
			                                });
			                                </script>
			                <select id="tipo_doc" name="tipo_doc">
			                    <option value="">::Seleccione::</option>
			                    <option value="F" <?php if ($tipo_docu == 'F') echo 'selected="selected"'; ?>>Factura</option>
			                    <option value="B" <?php if ($tipo_docu == 'B') echo 'selected="selected"'; ?>>Boletas</option>
			                    <option value="N" <?php if ($tipo_docu == 'N') echo 'selected="selected"'; ?>>Comprobante</option>
			
			                </select>   
			                <ul id="imprimirArea" class="lista_botones"><li id="imprimir">Imprimir</li></ul>
			            </div>
			</div>
			<div id="cabeceraResultado" class="header"><?php echo $titulo_tabla; ?></div>
            <div id="frmResultado">
                <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                    <tr class="cabeceraTabla">
                        <td width="10%">FEHCA DE EMISION</td>
                        <td width="7%">TIPO</td>
                        <td width="5%">SERIE</td>
                        <td width="5%">NUMERO</td>
                        <td width="10%">NOMBRE Y/O RAZON SOCIAL</td>
                        <td width="5%">RUC</td>
                        <td width="5%">VALOR VENTA</td>
                        <td width="5%">I.G.V</td>
                        <td width="5%">TOTAL IMPORTE</td>
                    </tr>
                    <?php
                    if (count($lista) > 0) {
						$valor_ventaS = 0;
                        $valor_igvS = 0;
                        $valor_totalS =0;
								
                        $valor_ventaD = 0;
                        $valor_igvD = 0;
                        $valor_totalD =0;
						
                        foreach ($lista as $indice => $valor) {
                            $fecha = $valor->CPC_Fecha;
                            $tipo = $valor->CPC_TipoDocumento;
                            $serie = $valor->CPC_Serie;
                            $numero = $valor->CPC_Numero;
                            $flag = $valor->CPC_FlagEstado;
                            $tipo_persona = $valor->CLIC_TipoPersona;
							$tipo_Moneda=$valor->MONED_Simbolo;
							$cod_Moneda=$valor->MONED_Codigo;
                            if ($flag == 1) {
                                $venta = $valor->CPC_subtotal;
                                $igv = $valor->CPC_igv;
                                $total = $valor->CPC_total;
								
								
								
								if($cod_Moneda==1){
                                $valor_ventaS += $venta;
                                $valor_igvS += $igv;
                                $valor_totalS +=$total;}
								if($cod_Moneda==2){
                                $valor_ventaD += $venta;
                                $valor_igvD += $igv;
                                $valor_totalD +=$total;}	
								
								
                                if ($tipo_persona == '0') {
                                    $nombre = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                                    $ruc = $valor->PERSC_Ruc;
                                } else {
                                    $nombre = $valor->EMPRC_RazonSocial;
                                    $ruc = $valor->EMPRC_Ruc;
                                }
                            } else {

                                $nombre = "ANULADO";
                                $ruc = "";
                                $venta = "";
                                $igv = "";
                                $total = "";
                            }


                            $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
                            ?>
                            <tr class="<?php echo $class; ?>">
                                <td><div align="center"><?php echo $fecha; ?></div></td>
                                <td><div align="left"><?php if ($tipo == 'F') echo "Factura"; else echo "Boleta" ?></div></td>
                                <td><div align="center"><?php echo $serie; ?></div></td>
                                <td><div align="center"><?php echo $numero; ?></div></td>
                                <td><div align="center"><?php echo $nombre; ?></div></td>
                                <td><div align="center"><?php echo $ruc; ?></div></td>
                                <td><div align="center"><?php if ($venta != NULL) echo $venta; else echo "0.00"; ?></div></td>
                                <td><div align="center"><?php if ($igv != NULL) echo $igv; else echo "0.00"; ?></div></td>
                                <td><div align="center"><?php echo $tipo_Moneda;?>&nbsp;<?php echo $total; ?></div></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="6"></td>

                            <td><div align="center"><?php echo $valor_ventaS; ?></div></td>
                            <td><div align="center"><?php echo $valor_igvS; ?></div></td>
                            <td><div align="center">S/.<?php

	
							echo number_format($valor_totalS, 2); 
							
							
							?></div></td>
							
							
                        </tr>
						 <tr>
                            <td colspan="6"></td>

                            <td><div align="center"><?php echo $valor_ventaD; ?></div></td>
                            <td><div align="center"><?php echo $valor_igvD; ?></div></td>
                            <td><div align="center">US$ <?php echo number_format($valor_totalD, 2); ?></div></td>
							
							
                        </tr>
						
                        <?php
                    }
                    else {
                        ?>
                    </table>

                    <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                        <tbody>
                            <tr>
                                <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                }
                ?>
            </div>
            
<!--            <div style="margin-top: 15px;"><?php echo $paginacion; ?></div>-->
            <input type="hidden" id="iniciopagina" name="iniciopagina">
            <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
<!--            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">-->

        </div>
    </div>
 </div>