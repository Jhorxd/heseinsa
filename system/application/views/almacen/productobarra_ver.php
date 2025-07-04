<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/producto.js"></script>


<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" style="height: 10%;background-color: skyblue;border: 1px solid !important;" class="header"><span><?php echo $titulo; ?></span></div>
            <div id="frmBusqueda">
                <?php echo validation_errors("<div class='error'>", '</div>'); ?>

                <div id="nuevoRegistro"
                     style="display:none;float:right;width:150px;height:20px;border:0px solid #000;margin-top:7px;"><a
                        href="#">Nuevo</a></div>
                <br><br>
                <div id="divPrincipales">
                    <div id="generator">
                        <div id="config">
                            <div class="config">
                                <br>
                                <div id="submit">
                                    <input name="codigo_producto" id="codigo_producto" type="hidden"
                                          value="<?php echo $cod_producto; ?>">
                                </div>
                            </div>
                            <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" rightmargin="0">
                            <div id="areaImprimir">
                                <?php
                                $tipo="code128"; //code39 //code25 //code128 //codabar
                            $size="170";
                            $width="230px";
                            $height="170px";

                            $cod=str_replace('#', '', $cod_producto);

                              $img_cb=base_url()."/system/libraries/barcode.php?codetype=".$tipo."&size=".$size."&text=".$cod;
                                ?>
                                <table>
                                    <tr>
                                        <td align="center"><label align="justify"><?php echo $nombre_producto; ?></label></td>
                                        <td align="center"><label align="justify"><?php echo $nombre_producto; ?></label></td>
                                        <td align="center"><label align="justify"><?php echo $nombre_producto; ?></label></td>
                                    </tr>
                                    <tr>
                                        <td><img alt="#<?php echo $cod_producto; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo $img_cb; ?>" /></td>
                                        <td><img alt="#<?php echo $cod_producto; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo $img_cb; ?>" /></td>
                                        <td><img alt="#<?php echo $cod_producto; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo $img_cb; ?>" /></td>

                                    </tr>

                                </table>



                            </div>


                            </body>

                        </div>


                    </div>
                    <div id="botonBusqueda">
                        <a href="#">
                            <img onclick="printDiv('areaImprimir')"; src="<?php echo base_url(); ?>images/botonimprimir.jpg" width="85" height="22"
                                 border="1">
                        </a>
                        <a href="#" id="cancelarCodigoBarra"><img
                                src="<?php echo base_url(); ?>images/botonaceptar.jpg" width="85" height="22"
                                border="1"></a>
                        <?php echo $oculto; ?>
                        <br/><br/><br/>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
        function printDiv(nombreDiv) {
             var contenido= document.getElementById(nombreDiv).innerHTML;
             var contenidoOriginal= document.body.innerHTML;

             document.body.innerHTML = contenido;

             window.print();

             document.body.innerHTML = contenidoOriginal;
        }
        </script>
